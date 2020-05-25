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
	$type_string = "";
	foreach ($question_array as $value) {
		$sql_a = "SELECT * FROM QuestionList WHERE QA='Q' AND No = $value";
		$result_a = mysqli_fetch_object($db->query($sql_a));
		$answer_string = $answer_string.$result_a->CA.'-';
		$single_or_multi_string = $single_or_multi_string.$result_a->single_or_multi.'-';
		$type_string = $type_string.$result_a->type.'-';
	}
	$answer_string = substr($answer_string, 0,-1);//DELETE THE LAST '-' CHARACTER
	$single_or_multi_string = substr($single_or_multi_string, 0, -1);//DELETE THE LAST '-' CHARACTER
	$type_string = substr($type_string,0,-1);//DELETE THE LAST '-' CHARACTER
	$ca_array = explode('-', $answer_string);
	$single_or_multi_array = explode('-',$single_or_multi_string);
	$type_array = explode('-',$type_string);



	// Cal the score
	$final_score = 0;
	foreach ($ca_array as $key => $value) {
		if(!isset($sa_array[$key]))
		{
			$sa_array[$key]='ERROR';
		}
		if ($single_or_multi_array[$key]=="SINGLE")// SINGLE
		{
			if(!strcmp($ca_array[$key],$sa_array[$key]))//if answer is correct
			{
				$final_score+=1;
			}
		}

		else if ($single_or_multi_array[$key]=="MULTI")//MULTI
		{
			if (strpos($type_array[$key],'L')!== false)
			{
				// ALL OPTIONS SELECTED, GET 1 POINT;
				$ca_element_array = explode(',',$ca_array[$key]);
				$sa_element_array = explode(',',$sa_array[$key]);
				$min_count = min(count($ca_element_array),count($sa_element_array));
				$check = 1;

				for( $i = 0 ; $i < count($ca_element_array) ; $i++)
				{
					$error_count = 0;
					for( $j = 0 ; $j < count($sa_element_array) ; $j++)
					{
						if($ca_element_array[$i] != $sa_element_array[$j])
						{
							$error_count++;
						}
						if($error_count == $min_count)
						{
							$check = 0;
							break;
						}
					}
				}
				if($check == 1)
				{
					$final_score++;
					if(strcmp($ca_array[$key],$sa_array[$key]) == 0)
					{
						$final_score++;
					}
				}
			}
			else{
				$ca_element_array = explode(',',$ca_array[$key]);
        $sa_element_array = explode(',',$sa_array[$key]);
				for( $i = 0 ; $i < count($ca_element_array) ; $i++)
				{
        	for( $j = 0 ; $j < count($sa_element_array) ; $j++)
					{
            if($ca_element_array[$i] == $sa_element_array[$j])
						{
            $final_score++;
            }
          }
        }
			}
		}


	}
	return $final_score;
}

function GetQuestionsScore($Question_No, $StudentsAnswerString)
{
	include("connects.php");
  $sql_a = "SELECT * FROM QuestionList WHERE QA='Q' AND No = $Question_No ";
  $result_a = mysqli_fetch_object($db->query($sql_a));
  $sa = $StudentsAnswerString;
  $ca = $result_a->CA;
  $type = $result_a->type;
  $single_or_multi = $result_a->single_or_multi;

  $score = 0;

  if ($single_or_multi=="SINGLE")// SINGLE
  {
    if(!strcmp($ca,$sa))//if answer is correct
    {
      $score+=1;
    }
  }
  else if ($single_or_multi=="MULTI")//MULTI
  {
    if (strpos($type,'L')!== false)
    {
      // ALL OPTIONS SELECTED, GET 1 POINT;
      $ca_element_array = explode(',',$ca);
      $sa_element_array = explode(',',$sa);
      $min_count = min(count($ca_element_array),count($sa_element_array));
      $check = 1;

      for( $i = 0 ; $i < count($ca_element_array) ; $i++)
      {
        $error_count = 0;
        for( $j = 0 ; $j < count($sa_element_array) ; $j++)
        {
          if($ca_element_array[$i] != $sa_element_array[$j])
          {
            $error_count++;
          }
          if($error_count == $min_count)
          {
            $check = 0;
            break;
          }
        }
      }
      if($check == 1)
      {
        $score++;
        if(strcmp($ca,$sa) == 0)
        {
          $score++;
        }
      }
    }
    else{
      $ca_element_array = explode(',',$ca);
      $sa_element_array = explode(',',$sa);
      for( $i = 0 ; $i < count($ca_element_array) ; $i++)
      {
        for( $j = 0 ; $j < count($sa_element_array) ; $j++)
        {
          if($ca_element_array[$i] == $sa_element_array[$j])
          {
          $score++;
          }
        }
      }
    }
  }

return $score;
}
?>
