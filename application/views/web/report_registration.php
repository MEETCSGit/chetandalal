<?php
    // $rating_data=json_encode($rating_count_forensic);
?>
<!-- Inner Banner Wrapper Start -->
<link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" rel="stylesheet">

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>

<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Registration Report</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Utils</li>       
        <li>Registration Report</li>       
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <div class="inner-wrapper-main">
        <div class="col-sm-12">         
          <div class="bs-example">
              <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#registreduser">Registered User</a></li>      
                  <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">Paid User <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                          <li><a data-toggle="tab" href="#OnlineGFSU">GFSU</a></li>
                          <li><a data-toggle="tab" href="#OnlineCFACFI">CFACFI</a></li>
                          <li><a data-toggle="tab" href="#Classroom">Classroom</a></li>
                          <li><a data-toggle="tab" href="#Books">Books</a></li>
                          <li><a data-toggle="tab" href="#transaction_failure">Transaction Failure / Bounced </a></li>
                         
                      </ul>
                  </li>
                  <li><a data-toggle="tab" href="#Newsletter">Newsletter Subscription</a></li>
                  
                  <!--li><a data-toggle="tab" href="#Rating">Rating </a></li-->
                  <li class="dropdown">
                      <a data-toggle="dropdown" class="dropdown-toggle" href="#">Rating <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                          <li><a data-toggle="tab" href="#forensic_course">Forensic Accounting Course</a></li>
                          <li><a data-toggle="tab" href="#excel_course">Excel Course</a></li>
                          <li><a data-toggle="tab" href="#cfacfi_course">CFACFI Course</a></li>
                      </ul>
                  </li>
              </ul>
              <div class="tab-content">
                  <div id="registreduser" class="tab-pane fade in active">
                      <div class="row">       
                      <div class="col-sm-12">
                      <br />
                        <table id="tblregistreduser" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>                                 
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>   
                                  <th>Registred On</th>   

                              </tr>
                          </thead>
                          <tbody>
                             <?php
                                  foreach ($register_data['registred_on_site'] as $value){
                                    $mobile=$value['mobile_no']? $value['mobile_no'] : '-';
                                    echo "
                                      <tr>
                                        <td>".ucfirst($value['first_name'])."</td>
                                        <td>".ucfirst($value['last_name'])."</td>
                                        <td>".strtolower($value['email'])."</td>
                                        <td class='custom_center'>".$mobile."</td>
                                        <td data-order='".$value['registred_on']."'>".date('d-m-Y',strtotime($value['registred_on']))."</td>                                        
                                      </tr>
                                    ";
                                  }
                                  ?>
                          </tbody>
                        </table>
                      </div>                     
                    </div>
                  </div>
                  <div id="Newsletter" class="tab-pane fade">
                    <br />
                      <table id="tblNewsletter" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>                                  
                                  <th>Email</th>
                                  <th>Subscription Status</th>                                  
                              </tr>
                          </thead>
                          <tbody>
                             
                                   <?php
                                  foreach ($register_data['news_letter'] as $value){
                                    echo "
                                      <tr>
                                        <td>".$value['emailid']."</td>
                                        <td>".$value['sub_status']."</td>
                                      </tr>
                                    ";
                                  }
                                  ?>
                              
                          </tbody>
                      </table>
                  </div>
                  <div id="OnlineGFSU" class="tab-pane fade table-responsive">
                    <br />
                      <table id="tblonline" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>
                                  <th>City</th> 
                                  <th>Transcation ID</th>
                                  <th>Order date</th>
                                  <th>GST NO</th>
                                  <th>Payment Type</th>
                                  <th>Amount</th>                                  
                                  <th></th>                                  
                              </tr>
                          </thead>
                          <tbody>
                              
                                  <?php
                                  foreach ($register_data['registration_paid_olc'] as $value){
                                    echo "
                                      <tr>
                                        <td>".$value['Name']."</td>
                                        <td>".$value['Email']."</td>
                                        <td>".$value['Phone']."</td>
                                        <td>".ucfirst(strtolower($value['city']))."</td>
                                        <td>".$value['Transaction_ID']."</td>
                                        <td data-order='".$value['orderdatetime']."'>".date('d-m-Y H:i:s',strtotime($value['orderdatetime']))."</td>
                                        <td>".$value['gstin_no']."</td>
                                        <td>".($value['back_door_access']==0 ? 'Online' : 'Offline')."</td>
                                        <td>".$value['order_amt']."</td>
                                        <td><a target='_blank' href=".base_url('user-history/index/'.$value['user_id'])."><i class='fa fa-external-link' aria-hidden='true'></i></a></td>
                                      </tr>
                                    ";
                                  }
                                  ?>
                             
                          </tbody>
                      </table>
                  </div>
                  <div id="OnlineCFACFI" class="tab-pane fade table-responsive">
                    <br />
                    <table id="tblonlinecfacfi" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>City</th> 
                              <th>Transcation ID</th>
                              <th>Order date</th>
                              <th>GST NO</th>
                              <th>Payment Type</th>
                              <th>Amount</th>                                  
                              <th></th>                                  
                          </tr>
                      </thead>
                      <tbody>
                          
                        <?php
                        foreach ($register_data['registration_paid_olc_cfacfi'] as $value){
                          echo "
                            <tr>
                              <td>".$value['Name']."</td>
                              <td>".$value['Email']."</td>
                              <td>".$value['Phone']."</td>
                              <td>".ucfirst(strtolower($value['city']))."</td>
                              <td>".$value['Transaction_ID']."</td>
                              <td data-order='".$value['orderdatetime']."'>".date('d-m-Y H:i:s',strtotime($value['orderdatetime']))."</td>
                              <td>".$value['gstin_no']."</td>
                              <td>".($value['back_door_access']==0 ? 'Online' : 'Offline')."</td>
                              <td>".$value['order_amt']."</td>
                              <td><a target='_blank' href=".base_url('user-history/index/'.$value['user_id'])."><i class='fa fa-external-link' aria-hidden='true'></i></a></td>
                            </tr>
                          ";
                        }
                        ?>
                         
                      </tbody>
                    </table>
                  </div>
                  <div id="Classroom" class="tab-pane fade">
                    <br />
                      <table id="tblclass" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>
                                  <th>City</th> 
                                  <th>Transcation ID</th>
                                  <th>Order date</th>
                                  <th>Amount</th>
                              </tr>
                          </thead>
                          <tbody>
                               <?php
                                  foreach ($register_data['registration_paid_crc'] as $value){
                                    echo "
                                      <tr>
                                        <td>".$value['Name']."</td>
                                        <td>".$value['Email']."</td>
                                        <td>".$value['Phone']."</td>
                                        <td>".ucfirst(strtolower($value['city']))."</td>
                                        <td>".$value['Transaction_ID']."</td>
                                        <td data-order='".$value['orderdatetime']."' >".date('d-m-Y H:i:s',strtotime($value['orderdatetime']))."</td>
                                        <td>".$value['order_amt']."</td>
                                      </tr>
                                    ";
                                  }
                                  ?>
                          </tbody>
                      </table>
                  </div>
                  <div id="Books" class="tab-pane fade">
                    <br />
                      <table id="tblbooks" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>
                                  <th>City</th>  
                                  <th>Delivery Address</th> 
                                  <th>Transcation ID</th>
                                  <th>Order date</th>
                                  <th>Amount</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                  foreach ($register_data['registration_paid_git'] as $value){
                                    $address=$value['address']?$value['address']:'--';
                                    echo "
                                      <tr>
                                        <td>".$value['Name']."</td>
                                        <td>".$value['Email']."</td>
                                        <td>".$value['Phone']."</td>
                                        <td>".ucfirst(strtolower($value['city']))."</td>
                                        <td>".$address."</td>
                                        <td>".$value['Transaction_ID']."</td>
                                        <td data-order='".$value['orderdatetime']."' >".date('d-m-Y H:i:s',strtotime($value['orderdatetime']))."</td>
                                        <td>".$value['order_amt']."</td>
                                      </tr>
                                    ";
                                  }
                                  ?>
                          </tbody>
                      </table>
                  </div>
                  <div id="transaction_failure" class="tab-pane fade table-responsive">
                    <br />
                      <table id="tbltransaction_failure" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Phone</th>
                                  <th>City</th>                                  
                                  <th>Type</th>                                  
                                  <th>Transcation ID</th>
                                  <th>Status</th>
                                  <th>Order date</th>
                                  <th>Amount</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php
                                  foreach ($register_data['transaction_failure'] as $value){
                                    echo "
                                      <tr>
                                        <td>".ucfirst(strtolower($value['Name']))."</td>
                                        <td>".$value['Email']."</td>
                                        <td>".$value['Phone']."</td>
                                        <td>".ucfirst(strtolower($value['city']))."</td>
                                        <td>".$value['c_type']."</td>
                                        <td>".$value['Transaction_ID']."</td>
                                        <td>".$value['status']."</td>
                                        <td data-order='".$value['orderdatetime']."' >".date('d-m-Y H:i:s',strtotime($value['orderdatetime']))."</td>
                                        <td>".$value['order_amt']."</td>
                                      </tr>
                                    ";
                                  }
                                  ?>
                          </tbody>
                      </table>
                  </div>
                  <div id="forensic_course" class="tab-pane fade">
                    <br>                    
                      <table id="tbRating" class="table table-striped table-bordered dt-responsive nowrap" align="center" cellspacing="0" width="100%">                        
                        <thead>
                          <tr>
                            <th class="text-center">Modules</th>
                            <th class="text-center">*</th>
                            <th class="text-center">**</th>
                            <th class="text-center">***</th>
                            <th class="text-center">****</th>
                            <th class="text-center">*****</th>
                            <th class="text-center">Total Ratings</th>
                            <th class="text-center">Total Feedback</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach ($rating_count_forensic as $value){
                              $module_no=substr($value['name'],12,3);
                              echo "<tr><td>".$value['name']."</td>"; 
                              echo check($value['1_Rating_id'],$value['1_Rating'],$value['id']);
                              echo check($value['2_Rating_id'],$value['2_Rating'],$value['id']);
                              echo check($value['3_Rating_id'],$value['3_Rating'],$value['id']);
                              echo check($value['4_Rating_id'],$value['4_Rating'],$value['id']);
                              echo check($value['5_Rating_id'],$value['5_Rating'],$value['id']);

                              if($value['count_rating']==0)
                                echo "<td>".$value['count_rating']."</td>";
                              else
                                echo "<td><a href='#' class='alluserlist' data-toggle='modal' data-target='#userlistmodal' onclick='getAllUser(".$value['id'].")'>".$value['count_rating']." Ratings<a></td>";

                             if($value['feedback_count']==1)
                                echo "<td><a href='#' class='alluserlist' data-toggle='modal' data-target='#userlistmodal' onclick='getAllFeedback(".$module_no.", ".$value['course'].");'>".$value['feedback_count']." Feedback<a></td>";
                             else if($value['feedback_count']!=0)
                                echo "<td><a href='#' class='alluserlist' data-toggle='modal' data-target='#userlistmodal' onclick='getAllFeedback(".$module_no.", ".$value['course'].");'>".$value['feedback_count']." Feedbacks<a></td>";
                              else
                                 echo "<td>0 Feedback</td>";

                              echo "</tr>";
                            }
                            ?>                                                    
                        </tbody>
                      </table>
                  </div>
                  <div id="excel_course" class="tab-pane fade">
                    <br>                    
                      <table id="tbRating" class="table table-striped table-bordered dt-responsive nowrap" align="center" cellspacing="0" width="100%">                        
                        <thead>
                          <tr>
                            <th class="text-center">Modules</th>
                            <th class="text-center">*</th>
                            <th class="text-center">**</th>
                            <th class="text-center">***</th>
                            <th class="text-center">****</th>
                            <th class="text-center">*****</th>
                            <th class="text-center">Total Ratings</th>
                            <th class="text-center">Total Feedback</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach ($rating_count_excel as $value){
                              $module_no=substr($value['name'],12,3);
                              echo "<tr><td>".$value['name']."</td>"; 
                              echo check($value['1_Rating_id'],$value['1_Rating'],$value['id']);
                              echo check($value['2_Rating_id'],$value['2_Rating'],$value['id']);
                              echo check($value['3_Rating_id'],$value['3_Rating'],$value['id']);
                              echo check($value['4_Rating_id'],$value['4_Rating'],$value['id']);
                              echo check($value['5_Rating_id'],$value['5_Rating'],$value['id']);

                              if($value['count_rating']==0)
                                echo "<td>".$value['count_rating']."</td>";
                              else
                                echo "<td><a href='#' class='alluserlist' data-toggle='modal' data-target='#userlistmodal' onclick='getAllUser(".$value['id'].")'>".$value['count_rating']." Ratings<a></td>";

                             if($value['feedback_count']==1)
                                echo "<td><a href='#' class='alluserlist' data-toggle='modal' data-target='#userlistmodal' onclick='getAllFeedback(".$module_no.", ".$value['course'].");'>".$value['feedback_count']." Feedback<a></td>";
                             else if($value['feedback_count']!=0)
                                echo "<td><a href='#' class='alluserlist' data-toggle='modal' data-target='#userlistmodal' onclick='getAllFeedback(".$module_no.", ".$value['course'].");'>".$value['feedback_count']." Feedbacks<a></td>";
                              else
                                 echo "<td>0 Feedback</td>";

                              echo "</tr>";
                            }
                            ?>                                                    
                        </tbody>
                      </table>
                  </div>
                  <div id="cfacfi_course" class="tab-pane fade">
                    <br>                    
                      <table id="tbRating" class="table table-striped table-bordered dt-responsive nowrap" align="center" cellspacing="0" width="100%">                        
                        <thead>
                          <tr>
                            <th class="text-center">Modules</th>
                            <th class="text-center">*</th>
                            <th class="text-center">**</th>
                            <th class="text-center">***</th>
                            <th class="text-center">****</th>
                            <th class="text-center">*****</th>
                            <th class="text-center">Total Ratings</th>
                            <th class="text-center">Total Feedback</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach ($rating_count_cfacfi as $value){
                              $module_no=substr($value['name'],12,3);
                              echo "<tr><td>".$value['name']."</td>"; 
                              echo check($value['1_Rating_id'],$value['1_Rating'],$value['id']);
                              echo check($value['2_Rating_id'],$value['2_Rating'],$value['id']);
                              echo check($value['3_Rating_id'],$value['3_Rating'],$value['id']);
                              echo check($value['4_Rating_id'],$value['4_Rating'],$value['id']);
                              echo check($value['5_Rating_id'],$value['5_Rating'],$value['id']);

                              if($value['count_rating']==0)
                                echo "<td>".$value['count_rating']."</td>";
                              else
                                echo "<td><a href='#' class='alluserlist' data-toggle='modal' data-target='#userlistmodal' onclick='getAllUser(".$value['id'].")'>".$value['count_rating']." Ratings<a></td>";

                             if($value['feedback_count']==1)
                                echo "<td><a href='#' class='alluserlist' data-toggle='modal' data-target='#userlistmodal' onclick='getAllFeedback(".$module_no.", ".$value['course'].");'>".$value['feedback_count']." Feedback<a></td>";
                             else if($value['feedback_count']!=0)
                                echo "<td><a href='#' class='alluserlist' data-toggle='modal' data-target='#userlistmodal' onclick='getAllFeedback(".$module_no.", ".$value['course'].");'>".$value['feedback_count']." Feedbacks<a></td>";
                              else
                                 echo "<td>0 Feedback</td>";

                              echo "</tr>";
                            }
                            ?>                                                    
                        </tbody>
                      </table>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="userlistmodal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">User List</span></span></h4>
      </div>
      <div class="modal-body">
        <div id="userlistdiv"></div>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#tblregistreduser').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#tblNewsletter').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#tblonline').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf', 'print'
        ],
        "columnDefs": [ {
        "targets": 7,
        "orderable": false
        } ]
    });

    $('#tblclass').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#tblbooks').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel', 'pdf', 'print'
        ]
    } );
    var rating_datatable=$('#tbRating').DataTable({
        dom: 'Bfrtip',
        paging: true,
        buttons: [
             'csv', 'excel', 'pdf', 'print'
        ]
    } );
    $('#tbltransaction_failure').DataTable({
        dom: 'Bfrtip',
        paging: true,
        buttons: [
             'csv', 'excel', 'pdf', 'print'
        ]
    } );     
});
</script>

<script type="text/javascript">
  function getUser(choice_data,option_data){    
    var data={
      choice_data : choice_data,
      option_data : option_data
    }
    data=JSON.stringify(data);
    url="<?php echo base_url('registration_report/download_user_rating'); ?>";

    customAjax(url,data);
  }

   function getAllUser(choice_data){      
    var data={
      choice_data : choice_data,
    }
    data=JSON.stringify(data);
    url="<?php echo base_url('registration_report/getAllModuleUser'); ?>";
    customAjax(url,data);
  }

   function userRating(data){   
      if(data['modal_code']==1){
         var userdata=data.userdata;         
         popover_data='';
         for (i = 0; i < userdata.length; i++) { 
            var datetime=toDateTime(userdata[i]['timemodified'])
            popover_data += "<p><span style='float:left;font-size: 18px;'><i class='fa fa-user'></i> "+userdata[i]['username']+"</span><span style='float:right;'><i class='fa fa-calendar'></i> <small><strong>"+(""+datetime).replace("GMT+0530 (India Standard Time)", "")+"</strong></small></span></p><br/><br/><p>"+userdata[i]['value']+"</p><br />";
         }         
         var userlistdiv=$("#userlistmodal").find("#userlistdiv");   
         userlistdiv.html(popover_data);
      }
      else{
         var userdata=data.userdata;
         var popover_data="<table><thead><tr><th>USERS</th></tr></thead><tbody>";
         for (i = 0; i < userdata.length; i++) { 
            var j=i+1;      
            popover_data += "<tr><td colspan='3'>"+[j]+". "+userdata[i].firstname+" "+userdata[i].lastname+"</td></tr>";
         }
         popover_data+= "</tbody></table>";
         var userlistdiv=$("#userlistmodal").find("#userlistdiv");   
         userlistdiv.html(popover_data);
      }
   }

   function getFeedback(userid,choice_data){
      var data={
         userid : userid,
         choice_data : choice_data,
       }
       data=JSON.stringify(data);
       url="<?php echo base_url('registration_report/getFeedback'); ?>";
       customAjax(url,data);
   }

   function getAllFeedback(module, course){
      var data={
         module : module,
         course : course
       }
       data=JSON.stringify(data);
       url="<?php echo base_url('registration_report/getAllFeedback'); ?>";
       customAjax(url,data);
   }
   function toDateTime(secs) {
    var t = new Date(1970, 0, 1); // Epoch
    t.setSeconds(secs);
    return t;
}
</script>


