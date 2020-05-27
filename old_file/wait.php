<!DOCTYPE html>
<?php 
	session_start(); 
?>
<?php
	include("connects.php");
	$sql = "SELECT * FROM `Now_state`";
	$temp = "SELECT * FROM `temp_for_state`";
	$now = 0;
	$last = 0;
	if($stmt = $db->query($sql)){
		while($result = mysqli_fetch_object($stmt)){
			$now = $result->No;
			$stmt = $db->query($temp);
			$result = mysqli_fetch_object($stmt);
			$last = $result->No_temp;
			
		}
	}	
?>
<html lang="en" style="height:100%">
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
		<link href="../vendors/font-awesome/css/fontawesome-all.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
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

		<!-- Custom Theme Style -->
		<link href="../build/css/custom.min.css" rel="stylesheet">						
	</head>
	<body class="nav-md" style="height:100%">
		<h1>等待中</h1>
		
		<?
			include("connects.php");
			
			$date=date('Y-m-d H:i:s');
			$sql_get_UUID_NoExam = "select * from Now_state";	

			if($stmt = $db->query($sql_get_UUID_NoExam)){
				while($result = mysqli_fetch_object($stmt)){			
					$ExamNo = $result->ExamNumber;
					$UUID = $result->UUID;	
				}
			}

			//$WhoAnswer = $_POST['username'];	
			$WhosAnswer = "A1234";

			$Answer_count_sql = "Select count(Answer) AS Answer_count from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
			$stmt1 = $db->query($Answer_count_sql);
			$result = mysqli_fetch_object($stmt1);
			$Answer_number = $result->Answer_count;
			
			if($Answer_number ==0 ){
				//抓取最大之No+1
				$No_sql = "select MAX(No) AS MAXNO from ExamResult";
				$result = mysqli_fetch_object($db->query($No_sql));
				$No = $result->MAXNO;
				$No = $No+1;
				
				
				//抓取有幾題題目	
				$sql_catch = "select question_list from ExamList where No ='".$ExamNo."'";
				$result = mysqli_fetch_object($db->query($Answer_sql));
				$examstr = $result->question_list;
				$qlist = array();
				$qlist = mb_split(",",$examstr);
				echo count($qlist);
				$exam_num = count($qlist);
				$Answer = '';
				for( $i = 0 ; $i < exam_num ; $i++){
					if($i != 0){
						$Answer = $Answer.'-N';
					}
					else{
						$Answer = $Answer.'N';
					}
				}
				$inser_sql = "insert into ExamResult (No,ExamNo,UUID,Answer,WhosAnswer,ExamTime) Values ('".$No."','".$ExamNo."','".$UUID."','".$Answer_get."','".$WhosAnswer."','".$date."')";
				$db->query($inser_sql);
			}
		?>
		
		<script>
			var get_last = <?php echo "$last";?>;
			var get_now =  <?php echo "$now";?>;
			
			function set_question(){
				if(get_last != get_now){										
					//跳至下一題
					$.ajax(
					{
						type:"POST",
						url:"client_show.php"															
					}
					).done(function(msg){});
					window.location.reload();															
				}
				$.ajax(
				{
					type:"POST",
					url:"mobile_reset.php",
					success:function(data){
						get_last = data;
					}
				});
			}
			setInterval(set_question,1000);
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

		<!-- Custom Theme Scripts -->
		<script src="../build/js/custom.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>
	</body>
</html>