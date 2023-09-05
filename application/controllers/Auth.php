<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->library('form_validation');
        $this->load->model('M_login', 'login');
        $this->load->model('Admin_model', 'admin');
    }


    private function _has_login()
    {
        if ($this->session->userdata('login_session')) 
        {
            $data_user = $this->session->userdata('login_session');
            if ($data_user['role'] == 'Administrator') 
            {
                redirect('admin/dashboard');
            } elseif ($data_user['role'] == 'Member') 
            {
                redirect('user/dashboard');
            }
        }
    }


    public function index()
    {
        $this->_has_login();
        $this->load->helper('captcha');
        $vals = array(
            // 'word'          => 'Random word',
            'img_path'      => './captcha-images/',
            'img_url'       => base_url().'captcha-images/',
            'font_path'     => './path/to/fonts/texb.ttf',
            'img_width'     => '150',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 8,
            'font_size'     => 16,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz',

            // White background and border, black text and red grid
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('captcha', 'Captcha', 'required|trim');

        if ($this->form_validation->run() == false) 
        {
            $cap = create_captcha($vals);
            $image = $cap['image'];
            $captcha_word = $cap['word'];
            $this->session->set_userdata('captchaword', $captcha_word);
            $data['title'] = 'Login Aplikasi';
            $data['captcha_image'] = $image;
            $this->template->load('templates/auth', 'auth/login', $data);
        } else 
        {
            $input = $this->input->post(null, true);
            $user_captcha = $this->input->post('captcha');
            $stored_captcha = $this->session->userdata('captchaword');
            $user = $this->db->get_where('user', ['username' => $input['username']])->row_array();
            
            if($user_captcha == $stored_captcha)
            {
                $cek_username = $this->login->cek_username($input['username']);
                if ($user['is_active'] == 1) {
                    if (!empty($cek_username)) 
                    {
                        $password = $this->login->get_password($input['username']);
                        
                        if (password_verify($input['password'], $password)) 
                        {
                            $clean_role = htmlspecialchars($cek_username['role']);
                            $user_db = $this->login->userdata($input['username']);
                                $userdata = [
                                    'user'  => $user_db['id_user'],
                                    'role'  => $cek_username['role'],
                                    'timestamp' => time(),
                                    'log' => date('H:i:s')
                                ];
                            $data = $this->session->set_userdata('login_session', $userdata);
                            $response = [
                            'status' => 'success',
                            'redirect' => ($clean_role == 'Administrator') ? 'admin/dashboard' : 'user/dashboard'
                        ];
                        } else 
                        {
                            $response = [
                                'status' => 'error',
                                'msg' => 'Mohon periksa password anda lagi!'
                            ];
                        }
                    } else 
                    {
                        $response = [
                            'status' => 'error',
                            'msg' => 'Username tidak terdaftar!'
                        ];
                    }
                } else {
                     $response = [
                            'status' => 'error',
                            'msg' => 'Email belum teraktivasi!'
                        ];
                }
            } else 
            {
                $cap = create_captcha($vals);
                $captcha_word = $cap['word'];

                $this->session->set_userdata('captchaword', $captcha_word);

                $response = [
                    'status' => 'error',
                    'msg' => 'Kode CAPTCHA yang Anda masukkan salah.'
                ];
            }
            echo json_encode($response);
        }
    }

    public function newCaptcha()
    {
        $this->load->helper('captcha');
        $vals = array(
            // 'word'          => 'Random word',
            'img_path'      => './captcha-images/',
            'img_url'       => base_url().'captcha-images/',
            'font_path'     => './path/to/fonts/texb.ttf',
            'img_width'     => '150',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 8,
            'font_size'     => 16,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz',

            // White background and border, black text and red grid
            'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            )
        );

        $cap = create_captcha($vals);
        $image = $cap['image'];
        $captcha_word = $cap['word'];
        $this->session->set_userdata('captchaword', $captcha_word);
        echo $image;
    }

    
    public function logout()
    {
        $this->session->unset_userdata('login_session');

        set_pesan('Logout berhasil!');
        redirect('auth');
    }

    public function register()
    {
        $this->_has_login();
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]|alpha_numeric', [
            'is_unique' => 'Username ini sudah pernah terdaftar, silahkan ganti dengan username lain!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'matches' => 'Password tidak sama!',
            'min_length' => 'Password terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|trim|matches[password]');
        $this->form_validation->set_rules('name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email ini sudah pernah terdaftar, silahkan ganti dengan email lain!'
        ]);

        if ($this->form_validation->run() == false) 
        {
            $data['title'] = 'Register';
            $this->template->load('templates/auth', 'auth/register', $data);
        } 
        else 
        {
            $availablePhotos = ['default.jpg', 'default.png', 'profile.jpg', 'user.png'];
            $randomIndex = array_rand($availablePhotos);
            $randomPhoto = $availablePhotos[$randomIndex];

            $input = $this->input->post(null, true);
            unset($input['password2']);
            $input['username'] = htmlspecialchars($input['username']);
            $input['email'] = htmlspecialchars($input['email']);
            $input['name'] = htmlspecialchars($input['name']);
            $input['password'] = password_hash($input['password'], PASSWORD_DEFAULT);
            $input['role_id'] = 2;
            $input['is_active'] = 0;
            $input['photo'] = $randomPhoto;
            $input['date_created'] = time();

            // $token = base64_encode(random_bytes(32));
            $otp_code = rand(1000, 9999); // Contoh kode OTP 4 digit

            $user_token = [
                'email' => $input['email'],
                'token' => $otp_code,
                'date_created' => time()
            ];

            $query = $this->admin->insert('user', $input);
            $input_token = $this->admin->insert('user_token', $user_token);
            $userdata = $this->session->set_userdata('register_session', $user_token);
            if ($query && $input_token) 
            {
                $this->_sendEmail($otp_code, 'verify');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat! Akun berhasil dibuat. Silahkan aktifkan akun anda menggunakan OTP yang sudah kami kirim ke email anda!</div>');
                redirect('auth/verify');
            } 
            else 
            {
                set_pesan('Akun anda tidak berhasil teregistrasi', false);
                redirect('auth/register');
            }
        }
    }

    private function _sendEmail($otp_code, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'muhalfian271899@gmail.com',
            'smtp_pass' => 'vvabiemnietdngcu',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];
        

        $this->email->initialize($config);

        $this->email->from('muhalfian271899@gmail.com', 'BPJS Cabang Kota Magelang');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Kode OTP Anda');
            $this->email->message('Kode OTP Anda adalah: ' . $otp_code);
        } else if ($type == 'forgot') {
            $this->email->subject('ASKK ME account password request recovery');
            $this->email->message('Klik link ini untuk mereset password anda! : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Recovery Password</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }


    public function verify()
    {
        $this->form_validation->set_rules('otp_1', 'OTP', 'required|trim');
        $this->form_validation->set_rules('otp_2', 'OTP', 'required|trim');
        $this->form_validation->set_rules('otp_3', 'OTP', 'required|trim');
        $this->form_validation->set_rules('otp_4', 'OTP', 'required|trim');

        if ($this->form_validation->run() == false) 
        {
            $data['title'] = 'OTP Verification';
            $this->template->load('templates/otp', 'auth/otp', $data);
        } else 
        {
            $otp_1 = $this->input->post('otp_1');
            $otp_2 = $this->input->post('otp_2');
            $otp_3 = $this->input->post('otp_3');
            $otp_4 = $this->input->post('otp_4');

            $entered_otp = $otp_1 . $otp_2 . $otp_3 . $otp_4;
            $data = $this->session->userdata('register_session');
            $this->db->select('token');
            $this->db->where('email', $data['email']);
            $query = $this->db->get('user_token');
            
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $valid_otp = $row->token; // Kode OTP yang tersimpan di database
                $user_token = $this->db->get_where('user_token', ['token' => $data['token']])->row_array();
                if ($entered_otp === $valid_otp) {
                    if (time() - $user_token['date_created'] < (60 * 10)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $data['email']);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $data['email']]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $data['email'] . ' has been activated! Please login.</div>');
                    redirect('auth');
                } else 
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong OTP.</div>');
                    redirect('auth/verify');
                }
            } else 
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Cant match the OTP code.</div>');
                redirect('auth/verify');
            }
            }
        }
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->template->load('templates/auth', 'auth/forgot-password', $data);
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password!</div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered or activated!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }


    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong token.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong email.</div>');
            redirect('auth');
        }
    }
    
    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[6]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->template->load('templates/auth', 'auth/change-password', $data);
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->db->delete('user_token', ['email' => $email]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please login.</div>');
            redirect('auth');
        }
    }
}