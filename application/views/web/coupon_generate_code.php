<link href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>

<style type="text/css">
  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
  }
</style>

<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Coupon Code</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Coupon Code</li>
       
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <h2>Generate <span>Coupon Code</span> </h2>
     
      <div class="inner-wrapper-main">
        <div class="col-md-8 col-md-offset-2 ">
          <div class="form">
            <form action="<?php echo base_url('generate-coupon-code/store-coupon-code')?>" method="post" id="coupon_code_frm" name="coupon_code_frm">
              <div class="row">               
                <div class="col-md-6">
                  <label>Domain</label>
                  <input type="text"  placeholder="Domain e.g(https://bcasonline.org)" value="<?php echo @$domian; ?>" name="domian" class="txt" >
                </div>
                <div class="col-md-6">
                  <label>Coupon Code<font color="red">*</font></label>
                  <input type="text" required placeholder="Coupon Code" value="<?php echo @$coupon_code; ?>" name="coupon_code" id="coupon_code"   class="txt" />
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label>Amount<font color="red">*</font></label>
                  <input type="number" required placeholder="Amount in INR" value="<?php echo @$amount; ?>" name="amount" id="amount" class="txt" />
                </div>
                <div class="col-md-6">
                  <label>Coupon For<font color="red">*</font></label>
                  <select type="text"  placeholder="" required name="coupon_for" id="coupon_for" class="txt" >
                    <option value="olc">Online Course</option>
                    <?php /*<!--  <option value="crc">Classroom Course</option>
                    <option value="git">Gita For Professionals </option> -->*/ ?>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label>Valid Upto<font color="red">*</font></label>
                  <input type="text" readonly  required placeholder="Valid upto e.g: 7/12/2017" value="<?php echo @$valid_up_to; ?>" name="valid_up_to" id="valid_up_to" class="txt" />
                </div>
                <div class="col-md-6">
                  <label>Multiple Use</label>
                  <select type="text"  placeholder="" required name="multiple_use" id="multiple_use" class="txt" >
                    <option value="S">Single Use</option>
                    <option value="M">Multiple Use</option>                    
                  </select>
                </div>
                
              </div>
              <br/>             
              <div class="row">                
                <div class="dynamicbtn">
                    <div class="div_edit">
                      <input type="submit" value="Create Coupon Code" name="btn_edt" id="btn_edt" class="btn btn-primary pull-right" >
                    </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <hr/>
    <div class="row">
      <div class="col-md-12">
        <table id="tblcouponcode" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
          <tr>
            <th>Coupon Code</th>
            <th>Amount</th>
            <th>Coupon For</th>
            <th>Domain</th>
            <th>Is Used</th>
            <th>Valid Upto</th>
            <th>Added By</th>
          </tr>            
          </thead>
          <tbody>
            <?php             
              $used=array(
                  1=>'Used',
                  0=>'Not Used'
                ); 
              $coupon_for=array(
                  'olc'=>'eLearning',
                  'crc'=>'Classroom',
                  'git'=>'Book'
                );          
              foreach ($coupon_data as  $value) { 
                  $value['is_used']==$value['is_used'] ? 'Used' : 'Not Used' ;             
                  echo "
                    <tr>
                      <td>$value[coupon_code]</td>
                      <td>$value[amount]</td>
                      <td>".$coupon_for[$value['coupon_for']]."</td>
                      <td>$value[domian]</td>
                      <td>".$used[$value['is_used']]."</td>
                      <td>".date('d-m-Y',strtotime($value['validupto']))."</td>                      
                      <td>$value[Name]</td>                      
                    </tr>
                  ";
              }
            ?>            
          </tbody>
        </table>
      </div>      
    </div>
  </div>
</section>
<script type="text/javascript">
$(document).ready(function() {
    $('#tblcouponcode').DataTable();
    //$('#valid_up_to').datepicker();
    $( "#valid_up_to" ).datepicker({        
        changeMonth: true,        
        minDate:0,    
        dateFormat:"dd/mm/yy"        
    });   
});
</script>


