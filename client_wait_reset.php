<?php
	include("connects.php");
	$sql = "SELECT * FROM Now_state";
	$temp = "SELECT * FROM temp_for_state";
//	$now = 0;
//	$UUID_now = '';
	if($stmt = $db->query($sql))
	{
		while($result = mysqli_fetch_object($stmt))
		{
//			$now = $result->No;
			$UUID_now = $result->UUID;
			$result = mysqli_fetch_object($db->query($temp));
			$UUID_last = $result->UUID;
		}
	}
//	$sql = "SELECT * FROM Now_State";
	$result = mysqli_fetch_object($db->query($sql));
	$UUID_now = $result->UUID;


	$result = mysqli_fetch_object($db->query($temp));
	$last_UUID = $result->UUID;
	echo $last_UUID;

	$last = "UPDATE temp_for_state SET UUID='".$UUID_now."'";
	$db->query($last);
	$db->close();
?>
