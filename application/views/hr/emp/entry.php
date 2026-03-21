        

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>New Employee</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" style="color:<?php echo $this->Company->table_bg_color();?>;" >Basic Details  
                                <span style="color:red" id="warningMsg"></span>
                              </div>
                                   
                                    <div class="form-row">
                                      
    
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                                                          
                                              
                                            <?php 
                                              if(isset($res2[0]['doj']) and $res2[0]['doj']!='0000-00-00'){$test = new DateTime($res2[0]['doj']);$doj= date_format($test, 'd-m-Y');}else{$doj='';}
                                              if(isset($res2[0]['dob']) and $res2[0]['dob']!='0000-00-00'){$test = new DateTime($res2[0]['dob']);$dob= date_format($test, 'd-m-Y');}else{$dob='';}
                                              if(isset($res2[0]['dor']) and $res2[0]['dor']!='0000-00-00'){$test = new DateTime($res2[0]['dor']);$dor= date_format($test, 'd-m-Y');}else{$dor='';}
                                              
                                              if(isset($res2[0]['last_promotion_date']) and $res2[0]['last_promotion_date']!='0000-00-00'){$test = new DateTime($res2[0]['last_promotion_date']);$last_promotion_date= date_format($test, 'd-m-Y');}else{$last_promotion_date='';}
                                              
                                              if(isset($res2[0]['trainee_probation_date']) and $res2[0]['trainee_probation_date']!='0000-00-00'){$test = new DateTime($res2[0]['trainee_probation_date']);$trainee_probation_date= date_format($test, 'd-m-Y');}else{$trainee_probation_date='';}
                                              
                                              if(isset($res2[0]['due_conf_date']) and $res2[0]['due_conf_date']!='0000-00-00'){$test = new DateTime($res2[0]['due_conf_date']);$due_conf_date= date_format($test, 'd-m-Y');}else{$due_conf_date='';}
                                              
                                              if(isset($res2[0]['actual_conf_date']) and $res2[0]['actual_conf_date']!='0000-00-00'){$test = new DateTime($res2[0]['actual_conf_date']);$actual_conf_date= date_format($test, 'd-m-Y');}else{$actual_conf_date='';}
                                              
                                              if(isset($res2[0]['increment_due_date']) and $res2[0]['increment_due_date']!='0000-00-00'){$test = new DateTime($res2[0]['increment_due_date']);$increment_due_date= date_format($test, 'd-m-Y');}else{$increment_due_date='';}
                                              
                                              if(isset($res2[0]['date_of_transfer']) and $res2[0]['date_of_transfer']!='0000-00-00'){$test = new DateTime($res2[0]['date_of_transfer']);$date_of_transfer= date_format($test, 'd-m-Y');}else{$date_of_transfer='';}
                                              
                                              if(isset($res2[0]['date_of_leave']) and $res2[0]['date_of_leave']!='0000-00-00'){$test = new DateTime($res2[0]['date_of_leave']);$date_of_leave= date_format($test, 'd-m-Y');}else{$date_of_leave='';} 
                                              if(isset($res2[0]['fater_dob']) and $res2[0]['fater_dob']!='0000-00-00'){$test = new DateTime($res2[0]['fater_dob']);$fater_dob= date_format($test, 'd-m-Y');}else{$fater_dob='';}
                                              if(isset($res2[0]['mother_dob']) and $res2[0]['mother_dob']!='0000-00-00'){$test = new DateTime($res2[0]['mother_dob']);$mother_dob= date_format($test, 'd-m-Y');}else{$mother_dob='';}
                                              if(isset($res2[0]['spouse_no']) and $res2[0]['spouse_no']!='0000-00-00'){$test = new DateTime($res2[0]['spouse_no']);$spouse_no= date_format($test, 'd-m-Y');}else{$spouse_no='';}
                                              if(isset($res2[0]['date_of_marriage']) and $res2[0]['date_of_marriage']!='0000-00-00'){$test = new DateTime($res2[0]['date_of_marriage']);$date_of_marriage= date_format($test, 'd-m-Y');}else{$date_of_marriage='';}
                                              if(isset($res2[0]['child_dob1']) and $res2[0]['child_dob1']!='0000-00-00'){$test = new DateTime($res2[0]['child_dob1']);$child_dob1= date_format($test, 'd-m-Y');}else{$child_dob1='';}
                                              if(isset($res2[0]['child_dob2']) and $res2[0]['child_dob2']!='0000-00-00'){$test = new DateTime($res2[0]['child_dob2']);$child_dob2= date_format($test, 'd-m-Y');}else{$child_dob2='';}
                                              if(isset($res2[0]['child_dob3']) and $res2[0]['child_dob3']!='0000-00-00'){$test = new DateTime($res2[0]['child_dob3']);$child_dob3= date_format($test, 'd-m-Y');}else{$child_dob3='';}
                                              if(isset($res2[0]['child_dob4']) and $res2[0]['child_dob4']!='0000-00-00'){$test = new DateTime($res2[0]['child_dob4']);$child_dob4= date_format($test, 'd-m-Y');}else{$child_dob4='';}
                                              
                                              if(isset($res2[0]['doj_master_roll']) and $res2[0]['doj_master_roll']!='0000-00-00'){$test = new DateTime($res2[0]['doj_master_roll']);$doj_master_roll= date_format($test, 'd-m-Y');}else{$doj_master_roll='';}
                                              if(isset($res2[0]['dor_master_roll']) and $res2[0]['dor_master_roll']!='0000-00-00'){$test = new DateTime($res2[0]['dor_master_roll']);$dor_master_roll= date_format($test, 'd-m-Y');}else{$dor_master_roll='';}
                                            ?> 

                                            <div class="col-md-2">
                                                <label>Payroll Unit</label>
                                                <select class="form-control"  id="company_role" onchange="getNextEmpcode(this.value)">
                                                  <?php 
                                                   if(isset($res2[0]['company_role'])){}else{
                                                    echo '<option value="">Select</option>';
                                                   }
                                                 
                                                      foreach($company_role as $c)
                                                      {
                                                           if(isset($res2[0]['company_role'])){
                                                            if($res2[0]['company_role']!=$c['name']){ continue;}
                                                           }
                                                        ?>
                                                          <option <?php if(isset($res2[0]['company_role'])){if($res2[0]['company_role']==$c['name']){echo "selected";}}?> value="<?php echo $c['name'];?>" >
                                                              <?php echo $c['name'];?>
                                                          </option>
                                                        <?php
                                                      }
                                                    ?>	
                                                </select>
                                            </div> 

                                             <div class="col-md-2">
                                                <label >Working Units</label>
                                                <select class="form-control"  id="plant" >
                                                    <option value="">Select</option>
                                                    <?Php 
                                                      foreach($company_role as $c)
                                                      {
                                                        ?>
                                                          <option <?php if(isset($res2[0]['plant'])){if($res2[0]['plant']==$c['name']){echo "selected";}}?> value="<?php echo $c['name'];?>" >
                                                              <?php echo $c['name'];?>
                                                          </option>
                                                        <?php
                                                      }
                                                    ?>	
                                                </select>
                                            </div> 
 
                                          
                          
                                            <div class="col-md-2">
                                                  <label >Employee Code</label> <span id="emp_dis" style="color:<?php echo $this->Company->table_bg_color();?>;"></span>
                                                  <input type="text" class="form-control"  id="emp_code" required  autocomplete="off" value="<?php if(isset($res2[0]['emp_code'])){echo $res2[0]['emp_code'];}?>" <?php if(isset($res2[0]['emp_code'])){ echo "disabled";}?>  onKeyUp="fun_check_emp_code(this.value)" >
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group" >
                                                  <label >Bio Id Code</label> <span id="bio_dis" style="color:<?php echo $this->Company->table_bg_color();?>;"></span>
                                                  <input type="text" class="form-control"  id="bio_code"   autocomplete="off" value="<?php if(isset($res2[0]['bio_code']))echo $res2[0]['bio_code'];?>" onKeyUp="fun_check_bio_code(this.value)" >
                                                </div>
                                            </div>
                                            
                                           
                
                                            <div class="col-md-2">
                                              <div class="form-group" >
                                                <label >Full Name</label>
                                                <input type="text" class="form-control"  id="first_name" required  autocomplete="off" value="<?php if(isset($res2[0]['first_name']))echo $res2[0]['first_name'];?>"  >
                                                <input type="hidden" class="form-control"  id="last_name" required  autocomplete="off" value="<?php if(isset($res2[0]['last_name']))echo $res2[0]['last_name'];?>"  >
                                              </div>
                                            </div>

                                        
                                            <div class="col-md-2">
                                              <div class="form-group">
                                                  <label >Gender</label>
                                                      <select class="form-control"  id="gender">
                                                            <option  <?php if(isset($res2[0]['gender'])){if($res2[0]['gender']=='Male'){echo "selected";}};?>  value="Male">Male</option>
                                                            <option <?php if(isset($res2[0]['gender'])){if($res2[0]['gender']=='Female'){echo "selected";}};?>  value="Female">Female</option>
                                                            <option <?php if(isset($res2[0]['gender'])){if($res2[0]['gender']=='Other'){echo "selected";}};?> value="Other">Other</option>
                                                      </select>
                                                </div>
                                            </div>   
                
                                            <div class="col-md-2">
                                                <div class="form-group" >
                                                  <label >Mobile No</label>
                                                  <input type="text" class="form-control"    id="telphone" required autocomplete="off" value="<?php if(isset($res2[0]['mob']))echo $res2[0]['mob'];?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <div class="form-group" >
                                                  <label >Email </label> <span id="email_dis" style="color:<?php echo $this->Company->table_bg_color();?>;"></span>
                                                  <input type="email" class="form-control"    id="email"  autocomplete="off" value="<?php if(isset($res2[0]['email']))echo $res2[0]['email'];?>" onKeyUp="fun_check_email(this.value)">
                                                </div>
                                            </div>
                
                                            <div class="col-md-2">
                                                <div class="form-group" >
                                                  <label >Date Of Join</label>
                                                  <input type="text" class="form-control" id="doj" placeholder="DD-MM-YYYY" required autocomplete="off" value="<?php echo $doj;?>">
                                                </div>
                                            </div>
                
                                            <div class="col-md-2">
                                                <div class="form-group" >
                                                  <label >D.O.B </label>
                                                  <input type="text" class="form-control" id="dob" placeholder="DD-MM-YYYY" required autocomplete="off" value="<?php  echo $dob;?>">
                                                </div>
                                            </div>
                
                                            <div class="col-md-2">
                                                <div class="form-group" >
                                                  <label >D.O.R</label>
                                                  <input type="text" class="form-control" id="dor" placeholder="DD-MM-YYYY" required autocomplete="off" value="<?php  echo $dor;?>">
                                                </div>
                                            </div>
                
                                            <div class="col-md-2">
                                                <div class="form-group" >
                                                  <label >Age</label>
                                                  <input type="text" class="form-control" id="age"  autocomplete="off" value="<?php if(isset($res2[0]['age']))echo $res2[0]['age'];?>">
                                                </div>
                                            </div>
               
                                            <div class="col-md-2">
                                              <div class="form-group" >
                                                <label >Blood Group</label>
                                                <input type="text" class="form-control"  id="blood_group" required  autocomplete="off" value="<?php  if(isset($res2[0]['blood_group']))echo $res2[0]['blood_group'];?>">
                                              </div>
                                            </div>
   
                                            <div class="col-md-12">
                                              <div class="panel-heading clearfix">
                                                  <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Qualification And Exp. Details</h4>
                                              </div>
                                            </div>
   
                                    <div class="col-md-4">
                                        <div class="form-group" >
                                          <label >Qualification</label>
                                          <textarea class="form-control"  id="quli" required  autocomplete="off" ><?php  if(isset($res2[0]['quli']))echo $res2[0]['quli'];?></textarea>
                                        </div>
                                    </div>


                                  <div class="col-md-4">
                                        <div class="form-group" >
                                          <label >Additional Qualification</label>
                                          <textarea class="form-control"  id="add_quli" required  autocomplete="off" ><?php  if(isset($res2[0]['add_quli']))echo $res2[0]['add_quli'];?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group" >
                                          <label >Last Organisation Served With Location</label>
                                          <textarea class="form-control"  id="last_org" required  autocomplete="off" ><?php  if(isset($res2[0]['last_org']))echo $res2[0]['last_org'];?></textarea>
                                        </div>
                                    </div>
                                    
                                  
                                          
                                    
                                    <div class="col-md-4">
                                        <div class="form-group" >
                                          <label >Past EXP.</label>
                                          <input type="text" class="form-control"   id="past_exp" required  autocomplete="off" value="<?php if(isset($res2[0]['past_exp']))echo $res2[0]['past_exp'];?>">
                                        </div>
                                    </div>
                                    
                                      <div class="col-md-4">
                                        <div class="form-group" >
                                          <label >Pres. EXP.</label>
                                          <input type="number" class="form-control" id="pres_exp"  autocomplete="off" value="<?php  if(isset($res2[0]['pres_exp']))echo $res2[0]['pres_exp'];?>">
                                        </div>
                                    </div>
                                    
                                  
                                <div class="col-md-4">
                                        <div class="form-group" >
                                          <label >Total EXP.</label>
                                          <input type="number" class="form-control" id="total_exp"  autocomplete="off" value="<?php  if(isset($res2[0]['total_exp']))echo $res2[0]['total_exp'];?>">
                                        </div>
                                    </div>











                                    <div class="col-md-12">
                                      <div class="panel-heading clearfix">
                                          <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Company Profile</h4>
                                      </div>
                                    </div>
                                                        

                                    <div class="col-md-2">
                                      <div class="form-group">
                                          <label >Joining Desigantion</label>
                                              <select class="form-control"   id="join_desig">
                                                    <option value="">Select</option>
                                                      <?Php 
                                                        foreach($role as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['join_desig'])){if($res2[0]['join_desig']==$c['role_id']){echo "selected";}}?> value="<?php echo $c['role_id'];?>" >
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>		
                                              </select>
                                        </div>
                                      </div> 
                                      
                                      
                                      <div class="col-md-2">
                                      <div class="form-group">
                                          <label >Current Desigantion</label>
                                              <select class="form-control"   id="current_desig">
                                                    <option  value="">Select</option>
                                                      <?Php 
                                                        foreach($role as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['role_in_department'])){if($res2[0]['role_in_department']==$c['role_id']){echo "selected";}}?> value="<?php echo $c['role_id'];?>" >
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>		
                                              </select>
                                        </div>
                                      </div> 
                              
                                          
                                        
                                    
                                      <div class="col-md-2">
                                      <div class="form-group">
                                          <label >Select Main Department</label>
                                              <select class="form-control"   id="dept">
                                                    <option  <?php if(isset($res2[0]['department_id'])){if($res2[0]['department_id']==''){echo "selected";}}?>  value="">Select</option>
                                                      <?Php 
                                                        foreach($dept as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['department_id'])){if($res2[0]['department_id']==$c['department_id']){echo "selected";}}?> value="<?php echo $c['department_id'];?>" >
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>		
                                              </select>
                                        </div>
                                      </div> 




                                      <div class="col-md-2">
                                      <div class="form-group">
                                          <label >Select Sub Department</label>
                                              <select class="form-control"   id="sub_dept">
                                                    <option  <?php if(isset($res2[0]['sub_department_id'])){if($res2[0]['sub_department_id']==''){echo "selected";}}?>  value="">Select</option>
                                                      <?Php 
                                                        foreach($dept as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['sub_department_id'])){if($res2[0]['sub_department_id']==$c['department_id']){echo "selected";}}?> value="<?php echo $c['department_id'];?>" >
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>		
                                              </select>
                                        </div>
                                      </div> 

                                     
                                      <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Team</label>
                                          <input type="text" class="form-control"  id="emp_team" required  autocomplete="off" value="<?php  if(isset($res2[0]['emp_team']))echo $res2[0]['emp_team'];?>">
                                        </div>
                                    </div>
                                              
                                  
                                      <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Status - HOD / Other</label>
                                          <select class="form-control"  id="hod_status">
                                                <option value="">Select</option>
                                                    <option <?php if(isset($res2[0]['hod_status'])){if($res2[0]['hod_status']=='HOD'){echo "selected";}};?>  value="HOD">HOD</option>
                                                    <option <?php if(isset($res2[0]['hod_status'])){if($res2[0]['hod_status']=='OTHER'){echo "selected";}};?>  value="OTHER">OTHER</option>
                                              </select>  
                                        </div>
                                    </div>
                                    
                                    

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Sub Category  (Staff / Tech)</label>
                                          <select class="form-control"  id="staff_tech">
                                              <option value="">Select</option>
                                                    <option <?php if(isset($res2[0]['staff_tech'])){if($res2[0]['staff_tech']=='Staff'){echo "selected";}};?>  value="Staff">Staff</option>
                                                    <option <?php if(isset($res2[0]['staff_tech'])){if($res2[0]['staff_tech']=='Tech'){echo "selected";}};?>  value="Tech">Tech</option>
                                              </select>  
                                        </div>
                                    </div>

                                

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Job Responsibility</label>
                                          <input type="text" class="form-control"  id="job_respons" required  autocomplete="off" value="<?php  if(isset($res2[0]['job_respons']))echo $res2[0]['job_respons'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Payroll Area</label>
                                          <input type="text" class="form-control"  id="payroll_area" required  autocomplete="off" value="<?php  if(isset($res2[0]['payroll_area']))echo $res2[0]['payroll_area'];?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Join Grade</label>
                                          <input type="text" class="form-control"  id="join_grade" required  autocomplete="off" value="<?php  if(isset($res2[0]['join_grade']))echo $res2[0]['join_grade'];?>">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Current Grade</label>
                                          <input type="text" class="form-control"  id="current_grade" required  autocomplete="off" value="<?php  if(isset($res2[0]['current_grade']))echo $res2[0]['current_grade'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Date of Last Promotion</label>
                                          <input type="text" class="form-control"  id="last_promotion_date" placeholder="DD-MM-YYYY" required  autocomplete="off" value="<?php   echo $last_promotion_date;?>">
                                        </div>
                                    </div>


                              
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Performance Ranking Last Year</label>
                                          <input type="text" class="form-control"  id="perfor_ranking" readonly  autocomplete="off" value="<?php  if(isset($res2[0]['perfor_ranking']))echo $res2[0]['perfor_ranking'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Last INC.(Rs.)</label>
                                          <input type="text" class="form-control"  id="inc_rs" readonly  autocomplete="off" value="<?php  if(isset($res2[0]['inc_rs']))echo $res2[0]['inc_rs'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                      <div class="panel-heading clearfix">
                                          <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Payment Details</h4>
                                      </div>
                                    </div>
                                                        

                                  
                              
                                    

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >BASIC</label>
                                          <input type="number" class="form-control"  id="basic_salary" required  autocomplete="off" value="<?php  if(isset($res2[0]['basic_salary']))echo $res2[0]['basic_salary'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >HRA</label>
                                          <input type="number" class="form-control"  id="hra" required  autocomplete="off" value="<?php  if(isset($res2[0]['hra']))echo $res2[0]['hra'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >CONV</label>
                                          <input type="number" class="form-control"  id="conv" required  autocomplete="off" value="<?php  if(isset($res2[0]['conv']))echo $res2[0]['conv'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >City Comp. Allow</label>
                                          <input type="number" class="form-control"  id="city_comp" required  autocomplete="off" value="<?php  if(isset($res2[0]['city_comp']))echo $res2[0]['city_comp'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                              
                                                  
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >OTHER ALLOW.</label>
                                          <input type="number" class="form-control"  id="other_allow" required  autocomplete="off" value="<?php  if(isset($res2[0]['other_allow']))echo $res2[0]['other_allow'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                                
                                                          
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >SPL. PAY</label>
                                          <input type="number" class="form-control"  id="spl_pay" required  autocomplete="off" value="<?php  if(isset($res2[0]['spl_pay']))echo $res2[0]['spl_pay'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                            
                                            
                                            
                                            
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >MEDI REM.</label>
                                          <input type="number" class="form-control"  id="medi_rem" required  autocomplete="off" value="<?php  if(isset($res2[0]['medi_rem']))echo $res2[0]['medi_rem'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label ><!--Fuel Reimbursement-->Arrear</label>
                                          <input type="number" class="form-control"  id="fuel_reimb" required  autocomplete="off" value="<?php  if(isset($res2[0]['fuel_reimb']))echo $res2[0]['fuel_reimb'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >ALL (Full) Attendance</label>
                                          <input type="number" class="form-control"  id="get_attendance_all" required  autocomplete="off" value="<?php  if(isset($res2[0]['get_attendance_all']))echo $res2[0]['get_attendance_all'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >EL Encashment</label>
                                          <input type="number" class="form-control"  id="get_el_encashment" required  autocomplete="off" value="<?php  if(isset($res2[0]['get_el_encashment']))echo $res2[0]['get_el_encashment'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >CL Encashment</label>
                                          <input type="number" class="form-control"  id="get_cl_encashment" required  autocomplete="off" value="<?php  if(isset($res2[0]['get_cl_encashment']))echo $res2[0]['get_cl_encashment'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Other 1</label>
                                          <input type="number" class="form-control"  id="get_other1" required  autocomplete="off" value="<?php  if(isset($res2[0]['get_other1']))echo $res2[0]['get_other1'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Other 2</label>
                                          <input type="number" class="form-control"  id="get_other2" required  autocomplete="off" value="<?php  if(isset($res2[0]['get_other2']))echo $res2[0]['get_other2'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Other 3</label>
                                          <input type="number" class="form-control"  id="get_other3" required  autocomplete="off" value="<?php  if(isset($res2[0]['get_other3']))echo $res2[0]['get_other3'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Other 4</label>
                                          <input type="number" class="form-control"  id="get_other4" required  autocomplete="off" value="<?php  if(isset($res2[0]['get_other4']))echo $res2[0]['get_other4'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>

                                   


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Gross Total At Joining (A)</label>
                                          <input type="number" class="form-control"  id="ctc_at_join" required  autocomplete="off" value="<?php  if(isset($res2[0]['ctc_at_join']))echo $res2[0]['ctc_at_join'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Current Gross Total  (B)</label>
                                          <input type="number" class="form-control"  id="current_ctc" required  autocomplete="off" value="<?php  if(isset($res2[0]['current_ctc']))echo $res2[0]['current_ctc'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Total Rise Rs (B-A)</label>
                                          <input type="number" class="form-control"  id="total_rise_rs" required  autocomplete="off" value="<?php  if(isset($res2[0]['total_rise_rs']))echo $res2[0]['total_rise_rs'];?>">
                                        </div>
                                    </div>




                                  

                                    


                                    <div class="col-md-12">
                                        <div class="form-group" >
                                          <label ><b>Deduction</b></label>
                                          <input type="hidden" class="form-control"  id="ctc_on_probation" required  autocomplete="off" value="<?php  if(isset($res2[0]['ctc_on_probation']))echo $res2[0]['ctc_on_probation'];?>" onkeyup="fun_cal_salary()">
                                          <input type="hidden" class="form-control"  id="trainee_probn_ctc" required  autocomplete="off" value="<?php  if(isset($res2[0]['trainee_probn_ctc']))echo $res2[0]['trainee_probn_ctc'];?>" onkeyup="fun_cal_salary()">
                                      </div>
                                    </div> 

                                    <div class="col-md-1">
                                        <div class="form-group" >
                                          <label >ESIC Deduction</label>
                                          <select class="form-control"  id="esic_ded" onchange="fun_esi(this.value)">
                                              <option value="">Select</option>
                                                    <option <?php if(isset($res2[0]['esic_ded'])){if($res2[0]['esic_ded']=='Yes'){echo "selected";}};?> >Yes</option>
                                                    <option <?php if(isset($res2[0]['esic_ded'])){if($res2[0]['esic_ded']=='No'){echo "selected";}};?>  >No</option>
                                              </select>  
                                        </div>
                                    </div>  
                                    

                                    <div class="col-md-1">
                                        <div class="form-group" >
                                          <label  >ESIC (%)</label>
                                          <input type="number" class="form-control"   id="esic" required  autocomplete="off" value="<?php  if(isset($res2[0]['esic']))echo $res2[0]['esic'];?>">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group" >
                                          <label >E.P.F. Deduction</label>
                                          <select class="form-control"  id="pf_ded" onchange="fun_pf(this.value)">
                                              <option value="">Select</option>
                                                    <option <?php if(isset($res2[0]['pf_ded'])){if($res2[0]['pf_ded']=='Yes'){echo "selected";}};?> >Yes</option>
                                                    <option <?php if(isset($res2[0]['pf_ded'])){if($res2[0]['pf_ded']=='No'){echo "selected";}};?>  >No</option>
                                              </select>  
                                        </div>
                                    </div> 
                                            
                                            
                                    <div class="col-md-1">
                                        <div class="form-group" >
                                          <label >E.P.F. (%)</label>
                                          <input type="number" class="form-control"  id="epf" required  autocomplete="off" value="<?php  if(isset($res2[0]['epf']))echo $res2[0]['epf'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label  >Canteen</label>
                                          <input type="number" class="form-control"   id="lost_canteen" required  autocomplete="off" value="<?php  if(isset($res2[0]['lost_canteen']))echo $res2[0]['lost_canteen'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label  title="(lost_breakfast">Break Fast</label>
                                          <input type="number" class="form-control" title="lost_breakfast"  id="lost_breakfast" required  autocomplete="off" value="<?php  if(isset($res2[0]['lost_breakfast']))echo $res2[0]['lost_breakfast'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label  >BUS</label>
                                          <input type="number" class="form-control"   id="lost_bus" required  autocomplete="off" value="<?php  if(isset($res2[0]['lost_bus']))echo $res2[0]['lost_bus'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label  >Advance</label>
                                          <input type="number" class="form-control" readonly   id="lost_advance" required  autocomplete="off" value="<?php  if(isset($res2[0]['lost_advance']))echo $res2[0]['lost_advance'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >BONUS</label>
                                          <input type="number" class="form-control"  id="bonus" required  autocomplete="off" value="<?php  if(isset($res2[0]['bonus']))echo $res2[0]['bonus'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >EX-GRATIA</label>
                                          <input type="number" class="form-control"  id="ex_gratia" required  autocomplete="off" value="<?php  if(isset($res2[0]['ex_gratia']))echo $res2[0]['ex_gratia'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Deduction Other 1</label>
                                          <input type="number" class="form-control"  id="lost_1" readonly  autocomplete="off" value="<?php  if(isset($res2[0]['lost_1']))echo $res2[0]['lost_1'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Deduction Other 2</label>
                                          <input type="number" class="form-control"  id="lost_2" readonly  autocomplete="off" value="<?php  if(isset($res2[0]['lost_2']))echo $res2[0]['lost_2'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Deduction Other 3</label>
                                          <input type="number" class="form-control"  id="lost_3" readonly  autocomplete="off" value="<?php  if(isset($res2[0]['lost_3']))echo $res2[0]['lost_3'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Deduction Other 4</label>
                                          <input type="number" class="form-control"  id="lost_4" readonly  autocomplete="off" value="<?php  if(isset($res2[0]['lost_4']))echo $res2[0]['lost_4'];?>" onkeyup="fun_cal_salary()">
                                        </div>
                                    </div>
                                    
                                  
                                            
                                    <input type="hidden" class="form-control"  id="old_ex_gratia" required  autocomplete="off" value="<?php  if(isset($res2[0]['old_ex_gratia']))echo $res2[0]['old_ex_gratia'];?>">
                                      
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >CTC</label>
                                          <input type="number" class="form-control"  id="current_total_ctc"  required  autocomplete="off" value="<?php  if(isset($res2[0]['current_total_ctc']))echo $res2[0]['current_total_ctc'];?>">
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                      <div class="panel-heading clearfix">
                                          <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Other Details</h4>
                                      </div>
                                    </div>
                                  
                              

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Working  Hrs (Without OT Hours)</label>
                                          <input type="text" class="form-control"  id="working_hr" required  autocomplete="off" value="<?php  if(isset($res2[0]['working_hr']))echo $res2[0]['working_hr'];?>">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label >Shift Status</label>
                                                <select class="form-control"  id="shift_status">
                                                  <option value="">Select</option>
                                                <option  <?php if(isset($res2[0]['shift_status'])){if($res2[0]['shift_status']=='In Shift'){echo "selected";}};?>  >In Shift</option>
                                                <option <?php if(isset($res2[0]['shift_status'])){if($res2[0]['shift_status']=='General'){echo "selected";}};?>  >General</option>
                                                </select>
                                          </div>
                                    </div>   
                                              

                                    
                                    <div class="col-md-2">
                                          <div class="form-group">
                                              <label >Current Shift</label>
                                                  <select class="form-control"  id="current_shift">
                                                    <option value="">Select</option>
                                                  <?Php 
                                                      foreach($shifts as $s)
                                                      {
                                                        ?>
                                                          <option <?php if(isset($res2[0]['current_shift'])){if($res2[0]['current_shift']==$s['shift_code']){echo "selected";}}?> value="<?php echo $s['shift_code'];?>" >
                                                              <?php echo $s['shift_code'].', '.$s['in_time'].'-'.$s['out_time_ot'];?>
                                                          </option>
                                                        <?php
                                                      }
                                                    ?>	
                                                  </select>
                                            </div>
                                      </div>   
                                    
                                    
                                    
                                    <div class="col-md-2">
                                          <div class="form-group">
                                              <label >Get Overtime</label>
                                                  <select class="form-control"  id="get_overtime">
                                                  <option value="">Select</option>
                                                  <option  <?php if(isset($res2[0]['get_overtime'])){if($res2[0]['get_overtime']=='No'){echo "selected";}};?>  >No</option>
                                                  <option <?php if(isset($res2[0]['get_overtime'])){if($res2[0]['get_overtime']=='Yes'){echo "selected";}};?>  >Yes</option>
                                                  </select>
                                            </div>
                                      </div>   

                                      <div class="col-md-2">
                                          <div class="form-group">
                                              <label >Rest Day</label>
                                                  <select id="restday" class="form-control">
                                                    <option value="">Select</option>
                                                        <option <?php if(isset($res2[0]['restday'])){if($res2[0]['restday']=='Sun'){echo "selected";}};?>>Sun</option>
                                                        <option <?php if(isset($res2[0]['restday'])){if($res2[0]['restday']=='Mon'){echo "selected";}};?>>Mon</option>
                                                        <option <?php if(isset($res2[0]['restday'])){if($res2[0]['restday']=='Tue'){echo "selected";}};?>>Tue</option>
                                                        <option <?php if(isset($res2[0]['restday'])){if($res2[0]['restday']=='Wed'){echo "selected";}};?>>Wed</option>
                                                        <option <?php if(isset($res2[0]['restday'])){if($res2[0]['restday']=='Thu'){echo "selected";}};?>>Thu</option>
                                                        <option <?php if(isset($res2[0]['restday'])){if($res2[0]['restday']=='Fri'){echo "selected";}};?>>Fri</option>
                                                        <option <?php if(isset($res2[0]['restday'])){if($res2[0]['restday']=='Sat'){echo "selected";}};?>>Sat</option>
                                                  </select>
                                            </div>
                                      </div>   
                                    

                                     <div class="col-md-2">
                                          <div class="form-group">
                                              <label>Late Punch Add(Day's)</label>
                                                  <select class="form-control"  id="late_punch_add">
                                                  <option value="">Select</option>
                                                  <option  <?php if(isset($res2[0]['late_punch_add'])){if($res2[0]['late_punch_add']=='No'){echo "selected";}};?>  >No</option>
                                                  <option <?php if(isset($res2[0]['late_punch_add'])){if($res2[0]['late_punch_add']=='Yes'){echo "selected";}};?>  >Yes</option>
                                                  </select>
                                            </div>
                                      </div> 

                                       <div class="col-md-2">
                                          <div class="form-group">
                                              <label>On Daily Wages ?</label>
                                                  <select class="form-control"  id="on_daily_wages">
                                                  <option value="">Select</option>
                                                  <option  <?php if(isset($res2[0]['on_daily_wages'])){if($res2[0]['on_daily_wages']=='No'){echo "selected";}};?>  >No</option>
                                                  <option <?php if(isset($res2[0]['on_daily_wages'])){if($res2[0]['on_daily_wages']=='Yes'){echo "selected";}};?>  >Yes</option>
                                                  </select>
                                            </div>
                                      </div> 

                                      <div class="col-md-2">
                                        <div class="form-group" >
                                          <label > Daily Wages Rs/Day</label>
                                          <input type="number" class="form-control"  id="daily_wages_rs" required  autocomplete="off" value="<?php  if(isset($res2[0]['daily_wages_rs']))echo $res2[0]['daily_wages_rs'];?>">
                                        </div>
                                      </div>

                                    


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Trainee Probation Date</label>
                                          <input type="text" class="form-control"  id="trainee_probation_date" placeholder="DD-MM-YYYY" required  autocomplete="off" value="<?php   echo $trainee_probation_date;?>">
                                        </div>
                                    </div>
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Due Conf Date</label>
                                          <input type="text" class="form-control"  id="due_conf_date" placeholder="DD-MM-YYYY" required  autocomplete="off" value="<?php   echo $due_conf_date;?>">
                                        </div>
                                    </div>
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Actual Conf Date</label>
                                          <input type="text" class="form-control"  id="actual_conf_date" placeholder="DD-MM-YYYY" required  autocomplete="off" value="<?php   echo $actual_conf_date;?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Increment Due Date</label>
                                          <input type="text" class="form-control"  id="increment_due_date" placeholder="DD-MM-YYYY" required  autocomplete="off" value="<?php   echo $increment_due_date;?>">
                                        </div>
                                    </div>
                                            
                                              
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Increment Amount</label>
                                          <input type="number" class="form-control"  id="increment_due_month" required  autocomplete="off" value="<?php  if(isset($res2[0]['increment_due_month']))echo $res2[0]['increment_due_month'];?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Date Of Transfer, IF ANY</label>
                                          <input type="text" class="form-control"  id="date_of_transfer" placeholder="DD-MM-YYYY" required  autocomplete="off" value="<?php  echo $date_of_transfer;?>">
                                        </div>
                                    </div>
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Plant Name Transfered From</label>
                                          <input type="text" class="form-control"  id="plan_name_tranfer" required  autocomplete="off" value="<?php  if(isset($res2[0]['plan_name_tranfer']))echo $res2[0]['plan_name_tranfer'];?>">
                                        </div>
                                    </div>

                                

                                    
                                    <div class="col-md-12">
                                      <div class="panel-heading clearfix">
                                          <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Doucument & ID</h4>
                                      </div>
                                    </div>
                                                        

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >UAN</label>
                                          <input type="text" class="form-control"  id="emp_uan" required  autocomplete="off" value="<?php  if(isset($res2[0]['emp_uan']))echo $res2[0]['emp_uan'];?>">
                                        </div>
                                    </div>
                              
                                    

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >EPF Code</label>
                                          <input type="text" class="form-control"  id="epf_code" required  autocomplete="off" value="<?php  if(isset($res2[0]['epf_code']))echo $res2[0]['epf_code'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >ESI Code</label>
                                          <input type="text" class="form-control"  id="esi_code" required  autocomplete="off" value="<?php  if(isset($res2[0]['esi_code']))echo $res2[0]['esi_code'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >PAN Number</label>
                                          <input type="text" class="form-control"  id="pan_no" required  autocomplete="off" value="<?php  if(isset($res2[0]['pan_no']))echo $res2[0]['pan_no'];?>">
                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Aadhar Number</label>
                                          <input type="text" class="form-control"  id="aadhar_no" required  autocomplete="off" value="<?php  if(isset($res2[0]['aadhar_no']))echo $res2[0]['aadhar_no'];?>">
                                        </div>
                                    </div>
                              
                                                  
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Voter ID Number</label>
                                          <input type="text" class="form-control"  id="voter_id" required  autocomplete="off" value="<?php  if(isset($res2[0]['voter_id']))echo $res2[0]['voter_id'];?>">
                                        </div>
                                    </div>
                                                
                                                          
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Bank Name</label>
                                          <input type="text" class="form-control"  id="bank_name" required  autocomplete="off" value="<?php  if(isset($res2[0]['bank_name']))echo $res2[0]['bank_name'];?>">
                                        </div>
                                    </div>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Bank Account Number</label>
                                          <input type="text" class="form-control"  id="bank_account_no" required  autocomplete="off" value="<?php  if(isset($res2[0]['bank_account_no']))echo $res2[0]['bank_account_no'];?>">
                                        </div>
                                    </div>
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >IFSC Code</label>
                                          <input type="text" class="form-control"  id="co_mob_no" required  autocomplete="off" value="<?php  if(isset($res2[0]['co_mob_no']))echo $res2[0]['co_mob_no'];?>">
                                        </div>
                                    </div>
                                  
                                            
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Personal Contact Number 2</label>
                                          <input type="text" class="form-control"  id="personal_no2" required  autocomplete="off" value="<?php  if(isset($res2[0]['personal_no2']))echo $res2[0]['personal_no2'];?>">
                                        </div>
                                    </div>
                                    
                                    
                                    
                                              
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Nominee Name</label>
                                          <input type="text" class="form-control"  id="nominee_name" required  autocomplete="off" value="<?php  if(isset($res2[0]['nominee_name']))echo $res2[0]['nominee_name'];?>">
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Nominee Relation</label>
                                          <input type="text" class="form-control"  id="nominee_rel" required  autocomplete="off" value="<?php  if(isset($res2[0]['nominee_rel']))echo $res2[0]['nominee_rel'];?>">
                                        </div>
                                    </div>
                                    


                                    <div class="col-md-12">
                                      <div class="panel-heading clearfix">
                                          <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Address & Family Details</h4>
                                      </div>
                                    </div>
                                                        

                                                            
                                    
                        
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                          <label >Present Address</label>
                                        <textarea class="form-control"  id="present_address"   autocomplete="off"><?php if(isset($res2[0]['present_address']))echo $res2[0]['present_address'];?></textarea>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-6">
                                        <div class="form-group" >
                                          <label >Permanent Address</label>
                                        <textarea class="form-control"  id="permanent_address"   autocomplete="off"><?php if(isset($res2[0]['permanent_address']))echo $res2[0]['permanent_address'];?></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Home Town Contact Number</label>
                                          <input type="text" class="form-control"   id="home_town_no" required  autocomplete="off" value="<?php if(isset($res2[0]['home_town_no']))echo $res2[0]['home_town_no'];?>">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label > PIN Code Permanent Address</label>
                                          <input type="text" class="form-control"   id="pin_code_permanet" required  autocomplete="off" value="<?php if(isset($res2[0]['pin_code_permanet']))echo $res2[0]['pin_code_permanet'];?>">
                                        </div>
                                    </div>
                                    
                                  
                                  
                                  
                                                          
                                                
                                    
                                    
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >State Permanent Address</label>
                                          <input type="text" class="form-control"    id="state_par_address" required  autocomplete="off" value="<?php if(isset($res2[0]['state_par_address']))echo $res2[0]['state_par_address'];?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Cast Category</label>
                                          <select class="form-control"  id="emp_cast_category">
                                              <option value="">Select</option>
                                                    <option <?php if(isset($res2[0]['emp_cast_category'])){if($res2[0]['emp_cast_category']=='General'){echo "selected";}};?>  value="General">General</option>
                                                    <option <?php if(isset($res2[0]['emp_cast_category'])){if($res2[0]['emp_cast_category']=='OBC'){echo "selected";}};?>  value="OBC">OBC</option>
                                                    <option <?php if(isset($res2[0]['emp_cast_category'])){if($res2[0]['emp_cast_category']=='SC'){echo "selected";}};?>  value="SC">SC</option>
                                                    <option <?php if(isset($res2[0]['emp_cast_category'])){if($res2[0]['emp_cast_category']=='ST'){echo "selected";}};?>  value="ST">ST</option>
                                                    <option <?php if(isset($res2[0]['emp_cast_category'])){if($res2[0]['emp_cast_category']=='Other'){echo "selected";}};?>  value="Other">Other</option>
                                                    <option <?php if(isset($res2[0]['emp_cast_category'])){if($res2[0]['emp_cast_category']=='NA'){echo "selected";}};?>  value="NA">NA</option>
                                              </select>  
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Father's Name</label>
                                          <input type="text" class="form-control"    id="father_name"  autocomplete="off" value="<?php  if(isset($res2[0]['father_name']))echo $res2[0]['father_name'];?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Father'S DOB</label>
                                          <input type="text" class="form-control"    id="fater_dob"  placeholder="DD-MM-YYYY"   autocomplete="off" value="<?php   echo $fater_dob;?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Mother's Name</label>
                                          <input type="text" class="form-control"    id="mother_name"  autocomplete="off" value="<?php  if(isset($res2[0]['mother_name']))echo $res2[0]['mother_name'];?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Mother DOB</label>
                                          <input type="text" class="form-control"    id="mother_dob"   placeholder="DD-MM-YYYY"  autocomplete="off" value="<?php   echo $mother_dob;?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Marrige</label>
                                          <select class="form-control"  id="emp_marrige_status">
                                              <option value="">Select</option>
                                                    <option <?php if(isset($res2[0]['emp_marrige_status'])){if($res2[0]['emp_marrige_status']=='Married'){echo "selected";}};?>  value="Married">Married</option>
                                                    <option <?php if(isset($res2[0]['emp_marrige_status'])){if($res2[0]['emp_marrige_status']=='Unmarried'){echo "selected";}};?>  value="Unmarried">Unmarried</option> 
                                                    <option <?php if(isset($res2[0]['emp_marrige_status'])){if($res2[0]['emp_marrige_status']=='Divorced'){echo "selected";}};?>  value="Divorced">Divorced</option>
                                                    <option <?php if(isset($res2[0]['emp_marrige_status'])){if($res2[0]['emp_marrige_status']=='Widowed'){echo "selected";}};?>  value="Widowed">Widowed</option>
                                                    <option <?php if(isset($res2[0]['emp_marrige_status'])){if($res2[0]['emp_marrige_status']=='Separated'){echo "selected";}};?>  value="Separated">Separated</option>
                                                    <option <?php if(isset($res2[0]['emp_marrige_status'])){if($res2[0]['emp_marrige_status']=='NA'){echo "selected";}};?>  value="NA">NA</option>
                                                    <option <?php if(isset($res2[0]['emp_marrige_status'])){if($res2[0]['emp_marrige_status']=='Other'){echo "selected";}};?>  value="Other">Other</option>
                                            </select>  
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Spouse Name</label>
                                          <input type="text" class="form-control"    id="spouse_name"  autocomplete="off" value="<?php  if(isset($res2[0]['spouse_name']))echo $res2[0]['spouse_name'];?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Spouse DOB</label>
                                          <input type="text" class="form-control"    id="spouse_no" placeholder="DD-MM-YYYY"  autocomplete="off" value="<?php   echo $spouse_no;?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Date Of Marriage</label>
                                          <input type="text" class="form-control"    id="date_of_marriage" placeholder="DD-MM-YYYY"  autocomplete="off" value="<?php   echo $date_of_marriage;?>">
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-1 NAME</label>
                                          <input type="text" class="form-control"    id="child_name1"  autocomplete="off" value="<?php  if(isset($res2[0]['child_name1']))echo $res2[0]['child_name1'];?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-1 Gender</label>
                                          <select class="form-control"  id="child_gender1">
                                                <option <?php if(isset($res2[0]['child_gender1'])){if($res2[0]['child_gender1']=='Male'){echo "selected";}};?>  value="Male">Male</option>
                                                <option <?php if(isset($res2[0]['child_gender1'])){if($res2[0]['child_gender1']=='Female'){echo "selected";}};?>  value="Female">Female</option>
                                          </select>  
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-1 DOB</label>
                                          <input type="text" class="form-control"    id="child_dob1" placeholder="DD-MM-YYYY"  autocomplete="off" value="<?php   echo $child_dob1;?>">
                                        </div>
                                    </div>
                                    


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-2 NAME</label>
                                          <input type="text" class="form-control"    id="child_name2"  autocomplete="off" value="<?php  if(isset($res2[0]['child_name2']))echo $res2[0]['child_name2'];?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-2 Gender</label>
                                          <select class="form-control"  id="child_gender2">
                                            <option <?php if(isset($res2[0]['child_gender2'])){if($res2[0]['child_gender2']=='Male'){echo "selected";}};?>  value="Male">Male</option>
                                            <option <?php if(isset($res2[0]['child_gender2'])){if($res2[0]['child_gender2']=='Female'){echo "selected";}};?>  value="Female">Female</option>
                                          </select>  
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-2 DOB</label>
                                          <input type="text" class="form-control"    id="child_dob2" placeholder="DD-MM-YYYY"  autocomplete="off" value="<?php  echo $child_dob2;?>">
                                        </div>
                                    </div>
                                  
                              
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-3 NAME</label>
                                          <input type="text" class="form-control"    id="child_name3"  autocomplete="off" value="<?php  if(isset($res2[0]['child_name3']))echo $res2[0]['child_name3'];?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-3 Gender</label>
                                          <select class="form-control"  id="child_gender3">
                                                      <option <?php if(isset($res2[0]['child_gender3'])){if($res2[0]['child_gender3']=='Male'){echo "selected";}};?>  value="Male">Male</option>
                                                    <option <?php if(isset($res2[0]['child_gender3'])){if($res2[0]['child_gender3']=='Female'){echo "selected";}};?>  value="Female">Female</option>
                                              </select>  
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-3 DOB</label>
                                          <input type="text" class="form-control"    id="child_dob3" placeholder="DD-MM-YYYY"  autocomplete="off" value="<?php   echo $child_dob3;?>">
                                        </div>
                                    </div>
                              
                              
                              
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-4 NAME</label>
                                          <input type="text" class="form-control"    id="child_name4"  autocomplete="off" value="<?php  if(isset($res2[0]['child_name4']))echo $res2[0]['child_name4'];?>">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-4 Gender</label>
                                            <select class="form-control"  id="child_gender4">
                                              <option <?php if(isset($res2[0]['child_gender4'])){if($res2[0]['child_gender4']=='Male'){echo "selected";}};?>  value="Male">Male</option>
                                              <option <?php if(isset($res2[0]['child_gender4'])){if($res2[0]['child_gender4']=='Female'){echo "selected";}};?>  value="Female">Female</option>
                                            </select>                    
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Child-4 DOB</label>
                                          <input type="text" class="form-control"    id="child_dob4"  placeholder="DD-MM-YYYY" autocomplete="off" value="<?php   echo $child_dob4;?>">
                                        </div>
                                    </div>

                                    
                                    
                                    <div class="col-md-12" style="margin-top:50px;">
                                          <div class="panel-heading clearfix">
                                              <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Master Roll</h4>
                                          </div>
                                      </div>


                                      <div class="col-md-2">
                                          <div class="form-group" >
                                            <label >Display in Master Roll</label>
                                            <select class="form-control"  id="mater_roll">
                                                <option value="">Select</option>
                                                      <option <?php if(isset($res2[0]['mater_roll'])){if($res2[0]['mater_roll']=='Yes'){echo "selected";}};?> >Yes</option>
                                                      <option <?php if(isset($res2[0]['mater_roll'])){if($res2[0]['mater_roll']=='No'){echo "selected";}};?>  >No</option>
                                                </select>  
                                          </div>
                                      </div> 


                                       <div class="col-md-2">
                                          <div class="form-group" >
                                            <label >BASIC Master Roll</label>
                                            <input type="number" class="form-control"  id="basic_salary_master_roll" required  autocomplete="off" value="<?php  if(isset($res2[0]['basic_salary_master_roll']))echo $res2[0]['basic_salary_master_roll'];?>">
                                          </div>
                                      </div>


                                      <div class="col-md-2">
                                          <div class="form-group" >
                                            <label >HRA Master Roll</label>
                                            <input type="number" class="form-control"  id="hra_master_roll" required  autocomplete="off" value="<?php  if(isset($res2[0]['hra_master_roll']))echo $res2[0]['hra_master_roll'];?>">
                                          </div>
                                      </div>


                                      <div class="col-md-2">
                                          <div class="form-group" >
                                            <label >CONV Master Roll</label>
                                            <input type="number" class="form-control"  id="conv_master_roll" required  autocomplete="off" value="<?php  if(isset($res2[0]['conv_master_roll']))echo $res2[0]['conv_master_roll'];?>">
                                          </div>
                                      </div>

                                      <div class="col-md-2">
                                          <div class="form-group" >
                                            <label  >Advance Deduction Master Roll</label>
                                            <input type="number" class="form-control"   id="lost_advance_master_roll" required  autocomplete="off" value="<?php  if(isset($res2[0]['lost_advance_master_roll']))echo $res2[0]['lost_advance_master_roll'];?>" readonly>
                                          </div>
                                      </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label  >Other Deduction. Master Roll</label>
                                          <input type="number" class="form-control"   id="other_advance_master_roll" required  autocomplete="off" value="<?php  if(isset($res2[0]['other_advance_master_roll']))echo $res2[0]['other_advance_master_roll'];?>" readonly>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >Date Of Join</label>
                                          <input type="text" class="form-control" id="doj_master_roll" placeholder="DD-MM-YYYY" required autocomplete="off" value="<?php echo $doj_master_roll;?>">
                                        </div>
                                    </div>
        
                                    <div class="col-md-2">
                                        <div class="form-group" >
                                          <label >D.O.R</label>
                                          <input type="text" class="form-control" id="dor_master_roll" placeholder="DD-MM-YYYY" required autocomplete="off" value="<?php  echo $dor_master_roll;?>">
                                        </div>
                                    </div>
                    









                                      <div class="col-md-12" style="margin-top:50px;">
                                          <div class="panel-heading clearfix">
                                              <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Current Status</h4>
                                          </div>
                                      </div>
                                                              
                                
                          
                                        <div class="col-md-2">
                                            <div class="form-group" >
                                              <label for="exampleInputEmail1">Draft Entry</label>
                                              <select class="form-control" id="draft_entry">
                                                <option  <?php if(isset($res2[0]['draft_entry'])){if($res2[0]['draft_entry']=='1'){echo "selected";}}?> value="1">Yes</option>
                                                <option  <?php  if(isset($res2[0]['draft_entry'])){if($res2[0]['draft_entry']=='0'){echo "selected";}}?>  value="0">No</option>
                                              </select>
                                            </div>
                                        </div>
                          
                          
                                        <div class="col-md-2">
                                            <div class="form-group" >
                                              <label for="exampleInputEmail1">Active / Deactive</label>
                                              <select class="form-control" id="active">
                                                  <option  <?php  if(isset($res2[0]['active'])){if($res2[0]['active']=='Active'){echo "selected";}}?>  value="Active">Active</option>
                                                  <option  <?php if(isset($res2[0]['active'])){if($res2[0]['active']=='Deactive'){echo "selected";}}?> value="Deactive">Deactive</option>
                                                  <option  <?php if(isset($res2[0]['active'])){if($res2[0]['active']=='Pending'){echo "selected";}}?> value="Pending">Pending</option>
                                                  <option  <?php if(isset($res2[0]['active'])){if($res2[0]['active']=='Banned'){echo "selected";}}?> value="Banned">Banned</option>
                                              </select>
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group" >
                                              <label for="exampleInputEmail1">Attendance Entry Yes / No</label>
                                              <select class="form-control" id="attendance_entry">
                                                  <option  <?php  if(isset($res2[0]['attendance_entry'])){if($res2[0]['attendance_entry']=='0'){echo "selected";}}?>  value="0">Yes</option>
                                                  <option  <?php if(isset($res2[0]['attendance_entry'])){if($res2[0]['attendance_entry']=='1'){echo "selected";}}?> value="1">No</option>
                                              </select>
                                            </div>
                                        </div>

                                       <div class="col-md-6">
                                          <div class="form-group">
                                              <label>Asset Issue List</label>
                                              <div class="d-flex flex-wrap gap-3">

                                                  <?php 
                                                  $selectedAssets = [];

                                                  if (!empty($res2[0]['asset_issue'])) {
                                                      $selectedAssets = array_map('trim', explode(',', $res2[0]['asset_issue']));
                                                  }
                                                  $assetList = $this->Base->get_all_hr_asset_list();

                                                  if(!empty($assetList)){
                                                      foreach($assetList as $key => $asset){

                                                          $checked = in_array($asset, $selectedAssets) ? 'checked' : '';
                                                  ?>
                                                          <div class="form-check form-check-inline">
                                                              <input 
                                                                  class="form-check-input" 
                                                                  type="checkbox" 
                                                                  name="asset_issue[]" 
                                                                  id="asset_<?= $key ?>" 
                                                                  value="<?= htmlspecialchars($asset) ?>"
                                                                  <?= $checked ?>
                                                              >
                                                              <label class="form-check-label" for="asset_<?= $key ?>">
                                                                  <?= htmlspecialchars($asset) ?>
                                                              </label>
                                                          </div>
                                                  <?php 
                                                      }
                                                  } else {
                                                      echo '<span class="text-danger">No assets found</span>';
                                                  }
                                                  ?>

                                              </div>
                                          </div>
                                      </div>




                                       
                                        <div class="col-md-12" style="margin-top:50px;">
                                          <div class="panel-heading clearfix">
                                              <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Login Details</h4>
                                          </div>
                                        </div>


                                        
                                        <div class="col-md-2">
                                            <div class="form-group" >
                                              <label >Login Status</label>
                                              <select class="form-control" id="status">
                                                <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Deactive'){echo "selected";}}?> value="Deactive">Deactive</option>
                                                  <option  <?php  if(isset($res2[0]['status'])){if($res2[0]['status']=='Active'){echo "selected";}}?>  value="Active">Active</option>
                                                  
                                              </select>
                                            </div>
                                        </div>

                                         <div class="col-md-2">
                                            <div class="form-group" >
                                              <label >Login Location</label>
                                              <select class="form-control" id="login_from_other_ip">
                                                  <option  <?php  if(isset($res2[0]['login_from_other_ip'])){if($res2[0]['login_from_other_ip']=='0'){echo "selected";}}?>  value="0">Only From Company</option>
                                                  <option  <?php if(isset($res2[0]['login_from_other_ip'])){if($res2[0]['login_from_other_ip']=='1'){echo "selected";}}?> value="1">Everywhere</option>
                                              </select>
                                            </div>
                                        </div>

                                        
                                       
                                       
                                  <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="new_emp_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   

                                           
<script>
function getNextEmpcode(company_role) {

    if (!company_role) return;

    $.post(
        "<?= base_url('index.php/Hr/get_next_emp_code') ?>",
        { company_role: company_role },
        function (res) {

            // If jQuery doesn't auto-parse JSON
            if (typeof res === 'string') {
                try {
                    res = JSON.parse(res);
                } catch (e) {
                    console.error('Invalid JSON:', res);
                    return;
                }
            }

            // Set emp code
            if (res.emp_code !== undefined) {
                $('#emp_code').val(res.emp_code);
                fun_check_emp_code(res.emp_code);
            }

            // Show warning if exists
            if (res.warning) {
                $('#warningMsg')
                    .text("Warning : " + res.warning)
                    .show();
            } else {
                $('#warningMsg')
                    .text('')
                    .hide();
            }

            // Optional: handle hard errors
            if (res.error) {
                $('#warningMsg')
                    .text(res.error)
                    .show();
                $('#emp_code').val('');
            }

           
        }
    );
}

</script>

<script>
  function fun_esi(val){
    if(val=='Yes'){
      document.getElementById('esic').value = '0.75';
    }
    else{
      document.getElementById('esic').value = '';
    }
  }
  function fun_pf(val){
    if(val=='Yes'){
      document.getElementById('epf').value = '12';
    }
    else{
      document.getElementById('epf').value = '';
    }
  }


  function fun_cal_salary(){
    //var basic_salary = document.getElementById('basic_salary').value;
    
    // var hra = (basic_salary*20)/100;
    // document.getElementById('hra').value = hra.toFixed(2);
    
    // var conv = (basic_salary*10)/100;
    // document.getElementById('conv').value = conv.toFixed(2);
    
    // var city_comp = (basic_salary*5)/100;
    // document.getElementById('city_comp').value = city_comp.toFixed(2);

    let basic_salary = (+document.getElementById('basic_salary').value);
    let hra = (+document.getElementById('hra').value);
    let conv = (+document.getElementById('conv').value);
    let city_comp = (+document.getElementById('city_comp').value);
    let other_allow = (+document.getElementById('other_allow').value);
    let spl_pay = (+document.getElementById('spl_pay').value);
    let medi_rem = (+document.getElementById('medi_rem').value);
    
    let fuel_reimb = (+document.getElementById('fuel_reimb').value);
    let get_attendance_all = (+document.getElementById('get_attendance_all').value);
    let get_el_encashment = (+document.getElementById('get_el_encashment').value);

    let get_cl_encashment = (+document.getElementById('get_cl_encashment').value);
    let get_other1 = (+document.getElementById('get_other1').value);
    let get_other2 = (+document.getElementById('get_other2').value);
    let get_other3 = (+document.getElementById('get_other3').value);
    let get_other4 = (+document.getElementById('get_other4').value);

    let total_ctc = basic_salary + hra + conv + city_comp + other_allow + spl_pay + medi_rem + fuel_reimb + get_attendance_all + get_el_encashment + get_cl_encashment + get_other1 + get_other2 + get_other3 + get_other4;
    document.getElementById('current_ctc').value = total_ctc.toFixed(0);
    
    let ctc_at_join = (+document.getElementById('ctc_at_join').value);
    let inc_salary = total_ctc - ctc_at_join;
    document.getElementById('total_rise_rs').value = inc_salary.toFixed(0);

    //deduction
    let ctc_on_probation = (+document.getElementById('ctc_on_probation').value);
    let trainee_probn_ctc = (+document.getElementById('trainee_probn_ctc').value);
    let lost_canteen = (+document.getElementById('lost_canteen').value);

    let lost_breakfast = (+document.getElementById('lost_breakfast').value);
    let lost_bus = (+document.getElementById('lost_bus').value);
    let lost_advance = (+document.getElementById('lost_advance').value);

    let bonus = (+document.getElementById('bonus').value);
    let ex_gratia = (+document.getElementById('ex_gratia').value);
    let lost_1 = (+document.getElementById('lost_1').value);
    let lost_2 = (+document.getElementById('lost_2').value);
    let lost_3 = (+document.getElementById('lost_3').value);
    let lost_4 = (+document.getElementById('lost_4').value);

    let total_deduction = ctc_on_probation + trainee_probn_ctc + lost_canteen + lost_breakfast + lost_bus + lost_advance + bonus + ex_gratia + lost_1 + lost_2 + lost_3 + lost_4;
    let current_total_ctc = total_ctc - total_deduction;
    document.getElementById('current_total_ctc').value = current_total_ctc.toFixed(0);

  }
</script>

<?php $this->load->view('js/hr_js');?>


