<?php

class Pemesanan_model extends CI_Model
{
  public function getPemesanan($id = null, $petugas)
  {
    if ($id == null) {
      //ini nampilin di halaman awal
      $this->db->select('pem.id_pemesanan, pel.nama as nama_pelanggan, pet.nama as nama_petugas, pem.total_harga, pem.tanggal_masuk, pem.tanggal_keluar, pem.status')
        ->from('ppk_pemesanan pem')
        ->join('ppk_pelanggan pel', 'pel.id_pelanggan = pem.id_pelanggan')
				->join('ppk_petugas pet', 'pet.id_petugas = pem.id_petugas')
				->group_start()
					->where('pet.nama', $petugas)
					->or_where('pet.id_petugas', 0)
				->group_end()
        ->where('pet.nama', $petugas);
      return $this->db->get()->result_array();
    } else {
      //ini buat detail pemesanan nya
      $this->db->select('pem.id_pemesanan, pel.nama as nama_pelanggan, pet.nama as nama_petugas, pem.total_harga, pem.tanggal_masuk, pem.tanggal_keluar, pem.status')
        ->from('ppk_pemesanan pem')
        ->join('ppk_pelanggan pel', 'pel.id_pelanggan = pem.id_pelanggan')
        ->join('ppk_petugas pet', 'pet.id_petugas = pem.id_petugas')
        ->where('pem.id_pemesanan', $id)
        ->where('pet.nama', $petugas);
      return $this->db->get()->result_array();
    }
  }

  public function updatePemesanan($data, $id)
  {
    $this->db->update('ppk_pemesanan', $data, ['id_pemesanan' => $id]);
    return $this->db->affected_rows();
  }

  public function getRincianPemesanan($id)
  {
    return $this->db->select('bar.nama, rin.jumlah, rin.harga')
      ->from('ppk_rincian_pemesanan rin')
      ->join('ppk_pemesanan pem', 'pem.id_pemesanan = rin.id_pemesanan')
      ->join('ppk_barang_cucian bar', 'bar.id = rin.id_barang_cucian')
      ->where('rin.id_pemesanan', $id)->get()->result_array();
  }
}
