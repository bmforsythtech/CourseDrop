<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'instructor.php');

foreach ($_SESSION['studentsToDrop'] as $sid => $student) {
    $query = "SELECT user_id, username, firstname, lastname, email FROM users WHERE user_id = ?";

    $params = array($_SESSION['sid']);
    $iresult = $mysql->rawQuery($query, $params);

    $query = "SELECT division FROM divisions WHERE semester = ? AND course = ?";

    $params = array($semester, $student['course']);
    $dresult = $mysql->rawQuery($query, $params);
    
    if(empty($dresult[0]['division'])) $dresult[0]['division'] = '';
    
    $data = array();
    $data['status'] = $statuses[2];
    $data['status_code'] = '2';
    $data['semester'] = $semester;
    $data['firstname'] = $student['firstname'];
    $data['lastname'] = $student['lastname'];
    $data['username'] = $student['username'];
    $data['studentemail'] = $student['email'];
    $data['studentid'] = $sid;
    $data['course'] = $student['course'];
    $data['course_name'] = $student['name'];
    $data['reasons'] = $student['reasons'];
    $data['grade'] = $student['grade'];
    $data['lastdate'] = $student['lastdate'];
    $data['comments'] = $student['comments'];
    $data['instructorid'] = $iresult[0]['user_id'];
    $data['instructorname'] = $iresult[0]['firstname'] . ' ' . $iresult[0]['lastname'];
    $data['instructoremail'] = $iresult[0]['email'];
    $data['officialwithdrawal'] = time();
    $data['rdue'] = time() + ALERT_INT;
    $data['division'] = $dresult[0]['division'];

    $formID = $mysql->insert('forms', $data);
    if (!empty($formID)) {
        $_SESSION['formids'][$sid] = $formID;

        $data['id'] = $formID;

        writelog($data['id'], 'Instructor submitted new drop request.');

        instructor_confirmation($data);
        records_alert($data);
    } else {
        $_SESSION['errors'][] = "Unable to submit form for student id: " . $sid;
    }
}

header('Location: confirmation_instructor.php');