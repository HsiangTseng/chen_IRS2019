<?php
function calScore($ExamResultNo,$ExamListNo)
{
	include("connects.php");

	//GET STUDENT ANSWER
	$sql = "SELECT * FROM ExamResult WHERE No=$ExamResultNo";
    $result = mysqli_fetch_object($db->query($sql));
    $student_answer = $result->Answer;
    $sa_array = explode('-', $student_answer);

    //GET CORRECT ANSWER
	$sql_ca = "SELECT * FROM ExamList WHERE No = $ExamListNo";
	$result_ca = mysqli_fetch_object($db->query($sql_ca));
	$question_list = $result_ca->question_list;
	$question_array = explode(",", $question_list);

	$answer_string = "";
	$single_or_multi_string = "";
	foreach ($question_array as $value) {
		$sql_a = "SELECT * FROM QuestionList WHERE QA='Q' AND No = $value";
		$result_a = mysqli_fetch_object($db->query($sql_a));
		$answer_string = $answer_string.$result_a->CA.'-';
		$single_or_multi_string = $single_or_multi_string.$result_a->single_or_multi.'-';
	}
	$answer_string = substr($answer_string, 0,-1);//DELETE THE LAST '-' CHARACTER
	$single_or_multi_string = substr($single_or_multi_string, 0, -1);//DELETE THE LAST '-' CHARACTER
	$ca_array = explode('-', $answer_string);
	$single_or_multi_array = explode('-',$single_or_multi_string);



	// Cal the score
	$final_score = 0;
	foreach ($ca_array as $key => $value) {
		if ($single_or_multi_array[$key]=="SINGLE")// SINGLE
		{
			if(!strcmp($ca_array[$key],$sa_array[$key]))//if answer is correct
			{
				$final_score+=1;
			}
		}

		else if ($single_or_multi_array[$key]=="MULTI")//MULTI
		{
			// SICK SOLUTION
			if((strpos($ca_array[$key],'A1') !== false) && (strpos($sa_array[$key],'A1') !== false))$final_score+=1;
			if((strpos($ca_array[$key],'A2') !== false) && (strpos($sa_array[$key],'A2') !== false))$final_score+=1;
			if((strpos($ca_array[$key],'A3') !== false) && (strpos($sa_array[$key],'A3') !== false))$final_score+=1;
			if((strpos($ca_array[$key],'A4') !== false) && (strpos($sa_array[$key],'A4') !== false))$final_score+=1;
			if((strpos($ca_array[$key],'A5') !== false) && (strpos($sa_array[$key],'A5') !== false))$final_score+=1;
			if((strpos($ca_array[$key],'A6') !== false) && (strpos($sa_array[$key],'A6') !== false))$final_score+=1;
			if((strpos($ca_array[$key],'A7') !== false) && (strpos($sa_array[$key],'A7') !== false))$final_score+=1;
			if((strpos($ca_array[$key],'A8') !== false) && (strpos($sa_array[$key],'A8') !== false))$final_score+=1;
		}



	}

	//print_r($single_or_multi_array);
	return $final_score;

}


//calScore('3','1');
?>
