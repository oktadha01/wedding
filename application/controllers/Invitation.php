<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Invitation extends CI_Controller
{
    public $M_invitation;
    public $input;
    public $uri;
    public $db;
    var $template = 'temp_wedd/index';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_invitation');
    }
    function index()
    {
        $dateString = '2024-08-11 12:00:00'; // Example date and time
        // Create a DateTime object
        $date = new DateTime($dateString);
        // Get the Unix timestamp
        $formattedDate = $date->getTimestamp();
        $name = '';

        $data['tittle']      = 'Welcome to the Wedding of Rani &amp; Ivan &#8211; 11 August 2024';
        $data['for']         = $name;
        $data['tgl_acara']   = $formattedDate;
        $data['content']     = 'office/invitation/invit';
        $data['script']      = 'office/invitation/invit_js';
        $this->load->view($this->template, $data);
    }
    function for()
    {
        $this->load->helper('url');
        $for = str_replace("-", " ", $this->uri->segment(3));

        $name = '';
        $this->db->select("name,id_undangan");
        $this->db->where('name', $for);
        $query_ = $this->db->get('undangan');
        if ($query_->num_rows() > 0) {
            foreach ($query_->result() as $row) {
                $name =  $row->name;
            }
        } else {
            redirect(base_url());
        }

        $dateString = '2024-08-11 12:00:00'; // Example date and time

        // Create a DateTime object
        $date = new DateTime($dateString);

        // Get the Unix timestamp
        $formattedDate = $date->getTimestamp();
        $data['tittle']      = 'Undangan untuk ' . $name . ' &#8211; Welcome to the Wedding of Rani &amp; Ivan &#8211; 11 August 2024';
        $data['for']         = $name;
        $data['tgl_acara']   = $formattedDate;
        $data['content']     = 'office/invitation/invit';
        $data['script']      = 'office/invitation/invit_js';
        $this->load->view($this->template, $data);
    }
    function add_ucapan()
    {
        $date = new DateTime();
        $formattedDate = $date->format('F j, Y h:i A');
        $name = $this->input->post('name');
        $hadir = $this->input->post('hadir');
        if ($this->input->post('hadir') == 'No') {
            $jumlah = '';
        } else {
            $jumlah = $this->input->post('jumlah');
        }
        $ucapan = $this->input->post('ucapan');
        $tgl_ucapan = $formattedDate;

        $this->M_invitation->m_add_ucapan($name, $hadir, $jumlah, $ucapan, $tgl_ucapan);
    }
    function load_ucapan()
    {
        $list['ucapan'] = $this->M_invitation->m_data_ucapan();
        // echo 'conto';
        foreach ($list['ucapan'] as $data) {
            echo '<article class="elementor-post elementor-grid-item post-2485 greeting type-greeting status-publish hentry">
                                                        <div class="elementor-post__card">
                                                            <div class="elementor-post__text">
                                                                <p class="elementor-post__title">' . $data->name . '</p>
                                                                <div class="elementor-post__excerpt">
                                                                    <p>' . $data->ucapan . '</p>
                                                                </div>
                                                            </div>
                                                            <div class="elementor-post__meta-data">
                                                                <span class="elementor-post-date">' . $data->tgl_ucapan . '</span>
                                                            </div>
                                                        </div>
                                                    </article>';
        }
    }
}
