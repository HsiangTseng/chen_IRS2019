<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
  include("convert_wmf.php");

  $KeyboardNo = $_POST['KeyboardNo'];
  $KeyboardName = $_POST['KeyboardName'];

  //echo $KeyboardNo.$KeyboardName;
  $sql = "UPDATE Keyboard SET KeyboardName='$KeyboardName' WHERE KeyboardNo = '$KeyboardNo' ";
  $db->query($sql);

  $sql = "SELECT * FROM Keyboard WHERE KeyboardNo = '$KeyboardNo' ";
  $result = mysqli_fetch_object($db->query($sql));
  $old_ext = $result->ext;
	$KeyboardStyle = $result->Style;

  $ext_array = explode("-",$old_ext);

	$img_number = 0;
	if($KeyboardStyle=="A")$img_number=8;
	else if($KeyboardStyle=="B")$img_number=40;
	else if($KeyboardStyle=="C")$img_number=16;
	else if($KeyboardStyle=="D")$img_number=24;

	/*print_r($ext_array);
	echo '<br />'.$KeyboardStyle;
	echo $img_number;*/

	for($i = 0 ; $i < $img_number ; $i++)
	{
		$file_name = "file".$i;
		$A_index = $i+1;


		if ($_FILES[$file_name]['error'] === UPLOAD_ERR_OK){

			// KEYBOARD MUST HAVE OLD PICTURE, SO DELETE OLD ONE
			$old_name = 'upload/K'.$KeyboardNo.'A'.$A_index.'.'.$ext_array[$i];
			unlink($old_name);

			//UPLOAD
			$file = $_FILES[$file_name]['tmp_name'];
			$ext = end(explode('.', $_FILES[$file_name]['name']));
			$dest = 'upload/K'.(string)$KeyboardNo.'A'.$A_index.'.'.$ext;
			move_uploaded_file($file, $dest);

			if($ext=="wmf")
			{
				$name = 'K'.(string)$KeyboardNo.'A'.$A_index;
				convert_wmf($name);
				$ext="jpg";
				unlink('upload/K'.$KeyboardNo.'A'.$A_index.'.wmf');
			}
			$ext_array[$i] = $ext;
		}
	}

  $final_ext = implode("-",$ext_array);
  //echo $old_ext.'<br />';
  //echo $final_ext;




  //UPDATE ext
  $sql = "UPDATE Keyboard SET ext='$final_ext' WHERE KeyboardNo = '$KeyboardNo' ";
  $db->query($sql);

  echo "<script>alert('編輯成功'); location.href = 'editKeyboard.php';</script>";
?>
