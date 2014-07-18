<?php

session_start();

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    session_destroy();
    unset($_SESSION);
    session_start();
    $_SESSION['messages'] = array('Logout successful.');
}

//Required files
require_once(DIR_CLASSES . 'mysql.php');
require_once(DIR_FUNCTIONS . 'emails.php');
require_once(DIR_FUNCTIONS . 'logs.php');

//Determine current semester
if (date('n') >= 1 && date('n') <= 4) {
    $semester = date('Y') . 'SP';
}
if (date('n') >= 5 && date('n') <= 7) {
    $semester = date('Y') . 'SU';
}
if (date('n') >= 8 && date('n') <= 12) {
    $semester = date('Y') . 'FA';
}

//Check to see if user is logged in, if not redirect to login page.
if ($_SESSION['auth'] != 1 && 
    basename($_SERVER['SCRIPT_FILENAME']) != 'index.php' &&
    basename($_SERVER['SCRIPT_FILENAME']) != 'instructor_request.php'
) {
    $_SESSION['return_url'] = basename($_SERVER['PHP_SELF']) . '?' . $_SERVER['QUERY_STRING'];
    header('Location: index.php');
    die();
}

//Connect to MySQL
$mysql = new Mysqlidb(MY_HOST, MY_USER, MY_PASS, MY_DATA);

//Load the config
$config = array();
foreach ($mysql->get('config') as $value) {
    $config[$value['ckey']] = $value['value'];
}