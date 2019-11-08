<?
	include("connects.php");
	
	$sql_nowstate = "select * from Now_state";
	
	//取得現在題號、現在的試卷號碼
	if($stmt = $db->query($sql_nowstate))
	{
		while($result = mysqli_fetch_object($stmt))
		{
			$sql_number = $result->No;
			$sql_quiz = $result->ExamNumber;			
		}
	}
	
	//取得每一題在Questionlist的號碼
	$sql_quiz = "SELECT * FROM ExamList WHERE No like '$sql_quiz'";
	$result = mysqli_fetch_object($db->query($sql_quiz));
	$q_list = array();
	$temp_string = $result->question_list;
	$q_list = explode(",",$temp_string);
	
	//取得此題的答案數量
	$sql_number_quiz = "select count(QA) AS Count from QuestionList where No like '".$q_list[$sql_number-1]."'";
	$stmt = $db->query($sql_number_quiz);
	$number_quiz_sql = mysqli_fetch_object($stmt);
	$number_quiz = $number_quiz_sql->Count;
	
	//取得現在題目的題型為單選或多選
	$sql_checkbox = "select * from QuestionList where No like '".$q_list[$sql_number-1]."' and QA like 'Q'";
	$stmt = $db->query($sql_checkbox);
	$result = mysqli_fetch_object($stmt);
	$exam_type = $result->single_or_multi;
	$quiz_type = $result->type;
	$No_keyboard = $result->KeyboardNo;
	
	
	//判斷題目是否為邏輯順序題
	//題目為邏輯順序題
	if(strpos($quiz_type,'L')!== false){
		if(strpos($quiz_type,'WORD')!== false){
			echo "<div class='col-md-12 col-sm-12 col-xs-12' style='height:10%; position:fixed; top:0; z-index:1;'>";
				echo "<input type='text' id='input' style='height:100%;width:100%;font-size:30px;'>";
			echo "</div>";		
		}
		else{
			echo "<div id='input' class='col-md-12 col-sm-12 col-xs-12 logic_graph' style='height:10%; position:fixed; top:0; z-index:1;'>";
				
			echo "</div>";
		}
		echo "<div class='col-md-12 col-sm-12 col-xs-12' style='height:80%;margin-top:7%;margin-bottom:9%;'>";	
		$sql_catch_exam = "select * from Keyboard where KeyboardNo = '".$No_keyboard."'";
		$result = mysqli_fetch_object($db->query($sql_catch_exam));
		
		
		if(strpos($quiz_type,'WORD')!== false){
			$keyboard = $result->wordQuestion;			
			$Arr_text = explode("^&",$keyboard);
			for( $i = 0 ; $i < count($Arr_text) ; $i++){
				$answer_index = $i;
				$answer_index+=1;			
				echo "<div class='col-md-2 col-sm-2 col-xs-2 div25'>";
					echo "<input type='checkbox' id='A".$answer_index."' name='value[]' value='A".$answer_index."' placeholder='".$Arr_text[$i]."' onclick='show_order(this.value,this.id,this.placeholder)'>";
						echo "<label style='word-wrap:break-word;' class='square-button rwdtxt' for='A".$answer_index."'>".$Arr_text[$i]."</label>";
				echo "</div>";
			}
		}
		else{
			$keyboard = $result->ext;			
			$Arr_img = explode("-",$keyboard);
			for( $i = 0 ; $i < count($Arr_img) ; $i++){
				$answer_index = $i;
				$answer_index+=1;			
				echo "<div class='col-md-2 col-sm-2 col-xs-2 div25'>";
					echo "<input type='checkbox' id='A".$answer_index."' name='value[]' value='A".$answer_index."' placeholder='upload/K".$No_keyboard."A".$answer_index.".".$Arr_img[$i]."' onclick='picture_order(this.value,this.id,this.placeholder)'>";
						echo "<label class='square-button rwdtxt' for='A".$answer_index."'>";
							echo "<img class='small-img' src='upload/K".$No_keyboard."A".$answer_index.".".$Arr_img[$i]."'>";
						echo "</label>";
				echo "</div>";
			}						
		}
	
		echo "</div>";	
	}
	
	//題目不為邏輯順序題
	else{
		//判斷題目為多題模式還是為4題模式
		//4題模式
		echo "<div class='col-md-12 col-sm-12 col-xs-12'  style='height:90%'>";			
		if($number_quiz == 5){
			//單選題						
			if($exam_type == 'SINGLE'){
				for( $i = 1 ; $i <= 4 ; $i++){
					$sql_data = "select * FROM QuestionList WHERE No like '".$q_list[$sql_number-1]."' AND QA like 'A".$i."'";
					$result = mysqli_fetch_object($db->query($sql_data));
					echo "<div class='col-md-6 col-sm-6 col-xs-6 div50 test'>";
					//聲音
					if(!empty($result->audio)&&!is_null($result->audio)){
						echo "<audio controls>";
							echo "<source src='upload/'".$result->audio."' type='audio/mpeg'>";
						echo "</audio>";
					}
					//圖片
					if(!empty($result->picture_ext)&&!is_null($result->picture_ext)){
						//有圖有文字
						if(!empty($result->Content)&&!is_null($result->Content)){
							echo "<input type='radio' id='A".$i."' name='value[]' value='A".$i."'>";
								echo "<label for='A".$i."' class='square-button rwdtxt'>";
									echo "<img class='small-img' src='upload/Q".$q_list[$sql_number-1]."A".$i.".".$result->picture_ext."' alt='".$result->picture_alt."'>";
									echo "<p style='word-wrap:break-word;' class='show-text rwdtxt'>".$result->Content."</p>";
								echo "</label>";
						}
						//有圖沒文字
						else{
							echo "<input type='radio' id='A".$i."' name='value[]' value='A".$i."'>";
							echo "<label for='A".$i."' class='square-button rwdtxt'>";
								echo "<img class='small-img' src='upload/Q".$q_list[$sql_number-1]."A".$i.".".$result->picture_ext."' alt='".$result->picture_alt."'>";
							echo "</label>";
						}
					}	
					//文字
					elseif(empty($result->picture_ext)||is_null($result->picture_ext)){
						echo "<input type='radio' id='A".$i."' name='value[]' value='A".$i."' >";
							echo "<label  for='A".$i."' style='word-wrap:break-word;' class='square-button rwdonlytxt'>".$result->Content."</label>";
					}
					echo "</div>";
				}
			}	
			//多選題		
			else{
				for( $i = 1 ; $i <= 4 ; $i++){
					$sql_data = "select * FROM QuestionList WHERE No like '".$q_list[$sql_number-1]."' AND QA like 'A".$i."'";
					$result = mysqli_fetch_object($db->query($sql_data));
					echo "<div class='col-md-6 col-sm-6 col-xs-6 div50 test'>";
					//聲音
					if(!empty($result->audio)&&!is_null($result->audio)){
						echo "<audio controls>";
							echo "<source src='upload/'".$result->audio."' type='audio/mpeg'>";
						echo "</audio>";
					}
					//圖片
					if(!empty($result->picture_ext)&&!is_null($result->picture_ext)){
						//有圖有文字
						if(!empty($result->Content)&&!is_null($result->Content)){
							echo "<input type='checkbox' id='A".$i."' name='value[]' value='A".$i."'>";
								echo "<label for='A".$i."' class='square-button rwdtxt'>";
									echo "<img class='small-img' src='upload/Q".$q_list[$sql_number-1]."A".$i.".".$result->picture_ext."' alt='".$result->picture_alt."'>";
									echo "<p style='word-wrap:break-word;' class='square-button rwdtxt'>".$result->Content."</p>";
								echo "</label>";
						}
						//有圖沒文字
						else{
							echo "<input type='checkbox' id='A".$i."' name='value[]' value='A".$i."'>";
							echo "<label for='A".$i."' class='square-button rwdtxt'>";
								echo "<img class='small-img' src='upload/Q".$q_list[$sql_number-1]."A".$i.".".$result->picture_ext."' alt='".$result->picture_alt."'>";
							echo "</label>";
						}
					}	
					//沒圖片有文字
					elseif(empty($result->picture_ext)||is_null($result->picture_ext)){
						echo "<input type='checkbox' id='A".$i."' name='value[]' value='A".$i."' >";
							echo "<label  for='A".$i."' style='word-wrap:break-word;' class='square-button rwdonlytxt'>".$result->Content."</label>";
					}
					echo "</div>";
				}
			}			
		}
		
		
		//keyboard模式
		else{
			//拿ext字串
			$sql_catch_exam = "select * from Keyboard where KeyboardNo = '".$No_keyboard."'";
			$result = mysqli_fetch_object($db->query($sql_catch_exam));
			
			$keyboard = $result->ext;
			$Arr = explode("-",$keyboard);
			
			//wordQuestion字串
			$keyboard = $result->wordQuestion;
			$Arr_text = explode("^&",$keyboard);
			
			//單選題
			if($exam_type == 'SINGLE'){						
				for( $i = 0 ; $i < count($Arr) ; $i++){
					$answer_index = $i;
					$answer_index+=1;
					echo "<div class='col-md-3 col-sm-3 col-xs-3 div50 test'>";
						echo "<input type='radio' id='A".($answer_index)."' name='value[]' value='A".($answer_index)."'>";
							//有圖片
							if(!empty($Arr[$i])&&!is_null($Arr[$i])){	
								//有文字
								if(!empty($Arr_text[$i])&&!is_null($Arr_text[$i])){		
									echo "<label for='A".($answer_index)."' class='square-button rwdtxt'>";
										echo "<img class='small-img' src='upload/K".$No_keyboard."A".$answer_index.".".$Arr[$i]."'>";
										echo "<p style='word-wrap:break-word;' class='square-button rwdtxt'>".$Arr_text[$i]."</p>";
									echo "</label>";
								}
								//無文字
								else{
									echo "<label for='A".($answer_index)."' class='square-button rwdtxt'>";
										echo "<img class='small-img' src='upload/K".$No_keyboard."A".$answer_index.".".$Arr[$i]."'>";
									echo "</label>";
								}
							}
							//單純文字
							else{
								echo "<label  for='A".$i."' style='word-wrap:break-word;' class='square-button rwdonlytxt'>".$Arr_text[$i]."</label>";
							}
					echo "</div>";
					
				}
			}	
			//多選題
			else{				
				for( $i = 0 ; $i < count($Arr) ; $i++){
					$answer_index = $i;
					$answer_index+=1;
					echo "<div class='col-md-3 col-sm-3 col-xs-3 div50 test'>";
						echo "<input type='checkbox' id='A".($answer_index)."' name='value[]' value='A".($answer_index)."'>";
							//有圖片
							if(!empty($Arr[$i])&&!is_null($Arr[$i])){
								//有文字
								if(!empty($Arr_text[$i])&&!is_null($Arr_text[$i])){		
									echo "<label for='A".($answer_index)."' class='square-button rwdtxt'>";
										echo "<img class='small-img' src='upload/K".$No_keyboard."A".$answer_index.".".$Arr[$i]."'>";
										echo "<p style='word-wrap:break-word;' class='square-button rwdtxt'>".$Arr_text[$i]."</p>";
									echo "</label>";
								}
								//無文字
								else{
									echo "<label for='A".($answer_index)."' class='square-button rwdtxt'>";
										echo "<img class='small-img' src='upload/K".$No_keyboard."A".$answer_index.".".$Arr[$i]."'>";
									echo "</label>";
								}
							}
							//單純文字
							else{
								echo "<label  for='A".$i."' style='word-wrap:break-word;' class='square-button rwdonlytxt'>".$Arr_text[$i]."</label>";
							}
					echo "</div>";
				}
			}
		}	
	
		echo "</div>";
	}
?>
