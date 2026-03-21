<?php 
    $login_emp_id = $this->session->userdata('login_emp_id');
    $empData = $this->Base->emp_details_from_emp_code($login_emp_id);
?>





            <!-- ============ Body content start ============= -->
            <div class="main-content" >
                  <div class="separator-breadcrumb border-top"  >
                    <div class="row" >
                          <div class="col-md-0"></div>


                                       <div id="main-wrapper">
                                          <div class="row">
                                                      <?php 
                                                          $this->Hrmodel->hr_total_employee_box(2,'#12AFCB','white');
                                                          $this->Hrmodel->hr_total_employee_staff_box(2,'#12AFCB','white');
                                                          $this->Hrmodel->hr_total_employee_tech_box(2,'#12AFCB','white');
                                                          $this->Hrmodel->hr_total_employee_male_box(2,'#12AFCB','white');
                                                          $this->Hrmodel->hr_total_employee_female_box(2,'#12AFCB','white');
                                                          $this->Hrmodel->hr_total_employee_newjoin_box(2,'#f25656','white');
                                                          $this->Hrmodel->hr_total_employee_resign_box(2,'#E39E9F','white');
                                                      ?>
                                          </div>
                                      </div>
                          </div><!--  Row -->

                          <div class="row">
                                      <?php 
                                          $this->Hrmodel->contract_wise_salary_graph('success','primary','600px','12');  
                                      ?>
                          </div><!--  Row -->

                          <div class="row">
                                      <?php 
                                          //Dept wise
                                          $this->Hrmodel->dept_wise_salary_graph('success','primary','200px','200px');  
                                          $this->Hrmodel->yearly_salary_graph('success','300px','100%','#12AFCB','orange');
                                          $this->Hrmodel->yearly_ot_hours_graph('danger','300px','100%','#12AFCB','orange'); 
                                      ?>
                          </div>

                          <div class="row">
                                      <?php 
                                          //$this->Dashbord->sales_vs_salary_graph('white','300px','100%','#12AFCB','orange'); 
                                          $this->Hrmodel->emp_join_monthly('white','300px','100%','#12AFCB','orange');
                                          $this->Hrmodel->emp_attrition_monthly('white','300px','100%','#12AFCB','orange');
                                      ?>
                          </div>

                         

                  </div> 
            </div><!-- end of main-content -->
      
            
 



   