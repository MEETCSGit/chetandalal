<?php 
  if($this->authorize->checkAliveSession()){
    $logdata='<li class="pull-right">&nbsp;&nbsp;<a href="'. base_url("enroll").'" class="txt2 btn btn-primary" style="margin-top:-10px; " >Enroll</a>&nbsp;&nbsp;</li>';
  }else{
    $logdata='<li class="pull-right">&nbsp;&nbsp;<a href="'.base_url('register').'" class="txt2 btn btn-primary" style="margin-top:-10px; " alt="Register to enroll in this course" >Register & Enroll</a>&nbsp;&nbsp;</li>';
  }
?>
<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Course</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li>Course</li>
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
          <div class="courses new">
            <div class="col-sm-5 course-thumb"> <img src="<?php echo base_url('assets/');?>images/class-img1.jpg" alt="Course Image"> </div>
            <div class="col-sm-7 course-cnt" >
              <h3>Lorem Ipsum is simply dummy</h3>
              <ul class="area-period">
                <li><i class="fa fa-map-marker" aria-hidden="true"></i> Austria</li>
                <li><i class="fa fa-clock-o" aria-hidden="true"></i> 1 Year</li>
              </ul>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries. </p>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              <ul class="price-and-seats" style="padding-bottom: 17px;" >
                <li><strong><i class="fa fa-inr" alt="info"></i> 160 </strong></li>&nbsp;&nbsp;
                <li><strong><i class="fa fa-info"></i> <a href="<?php echo base_url('courses/course-details/1');?>">Veiw Details</strong></li>
                <?php echo $logdata;?>
                <li class="pull-right"><i class="fa fa-tasks" aria-hidden="true"></i> 18 Seats</li>
              </ul>
            </div>
          </div>
          <div class="courses ">
            <div class="col-sm-5 course-thumb"> <img src="<?php echo base_url('assets/');?>images/class-img1.jpg" alt="Course Image"> </div>
            <div class="col-sm-7 course-cnt" >
              <h3>Lorem Ipsum is simply dummy</h3>
              <ul class="area-period">
                <li><i class="fa fa-map-marker" aria-hidden="true"></i> Austria</li>
                <li><i class="fa fa-clock-o" aria-hidden="true"></i> 1 Year</li>
              </ul>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries. </p>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              <ul class="price-and-seats" style="padding-bottom: 17px;" >
                <li><strong><i class="fa fa-inr" alt="info"></i>160 </strong></li>&nbsp;&nbsp;
                <li><strong><i class="fa fa-info"></i> <a href="<?php echo base_url('courses/course-details/1');?>">Veiw Details</strong></li>
                <?php echo $logdata;?>                
                <li class="pull-right"><i class="fa fa-tasks" aria-hidden="true"></i> 18 Seats</li>
              </ul>
            </div>
          </div>
          <div class="courses ">
            <div class="col-sm-5 course-thumb"> <img src="<?php echo base_url('assets/');?>images/class-img1.jpg" alt="Course Image"> </div>
            <div class="col-sm-7 course-cnt" >
              <h3>Lorem Ipsum is simply dummy</h3>
              <ul class="area-period">
                <li><i class="fa fa-map-marker" aria-hidden="true"></i> Austria</li>
                <li><i class="fa fa-clock-o" aria-hidden="true"></i> 1 Year</li>
              </ul>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries. </p>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              <ul class="price-and-seats" style="padding-bottom: 17px;" >
                <li><strong><i class="fa fa-inr" alt="info"></i>160 </strong></li>&nbsp;&nbsp;
                <li><strong><i class="fa fa-info"></i> <a href="<?php echo base_url('courses/course-details/2');?>">Veiw Details</strong></li>
                <?php echo $logdata;?>
                <li class="pull-right"><i class="fa fa-tasks" aria-hidden="true"></i> 18 Seats</li>
              </ul>
            </div>
          </div>
          <div class="courses ">
            <div class="col-sm-5 course-thumb"> <img src="<?php echo base_url('assets/');?>images/class-img1.jpg" alt="Course Image"> </div>
            <div class="col-sm-7 course-cnt" >
              <h3>Lorem Ipsum is simply dummy</h3>
              <ul class="area-period">
                <li><i class="fa fa-map-marker" aria-hidden="true"></i> Austria</li>
                <li><i class="fa fa-clock-o" aria-hidden="true"></i> 1 Year</li>
              </ul>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries. </p>
              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
              <ul class="price-and-seats" style="padding-bottom: 17px;" >
                <li><strong><i class="fa fa-inr" alt="info"></i>160 </strong></li>&nbsp;&nbsp;
                <li><strong><i class="fa fa-info"></i> <a href="<?php echo base_url('courses/course-details/2');?>">Veiw Details</strong></li>
                <?php echo $logdata;?>  
                <li class="pull-right"><i class="fa fa-tasks" aria-hidden="true"></i> 18 Seats</li>
              </ul>
            </div>
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