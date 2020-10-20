<!-- Footer Links Start-->
<style type="text/css">
  .mt-10{
    margin-top: 10px;
  }
  .userguide-header{
    padding-right: 10px;
    border-bottom: 0px solid #e5e5e5;
    padding-top: 10px;
    padding-bottom: 0px;
  }
</style>
<footer>
  <div class="container">
    <div class="col-sm-3 wow fadeInDownBig animate " data-wow-duration="1s"><img src="<?php echo base_url('assets/');?>img/CD_LOGO1.png" alt="Chetandalal Investigation"> </div>
    <div class="col-sm-5">
      <div class="contactus">
        <h2>Contact Us</h2>
        <ul class="list-ul">
          <li><i class="fa fa-map-marker"></i>308-309, Bombay Market Apartments, Tardeo Road, Near A.C. Market, Tardeo, Mumbai 400034 , INDIA</li>
          <!-- <li><i class="fa fa-phone"></i>+91 99999 99999</li> -->
          <li><i class="fa fa-envelope"></i><a data-toggle="modal" data-target="#mailtoModal" href="mailto:training@chetandalal.com">training@chetandalal.com</a></li>
        </ul>
      </div>
    </div>
    <div class="col-sm-4 subscirbe pull-right">
      <h2>Newsletter</h2>
      <p class="sub"><span>Subscribe</span> to Our Newsletter to get Important Blog Posts &amp; Inside Scoops:</p>
      <div class="form">
      <form id="newsletter_sub" data-skip="0" action="<?php echo base_url('register/subscribe-newsletter'); ?>" method="post" >
        <input type="text" placeholder="Enter your Email" id="emailfoot" name="email" class="form-control first" />
        <button  class="bttn g-recaptcha" data-sitekey="6Leq8tgZAAAAACHR4l5xv2OZ2_pT1DgH3bDwiwGK" data-callback='onSubmit' value="Subscribe" >Subscribe</button>
      </form>
      </div>
    </div>
    <!-- <div class="col-sm-3 wow fadeInDownBig animate">
      <a href="https://play.google.com/store/apps/details?id=com.cdimselearn.meetcs" target="_blank"><img src="<?php echo base_url('assets/mail/')?>images/googleplay.png" style="height: 40px; width: 125px"></a>
      <a href="https://itunes.apple.com/us/app/cdims-elearn/id1225923804?mt=8" target="_blank"><img src="<?php echo base_url('assets/mail/')?>images/applestore.png" style="height: 40px; width: 125px"></a>
    </div> -->
    <div class="col-sm-5">
      <div class="contactus mt-10">
        <h2>Collaborations</h2>
        <ul class="list-ul">
          <!-- <li><a href="http://gfsu.edu.in" target="_blank"><i class="fa fa-link"></i>GFSU </a></li> -->
          <!-- <li><i class="fa fa-phone"></i>+91 99999 99999</li> -->
          <li><a  href="http://stanton.com.au/" target="_blank"><i class="fa fa-link"></i>Stantons International </a></li>
        </ul>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="contactus">
        <h2>User Guide</h2>
        <ul class="list-ul">
          <li><a href="" data-toggle="modal" data-target="#userguide"><i class="fa fa-book"></i>6 Step User Guide </a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
<!-- Footer Links End -->
<!-- Copy Rights Start -->
<div class="footer-wrapper">
  <div class="container">    
    <p>Made With <a href="" class="love">❤</a> by <a href="https://meetcs.com" target="_blank" class="footer-anchor">MEETCS</a> | &copy;  
      <script type="text/javascript">
        var d=new Date();
        document.write(d.getFullYear());
      </script>   
      CDIMS All Rights Reserved. | POLICY : <a href="<?php echo base_url('privacy-policy')?>" class="footer-anchor">Privacy </a> | <a href="<?php echo base_url('Terms-and-condition')?>" class="footer-anchor">T &amp; C</a> | <a href="<?php echo base_url('faqs')?>" class="footer-anchor">FAQs</a>
    </p>
    <p>**Note : Best viewed in all the latest version of browser. </p>
  </div>
  <a id="scrool-top" href="javascript:void(0)"><i class="fa fa-long-arrow-up" aria-hidden="true"></i></a> 
</div>
<!-- Modal -->
<div id="mailtoModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select the mailer</h4>
      </div>
      <div class="modal-body">
        <p><center><a style="padding: 0 10px 0 10px;" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=training@chetandalal.com&su&body&bcc&tf=1"><img width="100" alt="Gmail" src="<?php echo base_url('assets/img/mailicon/gmail.png')?>"/> </a><a style="padding: 0 10px 0 10px;" target="_blank" href="https://outlook.live.com"><img alt="Outlook Live" width="100" src="<?php echo base_url('assets/img/mailicon/Outlook.png')?>"/> </a><a style="padding: 0 10px 0 10px;" target="_blank" href="https://mail.yahoo.com"><img alt="Yahoo Mail" width="100" src="<?php echo base_url('assets/img/mailicon/yahoomail.png')?>"/> </a></center></p>
      </div>
     <!--  <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div> -->
    </div>

  </div>
</div>
<div id="userguide" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
       <div class="modal-header userguide-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>        
      </div>      
      <div class="modal-body">
        <img src="<?php echo base_url(); ?>assets/img/cdims_user_guide.jpg" alt="CDIMS User Guide" height=650>
      </div>      
    </div>

  </div>
</div>
<!-- Copy Rights End --> 
<script type="text/javascript">  
  $(document).ready(function(){
    <?php    
      if(@$getData['message']!=""){
        //$data=base64_decode(json)
        $data=json_encode($getData);
        echo "       
        errMsg($data);
        ";
      }?>
  });

</script>
<!-- Start of StatCounter Code for DoYourOwnSite -->
<script type="text/javascript">
    var sc_project=11308952; 
    var sc_invisible=1; 
    var sc_security="0fd3f4dd"; 
    var scJsHost = (("https:" == document.location.protocol) ?
    "https://secure." : "http://www.");
    document.write("<sc"+"ript type='text/javascript' src='" +
    scJsHost+
    "statcounter.com/counter/counter.js'></"+"script>");
</script>
<noscript><div class="statcounter">
<img class="statcounter" src="//c.statcounter.com/11308952/0/0fd3f4dd/1/" alt="free web stats"></a></div>
</noscript>
<!-- End of StatCounter Code for DoYourOwnSite -->
 
<script src="<?php echo base_url('assets/');?>assets/jquery/jquery.animateNumber.min.js"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
 <script src="https://www.google.com/recaptcha/api.js" async defer></script>
 <script>
       function onSubmit(token) {
         $( "#newsletter_sub" ).submit();
       }
     </script>
<script src="<?php echo base_url('assets/');?>assets/easing/jquery.easing.min.js"></script> 
<script src="<?php echo base_url('assets/');?>assets/bootstrap/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url('assets/');?>assets/wow/wow.min.js"></script> 
<script src="<?php echo base_url('assets/');?>assets/owl-carousel/js/owl.carousel.js"></script> 
<script src="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.js"></script>
<script src="<?php echo base_url('assets/');?>js/custom.js"></script>
<script src="<?php echo base_url('assets/');?>js/my_custom.js"></script>
<script src="<?php echo base_url('assets/');?>js/function.js"></script>

</body>
</html>