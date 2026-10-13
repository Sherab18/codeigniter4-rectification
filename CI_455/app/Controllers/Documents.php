<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\StationModel;
use CodeIgniter\HTTP\ResponseInterface;

class Documents extends BaseController
{
    protected $session;

    public function __construct()
    {
        // 'auth' must be the name of your helper file containing user_right()
        // 'url' is required for url_title()
        helper(['form', 'date', 'database', 'file','text']);
        $this->session = session();
    }

    public function index()
    {
        $docModel = new DocumentModel();
        $stationModel = new StationModel();

        // Safely retrieve session data
        $loginInfo = $this->session->get('login_info');
        if (!$loginInfo) {
            return redirect()->to('login')->with('error', 'Please login to continue.');
        }

        $unitId = $loginInfo['unit_id'];

        // Security Check
        if (!function_exists('user_right')) {
            // Fallback if helper failed to load
            return "System Error: Authorization helper not found.";
        }

        $userRights = user_right($unitId);
        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not an System Administrator!');
        }

        $data = [
            'title'     => 'Station Documents',
            'stations'  => $stationModel->orderBy('station', 'ASC')->findAll(),
            'documents' => $docModel->select('c_station_documents.*, c_stations.station as station_name')
                ->join('c_stations', 'c_stations.id = c_station_documents.station_id', 'left')
                ->orderBy('c_station_documents.created_at', 'DESC')
                ->findAll()
        ];

        return view('admin/Code_form', $data);
    }

    public function upload()
    {
        try {
            $docModel = new DocumentModel();
            $loginInfo = $this->session->get('login_info');

            if (!$loginInfo) throw new \Exception("Session expired.");

            $validationRule = [
                'station_id' => 'required|numeric',
                'unit_name'  => 'required|string|max_length[50]',
                'plant_pdf'  => [
                    'label' => 'PDF File',
                    'rules' => [
                        'uploaded[plant_pdf]',
                        'ext_in[plant_pdf,pdf]',
                        'max_size[plant_pdf,51200]', // 50MB
                    ],
                ],
            ];

            if (!$this->validate($validationRule)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $file = $this->request->getFile('plant_pdf');

            if ($file->isValid() && !$file->hasMoved()) {
                $stationId = $this->request->getPost('station_id');
                $unitName  = $this->request->getPost('unit_name');

                $newName = $stationId . "_" . url_title($unitName, '_', true) . "_" . time() . ".pdf";
                $uploadPath = WRITEPATH . 'uploads/cod_reports/';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $file->move($uploadPath, $newName);

                $saveData = [
                    'station_id'  => $stationId,
                    'unit_name'   => $unitName,
                    'doc_type'    => 'COD',
                    'file_path'   => $newName,
                    'uploaded_by' => $loginInfo['user_id'],
                ];

                $docModel->insert($saveData);
                return redirect()->to(base_url('documents'))->with('success', "Document uploaded successfully.");
            }

            throw new \Exception($file->getErrorString());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function download($id)
    {
        $docModel = new DocumentModel();
        $doc = $docModel->find($id);

        if (!$doc) return redirect()->back()->with('error', 'Record not found.');

        $path = WRITEPATH . 'uploads/cod_reports/' . $doc['file_path'];

        if (file_exists($path)) {
            return $this->response->download($path, null);
        }

        return redirect()->back()->with('error', 'File not found on server.');
    }
}
