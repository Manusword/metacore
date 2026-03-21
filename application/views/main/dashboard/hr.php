<?php 
    $login_emp_id = $this->session->userdata('login_emp_id');
    $empData = $this->Base->emp_details_from_emp_code($login_emp_id);
?>





            <!-- ============ Body content start ============= -->
            <div class="main-content" >
                  <div class="separator-breadcrumb border-top"  >
                    <div class="row" >
                          <div class="col-md-0"></div>


                                      


                                            <div class="col-md-12 mb-4" style="margin-top: 20px;">
                                            <div class="card text-left">
                                                <div class="card-body">
                                                     <?php if($login_emp_id == 1 || $login_emp_id == 790){ ?>
                                                       <h4 class="card-title mb-3">
                                                        
                                                         <a  href="<?php base_url()?>home?Hr/add_other" target="_blank"   class="btn btn-light" >
                                                              New Other Application
                                                          </a>
                                                          <a  href="<?php base_url()?>home?Hr/list_other_application" target="_blank"   class="btn btn-light" >
                                                              Other Application List
                                                          </a>
                                                      </h4>
                                                       <?php } ?>
                            
                                                      <div class="table-responsive">
                                                          <?php 
                                                            $gapDays = "-35";
                                                            $today = date('Y-m-d');
		                                                    $from_date = $this->Base->get_choise_gap_ymd($today,"$gapDays day");

                                                           
                                                            $advacedata = $this->Hrmodel->get_dashboard_advance($gapDays);
                                                            //$this->Hrmodel->get_advance_history_emp_code_table($advacedata,1);
                                                            
                                                            $leavedata = $this->Hrmodel->get_dashboard_leave();
                                                            //$this->Hrmodel->get_leave_history_emp_code_table($leavedata,1);
                                                            $otherdata = $this->Hrmodel->get_dashboard_other_application_with_date("All","All",$from_date,$today);
                                                            $this->Hrmodel->get_dashbord_to_display_all_table($advacedata,$leavedata,$otherdata);

                                                            //show old way
                                                            //$this->Hrmodel->get_dashbord_to_display_all_diff_table_html();
                                                          ?>
                                                      </div>
                                                      
                                                      
                                                </div>
                                            </div>

                                           
                                          

                                         
                                       
                                          <div class="col-md-12 mb-4" style="margin-top: 20px;">
                                             <div class="card text-left" style="margin-top:30px">
                                                <div class="card-body">
                                                  <h4 class="card-title mb-3">Today Absent List</h4>
                                                    <div class="table-responsive">
                                                          <?php $this->Hrmodel->display_absent();?>
                                                      </div>
                                                </div>
                                            </div>
                                          </div>
                                          



                                          <!--  end of col -->



                                           

                                              
                   
                      </div><!--  Row -->
                  </div> 
            </div><!-- end of main-content -->
      
            
 



   