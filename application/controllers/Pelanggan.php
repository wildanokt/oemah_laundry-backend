<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Pelanggan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelanggan_model', 'pelanggan');
        // header('Access-Control-Allow-Origin: *');
		// header('Access-Control-Allow-Methods: *');		
		// header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
		// header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Access-Control-Request-Method, Authorization");
		// SOLUSI TEKOK INTERNET :D
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
		}		
    }

    //get pelanggan
    public function index_get()
    {
        $id = $this->get('id');
        if ($id) {
            $pelanggan = $this->pelanggan->getPelanggan($id);
        } else {
            $pelanggan = $this->pelanggan->getPelanggan();
        }

        if ($pelanggan) {
            $this->response([
                'status' => true,
                'data' => $pelanggan,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Pelanggan tidak ditemukan / kosong',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    //register pelanggan
    public function index_post()
    {
        $data = [
            'nama' => $this->post('nama'),
            'username' => $this->post('username'),
            'password' => password_hash($this->post('password'), PASSWORD_DEFAULT),
            'telepon' => $this->post('telepon'),
            'alamat' => $this->post('alamat'),
        ];


        if ($this->pelanggan->setPelanggan($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Pelanggan berhasil didaftarkan',
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Pelanggan gagal didaftarkan',
            ], REST_Controller::HTTP_NOT_ACCEPTABLE);
        }
    }

    //login
    public function login_post()
    {
        $data = [
            'username' => $this->post('username'),
            'password' => $this->post('password')
        ];

        $userData = $this->pelanggan->getPelanggan($data['username']);
        if ($userData) {
            if (password_verify($data['password'], $userData['password'])) {
                $this->response([
                    'status' => true,
                    'message' => 'Login berhasil',
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Password salah',
                ], REST_Controller::HTTP_UNAUTHORIZED);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Pelanggan tidak ditemukan',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    //update
    public function index_put()
    {
        $id = $this->put('id');
        $user = $this->pelanggan->getPelanggan($id);
        $password = '';
        if ($this->put('password') == '') {
            $password = $user['password'];
        } else {
            $password = $this->put('password');
        }

        $data = [
            'nama' => $this->put('nama'),
            'username' => $this->put('username'),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'telepon' => $this->put('telepon'),
            'alamat' => $this->put('alamat'),
        ];
		// $this->response([
		// 	'status' => true,
		// 	'message' => 'Data pelanggan telah diperbarui',
		// ], REST_Controller::HTTP_OK);
		
        if ($this->pelanggan->updatePelanggan($id, $data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Data pelanggan telah diperbarui',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data pelanggan gagal diperbarui',
            ], REST_Controller::HTTP_NOT_MODIFIED);
        }
    }

    //delete pelanggan
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($this->pelanggan->deletePelanggan($id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Pelanggan berhasil dihapus',
            ], REST_Controller::HTTP_ACCEPTED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Pelanggan gagal dihapus',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
