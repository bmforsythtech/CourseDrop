<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');

if (strtotime($config['open']) > time() ||
        strtotime($config['close']) < time()
) {
    include(DIR_VIEWS . 'header.php');
    include(DIR_VIEWS . 'form.closed.php');
    include(DIR_VIEWS . 'footer.php');
    exit();
}

//Clear Dropped Courses
if (isset($_SESSION['form_ids'])){
    unset($_SESSION['form_ids']);
}

//Get course information from database
$query = "SELECT C.course, C.name, C.end_date, U.firstname, U.lastname FROM students S LEFT JOIN courses C ON C.course = S.course LEFT JOIN instructors I ON S.course = I.course LEFT JOIN users U ON I.user_id = U.user_id WHERE S.user_id LIKE ? AND S.semester = ? AND S.available = ?";

$params = array($_SESSION['sid'], $semester, 'Y');
$data = $mysql->rawQuery($query, $params);

//Not the best way...
$query = "SELECT course FROM forms WHERE studentid LIKE ? AND semester = ?";

$params = array($_SESSION['sid'], $semester);
$results = $mysql->rawQuery($query, $params);

foreach ($results as $course) {
    $droppedCourses[] = $course['course'];
}

//Instructor check.  If user is marked as instructor and not enrolled in any courses, redirect them to the instructor page.
if ($_SESSION['instructor'] == 1 && empty($data)) {
    header('Location: instructor.php');
    exit();
}

include(DIR_VIEWS . 'header.php');

if (empty($data)) {
    include(DIR_VIEWS . 'form.empty.php');
} elseif (count($droppedCourses) == count($data)) {
    include(DIR_VIEWS . 'form.history.php');
} else {
    include(DIR_VIEWS . 'form.php');
}

include(DIR_VIEWS . 'footer.php');
?>