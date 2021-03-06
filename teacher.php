<?php 



session_start();





date_default_timezone_set("Asia/Manila");





include "functions/connect.php";


mysqli_query($con, "UPDATE tblactivity SET activity_status='Closed' WHERE activity_dateend < '".date("Y-m-d H:i:s")."' AND activity_status='Open'");

mysqli_query($con, "UPDATE tbltest SET test_status='Closed' WHERE test_dateend < '".date("Y-m-d H:i:s")."' AND test_status='Published'");


if (isset($_SESSION['isLogin'])) {



    if ($_SESSION['isLogin'] == "student") {



        header("location: student.php");

    }





} else {



    header("location: index.php");

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

    <title id="tlpage">Teacher Page </title>



    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <link rel="icon" href="favicon.ico" type="image/x-icon">



    <!-- Bootstrap -->

    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

     <!-- PNotify -->
    <link href="vendors/pnotify/dist/pnotify.css" rel="stylesheet">

    <link href="vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">

    <link href="vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- Font Awesome -->

    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

     <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">

    <!-- bootstrap-wysiwyg -->
    <link href="vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">

    <!-- jVectorMap -->

    <link href="css/maps/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>

     <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">

    <!-- Custom Theme Style -->

    <link href="css/custom.css" rel="stylesheet">

  </head>



  <body class="nav-md">

   

  <?php



                include "functions/teacherpages.php";



                $page = !empty($_GET['page']) ? $_GET['page'] : "";



                switch($page){



            



                case "createclass"; echo createclass(); break;



                case "createperiod"; echo createperiod(); break;



                case "classperiod"; echo classperiod(); break;



                case "viewpost"; echo viewpost(); break;
                

                case "viewgrade"; echo viewgrade(); break;


                case "students"; echo students(); break;

                
                case "search"; echo search(); break;

                
                case "viewstudent"; echo viewstudent(); break;


                case "viewteacher"; echo viewteacher(); break;

                case "viewactivity"; echo viewactivity(); break;

                
                case "inbox"; echo inbox(); break;


                case "viewtest"; echo viewtest(); break;


                case "grades"; echo grades(); break;

                case "timeline"; echo timeline(); break;

                case "myprofile"; echo myprofile(); break;


                default: echo index(); break;



                                    

                 }





  ?>



     <!-- jQuery -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap -->

    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>

          <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>

    <!-- FastClick -->

    <script src="vendors/fastclick/lib/fastclick.js"></script>

    <!-- Date -->

    <script src="js/moment/moment.min.js"></script>

    <script src="js/datepicker/daterangepicker.js"></script>



    <!-- jQuery Smart Wizard -->

    <script src="vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
    

    <!-- NProgress -->

    <script src="vendors/nprogress/nprogress.js"></script>

    <!-- Chart.js -->

    <script src="vendors/Chart.js/dist/Chart.min.js"></script>

    <!-- jQuery Sparklines -->

    <script src="vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

     <!-- PNotify -->
    <script src="vendors/pnotify/dist/pnotify.js"></script>

    <script src="vendors/pnotify/dist/pnotify.buttons.js"></script>

    <script src="vendors/pnotify/dist/pnotify.nonblock.js"></script>

         <!-- PNotify -->


     <!-- jQuery Tags Input -->
    <script src="vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>

     <!-- bootstrap-wysiwyg -->
    <script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="vendors/google-code-prettify/src/prettify.js"></script>

    <!-- Flot -->

    <script src="vendors/Flot/jquery.flot.js"></script>

    <script src="vendors/Flot/jquery.flot.pie.js"></script>

    <script src="vendors/Flot/jquery.flot.time.js"></script>

    <script src="vendors/Flot/jquery.flot.stack.js"></script>

    <script src="vendors/Flot/jquery.flot.resize.js"></script>

    <!-- Flot plugins -->

    <script src="js/flot/jquery.flot.orderBars.js"></script>

    <script src="js/flot/date.js"></script>

    <script src="js/flot/jquery.flot.spline.js"></script>

    <script src="js/flot/curvedLines.js"></script>

    <!-- bootstrap-daterangepicker -->

 





     <!-- PNotify -->
    <script>
      $(document).ready(function() {
        
        $('#scrollable').animate({ scrollTop: $('#scrollable').prop('scrollHeight')}, 2);

       
       

       setInterval(function() {

       jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "scripts.php?page=notifications",
            data: "id=" + <?php echo $_SESSION['id']; ?> + "&type=Teacher",
            success:function(response){
            
              var resp = response.split("~");

              if (resp[0] != 0) {


                 new PNotify({
                                  title: resp[1],
                                  text: resp[2],
                                  type: resp[3],
                                  styling: 'bootstrap3'
                              });


              }
              


            },
            error:function (xhr, ajaxOptions, thrownError){
           
            }
        }); 


       
       }, 2000); //2 seconds

        // count inbox 

       setInterval(function() {

       jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "scripts.php?page=checkinbox",
            data: "type=teacher",
            success:function(msgCount){
            
              
                if (msgCount == "0") {

                  document.getElementById('inboxcount').innerHTML = "";

                } else {

                  document.getElementById('inboxcount').innerHTML = msgCount;

                }


            },
            error:function (xhr, ajaxOptions, thrownError){
           
            }
        }); 


              // start of counting notifications

        jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "scripts.php?page=checknotif",
            data: "type=Teacher",
            success:function(response){
            
              if (response == 0) {

                document.getElementById('notifcount').innerHTML = "";
                document.getElementById('tlpage').innerHTML = "Teacher Page";

              } else {


                document.getElementById('notifcount').innerHTML = response;
                document.getElementById('tlpage').innerHTML = "(" + response + ") Teacher Page";

              }
              


            },
            error:function (xhr, ajaxOptions, thrownError){
           
            }


            
        }); 


       
       }, 2000); //2 seconds


       // end of inbox count


       

      }); 



    </script>
    <!-- /PNotify -->

    <!-- Date -->

     <script>
      $(document).ready(function() {
        $('#single_cal1').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          var dt = document.getElementById('single_cal1').value;


      

         });


        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          var dt = document.getElementById('single_cal2').value;


          

         });

        });
    </script>

    <!-- /bootstrap-daterangepicker -->


     <!-- jQuery Smart Wizard -->
    <script>
      $(document).ready(function() {
        $('#wizard').smartWizard();
        
        $('.buttonNext').addClass('btn btn-info');
        $('.buttonPrevious').addClass('btn btn-primary');


        $('#quiztable').dataTable();

        $('#examtable').dataTable();

        $('#questionstable').dataTable();

        $('#activitytable').dataTable();

        $('#studentstable').dataTable();

        $('#selectpriv').change(function () {
          if ($(this).val() == "Custom") {
              $('#custom-modal').modal('show');
          }
      });
       

      });
    </script>
    <!-- /jQuery Smart Wizard -->


    <!-- bootstrap-wysiwyg for new post -->
    <script>
      $(document).ready(function() {
        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editor').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editor').wysiwyg({
          fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
      });
    </script>
    <!-- /bootstrap-wysiwyg for new post -->

        <!-- bootstrap-wysiwyg for new activity -->
    <script>
      $(document).ready(function() {
        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editora').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editora').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editora').wysiwyg({
          fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
      });
    </script>
    <!-- /bootstrap-wysiwyg for new activity-->


        <!-- bootstrap-wysiwyg for new test -->
    <script>
      $(document).ready(function() {
        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editort').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editort').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editort').wysiwyg({
          fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
      });
    </script>
    <!-- /bootstrap-wysiwyg for new test -->


           <!-- bootstrap-wysiwyg for edit fields -->
    <script>
      $(document).ready(function() {
        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editore').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editore').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editore').wysiwyg({
          fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
      });
    </script>
    <!-- /bootstrap-wysiwyg for edit fields-->


      <!-- jQuery Tags Input -->
    <script>
      function onAddTag(tag) {
        alert("Added a tag: " + tag);
      }

      function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
      }

      function onChangeTag(input, tag) {
        alert("Changed a tag: " + tag);
      }

      $(document).ready(function() {
        $('#tags_1').tagsInput({
          width: 'auto'
        });
      });
    </script>
    <!-- /jQuery Tags Input -->

   

    <!-- Custom Theme Scripts -->

    <script src="js/custom.js"></script>



     <!-- Datatables -->

    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>

    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>

    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>

    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>

    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>

    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>

    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>

    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>

    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>

    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

    <script type="text/javascript" src="social/js/oauthpopup.js"></script>

    <!-- Sweet Alert Box -->

    <script src="dist/sweetalert.min.js"></script> 

      <script type="text/javascript"> // full facebook logout

        window.fbAsyncInit = function() {

          FB.init({

          appId      : '1203488246433380', // replace your app id here

          channelUrl : 'http://esn.itcapstone.com/teacher.php', 

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



        function FBLogout(){

          FB.logout(function(response) {

            window.location.href = "scripts.php?page=logout";

          });

        }



        // end facebook logout

        </script>


    <script type="text/javascript">





      /*var easd = window.location.href;



      alert(easd); */





    $(document).ready(function(){ // logout for google


        $("#myHref").on('click', function() {


        document.getElementById('conversation').innerHTML = '<li><center><img src="images/loadgif.gif" width="20" height="20" /></center></li>';


            jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "scripts.php?page=loadinbox",
            data: "type=teacher",
            success:function(unseenMsgs){
            
              

                  //document.getElementById('inboxcount').innerHTML = "";

                  document.getElementById('conversation').innerHTML = unseenMsgs;
               

            },
            error:function (xhr, ajaxOptions, thrownError){
           
                }
            });



      });

          $("#myNotif").on('click', function() {

        document.getElementById('notifcount').innerHTML = "";
        document.getElementById('notifmsgs').innerHTML = '<li><center><img src="images/loadgif.gif" width="20" height="20" /></center></li>';


            jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "scripts.php?page=loadnotifs",
            data: "type=Teacher",
            success:function(unseenNotifs){
            
              

                  //document.getElementById('inboxcount').innerHTML = "";

                  document.getElementById('notifmsgs').innerHTML = unseenNotifs;
               

            },
            error:function (xhr, ajaxOptions, thrownError){
           
                }
            });



      });


           $("#myButton").on('click', function() {




        document.getElementById('ndetails').innerHTML = '<center><img src="images/loadgif.gif" width="50" height="50" /></center>';


            jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "scripts.php?page=refnotif",
            data: "type=Teacher",
            success:function(notifs){
            
              

                  //document.getElementById('inboxcount').innerHTML = "";

                  document.getElementById('ndetails').innerHTML = notifs;
               

            },
            error:function (xhr, ajaxOptions, thrownError){
           
                }
            });



      });

           $('input[type="checkbox"]').click(function(){
              if($(this).attr("value")=="Identification"){
                  $("#ident").toggle();
              }
              if($(this).attr("value")=="Multiple"){
                  $("#multi").toggle();
              }
              if($(this).attr("value")=="Matching"){
                  $("#match").toggle();
              }
               if($(this).attr("value")=="Essay"){
                  $("#ess").toggle();
              }
          });

           $('#testForm').submit(function(){
                var checkbox_value = [];
                var isInsert = true;


                $('#ctf:checked').each(function(i){
                    checkbox_value[i] = $(this).val();
                
                });


                if(checkbox_value==""){
                    swal("Question Format", "Please check at least one format", "info");
                    return false;

                }


          });

        
        

        $('a.logout').googlelogout({



      redirect_url:'http://esn.itcapstone.com/scripts.php?page=logout'



    });





    }); //end logout google



    </script> 






     <!-- compose -->

    <script>

      $('#compose, .compose-close').click(function(){

        $('.compose').slideToggle();

      });

    </script>

    <!-- /compose -->



    <!-- Datatables -->

    <script>

      $(document).ready(function() {



        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({

          keys: true

        });



        $('#datatable-responsive').DataTable();



        $('#datatable-scroller').DataTable({

          ajax: "js/datatables/json/scroller-demo.json",

          deferRender: true,

          scrollY: 380,

          scrollCollapse: true,

          scroller: true

        });



        var table = $('#datatable-fixed-header').DataTable({

          fixedHeader: true

        });



        //TableManageButtons.init();

      });


      function showLoading() {

        var msg = document.getElementById("message").value;

        var cus = document.getElementById('selectpriv').value;

        if (msg != "" && cus != "Custom") {

               document.getElementById("sgif").style.display = "inline";

        }

     

      }

      function showLoadBar() {

        

               document.getElementById("stest").style.display = "inline";

         document.getElementById("stests").style.display = "inline";

     

      }

      function saveText() {

        var txt = document.getElementById("editor").innerHTML;

        document.getElementById('message').innerHTML = txt;


      }

      function saveIns() {

        var txt = document.getElementById('editora').innerHTML;

        document.getElementById('activityDesc').innerHTML = txt;


      }

      function actGrade(id) {

        var grade = document.getElementById('grd'+id).value;



                  jQuery.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "scripts.php?page=actgrade", //Where to make Ajax calls
                    data : {"id" : id, "grade" : grade},
                    success:function(response){

                        

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                      
                    }
                });



      }

      function selectedStudent(id) {

        document.getElementById('receiverName').value = document.getElementById('sname'+id).innerHTML + " (STUDENT #" + document.getElementById('studid'+id).value + ")";
        document.getElementById('receiverID').value = id;
        document.getElementById('receiverType').value = 'student';


      }

      function selectedTeacher(id) {

        document.getElementById('receiverName').value = document.getElementById('tname'+id).innerHTML + " (TEACHER #" + document.getElementById('empid'+id).value + ")";
        document.getElementById('receiverID').value = id;
        document.getElementById('receiverType').value = 'teacher';


      }

      function composeMsg() {

          var msg = document.getElementById('receiverMsg').value;

          var type = document.getElementById('receiverType').value;

          var id = document.getElementById('receiverID').value;

          if (msg != "" && msg != " " && id != "") {

              document.getElementById('receiverBtn').style.display = "none";

              document.getElementById('receiverGif').style.display = "inline";

            


                  jQuery.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "scripts.php?page=composemsg", //Where to make Ajax calls
                      data : {"msg" : msg, "id" : id, "type" : type },
                    success:function(response){

                        

                        if (response == "success") {


                          swal("Success", "You have successfully sent the message", "success")

                          document.getElementById('searchField').value = "";

                          searchUser();

                          document.getElementById('receiverName').value = "";
                          document.getElementById('receiverMsg').value = "";
                          document.getElementById('receiverID').value = "";

                        } else {


                          swal("Failed", "Failed to sent a message for a moment", "error");
                        }


                       
                        document.getElementById('receiverBtn').style.display = "inline";

                        document.getElementById('receiverGif').style.display = "none";

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                      
                    }
                });



          }

          

      }

      function searchUser() {


        var search = document.getElementById('searchField').value;

        document.getElementById('filterusers').innerHTML = '<center><img src="images/loadgif.gif" width="40" height="40" /></center>';

        jQuery.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "scripts.php?page=searchuser", //Where to make Ajax calls
                      data : {"search" : search},
                    success:function(userFields){

                        
                         document.getElementById('filterusers').innerHTML = userFields;
                       

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                      
                    }
                });


      }

      function ent(ele) {

          if(event.keyCode == 13) {

             searchUser();

             event.preventDefault();
             return false;

          }
      }

       function saveTDesc() {

        var txt = document.getElementById('editort').innerHTML;

        document.getElementById('quizDesc').innerHTML = txt;


      }

       function editDesc() {

        var txt = document.getElementById('editore').innerHTML;

        document.getElementById('editdesc').innerHTML = txt;


      }

       function gAct(id) {

        var grd = document.getElementById('grd'+id).value;

        if (grd < 0) {

          swal("Invalid Grade", "Negative grade is not allowed.", "error");

          document.getElementById('grd'+id).value = 0;

        } else if (grd > 100) {

           swal("Invalid Grade", "Maximum grade is 100", "error");

          document.getElementById('grd'+id).value = 0;

        } else {


                  jQuery.ajax({
                    type: "POST", // HTTP method POST or GET
                    url: "scripts.php?page=actgrade", //Where to make Ajax calls
                    data : {"id" : id, "grade" : grd},
                    success:function(response){

                        

                    },
                    error:function (xhr, ajaxOptions, thrownError){
                      
                    }
                });

        }


      }

 

     function showUpload() {

        var file = document.getElementById("file").value;

        if (file != "") {

               document.getElementById("sgif").style.display = "inline";

        }

     

      }


      function clearActivity() {


        document.getElementById('activityName').value = "";
        document.getElementById('activityDesc').innerHTML = "";
        document.getElementById('activityDays').value = "";
        document.getElementById('editora').innerHTML = "";

        document.getElementById('btnActivity').removeAttribute("disabled");

      }

      function createActivity() {


        var activityName = document.getElementById('activityName').value;
        var activityDesc = document.getElementById('activityDesc').value;
        var activityDays = document.getElementById('activityDays').value;
        var periodID     = document.getElementById('periodID').value;

        if (activityName == "" || activityName == " "){


          document.getElementById('activityMsg').innerHTML =  '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Input Activity Name</div>';

        } else if (activityDesc == "" || activityDesc == " ") {


          document.getElementById('activityMsg').innerHTML =  '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Input Activity Instructions</div>';


        } else if (activityDays <= 0) {


          document.getElementById('activityMsg').innerHTML =  '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Input Days Duration, minimum days is 1.</div>';

        } else {


          document.getElementById('btnActivity').setAttribute("disabled", "true");

           jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "scripts.php?page=saveactivity", //Where to make Ajax calls
             data: "id=" + periodID + "&name=" + activityName +"&desc=" +activityDesc + "&days=" + activityDays, //post variables
            success:function(response){

              if (response == "success") {

                    window.location.reload(1);

              } else {

                  document.getElementById('activityMsg').innerHTML =  '<div class="alert alert-danger alert-dismissible fade in" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> Server unavailable at this moment, please try again later.</div>';

                

                      document.getElementById('btnActivity').removeAttribute("disabled");

              }

              

            },
            error:function (xhr, ajaxOptions, thrownError){
              
            }
        });

        }



      }

    </script>

    <!-- /Datatables -->

    

    <script src="js/custom-file-input.js"></script>

    
    <script language="javascript">
    function fbshareCurrentPage()

    {

      var url = "http://esn.itcapstone.com/sharer.php?id=<?php echo $_GET['id']; ?>&sharer=<?php echo uniqid(); ?>";

      window.open("https://www.facebook.com/sharer/sharer.php?u="+ escape(url), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false; 


     
    }


   /* function fbShare(url, title, descr, image, winWidth, winHeight) {
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width='+winWidth+',height='+winHeight);
    } */

        function gshareCurrentPage()

    {window.open("https://plus.google.com/share?url="+escape(window.location.href)+"&t="+document.title, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false; }
</script>


  <!-- Other Functions -->

      <script type="text/javascript">

          function loadConversation() {

            document.getElementById('conversation').innerHTML = '<li><center><img src="images/loadgif.gif" width="20" height="20" /></center></li>';


            jQuery.ajax({
            type: "POST", // HTTP method POST or GET
            url: "scripts.php?page=loadinbox",
            data: "type=teacher",
            success:function(unseenMsgs){
            
              

                  //document.getElementById('inboxcount').innerHTML = "";

                  document.getElementById('conversation').innerHTML = unseenMsgs;
               

            },
            error:function (xhr, ajaxOptions, thrownError){
           
                }
            });


          }

          function loadMsg() {


          			var nm = document.getElementById('nm').value;

	            

          		jQuery.ajax({
	            type: "POST", // HTTP method POST or GET
	            url: "scripts.php?page=loadChat",
	            data: "id=" + <?php echo $_GET['id']; ?> + "&name=" + nm,
	            success:function(chat){
	            
	              	  var c = parseInt(document.getElementById('cMsg').value);

	              	  c += 1;

	                  document.getElementById('m'+c).innerHTML = chat;

	                  document.getElementById('cMsg').value = c;

	                   $('#scrollable').animate({ scrollTop: $('#scrollable').prop('scrollHeight')}, 1000);

         
	               

	            },
	            error:function (xhr, ajaxOptions, thrownError){
	           
	                }
	            });



          }

          <?php 

          if (isset($_GET['id'])) {

          ?>

              function sendReply() {


              		var msg = document.getElementById('message').value;
              		var sid = document.getElementById('sid').value;
              		var stype = document.getElementById('stype').value;

              		if (msg != "" && msg != " ") {

    	          		jQuery.ajax({
    		            type: "POST", // HTTP method POST or GET
    		            url: "scripts.php?page=msgreply",
    		            // data: "id=" + <?php echo $_GET['id']; ?> + "&msg=" + msg + "&sid=" + sid + "&stype=" + stype,
                     data : { "id" : <?php echo $_GET['id']; ?>, "msg" : msg, "sid" : sid, "stype" : stype },
    		            success:function(chat){
    		            
                        
    		              	  document.getElementById('message').value = "";

    		            },
    		            error:function (xhr, ajaxOptions, thrownError){
    		           
    		                }
    		            });


    	          	}
              }

          <?php } ?>

          function selectFormat() {

          	var format = document.getElementById('quizFormat').value;

          	if (format == "") {

          		document.getElementById('choice').style.display = "none";

          		document.getElementById('identify').style.display = "none";

              document.getElementById('matching').style.display = "none";

              document.getElementById('essay').style.display = "none";

          		document.getElementById('upload').style.display = "none";


          	} else if (format == "Multiple") {

          		document.getElementById('choice').style.display = "block";

          		document.getElementById('identify').style.display = "none";

              document.getElementById('matching').style.display = "none";

              document.getElementById('essay').style.display = "none";

          		document.getElementById('upload').style.display = "block";

          	} else if (format == "Identification") {
          		
          		document.getElementById('choice').style.display = "none";

              document.getElementById('matching').style.display = "none";

              document.getElementById('essay').style.display = "none";

          		document.getElementById('identify').style.display = "block";

          		document.getElementById('upload').style.display = "block";

          	} else if (format == "Matching") {

              document.getElementById('choice').style.display = "none";

              document.getElementById('matching').style.display = "block";

              document.getElementById('essay').style.display = "none";

              document.getElementById('identify').style.display = "none";

              document.getElementById('upload').style.display = "block";


            } else if (format == "Essay") {

              document.getElementById('choice').style.display = "none";

              document.getElementById('matching').style.display = "none";

              document.getElementById('essay').style.display = "block";

              document.getElementById('identify').style.display = "none";

              document.getElementById('upload').style.display = "block";

            }

          }

           function selectPeriod() {

            var period = document.getElementById('cperiod').value;

            if (period == 0) {

              window.location = "?page=grades&id=" + <?php echo $_GET['id']; ?> + "&filter=overall";

            } else {

              window.location = "?page=grades&id=" + <?php echo $_GET['id']; ?> + "&filter=" + period;

            }

          }

          function changeTimeline() {

          	 var period = document.getElementById('tperiod').value;


              document.getElementById("sgif").style.display = "inline";

             	jQuery.ajax({
	            type: "POST", // HTTP method POST or GET
	            url: "scripts.php?page=changetimeline",
	            data: "id=" + <?php echo $_GET['id']; ?> + "&cpid=" + period + "&type=teacher",
	            success:function(timeline){
	            
	              	  
	            		document.getElementById('pt').innerHTML = timeline;

                  document.getElementById("sgif").style.display = "none";
	               

	            },
	            error:function (xhr, ajaxOptions, thrownError){
	           
	                }
	            });



          }

          function saveEssay(id) {

            var points = document.getElementById(id).value

             jQuery.ajax({
                type: "POST", // HTTP method POST or GET
                url: "scripts.php?page=saveessay",
                 data : { "id" : id, "points" : points },
                success:function(chat){
                
                      
                },
                error:function (xhr, ajaxOptions, thrownError){
               
                    }
                });

            
          }

           function changeGraph() {

             var period = document.getElementById('tgraph').value;

             var oldperiod = document.getElementById('ograph').value;

             document.getElementById('bar'+period).style.display = "inline";

             document.getElementById('bar'+oldperiod).style.display = "none";

             document.getElementById('ograph').value = period;

          }

          function showGif() {



            if (!document.getElementById("tags_1").value) {
    

                swal("Sections","Please enter some sections", "error");


            } else {
            document.getElementById('btnSubmit').style.display = "none";

            document.getElementById('subgif').style.display = "inline";

            }


          }

             
          <?php if(isset($_GET['id'])) { ?>

          function closeActivity() {

          	   	swal({   
          		title: "Close Activity",   
          		text: "Are you sure you want to close and grade your students now?",   
          		type: "info",   
          		showCancelButton: true,   
          		closeOnConfirm: false,   
          		showLoaderOnConfirm: true, }, 
          			function(){   
          				setTimeout(function(){     
          					swal("Success","Activity successfuly closed.","success");
          						window.location = "scripts.php?page=closeactivity&id=" + <?php echo $_GET['id']; ?>;
          						   }, 3000); });


          }


           function delClass() {


            swal({   title: "Delete This Class?",   
              text: "All activities associated with this class are also be deleted",   
              type: "warning",   
              showCancelButton: true,  
               confirmButtonColor: "#DD6B55",   
               confirmButtonText: "Yes, delete it",  
               closeOnConfirm: false }, 


                function(){   swal("Class Deleted", "You will be redirected to homepage", "success"); 


                window.location = "scripts.php?page=deactclass&id=" + <?php echo $_GET['id']; ?>;

              });



          }

           function removePost(id) {


            swal({   title: "Post Delete",   
              text: "All data associated with this post will also be deleted",   
              type: "warning",   
              showCancelButton: true,  
               confirmButtonColor: "#DD6B55",   
               confirmButtonText: "Yes, delete it",  
               closeOnConfirm: false }, 


                function(){   swal("Post Deleted !", "Successfuly post was deleted", "success"); 


                <?php 

                if (!isset($_GET['page']) || $_GET['page'] == "index") {


                  ?>

                  window.location = "scripts.php?page=deletepost&ref=index&post=" + id;

                
                  <?php 

                } else if ($_GET['page'] == "classperiod") {

                  ?>

                 window.location = "scripts.php?page=deletepost&ref=classperiod&post=" + id + "&id=" + <?php echo $_GET['id']; ?>;

                 <?php

                } else if ($_GET['page'] == "timeline") {


                  ?>

                 window.location = "scripts.php?page=deletepost&ref=timeline&post=" + id + "&id=" + <?php echo $_GET['id']; ?>;

                <?php
                }

                ?>

               

              });



          }

          function editPost(id) {

           
              document.getElementById('postid').value = id;

            jQuery.ajax({
              type: "POST", // HTTP method POST or GET
              url: "scripts.php?page=changetxtfield&id=" + <?php echo $_GET['id']; ?>,
              data: "id=" + id,
              success:function(txtfield){
              
                    document.getElementById('editore').innerHTML = txtfield;

                    document.getElementById('editdesc').innerHTML = txtfield;
                 

              },
              error:function (xhr, ajaxOptions, thrownError){
             
                  }
              });

            jQuery.ajax({
              type: "POST", // HTTP method POST or GET
              url: "scripts.php?page=changetxtname&id=" + <?php echo $_GET['id']; ?>,
              data: "id=" + id,
              success:function(txtname){
              
                    document.getElementById('txtName').innerHTML = txtname;
                  //document.getElementById('cfield').innerHTML = fields
                 

              },
              error:function (xhr, ajaxOptions, thrownError){
             
                  }
              });



          }

          function delStudent(id) {

             swal({   title: "Kick this student?",   
              text: "Removed the student, but retains his/her activity data",   
              type: "warning",   
              showCancelButton: true,  
               confirmButtonColor: "#DD6B55",   
               confirmButtonText: "Yes, delete it",  
               closeOnConfirm: false }, 


                function(){   swal("Student Removed", "Student has now been kicked.", "success"); 


                window.location = "scripts.php?page=kickstudent&id=" + <?php echo $_GET['id']; ?> + "&class=" + id;

              });



          }


          <?php } ?>

          

          function validateForm() {

   
            var cpid = document.getElementById('cpi').value;

            var bGrade = document.getElementById('bGrade').value;

            var sum = 0;

            if (cpid == 0) {

               var tpid = document.getElementById('tpid').value;

              

                for(var p = 0; p < tpid; p++) {

                  var g = document.getElementById('pGrade'+p).value;

                  sum += Math.round(g);

                }


            } else {


               var a = document.getElementById('aGrade').value;

              sum += Math.round(a);

              var q = document.getElementById('qGrade').value;

              sum += Math.round(q);

              var e = document.getElementById('eGrade').value;

              sum += Math.round(e);

            }





            if (sum != 100) {

              swal("Grades","Grades percentage must sum up to 100. Current Total :" + sum ,"info");

               return false;

            } else if (bGrade < 0) {

              swal("Base Grade","Base grade must not be a negative value.","info");

               return false;

            } else if (bGrade > 70) {

              swal("Base Grade", "Base Grade must limit is only 70.", "info");

               return false;

            }

           
        }


      </script>

    <!-- end of other functions -->

    <script>


      Chart.defaults.global.legend = {

        enabled: false

      };

    
      var button = document.getElementById('hideshow'); // Assumes element with id='button'

        button.onclick = function() {
            var div = document.getElementById('cmp');
            if (div.style.display !== 'none') {
                div.style.display = 'none';
                document.getElementById('hideshow').value = "Post Announcement";
            }
            else {
                div.style.display = 'block';
                 document.getElementById('hideshow').value = "Hide Announcement";
            }
        };


      

    </script>

    <script>
      var toggle = function() {
      var mydiv = document.getElementById('cto');
      if (mydiv.style.display === 'block' || mydiv.style.display === '')
        mydiv.style.display = 'none';
      else
        mydiv.style.display = 'block';
      }

      var taggle = function() {
      var mydiv = document.getElementById('ato');
      if (mydiv.style.display === 'block' || mydiv.style.display === '')
        mydiv.style.display = 'none';
      else
        mydiv.style.display = 'block';
      }

    </script>

    <!-- start of graph -->

    <?php 

    if (isset($_GET['page'])) {

    	if ($_GET['page'] == "inbox" && isset($_GET['id'])) {


    		echo '<script type="text/javascript">';


    		echo 'setInterval(function() {

        

		       jQuery.ajax({
		            type: "POST", // HTTP method POST or GET
		            url: "scripts.php?page=checkmsg",
		            data: "id='.$_GET['id'].'",
		            success:function(msgCount){';
		            
		                echo "var cMsg = parseInt(document.getElementById('cMsg').value);
		           
		                if (msgCount != cMsg) {

		                  

		                  loadMsg();



		                }


		            },
		            error:function (xhr, ajaxOptions, thrownError){
		           
		            }
		        }); 


		       
		       }, 1000); //1 seconds";



    		echo '</script>';

    	} else if ($_GET['page'] == "timeline") {



          $periods = mysqli_query($con, "SELECT * FROM tblclassperiod,tblperiod WHERE tblclassperiod.section_id='".$_GET['id']."' AND tblperiod.period_id=tblclassperiod.period_id ORDER BY tblperiod.period_id ASC");

              

                while($periodsRow = mysqli_fetch_array($periods)) {

                 $graph = mysqli_query($con, "SELECT * FROM tblgrades,tblstudent WHERE tblgrades.section_id='".$_GET['id']."' AND tblgrades.cp_id='".$periodsRow['cp_id']."' AND tblstudent.student_id=tblgrades.student_id ORDER BY tblgrades.total_grade DESC LIMIT 5");


                                      
                                    $graphCount = mysqli_num_rows($graph);


                                    if ($graphCount != 0)  {


                                      echo '<script>';

                                      $g = 0;

                                      $snames = "";
                                      $sgrades = "";

                                      while($graphRow = mysqli_fetch_array($graph)) {



                                        
                                            $tgrade = $graphRow['total_grade'];
                                              
                                         



                                          if (($g + 1) == $graphCount) {

                                            $snames .= '"'.strtoupper($graphRow['student_fname'][0]).'. '.strtoupper($graphRow['student_lname']).'"';
                                            

                                            $sgrades .= '"'.$tgrade.'"';


                                          } else {

                                            $snames .= '"'.strtoupper($graphRow['student_fname'][0]).'. '.strtoupper($graphRow['student_lname']).'",';


                                            $sgrades .= '"'.$tgrade.'",';

                                          }

                                          $g += 1;


                                      }




                                                                              // Bar chart
                                        echo 'var ctx = document.getElementById("bar'.$periodsRow['cp_id'].'");
                                        var mybarChart = new Chart(ctx, {
                                          type: "bar",
                                          data: {
                                            labels: ['.$snames.'],


                                            datasets: [{
                                              label: "'.ucfirst($periodsRow['period_name']).' Grade ",
                                              backgroundColor: [
                                              "#455C73",
                                              "#9B59B6",
                                              "#BDC3C7",
                                              "#26B99A",
                                              "#3498DB"
                                            ],
                                              data: ['.$sgrades.']
                                            }]
                                          },

                                          options: {
                                            scales: {
                                              yAxes: [{
                                                ticks: {
                                                  beginAtZero: true
                                                }
                                              }]
                                            }
                                          }
                                        });




                                      </script>';



                                    }



                  }





      } else if ($_GET['page'] == "viewstudent") {


            $class = mysqli_query($con, "SELECT * FROM tblclass,tblsection,tblteacher WHERE tblclass.student_id='".$_GET['id']."' AND tblsection.section_id=tblclass.section_id AND tblteacher.teacher_id=tblsection.teacher_id");

            $classCount = mysqli_num_rows($class);


            echo '<script>';

            if ($classCount == 0) {


                  
              echo "document.getElementById('cr').innerHTML = '<center><h1>No Graph Available</h1></center> <br /> <br />';";

            } else {

              $sgrades = "";
              $snames = "";
              $g = 0;


              while($classRow = mysqli_fetch_array($class)) {


                    $overall = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='0' AND section_id='".$classRow['section_id']."' AND student_id='".$_GET['id']."'");

                    $overallCount = mysqli_num_rows($overall);

                    if ($overallCount == 0) {

                      if (($g + 1) == $classCount) {

                        $snames .= '"Subject '.($g + 1).'"';

                        $sgrades .= $classRow['teacher_basegrade'];

                      

                      } else {

                        $snames .= '"Subject '.($g + 1).'",';

                        $sgrades .= $classRow['teacher_basegrade'].',';

                        


                      }


                    } else {

                      $overallRow = mysqli_fetch_array($overall);

                      if (($g + 1) == $classCount) {

                        $snames .= '"Subject '.($g + 1).'"';

                        $sgrades .= ($overallRow['total_grade'] + $classRow['teacher_basegrade']);

                       

                      } else {

                        $snames = '"Subject '.($g + 1).'",';

                        $sgrades .= ($overallRow['total_grade'] + $classRow['teacher_basegrade']).',';

                        


                      }


                    }


                    $g += 1;


              }


                // Radar chart
                echo 'var ctx = document.getElementById("canvasRadar");
                var data = {
                  labels: ['.$snames.'],
                   datasets: [{
                    label: "Current Grade ",
                    backgroundColor: "rgba(3, 88, 106, 0.2)",
                    borderColor: "rgba(3, 88, 106, 0.80)",
                    pointBorderColor: "rgba(3, 88, 106, 0.80)",
                    pointBackgroundColor: "rgba(3, 88, 106, 0.80)",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(220,220,220,1)",
                    data: ['.$sgrades.']
                  }]
                };

                var canvasRadar = new Chart(ctx, {
                  type: "radar",
                  data: data,

                    options: {
                            scale: {
                                
                                ticks: {
                                    max: 100,
                                    beginAtZero: true
                                }
                            }
                    }

                });';



            }

        




            echo '</script>';




      } else if ($_GET['page'] == "viewteacher") {


         $class = mysqli_query($con, "SELECT * FROM tblsection,tblteacher WHERE tblsection.teacher_id='".$_GET['id']."' AND tblteacher.teacher_id=tblsection.teacher_id");

            $classCount = mysqli_num_rows($class);


            echo '<script>';

            if ($classCount == 0) {


                  
              echo "document.getElementById('cr').innerHTML = '<center><h1>No Graph Available</h1></center> <br /> <br />';";

            } else {

              $sgrades = "";
              $snames = "";
              $g = 0;


              while($classRow = mysqli_fetch_array($class)) {


                    $overall = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='0' AND section_id='".$classRow['section_id']."' ORDER BY total_grade DESC");

                    $overallCount = mysqli_num_rows($overall);

                    if ($overallCount == 0) {

                      if (($g + 1) == $classCount) {

                        $snames .= '"Subject '.($g + 1).'"';

                        $sgrades .= $classRow['teacher_basegrade'];

                    

                      } else {

                        $snames .= '"Subject '.($g + 1).'",';

                        $sgrades .= $classRow['teacher_basegrade'].',';

                     


                      }


                    } else {

                      $overallRow = mysqli_fetch_array($overall);

                      if (($g + 1) == $classCount) {

                        $snames .= '"Subject '.($g + 1).'"';

                        $sgrades .= ($overallRow['total_grade'] + $classRow['teacher_basegrade']);

                      

                      } else {

                        $snames = '"Subject '.($g + 1).'",';

                        $sgrades .= ($overallRow['total_grade'] + $classRow['teacher_basegrade']).',';



                      }


                    }


                    $g += 1;


              }

                                  // Bar chart
                                        echo 'var ctx = document.getElementById("canvasRadar");
                                        var mybarChart = new Chart(ctx, {
                                          type: "bar",
                                          data: {
                                            labels: ['.$snames.'],


                                            datasets: [{
                                              label: "Highest Record Grade",
                                              backgroundColor: [
                                              "#455C73",
                                              "#9B59B6",
                                              "#BDC3C7",
                                              "#26B99A",
                                              "#3498DB",
                                              "#455C73",
                                              "#9B59B6",
                                              "#BDC3C7",
                                              "#26B99A"
                                            ],
                                              data: ['.$sgrades.']
                                            }]
                                          },

                                          options: {
                                            scales: {
                                              yAxes: [{
                                                ticks: {
                                                  beginAtZero: true
                                                }
                                              }]
                                            }
                                          }
                                        });';


                // Radar chart
                // echo 'var ctx = document.getElementById("canvasRadar");
                // var data = {
                //   labels: ['.$snames.'],
                //    datasets: [{
                //     label: "Current Grade ",
                //     backgroundColor: "rgba(3, 88, 106, 0.2)",
                //     borderColor: "rgba(3, 88, 106, 0.80)",
                //     pointBorderColor: "rgba(3, 88, 106, 0.80)",
                //     pointBackgroundColor: "rgba(3, 88, 106, 0.80)",
                //     pointHoverBackgroundColor: "#fff",
                //     pointHoverBorderColor: "rgba(220,220,220,1)",
                //     data: ['.$sgrades.']
                //   }]
                // };

                // var canvasRadar = new Chart(ctx, {
                //   type: "radar",
                //   data: data,

                //    options: {
                //             scale: {
                                
                //                 ticks: {
                //                     max: 100,
                //                     beginAtZero: true
                //                 }
                //             }
                //     }

                  
                // });';



            }

        




            echo '</script>';






      } else if ($_GET['page'] == "myprofile") {


        $class = mysqli_query($con, "SELECT * FROM tblsection,tblteacher WHERE tblsection.teacher_id='".$_SESSION['id']."' AND tblteacher.teacher_id=tblsection.teacher_id");

            $classCount = mysqli_num_rows($class);


            echo '<script>';

            if ($classCount == 0) {


                  
              echo "document.getElementById('cr').innerHTML = '<center><h1>No Graph Available</h1></center> <br /> <br />';";

            } else {

              $sgrades = "";
              $snames = "";
              $g = 0;


              while($classRow = mysqli_fetch_array($class)) {




                    $overall = mysqli_query($con, "SELECT * FROM tblgrades WHERE cp_id='0' AND section_id='".$classRow['section_id']."' ORDER BY total_grade DESC");

                    $overallCount = mysqli_num_rows($overall);

                    if ($overallCount == 0) {

                      if (($g + 1) == $classCount) {

                        $snames .= '"'.$classRow['section_name'].' - '.$classRow['section_desc'].' '.$classRow['section_term'].'"';

                        $sgrades .= $classRow['teacher_basegrade'];

                    

                      } else {

                       
                        $snames = '"'.$classRow['section_name'].' - '.$classRow['section_desc'].' '.$classRow['section_term'].'",';


                        $sgrades .= $classRow['teacher_basegrade'].',';

                     


                      }


                    } else {

                      $overallRow = mysqli_fetch_array($overall);

                      if (($g + 1) == $classCount) {

                        $snames .= '"'.$classRow['section_name'].' - '.$classRow['section_desc'].' '.$classRow['section_term'].'"';

                        $sgrades .= ($overallRow['total_grade'] + $classRow['teacher_basegrade']);

                      

                      } else {

                        $snames = '"'.$classRow['section_name'].' - '.$classRow['section_desc'].' '.$classRow['section_term'].'",';

                        $sgrades .= ($overallRow['total_grade'] + $classRow['teacher_basegrade']).',';



                      }


                    }


                    $g += 1;


              }


                                                        // Bar chart
                                        echo 'var ctx = document.getElementById("canvasRadar");
                                        var mybarChart = new Chart(ctx, {
                                          type: "bar",
                                          data: {
                                            labels: ['.$snames.'],


                                            datasets: [{
                                              label: "Highest Record Grade",
                                              backgroundColor: [
                                              "#455C73",
                                              "#9B59B6",
                                              "#BDC3C7",
                                              "#26B99A",
                                              "#3498DB",
                                              "#455C73",
                                              "#9B59B6",
                                              "#BDC3C7",
                                              "#26B99A"
                                            ],
                                              data: ['.$sgrades.']
                                            }]
                                          },

                                          options: {
                                            scales: {
                                              yAxes: [{
                                                ticks: {
                                                  beginAtZero: true
                                                }
                                              }]
                                            }
                                          }
                                        });';



                // // Radar chart
                // echo 'var ctx = document.getElementById("canvasRadar");
                // var data = {
                //   labels: ['.$snames.'],
                //    datasets: [{
                //     label: "Current Grade ",
                //     backgroundColor: "rgba(3, 88, 106, 0.2)",
                //     borderColor: "rgba(3, 88, 106, 0.80)",
                //     pointBorderColor: "rgba(3, 88, 106, 0.80)",
                //     pointBackgroundColor: "rgba(3, 88, 106, 0.80)",
                //     pointHoverBackgroundColor: "#fff",
                //     pointHoverBorderColor: "rgba(220,220,220,1)",
                //     data: ['.$sgrades.']
                //   }]
                // };

                // var canvasRadar = new Chart(ctx, {
                //   type: "radar",
                //   data: data,

                //    options: {
                //             scale: {
                                
                //                 ticks: {
                //                     max: 100,
                //                     beginAtZero: true
                //                 }
                //             }
                //     }

                  
                // });';



            }

        




            echo '</script>';


      }



    }

    ?>

  
  </body>

</html>