<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Rincian extends REST_Controller
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
      //yang ini harus diganti pake session(?)
      // $petugas = $this->get('petugas');
      // if($id == null){
      //   $pemesanan = $this->pemesanan->getPemesanan(null, $petugas);
      // } else {
      //   $pemesanan = $this->pemesanan->getPemesanan($id, $petugas);
      // }
      $rincian = $this->pemesanan->getRincianPemesanan($id);
      if ($rincian) {
        $this->response([
          'status' => true,
          'data' => $rincian,
        ], REST_Controller::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'error' => 'Data kosong',
        ], REST_Controller::HTTP_NOT_FOUND);
      }
    }
}
