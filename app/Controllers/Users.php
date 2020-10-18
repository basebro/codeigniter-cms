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

				$this->setUserSession($user);
				//$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to('dashboard');
			}
		}

		echo view('templates/header', $data);
		echo view('login');
		echo view('templates/footer');
	}

	private function setUserSession($user)
	{
		$data = [
			'id' => $user['id'],
			'name' => $user['name'],
			'last_name' => $user['last_name'],
			'email' => $user['email'],
			'isLoggedIn' => true,
		];

		session()->set($data);
		return true;
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

	public function profile()
	{

		$data = [];
		$data['title'] = 'profile';

		if (!session()->get('isLoggedIn')) {
			return redirect()->to('login');
		}

		helper(['form']);
		$model = new UserModel();

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'name' => 'required|min_length[3]|max_length[20]',
				'last_name' => 'required|min_length[3]|max_length[20]',
			];

			if ($this->request->getPost('password') != '') {
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}


			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

				$newData = [
					'id' => session()->get('id'),
					'name' => $this->request->getPost('name'),
					'last_name' => $this->request->getPost('last_name'),
				];
				if ($this->request->getPost('password') != '') {
					$newData['password'] = $this->request->getPost('password');
				}
				$model->save($newData);

				session()->setFlashdata('success', 'Successfuly Updated');
				return redirect()->to('/profile');
			}
		}

		$data['user'] = $model->where('id', session()->get('id'))->first();
		echo view('templates/header', $data);
		echo view('profile');
		echo view('templates/footer');
	}
	
	public function logout()
	{
		session()->destroy();
		return redirect()->to('login');
	}
}
