<?php
defined('BASEPATH') or exit('No direct script access allowed');

// File: application/helpers/alert_helper.php

function show_sweet_alert($success, $message)
{
    $status = $success ? 'success' : 'error';
    $data = [
        'status' => $status,
        'message' => $message
    ];
    echo json_encode($data);
}