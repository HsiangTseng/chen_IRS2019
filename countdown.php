<?php
	include("connects.php");
	$time = 999;

	$sql = "SELECT * FROM Now_state";
	// Get the quiz limit time;
	if($stmt = $db->query($sql))
	{
		while($result = mysqli_fetch_object($stmt))
		{
			$time = $result->Temp;
		}
	}

	//let the quiz limit time-1
	$sql = "UPDATE Now_state SET Temp=$time-1";
	$db->query($sql);
	$db->close();
?>
