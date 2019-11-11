<?php

class Event_model extends CI_Model
{
    public function getEvent($id = null)
    {
        if ($id) {
            return $this->db->get_where('event', ['id' => $id])->result_array();
        } else {
            $this->db->order_by('id', 'DESC');
            return $this->db->get('event')->result_array();
        }
    }

    public function setEvent($data)
    {
        $this->db->insert('event', $data);
        return $this->db->affected_rows();
    }

    public function updateEvent($id, $data)
    {
        $this->db->update('event', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function deleteEvent($id)
    {
        $this->db->delete('event', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function getPeserta($id)
    {
        return $this->db->query('SELECT peserta.* FROM event JOIN peserta ON event.id=peserta.id_event WHERE event.id="' . $id . '"')->result_array();
    }

    public function getJumlahPeserta($id)
    {
        return $this->db->query('SELECT peserta.* FROM event JOIN peserta ON event.id=peserta.id_event WHERE event.id="' . $id . '"')->num_rows();
    }
}
