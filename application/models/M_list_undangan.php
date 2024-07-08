<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_list_undangan extends CI_Model
{
    var $column_ordertrx = array(null, 'name');
    var $column_searchtrx = array('name', 'contact', 'category', 'status', 'state');
    var $ordertrx = array('id_undangan' => 'ASC');
    private function _get_datatables($fil_status_send)
    {
        $this->db->select('*');
        $this->db->from('undangan');
        // $this->db->where('transaksi.id_event', $id_event);
        // $this->db->order_by('id_undangan', 'DESC');
        
        if ($fil_status_send == 'send'){
            $this->db->where('status', '');
            
        }else if ($fil_status_send == 'resending'){
            $this->db->where('status', 'processing');
            $this->db->or_where('state', 'sent');
        }else{
            
            // $this->db->where('status', '');
        }

            $i = 0;
        foreach ($this->column_searchtrx as $trx) {
            if (@$_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($trx, $_POST['search']['value']);
                } else {
                    $this->db->or_like($trx, $_POST['search']['value']);
                }
                if (count($this->column_searchtrx) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_ordertrx[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatablest($fil_status_send)
    {
        $this->_get_datatables($fil_status_send);
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtereds($fil_status_send)
    {
        $this->_get_datatables($fil_status_send);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all($fil_status_send)
    {
        $this->_get_datatables($fil_status_send);
        return $this->db->count_all_results();
    }

    function m_add_undangan($data)
    {
        return $this->db->insert('undangan', $data);
    }
    function m_edit_undangan($id_undangan, $name, $contact, $category, $col_category)
    {
        $update = $this->db->set('name', $name)
            ->set('contact', $contact)
            ->set('category', $category)
            ->set('col_category', $col_category)
            ->where('id_undangan', $id_undangan)
            ->update('undangan');
        return $update;
    }
    function m_delete_list_undangan($id_undangan)
    {
        $delete = $this->db->where('id_undangan', $id_undangan)
            ->delete('undangan');
        return $delete;
    }

    function get_list_wa($postid_undangan)
    {

        $postid_undangan = $this->input->post('id-undangan');

        // Ensure that $postid_undangan is not empty and is a string
        if (!empty($postid_undangan) && is_string($postid_undangan)) {
            // Convert the comma-separated string into an array
            $id_undangan = explode(',', rtrim($postid_undangan, ','));

            // Perform the database query
            $this->db->select('*');
            $this->db->from('undangan');
            $this->db->where_in('id_undangan', $id_undangan);
            $query = $this->db->get();

            // Return the result set
            return $query->result();
        } else {
            // Handle the case where $postid_undangan is empty or not a string
            return [];
        }
    }
}
