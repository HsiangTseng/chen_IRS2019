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
	$student_id = $_GET['index'];

?>
<?php
	include("connects.php");

	$sql = "SELECT * FROM UserList WHERE StudentNumber ='".$student_id."'";

	if($stmt = $db->query($sql)){
		while($result = mysqli_fetch_object($stmt)){
			$Name = $result->Name;
			$School = $result->School;
			$Grade = $result->Grade;
			$Class = $result->Class;
			$Gender = $result->Gender;
			$Birth = $result->Birth;
      $TestTime = $result->TestTime;
			$TestTeacher = $result->TestTeacher;
			$Category = $result->Category;
      $id = $result->id;
      $password = $result->password;
		}
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
            <!-- PAGE TITLE -->
            <div class="page-title">
              <div class="title_left">
                <h3>學生註冊頁</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <!-- PAGE TITLE -->


            <!-- SIGN UP -->
            <div class="row">
              <div class="col-md-10 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>學生檢視</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left input_mask" method="post" action="updateEdit_Student.php" enctype="multipart/form-data" onKeyDown="if (event.keyCode == 13) {return false;}">
                      <div class="ln_solid"></div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">學生姓名 : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" value="<?php echo $Name;?>" required="required" />
                        </div>
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">就讀學校 : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="school" value="<?php echo $School;?>" required="required" />
                        </div>
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">就讀年級 : <span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-2">
                          <select id="grade" name="grade" class="form-control" required>
                            <?php
                            for($i=1;$i<=6;$i++)
                            {
                              if($i==1)
                              {
                                echo '<option value="1"';
                                if($Grade==$i) {echo 'selected="selected"';}
                                echo '>一</option>';
                              }
                              if($i==2)
                              {
                                echo '<option value="2"';
                                if($Grade==$i) {echo 'selected="selected"';}
                                echo '>二</option>';
                              }
                              if($i==3)
                              {
                                echo '<option value="3"';
                                if($Grade==$i) {echo 'selected="selected"';}
                                echo '>三</option>';
                              }
                              if($i==4)
                              {
                                echo '<option value="4"';
                                if($Grade==$i) {echo 'selected="selected"';}
                                echo '>四</option>';
                              }
                              if($i==5)
                              {
                                echo '<option value="5"';
                                if($Grade==$i) {echo 'selected="selected"';}
                                echo '>五</option>';
                              }
                              if($i==6)
                              {
                                echo '<option value="6"';
                                if($Grade==$i) {echo 'selected="selected"';}
                                echo '>六</option>';
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <label class="control-label">年</label>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">就讀班級 : <span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-2">
                          <select id="class" name="class" class="form-control" required>
                            <?php
                            for($i=1;$i<=3;$i++)
                            {
                              if($i==1)
                              {
                                echo '<option value="普通班"';
                                if($Class=="普通班"){echo 'selected="selected"';}
                                echo '>普通班</option>';
                              }
                              if($i==2)
                              {
                                echo '<option value="資源班"';
                                if($Class=="資源班"){echo 'selected="selected"';}
                                echo '>資源班</option>';
                              }
                              if($i==3)
                              {
                                echo '<option value="特教班"';
                                if($Class=="特教班"){echo 'selected="selected"';}
                                echo '>特教班</option>';
                              }

                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">性別 : <span class="required">*</span>
                        </label>
                        <input type="radio" class="radio-inline flat" name="gender" value="boy" <?php if($Gender=="boy")echo 'checked';?>><label>男</label>
                        <input type="radio" class="radio-inline flat" name="gender" value="girl" <?php if($Gender=="girl")echo 'checked';?>><label>女</label>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">出生日期 : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="date" name="bday" value="<?php echo $Birth;?>" required="required"/>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">測驗日期 : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="date" name="test_time" value="<?php echo $TestTime;?>" required="required">
                        </div>
                      </div>


                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">施測人員 : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="test_teacher" value="<?php echo $TestTeacher;?>" required="required"/>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">障礙類別 : <span class="required">*</span>
                        </label>
                        <div class="col-md-4 col-sm-4">
                          <select id="category" name="category" class="form-control" required>
                            <?php
                            for($i=0;$i<=12;$i++)
                            {
                              if($i==0)
                              {
                                echo '<option value="0" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>無 (一般生)</option>';
                              }
                              if($i==1)
                              {
                                echo '<option value="1" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>智能障礙</option>';
                              }
                              if($i==2)
                              {
                                echo '<option value="2" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>視覺障礙</option>';
                              }
                              if($i==3)
                              {
                                echo '<option value="3" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>聽覺障礙</option>';
                              }
                              if($i==4)
                              {
                                echo '<option value="4" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>語言障礙</option>';
                              }
                              if($i==5)
                              {
                                echo '<option value="5" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>腦性麻痺 (Cerbral Palsy)</option>';
                              }
                              if($i==6)
                              {
                                echo '<option value="6" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>肢體障礙</option>';
                              }
                              if($i==7)
                              {
                                echo '<option value="7" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>身體病弱</option>';
                              }
                              if($i==8)
                              {
                                echo '<option value="8" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>情緒行為障礙</option>';
                              }
                              if($i==9)
                              {
                                echo '<option value="9" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>學習障礙</option>';
                              }
                              if($i==10)
                              {
                                echo '<option value="10" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>多重障礙</option>';
                              }
                              if($i==11)
                              {
                                echo '<option value="11" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>自閉症</option>';
                              }
                              if($i==12)
                              {
                                echo '<option value="12" ';
                                if($Category==$i) {echo'selected="selected"';}
                                echo '>發展遲緩</option>';
                              }
                            }
                            ?>

                          </select>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">學生帳號 : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="account" value="<?php echo $id;?>" required="required"/>
                        </div>
                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">學生密碼 : <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="password" value="<?php echo $password;?>" required="required"/>
                        </div>
                      </div>

                      <input type="hidden" name="student_id" value="<?php echo $student_id;?>">


                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" id="btn_submit" class="btn btn-success">編輯</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
                <!-- SIGN UP -->








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
  </body>
</html>
