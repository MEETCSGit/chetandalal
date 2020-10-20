<style type="text/css">
.background-image1{
  background-image: url('<?php echo base_url()?>assets/img/Doc1.jpg');height: 100%;width:100%;
  background-size: 100% 100%;
}
.background-image2{
  background-image: url('<?php echo base_url()?>assets/img/Doc2.jpg');height: 100%;width:100%;
  background-size: 100% 100%;
}
</style>
<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Con-Test for NMIMS</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Pages</li>
        <li>Con-Test for NMIMS</li>
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <div class="inner-wrapper-main not-found">
        <div class="row">
          <div class="col-md-6" style="height: 500px;">
            <div class="background-image1"></div>
          </div>
          <div class="col-md-6" style="height: 500px;">
            <div class="background-image2"></div>
          </div>
        </div> 
      </div>
    </div>
  </div>
</section>
<!-- Call to Action start -->
<div class="call-to-action">
  <div class="container">
    <h3>Enroll yourself to our online course</h3>
    <p>Fraud Investigations | Forensic Audits | Risk Assessments</p>
    <a href="<?php echo base_url('register');?>">Register Today</a> </div>
</div>
<!-- Call to Action End -->
<!-- Footer Links Start-->

<script type="text/javascript" language="javascript">
    $(function() {
        $(this).bind("contextmenu", function(e) {
            e.preventDefault();
        });
    }); 

    $(document).keydown(function (event) {
      if (event.keyCode == 123) { // Prevent F12
          return false;
      } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
          return false;
      }
  });
</script>