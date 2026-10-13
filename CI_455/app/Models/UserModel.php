<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'b_users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array'; // Ensure array format is explicitly returned
    protected $allowedFields    = ['given_name', 'last_name', 'sex', 'mobile', 'email', 'avatar', 'password', 'status', 'created_at', 'updated_at'];

    protected $beforeInsert     = ['hashPassword'];
    protected $beforeUpdate     = ['hashPassword']; // Added beforeUpdate hook

    protected function hashPassword(array $data)
    {
        // Hash password only if it is set and not empty
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            // Remove empty password field so it doesn't accidentally overwrite with empty string
            unset($data['data']['password']);
        }

        return $data;
    }
}
