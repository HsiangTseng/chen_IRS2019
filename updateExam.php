<?php
	include("connects.php");
	
	$exam_title = $_POST['exam_title'];
	$exam_note = $_POST['exam_note'];
	$exam_teacher = $_POST['exam_teacher'];
	//$number_of_questions = $_POST['number_of_questions'];

	//echo $number_of_questions;

	$sql = "SELECT MAX(No) AS max FROM ExamList";
    $result = mysqli_fetch_object($db->query($sql));
    $max_number = $result->max;
    $max_number = $max_number+1;
    //get the new question's number.


	$sql2 = "INSERT INTO ExamList (No, ExamTitle, Teacher, Note) VALUES ('$max_number', '$exam_title', '$exam_teacher',  '$exam_note')";
	$db->query($sql2);

	$db->close();
	//echo $max_number.$exam_title;
    header ('location: ExamList.php');
    exit;


?>

<!DOCTYPE html>

<?php
session_start();
if($_SESSION['username'] == null)
{
        header ('location: IRS_Login.php');
        exit;
}
?>
