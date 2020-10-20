<link href="<?php echo base_url('assets/');?>css/summernote.css" rel="stylesheet">
<script src="<?php echo base_url('assets/')?>js/summernote.js" type="text/javascript"></script>

<!-- <link href="<?php echo base_url('assets/');?>css/select2.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/')?>js/select2.min.js" type="text/javascript"></script> -->
<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Mail</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Mail</li>
       
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <h2>CDIMS <span> Mails</span> </h2>
      <div class="inner-wrapper-main">
        <div class="col-md-8 col-md-offset-2 ">
          <div class="form">
            <form action="<?php echo base_url('mail/sendMail')?>" method="post" id="mailFrm" name="mailFrm" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                  <label>Mail Type</label>
                  <select name="mailtype" type="text" id="mailtype" class="txt">
                    <option value="1">Article</option>
                    <option value="2">Newsletter</option>
                    <option value="3">Notification</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label>Users</label>
                  <select name="selectall" type="text" id="selectall" class="txt">
                    <option value="1">Selected</option>
                    <option value="2" selected>To all</option>
                  </select>
                </div>
              </div>

              <div id="mail_section">
                <div class="row">
                  <div class="col-md-12">
                    <label>To</label>
                    <input class="txt" type="text" name="tomails">
                  </div>                
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label>CC</label>
                    <input class="txt" type="text" name="ccmails">
                  </div>                
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label>BCC</label>
                    <input class="txt" type="text" name="bccmails">
                  </div>                
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <label>Subject</label>
                  <input class="txt" type="text" name="subject" required>
                </div>                
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <label>Content</label>
                  <textarea id="content" name="content" required></textarea>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-12">
                  <input type="submit" value="Send" name="btn_send" id="btn_send" class="btn btn-primary pull-right" >  
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script type="text/javascript">
$(document).ready(function(){
    
    $('#mail_section').hide();

    $('#mailtype').on('change', function(){
      var mailtype = $('#mailtype').val();
      if(mailtype=='3'){
        // $('#mail_section input').removeAttr('disabled');
        $('#mail_section').show();
        $('#selectall').val('1').change();
      }else{
        // $('#mail_section input').prop('disabled', true);
        $('#mail_section').hide();
        $('#selectall').val('2').change();
      }
    });


    $('#selectall').on('change', function(){
      var selectall = $('#selectall').val();
      if(selectall == '1'){
        // $('#mail_section input').removeAttr('disabled');
        $('#mail_section').show();
      }else{
        // $('#mail_section input').prop('disabled', true);
        $('#mail_section').hide();
      }
    })

    $('#content').summernote({
      // toolbar: false,
      height: 300,
      placeholder: ""
    });


    /*toolbar:[
      ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
    ]*/

    /*$('#btn_edt').on('click', function(){
      $("input").removeAttr('disabled');


      var updateBtnTemplate = '<input type="button" value="Update" name="btn_update" id="btn_update" class="btn btn-success pull-right" >'+
                  '<input type="button" value="Cancel" name="btn_cancel" id="btn_cancel" class="btn btn-danger pull-left btn_cancel" >';

      $('div.div_edit').replaceWith(updateBtnTemplate);
    });*/


    
});


</script>


