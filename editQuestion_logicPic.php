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
                  <h1><b>圖片順序題編輯</b></h1>
                  <div class="clearfix"></div>
                </div>
                <!-- title bar-->

                <div class="form-horizontal form-label-left">
                  <div class="form-group">
                    <label class="control-label col-md-3" for="first-name">增減選項 : </label>
                    <button class="btn btn-success" onclick="combine_add()">+</button>
                    <button class="btn btn-danger" onclick="subInputPic()">-</button>
                  </div>
                </div>

                <form class="form-horizontal form-label-left" method="post" action="updateEdit_logicPic.php" enctype="multipart/form-data" onKeyDown="if (event.keyCode == 13) {return false;}">
                <div class="form-group">
                    <label class="control-label col-md-3" for="first-name">題目流水號 : </label>
                    <label class="control-label">
                        <?php
                          echo $question_number;
                        ?>
                    </label>
                </div>


                <div id="messagePic"></div>


                <HR>
                <HR>
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
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3" for="first-name">正確順序 :<span class="required"></span></label>
                    <div class="col-md-5">
                        <input type="text" id="CA"  name="CA" placeholder="正解順序 例如: A1-A3-A2-A4" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                </div>

                <input type="hidden" name="picture_number"  id="picture_number">
                <input type="hidden" name="question_number" <?php echo 'value="'.$question_number.'" >';?>
                <clearfix>
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">重填</button>
                    <button type="submit" class="btn btn-success">送出</button>
                </div>
                </form>
                </div>


                <script
                      src="https://code.jquery.com/jquery-1.9.0.js"
                      integrity="sha256-TXsBwvYEO87oOjPQ9ifcb7wn3IrrW91dhj6EMEtRLvM="
                      crossorigin="anonymous">
                      </script>
                <script>
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
                <script type="text/javascript">
                var pic_create_input_number = 0;



                function addInputPic() {
                        pic_create_input_number++;
                        var div_form = document.createElement("DIV");
                        div_form.setAttribute("class","form-group");
                        name = 'div_qpic'+pic_create_input_number;
                        div_form.setAttribute("id",name);


                        var lb = '<label class="control-label col-md-3" for="first-name">圖片' + pic_create_input_number +' :<span class="required"></span></label>';
                        var md5 = '<div class="col-md-3">';
                        var input_q =  '<input type="file" name="A'+pic_create_input_number+'_file" id="A'+pic_create_input_number+'_file"/>';
                        var view = '<div class="thumbnail" style="border-style: outset; width:200px; height:200px; margin:0px auto;">'+
                                          '<img id="img'+pic_create_input_number+'" src="" alt="">'+
                                    '</div>';
                        div_form.innerHTML = lb+md5+input_q+view;
                        document.getElementById("messagePic").appendChild(div_form);
                        document.getElementById("picture_number").value=pic_create_input_number;
                        }

                function subInputPic() {
                          if(pic_create_input_number>1)
                            {
                              _name = 'div_qpic'+pic_create_input_number;
                            document.getElementById(_name).remove();
                            pic_create_input_number--;
                            document.getElementById("picture_number").value=pic_create_input_number;
                            }
                        }

                //addInputPic();

                </script>



                <?php
                // PHP BLOCK, SETTING ALL DEFAULT VALUE HERE!
                include("connects.php");
                $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'Q'";
                $result = mysqli_fetch_object($db->query($sql));
                $content = $result->Content;
                $CA = $result->CA;
                $classification = $result->classification;
                $KeyboardNo = $result->KeyboardNo;

                //Question
                echo '<script>document.getElementById("Q1").value="'.$content.'";</script>';
                echo '<script>document.getElementById("CA").value="'.$CA.'";</script>';

                //CLASSIFIACATION
                if($classification=="1") echo '<script>document.getElementById("class_1").checked = true;</script>';
                else if($classification=="2") echo '<script>document.getElementById("class_2").checked = true;</script>';
                else if($classification=="3") echo '<script>document.getElementById("class_3").checked = true;</script>';

                //Default Answer
                $sql = "SELECT * FROM Keyboard WHERE KeyboardNo = '$KeyboardNo'";
                $result = mysqli_fetch_object($db->query($sql));
                $ext = $result->ext;
                $ext = explode("-", $ext);
                $old_count = count($ext);



                for($i = 1 ; $i <= $old_count ; $i++)
                {
                  echo'<script>addInputPic();</script>';
                  echo '
                  <script>
                  $("#A'.$i.'_file").change(function(){
                      var objUrl = getObjectURL(this.files[0]) ;
                      console.log("objUrl = "+objUrl) ;
                      if (objUrl) {
                          $("#img'.$i.'").attr("src", objUrl) ;
                      }
                      var Img = document.getElementById("img'.$i.'");
                      document.getElementById("img'.$i.'").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                  }) ;
                  </script>
                  ';
                }
                ?>



                <script>
                function combine_add(){
                  //THE NEW ADDINPUTPIC MUST COMBINE THE PREVIEW FUNCTION
                  addInputPic();
                  <?php
                  echo '
                  $("#A'.$i.'_file").change(function(){
                      var objUrl = getObjectURL(this.files[0]) ;
                      console.log("objUrl = "+objUrl) ;
                      if (objUrl) {
                          $("#img'.$i.'").attr("src", objUrl) ;
                      }
                      var Img = document.getElementById("img'.$i.'");
                      document.getElementById("img'.$i.'").setAttribute("style", "max-height:100%;max-height:100%;border-style: outset;");
                  }) ;';

                  ?>
                }
                </script>


                <?php

                //SETTING THE DEFAULT IMG
                for($j = 1; $j <= $old_count ; $j++)
                {
                  $array_index = $j-1;
                  echo '<script>document.getElementById("img'.$j.'").src="upload/K'.$KeyboardNo.'A'.$j.'.'.$ext[$array_index].'";</script>';
                }
                ?>


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
            <!--script src="../vendors/DataTables_new/datatables.js"></script-->

            <!-- Custom Theme Scripts -->
            <script src="../build/js/custom.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>


  </body>
</html>
