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
  include("connects.php");

  $get_index = $_POST['result_number']-1;

  $ResultNo = array();
  $sql_b = "SELECT No FROM `ExamResult` GROUP BY UUID ORDER BY No ASC";
  if($stmt_b = $db->query($sql_b))
  {
    while($result_b = mysqli_fetch_object($stmt_b))
    {
      array_push($ResultNo,$result_b->No);
    }
  }

  $result_number = $ResultNo[$get_index];
  //echo $result_number;
  $sql = "SELECT ExamNo,UUID,Answer,ExamTime FROM ExamResult WHERE No = '$result_number'";
  $result = mysqli_fetch_object($db->query($sql));

  $ExamNumber = $result->ExamNo;
  $UID = $result->UUID;
  $Time = $result->ExamTime;

  //echo $ExamNumber.'  '.$UID.'   '.$Time;

  $sql = "SELECT ExamTitle,Teacher FROM ExamList WHERE No = '$ExamNumber'";
  $result = mysqli_fetch_object($db->query($sql));
  $Title = $result->ExamTitle;
  $Teacher = $result->Teacher;

  //echo $Teacher.'  '.$Title;
  //echo $UID;
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
            <link href="../vendors/font-awesome/css/fontawesome-all.css" rel="stylesheet">
            <!-- Font Awesome -->
            <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
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
          <div class="">


            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h1><b>考試成績</b></h1>


                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


                    <!-- start project list -->
                    <table class="table table-striped projects">
                      <thead>
                        <tr>
                          <th style="width: 5%">#</th>
                          <th style="width: 10%">學生姓名</th>
                          <th style="width: 15%">學生考試紀錄編號</th>
                          <th>試卷名稱</th>
                          <th>成績</th>
                          <th>及格狀態</th>
                          <th style="width: 20%">#Edit</th>
                        </tr>
                      </thead>

                      <tbody>

                        <?php
                        $index = 1;
                        include("connects.php");
                        include("CalculateScore.php");


                        $sql = "SELECT * FROM ExamResult WHERE UUID = '$UID'";
                        if($stmt = $db->query($sql))
                            {
                              while($result = mysqli_fetch_object($stmt))
                              {
                                $whosid = $result->WhosAnswer;
                                $sql_user = "SELECT * FROM UserList WHERE id = '$whosid'";
                                $stmtu = $db->query($sql_user);
                                $resultu = mysqli_fetch_object($stmtu);
                                $whosname = $resultu->Name;

                                $sql_examresult = "SELECT No FROM ExamResult WHERE UUID = '$UID' AND WhosAnswer = '$whosid'";
                                $stmt_exam = $db->query($sql_examresult);
                                $result_exam = mysqli_fetch_object($stmt_exam);
                                $exam_result_no = $result_exam->No;
                                echo '<tr>';
                                echo   '<td>'.$index.'</td>';
                                echo   '<td>';
                                echo     '<a>'.$whosname.'</a><br />';
                                echo     '<small>'.$result->WhosAnswer.'</small>';
                                echo   '</td>';
                                echo   '<td>';
                                echo   '<p>'.$exam_result_no.'</p>';
                                echo   '</td>';
                                echo   '<td>';
                                echo     '<p>'.$Title.'</p>';
                                echo   '</td>';
                                echo   '<td class="project_progress">';
                                echo     '<div class="progress progress_sm">';

                                $point = calScore($result->No,$result->ExamNo);

                                if($point >= 60){$state = 'bg-green';}
                                else {$state = 'bg-red';}
                                echo       '<div class="progress-bar '.$state.'" role="progressbar" data-transitiongoal="'.$point.'"></div>';
                                echo     '</div>';
                                echo     '<small>'.$point.' Point.</small>';
                                echo   '</td>';
                                echo   '<td>';
                                if ($point >=60){$button_state = ' btn-success btn-xs">及格</button>';}
                                else {$button_state = ' btn-danger btn-xs">不及格</button>';}
                                echo     '<button type="button" class="btn'.$button_state;
                                echo   '</td>';
                                echo   '<td>';
                                         echo '<a href="'.'AnswerRecord.php?ExamResultNo='.$exam_result_no.'&WhosAnswer='.$whosid.'" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i>作答詳情</a>';
                                echo    '</td>';
                                echo '</tr>';
                                $index ++;
                              }
                            }
                         ?>



                      </tbody>
                    </table>
                    <!-- end project list -->

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
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
            <!-- DataTable -->
            <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>

            <!-- Custom Theme Scripts -->
            <script src="../build/js/custom.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>

            <?php
              function get_score($uid,$student)
              {
                include("connects.php");
                $sql = "SELECT Answer FROM ExamResult WHERE WhosAnswer = 'Teacher' AND UUID = '$uid'";
                $result = mysqli_fetch_object($db->query($sql));
                $answer = '';
                $answer = (string)$result->Answer;

                $sql = "SELECT Answer FROM ExamResult WHERE WhosAnswer = '$student' AND UUID = '$uid'";
                $result = mysqli_fetch_object($db->query($sql));
                $student = '';
                $student = (string)$result->Answer;

                $answer_array=array();
                $student_array=array();
                $answer_array = mb_split("-",$answer);
                $student_array = mb_split("-",$student);

                $score = 0;
                for ($i =0 ; $i < sizeof($answer_array) ; $i++)
                {
                  if( strcmp($answer_array[$i],$student_array[$i] ) == 0)
                  {
                      $score += 10 ;
                  }
                }
                return $score;
              }

            ?>

  </body>
</html>
