<section class="inner-wrapper">
  <div class="container">
    <div class="row offset-top-40">
      <h2>CDIMS  <span>Forgot Password</span></h2>
      <div class="inner-wrapper-main">
        <div class="col-sm-6 col-sm-offset-3 col-xs-offset-0">
          <div class="form">
            <form action="<?php echo base_url('lauth/userAuth');?>" method="post" name="Login_Form" class="form-signin">
              <input type="text"  class="txt" name="username" placeholder="Username" required />
              <input type="password"  class="txt" name="password" placeholder="Password" required/>
              <input type="hidden"  class="txt" name="action" value="Authenticate" required/>
             
              
               <strong><a href="<?php echo base_url('register')?>">Forgot Password?</a></strong> | If you are a new user then <a href="<?php echo base_url('register')?>"><strong> REGISTER</strong></a> <br />
                <input type="submit" value="Login" name="submit" class="txt2">              
              <!-- <div class="social-login">               
                <p class="hidden-xs">Or Login with</p>
                <ul class="social-icons hidden-xs">
                  <li class="facebook"><a href="javascript:void(0)" target="_blank"><i class="fa fa-facebook"></i></a></li>
                  <li class="twitter"><a href="javascript:void(0)" target="_blank"><i class="fa fa-twitter"></i></a></li>
                  <li class="google-plus"><a href="javascript:void(0)" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                </ul>
              </div> -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
   var csfrData = {};
   csfrData['<?php echo $this->security->get_csrf_token_name(); ?>']
                     = '<?php echo $this->security->get_csrf_hash(); ?>';
    $(function() {
        // Attach csfr data token
        $.ajaxSetup({
           data: csfrData
        });
    });
</script>