<?php

include("connects.php");
$number = $_GET['number'];

$sqlQuestion = "UPDATE QuestionList SET status='0' WHERE No='$number'";
$db->query($sqlQuestion);
$db->close();
echo "<script>alert('題目已刪除'); location.href = 'QuestionList.php';</script>";
?>
