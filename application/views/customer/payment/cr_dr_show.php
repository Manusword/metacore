            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    

                        <div class="col-md-2">
                            <label>Form Date</label>
                            <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php echo date('d-m-Y')?>" required  >
                        </div>
                        
                        <div class="col-md-2">
                            <label>To Date</label>
                            <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php echo date('d-m-Y')?>" required>
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
                        <input type="button" id="cr_dr_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>
                </div>
                
                
                
                
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <?php $reg_form = $this->Company->customer_reg_form_show();  if($reg_form[0]['details2']=='Yes'){?>
                    <div class="col-md-12" style="margin-bottom:20px;" >
                        <span ><i class="fa fa-long-arrow-down" style="color:green; "></i><a href="<?php  echo $reg_form[0]['details3']?>" style="color:green;"> Download Customer Registration Form</a></span>
                        <span style="margin-left:50px;"><i class="fa fa-long-arrow-up" style="color:red; "></i><a target="_blank" href="<?php echo base_url();?>index.php/Supplier/supplier_reg_form_upload"  style="color:red;"> Upload Customer Registration Form</a></span>
                    </div>
                    <?php }?>
                    
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Credit & Debit List</div>
                               
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('customer/payment/cr_dr_show_table',$res2);?></div>  
                            
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/customer');?>


   
