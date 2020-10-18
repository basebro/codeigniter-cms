<?php

namespace App\Controllers;

class Users extends BaseController
{
	public function index()
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

		echo view('templates/header', $data);
		echo view('register');
		echo view('templates/footer');
	}
}
