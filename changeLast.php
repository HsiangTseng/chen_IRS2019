<?php
	include("connects.php");
	$Teacher_ID = $_POST['Teacher_ID'];
	$now = 0;

	$sql = "SELECT * FROM Now_state Where Teacher_ID ='$Teacher_ID'";
	if($stmt = $db->query($sql))
	{
		while($result = mysqli_fetch_object($stmt))
		{
			$now = $result->No;
		}
	}

	if($now > 1)
	{
		$sql = "UPDATE Now_state SET No=$now-1 WHERE Teacher_ID='$Teacher_ID'";
		$db->query($sql);

		//update timestamp
		$date = date('H:i:s');
		$sql = "UPDATE State SET Time_stamp = '$date'";
		$db->query($sql);
		//restart the quiz time , if timeout -> auto change to next quiz
		//$sql = "UPDATE Now_state SET Temp=5";
		//$db->query($sql);
	}

	$db->close();
	header ('location: home.php');

?>
