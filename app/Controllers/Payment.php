<?php namespace App\Controllers;
use \App\Models\MapiModel;

class Payment extends BaseController
{
	protected $session;
    
    function __construct()
	{

		$this->session = \Config\Services::session();
		$this->session->start();
	}

	public function index($category)
	{
		$balance = MapiModel::curl_data('/balance', "GET", null, $_COOKIE['sims_token']);
        if($balance->status == 108){
            return redirect()->to('logout?expired=true'); 
        }

		$services = MapiModel::curl_data('/services', "GET", null, $_COOKIE['sims_token']);
		$service = array();

		foreach($services->data as $row){
			if(strtolower($row->service_code) == $category){
				$service[] = $row;
			}
		}

		$data['service'] = $service[0];
		$data['balance'] = $balance;
		$data['category'] = $category;
		$data['session']  = $this->session;  
		return view('payment', $data);
	}

}