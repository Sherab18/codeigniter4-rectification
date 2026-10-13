<?php

namespace App\Controllers;

use App\Libraries\DailyReportParser;
use App\Models\ReportModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class Reports_ks extends BaseController
{
    protected $reportModel;
    protected $session;

    public function __construct()
    {
        helper(['form', 'date', 'database', 'file']);
        $this->reportModel = new ReportModel();
        $this->session = \Config\Services::session();
    }

    public function report_list()
    {
        $searchQuery = $this->request->getVar('search');
        $reportType = $this->request->getVar('report_type');
        $uploadDate = $this->request->getVar('upload_date');

        $builder = $this->reportModel;

        if ($reportType) {
            $builder->like('report_type', $reportType);
        }

        if ($uploadDate) {
            $builder->where('Date(upload_date)', $uploadDate);
        }
        $builder->orderBy('upload_date', 'DESC');


        $reports = $builder->findAll();

        return view('reports/report_list', [
            'reports' => $reports,
            'searchQuery' => $searchQuery,
            'reportType' => $reportType,
            'uploadDate' => $uploadDate,
        ]);
    }

    /** The public page lives in Publicdata::report_public; keep this route working by redirecting. */
    public function report_public()
    {
        return redirect()->to('publicdata/report_public');
    }


    public function report_create()
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'system_operator') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a System Operator!');
        }
        return view('reports/report_add');
    }

    public function report_store()
    {
        $loginInfo = $this->session->get('login_info');

        if (empty($loginInfo) || !is_array($loginInfo)) {
            return redirect()->to('users/login')->with('error', 'Session Expired or Not Logged In.');
        }

        $unitId = $loginInfo['unit_id'];
        $userId = $loginInfo['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'system_operator') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a System Operator!');
        }

        $file = $this->request->getFile('uploaded_file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', $file ? $file->getErrorString() : 'No file uploaded.');
        }

        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'txt'];
        $fileExtension = $file->getClientExtension();
        if (!in_array(strtolower($fileExtension), $allowedTypes)) {
            return redirect()->back()->with('error', 'Invalid file type. Only PDF, JPG, PNG, and TXT files are allowed.');
        }

        if ($file->getSize() > 5242880) {
            return redirect()->back()->with('error', 'File too large. Maximum size is 5MB.');
        }

        $reportType = $this->request->getPost('report_type');
        if (!in_array($reportType, ['daily', 'quarterly', 'annual'], true)) {
            return redirect()->back()->with('error', 'Invalid report type.');
        }

        // Unique, sanitised file name so a second upload never overwrites an earlier one
        $sanitizedName = date('Ymd_His') . '_' . preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $file->getName());
        $uploadPath = 'uploads/reports/';
        $fullPath = WRITEPATH . $uploadPath;

        // Fixed: the directory check previously used a relative path instead of $fullPath
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        if ($file->move($fullPath, $sanitizedName)) {
            $row = [
                'report_type' => $reportType,
                'file_name'   => $sanitizedName,
                'file_path'   => $uploadPath . $sanitizedName,
                'upload_date' => date('Y-m-d H:i:s'),
            ];

            $message = 'Report uploaded successfully.';

            // Auto-extract the dashboard summary from daily reports
            if ($reportType === 'daily') {
                $summary = (new DailyReportParser())->parseFile($fullPath . $sanitizedName);
                if ($summary) {
                    $row['summary_json'] = json_encode($summary, JSON_UNESCAPED_UNICODE);
                    $row['report_date']  = $summary['report_date'] ?? date('Y-m-d');
                    $message .= ' Summary extracted for the dashboard.';
                } else {
                    $message .= ' Note: no summary could be extracted (is it a text-based PDF/TXT?).';
                }
            }

            $this->reportModel->save($row);
            return redirect()->to('reports/report_list')->with('message', $message);
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    public function report_download($id)
    {
        $report = $this->reportModel->find($id);

        if ($report && file_exists(WRITEPATH . $report['file_path'])) {
            return $this->response->download(
                WRITEPATH . $report['file_path'], // Full absolute path
                null, // Keep original filename
                true // Set download headers
            );
        }
        return redirect()->back()->with('error', 'File not found.');
    }

    public function report_preview($id)
    {
        $report = $this->reportModel->find($id);

        if ($report && file_exists(WRITEPATH . $report['file_path'])) {
            $fileExtension = pathinfo($report['file_name'], PATHINFO_EXTENSION);
            $mimeTypes = [
                'pdf' => 'application/pdf',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'txt' => 'text/plain'
            ];

            $mimeType = $mimeTypes[strtolower($fileExtension)] ?? 'application/octet-stream';

            return $this->response
                ->setHeader('Content-Type', $mimeType)
                ->setHeader('Content-Disposition', 'inline; filename="' . $report['file_name'] . '"')
                ->setHeader('X-Content-Type-Options', 'nosniff')
                ->setBody(file_get_contents(WRITEPATH . $report['file_path']));
        }
        return redirect()->back()->with('error', 'File not found.');
    }

    public function report_delete($id)
    {
        $loginInfo = $this->session->get('login_info');

        if (empty($loginInfo) || !is_array($loginInfo)) {
            return redirect()->to('users/login')->with('error', 'Session Expired or Not Logged In.');
        }

        $unitId = $loginInfo['unit_id'];
        $userId = $loginInfo['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'system_operator') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a System Operator!');
        }
        $report = $this->reportModel->find($id);
        if ($report) {
            // Fixed: file_path is relative to WRITEPATH, so the file was never actually deleted before
            $abs = WRITEPATH . $report['file_path'];
            if (is_file($abs)) {
                unlink($abs);
            }
            $this->reportModel->delete($id);
            return redirect()->to('reports/report_list')->with('message', 'Report deleted successfully.');
        }
        return redirect()->back()->with('error', 'Report not found.');
    }

    /*------------------------------------------------------------------------------------------------------------------------
	* REMAP to prevent unauthorized method access
	*/
    public function _remap($method, $param1 = null, $param2 = null)
    {
        if (method_exists($this, $method)) {
            return $this->$method($param1, $param2);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }
    }
}
