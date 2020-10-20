<!-- Inner Banner Wrapper Start -->
<div class="inner-banner">
  <div class="container">
    <div class="col-sm-12">
      <h2>User History </h2>
    </div>
    <div class="col-sm-12 inner-breadcrumb">
      <ul>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li><a href="<?php echo base_url('user-history');?>">User History</a></li>
        
      </ul>
    </div>
  </div>
</div>
<!-- Inner Banner Wrapper End -->
<section class="inner-wrapper">
  <div class="container">
    <div class="row">
      <div class="inner-wrapper-main">
       
        <div class="col-sm-8">
          <div id="accordion-first" class="clearfix">
            <div class="accordion" id="accordion1"> 
              <h2>Complete user history of <span><?php echo @$user_details['firstname'].' '.@$user_details['lastname'] ?></span></h2>             
              <div class="accordion-group">
                <div class="accordion-heading"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapseTwo"> <em class="icon-fixed-width fa fa-plus"></em>Basic  </a> </div>
                <div style="height: 0px;" id="collapseTwo" class="accordion-body collapse">
                  <div class="accordion-inner">
                  <table class="table table-responsive table-bordered">
                    <tr>
                      <td><strong>Name </strong></td>
                      <td><?php echo @$user_details['firstname'].' '.@$user_details['lastname'] ?></td>                    
                      <td><strong>Gender</strong></td>
                      <td><?php echo @$user_details['customfields']['gender'];?></td>
                    </tr>
                    <tr>
                      <td><strong>Email </strong></td>
                      <td><?php echo @$user_details['email']; ?></td>                    
                      <td><strong>Phone</strong></td>
                      <td><?php echo @$user_details['phone1'];?></td>
                    </tr>
                    <tr>
                      <td><strong>Date Of Birth </strong></td>
                      <td><?php echo @$user_details['dateofbirth']; ?></td>                    
                      <td><strong>City</strong></td>
                      <td><?php echo @$user_details['city'];?></td>
                    </tr>
                    <tr>                                         
                      <td><strong>State</strong></td>
                      <td><?php echo @$user_details['state_name'];?></td>
                      <td><strong>Country </strong></td>
                      <td><?php echo @$user_details['country_name'];?></td> 
                    </tr>
                  </table>
                  
                  </div>
                </div>
              </div>
              <div class="accordion-group">
                <div class="accordion-heading"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapseThree"> <em class="icon-fixed-width fa fa-plus"></em>Education </a> </div>
                <div style="height: 0px;" id="collapseThree" class="accordion-body collapse">
                  <div class="accordion-inner"> 
                    <table class="table table-responsive table-bordered">
                      <tr>
                        <td><strong>University </strong></td>
                        <td><?php echo @$user_details['customfields']['university']; ?></td>                    
                        <td><strong>City</strong></td>
                        <td><?php echo @$user_details['customfields']['universitycity'];?></td>
                      </tr>
                      <tr>
                        <td><strong>Year of passing </strong></td>
                        <td><?php echo @$user_details['customfields']['yearofpassing']; ?></td>                    
                        <td><strong>Passing Grade (In percentage)</strong></td>
                        <td><?php echo @$user_details['customfields']['passinggrade'];?></td>
                      </tr>                      
                    </table>
                  </div>
                </div>
              </div>
              <div class="accordion-group">
                <div class="accordion-heading"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapseFour"> <em class="icon-fixed-width fa fa-plus"></em>Professional  </a> </div>
                <div style="height: 0px;" id="collapseFour" class="accordion-body collapse">
                  <div class="accordion-inner"> 
                    <table class="table table-responsive table-bordered">
                      <tr>
                        <td><strong>Organization </strong></td>
                        <td><?php echo @$user_details['customfields']['organisation']; ?></td>                    
                        <td><strong>Experience</strong></td>
                        <td><?php echo @$user_details['customfields']['sinceyears'];?></td>
                      </tr>
                      <tr>
                        <td><strong>Designation </strong></td>
                        <td><?php echo @$user_details['customfields']['designation']; ?></td>                    
                        <td><strong>Work Profile</strong></td>
                        <td><?php echo @$user_details['customfields']['workprofile'];?></td>
                      </tr> 
                      <tr>
                        <td ><strong> Other Certifications/Degrees  </strong></td>
                        <td colspan="3"><?php echo @$user_details['customfields']['othereducation']; ?></td>                    
                        
                      </tr> 
                                         
                    </table>
                  </div>
                </div>
              </div>              
              <div class="accordion-group">
                <div class="accordion-heading"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#c6"> <em class="icon-fixed-width fa fa-plus"></em>Documents uploaded  </a> </div>
                <div style="height: 0px;" id="c6" class="accordion-body collapse">
                  <div class="accordion-inner"> 
                    <table class="table table-responsive table-bordered">
                      <tr>
                        <td><strong>Birth Certificate </strong></td>
                        <td>
                          <?php 
                            if(!empty(@$user_details['docpath']['docbc'])){
                              echo "
                                <a target='_blank' href='".base_url($user_details['docfilepaths']['docbc'].$user_details['docpath']['docbc'])."'>View</a>
                              ";
                            }else{
                              echo "-";
                            }

                          ?>
                        </td>                    
                        <td><strong>Address Proof</strong></td>
                        <td>
                          <?php 
                            if(!empty(@$user_details['docpath']['docaddr'])){
                              echo "
                                <a target='_blank' href='".base_url($user_details['docfilepaths']['docaddr'].$user_details['docpath']['docaddr'])."'>View</a>
                              ";
                            }else{
                              echo "-";
                            }

                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Graduation certificate </strong></td>
                        <td>
                          <?php 
                            if(!empty(@$user_details['docpath']['docgrad'])){
                              echo "
                                <a target='_blank' href='".base_url($user_details['docfilepaths']['docgrad'].$user_details['docpath']['docgrad'])."'>View</a>
                              ";
                            }else{
                              echo "-";
                            }

                          ?>
                        </td>                    
                        <td><strong>Name Change certificate</strong></td>
                        <td>
                          <?php 
                            if(!empty(@$user_details['docpath']['docnamechng'])){
                              echo "
                                <a target='_blank' href='".base_url($user_details['docfilepaths']['docnamechng'].$user_details['docpath']['docnamechng'])."'>View</a>
                              ";
                            }else{
                              echo "-";
                            }

                          ?>
                        </td>
                      </tr>                                                                
                    </table>        
                  </div>
                </div>
              </div>
              <div class="accordion-group">
                <div class="accordion-heading"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#c7"> <em class="icon-fixed-width fa fa-plus"></em>Quiz     </a> </div>
                <div style="height: 0px;" id="c7" class="accordion-body collapse">
                  <div class="accordion-inner"> 
                    <table class="table table-responsive table-bordered">
                      <tr>
                        
                        <th>Module Name</th>
                        <th>Attempts</th>
                        <th>grade</th>
                      </tr>
                      <?php 
                        foreach ($user_details['get_quiz'] as $value) {
                          echo "
                            <tr>
                             
                              <td>".$value['name']."</td>
                              <td>".$value['attempts']."</td>
                              <td>".round($value['grade'],2)."</td>
                            </tr>
                          ";
                        }
                      ?>                                   
                    </table>
                  </div>
                </div>
              </div>
              <div class="accordion-group">
                <div class="accordion-heading"> <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#c8"> <em class="icon-fixed-width fa fa-plus"></em>Rating   </a> </div>
                <div style="height: 0px;" id="c8" class="accordion-body collapse">
                  <div class="accordion-inner">
                    <table class="table table-responsive table-bordered">
                      <tr>
                        
                        <th>Module Name</th>
                        <th>*</th>
                        <th>**</th>
                        <th>***</th>
                        <th>****</th>
                        <th>*****</th>
                      </tr>
                      <?php 
                        foreach ($user_details['get_rating'] as $value) {
                          echo "
                            <tr>                             
                              <td>".$value['name']."</td>
                              <td>".$value['1_Rating']."</td>
                              <td>".$value['2_Rating']."</td>
                              <td>".$value['3_Rating']."</td>
                              <td>".$value['4_Rating']."</td>
                              <td>".$value['5_Rating']."</td>                              
                            </tr>
                          ";
                        }
                      ?>                                   
                    </table>
                  </div>
                </div>
              </div>              
                                                   
            </div>
            <!-- end accordion -->
          </div>
        </div>
        
        <div class="col-sm-4">
          
          <div class="row">
            <div class="download-services">
              <img width="300" style="width: 300px;" src="<?php echo @$user_details['profilepicture']?>" alt="<?php echo @$user_details['firstname']?>"/>
            
            </div>
          </div>
          <div class="row">&nbsp;</div>
          <div class="row">
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
