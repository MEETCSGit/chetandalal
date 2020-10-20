<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Order History</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li>Order History</li>
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
      <h2>Order  <span>History</span></h2>
      <?php foreach (@$orderdata as $order) {
      ?>
          <div class="inner-wrapper-main image-styles">
            <div class="case_studies_custom_border">
                <div class="row">
                  <!-- <center> -->
                    <table class="table">
                      <tr>
                        <th>Transaction ID</th>
                        <th>Payment for</th>
                        <th>Bank reference No</th>
                        <th>Order Date</th>
                        <th>Order Amount</th>
                        <th>Invoice</th>
                      </tr>
                      <tr>
                        <td style="text-align: justify;"><?php echo $order['transaction_id']; ?></td>
                        <td style="text-align: justify;"><?php echo $order['product_info']; ?></td>
                        <td style="text-align: justify;"><?php echo $order['bank_ref_num']; ?></td>
                        <td style="text-align: justify;"><?php echo $order['orderdatetime']; ?></td>
                        <td style="text-align: justify;"><span class="fa fa-inr"><?php echo $order['order_amt']; ?></span></td>

                        <?php if(!$order['back_door_access']) { ?>
                          <td style="text-align: justify;"><a target="_blank" href="<?=base_url('order-history/print-invoice/'.$order['transaction_id']);?>" ><span title="Download Invoice" style="color:red" class="fa fa-file-pdf-o fa-2x"></span></a></td>
                        <?php }else { ?>
                          <td>NOT AVAILABLE</td>
                        <?php } ?>
                      </tr>
                    </table>
                  <!-- </center> -->
                </div>
            </div>
          </div>
        <br/>
      <?php
        } 
      ?>
  </div>
</section>
