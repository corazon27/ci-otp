<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_login', 'login');
        cek_login('Administrator');
    }
    
    public function index()
    {   
        $data['title'] = 'Dashboard';
        // $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('dashboard/index');
        $this->load->view('templates/admin/footer');
    }

}