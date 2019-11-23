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
    }
    public function index_get()
    {
      $id = $this->get('id');
      if($id == null){
        $pemesanan = $this->pemesanan->getPemesanan();
      } else {
        $pemesanan = $this->pemesanan->getPemesanan($id);
      }

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
    public function index_put()
    {
      $id = $this->put('id');
      $data = [
        'status' => $this->put('status')
      ];
      if($this->pemesanan->updatePemesanan($data, $id) > 0){
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
