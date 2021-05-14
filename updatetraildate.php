
<?php 
include "session.php";
include "db.php";
$id=$_SESSION["id"];
$newupdate_date=$_POST["increase_date"];
$sql="update leads set lead_followupdate='".$newupdate_date."' WHERE leads.lead_id = ".$lead_id;;

?>
