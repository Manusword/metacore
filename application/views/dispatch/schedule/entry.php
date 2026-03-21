        
<?php 
  if(isset($res2[0]['schedule_save_date'])){$entry_date = $this->Base->change_date_dmy($res2[0]['schedule_save_date']);}else{$entry_date=date('d-m-Y');}
  if(isset($res2[0]['customer_po_date'])){$customer_po_date = $this->Base->change_date_dmy($res2[0]['customer_po_date']);}else{$customer_po_date=date('d-m-Y');}
  
?>
        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Add Schedule</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Schedule</div>
                                    <div class="form-row">
                                      
                                     
                                 
                                    <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                    <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['schedule_id']))echo $res2[0]['schedule_id'];?>">
         
        
                                    


   
                                    <div class="col-md-4" style="margin-top:10px;">
                                            <label >Type Of Bill</label>
                                            <select  class="form-control"  style=" width: 100%" id="type_of_bill" >
                                                <option <?php if(isset($res2[0]['type_of_bill'])){if($res2[0]['type_of_bill']=='Tax Invoice'){echo "selected";}}?>>Tax Invoice</option>
                                                <option <?php if(isset($res2[0]['type_of_bill'])){if($res2[0]['type_of_bill']=='Rejection Invoice'){echo "selected";}}?>>Rejection Invoice</option>
                                            </select>
                                    </div> 
                                     
                                     
                                     
                                      <div class="col-md-4" style="margin-top:10px;">
                                                <label >Supplementary PO</label>
                                                     <select  class="form-control"  style=" width:100%" id="supply" >
                                                          <option <?php if(isset($res2[0]['supply'])){if($res2[0]['supply']=='0'){echo "selected";}}else{echo "selected";}?> value="0">NO</option>
                                                          <option <?php if(isset($res2[0]['supply'])){if($res2[0]['supply']=='1'){echo "selected";}}?> value="1">Yes</option>
                                                     </select>
                                        </div> 
                                     
                                        <div class="col-md-4" style="margin-top:10px;">
                                           <label >Schedule Date</label>
                                           <input type="text" name="entry_date" id="entry_date" class="form-control" placeholder="DD-MM-YYYY" value="<?php echo $entry_date;?>">  
                                        </div>

                                    
                                        <div class="col-md-3" style="margin-top:10px;">
                                           <label >Select Customer</label>
                                               <select  class="form-control"  style=" width: 100%" name="customer" id="customer"   <?php /*onChange="get_all_product_of_this_customer(this.value)"*/ ?> >
                                                    <option  <?php //if(isset($res2[0]['supplier_id'])){if($res2[0]['supplier_id']==''){echo "selected";}}?>  value="">Select</option>
                                                      <?Php 
                                                        foreach($customer as $c)
                                                        {
                                                            ?>
                                                              <option <?php if(isset($res2[0]['customer_id'])){if($res2[0]['customer_id']==$c['id']){ echo "selected";}}?>  value="<?php echo $c['id'];?>">
                                                                <?php echo $c['name'];?>
                                                              </option>
                                                            <?php
                                                        }//foreach
                                                      ?>		
                                              </select>
                                        </div>

                                        <?php /*
                                        <div class="col-md-3" style="margin-top:10px;">
                                           <label >Actual Month</label>
                                               <select  class="form-control"   id="actual_month"  >
                                                    <option  value="">Select</option>
                                                    <option <?php if(isset($res2[0]['actual_month'])){if($res2[0]['actual_month']==$c['id']){ echo "selected";}}?>>Dec 2023</option>
                                                    <option <?php if(isset($res2[0]['actual_month'])){if($res2[0]['actual_month']==$c['id']){ echo "selected";}}?>>Nov 2023</option>
                                                    <option <?php if(isset($res2[0]['actual_month'])){if($res2[0]['actual_month']==$c['id']){ echo "selected";}}?>>Oct 2023</option>
                                              </select>
                                        </div>

                                        */?>

                                        <div class="col-md-3" style="margin-top:10px;">
                                           <label>Actual Month</label>
                                           <input type="text" name="actual_month" id="actual_month" class="form-control" value="<?php if(isset($res2[0]['actual_month']))echo $res2[0]['actual_month'];?>" >  
                                        </div>
                                        

                                        <div class="col-md-3" style="margin-top:10px;">
                                           <label >Work Order No.</label>
                                           <input type="text" name="po_no" id="po_no" class="form-control" value="<?php if(isset($res2[0]['customer_po']))echo $res2[0]['customer_po'];?>" >  
                                        </div>
                                        

                                       <div class="col-md-3" style="margin-top:10px;">
                                           <label >Work Order Date <span style="color:blue">DD-MM-YYYY</span></label>
                                           <input type="text" name="po_date" id="po_date" class="form-control" placeholder="DD-MM-YYYY" value="<?php echo $customer_po_date;?>">  
                                        </div>
                                        
                                        



                                      
   
   
                                        
                                        
                                        <!------------Row 3 start------------>
                                        <div class="col-md-12"    style=" margin-top:50px;">
                                            <div class="row-fluid">
                                              <div class="span12" >
                                                <div class="widget-box">
                                                  
                                                                <!------------From start------------>
                                                                <div class="widget-content nopadding">
                                      


                                                                  <div style=" margin-left:40px;">
                                                                      <input class="form-control-new" readonly  value="Description" type="text" style=" height:30px; width:150px; border:none; background-color:#f7f7f5; margin-left:5px;" />
                                                                      <input class="form-control-new" readonly  value="Grade" type="text" style=" height:30px; width:100px; border:none; background-color:#f7f7f5; margin-left:5px;" />
                                                                      <input class="form-control-new" readonly  value="Oil / W.Oil" type="text" style=" height:30px; width:100px; border:none; background-color:#f7f7f5; margin-left:5px;" />
                                                                      
                                                                      <input class="form-control-new" readonly  value="Price"  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />
                                                                      
                                                                      <input class="form-control-new" readonly  value="Order Qty"  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly  value="Unit"  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly  value="Amount"  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly  value="From Date"  type="text" style=" height:30px; width:120px;border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly  value="To Date"  type="text" style=" height:30px; width:120px;border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly  value="Forecast Qty"  type="text" style=" height:30px; width:120px;border:none; background-color:#f7f7f5;" />
                                                                      <input class="form-control-new" readonly  value="Spec."  type="text" style=" height:30px; width:120px;border:none; background-color:#f7f7f5;" />

                                                                  </div>



                                                                        
                                                                  <?php 
                                                                  //----------------------------------update case
                                                                  if(isset($res3) and count($res3)>0)
                                                                  {
                                                                    $k=1000;
                                                                    foreach($res3 as $w)
                                                                    {
                                                                      $product_id2=$w['product_id'];
                                                                      $product2 = $this->Productmodel->get_product_column_data_with_id($product_id2,'name');
                                                                      $pname = $product2[0]['name'];	
                                                                            
                                                                      
                                                                      if(isset($w['from_date'])){$from_date1 = $this->Base->change_date_dmy($w['from_date']);}else{$from_date1 = "";}
                                                                      if(isset($w['to_date'])){$to_date1 = $this->Base->change_date_dmy($w['to_date']);}else{$to_date1 = "";}
                                                                      
                                                                      ?>
                                                                    
                                                                      <div id="readrootjr<?php echo $k;?>" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                              <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
                                                                                  <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                              </a>
                                                                              <input type="hidden" name="details_id[]" class="details_id"  value="<?php echo $w['details_id'];?>" id="details_id_<?php echo $k;?>">
                                                                             <?php /*
                                                                              <select  style="height:33px;   width:250px; margin-left:5px; " id="goods_<?php echo $k;?>" class="goods" onChange="get_customer_product_rate(this.id)">
                                                                                <?php
                                                                                  if(isset($res2[0]['customer_id']))
                                                                                  { 
                                                                                      $out1 = $this->Customermodel->get_customer_rate_with_id($res2[0]['customer_id']);
                                                                                      foreach($out1 as $o)
                                                                                      {
                                                                                          $pro = $this->Productmodel->get_product_data_with_id($o['product_id']);
                                                                                          ?>
                                                                                            <option <?php if($w['product_id']==$o['product_id']){echo "selected";}?>  value="<?php echo $o['product_id'];?>">
                                                                                              <?php echo $pro[0]['name'];?>
                                                                                            </option>
                                                                                          <?php
                                                                                      }//foreach
                                                                                  }//isset
                                                                                ?>
                                                                                </select>
                                                                                */?>

                                                                                <input type="text"   style="height:33px;   width:150px; margin-left:5px; " class="goods2" id="goods2_<?php echo $k;?>" onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_rate')" value="<?php echo $pname;?>" />
                                                                                <input type="hidden"   style="height:33px;   width:40px; " id="goods_<?php echo $k;?>"  name="goods[]" class="goods" placeholder="P.id" value="<?php echo $w['product_id'];?>"  />
                                                                                        



                                                                                <select id="grade_<?php echo $k;?>"  name="grade[]" class="grade" style="height:33px; width:100px; margin-left:5px; " >
                                                                                    <option value="">Select</option>
                                                                                    <?php
                                                                                      foreach($grade as $o)
                                                                                      {
                                                                                          $grade_id=$o['id'];
                                                                                          ?>
                                                                                              <option <?php if($w['product_grade']==$o['id']){echo "selected";}?> value="<?php echo $o['id'];?>"><?php echo $o['name'];?></option>
                                                                                          <?php
                                                                                      }
                                                                                    ?>
                                                                                </select>
                                                                              
                                                                                <select id="oil_"  name="oil[]" class="oil" style="height:33px; width:100px; margin-left:5px; " >
                                                                                  <option value="">Select</option>
                                                                                  <option <?php if($w['oil']=="Oil"){echo "selected";}?> value="Oil">Oil</option>
                                                                                  <option <?php if($w['oil']=="Without Oil"){echo "selected";}?> value="Without Oil">Without Oil</option>
                                                                                  <option <?php if($w['oil']=="Spool"){echo "selected";}?> value="Spool">Spool</option>
                                                                                </select>

                                                                                <input type="number"   style="height:33px; width:80px; " class="rate" id="rate_<?php echo $k;?>" name="rate[]"  value="<?php echo $w['rate'];?>" />
                                                                                
                                                                                <input type="number"   style="height:33px; width:80px; " class="order" id="order_<?php echo $k;?>" name="order[]" onKeyUp="fun_cal_cost(this.id)" value="<?php echo $w['order_qty'];?>" />
                                                                                
                                                                                <input type="text"   style="height:33px; width:80px; " class="unit" id="unit_<?php echo $k;?>" name="unit[]" value="<?php echo $w['unit'];?>" />

                                                                                <input type="text"   style="height:33px; width:80px; " class="cost" id="cost_<?php echo $k;?>" name="cost[]"  value="<?php echo $saved_amt[] = $w['amt'];?>"/>
                                                                                <input type="text"   style="height:33px; width:120px; " class="fromdate" id="fromdate_<?php echo $k;?>" name="fromdate[]" placeholder="DD-MM-YYYY" value="<?php echo $from_date1;?>"/>
                                                                                <input type="text"   style="height:33px; width:120px; " class="todate" id="todate_<?php echo $k;?>" name="todate[]" placeholder="DD-MM-YYYY" value="<?php echo $to_date1;?>"/>
                                                                                <input type="number"   style="height:33px; width:120px; " class="forecast" id="forecast_<?php echo $k;?>" name="forecast[]"  value="<?php echo $w['forecast_qty'];?>" />
                                                                                <input type="text"   style="height:33px; width:120px; " class="proremarks" id="proremarks_<?php echo $k;?>" name="proremarks[]"  value="<?php echo $w['proremarks'];?>" />
                                                                      
                                                                        </div>

                                                                      <?php
                                                                    $k++;
                                                                    }//foreach
                                                                  }
                                                                  else
                                                                  {
                                                                    ?>
                                                                      <div id="readrootjr101" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                          <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
                                                                              <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                          </a>
                                                                          <input type="hidden" name="details_id[]" class="details_id"  value="" id="details_id_">
                                                                          
                                                                          <?php /*
                                                                          <select id="goods_"  name="goods[]" class="goods" style="height:33px; width:250px; margin-left:5px; " onChange="get_customer_product_rate(this.id)">
                                                                              <option value="">Select</option>
                                                                          </select>
                                                                          */?>

                                                                          <input type="text"   style="height:33px;   width:150px; margin-left:5px; " class="goods2" id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_rate')" />
                                                                          <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />



                                                                         

                                                                          <select id="grade_"  name="grade[]" class="grade" style="height:33px; width:100px; margin-left:5px; " >
                                                                              <option value="">Select</option>
                                                                              <?php
                                                                                foreach($grade as $o)
                                                                                {
                                                                                    $grade_id=$o['id'];
                                                                                    ?>
                                                                                        <option value="<?php echo $o['id'];?>"><?php echo $o['name'];?></option>
                                                                                    <?php
                                                                                }
                                                                              ?>
                                                                          </select>

                                                                          <select id="oil_"  name="oil[]" class="oil" style="height:33px; width:100px; margin-left:5px; " >
                                                                              <option value="">Select</option>
                                                                              <option value="Oil">Oil</option>
                                                                              <option value="Without Oil">Without Oil</option>
                                                                              <option value="Spool">Spool</option>
                                                                          </select>

                                                                          <input type="number"   style="height:33px; width:80px; " class="rate" id="rate_" name="rate[]"  />
                                                                          <input type="number"   style="height:33px; width:80px; " class="order" id="order_" name="order[]" onKeyUp="fun_cal_cost(this.id)" />
                                                                          <input type="text"   style="height:33px; width:80px; " class="unit" id="unit_" name="unit[]" />
                                                                          
                                                                          <input type="text"   style="height:33px; width:80px; " class="cost" id="cost_" name="cost[]" />
                                                                          <input type="text"   style="height:33px; width:120px; " class="fromdate" id="fromdate_" name="fromdate[]" placeholder="DD-MM-YYYY" value="<?php echo date('d-m-Y');?>"/>
                                                                          <input type="text"   style="height:33px; width:120px; " class="todate" id="todate_" name="todate[]" placeholder="DD-MM-YYYY" value="<?php echo date('t-m-Y');?>" />
                                                                          <input type="number"   style="height:33px; width:120px; " class="forecast" id="forecast_" name="forecast[]"  />
                                                                          <input type="text"   style="height:33px; width:120px; " class="proremarks" id="proremarks_" name="proremarks[]"   />
                                                                      
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
                                                                      <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
                                                                          <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                      </a>
                                                                      <input type="hidden" name="details_id[]" class="details_id"  value="" id="details_id_">
                                                                      <?php /*
                                                                      <select id="goods_"  name="goods[]" class="goods" style="height:33px; width:250px; margin-left:5px; " onChange="get_customer_product_rate(this.id)">
                                                                        <option value="">Select</option>
                                                                            <?php
                                                                            if(isset($res2[0]['customer_id']))
                                                                            { 
                                                                                $customer_id= $res2[0]['customer_id'];
                                                                               $out1 = $this->Customermodel->get_customer_rate_with_id($customer_id);
                                                                                if(!empty($out1))
                                                                                {
                                                                                    foreach($out1 as $o)
                                                                                    {
                                                                                        $product_id=$o['product_id'];
                                                                                        $pro = $this->Productmodel->get_product_data_with_id($o['product_id']);
                                                                                    ?>
                                                                                        <option value="<?php echo $o['product_id'];?>"><?php echo $pro[0]['name'];?></option>
                                                                                    <?php
                                                                                    }
                                                                                }
                                                                        
                                                                            }
                                                                            ?>
                                                                      </select>
                                                                      */?>

                                                                        <input type="text"   style="height:33px;   width:150px; margin-left:5px; " class="goods2" id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_rate')" />
                                                                        <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />

                                                                      <select id="grade_"  name="grade[]" class="grade" style="height:33px; width:100px; margin-left:5px; " >
                                                                          <option value="">Select</option>
                                                                          <?php
                                                                            foreach($grade as $o)
                                                                            {
                                                                                $grade_id=$o['id'];
                                                                                ?>
                                                                                    <option value="<?php echo $o['id'];?>"><?php echo $o['name'];?></option>
                                                                                <?php
                                                                            }
                                                                          ?>
                                                                      </select>
                                                                      <select id="oil_"  name="oil[]" class="oil" style="height:33px; width:100px; margin-left:5px; " >
                                                                          <option value="">Select</option>
                                                                          <option value="Oil">Oil</option>
                                                                          <option value="Without Oil">Without Oil</option>
                                                                          <option value="Spool">Spool</option>
                                                                      </select>
                                                                      <input type="number"   style="height:33px; width:80px; " class="rate" id="rate_" name="rate[]"  />
                                                                      <input type="number"   style="height:33px; width:80px; " class="order" id="order_" name="order[]" onKeyUp="fun_cal_cost(this.id)" />
                                                                      <input type="text"   style="height:33px; width:80px; " class="unit" id="unit_" name="unit[]" />
                                                                      <input type="text"   style="height:33px; width:80px; " class="cost" id="cost_" name="cost[]" />
                                                                      <input type="text"   style="height:33px; width:120px; " class="fromdate" id="fromdate_" name="fromdate[]" placeholder="DD-MM-YYYY" value="<?php echo date('d-m-Y');?>"/>
                                                                      <input type="text"   style="height:33px; width:120px; " class="todate" id="todate_" name="todate[]" placeholder="DD-MM-YYYY" value="<?php echo date('t-m-Y');?>" />
                                                                      <input type="number"   style="height:33px; width:120px; " class="forecast" id="forecast_" name="forecast[]"  />
                                                                      <input type="text"   style="height:33px; width:120px; " class="proremarks" id="proremarks_" name="proremarks[]"   />
                                                                  </div>

                                                                                
                                            
                        
                        
                        
                        
                                                </div>
                                              <!------------form close------------>
                                                          </div>			
                                            </div>
                                          </div>
                                        </div>
                                        <!------------Row 3 close------------>  
   
   
    			
                                      
                                      
                                                          
   
                                        <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">   
            			                          <div class="panel-body">

                                              <div class="col-md-12" style="height:80px;">
                                                  <label  >Total Amount </label>
                                                <input type="text" class="form-control" id="total_amt" name="total_amt" value="<?php if(!empty($saved_amt)){ echo round(array_sum($saved_amt));}?>">
                                              </div>

                                              <div class="col-md-12" style="height:80px;">
                                                  <label  >Comment </label>
                                                  <textarea class="form-control" id="comment" name="comment"><?php if(isset($res2[0]['remarks'])){echo $res2[0]['remarks'];}?></textarea>
                                              </div>
                                        
                                            </div>
                                        </div>     
                                         
                                               
                                               
                                        <div class="col-md-12" style="margin-top:50px;">                            
                                          <div class="box-footer">
                                                <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                  Ready To Save <input type="checkbox"  id="chk" name="checkbox[]"    style="float:center">
                                                  <button type="button" class="btn btn-success" id="schedule_save" style="margin-left:50px;float:center" >Save</button>
                                                </div>
                                          </div>
                                        </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/dispatch_js');?>




