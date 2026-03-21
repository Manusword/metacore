   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                      
                                        
                                        <div class="col-md-2">
                                            <label>Form Date</label>
                                            <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php if(isset($search_date1)){echo $search_date1;}else{echo date('d-m-Y');}?>" required  >
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label>To Date</label>
                                            <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php if(isset($search_date2)){echo $search_date2;}else{echo date('d-m-Y');}?>" required>
                                        </div>


                                        <div class="col-md-1">
                                            <label>Finish Size</label>
                                            <input type="number" class="form-control" id="finish_size" >
                                        </div>


                                        <div class="col-md-1">
                                                <label>Shift</label>
                                                      <select class="form-control" id="shift">
                                                            <option value=''>Select</option>
                                                            <option>A</option>
                                                            <option>B</option>
                                                            <option>C</option>
                                                      </select>
                                          </div> 


                                          <div class="col-md-1">
                                              <label>Grade</label>
                                                  <select class="form-control"  id="product_grade">
                                                      <option    value="">Select</option>
                                                          <?Php 
                                                            foreach($grade as $c)
                                                            {
                                                              ?>
                                                                <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
                                                              <?php
                                                            }
                                                          ?>		
                                                  </select>
                                        </div>
                                      
                                        
                                        
                                         
                                          <div class="col-md-2">
                                                  <label >Department </label>
                                                    <select class="form-control" id="dept" onChange="fun_get_machine_form_dept_id(this.value,'mc_no','diff_id')">
                                                        <option value="">Select</option>
                                                            <?php 
                                                            foreach($dept as $d)
                                                            {
                                                            ?>
                                                              <option  value="<?php echo $d['department_id'];?>"  ><?php echo $d['name'];?></option>
                                                            <?php 
                                                            }
                                                            ?>
                                                    </select>
                                            </div>

                                            <div class="col-md-2">
                                              <label >M/C No </label>
                                                <select class="form-control" id="mc_no">
                                                    <option value="">Select</option>
                                                    <?php 
                                                      foreach($machine as $m)
                                                      {
                                                       ?><option  value="<?php echo $m['mc_id'];?>"><?php echo $m['name'];?></option><?php 
                                                      }
                                                    ?>
                                                </select>
                                            </div>

                                       
                    
                     <div class="col-md-1">
                        <input type="button" id="log_test_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >In Process Testing List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                  <?php $this->load->view('qc/long/show_table',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/qc_js');?>

                
