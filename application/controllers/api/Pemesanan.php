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
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
			header("Access-Control-Allow-Headers: *");
			header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Access-Control-Request-Method, Authorization");
			// SOLUSI TEKOK INTERNET :D
			$method = $_SERVER['REQUEST_METHOD'];
			if ($method == "OPTIONS") {
				die();
			}
    }
    public function index_get()
    {
      $id = $this->get('id');
      $petugas = $this->get('petugas');
      if($id == null){
        $pemesanan = $this->pemesanan->getPemesanan(null, $petugas);
      } else {
        $pemesanan = $this->pemesanan->getPemesanan($id, $petugas);
      }
      if ($pemesanan) {
        $this->response([
          'status' => true,
          'data' => $pemesanan,
        ], REST_Controller::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'error' => 'Data kosong',
        ], REST_Controller::HTTP_NOT_FOUND);
      }
    }
    public function index_put()
    {
      $id = $this->put('id');
      if($this->put('id_petugas') != null){
        $data = [
          'status' => $this->put('status'),
          'id_petugas' => $this->put('id_petugas')
        ];
      } else {
        $data = [
          'status' => $this->put('status')
        ];
      }
      $pemesanan = $this->pemesanan->updatePemesanan($data, $id);
      if($pemesanan){
        $this->response([
          'status' => true,
          'message' => 'Status berhasil diubah.',
        ], REST_Controller::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'message' => 'Gagal mengubah status!',
        ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }
}
