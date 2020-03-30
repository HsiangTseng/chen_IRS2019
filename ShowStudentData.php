<?php
	include("connects.php");
	
	if(isset($_GET['student_no'])){
		$student_no = $_GET['student_no'];

		$sql = "select * from ExamResult WHERE WhosAnswer = '".$student_no."'";

		


	}
?>
