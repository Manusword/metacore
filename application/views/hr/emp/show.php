         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                                        
                                        <?php
                                            $this->Hrmodel->all_unit_filter();//payroll units filter
                                        ?>
                                        
                                        <div class="col-md-1">
                                            <label >Emp code</label>
                                            <input type="text" class="form-control"  id="emp_id1"  >
                                        </div> 

                                         <div class="col-md-1">
                                            <label >Bio code</label>
                                            <input type="text" class="form-control"  id="bio_id1"  >
                                        </div> 
                                        
                                        <div class="col-md-1">
                                            <label >Name</label>
                                            <input type="text" class="form-control"  id="name1"  >
                                        </div> 
                                        
                                       
                                        <div class="col-md-1" >
                                            <label >Dept.</label>
                                            <select class="form-control" id="dept1" >
                                            	<option value="">All</option>
                                               <?php 
											   	foreach($dept as $d)
												{
											   		?>
                                               			<option <?php if(!empty($def_dept)){if($d['department_id']==$def_dept){ echo "selected";}}?>  value="<?php echo $d['department_id'];?>"><?php echo $d['name'];?></option>
                                               		<?php 
											   	}
											   ?>
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <label >DOJ</label>
                                            <input type="month" class="form-control"  id="doj1"  >
                                        </div> 

                                        <div class="col-md-1">
                                            <label >DOR</label>
                                            <input type="month" class="form-control"  id="dor1"  >
                                        </div> 
                                        
                                        
                                        
                                         <div class="col-md-1" >
                                           <label >Mater Rroll</label>
                                            <select class="form-control"  id="mater_roll1"  >
                                            	<option value="">All</option>
                                                <option>Yes</option>
                                				<option>No</option>
                                			</select>
                                        </div>
                                        
                                       
                                        <div class="col-md-1" >
                                           <label >Active</label>
                                            <select class="form-control"  id="active1"  >
                                            	<option value="">All</option>
                                                <option selected>Active</option>
                                				<option>Deactive</option>
                                			 </select>
                                        </div>

                                        <div class="col-md-1" >
                                           <label >Reports</label>
                                            <select class="form-control"  id="report_type1"  >
                                            	<option value='1'>Basic</option>
                                                <option  value='2'>Payment</option>
                                                <option value='6'>Assets</option>
                                				<option  value='3'>Doucument</option>
                                                <option  value='8'>Latter</option>
                                                <option  value='4'>Address & Family</option>
                                                <option value='7'>Login Status</option>
                                                <option  value='5'>Master Roll</option>
                                                <option  value='9'>Epf Members</option>
                                                <option  value='11'>Leave List</option>
                                                <option  value='10'>Draft List</option>
                                            </select>
                                        </div>
                                       
                    
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="emp_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Employee List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('hr/emp/show_table',$res2);?></div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/hr_js');?>
 
