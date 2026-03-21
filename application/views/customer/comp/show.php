            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    
                    

                    <div class="col-md-2">
                            <label>Form Date</label>
                            <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php echo date('01-m-Y')?>" required  >
                        </div>
                        
                        <div class="col-md-2">
                            <label>To Date</label>
                            <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php echo date('d-m-Y')?>" required>
                        </div>

                        <div class="col-md-2" >
                        <label >Type</label>
                        <select class="form-control" id="type">
                            <option  value="">All</option>
                            <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Complaint'){echo "selected";}?>  value="Complaint">Complaint</option>
                            <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Dispute'){echo "selected";}?> value="Dispute">Dispute</option>
                        </select>
                    </div>
                        
                        <div class="col-md-2">
                            <label >Select Customer</label>
                            <select class="form-control select2"    id="search_customer">
                                <option  value="">Select</option>
                                    <?Php 
                                    foreach($cus as $c)
                                    {
                                        ?>
                                            <option value="<?php echo $c['id'];?>">
                                                    <?php echo $c['name'];?>
                                            </option>
                                        <?php
                                    }
                                    ?>		
                            </select>
                        </div>
                  


                    <div class="col-md-1">
                        <input type="button" id="cust_compl_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>
                </div>
                
                
                
                
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    
                    
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Customer Complaint List</div>
                               
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('customer/comp/show_table',$res2);?></div>  
                            
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/customer');?>


   
