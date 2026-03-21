        
<?php 
  if(isset($res2[0]['entry_date'])){$entry_date = $this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date=date('d-m-Y');}
  if(isset($res2[0]['remarks'])){$remarks = $res2[0]['remarks'];}else{$remarks = "";}
?>
        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Add Dispatch</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Dispatch</div>
                                    <div class="form-row">
                                      
                                     
                                 
                                   

                                    <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                    <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['dispatch_id']))echo $res2[0]['dispatch_id'];?>">
                                    <input type="hidden" name="old_grand_total_amt" id="old_grand_total_amt"  value="<?php if(isset($res2[0]['grandtotal']))echo $res2[0]['grandtotal'];?>">

        
                                    <div class="col-md-3" >
                                        <label >Type Of Bill </label>
                                        <select  class="form-control"  style=" width: 100%" id="type_of_bill" >
                                          <option <?php if(isset($res2[0]['type_of_bill'])){if($res2[0]['type_of_bill']=='Tax Invoice'){echo "selected";}}?>>Tax Invoice</option>
                                          <option <?php if(isset($res2[0]['type_of_bill'])){if($res2[0]['type_of_bill']=='Rejection Invoice'){echo "selected";}}?>>Rejection Invoice</option>
                                        </select>
                                    </div>


                                                
                                    <div class="col-md-3">
                                          <label >Dispatch Date</label>
                                          <input type="text" class="form-control"     id="entry_date" required  autocomplete="off" value="<?php echo $entry_date;?>">
                                    </div>
                                    
                                    <div class="col-md-3">
                                          <label >Invoice No</label>
                                          <input type="number" class="form-control"     id="invoice_no" required  autocomplete="off" value="<?php if(isset($res2[0]['dispatch_no'])){echo $res2[0]['dispatch_no'];}?>">
                                    </div>
                                                 
                                    <div class="col-md-3">
                                        <label >Select Customer </label>
                                        <select  class="form-control"  style=" width: 100%" id="customer_id" onChange="fun_get_product_from_schedule_id2(this.value)">
                                              <option  <?php if(isset($res2[0]['customer_id'])){if($res2[0]['customer_id']==''){echo "selected";}}?>  value="">Select</option>
                                                <?Php 
                                                  foreach($customer as $c)
                                                  {
                                                    ?>
                                                      <option <?php if(isset($res2[0]['customer_id'])){if($res2[0]['customer_id']==$c['id']){echo "selected";}}?> value="<?php echo $c['id'];?>">
                                                          <?php echo $c['name'];?>
                                                      </option>
                                                    <?php
                                                  }
                                                ?>		
                                        </select>
                                    </div> 

                                  
                                    <?php 
                                    /*
				                             if(isset($res2[0]['customer_schedule_id']))
                                      {
                                        $customer_id =$res2[0]['customer_id'];
                                        $where="  customer_id='$customer_id' and stage='0' and status='Active' ";
                                        $out1=$this->Mymodel->select_where('customer_schedule',$where);
                                        if(!empty($out1))
                                        {
                                        ?>
                                          <div class="col-md-3" id="dis_pono">
                                              <label>P.O List</label>
                                              <select class="form-control" id="po_no"   onChange="fun_get_product_from_schedule_id(this.value)"  >
                                              <option value="">Select</option>
                                                <?php
                                                foreach($out1 as $o)
                                                {
                                                  ?>
                                                    <option <?php if(isset($res2[0]['customer_schedule_id'])){if($res2[0]['customer_schedule_id']==$o['schedule_id']){echo "selected";}}?> value="<?php echo $o['schedule_id'];?>"><?php echo $o['customer_po'];?></option>
                                                  <?php
                                                }
                                              ?>
                                              </select>
                                          </div>
                                        <?php
                                        }
                                      }
                                      else
                                      {
                                          ?>
                                            <div class="col-md-3" >
                                                <label>P.O List </label>
                                                <select  class="form-control"  style=" width: 100%" id="po_no" onChange="fun_get_product_from_schedule_id(this.value)" >
                                                  <option value="">Select</option>
                                                </select>
                                            </div> 
                                          <?php
                                      }
                                      */
                                      ?>
                                       
                                    
                                                              
                                                              
                                    <div class="col-md-3">
                                          <label >Transport Mode </label>
                                          <input type="text" class="form-control"   id="transport_mode"   autocomplete="off" value="<?php if(isset($res2[0]['transport_mode']))echo $res2[0]['transport_mode'];?>">
                                    </div>
                                    
                                    <div class="col-md-3">
                                          <label >Vehicle No. </label>
                                          <input type="text" class="form-control"   id="vehicle_no"   autocomplete="off" value="<?php if(isset($res2[0]['vehicle_no']))echo $res2[0]['vehicle_no'];?>">
                                    </div>
                                
                                
                              
                                    <div class="col-md-3">
                                        <label >Place Of Supply (Destination) </label>
                                        <input type="text" class="form-control"   id="place_of_supply"   autocomplete="off" value="<?php if(isset($res2[0]['place_of_supply']))echo $res2[0]['place_of_supply'];?>">
                                    </div>
                                      

                                    <div class="col-md-3" >
                                        <label >Export Bill?</label>
                                        <select  class="form-control"  style=" width:100%" id="isexport" >
                                              <option <?php if(isset($res2[0]['isexport'])){if($res2[0]['isexport']=='No'){echo "selected";}}?> value="No">No</option>
                                              <option <?php if(isset($res2[0]['isexport'])){if($res2[0]['isexport']=='Yes'){echo "selected";}}?> value="Yes">Yes</option>
                                        </select>
                                    </div>      

                                    
                                    
                                    <div class="col-md-3" >
                                      <!--<label >Discount Offer in %</label>-->
                                      <input type="hidden" class="form-control"   id="discount_offer" onKeyUp="fun_extra_discount_percent(this.value)"  autocomplete="off" value="<?php if(isset($res2[0]['discount_offer']))echo $res2[0]['discount_offer'];?>">
                                    </div>
                                    
                                                
   

   
                                        
                                        
                                        <!------------Row 3 start------------>
                                        <div class="col-md-12"    style=" margin-top:50px;">
                                            <div class="row-fluid">
                                              <div class="span12" >
                                                <div class="widget-box">
                                                  
                                                                <!------------From start------------>
                                                                <div class="widget-content nopadding">
                                      
                                                                    <div style=" margin-left:40px;">
                                                                      <input class="form-control-new" readonly  value="Description Of Goods" type="text" style=" height:30px; width:200px; border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly value="Total Qty" type="text" style=" height:30px; width:80px; border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly value="Send" type="text" style=" height:30px; width:80px; border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly value="Dispatch Qty" type="text" style=" height:30px; width:100px; border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly value="Unit" type="text" style=" height:30px; width:70px; border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly value="HSN Code" type="text" style=" height:30px; width:70px; border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly  value="Pckgs No."  type="text" style=" height:30px; width:70px;border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly value="Rate" type="text" style=" height:30px; width:80px; border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly value="Total Amount" type="text" style=" height:30px; width:100px;margin-left:0px; border:none; background-color:#f7f7f5;" />
                                                                    </div>
                                                                    
                                                                    <?php 
                                                                    if(isset($res3) and count($res3)>0)
                                                                    {
                                                                      $c=1000;
                                                                      foreach($res3 as $w)
                                                                      {
                                                                          $product_id = $w['product_id'];
                                                                          $pro2 = $this->Productmodel->get_product_data_with_id($product_id);
                                                                          ?>
                                                                          <div id="readrootjr101" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                              <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_"><i class="nav-icon i-Close-Window" style="color:white;"></i></a>
                                                                              <input type="hidden" name="dispatch_details_id[]" class="dispatch_details_id"  value="<?php if(isset($w['dispatch_details_id'])){echo $w['dispatch_details_id'];}else{echo 0;}?>" id="dispatch_details_id_<?php echo $c;?>">
                                                                              <input type="hidden" name="oldgoodsid[]" class="oldgoodsid"  value="<?php if(isset($w['customer_schedule_details_id'])){echo $w['customer_schedule_details_id'];}?>" id="oldgoodsid_<?php echo $c;?>">
                                                                              <input type="hidden" name="oldqty[]" class="oldqty"  value="<?php if(isset($w['qty'])){echo $w['qty'];}?>" id="oldqty_<?php echo $c;?>">
                                                                              <input type="hidden" name="oldamt[]" class="oldamt"  value="<?php if(isset($w['total_amt'])){echo $w['total_amt'];}?>" id="oldamt_<?php echo $c;?>">
                                                                             
                                                                                    <select  style="height:33px;   width:200px; margin-left:5px; " id="goods_<?php echo $c;?>" class="goods" onChange="fun_product_in_dispatch(this.id,1)">
                                                                                    <option value="">Select</option>
                                                                                    <?php
                                                                                    /*
                                                                                    if(isset($res2[0]['customer_schedule_id']))
                                                                                    { 
                                                                                      $schedule_id =$res2[0]['customer_schedule_id'];
                                                                                      $customer_id= $res2[0]['customer_id'];
                                                                                      $out1 = $this->Dispatchmodel->get_customer_schedule_details_data_with_id($schedule_id);
                                                                                      if(!empty($out1))
                                                                                      {
                                                                                         foreach($out1 as $o)
                                                                                          {
                                                                                              $product_id=$o['product_id'];
                                                                                              $pro =$this->Productmodel->get_product_data_with_id($product_id);
                                                                          
                                                                                              //---------getting product name by custome 
                                                                                              $rate = $this->Customermodel->get_customer_product_rate($customer_id,$product_id);
                                                                                              if(!empty($rate))
                                                                                              {
                                                                                                  $custname= ' "'.$rate[0]['custname'].'"';
                                                                                              }
                                                                                              else
                                                                                              {
                                                                                                  $custname='';
                                                                                              }
                                                                                              ?>
                                                                                                  <option <?php if(isset($w['customer_schedule_details_id'])){if($w['customer_schedule_details_id']==$o['details_id']){echo "selected";}}?> value="<?php echo $o['details_id'];?>">
                                                                                                      <?php echo $pro[0]['name'].' '.$custname.', (Rate: '.$o['rate'].', Qty: '.$o['order_qty'].')';?>
                                                                                                  </option>
                                                                                              <?php 
                                                                                          }//foreach
                                                                                      }//if(!empty($out1))
                                                                                    }//if(isset($res2[0]['customer_schedule_id']))
                                                                                    */
                                                                                    if(isset($res2[0]['customer_id']))
                                                                                    {
                                                                                      $customer_id= $res2[0]['customer_id'];
                                                                                      $sch = $this->Dispatchmodel->get_customer_schedule_list($customer_id,date('Y-m-01'),date('Y-m-31'));
                                                                                      if(!empty($sch)){
                                                                                        foreach($sch as $s){
                                                                                          //getting all schedule data
                                                                                          $schedule_id = $s['schedule_id'];
                                                                                          ?><option value="" disabled>Schedule No : <?php echo $s['customer_po'];?></option><?php
                                                                                          //-----------------------
                                                                                          //$schedule_id =$res2[0]['customer_schedule_id'];
                                                                                          //$customer_id= $res2[0]['customer_id'];
                                                                                          $out1 = $this->Dispatchmodel->get_customer_schedule_details_data_with_id($schedule_id);
                                                                                          if(!empty($out1))
                                                                                          {
                                                                                            foreach($out1 as $o)
                                                                                              {
                                                                                                  $product_id=$o['product_id'];
                                                                                                  $pro =$this->Productmodel->get_product_data_with_id($product_id);
                                                                              
                                                                                                  //---------getting product name by custome 
                                                                                                  $rate = $this->Customermodel->get_customer_product_rate($customer_id,$product_id);
                                                                                                  if(!empty($rate))
                                                                                                  {
                                                                                                      $custname= ' "'.$rate[0]['custname'].'"';
                                                                                                  }
                                                                                                  else
                                                                                                  {
                                                                                                      $custname='';
                                                                                                  }
                                                                                                  ?>
                                                                                                      <option <?php if(isset($w['customer_schedule_details_id'])){if($w['customer_schedule_details_id']==$o['details_id']){echo "selected";}}?> value="<?php echo $o['details_id'];?>">
                                                                                                          <?php echo $pro[0]['name'].' '.$custname.', (Rate: '.$o['rate'].', Qty: '.$o['order_qty'].')';?>
                                                                                                      </option>
                                                                                                  <?php 
                                                                                              }//foreach
                                                                                          }//if(!empty($out1))
                                                                                          //--------------------------
                                                                                         
                                                                                        }//sch id
                                                                                      }//sch
                                                                                          
                                                                                    }//customer_id
                                                                                    
                                                                                    ?>
                                                                                    </select>
                                                                                    
                                                                                <input type="text"   style="height:33px;   width:80px;  background-color:#f7f7f5; " readonly id="totalqty_<?php echo $c;?>" name="totalqty[]" class="totalqty"  />
                                                                                <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " readonly id="recqty_<?php echo $c;?>" name="recqty[]" class="recqty" />
                                                                                <input type="number"   style="height:33px; width:100px;   " class="amount_weight" id="net_<?php echo $c;?>" name="net[]"  onKeyUp="fun_price_dispatch(this.id)" value="<?php if(isset($w['qty'])){echo $w['qty'];}?>"  />
                                                                                <input type="text"   style="height:33px;   width:70px;   " id="unitname_<?php echo $c;?>" name="unitname]" class="unitname" value="<?php if(isset($w['unit_name'])){echo $w['unit_name'];}else{ echo "MT";}?>"  />
                                                                                <input type="number"   style="height:33px;   width:70px;  " id="hsn_<?php echo $c;?>" name="hsn[]" class="hsn" value="<?php if(isset($w['hsn'])){echo $w['hsn'];}else{ echo "7312";}?>"  />
                                                                                <input type="text"   style="height:33px; width:70px;  "  id="package_<?php echo $c;?>" name="package[]" class="package" value="<?php if(isset($w['package_no'])){echo $w['package_no'];}?>"  />
                                                                                <input type="number"   style="height:33px;   width:80px;   " id="price_<?php echo $c;?>" name="price[]"  class="price" value="<?php if(isset($w['rate'])){echo $w['rate'];}?>"  onKeyUp="fun_price_dispatch(this.id)" />
                                                                                <input type="number"   style="height:33px; width:100px;  " class="total_amount" id="amount_<?php echo $c;?>" name="amount[]" value="<?php if(isset($w['total_amt'])){echo $w['total_amt'];}?>"  />
                                                                                <span id="discountdetails_<?php echo $c;?>"></span>
                                                                            </div>
                                                                          <?php 
                                                                        $c++;
                                                                      }//foreach
                                                                    }
                                                                    else
                                                                    {
                                                                      ?>
                                                                      <div id="readrootjr101" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                          <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_"><i class="nav-icon i-Close-Window" style="color:white;"></i></a>
                                                                          <input type="hidden" name="dispatch_details_id[]" class="dispatch_details_id"  value="" id="dispatch_details_id_">
                                                                          <input type="hidden" name="oldgoodsid[]" class="oldgoodsid"  value="" id="oldgoodsid_">
                                                                          <input type="hidden" name="oldqty[]" class="oldqty"  value="" id="oldqty_">
                                                                          <input type="hidden" name="oldamt[]" class="oldamt"  value="" id="oldamt_">
                                                                          <select  style="height:33px;   width:200px; margin-left:5px; " id="goods_" class="goods" onChange="fun_product_in_dispatch(this.id,1)">
                                                                            <option value="">Select</option>
                                                                          </select>
                                                                          <input type="text"   style="height:33px;   width:80px;  background-color:#f7f7f5; " readonly id="totalqty_" name="totalqty[]" class="totalqty"  />
                                                                          <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " readonly id="recqty_" name="recqty[]" class="recqty"  />
                                                                          <input type="number"   style="height:33px; width:100px;   " class="amount_weight" id="net_" name="net[]"  onKeyUp="fun_price_dispatch(this.id)"  />
                                                                          <input type="text"   style="height:33px;   width:70px;   " id="unitname_" name="unitname]" class="unitname" value="MT" />
                                                                          <input type="number"   style="height:33px;   width:70px;  " id="hsn_" name="hsn[]" class="hsn" value=""  />
                                                                          <input type="text"   style="height:33px; width:70px;  "  id="package_" name="package[]" class="package"  />
                                                                          <input type="number"   style="height:33px;   width:80px;   " id="price_" name="price[]" class="price"   onKeyUp="fun_price_dispatch(this.id)"  />
                                                                          <input type="number"   style="height:33px; width:100px;  " class="total_amount" id="amount_" name="amount[]"  />
                                                                          <span id="discountdetails_"></span>
                                                                      </div>
                                                                      <?php
                                                                    }
                                                                    ?>
                                                                  
                                                                  <div class="form-group">
                                                                      <span id="writerootjr"></span>
                                                                      <input type="button" id="moreFields" class="btn btn-warning pull-left" style="width:80px" onclick="javascript:moreFields1('readrootjr','writerootjr');"  value="Add" /> 
                                                                  </div>   
                                                                  
                                                                  <br />
                                                                  <br />
                                                                  <br />
                                                                  
                                                                  <div id="readrootjr" style="display:none;  margin-bottom:20px; margin-top:10px;">
                                                                      <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_"><i class="nav-icon i-Close-Window" style="color:white;"></i></a>
                                                                      <input type="hidden" name="dispatch_details_id[]" class="dispatch_details_id"  value="" id="dispatch_details_id_">
                                                                      <input type="hidden" name="oldgoodsid[]" class="oldgoodsid"  value="" id="oldgoodsid_">
                                                                      <input type="hidden" name="oldqty[]" class="oldqty"  value="" id="oldqty_">
                                                                      <input type="hidden" name="oldamt[]" class="oldamt"  value="" id="oldamt_">
                                                                      <select  style="height:33px;   width:200px; margin-left:5px; " id="goods_" class="goods" onChange="fun_product_in_dispatch(this.id,1)">
                                                                        <option value="">Select</option>
                                                                        <?php
                                                                                   /*
                                                                                   if(isset($res2[0]['customer_schedule_id']))
                                                                                    { 
                                                                                      $schedule_id =$res2[0]['customer_schedule_id'];
                                                                                      $customer_id= $res2[0]['customer_id'];
                                                                                      $out1 = $this->Dispatchmodel->get_customer_schedule_details_data_with_id($schedule_id);
                                                                                      if(!empty($out1))
                                                                                      {
                                                                                         foreach($out1 as $o)
                                                                                          {
                                                                                              $product_id=$o['product_id'];
                                                                                              $pro =$this->Productmodel->get_product_data_with_id($product_id);
                                                                          
                                                                                              //---------getting product name by custome 
                                                                                              $rate = $this->Customermodel->get_customer_product_rate($customer_id,$product_id);
                                                                                              if(!empty($rate))
                                                                                              {
                                                                                                  $custname= ' "'.$rate[0]['custname'].'"';
                                                                                              }
                                                                                              else
                                                                                              {
                                                                                                  $custname='';
                                                                                              }
                                                                                              ?>
                                                                                                  <option  value="<?php echo $o['details_id'];?>">
                                                                                                      <?php echo $pro[0]['name'].' '.$custname.', (Rate: '.$o['rate'].', Qty: '.$o['order_qty'].')';?>
                                                                                                  </option>
                                                                                              <?php 
                                                                                          }//foreach
                                                                                      }//if(!empty($out1))
                                                                                    }//if(isset($res2[0]['customer_schedule_id']))
                                                                                    */
                                                                                    if(isset($res2[0]['customer_id']))
                                                                                    {
                                                                                      $customer_id= $res2[0]['customer_id'];
                                                                                      $sch = $this->Dispatchmodel->get_customer_schedule_list($customer_id,date('Y-m-01'),date('Y-m-31'));
                                                                                      if(!empty($sch)){
                                                                                        foreach($sch as $s){
                                                                                          //getting all schedule data
                                                                                          $schedule_id = $s['schedule_id'];
                                                                                          ?><option value="" disabled>Schedule No : <?php echo $s['customer_po'];?></option><?php
                                                                                          //-----------------------
                                                                                          //$schedule_id =$res2[0]['customer_schedule_id'];
                                                                                          //$customer_id= $res2[0]['customer_id'];
                                                                                          $out1 = $this->Dispatchmodel->get_customer_schedule_details_data_with_id($schedule_id);
                                                                                          if(!empty($out1))
                                                                                          {
                                                                                            foreach($out1 as $o)
                                                                                              {
                                                                                                  $product_id=$o['product_id'];
                                                                                                  $pro =$this->Productmodel->get_product_data_with_id($product_id);
                                                                              
                                                                                                  //---------getting product name by custome 
                                                                                                  $rate = $this->Customermodel->get_customer_product_rate($customer_id,$product_id);
                                                                                                  if(!empty($rate))
                                                                                                  {
                                                                                                      $custname= ' "'.$rate[0]['custname'].'"';
                                                                                                  }
                                                                                                  else
                                                                                                  {
                                                                                                      $custname='';
                                                                                                  }
                                                                                                  ?>
                                                                                                     <option  value="<?php echo $o['details_id'];?>">
                                                                                                      <?php echo $pro[0]['name'].' '.$custname.', (Rate: '.$o['rate'].', Qty: '.$o['order_qty'].')';?>
                                                                                                  </option>
                                                                                                  <?php 
                                                                                              }//foreach
                                                                                          }//if(!empty($out1))
                                                                                          //--------------------------
                                                                                         
                                                                                        }//sch id
                                                                                      }//sch
                                                                                          
                                                                                    }//customer_id
                                                                                    
                                                                                    ?>
                                                                      </select>
                                                                      <input type="text"   style="height:33px;   width:80px;  background-color:#f7f7f5; " readonly id="totalqty_" name="totalqty[]" class="totalqty"  />
                                                                      <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " readonly id="recqty_" name="recqty[]" class="recqty"  />
                                                                      <input type="number"   style="height:33px; width:100px;   " class="amount_weight" id="net_" name="net[]"  onKeyUp="fun_price_dispatch(this.id)"  />
                                                                      <input type="text"   style="height:33px;   width:70px;   " id="unitname_" name="unitname]" class="unitname" value="MT" />
                                                                      <input type="number"   style="height:33px;   width:70px;  " id="hsn_" name="hsn[]" class="hsn" value=""  />
                                                                      <input type="text"   style="height:33px; width:70px;  "  id="package_" name="package[]" class="package"  />
                                                                      <input type="number"   style="height:33px;   width:80px;   " id="price_" name="price[]" class="price"   onKeyUp="fun_price_dispatch(this.id)" />
                                                                      <input type="number"   style="height:33px; width:100px;  " class="total_amount" id="amount_" name="amount[]"  />
                                                                      <span id="discountdetails_"></span>
                                                                  </div><!--readrootjr end-->


                        
                                                                </div>
                                                <!------------form close------------>
                                                </div>			
                                            </div>
                                          </div>
                                        </div>
                                        <!------------Row 3 close------------>  
   
                                                                        
    			
                                    <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
                                      <div style=" height:1px; width:100%; background-color:#74767d"></div>
                                    </div>
                                      
                                    <div class="col-md-12" style="margin-top:10px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">Total</label>
                                        <div class="col-sm-2" style="float:left"></div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="total_old"   value="<?php if(!empty($res2[0]['total_before_dis'])){echo $res2[0]['total_before_dis'];}else{if(isset($res2[0]['total'])){echo $res2[0]['total'];}}?>"  onKeyUp="fun_grand_total()">
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-md-12" style="margin-top:5px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">
                                          Scheme /Extra / Cash Discount (If Any)              	
                                        </label>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="other_discount_per" onkeyup="fun_grand_total()"   value="<?php if(isset($res2[0]['other_discount_per'])){if($res2[0]['other_discount_per']>0){echo $res2[0]['other_discount_per'];}else{echo "0";}}else{echo "0";}?>"   >                
                                        </div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="discount"   value="<?php if(isset($res2[0]['discount'])){if($res2[0]['discount']>0){echo $res2[0]['discount'];}else{echo "0.00";}}else{echo "0.00";}?>"   >                
                                        </div>
                                    </div> 


                                    <?php 
                                      // TDS Cost   enable or diable
                                      if($this->Company->dispatch_entry_charge_apply_tds() == "TRUE")
                                      {
                                        ?>
                                        <div class="col-md-12" style="margin-top:5px;" style="float:left">
                                            <div class="col-sm-4" style="float:left"></div>
                                            <label for="input-Default" class="col-sm-4 control-label" style="float:left">
                                                TOD Charge (%)         	
                                            </label>
                                            <div class="col-sm-2" style="float:left">
                                                <input type="number" class="form-control" id="tod_per" onkeyup="fun_grand_total()"   value="<?php if(isset($res2[0]['tod_per'])){if($res2[0]['tod_per']>0){echo $res2[0]['tod_per'];}else{echo "0.00";}}else{echo "0";}?>"   >                
                                            </div>
                                            <div class="col-sm-2" style="float:left">
                                                <input type="number" class="form-control" id="tod_cost_val"   value="<?php if(isset($res2[0]['tod_cost_val'])){if($res2[0]['tod_cost_val']>0){echo $res2[0]['tod_cost_val'];}else{echo "0.00";}}else{echo "0.00";}?>"   >                
                                            </div>
                                        </div> 
                                        <?php 
                                      }
                                      else
                                      {
                                        ?>
                                        <input type="hidden" class="form-control" id="tod_per" onkeyup="fun_grand_total()"   value="<?php if(isset($res2[0]['tod_per'])){if($res2[0]['tod_per']>0){echo $res2[0]['tod_per'];}else{echo "0.00";}}else{echo "0.00";}?>"   >                
                                        <input type="hidden" class="form-control" id="tod_cost_val"   value="<?php if(isset($res2[0]['tod_cost_val'])){if($res2[0]['tod_cost_val']>0){echo $res2[0]['tod_cost_val'];}else{echo "0.00";}}else{echo "0.00";}?>"   >                
                                        <?php
                                      }
                                    ?>                                 


                                    <?php 
                                      // Amortisation Cost   enable or diable
                                      if($this->Company->dispatch_entry_charge_apply_amortisation() == "TRUE")
                                      {
                                        ?>
                                        <div class="col-md-12" style="margin-top:5px;" style="float:left">
                                            <div class="col-sm-4" style="float:left"></div>
                                            <label for="input-Default" class="col-sm-4 control-label" style="float:left">
                                                Amortisation Cost          	
                                            </label>
                                            <div class="col-sm-2" style="float:left">
                                                <input type="number" class="form-control" id="amortisation_cost_per" onkeyup="fun_grand_total()"   value="<?php if(isset($res2[0]['amortisation_cost_per'])){if($res2[0]['amortisation_cost_per']>0){echo $res2[0]['amortisation_cost_per'];}else{echo "0.00";}}else{echo "0.00";}?>"   >                
                                            </div>
                                            <div class="col-sm-2" style="float:left">
                                                <input type="number" class="form-control" id="amortisation_cost_val"   value="<?php if(isset($res2[0]['amortisation_cost_val'])){if($res2[0]['amortisation_cost_val']>0){echo $res2[0]['amortisation_cost_val'];}else{echo "0.00";}}else{echo "0.00";}?>"   >                
                                            </div>
                                        </div> 
                                        <?php 
                                      }
                                      else
                                      {
                                        ?>
                                          <input type="hidden" class="form-control" id="amortisation_cost_per" onkeyup="fun_grand_total()"   value="<?php if(isset($res2[0]['amortisation_cost_per'])){if($res2[0]['amortisation_cost_per']>0){echo $res2[0]['amortisation_cost_per'];}else{echo "0.00";}}else{echo "0.00";}?>"   >                
                                          <input type="hidden" class="form-control" id="amortisation_cost_val"   value="<?php if(isset($res2[0]['amortisation_cost_val'])){if($res2[0]['amortisation_cost_val']>0){echo $res2[0]['amortisation_cost_val'];}else{echo "0.00";}}else{echo "0.00";}?>"   >                
                                        <?php
                                      }
                                    ?>


                                    <div class="col-md-12" style="margin-top:10px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left"><b>Total Taxable Amount </b></label>
                                        <div class="col-sm-2" style="float:left"></div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="taxable_amt"   value="<?php if(isset($res2[0]['total'])){echo $res2[0]['total'];}?>"  onKeyUp="fun_grand_total()">
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
                                      <div style=" height:1px; width:100%; background-color:#74767d"></div>
                                    </div>
                                    

                                    <div class="col-md-12" style="margin-top:10px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">Freight Charges</label>
                                        <div class="col-sm-2" style="float:left"></div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="ffc_amt"   value="<?php if(isset($res2[0]['ffc_amt'])){echo $res2[0]['ffc_amt'];}else{ echo "0.00";}?>"  onKeyUp="fun_grand_total()">
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-12" style="margin-top:10px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">Labour Charges</label>
                                        <div class="col-sm-2" style="float:left"></div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="laber_charge"  value="<?php if(isset($res2[0]['laber_charge'])){echo $res2[0]['laber_charge'];}else{ echo "0.00";}?>"   onKeyUp="fun_grand_total()">
                                        </div>
                                    </div>
                              

                                    <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
                                      <div style=" height:1px; width:100%; background-color:#74767d"></div>
                                    </div>
                                  
                                
                                    <div class="col-md-12" style="margin-top:5px;">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left"></label>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="text" class="form-control"  value="GST (%)" readonly >
                                        </div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="text" class="form-control"  value="Amount" readonly>
                                        </div>
                                    </div>   
                                    
                                    
                                    <div class="col-md-12" style="margin-top:5px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">
                                          SGST                 	
                                        </label>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="sgst_per"  onKeyUp="fun_sgst()"  value="<?php if(isset($res2[0]['sgst_per']))echo $res2[0]['sgst_per'];?>" >
                                        </div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="sgst_val"   value="<?php if(isset($res2[0]['sgst_val']))echo $res2[0]['sgst_val'];?>"   >
                                        </div>
                                    </div>      
                                    
                                      
                                    <div class="col-md-12" style="margin-top:5px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">
                                          CGST                 	
                                        </label>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="cgst_per"  onKeyUp="fun_cgst()"  value="<?php if(isset($res2[0]['cgst_per']))echo $res2[0]['cgst_per'];?>" >
                                        </div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="cgst_val"   value="<?php if(isset($res2[0]['cgst_val']))echo $res2[0]['cgst_val'];?>"   >
                                        </div>
                                    </div>      
                                    

                                    <div class="col-md-12" style="margin-top:5px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">
                                          IGST                 	
                                        </label>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="igst_per"  onKeyUp="fun_igst()"  value="<?php if(isset($res2[0]['igst_per']))echo $res2[0]['igst_per'];?>" >
                                        </div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="igst_val"   value="<?php if(isset($res2[0]['igst_val']))echo $res2[0]['igst_val'];?>"   >
                                        </div>
                                    </div>      
                                    
                                      
                                    <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
                                      <div style=" height:1px; width:100%; background-color:#74767d"></div>
                                    </div>


                                    <div class="col-md-12"style="margin-top:5px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">Round OFF / Other Charges </label>
                                        <div class="col-sm-2" style="float:left"></div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="roundoff"  placeholder=".00"  onKeyUp="fun_grand_total()" value="<?php if(isset($res2[0]['roundoff']))echo $res2[0]['roundoff'];?>">
                                        </div>
                                    </div>

                                    <div class="col-md-12"style="margin-top:5px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">Sub Total </label>
                                        <div class="col-sm-2" style="float:left"></div>
                                        <div class="col-sm-2" style="float:left">
                                          <input type="number" class="form-control" id="grandtotal"  readonly value="<?php if(isset($res2[0]['grandtotal']))echo $res2[0]['grandtotal'];?>">
                                        </div>
                                    </div>
            
           

                                    <?php 
                                      // TDS
                                      if($this->Company->dispatch_entry_charge_apply_tcs() == "TRUE")
                                      {
                                         $tds_def_per = $this->Company->dispatch_entry_charge_apply_tcs_val();
                                          ?>
                                            <div class="col-md-12" style="margin-top:5px;" style="float:left"> 
                                                <div class="col-sm-4" style="float:left"></div>
                                                <label for="input-Default" class="col-sm-4 control-label" style="float:left">
                                                    TCS (%)                	
                                                </label>
                                                <div class="col-sm-2" style="float:left">
                                                    <input type="text" class="form-control" id="tds_per"   onKeyUp="fun_grand_total()"  value="<?php if(isset($res2[0]['tds_per'])){echo $res2[0]['tds_per'];}else{echo $tds_def_per;}?>" >
                                                </div>
                                                <div class="col-sm-2" style="float:left">
                                                    <input type="text" class="form-control" id="tds_val"   value="<?php if(isset($res2[0]['tds_val']))echo $res2[0]['tds_val'];?>"   >
                                                </div>
                                            </div>      
                                          <?php 
                                      }
                                      else
                                      {
                                          ?>
                                              <input type="hidden" class="form-control" id="tds_per"  onKeyUp="tds_per()"  value="<?php if(isset($res2[0]['tds_per']))echo $res2[0]['tds_per'];?>" > 
                                              <input type="hidden" class="form-control" id="tds_val"   value="<?php if(isset($res2[0]['tds_val']))echo $res2[0]['tds_val'];?>"   >      
                                          <?php
                                      }
                                    ?> 

                                    <div class="col-md-12" style=" margin-top:10px;" style="float:left">
                                        <div class="col-sm-4" style="float:left"></div>
                                        <label for="input-Default" class="col-sm-2 control-label" style="float:left">Grand Total    </label>
                                        <div class="col-sm-2" style="float:left">
                                          <b></b>
                                        </div>
                                        <div class="col-sm-2" style="float:left"></div>
                                        <div class="col-sm-2" style="float:left">
                                            <input type="number" class="form-control" id="grandtotal2"  readonly value="<?php if(isset($res2[0]['grandtotal2']))echo $res2[0]['grandtotal2'];?>">
                                        </div>
                                    </div>
    
                                    
                                    <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
                                      <div style=" height:1px; width:100%; background-color:#74767d"></div>
                                    </div>
   
   
            
                                    <div class="col-md-4" style="margin-top:30px; margin-bottom:30px; float:right;">   
                                          <div class="panel-body">
                                            <div class="col-md-12" style="height:100px;">
                                              <label  >Remarks </label>
                                              <textarea class="form-control" id="remarks"><?php if(isset($remarks)){echo $remarks;}?></textarea>
                                            </div>
                                          </div>
                                    </div>   
 
            
            
                                    <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
                                      <div style=" height:1px; width:100%; background-color:#74767d"></div>
                                    </div>  



                                         
                                               
                                               
                                        <div class="col-md-12" style="margin-top:50px;">                            
                                          <div class="box-footer">
                                                <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                  Ready To Save <input type="checkbox"  id="chk" name="checkbox[]"    style="float:center">
                                                  <button type="button" class="btn btn-success" id="dispatch_save" style="margin-left:50px;float:center" >Save</button>
                                                </div>
                                          </div>
                                        </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/dispatch_js');?>




