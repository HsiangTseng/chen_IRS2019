<?
	include("connects.php");

	$teacher_id = $_SESSION['username'];

	$checkstudentnumberarray = array();

	$check_count = 0;
	$check_i = 0;

	$sql_teacherclass = "select * from ClassList where Teacher_ID = '".$teacher_id."'";
	if($stmt =$db->query($sql_teacherclass)){	
		$result = mysqli_fetch_object($stmt);
		$classlist = $result->StudentNumberList;
		$checkstudentnumberarray = mb_split("-",$classlist);
		$check_count = count($checkstudentnumberarray);
	}

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

	for($i = 0 ; $i < $count ; $i++){
		if($check_i!=$check_count){
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
			}
			else{
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
		else{
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
