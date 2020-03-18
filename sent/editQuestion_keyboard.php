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
$question_number = $_GET['number'];
//$multi_or_single = $_GET['ms'];
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
                  <h1><b>鍵盤題編輯</b></h1>
                  <div class="clearfix"></div>
                </div>
                <!-- title bar-->

                <form class="form-horizontal form-label-left" method="post" action="updateEdit_keyboard.php" enctype="multipart/form-data" onKeyDown="if (event.keyCode == 13) {return false;}">


                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">請先選擇Keyboard : </label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
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
                      location.href = 'editQuestion_keyboard.php'+'?number=<?php echo $question_number;?>&KeyboardNo='+kbnumber;
                    }
                  </script>





                <div class="form-group">
                    <label class="control-label col-md-3" for="first-name">題目 :<span class="required"></span></label>
                    <div class="col-md-3">
                        <input type="text"  id="Q1" name="Q1" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3" for="last-name">附加音檔 : </label>
                  <div class="col-md-3">
                      <input type="file" name="audio_file"/>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3" for="last-name">附加影片 : </label>
                  <div class="col-md-3">
                      <input type="file" name="video_file" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3" for="last-name">題目附圖 : </label>
                  <div class="col-md-3">
                    <input type="file" id="Q1_file" name="Q1_file"/>
                  </div>
                </div>
                <div class="thumbnail" style="border-style: outset; width:200px; height:200px; margin:0px auto;">
                      <img id="img0" src="" alt="">
                </div>



                <div class="form-group required">
                    <label class="control-label col-md-3" for="first-name">正解 :<span class="required"></span></label>
                    <input type="checkbox" class="radio-inline flat" id="check_1" name="answer[]" value="A1"><label>A選項</label>
                    <input type="checkbox" class="radio-inline flat" id="check_2" name="answer[]" value="A2"><label>B選項</label>
                    <input type="checkbox" class="radio-inline flat" id="check_3" name="answer[]" value="A3"><label>C選項</label>
                    <input type="checkbox" class="radio-inline flat" id="check_4" name="answer[]" value="A4"><label>D選項</label>
                    <br />
                    <input type="checkbox" class="radio-inline flat" id="check_5" name="answer[]" value="A5"><label>E選項</label>
                    <input type="checkbox" class="radio-inline flat" id="check_6" name="answer[]" value="A6"><label>F選項</label>
                    <input type="checkbox" class="radio-inline flat" id="check_7" name="answer[]" value="A7"><label>G選項</label>
                    <input type="checkbox" class="radio-inline flat" id="check_8" name="answer[]" value="A8"><label>H選項</label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3" for="first-name">測驗型別 :<span class="required"></span></label>
                    <input type="radio" class="radio-inline flat" id="class_1" name="classification[]" value="1" required><label>詞彙理解</label>
                    <input type="radio" class="radio-inline flat" id="class_2" name="classification[]" value="2" required><label>詞彙表達</label>
                    <input type="radio" class="radio-inline flat" id="class_3" name="classification[]" value="3" required><label>語法表現</label>
                </div>
                <clearfix>
                <style>
                .responsive {
                  width: 150px;
                  height: 150px;
                  border:5px;
                  border-color:#A0A0A0;
                  border-style: double;
                }
                </style>
                <?php
                if(isset($_GET['KeyboardNo']))
                {
                  if($GetKeyboardNo>0)
                  {
                    $ext_array = array();
                    $ext_array = explode("-",$GetKeyboardExt);

                    echo '<div class="row">';
                    echo '<BR />';
                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A1.'.$ext_array[0].'">';
                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A2.'.$ext_array[1].'">';
                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A3.'.$ext_array[2].'">';
                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A4.'.$ext_array[3].'">';
                    echo '</div>';
                    echo '<div class="row">';
                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A5.'.$ext_array[4].'">';
                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A6.'.$ext_array[5].'">';
                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A7.'.$ext_array[6].'">';
                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A8.'.$ext_array[7].'">';
                    echo '</div>';
                  }

                }
                ?>
                <input type="hidden" name="question_number" <?php echo 'value="'.$question_number.'" >';?>
                <div class="col-md-3 col-sm-3 col-xs-6 ">
                    <button type="submit" class="btn btn-success">送出</button>
                </div>
            </form>
            </div>
            <!-- Question -->
            <script
                  src="https://code.jquery.com/jquery-1.9.0.js"
                  integrity="sha256-TXsBwvYEO87oOjPQ9ifcb7wn3IrrW91dhj6EMEtRLvM="
                  crossorigin="anonymous">
                  </script>
            <script>
            window.onload = function() {
                  document.getElementById("img0").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                };

            $("#Q1_file").change(function(){
                var objUrl = getObjectURL(this.files[0]) ;
                console.log("objUrl = "+objUrl) ;
                if (objUrl) {
                    $("#img0").attr("src", objUrl) ;
                }
                var Img = document.getElementById('img0');
                document.getElementById("img0").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
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


            <?php
            // PHP BLOCK, SETTING ALL DEFAULT VALUE HERE!
            include("connects.php");
            $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'Q'";
            $result = mysqli_fetch_object($db->query($sql));
            $content = $result->Content;
            $CA = $result->CA;
            $classification = $result->classification;

            //echo $content.$classification.$CA;

            //CLASSIFIACATION
            if($classification=="1") echo '<script>document.getElementById("class_1").checked = true;</script>';
            else if($classification=="2") echo '<script>document.getElementById("class_2").checked = true;</script>';
            else if($classification=="3") echo '<script>document.getElementById("class_3").checked = true;</script>';

            //Question
            echo '<script>document.getElementById("Q1").value="'.$content.'";</script>';
            $Q1_ext = $result->picture_ext;
            echo '<script>document.getElementById("img0").src ="upload/Q'.$question_number.'Q1.'.$Q1_ext.'";</script>';

            //CORRECT answer
            if(strpos($CA, 'A1')!==false)echo '<script>document.getElementById("check_1").checked = true;</script>';
            if(strpos($CA, 'A2')!==false)echo '<script>document.getElementById("check_2").checked = true;</script>';
            if(strpos($CA, 'A3')!==false)echo '<script>document.getElementById("check_3").checked = true;</script>';
            if(strpos($CA, 'A4')!==false)echo '<script>document.getElementById("check_4").checked = true;</script>';
            if(strpos($CA, 'A5')!==false)echo '<script>document.getElementById("check_5").checked = true;</script>';
            if(strpos($CA, 'A6')!==false)echo '<script>document.getElementById("check_6").checked = true;</script>';
            if(strpos($CA, 'A7')!==false)echo '<script>document.getElementById("check_7").checked = true;</script>';
            if(strpos($CA, 'A8')!==false)echo '<script>document.getElementById("check_8").checked = true;</script>';
            //echo $CA;
            ?>






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
            <!--script src="../vendors/DataTables_new/datatables.js"></script-->

            <!-- Custom Theme Scripts -->
            <script src="../build/js/custom.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>


  </body>
</html>