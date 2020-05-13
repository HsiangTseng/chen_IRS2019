<?php
	include("connects.php");
	
	$sql = "SELECT * FROM ExamResult";

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
		
/*		$msg = array();
                $index = 0;
                if($stmt = $db->query($sql)){
                        while($result = mysqli_fetch_object($stmt)){
                                $WhosAnswer = $result->WhosAnswer;
                                $datetime = date("Y-m-d",strtotime($result->ExamTime));
                                $msg[$index] = array("ExamTime"=>$datetime, "WhosAnswer"=>$WhosAnswer);
                                $index++;
                        }
                }

                echo json_encode($msg);
*/
        }
	
	$msg = array();
        $index = 0;
        if($stmt = $db->query($sql)){
	        while($result = mysqli_fetch_object($stmt)){
        	        $WhosAnswer = $result->WhosAnswer;
                        $datetime = date("Y-m-d",strtotime($result->ExamTime));
                        $msg[$index] = array("ExamTime"=>$datetime, "WhosAnswer"=>$WhosAnswer);
                        $index++;
                }
        }

        echo json_encode($msg);



	/*else{	
		$msg = array();
		$msg2 = array();
		$index = 0;
		if($stmt = $db->query($sql)){
			while($result = mysqli_fetch_object($stmt)){
				$WhosAnswer = $result->WhosAnswer;
				$datetime = date("Y-m-d",strtotime($result->ExamTime));			
				$msg[$index] = array("ExamTime"=>$datetime, "WhosAnswer"=>$WhosAnswer);
				$index++;
			}
		}
		$index2 = 0;
		for($i = 0 ; $i < $index ; $i++){
			if($i > 0){			
				if($msg[$i]["ExamTime"]!=$msg[$i-1]["ExamTime"]){
					$msg2[$index2] = $msg[$i];
					$index2++;
				}
			}
			else{
				$msg2[$index2] = $msg[$i]; 
				$index2++;
			}
		}

		echo json_encode($msg2);
	}*/

?>
