<?php namespace App\Controllers;
use \App\Models\MapiModel;

class Transaction extends BaseController
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

		$history = MapiModel::curl_data('/transaction/history?limit=5&offset=0', "GET", null, $_COOKIE['sims_token']);

		$data['history'] = $history->data->records;		
		$data['balance'] = $balance;
		$data['session']  = $this->session; 

		return view('transaction', $data);
	}

	public function list(){

		$history = MapiModel::curl_data('/transaction/history?limit=5&offset='.$_GET['offset'], "GET", null, $_COOKIE['sims_token']);
		if($history->status == 108){
            return redirect()->to('logout?expired=true'); 
        }

		$data['status'] = $history->status;
		$data['data'] = $history->data->records;
		$data['jumlah'] = count($history->data->records);

		echo json_encode($data);
	}

}