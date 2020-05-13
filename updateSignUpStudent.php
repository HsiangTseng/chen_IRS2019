<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");

	$sql = "SELECT MAX(StudentNumber) AS max FROM UserList WHERE type = 'S'";
  $result = mysqli_fetch_object($db->query($sql));
  $max_number = $result->max;
  $max_number+=1;

	$account = $_POST['account'];
	$password = $_POST['password'];
	$name = $_POST['name'];
	$school = $_POST['school'];
	$grade = $_POST['grade'];
	$class = $_POST['class'];
  //$seatnumber = $_POST['seatnumber'];
  $gender = $_POST['gender'];
  $bday = $_POST['bday'];
  $test_time= $_POST['test_time'];
  $test_type = $_POST['test_type'];
  $test_teacher = $_POST['test_teacher'];
  $category = $_POST['category'];


	//CHECK IF THE ID IS EXIST
	$sql_check = "SELECT COUNT(id) AS number FROM UserList WHERE id='$account'";
	$result_check = mysqli_fetch_object($db->query($sql_check));
  $count_number = $result_check->number;
	//echo $count_number;

	if($count_number>0)//IF EXIST
	{
		echo "<script>alert('註冊失敗，帳號已重複'); location.href = 'StudentList.php';</script>";
	}
	else if ($count_number==0)
	{
		$sql = "INSERT INTO `UserList`(`StudentNumber`,`id`, `password`, `type`, `Name`, `School`, `Grade`, `Class`, `Gender`, `Birth`, `TestTime`, `TestWay`,
			 `TestTeacher`, `Category`) VALUES ('$max_number','$account', '$password', 'S', '$name', '$school', '$grade', '$class', '$gender', '$bday', '$test_time', '$test_type',
					'$test_teacher', '$category')";
		$db->query($sql);
		$db->close();

		echo "<script>alert('註冊成功'); location.href = 'StudentList.php';</script>";
	}




?>
