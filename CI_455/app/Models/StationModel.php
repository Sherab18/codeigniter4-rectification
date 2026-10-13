<?php

namespace App\Models;

use CodeIgniter\Model;

class StationModel extends Model
{
    protected $table = 'c_stations';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id',
        'station',
        'capacity',
        'voltage',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'station' => 'required|alpha|min_length[3]',
        'capacity' => 'required|min_length[5]',
        'voltage' => 'required',
    ];
    protected $validationMessages = [
        'station' => [
            'required' => 'The Station name cannot be blank',
            'alpha' => 'The Station name must contain only alphabets',
            'min_length' => 'The Station name must contain atleast 3 characters',
        ],
        'capacity' => [
            'required' => 'The Station capacity cannot be blank',
            'min_length' => 'The Station capacity must contain atleast 5 characters',
        ],
        'voltage' => [
            'required' => 'Select one Voltage level',
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
