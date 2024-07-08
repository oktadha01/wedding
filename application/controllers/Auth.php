<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	var $template = 'templates/index';

	public $session;
	public $form_validation;
	public $M_auth;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_auth');
	}

	public function index()
	{
		$session = $this->session->userdata('status');

		if ($session == '') {
			$this->load->view('office/login/login');
		} else {
			redirect('Dashboard');
		}
	}

	public function login()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[15]');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == TRUE) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);

			$data = $this->M_auth->login($username, $password);

			if ($data == false) {
				$this->session->set_flashdata('result_login', '<br>Email atau Password yang anda masukkan salah.');
				redirect('Auth');
			} else {
				$session = [
					'userdata' => $data,
					'status' => "Loged in"
				];
				$this->session->set_userdata($session);
				redirect('Dashboard');
			}
		} else {
			$this->session->set_flashdata('result_login', '<br>email Dan Password Harus Diisi.');
			redirect('Auth');
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		$this->session->set_flashdata('sukses', 'Anda Telah Keluar dari Aplikasi');
		redirect('Auth');
	}
	// function __construct()
	// {
	// 	parent::__construct();
	// 	$this->load->model('m_auth');
	// 	$is_login = $this->session->userdata('status');

	// 	if ($is_login) {
	// 		redirect(base_url());
	// 		return;
	// 	}
	// }

	// function index()
	// {
	// 	$this->load->view('page/login');
	// }

	// public function login()
	// {
	// 	$input = array(
	// 		'username'  => $this->input->post('username'),
	// 		'password'  => $this->input->post('password'),
	// 	);

	// 	// $input = (object) $this->input->post(null, true);

	// 	if ($this->m_auth->run($input)) {
	// 		// $this->session->set_flashdata('success', 'Berhasil melakukan login');
	// 		// if ($this->session->userdata("status_user") == '0') {

	// 		redirect(base_url(''));
	// 		// } else {

	// 		// redirect(base_url('login'));
	// 		// }
	// 	} else {
	// 		// echo $input;
	// 		$this->session->set_flashdata('error', 'E-mail/Password anda masukan salah !!');
	// 		redirect(base_url('Auth'));
	// 	}
	// }
	// function logout()
	// {
	// 	$this->session->sess_destroy();
	// 	$this->session->set_flashdata('sukses', 'Anda Telah Keluar dari Aplikasi');
	// 	redirect(base_url('Auth'));
	// 	// redirect('Auth');
	// }
}


/* End of file Login.php */
/* Location: ./application/controllers/Login.php */