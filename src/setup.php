<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'admin.php');

if (!empty($_POST)){
    $data = array();
    foreach ($config as $key=>$value){
        if (isset($_POST[$key])){
            $mysql->where('ckey', $key);
            $mysql->update('config', array('value' => $_POST[$key]));
        }
    }
    
    writelog(NULL, print_r($_POST, TRUE));
    
    $_SESSION['messages'][] = 'Settings saved.';
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

//Load unique divisions
$divisions = array();
$query = "SELECT division FROM divisions WHERE division != ? AND semester = ? GROUP BY division";
$params = array('', $semester);
$results = $mysql->rawQuery($query, $params);
foreach ($results as $result) {
    $divisions[$result['division']] = $config['deanfor' . strtolower($result['division'])];
}

include(DIR_VIEWS . 'header.php');
include(DIR_VIEWS . 'setup.php');
include(DIR_VIEWS . 'footer.php');