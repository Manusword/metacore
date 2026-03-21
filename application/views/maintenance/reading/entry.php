<?php 
   if(isset($search_date)){$entry_date=$this->Base->change_date_dmy($search_date);}else{$entry_date='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Energy Meter Reading</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Meter Reading</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php //if(isset($res2[0]['maint_problem_id']))echo $res2[0]['maint_problem_id'];?>">
                                                                                  
                                            <div class="col-md-12" >
                                                  <label >Date<span style="color:red;" id="product_dis_id"></span></label>
                                                  <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                            </div>
                                            



                                            <?php 
                                                    
                                            foreach($dept as $d)
                                            {
                                                $dname = $d['name'];
                                                if($d['is_main_production'] != 1)
                                                {
                                                    $result_reading='';$result_reading = $this->Maintenancemodel->get_energy_meter_reading_with_date_dept($search_date,$d['department_id']);//for update
                                                    ?>
                                                    <div class="col-md-3" style="margin-top:10px;" >
                                                          <label ><?php echo $d['name'];?></label> 
                                                          <input type="hidden" class="form-control deptclassid"   autocomplete="off" value="<?php echo $d['department_id'];?>" >
                                                          <input type="number" class="form-control deptclassval"   autocomplete="off" value="<?php if(!empty($result_reading) and $result_reading>0){ echo $result_reading;}?>" >
                                                    </div>
                                                    <?php 
                                                }
                                                else
                                                {
                                                        echo '<div class="col-md-12" style="margin-top:10px;" >'.$dname.'<br></div>'; 
                                                        $machine = $this->Machinemodel->fun_get_machine_form_dept_id($d['department_id']);
                                                        foreach($machine as $m)
                                                        {
                                                          $result_reading2='';$result_reading2 = $this->Maintenancemodel->get_energy_meter_reading_with_date_dept_mc($search_date,$d['department_id'],$m['mc_id']);//for update
                                                          ?>
                                                          <div class="col-md-3" style="margin-top:10px;" >
                                                                <label ><?php echo $m['name'];?></label> 
                                                                <input type="hidden" class="form-control machineclassid"   autocomplete="off" value="<?php echo $d['department_id'].','.$m['mc_id'];?>" >
                                                                <input type="number" class="form-control machineclassval"   autocomplete="off" value="<?php if(!empty($result_reading2) and $result_reading2>0){ echo $result_reading2;}?>" >
                                                          </div>
                                                          <?php 
                                                        }//machine

                                                        echo '<div class="col-md-12" style="margin-top:10px;" ><br></div>'; 
                                                    
                                                  }//else
                                                
                                              }//foreach
                                            ?>





                                            
                                          
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="meter_reading_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   




        
   

    

<?php $this->load->view('js/maintenance_js');?>
