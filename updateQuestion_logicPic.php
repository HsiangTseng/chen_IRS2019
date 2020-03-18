<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
		include("connects.php");
    include("convert_wmf.php");



    $Q1 = $_POST['Q1'];
    $CA = $_POST['CA'];
    $number = $_POST['picture_number'];
		$classification = $_POST['classification'];
		$OriginOrKeyboard = $_POST['OriginOrKeyboard'];

		$sql = "SELECT MAX(No) AS max FROM QuestionList";
		$result = mysqli_fetch_object($db->query($sql));
		$max_number = $result->max;
		$max_number = $max_number+1;
		//get the new question's number

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

		if($OriginOrKeyboard=="Origin")
		{
			//echo $number;
			$sql = "SELECT MAX(KeyboardNo) AS max FROM Keyboard";
	    $result = mysqli_fetch_object($db->query($sql));
	    $KeyboardNumber = $result->max;
	    $KeyboardNumber = $KeyboardNumber+1;
	    //get the new question's number

			$ext = array();

	    for ($i=1; $i<=$number ; $i++ )
	    {
	    	$name = 'A'.$i.'_file';
	    	$n = 'A'.$i;
		    if ($_FILES[$name]['error'] === UPLOAD_ERR_OK){
			  $file = $_FILES[$name]['tmp_name'];
			  $ext[$i] = end(explode('.', $_FILES[$name]['name']));
			  $dest = 'upload/K'.(string)$KeyboardNumber.$n.'.'.$ext[$i];
			   move_uploaded_file($file, $dest);
			  }
				else {
				}

        //---------WMF Covert to JPG--------------
        if($ext[$i]=="wmf")
        {
            $name = 'K'.(string)$KeyboardNumber.$n;
            convert_wmf($name);
            $ext[$i]="jpg";
        }
        //---------WMF Covert to JPG--------------
	    }

	    $ext_string = $ext[1];
	    for($i=2;$i<=$number;$i++)
	    {
	    	$ext_string = $ext_string.'-'.$ext[$i];
	    }

	    $sql2 = "INSERT INTO Keyboard (KeyboardNo,type, ext) VALUES ('$KeyboardNumber', 'Logic', '$ext_string')";
	    $db->query($sql2);

	    $sqlQuestion = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo, classification, picture_ext, audio, video) VALUES ('$max_number', 'Q', '$CA', '$Q1', 'LPICTURE', 'MULTI', '$KeyboardNumber', '$classification[0]', '$q1_ext', '$audio_dest', '$video_dest')";
	    $db->query($sqlQuestion);
		}
		else if($OriginOrKeyboard=="Keyboard")
		{
			$KeyboardNo = $_POST['KeyboardNo'];
			//echo $KeyboardNo;
			$sql = "SELECT MAX(No) AS max FROM QuestionList";
	    $result = mysqli_fetch_object($db->query($sql));
	    $max_number = $result->max;
	    $max_number = $max_number+1;
	    //get the new question's number

			$sqlQuestion = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo, classification, picture_ext, audio, video) VALUES ('$max_number', 'Q', '$CA', '$Q1', 'LPICTURE', 'MULTI', '$KeyboardNo', '$classification[0]', '$q1_ext', '$audio_dest', '$video_dest')";
	    $db->query($sqlQuestion);

		}

/*
    $sql = "SELECT MAX(KeyboardNo) AS max FROM Keyboard";
    $result = mysqli_fetch_object($db->query($sql));
    $KeyboardNumber = $result->max;
    $KeyboardNumber = $KeyboardNumber+1;
    //get the new question's number

    $sql = "SELECT MAX(No) AS max FROM QuestionList";
    $result = mysqli_fetch_object($db->query($sql));
    $max_number = $result->max;
    $max_number = $max_number+1;
    //get the new question's number

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


    $ext = array();

    for ($i=1; $i<=$number ; $i++ )
    {
    	$name = 'A'.$i.'_file';
    	$n = 'A'.$i;
	    if ($_FILES[$name]['error'] === UPLOAD_ERR_OK){
		  $file = $_FILES[$name]['tmp_name'];
		  $ext[$i] = end(explode('.', $_FILES[$name]['name']));
		  $dest = 'upload/K'.(string)$KeyboardNumber.$n.'.'.$ext[$i];
		   move_uploaded_file($file, $dest);
		  }
		else {
		}

        //---------WMF Covert to JPG--------------
        if($ext[$i]=="wmf")
        {
            $name = 'K'.(string)$KeyboardNumber.$n;
            convert_wmf($name);
            $ext[$i]="jpg";
        }
        //---------WMF Covert to JPG--------------
    }

    $ext_string = $ext[1];
    for($i=2;$i<=$number;$i++)
    {
    	$ext_string = $ext_string.'-'.$ext[$i];
    }

    $sql2 = "INSERT INTO Keyboard (KeyboardNo,type, ext) VALUES ('$KeyboardNumber', 'Logic', '$ext_string')";
    $db->query($sql2);

    $sqlQuestion = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo, classification, picture_ext, audio, video) VALUES ('$max_number', 'Q', '$CA', '$Q1', 'LPICTURE', 'MULTI', '$KeyboardNumber', '$classification[0]', '$q1_ext', '$audio_dest', '$video_dest')";
    $db->query($sqlQuestion);
    $db->close();

    echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";




*/

?>
