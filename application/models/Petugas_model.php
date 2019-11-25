<?php

class Petugas_model extends CI_Model
{
	public function checkLogin($where){
		return $this->db->get_where('ppk_petugas', $where)->row_array();
	}
}
