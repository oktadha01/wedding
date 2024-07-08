<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_invitation extends CI_Model
{
    function m_data_ucapan()
    {

        $this->db->select('*');
        $this->db->from('undangan');
        $this->db->where('ucapan !=', ''); // Corrected this line
        $this->db->order_by('tgl_ucapan', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function m_add_ucapan($name,$hadir,$jumlah,$ucapan, $tgl_ucapan)
    {
        $update = $this->db->set('hadir', $hadir)
            ->set('jumlah', $jumlah)
            ->set('ucapan', $ucapan)
            ->set('tgl_ucapan', $tgl_ucapan)
            ->where('name', $name)
            ->update('undangan');
        return $update;
    }
}
