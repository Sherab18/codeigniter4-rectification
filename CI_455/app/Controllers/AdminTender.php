<?php

namespace App\Controllers;

use App\Models\TenderModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminTender extends BaseController
{
    protected $tenderModel;
    protected $session;

    public function __construct()
    {
        helper(['form', 'date', 'database', 'file']);
        $this->session = session();
        $this->tenderModel = new TenderModel();
    }
    public function tender()
    {
        $data = [
            'title' => 'Manage Tender Documents',
            'tenders' => $this->tenderModel->getTenders()
        ];
        return view('admin/tenders', $data);
    }

    public function create()
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a Administrator!');
        }
        $data = [
            'title' => 'Add New Tender'
        ];
        return view('admin/tender_form', $data);
    }

    public function save()
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a Administrator!');
        }
        $rules = [
            'title' => 'required|max_length[255]',
            'reference' => 'required|max_length[255]',
            'content' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'reference' => $this->request->getPost('reference'),
            'content' => $this->request->getPost('content'),
            'contact_name' => $this->request->getPost('contact_name'),
            'contact_phone' => $this->request->getPost('contact_phone'),
            'contact_email' => $this->request->getPost('contact_email'),
        ];

        $files = [];
        $uploadedFiles = $this->request->getFiles();

        if ($uploadedFiles['files'] && is_array($uploadedFiles['files'])) {
            foreach ($uploadedFiles['files'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();

                    $uploadPath = WRITEPATH . 'uploads/tenders/';
                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }

                    $file->move($uploadPath, $newName);

                    $files[] = [
                        'name' => $file->getClientName(),
                        'path' => 'writable/uploads/tenders/' . $newName
                    ];
                }
            }
        }

        if (!empty($files)) {
            $data['files'] = json_encode($files);
        }

        if ($this->request->getPost('id')) {
            $tenderId = $this->request->getPost('id');
            $existingTender = $this->tenderModel->find($tenderId);

            if (!$this->request->getPost('delete_files') && $existingTender['files']) {
                $data['files'] = $existingTender['files'];
            }

            $this->tenderModel->update($tenderId, $data);
            session()->setFlashdata('success', 'Tender updated successfully!');
        } else {
            $this->tenderModel->insert($data);
            session()->setFlashdata('success', 'Tender added successfully!');
        }

        return redirect()->to('/admin/tenders');
    }

    public function edit($id)
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a Administrator!');
        }
        $tender = $this->tenderModel->find($id);
        if (!$tender) {
            throw PageNotFoundException::forPageNotFound();
        }

        if ($tender['files']) {
            $tender['files'] = json_decode($tender['files'], true);
        }

        $data = [
            'title' => 'Edit Tender',
            'tender' => $tender
        ];

        return view('admin/tender_form', $data);
    }

    public function delete($id)
    {
        $unitId = $this->session->get('login_info')['unit_id'];
        $userId = $this->session->get('login_info')['user_id'];

        $userRights = user_right($unitId);
        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not a Administrator!');
        }
        $tender = $this->tenderModel->find($id);
        if (!$tender) {
            throw PageNotFoundException::forPageNotFound();
        }

        if ($tender['files']) {
            $files = json_decode($tender['files'], true);
            foreach ($files as $file) {
                if (isset($file['path']) && file_exists($file['path'])) {
                    unlink($file['path']);
                }
            }
        }

        $this->tenderModel->delete($id);
        $this->session->setFlashdata('success', 'Tender deleted successfully!');

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['status' => 'success']);
        }

        return redirect()->to('/admin/tenders');
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
