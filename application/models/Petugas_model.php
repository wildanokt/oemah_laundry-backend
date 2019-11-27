<?php

class Petugas_model extends CI_Model
{
    public function getPetugas()
    {
        $this->db->select('id_petugas, nama, username, tipe')
            ->from('ppk_petugas')
            ->where('id_petugas != 0');
        return $this->db->get()->result_array();
    }

    public function getPetugasbyID($id = null)
    {
        $this->db->select('id_petugas, nama, username, tipe')
            ->from('ppk_petugas')
            ->where('id_petugas', $id);
        return $this->db->get()->result_array();
    }

    public function insertPetugas($arr)
    {
        $this->db->insert('ppk_petugas', $arr);
        return $this->db->affected_rows() > 0 ? true : false;
    }

    public function authInsert($arr)
    {
        return $this->db->get_where('ppk_petugas', $arr)->row_array();
    }

    public function checkLogin($where)
    {
        return $this->db->get_where('ppk_petugas', $where)->row_array();
    }
}
