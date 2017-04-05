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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                     <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> -->

                     

                    </ul>

                  </li>';



                $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                      <!-- <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




                       }



                      $html .='</ul>

                    </li>';


                    }

                }


            


                $html .='

                </ul>

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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);
   



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>

             <div class="row">
              <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dashboard</h2>
                 
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="col-md-8 col-sm-8 col-xs-12">';


                        if ($_SESSION['getstarted'] == 0) {



                       $html .='<div class="x_panel">

                                  <div class="x_title">

                                    <h2>Getting Started</h2>

                                    

                                    <div class="clearfix"></div>

                                  </div>

                                  <div class="x_content">

                                    <div class="col-md-12 col-sm-12 col-xs-12">

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
                                                              Class & Period<br />
                                                              <small>About class & periods</small>
                                                          </span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#step-3">
                                            <span class="step_no">3</span>
                                            <span class="step_descr">
                                                              Timeline, Activities, Quizzes & Exams<br />
                                                              <small>How to deal with activities</small>
                                                          </span>
                                          </a>
                                        </li>
                                        <li>
                                          <a href="#step-4">
                                            <span class="step_no">4</span>
                                            <span class="step_descr">
                                                              Grades & Performance<br />
                                                              <small>Learn how grades work</small>
                                                          </span>
                                          </a>
                                        </li>
                                      </ul>
                                      <div id="step-1">
                                         <h2 class="StepTitle">Hello Teacher '.$_SESSION['fname'].'</h2>
                                        <p>
                                           Welcome to <b>Educational Social Network</b>, this website will be your aid in managing your class. As long you are connected via internet, you can able to interact with your students even at home, vacation or in a conference meeting. This website application is intended for both teacher and students, those students who are joined in a class will able to received notifications whenever there are new updates such as <i>announcements, activities, quizzes and exams.</i>
                                        </p>
                                        <p>
                                          <b>Educational Social Network</b> or <i>(EDSON)</i> aims to connect your class in a social way. Post your announcement in your class timeline, view their profile and see their responses and interactions on your class. Upload your activity materials, so your students will download it and able to cope with your class. See next for creating a class and period.
                                        </p>

                                      </div>
                                      <div id="step-2">
                                        <h2 class="StepTitle">Class</h2>
                                        <p>
                                          The Educational Social Network, has the capability of creating a new class. Likewise, if you have a subject to be handled then you may create a new class listing with its subject name, section, and its schedule description. You can found it at the upper left of your dashboard menu. All classes has its corresponding periods, whenever you create a new class it will automatically generate its periods depending on the number of periods you created. See Periods below;
                                        </p>
                                        <h2 class="StepTitle">Period</h2>
                                        <p>
                                          By creating periods, you can able to dissect the current term. Normal periods have its description such as Prelim, Midterm, and Finals. For some, it may included Pre-Finals or Summer in other way around. Creation of period can be located at the upper left of your dashboard menu.
                                        </p>
                                      </div>
                                      <div id="step-3">
                                        <h2 class="StepTitle">Timeline</h2>
                                        <p>
                                          This is where all announcements and activities can be found. There are two timelines, it can be by <b>period</b> or in <b>general</b>. First, General Timeline of a class allows you and joined students to see all posted announcements and activities in the whole period <i>(it will display all the period timeline from the start of a period until the end)</i>. Second, Period Timeline of a class allows you and joined students to see what are the announcements and activities on that one period.
                                        </p>
                                         <h2 class="StepTitle">Activities</h2>
                                        <p>
                                          A teacher can create an activities, this is different from quizzes and exams. Activities are more like assignments, you state some questions and attached if any activity guide materials for the students to be answered. Students must upload their answers of the said activity within the date span allocated by the teacher. Failed to do so will be given automatically a zero grade. NOTE : every activity made will be posted automatically on a Timeline.
                                        </p>

                                        <h2 class="StepTitle">Quizzes & Exams</h2>
                                        <p>
                                          A teacher can create a set of questions for quizzes and exams via uploading on the Excel File format guide. You will be given instructions once you are creating a quiz or exam. Once uploaded, all questions will be arranged in random. Teacher can also set the schedule date span and time for the quiz or exam to be finished. Once a student is finished, it will automatically calculate its score. The teacher have aksi the option to reopen the quiz or exam for maximum of 3 days for those students who have not yet taken the quiz or exam. NOTE : every quiz and exams made will be posted automatically on a Timeline.
                                        </p>
                                      </div>
                                      <div id="step-4">
                                        <h2 class="StepTitle">Grades</h2>
                                        <p>Grades are automatically calculated for quizzes and exams. But you manually inputed on activities, because you have to download their work first before grading them via excel file. You can download the gradesheet for those students who have passed the activities, and those students who fail to upload their activity will be given automatically a zero grade.
                                        </p>
                                        <h2 class="StepTitle">Performance</h2>
                                        <p>
                                          A graphical representation on each class will show on your dashboard home. It will record the most highest average grade attainment for each classes you have handled. And also it will feature a radar chart, consisting for their performance of each subject. Radar chart can be viewed on their profile.
                                        </p>
                                        <p>
                                          Now you have know the basics, if you have questions just check the FAQ (Frequently Asked Question) page regarding this site. Best of luck Teacher '.$_SESSION['fname'].'
                                        </p>

                                              <div class="clearfix"></div>

                                              <a href="scripts.php?page=getstarted&type=teacher" class="btn btn-success pull-right btn-lg">Finish</a>
                                      </div>

                                    </div>
                                    <!-- End SmartWizard Content -->


                                   </div>
                            </div>

                          </div>';





                        } else {


                          $html .='

                            <input type="button" class="btn btn-primary" id="hideshow" value="Post Announcement">
                              <div id="cmp" style="display: none;">
                                 <div class="compose-body">
                                   <form action="scripts.php?page=postdashboard" enctype="multipart/form-data" method="POST" >

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

                                  <br />

                                  <div class="compose-footer pull-right">

                                  <select id="selectpriv" name="priv">
                                  <option value="All">All Sections</option>';

                                  $s = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");

                                  while ($sRow = mysqli_fetch_array($s)) {


                                    $html .='<option value="'.$sRow['section_id'].'">'.$sRow['section_name'].'-'.$sRow['section_desc'].'</option>';

                                  }


                                  $html .='<!-- <option value="Custom">Custom</option> -->

                                  </select>
                                  &nbsp; &nbsp; 
                                 
                                  <input type="file" name="upload[]" id="file" class="inputfile inputfile-3" data-multiple-caption="{count} files selected" multiple="multiple" />
                                  <label for="file"><i class="fa fa-upload"></i> <small><span> Upload Files</span></small></label>
                                  <label id="sgif" style="display:none;"><img src="images/loadgif.gif" width="20" height="20" /></label>

                                    <button class="btn btn-sm btn-success" onclick="showLoading();" type="submit">Post</button>

                                  </div>

                                   </form>


                                   </div>


                                     <div class="x_title">
                               
                                <div class="clearfix"></div>
                              </div>
                              <div class="x_content">

                               <div id="pt">';

                                      // $cp = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection,tblperiod WHERE tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.teacher_id='".$_SESSION['id']."' AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");

                                        $cp = mysqli_query($con, "SELECT * FROM tblpost,tblsection WHERE tblpost.user_type='Teacher' AND tblpost.user_id='".$_SESSION['id']."' AND tblsection.section_id=tblpost.section_id AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");

                                      $cpCount = mysqli_num_rows($cp);

                                      if ($cpCount == 0) {

                                        $html .='';

                                      } else {

                                        $html .='<ul class="list-unstyled timeline">';

                                        while($cpRow = mysqli_fetch_array($cp)) {



                                              $r = mysqli_query($con, "SELECT * FROM tblreply WHERE post_id='".$cpRow['post_id']."'");

                                              $rCount = mysqli_num_rows($r);

                                              $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.cp_id='".$cpRow['cp_id']."' AND tblperiod.period_id=tblclassperiod.period_id");


                                              $pCount = mysqli_num_rows($p);

                                              if ($pCount != 0) {

                                                $pRow = mysqli_fetch_array($p);

                                                $periodName = strtoupper($pRow['period_name']);

                                              } else {


                                               $periodName = "ALL PERIODS";
                                              }

                                              

                                            
                                              $editControls = "";


                                              if ($cpRow['user_type'] == "Teacher") {


                                                $s = mysqli_query($con, "SELECT * FROM tblteacher WHERE tblteacher.teacher_id='".$cpRow['user_id']."'");

                                                $sRow = mysqli_fetch_array($s);

                                                $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                                $postedPost = 'Posted by '.$sRow['teacher_fname'].' '.$sRow['teacher_lname'].' <i title="Teacher" class="fa fa-check-circle"></i>';





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


                                                      $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.strtoupper($cpRow['period_name']).']</b> >';

                                                      $postedPost = 'Posted by <a href="?page=myprofile">'.$sRow['student_fname'].' '.$periodName.' <i title="X Class President" class="fa fa-remove"></i></a>';

                                                    } else {

                                                       $headerPost = $cpRow['section_name'].' - '.$cpRow['section_desc'].' <b>['.$periodName.']</b> ';

                                                       $postedPost = 'Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].' <i title="X Class President" class="fa fa-remove"></i></a> ';

                                                    }

                                                    

                                                }


                                              }

                                            $isDisplay = true;

                                           

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
                      



                      $html .='</div>


                     <!-- start project-detail sidebar -->
                    <div class="col-md-4 col-sm-4 col-xs-12">

                      <section class="panel">

                        <div class="x_title">
                          <h2>Recent Submissions</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">';



                                        $sec = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit,tblstudent WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id AND tblstudent.student_id=tblsubmit.student_id ORDER BY tblsubmit.submit_datetime DESC");

                                          $secCount = mysqli_num_rows($sec);

                                          if ($secCount == 0) {

                                               $html .='<p>No activities submitted</p>';


                                          } else {



                                              $html .='<!-- start project list -->
                                                <table id="activitytable99" class="table table-striped projects">
                                                  <thead>
                                                    <tr>
                                                      <th>Actvity Name</th>
                                                      <th>Student</th>
                                                      <th>Action</th>
                                                    </tr>
                                                  </thead>
                                                    <tbody>';






                                                  while($secRow = mysqli_fetch_array($sec)) {



                                                      $cp = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection,tblperiod WHERE tblpost.custom_id='".$secRow['activity_id']."' AND tblpost.post_type = 'Activity' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblperiod.period_id=tblclassperiod.period_id");

                                                        $cpRow = mysqli_fetch_array($cp);


                                                          if ($cpRow['section_status'] == "Active") {
                                                            
                                                                $html .='
                                                                  <tr>
                                                                    <td>
                                                                      <a>'.$secRow['activity_name'].'</a>
                                                                      <br />
                                                                      <small>'.$cpRow['section_name'].' - '.$cpRow['section_desc'].' ('.strtoupper($cpRow['period_name']).')</small>
                                                                    </td>
                                                                    <td>'.$secRow['student_fname'].' '.$secRow['student_lname'].'</td>


                                                                    <td> <a href="?page=viewgrade&id='.$secRow['activity_id'].'" class="btn btn-info btn-xs">View Activity</a>
                                                                   </td>
                                                                   
                                                                  </tr>';
                                                          }

                                                        }


                                                  $html .='
                                                      </tbody>
                                                    </table>';

                                                
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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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


        $html .=' <!-- modal for custom privacy -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="custom-modal">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Custom Privacy</h4>

                        </div>

                        <div class="modal-body">

                      

                        <form class="form-horizontal">

                       

                          <div class="form-group">

                           

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                 <input type="radio" checked name="selpriv" value="Only">Shared only to

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter sections here"></textarea>

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                          

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="radio" name="selpriv" value="Except">Shared to all except
                              <textarea id="receiverMsg" class="form-control" disabled coloring="10" placeholder="Enter sections here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button> -->

                          



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal custom -->';


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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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



function createclass() {




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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> -->  

                      

                    </ul>

                  </li>';



                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$row1['section_term'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                      <!-- <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




                       }



                      $html .='</ul>

                    </li>';


                    }

                }
                  


                $html .='

                </ul>

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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



         $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);



        $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'

                 .'0123456789'); // and any other characters

       shuffle($seed); // probably optional since array_is randomized; this may be redundant

       $rand = '';

       foreach (array_rand($seed, 5) as $k) $rand .= $seed[$k];



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>


            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>

            <div class="row">

              <div class="col-md-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2><a href="teacher.php">Home</a> / Create Class</h2>

                    

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    <div class="col-md-12 col-sm-12 col-xs-12">



                         <br />

                    <form method="POST" action="scripts.php?page=savesections" data-parsley-validate class="form-horizontal form-label-left">';



                      if ($_SESSION['cerror'] == "Success") {



                           $html .='<div class="alert alert-success alert-dismissible fade in" role="alert">

                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                      </button>

                      Successfully added.

                    </div>';





                      } else if ($_SESSION['cerror'] != "") {



                           $html .='<div class="alert alert-danger alert-dismissible fade in" role="alert">

                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                      </button>

                      '.$_SESSION['cerror'].'

                    </div>';



                      }



                      $_SESSION['cerror'] = "";





                      $html .='



                      <!-- <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Class Name <span class="required">*</span>

                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <input type="text" name="name" required="required" placeholder="MATH03" class="form-control col-md-7 col-xs-12">

                        </div>

                      </div> -->


                      <h3>Sections</h3>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12"> <span class="required">Add Sections*</span>

                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                           <input id="tags_1" type="text" name="sections" class="tags form-control col-md-7 col-xs-12" required="required" placeholder="Enter sections here e.g cd, ck" />

                        </div>

                      </div>

                       




                      <div class="form-group">

                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                          <button type="reset" class="btn btn-primary">Reset</button>

                          <button type="submit" onclick="showGif();" id="btnSubmit" class="btn btn-success">Submit</button>

                          <img src="images/loadgif.gif" width="50" height="50" id="subgif" style="display:none;" />

                        </div>

                      </div>



                    </form>


                      <div class="ln_solid"></div>

                        <form method="POST" action="scripts.php?page=saveclassterm" data-parsley-validate class="form-horizontal form-label-left">


                      <h3>Add Class</h3>

                         <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12"> <span class="required">Period</span>

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                               <select name="period" class="form-control">
                               <option value="Prelim">Prelim</option>
                               <option value="Midterm">Midterm</option>
                               <option value="Finals">Finals</option>

                               </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12"> <span class="required">Term</span>

                            </label>

                            <div class="col-md-6 col-sm-6 col-xs-12">

                               <select name="term" class="form-control">
                               <option value="1st Semester">1st Semester</option>
                               <option value="2nd Semester">2nd Semester</option>
                               <option value="1st Trimester">1st Trimester</option>
                               <option value="2nd Trimester">2nd Trimester</option>
                               <option value="3rd Trimester">3rd Trimester</option>
                               <option value="Summer">Summer</option>

                               </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12"> <span class="required">Year</span>

                            </label>

                            <div class="col-md-3 col-sm-3 col-xs-12">

                               <select name="yr1" class="form-control">
                               <option value="2016">2016</option>
                               <option value="2017">2017</option>

                               </select>

                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">

                               <select name="yr2" class="form-control">
                               <option value="2017">2017</option>
                               <option value="2018">2018</option>

                               </select>

                            </div>

                        </div>

                        <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12"> <span class="required">Section</span>

                            </label>

                            <div class="col-md-3 col-sm-3 col-xs-12">

                               <select name="sec" class="form-control" required>
                               <option value="">Select a section</option>';

                               $s = mysqli_query($con, "SELECT * FROM tblsections WHERE teacher_id='".$_SESSION['id']."'");

                               while($sRow = mysqli_fetch_array($s)) {


                                $html .='<option value="'.$sRow['section_name'].'">'.$sRow['section_name'].'</option>';

                               }
                               

                               $html .='</select>

                            </div>

                        </div>
                       
                            <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12"> <span class="required">Class & Category</span>

                            </label>

                            <div class="col-md-3 col-sm-3 col-xs-12">

                                <input type="text" name="classname" required class="form-control" placeholder="e.g MATH03"/>

                            </div>

                            <div class="col-md-3 col-sm-3 col-xs-12">

                               <select name="ctgry" class="form-control" required>
                                  <option value="">Category</option>
                                  <option value="English">English</option>
                                  <option value="Math">Math</option>
                                  <option value="Filipino">Filipino</option>
                                  <option value="Science">Science</option>
                                  <option value="Business">Business</option>
                                  <option value="Ethics">Ethics</option>
                                  <option value="History">History</option>
                                  <option value="Engineering">Engineering</option>
                                  <option value="Computer">Computer</option>
                                  <option value="Religion">Religion</option>
                                  <option value="PE">PE</option>
                                  <option value="Arts">Arts</option>
                                  <option value="NSTP">NSTP</option>

                               </select>

                            </div>

                        </div>




                      <div class="form-group">

                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                          <button type="reset" class="btn btn-primary">Reset</button>

                          <button type="submit" id="btnSubmit1" class="btn btn-success">Submit</button>

                          <!-- <img src="images/loadgif.gif" width="50" height="50" id="subgif" style="display:none;" /> -->

                        </div>

                      </div>


                    </div>


                    </form>
                   



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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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





function createperiod() {



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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <li><a href="?page=createperiod">Create Period</a>

                      </li> 

                     

                    </ul>

                  </li>';



                $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_name ASC");

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


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_name'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';


                       $res1 = mysqli_query($con, "SELECT * FROM tblperiod WHERE period_status='Active' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['period_name'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblsection,tblclassperiod WHERE tblsection.section_name='".$row['section_name']."' AND tblsection.teacher_id='".$_SESSION['id']."' AND tblsection.section_status='Active' AND tblclassperiod.section_id=tblsection.section_id AND tblclassperiod.period_id='".$row1['period_id']."'");

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['section_desc'].'</a>';


                                        }


                                    $html .='</ul>

                                  </li>';




                       }



                      $html .='</ul>

                    </li>';


                    }

                }


                  



                $html .='

                </ul>

              </div>

              <div class="menu_section">

                <h3>My Classes</h3>

                <ul class="nav side-menu">';



                $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_name ASC");

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


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_name='".$row['section_name']."' AND section_status='Active' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_desc'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">

                                       <li><a href="?page=timeline&id='.$row1['section_id'].'">Timeline</a>

                                      </li> 

                                      <!-- <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->

                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Grades</a>

                                      </li>

                                    </ul>

                                  </li>';




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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



         $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);





        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>


            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    <h2><a href="teacher.php">Home</a> / Create Period</h2>

                    

                    <div class="clearfix"></div>

                  </div>

                  <div class="x_content">

                    <div class="col-md-12 col-sm-12 col-xs-12">



                         <br />

                    <form method="POST" action="scripts.php?page=saveperiod" data-parsley-validate class="form-horizontal form-label-left">';



                      if ($_SESSION['cerror'] == "Success") {



                           $html .='<div class="alert alert-success alert-dismissible fade in" role="alert">

                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                      </button>

                      Successfully added a new period

                    </div>';





                      } else if ($_SESSION['cerror'] != "") {



                           $html .='<div class="alert alert-danger alert-dismissible fade in" role="alert">

                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                      </button>

                      '.$_SESSION['cerror'].'

                    </div>';



                      }



                      $_SESSION['cerror'] = "";





                      $html .='



                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Period Name <span class="required">*</span>

                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <input type="text" name="name" required="required" placeholder="Prelim" class="form-control col-md-7 col-xs-12">

                        </div>

                      </div>

                      <div class="form-group">

                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Description <span class="required">*</span>

                        </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">

                          <input type="text" name="desc" required="required" placeholder="Prelim 2016 1st Term" class="form-control col-md-7 col-xs-12">

                        </div>

                      </div>

                      



                      <div class="ln_solid"></div>

                      <div class="form-group">

                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">

                          <button type="reset" class="btn btn-primary">Cancel</button>

                          <button type="submit" onclick="showGif();" id="btnSubmit" class="btn btn-success">Submit</button>

                          <img src="images/loadgif.gif" width="50" height="50" id="subgif" style="display:none;" />

                        </div>

                      </div>



                    </form>





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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> -->

                     

                    </ul>

                  </li>';



                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                   <!--    <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




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


        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



          $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);



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



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

             <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>


            <div class="row">

               <div class="col-md-12 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    

                    <h2>'.$classRow['period_name'].' / '.$classRow['section_name'].'</h2>

                    

                    <div class="clearfix"></div>

                  </div> <!-- x_title -->

                      <div class="" role="tabpanel" data-example-id="togglable-tabs">

                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">

                        <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Timeline</a>

                        </li>

                          <li role="presentation" class=""><a href="#activity" role="tab" id="activity-tab" data-toggle="tab" aria-expanded="false">Activity</a>

                        </li>

                            <li role="presentation" class=""><a href="#quiz" role="tab" id="quiz-tab" data-toggle="tab" aria-expanded="false">Exam & Quizzes</a>

                        </li>

                        <li role="presentation" class=""><a href="#grade" role="tab" id="grade-tab" data-toggle="tab" aria-expanded="false">Grade</a>

                        </li> 


                        <li role="presentation" class=""><a href="#students" role="tab" id="students-tab" data-toggle="tab" aria-expanded="false">Students</a>

                        </li> 





                      </ul>

                      <div id="myTabContent" class="tab-content">

                        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">

                            <h3>Section Code : <b>'.$classRow['section_code'].'</b></h3>
                            <small>Copy the code at the top and share it to your students.</small>
                          <br />

                             <br />

                          <button id="compose" class="btn btn-success" type="button">Post to Timeline</button>

                          <a href="#" data-toggle="modal" data-target="#viewannouncements" class="btn btn-primary">View Announcements</a>

                          <hr />



                          <ul class="list-unstyled timeline">';





                         $cl = mysqli_query($con, "SELECT * FROM tblclassperiod WHERE cp_id='".$_GET['id']."'");

                          $clRow = mysqli_fetch_array($cl);



                          $t = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$_GET['id']."' ORDER BY post_datetime DESC");



                          $tCount = mysqli_num_rows($t);



                          if ($tCount == 0) {





                            $html .='<h2>No Timeline to be shown</h2>';



                          } else {





                          while($tRow = mysqli_fetch_array($t)) {



                            $r = mysqli_query($con, "SELECT * FROM tblreply WHERE post_id='".$tRow['post_id']."'");



                            $rCount = mysqli_num_rows($r);



                            if ($tRow['user_type'] == "Teacher") {





                              $headerPost = 'Posted by <a href="?page=myprofile">'.$_SESSION['fname'].' '.$_SESSION['lname'].'</a> <i title="Teacher" class="fa fa-check-circle"></i>';



                            } else {



                             
                              $s = mysqli_query($con, "SELECT * FROM tblstudent,tblclass WHERE tblstudent.student_id='".$tRow['user_id']."' AND tblclass.student_id=tblstudent.student_id AND tblclass.section_id='".$classRow['section_id']."'");



                              $sRow = mysqli_fetch_array($s);

                              if ($sRow['class_status'] == "Class President") {

                                   $headerPost = 'Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="Class President" class="fa fa-check-circle-o"></i>';


                              } else {

                                   $headerPost = 'Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="X Class President" class="fa fa-remove"></i>';

                              }


                            }

                          $isDisplay = true;

                          if ($tRow['post_type'] == "Quiz" || $tRow['post_type'] == "Exam") {

                            $test = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$tRow['custom_id']."'");

                            $testRow = mysqli_fetch_array($test);

                          



                          } else if ($tRow['post_type'] == "Activity") {

                            $a = mysqli_query($con, "SELECT * FROM tblactivity WHERE activity_id='".$tRow['custom_id']."'");

                            $aRow = mysqli_fetch_array($a);


                          }

                          // tag coloring



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

                              $postContent = '<h3 class="title">'.$aRow['activity_name'].'</h3>
                                              <p>'.$aRow['activity_desc'].'</p>
                                              '.$headerPost;  
                          }

                          // end of tag coloring

                          if ($isDisplay == true) {

                         

                                $html .='<li>

                                  <div class="block">

                                    <div class="'.$tags.'">

                                      <a href="?page=viewpost&id='.$tRow['post_id'].'&cpid='.$_GET['id'].'" class="'.$tag.'">

                                        <span>'.$tRow['post_type'].'</span>

                                      </a>

                                    </div>

                                    <div class="block_content">

                                        <ul class="nav navbar-right panel_toolbox">
                                              <li><a href="#" data-toggle="modal" onclick="editPost('.$tRow['post_id'].');" data-target="#editFields"><i class="fa fa-edit"></i></a>
                                                  </li>
                                                <li><a onclick="removePost('.$tRow['post_id'].');"><i class="fa fa-remove" title="Remove Post"></i></a>
                                                  </li>
                                            </ul>

                                    '.$postContent.'

                                    <!-- <h2 class="title">$headerPost</h2> -->

                                       

                                      <div class="byline">

                                        <span title="Posted at '.date('F d, Y g:i A', strtotime($tRow['post_datetime'])).'">'.timeAgo($tRow['post_datetime']).'</span>

                                      </div>';


                                      if ($tRow['post_files'] == "N/A") {


                                        if ($tRow['post_type'] == "Activity") {

                                            $actRes = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$tRow['custom_id']."'");

                                            $aCount = mysqli_num_rows($actRes);

                                            $html .=' <p><a href="?page=viewpost&id='.$tRow['post_id'].'&cpid='.$_GET['id'].'">Submiited('.$aCount.') / View Replies('.$rCount.')</a></p>';


                                        } else {



                                          if ($tRow['post_type'] == "Post") {



                                        $html .=' <p><a href="?page=viewpost&id='.$tRow['post_id'].'&cpid='.$_GET['id'].'">View Replies ('.$rCount.')</a></p>';

                                          } else {

                                              if ($testRow['test_status'] == "Unpublished") {

                                                $html .=' <p>Post Status : <b>Unpublished</b></p>';


                                              } else {

                                                $html .=' <p><a href="?page=viewpost&id='.$tRow['post_id'].'&cpid='.$_GET['id'].'">View Replies ('.$rCount.')</a></p>';

                                              }


                                          }


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

                          <br />
                         
                          <!-- <a href="#" data-toggle="modal" class="btn btn-success" data-target="#newActivity">Create Activity</a> -->';

                                if ($_SESSION['cerror'] == "Success") {



                                   $html .='<div class="alert alert-success alert-dismissible fade in" role="alert">

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                                    </button>

                                    Successfully created!

                                  </div>';

                              } else if ($_SESSION['cerror'] != "") {


                                   $html .='<div class="alert alert-danger alert-dismissible fade in" role="alert">

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                                    </button>

                                    '.$_SESSION['cerror'].'

                                  </div>';


                              }

                              $_SESSION['cerror']  = "";

                           


                          $html .= '

                          <input type="button" value="Create Activity" class="btn btn-primary" id="atb" onclick="taggle();">

                          <div id="ato" style="display:none;">


                              <form class="form-horizontal form-label-left" action="scripts.php?page=saveactivity&id='.$classRow['section_id'].'&cpid='.$_GET['id'].'" enctype="multipart/form-data" method="POST">


                              <div class="form-group">

                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Activity Name</label>

                                <div class="col-md-9 col-sm-9 col-xs-12">

                                  <input type="text" maxlength="30" required="required" id="activityName" name="activityName" class="form-control" placeholder="Enter activity name here">

                                </div>

                              </div>



                                <div class="form-group">

                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Activity Instructions</label>

                                  <div class="col-md-9 col-sm-9 col-xs-12">

                                    <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editora">
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

                        
                              <div id="editora" onblur="saveIns();" class="editor-wrapper"></div>

                                    <textarea class="form-control" style="display:none;" name="activityDesc" id="activityDesc" required="required"></textarea>

                                  </div>

                                </div>

                          
                                <div class="form-group">

                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Deadline</label>

                                    <div class="col-md-9 col-sm-9 col-xs-12">

                                                    <input type="text" class="form-control has-feedback-left" name="deadline" id="single_cal2" placeholder="From date today until." aria-describedby="inputSuccess2Status">
                                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                                <span id="inputSuccess2Status" class="sr-only">(success)</span>

                                    </div>

                                     

                                </div>

                                 <div class="form-group">

                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Images</label>

                                  <div class="col-md-9 col-sm-9 col-xs-12">

                                                
                                  <input type="file" name="upload[]" id="file" multiple accept="image/*"> <br />


                                  <input type="submit" onclick="showLoadBar();" class="btn btn-primary" value="Save Activity">

                                        <label id="stest" style="display:none;"><img src="images/loadgif.gif" width="20" height="20" /></label>

                                       


                                  </div>

                                   
                                </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission</center>

                       

                       </form>


                          </div>

                          <hr />';


                           $a = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$_GET['id']."' AND post_type='Activity' ORDER BY post_datetime DESC");



                          $aCount = mysqli_num_rows($a);



                          if ($aCount == 0) {





                            $html .='<h2>No Activities to be shown</h2>';

                          } else {


                              $html .='<h2>List of '.$classRow['period_name'].' Activities</h2>

                               <div class="x_content">

                                 <table id="activitytable" width="100%" class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Activity Name</th>
                                        <th>Activity Span</th>
                                        <th>Status</th>
                                        <th>Submission</th>
                                        <th class="hidden-xs">Actions</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                    $act = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Activity' AND tblactivity.activity_id=tblpost.custom_id");

                                    while($actRow = mysqli_fetch_array($act)) {

                                      $stud = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$classRow['section_id']."'");

                                      $studCount = mysqli_num_rows($stud);

                                      $submit = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$actRow['activity_id']."'");

                                      $submitCount = mysqli_num_rows($submit);

                                       $html .='

                                      <tr>
                                      <th scope="row">'.$actRow['activity_id'].'</th>
                                      <td>'.$actRow['activity_name'].'</td>
                                      <td>'.date("M d, Y", strtotime($actRow['activity_datestart'])).' - '.date("M d, Y", strtotime($actRow['activity_dateend'])).'</td>
                                      <td>'.$actRow['activity_status'].'</td>
                                      <td class="hidden-xs">'.$submitCount.' / '.$studCount.' Students </td>

                                      <td class="hidden-xs">  <div class="btn-group">
                                              <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" type="button"> Actions <span class="caret"></span> </button>
                                              <ul class="dropdown-menu">
                                                <li><a href="?page=viewpost&id='.$actRow['post_id'].'&cpid='.$_GET['id'].'">View Post</a>
                                                </li>
                                                 <li><a href="?page=viewgrade&id='.$actRow['activity_id'].'">View Submissions</a>
                                                </li>';

                                                if ($actRow['activity_status'] == "Open") {

                                                    $html .='<li><a href="#extend'.$actRow['activity_id'].'" data-toggle="modal">Extend</a>
                                                </li>';

                                                } else {

                                                  $html .='<li><a href="#reopen'.$actRow['activity_id'].'" data-toggle="modal">Re-Open</a>
                                                </li>';

                                                }

                                             

                                                
                                              $html .='
                                              </ul>
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

                          <br />
                         
                         <!-- <a href="#" data-toggle="modal" class="btn btn-success" data-target="#newTest">Create Test</a> -->';


                      if ($_SESSION['terror'] == "Success") {



                           $html .='<div class="alert alert-success alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Successfully created!

                          </div>';

                      } else if ($_SESSION['terror'] != "") {


                           $html .='<div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            '.$_SESSION['terror'].'

                          </div>';


                      }


                      $_SESSION['terror'] = "";



                        $html .='<input type="button" value="Create Test" class="btn btn-primary" id="ctb" onclick="toggle();">

                          <div id="cto" style="display:none;">

                             <form class="form-horizontal form-label-left" id="testForm" action="scripts.php?page=savetest" enctype="multipart/form-data" method="POST">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <select id="testType" name="type" class="form-control">
                               <option value="Quiz" selected>Quiz</option>';

                               $exam = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$_GET['id']."' AND post_type='Exam'");

                               $hasExam = mysqli_num_rows($exam);

                               if ($hasExam == 0) {

                                $html .='<option value="Exam">Exam</option>';

                               }



                               $html .='</select>

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Test Name</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <input type="text" maxlength="30" required="required" id="quizName" name="qname" class="form-control" placeholder="Enter test name here">

                            </div>

                          </div>



                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Test Description</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editort">
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

                  
                        <div id="editort" onblur="saveTDesc();" class="editor-wrapper"></div>

                              <textarea style="display:none;" name="desc" id="quizDesc" required="required" placeholder="Enter test description here"></textarea>

                            </div>

                          </div>

                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Deadline</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <!-- <input type="number" name="days" required="required" id="quizDays" class="form-control" value="1">

                               <small>If none or zero it will be save as unpublished</small> -->


                                   
                                        <input type="text" name="deadline" required class="form-control has-feedback-left" id="single_cal1" placeholder="From date today until." aria-describedby="inputSuccess2Status">
                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        <span id="inputSuccess2Status" class="sr-only">(success)</span>
                                    
                      

                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Time Duration</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <select id="quizDuration" name="time" class="form-control">
                               <option value="30" selected>30 minutes</option>
                               <option value="60">1 hour</option>
                               <option value="90">1 hour and 30 minutes</option>
                               <option value="120">2 hours</option>

                               </select>

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Question Format</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                                    <input type="checkbox" name="testFormat[]" id="ctf" onclick="ident();" value="Identification">Identification
                                    <br />

                                    <div id="ident" style="display:none;">

                                      <a href="functions/identification.php" class="btn btn-primary">Download Identification Format</a><input type="file" id="upd1" name="ident" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                                 
                                    </div>


                                    <hr />

                                    <input type="checkbox" name="testFormat[]" id="ctf" value="Multiple" class="flat" /> Multiple Choice
                                    <br />

                                    <div id="multi" style="display:none;">

                                      <a href="functions/choiceformat.php" class="btn btn-primary">Download Multiple Choice Format</a><input type="file" id="upd2" name="multi" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                                 
                                    </div>

                                    <hr />

                                    <input type="checkbox" name="testFormat[]" id="ctf" value="Matching" class="flat" /> Matching Type
                                    <br />


                                    <div id="match" style="display:none;">

                                      <a href="functions/matching.php" class="btn btn-primary">Download Matching Type Format</a><input type="file" id="upd3" name="match" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                                 
                                    </div>

                                    <hr />

                                    <input type="checkbox" name="testFormat[]" id="ctf" value="Essay" class="flat" /> Essay


                                    <div id="ess" style="display:none;">

                                      <a href="functions/essay.php" class="btn btn-primary">Download Essay Type Format</a><input type="file" id="upd4" name="essay" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                                 
                                    </div>

                                    <hr />

                                    <!-- Question Format should reflect to checked boxes, if you check The Identification Type but uploaded a Multiple Choice Format then it will not be saved. -->

                               <!-- <select id="quizFormat" required="required" name="format" onchange="selectFormat();" class="form-control">
                               <option value="" selected>Choose a format</option>
                               <option value="Multiple">Multiple Choice</option>
                               <option value="Identification">Identification</option>
                               <option value="Matching">Matching Type</option>
                               <option value="Essay">Essay</option>

                            

                               </select> -->

                               <br />

                                <div class="col-md-6 col-sm-6 col-xs-12">

                                     <!-- <a href="functions/choiceformat.php" id="choice" style="display:none;" class="btn btn-primary">Download Multiple Choice Format</a>

                                  <a href="functions/identification.php" id="identify" style="display:none;" class="btn btn-primary">Download Identification Format</a>

                                   <a href="functions/matching.php" id="matching" style="display:none;" class="btn btn-primary">Download Matching Type Format</a>

                                    <a href="functions/essay.php" id="essay" style="display:none;" class="btn btn-primary">Download Essay Format</a>

                                  <br /> -->

                                  <!-- <input type="file" id="upload" style="display:none;" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" /> -->


                                  </div>

                                         
                            </div>

                         
                          </div>




                          <input type="hidden" name="periodID" value="'.$_GET['id'].'" id="periodID">

                                  <div class="form-group">

                                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Images</label>

                                  <div class="col-md-9 col-sm-9 col-xs-12">

                                                
                                  <input type="file" name="upload[]" id="file" multiple accept="image/*">

                                  <br />

                                        <button type="submit" onclick="showLoadBar();" class="btn btn-primary" >Save Test</button>

                                      <label id="stests" style="display:none;"><img src="images/loadgif.gif" width="20" height="20" /></label>

                                  </div>

                                   
                                </div>


                          
                          <center>All tests are automatically closed within 11:59 PM of its last date of taken</center>
                  

                          </form>

                          </div>

                          <hr />';


                           $a = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$_GET['id']."' AND post_type !='Post' AND post_type != 'Activity' ORDER BY post_id DESC");



                          $aCount = mysqli_num_rows($a);



                          if ($aCount == 0) {





                            $html .='<h2>No Tests to be shown</h2>';

                          } else {


                              $html .='<h2>List of '.$classRow['period_name'].' Tests</h2>

                               <div class="x_content">

                                 <table id="quiztable" width="100%" class="table table-striped table-bordered">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Span</th>
                                        <th>Status</th>
                                        <th class="hidden-xs">Actions</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                    $test = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type !='Post' AND tblpost.post_type != 'Activity' AND tbltest.test_id=tblpost.custom_id");

                                    while($testRow = mysqli_fetch_array($test)) {

                                        if ($testRow['test_status'] == "Unpublished") {

                                           $span = "TBA";

                                        } else {


                                        $span = date("M d, Y", strtotime($testRow['test_datestart'])).' - '.date("M d, Y", strtotime($testRow['test_dateend']));

                                        }


                                        if ($testRow['test_type'] == "Quiz") {

                                             $html .='

                                            <tr>
                                            <th scope="row">'.$testRow['test_id'].'</th>
                                            <td>'.$testRow['test_name'].'</td>
                                            <td>'.$testRow['test_type'].'</td>
                                            <td>'.$span.'</td>
                                            <td>'.$testRow['test_status'].'</td>

                                            <td class="hidden-xs">  <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle btn-sm" type="button"> Actions <span class="caret"></span> </button>
                                                    <ul class="dropdown-menu">
                                                      <li><a href="?page=viewpost&id='.$testRow['post_id'].'&cpid='.$_GET['id'].'">View Post</a>
                                                      </li>
                                                       <li><a href="?page=viewtest&id='.$testRow['test_id'].'">View Test</a>
                                                      </li>';

                                                      if ($testRow['test_status'] == "Published") {

                                                          $html .='<li><a href="#extendtest'.$testRow['test_id'].'" data-toggle="modal">Extend</a>
                                                      </li>';

                                                      } else {

                                                        if ($testRow['test_status'] == "Unpublished") {

                                                          $html .='<li><a href="#publishtest'.$testRow['test_id'].'" data-toggle="modal">Publish</a>
                                                      </li>';

                                                        } else {

                                                             $html .='<li><a href="#reopentest'.$testRow['test_id'].'" data-toggle="modal">Re-Open</a>
                                                      </li>';
                                                        }

                                                       

                                                      }

                                                      
                                                    $html .='
                                                    </ul>
                                                  </div>
                                                </td>
                                            </tr>';

                                        } else {

                                            $html .='

                                            <tr>
                                            <th scope="row"><b>'.$testRow['test_id'].'</b></th>
                                            <td><b>'.$testRow['test_name'].'</b></td>
                                            <td><b>'.$testRow['test_type'].'</b></td>
                                            <td><b>'.$span.'</b></td>
                                            <td><b>'.$testRow['test_status'].'</b></td>

                                            <td class="hidden-xs">  <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-sm" type="button"> Actions <span class="caret"></span> </button>
                                                    <ul class="dropdown-menu">
                                                      <li><a href="?page=viewpost&id='.$testRow['post_id'].'&cpid='.$_GET['id'].'">View Post</a>
                                                      </li>
                                                       <li><a href="?page=viewtest&id='.$testRow['test_id'].'">View Test</a>
                                                      </li>';

                                                      if ($testRow['test_status'] == "Published") {

                                                          $html .='<li><a href="#extendtest'.$testRow['test_id'].'" data-toggle="modal">Extend</a>
                                                      </li>';

                                                      } else {

                                                        if ($testRow['test_status'] == "Unpublished") {

                                                          $html .='<li><a href="#publishtest'.$testRow['test_id'].'" data-toggle="modal">Publish</a>
                                                      </li>';

                                                        } else {

                                                             $html .='<li><a href="#reopentest'.$testRow['test_id'].'" data-toggle="modal">Re-Open</a>
                                                      </li>';
                                                        }

                                                       

                                                      }

                                                    


                                                      
                                                    $html .='
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


                        <div role="tabpanel" class="tab-pane fade" id="grade" aria-labelledby="grade-tab">

                        
                         
                           <a href="functions/dlgrade.php?id='.$_GET['id'].'" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Download Grade</a>

                             <br />

                             <br />

                            <table class="table table-striped table-bordered" width="100%" id="questionstable">
                                    <thead>
                                      <tr>
                                        <th scope="row">#</th>
                                        <th>Name</th>';

                                        $ac = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Activity' AND tblactivity.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");

                                        $c = 1;

                                        while($acRow = mysqli_fetch_array($ac)) {

                                           

                                            $html .='<th>ACT'.$c.' - '.$acRow['activity_name'].'</th>';

                                             $c += 1;

                                        }

                                         $qz = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Quiz' AND tbltest.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");

                                              $c = 1;

                                        while($qzRow = mysqli_fetch_array($qz)) {

                                            $html .='<th>Q'.$c.' - '.$qzRow['test_name'].'</th>';

                                             $c += 1;

                                        }

                                        $ts = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Exam' AND tbltest.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");


                                        while($tsRow = mysqli_fetch_array($ts)) {

                                            $html .='<th>Exam</th>';

                                        }


                                        $html .='<th>'.$classRow['period_name'].' Grade</th>
                                        <th>Calculations</th>
                                      </tr>
                                    </thead>

                                    <tbody>';


                                      $s = mysqli_query($con, "SELECT * FROM tblclass,tblstudent WHERE tblclass.section_id='".$classRow['section_id']."' AND tblstudent.student_id=tblclass.student_id ORDER BY tblstudent.student_lname ASC");

                                      while($sRow = mysqli_fetch_array($s)) {


                                            $html .=' <tr>
                                                      <th scope="row"><img src="'.$sRow['student_picpath'].'" width="30" height="30"></th>
                                                          <td><a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a></td>';



                                             $ac = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Activity' AND tblactivity.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");


                                              while($acRow = mysqli_fetch_array($ac)) {


                                                  $sb = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$acRow['activity_id']."' AND student_id='".$sRow['student_id']."'");

                                                  $sbCount = mysqli_num_rows($sb);

                                                  if ($sbCount == 0) {



                                                  $html .='<td>0/100</td>';


                                                  } else {


                                                  $sbRow = mysqli_fetch_array($sb);

                                                  $html .='<td>'.$sbRow['submit_grade'].'/100</td>';


                                                  }


                                              }


                                                $qz = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Quiz' AND tbltest.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");


                                                  while($qzRow = mysqli_fetch_array($qz)) {


                                                          $qs = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$qzRow['test_id']."'");

                                                          $qsCount = mysqli_num_rows($qs);

                                                          $hs = mysqli_query($con, "SELECT * FROM tblanswer WHERE test_id='".$qzRow['test_id']."' AND student_id='".$sRow['student_id']."'");

                                                            $hsCount = mysqli_num_rows($hs);

                                                            if ($hsCount == 0) {



                                                            $html .='<td>0/'.$qsCount.'</td>';


                                                            } else {

                                                                 $correctItems = 0;

                                                                while($hsRow = mysqli_fetch_array($hs)) {

                                                                  if ($hsRow['answered_status'] == "Correct") {

                                                                     $correctItems += 1;
                                                                  }

                                                                }




                                                            $html .='<td>'.$correctItems.'/'.$qsCount.'</td>';


                                                            }

                                                  }



                                              $ts = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tblpost.post_type='Exam' AND tbltest.post_id=tblpost.post_id ORDER BY tblpost.post_datetime ASC");


                                                  while($tsRow = mysqli_fetch_array($ts)) {


                                                          $qs = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$tsRow['test_id']."'");

                                                          $qsCount = mysqli_num_rows($qs);

                                                          $hs = mysqli_query($con, "SELECT * FROM tblanswer WHERE test_id='".$tsRow['test_id']."' AND student_id='".$sRow['student_id']."'");

                                                            $hsCount = mysqli_num_rows($hs);

                                                            if ($hsCount == 0) {



                                                            $html .='<td>0/'.$qsCount.'</td>';


                                                            } else {

                                                                 $correctItems = 0;

                                                                while($hsRow = mysqli_fetch_array($hs)) {

                                                                  if ($hsRow['answered_status'] == "Correct") {

                                                                     $correctItems += 1;
                                                                  }

                                                                }




                                                            $html .='<td>'.$correctItems.'/'.$qsCount.'</td>';


                                                            }

                                                  }


                                                $grade = mysqli_query($con, "SELECT * FROM tblgrades WHERE student_id='".$sRow['student_id']."' AND section_id='".$classRow['section_id']."' AND cp_id='".$_GET['id']."'");


                                                $gradeRow = mysqli_fetch_array($grade);




                                                  $html .='<td width="20%"><div class="progress">';
                                                           

                                                    if ($gradeRow['total_grade'] < 50) {

                                                      $html .='<div class="progress-bar progress-bar-danger" data-transitiongoal="'.$gradeRow['total_grade'].'">'.$gradeRow['total_grade'].'%</div>';

                                                    } else if ($gradeRow['total_grade'] >= 50 && $gradeRow['total_grade'] <= 70) {


                                                      $html .='<div class="progress-bar progress-bar-info" data-transitiongoal="'.$gradeRow['total_grade'].'">'.$gradeRow['total_grade'].'%</div>';
                                                    } else {


                                                      $html .='<div class="progress-bar progress-bar-primary" data-transitiongoal="'.$gradeRow['total_grade'].'">'.$gradeRow['total_grade'].'%</div>';
                                                    }
                                                    
                                                    $html .='</div></td>

                                                          <td><a href="#" data-toggle="modal" data-target="#calc'.$sRow['student_id'].'" class="btn btn-info btn-sm"><i class="fa fa-info"></i> View</a>

                                                          </tr>';



                                      }



                                    $html .='
                                    </tbody>
                                  </table>

                          <hr />

                        </div>


                        <div role="tabpanel" class="tab-pane fade" id="students" aria-labelledby="students-tab">

                          

                      <h2> List of Students </h3>

                       <table class="table table-striped table-bordered" width="100%" id="studentstable">
                                    <thead>
                                      <tr>
                                        <th class="hidden-xs">#</th>
                                        <th>Picture</th>
                                        <th>Name</th>
                                        <th class="hidden-xs">Date Joined</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                    $join = mysqli_query($con, "SELECT * FROM tblclass,tblstudent WHERE tblclass.section_id='".$classRow['section_id']."' AND tblstudent.student_id=tblclass.student_id ORDER BY tblstudent.student_lname ASC");

                                    $cp = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$classRow['section_id']."' AND class_status='Class President'");

                                    $hasPresident = mysqli_num_rows($cp);

                                    while($joinedRow = mysqli_fetch_array($join)) {

                                       $html .='

                                      <tr>
                                      <th scope="row" class="hidden-xs">'.$joinedRow['student_num'].'</th>
                                      <td><img src="'.$joinedRow['student_picpath'].'" width="30" height="30"></td>
                                      <td><a href="?page=viewstudent&id='.$joinedRow['student_id'].'">'.$joinedRow['student_fname'].' '.$joinedRow['student_lname'].'</a></td>
                                      <td class="hidden-xs">'.timeAgo($joinedRow['class_datejoined']).'</td>';

                                      if ($hasPresident == 0) {


                                        // $html .='<td><a href="scripts.php?page=makepresident&id='.$classRow['section_id'].'&class='.$joinedRow['class_id'].'" class="btn btn-primary btn-sm"><i class="fa fa-check-circle-o"></i> Make President</a></td>';

                                        $html .='<td><a href="scripts.php?page=makepresident&id='.$_GET['id'].'&class='.$joinedRow['class_id'].'" class="btn btn-primary btn-sm"><i class="fa fa-check-circle-o"></i> Make President</a></td>';

                                      } else {

                                        if ($joinedRow['class_status'] == "Class President") {
                                                // $html .='<td><a href="scripts.php?page=removepresident&id='.$classRow['section_id'].'&class='.$joinedRow['class_id'].'" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Remove President</a></td>';

                                          $html .='<td><a href="scripts.php?page=removepresident&id='.$_GET['id'].'&class='.$joinedRow['class_id'].'" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Remove President</a></td>';

                                        } else {

                                                $html .='<td>Student</td>';
                                        }

                                      }




                                      $html .='
                                      <td><button type="button" onclick="delStudent('.$joinedRow['class_id'].');" class="btn btn-danger"><i class="fa fa-remove"></i> Kick</button</td>

                                      </tr>';


                                    }

                                    $html .='
                                    </tbody>
                                  </table>

                          

                          <hr />

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
       <form action="scripts.php?page=post&id='.$_GET['id'].'&type=teacher" enctype="multipart/form-data" method="POST" >
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

      $grades = mysqli_query($con, "SELECT * FROM tblgrades,tblstudent WHERE tblgrades.section_id='".$classRow['section_id']."' AND tblgrades.cp_id='".$classperiodID."' AND tblstudent.student_id=tblgrades.student_id");



            // modal for details  in grade

     while($gradesRow = mysqli_fetch_array($grades)) {

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="calc'.$gradesRow['student_id'].'">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">'.strtoupper($periodName).' GRADE : '.$gradesRow['student_fname'].' '.$gradesRow['student_lname'].'</h4>



                        </div>

                        <div class="modal-body">';


                       

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
                                    <th>Action</th>
                                  </tr>
                                </thead>

                                <tbody>';

                            while($activityRow = mysqli_fetch_array($activity)) {


                              $submit = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$activityRow['activity_id']."' AND student_id='".$gradesRow['student_id']."'");

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
                                  <td><a href="?page=viewgrade&id='.$activityRow['activity_id'].'" class="btn btn-info btn-sm"><i class="fa fa-arrow-circle-right"></i> View</a></td>
                                </tr>';





                            }


                            $prgActivity = $myActivityScore / $totalActivityScore;

                            $fnActivity = $prgActivity * $classRow['grade_activity'];

                            $fnActivity = round($fnActivity, 0);

                              $html .='</tbody>

                                    </table>

                            '.$gradesRow['student_fname'].' Total Activity Score : '.$myActivityScore.' <br />
                            Total Activity Item Score : '.$totalActivityScore.' <br />
                            <b>Get Activity Score</b> : '.$gradesRow['student_fname'].' Total Activity Score / Total Activity Item Score ; '.$myActivityScore.' / '.$totalActivityScore.' = '.round($prgActivity,1).' <br />
                            Activity Percentage : <b>Get Activity Score</b> / Activity (%) ; '.round($prgActivity,1).' X '.$classRow['grade_activity'].' = <b>'.$fnActivity.'</b> <br />

                            <h4>Activity ('.$classRow['grade_activity'].'%) Grade : <b>'.$fnActivity.'</b></h4>';


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


                              $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$quizRow['test_id']."' AND student_id='".$gradesRow['student_id']."'");

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

                            $fnQuiz = $prgQuiz * $classRow['grade_quiz'];

                            $fnQuiz = round($fnQuiz, 0);

                              $html .='</tbody>

                                    </table>

                            '.$gradesRow['student_fname'].' Total Quiz Points : '.$myQuizScore.' <br />
                            Total Quiz Item Points : '.$totalQuizScore.' <br />
                            <b>Get Quiz Score</b> : '.$gradesRow['student_fname'].' Total Quiz Points / Total Quiz Item Points ; '.$myQuizScore.' / '.$totalQuizScore.' = '.round($prgQuiz,1).' <br />
                            Quiz Percentage : <b>Get Quiz Score</b> / Quiz (%) ; '.round($prgQuiz,1).' X '.$classRow['grade_quiz'].' = <b>'.$fnQuiz.'</b> <br />

                            <h4>Quiz ('.$classRow['grade_quiz'].'%) Grade : <b>'.$fnQuiz.'</b></h4>';

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


                              $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$examRow['test_id']."' AND student_id='".$gradesRow['student_id']."'");

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


                            $prgExam = $myExamScore / $totalExamScore;

                            $fnExam = $prgExam * $classRow['grade_exam'];

                            $fnExam = round($fnExam, 0);

                              $html .='</tbody>

                                    </table>

                            '.$gradesRow['student_fname'].' Total Exam Points : '.$myExamScore.' <br />
                            Total Exam Item Points : '.$totalExamScore.' <br />
                            <b>Get Exam Score</b> : '.$gradesRow['student_fname'].' Total Exam Points / Total Exam Item Points ; '.$myExamScore.' / '.$totalExamScore.' = '.round($prgExam,1).' <br />
                            Exam Percentage : <b>Get Exam Score</b> / Exam (%) ; '.round($prgExam,1).' X '.$classRow['grade_exam'].' = <b>'.$fnExam.'</b> <br />

                            <h4>Exam ('.$classRow['grade_exam'].'%) Grade : <b>'.$fnExam.'</b></h4>';


                          }

                           // end of exams

                          


                        $html .='

                          <hr />

                          <h3>'.$classRow['period_name'].' Grade : <b>'.$gradesRow['total_grade'].'% </b></h3>

                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';


          }


      // modal for creating a new activity

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newActivity">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Create Activity</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left action="#" method="POST">


                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Activity Name</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <input type="text" maxlength="30" required="required" id="activityName" class="form-control" placeholder="Enter activity name here">

                            </div>

                          </div>



                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Activity Instructions</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editora">
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

                  
                        <div id="editora" onblur="saveIns();" class="editor-wrapper"></div>

                              <textarea class="form-control" style="display:none;" id="activityDesc" required="required"></textarea>

                            </div>

                          </div>

                          
                        <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Duration</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" required="required" id="activityDays" class="form-control" value="2">

                            </div>

                          </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission</center>

                          <input type="hidden" value="'.$_GET['id'].'" id="periodID">

                       </form>





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" onclick="clearActivity();" data-dismiss="modal">Close</button>

                          <button type="button" id="btnActivity" class="btn btn-primary" onclick="createActivity();">Create Activity</button>

                        </div>



                      </div>

                    </div>

                  </div>';

      // end


       // modal for creating a new test

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newTest">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Create A New Test</h4>

                        </div>

                        <div class="modal-body">

                          

                          <form class="form-horizontal form-label-left" id="testForm" action="scripts.php?page=savetest" enctype="multipart/form-data" method="POST">

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Type</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <select id="testType" name="type" class="form-control">
                               <option value="Quiz" selected>Quiz</option>';

                               $exam = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='".$_GET['id']."' AND post_type='Exam'");

                               $hasExam = mysqli_num_rows($exam);

                               if ($hasExam == 0) {

                                $html .='<option value="Exam">Exam</option>';

                               }



                               $html .='</select>

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Test Name</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <input type="text" maxlength="30" required="required" id="quizName" name="qname" class="form-control" placeholder="Enter test name here">

                            </div>

                          </div>



                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Test Description</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editort">
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

                  
                        <div id="editort" onblur="saveTDesc();" class="editor-wrapper"></div>

                              <textarea style="display:none;" name="desc" id="quizDesc" required="required" placeholder="Enter test description here"></textarea>

                            </div>

                          </div>

                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Duration</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <!-- <input type="number" name="days" required="required" id="quizDays" class="form-control" value="1">

                               <small>If none or zero it will be save as unpublished</small> -->



                            </div>

                          </div>

                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Time Duration</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <select id="quizDuration" name="time" class="form-control">
                               <option value="30" selected>30 minutes</option>
                               <option value="60">1 hour</option>
                               <option value="90">1 hour and 30 minutes</option>
                               <option value="120">2 hours</option>

                               </select>

                            </div>

                          </div>

                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Question Format</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                                    <input type="checkbox" name="testFormat[]" id="ctf" onclick="ident();" value="Identification">Identification
                                    <br />

                                    <div id="ident" style="display:none;">

                                      <a href="functions/identification.php" class="btn btn-primary">Download Identification Format</a><input type="file" id="upd1" name="ident" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                                 
                                    </div>


                                    <hr />

                                    <input type="checkbox" name="testFormat[]" id="ctf" value="Multiple" class="flat" /> Multiple Choice
                                    <br />

                                    <div id="multi" style="display:none;">

                                      <a href="functions/choiceformat.php" class="btn btn-primary">Download Multiple Choice Format</a><input type="file" id="upd2" name="multi" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                                 
                                    </div>

                                    <hr />

                                    <input type="checkbox" name="testFormat[]" id="ctf" value="Matching" class="flat" /> Matching Type
                                    <br />


                                    <div id="match" style="display:none;">

                                      <a href="functions/matching.php" class="btn btn-primary">Download Matching Type Format</a><input type="file" id="upd3" name="match" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                                 
                                    </div>

                                    <hr />

                                    <input type="checkbox" name="testFormat[]" id="ctf" value="Essay" class="flat" /> Essay


                                    <div id="ess" style="display:none;">

                                      <a href="functions/essay.php" class="btn btn-primary">Download Essay Type Format</a><input type="file" id="upd4" name="essay" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />

                                 
                                    </div>

                                    <hr />

                                    <!-- Question Format should reflect to checked boxes, if you check The Identification Type but uploaded a Multiple Choice Format then it will not be saved. -->

                               <!-- <select id="quizFormat" required="required" name="format" onchange="selectFormat();" class="form-control">
                               <option value="" selected>Choose a format</option>
                               <option value="Multiple">Multiple Choice</option>
                               <option value="Identification">Identification</option>
                               <option value="Matching">Matching Type</option>
                               <option value="Essay">Essay</option>

                            

                               </select> -->

                               <br />

                                <div class="col-md-6 col-sm-6 col-xs-12">

                                     <!-- <a href="functions/choiceformat.php" id="choice" style="display:none;" class="btn btn-primary">Download Multiple Choice Format</a>

                                  <a href="functions/identification.php" id="identify" style="display:none;" class="btn btn-primary">Download Identification Format</a>

                                   <a href="functions/matching.php" id="matching" style="display:none;" class="btn btn-primary">Download Matching Type Format</a>

                                    <a href="functions/essay.php" id="essay" style="display:none;" class="btn btn-primary">Download Essay Format</a>

                                  <br /> -->

                                  <!-- <input type="file" id="upload" style="display:none;" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" /> -->

                                  </div>


                            </div>

                         
                          </div>



                          <center>All tests are automatically closed within 11:59 PM of its last date of taken</center>

                          <input type="hidden" name="periodID" value="'.$_GET['id'].'" id="periodID">

                   





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Create Test</button>

                        </div>

                            </form>

                      </div>

                    </div>

                  </div>';

      // end

      // modal for extending in activity

     $res = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblactivity.activity_id=tblpost.custom_id AND tblactivity.activity_status='Open'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="extend'.$row['activity_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Extend Activity Duration</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=extendactivity&id='.$row['activity_id'].'&cpid='.$_GET['id'].'" method="POST">

                          <center><p>Extend days for Activity #'.$row['activity_id'].' - '.$row['activity_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Extend Days</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="activityDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission.</center>

                     




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="Submit" class="btn btn-primary">Confirm</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';

      }

      // end 

        // modal for reopen activity

     $res = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblactivity.activity_id=tblpost.custom_id AND tblactivity.activity_status='Closed'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="reopen'.$row['activity_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Reopen Activity</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=reopenactivity&id='.$row['activity_id'].'&cpid='.$_GET['id'].'" method="POST">

                          <center><p>Reopen Activity #'.$row['activity_id'].' - '.$row['activity_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Reopen</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="activityDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission.</center>

                 





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Confirm</button>

                        </div>

                              </form>

                      </div>

                    </div>

                  </div>';

      }

      // end 


       // modal for extending in test

     $res = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tbltest.test_id=tblpost.custom_id AND tbltest.test_status='Published'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="extendtest'.$row['test_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Extend '.$row['test_type'].' Duration</h4>

                        </div>

                        <div class="modal-body">

                          <form class="form-horizontal form-label-left" action="scripts.php?page=extendtest&id='.$row['test_id'].'&cpid='.$_GET['id'].'" method="POST">

                          <center><p>Extend days for '.$row['test_type'].' #'.$row['test_id'].' - '.$row['test_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Extend Days</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="testDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All test are automatically closed within 11:59 PM of its last date of duration`.</center>

                     




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="Submit" class="btn btn-primary">Confirm</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';

      }

      // end 

        // modal for reopen test

     $res = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tbltest.test_id=tblpost.custom_id AND tbltest.test_status='Closed'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="reopentest'.$row['test_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Reopen '.$row['test_type'].'</h4>

                        </div>

                        <div class="modal-body">

                          <form class="form-horizontal form-label-left" action="scripts.php?page=reopentest&id='.$row['test_id'].'&cpid='.$_GET['id'].'" method="POST">

                          <center><p>Reopen '.$row['test_type'].' #'.$row['test_id'].' - '.$row['test_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Reopen</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="quizDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All tests are automatically closed within 11:59 PM of its last date of duration.</center>

                 





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Confirm</button>

                        </div>

                              </form>

                      </div>

                    </div>

                  </div>';

      }

      // end 

      // modal for publish test


        // modal for reopen test

     $res = mysqli_query($con, "SELECT * FROM tblpost,tbltest WHERE tblpost.cp_id='".$_GET['id']."' AND tbltest.test_id=tblpost.custom_id AND tbltest.test_status='Unpublished'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="publishtest'.$row['test_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Publish '.$row['test_type'].'</h4>

                        </div>

                        <div class="modal-body">

                          <form class="form-horizontal form-label-left" action="scripts.php?page=reopentest&id='.$row['test_id'].'&cpid='.$_GET['id'].'" method="POST">

                          <center><p>Publish '.$row['test_type'].' #'.$row['test_id'].' - '.$row['test_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Reopen</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="quizDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All tests are automatically closed within 11:59 PM of its last date of duration.</center>

                 


                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Confirm</button>

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



        $filter = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.section_id='".$classRow['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");

          $filterRow = mysqli_fetch_array($filter);

          $classperiodID = $filterRow['cp_id'];
          $periodName    = $filterRow['period_name'];
          $periodDesc      = $filterRow['period_desc'];

     $grades = mysqli_query($con, "SELECT * FROM tblgrades,tblstudent WHERE tblgrades.section_id='".$classRow['section_id']."' AND tblgrades.cp_id='".$_GET['id']."' AND tblstudent.student_id=tblgrades.student_id");



            // modal for details  in grade

     while($gradesRow = mysqli_fetch_array($grades)) {

         $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="student'.$gradesRow['student_id'].'">

                        <div class="modal-dialog modal-lg">

                          <div class="modal-content">



                            <div class="modal-header">

                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                              </button>';


                                   $html .='<h4 class="modal-title" id="myModalLabel">'.strtoupper($periodName).' GRADE : '.$gradesRow['student_fname'].' '.$gradesRow['student_lname'].'</h4>';

                              

                           

                            $html .='

                            </div>

                            <div class="modal-body">';


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
                                        <th>Action</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                while($activityRow = mysqli_fetch_array($activity)) {


                                  $submit = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$activityRow['activity_id']."' AND student_id='".$gradesRow['student_id']."'");

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
                                      <td><a href="?page=viewgrade&id='.$activityRow['activity_id'].'" class="btn btn-info btn-sm"><i class="fa fa-arrow-circle-right"></i> View</a></td>
                                    </tr>';





                                }


                                $prgActivity = $myActivityScore / $totalActivityScore;

                                $fnActivity = $prgActivity * $filterRow['grade_activity'];

                                $fnActivity = round($fnActivity, 0);

                                  $html .='</tbody>

                                        </table>

                                '.$gradesRow['student_fname'].' Total Activity Score : '.$myActivityScore.' <br />
                                Total Activity Item Score : '.$totalActivityScore.' <br />
                                <b>Get Activity Score</b> : '.$gradesRow['student_fname'].' Total Activity Score / Total Activity Item Score ; '.$myActivityScore.' / '.$totalActivityScore.' = '.round($prgActivity,1).' <br />
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


                                  $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$quizRow['test_id']."' AND student_id='".$gradesRow['student_id']."'");

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


                                  $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$examRow['test_id']."' AND student_id='".$gradesRow['student_id']."'");

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
                                      <td>'.$totalQCount.'</td>
                                      <td><a href="?page=viewtest&id='.$examRow['test_id'].'" class="btn btn-info btn-sm"><i class="fa fa-arrow-circle-right"></i> View</a></td>
                                    </tr>';





                                }


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

                               // end of exam



                            

                              


                            $html .='</div>

                            <div class="modal-footer">

                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                            </div>

                              </form>


                          </div>

                        </div>

                      </div>';


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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>';


                          $res = mysqli_query($con, "SELECT * FROM tblpost WHERE cp_id='0' AND announcement='Yes' AND section_id='".$classRow['section_id']."' ORDER BY post_datetime DESC");

                          while($row = mysqli_fetch_array($res)) {


                            $html .= '<tr>
                                      <td>'.$row['post_id'].'</td>
                                      <td>'.$row['post_msg'].'</td>
                                      <td>'.timeAgo($row['post_datetime']).'</td>
                                      <td><a class="btn btn-danger" href="scripts.php?page=delan&id='.$row['post_id'].'&cpid='.$_GET['id'].'">Delete</a></td>
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




//asdaq
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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> --> 

                      

                    </ul>

                  </li>';




                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                     <!--  <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                  
                    

                     $html .='
                       </li>

                              <li><a href="?page=viewpost&id='.$_GET['id'].'&cpid='.$_GET['cpid'].'"><i class="fa fa-circle"></i> View Post</a>

                      </li>';



                

                $html .='

             

                </ul>

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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



          $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");




        $countSubmmissions = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod,tblsection WHERE tblclassperiod.cp_id='".$_GET['cpid']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id");



        $classRow = mysqli_fetch_array($res);



        $res = mysqli_query($con, "SELECT * FROM tblpost WHERE post_id='".$_GET['id']."'");



        $postRow = mysqli_fetch_array($res);



        if ($postRow['user_type'] == "Teacher") {





          $headerPost = $_SESSION['fname'].' '.$_SESSION['lname'] .' <i title="Teacher" class="fa fa-check-circle"></i>';



          $img   = $_SESSION['picpath'];



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

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>


            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="x_panel">

                    <div class="x_title">

                      <h2>View Post</h2>

                      

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

                            <span class="message">

                             <h4>'.$postRow['post_msg'].'</h4>

                            </span>

                          </a>

                        </li>

                      </ul>';


                        $videos = "";

                        $images = "";

                        $others = "";

                        $activities = "";

                   

                        if ($postRow['post_type'] == "Activity") {

                          $stud = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$classRow['section_id']."'");

                          $studCount = mysqli_num_rows($stud);

                          
                          $act = mysqli_query($con, "SELECT * FROM tblactivity WHERE post_id='".$_GET['id']."'");

                          $actRow = mysqli_fetch_array($act);

                          $submit = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$actRow['activity_id']."'");

                          $submitCount = mysqli_num_rows($submit);

                          $activities = ' <hr />
                          <h3></u>Activity Information</u></h3>

                          <p><b>Activity Name : </b> '.$actRow['activity_name'].'</p>

                          <p><b>Instructions : </b> '.$actRow['activity_desc'].'</p>

                          <p><b>Duration : </b> '.date("M d, Y", strtotime($actRow['activity_datestart'])).' - '.date("M d, Y", strtotime($actRow['activity_dateend'])).'</p>

                          <p><b>Status : </b> '.$actRow['activity_status'].'</p>

                          <p><b>Total Submitted : </b>'.$submitCount.' / '.$studCount.' students</p>

                          <p><small>All activities are automatically closed on 11:59 PM of its last date</small></p>';


                        } else if ($postRow['post_type'] == "Quiz" || $postRow['post_type'] == "Exam") {

                          $stud = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$classRow['section_id']."'");

                          $studCount = mysqli_num_rows($stud);

                          
                          $act = mysqli_query($con, "SELECT * FROM tbltest WHERE post_id='".$_GET['id']."'");

                          $actRow = mysqli_fetch_array($act);

                          $submit = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$actRow['test_id']."'");

                          $submitCount = mysqli_num_rows($submit);

                          $activities .=' <hr />

                          <h3></u>'.$postRow['post_type'].' Information</u></h3>

                          <p><b>'.$postRow['post_type'].' Name : </b> '.$actRow['test_name'].'</p>

                          <p><b>Instructions : </b> '.$actRow['test_desc'].'</p>

                          <p><b>Days Duration : </b> '.date("M d, Y", strtotime($actRow['test_datestart'])).' - '.date("M d, Y", strtotime($actRow['test_dateend'])).'</p>';

                          if ($actRow['test_status'] == "Published") {

                              $dateNow = date("Y-m-d H:i:s");
                              $dateEnd = date("Y-m-d H:i:s", strtotime($actRow['test_dateend']));

                              if ($dateNow >= $dateEnd) {

                                 $activities .='<p><b>Status : </b> Closed</p>';

                              } else {

                                 $activities .='<p><b>Status : </b> Open</p>';

                              }

                          }


                          $activities .='<p><b>Time Limit : </b> '.$actRow['test_time'].'</p>

                          <p><b>Total Taken : </b>'.$submitCount.' / '.$studCount.' students</p>

                          <p><small>All activities are automatically closed on 11:59 PM of its last date</small></p>

                          <p><a href="?page=viewtest&id='.$actRow['test_id'].'" class="btn btn-info">View Quiz & Scores</a></p>';

                        }


                       if ($postRow['post_files'] != "N/A") {

                        $html .='  <br />
                        <!-- <h4><u>Attachments</u></h4> -->';

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

                    <a href="javascript:fbshareCurrentPage()" class="btn btn-primary btn-sm" target="_blank" alt="Share on Facebook"><i class="fa fa-facebook"></i> Share</a>

                    <!-- <a href="javascript:gshareCurrentPage()" class="btn btn-danger btn-sm" target="_blank" alt="Share on Google"><i class="fa fa-google"></i> Share</a> -->


                    <br />'.$activities.' '.$images.' '.$others.'<br />'.$videos.'
                
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





                            $headerPost = $_SESSION['fname'].' '.$_SESSION['lname'] .' <i title="Teacher" class="fa fa-check-circle"></i>';



                            $img   = $_SESSION['picpath'];



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

                              <img src="'.$img.'" style="width:68px;" alt="img-circle" />

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

                              <span>'.$headerPost.'</span>

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

        <form action="scripts.php?page=reply&id='.$_GET['id'].'&cpid='.$_GET['cpid'].'" method="POST">



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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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


function viewgrade() {



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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> -->

                     

                    </ul>

                  </li>';




                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                     <!--  <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




                       }



                      $html .='</ul>

                    </li>';


                    }

                }


                $html .='


                   </li>

                              <li><a href="?page=viewgrade&id='.$_GET['id'].'"><i class="fa fa-circle"></i> View Grade</a>

                      </li>

                </ul>
                

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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



          $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblpost,tblactivity,tblclassperiod,tblperiod,tblsection WHERE tblpost.custom_id='".$_GET['id']."' AND tblpost.post_type='Activity' AND tblactivity.activity_id=tblpost.custom_id AND tblclassperiod.cp_id=tblpost.cp_id AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id AND tblsection.section_status='Active'");


        $activityRow = mysqli_fetch_array($res);


         $stud = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$activityRow['section_id']."'");

         $studCount = mysqli_num_rows($stud);

         $submit = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$_GET['id']."'");

         $submitCount = mysqli_num_rows($submit);



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>


            <div class="row">

               <div class="col-md-12 col-xs-12">

                <div class="x_panel">

                  <div class="x_title">

                    

                    <h2><a href="?page=classperiod&id='.$activityRow['cp_id'].'">'.$activityRow['period_name'].' - '.$activityRow['section_name'].'</a> / View Activity Grades</h2>

                    

                    <div class="clearfix"></div>

                  </div> <!-- x_title -->

                      <div class="x_content">


                      <p><b>Activity Name :</b> '.$activityRow['activity_name'].'</p>
                      <p><b>Activity Duration :</b> '.date("M d, Y", strtotime($activityRow['activity_datestart'])).' - '.date("M d, Y", strtotime($activityRow['activity_dateend'])).'</p>
                      <p><b>Total Submitted :</b> '.$submitCount.' / '.$studCount.' students</p>
                      <p><b>Activity Status : </b> '.$activityRow['activity_status'].'</p>
                      <p>Maximum score of each activity is 100</p>

                     <!-- <a href="functions/activitygrade.php?&id='.$_GET['id'].'&secid='.$activityRow['section_id'].'" class="btn btn-success"><i class="fa fa-download"></i> Download Activity Gradesheet</a> -->

                      ';

                    

                         $the_folder = 'Activities/Activity'.$_GET['id'];
                         $zip_file_name = 'Activity'.$_GET['id'].'.zip';



                            if(!is_dir($zip_file_name)) {

                                $za = new FlxZipArchive;
                                $res = $za->open($zip_file_name, ZipArchive::CREATE);
                                if($res === TRUE)    {
                                    $za->addDir($the_folder, basename($the_folder)); $za->close();
                                }
                                else  { 

                                  //echo 'Could not create a zip archive';

                                }

                            }


                        $html .=' 

                        <a href="Activity'.$_GET['id'].'.zip" class="btn btn-primary"><i class="fa fa-file-zip-o"></i> Download Activity 1 Submitted Files</a>  

                        <a href="" class="btn btn-info"><i class="fa fa-save"></i> Save Grade Changes</a>

                        <a href="" class="btn btn-success"><i class="fa fa-repeat"></i> Refresh Changes</a>


                        <!-- <form action="scripts.php?page=activitygrade&id='.$_GET['id'].'" enctype="multipart/form-data" method="POST" >

                       
                        <input type="file" name="file" required="required" id="file" class="inputfile inputfile-3" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
                        <label for="file"><i class="fa fa-upload"></i> <small><span> Select Gradesheet</span></small></label>
                        <label id="sgif" style="display:none;"><img src="images/loadgif.gif" width="20" height="20" /></label>

                          <button class="btn btn-success" onclick="showUpload();" type="submit">Upload Grade</button>

                     

                        </form> -->';

                      

                      $html .='<hr />

                      <h2> List of Students Submitted </h3>

                       <table id="studentstable" class="table table-striped table-bordered" width="100%">
                                    <thead>
                                      <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date Submitted</th>
                                        <th>View Submitted</th>
                                        <th>Activity Grade</th>
                                        <th>Activity %</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                    $act = mysqli_query($con, "SELECT * FROM tblsubmit,tblstudent WHERE tblsubmit.activity_id='".$_GET['id']."' AND tblstudent.student_id=tblsubmit.student_id ORDER BY tblsubmit.submit_datetime DESC");

                                    while($actRow = mysqli_fetch_array($act)) {

                                       $html .='

                                      <tr>
                                      <th scope="row"><img src="'.$actRow['student_picpath'].'" width="30" height="30"></th>
                                      <td>'.$actRow['student_fname'].' ' .$actRow['student_lname'].'</td>
                                      <td>'.date("M d, Y g:i A", strtotime($actRow['submit_datetime'])).'</td>
                                      <td>';

                                      // $html .='<a href="Activities/Activity'.$_GET['id'].'/'.$actRow['submit_filepath'].'" target="_blank" class="btn btn-primary btn-sm">View</a>

                                      $ext = pathinfo($actRow['submit_filepath'], PATHINFO_EXTENSION);

                                          if (strtoupper($ext) == "JPG" || strtoupper($ext) == "JPEG" || strtoupper($ext) == "PNG") {

                                             $html .='<a href="?page=viewactivity&id='.$actRow['submit_id'].'&act='.$_GET['id'].'" class="btn btn-primary btn-sm">View</a>';


                                          } else {

                                            
                                             $html .='<a href="Activities/Activity'.$_GET['id'].'/'.$actRow['submit_filepath'].'" target="_blank" class="btn btn-primary btn-sm">View</a>';

                                          }


                                      $html .='</td>
                                      <td>  <div class="progress">';

                                      $prg = $actRow['submit_grade'];

                                    if ($prg < 50) {

                                                      $html .='<div class="progress-bar progress-bar-danger" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';

                                                    } else if ($prg >= 50 && $prg <= 70) {


                                                      $html .='<div class="progress-bar progress-bar-info" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    } else {


                                                      $html .='<div class="progress-bar progress-bar-primary" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    }

                                    $html .='</div></td> <td>

                                    <div class="form-group has-feedback"> 
                                    <input type="number" class="form-control" value="'.$actRow['submit_grade'].'" id="grd'.$actRow['submit_id'].'" onblur="gAct('.$actRow['submit_id'].');" />
                                     <span class="form-control-feedback right" aria-hidden="true">100</span>
                                     </div>';

                                      


                                      $html .='</td>
                                      </tr>';


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


      // modal for creating a new activity

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newActivity">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Create Activity</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left action="#" method="POST">


                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Activity Name</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <input type="text" maxlength="30" required="required" id="activityName" class="form-control" placeholder="Enter activity name here">

                            </div>

                          </div>



                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Activity Instructions</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <textarea class="form-control" id="activityDesc" required="required" placeholder="Enter activity description here" maxlength="160"></textarea>

                            </div>

                          </div>

                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Duration</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" required="required" id="activityDays" class="form-control" value="2">

                            </div>

                          </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission</center>

                          <input type="hidden" value="'.$_GET['id'].'" id="periodID">

                       </form>





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" onclick="clearActivity();" data-dismiss="modal">Close</button>

                          <button type="button" id="btnActivity" class="btn btn-primary" onclick="createActivity();">Create Activity</button>

                        </div>



                      </div>

                    </div>

                  </div>';

      // end


      // modal for extending

     $res = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblactivity.activity_id=tblpost.custom_id AND tblactivity.activity_status='Open'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="extend'.$row['activity_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Extend Activity Duration</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=extendactivity&id='.$row['activity_id'].'&cpid='.$_GET['id'].'" method="POST">

                          <center><p>Extend days for Activity #'.$row['activity_id'].' - '.$row['activity_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Extend Days</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="activityDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission.</center>

                     




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="Submit" class="btn btn-primary">Confirm</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';

      }

      // end 

        // modal for reopen

     $res = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblactivity.activity_id=tblpost.custom_id AND tblactivity.activity_status='Closed'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="reopen'.$row['activity_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Reopen Activity</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=reopenactivity&id='.$row['activity_id'].'&cpid='.$_GET['id'].'" method="POST">

                          <center><p>Reopen Activity #'.$row['activity_id'].' - '.$row['activity_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Reopen</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="activityDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission.</center>

                 





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Confirm</button>

                        </div>

                              </form>

                      </div>

                    </div>

                  </div>';

      }

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li>  -->

                      

                    </ul>

                  </li>';



              

                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                     <!--  <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



          $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);



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

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
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
                                        <th class="hidden-xs">#</th>
                                        <th>Picture</th>
                                        <th>Name</th>
                                        <th class="hidden-xs">Date Joined</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                    $join = mysqli_query($con, "SELECT * FROM tblclass,tblstudent WHERE tblclass.section_id='".$_GET['id']."' AND tblstudent.student_id=tblclass.student_id ORDER BY tblstudent.student_lname ASC");

                                    $cp = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$_GET['id']."' AND class_status='Class President'");

                                    $hasPresident = mysqli_num_rows($cp);

                                    while($joinedRow = mysqli_fetch_array($join)) {

                                       $html .='

                                      <tr>
                                      <th scope="row" class="hidden-xs">'.$joinedRow['student_num'].'</th>
                                      <td><img src="'.$joinedRow['student_picpath'].'" width="30" height="30"></td>
                                      <td><a href="?page=viewstudent&id='.$joinedRow['student_id'].'">'.$joinedRow['student_fname'].' '.$joinedRow['student_lname'].'</a></td>
                                      <td class="hidden-xs">'.timeAgo($joinedRow['class_datejoined']).'</td>';

                                      if ($hasPresident == 0) {


                                        $html .='<td><a href="scripts.php?page=makepresident&id='.$_GET['id'].'&class='.$joinedRow['class_id'].'" class="btn btn-primary btn-sm"><i class="fa fa-check-circle-o"></i> Make President</a></td>';

                                      } else {

                                        if ($joinedRow['class_status'] == "Class President") {
                                                $html .='<td><a href="scripts.php?page=removepresident&id='.$_GET['id'].'&class='.$joinedRow['class_id'].'" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Remove President</a></td>';

                                        } else {

                                                $html .='<td>Student</td>';
                                        }

                                      }




                                      $html .='
                                      <td><button type="button" onclick="delStudent('.$joinedRow['class_id'].');" class="btn btn-danger"><i class="fa fa-remove"></i> Kick</button</td>

                                      </tr>';


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


      // modal for creating a new activity

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="newActivity">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Create Activity</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left action="#" method="POST">


                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Activity Name</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <input type="text" maxlength="30" required="required" id="activityName" class="form-control" placeholder="Enter activity name here">

                            </div>

                          </div>



                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Activity Instructions</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <textarea class="form-control" id="activityDesc" required="required" placeholder="Enter activity description here" maxlength="160"></textarea>

                            </div>

                          </div>

                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Duration</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" required="required" id="activityDays" class="form-control" value="2">

                            </div>

                          </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission</center>

                          <input type="hidden" value="'.$_GET['id'].'" id="periodID">

                       </form>





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" onclick="clearActivity();" data-dismiss="modal">Close</button>

                          <button type="button" id="btnActivity" class="btn btn-primary" onclick="createActivity();">Create Activity</button>

                        </div>



                      </div>

                    </div>

                  </div>';

      // end


      // modal for extending

     $res = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblactivity.activity_id=tblpost.custom_id AND tblactivity.activity_status='Open'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="extend'.$row['activity_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Extend Activity Duration</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=extendactivity&id='.$row['activity_id'].'&cpid='.$_GET['id'].'" method="POST">

                          <center><p>Extend days for Activity #'.$row['activity_id'].' - '.$row['activity_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Extend Days</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="activityDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission.</center>

                     




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="Submit" class="btn btn-primary">Confirm</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';

      }

      // end 

        // modal for reopen

     $res = mysqli_query($con, "SELECT * FROM tblpost,tblactivity WHERE tblpost.cp_id='".$_GET['id']."' AND tblactivity.activity_id=tblpost.custom_id AND tblactivity.activity_status='Closed'");

     while($row = mysqli_fetch_array($res)) {


     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="reopen'.$row['activity_id'].'">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Reopen Activity</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=reopenactivity&id='.$row['activity_id'].'&cpid='.$_GET['id'].'" method="POST">

                          <center><p>Reopen Activity #'.$row['activity_id'].' - '.$row['activity_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Reopen</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="activityDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All activites are automatically closed within 11:59 PM of its last date of submission.</center>

                 





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="submit" class="btn btn-primary">Confirm</button>

                        </div>

                              </form>

                      </div>

                    </div>

                  </div>';

      }

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> --> 

                       <li><a href="?page=search&keyword='.$_GET['keyword'].'">Search Results</a>

                      </li> 

                     

                    </ul>

                  </li>';



                
                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                     <!--  <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);
   



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
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

                        $res = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection WHERE tblpost.post_msg LIKE'%".$keyword."%' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblsection.teacher_id='".$_SESSION['id']."' AND tblsection.section_status='Active'");



                        $hasPosts = mysqli_num_rows($res);

                        if ($hasPosts != 0) {


                          if ($hasSection != 0) {

                                $html .='<li role="presentation"><a href="#tab_content2" id="post-tab" role="tab" data-toggle="tab" aria-expanded="true">Posts('.$hasPosts.')</a>  </li>';

                          } else {

                              $html .='<li role="presentation" class="active"><a href="#tab_content2" id="post-tab" role="tab" data-toggle="tab" aria-expanded="true">Posts('.$hasPosts.')</a>  </li>';

                          }
                         


                        }


                        $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_fname LIKE'%".$keyword."%' OR student_lname LIKE'%".$keyword."%'");

                        $hasStudents = mysqli_num_rows($res);

                        if ($hasStudents != 0) {

                          $html .='<li role="presentation"><a href="#tab_content3" id="student-tab" role="tab" data-toggle="tab" aria-expanded="true">Students('.$hasStudents.')</a>
                        </li>';


                        }

                         $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_fname LIKE'%".$keyword."%' AND teacher_id != '".$_SESSION['id']."' OR teacher_lname LIKE'%".$keyword."%' AND teacher_id != '".$_SESSION['id']."'");

                        $hasTeachers = mysqli_num_rows($res);

                        if ($hasTeachers != 0) {

                          $html .='<li role="presentation"><a href="#tab_content4" id="teacher-tab" role="tab" data-toggle="tab" aria-expanded="true">Teachers('.$hasTeachers.')</a>
                        </li>';


                        }


                      $html .='</ul>
                      <div id="myTabContent" class="tab-content">';

                      if ($hasSection != 0) {

                      $res = mysqli_query($con, "SELECT * FROM tblsection,tblteacher WHERE tblsection.section_code='".$keyword."' AND tblteacher.teacher_id=tblsection.teacher_id");

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

                         
                              
                            $html .='</div>
                          </li>

                          </ul>
                        </div>';

                    }

                    if ($hasPosts != 0) {

                      
                      $res = mysqli_query($con, "SELECT * FROM tblpost,tblclassperiod,tblsection,tblperiod WHERE tblpost.post_msg LIKE'%".$keyword."%' AND tblclassperiod.cp_id=tblpost.cp_id AND tblsection.section_id=tblclassperiod.section_id AND tblsection.teacher_id='".$_SESSION['id']."' AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_status='Active' ORDER BY tblpost.post_datetime DESC");


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

                           $html .='

                            </ul>
                          </div>';

                    }


                     if ($hasStudents != 0) {

                      
                      $res = mysqli_query($con, "SELECT * FROM tblstudent WHERE student_fname LIKE'%".$keyword."%' OR student_lname LIKE'%".$keyword."%'");
                  

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!--<li><a href="?page=createperiod">Create Period</a>

                      </li>-->  

                      

                    </ul>

                  </li>';



                    
                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                     <!--  <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);
   


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

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
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

                    


                      $html .='<div class="profile_img">

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> -->

                     

                    </ul>

                  </li>';



                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                     <!--  <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);
   

        
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

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
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
                          <h2>Overall Subject Grade Performance</h2>
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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> --> 

                     

                    </ul>

                  </li>';



             
                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                   <!--    <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);
   


        $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id='".$_SESSION['id']."'");

        $userRow = mysqli_fetch_array($res);



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>

             <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Profile<small>My Profile</small></h2>
                   
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

                    


                      $html .='<div class="profile_img">

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
                          <h2>My Subjects Highest Grade Attainment</h2>
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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> --> 

                    

                    </ul>

                  </li>';

                    

                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                     <!--  <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);
   



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
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

                        $res = mysqli_query($con, "SELECT * FROM tblconversation WHERE myuser_id='".$_SESSION['id']."' AND myuser_type='teacher' ORDER BY conversation_status DESC");

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> -->

                     

                    </ul>

                  </li>';



                
                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                      <!-- <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




                       }



                      $html .='</ul>

                    </li>';


                    }

                }
                  


                  
                    

                     $html .='
                       </li>

                              <li><a href=""><i class="fa fa-circle"></i> View Test</a>

                      </li>

                </ul>

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




        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



          $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");




        $countSubmmissions = mysqli_num_rows($res);

        $res = mysqli_query($con, "SELECT * FROM tbltest,tblpost,tblclassperiod,tblperiod,tblsection WHERE tbltest.test_id='".$_GET['id']."' AND tblpost.post_id=tbltest.post_id AND tblclassperiod.cp_id=tblpost.cp_id AND tblperiod.period_id=tblclassperiod.period_id AND tblsection.section_id=tblclassperiod.section_id AND tblsection.section_status='Active'");

        $testRow = mysqli_fetch_array($res);

        $filepath = "";

        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>


            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>




             <div class="row">
              <div class="col-md-12">
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
                      <br />

                     
                     
                       <h4><u>Students Results</u></h4>
                       <br />';


                        $taken = mysqli_query($con, "SELECT * FROM tbltaken,tblstudent WHERE tbltaken.test_id='".$_GET['id']."' AND tblstudent.student_id=tbltaken.student_id");

                        $hasTaken = mysqli_num_rows($taken);

                          $dateNow = date("Y-m-d H:i:s");
                          $dateEnd = date("Y-m-d H:i:s", strtotime($testRow['test_dateend']));

                          $items = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$_GET['id']."'");

                          $totalItems = mysqli_num_rows($items);

                         


                        if ($hasTaken == 0) {

                          $html .='Results will be shown after your students finish the test.';

                        } else {

                       

                          

                            $html .='
                             <table id="studentstable" class="table table-striped dt-responsive nowrap table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                        <th width="10%">#</th>
                                        <th>Student</th>
                                        <th width="10%">Score</th>
                                        <th>Grade</th>
                                        <th width="10%">Actions</th>
                                      </tr>
                                    </thead>

                                    <tbody>';


                                    while($takenRow = mysqli_fetch_array($taken)) {

                                      

                                      $correct = mysqli_query($con, "SELECT * FROM tblanswer WHERE answered_status='Correct' AND test_id='".$_GET['id']."' AND student_id='".$takenRow['student_id']."'");

                                      $correctNum = mysqli_num_rows($correct);

                                      $prg = ($correctNum / $totalItems) * 100;

                                      $prg = round($prg, 0);


                                      $html .='

                                        <tr>
                                        <td width="10%"><center><img src="'.$takenRow['student_picpath'].'" width="40" height="40"></center></td>
                                        <td>'.$takenRow['student_fname'].' '.$takenRow['student_lname'].'</td>
                                        <td width="10%">'.$correctNum.' / '.$totalItems.'</td>
                                        <td><div class="progress">';

                                          if ($prg < 50) {

                                                      $html .='<div class="progress-bar progress-bar-danger" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';

                                                    } else if ($prg >= 50 && $prg <= 70) {


                                                      $html .='<div class="progress-bar progress-bar-info" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    } else {


                                                      $html .='<div class="progress-bar progress-bar-primary" data-transitiongoal="'.$prg.'">'.$prg.'%</div>';
                                                    }


                                              // <div class="progress-bar progress-bar-info" data-transitiongoal="'.$prg.'">'.$prg.'%</div>
                                        $html .='</div></td>
                                        <td width="10%"><a href="#view'.$takenRow['taken_id'].'" data-toggle="modal" class="btn btn-info">View</a></td>';


                                    }


                                    $html .='</tbody>
                                    </table>';
                          


                        }
                      



                        



                      $html .='<div>


                      <hr />

                       <h4><u>Question Correctness Percentage</u></h4>

                       <br />
                      
                             <table id="questionstable" class="table table-striped dt-responsive nowrap table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                        <th>Format</th>
                                        <th>#</th>
                                        <th>Question</th>
                                        <th>Correct Answer</th>
                                        <th>% Students Correct</th>
                                      </tr>
                                    </thead>

                                    <tbody>';

                                    $ques = mysqli_query($con, "SELECT * FROM tblquestion WHERE test_id='".$_GET['id']."'");

                                    $q = 1;

                                    while($quesRow = mysqli_fetch_array($ques)) {

                                      

                                      $correct = mysqli_query($con, "SELECT * FROM tblanswer WHERE answered_status='Correct' AND test_id='".$_GET['id']."' AND question_id='".$quesRow['question_id']."'");

                                       $correctNum = mysqli_num_rows($correct);

                                      $ans = mysqli_query($con, "SELECT * FROM tblanswer WHERE test_id='".$_GET['id']."' AND question_id='".$quesRow['question_id']."'");

                                      $totalAns = mysqli_num_rows($ans);

                                      if ($totalAns != 0) {

                                      $prg = ($correctNum / $totalAns) * 100;

                                      $prg = round($prg, 0);

                                      } else {

                                        $prg = 0;

                                      }

                                      $html .='

                                        <tr>
                                        <td>'.$quesRow['tFormat'].'</td>
                                        <td>'.$q.'</td>
                                        <td>'.$quesRow['question'].'</td>
                                        <td>'.$quesRow['correct_ans'].'</td>
                                        <td><div class="progress">
                                              <div class="progress-bar progress-bar-success" data-transitiongoal="'.$prg.'">'.$prg.'%</div>
                                            </div></td>';


                                        $q += 1;

                                    }


                                    $html .='</tbody>
                                    </table>';
                       


                       


                      $html .='
                      </div>


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
                            <p>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</p>
                            <p class="title">'.$testRow['test_type'].' Name</p>
                            <p><a href="#editname" data-toggle="modal" title="Edit '.$testRow['test_type'].' Name"><i class="fa fa-pencil"></i></a> '.$testRow['test_name'].'</p>
                            <p class="title">Time Duration</p>
                            <p>'.$testRow['test_time'].' mins</p>
                            <p class="title">'.$testRow['test_type'].' Format</p>
                            <p>'.$testRow['test_format'].'</p>
                            <p class="title">Started</p>';

                            if ($testRow['test_status'] != "Unpublished") {

                              $html .=' <p title="Started on '.date("M d, Y g:i A", strtotime($testRow['test_datestart'])).'">'.timeAgo($testRow['test_datestart']).'</p>';

                            } else {

                               $html .=' <p>Not Yet Publish</p>';
                            }

                           
                            
                            $html .='<p class="title">Deadline</p>';

                             if ($testRow['test_status'] != "Unpublished") {

                                $html .='<p>'.date("M d, Y g:i A", strtotime($testRow['test_dateend'])).'</p>';

                            } else {

                               $html .=' <p>Not Yet Publish</p>';
                            }

                         

                            if ($testRow['test_status'] == "Published") {

                              $html .='<a href="#extend" data-toggle="modal" class="btn btn-primary btn-sm">Extend</a>';

                            } else if ($testRow['test_status'] == "Closed") {

                               $html .='<a href="#reopen" data-toggle="modal" class="btn btn-info btn-sm">Reopen</a>';


                            } else if ($testRow['test_status'] == "Unpublished") {

                               $html .='<a href="#publish" data-toggle="modal" class="btn btn-info btn-sm">Publish Now</a>';

                            }

                             if ($testRow['test_peek'] == "Yes") {


                            $html .='<a href="scripts.php?page=nopeek&id='.$_GET['id'].'" class="btn btn-info btn-sm">Disable Peek Results</a>';

                             } else {
                              $html .='<a href="scripts.php?page=yespeek&id='.$_GET['id'].'" class="btn btn-success btn-sm">Enable Peek Results</a>';


                              }

                              $html .='<hr />';

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

    if ($testRow['test_status'] == "Published") {

            // modal for extending in quiz

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="extend">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Extend '.$testRow['test_type'].' Duration</h4>

                        </div>

                        <div class="modal-body">

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=extendtest&id='.$_GET['id'].'" method="POST">

                          <center><p>Extend days for '.$testRow['test_type'].' #'.$testRow['test_id'].' - '.$testRow['test_name'].'</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Extend Days</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="number" name="days" required="required" id="testDays" class="form-control" value="1">

                            </div>

                          </div>


                          <center>All tests are automatically closed within 11:59 PM of its last date of duration`.</center>

                     




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="Submit" class="btn btn-primary">Confirm</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';

                     // end 

      } else if ($testRow['test_status'] == "Closed") {


             $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="reopen">

                            <div class="modal-dialog modal-sm">

                              <div class="modal-content">



                                <div class="modal-header">

                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                                  </button>

                                  <h4 class="modal-title" id="myModalLabel">Reopen '.$testRow['test_type'].'</h4>

                                </div>

                                <div class="modal-body">

                                  <form class="form-horizontal form-label-left" action="scripts.php?page=reopentest&id='.$_GET['id'].'" method="POST">

                                  <center><p>Reopen '.$testRow['test_type'].' #'.$row['test_id'].' - '.$row['test_name'].'</p></center>
                                  
                                   <div class="form-group">

                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Reopen</label>

                                    <div class="col-md-9 col-sm-9 col-xs-12">

                                       <input type="number" name="days" required="required" id="quizDays" class="form-control" value="1">

                                    </div>

                                  </div>


                                  <center>All tests are automatically closed within 11:59 PM of its last date of duration.</center>

                         





                                </div>

                                <div class="modal-footer">

                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                  <button type="submit" class="btn btn-primary">Confirm</button>

                                </div>

                                      </form>

                              </div>

                            </div>

                          </div>';


      // end 

      } else if ($testRow['test_status'] == "Unpublished") {

           $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="publish">

                            <div class="modal-dialog modal-sm">

                              <div class="modal-content">



                                <div class="modal-header">

                                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                                  </button>

                                  <h4 class="modal-title" id="myModalLabel">Publish '.$testRow['test_type'].'</h4>

                                </div>

                                <div class="modal-body">

                                  

                                  <form class="form-horizontal form-label-left" action="scripts.php?page=publishtest&id='.$_GET['id'].'" method="POST">

                                  <center><p>Publish '.$testRow['test_type'].' #'.$testRow['test_id'].' - '.$testRow['test_name'].'</p></center>
                                  
                                   <div class="form-group">

                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Days Duration</label>

                                    <div class="col-md-9 col-sm-9 col-xs-12">

                                       <input type="number" name="days" required="required" id="quizDays" class="form-control" value="1">

                                    </div>

                                  </div>


                                  <center>All tests are automatically closed within 11:59 PM of its last date of duration.</center>

                         





                                </div>

                                <div class="modal-footer">

                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                  <button type="submit" class="btn btn-primary">Confirm</button>

                                </div>

                                      </form>

                              </div>

                            </div>

                          </div>';


      // end 


      }

             // modal for editing name

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="editname">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Edit '.$testRow['test_type'].' Name</h4>

                        </div>

                        <div class="modal-body">



                          <div id="activityMsg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left" action="scripts.php?page=updatetestname&id='.$_GET['id'].'" method="POST">

                          <center><p>Edit '.$testRow['test_type'].' Name</p></center>
                          
                           <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Edit Name</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                               <input type="text" name="name" required="required" id="testName" class="form-control" value="'.$testRow['test_name'].'">

                            </div>

                          </div>

                     




                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="Submit" class="btn btn-primary">Confirm</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';

                     // end 

          $taken = mysqli_query($con, "SELECT * FROM tbltaken,tblstudent WHERE tbltaken.test_id='".$_GET['id']."' AND tblstudent.student_id=tbltaken.student_id");

          while($takenRow = mysqli_fetch_array($taken)) {


              $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="view'.$takenRow['taken_id'].'">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">View '.$takenRow['student_fname'].' '.$takenRow['student_lname'].' Answered</h4>

                        </div>

                        <div class="modal-body">
                          
                          <h5>Date and Time Taken : '.date("M d, Y g:i A", strtotime($takenRow['datetime_taken'])).'</h5>';


                           $essay = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$takenRow['student_id']."' AND tblquestion.tFormat='Essay' AND tblquestion.question_id=tblanswer.question_id ORDER BY tblquestion.question_id ASC");

                           $essayCount = mysqli_num_rows($essay);

                           if ($essayCount != 0) {


                              $html .='<h4>Essay</h4>
                                        <table class="table table-striped table-bordered" width="100%">

                                      <thead>
                                        <tr>
                                          <th>#</th>
                                          <th>Question</th>
                                          <th>Answered</th>
                                          <th>Points</th>
                                        </tr>
                                      </thead>

                                      <tbody>';

                                 $q = 1;


                                while ($essayRow = mysqli_fetch_array($essay)) {


                                    $html .='
                                    <tr>
                                    <td>'.$q.'</td>
                                    <td>'.$essayRow['question'].'</td>
                                    <td>'.$essayRow['student_answered'].'</td>';

                                      $html .='<td>
                                    <select id="'.$essayRow['answer_id'].'" class="form-control" onchange="saveEssay('.$essayRow['answer_id'].');">';


                                       // <select id="'.$essayRow['answer_id'].'" class="form-control" onchange="saveEssay('.$essayRow['answer_id'].');">

                                    $maxpts = $essayRow['points'];

                                    for($p = 0; $p <= $maxpts; $p++) {

                                      if ($essayRow['answered_pt'] == $p) {

                                        $html .='<option value="'.$p.'" selected>'.$p.'</option>';

                                      } else {

                                        $html .='<option value="'.$p.'">'.$p.'</option>';

                                      }

                                    }

                                     $html .='</select></td>


                                    </tr>';


                                    $q++;


                                 }


                                      

                                $html .='</tbody>

                                      </table>';


                           }


                          $ques = mysqli_query($con, "SELECT * FROM tblanswer,tblquestion WHERE tblanswer.test_id='".$_GET['id']."' AND tblanswer.student_id='".$takenRow['student_id']."' AND tblquestion.tFormat != 'Essay' AND tblquestion.question_id=tblanswer.question_id ORDER BY tblquestion.question_id ASC");


                          $qCount = mysqli_num_rows($ques);


                          if ($qCount != 0) {


                                $q = 1;

                              $html .='

                              <hr />

                              <table class="table table-striped table-bordered" width="100%">

                                <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Answered</th>
                                    <th>Status</th>
                                    <th>Points</th>
                                  </tr>
                                </thead>

                                <tbody>';

                                while($quesRow = mysqli_fetch_array($ques)) {

                                    $html .='
                                      <tr>
                                      <td>'.$q.'</td>
                                      <td>'.$quesRow['question'].'</td>
                                      <td>'.$quesRow['student_answered'].'</td>
                                      <td>'.$quesRow['answered_status'].'</td>
                                      <td>'.$quesRow['points'].'</td>
                                      </tr>';

                                      $q++;

                                }


                            $html .='</tbody>

                                </table>';




                          }



                              // <a href="scripts.php?page=essaygrade&id='.$_GET['id'].'&student='.$takenRow['student_id'].'" class="btn btn-success">Save Grade</a>
                        $html .='</div>

                        <div class="modal-footer">

                        <a href="scripts.php?page=essaygrade&id='.$_GET['id'].'&student='.$takenRow['student_id'].'" class="btn btn-success">Save Grade</a>

                          <!-- <button type="button" data-dismiss="modal" class="btn btn-success">Save Grade</button> -->
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';


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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> -->

                     
                    </ul>

                  </li>';



                
                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                      <!-- <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




                       }



                      $html .='</ul>

                    </li>';


                    }

                }

                $html .=' 

                           <li><a href=""><i class="fa fa-circle"></i> View Grades</a>

                      </li>

            
                </ul>

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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



          $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");




        $countSubmmissions = mysqli_num_rows($res);

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

        $stud = mysqli_query($con, "SELECT * FROM tblclass WHERE section_id='".$_GET['id']."'");

        $studentCount = mysqli_num_rows($stud);



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

             <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>


            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>




             <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View Grades</h2>
                   
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
                          <span class="name"> Total Students </span>
                          <span class="value text-success"> '.$studentCount.' </span>
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
                              $overAllPercentage = 100 - $_SESSION['basegrade'];


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


                        $grade = mysqli_query($con, "SELECT * FROM tblgrades,tblstudent WHERE tblgrades.cp_id='".$classperiodID."' AND tblgrades.section_id='".$_GET['id']."' AND tblstudent.student_id=tblgrades.student_id");


                        $gradeCount = mysqli_num_rows($grade);
                         


                        if ($gradeCount == 0) {

                          $html .='No grades to be shown';

                        } else {

                       
                          if ($classperiodID != 0) {
                          

                            $html .='
                             <table id="studentstable" class="table table-striped dt-responsive nowrap table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                        <th width="10%">#</th>
                                        <th>Name</th>
                                        <th>Act '.$filterRow['grade_activity'].'%</th>
                                        <th>Quiz '.$filterRow['grade_quiz'].'%</th>
                                        <th>Exam '.$filterRow['grade_exam'].'%</th>
                                        <th><center>'.strtoupper($periodName).' GRADE</center></th>
                                        <th width="10%" class="hidden-xs">Action</th>
                                      </tr>
                                    </thead>

                                    <tbody>';


                                    $basegrade = $_SESSION['basegrade'];

                                    while($gradeRow = mysqli_fetch_array($grade)) {

                                      

                                     


                                      $html .='

                                        <tr>
                                        <td width="10%"><center><img src="'.$gradeRow['student_picpath'].'" width="40" height="40"></center></td>
                                        <td>'.$gradeRow['student_fname'].' '.$gradeRow['student_lname'].'</td>
                                        <td>'.$gradeRow['activity_grade'].'</td>
                                        <td>'.$gradeRow['quiz_grade'].'</td>
                                        <td>'.$gradeRow['exam_grade'].'</td>
                                        <td width="30%"><div class="progress">';
                                                   

                                            if ($gradeRow['total_grade'] < 50) {

                                              $html .='<div class="progress-bar progress-bar-danger" data-transitiongoal="'.$gradeRow['total_grade'].'">'.$gradeRow['total_grade'].'%</div>';

                                            } else if ($gradeRow['total_grade'] >= 50 && $gradeRow['total_grade'] <= 70) {


                                              $html .='<div class="progress-bar progress-bar-info" data-transitiongoal="'.$gradeRow['total_grade'].'">'.$gradeRow['total_grade'].'%</div>';
                                            } else {


                                              $html .='<div class="progress-bar progress-bar-primary" data-transitiongoal="'.$gradeRow['total_grade'].'">'.$gradeRow['total_grade'].'%</div>';
                                            }
                                            
                                            $html .='</div></td>
                                        <td width="10%" class="hidden-xs"><a href="#student'.$gradeRow['student_id'].'" class="btn btn-success" data-toggle="modal">View</a></td>
                                       </tr>';


                                    }


                                    $html .='</tbody>
                                    </table>';


                          } else {


                             $html .='
                             <table id="studentstable" class="table table-striped dt-responsive nowrap table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                        <th width="10%">#</th>
                                        <th>Name</th>';


                                        $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblclassperiod.cp_id ASC");

                                        while($pRow = mysqli_fetch_array($p)) {


                                          $html .='<th>'.ucfirst($pRow['period_name']).' '.$pRow['period_grade'].'%</th>';

                                        }


                                        $html .='<th><center>'.strtoupper($periodName).' GRADE</center></th>
                                        <th width="10%" class="hidden-xs">Action</th>
                                      </tr>
                                    </thead>

                                    <tbody>';



                                    while($gradeRow = mysqli_fetch_array($grade)) {

                                      

                                      $html .='

                                        <tr>
                                        <td width="10%"><center><img src="'.$gradeRow['student_picpath'].'" width="40" height="40"></center></td>
                                        <td>'.$gradeRow['student_fname'].' '.$gradeRow['student_lname'].'</td>';

                                         $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblclassperiod.cp_id ASC");

                                          $ovg = 0;

                                        while($pRow = mysqli_fetch_array($p)) {


                                          $g = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='".$pRow['cp_id']."' AND student_id='".$gradeRow['student_id']."'");

                                          $gCount = mysqli_num_rows($g);

                                          if ($gCount == 0) {

                                            $html .='<td>0</td>';

                                          } else {

                                            $gRow = mysqli_fetch_array($g);

                                            $html .='<td>'.round((($gRow['total_grade'] / 100) * $pRow['period_grade']),1).'</td>';

                                            $ovg += round((($gRow['total_grade'] / 100) * $pRow['period_grade']),1);

                                          }

                                         

                                        }
                                        
                                        $html .='<td><div class="progress">';

                                            
                                           if ($ovg < 50) {

                                              $html .='<div class="progress-bar progress-bar-danger" data-transitiongoal="'.$ovg.'">'.$ovg.'%</div>';

                                            } else if ($ovg >= 50 && $ovg <= 70) {


                                              $html .='<div class="progress-bar progress-bar-info" data-transitiongoal="'.$ovg.'">'.$ovg.'%</div>';
                                            } else {


                                              $html .='<div class="progress-bar progress-bar-primary" data-transitiongoal="'.$ovg.'">'.$ovg.'%</div>';
                                            }


                                              // <div class="progress-bar progress-bar-info" data-transitiongoal="'.($gradeRow['total_grade'] + $_SESSION['basegrade']).'">'.($gradeRow['total_grade'] + $_SESSION['basegrade']).'%</div>
                                        $html .='</div></td>
                                        <td width="10%" class="hidden-xs"><a href="#student'.$gradeRow['student_id'].'" class="btn btn-success" data-toggle="modal">View</a></td>
                                       </tr>';


                                       //  $html .='<td><div class="progress">
                                       //        <div class="progress-bar progress-bar-info" data-transitiongoal="'.($gradeRow['total_grade'] + $_SESSION['basegrade']).'">'.($gradeRow['total_grade'] + $_SESSION['basegrade']).'%</div>
                                       //      </div></td>
                                       //  <td width="10%" class="hidden-xs"><a href="#student'.$gradeRow['student_id'].'" class="btn btn-success" data-toggle="modal">View</a></td>
                                       // </tr>';


                                    }


                                    $html .='</tbody>
                                    </table>';



                          }
                          


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

                          <form method="POST" action="scripts.php?page=savegrade&id='.$_GET['id'].'" onsubmit="return validateForm()">

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
                          <p><input type="number" class="form-control" id="aGrade" name="aGrade" required="required" placeholder="Enter activity percentage here" value="'.$filterRow['grade_activity'].'"></p>
                          <p class="title">Quiz %</p>
                          <p><input type="number" class="form-control" id="qGrade" name="qGrade" required="required" placeholder="Enter quiz percentage here" value="'.$filterRow['grade_quiz'].'"></p>
                          <p class="title">Exam %</p>
                          <p><input type="number" class="form-control" id="eGrade" name="eGrade" required="required" placeholder="Enter exam percentage here" value="'.$filterRow['grade_exam'].'"></p>

                          <p>All 3 values at the top must sum up to 100%</p>

                           <input type="hidden" value="'.$_SESSION['basegrade'].'" id="bGrade" name="bGrade">';


                          } else {


                            $list = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblclassperiod.cp_id ASC");

                            $p = 0;

                            while($listRow = mysqli_fetch_array($list)) {

                                $html .='<p class="title">'.ucfirst($listRow['period_name']).' %</p>
                                <p><input type="number" class="form-control" id="pGrade'.$p.'" name="pGrade'.$listRow['cp_id'].'" required="required" placeholder="Enter period grade here" value="'.$listRow['period_grade'].'"></p>';

                                $p += 1;


                            }

                            $html .='<p>All period grade values must sum up to 100%</p> <br /> <br />

                            <!--<p class="title">Base Grade</p>-->
                            <p><input type="number" class="form-control" style="display:none;" required="required" id="bGrade" name="bGrade" value="'.$_SESSION['basegrade'].'"></p>

                            <input type="hidden" value="'.$p.'" id="tpid" name="tpid">';


                          }


                            $html .=' <input type="hidden" value="'.$classperiodID.'" id="cpi" name="cpid">

                            <input type="submit" class="btn btn-danger" value="Save Changes">

                            </form>
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

     


     $grades = mysqli_query($con, "SELECT * FROM tblgrades,tblstudent WHERE tblgrades.section_id='".$_GET['id']."' AND tblgrades.cp_id='".$classperiodID."' AND tblstudent.student_id=tblgrades.student_id");



            // modal for details  in grade

     while($gradesRow = mysqli_fetch_array($grades)) {

     $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="student'.$gradesRow['student_id'].'">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>';

                          if ($classperiodID == 0) {


                               $html .='<h4 class="modal-title" id="myModalLabel">OVERALL GRADE : '.$gradesRow['student_fname'].' '.$gradesRow['student_lname'].'</h4>';


                          } else {

                               $html .='<h4 class="modal-title" id="myModalLabel">'.strtoupper($periodName).' GRADE : '.$gradesRow['student_fname'].' '.$gradesRow['student_lname'].'</h4>';

                          }

                       

                        $html .='

                        </div>

                        <div class="modal-body">';


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


                                    $pScore = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='".$periodsRow['cp_id']."' AND student_id='".$gradesRow['student_id']."'");

                                    $pScoreRow = mysqli_fetch_array($pScore);


                                
                                      $html .='

                                        <tr>
                                        <td width="10%"><center><img src="'.$gradesRow['student_picpath'].'" width="30" height="30"></center></td>
                                        <td>'.$gradesRow['student_fname'].' '.$gradesRow['student_lname'].'</td>
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


                          // $html .='<h4><u>OVERALL PERIOD GRADE</u></h4>

                          // <p>Highest applicable grade is 100%, we have to subtract the 100% to the current base grade and get its percentage and sum it to all period grades</p>

                          // BASE GRADE :'.$_SESSION['basegrade'].'% <br />
                          // OVERALL PERIOD % EQUIVALENT : 100% - '.$_SESSION['basegrade'].'% = <b>'.(100 - $_SESSION['basegrade']).'%</b> <br />
                          // <!-- OVERALL GRADE : ( (SUM OF ALL PERIOD GRADES / 100) X OVERALL PERIOD % EQUIVALENT ) + BASE GRADE % <i>See Below;</i> <br /> -->

                          // OVERALL GRADE : ( (SUM OF ALL PERIOD GRADES / 100) X OVERALL PERIOD % EQUIVALENT ) <i>See Below;</i> <br />

                          // ( (';

                          $html .='<h4><u>OVERALL PERIOD GRADE</u></h4>

                    

                          BASE GRADE :'.$_SESSION['basegrade'].'% <br />
                          OVERALL PERIOD % EQUIVALENT : 100% <br />
                           <!-- OVERALL GRADE : ( (SUM OF ALL PERIOD GRADES / 100) X OVERALL PERIOD % EQUIVALENT ) + BASE GRADE % <i>See Below;</i> <br /> -->

                         OVERALL GRADE : ( (SUM OF ALL PERIOD GRADES / 100) X OVERALL PERIOD % EQUIVALENT ) <i>See Below;</i> <br />

                           ( (';

                          $oScore = mysqli_query($con, "SELECT * FROM tblgrades,tblclassperiod WHERE tblgrades.section_id='".$_GET['id']."' AND tblgrades.student_id='".$gradesRow['student_id']."' AND tblclassperiod.cp_id=tblgrades.cp_id ORDER BY tblgrades.cp_id ASC");

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
                                    <th>Action</th>
                                  </tr>
                                </thead>

                                <tbody>';

                            while($activityRow = mysqli_fetch_array($activity)) {


                              $submit = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$activityRow['activity_id']."' AND student_id='".$gradesRow['student_id']."'");

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
                                  <td><a href="?page=viewgrade&id='.$activityRow['activity_id'].'" class="btn btn-info btn-sm"><i class="fa fa-arrow-circle-right"></i> View</a></td>
                                </tr>';





                            }


                            $prgActivity = $myActivityScore / $totalActivityScore;

                            $fnActivity = $prgActivity * $filterRow['grade_activity'];

                            $fnActivity = round($fnActivity, 0);

                              $html .='</tbody>

                                    </table>

                            '.$gradesRow['student_fname'].' Total Activity Score : '.$myActivityScore.' <br />
                            Total Activity Item Score : '.$totalActivityScore.' <br />
                            <b>Get Activity Score</b> : '.$gradesRow['student_fname'].' Total Activity Score / Total Activity Item Score ; '.$myActivityScore.' / '.$totalActivityScore.' = '.round($prgActivity,1).' <br />
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


                              $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$quizRow['test_id']."' AND student_id='".$gradesRow['student_id']."'");

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


                              $taken = mysqli_query($con, "SELECT * FROM tbltaken WHERE test_id='".$examRow['test_id']."' AND student_id='".$gradesRow['student_id']."'");

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

                           // end of exam



                        }

                          


                        $html .='</div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>

                          </form>


                      </div>

                    </div>

                  </div>';


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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                      <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> -->


                    </ul>

                  </li>';



                   $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                   <!--    <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);
   
        $section = mysqli_query($con, "SELECT * FROM tblsection WHERE section_id='".$_GET['id']."'");

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

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
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


                                           $r = mysqli_query($con, "SELECT * FROM tblreply WHERE post_id='".$cpRow['post_id']."'");



                                        $rCount = mysqli_num_rows($r);




                                        if ($cpRow['user_type'] == "Teacher") {





                                          $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> Posted by <a href="?page=myprofile">'.$_SESSION['fname'].' '.$_SESSION['lname'].'</a> <i title="Teacher" class="fa fa-check-circle"></i>';



                                        } else {



                                         
                                          $s = mysqli_query($con, "SELECT * FROM tblstudent,tblclass WHERE tblstudent.student_id='".$cpRow['user_id']."' AND tblclass.student_id=tblstudent.student_id AND tblclass.section_id='".$_GET['id']."'");



                                          $sRow = mysqli_fetch_array($s);

                                          if ($sRow['class_status'] == "Class President") {



                                               $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> <br />Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="Class President" class="fa fa-check-circle-o"></i>';


                                          } else {

                                               $headerPost = '<b>['.strtoupper($cpRow['period_name']).']</b> <br />Posted by <a href="?page=viewstudent&id='.$sRow['student_id'].'">'.$sRow['student_fname'].' '.$sRow['student_lname'].'</a> <i title="X Class President" class="fa fa-remove"></i>';

                                          }


                                        }

                                      $isDisplay = true;

                                      if ($cpRow['post_type'] == "Quiz" || $cpRow['post_type'] == "Exam") {

                                        $test = mysqli_query($con, "SELECT * FROM tbltest WHERE test_id='".$cpRow['custom_id']."'");

                                        $testRow = mysqli_fetch_array($test);

                                      


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

                                                <div class="block_content">

                                                  

                                                    <ul class="nav navbar-right panel_toolbox">
                                                      <li><a href="#" data-toggle="modal" onclick="editPost('.$cpRow['post_id'].');" data-target="#editFields"><i class="fa fa-edit"></i></a></li>
                                                        <li><a onclick="removePost('.$cpRow['post_id'].');"><i class="fa fa-remove" title="Remove Post"></i></a>
                                                          </li>
                                                    </ul>

                                                    '.$postContent.'

                                                  <div class="byline">

                                                    <span title="Posted at '.date('F d, Y g:i A', strtotime($cpRow['post_datetime'])).'">'.$sectionRow['section_name'].' - '.$sectionRow['desc'].' '.timeAgo($cpRow['post_datetime']).'</span>

                                                  </div>';


                                                  if ($cpRow['post_files'] == "N/A") {


                                                    if ($cpRow['post_type'] == "Activity") {

                                                        $actRes = mysqli_query($con, "SELECT * FROM tblsubmit WHERE activity_id='".$cpRow['custom_id']."'");

                                                        $aCount = mysqli_num_rows($actRes);

                                                        $html .=' <p><a href="?page=viewgrade&id='.$cpRow['custom_id'].'">View Submissions('.$aCount.')</a> | <a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$cpRow['cp_id'].'">View Replies('.$rCount.')</a></p>';


                                                    } else {



                                                      if ($cpRow['post_type'] == "Post") {



                                                        $html .=' <p><a href="?page=viewpost&id='.$cpRow['post_id'].'&cpid='.$_GET['id'].'">View Replies ('.$rCount.')</a></p>';

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
                            <p>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</p>

                            <p class="title">Class President</p>
                            <p>'.$classPresident.'</p>
                            <p class="title">Total Students</p>
                            <p>'.$classStudCount.'</p>

                            <br />

                            <button type="button" onclick="delClass();" class="btn btn-danger"><i class="fa fa-remove"></i> Delete Class</button>
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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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

function viewactivity() {



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

                <span>Welcome,</span>

                <h2>'.$_SESSION['fname'].' '.$_SESSION['lname'].'</h2>

              </div>

            </div>

            <!-- /menu profile quick info -->



            <br />



            <!-- sidebar menu -->

            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu menu_fixed">

              <div class="menu_section">

                <h3>Teacher</h3>

                <ul class="nav side-menu">

                  <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>

                    <ul class="nav child_menu">

                    <li><a href="teacher.php">Dashboard</a>

                    </li>

                      <li><a href="?page=createclass">Create Class</a>

                      </li>

                     <!-- <li><a href="?page=createperiod">Create Period</a>

                      </li> -->

                     

                    </ul>

                  </li>';



                $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."' AND section_status='Active' ORDER BY section_desc ASC");

                $newName = "";

                while($row = mysqli_fetch_array($res)) {

                  $isAdd = true;

                            if ($newName == "") {

                                $newName = $row['section_desc'];


                            } else {

                                if ($newName == $row['section_desc']) {

                                  $isAdd = false;

                                } 


                                $newName = $row['section_desc'];
                            }


                    if ($isAdd == true) {


                       $html .='  <li><a><i class="fa fa-edit"></i> '.$row['section_desc'].' <span class="fa fa-chevron-down"></span></a>

                      <ul class="nav child_menu">';

                      $p = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");

                      $pRow = mysqli_fetch_array($p);


                       $res1 = mysqli_query($con, "SELECT * FROM tblsection WHERE section_desc='".$row['section_desc']."' AND teacher_id='".$_SESSION['id']."'");

                       while($row1 = mysqli_fetch_array($res1)) {


                        $html .='  <li><a>'.$row1['section_name'].' <br />'.$pRow['period_desc'].' '.$pRow['period_yr'].'<span class="fa fa-chevron-down"></span></a>

                                     <ul class="nav child_menu">';


                                        $res2 = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$row1['section_id']."' AND tblperiod.period_id=tblclassperiod.period_id");  

                                        while($row2 = mysqli_fetch_array($res2)) {


                                          $html .=' <li><a href="?page=classperiod&id='.$row2['cp_id'].'">'.$row2['period_name'].'</a>';


                                        }

                                       $html .='<li><a href="?page=timeline&id='.$row1['section_id'].'">Overall Timeline</a>

                                      </li> 


                                      <li><a href="?page=grades&id='.$row1['section_id'].'">Overall Grades</a>

                                      </li> 

                                      <!-- <li><a href="?page=students&id='.$row1['section_id'].'">Students</a>

                                      </li> -->



                                   </ul>

                                  </li>';




                       }



                      $html .='</ul>

                    </li>

                    <li><a href="">View Submitted</a></li>';


                    }

                }


            


                $html .='

                </ul>

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







        $res = mysqli_query($con, "SELECT * FROM tblsection WHERE teacher_id='".$_SESSION['id']."'");



        $countClass = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblclass, tblsection WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblclass.section_id=tblsection.section_id");



        $countStudents = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity WHERE teacher_id='".$_SESSION['id']."'");



        $countActivities = mysqli_num_rows($res);



        $res = mysqli_query($con, "SELECT * FROM tblactivity,tblsubmit WHERE tblactivity.teacher_id='".$_SESSION['id']."' AND tblsubmit.activity_id=tblactivity.activity_id");



        $countSubmmissions = mysqli_num_rows($res);
    

        $act = mysqli_query($con, "SELECT * FROM tblsubmit,tblactivity,tblstudent WHERE tblsubmit.submit_id='".$_GET['id']."' AND tblactivity.activity_id=tblsubmit.activity_id AND tblstudent.student_id=tblsubmit.student_id");

        $actRow = mysqli_fetch_array($act);



        $html .='

        <!-- page content -->

        <div class="right_col" role="main">



          <br />

          <div class="">



            <div class="row top_tiles">

              
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:black;"><i class="fa fa-briefcase" style="color:black;"></i>

                  </div>

                  <div class="count">'.$countClass.'</div>



                  <h3>Class Created</h3>

                  <p>Number of class created</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:lightgreen;"><i class="fa fa-users" style="color:lightgreen;"></i>

                  </div>

                  <div class="count">'.$countStudents.'</div>



                  <h3>Students</h3>

                  <p>Number of students handled</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:red;"><i class="fa fa-tasks" style="color:red;"></i>

                  </div>

                  <div class="count">'.$countActivities.'</div>



                  <h3>Activities</h3>

                  <p>Number of activities made.</p>

                </div>

              </div>

              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon" style="color:tan;"><i class="fa fa-line-chart" style="color:tan;"></i>

                  </div>

                  <div class="count">'.$countSubmmissions.'</div>



                  <h3>Submissions</h3>

                  <p>Number of submissions</p>

                </div>

              </div>

            </div>

            <div class="title_right">
                <div class="col-md-3 col-sm-3 col-xs-12 form-group pull-right top_search">
                  <form action="scripts.php?page=search&type=teacher" method="POST">
                  <div class="input-group">
                    <input type="text" class="form-control" name="search" required="required" placeholder="Search for...">
                    <span class="input-group-btn">
                              <button class="btn btn-default" type="submit">Go!</button>
                          </span>
                  </div>
                  </form>
                </div>
            </div>

             <div class="row">
              <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>View Submitted</h2>
                 
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="col-md-8 col-sm-8 col-xs-12">

                    <center>

                    <img class="img-responsive" src="Activities/Activity'.$_GET['act'].'/'.$actRow['submit_filepath'].'">


                    </center></div>


                     <!-- start project-detail sidebar -->
                    <div class="col-md-4 col-sm-4 col-xs-12">

                      <section class="panel">

                        <div class="x_title">
                          <h2>Submit Info</h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">

                           <div class="project_detail">

                          <p class="title">Student #</p>
                          <p>'.$actRow['student_num'].'</p>

                          <p class="title">Student</p>
                          <p>'.$actRow['student_fname'].' '.$actRow['student_lname'].'</p>

                          <p class="title">DateTime Submitted</p>
                          <p>'.timeAgo($actRow['submit_datetime']).'</p>

                            <form action="scripts.php?page=svgrade&id='.$_GET['id'].'&act='.$_GET['act'].'" method="POST">

                            <div class="form-group has-feedback"> 
                                    <input type="number" name="grd" required class="form-control" value="'.$actRow['submit_grade'].'" id="grd'.$actRow['submit_id'].'" onblur="gAct('.$actRow['submit_id'].');" />
                                     <span class="form-control-feedback right" aria-hidden="true">100</span>
                            </div>


                          <input type="submit" class="btn btn-success" value="Save Changes">
                          <a href="?page=viewgrade&id='.$_GET['act'].'" class="btn btn-primary">Back</a>

                          </form>

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

                              $res = mysqli_query($con, "SELECT * FROM tblteacher WHERE teacher_id !='".$_SESSION['id']."' ORDER BY RAND() LIMIT 5");

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


        $html .=' <!-- modal for custom privacy -->

      <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="custom-modal">

                    <div class="modal-dialog modal-sm">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Custom Privacy</h4>

                        </div>

                        <div class="modal-body">

                      

                        <form class="form-horizontal">

                       

                          <div class="form-group">

                           

                            <div class="col-md-12 col-sm-12 col-xs-12">
                                 <input type="radio" checked name="selpriv" value="Only">Shared only to

                              <textarea id="receiverMsg" class="form-control" placeholder="Enter sections here"></textarea>

                            </div>

                          </div>


                          <div class="form-group">

                            <label class="class="control-label col-md-3 col-sm-3 col-xs-12"">

                          

                            </label>

                            <div class="col-md-12 col-sm-12 col-xs-12">

                                <input type="radio" name="selpriv" value="Except">Shared to all except
                              <textarea id="receiverMsg" class="form-control" disabled coloring="10" placeholder="Enter sections here"></textarea>

                            </div>

                          </div>

                        </form>


                        </div>

                        <div class="modal-footer">


                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button> -->

                          



                        </div>

                         

                      </div>

                    </div>

                  </div>

        <!-- end of modal custom -->';


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

                      

                        <form class="form-horizontal" method="POST" action="scripts.php?page=updateprofilet" enctype="multipart/form-data">

                       

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


//Function definition



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