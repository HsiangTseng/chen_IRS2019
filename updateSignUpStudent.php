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
    $seatnumber = $_POST['seatnumber'];
    $gender = $_POST['gender'];
    $bday = $_POST['bday'];
    $test_time= $_POST['test_time'];
    $test_type = $_POST['test_type'];
    $test_teacher = $_POST['test_teacher'];
    $category = $_POST['category'];




    $sql = "INSERT INTO `UserList`(`StudentNumber`,`id`, `password`, `type`, `Name`, `School`, `Grade`, `Class`, `Gender`, `Birth`, `TestTime`, `TestWay`,
			 `TestTeacher`, `Category`) VALUES ('$max_number','$account', '$password', 'S', '$name', '$school', '$grade', '$class', '$gender', '$bday', '$test_time', '$test_type',
				  '$test_teacher', '$category')";
	$db->query($sql);
	$db->close();

	echo "<script>alert('註冊成功'); location.href = 'StudentList.php';</script>";

?>
