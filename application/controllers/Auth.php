<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
    }

    public function confirmregister()
    {
        $fullName = $this->input->post('fullName');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if (!$this->UserModel->create($fullName, $username, $password)) {
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
        } elseif ($this->UserModel->is_logged_in()) {
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
        if ($this->UserModel->authenticate($username, $password)) {
            $this->session->is_logged_in = true;
            $this->session->username = $username;
            redirect('');
        } else {
            $this->session->login_error = true;
            redirect('/auth/login');
        }
    }

    public function account()
    {
        $username = $this->session->username;
        $fullName = $this->UserModel->getAccountName($username);

        $this->load->view('includes/header.php', array('isLoggedIn' => $this->UserModel->is_logged_in()));
        $this->load->view('account', array('fullName' => $fullName));
        $this->load->view('includes/footer.php');
    }

    public function changename()
    {
        $username = $this->session->username;
        $newFullName = $this->input->post('fullName');
        $this->UserModel->changeFulLName($username, $newFullName);

        header('Content-Type: application/json');
        echo json_encode($this->UserModel->getAccountName($username));
    }

    public function changepassword()
    {
        $username = $this->session->username;
        $oldPassword = $this->input->post('oldPassword');
        $newPassword = $this->input->post('newPassword');
        $success = $this->UserModel->changePassword($username, $oldPassword, $newPassword);

        if ($success) {
            $this->session->is_logged_in = false;
            header('Content-Type: application/json');
            echo json_encode("Password Changed Successfully");
        } else {
            // Display error msg
        }
    }

    public function logout()
    {
        $this->session->is_logged_in = false;
        redirect('');
    }
}
