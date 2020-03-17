<?php
	include("connects.php");
	
	if(isset($_SESSION['Teacher_ID'])){
		$Teacher_ID = $_SESSION['Teacher_ID'];
		$temp = "SELECT * FROM temp_for_state where Teacher_ID = '".$Teacher_ID."'";
        	$sql = "SELECT * FROM Now_state where Teacher_ID = '".$Teacher_ID."'";
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
									
		$sql = "SELECT * FROM Now_state where Teacher_ID = '".$Teacher_ID."'";
		$stmt = $db->query($sql);
		$result = mysqli_fetch_object($stmt);
		$now = $result->No;

		$temp = "SELECT * FROM temp_for_state where Teacher_ID = '".$Teacher_ID."'";
		$stmt = $db->query($temp);
		$result = mysqli_fetch_object($stmt);
		$last = $result->No_temp;
		echo $last;
	
		$last = "UPDATE temp_for_state SET No_temp= $now where Teacher_ID = '".$Teacher_ID."'";
		$db->query($last);
		$db->close();
	}
?>
