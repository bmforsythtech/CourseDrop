<?php

define("SCRIPT_TIMEOUT", 3540); //In seconds.
define("MEMORY_LIMIT", "256M");
define("IMPORT_DIR", "/path/to/import"); //Directory to process CSV files from.  No trailing slash.
define("PROCESS_FILES", 86400); //Only process files that were imported in the last 3600 seconds (hour).
define("USERS_FILE", "USER");
define("INSTRUCT_FILE", "INSTRUCTOR");
define("STUDENT_FILE", "STUDENT");
define("COURSES_FILE", "COURSE");
define("DIVISIONS_FILE", "CourseDivision");
define("NODROP_FILE", "NoDropStudents");
define("ALERT_EMAILS", "user@domain.com"); //Email addresses to send alert messages to.
//MySQL Connection (Not Used) Script converted to load CSV files and store them in memory
define("MYSQL_HOST", "localhost");
define("MYSQL_USER", "username");
define("MYSQL_PASS", "password");
define("MYSQL_DB", "database");
define("MYSQL_HOST2", "localhost");
define("MYSQL_USER2", "username");
define("MYSQL_PASS2", "password");
define("MYSQL_DB2", "database");
define("MYSQL_UTABLE", "users");
define("MYSQL_ITABLE", "instructors");
define("MYSQL_STABLE", "students");
define("MYSQL_CTABLE", "courses");
define("MYSQL_DTABLE", "divisions");
define("MYSQL_NTABLE", "nodrop");

//User table mappings
define("USERS_ID", "STUDENT_ID");
define("USERS_USERNAME", "USER_ID");
define("USERS_FIRSTNAME", "FIRSTNAME");
define("USERS_LASTNAME", "LASTNAME");
define("USERS_EMAIL", "EMAIL");
define("USERS_ROLE", "INSTITUTION_ROLE");
define("USERS_GENDER", "GENDER");

define("INSTR_COURSE", "EXTERNAL_COURSE_KEY");
define("INSTR_ID", "EXTERNAL_PERSON_KEY");
define("INSTR_ROLE", "ROLE");

define("STUDE_COURSE", "EXTERNAL_COURSE_KEY");
define("STUDE_ID", "EXTERNAL_PERSON_KEY");
define("STUDE_AVAILABLE", "AVAILABLE_IND");
define("STUDE_ROLE", "ROLE");

define("COURS_COURSE", "EXTERNAL_COURSE_KEY");
define("COURS_NAME", "COURSE_NAME");
define("COURS_AVAILABLE", "AVAILABLE_IND");

define("DIV_COURSE", "COURSE_ID");
define("DIV_DIVISION", "DIVISION");

define("NOD_ID", "Id");

ini_set('memory_limit', MEMORY_LIMIT);
set_time_limit(SCRIPT_TIMEOUT);
error_reporting(E_ERROR);
chdir(__DIR__);
date_default_timezone_set('America/New_York');

$errors = array();
$debug = false;

include_once('classes/mysql.php');

//MySQL
$mysql = new Mysqlidb(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
$mysql2 = new Mysqlidb(MYSQL_HOST2, MYSQL_USER2, MYSQL_PASS2, MYSQL_DB2);

if ($handle = opendir(IMPORT_DIR)) {
    $imported_files = array();
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            //Only process files that have been updated in the past X seconds
            if ((time() - filemtime(IMPORT_DIR . '/' . $entry)) < PROCESS_FILES) {
                $imported_files[] = $entry;
            }
        }
    }
    closedir($handle);
}
if (empty($imported_files) &&
        date('N') != '6' && //Exclude Saturdays
        date('N') != '7' && //Exclude Sundays
        (date('N') == '1' && date('G') > 6) //Exclude Mondays before 6am
) {
    $errors[] = 'No files to process.  File import from Informer is likely broken.';
}

//Loop through each file, determine what file it is and perform the import.
foreach ($imported_files as $imported_file) {
    if ($debug) {
        $errors[] = "Inspecting file: " . $imported_file;
    }

    unset($matches);
    if (preg_match('/' . USERS_FILE . '/i', $imported_file)) {
        if ($debug) {
            $errors[] = "Loading user import file: " . $imported_file;
        }
        if (!import_users($imported_file)) {
            $errors[] = "Could not import file: " . $imported_file;
        }
    }
    if (preg_match('/' . INSTRUCT_FILE . '-(\w+)/i', $imported_file, $matches)) {
        if ($debug) {
            $errors[] = "Loading instructor import file: " . $imported_file;
        }
        if (!import_instructors($imported_file, $matches[1])) {
            $errors[] = "Could not import file: " . $imported_file;
        }
    }
    if (preg_match('/' . STUDENT_FILE . '-(\w+)/i', $imported_file, $matches)) {
        if ($debug) {
            $errors[] = "Loading student import file: " . $imported_file;
        }
        if (!import_students($imported_file, $matches[1])) {
            $errors[] = "Could not import file: " . $imported_file;
        }
    }
    if (preg_match('/' . COURSES_FILE . '-(\w+)/i', $imported_file, $matches)) {
        if ($debug) {
            $errors[] = "Loading courses import file: " . $imported_file;
        }
        if (!import_courses($imported_file, $matches[1])) {
            $errors[] = "Could not import file: " . $imported_file;
        }
    }
    if (preg_match('/' . DIVISIONS_FILE . '-(\w+)/i', $imported_file, $matches)) {
        if ($debug) {
            $errors[] = "Loading divisions import file: " . $imported_file;
        }
        if (!import_divisions($imported_file, $matches[1])) {
            $errors[] = "Could not import file: " . $imported_file;
        }
    }
    if (preg_match('/' . NODROP_FILE . '/i', $imported_file, $matches)) {
        if ($debug) {
            $errors[] = "Loading no drop list import file: " . $imported_file;
        }
        if (!import_nodrop($imported_file)) {
            $errors[] = "Could not import file: " . $imported_file;
        }
    }

    if ($debug) {
        $errors[] = "Done loading file: " . $imported_file;
    }
}

if (!empty($errors)) {
    print_r($errors);
    if (alert_email(implode("\r\n", $errors))) {
        echo "Email Sent";
    }
}

function import_users($file) {
    global $mysql, $mysql2;

    $users = parse_csv(IMPORT_DIR . '/' . $file);

    //Lock table while we import
    $mysql->truncate(MYSQL_UTABLE);
    $mysql->lock(MYSQL_UTABLE);
    $mysql2->truncate(MYSQL_UTABLE);
    $mysql2->lock(MYSQL_UTABLE);

    foreach ($users as $user) {
        $data = array();
        $data['user_id'] = $user[USERS_ID];
        $data['username'] = $user[USERS_USERNAME];
        $data['firstname'] = $user[USERS_FIRSTNAME];
        $data['lastname'] = $user[USERS_LASTNAME];
        $data['email'] = $user[USERS_EMAIL];
        $data['role'] = $user[USERS_ROLE];
        $data['gender'] = $user[USERS_GENDER];

        $mysql->insert(MYSQL_UTABLE, $data);
        $mysql2->insert(MYSQL_UTABLE, $data);
    }

    $mysql->unlock(MYSQL_UTABLE);
    $mysql2->unlock(MYSQL_UTABLE);

    return true;
}

function import_instructors($file, $semester) {
    global $mysql, $mysql2;

    $instructors = parse_csv(IMPORT_DIR . '/' . $file);

    //Lock table while we import
    $mysql->lock(MYSQL_ITABLE);
    $mysql->where('semester', $semester);
    $mysql->delete(MYSQL_ITABLE);
    $mysql2->lock(MYSQL_ITABLE);
    $mysql2->where('semester', $semester);
    $mysql2->delete(MYSQL_ITABLE);

    foreach ($instructors as $instructor) {
        $data = array();
        $data['semester'] = $semester;
        $data['course'] = $instructor[INSTR_COURSE];
        $data['user_id'] = $instructor[INSTR_ID];
        $data['role'] = $instructor[INSTR_ROLE];

        $mysql->insert(MYSQL_ITABLE, $data);
        $mysql2->insert(MYSQL_ITABLE, $data);
    }

    $mysql->unlock(MYSQL_ITABLE);
    $mysql2->unlock(MYSQL_ITABLE);

    return true;
}

function import_students($file, $semester) {
    global $mysql, $mysql2;

    $students = parse_csv(IMPORT_DIR . '/' . $file);

    //Lock table while we import
    $mysql->lock(MYSQL_STABLE);
    $mysql->where('semester', $semester);
    $mysql->delete(MYSQL_STABLE);
    $mysql2->lock(MYSQL_STABLE);
    $mysql2->where('semester', $semester);
    $mysql2->delete(MYSQL_STABLE);

    foreach ($students as $student) {
        $data = array();
        $data['semester'] = $semester;
        $data['course'] = $student[STUDE_COURSE];
        $data['user_id'] = $student[STUDE_ID];
        $data['available'] = $student[STUDE_AVAILABLE];
        $data['role'] = $student[STUDE_ROLE];

        $mysql->insert(MYSQL_STABLE, $data);
        $mysql2->insert(MYSQL_STABLE, $data);
    }

    $mysql->unlock(MYSQL_STABLE);
    $mysql2->unlock(MYSQL_STABLE);

    return true;
}

function import_courses($file, $semester) {
    global $mysql, $mysql2;

    $courses = parse_csv(IMPORT_DIR . '/' . $file);

    //Lock table while we import
    $mysql->lock(MYSQL_CTABLE);
    $mysql->where('semester', $semester);
    $mysql->delete(MYSQL_CTABLE);
    $mysql2->lock(MYSQL_CTABLE);
    $mysql2->where('semester', $semester);
    $mysql2->delete(MYSQL_CTABLE);

    foreach ($courses as $course) {
        $data = array();
        $data['semester'] = $semester;
        $data['course'] = $course[COURS_COURSE];
        $data['name'] = $course[COURS_NAME];
        $data['available'] = $course[COURS_AVAILABLE];

        $mysql->insert(MYSQL_CTABLE, $data);
        $mysql2->insert(MYSQL_CTABLE, $data);
    }

    $mysql->unlock(MYSQL_CTABLE);
    $mysql2->unlock(MYSQL_CTABLE);

    return true;
}

function import_divisions($file, $semester) {
    global $mysql, $mysql2;

    $divisions = parse_csv(IMPORT_DIR . '/' . $file);

    //Lock table while we import
    $mysql->lock(MYSQL_DTABLE);
    $mysql->where('semester', $semester);
    $mysql->delete(MYSQL_DTABLE);
    $mysql2->lock(MYSQL_DTABLE);
    $mysql2->where('semester', $semester);
    $mysql2->delete(MYSQL_DTABLE);

    foreach ($divisions as $division) {
        $data = array();
        $data['semester'] = $semester;
        $data['course'] = $division[DIV_COURSE];
        $data['division'] = $division[DIV_DIVISION];

        $mysql->insert(MYSQL_DTABLE, $data);
        $mysql2->insert(MYSQL_DTABLE, $data);
    }

    $mysql->unlock(MYSQL_DTABLE);
    $mysql2->unlock(MYSQL_DTABLE);

    return true;
}

function import_nodrop($file) {
    global $mysql;

    $nodrops = parse_csv(IMPORT_DIR . '/' . $file);

    //Lock table while we import
    $mysql->lock(MYSQL_NTABLE);
    $mysql->delete(MYSQL_NTABLE);

    foreach ($nodrops as $nodrop) {
        $data = array();
        $data['user_id'] = $nodrop[NOD_ID];
        
        $mysql->insert(MYSQL_NTABLE, $data);
    }

    $mysql->unlock(MYSQL_NTABLE);

    return true;
}

function parse_csv($file) {
    //Open CSV file and parse it
    $row = 1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        $results = array();
        while (($data = fgetcsv($handle, 0, "|")) !== FALSE) {
            if ($row == 1) {
                $cols = $data;
                $row++;
                continue;
            }
            for ($i = 0; $i < count($data); $i++) {
                $result[$cols[$i]] = $data[$i];
            }
            $results[] = $result;
            unset($result);
            $row++;
        }
        fclose($handle);
    } else {
        $errors[] = "Could not parse file: " . $file;
        return false;
    }

    return $results;
}

function alert_email($message) {
    $headers = 'From: Course Drop Script <webmaster@forsythtech.edu>' . "\r\n";
    return mail(ALERT_EMAILS, 'Course Drop Import Error', $message, $headers);
}

?>