<?php session_start(); ?>
<!--上方語法為啟用session，此語法要放在網頁最前方-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//連接資料庫
//只要此頁面上有用到連接MySQL就要include它
include("connects.php");
$pid = $_POST['id'];
$pw = $_POST['pwd'];

//搜尋資料庫資料
$sql = "SELECT * FROM UserList where id = '$pid'";
$stmt = $db->query($sql);
$result = mysqli_fetch_object($stmt);
$type = $result->type;
//判斷帳號與密碼是否為空白
//以及MySQL資料庫裡是否有這個會員
if($pid != null && $pw != null && $result->id == $pid && $result->password == $pw)
{
        //將帳號寫入session，方便驗證使用者身份
        $_SESSION['username'] = $pid;
        $_SESSION['type'] = $type;

        if($type == 'T')
        {
        	header ('location: LandingPage.php');
        }
        if($type == 'S')
        {
        	header ('location: wait.php');
        }
        //echo '<meta http-equiv=REFRESH CONTENT=1;url=home.php>';
}
else
{
		header ('location: WrongUser.php');
        //echo '<meta http-equiv=REFRESH CONTENT=1;url=WrongUser.php>';
}
?>