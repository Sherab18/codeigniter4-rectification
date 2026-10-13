<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'content', 'attachments'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    protected function generateSlug(array $data)
    {
        $title = $data['data']['title'] ?? '';
        $slug = url_title($title, '-', true);
        $data['data']['slug'] = $this->makeUniqueSlug($slug);
        return $data;
    }

    private function makeUniqueSlug($slug, $count = 0)
    {
        $newSlug = $slug . ($count ? "-$count" : '');
        $exists = $this->where('slug', $newSlug)->countAllResults();

        return ($exists) ? $this->makeUniqueSlug($slug, $count + 1) : $newSlug;
    }
}