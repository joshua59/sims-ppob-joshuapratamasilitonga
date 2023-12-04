<?php namespace App\Controllers;
use \App\Models\MapiModel;

class Account extends BaseController
{
	protected $session;
    
    function __construct()
	{

		$this->session = \Config\Services::session();
		$this->session->start();
	}

	public function index()
	{
		$profile = MapiModel::curl_data('/profile', "GET", null, $_COOKIE['sims_token']);
		if($profile->status == 108){
            return redirect()->to('logout?expired=true'); 
        }

		$this->session->set('email', $profile->data->email);
		$this->session->set('first_name', $profile->data->first_name);
		$this->session->set('last_name', $profile->data->last_name);
		$this->session->set('profile_image', $profile->data->profile_image);

		$balance = MapiModel::curl_data('/balance', "GET", null, $_COOKIE['sims_token']);
        
		$data['balance'] = $balance;
		$data['session']  = $this->session;

		return view('account', $data);
	}

    public function edit()
	{
		$balance = MapiModel::curl_data('/balance', "GET", null, $_COOKIE['sims_token']);
        if($balance->status == 108){
            return redirect()->to('logout?expired=true'); 
        }

		$data['balance'] = $balance;
		$data['session']  = $this->session;

		return view('edit_profile', $data);
	}
}