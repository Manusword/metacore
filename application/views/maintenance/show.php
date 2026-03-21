   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                        <div class="col-md-1">
                                            <label>Form Date</label>
                                            <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php if(isset($search_date1)){echo $search_date1;}else{echo date('01-m-Y');}?>" required  >
                                        </div>
                                        
                                        <div class="col-md-1">
                                            <label>To Date</label>
                                            <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php if(isset($search_date2)){echo $search_date2;}else{echo date('d-m-Y');}?>" required>
                                        </div>

                                        <div class="col-md-1">
                                         <label for="exampleInputEmail1">Type of Work</label>
                                              <select class="form-control"   id="type_of_work">
                                                  <option  value="">All</option>
                                                  <option>Breakdown</option>
                                                  <option>Preventive</option>
                                                  <option>Installation</option>
                                                  <option>Improvement</option>
                                                  <option>Other Work</option>
                                              </select>
                                        </div>
                                        
                                        
                                        <div class="col-md-1">
                                         <label for="exampleInputEmail1">MBD / EBD</label>
                                              <select class="form-control"   id="type1">
                                                  <option  value="">All</option>
                                                  <option>MBD</option>
                                                  <option>EBD</option>
                                                  <option>Both</option>
                                                  <option>Utility</option>
                                                  <option>Instrumentation</option>
                                                  <option>Other</option>
                                              </select>
                                        </div>
                                        
                                 
                                        
                                        <div class="col-md-1">
                                         <label for="exampleInputEmail1">Problem Type</label>
                                              <select class="form-control"   id="problem_type_id">
                                                  <option value="">All</option>
                                                    <?php 
                                                    foreach($pl as $p)
                                                    {
                                                        ?>
                                                            <option  value="<?php echo $p['id'];?>"  ><?php echo $p['name'];?></option>
                                                        <?php 
                                                    }
                                                    ?>
                                              </select>
                                        </div>


                                        <div class="col-md-1">
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


                                         <div class="col-md-1">
                                         <label for="exampleInputEmail1">Priority</label>
                                              <select class="form-control"   id="priority">
                                                  <option  value="">All</option>
                                                  <option>Low</option>
                                                  <option>Medium</option>
                                                  <option>High</option>
                                                  <option>Urgent</option>
                                              </select>
                                        </div>

                                        <div class="col-md-1">
                                         <label for="exampleInputEmail1">Rating</label>
                                              <select class="form-control"   id="rating">
                                                  <option  value="">All</option>
                                                  <option>1</option>
                                                  <option>2</option>
                                                  <option>3</option>
                                                  <option>4</option>
                                                  <option>5</option>
                                              </select>
                                        </div>

                                         <div class="col-md-1">
                                            <label>Attend By</label>
                                             <input type="text" class="form-control"  id="attend_by" onKeyUp="op_search(this.id)" required  autocomplete="off" >
                                        </div>
                                        
                                        
                                        
                                        <div class="col-md-1">
                                            <label for="exampleInputEmail1">Status</label>
                                              <select class="form-control"   id="status">
                                                  <option    value="">All</option>
                                                  <option    value="Pending">Pending</option>
                                                  <option   value="Under Process">Under Process</option>
                                                  <option  value="Completed">Completed</option>
                                                  <option   value="Canceled">Canceled</option>
                                              </select>
                                        </div>
                                        
                    
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="breakdown_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Breakdown List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('maintenance/show_table',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>


                   
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/maintenance_js');?>

                
