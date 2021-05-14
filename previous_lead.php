<?php
include "session.php";
include "db.php";
$user_id=$_SESSION["id"];
$lead_id = $_POST['lead_id'];
$today = date("Y-m-d");

$sql = "SELECT lead_id FROM leads join feedbacks on leads.lead_id = feedbacks.feedback_lead_id where lead_user_id= " . $user_id . " and lead_id < " . $lead_id . " and feedback_leadstatus != 'Lead_Enrolled' order by lead_id desc LIMIT 1";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
if($row == null){
    $row['lead_id'] = 0;
}
header('Content-Type: application/json');
echo json_encode($row);
?>
