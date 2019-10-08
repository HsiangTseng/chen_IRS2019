<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
	include("connects.php");
    include("convert_wmf.php");



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

    //edit block
    if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
    {
        $tag = $_POST['edit_tag'];
        $question_number = $_POST['question_number'];
        $KeyboardNumber = $_POST['KeyboardNo'];
        $max_number = $question_number;
        

        $sql = "SELECT * FROM Keyboard WHERE KeyboardNo = '$KeyboardNumber'";
        $result = mysqli_fetch_object($db->query($sql));
        $extString = $result->ext;

        //GET Number of Answer Options.
        $old_pictureNumber = substr_count($extString,"-")+1;
        $extArray =  mb_split("-",$extString);

        /*echo 'Q'.$max_number;
        echo 'K'.$KeyboardNo;
        echo 'picture_number'.$old_pictureNumber;
        echo 'ext'.$extString;*/

        
        // if edit , must DELETE OLD FILE first!!!
        for ($i=1;$i<=$old_pictureNumber;$i++)
        {
            $$sql = "SELECT * FROM QuestionList WHERE No = '$question_number' AND QA = 'A1'";
            $unlinkstring = 'upload/K'.$KeyboardNumber.'A'.$i.'.'.$extArray[$i-1];
            unlink($unlinkstring);
        }

    }



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

    //if edit
    if(isset($_POST['edit_tag'])&&isset($_POST['question_number']))
    {

        $sql = "UPDATE Keyboard SET ext='$ext_string' WHERE KeyboardNo = '$KeyboardNumber'";
        $db->query($sql);

        $sqlQuestion = "UPDATE QuestionList SET CA = '$CA', Content = '$Q1' WHERE No= '$max_number'";
        $db->query($sqlQuestion);

        $db->close();

        echo "<script>alert('編輯成功'); location.href = 'QuestionList.php';</script>";

    }

    else
    {
        $sql2 = "INSERT INTO Keyboard (KeyboardNo,type, ext) VALUES ('$KeyboardNumber', 'Logic', '$ext_string')";
        $db->query($sql2);

        $sqlQuestion = "INSERT INTO QuestionList (No, QA, CA, Content, type, single_or_multi, KeyboardNo) VALUES ('$max_number', 'Q', '$CA', '$Q1', 'LPICTURE', 'MULTI', '$KeyboardNumber')";
        $db->query($sqlQuestion);
        $db->close();

        echo "<script>alert('出題成功'); location.href = 'MakeQuestion.php';</script>";
    }


    

	
?>

