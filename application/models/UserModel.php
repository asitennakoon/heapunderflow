<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
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

    function getAccountName($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('user');

        if ($query->num_rows() != 1) {
            return false;
        } else {
            return $query->row()->fullName;
        }
    }

    function changeFullName($username, $fullName)
    {
        $this->db->where(array('username' => $username));
        $this->db->update('user', array('fullName' => $fullName));
    }

    function changePassword($username, $oldPassword, $newPassword)
    {
        $query = $this->db->get_where('user', array('username' => $username));

        if ($query->num_rows() != 1) {
            return false;
        } else {
            $row = $query->row();

            if (password_verify($oldPassword, $row->password)) {

                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->db->update('user', array('password' => $hashed_password));
                return true;
            } else {
                return false;
            }
        }
    }
}
