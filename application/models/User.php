<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function create($fullName, $username, $password)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if ($this->db->insert('user', array('fullName' => $fullName, 'username' => $username, 'password' => $hashed_password))) {
            return true;
        } else {
            return false;
        }
    }

    function authenticate($username, $password)
    {
        $query = $this->db->get_where('user', array('username' => $username));
        if ($query->num_rows() != 1) {
            return false;
        } else {
            $row = $query->row();
            if (password_verify($password, $row->password)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function is_logged_in()
    {
        if (isset($this->session->is_logged_in) && $this->session->is_logged_in == true) {
            return true;
        } else {
            return false;
        }
    }
}
