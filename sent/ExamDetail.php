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


<?php
	include("connects.php");

	$exam_number = $_POST['edit_number'];

  $sql = "SELECT * FROM `ExamList` WHERE `No`='$exam_number'";
  $result = mysqli_fetch_object($db->query($sql));
  $exam_title = $result->ExamTitle;
  $exam_teacher = $result->Teacher;
  $exam_note = $result->Note;

  $db->close();

?>

<!DOCTYPE html>


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
              <a class="site_title"><i class="fas fa-book"></i> <span>Chen's IRS</span></a>
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
            <div class="page-title">
              <div class="title_left">
                <h3><b>設計測驗卷</b></h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <!-- really important clearfix -->

            <div class="col-md-6 col-xs-12">
        	   <div class="row">
    	            <div class="x_panel">
    	                <!-- title bar-->
    	                <div class="x_title">
    	                  <h4><b>測驗卷細節</b></h4>
    	                  <div class="clearfix"></div>
    	                </div>
    	                <!-- title bar-->

                        <!-- content area-->
                        <div class="x_content">


                                <?php
                                    include("connects.php");
                                    $sql = "SELECT COUNT(No) AS max FROM QuestionList WHERE QA='Q' AND status!='0'";
                                    $result = mysqli_fetch_object($db->query($sql));
                                    $maxnum = $result->max;

                                    $question_number = array();
                                    $question_content = array();
                                    $classification_array = array();
                                    $index = 1;
                                    $sql = "SELECT * FROM QuestionList WHERE QA = 'Q' AND status!='0' ORDER BY type DESC ,single_or_multi DESC";
                                    if($stmt = $db->query($sql))
                                    {
                                        while($result = mysqli_fetch_object($stmt))
                                        {
                                            $question_content[$index] = $result->Content;
                                            $question_number[$index] = $result->No;
                                            $classification_array[$index] = $result->classification;
                                            $index++;
                                        }
                                    }
                                    //GET THE QUESTIONG CONTNET IN THE ARRAY question_content and QUESTION NUMBER IN ARRAY question_number

                                    $sql = "SELECT count(No) AS SWNumber FROM `QuestionList` WHERE QA='Q' AND type='WORD' AND single_or_multi='single' AND status!='0'";
                                    $SWNumber = mysqli_fetch_object($db->query($sql))->SWNumber;
                                    $sql = "SELECT count(No) AS MWNumber FROM `QuestionList` WHERE QA='Q' AND type='WORD' AND single_or_multi='multi' AND status!='0'";
                                    $MWNumber = mysqli_fetch_object($db->query($sql))->MWNumber;
                                    $sql = "SELECT count(No) AS SVNumber FROM `QuestionList` WHERE QA='Q' AND type='VIDEO' AND single_or_multi='single' AND status!='0'";
                                    $SVNumber = mysqli_fetch_object($db->query($sql))->SVNumber;
                                    $sql = "SELECT count(No) AS MVNumber FROM `QuestionList` WHERE QA='Q' AND type='VIDEO' AND single_or_multi='multi' AND status!='0'";
                                    $MVNumber = mysqli_fetch_object($db->query($sql))->MVNumber;
                                    $sql = "SELECT count(No) AS SPNumber FROM `QuestionList` WHERE QA='Q' AND type='PICTURE' AND single_or_multi='single' AND status!='0'";
                                    $SPNumber = mysqli_fetch_object($db->query($sql))->SPNumber;
                                    $sql = "SELECT count(No) AS MPNumber FROM `QuestionList` WHERE QA='Q' AND type='PICTURE' AND single_or_multi='multi' AND status!='0'";
                                    $MPNumber = mysqli_fetch_object($db->query($sql))->MPNumber;


                                    function ddl_content()
                                    {
                                        global $maxnum,$SWNumber,$MWNumber,$SVNumber,$MVNumber,$SPNumber,$MPNumber,$question_number,$q_list,$question_content,$classification_array;
                                        for ($i=1 ; $i<=$maxnum ; $i++)
                                        {
                                        if($i==1){echo "<optgroup label=\"單選文字\">";}
                                        if($i==1+$SWNumber){echo "<optgroup label=\"多選文字\">";}
                                        if($i==1+$SWNumber+$MWNumber){echo "<optgroup label=\"單選影片\">";}
                                        if($i==1+$SWNumber+$MWNumber+$SVNumber){echo "<optgroup label=\"多選影片\">";}
                                        if($i==1+$SWNumber+$MWNumber+$SVNumber+$MVNumber){echo "<optgroup label=\"單選圖片\">";}
                                        if($i==1+$SWNumber+$MWNumber+$SVNumber+$MVNumber+$SPNumber){echo "<optgroup label=\"多選圖片\">";}
                                        echo "<option value=";
                                        echo " \"";
                                        echo "$question_number[$i]";
                                        echo " \"";
                                        /*if (($question_number[$i] == $q_list[$q_list_index]) && sizeof($q_list)>1 )
                                        {
                                             echo " selected ";
                                        }*/
                                        echo ">";
                                        if($classification_array[$i]=="1")
                                        {
                                          echo '[理解] '.$question_content[$i];
                                        }
                                        else if ($classification_array[$i]=="2")
                                        {
                                          echo '[表達] '.$question_content[$i];
                                        }
                                        else if ($classification_array[$i]=="3")
                                        {
                                          echo '[表現] '.$question_content[$i];
                                        }
                                        else if ($classification_array[$i]=="0")
                                        {
                                          echo '[未設定] '.$question_content[$i];
                                        }
                                        echo "</option>";
                                        if($i==$SWNumber){echo "</optgroup>";}
                                        if($i==$SWNumber+$MWNumber){echo "</optgroup>";}
                                        if($i==$SWNumber+$MWNumber+$SVNumber){echo "</optgroup>";}
                                        if($i==$SWNumber+$MWNumber+$SVNumber+$MVNumber){echo "</optgroup>";}
                                        if($i==$SWNumber+$MWNumber+$SVNumber+$MVNumber+$SPNumber){echo "</optgroup>";}
                                        if($i==$SWNumber+$MWNumber+$SVNumber+$MVNumber+$SPNumber+$MPNumber){echo "</optgroup>";}
                                        }
                                    }
                                ?>


                            <form class="form-horizontal form-label-left" method="post" action="editExam.php" onKeyDown="if (event.keyCode == 13) {return false;}">
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">測驗卷編號</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <input type="text" class="form-control" readonly="readonly" name="exam_num" placeholder="<?php echo $exam_number;?>" value="<?php echo $exam_number;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">測驗卷名稱</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <input type="text" class="form-control" required="required" name="ExamTitle" value="<?php echo $exam_title;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">測驗說明</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <input type="text" class="form-control" name="Note" value="<?php echo $exam_note;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">出題老師</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                      <input type="text" class="form-control" required="required" name="Teacher" value="<?php echo $exam_teacher;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-md-3" for="first-name">增減習題數量 : </label>
                                  <button type="button" class="btn btn-success" onclick="addInputExe()">增加</button>
                                  <button type="button" class="btn btn-danger" onclick="subInputExe()">減少</button>
                                </div>

                                <div id="exercise"></div>
                                <input type="hidden" name="exercise_number"  id="exercise_number">
                                <script>
                                var exercise_create_input_number = 0;
                                function addInputExe() {
                                          exercise_create_input_number++;
                                          var ediv_form = document.createElement("DIV");
                                          ediv_form.setAttribute("class","form-group");
                                          name = 'div_epic'+exercise_create_input_number;
                                          ediv_form.setAttribute("id",name);

                                          var elb =
                                                  '<div class="form-group">'+
                                                  '<label class="control-label col-md-3 col-sm-3 col-xs-12">第'+exercise_create_input_number+'題</label>'+
                                                    '<div class="col-md-9 col-sm-9 col-xs-12">'+
                                                      '<select class="select2_single form-control" id="q'+exercise_create_input_number+'_id" name="q1[]" tabindex="-1" required>'+
                                                        '<?php ddl_content(0);?>'+
                                                      '</select>'+
                                                    '</div>'+
                                                  '</div>';


                                          ediv_form.innerHTML = elb;
                                          document.getElementById("exercise").appendChild(ediv_form);
                                          document.getElementById("exercise_number").value=exercise_create_input_number;
                                          }
                                function subInputExe() {
                                            if(exercise_create_input_number>1)
                                              {
                                                _ename = 'div_epic'+exercise_create_input_number;
                                              document.getElementById(_ename).remove();
                                              exercise_create_input_number--;
                                              document.getElementById("exercise_number").value=exercise_create_input_number;
                                              }
                                          }


                                function settingSelected(list_index,selected_index)//this function for edit to select the default ddl index
                                {
                                  list_index++;
                                  var name = "q"+list_index+"_id";
                                  document.getElementById(name).selectedIndex = selected_index;
                                }
                                </script>

                                <?php
                                //----------EDIT BLOCK----------
                                $sql = "SELECT * FROM `ExamList` WHERE `No`='$exam_number'";
                                $result = mysqli_fetch_object($db->query($sql));
                                $q_list = array();
                                $temp_string = $result->question_list;
                                $q_list = mb_split(",",$temp_string);

                                foreach ($q_list as $key => $value) {
                                  echo '<script>addInputExe('.$q_list[$key].')</script>';

                                  for($i = 1 ; $i < $index ; $i++)
                                  {
                                    if($question_number[$i]==trim($q_list[$key]))
                                    {
                                      $temp_index = $i-1;
                                      echo '<script>settingSelected('.$key.','.$temp_index.')</script>';
                                    }
                                  }
                                }
                                //----------EDIT BLOCK----------
                                ?>

                                  <div class="ln_solid"></div>
                                  <div class="form-group">
                                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                      <button type="submit" name class="btn btn-success">編輯</button>
                                    </div>
                                  </div>

                            </form>
                        </div>
                        <!-- content area-->
    	            </div>
                </div>
	        </div>
    	</div>
        <!-- page content################################# -->


        <!-- footer content -->
        <footer>
        </footer>
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
