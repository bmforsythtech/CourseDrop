<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');

//Get course information from database
$data = array();
foreach ($_SESSION['form_ids'] as $form_id) {
    $query = "SELECT id, course, course_name, instructorname FROM forms WHERE id = ?";

    $params = array($form_id);
    $result = $mysql->rawQuery($query, $params);

    $data[] = $result[0];
}

include(DIR_VIEWS . 'header.php');
include(DIR_VIEWS . 'confirmation.php');
include(DIR_VIEWS . 'footer.php');
