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
                  <h1><b>測驗卷</b></h1>
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
                      <th>備註</th>
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
            <form  class="form-horizontal form-label-left" method="post" action="ExamDetail.php" onKeyDown="if (event.keyCode == 13) {return false;}">
                    <div class="form-group">
                        <label class="control-label col-md-10" for="last-name">請輸入要編輯的測驗卷編號 : <span></span></label>
                        <div class="col-md-1">
                          <input type="text"  name="edit_number" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <button type="submit" class="btn btn-dark btn-md">編輯</button>
                    </div>
            </form>

            <form  class="form-horizontal form-label-left" method="post" action="ExamStart.php" onKeyDown="if (event.keyCode == 13) {return false;}">
                    <div class="form-group">
                        <label class="control-label col-md-10" for="last-name">請輸入要考試的測驗卷編號 : <span></span></label>
                        <div class="col-md-1">
                          <input type="text"  name="exam_number" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                        <button type="submit" class="btn btn-danger btn-md">考試</button>
                    </div>
            </form>


          </div>

          <div>
            <button type="button" class="btn btn-success btn-lg"  onclick="self.location.href='MakeExam.php'">新增測驗卷</button>
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
              $sql = "SELECT MAX(No) AS max FROM ExamList";
              $result = mysqli_fetch_object($db->query($sql));
              $max_number = $result->max;
              $title = array();
              $teacher = array();
              $note = array();
              for ( $a = 1 ; $a<=$max_number ; $a++)
              {
                $sql2 = "SELECT `ExamTitle`,`Teacher`,`Note` FROM `ExamList` WHERE `No` =$a";
                $result2 = mysqli_fetch_object($db->query($sql2));
                $title[$a] = $result2->ExamTitle;
                $teacher[$a] = $result2->Teacher;
                $note[$a] = $result2->Note;
                $title_to_json=json_encode((array)$title);
                $teacher_to_json=json_encode((array)$teacher);
                $note_to_json=json_encode((array)$note);
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
                          var titlefromPHP=<? echo $title_to_json ?>;
                          var teacherfromPHP=<? echo $teacher_to_json ?>;
                          var notefromPHP=<? echo $note_to_json ?>;
                          var t = $('#e_list').DataTable();
                          for (var i=1 ; i<= <?php echo "$max_number";?> ; i++)
                          {
                            t.row.add(
                            [
                            i,
                            titlefromPHP[i],
                            teacherfromPHP[i],
                            notefromPHP[i],
                            ]).draw(false);
                          } 
                        }

                );
            </script>


  </body>
</html>