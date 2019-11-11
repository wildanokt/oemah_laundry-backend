<?php

class Pemesanan_model extends CI_Model
{
	public function getPemesanan(){
		return $this->db->get('ppk_pemesanan')->result_array();
	}
}
