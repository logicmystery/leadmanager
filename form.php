<?php
include "header.php";
include "db.php"; // Using database connection file here
?>
<style>
  .column {
    width: 100%;
  }

  @media (min-width: 600px) {
    .column {
      width: 50%;
    }
  }

  @media only screen and (min-width: 280px) {
    .current-status {
      width: 40%;
    }
  }

  @media only screen and (min-width: 1024px) {
    .current-status {
      width: auto;
    }
  }

  .new {
    overflow-x: scroll;
  }

  thead {
    display: block;
  }

  tbody {
    display: block;
    overflow-y: auto;
    overflow-x: auto;
    height: 180px;
    white-space: nowrap;
  }

  td,
  th {
    width: 100%;

  }

  table {
    width: auto;
    white-space: nowrap;

  }

  #slideshow {
    margin: 20px auto;
    position: relative;
    width: 350px;
    height: 120px;
    padding: 7px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
  }

  .lead-details {
    font-size: 28px;
  }

  .current-status {
    float: right;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 2px;
    background-color: gold;
  }

  .message {
    /* text-align: center; */
    color: green;
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
  }
</style>
<?php
$id = $_SESSION["id"];
if (isset($_GET['lead_id'])) {
  $lead_id = base64_decode($_GET['lead_id']);
}
$today = date("Y-m-d");

//die(222);
if (!empty($lead_id)) {
  $q = "SELECT * FROM `leads` LEFT JOIN feedbacks ON leads.lead_id=feedbacks.feedback_lead_id WHERE leads.lead_id=" . $lead_id . "";


  $qry = mysqli_query($conn, $q);
  $data = $qry->fetch_assoc();
  $lead_name = $data['lead_name'];
  $lead_email = $data['lead_email'];
  $lead_phonenumber = $data['lead_phonenumber'];
  $lead_jobtitle = $data['lead_jobtitle'];
  $feedback_title = $data['feedback_title'];
  $feedback_date = $data['feedback_date'];
  $feedback_enquiry = $data['feedback_enquiry'];
  $feedback_gcfeedback = $data['feedback_gcfeedback'];
  $feedback_selectdate = $data['lead_trail_date'];
  $feedback_selecttime = $data['lead_trail_time'];
  $feedback_trainerfeedback = $data['feedback_trainerfeedback'];
  $feedback_leadstatus = $data['feedback_leadstatus'];
  $feedback_followupdate = $data['lead_followupdate'];
  $feedback_leadvalue = $data['feedback_leadvalue'];
} else {
  $today_last = "SELECT COUNT(*) AS total_tead FROM `leads` WHERE lead_date = '" . $today . "' AND lead_user_id = " . $id . "";
  $resp = $conn->query($today_last);
  $total_result = $resp->fetch_assoc();
  $fetch_date = '';
  $dec_day = 1;

  if ($total_result['total_tead']  == 0) {
    for ($i = 0; $i < $dec_day; $i++) {
      $fetch_date = date('Y-m-d', strtotime('-' . $dec_day . ' day'));
      $sqli = "SELECT COUNT(*) AS total_tead FROM `leads` WHERE lead_date = '" . $fetch_date . "' AND lead_user_id = " . $id . "";

      $dataxx = $conn->query($sqli);

      $totalResult = $dataxx->fetch_assoc();
      if ($totalResult['total_tead'] == 0) {
        $dec_day = $dec_day + 1;
      }
    }
  } else {
    $fetch_date = date("Y-m-d");
  }
  $feedback_sql = "SELECT  COUNT(feedbacks_id) as feedbacks_count FROM leads LEFT JOIN feedbacks ON leads.lead_id=feedbacks.feedback_lead_id WHERE lead_user_id= " . $id . " AND lead_date= '" . $fetch_date . "'";
  $re = $conn->query($feedback_sql);
  $row = $re->fetch_assoc();
  $feedbackCount = $row['feedbacks_count'];
  if ($feedbackCount == 0) {
    $feedbackStatus = "";
  } else {
    $feedbackStatus = " AND feedback_leadstatus !='Lead_Enrolled' AND feedback_leadstatus !='Lead_Enrolled_without_Trial'";
  }
  $sql = "SELECT * FROM leads LEFT JOIN feedbacks ON leads.lead_id=feedbacks.feedback_lead_id WHERE lead_user_id= " . $id . " AND lead_date= '" . $fetch_date . "' $feedbackStatus  ORDER BY lead_id DESC LIMIT 1";

  $res = $conn->query($sql);
  $count = $res->num_rows;
  if ($count > 0) {
    $total = $res->fetch_assoc();
    $lead_id = $total['lead_id'];
    $lead_name = $total['lead_name'];
    $lead_email = $total['lead_email'];
    $lead_phonenumber = $total['lead_phonenumber'];
    $lead_jobtitle = $total['lead_jobtitle'];
    $feedback_title = $total['feedback_title'];
    $feedback_date = $total['feedback_date'];
    $feedback_enquiry = $total['feedback_enquiry'];
    $feedback_gcfeedback = $total['feedback_gcfeedback'];
    $feedback_selectdate = $total['lead_trail_date'];
    $feedback_selecttime = $total['lead_trail_time'];
    $feedback_trainerfeedback = $total['feedback_trainerfeedback'];
    $feedback_leadstatus = $total['feedback_leadstatus'];
    $feedback_followupdate = $total['lead_followupdate'];
    $feedback_leadvalue = $total['feedback_leadvalue'];
  } else {
    $lead_id = 0;
  }
}

// $feedbackstatus = "";
// if (empty($feedback_gcfeedback)) {
//   $feedbackstatus = "Disabled";
// } else {
//   $feedbackstatus = "";
// }
// $feedbacktime = "";
// if (empty($feedback_selectdate)) {
//   $feedbacktime = "Disabled";
// } else {
//   $feedbacktime = "";
// }
// $follow_status = "";
// if (empty($feedback_selectdate) && empty($feedback_selecttime)) {
//   $follow_status = "Disabled";
// } else {
//   $follow_status = "";
// }
?>
<!-- <p>bg-info</p> -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-12 m-auto" style="padding: 20px;">
      <?php if (!empty($_SESSION["message"])) { ?>
        <div class="message"><?php echo $_SESSION["message"];
                              unset($_SESSION["message"]);
                              ?></div>
      <?php } ?>
      <div class="card bg-secondary" style="border-radius: 13px;box-shadow: 0 0 20px rgba(0,0,0,0.4);">
        <div class="card-body">
          <div class="text-center">
            <span class="text-center text-white font-weight-bold lead-details">Lead Details</span><b><span class="current-status"></span></b>
          </div>
          <div class="form-group">
            <label class="text-white">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo $lead_name; ?>" class="field left" readonly="readonly">
          </div>
          <div class="form-group">
            <label class="text-white">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo $lead_email; ?>" class="field left" readonly="readonly">
          </div>
          <label class="text-white">Mobile</label>
          <div class="form-inline">
            <input type="text" class="form-control" name="number" value="<?php echo $lead_phonenumber; ?>" class="field left" readonly="readonly">
            <button onclick="callstatus(<?php echo $lead_id; ?>)" class="btn btn-warning"><i class="material-icons"><a href="tel:<?php echo $lead_phonenumber; ?>">call</a></i></button>
          </div>
          <div class="form-group">
            <label class="text-white">Occupation</label>
            <input type="text" class="form-control" name="ocupation" value="<?php echo $lead_jobtitle; ?>" class="field left" readonly="readonly">
          </div>
          <form action="feedback.php" method="post" autocomplete="off" onsubmit="return confirm('Do you want to save?');">
            <input type="hidden" name="lead_id" value="<?php echo $lead_id; ?>">
            <div class="form-group">
              <label class="text-white">Enquired for</label>
              <input type="text" class="form-control" name="enquiry" id="enquiry" value="<?php echo $feedback_enquiry; ?>">
              <button id="btn_enq" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>
            <div class="form-group">
              <label class="text-white">GC Feedback</label>
              <textarea rows="4" cols="100" class="form-control" name="gcfeedback" id="gcfeedback"><?php echo $feedback_title; ?></textarea>
              <button id="btn_gcfck" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>

            <div class="form-group">
              <label class="text-white">Select Trial Trainer</label>
              <table class="table table-secondary table-hover table-fixed" id="trainer_table" value="">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Contact No</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
              <button id="trail_traineer" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>
            <div class="form-group">
              <label class="text-white">Select Trial Date</label>
              <input type="text" class="form-control" name="trail_date" id="trail_date" value="<?php echo $feedback_selectdate; ?>">
              <button id="btn_trail_date" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>

            <div>
              <label class="text-white">Select Trial Time</label>
              <?php
              $start = strtotime('07:00 AM');
              $end = strtotime('10:30 PM');
              ?>
              <select name="selecttime" id="trail_time">
                <option value="00:00:00">H:i</option>
                <?php for ($i = $start; $i <= $end; $i += 1800) {
                  if ($feedback_selecttime == date('H:i', $i) . ":00") { ?>
                    <option value='<?php echo date('H:i', $i) . ":00"; ?>' selected><?php echo date('H:i', $i); ?></option>
                  <?php } else { ?>
                    <option value='<?php echo date('H:i', $i) . ":00"; ?>'><?php echo date('H:i', $i); ?></option>
                <?php }
                } ?>
              </select>
              <button id="btn_trail_time" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>
            <div class="form-group">
              <label class="text-white">Trainer Feedback</label>
              <textarea rows="4" cols="100" class="form-control" name="trainerfeedback" id="trainer_feedback"><?php echo $feedback_trainerfeedback; ?></textarea>
              <button id="btn_trainerfeedback" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>
            <div class="form-group">
              <label class="text-white">Set a Follow Up Date</label>
              <input type="text" class="form-control" name="followdate" id="followdate" value="<?php echo  $feedback_followupdate; ?>" readonly>
              <button id="btn_flw_date" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>


            <div class="form-group">
              <label class="text-white">GC Followup Feedback</label>
              <textarea rows="4" cols="100" class="form-control" name="followupfeedback" row="5" id="gc_follow_up_feedback"><?php echo $feedback_gcfeedback; ?></textarea>
              <button id="btn_flw_feedback" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>
            <div>
              <label class="text-white">Update lead Status</label>
              <select name="leadstatus" value="<?php echo $feedback_leadstatus; ?>" id="lead_status">
                <option value="">Tap on New Lead</option>
                <option value="Lead_Assigned">Lead Assigned</option>
                <option value="In_touch">In touch</option>
                <option value="Trial_Scheduled">Trial Scheduled</option>
                <option value="Trial_Conducted">Trial Conducted</option>
                <option value="Followup_Inprogress">Followup Inprogress</option>
                <option value="Awaiting_payment">Awaiting payment</option>
                <option value="Not_responding">Not responding</option>
                <option value="Not_Responding_After_Trial">Not Responding After Trial</option>
                <option value="Not_Interested">Not Interested</option>
                <option value="Reassigned">Reassigned</option>
                <option value="Lead_Enrolled_without_Trial">Lead Enrolled (without Trial)</option>
                <option value="Lead_Enrolled">Lead Enrolled</option>
              </select>
              <button id="btn_status" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>
            <div class="form-group">
              <label class="text-white">Deal Value</label>
              <input type="number" name="number" id="deal_value" class="form-control" value="<?php echo $feedback_leadvalue; ?>">
              <button id="btn_deal" type="submit" class="btn btn-warning" style="display:none;"><i class="fa fa-check" style="font-size:20px;color:seagreen;"></i></button>
            </div>
            <?php
            $qy = "SELECT users_id,users_name FROM users WHERE users_id != " . $id . " ";
            $qqy = mysqli_query($conn, $qy);
            ?>
            <select name="assign_pool" id="assign_pool">
              <option value="">Select Option</option>
              <option value="assign_to_pool">Assign To Pool</option>
              <?php
              while ($persons = $qqy->fetch_assoc()) {
                $username = $persons['users_name'];
                $userid = $persons['users_id'];
                echo "<option value='$userid'>" . $username . " (" . $userid . ")</option>";
              }
              ?>
            </select>
            <div class="btn-group">
              <button type="button" onclick="assign_to_pool(<?php echo $lead_id; ?>)" class="btn btn-success" style="width:100px;">Assign</button>
            </div>

          </form>
        </div>
      </div>
      </br>
      <div class="container-fluid">
        <div class="row">
          <label style="margin: auto;color: deeppink;"><b>Activity History</b></label>
          <div class="col-md-12 col-12" style="overflow-x:auto;" id="lead_activity">
            <table class="table table-bordered" style="background-color: aliceblue;">
              <thead>
                <tr>
                  <th>Activity Date</th>
                  <th>Activity Description</th>
                  <th>Activity Value</th>
                </tr>
              </thead>
              <tbody id="table_call">
                <?php
                $followupdate_menuall_set = 0;
                $today_activity = "SELECT * FROM mapleadactivity JOIN activitys ON activitys.activity_id=mapleadactivity.mapactivity_activity_id JOIN leads ON leads.lead_id=mapleadactivity.mapactivity_lead_id JOIN users ON users.users_id=leads.lead_user_id WHERE mapleadactivity.mapactivity_lead_id= " . $lead_id . " AND users.users_id= " . $id . " ORDER BY mapleadactivity.mapleadactivity_date DESC";
                if ($today_leads_result = mysqli_query($conn, $today_activity)) {
                  while ($row = $today_leads_result->fetch_assoc()) {
                    if ($row['mapactivity_activity_id'] == 7) {
                      $followupdate_menuall_set = 1;
                    }
                ?>
                    <tr>
                      <td><?php echo $row['mapleadactivity_date']; ?></td>
                      <td><?php echo $row['activity_description']; ?></td>
                      <td><?php echo $row['mapleadactivity_value']; ?></td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="fixed-bottom ">
            <a href="customer.php"> <button type="button" class="btn btn-sm btn-success" style="width:85px;">Back</button></a>

            <a href="#"> <button type="button" id="btn_pre" onclick="previous_lead(<?php echo $lead_id; ?>)" class="btn btn-sm btn-success" style="width:85px;">Previous</button></a>

            <a href="#"><button type="button" id="btn_next" onclick="next_lead(<?php echo $lead_id; ?>)" class="btn btn-sm btn-success" style="width:85px;">Next</button></a>

            <a href="#"><button type="button" class="btn btn-sm btn-success" onclick="check_available_lead()" style="width:85px;">New Lead</button></a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal_UpadteSataus">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Enter Call Feedback</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
        <!-- <span aria-hidden="true">&times;</span> -->
        <!-- </button> -->
      </div>
      <div class="modal-body">
        <!--<p>Modal body text goes here.</p>-->
        <input type="hidden" name="leadId" id="leadId">
        <textarea rows="2" cols="100" class="form-control" name="followdate" id="follow_up"></textarea>
        <!-- <div class="modal-footer">-->
        <div style="text-align: center;margin-top: 5px;">
          <button type="submit" onclick="savedata()" class="btn btn-primary">Save</button>
        </div>
      </div>

      <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
    </div>
  </div>
</div>
</div>
<script>
  function savedata() {
    $('#modal_UpadteSataus').modal('hide');
    var lead_id = $("#leadId").val();
    var call_feedback_new = $("#follow_up").val();
    $.post("activity.php", {
      "lead_id": lead_id,
      "call_feedback_new": call_feedback_new
    }, function(resp) {
      if (resp.status == 'success') {
        location.reload();
      }
    });
  }

  //$("#trail_time").change(function(){
  //   var gc_feedback=$("#gcfeedback").val();
  // if(gc_feedback ==''){
  // $("#lead_status").val('lead_assigned');

  // }
  // var gc_feedback=$("#gcfeedback").val();
  // var trail_date=$("#trail_date").val();
  // if(gc_feedback !=''&& trail_date ==''){
  // $("#lead_status").val('in_touch');

  // }
  // var trail_date=$("#trail_date").val();
  // if(trail_date!='null'){
  // $("#lead_status").val('trial_scheduled');
  // }
  // var trainer_feedback=$("#trainer_feedback").val();
  // if(trainer_feedback !=''){
  // $("#lead_status").val('trial_conducted');
  // }
  // var followdate=$("#followdate").val();
  // console.log(followdate);
  // //var dt = new Date();
  // // var today_date=(dt.getMonth()+1) + "/"
  //  //               + dt.getDate() + "/" 
  // //                + dt.getFullYear();
  // //console.log(today_date);
  // /*if(followdate != ''){
  // $("#lead_status").val('followup_inprogress');
  // }*/
  // var deal_value=$("#deal_value").val();
  // if(deal_value >0){
  // $("#lead_status").val('awaiting_payment');
  // }
  function preCheck() {
    if (confirm('Do you want to send feedback ?')) {
      return true;
    } else {
      return false;
    }
  }
  $(document).ready(function() {
    $(".message").hide(4000);
    var btn_count = 0;
    $('#gcfeedback').keyup(function() {
      var resp = $("#lead_activity>table>tbody>tr:first").trigger('click');
      if (resp[0].lastElementChild.innerHTML != 'Lead was called') {
        alert("Please call your lead first then update GC feedback.");
        $('#gcfeedback').val('');
        $('#gcfeedback').attr("readonly", true);
      } else {
        $('#gcfeedback').attr("readonly", false);
        if ($(this).val() != '') {
          $('#btn_gcfck').show();
          showHidePreNext(1);
          // $('#enquiry').val('');
          $('#btn_enq').hide();
          $('#btn_trail_date').hide();
          $('#btn_trail_time').hide();
          $('#btn_trainerfeedback').hide();
          $('#btn_flw_date').hide();
          $('#btn_flw_feedback').hide();
          $('#btn_deal').hide();
        } else {
          $('#btn_gcfck').hide();
          $('#btn_enq').hide();
          $('#btn_trail_date').hide();
          $('#btn_trail_time').hide();
          $('#btn_trainerfeedback').hide();
          $('#btn_flw_date').hide();
          $('#btn_flw_feedback').hide();
          $('#btn_deal').hide();
          showHidePreNext(0);
        }
      }
    });
    $('#enquiry').keyup(function() {
      if ($(this).val() != '') {
        $('#btn_enq').show();
        showHidePreNext(1);
        // $('#gcfeedback').val('');
        $('#btn_gcfck').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      } else {
        showHidePreNext(0);
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      }
    });
    $('#trail_date').click(function() {
      if ($(this).val() != '') {
        showHidePreNext(1);
        $('#btn_trail_date').show();
        // $('#gcfeedback').val('');
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      } else {
        showHidePreNext(0);
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      }
    });
    $('#trail_time').change(function() {
      if ($(this).val() != '') {
        showHidePreNext(1);
        $('#btn_trail_time').show();
        // $('#gcfeedback').val('');
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      } else {
        showHidePreNext(0);
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      }
    });
    $('#trainer_feedback').keyup(function() {
      if ($(this).val() != '') {
        showHidePreNext(1);
        $('#btn_trainerfeedback').show();
        // $('#gcfeedback').val('');
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      } else {
        showHidePreNext(0);
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      }
    });
    $('#followdate').click(function() {
      if (trail_date !== '0000-00-00' && trail_time !== '00:00:00') {
        $('#followdate').attr("readonly", false);
      }
      if ($(this).val() != '') {
        showHidePreNext(1);
        $('#btn_flw_date').show();
        // $('#gcfeedback').val('');
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      } else {
        showHidePreNext(0);
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      }
    });
    $('#gc_follow_up_feedback').keyup(function() {
      var resp = $("#lead_activity>table>tbody>tr:first").trigger('click');
      var trailDate = $('#trail_date').val();
      var trailTime = $('#trail_time').val();
      var trail_date = trailDate + ' ' + trailTime;
      var today = "<?php echo date('Y-m-d H:i:s'); ?>";

      if (resp[0].lastElementChild.innerHTML != 'Lead was called') {
        alert("Please call your lead first then update GC followup feedback.");
        $('#gc_follow_up_feedback').val('');
        $('#gc_follow_up_feedback').attr("readonly", true);
      } else if (trail_date <= today) {
        alert("Please set trail datetime greater than current datetime then update GC followup feedback.");
        $('#gc_follow_up_feedback').val('');
        $('#gc_follow_up_feedback').attr("readonly", true);
      } else {
        $('#gc_follow_up_feedback').attr("readonly", false);
        if ($(this).val() != '') {
          showHidePreNext(1);
          $('#btn_flw_feedback').show();
          // $('#gcfeedback').val('');
          $('#btn_gcfck').hide();
          $('#btn_enq').hide();
          $('#btn_trail_date').hide();
          $('#btn_trail_time').hide();
          $('#btn_trainerfeedback').hide();
          $('#btn_flw_date').hide();
          $('#btn_deal').hide();
        } else {
          showHidePreNext(0);
          $('#btn_gcfck').hide();
          $('#btn_enq').hide();
          $('#btn_trail_date').hide();
          $('#btn_trail_time').hide();
          $('#btn_trainerfeedback').hide();
          $('#btn_flw_date').hide();
          $('#btn_flw_feedback').hide();
          $('#btn_deal').hide();
        }
      }
    });
    $('#deal_value').keyup(function() {
      if ($(this).val() != '') {
        showHidePreNext(1);
        $('#btn_deal').show();
        // $('#gcfeedback').val('');
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
      } else {
        showHidePreNext(0);
        $('#btn_gcfck').hide();
        $('#btn_enq').hide();
        $('#btn_trail_date').hide();
        $('#btn_trail_time').hide();
        $('#btn_trainerfeedback').hide();
        $('#btn_flw_date').hide();
        $('#btn_flw_feedback').hide();
        $('#btn_deal').hide();
      }
    });

    var currStatus = "";
    var name = $("#name").val();
    var gc_feedback = $("#gcfeedback").val();
    var trail_date = $("#trail_date").val();
    var trail_time = $("#trail_time").val();
    var trainer_feedback = $("#trainer_feedback").val();
    var followdate = $("#followdate").val();
    var deal_value = $("#deal_value").val();
    if (name == '') {
      currStatus = "";
    } else if (gc_feedback == '') {
      currStatus = "Lead_Assigned";
    } else if (gc_feedback != '') {
      currStatus = "In_touch";
    }
    if (trail_date !== '0000-00-00' && trail_time !== '00:00:00') {
      $('#followdate').attr("readonly", false);
      currStatus = "Trial_Scheduled";
    }
    if (trainer_feedback != '') {
      currStatus = "Trial_Conducted";
    }
    var followupdate_menuall_set = <?php echo $followupdate_menuall_set ?>;
    if (followdate != '0000-00-00' && followupdate_menuall_set == 1) {
      currStatus = "Followup_Inprogress";
    }
    if (deal_value != 0) {
      currStatus = "Awaiting_payment";
    }
    var saveSatatus = "<?php echo $feedback_leadstatus; ?>";
    if (saveSatatus == "Lead_Enrolled") {
      currStatus = "Lead_Enrolled";
    } else if (saveSatatus == "Not_responding") {
      currStatus = "Lead_Enrolled";
    } else if (saveSatatus == "Not_Interested") {
      currStatus = "Not_Interested";
    } else if (saveSatatus == "Not_Responding_After_Trial") {
      currStatus = "Not_Responding_After_Trial";
    } else if (saveSatatus == "Lead_Enrolled_without_Trial") {
      currStatus = "Lead_Enrolled_without_Trial";
    }
    $("#lead_status").val(currStatus);
    console.log(currStatus);
    if (currStatus != '') {
      var str_replace = currStatus.replace("_", " ");
    } else {
      var str_replace = "Tap on New Lead";
    }

    $('.current-status').html(str_replace);
    $("#trail_date").datepicker({
      dateFormat: "yy-mm-dd",
      minDate: 0,
      onSelect: function(date) {
        var dt2 = $('#followdate');
        var startDate = $(this).datepicker('getDate');
        var minDate = $(this).datepicker('getDate');
        dt2.datepicker('setDate', minDate);
        startDate.setDate(startDate.getDate() + 30);
        //sets dt2 maxDate to the last day of 30 days window
        dt2.datepicker('option', 'maxDate', startDate);
        dt2.datepicker('option', 'minDate', minDate);
        $(this).datepicker('option', 'minDate', minDate);
      }
    });
    var diff = Math.floor((Date.parse(trail_date) - Date.parse("<?php echo $today; ?>")) / 86400000);
    $('#followdate').datepicker({
      dateFormat: "yy-mm-dd",
      minDate: diff
    });
  });

  $('#lead_status').change(function() {
    var change_status = $('#lead_status').val();
    if (change_status == 'Not_responding' || change_status == 'Not_Interested' || change_status == 'Not_Responding_After_Trial' || change_status == 'Lead_Enrolled_without_Trial' || change_status == 'Lead_Enrolled') {
      $('#btn_status').show();
    }
  });

  function assign_to_pool(lead_id) {
    var assign = $('#assign_pool').val();
    $.post("assign_to_pool.php", {
      "lead_id": lead_id,
      "assign": assign
    }, function(resp) {
      if (resp.lead_id > 0 && resp.lead_id != null && resp.lead_id != '') {
        window.location.href = "/learning_crm/form.php?lead_id=" + btoa(resp.lead_id);
      } else {
        window.location.href = "/learning_crm/form.php";
      }
    });
  }

  // function gcFllowupDate(lead_id) {
  $('#btn_flw_date').click(function() {
    var lead_id = <?php echo $lead_id; ?>;
    var fllowupdate = $('#followdate').val();
    $.post("update_gcfllowup_date.php", {
      "lead_id": lead_id,
      "fllowupdate": fllowupdate
    }, function(resp) {

    });
  });

  //}


  function showHidePreNext(btn_count) {
    if (btn_count > 0) {
      $('#btn_pre').prop("disabled", true);
      $('#btn_next').prop("disabled", true);
    } else {
      $('#btn_pre').prop("disabled", false);
      $('#btn_next').prop("disabled", false);
    }
  }

  function valid_trail_date() {
    var update_time = $("#trail_time").val();
    var update_date = $("#trail_date").val();

    var current_date = new Date();
    var time = current_date.getHours() + ":" + current_date.getMinutes();
    var today_date = current_date.getFullYear() + "-" +
      (current_date.getMonth() + 1) + "-" +
      current_date.getDate();
    if (update_date == today_date && update_time > '21:00') {
      var increase_date = newupdate_date.setDate(newupdate_date.getDate() + 1);

      $.post("updatetraildate.php", {
        "newupdate_date": increase_date
      }, function(data) {

      });
    }
  }

  function update_activity(text, lead_id) {
    if (text == "leadassign") {
      insert_data(lead_id, 1);
    }

  }

  function insert_data(id, activity_id) {
    $.post("activity.php", {
      "map_activity_id": id,
      "activity": activity_id
    }, function(data) {

    });
  }

  function callstatus(lead_id) {
    $('#modal_UpadteSataus').modal('show');
    $('#leadId').val(lead_id);

    $('#gcfeedback').attr("readonly", false);
    $('#gc_follow_up_feedback').attr("readonly", false);
    $.post("status.php", {
      "lead_id": lead_id
    }, function(data) {
      var append_data = "";
      var count = 1;
      for (var i = 0; i < data.length; i++) {
        append_data += '<tr><td>' + data[i].mapleadactivity_date + '</td><td>' + data[i]['activity_description'] + '</td><td>' + data[i]['mapleadactivity_value'] + '</td></tr>';
      }
      $('#table_call').html(append_data);
    });
  }
  // $("#enquiry").click(function() {
  //   $("#btn_enq").show();
  // });
  // // $("#gcfeedback").click(function() {
  // //   $("#btn_gcfck").show();
  // // });
  // $("#trainer_table").click(function() {
  //   $("#trail_traineer").show();
  // });
  // $("#trail_date").click(function() {
  //   $("#btn_trail_date").show();
  // });
  // $("#trail_time").click(function() {
  //   $("#btn_trail_time").show();
  // });
  // $("#trainer_feedback").click(function() {
  //   $("#btn_trainerfeedback").show();
  // });
  // $("#followdate").click(function() {
  //   $("#btn_flw_date").show();
  // });
  // $("#feedback_trail_date").click(function() {
  //   $("#btn_flw_feedback").show();
  // });
  // $("#deal_value").click(function() {
  //   $("#btn_deal").show();
  // });
  // $(function() {

  function check_available_lead() {
    $.post("check_available_lead.php", {}, function(resp) {
      if (resp.available_lead > 0) {
        window.location.href = "/learning_crm/data.php";
      } else {
        alert("New Lead Not Available!");
      }
    });
  }

  function next_lead(lead_id) {
    console.log(lead_id);
    if (lead_id != 0) {
      $.post("next_lead.php", {
        "lead_id": lead_id
      }, function(resp) {
        if (resp.lead_id > 0 && resp.lead_id != null && resp.lead_id != '') {
          window.location.href = "/learning_crm/form.php?lead_id=" + btoa(resp.lead_id);
        } else {
          alert("Next lead not available, Please assign a new lead.");
        }
      });
    } else {
      alert("Lead not available, Please assign a new lead.");
    }
  }

  function previous_lead(lead_id) {
    if (lead_id != 0) {
      $.post("previous_lead.php", {
        "lead_id": lead_id
      }, function(resp) {
        if (resp.lead_id > 0 && resp.lead_id != null && resp.lead_id != '') {
          window.location.href = "/learning_crm/form.php?lead_id=" + btoa(resp.lead_id);
        } else {
          alert("Previous lead not available!");
        }
      });
    } else {
      alert("Lead not available, Please assign a new lead.");
    }
  }
</script>
<?php include "footer.php"; ?>