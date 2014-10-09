<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'instructor.php');

if (strtotime($config['iopen']) > time() ||
        strtotime($config['iclose']) < time()
) {
    include(DIR_VIEWS . 'header.php');
    include(DIR_VIEWS . 'form.closed.php');
    include(DIR_VIEWS . 'footer.php');
    exit();
}

if (isset($_GET['c']) && !empty($_GET['c'])) {
    unset($_SESSION['studentsToDrop']);
    $_SESSION['icourse'] = $_GET['c'];
    $query = "SELECT S.user_id, U.firstname, U.lastname, U.email, U.username FROM students S LEFT JOIN users U ON S.user_id = U.user_id WHERE S.course = ? AND S.semester = ? AND S.available = ? ORDER BY U.lastname";

    $params = array($_SESSION['icourse'], $semester, 'Y');
    $data = $mysql->rawQuery($query, $params);

    $processed = array();
    $query = "SELECT studentid FROM forms WHERE course = ? AND semester = ? AND deleted = 0";

    $params = array($_SESSION['icourse'], $semester);
    $results = $mysql->rawQuery($query, $params);

    foreach ($results as $result) {
        $processed[] = $result['studentid'];
    }
} else {
    $query = "SELECT C.name, I.course FROM instructors I LEFT JOIN courses C ON C.course = I.course WHERE I.user_id LIKE ? AND C.semester = ? ORDER BY I.course";

    $params = array($_SESSION['sid'], $semester);
    $data = $mysql->rawQuery($query, $params);

    $query = "SELECT id, semester, status, firstname, lastname, course, course_name, studentid, status FROM forms WHERE instructorid = ? AND deleted = ? ORDER BY id DESC";

    $params = array($_SESSION['sid'], 0);
    $history = $mysql->rawQuery($query, $params);
}

include(DIR_VIEWS . 'header.php');

if (isset($_GET['c']) && !empty($_GET['c']) && !empty($data)) {
    include(DIR_VIEWS . 'form.instructor.php');
} else {
    unset($_SESSION['icourse']);
    include(DIR_VIEWS . 'instructor.php');
}

include(DIR_VIEWS . 'footer.php');
?>