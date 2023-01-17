<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User');
    }

    public function confirmregister()
    {
        $fullName = $this->input->post('fullName');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if (!$this->User->create($fullName, $username, $password)) {
            //TODO: redirect to register again with an error message
        } else {
            $this->load->view('includes/header.php');
            $this->load->view('confirmregister');
            $this->load->view('includes/footer.php');
        }
    }

    public function login()
    {
        if (isset($this->session->login_error) && $this->session->login_error == true) {
            // $this->session->login_error = false;
            $this->session->unset_userdata('login_error');
            $this->load->view('includes/header.php');
            $this->load->view(
                'login',
                array('login_error_msg' => "Username or Password is incorrect. Please try again.")
            );
            $this->load->view('includes/footer.php');
        } elseif ($this->User->is_logged_in()) {
            redirect('');
        } else {
            $this->load->view('includes/header.php');
            $this->load->view('login');
            $this->load->view('includes/footer.php');
        }
    }

    public function authenticate()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($this->User->authenticate($username, $password)) {
            log_message('debug', "Login Success. Username is $username");
            $this->session->is_logged_in = true;
            $this->session->username = $username;
            redirect('');
        } else {
            log_message('debug', "Login failed for $username");
            $this->session->login_error = true;
            redirect('/auth/login');
        }
    }

    public function logout()
    {
        $this->session->is_logged_in = false; //or session destroy
        redirect('');
    }
}
