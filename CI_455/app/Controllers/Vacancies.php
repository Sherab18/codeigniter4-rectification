<?php

namespace App\Controllers;

use App\Models\VacancyModel;
use App\Models\CandidateModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Vacancies extends BaseController
{
    protected $vacancyModel;
    protected $candidateModel;
    public $session;


    public function __construct()
    {
        $this->vacancyModel = new VacancyModel();
        $this->candidateModel = new CandidateModel();
        $this->session = session();
        helper(['form', 'date', 'database', 'file','text']);
    }

    public function index()
    {
        $data = [
            'title' => 'Vacancies',
            'vacancies' => $this->vacancyModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('vacancies/index', $data);
    }

    public function create()
    {
        // 1. Get session safely
        $loginInfo = $this->session->get('login_info');

        // 2. If no session, they shouldn't even be here
        if (!$loginInfo) {
            return redirect()->to('login')->with('error', 'Session expired.');
        }

        $unitId = $loginInfo['unit_id'];

        // 3. Force global scope call (The backslash is key!)
        if (function_exists('user_right')) {
            $userRights = user_right($unitId);
        } else {
            // This is a backup check to tell you exactly what's wrong
            die("The function 'user_right' is still not found. Check if the helper file is loaded.");
        }

        if ($userRights !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized: You are not an Administrator!');
        }

        $data = ['title' => 'Create Vacancy'];
        return view('vacancies/create', $data);
    }

    public function store()
    {
        $rules = [
            'title' => 'required|max_length[255]',
            'description' => 'required',
            'department' => 'required|max_length[100]',
            'position_type' => 'required|max_length[50]',
            'attachment' => 'permit_empty|uploaded[attachment]|max_size[attachment,102040]|ext_in[attachment,pdf]',
            'close_at' => 'required|valid_date'

        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $attachmentPath = null;
        $attachment = $this->request->getFile('attachment');

        if ($attachment && $attachment->isValid() && !$attachment->hasMoved()) {
            $uploadPath = WRITEPATH . 'uploads/vacancies';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $newName = $attachment->getRandomName();

            try {
                $attachment->move($uploadPath, $newName);
                $attachmentPath = 'uploads/vacancies/' . $newName;
            } catch (\Exception $e) {
                log_message('error', 'File upload failed: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to upload attachment. Please try again.');
            }
        }


        $this->vacancyModel->save([
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'department' => $this->request->getPost('department'),
            'position_type' => $this->request->getPost('position_type'),
            'close_at' => $this->request->getPost('close_at'),
            'created_by' => $this->session->get('login_info')['user_id'],
            'status' => 'open',
            'attachment_path' => $attachmentPath


        ]);
        return redirect()->to('career/vacancies')->with('message', 'Vacancy created successfully');
    }

    public function view($id)
    {
        $vacancy = $this->vacancyModel->find($id);
        if (!$vacancy) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $vacancy['title'],
            'vacancy' => $vacancy,
            'candidates' => $this->candidateModel->where('vacancy_id', $id)
                ->orderBy('created_at', 'DESC')
                ->findAll()
        ];

        return view('vacancies/view', $data);
    }
    public function attachment($vacancyId)
    {
        $vacancy = $this->vacancyModel->find($vacancyId);
        if (!$vacancy || empty($vacancy['attachment_path'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $filePath = WRITEPATH . $vacancy['attachment_path'];
        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response->download($filePath, null);
    }
    public function close($id)
    {
        $vacancy = $this->vacancyModel->find($id);
        if (!$vacancy) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->vacancyModel->update($id, ['status' => 'closed']);
        return redirect()->back()->with('message', 'Vacancy closed successfully');
    }
    // In your Vacancies controller
    public function extend($id)
    {
        $vacancy = $this->vacancyModel->find($id);
        if (!$vacancy) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        if ($this->request->getMethod() === 'post') {
            $rules = ['close_at' => 'required|valid_date'];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->vacancyModel->update($id, [
                'close_at' => $this->request->getPost('close_at')
            ]);

            return redirect()->to('career/vacancies')->with('message', 'Vacancy closing time extended');
        }

        $data = [
            'title' => 'Extend Vacancy Closing Time',
            'vacancy' => $vacancy
        ];

        return view('vacancies/extend', $data);
    }
    public function publishResults($id)
    {
        $vacancy = $this->vacancyModel->find($id);

        if (!$vacancy) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->vacancyModel->update($id, ['results_published' => 1]);

        return redirect()->back()->with('message', 'Results published successfully');
    }

    public function unpublishResults($id)
    {
        $vacancy = $this->vacancyModel->find($id);

        if (!$vacancy) {
            throw PageNotFoundException::forPageNotFound();
        }

        $this->vacancyModel->update($id, ['results_published' => 0]);

        return redirect()->back()->with('message', 'Results unpublished successfully');
    }
}
