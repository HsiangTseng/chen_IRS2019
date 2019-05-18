<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
	

	$Answer = $_POST['Answer'];
    $Answer = implode ("^&", $Answer);

    $Q1 = $_POST['Q1'];
    $CA = $_POST['CA'];

    $sql = "SELECT MAX(KeyboardNo) AS max FROM Keyboard";
    $result = mysqli_fetch_object($db->query($sql));
    $KeyboardNumber = $result->max;
    $KeyboardNumber = $KeyboardNumber+1;
    //get the new question's number

	$sqlKeyboard = "INSERT INTO Keyboard (KeyboardNo, type, wordQuestion) VALUES ('$KeyboardNumber', 'Logic', '$Answer')";
	$db->query($sqlKeyboard);






	$sql = "SELECT MAX(No) AS max FROM QuestionList";
    $result = mysqli_fetch_object($db->query($sql));
    $max_number = $result->max;
    $max_number = $max_number+1;

	$sqlQuestion = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo) VALUES ('$max_number', 'Q', '$CA', '$Q1', 'LWORD', 'MULTI', '$KeyboardNumber')";
	$db->query($sqlQuestion);
	$db->close();
	
	echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";
	
?>

