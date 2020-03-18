<?
	session_start();
	include("connects.php");
	$Teacher_ID = $_SESSION['Teacher_ID'];

        $date=date('Y-m-d H:i:s');
        $sql_get_UUID_NoExam = "select * from Now_state where Teacher_ID = '".$Teacher_ID."'";

	if($stmt = $db->query($sql_get_UUID_NoExam)){
        	while($result = mysqli_fetch_object($stmt)){
                	$ExamNo = $result->ExamNumber;
                        $UUID = $result->UUID;
                }
	}

       	$WhosAnswer = $_SESSION['username'];        

        $Answer_count_sql = "Select count(Answer) AS Answer_count from ExamResult Where ExamNo ='".$ExamNo."' and UUID ='".$UUID."' and WhosAnswer='".$WhosAnswer."'";
        $stmt1 = $db->query($Answer_count_sql);
        $result = mysqli_fetch_object($stmt1);
        $Answer_number = $result->Answer_count;

        if($Answer_number ==0 ){
	        //抓取最大之No+1
	        $No_sql = "select MAX(No) AS MAXNO from ExamResult";
        	$result = mysqli_fetch_object($db->query($No_sql));
	        $No = $result->MAXNO;
        	$No = $No+1;
                //抓取有幾題題目
	        $sql_catch = "select question_list from ExamList where No ='".$ExamNo."'";
        	$result = mysqli_fetch_object($db->query($sql_catch));
	        $examstr = $result->question_list;
        	$qlist = array();
	        $qlist = mb_split(",",$examstr);        	
	        $exam_num = count($qlist);
        	$Answer = '';
	        $Answertime = '';
        	for( $i = 0 ; $i < $exam_num ; $i++){
     			if($i != 0){
		        	$Answer = $Answer.'-N';
	                        $Answertime = $Answertime.'-N';
        	        }
                	else{
                		$Answer = $Answer.'N';
	                        $Answertime = $Answertime.'N';
        	        }
		}
	        $inser_sql = "insert into ExamResult (No,ExamNo,UUID,Answer,WhosAnswer,ExamTime,AnswerTime) Values ('".$No."','".$ExamNo."','".$UUID."','".$Answer."','".$WhosAnswer."','".$date."','".$Answertime."')";
        	$db->query($inser_sql);
	}
        header('location: client_show.php');
?>
