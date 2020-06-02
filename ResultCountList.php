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
                  <?php
                    include("connects.php");
                    include("CalculateScore.php");
                    //Get ExamNo
                    $sql = "SELECT ExamNo FROM ExamResult WHERE No = '$ExamResultNoList[0]' ";
                    $result = mysqli_fetch_object($db->query($sql));
                    $ExamNumber = $result->ExamNo;
                    //echo ' '.$ExamNumber;

                    //Get Students' name
                    $StudentName_array = array();
                    foreach ($ExamResultNoList as $key => $value) {
                      $sql = "SELECT WhosAnswer FROM ExamResult WHERE No = '$ExamResultNoList[$key]' ";
                      $result = mysqli_fetch_object($db->query($sql));
                      $whos = $result->WhosAnswer;

                      $sql_user = "SELECT Name FROM UserList WHERE id = '$whos' ";
                      $result_user = mysqli_fetch_object($db->query($sql_user));
                      $name = $result_user->Name;

                      array_push($StudentName_array,$name);
                    }
                    //print_r($StudentName_array);

                    //Get question_list
                    $sql = "SELECT question_list FROM ExamList WHERE No = $ExamNumber ";
                    $result = mysqli_fetch_object($db->query($sql));
                    $question_list = $result->question_list;
                    //echo $question_list;
                    $question_number_array = array();
                    $question_number_array = explode(",",$question_list);
                    $question_count = count($question_number_array);
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
                      $sql_student_result = "SELECT Answer FROM ExamResult WHERE No = '$ExamResultNoList[$key]' ";
                      //echo $sql_student_result;
                      $result_sq = mysqli_fetch_object($db->query($sql_student_result));
                      $student_answer_array[$key]= $result_sq->Answer;
                      //$student_answer_array[0]=> N-N-A1,A2-N-N
                      //$student_answer_array[1]=> A1-A2-A1,A2-A1-A1
                    }

                    $student_number = count($ExamResultNoList);
                    $FinalCount_array = array();
                    //$FinalCount_array[題號][學生編號] = -1,0,1 (-1表程式錯誤,0為未得分或未答,1為有得分)
                    for ($i = 0 ; $i < $question_count ; $i++){
                      for ($j = 0 ;$j < $student_number ; $j++){
                        $FinalCount_array[$i][$j] = -1;
                      }
                    }

                    for ($i = 0 ; $i < $question_count ; $i++){
                      for ($j = 0 ;$j < $student_number ; $j++){
                        $temp = array();
                        $temp = explode('-',$student_answer_array[$j]);
                        $s = GetQuestionsScore($question_number_array[$i],$temp[$i]);
                        if($s>0)//如果該學生答對
                        {
                          $FinalCount_array[$i][$j] = 1;
                        }
                        else
                        {
                          $FinalCount_array[$i][$j] = 0;
                        }
                      }
                    }

                    $FinalCount_array_to_json = json_encode((array)$FinalCount_array);
                    $StudentName_array_to_json = json_encode((array)$StudentName_array);


                  ?>
                <!-- Student List Table -->
                <div style=overflow:auto;>
                  <table id="e_list" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>學生</th>
                        <?php
                          for ($i = 0 ; $i < $question_count ; $i++)
                          {
                            $index = $i+1;
                            echo '<th>'.$index.'</th>';
                          }
                        ?>
                      </tr>
                    </thead>

                    <tbody>
                      <tr>
                        <?php
  		                  echo '<td>'.$StudentName_array[0].'</td>';
                        for ($i = 0 ; $i < $question_count ; $i++)
                        {
                          echo '<td>'.$FinalCount_array[$i][0].'</td>';
                        }
                        ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
                $('#e_list').removeAttr('width').dataTable( {
                  paging : false,
                  "columnDefs": [
                    { width : 80 , targets : 0}
                  ],
                  fixedColumns : true,

                  //rowCallback function用在逐一尋找各td數值,若==0, 更改其css為紅色
                  rowCallback : function(row, data, index){
                    for (i = 1 ; i <= <?php echo "$question_count";?> ; i++)
                    {
                      if(data[i] == 0 )
                      {
                        var td_index = 'td:eq('+i+')'
                        $(row).find(td_index).css('color', 'red');
                      }
                    }
                  }
                } );


                $(document).ready
                (
                    function()
                        {
                          var FinalCountfromPHP = <? echo $FinalCount_array_to_json ?>;
                          var StudentNamefromPHP = <? echo $StudentName_array_to_json ?>;
                          var t = $('#e_list').DataTable();
                          for (var i=1 ; i< <?php echo "$student_number";?> ; i++)
                          {
                            t.row.add(
                            [
                            StudentNamefromPHP[i],
                            <?php
                              for($i = 0 ; $i < $question_count ; $i++)
                              {
                                echo 'FinalCountfromPHP['.$i.'][i],';
                              }
                            ?>
                          ]).draw(false);
                          }
                        }
                );
            </script>


  </body>
</html>
