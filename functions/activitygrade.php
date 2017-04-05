<?php

session_start();

/** Set default timezone (will throw a notice otherwise) */
date_default_timezone_set('Asia/Manila');

// include PHPExcel
require('../PHPExcel.php');

include "connect.php";



// create new PHPExcel object
$objPHPExcel = new PHPExcel;

// set default font
$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');

// set default font size
$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);

// create the writer
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");

 

/**

 * Define currency and number format.

 */

// currency format, € with < 0 being in red color
$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';

// number format, with thousands separator and two decimal points.
$numberFormat = '#,#0.##;[Red]-#,#0.##';

 
// get activity information

$res = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$_GET['id']."'");

$activityRow = mysqli_fetch_array($res);


// writer already created the first sheet for us, let's get it
$objSheet = $objPHPExcel->getActiveSheet();

// rename the sheet
$objSheet->setTitle($activityRow['activity_name']);


$totalRow = 6;
 

// let's bold and size the header font and write the header
// as you can see, we can specify a range of cells, like here: cells from A1 to A4
$objSheet->getStyle('A1:A4')->getFont()->setBold(true)->setSize(12);
$objSheet->getStyle('A6:E6')->getFont()->setBold(true)->setSize(12);

// header activity name

$objSheet->getCell('A1')->setValue('Activity ID :');
$objSheet->getCell('A2')->setValue('Activity Name :');
$objSheet->getCell('A3')->setValue('Activity Duration :');
$objSheet->getCell('A4')->setValue('Instructor :');

// write header activity valyes

$objSheet->getCell('B1')->setValue($activityRow['activity_id']);
$objSheet->getCell('B2')->setValue($activityRow['activity_name']);
$objSheet->getCell('B3')->setValue(date("M d, Y", strtotime($activityRow['activity_datestart'])).' - '.date("M d, Y", strtotime($activityRow['activity_dateend'])));
$objSheet->getCell('B4')->setValue($_SESSION['fname'].' '.$_SESSION['lname']);

// write header


$objSheet->getCell('A6')->setValue('Student ID');
$objSheet->getCell('B6')->setValue('Student Name');
$objSheet->getCell('C6')->setValue('Submitted');
$objSheet->getCell('D6')->setValue('Grade');
$objSheet->getCell('E6')->setValue('Remarks');

// we could get this data from database, but here we are writing for simplicity

$stud = mysqli_query($con, "SELECT * FROM tblclass,tblstudent WHERE tblclass.section_id='".$_GET['secid']."' AND tblstudent.student_id=tblclass.student_id");

while($studentRow = mysqli_fetch_array($stud)) {


	$totalRow += 1;

	$objSheet->getCell('A'.$totalRow)->setValue($studentRow['student_id']);
	$objSheet->getCell('B'.$totalRow)->setValue($studentRow['student_fname'].' '.$studentRow['student_lname']);

	$check = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$_GET['id']."' AND student_id='".$studentRow['student_id']."'");

	$hasSubmitted = mysqli_num_rows($check);

	if ($hasSubmitted == 0) {

		$objSheet->getCell('C'.$totalRow)->setValue('N/A');
		$objSheet->getCell('D'.$totalRow)->setValue('0');
		$objSheet->getCell('E'.$totalRow)->setValue('N/A');

	} else {

		$submittedRow = mysqli_fetch_array($check);

		$objSheet->getCell('C'.$totalRow)->setValue('Done');
		$objSheet->getCell('D'.$totalRow)->setValue($submittedRow['submit_grade']);
		$objSheet->getCell('E'.$totalRow)->setValue($submittedRow['submit_remarks']);

	}

	



}



// autosize the columns
$objSheet->getColumnDimension('A')->setAutoSize(true);
$objSheet->getColumnDimension('B')->setAutoSize(true);
$objSheet->getColumnDimension('C')->setAutoSize(true);
$objSheet->getColumnDimension('D')->setAutoSize(true);
$objSheet->getColumnDimension('E')->setAutoSize(true);


// protect the cells

$objSheet->getProtection()->setPassword('PHPExcel');
$objSheet->getProtection()->setSheet(true);

if ($totalRow != 6) {

	$objSheet->getStyle('D7:D'.$totalRow)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
	$objSheet->getStyle('E7:E'.$totalRow)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

}




//Setting the header type
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Activity '.$activityRow['activity_name'].' - '.date("Y-m-d").'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter->save('php://output');

/* If you want to save the file on the server instead of downloading, replace the last 4 lines by 
	$objWriter->save('test.xlsx');
*/

?>
