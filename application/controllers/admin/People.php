<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class People extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login('Administrator');
        $this->load->model('People_model', 'peoples');
        $this->load->model('M_login', 'login');
    }
    
    public function index()
    {
        $data['title'] = 'People';
        $data['page'] = 'Daftar People';

        // Load Library
        $this->load->library('pagination');

        // Config
        $config['base_url'] = 'http://localhost/modifotp/admin/people/index';
        $config['total_rows'] = $this->peoples->countAllPeoples();
        $config['per_page'] = 5;
        $config['num_links'] = 5;

        // Styling Pagination
        $config['full_tag_open'] = '
        <nav>
            <ul class="pagination justify-content-center mt-5">';

        $config['full_tag_close'] = '
            </ul>
        </nav>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');

        // Initialize
        $this->pagination->initialize($config);

        $data['start'] = $this->uri->segment(4);
        $data['peoples'] = $this->peoples->getPeoples($config['per_page'], $data['start']);
        
        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/people/index');
        $this->load->view('templates/admin/footer');
    }

}