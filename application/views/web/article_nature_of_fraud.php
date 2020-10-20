<style type="text/css">
  .articletext{
    text-align: justify
  }
</style>
<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Articles</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li>Publications</li>        
        <li><a href="<?php echo base_url('articles');?>">Articles</a></li>  
        <li>The nature of fraud</li>       
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<?php if(!$this->authorize->checkAliveSession()){
 ?>   
<section class="inner-wrapper">
  <div class="container">
    <div class="row">      
      <div class="inner-wrapper-main">
        <div class="col-sm-12">
          <h1>To view this Article you must <a style="color:#6091ba;" href="<?php echo base_url('login')?>">login</a>.</h1>          
        </div>
      </div>  
    </div>
  </div>
</section>  
 <?php  
 }else{
   ?>
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      
      <div class="inner-wrapper-main typo">
        <div class="col-sm-12">
          <h1>The nature of fraud</h1>
          <p class="articletext">
            The Bombay Chartered Accountants’ Society (BCAs), set up in July 1949, not only endeavours to keep its over 8,000 members abreast of the developments in their field, but also provides them, as also Chartered Accountant students, courses like its 120-hour Internal Audit Studies programme, in association with the Wellingkar Institute of Management Development and Research. 

            This voluntary organisation also offers a two-month course on Double Taxation Avoidance Agreements and another for three months for independent directors, in collaboration with the SP Jain Institute of Management Research. It conducts others on arbitration, conciliation and mediation and on business consultancy studies, in collaboration with the Jamnalal Bajaj Institute of Management Studies that culminates in the award of a certificate from the Mumbai University. Its yearly diary and reckoner is a valuable guide to all professionals in the industry, apart from its monthly BAC journal, which is subscribed to not only by its members, but also by corporate bodies and the tax department. 

            The society, moreover, inter-faces with the authorities on various laws and procedural issues with a view to making them just and friendly to the public. Its representations include pre- and post- budget memoranda to the finance ministry. It runs clinics for resolving difficulties in conduct of audit of non-profit organisations and young CAS and also holds revision classes for CA students, in association with the Regional Council of the Institute of Chartered Accountants of India. 

          </p>
          
        </div>
        <!-- <div class="col-sm-4">
          <hgroup>
            <h2>Keywords</h2>
          </hgroup>
        </div> -->
      </div>
    </div>
    <div class="row offset-top-80 " >
      <!-- <h2>Image <span>Left</span></h2> -->
      <div class="inner-wrapper-main image-styles">
        <div class="col-sm-10 col-sm-offset-1">
          <div class="row">
          <div class="col-sm-4"><img src="<?php echo base_url('assets/');?>img/articles/article_1.jpg" alt="Image"></div>
            <div class="col-sm-8">
              <p style="text-align: justify;">Fraud Detection: a Practical Approach for Auditors by Chetan Dalal is one of the many books the BCAS publishes as part of its knowledge dissemination exercise. Dalal, an expert in fraud detection, advocates countering white collar crime at an intellectual level by creating an environment which is not conducive to it. Through various case studies, he details the diverse tools, techniques and methods required to detect fraud, reflecting also on the psychological aspects of deterring such offences. Supplementing his work is an enclosed compact disc with a brief audio visual on forensic accounting, entitled “The placebo effect”. </p>
            </div>
            
          </div>
        </div>
      </div>
    </div>
    <div class="row offset-top-80 ">
      <!-- <h2>Image <span>Right</span></h2> -->
      <div class="inner-wrapper-main image-styles">
        <div class="col-sm-10 col-sm-offset-1">
          <div class="row">
            <div class="col-sm-8">
              <p style="text-align: justify;">In their foreword, Harish Motiwalla, chairman, and SanIeev Pandit, president, of the BCAS Research committee, note that 'fraud’ is one area where an ‘expectation gap’ persists between auditors and the users of their reports. ”The users presume that the audited statements are free from fraud as, in their perception, discovery of fraud is the primary responsibility of the auditors,” they indicate. ”On the other hand, the profession has consistently maintained that discovery of ’fraud' is and can never be part of audit.” 

              As frauds imply the need for investigation, the Institute of Chartered Accountants of India has mandated that the auditor’s report on financial statements include in its applicability of Auditing and Assurance Standard (AAS) 28 the following paragraph: "We have conducted our audit in accordance with the auditing standards generally accepted in India. Those standards require that we plan and perform the audit to obtain reasonable assurance whether the financial statements are free of FRAUD DETECTION: material misstatement….We believe that our audit provides a reasonable basis of our opinion”.</p>
            </div>
            <div class="col-sm-4"><img src="<?php echo base_url('assets/');?>img/articles/article_1.jpg" alt="Image"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row offset-top-80 " >
      <!-- <h2>Image <span>Left</span></h2> -->
      <div class="inner-wrapper-main image-styles">
        <div class="col-sm-10 col-sm-offset-1">
          <div class="row">
          <div class="col-sm-4"><img src="<?php echo base_url('assets/');?>img/articles/article_1.jpg" alt="Image"></div>
            <div class="col-sm-8">
              <p style="text-align: justify;">The institute has, however, also issued AAS 4, which contends that by Chetan Dalal fact that an audit is carried out may act as a deterrent, but the auditor is not and cannot be held responsible for the prevention of fraud and error’. Dalal maintains, however, that an auditor can scarcely avoid or turn away from the possibilities of fraud. He thus needs to equip himself with a reasonable level of awareness of the symptoms of fraud. While the line of demarcation between investigation and audit may overlap, a good professional should be able to render a value-based service, he points out. 

              ”The concept of an auditor (particularly, those audit assignments where they are not under a statute), being a compliance officer, has disappeared and is virtually being replaced by the ’business partner’ concept,”. He observes ”As long as the fundamental principles of audit, professional ethics and standards of auditing are not being compromised, the auditor can and must offer all his skill and expertise to the client.” 

              Dalal provides a practical approach for investigation, in an effort to bring greater awareness of the existence of possible frauds, and to provide an insight into structured as well as uncommon methods for detection of frauds. The underlying principle is evidently ’forewarned is forearmed’. </p>
            </div>
            
          </div>
        </div>
      </div>
    </div>

  </div>
  </div>
</section>
<?php } ?>