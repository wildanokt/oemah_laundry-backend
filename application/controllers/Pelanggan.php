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
		$username = $this->post('username');

		if ($this->pelanggan->isUsernameUnique($username) == false) {
			$this->response([
				'status' => false,
				'message' => 'Username telah digunakan oleh orang lain',
			], REST_Controller::HTTP_OK);
		}
		$data = [
			'nama' => $this->post('nama'),
			'username' => $username,
			'password' => sha1($this->post('password')),
			'telepon' => $this->post('telepon'),
			'alamat' => $this->post('alamat'),
		];

		if ($this->pelanggan->setPelanggan($data) > 0) {
			$pelanggan = $this->pelanggan->getPelangganByUsername($username);
			$this->response([
				'status' => true,
				'message' => 'Pelanggan berhasil didaftarkan',
				'data' => $pelanggan
			], REST_Controller::HTTP_CREATED);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Pelanggan gagal didaftarkan'
			], REST_Controller::HTTP_NOT_ACCEPTABLE);
		}
	}

	//login
	public function login_post()
	{
    $password = sha1($this->post('password'));
		$data = [
			'username' => $this->post('username')
		];

		$userData = $this->pelanggan->getPelanggan($data['username']);
		if ($userData) {
			if ($userData['password'] == $password) {
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

		$username = $this->put('username');
		if ($user['username'] != $username) {
			if ($this->pelanggan->isUsernameUnique($username, $user['id_pelanggan']) == false) {
				$this->response([
					'status' => false,
					'message' => 'Username telah digunakan oleh orang lain',
				], REST_Controller::HTTP_OK);
			}
		}
		$data = [
			'nama' => $this->put('nama'),
			'username' => $this->put('username'),
			'password' => sha1($password),
			'telepon' => $this->put('telepon'),
			'alamat' => $this->put('alamat'),
		];

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

	//--------------------------------------
	public function pesanan_get()
	{
		$id = $this->get('id');
		$pesanan = $this->pelanggan->getPesananPelanggan($id);
		if ($pesanan) {
			$this->response([
				'status' => true,
				'data' => $pesanan,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Pesanan tidak ditemukan / kosong',
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function pesanan_post()
	{
		$id = $this->post('id_pelanggan');
		$postPesanan = $this->post('pesanan');
		$tanggalMasuk = $this->post('tanggal_masuk');

		$total = 0;
		$harga = [];
		$tanggalKeluar = [];
		foreach ($postPesanan as $key => $value) {
			$detailBarang = $this->pelanggan->getHargaBarang($key);
			$harga[] = [
				$key => $detailBarang['harga']
			];
			$tanggalKeluar[] = $detailBarang['lama'];
			$total += $value * $detailBarang['harga'];
		}
		$tanggalKeluarFix = max($tanggalKeluar);
		$data = [
			'id_petugas' => 0,
			'id_pelanggan' => $id,
			'total_harga' => $total,
			'tanggal_masuk' => $tanggalMasuk,
			'tanggal_keluar' => date('Y-m-d', strtotime($tanggalMasuk . "+$tanggalKeluarFix days")),
			'status' => 'Belum Diproses',
		];

		$rinci = [];
		if ($this->pelanggan->inputPesanan($data) == true) {
			$pesanan_id = $this->pelanggan->getLatestId()['id_pemesanan'];
			$rinci = [];
			foreach ($postPesanan as $key => $value) {
				$detailBarang = $this->pelanggan->getHargaBarang($key);
				$rinci[] = [
					'id_pemesanan' => $pesanan_id,
					'id_barang_cucian' => $detailBarang['id'],
					'jumlah' => $value,
					'harga' => $detailBarang['harga'] * $value,
				];
			}
			$this->pelanggan->inputRinci($rinci);

			$this->response([
				'status' => true,
				'message' => 'Pesanan berhasil',
				'data' => $rinci
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Pesanan gagal',
			], REST_Controller::HTTP_NOT_ACCEPTABLE);
		}
	}

	public function detail_get()
	{
		$id = $this->get('id');
		$pesanan = $this->pelanggan->getDetailPesananPelanggan($id);
		if ($pesanan) {
			$this->response([
				'status' => true,
				'data' => $pesanan,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Pesanan tidak ditemukan / kosong',
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
}
