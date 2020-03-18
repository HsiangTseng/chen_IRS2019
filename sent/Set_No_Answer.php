<?php
	include("connects.php");
	
	//get answer data from database and the time now
	$date=date('Y-m-d H:i:s');
	$sql_get_UUID_NoExam = "select * from Now_state";
	$No_Answer = "-N";
	
	if($stmt = $db->query($sql_get_UUID_NoExam)){
		while($result = mysqli_fetch_object($stmt)){			
			$ExamNo = $result->ExamNumber;
			$UUID = $result->UUID;			
		}
	}
	//$WhoAnswer = $_POST['username'];
	$WhosAnswer='A1234';
	
	$Answer_count_sql = "Select count(Answer) AS Answer_count from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
	$stmt1 = $db->query($Answer_count_sql);
	$result = mysqli_fetch_object($stmt1);
	$Answer_number = $result->Answer_count;

	//更新答案			
	if($Answer_number > 0){		

		$Answer_sql = "Select Answer from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";

		$stmt2 = $db->query($Answer_sql);
		$result = mysqli_fetch_object($stmt2);
		$Answer_get = $result->Answer;
		$Answer_get = $Answer_get.$No_Answer;
	
		$upd_sql = "update ExamResult SET Answer='".$Answer_get."',ExamTime='".$date."' Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
		$db->query($upd_sql);
	}
	//新增回答
	else{			
		//新增答案時，才需要No
		$No_sql = "select MAX(No) AS MAXNO from ExamResult";
		$result = mysqli_fetch_object($db->query($No_sql));
		$No = $result->MAXNO;
		$No=$No+1;
		$upd_sql = "insert into ExamResult (No,ExamNo,UUID,Answer,WhosAnswer,ExamTime) Values ('".$No."','".$ExamNo."','".$UUID."','N','".$WhosAnswer."','".$date."')";
		$db->query($upd_sql);
	}	
?>