            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <div class="col-md-2" >
                        <label >Type</label>
                        <select class="form-control" name="type" id="type" >
                            <option value="">All</option>
                            <option <?php if(isset($type)){if($type=='Manufacturer'){echo "selected";}}?> value="Manufacturer">Manufacturer</option>
                            <option <?php if(isset($type)){if($type=='Dealer'){echo "selected";}}?> value="Dealer">Dealer</option>
                        </select>
                    </div>

                
                    <div class="col-md-2">
                        <label >Name</label>
                        <input type="text" class="form-control"  id="name" name="name" value="<?php if(isset($name))echo $name;?>" >
                    </div> 
                    <div class="col-md-2">
                        <label >City</label>
                        <input type="text" class="form-control"  id="city" name="city" value="<?php if(isset($city))echo $city;?>" >
                    </div> 
                    <div class="col-md-1">
                        <input type="button" id="supplier_search" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>
                </div>
                
                
                
                
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <?php $reg_form = $this->Company->supplier_reg_form_show();  if($reg_form[0]['details2']=='Yes'){?>
                    <div class="col-md-12" style="margin-bottom:20px;" >
                        <span ><i class="fa fa-long-arrow-down" style="color:green; "></i><a href="<?php  echo $reg_form[0]['details3']?>" style="color:green;"> Download Supplier Registration Form</a></span>
                        <span style="margin-left:50px;"><i class="fa fa-long-arrow-up" style="color:red; "></i><a target="_blank" href="<?php echo base_url();?>index.php/Supplier/supplier_reg_form_upload"  style="color:red;"> Upload Supplier Registration Form</a></span>
                    </div>
                    <?php }?>
                    
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Supplier List</div>
                               
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show"><?php $this->load->view('supplier/show_table',$res2);?></div>  
                            
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   




<?php $this->load->view('js/supplier');?>
