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
      margin-left: 30px;
  }


  
  .docviewlink {
    color: #1a0dab;
    text-decoration: underline #1a0dab;
  }
 
  .file_input_hidden{
    display: none;
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
    var docfilepaths = <?php echo @$user_details['docfilepaths'] ?>;
    // console.log(docfilepaths['docbc']);
    
    if(docpathsarr){
      docpathsarr = JSON.parse(docpathsarr);
      $.each(docpathsarr, function(key, value){
        if(value!=''){
          // console.log(key+' '+value);
          // console.log('<?php echo base_url() ?>' + docfilepaths[key] + value);
          // $('#span'+key).html('<a href=<?php echo base_url() ?>'+docfilepaths[key]+value+' class="docviewlink" target="_blank"><b><i>(View)</i></b></a>');
          $('#'+key+'_lblname').html('<a href=<?php echo base_url() ?>'+docfilepaths[key]+value+' class="docviewlink" target="_blank"><b>View Document</b></a>');
          $('#'+key+'_iconname').addClass('fa fa-check-circle fa-lg');
          $('#'+key+'_iconname').css('color','green');
        }else{
          $('#'+key+'_iconname').addClass('fa fa-times-circle fa-lg');
          $('#'+key+'_iconname').css('color','red');
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
      <h2>Profile</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Profile</li>
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
      <div class="row">
        <div class="col-md-10">
          <label>Note : </label>
          All <b><span class="required"> star</span></b> marked fields need to be <b>filled/uploaded</b> before you are allowed to appear for the <b>final examination</b>.
        </div>
        <div class="col-md-2">
          <a href="<?php echo base_url('home') ?>" class="btn btn-primary btn-xs pull-right">Skip for now</a>
        </div>
      </div>
      
      <div class="inner-wrapper-main">
        <div class="col-md-12 ">
          <div class="form">
            <form action="<?php echo base_url('profile/editProfile/').$this->input->get('redirect_to')  ?>" method="post" id="profileFrm" name="profileFrm">
              <div class="row">
                  <div class="col-md-3">
                    <div class="row">
                      
                      <div class="col-md-12 profpicupld">
                        <label for="docpp">
                          <p><img src="<?php echo @$user_details['profilepicture'] ?>" width="120" height="120" id="imgprofpic"></p>
                        </label>
                        <input type='file' name="docpp" id="docpp">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <p><small>(Click on the above box to upload the profile picture)</small></p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <p><i>Your Profile is <b><?php echo @$user_details['profilepercent'];?> %</b> completed</i></p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <!-- <div class="row">
                      <div class="col-md-12">
                        <h3><b>Documents Upload</b></h3>
                      </div>
                    </div> -->
                    <div class="row">
                      <div class="row">
                        <div class='col-md-1'>
                          <label>1. </label>
                        </div>
                        <div class='col-md-3'>
                          <label class="required">Graduation Certificate</label>
                        </div>
                        <div class='col-md-1' >
                          <i id="docgrad_iconname" aria-hidden="true"></i>
                        </div>
                        <div class='col-md-2'>
                          <a href="javascript:void(0)" id="a_gradupload" title="Click to upload Graduation Certificate"> <i class="fa fa-upload fa-lg" aria-hidden="true"></i>&nbsp;Upload</a>
                        </div>
                        <div class='col-md-3'>
                          <label id="docgrad_lblname"></label>
                        </div>
                      </div>
                      <div class="row">
                        <div class='col-md-1'>
                          <label>2. </label>
                        </div>
                        <div class='col-md-3'>
                          <label class="required">Birth Certificate</label>
                        </div>
                        <div class='col-md-1'>
                          <i id="docbc_iconname" aria-hidden="true"></i>
                        </div>
                        <div class='col-md-2'>
                          <a href="javascript:void(0)" id="a_bcupload" title="Click to upload Birth certificate"> <i class="fa fa-upload fa-lg" aria-hidden="true"></i>&nbsp;Upload</a>
                        </div>
                        <div class='col-md-3'>
                          <label id="docbc_lblname"></label>
                        </div>
                      </div>
                      <div class="row">
                        <div class='col-md-1'>
                          <label>3. </label>
                        </div>
                        <div class='col-md-3'>
                          <label class="required">Address Proof</label>
                        </div>
                        <div class='col-md-1'>
                          <i id="docaddr_iconname" aria-hidden="true"></i>
                        </div>
                        <div class='col-md-2'>
                          <a href="javascript:void(0)" id="a_addrupload" title="Click to upload Address Proof"> <i class="fa fa-upload fa-lg" aria-hidden="true"></i>&nbsp;Upload</a>
                        </div>
                        <div class='col-md-3'>
                          <label id="docaddr_lblname"></label>
                        </div>
                      </div>
                      <div class="row">
                        <div class='col-md-1'>
                          <label>4. </label>
                        </div>
                        <div class='col-md-3'>
                          <label>Name Change Certificate</label>
                        </div>
                        <div class='col-md-1'>
                          <i id="docnamechng_iconname" aria-hidden="true"></i>
                        </div>
                        <div class='col-md-2'>
                          <a href="javascript:void(0)" id="a_ncupload" title="Click to upload Name Change Certifate"> <i class="fa fa-upload fa-lg" aria-hidden="true"></i>&nbsp;Upload</a>
                        </div>
                        <div class='col-md-3'>
                          <label id="docnamechng_lblname"></label>
                        </div>
                      </div>
                      <div class="row" style="display: none">
                        <input type='file' name="docbc" id="docbc" class='txt' value='choose' >
                        <input type='file' name="docaddr" id="docaddr" class='txt' value='choose' >
                        <input type='file' name="docgrad" id="docgrad" class='txt' value='choose' >
                        <input type='file' name="docnamechng" id="docnamechng" class='txt' value='choose' >
                      </div>
                      <p></p>
                      <div class="row">
                        <div class="col-md-12">
                            <span><b>Instructions for uploading documents.</b></span>
                            <div class="ordered-list">
                                <ol>
                                    <li><i>Mandatory: <b>Graduation certificate, Birth certificate, Address proof</b> and <b>Profile picture</b>.</i></li>
                                    <li><i>The final examination link will not be made visible to you, unless the mandatory information <b>(Graduation certificate, Birth certificate, Address proof and Profile picture)</b> is uploaded. The rest of the modules can be attempted without these as well.</i></li>
                                    <li><i>Only <b>.pdf, .jpg, .png</b> can be uploaded for <b>documents</b> and only <b>.jpg, .png</b> for <b>profile picture</b>.</i></li>
                                    <li><i>The <b>size</b> of any <b>uploaded file</b> should <b>not exceed 2 MB</b>.</i></li>
                                    <li><i>To <b>edit or update</b> a document or profile picture, please <b>upload again</b>. The new file would automatically <b>replace</b> the old file.</i></li>
                                </ol>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <br />
              <br />
              <center></center>
              <div class="row">
                <div class="col-md-2">
                    <u><h3><b>Basic Details</b></h3></u>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
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
                    <div class="col-md-3">
                      <label class="required">First Name</label>
                      <input type="text" required placeholder="First Name" value="<?php echo @$user_details['firstname'] ?>" name="firstname" class="txt" >
                    </div>
                    <div class="col-md-3">
                      <label class="required">Father's/Mother's/Husband's Name</label>
                      <input type="text" placeholder="Middle Name" value="<?php echo @$user_details['middlename'] ?>" name="middlename" class="txt" >
                    </div>
                    <div class="col-md-4">
                      <label class="required">Last Name</label>
                      <input type="text" required placeholder="Last Name" value="<?php echo @$user_details['lastname'] ?>" name="lastname" class="txt" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  <label class="required">Gender</label>
                  <select name="gender" type="text" class="txt" id="gender" aria-invalid="false">
                    <option value="" selected>Choose</option>
                    <option value="Male" <?php echo @$user_details['customfields']['gender']=='Male'?'selected':'' ?>>Male</option>
                    <option value="Female" <?php echo @$user_details['customfields']['gender']=='Female'?'selected':'' ?>>Female</option>
                    <option value="Transgender" <?php echo @$user_details['customfields']['gender']=='Transgender'?'selected':'' ?>>Transgender</option>
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="required">Mobile No</label>
                  <input type="text"  placeholder="eg. 9876543211" value="<?php echo @$user_details['phone1'] ?>" name="mobileno" id="mobileno" class="txt" >
                </div>
                <div class="col-md-3">
                  <label class="required">Date of Birth</label>
                  <input type="text" placeholder="Date of birth" name="dateofbirth" id="dateofbirth" value="<?php echo @$user_details['dateofbirth'] ?>" class="txt" required readonly>
                </div>
                <div class="col-md-4">
                  <label class="required">Pin Code</label>
                  <input type="number" maxlength="6" minlength="6" placeholder="421201" value="<?php echo @$user_details['pincode'] ?>" name="pincode" id="pincode" class="txt" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-5">
                  <label class="required">Correspondence Address</label>
                  <textarea placeholder="Address" name="address" id="address" type="text" class="txt_3" required><?php echo @$user_details['address']?></textarea>
                </div>
                <div class="col-md-3">
                  <label class="required">Country</label>
                  <select class="txt" type="text" id="country" name="country" required>
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="required">State</label>
                  <select class="txt" type="text" id="state" name="state" required>
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="required">City</label>
                  <input type="text" placeholder="eg. Bangalore" name="city" id="city" value="<?php echo @$user_details['city'] ?>" class="txt" required>
                </div>
              </div>
              <hr/>
              <!-- Educational details Start-->
              <div class="row">
                <div class="col-md-4">
                  <u><h3><b>Highest Educational Detail</b></h3></u>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">University</label>
                  <input type="text" placeholder="University Name" name="university" id="university" value="<?php echo @$user_details['customfields']['university'] ?>" class="txt" required>
                </div>
                <div class="col-md-6">
                  <label class="required">City</label>
                  <input type="text" placeholder="eg. Bangalore" name="universitycity" id="universitycity" value="<?php echo @$user_details['customfields']['universitycity'] ?>" class="txt" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label class="required">Year of passing</label>
                  <input type="number"  placeholder="eg. 2017" name="yearofpassing" id="yearofpassing" value="<?php echo @$user_details['customfields']['yearofpassing'] ?>" class="txt" required>
                </div>
                <div class="col-md-6">
                  <label>Passing Grade (In percentage)</label>
                  <input type="number" placeholder="%" step="0.01" placeholder="" name="passinggrade" id="passinggrade" value="<?php echo @$user_details['customfields']['passinggrade'] ?>" class="txt">
                </div>
              </div>
              <hr/>
              <!-- Educational details End-->
              <div class="row">
                <div class="col-md-3">
                  <u><h3><b>Professional Details</b></h3></u>
                </div>
              </div>
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
                  <input type="text" placeholder="eg. Sales Executive" name="designation" value="<?php echo @$user_details['customfields']['designation'] ?>" id="designation" class="txt">
                </div>
                <div class="col-md-6">
                  <label>Work Profile</label>
                  <input type="text" placeholder="Work Profile" name="workprofile" value="<?php echo @$user_details['customfields']['workprofile'] ?>" id="workprofile" class="txt">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <label>Other Certifications/Degrees</label>
                  <textarea type="text" placeholder="Certifications/Degrees" name="othereducation" id="othereducation" class="txt"><?php echo @$user_details['customfields']['othereducation'] ?></textarea>
                </div>
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

    /****Birth Certificate****/
    $('#a_bcupload').on('click', function(){
      $('#docbc').click();
    });

    $('input[type=file][name=docbc]').change(function(e){
      // console.log(e.target.files[0].name);
      $('#docbc_lblname').html(e.target.files[0].name);
    });
    /****Birth Certificate****/

    /****Address proof****/
    $('#a_addrupload').on('click', function(){
      $('#docaddr').click();
    });
    
    $('input[type=file][name=docaddr]').change(function(e){
      $('#docaddr_lblname').html(e.target.files[0].name);
    });
    /****Address proof****/

    /****Graduation Certificate****/
    $('#a_gradupload').on('click', function(){
      $('#docgrad').click();
    });

    $('input[type=file][name=docgrad]').change(function(e){
      $('#docgrad_lblname').html(e.target.files[0].name);
    });
    /****Graduation Certificate****/

    /****Name Change Certificate****/
    $('#a_ncupload').on('click', function(){
      $('#docnamechng').click();
    });

    $('input[type=file][name=docnamechng]').change(function(e){
      $('#docnamechng_lblname').html(e.target.files[0].name);
    });
    
    /****Name Change Certificate****/

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