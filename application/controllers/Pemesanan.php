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
    $arr = [
      'id_pelanggan' => $this->post('id_pelanggan'),
      'id_petugas' => $this->post('id_petugas'),
      'tipe_cucian' => $this->post('tipe_cucian'),
      'barang_cucian' => $this->post('barang_cucian'),
      'berat' => $this->post('berat'),
      'harga' => $this->post('harga'),
      'tanggal_masuk' => $this->post('tanggal_masuk'),
      'tanggal_keluar' => $this->post('tanggal_keluar'),
      'status' => $this->post('status')
    ];
    if ($this->pemesanan->insertPemesananAdmin($arr)) {
      $this->response([
        'status' => 'Sukses',
        'message' => 'Data berhasil dimasukkan',
        'data' => $arr
      ], REST_Controller::HTTP_OK);
    } else {
      $this->response([
        'status' => 'Error',
        'message' => 'Data gagal dimasukkan',
        'data' => $arr
      ], REST_Controller::HTTP_BAD_REQUEST);
    }
    // if ($this->peserta->updatePeserta($kode) > 0) {
    // 	$this->response([
    // 		'status' => true,
    // 		'message' => 'Peserta terkonfirmasi hadir',
    // 	], REST_Controller::HTTP_OK);
    // } else {
    // 	$this->response([
    // 		'status' => false,
    // 		'message' => 'peserta tidak ditemukan',
    // 	], REST_Controller::HTTP_NOT_FOUND);
    // }
  }
}
