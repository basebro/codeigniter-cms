<?php

namespace App\Controllers;

use App\Models\UserModel;

class Register extends BaseController
{
	public function login()
	{
		$data = [];

		$data['title'] = 'Login';
		helper(['form']);

		if ($this->request->getMethod() === 'post') {
			$rules = [
				'email'  => 'required|min_length[5]|max_length[255]|valid_email',
				'password'  => 'required|min_length[8]|max_length[255]|validateUser[email,password]',
			];
			$errors = [
				'password' => [
					'validateUser' => 'Invalid Email or Password'
				]
			];
			if (!$this->validate($rules, $errors)) {
				$data['validation'] = $this->validator;
			} else {
				$model = new UserModel();

				$user = $model->where('email', $this->request->getVar('email'))
					->first();

				parent::setUserSession($user);
				return redirect()->to('dashboard');
			}
		}

		echo view('templates/header', $data);
		echo view('register/login');
		echo view('templates/footer');
	}

	public function register()
	{
		$data = [];

		$data['title'] = 'Register';
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
					'roles' => ['ROLE_USER'],
				];
				$model->save($newUser);
				$session = session();

				parent::sendMail($this->request->getVar('email'));
				$session->setFlashdata('success', 'Successful Registration');

				return redirect()->to('login');
			}
		}
		echo view('templates/header', $data);
		echo view('register/register');
		echo view('templates/footer');
	}


	public function logout()
	{
		session()->destroy();
		return redirect()->to('login');
	}
}
