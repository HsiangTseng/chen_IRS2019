<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
	
	$q1 = $_POST['Q1'];
	$a1_alt = $_POST['A1_alt'];
	$a2_alt = $_POST['A2_alt'];
	$a3_alt = $_POST['A3_alt'];
	$a4_alt = $_POST['A4_alt'];
	$CA = $_POST['answer'];
	$CA = implode (",", $CA);
	$single_or_multi = $_POST['single_or_multi'];

	$sql = "SELECT MAX(No) AS max FROM QuestionList";
    $result = mysqli_fetch_object($db->query($sql));
    $max_number = $result->max;
    $max_number = $max_number+1;
    //get the new question's number.

	if ($_FILES['audio_file']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['audio_file']['tmp_name'];
	  $a1_ext = end(explode('.', $_FILES['audio_file']['name']));
	  $audio_dest = 'upload/Q'.(string)$max_number.'.mp3';
	   move_uploaded_file($file, $audio_dest);
	  }
	else {
		$audio_dest = '';
	}

	if ($_FILES['A1_file']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['A1_file']['tmp_name'];
	  $a1_ext = end(explode('.', $_FILES['A1_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'A1.'.$a1_ext;
	   move_uploaded_file($file, $dest);
	  }
	else {
	}

	if ($_FILES['A2_file']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['A2_file']['tmp_name'];
	  $a2_ext = end(explode('.', $_FILES['A2_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'A2.'.$a2_ext;
	   move_uploaded_file($file, $dest);
	  }
	else {
	}

	if ($_FILES['A3_file']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['A3_file']['tmp_name'];
	  $a3_ext = end(explode('.', $_FILES['A3_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'A3.'.$a3_ext;
	   move_uploaded_file($file, $dest);
	  }
	else {
	}

	if ($_FILES['A4_file']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['A4_file']['tmp_name'];
	  $a4_ext = end(explode('.', $_FILES['A4_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'A4.'.$a4_ext;
	   move_uploaded_file($file, $dest);
	  }
	else {
	}



	// AUDIO
	if ($_FILES['audio_A1']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['audio_A1']['tmp_name'];

	  $a1_aext = end(explode('.', $_FILES['audio_A1']['name']));
	  $audio_A1 = 'upload/Q'.(string)$max_number.'A1.mp3';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $audio_A1);
	  }
	else {
		$audio_A1 = '';
	}

	if ($_FILES['audio_A2']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['audio_A2']['tmp_name'];

	  $a2_aext = end(explode('.', $_FILES['audio_A2']['name']));
	  $audio_A2 = 'upload/Q'.(string)$max_number.'A2.mp3';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $audio_A2);
	  }
	else {
		$audio_A2 = '';
	}

	if ($_FILES['audio_A3']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['audio_A3']['tmp_name'];

	  $a3_aext = end(explode('.', $_FILES['audio_A3']['name']));
	  $audio_A3 = 'upload/Q'.(string)$max_number.'A3.mp3';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $audio_A3);
	  }
	else {
		$audio_A3 = '';
	}

	if ($_FILES['audio_A4']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['audio_A4']['tmp_name'];

	  $a4_aext = end(explode('.', $_FILES['audio_A4']['name']));
	  $audio_A4 = 'upload/Q'.(string)$max_number.'A4.mp3';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $audio_A4);
	  }
	else {
		$audio_A4 = '';
	}


	$sql2 = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, audio) VALUES ('$max_number', 'Q', '$CA', '$q1', 'PICTURE', '$single_or_multi', '$audio_dest')";
	$db->query($sql2);

	$sql2 = "INSERT INTO QuestionList (No, QA,  type, picture_alt, picture_ext, audio) VALUES ('$max_number', 'A1', 'PICTURE', '$a1_alt' ,'$a1_ext', '$audio_A1')";
	$db->query($sql2);

	$sql2 = "INSERT INTO QuestionList (No, QA,  type, picture_alt, picture_ext, audio) VALUES ('$max_number', 'A2', 'PICTURE', '$a2_alt' ,'$a2_ext', '$audio_A2')";
	$db->query($sql2);

	$sql2 = "INSERT INTO QuestionList (No, QA,  type, picture_alt, picture_ext, audio) VALUES ('$max_number', 'A3', 'PICTURE', '$a3_alt' ,'$a3_ext', '$audio_A3')";
	$db->query($sql2);

	$sql2 = "INSERT INTO QuestionList (No, QA,  type, picture_alt, picture_ext, audio) VALUES ('$max_number', 'A4', 'PICTURE', '$a4_alt' ,'$a4_ext', '$audio_A4')";
	$db->query($sql2);






	$db->close();

	echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";
?>

