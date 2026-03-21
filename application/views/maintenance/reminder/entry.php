<?php 
   if(isset($res2[0]['event_date'])){$event_date=$this->Base->change_date_dmy($res2[0]['event_date']);}else{$event_date='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Reminder</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Reminder</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden"  id="reminder_id"  value="<?php if(isset($res2[0]['reminder_id']))echo $res2[0]['reminder_id'];?>">
                                            <input type="hidden"  id="customer_id"  value="<?php if(isset($res2[0]['customer_id']))echo $res2[0]['customer_id'];?>">
                                               
                                            
                                            <div class="col-md-12" >
                                                  <label>Type</label>
                                                    <select class="form-control" id="location">
                                                        <option <?php if(isset($res2[0]['location'])){if($res2[0]['location']=='Reminder'){echo 'selected';}}?>>Reminder</option>
                                                        <option <?php if(isset($res2[0]['location'])){if($res2[0]['location']=='Customer'){echo 'selected';}}?>>Customer</option>
                                                        <option <?php if(isset($res2[0]['location'])){if($res2[0]['location']=='Training'){echo 'selected';}}?>>Training </option>
                                                        <option <?php if(isset($res2[0]['location'])){if($res2[0]['location']=='Tool'){echo 'selected';}}?>>Tool</option>
                                                        <option <?php if(isset($res2[0]['location'])){if($res2[0]['location']=='Machine'){echo 'selected';}}?>>Machine</option>
                                                        <option <?php if(isset($res2[0]['location'])){if($res2[0]['location']=='Canteen'){echo 'selected';}}?>>Canteen</option>
                                                        <option <?php if(isset($res2[0]['location'])){if($res2[0]['location']=='Company'){echo 'selected';}}?>>Company</option>
                                                        <option <?php if(isset($res2[0]['location'])){if($res2[0]['location']=='Personal'){echo 'selected';}}?>>Personal</option>
                                                        <option <?php if(isset($res2[0]['location'])){if($res2[0]['location']=='Other'){echo 'selected';}}?>>Other</option>
                                                    </select>
                                            </div>
                                         

                                            <div class="col-md-12" style="margin-top:10px">
                                                  <label >Task</label>
                                                    <textarea  class="form-control"  id="task" required  autocomplete="off"><?php if(isset($res2[0]['task']))echo $res2[0]['task'];?></textarea>
                                            </div>



                                            <div class="col-md-6" style="margin-top:20px">
                                                  <label>1st Event Date<span style="color:red;" id="product_dis_id"></span></label>
                                                  <input type="text" class="form-control"  id="event_date" required  autocomplete="off" value="<?php if(isset($event_date))echo $event_date;?>" >
                                            </div>


                                             <div class="col-md-6" style="margin-top:20px">
                                                  <label >Task Priority</label>
                                                    <select class="form-control" id="priority">
                                                        <option <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='Low'){echo 'selected';}}?>>Low</option>
                                                        <option <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='Medium'){echo 'selected';}}?>>Medium</option>
                                                        <option <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='High'){echo 'selected';}}?>>High</option>
                                                        <option <?php if(isset($res2[0]['priority'])){if($res2[0]['priority']=='Urgent'){echo 'selected';}}?>>Urgent</option>
                                                    </select>
                                            </div>



                                           
                                            
                                       


                                            <div class="col-md-6" style="margin-top:20px">
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

                                            <div class="col-md-6" style="margin-top:20px">
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

                                           
                                          
                                           
                                    
                                            <div class="col-md-6" style="margin-top:20px">
                                                  <label >Status</label>
                                                  <select class="form-control"   id="status">
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Pending'){echo "selected";}}?>>Pending</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Under Process'){echo "selected";}}?>>Under Process</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Completed'){echo "selected";}}?>>Completed</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Canceled'){echo "selected";}}?>>Canceled</option>
                                                  </select>
                                            </div>
                                            
                                          <div class="col-md-6" style="margin-top:20px">
                                                  <label >Repeat </label>
                                                    <select class="form-control" id="repeat_status">
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='none'){echo "selected";}}?> value="none">No Repeat</option>
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='Daily'){echo "selected";}}?> value="Daily">Daily</option>
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='Weekly'){echo "selected";}}?> value="Weekly">Weekly</option>
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='Monthly'){echo "selected";}}?> value="Monthly">Monthly</option>
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='2 Month'){echo "selected";}}?> value="2 Month">2 Month</option>
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='3 Month'){echo "selected";}}?>  value="3 Month">3 Month</option>
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='4 Month'){echo "selected";}}?> value="4 Month">4 Month</option>
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='6 Month'){echo "selected";}}?> value="6 Month">6 Month</option>
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='8 Month'){echo "selected";}}?> value="8 Month">8 Month</option>
                              <option <?php if(isset($res2[0]['repeat_status'])){if($res2[0]['repeat_status']=='Yearly'){echo "selected";}}?> value="Yearly">Yearly</option>
                                                    </select>
                                            </div>

                                           


                                            <div class="col-md-12" style="margin-top:20px">
                                                  <label >Visible To</label>
                                                    <select class="form-control" id="show_to">
                                                        <option <?php if(isset($res2[0]['show_to'])){if($res2[0]['show_to']=='My Id'){echo 'selected';}}?>>My Id</option>
                                                        <option <?php if(isset($res2[0]['show_to'])){if($res2[0]['show_to']=='Everyone'){echo 'selected';}}?>>Everyone</option>
                                                    </select>
                                            </div>

                                             <div class="col-md-12" style="margin-top:10px">
                                                  <label >Remarks</label>
                                                    <textarea  class="form-control"  id="remarks" required  autocomplete="off"><?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?></textarea>
                                            </div>
                                                            
                                          
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="reminder_save" >Save</button>
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
</script>


