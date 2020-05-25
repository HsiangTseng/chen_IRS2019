<?php
function getScore($Question_No, $StudentsAnswerString)
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
