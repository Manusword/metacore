<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
?>  
            
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Long Testing Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Log Sheet QC</div>
                                    <div class="form-row">
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                          
                                      
                                          <div class="col-md-4" style="margin-top:10px">
                                                <label >Production Date</label>
                                                <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                          </div>
 
                                          <div class="col-md-4" style="margin-top:10px">
                                                <label>Shift</label>
                                                      <select class="form-control" id="shift">
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='A'){echo "selected";}}?> >A</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='B'){echo "selected";}}?>>B</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='C'){echo "selected";}}?>>C</option>
                                                      </select>
                                          </div> 


                                          <div class="col-md-4" style="margin-top:10px">
                                              <label>Base Size (mm) <span style="color:red;">(After point 3 Diigt)<span></label>
                                              <input type="number" class="form-control"  id="base_size" required  autocomplete="off" value="<?php if(isset($res2[0]['base_size']))echo $res2[0]['base_size'];?>" >
                                        </div>


                                        <div class="col-md-3" style="margin-top:10px">
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

                                            <div class="col-md-3" style="margin-top:10px">
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



                                            <div class="col-md-3" style="margin-top:10px">
                                              <label>Grade</label>
                                                  <select class="form-control" name="product_grade" id="product_grade">
                                                      <option  <?php if(isset($res2[0]['product_grade'])){if($res2[0]['product_grade']==''){echo "selected";}}?>  value="">Select</option>
                                                          <?Php 
                                                            foreach($grade as $c)
                                                            {
                                                              ?>
                                                                <option 
                                                                <?php 
                                                                  if(isset($res2[0]['product_grade'])){if($res2[0]['product_grade']==$c['id']){echo "selected";}}
                                                                ?> 
                                                                value="<?php echo $c['id'];?>">
                                                                    <?php echo $c['name'];?>
                                                                </option>
                                                              <?php
                                                            }
                                                          ?>		
                                                  </select>
                                        </div> 

                                        <div class="col-md-3" style="margin-top:10px">
                                              <label>Batch / Heat No</label>
                                              <input type="text" class="form-control"  id="batch_no" required  autocomplete="off" value="<?php if(isset($res2[0]['batch_no']))echo $res2[0]['batch_no'];?>" >
                                        </div>


                                        
                                        <div class="col-md-4" style="margin-top:10px">
                                                <label  >Product Type</label>
                                                <select class="form-control" id="product_type">
                                                  <option value="">Select</option>
                                                  <?php 
                                                    foreach($product_type as $u)
                                                    {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['product_type'])){if($u['id']==$res2[0]['product_type']){ echo "selected";}}?> value="<?php echo $u['id'];?>" ><?php echo $u['name'];?></option>
                                                      <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                          <div class="col-md-4" style="margin-top:10px">
                                                <label>Finish Size (mm) <span style="color:red;">(After point 3 Diigt)<span></label>
                                                <input type="number" class="form-control"  id="finish_size" required  autocomplete="off" value="<?php if(isset($res2[0]['finish_size']))echo $res2[0]['finish_size'];?>"   >
                                          </div>





                                          <div class="col-md-4" style="margin-top:10px">
                                              <label>Coil dia (mm)</label>
                                              <input type="number" class="form-control"  id="coil_dia" required  autocomplete="off" value="<?php if(isset($res2[0]['coil_dia']))echo $res2[0]['coil_dia'];?>"   >
                                          </div>

                                          <div class="col-md-12">
                                            <hr>
                                        </div>

                                       


                                        <div class="col-md-4" style="margin-top:10px">
                                              <label>Coil No From</label>
                                              <input type="number" class="form-control"  id="coil_dia_from" required  autocomplete="off" value="<?php if(isset($res2[0]['coil_dia_from']))echo $res2[0]['coil_dia_from'];?>" >
                                        </div>

                                        <div class="col-md-4" style="margin-top:10px">
                                              <label>Coil No To</label>
                                              <input type="number" class="form-control"  id="coil_dia_to" required  autocomplete="off" value="<?php if(isset($res2[0]['coil_dia_to']))echo $res2[0]['coil_dia_to'];?>" >
                                        </div>


                                        <div class="col-md-4" style="margin-top:10px">
                                              <label>Total Coils</label>
                                              <input type="number" class="form-control"  id="total_coils" required  autocomplete="off" value="<?php if(isset($res2[0]['total_coils']))echo $res2[0]['total_coils'];?>" >
                                        </div>


                                        <div class="col-md-4" style="margin-top:10px">
                                              <label>Total Pass Colis</label>
                                              <input type="number" class="form-control"  id="total_pass_coils" required  autocomplete="off" value="<?php if(isset($res2[0]['total_pass_coils']))echo $res2[0]['total_pass_coils'];?>" >
                                        </div>

                                        <div class="col-md-4" style="margin-top:10px">
                                              <label>No. of NC Coils</label>
                                              <input type="number" class="form-control"  id="total_nc_coils" required  autocomplete="off" value="<?php if(isset($res2[0]['total_nc_coils']))echo $res2[0]['total_nc_coils'];?>" >
                                        </div>

                                           <div class="col-md-4" style="margin-top:10px">
                                                <label  >Operator Name</label>
                                                <input type="text" class="form-control" id="operator1"   onKeyUp="op_search(this.id)" value="<?php if(isset($res2[0]['operator1']))echo $res2[0]['operator1'];?>" >
                                            </div>




                                        <div class="col-md-4" style="margin-top:10px">
                                              <label>Reason of NC</label>
                                              <input type="text" class="form-control"  id="nc_reason" required  autocomplete="off" value="<?php if(isset($res2[0]['nc_reason']))echo $res2[0]['nc_reason'];?>"   >
                                        </div>



                                        <div class="col-md-4" style="margin-top:10px">
                                          <label >Select Customer </label>
                                          <select  class="form-control"  style=" width: 100%" id="customer_id" >
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

                                          <div class="col-md-4" style="margin-top:10px">
                                              <label>Diversion</label>
                                              <input type="text" class="form-control"  id="diversion" required  autocomplete="off" value="<?php if(isset($res2[0]['diversion']))echo $res2[0]['diversion'];?>"   >
                                        </div>











                                       



                                         
                                            
                                            



                                      

                                        
                                       
                                       
                                         

                                        
                                       
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="log_test_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/qc_js');?>


