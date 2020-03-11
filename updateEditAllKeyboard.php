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

  $ext_array = explode("-",$old_ext);

  //print_r($ext_array);

  if ($_FILES['file0']['error'] === UPLOAD_ERR_OK){

    // KEYBOARD MUST HAVE OLD PICTURE, SO DELETE OLD ONE
    $a1_old_name = 'upload/K'.$KeyboardNo.'A1.'.$ext_array[0];
    unlink($a1_old_name);

    //UPLOAD
    $file = $_FILES['file0']['tmp_name'];
    $a1_ext = end(explode('.', $_FILES['file0']['name']));
    $dest = 'upload/K'.(string)$KeyboardNo.'A1.'.$a1_ext;
    move_uploaded_file($file, $dest);

    if($a1_ext=="wmf")
    {
      $name = 'K'.(string)$KeyboardNo.'A1';
      convert_wmf($name);
      $a1_ext="jpg";
      unlink('upload/K'.$KeyboardNo.'A1.wmf');
    }
    $ext_array[0] = $a1_ext;
  }

  if ($_FILES['file1']['error'] === UPLOAD_ERR_OK){

    // KEYBOARD MUST HAVE OLD PICTURE, SO DELETE OLD ONE
    $a2_old_name = 'upload/K'.$KeyboardNo.'A2.'.$ext_array[1];
    unlink($a2_old_name);

    //UPLOAD
    $file = $_FILES['file1']['tmp_name'];
    $a2_ext = end(explode('.', $_FILES['file1']['name']));
    $dest = 'upload/K'.(string)$KeyboardNo.'A2.'.$a2_ext;
    move_uploaded_file($file, $dest);

    if($a2_ext=="wmf")
    {
      $name = 'K'.(string)$KeyboardNo.'A2';
      convert_wmf($name);
      $a2_ext="jpg";
      unlink('upload/K'.$KeyboardNo.'A2.wmf');
    }
    $ext_array[1] = $a2_ext;
  }

  if ($_FILES['file2']['error'] === UPLOAD_ERR_OK){

    // KEYBOARD MUST HAVE OLD PICTURE, SO DELETE OLD ONE
    $a3_old_name = 'upload/K'.$KeyboardNo.'A3.'.$ext_array[2];
    unlink($a3_old_name);

    //UPLOAD
    $file = $_FILES['file2']['tmp_name'];
    $a3_ext = end(explode('.', $_FILES['file2']['name']));
    $dest = 'upload/K'.(string)$KeyboardNo.'A3.'.$a3_ext;
    move_uploaded_file($file, $dest);

    if($a3_ext=="wmf")
    {
      $name = 'K'.(string)$KeyboardNo.'A3';
      convert_wmf($name);
      $a3_ext="jpg";
      unlink('upload/K'.$KeyboardNo.'A3.wmf');
    }
    $ext_array[2] = $a3_ext;
  }

  if ($_FILES['file3']['error'] === UPLOAD_ERR_OK){

    // KEYBOARD MUST HAVE OLD PICTURE, SO DELETE OLD ONE
    $a4_old_name = 'upload/K'.$KeyboardNo.'A4.'.$ext_array[3];
    unlink($a4_old_name);

    //UPLOAD
    $file = $_FILES['file3']['tmp_name'];
    $a4_ext = end(explode('.', $_FILES['file3']['name']));
    $dest = 'upload/K'.(string)$KeyboardNo.'A4.'.$a4_ext;
    move_uploaded_file($file, $dest);

    if($a4_ext=="wmf")
    {
      $name = 'K'.(string)$KeyboardNo.'A4';
      convert_wmf($name);
      $a4_ext="jpg";
      unlink('upload/K'.$KeyboardNo.'A4.wmf');
    }
    $ext_array[3] = $a4_ext;
  }


  if ($_FILES['file4']['error'] === UPLOAD_ERR_OK){

    // KEYBOARD MUST HAVE OLD PICTURE, SO DELETE OLD ONE
    $a5_old_name = 'upload/K'.$KeyboardNo.'A5.'.$ext_array[4];
    unlink($a5_old_name);

    //UPLOAD
    $file = $_FILES['file4']['tmp_name'];
    $a5_ext = end(explode('.', $_FILES['file4']['name']));
    $dest = 'upload/K'.(string)$KeyboardNo.'A5.'.$a5_ext;
    move_uploaded_file($file, $dest);

    if($a5_ext=="wmf")
    {
      $name = 'K'.(string)$KeyboardNo.'A5';
      convert_wmf($name);
      $a5_ext="jpg";
      unlink('upload/K'.$KeyboardNo.'A5.wmf');
    }
    $ext_array[4] = $a5_ext;
  }

  if ($_FILES['file5']['error'] === UPLOAD_ERR_OK){

    // KEYBOARD MUST HAVE OLD PICTURE, SO DELETE OLD ONE
    $a6_old_name = 'upload/K'.$KeyboardNo.'A6.'.$ext_array[5];
    unlink($a6_old_name);

    //UPLOAD
    $file = $_FILES['file5']['tmp_name'];
    $a6_ext = end(explode('.', $_FILES['file5']['name']));
    $dest = 'upload/K'.(string)$KeyboardNo.'A6.'.$a6_ext;
    move_uploaded_file($file, $dest);

    if($a6_ext=="wmf")
    {
      $name = 'K'.(string)$KeyboardNo.'A6';
      convert_wmf($name);
      $a6_ext="jpg";
      unlink('upload/K'.$KeyboardNo.'A6.wmf');
    }
    $ext_array[5] = $a6_ext;
  }


  if ($_FILES['file6']['error'] === UPLOAD_ERR_OK){

    // KEYBOARD MUST HAVE OLD PICTURE, SO DELETE OLD ONE
    $a7_old_name = 'upload/K'.$KeyboardNo.'A7.'.$ext_array[6];
    unlink($a7_old_name);

    //UPLOAD
    $file = $_FILES['file6']['tmp_name'];
    $a7_ext = end(explode('.', $_FILES['file6']['name']));
    $dest = 'upload/K'.(string)$KeyboardNo.'A7.'.$a7_ext;
    move_uploaded_file($file, $dest);

    if($a7_ext=="wmf")
    {
      $name = 'K'.(string)$KeyboardNo.'A7';
      convert_wmf($name);
      $a7_ext="jpg";
      unlink('upload/K'.$KeyboardNo.'A7.wmf');
    }
    $ext_array[6] = $a7_ext;
  }

  if ($_FILES['file7']['error'] === UPLOAD_ERR_OK){

    // KEYBOARD MUST HAVE OLD PICTURE, SO DELETE OLD ONE
    $a8_old_name = 'upload/K'.$KeyboardNo.'A8.'.$ext_array[7];
    unlink($a8_old_name);

    //UPLOAD
    $file = $_FILES['file7']['tmp_name'];
    $a8_ext = end(explode('.', $_FILES['file7']['name']));
    $dest = 'upload/K'.(string)$KeyboardNo.'A8.'.$a8_ext;
    move_uploaded_file($file, $dest);

    if($a8_ext=="wmf")
    {
      $name = 'K'.(string)$KeyboardNo.'A8';
      convert_wmf($name);
      $a8_ext="jpg";
      unlink('upload/K'.$KeyboardNo.'A8.wmf');
    }
    $ext_array[7] = $a8_ext;
  }


  $final_ext = implode("-",$ext_array);
  //echo $old_ext.'<br />';
  //echo $final_ext;

  //UPDATE ext
  $sql = "UPDATE Keyboard SET ext='$final_ext' WHERE KeyboardNo = '$KeyboardNo' ";
  $db->query($sql);

  echo "<script>alert('編輯成功'); location.href = 'editKeyboard.php';</script>";
?>
