<?php
include "session.php";
include "db.php";
$user_id=$_SESSION["id"];
$lead_id = $_POST['lead_id'];
$today = date("Y-m-d");
$sql = "SELECT lead_id FROM leads join feedbacks on leads.lead_id = feedbacks.feedback_lead_id where lead_user_id=" . $user_id . " and lead_id > " . $lead_id . " and feedback_leadstatus != 'Lead_Enrolled'  order by lead_id asc LIMIT 1";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
if($row == null){
    $row['lead_id'] = 0;
}
// $after = $nextdata['lead_id'];
// $Chk_New = $_GET["Chk_New"];
// $nextstatus = "";
// if (empty($after)) {
//   $nextstatus = "Disabled";
// } else {
//   $lead_id = $nextdata['lead_id'];
// }
// $sql = "SELECT COUNT(*) as available_lead FROM `leads` WHERE lead_user_id = 0";
// $result=$conn->query($sql);
// $row = $result->fetch_assoc();
header('Content-Type: application/json');
echo json_encode($row);
?>
