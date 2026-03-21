        

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Product</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Product</div>
                                    <div class="form-row">
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['product_id']))echo $res2[0]['product_id'];?>">
                                
                                        <div class="col-md-4">
                                              <label>Select Category</label>
                                                  <select class="form-control" name="product_cat" id="product_cat">
                                                      <option  <?php if(isset($res2[0]['category_id'])){if($res2[0]['category_id']==''){echo "selected";}}?>  value="">Select</option>
                                                          <?Php 
                                                            foreach($category as $c)
                                                            {
                                                          ?>
                                                            <option 
                                                          <?php 
                                                          if(isset($selected_product_cat))
                                                          {
                                                            if($selected_product_cat==$c['category_id']){echo "selected";}
                                                          }
                                                          else
                                                          {
                                                            if(isset($res2[0]['category_id'])){if($res2[0]['category_id']==$c['category_id']){echo "selected";}}
                                                          }
                                                          ?> 
                                                            value="<?php echo $c['category_id'];?>">
                                                                <?php echo $c['name'];?>
                                                            </option>
                                                          <?php
                                                            }
                                                          ?>		
                                                  </select>
                                        </div> 

                                        <div class="col-md-4">
                                              <label >Product Full Name Or Code<span style="color:red;" id="product_dis_id"></span></label>
                                              <input type="text" class="form-control"   name="name" id="productname_" required  autocomplete="off" value="<?php if(isset($res2[0]['name']))echo $res2[0]['name'];?>"    onKeyUp="fun_get_product(this.id,'productname_','productname_','same_id_one_search')">
                                        </div>

                                        
                                          <div class="col-md-4">
                                                <label >Details </label>
                                                <input type="text" class="form-control"   name="details" id="details" required  autocomplete="off" value="<?php if(isset($res2[0]['details']))echo $res2[0]['details'];?>" >
                                          </div>
                                          
                                          
                                          
                                          <div class="col-md-3">
                                                <label >Days for Min Level</label>
                                                <input type="number" class="form-control"   name="no_of_days" id="no_of_days" required  autocomplete="off" value="<?php if(isset($res2[0]['no_of_days']))echo $res2[0]['no_of_days'];?>">
                                          </div>

                                          <div class="col-md-3">
                                                <label >Min Level</label>
                                                <input type="number" class="form-control"   name="economic" id="economic" required  autocomplete="off" value="<?php if(isset($res2[0]['economic']))echo $res2[0]['economic'];?>">
                                          </div>
                                          
                                          
                                          <div class="col-md-3">
                                                <label >Re-order Level</label>
                                                <input type="number" class="form-control"   name="reorder" id="reorder" required  autocomplete="off" value="<?php if(isset($res2[0]['reorder']))echo $res2[0]['reorder'];?>">
                                          </div>
                                      
                                          <div class="col-md-3">
                                                <label >Max Level</label>
                                                <input type="number" class="form-control"   name="max_level" id="max_level" required  autocomplete="off" value="<?php if(isset($res2[0]['max_level']))echo $res2[0]['max_level'];?>">
                                          </div>
                                          
                                          
                                          <div class="col-md-6">
                                                <label >Size in nos. (Eg: 0.35,1.350) mm</label>
                                                <input type="number" class="form-control"   name="size" id="size" required  autocomplete="off" value="<?php if(isset($res2[0]['size']))echo $res2[0]['size'];?>">
                                          </div>
                                          
                                        
                                          <div class="col-md-6">
                                                    <label >Select Unit</label>
                                                    <select class="form-control"  name="unit" id="unit1">
                                                          <option  <?php if(isset($res2[0]['unit_id'])){if($res2[0]['unit_id']==''){echo "selected";}}?>  value="">Select</option>
                                                            <?Php 
                                                              foreach($unit as $c)
                                                              {
                                                                ?>
                                                                  <option 
                                                                  <?php 
                                                                  if(isset($selected_unit))
                                                                  {
                                                                    if($selected_unit==$c['unit_id']){echo "selected";}
                                                                  }
                                                                  else
                                                                  {
                                                                    if(isset($res2[0]['unit_id'])){if($res2[0]['unit_id']==$c['unit_id']){echo "selected";}}
                                                                  }
                                                                  ?> 
                                                                  value="<?php echo $c['unit_id'];?>"><?php echo $c['name'];?>
                                                                </option>
                                                              <?php
                                                              }
                                                            ?>	
                                                    </select>
                                            </div>
                                            
                                            
                                            
                                            <div class="col-md-3">
                                                        <label >Is Product Repeated ?</label>
                                                        <select class="form-control"   id="is_repeated">
                                                              <option  <?php if(isset($res2[0]['repeated'])){if($res2[0]['repeated']==''){echo "selected";}}?>  value="">Select</option>
                                                              <option <?php if(isset($res2[0]['repeated'])){if($res2[0]['repeated']=='1'){echo "selected";}}?> value="1">Yes</option>
                                                              <option <?php if(isset($res2[0]['repeated'])){if($res2[0]['repeated']=='0'){echo "selected";}}?> value="0">No</option>
                                                        </select>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                    <label >Is it Row Matrial ?</label>
                                                    <select class="form-control"   id="row_mat_puc">
                                                          <option  <?php if(isset($res2[0]['row_mat_puc'])){if($res2[0]['row_mat_puc']==''){echo "selected";}}?>  value="">Select</option>
                                                          <option <?php if(isset($res2[0]['row_mat_puc'])){if($res2[0]['row_mat_puc']=='1'){echo "selected";}}?> value="1">Yes</option>
                                                          <option <?php if(isset($res2[0]['row_mat_puc'])){if($res2[0]['row_mat_puc']=='0'){echo "selected";}}?> value="0">No</option>
                                                    </select>
                                            </div>

                                            <div class="col-md-3">
                                                    <label >Is it Consumable ?</label>
                                                    <select class="form-control"   id="con_mat_puc">
                                                          <option  <?php if(isset($res2[0]['con_mat_puc'])){if($res2[0]['con_mat_puc']==''){echo "selected";}}?>  value="">Select</option>
                                                          <option <?php if(isset($res2[0]['con_mat_puc'])){if($res2[0]['con_mat_puc']=='1'){echo "selected";}}?> value="1">Yes</option>
                                                          <option <?php if(isset($res2[0]['con_mat_puc'])){if($res2[0]['con_mat_puc']=='0'){echo "selected";}}?> value="0">No</option>
                                                    </select>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                  <label >Active / Deactive</label>
                                                  <select class="form-control" style="width: 100%; " name="active" id="active">
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Active'){echo "selected";}}?>  value="Active">Active</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Deactive'){echo "selected";}}?> value="Deactive">Deactive</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Pending'){echo "selected";}}?> value="Pending">Pending</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Banned'){echo "selected";}}?> value="Banned">Banned</option>
                                                  </select>
                                            </div>
                                               
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="product_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/product_js');?>


