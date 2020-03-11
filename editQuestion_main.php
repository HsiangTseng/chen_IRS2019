<!DOCTYPE html>

<?php

    session_start();

    if($_SESSION['username'] == null)
    {
            header ('location: IRS_Login.php');
            exit;
    }


    $question_number = $_GET['number'];

    include("connects.php");

    $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'Q'";
    $result = mysqli_fetch_object($db->query($sql));
    $single_or_multi = $result->single_or_multi;
    $type = $result->type;


    if($type=='WORD')
    {
        header("Location: editQuestion_word.php?ms=$single_or_multi&number=$question_number");
    }

    else if ($type=='PICTURE')
    {
        header("Location: editQuestion_picture.php?ms=$single_or_multi&number=$question_number");
    }

    else if ($type=='LWORD')
    {
        header("Location: editQuestion_logicWord.php?ms=$single_or_multi&number=$question_number");
    }

    else if ($type=='LPICTURE')
    {
        header("Location: editQuestion_logicPic.php?ms=$single_or_multi&number=$question_number");
    }

    else if ($type=='VIDEO')
    {
        header("Location: editQuestion_video.php?ms=$single_or_multi&number=$question_number");
    }

    else if ($type=='KEYBOARD')
    {
        $KeyboardNo = $result->KeyboardNo;
        header("Location: editQuestion_keyboard.php?ms=$single_or_multi&number=$question_number&KeyboardNo=$KeyboardNo");
    }





?>
