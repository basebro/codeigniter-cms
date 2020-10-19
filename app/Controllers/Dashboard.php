<?php

namespace App\Controllers;

use App\Models\NewsModel;

class Dashboard extends BaseController
{
	public function index()
	{
		$model = new NewsModel();

		$data = [];
		$data = [
			'news'  => $model->getNewsByUser(),
			'title' => 'Articles',
		];

		echo view('templates/header', $data);
		echo view('news/overview', $data);
		echo view('templates/footer');
	}

	
    public function view($slug = NULL)
    {
        $model = new NewsModel();

        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news article: ' . $slug);
        }

        $data['title'] = $data['news']['title'];
        $data['created_at'] = $data['news']['created_at'];

        echo view('templates/header', $data);
        echo view('news/single-view', $data);
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
                'visibility'  => $this->request->getPost('visibility'),
                'status'  => $this->request->getPost('status'),
                'user_id'  => session()->get('id'),
            ]);

            session()->setFlashdata('success', 'Has created a new article');

            return redirect()->route('dashboard');
        } else {
            echo view('templates/header', ['title' => 'Create a new article']);
            echo view('news/create');
            echo view('templates/footer');
        }
    }

    public function update($id)
    {
        $model = new NewsModel();

        $data['news'] = $model->getNewById($id);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news article with id: ' . $id);
        }

        $data['title'] = $data['news']['title'];

        if ($this->request->getMethod() === 'post' && $this->validate([
            'title' => 'required|min_length[3]|max_length[255]',
            'body'  => 'required',
            'visibility'  => 'required',
            'status'  => 'required'
        ])) {
            $model->save([
                'id'       => $id,
                'title' => $this->request->getPost('title'),
                'slug'  => url_title($this->request->getPost('title'), '-', TRUE),
                'body'  => $this->request->getPost('body'),
                'visibility'  => $this->request->getPost('visibility'),
                'status'  => $this->request->getPost('status'),
            ]);
            session()->setFlashdata('success', 'Has updated the article with id: ' . $id);

            return redirect()->route('dashboard');
        } else {
            echo view('templates/header', ['title' => 'Update article' . $id]);
            echo view('news/update', $data);
            echo view('templates/footer');
        }
    }

    public function delete($id)
    {
        $model = new NewsModel();

        $data['news'] = $model->getNewById($id);

        if (empty($data['news'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the news article with id: ' . $id);
        }

        $data['title'] = $data['news']['title'];

        if ($this->request->getMethod() === 'post') {
            $model->delete($id);
            session()->setFlashdata('success', 'Has deleted the article with id: ' . $id);

            return redirect()->route('dashboard');
        } else {
            echo view('templates/header', ['title' => 'Delete article' . $id]);
            echo view('news/delete', $data);
            echo view('templates/footer');
        }
    }

}
