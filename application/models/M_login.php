<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{

    public function cek_username($username)
    {
        $sql = "SELECT a.username, a.role_id, b.role
                FROM user a 
                INNER JOIN user_role b ON a.role_id = b.id
                WHERE a.username = ?";
        $query = $this->db->query($sql, array($username))->row_array();
        return $query;
    }

    public function get_password($username)
    {
        $sql = "SELECT password 
                FROM user 
                WHERE username = ?";
        $query = $this->db->query($sql, array($username))->row_array();
        
        if ($query) {
            return $query['password'];
        } else {
            return null;
        }
    }


    public function userdata($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row_array();
    }

}