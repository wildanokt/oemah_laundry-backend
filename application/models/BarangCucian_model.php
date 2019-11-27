<?php

class BarangCucian_model extends CI_Model
{
    public function getBarang()
    {
        return $this->db->get('ppk_barang_cucian')->result_array();
    }

    public function getBarangbyID($id = null)
    {
        return $this->db->get_where('ppk_barang_cucian', array('id' => $id))->result_array();
    }

    public function insertBarang($arr)
    {
        $this->db->insert('ppk_barang_cucian', $arr);
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function authInsert($arr)
    {
        return $this->db->get_where('ppk_petugas', $arr)->row_array();
    }
}
