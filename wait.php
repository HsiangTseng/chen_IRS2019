<!DOCTYPE html>
<?php
	session_start();
	if($_SESSION['username'] == null)
        {
                header ('location: IRS_Login.php');
                exit;
        }
        if ($_SESSION['type']!='S')
        {
            header ('location: IRS_Login.php');
            exit;
        }

	$WhosAnswer = $_SESSION['username'];
?>
<?php
	include("connects.php");
	$sql_user = "select * from UserList where id='".$WhosAnswer."'";
	$stmt2 = $db->query($sql_user);
	$result2 = mysqli_fetch_object($stmt2);
	$userStudentNumber = $result2->StudentNumber;
	$now = 0;
        $last = 0;
	$UUID_now = "";
	$UUID_last ="";
	$Teacher_ID = "";


	$sql_catch_count = "select count(Teacher_ID) as count from ClassList where StudentNumberList like '%".$userStudentNumber."%'";
	$result_count = mysqli_fetch_object($db->query($sql_catch_count));
	$catch_count = $result_count->count;

	if($catch_count > 0){
		$sql_catch_teacher = "select * from ClassList where StudentNumberList like '%".$userStudentNumber."%'";
		if($stmt3 = $db->query($sql_catch_teacher))
		{
				while($result3 = mysqli_fetch_object($stmt3))
				{
					$Studentlist_array = array();
					$temp_list = $result3->StudentNumberList;
					$Studentlist_array = explode("-",$temp_list);
					foreach ($Studentlist_array as $key => $value) {
						if($Studentlist_array[$key]==$userStudentNumber)
						{
							$Teacher_ID = $result3->Teacher_ID;
							$_SESSION['Teacher_ID'] =  $Teacher_ID;
							//echo $Teacher_ID;
							//print_r($Studentlist_array);
						}
					}
				}
		}
		/*$stmt3 = $db->query($sql_catch_teacher);
    $result3 = mysqli_fetch_object($stmt3);
		$Teacher_ID = $result3->Teacher_ID;
		$_SESSION['Teacher_ID'] =  $Teacher_ID;*/


		$sql = "SELECT * FROM Now_state where Teacher_ID='".$Teacher_ID."'";
		$temp = "SELECT * FROM temp_for_state where Teacher_ID='".$Teacher_ID."'";
		$now = 0;
		$last = 0;
		if($stmt = $db->query($sql)){
			while($result = mysqli_fetch_object($stmt)){
				$now = $result->No;
				$UUID_now = $result->UUID;
				$stmt = $db->query($temp);
				$result = mysqli_fetch_object($stmt);
				$last = $result->No_temp;
				$UUID_last = $result->UUID;

			}
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
	<body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"> <span>AAC使用者語言測驗</span></a>
            </div>

            <div class="clearfix"></div>


            <br />



          </div>
        </div>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                  </div>
                  <div class="x_content">
                      <h1>等待進入考試中,請稍後</h1>
			<?php
				include("connects.php");
				$sql = "select * from UserList where id ='".$_SESSION['username']."'";
				if($stmt = $db->query($sql)){
					while($result = mysqli_fetch_object($stmt)){
						$id = $result->id;
						$Name = $result->Name;
						$School = $result->School;
						$Grade = $result->Grade;
						$Class = $result->Class;
					}
				}

				echo "<div class='col-md-12 col-sm-12 col-xs-12 profile_details'>";
					echo "<div class='well profile_view'>";
						echo "<div class='col-sm-12'>";
							echo "<h4 class='brief'>個人資料</h4>";
							echo "<div class='left col-xs-7'>";
								echo "<h1><strong>".$Name."</strong></h1>";
								echo "<p><strong>學校: </strong> ".$School."</p>";
								echo "<p><i class='fa fa-building'></i><strong>學號： </strong>".$id."</p>";
								echo "<p><i class='fa fa-building'></i><strong>班級： </strong>".$Grade."年".$Class."</p>";
							echo "</div>";
							echo "<div class='right col-xs-5 text-center'>";
								echo "<img src='images/user.png' alt='' class='img-circle img-responsive'>";
							echo "</div>";
						echo "</div>";
						echo "<div class='col-xs-12 bottom text-center'>";
							echo "<div class='col-xs-12 col-sm-6 emphasis'>";
								echo "<p class='ratings'>";
									echo "<a></a>";
								echo "</p>";
							echo "</div>";
						echo "</div>";
					echo "</div>";
				echo "</div>";
			?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
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

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
		<script>
			 var get_last = <?php echo "$last";?>;
                                var get_now =  <?php echo "$now";?>;
                                var get_last_UUID = "<?php echo $UUID_last;?>";
                                var get_now_UUID = "<?php echo $UUID_now;?>";
                                var get_teacher = "<?php echo $Teacher_ID;?>";

			function set_status(){
					if(get_now_UUID.trim()!=get_last_UUID.trim()){
						$.ajax(
						{
							type:"POST",
							url:"client_wait_reset.php"
						}
						).done(function(msg){});
					}
					if(get_last != 0){
						//跳至下一題
						$.ajax(
						{
							type:"POST",
							url:"mobile_reset.php"
						}
						).done(function(msg){});
						document.location.href="setstudentdata.php";
					}
					$.ajax(
                                        {
                                                type:"POST",
                                                url:"CatchTeacher.php",
                                                success:function(data){
                                                        get_teacher = data;
                                                }
                                        });
					$.ajax(
					{
						type:"POST",
						url:"client_wait_reset.php",
						success:function(data){
							get_last_UUID = data;
						}
					});
					$.ajax(
					{
						type:"POST",
						url:"mobile_reset.php",
						success:function(data){
							get_last = data;
						}
					});
			}
			setInterval(set_status,1000);
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
