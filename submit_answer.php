<?php
	session_start();
	include("connects.php");
	$Answer_get='';
	//get answer data from database
	$date=date('Y-m-d H:i:s');
	$sql_get_UUID_NoExam = "select * from Now_state";	
	
	if($stmt = $db->query($sql_get_UUID_NoExam)){
		while($result = mysqli_fetch_object($stmt)){			
			$ExamNo = $result->ExamNumber;
			$UUID = $result->UUID;	
			$No = $result->No;
		}
	}
	
	//$WhoAnswer = $_POST['username'];	
	//$WhosAnswer = "A1234";
	$WhosAnswer = $_SESSION['username'];

	//new 
	//$answer_start_time = $_SESSION['answer_start_time'];
	

	
	$Answer_count_sql = "Select count(Answer) AS Answer_count from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
	$stmt1 = $db->query($Answer_count_sql);
	$result = mysqli_fetch_object($stmt1);
	$Answer_number = $result->Answer_count;


	if(isset($_POST['submit'])){
		//更新答案
		//獲得資料庫內之答案
		$Answer_sql = "Select * from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
		$stmt2 = $db->query($Answer_sql);
		$result = mysqli_fetch_object($stmt2);
		$Answer_get = $result->Answer;
		$Answer_time_get = $result->AnswerTime;
		
		$This_answer_get='';
		$answer_start_time = '';
		//獲得此題答案		
		if(!empty($_POST['hidden'])){
			$answer_start_time = $_POST['hidden_time'];
			$This_answer_get = $_POST['hidden'];
			foreach($_POST['hidden'] as $value){
				$This_answer_get = $This_answer_get.$value;
			}
		}
		elseif(!empty($_POST['value'])){						
			$answer_start_time = $_POST['hidden_time'];
			foreach($_POST['value'] as $value){
				if($This_answer_get != ''){
					$This_answer_get = $This_answer_get.',';
				}
				$This_answer_get = $This_answer_get.$value;
			}

		}		
		if($This_answer_get != ''){
			$answer_end_time = microtime(true);
			$answer_time = round($answer_end_time - $answer_start_time,2);

			$Answer_arr = mb_split("-",$Answer_get);
			$Answer_time_arr = mb_split("-",$Answer_time_get);
			for( $i = 0 ; $i < count($Answer_arr) ; $i++ ){
				if( $i == ($No-1)){
					$Answer_arr{$i} = $This_answer_get;
					$Answer_time_arr{$i} = $answer_time;
					break;
				}
			}
			$after_answer=implode("-",$Answer_arr);
			$after_answer_time = implode("-",$Answer_time_arr);
		
			$upd_sql = "update ExamResult SET Answer='".$after_answer."',ExamTime='".$date."' ,AnswerTime='".$after_answer_time."' Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
			$db->query($upd_sql);
			$update_check_sql = "update Now_state SET check_answer=1 where 1";
			$db->query($update_check_sql);
		}
		header ('location: client_show.php');
	}
?>	
