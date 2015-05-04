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

//Check to see if user is logged in, if not redirect to login page.
if ($_SESSION['auth'] != 1 && 
    basename($_SERVER['SCRIPT_FILENAME']) != 'login.php' &&
    basename($_SERVER['SCRIPT_FILENAME']) != 'instructor_request.php'
) {
    $_SESSION['return_url'] = basename($_SERVER['PHP_SELF']) . '?' . $_SERVER['QUERY_STRING'];
    header('Location: login.php');
    die();
}

//Connect to MySQL
$mysql = new Mysqlidb(MY_HOST, MY_USER, MY_PASS, MY_DATA);

//Load the config
$config = array();
foreach ($mysql->get('config') as $value) {
    $config[$value['ckey']] = $value['value'];
}

if (isset($config['year']) && isset($config['semester'])){
    $semester = $config['year'] . $config['semester'];
} else {
    $_SESSION['errors'][] = 'Year and semeseter need to be configured in the setup screen.';
}

//Admins do not check setup screen and do not realize when the configuration is incorrect.
if (!isset($_SESSION['messagesRead'])){
    $_SESSION['messagesRead'] = array();
}
if (
        $_SESSION['admin'] == 1 &&
        !in_array(1, $_SESSION['messagesRead']) &&
        (strtotime($config['open'] . ' ' . $config['openTime']) > time() || strtotime($config['close'] . ' ' . $config['closeTime']) < time())
   ) {
    $_SESSION['messages'][] = 'The Course Drop system is closed to students.';
    $_SESSION['messagesRead'][] = 1;
}
if (
        $_SESSION['admin'] == 1 &&
        !in_array(2, $_SESSION['messagesRead']) &&
        (strtotime($config['iopen'] . ' ' . $config['iopenTime']) > time() || strtotime($config['iclose'] . ' ' . $config['icloseTime']) < time())
   ) {
    $_SESSION['messages'][] = 'The Course Drop system is closed to instructors.';
    $_SESSION['messagesRead'][] = 2;
}
if (isset($_GET['messagesRead'])){
    $_SESSION['messagesRead'][] = (int)$_GET['messagesRead'];
}