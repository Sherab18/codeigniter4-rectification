<?php

namespace App\Models;

use CodeIgniter\Model;

class VacancyModel extends Model
{
    protected $table = 'vacancies';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'department', 'position_type', 'status', 'created_by', 'attachment_path', 'close_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function checkAndCloseExpiredVacancies()
{
    $currentDateTime = date('Y-m-d H:i:s');
    return $this->where('status', 'open')
                ->where('close_at <=', $currentDateTime)
                ->set('status', 'closed')
                ->update();
}
    // Add this method for public vacancies
    public function getPublicVacancies()
{
    $this->checkAndCloseExpiredVacancies();
    $currentDateTime = date('Y-m-d H:i:s');
    
    return $this->where('status', 'open')
        ->where('close_at >', $currentDateTime)
        ->orderBy('created_at', 'DESC')
        ->findAll();
}

public function getPublicVacancy($id)
{
    $this->checkAndCloseExpiredVacancies();
    $currentDateTime = date('Y-m-d H:i:s');
    
    return $this->where('status', 'open')
        ->where('close_at >', $currentDateTime)
        ->where('id', $id)
        ->first();
}
}
