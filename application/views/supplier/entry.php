   
           

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Supplier</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Supplier</div>
                                    <div class="form-row">
                                      
                                        <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                        <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">

                                            <div class="col-md-4">
                                                <label for="exampleInputPassword1">Type Of Supplier</label>
                                                <select class="form-control"  name="type" id="type">
                                                  <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Manufacturer'){echo "selected";}?>  value="Manufacturer">Manufacturer</option>
                                                  <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Dealer'){echo "selected";}?> value="Dealer">Dealer</option>
                                                </select>
                                            </div> 


                                            <div class="col-md-4">
                                                <label for="exampleInputPassword1">Product Type</label>
                                                <select class="form-control"  name="product_type" id="product_type">
                                                  <option  <?php if(isset($res2[0]['product_type']))if($res2[0]['product_type']=='Consumable'){echo "selected";}?>  value="Consumable">Consumable</option>
                                                  <option  <?php if(isset($res2[0]['product_type']))if($res2[0]['product_type']=='Raw Material'){echo "selected";}?> value="Raw Material">Raw Material</option>
                                                </select>
                                            </div> 
                                          
                                            <div class="col-md-4">
                                                <label >Name</label>
                                                <input type="text" class="form-control"  name="name" id="name" required  autocomplete="off" value="<?php if(isset($res2[0]['name']))echo $res2[0]['name'];?>"  >
                                            </div>
                                            
                                            
                                            <div class="col-md-4">
                                                  <label >Supplier Approved No <span style="color:blue">If Approved</span></label>
                                                  <input type="number" class="form-control"  id="approved_no"   autocomplete="off" value="<?php if(isset($res2[0]['approved_no']))echo $res2[0]['approved_no'];?>"  >
                                            </div>
                                            
                                            
                                            <div class="col-md-4">
                                                  <label >Telephone Number</label>
                                                  <input type="number" class="form-control"   name="telphone" id="telphone" required autocomplete="off" value="<?php if(isset($res2[0]['telphone']))echo $res2[0]['telphone'];?>">
                                            </div>
                                            
                                            <!-- 
                                              <div class="col-md-6">
                                                    <label >Email</label>
                                                    <input type="email" class="form-control"   name="email" id="email"  autocomplete="off" value="<?php if(isset($res2[0]['email']))echo $res2[0]['email'];?>">
                                              </div>
                                            -->
                                            
                                
                                            <div class="col-md-4">
                                                  <label >Address</label>
                                                  <input type="text" class="form-control"   name="address" id="address" required  autocomplete="off" value="<?php if(isset($res2[0]['address']))echo $res2[0]['address'];?>">
                                            </div>
                                            
                                            <div class="col-md-4">
                                                  <label >City</label>
                                                  <input type="text" class="form-control"   name="city" id="city" required  autocomplete="off" value="<?php if(isset($res2[0]['city']))echo $res2[0]['city'];?>">
                                            </div>
                                            
                                          
                                            <div class="col-md-4">
                                                  <label for="exampleInputPassword1">Select State</label>
                                                      <select class="form-control"  name="state" id="state">
                                                            <option  <?php if(isset($res2[0]['state'])){if($res2[0]['state']==''){echo "selected";}}?>  value="">Select</option>
                                                              <?Php 
                                                                foreach($state as $c)
                                                                {
                                                              ?>
                                                                <option <?php if(isset($res2[0]['state'])){if($res2[0]['state']==$c['state_name'].' ('.$c['state_id'].')'){echo "selected";}}?> value="<?php echo $c['state_name'].' ('.$c['state_id'].')';?>">
                                                                    <?php echo $c['state_name'].' ('.$c['state_id'].')';?>
                                                                </option>
                                                              <?php
                                                                }
                                                              ?>		
                                                      </select>
                                            </div> 
                                                                  
                                                        
                                            
                                            
                                            
                                            <div class="col-md-4">
                                                  <label >Country</label>
                                                  <input type="text" class="form-control"   name="country" id="country" required  autocomplete="off" value="<?php if(isset($res2[0]['country']))echo $res2[0]['country'];?>">
                                            </div>
                                            
                                            <div class="col-md-12">
                                                  <label >Postcode</label>
                                                  <input type="number" class="form-control"   name="zip" id="zip"  autocomplete="off" value="<?php  if(isset($res2[0]['zip']))echo $res2[0]['zip'];?>">
                                            </div>
                                            
                                          
                                            <div class="col-md-6" style=" margin-top:30px; color:blue;">
                                                <label style="width:100%" >Contact Person 1 Details</label>
                                               	<div class="col-md-12">
                                                        <label >Name</label>
                                                        <input type="text" class="form-control"   name="con_name1" id="con_name1"  autocomplete="off" value="<?php  if(isset($res2[0]['con_name1']))echo $res2[0]['con_name1'];?>">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label >Mobile</label>
                                                        <input type="number" class="form-control"   name="con_mob1" id="con_mob1"  autocomplete="off" value="<?php  if(isset($res2[0]['con_mob1']))echo $res2[0]['con_mob1'];?>">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label >Email</label>
                                                        <input type="email" class="form-control"   name="con_email1" id="con_email1"  autocomplete="off" value="<?php  if(isset($res2[0]['con_email1']))echo $res2[0]['con_email1'];?>">
                                                    </div>
                                                      <div class="col-md-12">
                                                        <label >Designation </label>
                                                        <input type="text" class="form-control"    id="designation1"  autocomplete="off" value="<?php  if(isset($res2[0]['designation1']))echo $res2[0]['designation1'];?>">
                                                    </div>
                                            </div>
                                            
                                            
                                            
                                            <div class="col-md-6" style=" margin-top:30px; color:blue;">
                                                  <label style="width:100%;" >Contact Person 2 Details</label>
                                                    <div class="col-md-12">
                                                        <label >Name</label>
                                                        <input type="text" class="form-control"   name="con_name2" id="con_name2"  autocomplete="off" value="<?php  if(isset($res2[0]['con_name2']))echo $res2[0]['con_name2'];?>">
                                                    </div>
                                                    <div class="col-md-12">
                                                          <label >Mobile</label>
                                                        <input type="number" class="form-control"   name="con_mob2" id="con_mob2"  autocomplete="off" value="<?php  if(isset($res2[0]['con_mob2']))echo $res2[0]['con_mob2'];?>">
                                                    </div>
                                                    <div class="col-md-12">
                                                          <label >Email</label>
                                                        <input type="email" class="form-control"   name="con_email2" id="con_email2"  autocomplete="off" value="<?php  if(isset($res2[0]['con_email2']))echo $res2[0]['con_email2'];?>">
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                          <label >Designation </label>
                                                        <input type="text" class="form-control"    id="designation2"  autocomplete="off" value="<?php  if(isset($res2[0]['designation2']))echo $res2[0]['designation2'];?>">
                                                    </div>
                                            </div>
                                            
                                           
                                            
                                            <div class="col-md-6" style="margin-top:30px;">
                                                  <label >GST Number</label> <span id="gst_ab" style="color:red;"></span>
                                                  <input type="text" class="form-control"   name="gst" id="gst" required  autocomplete="off" value="<?php  if(isset($res2[0]['gst_no']))echo $res2[0]['gst_no'];?>" onKeyUp="fun_check_gst(this.value,'supplier')">
                                            </div>
                                            
                                      
                                      
                                            <div class="col-md-6" style="margin-top:30px;">
                                                  <label >Payment Terms</label>
                                                  <input type="text" class="form-control"   name="payment_terms" id="payment_terms"  autocomplete="off" value="<?php  if(isset($res2[0]['payment_terms']))echo $res2[0]['payment_terms'];?>">
                                            </div>
                                            
                                            
                                            <div class="col-md-6">
                                                  <label >Place Of Delivery</label>
                                                  <input type="text" class="form-control"   name="del_place" id="del_place"  autocomplete="off" value="<?php  if(isset($res2[0]['del_place']))echo $res2[0]['del_place'];?>">
                                            </div>
                                            
                                            
                                            
                                            <div class="col-md-6">
                                                  <label >Mode Of Dispatch</label>
                                                  <input type="text" class="form-control"   name="mod_of_dis" id="mod_of_dis"  autocomplete="off" value="<?php  if(isset($res2[0]['mod_of_dis']))echo $res2[0]['mod_of_dis'];?>">
                                            </div>
                                      
                                      
                                            <div class="col-md-12">
                                                  <label >Active / Deactive</label>
                                                  <select class="form-control"  name="active" id="active">
                                                      <option  <?php  if(isset($res2[0]['status'])){if($res2[0]['status']=='Active'){echo "selected";}}?>  value="Active">Active</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Deactive'){echo "selected";}}?> value="Deactive">Deactive</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Pending'){echo "selected";}}?> value="Pending">Pending</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Banned'){echo "selected";}}?> value="Banned">Banned</option>
                                                  </select>
                                            </div>
                                              
                                                              
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="supplier_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   



         
            
      

<?php $this->load->view('js/supplier');?>


     
