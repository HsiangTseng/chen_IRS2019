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
                  <h1><b>學生考試紀錄</b></h1>
                  <div class="clearfix"></div>
                </div>
        	<form class="form-horizontal form-label-left input_mask" method="POST" action="StudentExamResult.php">
			<div>
                        	<label class="control-label col-md-1 col-sm-1 col-xs-12">就讀年級 :</label>
		                <div class="col-md-2 col-sm-2">
        	        		<select id="search_grade" name="search_grade" class="form-control" onChange="catch_student()" >
						<option value="0">請選擇年級</option>
					        <option value="1">一</option>
	                	        	<option value="2">二</option>
        	        			<option value="3">三</option>
		        	        	<option value="4">四</option>
        				        <option value="5">五</option>
			        		<option value="6">六</option>
			        	</select>
		                </div>
                	        <label class="control-label">年</label>

	                        <label class="control-label col-md-1 col-sm-1 col-xs-12">就讀班級 :</label>
        	                <div class="col-md-2 col-sm-2">
                	        	<select id="search_class" name="search_class" class="form-control"  onChange="catch_student()" >
						<option value="0">請選擇班級</option>
	  	                        	<option value="普通班">普通班</option>
		          	                <option value="資源班">資源班</option>
                		  	        <option value="特教班">特教班</option>
	  	                        </select>
            	                </div>

				<label class="control-label col-md-1 col-sm-1 col-xs-12">學生姓名：</label>
                                <div class="col-md-2 col-sm-2">
                                        <select id="student" name="search_student" class="form-control" required>
                                                <option value="0">請選擇學生</option>
                                        </select>
                                </div>

				<button type="submit" id="btn_submit" class="btn btn-success">搜尋</button>
			</div>
                </form>


                <!-- title bar-->

                <!-- Question List Table -->
                <table id="q_list" class="table table-striped table-bordered">
		<?php
			include("connects.php");	
			include("CalculateScore.php");
			if(isset($_POST['search_student'])){
				$sql_max = "select Max(No) as max_count from ExamResult";
				$result = mysqli_fetch_object($db->query($sql_max));
		                $max_number = $result->max_count;
				$count_max = 0;
				$No_Array = array();
				$ExamNo_Array = array();
				$ExamTime_Array = array();
				$ExamTitle_Array = array();
                                $Teacher_Array = array();
				$Name_Array = array();
				$point_Array = array();
				$state_Array = array();
				$button_state_Array = array();
				$ShowName_Array = array();
				
				if(strpos($_POST['search_student'],'0') === false){					
 	                        	$search_student = $_POST['search_student'];
					$sql_student = "select * from UserList where StudentNumber = '".$search_student."'"; 
					$result_student  = mysqli_fetch_object($db->query($sql_student));
					$AnswerStudent = $result_student->id;
					for($index = 1, $count_index = 1; $index <= $max_number ; $index++){
						$ShowName_Array[$count_index] = $result_student->Name;
						$sql_student_exam = "select * from ExamResult WHERE WhosAnswer ='".$AnswerStudent."' AND No = '".$index."'";
						$result2 = mysqli_fetch_object($db->query($sql_student_exam));
						if(!empty($result2->Answer)){
							if(!is_null($result2->Answer)){
								$No_Array[$count_index] = $result2->No;								
								$ExamTime_Array[$count_index] = $result2->ExamTime;
								$ExamNo_Array[$count_index] = $result2->ExamNo;								
								$Name_Array[$count_index] = $result2->WhosAnswer;								
								$point_Array[$count_index] = calScore($result2->No,$result2->ExamNo);

								if($point_Array[$count_index] > 60){
									$state_Array[$count_index] = "bg-green";
									$button_state_Array[$count_index] = " btn-success btn-xs\">及格</button>";
								}
								else{
									$state_Array[$count_index] = "bg-red";
									$button_state_Array[$count_index] = " btn-danger btn-xs\">不及格</button>";
								}

								$sql_examno = "select * from ExamList where No = '".$ExamNo_Array[$count_index]."'";
								$result3 = mysqli_fetch_object($db->query($sql_examno));
								$ExamTitle_Array[$count_index] = $result3->ExamTitle;
								$Teacher_Array[$count_index] = $result3->Teacher;							

								$No_to_json = json_encode((array)$No_Array);
								$ShowName_to_json = json_encode((array)$ShowName_Array);
								$Name_to_json = json_encode((array)$Name_Array);
								$ExamTime_to_json=json_encode((array)$ExamTime_Array);
								$ExamNo_to_json=json_encode((array)$ExamNo_Array);
                                                                $ExamTitle_to_json=json_encode((array)$ExamTitle_Array);
                                                                $Teacher_to_json=json_encode((array)$Teacher_Array);
								$Point_to_json = json_encode((array)$point_Array);
								$State_to_json = json_encode((array)$state_Array);
								$Button_state_to_json = json_encode((array)$button_state_Array);
								
									
								$count_index++;
								$count_max = $count_index;
							}
						}						
					}
					
					if($count_max > 0){
						echo '<thead>';
							echo '<th>No</th>';
							echo '<th>學生姓名</th>';
							echo '<th>試卷名稱</th>';
	                        	                echo '<th>出題老師</th>';
							echo '<th>測驗時間</th>';
							echo '<th>成績</th>';
							echo '<th>及格狀態</th>';
							echo '<th>#edit</th>';
						echo '</thead>';
				
						echo '<tbody>';
							echo '<tr>';
								echo '<td>'.$No_Array[1].'</td>';
					                        echo '<td>'.$ShowName_Array[1].'</td>';
								echo '<td>'.$ExamTitle_Array[1].'</td>';
								echo '<td>'.$Teacher_Array[1].'</td>';
								echo '<td>'.$ExamTime_Array[1].'</td>';

								echo   '<td class="project_progress">';
				                                echo     '<div class="progress progress_sm">';
				                                if($point_Array[1] >= 60){$state= 'bg-green';}
				                                else {$state = 'bg-red';}
                                				echo       '<div class="progress-bar '.$state.'" role="progressbar" data-transitiongoal="'.$point_Array[1].'"></div>';
				                                echo     '</div>';
                                				echo     '<small>'.$point_Array[1].' Point.</small>';
				                                echo   '</td>';

								echo   '<td>';
				 			 	if ($point_Array[1] >=60){$button_state = ' btn-success btn-xs">及格</button>';}
				                                else {$button_state = ' btn-danger btn-xs">不及格</button>';}
				                                echo     '<button type="button" class="btn'.$button_state;
                                				echo   '</td>';
				                                echo   '<td>';
                                				         echo '<a href="'.'AnswerRecord.php?ExamResultNo='.$No_Array[1].'&WhosAnswer='.$Name_Array[1].'" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i>作答詳情</a>';
				                                echo    '</td>';
                                				echo '</tr>';
								

							echo '</tr>';
						echo '</tbody>';
					}
				}
			}
		?>
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
	    <script>
	    	function catch_student(){
			var catch_grade = document.getElementById("search_grade").value;
			var catch_class = document.getElementById("search_class").value;
			if((catch_grade!="") &&(catch_class!="")){
				$.ajax(
                                {
                                	type: "POST",
	                                url: "GetStudentData.php",
        	                        dataType:"json",
                	                data: {catch_grade : catch_grade,
					       catch_class : catch_class	
					},
                        	        success:function(msg)
                                	{
						var msg_length = msg.length;
                                                $('#student').empty();
                                                $('#student').append('<option value="0">請選擇學生</option>');
                                                for(var i = 0 ; i <  msg_length ; i++){
                                                        $('#student').append('<option value="'+msg[i]["StudentNumber"]+'">'+msg[i]["Name"]+'</option>');
                                                }

					}		
				})
			}				
			else if(catch_grade!=""){
				$.ajax(
                                {
                                        type: "POST",
                                        url: "GetStudentData.php",
                                        dataType:"json",
                                        data: {catch_grade : catch_grade},
                                        success:function(msg)
                                        {
						var msg_length = msg.length;
						$('#student').empty();
						$('#student').append('<option value="0">請選擇學生</option>');
						for(var i = 0 ; i <  msg_length ; i++){
							$('#student').append('<option value="'+msg[i]["StudentNumber"]+'">'+msg[i]["Name"]+'</option>');							
						}
                                        }
                                })
                        }
			else if(catch_class!=""){
				$.ajax(
                                {
                                        type: "POST",
                                        url: "GetStudentData.php",
                                        dataType:"json",
                                        data: {catch_class : catch_class},
                                        success:function(msg)
                                        {
						var msg_length = msg.length;
                                                $('#student').empty();
                                                $('#student').append('<option value="0">請選擇學生</option>');
                                                for(var i = 0 ; i <  msg_length ; i++){
                                                        $('#student').append('<option value="'+msg[i]["StudentNumber"]+'">'+msg[i]["Name"]+'</option>');
                                                }

                                        }
                                })
                        }

		}		
	</script>







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

	     <script type="text/javascript" class="init">
                $(document).ready
                (
                        function(){
                              var count_max = <?php echo "$count_max";?>;

                              if(count_max > 1){
                                     var No_fromPHP = <? echo $No_to_json ?>;
				     var ShowName_fromPHP=<? echo $ShowName_to_json ?>;
                                     var Name_fromPHP=<? echo $Name_to_json ?>;
                                     var ExamTime_fromPHP=<? echo $ExamTime_to_json ?>;
                                     var ExamNo_fromPHP=<? echo $ExamNo_to_json ?>;
                                     var ExamTitle_fromPHP=<? echo $ExamTitle_to_json ?>;
                                     var Teacher_fromPHP=<? echo $Teacher_to_json ?>;
				     var Point_fromPHP = <? echo $Point_to_json?>;
				     var State_fromPHP = <? echo $State_to_json?>;
				     var ButtonState_fromPHP = <? echo $Button_state_to_json?>;

                                     var t = $('#q_list').DataTable();



                              for (var i=2 ; i< <?php echo "$count_max";?> ; i++)
                              {
                                    t.row.add(
                                    [
                                    No_fromPHP[i],
                                    ShowName_fromPHP[i],
                                    ExamTitle_fromPHP[i],
                                    Teacher_fromPHP[i],
                                    ExamTime_fromPHP[i],			    
				    "<div class=\"progress progress_sm\"><div class=\"progress-bar "+State_fromPHP+" role=\"progressbar\" data-transitiongoal=\""+Point_fromPHP[i]+"\"></div></div><small>"+Point_fromPHP[i]+" Point.</small>",
				    "<button type=\"button\" class=\"btn"+ButtonState_fromPHP[i],
			            "<a href=\"AnswerRecord.php?ExamResultNo="+No_fromPHP[i]+"&WhosAnswer="+Name_fromPHP[i]+"\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-folder\"></i>作答詳情</a>",
                                    ]).draw(false);

                              }
                              }
                        }

                );
             </script>

  </body>
</html>
