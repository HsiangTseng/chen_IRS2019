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

$ExamResultNoList = $_POST['chosen_student'];

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
                  <h1><b>資料統計</b></h1>
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
                      <th>難易度</th>
                      <th>鑑別度</th>

                    </tr>
                  </thead>


                  <?php
                    include("connects.php");
                    include("CalculateScore.php");
                    //Get ExamNo
                    $sql = "SELECT ExamNo FROM ExamResult WHERE No = '$ExamResultNoList[0]' ";
                    $result = mysqli_fetch_object($db->query($sql));
                    $ExamNumber = $result->ExamNo;
                    //echo ' '.$ExamNumber;

                    //Get question_list
                    $sql = "SELECT question_list FROM ExamList WHERE No = $ExamNumber ";
                    $result = mysqli_fetch_object($db->query($sql));
                    $question_list = $result->question_list;
                    //echo $question_list;
                    $question_number_array = array();
                    $question_number_array = explode(",",$question_list);
                    $question_count = count($question_number_array);
                    //print_r($question_array);
                    //print_r($question_number_array);

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
                    foreach ($ExamResultNoList as $key => $value) {
                      //$student_id = $StudentList[$key];
                      //$sql_student_result = "SELECT Answer FROM ExamResult WHERE ExamNo = '$ExamNumber' AND WhosAnswer = '$student_id' AND UUID = '$UUID' AND ExamTime LIKE '$ExamDate%' ";
                      $sql_student_result = "SELECT Answer FROM ExamResult WHERE No = '$ExamResultNoList[$key]' ";
                      //echo $sql_student_result;
                      $result_sq = mysqli_fetch_object($db->query($sql_student_result));
                      $student_answer_array[$key]= $result_sq->Answer;
                      //$student_answer_array[0]=> N-N-A1,A2-N-N
                      //$student_answer_array[1]=> A1-A2-A1,A2-A1-A1
                    }

                    //COUNT CURRECT ANSWER'S NUMBER
                    $good_array = array();//array index = question_index, good_array[0] = 10, means 10 students have currect answer in question 1
                    $wrong_array = array();//array index = question_index, wrong_array[2] = 7, means 7 students answer wrong answer in question 3
                    $student_number = count($ExamResultNoList);
                    foreach ($ca_array as $key => $value) {
                      $good_array[$key] = 0;
                      $wrong_array[$key] = 0;
                    }
                    foreach ($question_number_array as $key => $value) {
                      for ($i = 0 ; $i < $student_number ; $i++)
                      {
                        $temp = array();
                        $temp = explode('-',$student_answer_array[$i]);
                        //echo $temp[$key].'*<br />';
                        //if($ca_array[$key] == $temp[$key]);
                        $s = GetQuestionsScore($question_number_array[$key],$temp[$key]);
                        if($s > 0)
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



                    //Cal Student's score
                    $ExamResultNo_array = array();
                    $Score_array = array();
                    foreach ($ExamResultNoList as $key => $value) {
                      //$sql_get_resultno = "SELECT No FROM ExamResult WHERE ExamNo = '$ExamNumber' AND WhosAnswer = '$StudentList[$key]' AND UUID = '$UUID' AND ExamTime LIKE '$ExamDate%' ";
                      //$resultno = mysqli_fetch_object($db->query($sql_get_resultno));
                      //echo $resultno->No.'  ';
                      //array_push($ExamResultNo_array,$resultno->No); //$ExamResultNo_array[0]=>205, $ExamResultNo_array[1]=>206...
                      $score = calScore($ExamResultNoList[$key], $ExamNumber);
                      array_push($Score_array, $score);//$Score_array[0]=>11,...
                    }

                    $temp_array = array();
                    $temp_array = $Score_array;



                    $StudentNum = count($ExamResultNoList);
                    $HighLevelPeopleCount = floor($StudentNum*0.27);//高分組人數
                    $LowLevelPeopleCount = floor($StudentNum*0.27);//低分組人數

                    if($HighLevelPeopleCount==0)$HighLevelPeopleCount=1;
                    if($LowLevelPeopleCount==0)$LowLevelPeopleCount=1;

                    rsort($temp_array);//由大到小排列分數
                    $HighLevelLimit = $temp_array[$HighLevelPeopleCount-1];//分數為$HighLevelLimit以上為高分組
                    sort($temp_array);//由小到大排列分數
                    $LowLevelLimit = $temp_array[$HighLevelPeopleCount-1];//分數為$LowLevelLimit以下為低分組

                    //重新確認高低分組人數
                    //若高分組人數為4人，但前幾分數為25,24,23,23,23,23,23則高分組門檻為23分，而所有分數大於等於23者皆為高分組，低分組同理
                    //若前幾分數為25,24,24,23,22,21..則照原規則取最高分四人（因只有一位23分）
                    $new_HighLevelPeopleCount = 0;
                    $new_LowLevelPeopleCount = 0;
                    for($i = 0 ; $i < $student_number ; $i++)
                    {
                      if($Score_array[$i]>=$HighLevelLimit)
                      {
                        $new_HighLevelPeopleCount += 1;
                      }
                      if($Score_array[$i]<=$LowLevelLimit)
                      {
                        $new_LowLevelPeopleCount += 1;
                      }
                    }
                    if($new_HighLevelPeopleCount>$HighLevelPeopleCount)
                    {
                      $HighLevelPeopleCount = $new_HighLevelPeopleCount; //若高分組人數超過原高分組人數，則更新高分組人數
                    }
                    if($new_LowLevelPeopleCount>$LowLevelPeopleCount)
                    {
                      $LowLevelPeopleCount = $new_LowLevelPeopleCount;
                    }



                    echo'高分組門檻：'.$HighLevelLimit.', 低分組門檻：'.$LowLevelLimit.', 高分組'.$HighLevelPeopleCount.'人, 低分組'.$LowLevelPeopleCount.'人';
                    echo'<br />'.'*難易度運算:(該題高分組答對率+該題低分組答對率)/2';
                    echo'<br />'.'*鑑別度運算:(高分組答對率-低分組答對率)';
                    echo'<br />答對：該學生於該題得分1分以上, 答錯：學生於該題得分為0分';

                    /*print_r($Score_array);
                    rsort($temp_array);//由大到小排列分數
                    echo '<br />';
                    print_r($temp_array);*/

                    $HighLevelCount = array();
                    $LowLevelCount = array();
                    for($i = 0 ; $i < $question_count ; $i++)
                    {
                      $HighLevelCount[$i]=0;
                      $LowLevelCount[$i]=0;
                    }


                    for ($i = 0 ; $i < $question_count ; $i++){
                      for ($j = 0 ;$j < $student_number ; $j++){
                        $temp = array();
                        $temp = explode('-',$student_answer_array[$j]);
                        $s = GetQuestionsScore($question_number_array[$i],$temp[$i]);
                        if($s>0)//如果該學生答對
                        {
                          if($Score_array[$j]>=$HighLevelLimit)//且該學生為高分組
                          {
                            $HighLevelCount[$i]+=1;//此題的高分組答對人數++
                          }
                          if($Score_array[$j]<=$LowLevelLimit)//且該學生為低分組
                          {
                            $LowLevelCount[$i]+=1;//此題的低分組答對人數++
                          }
                        }
                      }
                    }

                    $Difficulty_array = array();//每題的難易度
                    $Discrimination_array = array();//每題的鑑別度

                    for ($i = 0 ; $i < $question_count ; $i++)
                    {
                      $HighPercent = $HighLevelCount[$i]/$HighLevelPeopleCount;//高分組答對率
                      $LowPercent = $LowLevelCount[$i]/$LowLevelPeopleCount;//低分組答對率
                      $diff = ($HighPercent+$LowPercent)/2;//難易度=(高分組答對率+低分組答對率)/2
                      $Dis = $HighPercent-$LowPercent;//鑑別度=(高分組答對率-低分組答對率)
                      array_push($Difficulty_array,$diff);
                      array_push($Discrimination_array,$Dis);
                    }

                    for ($i = 0 ; $i < $question_count ; $i++)
                    {
                      $Difficulty_array[$i] = floor($Difficulty_array[$i]*100)/100; //至保留小數點後兩位, ex:13.33333->1333->13.33
                      $Discrimination_array[$i] = floor($Discrimination_array[$i]*100)/100;
                    }
                    //print_r($Score_array);
                    //print_r($HighLevelCount);
                    //echo '<br />'.$HighLevelPeopleCount;

                    $ca_array_to_json = json_encode((array)$ca_array);
                    $content_array_to_json = json_encode((array)$content_array);
                    $good_array_to_json = json_encode((array)$good_array);
                    $wrong_array_to_json = json_encode((array)$wrong_array);
                    $HighLevelCount_to_json = json_encode((array)$HighLevelCount);
                    $LowLevelCount_to_json = json_encode((array)$LowLevelCount);
                    $Difficulty_array_to_json = json_encode((array)$Difficulty_array);
                    $Discrimination_array_to_json = json_encode((array)$Discrimination_array);

                  ?>

                  <tbody>
                    <tr>
                      <?php
		                  echo '<td>1</td>';
                      echo '<td>'.$content_array[0].'</td>';
                      echo '<td>'.$ca_array[0].'</td>';
                      echo '<td>'.$good_array[0].'</td>';
                      echo '<td>'.$wrong_array[0].'</td>';
                      echo '<td>'.$HighLevelCount[0].'</td>';
                      echo '<td>'.$LowLevelCount[0].'</td>';
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
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "10%" },
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
                          var HighCount =<? echo $HighLevelCount_to_json ?>;
                          var LowCount =<? echo $LowLevelCount_to_json ?>;
                          var Diff_arrayfromPHP =<? echo $Difficulty_array_to_json ?>;
                          var Dis_arrayfromPHP =<? echo $Discrimination_array_to_json ?>;
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
                            Diff_arrayfromPHP[i],
                            Dis_arrayfromPHP[i],
                            ]).draw(false);
                          }
                        }
                );
            </script>


  </body>
</html>
