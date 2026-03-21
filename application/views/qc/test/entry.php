<?php 
      if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
      //getting heat no and base coil no


      if(!empty($res2[0]['base_size']) && !empty($res2[0]['product_grade'])){
            $heatCoilNO = $this->Pomodel->get_all_heatno_colino_from_fsize_grade($res2[0]['base_size'],$res2[0]['product_grade']);
      }else{
            $heatCoilNO = array();
      }

      
      if(!empty($res2[0]['for_patt']) && (int)$res2[0]['for_patt'] == 1 && !empty($res2[0]['base_size']) && !empty($res2[0]['product_grade'])){
            $lotno = $this->Qcmodel->get_all_lotno_with_coil_from_fur($res2[0]['base_size'],$res2[0]['product_grade']);
      }else{
            $lotno = array();
      }
     
?>  
            
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>QC In Process Testing Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                  
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >In Process Testing Register (D.W.D)</div>
                                    <div class="form-row">
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      
                                      <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                          
                                      
                                          <div class="col-md-2" style="margin-top:10px">
                                                <label >Date</label>
                                                <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                          </div>
 
                                          <div class="col-md-2" style="margin-top:10px">
                                                <label>Shift</label>
                                                      <select class="form-control" id="shift">
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='A'){echo "selected";}}?> >A</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='B'){echo "selected";}}?>>B</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='C'){echo "selected";}}?>>C</option>
                                                      </select>
                                          </div> 


                                         
                                        <div class="col-md-2" style="margin-top:10px">
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

                                            <div class="col-md-2" style="margin-top:10px">
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



                                            <div class="col-md-2" style="margin-top:10px">
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

                                        <div class="col-md-2" style="margin-top:10px">
                                              <label>Batch No</label>
                                              <input type="text" class="form-control"  id="batch_no" required  autocomplete="off" value="<?php if(isset($res2[0]['batch_no']))echo $res2[0]['batch_no'];?>" >
                                        </div>


                                        
                                        <div class="col-md-2" style="margin-top:10px">
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

                                           

                                            <div class="col-md-1" style="margin-top:10px">
                                              <label>Base (Size)</label>
                                              <input type="number" class="form-control"  id="base_size" required  autocomplete="off" value="<?php if(isset($res2[0]['base_size']))echo $res2[0]['base_size'];?>" >
                                        </div>


                                          <div class="col-md-1" style="margin-top:10px">
                                                <label>Finish Size</label>
                                                <input type="number" class="form-control"  id="finish_size" required  autocomplete="off" value="<?php if(isset($res2[0]['finish_size']))echo $res2[0]['finish_size'];?>"   >
                                          </div>





                                          <div class="col-md-1" style="margin-top:10px">
                                              <label>Coil dia</label>
                                              <input type="number" class="form-control"  id="coil_dia" required  autocomplete="off" value="<?php if(isset($res2[0]['coil_dia']))echo $res2[0]['coil_dia'];?>"   >
                                          </div>


                                          <div class="col-md-1" style="margin-top:10px">
                                              <label>Coil No From</label>
                                              <input type="number" class="form-control"  id="coil_dia_from" required  autocomplete="off" value="<?php if(isset($res2[0]['coil_dia_from']) and $res2[0]['coil_dia_from']>0){echo $coil_dia_from =  $res2[0]['coil_dia_from'];} else{ $coil_dia_from = 1;}?>" >
                                        </div>

                                        <div class="col-md-1" style="margin-top:10px">
                                              <label>Coil No To</label>
                                              <input type="number" class="form-control"  id="coil_dia_to" required  autocomplete="off" value="<?php if(isset($res2[0]['coil_dia_to']) and $res2[0]['coil_dia_to']>0){echo $coil_dia_to = $res2[0]['coil_dia_to'];}else{$coil_dia_to = 1;}?>" >
                                        </div>


                                        <div class="col-md-1" style="margin-top:10px; color:blue">
                                              <label>Total Coils</label>
                                              <input type="number" class="form-control"  id="total_coils" required  autocomplete="off" value="<?php if(isset($res2[0]['total_coils']))echo $res2[0]['total_coils'];?>" >
                                        </div>


                                        <div class="col-md-2" style="margin-top:10px; color:green">
                                              <label>Total Pass Colis</label>
                                              <input type="number" class="form-control"  id="total_pass_coils" required  autocomplete="off" value="<?php if(isset($res2[0]['total_pass_coils']))echo $res2[0]['total_pass_coils'];?>" >
                                        </div>

                                        <div class="col-md-2" style="margin-top:10px; color:red">
                                              <label>No. of NC Coils</label>
                                              <input type="number" class="form-control"  id="total_nc_coils" required  autocomplete="off" value="<?php if(isset($res2[0]['total_nc_coils']))echo $res2[0]['total_nc_coils'];?>" >
                                        </div>

                                        <div class="col-md-2" style="margin-top:10px">
                                                <label  >Operator Name</label>
                                                <input type="text" class="form-control" id="operator1"   onKeyUp="op_search(this.id)" value="<?php if(isset($res2[0]['operator1']))echo $res2[0]['operator1'];?>" >
                                            </div>


                                          <div class="col-md-4" style="margin-top:10px">
                                                <label >Select Customer </label>
                                                <select  class="form-control"  style=" width: 100%" id="customer_id" >
                                                      <option  <?php if(isset($res2[0]['customer_id'])){if($res2[0]['customer_id']==''){echo "selected";}}?>  value="">Select</option>
                                                            <?Php 
                                                            foreach($customer as $c)
                                                            {
                                                            ?>
                                                                  <option <?php if(isset($res2[0]['customer_id'])){if($res2[0]['customer_id']==$c['id']){echo "selected";}}?> value="<?php echo $c['id'];?>">
                                                                  <?php echo $c['name'];?>
                                                                  </option>
                                                            <?php
                                                            }
                                                            ?>		
                                                </select>
                                          </div> 

                                          <div class="col-md-6" style="margin-top:10px">
                                              <label>Reason of NC</label>
                                              <input type="text" class="form-control"  id="nc_reason" required  autocomplete="off" value="<?php if(isset($res2[0]['nc_reason']))echo $res2[0]['nc_reason'];?>"   >
                                        </div>
                                          
                                         

                                          <div class="col-md-2" style="margin-top:10px">
                                                <label  >Base Coil After Patt</label>
                                                <select class="form-control" id="for_patt">
                                                      <option value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['for_patt'])){if($res2[0]['for_patt']=='0'){echo "selected";}}?> value="0">No</option> 
                                                      <option  <?php if(isset($res2[0]['for_patt'])){if($res2[0]['for_patt']=='1'){echo "selected";}}?> value="1">Yes</option>
                                                </select>
                                          </div>

                                         <?php 
                                         /*
                                          if(!empty($res2[0]['for_patt']) && (int)$res2[0]['for_patt'] == 1){
                                                //show lotno
                                                ?>
                                                     <input type="hidden" class="form-control"  id="lotno" required  autocomplete="off" value="<?php if(isset($res2[0]['lotno']))echo $res2[0]['lotno'];?>" placeholder="Not use here"  >
                                                <?php
                                          }else{
                                                ?>
                                                       <div class="col-md-2"  style="margin-top:10px">
                                                            <label >Lotno</label>
                                                            <select class="form-control" id="lotno">
                                                                  <option value="">Lotno</option>
                                                                  <?php 
                                                                  $lotnoList = $this->Base->get_all_lotno_for_pickling();
                                                                  foreach($lotnoList as $l)
                                                                  {
                                                                        ?>
                                                                              <option <?php if(isset($res2[0]['lotno'])){if($l['id']==$res2[0]['lotno']){ echo "selected";}}?>   value="<?php echo $l['id'];?>" ><?php echo $l['name'];?></option>
                                                                        <?php
                                                                  }//foreach
                                                                  ?>
                                                            </select>
                                                      </div>

                                                <?php
                                          }
                                          */
                                          ?>


                                        

                                          <div class="col-md-12">
                                            <hr>
                                          </div>

                                       
                                          <div class="col-md-12">
                                                    <table border=1 width="">
                                                          <tr>
                                                                <th>Coil no</th>
                                                                <th>Finish Size</th>
                                                                <th>Breaking Load</th>
                                                                <th>UTS Kgf/mm<sup>2</sup></th>
                                                                <th>Torsion Test</th>
                                                                <th>Band Test</th>
                                                                <th>% RA</th>
                                                                <th>No. Scratch Brightness</th>
                                                                <th>Remarks</th>
                                                                <th>
                                                                  <?php 
                                                                        if(!empty($res2[0]['for_patt']) && (int)$res2[0]['for_patt'] == 1){
                                                                              echo "Coil No, Lotno";
                                                                        }else{
                                                                              echo "Base Coil No. / HeatNo";
                                                                        }
                                                                  ?>
                                                                </th>
                                                                <th>Weight (kg.)</th>
                                                          </tr>
                                                          
                                                      <?php
                                                     
                                                      if(!empty($res3))
                                                      {
                                                            //print_r($res3);
                                                            foreach($res3 as $s)
                                                            {
                                                                  ?>
                                                                  <tr>
                                                                        <input type="hidden" class="form-control qcLogDetailsid"  name="qcLogDetailsid[]" value="<?php echo $s['id'];?>">    
                                                                        <td><input type="number" class="form-control coilno" name="coilno[]"  value="<?php echo $s['coil_no'];?>" readonly  ></td>
                                                                        <td><input type="number" class="form-control finishsize"  name="finish_size[]" value="<?php echo $s['finish_size'];?>"></td>
                                                                        <td><input type="number" class="form-control breakingload"  name="breaking_load[]" value="<?php echo $s['breaking_load'];?>"></td>
                                                                        <td><input type="number" class="form-control uts" readonly name="uts[]" value="<?php echo $s['uts'];?>"></td>
                                                                        <td><input type="text" class="form-control torsiontest"  name="torsion_test[]" value="<?php echo $s['torsion_test'];?>"></td>
                                                                        <td><input type="text" class="form-control bendtest"  name="bend_test[]" value="<?php echo $s['bend_test'];?>"></td>
                                                                        <td><input type="number" class="form-control raper"  name="ra_per[]" value="<?php echo $s['ra_per'];?>"></td>
                                                                        <td><input type="text" class="form-control scratchbrigitness"  name="scratch_brigitness[]" value="<?php echo $s['scratch_brigitness'];?>"></td>
                                                                        <td><input type="text" class="form-control remarks"  name="remarks[]" value="<?php echo $s['remarks'];?>"  ></td>
                                                                        <td>
                                                                              <?php 
                                                                                    if(!empty($res2[0]['for_patt']) && (int)$res2[0]['for_patt'] == 1){
                                                                                          //WD prooduction coil as Base coil
                                                                                          ?>
                                                                                                <select class="form-control baseCoilId" name="baseCoilId[]">
                                                                                                      <option value="">Coilno, Lotno</option>
                                                                                                      <?php 
                                                                                                      foreach($lotno as $l)
                                                                                                      {
                                                                                                            ?>
                                                                                                                   <option <?php if(isset($s['lotno'])){if($l['id']==$s['lotno']){ echo "selected";}}?>   value="<?php echo $l['id'];?>" ><?php echo $l['new_coil_no'].', '.$l['lotname'];?></option>
                                                                                                            <?php
                                                                                                      }//foreach
                                                                                                      ?>
                                                                                                </select>
                                                                                          <?php
                                                                                    }
                                                                                    else{
                                                                                          //ROW material Base coil 
                                                                                         
                                                                                          ?>
                                                                                                <select class="form-control baseCoilId" name="baseCoilId[]">
                                                                                                      <option value="">Select</option>
                                                                                                      <?php 
                                                                                                      foreach($heatCoilNO as $h)
                                                                                                      {
                                                                                                            ?>
                                                                                                            <option <?php if(isset($s['baseCoilId'])){if($h['coil_test_d']==$s['baseCoilId']){ echo "selected";}}?> value="<?php echo $h['coil_test_d'];?>" ><?php echo $h['coil_no'].', '.$h['heat_no'].', '.$h['lotname'];?></option>
                                                                                                            <?php
                                                                                                      }//foreach
                                                                                                      
                                                                                                      if(!empty($s['baseCoilId']) && $s['baseCoilId']>0){
                                                                                                            $heatCoilNO_single = $this->Pomodel->get_all_heatno_colino_from_coil_id($s['baseCoilId']);
                                                                                                            if(!empty($heatCoilNO_single)){
                                                                                                                  ?>
                                                                                                                        <option selected value="<?php echo $heatCoilNO_single[0]['coil_test_d'];?>" >
                                                                                                                              <?php echo  $heatCoilNO_single[0]['coil_no'].', '. $heatCoilNO_single[0]['heat_no'].', '. $heatCoilNO_single[0]['lotname'];?>
                                                                                                                        </option>
                                                                                                                  <?php 
                                                                                                            }
                                                                                                      }// if(!empty($s['baseCoilId']) && $s['baseCoilId']>0){
                                                                                                      ?>
                                                                                                </select>
                                                                                          <?php
                                                                                    }//else
                                                                              ?>
                                                                        </td>
                                                                        
                                                                        <td><input type="text" class="form-control coilweight"  name="coilweight[]" value="<?php echo $s['coil_weight'];?>"  ></td>
                                                                  </tr>
                                                                  <?php
                                                            }//foreach
                                                      }//if
                                                      else
                                                      {
                                                            //new entry
                                                            for($i=$coil_dia_from; $i<=$coil_dia_to; $i++ )
                                                            {
                                                                  ?>
                                                                  <tr>
                                                                        <input type="hidden" class="form-control qcLogDetailsid"  name="qcLogDetailsid[]">      
                                                                        <td><input type="number" readonly class="form-control coilno" name="coilno[]"  value="<?php echo $i;?>"   ></td>
                                                                        <td><input type="number" class="form-control finishsize"  name="finish_size[]"></td>
                                                                        <td><input type="number" class="form-control breakingload"  name="breaking_load[]"></td>
                                                                        <td><input type="number" class="form-control uts" readonly name="uts[]" ></td>
                                                                        <td><input type="text" class="form-control torsiontest"  name="torsion_test[]" ></td>
                                                                        <td><input type="text" class="form-control bendtest"  name="bend_test[]"></td>
                                                                        <td><input type="number" class="form-control raper"  name="ra_per[]" ></td>
                                                                        <td><input type="text" class="form-control scratchbrigitness"  name="scratch_brigitness[]" ></td>
                                                                        <td><input type="text" class="form-control remarks"  name="remarks[]"   ></td>
                                                                        <td>
                                                                              <?php 
                                                                                    if(!empty($res2[0]['for_patt']) && (int)$res2[0]['for_patt'] == 1){
                                                                                          //WD prooduction coil as Base coil
                                                                                          ?>
                                                                                                <select class="form-control baseCoilId" name="baseCoilId[]">
                                                                                                     <option value="">Coilno, Lotno</option>
                                                                                                      <?php 
                                                                                                      foreach($lotno as $l)
                                                                                                      {
                                                                                                            ?>
                                                                                                                   <option <?php if(isset($s['lotno'])){if($l['id']==$s['lotno']){ echo "selected";}}?>   value="<?php echo $l['id'];?>" ><?php echo $l['new_coil_no'].', '.$l['new_coil_no'];?></option>
                                                                                                            <?php
                                                                                                      }//foreach
                                                                                                      ?>
                                                                                                </select>
                                                                                          <?php
                                                                                    }
                                                                                    else{
                                                                                          //ROW material Base coil 
                                                                                          ?>
                                                                                                <select class="form-control baseCoilId" name="baseCoilId[]">
                                                                                                      <option value="">Select</option>
                                                                                                      <?php 
                                                                                                            foreach($heatCoilNO as $h)
                                                                                                            {
                                                                                                                  ?>
                                                                                                                  <option <?php //if(isset($res2[0]['baseCoilId'])){if($h['coil_test_d']==$res2[0]['baseCoilId']){ echo "selected";}}?> value="<?php echo $h['coil_test_d'];?>" ><?php echo $h['coil_no'].', '.$h['heat_no'].', '.$h['lotname'];?></option>
                                                                                                                  <?php
                                                                                                            }
                                                                                                ?>
                                                                                                </select>
                                                                                          <?php
                                                                                    }//else
                                                                              ?>
                                                                        </td>
                                                                        <td><input type="text" class="form-control coilweight"  name="coilweight[]"  ></td>
                                                                  </tr>
                                                                  <?php
                                                            }//foreach
                                                      }//if
                                                     
                                                     ?>
                                                          
                                                    </table>
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


