<?php

namespace App\Controllers;

use App\Models\CandidateModel;
use App\Models\VacancyModel;
use App\Models\ShortlistModel;

class Candidates extends BaseController
{
    protected $candidateModel;
    protected $vacancyModel;
    protected $shortlistModel;

    public function __construct()
    {
        $this->candidateModel = new CandidateModel();
        $this->vacancyModel = new VacancyModel();
        $this->shortlistModel = new ShortlistModel();
        helper(['form', 'url']);
    }

    public function shortlist($candidateId)
    {
        $candidate = $this->candidateModel->find($candidateId);
        if (!$candidate) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Shortlist Candidate',
            'candidate' => $candidate
        ];

        return view('candidates/shortlist', $data);
    }

    public function storeShortlist()
    {
        $rules = [
            'candidate_id' => 'required|numeric',
            'notes' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $candidateId = $this->request->getPost('candidate_id');

        // Update candidate status
        $this->candidateModel->update($candidateId, [
            'status' => 'shortlisted'
        ]);

        // Add to shortlist
        $this->shortlistModel->save([
            'candidate_id' => $candidateId,
            'notes' => $this->request->getPost('notes'),
            'shortlisted_by' => session()->get('login_info')['user_id'], // Assuming you have user authentication
        ]);

        $candidate = $this->candidateModel->find($candidateId);
        return redirect()->to('career/vacancies/view/' . $candidate['vacancy_id'])
            ->with('message', 'Candidate shortlisted successfully');
    }

    public function viewResume($candidateId)
    {
        $candidate = $this->candidateModel->find($candidateId);
        if (!$candidate) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get the path from database
        $dbPath = $candidate['resume_path'];

        // Convert the stored path to actual file path
        $filePath = str_replace('writable/', WRITEPATH, $dbPath);

        // Verify the file exists
        if (!file_exists($filePath)) {
            log_message('error', "Resume file not found: " . $filePath);
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response->download($filePath, null);
    }

    public function viewShortlisted()
    {
        $shortlisted = $this->candidateModel->select('candidates.*, vacancies.title as vacancy_title')
            ->join('vacancies', 'vacancies.id = candidates.vacancy_id')
            ->where('candidates.status', 'shortlisted')
            ->orderBy('candidates.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Shortlisted Candidates',
            'candidates' => $shortlisted
        ];

        return view('candidates/shortlisted', $data);
    }
    public function reject($candidateId)
    {
        $candidate = $this->candidateModel->find($candidateId);
        if (!$candidate) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Reject Candidate',
            'candidate' => $candidate
        ];

        return view('candidates/reject', $data);
    }

    public function storeRejection()
    {
        $rules = [
            'candidate_id' => 'required|numeric',
            'notes' => 'permit_empty|string'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->candidateModel->update($this->request->getPost('candidate_id'), [
            'status' => 'rejected',
            'rejection_notes' => $this->request->getPost('notes'), // Save notes to rejection_notes field
            'rejected_by' => session()->get('login_info')['user_id'],
        ]);

        $candidate = $this->candidateModel->find($this->request->getPost('candidate_id'));
        return redirect()->to('career/vacancies/view/' . $candidate['vacancy_id'])
            ->with('message', 'Candidate rejected successfully');
    }

    public function select($candidateId)
    {
        $candidate = $this->candidateModel->find($candidateId);
        if (!$candidate) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Select Candidate',
            'candidate' => $candidate
        ];

        return view('candidates/select', $data);
    }

    public function storeSelection()
    {
        $rules = [
            'candidate_id' => 'required|numeric',
            'notes' => 'permit_empty|string'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->candidateModel->update($this->request->getPost('candidate_id'), [
            'status' => 'hired',
            'hired_notes' => $this->request->getPost('notes'),
            'selected_by' => session()->get('login_info')['user_id'],

        ]);

        $candidate = $this->candidateModel->find($this->request->getPost('candidate_id'));
        return redirect()->to('/career/vacancies/view/' . $candidate['vacancy_id'])
            ->with('message', 'Candidate hired successfully');
    }
}
