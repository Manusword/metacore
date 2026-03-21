                         
        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Attendance & Salary Reports</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" style="color:<?php echo $this->Company->table_bg_color();?>;" ></div>
                                   
                              


                                            <div class="col-md-12" style="float:left; ">
                                                <div class="panel panel-white" style="height:500px; color:black;">
                                                    <div class="panel-body">
                                                        <div class="panel-heading clearfix" style="margin-top:0px;"><h4 align="left" >Please Select</h4></div>
                                                        
                                                        <div class="col-md-3" style="float:left;">
                                                            <div class="form-group" >
                                                                <label for="exampleInputEmail1">Type</label>
                                                                <select class="form-control" name="type_search" id="type_search">
                                                                    <option value="">Select</option>
                                                                    <option value="All">All</option>
                                                                    <?Php 
                                                                    $i=1;
                                                                    foreach($company_role as $c)
                                                                    {
                                                                        if($i == 1){ $selected = "selected";}else{$selected='';}
                                                                    ?>
                                                                        <option <?php if(isset($type)){if($type==$c['name']){echo "selected";}} echo $selected;?> value="<?php echo $c['name'];?>" >
                                                                            <?php echo $c['name'];?>
                                                                        </option>
                                                                    <?php
                                                                    $i++;
                                                                    }
                                                                    ?>	
                                                                </select>
                                                            </div>
                                                        </div>
                                    

                                                        <?php $year = date('Y');?>
                                                        <div class="col-md-3" style="float:left;">
                                                            <div class="form-group" >
                                                                <label for="exampleInputEmail1">Year</label>
                                                                <select class="form-control" name="year_search" id="year_search">
                                                                    <option value="">Select</option>
                                                                    <option <?php if(!empty($year))if($year=='2025'){ echo "selected";}?>>2025</option>
                                                                    <option <?php if(!empty($year))if($year=='2026'){ echo "selected";}?>>2026</option>
                                                                    <option <?php if(!empty($year))if($year=='2027'){ echo "selected";}?>>2027</option>
                                                                    <option <?php if(!empty($year))if($year=='2028'){ echo "selected";}?>>2028</option>
                                                                    <option <?php if(!empty($year))if($year=='2029'){ echo "selected";}?>>2029</option>
                                                                    <option <?php if(!empty($year))if($year=='2030'){ echo "selected";}?>>2030</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <?php $month = date('m');?>
                                                        <div class="col-md-3" style="float:left;" >
                                                            <div class="form-group" >
                                                                <label for="exampleInputEmail1">Month</label>
                                                                <select class="form-control" name="month_search" id="month_search">
                                                                    <option value="">Select</option>
                                                                    <option <?php if(!empty($month))if($month=='1'){ echo "selected";}?> value="1">Jan</option>
                                                                    <option <?php if(!empty($month))if($month=='2'){ echo "selected";}?> value="2">Feb</option>
                                                                    <option <?php if(!empty($month))if($month=='3'){ echo "selected";}?> value="3">Mar</option>
                                                                    <option <?php if(!empty($month))if($month=='4'){ echo "selected";}?> value="4">Apr</option>
                                                                    <option <?php if(!empty($month))if($month=='5'){ echo "selected";}?> value="5">May</option>
                                                                    <option <?php if(!empty($month))if($month=='6'){ echo "selected";}?> value="6">Jun</option>
                                                                    <option <?php if(!empty($month))if($month=='7'){ echo "selected";}?> value="7">Jul</option>
                                                                    <option <?php if(!empty($month))if($month=='8'){ echo "selected";}?> value="8">Aug</option>
                                                                    <option <?php if(!empty($month))if($month=='9'){ echo "selected";}?> value="9">Sep</option>
                                                                    <option <?php if(!empty($month))if($month=='10'){ echo "selected";}?> value="10">Qct</option>
                                                                    <option <?php if(!empty($month))if($month=='11'){ echo "selected";}?> value="11">Nov</option>
                                                                    <option <?php if(!empty($month))if($month=='12'){ echo "selected";}?> value="12">Dec</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3" style="margin-top:23px;float:left;">                            
                                                                <div class="form-group"  >
                                                                <div class="col-md" align="left"><span id="wait" style="color:orange; display:none;">Please Wait...</span>
                                                                    <button type="button" class="btn btn-info"  onclick="reports_search()" >Search</button>
                                                                </div>
                                                            </div>   
                                                        </div> 

                                                        <div id="result_reports_search" style="margin-top:23px;float:left;"> 
                                                        
                                                        </div>
                                                    
                                                    
                                   
                                
                                                    </div>
                                                </div>
                                            </div>

                                           
                                    
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   
                

<?php $this->load->view('js/hr_js');?>

    
