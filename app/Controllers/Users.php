<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
	public function showUsers()
	{
		$model = new UserModel();

		$data = [
			'users'  => $model->findAll(),
			'title' => 'All users',
		];

		echo view('templates/header', $data);
		echo view('user/show-users');
		echo view('templates/footer');
	}

	public function createUser()
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

				parent::sendMail($this->request->getVar('email'));
				session()->setFlashdata('success', 'Successful Registration');

				return redirect()->route('dashboard/users/show');
			}
		}
		echo view('templates/header', $data);
		echo view('user/create-user');
		echo view('templates/footer');
	}

	public function editUser($id)
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

	public function deleteUser($id)
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
			echo view('templates/header', $data);
			echo view('user/delete-user', $data);
			echo view('templates/footer');
		}
	}

	public function profile()
	{
		$data = [];
		$data['title'] = 'Profile';

		helper(['form']);
		$model = new UserModel();

		if ($this->request->getMethod() == 'post') {
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
		echo view('user/profile');
		echo view('templates/footer');
	}
}
