<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'admin.php');

//Page filters
if (isset($_GET['filter']))
    $_SESSION['filter']['filter'] = $_GET['filter'];
if (isset($_GET['status']))
    $_SESSION['filter']['status'] = $_GET['status'];
if (isset($_GET['semester']))
    $_SESSION['filter']['semester'] = $_GET['semester'];
if (isset($_GET['search']))
    $_SESSION['filter']['search'] = trim($_GET['search']);
if (isset($_GET['deleted']))
    $_SESSION['filter']['deleted'] = $_GET['deleted'];
if (isset($_GET['reset'])){
    unset($_SESSION['filter']['search']);
    unset($_SESSION['filter']['deleted']);}

//Default deleted to 0
if (!isset($_SESSION['filter']['deleted']))
    $_SESSION['filter']['deleted'] = 0;
    
//Get list of semesters
$query = "SELECT semester FROM forms GROUP BY semester ORDER BY id DESC LIMIT 5;";
$semestersList = $mysql->rawQuery($query);

if (isset($_POST['approve']) && isset($_POST['id'])) {
    $data = array(
        'status' => $statuses[3],
        'status_code' => '3'
    );

    $mysql->where('id', $_POST['id']);
    $result = $mysql->update('forms', $data);
    
    $query = "SELECT * FROM forms WHERE id = ?";

    $params = array($_POST['id']);
    $data = $mysql->rawQuery($query, $params);
    $data = $data[0];

    if (empty($result)) {
        $_SESSION['errors'][] = 'Form ' . $_POST['id'] . ' has already been processed.  Please review log for this form.';
        header('Location: ' . basename($_SERVER['SCRIPT_NAME']) . '?id=' . $_POST['id']);
        exit();
    } elseif (!empty($data)) {
        student_processed($data);
        instructor_processed($data);
        veteran_check($data);
        deans_processed($data);
        writelog($_POST['id'], 'Records Office set drop form to completed.');
        $_SESSION['id'] = $_POST['id'];
        header('Location: ' . basename($_SERVER['SCRIPT_NAME']) . '?confirm');
        exit();
    } else {
        $_SESSION['errors'][] = 'There was an error approving form ' . $_POST['id'] . '.  Form not found.';
        header('Location: ' . basename($_SERVER['SCRIPT_NAME']) . '?id=' . $_POST['id']);
        exit();
    }
} elseif (isset($_POST['update']) && isset($_POST['id'])) {
    $data = array(
        'grade' => $_POST['grade'],
        'lastdate' => $_POST['lastdate']
    );

    $mysql->where('id', $_POST['id']);
    $result = $mysql->update('forms', $data);
    
    $query = "SELECT * FROM forms WHERE id = ?";

    $params = array($_POST['id']);
    $data = $mysql->rawQuery($query, $params);
    $data = $data[0];

    if (empty($result)) {
        $_SESSION['errors'][] = 'No information has changed.';
        header('Location: ' . basename($_SERVER['SCRIPT_NAME']) . '?id=' . $_POST['id']);
        exit();
    } else {
        writelog($_POST['id'], 'Drop request updated. Old grade: ' . $data['grade'] . '.  Old last date attended: ' . $data['lastdate'] . '.');
        header('Location: ' . basename($_SERVER['SCRIPT_NAME']) . '?id=' . $_POST['id']);
        exit();
    }
} elseif (isset($_GET['id'])) {
    $query = "SELECT * FROM forms WHERE id = ?";

    $params = array($_GET['id']);
    $data = $mysql->rawQuery($query, $params);
    $data = $data[0];

    $query = "SELECT * FROM logs WHERE form_id = ? ORDER BY time DESC, id DESC";

    $params = array($data['id']);
    $logs = $mysql->rawQuery($query, $params);
} elseif (isset($_GET['undelete']) && !empty($_GET['undelete'])) {
    $data = array(
        'deleted' => 0
    );

    $mysql->where('id', $_GET['undelete']);
    $result = $mysql->update('forms', $data);
    
    if (empty($result)) {
        $_SESSION['errors'][] = 'Form ' . $_GET['undelete'] . ' could not be restored.';
        header('Location: ' . basename($_SERVER['SCRIPT_NAME']) . '?id=' . $_GET['undelete']);
        exit();
    } else {
        writelog($_GET['undelete'], 'Restored');
        header('Location: ' . basename($_SERVER['SCRIPT_NAME']) . '?id=' . $_GET['undelete']);
        exit();
    }
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
        $_SESSION['messages'][] = 'Form ' . $_GET['delete'] . ' deleted.';
        writelog($_GET['delete'], 'Deleted');
    }
    
    header('Location: view_form.php');
    exit();
}

include(DIR_VIEWS . 'header.php');

if (!empty($data)) {
    include(DIR_VIEWS . 'form.view.php');
} else {
    $query = "SELECT COUNT(*) as pages FROM forms WHERE deleted = ?";
    $params = array($_SESSION['filter']['deleted']);
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
    $params = array($_SESSION['filter']['deleted']);
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