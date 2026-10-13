<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'report_type',
        'file_name',
        'file_path', // relative to WRITEPATH
        'upload_date',
        'report_date',   // date the daily report is for (extracted)
        'summary_json',  // figures extracted for the dashboard
    ];

    protected $validationRules = [
        'report_type' => 'required',
        'file_name'   => 'required',
        'file_path'   => 'required',
        'upload_date' => 'required',
    ];
}
