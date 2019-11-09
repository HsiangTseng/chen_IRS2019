<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
	
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


    echo $account;

    $sql2 = "INSERT INTO UserList (id, password, type, Name, School, Grage, Class, Seatnumber, Gender, Birth, TestTime, TestWay, TestTeacher, Category) VALUES ('$account', '$password', 'S', '$name', '$school', '$grade', '$class', '$seatnumber', '$gender', '$bday', '$test_time', '$test_type', '$test_teacher', '$category')";

    $sql = "INSERT INTO `UserList`(`id`, `password`, `type`, `Name`, `School`, `Grade`, `Class`, `Seatnumber`, `Gender`, `Birth`, `TestTime`, `TestWay`, `TestTeacher`, `Category`) VALUES ('$account', '$password', 'S', '$name', '$school', '$grade', '$class', '$seatnumber', '$gender', '$bday', '$test_time', '$test_type', '$test_teacher', '$category')";
	$db->query($sql);
	$db->close();

?>