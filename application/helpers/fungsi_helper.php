<?php

function cek_login($level = null)
{
    $ci = get_instance();
	$userdata = $ci->session->userdata('login_session');
	if ($userdata['role'] != $level) {
		redirect('404');	
	}
}
// function is_admin()
// {
//     $ci = get_instance();
//     $role = $ci->session->userdata('login_session')['role_id'];

//     $status = true;

//     if ($role != '1') {
//         $status = false;
//     }

//     return $status;
// }

function set_pesan($pesan, $tipe = true)
{
    $ci = get_instance();
    if ($tipe) {
        $ci->session->set_flashdata('pesan', "<div class='alert alert-success'><strong></strong> {$pesan} <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    } else {
        $ci->session->set_flashdata('pesan', "<div class='alert alert-danger'><strong></strong> {$pesan} <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
    }
}

function userdata($field, $date_format = null)
{
    $ci = get_instance();
    $ci->load->model('Admin_model', 'admin');

    $role = $ci->session->userdata('login_session')['role'];

    if ($role == 'Administrator') {
        $userId = $ci->session->userdata('login_session')['user'];
        $data = $ci->admin->userdata($userId);
        // var_dump($data);
        // die;
    } elseif ($role == 'Member') {
        $memberId = $ci->session->userdata('login_session')['user'];
        $data = $ci->admin->userdata($memberId);
    }

    return $data[$field];
}


function output_json($data)
{
    $ci = get_instance();
    $data = json_encode($data);
    $ci->output->set_content_type('application/json')->set_output($data);
}