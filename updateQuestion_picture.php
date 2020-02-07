<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");

	$q1 = $_POST['Q1'];
	$a1_alt = $_POST['A1_alt'];
	$a2_alt = $_POST['A2_alt'];
	$a3_alt = $_POST['A3_alt'];
	$a4_alt = $_POST['A4_alt'];
	$q1_alt = $_POST['Q1_alt'];
	$CA = $_POST['answer'];
	$CA = implode (",", $CA);
	$single_or_multi = $_POST['single_or_multi'];
	$classification = $_POST['classification'];

	$sql = "SELECT MAX(No) AS max FROM QuestionList";
    $result = mysqli_fetch_object($db->query($sql));
    $max_number = $result->max;
    $max_number = $max_number+1;
    //get the new question's number.

    //edit block
    if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
    {
    	$tag = $_POST['edit_tag'];
    	$question_number = $_POST['question_number'];
    	$max_number = $question_number;


    	// if edit , must DELETE OLD FILE first!!!
    	$sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'A1'";
        $result = mysqli_fetch_object($db->query($sql));
        $ext = $result->picture_ext;
        unlink('upload/Q'.$question_number.'A1.'.$ext);

    	$sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'A2'";
        $result = mysqli_fetch_object($db->query($sql));
        $ext = $result->picture_ext;
        unlink('upload/Q'.$question_number.'A2.'.$ext);

        $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'A3'";
        $result = mysqli_fetch_object($db->query($sql));
        $ext = $result->picture_ext;
        unlink('upload/Q'.$question_number.'A3.'.$ext);

        $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'A4'";
        $result = mysqli_fetch_object($db->query($sql));
        $ext = $result->picture_ext;
        unlink('upload/Q'.$question_number.'A4.'.$ext);

    }




	if ($_FILES['audio_file']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['audio_file']['tmp_name'];
	  $a1_ext = end(explode('.', $_FILES['audio_file']['name']));
	  $audio_dest = 'upload/Q'.(string)$max_number.'.mp3';
	   move_uploaded_file($file, $audio_dest);
	  }
	else {
		$audio_dest = '';
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

	//---------WMF Covert to JPG--------------
	include("convert_wmf.php");
	if($q1_ext=="wmf")
	{
		$name = 'Q'.(string)$max_number.'Q1';
		convert_wmf($name);
		$q1_ext="jpg";
	}
	if($a1_ext=="wmf")
	{
		$name = 'Q'.(string)$max_number.'A1';
		convert_wmf($name);
		$a1_ext="jpg";
	}
	if($a2_ext=="wmf")
	{
		$name = 'Q'.(string)$max_number.'A2';
		convert_wmf($name);
		$a2_ext="jpg";
	}
	if($a3_ext=="wmf")
	{
		$name = 'Q'.(string)$max_number.'A3';
		convert_wmf($name);
		$a3_ext="jpg";
	}
	if($a4_ext=="wmf")
	{
		$name = 'Q'.(string)$max_number.'A4';
		convert_wmf($name);
		$a4_ext="jpg";
	}

	//---------WMF Covert to JPG--------------



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

	if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
	{
		$sql2 = "UPDATE QuestionList SET CA='$CA', Content='$q1' WHERE No = '$question_number' AND QA='Q' ";
		$db->query($sql2);

		$sql2 = "UPDATE QuestionList SET picture_alt='$a1_alt', picture_ext='$a1_ext' WHERE No = '$question_number' AND QA='A1' ";
		$db->query($sql2);

		$sql2 = "UPDATE QuestionList SET picture_alt='$a2_alt', picture_ext='$a2_ext' WHERE No = '$question_number' AND QA='A2' ";
		$db->query($sql2);

		$sql2 = "UPDATE QuestionList SET picture_alt='$a3_alt', picture_ext='$a3_ext' WHERE No = '$question_number' AND QA='A3' ";
		$db->query($sql2);

		$sql2 = "UPDATE QuestionList SET picture_alt='$a4_alt', picture_ext='$a4_ext' WHERE No = '$question_number' AND QA='A4' ";
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

		$sql2 = "INSERT INTO QuestionList (No, QA, CA, Content, picture_alt, picture_ext, type, single_or_multi, audio, classification) VALUES ('$max_number', 'Q', '$CA', '$q1', '$q1_alt', '$q1_ext', 'PICTURE', '$single_or_multi', '$audio_dest', '$classification[0]')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA,  type, picture_alt, picture_ext, audio, classification) VALUES ('$max_number', 'A1', 'PICTURE', '$a1_alt' ,'$a1_ext', '$audio_A1', '0')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA,  type, picture_alt, picture_ext, audio, classification) VALUES ('$max_number', 'A2', 'PICTURE', '$a2_alt' ,'$a2_ext', '$audio_A2', '0')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA,  type, picture_alt, picture_ext, audio, classification) VALUES ('$max_number', 'A3', 'PICTURE', '$a3_alt' ,'$a3_ext', '$audio_A3', '0')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA,  type, picture_alt, picture_ext, audio, classification) VALUES ('$max_number', 'A4', 'PICTURE', '$a4_alt' ,'$a4_ext', '$audio_A4', '0')";
		$db->query($sql2);
		$db->close();

		//echo $max_number.$a1_ext.$a1_alt;
		echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";
	}

/*
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
*/
?>
