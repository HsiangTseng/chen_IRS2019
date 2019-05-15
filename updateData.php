<?php
	include("connects.php");
	
	$sql = "UPDATE Now_state SET No=1";

	if ($db->query($sql) === TRUE) {
	    echo "Record updated successfully";
	} else {
	    echo "Error updating record: " . $conn->error;
	}

	$db->close();
?>

