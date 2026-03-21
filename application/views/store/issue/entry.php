        
<?php 
  if(isset($res2[0]['po_date'])){$entry_date = $this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date=date('d-m-Y');}
  
  $next_issue_no = $this->Storemodel->get_next_issue_slip_no();
?>
        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Issue Request</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Slip</div>
                                    <div class="form-row">
                                      
                                                                      
                                    <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                    <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['indent_store_req_id']))echo $res2[0]['indent_store_req_id'];?>">
                                    
                                    


   
                                    <div class="col-md-3" >
                                              <label for="exampleInputPassword1">Issue No.</label>
                                              <input type="text" class="form-control" readonly  id="issue_no" value="<?php if(!empty($res2[0]['indent_no'])){echo $res2[0]['indent_no'];}else{echo $next_issue_no;}?>"  >
                                    </div>

                                      <div class="col-md-3">
                                            <label >Date</label>
                                            <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                      </div>

                                      <div class="col-md-3">
                                            <label >Department </label>
                                              <select class="form-control" id="dept" onChange="fun_get_machine_form_dept_id(this.value,'mc_no','diff_id')">
                                                  <option value="">Select</option>
                                                      <?php 
                                                      foreach($dept as $d)
                                                      {
                                                      ?>
                                                        <option  <?php if(isset($res2[0]['dept'])){if($res2[0]['dept']==$d['department_id']){echo 'selected';}}?> value="<?php echo $d['department_id'];?>"  ><?php echo $d['name'];?></option>
                                                      <?php 
                                                      }
                                                      ?>
                                              </select>
                                      </div>

                                      <div class="col-md-3">
                                        <label >M/C No </label>
                                          <select class="form-control" id="mc_no">
                                              <option value="">Select</option>
                                              <?php 
                                                if(!empty($res2[0]['dept']) and !empty($res2[0]['mc_no']))
                                                {
                                                    $machine = $this->Machinemodel->fun_get_machine_form_dept_id($res2[0]['dept']);
                                                    foreach($machine as $m)
                                                    {
                                                      ?><option <?php if($m['mc_id'] == $res2[0]['mc_no']){ echo "selected";}?> value="<?php echo $m['mc_id'];?>"><?php echo $m['name'];?></option><?php 
                                                    }
                                                }
                                              ?>
                                          </select>
                                      </div>



                                      
   
   
                                        <!------------Row 3 start------------>
                                          <div class="col-md-12"    style=" margin-top:50px;">
                                            <div class="row-fluid">
                                              <div class="span12" >
                                                <div class="widget-box">
                                                      <!------------From start------------>
                                                      <div class="widget-content nopadding">
                                                            <div style=" margin-left:40px;">
                                                                    <input class="form-control-new" readonly  value="Product" type="text" style=" height:30px; width:200px; border:none; background-color:#f7f7f5; margin-left:5px;" />
                                                                    <input class="form-control-new" readonly  value="Grade"  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />
                                                                    <input class="form-control-new" readonly  value="Lotno"  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />
                                                                    <input class="form-control-new" readonly  value="UOM"  type="text" style=" height:30px; width:50px;border:none; background-color:#f7f7f5;" />
                                                                    <input class="form-control-new" readonly  value="Total Qty"  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />
                                                                    <input class="form-control-new" readonly  value="Issue Qty"  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />
                                                                    <input class="form-control-new" readonly  value="Issue Pkg"  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />
                                                                    <input class="form-control-new" readonly  value="Received BY"  type="text" style=" height:30px; width:100px;border:none; background-color:#f7f7f5;" />
                                                                    <!--<input class="form-control-new" readonly  value="Total Rec."  type="text" style=" height:30px; width:80px;border:none; background-color:#f7f7f5;" />-->
                                                              </div>
                                                              <?php 
                                                                  //----------------------------------update case
                                                                  if(isset($res3) and count($res3)>0)
                                                                  {
                                                                    $k=1000;
                                                                    foreach($res3 as $w)
                                                                    {
                                                                        $product_id2 = $w['product_id'];
                                                                        $product2 = $this->Productmodel->get_product_column_data_with_id($product_id2,'name');
                                                                        $pname = $product2[0]['name'];

                                                                        $cpro = $this->Productmodel->get_product_column_data_with_id($product_id2,'unit_id');
                                                                        $current_unit_name =  $this->Base->get_unit_name_from_id($cpro[0]['unit_id']);
                                                                          ?>
                                                                            <div id="readrootjr<?php echo $k;?>" style="  margin-bottom:20px; margin-top:10px;">
                                                                            
                                                                            <input type="hidden"  class="oldproductid"  id="oldproductid_<?php echo $k;?>" value="<?php echo $product_id2;?>"  />
                                                                            <input type="hidden"  class="oldlotno"  id="oldlotno_<?php echo $k;?>" value="<?php echo $w['lotno'];?>"  />
                                                                            <input type="hidden"  class="oldgrade"  id="oldgrade_<?php echo $k;?>" value="<?php echo $w['grade'];?>"  />
                                                                            <input type="hidden"  class="oldqty"  id="oldqty_<?php echo $k;?>" value="<?php echo $w['issuequnt'];?>"  />
                                                                            <input type="hidden"  class="oldamt"  id="oldamt_<?php echo $k;?>" value="<?php echo $w['amt'];?>"  />
                                                                            <input type="hidden"  class="oldpkg"  id="oldpkg_<?php echo $k;?>" value="<?php echo $w['pkg'];?>"  />

                                                                              <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick=" " id="closebutton_<?php echo $k;?>"><i class="nav-icon i-Close-Window" style="color:white;"></i></a>
                                                                              <input type="hidden"   style="height:33px;   width:200px; margin-left:5px; " class="detailsid" id="detailsid_<?php echo $k;?>"  value="<?php echo $w['details_id'];?>"  />
                                                                              <input type="text" style="height:33px;   width:200px; margin-left:5px; "   class="goods2"   id="goods2_<?php echo $k;?>"  onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_grade_lotno_list')" value="<?php echo $pname;?>" />
                                                                              <input type="hidden"  class="goods"  id="goods_<?php echo $k;?>" value="<?php echo $product_id2;?>"  />
                                                                              <select   style="height:33px; width:80px; " class="grade"  id="grade_<?php echo $k;?>">
                                                                                <option value="">Grade</option>
                                                                                <?php 
                                                                                  foreach($grade as $c)
                                                                                  {
                                                                                      ?>
                                                                                        <option <?php if(!empty($w['grade'])){ if($w['grade'] == $c['id']){ echo "selected";} } ?>   value="<?php echo $c['id'];?>">
                                                                                          <?php echo $c['name'];?>
                                                                                        </option>
                                                                                      <?php
                                                                                  }
                                                                                ?>
                                                                              </select>
                                                                              <select   style="height:33px; width:80px; " class="lotno"  id="lotno_<?php echo $k;?>" onChange="fun_issue_product_get_qty(this.id)">
                                                                                <option value="">Lotno</option>
                                                                                <option <?php if(!empty($w['lotno'])){ echo "selected"; } ?> ><?php echo $w['lotno'];?></option>
                                                                              </select>
                                                                              <input type="text"   style="height:33px; width:50px; " readonly class="uom" id="uom_<?php echo $k;?>" value="<?php echo $current_unit_name;?>" />
                                                                              <input type="text"   style="height:33px; width:80px; " readonly class="totalqty" id="totalqty_<?php echo $k;?>"   />
                                                                              <input type="number"   style="height:33px; width:80px; " class="issueqty" id="issueqty_<?php echo $k;?>"   value="<?php echo $w['issuequnt'];?>"  />
                                                                              <input type="number"   style="height:33px; width:80px; " class="issuepkg" id="issuepkg_<?php echo $k;?>"  value="<?php echo $w['pkg'];?>"  />
                                                                              <input type="text"   style="height:33px;   width:100px;  " class="receivedby" id="receivedby_<?php echo $k;?>"    value="<?php echo $w['receivedby'];?>"   />
                                                                              <input type="hidden"   style="height:33px; width:80px; " class="totalreceive" id="totalreceive_<?php echo $k;?>"    />
                                                                            </div><!--readrootjr end-->
                                                                          <?php
                                                                    $k++;
                                                                    }//foreach
                                                                  }//isset
                                                                  else
                                                                  {
                                                                      ?>
                                                                      <div id="readrootjr101" style="  margin-bottom:20px; margin-top:10px;">
                                                                            <input type="hidden"  class="oldproductid"  id="oldproductid_"  />
                                                                            <input type="hidden"  class="oldlotno"  id="oldlotno_"  />
                                                                            <input type="hidden"  class="oldgrade"  id="oldgrade_"  />
                                                                            <input type="hidden"  class="oldqty"  id="oldqty_"   />
                                                                          
                                                                          <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_"><i class="nav-icon i-Close-Window" style="color:white;"></i></a>
                                                                          <input type="hidden"   style="height:33px;   width:200px; margin-left:5px; " class="detailsid" id="detailsid_"  />
                                                                          <input type="text" style="height:33px;   width:200px; margin-left:5px; "   class="goods2"   id="goods2_"  onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_grade_lotno_list')"  />
                                                                          <input type="hidden"  class="goods"  id="goods_"  />
                                                                          <select   style="height:33px; width:80px;  " class="grade"  id="grade_">
                                                                            <option value="">Grade</option>
                                                                          </select>
                                                                          <select   style="height:33px; width:80px; " class="lotno"  id="lotno_" onChange="fun_issue_product_get_qty(this.id)">
                                                                            <option value="">Lotno</option>
                                                                          </select>
                                                                          <input type="text"   style="height:33px; width:50px; " readonly class="uom" id="uom_"  />
                                                                          <input type="text"   style="height:33px; width:80px; " readonly class="totalqty" id="totalqty_"  />
                                                                          <input type="number"   style="height:33px; width:80px; " class="issueqty" id="issueqty_"  />
                                                                          <input type="number"   style="height:33px; width:80px; " class="issuepkg" id="issuepkg_"  />
                                                                          <input type="text"   style="height:33px;   width:100px;  " class="receivedby" id="receivedby_"    />
                                                                          <input type="hidden"   style="height:33px; width:80px; " readonly class="totalreceive" id="totalreceive_"  />
                                                                      </div><!--readrootjr end-->
                                                                      <?php 
                                                                  }//else isset
                                                                  ?>
                                                                  <div class="form-group">
                                                                      <span id="writerootjr"></span>
                                                                      <input type="button" id="moreFields" class="btn btn-warning pull-left" style="width:80px" onclick="javascript:moreFields1('readrootjr','writerootjr');"  value="Add" /> 
                                                                  </div>   
                                                                  <br />
                                                                  <br />
                                                                  <br />
                                                                  <div id="readrootjr" style="display:none;  margin-bottom:20px; margin-top:10px;">
                                                                        <input type="hidden"  class="oldproductid"  id="oldproductid_"  />
                                                                        <input type="hidden"  class="oldlotno"  id="oldlotno_"  />
                                                                        <input type="hidden"  class="oldgrade"  id="oldgrade_"  />
                                                                        <input type="hidden"  class="oldqty"  id="oldqty_"   />
                                                                      <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_"><i class="nav-icon i-Close-Window" style="color:white;"></i></a>
                                                                      <input type="hidden"   style="height:33px;   width:200px; margin-left:5px; "  class="detailsid" id="detailsid_" />
                                                                      <input type="text" style="height:33px;   width:200px; margin-left:5px; "   class="goods2"   id="goods2_"  onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_grade_lotno_list')"  />
                                                                      <input type="hidden"  class="goods"  id="goods_"  />
                                                                      <select   style="height:33px; width:80px; " class="grade"  id="grade_">
                                                                        <option value="">Grade</option>
                                                                      </select>
                                                                      <select   style="height:33px; width:80px;" class="lotno"  id="lotno_" onChange="fun_issue_product_get_qty(this.id)">
                                                                        <option value="">Lotno</option>
                                                                      </select>
                                                                      <input type="text"   style="height:33px; width:50px; " readonly class="uom" id="uom_"  />
                                                                      <input type="text"   style="height:33px; width:80px; " readonly class="totalqty" id="totalqty_"  />
                                                                      <input type="number"   style="height:33px; width:80px; " class="issueqty" id="issueqty_"  />
                                                                      <input type="number"   style="height:33px; width:80px; " class="issuepkg" id="issuepkg_"  />
                                                                      <input type="text"   style="height:33px;   width:100px;  " class="receivedby" id="receivedby_"    />
                                                                      <input type="hidden"   style="height:33px; width:80px; " readonly class="totalreceive" id="totalreceive_"  />
                                                                  </div><!--readrootjr end-->

                                                      </div>
                                                <!------------form close------------>
                                                </div>			
                                              </div>
                                            </div>
                                          </div>
                                          <!------------Row 3 close------------>  
                                      
                                      
                                                          
   
                                          <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">   
            			                            <div class="panel-body">
                                       
                                                  <div class="col-md-4" style="height:80px; float:left">
                                                      <label  >Comment </label>
                                                      <input type="text" class="form-control" id="comment"  value="<?php if(isset($res2[0]['comment'])){echo $res2[0]['comment'];}?>" >
                                                  </div>
                                                  
                                                  
                                                    <div class="col-md-4" style="height:80px;float:left">
                                                      <label  >Indentor</label>
                                                      <input type="text" class="form-control" id="indentor"  onKeyUp="op_search(this.id)" value="<?php if(isset($res2[0]['indentor'])){echo $res2[0]['indentor'];}?>" onKeyUp="op_search(this.id)">
                                                  </div>
                                                  
                                                  
                                                  <div class="col-md-4" style="height:80px;float:left">
                                                      <label  >Requested By</label>
                                                      <input type="text" class="form-control" id="request_by"  onKeyUp="op_search(this.id)" value="<?php if(isset($res2[0]['request_by'])){echo $res2[0]['request_by'];}?>" onKeyUp="op_search(this.id)">
                                                  </div>
                                        
                                              </div>
                                          </div>   

                                          <div class="col-md-12">
                                            <label >Stage </label>
                                            <select class="form-control" id="current_stage">
                                                <option  value="1">Send to Store</option>
                                                <?php if(isset($res2[0]['stage']) and $res2[0]['stage'] == 1 ){?>
                                                  <option selected value="2">Approve</option>
                                                  <option value="9">Reject</option>
                                                <?php }elseif(isset($res2[0]['stage']) and $res2[0]['stage'] == 2 ){?>
                                                  <option selected value="2">Approve</option>
                                                  <option value="9">Reject</option>
                                                <?php }elseif(isset($res2[0]['stage']) and $res2[0]['stage'] == 9 ){?>
                                                  <option  value="2">Approve</option>
                                                  <option selected value="9">Reject</option>
                                                <?php }?>                                            
                                            </select>
                                          </div>   
   
                                               
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="stock_issue_save" >Save</button>
                                                    </div>
                                              </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/product_js');?>


