<?php 
//include "session.php";
// include "db.php";
// $map_activity_id=$_POST['map_activity_id'];
// $activity_id=$_POST['activity_id'];
// $newsql="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`) VALUES ('".$map_activity_id."', '".."');"
include "db.php";
$lead_id=$_POST['lead_id'];
$call_feedback_new=$_POST['call_feedback_new'];
$date = date('Y-m-d H:i:s');
$lead_sql="select * from leads where lead_id = " . $lead_id;
$resp=$conn->query($lead_sql);
$lead_data = $resp->fetch_assoc();
$trail_date_time = $lead_data['lead_trail_date'] .' '. $lead_data['lead_trail_time'];
if($lead_data['lead_trail_date'] != '0000-00-00' && $lead_data['lead_trail_time'] != '00:00:00'){
    if($trail_date_time > $date){
        $sql="update feedbacks set feedback_title='".$call_feedback_new."' where feedback_lead_id='".$lead_id."'";
        mysqli_query($conn, $sql);
        $gcf="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '3','".$date."','". $call_feedback_new."')";
        $conn->query($gcf);
    }else{
        $sql="update feedbacks set feedback_gcfeedback='".$call_feedback_new."' where feedback_lead_id='".$lead_id."'";
        mysqli_query($conn, $sql);
        $gc_followup_feed="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '6','".$date."','".$call_feedback_new."')";
        $conn->query($gc_followup_feed);
    }
}else{
    $sql="update feedbacks set feedback_title='".$call_feedback_new."' where feedback_lead_id='".$lead_id."'";
    mysqli_query($conn, $sql);
    $gcf="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '3','".$date."','". $call_feedback_new."')";
    $conn->query($gcf);
}
$data['status'] = "success";
header('Content-Type: application/json');
echo json_encode($data);
// header("Location:customer.php?");
// exit();
?>
