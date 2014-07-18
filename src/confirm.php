<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');

//Check to see if this is a form submission.
$errors = array();
if (empty($_POST['courses'])) {
    $errors[] = 'You must select at least one course to proceed.';
}
if (empty($_POST['veteran'])) {
    $errors[] = 'You must answer the question about your veteran status to proceed.';
}
if (empty($_POST['reasons']) && empty($_POST['reasons_other'])) {
    $errors[] = 'You must select at least one reason to proceed.';
}

if (!empty($errors)){
    $_SESSION['errors'] = $errors;
    header('Location: form.php');
    exit();
}

//Stack it up in the Session
$_SESSION['coursesToDrop'] = $_POST['courses'];
$_SESSION['reasonsToDrop'] = $_POST['reasons'];
if (!empty($_POST['reasons_other'])) {
    $_SESSION['reasonsToDrop'][] = $_POST['reasons_other'];
}
$_SESSION['veteran'] = $_POST['veteran'];

//Get course information from database
$query = "SELECT C.course, C.name, U.firstname, U.lastname FROM students S LEFT JOIN courses C ON C.course = S.course LEFT JOIN instructors I ON S.course = I.course LEFT JOIN users U ON I.user_id = U.user_id WHERE S.user_id LIKE ? AND S.semester = ? AND S.available = ?";

$params = array($_SESSION['sid'], $semester, 'Y');
$results = $mysql->rawQuery($query, $params);

$data = array();
foreach ($results as $result) {
    if (in_array($result['course'], $_SESSION['coursesToDrop'])) {
        $data[] = $result;
    }
}

//$query = "SELECT id FROM forms WHERE studentid LIKE ? AND semester = ?";

//$params = array($_SESSION['sid'], $semester);
//$forms = $mysql->rawQuery($query, $params);

//Is student dropping all courses?
//if ((count($_SESSION['coursesToDrop']) + count($forms)) >= count($results)) {
if ((count($_SESSION['coursesToDrop'])) >= count($results)) {
    $_SESSION['droppingAll'] = 1;
} else {
    $_SESSION['droppingAll'] = 0;
}

include(DIR_VIEWS . 'header.php');
include(DIR_VIEWS . 'confirm.php');
include(DIR_VIEWS . 'footer.php');
