<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
   if(isset($res2[0]['break_down_date'])){$break_down_date=$this->Base->change_date_dmy($res2[0]['break_down_date']);}else{$break_down_date='';}
   if(isset($res2[0]['comp_date']) and $res2[0]['comp_date']!='0000-00-00'){$comp_date=$this->Base->change_date_dmy($res2[0]['comp_date']);}else{$comp_date='';}
   if(isset($res2[0]['break_down_time'])){echo $break_down_time=$this->Base->change_time_hisa($res2[0]['break_down_time']);}else{$break_down_time='';}
   if(!empty($res2[0]['comp_time']) and $res2[0]['comp_time']!='00:00:00'){$comp_time=$this->Base->change_time_hisa($res2[0]['comp_time']);}else{$comp_time='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Maintenance Breakdown</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Breakdown</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['maint_problem_id']))echo $res2[0]['maint_problem_id'];?>">
                                                                                  
                                            <div class="col-md-3">
                                                  <label >Date<span style="color:red;" id="product_dis_id"></span></label>
                                                  <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" onchange="setDate(this.value)" >
                                            </div>
                                            
                                            <div class="col-md-3">
                                                  <label >Shift</label>
                                                    <select class="form-control" id="shift">
                                                        <option value="">Select</option>
                                                        <option <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='A'){echo 'selected';}}?>>A</option>
                                                        <option <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='B'){echo 'selected';}}?>>B</option>
                                                    </select>
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

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label >Type of Work</label>
                                                    <select class="form-control" id="type_of_work">
                                                      <option value="">Select</option>
                                                      <option <?php if(isset($res2[0]['type_of_work'])){if($res2[0]['type_of_work']=='Breakdown'){echo 'selected';}}?>>Breakdown</option>
                                                      <option <?php if(isset($res2[0]['type_of_work'])){if($res2[0]['type_of_work']=='Preventive'){echo 'selected';}}?>>Preventive</option>
                                                      <option <?php if(isset($res2[0]['type_of_work'])){if($res2[0]['type_of_work']=='Installation'){echo 'selected';}}?>>Installation</option>
                                                      <option <?php if(isset($res2[0]['type_of_work'])){if($res2[0]['type_of_work']=='Improvement'){echo 'selected';}}?>>Improvement</option>
                                                      <option <?php if(isset($res2[0]['type_of_work'])){if($res2[0]['type_of_work']=='Other Work'){echo 'selected';}}?>>Other Work</option>
                                                    </select>
                                            </div>

                                            
                                            
                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label >MBD / EBD / Both / Other</label>
                                                    <select class="form-control" id="type2">
                                                        <option value="">Select</option>
                                                        <option <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='MBD'){echo 'selected';}}?>>MBD</option>
                                                        <option <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='EBD'){echo 'selected';}}?>>EBD</option>
                                                        <option <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='Both'){echo 'selected';}}?>>Both</option>
                                                        <option <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='Utility'){echo 'selected';}}?>>Utility</option>
                                                        <option <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='Instrumentation'){echo 'selected';}}?>>Instrumentation</option>
                                                        <option <?php if(isset($res2[0]['type2'])){if($res2[0]['type2']=='Other'){echo 'selected';}}?>>Other</option>
                                                    </select>
                                            </div>
                                            

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label >CRITICAL / NON-CRITICAL</label>
                                                    <select class="form-control" id="type">
                                                        <option value="">Select</option>
                                                        <option <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='CRITICAL'){echo 'selected';}}?>>CRITICAL</option>
                                                        <option <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='NON CRITICAL'){echo 'selected';}}?>>NON CRITICAL</option>
                                                    </select>
                                            </div>
                                            

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label>Type of Problem</label>
                                                    <select class="form-control" id="type_of_problem" onchange="myFunction(this.value)">
                                                        <option value="">Select</option>
                                                        <?php 
                                                          
                                                              foreach($pl as $p)
                                                              {
                                                                ?><option <?php if(!empty($res2[0]['problem_type_id'])){  if($p['id'] == $res2[0]['problem_type_id']){ echo "selected";} } ?> value="<?php echo $p['id'];?>"><?php echo $p['name'];?></option><?php 
                                                              }
                                                          
                                                        ?>
                                                        <option value="Other">Other</option>
                                                    </select>
                                            </div>
                                            <div class="col-md-3" style="margin-top:10px; display:none" id='other_problem_box'>
                                                  <label  style="color:blue">Enter Other Problem</label>
                                                  <input type="text" class="form-control"  id="other_problem_type" required  autocomplete="off" value="<?php if(isset($res2[0]['problem']))echo $res2[0]['problem'];?>">
                                            </div>
                                            
                                          
                                            
                                            <div class="col-md-12" style="margin-top:10px">
                                                  <label  style="color:orange">Problem details</label>
                                                  <input type="text" class="form-control"  id="problem" required  autocomplete="off" value="<?php if(isset($res2[0]['problem']))echo $res2[0]['problem'];?>">
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label >Reported By</label>
                                                    <input type="text" class="form-control"  id="person" onKeyUp="op_search(this.id)" required  autocomplete="off"  value="<?php if(isset($res2[0]['person']))echo $res2[0]['person'];?>">
                                            </div>
                                            
                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label >Shift Incharge Name</label>
                                                    <input type="text" class="form-control"  id="shift_incharge1" onKeyUp="op_search(this.id)" required  autocomplete="off"  value="<?php if(isset($res2[0]['shift_incharge1']))echo $res2[0]['shift_incharge1'];?>">
                                            </div>

                                           
                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label >Break Down Date</label>
                                                  <input type="text" class="form-control"  id="break_down_date" required  autocomplete="off" value="<?php if(isset($break_down_date))echo $break_down_date;?>">
                                            </div>


                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label >Break Down Time (eg: 5:40 AM)</label>
                                                    <input type="time" class="form-control"  id="break_down_time" required  autocomplete="off"  value="<?php if(!empty($break_down_time))echo date("H:i:s", strtotime($break_down_time));?>">
                                            </div>
                                            
                                           
                                            
                                            <div class="col-md-12" style="margin-top:10px">
                                                    <label >Observation & Action Taken By Maint. </label>
                                                      <textarea  class="form-control"  id="action_taken" required  autocomplete="off"><?php if(isset($res2[0]['action_taken']))echo $res2[0]['action_taken'];?></textarea>
                                            </div>

                                             <div class="col-md-12" style="margin-top:10px">
                                                  <label >Root Cause (if breakdown)</label>
                                                    <input type="text" class="form-control"  id="root_cause" required  autocomplete="off" value="<?php if(isset($res2[0]['root_cause']))echo $res2[0]['root_cause'];?>" >
                                            </div>

                                            
                                            
                                            <div class="col-md-12" style="margin-top:10px">
                                                  <label >Any Part Change </label>
                                                    <textarea  class="form-control"  id="part_change" required  autocomplete="off"><?php if(isset($res2[0]['part_change']))echo $res2[0]['part_change'];?></textarea>
                                            </div>
                                        
                                            <div class="col-md-2" style="margin-top:10px">
                                                    <label >Attend By</label>
                                                    <input type="text" class="form-control"  id="attend_by" required  onKeyUp="op_search(this.id)" autocomplete="off" value="<?php if(isset($res2[0]['attend_by']))echo $res2[0]['attend_by'];?>" >
                                            </div>
                                          
                                           
                                    
                                            <div class="col-md-2" style="margin-top:10px">
                                                  <label >Status</label>
                                                  <select class="form-control"  name="active" id="active">
                                                      <option  <?php if(isset($res2[0]['active'])){if($res2[0]['active']=='Pending'){echo "selected";}}?>>Pending</option>
                                                      <option  <?php if(isset($res2[0]['active'])){if($res2[0]['active']=='Under Process'){echo "selected";}}?>>Under Process</option>
                                                      <option  <?php if(isset($res2[0]['active'])){if($res2[0]['active']=='Completed'){echo "selected";}}?>>Completed</option>
                                                      <option  <?php if(isset($res2[0]['active'])){if($res2[0]['active']=='Canceled'){echo "selected";}}?>>Canceled</option>
                                                  </select>
                                            </div>
                                            
                                             <div class="col-md-2" style="margin-top:10px">
                                                  <label >Completed Date</label>
                                                  <input type="text" class="form-control"  id="comp_date" required  autocomplete="off" value="<?php if(isset($comp_date))echo $comp_date;?>" >
                                            </div>
                                          
                                            <div class="col-md-2" style="margin-top:10px">
                                                  <label >Completed Time </label>
                                                    <input type="time" class="form-control"  id="comp_time" required  autocomplete="off" value="<?php if(isset($comp_time) and $comp_time !='')echo date("H:i:s", strtotime($comp_time));?>" placeholder="5:40 AM" >
                                            </div>


                                            <div class="col-md-2" style="margin-top:10px">
                                                  <label >Assigned Task Priority</label>
                                                    <select class="form-control" id="priority">
                                                        <option value="">Select</option>
                                                        <option <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='Low'){echo 'selected';}}?>>Low</option>
                                                        <option <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='Medium'){echo 'selected';}}?>>Medium</option>
                                                        <option <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='High'){echo 'selected';}}?>>High</option>
                                                        <option <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='Urgent'){echo 'selected';}}?>>Urgent</option>
                                                    </select>
                                            </div>

                                             <div class="col-md-2" style="margin-top:10px">
                                                  <label >Efficiency Rating</label>
                                                    <select class="form-control" id="rating">
                                                        <option value="">Select</option>
                                                        <option <?php if(isset($res2[0]['rating'])){if($res2[0]['rating']=='1'){echo 'selected';}}?>>1</option>
                                                        <option <?php if(isset($res2[0]['rating'])){if($res2[0]['rating']=='2'){echo 'selected';}}?>>2</option>
                                                        <option <?php if(isset($res2[0]['rating'])){if($res2[0]['rating']=='3'){echo 'selected';}}?>>3</option>
                                                        <option <?php if(isset($res2[0]['rating'])){if($res2[0]['rating']=='4'){echo 'selected';}}?>>4</option>
                                                        <option <?php if(isset($res2[0]['rating'])){if($res2[0]['rating']=='5'){echo 'selected';}}?>>5</option>
                                                    </select>
                                            </div>
                                            
                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label >Checked By</label>
                                                    <input type="text" class="form-control"  id="checked_by" onKeyUp="op_search(this.id)" required  autocomplete="off" value="<?php if(isset($res2[0]['checked_by']))echo $res2[0]['checked_by'];?>" >
                                            </div>
                                            
                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label >Shift Incharge</label>
                                                    <input type="text" class="form-control"  id="shift_incharge2"  onKeyUp="op_search(this.id)" required  autocomplete="off" value="<?php if(isset($res2[0]['shift_incharge2']))echo $res2[0]['shift_incharge2'];?>" >
                                            </div>
                                           
                                            
                                            <div class="col-md-12" style="margin-top:10px">
                                                
                                                  <label >Section Head / MD Review</label>
                                                <textarea  class="form-control"  id="md_review" required  autocomplete="off"><?php if(isset($res2[0]['md_review']))echo $res2[0]['md_review'];?></textarea>
                                                
                                            </div>                         
                                                                        
                                          
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="breaksown_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   




        
   

    

<?php $this->load->view('js/maintenance_js');?>


<script>
/*
  $(goods2_id).autocomplete({
		source: '<?php echo base_url().'index.php';?>/Ajex/maint_breakdown_autocomplate/',
		autoFocus:true,
		select: function(event, ui) {
				event.preventDefault();
				$(goods2_id).val(ui.item.label);
				$(goods_id).val(ui.item.value);
				
				fun_get_rate_from_cust3(goods_id);
				
				
			},
    });
    */
</script>

<script>
  function myFunction(val) {
    if(val == 'Other')
    {
      //show
      document.getElementById("other_problem_type").value='';
      document.getElementById("other_problem_box").style.display = "block";
    }
    else
    {
      //hide
      document.getElementById("other_problem_type").value='';
      document.getElementById("other_problem_box").style.display = "none";
    }//val
  }

  function setDate(val){
    document.getElementById("break_down_date").value=val;
    document.getElementById("comp_date").value=val;
    
  }
</script>


