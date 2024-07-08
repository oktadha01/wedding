<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dash_admin extends CI_Model
{
    function m_count_data()
    {

        $this->db->select('COUNT(*) AS total');
        $this->db->select('COUNT(CASE WHEN status = "processing" THEN 1 END) AS processing');
        $this->db->select('COUNT(CASE WHEN state = "sent" THEN 1 END) AS sent');
        $this->db->select('COUNT(CASE WHEN state = "delivered" THEN 1 END) AS delivered');
        $this->db->select('COUNT(CASE WHEN hadir = "Yes" THEN 1 END) AS hadir');
        $this->db->select('COUNT(CASE WHEN hadir = "No" THEN 1 END) AS tdk_hadir');
        $this->db->select('SUM(jumlah) AS total_hadir');
        $this->db->from('undangan');
        $query = $this->db->get();
        return $query->result();
    }
}
