<link href="<?php echo base_url('assets/');?>css/select2.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/')?>js/select2.min.js" type="text/javascript"></script>
<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Registration</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Register</li>
       
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <h2>CDIMS <span>Registration</span> </h2>
      <div class="inner-wrapper-main">
        <div class="col-md-8 col-md-offset-2 ">
          <div class="form">
            <form action="<?php echo base_url('register/registerUser')?>" method="post" id="contactFrm" name="contactFrm">
              <div class="row">
                <div class="col-md-6">
                  <label>First Name <font color="red">*</font></label>
                  <input type="text" required placeholder="First Name" value="" name="firstname" class="txt">
                </div>
                <div class="col-md-6">
                  <label>Last Name<font color="red">*</font></label>
                  <input type="text" required placeholder="Last Name" value="" name="lastname" class="txt">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label>Mobile<font color="red">*</font></label>
                  <input type="number" required placeholder="Mobile No" maxlength="10" minlength="10"  value="" name="mobile" class="txt">
                </div>
                <div class="col-md-6">
                  <label>Email<font color="red">*</font></label>
                  <input type="text" required placeholder="Email" value="" name="email" class="txt">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label>Password<font color="red">*</font></label>
                  <input type="password" required placeholder="password" value="" name="password" class="txt">
                </div>
                <div class="col-md-6">
                  <label>Confirm Password<font color="red">*</font></label>
                  <input type="password" required placeholder="Confirm Password" value="" name="cpass" class="txt">
                </div>
              </div>
              <center>
              <div class="btn-shapes">
                    <input type="submit" value="Register" name="submit" class="txt2">
              </div>
          
              </center>
            </form>
              
              

              <!-- <div class="row">
                <div class="col-md-12">
                  <label>Registration Type  </label><br />

                  <label ><input type="radio" onclick="radioclick();" checked required id="reg_type"  value="nr"  name="reg_type" class="txt"> Normal</label>&nbsp;&nbsp;&nbsp;
                  <label ><input type="radio" onclick="radioclick();" required value="cr" id="reg_type" name="reg_type"  class="txt"> Classroom Course</label>&nbsp;&nbsp;&nbsp;
                  <label ><input type="radio" onclick="radioclick();" required value="oc" id="reg_type" name="reg_type" class="txt"> Online Course </label>&nbsp;&nbsp;&nbsp;
                  <br />
                </div>                
              </div>
              <div class="row" id="showdata_cr" style="display: none;">
                <div class="col-md-6">
                  <label>Select Course Date </label><br />
                  <select name="courselist" type="text" class="txt" id="" aria-invalid="false">
                    <option value="Select anyone">Select course date</option>
                    <option value="12_13_14_april_2017">12,13,14 April 2017</option>
                    <option value="12_13_14_May_2017">12,13,14 May 2017</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label>Select Location </label><br />
                  <select name="courselist" type="text" class="txt" id="" aria-invalid="false">
                    <option value="Select anyone">Select Location</option>
                    <option value="mumbai">Mumbai</option>
                    <option value="delhi">Delhi</option>
                  </select>                                  
                </div>                
              </div> -->
              <!-- <div class="row">
                <div class="col-md-4">
                  <label>Email</label>
                  <input type="text" required placeholder="Email" value="" name="email" class="txt">
                </div>
                <div class="col-md-4">
                  <label>Address</label>
                  <textarea required type="text" placeholder="address" value="" name="address" class="txt_3"></textarea> 
                </div>
                <div class="col-md-4">
                  <label>City</label>
                  <input type="text" required placeholder="Email" value="" name="email" class="txt">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label>Pincode</label>
                  <input type="text" required placeholder="Pincode" value="" name="pincode" class="txt">
                </div>
                <div class="col-md-4">
                  <label>Are you a Chartered Accountant?</label>
                  <br />
                  <br />
                   <label><input type="radio"  required alt="Are you a Chartered Accountant?" value="Y" name="cacc" class="txt">&nbsp;Yes </label> <label>&nbsp;&nbsp;&nbsp;
                  <input type="radio" required alt="Are you a Chartered Accountant?" value="N" name="cacc" checked class="txt">&nbsp;No </label>
                </div>
                <div class="col-md-4">
                  <label>ICAI Membership Number</label>
                  <input type="text" required placeholder="Email" value="" name="email" class="txt">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label>Year Of ICAI Membership</label>
                  <input type="text" required placeholder="Email" value="" name="email" class="txt">
                </div>
                <div class="col-md-4">
                  <label>Occupation</label>
                 
                  <select name="occupation" type="text" class="txt" id="" aria-invalid="false">
                    <option value="Select anyone">Select anyone</option>
                    <option value="Service - In Corporate Sector">Service - In Corporate Sector</option>
                    <option value="Service - In Govt. / PSU/Semi-Govt.">Service - In Govt. / PSU/Semi-Govt.</option>
                    <option value="Service - In CA Firm">Service - In CA Firm</option>
                    <option value="Service - Others">Service - Others</option>
                    <option value="Business - CA Firm">Business - CA Firm</option>
                    <option value="Business - Professional Consultancy">Business - Professional Consultancy</option>
                    <option value="Business - Other">Business - Other</option>
                    <option value="Academician">Academician</option>
                    <option value="Retired">Retired</option>
                    <option value="Others">Others</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label>ICAI Membership Number</label>
                  <input type="text" required placeholder="Email" value="" name="email" class="txt">
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <label>Name of Your Organisation</label>
                  <input type="text" required placeholder="Your Organisation" value="" name="organisation" class="txt">
                </div>
                <div class="col-md-4">
                  <label>How familiar are you with MS Excel?</label>
                  <select name="MS" class="txt" type="text" aria-invalid="false">
                    <option value="">Select anyone</option>
                    <option value="No working Knowledge / Occasional User">No working Knowledge / Occasional User</option>
                    <option value="I use the basic functions">I use the basic functions</option>
                    <option value="I use advanced functions like vlookup, pivot tables etc">I use advanced functions like vlookup, pivot tables etc</option><option value="I use macros for creating programmes in excel">I use macros for creating programmes in excel</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label>How did you learn about this Program?</label>
                  <select name="" type="text" class="txt select_2_mul " id="" aria-required="true" aria-invalid="false" multiple="multiple">
                    <option value="Through Emailer">Through Emailer</option>
                    <option value="Through Friend">Through Friend</option>
                    <option value="Through Net Browing">Through Net Browing</option>
                    <option value="Through GFSU Website / GFSU Comminications">Through GFSU Website / GFSU Comminications</option>
                    <option value="Inspired from the CDIMS Publications">Inspired from the CDIMS Publications</option>
                    <option value="Attended CDIMS Programs Earlier">Attended CDIMS Programs Earlier</option>
                    <option value="Others">Others</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label>What are your expectations from this course?</label>
                  <textarea type="text" required placeholder="your expectations" value="" name="email" class="txt"></textarea>
                </div>                
              </div> -->
              
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
$(document).ready(function(){
    //$(".select_2_mul").select2();
    
});
function radioclick(){
  var checkdata=$('input[name="reg_type"]:checked').val();
  if(checkdata=='cr'){
    $('#showdata_cr').css({"display":"block"});
  }else{
    $('#showdata_cr').css({"display":"none"});
  }
}
  
</script>


