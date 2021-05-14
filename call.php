<?php 
session_start();
include "db.php";
$call = base64_decode($_GET['callid']);
$dt = date('Y-m-d');
$idd=$_SESSION["id"];
$sql = "select lead_callcount from leads where lead_user_id =".$idd." and lead_date = '".$dt."' and lead_id = ".$call."";
$resp = $conn->query($sql);
$row = $resp->fetch_assoc();
$total_call = $row['lead_callcount']+1;
$sqli="UPDATE `leads` SET lead_callcount=".$total_call." where lead_id='".$call."' and lead_user_id =".$idd." and lead_date = '".$dt."'";
$conn->query($sqli);

 header("location:customer.php"); // redirects to all records page
 exit;	




?>
