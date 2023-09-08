<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login('Administrator');
        $this->load->model('Product_model', 'product');
        $this->load->model('M_login', 'login');
    }

    public function pdf()
    {
        $data_user = $this->session->userdata('login_session');
        // Load the dompdf library
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Load the HTML view
        $data['products'] = $this->product->get_data_pdf($data_user['user']); // change this line according to your model
        $html = $this->load->view('admin/product/pdf_view', $data, true);

        // Load the HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Set the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF (choose to save or display)
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("products.pdf", array("Attachment" => false));
    }

    public function index()
    {
        // Menggunakan session untuk memperoleh data user yang sedang login
        $data_user = $this->session->userdata('login_session');
        $data['data_user'] = $data_user;
        $data['user'] = $this->login->userdata($data_user['user']);

        $data['title'] = 'Product';
        $data['page'] = 'Daftar Product';

        // Pagination start
        $this->load->library('pagination');
        $config['base_url'] = site_url('/admin/product/');
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->product->get_total_data($data_user['user']);
        $config['per_page'] = 5;

        $config['attributes'] = array('class' => 'page-link');
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $limit = $config['per_page'];
        $offset = (int) html_escape($this->input->get('per_page'));

        // Data product
        $params = array($data_user['user'], $offset, $limit);
        $data['products'] = $this->product->get_all_data_product($params);
        // Pagination end

        // Title
        $data['no'] = $offset + 1;

        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/product/index');
        $this->load->view('templates/admin/footer');
    }


    // Custom validation callback for image field
    public function validate_image()
    {
        if (!empty($_FILES['image']['name'])) 
        {
            $config['upload_path'] = './upload';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2 MB
            $config['encrypt_name'] = true;
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload('image')) 
            {
                $this->form_validation->set_message('validate_image', '{field} harus berupa file gambar yang valid (jpg, jpeg, png, gif) dengan ukuran maksimal 2MB.');
                return false;
            }
        }
    
        return true;
    }

    public function get_product()
    {
        $id = $this->input->post('id');
        $product = $this->product->get_product_by_id($id);
        if ($product) 
        {
            echo json_encode($product);
        } else 
        {
            echo json_encode(['error' => 'Produk tidak ditemukan!']);
        }
    }

    public function create()
    {
        // Load form validation library
        $this->load->library('form_validation');
    
        // Set validation rules for each input field
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('image', 'Image', 'callback_validate_image');
    
        if ($this->form_validation->run() === false) 
        {
            // Form validation failed, return error response
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
            return;
        }

        $data_user = $this->session->userdata('login_session');
    
        $data = [
            //foreign key
            'id_user' => $data_user['user'],
            // foreign key
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price' => $this->input->post('price'),
            'image' => $this->input->post('image'),
            'created_at' => time()
        ];
    
        if (!empty($_FILES['image']['name'])) 
        {
            $config['upload_path'] = './upload';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2 MB
            $config['encrypt_name'] = true;
    
            $this->load->library('upload', $config);
    
            if (!$this->upload->do_upload('image')) 
            {
                // Image upload failed, return error response
                $error = $this->upload->display_errors();
                echo json_encode(['status' => 'error', 'message' => $error]);
                return;
            }
    
            $upload_data = $this->upload->data();
            $data['image'] = $upload_data['file_name'];
        }
    
        $id = $this->product->create($data, $data_user['user']);
        if ($id) 
        {
            echo json_encode(['status' => 'success', 'id' => $id]);
        } else 
        {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan produk!']);
        }
    }
    
    public function update()
    {
        // Load form validation library
        $this->load->library('form_validation');

        // Set form validation rules
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('image', 'Image', 'callback_validate_image');

        // Run form validation
        if ($this->form_validation->run() == false) 
        {
            // If form validation fails, return error response
            $errors = validation_errors();
            echo json_encode(['status' => 'error', 'message' => $errors]);
            return;
        }

        $id = $this->input->post('id');
        $existing_product = $this->product->get_product_by_id($id);

        if (!$existing_product) 
        {
            echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan!']);
            return;
        }

        $data_user = $this->session->userdata('login_session');

        $data = [
            'id_user' => $data_user['user'],
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price' => $this->input->post('price'),
            'created_at' => time()
        ];

        if ($_FILES['image']['name']) 
        {
            $config['upload_path'] = './upload';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // 2 MB
            $config['encrypt_name'] = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')) 
            {
                $error = $this->upload->display_errors();
                echo json_encode(['status' => 'error', 'message' => $error]);
                return;
            }

            $upload_data = $this->upload->data();
            $data['image'] = $upload_data['file_name'];
        } else 
        {
            // If no new image is uploaded, use the existing image data
            $data['image'] = $existing_product->image;
        }

        $rows = $this->product->update($id, $data);
        if ($rows > 0) 
        {
            echo json_encode(['status' => 'success', 'rows' => $rows]);
        } else 
        {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbaharui produk!']);
        }
    }


    public function delete()
    {
        $id = $this->input->post('id');
        $rows = $this->product->delete($id);
        if ($rows > 0) 
        {
            echo json_encode(['status' => 'success', 'rows' => $rows]);
        } else 
        {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus produk!']);
        }
    }
    
    //controller
    public function delete_selected() {
        if ($this->input->is_ajax_request() == true) {
            $id = $this->input->post('delete_ids', true);
            $jmlData = count($id);
            $hapusData = $this->product->delete_products($id, $jmlData);

            if ($hapusData == true) {
                $msg = [
                    'sukses' => "$jmlData data product berhasil terhapus"
                ];
            } else {
                $msg = [
                    'error' => 'Gagal menghapus data!'
                ];
            }
            echo json_encode($msg);
        } else {
            echo "Maaf tidak dapat melanjutkan proses";
            exit;
        }
    }

    
}