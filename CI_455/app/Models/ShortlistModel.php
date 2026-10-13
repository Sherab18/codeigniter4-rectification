<?php namespace App\Models;

use CodeIgniter\Model;

class ShortlistModel extends Model
{
    protected $table = 'shortlists';
    protected $primaryKey = 'id';
    protected $allowedFields = ['candidate_id', 'notes', 'shortlisted_by'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}