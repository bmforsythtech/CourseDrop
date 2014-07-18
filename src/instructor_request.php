<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');

if (isset($_POST['submit'])) {

    if (empty($_SESSION['tuid'])) {
        $_SESSION['errors'] = 'There was an error submitting the form';
        header('Location: /');
        exit();
    }

    if (empty($_POST['grade']))
        $_SESSION['errors'][] = 'Grade must be filled in.';
    if (empty($_POST['lastdate']))
        $_SESSION['errors'][] = 'Last date of attendance must be filled in.';
    if (strtotime($_POST['lastdate']) > strtotime(date('m/d/Y', $_SESSION['courseinfo']['officialwithdrawal'])))
        $_SESSION['errors'][] = 'Last date of attendance cannot be later than official withdrawal date.';

    if (!empty($_SESSION['errors'])) {
        header('Location: /' . basename($_SERVER['SCRIPT_NAME']) . '?t=' . $_SESSION['tuid']);
        exit();
    }

    $data = array(
        'grade' => $_POST['grade'],
        'lastdate' => $_POST['lastdate'],
        'comments' => $_POST['comments'],
        'status' => $statuses[2],
        'status_code' => '2',
        'rdue' => time() + ALERT_INT
    );

    $mysql->where('tuid', $_SESSION['tuid']);
    $result = $mysql->update('forms', $data);

    if (empty($result)) {
        $_SESSION['errors'][] = 'There was an error submitting the form';
        header('Location: /' . basename($_SERVER['SCRIPT_NAME']) . '?t=' . $_SESSION['tuid']);
        exit();
    } else {
        instructor_confirmation($_SESSION['courseinfo']);
        records_alert($_SESSION['courseinfo']);
        writelog($_SESSION['courseinfo']['id'], 'Instructor submitted additional information.');
        header('Location: /' . basename($_SERVER['SCRIPT_NAME']) . '?confirm');
        exit();
    }
} elseif (isset($_GET['t'])) {
    $_SESSION['tuid'] = $_GET['t'];

    $query = "SELECT * FROM forms WHERE tuid = ? AND status_code = 1 AND deleted = ?";

    $params = array($_SESSION['tuid'], 0);
    $data = $mysql->rawQuery($query, $params);
    $data = $data[0];

    $_SESSION['courseinfo'] = $data;
} elseif (isset($_GET['confirm'])) {
    include(DIR_VIEWS . 'header.php');
    ?>
    <div class="row">
        <div class="large-16 columns">
            <h3>Thank you</h3>
            <p>We received your portion of the drop request.  You may now close this window.</p>
        </div>
    </div>
    <?php
    include(DIR_VIEWS . 'footer.php');
    session_destroy();
    exit();
}

include(DIR_VIEWS . 'header.php');

if (!empty($data)) {
    include(DIR_VIEWS . 'form.instructor.request.php');
} else {
    ?>
    <div class="row">
        <div class="large-16 columns">
            <p></p>
            <h4>Information has already been submitted.  Please contact the Records Office.</h4>
        </div>
    </div>
    <?php
}

include(DIR_VIEWS . 'footer.php');
?>