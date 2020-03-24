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

	//---------------Question File------------------
	if ($_FILES['Q1_file']['error'] === UPLOAD_ERR_OK){

	$old_ext = $result->picture_ext;
	//IF HAVE OLD IMG, DELETE IT
	if(strlen($old_ext)>0)
	{
		$old_img_name = 'upload/Q'.(string)$question_number.'Q1.'.$old_ext;
		unlink($old_img_name);
	}

	$file = $_FILES['Q1_file']['tmp_name'];
	$q1_ext = end(explode('.', $_FILES['Q1_file']['name']));
	$dest = 'upload/Q'.(string)$question_number.'Q1.'.$q1_ext;
	move_uploaded_file($file, $dest);

	//update ext
	$sqlQuestion = "UPDATE QuestionList SET picture_ext='$q1_ext' WHERE No='$question_number'";
	$db->query($sqlQuestion);

	}
	else {
	}

	if ($_FILES['audio_file']['error'] === UPLOAD_ERR_OK){
		$old_audio = $result->audio;

		//IF HAVE OLD AUDIO, DELETE
		if(strlen($old_audio)>0)
		{
			unlink($old_audio);
		}

		$file = $_FILES['audio_file']['tmp_name'];
		$audio_dest = 'upload/Q'.(string)$question_number.'.mp3';
		# 將檔案移至指定位置
		move_uploaded_file($file, $audio_dest);

		//update audio
		$sqlQuestion = "UPDATE QuestionList SET audio='$audio_dest' WHERE No='$question_number'";
		$db->query($sqlQuestion);
		}
	else {
	}

	if ($_FILES['video_file']['error'] === UPLOAD_ERR_OK){
		$old_video = $result->video;

		//IF HAVE OLD VIDEO, DELETE
		if(strlen($old_video)>0)
		{
			unlink($old_video);
		}

		$file = $_FILES['video_file']['tmp_name'];

		$video_ext = end(explode('.', $_FILES['video_file']['name']));
		$video_dest = 'upload/Q'.(string)$question_number.'.'.$video_ext;
		# 將檔案移至指定位置
		move_uploaded_file($file, $video_dest);

		//update audio
		$sqlQuestion = "UPDATE QuestionList SET video='$video_dest' WHERE No='$question_number'";
		$db->query($sqlQuestion);
		}
	else {
		$video_dest = "";
	}
	//---------------Question File------------------

	$audio_ext_number = substr_count($Answer,"^&");
	$audio_ext_list = "N";
	if($audio_ext_number>0)
	{
		for($i=0;$i<$audio_ext_number;$i++)
		{
			$audio_ext_list = $audio_ext_list."-N";
		}
	}


  //UPDATE QUESTIONLIST DB
  $sqlQuestion = "UPDATE QuestionList SET CA = '$CA', Content = '$Q1', classification='$classification[0]' WHERE No='$question_number'";
  $db->query($sqlQuestion);

  //UPDATE KEYBOARD DB
	$sqlKeyboard = "UPDATE Keyboard SET wordQuestion = '$Answer', audio_ext='$audio_ext_list' WHERE KeyboardNo='$KeyboardNo'";
  $db->query($sqlKeyboard);


  echo "<script>alert('編輯完成'); location.href = 'QuestionList.php';</script>";


?>
