<?php
	session_start();
	include("connects.php");


	$Teacher_ID = $_SESSION['username'];

	if(isset($_POST['submit'])){
		$This_answer_get = '';

		 //獲取其他老師的班級
	        $OtherTeacherarray = array();
        	$count_other_teacher = 0;
	        $sql_teacher_all = "select * from UserList where type = 'T' and id != '".$Teacher_ID."'";
        	if($stmt3=$db->query($sql_teacher_all))
	        {
        	        while($result3 = mysqli_fetch_object($stmt3)){
                	        $OtherTeacherarray[$count_other_teacher] = $result3->id;
                        	$count_other_teacher++;
	                }
        	}
	        //獲取其他老師的班級學生
        	$OtherTeacherStudentarray = array();
	        $OtherTeacherStudentCount = 0;
        	for($index = 0 ; $index < $count_other_teacher ; $index++){
	                $sql_teacherclass = "select * from ClassList where Teacher_ID = '".$OtherTeacherarray[$index]."'";
        	        if($stmt4=$db->query($sql_teacherclass))
                	{
                        	while($result4 = mysqli_fetch_object($stmt4)){
                                	$otherclasslist = $result4->StudentNumberList;
	                                $otherstudentnumberarray = mb_split("-",$otherclasslist);
        	                        $otherstudentcount = count($otherstudentnumberarray);
	
        	                        $OtherTeacherStudentarray = array_merge($OtherTeacherStudentarray,$otherstudentnumberarray);
                	                $OtherTeacherStudentCount = $OtherTeacherStudentCount+$otherstudentcount;
                        	}
	                }
        	}
		sort($OtherTeacherStudentarray);

		$count_student = 0;
		$check_user = 0;
		$used_student = array();	
		if(!empty($_POST['value'])){
			foreach($_POST['value'] as $value){
				for($other_i = 0 ; $other_i < $OtherTeacherStudentCount ; $other_i++){
					if($OtherTeacherStudentarray[$other_i] == $value){
                                                $used_student[$count_student]=$OtherTeacherStudentarray[$other_i];
                                                $count_student++;
                                        }
				}
				if($count_student == 0){
					if($This_answer_get != ''){
                                                $This_answer_get = $This_answer_get.'-';
                                        }
                                        $This_answer_get = $This_answer_get.$value;
				}
				else{
					$check_user = 1;
				}
			}
		}
		
		if($check_user == 1){
			echo "<script>";
			echo "alert('";
			for($count_i = 0 ; $count_i < $count_student ; $count_i++){
				$sql_student_data = "select * from UserList where StudentNumber = '".$used_student[$count_i]."'";
				$stmt5=$db->query($sql_student_data);
				$result5 = mysqli_fetch_object($stmt5);
				echo "編號:".$result5->StudentNumber."  姓名：".$result5->Name."，已被其他老師選取\\n";
			}
			echo "');";			
			echo "location.href = 'editstudentlist.php';</script>";
		}
		
		else{
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
			echo "<script>alert('編輯成功'); location.href = 'editstudentlist.php';</script>";
		}
	}

?>
