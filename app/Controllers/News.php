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
            'title' => 'Your news',
        ];

        echo view('templates/header', $data);
        echo view('news/overview', $data);
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
        echo view('news/view', $data);
        echo view('templates/footer', $data);
    }

    public function create()
    {
        $model = new NewsModel();

        if ($this->request->getMethod() === 'post' && $this->validate([
            'title' => 'required|min_length[3]|max_length[255]',
            'body'  => 'required',
        ])) {
            $model->save([
                'title' => $this->request->getPost('title'),
                'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                'body'  => $this->request->getPost('body'),
                'created_at'  => $this->request->getPost('created_at'),
                'visibility'  => $this->request->getPost('visibility'),
                'status'  => $this->request->getPost('status'),
            ]);

            session()->setFlashdata('success', 'Has created a new article');

            return redirect()->route('news');
        } else {
            echo view('templates/header', ['title' => 'Create a news item']);
            echo view('news/create');
            echo view('templates/footer');
        }
    }

    public function update($id)
    {
        $model = new NewsModel();

        $data['news'] = $model->getNewById($id);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item with id: ' . $id);
        }

        $data['title'] = $data['news']['title'];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'title' => 'required|min_length[3]|max_length[255]',
            'body'  => 'required',
            'created_at'  => 'required',
            'visibility'  => 'required',
            'status'  => 'required'
        ])) {
            $model->save([
                'id'       => $id,
                'title' => $this->request->getPost('title'),
                'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                'body'  => $this->request->getPost('body'),
                'created_at'  => $this->request->getPost('created_at'),
                'visibility'  => $this->request->getPost('visibility'),
                'status'  => $this->request->getPost('status'),
            ]);
            session()->setFlashdata('success', 'Has updated the article with id: ' . $id);

            return redirect()->route('news');

        } else {
            echo view('templates/header', ['title' => 'Update item' . $id]);
            echo view('news/update', $data);
            echo view('templates/footer');
        }
    }

    public function delete($id)
    {
        $model = new NewsModel();

        $data['news'] = $model->getNewById($id);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news item with id: ' . $id);
        }

        $data['title'] = $data['news']['title'];

        if ($this->request->getMethod() === 'post') {
            $model->delete($id);
            session()->setFlashdata('success', 'Has deleted the article with id: ' . $id);

            return redirect()->route('news');
        } else {
            echo view('templates/header', ['title' => 'Delete item' . $id]);
            echo view('news/delete', $data);
            echo view('templates/footer');
        }
    }
}
