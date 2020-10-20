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
      <h2>CDIMS <span>Online course Enrolment</span> </h2>
      <div class="inner-wrapper-main">
        <!-- <div class="row">
            <marquee class="title" direction="left" behavior="alternate" scrolldelay="250">
                <div>
                    <ul>
                        <li class="text_animate" style="list-style: none;"> 
                        <font color="#f54205">ADDITIONAL Discount of <b><i class="fa fa-inr"></i> 1,000 </b> on this </font>
                         <font color="#020167">Independence Day - Use Coupon code <b>"INDPD70"</b> </font>
                         <font color="#0d6405">Valid on 14th and 15th August 2017 only.</font>
                        </li>
                    </ul>
                </div>
            </marquee>
        </div> -->
        <div class="col-md-12  ">
          <div class="form">
            <form action='<?php echo base_url('register/payment-for-course');?>' name="payuForm" method='post'>
              <div class="row" >
                <div class="col-md-6">
                  <label>Course Type </label><br />
                  <input type="text" readonly class="txt" name="c_type" value="Online Course" disabled />     
                  <input type="hidden" readonly class="txt" name="c_type_hid" id="c_type_hid" value="olc"  />              
                </div>
                <div class="col-md-6">
                  <label>Amount </label><br />
                  <input type="text" class="txt" readonly id="amount" name="amount" value="17700" disabled />
                </div>                
              </div>
              <div class="row" >
                <div class="col-md-6">
                  <label>Billing Name <font color="red">*</font> </label><br />
                  <input placeholder="Billing name to be on invoice." type="text" required  class="txt" id="billing_name" value="<?php echo ucfirst(strtolower($this->session->userdata('firstname')));?>" name="billing_name" maxlength="40"  />
                </div>
                <div class="col-md-6">
                  <label>Billing Address <font color="red">*</font> </label><br />
                  <textarea placeholder="Billing address to be on invoice." type="text" class="txt_3" required  id="billing_address" name="billing_address" maxlength="500"></textarea>
                </div>                
              </div>
              
              <div class="row">
                <div class="col-md-6">
                    <label>Are you a graduate ?</label>
                    <select id="ayag" type="text" class="txt">
                        <option selected disabled>Choose</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="col-sm-6" >
                    <label>Coupon Code </label><br/>
                    <input type="text" class="txt" placeholder="Do you have a coupon code? "  id="coupon_code" name="coupon_code" value="<?php echo @$coupon_code;?>"  />
                </div>
              </div>
              <div class="row" >
                <div class="col-md-6">
                  
                  <input title="Reverse Charge" type="checkbox"   class="txt" id="reverse_charge"  name="reverse_charge"  />&nbsp;&nbsp;&nbsp;<label>Reverse Charge (for GSTIN - Check the checkbox to avail benefit of GST)  </label>
                  <br />
                  <br />
                </div>
                <div class="col-md-6 gst_hide" id="gst_hide">
                  <label>GSTIN <font color="red">*</font> </label><br />
                  <input placeholder="GST No. for reverse charge."  type="text" class="txt_3"   id="gstin" name="gstin" maxlength="15"/>
                </div>                
              </div>

              <!-- <div class="row" id="cert_note">
                <div class="col-sm-6">
                    <center>
                    <li><i style="color: red;">Please Note : You can proceed with the course, but the certificate will be issued only after graduation (within the duration of the course)</i></li></center>
                </div>                               
              </div> -->  

              <div class="row">
                <div class="col-md-12">
                    Note :
                </div>
                <div class="col-md-12 ordered-list" id="notes">
                    <ol>
                        <li>The course needs to be finished within 6 months of date of enrolment.</li>
                        <li>Please ensure that your name is correctly spelled as this is what will be used for your final certificate.</li>
                        <li id="cert_note"><i style="color: red;">You can proceed with the course, but the certificate will be issued only after graduation (within the duration of the course)</i></li>
                    </ol>
                </div>               
              </div>                         
              <center>
                <div class="btn-shapes">
                    <!-- <input type="submit" value="Pay" name="submit" class="txt2" data-toggle="modal" data-target="#modal_license" />  -->
                    <button type="button" id="pay_for_olc" class="btn btn-primary" >Pay</button>
                </div> 
              </center>

              <div class="modal fade" id="modal_license">
                <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">License & User Agreement</h4>
                      </div>
                      <div class="modal-body">
                        <div style="height: 240px; overflow-y: scroll">
                            <p style='margin:0cm;margin-bottom:.0001pt;background:white;vertical-align:
                            baseline'><span class=red2><i><span style='font-size:11.5pt;font-family:"inherit",serif;
                            color:#880000'>Please read the following carefully</span></i></span><span
                            style='font-size:11.5pt;font-family:lato;color:#050505'><o:p></o:p></span></p>

                            <p style='margin-top:7.5pt;margin-right:0cm;margin-bottom:0cm;margin-left:0cm;
                            margin-bottom:.0001pt;text-align:justify;background:white'><b><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>IMPORTANT-
                            PLEASE READ CAREFULLY This End User License Agreement (“Agreement”)</span></b><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'> constitutes
                            a valid and binding agreement between Chetan Dalal Investigation and Management
                            Service Pvt. Ltd. (“CDIMS” or “we”) with office at 308-309, Bombay Market
                            Apartments, Tardeo Road, <span class=msoDel><del cite="mailto:Mahesh%20Bhatki"
                            datetime="2017-04-17T12:34"> </del></span>Near AC Market, Tardeo, Mumbai
                            -400034, and you (“you,” or “your”) for the use of the online course material,
                            as those terms are defined below. You must enter into this agreement in order
                            to install, access and use the online course. The term CDIMS shall also include
                            itself, its Directors, its associate companies, its faculties, consultants,
                            course contributors and third party service providers and all companies under
                            the same management.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>BY UNDERGOING
                            THE ONLINE COURSE, YOU AGREE TO BE BOUND BY THE TERMS OF THIS AGREEMENT. IF YOU
                            DO NOT AGREE TO THE TERMS OF THIS AGREEMENT, DO NOT PAY OR ACCESS THE ONLINE
                            COURSE.&nbsp;The Online Course is not intended for use by or availability to
                            persons under the age limit of any jurisdiction which restricts the use of
                            Internet-based applications and services according to age. IF YOU RESIDE IN
                            SUCH A JURISDICTION AND ARE UNDER THAT JURISDICTION’S AGE LIMIT FOR USING
                            INTERNET-BASED APPLICATIONS OR SERVICES, YOU MAY NOT DOWNLOAD OR USE THE ONLINE
                            COURSE AND YOU MAY NOT ACCESS THE SERVICES.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>&nbsp;1. License Grant</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>Subject to
                            the terms of this Agreement, CDIMS hereby grants you a limited, non-exclusive,
                            personal, non-sub licensable, non-assignable license to download, install and
                            use the Online Course, including CDIMS Learning Management System, any online
                            or enclosed documentation, courses, data distributed to your computer for
                            processing and any future programming fixes or updates provided to you
                            (collectively, the “Online Course”) onto an authorised  computer systems
                            comprising of desktops, laptops,  mobile phone, tablets and such computer
                            equipments authorised from time to time; OR install and store the Software on a
                            storage device, such as a network server, used only to utilize the Software on
                            your other computers over an internal network, provided you have a license for
                            each separate computer on which the Software is installed and run for your sole
                            use to install, interact with and utilize the Online Course, including the
                            content and features contained therein and the services and the Network related
                            thereto (“Services”). The Online Course may only be used in connection with the
                            Services. As used herein, the term “Network” means the universe of computers
                            connected to the Internet that are operating the Online Course.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>2. License Restrictions</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>a)
                            Notwithstanding anything to the contrary, you may not: (i) remove any proprietary
                            notices from the Services, Online Course or any copy thereof; (ii) cause,
                            permit or authorize the modification, creation of derivative works,
                            translation, reverse engineering, decompiling or disassembling or hacking of
                            the Online Course, the Services or the Network; (iii) sell, assign, rent,
                            lease, act as a service bureau, or grant rights in the Online Course or
                            Services, including, without limitation, through sublicense, to any other
                            entity without the prior written consent of CDIMS; (iv) export or re-export the
                            Online Course in violation of Indian  laws or any applicable laws; (v) use the
                            Online Course or Services for any commercial purpose or the benefit of any
                            third party or charge any person for the use of the Online Course; or (vi) use
                            the Online Course or Services to, or in any way that would violate any
                            applicable law, regulation or ordinance; (vii) collect any information or
                            communication about the Network or users of the Online Course or Services by
                            monitoring, interdicting or intercepting any process of the Online Course or
                            the Network; and (viii) use any type of bot, spider virus, clock, timer,
                            counter, worm, software lock, drop dead device, packet-sniffer, Trojan-horse
                            routing, trap door, time bomb or any other codes or instructions that are
                            designed to be used to provide a means of surreptitious or unauthorized access
                            or that are designed to distort, delete, damage or disassemble the Online Course,
                            the Services or the Network. Furthermore, you may not use the Online Course or
                            Services to develop, generate, transmit or store information that: (A)
                            infringes any third party’s intellectual property or other proprietary right;
                            (B) is defamatory, harmful, abusive, obscene or hateful; (C) in any way
                            obstructs or otherwise interferes with the normal performance of another
                            person’s use of the Online Course or Services, (D) performs any unsolicited
                            commercial communication not permitted by applicable law; (E) is harassment or
                            a violation of privacy or threatens other people or groups of people; and (F)
                            impersonates any other person, or steals or assumes any person’s identity
                            (whether a real identity or online nickname or alias).</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(b) The
                            Online Course and Services contain confidential and trade secret information
                            owned or licensed by CDIMS, and you agree to take reasonable steps at all times
                            to protect and maintain the confidentiality of such information.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(c) The
                            Online Course and Services may be incorporated into, and may incorporate,
                            technology, software and services owned and controlled by third parties. Use of
                            such third party software or services is subject to the terms and conditions of
                            the applicable third party license agreements, and you agree to look solely to
                            the applicable third party and not to CDIMS to enforce any of your rights. All
                            modifications or enhancements to the Online Course and Services remain the sole
                            property of CDIMS. You understand that CDIMS, in its sole discretion, may
                            modify or discontinue or suspend your right to access any of its Services or
                            use any of the Online Course at any time, and may at any time suspend or
                            terminate any license hereunder and disable any Online Course you may already
                            have accessed or installed without prior notice. CDIMS reserves the right to
                            add additional features or functions to the Online Course. When installed on
                            your computer, the Online Course periodically communicates with CDIMS servers.
                            You acknowledge and agree that CDIMS has no obligation to make available to you
                            any subsequent versions of its software applications.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>  <strong><span style='font-family:"inherit",serif'>3.
                            Permission to Utilize.</span></strong></span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>In order to
                            receive the benefits provided by the Online Course, you hereby grant permission
                            for the Online Course to utilize the processor and bandwidth of your computer
                            for the limited purpose of facilitating the communication between other Online Course
                            users. You understand that the Online Course will protect the privacy and
                            integrity of your computer resources and communication and ensure the
                            unobtrusive utilization of your computer resources to the greatest extent
                            possible.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>4. Proprietary Rights.</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>The Online Course
                            and Services contain proprietary and confidential information of CDIMS,
                            including copyrights, trade secrets and trademarks contained therein, which are
                            protected by international copyright laws. Title to and ownership of the Online
                            Course, including without limitation all intellectual property rights therein
                            and thereto, are and shall remain the exclusive property of CDIMS and its suppliers,
                            and except for the limited license granted to you (under this Agreement), CDIMS
                            reserves all right, title and interest in and to the Online Course. You shall
                            not take any action to jeopardize, limit or interfere with CDIMS’s ownership of
                            and rights with respect to the Online Course and Services. You acknowledge that
                            any unauthorized copying or unauthorized use of the Online Course or Services
                            is a violation of this Agreement and copyright laws and is strictly prohibited.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>5. Term; Termination.</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(a) This
                            Agreement will be effective as of the date you accept this Agreement, thereby
                            expressly agreeing to the terms and conditions set forth herein, and will
                            remain effective until expiration date set forth for your licenses as stated
                            elsewhere in this agreement or unless terminated by either party as set forth
                            below.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(b) You may
                            terminate this Agreement at any time provided you cease all use of the Online Course
                            and Services AND destroy or remove from all hard drives, networks, and other
                            storage media all copies of the Online Course in your possession and confirm
                            this in writing on official letterhead with CDIMS no later than ten (10)
                            business days after termination. Termination of this agreement by you does not
                            affect any payments that you may have already made under this Agreement, and no
                            refunds shall be made based on a termination.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(c) CDIMS may
                            terminate this Agreement at any time, with or without cause, by providing
                            notice to you and/or preventing your access to the Online Course and/or
                            Services. In this case, you must confirm in writing with CDIMS no later than
                            ten (10) business days after termination that you have ceased use of the Online
                            Course and Services AND destroyed or removed from all hard drives, networks,
                            and other storage media all copies of the Online Course in your possession. If
                            the termination is not due to your fault or breach, CDIMS shall refund license
                            fees for any unused licenses based upon expected usage as contemplated at the
                            time of purchase.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(d) Upon
                            termination of this Agreement for any reason (i) all licenses and rights to use
                            the Online Course and the Services shall terminate and you must remove the
                            Online Course from your computer equipment and dispose of all originals and copies
                            of the Online Course in your possession, and (ii) Sections 2, 4, 5(b), and 7
                            through 13 shall survive such termination.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>6. Payment.</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>If you have
                            subscribed to online Learning Management System or to the courses hosted of CDIMS’s
                            site you acknowledge that certain functions in the Online Course are only
                            available to paid subscribers after a free trial period allowed if any of the
                            Online Course and Services (the “Free Trial Period”) ends. After the Free Trial
                            Period ends as aforesaid, you will be presented with the option to subscribe to
                            the Subscription Services. If you do not wish to subscribe, you acknowledge
                            that you cannot access functions and services only available to paid
                            subscribers. To subscribe to the Subscription Services you must agree to the
                            terms and conditions of the Subscription Services.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>If you have
                            purchased CDIMS’s Learning Management System or Courses to be installed locally
                            on your computer or upgrades or support contracts, you represent or warrant
                            that you have paid all sums due therefor or shall pay the same according to
                            terms and conditions of the purchase.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>7. Your Representations and Warranties.</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(a) You
                            represent and warrant that (i) you possess the legal right and ability to enter
                            into this Agreement and to comply with its terms, (ii) you will use the Online Course
                            and Services for lawful purposes only and in accordance with this Agreement and
                            all applicable laws, regulations and policies, (iii) you will not attempt to
                            decompile, reverse engineer or hack the Online Course or the Network or to
                            defeat or overcome any encryption and/or other technical protection methods
                            implemented by CDIMS with respect to the Online Course and/or data transmitted,
                            processed or stored by CDIMS or other users of the Online Course, (iv) you will
                            not take any steps to interfere with or in any manner compromise any of CDIMS’s
                            security measures, any other individual’s or entity’s computer on the Network
                            and/or otherwise sharing Services, (v) you will always provide and maintain
                            true, accurate, current and complete information as requested by CDIMS, and
                            (vi) you will only use the Online Course and Services on a computer on which
                            such use is authorized by the computer’s owner. (vii) in respect of Online
                            Courses you will use a password that is not easily compromised or predictable
                            by anyone else and all measures shall be taken to keep the password safe and
                            secure at all times, (viii) in furtherance of the foregoing you will not
                            directly or indirectly allow anyone to avail any portion of the Online Courses
                            either by sharing your user_id, password or in any other manner. (ix) </span><span
                            lang=EN-US style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>Without
                            the prior consent of the author, no part of Online Courses, the test data and
                            other downloadable materials or any other material connected with the Online
                            Courses may be copied, reproduced, stored or transmitted in any form or by any
                            means including without limitation by means of <span class=msoDel><del
                            cite="mailto:Mahesh%20Bhatki" datetime="2017-04-17T12:34"> </del></span>electronic,
                            mechanical, photocopying, recording or otherwise.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(b) You agree
                            that you will not use any automatic or manual device or process to interfere or
                            attempt to interfere with the proper working of the Online Course, Network or
                            Services, except to remove the Online Course from a computer of which you are
                            an owner or authorized user in a manner permitted by this Agreement. You may
                            not violate or attempt to violate the security of the Online Course, Network or
                            Services. CDIMS reserves the right to investigate occurrences which may involve
                            such violations, and may involve, and cooperate with, law enforcement authorities
                            in prosecuting users who have participated in such violations.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(c) If CDIMS
                            has reasonable grounds to suspect that your representations, warranty or promises
                            are inaccurate or breached, CDIMS may terminate this license, deny any or all
                            use of the Online Course and/or Services, and pursue any appropriate legal
                            remedies.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>8. Indemnity.</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>You agree to
                            indemnify, hold harmless and defend CDIMS and its affiliates, parent companies,
                            subsidiaries, officers, directors, employees, agents and network service
                            providers at your expense, against any and all third-party claims, actions,
                            proceedings, and suits and all related liabilities, damages, settlements,
                            penalties, fines, costs and expenses (including, without limitation, reasonable
                            attorneys’ fees and other dispute resolution expenses) incurred by CDIMS
                            arising out of or relating to your (a) violation or breach of any term of this
                            Agreement or any policy or guidelines referenced herein, or (b) use or misuse
                            of the Online Course and/or Services.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>9. Disclaimer of Warranties</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(a) THE
                            ONLINE COURSE AND SERVICES ARE PROVIDED “AS IS” AND THERE ARE NO WARRANTIES,
                            CLAIMS OR REPRESENTATIONS MADE BY CDIMS, EITHER EXPRESS, IMPLIED, OR STATUTORY,
                            WITH RESPECT TO THE ONLINE COURSE OR SERVICES, INCLUDING WARRANTY OF QUALITY,
                            PERFORMANCE, NON-INFRINGEMENT, MERCHANTABILITY, OR FITNESS FOR A PARTICULAR
                            PURPOSE, NOR ARE THERE ANY WARRANTIES CREATED BY COURSE OF DEALING, COURSE OF
                            PERFORMANCE, OR TRADE USAGE. CDIMS FURTHER DOES NOT REPRESENT OR WARRANT THAT
                            THE ONLINE COURSE OR ANY SERVICES WILL ALWAYS BE AVAILABLE, ACCESSIBLE,
                            UNINTERRUPTED, TIMELY, SECURE, ACCURATE, COMPLETE, ERROR-FREE, OR WILL OPERATE
                            WITHOUT PACKET LOSS, NOR DOES CDIMS WARRANT ANY CONNECTION TO OR TRANSMISSION
                            FROM THE INTERNET, OR ANY QUALITY OF CALLS MADE THROUGH THE ONLINE COURSE OR
                            THE SERVICES.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(b) YOU
                            ACKNOWLEDGE THAT THE ENTIRE RISK ARISING OUT OF THE USE OR PERFORMANCE OF THE
                            ONLINE COURSE AND SERVICES REMAINS WITH YOU TO THE MAXIMUM EXTENT PERMITTED BY
                            LAW.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(c) THE
                            ONLINE COURSE IS UTILIZED AND DISTRIBUTED BY THIRD PARTY WHICH ARE UNRELATED TO
                            CDIMS. YOU ACKNOWLEDGE THAT INSTALLATION OF THE ONLINE COURSE WILL ALLOW THIRD
                            PARTIES WHO ARE NOT AFFILIATED WITH CDIMS THE ABILITY TO COMMUNICATE WITH YOUR
                            COMPUTER (“OUTSIDE PARTY”). YOU AGREE THAT CDIMS WILL NOT BE LIABLE FOR ANY
                            DAMAGE, CLAIM OR LOSS OF ANY KIND WHATSOEVER, INCLUDING BUT NOT LIMITED TO
                            INDIRECT, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES AS STATED IN PARAGRAPH
                            9(a) ABOVE, RESULTING FROM ANY ACTIONS OR OMISSIONS OF THE OUTSIDE PARTIES.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(d) The
                            Online Course incorporates contents of business names, telephone numbers,
                            characters, places, events, incidents, logos, references and such other data which
                            are just test data and fictional products of the author's imagination and only
                            meant for academic education and </span><span lang=EN-US style='font-size:8.5pt;
                            font-family:"inherit",serif;color:#050505'>with the intention to make the case
                            studies more demonstrative and understandable</span><span style='font-size:
                            8.5pt;font-family:"inherit",serif;color:#050505'>. </span><span lang=EN-US
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>The objective
                            is to show how intelligent fraudsters are and how they&nbsp;can manipulate
                            falsehood to look real life like. </span><span style='font-size:8.5pt;
                            font-family:"inherit",serif;color:#050505'>Any resemblance to actual persons,
                            living or dead, or actual events is purely coincidental </span><span
                            lang=EN-US style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>and
                            it does not mean that the relevant incident or fraud had taken place there</span><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>.  </span><span
                            lang=EN-US style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>The
                            opinions and views expressed in this Courses are without prejudice and are
                            based on experience of the authors, research or based on empirical studies. The
                            Courses is purely for academic consumption and should not be construed as
                            professional advice. The author does not warrant that the views stated shall be
                            effective in each and every case or may give predictable consequences. The
                            author shall not be responsible for the result of any action taken on the basis
                            of this work whether directly or indirectly and for any errors or omissions in
                            the work.</span></p>

                            <p class=MsoBodyText style='margin-bottom:4.0pt;text-indent:0cm;line-height:
                            11.1pt'><span lang=EN-US style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>(e) CDIMS and all its associates, expressly disclaim all and any
                            liability and responsibility to any person, whether a user or reader of this Courses,
                            in respect of anything, and of the consequences of anything, done or omitted to
                            be done by any such person in reliance, whether wholly or partially, upon the
                            whole or any part of the contents in this Courses. Without limiting the
                            generality of the above, we shall not have any responsibility for any act or
                            omission of any other author, consultant or editor.</span></p>

                            <p class=MsoNormal><span lang=EN-US style='font-size:8.5pt;line-height:107%;
                            font-family:"inherit",serif;color:#050505'>&nbsp;</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(f) As some
                            jurisdictions do not allow some of the exclusions set forth in this Section 9,
                            some of these exclusions may not apply to you.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>10. Limitation of Liability.</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(a) IN NO
                            EVENT SHALL CDIMS, ITS AFFILIATES, PARENT COMPANY, SUBSIDIARY, OFFICERS,
                            DIRECTORS, EMPLOYEES, AGENTS OR NETWORK SERVICE PROVIDERS BE LIABLE WHETHER IN
                            CONTRACT, WARRANTY, TORT (INCLUDING NEGLIGENCE (WHETHER ACTIVE, PASSIVE OR
                            IMPUTED), PRODUCT LIABILITY OR STRICT LIABILITY OR OTHER THEORY), FOR ANY
                            INDIRECT, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES (INCLUDING WITHOUT
                            LIMITATION ANY LOSS OF DATA, SERVICE INTERRUPTION, COMPUTER FAILURE OR
                            PECUNIARY LOSS) ARISING OUT OF THE USE OR INABILITY TO USE THE ONLINE COURSE OR
                            THE SERVICES, EVEN IF CDIMS HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH
                            DAMAGES.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(b) YOUR ONLY
                            RIGHT WITH RESPECT TO ANY PROBLEMS OR DISSATISFACTION WITH THE ONLINE COURSE
                            AND/OR SERVICES IS TO UNINSTALL AND CEASE USE OF SUCH ONLINE COURSE AND
                            SERVICES.</span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>(c) As some
                            jurisdictions do not allow some of the exclusions set forth in this Section 10,
                            some of these exclusions may not apply to you.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>11. Emergency Calls.</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>BY ACCEPTING
                            THE TERMS OF THIS END USER LICENSE AGREEMENT YOU EXPRESSLY ACKNOWLEDGE AND
                            AGREE THAT THE ONLINE COURSE AND THE SERVICES DO NOT AND ARE NOT INTENDED TO
                            SUPPORT OR CARRY EMERGENCY SITUATIONS OR EMERGENCY SERVICES OF ANY KIND AND
                            THAT CDIMS, ITS AFFILIATES, PARENT COMPANY, SUBSIDIARY, OFFICERS, DIRECTORS,
                            EMPLOYEES, AGENTS AND NETWORK SERVICE PROVIDERS ARE NOT NOR SHALL BE LIABLE IN
                            ANY MANNER FOR SUCH CALLS.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>12. Electronic Signatures and Agreements.</span></strong></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>You
                            acknowledge and agree that by clicking on the button labelled “SUBMIT”, “LAUNCH”, 
                            “OK”, “DOWNLOAD”, “I ACCEPT” or such similar links as may be designated by CDIMS
                            to download the Online Course to accept the terms and conditions of this
                            Agreement, you are submitting a legally binding electronic signature and are entering
                            a legally binding contract. You acknowledge that your electronic submissions
                            constitute your agreement and intent to be bound by this Agreement. Pursuant to
                            any applicable statutes, regulations, rules, ordinances or other laws, YOU
                            HEREBY AGREE TO THE USE OF ELECTRONIC SIGNATURES, CONTRACTS, ORDERS AND OTHER
                            RECORDS AND TO ELECTRONIC DELIVERY OF NOTICES, POLICY AND RECORDS OF
                            TRANSACTIONS INITIATED OR COMPLETED THROUGH THE ONLINE COURSE OR SERVICES.
                            Further, you hereby waive any rights or requirements under any statutes,
                            regulations, rules, ordinances or other laws in any jurisdiction which require
                            an original signature or delivery or retention of non-electronic records.</span></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><strong><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>13. General Provisions.</span></strong></p>

                            <p style='margin:0cm;margin-bottom:.0001pt;text-align:justify;background:white;
                            vertical-align:baseline'><span style='font-size:8.5pt;font-family:"inherit",serif;
                            color:#050505'>CDIMS reserves all rights not expressly granted herein. CDIMS
                            may modify this Agreement at any time by providing such revised Agreement to
                            you or posting the revised Agreement on its website </span></p>

                            <p style='margin-top:12.0pt;margin-right:0cm;margin-bottom:12.0pt;margin-left:
                            0cm;text-align:justify;background:white;vertical-align:baseline'><span
                            style='font-size:8.5pt;font-family:"inherit",serif;color:#050505'>YOU EXPRESSLY
                            ACKNOWLEDGE THAT YOU HAVE READ THIS AGREEMENT AND UNDERSTAND THE RIGHTS,
                            OBLIGATIONS, TERMS AND CONDITIONS SET FORTH HEREIN. BY CONTINUING TO INSTALL
                            THE ONLINE COURSE, YOU EXPRESSLY CONSENT TO BE BOUND BY ITS TERMS AND
                            CONDITIONS AND GRANT TO CDIMS THE RIGHTS SET FORTH HEREIN.</span></p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Disagree</button>
                        <button type="submit" class="btn btn-success pull-right" >I Accept</button>
                      </div>
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

<style type="text/css">
    .gst_hide{
        display: none;
    }
</style>


<script type="text/javascript">
$(document).ready(function(){
    /*var formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'INR',
      minimumFractionDigits: 2,
    })
    $('#amount').val(formatter.format($('#amount').val()));
    */
    var rev_chrg="0";
    var gst_state={
        "myrows": [{
            "state_name": "Andaman and Nicobar Islands",
            "tin_number": "35",
            "state_code": "AN"
        }, {
            "state_name": "Andhra Pradesh",
            "tin_number": "28",
            "state_code": "AP"
        }, {
            "state_name": "Andhra Pradesh (New)",
            "tin_number": "37",
            "state_code": "AD"
        }, {
            "state_name": "Arunachal Pradesh",
            "tin_number": "12",
            "state_code": "AR"
        }, {
            "state_name": "Assam",
            "tin_number": "18",
            "state_code": "AS"
        }, {
            "state_name": "Bihar",
            "tin_number": "10",
            "state_code": "BH"
        }, {
            "state_name": "Chandigarh",
            "tin_number": "04",
            "state_code": "CH"
        }, {
            "state_name": "Chattisgarh",
            "tin_number": "22",
            "state_code": "CT"
        }, {
            "state_name": "Dadra and Nagar Haveli",
            "tin_number": "26",
            "state_code": "DN"
        }, {
            "state_name": "Daman and Diu",
            "tin_number": "25",
            "state_code": "DD"
        }, {
            "state_name": "Delhi",
            "tin_number": "07",
            "state_code": "DL"
        }, {
            "state_name": "Goa",
            "tin_number": "30",
            "state_code": "GA"
        }, {
            "state_name": "Gujarat",
            "tin_number": "24",
            "state_code": "GJ"
        }, {
            "state_name": "Haryana",
            "tin_number": "06",
            "state_code": "HR"
        }, {
            "state_name": "Himachal Pradesh",
            "tin_number": "02",
            "state_code": "HP"
        }, {
            "state_name": "Jammu and Kashmir",
            "tin_number": "01",
            "state_code": "JK"
        }, {
            "state_name": "Jharkhand",
            "tin_number": "20",
            "state_code": "JH"
        }, {
            "state_name": "Karnataka",
            "tin_number": "29",
            "state_code": "KA"
        }, {
            "state_name": "Kerala",
            "tin_number": "32",
            "state_code": "KL"
        }, {
            "state_name": "Lakshadweep Islands",
            "tin_number": "31",
            "state_code": "LD"
        }, {
            "state_name": "Madhya Pradesh",
            "tin_number": "23",
            "state_code": "MP"
        }, {
            "state_name": "Maharashtra",
            "tin_number": "27",
            "state_code": "MH"
        }, {
            "state_name": "Manipur",
            "tin_number": "14",
            "state_code": "MN"
        }, {
            "state_name": "Meghalaya",
            "tin_number": "17",
            "state_code": "ME"
        }, {
            "state_name": "Mizoram",
            "tin_number": "15",
            "state_code": "MI"
        }, {
            "state_name": "Nagaland",
            "tin_number": "13",
            "state_code": "NL"
        }, {
            "state_name": "Odisha",
            "tin_number": "21",
            "state_code": "OR"
        }, {
            "state_name": "Pondicherry",
            "tin_number": "34",
            "state_code": "PY"
        }, {
            "state_name": "Punjab",
            "tin_number": "03",
            "state_code": "PB"
        }, {
            "state_name": "Rajasthan",
            "tin_number": "08",
            "state_code": "RJ"
        }, {
            "state_name": "Sikkim",
            "tin_number": "11",
            "state_code": "SK"
        }, {
            "state_name": "Tamil Nadu",
            "tin_number": "33",
            "state_code": "TN"
        }, {
            "state_name": "Telangana",
            "tin_number": "36",
            "state_code": "TS"
        }, {
            "state_name": "Tripura",
            "tin_number": "16",
            "state_code": "TR"
        }, {
            "state_name": "Uttar Pradesh",
            "tin_number": "09",
            "state_code": "UP"
        }, {
            "state_name": "Uttarakhand",
            "tin_number": "05",
            "state_code": "UT"
        }, {
            "state_name": "West Bengal",
            "tin_number": "19",
            "state_code": "WB"
        }]
    };
    $('#reverse_charge').change(function(){       
        if($('#reverse_charge').is(':checked')){
            $('#gst_hide').removeClass('gst_hide');
            $('#gstin').attr('required','required');
            rev_chrg=1;

        }else{
            $('#gst_hide').addClass('gst_hide');
            $('#gst_hide').val('');
            $('#gstin').removeAttr('required','required');  
            rev_chrg=0;          
        }
    });
    $('#ayag').on('change', function(){
        var ayag = $('#ayag').val();
        if(ayag == 'No'){
            // $('#cert_note').show();
            $('#notes ol #cert_note').show();
        }else{
            // $('#cert_note').hide();
            $('#notes ol #cert_note').hide();
        };
    });
    $('#pay_for_olc').click(function(){
        if($('#billing_name').val()==''){
            swal({
                      title: 'Error Message',
                      text: "Billing name is required.",
                      type: 'error'
                });
            return;
        }
        if($('#billing_address').val()==''){
            swal({  
                      title: 'Error Message',
                      text: "Billing address is required.",
                      type: 'error'
                });
            return;
        }
       
        if($('#gstin').val()==''){
            if($('#reverse_charge').is(':checked')){                
                swal({  
                          title: 'Error Message',
                          text: "GSTIN field is required.",
                          type: 'error'
                    });
                return;
            }
        }
        var fd={coupon_code:$('#coupon_code').val(),c_type_hid:$('#c_type_hid').val(),billing_name:$('#billing_name').val(),billing_address:$('#billing_address').val(),gstin:$('#gstin').val(),reverse_charge:rev_chrg};

        $.ajax({
            url: "<?php echo base_url('register/get-coupon-code');?>",
            type: "POST",
            dataType: "json",
            data: fd,
            /*contentType:false,
            processData:false, */
            beforeSend: function(){
                $('#dvLoading').show();
            },
            success: function(json) 
            {            
                if(json.res_code==0){
                    swal({
                          title: 'Error Message',
                          html: json.message,
                          type: 'error'
                    });
                    $('#coupon_code').val('');
                }else if(json.res_code==1){
                    $('#amount').val(( 8000 - json.amount));
                    $("#modal_license").modal("show");
                }    
            },
            complete:function(){
                $('#dvLoading').hide();
            }
        });     
    });
    $('#notes ol #cert_note').hide()
    <?php
        if(!empty($this->input->get('message'))){
            $response=json_decode(base64_decode(urldecode($this->input->get('message'))));
            if(@$response['message'])            
                echo "
                    swal({
                              title: 'Error Message',
                              text: ".@$response['message'].",
                              type: 'error'
                        });
                    $('#coupon_code').val('".@$response['coupon_code']."');
                ";
        }
    ?>
});

</script>