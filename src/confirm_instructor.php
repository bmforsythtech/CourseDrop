<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'instructor.php');

//Check to see if this is a form submission.
if (empty($_POST['students']) && empty($_SESSION['studentsToDrop'])) {
    $_SESSION['errors'][] = 'You must select at least one student to proceed.';
    unset($_SESSION['studentsToDrop']);
    header('Location: instructor.php');
    exit();
}

//Stack it up in the Session
if (isset($_POST['students']) && !empty($_POST['students'])) {
    foreach ($_POST['students'] as $student) {
        //Get course information from database
        $query = "SELECT C.course, C.name, U.firstname, U.lastname, U.username, U.email, S.user_id FROM students S LEFT JOIN courses C ON C.course = S.course LEFT JOIN users U ON S.user_id = U.user_id WHERE S.user_id LIKE ? AND C.course = ? AND S.semester = ?";

        $params = array($student, $_SESSION['icourse'], $semester);
        $result = $mysql->rawQuery($query, $params);

        $_SESSION['studentsToDrop'][$student] = $result[0];
    }

    //Redirect so we're not sitting on a POST
    header('Location: confirm_instructor.php');
    exit();
}

include(DIR_VIEWS . 'header.php');
include(DIR_VIEWS . 'confirm_instructor.php');
include(DIR_VIEWS . 'footer.php');
