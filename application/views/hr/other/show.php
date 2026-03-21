   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                            <?php if($page != 'onlyPendingGatepass') {?>
                                        <div class="col-md-2">
                                            <label style="color:blue">Type of Application</label>
                                            <select class="form-control"   id="search_type">
                                                  <option    value="">All</option>
                                                    <option value="">Select</option>
                                                    <option  <?php if(isset($type)){if($type=='Medical'){echo "selected";}}?>>Medical</option>
                                                    <option  <?php if(isset($type)){if($type=='EPF/ESI'){echo "selected";}}?>>EPF/ESI</option>
                                                    <option  <?php if(isset($type)){if($type=='Fight'){echo "selected";}}?>>Fight</option>
                                                    <option  <?php if(isset($type)){if($type=='Fine'){echo "selected";}}?>>Fine</option>
                                                    <option  <?php if(isset($type)){if($type=='Gatepass'){echo "selected";}}?>>Gatepass</option>
                                                    <option  <?php if(isset($type)){if($type=='Increment'){echo "selected";}}?>>Increment</option>
                                                    <option  <?php if(isset($type)){if($type=='MEMO'){echo "selected";}}?>>MEMO</option>
                                                    <option  <?php if(isset($type)){if($type=='Mobile'){echo "selected";}}?>>Mobile</option>
                                                    <option  <?php if(isset($type)){if($type=='Resign'){echo "selected";}}?>>Resign</option>
                                                    <option  <?php if(isset($type)){if($type=='Rest Change'){echo "selected";}}?>>Rest Change</option>
                                                    <option  <?php if(isset($type)){if($type=='Re-Join'){echo "selected";}}?>>Re-Join</option>
                                                    <option  <?php if(isset($type)){if($type=='Salary'){echo "selected";}}?>>Salary</option>
                                                    <option  <?php if(isset($type)){if($type=='Shift Change'){echo "selected";}}?>>Shift Change</option>
                                                    <option  <?php if(isset($type)){if($type=='Other'){echo "selected";}}?>>Other</option>
                                              </select>
                                        </div>

                
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

                                        <div class="col-md-1">
                                            <input type="button" id="other_appli_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                                        </div>
                    <?php }?>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Others Application List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('hr/other/show_table',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>


                   
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/hr_js');?>

                
