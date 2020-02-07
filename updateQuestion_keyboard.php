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
		$classification = $_POST['classification'];

    //edit block
    if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
    {
    	$tag = $_POST['edit_tag'];
    	$question_number = $_POST['question_number'];
    	$max_number = $question_number;

    }


    // if edit
	if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
	{
		$sql = "UPDATE QuestionList SET CA = '$CA', Content='$q1', KeyboardNo='$keyboardNo' WHERE No = '$max_number' AND QA = 'Q'";
		$db->query($sql);
		$db->close();

		echo "<script>alert('編輯成功'); location.href = 'QuestionList.php';</script>";
	}

	else // if not edit , means insert.
	{
	  	$sql2 = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo, classification) VALUES ('$max_number', 'Q', '$CA', '$q1', 'KEYBOARD', 'MULTI', '$keyboardNo', '$classification[0]')";
		$db->query($sql2);


		$db->close();

		echo "<script>alert('出題成功'); location.href = 'KeyboardSite.php';</script>";
	}


?>
