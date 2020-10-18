<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'body', 'created_at', 'updated_at', 'visibility', 'status'];

    public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['slug' => $slug])
            ->first();
    }

    public function getNewById($id)
    {
        return $this->asArray()
            ->where(['id' => $id])
            ->first();
    }
}
