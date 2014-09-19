<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');

if ($_SESSION['instructor'] != 1) {
    $_SESSION['errors'][] = 'Must be instructor to view forms';
    include('header.php');
    include('footer.php');
    die();
}

if (isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];

    $query = "SELECT * FROM forms WHERE id = ? AND instructorid = ?";

    $params = array($_SESSION['id'], $_SESSION['sid']);
    $data = $mysql->rawQuery($query, $params);
    $data = $data[0];

    $query = "SELECT * FROM logs WHERE form_id = ? ORDER BY time DESC, id DESC";

    $params = array($data['id']);
    $logs = $mysql->rawQuery($query, $params);

    $_SESSION['courseinfo'] = $data;
}

include(DIR_VIEWS . 'header.php');

if (!empty($data)) {
    include(DIR_VIEWS . 'form.view.instructor.php');
}

include(DIR_VIEWS . 'footer.php');
?>