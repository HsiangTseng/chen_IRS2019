<!DOCTYPE html>
<html lang="en">
          <head>
                       <!-- Meta, title, CSS, favicons, etc.--> 
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
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fas fa-edit"></i></div>
                  <div class="count">
                  <?php
                  include("connects.php");
                  $sql = "SELECT * FROM Now_state";
                  $result = mysqli_fetch_object($db->query($sql));
                  echo $result->No;
                  ?>
                  </div>
                  <h3>Question</h3>
                </div>
            </div>

            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="far fa-calendar-alt"></i></div>
                  <div class="count">
                    <?php
                    date_default_timezone_set("Asia/Taipei");
                    $date = date('Y/m/d');
                    echo $date;  
                    ?>
                  </div>
                  <h3>Date</h3>
                </div>
            </div>

            <script>
              function updateDiv()
              { 
                $( "#time_block" ).load(window.location.href + " #time_block" );
              }
              setInterval(updateDiv,1000);
            </script>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fas fa-clock"></i></div>
                  <div class="count" id="time_block">
                  <?php
                  $time = date('H:i:s');
                  echo $time;  
                  ?>
                  </div>
                  <h3>Time</h3>
                </div>
            </div>

            

            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"><i class="fas fa-user-edit"></i></div>
                  <div class="count">
                  5
                  </div>
                  <h3>Students</h3>
                </div>
            </div>

          </div>
          <!-- /top tiles -->
		  
	   	    
            
            <!-- Question -->
            <div class="x_panel">
                <!-- Question content-->
                <div class="x_content">
                      <div class="bs-example" data-example-id="simple-jumbotron">
                        <div class="jumbotron">
                            <h1>								
				<?php
					include("connects.php");
					$sql = "SELECT * FROM `Now_state`";
					$temp = "SELECT * FROM `temp_for_state`";
                                    	$now = 0;
					$last = 0;
                                    if($stmt = $db->query($sql))
                                    {
                                        while($result = mysqli_fetch_object($stmt))
                                        {
                                            $now = $result->No;
											
											$stmt = $db->query($temp);
											$result = mysqli_fetch_object($stmt);
											$last = $result->No_temp;
											
                                        }
                                    }
				    
				    $sql = "SELECT * FROM QuestionList WHERE No like '$now' AND QA like 'A1'";
                                    $result = mysqli_fetch_object($db->query($sql));
									echo "<input type='button' onclick=reply_a() value='[A]".$result->Content."'>";			
									echo '<br>';
									echo '<br>';
									
                                    $sql = "SELECT * FROM QuestionList WHERE No like '$now' AND QA like 'A2'";
                                    $result = mysqli_fetch_object($db->query($sql));
									echo "<input type='button' onclick=reply_b() value='[B]".$result->Content."'>";                                    
									echo '<br>';
									echo '<br>';
									
                                    $sql = "SELECT * FROM QuestionList WHERE No like '$now' AND QA like 'A3'";
                                    $result = mysqli_fetch_object($db->query($sql));
									echo "<input type='button' onclick=reply_c() value='[C]".$result->Content."'>";                                   
									echo '<br>';
									echo '<br>';
									
                                    $sql = "SELECT * FROM QuestionList WHERE No like '$now' AND QA like 'A4'";
                                    $result = mysqli_fetch_object($db->query($sql));
									echo "<input type='button' onclick=reply_d() value='[D]".$result->Content."'>";                                    
									echo '<br>';
				?>
				<script>
				var get_last = <?php echo $last?>;
				var get_now = <?php echo $now?>;									
					function set_question()
						{ 
							
							//alert(get_last);
							
							if(get_last != get_now){
								$.ajax(
										{
											type:"POST",
											url:"mobile_reset.php",
										}
								).done(function(msg){});
								window.location.reload();							
							}
							
							$.ajax(
								{
								url:'mobile_reset.php',
								type:'POST',
								success: function(data){
									get_last = data;
								}
							});						
						}
					setInterval(set_question,1000);
				</script>
								
								
                            </h1>
                        </div>
                      </div>
                </div>
                <!-- Question content-->
            </div>
	
            

        <!-- page content################################# -->

        <!-- footer content -->
        <!--footer>
        <!--/footer>
        <!-- /footer content -->


      </div>
    </div>
	
			
			
			
			<script>
				function reply_a(){
				
				}
				function reply_b(){
				
				}
				function reply_c(){
				
				}
				function reply_d(){
				
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

            <!-- Custom Theme Scripts -->
            <script src="../build/js/custom.min.js"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/dojo/1.13.0/dojo/dojo.js"></script>
  </body>
</html>
