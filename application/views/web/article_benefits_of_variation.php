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
        <li>The benefits of variation</li>        
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
          <h1>The benefits of variation</h1>
          <p class="articletext">
            Variation, through the element of surprise, phenomenally increases the effectiveness of any fraud detection strategy.

            There is no greater comfort to an embezzler than a predictable and repetitive inspection or audit programme, however exhaustive and penetrative it may be. All white-collar crimes are essentially manipulations executed with intelligence and adroitly adapted to a given system and environment. Unless variation and surprises are brought in, the planning and execution of frauds becomes easy. Cyclical surveillance of any kind, whether it be an audit, investigation, or a managerial review, is emasculated by predictable, fixed, and standardised routines.

            In a tea-manufacturing company there were several tea estates in a particular area at dispersed locations. The tea leaves were grown, collected, processed, and packed into boxes at each of the estates. Each estate was under the control of a manager who had under him the plantation workers, accounts, and payroll staff. The main expense was the monthly staff pay roll, most of which was paid in cash. The company had its team of internal and external auditors who regularly visited all the estates in succession on fixed dates each year. These auditors usually had a well-planned schedule which had a convenient route so as to facilitate a visit to all the estates within a given time. On an average each team spent about three days at each location. The review plan at each estate was standardised. It included a comprehensive check of all finance-related areas and even included a ‘surprise' cash count at any time of the auditors' choice during their visit.  


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
          <div class="col-sm-4"><img src="<?php echo base_url('assets/');?>img/articles/article_3.jpg" alt="Image"></div>
            <div class="col-sm-8">
              <p style="text-align: justify;">For years this routine checking continued and no serious discrepancies were ever reported. However, in one year the audit team had a risk management expert. The expert felt that this was a typical case of the ‘stale procedures syndrome'. He explained to the chief auditor that though the areas covered were exhaustive, the plan was too predictable and repetitive. While he explained that he did not mean to suggest that there was foul play, there certainly was a risk that an intelligent fraudster would rind the audit exercise easy to circumvent. He pointed out that the surprise cash count was no surprise at all because their audit schedule was well known and the audit team was picked up and dropped from one estate to the next on dates communicated well in advance to each of the tea estates. Therefore no cashier, Storekeeper, or manager would be foolish enough to leave any trace of any wrongdoing and the review would never have the edge of a ‘surprise‘ check. </p>
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
              <p style="text-align: justify;">The chief auditor conceded the point and asked him what could be done in the given situation. The tea estates were on mountains and there was no other means of transport to facilitate their coming unannounced. The expert suggested that the planned route be changed suddenly, and, to have at least one tea estate visited twice in quick succession. Accordingly, when one of the tea estates' audit was completed, the audit team moved on to the next estate and began the review there. However, one of the team members was sent back to the previous estate immediately to conduct a second cash count, stores verification, and examination of payroll payments. The results were astonishing. There was a cash shortage of Rs 3.24 lakh. The payroll review also showed plenty of empty envelopes of previous month's uncollected wages of employees who had left. </p>
            </div>
            <div class="col-sm-4"><img src="<?php echo base_url('assets/');?>img/articles/article_3.jpg" alt="Image"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row offset-top-80 " >
      <!-- <h2>Image <span>Left</span></h2> -->
      <div class="inner-wrapper-main image-styles">
        <div class="col-sm-10 col-sm-offset-1">
          <div class="row">
          <div class="col-sm-4"><img src="<?php echo base_url('assets/');?>img/articles/article_3.jpg" alt="Image"></div>
            <div class="col-sm-8">
                <p style="text-align: justify;">A detailed investigation was ordered and it was found that there was a cartel of some of the tea estate managers indulging in cash and payroll manipulations. Shortages were easily covered up by transferring cash from one estate to another during an audit period. What was revealed was exactly that. The tea estate whose audit had just been completed had dispatched some cash and some of the unpaid workers' wages to another tea estate to cover up a shortage there and where audit was to take place shortly as per the audit schedule. This procedure was simple, easy, and unfortunately successful, because the standard audit timing as well the technique had remained unchanged for the past 10 years. 

                In the process of risk management the chances of both preventing and detecting fraud by regular well defined and relatively predictable procedures are slim, more so if procedures have become stale. The perpetrators in most cases will have adapted themselves, and also familiarised themselves with the relative strengths and weaknesses. If at all frauds in such situations are unearthed, they are stumbled upon accidentally. Only innovative variations introduced, with an element of surprise, are capable of revealing, or for that matter; deterring potential fraudsters.
              </p>
            </div>
            
          </div>
        </div>
      </div>
    </div>

  </div>
  </div>
</section>
 <?php } ?>