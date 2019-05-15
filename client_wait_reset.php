<?php
	include("connects.php");
	$sql = "SELECT * FROM Now_state";
	$now = 0;
	$UUID_now = '';
	if($stmt = $db->query($sql))
	{
		while($result = mysqli_fetch_object($stmt))
		{
			$now = $result->No;
			$UUID_now = $result->UUID;
		}
	}
	$last = "UPDATE temp_for_state SET No_temp= '".$now."', UUID = '".$UUID_now."'";
	$db->query($last);
	$db->close();
?>
