<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table = 'c_tickets';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'target',
        'severity',
        'station',
        'prob_desc',
        'serv_affected',
        'issue_by',
        'issue_date',
        'status',
        'passed_reason',
        'pen_reason',
        'pen_eng',
        'pen_date',
        'sol_procedure',
        'sol_eng',
        'sol_date',
        'ver_status',
        'ver_remarks',
        'ver_eng',
        'ver_date',
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'issue_date';
    protected $updatedField = 'pen_date';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'target' => 'required',
        'severity' => 'required',
        'station' => 'required',
        'prob_desc' => 'required|min_length[10]',
        'serv_affected' => 'required|min_length[10]',
        'tmp_pen_reason' => 'required_with[orb_pen]',
        'sol_procedure' => 'required_with[orb_sol]',
        'ver_remarks' => 'required_with[ver_status]',
    ];
    protected $validationMessages = [
        'target' => [
            'required' => 'Choose one service unit',
        ],
        'severity' => [
            'required' => 'Choose type of problem severity',
        ],
        'station' => [
            'required' => 'Select one station',
        ],
        'prob_desc' => [
            'required' => 'The problem description field cannot be blank',
            'min_length' => 'The problem description field must contain atlease 10 characters',
        ],
        'serv_affected' => [
            'required' => 'The service affected field cannot be blank',
            'min_length' => 'The service affected description must contain atlease 10 characters',
        ],
        'tmp_pen_reason' => [
            'required_with' => 'The reason for keeping the ticket pending cannot be blank.'
        ],
        'sol_procedure' => [
            'required_with' => 'Procedure followed for solving the ticket cannot be blank.'
        ],
        'ver_status' => [
            'required' => 'Verification status is required',
        ],
        'ver_remarks' => [
            'required_with' => 'Overall remarks on solved ticket cannot be blank.'
        ],
    ];
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
