<?php
	session_start();
	include("connects.php");


	if(isset($_SESSION['Teacher_ID'])){
		$Teacher_ID = $_SESSION['Teacher_ID'];
		$sql = "SELECT * FROM Now_state where Teacher_ID = '".$Teacher_ID."'";
		$temp = "SELECT * FROM temp_for_state where Teacher_ID = '".$Teacher_ID."'";
		if($stmt = $db->query($sql))
		{
			while($result = mysqli_fetch_object($stmt))
			{
				$UUID_now = $result->UUID;
				$result = mysqli_fetch_object($db->query($temp));
				$UUID_last = $result->UUID;
			}
		}
		$result = mysqli_fetch_object($db->query($sql));
		$UUID_now = $result->UUID;


		$result = mysqli_fetch_object($db->query($temp));
		$last_UUID = $result->UUID;
		echo $last_UUID;

		$last = "UPDATE temp_for_state SET UUID='".$UUID_now."' where Teacher_ID = '".$Teacher_ID."'";
		$db->query($last);
		$db->close();
	}
?>
