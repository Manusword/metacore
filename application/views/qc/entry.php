        

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>QC Specification Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >QC Specification Entry</div>
                                    <div class="form-row">
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                
                                        <div class="col-md-3">
                                              <label>Type 1</label>
                                                  <select class="form-control" name="type1" id="type1">
                                                      <option  <?php if(isset($res2[0]['type1'])){if($res2[0]['type1']==''){echo "selected";}}?>  value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['type1'])){if($res2[0]['type1']=='IPT'){echo "selected";}}?>  value="IPT">In Process Testing</option>
                                                  </select>
                                        </div> 

                                        <div class="col-md-3">
                                              <label>Type 2</label>
                                                  <select class="form-control" name="type2" id="type2">
                                                      <option  <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']==''){echo "selected";}}?>  value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='SW'){echo "selected";}}?>  value="SW">High Carbon Steel Wire</option>
                                                      <option  <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='GI'){echo "selected";}}?>  value="GI">GI Rope Wire</option>
                                                  </select>
                                        </div> 


                                        <div class="col-md-3">
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

                                        <div class="col-md-3">
                                              <label>Product Type</label>
                                                  <select class="form-control"  id="product_type">
                                                      <option  <?php if(isset($res2[0]['product_type'])){if($res2[0]['product_type']==''){echo "selected";}}?>  value="">Select</option>
                                                          <?Php 
                                                            foreach($product_type as $c)
                                                            {
                                                              ?>
                                                                <option 
                                                                <?php 
                                                                  if(isset($res2[0]['product_type'])){if($res2[0]['product_type']==$c['id']){echo "selected";}}
                                                                ?> 
                                                                value="<?php echo $c['id'];?>">
                                                                    <?php echo $c['name'];?>
                                                                </option>
                                                              <?php
                                                            }
                                                          ?>		
                                                  </select>
                                        </div> 


                                        <div class="col-md-12">
                                            <hr>
                                        </div>

                                        <div class="col-md-12" style="margin-bottom:10px">
                                              <label>Dia (Size)</label>
                                              <input type="number" class="form-control"  id="size" required  autocomplete="off" value="<?php if(isset($res2[0]['size']))echo $res2[0]['size'];?>" >
                                        </div>

                                        <div class="col-md-2">
                                              <label>Min Tolerance</label>
                                              <input type="number" class="form-control"  id="min_tole" required  autocomplete="off" value="<?php if(isset($res2[0]['min_tole']))echo $res2[0]['min_tole'];?>"  onKeyUp="fun_min_tole()" >
                                        </div>

                                        <div class="col-md-2">
                                              <label>Min Tolerance (Size)</label>
                                              <input type="number" class="form-control"  id="min_size" required  autocomplete="off" value="<?php if(isset($res2[0]['min_size']))echo $res2[0]['min_size'];?>"   >
                                        </div>

                                        <div class="col-md-2">
                                              <label>Max Tolerance</label>
                                              <input type="number" class="form-control"  id="max_tole" required  autocomplete="off" value="<?php if(isset($res2[0]['max_tole']))echo $res2[0]['max_tole'];?>" onKeyUp="fun_max_tole()"   >
                                        </div>

                                        <div class="col-md-2">
                                              <label>Max Tolerance (Size)</label>
                                              <input type="number" class="form-control"  id="max_size" required  autocomplete="off" value="<?php if(isset($res2[0]['max_size']))echo $res2[0]['max_size'];?>"   >
                                        </div>

                                        <div class="col-md-2">
                                              <label>Ovality Max</label>
                                              <input type="number" class="form-control"  id="ovality_max" required  autocomplete="off" value="<?php if(isset($res2[0]['ovality_max']))echo $res2[0]['ovality_max'];?>" onKeyUp="fun_max_ovality()"   >
                                        </div>

                                        <div class="col-md-2">
                                              <label>Ovality Max (size)</label>
                                              <input type="number" class="form-control"  id="ovality_size_max" required  autocomplete="off" value="<?php if(isset($res2[0]['ovality_size_max']))echo $res2[0]['ovality_size_max'];?>"   >
                                        </div>


                                        <div class="col-md-12">
                                            <hr>
                                            <h4 align='center'>Tensile Strength (Kg/mm<sup>2</sup>)</h4>
                                        </div>

                                        <div class="col-md-2">
                                              <label>SS-1 (SL) Min</label>
                                              <input type="number" class="form-control"  id="ts_min_ss1" required  autocomplete="off" value="<?php if(isset($res2[0]['ts_min_ss1']))echo $res2[0]['ts_min_ss1'];?>"   >
                                        </div>
                                        <div class="col-md-2">
                                              <label>SS-1 (SL) Max</label>
                                              <input type="number" class="form-control"  id="ts_max_ss1" required  autocomplete="off" value="<?php if(isset($res2[0]['ts_max_ss1']))echo $res2[0]['ts_max_ss1'];?>"   >
                                        </div>

                                        <div class="col-md-2">
                                              <label>SS-2 (SM) Min</label>
                                              <input type="number" class="form-control"  id="ts_min_ss2" required  autocomplete="off" value="<?php if(isset($res2[0]['ts_min_ss2']))echo $res2[0]['ts_min_ss2'];?>"   >
                                        </div>
                                        <div class="col-md-2">
                                              <label>SS-2 (SM) Max</label>
                                              <input type="number" class="form-control"  id="ts_max_ss2" required  autocomplete="off" value="<?php if(isset($res2[0]['ts_max_ss2']))echo $res2[0]['ts_max_ss2'];?>"   >
                                        </div>

                                        <div class="col-md-2">
                                              <label>SS-3 (DM) Min</label>
                                              <input type="number" class="form-control"  id="ts_min_ss3" required  autocomplete="off" value="<?php if(isset($res2[0]['ts_min_ss3']))echo $res2[0]['ts_min_ss3'];?>"   >
                                        </div>
                                        <div class="col-md-2">
                                              <label>SS-3 (DM) Max</label>
                                              <input type="number" class="form-control"  id="ts_max_ss3" required  autocomplete="off" value="<?php if(isset($res2[0]['ts_max_ss3']))echo $res2[0]['ts_max_ss3'];?>"   >
                                        </div>

                                        <div class="col-md-12" style="margin-top:10px">
                                              <label>Remarks</label>
                                              <input type="text" class="form-control"  id="remarks" required  autocomplete="off" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>"   >
                                        </div>

                                       
                                       
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="spec1_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/qc_js');?>


