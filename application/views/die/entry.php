<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
?>  
            
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>New Die Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                <div class="col-md-3"></div>
                    <div class="col-md-5">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Die Entry <br> <span id="ddie_out" style="color:red"></span></div>
                                    <div class="form-row">
                                          
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                          
                                      
                                        <div class="col-md-6">
                                            <label>Date <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="entry_date" name="entry_date"   value="<?php echo $entry_date;?>">
                                        </div>


                                        <div class="col-md-6" style=" margin-top:10px; margin-bottom:10px;">
                                            <label  >Die Type <span style="color:red">*</span></label>
                                            <select class="form-control" name="die_type" id="die_type">
                                            	<option  value="">Select</option>
                                                <option <?php if(isset($res2[0]['die_type'])){  if($res2[0]['die_type']=='D'){echo "selected";} }?> >D</option>
                                                <option <?php if(isset($res2[0]['die_type'])){  if($res2[0]['die_type']=='M'){echo "selected";} }?> >M</option>
                                                <option <?php if(isset($res2[0]['die_type'])){  if($res2[0]['die_type']=='W'){echo "selected";} }?> >W</option>
                                            </select>
                                        </div>
                                
                                        
                                        <div class="col-md-6">
                                            <label>Die No <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="die_no" name="die_no"  minlength="4" required onKeyUp="fun_die_no_check(this.value)" value="<?php if(isset($res2[0]['die_no'])){echo $res2[0]['die_no'];}?>">
                                        </div>
                                        
                                        
                                        
                                      	 <div class="col-md-6">
                                            <label  >Manufacturing  Die No <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="menu_no"  name="menu_no" required value="<?php if(isset($res2[0]['menu_no'])){echo $res2[0]['menu_no'];}?>">
                                        </div>
                                        
                                        
                                         <div class="col-md-6" style=" margin-top:10px;">
                                            <label  >Size <span style="color:red">*</span></label>
                                            <input type="text" class="form-control" id="size"  placeholder="0.225" name="size" required value="<?php if(isset($res2[0]['menu_no'])){echo $res2[0]['size'];}?>">
                                        </div>
                                        
                                        
                                         <div class="col-md-6" style=" margin-top:10px;">
                                            <label  >Pallet <span style="color:red">*</span></label>
                                            <select class="form-control" name="pallet" id="pallet">
                                            	<option value="">Select</option>
                                                <?php 
                                                foreach($die as $d){
                                                ?>
                                                <option <?php if(isset($res2[0]['pallet_id'])){  if($res2[0]['pallet_id']==$d['id']){echo "selected";} }?> value="<?php echo $d['id'];?>"><?php echo $d['pallet'].' ('.$d['code'].')';?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        
                                        
                                        <div class="col-md-6" style=" margin-top:10px;">
                                            <label  >Location <span style="color:red">*</span></label>
                                            <select class="form-control" name="location" id="location" onChange="fun_loaction(this.value)">
                                            	<option value="">Select</option>
                                                <option <?php if(isset($res2[0]['location'])){  if($res2[0]['location']=='Stock'){echo "selected";} }?>>Stock</option>
                                                <option <?php if(isset($res2[0]['location'])){  if($res2[0]['location']=='M/C'){echo "selected";} }?>>M/C</option>
                                                <option <?php if(isset($res2[0]['location'])){  if($res2[0]['location']=='Repair'){echo "selected";} }?>>Repair</option>
                                                <option <?php if(isset($res2[0]['location'])){  if($res2[0]['location']=='Scrap'){echo "selected";} }?>>Scrap</option>
                                               
                                            </select>
                                        </div>
                                        
                                       
                                       <?php 
                                          if(isset($res2[0]['location']) and $res2[0]['location']=='M/C')
                                          {  
                                                ?>
                                                      <div class="col-md-6" style=" margin-top:10px;" id="mc_out">
                                                <?php	
                                          }
                                          else
                                          {
                                          ?>
                                                <div class="col-md-6" style=" margin-top:10px; display:none;" id="mc_out">
                                          <?php
                                          }
                                          ?> 
                                        	 <label  >M/C No.<span style="color:red">*</span></label>
                                            <select class="form-control" name="mc" id="mc">
                                            	<option value="">Select</option>
                                                <?php 
                                                foreach($mc as $d){
                                                ?>
                                                <option <?php if(isset($res2[0]['mc_id'])){  if($res2[0]['mc_id']==$d['mc_id']){echo "selected";} }?> value="<?php echo $d['mc_id'];?>"><?php echo $d['dname'].' : '.$d['mname'].'';?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        
           
                                        

                                     
                                       
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="new_die_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/ddie_js');?>


