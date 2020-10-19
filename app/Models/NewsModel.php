<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'slug', 'body', 'created_at', 'updated_at', 'visibility', 'status', 'user_id'];

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];


    protected function beforeInsert(array $data)
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    protected function beforeUpdate(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d H:i:s');
        return $data;
    }

    public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->where('status', 'published')->findAll();
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

    public function getNewsByUser()
    {
        if (session()->get('roles') == json_encode(['ROLE_ADMIN'])) {
            return $this->asArray()->findAll();
        }
        return $this->asArray()
            ->where(['user_id' => session()->get('id')])
            ->findAll();
    }
}
