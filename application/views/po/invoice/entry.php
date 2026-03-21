<?php 
  if(isset($res2[0]['product_invoice_save_date'])){
    $product_invoice_save_date1 = $this->Base->change_date_dmy($res2[0]['product_invoice_save_date']);}
  else{$product_invoice_save_date1 = date('d-m-Y');}
      
  if(isset($res2[0]['invoice_date'])){
    $invoice_date1 = $this->Base->change_date_dmy($res2[0]['invoice_date']);}
  else{$invoice_date1='';}
?>   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Purchase Invoice</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Invoice</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['product_invoice_entry_id']))echo $res2[0]['product_invoice_entry_id'];?>">
                                            <input type="hidden" name="old_entry_date" id="old_entry_date"  value="<?php if(isset($res2[0]['product_invoice_save_date']))echo $res2[0]['product_invoice_save_date'];?>">
                                            <input type="hidden" name="old_invoice_no" id="old_invoice_no"  value="<?php if(isset($res2[0]['product_invoice_save_no']))echo $res2[0]['product_invoice_save_no'];?>">
                                            


                                            
                                            <div class="col-md-3">
                                                  <label >Recive Date</label>
                                                  <input type="text" class="form-control"   name="product_invoice_save_date" id="product_invoice_save_date" required  autocomplete="off" value="<?php echo $product_invoice_save_date1;?>">
                                            </div>
                                          
                                          
                                            <div class="col-md-3">
                                                <label >Select Supplier </label>
                                                <select  class="js-states form-control"  style=" width: 100%" name="supplier_id" id="supplier_id" onChange="fun_gst_type_and_po_product_invoice_entry(this.value)">
                                                      <option  <?php if(isset($res2[0]['supplier_id'])){if($res2[0]['supplier_id']==''){echo "selected";}}?>  value="">Select</option>
                                                        <?Php 
                                                          foreach($supplier as $c)
                                                          {
                                                            ?>
                                                              <option <?php if(isset($res2[0]['supplier_id'])){if($res2[0]['supplier_id']==$c['id']){echo "selected";}}?> value="<?php echo $c['id'];?>">
                                                                  <?php echo $c['name'];?>
                                                              </option>
                                                            <?php
                                                          }
                                                        ?>		
                                                </select>
                                            </div>


                                            <div class="col-md-3">
                                                <label >Type </label>
                                                <select  class="form-control"  style=" width: 100%" name="type" id="type" >
                                                  <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']==''){echo "selected";}}?>  value="">Select</option>
                                                  <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Invoice'){echo "selected";}}?>  value="Invoice">Invoice</option>
                                                  <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Challan'){echo "selected";}}?>  value="Challan">Challan</option>
                                                </select>
                                            </div>                      
                                                                      
                                            <div class="col-md-3">
                                                  <label >Invoice / Challan No. </label>
                                                  <input type="text" class="form-control"   name="invoice_no" id="invoice_no"   autocomplete="off" value="<?php if(isset($res2[0]['invoice_no']))echo $res2[0]['invoice_no'];?>">
                                            </div>
                                                
                                            <div class="col-md-3">
                                                  <label >Date Of Invoice / Challan </label>
                                                  <input type="text"  class="form-control"   name="invoice_date" id="invoice_date" required  autocomplete="off" value="<?php echo $invoice_date1;?>">
                                            </div>

                                            <div class="col-md-3">
                                                  <label >Transport Mode </label>
                                                  <input type="text" class="form-control"   name="transport_mode" id="transport_mode"   autocomplete="off" value="<?php if(isset($res2[0]['transport_mode']))echo $res2[0]['transport_mode'];?>">
                                            </div>
                                            
                                            <div class="col-md-3">
                                                  <label >Vehicle No. </label>
                                                  <input type="text" class="form-control"   name="vehicle_no" id="vehicle_no"   autocomplete="off" value="<?php if(isset($res2[0]['vehicle_no']))echo $res2[0]['vehicle_no'];?>">
                                            </div>
                                        
                                        
                                            <div class="col-md-3">
                                                  <label >Gate Entry No. </label>
                                                  <input type="text" class="form-control"   name="gate_pass_no" id="gate_pass_no"   autocomplete="off" value="<?php if(isset($res2[0]['gate_pass_no']))echo $res2[0]['gate_pass_no'];?>">
                                            </div>

                                            <input type="hidden" class="form-control"   name="same_company" id="same_company"  value="No">

                                            

                                          

                                            
   
                                            <!------------Row 3 start------------>
                                            <div class="col-md-12" style="margin-top:70px"  >
                                              <div class="row-fluid">
                                                <div class="span12" >
                                                  <div class="widget-box">
                                                    <!------------From start------------>
                                                    <div class="widget-content nopadding">
                                                      
                                                      <div style=" margin-left:40px;">
                                                        <input class="form-control-new" readonly  value="Description Of Goods" type="text" style=" height:30px; width:150px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="PO NO" type="text" style=" height:30px; width:110px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="Total Qty" type="text" style=" height:30px; width:80px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="Recived" type="text" style=" height:30px; width:80px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="Remaining" type="text" style=" height:30px; width:80px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="Qty." type="text" style=" height:30px; width:80px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="Unit" type="text" style=" height:30px; width:70px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="HSN Code" type="text" style=" height:30px; width:70px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly  value="Pckgs No."  type="text" style=" height:30px; width:70px;border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="Rate" type="text" style=" height:30px; width:80px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="Total Amount" type="text" style=" height:30px; width:100px;margin-left:0px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="SGST %" type="text" style=" height:30px; width:50px;margin-left:0px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="CGST %" type="text" style=" height:30px; width:50px;margin-left:0px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="IGST %" type="text" style=" height:30px; width:50px;margin-left:0px; border:none; background-color:#f7f7f5;" />
                                                        <input class="form-control-new" readonly value="GST Amount" type="text" style=" height:30px; width:100px;margin-left:0px; border:none; background-color:#f7f7f5;" />
                                                      </div>
                                                      <?php 
                                                        //----------------------------------update case
                                                        if(isset($res3) and count($res3)>0)
                                                        {
                                                          $c=1000;
                                                          foreach($res3 as $w)
                                                          {
                                                              $product_id = $w['product_id'];
                                                              $supplier_id = $w['supplier_id'];
                                                              ?>
                                                              <div id="readrootjr101" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="fun_invoice_product_not_delete_msg(); " id="closebutton_">
                                                                  <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                </a>
                                                                <input type="hidden" name="details_id[]" class="details_id"  value="<?php if(isset($w['details_id'])){echo $w['details_id'];}else{echo 0;}?>" id="detailsid_<?php echo $c;?>">
                                                                <input type="hidden" name="oldqty[]" class="oldqty"  value="<?php if(isset($w['net'])){echo $w['net'];}else{echo 0;}?>" id="oldqty_<?php echo $c;?>">
                                                                <input type="hidden" name="oldamt[]" class="oldamt"  value="<?php if(isset($w['amount'])){echo $w['amount'];}else{echo 0;}?>" id="oldamt_<?php echo $c;?>">
                                                                <input type="hidden" name="oldlot[]" class="oldlot"  value="<?php if(isset($w['lotno'])){echo $w['lotno'];}else{echo 0;}?>" id="oldlot_<?php echo $c;?>">
                                                                <input type="hidden" name="oldgrade[]" class="oldgrade"  value="<?php if(isset($w['product_grade_id'])){echo $w['product_grade_id'];}else{echo 0;}?>" id="oldgrade_<?php echo $c;?>">
                                                                <input type="hidden" name="oldpoid[]" class="oldpoid"  value="<?php if(isset($w['poid'])){echo $w['poid'];}else{echo 0;}?>" id="oldpoid_<?php echo $c;?>">
                                                                <input type="hidden" name="oldqc[]" class="oldqc"  value="<?php if(isset($w['qc_check'])){echo $w['qc_check'];}else{echo 0;}?>" id="oldqc_<?php echo $c;?>">
                                                                <input type="hidden" name="oldproduct[]" class="oldproduct"  value="<?php if(isset($w['product_id'])){echo $w['product_id'];}?>" id="oldproduct_<?php echo $c;?>">
                                                                <input type="hidden" name="oldpkg[]" class="oldpkg"  value="<?php if(isset($w['package'])){echo $w['package'];}else{echo 0;}?>" packageid="oldpkg_<?php echo $c;?>">
                                                                <select  style="height:33px;   width:150px; margin-left:5px; " id="goods_<?php echo $c;?>" name="goods[]" class="goods" onChange="get_po_no_form_supplier_and_product_invoice_entry(this.id)">
                                                                  <option value="">Select</option>
                                                                  <?php 
                                                                    $out=$this->Pomodel->get_po_details_with_supplier_id($supplier_id);
                                                                    foreach($out as $r)
                                                                    {
                                                                        $out2 = $this->Productmodel->get_product_data_with_id($r['product_id']);
                                                                        ?>
                                                                          <option <?php if(isset($w['product_id'])){if($w['product_id']==$r['product_id']){echo "selected";}}?> value="<?php echo $r['product_id'];?>"><?php echo $out2[0]['name'];?></option>
                                                                        <?php
                                                                    }
                                                                  ?>
                                                                </select>
                                                                <select  style="height:33px;  width:110px; " id="poid_<?php echo $c;?>" name="poid[]" class="poid" onChange="fun_po_details(this.id)">
                                                                    <option value="">Select</option>
                                                                    <?php
                                                                      $product2=$this->Pomodel->get_product_data_with_id_all($supplier_id,$product_id);
                                                                      foreach($product2 as $p)
                                                                      {
                                                                        ?>
                                                                            <option <?php if(isset($w['poid'])){if($w['poid']==$p['po_entry_details_id']){echo "selected";}}?> value="<?php echo $p['po_entry_details_id'];?>"><?php echo $p['po_no'];?></option>
                                                                        <?php
                                                                      }
                                                                    ?>
                                                                </select>
                                                                <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " id="totalqty_<?php echo $c;?>" name="totalqty[]" class="totalqty" readonly  />
                                                                <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " id="recqty_<?php echo $c;?>" name="recqty[]" class="recqty" readonly />
                                                                <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " id="remqty_<?php echo $c;?>" name="remqty[]" class="remqty" readonly />
                                                                <input type="text"   style="height:33px; width:80px; " class="amount_weight" id="net_<?php echo $c;?>" name="net[]"  onKeyUp="fun_invoice_price(this.id)" value="<?php if(isset($w['net'])){echo $w['net'];}?>" />
                                                                <select  style="height:33px;  width:70px; " id="unitname_" name="unitname[]" class="unitname">
                                                                  <option value="">Select</option>
                                                                  <?Php 
                                                                    foreach($unit as $u)
                                                                    {
                                                                      ?>
                                                                        <option <?php if(isset($w['unitname_id'])){if($w['unitname_id']==$u['unit_id']){echo "selected";}}?>  value="<?php echo $u['unit_id'];?>">
                                                                            <?php echo $u['name'];?>
                                                                        </option>
                                                                      <?php
                                                                    }
                                                                  ?>
                                                                </select>
                                                                <input type="text"   style="height:33px;   width:70px;  " id="hsn_<?php echo $c;?>" name="hsn[]" class="hsn" value="<?php if(isset($w['hsn'])){echo $w['hsn'];}?>" />
                                                                <input type="text"   style="height:33px; width:70px; "  id="package_<?php echo $c;?>" name="package[]" class="package" value="<?php if(isset($w['package']))echo $w['package'];?>" />
                                                                <input type="text"   style="height:33px;   width:80px;  " id="price_<?php echo $c;?>" name="price[]" readonly class="price" onKeyUp="fun_invoice_price(this.id)" value="<?php if(isset($w['price']))echo $w['price'];?>" />
                                                                <input type="text"   style="height:33px; width:100px; " class="total_amount" id="amount_<?php echo $c;?>" name="amount[]" onKeyUp="fun_invoice_net_total()" value="<?php if(isset($w['amount']))echo $w['amount'];?>" />
                                                                <input type="text"   style="height:33px; width:50px; " class="itemsgst" id="itemsgst_<?php echo $c;?>" name="itemsgst[]" onKeyUp="fun_invoice_gst(this.id)"  value="<?php if(isset($w['itemsgst']))echo $w['itemsgst'];?>" />
                                                                <input type="text"   style="height:33px; width:50px; " class="itemcgst" id="itemcgst_<?php echo $c;?>" name="itemcgst[]" onKeyUp="fun_invoice_gst(this.id)" value="<?php if(isset($w['itemcgst']))echo $w['itemcgst'];?>" />
                                                                <input type="text"   style="height:33px; width:50px; " class="itemigst" id="itemigst_<?php echo $c;?>" name="itemigst[]" onKeyUp="fun_invoice_gst(this.id)" value="<?php if(isset($w['itemigst']))echo $w['itemigst'];?>" />
                                                                <input type="text"   style="height:33px; width:100px; " class="itemgstrs" id="itemgstrs_<?php echo $c;?>" name="itemgstrs[]" value="<?php if(isset($w['itemgstrs']))echo $w['itemgstrs'];?>"  />
                                                                <select  style="height:33px;  width:80px; " id="notrepeat_" name="notrepeat[]" class="notrepeat">
                                                                    <option <?php if(isset($w['notrepeat'])){if($w['notrepeat']==0){echo "selected";}}?> value="0">New</option>
                                                                    <option <?php if(isset($w['notrepeat'])){if($w['notrepeat']==1){echo "selected";}}?> value="1">Marge</option>
                                                                </select>
                                                              </div>
                                                              <?php 
                                                              $c++;
                                                          }//foreach
                                                        }
                                                        else
                                                        {
                                                          ?>
                                                            <div id="readrootjr101" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                              <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
                                                                <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                              </a>
                                                              <input type="hidden" name="details_id[]" class="details_id" id="detailsid_"  value="0">
                                                              <input type="hidden" name="oldqty[]" class="oldqty" id="oldqty_"  value="0">
                                                              <input type="hidden" name="oldamt[]" class="oldamt" id="oldamt_"  value="0">
                                                              <input type="hidden" name="oldlot[]" class="oldlot" id="oldlot_"  value="0">
                                                              <input type="hidden" name="oldgrade[]" class="oldgrade" id="oldgrade_"  value="0">
                                                              <input type="hidden" name="oldpoid[]" class="oldpoid" id="oldpoid_"  value="0">
                                                              <input type="hidden" name="oldqc[]" class="oldqc" id="oldqc_"  value="0">
                                                              <input type="hidden" name="oldproduct[]" class="oldproduct" id="oldproduct_"  value="0">
                                                              <input type="hidden" name="oldpkg[]" class="oldpkg" id="oldpkg_"  value="0">
                                                              <select  style="height:33px;   width:150px; margin-left:5px; " id="goods_" name="goods[]" class="goods" onChange="get_po_no_form_supplier_and_product_invoice_entry(this.id)">
                                                                <option value="">Select</option>
                                                                <?php 
                                                                  if(isset($res2[0]['supplier_id']))
                                                                  {
                                                                    $out3=$this->Pomodel->get_po_details_with_supplier_id($res2[0]['supplier_id']);
                                                                    foreach($out3 as $r)
                                                                    {
                                                                        $out2 = $this->Productmodel->get_product_data_with_id($r['product_id']);
                                                                        ?>
                                                                          <option value="<?php echo $product_id;?>"><?php echo $out2[0]['name'];?></option>
                                                                        <?php
                                                                    }
                                                                  }
                                                                ?>
                                                              </select>
                                                              <select  style="height:33px;  width:110px; " id="poid_" name="poid[]" class="poid" onChange="fun_po_details(this.id)">
                                                                  <option value="">Select</option>
                                                              </select>
                                                              <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " id="totalqty_" name="totalqty[]" class="totalqty" readonly />
                                                              <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " id="recqty_" name="recqty[]" class="recqty" readonly />
                                                              <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " id="remqty_" name="remqty[]" class="remqty" readonly />
                                                              <input type="text"   style="height:33px; width:80px; " class="amount_weight" id="net_" name="net[]"  onKeyUp="fun_invoice_price(this.id)" />
                                                              <select  style="height:33px;  width:70px; " id="unitname_" name="unitname[]" class="unitname">
                                                                  <option value="">Select</option>
                                                                  <?Php 
                                                                    foreach($unit as $c)
                                                                    {
                                                                  ?>
                                                                    <option  value="<?php echo $c['unit_id'];?>">
                                                                        <?php echo $c['name'];?>
                                                                    </option>
                                                                  <?php
                                                                    }
                                                                  ?>
                                                              </select>
                                                              <input type="text"   style="height:33px;   width:70px;  " id="hsn_" name="hsn[]" class="hsn" />
                                                              <input type="text"   style="height:33px; width:70px; "  id="package_" name="package[]" class="package" />
                                                              <input type="text"   style="height:33px;   width:80px;  " id="price_" name="price[]" class="price" readonly onKeyUp="fun_invoice_price(this.id)" />
                                                              <input type="text"   style="height:33px; width:100px; " class="total_amount" id="amount_" name="amount[]" onKeyUp="fun_invoice_net_total()" />
                                                              <input type="text"   style="height:33px; width:50px; " class="itemsgst" id="itemsgst_" name="itemsgst[]" onKeyUp="fun_invoice_gst(this.id)"  />
                                                              <input type="text"   style="height:33px; width:50px; " class="itemcgst" id="itemcgst_" name="itemcgst[]" onKeyUp="fun_invoice_gst(this.id)"  />
                                                              <input type="text"   style="height:33px; width:50px; " class="itemigst" id="itemigst_" name="itemigst[]" onKeyUp="fun_invoice_gst(this.id)"  />
                                                              <input type="text"   style="height:33px; width:100px; " class="itemgstrs" id="itemgstrs_" name="itemgstrs[]"  />
                                                              <select  style="height:33px;  width:80px; " id="notrepeat_" name="notrepeat[]" class="notrepeat">
                                                                  <option value="0">New</option>
                                                                  <option value="1">Marge</option>
                                                              </select>
                                                            </div>
                                                          <?php
                                                        }
                                                      ?>
                                                      <div class="form-group">
                                                        <span id="writerootjr"></span>
                                                        <input type="button" id="moreFields" class="btn btn-warning pull-left" style="width:80px" onclick="javascript:moreFields1('readrootjr','writerootjr');" value="Add" /> 
                                                      </div>   
                                                    
                                                      <br />
                                                      <br />
                                                      <br />

                                                      <div id="readrootjr" style="display:none;  margin-bottom:20px; margin-top:10px;">
                                                        <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
                                                          <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                        </a>
                                                        <input type="hidden" name="details_id[]" class="details_id" id="detailsid_"  value="0">
                                                        <input type="hidden" name="oldqty[]" class="oldqty" id="oldqty_"  value="0">
                                                        <input type="hidden" name="oldamt[]" class="oldamt" id="oldamt_"  value="0">
                                                        <input type="hidden" name="oldlot[]" class="oldlot" id="oldlot_"  value="0">
                                                        <input type="hidden" name="oldgrade[]" class="oldgrade" id="oldgrade_"  value="0">
                                                        <input type="hidden" name="oldpoid[]" class="oldpoid" id="oldpoid_"  value="0">
                                                        <input type="hidden" name="oldqc[]" class="oldqc" id="oldqc_"  value="0">
                                                        <input type="hidden" name="oldproduct[]" class="oldproduct" id="oldproduct_"  value="0">
                                                        <input type="hidden" name="oldpkg[]" class="oldpkg" id="oldpkg_"  value="0">
                                                        <select  style="height:33px;   width:150px; margin-left:5px; " id="goods_" name="goods[]" class="goods" onChange="get_po_no_form_supplier_and_product_invoice_entry(this.id)">
                                                          <option value="">Select</option>
                                                            <?php 
                                                              if(isset($res2[0]['supplier_id']))
                                                              {
                                                                $out3=$this->Pomodel->get_po_details_with_supplier_id($res2[0]['supplier_id']);
                                                                foreach($out3 as $r)
                                                                {
                                                                    $out2 = $this->Productmodel->get_product_data_with_id($r['product_id']);
                                                                    ?>
                                                                      <option value="<?php echo $product_id;?>"><?php echo $out2[0]['name'];?></option>
                                                                    <?php
                                                                }
                                                              }
                                                            ?>
                                                        </select>
                                                        <select  style="height:33px;  width:110px; " id="poid_" name="poid[]" class="poid" onChange="fun_po_details(this.id)">
                                                            <option value="">Select</option>
                                                        </select>
                                                        <input type="text"   style="height:33px;   width:80px; background-color:#f.7f7f5;  " id="totalqty_" name="totalqty[]" class="totalqty" readonly />
                                                        <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " id="recqty_" name="recqty[]" class="recqty" readonly />
                                                        <input type="text"   style="height:33px;   width:80px; background-color:#f7f7f5;  " id="remqty_" name="remqty[]" class="remqty" readonly />
                                                        <input type="text"   style="height:33px; width:80px; " class="amount_weight" id="net_" name="net[]"  onKeyUp="fun_invoice_price(this.id)" />
                                                        <select  style="height:33px;  width:70px; " id="unitname_" name="unitname[]" class="unitname">
                                                            <option value="">Select</option>
                                                            <?Php 
                                                              foreach($unit as $c)
                                                              {
                                                                ?>
                                                                  <option  value="<?php echo $c['unit_id'];?>">
                                                                      <?php echo $c['name'];?>
                                                                  </option>
                                                                <?php
                                                              }
                                                            ?>
                                                        </select>
                                                        <input type="text"   style="height:33px;   width:70px;  " id="hsn_" name="hsn[]" class="hsn" />
                                                        <input type="text"   style="height:33px; width:70px; "  id="package_" name="package[]" class="package" />
                                                        <input type="text"   style="height:33px;   width:80px;  " id="price_" name="price[]" class="price" readonly onKeyUp="fun_invoice_price(this.id)" />
                                                        <input type="text"   style="height:33px; width:100px; " class="total_amount" id="amount_" name="amount[]" onKeyUp="fun_invoice_net_total()" />
                                                        <input type="text"   style="height:33px; width:50px; " class="itemsgst" id="itemsgst_" name="itemsgst[]" onKeyUp="fun_invoice_gst(this.id)"  />
                                                        <input type="text"   style="height:33px; width:50px; " class="itemcgst" id="itemcgst_" name="itemcgst[]" onKeyUp="fun_invoice_gst(this.id)"  />
                                                        <input type="text"   style="height:33px; width:50px; " class="itemigst" id="itemigst_" name="itemigst[]" onKeyUp="fun_invoice_gst(this.id)"  />
                                                        <input type="text"   style="height:33px; width:100px; " class="itemgstrs" id="itemgstrs_" name="itemgstrs[]"  />
                                                        <select  style="height:33px;  width:80px; " id="notrepeat_" name="notrepeat[]" class="notrepeat">
                                                            <option value="0">New</option>
                                                            <option value="1">Marge</option>
                                                        </select>
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
                                            
                                            <div class="col-md-12" >
                                                <div class="col-sm-4" style="float:left"></div>
                                                <label for="input-Default" style="float:left" class="col-sm-4 control-label"><b>Total </b></label>
                                                <div class="col-sm-2" style="float:left"></div>
                                                <div class="col-sm-2" style="float:left">
                                                    <input type="text" class="form-control" id="total_old"   value="<?php if(isset($res2[0]['total_old']) and $res2[0]['total_old']>0){if(isset($res2[0]['total_old'])){echo $res2[0]['total_old'];}}else{if(isset($res2[0]['total'])){echo $res2[0]['total'];}}?>"  onKeyUp="new_dis()">
                                                </div>
                                            </div>
                                      
                                
                                            <div class="col-md-12" style=" margin-top:5px;" >
                                                <div class="col-sm-4" style="float:left"></div>
                                                <label for="input-Default" style="float:left" class="col-sm-2 control-label">Discount (%)</label>
                                                <div class="col-sm-1" style="float:left">
                                                  <input type="text"  class="form-control" id="dis_per"  value="<?php if(isset($res2[0]['dis_per']))echo $res2[0]['dis_per'];?>" placeholder="%" onKeyUp="new_dis()" >
                                                </div>
                                                <div class="col-sm-2" style="float:left">
                                                    <input type="text" class="form-control" id="dis_amt"  value="<?php if(isset($res2[0]['dis_amt']))echo $res2[0]['dis_amt'];?>"   readonly>
                                                </div>
                                                <div class="col-sm-1" style="float:left">
                                                  Total + Discount Amt.
                                                </div>
                                                <div class="col-sm-2" style="float:left">
                                                  <input type="text" class="form-control" id="total"   value="<?php if(isset($res2[0]['total']))echo $res2[0]['total'];?>"   onKeyUp="fun_invoice_grand_total()">
                                                </div>
                                            </div>
                                  
                                            <!--------------------------------gst ajex---->  
                                            <div id="gst_type_div"> 
                                                <input type="hidden" name="gst_type"    id="gst_type" value="<?php if(isset($res2[0]['gst_type']))echo $res2[0]['gst_type'];?>">
                                            </div>
                                            <!--------------------------------gst ajex----> 
                                          
                                            <div class="col-md-12" style="margin-top:5px;">
                                                <div class="col-sm-4" style="float:left"></div>
                                                <label for="input-Default" style="float:left" class="col-sm-4 control-label">
                                                  Total GST Amount (Without Discount)                 	
                                                </label>
                                                <div class="col-sm-2" style="float:left"></div>
                                                <div class="col-sm-2" style="float:left">
                                                    <input type="text" class="form-control" id="gstcharge"  onKeyUp="fun_invoice_grand_total()" name="gstcharge" value="<?php if(isset($res2[0]['gstcharge']))echo $res2[0]['gstcharge'];?>"   >
                                                </div>
                                            </div>      
                                            
                                            <div class="col-md-12" style=" margin-top:5px;" >
                                                <div class="col-sm-4" style="float:left"></div>
                                                <label for="input-Default" style="float:left" class="col-sm-2 control-label"><b>FFC</b></label>
                                            
                                                <div class="col-sm-2" style="float:left">
                                                    <input type="text" class="form-control" id="ffc_charge" name="ffc_charge" placeholder="FFC Charge"  value="<?php if(isset($res2[0]['ffc_charge']))echo $res2[0]['ffc_charge'];?>">
                                                </div>
                                              
                                                <div class="col-sm-1" style="float:left">
                                                  <input type="text" class="form-control" id="ffc_gst_per" name="ffc_gst_per"  value="<?php if(isset($res2[0]['ffc_gst_per']))echo $res2[0]['ffc_gst_per'];?>" placeholder="%" onKeyUp="fun_ffc_gst(this.value)">
                                                </div>
                                              
                                                <div class="col-sm-1" style="float:left">
                                                  <input type="text" class="form-control" id="ffc_gst_amt" name="ffc_gst_amt"  value="<?php if(isset($res2[0]['ffc_gst_amt']))echo $res2[0]['ffc_gst_amt'];?>" readonly placeholder="GST Amt">
                                                </div>
                                              
                                                <div class="col-sm-2" style="float:left">
                                                  <input type="text" class="form-control" id="ffc_amt"  onKeyUp="fun_invoice_grand_total()" name="ffc_amt"  value="<?php if(isset($res2[0]['ffc_amt']))echo $res2[0]['ffc_amt'];?>" placeholder="FFC Total (Charge+GST)" >
                                                </div>
                                            </div>
                                  
                                            <div class="col-md-12"style="margin-top:5px;" >
                                                <div class="col-sm-4" style="float:left"></div>
                                                <label for="input-Default" style="float:left" class="col-sm-4 control-label">Less: Rounded Off (-) </label>
                                                <div class="col-sm-2" style="float:left"></div>
                                                <div class="col-sm-2" style="float:left">
                                                    <input type="text" class="form-control" id="roundoff" name="roundoff" placeholder=".00"  onKeyUp="fun_invoice_grand_total()" value="<?php if(isset($res2[0]['roundoff']))echo $res2[0]['roundoff'];?>">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
                                                <div style=" height:1px; width:100%; background-color:#74767d"></div>
                                            </div>
                                          
                                            <div class="col-md-12" >
                                                <div class="col-sm-4" style="float:left"></div>
                                                <label for="input-Default" style="float:left" class="col-sm-2 control-label">Grand Total (Qty).   </label>
                                                <div class="col-sm-2" style="float:left">
                                                  <b>
                                                    <input type="text" class="form-control" id="amount_weight_sum" name="amount_weight_sum" readonly value="<?php if(isset($res2[0]['amount_weight_sum']))echo $res2[0]['amount_weight_sum'];?>">
                                                  </b>
                                                </div>
                                                
                                                <div class="col-sm-2" style="float:left"><span style="float:right">₹</soan></div>
                                                  <div class="col-sm-2" style="float:left">
                                                    <input type="text" class="form-control" id="grandtotal" name="grandtotal" readonly value="<?php if(isset($res2[0]['grandtotal']))echo $res2[0]['grandtotal'];?>">
                                                  </div>
                                            </div>

                                  
                                  
                                            <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
                                                <div style=" height:1px; width:100%; background-color:#74767d"></div>
                                            </div>
                                            
                                            <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">   
                                                  <div class="panel-body">
                                                    <div class="col-md-12" style="height:80px;">
                                                      <label  >Remarks </label>
                                                      <textarea class="form-control" id="remarks" name="remarks"><?php if(isset($res2[0]['remarks'])){echo $res2[0]['remarks'];}?></textarea>
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
                                                      <button type="button" class="btn btn-success" id="po_invoice_save" style="margin-left:50px;float:center" >Save</button>
                                                    </div>
                                              </div>
                                            </div>      
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/po_js');?>


