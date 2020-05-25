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
/*
$ExamNumber = $_POST['search_exam'];
$ExamDate = $_POST['search_date'];
$StudentList = $_POST['student'];
*/
$ExamNumber = 10;
$ExamDate = '2020-05-20';
$StudentList = ['student1','student2'];
echo $ExamNumber.'  '.$ExamDate;
print_r($StudentList);

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
                  <h1><b>學生清單</b></h1>
                  <div class="clearfix"></div>
                </div>
                <!-- title bar-->

                <!-- Student List Table -->
                <table id="e_list" class="table table-striped table-bordered">
                  <thead>
                    <tr>
		                  <th>題號</th>
                      <th>題目</th>
                      <th>正解</th>
                      <th>答對</th>
                      <th>答錯</th>
                    </tr>
                  </thead>


                  <?php
                    include("connects.php");
                    include("CalculateScore.php");
                    $sql = "SELECT question_list FROM ExamList WHERE No = $ExamNumber ";
                    $result = mysqli_fetch_object($db->query($sql));
                    $question_list = $result->question_list;
                    //echo $question_list;
                    $question_number_array = array();
                    $question_number_array = explode(",",$question_list);
                    $question_count = count($question_number_array);
                    //print_r($question_array);
                    print_r($question_number_array);

                    //GET THE QUESTUON'S CONTENT AND CURRECT ANSWER
                    $content_array = array();
                    $ca_array = array();
                    foreach ($question_number_array as $key => $value) {
                      $q_number = $question_number_array[$key];
                      $sql_q = "SELECT * FROM QuestionList WHERE No=$q_number AND QA='Q' ";
                      $result_q = mysqli_fetch_object($db->query($sql_q));
                      array_push($content_array, $result_q->Content);
                      array_push($ca_array, $result_q->CA);
                      //$ca_array[0]=> A1,A2
                      //$ca_array[0]=> A1,A3,A5..
                    }

                    //GET STUDENT'S AnswerRecord
                    $student_answer_array = array();
                    foreach ($StudentList as $key => $value) {
                      $student_id = $StudentList[$key];
                      $sql_student_result = "SELECT Answer FROM ExamResult WHERE ExamNo = '$ExamNumber' AND WhosAnswer = '$student_id' AND ExamTime LIKE '$ExamDate%' ";
                      //echo $sql_student_result;
                      $result_sq = mysqli_fetch_object($db->query($sql_student_result));
                      $student_answer_array[$key]= $result_sq->Answer;
                      //$student_answer_array[0]=> N-N-A1,A2-N-N
                      //$student_answer_array[1]=> A1-A2-A1,A2-A1-A1
                    }

                    //COUNT CURRECT ANSWER'S NUMBER
                    $good_array = array();//array index = question_index, good_array[0] = 10, means 10 students have currect answer in question 1
                    $wrong_array = array();//array index = question_index, wrong_array[2] = 7, means 7 students answer wrong answer in question 3
                    $student_number = count($StudentList);
                    foreach ($ca_array as $key => $value) {
                      $good_array[$key] = 0;
                      $wrong_array[$key] = 0;
                    }
                    foreach ($ca_array as $key => $value) {
                      for ($i = 0 ; $i < $student_number ; $i++)
                      {
                        $temp = array();
                        $temp = explode('-',$student_answer_array[$i]);
                        if($ca_array[$key] == $temp[$key])
                        {
                          $good_array[$key]+=1;
                        }
                        else
                        {
                          $wrong_array[$key]+=1;
                        }
                      }
                    }
                    //wrong_array[i] + good_array[i] = all student's number

                    $ca_array_to_json = json_encode((array)$ca_array);
                    $content_array_to_json = json_encode((array)$content_array);
                    $good_array_to_json = json_encode((array)$good_array);
                    $wrong_array_to_json = json_encode((array)$wrong_array);

                    //Cal Student's score
                    $ExamResultNo_array = array();
                    $Score_array = array();
                    foreach ($StudentList as $key => $value) {
                      $sql_get_resultno = "SELECT No FROM ExamResult WHERE ExamNo = '$ExamNumber' AND WhosAnswer = '$StudentList[$key]' AND ExamTime LIKE '$ExamDate%' ";
                      $resultno = mysqli_fetch_object($db->query($sql_get_resultno));
                      //echo $resultno->No.'  ';
                      array_push($ExamResultNo_array,$resultno->No); //$ExamResultNo_array[0]=>205, $ExamResultNo_array[1]=>206...
                      $score = calScore($ExamResultNo_array[$key], $ExamNumber);
                      array_push($Score_array, $score);//$Score_array[0]=>11,...
                    }

                    $temp_array = array();
                    $temp_array = $Score_array;



                    $StudentNum = count($StudentList);
                    $HighLevelPeopleCount = floor($StudentNum*0.27);//高分組人數
                    $LowLevelPeopleCount = floor($StudentNum*0.27);//低分組人數

                    if($HighLevelPeopleCount==0)$HighLevelPeopleCount=1;
                    if($LowLevelPeopleCount==0)$LowLevelPeopleCount=1;

                    rsort($temp_array);//由大到小排列分數
                    $HighLevelLimit = $temp_array[$HighLevelPeopleCount-1];//分數為$HighLevelLimit以上為高分組

                    sort($temp_array);//由小道大排列分數
                    $LowLevelLimit = $temp_array[$HighLevelPeopleCount-1];//分數為$LowLevelLimit以下為低分組

                    echo'高分組門檻：'.$HighLevelLimit.' 低分組門檻：'.$LowLevelLimit;



                  ?>

                  <tbody>
                    <tr>
                      <?php
		                  echo '<td>1</td>';
                      echo '<td>'.$content_array[0].'</td>';
                      echo '<td>'.$ca_array[0].'</td>';
                      echo '<td>'.$good_array[0].'</td>';
                      echo '<td>'.$wrong_array[0].'</td>';
                      ?>
                    </tr>
                  </tbody>
                </table>
                <!-- Student List Table -->

            </div>
            <!-- Exam -->










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



            <script type="text/javascript" class="init">
                $('#e_list').dataTable( {
                  "columns": [
		                { "width": "5%" },
                    { "width": "20%" },
                    { "width": "35%" },
                    { "width": "20%" },
                    { "width": "20%" },
                  ]
                } );


                $(document).ready
                (
                    function()
                        {
			                    var ca_arrayfromPHP =<? echo $ca_array_to_json ?>;
                          var content_arrayfromPHP=<? echo $content_array_to_json ?>;
                          var good_arrayfromPHP=<? echo $good_array_to_json ?>;
                          var wrong_arrayfromPHP=<? echo $wrong_array_to_json ?>;

                          var t = $('#e_list').DataTable();
                          for (var i=1 ; i< <?php echo "$question_count";?> ; i++)
                          {
                            t.row.add(
                            [
                            i+1,
                            content_arrayfromPHP[i],
			                      ca_arrayfromPHP[i],
                            good_arrayfromPHP[i],
                            wrong_arrayfromPHP[i],
                            ]).draw(false);
                          }
                        }
                );
            </script>


  </body>
</html>
