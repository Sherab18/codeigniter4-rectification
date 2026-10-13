<?php

namespace App\Models;

use CodeIgniter\Model;

class CandidateModel extends Model
{
    protected $table = 'candidates';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'vacancy_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'resume_path',
        'cover_letter',
        'hired_notes',
        'rejection_notes',
        'status',
        'selected_by',
        'rejected_by',
        'applied_at' // ADDED applied_at
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getCandidatesByVacancy($vacancyId)
    {
        return $this->where('vacancy_id', $vacancyId)->findAll();
    }

    public function getShortlistedCandidates($vacancyId = null)
    {
        $builder = $this->where('status', 'shortlisted');
        if ($vacancyId) {
            $builder->where('vacancy_id', $vacancyId);
        }
        return $builder->findAll();
    }

    public function rejectCandidate($candidateId, $notes = null)
    {
        return $this->update($candidateId, [
            'status' => 'rejected',
            'rejection_notes' => $notes
        ]);
    }
    // In your CandidateModel, update the getPublicCandidates method:
    public function getPublicCandidates($vacancyId = null, $statuses = ['shortlisted', 'hired'])
    {
        $builder = $this->whereIn('status', $statuses);

        if ($vacancyId) {
            $builder->where('vacancy_id', $vacancyId);
        }

        $candidates = $builder->orderBy('status', 'DESC')
            ->orderBy('first_name', 'ASC')
            ->orderBy('last_name', 'ASC')
            ->findAll();

        // Add full_name to each candidate
        foreach ($candidates as &$candidate) {
            $candidate['full_name'] = $candidate['first_name'] . ' ' . $candidate['last_name'];
        }

        return $candidates;
    }

    public function getPublicCandidate($id)
    {
        $candidate = $this->whereIn('status', ['shortlisted', 'hired'])
            ->where('id', $id)
            ->first();

        if ($candidate) {
            $candidate['full_name'] = $candidate['first_name'] . ' ' . $candidate['last_name'];
        }

        return $candidate;
    }
}
