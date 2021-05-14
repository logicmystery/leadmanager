<?php
session_start();
include "db.php";
$user_id=$_SESSION["id"];
$date = date('Y-m-d H:i:s');
$lead_id = $_POST["lead_id"];
if(!empty($lead_id)){
    if (!empty($_POST["followupfeedback"])) {
      $feedback = $_POST["followupfeedback"];
    } else {
      $feedback = '';
    }
    if (!empty($_POST["enquiry"])) {
      $enquiry = $_POST["enquiry"];
    } else {
      $enquiry = '';
    }
    if (!empty($_POST["gcfeedback"])) {
      $gcfeedback = $_POST["gcfeedback"];
    } else {
      $gcfeedback = '';
    }
    if (!empty($_POST["trail_date"])) {
      $trail_date = $_POST["trail_date"];
    }else {
      $trail_date = '';
    }
    if (!empty($_POST["selecttime"])) {
      $trail_time = $_POST["selecttime"];
    } else {
      $trail_time = '';
    }
    if (!empty($_POST["trainerfeedback"])) {
      $trainerfeedback = $_POST['trainerfeedback'];
    } else {
      $trainerfeedback = '';
    }
    if (!empty($_POST["leadstatus"])) {
      $leadstatus = $_POST['leadstatus'];
    } else {
      $leadstatus = '';
    }
    if (!empty($_POST["number"])) {
      $leadvalue = $_POST['number'];
    } else {
      $leadvalue = 0;
    }
    if (!empty($_POST["followdate"])) {
      $followdate = $_POST["followdate"];
    }else {
      $followdate ='';
    }

    $feedback_sql = "SELECT * FROM feedbacks WHERE feedback_lead_id= " .$lead_id . "";
    $re=$conn->query($feedback_sql);
    $row = $re->fetch_assoc();
    $feedback_id = $row['feedbacks_id'];
    if($gcfeedback == $row['feedback_title']){
      $gcfeedback = $row['feedback_title'];
    }else{
      $gc_followup_feed="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '3','".$date."','".$gcfeedback."')";
      $conn->query($gc_followup_feed);
    }

    if($enquiry == $row['feedback_enquiry']){
      $enquiry = $row['feedback_enquiry'];
    }

    if($feedback== $row['feedback_gcfeedback']){
      $feedback = $row['feedback_gcfeedback'];
    }else{
      $gcf="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '6','".$date."','". $feedback."')";
      $conn->query($gcf);
    }

    if($trainerfeedback == $row['feedback_trainerfeedback']){
      $trainerfeedback =$row['feedback_trainerfeedback'];
    }else{
      $tr_feed="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '5','".$date."','".$trainerfeedback."')";
      $conn->query($tr_feed);
    }

    if($leadstatus == $row['feedback_leadstatus']){
      $leadstatus =$row['feedback_leadstatus'];
    }else{
      if($leadstatus == 'Not_responding' || $leadstatus == 'Not_Responding_After_Trial' || $leadstatus == 'Lead_Enrolled_without_Trial'){
        $lead_status="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '9','".$date."','Status Manual update')";
        $conn->query($lead_status);
      }else if($leadstatus == 'Lead_Enrolled'){
        $lead_status="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '10','".$date."','LeadEnrolled')";
        $conn->query($lead_status);
      }else if($leadstatus == 'Not_Interested'){
        $lead_status="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '11','".$date."','Status Manual update')";
        $conn->query($lead_status);
      }
    }

    if($leadvalue == $row['feedback_leadvalue']){
      $leadvalue =$row['feedback_leadvalue'];
    }else{
      $lead_val="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '8','".$date."','". $leadvalue."')";
      $conn->query($lead_val);
    }

    $sql = "UPDATE `feedbacks` SET `feedback_title`='" . $gcfeedback . "',`feedback_enquiry`='" . $enquiry . "',
    `feedback_gcfeedback`='" . $feedback . "',`feedback_trainerfeedback`='" . $trainerfeedback . "',`feedback_leadstatus`='" . $leadstatus . "',
    `feedback_leadvalue`='" . $leadvalue . "' WHERE feedbacks_id='" . $feedback_id . "'";
    mysqli_query($conn, $sql);
    $newid = base64_encode($lead_id);

    $lead_sql="select * from leads where lead_id = " . $lead_id;
    $resp=$conn->query($lead_sql);
    $lead_data = $resp->fetch_assoc();
   
    if($trail_date == $lead_data['lead_trail_date']){
      $trail_date = $lead_data['lead_trail_date'];
    }else{
      $td="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '4','".$date."','".$trail_date."')";
      $conn->query($td);
    }

    if($trail_time == $lead_data['lead_trail_time']){
      $trail_time = $lead_data['lead_trail_time'];
    }else{
      $t_time="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '4','".$date."','".$trail_time."')";
      $conn->query($t_time);
    }
    if($trail_time !="00:00:00" &&  $trail_date !="0000-00-00"){
      if($trail_time < "21:00:00"){
        $followdate = $trail_date;
      }
    }
    // if($followdate == $lead_data['lead_followupdate']){
    //   $followdate = $lead_data['lead_followupdate'];
    // }else{
    //   $flw_up_date="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '7','".$date."','".$followdate."')";
    //   $conn->query($flw_up_date);  
    // }

    $update_lead = "UPDATE `leads` SET `lead_trail_date` = '".$trail_date."',`lead_trail_time` = '" . $trail_time . "', `lead_followupdate`= '". $followdate ."' WHERE `leads`.`lead_id` = " . $lead_id;
    mysqli_query($conn, $update_lead);
    if($trail_time > "21:00:00"){
      $new_trail_date = date('Y-m-d', strtotime($followdate . ' +1 day'));
      $update_followup = "UPDATE `leads` SET `lead_followupdate`= '". $new_trail_date ."' WHERE `leads`.`lead_id` = ". $lead_id ." ";
      mysqli_query($conn, $update_followup);
      // $flwupdate="INSERT INTO `mapleadactivity` (`mapactivity_lead_id`, `mapactivity_activity_id`,`mapleadactivity_date`,`mapleadactivity_value`) VALUES ('".$lead_id."', '7','".$date."','".$new_trail_date."')";
      // $conn->query($flwupdate); 
     }

    header("Location:form.php?lead_id='".$newid."'");
    exit();
  }
