<?php

function index() {



  include "functions/connect.php";

	

	$html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="">Dashboard</a>

                    </li>

                    <!-- <li><a href="?page=myprofile">My Profile</a> 

                      </li>

                      <li><a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                      -->

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                              	</li>';


                        }





                     

                    

                     $html .='</ul>

                       </li>';



                  }






                $html .='

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                       	$res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                       	$hasRows = mysqli_num_rows($res2);

	                       	if ($hasRows == 1) {

	                        $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

	                                     <ul class="nav child_menu">

	                                      <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

	                                      </li> 

	                                       <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

	                                      </li>

	                                      <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

	                                      </li>

	                                    </ul>

	                                  </li>';


	                         }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                     <li><a href="?page=myprofile">My Profile</a>

                    </li>

                  
                  
                    <li>

                      <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a>

                    </li> 

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                    	

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>

                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>




                <li role="presentation" class="dropdown">


                <a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

               

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>

            

              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

        	$countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

        	$countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);
   



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

             <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dashboard</h2>
                 
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="col-md-9 col-sm-9 col-xs-12">';


                        if ($_SESSION['getstarted'] == 0) {



                          $html .='<div class="x_title">
                                    <h2>Getting Started</h2>
                                    <div class="clearfix"></div>
                                  </div>
                                  <div class="panel-body">

                                                             <!-- Smart Wizard -->
                                        <div id="wizard" class="form_wizard wizard_horizontal">
                                          <ul class="wizard_steps">
                                            <li>
                                              <a href="#step-1">
                                                <span class="step_no">1</span>
                                                <span class="step_descr">
                                                                  Getting Started<br />
                                                                  <small>Overview</small>
                                                              </span>
                                              </a>
                                            </li>
                                            <li>
                                              <a href="#step-2">
                                                <span class="step_no">2</span>
                                                <span class="step_descr">
                                                                  Timeline, Activities, Quizzes & Exams<br />
                                                                  <small>How to deal with activities</small>
                                                              </span>
                                              </a>
                                            </li>
                                            <li>
                                              <a href="#step-3">
                                                <span class="step_no">3</span>
                                                <span class="step_descr">
                                                                  Grades & Performance<br />
                                                                  <small>Learn how grades work</small>
                                                              </span>
                                              </a>
                                            </li>
                                          </ul>
                                          <div id="step-1">
                                             <h2 class="StepTitle">Hello Student '.$_SESSION['fname'].'</h2>
                                            <p>
                                               Welcome to <b>Educational Social Network</b>, this website will be your aid in managing your class. As long you are connected via internet, you can able to interact with your teachers even at home, or vacation. This website application is intended for both teacher and students, those students who are joined in a class will able to received notifications whenever there are new updates such as <i>announcements, activities, quizzes and exams.</i>
                                            </p>
                                            <p>
                                              <b>Educational Social Network</b> or <i>(EDSON)</i> aims to connect your class in a social way. Post your announcement in your class timeline, view their profile and see their responses and interactions on your class. Upload your activity materials, so your students will download it and able to cope with your class. See next for creating a class and period.
                                            </p>

                                          </div>
                                          <div id="step-2">
                                            <h2 class="StepTitle">Timeline</h2>
                                            <p>
                                              This is where all announcements and activities can be found. There are two timelines, it can be by <b>period</b> or in <b>general</b>. First, General Timeline of a class allows you and joined students to see all posted announcements and activities in the whole period <i>(it will display all the period timeline from the start of a period until the end)</i>. Second, Period Timeline of a class allows you and joined students to see what are the announcements and activities on that one period.
                                            </p>
                                             <h2 class="StepTitle">Activities</h2>
                                            <p>
                                              A teacher can create an activities, this is different from quizzes and exams. Activities are more like assignments, students must upload their answers of the said activity within the date span allocated by the teacher. Failed to do so will be given automatically a zero grade. NOTE : every activity made will be posted automatically on a Timeline.
                                            </p>

                                            <h2 class="StepTitle">Quizzes & Exams</h2>
                                            <p>
                                              A teacher can create a set of questions for quizzes and exams. All questions will be arranged in random and your teacher can also set the schedule date span and time for the quiz or exam to be finished. Once a student is finished, it will automatically calculate its score. The teacher have aksi the option to reopen the quiz or exam for maximum of 3 days for those students who have not yet taken the quiz or exam. NOTE : every quiz and exams made will be posted automatically on a Timeline.
                                            </p>
                                          </div>
                                          <div id="step-3">
                                            <h2 class="StepTitle">Grades</h2>
                                            <p>Grades are automatically calculated for quizzes and exams. But the teacher will be manually inputed on activities, because your teachers have to download their work first before grading them via excel file. You can view your grade to your corresponding subject taken.
                                            </p>
                                            <h2 class="StepTitle">Performance</h2>
                                            <p>
                                              A graphical representation on each class will show on your dashboard home. It will record the most highest average grade attainment for each classes you have joined. And also it will feature a radar chart, consisting for their performance of each subject. Radar chart can be viewed on their profile.
                                            </p>
                                            <p>
                                              Now you have know the basics, if you have questions just check the FAQ (Frequently Asked Question) page regarding this site. Best of luck Student '.$_SESSION['fname'].'
                                            </p>

                                                  <div class="clearfix"></div>

                                                  <a href="scripts.php?page=getstarted&type=student" hidden class="btn btn-success pull-right btn-lg">Finish</a>
                                          </div>

                                        </div>
                                        <!-- End SmartWizard Content -->



                                  </div>';





                        } else {


                          $html .='

                           <div class="x_title">
                                <h2>Overall Timeline</h2>
                               
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">

                                  <div class="col-lg-4 col-md-4 col-xs-12 col-sm-4">
                                   <select id="typeposts" class="form-control">
                                     <option value="all" selected>All</option>
                                     <option value="post">Posts Only</option>
                                     <option value="activity">Activities Only</option>
                                     <option value="test">Quizzes & Exams Only</option>
                                   </select>

                                </div>

                                   <br /> 

                                   <hr />

                                     <label id="sgif" style="display:none;"><img src="images/loadgif.gif" width="30" height="30" /></label>


                            <div id="pt">';

                                      // $cp = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection,tblperiod,tblclass WHERE tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id AND tblclass.section_id=tblsection.section_id AND tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");

                             $cp = mysqli_query($con, "SELECT * FROM tblclass,tblpost,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblpost.section_id=tblclass.section_id AND tblsection.section_id=tblpost.section_id AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");

                                      $cpCount = mysqli_num_rows($cp);

                                      if ($cpCount == 0) {

                                        $html .='<h2>No Timeline To Be Shown</h2>';

                                      }

                                      else {

                                        $html .='<ul class="list-unstyled timeline">';

                                        while($cpRow = mysqli_fetch_array($cp)) {


                                              $r = mysqli_query($con, "SELECT * FROM tblreply WHERE post_id='".$cpRow['post_id']."'");



                                              $rCount = mysqli_num_rows($r);

                                              $pe = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.cp_id='".$cpRow['cp_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                                              $peCount = mysqli_num_rows($pe);


                                              if ($peCount == 0) {


                                                $periodName = "ALL PERIODS";

                                              } else {

                                                $peRow = mysqli_fetch_array($pe);

                                                 $periodName = strtoupper($peRow['period_name']);

                                               

                                              }


                                              if ($cpRow['user_type'] == "Teacher") {





                                                $s = mysqli_query($con, "SELECT * FROM tblteacher WHERE tblteacher.teacher_id='".$cpRow['user_id']."'");

                                                $sRow = mysqli_fetch_array($s);

                                                $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                                $postedPost = 'Posted by <a href="?page=viewteacher&id='.$sRow['teacher_id'].'">'.$sRow['teacher_fname'].' '.$sRow['teacher_lname'].' <i title="Teacher" class="fa fa-check-circle"></i></a>';



                                              } else {



                                                $s = mysqli_query($con, "SELECT * FROM tblstudent,tblclass WHERE tblstudent.student_id='".$cpRow['user_id']."' AND tblclass.student_id=tblstudent.student_id AND tblclass.section_id='".$cpRow['section_id']."'");



                                                $sRow = mysqli_fetch_array($s);

                                                if ($sRow['class_status'] == "Class President") {

                                                      if ($sRow['student_id'] == $_SESSION['id']) {

                                                        $editControls = ' <ul class="nav navbar-right panel_toolbox">
                                                                              <li><a href="#" data-toggle="modal" onclick="editPost('.$cpRow['post_id'].');" data-target="#editFields"><i class="fa fa-edit"></i></a></li>
                                                                                <li><a onclick="removePost('.$cpRow['post_id'].');"><i class="fa fa-remove" title="Remove Post"></i></a>
                                                                                  </li>
                                                                            </ul>';

                                                        $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                                        $postedPost = 'Posted by <a href="?page=myprofile">'.$sRow['student_fname'].' '.$sRow['student_lname'].'<i title="Class President" class="fa fa-check-circle-o"></i></a> ';

                                                      } else {

                                                         $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                                         $postedPost = 'Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].' <i title="Class President" class="fa fa-check-circle-o"></i></a>';
                                                      }

                                                  


                                                } else {

                                                    if ($sRow['student_id'] == $_SESSION['id']) {


                                                      $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> >';

                                                      $postedPost = 'Posted by <a href="?page=myprofile">'.$sRow['student_fname'].' '.$sRow['student_lname'].' <i title="X Class President" class="fa fa-remove"></i></a>';

                                                    } else {

                                                       $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                                       $postedPost = 'Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].' <i title="X Class President" class="fa fa-remove"></i></a> ';

                                                    }

                                                    

                                                }


                                              }

                                            $isDisplay = true;

                                            if ($cpRow['post_type'] == "Quiz" || $cpRow['post_type'] == "Exam") {

                                              $test = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$cpRow['custom_id']."'");

                                              $testRow = mysqli_fetch_array($test);

                                            
                                              if ($testRow['test_status'] == "Unpublished") {

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

                                                  $html .='<li>

                                                    <div class="block">

                                                      <div class="'.$tags.'">

                                                        <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'" class="'.$tag.'">

                                                          <span>'.$cpRow['post_type'].'</span>

                                                        </a>

                                                      </div>

                                                      <div class="block_content">

                                                        <h2 class="title">

                                                                        '.$headerPost.'

                                                                    </h2>

                                                                    '.

                                                        $editControls.'

                                                        <div class="byline">

                                                          <span title="Posted at '.date('F d, Y g:i A', strtotime($cpRow['post_datetime'])).'">'.$postedPost.' '.timeAgo($cpRow['post_datetime']).'</span>

                                                        </div>

                                                        <p>'.$cpRow['post_msg'].'</p>';


                                                        if ($cpRow['post_files'] == "N/A") {


                                                          if ($cpRow['post_type'] == "Activity") {

                                                              $actRes = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$cpRow['custom_id']."'");

                                                              $aCount = mysqli_num_rows($actRes);

                                                              $html .=' <p>Submitted('.$aCount.') | <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies('.$rCount.')</a></p>';


                                                          } else {



                                                            if ($cpRow['post_type'] == "Post") {



                                                              $html .=' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies ('.$rCount.')</a></p>';

                                                                } else {

                                                                    if ($testRow['test_status'] == "Unpublished") {

                                                                      $html .=' <p>Post Status : <b>Unpublished</b></p>';


                                                                    } else {

                                                                      $html .=' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies ('.$rCount.')</a> | <a href="?page=viewtest&id='.$cpRow['custom_id'].'">View Test</a></p>';

                                                                    }


                                                                }


                                                          }


                                                        } else {

                                                           $fc = split(",", $cpRow['post_files']);

                                                           $html .=' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Attachments('.count($fc).') & Replies('.$rCount.')</a></p>';

                                                        }

                                                       

                                                       

                                                      $html .='</div>

                                                    </div>

                                                 </li>';

                                                }



                                  } // end of while

                                    $html .=' </ul>';


                              }

                              $html .='
                                  </div>


                              </div>';




                        }



                   $html .=' </div>

                    <!-- start project-detail sidebar -->
                    <div class="col-md-3 col-sm-3 col-xs-12">

                      <section class="panel">

                        <div class="x_title">
                          <h2>Recent Post</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">';

                          $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' AND post_type != 'Submit' AND post_type != 'Kick' ORDER BY notif_datetime DESC");

                          $c = mysqli_num_rows($res);

                            $sectionName = "No Post";
                            $postedMsg = "No Recent Post to be shown.";
                            $postedBy = "N/A";
                            $postedDate = "N/A";
                            $postedAttachements = "N/A";
                            $postedPeriod = "N/A";
                            $postedButton = "";

                          if ($c != 0) {

                          $row = mysqli_fetch_array($res);

                          $sec = mysqli_query($con, "SELECT * FROM tblclassperiod,tblsection,tblperiod WHERE tblclassperiod.cp_id='".$row['cp_id']."' AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id");

                          $secRow = mysqli_fetch_array($sec);


                          $pos = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$row['custom_id']."'");

                          $posRow = mysqli_fetch_array($pos);

                          $postedDate = timeAgo($posRow['post_datetime']);

                          $postedPeriod = $secRow['period_name'];

                          $sectionName = $secRow['section_name'].' - '.$secRow['section_desc'];

                          $postedMsg = $posRow['post_msg'];

                          if ($secRow['section_status'] == "Active") {

                          $postedButton = '  <div class="text-center mtop20">
                            <a href="?page=viewpost&id='.$posRow['post_id'].'&cpid='.$row['cp_id'].'" class="btn btn-sm btn-primary">View Post</a>
                          </div>';

                          } else {

                          $postedButton = "<i>This class has been removed.</i>";

                          }




                            if ($posRow['user_type'] == "Teacher") {

                                $user = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$posRow['user_id']."'");

                                $userRow = mysqli_fetch_array($user);

                                $postedBy = $userRow['teacher_fname'].' '.$userRow['teacher_lname'].' <i class="fa fa-check-circle"></i>';


                            } else {


                               $user = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id='".$posRow['user_id']."'");

                               $userRow = mysqli_fetch_array($user);

                               $postedBy = $userRow['student_fname'].' '.$userRow['student_lname'].' <i class="fa fa-check-circle-o"></i>';


                            }

                            if ($posRow['post_files'] == "N/A") {


                                $postedAttachements = "No Files Attached

                                <br /> 
                                <br />";


                            } else {

                              /*

                                   <ul class="list-unstyled project_files">
                            <li><a href=""><i class="fa fa-file-word-o"></i> Functional-requirements.docx</a>
                            </li>
                            <li><a href=""><i class="fa fa-file-pdf-o"></i> UAT.pdf</a>
                            </li>
                            <li><a href=""><i class="fa fa-mail-forward"></i> Email-from-flatbal.mln</a>
                            </li>
                            <li><a href=""><i class="fa fa-picture-o"></i> Logo.png</a>
                            </li>
                            <li><a href=""><i class="fa fa-file-word-o"></i> Contract-10_12_2014.docx</a>
                            </li>
                          </ul>

                            */

                                $postedAttachements = "";

                                  $filepath = split(",", $posRow['post_files']);

                                $postedAttachements .='
                                   <ul class="list-unstyled project_files">';

                                for($i = 0; $i < count($filepath); $i++) {

                                   $ext = pathinfo($filepath[$i], PATHINFO_EXTENSION);

                                    if (strtoupper($ext) == "DOC" || strtoupper($ext) == "DOCX") {

                                      $postedAttachements .='<li>
                                      <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-word-o"></i> '.$filepath[$i].'</a>
                                       </li>';


                                    } else if (strtoupper($ext) == "XLS" || strtoupper($ext) == "XLSX") {

                                       $postedAttachements .='<li>
                                      <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-excel-o"></i> '.$filepath[$i].'</a>
                                       </li>';

                                    } else if (strtoupper($ext) == "PDF") {

                                       $postedAttachements .='<li>
                                      <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-pdf-o"></i> '.$filepath[$i].'</a>
                                       </li>';

                                    } else if (strtoupper($ext) == "PPT" || strtoupper($ext) == "PPTX") {

                                       $postedAttachements .='<li>
                                      <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-powerpoint-o"></i> '.$filepath[$i].'</a>
                                       </li>';

                                    }else if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                                       $postedAttachements .='<li>
                                      <a href="#" data-toggle="modal" data-target="#img'.$i.'"><i class="fa fa-file-image-o"></i> '.$filepath[$i].'</a>
                                       </li>';


                                    } else {

                                        $postedAttachements .='<li>
                                      <a href="uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file"></i> '.$filepath[$i].'</a>
                                       </li>';

                                       //$others.='<p><i>'.$filepath[$i].'</i> <small><b><a href="uploaded/'.$filepath[$i].'" target="_blank">Download</a></b></small></p>';

                                    }

                                }

                                $postedAttachements .='</ul>';


                            }



                          }


                          $html .='<h3 class="green"><i class="fa fa-comments-o"></i> '.$sectionName.'</h3>

                          <p>'.$postedMsg.'</p>
                          <br />

                          <div class="project_detail">

                            <p class="title">Period</p>
                            <p>'.$postedPeriod.'</p>

                            <p class="title">Posted By</p>
                            <p>'.$postedBy.'</p>
                            <p class="title">Date Posted</p>
                            <p>'.$postedDate.'</p>
                          </div>

                          <br />
                          <h5>Post Attachments</h5>'

                          .$postedAttachements.'
                     

                          <br />

                          '.$postedButton.'

                        </div>

                      </section>

                    </div>
                    <!-- end project-detail sidebar -->

                  </div>
                </div>
              </div>
            </div>


          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>';


        // modal for editing fields

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editFields">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit Fields</h4>

                        </div>

                        <div class="modal-body">

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=updatefields&ref=index" method="POST">


                           <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editore">
                                <div class="btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                  </ul>
                                </div>

                                <div class="btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                    <li>
                                      <a data-edit="fontSize 5">
                                        <p style="font-size:17px">Huge</p>
                                      </a>
                                    </li>
                                    <li>
                                      <a data-edit="fontSize 3">
                                        <p style="font-size:14px">Normal</p>
                                      </a>
                                    </li>
                                    <li>
                                      <a data-edit="fontSize 1">
                                        <p style="font-size:11px">Small</p>
                                      </a>
                                    </li>
                                  </ul>
                                </div>

                                <div class="btn-group">
                                  <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                  <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                  <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                  <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                </div>

                                <div class="btn-group">
                                  <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                  <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                  <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                  <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                </div>

                                <div class="btn-group">
                                  <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                  <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                  <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                  <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                </div>

                                <div class="btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                  <div class="dropdown-menu input-append">
                                    <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                    <button class="btn" type="button">Add</button>
                                  </div>
                                  <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                </div>


                                <div class="btn-group">
                                  <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                  <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                </div>

                              </div>

                  
                           <div id="editore" onblur="editDesc();" class="editor-wrapper"></div>

                                  <textarea style="display:none;" name="desc" id="editdesc" required="required" placeholder="Enter test description here"></textarea>

                              <br />

                               <div class="form-group" id="txtName">


                                </div>

                                <input type="hidden" name="id" id="postid" value="0">



                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                        </div>

                            </form>

                      </div>

                    </div>

                  </div>';

      // end

      for($i = 0; $i < count($filepath); $i++) {

                $ext = pathinfo($filepath[$i], PATHINFO_EXTENSION);

                                    if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                                         $html .=' <!-- modal for image-->

                                            <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="img'.$i.'">

                                                          <div class="modal-dialog modal-lg">

                                                            <div class="modal-content">



                                                              <div class="modal-header">

                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                                                                </button>

                                                                <h4 class="modal-title" id="myModalLabel">View Image</h4>

                                                              </div>

                                                              <div class="modal-body">


                                                                   <center>
                                                              <img class="img-responsive" src="uploaded/'.$filepath[$i].'"> <br />
                                                              <i>'.$filepath[$i].'</i>
                                                              </center>


                                                              </div>

                                                              <div class="modal-footer">


                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>



                                                              </div>

                                                               

                                                            </div>

                                                          </div>

                                                        </div>

                                              <!-- end of modal image -->';

                                    }

         }

    




    $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

         $html .=' <!-- modal for edit profile -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editprofile">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit My Profile</h4>

                        </div>

                        <div class="modal-body">

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofiles" enctype="multipart/form-data">

                       

                            <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            First Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="fname" class="form-control" required value="'.$_SESSION['fname'].'">

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Last Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="lname" class="form-control" required value="'.$_SESSION['lname'].'">

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Upload a photo

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="file" name="upload" accept="image/*" />

                            </div>

                          </div>

                     

                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                          
                             </form>



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal edit profile -->';




    return $html;





}




function search() {



  include "functions/connect.php";

  

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                      <!-- <li><a href="?page=myprofile">My Profile</a>

                      </li> -->

                      <li><a href="?page=search&keyword='.$_GET['keyword'].'">Search Results</a>

                      </li>

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                             
                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';

                        }





                     

                    

                     $html .='</ul>

                       </li>';



                  }






                $html .='

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                          <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                    <li><a href="?page=myprofile">My Profile</a>

                    </li>

                  
                      <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>

                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>




                <li role="presentation" class="dropdown">';







                  $html .='<a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                    

                  </ul>

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>




              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);
   



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

             <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

            <div class="row">

              <div class="col-md-12 col-xs-12">


              <div class="x_panel">

                  <div class="x_title">

                      <h2>Search Results : <b>'.$_GET['keyword'].'</b></h2>

                    

                    <div class="clearfix"></div>

                  </div>

                  <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">';

                        $keyword = mysqli_real_escape_string($con, $_GET['keyword']);

                        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE section_code='".$keyword."' AND section_status='Active'");

                        $hasSection = mysqli_num_rows($res);

                        if ($hasSection != 0) {


                        $html .='<li role="presentation" class="active"><a href="#tab_content1" id="section-tab" role="tab" data-toggle="tab" aria-expanded="true">Section</a>
                        </li>';


                        }

                        $res = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblclass,tblsection WHERE tblpost.post_msg LIKE'%".$keyword."%' AND tblclassperiod.cp_id=tblpost.cp_id AND tblclass.section_id=tblclassperiod.section_id AND tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclassperiod.section_id AND tblsection.section_status='Active'");



                        $hasPosts = mysqli_num_rows($res);

                        if ($hasPosts != 0) {


                          if ($hasSection != 0) {

                                $html .='<li role="presentation"><a href="#tab_content2" id="post-tab" role="tab" data-toggle="tab" aria-expanded="true">Posts('.$hasPosts.')</a>  </li>';

                          } else {

                              $html .='<li role="presentation" class="active"><a href="#tab_content2" id="post-tab" role="tab" data-toggle="tab" aria-expanded="true">Posts('.$hasPosts.')</a>  </li>';

                          }
                         


                        }


                        $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_fname LIKE'%".$keyword."%' AND student_id != '".$_SESSION['id']."' OR student_lname LIKE'%".$keyword."%' AND student_id != '".$_SESSION['id']."'");

                        $hasStudents = mysqli_num_rows($res);

                        if ($hasStudents != 0) {

                          $html .='<li role="presentation"><a href="#tab_content3" id="student-tab" role="tab" data-toggle="tab" aria-expanded="true">Students('.$hasStudents.')</a>
                        </li>';


                        }

                         $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_fname LIKE'%".$keyword."%' OR teacher_lname LIKE'%".$keyword."%'");

                        $hasTeachers = mysqli_num_rows($res);

                        if ($hasTeachers != 0) {

                          $html .='<li role="presentation"><a href="#tab_content4" id="teacher-tab" role="tab" data-toggle="tab" aria-expanded="true">Teachers('.$hasTeachers.')</a>
                        </li>';


                        }


                      $html .='</ul>
                      <div id="myTabContent" class="tab-content">';

                      if ($hasSection != 0) {

                      $res = mysqli_query($con, "SELECT * FROM tblsection,tblteacher WHERE tblsection.section_code='".$keyword."' AND tblteacher.teacher_id=tblsection.teacher_id AND tblsection.section_status='Active'");

                      $sectionRow = mysqli_fetch_array($res);

                      $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."' AND section_id='".$sectionRow['section_id']."'");

                      $hasJoined = mysqli_num_rows($res);

                      $html .='

                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="section-tab">
                           <ul class="list-unstyled top_profiles scroll-view">

                          <li class="media event">
                            <a class="pull-left border-aero profile_thumb">
                              <i class="fa fa-institution aero"></i>
                            </a>
                            <div class="media-body">
                              <p class="title">'.$sectionRow['section_name']. ' - '.$sectionRow['section_desc'].'</p>
                              <p><strong>Instructor : </strong> '.$sectionRow['teacher_fname'].' '.$sectionRow['teacher_lname'].'</p>';

                              if ($hasJoined == 0) {

                              $html .='<a href="scripts.php?page=joinclass&id='.$sectionRow['section_id'].'&keyword='.$_GET['keyword'].'" class="btn btn-primary btn-sm">Join Class</a>';

                              } else {

                                $joinRow = mysqli_fetch_array($res);

                                $html .='<p> <small>Joined '.timeAgo($joinRow['class_datejoined']).'</small>
                              </p>';
                              }

                              
                            $html .='</div>
                          </li>

                          </ul>
                        </div>';

                    }

                    if ($hasPosts != 0) {

                      
                      $res = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblclass,tblsection,tblperiod WHERE tblpost.post_msg LIKE'%".$keyword."%' AND tblclassperiod.cp_id=tblpost.cp_id AND tblclass.section_id=tblclassperiod.section_id AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id AND tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");


                        if ($hasSection != 0) {

                           $html .='

                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="post-tab">
                           <ul class="list-unstyled top_profiles scroll-view">';

                        } else {

                          $html .='

                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content2" aria-labelledby="post-tab">
                           <ul class="list-unstyled top_profiles scroll-view">';
                        }

                            


                  
                           while($postRow = mysqli_fetch_array($res)) {

                            $html .='<li class="media event">
                              <a class="pull-left border-aero profile_thumb">
                                <i class="fa fa-pencil blue"></i>
                              </a>
                              <div class="media-body">
                                <a class="title" href="?page=viewpost&id='.$postRow['post_id'].'&cpid='.$postRow['cp_id'].'">['.strtoupper($postRow['period_name']).'] '.$postRow['section_name'].' - '.$postRow['section_desc'].'
                                <p><strong>Message : </strong> '.$postRow['post_msg'].'</p>
                                <p><small>Posted '.timeAgo($postRow['post_datetime']).'</small></p>
                                </a>
                                </div>  
                            </li>';

                           


                           }

                           $html .=' </ul>
                          </div>';


                    }


                     if ($hasStudents != 0) {

                      
                      $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_fname LIKE'%".$keyword."%' AND student_id != '".$_SESSION['id']."' OR student_lname LIKE'%".$keyword."%' AND student_id != '".$_SESSION['id']."'");
                  

                      if ($hasPosts != 0) {

                         $html .=' <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="student-tab">';
                        

                      } else {

                         $html .=' <div role="tabpanel" class="tab-pane fade active in" id="tab_content3" aria-labelledby="student-tab">';

                      }


                     

                        while($studentsRow = mysqli_fetch_array($res)) {

                          $subj = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$studentsRow['student_id']."'");

                          $hasSubject = mysqli_num_rows($subj);

                         
                          
                        $html .=' <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Student</i></h4>
                            <div class="left col-xs-7">
                              <h2>'.$studentsRow['student_fname'].' '.$studentsRow['student_lname'].'</h2>
                              <p><strong># of Subjects Joined: </strong> '. $hasSubject .' </p>
                              <ul class="list-unstyled">
                                Email Address: '.$studentsRow['student_email'].'</li>
                              </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                              <img src="'.$studentsRow['student_picpath'].'" alt="" class="img-circle img-responsive">
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <!-- <p class="ratings">
                                <a>4.0</a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star-o"></span></a>
                              </p> -->
                            </div>
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <!-- <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-user">
                                </i> <i class="fa fa-comments-o"></i> </button> -->
                              <a href="?page=viewstudent&id='.$studentsRow['student_id'].'" class="btn btn-primary btn-xs">
                                <i class="fa fa-user"> </i> View Profile
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>';

                      }



                        $html .='</div>';


                    }
                  



                     if ($hasTeachers != 0) {

                      
                      $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_fname LIKE'%".$keyword."%' OR teacher_lname LIKE'%".$keyword."%'");
                  
                      if ($hasPosts != 0) {

                            $html .='

                        <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="teacher-tab">';

                      } else {

                        $html .='

                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content4" aria-labelledby="teacher-tab">';
                      }


                      

                        while($teachersRow = mysqli_fetch_array($res)) {

                          $subj = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$teachersRow['teacher_id']."'");

                          $hasSubject = mysqli_num_rows($subj);

                         
                          
                        $html .=' <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                        <div class="well profile_view">
                          <div class="col-sm-12">
                            <h4 class="brief"><i>Instructor</i></h4>
                            <div class="left col-xs-7">
                              <h2>'.$teachersRow['teacher_fname'].' '.$teachersRow['teacher_lname'].'</h2>
                              <p><strong># of Subjects Handled : </strong> '. $hasSubject .' </p>
                              <ul class="list-unstyled">
                                Email Address: '.$teachersRow['teacher_email'].'</li>
                              </ul>
                            </div>
                            <div class="right col-xs-5 text-center">
                              <img src="'.$teachersRow['teacher_picpath'].'" alt="" class="img-circle img-responsive">
                            </div>
                          </div>
                          <div class="col-xs-12 bottom text-center">
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <!-- <p class="ratings">
                                <a>4.0</a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star"></span></a>
                                <a href="#"><span class="fa fa-star-o"></span></a>
                              </p> -->
                            </div>
                            <div class="col-xs-12 col-sm-6 emphasis">
                              <!-- <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-user">
                                </i> <i class="fa fa-comments-o"></i> </button> -->
                              <a href="?page=viewteacher&id='.$teachersRow['teacher_id'].'" class="btn btn-primary btn-xs">
                                <i class="fa fa-user"> </i> View Profile
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>';

                      }



                        $html .='</div>';


                    }


                    if ($hasSection == 0 && $hasTeachers == 0 && $hasStudents == 0 && $hasPosts == 0) {


                      $html .='<h3>No Results Found</h3>';

                    }


                  


                      $html .='

                      </div>
                    </div>

                </div>

              </div>

            </div>







            







          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>';

        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';


                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

    return $html;





}



function classperiod() {



  include "functions/connect.php";

  

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>


                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>

                       </li>';



                  }






                $html .='

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                         <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                     <li><a href="?page=myprofile">My Profile</a>

                    </li>

                   
                      <li><a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a>
                      </li> 

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>


                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>



                <li role="presentation" class="dropdown">';







                  $html .='<a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                   

                  </ul>

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>




              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);


   
        $res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");



        $classRow = mysqli_fetch_array($res);

        $stat = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$classRow['section_id']."' AND student_id='".$_SESSION['id']."'");

        $statRow = mysqli_fetch_array($stat);


        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

            <div class="row">

               <div class="col-md-12 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    

                    <h2>'.$classRow['period_name'].' / '.$classRow['section_name'].' - '.$classRow['section_desc'].'</h2>

                    

                    <div class="clearfix"></div>

                  </div> <!-- x_title -->

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">

                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">

                        <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Timeline</a>

                        </li>

                          <li role="presentation" class=""><a href="#activity" role="tab" id="activity-tab" data-toggle="tab" aria-expanded="false">Activities</a>

                        </li>

                         <li role="presentation" class=""><a href="#quiz" role="tab" id="quiz-tab" data-toggle="tab" aria-expanded="false">Tests</a>

                        </li>



                      </ul>

                      <div id="myTabContent" class="tab-content">

                        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">

                          <br />';

                          if ($statRow['class_status'] == "Class President") {


                               $html .='<button id="compose" class="btn btn-success" type="button">Post to Timeline</button>';

                          }



                          $html .='<a href="#" data-toggle="modal" data-target="#viewannouncements" class="btn btn-primary">View Announcements</a>

                          <hr />



                          <ul class="list-unstyled timeline">';


                          $cl = mysqli_query($con, "SELECT * FROM tblclassperiod WHERE cp_id='".$_GET['id']."'");

                          $clRow = mysqli_fetch_array($cl);



                          // $t = mysqli_query($con, "SELECT * FROM tblpost WHERE section_id='".$clRow['section_id']."' AND cp_id='".$_GET['id']."' OR section_id='".$clRow['section_id']."' AND cp_id='0' ORDER BY post_datetime DESC");

                          $t = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$_GET['id']."' ORDER BY post_datetime DESC");


                          $tCount = mysqli_num_rows($t);



                          if ($tCount == 0) {





                            $html .='<h2>No Timeline to be shown</h2>';



                          } else {





                          while($tRow = mysqli_fetch_array($t)) {


                            $editControls = "";

                            $r = mysqli_query($con, "SELECT * FROM tblreply WHERE post_id='".$tRow['post_id']."'");



                            $rCount = mysqli_num_rows($r);



                            if ($tRow['user_type'] == "Teacher") {



                              $s = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$tRow['user_id']."'");

                              $sRow = mysqli_fetch_array($s);

                              $headerPost = 'Posted by <a href="?page=viewteacher&id='.$tRow['user_id'].'">'.$sRow['teacher_fname'].' '.$sRow['teacher_lname'].'</a> <i title="Teacher" class="fa fa-check-circle"></i>';



                            } else {



                              $s = mysqli_query($con, "SELECT * FROM tblstudent,tblclass WHERE tblstudent.student_id='".$tRow['user_id']."' AND tblclass.student_id=tblstudent.student_id AND tblclass.section_id='".$classRow['section_id']."'");



                              $sRow = mysqli_fetch_array($s);

                              if ($sRow['class_status'] == "Class President") {

                                   if ($tRow['user_id'] != $_SESSION['id']) {

                                   $headerPost = 'Posted by <a href="?page=viewstudent&id='.$tRow['user_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="Class President" class="fa fa-check-circle-o"></i>';

                                  } else {


                                                        $editControls = ' <ul class="nav navbar-right panel_toolbox">
                                                                              <li><a href="#" data-toggle="modal" onclick="editPost('.$tRow['post_id'].');" data-target="#editFields"><i class="fa fa-edit"></i></a></li>
                                                                                <li><a onclick="removePost('.$tRow['post_id'].');"><i class="fa fa-remove" title="Remove Post"></i></a>
                                                                                  </li>
                                                                            </ul>';


                                   $headerPost = 'Posted by <a href="myprofile">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="Class President" class="fa fa-check-circle-o"></i>';

                                  }


                              } else {

                                  if ($tRow['user_id'] != $_SESSION['id']) {

                                   $headerPost = 'Posted by <a href="?page=viewstudent&id='.$tRow['user_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="X Class President" class="fa fa-remove"></i>';

                                 } else {

                                   $headerPost = 'Posted by <a href="?page=myprofile">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="X Class President" class="fa fa-remove"></i>';

                                 }

                              }

                           


                            }

                          $isDisplay = true;


                          if ($tRow['post_type'] == "Quiz" || $tRow['post_type'] == "Exam") {

                            $test = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$tRow['custom_id']."'");

                            $testRow = mysqli_fetch_array($test);

                            if ($testRow['test_status'] == "Unpublished") {

                              $isDisplay = false;

                            }



                          }



                          if ($tRow['post_type'] == "Post") {

                            $tag = "tag";
                            $tags = "tags";

                            $postContent = '<p>'.$tRow['post_msg'].'</p>
                                              '.$headerPost;


                          } else if ($tRow['post_type'] == "Quiz") {

                             $tag = "quiztag";
                            $tags = "quiztags";

                            $postContent = '<h3 class="title">'.$testRow['test_name'].'</h3>
                                                <p>'.$testRow['test_desc'].'</p>
                                                '.$headerPost;


                          } else if ($tRow['post_type'] == "Exam") {

                             $tag = "examtag";
                            $tags = "examtags";

                             $postContent = '<h3 class="title">'.$testRow['test_name'].'</h3>
                                                <p>'.$testRow['test_desc'].'</p>
                                                '.$headerPost;


                          } else if ($tRow['post_type'] == "Activity") {


                             $tag = "activitytag";
                            $tags = "activitytags";


                            $a = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$tRow['custom_id']."'");

                            $aRow = mysqli_fetch_array($a);


                              $postContent = '<h3 class="title">'.$aRow['activity_name'].'</h3>
                                              <p>'.$aRow['activity_desc'].'</p>
                                              '.$headerPost;  

                          }


                            if ($isDisplay == true) {

                                $html .='<li>

                                  <div class="block">

                                    <div class="'.$tags.'">

                                      <a href="?page=viewpost&id='.$tRow['post_id'].'&cpid='.$_GET['id'].'" class="'.$tag.'">

                                        <span>'.$tRow['post_type'].'</span>

                                      </a>

                                    </div>

                                    <div class="block_content">'.$editControls.'

                                    '.$postContent.'

                                      <div class="byline">

                                        <span title="Posted at '.date('F d, Y g:i A', strtotime($tRow['post_datetime'])).'">'.timeAgo($tRow['post_datetime']).'</span>

                                      </div>';


                                      if ($tRow['post_files'] == "N/A") {


                                        if ($tRow['post_type'] == "Activity") {

                                            $actRes = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$tRow['custom_id']."'");

                                            $aCount = mysqli_num_rows($actRes);

                                            $html .=' <p><a href="?page=viewpost&id='.$tRow['post_id'].'&cpid='.$_GET['id'].'">Submiited('.$aCount.') / View Replies('.$rCount.')</a></p>';


                                        } else if ($tRow['post_type'] == "Post") {



                                        $html .=' <p><a href="?page=viewpost&id='.$tRow['post_id'].'&cpid='.$_GET['id'].'">View Replies ('.$rCount.')</a></p>';

                                        } else {

                                            $html .=' <p><a href="?page=viewpost&id='.$tRow['post_id'].'&cpid='.$_GET['id'].'">View Replies ('.$rCount.')</a> | <a href="?page=viewtest&id='.$tRow['custom_id'].'">View Test</a></p>';


                                        }


                                      } else {

                                         $fc = split(",", $tRow['post_files']);

                                         $html .=' <p><a href="?page=viewpost&id='.$tRow['post_id'].'&cpid='.$_GET['id'].'">View Attachments('.count($fc).') & Replies('.$rCount.')</a></p>';

                                      }

                                     

                                     

                                    $html .='</div>

                                  </div>

                               </li>';


                             }



                          }



                        }



                 

                 

                          $html .='

                          </ul>

                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="activity" aria-labelledby="activity-tab">

                          <br />  ';


                           $a = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$_GET['id']."' AND post_type='Activity' ORDER BY post_datetime DESC");



                          $aCount = mysqli_num_rows($a);



                          if ($aCount == 0) {





                            $html .='<h2>No Activities to be shown</h2>';

                          } else {


                              $html .='<h2>List of '.$classRow['period_name'].' Activities</h2>

                               <hr />

                               <div class="x_content">

                                 <table id="activitytable" class="table table-striped" width="100%">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Activity Name</th>
                                        <th>Activity Span</th>
                                        <th>Status</th>
                                        <th>Submission</th>
                                        <th>Score</th>
                                        <th class="hidden-xs">Actions</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                    $act = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblactivity.activity_id=tblpost.custom_id");

                                    while($actRow = mysqli_fetch_array($act)) {

                                      $aScore = 0;
                                     

                                      $submit = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$actRow['activity_id']."' AND student_id='".$_SESSION['id']."'");

                                      $submitCount = mysqli_num_rows($submit);

                                      if ($submitCount == 0) {

                                        $hasSubmitted = "N/A";

                                        $aScore = 0;

                                      } else {

                                        $submitRow = mysqli_fetch_array($submit);

                                        $hasSubmitted = $submitRow['submit_status'];

                                        $aScore = $submitRow['submit_grade'];

                                      }

                                       $html .='

                                      <tr>
                                      <th scope="row">'.$actRow['activity_id'].'</th>
                                      <td>'.$actRow['activity_name'].'</td>
                                      <td>'.date("M d, Y", strtotime($actRow['activity_datestart'])).' - '.date("M d, Y", strtotime($actRow['activity_dateend'])).'</td>
                                      <td>'.$actRow['activity_status'].'</td>
                                      <td>'.$hasSubmitted.'</td>
                                      <td width="20%"><div class="progress">';

                                          if ($aScore < 50) {

                                                      $html .='<div class="progress-bar progress-bar-danger" data-transitiongoal="'.$aScore.'">'.$aScore.'%</div>';

                                                    } else if ($aScore >= 50 && $aScore <= 70) {


                                                      $html .='<div class="progress-bar progress-bar-info" data-transitiongoal="'.$aScore.'">'.$aScore.'%</div>';
                                                    } else {


                                                      $html .='<div class="progress-bar progress-bar-primary" data-transitiongoal="'.$aScore.'">'.$aScore.'%</div>';
                                                    }


                                              // <div class="progress-bar progress-bar-info" data-transitiongoal="'.$prg.'">'.$prg.'%</div>
                                        $html .='</div></td>

                                      <td class="hidden-xs">  <div class="btn-group">
                                              <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" type="button"> Actions <span class="caret"></span> </button>
                                              <ul class="dropdown-menu">
                                                <li><a href="?page=viewpost&id='.$actRow['post_id'].'&cpid='.$_GET['id'].'">View Post</a>
                                                </li>';

                                                if ($hasSubmitted == "Checked") {

                                                  $html .='  <li><a href="#checked'.$actRow['activity_id'].'" data-toggle="modal" >View Grade</a>
                                                </li>';

                                                }

                                               
                                              $html .='</ul>
                                            </div>
                                          </td>
                                      </tr>';


                                    }

                                    $html .='
                                    </tbody>
                                  </table>

                              </div>';

                          }


                        $html .='

                        </div>

                         <div role="tabpanel" class="tab-pane fade" id="quiz" aria-labelledby="quiz-tab">

                          <br />  ';


                           $a = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type !='Post' AND tblpost.post_type != 'Activity' AND tbltest.test_id=tblpost.custom_id AND tbltest.test_status != 'Unpublished' ORDER BY tblpost.post_datetime DESC");



                          $aCount = mysqli_num_rows($a);



                          if ($aCount == 0) {





                            $html .='<h2>No Tests to be shown</h2>';

                          } else {


                              $html .='<h2>List of '.$classRow['period_name'].' Tests</h2>

                               <hr />

                               <div class="x_content">

                                 <table id="quiztable" class="table table-striped" width="100%">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Item Scored</th>
                                        <th>Score Percentage</th>
                                        <th class="hidden-xs">Actions</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                    $act = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type != 'Post' AND tblpost.post_type != 'Activity' AND tbltest.test_id=tblpost.custom_id");

                                    while($actRow = mysqli_fetch_array($act)) {

                                     

                                      $totalTest = mysqli_query($con, "SELECT SUM(points) AS sum FROM tblquestion WHERE test_id='".$actRow['test_id']."'");

                                      $totalTestRow = mysqli_fetch_array($totalTest);

                              

                                      $tScore = 0;


                                      $submit = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$actRow['test_id']."' AND student_id='".$_SESSION['id']."'");

                                      $submitCount = mysqli_num_rows($submit);

                                      if ($submitCount == 0) {

                                        $hasSubmitted = "Not Yet Taken";

                                           $tScore = 0;

                                      } else {

                                        $submitRow = mysqli_fetch_array($submit);

                                        $hasSubmitted = $submitRow['taken_status'];


                                      $tScore = $submitRow['result_grade'];


                                      }

                                         $prg = ($tScore  / $totalTestRow['sum']) * 100;

                                        $prg = round($prg, 0);

                                      if ($actRow['test_type'] == "Quiz") {

                                           $html .='

                                          <tr>
                                          <th scope="row">'.$actRow['test_id'].'</th>
                                          <td>'.$actRow['test_name'].'</td>
                                          <td>'.$actRow['test_type'].'</td>
                                          <td>'.date("M d, Y", strtotime($actRow['test_datestart'])).' - '.date("M d, Y g:i A", strtotime($actRow['test_dateend'])).'</td>
                                          <td>'.$hasSubmitted.'</td>
                                          <td>'.$tScore.'/'. $totalTestRow['sum'].'</td>
                                          <td width="20%"> <div class="progress">';

                                                    if ($prg < 50) {

                                                      $html .='<div class="progress-bar progress-bar-danger" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';

                                                    } else if ($prg >= 50 && $prg <= 70) {


                                                      $html .='<div class="progress-bar progress-bar-info" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    } else {


                                                      $html .='<div class="progress-bar progress-bar-primary" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    }

                                          
                                          $html .='</div></td>
                                                <td class="hidden-xs">  <div class="btn-group">
                                                  <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" type="button"> Actions <span class="caret"></span> </button>
                                                  <ul class="dropdown-menu">
                                                    <li><a href="?page=viewpost&id='.$actRow['post_id'].'&cpid='.$_GET['id'].'">View Post</a>
                                                    </li>
                                                    <li><a href="?page=viewtest&id='.$actRow['test_id'].'">View Test</a>
                                                    </ul>
                                                </div>
                                              </td>
                                          </tr>';

                                      } else {

                                          $html .='

                                          <tr>
                                          <th scope="row"><b>'.$actRow['test_id'].'</b></th>
                                          <td><b>'.$actRow['test_name'].'</b></td>
                                          <td><b>'.$actRow['test_type'].'</b></td>
                                          <td><b>'.date("M d, Y", strtotime($actRow['test_datestart'])).' - '.date("M d, Y g:i A", strtotime($actRow['test_dateend'])).'</b></td>
                                          <td><b>'.$hasSubmitted.'</b></td>
                                          <td>'.$tScore.'/'. $totalTestRow['sum'].'</td>    
                                          <td width="20%"> <div class="progress">';

                                                    if ($prg < 50) {

                                                      $html .='<div class="progress-bar progress-bar-danger" title="'.$prg.'%"  data-transitiongoal="'.$prg.'">'.$prg.'%</div>';

                                                    } else if ($prg >= 50 && $prg <= 70) {


                                                      $html .='<div class="progress-bar progress-bar-info" title="'.$prg.'%" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    } else {


                                                      $html .='<div class="progress-bar progress-bar-primary" title="'.$prg.'%"  data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    }

                                          
                                          $html .='</div></td>  <td class="hidden-xs">  <div class="btn-group">
                                                  <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-sm" type="button"> Actions <span class="caret"></span> </button>
                                                  <ul class="dropdown-menu">
                                                    <li><a href="?page=viewpost&id='.$actRow['post_id'].'&cpid='.$_GET['id'].'">View Post</a>
                                                    </li>
                                                    <li><a href="?page=viewtest&id='.$actRow['test_id'].'">View Test</a>
                                                    </ul>
                                                </div>
                                              </td>
                                          </tr>';

                                      }


                                    }

                                    $html .='
                                    </tbody>
                                  </table>


                              </div>';

                          }


                        $html .='

                        </div>


                      </div>

                   </div>


                </div> <!-- x_panel-->

              </div> <!-- col -->

            </div> <!-- row -->




          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>


    <!-- compose -->

    <div class="compose col-md-6 col-xs-12">

      <div class="compose-header">

        Timeline

        <button type="button" class="close compose-close">

          <span>×</span>

        </button>

      </div>



      <div class="compose-body">

         <form action="scripts.php?page=post&id='.$_GET['id'].'&type=student" enctype="multipart/form-data" method="POST" >
        Post to '.$classRow['period_name'].' '.$classRow['section_name'].' - '.$classRow['section_desc'].'

         <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                    <div class="btn-group">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                      <ul class="dropdown-menu">
                      </ul>
                    </div>

                    <div class="btn-group">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li>
                          <a data-edit="fontSize 5">
                            <p style="font-size:17px">Huge</p>
                          </a>
                        </li>
                        <li>
                          <a data-edit="fontSize 3">
                            <p style="font-size:14px">Normal</p>
                          </a>
                        </li>
                        <li>
                          <a data-edit="fontSize 1">
                            <p style="font-size:11px">Small</p>
                          </a>
                        </li>
                      </ul>
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                      <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                      <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                      <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                      <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                      <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                      <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                    </div>

                    <div class="btn-group">
                      <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                      <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                      <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                      <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                    </div>

                    <div class="btn-group">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                      <div class="dropdown-menu input-append">
                        <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                        <button class="btn" type="button">Add</button>
                      </div>
                      <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                    </div>


                    <div class="btn-group">
                      <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                      <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                    </div>
        </div>

                  <div id="editor" onblur="saveText();" class="editor-wrapper"></div>

                  <textarea id="message" name="msg" required style="display:none;"></textarea>

      </div>



      <div class="compose-footer">

     
      <input type="file" name="upload[]" id="file" class="inputfile inputfile-3" data-multiple-caption="{count} files selected" multiple="multiple" />
      <label for="file"><i class="fa fa-upload"></i> <small><span> Upload Files</span></small></label>
      <label id="sgif" style="display:none;"><img src="images/loadgif.gif" width="20" height="20" /></label>

        <button class="btn btn-sm btn-success" onclick="showLoading();" type="submit">Post</button>

      </div>

      </form>

    </div>

    <!-- /compose -->';

    // start of modal view grade

     $res = mysqli_query($con, "SELECT * FROM tblpost,tblactivity,tblsubmit WHERE tblpost.cp_id='".$_GET['id']."' AND tblactivity.activity_id=tblpost.custom_id AND tblsubmit.activity_id=tblactivity.activity_id AND tblsubmit.student_id='".$_SESSION['id']."' AND tblsubmit.submit_status='Checked'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="checked'.$row['activity_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">My Grade</h4>

                        </div>

                        <div class="modal-body">


                          <form class="form-horizontal form-label-left" action="" method="POST">

                          <center><p>My Grade For #'.$row['activity_id'].' - '.$row['activity_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Grade</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="text" readonly class="form-control" value="'.$row['submit_grade'].'">

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Remarks</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <textarea class="form-control" value="'.$row['submit_remarks'].'" readonly></textarea>

                            </div>

                          </div>

                         

                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';

      }

      // end 


        // modal for editing fields

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editFields">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit Fields</h4>

                        </div>

                        <div class="modal-body">

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=updatefields&ref=classperiod&id='.$_GET['id'].'" method="POST">


                           <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editore">
                                <div class="btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                  </ul>
                                </div>

                                <div class="btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                    <li>
                                      <a data-edit="fontSize 5">
                                        <p style="font-size:17px">Huge</p>
                                      </a>
                                    </li>
                                    <li>
                                      <a data-edit="fontSize 3">
                                        <p style="font-size:14px">Normal</p>
                                      </a>
                                    </li>
                                    <li>
                                      <a data-edit="fontSize 1">
                                        <p style="font-size:11px">Small</p>
                                      </a>
                                    </li>
                                  </ul>
                                </div>

                                <div class="btn-group">
                                  <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                  <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                  <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                  <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                </div>

                                <div class="btn-group">
                                  <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                  <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                  <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                  <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                </div>

                                <div class="btn-group">
                                  <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                  <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                  <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                  <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                </div>

                                <div class="btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                  <div class="dropdown-menu input-append">
                                    <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                    <button class="btn" type="button">Add</button>
                                  </div>
                                  <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                </div>


                                <div class="btn-group">
                                  <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                  <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                </div>

                              </div>

                  
                           <div id="editore" onblur="editDesc();" class="editor-wrapper"></div>

                                  <textarea style="display:none;" name="desc" id="editdesc" required="required" placeholder="Enter test description here"></textarea>

                              <br />

                               <div class="form-group" id="txtName">


                                </div>

                                <input type="hidden" name="id" id="postid" value="0">



                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                        </div>

                            </form>

                      </div>

                    </div>

                  </div>';

      // end


              $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                             $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

          $html .=' <!-- modal for announcement-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="viewannouncements">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">View Announcements</h4>

                        </div>

                        <div class="modal-body">

                          
                           <table  width="100%" class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>Post #</th>
                                        <th>Announcement</th>
                                        <th>Date Time Posted</th>
                                      </tr>
                                    </thead>
                                    <tbody>';


                          $res = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='0' AND announcement='Yes' AND section_id='".$classRow['section_id']."' ORDER BY post_datetime DESC");

                          while($row = mysqli_fetch_array($res)) {


                            $html .= '<tr>
                                      <td>'.$row['post_id'].'</td>
                                      <td>'.$row['post_msg'].'</td>
                                      <td>'.timeAgo($row['post_datetime']).'</td>
                                      </tr>';

                          }



                        $html .='</tbody>
                            </table>

                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- announcement -->';

    return $html;





}

function viewpost() {



  include "functions/connect.php";

  

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                      <!-- <li><a href="?page=myprofile">My Profile</a>

                      </li> -->

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>


                       </li> ';



                  }






                $html .='

                  <li><a href="?page=viewpost&id='.$_GET['id'].'&cpid='.$_GET['cpid'].'"><i class="fa fa-circle"></i> View Post</a>

                      </li>

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                          <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                     <li><a href="?page=myprofile">My Profile</a>

                    </li>

                    <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>
                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>




                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>




                <li role="presentation" class="dropdown">';







                  $html .=' <a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                   

                  </ul>

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>




              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);


   
         $res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['cpid']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");



        $classRow = mysqli_fetch_array($res);



        $res = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$_GET['id']."'");

        $postRow = mysqli_fetch_array($res);


        if ($postRow['user_type'] == "Teacher") {

          $user = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$postRow['user_id']."'");

          $userRow = mysqli_fetch_array($user);


          $headerPost = $userRow['teacher_fname'].' '.$userRow['teacher_lname'] .' <i title="Teacher" class="fa fa-check-circle"></i>';



          $img   = $userRow['teacher_picpath'];



        } else {



          $s = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id='".$postRow['user_id']."'");



          $sRow = mysqli_fetch_array($s);



          $headerPost = $sRow['student_fname'].' '.$sRow['student_lname'].' <i title="Class President" class="fa fa-check-circle-o"></i>';



          if ($sRow['student_status'] == "Registration") {



            $img = "images/student/".$sRow['student_picpath'];



          } else {



              $img  = $sRow['student_picpath'];

          }



        



        }



        $rep = mysqli_query($con, "SELECT * FROM tblreply WHERE post_id='".$_GET['id']."' ORDER BY reply_datetime DESC");



        $replyCount = mysqli_num_rows($rep);


        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

             <div class="row">

                 <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="x_panel">

                    <div class="x_title">

                      <h2>View Post / '.$classRow['section_name'].' - '.$classRow['section_desc'].'</h2>

                      

                      <div class="clearfix"></div>

                    </div>

                    <div class="x_content">



                      <ul class="list-unstyled msg_list">

                        <li>

                          <a>

                            <span class="image">

                              <img src="'.$img.'" style="width:68px;" alt="img" />

                            </span>

                            <span>

                              <span>'.$headerPost.'</span>

                              <span class="time">'.timeAgo($postRow['post_datetime']).'&nbsp;&nbsp;&nbsp;</span>

                            </span>

                           <br /> <br /> <br /> <br />

                              <h3>'.$postRow['post_msg'].'</h3>

                            

                          </a>

                        </li>

                      </ul>
                        <a href="javascript:fbshareCurrentPage()" class="btn btn-primary btn-sm" target="_blank" alt="Share on Facebook"><i class="fa fa-facebook"></i> Share</a>';


                        $videos = "";

                        $images = "";

                        $others = "";

                        $activities = "";



                        if ($postRow['post_type'] == "Activity") {


                          $act = mysqli_query($con, "SELECT * FROM tblactivity WHERE post_id='".$_GET['id']."'");

                          $actRow = mysqli_fetch_array($act);



                              $dateNow = date("Y-m-d H:i:s");
                              $dateEnd = date("Y-m-d H:i:s", strtotime($actRow['activity_dateend']));



                          $activities = ' <br />
                          <h3></u>Activity Information</u></h3>

                          <p><b>Activity Name : </b> '.$actRow['activity_name'].'</p>

                          <p><b>Instructions : </b> '.$actRow['activity_desc'].'</p>

                          <p><b>Duration : </b> '.date("M d, Y", strtotime($actRow['activity_datestart'])).' - '.date("M d, Y", strtotime($actRow['activity_dateend'])).'</p>';

                            if ($actRow['activity_status'] == "Open") {


                              $activities .=' <p><b>Status : </b> Open</p>';

                            } else {

                              $activities .='<p><b>Status : </b> Closed</p>';

                            }

                          $activities .= '<p><small>All activities are automatically closed on 11:59 PM of its last date</small></p>

                          <hr />';

                          $sub = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$actRow['activity_id']."' AND student_id='".$_SESSION['id']."'");

                          $sCount = mysqli_num_rows($sub);

                          if ($sCount == 0) {



                              if ($actRow['activity_status'] == "Open") {

                                  $activities .='
                                  <p>Submitted : <b>Not Yet</b></p>
                                  <form method="POST" action="scripts.php?page=submit&id='.$_GET['id'].'&cpid='.$_GET['cpid'].'&activity='.$actRow['activity_id'].'" enctype="multipart/form-data">


                                  <input type="file" name="upload" required="required" />

                                  <br />

                                  <input type="submit" value="Submit Activity" class="btn btn-primary btn-sm" />


                                  </form>';

                              } else {

                                  $activities .='<p>Submitted : <b>Failed</b></p>';
                              }


                          

                          } else {

                            $subRow = mysqli_fetch_array($sub);

                            $activities .='<p>Submitted : <b>'.$subRow['submit_status'].'</b></p>
                                            <p>Date Submitted : '.timeAgo($subRow['submit_datetime']).'</p>';
                          }


                        } else if ($postRow['post_type'] == "Quiz" || $postRow['post_type'] == "Exam") {


                          $act = mysqli_query($con, "SELECT * FROM tbltest WHERE post_id='".$_GET['id']."'");

                          $actRow = mysqli_fetch_array($act);



                              $dateNow = date("Y-m-d H:i:s");
                              $dateEnd = date("Y-m-d H:i:s", strtotime($actRow['test_dateend']));



                          $activities = ' <br />
                          <h3></u>'.$postRow['post_type'].' Information</u></h3>

                          <p><b>'.$postRow['post_type'].' Name : </b> '.$actRow['test_name'].'</p>

                          <p><b>Instructions : </b> '.$actRow['test_desc'].'</p>

                          <p><b>Duration : </b> '.date("M d, Y", strtotime($actRow['test_datestart'])).' - '.date("M d, Y", strtotime($actRow['test_dateend'])).'</p>';

                            if ($dateNow < $dateEnd) {


                              $activities .=' <p><b>Status : </b> Open</p>';

                            } else {

                              $activities .='<p><b>Status : </b> Closed</p>';

                            }

                          $activities .= '<p><small>All activities are automatically closed on 11:59 PM of its last date</small></p>

                          <hr />';

                          $sub = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$actRow['test_id']."' AND student_id='".$_SESSION['id']."'");

                          $sCount = mysqli_num_rows($sub);

                          if ($sCount == 0) {



                              if ($dateNow < $dateEnd) {

                                  $activities .='
                                  <p><a href="?page=viewtest&id='.$actRow['test_id'].'" class="btn btn-info">Take '.$postRow['post_type'].'</a></p>';
                                  
                              } else {

                                  $activities .='<p>Test Taken : <b>Failed</b></p>';
                              }


                          

                          } else {

                            $subRow = mysqli_fetch_array($sub);

                                $activities .='
                                  <p><a href="?page=viewtest&id='.$actRow['test_id'].'" class="btn btn-info">View '.$postRow['post_type'].'</a></p>';
                                  
                          }

                        }



                 
                        if ($postRow['post_files'] != "N/A") {

                        $html .='  <br />
                        <h4><u>Attachments</u></h4>';

                        $filepath = split(",", $postRow['post_files']);

                      

                        for($i = 0; $i < count($filepath); $i++) {

                           $ext = pathinfo($filepath[$i], PATHINFO_EXTENSION);

                            if (strtoupper($ext) == "DOC" || strtoupper($ext) == "DOCX" || strtoupper($ext) == "PDF" || strtoupper($ext) == "XLS" || strtoupper($ext) == "XLSX" || strtoupper($ext) == "PPT" || strtoupper($ext) == "PPTX") {

                          $html .='<p><i>'.$filepath[$i].'</i> <small><b><a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank">View</a> / <a href="uploaded/'.$filepath[$i].'" target="_blank">Download</a></b></small></p>';

                            } else if (strtoupper($ext) == "MP4") {

                              $videos .= '<video width="100%" height="100%" controls> <source src="uploaded/'.$filepath[$i].'">  Your browser does not support HTML5 video. </video> <center><a href="uploaded/'.$filepath[$i].'" target="_blank">Download <small>(right click then save link)</small></a></center><br /> <br />';



                            } else if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                              $images .='<p><i>'.$filepath[$i].'</i> <small><b><a href="#" data-toggle="modal" data-target="#img'.$i.'">View Image</a></b></small></p>';


                            } else {

                               $others.='<p><i>'.$filepath[$i].'</i> <small><b><a href="uploaded/'.$filepath[$i].'" target="_blank">Download</a></b></small></p>';

                            }

                        } 

                      }

                      



                    



                  
                    $html .= '   

                  

                    <!-- <a href="javascript:gshareCurrentPage()" class="btn btn-danger btn-sm" target="_blank" alt="Share on Google"><i class="fa fa-google"></i> Share</a> -->


                    '.$activities.' '.$images.' '.$others.' '.$videos.'
                    </div>

                  </div>

                </div>



                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="x_panel">

                    <div class="x_title">

                      <h2>Replies ('.$replyCount.')</h2>

                      

                      <div class="clearfix"></div>

                    </div>

                    <div class="x_content">

                    <a href="?page=classperiod&id='.$_GET['cpid'].'" class="btn btn-primary">Back</a>

                     <button id="compose" class="btn btn-success" type="button">Reply</button>

                      <ul class="list-unstyled msg_list">';



                      if ($replyCount == 0) {



                        $html .='<h3>No Replies</h3>';





                      } else {


                        $r = 0;


                        while($replyRow = mysqli_fetch_array($rep)) {



                          if ($replyRow['user_type'] == "Teacher") {


                             $s = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$replyRow['user_id']."'");



                            $sRow = mysqli_fetch_array($s);


                            $headerPost = $sRow['teacher_fname'].' '.$sRow['teacher_lname'] .' <i title="Teacher" class="fa fa-check-circle"></i>';



                            $img   = $sRow['teacher_picpath'];



                          } else {


                           $s = mysqli_query($con, "SELECT * FROM tblstudent,tblclass WHERE tblstudent.student_id='".$replyRow['user_id']."' AND tblclass.student_id=tblstudent.student_id AND tblclass.section_id='".$classRow['section_id']."'");



                            $sRow = mysqli_fetch_array($s);



                            if ($sRow['class_status'] == "Class President") {



                                   $headerPost = $sRow['student_fname'].' '.$sRow['student_lname'].' <i title="Class President" class="fa fa-check-circle-o"></i>';



                            } else {





                                  $headerPost = $sRow['student_fname'].' '.$sRow['student_lname'];

                            }





                       



                            if ($sRow['student_status'] == "Registration") {



                              $img = "images/student/".$sRow['student_picpath'];



                            } else {



                                $img  = $sRow['student_picpath'];

                            }



                          



                          }





                          $html .='<li>

                          <a>

                            <span class="image">

                              <img src="'.$img.'" style="width:68px;" />

                            </span>

                            <span>

                              <span><b>'.$headerPost.'</b></span>

                              <span class="time">'.timeAgo($replyRow['reply_datetime']).'&nbsp;&nbsp;&nbsp;</span>

                            </span>

                            <span class="message">

                              <h4>'.$replyRow['reply_msg'].'</h4>

                            </span>

                          </a>

                        </li>';


                        $r += 1;

                        if ($r == ($replyCount)) {

                          $html .='<li style="display:none;">

                          <a>

                            <span class="image">

                              <img src="'.$img.'" alt="img-circle" />

                            </span>

                            <span>

                              <span>'.$headerPost.'e</span>

                              <span class="time">'.timeAgo($replyRow['reply_datetime']).'&nbsp;&nbsp;&nbsp;</span>

                            </span>

                            <span class="message">

                              '.$replyRow['reply_msg'].'

                            </span>

                          </a>

                        </li>';

                        }

                        }



                      }

                        

                      $html .='</ul>

                      

                      

                    </div>

                  </div>

                </div>

            </div>




          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>

      <!-- compose -->

    <div class="compose col-md-6 col-xs-12">

      <div class="compose-header">

        Reply Post

        <button type="button" class="close compose-close">

          <span>×</span>

        </button>

      </div>



      <div class="compose-body">

        <div id="alerts"></div>



        <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">

          <div class="btn-group">

            Reply

          </div>



        </div>

        <form action="scripts.php?page=studentreply&id='.$_GET['id'].'&cpid='.$_GET['cpid'].'" method="POST">



          <textarea id="message" required="required" class="form-control" name="msg" maxlength="160"></textarea>

      </div>



      <div class="compose-footer">

        <button class="btn btn-sm btn-success" type="submit" id="compose">Reply</button>

      </div>

      </form>

    </div>

    <!-- /compose -->';


    for($i = 0; $i < count($filepath); $i++) {

                $ext = pathinfo($filepath[$i], PATHINFO_EXTENSION);

                                    if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                                         $html .=' <!-- modal for image-->

                                            <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="img'.$i.'">

                                                          <div class="modal-dialog modal-lg">

                                                            <div class="modal-content">



                                                              <div class="modal-header">

                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                                                                </button>

                                                                <h4 class="modal-title" id="myModalLabel">View Image</h4>

                                                              </div>

                                                              <div class="modal-body">

                                                              <center>
                                                              <img class="img-responsive" src="uploaded/'.$filepath[$i].'"> <br />
                                                              <i>'.$filepath[$i].'</i>
                                                              </center>

                                                              </div>

                                                              <div class="modal-footer">


                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>



                                                              </div>

                                                               

                                                            </div>

                                                          </div>

                                                        </div>

                                              <!-- end of modal image -->';

                                    }

         }


        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

    return $html;





}


function viewstudent() {



  include "functions/connect.php";

  

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                      <!-- <li><a href="?page=myprofile">My Profile</a>

                      </li> -->

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>


                       </li> ';



                  }






                $html .='

                  <li><a href="?page=viewstudent&id='.$_GET['id'].'"><i class="fa fa-circle"></i> View Profile</a>

                      </li>

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                        <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                     <li><a href="?page=myprofile">My Profile</a>

                    </li>

                     <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>




                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>




                <li role="presentation" class="dropdown">';







                  $html .=' <a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                    

                  </ul>

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>




              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);


   
         $res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['cpid']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");



        $classRow = mysqli_fetch_array($res);



        $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id='".$_GET['id']."'");

        $userRow = mysqli_fetch_array($res);





        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

             <div class="row">



                 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View User <small>Student Profile</small></h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">



                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">';


                    	if (isset($_SESSION['msg'])) {


                    		if ($_SESSION['msg'] != "") {


                    			$html .='	 <div class="alert alert-success alert-dismissible fade in" role="alert">
			                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			                    </button>
			                    <strong>Message Sent</strong> You have sent a message
			             </div>';

                    		}

                    		$_SESSION['msg'] = "";

                    	}

                    


                      $html .='

                      <div class="profile_img">

                        <!-- end of image cropping -->
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="img-responsive avatar-view" src="'.$userRow['student_picpath'].'" alt="Avatar">

                        
                          <!-- Loading state -->
                          <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                        </div>
                  

                      </div>
                      <h3>'.$userRow['student_fname'].' '.$userRow['student_lname'].'</h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa fa-asterisk user-profile-icon"></i> '.$userRow['student_num'].' 
                        </li>

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> '.$userRow['student_email'].'
                        </li>

                        <!-- <li class="m-top-xs">
                          <i class="fa fa-external-link user-profile-icon"></i>
                          <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                        </li> -->
                      </ul>

                      <button type="button" id="compose" class="btn btn-success"><i class="fa fa-send m-right-xs"></i> Send Message</button>
                      <br />

                      <!-- start skills -->
                      <!-- 
                      <h4>Skills</h4>
                      <ul class="list-unstyled user_data">
                        <li>
                          <p>Web Applications</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                        <li>
                          <p>Website Design</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                          </div>
                        </li>
                        <li>
                          <p>Automation & Testing</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                          </div>
                        </li>
                        <li>
                          <p>UI / UX</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                      </ul>
                      -->
                      <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <div class="profile_title">
                        <div class="col-md-6">
                          <h2>Student Performance</h2>
                        </div>
                        <div class="col-md-6">
                          
                        </div>
                      </div>
                      <!-- start of user-activity-graph -->
                      
                        <br />
                        <div id="cr">
                        <canvas id="canvasRadar"></canvas>
                        </div>
                      
                      <!-- end of user-activity-graph -->

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a>
                          </li>
                         
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                          <h3> No Recent Activities</h3>
                            <!-- start recent activity -->
                            <!-- <ul class="messages">
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-info">24</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Desmond Davison</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                    <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                  </p>
                                </div>
                              </li>
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-error">21</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Brian Michaels</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1" aria-hidden="true" data-icon=""></span>
                                    <a href="#" data-original-title="">Download</a>
                                  </p>
                                </div>
                              </li>
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-info">24</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Desmond Davison</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                    <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                  </p>
                                </div>
                              </li>
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-error">21</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Brian Michaels</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1" aria-hidden="true" data-icon=""></span>
                                    <a href="#" data-original-title="">Download</a>
                                  </p>
                                </div>
                              </li>

                            </ul> -->
                            <!-- end recent activity -->

                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>




          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>

      <!-- compose -->

    <div class="compose col-md-6 col-xs-12">

      <div class="compose-header">

        Send Message to '.$userRow['student_fname'].' '.$userRow['student_lname'].'

        <button type="button" class="close compose-close">

          <span>×</span>

        </button>

      </div>



      <div class="compose-body">

        <div id="alerts"></div>



        <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">

          <div class="btn-group">

            Leave a Message

          </div>



        </div>

        <form action="scripts.php?page=sendmessage&id='.$_GET['id'].'&type=student" method="POST">



          <textarea id="message" required="required" class="form-control" name="msg" maxlength="160"></textarea>

      </div>



      <div class="compose-footer">

        <button class="btn btn-sm btn-success" type="submit" id="compose">Send</button>

      </div>

      </form>

    </div>

    <!-- /compose -->';

        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

    return $html;





}

function viewteacher() {



  include "functions/connect.php";

  

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                      <!-- <li><a href="?page=myprofile">My Profile</a>

                      </li> -->

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>


                       </li> ';



                  }






                $html .='

                  <li><a href="?page=viewteacher&id='.$_GET['id'].'"><i class="fa fa-circle"></i> View Profile</a>

                      </li>

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                         <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                    <li><a href="?page=myprofile">My Profile</a>

                    </li>

                      <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>



                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>





                <li role="presentation" class="dropdown">';







                  $html .='<a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                  

                  </ul>

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>




              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);


   
         $res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['cpid']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");



        $classRow = mysqli_fetch_array($res);



        $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$_GET['id']."'");

        $userRow = mysqli_fetch_array($res);





        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View User <small>Teacher Profile</small></h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">';

                    if (isset($_SESSION['msg'])) {


                        if ($_SESSION['msg'] != "") {


                          $html .='  <div class="alert alert-success alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <strong>Message Sent</strong> You have sent a message
                   </div>';

                        }

                        $_SESSION['msg'] = "";

                      }

                    


                      $html .='



                      <div class="profile_img">

                        <!-- end of image cropping -->
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="img-responsive avatar-view" src="'.$userRow['teacher_picpath'].'" alt="Avatar">

                        
                          <!-- Loading state -->
                          <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                        </div>
                  

                      </div>
                      <h3>'.$userRow['teacher_fname'].' '.$userRow['teacher_lname'].'</h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa fa-asterisk user-profile-icon"></i> '.$userRow['employee_id'].' 
                        </li>

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> '.$userRow['teacher_email'].'
                        </li>

                        <!-- <li class="m-top-xs">
                          <i class="fa fa-external-link user-profile-icon"></i>
                          <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                        </li> -->
                      </ul>

                       <button type="button" id="compose" class="btn btn-success"><i class="fa fa-send m-right-xs"></i> Send Message</button>
                      <br />

                      <!-- start skills -->
                      <!-- 
                      <h4>Skills</h4>
                      <ul class="list-unstyled user_data">
                        <li>
                          <p>Web Applications</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                        <li>
                          <p>Website Design</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                          </div>
                        </li>
                        <li>
                          <p>Automation & Testing</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                          </div>
                        </li>
                        <li>
                          <p>UI / UX</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                      </ul>
                      -->
                      <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <div class="profile_title">
                        <div class="col-md-6">
                          <h2>Highest Class Grade Performance</h2>
                        </div>
                        <div class="col-md-6">
                          
                        </div>
                      </div>
                      <!-- start of user-activity-graph -->
                        <br />
                        <div id="cr">
                        <canvas id="canvasRadar"></canvas>
                        </div>
                      
                      <!-- end of user-activity-graph -->

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a>
                          </li>
                         
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                          <h3> No Recent Activities</h3>
                            <!-- start recent activity -->
                            <!-- <ul class="messages">
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-info">24</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Desmond Davison</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                    <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                  </p>
                                </div>
                              </li>
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-error">21</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Brian Michaels</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1" aria-hidden="true" data-icon=""></span>
                                    <a href="#" data-original-title="">Download</a>
                                  </p>
                                </div>
                              </li>
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-info">24</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Desmond Davison</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                    <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                  </p>
                                </div>
                              </li>
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-error">21</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Brian Michaels</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1" aria-hidden="true" data-icon=""></span>
                                    <a href="#" data-original-title="">Download</a>
                                  </p>
                                </div>
                              </li>

                            </ul> -->
                            <!-- end recent activity -->

                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>




          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>

       <!-- compose -->

    <div class="compose col-md-6 col-xs-12">

      <div class="compose-header">

        Send Message to '.$userRow['teacher_fname'].' '.$userRow['teacher_lname'].'

        <button type="button" class="close compose-close">

          <span>×</span>

        </button>

      </div>



      <div class="compose-body">

        <div id="alerts"></div>



        <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">

          <div class="btn-group">

            Leave a Message

          </div>



        </div>

        <form action="scripts.php?page=sendmessage&id='.$_GET['id'].'&type=teacher" method="POST">



          <textarea id="message" required="required" class="form-control" name="msg" maxlength="160"></textarea>

      </div>



      <div class="compose-footer">

        <button class="btn btn-sm btn-success" type="submit" id="compose">Send</button>

      </div>

      </form>

    </div>

    <!-- /compose -->';

        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                             $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

    return $html;





}

function myprofile() {



  include "functions/connect.php";

  

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                      <li><a href="?page=myprofile">My Profile</a>

                      </li> 

                      <li><a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a>
                      </li> 

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>


                       </li> ';



                  }






                $html .='

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                        <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                     <li><a href="?page=myprofile">My Profile</a>

                    </li>

                      <li><a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a>
                      </li> 


                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>



                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>





                <li role="presentation" class="dropdown">';







                  $html .=' <a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                    

                  </ul>

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>




              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);


   
         $res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['cpid']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");



        $classRow = mysqli_fetch_array($res);



        $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id='".$_SESSION['id']."'");

        $userRow = mysqli_fetch_array($res);





        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

             <div class="row">



                 <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Profile <small>My Profile</small></h2>
                   
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">



                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">';


                      if (isset($_SESSION['msg'])) {


                        if ($_SESSION['msg'] != "") {


                          $html .='  <div class="alert alert-success alert-dismissible fade in" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <strong>Message Sent</strong> You have sent a message
                   </div>';

                        }

                        $_SESSION['msg'] = "";

                      }

                    


                      $html .='

                      <div class="profile_img">

                        <!-- end of image cropping -->
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="img-responsive avatar-view" src="'.$userRow['student_picpath'].'" alt="Avatar">

                        
                          <!-- Loading state -->
                          <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                        </div>
                  

                      </div>
                      <h3>'.$userRow['student_fname'].' '.$userRow['student_lname'].'</h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa fa-asterisk user-profile-icon"></i> '.$userRow['student_num'].' 
                        </li>

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> '.$userRow['student_email'].'
                        </li>

                        <!-- <li class="m-top-xs">
                          <i class="fa fa-external-link user-profile-icon"></i>
                          <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                        </li> -->
                      </ul>

                      <!-- start skills -->
                      <!-- 
                      <h4>Skills</h4>
                      <ul class="list-unstyled user_data">
                        <li>
                          <p>Web Applications</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                        <li>
                          <p>Website Design</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                          </div>
                        </li>
                        <li>
                          <p>Automation & Testing</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                          </div>
                        </li>
                        <li>
                          <p>UI / UX</p>
                          <div class="progress progress_sm">
                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                          </div>
                        </li>
                      </ul>
                      -->
                      <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <div class="profile_title">
                        <div class="col-md-6">
                          <h2>My Subject Performance</h2>
                        </div>
                        <div class="col-md-6">
                          
                        </div>
                      </div>
                      <!-- start of user-activity-graph -->
                      
                        <br />
                        <div id="cr">
                        <canvas id="canvasRadar"></canvas>
                        </div>
                      
                      <!-- end of user-activity-graph -->

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Recent Activity</a>
                          </li>
                         
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                          <h3> No Recent Activities</h3>
                            <!-- start recent activity -->
                            <!-- <ul class="messages">
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-info">24</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Desmond Davison</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                    <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                  </p>
                                </div>
                              </li>
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-error">21</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Brian Michaels</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1" aria-hidden="true" data-icon=""></span>
                                    <a href="#" data-original-title="">Download</a>
                                  </p>
                                </div>
                              </li>
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-info">24</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Desmond Davison</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1 text-info" aria-hidden="true" data-icon=""></span>
                                    <a href="#"><i class="fa fa-paperclip"></i> User Acceptance Test.doc </a>
                                  </p>
                                </div>
                              </li>
                              <li>
                                <img src="images/img.jpg" class="avatar" alt="Avatar">
                                <div class="message_date">
                                  <h3 class="date text-error">21</h3>
                                  <p class="month">May</p>
                                </div>
                                <div class="message_wrapper">
                                  <h4 class="heading">Brian Michaels</h4>
                                  <blockquote class="message">Raw denim you probably havent heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua butcher retro keffiyeh dreamcatcher synth.</blockquote>
                                  <br />
                                  <p class="url">
                                    <span class="fs1" aria-hidden="true" data-icon=""></span>
                                    <a href="#" data-original-title="">Download</a>
                                  </p>
                                </div>
                              </li>

                            </ul> -->
                            <!-- end recent activity -->

                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>




          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>';

        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

         $html .=' <!-- modal for edit profile -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editprofile">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit My Profile</h4>

                        </div>

                        <div class="modal-body">

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofiles" enctype="multipart/form-data">

                       

                            <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            First Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="fname" class="form-control" required value="'.$_SESSION['fname'].'">

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Last Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="lname" class="form-control" required value="'.$_SESSION['lname'].'">

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Upload a photo

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="file" name="upload" accept="image/*" />

                            </div>

                          </div>

                     

                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                          
                             </form>



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal edit profile -->';


    return $html;





}

function inbox() {



  include "functions/connect.php";

  $conversation = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."'");

  $conversationCount = mysqli_num_rows($conversation);

  if ($conversationCount == 0) {

    header("location: ?page=index");
  }
  

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                      <!-- <li><a href="?page=myprofile">My Profile</a> 

                      </li> -->

                    </ul>

                  </li>

                  <li><a href=""><i class="fa fa-envelope-o"></i> Inbox</a></li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>

                       </li>';



                  }






                $html .='

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                         <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                    <li><a href="?page=myprofile">My Profile</a>

                    </li>

                     <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>



                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>





                <li role="presentation" class="dropdown">';







                  $html .=' <a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                   

                  </ul> 

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>


              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);
   



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>My Inbox<small>Conversation Area</small></h2>
                        
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-sm-3 col-md-3 col-xs-12 mail_list_column" style="height:400px; overflow-y:auto;">';

                        $selectedName = "";

                        $selectedPhoto = "";

                        $customURL = '';

                        $selectedID = "";

                        $selectedType = "";

                        $selectedEmail = "";

                        if (isset($_GET['id'])) {

                          $currentID = $_GET['id'];

                        } else {

                          $currentID = 0;

                        }

                        $res = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='student' ORDER BY conversation_status DESC");

                        while ($row = mysqli_fetch_array($res)) {

                            $msg = mysqli_query($con, "SELECT * FROM tblmessage WHERE conversation_id='".$row['conversation_id']."' ORDER BY date_sent DESC");

                            $msgRow = mysqli_fetch_array($msg);


                            if ($row['sender_type'] == "teacher") {


                                $user = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$row['sender_id']."'");

                                $userRow = mysqli_fetch_array($user);

                                $userFullName = $userRow['teacher_fname'].' '.$userRow['teacher_lname'];

                                $userPicpath = $userRow['teacher_picpath'];

                                $userURL = '?page=viewteacher&id='.$row['sender_id'];

                                $userType = "teacher";

                                $userEmail = $userRow['teacher_email'];


                            } else {

                                $user = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id='".$row['sender_id']."'");

                                $userRow = mysqli_fetch_array($user);

                                $userFullName = $userRow['student_fname'].' '.$userRow['student_lname'];

                                $userPicpath = $userRow['student_picpath'];

                                $userURL = '?page=viewstudent&id='.$row['sender_id'];

                                $userType = "student";

                                $userEmail = $userRow['student_email'];

                            }


                            $html .='

                                <a href="?page=inbox&id='.$row['conversation_id'].'">
                                  <div class="mail_list">
                                    <div class="left">';

                            if ($currentID == $row['conversation_id']) {

                              $html .='<i class="fa fa-circle"></i>';

                              $selectedName = $userFullName;

                              $selectedPhoto = $userPicpath;

                              $selectedID = $row['sender_id'];

                              $selectedType = $userType;

                              $selectedEmail = $userEmail;

                              $customURL = $userURL;

                            } else {

                               $html .='<i class="fa fa-circle-o"></i>';

                            }


                            $html .='
                             </div>
                            <div class="right">
                              <h3>'.$userFullName.' <small>'.timeAgo($row['conversation_datetime']).'</small></h3>
                              <p>'.substr($msgRow['message'], 0, 50).'</p>
                            </div>
                          </div>
                        </a>';

                        }

                    
                             
                           
                      $html .='</div>
                      <!-- /MAIL LIST -->

                      <!-- CONTENT MAIL -->
                      <div class="col-sm-9 col-md-9 col-xs-12 mail_view">
                        <div class="inbox-body">';
                          
                        if (isset($_GET['id'])) {


                            $html .='

                            <h3><a href="'.$customURL.'"><img src="'.$selectedPhoto.'" width="40" height="40" class="img-circle" />'.$selectedName.' </a></h3>
                            '.$selectedEmail.' <b>('.strtoupper($selectedType).')</b> <br />
                             <a href="'.$customURL.'" class="btn btn-sm btn-primary">View Profile</a>

                            <!-- <button type="button" id="compose" class="btn btn-success btn-sm">Reply</button> -->
                            <hr />
                              
                              <div id="scrollable" style="height:400px; width:100%; overflow-y:auto;">';


                              $msg = mysqli_query($con, "SELECT * FROM tblmessage WHERE conversation_id='".$_GET['id']."'");

                              $userIdentifier = "";
                              $meCount = 0;
                              $awayCount = 0;
                             
                              $totalMsg = mysqli_num_rows($msg);
                              $countMsg = 0;
                             

                              while($msgRow = mysqli_fetch_array($msg)) {


                                     if ($msgRow['user_id'] == $_SESSION['id'] && $msgRow['user_type'] == $_SESSION['isLogin']) {

                                           $userIdentifier = "Me";
                                           $meCount += 1;
                                           

                                     } else {


                                            $userIdentifier = "Away";
                                            $awayCount += 1;
                                     }




                                     if ($userIdentifier == "Me") {


                                          if ($awayCount != 0) {

                                            $html .='<br />
                                                      </div>';

                                              $awayCount = 0;

                                          }

                                          if ($meCount == 1) {

                                                 $html .='<div id="m'.$countMsg.'">
                                                 <h4 class="pull-right"><b>Me</b></h4> <br /> <br />';

                                          } 

                                            $html .='<span class="pull-right" title="Sent '.timeAgo($msgRow['date_sent']).'">'.$msgRow['message'].' </span> <br />';

                                     } else {

                                          if ($meCount != 0) {

                                            $html .='<br />
                                                      </div>';

                                              $meCount = 0;

                                          }


                                          if ($awayCount == 1) {

                                                   $html .='<div id="m'.$countMsg.'">
                                                   <h4 class="pull-left"><a href="'.$customURL.'"><b>'.$selectedName.'</b></a></h4> <br /> <br />';

                                            } 

                                              $html .='<span class="pull-left" title="Sent '.timeAgo($msgRow['date_sent']).'">'.$msgRow['message'].' </span> <br />';

                                     }
                                   

                            
                                   
                                     $countMsg += 1;

                                     if ($countMsg == $totalMsg) {

                                        $html .='<br />
                                                      </div>';

                                        $additionalMsgs = $totalMsg + 300;

                                        for($i = $totalMsg; $i < $additionalMsgs; $i++) {

                                          $html .='<div id="m'.$i.'"></div>';

                                        }


                                     }
                              }

                                                                    
                          $html .='</div> 

                            <input type="hidden" value="'.$totalMsg.'" id="cMsg">
                            <input type="hidden" value="'.$selectedName.'" id="nm">
                            <input type="hidden" value="" id="userStats">
                            <input type="hidden" value="'.$selectedID.'" id="sid">
                            <input type="hidden" value="'.$selectedType.'" id="stype">

                             <textarea id="message" required="required" class="form-control" placeholder="Enter message here" name="msg" maxlength="160"></textarea> <br />
                             <button class="btn btn-sm btn-success pull-right" onclick="sendReply()" type="button"><i class="fa fa-paper-plane"></i></button>';





                        }

                          
                        $html .='</div>

                      </div>
                      <!-- /CONTENT MAIL -->
                    </div>
                  </div>
                </div>
              </div>
            </div>






            







          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>

         <!-- compose -->

    <div class="compose col-md-6 col-xs-12">

      <div class="compose-header">

        Reply to '.$selectedName.'

        <button type="button" class="close compose-close">

          <span>×</span>

        </button>

      </div>



      <div class="compose-body">

        <div id="alerts"></div>



        <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">

          <div class="btn-group">

            Enter reply here

          </div>



        </div>

        <form action="#" method="POST">



          <!-- <textarea id="message" required="required" class="form-control" name="msg" maxlength="160"></textarea> -->

      </div>



      <div class="compose-footer">

        <button class="btn btn-sm btn-success" onclick="sendReply()" type="button">Send</button>
        <button class="btn btn-sm btn-primary" type="button" id="compose">Hide</button>

      </div>

      </form>

    </div>

    <!-- /compose -->';


        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

         $html .=' <!-- modal for edit profile -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editprofile">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit My Profile</h4>

                        </div>

                        <div class="modal-body">

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofiles" enctype="multipart/form-data">

                       

                            <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            First Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="fname" class="form-control" required value="'.$_SESSION['fname'].'">

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Last Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="lname" class="form-control" required value="'.$_SESSION['lname'].'">

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Upload a photo

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="file" name="upload" accept="image/*" />

                            </div>

                          </div>

                     

                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                          
                             </form>



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal edit profile -->';


    return $html;





}


function viewtest() {



  include "functions/connect.php";


      // check for ongoing to finish when the time duration expires

       $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$_GET['id']."' AND student_id='".$_SESSION['id']."'");

       $hasTaken = mysqli_num_rows($taken);

       if ($hasTaken != 0) {

         $takenRow = mysqli_fetch_array($taken);

         $dateNow = date("Y-m-d H:i:s");
         $dateEnd = date("Y-m-d H:i:s", strtotime($takenRow['datetime_end']));

         if ($dateNow > $dateEnd) {


            mysqli_query($con, "UPDATE tbltaken SET taken_status='Finish' WHERE taken_id='".$takenRow['taken_id']."'");

         }
    
      }

      // end

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                    <!-- <li><a href="?page=myprofile">My Profile</a>

                      </li> 

                      <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a>

                      -->

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>


                       </li> ';



                  }






                $html .='

                  <li><a href=""><i class="fa fa-circle"></i> View Test</a>

                      </li>

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                          <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                     <li><a href="?page=myprofile">My Profile</a>

                    </li>

                     <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>




                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>




                <li role="presentation" class="dropdown">';







                  $html .='<a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                  

                  </ul>

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>




              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);




        $test = mysqli_query($con, "SELECT * FROM tbltest,tblpost,tblclassperiod,tblsection,tblperiod,tblteacher WHERE tbltest.test_id='".$_GET['id']."' AND tblpost.post_id=tbltest.post_id AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id AND tblteacher.teacher_id=tblsection.teacher_id");


        $testRow = mysqli_fetch_array($test);





        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

             <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View Test</h2>
                   
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Class Section </span>
                          <span class="value text-success"> '.strtoupper($testRow['section_name']). ' - '.strtoupper($testRow['section_desc']).'</span>
                        </li>
                        <li>
                          <span class="name"> Period </span>
                          <span class="value text-success"> '.strtoupper($testRow['period_name']).' </span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> Test Type </span>
                          <span class="value text-success"> '.strtoupper($testRow['test_type']).' </span>
                        </li>
                      </ul>
                      <br />';

                      
                        $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$_GET['id']."' AND student_id='".$_SESSION['id']."'");

                        $hasTaken = mysqli_num_rows($taken);

                          $dateNow = date("Y-m-d H:i:s");
                          $dateEnd = date("Y-m-d H:i:s", strtotime($testRow['test_dateend']));

                          $items = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$_GET['id']."'");

                          $totalItems = mysqli_num_rows($items);

                         

                        if ($hasTaken == 0) {

                           $html .='<center> 
                           <ul class="list-unstyled">
                          <li>'.$testRow['test_type'].' Name : '.$testRow['test_name'].' </li>
                          <li>Question Format : <b>'.$testRow['test_format'].'</b></li>
                          <li>Time Duration : <b>'.$testRow['test_time'].' mins</b></li>
                          <li>Number of Questions : <b>'.$totalItems.'</b></li>
                          </ul>';


                          if ($dateNow > $dateEnd) {

                            $html .='<h3>The test has ended</h3>
                            <div class="progress">
                                  <div class="progress-bar progress-bar-info" data-transitiongoal="0">0</div>
                                </div>
                                <center>You have failed to take the test</center>';

                          } else {

                            $html .='<a href="scripts.php?page=newtest&id='.$_GET['id'].'" id="takebutton" onclick="newTest();" class="btn btn-primary btn-lg">Take Now <i class="fa fa-arrow-circle-right"></i></a>
                            <img src="images/loadgif.gif" id="wizgif" style="display:none;" width="50" height="50" />
                            ';
                          }

                          $html .='</center>';

                        } else {


                          $takenRow = mysqli_fetch_array($taken);


                          if ($takenRow['taken_status'] == "Ongoing") {


                               $html .='<center> <ul class="list-unstyled">
                                <li>'.$testRow['test_type'].' Name : '.$testRow['test_name'].'</li>
                                <li>Question Format : <b>'.$testRow['test_format'].'</b></li>
                                <li>Time Duration : <b>'.$testRow['test_time'].' mins</b></li>
                                <li>Number of Questions : <b>'.$totalItems.'</b></li>
                                </ul>
                                <a href="?page=taketest&id='.$_GET['id'].'#wizard" class="btn btn-primary btn-lg">Resume Test <i class="fa fa-arrow-circle-right"></i></a>
                                </center>';


                            } else {

                                $ques = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$_GET['id']."'");

                                $countItems = mysqli_num_rows($ques);

                                $correct = mysqli_query($con, "SELECT * FROM tblanswer WHERE answered_status='Correct' AND test_id='".$_GET['id']."' AND student_id='".$_SESSION['id']."'");

                                $correctNum = mysqli_num_rows($correct);

                                

                                $prg = ($correctNum / $countItems) * 100;

                                $prg = round($prg, 0);

                                $html .='<center><h4>You have already taken the test</h4>';

                                if ($testRow['test_format'] == "Essay") {

                                    $html .='<h3>You have currently scored '.$correctNum.' out of '.$countItems.' Items</h3>
                                    <i>Do not worry, your instructor will update your score based on your answers</i>';
                                } else {

                                  $html .='<h3>You Scored '.$correctNum.' out of '.$countItems.' Items</h3>';
                                }

                                
                                $html .= '</center>
                                  <div class="progress">';

                                    if ($prg < 50) {

                                                      $html .='<div class="progress-bar progress-bar-danger" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';

                                                    } else if ($prg >= 50 && $prg <= 70) {


                                                      $html .='<div class="progress-bar progress-bar-info" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    } else {


                                                      $html .='<div class="progress-bar progress-bar-primary" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    }

                                  // <div class="progress-bar progress-bar-info" data-transitiongoal="'.$prg.'">'.$prg.'%</div>
                                $html .='</div>
                                <center>A total of <b>'.$takenRow['result_grade'].'</b> point/s has been recorded to your grade.</center>
                                ';
                              // code to show the results
                            }


                        }


                      if ($testRow['test_peek'] == "Yes") {


                            $html .='<div>


                            <hr />
                              <h4>My '.$testRow['test_type'].' Results</h4>';


                              if ($hasTaken == 0) {

                                $html .='Results will be shown after taking the test.';

                              } else {

                             

                                if ($takenRow['taken_status'] == "Ongoing") {


                                    $html .='Results will be shown after taking the test.';

                                } else if ($testRow['test_format'] != "Essay") {

                                  $html .='
                                   <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th>Question #</th>
                                              <th>Status</th>
                                              <th>Points Earned</th>
                                            </tr>
                                          </thead>

                                          <tbody>';


                                          $pt = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$_SESSION['id']."' AND tblquestion.question_id=tblanswer.question_id");

                                          $q = 1;

                                          while($ptRow = mysqli_fetch_array($pt)) {

                                              $p = 0;

                                            if ($ptRow['answered_status'] == "Correct") {

                                              $p = $ptRow['points'];

                                            }



                                            $html .='
                                            <tr>
                                            <td>Question #'.$q.'</td>
                                            <td>'.$ptRow['answered_status'].'</td>
                                            <td>'.$p.'</td>
                                            </tr>';

                                            $q += 1;

                                          }

                                          $html .='</tbody>
                                          </table>';
                                } else {

                                 $html .='
                                   <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th>Question #</th>
                                              <th>Answered</th>
                                              <th>Points Earned</th>
                                            </tr>
                                          </thead>

                                          <tbody>';


                                          $pt = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$_SESSION['id']."' AND tblquestion.question_id=tblanswer.question_id");

                                          $q = 1;


                                            

                                          while($ptRow = mysqli_fetch_array($pt)) {


                                           
                                            $p = $ptRow['answered_pt'];

                                            


                                            $html .='
                                            <tr>
                                            <td>Question #'.$q.'</td>
                                            <td>'.$ptRow['student_answered'].'</td>
                                            <td>'.$p.'</td>
                                            </tr>';

                                            $q += 1;

                                          }

                                          $html .='</tbody>
                                          </table>';

                                }


                              }


                            $html .='
                            </div>';


                    }


                    $html.='</div>

                    <!-- start project-detail sidebar -->
                    <div class="col-md-3 col-sm-3 col-xs-12">

                      <section class="panel">

                        <div class="x_title">
                          <h2>'.$testRow['test_type'].' Description</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                          <h3 class="green"><i class="fa fa-tasks"></i> '.$testRow['test_type'].'</h3>

                          <p>'.$testRow['test_desc'].'</p>
                          <br />

                          <div class="project_detail">

                            <p class="title">Instructor</p>
                            <p>'.$testRow['teacher_fname'].' '.$testRow['teacher_lname'].'</p>
                            <p class="title">Started</p>
                            <p>'.timeAgo($testRow['test_datestart']).'</p>
                            <p class="title">Deadline</p>
                            <p>'.date("M d, Y g:i A", strtotime($testRow['test_dateend'])).'</p>

                            <hr />';

                                $postFiles = mysqli_query($con, "SELECT * FROM tblpost WHERE custom_id='".$_GET['id']."' AND post_type != 'Activity'");


                                $imgRow = mysqli_fetch_array($postFiles);

                                if ($imgRow['post_files'] == "N/A") {

                                  $html .='No File Attachments';

                                } else {

                                  $html .='Test Attachments';
                                  
                                    $filepath = split(",", $imgRow['post_files']);

                                       for($i = 0; $i < count($filepath); $i++) {

                                         $ext = pathinfo($filepath[$i], PATHINFO_EXTENSION);

                                          if (strtoupper($ext) == "DOC" || strtoupper($ext) == "DOCX") {

                                            $html .='<li>
                                            <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-word-o"></i> '.$filepath[$i].'</a>
                                             </li>';


                                          } else if (strtoupper($ext) == "XLS" || strtoupper($ext) == "XLSX") {

                                             $html .='<li>
                                            <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-excel-o"></i> '.$filepath[$i].'</a>
                                             </li>';

                                          } else if (strtoupper($ext) == "PDF") {

                                             $html .='<li>
                                            <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-pdf-o"></i> '.$filepath[$i].'</a>
                                             </li>';

                                          } else if (strtoupper($ext) == "PPT" || strtoupper($ext) == "PPTX") {

                                             $html .='<li>
                                            <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-powerpoint-o"></i> '.$filepath[$i].'</a>
                                             </li>';

                                          } else if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                                             $html .='<li>
                                            <a href="#" data-toggle="modal" data-target="#img'.$i.'"><i class="fa fa-file-image-o"></i> '.$filepath[$i].'</a>
                                             </li>';


                                          } else {

                                              $html .='<li>
                                            <a href="uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file"></i> '.$filepath[$i].'</a>
                                             </li>';

                                             //$others.='<p><i>'.$filepath[$i].'</i> <small><b><a href="uploaded/'.$filepath[$i].'" target="_blank">Download</a></b></small></p>';

                                          }

                                      }


                                }

                          $html .='</div>

                        </div>

                      </section>

                    </div>
                    <!-- end project-detail sidebar -->

                  </div>
                </div>
              </div>
            </div>



          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>';

     for($i = 0; $i < count($filepath); $i++) {

                $ext = pathinfo($filepath[$i], PATHINFO_EXTENSION);

                                    if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                                         $html .=' <!-- modal for image-->

                                            <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="img'.$i.'">

                                                          <div class="modal-dialog modal-lg">

                                                            <div class="modal-content">



                                                              <div class="modal-header">

                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                                                                </button>

                                                                <h4 class="modal-title" id="myModalLabel">View Image</h4>

                                                              </div>

                                                              <div class="modal-body">

                                                              <center>
                                                              <img class="img-responsive" src="uploaded/'.$filepath[$i].'"> <br />
                                                              <i>'.$filepath[$i].'</i>
                                                              </center>

                                                              </div>

                                                              <div class="modal-footer">


                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>



                                                              </div>

                                                               

                                                            </div>

                                                          </div>

                                                        </div>

                                              <!-- end of modal image -->';

                                    }

         }


        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

         $html .=' <!-- modal for edit profile -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editprofile">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit My Profile</h4>

                        </div>

                        <div class="modal-body">

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofiles" enctype="multipart/form-data">

                       

                            <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            First Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="fname" class="form-control" required value="'.$_SESSION['fname'].'">

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Last Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="lname" class="form-control" required value="'.$_SESSION['lname'].'">

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Upload a photo

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="file" name="upload" accept="image/*" />

                            </div>

                          </div>

                     

                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                          
                             </form>



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal edit profile -->';


    return $html;





}

function taketest() {



  include "functions/connect.php";


  // check remaining time

  $time = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$_GET['id']."' AND student_id='".$_SESSION['id']."'");

  $timeC = mysqli_num_rows($time);

  if ($timeC == 0) {

    header("location: ?page=viewtest&id=".$_GET['id']);

  }

  $timeRow = mysqli_fetch_array($time);

  $date1  = new Datetime(date("Y-m-d H:i:s"));

  $date2 = new Datetime(date("Y-m-d H:i:s",strtotime($timeRow['datetime_end'])));

  $startDate = new Datetime(date("Y-m-d H:i:s",strtotime($timeRow['datetime_taken'])));

  $st = date("Y-m-d H:i:s", strtotime($timeRow['datetime_taken']));
  $et = date("Y-m-d H:i:s", strtotime($timeRow['datetime_end']));


  $interval = date_diff($date2,$date1);

  if ($timeRow['taken_status'] == "Finish") {

    header("location: ?page=viewtest&id=".$_GET['id']);

  } 
  // end

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                       <!-- <li><a href="?page=myprofile">My Profile</a>

                      </li>

                      <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                      -->

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>


                       </li> ';



                  }






                $html .='

                  <li><a href=""><i class="fa fa-circle"></i> Take Test</a>

                      </li>

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                         <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                     <li><a href="?page=myprofile">My Profile</a>

                    </li>

                  
                     <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>




                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>




                <li role="presentation" class="dropdown">';







                  $html .='<a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                  

                  </ul>

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>




              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);




        $test = mysqli_query($con, "SELECT * FROM tbltest,tblpost,tblclassperiod,tblsection,tblperiod,tblteacher WHERE tbltest.test_id='".$_GET['id']."' AND tblpost.post_id=tbltest.post_id AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id AND tblteacher.teacher_id=tblsection.teacher_id");


        $testRow = mysqli_fetch_array($test);





        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

             <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Take '.$testRow['test_type'].'</h2>
                   
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Class Section </span>
                          <span class="value text-success"> '.strtoupper($testRow['section_name']). ' - '.strtoupper($testRow['section_desc']).'</span>
                        </li>
                        <li>
                          <span class="name"> Period </span>
                          <span class="value text-success"> '.strtoupper($testRow['period_name']).' </span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> Time Remaining</span>
                          <span class="value text-success" id="hms"> '.$interval->format('%H:%I:%S').' </span>
                        </li>
                      </ul>
                      <br />

                           <!-- Smart Wizard -->
                           <center><img src="images/loadgif.gif" id="wizgif" width="50" height="50" /></center>

                    <div id="wizard" class="form_wizard wizard_horizontal" style="display:none;">
                      <ul class="wizard_steps">';

                        $ident = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$_SESSION['id']."' AND tblquestion.tFormat='Identification' AND tblquestion.question_id=tblanswer.question_id ORDER BY RAND()");


                        $identCount = mysqli_num_rows($ident);

                        $stepCount = 1;
                        $stepFinish = 1;
                        $currentItem = 1;

                        if ($identCount != 0) {

                          $html .='<li>
                              <a href="#step-ident">
                                <span class="step_no">'.$stepCount.'</span>
                                <span class="step_descr">Identification</span>
                              </a>
                            </li>';

                            $stepCount++;

                        }


                        $multi = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$_SESSION['id']."' AND tblquestion.tFormat='Multiple' AND tblquestion.question_id=tblanswer.question_id ORDER BY RAND()");

                        $multiCount = mysqli_num_rows($multi);

                        if ($multiCount != 0) {

                          $html .='<li>
                              <a href="#step-multi">
                                <span class="step_no">'.$stepCount.'</span>
                                <span class="step_descr">Multiple Choice</span>
                              </a>
                            </li>';

                            $stepCount++;

                        }

                        $match = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$_SESSION['id']."' AND tblquestion.tFormat='Matching' AND tblquestion.question_id=tblanswer.question_id ORDER BY RAND()");

                        $matchCount = mysqli_num_rows($match);

                        if ($matchCount != 0) {

                          $html .='<li>
                              <a href="#step-match">
                                <span class="step_no">'.$stepCount.'</span>
                                <span class="step_descr">Matching Type</span>
                              </a>
                            </li>';

                            $stepCount++;

                        }

                        $essay = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$_SESSION['id']."' AND tblquestion.tFormat='Essay' AND tblquestion.question_id=tblanswer.question_id ORDER BY RAND()");

                        $essayCount = mysqli_num_rows($essay);

                        if ($essayCount != 0) {

                          $html .='<li>
                              <a href="#step-essay">
                                <span class="step_no">'.$stepCount.'</span>
                                <span class="step_descr">Essay</span>
                              </a>
                            </li>';

                            $stepCount++;

                        }


                        $html .='</ul>';


                        // start of identification

                        if ($identCount != 0) {

                          $html .='<div id="step-ident">';



                          while ($identRow = mysqli_fetch_array($ident)) {


                               $html .= ' <hr />
                                <h4>'.$currentItem.'. '.$identRow['question'].' <img src="images/loadgif.gif" id="gif'.$identRow['answer_id'].'" style="display:none;" width="15" height="15" /></h4>

                                <input type="text" onblur="saveIdent('.$identRow['answer_id'].');" value="'.$identRow['student_answered'].'" id="'.$identRow['answer_id'].'" placeholder="Input answer here">';


                               $currentItem++; 


                          }



                          $stepFinish++;

                          if ($stepFinish == $stepCount) {

                            $html .='<div class="clearfix"></div>

                                     <br />

                                    <button type="button" onclick="finishTest();" hidden class="btn btn-success pull-right btn-lg">Finish Test</button>';

                          }


                          $html .='</div>';




                        }

                        // end of identification

                        // start of multiple choice


                        if ($multiCount != 0) {

                          $currentItem = 1;


                          $html .='<div id="step-multi">';



                          while ($multiRow = mysqli_fetch_array($multi)) {

                              $html .= ' <hr />
                                <h4>'.$currentItem.'. '.$multiRow['question'].' <img src="images/loadgif.gif" id="gif'.$multiRow['answer_id'].'" style="display:none;" width="15" height="15" /></h4>';

                              
                               $a = array();


                               $a[0] = $multiRow['correct_ans'];
                               $a[1] = $multiRow['f_dummy'];
                               $a[2] = $multiRow['s_dummy'];
                               $a[3] = $multiRow['t_dummy'];


                                shuffle($a);

                                for($i = 0; $i < count($a); $i++) {

                                  if ($multiRow['student_answered'] == $a[$i]) {


                                      $html .='<div class="radio">
                                        <label>
                                          <input type="radio" class="flat" onclick="saveAns('.$multiRow['answer_id'].');" name="'.$multiRow['answer_id'].'" value="'.$a[$i].'" checked> '.$a[$i].'
                                        </label>
                                      </div>';

                                  } else {

                                     $html .='<div class="radio">
                                        <label>
                                          <input type="radio" class="flat" onclick="saveAns('.$multiRow['answer_id'].');"  name="'.$multiRow['answer_id'].'" value="'.$a[$i].'" > '.$a[$i].'
                                        </label>
                                      </div>';


                                  }


                                }

                              $currentItem++;


                          }



                          $stepFinish++;

                          if ($stepFinish == $stepCount) {

                            $html .='<div class="clearfix"></div>

                                     <br />

                                    <button type="button" onclick="finishTest();" hidden class="btn btn-success pull-right btn-lg">Finish Test</button>';

                          }


                          $html .='</div>';



                        }

                        // end of multiple choice

                        // start of matching count


                        if ($matchCount != 0) {

                          $currentItem = 1;
                          $letters = range('A', 'Z');

                          $l = 0;

                          $matchAnswers = array();
                          $matchQuestions = array();
                          $studentAnswered = array();
                          $answerID = array();

                          $html .='<div id="step-match">';



                          while ($matchRow = mysqli_fetch_array($match)) {

                              
                              

                        
                              $matchAnswers[$l] = $matchRow['correct_ans'];
                              $matchQuestions[$l] = $matchRow['question'];
                              $studentAnswered[$l] = $matchRow['student_answered'];
                              $answerID[$l] = $matchRow['answer_id'];

                              $l++;
                                
                            


                              $currentItem++;


                          }

                          $html .='<hr />

                            <h3>List of Questions</h3>';

                            shuffle($matchAnswers);

                            for($l = 0; $l < count($matchQuestions); $l++) {

                                $html .='<h4>
                                <select id="'.$answerID[$l].'" onchange="saveMatch('.$answerID[$l].');">
                                <option value=""></option>';

                                for($a = 0; $a < count($matchAnswers); $a++) {


                                    if ($matchAnswers[$a] == $studentAnswered[$l]) {

                                      $html .='<option value="'.$matchAnswers[$a].'" selected>'.$letters[$a].'</option>';

                                    } else {

                                      $html .='<option value="'.$matchAnswers[$a].'">'.$letters[$a].'</option>';

                                    }

                                }


                                $html .='</select> '.($l + 1).'. '.$matchQuestions[$l].' <img src="images/loadgif.gif" id="gif'.$answerID[$l].'" style="display:none;" width="15" height="15" />
                                </h4>';



                            }
                            


                            $html .='

                            <hr />

                            <h3>Potential Answers</h3>';

                             for($a = 0; $a < count($matchAnswers); $a++) {


                                    $html .= '<h4>'.$letters[$a].'. '.$matchAnswers[$a].'</h4>';
                                    

                              }



                          $stepFinish++;

                          if ($stepFinish == $stepCount) {

                            $html .='<div class="clearfix"></div>

                                     <br />

                                    <button type="button" onclick="finishTest();" hidden class="btn btn-success pull-right btn-lg">Finish Test</button>';

                          }


                          $html .='</div>';



                        }

                        // end of matching type


                        // start of essay

                        if ($essayCount != 0) {

                          $currentItem = 1;

                          $html .='<div id="step-essay">';



                          while ($essayRow = mysqli_fetch_array($essay)) {


                               $html .= ' <hr />
                                <h4>'.$currentItem.'. '.$essayRow['question'].' <img src="images/loadgif.gif" id="gif'.$essayRow['answer_id'].'" style="display:none;" width="15" height="15" /></h4>

                                <textarea class="form-control" onblur="saveEssay('.$essayRow['answer_id'].');" id="'.$essayRow['answer_id'].'" placeholder="Enter answer here">'.$essayRow['student_answered'].'</textarea>'; 


                               $currentItem++; 


                          }



                          $stepFinish++;

                          if ($stepFinish == $stepCount) {

                            $html .='<div class="clearfix"></div>

                                     <br />

                                    <button type="button" onclick="finishTest();" hidden class="btn btn-success pull-right btn-lg">Finish Test</button>';

                          }


                          $html .='</div>';




                        }

                        // end of essay




                    $html .='</div>
                    <!-- End SmartWizard Content -->

                      

                    </div>

                    <!-- start project-detail sidebar -->
                    <div class="col-md-3 col-sm-3 col-xs-12">

                      <section class="panel">

                        <div class="x_title">
                          <h2>'.$testRow['test_type'].' Description</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                          <h3 class="green"><i class="fa fa-tasks"></i> '.$testRow['test_type'].'</h3>

                          <p>'.$testRow['test_desc'].'</p>
                          <br />

                          <div class="project_detail">

                            <p class="title">Instructor</p>
                            <p>'.$testRow['teacher_fname'].' '.$testRow['teacher_lname'].'</p>
                            <p class="title">Post Started</p>
                            <p>'.timeAgo($testRow['test_datestart']).'</p>
                            <p class="title">Deadline</p>
                            <p>'.date("M d, Y g:i A", strtotime($testRow['test_dateend'])).'</p>';

                            $postFiles = mysqli_query($con, "SELECT * FROM tblpost WHERE custom_id='".$_GET['id']."' AND post_type != 'Activity'");


                                $imgRow = mysqli_fetch_array($postFiles);

                                if ($imgRow['post_files'] == "N/A") {

                                  $html .='No File Attachments';

                                } else {

                                  $html .='Test Attachments';
                                  
                                    $filepath = split(",", $imgRow['post_files']);

                                       for($i = 0; $i < count($filepath); $i++) {

                                         $ext = pathinfo($filepath[$i], PATHINFO_EXTENSION);

                                          if (strtoupper($ext) == "DOC" || strtoupper($ext) == "DOCX") {

                                            $html .='<li>
                                            <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-word-o"></i> '.$filepath[$i].'</a>
                                             </li>';


                                          } else if (strtoupper($ext) == "XLS" || strtoupper($ext) == "XLSX") {

                                             $html .='<li>
                                            <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-excel-o"></i> '.$filepath[$i].'</a>
                                             </li>';

                                          } else if (strtoupper($ext) == "PDF") {

                                             $html .='<li>
                                            <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-pdf-o"></i> '.$filepath[$i].'</a>
                                             </li>';

                                          } else if (strtoupper($ext) == "PPT" || strtoupper($ext) == "PPTX") {

                                             $html .='<li>
                                            <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-powerpoint-o"></i> '.$filepath[$i].'</a>
                                             </li>';

                                          } else if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                                             $html .='<li>
                                            <a href="#" data-toggle="modal" data-target="#img'.$i.'"><i class="fa fa-file-image-o"></i> '.$filepath[$i].'</a>
                                             </li>';


                                          } else {

                                              $html .='<li>
                                            <a href="uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file"></i> '.$filepath[$i].'</a>
                                             </li>';

                                             //$others.='<p><i>'.$filepath[$i].'</i> <small><b><a href="uploaded/'.$filepath[$i].'" target="_blank">Download</a></b></small></p>';

                                          }

                                      }


                                }
                          

                          $html .='</div>

                          
                        </div>

                      </section>

                    </div>
                    <!-- end project-detail sidebar -->

                  </div>
                </div>
              </div>
            </div>



          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">
            <a class="btn btn-info btn-sm" href="#wizard">Move Page Up</a> &nbsp;
            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>';

        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                             $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

         $html .=' <!-- modal for edit profile -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editprofile">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit My Profile</h4>

                        </div>

                        <div class="modal-body">

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofiles" enctype="multipart/form-data">

                       

                            <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            First Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="fname" class="form-control" required value="'.$_SESSION['fname'].'">

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Last Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="lname" class="form-control" required value="'.$_SESSION['lname'].'">

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Upload a photo

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="file" name="upload" accept="image/*" />

                            </div>

                          </div>

                     

                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                          
                             </form>



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal edit profile -->';


    return $html;





}

function grades() {



  include "functions/connect.php";


  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                       <li><a href="?page=myprofile">My Profile</a>

                      </li> 

                      <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>


                       </li> ';



                  }






                $html .='

                  <li><a href=""><i class="fa fa-circle"></i> View Grades</a>

                      </li>

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                          <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                    <li><a href="?page=myprofile">My Profile</a>

                    </li>

                      <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>




                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>




                <li role="presentation" class="dropdown">';







                  $html .='<a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                  

                  </ul>

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>




              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);



        if (!isset($_GET['filter'])) {

          $filter = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");

          $filterRow = mysqli_fetch_array($filter);

          $classperiodID = $filterRow['cp_id'];
          $periodName    = $filterRow['period_name'];
          $periodDesc      = $filterRow['period_desc'];

        } else {

          if ($_GET['filter'] == "overall") {

            $classperiodID = 0;
            $periodName = "Overall";

            $filter = mysqli_query($con, "SELECT * FROM tblsection WHERE section_id='".$_GET['id']."' AND section_status='Active'");

            $filterRow = mysqli_fetch_array($filter);

            $periodDesc = "Overall period grades.";

          } else {

            $filter = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['filter']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");

            $filterRow = mysqli_fetch_array($filter);

            $classperiodID = $filterRow['cp_id'];
            $periodName    = $filterRow['period_name'];
            $periodDesc      = $filterRow['period_desc'];

          }


        }

        $teacher = mysqli_query($con, "SELECT * FROM tblsection,tblteacher WHERE tblsection.section_id='".$_GET['id']."' AND tblteacher.teacher_id=tblsection.teacher_id");

        $teacherRow = mysqli_fetch_array($teacher);
       




        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

             <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>My Grades</h2>
                   
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="col-md-9 col-sm-9 col-xs-12">

                      <ul class="stats-overview">
                        <li>
                          <span class="name"> Class Section </span>
                          <span class="value text-success"> '.strtoupper($filterRow['section_name']). ' - '.strtoupper($filterRow['section_desc']).'</span>
                        </li>
                        <li>
                          <span class="name"> Section Code </span>
                          <span class="value text-success"> '.strtoupper($filterRow['section_code']).' </span>
                        </li>
                        <li class="hidden-phone">
                          <span class="name"> Instructor </span>
                          <span class="value text-success"> '.strtoupper($teacherRow['teacher_fname'].' '.$teacherRow['teacher_lname']).' </span>
                        </li>
                      </ul>
                      <br />

                     
                     
                       <h3><u>'.strtoupper($periodName).' GRADE</u></h3>
                       <br />';

                    
                        if ($classperiodID != 0) {



                            $students = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$_GET['id']."'");

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

                                        $avgActivity = $avgActivity * $filterRow['grade_activity'];

                                        $avgActivity = round($avgActivity, 0);

                                        }

                                        //  get percentage of quiz

                                        if ($totalQuizzes != 0) {

                                        $avgQuiz = ($quizScore / $totalQuizzes);

                                        $avgQuiz = $avgQuiz * $filterRow['grade_quiz'];

                                        $avgQuiz = round($avgQuiz, 0);

                                        }

                                        // get percentage of exam

                                        if ($totalExams != 0) {

                                        $avgExam = ($examScore / $totalExams);

                                        $avgExam = $avgExam * $filterRow['grade_exam'];

                                        $avgExam = round($avgExam, 0);

                                        }

                                        // total period grade


                                            $periodGrade = $avgActivity + $avgQuiz + $avgExam;
                                         
                                            $checkGrade = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='".$classperiodID."' AND student_id='".$studentsRow['student_id']."'");


                                            $hasGrade = mysqli_num_rows($checkGrade);

                                            if ($hasGrade == 0) {

                                              mysqli_query($con, "INSERT INTO tblgrades VALUES('0','".$studentsRow['student_id']."','".$_GET['id']."','".$classperiodID."','".$avgActivity."','".$avgQuiz."','".$avgExam."','".$periodGrade."')");


                                            } else {

                                              $studentGrade = mysqli_fetch_array($checkGrade);

                                              mysqli_query($con, "UPDATE tblgrades SET activity_grade='".$avgActivity."',quiz_grade='".$avgQuiz."',exam_grade='".$avgExam."',total_grade='".$periodGrade."' WHERE grade_id='".$studentGrade['grade_id']."'");


                                            }

                                    }




                              }





                      } else {


                        $check = mysqli_query($con, "SELECT sum(period_grade) as total FROM tblclassperiod WHERE section_id='".$_GET['id']."'");

                        $checkRow = mysqli_fetch_array($check);

                        if ($checkRow['total'] == 100) {




                          $students = mysqli_query($con, "SELECT * FROM tblclass,tblstudent WHERE tblclass.section_id='".$_GET['id']."' AND tblstudent.student_id=tblclass.student_id");

                          while($studentsRow = mysqli_fetch_array($students)) {

                              $overAllScore = 0;
                              $overAllGrade = 0;
                              $overAllPercentage = 100 - $teacherRow['teacher_basegrade'];


                              $g = mysqli_query($con, "SELECT * FROM tblgrades,tblclassperiod WHERE tblgrades.section_id='".$_GET['id']."' AND tblgrades.student_id='".$studentsRow['student_id']."' AND tblclassperiod.cp_id=tblgrades.cp_id ORDER BY tblgrades.cp_id ASC");

                              while($gRow = mysqli_fetch_array($g)) {


                                $overAllScore += ($gRow['total_grade'] / 100) * $gRow['period_grade'];


                              }


                              $overAllScore = ($overAllScore / 100) * $overAllPercentage;

                              $overAllGrade = round($overAllScore, 0);


                              $og = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='0' AND student_id='".$studentsRow['student_id']."' AND section_id='".$_GET['id']."'");

                              $ogCount = mysqli_num_rows($og);


                              if ($ogCount == 0) {

                                mysqli_query($con, "INSERT INTO tblgrades VALUES('0','".$studentsRow['student_id']."','".$_GET['id']."','0','0','0','0','".$overAllGrade."')");


                              } else {

                                $ogRow = mysqli_fetch_array($og);

                                     mysqli_query($con, "UPDATE tblgrades SET total_grade='".$overAllGrade."' WHERE grade_id='".$ogRow['grade_id']."'");


                              }




                            }











                        }


                      }


                      if ($classperiodID == 0) {






                            $periods = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                              while($periodsRow = mysqli_fetch_array($periods)) {


                                  $post = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$periodsRow['cp_id']."' AND post_type != 'Post'");

                                  $postCount = mysqli_num_rows($post);

                                  $html .='<h4><u>'.strtoupper($periodsRow['period_name']).' PERIOD</u></h4>';

                                  if ($postCount == 0) {


                                    $html .='No activities, quizzes and exams available

                                    <hr />';



                                  } else {



                                $html .='
                                 <table class="table table-striped dt-responsive nowrap table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                          <tr>
                                            <th width="10%">#</th>
                                            <th>Name</th>
                                            <th>Act '.$periodsRow['grade_activity'].'%</th>
                                            <th>Quiz '.$periodsRow['grade_quiz'].'%</th>
                                            <th>Exam '.$periodsRow['grade_exam'].'%</th>
                                            <th><center>'.strtoupper($periodsRow['period_name']).' GRADE</center></th>
                                          </tr>
                                        </thead>

                                        <tbody>';


                                        $pScore = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='".$periodsRow['cp_id']."' AND student_id='".$_SESSION['id']."'");

                                        $pScoreRow = mysqli_fetch_array($pScore);


                                    
                                          $html .='

                                            <tr>
                                            <td width="10%"><center><img src="'.$_SESSION['picpath'].'" width="30" height="30"></center></td>
                                            <td>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</td>
                                            <td>'.$pScoreRow['activity_grade'].'</td>
                                            <td>'.$pScoreRow['quiz_grade'].'</td>
                                            <td>'.$pScoreRow['exam_grade'].'</td>
                                            <td width="30%"><div class="progress">
                                                  <div class="progress-bar progress-bar-info" data-transitiongoal="'.$pScoreRow['total_grade'].'">'.$pScoreRow['total_grade'].'%</div>
                                                </div></td>
                                           </tr>';


                                        


                                        $html .='</tbody>
                                        </table>


                                        '.strtoupper($gradesRow['student_fname']).' '.strtoupper($periodsRow['period_name']).' GRADE : '.$pScoreRow['total_grade'].' <br />
                                        '.strtoupper($periodsRow['period_name']).' % EQUIVALENT : '.$periodsRow['period_grade'].' <br />
                                        GET '.$periodsRow['period_grade'].'% of '.strtoupper($periodsRow['period_name']).' GRADE: : ('.$pScoreRow['total_grade'].' / 100) X '.$periodsRow['period_grade'].' <br />

                                        <h4>'.ucfirst($periodsRow['period_name']).' Grade ('.$periodsRow['period_grade'].'%) : <b>'.round((($pScoreRow['total_grade'] / 100) * $periodsRow['period_grade']), 1).'</b></h4>




                                        <hr />';





                                  }




                              }


                              $html .='<h4><u>OVERALL PERIOD GRADE</u></h4>


                              BASE GRADE :'.$teacherRow['teacher_basegrade'].'% <br />
                              OVERALL PERIOD % EQUIVALENT : 100% <br />
                             OVERALL GRADE : ( (SUM OF ALL PERIOD GRADES / 100) X OVERALL PERIOD % EQUIVALENT ) <i>See Below;</i> <br />

                              ( (';

                              $oScore = mysqli_query($con, "SELECT * FROM tblgrades,tblclassperiod WHERE tblgrades.section_id='".$_GET['id']."' AND tblgrades.student_id='".$_SESSION['id']."' AND tblclassperiod.cp_id=tblgrades.cp_id ORDER BY tblgrades.cp_id ASC");

                             $totalPG = 0;
                          $oScoreCount = mysqli_num_rows($oScore);
                          $o = 0;

                          while($oScoreRow = mysqli_fetch_array($oScore)) {


                            $totalPG += round(($oScoreRow['total_grade'] / 100) * $oScoreRow['period_grade'],1);

                            $html .= round(($oScoreRow['total_grade'] / 100) * $oScoreRow['period_grade'],1);

                            if (($o + 1) == $oScoreCount) {


                            } else {

                              $html .=' + ';
                            }

                            $o += 1;

                          }

                          // $html .=' / 100 ) X '.(100 - $_SESSION['basegrade']).' ) + '.$_SESSION['basegrade'] .' <br />

                          // <h3>OVERALL GRADE : <b>'.round(( ( ($totalPG / 100) * (100 - $_SESSION['basegrade']) ) + $_SESSION['basegrade'] ),0).'%</b></h3>';

                          $html .=' / 100 ) X 100% <br />

                           <h3>OVERALL GRADE : <b>'.round( ( ($totalPG / 100) * 100),1).'%</b></h3>';



                            } else {


                              // start of activity

                              $activity = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$classperiodID."' AND tblpost.post_type='Activity' AND tblactivity.activity_id=tblpost.custom_id");

                              $activityCount = mysqli_num_rows($activity);

                              $html .= '<h4><u>Activities</u></h4>';

                              $myActivityScore = 0;

                              $totalActivityScore = 0;


                              if ($activityCount == 0) {

                                $html .='No activities available';


                              } else {

                                $html .='

                                  <table class="table table-bordered table-striped">

                                    <thead>
                                      <tr>
                                        <th width="10%">#</th>
                                        <th>Name</th>
                                        <th>Activity Span</th>
                                        <th>Submission</th>
                                        <th>Score</th>
                                        <!-- <th>Action</th> -->
                                      </tr>
                                    </thead>

                                    <tbody>';

                                while($activityRow = mysqli_fetch_array($activity)) {


                                  $submit = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$activityRow['activity_id']."' AND student_id='".$_SESSION['id']."'");

                                  $submitCount = mysqli_num_rows($submit);

                                  $totalActivityScore += 100;

                                  if ($submitCount == 0) {

                                    $submitDate = "Didn't Submit";

                                    $submitScore = 0;

                                  } else {

                                    $submitRow = mysqli_fetch_array($submit);

                                    $submitDate = "Submitted at ".date("M d, Y g:i A", strtotime($submitRow['submit_datetime']));

                                    $submitScore = $submitRow['submit_grade'];

                                    $myActivityScore += $submitScore;

                                  }

                                  $html .='

                                    <tr>
                                      <td width="10%">'.$activityRow['activity_id'].'</td>
                                      <td>'.$activityRow['activity_name'].'</td>
                                      <td>'.date("M d, Y", strtotime($activityRow['activity_datestart'])).' - '.date("M d, Y", strtotime($activityRow['activity_dateend'])).'</td>
                                      <td>'.$submitDate.'</td>
                                      <td>'.$submitScore.' / 100</td>
                                      <!-- <td><a href="?page=viewgrade&id='.$activityRow['activity_id'].'" class="btn btn-info btn-sm"><i class="fa fa-arrow-circle-right"></i> View</a></td> -->
                                    </tr>';





                                }


                                $prgActivity = $myActivityScore / $totalActivityScore;

                                $fnActivity = $prgActivity * $filterRow['grade_activity'];

                                $fnActivity = round($fnActivity, 0);

                                  $html .='</tbody>

                                        </table>

                                My Total Activity Score : '.$myActivityScore.' <br />
                                Total Activity Item Score : '.$totalActivityScore.' <br />
                                <b>Get Activity Score</b> : My Total Activity Score / Total Activity Item Score ; '.$myActivityScore.' / '.$totalActivityScore.' = '.round($prgActivity,1).' <br />
                                Activity Percentage : <b>Get Activity Score</b> / Activity (%) ; '.round($prgActivity,1).' X '.$filterRow['grade_activity'].' = <b>'.$fnActivity.'</b> <br />

                                <h4>Activity ('.$filterRow['grade_activity'].'%) Grade : <b>'.$fnActivity.'</b></h4>';


                              }

                              // end of activity

                              $html .='<hr />';

                              // start of quizzes

                              $quiz = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$classperiodID."' AND tblpost.post_type='Quiz' AND tbltest.test_id=tblpost.custom_id");

                              $quizCount = mysqli_num_rows($quiz);

                              $html .= '<h4><u>Quizzes</u></h4>';

                              $myQuizScore = 0;

                              $totalQuizScore = 0;


                              if ($quizCount == 0) {

                                $html .='No quizzes available';


                              } else {

                                $html .='

                                  <table class="table table-bordered table-striped">

                                    <thead>
                                      <tr>
                                        <th width="10%">#</th>
                                        <th>Name</th>
                                        <th>Quiz Span</th>
                                        <th>Points</th>
                                        <th>Total Items</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                while($quizRow = mysqli_fetch_array($quiz)) {


                                  $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$quizRow['test_id']."' AND student_id='".$_SESSION['id']."'");

                                  $takenCount = mysqli_num_rows($taken);

                      

                                  if ($takenCount == 0) {

                                    $myQuizScore += 0;

                                    $takenScore = 0;

                                  } else {

                                    $takenRow = mysqli_fetch_array($taken);

                                    $takenScore = $takenRow['result_grade'];

                                    $myQuizScore += $takenScore;

                                  }

                                  $totalP = mysqli_query($con, "SELECT sum(points) as total FROM tblquestion WHERE test_id='".$quizRow['test_id']."'");

                                  $totalPRow = mysqli_fetch_array($totalP);

                                  $totalQ = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$quizRow['test_id']."'");

                                  $totalQCount = mysqli_num_rows($totalQ);

                                  $totalQuizScore += $totalPRow['total'];

                                  $html .='

                                    <tr>
                                      <td width="10%">'.$quizRow['test_id'].'</td>
                                      <td>'.$quizRow['test_name'].'</td>
                                      <td>'.date("M d, Y", strtotime($quizRow['test_datestart'])).' - '.date("M d, Y", strtotime($quizRow['test_dateend'])).'</td>
                                      <td>'.$takenScore.' / '.$totalPRow['total'].'</td>
                                      <td>'.$totalQCount.'</td>
                                      <td><a href="?page=viewtest&id='.$quizRow['test_id'].'" class="btn btn-info btn-sm"><i class="fa fa-arrow-circle-right"></i> View</a></td>
                                    </tr>';





                                }


                                $prgQuiz = $myQuizScore / $totalQuizScore;

                                $fnQuiz = $prgQuiz * $filterRow['grade_quiz'];

                                $fnQuiz = round($fnQuiz, 0);

                                  $html .='</tbody>

                                        </table>

                                '.$gradesRow['student_fname'].' Total Quiz Points : '.$myQuizScore.' <br />
                                Total Quiz Item Points : '.$totalQuizScore.' <br />
                                <b>Get Quiz Score</b> : '.$gradesRow['student_fname'].' Total Quiz Points / Total Quiz Item Points ; '.$myQuizScore.' / '.$totalQuizScore.' = '.round($prgQuiz,1).' <br />
                                Quiz Percentage : <b>Get Quiz Score</b> / Quiz (%) ; '.round($prgQuiz,1).' X '.$filterRow['grade_quiz'].' = <b>'.$fnQuiz.'</b> <br />

                                <h4>Quiz ('.$filterRow['grade_quiz'].'%) Grade : <b>'.$fnQuiz.'</b></h4>';

                              }

                               // end of quizzes

                              $html .='<hr />';

                              // start of exam


                              $exam = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$classperiodID."' AND tblpost.post_type='Exam' AND tbltest.test_id=tblpost.custom_id");

                              $examCount = mysqli_num_rows($exam);

                              $html .= '<h4><u>Exam</u></h4>';

                              $myExamScore = 0;

                              $totalExamScore = 0;


                              if ($examCount == 0) {

                                $html .='No exam available';


                              } else {

                                $html .='

                                  <table class="table table-bordered table-striped">

                                    <thead>
                                      <tr>
                                        <th width="10%">#</th>
                                        <th>Name</th>
                                        <th>Exam Span</th>
                                        <th>Points</th>
                                        <th>Total Items</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                while($examRow = mysqli_fetch_array($exam)) {


                                  $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$examRow['test_id']."' AND student_id='".$_SESSION['id']."'");

                                  $takenCount = mysqli_num_rows($taken);

                      

                                  if ($takenCount == 0) {

                                    $myExamScore += 0;

                                    $examScore = 0;

                                  } else {

                                    $takenRow = mysqli_fetch_array($taken);

                                    $takenScore = $takenRow['result_grade'];

                                    $myExamScore += $takenScore;

                                  }

                                  $totalP = mysqli_query($con, "SELECT sum(points) as total FROM tblquestion WHERE test_id='".$examRow['test_id']."'");

                                  $totalPRow = mysqli_fetch_array($totalP);

                                  $totalE = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$examRow['test_id']."'");

                                  $totalECount = mysqli_num_rows($totalE);

                                  $totalExamScore += $totalPRow['total'];

                                  $html .='

                                    <tr>
                                      <td width="10%">'.$examRow['test_id'].'</td>
                                      <td>'.$examRow['test_name'].'</td>
                                      <td>'.date("M d, Y", strtotime($examRow['test_datestart'])).' - '.date("M d, Y", strtotime($examRow['test_dateend'])).'</td>
                                      <td>'.$takenScore.' / '.$totalPRow['total'].'</td>
                                      <td>'.$totalECount.'</td>
                                      <td><a href="?page=viewtest&id='.$examRow['test_id'].'" class="btn btn-info btn-sm"><i class="fa fa-arrow-circle-right"></i> View</a></td>
                                    </tr>';





                                }


                                // $prgExam = $myExamScore / $totalExamScore;

                                // $fnExam = $prgExam * $filterRow['grade_exam'];

                                // $fnExam = round($fnExam, 0);

                                //   $html .='</tbody>

                                //         </table>

                                // My Total Exam Points : '.$myExamScore.' <br />
                                // Total Exam Item Points : '.$totalExamScore.' <br />
                                // <b>Get Exam Score</b> : My Total Exam Points / Total Exam Item Points ; '.$myExamScore.' / '.$totalExamScore.' = '.round($prgExam,1).' <br />
                                // Exam Percentage : <b>Get Exam Score</b> / Exam (%) ; '.round($prgExam,1).' X '.$filterRow['grade_exam'].' = <b>'.$fnExam.'</b> <br />

                                // <h4>Exam ('.$filterRow['grade_exam'].'%) Grade : <b>'.$fnExam.'</b></h4>';

                                  $prgExam = $myExamScore / $totalExamScore;

                                $fnExam = $prgExam * $filterRow['grade_exam'];

                                $fnExam = round($fnExam, 0);

                                  $html .='</tbody>

                                        </table>

                                '.$gradesRow['student_fname'].' Total Exam Points : '.$myExamScore.' <br />
                                Total Exam Item Points : '.$totalExamScore.' <br />
                                <b>Get Exam Score</b> : '.$gradesRow['student_fname'].' Total Exam Points / Total Exam Item Points ; '.$myExamScore.' / '.$totalExamScore.' = '.round($prgExam,1).' <br />
                                Exam Percentage : <b>Get Exam Score</b> / Exam (%) ; '.round($prgExam,1).' X '.$filterRow['grade_exam'].' = <b>'.$fnExam.'</b> <br />

                                <h4>Exam ('.$filterRow['grade_exam'].'%) Grade : <b>'.$fnExam.'</b></h4>';



                              }

                              $html .= '<h3>MY '.strtoupper($periodName).' GRADE : <b>'.($fnActivity + $fnQuiz + $fnExam).'%</b></h3>';

                               // end of exam



                            }

                    
                    $html .='</div>

                    <!-- start project-detail sidebar -->
                    <div class="col-md-3 col-sm-3 col-xs-12">

                      <section class="panel">

                        <div class="x_title">
                          <h2>Grades Information</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                          <h3 class="green"><i class="fa fa-tasks"></i> '.strtoupper($periodName).'</h3>

                          <p>'.$periodDesc.'</p>
                          <br />

                          <div class="project_detail">


                          <p class="title">Selected Period</p>
                          <p><select id="cperiod" required="required" name="cperiod" onchange="selectPeriod();" class="form-control">';


                          $cp = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                          while($cpRow = mysqli_fetch_array($cp)) {


                            if ($classperiodID == $cpRow['cp_id']) {

                              $html .='<option value="'.$cpRow['cp_id'].'" selected>'.strtoupper($cpRow['period_name']).'</option>';
                            } else {


                              $html .='<option value="'.$cpRow['cp_id'].'">'.strtoupper($cpRow['period_name']).'</option>';
                            }





                          }

                            if ($classperiodID == 0) {


                              $html .='<option value="0" selected>OVERALL PERIOD</option>';

                            } else {

                               $html .='<option value="0">OVERALL PERIOD</option>';
                            }
                            

                          $html .='</select></p>';

                          if ($classperiodID != 0) {


                          $html .='<p class="title">Activity %</p>
                          <p>'.$filterRow['grade_activity'].'</p>
                          <p class="title">Quiz %</p>
                          <p>'.$filterRow['grade_quiz'].'</p>
                          <p class="title">Exam %</p>
                          <p>'.$filterRow['grade_exam'].'</p>';


                          } else {


                            $list = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblclassperiod.cp_id ASC");

                            $p = 0;

                            while($listRow = mysqli_fetch_array($list)) {

                                $html .='<p class="title">'.ucfirst($listRow['period_name']).' %</p>
                                <p>'.$listRow['period_grade'].'</p>';

                             

                            }

                            $html .=' <br />

                            <!-- <p class="title">Base Grade</p>
                            <p>'.$teacherRow['teacher_basegrade'].'</p> -->';


                          }


                            $html .=' 
                          </div>

                        </div>

                      </section>

                    </div>
                    <!-- end project-detail sidebar -->

                  </div>
                </div>
              </div>
            </div>

            







          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>';

        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");


                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

         $html .=' <!-- modal for edit profile -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editprofile">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit My Profile</h4>

                        </div>

                        <div class="modal-body">

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofiles" enctype="multipart/form-data">

                       

                            <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            First Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="fname" class="form-control" required value="'.$_SESSION['fname'].'">

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Last Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="lname" class="form-control" required value="'.$_SESSION['lname'].'">

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Upload a photo

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="file" name="upload" accept="image/*" />

                            </div>

                          </div>

                     

                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                          
                             </form>



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal edit profile -->';



    return $html;





}

function students() {



  include "functions/connect.php";

  

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                       <li><a href="?page=myprofile">My Profile</a> 

                      </li> 

                      <li><a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>

                       </li>';



                  }






                $html .='

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                        <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                     <li><a href="?page=myprofile">My Profile</a>

                    </li>

                     <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>




                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>




                <li role="presentation" class="dropdown">';







                  $html .=' <a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>


              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);
   
        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE section_id='".$_GET['id']."'");

        $sectionRow = mysqli_fetch_array($res);

        $stud = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$_GET['id']."'");

        $studCount = mysqli_num_rows($stud);


        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

                 <div class="row">

               <div class="col-md-12 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    

                    <h2>'.$sectionRow['section_name'].' - '.$sectionRow['section_desc'].' Students</h2>

                    

                    <div class="clearfix"></div>

                  </div> <!-- x_title -->

                      <div class="x_content">


                          <h3>Section Code : <b>'.$sectionRow['section_code'].'</b></h3>
                            <small>Copy the code at the top and share it to your students.</small>

                            <br />
                            <br />

                      <p><b>Total Students :</b> '.$studCount.'</p>

                      <hr />

                      <h2> List of Students </h3>

                       <table class="table table-striped table-bordered" width="100%" id="studentstable">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Picture</th>
                                        <th>Name</th>
                                        <th>Date Joined</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                    $join = mysqli_query($con, "SELECT * FROM tblclass,tblstudent WHERE tblclass.section_id='".$_GET['id']."' AND tblstudent.student_id=tblclass.student_id ORDER BY tblstudent.student_lname ASC");

                                    

                                    while($joinedRow = mysqli_fetch_array($join)) {

                                       $html .='

                                      <tr>
                                      <th scope="row">'.$joinedRow['student_num'].'</th>
                                      <td><img src="'.$joinedRow['student_picpath'].'" width="30" height="30"></td>';

                                      if ($joinedRow['class_status'] == "Class President") {

                                                $html .='<td>'.$joinedRow['student_fname'].' '.$joinedRow['student_lname'].' <i class="fa fa-check-circle-o"></i></td>';

                                        } else {

                                                $html .='<td>'.$joinedRow['student_fname'].' '.$joinedRow['student_lname'].'</td>';
                                        }


                                      
                                      
                                      $html .='<td>'.timeAgo($joinedRow['class_datejoined']).'</td>';

                                                if ($joinedRow['student_id'] == $_SESSION['id']) {

                                                     $html .='     <td><a href="?page=myprofile" class="btn btn-success">My Profile</a></td>';

                                                } else {

                                                    $html .='     <td><a href="?page=viewstudent&id='.$joinedRow['student_id'].'" class="btn btn-success">View Profile</a></td>';
                                                }

                                          

                                              $html .='</tr>';


                                    }

                                    $html .='
                                    </tbody>
                                  </table>



                      </div>




                </div> <!-- x_panel-->

              </div> <!-- col -->

            </div> <!-- row -->

          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>';

        $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';


    return $html;





}

function timeline() {



  include "functions/connect.php";

  

  $html =' <div class="container body">

      <div class="main_container">

        <div class="col-md-3 left_col">

          <div class="left_col scroll-view">

            <div class="navbar nav_title" style="border: 0;">

              <a href="teacher.php" class="site_title"><i class="fa fa-pencil"></i> <span>EDSON</span></a>

            </div>



            <div class="clearfix"></div>



            <!-- menu profile quick info -->

            <div class="profile">

              <div class="profile_pic">

                <img src="'.$_SESSION['picpath'].'" alt="..." class="img-circle profile_img">

              </div>

              <div class="profile_info">

                <span>Welcome, Student</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Student</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="student.php">Dashboard</a>

                    </li>

                      <!-- <li><a href="?page=myprofile">My Profile</a> 

                      </li> -->

                    </ul>

                  </li>';


              
                  $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");



                  while($row = mysqli_fetch_array($res)) {



                       $html .='



                       <li><a><i class="fa fa-edit"></i>'.$row['section_name'].' - '.$row['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                        <ul class="nav child_menu">';





                        $res1 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                            
                        while($row1 = mysqli_fetch_array($res1)) {


                               $html .='<li><a href="?page=classperiod&id='.$row1['cp_id'].'">'.$row1['period_name'].'</a>
                                </li>';


                        }





                     

                    

                     $html .='</ul>

                       </li>';



                  }






                $html .='

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblclass,tblsection WHERE tblclass.student_id='".$_SESSION['id']."' AND tblsection.section_id=tblclass.section_id AND tblsection.section_status='Active'");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_name'];


                            } else {

                                if ($newName == $row['section_name']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_name'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-windows"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $res2 = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$row1['section_id']."' AND student_id='".$_SESSION['id']."'");

                        $hasRows = mysqli_num_rows($res2);

                          if ($hasRows == 1) {

                          $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                       <ul class="nav child_menu">

                                        <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                        </li> 

                                         <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                        </li>

                                        <li><a href="?page=grades&id='.$row1['section_id'].'">My Grades</a>

                                        </li>

                                      </ul>

                                    </li>';


                           }


                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  

                

                $html .='</ul>

              </div>



            </div>

            <!-- /sidebar menu -->



           

          </div>

        </div>



        <!-- top navigation -->

        <div class="top_nav">



          <div class="nav_menu">

            <nav class="" role="navigation">

              <div class="nav toggle">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <img src="'.$_SESSION['picpath'].'" alt="">'.$_SESSION['fname'].' '.$_SESSION['lname'].'

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                     <li><a href="?page=myprofile">My Profile</a>

                    </li>

                     <li> <a href="#" data-toggle="modal" data-target="#editprofile">Edit Profile</a></li>

                    <li>';

                    
                    if ($_SESSION['login'] == "Google") {
                      

                     $html .=" <a class='logout' href='javascript:void(0);'><i class='icon icon-signout'></i> Logout</a>";

                   } else {

                    $html .= '<a class="logout" href="#" onclick="FBLogout();"><i class="icon icon-signout"></i> Logout</a>';

                   }


                    $html .='</li>

                  </ul>

                </li>




                 <li role="presentation" class="dropdown">

                     <a href="javascript:;" id="myNotif" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-globe"></i>

                    <span class="badge bg-green" id="notifcount"></span>

                  </a>

                  <ul id="notifmsgs" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                 </li>




                <li role="presentation" class="dropdown">';







                  $html .=' <a href="javascript:;" id="myHref" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                    <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green" id="inboxcount"></span>

                  </a>

                  <ul id="conversation" class="dropdown-menu list-unstyled msg_list" role="menu">

                      

                  </ul> 

                </li>

                  <li title="Compose A New Message"><a href="#" data-toggle="modal" data-target="#newmessage"><i class="fa fa-paper-plane"></i></a></li>


              </ul>

            </nav>

          </div>



        </div>

        <!-- /top navigation -->';



        $res = mysqli_query($con, "SELECT * FROM tblclass WHERE student_id='".$_SESSION['id']."'");  

          $countJoin = mysqli_num_rows($res);     

        $res = mysqli_query($con, "SELECT * FROM tblsubmit WHERE student_id='".$_SESSION['id']."'");  

            $countActivities = mysqli_num_rows($res);       

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Quiz' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'");        

          $countQuizzes = mysqli_num_rows($res);        

        $res = mysqli_query($con, "SELECT * FROM tbltest, tbltaken WHERE tbltest.test_type='Exam' AND tbltaken.test_id=tbltest.test_id AND tbltaken.student_id='".$_SESSION['id']."'"); 

        $countExams = mysqli_num_rows($res);
   
        $section = mysqli_query($con, "SELECT * FROM tblsection,tblteacher WHERE tblsection.section_id='".$_GET['id']."' AND tblteacher.teacher_id=tblsection.teacher_id");

        $sectionRow = mysqli_fetch_array($section);

        $classStud = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$_GET['id']."'");

        $classStudCount = mysqli_num_rows($classStud);

        $classPres = mysqli_query($con, "SELECT * FROM tblclass,tblstudent WHERE tblclass.section_id='".$_GET['id']."' AND tblclass.class_status='Class President' AND tblstudent.student_id=tblclass.student_id");

        $hasPresident = mysqli_num_rows($classPres);

        if ($hasPresident == 0) {

          $classPresident = "Not Yet Assigned";


        } else {

          $classPresRow = mysqli_fetch_array($classPres);

          $classPresident = $classPresRow['student_fname'].' '.$classPresRow['student_lname'];
        }


        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-institution" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countJoin.'</div>



                  <h3>Class Joined</h3>

                  <p>Number of class joined</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities passed</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-pencil" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countQuizzes.'</div>



                  <h3>Quizzes</h3>

                  <p>Number of quizzess taken.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red"></i>

                  </div>

                  <div class="count">'.$countExams.'</div>



                  <h3>Exams</h3>

                  <p>Number of exams taken</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <form action="scripts.php?page=search&type=student" method="POST">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                 
                  <div class="input-group">
                   
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                   
                  </div>
                </div>
                 </form>
            </div>

             <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Timeline</h2>
                 
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="col-md-9 col-sm-9 col-xs-12">

                           <div class="x_title">
                                <h2>Section Timeline</h2>
                               
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">


                              <div class="col-lg-4 col-md-4 col-xs-12 col-sm-4">
                                <select id="tperiod" class="form-control" onchange="changeTimeline();">
                                <option value="0" selected>OVERALL TIMELINE</option>';

                                $periods = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblperiod.period_id ASC");

                                while($periodsRow = mysqli_fetch_array($periods)) {

                                  $html .='<option value="'.$periodsRow['cp_id'].'">'.strtoupper($periodsRow['period_name']).' TIMELINE</option>';

                                }

                                $html .='</select>

                              </div>

                              <br /> 

                              <hr />

                                    <label id="sgif" style="display:none;"><img src="images/loadgif.gif" width="30" height="30" /></label>
                            <div id="pt" style="overflow-y:auto; height:400px;">';

                                $cp = mysqli_query($con, "SELECT * FROM tblclassperiod,tblpost,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblpost.cp_id=tblclassperiod.cp_id AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblpost.post_datetime DESC");

                                $cpCount = mysqli_num_rows($cp);

                                if ($cpCount == 0) {

                                  $html .='<h2>No Timeline To Be Shown</h2>';

                                }

                                else {

                                  $html .='<ul class="list-unstyled timeline">';

                                  while($cpRow = mysqli_fetch_array($cp)) {

                                      $editControls = "";


                                           $r = mysqli_query($con, "SELECT * FROM tblreply WHERE post_id='".$cpRow['post_id']."'");



                                        $rCount = mysqli_num_rows($r);




                                        if ($cpRow['user_type'] == "Teacher") {





                                          $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> Posted by <a href="?page=viewteacher&id='.$sectionRow['teacher_id'].'">'.$sectionRow['teacher_fname'].' '.$sectionRow['teacher_lname'].'</a> <i title="Teacher" class="fa fa-check-circle"></i>';



                                        } else {



                                         
                                          $s = mysqli_query($con, "SELECT * FROM tblstudent,tblclass WHERE tblstudent.student_id='".$cpRow['user_id']."' AND tblclass.student_id=tblstudent.student_id AND tblclass.section_id='".$_GET['id']."'");



                                          $sRow = mysqli_fetch_array($s);

                                          if ($sRow['class_status'] == "Class President") {

                                                if ($sRow['student_id'] == $_SESSION['id']) {

                                                    $editControls = ' <ul class="nav navbar-right panel_toolbox">
                                                                              <li><a href="#" data-toggle="modal" onclick="editPost('.$cpRow['post_id'].');" data-target="#editFields"><i class="fa fa-edit"></i></a></li>
                                                                                <li><a onclick="removePost('.$cpRow['post_id'].');"><i class="fa fa-remove" title="Remove Post"></i></a>
                                                                                  </li>
                                                                            </ul>';

                                                  $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> Posted by <a href="?page=myprofile">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="Class President" class="fa fa-check-circle-o"></i>';

                                                } else {

                                                   $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="Class President" class="fa fa-check-circle-o"></i>';
                                                }

                                            


                                          } else {

                                              if ($sRow['student_id'] == $_SESSION['id']) {


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

                                      
                                        if ($testRow['test_status'] == "Unpublished") {

                                          $isDisplay = false;

                                        }


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

                                        $a = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$cpRow['custom_id']."'");

                                        $aRow = mysqli_fetch_array($a);

                                        $postContent = '<h3 class="title">'.$aRow['activity_name'].'</h3>
                                                       '.$headerPost;
                                      }
                                      // end of tag coloring

                                      if ($isDisplay == true) {

                                            $html .='<li>

                                              <div class="block">

                                                <div class="'.$tags.'">

                                                  <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$_GET['id'].'" class="'.$tag.'">

                                                    <span>'.$cpRow['post_type'].'</span>

                                                  </a>

                                                </div>

                                                <div class="block_content">'
                                                .$editControls.'
                                                '.$postContent.'

                                                            
                                                  <div class="byline">

                                                    <span title="Posted at '.date('F d, Y g:i A', strtotime($cpRow['post_datetime'])).'">'.$sectionRow['section_name'].' - '.$sectionRow['section_desc'].' '.timeAgo($cpRow['post_datetime']).'</span>

                                                  </div>';


                                                  if ($cpRow['post_files'] == "N/A") {


                                                    if ($cpRow['post_type'] == "Activity") {

                                                        $actRes = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$cpRow['custom_id']."'");

                                                        $aCount = mysqli_num_rows($actRes);

                                                        $html .=' <p>Submitted('.$aCount.') | <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies('.$rCount.')</a></p>';


                                                    } else {



                                                      if ($cpRow['post_type'] == "Post") {



                                                        $html .=' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies ('.$rCount.')</a></p>';

                                                          } else {

                                                              if ($testRow['test_status'] == "Unpublished") {

                                                                $html .=' <p>Post Status : <b>Unpublished</b></p>';


                                                              } else {

                                                                $html .=' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies ('.$rCount.')</a> | <a href="?page=viewtest&id='.$cpRow['custom_id'].'">View Test</a></p>';

                                                              }


                                                          }


                                                    }


                                                  } else {

                                                     $fc = split(",", $cpRow['post_files']);

                                                     $html .=' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Attachments('.count($fc).') & Replies('.$rCount.')</a></p>';

                                                  }

                                                 

                                                 

                                                $html .='</div>

                                              </div>

                                           </li>';

                                          }



                                      














                            } // end of while

                              $html .=' </ul>';


                        }

                              $html .='
                                  </div>

                              </div>';




                      $students = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$_GET['id']."'");

                          while($studentsRow = mysqli_fetch_array($students)) {

                               

                                    $activityScore = 0;
                                    $quizScore = 0;
                                    $examScore = 0;

                                    $totalActivity = 0;
                                    $totalQuizzes  = 0;
                                    $totalExams = 0;


                                $cp = mysqli_query($con, "SELECT * FROM tblclassperiod WHERE section_id='".$_GET['id']."' ORDER BY cp_id ASC");


                                while($cpRow = mysqli_fetch_array($cp)) { // start of periods



                                    $post = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$cpRow['cp_id']."' AND post_type != 'Post'");

                                    $postCount = mysqli_num_rows($post);

                                    while($postRow = mysqli_fetch_array($post)) { // start of calculations


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


                                    } // end of grade calculations


                                    if ($postCount != 0) { // start of post count

                                        $avgActivity = 0;

                                        $avgQuiz = 0;

                                        $avgExam = 0;

                                        // get percentage of activity

                                        if ($totalActivity != 0) {

                                        $avgActivity = ($activityScore / $totalActivity);

                                        $avgActivity = $avgActivity * $cpRow['grade_activity'];

                                        $avgActivity = round($avgActivity, 0);

                                        }

                                        //  get percentage of quiz

                                        if ($totalQuizzes != 0) {

                                        $avgQuiz = ($quizScore / $totalQuizzes);

                                        $avgQuiz = $avgQuiz * $cpRow['grade_quiz'];

                                        $avgQuiz = round($avgQuiz, 0);

                                        }

                                        // get percentage of exam

                                        if ($totalExams != 0) {

                                        $avgExam = ($examScore / $totalExams);

                                        $avgExam = $avgExam * $cpRow['grade_exam'];

                                        $avgExam = round($avgExam, 0);

                                        }

                                        // total period grade

                                         $periodGrade = $avgActivity + $avgQuiz + $avgExam;
                                       
                                          $checkGrade = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='".$cpRow['cp_id']."' AND student_id='".$studentsRow['student_id']."'");


                                          $hasGrade = mysqli_num_rows($checkGrade);

                                          if ($hasGrade == 0) {

                                            mysqli_query($con, "INSERT INTO tblgrades VALUES('0','".$studentsRow['student_id']."','".$_GET['id']."','".$cpRow['cp_id']."','".$avgActivity."','".$avgQuiz."','".$avgExam."','".$periodGrade."')");


                                          } else {

                                            $studentGrade = mysqli_fetch_array($checkGrade);

                                            mysqli_query($con, "UPDATE tblgrades SET activity_grade='".$avgActivity."',quiz_grade='".$avgQuiz."',exam_grade='".$avgExam."',total_grade='".$periodGrade."' WHERE grade_id='".$studentGrade['grade_id']."'");


                                          }

                                    } // end of post count


                                }



                          }

                     
                            $html .='<div>
                            &nbsp; <br />
                            &nbsp; <br />
                            &nbsp; <br />

                            <h2>Top 5 Students Highest Grade Performance</h2>
                            <hr />

                            <div class="col-lg-4 col-md-4 col-xs-12 col-sm-4">
                                <select id="tgraph" class="form-control" onchange="changeGraph();">';

                                $periods = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblperiod.period_id ASC");

                                while($periodsRow = mysqli_fetch_array($periods)) {

                                  $html .='<option value="'.$periodsRow['cp_id'].'">'.strtoupper($periodsRow['period_name']).' GRADE GRAPH</option>';

                                }

                                $html .='</select>
                            </div>

                                &nbsp; <br />
                                &nbsp; <br />
                                &nbsp; <br />
                                &nbsp; <br />


                              <div id="cg">';

                               $periods = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblperiod.period_id ASC");

                                $p = 0;

                                while($periodsRow = mysqli_fetch_array($periods)) {

                                  $pc = mysqli_query($con, "SELECT * FROM tblgrades WHERE section_id='".$_GET['id']."' AND cp_id='".$periodsRow['cp_id']."'");

                                  $pcCount = mysqli_num_rows($pc);

                                  if ($pcCount != 0) {

                                      if ($p == 0) {

                                         $html .='<canvas id="bar'.$periodsRow['cp_id'].'"></canvas>';

                                         $p = $periodsRow['cp_id'];

                                      } else {

                                         $html .='<canvas id="bar'.$periodsRow['cp_id'].'" style="display:none;"></canvas>';
                                      }

                                  } else {

                                      if ($p == 0) {

                                         $html .='<div id="bar'.$periodsRow['cp_id'].'"><center><h2>No Graph Available</h2></center></div>';

                                         $p = $periodsRow['cp_id'];

                                      } else {

                                         $html .='<div id="bar'.$periodsRow['cp_id'].'" style="display:none;"><center><h2>No Graph Available</h2></div>';
                                      }

                                  }
                               

                                }

                              $html .='

                              <input type="hidden" value="'.$p.'" id="ograph">

                              </div>

                               &nbsp; <br />

                              <center>For further information about how grades are calculated, visit the grade page of your section.</center>

                            </div> <!-- end -->



                    </div>


                     <!-- start project-detail sidebar -->
                    <div class="col-md-3 col-sm-3 col-xs-12">

                      <section class="panel">

                        <div class="x_title">
                          <h2>Section Information</h2>
                          <div class="clearfix"></div>

                        </div>
                        <div class="panel-body">


                          <h3 class="green"><i class="fa fa-comments-o"></i> '.$sectionRow['section_name'].' - '.$sectionRow['section_desc'].'</h3>

                          <p>Section Code : <b>'.$sectionRow['section_code'].'</b></p>
                          <br />

                          <div class="project_detail">

                            <p class="title">Instructor</p>
                            <p>'.$sectionRow['teacher_fname'].' '.$sectionRow['teacher_lname'].'</p>

                            <p class="title">Class President</p>
                            <p>'.$classPresident.'</p>
                            <p class="title">Total Students</p>
                            <p>'.$classStudCount.'</p>
                          </div>

                          <br />
                          <h5>Section Attachments</h5>';

                          $postFiles = mysqli_query($con, "SELECT * FROM tblclassperiod,tblpost WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblpost.cp_id=tblclassperiod.cp_id AND tblpost.post_files != 'N/A' ORDER BY tblpost.post_id DESC");


                          $postFilesCount = mysqli_num_rows($postFiles);

                          if ($postFilesCount == 0) {

                            $html .='No Files Attached.';

                          } else {

                            $html .='<ul class="list-unstyled project_files">';

                            while($postFilesRow = mysqli_fetch_array($postFiles)) {


                                $filepath = split(",", $postFilesRow['post_files']);

                                 for($i = 0; $i < count($filepath); $i++) {

                                   $ext = pathinfo($filepath[$i], PATHINFO_EXTENSION);

                                    if (strtoupper($ext) == "DOC" || strtoupper($ext) == "DOCX") {

                                      $html .='<li>
                                      <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-word-o"></i> '.$filepath[$i].'</a>
                                       </li>';


                                    } else if (strtoupper($ext) == "XLS" || strtoupper($ext) == "XLSX") {

                                       $html .='<li>
                                      <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-excel-o"></i> '.$filepath[$i].'</a>
                                       </li>';

                                    } else if (strtoupper($ext) == "PDF") {

                                       $html .='<li>
                                      <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-pdf-o"></i> '.$filepath[$i].'</a>
                                       </li>';

                                    } else if (strtoupper($ext) == "PPT" || strtoupper($ext) == "PPTX") {

                                       $html .='<li>
                                      <a href="http://docs.google.com/gview?url=esn.itcapstone.com/uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file-powerpoint-o"></i> '.$filepath[$i].'</a>
                                       </li>';

                                    } else if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                                       $html .='<li>
                                      <a href="#" data-toggle="modal" data-target="#img'.$i.'"><i class="fa fa-file-image-o"></i> '.$filepath[$i].'</a>
                                       </li>';


                                    } else {

                                        $html .='<li>
                                      <a href="uploaded/'.$filepath[$i].'" target="_blank"><i class="fa fa-file"></i> '.$filepath[$i].'</a>
                                       </li>';

                                       //$others.='<p><i>'.$filepath[$i].'</i> <small><b><a href="uploaded/'.$filepath[$i].'" target="_blank">Download</a></b></small></p>';

                                    }

                                }


                            }

                            $html .='</ul>';

                          }

                          
                        $html .='</div>

                      </section>

                    </div>
                    <!-- end project-detail sidebar -->

                  </div>
                </div>
              </div>
            </div>


          </div>

        </div>

        <!-- /page content -->



        <!-- footer content -->

        <footer>

          <div class="pull-right">

            <i class="fa fa-pencil"></i> Educational Social Network

          </div>

          <div class="clearfix"></div>

        </footer>

        <!-- /footer content -->

      </div>

    </div>';

        // modal for editing fields

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editFields">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit Fields</h4>

                        </div>

                        <div class="modal-body">

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=updatefields&ref=timeline&id='.$_GET['id'].'" method="POST">


                           <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editore">
                                <div class="btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                  </ul>
                                </div>

                                <div class="btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                  <ul class="dropdown-menu">
                                    <li>
                                      <a data-edit="fontSize 5">
                                        <p style="font-size:17px">Huge</p>
                                      </a>
                                    </li>
                                    <li>
                                      <a data-edit="fontSize 3">
                                        <p style="font-size:14px">Normal</p>
                                      </a>
                                    </li>
                                    <li>
                                      <a data-edit="fontSize 1">
                                        <p style="font-size:11px">Small</p>
                                      </a>
                                    </li>
                                  </ul>
                                </div>

                                <div class="btn-group">
                                  <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                  <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                  <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                  <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                </div>

                                <div class="btn-group">
                                  <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                  <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                  <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                  <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                </div>

                                <div class="btn-group">
                                  <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                  <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                  <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                  <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                </div>

                                <div class="btn-group">
                                  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                  <div class="dropdown-menu input-append">
                                    <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                    <button class="btn" type="button">Add</button>
                                  </div>
                                  <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                </div>


                                <div class="btn-group">
                                  <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                  <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                </div>

                              </div>

                  
                           <div id="editore" onblur="editDesc();" class="editor-wrapper"></div>

                                  <textarea style="display:none;" name="desc" id="editdesc" required="required" placeholder="Enter test description here"></textarea>

                              <br />

                               <div class="form-group" id="txtName">


                                </div>

                                <input type="hidden" name="id" id="postid" value="0">



                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                        </div>

                            </form>

                      </div>

                    </div>

                  </div>';

      // end

                  for($i = 0; $i < count($filepath); $i++) {

                $ext = pathinfo($filepath[$i], PATHINFO_EXTENSION);

                                    if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                                         $html .=' <!-- modal for image-->

                                            <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="img'.$i.'">

                                                          <div class="modal-dialog modal-lg">

                                                            <div class="modal-content">



                                                              <div class="modal-header">

                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                                                                </button>

                                                                <h4 class="modal-title" id="myModalLabel">View Image</h4>

                                                              </div>

                                                              <div class="modal-body">


                                                                   <center>
                                                              <img class="img-responsive" src="uploaded/'.$filepath[$i].'"> <br />
                                                              <i>'.$filepath[$i].'</i>
                                                              </center>

                                                              </div>

                                                              <div class="modal-footer">


                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>



                                                              </div>

                                                               

                                                            </div>

                                                          </div>

                                                        </div>

                                              <!-- end of modal image -->';

                                    }

         }


                $html .=' <!-- modal for notifications -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="showNotif">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Notfications</h4>

                        </div>

                        <div class="modal-body">

                          <button type="button" id="myButton" class="btn btn-primary"><i class="fa fa-repeat"></i> Refresh Details</button>



                          <div id="ndetails">

                              <ul class="list-unstyled msg_list">';

                        $res = mysqli_query($con, "SELECT * FROM tblnotifications WHERE user_id='".$_SESSION['id']."' AND user_type='Student' AND post_type != 'Join' ORDER BY notif_datetime DESC");


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
                        

                      $html .='</ul>




                          </div>




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- Notfications -->';

                 $html .=' <!-- modal for new message-->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newmessage">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Compose A New Message</h4>

                        </div>

                        <div class="modal-body">

                        <center>
                          <form class="form-inline">
                            <div class="form-group">
                              <input type="text" id="searchField" onkeydown="ent(this);" class="form-control" placeholder="Type an email or name of the user">
                            </div>
                            <button type="button" onclick="searchUser();" class="btn btn-default">Search User</button>
                          </form>

                          <br />

                          <h4><u>Users that you may know.</u></h4>

                          <br />

                        <form class="form-inline">
                          <div id="filterusers">';


                          $userCount = 0;

                              $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['student_id']."' AND sender_type='student'");

                                  $c = mysqli_num_rows($res1);

                                 

                                  if ($c == 0) {

                                     $userCount += $c;

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher ORDER BY RAND() LIMIT 5");

                              $max = 0;

                              while($row = mysqli_fetch_array($res)) {


                                  $res1 = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='".$_SESSION['isLogin']."' AND sender_id='".$row['teacher_id']."' AND sender_type='teacher'");

                                  $c = mysqli_num_rows($res1);


                                  if ($c == 0) {


                                  $userCount += $c;

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



                          $html .='</div>

                        </form>

                        </center>

                        <br />

                        <form class="form-horizontal">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <input type="text" id="receiverName" name="name" required="required" readonly placeholder="Select a user at the top" class="form-control col-md-7 col-xs-12">

                              <input type="hidden" id="receiverID">
                              <input type="hidden" id="receiverType">

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Message :

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter your message here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" id="receiverBtn" onclick="composeMsg();">Send</button>

                          <img src="images/loadgif.gif" width="45" height="45" id="receiverGif" style="display:none;" />



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal message -->';

         $html .=' <!-- modal for edit profile -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editprofile">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit My Profile</h4>

                        </div>

                        <div class="modal-body">

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofiles" enctype="multipart/form-data">

                       

                            <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            First Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="fname" class="form-control" required value="'.$_SESSION['fname'].'">

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Last Name

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="text" name="lname" class="form-control" required value="'.$_SESSION['lname'].'">

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                            Upload a photo

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="file" name="upload" accept="image/*" />

                            </div>

                          </div>

                     

                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Update</button>

                          
                             </form>



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal edit profile -->';




    return $html;





}

function timeAgo($time_ago) {

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

?>