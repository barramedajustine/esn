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

 
    $res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");



        $classRow = mysqli_fetch_array($res);


         

          $classperiodID =     $classRow['cp_id'];
          $periodName    =     $classRow['period_name'];
          $periodDesc      =     $classRow['period_desc'];

      

                      $students = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$classRow['section_id']."'");


                      $studentCount = mysqli_num_rows($students);

                        while($studentsRow = mysqli_fetch_array($students)) {

                               

                                    $activityScore = 0;
                                    $quizScore = 0;
                                    $examScore = 0;

                                    $totalActivity = 0;
                                    $totalQuizzes  = 0;
                                    $totalExams = 0;


                                    $post = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$classperiodID."' AND post_type != 'Post'");

                                    $postCount = mysqli_num_rows($post);

                                    while($postRow = mysqli_fetch_array($post)) {


                                      if ($postRow['post_type'] == "Activity") {


                                          $submit = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$postRow['custom_id']."' AND student_id='".$studentsRow['student_id']."'");

                                          $hasSubmit = mysqli_num_rows($submit);

                                          if ($hasSubmit == 0) {

                                            $activityScore += 0;


                                          } else {

                                            $submitRow = mysqli_fetch_array($submit);

                                            $activityScore += $submitRow['submit_grade'];


                                          }

                                        

                                       

                                          $totalActivity += 100;


                                      } else {

                                        
                                        $questions = mysqli_query($con, "SELECT sum(points) as total FROM tblquestion WHERE test_id='".$postRow['custom_id']."'");

                                        $questionsRow = mysqli_fetch_array($questions);

                                        $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$postRow['custom_id']."' AND student_id='".$studentsRow['student_id']."'");

                                        $hasTaken = mysqli_num_rows($taken);

                                        if ($postRow['post_type'] == "Quiz") {


                                          if ($hasTaken == 0) {

                                            $quizScore += 0;

                                          } else {

                                            $takenRow = mysqli_fetch_array($taken);

                                            $quizScore += $takenRow['result_grade'];


                                          }


                                          $totalQuizzes += $questionsRow['total'];





                                        } else {


                                          if ($hasTaken == 0) {

                                            $examScore += 0;

                                          } else {

                                            $takenRow = mysqli_fetch_array($taken);

                                            $examScore += $takenRow['result_grade'];


                                          }



                                          $totalExams += $questionsRow['total'];


                                        }



                                      }


                                    }


                                    if ($postCount != 0) {

                                        $avgActivity = 0;

                                        $avgQuiz = 0;

                                        $avgExam = 0;

                                        // get percentage of activity

                                        if ($totalActivity != 0) {

                                        $avgActivity = ($activityScore / $totalActivity);

                                        $avgActivity = $avgActivity * $classRow['grade_activity'];

                                        $avgActivity = round($avgActivity, 0);

                                        }

                                        //  get percentage of quiz

                                        if ($totalQuizzes != 0) {

                                        $avgQuiz = ($quizScore / $totalQuizzes);

                                        $avgQuiz = $avgQuiz * $classRow['grade_quiz'];

                                        $avgQuiz = round($avgQuiz, 0);

                                        }

                                        // get percentage of exam

                                        if ($totalExams != 0) {

                                        $avgExam = ($examScore / $totalExams);

                                        $avgExam = $avgExam * $classRow['grade_exam'];

                                        $avgExam = round($avgExam, 0);

                                        }

                                        // total period grade

                                         $periodGrade = $avgActivity + $avgQuiz + $avgExam;
                                       
                                          $checkGrade = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='".$classperiodID."' AND student_id='".$studentsRow['student_id']."'");


                                          $hasGrade = mysqli_num_rows($checkGrade);

                                          if ($hasGrade == 0) {

                                            mysqli_query($con, "INSERT INTO tblgrades VALUES('0','".$studentsRow['student_id']."','".$classRow['section_id']."','".$classperiodID."','".$avgActivity."','".$avgQuiz."','".$avgExam."','".$periodGrade."')");


                                          } else {

                                            $studentGrade = mysqli_fetch_array($checkGrade);

                                            mysqli_query($con, "UPDATE tblgrades SET activity_grade='".$avgActivity."',quiz_grade='".$avgQuiz."',exam_grade='".$avgExam."',total_grade='".$periodGrade."' WHERE grade_id='".$studentGrade['grade_id']."'");


                                          }

                                  }




                      }











/**

 * Define currency and number format.

 */

// currency format, € with < 0 being in red color
$currencyFormat = '#,#0.## \€;[Red]-#,#0.## \€';

// number format, with thousands separator and two decimal points.
$numberFormat = '#,#0.##;[Red]-#,#0.##';

 
// get activity information

// $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$_GET['id']."'");

// $activityRow = mysqli_fetch_array($res);


// writer already created the first sheet for us, let's get it
$objSheet = $objPHPExcel->getActiveSheet();

// // rename the sheet
 $objSheet->setTitle($classRow['period_name'].' Grade');

// 
$totalRow = 6;
 

// let's bold and size the header font and write the header
// as you can see, we can specify a range of cells, like here: cells from A1 to A4
$objSheet->getStyle('A1:A4')->getFont()->setBold(true)->setSize(12);
$objSheet->getStyle('A6:Q6')->getFont()->setBold(true)->setSize(12);

// header activity name

$objSheet->getCell('A1')->setValue('Period :');
$objSheet->getCell('A2')->setValue('Term :');
$objSheet->getCell('A3')->setValue('Subject & Section :');
$objSheet->getCell('A4')->setValue('Instructor :');

// write header activity valyes

$objSheet->getCell('B1')->setValue($classRow['period_name']);
$objSheet->getCell('B2')->setValue($classRow['section_term']);
$objSheet->getCell('B3')->setValue($classRow['section_name'].' - '.$classRow['section_desc']);
$objSheet->getCell('B4')->setValue($_SESSION['fname'].' '.$_SESSION['lname']);

// write header


$objSheet->getCell('A6')->setValue('Student ID');
$objSheet->getCell('B6')->setValue('Student Name');
// $objSheet->getCell('C6')->setValue('Submitted');
// $objSheet->getCell('D6')->setValue('Grade');
// $objSheet->getCell('E6')->setValue('Remarks');



$column = 'C';
$c = 1;


   $ac = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Activity' AND tblactivity.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");

                                    

      while($acRow = mysqli_fetch_array($ac)) {

                                
                 $objSheet->getCell($column.$totalRow)->setValue('ACT'.$c);           


                  $column++;

                  $c += 1;

                  $objSheet->getColumnDimension($column)->setAutoSize(true);

      }

$c = 1;

   $qz = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Quiz' AND tbltest.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");

      while($qzRow = mysqli_fetch_array($qz)) {

                                               $objSheet->getCell($column.$totalRow)->setValue('Q'.$c);           


                 										 $column++;

                                             $c += 1;


                  $objSheet->getColumnDimension($column)->setAutoSize(true);

            }



      $ts = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Exam' AND tbltest.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");


      while($tsRow = mysqli_fetch_array($ts)) {

 			$objSheet->getCell($column.$totalRow)->setValue('Exam');    

 				$column++;


                  $objSheet->getColumnDimension($column)->setAutoSize(true);

        }


$objSheet->getCell($column.$totalRow)->setValue('Activity '.$classRow['grade_activity'].'%');

$column++;


$objSheet->getColumnDimension($column)->setAutoSize(true);

$objSheet->getCell($column.$totalRow)->setValue('Quiz '.$classRow['grade_quiz'].'%');

$column++;


$objSheet->getColumnDimension($column)->setAutoSize(true);

$objSheet->getCell($column.$totalRow)->setValue('Exam '.$classRow['grade_exam'].'%');

$column++;


$objSheet->getColumnDimension($column)->setAutoSize(true);

$objSheet->getCell($column.$totalRow)->setValue(strtoupper($classRow['period_name']).' GRADE');


  $s = mysqli_query($con, "SELECT * FROM tblclass,tblstudent WHERE tblclass.section_id='".$classRow['section_id']."' AND tblstudent.student_id=tblclass.student_id ORDER BY tblstudent.student_lname ASC");

            while($sRow = mysqli_fetch_array($s)) {

            		$column = "A";
            		$totalRow += 1;

            		$objSheet->getCell($column.$totalRow)->setValue($sRow['student_id']);

            		$column++;

            		$objSheet->getCell($column.$totalRow)->setValue($sRow['student_fname'].' '.$sRow['student_lname']);

            		$column++;

					
            		// loop for activities
					 $ac = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Activity' AND tblactivity.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");


                               while($acRow = mysqli_fetch_array($ac)) {


                                       $sb = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$acRow['activity_id']."' AND student_id='".$sRow['student_id']."'");

                                                  $sbCount = mysqli_num_rows($sb);

                                                  if ($sbCount == 0) {



                                                  $objSheet->getCell($column.$totalRow)->setValue("0");


                                                  } else {


                                                  $sbRow = mysqli_fetch_array($sb);

                                                  $objSheet->getCell($column.$totalRow)->setValue($sbRow['submit_grade']);


                                                  }

                                         	$column++;


                                }

                    // loop for quizzes
                    $qz = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Quiz' AND tbltest.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");


                                while($qzRow = mysqli_fetch_array($qz)) {


                                                          $qs = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$qzRow['test_id']."'");

                                                          $qsCount = mysqli_num_rows($qs);

                                                          $hs = mysqli_query($con, "SELECT * FROM tblanswer WHERE test_id='".$qzRow['test_id']."' AND student_id='".$sRow['student_id']."'");

                                                            $hsCount = mysqli_num_rows($hs);

                                                            if ($hsCount == 0) {



                                                            
                                                  			$objSheet->getCell($column.$totalRow)->setValue("0");


                                                            } else {

                                                                 $correctItems = 0;

                                                                while($hsRow = mysqli_fetch_array($hs)) {

                                                                  if ($hsRow['answered_status'] == "Correct") {

                                                                     $correctItems += $hsRow['answered_pts'];
                                                                  }

                                                                }




                                                            $objSheet->getCell($column.$totalRow)->setValue($correctItems);


                                                            }

                                                 $column++;

                                }



	              //loop for exams
	               $ts = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Exam' AND tbltest.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");


                                while($tsRow = mysqli_fetch_array($ts)) {


                                                          $qs = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$tsRow['test_id']."'");

                                                          $qsCount = mysqli_num_rows($qs);

                                                          $hs = mysqli_query($con, "SELECT * FROM tblanswer WHERE test_id='".$tsRow['test_id']."' AND student_id='".$sRow['student_id']."'");

                                                            $hsCount = mysqli_num_rows($hs);

                                                            if ($hsCount == 0) {



                                                               $objSheet->getCell($column.$totalRow)->setValue("0");


                                                            } else {

                                                                 $correctItems = 0;

                                                                while($hsRow = mysqli_fetch_array($hs)) {

                                                                  if ($hsRow['answered_status'] == "Correct") {

                                                                     $correctItems += $hsRow['answered_pts'];
                                                                  }

                                                                }




                                                              $objSheet->getCell($column.$totalRow)->setValue($correctItems);


                                                            }


                                          $column++;

                                }





                                                $grade = mysqli_query($con, "SELECT * FROM tblgrades WHERE student_id='".$sRow['student_id']."' AND section_id='".$classRow['section_id']."' AND cp_id='".$_GET['id']."'");


                                                $gradeRow = mysqli_fetch_array($grade);

                                                 $objSheet->getCell($column.$totalRow)->setValue($gradeRow['activity_grade']);

                                                 $column++;

                                                 $objSheet->getCell($column.$totalRow)->setValue($gradeRow['quiz_grade']);

                                                 $column++;

                                                 $objSheet->getCell($column.$totalRow)->setValue($gradeRow['exam_grade']);

                                                 $column++;

                                                 $objSheet->getCell($column.$totalRow)->setValue($gradeRow['total_grade']);



            }


// $row = 6;
// $lastColumn = $objSheet->getHighestColumn();
// $lastColumn++;
// // for ($column = 'C'; $column != $lastColumn; $column++) {
// //     $cell = $worksheet->getCell($column.$row);
// //     //  Do what you want with the cell
// // }

// $objSheet->getCell('C6')->setValue($lastColumn);



// we could get this data from database, but here we are writing for simplicity

// $stud = mysqli_query($con, "SELECT * FROM tblclass,tblstudent WHERE tblclass.section_id='".$_GET['secid']."' AND tblstudent.student_id=tblclass.student_id");

// while($studentRow = mysqli_fetch_array($stud)) {


// 	$totalRow += 1;

// 	$objSheet->getCell('A'.$totalRow)->setValue($studentRow['student_id']);
// 	$objSheet->getCell('B'.$totalRow)->setValue($studentRow['student_fname'].' '.$studentRow['student_lname']);

// 	$check = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$_GET['id']."' AND student_id='".$studentRow['student_id']."'");

// 	$hasSubmitted = mysqli_num_rows($check);

// 	if ($hasSubmitted == 0) {

// 		$objSheet->getCell('C'.$totalRow)->setValue('N/A');
// 		$objSheet->getCell('D'.$totalRow)->setValue('0');
// 		$objSheet->getCell('E'.$totalRow)->setValue('N/A');

// 	} else {

// 		$submittedRow = mysqli_fetch_array($check);

// 		$objSheet->getCell('C'.$totalRow)->setValue('Done');
// 		$objSheet->getCell('D'.$totalRow)->setValue($submittedRow['submit_grade']);
// 		$objSheet->getCell('E'.$totalRow)->setValue($submittedRow['submit_remarks']);

// 	}

	



// }



// // autosize the columns
$objSheet->getColumnDimension('A')->setAutoSize(true);
$objSheet->getColumnDimension('B')->setAutoSize(true);
$objSheet->getColumnDimension('C')->setAutoSize(true);
// $objSheet->getColumnDimension('D')->setAutoSize(true);
// $objSheet->getColumnDimension('E')->setAutoSize(true);
// $objSheet->getColumnDimension('F')->setAutoSize(true);
// $objSheet->getColumnDimension('G')->setAutoSize(true);
// $objSheet->getColumnDimension('H')->setAutoSize(true);
// $objSheet->getColumnDimension('I')->setAutoSize(true);
// $objSheet->getColumnDimension('J')->setAutoSize(true);
// $objSheet->getColumnDimension('K')->setAutoSize(true);
// $objSheet->getColumnDimension('L')->setAutoSize(true);
// $objSheet->getColumnDimension('M')->setAutoSize(true);
// $objSheet->getColumnDimension('N')->setAutoSize(true);


// protect the cells

$objSheet->getProtection()->setPassword('PHPExcel');
$objSheet->getProtection()->setSheet(true);

// if ($totalRow != 6) {

// 	$objSheet->getStyle('D7:D'.$totalRow)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
// 	$objSheet->getStyle('E7:E'.$totalRow)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

// }




//Setting the header type
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="'.$classRow['section_name'].' '.$classRow['section_desc'].' - '.$classRow['period_name'].'.xlsx"');
header('Content-Disposition: attachment;filename="'.$classRow['section_name'].' '.$classRow['section_desc'].' - '.$classRow['period_name'].' Grade.xlsx"');
header('Cache-Control: max-age=0');

$objWriter->save('php://output');

/* If you want to save the file on the server instead of downloading, replace the last 4 lines by 
	$objWriter->save('test.xlsx');
*/

?>
