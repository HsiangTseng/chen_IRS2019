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

	  $a1_ext = end(explode('.', $_FILES['video_file']['name']));
	  $dest = 'upload/Q'.(string)$max_number.'.mp4';
	   # 將檔案移至指定位置
	   move_uploaded_file($file, $dest);
	  }
	else {
	  //echo '錯誤代碼：' . $_FILES['A1_file']['error'] . '<br/>';
	}


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
		$sql2 = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, picture_ext) VALUES ('$max_number', 'Q', '$CA', '$q1', 'VIDEO', '$single_or_multi', '$dest')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content) VALUES ('$max_number', 'A1', 'VIDEO', '$a1')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content) VALUES ('$max_number', 'A2', 'VIDEO', '$a2')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content) VALUES ('$max_number', 'A3', 'VIDEO', '$a3')";
		$db->query($sql2);

		$sql2 = "INSERT INTO QuestionList (No, QA, type, Content) VALUES ('$max_number', 'A4', 'VIDEO', '$a4')";
		$db->query($sql2);

		$db->close();

		echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";	
	}


?>

