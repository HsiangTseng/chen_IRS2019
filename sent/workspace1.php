<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
	include("convert_wmf.php");

	$keyboardName = $_POST['KeyboardName'];
  $picture_number = $_POST['picture_number'];
  $Keyboard_Style = $_POST['Keyboard_Style'];

	$sql = "SELECT MAX(KeyboardNo) AS max FROM Keyboard";
  $result = mysqli_fetch_object($db->query($sql));
  $max_number = $result->max;
  $max_number = $max_number+1;
  //get the new question's number.

  /*echo 'K->>'.$max_number.'<br />';
  echo 'Name->>'.$keyboardName.'<br />';
  echo 'picture_number->>'.$picture_number.'<br />';
  echo 'STYLE->>'.$Keyboard_Style.'<br />';*/

  $ext_list = "";

  if ($_FILES['file0']['error'] === UPLOAD_ERR_OK){
	  $file = $_FILES['file0']['tmp_name'];
	  $ext = end(explode('.', $_FILES['file0']['name']));
	  $dest = 'upload/K'.(string)$max_number.'A1.'.$ext;
	  move_uploaded_file($file, $dest);


		//WMF
		if($ext=="wmf")
		{
			$name = 'K'.(string)$max_number.'A1';
			convert_wmf($name);
			$ext="jpg";
			$wmf_name = 'upload/K'.(string)$max_number.'A1.wmf';
			unlink($wmf_name);
		}
		$ext_list = $ext;
	  }
	else {
	}

  for($i = 1; $i < $picture_number ; $i++)
  {
    $file_name = "file".$i;

    if ($_FILES[$file_name]['error'] === UPLOAD_ERR_OK){
  	  $file = $_FILES[$file_name]['tmp_name'];
  	  $ext = end(explode('.', $_FILES[$file_name]['name']));
      $A_index = $i+1;
  	  $dest = 'upload/K'.(string)$max_number.'A'.$A_index.'.'.$ext;
  	  move_uploaded_file($file, $dest);

			//WMF
			if($ext=="wmf")
			{
				$name = 'K'.(string)$max_number.'A'.$A_index;
				convert_wmf($name);
				$ext="jpg";
				$wmf_name = 'upload/K'.(string)$max_number.'A'.$A_index.'.wmf';
				unlink($wmf_name);
			}


      $ext_list = $ext_list.'-'.$ext;
  	  }
  	else {
    }
  }

  $sql2 = "INSERT INTO Keyboard (KeyboardNo, KeyboardName, type, ext, Style) VALUES ('$max_number', '$keyboardName', 'Keyboard', '$ext_list', '$Keyboard_Style')";
	$db->query($sql2);

  echo "<script>alert('建立鍵盤成功'); location.href = 'KeyboardSite.php';</script>"  ;
?>
