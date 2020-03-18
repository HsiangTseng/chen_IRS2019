<?php


// origin_name format is LIKE "Q31A1", Not include ext.
function convert_wmf($origin_name)
	{
		$file_name = "upload/".$origin_name.".wmf";
		$image = new Imagick();
		$image->setresolution(200, 200);
		$image->readimage($file_name);
		$image->resizeImage(800,0,Imagick::FILTER_LANCZOS,1);
		$image->setImageFormat('jpg');
		$image->writeImage("upload/".$origin_name.".jpg");
	}

?>