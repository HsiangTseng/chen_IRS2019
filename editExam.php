<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
    include("connects.php");

    $exam_number = $_POST['exam_num'];
    $question = $_POST['q1'];
    $question_count = $_POST['exercise_number'];

    $exam_title = $_POST['ExamTitle'];
    $note = $_POST['Note'];
    $teacher = $_POST['Teacher'];

    //echo $exam_title.$note.$teacher;
    //print_r($question);
    //echo $question_count;

    $question_list = "";
    $question_list = $question[0];
    for ($i = 1 ; $i < $question_count ; $i++)
    {
      $question_list = trim($question_list).",".trim($question[$i]);
    }

    //echo $question_list;

    $sql = "UPDATE `ExamList` SET question_list='$question_list', ExamTitle='$exam_title', Note='$note', Teacher='$teacher' WHERE No = '$exam_number'";
    $db->query($sql);
    $db->close();
    echo "<script>alert('編輯結束'); location.href = 'ExamList.php';</script>";
?>
