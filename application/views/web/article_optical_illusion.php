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
        <li>Optical illusions and reality</li>        
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
          <h1>Optical illusions and reality</h1>
          <p class="articletext">
            Being guided by what you think you see rather than what you actually see could make you a victim of deception there was a manager, a paragon of virtue, an exemplary case of a sincere hardworking and dedicated employee. He usually would be the first to enter office and the last to leave. He had been conferred the rnost hardworking and valuable employee designation, The entire office was stunned when it was eventually revealed that he was actually involved in fraudulent manipulations in the application software to suppress his own overdue loan account, and those of his accomplices in the overdue statements, he also inflicted considerable damage to the company by adjusting friendly debtors balances to show lesser receivable balances than actuals. All these manipulations and research relating to them were effected during those periods of apparent ’late sitting’ which disillusioned the company. The late sitting was an illusional attitude of hard work created to shield the real truth of deception. 

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
          <div class="col-sm-4"><img src="<?php echo base_url('assets/');?>img/articles/article_2.jpg" alt="Image"></div>
            <div class="col-sm-8">
              <p style="text-align: justify;">Man's actions are often governed not by what he actually sees, but what he thinks he sees. Thus his perception is a result of not only his vision but also his mind set, preconceived notions, deep-rusted beliefs and past experience. For example, consider the question 'Why are 1990 Indian rupee coins worth more than 1960 Indian rupee coins?’ Most people would obviously jump to the conclusion that the answer has something to do with the quality of the coins minted in 1990 or 1960. However, the answer is quite simple: one thousand nine hundred and ninety rupees are greater than one thousand nine hundred and sixty rupees What happens is that the brain is so used to seeing a number as 1990 as a calendar year, that it does not consider the other possibility-a pure and simple number one thousand nine hundred and ninety. An imperfect understanding of the question is reached and consequently the simple answer is missed. The brain subconsciously often adds its own deep rooted beliefs and presumptions to a message received by it, and its intellect judges data or information in the light of such presumptions in such circumstances, sometimes, his judgement is clouded and possibly he could become a victim of an incorrect interpretation, Perpetrators of fraud try to take advantage of this phenomenon, by adroitly projecting illusions in facts, figures or even behaviour to camouflage their ulterior and ill motivated actions, therefore, it is advisable to approach a problem with care and caution, to understand it clearly, and distrust anything that is too obvious unless and until it is primed, preferably try hard core evidence. </p>
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
              <p style="text-align: justify;">The following is another illustration of this phenomenon. A benevolent young man used to regularly visit a bank to deposit and withdraw cash and cheques (or certain aged and handicapped people. He was an agent for LIC policies, investments, etc., and was apparently doing quite well. He had a pleasant personality and was friendly with everyone in the bank. There was nothing to suggest that he had a personal interest or motive and all the account holders, whom he was helping, trusted him implicitly and never had any complaints. The internal auditor who was auditing that bank’s accounts wondered how this man had the time to help so many people even in the busy month of the financial year. In fact, at times the man would visit the bank even twice a day as evidenced from the daily deposits and withdrawals. The internal auditor felt that he was too helpful to be doing this without an ulterior motive. </p>
            </div>
            <div class="col-sm-4"><img src="<?php echo base_url('assets/');?>img/articles/article_2.jpg" alt="Image"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row offset-top-80 " >
      <!-- <h2>Image <span>Left</span></h2> -->
      <div class="inner-wrapper-main image-styles">
        <div class="col-sm-10 col-sm-offset-1">
          <div class="row">
          <div class="col-sm-4"><img src="<?php echo base_url('assets/');?>img/articles/article_2.jpg" alt="Image"></div>
            <div class="col-sm-8">
              <p style="text-align: justify;">He studied the pattern of the deposits and withdrawals in the man’s own bank account. He saw that there were several days on which he actually deposited and withdrew identical amounts on the same day. It did not make sense why a person would deposit and withdraw an amount on the same day within a span of one hour several times in a month. A surveillance and an investigation later revealed that he was laundering counterfeit notes. He was inserting counterfeit notes in wads of currency deposited and later withdrawing the money. He would even change several notes in some of the cash deposits of the aged and handicapped people, since the aura of a noble cause was created and several deposits were paid at one time, generally no one suspected him of inserting counterfeit notes. 

              Such cases indicate one simple factor. Something that is too obvious, or too good to be true, should be examined and corroborated. Since the human mind gets carried away easily, truth has to be established unassailably with due care, evidence and factual corroboration. Distrust the obvious. </p>
            </div>
            
          </div>
        </div>
      </div>
    </div>

  </div>
  </div>
</section>
<?php }?>