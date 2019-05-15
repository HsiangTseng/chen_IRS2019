<?
	include("connects.php");
	
	$sql_nowstate = "select * from Now_state";
	
	//取得現在題號、現在的試卷號碼
	if($stmt = $db->query($sql_nowstate))
	{
		while($result = mysqli_fetch_object($stmt))
		{
			$sql_number_show = $result->No;
			$sql_number = $sql_number_show-1;
			$sql_quiz = $result->ExamNumber;			
		}
	}
	
	//取得每一題在Questionlist的號碼
	$sql_quiz = "SELECT * FROM ExamList WHERE No like '$sql_quiz'";
	$result = mysqli_fetch_object($db->query($sql_quiz));
    $q_list = array();
    $temp_string = $result->question_list;
    $q_list = mb_split(",",$temp_string);
	
	//取得此題的答案數量
	$sql_number_quiz = "select count(QA) AS Count from QuestionList where No like '".$q_list[$sql_number]."'";
	$stmt = $db->query($sql_number_quiz);
	$number_quiz = mysqli_fetch_object($stmt);
	echo $number_quiz->Count;

?>