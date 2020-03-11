<!DOCTYPE html>

<?php
include("connects.php");
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
//GET THE KeyboardNo From GET[]
if(isset($_GET['KeyboardNo']))
{
  $GetKeyboardNo = $_GET['KeyboardNo'];
  if($GetKeyboardNo>0)
  {
    $sql = "SELECT * FROM `Keyboard` WHERE KeyboardNo='$GetKeyboardNo'";
    $result = mysqli_fetch_object($db->query($sql));
    $GetKeyboardExt = $result->ext;
  }

}
else {
  $GetKeyboardNo = 0;
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


            <!-- Question -->
            <div class="x_panel">
                <!-- title bar-->
                <div class="x_title">
                  <h1><b>KEYBOARD題型</b></h1>
                  <div class="clearfix"></div>
                </div>
                <!-- title bar-->





                    <!-- setQuestion TAB -->
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="setQuestion">
                            <form class="form-horizontal form-label-left" method="post" action="updateEditAllKeyboard.php" enctype="multipart/form-data" onKeyDown="if (event.keyCode == 13) {return false;}">


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">請先選擇Keyboard : </label>
                                <div class="col-md-6 col-sm-6 col-xs-9">
                                  <select class="select2_single form-control" name="KeyboardNo" id="KeyboardNo" onchange="KeyboardOnchange()" tabindex="-1" required>
                                        <?php
                                            $sql = "SELECT COUNT(KeyboardNo) AS KeyboardNumber FROM `Keyboard` WHERE type='Keyboard'";
                                            $result = mysqli_fetch_object($db->query($sql));
                                            $KeyboardNum = $result->KeyboardNumber;

                                            //echo $KeyboardNum;
                                            $sql2 = "SELECT * FROM `Keyboard` WHERE type='Keyboard'";
                                            $_KeyboardNo = array();
                                            $_KeyboardName = array();
                                            $index = 0;

                                            if($stmt = $db->query($sql2))
                                            {
                                                while ($result = mysqli_fetch_object($stmt))
                                                {
                                                    $_KeyboardNo[$index] = $result->KeyboardNo;
                                                    $_KeyboardName[$index] = $result->KeyboardName;
                                                    $index++;
                                                }
                                            }
                                            echo '<option value="-10">請先選擇Keyboard</option>';
                                            for($i=0 ; $i<$KeyboardNum ; $i++)
                                            {
                                                echo "<option value=";
                                                echo "\"";
                                                echo $_KeyboardNo[$i];
                                                echo "\"";
                                                if($_KeyboardNo[$i]==$GetKeyboardNo) echo " selected ";
                                                echo ">";
                                                echo $_KeyboardName[$i];
                                                echo "</option>";
                                            }
                                            $db->close();
                                        ?>
                                </select>

                                </div>
                            </div>
                              <script>
                                function KeyboardOnchange()
                                {
                                  var kbnumber = document.getElementById("KeyboardNo").value;
                                  location.href = 'editKeyboard.php'+'?KeyboardNo='+kbnumber;
                                }
                              </script>

                              <div class="form-group">
                                  <label class="control-label col-md-3" for="first-name">Keyboard名稱 :<span class="required"></span></label>
                                  <div class="col-md-3">
                                      <input type="text" id="KeyboardName" name="KeyboardName" required="required" class="form-control col-md-7 col-xs-12">
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-3">
                                      <input type="file" name="file0" id="file0"/>
                                      <div class="thumbnail" style="border-style: outset;">
                                        <img id="img0" src="" alt="">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <input type="file" name="file1" id="file1"/>
                                      <div class="thumbnail" style="border-style: outset;">
                                        <img id="img1" src="" alt="">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <input type="file" name="file2" id="file2"/>
                                      <div class="thumbnail" style="border-style: outset;">
                                        <img id="img2" src="" alt="">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <input type="file" name="file3" id="file3"/>
                                      <div class="thumbnail" style="border-style: outset;">
                                        <img id="img3" src="" alt="">
                                      </div>
                                  </div>
                              </div>

                              <HR>
                              <HR>

                              <div class="row">
                                  <div class="col-md-3">
                                      <input type="file" name="file4" id="file4"/>
                                      <div class="thumbnail" style="border-style: outset;">
                                        <img id="img4" src="" alt="">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <input type="file" name="file5" id="file5"/>
                                      <div class="thumbnail" style="border-style: outset;">
                                        <img id="img5" src="" alt="">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <input type="file" name="file6" id="file6"/>
                                      <div class="thumbnail" style="border-style: outset;">
                                        <img id="img6" src="" alt="">
                                      </div>
                                  </div>
                                  <div class="col-md-3">
                                      <input type="file" name="file7" id="file7"/>
                                      <div class="thumbnail" style="border-style: outset;">
                                        <img id="img7" src="" alt="">
                                      </div>
                                  </div>
                              </div>


                              <script
                                src="https://code.jquery.com/jquery-1.9.0.js"
                                integrity="sha256-TXsBwvYEO87oOjPQ9ifcb7wn3IrrW91dhj6EMEtRLvM="
                                crossorigin="anonymous">
                              </script>
                              <script>

                              $("#file0").change(function(){
                                  var objUrl = getObjectURL(this.files[0]) ;
                                  console.log("objUrl = "+objUrl) ;
                                  if (objUrl) {
                                      $("#img0").attr("src", objUrl) ;
                                  }
                                  var Img = document.getElementById('img0');
                                  document.getElementById("img0").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                              }) ;
                              $("#file1").change(function(){
                                  var objUrl = getObjectURL(this.files[0]) ;
                                  console.log("objUrl = "+objUrl) ;
                                  if (objUrl) {
                                      $("#img1").attr("src", objUrl) ;
                                  }
                                  var Img = document.getElementById('img1');
                                  document.getElementById("img1").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                              }) ;
                              $("#file2").change(function(){
                                  var objUrl = getObjectURL(this.files[0]) ;
                                  console.log("objUrl = "+objUrl) ;
                                  if (objUrl) {
                                      $("#img2").attr("src", objUrl) ;
                                  }
                                  var Img = document.getElementById('img2');
                                  document.getElementById("img2").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                              }) ;
                              $("#file3").change(function(){
                                  var objUrl = getObjectURL(this.files[0]) ;
                                  console.log("objUrl = "+objUrl) ;
                                  if (objUrl) {
                                      $("#img3").attr("src", objUrl) ;
                                  }
                                  var Img = document.getElementById('img3');
                                  document.getElementById("img3").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                              }) ;
                              $("#file4").change(function(){
                                  var objUrl = getObjectURL(this.files[0]) ;
                                  console.log("objUrl = "+objUrl) ;
                                  if (objUrl) {
                                      $("#img4").attr("src", objUrl) ;
                                  }
                                  var Img = document.getElementById('img4');
                                  document.getElementById("img4").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                              }) ;
                              $("#file5").change(function(){
                                  var objUrl = getObjectURL(this.files[0]) ;
                                  console.log("objUrl = "+objUrl) ;
                                  if (objUrl) {
                                      $("#img5").attr("src", objUrl) ;
                                  }
                                  var Img = document.getElementById('img5');
                                  document.getElementById("img5").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                              }) ;
                              $("#file6").change(function(){
                                  var objUrl = getObjectURL(this.files[0]) ;
                                  console.log("objUrl = "+objUrl) ;
                                  if (objUrl) {
                                      $("#img6").attr("src", objUrl) ;
                                  }
                                  var Img = document.getElementById('img6');
                                  document.getElementById("img6").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                              }) ;
                              $("#file7").change(function(){
                                  var objUrl = getObjectURL(this.files[0]) ;
                                  console.log("objUrl = "+objUrl) ;
                                  if (objUrl) {
                                      $("#img7").attr("src", objUrl) ;
                                  }
                                  var Img = document.getElementById('img7');
                                  document.getElementById("img7").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                              }) ;


                              function getObjectURL(file) {
                                  var url = null ;
                                  if (window.createObjectURL!=undefined) { // basic
                                      url = window.createObjectURL(file) ;
                                  } else if (window.URL!=undefined) { // mozilla(firefox)
                                      url = window.URL.createObjectURL(file) ;
                                  } else if (window.webkitURL!=undefined) { // webkit or chrome
                                      url = window.webkitURL.createObjectURL(file) ;
                                  }
                                  return url ;
                                  console.log( url )
                              }
                              </script>

                            <input type="hidden" name="KeyboardNo" <?php echo 'value="'.$GetKeyboardNo.'" >';?>
                            <div class="col-md-3 col-sm-3 col-xs-6 ">
                                <button type="submit" class="btn btn-success">送出</button>
                            </div>
                        </form>
                    </div>
                    <!-- setQuestion TAB -->


                    <?php
                    //SETTING THE DEFALUT Data
                    include("connects.php");


                    //KeyboardName
                    if(isset($_GET['KeyboardNo']))
                    {
                      $KeyboardNo = $_GET['KeyboardNo'];
                      $sql = "SELECT * FROM Keyboard WHERE KeyboardNo = '$KeyboardNo' ";
                      $result = mysqli_fetch_object($db->query($sql));
                      $KeyboardName = $result->KeyboardName;
                      $ext= $result->ext;

                      echo '<script>document.getElementById("KeyboardName").value="'.$KeyboardName.'";</script>';

                      //VIEW OLD IMG
                      $old_ext = explode("-",$ext);
                      foreach ($old_ext as $key => $value)
                      {
                        $img_index = $key+1;
                        echo '<script>document.getElementById("img'.$key.'").src="upload/K'.$KeyboardNo.'A'.$img_index.'.'.$old_ext[$key].'";</script>';
                      }
                    }

                    ?>



                <!-- MakeOut Form -->

            </div>
            <!-- Question -->







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
