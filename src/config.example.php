<?php

define('MY_HOST', 'localhost');
define('MY_USER', 'username');
define('MY_PASS', 'password');
define('MY_DATA', 'database');

define('LDAP_IP', '255.255.255.255');
define('LDAP_BASEDN', 'cn=User,cn=Users,dc=domain,dc=com');
define('LDAP_BINDPW', 'password');
define('LDAP_SEARCHDN', 'ou=Users,dc=domain,dc=com');

define('DIR_VIEWS', 'views/');
define('DIR_CLASSES', 'classes/');
define('DIR_FUNCTIONS', 'functions/');
define('DIR_INCLUDES', 'includes/');

define('ALERT_INT', 86400);

$admins = array(
    'username1',
    'username2',
    'username3'
);
$statuses = array(
    '1' => 'Student Filed Request',
    '2' => 'Instructor Reviewed',
    '3' => 'Records Approved'
);
$view_filters = array(
    'AC' => 'A-B',
    'CG' => 'C-F',
    'GI' => 'G-H',
    'IP' => 'I-O',
    'PX' => 'P-W',
    'XA' => 'X-Z'
);

//Email Setup
//$debugemail = 'user@domain.com'; //Uncomment this and set to debug email.