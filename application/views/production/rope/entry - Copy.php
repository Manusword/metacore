<?php 
  if(isset($res2[0]['mc_id'])){$dept_id = $this->Machinemodel->fun_get_dept_id_from_mc_id($res2[0]['mc_id']);}else{$dept_id='';}
  if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
  if(isset($res2[0]['in_product_id'])){
    $out = $this->Productmodel->get_product_data_with_id($res2[0]['in_product_id']); 
    if(!empty($out))
    {
      $in_product_name = $out[0]['name'];
    }
    else
    {
      $in_product_name='';
    }
  }else{$in_product_name='';}

  if(isset($res2[0]['out_product_id'])){
    $out = $this->Productmodel->get_product_data_with_id($res2[0]['out_product_id']); 
    if(!empty($out))
    {
      $out_product_name = $out[0]['name'];
    }
    else
    {
      $out_product_name='';
    }
  }else{$out_product_name='';}
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
                                                                             
                                            <div class="col-md-3">
                                                  <label >Department </label>
                                                    <select class="form-control" id="dept" onChange="fun_get_machine_form_dept_id(this.value,'mc_no','diff_id')">
                                                        <option value="">Select</option>
                                                            <?php 
                                                            foreach($dept as $d)
                                                            {
                                                            ?>
                                                              <option  <?php if(isset($dept_id)){if($dept_id==$d['department_id']){echo 'selected';}}?> value="<?php echo $d['department_id'];?>"  ><?php echo $d['name'];?></option>
                                                            <?php 
                                                            }
                                                            ?>
                                                    </select>
                                            </div>


                                            <div class="col-md-3">
                                                  <label >Date</label>
                                                  <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                            </div>


                                            <div class="col-md-3">
                                                <label  >M/C</label>
                                                <select class="form-control" id="mc_no"  onChange="fun_get_last_machine_details(this.value)" >
                                                  <option value="">Select</option>
                                                    <?php 
                                                      if(!empty($dept_id) and !empty($res2[0]['mc_id']))
                                                      {
                                                          $machine = $this->Machinemodel->fun_get_machine_form_dept_id($dept_id);
                                                          foreach($machine as $m)
                                                          {
                                                            ?><option <?php if($m['mc_id'] == $res2[0]['mc_id']){ echo "selected";}?> value="<?php echo $m['mc_id'];?>"><?php echo $m['name'];?></option><?php 
                                                          }
                                                      }
                                                    ?>
                                                  </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label  >M/C Speed (RPM)</label>
                                                <input type="number" class="form-control" id="mc_speed" value="<?php if(isset($res2[0]['mc_speed']))echo $res2[0]['mc_speed'];?>"  >
                                            </div>

                                           
                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label>Finish Size</label>
                                                <input type="text"    class="form-control"   id="goods31_" onKeyUp="fun_get_product(this.id,'goods31_','goods32_','diff_id_one_search2')" value="<?php if(isset($out_product_name))echo $out_product_name;?>"  />
                                                <input type="hidden"  class="goods"   id="goods32_" value="<?php if(isset($res2[0]['out_product_id']))echo $res2[0]['out_product_id'];?>"  />
                                            </div>


                                            <div class="col-md-2" style="margin-top:10px;">
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

                                            <div class="col-md-2" style="margin-top:10px;">
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

                                            <!------------New field start----------->
                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Operation</label>
                                                <input type="text" class="form-control" id="operation" value="<?php if(isset($res2[0]['operation']))echo $res2[0]['operation'];?>" >
                                            </div>

                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Construction</label>
                                                <input type="text" class="form-control" id="construction" value="<?php if(isset($res2[0]['construction']))echo $res2[0]['construction'];?>" >
                                            </div>

                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >WT/Mtr</label>
                                                <input type="text" class="form-control" id="wt_mt" value="<?php if(isset($res2[0]['wt_mt']))echo $res2[0]['wt_mt'];?>" >
                                            </div>

                                         

                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Pitch</label>
                                                <input type="text" class="form-control" id="pitch" value="<?php if(isset($res2[0]['pitch']))echo $res2[0]['pitch'];?>" >
                                            </div>

                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Line Speed</label>
                                                <input type="text" class="form-control" id="line_speed" value="<?php if(isset($res2[0]['line_speed']))echo $res2[0]['line_speed'];?>" >
                                            </div>

                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Machine Capacity</label>
                                                <input type="text" class="form-control" id="mc_capacity" value="<?php if(isset($res2[0]['mc_capacity']))echo $res2[0]['mc_capacity'];?>" >
                                            </div>


                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Target</label>
                                                <input type="text" class="form-control" id="target" value="<?php if(isset($res2[0]['target']))echo $res2[0]['target'];?>" >
                                            </div>


                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Qty in Meter</label>
                                                <input type="text" class="form-control" id="qty_in_meter" value="<?php if(isset($res2[0]['qty_in_meter']))echo $res2[0]['qty_in_meter'];?>" >
                                            </div>


                                            <!------------New field end----------->


                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Unit</label>
                                                <select class="form-control" id="unit1">
                                                  <option value="">Select</option>
                                                  <?php 
                                                    foreach($unit as $u)
                                                    {
                                                      ?>
                                                        <option 
                                                          <?php 
                                                              if(isset($res2[0]['unit_id'])){
                                                                if($u['unit_id']==$res2[0]['unit_id']){ echo "selected";}
                                                              }
                                                              else{
                                                                if($u['unit_id']==1){ echo "selected";}
                                                              }
                                                          ?> 
                                                        value="<?php echo $u['unit_id'];?>" ><?php echo $u['name'];?></option>
                                                      <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            
                                            
                                            <div class="col-md-2" style="margin-top:10px;">
                                                <label  >Remarks</label>
                                                <input type="text" class="form-control" id="remarks" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>" >
                                            </div>


                                            <div  class="col-md-12"><hr></div>

                                            <div  class="col-md-1">
                                                <label  >Shift</label>
                                                <select class="form-control" id="shift1">
                                                  <option value="A">A</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-1">
                                                <label  >Shift Hours</label>
                                                <input type="text" class="form-control" id="shift_hours1" onKeyUp="fun_get_running_hours1()" value="<?php if(isset($res2[0]['shift_hours1'])){echo $res2[0]['shift_hours1'];}else{echo "11.5";}?>" >
                                            </div>

                                            <div class="col-md-1">
                                                <label  >No of Coil</label>
                                                <input type="number" class="form-control" id="no_of_spool1"  value="<?php if(isset($res2[0]['no_of_spool1']))echo $res2[0]['no_of_spool1'];?>">
                                            </div>
                                            
                                            <div class="col-md-1">
                                                <label  >Qty</label>
                                                <input type="number" class="form-control" id="qty1"  value="<?php if(isset($res2[0]['qty1']))echo $res2[0]['qty1'];?>" >
                                            </div>

                                            <div  class="col-md-1">
                                                <label>Stage</label>
                                                <select class="form-control" id="stage1">
                                                  <option value="">Select</option>
                                                  <option <?php if(isset($res2[0]['stage1'])){if($res2[0]['stage1']=='A'){echo 'selected';}}?>>A</option>
                                                  <option <?php if(isset($res2[0]['stage1'])){if($res2[0]['stage1']=='B'){echo 'selected';}}?>>B</option>
                                                  <option <?php if(isset($res2[0]['stage1'])){if($res2[0]['stage1']=='C'){echo 'selected';}}?>>C</option>
                                                  <option <?php if(isset($res2[0]['stage1'])){if($res2[0]['stage1']=='P'){echo 'selected';}}?>>P</option>
                                                </select>
                                            </div>


                                            <div class="col-md-2">
                                                <label  >Operator Name</label>
                                                <input type="text" class="form-control" id="operator1"   onKeyUp="op_search(this.id)" value="<?php if(isset($res2[0]['operator_id_1']))echo $res2[0]['operator_id_1'];?>" >
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
                                                  <option <?php if(isset($res2[0]['down_type1'])){if($res2[0]['down_type1']=='Other'){echo 'selected';}}?>>Other</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-2" style="margin-top:10px">
                                                <label  >Down Reason</label>
                                                <input type="text" class="form-control" id="down_reason1"  value="<?php if(isset($res2[0]['down_reason1']))echo $res2[0]['down_reason1'];?>">
                                            </div>
                                            
                                            <div class="col-md-2" style="margin-top:10px">
                                                <label  >Total Down (Hours) </label>
                                                <input type="number" class="form-control" id="down_total_time1" onKeyUp="fun_get_running_hours1()" placeholder="Eg: 0.5, 2, 4.5"  value="<?php if(isset($res2[0]['down_total_time1']))echo $res2[0]['down_total_time1'];?>">
                                            </div>

                                            <div class="col-md-2" style="margin-top:10px">
                                                <label  >Total Running (Hours) </label>
                                                <input type="number" class="form-control" id="running_hours_1" placeholder="Eg: 0.5, 2, 4.5"  value="<?php if(isset($res2[0]['running_hours_1'])){echo $res2[0]['running_hours_1'];}else{echo "11.5";}?>">
                                            </div>

                                          


                                            <div  class="col-md-12"><hr></div>
                                        
                                            <div  class="col-md-1">
                                                <label  >Shift</label>
                                                <select class="form-control" id="shift2">
                                                  <option value="B">B</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-1">
                                                <label  >Shift Hours</label>
                                                <input type="text" class="form-control" id="shift_hours2" onKeyUp="fun_get_running_hours2()" value="<?php if(isset($res2[0]['shift_hours2'])){echo $res2[0]['shift_hours2'];}else{echo "12";}?>" >
                                            </div>

                                            <div class="col-md-1">
                                                <label  >No of Coil</label>
                                                <input type="number" class="form-control" id="no_of_spool2"  value="<?php if(isset($res2[0]['no_of_spool2']))echo $res2[0]['no_of_spool2'];?>" >
                                            </div>
                                            
                                            <div class="col-md-1">
                                                <label  >Qty</label>
                                                <input type="number" class="form-control" id="qty2"   value="<?php if(isset($res2[0]['qty2']))echo $res2[0]['qty2'];?>" >
                                            </div>

                                            <div  class="col-md-1">
                                                <label>Stage</label>
                                                <select class="form-control" id="stage2">
                                                  <option value="">Select</option>
                                                  <option <?php if(isset($res2[0]['stage2'])){if($res2[0]['stage2']=='A'){echo 'selected';}}?>>A</option>
                                                  <option <?php if(isset($res2[0]['stage2'])){if($res2[0]['stage2']=='B'){echo 'selected';}}?>>B</option>
                                                  <option <?php if(isset($res2[0]['stage2'])){if($res2[0]['stage2']=='C'){echo 'selected';}}?>>C</option>
                                                  <option <?php if(isset($res2[0]['stage2'])){if($res2[0]['stage2']=='P'){echo 'selected';}}?>>P</option>
                                                </select>
                                            </div>


                                            <div class="col-md-2">
                                                <label  >Operator Name</label>
                                                <input type="text" class="form-control" id="operator2" onKeyUp="op_search(this.id)"  value="<?php if(isset($res2[0]['operator_id_2']))echo $res2[0]['operator_id_2'];?>" >
                                            </div>

                                            <div class="col-md-2">
                                                <label  >Helper Name</label>
                                                <input type="text" class="form-control" id="helper2" onKeyUp="op_search(this.id)"  value="<?php if(isset($res2[0]['helper2']))echo $res2[0]['helper2'];?>" >
                                            </div>
                                            
                                            <div  class="col-md-2">
                                                <label  >Down Type</label>
                                                <select class="form-control" id="down_type2">
                                                  <option value="">Select</option>
                                                  <option <?php if(isset($res2[0]['down_type2'])){if($res2[0]['down_type2']=='MBD'){echo 'selected';}}?>>MBD</option>
                                                  <option <?php if(isset($res2[0]['down_type2'])){if($res2[0]['down_type2']=='EBD'){echo 'selected';}}?>>EBD</option>
                                                  <option <?php if(isset($res2[0]['down_type2'])){if($res2[0]['down_type2']=='Die'){echo 'selected';}}?>>Die</option>
                                                  <option <?php if(isset($res2[0]['down_type2'])){if($res2[0]['down_type2']=='MBD, EBD, Die'){echo 'selected';}}?>>MBD, EBD, Die</option>
                                                  <option <?php if(isset($res2[0]['down_type2'])){if($res2[0]['down_type2']=='Operator'){echo 'selected';}}?>>Operator</option>
                                                  <option <?php if(isset($res2[0]['down_type2'])){if($res2[0]['down_type2']=='No Materil'){echo 'selected';}}?>>No Materil</option>
                                                  <option <?php if(isset($res2[0]['down_type2'])){if($res2[0]['down_type2']=='Program Change'){echo 'selected';}}?>>Program Change</option>
                                                  <option <?php if(isset($res2[0]['down_type2'])){if($res2[0]['down_type2']=='Bobbin Short'){echo 'selected';}}?>>Bobbin Short</option>
                                                  <option <?php if(isset($res2[0]['down_type2'])){if($res2[0]['down_type2']=='Other'){echo 'selected';}}?>>Other</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-2" style="margin-top:10px">
                                                <label  >Down Reason</label>
                                                <input type="text" class="form-control" id="down_reason2"  value="<?php if(isset($res2[0]['down_reason2']))echo $res2[0]['down_reason2'];?>">
                                            </div>
                                            
                                            <div class="col-md-2" style="margin-top:10px">
                                                <label  >Total Down Time (Hours) </label>
                                                <input type="number" class="form-control" id="down_total_time2" onKeyUp="fun_get_running_hours2()" placeholder="Eg: 0.5, 2, 4.5"  value="<?php if(isset($res2[0]['down_total_time2']))echo $res2[0]['down_total_time2'];?>">
                                            </div>

                                            <div class="col-md-2" style="margin-top:10px">
                                                <label  >Total Running (Hours) </label>
                                                <input type="number" class="form-control" id="running_hours_2" placeholder="Eg: 0.5, 2, 4.5"  value="<?php if(isset($res2[0]['running_hours_2'])){echo $res2[0]['running_hours_2'];}else{echo "12";}?>">
                                            </div>

                                           


                                            
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="production_save" >Save</button>
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
  }

  function fun_get_running_hours2()
  {
      var shift_hours2=$('#shift_hours2').val();
      var down_total_time2=$('#down_total_time2').val();
      var run_hours = (+shift_hours2)-(+down_total_time2);
      $('#running_hours_2').val(run_hours);
  }
</script>