<?php

$servername = "localhost";
//$username = "root";
//$password = "";
 $username = "PUT YOUR DATABASE USER NAME";
 $password = "YOUR DATABASE PASSWORD";
$database = "YOUR DATABASE";

// Create connection
$conn = new mysqli($servername, $username, $password,$database);
date_default_timezone_set('Asia/Kolkata');
//Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

?>
