<!DOCTYPE html>

<?php
session_start();
if($_SESSION['username'] == null)
{
        header ('location: IRS_Login.php');
        exit;
}
?>

<?php
      include("connects.php");
      $exam_number = $_POST['exam_number'];


      $sql = "SELECT * FROM `ExamList` WHERE `No`='$exam_number'";
      $result = mysqli_fetch_object($db->query($sql));
      $q_list = array();
      $temp_string = $result->question_list;
      $q_list = mb_split(",",$temp_string);
      //print_r($q_list);

      $sql = "SELECT * FROM Now_state";
      $result = mysqli_fetch_object($db->query($sql));
      $exam_index = $result->No;
      $question_number = $result->No;

      array_push($q_list,"0");
      $q_list_number = sizeof($q_list);
      for ($i = $q_list_number-1; $i>0 ; $i--)
      {
        $q_list[$i] = $q_list[$i-1];
      }
      $q_list[0] = "0";

      if($exam_index ==0)
      {
        $sql = "UPDATE Now_state SET No =1";
        $db->query($sql);
        $exam_index = 1;
      }

      //echo $q_list_number."--".$question_number;
      if($question_number==0)$question_number=1;

      $db->close();

?>

<html lang="en">
          <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <!-- Meta, title, CSS, favicons, etc. -->
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
        	<link rel="icon" href="images/favicon.ico" type="image/ico" />

            <title>Chen's IRS | </title>

            <!-- Bootstrap -->
            <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Font Awesome -->
            <!-- link href="../vendors/font-awesome/css/fontawesome-all.css" rel="stylesheet" -->
            <!-- Font Awesome -->
            <!-- link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" -->

            <link href="..//vendors/fontawesome-free-5.8.2-web/css/all.css" rel="stylesheet">
            <!-- NProgress -->
            <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
            <!-- iCheck -->
            <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
            <!-- bootstrap-progressbar -->
            <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
            <!-- JQVMap -->
            <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
            <!-- bootstrap-daterangepicker -->
            <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

            <!-- Custom Theme Style -->
            <link href="../build/css/custom.min.css" rel="stylesheet">
          </head>




  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"><i class="fas fa-book"></i> <span>Chen's IRS</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <!-- img src="images/img.jpg" alt="..." class="img-circle profile_img"-->
              </div>
              <div class="profile_info">
                <span>Welcome,NCYU</span>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <?php
                  include("side_bar_menu.php");
                  echo side_bar();
                  ?>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->

            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content################################# -->
        <div class="right_col" role="main">
            <!-- Question -->
            <div class="x_panel">
                <!-- title bar-->
                <div class="x_title">
                  <h1>
                      <b>題目</b>
                      <!--button type="button" id="zeroquiz" class="btn btn-success btn-lg" style="float: right;">歸零(test)</button-->
                      <button type="button" class="btn btn-success btn-lg" onClick = "timedMsg()" style="float: right;">5秒換題</button>
                      <button type="button" id="lastquiz" class="btn btn-danger btn-lg" style="float: right;">前一題</button>
                      <button type="button" id="nextquiz" class="btn btn-success btn-lg" style="float: right;">換題</button>
                  </h1>

                  <div class="clearfix"></div>
                </div>
                <!-- title bar-->


                <!-- style for img-->
                <style>
                .responsive {
                  width: 100%;
                  max-width: 650px;
                  height: auto;
                }
                </style>
                <!-- Question content-->
                <div class="x_content">
                      <div class="bs-example" data-example-id="simple-jumbotron">
                        <div class="jumbotron">
                            <h1>
                                <?php
                                    include("connects.php");

                                    $sql = "SELECT * FROM QuestionList WHERE No like '$q_list[$exam_index]' AND QA like 'Q'";
                                    if($stmt = $db->query($sql))
                                    {
                                        while($result = mysqli_fetch_object($stmt))
                                        {
                                          $q_type=$result->type;
                                          $picture_ext = $result->picture_ext;
                                          echo '<p style="font-size:60px;"><b>題號: '.$question_number.'</b></p>';
                                          echo '<p style="font-size:60px;"><b>'.$result->Content.'</b></p>';
                                          if(!(empty($picture_ext)||is_null($picture_ext)))//if have picture in the question
                                          {
                                            if(strpos($picture_ext,'upload') === false)
                                            {
                                              echo '<div class="col-lg-6 col-md-6">';
                                              echo '<p></p>';
                                              echo '<img src="upload/Q';
                                              echo $q_list[$exam_index];
                                              echo 'Q1.';
                                              echo $result->picture_ext;
                                              echo '" class="responsive" style="max-height:100%;max-width:100%;border:5px; border-color:#A0A0A0; border-style: double;">';
                                              echo '</div>';
                                            }
                                          }
                                          if (!empty($result->video))
                                          {
                                            echo '<div class="col-lg-6 col-md-6" style="text-align: center;">';
                                            echo '<video width="960" class="center" controls>';
                                            echo '<source src="'.$result->video.'" type="video/mp4" />';
                                            echo '</video>';
                                            echo '</div>';
                                          }

                                          if (!empty($result->audio))
                                          {
                                            echo '<audio controls>';
                                            echo '<source src="upload/Q'.$q_list[$exam_index].'.mp3" type="audio/mpeg">';
                                            echo '</audio><p>';
                                          }
                                        }

                                    }
                                    $db->close();

                                ?>
                            </h1>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                </div>
                <!-- Question content-->
            </div>
            <!-- Question -->




            <script type="text/javascript">

            function timedMsg()
            {
            var t=setTimeout("runnext()",5000);
            }

            function runnext()
            {
              $.ajax
                       (
                          {
                          type: "POST",
                          url: "changeNext.php",
                          data: { name: "Next" }
                          }
                       ).done(function( msg ) {});
                       //location.reload();
            }


            </script>



        <!-- page content################################# -->

        <!-- footer content -->
        <!--footer>
        <!--/footer>
        <!-- /footer content -->


      </div>
    </div>







            <!-- jQuery -->
            <script src="../vendors/jquery/dist/jquery.min.js"></script>
            <!-- Bootstrap -->
            <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
            <!-- FastClick -->
            <script src="../vendors/fastclick/lib/fastclick.js"></script>
            <!-- NProgress -->
            <script src="../vendors/nprogress/nprogress.js"></script>
            <!-- Chart.js -->
            <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
            <!-- gauge.js -->
            <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
            <!-- bootstrap-progressbar -->
            <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
            <!-- iCheck -->
            <script src="../vendors/iCheck/icheck.min.js"></script>
            <!-- Skycons -->
            <script src="../vendors/skycons/skycons.js"></script>
            <!-- Flot -->
            <script src="../vendors/Flot/jquery.flot.js"></script>
            <script src="../vendors/Flot/jquery.flot.pie.js"></script>
            <script src="../vendors/Flot/jquery.flot.time.js"></script>
            <script src="../vendors/Flot/jquery.flot.stack.js"></script>
            <script src="../vendors/Flot/jquery.flot.resize.js"></script>
            <!-- Flot plugins -->
            <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
            <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
            <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
            <!-- DateJS -->
            <script src="../vendors/DateJS/build/date.js"></script>
            <!-- JQVMap -->
            <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
            <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
            <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
            <!-- bootstrap-daterangepicker -->
            <script src="../vendors/moment/min/moment.min.js"></script>
            <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

            <!-- Custom Theme Scripts -->
            <script src="../build/js/custom.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>

            <script type="text/javascript">
                 $('#nextquiz').click(function()
                    {
                      if (<?php echo $question_number; ?> == <?php echo $q_list_number-1; ?>)
                      {
                        location.href = 'ExamFinish.php';
                      }
                      else
                      {
                         $.ajax
                         (
                            {
                            type: "POST",
                            url: "changeNext.php",
                            data: { name: "Next" }
                            }
                         ).done(function( msg ) {});
                         //location.reload();
                         setTimeout('location.reload();',300);
                      }
                    });

                 $('#lastquiz').click(function()
                    {
                       $.ajax
                       (
                          {
                          type: "POST",
                          url: "changeLast.php",
                          data: { name: "Last" }
                          }
                       ).done(function( msg ) {});
                       //location.reload();
                      setTimeout('location.reload();',300);

                    });

                 $('#zeroquiz').click(function()
                    {
                         $.ajax
                         (
                            {
                            type: "POST",
                            url: "updateData.php",
                            data: { name: "Zero" }
                            }
                         ).done(function( msg ) {});
                         location.reload();
                    });
            </script>
  </body>
</html>
