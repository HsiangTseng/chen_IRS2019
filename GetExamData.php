<?php
	include("connects.php");
	
	$sql = "SELECT * FROM `ExamResult`";

	if(isset($_POST['exam_no'])){
		if($_POST['exam_no']!="0"){
			$sql = $sql." WHERE ExamNo = '".$_POST['exam_no']."'";
		}	
	}


	if(isset($_POST['exam_time'])){
                if($_POST['exam_time']!="0"){
			if(strpos($sql,"WHERE")){
                                $sql = $sql." AND ExamTime like '%".$_POST['exam_time']."%'";
                        }
			else{
                        	$sql = $sql." WHERE ExamTime like '%".$_POST['exam_time']."%'";
			}
                }
		
        }

	if(isset($_POST['exam_num'])){
		if($_POST['exam_num']!="0"){
			if(strpos($sql,"WHERE")){
                                $sql = $sql." AND UUID = '".$_POST['exam_num']."'";
                        }
                        else{
                               $sql = $sql." WHERE UUID = '".$_POST['exam_num']."'";
                        }
		}
	}

	if(strpos($sql,"WHERE")){
        	$sql = $sql." AND WhosAnswer != ''";
        }
        else{
        	$sql = $sql." WHERE WhosAnswer != ''";
        }


	
	$sql = $sql." ORDER BY `ExamTime` ASC ";
	
	$msg = array();
        $index = 0;
        if($stmt = $db->query($sql)){
	        while($result = mysqli_fetch_object($stmt)){
        	        $WhosAnswer = $result->WhosAnswer;
                        $datetime = date("Y-m-d",strtotime($result->ExamTime));
			$UUID = $result->UUID;
			
			$sql_student = "SELECT * FROM UserList WHERE id = '".$WhosAnswer."'";
			$stmt1 = $db->query($sql_student);
			$result1 = mysqli_fetch_object($stmt1);
			$WhosAnswer_Name = $result1->Name;

                        $msg[$index] = array("ExamTime"=>$datetime, "WhosAnswer"=>$WhosAnswer, "UUID"=>$UUID, "WhosAnswer_Name"=>$WhosAnswer_Name);
                        $index++;
                }
        }

        echo json_encode($msg);
?>
