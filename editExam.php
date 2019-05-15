<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
    include("connects.php");
    
    $exam_number = $_POST['exam_num'];
    $a1 = $_POST['q1'];    
    $a2 = $_POST['q2'];
    $a3 = $_POST['q3'];    
    $a4 = $_POST['q4'];    
    $a5 = $_POST['q5'];    
    $a6 = $_POST['q6'];    
    $a7 = $_POST['q7'];    
    $a8 = $_POST['q8'];    
    $a9 = $_POST['q9'];    
    $a10 = $_POST['q10'];    

    $all = array();

    array_push($all,$a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8,$a9,$a10);
    $all = implode (",", $all);
    $all = preg_replace('/\s(?=)/', '', $all);
    $sql = "UPDATE `ExamList` SET `question_list`='$all' WHERE No = '$exam_number'";
    $db->query($sql);
    $db->close();
    echo "<script>alert('編輯結束'); location.href = 'ExamList.php';</script>";
?>

