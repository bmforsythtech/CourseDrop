<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'admin.php');

if ($_POST['submit'] == 'Switch User' && !empty($_POST['sid'])) {
    writelog(NULL, 'Switched to sid: ' . $_POST['sid']);
    $_SESSION['sid'] = $_POST['sid'];
    header('Location: form.php');
    die();
}

include(DIR_VIEWS . 'header.php');
include(DIR_VIEWS . 'admin.php');
include(DIR_VIEWS . 'footer.php');
