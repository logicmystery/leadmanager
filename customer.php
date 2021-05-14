<?php
include "header.php";
include "db.php";
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
    height: 200px;
    white-space: nowrap;
  }

  td,
  th {
    width: 230px;

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

  #slideshow>div {
    position: absolute;
    top: 10px;
    left: 5px;
    right: 10px;
    bottom: 10px;
  }

  .swiper-container {
    width: 100%;
    height: 80px;
  }

  .swiper-slide {
    text-align: center;
    font-size: 10px;
    background: #fff;

    /* Center slide text vertically */
    display: -webkit-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    -webkit-align-items: center;
    align-items: center;
  }
</style>
<?php
$id = $_SESSION["id"];
$date = date('Y-m-d');
$current_year = date('Y');
$current_month = date('m');
$sql = "SELECT count(feedback_leadstatus) as today_callcount FROM feedbacks JOIN leads on leads.lead_id = feedbacks.feedback_lead_id JOIN users ON users.users_id=leads.lead_user_id WHERE YEAR(feedback_date) ='" . $current_year . "' AND MONTH(feedback_date) ='" . $current_month . "' and users_id='" . $id . "' AND feedback_leadstatus ='Lead_Enrolled' OR feedback_leadstatus ='Lead_Enrolled_without_Trial' ";
//$sql = "SELECT count(lead_callcount) as total_enrollment FROM leads where lead_user_id='" . $id . "' and monthname(lead_date)='" . $month . "'";
$result = $conn->query($sql);
$monthdata = $result->fetch_assoc();

$sli = "SELECT sum(feedback_leadvalue) as today_leadvalue FROM feedbacks JOIN leads on leads.lead_id = feedbacks.feedback_lead_id JOIN users ON users.users_id=leads.lead_user_id WHERE YEAR(feedback_date) ='" . $current_year . "' AND MONTH(feedback_date) ='" . $current_month . "' and users_id='" . $id . "' AND feedback_leadstatus ='Lead_Enrolled' OR feedback_leadstatus ='Lead_Enrolled_without_Trial' ";
$add = $conn->query($sli);
$amount = $add->fetch_assoc();
?>

<div class="container">
  <div class="row my-3">
    <div class="col-md-4 col-sm-12">
      <div class="text-center text-success"><a href="form.php"><button class="btn btn-sm btn-warning" style="border-radius:25px;">
            <h4>Call Your Leads</h4>
          </button></a></div>
    </div>
    <div class="my-2 col-md-2 text-center">
    </div>
    <!--<label class=""><h5>Previous Months</h5></label></br>
    <input type="month" name="startDate" id="startDate" class="date-picker" />-->
    <div class="col-md-6">
      <!-- <form action="" method="post"> -->
      <div style="float:right; float-top:20px;">
        <a href="#" id="previousmonth">Previous Months</a>
        <div id="date_field" style="display:none;">
          <input type="month" name="startDate" id="startDate" class="date-picker" />
        </div>
      </div>
      <div class="form-group">
        <h5 class="text-success my-2" style="font-size:17px;" id="month_performance">CURRENT MONTH</h5>
      </div>
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <!--<div class="card">
<div class="card-body bg-info">-->
            <div style="border:7px solid skyblue; border-radius:10px;">
              <span class="text-center font-weight-bold" style="font-size:15px;" id="total_enrollment"><?php echo $monthdata['today_callcount']; ?></span><br />
              <!--<input type="text" name="enroll" class="form-control"class="field left" readonly="readonly" value="<?php echo $total['today_callcount']; ?>">-->
              <label class="text-center font-weight-bold " style="padding:5px;">
                <h6>No of Enrollments</h6>
              </label>
              <!--</div>
</div>  -->
            </div>
            <!--<div class="card">
<div class="card-body bg-info">-->
            <div style="border:7px solid skyblue; border-radius:10px; margin:5px;">
              <span class="text-center font-weight-bold" style="font-size:15px;" id="total_conversion"><?php echo $amount['today_leadvalue'] == null ? 0 : $amount['today_leadvalue'] ; ?></span><br />
              <label class="text-center font-weight-bold" style="padding:5px;">
                <h6>Total Conversion</h6>
              </label>
            </div>
            <!-- </div>
</div>-->
          </div>
        </div>
      </div>
      <!-- </form> -->
    </div>
  </div>
</div>

<div class="container">
  <div class="row">

    <div class="col-md-10  m-auto">
      <div class="text-center " style="float:right;"><a href="#" onclick="leads()">View All Leads</a></div>
      <div class=" text-success">
        <a href="#" onclick="today_new_leads()">
          <h5>Follow ups for today</h5>
        </a>
      </div>
    </div>

    <table class="table table-secondary table-hover table-fixed">

      <thead>
        <tr>
          <th>Sl</th>
          <th>Name</th>
          <th id="table_date">Followup Date</th>
          <th>Call</th>
          <th>Others</th>
        </tr>
      </thead>
      <tbody id="tabledata">
        <?php
        $today_leads = "SELECT * FROM leads WHERE lead_user_id= " . $id . " and lead_followupdate = '" . $date . "' ORDER BY lead_id ASC";
        $today_leads_res = mysqli_query($conn, $today_leads);
       // $rowcount=mysqli_num_rows($today_leads_res);
          $count = 1;
          while ($roww = $today_leads_res->fetch_assoc()) {
            $lead_id = $roww["lead_id"];
          ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $roww['lead_name']; ?></td>
              <td><?php echo $roww['lead_date']; ?></td>
              <td><button class="btn btn-warning" onclick="call_feedback(<?php echo $lead_id; ?>),callstatus(<?php echo $lead_id; ?>)"><i class="material-icons"> <a href="tel:<?php echo $roww['lead_phonenumber']; ?>" href="call.php?callid=<?php echo base64_encode($roww['lead_id']); ?>">call</a></i></button></td>
              <td><a href="form.php?lead_id=<?php echo base64_encode($roww['lead_id']); ?>">Details</a></td>
            </tr>
          <?php
           }
       ?>
      </tbody>
    </table>
  </div>
</div>
</div>


<!-- Initialize Swiper -->
<script>
  var swiper = new Swiper('.swiper-container');
</script>
<script>
  $(document).ready(function() {

  });
  $("#startDate").on('change', function() {
    var select_date = $("#startDate").val();
    $.post("monthdata.php", {
      "date_month": select_date
    }, function(resp) {
      console.log(resp);
      $("#total_enrollment").html(resp.monthwise_count.today_callcount);
      $("#total_conversion").html(resp.monthwise_data.today_leadvalue);
      var date = new Date(select_date);  
      var month = date.toLocaleString('default', { month: 'long' });
      var res = month.toUpperCase();
      $("#month_performance").html('PERFORMANCE FOR '+res);
    });
  });

  function leads() {
    $.post("new.php", {}, function(data) {
      if(data.length > 0){
      var append_data = "";
      var count = 1;
      for (var i = 0; i < data.length; i++) {
        append_data += '<tr><td>' + count++ + '</td><td>' + data[i]['lead_name'] + '</td>' +
          '<td>' + data[i]['lead_trail_date'] + '</td><td><button onclick="call_feedback(' + data[i]["lead_id"] + '),callstatus(' + data[i]["lead_id"] + ')" class="btn btn-warning"><i class="material-icons">' +
          '<a href="tel:' + data[i]['lead_phonenumber'] + '"' +
          'href="call.php?callid=' + btoa(data[i]['lead_id']) + '" >call</a></i></button></td>' +
          '<td><a href="form.php?lead_id=' + btoa(data[i]['lead_id']) + '">Details</a></td></tr>';

      }
      $("#table_date").html("Trail Date");
      $('#tabledata').html(append_data);
    }else{
      $('#tabledata').html("Data not found.");
    }

    });

  }

  function today_new_leads() {

    location.reload();
  }
  $("#previousmonth").click(function() {
    $("#date_field").show();
    $("#previousmonth").hide();
  });
  // $("#date_field").change(function(){
  //   var d=$("#startDate").val();
  //   const date = new Date(d);  
  //   const month = date.toLocaleString('default', { month: 'long' });
  //   var res = month.toUpperCase();
  //   $("#month_performance").html(' PERFORMANCE FOR');

  // });

  function call_feedback(lead_id) {
    $('#modal_UpadteSataus').modal('show');
    $('#leadId').val(lead_id);
  }

  function savedata() {
    $('#modal_UpadteSataus').modal('hide');
    var lead_id = $("#leadId").val();
    var call_feedback_new = $("#follow_up").val();
    $.post("activity.php", {
      "lead_id": lead_id,
      "call_feedback_new": call_feedback_new
    }, function(resp) {

    });
    // $.ajax({url: "activity.php",type: 'post',data:{"lead_id":lead_id,"call_feedback_new":call_feedback_new},
    //           dataType: 'html',
    //           success: function (data) {
    //          alert();    
    //       }
    //       });

  }

  function callstatus(lead_id) {
    $.post("status.php", {
      "lead_id": lead_id
    }, function(data) {});
  }
</script>
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
<?php include "footer.php"; ?>