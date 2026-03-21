         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                    <div class="col-md-1">
                        <label>Form Date</label>
                        <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php echo date('01-m-Y')?>" required  >
                    </div>
                    
                    <div class="col-md-1">
                        <label>To Date</label>
                        <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php echo date('d-m-Y');?>" required>
                    </div>

                    <div class="col-md-1">
                        <label>Actual Month</label>
                        <input type="text" class="form-control" id="actual_month2" name="actual_month2" >
                    </div>

                    <div class="col-md-2" >
                        <label >Select Customer</label>
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


                    <div class="col-md-1" >
                        <label >Grade</label>
                            <select  class="form-control"  style=" width: 100%"  id="grade"   >
                                <option value="">Select</option>
                                    <?Php 
                                    foreach($grade as $c)
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

                    <div class="col-md-1" >
                        <label >Oil / W.Oil</label>
                            <select  class="form-control"  style=" width: 100%"  id="oil"   >
                                <option value="">Select</option>
                                <option value="Oil">Oil</option>
                                <option value="Without Oil">Without Oil</option>
                            </select>
                    </div>

                   

                    <div class="col-md-2" >
                        <label >Product (Select via Click)</label>
                        <input type="text"  class="form-control"   id="name2_" placeholder="Type to Select" onKeyUp="fun_get_product(this.id,'name2_','name_','diff_id_one_search')">
                        <input type="hidden"  class="form-control"   id="name_">
                    </div>

                    <div class="col-md-1" >
                        <label >Po No.</label>
                        <input type="text"  class="form-control"   id="po_no">
                    </div>

                    <div class="col-md-1" >
                        <label >Type Of Bill</label>
                            <select class="form-control" id="type_of_bill"  >
                            <option>Tax Invoice</option>
                            <option>Rejection Invoice</option>
                        </select>
                    </div>
                    
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="schedule_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Schedule List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('dispatch/schedule/show_table',$res2);?></div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   

                 
               


                <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade popup_product_his"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body" id="popup_product_his_dis">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<?php $this->load->view('js/dispatch_js');?>


 
