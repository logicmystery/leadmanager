<?php 
session_start();
include "db.php";
$date = date('Y-m-d H:i:s');
$id=$_SESSION["id"];
$lead_id=$_POST['lead_id'];
 $data = array();
$sql="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '2','".$date."','Lead was called')";
$conn->query($sql);

$today_activity="SELECT * FROM mapleadactivity JOIN activitys ON activitys.activity_id=mapleadactivity.mapactivity_activity_id JOIN leads ON leads.lead_id=mapleadactivity.mapactivity_lead_id JOIN users ON users.users_id=leads.lead_user_id WHERE mapleadactivity.mapactivity_lead_id='".$lead_id."' AND users.users_id= ".$id." ORDER BY mapleadactivity.mapleadactivity_date DESC";
$today_leads_result= mysqli_query($conn, $today_activity);
while($row = $today_leads_result->fetch_assoc()) {
 $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);

?>
