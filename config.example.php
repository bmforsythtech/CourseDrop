<?php

//MySQL Configuration
define('MY_HOST', 'localhost');
define('MY_USER', 'coursedrop');
define('MY_PASS', 'password');
define('MY_DATA', 'coursedrop');

//LDAP Configuration
define('LDAP_SERVER', 'ldap://127.0.0.1'); //Server address.  ldaps:// for secure
define('LDAP_PORT', '389'); //Port 636 for secure
define('LDAP_SEARCHDN', 'ou=Users,dc=domain,dc=edu'); //Directory where your users are stored
define('LDAP_PRN', 'domain' . "\\"); //Your domain prefix. Ex: forsythtech
define('LDAP_FILTER', 'sAMAccountName');

define('LDAP_ID', 'employeeID'); //Active Directory attribute where your student/employee ID's are stored.
define('LDAP_INSTRUCTOR', 'LDAPGroupName'); //If the user is in this active directory group, they will be logged in as an Instructor

//Local folder assignments
define('DIR_VIEWS', 'views/');
define('DIR_CLASSES', 'classes/');
define('DIR_FUNCTIONS', 'functions/');
define('DIR_INCLUDES', 'includes/');

//How often are instructors reminded via email that they need to fill out their portion of the drop form.
define('ALERT_INT', 86400); //In seconds

//Emails
define('EMAIL_FROM', 'webmaster@domain.edu'); //This system will send emails from
define('EMAIL_REPLY', 'no-reply@domain.edu'); //Reply to
define('EMAIL_RECORDS', 'records@domain.edu'); //Records Office email

//Debug
define('DEBUG_EMAILS', "admin1@domain.edu,admin2@domain.edu"); //Send debug emails to
define('DEBUG_FROM', 'webmaster@domain.edu'); //Debug email from
define('DEBUG', false); //Switch debug on/off.

// Array of LDAP accounts desinated as admins.  These users will be logged in with administrator rights
$admins = array(
    'admin1',
    'admin2'
);

//Desinated names for form status.
$statuses = array(
    '1' => 'Student Filed Request',
    '2' => 'Instructor Reviewed',
    '3' => 'Records Approved'
);

//Used on the forms.php page, breaks down forms by student last name within the defined ranges.
$view_filters = array(
    'AB' => 'A-B',
    'CF' => 'C-F',
    'GH' => 'G-H',
    'IO' => 'I-O',
    'PW' => 'P-W',
    'XZ' => 'X-Z'
);
