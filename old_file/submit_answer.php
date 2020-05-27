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
		}
	}
	
	//$WhoAnswer = $_POST['username'];	
	$WhosAnswer = "A1234";
	
	$Answer_count_sql = "Select count(Answer) AS Answer_count from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
	$stmt1 = $db->query($Answer_count_sql);
	$result = mysqli_fetch_object($stmt1);
	$Answer_number = $result->Answer_count;




	if(isset($_POST['submit'])){
		//判斷資料庫是否有此人的答案
		//若有此人在這次考試的答案則更新若無則新增
		//更新答案
		if($Answer_number>0){
			$Answer_sql = "Select Answer from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
			$stmt2 = $db->query($Answer_sql);
			$result = mysqli_fetch_object($stmt2);
			$Answer_get = $result->Answer;
			$Answer_get = $Answer_get.'-';
			
			
			//一般多選
			if(!empty($_POST['value'])){						
				foreach($_POST['value'] as $value){
					$Answer_get = $Answer_get.$value;
				}	
				$upd_sql = "update ExamResult SET Answer='".$Answer_get."',ExamTime='".$date."' Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
				$db->query($upd_sql);
				$update_check_sql = "update Now_state SET check_answer=1 where 1";
				$db->query($update_check_sql);
				header ('location: client_show.php');
			}
		}
		//新增回答
		else{
			//新增答案時，才需要No
			$No_sql = "select MAX(No) AS MAXNO from ExamResult";
			$result = mysqli_fetch_object($db->query($No_sql));
			$No = $result->MAXNO;
			$No = $No+1;	
					
			//一般多選
			if(!empty($_POST['value'])){						
				foreach($_POST['value'] as $value){
					$Answer_get = $Answer_get.$value;
				}				
				$upd_sql = "insert into ExamResult (No,ExamNo,UUID,Answer,WhosAnswer,ExamTime) Values ('".$No."','".$ExamNo."','".$UUID."','".$Answer_get."','".$WhosAnswer."','".$date."')";
				$db->query($upd_sql);
				$update_check_sql = "update Now_state check_answer=1 where 1";
				$db->query($update_check_sql);
				header ('location: client_show.php');

			}
		}		
	}


?>	