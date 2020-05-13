<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");

  $student_id = $_POST['student_id'];
	$account = $_POST['account'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$school = $_POST['school'];
	$grade = $_POST['grade'];
	$class = $_POST['class'];
  $gender = $_POST['gender'];
  $bday = $_POST['bday'];
  $test_teacher = $_POST['test_teacher'];
	$test_time = $_POST['test_time'];
  $category = $_POST['category'];

  //echo $student_id.'<BR />';
  //echo $account.$password.$name.$school.$grade.$class.$gender.$bday.$test_teacher.$category;


	//CHECK IF THE ID IS EXIST
	$sql_check = "SELECT COUNT(id) AS number FROM UserList WHERE id='$account'";
	$result_check = mysqli_fetch_object($db->query($sql_check));
	$count_number = $result_check->number;
	//echo $count_number;

	if($count_number>0)//IF EXIST
	{
		$sql_check_e = "SELECT StudentNumber FROM UserList WHERE id='$account'";
		$result_check_e = mysqli_fetch_object($db->query($sql_check_e));
		$old_number = $result_check_e->StudentNumber;
		if($old_number==$student_id)
		{
			$sql = "UPDATE UserList SET id='$account', password='$password', Name='$name', School='$school', Grade='$grade', Class='$class', gender='$gender', Birth='$bday', TestTime='$test_time', TestTeacher='$test_teacher', Category='$category' WHERE StudentNumber = '$student_id'";
			$db->query($sql);
			$db->close();
			echo "<script>alert('編輯成功'); location.href = 'StudentList.php';</script>";
		}
		else if($old_number!=$student_id)
		{
			echo "<script>alert('編輯失敗，帳號已重複'); location.href = 'StudentList.php';</script>";
		}
	}
	else if($count_number==0)
	{
		$sql = "UPDATE UserList SET id='$account', password='$password', Name='$name', School='$school', Grade='$grade', Class='$class', gender='$gender', Birth='$bday', TestTime='$test_time', TestTeacher='$test_teacher', Category='$category' WHERE StudentNumber = '$student_id'";
		$db->query($sql);
		$db->close();
		echo "<script>alert('編輯成功'); location.href = 'StudentList.php';</script>";
	}



?>
