<?php
	session_start();
        include("connects.php");
	$WhosAnswer = $_SESSION['username'];
        $sql_user = "select * from UserList where id='".$WhosAnswer."'";
        $stmt2 = $db->query($sql_user);
        $result2 = mysqli_fetch_object($stmt2);
        $userStudentNumber = $result2->StudentNumber;


        $sql_catch_count = "select count(Teacher_ID) as count from ClassList where StudentNumberList like '%".$userStudentNumber."%'";
        $result_count = mysqli_fetch_object($db->query($sql_catch_count));
        $catch_count = $result_count->count;

        if($catch_count > 0){
                $sql_catch_teacher = "select * from ClassList where StudentNumberList like '%".$userStudentNumber."%'";
								if($stmt3 = $db->query($sql_catch_teacher))
								{
										while($result3 = mysqli_fetch_object($stmt3))
										{
											$Studentlist_array = array();
											$temp_list = $result3->StudentNumberList;
											$Studentlist_array = explode("-",$temp_list);
											foreach ($Studentlist_array as $key => $value) {
												if($Studentlist_array[$key]==$userStudentNumber)
												{
													$Teacher_ID = $result3->Teacher_ID;
													$_SESSION['Teacher_ID'] =  $Teacher_ID;
													//echo $Teacher_ID;
													//print_r($Studentlist_array);
												}
											}
										}
								}
                /*$stmt3 = $db->query($sql_catch_teacher);
                $result3 = mysqli_fetch_object($stmt3);
                $Teacher_ID = $result3->Teacher_ID;
                $_SESSION['Teacher_ID'] =  $Teacher_ID;*/

		echo $Teacher_ID;
        }
	else{
		if(isset($_SESSION['Teacher_ID'])){
			unset($_SESSION['Teacher_ID']);
		}
		$Teacher_ID = "";
		echo $Teacher_ID;
	}
?>
