<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');
require_once(DIR_INCLUDES . 'admin.php');

if (!empty($_GET['semester'])) {
    //Uses a lot of memory
    ini_set('memory_limit','256M');
    
    //Get course information from database
    $query = "SELECT id,status,semester,firstname,lastname,studentemail,studentid,username,phone,course,course_name,division,reasons,grade,lastdate,comments,instructorid,instructorname,instructoremail,officialwithdrawal FROM forms WHERE semester = ? AND deleted = ? ORDER BY id";

    $params = array($_GET['semester'], 0);
    $results = $mysql->rawQuery($query, $params);

    //Load PHP Excel class
    require_once DIR_CLASSES . 'PHPExcel.php';

    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Course Drop System")
            ->setLastModifiedBy("Coures Drop System")
            ->setTitle("All drop forms for " . $_GET['semester'])
            ->setSubject("All drop forms for " . $_GET['semester'])
            ->setDescription("All drop forms for " . $_GET['semester'])
            ->setKeywords("course drop form")
            ->setCategory("Forms");


    // Add some data
    $row = 1;
    $col = 'A';
    foreach ($results[0] as $key => $value) {
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($col . $row, $key);
        $col++;
    }
    $row++;
    foreach ($results as $result) {
        $col = 'A';
        foreach ($result as $key => $value) {
            if ($key == 'officialwithdrawal'){
                $value = date('Y-m-d H:i:s', $value);
            }
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($col . $row, $value);
            $col++;
        }
        $row++;
    }

    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="CourseDropForms' . $_GET['semester'] . '.xlsx"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
    header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;
}

//Get list of semesters
$query = "SELECT semester FROM forms GROUP BY semester;";
$semestersList = $mysql->rawQuery($query);

include(DIR_VIEWS . 'header.php');
include(DIR_VIEWS . 'reports.php');
include(DIR_VIEWS . 'footer.php');
