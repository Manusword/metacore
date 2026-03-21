<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
   if(isset($res2[0]['target_date'])){$target_date=$this->Base->change_date_dmy($res2[0]['target_date']);}else{$target_date='';}
   if(!empty($res2[0]['comp_date']) and $res2[0]['comp_date']!='0000-00-00'){$comp_date=$this->Base->change_date_dmy($res2[0]['comp_date']);}else{$comp_date='';}
?>  
            

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Minutes of Meeting</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New MOM Point</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['mom_id']))echo $res2[0]['mom_id'];?>">
                                  
                                            <div class="col-md-4">
                                                  <label for="exampleInputEmail1">Date Of Meeting <span style="color:red;" id="product_dis_id"></span></label>
                                                  <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                            </div>
                                            
                                            <div class="col-md-4">
                                                  <label for="exampleInputEmail1">Coordinator </label>
                                                  <input type="text" class="form-control"    id="chair_person" required  autocomplete="off" value="<?php if(isset($res2[0]['chair_person']))echo $res2[0]['chair_person'];?>">
                                            </div>
                                            
                                            <div class="col-md-4">
                                                  <label for="exampleInputEmail1">Participants</label>
                                                  <input type="text" class="form-control"    id="participants" required  autocomplete="off" value="<?php if(isset($res2[0]['participants']))echo $res2[0]['participants'];?>">
                                            </div>
                                            
                                            
                                            <div class="col-md-12">
                                                  <label for="exampleInputEmail1">Review Points</label>
                                                  <textarea  class="form-control"  id="review_point" required  autocomplete="off"><?php if(isset($res2[0]['review']))echo $res2[0]['review'];?></textarea>
                                            </div>
                                        
                                            <div class="col-md-6">
                                                  <label for="exampleInputEmail1">Current Status</label>
                                                  <input type="text" class="form-control"  id="current_status" required  autocomplete="off" value="<?php if(isset($res2[0]['current_status']))echo $res2[0]['current_status'];?>">
                                            </div>
                                            
                                            <div class="col-md-6">
                                                  <label for="exampleInputEmail1">Action Taken (Resource Required If)</label>
                                                  <input type="text" class="form-control"  id="action_taken" required  autocomplete="off" value="<?php if(isset($res2[0]['action_taken']))echo $res2[0]['action_taken'];?>">
                                            </div>
                                            
                                            <div class="col-md-3">
                                                  <label for="exampleInputEmail1">RESP.</label>
                                                  <input type="text" class="form-control"  id="resp" required  autocomplete="off" value="<?php if(isset($res2[0]['resp']))echo $res2[0]['resp'];?>">
                                            </div>
                                            
                                            <div class="col-md-3">
                                                  <label for="exampleInputEmail1">Target Date</label>
                                                  <input type="text" class="form-control"  id="target_date" required  autocomplete="off" value="<?php if(isset($target_date))echo $target_date;?>" >
                                            </div>
                                            
                                            <div class="col-md-3">
                                                  <label for="exampleInputEmail1">Completed Date</label>
                                                  <input type="text" class="form-control"  id="comp_date" required  autocomplete="off" value="<?php if(isset($comp_date))echo $comp_date;?>" >
                                            </div>
                                            
                                            <div class="col-md-3">
                                                  <label for="exampleInputEmail1">Status</label>
                                                    <select class="form-control"  name="active" id="active">
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Pending'){echo "selected";}}?>  value="Pending">Pending</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Under Progress'){echo "selected";}}?>  value="Under Progress">Under Progress</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Completed'){echo "selected";}}?> value="Completed">Completed</option>
                                                    </select>
                                            </div>
                                                  
                                            <div class="col-md-12">
                                                  <label for="exampleInputEmail1">MD Review</label>
                                                  <textarea  class="form-control"  id="md_review" required  autocomplete="off"><?php if(isset($res2[0]['md_review']))echo $res2[0]['md_review'];?></textarea>
                                            </div>                       
                                          
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="mom_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   


<?php $this->load->view('js/meeting_js');?>


