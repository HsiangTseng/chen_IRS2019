<html>

<head>
</head>

<body>
</body>
<script>
	function alertTimeout(mymsg,mymsecs)
	{
		var myelement = document.createElement("div");
		myelement.setAttribute("style","background-color: red;color:white; width: 450px;height: 200px;position: absolute;top:0;bottom:0;left:0;right:0;margin:auto;border: 4px solid black;font-family:arial;font-size:25px;font-weight:bold;display: flex; align-items: center; justify-content: center; text-align: center;");
		myelement.innerHTML = mymsg;
		setTimeout(function(){
			myelement.parentNode.removeChild(myelement);
			location.href = 'client_show.php';
		},mymsecs);
		document.body.appendChild(myelement);
	}

	function alertRightTimeout(mymsg,mymsecs)
        {
                var myelement = document.createElement("div");
                myelement.setAttribute("style","background-color: green;color:white; width: 450px;height: 200px;position: absolute;top:0;bottom:0;left:0;right:0;margin:auto;border: 4px solid black;font-family:arial;font-size:25px;font-weight:bold;display: flex; align-items: center; justify-content: center; text-align: center;");
                myelement.innerHTML = mymsg;
                setTimeout(function(){
                        myelement.parentNode.removeChild(myelement);
                        location.href = 'client_show.php';
                },mymsecs);
                document.body.appendChild(myelement);
        }
</script>

<?php
	session_start();
	include("connects.php");
	$Answer_get='';
	//get answer data from database
	$date=date('Y-m-d H:i:s');
	$Teacher_ID = $_SESSION['Teacher_ID'];
	$sql_get_UUID_NoExam = "select * from Now_state where Teacher_ID = '".$Teacher_ID."'";
	
	if($stmt = $db->query($sql_get_UUID_NoExam)){
		while($result = mysqli_fetch_object($stmt)){			
			$ExamNo = $result->ExamNumber;
			$UUID = $result->UUID;	
			$No = $result->No;
		}
	}
	
	$WhosAnswer = $_SESSION['username'];
	
	$Answer_count_sql = "Select count(Answer) AS Answer_count from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
	$stmt1 = $db->query($Answer_count_sql);
	$result = mysqli_fetch_object($stmt1);
	$Answer_number = $result->Answer_count;

	$select_exam_sql = "select * from ExamList WHERE No = '".$ExamNo."'";
	$stmt_exam = $db->query($select_exam_sql);
        $result_exam = mysqli_fetch_object($stmt_exam);
	$exam_list = $result_exam->question_list;
	$Arr_exam = mb_split(",",$exam_list);

	$select_CA_Status_sql = "select * from QuestionList WHERE No ='".$Arr_exam{$No-1}."' AND QA = 'Q'";
	$stmt_CA = $db->query($select_CA_Status_sql);
        $result_CA = mysqli_fetch_object($stmt_CA);
	$Answer_CA = $result_CA->CA;
	$Answer_Status = $result_CA->status;


	
	

	if(isset($_POST['submit'])){
		if($Answer_Status == "2"){
			$This_answer_get ='';
			if(!empty($_POST['hidden'])){
                                $answer_start_time = $_POST['hidden_time'];
                                $This_answer_get = $_POST['hidden'];
//				$This_answer_get = $This_answer_get.$_POST['hidden'];
//                                foreach($_POST['hidden'] as $value){
  //                                      $This_answer_get = $This_answer_get.$value;
    //                            }
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
				if(strpos($This_answer_get,$Answer_CA)!==false){
					echo "<script>
						alertRightTimeout('答對了喔',5000);
						</script>";
				}
				else{
					echo "<script>alertTimeout('答錯了喔',5000); </script>";
				}
                        }
		}
		else{
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
//				$This_answer_get = $This_answer_get.$_POST['hidden'];
//				foreach($_POST['hidden'] as $value){
//					$This_answer_get = $This_answer_get.$value;
//				}
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
	}
?>	
</html>
