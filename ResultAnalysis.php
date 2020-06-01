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

		<style type="text/css">
			table{
				border-collapse:collapse;
				border:1px solid black;
			}
			td{
				border:1px solid black;
			}
		</style>
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
					<h1><b>考試分析</b></h1>
					<div class="clearfix"></div>
				</div>
				<form class="form-horizontal form-label-left input_mask" method="POST" action="ResultAnalysisList.php">
					<div>
						<label class="control-label col-md-1 col-sm-1 col-xs-12">試卷名稱 :</label>
						<div class="col-md-2 col-sm-2">
							<select id="search_exam" name="search_exam" class="form-control" onChange="catch_exam()">
							<option value="0">請選擇試卷</option>
								<?php
									include("connects.php");

									$sql_str = "select * from ExamList";

									$stmt = $db->query($sql_str);

									while($result = mysqli_fetch_object($stmt)){
									echo "<option value='".$result->No."'>".$result->ExamTitle."</option>";
								}
								?>
							</select>
						</div>

						<label class="control-label col-md-1 col-sm-1 col-xs-12">考試日期 :</label>
						<div class="col-md-2 col-sm-2">
							<select id="search_date" name="search_date" class="form-control"  onChange="catch_date()" >
								<option value="0">請選擇日期</option>
							</select>
						</div>

						<label class="control-label col-md-1 col-sm-1 col-xs-12">第幾次考試 :</label>
						<div class="col-md-2 col-sm-2">
							<select id="search_UUID" name="search_UUID" class="form-control"  onChange="catch_examnum()" >
								<option value="0">請選擇第幾次考試</option>
							</select>
						</div>
						<input type="button" id="btn_check_all" class="btn btn-success" onclick="check_all()" disabled value="全選">
						<input type="button" id="btn_clear_all" class="btn btn-success" onclick="clear_all()" disabled value="全部取消">

						<label class="col-md-12 col-sm-12 col-xs-12">考試學生 :</label>
						<table class="col-md-12 col-sm-12" id="exam_student" name="exam_student">

						</table>

					</div>
				</form>
				
				<form class="form-horizontal form-label-left input_mask" method="POST" action="ResultAnalysisList.php">
					<div>
						<label class="col-md-12 col-sm-12 col-xs-12">選擇的學生 :</label>
						<div class="col-md-12 col-sm-12" id="student_chosen" name="student_chosen">

						</div>
						<button type="submit" id="btn_submit" class="btn btn-success" disabled>搜尋</button>
					</div>
				</form>
				<!-- title bar-->

				<!-- page content################################# -->

				<!-- footer content -->
				<!--footer>
				<!--/footer>
				<!-- /footer content -->

			</div>
		</div>
		<script>
			var counter_student = 0;
			var exam_num_array = new Array();
			var count_isame_num = 0;
			
			function catch_exam(){
				counter_student = 0;
				var exam_no = document.getElementById("search_exam").value;
				var exam_time = document.getElementById("search_date").value;
				var exam_num = document.getElementById("search_UUID").value;
				if(exam_no!=""){
					$.ajax({
						type: "POST",
						url: "GetExamData.php",
						dataType:"json",
						data: {
							exam_no : exam_no
						},
						success:function(msg)
						{
							var msg_length = msg.length;
							$('#search_date').empty();
							$('#search_UUID').empty();
							
							$('#exam_student').empty();						
							$('#student_chosen').empty();								

							$('#search_UUID').append('<option value="0">請選擇第幾次考試</option>');
							$('#search_date').append('<option value="0">請選擇考試日期</option>');
							for(var i = 0 ; i < msg_length ; i++){
								if(i > 0){
									if(msg[i]["ExamTime"]!=msg[i-1]["ExamTime"]){
										$('#search_date').append('<option value="'+msg[i]["ExamTime"]+'">'+msg[i]["ExamTime"]+'</option>');
									}
								}
								else{
									$('#search_date').append('<option value="'+msg[i]["ExamTime"]+'">'+msg[i]["ExamTime"]+'</option>');
								}
							}

							msg = msg.sort(function(a,b){
								return a.WhosAnswer > b.WhosAnswer ? 1 : -1;
							});
							counter = 0;
							var textContent = "";
							for(var i = 0 ; i <  msg_length ; i++){
								if(i > 0){
									if(msg[i]["WhosAnswer"] != msg[i-1]["WhosAnswer"]){
										if(counter % 6 == 0){
											textContent	+= "<tr>";
										}
										newid = 'chosen'+ exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];
										newid2 = exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];										
										if(document.getElementById(newid)){																					
											if(document.getElementById(newid).checked == true){
												textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' checked='true' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
											else{
												textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
										}
										else{
											textContent	+= "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
										}	
										if(counter % 6 == 5){
											textContent	+= "</tr>";
										}
										else if(i == (msg_length-1)){
											textContent	+= "</tr>";
										}
										counter = counter + 1;
									}
								}
								else{
									if(counter % 6 == 0){
										textContent	+= "<tr>";
									}
									
									newid = 'chosen'+ exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];
									newid2 = exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];										
									if(document.getElementById(newid)){																					
										if(document.getElementById(newid).checked == true){
											textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' checked='true' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
										}
										else{
											textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
										}
									}
									else{
										textContent	+= "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
									}
									
									if(counter % 6 == 5){
										textContent	+= "</tr>";
									}
									else if(i == (msg_length-1)){
										textContent	+= "</tr>";
									}
									counter = counter + 1;
								}
							}
							exam_student.innerHTML += textContent;
						}
					})
				}
				document.getElementById("btn_submit").disabled = true;
				document.getElementById("btn_check_all").disabled = true;
				document.getElementById("btn_clear_all").disabled = true;
			}

			function catch_date(){
				var exam_no = document.getElementById("search_exam").value;
				var exam_time = document.getElementById("search_date").value;
				var exam_num = document.getElementById("search_UUID").value;

				if(exam_time!=""){
					$.ajax({
					type: "POST",
					url: "GetExamData.php",
					dataType:"json",
					data: {
					exam_no : exam_no,
					exam_time : exam_time
					},
						success:function(msg)
						{
							$('#search_UUID').empty();
							$('#search_UUID').append('<option value="0">請選擇第幾次考試</option>');
							$('#exam_student').empty();
							counter_UUID = 1;

							for(var i = 0 ; i < msg.length ; i++){
								count_isame = 0;
								for(var j = 0; j < i ;j++){
									if(i > 0){
										if(msg[i]["UUID"] != msg[j]["UUID"]){
											count_isame++;
											if(count_isame == i){
												$('#search_UUID').append('<option value="'+msg[i]["UUID"]+'">第'+counter_UUID+'次考試</option>');
												exam_num_array[counter_UUID]=msg[i]["UUID"];
												counter_UUID++;
											}
										}
									}

									else{
										$('#search_UUID').append('<option value="'+msg[i]["UUID"]+'">第'+counter_UUID+'次考試</option>');
										exam_num_array[counter_UUID]=msg[i]["UUID"];
										counter_UUID++;
									}
								}								
								
								if(i == 0){
									$('#search_UUID').append('<option value="'+msg[i]["UUID"]+'">第'+counter_UUID+'次考試</option>');
									exam_num_array[counter_UUID]=msg[i]["UUID"];
									counter_UUID++;
								}
							}
							count_isame_num = counter_UUID;
							
							msg = msg.sort(function(a,b){
								return a.WhosAnswer > b.WhosAnswer ? 1 : -1;
							});


							var msg_length = msg.length;
							var counter = 0;
							var textContent = "";
							for(var i = 0 ; i < msg_length ; i++){
								if(i > 0){
									if(msg[i]["WhosAnswer"]!=msg[i-1]["WhosAnswer"]){
										if(counter % 6 == 0){
											textContent	+= "<tr>";
										}
										
										newid = 'chosen'+ exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];
										newid2 = exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];										
										if(document.getElementById(newid)){																					
											if(document.getElementById(newid).checked == true){
												textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' checked='true' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
											else{
												textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
										}
										else{
											textContent	+= "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
										}	
										
										if(counter % 6 == 5){
											textContent	+= "</tr>";
										}
										else if(i == (msg_length-1)){
											textContent	+= "</tr>";
										}
										counter = counter + 1;
									}
								}
								else{
								if(counter % 6 == 0){
									textContent	+= "<tr>";
								}
								newid = 'chosen'+ exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];
								newid2 = exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];										
								if(document.getElementById(newid)){																					
									if(document.getElementById(newid).checked == true){
										textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' checked='true' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
									}
									else{
										textContent     += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
									}
								}
								else{
									textContent	+= "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' disabled><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
								}								
								if(counter % 6 == 5){
									textContent	+= "</tr>";
								}
								else if(i == (msg_length-1)){
									textContent	+= "</tr>";
								}
								counter = counter + 1;
								}
							}
							exam_student.innerHTML += textContent;
						}
					})
				}
				if(counter_student == 0){
					document.getElementById("btn_submit").disabled = true;
				}
				else{
					document.getElementById("btn_submit").disabled = false;
				}
				document.getElementById("btn_check_all").disabled = true;
				document.getElementById("btn_clear_all").disabled = true;
			}

			function catch_examnum(){
			var exam_no = document.getElementById("search_exam").value;
			var exam_time = document.getElementById("search_date").value;
			var exam_num = document.getElementById("search_UUID").value;
			if(counter_student == 0){
                                document.getElementById("btn_submit").disabled = true;
                        }
                        else{
                                document.getElementById("btn_submit").disabled = false;
                        }

			
			if(exam_num!=""){
				$.ajax({
					type: "POST",
					url: "GetExamData.php",
					dataType:"json",
					data: {
						exam_no : exam_no,
						exam_time: exam_time,
						exam_num : exam_num
					},
					success:function(msg)
					{
						if(exam_num != "0"){
							document.getElementById("btn_check_all").disabled = false;
							document.getElementById("btn_clear_all").disabled = false;
						}
						else{
							document.getElementById("btn_check_all").disabled = true;
							document.getElementById("btn_clear_all").disabled = true;
							document.getElementById("btn_submit").disabled = true;
						}
						$('#exam_student').empty();
						var msg_length = msg.length;

						msg = msg.sort(function(a,b){
							return a.WhosAnswer > b.WhosAnswer ? 1 : -1;
						});
						counter = 0;
						var textContent = "";
						if(exam_num !="0"){
							for(var i = 0 ; i <  msg_length ; i++){
								if(i > 0){
									if(msg[i]["WhosAnswer"] != msg[i-1]["WhosAnswer"]){
										if(counter % 6 == 0){
											textContent	+= "<tr>";
										}
										newid = 'chosen'+ exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];
										newid2 = exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];										
										if(document.getElementById(newid)){																					
											if(document.getElementById(newid).checked == true){
												textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' checked='true'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
											else{
												textContent     += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
										}
										else{
											textContent	+= "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
										}
										if(counter % 6 == 5){
											textContent	+= "</tr>";
										}
										else if(i == (msg_length-1)){
											textContent	+= "</tr>";
										}
										counter = counter + 1;
									}
								}
								else{
									if(counter % 6 == 0){
										textContent	+= "<tr>";
									}
									newid = 'chosen'+ exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];
										newid2 = exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];										
										if(document.getElementById(newid)){																					
											if(document.getElementById(newid).checked == true){
												textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' checked='true'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
											else{
												textContent     += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
										}
										else{
											textContent	+= "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
										}
									if(counter % 6 == 5){
										textContent	+= "</tr>";
									}
									else if(i == (msg_length-1)){
										textContent	+= "</tr>";
									}
									counter = counter + 1;
								}
							}
						}
						else{
							for(var i = 0 ; i <  msg_length ; i++){
								if(i > 0){
									if(msg[i]["WhosAnswer"] != msg[i-1]["WhosAnswer"]){
										if(counter % 6 == 0){
											textContent     += "<tr>";
										}
										newid = 'chosen'+ exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];
										newid2 = exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];										
										if(document.getElementById(newid)){																					
											if(document.getElementById(newid).checked == true){
												textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' checked='true'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
											else{
												textContent     += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
										}
										else{
											textContent	+= "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
										}
										if(counter % 6 == 5){
											textContent     += "</tr>";
										}
										else if(i == (msg_length-1)){
											textContent     += "</tr>";
										}
										counter = counter + 1;
									}
								}
								else{
									if(counter % 6 == 0){
										textContent     += "<tr>";
									}
									newid = 'chosen'+ exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];
										newid2 = exam_time + ' ' + exam_num + ' '  + msg[i]["WhosAnswer"];										
										if(document.getElementById(newid)){																					
											if(document.getElementById(newid).checked == true){
												textContent += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)' checked='true'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
											else{
												textContent     += "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
											}
										}
										else{
											textContent	+= "<td><input type='checkbox' id='"+newid2+"' placeholder='"+msg[i]['WhosAnswer_Name']+"' name='student[]' value='"+msg[i]['No']+"' onclick='choose_student(this.id,this.placeholder,this.value)'><label for='"+newid2+"'>"+msg[i]['WhosAnswer_Name']+"</label></td>";
										}
									if(counter % 6 == 5){
										textContent     += "</tr>";
									}
									else if(i == (msg_length-1)){
										textContent     += "</tr>";
									}
									counter = counter + 1;
								}
							}
						}

						exam_student.innerHTML += textContent;
					}
				})
			}
			}


			function choose_student(id,placeholder,value){
				var exam_time = document.getElementById("search_date").value;
				var exam_num = document.getElementById("search_UUID").value;
				if (document.getElementById(id).checked){
					counter_student++;
					var div_form = document.createElement("div");
					div_form.setAttribute("class","col-md-3 col-sm-3 col-xs-3");
					newid = 'divchosen' + id;
					div_form.setAttribute("id",newid);				
					var id_array = new Array();
					id_array = newid.split(' ');
					for(var i = 1 ; i < count_isame_num ; i++){
						if(id_array[1] == exam_num_array[i]){
							var inner = '<input type="checkbox" id="chosen'+id+'" value="'+value+'" onclick="choose_student(this.id,this.placeholder,this.value)" name="chosen_student[]" placeholder="'+placeholder+'" checked="true"><label for="chosen'+ id +'">'+exam_time+' 第'+ i +'次考試 '+placeholder+'</label>';
						}
					}
					div_form.innerHTML = inner;
					document.getElementById("student_chosen").appendChild(div_form);
				}
				else{
					if(id.indexOf("chosen") >= 0){
						id = 'div' + id;
						document.getElementById(id).remove();
						id = id.substring(9,id.length);
						if(document.getElementById(id)){
                            document.getElementById(id).checked=false;
						}
					}	
					else{
						id = 'divchosen' + id;
						document.getElementById(id).remove();
					}
					counter_student--;
				}
				if(counter_student > 0){
					document.getElementById("btn_submit").disabled = false;
				}
				else{
					document.getElementById("btn_submit").disabled = true;
				}
			}

			function check_all(){
				var exam_time = document.getElementById("search_date").value;
                                var exam_num = document.getElementById("search_UUID").value;
				var counter_check = 0;
				checkboxes = document.getElementsByName('student[]');
				for(var i = 0 ; i< checkboxes.length ; i++){					
					if(checkboxes[i].checked == false){
						checkboxes[i].checked = true;
						counter_check++;
						var div_form = document.createElement("div");
		                                div_form.setAttribute("class","col-md-3 col-sm-3 col-xs-3");
                                	        newid = 'divchosen' + checkboxes[i].id;
						div_form.setAttribute("id",newid);
						var id_array = new Array();
		                                id_array = newid.split(' ');
                		                for(var j = 1 ; j < count_isame_num ; j++){
                                		        if(id_array[1] == exam_num_array[j]){
                                                	        var inner = '<input type="checkbox" id="chosen'+checkboxes[i].id+'" value="'+checkboxes[i].value+'" onclick="choose_student(this.id,this.placeholder,this.value)" name="chosen_student[]" placeholder="'+checkboxes[i].placeholder+'" checked="true"><label for="chosen'+ checkboxes[i].id +'">'+exam_time+' 第'+ j +'次考試 '+checkboxes[i].placeholder+'</label>';
		                                        }
                		                }
                                		div_form.innerHTML = inner;
		                                document.getElementById("student_chosen").appendChild(div_form);
					}
				}
				
				counter_student += counter_check;
				if(counter_student > 0){
					document.getElementById("btn_submit").disabled = false;
				}
				else{
					document.getElementById("btn_submit").disabled = true;
				}
			}
			function clear_all(){
				var exam_time = document.getElementById("search_date").value;
                                var exam_num = document.getElementById("search_UUID").value;
                                var counter_check = 0;
				checkboxes = document.getElementsByName('student[]');
				for(var i = 0 ; i< checkboxes.length ; i++){
					if(checkboxes[i].checked == true){
						checkboxes[i].checked = false;
						counter_check++;
						if(checkboxes[i].id.indexOf("chosen") >= 0){
							newid = 'div' + checkboxes[i].id;
							document.getElementById(newid).remove();
							newid = newid.substring(9,newid.length);
							if(document.getElementById(newid)){
					                        document.getElementById(newid).checked=false;
							}
						}	
						else{
							newid = 'divchosen' + checkboxes[i].id;
							document.getElementById(newid).remove();
						}
					}
				}			
					counter_student -= counter_check;
				if(counter_student > 0){
					document.getElementById("btn_submit").disabled = false;
				}
				else{
					document.getElementById("btn_submit").disabled = true;
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
	</body>
</html>
