<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
?>  
            
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>QC In Process Testing Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >In Process Testing Register (D.W.D)</div>
                                    <div class="form-row">
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                      <input type="hidden" id="type1"  value="<?php if(isset($res2[0]['type1']))echo $res2[0]['type1'];?>">
                                          
                                      
                                          <div class="col-md-4">
                                                <label >Date</label>
                                                <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                          </div>

                                          <div class="col-md-4">
                                                <label>Shift</label>
                                                      <select class="form-control" id="shift">
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='A'){echo "selected";}}?> >A</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='B'){echo "selected";}}?>>B</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='C'){echo "selected";}}?>>C</option>
                                                      </select>
                                          </div> 


                                          <div class="col-md-4">
                                                <label>Type 2</label>
                                                      <select class="form-control" name="type2" id="type2">
                                                            <option  <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']==''){echo "selected";}}?>  value="">Select</option>
                                                            <option  <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='SW'){echo "selected";}}?>  value="SW">High Carbon Steel Wire</option>
                                                            <option  <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='GI'){echo "selected";}}?>  value="GI">GI Rope Wire</option>
                                                      </select>
                                          </div> 

                                        <div class="col-md-4" style="margin-bottom:10px">
                                              <label>Dia (Size)</label>
                                              <input type="number" class="form-control"  id="size" required  autocomplete="off" value="<?php if(isset($res2[0]['size']))echo $res2[0]['size'];?>" >
                                        </div>


                                        <div class="col-md-4">
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

                                        <div class="col-md-4" >
                                              <label>Lotno</label>
                                              <input type="text" class="form-control"  id="lotno" required  autocomplete="off" value="<?php if(isset($res2[0]['lotno']))echo $res2[0]['lotno'];?>" >
                                        </div>



                                         
                                            
                                            <div class="col-md-6">
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

                                            <div class="col-md-6">
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



                                        <div class="col-md-12">
                                            <hr>
                                        </div>

                                       

                                        <div class="col-md-3">
                                              <label>Coil no</label>
                                              <input type="number" class="form-control"  id="coil_no" required  autocomplete="off" value="<?php if(isset($res2[0]['coil_no']))echo $res2[0]['coil_no'];?>"   >
                                        </div>

                                        <div class="col-md-3">
                                              <label>Finish Size</label>
                                              <input type="number" class="form-control"  id="finish_size" required  autocomplete="off" value="<?php if(isset($res2[0]['finish_size']))echo $res2[0]['finish_size'];?>"   >
                                        </div>

                                        <div class="col-md-3">
                                              <label>Breaking Load</label>
                                              <input type="number" class="form-control"  id="breaking_load" required  autocomplete="off" value="<?php if(isset($res2[0]['breaking_load']))echo $res2[0]['breaking_load'];?>"   >
                                        </div>

                                        <div class="col-md-3">
                                              <label>UTS Kgf/mm<sup>2</sup></label>
                                              <input type="number" class="form-control"  id="uts" required  autocomplete="off" value="<?php if(isset($res2[0]['uts']))echo $res2[0]['uts'];?>"   >
                                        </div>

                                        <div class="col-md-3">
                                              <label>Torsion Test</label>
                                              <input type="text" class="form-control"  id="torsion_test" required  autocomplete="off" value="<?php if(isset($res2[0]['torsion_test']))echo $res2[0]['torsion_test'];?>"  >
                                        </div>

                                        <div class="col-md-3">
                                              <label>Band Test</label>
                                              <input type="text" class="form-control"  id="bend_test" required  autocomplete="off" value="<?php if(isset($res2[0]['bend_test']))echo $res2[0]['bend_test'];?>"   >
                                        </div>

                                        <div class="col-md-3">
                                              <label>% RA</label>
                                              <input type="number" class="form-control"  id="ra_per" required  autocomplete="off" value="<?php if(isset($res2[0]['ra_per']))echo $res2[0]['ra_per'];?>"   >
                                        </div>

                                        <div class="col-md-3">
                                              <label>No. Scratch Brightness</label>
                                              <input type="text" class="form-control"  id="scratch_brigitness" required  autocomplete="off" value="<?php if(isset($res2[0]['scratch_brigitness']))echo $res2[0]['scratch_brigitness'];?>"   >
                                        </div>

                                       
                                        <div class="col-md-6" style="margin-top:10px">
                                              <label>Remarks</label>
                                              <input type="text" class="form-control"  id="remarks" required  autocomplete="off" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>"   >
                                        </div>

                                          <div class="col-md-6" style="margin-top:10px">
                                                <label>Status</label>
                                                <select class="form-control" id="status">
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Active'){echo "selected";}}?>  value="Active">Active</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Delete'){echo "selected";}}?>  value="Delete">Delete</option>
                                                </select>
                                          </div> 

                                        
                                       
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="test1_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/qc_js');?>


