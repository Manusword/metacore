<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Short Pieces Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Short Pieces Entry</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                                                                  
                                            <div class="col-md-3">
                                                  <label >Date<span style="color:red;" id="product_dis_id"></span></label>
                                                  <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
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

                                            
                                            
                                            <div class="col-md-3">
                                                  <label >Grade</label>
                                                    <select class="form-control" id="grade" >
                                                        <option value="">Select</option>
                                                            <?php 
                                                            foreach($grade as $d)
                                                            {
                                                            ?>
                                                              <option  <?php if(isset($res2[0]['grade'])){if($res2[0]['grade']==$d['id']){echo 'selected';}}?> value="<?php echo $d['id'];?>"  ><?php echo $d['name'];?></option>
                                                            <?php 
                                                            }
                                                            ?>
                                                    </select>
                                            </div>
                                            
                                        





                                            <div class="col-md-12" style="margin-top:10px;">
                                                <hr>
                                            </div>



                                            <div class="col-md-3" style="margin-top:10px;">
                                                  <label>Qty Shift (A)</label>
                                                  <input type="number" class="form-control"  id="qty1" required  autocomplete="off" value="<?php if(isset($res2[0]['qty1']))echo $res2[0]['qty1'];?>">
                                            </div>


                                            <div class="col-md-3" style="margin-top:10px;">
                                                  <label>Person</label>
                                                  <input type="text" class="form-control"  id="person1" onKeyUp="op_search(this.id)" required  autocomplete="off" value="<?php if(isset($res2[0]['person1']))echo $res2[0]['person1'];?>">
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px;">
                                                  <label >Unit</label>
                                                    <select class="form-control" id="unit1" >
                                                        <option value="">Select</option>
                                                            <?php 
                                                            foreach($unit as $d)
                                                            {
                                                            ?>
                                                              <option  <?php if(isset($res2[0]['unit1'])){if($res2[0]['unit1']==$d['unit_id']){echo 'selected';}}elseif($d['unit_id'] == 1){echo 'selected';}?> value="<?php echo $d['unit_id'];?>"  ><?php echo $d['name'];?></option>
                                                            <?php 
                                                            }
                                                            ?>
                                                    </select>
                                            </div>


                                            <div class="col-md-3" style="margin-top:10px;">
                                                  <label>Shift Incharge</label>
                                                  <input type="text" class="form-control"  id="shift_inchage1" onKeyUp="op_search(this.id)" required  autocomplete="off" value="<?php if(isset($res2[0]['shift_inchage1']))echo $res2[0]['shift_inchage1'];?>">
                                            </div>



                                            <div class="col-md-12" style="margin-top:10px;">
                                                <hr>
                                            </div>



                                            <div class="col-md-3" style="margin-top:10px;">
                                                  <label>Qty Shift (B)</label>
                                                  <input type="number" class="form-control"  id="qty2" required  autocomplete="off" value="<?php if(isset($res2[0]['qty2']))echo $res2[0]['qty2'];?>">
                                            </div>


                                            <div class="col-md-3" style="margin-top:10px;">
                                                  <label>Person</label>
                                                  <input type="text" class="form-control"  id="person2" onKeyUp="op_search(this.id)" required   autocomplete="off" value="<?php if(isset($res2[0]['person2']))echo $res2[0]['person2'];?>">
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px;">
                                                  <label >Unit</label>
                                                    <select class="form-control" id="unit2" >
                                                        <option value="">Select</option>
                                                            <?php 
                                                            foreach($unit as $d)
                                                            {
                                                            ?>
                                                              <option  <?php if(isset($res2[0]['unit2'])){if($res2[0]['unit2']==$d['unit_id']){echo 'selected';}}elseif($d['unit_id'] == 1){echo 'selected';}?> value="<?php echo $d['unit_id'];?>"  ><?php echo $d['name'];?></option>
                                                            <?php 
                                                            }
                                                            ?>
                                                    </select>
                                            </div>


                                            <div class="col-md-3" style="margin-top:10px;">
                                                  <label>Shift Incharge</label>
                                                  <input type="text" class="form-control"  id="shift_inchage2" onKeyUp="op_search(this.id)" required  autocomplete="off" value="<?php if(isset($res2[0]['shift_inchage2']))echo $res2[0]['shift_inchage2'];?>">
                                            </div>

                                          
                                            
                                                          
                                          
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="short_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   




        
   

    

<?php $this->load->view('js/production_js');?>

