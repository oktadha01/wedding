<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Dash_admin extends CI_Controller
{
    public $M_dash_admin;
    public $input;
    public $db;
    public $session;
    public $uri;
    var $template = 'temp_admin/index';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_dash_admin');
    }
    function index()
    {
        $data['count_data'] = $this->M_dash_admin->m_count_data();
        $data['tittle']          = 'Dashboard Undangan';
        $data['content']         = 'page_admin/dash_admin/dash_admin';
        $data['script']         = 'page_admin/dash_admin/dash_admin_js';
        $this->load->view($this->template, $data);
    }
}
