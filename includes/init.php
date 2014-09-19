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

if (isset($config['year']) && isset($config['semester'])){
    $semester = $config['year'] . $config['semester'];
} else {
    $_SESSION['errors'][] = 'Year and semeseter need to be configured in the setup screen.';
}