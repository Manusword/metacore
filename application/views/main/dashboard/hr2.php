<?php 
    $login_emp_id = $this->session->userdata('login_emp_id');
    $empData = $this->Base->emp_details_from_emp_code($login_emp_id);
?>





            <!-- ============ Body content start ============= -->
            <div class="main-content" >
                
                    
                  
                            <div class="row" >
                                <?php 
                                
                                    $this->Hrmodel->hr_total_employee_box(2,'#12AFCB','white');
                                    $this->Hrmodel->hr_total_employee_staff_box(2,'#12AFCB','white');
                                    $this->Hrmodel->hr_total_employee_tech_box(2,'#12AFCB','white');
                                    $this->Hrmodel->hr_total_employee_male_box(2,'#12AFCB','white');
                                    $this->Hrmodel->hr_total_employee_female_box(2,'#12AFCB','white');
                                    $this->Hrmodel->hr_total_employee_newjoin_box(2,'#f25656','white');
                                    $this->Hrmodel->hr_total_employee_resign_box(2,'#E39E9F','white');
                                    $this->Hrmodel->hr_total_deactive_employee_box(2,'#E39E9F','white');
                                ?>
                                         
                            </div><!--  Row -->

                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <?php 
                                                $this->Hrmodel->contract_wise_salary_graph('success','primary','600px','12');  
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           

                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <?php 
                                                 $this->Hrmodel->yearly_salary_graph('success','300px','100%','#12AFCB','orange');
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <?php 
                                                $this->Hrmodel->yearly_ot_hours_graph('danger','300px','100%','#12AFCB','orange'); 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <?php 
                                                $this->Hrmodel->emp_join_monthly('white','300px','100%','#12AFCB','orange');
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <?php 
                                                $this->Hrmodel->emp_attrition_monthly('white','300px','100%','#12AFCB','orange');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <?php 
                                                $this->Hrmodel->dept_wise_salary_graph('success','primary','200px','200px');
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                          



                 
            </div><!-- end of main-content -->
      
            
 



   