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
    $GetKeyboardStyle = $result->Style;
    //echo $GetKeyboardStyle;
  }

}
else {
  $GetKeyboardNo = 0;
}
$question_number = $_GET['number'];

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
                      <img id="imgQ" src="" alt="">
                </div>



                <div class="form-group required">
                    <div class="form-group required">
                        <label class="control-label col-md-3">正解 :<span class="required"></span></label>
                        <br />
                        <br />
                        <div style="text-align:center;">
                          <?php
                          if(isset($_GET['KeyboardNo']))
                          {
                            if($GetKeyboardNo>0)
                            {
                                if($GetKeyboardStyle=="A")//4*2
                                {
                                  for($i = 1 ; $i <= 8 ; $i++)
                                  {
                                    echo '<input type="checkbox" id="check_'.$i.'" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp;</label>';
                                    if($i%4==0){  echo '<br />';}
                                  }
                                }

                                else if($GetKeyboardStyle=="B")//8*5
                                {
                                  for($i = 1 ; $i <= 40 ; $i++)
                                  {
                                    echo '<input type="checkbox" id="check_'.$i.'" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp&nbsp&nbsp</label>';
                                    if($i%8==0){  echo '<br />';}
                                  }
                                }

                                else if($GetKeyboardStyle=="C")//4*4
                                {
                                  for($i = 1 ; $i <= 16 ; $i++)
                                  {
                                    echo '<input type="checkbox" id="check_'.$i.'" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp&nbsp&nbsp</label>';
                                    if($i%4==0){  echo '<br />';}
                                  }
                                }

                                else if($GetKeyboardStyle=="D")//6*4
                                {
                                  for($i = 1 ; $i <= 24 ; $i++)
                                  {
                                    echo '<input type="checkbox" id="check_'.$i.'" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp&nbsp&nbsp</label>';
                                    if($i%6==0){  echo '<br />';}
                                  }
                                }

                                else if($GetKeyboardStyle=="E")//4*3
                                {
                                  for($i = 1 ; $i <= 12 ; $i++)
                                  {
                                    echo '<input type="checkbox" id="check_'.$i.'" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp&nbsp&nbsp</label>';
                                    if($i%4==0){  echo '<br />';}
                                  }
                                }
                            }
                          }

                          ?>
                        </div>
                    </div>
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
                    echo '<div class="col-md-6" id="KeyboardPreview" style="margin-left:25%;">';
                      $half_index = 1;
                      for($i = 0 ; $i < 40 ; $i++)
                      {
                        if($i%4==0)
                        {
                          echo '<div id="half_id_'.$half_index.'" class="col-md-6">';
                          $half_index++;
                        }
                        echo '<div class="col-md-3" id ="div_'.$i.'" style="display:none; text-align:center;">';
                          echo '<div class="thumbnail" style="border-style: outset; height:80px;">';
                            echo '<img id="img'.$i.'" src="" alt="" style="height:100%">';
                          echo '</div>';
                        echo '</div>';
                        if($i%4==3)echo '</div>';
                      }
                    echo '</div>';

                    if($GetKeyboardStyle=="A")//4*2
                    {
                      for($i = 0 ; $i < 40 ; $i++)
                      {
                        echo '<script>document.getElementById("div_'.$i.'").style.display="none";</script>';
                      }
                      for($i = 0 ; $i < 8 ;$i++)
                      {
                        $img_index = $i+1;
                        echo '<script>document.getElementById("div_'.$i.'").style.display="block";</script>';
                        echo '<script>document.getElementById("div_'.$i.'").className="col-md-3";</script>';
                        echo '<script>document.getElementById("img'.$i.'").src="upload/K'.$GetKeyboardNo.'A'.$img_index.'.'.$ext_array[$i].'";</script>';
                      }
                      for($i = 1 ; $i <= 10 ; $i++)
                      {
                        echo '<script>document.getElementById("half_id_'.$i.'").className="";</script>';
                      }
                    }

                    else if($GetKeyboardStyle=="B")//8*5
                    {
                      for($i = 0 ; $i < 40 ; $i++)
                      {
                        echo '<script>document.getElementById("div_'.$i.'").style.display="none";</script>';
                      }
                      for($i = 0 ; $i < 40 ;$i++)
                      {
                        $img_index = $i+1;
                        echo '<script>document.getElementById("div_'.$i.'").style.display="block";</script>';
                        echo '<script>document.getElementById("div_'.$i.'").className="col-md-3";</script>';
                        echo '<script>document.getElementById("img'.$i.'").src="upload/K'.$GetKeyboardNo.'A'.$img_index.'.'.$ext_array[$i].'";</script>';
                      }
                      for($i = 1 ; $i <= 10 ; $i++)
                      {
                        echo '<script>document.getElementById("half_id_'.$i.'").className="col-md-6";</script>';
                      }
                    }

                    else if($GetKeyboardStyle=="C")//4*4
                    {
                      for($i = 0 ; $i < 40 ; $i++)
                      {
                        echo '<script>document.getElementById("div_'.$i.'").style.display="none";</script>';
                      }
                      for($i = 0 ; $i < 16 ;$i++)
                      {
                        $img_index = $i+1;
                        echo '<script>document.getElementById("div_'.$i.'").style.display="block";</script>';
                        echo '<script>document.getElementById("div_'.$i.'").className="col-md-3";</script>';
                        echo '<script>document.getElementById("img'.$i.'").src="upload/K'.$GetKeyboardNo.'A'.$img_index.'.'.$ext_array[$i].'";</script>';
                      }
                      for($i = 1 ; $i <= 10 ; $i++)
                      {
                        echo '<script>document.getElementById("half_id_'.$i.'").className="";</script>';
                      }
                    }

                    else if($GetKeyboardStyle=="D")//6*4
                    {
                      for($i = 0 ; $i < 40 ; $i++)
                      {
                        echo '<script>document.getElementById("div_'.$i.'").style.display="none";</script>';
                      }
                      for($i = 0 ; $i < 24 ;$i++)
                      {
                        $img_index = $i+1;
                        echo '<script>document.getElementById("div_'.$i.'").style.display="block";</script>';
                        echo '<script>document.getElementById("div_'.$i.'").className="col-md-2";</script>';
                        echo '<script>document.getElementById("img'.$i.'").src="upload/K'.$GetKeyboardNo.'A'.$img_index.'.'.$ext_array[$i].'";</script>';
                      }
                      for($i = 1 ; $i <= 10 ; $i++)
                      {
                        echo '<script>document.getElementById("half_id_'.$i.'").className="";</script>';
                      }
                    }

                    else if($GetKeyboardStyle=="E")//4*3
                    {
                      for($i = 0 ; $i < 40 ; $i++)
                      {
                        echo '<script>document.getElementById("div_'.$i.'").style.display="none";</script>';
                      }
                      for($i = 0 ; $i < 12 ;$i++)
                      {
                        $img_index = $i+1;
                        echo '<script>document.getElementById("div_'.$i.'").style.display="block";</script>';
                        echo '<script>document.getElementById("div_'.$i.'").className="col-md-3";</script>';
                        echo '<script>document.getElementById("img'.$i.'").src="upload/K'.$GetKeyboardNo.'A'.$img_index.'.'.$ext_array[$i].'";</script>';
                      }
                      for($i = 1 ; $i <= 10 ; $i++)
                      {
                        echo '<script>document.getElementById("half_id_'.$i.'").className="";</script>';
                      }
                    }

                  }

                }
                ?>
                <input type="hidden" name="question_number" <?php echo 'value="'.$question_number.'" >';?>
                <div class="col-md-12 col-sm-3 col-xs-12 ">
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
                  document.getElementById("imgQ").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                };

            $("#Q1_file").change(function(){
                var objUrl = getObjectURL(this.files[0]) ;
                console.log("objUrl = "+objUrl) ;
                if (objUrl) {
                    $("#imgQ").attr("src", objUrl) ;
                }
                var Img = document.getElementById('imgQ');
                document.getElementById("imgQ").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
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
            echo '<script>document.getElementById("imgQ").src ="upload/Q'.$question_number.'Q1.'.$Q1_ext.'";</script>';

            //CORRECT answer
            $CA_ARRAY = explode(",",$CA);
            foreach ($CA_ARRAY as $key => $value) {
              $ca_number = substr($CA_ARRAY[$key],1);
              //echo $ca_number;
              $check_id = 'check_'.$ca_number;
              //echo $check_id;
              echo '<script>document.getElementById("'.$check_id.'").checked = true;</script>';
            }


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
