<?php
	include("connects.php");

	$sql_upd = "update Now_state set check_answer = 0 where 1";
	
	$db->query($sql_upd);
	$db->close();
?>