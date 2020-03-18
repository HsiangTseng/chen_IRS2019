<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");

	$keyboardNo =$_POST['KeyboardNo'];
	$q1 = $_POST['Q1'];

	$sql = "SELECT MAX(No) AS max FROM QuestionList";
  $result = mysqli_fetch_object($db->query($sql));
  $max_number = $result->max;
  $max_number = $max_number+1;
  //get the new question's number.
  $CA = $_POST['answer'];
  $CA = implode (",", $CA);
	$classification = $_POST['classification'];


	//---------------Question File------------------
	if ($_FILES['Q1_file']['error'] === UPLOAD_ERR_OK){
	$file = $_FILES['Q1_file']['tmp_name'];
	$q1_ext = end(explode('.', $_FILES['Q1_file']['name']));
	$dest = 'upload/Q'.(string)$max_number.'Q1.'.$q1_ext;
	 move_uploaded_file($file, $dest);
	}
	else {
		$q1_ext = '';
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

	if ($_FILES['video_file']['error'] === UPLOAD_ERR_OK){
		$file = $_FILES['video_file']['tmp_name'];

		$video_ext = end(explode('.', $_FILES['video_file']['name']));
		$video_dest = 'upload/Q'.(string)$max_number.'.'.$video_ext;
		# 將檔案移至指定位置
		move_uploaded_file($file, $video_dest);
		}
	else {
		$video_dest = "";
	}
	//---------------Question File------------------



  $sql2 = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo, classification, picture_ext, audio, video) VALUES ('$max_number', 'Q', '$CA', '$q1', 'KEYBOARD', 'MULTI', '$keyboardNo', '$classification[0]', '$q1_ext', '$audio_dest', '$video_dest')";
	$db->query($sql2);


	$db->close();

	echo "<script>alert('出題成功'); location.href = 'KeyboardSite.php';</script>";



?>
