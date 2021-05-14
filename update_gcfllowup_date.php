<?php
include "db.php";
$lead_id=$_POST['lead_id'];
$fllowupdate=$_POST['fllowupdate'];
$date = date('Y-m-d H:i:s');
$flw_up_date="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '7','".$date."','".$fllowupdate."')";  
 $conn->query($flw_up_date);
 $data['status'] = "success";
header('Content-Type: application/json');
echo json_encode($data);  
?>