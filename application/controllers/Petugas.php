<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Petugas extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Petugas_model', 'petugas');
		header('Access-Control-Allow-Origin: *');
	}

	public function login_post()
	{
		$arr = [
			'username' => $this->post('username'),
			'password' => $this->post('password')
		];
		$result = $this->petugas->checkLogin($arr);
		if ($result) {
			if($result['id_petugas'] > 0){
				//success
				$this->response([
					'status' => true,
					'data' => $result,
				], REST_Controller::HTTP_OK);
			} else {
				//fail
				$this->response([
					'status' => false,
					'error' => 'Data kosong',
				], REST_Controller::HTTP_OK);
			}
		} else {
			//fail
			$this->response([
				'status' => false,
				'error' => 'Data kosong',
			], REST_Controller::HTTP_OK);
		}
	}
}
