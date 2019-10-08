<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
	
	$q1 = $_POST['Q1'];
	$a1 = $_POST['A1'];
	$a2 = $_POST['A2'];
	$a3 = $_POST['A3'];
	$a4 = $_POST['A4'];
	$CA = $_POST['answer'];
    $CA = implode (",", $CA);
    $q1_alt = $_POST['Q1_alt'];
    //echo $q1_alt;
    if(is_null($q1_alt) || empty($q1_alt))
    {
    	$q1_alt='';
    }
    $single_or_multi = $_POST['single_or_multi'];

	$sql = "SELECT MAX(No) AS max FROM QuestionList";
    $result = mysqli_fetch_object($db->query($sql));
    $max_number = $result->max;
    $max_number = $max_number+1;
    //get the new question's number


    //edit block
    if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
    {
    	$tag = $_POST['edit_tag'];
    	$question_number = $_POST['question_number'];
    	$max_number = $question_number;
    }


    //Q1 PICTURE
    if ($_FILES['Q1_file']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['Q1_file']['tmp_name'];
	  $q1_ext = end(explode('.', $_FILES['Q1_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'Q1.'.$q1_ext;
	   move_uploaded_file($file, $dest);
	  }
	else {
	}
		//---------WMF Covert to JPG--------------
	include("convert_wmf.php");
	if($q1_ext=="wmf")
	{
		$name = 'Q'.(string)$max_number.'Q1';
		convert_wmf($name);
		$q1_ext="jpg";
	}
	//---------WMF Covert to JPG--------------
    



	if ($_FILES['audio_file']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['audio_file']['tmp_name'];
	  $a1_ext = end(explode('.', $_FILES['audio_file']['name']));
	  $audio_dest = 'upload/Q'.(string)$max_number.'.mp3';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $audio_dest);
	  }
	else {
		$audio_dest = '';
	}

	if ($_FILES['audio_A1']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['audio_A1']['tmp_name'];

	  $a1_ext = end(explode('.', $_FILES['audio_A1']['name']));
	  $audio_A1 = 'upload/Q'.(string)$max_number.'A1.mp3';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $audio_A1);
	  }
	else {
		$audio_A1 = '';
	}

	if ($_FILES['audio_A2']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['audio_A2']['tmp_name'];

	  $a1_ext = end(explode('.', $_FILES['audio_A2']['name']));
	  $audio_A2 = 'upload/Q'.(string)$max_number.'A2.mp3';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $audio_A2);
	  }
	else {
		$audio_A2 = '';
	}

	if ($_FILES['audio_A3']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['audio_A3']['tmp_name'];

	  $a1_ext = end(explode('.', $_FILES['audio_A3']['name']));
	  $audio_A3 = 'upload/Q'.(string)$max_number.'A3.mp3';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $audio_A3);
	  }
	else {
		$audio_A3 = '';
	}

	if ($_FILES['audio_A4']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['audio_A4']['tmp_name'];

	  $a1_ext = end(explode('.', $_FILES['audio_A4']['name']));
	  $audio_A4 = 'upload/Q'.(string)$max_number.'A4.mp3';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $audio_A4);
	  }
	else {
		$audio_A4 = '';
	}



	// if edit
	if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
	{
		$sql2 = "UPDATE QuestionList SET CA='$CA', Content='$q1' WHERE No = '$question_number' AND QA='Q' ";
		$db->query($sql2);

		$sql2 = "UPDATE QuestionList SET Content='$a1' WHERE No = '$question_number' AND QA='A1' ";
		$db->query($sql2);	

		$sql2 = "UPDATE QuestionList SET Content='$a2' WHERE No = '$question_number' AND QA='A2' ";
		$db->query($sql2);	

		$sql2 = "UPDATE QuestionList SET Content='$a3' WHERE No = '$question_number' AND QA='A3' ";
		$db->query($sql2);	

		$sql2 = "UPDATE QuestionList SET Content='$a4' WHERE No = '$question_number' AND QA='A4' ";
		$db->query($sql2);	
		$db->close();
		echo "<script>alert('編輯成功'); location.href = 'QuestionList.php';</script>";

	}

	else // if not edit , means insert.
	{
		if(empty($q1_ext)||is_null($q1_ext))
		{
			$q1_ext = '';//if no image, init the q1_ext
		}
		//echo $max_number;
		$sql2 = "INSERT INTO QuestionList (No, QA, CA, Content, picture_alt, picture_ext, type, single_or_multi, audio) VALUES ('$max_number', 'Q', '$CA', '$q1', '$q1_alt', '$q1_ext', 'WORD', '$single_or_multi', '$audio_dest')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content, audio) VALUES ('$max_number', 'A1', 'WORD', '$a1', '$audio_A1')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content, audio) VALUES ('$max_number', 'A2', 'WORD', '$a2', '$audio_A2')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content, audio) VALUES ('$max_number', 'A3', 'WORD', '$a3', '$audio_A3')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content, audio) VALUES ('$max_number', 'A4', 'WORD', '$a4', '$audio_A4')";
		$db->query($sql2);
		$db->close();
		echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";
	}

	

?>

