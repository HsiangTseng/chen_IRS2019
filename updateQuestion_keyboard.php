<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
	
	$keyboardNo =$_POST['KeyboardNo'];
	$q1 = $_POST['Q1'];

	$sql = "SELECT MAX(No) AS max FROM QuestionList";
    $result = mysqli_fetch_object($db->query($sql));
    $max_number = $result->max;
    $max_number = $max_number+1;
    //get the new question's number.
    $CA = $_POST['answer'];
    $CA = implode (",", $CA);



	$sql2 = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo) VALUES ('$max_number', 'Q', '$CA', '$q1', 'KEYBOARD', 'MULTI', '$keyboardNo')";
	$db->query($sql2);


	$db->close();

	echo "<script>alert('出題成功'); location.href = 'KeyboardSite.php';</script>";
?>

