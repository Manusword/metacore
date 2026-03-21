   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                <div class="col-md-2">
                        <label>Form Date</label>
                        <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php echo date('01-m-Y')?>" required  >
                    </div>
                    
                    <div class="col-md-2">
                        <label>To Date</label>
                        <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php echo date('t-m-Y');?>" required>
                    </div>

                    <div class="col-md-2" >
                        <label >Sales Person wise</label>
                            <select class="form-control" id="sales_person"  >
                            <option>No</option>
                            <option>Yes</option>
                        </select>
                    </div>
                                        
                                       
                    
                    
                    
                    <div class="col-md-1">
                        <input type="button" id="supply_grade_wise" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Supply List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
        </div><!-- end of main-content -->   







<?php $this->load->view('js/dispatch_js');?>

                
