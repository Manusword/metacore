   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                      
                                        
                                        
                                        <div class="col-md-2">
                                              <label>Type 1</label>
                                                  <select class="form-control" id="type1">
                                                      <option  value="">Select</option>
                                                      <option  value="IPT">In Process Testing</option>
                                                  </select>
                                        </div> 

                                        <div class="col-md-2">
                                              <label>Type 2</label>
                                                  <select class="form-control"  id="type2">
                                                      <option   value="">Select</option>
                                                      <option   value="SW">High Carbon Steel Wire</option>
                                                      <option   value="GI">GI Rope Wire</option>
                                                  </select>
                                        </div> 


                                        <div class="col-md-2">
                                              <label>Grade</label>
                                                  <select class="form-control"  id="product_grade">
                                                      <option  value="">Select</option>
                                                          <?Php 
                                                            foreach($grade as $c)
                                                            {
                                                              ?>
                                                                <option value="<?php echo $c['id'];?>"><?php echo $c['name'];?></option>
                                                              <?php
                                                            }
                                                          ?>		
                                                  </select>
                                        </div> 
                                        
                                        <div class="col-md-2">
                                            <label>Dia (Size)</label>
                                            <input type="number" class="form-control" id="size"  >
                                        </div>


                                       
                    
                     <div class="col-md-1">
                        <input type="button" id="spec1_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Specification List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('qc/show_table',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/qc_js');?>

                
