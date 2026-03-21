   
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                                      
                                        
                                        <div class="col-md-1">
                                            <label>Form Date</label>
                                            <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php if(isset($search_date1)){echo $search_date1;}else{echo date('d-m-Y');}?>" required  >
                                        </div>
                                        
                                        <div class="col-md-1">
                                            <label>To Date</label>
                                            <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php if(isset($search_date2)){echo $search_date2;}else{echo date('d-m-Y');}?>" required>
                                        </div>


                                        <div class="col-md-2">
                                                <label>Customer</label>
                                                <select  class="form-control"  style=" width: 100%" id="customer_id" >
                                                      <option  <?php if(isset($res2[0]['customer_id'])){if($res2[0]['customer_id']==''){echo "selected";}}?>  value="">Select</option>
                                                            <?Php 
                                                            foreach($customer as $c)
                                                            {
                                                            ?>
                                                                  <option  value="<?php echo $c['id'];?>">
                                                                  <?php echo $c['name'];?>
                                                                  </option>
                                                            <?php
                                                            }
                                                            ?>		
                                                </select>
                                          </div> 


                                          <div class="col-md-2">
                                                <label>Product Type</label>
                                                <select  class="form-control"  style=" width: 100%" id="product_type" >
                                                      <option  <?php if(isset($res2[0]['customer_id'])){if($res2[0]['customer_id']==''){echo "selected";}}?>  value="">Select</option>
                                                      <?php 
                                                            foreach($product_type as $u)
                                                            {
                                                                  ?>
                                                                  <option  value="<?php echo $u['id'];?>" ><?php echo $u['name'];?></option>
                                                                  <?php
                                                            }
                                                      ?>			
                                                </select>
                                          </div> 


                                          <div class="col-md-2">
                                            <label>Product Name</label>
                                            <input type="text" class="form-control" id="product_name" >
                                        </div>

                                        <div class="col-md-1">
                                            <label>Invoice No.</label>
                                            <input type="text" class="form-control" id="invoice_no" >
                                        </div>

                                        <div class="col-md-1">
                                            <label>Certificate No.</label>
                                            <input type="text" class="form-control" id="certificate_no" >
                                        </div>

                                        

                                        <div class="col-md-1">
                                            <label>Size</label>
                                            <input type="text" class="form-control" id="size" >
                                        </div>


                                        



                                       
                    
                     <div class="col-md-1">
                        <input type="button" id="tc_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Material Test Certificate List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                  <?php $this->load->view('qc/tc/show_table',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/qc_js');?>

                
