<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class BarangCucian extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('BarangCucian_model', 'barang');
        header('Access-Control-Allow-Origin: *');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $barang = $this->barang->getBarang();
            if ($barang) {
                //success
                $this->response([
                    'status' => true,
                    'data' => $barang,
                ], REST_Controller::HTTP_OK);
            } else {
                //fail
                $this->response([
                    'status' => false,
                    'error' => 'Data kosong',
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $barang = $this->barang->getBarangbyID($id);
            if ($barang) {
                //success
                $this->response([
                    'status' => true,
                    'data' => $barang,
                ], REST_Controller::HTTP_OK);
            } else {
                //fail
                $this->response([
                    'status' => false,
                    'error' => 'Data kosong',
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {
        $auth = [
            'username' => $this->post('usernameAdmin'),
            'password' => $this->post('passwordAdmin')
        ];
        $arr = [
            'nama' => $this->post('barang'),
            'harga' => $this->post('harga'),
            'lama' => $this->post('lama')
        ];
        // cek autentikasi dan cek field kosong
        if ($this->barang->authInsert($auth) && !(in_array(null, $arr, false))) {
            if ($this->barang->insertBarang($arr)) {
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
        } else {
            $this->response([
                'status' => 'Error',
                'message' => 'Illegal akses'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
