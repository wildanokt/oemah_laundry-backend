<?php

class Pelanggan_model extends CI_Model
{
	public function getPelanggan($id = 'all')
	{
		if ($id == 'all') {
			return $this->db->get('ppk_pelanggan')->result_array();
		} else if (is_numeric($id)) {
			return $this->db->get_where('ppk_pelanggan', ['id_pelanggan' => $id])->row_array();
		} else {
			return $this->db->get_where('ppk_pelanggan', ['username' => $id])->row_array();
		}
	}

	public function getPelangganByUsername($username)
	{
		return $this->db->get_where('ppk_pelanggan', ['username' => $username])->row_array();
	}

	public function setPelanggan($data)
	{
		$this->db->insert('ppk_pelanggan', $data);
		return $this->db->affected_rows();
	}

	public function deletePelanggan($id)
	{
		$this->db->delete('ppk_pelanggan', ['id_pelanggan' => $id]);
		return $this->db->affected_rows();
	}

	public function updatePelanggan($id, $data)
	{
		$this->db->update('ppk_pelanggan', $data, ['id_pelanggan' => $id]);
		return $this->db->affected_rows();
	}

	public function getPesananPelanggan($id)
	{
		return $this->db->query('SELECT * FROM ppk_pemesanan JOIN ppk_pelanggan ON ppk_pemesanan.id_pelanggan = ppk_pelanggan.id_pelanggan WHERE ppk_pemesanan.id_pelanggan =' . $id . ' ORDER BY ppk_pemesanan.id_pemesanan DESC')->result_array();
	}

	public function getDetailPesananPelanggan($id)
	{
		return $this->db->query('SELECT pem.tanggal_masuk, pem.tanggal_keluar, pem.status, bar.nama, rin.jumlah, rin.harga, pem.total_harga, bar.harga as harga_barang FROM ppk_pemesanan pem JOIN ppk_rincian_pemesanan rin ON pem.id_pemesanan = rin.id_pemesanan JOIN ppk_barang_cucian bar ON bar.id = rin.id_barang_cucian WHERE pem.id_pemesanan =' . $id)->result_array();
	}

	public function inputPesanan($data)
	{
		$this->db->insert('ppk_pemesanan', $data);
		return $this->db->affected_rows() > 0 ? true : false;
	}

	public function getHargaBarang($nama)
	{
		return $this->db->get_where('ppk_barang_cucian', ['nama' => $nama])->row_array();
	}

	public function getLatestId()
	{
		return $this->db->query('SELECT ppk_pemesanan.id_pemesanan FROM `ppk_pemesanan` ORDER BY ppk_pemesanan.id_pemesanan DESC')->row_array();
	}

	public function inputRinci($data)
	{
		$this->db->insert_batch('ppk_rincian_pemesanan', $data);
		return $this->db->affected_rows() > 0 ? true : false;
	}

	public function isUsernameUnique($username, $id = null)
	{
		if ($id == null) {
			return $this->db->where('username', $username)
				->get('ppk_pelanggan')->row_array() == null ? true : false;
		} else {

			return $this->db->where('username', $username)
				->where('id_pelanggan != ', $id)
				->get('ppk_pelanggan')->row_array() == null ? true : false;
		}
	}
}
