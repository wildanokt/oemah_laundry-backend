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
        return $this->db->query('SELECT * FROM ppk_pemesanan JOIN ppk_pelanggan ON ppk_pemesanan.id_pelanggan = ppk_pelanggan.id_pelanggan WHERE ppk_pelanggan.id_pelanggan =' . $id . ' ORDER BY ppk_pemesanan.id_pemesanan DESC')->result_array();
    }

    public function getDetailPesananPelanggan($id)
    {
        return $this->db->query('SELECT * FROM ppk_pemesanan JOIN ppk_rincian_pemesanan ON ppk_pemesanan.id_pemesanan = ppk_rincian_pemesanan.id_pemesanan JOIN ppk_barang_cucian ON ppk_barang_cucian.id = ppk_rincian_pemesanan.id_barang_cucian WHERE ppk_pemesanan.id_pemesanan =' . $id)->result_array();
    }

    public function inputPesanan($data)
    {
        $this->db->insert('ppk_pemesanan', $data);
        return true;
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
        return true;
    }
}
