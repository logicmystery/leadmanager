<?php 
include "db.php";
$lead_id=$_POST['newlead_id'];
$call_feedback_new=$_POST['call_feedback_new'];
$sql="update feedbacks set feedback_gcfeedback='".$call_feedback_new."' where feedback_lead_id='".$lead_id."'";
mysqli_query($conn, $sql);
header("Location:customer.php?");
exit();

?>