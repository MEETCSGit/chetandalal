<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Courses</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Courses</li>       
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
          <div class="row"> 
            <div class="col-sm-4">
              <a href="<?php echo base_url('courses/course_details/3'); ?>">
                <div class="courses new">
                  <div class="course-thumb"> <img src="<?php echo base_url('assets/');?>img/courses/course_outer/excel.png" height="239" style="height:239px;object-fit: fill !important;" alt="Course Image"> </div>
                  <div class="course-cnt">
                    <h3> Excel </h3>
                    <ul class="area-period">
                      <li><i class="fa fa-map-marker" aria-hidden="true"></i>Anywhere</li>
                      <li><i class="fa fa-clock-o" aria-hidden="true"></i> Anytime</li>
                    </ul>
                    <h5><b>Excel Course form CDIMS</b></h5>
                    <p class="about_justify">Learn Excel basics and advance applications with hand-on experience to enhance your productivity in any daily use.  Check out how you can ease your daily routines and automate them without any coding. eLearning module  with simple step-by-step explanations.This course will be useful for all levels from DEO (Data Entry Operator) to CEO. This course is beneficial to all <br /><br /></p>
                   <!--  <p>&nbsp;</p> -->
                    <ul class="price-and-seats">
                        <!-- <li><strong><i class="fa fa-inr"></i>30,000 &nbsp;&nbsp;&nbsp;</strong></li> -->
                        <li><i class="fa fa-info"> </i><a href="<?php echo base_url('courses/course_details/3');?>">View Details</a></li> 
                       <li class="pull-right"><i class="fa fa-tasks" aria-hidden="true"></i> <a href="<?php echo base_url(); ?>faqs">FAQ</a></li>
                      <?php 
                       // }
                      ?>
                    </ul>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-sm-4">
              <a href="<?php echo base_url('courses/course_details/2');?>">
                <div class="courses ">
                  <div class="course-thumb"> <img src="<?php echo base_url('assets/');?>img/courses/course_outer/onlinecourses.jpg" height="239" style="height:239px;object-fit: fill !important;"  alt="Course Image"> </div>
                  <div class="course-cnt">                    
                    <h3>Certification in Forensic Accounting and Corporate Fraud Investigation (CFACFI Course)</h3>
                    <ul class="area-period">
                      <li><i class="fa fa-map-marker" aria-hidden="true"></i>Anywhere</li>
                      <li><i class="fa fa-clock-o" aria-hidden="true"></i >Anytime</li>
                    </ul>
                    <h5><b>Certification course by CDIMS</b></h5>
                    <p class="about_justify">This is an online Certification Course with various modules on Conceptual & Advanced Knowledge of Forensic Accounting & Fraud Investigation based on Case Studies. The faculties share  their  unique and profound experiences in the field of fraud detection <a href="<?php echo base_url('courses/course_details/2')?>">... Read More</a>
                    </p>
                    <ul class="price-and-seats">
                      <!-- <li><strong><i class="fa fa-inr"></i>30,000 &nbsp;&nbsp;&nbsp;</strong></li> -->
                      <li><i class="fa fa-info"> </i><a href="<?php echo base_url('courses/course_details/2');?>">View Details</a></li>
                      <li class="pull-right"><i class="fa fa-tasks" aria-hidden="true"></i> <a href="<?php echo base_url(); ?>faqs">FAQ</a></li>
                    </ul>
                  </div>
                </div>
              </a>
            </div>
           <!--  <div class="col-sm-4">
              <a href="<?php echo base_url('courses/course_details/1');?>">
                <div class="courses ">
                  <div class="course-thumb course_cover"> <img src="<?php echo base_url('assets/');?>img/courses/course_outer/class_room.jpg" style="height:239px" alt="Course Image"> </div>
                  <div class="course-cnt">
                    <h3>Classroom Course</h3>
                    <ul class="area-period">
                      <li><i class="fa fa-map-marker" aria-hidden="true"></i>All Major Cities</li>
                      <li><i class="fa fa-clock-o" aria-hidden="true"></i> 3 Days</li>
                    </ul>
                    <h5><b>3 Day Forensic Accounting Certification Course </b></h5>
                    <p class="about_justify">Introducing 3-day Certification Course on Forensic Accounting by CDIMS .<a href="<?php echo base_url('courses/course_details/1')?>">... Read More</a></p>
                    <ul class="price-and-seats">
                      <li><strong><i class="fa fa-inr"></i>30,000 &nbsp;&nbsp;&nbsp;</strong></li>
                      <li><i class="fa fa-info"> </i><a href="<?php echo base_url('courses/course_details/1');?>">View Details</a></li>
                      <li class="pull-right"><i class="fa fa-tasks" aria-hidden="true"></i> Limited Seats</li>
                    </ul>
                  </div>
                </div>
              </a>
            </div> -->
             <div class="col-sm-4">
              <div class="courses">
                <!-- <div class="course-thumb"> <img src="<?php //echo base_url('assets/');?>img/courses/course_outer/courses.png" alt="Course Image"> </div> -->
                <form method="post"  action="<?php echo base_url('courses/start-a-course')?>">
                <div class="course-cnt">
                  <h3>Want to start a course in your city?</h3>
                   <?php if($this->authorize->checkAliveSession()){
                    ?> 
                  <div class="row">
                    <div class="col-md-12">
                      <label>City</label>
                      <input type="text" required placeholder="Enter your city name" value="" name="city" class="txt">
                    </div>
                    <div class="col-md-12">
                      <label>Select Week</label>
                      <select type="text" required placeholder="Select week"  name="week" class="txt">
                        <option value=''>--Select Week--</option>
                        <option selected value='1st week'>1st week</option>
                        <option value='2nd week'>2nd week</option>
                        <option value='3rd week'>3rd week</option>
                        <option value='4th week'>4th week</option>
                        <option value='5th week'>5th week</option>                       
                      </select>
                    </div>
                    <div class="col-md-12">
                      <label>Select Month</label>
                      <select type="text" required placeholder="Select month"  name="month" class="txt">
                        <option value=''>--Select Month--</option>
                        <option selected value='1'>January</option>
                        <option value='2'>February</option>
                        <option value='3'>March</option>
                        <option value='4'>April</option>
                        <option value='5'>May</option>
                        <option value='6'>June</option>
                        <option value='7'>July</option>
                        <option value='8'>August</option>
                        <option value='9'>September</option>
                        <option value='10'>October</option>
                        <option value='11'>November</option>
                        <option value='12'>December</option>
                      </select>
                    </div>
                    <div class="col-md-12">
                      <label>Message</label>
                      <textarea type="text" style="height:99px;" required placeholder="Write your message to us (500 characters max)" value="" minlength="10" maxlength="500" name="message" if="message" class="txt"></textarea>
                    </div>
                    <div class="col-md-12">
                      <label></label>
                      <input type="submit" name="" class="txt btn btn-primary">
                    </div>
                  </div>
                  <?php }else{ ?>

                  <div class="row">
                  <center>
                    <h3><a href="<?php echo base_url('login');?>">Login</a> to post a request. </h3>                    
                  </center>
                  </div>
                  <?php } ?>
                </div>
                </form>
              </div>
            </div>
          </div>            
          <div class="row">             
            
                
          </div>         
          <!-- <div class="course-pagination">
            <ul class="pagination">
              <li> <a href="#" aria-label="Previous"> <span aria-hidden="true">Prev</span> </a> </li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li> <a href="#" aria-label="Next"> <span aria-hidden="true">Next</span> </a> </li>
            </ul>
          </div> -->
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  $(document).ready(function(){
    $(".ReadMore1").click(function(){
      $(".hide1").slideToggle();
    });
  });

  $(document).ready(function(){
    $(".ReadMore2").click(function(){
      $(".hide2").slideToggle();
    });
  });
</script>