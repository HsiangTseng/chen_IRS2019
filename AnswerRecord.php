<!DOCTYPE html>

<?php
session_start();

if($_SESSION['username'] == null)
{
        header ('location: IRS_Login.php');
        exit;
}
else if ($_SESSION['type']!='T')
{
    header ('location: IRS_Login.php');
    exit;
}
?>

<?php
$ExamResultNo = $_GET['ExamResultNo'];
$WhosAnswer = $_GET['WhosAnswer'];
//echo $_GET['ExamResultNo'];
//echo $_GET['WhosAnswer'];
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
            <!-- DataTable -->
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">

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

            
            <!-- Exam -->
            <div class="x_panel">
                <!-- title bar-->
                <div class="x_title">
                  <h1><b>測驗卷</b></h1>
                  <div class="clearfix"></div>
                </div>
                <!-- title bar-->

                <!-- Exam List Table -->
                <table id="e_list" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>題號</th>
                      <th>題型</th>
                      <th>題目</th>
                      <th>正確答案</th>
                      <th>學生答案</th>
                      <th>作答時間(秒)</th>
                    </tr>
                  </thead>


                  <?php
                    include("connects.php");

                    //GET STUDENT ANSWER
                    $sql = "SELECT * FROM ExamResult WHERE No=$ExamResultNo";
                    $result = mysqli_fetch_object($db->query($sql));
                    $ExamListNumber = $result->ExamNo;
                    $student_answer = $result->Answer;
                    $sa_array = explode('-', $student_answer);
                    $answer_time = $result->AnswerTime;
                    $answer_time_array = explode('-',$answer_time);

                    //GET CORRECT ANSWER AND QUESTION
                    $sql_ca = "SELECT * FROM ExamList WHERE No = $ExamListNumber";
                    $result_ca = mysqli_fetch_object($db->query($sql_ca));
                    $question_list = $result_ca->question_list;
                    $question_array = explode(",", $question_list);

                    $answer_string = "";
                    $question_string = "";
                    $type_string = "";
                    $single_or_multi_string = "";
                    foreach ($question_array as $value) {
                      $sql_a = "SELECT * FROM QuestionList WHERE QA='Q' AND No = $value";
                      $result_a = mysqli_fetch_object($db->query($sql_a));
                      $answer_string = $answer_string.$result_a->CA.'-';
                      $question_string = $question_string.$result_a->Content.'*-*';
                      $type_string = $type_string.$result_a->type.'-';
                      $single_or_multi_string = $single_or_multi_string.$result_a->single_or_multi.'-';
                    }
                    $answer_string = substr($answer_string, 0,-1);//DELETE THE LAST '-' CHARACTER
                    $ca_array = explode('-', $answer_string);

                    $type_string = substr($type_string, 0,-1);
                    $type_array = explode('-', $type_string);

                    $single_or_multi_string = substr($single_or_multi_string, 0,-1);
                    $single_or_multi_array = explode('-', $single_or_multi_string);

                    $question_string = substr($question_string, 0,-3);
                    $q_array = explode('*-*', $question_string);
                    //print_r($q_array);


                    /*
                    variable table
                    sa_array ==> student's answer [ARRAY]
                    ca_array ==> correct answer [ARRAY]
                    q_array ==> question content [ARRAY]
                    answer_time_array ==> the answer time that student use [ARRAY]
                    ExamListNumber ==> which exam [var]
                    ExamResultNo ==> Sequence number in examresult [var]

                    */

                    $Q_TO_JSON = json_encode((array)$q_array);
                    $SA_TO_JSON = json_encode((array)$sa_array);
                    $CA_TO_JSON = json_encode((array)$ca_array);
                    $ANSWERTIME_TO_JSON = json_encode((array)$answer_time_array);
                   
                  ?>

                  <tbody>
                    <tr>
                      <?php
                      echo '<td>1</td>';
                      echo '<td>TYPE</td>';
                      echo '<td>'.$q_array[0].'</td>';
                      echo '<td>'.$ca_array[0].'</td>';
                      echo '<td>'.$sa_array[0].'</td>';
                      echo '<td>'.$answer_time_array[0].'</td>';
                      ?>
                    </tr>

                  </tbody>
                </table>
                <!-- Exam List Table -->

            </div>
            <!-- Exam -->



        <!-- page content################################# -->


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
            <!-- DataTable -->
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

            <!-- Custom Theme Scripts -->
            <script src="../build/js/custom.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>



            <script type="text/javascript" class="init">
                $('#e_list').dataTable( {
                  "columns": [
                    { "width": "5%" },
                    { "width": "10%" },
                    { "width": "25%" },
                    { "width": "25%" },
                    { "width": "25%" },
                    { "width": "10%" },
                  ]
                } );

                $(document).ready
                (
                    function() 
                        {
                          var QfromPHP=<? echo $Q_TO_JSON ?>;
                          var CAfromPHP=<? echo $CA_TO_JSON ?>;
                          var SAfromPHP=<? echo $SA_TO_JSON ?>;
                          var ASTfromPHP=<? echo $ANSWERTIME_TO_JSON ?>;
                          var t = $('#e_list').DataTable();
                          for (var i=1 ; i<= <?php echo count($ca_array)-1;?> ; i++)
                          {
                            t.row.add(
                            [
                            i,
                            "TYPE",
                            QfromPHP[i],
                            CAfromPHP[i],
                            SAfromPHP[i],
                            ASTfromPHP[i],
                            ]).draw(false);
                          } 
                        }

                );
            </script>


  </body>
</html>