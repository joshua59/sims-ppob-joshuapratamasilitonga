<?php namespace App\Controllers;
use \App\Models\MapiModel;

class Topup extends BaseController
{
	protected $session;
    
    function __construct()
	{

		$this->session = \Config\Services::session();
		$this->session->start();
	}

	public function index()
	{
		$balance = MapiModel::curl_data('/balance', "GET", null, $_COOKIE['sims_token']);
        if($balance->status == 108){
            return redirect()->to('logout?expired=true'); 
        }
        
        $data['balance']  = $balance;
        $data['session']  = $this->session; 

		return view('topup', $data);
	}

}