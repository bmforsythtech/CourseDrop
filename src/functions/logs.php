<?php

function writelog($id, $message) {
    global $mysql;

    $data = array();

    if (!empty($id)) {
        $data['form_id'] = $id;
    }

    $data['form_id'] = $id;
    $data['message'] = $message;
    $data['time'] = time();

    if (!empty($_SESSION['sid']))
        $data['pid'] = $_SESSION['sid'];
    if (!empty($_SESSION['fullname']))
        $data['name'] = $_SESSION['fullname'];
    if (!empty($_SERVER['REMOTE_ADDR']))
        $data['ip'] = $_SERVER['REMOTE_ADDR'];

    return $mysql->insert('logs', $data);
}

function writeerror($message) {
    global $mysql;

    $data = array();

    $data['message'] = $message;
    $data['time'] = time();

    if (!empty($_SESSION['sid']))
        $data['pid'] = $_SESSION['sid'];
    if (!empty($_SESSION['fullname']))
        $data['name'] = $_SESSION['fullname'];
    if (!empty($_SERVER['REMOTE_ADDR']))
        $data['ip'] = $_SERVER['REMOTE_ADDR'];

    return $mysql->insert('errorlogs', $data);
}

?>