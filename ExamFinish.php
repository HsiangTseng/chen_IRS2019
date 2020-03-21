<?php
	include("connects.php");
	session_start();
	$username=$_SESSION['username'];

  $sql = "SELECT MAX(No) AS max FROM ExamResult";
  $result = mysqli_fetch_object($db->query($sql));
  $ID = $result->max +1;


	//Get the ExamNumber and the UUID.
	$sql = "SELECT * FROM Now_state WHERE Teacher_ID='$username'";
	if($stmt = $db->query($sql))
	{
		while($result = mysqli_fetch_object($stmt))
		{
			$ExamNumber = $result->ExamNumber;
			$UID = $result->UUID;
			$timestamp = $result->ExamTime;
		}
	}



	//Then get the Exam Answer from the ExamList
	$sql = "SELECT * FROM ExamList WHERE No = '$ExamNumber'";
	if($stmt = $db->query($sql))
	{
		while($result = mysqli_fetch_object(($stmt)))
		{
			if(isset($result->question_list))
			{
			$string_qlist = '';
			$string_qlist = $result->question_list;
			}
		}
	}
    $q_list = array();
    $temp_string = $result->question_list;
    $q_list = mb_split(",",$string_qlist);
	//q_list[0] = first question's number, etc.


	$answer_list = array();
	for($i = 0 ; $i < sizeof($q_list) ; $i++)
	{
		$sql = "SELECT CA FROM QuestionList WHERE QA = 'Q' AND No = '$q_list[$i]'";
		if($stmt = $db->query($sql))
		{
			while($result = mysqli_fetch_object(($stmt)))
			{
				$answer_list[$i] = $result->CA;
			}
		}
	}
	//answer_list[0] = first question's answer , etc.


	$answer_string = $answer_list[0];
	for ($a = 1 ; $a < sizeof($answer_list) ; $a++)
	{
		$answer_string = $answer_string.'-'.$answer_list[$a];
	}

	// answer_string will be like      A1-A2-A1-A3-A4-A1,A2,A3,A4-A1-A2-A4

	/*$sql = "INSERT INTO ExamResult (No, ExamNo, UUID, Answer, WhosAnswer, ExamTime) VALUES ('$ID','$ExamNumber','$UID','$answer_string','Teacher','$timestamp')";
	$db->query($sql);*/


  $sql_temp_state="UPDATE temp_for_state SET No_temp=0 WHERE Teacher_ID='$username'";
  $db->query($sql_temp_state);
  $sql_now_state="UPDATE Now_state SET No=0 WHERE Teacher_ID='$username'";
  $db->query($sql_now_state);
	$db->close();

	echo "<script>alert('考試完畢'); location.href = 'ExamList.php';</script>";

?>
