<?php  
include "session.php";
include "db.php";
$id=$_SESSION["id"];
$date_month=$_POST["date_month"];
$get_date=date_create($date_month);
$year_format=date_format($get_date,"Y");
$month_format=date_format($get_date,"m");
$ql="SELECT count(feedback_leadstatus) as today_callcount FROM feedbacks JOIN leads on leads.lead_id = feedbacks.feedback_lead_id JOIN users ON users.users_id=leads.lead_user_id where YEAR(feedback_date) ='".$year_format."' AND MONTH(feedback_date) ='".$month_format."' and users_id='".$id."' and feedback_leadstatus ='Lead_Enrolled' and feedback_leadstatus ='Lead_Enrolled_without_Trial' ";
$data=$conn->query($ql);
$total = $data->fetch_assoc();

$sli="SELECT sum(feedback_leadvalue) as today_leadvalue FROM feedbacks JOIN leads on leads.lead_id = feedbacks.feedback_lead_id JOIN users ON users.users_id=leads.lead_user_id where YEAR(feedback_date) ='".$year_format."' AND MONTH(feedback_date) ='".$month_format."' and users_id='".$id."' and feedback_leadstatus ='Lead_Enrolled' and feedback_leadstatus ='Lead_Enrolled_without_Trial' ";
$add=$conn->query($sli);
$amount = $add->fetch_assoc();
$result["monthwise_count"]=$total;
if($amount['today_leadvalue'] == null){
    $result["monthwise_data"]['today_leadvalue'] = 0;
}else{
    $result["monthwise_data"]=$amount;
}

header('Content-Type: application/json');
echo json_encode($result);


?>
