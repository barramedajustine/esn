<?php 
session_start();


date_default_timezone_set("Asia/Manila");

include "functions/connect.php";





?>




<!DOCTYPE html>

<html lang="en">

  <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">


 
    <?php 

      $res = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$_GET['id']."'");

      $postRow = mysqli_fetch_array($res);

      $res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.cp_id='".$postRow['cp_id']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");

      $descRow = mysqli_fetch_array($res);

      if ($postRow['user_type'] == "Teacher") {


        $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$postRow['user_id']."'");

        $userRow = mysqli_fetch_array($res);

        $name = $userRow['teacher_fname']. ' '.$userRow['teacher_lname'];

      } else {


        $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id='".$postRow['user_id']."'");

        $userRow = mysqli_fetch_array($res);

        $name = $userRow['student_fname'].' '.$userRow['student_lname'];


      }

      $url = "http://esn.itcapstone.com/sharer.php?id=".$_GET['id']."&cpid=".$postRow['cp_id'];


    ?>
    
    <meta name="author"                    content="<?php echo $name; ?>">
    <meta property="og:url"                content="<?php echo $url; ?>" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="<?php echo $descRow['section_name'].' '.$descRow['section_desc'].' - '.$descRow['period_name']; ?>" />
    <meta property="og:description"        content="<?php echo $postRow['post_msg']; ?>" />
    <meta property="og:image"              content="http://esn.itcapstone.com/images/fbthumbnail.jpg" />

   <title>Educational Social Network</title>

  <link rel="shortcut icon" href="images/favicon.ico">


    <!-- Bootstrap -->

    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">



    <!-- Custom Theme Style -->

    <link href="css/custom.css" rel="stylesheet">

    <?php 


    if (isset($_SESSION['isLogin'])) {



        if ($_SESSION['isLogin'] == "student") {



            $checkpointURL = "window.location='student.php?page=viewpost&id=".$_GET['id']."&cpid=".$postRow['cp_id']."';";

        } else {


            $checkpointURL = "window.location='teacher.php?page=viewpost&id=".$_GET['id']."&cpid=".$postRow['cp_id']."';";
        }





    } else {

        $_SESSION['postid'] = $_GET['id'];
        $_SESSION['cpid'] = $postRow['cp_id'];

        $checkpointURL = "window.location='index.php';";

    } 

    ?>


  </head>

    <body style="background:#F7F7F7;">


      <div id="wrapper"> <!-- start of wrapper -->

            <div id="login" class=" form">

            <section class="login_content">

              <form>

                <h1>Link Checkpoint</h1>

                <div>

                  <?php echo '<button type="button" onclick="'.$checkpointURL.'" class="btn btn-success btn-lg btn-block"><i class="fa fa-link"></i> Click to Continue</button>'; ?>

                </div>

               

                <div>

                

                </div>

                <div class="clearfix"></div>

                <div class="separator">



                   <p> Click to redirect your link</p>

                  <div class="clearfix"></div>

                  <br />

                  <div>

                    <h1><i class="fa fa-pencil" style="font-size: 26px;"></i> Educational Social Network</h1>



                    <p>©2016 All Rights Reserved. AMACC Davao Capstone</p>

                  </div>

                </div>

              </form>

            </section>

          </div>

         </div> <!-- end of wrapper -->



      <!-- jQuery -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap -->

    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>

  </html>