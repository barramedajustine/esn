<?php



function index() {

	



	$teacherURL = "window.location='?page=teacher';";

	$studentURL = "window.location='?page=student';";



		$html ='

   <center><img src="EDSON01.png" width="100%" height="100%">
   <h1 style="top:50px; color: #14312b;">Learn and communicate the easiest way!</h1></center>

		<div>

          <center>
	          <section class="login_content">

	            <form>

	              <h1 style="color: #14312b;">Login or Sign Up Now ! <br /> <small style="color: #14312b;">Choose your corresponding type of user.</small></h1>

	              <div>

	               <button type="button" onclick="'.$teacherURL.'" class="btn btn-success btn-lg btn-block"><i class="fa fa-user"></i> Teacher</button>

	              </div>

	              <div>

	                <button type="button" onclick="'.$studentURL.'"class="btn btn-info btn-lg btn-block"><i class="fa fa-users"></i> Student</button>
                  

	              </div>

	              <div>

	              

	              </div>

	              <div class="clearfix"></div>

	              <div class="separator">



	                 <p style="color: #14312b;"> Select your corresponding user type.</p>

	                <div class="clearfix"></div>

	                <br />

	                <div>

	                  <h1 style="color: #14312b;"><i class="fa fa-pencil" style="font-size: 26px;"></i> Educational Social Network</h1>



	                  <p style="color: #14312b;">©2016 All Rights Reserved. AMACC Davao Capstone</p>

	                </div>

	              </div>

	            </form>

	          </section>

            </center>

	        </div>';









    return $html;







}



function teacher() {



  $regURL = "window.location='?page=register&type=teacher';";

	$html ='



		<div id="login" class=" form">

          <section class="login_content">

            <form action="scripts.php?page=logint" method="POST">



              <h1 style="color: #14312b;">Teacher Login</h1>'.$_SESSION['cerror'].'



               <div>

                <input type="email" name="email" class="form-control" placeholder="Email" required="" />

              </div>

              <div>

                <input type="password" name="pass" class="form-control" placeholder="Password" required="" />

              </div>

              <div>

                <button type="submit" class="btn btn-default">Log in</button>
                <button type="button" class="btn btn-success" onclick="'.$regURL.'">Register</button>

                <!-- <a class="reset_pass" href="?page=index">Back to index</a> -->

              </div>



             </section>

              <div>

              	<a class="login btn btn-block btn-danger" href="javascript:void(0);"">

	                                	<i class="fa fa-google-plus"></i> Sign in via Google

	                          		</a>

                <a href="#" onclick="FBLogin();" class="btn btn-block btn-primary"><i class="fa fa-facebook"></i> Sign in via Facebook</a>

	            </div>

	          

	           <section class="login_content">

              <!-- <div class="clearfix"></div> -->


                        <a href="index.php" style="color: #14312b;">Back to Index</a>

                

                <!-- <p class="change_link">New to site?

                        <a href="#" data-toggle="modal" data-target="#r">Create Account</a>

                </p> -->





              	



                    



                <div class="clearfix"></div>

                <br />

                <div>

                  <h1 style="color: #14312b;"><i class="fa fa-pencil" style="font-size: 26px;"></i> Educational Social Network</h1>



                  <p style="color: #14312b;">©2016 All Rights Reserved. AMACC Davao Capstone</p>

                </div>

              </div>

            </form>

            </section>

        </div>';


                  $_SESSION['cerror'] = "";



        $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="r">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Create Account</h4>

                        </div>

                        <div class="modal-body">



                          <div id="msg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                        	<form class="form-horizontal form-label-left action="#" method="POST">



		                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

		                        <input type="text" class="form-control has-feedback-left" id="fname" placeholder="First Name">

		                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>

		                      </div>



		                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

		                        <input type="text" class="form-control" id="lname" placeholder="Last Name">

		                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>

		                      </div>



		                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

		                        <input type="email" class="form-control has-feedback-left" id="email" placeholder="Email">

		                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>

		                      </div>



		                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

		                        <input type="text" class="form-control" id="empid" placeholder="Employee ID">

		                        <span class="fa fa-eraser form-control-feedback right" aria-hidden="true"></span>

		                      </div>



		                      <div class="form-group">

		                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>

		                        <div class="col-md-9 col-sm-9 col-xs-12">

		                          <input type="password" required="required" id="pass" class="form-control" placeholder="Password">

		                        </div>

		                      </div>



		                      <div class="form-group">

		                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password</label>

		                        <div class="col-md-9 col-sm-9 col-xs-12">

		                          <input type="password" onkeypress="return enterT(event)" required="required" id="cpass" class="form-control" placeholder="Confirm Password">

		                        </div>

		                      </div>

		                      



                   		 </form>





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" onclick="registerT()">Register</button>

                        </div>



                      </div>

                    </div>

                  </div>';



     return $html;







}



function student() {



   $regURL = "window.location='?page=register&type=student';";



	 $html ='



      <div id="login" class=" form">

          <section class="login_content">

            <form action="scripts.php?page=logins" method="POST">

              <h1 style="color: #14312b;">Student Login </h1>'.$_SESSION['cerror'].'

              <div>

                <input type="email" name="email" class="form-control" placeholder="Email" required="" />

              </div>

              <div>

                <input type="password" name="pass" class="form-control" placeholder="Password" required="" />

              </div>

              <div>

                 <button type="submit" class="btn btn-default">Log in</button>
                <button type="button" class="btn btn-success" onclick="'.$regURL.'">Register</button>

                <!-- <a class="reset_pass" href="?page=index">Back to index</a> -->

              </div> 

              </section>

              <div>

                <a class="login btn btn-block btn-danger" href="javascript:void(0);"">

                                    <i class="fa fa-google-plus"></i> Sign in via Google

                                </a>

                <a href="#" onclick="FBLogin();" class="btn btn-block btn-primary"><i class="fa fa-facebook"></i> Sign in via Facebook</a>

              </div>

            

             <section class="login_content">

              <!-- <div class="clearfix"></div> -->


                        <a href="index.php" style="color: #14312b;">Back to Index</a>

                

                <!-- <p class="change_link">New to site?

                        <a href="#" data-toggle="modal" data-target="#r">Create Account</a>

                </p> -->





                

                    



                <div class="clearfix"></div>

                <br />

                <div>

                  <h1 style="color: #14312b;"><i class="fa fa-pencil" style="font-size: 26px;"></i> Educational Social Network</h1>



                  <p style="color: #14312b;">©2016 All Rights Reserved. AMACC Davao Capstone</p>

                </div>

              </div>

            </form>

          </section>

      

      </div>';

      $_SESSION['cerror'] = "";



   $html .='  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="r">

                    <div class="modal-dialog modal-lg">

                      <div class="modal-content">



                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>

                          </button>

                          <h4 class="modal-title" id="myModalLabel">Create Account</h4>

                        </div>

                        <div class="modal-body">



                          <div id="msg">



                          <!-- <div class="alert alert-danger alert-dismissible fade in" role="alert">

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>

                            </button>

                            Invalid Email / Password

                          </div> -->



                          </div>

                          

                          <form class="form-horizontal form-label-left action="#" method="POST">



                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                            <input type="text" class="form-control has-feedback-left" id="fname" placeholder="First Name">

                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>

                          </div>



                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                            <input type="text" class="form-control" id="lname" placeholder="Last Name">

                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>

                          </div>



                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                            <input type="email" class="form-control has-feedback-left" id="email" placeholder="Email">

                            <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>

                          </div>



                          <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">

                            <input type="text" class="form-control" id="studid" placeholder="Student ID">

                            <span class="fa fa-eraser form-control-feedback right" aria-hidden="true"></span>

                          </div>



                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <input type="password" required="required" id="pass" class="form-control" placeholder="Password">

                            </div>

                          </div>



                          <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Confirm Password</label>

                            <div class="col-md-9 col-sm-9 col-xs-12">

                              <input type="password" onkeypress="return enterS(event)" required="required" id="cpass" class="form-control" placeholder="Confirm Password">

                            </div>

                          </div>

                          



                       </form>





                        </div>

                        <div class="modal-footer">

                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                          <button type="button" class="btn btn-primary" onclick="registerS()">Register</button>

                        </div>



                      </div>

                    </div>

                  </div>';







     return $html;



}





function checkpoint() {





  include "functions/connect.php";



  $html ='



      <div id="login" class=" form">

          <section class="login_content">

            <form action="scripts.php?page=saveaccount&type='.$_GET['type'].'" method="POST">';



              if ($_GET['type'] == "teacher") {



                $html .='

                    <h1 style="color: #14312b;">Teacher Checkpoint</h1>

                    '.$_SESSION['cerror'].'

                    <div>

                          <div class="form-group">
                          
                            <label class="pull-left" style="color: #14312b;">Employee ID</label>
                              <input type="text" name="id" maxlength="30" class="form-control" placeholder="Enter employee id" required="" />

                          </div>


                          <div class="form-group">
                          
                            <label class="pull-left" style="color: #14312b;">New Password</label>
                              <input type="password" name="pass" maxlength="30" class="form-control" placeholder="Minimum of 5 characters" required="" />

                          </div>

                          <div class="form-group">
                          
                            <label class="pull-left" style="color: #14312b;">Confirm</label>
                              <input type="password" name="cpass" maxlength="30" class="form-control" placeholder="Retype password" required="" />

                          </div>


                      ';



              } else {



                $html .='<h1 style="color: #14312b;">Student Checkpoint</h1>

                    '.$_SESSION['cerror'].'

                    <div>



                        <div class="form-group">
                          
                            <label class="pull-left" style="color: #14312b;">Student ID</label>
                              <input type="text" name="id" maxlength="30" class="form-control" placeholder="Enter student id" required="" />

                          </div>


                          <div class="form-group">
                          
                            <label class="pull-left" style="color: #14312b;">New Password</label>
                              <input type="password" name="pass" maxlength="30" class="form-control" placeholder="Minimum of 5 characters" required="" />

                          </div>

                          <div class="form-group">
                          
                            <label class="pull-left" style="color: #14312b;">Confirm</label>
                              <input type="password" name="cpass" maxlength="30" class="form-control" placeholder="Retype password" required="" />

                          </div>


                      ';

              }







              $html .='</div>

              

              <div>

                <button type="submit" class="btn btn-block btn-success"> Proceed to Dashboard

                                </button>

              </div>

              <div class="clearfix"></div>

              <div class="separator">



              



                <div class="clearfix"></div>

                <br />

                <div>

                  <h1 style="color: #14312b;"><i class="fa fa-pencil" style="font-size: 26px;"></i> Educational Social Network</h1>



                  <p style="color: #14312b;">©2016 All Rights Reserved. AMACC Davao Capstone</p>

                </div>

              </div>

            </form>

          </section>

      

      </div>';





      $_SESSION['cerror'] = "";



      return $html;





}

function register() {


   include "functions/connect.php";

   $homeURL = "window.location='?page=".$_GET['type']."'";


  $html ='



      <div id="login" class=" form">


      <section class="login_content">

            <form action="scripts.php?page=insertaccount&type='.$_GET['type'].'" method="POST">';



              if ($_GET['type'] == "teacher") {



                $html .='

                    <h1 style="color: #14312b;">Teacher Registration</h1>'.$_SESSION['cerror'].'


                    <div>

                      <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Teacher ID </label>
                          <input type="text" name="id" maxlength="30" class="form-control" placeholder="Enter employee id" required="" />

                      </div>

                      <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">First Name </label>
                          <input type="text" name="fname" maxlength="30" class="form-control" placeholder="Enter first name" required="" />

                      </div>

                      <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Last Name </label>
                          <input type="text" name="lname" maxlength="30" class="form-control" placeholder="Enter last name" required="" />

                      </div>

                      <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Email Address </label>
                          <input type="email" name="email" maxlength="50" class="form-control" placeholder="Enter email address" required="" />

                      </div>

                       <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Password</label>
                          <input type="password" name="pass" maxlength="30" class="form-control" placeholder="Minimum of 5 characters" required="" />

                      </div>

                      <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Confirm Password</label>
                          <input type="password" name="cpass" maxlength="30" class="form-control" placeholder="Retype password" required="" />

                      </div>';



              } else {



                $html .='<h1 style="color: #14312b;">Student Registration</h1>

                    '.$_SESSION['cerror'].'

                    <div>



                     <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Student ID </label>
                          <input type="text" name="id" maxlength="30" class="form-control" placeholder="Enter student id" required="" />

                      </div>

                      <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">First Name </label>
                          <input type="text" name="fname" maxlength="30" class="form-control" placeholder="Enter first name" required="" />

                      </div>

                      <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Last Name </label>
                          <input type="text" name="lname" maxlength="30" class="form-control" placeholder="Enter last name" required="" />

                      </div>

                      <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Email Address </label>
                          <input type="email" name="email" maxlength="50" class="form-control" placeholder="Enter email address" required="" />

                      </div>

                       <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Password</label>
                          <input type="password" name="pass" maxlength="30" class="form-control" placeholder="Minimum of 5 characters" required="" />

                      </div>

                      <div class="form-group">

                        <label class="pull-left" style="color: #14312b;">Confirm Password</label>
                          <input type="password" name="cpass" maxlength="30" class="form-control" placeholder="Retype password" required="" />

                      </div>';

              }







              $html .='</div>

              

              <div>


                <button type="submit" class="btn btn-success"> Confirm Registration</button>
                <button type="button" onclick="'.$homeURL.'" class="btn btn-default">Back To Login</button>

              </div>

              <div class="clearfix"></div>

              <div class="separator">



              



                <div class="clearfix"></div>

                <br />

                <div>

                  <h1 style="color: #14312b;"><i class="fa fa-pencil" style="font-size: 26px;"></i> Educational Social Network</h1>



                  <p style="color: #14312b;">©2016 All Rights Reserved. AMACC Davao Capstone</p>

                </div>

              </div>

            </form>

          </section>

      

      </div>';





      $_SESSION['cerror'] = "";



      return $html;


}


function logout() {

  



    $html ='



      <div id="login" class=" form">

            <section class="login_content">

              <form>

                <h1 style="color: #14312b;">Logout Page</h1>

                <div>

                   <img src="images/loadgif.gif">

                   
                </div>

               

                <div>

                

                </div>

                <div class="clearfix"></div>

                <div class="separator">



                   <p style="color: #14312b;"> Redirecting to index page</p>

                  <div class="clearfix"></div>

                  <br />

                  <div>

                    <h1 style="color: #14312b;"><i class="fa fa-pencil" style="font-size: 26px;"></i> Educational Social Network</h1>



                    <p style="color: #14312b;">©2016 All Rights Reserved. AMACC Davao Capstone</p>

                  </div>

                </div>

              </form>

            </section>

          </div>';









    return $html;







}




?>