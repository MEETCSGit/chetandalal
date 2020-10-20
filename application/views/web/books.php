<!--Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Books</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Publications</li>
        <li>Books</li>
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <div class="inner-wrapper-main">
        <div class="col-sm-12">
          <div class="courses course-details">
            <div class="col-sm-3 course-thumb"> <img src="<?php echo  base_url();?>assets/img/books/gita book image.jpg" style="width:230px;" alt="The Bhagwad Gita"> </div>
            <div class="col-sm-9 course-cnt about_justify">
              <h3>Gita for Professionals </h3>
              <ul class="area-period">
                <!-- <li>Author <strong>Chetan Dalal</strong></li> -->
                <li>Genre <strong>Insprirational</strong></li>
                <!-- <li>Out of Stock</li> -->
                <!-- <li>Tag <strong> Books</strong></li>
                <li>Price <strong><i class="fa fa-inr"></i> 75</strong></li>                
                <li>Postage <strong><i class="fa fa-inr"></i> 50</strong></li>               
                <li>
                 <?php  //if($this->authorize->checkAliveSession()){ ?>
                 <a target="_blank" class="pointer" data-toggle="modal" data-target="#myModal" >Buy</a>
                 <?php //}else{ ?>
                 <a href="<?php //echo base_url('login');?>" >Login to Buy Books</a>
                 <?php // } ?>
                </li>-->
              </ul>
              <p></p>
             <p class="">
               The Bhagwad Gita has been explained, translated, interpreted, illustrated and discussed in many ways and in many talks and books and for various audience groups.  Chetan Dalal’s book, Gita for Professionals, is a happy addition to that list, presented this time as a “manual” for daily living, as the author puts it. The 140 page hard bound book has been published by the Bombay Chartered Accountants’ Society and is priced at an enticing Rs.75. True to its “manual” presentation, the book offers an introduction to the subject,carries an Appendix explaining the summary of the Mahabharata and “technical aspects” of the Gita, and ties it all up with the working lives of professionals, in particular Chartered Accountants. The Appendix and the chapter-by-chapter introduction therein makes it a book that can be used even by a novice, someone who has heard nothing or little about the great epic and the framework in which the Gita was delivered. The book contains experiences of several CAs and other professionals with some of the Shlokas of the Gita and wherever possible, the messages have been illustrated with parables and anecdotes.
             </p>
            </div>
          </div>
        </div>
      </div>
    </div>  
    <div class="row">
      <div class="inner-wrapper-main">
        <div class="col-sm-12">
        <hr class="style18" />
          <div class="courses course-details">
            <div class="col-sm-3 course-thumb"> <img src="<?php echo  base_url();?>assets/img/books/Book-2-1.png" style="width:300px;" alt="Third Edition Novel and Conventional Method of Audit, Investigation and Fraud Detection"></div>
            <div class="col-sm-9 course-cnt about_justify">             
              <h3>Third Edition Novel and Conventional Method of Audit, Investigation and Fraud Detection </h3>
              <ul class="area-period">
                <li>Author <strong>Chetan Dalal</strong></li>
                <li>Genre <strong>Auditing</strong></li>
                <li>Tag <strong>Recommended Books</strong></li>
                <li>Price <strong>RS 1720</strong></li>
                
                <li><a target="_blank" href="http://www.amazon.in/Novel-Conventional-Methods-Investigation-Derection/dp/935129515X/ref=sr_1_fkmr0_1?s=books&ie=UTF8&qid=1461663587&sr=1-1-fkmr0&keywords=Novel+and+Conventional+Method+of+Audit%2C+Investigation+and+Fraud+Detection+Third+Edition">Buy From Amazon</a></li>
              </ul>
              <p></p>
             <p class="">
               Novel and Conventional Methods of Audit, Investigation and Fraud Detection offers an insightful and descriptive account of the frauds and accounting irregularities and methodologies to detect them by using combination of novel and conventional audit approaches. The objective of this book is to provide practical approach for investigation to auditors and person entrusted with the task of investing white collar crimes. It deals in detail with warning bells, forensic testing and investigation methods. This book would be useful for auditors, management, investigators and also those in finance and operations at a decision making level. It provides insights into very advanced approaches and techniques in a simple manner. This book is entirely practical. Every concept, every technique and approach is backed up by a case study adapted from experiences of the author and other contributors who are all eminent experts in this world of forensic accounting and fraud investigations.
             </p>
             <p>Wolters Kluwer India Pvt. Ltd. is part of the Wolters Kluwer Group, a leading global information service provider for professionals. Wolters Kluwer Tax &amp; Accounting publications cover a wide range of topics such as tax, accounting, law and financial planning. Novel and Conventional Methods of Audit, Investigation and Fraud Detection by CA. Chetan Dalal, published in association with Wolters Kluwer India Pvt. Ltd., offers an insightful and descriptive account of the frauds and accounting irregularities and methodologies to detect them by using combination of novel and conventional audit approaches. The objective of this book is to provide practical approach for investigation to auditors and person entrusted with the task of investing white collar crimes.</p>
            </div>
          </div>
        </div>
      </div>
    </div>     
  </div>
</section>
<!-- Call to Action start -->
<div class="call-to-action custom_call_to_action" >
  <div class="container">
    <h3>Enroll yourself to our online course</h3>
    <p>Fraud Investigations | Forensic Audits | Risk Assessments</p>
    <?php if($this->authorize->checkAliveSession()){?>
    <a href="<?=base_url('courses');?>">Register Today</a> 
    <?php }else{
      echo " <a href=". base_url('register').">Register Today</a> ";
      }?>
    <p><p />
    <h3 class="animated1">In Association With</h3>
    <p class="animated2 zero_padding_margin">Gujarat Forensic Sciences University</p>
    <p class="animated2 zero_padding_margin">The only university across the world, dedicated to Forensic &amp; Investigative Science</p>
  </div>
</div>
<!-- Call to Action End

  <!-- Modal -->  
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Gita For Professional's - Purchase details</h4>
        </div>
        <div class="modal-body">
         <form action='<?php echo base_url('register/payment-for-course');?>'  name="payuForm" id="payuForm" method='post'>  
                
                  <div class="row">
                    <div class="col-md-12">
                        <label fro="book_qty">Quantity<font color="red">*</font></label>
                        <input type="number" maxlength="2" onkeypress="isNumber(event)" max="99" min="1" minlength="1"  class="txt zero_margin" size=3 value="<?=@$book_qty?@$book_qty:1; ?>" id="book_qty" name="book_qty"> 
                    </div>
                    &nbsp;
                    <div class="col-md-12">
                        <label fro="address">Delivery Address<font color="red">*</font></label>
                        <textarea  class="txt_3 zero_margin" type="text" id="address" minlength="20" maxlength="500" name="address" placeholder="Enter Address" ><?=@$address?@$address:""; ?></textarea>  
                        <input type="hidden" readonly class="txt" name="c_type_hid" value="git"  />
                    </div>
                    <div class="btn-shapes">
                      <button type="button" id="Submit_gita" class="btn btn-primary zero_margin">Pay</button>
                    </div>                 
                </div>

                  <!-- <input type="text" class="txt" size=3 readonly="readonly" id="total_price" name="total_price"> -->
                <script type="text/javascript">
                function isNumber(evt) {
                    evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                }
                  $(document).ready(function(){
                    <?php
                      if(@$open_popup){
                          echo " $('#myModal').modal('show');";
                      }
                    ?>                     
                    $('#Submit_gita').click(function(){
                        var bool=0;
                        if($('#book_qty').val()==''){
                            bool=1;
                            swal({
                                title: 'Enter Quantity',
                                text: '',
                                type: 'warning'                              
                            });                        
                        } 
                        if($('#address').val()==''){
                            bool=1;
                            swal({
                                title: 'Delivery address can not be empty and should be atleast 20 character in length.',
                                text: '',
                                type: 'warning'                              
                            });                        
                        }
                        if(bool==0){
                          $('#payuForm').submit(); 
                        }
                    });                 
                  });
                </script>     
                <style type="text/css">
                   input[type="number"] {
                      padding: 1px;
                      border: solid 1px #c9c9c9;
                      transition: border 0.3s;
                      width: 50px;
                    }
                    input[type="number"]:focus,
                    input[type="number"].focus {
                      border: solid 1px #969696;
                    } 
                    input[type=number]::-webkit-inner-spin-button, 
                    input[type=number]::-webkit-outer-spin-button { 
                      -webkit-appearance: none; 
                      margin: 0; 
                    }                         
                </style>           
                
               
                             
         </form>
        </div>
        
      </div>
      
    </div>
  </div>