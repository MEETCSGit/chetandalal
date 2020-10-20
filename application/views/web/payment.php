<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Registration</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Registration</li>
        <li>Classroom Course</li>       
      </ul>
    </div>
  </div>
</div>
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <?php
        switch (@$udf3) {
          case 'git':
              echo "<h2>Gita <span> for professionals</span> </h2>";
            break;
          case 'olc':
              echo "<h2>CDIMS <span>Online course Registration</span> </h2>";  
            break;
          case 'crc':
              echo "<h2>CDIMS <span>Classroom course Registration</span> </h2>";
            break;
          default:
            # code...
            break;
        }
      ?>
     
      <div class="inner-wrapper-main">
        <div class="col-md-8 col-md-offset-2 ">
          <div class="form" > 
            <form action='https://secure.payu.in/_payment' id="payuForm" name="payuForm" method='post'>
              <input type="hidden" name="firstname" value="<?php echo @$firstname; ?>" />
              <input type="hidden" name="lastname" value="<?php echo @$lastname; ?>" />
              <input type="hidden" name="surl" value="<?php echo base_url('register/transactionSuccess');?>" />
              <input type="hidden" name="phone" value="<?php echo @$phone; ?>" />
              <input type="hidden" name="key" value="<?php echo @$MERCHANT_KEY; ?>" />
              <input type="hidden" name="hash" value ="<?php echo @$hash; ?>" />
              <input type="hidden" name="curl" value="<?php echo base_url('register/transactionCancel');?>" />
              <input type="hidden" name="furl" value="<?php echo base_url('register/transactionFailure');?>" />
              <input type="hidden" name="txnid" value="<?php echo @$txnid; ?>" />
              <input type="hidden" name="productinfo" value="<?php echo @$productinfo; ?>" />
              <input type="hidden" name="amount" value="<?php echo @$order_amt; ?>" />
              <input type="hidden" name="email" value="<?php echo @$email; ?>" />
              <input type="hidden" name="udf1" value="<?php echo @$udf1; ?>" />
              <input type="hidden" name="udf2" value="<?php echo @$udf2; ?>" />
              <input type="hidden" name="udf3" value="<?php echo @$udf3; ?>" />
              <center>
                <div class="btn-shapes">
                    <input type="submit" id="submit" value="Auto Checkout" name="submit" class="txt2" /> 
                </div>          
              </center>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
window.onload = function(){
  $('#submit').click();
}
</script>
