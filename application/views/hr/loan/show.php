   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                        <div class="col-md-2">
                                            <label>Form Date</label>
                                            <input type="text" class="form-control" id="search_date1"  value="<?php if(isset($search_date1)){echo $search_date1;}else{echo date('01-m-Y');}?>" required  >
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label>To Date</label>
                                            <input type="text" class="form-control" id="search_date2"  value="<?php if(isset($search_date2)){echo $search_date2;}else{echo date('t-m-Y');}?>" required>
                                        </div>

                                         <div class="col-md-1">
                                            <label>Emp Code</label>
                                           <input type="text" class="form-control"  id="emp_code" onKeyUp="op_search(this.id)" required  autocomplete="off"   >
                                        </div>
                                        
                                        

                                        <div class="col-md-2">
                                         <label for="exampleInputEmail1">Dept</label>
                                              <select class="form-control"   id="dept">
                                                  <option value="">All</option>
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


                                        
                                         <div class="col-md-3 mt-2">
                                            <label>Status</label>
                                            <select class="form-control" id="status">
                                                <option  value="RUNNING">Running</option>
                                                <option  value="CLOSED">Closed</option>
                                            </select>
                                        </div>


                    
                     <div class="col-md-1">
                        <input type="button" id="loan_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Loan Application List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('hr/loan/show_table',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>


                   
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/hr_js');?>

                
