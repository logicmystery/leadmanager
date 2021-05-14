<?php 
session_start();
include "db.php";

$id=$_SESSION["id"];
$lead_id=$_POST["lead_id"];
$dt = date('Y-m-d');
$date = date('Y-m-d H:i:s');

$sql="SELECT * FROM leads where lead_user_id = 0 ORDER BY RAND() LIMIT 1";
$result=$conn->query($sql);
$row = $result->fetch_assoc();

$sql="INSERT INTO `feedbacks` (`feedback_lead_id`,`feedback_title`,`feedback_date`,`feedback_enquiry`,
`feedback_gcfeedback`,`feedback_trainerfeedback`,`feedback_leadstatus`,
`feedback_leadvalue`) VALUES ('".$row['lead_id']."','','".$date."','','','','','0')";
mysqli_query($conn, $sql);

$sqll="UPDATE `leads` SET lead_user_id= ".$id.", lead_date ='".$dt."', lead_trail_date ='',lead_trail_time='',lead_followupdate='' WHERE lead_id= ".$row['lead_id']."";
$conn->query($sqll);
$newsql="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$row['lead_id']."', '1','".$date."','Lead assigned')";
$conn->query($newsql);
$lead_id=base64_encode($row['lead_id']);
$_SESSION["message"] = "New Lead Assigned Successfully!";
header("location:form.php?lead_id=".$lead_id); // redirects to all records page
exit();	
?>

