<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'instructor.php');

//Check to see if this is a form submission.
if (empty($_SESSION['studentsToDrop'])) {
    $_SESSION['errors'][] = 'There was an error submitting the form.';
    unset($_SESSION['studentsToDrop']);
    header('Location: instructor.php');
    exit();
}

//Sort it stack it
if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        list ($type, $sid) = explode('_', $key);
        switch ($type) {
            case ('reasons'):
                if(empty($value)) $_SESSION['errors'][] = 'Reasons must be filled in for sid: ' . $sid;
                $_SESSION['studentsToDrop'][$sid]['reasons'] = $value;
                break;
            case ('lastdate'):
                if(empty($value)) $_SESSION['errors'][] = 'Last date of attendance must be filled in for sid: ' . $sid;
                $_SESSION['studentsToDrop'][$sid]['lastdate'] = $value;
                break;
            case ('grade'):
                if(empty($value)) $_SESSION['errors'][] = 'Grade must be filled in for sid: ' . $sid;
                $_SESSION['studentsToDrop'][$sid]['grade'] = $value;
                break;
            case ('comments'):
                $_SESSION['studentsToDrop'][$sid]['comments'] = $value;
                break;
        }
    }
    
    if (!empty($_SESSION['errors'])) {
        header('Location: confirm_instructor.php');
        exit();
    }
    
    header('Location: confirm2_instructor.php');
    exit();
}

include(DIR_VIEWS . 'header.php');
include(DIR_VIEWS . 'confirm2_instructor.php');
include(DIR_VIEWS . 'footer.php');
