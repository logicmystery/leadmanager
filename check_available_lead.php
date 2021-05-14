<?php
include "db.php";
$sql = "SELECT COUNT(*) as available_lead FROM `leads` WHERE lead_user_id = 0";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
header('Content-Type: application/json');
echo json_encode($row);
?>
