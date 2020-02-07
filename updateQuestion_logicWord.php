<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");


	$Answer = $_POST['Answer'];
    $Answer = implode ("^&", $Answer);

    $Q1 = $_POST['Q1'];
    $CA = $_POST['CA'];
		$classification = $_POST['classification'];

        //edit block
    if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
    {
    	$tag = $_POST['edit_tag'];
    	$question_number = $_POST['question_number'];
    	$max_number = $question_number;
    	$KeyboardNo = $_POST['KeyboardNo'];
    }

    $sql = "SELECT MAX(KeyboardNo) AS max FROM Keyboard";
    $result = mysqli_fetch_object($db->query($sql));
    $KeyboardNumber = $result->max;
    $KeyboardNumber = $KeyboardNumber+1;
    //get the new question's number



    //if edit
	if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
	{
		$sqlKeyboard = "UPDATE Keyboard  SET wordQuestion = '$Answer' WHERE KeyboardNo='$KeyboardNo'";
		$db->query($sqlKeyboard);

		$sqlQuestion = "UPDATE QuestionList SET CA = '$CA', Content = '$Q1' WHERE KeyboardNo='$KeyboardNo'";
		$db->query($sqlQuestion);
		$db->close();

		echo "<script>alert('編輯成功'); location.href = 'QuestionList.php';</script>";

	}

	else // if not edit , means insert.
	{
		$sqlKeyboard = "INSERT INTO Keyboard (KeyboardNo, type, wordQuestion) VALUES ('$KeyboardNumber', 'Logic', '$Answer')";
		$db->query($sqlKeyboard);

		$sql = "SELECT MAX(No) AS max FROM QuestionList";
	    $result = mysqli_fetch_object($db->query($sql));
	    $max_number = $result->max;
	    $max_number = $max_number+1;

		$sqlQuestion = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo, classification) VALUES ('$max_number', 'Q', '$CA', '$Q1', 'LWORD', 'MULTI', '$KeyboardNumber', '$classification[0]')";
		$db->query($sqlQuestion);
		$db->close();

		echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";
	}





?>
