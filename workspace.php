<?php
                    include("connects.php");
                    $sql = "SELECT COUNT(Name) AS max FROM UserList WHERE type = 'S'";
                    $result = mysqli_fetch_object($db->query($sql));
                    $max_number = $result->max;
                    $name = array();
                    $school = array();
                    $gender = array();
                    $grade = array();
                    $test_time = array();
                    $teacher = array();
                    $category = array();
                    for ( $a = 1 ; $a<=$max_number ; $a++)
                    {
                      $sql2 = "SELECT * FROM `UserList` WHERE `type` ='S'";
                      $result2 = mysqli_fetch_object($db->query($sql2));
                      $name[$a] = $result2->Name;
                      $school[$a] = $result2->School;
                      $gender[$a] = $result2->Gender;
                      $grade[$a] = $result2->Grade;
                      $test_time[$a] = $result2->TestTime;
                      $teacher[$a] = $result2->TestTeacher;
                      $category[$a] = $result2->Category;

                      echo $a;
                      echo $max_number;
                      echo $result2->Name;
                      echo $name[$a];

                      $name_to_json=json_encode((array)$name);
                      $school_to_json=json_encode((array)$school);
                      $gender_to_json=json_encode((array)$gender);
                      $grade_to_json=json_encode((array)$grade);
                      $test_time_to_json=json_encode((array)$test_time);
                      $teacher_to_json=json_encode((array)$teacher);
                      $category_to_json=json_encode((array)$category);
                    }
?>