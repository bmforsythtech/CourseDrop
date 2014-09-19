<?php

define('MY_HOST', 'localhost');
define('MY_USER', 'coursedrop');
define('MY_PASS', 'password');
define('MY_DATA', 'coursedrop');

define('LDAP_IP', '127.0.0.1');
define('LDAP_BASEDN', 'cn=Users,dc=domain,dc=edu');
define('LDAP_BINDPW', 'password');
define('LDAP_SEARCHDN', 'ou=Users,dc=domain,dc=edu');
define('LDAP_SERVER', '127.0.0.1');
define('LDAP_PRN', 'domain' . "\\");
define('LDAP_PORT', '389');
define('LDAP_DN', 'ou=Users,dc=domain,dc=edu');
define('LDAP_FILTER', 'sAMAccountName');

define('DIR_VIEWS', 'views/');
define('DIR_CLASSES', 'classes/');
define('DIR_FUNCTIONS', 'functions/');
define('DIR_INCLUDES', 'includes/');

define('ALERT_INT', 86400);

define('EMAIL_FROM', 'webmaster@domain.edu');
define('EMAIL_REPLY', 'no-reply@domain.edu');
define('EMAIL_RECORDS', 'records@domain.edu');

define('DEBUG_EMAILS', "admin1@domain.edu,admin2@domain.edu");
define('DEBUG_FROM', 'webmaster@domain.edu');
define('DEBUG', false);

$admins = array(
    'admin1',
    'admin2'
);
$statuses = array(
    '1' => 'Student Filed Request',
    '2' => 'Instructor Reviewed',
    '3' => 'Records Approved'
);
$view_filters = array(
    'AB' => 'A-B',
    'CF' => 'C-F',
    'GH' => 'G-H',
    'IO' => 'I-O',
    'PW' => 'P-W',
    'XZ' => 'X-Z'
);
