<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'admin.php');

if ($_POST['submit'] == 'Switch User' && !empty($_POST['sid'])) {
    writelog(NULL, 'Switched to sid: ' . $_POST['sid'], 'Admin SID');
    $_SESSION['sid'] = $_POST['sid'];
    header('Location: form.php');
    die();
}

if (!empty($_GET['action'])) {
    switch ($_GET['action']){
        case 'removeInstructor':
            //writelog(NULL, 'Switched to Student View.', 'Admin SID');
            $_SESSION['instructor'] = 0;
            break;
        case 'addInstructor':
            //writelog(NULL, 'Switched to Instructor View.', 'Admin SID');
            $_SESSION['instructor'] = 1;
            break;
    }
    header('Location: admin.php');
    die();
}

//Get log entries
$query = "SELECT * FROM logs WHERE type = ? ORDER BY time DESC, id DESC LIMIT 50";
$params = array('Admin SID');
$logs = $mysql->rawQuery($query, $params);

include(DIR_VIEWS . 'header.php');
include(DIR_VIEWS . 'admin.php');
include(DIR_VIEWS . 'footer.php');
