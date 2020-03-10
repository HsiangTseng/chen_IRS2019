<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");

  $question_number = $_POST['question_number'];

  $Answer = $_POST['Answer'];
  $Answer = implode ("^&", $Answer);

  $Q1 = $_POST['Q1'];
  $CA = $_POST['CA'];
  $classification = $_POST['classification'];

  $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'Q'";
  $result = mysqli_fetch_object($db->query($sql));
  $KeyboardNo = $result->KeyboardNo;

  //echo $question_number.$Q1.$CA.$KeyboardNo;
  //print_r($classification);
  //echo $Answer;


  //UPDATE QUESTIONLIST DB
  $sqlQuestion = "UPDATE QuestionList SET CA = '$CA', Content = '$Q1', classification='$classification[0]' WHERE No='$question_number'";
  $db->query($sqlQuestion);

  //UPDATE KEYBOARD DB
  $sqlKeyboard = "UPDATE Keyboard  SET wordQuestion = '$Answer' WHERE KeyboardNo='$KeyboardNo'";
  $db->query($sqlKeyboard);


  echo "<script>alert('編輯完成'); location.href = 'QuestionList.php';</script>";


?>
