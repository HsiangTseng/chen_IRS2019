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

                <!-- MakeOut Form -->
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="setQuestion" role="tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-pencil-alt" aria-hidden="true"></i>Keyboard題目</a></li>
                        <li role="presentation" class=""><a href="#tab_content2" id="setKeyboard" role="tab" data-toggle="tab" aria-expanded="false"><i class="fas fa-paint-brush" aria-hidden="true"></i>設計Keyboard</a></li>
                      </ul>
                </div>



                <!-- WORD TAB-->
                <div id="myTabContent" class="tab-content">

                    <!-- setQuestion TAB -->
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="setQuestion">
                            <form class="form-horizontal form-label-left" method="post" action="updateQuestion_keyboard.php" enctype="multipart/form-data" onKeyDown="if (event.keyCode == 13) {return false;}">


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
                                  location.href = 'KeyboardSite.php'+'?KeyboardNo='+kbnumber;
                                }
                              </script>





                            <div class="form-group">
                                <label class="control-label col-md-3" for="first-name">題目 :<span class="required"></span></label>
                                <div class="col-md-3">
                                    <input type="text"  name="Q1" required="required" class="form-control col-md-7 col-xs-12">
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
                                <input type="file" name="Q1_file"/>
                              </div>
                            </div>

                            <?php
                            //BEFORE CREATE HTML, MUST GET THE KEYBOARD DATA.
                            include("connects.php");
                            if(isset($_GET['KeyboardNo']))
                            {
                              if($GetKeyboardNo>0)
                              {
                                $sql = "SELECT * FROM `Keyboard` WHERE type='Keyboard' AND KeyboardNo='$GetKeyboardNo'";
                                $result = mysqli_fetch_object($db->query($sql));
                                $KeyboardNo = $result->KeyboardNo;
                                $KeyboardStyle = $result->Style;
                              }

                            }

                            ?>


                            <div class="form-group">
                                <label class="control-label col-md-3" for="first-name">測驗型別 :<span class="required"></span></label>
                                <input type="radio" class="radio-inline flat" name="classification[]" value="1" required><label>詞彙理解</label>
                                <input type="radio" class="radio-inline flat" name="classification[]" value="2" required><label>詞彙表達</label>
                                <input type="radio" class="radio-inline flat" name="classification[]" value="3" required><label>語法表現</label>
                            </div>
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
                                        if($KeyboardStyle=="A")//4*2
                                        {
                                          for($i = 1 ; $i <= 8 ; $i++)
                                          {
                                            echo '<input type="checkbox" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp;</label>';
                                            if($i%4==0){  echo '<br />';}
                                          }
                                        }

                                        else if($KeyboardStyle=="B")//8*5
                                        {
                                          for($i = 1 ; $i <= 40 ; $i++)
                                          {
                                            echo '<input type="checkbox" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp&nbsp&nbsp</label>';
                                            if($i%8==0){  echo '<br />';}
                                          }
                                        }

                                        else if($KeyboardStyle=="C")//4*4
                                        {
                                          for($i = 1 ; $i <= 16 ; $i++)
                                          {
                                            echo '<input type="checkbox" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp&nbsp&nbsp</label>';
                                            if($i%4==0){  echo '<br />';}
                                          }
                                        }

                                        else if($KeyboardStyle=="D")//6*4
                                        {
                                          for($i = 1 ; $i <= 24 ; $i++)
                                          {
                                            echo '<input type="checkbox" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp&nbsp&nbsp</label>';
                                            if($i%6==0){  echo '<br />';}
                                          }
                                        }

                                        else if($KeyboardStyle=="E")//4*3
                                        {
                                          for($i = 1 ; $i <= 12 ; $i++)
                                          {
                                            echo '<input type="checkbox" class="radio-inline flat" name="answer[]" value="A'.$i.'"><label>選&nbsp項&nbsp&nbsp&nbsp</label>';
                                            if($i%4==0){  echo '<br />';}
                                          }
                                        }
                                    }
                                  }

                                  ?>
                                </div>
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

                                echo '<div class="row" style="text-align:center; ">';
                                if($KeyboardStyle=="A")//4*2
                                {
                                  for($i = 1 ; $i <= 8 ; $i++)
                                  {
                                    $ext_index = $i-1;
                                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A'.$i.'.'.$ext_array[$ext_index].'">';
                                    if($i%4==0)echo'<br />';
                                  }
                                }

                                if($KeyboardStyle=="B")//8*5
                                {
                                  for($i = 1 ; $i <= 40 ; $i++)
                                  {
                                    $ext_index = $i-1;
                                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A'.$i.'.'.$ext_array[$ext_index].'">';
                                    if($i%8==0)echo'<br />';
                                  }
                                }
                                if($KeyboardStyle=="C")//4*4
                                {
                                  for($i = 1 ; $i <= 16 ; $i++)
                                  {
                                    $ext_index = $i-1;
                                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A'.$i.'.'.$ext_array[$ext_index].'">';
                                    if($i%4==0)echo'<br />';
                                  }
                                }
                                if($KeyboardStyle=="D")//6*4
                                {
                                  for($i = 1 ; $i <= 24 ; $i++)
                                  {
                                    $ext_index = $i-1;
                                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A'.$i.'.'.$ext_array[$ext_index].'">';
                                    if($i%6==0)echo'<br />';
                                  }
                                }
                                if($KeyboardStyle=="E")//4*3
                                {
                                  for($i = 1 ; $i <= 12 ; $i++)
                                  {
                                    $ext_index = $i-1;
                                    echo '<img id="" class="responsive" src="upload/K'.$GetKeyboardNo.'A'.$i.'.'.$ext_array[$ext_index].'">';
                                    if($i%4==0)echo'<br />';
                                  }
                                }
                                echo '</div>';
                              }

                            }
                            ?>

                            <div class="col-md-3 col-sm-3 col-xs-6 ">
                                <button type="submit" class="btn btn-success">送出</button>
                            </div>
                        </form>
                    </div>
                    <!-- setQuestion TAB -->

                    <!-- setKeyboard TAB -->
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="setKeyboard">
                            <form class="form-horizontal form-label-left" method="post" action="updateKeyboard.php" enctype="multipart/form-data" onKeyDown="if (event.keyCode == 13) {return false;}">

                            <div class="form-group">
                                <label class="control-label col-md-3" for="first-name"> 鍵盤型態 :<span class="required"></span></label>
                                <button class="btn btn-success" onclick="setKeyboardType('A');return false;">4*2</button>
                                <button class="btn btn-success" onclick="setKeyboardType('B');return false;">8*5</button>
                                <button class="btn btn-success" onclick="setKeyboardType('C');return false;">4*4</button>
                                <button class="btn btn-success" onclick="setKeyboardType('D');return false;">6*4</button>
                                <button class="btn btn-success" onclick="setKeyboardType('E');return false;">4*3</button>
                            </div>

                            <script
                              src="https://code.jquery.com/jquery-1.9.0.js"
                              integrity="sha256-TXsBwvYEO87oOjPQ9ifcb7wn3IrrW91dhj6EMEtRLvM="
                              crossorigin="anonymous">
                            </script>

                            <script>
                            function setKeyboardType(type)
                            {
                              <?php
                              //CLEAR EVERYTHING
                              for($index=0;$index<40;$index++)
                              {
                                echo 'document.getElementById("div_'.$index.'").style.display="none";';
                                echo 'document.getElementById("file'.$index.'").value= "";';
                                echo 'document.getElementById("file'.$index.'").required= false;';
                                echo 'document.getElementById("img'.$index.'").src= "";';
                                echo 'document.getElementById("div_'.$index.'").className= "";';
                              }
                              for($index=1;$index<=10;$index++)
                              {
                                echo 'document.getElementById("half_id_'.$index.'").className= "";';
                              }
                              ?>
                              if(type=="A")
                              {
                                //4*2
                                <?php
                                for($index=0;$index<8;$index++)
                                {
                                  //DISPLAY THE BLOCK
                                  echo 'document.getElementById("div_'.$index.'").style.display="block";';
                                  //SETTING THE RWD
                                  echo 'document.getElementById("div_'.$index.'").className="col-md-3";';
                                  //SETTING THE FILE required
                                  echo 'document.getElementById("file'.$index.'").required= true;';
                                }
                                //SETTING PICTURE_NUMBER AND KEYBOARD STYLE
                                echo 'document.getElementById("picture_number").value="8";';
                                echo 'document.getElementById("Keyboard_Style").value="A";';
                                ?>
                              }
                              else if (type=="B")
                              {
                                //8*5
                                <?php
                                for($index=0;$index<40;$index++)
                                {
                                  //DISPLAY THE BLOCK
                                  echo 'document.getElementById("div_'.$index.'").style.display="block";';

                                  //SETTING THE RWD
                                  echo 'document.getElementById("div_'.$index.'").className="col-md-3";';

                                  //SETTING THE FILE required
                                  echo 'document.getElementById("file'.$index.'").required= true;';
                                }
                                for($index=1;$index<=10;$index++)
                                {
                                  //THE HALF BLOCK (12->6+6)
                                  echo 'document.getElementById("half_id_'.$index.'").className= "col-md-6";';
                                }
                                //SETTING PICTURE_NUMBER AND KEYBOARD STYLE
                                echo 'document.getElementById("picture_number").value="40";';
                                echo 'document.getElementById("Keyboard_Style").value="B";';
                                ?>
                              }

                              else if (type=="C")
                              {
                                //4*4
                                <?php
                                for($index=0;$index<16;$index++)
                                {
                                  //DISPLAY THE BLOCK
                                  echo 'document.getElementById("div_'.$index.'").style.display="block";';

                                  //SETTING THE RWD
                                  echo 'document.getElementById("div_'.$index.'").className="col-md-3";';

                                  //SETTING THE FILE required
                                  echo 'document.getElementById("file'.$index.'").required= true;';
                                }

                                //SETTING PICTURE_NUMBER AND KEYBOARD STYLE
                                echo 'document.getElementById("picture_number").value="16";';
                                echo 'document.getElementById("Keyboard_Style").value="C";';
                                ?>
                              }

                              else if (type=="D")
                              {
                                //6*4
                                <?php
                                for($index=0;$index<24;$index++)
                                {
                                  //DISPLAY THE BLOCK
                                  echo 'document.getElementById("div_'.$index.'").style.display="block";';

                                  //SETTING THE RWD
                                  echo 'document.getElementById("div_'.$index.'").className="col-md-2";';

                                  //SETTING THE FILE required
                                  echo 'document.getElementById("file'.$index.'").required= true;';
                                }

                                //SETTING PICTURE_NUMBER AND KEYBOARD STYLE
                                echo 'document.getElementById("picture_number").value="24";';
                                echo 'document.getElementById("Keyboard_Style").value="D";';
                                ?>
                              }

                              else if (type=="E")
                              {
                                //6*4
                                <?php
                                for($index=0;$index<12;$index++)
                                {
                                  //DISPLAY THE BLOCK
                                  echo 'document.getElementById("div_'.$index.'").style.display="block";';

                                  //SETTING THE RWD
                                  echo 'document.getElementById("div_'.$index.'").className="col-md-3";';

                                  //SETTING THE FILE required
                                  echo 'document.getElementById("file'.$index.'").required= true;';
                                }

                                //SETTING PICTURE_NUMBER AND KEYBOARD STYLE
                                echo 'document.getElementById("picture_number").value="12";';
                                echo 'document.getElementById("Keyboard_Style").value="E";';
                                ?>
                              }
                            }


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
                            $half_index = 1;
                            for($i = 0 ; $i < 40 ; $i++)
                            {
                              if($i%4==0)
                              {
                                echo '<div id="half_id_'.$half_index.'" class="col-md-6">';
                                $half_index++;
                              }
                              echo '<div class="col-md-3" id ="div_'.$i.'" style="display:none;">';
                                echo '<label style="display:inline;">圖檔↓↓↓</label>';
                                echo '<input type="file" name="file'.$i.'" id="file'.$i.'"/>';
                                echo '<label style="display:inline;">音檔↓↓↓</label>';
                                echo '<input type="file" name="audio'.$i.'" id="audio'.$i.'"/>';
                                echo '<div class="thumbnail" style="border-style: outset;">';
                                  echo '<img id="img'.$i.'" src="" alt="">';
                                echo '</div>';
                              echo '</div>';
                              if($i%4==3)echo '</div>';
                            }

                            for($k = 0 ; $k < 40 ;$k++)
                            {
                              echo '
                              <script>
                              $("#file'.$k.'").change(function(){
                                  var objUrl = getObjectURL(this.files[0]) ;
                                  console.log("objUrl = "+objUrl) ;
                                  if (objUrl) {
                                      $("#img'.$k.'").attr("src", objUrl) ;
                                  }
                                  var Img = document.getElementById("img'.$k.'");
                                  document.getElementById("img'.$k.'").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                              }) ;
                              </script>
                              ';
                            }

                            ?>
                            <input type="hidden" name="Keyboard_Style"  id="Keyboard_Style">
                            <input type="hidden" name="picture_number"  id="picture_number">
                            <clearfix>

                            <label class="control-label col-md-3" for="first-name">Keyboard名稱 :<span class="required"></span></label>
                                <div class="col-md-3">
                                    <input type="text"  name="KeyboardName" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            <div class="col-md-3 col-sm-3 col-xs-6 ">
                                <button type="submit" class="btn btn-success">送出</button>
                            </div>
                        </form>
                    </div>
                    <!-- setKeyboard TAB -->



                </div>
                <!-- WORD TAB-->


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
