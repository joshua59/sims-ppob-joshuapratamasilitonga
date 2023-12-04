<?php

namespace App\Controllers;

use \App\Models\MapiModel;

class Login extends BaseController
{
	protected $session;

	function __construct()
	{

		$this->session = \Config\Services::session();
		$this->session->start();
	}

	public function index()
	{
		if(isset($_GET['expired'])){
			$data['expired_notif'] = true;
		}else{
			$data['expired_notif'] = false;
		}
		return view('login', $data);
	}

	public function login_process()
	{
		$data = MapiModel::curl_data('/profile', "GET", null, $_COOKIE['sims_token']);

		if($data->status == 108){
            return redirect()->to('logout?expired=true'); 
        }

		$this->session->set('email', $data->data->email);
		$this->session->set('first_name', $data->data->first_name);
		$this->session->set('last_name', $data->data->last_name);
		$this->session->set('profile_image', $data->data->profile_image);
		$this->session->set('is_login', true);

		echo json_encode("success");
	}

	public function logout()
	{
		setcookie('sims_token', null, -1, '/');
		unset($_COOKIE['sims_token']);
		$this->session->destroy();

		if(isset($_GET['expired'])){
			$params = "?expired=true";
		}else{
			$params = "";
		}
		return redirect()->to('login'.$params); 
	}
}
