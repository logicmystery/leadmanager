<?php 
include "session.php";
include "db.php";
$id=$_SESSION["id"];
 $data = array();
$sql="SELECT * FROM leads where lead_user_id='".$id."'";
$re=$conn->query($sql);
while($row = $re->fetch_assoc()) {
            $data[] = $row;
}
header('Content-Type: application/json');
echo json_encode($data);

?>

