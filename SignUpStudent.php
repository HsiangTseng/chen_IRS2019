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
                    <h2>學生註冊頁 <small>敬請完整填寫各項資料，皆為必填。</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />

                    <form class="form-horizontal form-label-left input_mask" method="post" action="updateSignUpStudent.php" enctype="multipart/form-data" onKeyDown="if (event.keyCode == 13) {return false;}">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">學生帳號 :</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <input type="text" class="form-control" name="account" placeholder="請輸入欲註冊之帳號" required="required">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">學生密碼 :</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <input type="password" id="pwd" class="form-control" name="password" onkeyup="check_same_pwd()" placeholder="請輸入密碼" required="required">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">確認密碼 :</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <input type="password" id="check_pwd" class="form-control" onkeyup="check_same_pwd()" placeholder="請再輸入一次密碼" required="required">
                        </div>
                        <span id = "confirm-msg"></span>
                      </div>

                      <script type="text/javascript">
                          function check_same_pwd()
                          {
                            var password = document.getElementById("pwd");
                            var check_password = document.getElementById("check_pwd");

                            var message = document.getElementById("confirm-msg");

                            var good_color = "#39ac39";
                            var bad_color = "#ff6666";
                            var btn = document.getElementById("btn_submit");
                            if(password.value == check_password.value)
                            {
                                if(password.value.length>0)
                                {
                                    check_password.style.backgroundColor = good_color;
                                    message.style.color = good_color;
                                    message.innerHTML = "密碼驗證成功";
                                    btn.disabled = false;
                                }

                            }
                            else
                            {
                                check_password.style.backgroundColor = bad_color;
                                message.style.color = bad_color;
                                message.innerHTML = "密碼驗證失敗，請確認後重新輸入。";

                                btn.disabled = true;

                            }


                          }
                      </script>

                      <div class="ln_solid"></div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">學生姓名 :</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <input type="text" class="form-control" name="name" placeholder="請輸入學生姓名" required="required">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">就讀學校 :</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <input type="text" class="form-control" name="school" placeholder="請輸入校名" required="required">
                        </div>
                        <div class="col-md-1 col-sm-1 col-xs-2">
                            <label class="control-label">國小</label>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">就讀年級 :</label>
                        <div class="col-md-2 col-sm-2">
                          <select id="grade" name="grade" class="form-control" required>
                            <option value="1">一</option>
                            <option value="2">二</option>
                            <option value="3">三</option>
                            <option value="4">四</option>
                            <option value="5">五</option>
                            <option value="6">六</option>
                          </select>
                        </div>
                        <label class="control-label">年</label>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">就讀班級 :</label>
                        <div class="col-md-2 col-sm-2">
                          <select id="class" name="class" class="form-control" required>
                            <option value="普通班">普通班</option>
                            <option value="資源班">資源班</option>
                            <option value="特教班">特教班</option>
                          </select>
                        </div>
                        <!--label class="control-label">班</label-->
                      </div>

                      <!--div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">座號 :</label>
                        <div class="col-md-2 col-sm-2">
                          <input type="text" class="form-control" name="seatnumber" placeholder="請輸入座號" required="required">
                        </div>
                        <label class="control-label">號</label>
                      </div-->

                      <div class="form-group">
                        <label class="control-label col-md-3" for="first-name">性別 :<span class="required"></span></label>
                        <input type="radio" class="radio-inline flat" name="gender" value="boy"><label>男</label>
                        <input type="radio" class="radio-inline flat" name="gender" value="girl"><label>女</label>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">出生日期 :</label>
                        <div class="col-md-4 col-sm-4">
                          <input type="date" class="form-control" name="bday" id="bday" onchange="submitBday()" required="required">
                        </div>
                      </div>

                      <script type="text/javascript">
                          function submitBday() {

                              var Bdate = document.getElementById('bday').value;
                              var Bday =+new Date(Bdate);
                              var result = document.getElementById('age');
                              var Q4A = ""+ ~~ ((Date.now() - Bday) / (31557600000));
                              //alert(Q4A);
                              result.value=Q4A;

                          }
                      </script>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">實際歲數 :</label>
                        <div class="col-md-4 col-sm-4">
                          <input type="text" value="" id="age" disabled="disabled" class="form-control" required="required">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">測驗日期 :</label>
                        <div class="col-md-4 col-sm-4">
                          <input type="date" class="form-control" name="test_time" value="2000-01-01" required="required">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3" for="first-name">施測方式 :<span class="required"></span></label>
                        <input type="radio" class="radio-inline flat" name="test_type" value="single"><label>個人</label>
                        <input type="radio" class="radio-inline flat" name="test_type" value="multi"><label>團體</label>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">施測人員 :</label>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                          <input type="text" class="form-control" name="test_teacher" required="required">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">障礙類別 :</label>
                        <div class="col-md-4 col-sm-4">
                          <select id="category" name="category" class="form-control" required>
                            <option value="0">無 (一般生)</option>
                            <option value="1">智能障礙</option>
                            <option value="2">視覺障礙</option>
                            <option value="3">聽覺障礙</option>
                            <option value="4">語言障礙</option>
                            <option value="5">腦性麻痺 (Cerbral Palsy)</option>
                            <option value="6">肢體障礙</option>
                            <option value="7">身體病弱</option>
                            <option value="8">情緒行為障礙</option>
                            <option value="9">學習障礙</option>
                            <option value="10">多重障礙</option>
                            <option value="11">自閉症</option>
                            <option value="12">發展遲緩</option>
                          </select>
                        </div>
                      </div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button type="submit" id="btn_submit" class="btn btn-success">註冊</button>
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
