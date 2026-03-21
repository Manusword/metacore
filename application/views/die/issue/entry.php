<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
?>  
            
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1 >Issue / Return Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                <div class="col-md-7" id="today_die_history_list"></div>
                
                    <div class="col-md-5">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" align="center" >Issue / Return Entry <br> <span id="ddie_out" style="color:red"></span></div>
                                    <div class="form-row">
                                          
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                          
                                     
                                        <div class="col-md-12" style=" margin-bottom:10px;">
                                            <label>Date <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="entry_date" name="entry_date" value="<?php echo date('d-m-Y');?>">
                                        </div>
                                        
                                        
                                        <div class="col-md-4" style=" margin-top:10px;">
                                                 <label>Die No.<span style="color:red">*</span></label>
                                                 <input type="text" class="form-control" id="die_no" name="die_no"  minlength="4" required onKeyUp="fun_die_no_check_issue(this.value)" >
                                        </div>
                                        
                                      	<div class="col-md-4" style=" margin-top:10px;">
                                            <label  >Manuf. No.</label>
                                            <input type="text" class="form-control" id="menu_no"  name="menu_no" readonly>
                                        </div>
                                        
                                      
                                         <div class="col-md-4" style=" margin-top:10px;">
                                            <label  >Pallet </label>
                                            <input type="text" class="form-control" id="pallet"  readonly >
                                        </div>
                                        
                                        
                                        <div class="col-md-4" style=" margin-top:10px; color:red; font-weight:bold">
                                            <label>From Location </label>
                                            <input type="text" class="form-control" id="old_location" style="border-color:red"  readonly>
                                        </div>


                                        <div class="col-md-4" style=" margin-top:10px;" >
                                            <label  >Old M/C No.</label>
                                            <select class="form-control" id="old_mc">
                                            	<option value="">Select</option>
                                                <?php 
                                                foreach($mc as $d){
                                                ?>
                                                <option  value="<?php echo $d['mc_id'];?>"><?php echo $d['dname'].' : '.$d['mname'].' ';?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                         

                                        <div class="col-md-4" style=" margin-top:10px;">
                                            <label>Size </label>
                                            <input type="text" class="form-control"  id="old_size"  readonly>
                                        </div>
                                        

                                        <div class="col-md-12" style=" margin-top:10px;"><hr> </div>
                                          
                                        <div class="col-md-6" style=" margin-top:10px;color:green; font-weight:bold">
                                            <label>To Location </label>
                                            <input type="text" class="form-control" id="new_location" style="border-color:green"  readonly>
                                        </div>

                                        <div class="col-md-6" style=" margin-top:10px; display: none;" id="new_size_list">
                                            <label>Current Size </label>
                                            <input type="number" class="form-control"  id="new_size"  >
                                        </div>


                                        <div class="col-md-6" style=" margin-top:10px; display: none;" id="mc_list" >
                                            <label  >M/C No.<span style="color:red">*</span></label>
                                            <select class="form-control" name="mc" id="mc">
                                            	<option value="">Select</option>
                                                <?php 
                                                foreach($mc as $d){
                                                ?>
                                                <option <?php if(isset($res2[0]['mc_id'])){  if($res2[0]['mc_id']==$d['mc_id']){echo "selected";} }?> value="<?php echo $d['mc_id'];?>"><?php echo $d['dname'].' : '.$d['mname'].' ';?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        
                                        
                                       
                                       
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="issue_return_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/ddie_js');?>


