<!-- Inner Banner Wrapper Start -->
<!-- <div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>404</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php //echo base_url();?>">Home</a></li>
        <li>Pages</li>
        <li>404</li>
      </ul>
    </div>
  </div>
</div> -->
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <div class="inner-wrapper-main not-found">
        <img width="50px" src="<?php echo base_url('assets/img/failure.png');?>">
        <h2>Transaction has failed!</h2>
         <p><?php echo @$message; ?></p>
        <a href="<?php echo base_url('courses');?>">Try placing the order again.</a> </div>
    </div>
  </div>
</section>
<!-- Call to Action start -->
<div class="call-to-action">
  <div class="container">
    <h3>Enroll yourself to our online course</h3>
    <p>Fraud Investigations | Forensic Audits | Risk Assessments</p>
    <a href="<?php echo base_url('courses');?>">Enroll Today</a> </div>
</div>
<!-- Call to Action End -->
<!-- Footer Links Start -->