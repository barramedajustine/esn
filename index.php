<?php 





session_start();



date_default_timezone_set("Asia/Manila");



ob_start();



include "functions/connect.php";





if (isset($_SESSION['isLogin'])) {





   if ($_SESSION['isLogin'] == "teacher") {



      



        header("location: teacher.php");





    } else {



        header("location: student.php");

    }





}



if (!isset($_SESSION['cerror'])) {



                $_SESSION['cerror'] = "";

 }





// for login google



// for google



$base_url= filter_var('http://esn.itcapstone.com/', FILTER_SANITIZE_URL);







// Visit https://code.google.com/apis/console to generate your



// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.



define('CLIENT_ID','1024057501520-radee8mjbv62emt801i9hfmcauv9g7lc.apps.googleusercontent.com');



define('CLIENT_SECRET','SMdlLh8x1wZuAk_XrQa-imHP');



if (isset($_GET['page'])) {



  if ($_GET['page'] == "teacher") {



    define('REDIRECT_URI','http://esn.itcapstone.com/?page=teacher&type=teacher');



  } else {



    define('REDIRECT_URI','http://esn.itcapstone.com/?page=student&type=student');

  }





} else {



  define('REDIRECT_URI','http://esn.itcapstone.com/');

}



//define('REDIRECT_URI','http://localhost/esn/');



define('APPROVAL_PROMPT','auto');



define('ACCESS_TYPE','offline');







// end for google







require_once 'social/lib/Google_Client.php';



require_once 'social/lib/Google_Oauth2Service.php';







$client = new Google_Client();



$client->setApplicationName("Educational Social Networking");



$client->setClientId(CLIENT_ID);



$client->setClientSecret(CLIENT_SECRET);



$client->setRedirectUri(REDIRECT_URI);



$client->setApprovalPrompt(APPROVAL_PROMPT);



$client->setAccessType(ACCESS_TYPE);







$oauth2 = new Google_Oauth2Service($client);







if (isset($_GET['code'])) {



  $client->authenticate($_GET['code']);



  $_SESSION['token'] = $client->getAccessToken();



  echo '<script type="text/javascript">window.close();</script>'; exit;



}







if (isset($_SESSION['token'])) {



 $client->setAccessToken($_SESSION['token']);



}







if (isset($_REQUEST['error'])) {



 echo '<script type="text/javascript">window.close();</script>'; exit;



}







if ($client->getAccessToken()) {



  $user = $oauth2->userinfo->get();









  // These fields are currently filtered through the PHP sanitize filters.



  // See http://www.php.net/manual/en/filter.filters.sanitize.php



  $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);



  $img = filter_var($user['picture'], FILTER_VALIDATE_URL);





  $_SESSION['picpath'] = $img;



  $_SESSION['fname'] = $user['given_name'];



  $_SESSION['lname'] = $user['family_name'];



  $_SESSION['email'] = $email;





  // The access token may have been updated lazily.



  $_SESSION['token'] = $client->getAccessToken();





  $_SESSION['login'] = "Google";





  // check if it newly registered



  if (isset($_GET['page'])) {



    if ($_GET['page'] == "teacher") {





      $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_email='".$email."'");



      $c = mysqli_num_rows($res);



        if ($c == 0) {



          header("location: index.php?page=checkpoint&type=teacher");





        } else {



          $row = mysqli_fetch_array($res);


          $_SESSION['getstarted'] = $row['teacher_guide'];



          $_SESSION['id'] = $row['teacher_id'];



          $_SESSION['isLogin'] = "teacher";

          $_SESSION['basegrade'] = $row['teacher_basegrade'];



          header("location: teacher.php");



        }





    } else if ($_GET['page'] == "student") {



      $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_email='".$email."'");



      $c = mysqli_num_rows($res);



      if ($c == 0) {



        header("location: index.php?page=checkpoint&type=student");





      } else {



        $row = mysqli_fetch_array($res);


        $_SESSION['getstarted'] = $row['student_guide'];


        $_SESSION['id'] = $row['student_id'];



        $_SESSION['isLogin'] = "student";



        header("location: student.php");



      }





    }



  }









} else {



  $authUrl = $client->createAuthUrl();



}





?>



<!DOCTYPE html>

<html lang="en">

  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">




    <title>Educational Social Network</title>


    <link rel="shortcut icon" href="images/favicon.ico">


    <!-- Bootstrap -->

    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">



    <!-- Custom Theme Style -->

    <link href="css/custom.css" rel="stylesheet"> 

  </head>


<body style="background-color: #7ba39b; background-image: url(images/bgnew.png);">


       <!-- start of wrapper -->





        <?php


        		if (!isset($_GET['page'])) {

        			// echo '<div class="row">';
              echo '<div id="wrapper">';

        		} else {

        			
                	echo '<div id="wrapper">';
                
        		}

                include "functions/indexpages.php";



                $page = !empty($_GET['page']) ? $_GET['page'] : "";



                switch($page){



            

                case "teacher"; echo teacher(); break;



                case "student"; echo student(); break;

                case "register"; echo register(); break;


                case "checkpoint"; echo checkpoint(); break;

                case "logout"; echo logout(); break;





                default: echo index(); break;



                                    

                 }



            



            ?>



     



        <!-- 



        <div id="register" class=" form">

          <section class="login_content">

            <form>

              <h1>Create Account</h1>

              <div>

                <input type="text" class="form-control" placeholder="Username" required="" />

              </div>

              <div>

                <input type="email" class="form-control" placeholder="Email" required="" />

              </div>

              <div>

                <input type="password" class="form-control" placeholder="Password" required="" />

              </div>

              <div>

                <a class="btn btn-default submit" href="index.html">Submit</a>

              </div>

              <div class="clearfix"></div>

              <div class="separator">



                <p class="change_link">Already a member ?

                  <a href="#tologin" class="to_register"> Log in </a>

                </p>

                <div class="clearfix"></div>

                <br />

                <div>

                  <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Gentelella Alela!</h1>



                  <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>

                </div>

              </div>

            </form>

          </section>

        </div>



        -->



      </div> <!-- end of wrapper -->



      <!-- jQuery -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap -->

    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>



    <script type="text/javascript" src="social/js/oauthpopup.js"></script>

     <!-- For Facebook Login -->

   <script type="text/javascript"> //login for facebook
      window.fbAsyncInit = function() {
        FB.init({
        appId      : '1203488246433380', // replace your app id here
        channelUrl : 'http://esn.itcapstone.com/',
        status     : true, 
        cookie     : true, 
        xfbml      : true  
        });
      };
      (function(d){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
      }(document));

      function FBLogin(){
        FB.login(function(response){
          if(response.authResponse){
            window.location.href = "scripts.php?page=fblogin&type=<?php echo $_GET['page']; ?>";
          }
        }, {scope: 'email, read_stream, publish_stream, user_birthday, user_location, user_work_history, user_hometown, user_photos'});
      }
    // end login facebook </script> 



    <script type="text/javascript">





    $(document).ready(function(){ // login for google



  

       $('a.login').oauthpopup({



                path: '<?php if(isset($authUrl)){echo $authUrl;}else{ echo '';}?>',



          width:650,



          height:350,



            });





    }); //end login google



    </script>


    <?php 

    if ($_GET['page'] == "logout") {



        echo '
        <script type="text/javascript">

              setInterval(function() {

                window.location = "index.php";
       
               }, 3000); //5 seconds

        </script>';


    }


    ?>
    

  </body>

</html>