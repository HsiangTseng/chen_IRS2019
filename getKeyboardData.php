<?php
    include("connects.php");

    $KeyboardNo = $_POST['KeyboardNo'];

    $sql2 = "SELECT * FROM Keyboard WHERE `KeyboardNo` = $KeyboardNo";
    $result2 = mysqli_fetch_object($db->query($sql2));
    $KeyboardStyle = $result2->Style;
    $ext = $result2->ext;

    echo $KeyboardStyle.$ext;

?>
