<?
	include("connects.php");

	$teacher_id = $_SESSION['username'];

	//獲取該位老師的班級學生
	$checkstudentnumberarray = array();
	$check_count = 0;
	
	$sql_teacherclass = "select * from ClassList where Teacher_ID = '".$teacher_id."'";
	if($stmt =$db->query($sql_teacherclass)){
		while($result = mysqli_fetch_object($stmt)){
			$classlist = $result->StudentNumberList;
			$checkstudentnumberarray = mb_split("-",$classlist);
			$check_count = count($checkstudentnumberarray);
		}
	}
	
	
	//獲取其他老師的班級
	$OtherTeacherarray = array();
	$count_other_teacher = 0;
	$sql_teacher_all = "select * from UserList where type = 'T' and id != '".$teacher_id."'";
	if($stmt3=$db->query($sql_teacher_all))
	{
		while($result3 = mysqli_fetch_object($stmt3)){
			$OtherTeacherarray[$count_other_teacher] = $result3->id;
			$count_other_teacher++;
		}
	}
	//獲取其他老師的班級學生
	$OtherTeacherStudentarray = array();
	$OtherTeacherStudentCount = 0;
	for($index = 0 ; $index < $count_other_teacher ; $index++){
		$sql_teacherclass = "select * from ClassList where Teacher_ID = '".$OtherTeacherarray[$index]."'";
		if($stmt4=$db->query($sql_teacherclass))
		{
			while($result4 = mysqli_fetch_object($stmt4)){
				$otherclasslist = $result4->StudentNumberList;
				$otherstudentnumberarray = mb_split("-",$otherclasslist);
				$otherstudentcount = count($otherstudentnumberarray);
				
				$OtherTeacherStudentarray = array_merge($OtherTeacherStudentarray,$otherstudentnumberarray);
				$OtherTeacherStudentCount = $OtherTeacherStudentCount+$otherstudentcount;
			}
		}
	}

	sort($OtherTeacherStudentarray);
	//print_r($OtherTeacherStudentarray);
	
	
	//獲取所有學生
	$studentnumberarray = array();
	$idarray = array();
	$namearray = array();
	$schoolarray = array();
	$gradearray = array();
	$classarray = array();
	$count = 0;
	$sql_student = "select * from UserList where type = 'S'";
	if($stmt2=$db->query($sql_student))
	{
		while($result2 = mysqli_fetch_object($stmt2)){
			$studentnumberarray[$count] = $result2->StudentNumber;
			$idarray[$count] = $result2->id;
			$namearray[$count] = $result2->Name;
			$schoolarray[$count] = $result2->School;
			$gradearray[$count] = $result2->Grade;
			$classarray[$count] = $result2->Class;
			$count++;
		}
	}
	$check_i = 0;
	$other_i = 0;
	//echo "<script>alert('".$OtherTeacherStudentarray[2]."');</script>";
	sort($studentnumberarray);
	//print_r($studentnumberarray);

	for($i = 0 ; $i < $count ; $i=$i+1){
		$check_show = 0;
		if($other_i != $OtherTeacherStudentCount){
			if($OtherTeacherStudentarray[$other_i] == $studentnumberarray[$i]){
				echo "<tr>";
					echo "<td>";
						echo "<input type='checkbox' name='value[]' id='".$studentnumberarray[$i]."' value='".$studentnumberarray[$i]."'  disabled>";
						echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$studentnumberarray[$i]."</label>";
					echo "</td>";
					echo "<td>";
						echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$schoolarray[$i]."</label>";
					echo "</td>";
					echo "<td>";
						echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$gradearray[$i]."年".$classarray[$i]."</label>";
					echo "</td>";
					echo "<td>";
						echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$idarray[$i]."-".$namearray[$i]."</label>";
					echo "</td>";
				echo "</tr>";
				$other_i++;
				$check_show = 1;
				//print_r($other_i);
			}
		}
		if($check_i!=$check_count && $check_show ==0){
			if($checkstudentnumberarray[$check_i] == $studentnumberarray[$i]){
				echo "<tr>";
					echo "<td>";
						echo "<input type='checkbox' name='value[]' id='".$studentnumberarray[$i]."' value='".$studentnumberarray[$i]."'  checked>";
						echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$studentnumberarray[$i]."</label>";
					echo "</td>";
					echo "<td>";
						echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$schoolarray[$i]."</label>";
					echo "</td>";
					echo "<td>";
						echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$gradearray[$i]."年".$classarray[$i]."</label>";
					echo "</td>";
					echo "<td>";
						echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$idarray[$i]."-".$namearray[$i]."</label>";
					echo "</td>";
				echo "</tr>";
				$check_i++;
				$check_show = 1;
			}
		}
		if($check_show == 0){
			echo "<tr>";
				echo "<td>";
					echo "<input type='checkbox' name='value[]' id='".$studentnumberarray[$i]."' value='".$studentnumberarray[$i]."'>";
					echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$studentnumberarray[$i]."</label>";
				echo "</td>";
				echo "<td>";
					echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$schoolarray[$i]."</label>";
				echo "</td>";
				echo "<td>";
					echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$gradearray[$i]."年".$classarray[$i]."</label>";
				echo "</td>";
				echo "<td>";
					echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='".$studentnumberarray[$i]."'>".$idarray[$i]."-".$namearray[$i]."</label>";
				echo "</td>";
			echo "</tr>";
		}
	}
?>

