<?php 
  if(isset($res2[0]['mc_id'])){$dept_id = $this->Machinemodel->fun_get_dept_id_from_mc_id($res2[0]['mc_id']);}else{$dept_id='';}
  if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
 
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Rope Production Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Basic Details</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['production_id']))echo $res2[0]['production_id'];?>">
                                                                             
                                            <div class="col-md-1">
                                                  <label >Date</label>
                                                  <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                            </div>

                                            <div  class="col-md-1">
                                                <label  >Shift</label>
                                                <select class="form-control" id="shift1">
                                                    <option value="">Select</option>
                                                    <option <?php if(isset($res2[0]['shift1'])){if($res2[0]['shift1'] == "A"){ echo "selected";}}?> value="A">A</option>
                                                    <option <?php if(isset($res2[0]['shift1'])){if($res2[0]['shift1'] == "B"){ echo "selected";}}?> value="B">B</option>
                                                </select>
                                            </div>



                                            <div class="col-md-1">
                                                <label  >M/C</label>
                                                <select class="form-control" id="mc_no"   >
                                                  <option value="">Select</option>
                                                    <?php 
                                                          foreach($machine as $m)
                                                          {
                                                            ?>
                                                                <option 
                                                                    <?php if(!empty($res2[0]['mc_id'])){if($m['mc_id'] == $res2[0]['mc_id']){ echo "selected";}}?> 
                                                                        value="<?php echo $m['mc_id'];?>">
                                                                    <?php echo $m['name'];?>
                                                                </option>
                                                                <?php 
                                                          }
                                                    ?>
                                                  </select>
                                            </div>
                                            
                                            
                                           

                                            <div class="col-md-1" >
                                                <label>Size</label>
                                                <input type="number" class="form-control" id="size" value="<?php if(isset($res2[0]['size']))echo $res2[0]['size'];?>" onChange="fun_get_last_machine_details_rope()">
                                            </div>

                                            <div  class="col-md-1">
                                                <label  >Operation</label>
                                                <select class="form-control" id="operation">
                                                    <option value="">Select</option>
                                                    <option <?php if(isset($res2[0]['operation'])){if($res2[0]['operation'] == "Finish"){ echo "selected";}}?> value="Finish" >Finish</option>
                                                    <option <?php if(isset($res2[0]['operation'])){if($res2[0]['operation'] == "Outer Core"){ echo "selected";}}?> value="Outer Core">Outer Core</option>
                                                    <option <?php if(isset($res2[0]['operation'])){if($res2[0]['operation'] == "Center Core"){ echo "selected";}}?> value="Center Core">Center Core</option>
                                                    <option <?php if(isset($res2[0]['operation'])){if($res2[0]['operation'] == "Rewinding"){ echo "selected";}}?> value="Rewinding">Rewinding</option>
                                                </select>
                                            </div>

                                            <div  class="col-md-1">
                                                <label  >Type</label>
                                                <select class="form-control" id="type">
                                                    <option value="">None</option>
                                                    <option <?php if(isset($res2[0]['type'])){if($res2[0]['type'] == "Old"){ echo "selected";}}?> value="Old" >Old</option>
                                                    <option <?php if(isset($res2[0]['type'])){if($res2[0]['type'] == "New"){ echo "selected";}}?> value="New" >New</option>
                                                </select>
                                            </div>



                                            <div  class="col-md-1">
                                                <label  >Construction</label>
                                                <select class="form-control" id="construction">
                                                    <option value="">Select</option>
                                                    <option <?php if(isset($res2[0]['construction'])){if($res2[0]['construction'] == "1 + 6"){ echo "selected";}}?> value="1 + 6">1 + 6</option>
                                                    <option <?php if(isset($res2[0]['construction'])){if($res2[0]['construction'] == "1 x 19"){ echo "selected";}}?> value="1 x 19">1 x 19</option>
                                                    <option <?php if(isset($res2[0]['construction'])){if($res2[0]['construction'] == "7 x 7"){ echo "selected";}}?> value="7 x 7">7 x 7</option>
                                                    <option <?php if(isset($res2[0]['construction'])){if($res2[0]['construction'] == "7 x 19"){ echo "selected";}}?> value="7 x 19">7 x 19</option>
                                                </select>
                                            </div>


                                            
                                            <div class="col-md-1">
                                                <label  >Grade</label>
                                                <select class="form-control" id="grade">
                                                  <option value="">Select</option>
                                                  <?php 
                                                    foreach($grade as $u)
                                                    {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['grade'])){if($u['id']==$res2[0]['grade']){ echo "selected";}}?> value="<?php echo $u['id'];?>" ><?php echo $u['name'];?></option>
                                                      <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>



                                            <div class="col-md-1" >
                                                <label  >WT/Mtr</label>
                                                <input type="number" class="form-control" id="wt_mt" value="<?php if(isset($res2[0]['wt_mt']))echo $res2[0]['wt_mt'];?>" onChange="fun_update_formula()">
                                            </div>

                                         
                                            

                                            <div class="col-md-1" >
                                                <label  >M/C Speed (RPM)</label>
                                                <input type="number" class="form-control" id="mc_speed" value="<?php if(isset($res2[0]['mc_speed']))echo $res2[0]['mc_speed'];?>" onChange="fun_update_formula()" >
                                            </div>

                                           
                                           


                                            <!------------New field start----------->
                                           

                                            <div class="col-md-1" >
                                                <label  >Pitch</label>
                                                <input type="number" class="form-control" id="pitch" value="<?php if(isset($res2[0]['pitch']))echo $res2[0]['pitch'];?>" onChange="fun_update_formula()" >
                                            </div>

                                            <div class="col-md-2" >
                                                <label  >Line Speed</label>
                                                <input type="number" class="form-control" id="line_speed" value="<?php if(isset($res2[0]['line_speed']))echo $res2[0]['line_speed'];?>"
                                                 >
                                            </div>


                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Machine Capacity</label>
                                                <input type="number" class="form-control" id="mc_capacity" value="<?php if(isset($res2[0]['mc_capacity']))echo $res2[0]['mc_capacity'];?>" >
                                            </div>


                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Target 100%</label>
                                                <input type="number" class="form-control" id="target" value="<?php if(isset($res2[0]['target']))echo $res2[0]['target'];?>" >
                                            </div>


                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Qty in Meter</label>
                                                <input type="number" class="form-control" id="qty_in_meter" value="<?php if(isset($res2[0]['qty_in_meter']))echo $res2[0]['qty_in_meter'];?>" onKeyUp="fun_update_formula()">
                                            </div>

                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Qty in Kgs</label>
                                                <input type="number" class="form-control" id="qty_in_kg"  value="<?php if(isset($res2[0]['qty_in_kg']))echo $res2[0]['qty_in_kg'];?>" >
                                            </div>

                                           


                                            <!------------New field end----------->

                                            <div  class="col-md-12"><hr></div>

                                            
                                            
                                            <div class="col-md-1">
                                                <label  >Shift Hours</label>
                                                <input type="number" class="form-control" id="shift_hours1" onKeyUp="fun_get_running_hours1()" value="<?php if(isset($res2[0]['shift_hours1'])){echo $res2[0]['shift_hours1'];}else{echo "11.5";}?>" >
                                            </div>

                                           

                                            <div class="col-md-2">
                                                <label  >Operator Name</label>
                                                <input type="text" class="form-control" id="operator1"   onKeyUp="op_search(this.id)" value="<?php if(isset($res2[0]['operator1']))echo $res2[0]['operator1'];?>" >
                                            </div>

                                            <div class="col-md-2">
                                                <label  >Helper Name</label>
                                                <input type="text" class="form-control" id="helper1" onKeyUp="op_search(this.id)"  value="<?php if(isset($res2[0]['helper1']))echo $res2[0]['helper1'];?>" >
                                            </div>
                                            
                                            <div  class="col-md-2">
                                                <label  >Down Type</label>
                                                <select class="form-control" id="down_type1">
                                                  <option value="">Select</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='MBD'){echo 'selected';}}?>>MBD</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='EBD'){echo 'selected';}}?>>EBD</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='Die'){echo 'selected';}}?>>Die</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='MBD, EBD, Die'){echo 'selected';}}?>>MBD, EBD, Die</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='Operator'){echo 'selected';}}?>>Operator</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='No Materil'){echo 'selected';}}?>>No Materil</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='Program Change'){echo 'selected';}}?>>Program Change</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='Bobbin Short'){echo 'selected';}}?>>Bobbin Short</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='Size Change Over'){echo 'selected';}}?>>Size Change Over</option>
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='Other'){echo 'selected';}}?>>Other</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-2" >
                                                <label  >Down Reason</label>
                                                <input type="text" class="form-control" id="down_reason1"  value="<?php if(isset($res2[0]['down_reason1']))echo $res2[0]['down_reason1'];?>">
                                            </div>
                                            
                                            <div class="col-md-2" >
                                                <label  >Total Down (Hours) </label>
                                                <input type="number" class="form-control" id="down_total_time1" onKeyUp="fun_get_running_hours1()" placeholder="Eg: 0.5, 2, 4.5"  value="<?php if(isset($res2[0]['down_total_time1']))echo $res2[0]['down_total_time1'];?>">
                                            </div>

                                            <div class="col-md-2" style="margin-top:10px">
                                                <label  >Total Running (Hours) </label>
                                                <input type="number" class="form-control" id="running_hours_1" placeholder="Eg: 0.5, 2, 4.5"  value="<?php if(isset($res2[0]['running_hours_1'])){echo $res2[0]['running_hours_1'];}else{echo "11.5";}?>">
                                            </div>


                                            <?php /*            
                                            <div  class="col-md-2" style="margin-top:10px">
                                                <label  >Eff % On</label>
                                                <select class="form-control" id="eff_on">
                                                  <option value="80">Select</option>
                                                  <option  value='100'>100%</option>
                                                  <option  value='95'>95%</option>
                                                  <option  value='90'>90%</option>
                                                  <option  value='85'>85%</option>

                                                  <option <?php if(empty($res2[0]['production_id'])){echo 'selected';}?> value='80'>80%</option>

                                                  <option  value='75'>75%</option>
                                                  <option  value='70'>70%</option>
                                                </select>
                                            </div>
                                            */?>


                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Eff %</label>
                                                <input type="number" class="form-control" id="eff1" value="<?php if(isset($res2[0]['eff1']))echo $res2[0]['eff1'];?>" >
                                            </div>

                                          


                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Scrap (kg)</label>
                                                <input type="number" class="form-control" id="scrap" value="<?php if(isset($res2[0]['scrap']))echo $res2[0]['scrap'];?>" >
                                            </div>

                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Remarks</label>
                                                <input type="text" class="form-control" id="remarks" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>" >
                                            </div>


                                          
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="production_save2" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   



<?php $this->load->view('js/production_js');?>
<script>
  function fun_get_running_hours1()
  {
      var shift_hours1=$('#shift_hours1').val();
      var down_total_time1=$('#down_total_time1').val();
      var run_hours = (+shift_hours1)-(+down_total_time1);
      $('#running_hours_1').val(run_hours);
      fun_update_formula()
  }
        
  

  function fun_update_formula(){
    let rpm = $('#mc_speed').val();
    let pitch = $('#pitch').val();
    let line_speed = (((+rpm) * (+pitch)) / 1000).toFixed(2);;
    $('#line_speed').val(line_speed);

    
    //machine capacity
    let mc_capacity = ((+line_speed) * 60).toFixed(1);
    $('#mc_capacity').val(mc_capacity);
     
    //target
    let run_hours = $('#running_hours_1').val();
   

    let target = ((+mc_capacity) * run_hours).toFixed(0);
    $('#target').val(target);
    //eff 80%
    let operation = $('#operation').val();
    //let getPerVal = (+$('#eff_on').val());
    let getPerVal = 100;
    //if(operation === "Finish"){ getPerVal = 80;}else{getPerVal=90;}
    //let get80Per = ((getPerVal/100) * target).toFixed(0);
    let qty_in_meter = $('#qty_in_meter').val();
    let eff1 = ((qty_in_meter*100)/target).toFixed(0);
    $('#eff1').val(eff1);
	

    //mtr to kg
    let wt_mt = $('#wt_mt').val();
    let qty_in_kg = (((+wt_mt) * (+qty_in_meter))/1000).toFixed(1);
    $('#qty_in_kg').val(qty_in_kg);

  }
</script>