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

    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $petugas = $this->petugas->getPetugas();
            if ($petugas) {
                //success
                $this->response([
                    'status' => true,
                    'data' => $petugas,
                ], REST_Controller::HTTP_OK);
            } else {
                //fail
                $this->response([
                    'status' => false,
                    'error' => 'Data kosong',
                ], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $petugas = $this->petugas->getPetugasbyID($id);
            if ($petugas) {
                //success
                $this->response([
                    'status' => true,
                    'data' => $petugas,
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
            'nama' => $this->post('nama'),
            'username' => $this->post('username'),
            'password' => $this->post('password'),
            'tipe' => $this->post('tipe')
        ];
        // $this->response([
        //     'status' => true,
        //     'message' => 'Username telah digunakan oleh orang lain',
        //     'data' => $arr['username']
        // ], REST_Controller::HTTP_OK);
        // cek autentikasi dan cek field kosong
        if ($this->petugas->authInsert($auth) && !(in_array(null, $arr, false) || ($this->post('tipe') != 'Petugas Admin' && $this->post('tipe') != 'Petugas Cuci'))) {
            if ($this->petugas->isUsernameUnique($arr['username']) == false) {
                $this->response([
                    'status' => false,
                    'message' => 'Username telah digunakan oleh orang lain',
                    'data' => $arr
                ], REST_Controller::HTTP_OK);
            }
            if ($this->petugas->insertPetugas($arr)) {
                $this->response([
                    'status' => true,
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

    public function login_post()
    {
        $arr = [
            'username' => $this->post('username'),
            'password' => $this->post('password')
        ];
        if (!in_array(null, $arr, false)) {

            $result = $this->petugas->checkLogin($arr);
            if ($result) {
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
            $this->response([
                'status' => false,
                'data' => 'Data kosong',
            ], REST_Controller::HTTP_OK);
        }
    }
}
