         

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
                        <label for="exampleInputPassword1">Select Customer</label>
                            <select  class="form-control"  style=" width: 100%"  id="customer"   >
                                <option value="">Select</option>
                                    <?Php 
                                    foreach($customer as $c)
                                    {
                                        ?>
                                            <option  value="<?php echo $c['id'];?>">
                                            <?php echo $c['name'];?>
                                            </option>
                                        <?php
                                    }//foreach
                                    ?>		
                            </select>
                    </div>

                   
                    
                   
                    <?php /*
                    <div class="col-md-2" >
                        <label >Grade</label>
                        <select class="form-control" id="grade"  >
                            <option value="">All</option>
                            <?php foreach($grade as $d){?>
                                <option value="<?php echo $d['id'];?>"><?php echo $d['name'];?></option>
                            <?php }?>
                        </select>
                    </div>
                    */?>

                    <div class="col-md-2" >
                        <label >Product (Select via Click)</label>
                        <input type="text"  class="form-control"   id="name2_" placeholder="Type to Select" onKeyUp="fun_get_product(this.id,'name2_','name_','diff_id_one_search')">
                        <input type="hidden"  class="form-control"   id="name_">
                    </div>

                    <div class="col-md-1" >
                        <label >Bill No.</label>
                        <input type="text"  class="form-control"   id="no">
                    </div>

                    <div class="col-md-1" >
                        <label >Type Of Bill</label>
                            <select class="form-control" id="type_of_bill"  >
                            <option>Tax Invoice</option>
                            <option>Rejection Invoice</option>
                        </select>
                    </div>

                    <div class="col-md-1" >
                        <label for="exampleInputPassword1">Cancel Bill</label>
                        <select  class="form-control"  style=" width: 100%" id="cancel_status" >
                            <option>All</option>
                            <option value='1'>Cancelled</option>
                            <option value='2'>Uncancelled</option>
                        </select>
                    </div> 
                                        
                    
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="dispatch_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Dispatch List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('dispatch/dispatch/show_table',$res2);?></div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/dispatch_js');?>


 
