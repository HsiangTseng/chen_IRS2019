<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
	


    $Q1 = $_POST['Q1'];
    $CA = $_POST['CA'];
    $number = $_POST['picture_number'];


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

    $ext = array();


    for ($i=1; $i<=$number ; $i++ )
    {
    	$name = 'A'.$i.'_file';
    	$n = 'A'.$i;
	    if ($_FILES[$name]['error'] === UPLOAD_ERR_OK){
		  $file = $_FILES[$name]['tmp_name'];
		  $ext[$i] = end(explode('.', $_FILES[$name]['name']));
		  $dest = 'upload/K'.(string)$max_number.$n.'.'.$ext[$i];
		   move_uploaded_file($file, $dest);
		  }
		else {
		}
    }

    $ext_string = $ext[1];
    for($i=2;$i<=$number;$i++)
    {
    	$ext_string = $ext_string.'-'.$ext[$i];
    }
    $sql2 = "INSERT INTO Keyboard (KeyboardNo,type, ext) VALUES ('$KeyboardNumber', 'Logic', '$ext_string')";
	$db->query($sql2);

	$sqlQuestion = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo) VALUES ('$max_number', 'Q', '$CA', '$Q1', 'LPICTURE', 'MULTI', '$KeyboardNumber')";
	$db->query($sqlQuestion);
	$db->close();

	echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";

	
?>

