<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
   if(isset($res2[0]['invoice_date'])){$invoice_date=$this->Base->change_date_dmy($res2[0]['invoice_date']);}else{$invoice_date='';}
   
?>  
            
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Material Test Certificate</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                  
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Material Test Certificate </div>
                                    <div class="form-row">
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      
                                      <input type="hidden" name="tc_id" id="tc_id"  value="<?php if(isset($res2[0]['tc_id']))echo $res2[0]['tc_id'];?>">
                                          
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


                                          <div class="col-md-2" style="margin-top:10px">
                                                <label >Date</label>
                                                <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                          </div>


 
                                          <div class="col-md-2" style="margin-top:10px">
                                                <label>Invoice No</label>
                                                <input type="text" class="form-control"  id="invoice_no" required  autocomplete="off" value="<?php if(isset($res2[0]['invoice_no']))echo $res2[0]['invoice_no'];?>" >
                                          </div>

                                          <div class="col-md-2" style="margin-top:10px">
                                                <label>Certificate No</label>
                                                <input type="text" class="form-control"  id="certificate_no" required  autocomplete="off" value="<?php if(isset($res2[0]['certificate_no']))echo $res2[0]['certificate_no'];?>" >
                                          </div>


                                        
                                        

                                          <div class="col-md-2" style="margin-top:10px">
                                              <label>No of Coil / Spool</label>
                                              <input type="number" class="form-control"  id="no_coil" required  autocomplete="off" value="<?php if(isset($res2[0]['no_coil']))echo $res2[0]['no_coil'];?>" >
                                          </div>

                                          <div class="col-md-2" style="margin-top:10px">
                                                <label >Product Type </label>
                                                <select  class="form-control"  style=" width: 100%" id="product_type" >
                                                      <option  <?php if(isset($res2[0]['product_type'])){if($res2[0]['product_type']==''){echo "selected";}}?>  value="">Select</option>
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

                                          <div class="col-md-2" style="margin-top:10px">
                                                <label>Product</label>
                                                <input type="text" class="form-control"  id="product_name" required  autocomplete="off" value="<?php if(isset($res2[0]['product_name']))echo $res2[0]['product_name'];?>"   >
                                          </div>

                                          <div class="col-md-2" style="margin-top:10px">
                                              <label>Size (mm) <span style='color:red;'>(0.500)</span></label>
                                              <input type="number" class="form-control"  id="size" required  autocomplete="off" value="<?php if(isset($res2[0]['size']))echo $res2[0]['size'];?>" onchange="fun_get_tc_details(this.value)"  >
                                          </div>

                                          <div class="col-md-2" style="margin-top:10px">
                                              <label>Weight(kg)</label>
                                              <input type="number" class="form-control"  id="weight" required  autocomplete="off" value="<?php if(isset($res2[0]['weight']))echo $res2[0]['weight'];?>"   >
                                          </div>


                                          <div class="col-md-2" style="margin-top:10px">
                                                <label >Invoie Date</label>
                                                <input type="text" class="form-control"  id="invoice_date" required  autocomplete="off" value="<?php if(isset($invoice_date))echo $invoice_date;?>" >
                                          </div>
                                          
                                          
                                          
                                          <div class="col-md-12">
                                            <hr>
                                            <h4 id='dis_span' style="color:red;"> </h4>
                                          </div>


                                          <div class="col-md-12" >
                                                      <h2>Chemical Composition</h2>   
                                                      <table border=1 width="100%">
                                                          <tr>
                                                                <th>Elements</th>
                                                                <th></th>
                                                                <th>C%</th>
                                                                <th>Mn%</th>
                                                                <th>Si%</th>
                                                                <th>P%</th>
                                                                <th>S%</th>
                                                                <th>Heat. No.</th>
                                                            </tr>

                                                            <tr>
                                                                  <td>Grade</td>
                                                                  <td>Min</td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="c_min" required  autocomplete="off" value="<?php if(isset($res2[0]['c_min']))echo $res2[0]['c_min'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="mn_min" required  autocomplete="off" value="<?php if(isset($res2[0]['mn_min']))echo $res2[0]['mn_min'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="si_min" required  autocomplete="off" value="<?php if(isset($res2[0]['si_min']))echo $res2[0]['si_min'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="p_min" required  autocomplete="off" value="<?php if(isset($res2[0]['p_min']))echo $res2[0]['p_min'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="s_min" required  autocomplete="off" value="<?php if(isset($res2[0]['s_min']))echo $res2[0]['s_min'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="text" class="form-control"  id="heatno_1" required  autocomplete="off" value="<?php if(isset($res2[0]['heatno_1']))echo $res2[0]['heatno_1'];?>"   >
                                                                  </td>
                                                            </tr>
                                                            <tr>
                                                                  <td>Grade</td>
                                                                  <td>Max</td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="c_max" required  autocomplete="off" value="<?php if(isset($res2[0]['c_max']))echo $res2[0]['c_max'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="mn_max" required  autocomplete="off" value="<?php if(isset($res2[0]['mn_max']))echo $res2[0]['mn_max'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="si_max" required  autocomplete="off" value="<?php if(isset($res2[0]['si_max']))echo $res2[0]['si_max'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="p_max" required  autocomplete="off" value="<?php if(isset($res2[0]['p_max']))echo $res2[0]['p_max'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="s_max" required  autocomplete="off" value="<?php if(isset($res2[0]['s_max']))echo $res2[0]['s_max'];?>"   >
                                                                  </td>
                                                                  <td>
                                                                        <input type="text" class="form-control"  id="heatno_2" required  autocomplete="off" value="<?php if(isset($res2[0]['heatno_2']))echo $res2[0]['heatno_2'];?>"   >
                                                                  </td>
                                                            </tr>
                                                            <tr>
                                                                  <td>Observed Value</td>
                                                                  <td></td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="c_obs" required  autocomplete="off" value="<?php if(isset($res2[0]['c_obs']))echo $res2[0]['c_obs'];?>"  onkeyup="fun_check_c_obs(this.value)"  >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="mn_obs" required  autocomplete="off" value="<?php if(isset($res2[0]['mn_obs']))echo $res2[0]['mn_obs'];?>"   onkeyup="fun_check_mn_obs(this.value)">
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="si_obs" required  autocomplete="off" value="<?php if(isset($res2[0]['si_obs']))echo $res2[0]['si_obs'];?>"  onkeyup="fun_check_si_obs(this.value)" >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="p_obs" required  autocomplete="off" value="<?php if(isset($res2[0]['p_obs']))echo $res2[0]['p_obs'];?>"  onkeyup="fun_check_p_obs(this.value)" >
                                                                  </td>
                                                                  <td>
                                                                        <input type="number" class="form-control"  id="s_obs" required  autocomplete="off" value="<?php if(isset($res2[0]['s_obs']))echo $res2[0]['s_obs'];?>" onkeyup="fun_check_s_obs(this.value)"  >
                                                                  </td>
                                                                  <td>
                                                                        <input type="text" class="form-control"  id="heatno_3" required  autocomplete="off" value="<?php if(isset($res2[0]['heatno_3']))echo $res2[0]['heatno_3'];?>"   >
                                                                  </td>
                                                            </tr>
                                                      </table>
                                          </div>
                                                          



                                        

                                          <div class="col-md-12">
                                            <hr>
                                            
                                          </div>



                                          <div class="col-md-12">
                                                      <h2>Physical & Mechanical Properties</h2>      
                                                      <table border=1 width="">
                                                            <tr>
                                                                  <th>Spec.</th>
                                                                  <th>Coil no</th>
                                                                  <th>Diameter (mm)</th>
                                                                  <th>UTS Kgf/mm<sup>2</sup></th>
                                                                  <th>Torsion (Turns)</th>
                                                                  <th>% RA</th>
                                                                  <th>Zinc Coating (gm/m<sup>2</sup>)</th>
                                                                  <th>Bend Test</th>
                                                                  <th>Surface</th>
                                                                  <th>Remarks</th>
                                                            </tr>

                                                                  

                                                          
                                                      <?php
                                                     
                                                      if(!empty($res3))
                                                      {
                                                            //print_r($res3);
                                                            $j=1;
                                                            foreach($res3 as $s)
                                                            {
                                                                  ?>
                                                                  <tr <?php if($j<= 2){echo "style='border: 1px blue'";}?>>
                                                                        <td><?php if($j== 3){echo "Result";}?> <?php //echo $j;?> </td>      
                                                                        <td><input type="text" class="form-control coilno" name="coilno[]"  value="<?php echo $s['coilno'];?>" id="coilnoId_<?php echo $j;?>"   ></td>
                                                                        <td><input type="number" class="form-control diameter"  name="diameter[]" value="<?php echo $s['diameter'];?>" id="diaId_<?php echo $j;?>"  onkeyup="fun_check_tc_dia(this.id)"></td>
                                                                        <td><input type="number" class="form-control uts"  name="uts[]" value="<?php echo $s['uts'];?>" id="utsId_<?php echo $j;?>"  onkeyup="fun_check_tc_uts(this.id)"></td>
                                                                        <td><input type="text" class="form-control torsiontest"  name="torsiontest[]" value="<?php echo $s['torsiontest'];?>" id="tsId_<?php echo $j;?>" ></td>
                                                                        <td><input type="text" class="form-control raper"  name="raper[]" value="<?php echo $s['raper'];?>" id="raId_<?php echo $j;?>" ></td>
                                                                        <td><input type="text" class="form-control zinc"  name="bend_teszinct[]" value="<?php echo $s['zinc'];?>" id="zincId_<?php echo $j;?>" ></td>
                                                                        <td><input type="text" class="form-control bend"  name="bend[]" value="<?php echo $s['bend'];?>" id="bendId_<?php echo $j;?>" ></td>
                                                                        <td><input type="text" class="form-control surface"  name="surface[]" value="<?php echo $s['surface'];?>" id="sufId_<?php echo $j;?>" ></td>
                                                                        <td><input type="text" class="form-control remarks"  name="remarks[]" value="<?php echo $s['remarks'];?>" id="remId_<?php echo $j;?>"   ></td>
                                                                  </tr>
                                                                  <?php
                                                                  $j++;
                                                            }//foreach
                                                            $k= $j;
                                                             //new entry
                                                             for($j=$k; $j<=10; $j++ )
                                                             {
                                                                   ?>
                                                                         <tr>
                                                                              <td> <?php if($j== 3){echo "Result";}?><?php echo $j;?></td>      
                                                                              <td><input type="text" class="form-control coilno" name="coilno[]"  id="coilnoId_<?php echo $j;?>"   ></td>
                                                                              <td><input type="number" class="form-control diameter"  name="diameter[]"  id="diaId_<?php echo $j;?>"  onkeyup="fun_check_tc_dia(this.id)"></td>
                                                                              <td><input type="number" class="form-control uts"  name="uts[]"  id="utsId_<?php echo $j;?>"   onkeyup="fun_check_tc_uts(this.id)"></td>
                                                                              <td><input type="text" class="form-control torsiontest"  name="torsiontest[]"  id="tsId_<?php echo $j;?>" ></td>
                                                                              <td><input type="text" class="form-control raper"  name="raper[]"  id="raId_<?php echo $j;?>" ></td>
                                                                              <td><input type="text" class="form-control zinc"  name="bend_teszinct[]" id="zincId_<?php echo $j;?>" ></td>
                                                                              <td><input type="text" class="form-control bend"  name="bend[]"  id="bendId_<?php echo $j;?>" ></td>
                                                                              <td><input type="text" class="form-control surface"  name="surface[]"  id="sufId_<?php echo $j;?>" ></td>
                                                                              <td><input type="text" class="form-control remarks"  name="remarks[]"  id="remId_<?php echo $j;?>"   ></td>
                                                                        </tr>
                                                                   <?php
                                                             }//foreach
                                                      }//if
                                                      else
                                                      {     
                                                            ?>
                                                                <tr style="border: 1px blue">
                                                                        <td></td>
                                                                        <td><input type="text" class="form-control coilno" name="coilno[]" value="Min" id='coilnoId_1'  ></td>
                                                                        <td><input type="number" class="form-control diameter"  name="diameter[]" id='diaId_1' ></td>
                                                                        <td><input type="number" class="form-control uts"  name="uts[]" id='utsId_1' ></td>
                                                                        <td><input type="text" class="form-control torsiontest"  name="torsion_test[]" id='tsId_1' ></td>
                                                                        <td><input type="text" class="form-control raper"  name="ra_per[]" id='raId_1' ></td>
                                                                        <td><input type="text" class="form-control zinc"  name="zinc[]" id='zincId_1' ></td>
                                                                        <td><input type="text" class="form-control bend"  name="bend[]" id='bendId_1' ></td>
                                                                        <td><input type="text" class="form-control surface"  name="surface[]" id='sufId_1' ></td>
                                                                        <td><input type="text" class="form-control remarks"  name="remarks[]"   id='remId_1' ></td>
                                                                  </tr> 
                                                                  <tr style="border: 1px blue">
                                                                        <td></td>
                                                                        <td><input type="text" class="form-control coilno" name="coilno[]" value="Max"  id='coilnoId_2'  ></td>
                                                                        <td><input type="number" class="form-control diameter"  name="diameter[]" id='diaId_2' ></td>
                                                                        <td><input type="number" class="form-control uts"  name="uts[]" id='utsId_2' ></td>
                                                                        <td><input type="text" class="form-control torsiontest"  name="torsion_test[]" id='tsId_2' ></td>
                                                                        <td><input type="text" class="form-control raper"  name="ra_per[]" id='raId_2' ></td>
                                                                        <td><input type="text" class="form-control zinc"  name="zinc[]" id='zincId_2' ></td>
                                                                        <td><input type="text" class="form-control bend"  name="bend[]" id='bendId_2' ></td>
                                                                        <td><input type="text" class="form-control surface"  name="surface[]" id='sufId_2' ></td>
                                                                        <td><input type="text" class="form-control remarks"  name="remarks[]"  id='remId_2'  ></td>
                                                                  </tr> 
                                                            <?php
                                                          
                                                            //new entry
                                                            for($j=3; $j<=12; $j++ )
                                                            {
                                                                  ?>
                                                                        <tr>
                                                                              <td><?php if($j == 1){echo "Result";}?></td>
                                                                              <td><input type="text" class="form-control coilno" name="coilno[]" id="coilnoId_<?php echo $j;?>"   ></td>
                                                                              <td><input type="number" class="form-control diameter"  name="diameter[]" id="diaId_<?php echo $j;?>"  onkeyup="fun_check_tc_dia(this.id)"></td>
                                                                              <td><input type="number" class="form-control uts"  name="uts[]" id="utsId_<?php echo $j;?>"  onkeyup="fun_check_tc_uts(this.id)" ></td>
                                                                              <td><input type="text" class="form-control torsiontest"  name="torsion_test[]" ></td>
                                                                              <td><input type="text" class="form-control raper"  name="ra_per[]" ></td>
                                                                              <td><input type="text" class="form-control zinc"  name="zinc[]" ></td>
                                                                              <td><input type="text" class="form-control bend"  name="bend[]" ></td>
                                                                              <td><input type="text" class="form-control surface"  name="surface[]" ></td>
                                                                              <td><input type="text" class="form-control remarks"  name="remarks[]"   ></td>
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
                                                      <button type="button" class="btn btn-success" id="tc_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/qc_js');?>


