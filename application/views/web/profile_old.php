<style type="text/css">
  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
  }

  .required:after { 
    content:" *"; 
    color: red;
  }

  .profpicupld > input{
    display: none;
  }

  .profpicupld img{
      cursor: pointer;
  }

  .docviewlink > a:hover {
    font-color: #337ab7;
  }
</style>

<?php
  $countries = json_encode(@$countries['country']);
  /*print_r($countries);
  exit;*/
?>

<link href="<?php echo base_url('assets/');?>css/jquery-ui.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/')?>js/jquery-ui.min.js" type="text/javascript"></script>


<script type="text/javascript">
  $(document).ready(function(){
    var countries=<?php  echo $countries;?>;
    
    var countryval = '<?php echo !empty(@$user_details['country_name'])?@$user_details['country_name']:'' ?>';
    $('#country').html(createOption(countries,'Choose Country'));

    $('#country').on('change', function(){
      $('#state').val('');
      var url = '<?php echo base_url('profile/getStates/') ?>' + $('#country').val()
      fetchState(url);
    });

    $('#country').val(countryval).trigger('change');

    var salutationval = '<?php echo !empty(@$user_details['customfields']['salutation'])?@$user_details['customfields']['salutation']:'' ?>';
    $('#salutation').val(salutationval);

    var docpathsarr = '<?php echo !empty(@$user_details['docpath'])?@$user_details['docpath']:'' ?>';
    // var docpathsarr = <?php echo @$user_details['docpath'] ?>;
    var docfilepaths = <?php echo @$user_details['docfilepaths'] ?>;
    // console.log(docfilepaths['docbc']);
    
    if(docpathsarr){
      docpathsarr = JSON.parse(docpathsarr);
      $.each(docpathsarr, function(key, value){
        if(value!=''){
          // console.log(key+' '+value);
          // console.log('<?php echo base_url() ?>' + docfilepaths[key] + value);
          $('#span'+key).html('<a href=<?php echo base_url() ?>'+docfilepaths[key]+value+' class="docviewlink" target="_blank"><b><i>(View)</i></b></a>');
        }
      });
    }

    $('#docpp').change(function(){
      readURL(this);
    });
    
  });

  function createOption(data,firstOpt,value){ 
    var setselected="";
    var options="";
    var options =options + "<option value='' "+setselected+">"+firstOpt+"</option>";  
    
    $.each(data, function(i, obj) {
      setselected="";
      if(obj.id==value){
        setselected="selected";
      }
      options += "<option value='"+obj.id+"' "+setselected+">"+obj.name+"</option>";
    });
    return options;
  }

  function fetchState(url){
    // console.log(url);
    $.ajax({
      url: url,
      type: "POST",
      dataType: "json",
      contentType:false,
      processData:false,
      success: function(json) {
        // console.log(json);
        var states = json;

        var stateval = '<?php echo !empty(@$user_details['state_name'])?@$user_details['state_name']:'' ?>';
        $('#state').html(createOption(states,'Choose States',stateval));
      }
    });
  }

  function readURL(input){
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgprofpic').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
  }

</script>



<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>My Profile</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>My Profile</li>
       
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
  <?php 
      if($this->input->get('complete')=="false"){
        echo '<h2>Please complete your profile first</h2>';
      }
  ?>
    <div class="row">
      <h2>CDIMS <span> My Profile</span> </h2>
      <div class="row">
        <div class="col-md-12">
          <center><a href="<?php echo base_url('home') ?>" class="btn btn-primary btn-xs">Skip for now</a></center>
        </div>
      </div>
      <center><i>Your Profile is <b><?php echo @$user_details['profilepercent'];?> %</b> completed</i></center><br/>
      <div class="inner-wrapper-main">
        <div class="col-md-8 col-md-offset-2 ">
          <div class="form">
            <form action="<?php echo base_url('profile/editProfile/').$this->input->get('redirect_to')  ?>" method="post" id="profileFrm" name="profileFrm">
              <div class="row">
                <center>
                  <div class="col-md-12 profpicupld">
                    <label for="docpp">
                      <img src="<?php echo @$user_details['profilepicture'] ?>" width="120" height="120" id="imgprofpic">
                    </label>
                    <input type='file' name="docpp" id="docpp">
                  </div>
                </center>
              </div>
              <br />
              <!-- <div class="row">
                <div class="col-md-12 pull-right">
                  <center>
                      
                  </center>
                </div>
              </div> -->
              <br />
              <center><h3><b>Basic Details</b></h3></center>
              <div class="row">
                <div class="col-md-2">
                  <label class="required">Salutation</label>
                  <select name="salutation" type="text" class="txt" id="salutation" aria-invalid="false">
                    <option value="" selected disabled>Choose</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Mrs.">Mrs.</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">First Name</label>
                  <input type="text" required placeholder="First Name" value="<?php echo @$user_details['firstname'] ?>" name="firstname" class="txt" >
                </div>
                <div class="col-md-6">
                  <label class="required">Last Name</label>
                  <input type="text" required placeholder="Last Name" value="<?php echo @$user_details['lastname'] ?>" name="lastname" class="txt" >
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">Father's/Mother's/Husband's Name</label>
                  <input type="text" placeholder="Middle Name" value="<?php echo @$user_details['middlename'] ?>" name="middlename" class="txt" >
                </div>
                <div class="col-md-6">
                  <label class="required">Gender</label>
                  <select name="gender" type="text" class="txt" id="gender" aria-invalid="false">
                    <option value="" selected>Choose</option>
                    <option value="Male" <?php echo @$user_details['customfields']['gender']=='Male'?'selected':'' ?>>Male</option>
                    <option value="Female" <?php echo @$user_details['customfields']['gender']=='Female'?'selected':'' ?>>Female</option>
                    <option value="Transgender" <?php echo @$user_details['customfields']['gender']=='Transgender'?'selected':'' ?>>Transgender</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">Correspondence Address</label>
                  <textarea placeholder="" name="address" id="address" type="text" class="txt_3" required><?php echo @$user_details['address']?></textarea>
                </div>
                <div class="col-md-6">
                  <label class="required">Mobile No</label>
                  <input type="text"  placeholder="" value="<?php echo @$user_details['phone1'] ?>" name="mobileno" id="mobileno" class="txt" >
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">Country</label>
                  <!-- <input type="text"  placeholder="" value="<?php //echo @$user_details['country_name'] ?>" name="country" id="country" class="txt" required> -->
                  <select class="txt" type="text" id="country" name="country" required>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="required">State</label>
                  <!-- <input type="text"  placeholder="" value="<?php //echo @$user_details['state_name'] ?>" name="state" id="state" class="txt" required> -->
                  <select class="txt" type="text" id="state" name="state" required>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">City</label>
                  <input type="text" placeholder="" name="city" id="city" value="<?php echo @$user_details['city'] ?>" class="txt" required>
                </div>
                <div class="col-md-6">
                  <label class="required">Pin Code</label>
                  <input type="number" maxlength="6" minlength="6" placeholder="" value="<?php echo @$user_details['pincode'] ?>" name="pincode" id="pincode" class="txt" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">Date of Birth</label>
                  <input type="text" placeholder="" name="dateofbirth" id="dateofbirth" value="<?php echo @$user_details['dateofbirth'] ?>" class="txt" required>
                </div>
              </div>
              <!-- Educational details Start-->
              <center><h3><b>Educational Details</b></h3></center>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">University</label>
                  <input type="text" placeholder="" name="university" id="university" value="<?php echo @$user_details['customfields']['university'] ?>" class="txt" required>
                </div>
                <div class="col-md-6">
                  <label class="required">City</label>
                  <input type="text" placeholder="" name="universitycity" id="universitycity" value="<?php echo @$user_details['customfields']['universitycity'] ?>" class="txt" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">Year of passing</label>
                  <input type="number"  placeholder="" name="yearofpassing" id="yearofpassing" value="<?php echo @$user_details['customfields']['yearofpassing'] ?>" class="txt" required>
                </div>
                <div class="col-md-6">
                  <label>Passing Grade (In percentage)</label>
                  <input type="number" placeholder="%" step="0.01" placeholder="" name="passinggrade" id="passinggrade" value="<?php echo @$user_details['customfields']['passinggrade'] ?>" class="txt">
                </div>
              </div>
              <!-- Educational details End-->
              <center><h3><b>Professional Details</b></h3></center>
              <div class="row">
                <div class="col-md-6">
                  <label>Name of Your Organisation</label>
                  <input type="text"  placeholder="Your Organisation" value="<?php echo @$user_details['customfields']['organisation'] ?>" name="organisation" class="txt" >
                </div>
                <div class="col-md-6">
                  <label>How long you been working for ? (In years)</label>
                  <input type="number" placeholder="In years" value="<?php echo @$user_details['customfields']['sinceyears'] ?>" name="sinceyears" id="sinceyears" class="txt">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label>Designation</label>
                  <input type="text" name="designation" value="<?php echo @$user_details['customfields']['designation'] ?>" id="designation" class="txt">
                </div>
                <div class="col-md-6">
                  <label>Work Profile</label>
                  <input type="text" name="workprofile" value="<?php echo @$user_details['customfields']['workprofile'] ?>" id="workprofile" class="txt">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label>Other Certifications/Degrees</label>
                  <textarea type="text" placeholder="" name="othereducation" id="othereducation" class="txt"><?php echo @$user_details['customfields']['othereducation'] ?></textarea>
                </div>
              </div>
              <center><h3><b>Documents Upload</b></h3></center>
              <div class="row">
                <div class="col-md-12">
                  <span><b>Instructions for uploading documents.</b></span>
                  <div class="ordered-list">
                      <ol>
                          <li><i>Only PDFs are allowed  to uploaded for documents and only .jpg can be uploaded for profile picture .</i></li>
                          <li><i>The size of the uploaded file should not exceed 2 MB.</i></li>
                          <li><i>Graduation certificate need not be submitted now, but it is mandatory to submit it to become eligibile to attempt the final examination.</i></li>
                      </ol>
                  </div>               
              </div>
              <div class="row">
                <div class='col-md-6'>
                  <label>Birth Certificate</label> <span id="spandocbc"></span>
                  <input type='file' name="docbc" id="docbc" class='txt' value='choose'>
                </div>

                <div class='col-md-6'>
                  <label>Address Proof</label> <span id="spandocaddr"></span>
                  <input type='file' name="docaddr" id="docaddr" class='txt' value='choose'>
                </div>

                <div class='col-md-6'>
                  <label class="required">Graduation certificate</label> <span id="spandocgrad"></span>
                  <input type='file' name="docgrad" id="docgrad" class='txt' value='choose'>
                </div>

                <div class='col-md-6'>
                  <label>Name Change certificate</label> <span id="spandocnamechng"></span>
                  <input type='file' name="docnamechng" id="docnamechng" class='txt' value='choose'>
                </div>

                <!-- <div class='col-md-6'>
                  <label>Profile Picture</label>
                  <input type='file' name="docpp" id="docpp" class='txt' value='choose'>
                </div> --> 
              </div>

              <br/><br/>
              <div class="dynamicbtn">
                  <div class="div_edit">
                    <input type="submit" value="Update Profile" name="btn_edt" id="btn_edt" class="btn btn-primary pull-right" >
                  </div>
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
    $('div.dynamicbtn').on('click','btn_cancel', function(){
      alert();
    });

    $( "#dateofbirth" ).datepicker({changeYear: true,changeMonth: true,yearRange: "1950:2013",dateFormat: "yy-mm-dd"});
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