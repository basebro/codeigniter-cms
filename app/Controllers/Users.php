<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
	public function login()
	{
		$data = [];

		$data['title'] = 'login';
		helper(['form']);

		echo view('templates/header', $data);
		echo view('login');
		echo view('templates/footer');
	}

	public function register()
	{
		$data = [];

		$data['title'] = 'register';
		helper(['form']);
		if ($this->request->getMethod() === 'post') {

			$rules = [
				'name' => 'required|min_length[3]|max_length[255]',
				'last_name'  => 'required|min_length[3]|max_length[255]',
				'email'  => 'required|min_length[5]|max_length[255]|is_unique[users.email]|valid_email',
				'password'  => 'required|min_length[8]|max_length[255]',
				'password_confirm'  => 'matches[password]',
			];
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				$model = new UserModel();

				$newUser = [
					'name' => $this->request->getVar('name'),
					'last_name' => $this->request->getVar('last_name'),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
				];
				$model->save($newUser);
				$session = session();
				$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to('login');
			}
		}
		echo view('templates/header', $data);
		echo view('register');
		echo view('templates/footer');
	}
}
