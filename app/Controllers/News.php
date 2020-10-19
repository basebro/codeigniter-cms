<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Controller;


class News extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $model = new NewsModel();

        $data = [
            'news'  => $model->getNews(),
            'title' => 'News',
        ];

        echo view('templates/header', $data);
        echo view('news/public-overview', $data);
        echo view('templates/footer', $data);
    }

    public function view($slug = NULL)
    {
        $model = new NewsModel();

        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];
        $data['created_at'] = $data['news']['created_at'];

        echo view('templates/header', $data);
        echo view('news/public-single-view', $data);
        echo view('templates/footer', $data);
    }
}
