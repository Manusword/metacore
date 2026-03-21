   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                        <div class="col-md-2">
                                            <label>Issue Form Date</label>
                                            <input type="text" class="form-control" id="search_date1"  value="<?php if(isset($search_date1)){echo $search_date1;}else{echo date('d-m-Y');}?>" required  >
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label>Issue To Date</label>
                                            <input type="text" class="form-control" id="search_date2"  value="<?php if(isset($search_date2)){echo $search_date2;}else{echo date('d-m-Y');}?>" required>
                                        </div>

                                         <div class="col-md-2">
                                            <label>Emp Code</label>
                                           <input type="text" class="form-control"  id="emp_code" onKeyUp="op_search(this.id)" required  autocomplete="off"   >
                                        </div>
                                        
                                        
                                        
                                        <div class="col-md-2">
                                            <label >Code ?</label>
                                              <select class="form-control"   id="type">
                                                  <option    value="">All</option>
                                                    <option>Yes</option>
                                                    <option>No</option>
                                              </select>
                                        </div>
                                        
                    
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="coupon_issue_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Canteen Coupon Issue List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('hr/canteen/show_table',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>


                   
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/hr_js');?>

                
