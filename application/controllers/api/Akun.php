<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Akun extends REST_Controller
{
    public function __construct()
    {
      parent::__construct();
      $this->load->model('Akun_model', 'akun');
      header('Access-Control-Allow-Origin: *');
    }
    public function index_post()
    {
      $username = $this->post('username');
      $password = $this->post('password');

      $akun = $this->akun->getAkun($username, $password);
      if ($akun) {
        $this->response([
          'status' => true,
          'data' => $akun,
        ], REST_Controller::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'error' => 'Akun tidak terdaftar!',
        ], REST_Controller::HTTP_NOT_FOUND);
      }
    }
    public function index_put()
    {
      $id = $this->put('id');
      $data = [
        'nama' => $this->put('nama'),
        'username' => $this->put('username'),
        'password' => $this->put('password'),
      ];
      if($this->akun->updateAkun($data, $id) > 0){
        $this->response([
          'status' => true,
          'message' => 'Akun berhasil diubah.',
        ], REST_Controller::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'message' => 'Gagal mengubah akun!',
        ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }
}
