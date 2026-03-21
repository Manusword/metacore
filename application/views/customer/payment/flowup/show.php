            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    
                       

                        <div class="col-md-2">
                            <label>Follow up On</label>
                            <input type="text" class="form-control" id="search_date1" autocomplete="off"  value="<?php //echo date('d-m-Y')?>" required  >
                        </div>
                        
                       
                        <div class="col-md-2">
                            <label >Select Customer</label>
                            <select class="form-control select2"    id="search_customer">
                                <option  value="">All Customer</option>
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
                            <label >Sales Person</label>
                            <select class="form-control select2"    id="search_sales">
                                <option  value="">All Person</option>
                                    <?Php 
                                    foreach($sales as $c)
                                    {
                                        ?>
                                            <option><?php echo $c['sales_person'];?></option>
                                        <?php
                                    }
                                    ?>		
                            </select>
                        </div>

                        <div class="col-md-1">
                            <label >Select Color</label>
                            <select class="form-control select2"    id="search_color">
                                <option  value="">All Color</option>
                                <option>Red</option>
                                <option>Orange</option>
                                <option>Green</option>
                            </select>
                        </div>


                        <div class="col-md-2" >
                            <label >Show in Follow Up List</label>
                            <select class="form-control" id="show_in_follow_up">
                               
                                <option   value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                
               
                   
                    <div class="col-md-1">
                        <input type="button" id="cus_flowup_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>
                            
                    <!-- <div class="col-md-1">
                        <a style=" margin-top:25px;" href="<?php base_url()?>home?Customer/cus_payment_flowup_list"  class="btn btn-dark" style=" float:left;">
                        Clear Filter
                        </a>
                    </div> -->


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
                              <div class="card-title" ></div>
                                <h4 class="card-title mb-3">Party Payment Details </h4>
                                
                                <div class="row">
                                   
                                    <?php /*
                                    <div class="col-md-2">
                                        <label>Select Mail</label>
                                        <select class="form-control" id="search_mail_type">
                                            <option  value="">No Mail</option>
                                            <option  value="1">Red Mail</option>
                                            <option  value="2">Upcoming</option>
                                            <option  value="3">Mail Type 3</option>
                                        </select>
                                    </div>
                                   
                                    <div class="col-md-1">
                                        <input type="button" id="cus_send_mail" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"   value="Send Mail" >
                                    </div>
                                    */?>

                                    
                                    
                                    <div class="col-md-1">
                                        <button  style=" margin-top:25px;"  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                    </div>
                                </div>

                                
                                <div style=" margin-top:25px;" id="table_show"> 
                                
                                <?php $this->load->view('customer/payment/flowup/show_table',$res2);?>
                            </div>  
                            
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   


               


               
                <!--  Large Modal -->
                <div class="modal fade bd-example-modal-lg"  tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg" id="fun_get_cust_details_display_box">
                        
                    </div>
                </div>
                <!--  Modal -->













<?php $this->load->view('js/customer');?>

   
