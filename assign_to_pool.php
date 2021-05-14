<?php
include "session.php";
include "db.php";
$user_id=$_SESSION["id"];
$lead_id=$_POST['lead_id'];
$assign=$_POST['assign'];

if(!empty($assign)){
    if ($assign = "assign_to_pool") {
        $sql="UPDATE `leads` SET `lead_user_id` = '0', lead_trail_date = '0000-00-00', lead_trail_time = '00:00:00', lead_followupdate = '0000-00-00' WHERE `leads`.`lead_id` = ".$lead_id." ";
        $conn->query($sql);
        $delete_lead = "DELETE FROM `mapleadactivity` WHERE `mapleadactivity`.`mapleadactivity_lead_id` = ".$lead_id."";
        $conn->query($delete_lead);
        $delete_feed = "DELETE FROM `feedbacks` WHERE `feedbacks`.`feedbacks_lead_id` = ".$lead_id."";
        $conn->query($delete_feed);
    }else{
        $sql="UPDATE `leads` SET `lead_user_id` = '".$assign."', lead_trail_date = '0000-00-00', lead_trail_time = '00:00:00', lead_followupdate = '0000-00-00' WHERE `leads`.`lead_id` = ".$lead_id." ";
        $conn->query($sql);
        $delete_lead = "DELETE FROM `mapleadactivity` WHERE `mapleadactivity`.`mapleadactivity_lead_id` = ".$lead_id."";
        $conn->query($delete_lead);
        $delete_feed = "DELETE FROM `feedbacks` WHERE `feedbacks`.`feedbacks_lead_id` = ".$lead_id."";
        $conn->query($delete_feed);
    }
}

$today = date("Y-m-d");
$sql = "SELECT lead_id FROM leads join feedbacks on leads.lead_id = feedbacks.feedback_lead_id where lead_user_id=" . $user_id . " and lead_id > " . $lead_id . " and feedback_leadstatus != 'Lead_Enrolled'  order by lead_id asc LIMIT 1";
$result=$conn->query($sql);
$row = $result->fetch_assoc();
if($row == null){
    $row['lead_id'] = 0;
}
 $row['status'] = "success";
header('Content-Type: application/json');
echo json_encode($row);  
?>