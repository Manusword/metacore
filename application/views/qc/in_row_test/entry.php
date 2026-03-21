<?php 
 
      if(isset($res3[0]['invoice_date'])){
            $invoice_date = $this->Base->change_date_dmy($res3[0]['invoice_date']);}
      else{$invoice_date ='';}

      if(isset($res3[0]['details_id'])){
            $invoice_deatils_id =  $res3[0]['details_id'];
      }


      if(!empty($res4[0]['min_bl']) && !empty($res4[0]['max_bl'])){
            $blres = $this->Base->get_breakingload_category($res4[0]['min_bl'],$res4[0]['max_bl'],0);
      }else{
            $blres = array();
      }
    
?>  
            
         
        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Incoming Material Inspection</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                  
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Incoming Material Inspection</div>
                                    <div class="form-row">

                                   
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      
                                      <input type="hidden" name="invoice_deatils_id" id="invoice_deatils_id"  value="<?php if(isset($res3[0]['details_id']))echo $res3[0]['details_id'];?>">
                                          
                                      <div class="col-md-4"  style="margin-top:10px">
                                                <label >Select Supplier </label>
                                                <select  class="js-states form-control"  style=" width: 100%" name="supplier_id" id="supplier_id" onChange="fun_gst_type_and_po_product_invoice_entry(this.value)">
                                                      <option  <?php if(isset($res3[0]['supplier_id'])){if($res3[0]['supplier_id']==''){echo "selected";}}?>  value="">Select</option>
                                                        <?Php 
                                                          foreach($supplier as $c)
                                                          {
                                                            ?>
                                                              <option <?php if(isset($res3[0]['supplier_id'])){if($res3[0]['supplier_id']==$c['id']){echo "selected";}}?> value="<?php echo $c['id'];?>">
                                                                  <?php echo $c['name'];?>
                                                              </option>
                                                            <?php
                                                          }
                                                        ?>		
                                                </select>
                                            </div>


                                          <div class="col-md-2" style="margin-top:10px">
                                                <label >Invoice Date</label>
                                                <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php echo $invoice_date;?>">
                                          </div>


 
                                          <div class="col-md-2" style="margin-top:10px">
                                                <label>Invoice No</label>
                                                <input type="text" class="form-control"  id="invoice_no" required  autocomplete="off" value="<?php if(isset($res3[0]['invoice_no']))echo $res3[0]['invoice_no'];?>" >
                                          </div>

                                          <div class="col-md-2" style="margin-top:10px">
                                                <label>Product</label>
                                                <input type="text" class="form-control"  id="pname" required  autocomplete="off" value="<?php if(isset($res3[0]['pname']))echo $res3[0]['pname'];?>"   >
                                          </div>

                                          <div class="col-md-2" style="margin-top:10px">
                                          <label>Grade</label>
                                                <select class="form-control" name="product_grade" id="product_grade">
                                                      <option  <?php if(isset($res4[0]['product_grade'])){if($res4[0]['product_grade']==''){echo "selected";}}?>  value="">Select</option>
                                                      <?Php 
                                                            foreach($grade as $c)
                                                            {
                                                                  ?>
                                                                  <option 
                                                                  <?php 
                                                                        if(isset($res4[0]['product_grade'])){if($res4[0]['product_grade']==$c['id']){echo "selected";}}
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
                                                <label  >Product Type</label>
                                                <select class="form-control" id="product_type">
                                                  <option value="">Select</option>
                                                  <?php 
                                                    foreach($product_type as $u)
                                                    {
                                                      ?>
                                                        <option <?php if(isset($res4[0]['product_type'])){if($u['id']==$res4[0]['product_type']){ echo "selected";}}?> value="<?php echo $u['id'];?>" ><?php echo $u['name'];?></option>
                                                      <?php
                                                    }
                                                    ?>
                                                </select>
                                          </div>

                                         <?php /*
                                          <div class="col-md-2" style="margin-top:10px">
                                                <label>Heat No</label>
                                                <input type="text" class="form-control"  id="heat_no" required  autocomplete="off" value="<?php if(isset($res4[0]['heat_no']))echo $res4[0]['heat_no'];?>" >
                                          </div>
                                          */?>


                                         
                                          <div class="col-md-2" style="margin-top:10px">
                                                <label>Finish Size</label>
                                                <input type="number" class="form-control"  id="finish_size" required  autocomplete="off" value="<?php if(isset($res4[0]['finish_size']))echo $res4[0]['finish_size'];?>"   >
                                          </div>


                                        <div class="col-md-2" style="margin-top:10px; color:blue">
                                              <label>Total Coils</label>
                                              <input type="number" class="form-control"  id="total_coils" required  autocomplete="off" value="<?php if(isset($res3[0]['package'])){echo $coil_to =  $res3[0]['package'];}else{$coil_to = 0;}?>" >
                                        </div>


                                        <div class="col-md-2" style="margin-top:10px; color:blue">
                                              <label> Min Breaking Load</label>
                                              <input type="number" class="form-control"  id="min_bl" required  autocomplete="off" value="<?php if(isset($res4[0]['min_bl']))echo $res4[0]['min_bl'];?>" >
                                        </div>


                                        <div class="col-md-2" style="margin-top:10px; color:blue">
                                              <label> Max Breaking Load</label>
                                              <input type="number" class="form-control"  id="max_bl" required  autocomplete="off" value="<?php if(isset($res4[0]['max_bl']))echo $res4[0]['max_bl'];?>" >
                                        </div>

                                    

                                      

                                          
                                          
                                          <div class="col-md-12">
                                            <hr>
                                            <h4 id='dis_span' style="color:red;"> </h4>
                                          </div>
                                          
                                          
                                          <div class="col-md-12" >
                                                      <h4></h4>   
                                                      <table border=1 width="100%">
                                                            <tr>
                                                                  <th colspan=2></th>      
                                                                  <th colspan=14>Chemical Composition</th>
                                                                  <th colspan=4>Mechanical Properties</th>
                                                            </tr>

                                                          <tr>
                                                                  <th>Sno</th>
                                                                  <th>Heat No</th>
                                                                  <th>C%</th>
                                                                  <th>Mn%</th>
                                                                  <th>P%</th>
                                                                  <th>S%</th>
                                                                  <th>Si%</th>
                                                                  <th>Tot Al%</th>
                                                                  <th>CR%</th>
                                                                  <th>CU%</th>
                                                                  <th>NI%</th>
                                                                  <th>MO%</th>
                                                                  <th>CE<sep>q</sep>%</th>
                                                                  <th>N2 (ppm)</th>
                                                                  <th>IS Grade</th>
                                                                  <th>Equivalent</th>

                                                                  <th>YS (N/mm<sup>2</sup>)</th>
                                                                  <th>UTS (N/mm<sup>2</sup>)</th>
                                                                  <th>EL%</th>
                                                                  <th>RA%</th>
                                                            </tr>


                                                            <?php
                                                     
                                                     if(!empty($heat))
                                                     {
                                                         // print_r($heat);
                                                           $k = 1;
                                                           foreach($heat as $h)
                                                           {
                                                                 ?>
                                    <tr >
                                          <input type="hidden" readonly class="form-control qcheatId"  name="qcheatId[]" value="<?php echo $h['row_qc_heat_id'];?>"> 
                                          <td style="background-color:white;"><?php echo $k;?></td>  
                                          <td><input type="text" class="form-control heatnolist"  name="heatnolist[]"  autocomplete="off" value="<?php if(isset($h['heatno']))echo $h['heatno'];?>"   ></td>
                                          <td><input type="number" class="form-control cval"  name="cval[]"   autocomplete="off" value="<?php if(isset($h['c_val']))echo $h['c_val'];?>"   ></td>
                                          <td> <input type="number" class="form-control mnval"  name="mnval[]"    autocomplete="off" value="<?php if(isset($h['mn_val']))echo $h['mn_val'];?>"   ></td>
                                          <td><input type="number" class="form-control pval"  name="pval[]" autocomplete="off" value="<?php if(isset($h['p_val']))echo $h['p_val'];?>"   ></td>
                                          <td><input type="number" class="form-control sval"  name="sval[]" autocomplete="off" value="<?php if(isset($h['s_val']))echo $h['s_val'];?>"   ></td>
                                          <td><input type="number" class="form-control sival"  name="sival[]"  autocomplete="off" value="<?php if(isset($h['si_val']))echo $h['si_val'];?>"   ></td>
                                          <td> <input type="number" class="form-control totalal"  name="totalal[]"   autocomplete="off" value="<?php if(isset($h['total_al']))echo $h['total_al'];?>"   ></td>
                                          <td> <input type="number" class="form-control crval"  name="crval[]"   autocomplete="off" value="<?php if(isset($h['cr_val']))echo $h['cr_val'];?>"   ></td>
                                          <td> <input type="number" class="form-control coval" name="coval[]"   autocomplete="off" value="<?php if(isset($h['co_val']))echo $h['co_val'];?>"   ></td>
                                          <td> <input type="number" class="form-control nival"  name="nival[]" autocomplete="off" value="<?php if(isset($h['ni_val']))echo $h['ni_val'];?>"   ></td>
                                          <td> <input type="number" class="form-control moval"  name="moval[]"    autocomplete="off" value="<?php if(isset($h['mo_val']))echo $h['mo_val'];?>"   ></td>
                                          <td> <input type="number" class="form-control ceqval"  name="ceqval[]"   autocomplete="off" value="<?php if(isset($h['ceq_val']))echo $h['ceq_val'];?>"   ></td>
                                          <td> <input type="number" class="form-control n2val"  name="n2val[]"    autocomplete="off" value="<?php if(isset($h['n2_val']))echo $h['n2_val'];?>"   ></td>
                                          <td> <input type="text" class="form-control isgrade"  name="isgrade[]"   autocomplete="off" value="<?php if(isset($h['is_grade']))echo $h['is_grade'];?>"   ></td>
                                          <td> <input type="text" class="form-control equivalent"  name="equivalent[]"    autocomplete="off" value="<?php if(isset($h['equivalent']))echo $h['equivalent'];?>"   ></td>
                                         
                                          <td><input type="text" class="form-control ysval"  name="ysval[]" required  autocomplete="off" value="<?php if(isset($h['ys_val']))echo $h['ys_val'];?>"   ></td>
                                          <td> <input type="number" class="form-control utsval"  name="utsval[]" required  autocomplete="off" value="<?php if(isset($h['uts_val']))echo $h['uts_val'];?>"   ></td>
                                          <td><input type="number" class="form-control elval"  name="elval[]" required  autocomplete="off" value="<?php if(isset($h['el_val']))echo $h['el_val'];?>"   ></td>
                                          <td><input type="number" class="form-control raval"  name="raval[]" required  autocomplete="off" value="<?php if(isset($h['ra_val']))echo $h['ra_val'];?>"   ></td>
                                    </tr>
                                                                 <?php
                                                                 $k++;
                                                           }//foreach

                                                           //$coil_to = $coil_to-$j;
                                                           for($i=$k; $i<=$k+3; $i++ )
                                                           {
                                                                 ?>
                                                                  <tr >
                                                                        <input type="hidden" readonly class="form-control qcheatId"  name="qcheatId[]"> 
                                                                        <td style="background-color:white;"><?php echo $i;?></td>  
                                                                        <td><input type="text" class="form-control heatnolist"  name="heatnolist[]"     autocomplete="off"    ></td>
                                                                        <td><input type="number" class="form-control cval"  name="cval[]" autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control mnval"  name="mnval[]"    autocomplete="off"    ></td>
                                                                        <td><input type="number" class="form-control pval"  name="pval[]"   autocomplete="off"   ></td>
                                                                        <td><input type="number" class="form-control sval"  name="sval[]"   autocomplete="off"    ></td>
                                                                        <td><input type="number" class="form-control sival"  name="sival[]"  autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control totalal"  name="totalal[]"   autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control crval"  name="crval[]"   autocomplete="off"    ></td>
                                                                        <td> <input type="number" class="form-control coval" name="coval[]"     autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control nival"  name="nival[]"   autocomplete="off"  ></td>
                                                                        <td> <input type="number" class="form-control moval"  name="moval[]"   autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control ceqval"  name="ceqval[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control n2val"  name="n2val[]"    autocomplete="off"    ></td>
                                                                        <td> <input type="text" class="form-control isgrade"  name="isgrade[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="text" class="form-control equivalent"  name="equivalent[]"    autocomplete="off"   ></td>

                                                                        <td> <input type="text" class="form-control ysval"  name="ys_val[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="text" class="form-control utsval"  name="uts_val[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="text" class="form-control elval"  name="el_val[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="text" class="form-control raval"  name="ra_val[]"    autocomplete="off"   ></td>
                                                                  </tr>
                                                                 <?php
                                                           }//foreach
                                                     }//if
                                                     else
                                                     {
                                                           //new entry

                                                           for($i=1; $i<=5; $i++ )
                                                           {
                                                                 ?>
                                                                  <tr >
                                                                  <input type="hidden" readonly class="form-control qcheatId"  name="qcheatId[]"> 
                                                                        <td style="background-color:white;"><?php echo $i;?></td>  
                                                                        <td><input type="text" class="form-control heatnolist"  name="heatnolist[]"     autocomplete="off"    ></td>
                                                                        <td><input type="number" class="form-control cval"  name="cval[]" autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control mnval"  name="mnval[]"    autocomplete="off"    ></td>
                                                                        <td><input type="number" class="form-control pval"  name="pval[]"   autocomplete="off"   ></td>
                                                                        <td><input type="number" class="form-control sval"  name="sval[]"   autocomplete="off"    ></td>
                                                                        <td><input type="number" class="form-control sival"  name="sival[]"  autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control totalal"  name="totalal[]"   autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control crval"  name="crval[]"   autocomplete="off"    ></td>
                                                                        <td> <input type="number" class="form-control coval" name="coval[]"     autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control nival"  name="nival[]"   autocomplete="off"  ></td>
                                                                        <td> <input type="number" class="form-control moval"  name="moval[]"   autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control ceqval"  name="ceqval[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="number" class="form-control n2val"  name="n2val[]"    autocomplete="off"    ></td>
                                                                        <td> <input type="text" class="form-control isgrade"  name="isgrade[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="text" class="form-control equivalent"  name="equivalent[]"    autocomplete="off"   ></td>

                                                                        <td> <input type="text" class="form-control ysval"  name="ys_val[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="text" class="form-control utsval"  name="uts_val[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="text" class="form-control elval"  name="el_val[]"    autocomplete="off"   ></td>
                                                                        <td> <input type="text" class="form-control raval"  name="ra_val[]"    autocomplete="off"   ></td>
                                                                  </tr>
                                                                 <?php
                                                           }//foreach
                                                     }//if
                                                    /*
                                                    ?>


                                                      <?php */?>
                                                           
                                                      </table>
                                          </div>



                                        

                                          <div class="col-md-12">
                                            <hr>
                                          </div>

                                          
                                          <div class="col-md-12">
                                                    <table border=1 width="100%">
                                                          <tr>
                                                                <th>S.No.</th>
                                                                <th>B.L Category</th>
                                                                <th>Finish Size</th>
                                                                <th>Heat No.</th>
                                                                <th>Coil No. / ID</th>
                                                               <th>Breaking Load</th>
                                                                <th>UTS Kgf/mm<sup>2</sup></th>
                                                                <th>Torsion Test</th>
                                                                <th>Band Test</th>
                                                                <th>RD (mm)</th>
                                                                <th>% RA</th>
                                                                <th>Remarks</th>
                                                          </tr>
                                                          
                                                      <?php
                                                     
                                                      if(!empty($res5))
                                                      {
                                                            //print_r($res3);
                                                            $j = 1;
                                                            foreach($res5 as $s)
                                                            {
                                                                  $minMaxBL = $this->Base->get_breakingload_min_max($blres[2],$blres[3],$blres[4],$blres[5],$s['bl_category']);
                                                                  ?>
                                                                  <tr >
                                                                        <input type="hidden" readonly class="form-control qcTestId"  name="qcTestId[]" value="<?php echo $s['coil_test_d'];?>"> 

                                                                        <td style="background-color:white;"><?php echo $j;?></td>  
                                                                        <th style="background-color:<?php echo $s['bl_color'];?>;color:white;"><?php echo $s['bl_category'].' '.$minMaxBL;?></th>  
                                                                        <td><input type="number" readonly class="form-control finishsize"  name="finish_size[]" value="<?php echo $s['finish_size'];?>"></td> 
                                                                        <td><input type="text"  class="form-control heatno" name="heatno[]"   value="<?php echo $s['heat_no'];?>"   ></td> 
                                                                        <td style="background-color:<?php echo $s['bl_color'];?>"><input type="text" class="form-control coilno" name="coilno[]"  value="<?php echo $s['coil_no'];?>"   ></td>
                                                                        
                                                                        <td style="background-color:<?php echo $s['bl_color'];?>"><input type="number" class="form-control breakingload"  name="breaking_load[]" value="<?php echo $s['breaking_load'];?>"></td>
                                                                        
                                                                        <td><input type="number" readonly class="form-control uts"  name="uts[]" value="<?php echo $s['uts'];?>"></td>
                                                                        <td><input type="text" class="form-control torsiontest"  name="torsion_test[]" value="<?php echo $s['torsion_test'];?>"></td>
                                                                        <td><input type="text" class="form-control bendtest"  name="bend_test[]" value="<?php echo $s['bend_test'];?>"></td>
                                                                        <td><input type="text" class="form-control rdarea"  name="rdarea[]" value="<?php echo $s['rdarea'];?>"></td>
                                                                        <td><input type="number" class="form-control raper"  name="ra_per[]" value="<?php echo $s['ra_per'];?>"></td>
                                                                      
                                                                        <td><input type="text" class="form-control remarks"  name="remarks[]" value="<?php echo $s['remarks'];?>"  ></td>
                                                                       
                                                                  </tr>
                                                                  <?php
                                                                  $j++;
                                                            }//foreach

                                                            //$coil_to = $coil_to-$j;
                                                            for($i=$j; $i<=$coil_to; $i++ )
                                                            {
                                                                  ?>
                                                                  <tr>
                                                                        <input type="hidden" readonly class="form-control qcTestId"  name="qcTestId[]" value="">
                                                                        <td><?php echo $i;?></td>
                                                                        <td></td>
                                                                        <td><input type="number" readonly class="form-control finishsize"  name="finish_size[]" value="<?php if(isset($res4[0]['finish_size']))echo $res4[0]['finish_size'];?>"></td>
                                                                        <td><input type="text"  class="form-control heatno" name="heatno[]"     ></td>
                                                                        <td><input type="text"  class="form-control coilno" name="coilno[]"    ></td>
                                                                        <td><input type="number" class="form-control breakingload"  name="breaking_load[]"></td>
                                                                       
                                                                        <td><input type="number" readonly class="form-control uts"  name="uts[]" ></td>
                                                                        <td><input type="text" class="form-control torsiontest"  name="torsion_test[]" ></td>
                                                                        <td><input type="text" class="form-control bendtest"  name="bend_test[]"></td>
                                                                        <td><input type="text" class="form-control rdarea"  name="rdarea[]" ></td>
                                                                        <td><input type="number" class="form-control raper"  name="ra_per[]" ></td>
                                                                       
                                                                        <td><input type="text" class="form-control remarks"  name="remarks[]"   ></td>
                                                                       
                                                                  </tr>
                                                                  <?php
                                                            }//foreach
                                                      }//if
                                                      else
                                                      {
                                                            //new entry

                                                            for($i=1; $i<=$coil_to; $i++ )
                                                            {
                                                                  ?>
                                                                  <tr>
                                                                        <input type="hidden" readonly class="form-control qcTestId"  name="qcTestId[]" value="">     
                                                                        <td><?php echo $i;?></td>
                                                                        <td></td>
                                                                        <td><input type="number" readonly class="form-control finishsize"  name="finish_size[]" value="<?php if(isset($res4[0]['finish_size']))echo $res4[0]['finish_size'];?>"></td>
                                                                        <td><input type="text"  class="form-control heatno" name="heatno[]"     ></td>
                                                                        <td><input type="text"  class="form-control coilno" name="coilno[]"    ></td>
                                                                        <td><input type="number" class="form-control breakingload"  name="breaking_load[]"></td>
                                                                        <td><input type="number" readonly class="form-control uts"  name="uts[]" ></td>
                                                                        <td><input type="text" class="form-control torsiontest"  name="torsion_test[]" ></td>
                                                                        <td><input type="text" class="form-control bendtest"  name="bend_test[]"></td>
                                                                        <td><input type="text" class="form-control rdarea"  name="rdarea[]" ></td>
                                                                        <td><input type="number" class="form-control raper"  name="ra_per[]" ></td>
                                                                        <td><input type="text" class="form-control remarks"  name="remarks[]"   ></td>
                                                                  </tr>
                                                                  <?php
                                                            }//foreach
                                                      }//if
                                                     
                                                     ?>
                                                          
                                                    </table>
                                          </div>

                                      


                                          <div class="col-md-12"  style="margin-top:30px">
                                                <h4>Breaking Load Category wise Details</h4>   
                                          </div>

                                          <div class="col-md-12">
                                                    <table border=1 width="40%">
                                                          <tr>
                                                            <th>B.L Category</th>
                                                            <th>No of Coils</th>
                                                            <th>Coil No. / ID</th>
                                                          </tr>
                                                          
                                                      <?php
                                                      if(isset($res3[0]['details_id']))
                                                      {
                                                            $res6 = $this->Pomodel->get_po_invoice_qc_row_test_coils_with_category($res3[0]['details_id']);
                                                            if(!empty($res6))
                                                            {
                                                                  $j = 1;
                                                                  $total_coils = array();
                                                                  foreach($res6 as $s)
                                                                  {
                                                                        $res7 = $this->Pomodel->get_po_invoice_qc_row_test_coils_with_category_coilsno($res3[0]['details_id'],$s['bl_category']);
                                                                       
                                                                        $minMaxBL = $this->Base->get_breakingload_min_max($blres[2],$blres[3],$blres[4],$blres[5],$s['bl_category']);
                                                                        ?>
                                                                              <tr >
                                                                                    <td style="background-color:<?php echo $s['bl_color'];?>;color:white;"><?php echo $s['bl_category'].' '.$minMaxBL;?></td>
                                                                                    <td style="background-color:white;"><?php echo $total_coils[] =  $s['no_of_coils'];?></td>  
                                                                                    <td style="background-color:white;">
                                                                                          <?php  
                                                                                                //print_r($res7);
                                                                                                if(!empty($res7)){
                                                                                                      foreach($res7 as $coil)
                                                                                                      {
                                                                                                            echo $coil['coil_no'];
                                                                                                            echo ", ";
                                                                                                      }
                                                                                                }
                                                                                          ?>
                                                                                    </td>  
                                                                              </tr>
                                                                        <?php
                                                                        $j++;
                                                                  }//foreach
                                                            }

                                                      } 
                                                     ?>

                                                      <tr>
                                                            <td><b>Total Checked</b></td>
                                                            <td><b><?php if(!empty($total_coils))echo array_sum($total_coils);?></b></td>
                                                            <td></td>
                                                      </tr>
                                                          
                                                    </table>
                                          </div>


                                     
                                       
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="in_row_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/qc_js');?>


