<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");

  $question_number = $_POST['question_number'];


  $Q1 = $_POST['Q1'];
  $CA = $_POST['CA'];
  $classification = $_POST['classification'];
  $picture_number = $_POST['picture_number'];

  $sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'Q'";
  $result = mysqli_fetch_object($db->query($sql));
  $KeyboardNo = $result->KeyboardNo;

  //UPDATE QUESTIONLIST DB
  $sqlQuestion = "UPDATE QuestionList SET CA = '$CA', Content = '$Q1', classification='$classification[0]' WHERE No='$question_number'";
  $db->query($sqlQuestion);


  $sql = "SELECT * FROM Keyboard WHERE KeyboardNo = '$KeyboardNo'";
  $result = mysqli_fetch_object($db->query($sql));
  $old_ext = $result->ext;
  $old_ext = explode("-", $old_ext);
  $old_count = count($old_ext);
  include("convert_wmf.php");
  for($i = 1 ; $i <= $picture_number ; $i++)
  {
    $name = 'A'.$i.'_file';
    $n = 'A'.$i;
    if ($_FILES[$name]['error'] === UPLOAD_ERR_OK){
    //CHECK IF THERE ARE OLD IMG
    $array_index = $i-1;

    //IF OLD IMG EXIST
    if(isset($old_ext[$array_index]))
    {
      // HAVE OLD FILE, DELETE
      $old_file_name = 'upload/K'.$KeyboardNo.'A'.$i.'.'.$old_ext[$array_index];
      unlink($old_file_name);

      //UPLOAD
      $file = $_FILES[$name]['tmp_name'];
      $new_ext = end(explode('.', $_FILES[$name]['name']));
      $dest = 'upload/K'.(string)$KeyboardNo.$n.'.'.$new_ext;
      move_uploaded_file($file, $dest);

      if($new_ext=="wmf")
    	{
    		$name = 'K'.(string)$KeyboardNo.$n;
    		convert_wmf($name);
    		$new_ext="jpg";
        unlink('upload/K'.(string)$KeyboardNo.$n.'.wmf');
    	}

      //CHANGE THE EXT ARRAY
      $old_ext[$array_index] = $new_ext;
    }
    else
    {
      //UPLOAD
      $file = $_FILES[$name]['tmp_name'];
      $new_ext = end(explode('.', $_FILES[$name]['name']));
      $dest = 'upload/K'.(string)$KeyboardNo.$n.'.'.$new_ext;
      move_uploaded_file($file, $dest);

      if($new_ext=="wmf")
    	{
    		$name = 'K'.(string)$KeyboardNo.$n;
    		convert_wmf($name);
    		$new_ext="jpg";
        unlink('upload/K'.(string)$KeyboardNo.$n.'.wmf');
    	}

      //PUSH IN EXT ARRAY
      array_push($old_ext, $new_ext);
    }

    }
  }

  //IF OLD FILE MORE THAN NEW FILE
  if($old_count>$picture_number)
  {
    $delete_number = $old_count-$picture_number;
    //echo $delete_number;
    for($j = $delete_number ; $j>0 ;$j--)
    { //print_r($old_ext);
      $file_index = $j+$picture_number;
      $array_index = $picture_number-1+$j;
      $old_file_name = 'upload/K'.$KeyboardNo.'A'.$file_index.'.'.$old_ext[$array_index];
      //echo $old_file_name.'<br />';
      unlink($old_file_name);
      unset($old_ext[$array_index]);

    }
  }

  $final_ext = implode("-",$old_ext);
  //UPDATE KEYBOARD DB
  $sqlKeyboard = "UPDATE Keyboard  SET ext = '$final_ext' WHERE KeyboardNo='$KeyboardNo'";
  $db->query($sqlKeyboard);
  echo "<script>alert('編輯完成'); location.href = 'QuestionList.php';</script>";

?>
