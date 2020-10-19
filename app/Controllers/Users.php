<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
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

				$this->setUserSession($user);
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
			'roles' => $user['roles'],
		];

		session()->set($data);
		return true;
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

				$this->sendMail($this->request->getVar('email'));
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
		$data['title'] = 'Profile';

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
				$rules['roles'] = 'required';
			}


			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {
				$newData = [
					'id' => session()->get('id'),
					'name' => $this->request->getPost('name'),
					'last_name' => $this->request->getPost('last_name'),
					'roles' => str_replace(["\"", "[", "]"], "", $this->request->getPost('roles')),
				];
				if ($this->request->getPost('password') != '') {
					$newData['password'] = $this->request->getPost('password');
				}
				$model->save($newData);

				session()->setFlashdata('success', 'Successfuly Updated');
				return redirect()->to('/dashboard/profile');
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

	function sendMail($to)
	{
		$email = \Config\Services::email();

		$email->setTo($to);
		$email->setFrom('christianacevedo.89@gmail.com', 'Confirm Registration');
		$email->setSubject('Welcome');
		$email->setMessage('Hello and welcome to our Platform');
		if ($email->send()) {
			echo 'Email successfully sent';
		} else {
			$data = $email->printDebugger(['headers']);
			print_r($data);
		}
	}

	public function showUsers()
	{
		$model = new UserModel();

		$data = [
			'users'  => $model->findAll(),
			'title' => 'Users',
		];

		echo view('templates/header', $data);
		echo view('user/show-users', $data);
		echo view('templates/footer', $data);
	}

	public function create()
	{
		$data = [];

		$data['title'] = 'Create User';
		helper(['form']);

		if ($this->request->getMethod() === 'post') {

			$rules = [
				'name' => 'required|min_length[3]|max_length[255]',
				'last_name'  => 'required|min_length[3]|max_length[255]',
				'email'  => 'required|min_length[5]|max_length[255]|is_unique[users.email]|valid_email',
				'password'  => 'required|min_length[8]|max_length[255]',
				'password_confirm'  => 'matches[password]',
				'roles'  => 'required',
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
					'roles' => $this->request->getVar('roles'),
				];

				$model->save($newUser);

				$this->sendMail($this->request->getVar('email'));
				session()->setFlashdata('success', 'Successful Registration');

				return redirect()->route('dashboard/users/show');
			}
		}
		echo view('templates/header', $data);
		echo view('user/create');
		echo view('templates/footer');
	}

	public function edit($id)
	{
		$data = [];
		$data['title'] = 'Edit User';

		helper(['form']);
		$model = new UserModel();

		$data['user'] = $model->getUserById($id);

		if ($this->request->getMethod() == 'post') {
			//let's do the validation here
			$rules = [
				'name' => 'required|min_length[3]|max_length[20]',
				'last_name' => 'required|min_length[3]|max_length[20]',
				'roles' => 'required',
			];

			if ($this->request->getPost('password') != '') {
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}


			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

				$newData = [
					'id' => $id,
					'name' => $this->request->getPost('name'),
					'last_name' => $this->request->getPost('last_name'),
					'roles' => str_replace(["\"", "[", "]"], "", $this->request->getPost('roles')),

				];
				if ($this->request->getPost('password') != '') {
					$newData['password'] = $this->request->getPost('password');
				}
				$model->save($newData);

				session()->setFlashdata('success', 'Successfuly Updated');
				return redirect()->route('dashboard/users/show');
			}
		}

		echo view('templates/header', $data);
		echo view('user/edit-user', $data);
		echo view('templates/footer');
	}



	public function delete($id)
	{
		$data = [];
		$data['title'] = 'Delete User';

		helper(['form']);
		$model = new UserModel();

		$data['user'] = $model->getUserById($id);

		if (empty($data['user'])) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the user with id: ' . $id);
		}


		if ($this->request->getMethod() === 'post') {
			$model->delete($id);
			session()->setFlashdata('success', 'Has deleted the user with id: ' . $id);

			return redirect()->route('dashboard/users/show');
		} else {
			echo view('templates/header', ['title' => 'Delete user' . $id]);
			echo view('user/delete-user', $data);
			echo view('templates/footer');
		}
	}
}
