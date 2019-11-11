<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Event extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Event_model', 'event');
    }

    //lihat event | (param: id (opsional) -> lihat event tertentu)
    public function index_get()
    {
        $id = $this->get('id');
        if ($id) {
            $event = $this->event->getEvent($id);
        } else {
            $event = $this->event->getEvent();
        }

        if ($event) {
            $this->response([
                'status' => true,
                'data' => $event,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'event tidak ditemukan / kosong',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    //tambah event
    public function index_post()
    {
        // $uploaddir = base_url('assets/event/' . str_replace(' ', '_', $this->post('nama_event') . '/'));
        $uploaddir = './assets/event/' . str_replace(' ', '_', $this->post('nama_event') . '/');
        if (!file_exists($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }
        $uploadfile = $uploaddir . basename($_FILES['gambar']['name']);
        $data = [
            'nama_event' => $this->post('nama_event'),
            'tanggal_mulai' => $this->post('tanggal_mulai'),
            'tanggal_selesai' => $this->post('tanggal_selesai'),
            'jam_mulai' => $this->post('jam_mulai'),
            'jam_selesai' => $this->post('jam_selesai'),
            'deskripsi' => $this->post('deskripsi'),
            'lokasi' => $this->post('lokasi'),
            'kuota' => $this->post('kuota'),
        ];
        //upload poster
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadfile)) {
            $data['gambar'] = basename($_FILES['gambar']['name']);

            if ($this->event->setEvent($data) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Event telah dibuat',
                ], REST_Controller::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Event gagal dibuat',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Event gagal dibuat (upload gambar gagal)',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //update event
    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nama_event' => $this->put('nama_event'),
            'tanggal_mulai' => $this->put('tanggal_mulai'),
            'tanggal_selesai' => $this->put('tanggal_selesai'),
            'jam_mulai' => $this->put('jam_mulai'),
            'jam_selesai' => $this->put('jam_selesai'),
            'deskripsi' => $this->put('deskripsi'),
            'lokasi' => $this->put('lokasi'),
            'kuota' => $this->put('kuota'),
        ];
        // $uploaddir = './assets/event/' . str_replace(' ', '_', $this->put('nama_event') . '/');
        // if (!file_exists($uploaddir)) {
        //     mkdir($uploaddir, 0777, true);
        // }
        // $uploadfile = $uploaddir . basename($_FILES['gambar']['name']);

        // if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadfile)) {
        //     unlink($uploaddir . $this->put('gambar'));
        //     $data['gambar'] = basename($_FILES['gambar']['name']);
        if ($this->event->updateEvent($id, $data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Event telah diperbarui',
            ], REST_Controller::HTTP_ACCEPTED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Event gagal diperbarui',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
        // } else {
        //     $this->response([
        //         'status' => false,
        //         'message' => 'Event gagal diperbarui (upload gambar gagal)',
        //     ], REST_Controller::HTTP_BAD_REQUEST);
        // }
    }

    //delete event | warning: event terhapus -> peserta terdaftar ikut terhapus
    public function index_delete()
    {
        $id = $this->delete('id');
        if ($this->event->deleteEvent($id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Event berhasil dihapus',
            ], REST_Controller::HTTP_ACCEPTED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Event gagal dihapus',
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
