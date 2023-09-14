<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class Peoples extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login('Administrator');
        $this->load->model('Peoples_model', 'peopless');
        $this->load->model('M_login', 'login');
    }

    public function index()
    {
        $data_user = $this->session->userdata('login_session');
        $data['data_user'] = $data_user;
        $data['user'] = $this->login->userdata($data_user['user']);
        
        $data['title'] = 'Peoples';
        $data['page'] = 'Daftar Peoples';

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/peoples/index');
        $this->load->view('templates/admin/footer');
    }

    public function ambildata()
    {
        if ($this->input->is_ajax_request() == true) {
            $list = $this->peopless->get_datatables();
            var_dump($list);
            die;
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                
                $no++;
                $row = array();
               
                $row[] = $no;
                $row[] = $field->name;
                $row[] = $field->email;
                $data[] = $row;
            }
 
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->member->count_all(),
                "recordsFiltered" => $this->member->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        } else {
            exit('Maaf data tidak bisa ditampilkan');
        }
    }
}