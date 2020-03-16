<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");


	$Answer = $_POST['Answer'];
    $Answer = implode ("^&", $Answer);

    $Q1 = $_POST['Q1'];
    $CA = $_POST['CA'];
		$classification = $_POST['classification'];

        //edit block
    if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
    {
    	$tag = $_POST['edit_tag'];
    	$question_number = $_POST['question_number'];
    	$max_number = $question_number;
    	$KeyboardNo = $_POST['KeyboardNo'];
    }

    $sql = "SELECT MAX(KeyboardNo) AS max FROM Keyboard";
    $result = mysqli_fetch_object($db->query($sql));
    $KeyboardNumber = $result->max;
    $KeyboardNumber = $KeyboardNumber+1;
    //get the new question's number


	$sql = "SELECT MAX(No) AS max FROM QuestionList";
	$result = mysqli_fetch_object($db->query($sql));
	$max_number = $result->max;
	$max_number = $max_number+1;
    //if edit
	if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
	{

		$sqlKeyboard = "UPDATE Keyboard  SET wordQuestion = '$Answer' WHERE KeyboardNo='$KeyboardNo'";
		$db->query($sqlKeyboard);

		$sqlQuestion = "UPDATE QuestionList SET CA = '$CA', Content = '$Q1' WHERE KeyboardNo='$KeyboardNo'";
		$db->query($sqlQuestion);
		$db->close();

		echo "<script>alert('編輯成功'); location.href = 'QuestionList.php';</script>";

	}

	else // if not edit , means insert.
	{


		if ($_FILES['Q1_file']['error'] === UPLOAD_ERR_OK){
		$file = $_FILES['Q1_file']['tmp_name'];
		$q1_ext = end(explode('.', $_FILES['Q1_file']['name']));
		$dest = 'upload/Q'.(string)$max_number.'Q1.'.$q1_ext;
		 move_uploaded_file($file, $dest);
		}
		else {
			$q1_dest = '';
		}

		if ($_FILES['audio_file']['error'] === UPLOAD_ERR_OK){

			$file = $_FILES['audio_file']['tmp_name'];
			//$a1_ext = end(explode('.', $_FILES['audio_file']['name']));
			$audio_dest = 'upload/Q'.(string)$max_number.'.mp3';
			 # 將檔案移至指定位置
			 move_uploaded_file($file, $audio_dest);
			}
		else {
			$audio_dest = '';
		}

		$sqlKeyboard = "INSERT INTO Keyboard (KeyboardNo, type, wordQuestion) VALUES ('$KeyboardNumber', 'Logic', '$Answer')";
		$db->query($sqlKeyboard);

		$sqlQuestion = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo, classification, picture_ext, audio) VALUES ('$max_number', 'Q', '$CA', '$Q1', 'LWORD', 'MULTI', '$KeyboardNumber', '$classification[0]', '$q1_ext', '$audio_dest')";
		$db->query($sqlQuestion);
		$db->close();

		echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";
	}





?>
