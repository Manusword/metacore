   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                        <div class="col-md-2">
                                            <label>Date From</label>
                                            <input type="text" class="form-control"  id="search_date1" value="<?php echo date('d-m-Y');?>" >
                                        </div>

                                        <div class="col-md-2">
                                            <label>Date To</label>
                                            <input type="text" class="form-control"  id="search_date2" value="<?php echo date('d-m-Y');?>" >
                                        </div>
                                        
                                        
                                        <div class="col-md-2" >
                                            <label  >M/C No</label>
                                            <select class="form-control" name="mc" id="mc">
                                            	<option value="">All</option>
                                                <?php 
                                                foreach($mc as $d){
                                                ?>
                                                <option  value="<?php echo $d['mc_id'];?>"><?php echo $d['dname'].' : '.$d['mname'].'';?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-1" >
                                            <label  >Pallet</label>
                                            <select class="form-control" name="pallet" id="pallet">
                                            	<option value="">All</option>
                                                <?php 
												foreach($die as $d){
												?>
                                                    <option  value="<?php echo $d['id'];?>">
                                                        <?php echo $d['pallet'].' ('.$d['code'].')';?>
                                                    </option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        
                                         <div class="col-md-1">
                                            <label>Die No</label>
                                            <input type="number" class="form-control" id="die_no" name="die_no"  >
                                        </div>
                                        
                                        <div class="col-md-1">
                                            <label>Manuf. No</label>
                                            <input type="text" class="form-control" id="menu_no" name="menu_no" >
                                        </div>

                                        <div class="col-md-1">
                                            <label>Size</label>
                                            <input type="number" class="form-control" id="size" name="size"  >
                                        </div>
                                       


                                       
                    
                     <div class="col-md-1">
                        <input type="button" id="new_die_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >All Die List</div>
                              <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('die/show_table',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/ddie_js');?>

                
