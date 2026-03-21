   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                        <div class="col-md-1">
                                            <label>Form Start Date</label>
                                            <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php echo date('01-m-Y')?>" required  >
                                        </div>
                                        
                                        <div class="col-md-1">
                                            <label>To Start Date</label>
                                            <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php if(isset($search_date2)){echo $search_date2;}else{echo $this->Base->change_date_dmy($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),'+10'));}?>" required>
                                        </div>
                                        
                                        <div class="col-md-1">
                                            <label >Department </label>
                                            <select class="form-control" id="dept" onChange="fun_get_machine_form_dept_id(this.value,'mc_no','diff_id')">
                                                <option value="">Select</option>
                                                    <?php 
                                                    foreach($dept as $d)
                                                    {
                                                    ?>
                                                        <option value="<?php echo $d['department_id'];?>"  ><?php echo $d['name'];?></option>
                                                    <?php 
                                                    }
                                                    ?>
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <label  >M/C</label>
                                            <select class="form-control" id="mc_no" >
                                                <option value="">Select</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1" >
                                            <label  >Inlet Grade</label>
                                            <select class="form-control" id="grade">
                                                <option value="">Select</option>
                                                <?php 
                                                foreach($grade as $u)
                                                {
                                                    ?>
                                                    <option  value="<?php echo $u['id'];?>" ><?php echo $u['name'];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-1" >
                                            <label>Inlet Size</label>
                                            <input type="text"    class="form-control"   id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','diff_id_one_search')"  />
                                            <input type="hidden"  class="goods"   id="goods_"   />
                                        </div>
                                        
                                        <div class="col-md-1" >
                                            <label>Outlet Size</label>
                                            <input type="text"    class="form-control"   id="goods31_" onKeyUp="fun_get_product(this.id,'goods31_','goods32_','diff_id_one_search')"   />
                                            <input type="hidden"  class="goods"   id="goods32_"   />
                                        </div>
                                       

                                        

                                       

                                        <div class="col-md-1" >
                                            <label  >Outlet Grade</label>
                                            <select class="form-control" id="product_type">
                                                <option value="">Select</option>
                                                <?php 
                                                foreach($product_type as $u)
                                                {
                                                    ?>
                                                    <option  value="<?php echo $u['id'];?>" ><?php echo $u['name'];?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                            
                                           
                                        
                                          <div class="col-md-1">
                                           <label  >Status</label>
                                           <select class="form-control" id="status"   >
                                                <option value="">Select</option>
                                                <option>Pending</option>
                                                <option>Completed</option>
                                                <option>Cancelled</option>
                                            </select>
                                        </div>                                       
                                       
                                    
                    
                     <div class="col-md-1">
                        <input type="button" id="plan_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Production List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('production/plan/show_table2',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/production_js');?>

                
