<?php

namespace App\Controllers;
use \App\Models\MapiModel;

class Home extends BaseController
{
    protected $session;
    
    function __construct()
	{

		$this->session = \Config\Services::session();
		$this->session->start();
	}

    public function index(): string
    {
        $balance = MapiModel::curl_data('/balance', "GET", null, $_COOKIE['sims_token']);
        if($balance->status == 108){
            return redirect()->to('logout?expired=true'); 
        }

        $services = MapiModel::curl_data('/services', "GET", null, $_COOKIE['sims_token']);
        $banner = MapiModel::curl_data('/banner', "GET", null, $_COOKIE['sims_token']);
        
        $data['banner']   = $banner;
        $data['services'] = $services;
        $data['balance']  = $balance;
        $data['session']  = $this->session;  
        return view('home', $data);
    }
}
