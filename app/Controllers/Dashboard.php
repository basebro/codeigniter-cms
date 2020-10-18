<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		$data = [];
		$data['title'] = 'dashboard';

		if (!session()->get('isLoggedIn')) {
			return redirect()->to('login');
		}

		echo view('templates/header', $data);
		echo view('dashboard');
		echo view('templates/footer');
	}
}
