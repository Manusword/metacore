   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                    <div class="col-md-2">
                        <label>Date</label>
                        <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php if(isset($search_date1)){echo $search_date1;}else{echo $this->Base->change_date_dmy($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),'-1'));}   ?>" required  >
                    </div>

                             

                    <div class="col-md-2">
                        <label>Show Emp code</label>
                        <select class="form-control" id="show_array">
                                <option>No</option>
                                <option>Yes</option>
                        </select>
                    </div>

                    
                   

                      
                    
                    
                    <div class="col-md-1">
                        <input type="button" id="list3_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Attendance Summary of each dept. date wise</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php //echo $this->Hrmodel->date_wise_attendance_summary2($search_date,'No','No');?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/hr_js');?>

                
