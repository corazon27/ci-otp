<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    protected $user;

    public function __construct()
    {
        parent::__construct();
        cek_login('Administrator');

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
        $this->load->model('Biodata_model', 'biodata');
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
        $this->load->view('templates/admin/header', $data);
        $this->load->view('templates/admin/sidebar');
        $this->load->view('templates/admin/topbar');
        $this->load->view('admin/profile/user');
        $this->load->view('templates/admin/footer');
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
            $sessionUser = $this->session->userdata('login_session');
            $userData = $this->biodata->getUser($sessionUser['user']);
            // echo "<pre>";
            // var_dump($userData);
            // echo "</pre>";
            // die;
            $data['user'] = $this->user;
            $data['profile'] = $this->biodata->dataProfile($sessionUser['user']);
            $data['domisili'] = $this->biodata->dataDomisili($sessionUser['user']);
            $data['provinsi'] = $this->biodata->dataProvinsi();
            $data['kota'] = $this->biodata->dataKota($userData['id_provinsi']);
            $data['kecamatan'] = $this->biodata->dataKecamatan($userData['id_kota']);
          
            $this->load->view('templates/admin/header', $data);
            $this->load->view('templates/admin/sidebar');
            $this->load->view('templates/admin/topbar');
            $this->load->view('admin/profile/setting');
            $this->load->view('templates/admin/footer');
        } else {
            $sessionUser = $this->session->userdata('login_session');
            $input = $this->input->post(null, true);
            $this->db->trans_start();
        
            // Input atau update ke tabel "biodata"
            $biodata_data = array(
                'alamat' => $input['alamat'],
                'jk' => $input['jk'],
                'no_telp' => $input['no_telp'],
            );
        
            // Pemisahan input dan update, gunakan insert_batch untuk update
            if ($this->biodata->isExists($sessionUser['user'])) {
                $this->biodata->update($sessionUser['user'], $biodata_data);
            } else {
                $biodata_data['id_user'] = $sessionUser['user'];
                $this->biodata->create($biodata_data);
            }
        
            // Hapus data "no_telp", "jk", dan "alamat" dari input sebelum update tabel "user"
            unset($input['no_telp']);
            unset($input['jk']);
            unset($input['alamat']);
        
            // Input atau update ke tabel "user" (termasuk foto jika ada perubahan)
            if (!empty($_FILES['foto']['name'])) {
                if ($this->upload->do_upload('foto')) {
                    if (userdata('photo') != 'default.jpg') {
                        $old_image = FCPATH . 'assets/img/avatar/' . userdata('photo');
                        if (!unlink($old_image)) {
                            set_pesan('gagal hapus foto lama.');
                            redirect('admin/profile/setting');
                        }
                    }
        
                    $input['photo'] = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                    die;
                }
            }
        
            // Update data user (termasuk foto jika ada perubahan)
            $this->admin->update('user', 'id_user', $input['id_user'], $input);
        
            // Akhiri transaksi
            $this->db->trans_complete();
        
            if ($this->db->trans_status() === false) {
                // Transaksi gagal
                set_pesan('Gagal menyimpan perubahan');
            } else {
                // Transaksi berhasil
                set_pesan('Perubahan berhasil disimpan.');
            }
        
            redirect('admin/profile/setting');
        }        
    }

    public function ubahpassword()
    {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|trim|min_length[3]|differs[password_lama]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'matches[password_baru]');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Ubah Password";
            $this->load->view('templates/admin/header', $data);
            $this->load->view('templates/admin/sidebar');
            $this->load->view('templates/admin/topbar');
            $this->load->view('admin/profile/ubahpassword');
            $this->load->view('templates/admin/footer');
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
            redirect('admin/profile/ubahpassword');
        }
    }


    public function getdatakota() {
        $provinsi_id = $this->input->post('provinsi');
        $kota = $this->biodata->getKotaByProvinsi($provinsi_id);
        echo json_encode($kota);
    }

    public function getdatakecamatan() {
        $kota_id = $this->input->post('kota');
        $kecamatan = $this->biodata->getKecamatanByKota($kota_id);
        echo json_encode($kecamatan);
    }





}