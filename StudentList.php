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
		      <th>編號</th>
                      <th>姓名</th>
                      <th>性別</th>
                      <th>學校</th>
                      <th>年級</th>
                      <th>施測時間</th>
                      <th>施測人員</th>
                      <th>障礙類別</th>
		      <th>編輯</th>
                    </tr>
                  </thead>


                  <?php
                    include("connects.php");
                    $sql = "SELECT COUNT(Name) AS max FROM UserList WHERE type = 'S'";
                    $result = mysqli_fetch_object($db->query($sql));
                    $max_number = $result->max;
		    $studentnumber = array();
                    $name = array();
                    $school = array();
                    $gender = array();
                    $grade = array();
                    $test_time = array();
                    $teacher = array();
                    $category = array();
                    for ( $a = 1 ; $a<=$max_number ; $a++)
                    {
                      $sql2 = "SELECT * FROM `UserList` WHERE `type` ='S' AND `StudentNumber` = $a";
                      $result2 = mysqli_fetch_object($db->query($sql2));
		      $studentnumber[$a] = $result2->StudentNumber;
                      $name[$a] = $result2->Name;
                      $school[$a] = $result2->School;
                      $gender[$a] = $result2->Gender;
                      if($gender[$a]=='boy')$gender[$a]='男';
                      else $gender[$a]='女';
                      $grade[$a] = $result2->Grade;
                      $test_time[$a] = $result2->TestTime;
                      $teacher[$a] = $result2->TestTeacher;
                      $category[$a] = $result2->Category;

                      if($category[$a]=='0'){$category[$a]='一般生';}
                      if($category[$a]=='1'){$category[$a]='智能障礙';}
                      if($category[$a]=='2'){$category[$a]='視覺障礙';}
                      if($category[$a]=='3'){$category[$a]='聽覺障礙';}
                      if($category[$a]=='4'){$category[$a]='語言障礙';}
                      if($category[$a]=='5'){$category[$a]='腦性麻痺';}
                      if($category[$a]=='6'){$category[$a]='肢體障礙';}
                      if($category[$a]=='7'){$category[$a]='身體病弱';}
                      if($category[$a]=='8'){$category[$a]='情緒行為障礙';}
                      if($category[$a]=='9'){$category[$a]='學習障礙';}
                      if($category[$a]=='10'){$category[$a]='多重障礙';}
                      if($category[$a]=='11'){$category[$a]='自閉症';}
                      if($category[$a]=='12'){$category[$a]='發展遲緩';}

		      $studentnumber_to_json = json_encode((array)$studentnumber);
                      $name_to_json=json_encode((array)$name);
                      $school_to_json=json_encode((array)$school);
                      $gender_to_json=json_encode((array)$gender);
                      $grade_to_json=json_encode((array)$grade);
                      $test_time_to_json=json_encode((array)$test_time);
                      $teacher_to_json=json_encode((array)$teacher);
                      $category_to_json=json_encode((array)$category);
                    }
                  ?>

                  <tbody>
                    <tr>
                      <?php
		      echo '<td>'.$studentnumber[1].'</td>';
                      echo '<td>'.$name[1].'</td>';
                      echo '<td>'.$gender[1].'</td>';
                      echo '<td>'.$school[1].'</td>';
                      echo '<td>'.$grade[1].'</td>';
                      echo '<td>'.$test_time[1].'</td>';
                      echo '<td>'.$teacher[1].'</td>';
                      echo '<td>'.$category[1].'</td>';
		      echo '<td><button type="submit" class="btn btn-info" onclick="btnclk(1)">編輯</button></td>';
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
		    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "5%" },
                    { "width": "15%" },
                    { "width": "5%" },
                    { "width": "20%" },
                    { "width": "10%" },
                    { "width": "15%" },
          	    { "width": "10%" },
                  ]
                } );
		
		function btnclk(q_index){
			var index = q_index;
			window.location.href = 'StudentStatusView.php?index='+index;
		}

                $(document).ready
                (
                    function() 
                        {
			  var studentnumberfromPHP =<? echo $studentnumber_to_json ?>;
                          var namefromPHP=<? echo $name_to_json ?>;
                          var schoolfromPHP=<? echo $school_to_json ?>;
                          var genderfromPHP=<? echo $gender_to_json ?>;
                          var gradefromPHP=<? echo $grade_to_json ?>;
                          var test_timefromPHP=<? echo $test_time_to_json ?>;
                          var teacherfromPHP=<? echo $teacher_to_json ?>;
                          var categoryfromPHP=<? echo $category_to_json ?>;
                          var t = $('#e_list').DataTable();
                          for (var i=2 ; i<= <?php echo "$max_number";?> ; i++)
                          {
                            t.row.add(
                            [
			    studentnumberfromPHP[i],
                            namefromPHP[i],
                            genderfromPHP[i],
                            schoolfromPHP[i],
                            gradefromPHP[i],
                            test_timefromPHP[i],
                            teacherfromPHP[i],
                            categoryfromPHP[i],
         		    "<button type=\"submit\" class=\"btn btn-info\" onclick=\"btnclk("+studentnumberfromPHP[i]+")\">編輯</button>",

                            ]).draw(false);
                          } 
                        }

                );
            </script>


  </body>
</html>
