 <!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Contact Us</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li>Contact Us</li>
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper contact-wrapper">
  <div class="container">
    <div class="row">
      <div class="inner-wrapper-main">
        <div class="contact-address">
          <div class="col-sm-12 col-md-6 no-space-right">
            <div class="col-sm-6 contact"> <i class="fa fa-map-marker"></i>
              <p><span>Address</span><br>
               308-309, Bombay Market Apt, Tardeo, Mumbai 400034 , INDIA</p>
            </div>
            <div class="col-sm-6 contact white"> <i class="fa fa-envelope"></i>
              <p><span>IT/Technical Support</span><br>
               <?php echo safe_mailto('helpdesk@chetandalal.com');?>
                
                </p>
            </div>
            <div class="col-sm-6 contact white"> <i class="fa fa-envelope"></i>
               <p><span>Training</span><br>
               <?php echo safe_mailto('training@chetandalal.com');?>
                
                </p>
            </div>
            <div class="col-sm-6 contact"> <i class="fa fa-book"></i>
              <p><span>User Guide</span><br>
               <a href="" data-toggle="modal" data-target="#userguide"></i>6 Step User Guide </a>
            </div>           
          </div>
          <div class="col-sm-12 col-md-6 no-space-left">
            <div class="form">
              <form action="<?php echo base_url('contactus/sendmail');?>" method="post" id="contactFrm" name="contactFrm">
                <div class="col-sm-6">
                   <input type="text" required placeholder="First Name" value="" name="firstname" class="txt">
                </div>
                <div class="col-sm-6">
                  <input type="text" required placeholder="Last Name" value="" name="lastname" class="txt">
                </div>               
                <div class="col-sm-6">
                  <input type="text" required placeholder="Mobile No" value="" name="mob" class="txt">
                </div>
                <div class="col-sm-6">
                  <input type="text" required placeholder="Email" value="" name="email" class="txt">
                </div>
                <div class="col-sm-12">
                  <textarea placeholder="Message" maxlength="500" minlength="10" style="height:159px;" name="message" type="text" class="txt_3"></textarea>
                </div>
                <input type="submit" value="submit" name="submit" class="txt2">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="google-map">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3773.0702981450663!2d72.81229841432575!3d18.972502537147353!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xaaab3047294c650e!2sChetan+Dental+Investigations+%26+Management+Services!5e0!3m2!1sen!2sus!4v1489484031218" allowfullscreen></iframe>
        </div>
</section>

