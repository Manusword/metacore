   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                    <div class="col-md-2">
                        <label >Department </label>
                        <select class="form-control" id="dept">
                            <option value="">Select</option>
                                <?php 
                                foreach($dept as $d)
                                {
                                ?>
                                    <option value="<?php echo $d['department_id'];?>"  selected><?php echo $d['name'];?></option>
                                <?php 
                                }
                                ?>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <label >Year </label>
                        <select class="form-control" id="year" >
                            <option value="">Select</option>
                            <option <?php if(date('Y') == '2021'){echo "selected";}?> >2021</option>
                            <option <?php if(date('Y') == '2022'){echo "selected";}?>>2022</option>
                            <option <?php if(date('Y') == '2023'){echo "selected";}?>>2023</option>
                            <option <?php if(date('Y') == '2024'){echo "selected";}?>>2024</option>
                            <option <?php if(date('Y') == '2025'){echo "selected";}?>>2025</option>
                        </select>
                    </div>


                    <div class="col-md-1">
                        <label >Month</label>
                        <select class="form-control" id="month">
                            <option value="">Select</option>
                            <option <?php if(date('m') == '01'){echo "selected";}?> value="01">Jan</option>
                            <option <?php if(date('m') == '02'){echo "selected";}?> value="02">Feb</option>
                            <option <?php if(date('m') == '03'){echo "selected";}?> value="03">Mar</option>
                            <option <?php if(date('m') == '04'){echo "selected";}?> value="04">Apr</option>
                            <option <?php if(date('m') == '05'){echo "selected";}?> value="05">May</option>
                            <option <?php if(date('m') == '06'){echo "selected";}?> value="06">Jun</option>
                            <option <?php if(date('m') == '07'){echo "selected";}?> value="07">Jul</option>
                            <option <?php if(date('m') == '08'){echo "selected";}?> value="08">Aug</option>
                            <option <?php if(date('m') == '09'){echo "selected";}?> value="09">Sep</option>
                            <option <?php if(date('m') == '10'){echo "selected";}?> value="10">Oct</option>
                            <option <?php if(date('m') == '11'){echo "selected";}?> value="11">Nov</option>
                            <option <?php if(date('m') == '12'){echo "selected";}?> value="12">Dec</option>
                        </select>
                    </div>
                                        
                                       
                    
                    
                    
                    <div class="col-md-1">
                        <input type="button" id="production_search4" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
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
                                    
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
        </div><!-- end of main-content -->   







<?php $this->load->view('js/production_js');?>

                
