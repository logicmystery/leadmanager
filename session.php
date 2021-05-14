<?php  
session_start();
 $myid=$_SESSION["id"];
if($myid >0){
//header("Location:customer.php");
//exit();
}
else{
header("Location:login.php");
exit();
}

?>
