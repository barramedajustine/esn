<?php



date_default_timezone_set("Asia/Manila");



session_start();



ob_start();



include "functions/connect.php";





// teacher registration



if ($_GET['page'] == "registert") {



	$id 	= 	mysqli_real_escape_string($con, $_POST['id']);

	$fname	=	mysqli_real_escape_string($con, $_POST['fname']);

	$lname	=	mysqli_real_escape_string($con, $_POST['lname']);

	$pass	=	mysqli_real_escape_string($con, $_POST['pass']);

	$email	=	$_POST['email'];

	



	$i 		=	mysqli_query($con, "SELECT * FROM tblteacher WHERE employee_id='".$id."'");

	$iC 	=	mysqli_num_rows($i);



	$e 		=	mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_email='".$email."'");

	$eC 	=	mysqli_num_rows($e);



	$m 		= 	0;

	$l 		= 	0;





	if ($eC == 0) {



	$validated = checkEmail($email, true);





		if ($validated == 1) {





							

							// build API request

							$APIUrl = 'http://api.email-validator.net/api/verify';

							$Params = array('EmailAddress' => $email,

							                'APIKey' => 'ev-d61114ecf7a6891d62a3a76a32612599');

							$Request = @http_build_query($Params);

							$ctxData = array(

							     'method' => "POST",

							     'header' => "Connection: close\r\n".

							     "Content-Length: ".strlen($Request)."\r\n",

							     'content'=> $Request);

							$ctx = @stream_context_create(array('http' => $ctxData));



							// send API request

							$result = json_decode(@file_get_contents(

							    $APIUrl, false, $ctx));



							// check API result

							if ($result && $result->{'status'} > 0) {

							    switch ($result->{'status'}) {

							        // valid addresses have a {200, 207, 215} result code

							        // result codes 114 and 118 need a retry

							        case 200:

							        case 207:

							        case 215:

							                //echo "Address is valid.";

							                break;

							        case 114:

							                // greylisting, wait 5min and retry

							                break;

							        case 118:

							                // api rate limit, wait 5min and retry

							                break;

							        default:

							                $l = 1;

							               // echo $result->{'info'};

							               // echo $result->{'details'};

							                break;

							    }

							} 



		} else {



			$m 	= 1;



		}





	}





	if ($iC == 1) {



		echo 'id';



	} else if ($id == "" || $id == " ") {



		echo 'empty';



	} else if ($eC == 1) {



		echo 'email';



	} else if ($m == 1) {



		echo 'valid';



	} else if ($l == 1) {



		echo 'online';



	} else if ($fname == "" || $fname == " ") {



		echo 'fname';



	} else if ($lname == "" || $lname == " ") {



		echo 'lname';



	} else if (strlen($pass) < 5) {



		echo 'minimum';



	} else if ($_POST['pass'] != $_POST['cpass']) {



		echo 'mismatch';



	} else {



		mysqli_query($con, "INSERT INTO tblteacher VALUES('0','".$id."','".$fname."','".$lname."','".$email."','".$pass."','nopic.png','Registration')");



		echo 'success';



	



	}

	

	





}



// end of teacher registration



// student registration



if ($_GET['page'] == "registers") {



	$id 	= 	mysqli_real_escape_string($con, $_POST['id']);

	$fname	=	mysqli_real_escape_string($con, $_POST['fname']);

	$lname	=	mysqli_real_escape_string($con, $_POST['lname']);

	$pass	=	mysqli_real_escape_string($con, $_POST['pass']);

	$email	=	$_POST['email'];

	



	$i 		=	mysqli_query($con, "SELECT * FROM tblstudent WHERE student_num='".$id."'");

	$iC 	=	mysqli_num_rows($i);



	$e 		=	mysqli_query($con, "SELECT * FROM tblstudent WHERE student_email='".$email."'");

	$eC 	=	mysqli_num_rows($e);



	$m 		= 	0;

	$l 		= 	0;





	if ($eC == 0) {



	$validated = checkEmail($email, true);





		if ($validated == 1) {



							

							// build API request

							$APIUrl = 'http://api.email-validator.net/api/verify';

							$Params = array('EmailAddress' => $email,

							                'APIKey' => 'ev-d61114ecf7a6891d62a3a76a32612599');

							$Request = @http_build_query($Params);

							$ctxData = array(

							     'method' => "POST",

							     'header' => "Connection: close\r\n".

							     "Content-Length: ".strlen($Request)."\r\n",

							     'content'=> $Request);

							$ctx = @stream_context_create(array('http' => $ctxData));



							// send API request

							$result = json_decode(@file_get_contents(

							    $APIUrl, false, $ctx));



							// check API result

							if ($result && $result->{'status'} > 0) {

							    switch ($result->{'status'}) {

							        // valid addresses have a {200, 207, 215} result code

							        // result codes 114 and 118 need a retry

							        case 200:

							        case 207:

							        case 215:

							                //echo "Address is valid.";

							                break;

							        case 114:

							                // greylisting, wait 5min and retry

							                break;

							        case 118:

							                // api rate limit, wait 5min and retry

							                break;

							        default:

							                $l = 1;

							               // echo $result->{'info'};

							               // echo $result->{'details'};

							                break;

							    }

							}



						



		} else {



			$m 	= 1;



		}





	}





	if ($iC == 1) {



		echo 'id';



	} else if ($id == "" || $id == " ") {



		echo 'empty';



	} else if ($eC == 1) {



		echo 'email';



	} else if ($m == 1) {



		echo 'valid';



	} else if ($l == 1) {



		echo 'online';



	} else if ($fname == "" || $fname == " ") {



		echo 'fname';



	} else if ($lname == "" || $lname == " ") {



		echo 'lname';



	} else if (strlen($pass) < 5) {



		echo 'minimum';



	} else if ($_POST['pass'] != $_POST['cpass']) {



		echo 'mismatch';



	} else {



		mysqli_query($con, "INSERT INTO tblstudent VALUES('0','".$id."','".$fname."','".$lname."','".$email."','".$pass."','nopic.png','Registration')");



		echo 'success';

	}

	





}



// end of student registration

// insert account

if ($_GET['page'] == "insertaccount") {



	$id 	= 	mysqli_real_escape_string($con, $_POST['id']);

	$fname	=	mysqli_real_escape_string($con, $_POST['fname']);

	$lname	=	mysqli_real_escape_string($con, $_POST['lname']);

	$pass	=	mysqli_real_escape_string($con, $_POST['pass']);

	$cpass 	=	mysqli_real_escape_string($con, $_POST['cpass']);

	$email	=	$_POST['email'];

	

	if ($_GET['type'] == "teacher") {


		$i 		=	mysqli_query($con, "SELECT * FROM tblteacher WHERE employee_id='".$id."'");

		$iC 	=	mysqli_num_rows($i);



		$e 		=	mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_email='".$email."'");

		$eC 	=	mysqli_num_rows($e);



		$m 		= 	0;

		$l 		= 	0;


	}	else {

		$i 		=	mysqli_query($con, "SELECT * FROM tblstudent WHERE student_num='".$id."'");

		$iC 	=	mysqli_num_rows($i);



		$e 		=	mysqli_query($con, "SELECT * FROM tblstudent WHERE student_email='".$email."'");

		$eC 	=	mysqli_num_rows($e);



		$m 		= 	0;

		$l 		= 	0;


	}





	if ($eC == 0) {



	$validated = checkEmail($email, true);





		if ($validated == 1) {





							

							// build API request

							$APIUrl = 'http://api.email-validator.net/api/verify';

							$Params = array('EmailAddress' => $email,

							                'APIKey' => 'ev-d61114ecf7a6891d62a3a76a32612599');

							$Request = @http_build_query($Params);

							$ctxData = array(

							     'method' => "POST",

							     'header' => "Connection: close\r\n".

							     "Content-Length: ".strlen($Request)."\r\n",

							     'content'=> $Request);

							$ctx = @stream_context_create(array('http' => $ctxData));



							// send API request

							$result = json_decode(@file_get_contents(

							    $APIUrl, false, $ctx));



							// check API result

							if ($result && $result->{'status'} > 0) {

							    switch ($result->{'status'}) {

							        // valid addresses have a {200, 207, 215} result code

							        // result codes 114 and 118 need a retry

							        case 200:

							        case 207:

							        case 215:

							                //echo "Address is valid.";

							                break;

							        case 114:

							                // greylisting, wait 5min and retry

							                break;

							        case 118:

							                // api rate limit, wait 5min and retry

							                break;

							        default:

							                $l = 1;

							               // echo $result->{'info'};

							               // echo $result->{'details'};

							                break;

							    }

							} 



		} else {



			$m 	= 1;



		}





	}





	if ($iC == 1) {



		$_SESSION['cerror'] = "ID already registered.";



	} else if ($id == "" || $id == " ") {



		$_SESSION['cerror'] = "ID is empty!.";



	} else if ($eC == 1) {



		$_SESSION['cerror'] = "Email Address is already registered.";



	} else if ($m == 1) {



		$_SESSION['cerror'] = "Email address is not valid";



	} else if ($l == 1) {



		$_SESSION['cerror'] = "Email address can't be found online";



	} else if ($fname == "" || $fname == " ") {



		$_SESSION['cerror'] = "Empty First Name";



	} else if ($lname == "" || $lname == " ") {



		$_SESSION['cerror'] = "Empty Last Name";



	} else if (strlen($pass) < 5) {



		$_SESSION['cerror'] = "Password must have a minimum of 5 characters";


	} else if ($_POST['pass'] != $_POST['cpass']) {



		$_SESSION['cerror'] = "Password mismatch.";



	} else {


		if ($_GET['type'] == "teacher") {

		


		$res = mysqli_query($con, "INSERT INTO tblteacher VALUES('0','".$id."','".$fname."','".$lname."','".$email."','".$pass."','nopic.png','Registration','0','50')");
	


		} else {

		$res = mysqli_query($con, "INSERT INTO tblstudent VALUES('0','".$id."','".$fname."','".$lname."','".$email."','".$pass."','nopic.png','Registration','0')");



		}


		if ($res) {

			$_SESSION['cerror'] = "Success, you can now login.";


		} else {


			$_SESSION['cerror'] = "Server error occured, please try again later.";
		}


	



	}

	

	header("location: index.php?page=register&type=".$_GET['type']);





}

// end of insert account



// teacher login



if ($_GET['page'] == "logint") {



	$email 	=	mysqli_real_escape_string($con, $_POST['email']);

	$pass 	=	mysqli_real_escape_string($con, $_POST['pass']);



	$res 	=	mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_email='".$email."' AND teacher_pass='".$pass."'");



	$c 		=	mysqli_num_rows($res);



	if ($c == 0) {





		$_SESSION['cerror'] = "Invalid Email or Password.";



		header("location: index.php?page=teacher");





	} else {



		$row 	 =	mysqli_fetch_array($res);



		$_SESSION['isLogin']	=	"teacher";

		$_SESSION['id']			=	$row['teacher_id'];

		$_SESSION['employee_id']=	$row['employee_id'];	

		$_SESSION['fname'] 		= 	$row['teacher_fname'];

		$_SESSION['lname']		=	$row['teacher_lname'];

		$_SESSION['email']		=	$row['teacher_email'];

		$_SESSION['pass']		=	$row['teacher_pass'];

		$_SESSION['login']		=	$row['teacher_status'];

		$_SESSION['getstarted'] = 	$row['teacher_guide'];

		$_SESSION['basegrade']	=	$row['teacher_basegrade'];

		if ($row['teacher_picpath'] == "nopic.png") {

			$_SESSION['picpath']	=	'images/teacher/'.$row['teacher_picpath'];

		} else {

			$_SESSION['picpath']	= $row['teacher_picpath'];
		}



		header("location: teacher.php");





	}





}



// end of teacher login



// teacher login



if ($_GET['page'] == "logins") {



	$email 	=	mysqli_real_escape_string($con, $_POST['email']);

	$pass 	=	mysqli_real_escape_string($con, $_POST['pass']);



	$res 	=	mysqli_query($con, "SELECT * FROM tblstudent WHERE student_email='".$email."' AND student_pass='".$pass."'");



	$c 		=	mysqli_num_rows($res);



	if ($c == 0) {





		$_SESSION['cerror'] = "Invalid Email or Password.";



		header("location: index.php?page=student");





	} else {



		$row 	 =	mysqli_fetch_array($res);



		$_SESSION['isLogin']	=	"student";

		$_SESSION['id']			=	$row['student_id'];

		$_SESSION['employee_id']=	$row['student_num'];	

		$_SESSION['fname'] 		= 	$row['student_fname'];

		$_SESSION['lname']		=	$row['student_lname'];

		$_SESSION['email']		=	$row['student_email'];

		$_SESSION['pass']		=	$row['student_pass'];

		$_SESSION['login']		=	$row['student_status'];

		$_SESSION['getstarted'] =	$row['student_guide'];

		if ($row['student_picpath'] == "nopic.png") {

			$_SESSION['picpath']	=	'images/student/'.$row['student_picpath'];

		} else {

			$_SESSION['picpath']	= $row['student_picpath'];
		}


		header("location: student.php");





	}





}



// end of student  login



if($_GET['page'] == "fblogin") { 

      include 'social/src/facebook.php';
      $appid    = "1203488246433380";
      $appsecret  = "e47b6dbb72b6363d2312bb01c00d8260";
      $facebook   = new Facebook(array(
          'appId' => $appid,
          'secret' => $appsecret,
          'cookie' => TRUE,
      ));

      $fbuser = $facebook->getUser();

      if ($fbuser) {

        try {

            $user_profile = $facebook->api('/me', array('fields' => 'first_name,last_name,email'));

        }

        catch (Exception $e) {

          header("location: index.php?page=".$_GET['type']);
          exit();

        }

        
        $_SESSION['login'] = "Facebook";
        $_SESSION['fname'] = $user_profile['first_name'];
        $_SESSION['lname'] = $user_profile['last_name'];
        $_SESSION['social_id'] = $fbuser;
        $_SESSION['picpath'] = "https://graph.facebook.com/".$_SESSION['social_id']."/picture?type=large";
        $_SESSION['email'] = $user_profile['email'];


       
      	if ($_GET['type'] == "teacher") {


      		$res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_email='".$_SESSION['email']."'");

      		$c = mysqli_num_rows($res);

      		if ($c == 1) {

      			$_SESSION['isLogin'] = "teacher";

      			$row = mysqli_fetch_array($res);

      			$_SESSION['getstarted'] = $row['teacher_guide'];
      			$_SESSION['id'] = $row['teacher_id'];
      			$_SESSION['basegrade']	=	$row['teacher_basegrade'];

      			if ($row['teacher_picpath'] != "nopic.png") {

      				 $_SESSION['picpath'] = $row['teacher_picpath'];

      			}

      			mysqli_query($con, "UPDATE tblteacher SET teacher_fname='".$_SESSION['fname']."',teacher_lname='".$_SESSION['lname']."',teacher_picpath='".$_SESSION['picpath']."' WHERE teacher_email='".$_SESSION['email']."'");

      			if (isset($_SESSION['postid'])) {

      				header("location: teacher.php?page=viewpost&id=".$_SESSION['postid']."&cpid=".$_SESSION['cpid']);

      			} else {

      				header("location: teacher.php");

      			}

      			

      		} else {

      			header("location: index.php?page=checkpoint&type=".$_GET['type']);

      		}



      	} else {

      		$res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_email='".$_SESSION['email']."'");

      		$c = mysqli_num_rows($res);

      		if ($c == 1) {

      			$_SESSION['isLogin'] = "student";

      			$row = mysqli_fetch_array($res);

      			$_SESSION['getstarted'] = $row['student_guide'];
      			$_SESSION['id'] = $row['student_id'];

      			if ($row['student_picpath'] != "nopic.png") {

      				 $_SESSION['picpath'] = $row['student_picpath'];

      			}

      			mysqli_query($con, "UPDATE tblstudent SET student_fname='".$_SESSION['fname']."',student_lname='".$_SESSION['lname']."',student_picpath='".$_SESSION['picpath']."' WHERE student_email='".$_SESSION['email']."'");

      			if (isset($_SESSION['postid'])) {


      				header("location: teacher.php?page=viewpost&id=".$_SESSION['postid']."&cpid=".$_SESSION['cpid']);

      			} else {

      			header("location: student.php");

      			}

      		} else {

      			header("location: index.php?page=checkpoint&type=".$_GET['type']);

      		}


      	}

        
        

      
      }

       
  }

// end of facebook login

// logout both teacher and students



if ($_GET['page'] == "logout") {





	session_destroy();


	//session_start();


	header("location: index.php?page=logout");



	











}





// end of logout



// save newly account



if ($_GET['page'] == "saveaccount") {





	$id = mysqli_real_escape_string($con, $_POST['id']);

	$fname = mysqli_real_escape_string($con, $_SESSION['fname']);

	$lname = mysqli_real_escape_string($con, $_SESSION['lname']);

	$pass 	= mysqli_real_escape_string($con, $_POST['pass']);

	$cpass	= mysqli_real_escape_string($con, $_POST['cpass']);



	if ($_GET['type'] == "teacher") {







		$res 	= mysqli_query($con, "SELECT * FROM tblteacher WHERE employee_id='".$id."'");



		$c 		= mysqli_num_rows($res);



		if ($c == 1) {



			$_SESSION['cerror'] = "Employee ID : ".$id." is already existed.";



			header("location: index.php?page=checkpoint&type=".$_GET['type']);





		} else if (strlen($pass) < 5) {


			$_SESSION['cerror'] = "Password must have atleast 5 characters";

			header("location: index.php?page=checkpoint&type=".$_GET['type']);


		} else if ($pass != $cpass) {

			$_SESSION['cerror'] = "Password mismatch";

			header("location: index.php?page=checkpoint&type=".$_GET['type']);


		} else {



			mysqli_query($con, "INSERT INTO tblteacher VALUES('0','".$id."','".$fname."','".$lname."','".$_SESSION['email']."','".$pass."','".$_SESSION['picpath']."','".$_SESSION['login']."','0','50')");



			$res 	= mysqli_query($con, "SELECT * FROM tblteacher WHERE employee_id='".$id."'");



			$row 	= mysqli_fetch_array($res);



			$_SESSION['id'] = $row['teacher_id'];


			$_SESSION['getstarted'] = 0;


			$_SESSION['isLogin'] = "teacher";

			$_SESSION['basegrade'] = 50;


			header("location: teacher.php");

		}









	} else {





		$res 	= mysqli_query($con, "SELECT * FROM tblstudent WHERE student_num='".$id."'");



		$c 		= mysqli_num_rows($res);



		if ($c == 1) {



			$_SESSION['cerror'] = "Student ID : ".$id." is already existed.";



			header("location: index.php?page=checkpoint&type=".$_GET['type']);





		} else if (strlen($pass) < 5) {


			$_SESSION['cerror'] = "Password must have atleast 5 characters";

			header("location: index.php?page=checkpoint&type=".$_GET['type']);


		} else if ($pass != $cpass) {

			$_SESSION['cerror'] = "Password mismatch";

			header("location: index.php?page=checkpoint&type=".$_GET['type']);


		} else {



			mysqli_query($con, "INSERT INTO tblstudent VALUES('0','".$id."','".$fname."','".$lname."','".$_SESSION['email']."','".$pass."','".$_SESSION['picpath']."','".$_SESSION['login']."','0')");





			$_SESSION['isLogin'] = "student";



			$res 	= mysqli_query($con, "SELECT * FROM tblstudent WHERE student_num='".$id."'");



			$row 	= mysqli_fetch_array($res);

			$_SESSION['getstarted'] = 0;



			$_SESSION['id'] = $row['student_id'];



			header("location: student.php");

		}



	}







}



// end of save account

// start of getting started

if ($_GET['page'] == "getstarted") {

	if ($_GET['type'] == "teacher") {


		mysqli_query($con, "UPDATE tblteacher SET teacher_guide='1' WHERE teacher_id='".$_SESSION['id']."'");

		$_SESSION['getstarted'] = 1;

		header("location: teacher.php");

	} else {

		mysqli_query($con, "UPDATE tblstudent SET student_guide='1' WHERE student_id='".$_SESSION['id']."'");

		$_SESSION['getstarted'] = 1;

		header("location: student.php");

	}


}

// end of getting started



if ($_GET['page'] == "saveperiod") {



	$periodName = mysqli_real_escape_string($con, $_POST['name']);

	$periodDesc = mysqli_real_escape_string($con, $_POST{'desc'});



	$c = mysqli_query($con, "SELECT * FROM tblperiod WHERE teacher_id='".$_SESSION['id']."' AND period_name='".$periodName."'");



	$count = mysqli_num_rows($c);





	if ($count == 1) {



			$_SESSION['cerror'] = "Period Name already existed to your dashboard";





	} else {





			$res = mysqli_query($con, "INSERT INTO tblperiod VALUES('0','".$_SESSION['id']."','".$periodName."','".$periodDesc."','Active')");



			if ($res) {



					$_SESSION['cerror'] = "Success";



					$res = mysqli_query($con, "SELECT * FROM tblperiod WHERE teacher_id='".$_SESSION['id']."' AND period_name='".$periodName."' ORDER BY period_id DESC");



					$cRow = mysqli_fetch_array($res);



					$periodID = $cRow['period_id'];



					$res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



					while($row = mysqli_fetch_array($res)) {





							mysqli_query($con, "INSERT INTO tblclassperiod VALUES('0','".$periodID."','".$row['section_id']."','Active','0','10','40','50')");





					}





			}



	}



	

	header("location: teacher.php?page=createperiod");





}



if ($_GET['page'] == "finishperiod") {



	mysqli_query($con, "UPDATE tblperiod SET period_status='Finish' WHERE section_id='".$_GET['id']."' AND period_status='Active'");



	header("location: teacher.php?page=classpage&id=".$_GET['id']);



}



// save new class



if ($_GET['page'] == "saveclass") {



	/*$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'

                 .'0123456789'); // and any other characters

	shuffle($seed); // probably optional since array_is randomized; this may be redundant

	$rand = '';

	foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k]; */



	$name = mysqli_real_escape_string($con, $_POST['name']);

	$sections = mysqli_real_escape_string($con, $_POST['sections']);

	//$code = mysqli_real_escape_string($con, $_POST['code']);

	$secs = split(",", $sections);


	for($i = 0; $i < count($secs); $i++) {

	$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'

                 .'0123456789'); // and any other characters

	shuffle($seed); // probably optional since array_is randomized; this may be redundant

	$code = '';

	foreach (array_rand($seed, 5) as $k) $code .= $seed[$k];

	$chck = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".strtoupper($name)."' AND section_desc='".strtoupper($secs[$i])."'");

	$chckC = mysqli_num_rows($chck);

	if ($chckC == 0) {


	$res = mysqli_query($con, "INSERT INTO tblsection VALUES('0','".strtoupper($name)."','".strtoupper($secs[$i])."','".$code."','".$_SESSION['id']."','Active')");



		if ($res) {



				$_SESSION['cerror'] = "Success";



				$res = mysqli_query($con, "SELECT * FROm tblsection WHERE section_code='".$code."'");



				$cRow = mysqli_fetch_array($res);



				$id = $cRow['section_id'];



				$res = mysqli_query($con, "SELECT * FROM tblperiod WHERE teacher_id='".$_SESSION['id']."'");



				while($row = mysqli_fetch_array($res)) {





						mysqli_query($con, "INSERT INTO tblclassperiod VALUES('0','".$row['period_id']."','".$id."','Active','0','10','40','50')");





				}




		}

	  } else {


	  	$_SESSION['cerror'] = "Section ".strtoupper($secs[$i])." is already listed under the subject of ".strtoupper($name);

	  	break;
	  }

    }

	header("location: teacher.php?page=createclass");



}



// end of save new class


// save class term



if ($_GET['page'] == "saveclassterm") {



	
	$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'

                 .'0123456789'); // and any other characters

	shuffle($seed); // probably optional since array_is randomized; this may be redundant

	$code = '';

	foreach (array_rand($seed, 5) as $k) $code .= $seed[$k];

	$periodYr = $_POST['yr1']."-".$_POST['yr2'];

	$periodTerm = $_POST['term'];

	$sectionTerm = $periodTerm." ".$periodYr;

	$periodName = $_POST['period'];

	$className = mysqli_real_escape_string($con, $_POST['classname']);

	$sectionCat = mysqli_real_escape_string($con, $_POST['ctgry']);

	$sectionName = mysqli_real_escape_string($con, $_POST['sec']);

	$pRow = "";


	$chck = mysqli_query($con, "SELECT * FROM tblperiod WHERE teacher_id='".$_SESSION['id']."' AND period_name='".$periodName."' AND period_desc='".$periodTerm."' AND period_yr='".$periodYr."' AND section_desc='".$sectionName."'");

	$chckC = mysqli_num_rows($chck);

	if ($chckC == 0) {


		$res = mysqli_query($con, "INSERT INTO tblperiod VALUES('0','".$_SESSION['id']."','".$periodName."','".$periodTerm."','Active','".$periodYr."','".$sectionName."')");

		if ($res) {


			$p = mysqli_query($con, "SELECT * FROM tblperiod WHERE teacher_id='".$_SESSION['id']."' AND period_name='".$periodName."' AND period_desc='".$periodTerm."' AND period_yr='".$periodYr."' AND section_desc='".$sectionName."'");

			$pRow = mysqli_fetch_array($p);

		} else {


			$_SESSION['cerror'] = "Server error occured.";

			header("location: teacher.php?page=createclass");

		}



	} else {


		$pRow = mysqli_fetch_array($chck);

	
	}

	$sec = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".strtoupper($className)."' AND section_desc='".strtoupper($sectionName)."' AND teacher_id='".$_SESSION['id']."' AND section_term='".$sectionTerm."'");

	$secNum = mysqli_num_rows($sec);

	$secRow = "";

	if ($secNum == 0) {

		mysqli_query($con, "INSERT INTO tblsection VALUES('0','".strtoupper($className)."','".strtoupper($sectionName)."','".$code."','".$_SESSION['id']."','Active','".$sectionCat."','".$sectionTerm."')");

		$res = mysqli_query($con, "SELECT * FROM tblsection WHERE section_code='".$code."' AND teacher_id='".$_SESSION['id']."'");

		$secRow = mysqli_fetch_array($res);


		mysqli_query($con, "INSERT INTO tblclassperiod VALUES('0','".$pRow['period_id']."','".$secRow['section_id']."','Active','0','10','40','50')");

		$_SESSION['cerror'] = "Success";


	} else {

		$secRow = mysqli_fetch_array($sec);

		$cp = mysqli_query($con, "SELECT * FROM tblclassperiod WHERE period_id='".$pRow['period_id']."' AND section_id='".$secRow['section_id']."'");

		$cpCount = mysqli_num_rows($cp);

		if ($cpCount == 0) {


			mysqli_query($con, "INSERT INTO tblclassperiod VALUES('0','".$pRow['period_id']."','".$secRow['section_id']."','Active','0','10','40','50')");

			$_SESSION['cerror'] = "Success";

		} else {


			$_SESSION['cerror'] = "Class ".$className." - ".$pRow['period_name']." has been already added to ".$sectionTerm;

		}


							
		
	}



    

	header("location: teacher.php?page=createclass");



}



// end of save new class term

// save new sections



if ($_GET['page'] == "savesections") {



	/*$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'

                 .'0123456789'); // and any other characters

	shuffle($seed); // probably optional since array_is randomized; this may be redundant

	$rand = '';

	foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k]; */



	//$name = mysqli_real_escape_string($con, $_POST['name']);

	$sections = mysqli_real_escape_string($con, $_POST['sections']);

	//$code = mysqli_real_escape_string($con, $_POST['code']);

	$secs = split(",", $sections);


	for($i = 0; $i < count($secs); $i++) {

	//$seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789'); // and any other characters

	//shuffle($seed); // probably optional since array_is randomized; this may be redundant

	//$code = '';

	//foreach (array_rand($seed, 5) as $k) $code .= $seed[$k];

	$chck = mysqli_query($con, "SELECT * FROM tblsections WHERE section_name='".strtoupper($secs[$i])."' AND teacher_id='".$_SESSION['id']."'");

	$chckC = mysqli_num_rows($chck);

		if ($chckC == 0) {


		$res = mysqli_query($con, "INSERT INTO tblsections VALUES('0','".$_SESSION['id']."','".strtoupper($secs[$i])."')");


			if ($res) {



					$_SESSION['cerror'] = "Success";



			} else {

					$_SESSION['cerror'] = "Server error, please try again later.";
			}

		} else {


		  	$_SESSION['cerror'] = "Section ".strtoupper($secs[$i])." is already added.";

		  	break;
		}

    }

	header("location: teacher.php?page=createclass");



}



// end of save new sections



// create activity



if ($_GET['page'] == "createactivity") {



	$dateSpan = "1970-01-01";



	$activityName = mysqli_real_escape_string($con, $_POST['name']);

	$activityDesc = mysqli_real_escape_string($con, $_POST['desc']);

	$activityType = $_POST['activity'];



	mysqli_query($con, "INSERT INTO tblactivity VALUES('0','".$_GET['pid']."','".$_SESSION['id']."','".$activityName."','".$activityDesc."','".$activityType."','".$dateSpan."','".$dateSpan."','30')");





	header("location: teacher.php?page=classperiod&id=".$_GET['id']."&pid=".$_GET['pid']);





}





// end of create activity


// start of update profile teacher

if ($_GET['page'] == "updateprofilet") {

	$fname = mysqli_real_escape_string($con, $_POST['fname']);

	$lname = mysqli_real_escape_string($con, $_POST['lname']);

	$picPath = "";

	if ($_FILES['upload']['name'][0] == "") {



			$picPath = $_SESSION['picpath'];


	} else {

		  $tmpFilePath = $_FILES['upload']['tmp_name'];

		 //save the filename
          $shortname = uniqid().'-'.$_FILES['upload']['name'];

                //save the url and the file
          $picPath = "images/" .  $shortname;


          move_uploaded_file($tmpFilePath, $picPath);

	}

	$res = mysqli_query($con, "UPDATE tblteacher SET teacher_fname='".$fname."',teacher_lname='".$lname."',teacher_picpath='".$picPath."' WHERE teacher_id='".$_SESSION['id']."'");


	if ($res) {

		$_SESSION['fname'] = $fname;

		$_SESSION['lname'] = $lname;

		$_SESSION['picpath'] = $picPath;


	}

	header("location: teacher.php?page=myprofile");


}

// end of teacher

// start of update profile student

if ($_GET['page'] == "updateprofiles") {

	$fname = mysqli_real_escape_string($con, $_POST['fname']);

	$lname = mysqli_real_escape_string($con, $_POST['lname']);

	$picPath = "";

	if ($_FILES['upload']['name'][0] == "") {



			$picPath = $_SESSION['picpath'];


	} else {

		  $tmpFilePath = $_FILES['upload']['tmp_name'];

		 //save the filename
          $shortname = uniqid().'-'.$_FILES['upload']['name'];

                //save the url and the file
          $picPath = "images/" .  $shortname;


          move_uploaded_file($tmpFilePath, $picPath);

	}

	$res = mysqli_query($con, "UPDATE tblstudent SET student_fname='".$fname."',student_lname='".$lname."',student_picpath='".$picPath."' WHERE student_id='".$_SESSION['id']."'");


	if ($res) {

		$_SESSION['fname'] = $fname;

		$_SESSION['lname'] = $lname;

		$_SESSION['picpath'] = $picPath;


	}

	header("location: student.php?page=myprofile");


}


// end of update profile student


// start of post



if ($_GET['page'] == "post") {



	$msg = mysqli_real_escape_string($con, $_POST['msg']);

	$filepaths = "";

	if ($_FILES['upload']['name'][0] == "") {


		$filepaths = "N/A";

	}else if(count($_FILES['upload']['name']) > 0){
        //Loop through each file

        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = uniqid().'-'.$_FILES['upload']['name'][$i];

                //save the url and the file
                $filePath = "uploaded/" .  $shortname;

          
                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {


                	if (count($_FILES['upload']['name']) == ($i + 1)) {

                		$filepaths .= $shortname;

                	} else {

                		$filepaths .= $shortname.",";
                	}

                    //$files[] = $shortname;
                    //insert into db 
                    //use $shortname for the filename
                    //use $filePath for the relative url to the file

                } 
              }
        }

    }

		$filepaths = mysqli_real_escape_string($con, $filepaths);

		//echo $filepaths;

		$typ = "";

		 if ($_GET['type'] == "teacher") {

    	

	    	$typ = "Teacher";

	    } else {

	    	$typ = "Student";

	    }

	    $postDatetime = date("Y-m-d H:i:s");

	    $sec = mysqli_query($con, "SELECT * FROM tblclassperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['id']."' AND tblsection.section_id=tblclassperiod.section_id");

    	$secRow = mysqli_fetch_array($sec);

    	mysqli_query($con, "INSERT INTO tblpost VALUES('0','".$msg."','".$postDatetime."','".$_GET['id']."','".$typ."','".$_SESSION['id']."','Post','0','".$filepaths."','No','".$secRow['section_id']."')");


    	$get = mysqli_query($con, "SELECT * FROM tblpost WHERE post_msg='".$msg."' AND cp_id='".$_GET['id']."' AND post_datetime='".$postDatetime."'");

    	$getRow = mysqli_fetch_array($get);

    	$period = mysqli_query($con, "SELECT * FROM tblperiod WHERE period_id='".$_GET['id']."'");

    	$periodRow = mysqli_fetch_array($period);

    	

    	$secDesc = strtoupper($secRow['section_name']. " - ".$secRow['section_desc']);

    	$secDesc = mysqli_real_escape_string($con, $secDesc);


    if ($_GET['type'] == "teacher") {

    	
    	$res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblclass WHERE tblclassperiod.cp_id='".$_GET['id']."' AND tblclass.section_id=tblclassperiod.section_id");

    	$notifMsg = 'Instructor '.$_SESSION['fname'].' '.$_SESSION['lname'].' has posted on '.$periodRow['period_name'].' timeline.';

    	$notifMsg = mysqli_real_escape_string($con, $notifMsg);

    	while($row = mysqli_fetch_array($res)) {

    		mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row['student_id']."','Post','".$getRow['post_id']."','".$_GET['id']."','".$notifMsg."','".$secDesc."','".$postDatetime."','Unseen','No')");

    	}


    	header("location: teacher.php?page=classperiod&id=".$_GET['id']);

    } else {

    	$res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblclass WHERE tblclassperiod.cp_id='".$_GET['id']."' AND tblclass.section_id=tblclassperiod.section_id AND tblclass.student_id != '".$_SESSION['id']."'");



    	$notifMsg = 'Class President '.$_SESSION['fname'].' '.$_SESSION['lname'].' has posted on '.$periodRow['period_name'].' timeline.';

    	$notifMsg = mysqli_real_escape_string($con, $notifMsg);

    	while($row = mysqli_fetch_array($res)) {

    		mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row['student_id']."','Post','".$getRow['post_id']."','".$_GET['id']."','".$notifMsg."','".$secDesc."','".$postDatetime."','Unseen','No')");

    	}

    	$res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['id']."' AND tblsection.section_id=tblclassperiod.section_id");

    	$row = mysqli_fetch_array($res);

    	mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Teacher','".$row['teacher_id']."','Post','".$getRow['post_id']."','".$_GET['id']."','".$notifMsg."','".$secDesc."','".$postDatetime."','Unseen','No')");


    	header("location: student.php?page=classperiod&id=".$_GET['id']);
    }







}



// end of post

// start of post dashboard



if ($_GET['page'] == "postdashboard") {



	$msg = mysqli_real_escape_string($con, $_POST['msg']);

	$filepaths = "";

	if ($_FILES['upload']['name'][0] == "") {


		$filepaths = "N/A";

	}else if(count($_FILES['upload']['name']) > 0){
        //Loop through each file

        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = uniqid().'-'.$_FILES['upload']['name'][$i];

                //save the url and the file
                $filePath = "uploaded/" .  $shortname;

          
                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $filePath)) {


                	if (count($_FILES['upload']['name']) == ($i + 1)) {

                		$filepaths .= $shortname;

                	} else {

                		$filepaths .= $shortname.",";
                	}

                    //$files[] = $shortname;
                    //insert into db 
                    //use $shortname for the filename
                    //use $filePath for the relative url to the file

                } 
              }
        }

    }

		$filepaths = mysqli_real_escape_string($con, $filepaths);

		//echo $filepaths;

		 $postDatetime = date("Y-m-d H:i:s");

		if ($_POST['priv'] == "All") {


				$sec = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active'");

				while($secRow = mysqli_fetch_array($sec)) {

					

						mysqli_query($con, "INSERT INTO tblpost VALUES('0','".$msg."','".$postDatetime."','0','Teacher','".$_SESSION['id']."','Post','0','".$filepaths."','Yes','".$secRow['section_id']."')");
		

						$get = mysqli_query($con, "SELECT * FROM tblpost WHERE user_type='Teacher' AND user_id='".$_SESSION['id']."' AND cp_id='0' AND post_msg='".$msg."' AND announcement='Yes'");

						$getRow = mysqli_fetch_array($get);


						$secDesc = strtoupper($secRow['section_name']. " - ".$secRow['section_desc']);

						$secDesc = mysqli_real_escape_string($con, $secDesc);


						  $notifMsg = 'Instructor '.$_SESSION['fname'].' '.$_SESSION['lname'].' has posted on '.$secRow['section_name'].'-'.$secRow['section_desc'];

						  $notifMsg = mysqli_real_escape_string($con, $notifMsg);


						   	$res = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$secRow['section_id']."'");

						 	while($row = mysqli_fetch_array($res)) {

						    		mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row['student_id']."','Post','".$getRow['post_id']."','0','".$notifMsg."','".$secDesc."','".$postDatetime."','Unseen','No')");

						    }


				}




		} else {


			$sec = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_id='".$_POST['priv']."' AND section_status='Active'");

			$secRow = mysqli_fetch_array($sec);

				
						mysqli_query($con, "INSERT INTO tblpost VALUES('0','".$msg."','".$postDatetime."','0','Teacher','".$_SESSION['id']."','Post','0','".$filepaths."','Yes','".$_POST['priv']."')");

						$get = mysqli_query($con, "SELECT * FROM tblpost WHERE user_type='Teacher' AND user_id='".$_SESSION['id']."' AND cp_id='0' AND post_msg='".$msg."' AND announcement='Yes'");

						$getRow = mysqli_fetch_array($get);


						$secDesc = strtoupper($secRow['section_name']. " - ".$secRow['section_desc']);

						$secDesc = mysqli_real_escape_string($con, $secDesc);


						  $notifMsg = 'Instructor '.$_SESSION['fname'].' '.$_SESSION['lname'].' has posted on '.$secRow['section_name'].'-'.$secRow['section_desc'];

						  $notifMsg = mysqli_real_escape_string($con, $notifMsg);


						   	$res = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$secRow['section_id']."'");

						 	while($row = mysqli_fetch_array($res)) {

						    		mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row['student_id']."','Post','".$getRow['post_id']."','0','".$notifMsg."','".$secDesc."','".$postDatetime."','Unseen','No')");

						    }


				



		}

	   


    // if ($_GET['type'] == "teacher") {

    	
    // 	$res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblclass WHERE tblclassperiod.cp_id='".$_GET['id']."' AND tblclass.section_id=tblclassperiod.section_id");

    // 	$notifMsg = 'Instructor '.$_SESSION['fname'].' '.$_SESSION['lname'].' has posted on '.$periodRow['period_name'].' timeline.';

    // 	$notifMsg = mysqli_real_escape_string($con, $notifMsg);

    // 	while($row = mysqli_fetch_array($res)) {

    // 		mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row['student_id']."','Post','".$getRow['post_id']."','".$_GET['id']."','".$notifMsg."','".$secDesc."','".$postDatetime."','Unseen','No')");

    // 	}


    // 	header("location: teacher.php?page=classperiod&id=".$_GET['id']);

    // } else {

    // 	$res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblclass WHERE tblclassperiod.cp_id='".$_GET['id']."' AND tblclass.section_id=tblclassperiod.section_id AND tblclass.student_id != '".$_SESSION['id']."'");



    // 	$notifMsg = 'Class President '.$_SESSION['fname'].' '.$_SESSION['lname'].' has posted on '.$periodRow['period_name'].' timeline.';

    // 	$notifMsg = mysqli_real_escape_string($con, $notifMsg);

    // 	while($row = mysqli_fetch_array($res)) {

    // 		mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row['student_id']."','Post','".$getRow['post_id']."','".$_GET['id']."','".$notifMsg."','".$secDesc."','".$postDatetime."','Unseen','No')");

    // 	}

    // 	$res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['id']."' AND tblsection.section_id=tblclassperiod.section_id");

    // 	$row = mysqli_fetch_array($res);

    // 	mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Teacher','".$row['teacher_id']."','Post','".$getRow['post_id']."','".$_GET['id']."','".$notifMsg."','".$secDesc."','".$postDatetime."','Unseen','No')");


    // 	header("location: student.php?page=classperiod&id=".$_GET['id']);
    // }


    header("location: teacher.php");




}



// end of post dashboard


// start of reply teacher

if ($_GET['page'] == "reply") {



	$msg = mysqli_real_escape_string($con, $_POST['msg']);



	mysqli_query($con, "INSERT INTO tblreply VALUES('0','".$_GET['id']."','Teacher','".$msg."','".date("Y-m-d H:i:s")."','".$_SESSION['id']."')");



	header("location: teacher.php?page=viewpost&id=".$_GET['id']."&cpid=".$_GET['cpid']);



}

// end of reply teacher


// start of reply teacher

if ($_GET['page'] == "studentreply") {



	$msg = mysqli_real_escape_string($con, $_POST['msg']);



	mysqli_query($con, "INSERT INTO tblreply VALUES('0','".$_GET['id']."','Student','".$msg."','".date("Y-m-d H:i:s")."','".$_SESSION['id']."')");



	header("location: student.php?page=viewpost&id=".$_GET['id']."&cpid=".$_GET['cpid']);



}

// end of reply teacher


// start of join class



if ($_GET['page'] == "joinclass") {



	

		$chck = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$_GET['id']."' AND student_id='".$_SESSION['id']."'");



		$ch = mysqli_num_rows($chck);



		if ($ch == 0) {


			mysqli_query($con, "INSERT INTO tblclass VALUES('0','".$_GET['id']."','".$_SESSION['id']."','Student','".date("Y-m-d H:i:s")."')");


			$sec = mysqli_query($con, "SELECT * FROM tblsection WHERE section_id='".$_GET['id']."'");

			$secRow = mysqli_fetch_array($sec);

			$title = $secRow['section_name'].' - '.$secRow['section_desc'];

			$title = mysqli_real_escape_string($con, $title);

			$message = $_SESSION['fname'].' '.$_SESSION['lname'].' has joined the class.';

			$message = mysqli_real_escape_string($con, $message);

			$res = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$_GET['id']."' AND student_id !='".$_SESSION['id']."'");

			while($row = mysqli_fetch_array($res)) {


				mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row['student_id']."','Join','0','0','".$message."','".$title."','".date("Y-m-d H:i:s")."','Unseen','No')");

			}


				mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Teacher','".$secRow['teacher_id']."','Join','0','0','".$message."','".$title."','".date("Y-m-d H:i:s")."','Unseen','No')");

		}
	


		header("location: student.php?page=search&keyword=".$_GET['keyword']);


}





// end of join code


// for search code

if ($_GET['page'] == "search") {


	if ($_GET['type'] == "student") {


		header("location: student.php?page=search&keyword=".$_POST['search']);

	} else {

		header("location: teacher.php?page=search&keyword=".$_POST['search']);
	}



}

// end of search code


// create activity

if ($_GET['page'] == "saveactivity") {



	$end = date('Y-m-d', strtotime($_POST['deadline']));

	$today = date("Y-m-d");

	// echo 'Deadline'. $end.'<br />Date Today'.$today;

	if ($end == $today) {

		$_SESSION['cerror'] = "Deadline shoud have atleast 1 day duration.";

		 // header("location: teacher.php?page=classperiod&id=".$_POST['periodID']);


	} else if ($end < $today) {


			$_SESSION['cerror'] = "Deadline should be greater than current date.";

			 // header("location: teacher.php?page=classperiod&id=".$_POST['periodID']);

	} else {


		$name = mysqli_real_escape_string($con, $_POST['activityName']);
		$desc = mysqli_real_escape_string($con, $_POST['activityDesc']);

		$filepaths = "";

			if ($_FILES['upload']['name'][0] == "") {


				$filepaths = "N/A";

			}else if(count($_FILES['upload']['name']) > 0){
		        //Loop through each file

		        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
		          //Get the temp file path
		            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

		            //Make sure we have a filepath
		            if($tmpFilePath != ""){
		            
		                //save the filename
		                $shortname = uniqid().'-'.$_FILES['upload']['name'][$i];

		                //save the url and the file
		                $filePath = "uploaded/" .  $shortname;

		          
		                //Upload the file into the temp dir
		                if(move_uploaded_file($tmpFilePath, $filePath)) {


		                	if (count($_FILES['upload']['name']) == ($i + 1)) {

		                		$filepaths .= $shortname;

		                	} else {

		                		$filepaths .= $shortname.",";
		                	}

		                    //$files[] = $shortname;
		                    //insert into db 
		                    //use $shortname for the filename
		                    //use $filePath for the relative url to the file

		                } 
		              }
		        }

		    }

			$filepaths = mysqli_real_escape_string($con, $filepaths);


		$customID = uniqid().''.$_SESSION['id'].''.$_GET['cpid'];

		$s = mysqli_query($con, "SELECT * FROM tblclassperiod WHERE cp_id='".$_GET['cpid']."'");

		$sRow = mysqli_fetch_array($s);


		$y = date("Y", strtotime($end));

		$m = date("m", strtotime($end));

		$d = date("d", strtotime($end));

		$startDate = date('Y-m-d H:i:s');
		
		$deadline = date('Y-m-d H:i:s', mktime("23","59","59",$m,$d,$y));

		// save first to post

		mysqli_query($con, "INSERT INTO tblpost VALUES ('0','Created an activity : ".$name."','".$startDate."','".$_GET['cpid']."','Teacher','".$_SESSION['id']."','Activity','".$customID."','".$filepaths."','No','".$sRow['section_id']."')");

		// end

		// get the last saved post

		$res = mysqli_query($con, "SELECT * FROM tblpost WHERE custom_id='".$customID."' AND post_type='Activity'");

		$row = mysqli_fetch_array($res);

		// save the activity

		mysqli_query($con, "INSERT INTO tblactivity VALUES('0','".$row['post_id']."','".$_SESSION['id']."','".$name."','".$desc."','".$startDate."','".$deadline."','Open')");


		// get the last saved activity
		$res1 = mysqli_query($con, "SELECT * FROM tblactivity WHERE post_id='".$row['post_id']."'");

		$row1 = mysqli_fetch_array($res1);

		// update post

		$final = mysqli_query($con, "UPDATE tblpost SET custom_id='".$row1['activity_id']."' WHERE post_id='".$row['post_id']."' AND post_type='Activity'");

		if ($final) {

			$_SESSION['cerror']  = "Success";

			mkdir("Activities/Activity".$row1['activity_id']);

			$sec = mysqli_query($con, "SELECT * FROM tblclassperiod,tblsection,tblperiod WHERE tblclassperiod.cp_id='".$_GET['cpid']."' AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id");

			$secRow = mysqli_fetch_array($sec);

			$title = $secRow['section_name']. ' - '.$secRow['section_desc'];

			$title = mysqli_real_escape_string($con, $title);

			$message = "Instructor ".$_SESSION['fname']." has created an activity in ".$secRow['period_name']." timeline, named ".$row1['activity_name'];

			$message = mysqli_real_escape_string($con, $message);

			$res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$secRow['section_id']."'");

			while($row2 = mysqli_fetch_array($res2)) {


				mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row2['student_id']."','Activity','".$row['post_id']."','".$_GET['cpid']."','".$message."','".$title."','".$startDate."','Unseen','No')");

			}




		} else {

			mysqli_query($con, "DELETE FROM tblpost WHERE post_id='".$row['post_id']."'");

			mysqli_query($con, "DELETE FROM tblactivity WHERE post_id='".$row['post_id']."'");

			$_SESSION['cerror']  = "Server error occured.";
		}

	}

	header("location: teacher.php?page=classperiod&id=".$_GET['cpid']);

}

// end of create activity

// start of extend activity

if ($_GET['page'] == "extendactivity") {

	$days = (int)$_POST['days'];

	if ($days > 0) {

		$res = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$_GET['id']."'");

		$row = mysqli_fetch_array($res);

		$deadline = date("Y-m-d H:i:s", strtotime($row['activity_dateend']. ' +'.$days.' days'));

		mysqli_query($con, "UPDATE tblactivity SET activity_dateend='".$deadline."' WHERE activity_id='".$_GET['id']."'");

		$sec = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection WHERE tblpost.custom_id='".$_GET['id']."' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id");

		$secRow = mysqli_fetch_array($sec);


		$title = $secRow['section_name']. ' - '.$secRow['section_desc'];

		$title = mysqli_real_escape_string($con, $title);

	

		$message = "Activity named ".$row['activity_name']." was extended";

		$message = mysqli_real_escape_string($con, $message);

		$res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$secRow['section_id']."'");

		while($row2 = mysqli_fetch_array($res2)) {


			mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row2['student_id']."','Activity','".$row['post_id']."','".$secRow['cp_id']."','".$message."','".$title."','".date("Y-m-d H:i:s")."','Unseen','No')");

		}

	}

	header("location: teacher.php?page=classperiod&id=".$_GET['cpid']);


}

// end of extend activity

// reopen activity

if ($_GET['page'] == "reopenactivity") {


	$days = (int)$_POST['days'];

	if ($days > 0) {

		$res = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$_GET['id']."'");

		$row = mysqli_fetch_array($res);

		$startDate = date('Y-m-d H:i:s');

		$endDate = date('Y-m-d H:i:s', strtotime('+'.$days.' days'));

		$y = date("Y", strtotime($endDate));

		$m = date("m", strtotime($endDate));

		$d = date("d", strtotime($endDate));
		
		$deadline = date('Y-m-d H:i:s', mktime("23","59","59",$m,$d,$y));


		mysqli_query($con, "UPDATE tblactivity SET activity_dateend='".$deadline."',activity_datestart='".$startDate."',activity_status='Open' WHERE activity_id='".$_GET['id']."'");

		$reopenMsg = "Reopened an activity : ".mysqli_real_escape_string($con, $row['activity_name']);

		mysqli_query($con, "UPDATE tblpost SET post_datetime='".$startDate."',post_msg='".$reopenMsg."' WHERE post_id='".$row['post_id']."'");

		$sec = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection WHERE tblpost.custom_id='".$_GET['id']."' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id");

		$secRow = mysqli_fetch_array($sec);


		$title = $secRow['section_name']. ' - '.$secRow['section_desc'];

		$title = mysqli_real_escape_string($con, $title);

		$message = "Activity named ".$row['activity_name']." was reopened";

		$message = mysqli_real_escape_string($con, $message);

		$res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$secRow['section_id']."'");

		while($row2 = mysqli_fetch_array($res2)) {


			mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row2['student_id']."','Activity','".$row['post_id']."','".$secRow['cp_id']."','".$message."','".$title."','".date("Y-m-d H:i:s")."','Unseen','No')");

		}

		unlink("Activity".$_GET['id'].".zip");

	}

	header("location: teacher.php?page=classperiod&id=".$_GET['cpid']);



}

// end of reopen

// start of closed activity

if ($_GET['page'] == "closeactivity") {

	mysqli_query($con, "UPDATE tblactivity SET activity_status='Closed' WHERE activity_id='".$_GET['id']."'");

	/*$the_folder = 'Activities/Activity'.$_GET['id'];
	$zip_file_name = 'Activity'.$_GET['id'].'.zip';



		$za = new FlxZipArchive;
		$res = $za->open($zip_file_name, ZipArchive::CREATE);
		if($res === TRUE)    {
		    $za->addDir($the_folder, basename($the_folder)); $za->close();
		}
		else  { 

			//echo 'Could not create a zip archive';

		} */


	header("location: teacher.php?page=viewgrade&id=".$_GET['id']);

}

// end of closed activity

// start of extend test

if ($_GET['page'] == "extendtest") {

	$days = (int)$_POST['days'];

	if ($days > 0) {

		$res = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$_GET['id']."'");

		$row = mysqli_fetch_array($res);

		$deadline = date("Y-m-d H:i:s", strtotime($row['test_dateend']. ' +'.$days.' days'));

		mysqli_query($con, "UPDATE tbltest SET test_dateend='".$deadline."' WHERE test_id='".$_GET['id']."'");

		$sec = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection WHERE tblpost.custom_id='".$_GET['id']."' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id");

		$secRow = mysqli_fetch_array($sec);


		$title = $secRow['section_name']. ' - '.$secRow['section_desc'];

		$title = mysqli_real_escape_string($con, $title);

	

		$message = $row['test_type']." named ".$row['test_name']." was extended";

		$message = mysqli_real_escape_string($con, $message);

		$res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$secRow['section_id']."'");

		while($row2 = mysqli_fetch_array($res2)) {


			mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row2['student_id']."','".$row['test_type']."','".$row['post_id']."','".$secRow['cp_id']."','".$message."','".$title."','".date("Y-m-d H:i:s")."','Unseen','No')");

		}

	}

	if (isset($_GET['cpid'])) {

		header("location: teacher.php?page=classperiod&id=".$_GET['cpid']);

	} else {

		header("location: teacher.php?page=viewtest&id=".$_GET['id']);
	}


}

// end of extend test

// reopen test

if ($_GET['page'] == "reopentest") {


	$days = (int)$_POST['days'];

	if ($days > 0) {

		$res = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$_GET['id']."'");

		$row = mysqli_fetch_array($res);

		$startDate = date('Y-m-d H:i:s');

		$endDate = date('Y-m-d H:i:s', strtotime('+'.$days.' days'));

		$y = date("Y", strtotime($endDate));

		$m = date("m", strtotime($endDate));

		$d = date("d", strtotime($endDate));
		
		$deadline = date('Y-m-d H:i:s', mktime("23","59","59",$m,$d,$y));


		mysqli_query($con, "UPDATE tbltest SET test_dateend='".$deadline."',test_datestart='".$startDate."',test_status='Published' WHERE test_id='".$_GET['id']."'");

		$reopenMsg = "Reopened a ".strtolower($row['test_type'])." : ".mysqli_real_escape_string($con, $row['test_name']);

		mysqli_query($con, "UPDATE tblpost SET post_datetime='".$startDate."',post_msg='".$reopenMsg."' WHERE post_id='".$row['post_id']."'");

		$sec = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection WHERE tblpost.custom_id='".$_GET['id']."' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id");

		$secRow = mysqli_fetch_array($sec);


		$title = $secRow['section_name']. ' - '.$secRow['section_desc'];

		$title = mysqli_real_escape_string($con, $title);

		$message = $row['test_type']." named ".$row['test_name']." was reopened";

		$message = mysqli_real_escape_string($con, $message);

		$res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$secRow['section_id']."'");

		while($row2 = mysqli_fetch_array($res2)) {


			mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row2['student_id']."','".$row['test_type']."','".$row['post_id']."','".$secRow['cp_id']."','".$message."','".$title."','".date("Y-m-d H:i:s")."','Unseen','No')");

		}


	}

	if (isset($_GET['cpid'])) {

		header("location: teacher.php?page=classperiod&id=".$_GET['cpid']);

	} else {

		header("location: teacher.php?page=viewtest&id=".$_GET['id']);
	}



}

// end of reopen test

// publish test

if ($_GET['page'] == "publishtest") {


	$days = (int)$_POST['days'];

	if ($days > 0) {

		$res = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$_GET['id']."'");

		$row = mysqli_fetch_array($res);

		$startDate = date('Y-m-d H:i:s');

		$endDate = date('Y-m-d H:i:s', strtotime('+'.$days.' days'));

		$y = date("Y", strtotime($endDate));

		$m = date("m", strtotime($endDate));

		$d = date("d", strtotime($endDate));
		
		$deadline = date('Y-m-d H:i:s', mktime("23","59","59",$m,$d,$y));


		mysqli_query($con, "UPDATE tbltest SET test_dateend='".$deadline."',test_datestart='".$startDate."',test_status='Published' WHERE test_id='".$_GET['id']."'");

		$reopenMsg = "Created a ".strtolower($row['test_type'])." : ".mysqli_real_escape_string($con, $row['test_name']);

		mysqli_query($con, "UPDATE tblpost SET post_datetime='".$startDate."',post_msg='".$reopenMsg."' WHERE post_id='".$row['post_id']."'");

		$sec = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection WHERE tblpost.custom_id='".$_GET['id']."' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id");

		$secRow = mysqli_fetch_array($sec);


		$title = $secRow['section_name']. ' - '.$secRow['section_desc'];

		$title = mysqli_real_escape_string($con, $title);

		$message = "Instructor ".$_SESSION['fname']." has created a ".strtolower($row['test_type'])." in ".$secRow['period_name']." timeline, named ".$row['test_name'];

		$message = mysqli_real_escape_string($con, $message);

		$res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$secRow['section_id']."'");

		while($row2 = mysqli_fetch_array($res2)) {


			mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row2['student_id']."','".$row['test_type']."','".$row['post_id']."','".$secRow['cp_id']."','".$message."','".$title."','".date("Y-m-d H:i:s")."','Unseen','No')");

		}


	}

	if (isset($_GET['cpid'])) {

		header("location: teacher.php?page=classperiod&id=".$_GET['cpid']);

	} else {

		header("location: teacher.php?page=viewtest&id=".$_GET['id']);
	}



}

// end of publish test

// start of editing name test

if ($_GET['page'] == "updatetestname") {


	$name = mysqli_real_escape_string($con, $_POST['name']);

	mysqli_query($con, "UPDATE tbltest SET test_name='".$name."' WHERE test_id='".$_GET['id']."'");

	header("location: teacher.php?page=viewtest&id=".$_GET['id']);


}


// end of editing name test

// start of editing desc test

if ($_GET['page'] == "updatetestdesc") {

	$desc = mysqli_real_escape_string($con, $_POST['desc']);

	mysqli_query($con, "UPDATE tbltest SET test_desc='".$desc."' WHERE test_id='".$_GET['id']."'");

	header("location: teacher.php?page=viewtest&id=".$_GET['id']);

}


// end of editing desc test


// start of make president

if ($_GET['page'] == "makepresident") {

	mysqli_query($con, "UPDATE tblclass SET class_status='Class President' WHERE class_id='".$_GET['class']."'");

	// header("location: teacher.php?page=students&id=".$_GET['id']);

	header("location: teacher.php?page=classperiod&id=".$_GET['id']);

}

// end of make president

// start of remove president

if ($_GET['page'] == "removepresident") {

	mysqli_query($con, "UPDATE tblclass SET class_status='Student' WHERE class_id='".$_GET['class']."'");

	// header("location: teacher.php?page=students&id=".$_GET['id']);

	header("location: teacher.php?page=classperiod&id=".$_GET['id']);

}

// end of remove president

// start of submit activity 

if ($_GET['page'] == "submit") {


	 $tmpFilePath = $_FILES['upload']['tmp_name'];

	 //save the filename
     $shortname = $_FILES['upload']['name'];

     //save the url and the file
     
     $filePath = "Activities/Activity".$_GET['activity']."/" .  $shortname;


          
                //Upload the file into the temp dir
      if(move_uploaded_file($tmpFilePath, $filePath)) {


      		$shortname = mysqli_real_escape_string($con, $shortname);

      		mysqli_query($con, "INSERT INTO tblsubmit VALUES('0','".$_GET['activity']."','".$_SESSION['id']."','".date('Y-m-d H:i:s')."','0','N/A','Done','".$shortname."')");

      		$sec = mysqli_query($con, "SELECT * FROM tblactivity,tblpost,tblclassperiod,tblsection WHERE tblactivity.activity_id='".$_GET['activity']."' AND tblpost.custom_id=tblactivity.activity_id AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id");

      		$secRow = mysqli_fetch_array($sec);

      		$title = $secRow['section_name']." - ".$secRow['section_desc'];

      		$title = mysqli_real_escape_string($con, $title);

      		$message = $_SESSION['fname'].' '.$_SESSION['lname'].' has submitted an activity to '.$secRow['activity_name'];

      		$message = mysqli_real_escape_string($con ,$message);

      		$ids = $_GET['activity'].",".$_SESSION['id'];

      		mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Teacher','".$secRow['teacher_id']."','Submit','".$ids."','".$secRow['cp_id']."','".$message."','".$title."','".date('Y-m-d H:i:s')."','Unseen','No')");

      }

      header("location: student.php?page=viewpost&id=".$_GET['id']."&cpid=".$_GET['cpid']); 


}


// end of submit activity

// start of notifications

if ($_GET['page'] == "notifications") {


	   $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_POST['id']."' AND user_type='".$_POST['type']."' AND status='Unseen'");

	   $c = mysqli_num_rows($res);

	   if ($c != 0) {

	   		$row = mysqli_fetch_array($res);

	   		if ($row['post_type'] == "Activity" || $row['post_type'] == "Quiz" || $row['post_type'] == "Exam") {

	   			$type = "danger";

	   			$redirect = "no";

	   			$link = '<a href="?page=viewpost&id='.$row['custom_id'].'&cpid='.$row['cp_id'].'" style="color: white;" target="_blank">'.$row['message'].'</a>
	   			<small>'.timeAgo($row['notif_datetime']).'</small>';


	   		} else if ($row['post_type'] == "Post") {


	   			$type = "success";

	   			$redirect = "no";

	   			$link = '<a href="?page=viewpost&id='.$row['custom_id'].'&cpid='.$row['cp_id'].'" style="color: white;" target="_blank">'.$row['message'].'</a> 
	   			<small>'.timeAgo($row['notif_datetime']).'</small>';

	   		} else if ($row['post_type'] == "Submit") {

	   			$type = "info";

	   			$redirect = "no";

	   			$ids = split(",", $row['custom_id']);

	   			$link = '<a href="?page=viewgrade&id='.$ids[0].'" style="color: white;" target="_blank">'.$row['message'].'</a> 
	   			<small>'.timeAgo($row['notif_datetime']).'</small>';

	   		} else if ($row['post_type'] == "Join") {

	   			$type = "info";

	   			$redirect = "no";

	   			$link = $row['message'].'
	   			<small>'.timeAgo($row['notif_datetime']).'</small>';

	   		} else if ($row['post_type'] == "Kick") {

	   			$type = "danger";

	   			$redirect = "yes";

	   			$link = $row['message'].'
	   			<small>'.timeAgo($row['notif_datetime']).'</small>';

	   		} else if ($row['post_type'] == "Deactivate") {


	   			$type = "danger";

	   			$redirect = "yes";

	   			$link = $row['message'].'
	   			<small>'.timeAgo($row['notif_datetime']).'</small>';

	   		}

	   		$title = $row['title'];

	   		

	   		mysqli_query($con, "UPDATE tblnotifications SET status='Seen' WHERE notification_id='".$row['notification_id']."'");

	   		echo $c.'~'.$title.'~'.$link.'~'.$type.'~'.$redirect;


	   } else {


	   		echo '0~0~0~0';

	   }

}


// end of notifications

// start of notification count

if ($_GET['page'] == "checknotif") {


	$res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='".$_POST['type']."' AND notif_seen='No'");

	$c = mysqli_num_rows($res);

	echo $c;

}

/// end of notification count

// start of send message

if ($_GET['page'] == "sendmessage") {


	$msg = mysqli_real_escape_string($con, $_POST['msg']);


	$res = mysqli_query($con, "SELECT * FROM tblconversation WHERE sender_id='".$_SESSION['id']."' AND sender_type='".$_SESSION['isLogin']."' AND myuser_id='".$_GET['id']."' AND myuser_type='".$_GET['type']."'");

	$c = mysqli_num_rows($res);

	if ($c == 0) {


		mysqli_query($con, "INSERT INTO tblconversation VALUES('0','".$_GET['id']."','".$_GET['type']."','".$_SESSION['id']."','".$_SESSION['isLogin']."','Unseen','".date('Y-m-d H:i:s')."')");

		mysqli_query($con, "INSERT INTO tblconversation VALUES('0','".$_SESSION['id']."','".$_SESSION['isLogin']."','".$_GET['id']."','".$_GET['type']."','Sent','".date('Y-m-d H:i:s')."')");


	}

	$res1  = mysqli_query($con, "SELECT * FROM tblconversation WHERE sender_id='".$_SESSION['id']."' AND sender_type='".$_SESSION['isLogin']."' AND myuser_id='".$_GET['id']."' AND myuser_type='".$_GET['type']."'");

	$row1 = mysqli_fetch_array($res1);

	$res2  = mysqli_query($con, "SELECT * FROM tblconversation WHERE sender_id='".$_GET['id']."' AND sender_type='".$_GET['type']."' AND myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."'");

	$row2 = mysqli_fetch_array($res2);



	mysqli_query($con, "INSERT INTO tblmessage VALUES('0','".$row1['conversation_id']."','".$_SESSION['id']."','".$_SESSION['isLogin']."','".$msg."','Unseen','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')");

	mysqli_query($con, "UPDATE tblconversation SET conversation_status='Unseen',conversation_datetime='".date("Y-m-d H:i:s")."' WHERE conversation_id='".$row1['conversation_id']."'");

	mysqli_query($con, "INSERT INTO tblmessage VALUES('0','".$row2['conversation_id']."','".$_SESSION['id']."','".$_SESSION['isLogin']."','".$msg."','Sent','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')");

	mysqli_query($con, "UPDATE tblconversation SET conversation_status='Sent',conversation_datetime='".date("Y-m-d H:i:s")."' WHERE conversation_id='".$row2['conversation_id']."'");

	$_SESSION['msg'] = "You have sent a message";

	if ($_SESSION['isLogin'] == "student") {


		if ($_GET['type'] == "student") {


		header("location: student.php?page=viewstudent&id=".$_GET['id']);

		} else {


		header("location: student.php?page=viewteacher&id=".$_GET['id']);

		}



	} else {


		if ($_GET['type'] == "student") {


		header("location: teacher.php?page=viewstudent&id=".$_GET['id']);

		} else {


		header("location: teacher.php?page=viewteacher&id=".$_GET['id']);

		}



	}

	
	


}


// end of send message


// start of quick compose msg

if ($_GET['page'] == "composemsg") {


	$msg = mysqli_real_escape_string($con, $_POST['msg']);


	$res = mysqli_query($con, "SELECT * FROM tblconversation WHERE sender_id='".$_SESSION['id']."' AND sender_type='".$_SESSION['isLogin']."' AND myuser_id='".$_POST['id']."' AND myuser_type='".$_POST['type']."'");

	$c = mysqli_num_rows($res);

	if ($c == 0) {


		mysqli_query($con, "INSERT INTO tblconversation VALUES('0','".$_POST['id']."','".$_POST['type']."','".$_SESSION['id']."','".$_SESSION['isLogin']."','Unseen','".date('Y-m-d H:i:s')."')");

		mysqli_query($con, "INSERT INTO tblconversation VALUES('0','".$_SESSION['id']."','".$_SESSION['isLogin']."','".$_POST['id']."','".$_POST['type']."','Sent','".date('Y-m-d H:i:s')."')");


	}

	$res1  = mysqli_query($con, "SELECT * FROM tblconversation WHERE sender_id='".$_SESSION['id']."' AND sender_type='".$_SESSION['isLogin']."' AND myuser_id='".$_POST['id']."' AND myuser_type='".$_POST['type']."'");

	$row1 = mysqli_fetch_array($res1);

	$res2  = mysqli_query($con, "SELECT * FROM tblconversation WHERE sender_id='".$_POST['id']."' AND sender_type='".$_POST['type']."' AND myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."'");

	$row2 = mysqli_fetch_array($res2);



	mysqli_query($con, "INSERT INTO tblmessage VALUES('0','".$row1['conversation_id']."','".$_SESSION['id']."','".$_SESSION['isLogin']."','".$msg."','Unseen','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')");

	mysqli_query($con, "UPDATE tblconversation SET conversation_status='Unseen',conversation_datetime='".date("Y-m-d H:i:s")."' WHERE conversation_id='".$row1['conversation_id']."'");

	mysqli_query($con, "INSERT INTO tblmessage VALUES('0','".$row2['conversation_id']."','".$_SESSION['id']."','".$_SESSION['isLogin']."','".$msg."','Sent','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')");

	mysqli_query($con, "UPDATE tblconversation SET conversation_status='Sent',conversation_datetime='".date("Y-m-d H:i:s")."' WHERE conversation_id='".$row2['conversation_id']."'");

	echo 'success';



}



// end of quick compose msg

// start of search user

if ($_GET['page'] == "searchuser") {


	$html = "";

	
                          $userCount = 0;


	$search = mysqli_real_escape_string($con, $_POST['search']);

	if ($_SESSION['isLogin'] == "student") {
 	

			$res = mysqli_query($con, "SELECT * FROM tblstudent WHERE CONCAT_WS(' ', student_fname, student_lname) LIKE '%".$search."%' AND student_id != '".$_SESSION['id']."' OR student_email='".$search."' AND student_id != '".$_SESSION['id']."'");

	} else {

			$res = mysqli_query($con, "SELECT * FROM tblstudent WHERE CONCAT_WS(' ', student_fname, student_lname) LIKE '%".$search."%' OR student_email='".$search."'");

	}

			
                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                              
                                  if ($c == 0) {

                                  	$userCount += 1;

                                     $html .='<div class="form-group">
                                        <img src="'.$row['student_picpath'].'" style="width:68px;"> <br />
                                          <p><b id="sname'.$row['student_id'].'">'.$row['student_fname'].' '.$row['student_lname'].'</b> <br />
                                          <span>Student #'.$row['student_num'].'</span> <br />
                                          <button type="button" onclick="selectedStudent('.$row['student_id'].');" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i> Message Me</button></p>
                                      </div>

                                         <div style="width:60px;" class="form-group">
                                            &nbsp;

                                            <input type="hidden" id="studid'.$row['student_id'].'" value="'.$row['student_num'].'">
                                        </div>';


                                    $max += 1;
                                  }

                                  if ($max == 2) {


                                    break;
                                  }



                              }


                   if ($_SESSION['isLogin'] == "teacher") {

                   		$res = mysqli_query($con, "SELECT * FROM tblteacher WHERE CONCAT_WS(' ', teacher_fname, teacher_lname) LIKE '%".$search."%' AND teacher_id != '".$_SESSION['id']."' OR teacher_email='".$search."' AND teacher_id !='".$_SESSION['id']."'");

                   } else {

                   		$res = mysqli_query($con, "SELECT * FROM tblteacher WHERE CONCAT_WS(' ', teacher_fname, teacher_lname) LIKE '%".$search."%' OR teacher_email='".$search."'");

                   }
                             

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);

                              
                                  if ($c == 0) {

                                  	    $userCount += 1;

                                     $html .='<div class="form-group">
                                        <img src="'.$row['teacher_picpath'].'" style="width:68px;"> <br />
                                          <p><b id="tname'.$row['teacher_id'].'">'.$row['teacher_fname'].' '.$row['teacher_lname'].'</b> <br />
                                          <span>Teacher #'.$row['employee_id'].'</span> <br />
                                          <button type="button" onclick="selectedTeacher('.$row['teacher_id'].');" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i> Message Me</button></p>


                                      </div>

                                         <div style="width:60px;" class="form-group">
                                            &nbsp;
                                            <input type="hidden" id="empid'.$row['teacher_id'].'" value="'.$row['employee_id'].'">
                                        </div>';


                                    $max += 1;
                                  }

                                  if ($max == 2) {


                                    break;
                                  }



                      }


                     if ($userCount == 0) {


                     	$html .='<h3>No Users Found</h3>';

                     } 

                   echo $html;



}


// end of search user

// start of message count

if ($_GET['page'] == "checkinbox") {

	$res = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_POST['type']."' AND conversation_status='Unseen'");

	$c = mysqli_num_rows($res);

	echo $c;


}

// end of message count

// start of load notifs

if ($_GET['page'] == "loadnotifs") {


	mysqli_query($con, "UPDATE tblnotifications SET notif_seen='Yes' WHERE user_id='".$_SESSION['id']."' AND user_type='".$_POST['type']."' AND notif_seen='No'");


	$res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='".$_POST['type']."' AND post_type != 'Join' ORDER BY notif_datetime DESC LIMIT 7");

	$c = mysqli_num_rows($res);

	$html = "";

	if ($c == 0) {

		$html .=' <li>

                      <div class="text-center">

                        <a>

                          <strong>You have no notifications</strong>

                        </a>

                      </div>

                    </li>';

	} else {

		while($row = mysqli_fetch_array($res)) {

			$userFullname = "";

			$userPic = "";

			$link = "";

			$isAdd = false;


			if ($row['post_type'] == "Post") {


			

				$link = '?page=viewpost&id='.$row['custom_id'].'&cpid='.$row['cp_id'];

				$isAdd = true;

			} else if ($row['post_type'] == "Activity") {


				$link = '?page=viewpost&id='.$row['custom_id'].'&cpid='.$row['cp_id'];

				$isAdd = true;

			} else if ($row['post_type'] == "Submit") {

				$ids = split(",", $row['custom_id']);

				$link = '?page=viewgrade&id='.$ids[0];

				$isAdd = true;

			} else if ($row['post_type'] == "Quiz" || $row['post_type'] == "Exam") {


				$test = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$row['custom_id']."'");

				$testRow = mysqli_fetch_array($test);

				$link = '?page=viewtest&id='.$testRow['custom_id'];

				$isAdd = true;


			}


			if ($isAdd == true) {

				$ids = split(",", $row['custom_id']);

				$p = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection WHERE tblpost.post_id='".$ids[0]."' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id");

				$pRow = mysqli_fetch_array($p);

				if ($pRow['user_type'] == "Teacher"){

					$user = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$pRow['user_id']."'");

					$userRow = mysqli_fetch_array($user);

					$userFullname = $userRow['teacher_fname'].' '.$userRow['teacher_lname'];

					$userPic = $userRow['teacher_picpath'];


				} else {

					$user = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id='".$pRow['user_id']."'");

					$userRow = mysqli_fetch_array($user);

					$userFullname = $userRow['student_fname'].' '.$userRow['student_lname'];

					$userPic = $userRow['student_picpath'];

				}

				$html .='<li>

	                      <a href="'.$link.'">

	                        <span class="image">

	                                          <img src="'.$userPic.'" alt="Profile Image" />

	                                      </span>

	                        <span>

	                                          <span>'.$userFullname.'</span>
	                                          <span class="time">'.timeAgo($row['notif_datetime']).'</span>


	                         </span>

	                        <span class="message">

	                         <b>['.$pRow['section_name'].' - '.$pRow['section_desc'].']</b> '.$row['message'].'

	                                      </span>

	                      </a>

	                    </li>';



             }


		}

		$html .='<li>

                      <div class="text-center">

                        <a href="#"" data-toggle="modal" data-target="#showNotif">

                          <strong>View All Notifications</strong>

                          <i class="fa fa-angle-right"></i>

                        </a>

                      </div>

                    </li>';


	}

	echo $html;


}


// end

// start of refresh notif

if ($_GET['page'] == "refnotif") {



	  $html ='<ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='".$_SESSION['isLogin']."' AND post_type != 'Join' ORDER BY notif_datetime DESC");


                          while($row = mysqli_fetch_array($res)) {

                                      $userFullname = "";

                                      $userPic = "";

                                      $link = "";

                                      $isAdd = false;


                                      if ($row['post_type'] == "Post") {


                                      

                                        $link = '?page=viewpost&id='.$row['custom_id'].'&cpid='.$row['cp_id'];

                                        $isAdd = true;

                                      } else if ($row['post_type'] == "Activity") {


                                        $link = '?page=viewpost&id='.$row['custom_id'].'&cpid='.$row['cp_id'];

                                        $isAdd = true;

                                      } else if ($row['post_type'] == "Submit") {

                                        $ids = split(",", $row['custom_id']);

                                        $link = '?page=viewgrade&id='.$ids[0];

                                        $isAdd = true;

                                      } else if ($row['post_type'] == "Quiz" || $row['post_type'] == "Exam") {


                                        $test = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$row['custom_id']."'");

                                        $testRow = mysqli_fetch_array($test);

                                        $link = '?page=viewtest&id='.$testRow['custom_id'];

                                        $isAdd = true;


                                      }


                                      if ($isAdd == true) {

                                        $ids = split(",", $row['custom_id']);

                                          $p = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection WHERE tblpost.post_id='".$ids[0]."' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id");

                                        $pRow = mysqli_fetch_array($p);

                                        if ($pRow['user_type'] == "Teacher"){

                                          $user = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$pRow['user_id']."'");

                                          $userRow = mysqli_fetch_array($user);

                                          $userFullname = $userRow['teacher_fname'].' '.$userRow['teacher_lname'].' <i class="fa fa-check-circle"></i>';

                                          $userPic = $userRow['teacher_picpath'];


                                        } else {

                                          $user = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id='".$pRow['user_id']."'");

                                          $userRow = mysqli_fetch_array($user);

                                          $userFullname = $userRow['student_fname'].' '.$userRow['student_lname'].' <i class="fa fa-check-circle-o"></i>';

                                          $userPic = $userRow['student_picpath'];

                                        }

                                        $html .='<li>

                                                        <a href="'.$link.'">

                                                          <span class="image">

                                                                            <img src="'.$userPic.'" style="width:68px;" alt="Profile Image" />

                                                                        </span>

                                                          <span>

                                                                            <span>'.$userFullname.'</span>
                                                                            <span class="time">'.timeAgo($row['notif_datetime']).'&nbsp;&nbsp;&nbsp;</span>


                                                           </span>

                                                          <span class="message">

                                                           <h5><b>['.$pRow['section_name'].' - '.$pRow['section_desc'].']</b> '.$row['message'].'</h5>

                                                                        </span>

                                                        </a>

                                                      </li>';



                                             }


                                    }
                        

                     echo $html;

}


// end of refresh notif

// start of load inbox

if ($_GET['page'] == "loadinbox") {

	mysqli_query($con, "UPDATE tblconversation SET conversation_status='Seen' WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_POST['type']."' AND conversation_status='Unseen'");


	$res = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_POST['type']."' ORDER BY conversation_datetime DESC LIMIT 5");

	$c = mysqli_num_rows($res);

	$html = "";

	if ($c == 0) {

		$html .=' <li>

                      <div class="text-center">

                        <a>

                          <strong>You have no messages</strong>

                        </a>

                      </div>

                    </li>';

	} else {

		while($row = mysqli_fetch_array($res)) {


				$userFullname = "";

				$userPic = "";

			if ($row['sender_type'] == "teacher") {

				$user = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$row['sender_id']."'");

				$userRow = mysqli_fetch_array($user);

				$userFullname = $userRow['teacher_fname'].' '.$userRow['teacher_lname'];

				$userPic = $userRow['teacher_picpath'];


			} else {

				$user = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id='".$row['sender_id']."'");

				$userRow = mysqli_fetch_array($user);

				$userFullname = $userRow['student_fname'].' '.$userRow['student_lname'];

				$userPic = $userRow['student_picpath'];

			}

			$msg = mysqli_query($con, "SELECT * FROM tblmessage WHERE conversation_id='".$row['conversation_id']."' ORDER BY date_sent DESC");

			$msgRow = mysqli_fetch_array($msg);

			$html .='<li>

                      <a href="?page=inbox&id='.$row['conversation_id'].'">

                        <span class="image">

                                          <img src="'.$userPic.'" alt="Profile Image" />

                                      </span>

                        <span>

                                          <span>'.$userFullname.'</span>';

                        if ($msgRow['status'] == "Unseen") {

                        	$html .='<span class="time">'.timeAgo($msgRow['date_sent']).' <i class="fa fa-dot-circle-o"></i></span>';

                        } else if ($msgRow['status'] == "Seen") {

                        	$html .='<span class="time">'.timeAgo($msgRow['date_seen']).' <i class="fa fa-check"></i></span>';

                        } else {

                        	$html .='<span class="time">'.timeAgo($msgRow['date_sent']).' <i class="fa fa-mail-forward"></i></span>';
                        }

                       
                        $html .='</span>

                        <span class="message">

                                          '.substr($msgRow['message'], 0, 50).'

                                      </span>

                      </a>

                    </li>';


		}

		$html .='<li>

                      <div class="text-center">

                        <a href="?page=inbox">

                          <strong>See All Messages</strong>

                          <i class="fa fa-angle-right"></i>

                        </a>

                      </div>

                    </li>';


	}

	echo $html;



}

// end of load inbox

// start of check msg


if ($_GET['page'] == "checkmsg") {


  $res = mysqli_query($con, "SELECT * FROM tblmessage WHERE conversation_id='".$_POST['id']."'");

  $c = mysqli_num_rows($res);

  echo $c;




}

// end of check msg

// start of load chat

if ($_GET['page'] == "loadChat") {

	$res = mysqli_query($con, "SELECT * FROM tblmessage WHERE conversation_id='".$_POST['id']."' ORDER BY date_sent DESC");

	$row = mysqli_fetch_array($res);

	if ($row['user_id'] == $_SESSION['id'] && $row['user_type'] == $_SESSION['isLogin']) {

		echo '<h4 class="pull-right"><b>Me</b></h4> <br /> <br />

		<span class="pull-right" title="Sent '.timeAgo($row['date_sent']).'">'.$row['message'].' </span> <br />

		<br />';


	} else {

		echo '<h4 class="pull-left"><b>'.$_POST['name'].'</b></h4> <br /> <br />

		<span class="pull-left" title="Sent '.timeAgo($row['date_sent']).'">'.$row['message'].' </span> <br />

		<br />';



	}

}

// end of count conversation

// start of reply message

if ($_GET['page'] == "msgreply") {

	$msg = mysqli_real_escape_string($con, $_POST['msg']);


	$res1  = mysqli_query($con, "SELECT * FROM tblconversation WHERE sender_id='".$_SESSION['id']."' AND sender_type='".$_SESSION['isLogin']."' AND myuser_id='".$_POST['sid']."' AND myuser_type='".$_POST['stype']."'");

	$row1 = mysqli_fetch_array($res1);

	$res2  = mysqli_query($con, "SELECT * FROM tblconversation WHERE sender_id='".$_POST['sid']."' AND sender_type='".$_POST['stype']."' AND myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."'");

	$row2 = mysqli_fetch_array($res2);

	mysqli_query($con, "INSERT INTO tblmessage VALUES('0','".$row1['conversation_id']."','".$_SESSION['id']."','".$_SESSION['isLogin']."','".$msg."','Unseen','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')");

	mysqli_query($con, "UPDATE tblconversation SET conversation_status='Unseen',conversation_datetime='".date("Y-m-d H:i:s")."' WHERE conversation_id='".$row1['conversation_id']."'");

	mysqli_query($con, "INSERT INTO tblmessage VALUES('0','".$row2['conversation_id']."','".$_SESSION['id']."','".$_SESSION['isLogin']."','".$msg."','Sent','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')");

	mysqli_query($con, "UPDATE tblconversation SET conversation_status='Sent',conversation_datetime='".date("Y-m-d H:i:s")."' WHERE conversation_id='".$row2['conversation_id']."'");



}

// end of reply message

// start of save test

if ($_GET['page'] == "savetest") {


		
	$end = date('Y-m-d', strtotime($_POST['deadline']));

	$today = date("Y-m-d");

	// echo 'Deadline'. $end.'<br />Date Today'.$today;

	if ($end == $today) {

		$_SESSION['terror'] = "Deadline shoud have atleast 1 day duration.";

		 // header("location: teacher.php?page=classperiod&id=".$_POST['periodID']);


	} else if ($end < $today) {


			$_SESSION['terror'] = "Deadline should be greater than current date.";

			 // header("location: teacher.php?page=classperiod&id=".$_POST['periodID']);

	} else {

			$filepaths = "";

			if ($_FILES['upload']['name'][0] == "") {


				$filepaths = "N/A";

			}else if(count($_FILES['upload']['name']) > 0){
		        //Loop through each file

		        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
		          //Get the temp file path
		            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

		            //Make sure we have a filepath
		            if($tmpFilePath != ""){
		            
		                //save the filename
		                $shortname = uniqid().'-'.$_FILES['upload']['name'][$i];

		                //save the url and the file
		                $filePath = "uploaded/" .  $shortname;

		          
		                //Upload the file into the temp dir
		                if(move_uploaded_file($tmpFilePath, $filePath)) {


		                	if (count($_FILES['upload']['name']) == ($i + 1)) {

		                		$filepaths .= $shortname;

		                	} else {

		                		$filepaths .= $shortname.",";
		                	}

		                    //$files[] = $shortname;
		                    //insert into db 
		                    //use $shortname for the filename
		                    //use $filePath for the relative url to the file

		                } 
		              }
		        }

		    }

			$filepaths = mysqli_real_escape_string($con, $filepaths);

			include 'PHPExcel/IOFactory.php';

			$quizName = mysqli_real_escape_string($con, $_POST['qname']);
			$quizDesc = mysqli_real_escape_string($con, $_POST['desc']);
			$quizDays = (int)$_POST['days'];
			$quizDuration = $_POST['time'];
			$quizFormat = "";

			if (is_uploaded_file($_FILES['ident']['tmp_name'])) {


		 	$quizFormat  = "Identification ";

			}


			if (is_uploaded_file($_FILES['multi']['tmp_name'])) {
		 
				 $quizFormat  .= "Multiple Choice ";

			}

			if (is_uploaded_file($_FILES['match']['tmp_name'])) {
		 
				 $quizFormat  .= "Matching Type ";

			}

			if (is_uploaded_file($_FILES['essay']['tmp_name'])) {
		 
				 $quizFormat  .= "Essay ";

			}

			if ($quizFormat != "") {

			

					$startDate = date('Y-m-d H:i:s');

					// $endDate = date('Y-m-d H:i:s', strtotime('+'.$quizDays.' days'));
					
				

					$quizStatus = "Published";


					$s = mysqli_query($con, "SELECT * FROM tblclassperiod WHERE cp_id='".$_POST['periodID']."'");

					$sRow = mysqli_fetch_array($s);

					$customID = uniqid().''.$_SESSION['id'].''.$_POST['periodID'];


					$y = date("Y", strtotime($end));

					$m = date("m", strtotime($end));

					$d = date("d", strtotime($end));
					
					$deadline = date('Y-m-d H:i:s', mktime("23","59","59",$m,$d,$y));

					if ($_POST['type'] == "Quiz") {

						$postMsg = "Created a quiz : ".$_POST['qname'];

					} else {

						$postMsg = "Created an exam : ".$_POST['qname'];
					}

					$postMsg = mysqli_real_escape_string($con, $postMsg);

					// save first to post

					mysqli_query($con, "INSERT INTO tblpost VALUES ('0','".$postMsg."','".$startDate."','".$_POST['periodID']."','Teacher','".$_SESSION['id']."','".$_POST['type']."','".$customID."','".$filepaths."','No','".$sRow['section_id']."')");

					// end

					// get the last saved post

					$res = mysqli_query($con, "SELECT * FROM tblpost WHERE custom_id='".$customID."'");

					$row = mysqli_fetch_array($res);

					// save the test

					mysqli_query($con, "INSERT INTO tbltest VALUES('0','".$row['post_id']."','".$_SESSION['id']."','".$quizName."','".$quizDesc."','".$_POST['type']."','".$quizFormat."','".$startDate."','".$deadline."','".$quizDuration."','".$quizStatus."','".$filepaths."','No')");


					// get the last saved test
					$res1 = mysqli_query($con, "SELECT * FROM tbltest WHERE post_id='".$row['post_id']."'");

					$row1 = mysqli_fetch_array($res1);

						//  Read your Excel workbook



						if (is_uploaded_file($_FILES['ident']['tmp_name'])) {


					 	
								$file_name = $_FILES['ident']['tmp_name'];
								$inputFileName = $file_name;



									try {
										$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
										$objReader = PHPExcel_IOFactory::createReader($inputFileType);
										$objPHPExcel = $objReader->load($inputFileName);
									} catch (Exception $e) {
										die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
										. '": ' . $e->getMessage());
									}


									//  Get worksheet dimensions
									$sheet = $objPHPExcel->getSheet(0);
									$highestRow = $sheet->getHighestRow();
									$highestColumn = $sheet->getHighestColumn();

									$testFormat = $sheet->getCell('B1')->getValue();


									if ($testFormat == "Identification") {

										//  Loop through each row of the worksheet in turn
										for ($r = 5; $r <= $highestRow; $r++) {
											//  Read a row of data into an array
											$rowData = $sheet->rangeToArray('A' . $r . ':' . $highestColumn . $r, 
											NULL, TRUE, FALSE);


												if ($rowData[0][0] != "" && $rowData[0][1] != "" && $rowData[0][5] != "") {

													$question = mysqli_real_escape_string($con, $rowData[0][0]);


													mysqli_query($con, "INSERT INTO tblquestion VALUES('0','".$row1['test_id']."','".$question."','".$rowData[0][1]."','N/A','N/A','N/A','".$rowData[0][5]."','Identification')");

												
												}

										}

									} else {

											mysqli_query($con, "DELETE FROM tblpost WHERE post_id='".$row['post_id']."'");

											mysqli_query($con, "DELETE FROM tbltest WHERE post_id='".$row['post_id']."'");

											mysqli_query($con, "DELETE FROM tblquestion WHERE test_id='".$row1['test_id']."'");



											 header("location: teacher.php?page=classperiod&id=".$_POST['periodID']);

									}


						}


						if (is_uploaded_file($_FILES['multi']['tmp_name'])) {
					 
							 	$file_name = $_FILES['multi']['tmp_name'];
								$inputFileName = $file_name;


									try {
										$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
										$objReader = PHPExcel_IOFactory::createReader($inputFileType);
										$objPHPExcel = $objReader->load($inputFileName);
									} catch (Exception $e) {
										die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
										. '": ' . $e->getMessage());
									}


									//  Get worksheet dimensions
									$sheet = $objPHPExcel->getSheet(0);
									$highestRow = $sheet->getHighestRow();
									$highestColumn = $sheet->getHighestColumn();

									$testFormat = $sheet->getCell('B1')->getValue();

									//  Loop through each row of the worksheet in turn
									for ($r = 5; $r <= $highestRow; $r++) {
										//  Read a row of data into an array
										$rowData = $sheet->rangeToArray('A' . $r . ':' . $highestColumn . $r, 
										NULL, TRUE, FALSE);


										
										
										if ($testFormat == "Multiple Choice") {

											if ($rowData[0][0] != "" && $rowData[0][1] != "" && $rowData[0][2] != "" && $rowData[0][3] != "" && $rowData[0][4] != "" && $rowData[0][5] != "") {

												$question = mysqli_real_escape_string($con, $rowData[0][0]);

												mysqli_query($con, "INSERT INTO tblquestion VALUES('0','".$row1['test_id']."','".$question."','".$rowData[0][1]."','".$rowData[0][2]."','".$rowData[0][3]."','".$rowData[0][4]."','".$rowData[0][5]."','Multiple')");

											
											}

										} else {

											mysqli_query($con, "DELETE FROM tblpost WHERE post_id='".$row['post_id']."'");

											mysqli_query($con, "DELETE FROM tbltest WHERE post_id='".$row['post_id']."'");

											mysqli_query($con, "DELETE FROM tblquestion WHERE test_id='".$row1['test_id']."'");



											 header("location: teacher.php?page=classperiod&id=".$_POST['periodID']);

										}

									}

						}

						if (is_uploaded_file($_FILES['match']['tmp_name'])) {
					 
							 	$file_name = $_FILES['match']['tmp_name'];
								$inputFileName = $file_name;


									try {
										$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
										$objReader = PHPExcel_IOFactory::createReader($inputFileType);
										$objPHPExcel = $objReader->load($inputFileName);
									} catch (Exception $e) {
										die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
										. '": ' . $e->getMessage());
									}


									//  Get worksheet dimensions
									$sheet = $objPHPExcel->getSheet(0);
									$highestRow = $sheet->getHighestRow();
									$highestColumn = $sheet->getHighestColumn();

									$testFormat = $sheet->getCell('B1')->getValue();


									//  Loop through each row of the worksheet in turn
									for ($r = 5; $r <= $highestRow; $r++) {
										//  Read a row of data into an array
										$rowData = $sheet->rangeToArray('A' . $r . ':' . $highestColumn . $r, 
										NULL, TRUE, FALSE);


										
										
										if ($testFormat == "Matching Type") {

											if ($rowData[0][0] != "" && $rowData[0][1] != "" && $rowData[0][5] != "") {

												$question = mysqli_real_escape_string($con, $rowData[0][0]);


												mysqli_query($con, "INSERT INTO tblquestion VALUES('0','".$row1['test_id']."','".$question."','".$rowData[0][1]."','N/A','N/A','N/A','".$rowData[0][5]."','Matching')");

											
											}

										} else {

											mysqli_query($con, "DELETE FROM tblpost WHERE post_id='".$row['post_id']."'");

											mysqli_query($con, "DELETE FROM tbltest WHERE post_id='".$row['post_id']."'");

											mysqli_query($con, "DELETE FROM tblquestion WHERE test_id='".$row1['test_id']."'");



											 header("location: teacher.php?page=classperiod&id=".$_POST['periodID']);

										}

									}

						}

						if (is_uploaded_file($_FILES['essay']['tmp_name'])) {
					 
							 	$file_name = $_FILES['essay']['tmp_name'];
								$inputFileName = $file_name;


									try {
										$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
										$objReader = PHPExcel_IOFactory::createReader($inputFileType);
										$objPHPExcel = $objReader->load($inputFileName);
									} catch (Exception $e) {
										die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
										. '": ' . $e->getMessage());
									}


									//  Get worksheet dimensions
									$sheet = $objPHPExcel->getSheet(0);
									$highestRow = $sheet->getHighestRow();
									$highestColumn = $sheet->getHighestColumn();

									$testFormat = $sheet->getCell('B1')->getValue();


									//  Loop through each row of the worksheet in turn
									for ($r = 5; $r <= $highestRow; $r++) {
										//  Read a row of data into an array
										$rowData = $sheet->rangeToArray('A' . $r . ':' . $highestColumn . $r, 
										NULL, TRUE, FALSE);


										
										
										if ($testFormat == "Essay") {

											if ($rowData[0][0] != "") {

												$question = mysqli_real_escape_string($con, $rowData[0][0]);

												$pts = $rowData[0][1];

												if ($pts == "0" || $pts == "") {

													$pts = 10;
												}


												mysqli_query($con, "INSERT INTO tblquestion VALUES('0','".$row1['test_id']."','".$question."','N/A','N/A','N/A','N/A','".$pts."','Essay')");

											
											}

										} else {

											mysqli_query($con, "DELETE FROM tblpost WHERE post_id='".$row['post_id']."'");

											mysqli_query($con, "DELETE FROM tbltest WHERE post_id='".$row['post_id']."'");

											mysqli_query($con, "DELETE FROM tblquestion WHERE test_id='".$row1['test_id']."'");



											 header("location: teacher.php?page=classperiod&id=".$_POST['periodID']);

										}

										

									}

						}


				

					// update post

					$final = mysqli_query($con, "UPDATE tblpost SET custom_id='".$row1['test_id']."' WHERE post_id='".$row['post_id']."' AND post_type='".$_POST['type']."'");

					if ($final) {

						

						$sec = mysqli_query($con, "SELECT * FROM tblclassperiod,tblsection,tblperiod WHERE tblclassperiod.cp_id='".$_POST['periodID']."' AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id");

						$secRow = mysqli_fetch_array($sec);

						$title = $secRow['section_name']. ' - '.$secRow['section_desc'];

						$title = mysqli_real_escape_string($con, $title);

						if ($_POST['type'] == "Quiz") {

							$message = "Instructor ".$_SESSION['fname']." has created a ".strtolower($_POST['type'])." in ".$secRow['period_name']." timeline, named ".$row1['test_name'];

						} else {

							$message = "Instructor ".$_SESSION['fname']." has created an ".strtolower($_POST['type'])." in ".$secRow['period_name']." timeline, named ".$row1['test_name'];


						}

						

						$message = mysqli_real_escape_string($con, $message);

						$res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$secRow['section_id']."'");

						while($row2 = mysqli_fetch_array($res2)) {


							mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row2['student_id']."','".$_POST['type']."','".$row['post_id']."','".$_POST['periodID']."','".$message."','".$title."','".$startDate."','Unseen','No')");

						}


					} else {

						mysqli_query($con, "DELETE FROM tblpost WHERE post_id='".$row['post_id']."'");

						mysqli_query($con, "DELETE FROM tbltest WHERE post_id='".$row['post_id']."'");

						mysqli_query($con, "DELETE FROM tblquestion WHERE test_id='".$row['test_id']."'");

					}

			}

	}


	  header("location: teacher.php?page=classperiod&id=".$_POST['periodID']);


}


// end of save test

// start of new test

if ($_GET['page'] == "newtest") {

	$test = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$_GET['id']."'");

	$testRow = mysqli_fetch_array($test);



	$res = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$_GET['id']."' ORDER BY RAND()");

	while($row = mysqli_fetch_array($res)) {

		mysqli_query($con, "INSERT INTO tblanswer VALUES('0','".$_SESSION['id']."','".$_GET['id']."','".$row['question_id']."','','N/A','0')");


	}


	$date1	=	date("Y-m-d H:i:s");

	$date2 	= 	date("Y-m-d H:i:s", strtotime("+".(int)$testRow['test_time']." minutes"));


	mysqli_query($con, "INSERT INTO tbltaken VALUES('0','".$_GET['id']."','".$_SESSION['id']."','".$date1."','".$date2."','".$testRow['test_time']."','Ongoing','N/A','0')");




	header("location: student.php?page=taketest&id=".$_GET['id']."#wizard");




}

// end of new test


// start of save ans
if ($_GET['page'] == "saveans") {



	$res = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.answer_id='".$_POST['id']."' AND tblquestion.question_id=tblanswer.question_id");

	$row = mysqli_fetch_array($res);

	if ($row['correct_ans'] == $_POST['ans']) {

		$status = "Correct";

	} else {

		$status = "Wrong";
	}


	$ans = mysqli_real_escape_string($con, $_POST['ans']);

	mysqli_query($con, "UPDATE tblanswer SET student_answered='".$ans."',answered_status='".$status."',answered_pt='".$row['points']."' WHERE answer_id='".$_POST['id']."'");


}

// end of save ans

// start of save ans
if ($_GET['page'] == "saveident") {



	$res = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.answer_id='".$_POST['id']."' AND tblquestion.question_id=tblanswer.question_id");

	$row = mysqli_fetch_array($res);

	$myAnswer = mysqli_real_escape_string($con, $_POST['ans']);


	$cor = mysqli_query($con, "SELECT * FROM tblquestion WHERE UPPER(correct_ans) LIKE'%".strtoupper($myAnswer)."%' AND question_id='".$row['question_id']."'");

	$c = mysqli_num_rows($cor);


	if ($c != 0) {

		$status = "Correct";

		$pt = $row['points'];

	} else {

		$status = "Wrong";

		$pt = 0;

	}


	$ans = mysqli_real_escape_string($con, $_POST['ans']);

	mysqli_query($con, "UPDATE tblanswer SET student_answered='".$ans."',answered_status='".$status."',answered_pt='".$pt."' WHERE answer_id='".$_POST['id']."'");


}

// end of save ans

// start of save essay
if ($_GET['page'] == "saveessay") {

	if ($_SESSION['isLogin'] == "student") {

	$ans = mysqli_real_escape_string($con, $_POST['ans']);

	mysqli_query($con, "UPDATE tblanswer SET student_answered='".$ans."',answered_status='N/A' WHERE answer_id='".$_POST['id']."'");

	} else {

	$res = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.answer_id='".$_POST['id']."' AND tblquestion.question_id=tblanswer.question_id");

	$row = mysqli_fetch_array($res);

	$pts = $_POST['points'];

	$passingPts = $row['points'] / 2;

	if ($pts >= $passingPts) {



		$status = "Correct";

	} else {




		$status = "Wrong";
	}



		mysqli_query($con, "UPDATE tblanswer SET answered_status='".$status."',answered_pt='".$pts."' WHERE answer_id='".$_POST['id']."'");


	}


}

// end of save essay

// start of essay grade

if ($_GET['page'] == "essaygrade") {




	$res = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$_GET['student']."' AND tblquestion.question_id=tblanswer.question_id");

	$pts = 0;

	while($row = mysqli_fetch_array($res)) {

		$pts += $row['answered_pt'];

	}

	mysqli_query($con, "UPDATE tbltaken SET result_grade='".$pts."' WHERE test_id='".$_GET['id']."' AND student_id='".$_GET['student']."'");


	header("location: teacher.php?page=viewtest&id=".$_GET['id']);


}


// end of essay grade

// start of finish test

if ($_GET['page'] == "finishtest") {

	$res = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$_SESSION['id']."' AND tblanswer.answered_status='Correct' AND tblquestion.question_id=tblanswer.question_id");
	$pts = 0;

	while($row = mysqli_fetch_array($res)) {

		$pts += $row['points'];
	}


	mysqli_query($con, "UPDATE tbltaken SET taken_status='Finish',result_grade='".$pts."' WHERE test_id='".$_GET['id']."' AND student_id='".$_SESSION['id']."'");

	header("location: student.php?page=viewtest&id=".$_GET['id']);

}


// end of finish test

// start of activity grade

if ($_GET['page'] == "activitygrade") {

	include 'PHPExcel/IOFactory.php';

	//  Read your Excel workbook

	$file_name = $_FILES['file']['tmp_name'];
	$inputFileName = $file_name;


		try {
			$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
		} catch (Exception $e) {
			die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
			. '": ' . $e->getMessage());
		}


		//  Get worksheet dimensions
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		$checkData = $sheet->rangeToArray('A1:B1',NULL, TRUE, FALSE);

		if ($checkData[0][1] == $_GET['id']) {

			//  Loop through each row of the worksheet in turn
			for ($r = 7; $r <= $highestRow; $r++) {
				//  Read a row of data into an array
				$rowData = $sheet->rangeToArray('A' . $r . ':' . $highestColumn . $r, 
				NULL, TRUE, FALSE);



						$remarks = mysqli_real_escape_string($con, $rowData[0][4]);

						$activityScore = $rowData[0][3];

						if (is_numeric($activityScore)) {

							if ($activityScore < 0) {

								$activityScore = 0;

							} else if ($activityScore > 100) {

								$activityScore = 100;
							}

						} else {

							$activityScore = 0;
						}

						mysqli_query($con, "UPDATE tblsubmit SET submit_grade='".$activityScore."',submit_remarks='".$remarks."' WHERE activity_id='".$_GET['id']."' AND student_id='".$rowData[0][0]."'");
					

			}

		}

		header("location: teacher.php?page=viewgrade&id=".$_GET['id']);


}


// end of activity grade

function checkEmail($email, $domainCheck = false) {



	if (preg_match('/^[a-zA-Z0-9\._-]+\@(\[?)[a-zA-Z0-9\-\.]+'.

				   '\.([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/', $email)) {

		if ($domainCheck && function_exists('checkdnsrr')) {

			list (, $domain)  = explode('@', $email);

			if (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A')) {

				return true;

			}

			return false;

		}

		return true;

	}

	return false;



}


if ($_GET['page'] == "savegrade") {


	if ($_POST['cpid'] == 0) {


		// save base grade

		mysqli_query($con, "UPDATE tblteacher SET teacher_basegrade='".$_POST['bGrade']."' WHERE teacher_id='".$_SESSION['id']."'");

		$_SESSION['basegrade'] = $_POST['bGrade'];

		// save period grades

		$list = mysqli_query($con, "SELECT * FROM tblclassperiod WHERE section_id='".$_GET['id']."' ORDER BY cp_id ASC");

		while($listRow = mysqli_fetch_array($list)) {

			mysqli_query($con, "UPDATE tblclassperiod SET period_grade='".$_POST['pGrade'.$listRow['cp_id']]."' WHERE cp_id='".$listRow['cp_id']."'");

		}



		header("location: teacher.php?page=grades&id=".$_GET['id']."&filter=overall");

	} else {

		mysqli_query($con, "UPDATE tblclassperiod SET grade_activity='".$_POST['aGrade']."',grade_quiz='".$_POST['qGrade']."',grade_exam='".$_POST['eGrade']."' WHERE cp_id='".$_POST['cpid']."'");


		header("location: teacher.php?page=grades&id=".$_GET['id']."&filter=".$_POST['cpid']);
	}




}


if ($_GET['page'] == "changetimeline") {


		$cp  = "";


	if ($_POST['cpid'] == 0) {

		$cp = mysqli_query($con, "SELECT * FROM tblclassperiod,tblpost,tblperiod WHERE tblclassperiod.section_id='".$_POST['id']."' AND tblpost.cp_id=tblclassperiod.cp_id AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblpost.post_datetime DESC");

	} else {


		$cp = mysqli_query($con, "SELECT * FROM tblclassperiod,tblpost,tblperiod WHERE tblclassperiod.cp_id='".$_POST['cpid']."' AND tblpost.cp_id=tblclassperiod.cp_id AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblpost.post_datetime DESC");

	}

		$cpCount = mysqli_num_rows($cp);



                                if ($cpCount == 0) {

                                  echo '<h2>No Timeline To Be Shown</h2>';

                                } else {

                                 echo '<ul class="list-unstyled timeline">';

                                  while($cpRow = mysqli_fetch_array($cp)) {

                                  	$editControls = "";

											$section = mysqli_query($con, "SELECT * FROM tblsection WHERE section_id='".$cpRow['section_id']."'");

											$sectionRow = mysqli_fetch_array($section);

                                           $r = mysqli_query($con, "SELECT * FROM tblreply WHERE post_id='".$cpRow['post_id']."'");



                                        $rCount = mysqli_num_rows($r);




                                        if ($cpRow['user_type'] == "Teacher") {


                                        	$user = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$cpRow['user_id']."'");

                                        	$userRow = mysqli_fetch_array($user);


                                        	if ($cpRow['user_id'] == $_SESSION['id']) {

                                        		 
                                        	if ($_SESSION['isLogin'] == "teacher") {

                                        		$editControls = ' <ul class="nav navbar-right panel_toolbox">
                                                                              <li><a href="#" data-toggle="modal" onclick="editPost('.$cpRow['post_id'].');" data-target="#editFields"><i class="fa fa-edit"></i></a>
                                                                                  </li>
                                                                                <li><a onclick="removePost('.$cpRow['post_id'].');"><i class="fa fa-remove" title="Remove Post"></i></a>
                                                                                  </li>
                                                                            </ul>';
                                        	}

                                        		 $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> Posted by <a href="?page=myprofile">'.$userRow['teacher_fname'].' '.$userRow['teacher_lname'].'</a> <i title="Teacher" class="fa fa-check-circle"></i>';
                                        	} else {

                                        		    $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> Posted by <a href="?page=viewteacher&id='.$cpRow['user_id'].'">'.$userRow['teacher_fname'].' '.$userRow['teacher_lname'].'</a> <i title="Teacher" class="fa fa-check-circle"></i>';
                                        	}


                                      



                                        } else {



                                         
                                          $s = mysqli_query($con, "SELECT * FROM tblstudent,tblclass WHERE tblstudent.student_id='".$cpRow['user_id']."' AND tblclass.student_id=tblstudent.student_id AND tblclass.section_id='".$_POST['id']."'");



                                          $sRow = mysqli_fetch_array($s);

                                          if ($sRow['class_status'] == "Class President") {


                                          		if ($sRow['student_id'] == $_SESSION['id']) {

                                          			 $editControls = ' <ul class="nav navbar-right panel_toolbox">
                                                                              <li><a href="#" data-toggle="modal" onclick="editPost('.$cpRow['post_id'].');" data-target="#editFields"><i class="fa fa-edit"></i></a> </li>
                                                                                <li><a onclick="removePost('.$cpRow['post_id'].');"><i class="fa fa-remove" title="Remove Post"></i></a>
                                                                                  </li>
                                                                            </ul>';


                                               $headerPost = '<b>['.strtoupper($cpRow['period_name']).' '.$sectionRow['section_name'].'-'.$sectionRow['section_desc'].']</b> Posted by <a href="?page=myprofile">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="Class President" class="fa fa-check-circle-o"></i>';

                                          		} else {


                                               $headerPost = '<b>['.strtoupper($cpRow['period_name']).' '.$sectionRow['section_name'].'-'.$sectionRow['section_desc'].']</b> <br />Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="Class President" class="fa fa-check-circle-o"></i>';
                                          		}



                                          } else {

                                          		if ($cpRow['user_id'] == $_SESSION['id']) {


                                               $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> Posted by <a href="?page=myprofile">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="X Class President" class="fa fa-remove"></i>';

                                          		} else {


                                               $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="X Class President" class="fa fa-remove"></i>';
                                          		}


                                          }


                                        }

                                      $isDisplay = true;

                                      if ($cpRow['post_type'] == "Quiz" || $cpRow['post_type'] == "Exam") {

                                        $test = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$cpRow['custom_id']."'");

                                        $testRow = mysqli_fetch_array($test);

                                        if ($cpRow['test_status'] == "Unpublished" && $_POST['type'] == "student") {

                                        	$isDisplay = false;
                                        }

                                      


                                      } else if ($cpRow['post_type'] == "Activity") {

                                      	$a = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$cpRow['custom_id']."'");

                                      	$aRow = mysqli_fetch_array($a);

                                      }

                                      // tag coloring

                                      if ($cpRow['post_type'] == "Post") {

                                        $tag = "tag";
                                        $tags = "tags";

                                            $postContent = '<p>'.$cpRow['post_msg'].'</p>
                                                       '.$headerPost;


                                      } else if ($cpRow['post_type'] == "Quiz") {

                                         $tag = "quiztag";
                                        $tags = "quiztags";


                                        $postContent = '<h3 class="title">'.$testRow['test_name'].'</h3>
                                                       '.$headerPost;


                                      } else if ($cpRow['post_type'] == "Exam") {

                                         $tag = "examtag";
                                        $tags = "examtags";


                                        $postContent = '<h3 class="title">'.$testRow['test_name'].'</h3>
                                                       '.$headerPost;



                                      } else if ($cpRow['post_type'] == "Activity") {


                                         $tag = "activitytag";
                                        $tags = "activitytags";


                                        $postContent = '<h3 class="title">'.$aRow['activity_name'].'</h3>
                                                       '.$headerPost;
                                      }

                                      // end of tag coloring

                                      if ($isDisplay == true) {

                                            echo '<li>

                                              <div class="block">

                                                <div class="'.$tags.'">

                                                  <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'" class="'.$tag.'">

                                                    <span>'.$cpRow['post_type'].'</span>

                                                  </a>

                                                </div>

                                                <div class="block_content">'.$editControls.'


                                                    '.$postContent.'

                                                  <div class="byline">

                                                    <span title="Posted at '.date('F d, Y g:i A', strtotime($cpRow['post_datetime'])).'">'.$sectionRow['section_name'].'- '.$sectionRow['section_desc'].' '.timeAgo($cpRow['post_datetime']).'</span>

                                                  </div>';


                                                  if ($cpRow['post_files'] == "N/A") {


                                                    if ($cpRow['post_type'] == "Activity") {

                                                        $actRes = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$cpRow['custom_id']."'");

                                                        $aCount = mysqli_num_rows($actRes);

                                                        if ($_SESSION['isLogin'] == "teacher") {

                                                        	 echo ' <p><a href="?page=viewgrade&id='.$cpRow['custom_id'].'">View Submissions('.$aCount.')</a> | <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies('.$rCount.')</a></p>';


                                                        } else {

                                                        	 echo ' <p>Submitted('.$aCount.') | <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies('.$rCount.')</a></p>';
                                                        }

                                                      

                                                    } else {



                                                      if ($cpRow['post_type'] == "Post") {



                                                        echo ' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies ('.$rCount.')</a></p>';

                                                          } else {

                                                              if ($testRow['test_status'] == "Unpublished") {

                                                                echo ' <p>Post Status : <b>Unpublished</b></p>';


                                                              } else {

                                                                echo ' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies ('.$rCount.')</a> | <a href="?page=viewtest&id='.$cpRow['custom_id'].'">View Test</a></p>';

                                                              }


                                                          }


                                                    }


                                                  } else {

                                                     $fc = split(",", $cpRow['post_files']);

                                                     echo ' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Attachments('.count($fc).') & Replies('.$rCount.')</a></p>';

                                                  }

                                                 

                                                 

                                                echo '</div>

                                              </div>

                                           </li>';

                                           

                                          }



                                      














                            } // end of while


                              echo '</ul>'; 


                       }
                              



             


}

if ($_GET['page'] == "changetype") {


	$cp  = "";

	$periodName = "";


	if ($_POST['type'] == "all") {

		 $cp = mysqli_query($con, "SELECT * FROM tblclass,tblpost,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblpost.section_id=tblclass.section_id AND tblsection.section_id=tblpost.section_id AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");

	} else if ($_POST['type'] == "post") {

		 $cp = mysqli_query($con, "SELECT * FROM tblclass,tblpost,tblsection WHERE tblpost.post_type='Post' AND tblclass.student_id='".$_SESSION['id']."' AND tblpost.section_id=tblclass.section_id AND tblsection.section_id=tblpost.section_id AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");


		 // $cp = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection,tblperiod,tblclass WHERE tblpost.post_type='Post' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id AND tblclass.section_id=tblsection.section_id AND tblclass.student_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY tblpost.post_datetime DESC");

	} else if ($_POST['type'] == "activity") {

		$cp = mysqli_query($con, "SELECT * FROM tblclass,tblpost,tblsection WHERE tblpost.post_type='Activity' AND tblclass.student_id='".$_SESSION['id']."' AND tblpost.section_id=tblclass.section_id AND tblsection.section_id=tblpost.section_id AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");


		 // $cp = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection,tblperiod,tblclass WHERE tblpost.post_type='Activity' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id AND tblclass.section_id=tblsection.section_id AND tblclass.student_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY tblpost.post_datetime DESC");

	} else {

			$cp = mysqli_query($con, "SELECT * FROM tblclass,tblpost,tblsection WHERE tblpost.post_type != 'Activity' AND tblpost.post_type != 'Post' AND tblclass.student_id='".$_SESSION['id']."' AND tblpost.section_id=tblclass.section_id AND tblsection.section_id=tblpost.section_id AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");

		// $cp = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection,tblperiod,tblclass WHERE tblpost.post_type != 'Activity' AND tblpost.post_type != 'Post' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id AND tblclass.section_id=tblsection.section_id AND tblclass.student_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY tblpost.post_datetime DESC");

	}

		$cpCount = mysqli_num_rows($cp);



                                if ($cpCount == 0) {

                                  echo '<h2>No Timeline To Be Shown</h2>';

                                } else {

                                 echo '<ul class="list-unstyled timeline">';

                                  while($cpRow = mysqli_fetch_array($cp)) {



                                                $periodName = "ALL PERIODS";

                                           $r = mysqli_query($con, "SELECT * FROM tblreply WHERE post_id='".$cpRow['post_id']."'");

                                               $editControls = "";
                                        $rCount = mysqli_num_rows($r);



                                             $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.cp_id='".$cpRow['cp_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                                              $pCount = mysqli_num_rows($p);

                                              if ($pCount != 0) {


                                                $pRow = mysqli_fetch_array($p);

                                                $periodName = strtoupper($pRow['period_name']);

                                              }


                                       



                                        if ($cpRow['user_type'] == "Teacher") {


                                        	$user = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$cpRow['user_id']."'");

                                        	$userRow = mysqli_fetch_array($user);

                                        	if ($userRow['user_id'] == $_SESSION['id'] && $_POST['usertype'] == "teacher") {

                                        		    $editControls = ' <ul class="nav navbar-right panel_toolbox">
                                                                              <li><a href="#" data-toggle="modal" onclick="editPost('.$cpRow['post_id'].');" data-target="#editFields"><i class="fa fa-edit"></i></a></li>
                                                                                <li><a onclick="removePost('.$cpRow['post_id'].');"><i class="fa fa-remove" title="Remove Post"></i></a>
                                                                                  </li>
                                                                            </ul>';

                                        		 $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                        		 $postedPost = 'Posted by <a href="?page=myprofile">'.$userRow['teacher_fname'].' '.$userRow['teacher_lname'].' <i title="Teacher" class="fa fa-check-circle"></i></a>';

                                        	} else {

                                        		    $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                        		  $postedPost = 'Posted by <a href="?page=viewteacher&id='.$cpRow['user_id'].'">'.$userRow['teacher_fname'].' '.$userRow['teacher_lname'].' <i title="Teacher" class="fa fa-check-circle"></i></a>';
                                        	}


                                      



                                        } else {



                                         
                                          $s = mysqli_query($con, "SELECT * FROM tblstudent,tblclass WHERE tblstudent.student_id='".$cpRow['user_id']."' AND tblclass.student_id=tblstudent.student_id AND tblclass.section_id='".$cpRow['section_id']."'");



                                          $sRow = mysqli_fetch_array($s);

                                          if ($sRow['class_status'] == "Class President") {


                                          		if ($cpRow['user_id'] == $_SESSION['id']) {

                                          			    $editControls = ' <ul class="nav navbar-right panel_toolbox">
                                                                              <li><a href="#" data-toggle="modal" onclick="editPost('.$cpRow['post_id'].');" data-target="#editFields"><i class="fa fa-edit"></i></a></li>
                                                                                <li><a onclick="removePost('.$cpRow['post_id'].');"><i class="fa fa-remove" title="Remove Post"></i></a>
                                                                                  </li>
                                                                            </ul>';

                                               $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                               $postedPost = 'Posted by <a href="?page=myprofile">'.$sRow['student_fname'].' '.$sRow['student_lname'].' <i title="Class President" class="fa fa-check-circle-o"></i></a>';

                                          		} else {


                                               $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b>';


                                               	$postedPost = 'Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].' <i title="Class President" class="fa fa-check-circle-o"></i></a>';

                                          		}



                                          } else {

                                          		if ($cpRow['user_id'] == $_SESSION['id']) {


                                               $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                               $postedPost = 'Posted by <a href="?page=myprofile">'.$sRow['student_fname'].' '.$sRow['student_lname'].'<i title="X Class President" class="fa fa-remove"></i></a> ';

                                          		} else {


                                               $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b>';

                                               $postedPost = 'Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].' <i title="X Class President" class="fa fa-remove"></i></a>';

                                          		}


                                          }


                                        }

                                      $isDisplay = true;

                                      if ($cpRow['post_type'] == "Quiz" || $cpRow['post_type'] == "Exam") {

                                        $test = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$cpRow['custom_id']."'");

                                        $testRow = mysqli_fetch_array($test);

                                        if ($cpRow['test_status'] == "Unpublished" && $_POST['type'] == "student") {

                                        	$isDisplay = false;
                                        }

                                      


                                      }

                                      // tag coloring

                                      if ($cpRow['post_type'] == "Post") {

                                        $tag = "tag";
                                        $tags = "tags";


                                      } else if ($cpRow['post_type'] == "Quiz") {

                                         $tag = "quiztag";
                                        $tags = "quiztags";

                                      } else if ($cpRow['post_type'] == "Exam") {

                                         $tag = "examtag";
                                        $tags = "examtags";


                                      } else if ($cpRow['post_type'] == "Activity") {


                                         $tag = "activitytag";
                                        $tags = "activitytags";
                                      }

                                      // end of tag coloring

                                      if ($isDisplay == true) {

                                            echo '<li>

                                              <div class="block">

                                                <div class="'.$tags.'">

                                                  <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'" class="'.$tag.'">

                                                    <span>'.$cpRow['post_type'].'</span>

                                                  </a>

                                                </div>

                                                <div class="block_content">

                                                  <h2 class="title">

                                                                  '.$headerPost.'

                                                              </h2>'.$editControls.'

                                                  <div class="byline">

                                                    <span title="Posted at '.date('F d, Y g:i A', strtotime($cpRow['post_datetime'])).'">'.$postedPost.' '.timeAgo($cpRow['post_datetime']).'</span>

                                                  </div>

                                                  <p>'.$cpRow['post_msg'].'</p>';


                                                  if ($cpRow['post_files'] == "N/A") {


                                                    if ($cpRow['post_type'] == "Activity") {

                                                        $actRes = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$cpRow['custom_id']."'");

                                                        $aCount = mysqli_num_rows($actRes);

                                                        if ($_SESSION['isLogin'] == "teacher") {



                                                       echo ' <p><a href="?page=viewgrade&id='.$cpRow['custom_id'].'">View Submissions('.$aCount.')</a> | <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies('.$rCount.')</a></p>';

                                                        } else {

                                                       echo ' <p>Submitted('.$aCount.') | <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies('.$rCount.')</a></p>';

                                                        }



                                                    } else {



                                                      if ($cpRow['post_type'] == "Post") {



                                                        echo ' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies ('.$rCount.')</a></p>';

                                                        } else {

                                                              if ($testRow['test_status'] == "Unpublished") {

                                                                echo ' <p>Post Status : <b>Unpublished</b></p>';


                                                              } else {

                                                                echo ' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies ('.$rCount.')</a> | <a href="?page=viewtest&id='.$cpRow['custom_id'].'">View Test</a></p>';

                                                              }


                                                          }


                                                    }


                                                  } else {

                                                     $fc = split(",", $cpRow['post_files']);

                                                     echo ' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Attachments('.count($fc).') & Replies('.$rCount.')</a></p>';

                                                  }

                                                 

                                                 

                                                echo '</div>

                                              </div>

                                           </li>';

                                           

                                          }




                            } // end of while


                              echo '</ul>'; 


                       }
                              



             


}

if ($_GET['page'] == "deactclass") {

	//mysqli_query($con, "UPDATE tblsection SET section_status='Deactivate' WHERE section_id='".$_GET['id']."'");

	mysqli_query($con, "DELETE FROM tblsection WHERE section_id='".$_GET['id']."'");

	mysqli_query($con, "DELETE FROM tblclassperiod WHERE section_id='".$_GET['id']."'");

	mysqli_query($con, "DELETE FROM tblclass WHERE section_id='".$_GET['id']."'");

	header("location: teacher.php");

}

if ($_GET['page'] == "kickstudent") {

	$res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.class_id='".$_GET['class']."' AND tblsection.section_id=tblclass.section_id");

	$row = mysqli_fetch_array($res);




	$del = mysqli_query($con, "DELETE FROM tblclass WHERE class_id='".$_GET['class']."'");

	if ($del) {

		$secDesc = $row['section_name'].' - '.$row['section_desc'];

		$secDesc = mysqli_real_escape_string($con, $secDesc);

		$notifMsg = "You have been kicked out from the class";

		mysqli_query($con, "INSERT INTO tblnotifications VALUES('0','Student','".$row['student_id']."','Kick','0','0','".$notifMsg."','".$secDesc."','".date("Y-m-d H:i:s")."','Unseen','No')");

	}

	// header("location: teacher.php?page=students&id=".$_GET['id']);

	header("location: teacher.php?page=classperiod&id=".$_GET['id']);

}

if ($_GET['page'] == "deletepost") {

	$res = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$_GET['post']."'");

	$row = mysqli_fetch_array($res);

	mysqli_query($con, "DELETE FROM tblpost WHERE post_id='".$_GET['post']."'");

	mysqli_query($con, "DELETE FROM tblnotifications WHERE post_type='Post' AND custom_id='".$_GET['post']."'");

	mysqli_query($con, "DELETE FROM tblreply WHERE post_id='".$_GET['post']."'");


	if ($row['post_type'] == "Activity") {

		mysqli_query($con, "DELETE FROM tblactivity WHERE activity_id='".$row['custom_id']."'");

		mysqli_query($con, "DELETE FROM tblsubmit WHERE activity_id='".$row['custom_id']."'");

		rmdir('Activities/Activity'.$row['custom_id']);

		unlink("Activity".$row['custom_id'].".zip");

	} else if ($row['post_type'] == "Quiz" || $row['post_type'] == "Exam") {

		mysqli_query($con, "DELETE FROM tbltest WHERE test_id='".$row['custom_id']."'");

		mysqli_query($con, "DELETE FROM tbltaken WHERE test_id='".$row['custom_id']."'");

		mysqli_query($con, "DELETE FROM tblquestion WHERE test_id='".$row['custom_id']."'");

		mysqli_query($con, "DELETE FROM tblanswer WHERE test_id='".$row['custom_id']."'");

	}


	if ($_GET['ref'] == "index") {




			header("location: ".$_SESSION['isLogin'].".php");

	} else {

			header("location: ".$_SESSION['isLogin'].".php?page=".$_GET['ref']."&id=".$_GET['id']);

	}



}

if ($_GET['page'] == "changetxtfield") {

		  $res = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$_POST['id']."'");

		  $row = mysqli_fetch_array($res);

		  if ($row['post_type'] == "Post") {

		  	$txtField = $row['post_msg'];


		  } else if ($row['post_type'] == "Activity") {

		  		$a = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$row['custom_id']."'");

		  		$aRow = mysqli_fetch_array($a);

		  		$txtField = $aRow['activity_desc'];
		  } else {

		  	$t = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$row['custom_id']."'");

		  	$tRow = mysqli_fetch_array($t);

		  	$txtField = $tRow['test_desc'];
		  }


	      echo $txtField;


}

if ($_GET['page'] == "changetxtname") {



		$res = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$_POST['id']."'");

		$row = mysqli_fetch_array($res);

		if ($row['post_type'] != "Post") {

			if ($row['post_type'] == "Activity") {


				$a = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$row['custom_id']."'");

				$aRow = mysqli_fetch_array($a);

				$txtName = $aRow['activity_name'];


			} else {


				$t = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$row['custom_id']."'");

				$tRow = mysqli_fetch_array($t);

				$txtName = $tRow['test_name'];
			}


			echo '<label class="control-label col-md-3 col-sm-3 col-xs-12">Edit Name</label>

                                  <div class="col-md-9 col-sm-9 col-xs-12">

                                    <input type="text" maxlength="30" required="required" id="editname" value="'.$txtName.'" name="name" class="form-control" placeholder="Enter name here">
 
                                  </div>';
		} else {

			echo "";
		}

	
}

if ($_GET['page'] == "updatefields") {

	$res = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$_POST['id']."'");

	$row = mysqli_fetch_array($res);

	if ($row['post_type'] == "Post") {

		$msg = mysqli_real_escape_string($con, $_POST['desc']);

		mysqli_query($con, "UPDATE tblpost SET post_msg='".$msg."' WHERE post_id='".$_POST['id']."'");


	} else if ($row['post_type'] == "Activity") {

		$msg = mysqli_real_escape_string($con, $_POST['desc']);
		$nme = mysqli_real_escape_string($con, $_POST['name']);

		$newMSg = "Created an activity : ".$nme;

		mysqli_query($con, "UPDATE tblpost SET post_msg='".$newMSg."' WHERE post_id='".$_POST['id']."'");
		mysqli_query($con, "UPDATE tblactivity SET activity_name='".$nme."',activity_desc='".$msg."' WHERE activity_id='".$row['custom_id']."'");

	} else {

		$msg = mysqli_real_escape_string($con, $_POST['desc']);
		$nme = mysqli_real_escape_string($con, $_POST['name']);

		if ($row['post_type'] == "Quiz") {

			$newMSg = "Created a quiz : ".$nme;

		} else {

			$newMSg = "Created an exam : ".$nme;
		}


		mysqli_query($con, "UPDATE tblpost SET post_msg='".$newMSg."' WHERE post_id='".$_POST['id']."'");
		mysqli_query($con, "UPDATE tbltest SET test_name='".$nme."',test_desc='".$msg."' WHERE test_id='".$row['custom_id']."'");

	}

	if (!isset($_GET['id'])) {


	header("location: ".$_SESSION['isLogin'].".php?page=".$_GET['ref']);

	} else {

	

	header("location: ".$_SESSION['isLogin'].".php?page=".$_GET['ref']."&id=".$_GET['id']);	
	}



}

if ($_GET['page'] == "delan") {


	mysqli_query($con, "DELETE FROM tblpost WHERE post_id='".$_GET['id']."'");

	header("location: teacher.php?page=classperiod&id=".$_GET['cpid']);
}

if ($_GET['page'] == "nopeek") {


  mysqli_query($con, "UPDATE tbltest SET test_peek='No' WHERE test_id='".$_GET['id']."'");


  header("location: teacher.php?page=viewtest&id=".$_GET['id']);
  
}

if ($_GET['page'] == "yespeek") {


  mysqli_query($con, "UPDATE tbltest SET test_peek='Yes' WHERE test_id='".$_GET['id']."'");


  header("location: teacher.php?page=viewtest&id=".$_GET['id']);
  

}


if ($_GET['page'] == "actgrade") {


	mysqli_query($con, "UPDATE tblsubmit SET submit_grade='".$_POST['grade']."' WHERE submit_id='".$_POST['id']."'");

	

}

if ($_GET['page'] == "svgrade") {


	mysqli_query($con, "UPDATE tblsubmit SET submit_grade='".$_POST['grd']."' WHERE submit_id='".$_GET['id']."'");

	
	header("location: teacher.php?page=viewactivity&id=".$_GET['id']."&act=".$_GET['act']);

}




function timeAgo($time_ago)

{

    $time_ago = strtotime($time_ago);

    $cur_time   = time();

    $time_elapsed   = $cur_time - $time_ago;

    $seconds    = $time_elapsed ;

    $minutes    = round($time_elapsed / 60 );

    $hours      = round($time_elapsed / 3600);

    $days       = round($time_elapsed / 86400 );

    $weeks      = round($time_elapsed / 604800);

    $months     = round($time_elapsed / 2600640 );

    $years      = round($time_elapsed / 31207680 );

    // Seconds

    if($seconds <= 60){

        return "just now";

    }

    //Minutes

    else if($minutes <=60){

        if($minutes==1){

            return "one minute ago";

        }

        else{

            return "$minutes minutes ago";

        }

    }

    //Hours

    else if($hours <=24){

        if($hours==1){

            return "an hour ago";

        }else{

            return "$hours hrs ago";

        }

    }

    //Days

    else if($days <= 7){

        if($days==1){

            return "yesterday";

        }else{

            return "$days days ago";

        }

    }

    //Weeks

    else if($weeks <= 4.3){

        if($weeks==1){

            return "a week ago";

        }else{

            return "$weeks weeks ago";

        }

    }

    //Months

    else if($months <=12){

        if($months==1){

            return "a month ago";

        }else{

            return "$months months ago";

        }

    }

    //Years

    else{

        if($years==1){

            return "one year ago";

        }else{

            return "$years years ago";

        }

    }

}



class FlxZipArchive extends ZipArchive {
        /** Add a Dir with Files and Subdirs to the archive;;;;; @param string $location Real Location;;;;  @param string $name Name in Archive;;; @author Nicolas Heimann;;;; @access private  **/
    public function addDir($location, $name) {
        $this->addEmptyDir($name);
         $this->addDirDo($location, $name);
     } // EO addDir;

        /**  Add Files & Dirs to archive;;;; @param string $location Real Location;  @param string $name Name in Archive;;;;;; @author Nicolas Heimann * @access private   **/
    private function addDirDo($location, $name) {
        $name .= '/';         $location .= '/';
      // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))    {
            if ($file == '.' || $file == '..') continue;
          // Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } 
}

?>