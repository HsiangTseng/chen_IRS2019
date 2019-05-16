<?php
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
	$WhosAnswer = "A1234";
	
	$Answer_count_sql = "Select count(Answer) AS Answer_count from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
	$stmt1 = $db->query($Answer_count_sql);
	$result = mysqli_fetch_object($stmt1);
	$Answer_number = $result->Answer_count;




	if(isset($_POST['submit'])){
		//更新答案
		//獲得資料庫內之答案
		$Answer_sql = "Select Answer from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
		$stmt2 = $db->query($Answer_sql);
		$result = mysqli_fetch_object($stmt2);
		$Answer_get = $result->Answer;
		
		$This_answer_get='';
		//獲得此題答案
		if(!empty($_POST['value'])){						
			foreach($_POST['value'] as $value){
				if($This_answer_get != ''){
					$This_answer_get = $This_answer_get.',';
				}
				$This_answer_get = $This_answer_get.$value;
			}
		}
		if($This_answer_get != ''){
		$Answer_arr = mb_split("-",$Answer_get);
		for( $i = 0 ; $i < count($Answer_arr) ; $i++ ){
			if( $i == ($No-1)){
				$Answer_arr{$i} = $This_answer_get;
				break;
			}
		}
		$after_answer=implode("-",$Answer_arr);
		
		$upd_sql = "update ExamResult SET Answer='".$after_answer."',ExamTime='".$date."' Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
		$db->query($upd_sql);
		$update_check_sql = "update Now_state SET check_answer=1 where 1";
		$db->query($update_check_sql);
		}
		header ('location: client_show.php');
	}
?>	
