        

        <!-- ============ Body content start ============= -->
        <style>
        .po-item-row {
            margin-bottom: 15px !important;
            padding: 12px 10px 12px 55px !important;
            border: 1px solid #d1d5db !important;
            border-radius: 6px !important;
            background-color: #fafafa !important;
            position: relative !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05) !important;
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 12px 8px !important;
            align-items: flex-start !important;
            transition: all 0.25s ease;
        }
        .po-item-row:hover {
            border-color: #e37209 !important;
            box-shadow: 0 4px 12px rgba(227, 114, 9, 0.08) !important;
        }
        .po-item-row:nth-child(even) {
            background-color: #f8fafc !important;
        }
        .po-item-row[style*="display: none"], .po-item-row[style*="display:none"] {
            display: none !important;
        }
        .po-item-row .btn-danger, .po-item-row .btn-info {
            position: absolute !important;
            left: 8px !important;
            top: 25px !important;
            margin-top: 0 !important;
        }
        .po-item-row input, .po-item-row select {
            margin: 0 !important;
        }
        .po-input-group {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-start !important;
        }
        .po-input-label {
            font-size: 10px !important;
            color: #64748b !important;
            font-weight: 700 !important;
            margin-bottom: 4px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }
        </style>
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Purchase Order</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <!--<div class="card-title" >New Purchase Order</div>-->
                                    <div class="form-row">
                                      
                                        <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                        <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['po_id']))echo $res2[0]['po_id'];?>">
                                        <input type="hidden" name="po_no" id="po_no"  value="<?php if(isset($res2[0]['po_no']))echo $res2[0]['po_no'];?>">
                                        <input type="hidden" name="current_stage" id="current_stage"  value="<?php if(isset($res2[0]['stage']))echo $res2[0]['stage'];?>">
                                            
                                        <div class="col-md-12" >
                                            <div class="panel panel-info">
                                                <!--
                                                <div class="panel-heading clearfix">
                                                    <h4 class="panel-title">Supplier Information</h4>
                                                </div>
                                                -->
                                                <div class="panel-body">
                                                    <div class="col-md-2" style="float:left">
                                                         <label >Select Supplier <span style="color:red;">*</span></label>
                                                        <select  class="form-control"   name="supplier_id" id="supplier_id" onChange="get_supplier_basic_details(this.value)">
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

                                                        <div class="col-md-2"  style="float:left">
                                                            <label >P.O No:</label>
                                                            <input type="text" class="form-control" readonly  value="<?php if(isset($res2[0]['po_no'])){echo $res2[0]['po_no'];}else{ echo "Auto";}?>" >
                                                        </div>
                
                                                        <?php 
                                                        
                                                            if(isset($res2[0]['po_date'])){$po_date1 = $this->Base->change_date_dmy($res2[0]['po_date']);}else{$po_date1=date('d-m-Y');}
                                                            if(isset($res2[0]['po_validity'])){$po_validity1 = $this->Base->change_date_dmy($res2[0]['po_validity']);}
                                                            else{$po_validity1 =  $this->Base->change_date_dmy($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),'+28'));}
                                                         
                                                            if(isset($res2[0]['po_date']))
                                                            {
                                                                //in update option 
                                                                ?>
                                                                <input type="hidden" name="po_date" value="<?php echo $po_date1;?>">
                                                                <div class="col-md-2"  style="float:left">
                                                                    <label >P.O Date: <span style="color:red;">*</span></label>
                                                                    <input type="text" class="form-control" name="po_date"  id="po_date" readonly value="<?php echo $po_date1;?>"  >
                                                                </div>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                //new entry
                                                                ?>
                                                                <div class="col-md-2"  style="float:left">
                                                                    <label >P.O Date: <span style="color:red;">*</span></label>
                                                                    <input type="text" class="form-control"  id="po_date" name="po_date"  required value="<?php echo $po_date1;?>"  >
                                                                </div>
                                                                <?php
                                                            }
                                                        ?>                                        
                                                        
                                                        <div class="col-md-2" style="float:left">
                                                            <label >P.O Validity: <span style="color:red;">*</span></label>
                                                            <input type="text" class="form-control" id="po_valid"  name="po_valid" required value="<?php echo $po_validity1;?>">
                                                        </div>
                                                        
                                                        <div class="col-md-2" style="float:left">
                                                            <label >Quotation Ref:</label>
                                                            <input type="text" class="form-control" id="com_qut_ref" name="com_qut_ref" value="<?php if(isset($res2[0]['quotation_ref']))echo $res2[0]['quotation_ref'];?>" >
                                                        </div>
                                                        
                                                        <div class="col-md-2" style="float:left">
                                                            <label >Indent Ref:</label>
                                                            <input type="text" class="form-control" id="com_indent_ref"  name="com_indent_ref" value="<?php if(isset($res2[0]['indent_ref']))echo $res2[0]['indent_ref'];?>" >
                                                        </div>
                                                        
                                                       
                                                    
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>


                                       

                                        <div class="col-md-12" >
                                            <div class="panel panel-white">
                                             <div class="col-md-12" style=" margin-top:10px;" ><hr></div>
                                                <!--
                                                <div class="panel-heading clearfix">
                                                    <h4 class="panel-title">Product Details</h4>
                                                </div>
                                                -->
                                                <div class="panel-body">

                                                            
                                                            <!------------Row 3 start------------>
                                                            <div class="col-md-12"  >
                                                                <div class="row-fluid">
                                                                    <div class="span12" >
                                                                        <div class="widget-box">
                                                                            <div class="widget-content nopadding"><!------------From start------------>

                                                                                <?php 
                                                                                //----------------------------------update case
                                                                                if(isset($res3) and count($res3)>0)
                                                                                {
                                                                                    $c=1000;
                                                                                    foreach($res3 as $w)
                                                                                    {
                                                                                        ?>
                                                                                        <div id="readrootjr101" class="po-item-row" style=" margin-bottom:20px; margin-top:10px;">
                                                                                            <?php 
                                                                                                if(!empty($w['rev_qunt']) and $w['rev_qunt']>0)
                                                                                                {
                                                                                                    ?>
                                                                                                    <a class="btn btn-info pull-left" onClick="fun_not_delete_msg()">
                                                                                                            <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                                                        </a>
                                                                                                    <?php
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    ?>
                                                                                                        <a class="btn btn-danger pull-left"  onclick="delete_item(this.id);this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_<?php echo $c;?>">
                                                                                                            <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                                                        </a>
                                                                                                    <?php 
                                                                                                }
                                                                                            ?>
                                                                                            <input type="hidden" name="po_details_id[]" class="po_details_id"  value="<?php if(isset($w['po_entry_details_id'])){echo $w['po_entry_details_id'];}else{echo 0;}?>" id="podetailsid_<?php echo $c;?>">
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">Description Of Goods</span>
                                                                                                <?php 
                                                                                                $pname = "";
                                                                                                if(isset($w['product_id']))
                                                                                                {
                                                                                                    $product_id2=$w['product_id'];
                                                                                                    $product2 = $this->Productmodel->get_product_column_data_with_id($product_id2,'name');
                                                                                                    if (!empty($product2)) {
                                                                                                        $pname = $product2[0]['name'];
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                                <input type="text"   style="height:33px;   width:200px; " id="goods2_<?php echo $c;?>"  class="goods2" onKeyUp="fun_get_product(this.id,'goods2_','goods_','new_po')" value="<?php echo $pname;?>"  />
                                                                                            </div>
                                                                                            <input type="hidden" id="goods_<?php echo $c;?>"  name="goods[]" class="goods" value="<?php if(isset($w['product_id']))echo $w['product_id'];?>" />
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">Details</span>
                                                                                                <input type="text"   style="height:33px;   width:200px; " class="goodsdetails" id="goodsdetails_<?php echo $c;?>" value="<?php if(isset($w['goodsdetails']))echo $w['goodsdetails'];?>" />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">HSN Code</span>
                                                                                                <input type="text"   style="height:33px;   width:70px;  " id="hsn_<?php echo $c;?>" name="hsn[]" class="hsn" value="<?php if(isset($w['hsn']))echo $w['hsn'];?>" />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">UOM</span>
                                                                                                <select  style="height:33px;   width:70px; " id="unitname_<?php echo $c;?>" name="unitname[]" class="unitname">
                                                                                                    <option value="">Select</option>
                                                                                                    <?Php 
                                                                                                        foreach($unit as $n)
                                                                                                        {
                                                                                                            ?>
                                                                                                                <option <?php if(isset($w['unitname_id'])){if($w['unitname_id']==$n['unit_id']){echo "selected";}}?>  value="<?php echo $n['unit_id'];?>">
                                                                                                                    <?php echo $n['name'];?>
                                                                                                                </option>
                                                                                                            <?php
                                                                                                        }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">Quantity</span>
                                                                                                <input type="text"   style="height:33px; width:70px; " class="qunt" id="qunt_<?php echo $c;?>" name="qunt[]" value="<?php if(isset($w['qunt']))echo $w['qunt'];?>"  onKeyUp="fun_net_total1(this.id)"/>
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">Rate</span>
                                                                                                <input type="text"   style="height:33px; width:100px; " id="rate_<?php echo $c;?>" name="rate[]" class="rate" onKeyUp="fun_net_total1(this.id)" value="<?php if(isset($w['rate']))echo $w['rate'];?>" />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">Disc. %</span>
                                                                                                <input type="text"   style="height:33px; width:70px; "  id="disc_<?php echo $c;?>" name="disc[]"  class="disc" onKeyUp="fun_net_total1(this.id)"  value="<?php if(isset($w['disc']))echo $w['disc'];?>" />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">Net Rate</span>
                                                                                                <input type="text"   style="height:33px; width:100px; " class="net" id="net_<?php echo $c;?>" name="net[]" value="<?php if(isset($w['net']))echo $w['net'];?>" readonly />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">Amount</span>
                                                                                                <input type="text"   style="height:33px; width:100px; " class="total_amount" id="amount_<?php echo $c;?>" name="amount[]" value="<?php if(isset($w['amount']))echo $w['amount'];?>" readonly />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">SGST %</span>
                                                                                                <input type="text"   style="height:33px; width:50px; " class="itemsgst" id="itemsgst_<?php echo $c;?>" name="itemsgst[]" onKeyUp="fun_gst(this.id)" value="<?php if(isset($w['itemsgst']))echo $w['itemsgst'];?>" />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">CGST %</span>
                                                                                                <input type="text"   style="height:33px; width:50px; " class="itemcgst" id="itemcgst_<?php echo $c;?>" name="itemcgst[]" onKeyUp="fun_gst(this.id)" value="<?php if(isset($w['itemcgst']))echo $w['itemcgst'];?>"  />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">IGST %</span>
                                                                                                <input type="text"   style="height:33px; width:50px; " class="itemigst" id="itemigst_<?php echo $c;?>" name="itemigst[]" onKeyUp="fun_gst(this.id)" value="<?php if(isset($w['itemigst']))echo $w['itemigst'];?>"  />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">GST Amount</span>
                                                                                                <input type="text"   style="height:33px; width:100px; " class="itemgstrs" id="itemgstrs_<?php echo $c;?>" name="itemgstrs[]" value="<?php if(isset($w['itemgstrs']))echo $w['itemgstrs'];?>" readonly />
                                                                                            </div>
                                                                                            <div class="po-input-group">
                                                                                                <span class="po-input-label">INFO</span>
                                                                                                <input type="text"   style="height:33px; width:200px;font-size:11px; " class="rowdiv" id="rowdiv_<?php echo $c;?>" readonly value="" />
                                                                                            </div>
                                                                                        </div>        

                                                                                    
                                                                                    <?php
                                                                                    $c++;
                                                                                    }//foreach
                                                                                }//if
                                                                                else
                                                                                {
                                                                                    //new entry case	
                                                                                    ?>
                                                                                    <div id="readrootjr101" class="po-item-row" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                                        <a class="btn btn-danger pull-left"  onclick="delete_item(this.id);this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
                                                                                        <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                                        </a>
                                                                                        <input type="hidden" name="po_details_id[]" class="po_details_id"  value="0" id="podetailsid_">
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Description Of Goods</span>
                                                                                            <input type="text"   style="height:33px;   width:200px; " class="goods2" id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','new_po')" />
                                                                                        </div>
                                                                                        <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Details</span>
                                                                                            <input type="text"   style="height:33px;   width:200px; " class="goodsdetails" id="goodsdetails_" />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">HSN Code</span>
                                                                                            <input type="text"   style="height:33px;   width:70px;  " id="hsn_" name="hsn[]" class="hsn" />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">UOM</span>
                                                                                            <select  style="height:33px;   width:70px; " id="unitname_" name="unitname[]" class="unitname">
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
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Quantity</span>
                                                                                            <input type="text"   style="height:33px; width:70px; " class="qunt" id="qunt_" name="qunt[]"  onKeyUp="fun_net_total1(this.id)"/>
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Rate</span>
                                                                                            <input type="text"   style="height:33px; width:100px; " id="rate_" name="rate[]" class="rate" onKeyUp="fun_net_total1(this.id)" />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Disc. %</span>
                                                                                            <input type="text"   style="height:33px; width:70px; "  id="disc_" name="disc[]" value="0" class="disc" onKeyUp="fun_net_total1(this.id)"  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Net Rate</span>
                                                                                            <input type="text"   style="height:33px; width:100px; " class="net" id="net_" name="net[]" readonly  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Amount</span>
                                                                                            <input type="text"   style="height:33px; width:100px; " class="total_amount" id="amount_" name="amount[]" readonly  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">SGST %</span>
                                                                                            <input type="text"   style="height:33px; width:50px; " class="itemsgst" id="itemsgst_" name="itemsgst[]" onKeyUp="fun_gst(this.id)"  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">CGST %</span>
                                                                                            <input type="text"   style="height:33px; width:50px; " class="itemcgst" id="itemcgst_" name="itemcgst[]" onKeyUp="fun_gst(this.id)"  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">IGST %</span>
                                                                                            <input type="text"   style="height:33px; width:50px; " class="itemigst" id="itemigst_" name="itemigst[]" onKeyUp="fun_gst(this.id)"  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">GST Amount</span>
                                                                                            <input type="text"   style="height:33px; width:100px; " class="itemgstrs" id="itemgstrs_" name="itemgstrs[]"  readonly />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">INFO</span>
                                                                                            <input type="text"   style="height:33px; width:200px;font-size:11px; " class="rowdiv" id="rowdiv_"   readonly value="" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }//if
                                                                                ?>

                                                                                    <div class="form-group">
                                                                                        <span id="writerootjr"></span>
                                                                                        <input type="button" id="moreFields" class="btn btn-warning pull-left" style="width:80px" onclick="javascript:moreFields1('readrootjr','writerootjr');" value="Add" /> 
                                                                                    </div>   
                                                                                    <br />
                                                                                    <br />
                                                                                    <br />

                                                                                    <div id="readrootjr" class="po-item-row" style="display:none;  margin-bottom:20px; margin-top:10px;">
                                                                                        <a class="btn btn-danger pull-left"  onclick="delete_item(this.id);this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
                                                                                            <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                                        </a>
                                                                                        <input type="hidden" name="po_details_id[]"  class="po_details_id"  value="0" id="podetailsid_">
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Description Of Goods</span>
                                                                                            <input type="text"   style="height:33px;   width:200px; "  class="goods2" id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','new_po')" />
                                                                                        </div>
                                                                                        <input type="hidden"   style="height:33px;   width:40px; " id="goods_"   name="goods[]" class="goods"  />
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Details</span>
                                                                                            <input type="text"   style="height:33px;   width:200px; " class="goodsdetails" id="goodsdetails_" />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">HSN Code</span>
                                                                                            <input type="text"   style="height:33px;   width:70px;  " id="hsn_" name="hsn[]" class="hsn" />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">UOM</span>
                                                                                            <select  style="height:33px;   width:70px; " id="unitname_" name="unitname[]" class="unitname">
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
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Quantity</span>
                                                                                            <input type="text"   style="height:33px; width:70px; " class="qunt" id="qunt_" name="qunt[]"  onKeyUp="fun_net_total1(this.id)"/>
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Rate</span>
                                                                                            <input type="text"   style="height:33px; width:100px; " id="rate_" name="rate[]" class="rate" onKeyUp="fun_net_total1(this.id)" />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Disc. %</span>
                                                                                            <input type="text"   style="height:33px; width:70px; "  id="disc_" name="disc[]" class="disc" value="0" onKeyUp="fun_net_total1(this.id)"  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Net Rate</span>
                                                                                            <input type="text"   style="height:33px; width:100px; " class="net" id="net_" name="net[]" readonly  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">Amount</span>
                                                                                            <input type="text"   style="height:33px; width:100px; " class="total_amount" id="amount_" name="amount[]"  readonly />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">SGST %</span>
                                                                                            <input type="text"   style="height:33px; width:50px; " class="itemsgst" id="itemsgst_" name="itemsgst[]"  onKeyUp="fun_gst(this.id)"  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">CGST %</span>
                                                                                            <input type="text"   style="height:33px; width:50px; " class="itemcgst" id="itemcgst_" name="itemcgst[]"  onKeyUp="fun_gst(this.id)"  />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">IGST %</span>
                                                                                            <input type="text"   style="height:33px; width:50px; " class="itemigst" id="itemigst_" name="itemigst[]"  onKeyUp="fun_gst(this.id)" />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">GST Amount</span>
                                                                                            <input type="text"   style="height:33px; width:100px; " class="itemgstrs" id="itemgstrs_" name="itemgstrs[]"  readonly />
                                                                                        </div>
                                                                                        <div class="po-input-group">
                                                                                            <span class="po-input-label">INFO</span>
                                                                                            <input type="text"   style="height:33px; width:200px;font-size:11px; " class="rowdiv" id="rowdiv_"   readonly value="" />
                                                                                        </div>

                                                                                    </div><!--readrootjr end-->


                                                            
                                                                            </div> <!------------form close------------>
                                                                        </div>			
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!------------Row 3 close------------>  

    					

                                                </div><!---panel body end-->
                                            </div><!---panel white end-->
                                        </div><!---12 end-->

                                                            
                                        <div class="col-md-12" style="margin-top:50px;">
                                            <div class="panel panel-white">
                                                <!--
                                                <div class="panel-heading clearfix">
                                                    <h4 class="panel-title">Tax</h4>
                                                </div>
                                                -->
                                                <div class="panel-body">
                                                <div class="col-md-12" style=" margin-top:10px;" ><hr></div>
                                                  
                                                    
                                                    <div class="col-md-12" style=" margin-top:10px;">
                                                        <div class="col-sm-4" style="float:left"></div>
                                                            <label for="input-Default" class="col-sm-4 control-label" style="float:left"><b>Total <span style="color:red;">*</span></b></label>
                                                        <div class="col-sm-2" style="float:left"></div>
                                                        <div class="col-sm-2" style="float:left">
                                                            <input type="text" class="form-control" id="total_old"   value="<?php if(isset($res2[0]['total_old']) and $res2[0]['total_old']>0){if(isset($res2[0]['total_old'])){echo $res2[0]['total_old'];}}else{if(isset($res2[0]['total'])){echo $res2[0]['total'];}}?>"  onKeyUp="new_dis()">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12"  style=" margin-top:10px;" >
                                                        <div class="col-sm-4" style="float:left"></div>
                                                         <label for="input-Default" class="col-sm-2 control-label" style="float:left">Discount (%)</label>
                                                        
                                                        <div class="col-sm-1" style="float:left">
                                                            <input type="text" class="form-control" id="dis_per"  value="<?php if(isset($res2[0]['dis_per']))echo $res2[0]['dis_per'];?>" placeholder="%" onKeyUp="new_dis()" >
                                                        </div>
                                                        
                                                        <div class="col-sm-2" style="float:left">
                                                            <input type="text" class="form-control" id="dis_amt"  value="<?php if(isset($res2[0]['dis_amt']))echo $res2[0]['dis_amt'];?>"    readonly>
                                                        </div>
                                                        
                                                        <div class="col-sm-1" style="float:left">
                                                            Total + Discount Amt.
                                                        </div>
                                                
                                                        <div class="col-sm-2" style="float:left">
                                                            <input type="text" class="form-control" id="total"   value="<?php if(isset($res2[0]['total']))echo $res2[0]['total'];?>"   onKeyUp="fun_grand_total()">
                                                        </div>
                                                    </div>

                                                    <!--------------------------------gst ajex---->  
                                                    <div id="gst_type_div"> 
                                                            <input type="hidden" name="gst_type"  id="gst_type" value="<?php if(isset($res2[0]['gst_type']))echo $res2[0]['gst_type'];?>">
                                                    </div>
                                                    <!--------------------------------gst ajex----> 
                                                    
                                                    <div class="col-md-12" style="margin-top:10px;">
                                                        <div class="col-sm-4" style="float:left"></div>
                                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">
                                                            Add: GST Amount                  	
                                                        </label>
                                                        <div class="col-sm-2" style="float:left">
                                                        </div>
                                                        <div class="col-sm-2" style="float:left">
                                                            <input type="text" class="form-control" id="gstcharge" name="gstcharge" value="<?php if(isset($res2[0]['gstcharge']))echo $res2[0]['gstcharge'];?>"   onKeyUp="fun_grand_total()" >
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12" style=" margin-top:10px;" >
                                                            <div class="col-sm-4" style="float:left"></div>
                                                            <label for="input-Default" class="col-sm-2 control-label" style="float:left"><b>FFC<span style="color:red;">*</span></b></label>
                                                            
                                                            <div class="col-sm-2" style="float:left">
                                                                <input type="text" class="form-control" id="ffc_charge" name="ffc_charge" placeholder="FFC Charge"  value="<?php if(isset($res2[0]['ffc_charge']))echo $res2[0]['ffc_charge'];?>" >
                                                            </div>
                                                        
                                                            <div class="col-sm-1" style="float:left">
                                                            <input type="text" class="form-control" id="ffc_gst_per" name="ffc_gst_per"  value="<?php if(isset($res2[0]['ffc_gst_per']))echo $res2[0]['ffc_gst_per'];?>" placeholder="%" onKeyUp="fun_ffc_gst(this.value)">
                                                            </div>
                                                        
                                                            <div class="col-sm-1" style="float:left">
                                                            <input type="text" class="form-control" id="ffc_gst_amt" name="ffc_gst_amt"  value="<?php if(isset($res2[0]['ffc_gst_amt']))echo $res2[0]['ffc_gst_amt'];?>" readonly>
                                                            </div>
                                                        
                                                            <div class="col-sm-2" style="float:left">
                                                            <input type="text" class="form-control" id="ffc_amt" name="ffc_amt"  value="<?php if(isset($res2[0]['ffc_amt']))echo $res2[0]['ffc_amt'];?>"   onKeyUp="fun_grand_total()">
                                                            </div>
                                                    </div>
                                    
                                                    <div class="col-md-12"style="margin-top:10px;" >
                                                        <div class="col-sm-4" style="float:left"></div>
                                                        <label for="input-Default" class="col-sm-4 control-label" style="float:left">Less: Rounded Off (-) </label>
                                                        <div class="col-sm-2" style="float:left"></div>
                                                        <div class="col-sm-2" style="float:left">
                                                            <input type="text" class="form-control" id="roundoff" name="roundoff" placeholder=".00"  onKeyUp="fun_grand_total()" value="<?php if(isset($res2[0]['roundoff']))echo $res2[0]['roundoff'];?>">
                                                        </div>
                                                    </div> 

                                                    <div class="col-md-12" style=" margin-top:10px;" >
                                                        <div class="col-sm-3" style="float:left"></div>
                                                        <label for="input-Default" class="col-sm-1 control-label" style="float:left">Grand Total</label>
                                                        <div class="col-sm-5" style="float:left">
                                                                <input type="text" name="rs_word" id="rs_word" style="width:100%" value="<?php if(isset($res2[0]['amount_word']))echo $res2[0]['amount_word'];?>" required>
                                                        </div>
                                                        
                                                        <div class="col-sm-1" style="float:left"><span style="float:right">₹</soan></div>
                                                        <div class="col-sm-2" style="float:left">
                                                            <input type="text" class="form-control" id="grandtotal" name="grandtotal" readonly value="<?php if(isset($res2[0]['grandtotal']))echo $res2[0]['grandtotal'];?>">
                                                        </div>
                                                    </div>
                                        
                                    
                                                </div><!---panel body end-->
                                            </div><!---panel white end-->
                                        </div><!---12 end--> 


                                        <div class="col-md-12" style="margin-top:30px">
                                            <div class="panel panel-white">
                                                <div class="panel-body">  
                                                        <div class="col-md-12" style=" margin-top:10px;" ><hr></div>
                                                            <div class="col-md-2" style="float:left">
                                                                <label  >Remarks </label>
                                                                <input type="text" class="form-control" id="remarks" name="remarks" value="<?php if(isset($res2[0]['remarks'])){echo $res2[0]['remarks'];}?>">
                                                            </div>
                                                            
                                                            <div class="col-md-2" style="float:left">
                                                                <label  >Delivery Schedule </label>
                                                                <input type="text" class="form-control" id="del_schedule" name="del_schedule" value="<?php if(isset($res2[0]['del_schedule'])){echo $res2[0]['del_schedule'];}?>">
                                                            </div>
                                                            
                                                            <div  class="col-md-2" style="float:left">
                                                                <label  >Payment Terms </label>
                                                                <input type="text" class="form-control" id="payment_terms" name="payment_terms"  value="<?php if(isset($res2[0]['payment_terms'])){echo $res2[0]['payment_terms'];}else{ echo "45 Days";}?>"  >
                                                            </div>
                                                            
                                                            <div  class="col-md-2" style="float:left">
                                                                <label  >Place Of Delivery </label>
                                                                <input type="text" class="form-control" id="del_place" name="del_place"   value="<?php if(isset($res2[0]['del_place'])){echo $res2[0]['del_place'];}else{ echo "At Work";}?>" >
                                                            </div>
                                                            
                                                            <div  class="col-md-2" style="float:left">
                                                                <label  >Mode Of Dispatch</label>
                                                                <input type="text" class="form-control" id="mod_of_dis" name="mod_of_dis"  value="<?php if(isset($res2[0]['mod_of_dis'])){echo $res2[0]['mod_of_dis'];}else{ echo "By Courier";}?>"  >
                                                            </div>
                                                            
                                                            <div  class="col-md-2" style="float:left">
                                                                <label  >Loading & Packing Charge</label>
                                                                <input type="text" class="form-control" id="loading_charge" name="loading_charge"   value="<?php if(isset($res2[0]['loading_charge'])){echo $res2[0]['loading_charge'];}else{ echo "NA";}?>" >
                                                            </div>
                                                            
                                                            <div  class="col-md-2" style="margin-top:10px;float:left">
                                                                <label  >Order By</label>
                                                                <input type="text" class="form-control" id="order_by" name="order_by"   value="<?php if(isset($res2[0]['order_by'])){echo $res2[0]['order_by'];}?>" >
                                                            </div>
                                                            
                                                            
                                                            <div  class="col-md-2" style="margin-top:10px;float:left">
                                                                <label  >Department</label>
                                                                <input type="text" class="form-control" id="department" name="department"   value="<?php if(isset($res2[0]['department'])){echo $res2[0]['department'];}?>" >
                                                            </div>
                                                            
                                                            <div  class="col-md-2" style="margin-top:10px;float:left">
                                                                <label  >M/C No.</label>
                                                                <input type="text" class="form-control" id="mc_no" name="mc_no"   value="<?php if(isset($res2[0]['mc_no'])){echo $res2[0]['mc_no'];}?>" >
                                                            </div>
                                                </div><!---panel body end-->
                                            </div><!---panel white end-->
                                        </div><!---12 end-->


                                        
   
                                        <div class="col-md-12" style=" margin-top:10px;" ><hr></div>
                                               
                                               
                                            <div class="col-md-12" style="margin-top:50px;"> 
                                                                       
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      Ready To Save <input type="checkbox"  id="chk" name="checkbox[]"    style="float:center">
                                                      <button type="button" class="btn btn-success" id="po_save" style="margin-left:50px;float:center" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   



<?php $this->load->view('js/po_js');?>





                                    
                                                    
                                    
                                                         
                                                
                                                    
     
                        
                        
                        
                        
                        
							
   
   
    	                                           
                                            
                                            
                                                   
                                                
                                                    
                                        
                                                    
                                                    
