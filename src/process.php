<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');

//Check to see if this is a form submission.
if (empty($_SESSION['coursesToDrop'])) {
    $errors[] = 'You must select at least one course to drop.';
    $_SESSION['errors'] = $errors;
    header('Location: form.php');
    exit();
}

$_SESSION['phone'] = (isset($_POST['phone'])) ? $_POST['phone'] : '';
$_SESSION['form_ids'] = array();

//Get Course Info
$sentdropall = false;
foreach ($_SESSION['coursesToDrop'] as $course) {
    $query = "SELECT user_id, username, firstname, lastname, email FROM users WHERE user_id = ?";

    $params = array($_SESSION['sid']);
    $sresult = $mysql->rawQuery($query, $params);

    $query = "SELECT C.course, C.name, I.user_id FROM courses C LEFT JOIN instructors I ON C.course = I.course AND C.semester = I.semester WHERE C.course = ? AND C.semester = ?";

    $params = array($course, $semester);
    $cresult = $mysql->rawQuery($query, $params);

    $query = "SELECT user_id, username, firstname, lastname, email FROM users WHERE user_id = ?";

    //TODO: Check to see if Instructor was found.

    $params = array($cresult[0]['user_id']);
    $iresult = $mysql->rawQuery($query, $params);
    
    $query = "SELECT division FROM divisions WHERE semester = ? AND course = ?";

    $params = array($semester, $cresult[0]['course']);
    $dresult = $mysql->rawQuery($query, $params);
    
    if(empty($dresult[0]['division'])) $dresult[0]['division'] = '';

    //TODO - Duplicate Check
    //$query = "SELECT id FROM forms WHERE semester = ? AND course = ?";
    //$params = array($semester, $cresult[0]['course']);
    //$dresult = $mysql->rawQuery($query, $params);
        
    $data = array();
    $data['status'] = $statuses[1];
    $data['status_code'] = '1';
    $data['semester'] = $semester;
    $data['firstname'] = $sresult[0]['firstname'];
    $data['lastname'] = $sresult[0]['lastname'];
    $data['studentemail'] = $sresult[0]['email'];
    $data['studentid'] = $sresult[0]['user_id'];
    $data['username'] = $sresult[0]['username'];
    $data['phone'] = $_SESSION['phone'];
    $data['course'] = $cresult[0]['course'];
    $data['course_name'] = $cresult[0]['name'];
    $data['reasons'] = implode(", ", $_SESSION['reasonsToDrop']);
    $data['instructorid'] = $iresult[0]['user_id'];
    $data['instructorname'] = $iresult[0]['firstname'] . ' ' . $iresult[0]['lastname'];
    $data['instructoremail'] = $iresult[0]['email'];
    $data['officialwithdrawal'] = time();
    $data['tuid'] = md5(uniqid(rand(), true));
    $data['idue'] = mktime(date("H"), date("i"), date("s"), date("n"), date("j") + 1, date("Y"));
    $data['veteran'] = $_SESSION['veteran'];
    $data['division'] = $dresult[0]['division'];

    $insert_id = $mysql->insert('forms', $data);

    if (!empty($insert_id)) {
        $_SESSION['form_ids'][] = $insert_id;

        $data['id'] = $insert_id;

        writelog($data['id'], 'Student submitted new drop request.');

        student_confirmation($data);
        instructor_request($data);
        
        //Send Email to Student Services/Financial Aid
        if (!empty($_SESSION['droppingAll']) && !$sentdropall) {
            drop_all($data);
            $sentdropall = true;
        }
    } else {
        $_SESSION['errors'][] = 'Could not submit form.';
    }
}

//Redirect
if (empty($_SESSION['errors'])) {
    header('Location: confirmation.php');
    unset($_SESSION['coursesToDrop']);
    writeerror(print_r($_SESSION['errors'], true) . " DATA:" . print_r($data, true));
    exit();
} else {
    header('Location: form.php');
    exit();
}
?>