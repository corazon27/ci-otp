<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login('Member');
    }
    
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data_user = $this->session->userdata('login_session');
        //  echo "<pre>";
        //             var_dump($data_user);
        //             echo "</pre>";
        //             die;
		$data['data_user'] = $data_user;
        // $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/member/header', $data);
        $this->load->view('templates/member/sidebar', $data);
        $this->load->view('templates/member/topbar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/member/footer');
    }
}