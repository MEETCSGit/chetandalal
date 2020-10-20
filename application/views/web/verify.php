<style type="text/css">
  .notbold{
    font-weight: normal;
  }
</style>

<link href="<?php echo base_url('assets/');?>css/summernote.css" rel="stylesheet">
<script src="<?php echo base_url('assets/')?>js/summernote.js" type="text/javascript"></script>

<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Verify Documents</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Pages</li>
        <li>Verify Documents</li>
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
   <!--  <h2>Verify  <span>Documents</span></h2> -->
    <div class="row">
      <center>
        <form id="frmflaggedusers" name="frmflaggedusers" method="post" action="<?php echo base_url('verify')?>">
          <div class="col-md-3">
            <!-- <label>Select Users by</label> -->
            <select name="selflagusers" id="selflagusers"  type="text" class="txt">
              <option value="not verified">Not Verified</option>
              <option value="verified">Verified</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="col-md-3">
            <input type="submit" class="btn btn-xs btn-success" value="Get Users">
          </div>
        </form>
      </center>
    </div>
    <hr>
    <?php
      $srno = 0;
      foreach (@$users as $user) {
        if($user['documentverified'] != ''){
          $srno++;
      ?>
        <form method="post" action="<?php echo base_url('verify/verifyUserDocuments/'.$user['id']) ?>">
          <div class="inner-wrapper-main image-styles">
            <div class="case_studies_custom_border">
                <div class="row">
                    <div class="row">
                      <div class="col-md-1">
                        <b>Sr.No</b>
                      </div>
                      <div class="col-md-1">
                        <b>Picture</b>
                      </div>
                      <div class="col-md-2">
                        <b>Name</b>
                      </div>
                      <div class="col-md-2">
                        <b>Email</b>
                      </div>
                      <div class="col-md-3">
                        <b>Documents</b>
                      </div>
                      <div class="col-md-1">
                        <!-- <b>Verify</b> -->
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-1">
                        <?php echo $srno; ?>
                      </div>
                      <div class="col-md-1">
                        <img src="<?php echo $user['profilepicture'] ?> " height="10" width="10">
                      </div>
                      <div class="col-md-2">
                        <?php echo ucfirst(strtolower($user['firstname'])).' '.ucfirst(strtolower($user['lastname'])); ?>
                      </div>
                      <div class="col-md-2">
                        <?php echo $user['email'] ?>
                      </div>
                      <div class="col-md-3">
                        <?php
                          foreach($user['documents'] as $key => $value){
                        ?>
                          <a href="<?php echo $value; ?>" target="_blank" class="btn btn-xs btn-default" id=""><?php echo @$buttonnames[$key]; ?></a>
                        <?php 
                          } 
                        ?>
                      </div>
                      <div class="col-md-1">
                        <?php
                          if($user['documentverified'] == "not verified"){
                        ?> 
                          <input type="submit" class="btn btn-xs btn-primary" value="Verify">
                        <?php
                          }
                          elseif($user['documentverified'] == "rejected"){
                        ?>
                          <input type="submit" class="btn btn-xs btn-danger" value="Rejected" disabled>
                        <?php
                          }
                          elseif($user['documentverified'] == "verified"){
                        ?>
                          <input type="submit" class="btn btn-xs btn-success" value="Verified" disabled>
                        <?php
                          }
                        ?>
                      </div>
                      <?php
                          if($user['documentverified'] == "not verified"){
                        ?>
                        <div class="col-md-1">
                          <a  class="btn btn-xs btn-danger btnreject" 
                              data-toggle="modal" 
                              data-userid="<?php echo $user['id'] ?>"
                              data-email="<?php echo $user['email'] ?>"
                              data-name="<?php echo ucfirst(strtolower($user['firstname'])).' '.ucfirst(strtolower($user['lastname'])) ?>"
                              href='#modal-reject'>Reject</a>
                        </div>
                      <?php
                        }
                      ?>
                    </div>
                </div>
            </div>
          </div>
        </form>
        <br/>
    <?php
        }
      }
    ?>
  </div>
</section>


<div class="modal fade" id="modal-reject">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?php echo base_url('verify/sendRejectionMail')?>">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Reject Document Verification</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label class="notbold">To</label>
              <label name="rejtomailname" id="rejtomailname"></label>
              <input type="hidden" name="rejtomailid" id="rejtomailid">
              <input type="hidden" name="rejtomailuserid" id="rejtomailuserid">
            </div>
          </div>
          <label class="notbold">Select the document that to be rejected.</label>
          <div class="row">
            <div class="col-md-4">
                <label>
                  <input type="checkbox" value="Birth certificate" name="docbc" id="docbc">
                  B.Certi
                </label>
            </div>
            <div class="col-md-4">
                <label>
                  <input type="checkbox" value="Address proof" name="docaddr" id="docaddr"> Address proof
                </label>
            </div>
            <div class="col-md-4">
                <label>
                  <input type="checkbox" value="Graduation certificate" name="docgrad" id="docgrad"> Grad Certi
                </label>
            </div>
            <div class="col-md-4">
                <label>
                  <input type="checkbox" value="Name change certificate" name="docnamechng" id="docnamechng"> N.C certi
                </label>
            </div>
            <div class="col-md-4">
                <label>
                  <input type="checkbox" value="Profile picture" name="docpp" id="docpp"> Profile Picture
                </label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <textarea name="rejmailcontent" id="rejmailcontent" ></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Send Mail</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Call to Action start -->
<!-- <div class="call-to-action">
  <div class="container">
    <h3>Enroll yourself to our online course</h3>
    <p>Fraud Investigations | Forensic Audits | Risk Assessments</p>
    <a href="<?php //echo base_url('register');?>">Register Today</a> </div>
</div> -->
<script type="text/javascript">
  $(document).ready(function(){
    $('.btnreject').on('click', function(){
      // console.log($(this).data());
      $('#rejtomailname').html($(this).data('name'));
      $('#rejtomailid').val($(this).data('email'));
      $('#rejtomailuserid').val($(this).data('userid'));

      // var mailcontheader = 'Following documents have been rejected in the verification process. Please upload valid documents as soon as possible : <br/>';

      // $('#rejmailcontent').summernote('code',mailcontheader);

      
      
      /*var rejdoc = new Array();
      $('#modal-reject input[type=checkbox]').on('change',function(){
        var mailcontbody = '<ol class="ordered-list">';
        if(this.checked){
          rejdoc.push({'key': this.id,'value': this.value});
        }else{
          
          var docid = this.id;
          $.each(rejdoc, function(i, j){
            if(j.key == docid){
              rejdoc.splice(i,1);
              return false;
            }
          });
        }
        $.each(rejdoc, function(i, j){
          mailcontbody+='<li>'+j.value+'</li>';
        });
        mailcontbody+='</ol>';
        $('#rejmailcontent').summernote('code',mailcontheader+mailcontbody);
      });*/
    });


    $('#rejmailcontent').summernote({
      toolbar: false,
      height: 300,
      placeholder: "Please mention reason for rejecting documents."
    });

    $('#selflagusers').val('<?php echo @$userflag?>');
  });

</script>
