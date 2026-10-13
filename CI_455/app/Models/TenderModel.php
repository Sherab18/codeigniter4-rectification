<?php

namespace App\Models;

use CodeIgniter\Model;

class TenderModel extends Model
{
    protected $table = 'tenders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'reference', 'content', 'files', 'contact_name', 'contact_phone', 'contact_email'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getTenders()
    {
        $tenders = $this->orderBy('created_at', 'DESC')->findAll();
        return array_map(function ($tender) {
            if ($tender['files'] && is_string($tender['files'])) {
                $decoded = json_decode($tender['files'], true);
                $tender['files'] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : [];
            } elseif (empty($tender['files'])) {
                $tender['files'] = [];
            }
            return $tender;
        }, $tenders);
    }

    public function deleteWithFiles($id)
    {
        $tender = $this->find($id);
        if (!$tender) return false;

        if ($tender['files']) {
            $files = json_decode($tender['files'], true);
            foreach ($files as $file) {
                if (file_exists($file['path'])) {
                    unlink($file['path']);
                }
            }
        }

        return $this->delete($id);
    }
}
