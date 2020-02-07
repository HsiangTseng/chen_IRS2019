<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");

	$q1 = $_POST['Q1'];
	$a1 = $_POST['A1'];
	$a2 = $_POST['A2'];
	$a3 = $_POST['A3'];
	$a4 = $_POST['A4'];
	$a1_alt = $_POST['a1_alt'];
	$a2_alt = $_POST['a2_alt'];
	$a3_alt = $_POST['a3_alt'];
	$a4_alt = $_POST['a4_alt'];
	$CA = $_POST['answer'];
	$classification = $_POST['classification'];

    $CA = implode (",", $CA);
    $single_or_multi = $_POST['single_or_multi'];

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

    	$sql = "SELECT * FROM QuestionList WHERE No = '$max_number'";
    	$result = mysqli_fetch_object($db->query($sql));
    	$ext = $result->picture_ext;

    	// if edit , must DELETE OLD FILE first!!!
    	unlink($ext);
    }


	if ($_FILES['video_file']['error'] === UPLOAD_ERR_OK){
	  //echo '檔案名稱: ' . $_FILES['A1_file']['name'] . '<br/>';
	  //echo '檔案類型: ' . $_FILES['A1_file']['type'] . '<br/>';
	  //echo '檔案大小: ' . ($_FILES['A1_file']['size'] / 1024) . ' KB<br/>';
	  //echo '暫存名稱: ' . $_FILES['A1_file']['tmp_name'] . '<br/>';

	  $file = $_FILES['video_file']['tmp_name'];

	  $video_ext = end(explode('.', $_FILES['video_file']['name']));
	  $video_dest = 'upload/Q'.(string)$max_number.'.'.$video_ext;
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $video_dest);
	  }
	else {
	  //echo '錯誤代碼：' . $_FILES['A1_file']['error'] . '<br/>';
	}


	if ($_FILES['a1_file']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['a1_file']['tmp_name'];
	  $a1_ext = end(explode('.', $_FILES['a1_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'A1.'.$a1_ext;
	   move_uploaded_file($file, $dest);
	  }
	else {
	}

	if ($_FILES['a2_file']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['a2_file']['tmp_name'];
	  $a2_ext = end(explode('.', $_FILES['a2_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'A2.'.$a2_ext;
	   move_uploaded_file($file, $dest);
	  }
	else {
	}

	if ($_FILES['a3_file']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['a3_file']['tmp_name'];
	  $a3_ext = end(explode('.', $_FILES['a3_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'A3.'.$a3_ext;
	   move_uploaded_file($file, $dest);
	  }
	else {
	}

	if ($_FILES['a4_file']['error'] === UPLOAD_ERR_OK){

	  $file = $_FILES['a4_file']['tmp_name'];
	  $a4_ext = end(explode('.', $_FILES['a4_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'A4.'.$a4_ext;
	   move_uploaded_file($file, $dest);
	  }
	else {
	}
	//---------WMF Covert to JPG--------------
	include("convert_wmf.php");
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



	// if edit
	if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
	{
		$sql2 = "UPDATE QuestionList SET CA='$CA', Content='$q1', picture_ext='$dest' WHERE No = '$question_number' AND QA='Q' ";
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

	else //insert
	{
		$sql2 = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, picture_ext, classification) VALUES ('$max_number', 'Q', '$CA', '$q1', 'VIDEO', '$single_or_multi', '$video_dest', '$classification[0]')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content, picture_alt, picture_ext, classification) VALUES ('$max_number', 'A1', 'VIDEO', '$a1', '$a1_alt', '$a1_ext', '0')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content, picture_alt, picture_ext, classification) VALUES ('$max_number', 'A2', 'VIDEO', '$a2', '$a2_alt', '$a2_ext', '0')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content, picture_alt, picture_ext, classification) VALUES ('$max_number', 'A3', 'VIDEO', '$a3', '$a3_alt', '$a3_ext', '0')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content, picture_alt, picture_ext, classification) VALUES ('$max_number', 'A4', 'VIDEO', '$a4', '$a4_alt', '$a4_ext', '0')";
		$db->query($sql2);

		$db->close();

		echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";
	}
	echo $a1_alt.$a1_ext.$a2_alt.$a2_ext.$a3_alt.$a3_ext.$a4_alt.$a4_ext;


?>
