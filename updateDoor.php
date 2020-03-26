<?php
if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK){
  $file = $_FILES['my_file']['tmp_name'];

  $ext = end(explode('.', $_FILES['my_file']['name']));
  $dest = 'door/file.'.$ext;
  # 將檔案移至指定位置
  move_uploaded_file($file, $dest);
  }
?>
