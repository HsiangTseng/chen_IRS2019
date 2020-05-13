<?php
	include("connects.php");
	$sql = "select * from Now_state";
	//$sql_quiz = "select ExamNumber from 'Now_state`";
	//$sql_number = "select No FROM `Now_state`";		
	$sql_number = 0;
	$sql_quiz = 0;
	if($stmt = $db->query($sql))
	{
		while($result = mysqli_fetch_object($stmt))
		{
			$sql_number = $result->No;
			$sql_number = $sql_number-1;
			$sql_quiz = $result->ExamNumber;
			$result = mysqli_fetch_object($stmt);
		}
	}
	

	$sql = "SELECT * FROM ExamList WHERE No like '$sql_quiz'";
    $result = mysqli_fetch_object($db->query($sql));
    $q_list = array();
    $temp_string = $result->question_list;
    $q_list = mb_split(",",$temp_string);	
	
	$sql_checkbox = "select * from QuestionList where No like '".$q_list[$sql_number]."' and QA like 'Q'";
	$stmt = $db->query($sql_checkbox);
	$result = mysqli_fetch_object($stmt);
	$checkbox = $result->single_or_multi;
	
	
	if($checkbox == 'SINGLE'){
		$sql_quiz_type = "select * from QuestionList where No like '".$q_list[$sql_number]."' and QA like 'Q'";
		$stmt = $db->query($sql_quiz_type);
		$result = mysqli_fetch_object($stmt);
		$quiz_type = $result->type;
		
		if($quiz_type == 'WORD' or $quiz_type =='VIDEO'){
			$sql_word = "select * FROM QuestionList WHERE No like '".$q_list[$sql_number]."' AND QA like 'A4'";
			$result = mysqli_fetch_object($db->query($sql_word));
			echo "<input type='button' onclick=reply_d() value='".$result->Content."'>";
		}
		else{
			$sql_picture = "select * from QuestionList where No like '".$q_list[$sql_number]."' and QA like 'A4'";//抓圖片相關資訊	
			$stmt = $db->query($sql_picture);
			$result = mysqli_fetch_object($stmt);
			$picture_type = $result->picture_ext;//抓圖片型態	
			$picture_alt = $result->picture_alt;//抓圖片alt
			
			echo "<input type='image' src='http://10.16.1.13/chen_IRS/upload/Q".$q_list[$sql_number]."A4.".$picture_type."' alt='".$picture_alt."' width='80%' height='80%' onclick='reply_d()'>";
		}
	}
	else{
		$sql_quiz_type = "select * from QuestionList where No like '".$q_list[$sql_number]."' and QA like 'Q'";
		$stmt = $db->query($sql_quiz_type);
		$result = mysqli_fetch_object($stmt);
		$quiz_type = $result->type;
		if($quiz_type == 'WORD' or $quiz_type =='VIDEO'){
			$sql_word = "select * FROM QuestionList WHERE No like '".$q_list[$sql_number]."' AND QA like 'A4'";
			$result = mysqli_fetch_object($db->query($sql_word));
			echo "<input type='checkbox' onclick=reply_d() value='".$result->Content."' font-size='20px'>";
		}
		else{
			$sql_picture = "select * from QuestionList where No like '".$q_list[$sql_number]."' and QA like 'A4'";//抓圖片相關資訊
			$stmt = $db->query($sql_picture);
			$result = mysqli_fetch_object($stmt);
			$picture_type = $result->picture_ext; //抓圖片型態		
			$picture_alt = $result->picture_alt; //抓圖片alt
			
			echo "<input type='checkbox' id='A4'/>";
			echo "<label for='A4'><img src='http://10.16.1.13/chen_IRS/upload/Q".$q_list[$sql_number]."A4.".$picture_type."' alt='".$picture_alt."' width='80%' height='80%' onclick='reply_d()'></label>";
		}
	}
	
	
	
	
	
	//echo "<input type='button' style=background-image:url(圖片網址);width:80px;height:25px;'>"
	//echo "<input type='button' onclick=reply_d() value='".$result->Content."'>";
?>
