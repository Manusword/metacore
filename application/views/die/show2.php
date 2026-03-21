   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                      
                                        <div class="col-md-2" >
                                            <label>Location</label>
                                            <select class="form-control"  id="location">
                                                <option>M/C</option>
                                            	<option>Stock</option>
                                                <option>Repair</option>
                                                <option>Scrap</option>
                                            </select>
                                        </div>


                                        <div class="col-md-2" >
                                            <label>Search Type</label>
                                            <select class="form-control" id="group_wise">
                                            	<option>Size Wise</option>
                                                <option>Machine Wise</option>
                                            </select>
                                        </div>
                                        
                                      
                    
                     <div class="col-md-1">
                        <input type="button" id="group_wise_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
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
                                    <?php 
                                        $this->Ddiemodel->get_all_die_group_by_size($location);
                                    ?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/ddie_js');?>

                
