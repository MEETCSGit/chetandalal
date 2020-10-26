<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#6091ba" >
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Chetan Dalal Investigation and Management Services</title>
<meta name="keywords" content="<?php echo @$keyword;?>">
<meta name="description" content="<?php echo @$description;?>">

<!-- Bootstrap CSS -->
<link href="<?php echo base_url('assets/');?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CSS-->
<link href="<?php echo base_url('assets/');?>font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?php echo base_url('assets/');?>css/style.min.css?v=1.0" rel="stylesheet">
<link href="<?php echo base_url('assets/');?>css/custom.css?v=1.02" rel="stylesheet">

<!-- Animate CSS -->
<link href="<?php echo base_url('assets/');?>assets/animate/animate.css" rel="stylesheet">


<!-- Owl Carousel -->
<link href="<?php echo base_url('assets/');?>assets/owl-carousel/css/owl.carousel.css" rel="stylesheet">
<link href="<?php echo base_url('assets/');?>assets/owl-carousel/css/owl.theme.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/sweetalert2/6.4.4/sweetalert2.min.css" rel="stylesheet">

<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/');?>img/favicon.ico">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="<?php echo base_url('assets/');?>assets/jquery/jquery-3.1.1.min.js"></script>
<script type=’application/ld+json’>
    {
        "@context": "<?php echo base_url(); ?>",
        "@type": "eLearning Course on Investigation And Management Services(Fraud Detection | Forensic auditing | Risk Assessment | B Training services | Training workshops ) ",
        "brand": "Chetandalal Investigation And Management Services",
        "name": "Chetan Dalal",
        "image": "<?php echo base_url('assets/');?>img/CD_LOGO1.png",
        "description": "Fraud Detection | Forensic auditing | Risk Assessment | B Training services | Training workshops | Certification Courses through Gujarat Forensic Sciences University, Asia's first university dedicated to forensic sciences (GFSU) and ACFE."
      }
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-100947292-1', 'auto');
  ga('send', 'pageview');
</script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head> 
<body >
<!-- Pre Loader -->
<div id="dvLoading"></div>
<!-- Header Start -->
<header>
  <div class="top-wrapper ">
 
    <div class="container">
      <div class="col-md-4 col-sm-6 top-wraper-left no-padding">
        <ul class="header-social-icons">
          <li class="facebook"><a href="https://www.facebook.com/CDIMSforensic/?fref=ts" target="_blank"><i class="fa fa-facebook"></i></a></li>
          <li class="twitter"><a href="https://twitter.com/cdims_media" target="_blank"><i class="fa fa-twitter"></i></a></li>
          <li class="youtube"><a href="https://www.youtube.com/channel/UC_KJD7_le_QePiuLGcRlQ8g" target="_blank"><i class="fa fa-youtube"></i></a></li>
          <li class="linkedin"><a href="https://www.linkedin.com/in/chetan-dalal-investigation-and-management-services-2b795113a/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
          <!-- <li class="pinterest"><a href="javascript:void(0)" target="_blank"><i class="fa fa-pinterest"></i></a></li> -->
          <!-- <li class="google-plus"><a href="" target="_blank"><i class="fa fa-google-plus"></i></a></li> -->
          
          <!-- <li class="dribbble"><a href="javascript:void(0)" target="_blank"><i class="fa fa-dribbble"></i></a></li> -->
        </ul>
      </div>

     
      <div class="rajesh col-md-8 col-sm-6">
        <ul  id="nav" class=" top-right pull-right nav nav-pills clearfix right" >
          <!-- Login -->
          <!--<li class="login"><a href="javascript:void(0)">Welcome,</a>
             <div class="login-form">
              <h4>Login</h4>
              <form action="<?php //echo base_url('lauth/login');?>" method="post">
                <input type="text" name="name" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" class="btn">Login</button>
              </form>
            </div> 
          </li>-->
          <!-- Register -->
         <!--  <li class="registers"><a href="<?php //echo base_url('register');?>"><i class="fa fa-user"></i>[Page Views]</a>
          
          </li> -->
          <!-- <li class="login"><a href="javascript:void(0)"><i class="fa fa-lock"></i>Login</a>
            <div class="login-form">
              <h4>Login</h4>
              <form action="#" method="post">
                <input type="text" name="name" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" class="btn">Login</button>
              </form>
            </div>
          </li> -->
          <?php 
            if($this->authorize->checkAliveSession()){?>
              <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" ><i class="fa fa-user"></i> Welcome, <?php echo ucfirst($this->session->userdata('firstname')); ?></a>             
                <ul id="products-menu" class="dropdown-menu clearfix" role="menu">
                  <li><a href="<?php echo base_url('profile'); ?>" >Profile</a></li>
                  <li><a href="<?php echo base_url('lms/mod/customcert/verify_certificate.php?contextid=1935'); ?>" >Verify Certificate </a></li>
                  <li><a href="<?php echo base_url('order-history'); ?>" >Order History</a></li>
                  <li><a href="<?php echo base_url('lms/login/change_password.php');?>" target="_blank">Change Password</a></li>
                </ul>

              </li>
              
              <li >
              <!-- <a href="<?php //echo base_url();?>lms/login/logout.php?sesskey=<?//=$this->session->userdata('sesskey')?>"><i class="fa fa-power-off"></i> Logout</a> -->
              <a href="<?php echo base_url('lauth/logout');?>"><i class="fa fa-power-off"></i> Logout</a>

              </li>
          <?php }
            else{
           ?>
           <li >
              <!-- <a href="<?php //echo base_url();?>lms/login/logout.php?sesskey=<?//=$this->session->userdata('sesskey')?>"><i class="fa fa-power-off"></i> Logout</a> -->
              <a href="#" data-toggle="modal" data-target="#userguide"><i class="fa fa-book"></i> 6 Step User Guide</a>

              </li>
            <?php
          }
            ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="logo-bar ">
    <div class="container">
      <!-- <div class="row">
        <marquee><h4>The <b>Certification course by GFSU</b> is presently <font color="red"><b>unavailable</b></font> for new registrations. We will shortly relaunch it in a different format and certification. <font color="red">Old registrations will be allowed to complete latest by 30th September 2018.</font></h4></marquee>
      </div> -->
      <!-- Logo -->
      <div class="row">
        <div class="col-sm-2 col-md-2 hidden-xs "><a href="<?php echo base_url();?>"> <img src="<?php echo base_url('assets/');?>img/CD_LOGO1.png" class="header_logo_chetandalal"  alt="Chetan Dalal Investigation and Management Services"></a> </div>
        <div class="col-md-4 col-md-offset-1 hidden-xs hidden-sm">
          <ul class="partner">
            <!--  <li class="partner-logo">
               <a href="http://stantons.com.au/" target="_blank"> 
                  <img src="<?php echo base_url('assets/');?>img/stantons.png"  alt="Chetan Dalal Investigation and Management Services collaboration partner" class=" header_logo_stantons pull-right" title="Collaboration Partner : Stantons International- Australia" >
              </a> 
            </li> -->
             <!-- <li class="partner-logo">
               <a href="http://www.gfsu.edu.in/"  target="_blank"> 
                  <img src="<?php //echo base_url('assets/');?>img/gfsu_logo.png"  alt="Chetan Dalal Investigation and Management Services collaboration partner " class="header_logo_gfsu_logo pull-right" title="Collaboration Partner : Gujarat Forensic Sciences University">
              </a> 
            </li> -->
          </ul>
         
        </div>
        <?php if(!$this->authorize->checkAliveSession()){?>
        <div class="col-md-5 col-sm-8 hidden-xs  " <?php if(@$hideHeader==1){ echo "style='display:none;'"; }?> >
          <!-- <form action="<?php //echo base_url('lauth/userAuth'); ?>" method="post" name="Login_Form" class="form-signin">  -->
           <form action="<?=moodle_site1();?>/custom_login/custom_login.php?last_url=<?php
           echo base_url(@$this->uri->segment(1)."/".@$this->uri->segment(2)."/".@$this->uri->segment(3));?>" method="post" id="loginForm" name="loginForm" class="form-signin">   
                                     
              <!-- <div class="social-login">               
                <p class="hidden-xs">Or Login with</p>
                <ul class="social-icons hidden-xs">
                  <li class="facebook"><a href="javascript:void(0)" target="_blank"><i class="fa fa-facebook"></i></a></li>
                  <li class="twitter"><a href="javascript:void(0)" target="_blank"><i class="fa fa-twitter"></i></a></li>
                  <li class="google-plus"><a href="javascript:void(0)" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                </ul>
              </div> -->
          <ul class="contact-info pull-right zero_margin ">
            <li class="row">
                <input type="text"  class="txt zero_margin " name="username" placeholder="Email ID" required />
            </li>
            <li> 
                <input type="password"  class="txt zero_margin" name="password" placeholder="Password" required/>
                <input type="hidden"  class="txt" name="action" value="Authenticate" />
            </li>
            <li>
              <div class="btn-shapes">
                <button type="submit" name="login_header" id="login_header" class="btn btn-primary zero_margin">Login</button>
              </div>
            </li>
                <br />
                <strong><a href="<?=base_url();?>lms/login/forgot_password.php" target="_blank">Forgot Password?</a></strong> | If you are a new user then <a href="<?php echo base_url('register')?>"><strong> REGISTER</strong></a>
          </ul>
          </form>
        </div>
        <?php }else{?>
          <div class="col-md-5 col-sm-8">
            <ul class="contact-info pull-right">              
              <li><i class="fa fa-envelope"></i>
                <p><span>Email Us</span><br>
                  <a data-toggle="modal" data-target="#mailtoModal" href="mailto:training@chetandalal.com">training@chetandalal.com</a></p>
              </li>
            </ul>
          </div>
        <?php }?>
      </div>
      <?php //if($this->authorize->checkAliveSession()){?>
     <!--  <div class="row">
        <div class="col-md-12">
          <center>
            <marquee><h4><?php echo @$enrol_msg; ?></h4></marquee>
          </center>
        </div>
      </div> -->
      <?php//} ?>
    </div>
  </div>
  <div class="wow fadeInDown navigation" data-offset-top="197" data-spy="affix">
    <div class="container">
      <nav class="navbar navbar-default">
        <div class="row">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="<?php echo base_url();?>"><img src="<?php echo base_url('assets/');?>img/CD_LOGO1.png" width=80 alt="Chetan Dalal Investigation and Management Services logo"/></a> </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <!-- <li class="<?php echo @$pageid == 1 ?  'active' : '' ;?>"><a href="<?php echo base_url();?>">Home</a></li> -->
             <!--  <li class="dropdown <?php echo @$pageid == 2 ?  'active' : '' ;?>"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Consultancy <i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url('consultancy/#Investigations');?>" alt="Statutory investigations,Corporate investigations,Insurance investigations,Open source intelligence">Investigations </a></li>
                  <li><a href="<?php echo base_url('consultancy/#SpecialAudits');?>" alt="Special Audits"> Special Audits </a></li>
                  <li><a href="<?php echo base_url('consultancy/#ForensicAuditing');?>">Forensic Auditing </a></li>
                  <li><a href="<?php echo base_url('consultancy/#RiskAssessment');?>">Risk Assessment </a></li>
                </ul>
              </li> -->
              <!-- <li class="<?php echo @$pageid == 3 ?  'active' : '' ;?>"><a href="<?php echo base_url('expert');?>">Our Experts</a></li>  -->
              <li class="<?php echo @$pageid == 4 ?  'active' : '' ;?>"><a href="<?php echo base_url('courses');?>">Courses</a></li>

              <!-- <li ><a href="<?php echo base_url('testimonials');?>">Testimonials</a></li> -->
            <!--   <li class="<?php echo @$pageid == 5 ?  'active' : '' ;?>"><a href="<?php echo base_url('awards');?>">Awards</a></li> -->
              <!-- <li class="<?php echo @$pageid == 6 ?  'active' : '' ;?>"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Publications <i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url('books');?>">Books </a></li>
                  <li><a href="<?php echo base_url('articles');?>" alt="articles">Articles </a></li>
                  <li><a href="<?php echo "http://blogs.chetandalal.com/";?>" title="chetandalal blogs" alt="chetandalal blogs">Blogs </a></li>
                  <li><a href="<?php echo base_url('case-studies');?>">Case Studies </a></li>
                 <li><a href="<?php //echo base_url('blogs');?>" alt="Blogs">Blogs </a></li>
                </ul>
              </li> -->
              <li class="<?php echo @$pageid == 7 ?  'active' : '' ;?>"><a href="<?php echo base_url('contactus');?>">Contact Us</a></li>
              <!-- <li class="<?php echo @$pageid == 9 ?  'active' : '' ;?>"><a href="<?php echo base_url('careers');?>">Careers</a></li> -->

              <?php if(!$this->authorize->checkAliveSession()){?>
              <li class="hidden-sm hidden-md hidden-lg <?php echo @$pageid == 8 ?  'active' : '' ;?>"><a  href="<?php echo base_url('login');?>">Login</a></li>
              <?php }else{ ?>
              <li ><a  href="<?php echo base_url('register/redirect');?>">My Course</a></li>
              <li class="hidden-sm  hidden-md hidden-lg" ><a href="<?php echo base_url('lauth/logout');?>">Logout</a></li>
               <?php }?>

               <?php
                if($this->authorize->checkAliveSession()){
                    if($this->session->userdata('web_admin')==9){
                ?>
                  <li class="<?php echo @$pageid == 6 ?  'active' : '' ;?>"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Utils <i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?php echo base_url('mail');?>">Mail </a></li>
                      <li><a href="<?php echo base_url('registration-report');?>" alt="registration-report">Report </a></li>
                      <li><a href="<?php echo base_url('generate-coupon-code');?>" alt="generate-coupon-code">Generate Coupon Code </a></li>
                      <li><a href="<?php echo base_url('verify');?>" alt="Documents Verification">Verify Documents </a></li>
                      
                    </ul>
                  </li>
                <?php
                    }
                  }
               ?>

               <!-- <li class="<?php echo @$pageid == 10 ?  'active' : '' ;?>"><a href="<?php //echo base_url('articles/article-nmims');?>">Con-Test for NMIMS</a></li> -->

              <!-- <li ><a href="<?php //echo base_url('Announcement');?>" alt="Announcement" title="Announcement"><i class="fa fa-bullhorn"></i></a></li> -->
            </ul>
          </div>  
          <!-- /.navbar-collapse -->
        </div>
      </nav>
    </div>
  </div>
</header>
<!-- Header End -->