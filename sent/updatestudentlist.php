<?php
	session_start();
	include("connects.php");
	
	$Teacher_ID = $_SESSION['username'];
	
	if(isset($_POST['submit'])){
		
		$This_answer_get = '';
		
		if(!empty($_POST['value'])){
			foreach($_POST['value'] as $value){
				if($This_answer_get != ''){
					$This_answer_get = $This_answer_get.'-';
				}
				$This_answer_get = $This_answer_get.$value;
			}
		}
		
		if($This_answer_get != ''){
			$sql = "select * from ClassList where Teacher_ID = '".$Teacher_ID."'";			
			$stmt = $db->query($sql);
			$result = mysqli_fetch_object($stmt);
			if(!empty($result->Teacher_ID) && !is_null($result->Teacher_ID))
			{
				$upd_sql = "update ClassList SET StudentNumberList = '".$This_answer_get."' where Teacher_ID = '".$Teacher_ID."'";
                                $db->query($upd_sql);
			}
			else
			{
				echo $This_answer_get;
				$insert_sql = "INSERT INTO ClassList (StudentNumberList,Teacher_ID) VALUES ('".$This_answer_get."','".$Teacher_ID."')";
	                        $db->query($insert_sql);
			}			
		}
		header ('location: editstudentlist.php');
	}

?>

