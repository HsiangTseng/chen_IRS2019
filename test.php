<html>
<?php
$file_name = $_FILES['file1']['name'];
echo $_FILES['file1'];
/*$image = new Imagick();
$image->setresolution(200, 200);
$image->readimage($file_name);
$image->resizeImage(800,0,Imagick::FILTER_LANCZOS,1);
$image->setImageFormat('jpg');*/
//echo $image;
?>
<img id="img7" src="<?php echo $file_name; ?>" alt="">
</html>
