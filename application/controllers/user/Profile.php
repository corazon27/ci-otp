<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    protected $user;

    public function __construct()
    {
        parent::__construct();
        cek_login('Member');

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');

        $userId = $this->session->userdata('login_session')['user'];
        // echo "<pre>";
        // var_dump($userId);
        // echo "</pre>";
        // die;
        $this->user = $this->admin->get('user', ['id_user' => $userId]);
    }


    public function index()
    {
        $data['title'] = "Profile";
        $data['user'] = $this->user;
        $this->load->view('templates/member/header', $data);
        $this->load->view('templates/member/sidebar');
        $this->load->view('templates/member/topbar');
        $this->load->view('member/profile/user');
        $this->load->view('templates/member/footer');
    }

    private function _validasi()
    {
        $userId = $this->session->userdata('login_session')['user'];
        $db = $this->admin->get('user', ['id_user' => $userId]);
        $username = $this->input->post('username', true);
        $email = $this->input->post('email', true);

        $uniq_username = $db['username'] == $username ? '' : '|is_unique[user.username]';
        $uniq_email = $db['email'] == $email ? '' : '|is_unique[user.email]';

        $this->form_validation->set_rules('username', 'Username', 'required|trim|alpha_numeric' . $uniq_username);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email' . $uniq_email);
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
    }

    private function _config()
    {
        $config['upload_path']      = "./assets/img/avatar";
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['encrypt_name']     = TRUE;
        $config['max_size']         = '2048';

        $this->load->library('upload', $config);
    }

    public function setting()
    {
        $this->_validasi();
        $this->_config();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Setting";
            $data['user'] = $this->user;
            $this->load->view('templates/member/header', $data);
            $this->load->view('templates/member/sidebar');
            $this->load->view('templates/member/topbar');
            $this->load->view('member/profile/setting');
            $this->load->view('templates/member/footer');
        } else {
            $input = $this->input->post(null, true);
            // var_dump($input);
            // die;
            if (empty($_FILES['foto']['name'])) {
                $insert = $this->admin->update('user', 'id_user', $input['id_user'], $input);
                if ($insert) {
                    set_pesan('perubahan berhasil disimpan.');
                } else {
                    set_pesan('perubahan tidak disimpan.');
                }
                redirect('user/profile/setting');
            } else {
                if ($this->upload->do_upload('foto') == false) {
                    echo $this->upload->display_errors();
                    die;
                } else {
                    if (userdata('photo') != 'default.jpg') {
                        $old_image = FCPATH . 'assets/img/avatar/' . userdata('photo');
                        if (!unlink($old_image)) {
                            set_pesan('gagal hapus foto lama.');
                            redirect('user/profile/setting');
                        }
                    }

                    $input['photo'] = $this->upload->data('file_name');
                    $update = $this->admin->update('user', 'id_user', $input['id_user'], $input);
                    if ($update) {
                        set_pesan('perubahan berhasil disimpan.');
                    } else {
                        set_pesan('gagal menyimpan perubahan');
                    }
                    redirect('user/profile/setting');
                }
            }
        }
    }

    public function ubahpassword()
    {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|trim|min_length[3]|differs[password_lama]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'matches[password_baru]');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Ubah Password";
            $this->load->view('templates/member/header', $data);
            $this->load->view('templates/member/sidebar');
            $this->load->view('templates/member/topbar');
            $this->load->view('member/profile/ubahpassword');
            $this->load->view('templates/member/footer');
        } else {
            $input = $this->input->post(null, true);
            // echo "<pre>";
            // var_dump($input);
            // echo "</pre>";
            // die;
            if (password_verify($input['password_lama'], userdata('password'))) {
                $new_pass = ['password' => password_hash($input['password_baru'], PASSWORD_DEFAULT)];
                $query = $this->admin->update('user', 'id_user', userdata('id_user'), $new_pass);

                if ($query) {
                    set_pesan('password berhasil diubah.');
                } else {
                    set_pesan('gagal ubah password', false);
                }
            } else {
                set_pesan('password lama salah.', false);
            }
            redirect('user/profile/ubahpassword');
        }
    }








}