<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Pemesanan extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pemesanan_model', 'pemesanan');
	}

	public function index_get()
	{
		$pemesanan = $this->pemesanan->getPemesanan();
		if ($pemesanan) {
			//success
			$this->response([
				'status' => true,
				'data' => $pemesanan,
			], REST_Controller::HTTP_OK);
		} else {
			//fail
			$this->response([
				'status' => false,
				'error' => 'Data kosong',
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_post()
	{
		$kode = $this->post('kode');
		if ($this->peserta->updatePeserta($kode) > 0) {
			$this->response([
				'status' => true,
				'message' => 'Peserta terkonfirmasi hadir',
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'peserta tidak ditemukan',
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
}
