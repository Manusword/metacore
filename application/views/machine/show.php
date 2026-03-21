         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                    <div class="col-md-2" >
                        <label >Dept. Name</label>
                        <select class="form-control"  id="dept"  >
                            <option value="">All</option>
                            <?Php 
                            foreach($dept as $d)
                            {
                                ?>
                                    <option  value="<?php echo $d['department_id'];?>">
                                        <?php echo $d['name'];?>
                                    </option>
                                <?php
                            }
                            ?>	
                        </select>
                    </div>

                    <div class="col-md-2" >
                        <label>Machine Name or No</label>
                        <input type="text"  class="form-control"   id="name" >
                    </div>

                    <div class="col-md-2" >
                        <label >Status</label>
                        <select class="form-control" id="status">
                                <option value="" >Select</option>
                                <option>Working</option>
                                <option>Under Maintenance</option>
                                <option>Rejected</option>
                        </select>
                    </div> 
                   

                    <div class="col-md-2">
                        <label >Show / Hide in Product entry List</label>
                        <select class="form-control"  id="hide_status">
                                <option value="0">Show</option>
                                <option value="1">Hide</option>
                        </select>
                    </div> 
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="machine_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Machine List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                    <div id="table_show"><?php $this->load->view('machine/show_table',$res2);?></div>  
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   

<?php $this->load->view('js/machine_js');?>
