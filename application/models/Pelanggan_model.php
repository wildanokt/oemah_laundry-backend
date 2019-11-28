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

    public function getPesananPelanggan($id = 'detail')
    {
        if (is_numeric($id)) {
            return $this->db->query('SELECT * FROM ppk_pemesanan JOIN ppk_pelanggan ON ppk_pemesanan.id_pelanggan = ppk_pelanggan.id_pelanggan WHERE ppk_pelanggan.id_pelanggan =' . $id . ' ORDER BY ppk_pemesanan.id_pemesanan DESC')->result_array();
        } else {
            return $this->db->query();
        }
    }
}
