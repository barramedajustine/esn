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

 

// writer already created the first sheet for us, let's get it
$objSheet = $objPHPExcel->getActiveSheet();

// rename the sheet
$objSheet->setTitle("Multiple Choice Question Format");

 

// let's bold and size the header font and write the header
// as you can see, we can specify a range of cells, like here: cells from A1 to A4
$objSheet->getStyle('A1')->getFont()->setBold(true)->setSize(12);
$objSheet->getStyle('A4:F4')->getFont()->setBold(true)->setSize(12);

// header activity name

$objSheet->getCell('A1')->setValue('Question Format :');

// write header activity valyes

$objSheet->getCell('B1')->setValue('Multiple Choice');
// write header


$objSheet->getCell('A4')->setValue('Question');
$objSheet->getCell('B4')->setValue('Correct Answer');
$objSheet->getCell('C4')->setValue('Dummy Ans 1');
$objSheet->getCell('D4')->setValue('Dummy Ans 2');
$objSheet->getCell('E4')->setValue('Dummy Ans 3');
$objSheet->getCell('F4')->setValue('Correct Points');





// autosize the columns
$objSheet->getColumnDimension('A')->setAutoSize(true);
$objSheet->getColumnDimension('B')->setAutoSize(true);
$objSheet->getColumnDimension('C')->setAutoSize(true);
$objSheet->getColumnDimension('D')->setAutoSize(true);
$objSheet->getColumnDimension('E')->setAutoSize(true);
$objSheet->getColumnDimension('F')->setAutoSize(true);


// protect the cells

$objSheet->getProtection()->setPassword('PHPExcel');
$objSheet->getProtection()->setSheet(true);

$objSheet->getCell('A5')->setValue('Sample Question Goes Here');
$objSheet->getCell('B5')->setValue('Answer');
$objSheet->getCell('C5')->setValue('Dummy Answer');
$objSheet->getCell('D5')->setValue('Dummy Answer');
$objSheet->getCell('E5')->setValue('Dummy Answer');
$objSheet->getCell('F5')->setValue('1');

$objSheet->getCell('A6')->setValue('What is the 3rd planet of the solar system?');
$objSheet->getCell('B6')->setValue('Earth');
$objSheet->getCell('C6')->setValue('Jupiter');
$objSheet->getCell('D6')->setValue('Venus');
$objSheet->getCell('E6')->setValue('Mars');
$objSheet->getCell('F6')->setValue('2');

$objSheet->getCell('A7')->setValue('Which is the following is not an animal?');
$objSheet->getCell('B7')->setValue('Ballpen');
$objSheet->getCell('C7')->setValue('Torquiose');
$objSheet->getCell('D7')->setValue('Seagull');
$objSheet->getCell('E7')->setValue('Sparrow');
$objSheet->getCell('F7')->setValue('2');

$objSheet->getStyle('A5:A200')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$objSheet->getStyle('B5:B200')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$objSheet->getStyle('C5:C200')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$objSheet->getStyle('D5:D200')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$objSheet->getStyle('E5:E200')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
$objSheet->getStyle('F5:F200')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);





//Setting the header type
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Multiple_Choice_Format.xlsx"');
header('Cache-Control: max-age=0');

$objWriter->save('php://output');

/* If you want to save the file on the server instead of downloading, replace the last 4 lines by 
	$objWriter->save('test.xlsx');
*/

?>
