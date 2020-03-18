<!DOCTYPE html>

<?php

    session_start();

    if($_SESSION['username'] == null)
    {
            header ('location: IRS_Login.php');
            exit;
    }


    $question_number = $_GET['number'];
    $multi_or_single = $_GET['ms'];

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
                  <h1><b>圖片選擇題編輯</b></h1>
                  <div class="clearfix"></div>
                </div>
                <!-- title bar-->

                <form class="form-horizontal form-label-left" method="post" action="updateEdit_picture.php" enctype="multipart/form-data" onKeyDown="if (event.keyCode == 13) {return false;}">
                    <div class="form-group">
                        <label class="control-label col-md-3" for="first-name">題目流水號 : </label>
                        <label class="control-label">
                          <?php
                              echo $question_number;
                          ?>
                        </label>
                    </div>

                    <div  class="form-group">
                        <label class="control-label col-md-3" for="first-name">答題型別 :<span class="required"></span></label>
                        <div style="display: none;">
                            <input type="radio" id="single_pic_radio" class="radio-inline flat" name="single_or_multi" value="SINGLE" required>
                            <input type="radio" id="multi_pic_radio" class="radio-inline flat" name="single_or_multi" value="MULTI">
                        </div>
                        <button class="btn btn-success" onclick="single_pic(); return false;">單選</button>
                        <button class="btn btn-success" onclick="multi_pic(); return false;">多選</button>
                    </div>

                    <script type="text/javascript">
                        function single_pic()
                        {
                            document.getElementById("single_pic_radio").checked=true;
                            document.getElementById("multi_pic_radio").checked=false;

                            var pic_div_form = document.createElement("DIV");
                            pic_div_form.setAttribute("class","form-group");
                            var word = '<label class="control-label col-md-3" for="first-name">正解 :<span class="required"></span></label>';
                            var A = '<input type="radio" class="radio-inline flat" id="radio_1" name="answer[]" value="A1" required><label>A選項</label>';
                            var B = '<input type="radio" class="radio-inline flat" id="radio_2" name="answer[]" value="A2"><label>B選項</label>';
                            var C = '<input type="radio" class="radio-inline flat" id="radio_3" name="answer[]" value="A3"><label>C選項</label>';
                            var D = '<input type="radio" class="radio-inline flat" id="radio_4" name="answer[]" value="A4"><label>D選項</label>';
                            pic_div_form.innerHTML = word+A+B+C+D;

                            var pic_list = document.getElementById("pic_ca");
                            while(pic_list.hasChildNodes()){
                                pic_list.removeChild(pic_list.firstChild);
                            }
                            document.getElementById("pic_ca").appendChild(pic_div_form);
                            document.getElementById("single_pic_submit").disabled = false;

                        }

                        function multi_pic()
                        {
                            document.getElementById("single_pic_radio").checked=false;
                            document.getElementById("multi_pic_radio").checked=true;

                            var pic_div_form = document.createElement("DIV");
                            pic_div_form.setAttribute("class","form-group");
                            var word = '<label class="control-label col-md-3" for="first-name">正解 :<span class="required"></span></label>';
                            var A = '<input type="checkbox" class="radio-inline flat" id="check_1" name="answer[]" value="A1"><label>A選項</label>';
                            var B = '<input type="checkbox" class="radio-inline flat" id="check_2" name="answer[]" value="A2"><label>B選項</label>';
                            var C = '<input type="checkbox" class="radio-inline flat" id="check_3" name="answer[]" value="A3"><label>C選項</label>';
                            var D = '<input type="checkbox" class="radio-inline flat" id="check_4" name="answer[]" value="A4"><label>D選項</label>';
                            pic_div_form.innerHTML = word+A+B+C+D;

                            var pic_list = document.getElementById("pic_ca");
                            while(pic_list.hasChildNodes()){
                                pic_list.removeChild(pic_list.firstChild);
                            }
                            document.getElementById("pic_ca").appendChild(pic_div_form);
                            document.getElementById("single_pic_submit").disabled = false;

                        }
                    </script>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="first-name">測驗型別 :<span class="required"></span></label>
                        <input type="radio" class="radio-inline flat" id="class_1" name="classification[]" value="1" required><label>詞彙理解</label>
                        <input type="radio" class="radio-inline flat" id="class_2" name="classification[]" value="2" required><label>詞彙表達</label>
                        <input type="radio" class="radio-inline flat" id="class_3" name="classification[]" value="3" required><label>語法表現</label>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3" for="first-name">題目 :<span class="required"></span></label>
                        <div class="col-md-5">
                            <input type="text" id="Q1"  name="Q1" required="required" class="form-control col-md-7 col-xs-12">
                        </div>

                        <label class="control-label col-md-1" for="last-name">附加音檔: <span></span></label>
                        <div class="col-md-3">
                            <input type="file" name="audio_file"/>
                        </div>
                    </div>
                    <div class="form-group  sameline">
                        <label class="control-label col-md-3" for="last-name">題目附圖 : <span></span></label>
                        <input type="file" name="Q1_file" id="Q1_file"/>
                        <label for="last-name">alt :</label>
                        <input type="text" name="Q1_alt" id="Q1_alt">
                    </div>
                    <div class="thumbnail" style="border-style: outset; width:200px; height:200px; margin:0px auto;">
                          <img id="img0" src="" alt="">
                    </div>
                    <hr style="border-top: 2px dashed #2D99C8;" />


                    <HR>
                    <HR>

                      <div class="form-group sameline">
                          <label class="control-label col-md-3" for="last-name">選項(A)附圖 : <span></span></label>
                          <input type="file" name="A1_file" id="A1_file"/>
                          <label for="last-name">alt :</label>
                          <input type="text" name="A1_alt" id="A1_alt">
                          <label class="col-md-2" style="text-align:right;">附加音檔:<span></span></label>
                          <input type="file" name="audio_A1"/>
                      </div>
                      <div class="thumbnail" style="border-style: outset; width:200px; height:200px; margin:0px auto;">
                            <img id="img1" src="" alt="">
                      </div>
                      <hr style="border-top: 2px dashed #2D99C8;" />


                      <div class="form-group sameline">
                          <label class="control-label col-md-3" for="last-name">選項(B)附圖 : <span></span></label>
                          <input type="file" name="A2_file" id="A2_file"/>
                          <label for="last-name">alt :</label>
                          <input type="text" name="A2_alt" id="A2_alt">
                          <label class="col-md-2" style="text-align:right;">附加音檔:<span></span></label>
                          <input type="file" name="audio_A2"/>
                      </div>
                      <div class="thumbnail" style="border-style: outset; width:200px; height:200px; margin:0px auto;">
                            <img id="img2" src="" alt="">
                      </div>
                      <hr style="border-top: 2px dashed #2D99C8;" />



                      <div class="form-group sameline">
                          <label class="control-label col-md-3" for="last-name">選項(C)附圖 : <span></span></label>
                          <input type="file" name="A3_file" id="A3_file"/>
                          <label for="last-name">alt :</label>
                          <input type="text" name="A3_alt" id="A3_alt">
                          <label class="col-md-2" style="text-align:right;">附加音檔:<span></span></label>
                          <input type="file" name="audio_A3"/>
                      </div>
                      <div class="thumbnail" style="border-style: outset; width:200px; height:200px; margin:0px auto;">
                            <img id="img3" src="" alt="">
                      </div>
                      <hr style="border-top: 2px dashed #2D99C8;" />



                      <div class="form-group sameline">
                          <label class="control-label col-md-3" for="last-name">選項(D)附圖 : <span></span></label>
                          <input type="file" name="A4_file" id="A4_file"/>
                          <label for="last-name">alt :</label>
                          <input type="text" name="A4_alt" id="A4_alt">
                          <label class="col-md-2" style="text-align:right;">附加音檔:<span></span></label>
                          <input type="file" name="audio_A4"/>
                      </div>
                      <div class="thumbnail" style="border-style: outset; width:200px; height:200px; margin:0px auto;">
                            <img id="img4" src="" alt="">
                      </div>
                      <hr style="border-top: 2px dashed #2D99C8;" />


                    <div id="pic_ca"></div>

                    <script
                      src="https://code.jquery.com/jquery-1.9.0.js"
                      integrity="sha256-TXsBwvYEO87oOjPQ9ifcb7wn3IrrW91dhj6EMEtRLvM="
                      crossorigin="anonymous">
                    </script>
                    <script>


                    window.onload = function() {
                          document.getElementById("img0").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                          document.getElementById("img1").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                          document.getElementById("img2").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                          document.getElementById("img3").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                          document.getElementById("img4").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
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
                    $("#A1_file").change(function(){
                        var objUrl = getObjectURL(this.files[0]) ;
                        console.log("objUrl = "+objUrl) ;
                        if (objUrl) {
                            $("#img1").attr("src", objUrl) ;
                        }
                        var Img = document.getElementById('img1');
                        document.getElementById("img1").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                    }) ;
                    $("#A2_file").change(function(){
                        var objUrl = getObjectURL(this.files[0]) ;
                        console.log("objUrl = "+objUrl) ;
                        if (objUrl) {
                            $("#img2").attr("src", objUrl) ;
                        }
                        var Img = document.getElementById('img2');
                        document.getElementById("img2").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                    }) ;
                    $("#A3_file").change(function(){
                        var objUrl = getObjectURL(this.files[0]) ;
                        console.log("objUrl = "+objUrl) ;
                        if (objUrl) {
                            $("#img3").attr("src", objUrl) ;
                        }
                        var Img = document.getElementById('img3');
                        document.getElementById("img3").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                    }) ;
                    $("#A4_file").change(function(){
                        var objUrl = getObjectURL(this.files[0]) ;
                        console.log("objUrl = "+objUrl) ;
                        if (objUrl) {
                            $("#img4").attr("src", objUrl) ;
                        }
                        var Img = document.getElementById('img4');
                        document.getElementById("img4").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
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




                    <!-- EDIT BLOCK-->
                    <input type="hidden" name="edit_tag" value="edit"/>
                    <input type="hidden" name="question_number" <?php echo 'value="'.$question_number.'" >';?>

                    <clearfix>
                      <div class="form-group">
                          <label class="control-label col-md-6"><font color="red">註1：若"送出"按鈕無法點選，代表尚未選擇答題類型(單選/多選)</font></label>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-5" for="first-name"><font color="red">註2：若選擇"多選"，請務必確認有勾選正解</font></label>
                      </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="reset">重填</button>
                        <button type="submit" id="single_pic_submit" class="btn btn-success" disabled>送出</button>
                    </div>
                </form>

            </div>
            <!-- Question -->

            <?php
            // PHP BLOCK, SETTING ALL DEFAULT VALUE HERE!
            include("connects.php");
            $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'Q'";
            $result = mysqli_fetch_object($db->query($sql));
            $type = $result->type;
            $content = $result->Content;
            $single_or_multi = $result->single_or_multi;
            $CA = $result->CA;
            $classification = $result->classification;

            //echo $type.$content.$single_or_multi.$CA.$classification;

            //SINGLE OR MULTI AND DEFAULT CA
            if($single_or_multi=="SINGLE")
            {
              echo '<script>single_pic();</script>';
              if($CA=="A1")echo '<script>document.getElementById("radio_1").checked = true;</script>';
              else if($CA=="A2")echo '<script>document.getElementById("radio_2").checked = true;</script>';
              else if($CA=="A3")echo '<script>document.getElementById("radio_3").checked = true;</script>';
              else if($CA=="A4")echo '<script>document.getElementById("radio_4").checked = true;</script>';
            }
            else
            {
              echo '<script>multi_pic();</script>';
              // IF CA CONTAINS 'A1', DO ...
              if(strpos($CA, 'A1')!==false)echo '<script>document.getElementById("check_1").checked = true;</script>';
              if(strpos($CA, 'A2')!==false)echo '<script>document.getElementById("check_2").checked = true;</script>';
              if(strpos($CA, 'A3')!==false)echo '<script>document.getElementById("check_3").checked = true;</script>';
              if(strpos($CA, 'A4')!==false)echo '<script>document.getElementById("check_4").checked = true;</script>';
            }

            //CLASSIFIACATION
            if($classification=="1") echo '<script>document.getElementById("class_1").checked = true;</script>';
            else if($classification=="2") echo '<script>document.getElementById("class_2").checked = true;</script>';
            else if($classification=="3") echo '<script>document.getElementById("class_3").checked = true;</script>';

            //Question
            echo '<script>document.getElementById("Q1").value="'.$content.'";</script>';
            $q1_pic_ext = $result->picture_ext;
            $q1_pic_alt = $result->picture_alt;
            if(strlen($q1_pic_ext)>0) echo '<script>document.getElementById("img0").src = "upload/Q'.$question_number.'Q1.'.$q1_pic_ext.'"</script>';
            if(strlen($q1_pic_alt)>0) echo '<script>document.getElementById("Q1_alt").value = "'.$q1_pic_alt.'"</script>';

            //A1
            $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'A1'";
            $result = mysqli_fetch_object($db->query($sql));
            $a1_pic_ext = $result->picture_ext;
            $a1_pic_alt = $result->picture_alt;
            if(strlen($a1_pic_ext)>0) echo '<script>document.getElementById("img1").src = "upload/Q'.$question_number.'A1.'.$a1_pic_ext.'"</script>';
            if(strlen($a1_pic_alt)>0) echo '<script>document.getElementById("A1_alt").value = "'.$a1_pic_alt.'"</script>';

            //A2
            $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'A2'";
            $result = mysqli_fetch_object($db->query($sql));
            $a2_pic_ext = $result->picture_ext;
            $a2_pic_alt = $result->picture_alt;
            if(strlen($a2_pic_ext)>0) echo '<script>document.getElementById("img2").src = "upload/Q'.$question_number.'A2.'.$a2_pic_ext.'"</script>';
            if(strlen($a2_pic_alt)>0) echo '<script>document.getElementById("A2_alt").value = "'.$a2_pic_alt.'"</script>';

            //A1
            $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'A3'";
            $result = mysqli_fetch_object($db->query($sql));
            $a3_pic_ext = $result->picture_ext;
            $a3_pic_alt = $result->picture_alt;
            if(strlen($a3_pic_ext)>0) echo '<script>document.getElementById("img3").src = "upload/Q'.$question_number.'A3.'.$a3_pic_ext.'"</script>';
            if(strlen($a3_pic_alt)>0) echo '<script>document.getElementById("A3_alt").value = "'.$a3_pic_alt.'"</script>';

            //A1
            $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'A4'";
            $result = mysqli_fetch_object($db->query($sql));
            $a4_pic_ext = $result->picture_ext;
            $a4_pic_alt = $result->picture_alt;
            if(strlen($a4_pic_ext)>0) echo '<script>document.getElementById("img4").src = "upload/Q'.$question_number.'A4.'.$a4_pic_ext.'"</script>';
            if(strlen($a4_pic_alt)>0) echo '<script>document.getElementById("A4_alt").value = "'.$a4_pic_alt.'"</script>';


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
