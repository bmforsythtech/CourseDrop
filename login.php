<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');

$errors = array();
$messages = array();
if ((isset($_POST['username'])) && (isset($_POST['password']))) {
    $username = LDAP_PRN . $_POST['username'];
    $password = $_POST['password'];
    $filter = "(" . LDAP_FILTER . "=" . $_POST['username'] . ")";

    if (empty($password) || empty($username)) {
        array_push($errors, 'Username and/or Password was incorrect, please try agian.');
    }

    if (!($connect = ldap_connect(LDAP_SERVER, LDAP_PORT))) {
        array_push($errors, 'Error #1, please contact ' . DEBUG_FROM . ' with this message.');
    }
    
    if (LDAP_TLS){
        if (!ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3)){
            array_push($errors, 'Error #2, please contact ' . DEBUG_FROM . ' with this message.');
        }
        if (!ldap_set_option($connect, LDAP_OPT_REFERRALS, 0)){
            array_push($errors, 'Error #3, please contact ' . DEBUG_FROM . ' with this message.');
        }
        if (!ldap_start_tls($connect)){
            array_push($errors, 'Error #4, please contact ' . DEBUG_FROM . ' with this message.');
        }
    }

    if (!($bind = ldap_bind($connect, $username, $password))) {
        array_push($errors, 'The username or password you entered is incorrect. Visit <a href="' . HELP_URL . '" target="_blank">' . HELP_URL . '</a> for help with logging in.');
    }
    
    if (!empty($errors)) {
        //Load errors into session
        $_SESSION['errors'] = $errors;
        $_SESSION['messages'] = $messages;
        header('Location: login.php');
        die();
    } else {
        $result = ldap_search($connect,LDAP_SEARCHDN,$filter);
        ldap_sort($connect,$result,"sn");
        $info = ldap_get_entries($connect, $result);
        
        ldap_close($connect);
        
        for ($i=0; $i<$info["count"]; $i++){
            if($info['count'] > 1) break;
            
            //Strip all extra info.
            $matches = array();
            if (preg_match('/^(\d+)/', $info[$i][LDAP_ID][0], $matches)){
                $sid = $matches[1];
            } else {
                array_push($errors, 'Could not find ID.  Please contact the Records Office.');
                header('Location login.php');
                die();
            }
            
            $_SESSION['fullname'] = trim($info[$i]["displayname"][0]);
            $_SESSION['lastname'] = trim($info[$i]["sn"][0]);
            $_SESSION['firstname'] = trim($info[$i]["givenname"][0]);
            $_SESSION['sid'] = $sid;
            $_SESSION['email'] = trim($info[$i]["mail"][0]);
            $_SESSION['username'] = trim($info[$i]["samaccountname"][0]);
            $_SESSION['auth'] = 1;
            
            foreach ($info[$i]['memberof'] as $disgroups) {
                if (preg_match('/CN=' . LDAP_INSTRUCTOR . '/i', $disgroups)) {
                    $_SESSION['instructor'] = 1;
                }
            }
            
            //Admin check - admins array set in config.php
            foreach ($admins as $admin) {
                if ($_SESSION['username'] == $admin) {
                    $_SESSION['admin'] = 1;
                    header('Location: view_form.php');
                    die();
                }
            }
            
            if (!empty($_SESSION['return_url'])) {
                header('Location: ' . $_SESSION['return_url']);
                unset($_SESSION['return_url']);
                die();
            } else {                
                header('Location: form.php');
                die();
            }
        }
    }
}

if ($_SESSION['auth'] == 1) {
    if (!empty($_SESSION['return_url'])) {
        header('Location: ' . $_SESSION['return_url']);
        unset($_SESSION['return_url']);
        die();
    } else {
        header('Location: form.php');
        die();
    }
}

include(DIR_VIEWS . 'header.php');
include(DIR_VIEWS . 'login.php');
include(DIR_VIEWS . 'footer.php');