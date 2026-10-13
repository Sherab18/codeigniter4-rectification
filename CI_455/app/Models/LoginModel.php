<?php

namespace App\Models;
use CodeIgniter\Model;

class LoginModel extends Model
{
	protected $table = 'b_login_activity';
	protected $primaryKey = 'id';
	
	protected $useAutoIncrement = false;
	
	protected $returnType = 'array';
	protected $useSoftDeletes = false;
	
	protected $allowedFields = [
		'id', 'user_id', 'user_agent', 'user_ip', 'login_time', 'logout_time',
	];
	
	protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
	
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = false;
	protected $cleanValidationRules = true;

	protected $allowCallbacks = true;
	protected $beforeInsert = [];
	protected $afterInsert = [];
	protected $beforeUpdate = [];
	protected $afterUpdate = [];
	protected $beforeFind = [];
	protected $afterFind = [];
	protected $beforeDelete = [];
	protected $afterDelete = [];
}