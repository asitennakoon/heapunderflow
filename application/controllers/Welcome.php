<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User');
	}

	public function index()
	{
		if ($this->User->is_logged_in()) {
			$data = [];
			$data['isLoggedIn'] = true;

			$this->load->view('includes/header.php', $data);
			$this->load->view('dashboard');
			$this->load->view('includes/footer.php');
		} else {
			$this->load->view('includes/header.php');
			$this->load->view('home');
			$this->load->view('includes/footer.php');
		}
	}
}
