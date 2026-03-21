   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                        <div  class="col-md-1">
                                            <label  >Dept. Type</label>
                                            <select class="form-control" id="dept_type">
                                                <option value="">All</option>
                                                <option  selected>Rope</option>
                                                <option  >Rewinding</option>
                                            </select>
                                        </div>
                
                                        <div class="col-md-1">
                                            <label>Form Date</label>
                                            <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php if(isset($search_date1)){echo $search_date1;}else{echo $this->Base->change_date_dmy($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),'-1'));}?>" required  >
                                        </div>
                                        
                                        <div class="col-md-1">
                                            <label>To Date</label>
                                            <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php if(isset($search_date2)){echo $search_date2;}else{echo $this->Base->change_date_dmy($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),'-1'));}?>" required>
                                        </div>

                                        <div  class="col-md-1">
                                            <label  >Shift</label>
                                            <select class="form-control" id="shift1">
                                                <option value="">All</option>
                                                <option  value="A">A</option>
                                                <option  value="B">B</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-1">
                                            <label  >M/C</label>
                                            <select class="form-control" id="mc_no"   >
                                                <option value="">All</option>
                                                <?php 
                                                    foreach($machine as $m)
                                                    {
                                                        ?>
                                                            <option value="<?php echo $m['mc_id'];?>"> <?php echo $m['name'];?></option>
                                                        <?php 
                                                    }
                                                ?>
                                                </select>
                                        </div>

                                       

                                        <div class="col-md-1" >
                                            <label>Size</label>
                                            <input type="text"    class="form-control"   id="size"   />
                                        </div>
                                        
                                      
                                        

                                        <div class="col-md-1" >
                                            <label  >Grade</label>
                                            <select class="form-control" id="grade">
                                                <option value="">All</option>
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

                                        <div  class="col-md-1">
                                                <label  >Operation</label>
                                                <select class="form-control" id="operation">
                                                    <option value="">All</option>
                                                    <option  value="Finish" >Finish</option>
                                                    <option  value="Outer Core">Outer Core</option>
                                                    <option  value="Center Core">Center Core</option>
                                                    <option  value="Rewinding">Rewinding</option>
                                                </select>
                                            </div>

                                            <div  class="col-md-1">
                                                <label  >Type</label>
                                                <select class="form-control" id="type">
                                                    <option value="">All</option>
                                                    <option  value="Old" >Old</option>
                                                    <option  value="New" >New</option>
                                                </select>
                                            </div>


                                            <div  class="col-md-1">
                                                <label  >Construction</label>
                                                <select class="form-control" id="construction">
                                                    <option value="">All</option>
                                                    <option  value="1 + 6">1 + 6</option>
                                                    <option  value="1 x 19">1 x 19</option>
                                                    <option  value="7 x 7">7 x 7</option>
                                                    <option  value="7 x 19">7 x 19</option>
                                                </select>
                                            </div>

                                        
                                        
                                          <div class="col-md-1">
                                           <label  >Down Type</label>
                                            <select class="form-control" id="down_type">
                                            	<option value="">All</option>
                                            	<option >MBD</option>
                                            	<option >EBD</option>
                                            	<option >Die</option>
                                                <option >MBD, EBD, Die</option>
                                            	<option >Operator</option>
                                            	<option >No Materil</option>
                                            	<option >Program Change</option>
                                            	<option >Bobbin Short</option>
                                                <option >Size Change Over</option>
                                            	<option >Other</option>
                                            </select>
                                        </div>                                       
                                       
                                       
                                        <div class="col-md-1"> 
                                            <label>Operator</label>
                                            <input type="text" class="form-control"   id="operator" required  autocomplete="off" onKeyUp="op_search(this.id)" >
                                        </div> 
                                       
                                        
                    
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="production_search_rope" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
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
                                    <?php $this->load->view('production/rope/show_table',$res2);?>
                                </div>  
                                 

                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/production_js');?>

                
