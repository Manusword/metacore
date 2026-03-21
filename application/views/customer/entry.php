     
           

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Customer</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Customer</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                            
                                            <div class="col-md-12">
                                                  <label for="exampleInputPassword1">Type Of Customer</label>
                                                    <select class="form-control" name="type" id="type">
                                                      <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Manufacturer'){echo "selected";}?>  value="Manufacturer">Manufacturer</option>
                                                      <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Trader'){echo "selected";}?> value="Trader">Trader</option>
                                                      <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Dealer'){echo "selected";}?> value="Dealer">Dealer</option>
                                                      <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Supplier'){echo "selected";}?> value="Supplier">Supplier</option>
                                                    </select>
                                            </div> 

                                            <div class="col-md-12">
                                                <label >Name</label>
                                                <input type="text" class="form-control"  name="name" id="name" required  autocomplete="off" value="<?php if(isset($res2[0]['name']))echo $res2[0]['name'];?>"  >
                                            </div>

                                            <div class="col-md-6">
                                                <label >Customer Code <span style="color:red" id="customer_code_span"></span></label>
                                                <input type="text" class="form-control"   id="customer_code" required  autocomplete="off" value="<?php if(isset($res2[0]['customer_code']))echo $res2[0]['customer_code'];?>"  onKeyUp="fun_check_customer_code(this.value)">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                  <label >Telephone Number</label>
                                                  <input type="number" class="form-control"   name="telphone" id="telphone" required autocomplete="off" value="<?php if(isset($res2[0]['telphone']))echo $res2[0]['telphone'];?>">
                                            </div>
                                            
                                          
                                            <div class="col-md-6">
                                                  <label >Email</label>
                                                  <input type="email" class="form-control"   name="email" id="email"  autocomplete="off" value="<?php if(isset($res2[0]['email']))echo $res2[0]['email'];?>">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                  <label >Address</label>
                                                  <input type="text" class="form-control"   name="address" id="address" required  autocomplete="off" value="<?php if(isset($res2[0]['address']))echo $res2[0]['address'];?>">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                  <label >City</label>
                                                  <input type="text" class="form-control"   name="city" id="city" required  autocomplete="off" value="<?php if(isset($res2[0]['city']))echo $res2[0]['city'];?>">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                  <label for="exampleInputPassword1">Select State</label>
                                                      <select class="form-control" tabindex="-1"   name="state" id="state">
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
                                                                  
                                            <div class="col-md-6">
                                                  <label >Country</label>
                                                  <input type="text" class="form-control"   name="country" id="country" required  autocomplete="off" value="<?php if(isset($res2[0]['country'])){echo $res2[0]['country'];}else{echo "India";}?>">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                  <label >Postcode</label>
                                                  <input type="number" class="form-control"   name="zip" id="zip"  autocomplete="off" value="<?php  if(isset($res2[0]['zip']))echo $res2[0]['zip'];?>">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                  <label >GST Number</label><span id="gst_ab" style="color:red;"></span>
                                                  <input type="text" class="form-control"   name="gst" id="gst" required  autocomplete="off" value="<?php  if(isset($res2[0]['gst_no']))echo $res2[0]['gst_no'];?>"  onKeyUp="fun_check_gst(this.value,'customer')">
                                            </div>
                                          
                                            <div class="col-md-6">
                                                  <label >Vender Code</label>
                                                  <input type="text" class="form-control"   name="vender_code" id="vender_code"  autocomplete="off" value="<?php  if(isset($res2[0]['vender_code']))echo $res2[0]['vender_code'];?>">
                                            </div>

                                            <div class="col-md-12" style=" margin-top:30px; color:Orange;">
                                                <hr>
                                                <label style="width:100%" >Billing Address (In Case of different form Main Address)</label>
                                                
                                                <div class="col-md-6" style="float:left;">
                                                      <label >Billing Company Name</label>
                                                      <input type="text" class="form-control"   id="bill_name" required  autocomplete="off" value="<?php if(isset($res2[0]['bill_name']))echo $res2[0]['bill_name'];?>"  >
                                                </div>
                                                
                                                <div class="col-md-6" style="float:left;">
                                                      <label >Billing Address</label>
                                                      <input type="text" class="form-control"    id="bill_address" required  autocomplete="off" value="<?php if(isset($res2[0]['bill_address']))echo $res2[0]['bill_address'];?>">
                                                </div>
                                                
                                                <div class="col-md-6" style="float:left;">
                                                      <label >Billing City</label>
                                                      <input type="text" class="form-control"   id="bill_city" required  autocomplete="off" value="<?php if(isset($res2[0]['bill_city']))echo $res2[0]['bill_city'];?>">
                                                </div>
                                                
                                                
                                                <div class="col-md-6" style="float:left;">
                                                      <label for="exampleInputPassword1">Billing State</label>
                                                          <select class="form-control" tabindex="-1"   id="bill_state">
                                                                <option  <?php if(isset($res2[0]['bill_state'])){if($res2[0]['bill_state']==''){echo "selected";}}?>  value="">Select</option>
                                                                  <?Php 
                                                                    foreach($state as $c)
                                                                    {
                                                                  ?>
                                                                    <option <?php if(isset($res2[0]['bill_state'])){if($res2[0]['bill_state']==$c['state_name'].' ('.$c['state_id'].')'){echo "selected";}}?> value="<?php echo $c['state_name'].' ('.$c['state_id'].')';?>">
                                                                        <?php echo $c['state_name'].' ('.$c['state_id'].')';?>
                                                                    </option>
                                                                  <?php
                                                                    }
                                                                  ?>		
                                                          </select>
                                                </div> 
                                                
                                                <div class="col-md-6" style="float:left;">
                                                      <label >Billing Country</label>
                                                      <input type="text" class="form-control"    id="bill_country" required  autocomplete="off" value="<?php if(isset($res2[0]['bill_country']))echo $res2[0]['bill_country'];?>">
                                                </div>
                                                
                                                <div class="col-md-6" style="float:left;">
                                                      <label >Billing Postcode</label>
                                                      <input type="number" class="form-control"   id="bill_zip"  autocomplete="off" value="<?php  if(isset($res2[0]['bill_zip']))echo $res2[0]['bill_zip'];?>">
                                                </div>

                                                <div class="col-md-6" style="float:left;">
                                                    <label >GST Number 2</label></span>
                                                    <input type="text" class="form-control"   name="gst2" id="gst2" required  autocomplete="off" value="<?php  if(isset($res2[0]['gst_no2']))echo $res2[0]['gst_no2'];?>">
                                                </div>
                                            </div>


                                            <div class="col-md-6" style=" margin-top:30px; color:blue;">
                                                <hr>
                                                <label style="width:100%" >Details of Contact Person 1</label>
                                                    <div class="col-md-12">
                                                          <div class="form-group" >
                                                            <label >Name</label>
                                                          <input type="text" class="form-control"   name="con_name1" id="con_name1"  autocomplete="off" value="<?php  if(isset($res2[0]['con_name1']))echo $res2[0]['con_name1'];?>">
                                                          </div>
                                                      </div>
                                                      <div class="col-md-12">
                                                          <div class="form-group" >
                                                            <label >Mobile</label>
                                                          <input type="number" class="form-control"   name="con_mob1" id="con_mob1"  autocomplete="off" value="<?php  if(isset($res2[0]['con_mob1']))echo $res2[0]['con_mob1'];?>">
                                                          </div>
                                                      </div>
                                                      <div class="col-md-12">
                                                          <div class="form-group" >
                                                            <label >Email</label>
                                                          <input type="email" class="form-control"   name="con_email1" id="con_email1"  autocomplete="off" value="<?php  if(isset($res2[0]['con_email1']))echo $res2[0]['con_email1'];?>">
                                                          </div>
                                                      </div>
                                                        <div class="col-md-12">
                                                          <div class="form-group" >
                                                            <label >Designation </label>
                                                          <input type="text" class="form-control"    id="designation1"  autocomplete="off" value="<?php  if(isset($res2[0]['designation1']))echo $res2[0]['designation1'];?>">
                                                          </div>
                                                      </div>
                                            </div>
                                              
                                            <div class="col-md-6" style=" margin-top:30px; color:blue;">
                                                <hr>
                                                <label style="width:100%;" >Details of Contact Person 2</label>
                                                 	  <div class="col-md-12">
                                                          <div class="form-group" >
                                                            <label >Name</label>
                                                          <input type="text" class="form-control"   name="con_name2" id="con_name2"  autocomplete="off" value="<?php  if(isset($res2[0]['con_name2']))echo $res2[0]['con_name2'];?>">
                                                          </div>
                                                      </div>
                                                      <div class="col-md-12">
                                                          <div class="form-group" >
                                                            <label >Mobile</label>
                                                          <input type="number" class="form-control"   name="con_mob2" id="con_mob2"  autocomplete="off" value="<?php  if(isset($res2[0]['con_mob2']))echo $res2[0]['con_mob2'];?>">
                                                          </div>
                                                      </div>
                                                      <div class="col-md-12">
                                                          <div class="form-group" >
                                                            <label >Email</label>
                                                          <input type="email" class="form-control"   name="con_email2" id="con_email2"  autocomplete="off" value="<?php  if(isset($res2[0]['con_email2']))echo $res2[0]['con_email2'];?>">
                                                          </div>
                                                      </div>
                                                      
                                                      <div class="col-md-12">
                                                          <div class="form-group" >
                                                            <label >Designation </label>
                                                          <input type="text" class="form-control"    id="designation2"  autocomplete="off" value="<?php  if(isset($res2[0]['designation2']))echo $res2[0]['designation2'];?>">
                                                          </div>
                                                      </div>
                                            </div>



                                          <div class="col-md-6" style=" margin-top:50px;">
                                                <label >Limit Of Dispatch (Eg: 15,00,000)</label>
                                                <input type="number" class="form-control"  placeholder="1500000"   id="limit_of_dis"  autocomplete="off" value="<?php  if(isset($res2[0]['limit_of_dis']))echo $res2[0]['limit_of_dis'];?>">
                                          </div>

                                          <div class="col-md-6" style=" margin-top:50px;">
                                                <label>Day's Limit  (Eg: 30) Day's</label>
                                                <input type="number" class="form-control"  placeholder="30"   id="limit_of_days"  autocomplete="off" value="<?php  if(isset($res2[0]['limit_of_days']))echo $res2[0]['limit_of_days'];?>">
                                          </div>
                                          
                                            
                                            <!--
                                            <div class="col-md-6" style=" margin-top:50px;">
                                                  <label >Limit Of Dispatch (Eg: 25,00,000)</label>
                                                  <input type="number" class="form-control"  placeholder="2500000"   id="limit_of_dis"  autocomplete="off" value="<?php  if(isset($res2[0]['limit_of_dis']))echo $res2[0]['limit_of_dis'];?>">
                                            </div>
                                            
                                            <div class="col-md-6" style=" margin-top:50px;">
                                                  <label >Scheme Enter Percentage (Eg: MRP-15% )</label>
                                                  <input type="number" class="form-control" placeholder="15"    id="scheme1"  autocomplete="off" value="<?php  if(isset($res2[0]['scheme1']))echo $res2[0]['scheme1'];?>">
                                            </div>
                                            
                                            <div class="col-md-6" style=" margin-top:50px;">
                                                  <label >Discount 1 Enter Percentage (Eg: 3%, 4% OF MRP)</label>
                                                  <input type="number" class="form-control" placeholder="3%"    id="dis_val1"  autocomplete="off" value="<?php  if(isset($res2[0]['dis_val1']))echo $res2[0]['dis_val1'];?>">
                                            </div>
                                            
                                            <div class="col-md-6" style=" margin-top:50px;">
                                                  <label >Discount 1 Percentage Apply within days(Eg: 3%, 4% OF MRP in 30days)</label>
                                                  <input type="number" class="form-control" placeholder="30"     id="dis_day1"  autocomplete="off" value="<?php  if(isset($res2[0]['dis_day1']))echo $res2[0]['dis_day1'];?>">
                                            </div>
                                            
                                            <div class="col-md-6" style=" margin-top:50px;">
                                                  <label >Discount 2 Enter Percentage (Eg: 3%, 4% OF MRP)</label>
                                                  <input type="number" class="form-control"    id="dis_val2"  autocomplete="off" value="<?php  if(isset($res2[0]['dis_val2']))echo $res2[0]['dis_val2'];?>">
                                            </div>
                                            
                                            <div class="col-md-6" style=" margin-top:50px;">
                                                  <label >Discount 2 Percentage Apply within days(Eg: 3%, 4% OF MRP in 30days)</label>
                                                  <input type="number" class="form-control"    id="dis_day2"  autocomplete="off" value="<?php  if(isset($res2[0]['dis_day2']))echo $res2[0]['dis_day2'];?>">
                                            </div>
                                            
                                            <div class="col-md-6" style=" margin-top:50px;">
                                                  <label >Discount 3 Enter Percentage (Eg: 3%, 4% OF MRP)</label>
                                                  <input type="number" class="form-control"    id="dis_val3"  autocomplete="off" value="<?php  if(isset($res2[0]['dis_val3']))echo $res2[0]['dis_val3'];?>">
                                            </div>
                                            
                                            <div class="col-md-6" style=" margin-top:50px;">
                                                  <label >Discount 3 Percentage Apply within days(Eg: 3%, 4% OF MRP in 30days)</label>
                                                  <input type="number" class="form-control"    id="dis_day3"  autocomplete="off" value="<?php  if(isset($res2[0]['dis_day3']))echo $res2[0]['dis_day3'];?>">
                                            </div>
                                            -->
                                            <div class="col-md-12" style=" margin-top:10px;">
                                                       
                                                <?php 
                                                if($this->Company->customer_rate_entry_via_customer_add() == 'TRUE')
                                                {
                                                ?>              
                                                              
                                                              
                                                              <div class="col-md-12" >
                                                                  <h3 align="center">Product Rate Details</h3>
                                                              </div>
                                                              <!------------Row 3 start------------>
                                                              <div class="col-md-12" style=" margin-top:20px;"  >
                                                                <div class="row-fluid">
                                                                  <div class="span12" >
                                                                    <div class="widget-box">
                                                                      <!------------From start------------>
                                                                      <div class="widget-content nopadding">
                                                                        <div style=" margin-left:40px;">
                                                                            <input class="form-control-new" readonly  value="Description Of Goods" type="text" style=" height:30px; width:200px; border:none; background-color:#f7f7f5; margin-left:5px;" />
                                                                            <input class="form-control-new" readonly value="Rate (Discount)" type="text" style=" height:30px; width:100px; border:none; background-color:#f7f7f5;" />
                                                                            <input class="form-control-new" readonly value="Product Name" type="text" style=" height:30px; width:200px; border:none; background-color:#f7f7f5;" />
                                                                        </div>
                                                                        <?php 
                                                                        //----------------------------------update case
                                                                        if(!empty($res3))
                                                                        {
                                                                          $j=1000;
                                                                          foreach($res3 as $w)
                                                                          {
                                                                            
                                                                            $product_id2=$w['product_id'];
                                                                            $product2 = $this->Productmodel->get_product_column_data_with_id($product_id2,'name');
                                                                            $pname = $product2[0]['name'];	
                                                                            ?>
                                                                            
                                                                                <div id="readrootjr<?php echo $j;?>" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                                        <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_<?php echo $j;?>"><i class="nav-icon i-Close-Window" style="color:white;"></i></a>
                                                                                        
                                                                                        <input type="hidden"  class="details_id"  value="<?php echo $w['customer_rate_id'];?>" id="details_id_<?php echo $j;?>">
                                                                                        <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_<?php echo $j;?>" onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_rate')" value="<?php echo $pname;?>" />
                                                                                        <input type="hidden"   style="height:33px;   width:40px; " id="goods_<?php echo $j;?>"  name="goods[]" class="goods" placeholder="P.id" value="<?php echo $w['product_id'];?>"  />
                                                                                        <input type="number"   style="height:33px;   width:100px; margin-left:5px; " class="rate" id="rate_<?php echo $j;?>"  value="<?php echo $w['rate'];?>" />
                                                                                      <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="custname" id="custname_<?php echo $j;?>" value="<?php echo $w['custname'];?>"  />
                                                                                  </div>
                                                                            <?php
                                                                            $j++;
                                                                          }//foreach
                                                                        }// if(!empty($res3))
                                                                        else
                                                                        {
                                                                        ?>     
                                                                          <div id="readrootjr101" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                                  <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_"><i class="nav-icon i-Close-Window" style="color:white;"></i></a>
                                                                                  <input type="hidden"  class="details_id"  value="0" id="details_id_">
                                                                                  <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_rate')" />
                                                                                  <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />
                                                                                  <input type="number"   style="height:33px;   width:100px; margin-left:5px; " class="rate" id="rate_"  />
                                                                                  <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="custname" id="custname_"  />
                                                                          </div>
                                                                        <?php 
                                                                        }// if(!empty($res3))
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <span id="writerootjr"></span>
                                                                            <input type="button" id="moreFields" class="btn btn-warning pull-left" style="width:80px" onclick="javascript:moreFields1('readrootjr','writerootjr');" value="Add" /> 
                                                                        </div>   
                                                                        <br />
                                                                        <br />
                                                                        <br />
                                                                        <div id="readrootjr" style="display:none;  margin-bottom:20px; margin-top:10px;">
                                                                              <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_"><i class="nav-icon i-Close-Window" style="color:white;"></i></a>
                                                                              <input type="hidden"  class="details_id"  value="0" id="details_id_">
                                                                              <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_rate')" />
                                                                              <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />
                                                                              <input type="number"   style="height:33px;   width:100px; margin-left:5px; " class="rate" id="rate_"  />
                                                                              <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="custname" id="custname_"  />
                                                                        </div><!--readrootjr end-->
                                                            
                                                            </div>
                                                            <!------------form close------------>
                                                                        </div>			
                                                          </div>
                                                        </div>
                                                              </div>
                                                      <!------------Row 3 close------------>  
                                                <?php 
                                                }
                                                else
                                                {
                                                ?>             
                                                    <input type="hidden"  class="details_id"  value="0" id="details_id_">
                                                        <input type="hidden"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_" onKeyUp="fun_auto(this.id)" />
                                                        <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />
                                                        <input type="hidden"   style="height:33px;   width:100px; margin-left:5px; " class="rate" id="rate_"  />
                                                        <input type="hidden"   style="height:33px;   width:200px; margin-left:5px; " class="custname" id="custname_"  />              
                                                <?php
                                                }
                                                ?>


                                            </div><!---col-md-12---->

                                            <div class="col-md-6" style=" margin-top:10px;">
                                                    <label >TCS Charge Apply</label>
                                                    <select class="form-control"  name="is_tcs" id="is_tcs">
                                                        <option  <?php  if(isset($res2[0]['is_tcs'])){if($res2[0]['is_tcs']==1){echo "selected";}}?>  value="1">Yes</option>
                                                        <option  <?php if(isset($res2[0]['is_tcs'])){if($res2[0]['is_tcs']=='0'){echo "selected";}}?> value="0">No</option>
                                                    </select>
                                            </div>
                                                    
                                            <div class="col-md-6" style=" margin-top:10px;">
                                                    <label >Active / Deactive</label>
                                                    <select class="form-control"  name="active" id="active">
                                                        <option  <?php  if(isset($res2[0]['status'])){if($res2[0]['status']=='Active'){echo "selected";}}?>  value="Active">Active</option>
                                                        <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Deactive'){echo "selected";}}?> value="Deactive">Deactive</option>
                                                        <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Pending'){echo "selected";}}?> value="Pending">Pending</option>
                                                        <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Banned'){echo "selected";}}?> value="Banned">Banned</option>
                                                    </select>
                                            </div> 


                                            <div class="col-md-6">
                                                  <label >Our Sales Person Name</label>
                                                  <input type="text" class="form-control"   name="sales_person" id="sales_person" required  autocomplete="off" value="<?php if(isset($res2[0]['sales_person'])){echo $res2[0]['sales_person'];}?>">
                                            </div>


                                            <div class="col-md-6">
                                                  <label>Area Or Location</label>
                                                  <input type="text" class="form-control"   name="area_location" id="area_location" required  autocomplete="off" value="<?php if(isset($res2[0]['area_location'])){echo $res2[0]['area_location'];}?>">
                                            </div> 
                                            
                                            <div class="col-md-6">
                                                  <label for="exampleInputPassword1">Show in Follow Up List</label>
                                                    <select class="form-control" name="show_in_follow_up" id="show_in_follow_up">
                                                      <option  <?php if(isset($res2[0]['show_in_follow_up']))if($res2[0]['show_in_follow_up']==1){echo "selected";}?>  value="1">Yes</option>
                                                      <option  <?php if(isset($res2[0]['show_in_follow_up']))if($res2[0]['show_in_follow_up']!=1){echo "selected";}?> value="0">No</option>
                                                    </select>
                                            </div> 

                                            <div class="col-md-6">
                                                  <label for="exampleInputPassword1">Disputed Issue.</label>
                                                    <select class="form-control"  id="disputed_issue">
                                                      <option  <?php if(isset($res2[0]['disputed_issue']))if($res2[0]['disputed_issue']==1){echo "selected";}?>  value="1">Yes</option>
                                                      <option  <?php if(isset($res2[0]['disputed_issue']))if($res2[0]['disputed_issue']!=1){echo "selected";}?> value="0">No</option>
                                                    </select>
                                            </div> 
                                        
                                            
                                            
                                            
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="customer_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   


<?php $this->load->view('js/customer');?>
            
                                         
              
              
              
    
              
   
            






  