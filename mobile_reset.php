<?php
	include("connects.php");

	 $temp = "SELECT * FROM temp_for_state";
         $sql = "SELECT * FROM Now_state";
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
									
	$sql = "SELECT * FROM Now_state";
	$stmt = $db->query($sql);
	$result = mysqli_fetch_object($stmt);
	$now = $result->No;

	$temp = "SELECT * FROM temp_for_state";
	$stmt = $db->query($temp);
	$result = mysqli_fetch_object($stmt);
	$last = $result->No_temp;
	echo $last;
	
	$last = "UPDATE temp_for_state SET No_temp= $now";
	$db->query($last);
	$db->close();

?>
