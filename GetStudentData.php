<?php
	include("connects.php");
	
	$sql = "SELECT * FROM UserList";

	if(isset($_POST['catch_grade'])){
		if($_POST['catch_grade']!="0"){
			$sql = $sql." WHERE Grade = '".$_POST['catch_grade']."'";
		}	
	}
		
	if(isset($_POST['catch_class'])){
		if($_POST['catch_class']!="0"){
			if(strpos($sql,"WHERE")){
				$sql = $sql." AND Class = '".$_POST['catch_class']."'";
			}
			else{
				$sql = $sql." WHERE Class = '".$_POST['catch_class']."'";
			}
		}
	}

	$msg = array();
	$index = 0;
	if($stmt = $db->query($sql)){
		while($result = mysqli_fetch_object($stmt)){
			$msg[$index] = array("StudentNumber"=>$result->StudentNumber,"Name"=>$result->Name);
			$index++;
		}
	}

	echo json_encode($msg);
?>
