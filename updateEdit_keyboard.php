<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
  $question_number = $_POST['question_number'];
	$keyboardNo =$_POST['KeyboardNo'];
	$q1 = $_POST['Q1'];

  $CA = $_POST['answer'];
  $CA = implode (",", $CA);
	$classification = $_POST['classification'];

/*
  echo 'Q--'.$question_number.'<br />';
  echo 'KEYBOARD--'.$keyboardNo.'<br />';
  echo $q1.'<br />';
  echo $CA.'<br />';
  echo $classification[0];
*/
  //UPDATE DATA
  $sql = "UPDATE QuestionList SET CA = '$CA', Content='$q1', KeyboardNo='$keyboardNo', classification='$classification[0]' WHERE No = '$question_number' AND QA = 'Q'";
  $db->query($sql);
  $db->close();
  echo "<script>alert('編輯成功'); location.href = 'QuestionList.php';</script>";

?>
