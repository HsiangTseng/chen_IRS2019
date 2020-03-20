<?php

include("connects.php");
$number = array();
$CA = array();

$sql = "SELECT CA,No FROM QuestionList WHERE type='LPICTURE' AND QA='Q'";

if($stmt = $db->query($sql))
{
    while($result = mysqli_fetch_object($stmt))
    {
      if(strpos($result->CA, '-')!== false)
      {
        array_push($CA,$result->CA);
        array_push($number,$result->No);
      }
    }
}

print_r($CA);
echo '<br />';
print_r($number);

foreach ($CA as $key => $value) {
  $CA[$key] = str_replace("-",",",$CA[$key]);
}
echo '<br />';
echo '-----------';
echo '<br />';
print_r($CA);
echo '<br />';
print_r($number);

foreach ($CA as $key => $value) {
  $sql_update = "UPDATE QuestionList SET CA='$CA[$key]' WHERE No='$number[$key]' AND QA='Q'";
  $db->query($sql_update);
}

?>
