<style type="text/css">
  .articletext{
    text-align: justify
  }
</style>
<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>Case Studies</h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li>Publications</li>        
        <li><a href="<?php echo base_url('case-studies');?>">Case Studies</a></li>        
        <li>The ‘time-bomb’ approach used by fraudsters- Part II</li>            
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
          <h1>To view this Case Study you must <a style="color:#6091ba;" href="<?php echo base_url('login?redirect_to=case_studies/case-studies-details/9')?>">login</a>.</h1>          
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
          <h1>The ‘time-bomb’ approach used by fraudsters- Part II</h1>
          <p><h4>Introduction</h4></p>
          <p class="articletext">
            In the part I of this article, the  principle of the time bomb approach often used by fraudsters was illustrated. Very simply, under this approach, fraudsters  carry out an act/omission, which does not impede or affect any routine operation for some time. Such an act/omission remains latent  for some time before it brings about devastation in some form. This period of time during which the act/omission remains dormant or latent enables the perpetrator to distance himself from the scene or from involvement,  and reduces the chances of any suspicion falling on him. He obviously derives some benefit from the devastation. The previous part illustrated a time bomb effect used by a fraudster in the world of medicine. This part illustrates how  this ‘time bomb’ approach  was used  in a five star hotel to suppress collections.
          </p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="inner-wrapper-main typo">
        <div class="col-sm-12">
          <p><h4>Backdrop</h4></p>
          <p class="articletext">
            ABC was a five star luxury hotel which was set up in a metro city in India. It had started off as an average hotel but had grown over the years and become a very popular hotel. It had acquired a five star status and had massive expansion plans. Originally a hotel with just some 20 rooms and one ordinary restaurant, it now had 200 rooms with five different restaurants, a beauty parlour, swimming pool, jacuzzi, sauna and steam baths, a health club etc. Seeing the past trend and potential for even greater growth, the directors had sanctioned huge budgets for expansion of the hotel and improving the existing facilities. The latest addition was an amphi theater where the hotel guests and visitors could see movies. 
          </p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="inner-wrapper-main typo">
        <div class="col-sm-12">
          <p><h4>Accounting system</h4></p>
          <p class="articletext">
            The hotel had grown  rapidly from a small hotel to a large luxury five star hotel. Its accounting applications  had been developed up over a period of time  in patches as its needs grew. It had a financial accounting application which had been used since it was a small hotel. When the hotel’s sales outlets increased, it developed a ‘Point of Sale’ (POS) software. Accordingly it  had installed POS terminals for monitoring and accounting for   sales and revenue earned through its various sales outlets such as the bar, restaurants, beauty parlour, health club, swimming pool, bakery, and other direct front desk revenue collections. Subsequently, to keep with the times, the hotel got a separate application for responding to internet inquiries for room reservations and to effect web based sales. It also had separate applications for inventory and payroll. All these had to be interfaced with the financial accounting application. The IT head  had therefore been entrusted the responsibility of interfacing all these applications  with the financial accounting application. Accordingly, an interface software was developed by the IT head which  generated a journal entry for the daily sales from all sources, which was automatically uploaded in the  financial accounting system. In fact, the  entire hotel operations,  though monitored through different applications, were  so interfaced and journal entries for all its applications like payroll, inventory and sales were automatically uploaded in the financial accounting system. 
            Though the system had been developed in patches, the directors had been reasonably careful in their approach. At each stage when a new application was installed it was tested by IT experts, before it was fully implemented. The diagram below provides a pictorial view of the interfacing of the sales application wherein its POS terminals   generated a journal entry which was automatically uploaded in the financial accounting system .


          </p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="inner-wrapper-main typo">
        <div class="col-sm-12">
          <p><h4>Internal Auditor notices a red flag</h4></p>
          <p class="articletext about_justify">
            The Point of Sale  (POS) application had a large menu of various reports, most of which were not even being used by the management. In addition to the usual daily  report of sales and collections for each service and facility offered by the hotel, the  POS system provided detailed reports for :


            <div class="unordered-list default-list">
              <ul>
                <li>Time slot wise sales</li>
                <li>Cashier-wise sales</li>
                <li>Terminal wise sales</li>
              </ul>
            </div>


            <p style="text-align: justify;">Though these reports were never reviewed by the management, the  internal auditor decided to study them for a better understanding of the hotel operations. He studied these reports to review trends and patterns  to ferret out anomalies or abnormalities if any. His effort was rewarded quickly. He found something strange in the report relating to the break up of cash and credit card sales. The anomaly appeared with respect to  the recently introduced amphi theater. Except for the first month during which the amphi theater was introduced, sales  for  entire nine month period after  it was introduced,   were effected only through  credit cards or  guest room recoveries (where guests staying at the hotel asked that the ticket sales be debited to their room).  There were no cash sales at all. Since this theater was open not only to the hotel’s in-house guests but also to outsiders visiting the hotel or its restaurants, (where footfalls were very high), it was difficult to believe that there were just no cash sales. To satisfy himself, the internal visited the amphi theater the next day and bought a ticket in cash. The tickets were issued by the hotel sales and event manager who had been given a counter for this purpose. Inside the theater he observed that there  was about 60 % seat occupancy. His suspicions about the  missing cash sales  were confirmed, when he checked the sales the next day. His own cash sale did not appear in the POS report. He also noticed that total ticket sales disclosed indicated that there was only about 25 % occupancy in the theater. It was obvious that ticket sales were being suppressed.  Without disclosing what he knew,  he queried the sales and events manager about the poor theater occupancy and the general absence of cash sales. The sales and events manager  responded stating that since the amphi tickets were priced at Rs. 500 each,  not many people bought them. Those who could afford these prices, generally used credit cards and in case of guests staying at the hotel, most of them charged the tickets to their room account. That  was why there were no cash sales.  It was now clear that  the sales and events manager was lying and obviously  misappropriating some part of the ticket sales collections, but the internal auditor did not want to confront him just yet. He wanted to get a complete overview of the modus operandi of the fraud, the quantum and the accomplices involved. He therefore made inquiries with the  other senior hotel staff such as the  general manager, the cashiers, the  bell boys and other attendants. Based on the lengthy discussions he had with all these and also the  IT head, the internal auditor discovered that this was a case of the time bomb fraud, perpetrated by the manager.</p>


          </p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="inner-wrapper-main typo">
        <div class="col-sm-12">
          <p><h4>How was the fraud was planned</h4></p>
          <p class="articletext">
            As stated earlier, the sales and events management had developed  and implemented the POS software  over a period of time, through its IT department.  
            The sales and event manager of the hotel was an intelligent person and had been with them for quite some time and had been an integral part of the development process and was very sharp and knowledgeable. However on a personal front, he had got into bad habits and had lost a lot of money and was constantly on the look-out for ways and means to make up his losses. He got one opportunity during the process of the development of the POS system, where the management encountered  a major problem of monitoring party and event sales. The usual cashiers at the POS outlets were not very happy about recording and monitoring party sales. This was because the POS software  was designed to monitor cash handling by cashiers and there were a lot of controls built in for rates, items sold, discounts and offers. By an large the usage of POS for routine sales was simple and user friendly, but party and event sales were a different proposition altogether. These party and event sales  collections were based on negotiations and constantly changes. The amounts billable were unpredictable as there were too many variables in terms of rates, items and discounts which had to be changed virtually for each event on each day. This resulted in too much of work and reconciliation of collections by cashiers and later being accountable to the management and internal auditors.  The regular cashiers and accountants were therefore disgruntled about this. The management was looking for a solution to this problem. The sales and events manager saw an ideal opportunity to plant a ‘time bomb’. He offered his own terminal specifically to  record such party or event sales so that the regular POS sales of the regular outlets would not be affected. He also offered to prepare daily reports and assist in uploading these sales. The management saw this as a welcome solution because the cashiers and accountants were becoming very  non co-operative. The management immediately agreed and appreciated the gesture  of the sales and events manager, not realizing that this was a kind of a time bomb.
            What the management missed out was the fact that the sales and event manager  got the  access  privilege of accepting large value advances and cheques and cash collections in  a terminal which was not on-line. The sales and event manager could up load the collection even at the end of the day because his was not an actual sales counter. Since most party sales were realized from corporate clients through cheques, the management did not see any risk in this.  The sales and event manager however  looked for  opportunities and even created some,  to collect cash at this terminal. He encouraged ‘friendly’ party hosts  to pay cash by offering discounts. Wherever he succeeded in generating  cash collections, he pocketed them or a large part of them. To satisfy auditors he  started teeming and lading practices (adjusting  advances received for future parties to fill up deficits created by misappropriating  collections for current events and parties). This went on for some time but his hunger for fraud grew. He wanted more cash.  He got that opportunity too very soon. Some months later, the project of the amphi theater was sanctioned and the management was faced with the same problem of requesting cashiers to include ticket sales for amphi theater.   As expected there was no cheer among the cashiers to take on this extra work and once again the sales and event manager came to the management’s rescue. He offered to take this also in his terminal.  The directors expressed their appreciation for this and even promoted him. The sales and events manager was overjoyed. 
            Therefore, as decided by the management, when the amphi theater was operational, the ticketing and the collection was done through the sales and event manager’s  POS terminal. Initially, for a month the sales and event manager did not manipulate anything. He knew that all eyes would be there on this new theater for some time so he waited for some time. Then, as the novelty of the new theater wore off, he started siphoning out cash collections without recording them in the POS terminal. Credit Card sales could not be misappropriated, and in any case he had to show some sales;  therefore he recorded them. Since this was not a regular cinema house, there were no serial numbered tickets and there was free seating. The guests were just given tokens which were returned to the ushers who returned them to the sales and events manager. As regards the daily sales, since he was originally monitoring party sales which did not have much cash,  his terminal was not monitored for surprise verifications  by the management or the auditors in the same way as they monitored the other POS collections. The sales and events manager’s end-of-the-day entry was enough for registering party sales and tickets sold at the theater.
            In the amphi theater alone, the sales and event manager, on a daily basis, siphoned  cash sales proceeds for a minimum of  10 seats in each show, for four shows, at Rs 500 a show-Rs 20,000. The total fraud in about a nine month period for ticket sales and party sales misappropriated exceeded Rs. 75 lacs.

          </p>
        </div>
      </div>
    </div>

    
    <div class="row">
      <div class="inner-wrapper-main typo">
        <div class="col-sm-12">
          <p><h4>Lessons learnt</h4></p>
          <p class="articletext">
            Internal auditors can learn the following lessons from the above case study:

            <div class="ordered-list">
              <ol>
                <li style="text-align: justify;">Look for red flags by viewing  data from all sides. Had the auditor not shown keen interest in the different reports, even the unused reports of the software, he would not have got the valuable clue- that there were only credit card sales and no cash sales. Even  AAS 4 requires an auditor to apply professional skepticism. Therefore it is advisable to view data kaleidoscopically in as many ways as possible. It would be useful to study every auditee’s accounting application to understand the nature of reports it is capable of generating </li>
                <li style="text-align: justify;">Physical aspects of any business are as important, if not more, than the records and books of account. In the above case, the auditor applied his test of reasonableness to the verify the absence of cash sales in the records and found it to be odd. When he himself went and actually observed how the theater ticket sales were effected he saw that cash sales did take place and also how high the theater occupancy was. Such personal visits to all places of operations of every business can provide immeasurable information and could throw out clues and anomalies in records, as it did in the above case.</li>
                <li style="text-align: justify;">There are never any short cut or ‘quick fix’ solutions. In the above, case the manager offered a  solution for monitoring the amphi theater ticket sales which the directors agreed to, without thinking of the consequences. Their immediate worry was the cashiers’ non co-operation and availability of the terminal which was solved by quick fix solution of using the POS terminal of the sales and event manager. However they forgot that there should have been separate controls in that terminal too.</li>
              </ol>
            </div>


          </p>
        </div>
      </div>
    </div>


  </div>
  </div>
</section>
<?php }?>