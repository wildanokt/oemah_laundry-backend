<?php

class Pemesanan_model extends CI_Model
{
	public function getPemesanan(){
		$this->db->select('pem.id_pemesanan, pel.nama as nama_pelanggan, pet.nama as nama_petugas, pem.tipe_cucian, pem.barang_cucian, pem.berat, pem.harga, pem.tanggal_masuk, pem.tanggal_keluar, pem.status')
		->from('ppk_pemesanan pem')
		->join('ppk_pelanggan pel', 'pel.id_pelanggan = pem.id_pelanggan')
		->join('ppk_petugas pet', 'pet.id_petugas = pem.id_petugas');
		return $this->db->get()->result_array();
	}
}
