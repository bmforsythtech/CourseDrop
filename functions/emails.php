<?php

function drop_all($data) {
    global $config;
    
    if (!isset($config['studentservicesemail'])) return false;
    
    $emailTo = implode(',', explode("\n", $config['studentservicesemail']));
    $subject = 'Online Course Withdrawal: ' . $data['firstname'] . ' ' . $data['lastname'] . ' Dropping All Courses';
    $headers = 'From: ' . EMAIL_FROM . "\r\n" .
            'Reply-To: ' . EMAIL_REPLY . "\r\n";
    $message = 'Name: ' . $data['firstname'] . ' ' . $data['lastname'] . "\r\n" .
            'SID: ' . $data['studentid'] . "\r\n" .
            'Phone: ' . $data['phone'] . "\r\n" .
            'Reasons: ' . $data['reasons'] . "\r\n";

    $mailed = mail($emailTo, $subject, $message, $headers);
    writelog($data['id'], 'Student dropping all courses alert email sent to Student Services: ' . $emailTo);

    return $mailed;
}

function veteran_check($data) {
    global $config;

    if (!isset($config['veteransemail'])) return false;
    
    if ($data['veteran'] == 'no' || empty($data['veteran']))
        return;

    $emailTo = implode(',', explode("\n", $config['veteransemail']));
    $subject = 'Online Course Withdrawal: Veteran, ' . $data['firstname'] . ' ' . $data['lastname'] . ', Dropping Course';
    $headers = 'From: ' . EMAIL_FROM . "\r\n" .
            'Reply-To: ' . EMAIL_REPLY . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $message = 'Student Name: ' . $data['firstname'] . ' ' . $data['lastname'] . "<br>\r\n" .
            'Student ID: ' . $data['studentid'] . "<br>\r\n" .
            'Course: ' . $data['course'] . "<br>\r\n" .
            'Reason(s) for Dropping: ' . $data['reasons'] . "<br>\r\n" .
            'Veteran?: ' . ucfirst($data['veteran']) . "<br>\r\n" .
            'Grade: ' . $data['grade'] . "<br>\r\n" .
            'Last Date of Attendance: ' . $data['lastdate'] . "<br>\r\n";

    $mailed = mail($emailTo, $subject, $message, $headers);
    writelog($data['id'], 'Veteran dropping course alert email sent to: ' . $emailTo);

    return $mailed;
}

function student_confirmation($data) {
    global $config;

    if (empty($data['studentemail'])){
        writelog($data['id'], 'No Student email set.');
        return false;
    }
    
    $emailTo = $data['studentemail'];
    $subject = 'Online Drop Form Initiated: ' . $data['id'];
    $headers = 'From: ForsythTech Records Office <' . EMAIL_RECORDS . '>' . "\r\n" .
            'Reply-To: ' . EMAIL_REPLY . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $message = 'Hi ' . $data['firstname'] . ',' . "<br>\r\n" .
            "<br>\r\n" .
            'We\'re writing to inform you that your request to drop the course ' . $data['course'] . ' has been received and is currently processing.' . "<br>\r\n" .
            "<br>\r\n" .
            'Your drop request reference number is: ' . $data['id'] . "<br>\r\n" .
            "<br>\r\n" .
            'If you have any questions, please do not respond to this email as it is not monitored.  Please contact the Records Office at:' . "<br>\r\n" .
            "<br>\r\n" .
            'Records Office' . "<br>\r\n" .
            'Allman Building Room 106' . "<br>\r\n" .
            'Phone: 336-734-7472' . "<br>\r\n";
    $mailed = mail($emailTo, $subject, $message, $headers);
    writelog($data['id'], 'Student confirmation email sent to ' . $emailTo);

    return $mailed;
}

function instructor_request($data) {
    global $config;

    if (empty($data['instructoremail'])){
        writelog($data['id'], 'No Instructor email set.');
        return false;
    }
    
    $emailTo = $data['instructoremail'];
    $subject = 'Student Drop Request - Information Need From You (Form ID: ' . $data['id'] . ')';
    $headers = 'From: ForsythTech Records Office <' . EMAIL_RECORDS . '>' . "\r\n" .
            'Reply-To: ' . EMAIL_REPLY . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $message = $data['firstname'] . ' ' . $data['lastname'] . ' has requested to drop from your course ' . $data['course'] . '.' . "<br>\r\n" .
            "<br>\r\n" .
            'To complete this process, we need some information from you.  Please go to the following URL to fill in the required information:' . "<br>\r\n" .
            "<br>\r\n" .
            '<a href="https://coursedrop.forsythtech.edu/instructor_request.php?t=' . $data['tuid'] . '">Information Needed: Form ' . $data['id'] . '</a>' . "<br>\r\n" .
            "<br>\r\n" .
            'Fill in their <b>grade</b>, <b>last date of attendance</b>, and any <b>comments</b> you may have.  This information is due by ' . date('m/d/y', $data['idue']) . '.' . "<br>\r\n" .
            "<br>\r\n" .
            'You will receive an email reminder until the Records Office receives this information.' . "<br>\r\n" .
            "<br>\r\n" .
            'Student Name: ' . $data['firstname'] . ' ' . $data['lastname'] . "<br>\r\n" .
            'Student ID: ' . $data['studentid'] . "<br>\r\n" .
            'Course: ' . $data['course'] . "<br>\r\n" .
            'Reason(s) for Dropping: ' . $data['reasons'] . "<br>\r\n" .
            'Veteran?: ' . ucfirst($data['veteran']) . "<br>\r\n" .
            "<br>\r\n" .
            'Thanks,' . "<br>\r\n" .
            "<br>\r\n" .
            'Forsyth Tech Records Department' . "\r\n";

    $mailed = mail($emailTo, $subject, $message, $headers);
    writelog($data['id'], 'Instructor request for additional information email sent to ' . $emailTo);

    return $mailed;
}

function instructor_confirmation($data) {
    global $config;

    if (empty($data['instructoremail'])){
        writelog($data['id'], 'No Instructor email set.');
        return false;
    }
    
    $emailTo = $data['instructoremail'];
    $subject = 'Drop Form Information Received: Form ' . $data['id'];
    $headers = 'From: ForsythTech Records Office <' . EMAIL_RECORDS . '>' . "\r\n" .
            'Reply-To: ' . EMAIL_REPLY . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $message = 'Hi ' . $data['instructorname'] . ',' . "<br>\r\n" .
            "<br>\r\n" .
            'We have received your portion for the Online Drop Form: ' . $data['id'] . '.  The form will now be reviewed and processed.' . "<br>\r\n" .
            "<br>\r\n" .
            'Student Name: ' . $data['firstname'] . ' ' . $data['lastname'] . "<br>\r\n" .
            'Student ID: ' . $data['studentid'] . "<br>\r\n" .
            'Course: ' . $data['course'] . "<br>\r\n" .
            'Reason(s) for Dropping: ' . $data['reasons'] . "<br>\r\n" .
            'Grade: ' . $data['grade'] . "<br>\r\n" .
            'Last Date of Attendance: ' . $data['lastdate'] . "<br>\r\n" .
            "<br>\r\n" .
            'Thanks' . "<br>\r\n" .
            'Forsyth Tech Records Office';

    $mailed = mail($emailTo, $subject, $message, $headers);
    writelog($data['id'], 'Instructor received additional information received confirmation email sent to ' . $emailTo);

    return $mailed;
}

function records_alert($data) {
    global $config;

    if (!isset($config['recordsemail'])) return false;
    
    //Append to subject line which range the last name falls under.
    $range = '';
    foreach ($view_filters as $key => $value) {
        $lower = substr($key, 0);
        $upper = substr($key, 1);
        if (in_array(range($lower, $upper), $data['lastname'])) {
            $range = $lower . ' ' . $upper;
        }
    }

    $emailTo = implode(',', explode("\n", $config['recordsemail']));
    $subject = 'New Drop Form: Form ' . $data['id'] . ', Scope ' . $range;
    $headers = 'From: ' . EMAIL_FROM . "\r\n" .
            'Reply-To: ' . EMAIL_REPLY . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $message = 'There is a new drop request waiting to be processed.' . "<br>\r\n" .
            "<br>\r\n" .
            'Student Name: ' . $data['firstname'] . ' ' . $data['lastname'] . "<br>\r\n" .
            'Student ID: ' . $data['studentid'] . "<br>\r\n" .
            'Course: ' . $data['course'] . "<br>\r\n" .
            'Reason(s) for Dropping: ' . $data['reasons'] . "<br>\r\n" .
            "<br>\r\n" .
            '<a href="https://coursedrop.forsythtech.edu/view_form.php?id=' . $data['id'] . '">Form ' . $data['id'] . '</a>';

    $mailed = mail($emailTo, $subject, $message, $headers);
    writelog($data['id'], 'Records new drop form alert email sent to ' . $emailTo . ' Scope: ' . $range);

    return $mailed;
}

function student_processed($data) {
    global $config;

    if (empty($data['studentemail'])){
        writelog($data['id'], 'No Student email set.');
        return false;
    }
    
    $emailTo = $data['studentemail'];
    $subject = 'Online Drop Form Processed: ' . $data['id'];
    $headers = 'From: ' . EMAIL_RECORDS . "\r\n" .
            'Reply-To: ' . EMAIL_REPLY . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $message = 'Hi ' . $data['firstname'] . ',' . "<br>\r\n" .
            "<br>\r\n" .
            'You have been withdrawn from ' . $data['course'] . '.' . "<br>\r\n" .
            "<br>\r\n" .
            'Your withdraw reference number is: ' . $data['id'] . "<br>\r\n" .
            "<br>\r\n" .
            'If you have any questions, please do not respond to this email as it is not monitored.  Please contact your Instructor';

    $mailed = mail($emailTo, $subject, $message, $headers);
    writelog($data['id'], 'Student course drop proccessed email sent to ' . $emailTo);

    return $mailed;
}

function instructor_processed($data) {
    global $config;

    if (empty($data['instructoremail'])){
        writelog($data['id'], 'No Instructor email set.');
        return false;
    }
    
    $emailTo = $data['instructoremail'];
    $subject = 'Online Drop Form Processed: ' . $data['id'];
    $headers = 'From: ' . EMAIL_RECORDS . "\r\n" .
            'Reply-To: ' . EMAIL_REPLY . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
    $message = 'Hi ' . $data['instructorname'] . ',' . "<br>\r\n" .
            "<br>\r\n" .
            'The online drop form: ' . $data['id'] . ' has been processed.' . "<br>\r\n" .
            "<br>\r\n" .
            'Student Name: ' . $data['firstname'] . ' ' . $data['lastname'] . "<br>\r\n" .
            'Student ID: ' . $data['studentid'] . "<br>\r\n" .
            'Course: ' . $data['course'] . "<br>\r\n" .
            'Reason(s) for Dropping: ' . $data['reasons'] . "<br>\r\n" .
            "<br>\r\n" .
            "<br>\r\n" .
            'Let us know how the process went via this short survey: https://classclimate.forsythtech.edu/classclimate/online.php?p=RV8DH, your feedback is appreciated!' . "<br>\r\n" .
            "<br>\r\n" .
            "<br>\r\n" .
            'Thanks' . "<br>\r\n" .
            'Forsyth Tech Records Office';

    $mailed = mail($emailTo, $subject, $message, $headers);
    writelog($data['id'], 'Instructor course drop processed email sent to ' . $emailTo);

    return $mailed;
}

function deans_processed($data) {
    global $config, $mysql;
    
    $insert = array(
        'email_data' => serialize($data),
        'sent' => '0',
        'tosend' => mktime('12', '0', '0', date("n", strtotime('next Friday')), date("j", strtotime('next Friday')))
    );

    $insertid = $mysql->insert('emails', $insert);
    
    if (!empty($insertid)){
        return true;
    } else {
        return false;
    }
}

function deans_email($division, $dataset) {
    global $config;
    
    if (!empty($division) && isset($config['deanfor' . strtolower($division)])){
        $emailTo = $config['deanfor' . strtolower($division)];
     } else {
         return false;
     }
     
     $subject = 'List of Processed Online Drop Forms';
     $headers = 'From: ' . EMAIL_RECORDS . "\r\n" .
             'Reply-To: ' . EMAIL_RECORDS . "\r\n" .
             'MIME-Version: 1.0' . "\r\n" .
             'Content-Type: text/html; charset=ISO-8859-1' . "\r\n";
     $message = 'Hi ' . $division . ' Division,' . "<br>\r\n" .
             "<br>\r\n" .
             'The folowing forms were processed this week:' . "<br>\r\n" .
             "<br>\r\n";

     foreach ($dataset as $data){
         $message .= 'Form: ' . $data['id'] . "<br>\r\n" .
             'Student Name: ' . $data['firstname'] . ' ' . $data['lastname'] . "<br>\r\n" .
             'Student ID: ' . $data['studentid'] . "<br>\r\n" .
             'Course: ' . $data['course'] . "<br>\r\n" .
             'Reason(s) for Dropping: ' . $data['reasons'] . "<br>\r\n" .
             "<br>\r\n";
         writelog($data['id'], 'Division email sent to ' . $emailTo);
     }

     $message .= 'Thanks' . "<br>\r\n" .
             'Forsyth Tech Records Office';

     $mailed = mail($emailTo, $subject, $message, $headers);

     return $mailed;
}
?>