<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Pemesanan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Peserta_model', 'peserta');
    }

    // public function index_get()
    // {
    //     $code = $this->get('kode');
    //     if ($this->peserta->updatePeserta($code) > 0) {
    //         //success
    //         redirect('https://www.google.com/');
    //     } else {
    //         //fail
    //         redirect('https://www.youtube.com/');
    //     }
    // }

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
