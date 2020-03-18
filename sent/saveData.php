<?php
$servername = "localhost";
$username = "root";
$password = "lilongsheng";
$dbname = "IRS_DB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$date = date('H:i:s');
$sql = "INSERT INTO State (No, Time_stamp)
VALUES ('4', '$date')";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();
?>
