         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                    <div class="col-md-2">
                        <label>Form Date</label>
                        <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php echo date('d-m-Y')?>" required  >
                    </div>
                    
                    <div class="col-md-2">
                        <label>To Date</label>
                        <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php echo date('d-m-Y');?>" required>
                    </div>

                    <div class="col-md-2" >
                        <label >Issue No.</label>
                        <input type="text"  class="form-control"   id="issue_no">
                    </div>
                    
                    <div class="col-md-2">
                        <label >Department </label>
                        <select class="form-control" id="dept" onChange="fun_get_machine_form_dept_id(this.value,'mc_no','diff_id')">
                            <option value="">Select</option>
                                <?php 
                                foreach($dept as $d)
                                {
                                ?>
                                    <option value="<?php echo $d['department_id'];?>"  ><?php echo $d['name'];?></option>
                                <?php 
                                }
                                ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label  >M/C</label>
                        <select class="form-control" id="mc_no" >
                            <option value="">Select</option>
                        </select>
                    </div>

                    
                    <div class="col-md-2" >
                        <label >Category</label>
                        <select class="form-control" name="cat" id="cat"  >
                            <option value="">All</option>
                            <?php foreach($cat2 as $d){?>
                                <option value="<?php echo $d['category_id'];?>"><?php echo $d['name'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="col-md-2" >
                        <label >Grade</label>
                        <select class="form-control" id="grade"  >
                            <option value="">All</option>
                            <?php foreach($grade as $d){?>
                                <option value="<?php echo $d['id'];?>"><?php echo $d['name'];?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="col-md-2" >
                        <label >Product (Select via Click)</label>
                        <input type="text"  class="form-control"   id="name2_" placeholder="Type to Select" onKeyUp="fun_get_product(this.id,'name2_','name_','diff_id_one_search')">
                        <input type="hidden"  class="form-control"   id="name_">
                    </div>


                    <div class="col-md-2" >
                        <label >Received BY</label>
                        <input type="text"  class="form-control"   id="req_by">
                    </div>

                    <div class="col-md-2" >
                        <label >Stage</label>
                        <select class="form-control" id="status"  >
                            <option selected value="">All</option>
                            <option  value="1">Pending</option>
                            <option value="2">Approved</option>
                            <option value="9">Rejected</option>
                        </select>
                    </div>
                    
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="store_issue_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Issue List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('store/issue/show_table',$res2);?></div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/product_js');?>


 
