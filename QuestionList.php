<!DOCTYPE html>

<?php
session_start();
if($_SESSION['username'] == null)
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


            <!-- Question -->
            <div class="x_panel">
                <!-- title bar-->
                <div class="x_title">
                  <h1><b>題庫</b></h1>
                  <div class="clearfix"></div>
                </div>
        				<form class="form-horizontal form-label-left input_mask" method="post" action="QuestionList.php">
        					<div>
        						<label class="control-label col-md-2 col-sm-2 col-xs-12">題目型別 :</label>
        						<div class="col-md-2 col-sm-2">
        						  <select id="search_type" name="search_type" class="form-control">
        							<option value="0">請選擇題目型別</option>
        							<option value="LWORD">文字順序</option>
        							<option value="WORD">文字選擇</option>
        							<option value="LPICTURE">圖片順序</option>
        							<option value="PICTURE">圖片選擇</option>
        							<option value="VIDEO">影片選擇</option>
        							<option value="KEYBOARD">KEYBOARD</option>
        						  </select>
        						</div>

        						<label class="control-label col-md-2 col-sm-2 col-xs-12">測驗型別 :</label>
        						<div class="col-md-2 col-sm-2">
        						  <select id="search_classification" name="search_classification" class="form-control">
        							<option value="0">請選擇測驗型別</option>
        							<option value="1">詞彙理解</option>
        							<option value="2">詞彙表達</option>
        							<option value="3">語法表現</option>
        						  </select>
        						</div>

        						<button type="submit" id="btn_submit" class="btn btn-success">搜尋</button>
        					</div>
                </form>


                <!-- title bar-->

                <!-- Question List Table -->
                <table id="q_list" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>題號.</th>
                      <th>文字/圖片</th>
                      <th>測驗型別</th>
                      <th>題目</th>
                      <th>編輯</th>
                      <th>刪除</th>
                    </tr>
                  </thead>
                  <?php
                    include("connects.php");
                    $sql = "SELECT MAX(No) AS max FROM QuestionList WHERE `QA` = 'Q'";
                    $result = mysqli_fetch_object($db->query($sql));
                    $max_number = $result->max;
                    $content = array();
                    $type = array();
                    $classification = array();
					          $No = array();
			              $max_count = 0;

            				if(isset($_POST['search_type'])){
            					 if(strpos($_POST['search_type'],'0') === false){
            						$search_type = $_POST['search_type'];
            					}
            				}
            				if(isset($_POST['search_classification'])){
            					if($_POST['search_classification'] != "0"){
            						$search_classification = $_POST['search_classification'];
            					}
            				}


                    for ( $a = 1, $count_index = 1 ; $a<=$max_number ; $a++)
                    {
            						$sql2 = "SELECT * FROM `QuestionList` WHERE `No` = $a AND `QA` = 'Q' AND `status`='1'";

            						if(isset($_POST['search_type'])){
            							if(strpos($_POST['search_type'],'0') === false){
            								$sql2 = $sql2." AND `type` = '$search_type'";
            							}
            						}
            						if(isset($_POST['search_classification'])){
            							if($_POST['search_classification'] != 0){
            								$sql2 = $sql2." AND `classification` = $search_classification";
            							}
            						}

            						$result2 = mysqli_fetch_object($db->query($sql2));
            						if(!empty($result2->Content))
            						{
            							if(!is_null($result2->Content))
            							{
            								$No[$count_index] = $result2->No;
            								$content[$count_index] = $result2->Content;
            								$type[$count_index] = $result2->type;
            								$classification[$count_index] = $result2->classification;

            								$No_to_json = json_encode((array)$No);
            								$content_to_json=json_encode((array)$content);
            								$type_to_json=json_encode((array)$type);
            								$class_to_json=json_encode((array)$classification);

            								$count_index++;
            								$max_count = $count_index;
            							}
            						}

                    }
                  ?>
                  <tbody>
                    <tr>
                      <?php
		                  if($max_count > 0){
                        echo '<td>'.$No[1].'</td>';
                        if($type[1]=='WORD')echo '<td>文字選擇</td>';
                        else if($type[1]=='PICTURE')echo '<td>圖片選擇</td>';
                        else if($type[1]=='LWORD')echo '<td>文字順序</td>';
                        else if($type[1]=='LPICTURE')echo '<td>圖片順序</td>';
                        else if($type[1]=='VIDEO')echo '<td>影片</td>';
                        else if($type[1]=='KEYBOARD')echo '<td>KEYBOARD</td>';

                        if($classification[1]=='0') echo '<td>未選擇</td>';
                        else if($classification[1]=='1') echo '<td>詞彙理解</td>';
                        else if($classification[1]=='2') echo '<td>詞彙表達</td>';
                        else if($classification[1]=='3') echo '<td>語法表現</td>';
                        echo '<td>'.$content[1].'</td>';
                        echo '<td><button type="submit" class="btn btn-info" onclick="btnclk('.$No[1].')">編輯</button></td>';
                        echo '<td><button type="submit" class="btn btn-danger" onclick="btndelete('.$No[1].')">刪除</button></td>';
			                }
                      ?>
                      <!--td></td>
                      <td></td>
                      <td></td-->
                    </tr>

                  </tbody>
                </table>
                <!-- Question List Table -->

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

			      <?php
              include("connects.php");
              $sql = "SELECT Max(No) AS max FROM QuestionList WHERE `QA`='Q' ";
              $result = mysqli_fetch_object($db->query($sql));
              $max_number = $result->max;
              $content = array();
              $type = array();
              $classification = array();
    					$No = array();
    			    $maxcount = 0;

    					if(isset($_POST['search_type'])){
    						 if(strpos($_POST['search_type'],'0') === false){
    							$search_type = $_POST['search_type'];
    						}
    					}

    					if(isset($_POST['search_classification'])){
    						if($_POST['search_classification'] != "0"){
    							$search_classification = $_POST['search_classification'];
    						}
    					}


              for ( $a = 1, $count_index = 1 ; $a<=$max_number ; $a++)
              {
						    $sql2 = "SELECT * FROM `QuestionList` WHERE `No` = $a AND `QA` = 'Q' AND `status`='1'";

    						if(isset($_POST['search_type'])){
    							 if(strpos($_POST['search_type'],'0') === false){
    								$sql2 = $sql2." AND `type` = '$search_type'";
    							}
    						}
    						if(isset($_POST['search_classification'])){
    							if($_POST['search_classification'] != 0){
    								$sql2 = $sql2." AND `classification` = $search_classification";
    							}
    						}

    						$result2 = mysqli_fetch_object($db->query($sql2));
    						if(!empty($result2->Content))
    						{
    							if(!is_null($result2->Content))
    							{
    								$No[$count_index] = $result2->No;
    								$content[$count_index] = $result2->Content;
    								$type[$count_index] = $result2->type;
    								$classification[$count_index] = $result2->classification;

    								$No_to_json = json_encode((array)$No);
    								$content_to_json=json_encode((array)$content);
    								$type_to_json=json_encode((array)$type);
    								$class_to_json=json_encode((array)$classification);

    								$count_index++;
    								$max_count = $count_index;
    							}
    						}

              }
            ?>


            <script type="text/javascript" class="init">
                $('#q_list').dataTable( {
                  "columns": [
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "10%" },
                    { "width": "60%" },
                    { "width": "5%" },
                    { "width": "5%" },
                  ]
                } );

                function btnclk(q_index)
                {
                  var index = q_index;
                  window.location.href = 'editQuestion_main.php?number='+index;
                }

                function btndelete(q_index)
                {
                  var index = q_index;
                  window.location.href = 'DeleteQuestion.php?number='+index;
                }


                $(document).ready
                (
                function(){
							  var No_fromPHP = <? echo $No_to_json ?>;
                              var content_fromPHP=<? echo $content_to_json ?>;
                              var type_fromPHP=<? echo $type_to_json ?>;
                              var class_fromPHP=<? echo $class_to_json ?>;
                              var bt = "<button type=\"submit\" class=\"btn btn-info\" onclick=\"btnclk()\">編輯</button>";
                              var bt2 = "<button type=\"submit\" class=\"btn btn-danger\" onclick=\"btndelete()\">刪除</button>";
                              var t = $('#q_list').DataTable();
                              for (var i=2 ; i< <?php echo "$max_count";?> ; i++)
                              {
                                if(type_fromPHP[i]=="WORD"){type_fromPHP[i]="文字選擇";}
                                else if(type_fromPHP[i]=="PICTURE"){type_fromPHP[i]="圖片選擇";}
                                else if(type_fromPHP[i]=="LWORD"){type_fromPHP[i]="文字順序";}
                                else if(type_fromPHP[i]=="LPICTURE"){type_fromPHP[i]="圖片順序";}
                                else if(type_fromPHP[i]=="VIDEO"){type_fromPHP[i]="影片";}
                                else if(type_fromPHP[i]=="KEYBOARD"){type_fromPHP[i]="KEYBOARD";}

                                if(class_fromPHP[i]=="0"){class_fromPHP[i]="未選擇";}
                                else if(class_fromPHP[i]=="1"){class_fromPHP[i]="詞彙理解";}
                                else if(class_fromPHP[i]=="2"){class_fromPHP[i]="詞彙表達";}
                                else if(class_fromPHP[i]=="3"){class_fromPHP[i]="語法表現";}

                                t.row.add(
                                    [
                                    No_fromPHP[i],
                                    type_fromPHP[i],
                                    class_fromPHP[i],
                                    content_fromPHP[i],
                                    "<button type=\"submit\" class=\"btn btn-info\" onclick=\"btnclk("+No_fromPHP[i]+")\">編輯</button>",
                                    "<button type=\"submit\" class=\"btn btn-danger\" onclick=\"btndelete("+No_fromPHP[i]+")\">刪除</button>",
                                    ]).draw(false);

                              }
                        }

                );

            </script>
  </body>
</html>
