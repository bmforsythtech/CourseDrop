<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');

//LDAP process needs to be reworked to not depend on service account.

$errors = array();
if ($_SESSION['auth'] != 1) {
    if ((isset($_POST['username'])) && (isset($_POST['password']))) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $filter = "samaccountname=$username";

        if (empty($password) || empty($username)) {
            array_push($errors, 'Username and/or Password was incorrect, please try agian.');
        }

        if (!($connect = ldap_connect(LDAP_IP))) {
            array_push($errors, 'Error #1, please contact webmaster@forsythtech.edu with this message.');
        }

        if (!($bind = ldap_bind($connect, LDAP_BASEDN, LDAP_BINDPW))) {
            array_push($errors, 'Error #2, please contact webmaster@forsythtech.edu with this message.');
        }

        $search = ldap_search($connect, LDAP_SEARCHDN, $filter);

        if (ldap_count_entries($connect, $search) != 1) {
            array_push($errors, 'Username and/or Password was incorrect, please try agian.');
        }

        $info = ldap_get_entries($connect, $search);

        $bind = @ldap_bind($connect, $info[0][dn], $password);

        if (!$bind || !isset($bind)) {
            array_push($errors, 'Username and/or Password was incorrect, please try agian.');
        }

        //Strip all extra info.
        $matches = array();
        if (preg_match('/^(\d+)/', $info[0]["description"][0], $matches)){
            $sid = $matches[1];
        } else {
            array_push($errors, 'Could not find ID.  Please contact the Records Office.');
        }
        
        if (empty($errors)) {
            $_SESSION['fullname'] = trim($info[0]["displayname"][0]);
            $_SESSION['lastname'] = trim($info[0]["sn"][0]);
            $_SESSION['firstname'] = trim($info[0]["givenname"][0]);
            $_SESSION['sid'] = $sid;
            $_SESSION['email'] = trim($info[0]["mail"][0]);
            $_SESSION['username'] = trim($info[0]["samaccountname"][0]);

            $_SESSION['auth'] = 1;
            
            foreach ($info[0]['memberof'] as $disgroups) {
                if (preg_match('/CN=ll-webmasters/i', $disgroups)) {
                    //$_SESSION['admin'] = 1;
                }
                if (preg_match('/CN=const-administration/i', $disgroups)) {
                    $_SESSION['instructor'] = 1;
                }
            }

            foreach ($admins as $admin) {
                if ($_SESSION['username'] == $admin) {
                    $_SESSION['admin'] = 1;
                }
            }

            if (!empty($_SESSION['return_url'])) {
                header('Location: /' . $_SESSION['return_url']);
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
        header('Location: /' . $_SESSION['return_url']);
        unset($_SESSION['return_url']);
        die();
    } else {
        header('Location: form.php');
        die();
    }
}

include(DIR_VIEWS . 'header.php');

if (strtotime($config['open']) > time() ||
        strtotime($config['close']) < time()
) {
    include(DIR_VIEWS . 'form.closed.php');
}

include(DIR_VIEWS . 'login.php');
include(DIR_VIEWS . 'footer.php');
