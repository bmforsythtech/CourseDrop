<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'admin.php');

//Don't reuse search
unset($_SESSION['filter']['search']);

//Page filters
if (isset($_GET['filter']))
    $_SESSION['filter']['filter'] = $_GET['filter'];
if (isset($_GET['status']))
    $_SESSION['filter']['status'] = $_GET['status'];
if (isset($_GET['semester']))
    $_SESSION['filter']['semester'] = $_GET['semester'];
if (isset($_GET['search']))
    $_SESSION['filter']['search'] = trim($_GET['search']);
//Get list of semesters
$query = "SELECT semester FROM forms GROUP BY semester ORDER BY id DESC LIMIT 5;";
$semestersList = $mysql->rawQuery($query);

if (isset($_POST['approve'])) {
    $data = array(
        'status' => $statuses[3],
        'status_code' => '3'
    );

    $mysql->where('id', $_SESSION['id']);
    $result = $mysql->update('forms', $data);

    if (empty($result)) {
        $_SESSION['errors'][] = 'There was an error submitting the form';
        header('Location: /' . basename($_SERVER['SCRIPT_NAME']) . '?id=' . $_SESSION['id']);
        exit();
    } else {
        student_processed($_SESSION['courseinfo']);
        instructor_processed($_SESSION['courseinfo']);
        veteran_check($_SESSION['courseinfo']);
        deans_processed($_SESSION['courseinfo']);
        writelog($_SESSION['id'], 'Records Office set drop form to completed.');
        header('Location: /' . basename($_SERVER['SCRIPT_NAME']) . '?confirm');
        exit();
    }
} elseif (isset($_POST['update'])) {
    $data = array(
        'grade' => $_POST['grade'],
        'lastdate' => $_POST['lastdate']
    );

    $mysql->where('id', $_SESSION['id']);
    $result = $mysql->update('forms', $data);

    if (empty($result)) {
        $_SESSION['errors'][] = 'No information has changed.';
        header('Location: /' . basename($_SERVER['SCRIPT_NAME']) . '?id=' . $_SESSION['id']);
        exit();
    } else {
        writelog($_SESSION['id'], 'Drop request updated. Old grade: ' . $_SESSION['courseinfo']['grade'] . '.  Old last date attended: ' . $_SESSION['courseinfo']['lastdate'] . '.');
        header('Location: /' . basename($_SERVER['SCRIPT_NAME']) . '?id=' . $_SESSION['id']);
        exit();
    }
} elseif (isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];

    $query = "SELECT * FROM forms WHERE id = ? AND deleted = ?";

    $params = array($_SESSION['id'], '0');
    $data = $mysql->rawQuery($query, $params);
    $data = $data[0];

    $query = "SELECT * FROM logs WHERE form_id = ? ORDER BY time DESC, id DESC";

    $params = array($data['id']);
    $logs = $mysql->rawQuery($query, $params);

    $_SESSION['courseinfo'] = $data;
} elseif (isset($_GET['confirm'])) {
    include(DIR_VIEWS . 'header.php');
    ?>
    <div class="row">
        <div class="sixteen columns">
            <h3>Form <?php echo $_SESSION['id']; ?> has been processed.</h3>
            <p><a href="/">Return to home.</a></p>
        </div>
    </div>
    <?php
    include(DIR_VIEWS . 'footer.php');
    exit();
} elseif (isset($_POST['cancel'])) {
    header('Location: view_form.php');
    exit();
} elseif (isset($_GET['delete'])) {
    $mysql->where('id', $_GET['delete']);
    $result = $mysql->update('forms', array('deleted' => '1'));
    
    if(empty($result)){
        $_SESSION['errors'][] = 'There was an error deleting the form.';
    } else {
        writelog($_SESSION['id'], 'Deleted');
    }
    
    header('Location: view_form.php');
    exit();
}

include(DIR_VIEWS . 'header.php');

if (!empty($data)) {
    include(DIR_VIEWS . 'form.view.php');
} else {
    $query = "SELECT COUNT(*) as pages FROM forms WHERE deleted = ?";
    $params = array(0);
    if (!empty($_SESSION['filter']['filter'])) {
        $query .= " AND lastname REGEXP ?";
        $params[] = '^[' . substr($_SESSION['filter']['filter'], 0, 1) .  '-' . substr($_SESSION['filter']['filter'], 1, 1) . ']';
    }
    if (!empty($_SESSION['filter']['status'])) {
        $query .= " AND status_code = ?";
        $params[] = $_SESSION['filter']['status'];
    }
    if (!empty($_SESSION['filter']['semester'])) {
        $query .= " AND semester = ?";
        $params[] = $_SESSION['filter']['semester'];
    }
    if (!empty($_SESSION['filter']['semester'])) {
        $query .= " AND semester = ?";
        $params[] = $_SESSION['filter']['semester'];
    }
    if (!empty($_SESSION['filter']['search'])) {
        if(preg_match("/^\d+$/", $_SESSION['filter']['search'])) {
            $query .= " AND studentid = ?";
            $params[] = $_SESSION['filter']['search'];
        } else {
            $query .= " AND lastname = ?";
            $params[] = $_SESSION['filter']['search'];
        }
    }
    $pagesCount = $mysql->rawQuery($query, $params);
    $pages = ceil(($pagesCount[0]['pages']) / 10);
    
    $query = "SELECT id, semester, status, firstname, lastname, course, course_name, studentid, status FROM forms WHERE deleted = ?";
    $params = array(0);
    if (!empty($_SESSION['filter']['filter'])) {
        $query .= " AND lastname REGEXP ?";
        $params[] = '^[' . substr($_SESSION['filter']['filter'], 0, 1) .  '-' . substr($_SESSION['filter']['filter'], 1, 1) . ']';
    }
    if (!empty($_SESSION['filter']['status'])) {
        $query .= " AND status_code = ?";
        $params[] = $_SESSION['filter']['status'];
    }
    if (!empty($_SESSION['filter']['semester'])) {
        $query .= " AND semester = ?";
        $params[] = $_SESSION['filter']['semester'];
    }
    if (!empty($_SESSION['filter']['search'])) {
        if(preg_match("/^\d+$/", $_SESSION['filter']['search'])) {
            $query .= " AND studentid = ?";
            $params[] = $_SESSION['filter']['search'];
        } else {
            $query .= " AND lastname = ?";
            $params[] = $_SESSION['filter']['search'];
        }
    }
    $query .= " ORDER BY id DESC";
    
    if (!isset($_GET['page'])){
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    
    $query .= " LIMIT " . (($page-1) * 10) . ",10";

    $history = $mysql->rawQuery($query, $params);
    
    include(DIR_VIEWS . 'view_form.php');
}

include(DIR_VIEWS . 'footer.php');
?>