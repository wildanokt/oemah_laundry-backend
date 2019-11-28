<?php

class Akun_model extends CI_Model
{
  public function getAkun($username, $password){
      return $this->db->get_where('ppk_petugas', array('username' => $username, 'password'=> $password))->result_array();
  }
  public function updateAkun($data, $id){
    $this->db->update('ppk_petugas', $data, ['id_petugas' => $id]);
    return $this->db->affected_rows();
  }
}
