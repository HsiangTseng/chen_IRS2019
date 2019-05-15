<!DOCTYPE html>

<?php
session_start();
if($_SESSION['username'] == null)
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
                  <!--li><a href="home.php"><i class="fas fa-pencil-alt fa-2x" ></i> 考試 </a></li-->
                  <li><a href="MakeQuestion.php"><i class="fas fa-edit fa-2x" aria-hidden="true"></i> 出題 </a></li>
                  <li><a href="QuestionList.php"><i class="fas fa-book fa-2x" aria-hidden="true"></i> 題庫 </a></li>
                  <li><a href="ExamList.php"><i class="fas fa-list-ol fa-2x" aria-hidden="true"></i> 測驗卷 </a></li>
                  <li><a href="ExamHistory.php"><i class="fas fa-list-ol fa-2x" aria-hidden="true"></i> 考試紀錄 </a></li>
                  <li><a href="logout.php"><i class="fas fa-arrow-alt-circle-left fa-2x" aria-hidden="true"></i> 登出 </a></li>
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
                  <h1><b>考試紀錄</b></h1>
                  <div class="clearfix"></div>
                </div>
                <!-- title bar-->

                <!-- Exam List Table -->
                <table id="e_list" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>測驗卷名稱</th>
                      <th>出題老師</th>
                      <th>測驗時間</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>

                  </tbody>
                </table>
                <!-- Exam List Table -->

            </div>
            <!-- Exam -->

          <div>
            <form  class="form-horizontal form-label-left" method="post" action="ExamResult.php" onKeyDown="if (event.keyCode == 13) {return false;}">
                    <div class="form-group">
                        <label class="control-label col-md-10" for="last-name">請輸入要查閱成績的測驗卷編號 : <span></span></label>
                        <div class="col-md-1">
                          <input type="text"  name="result_number" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <button type="submit" class="btn btn-dark btn-md">查閱</button>
                    </div>
            </form>
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
              include("connects.php");
              $sql = "SELECT MAX(No) AS max FROM ExamResult";
              $result = mysqli_fetch_object($db->query($sql));
              $max_number = $result->max;
              $ExamNo = array();
              $ExamTime = array();
              $ExamTitle = array();
              $Teacher = array();
              for ( $a = 1 ; $a<=$max_number ; $a++)
              {
                $sql2 = "SELECT `ExamNo`,`ExamTime` FROM `ExamResult` WHERE `No` =$a";
                $result2 = mysqli_fetch_object($db->query($sql2));
                $ExamNo[$a] = $result2->ExamNo;
                $ExamTime[$a] = $result2->ExamTime;


                $sql = "SELECT ExamTitle,Teacher,Note FROM ExamList WHERE No = '$ExamNo[$a]'";
                $result = mysqli_fetch_object($db->query($sql));
                $ExamTitle[$a] = $result->ExamTitle;
                $Teacher[$a] = $result->Teacher;

                $ExamTitle_to_json=json_encode((array)$ExamTitle);
                $ExamNo_to_json=json_encode((array)$ExamNo);
                $ExamTime_to_json=json_encode((array)$ExamTime);
                $Teacher_to_json=json_encode((array)$Teacher);
              }
            ?>

            <script type="text/javascript" class="init">
                $('#e_list').dataTable( {
                  "columns": [
                    { "width": "15%" },
                    { "width": "25%" },
                    { "width": "20%" },
                    { "width": "40%" },
                  ]
                } );

                $(document).ready
                (
                    function() 
                        {
                          var ExamTitlefromPHP=<? echo $ExamTitle_to_json ?>;
                          var ExamTimefromPHP=<? echo $ExamTime_to_json ?>;
                          var TeacherfromPHP=<? echo $Teacher_to_json ?>;
                          var t = $('#e_list').DataTable();
                          for (var i=1 ; i<= <?php echo "$max_number";?> ; i++)
                          {
                            t.row.add(
                            [
                            i,
                            ExamTitlefromPHP[i],
                            TeacherfromPHP[i],
                            ExamTimefromPHP[i],
                            ]).draw(false);
                          } 
                        }

                );
            </script>


  </body>
</html>