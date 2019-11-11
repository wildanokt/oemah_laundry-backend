<?php

class Peserta_model extends CI_Model
{
    public function getPeserta()
    {
        return $this->db->get('peserta')->result_array();
    }

    public function setPeserta($data)
    {
        $this->db->insert('peserta', $data);
        return $this->db->affected_rows();
    }

    public function deletePeserta($id_event)
    {
        $this->db->delete('peserta', ['id_event' => $id_event]);
        return $this->db->affected_rows();
    }

    public function updatePeserta($code)
    {
        $this->db->update('peserta', ['konfirmasi' => 1], ['kode_peserta' => $code]);
        return $this->db->affected_rows();
    }
}
