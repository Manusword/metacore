<?php 
   if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
?>  
            
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Pickling Testing</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Pickling Testing</div>
                                    <div class="form-row">
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      
                                      <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                          
                                      
                                          <div class="col-md-4" style="margin-top:10px">
                                                <label >Date</label>
                                                <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                          </div>
 
                                          <div class="col-md-4" style="margin-top:10px">
                                                <label>Time </label>
                                                      <select class="form-control" id="shift">
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']==''){echo "selected";}}?> value="">Select</option>
                                                            <option  disabled >AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='00:00'){echo "selected";}}?>>00:00</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='01:00'){echo "selected";}}?>>01:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='02:00'){echo "selected";}}?>>02:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='03:00'){echo "selected";}}?>>03:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='04:00'){echo "selected";}}?>>04:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='05:00'){echo "selected";}}?>>05:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='06:00'){echo "selected";}}?>>06:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='07:00'){echo "selected";}}?>>07:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='08:00'){echo "selected";}}?>>08:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='09:00'){echo "selected";}}?>>09:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='10:00'){echo "selected";}}?>>10:00 AM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='11:00'){echo "selected";}}?>>11:00 AM</option>
                                                            <option  disabled >PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='12:00'){echo "selected";}}?>>12:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='13:00'){echo "selected";}}?>>13:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='14:00'){echo "selected";}}?>>14:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='15:00'){echo "selected";}}?>>15:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='16:00'){echo "selected";}}?>>16:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='17:00'){echo "selected";}}?>>17:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='18:00'){echo "selected";}}?>>18:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='19:00'){echo "selected";}}?>>19:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='20:00'){echo "selected";}}?>>20:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='21:00'){echo "selected";}}?>>21:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='22:00'){echo "selected";}}?>>22:00 PM</option>
                                                            <option  <?php if(isset($res2[0]['shift'])){if($res2[0]['shift']=='23:00'){echo "selected";}}?>>23:00 PM</option>

                                                      </select>
                                          </div> 


                                      
                                          <div class="col-md-4" style="margin-top:10px">
                                                <label>Name of QC person</label>
                                                <input type="text" class="form-control"  id="qc_person" required  autocomplete="off" value="<?php if(isset($res2[0]['qc_person']))echo $res2[0]['qc_person'];?>"   >
                                          </div>



                                          <div class="col-md-12">
                                            <hr>
                                            <h4>HCL Tank</h4>
                                          </div>

                                          <div class="col-md-2" >
                                                <label>Conc - Tank 1</label>
                                                <input type="text" class="form-control"  id="tank1_connc" required  autocomplete="off" value="<?php if(isset($res2[0]['tank1_connc']))echo $res2[0]['tank1_connc'];?>"   >
                                          </div>

                                          <div class="col-md-2" >
                                                <label>Fe Content - Tank 1</label>
                                                <input type="text" class="form-control"  id="tank1_fe" required  autocomplete="off" value="<?php if(isset($res2[0]['tank1_fe']))echo $res2[0]['tank1_fe'];?>"   >
                                          </div>


                                          <div class="col-md-2" >
                                                <label>Conc - Tank 2</label>
                                                <input type="text" class="form-control"  id="tank2_connc" required  autocomplete="off" value="<?php if(isset($res2[0]['tank2_connc']))echo $res2[0]['tank2_connc'];?>"   >
                                          </div>

                                          <div class="col-md-2" >
                                                <label>Fe Content - Tank 2</label>
                                                <input type="text" class="form-control"  id="tank2_fe" required  autocomplete="off" value="<?php if(isset($res2[0]['tank2_fe']))echo $res2[0]['tank2_fe'];?>"   >
                                          </div>


                                          <div class="col-md-2" >
                                                <label>Conc - Tank 3</label>
                                                <input type="text" class="form-control"  id="tank3_connc" required  autocomplete="off" value="<?php if(isset($res2[0]['tank3_connc']))echo $res2[0]['tank3_connc'];?>"   >
                                          </div>

                                          <div class="col-md-2" >
                                                <label>Fe Content - Tank 3</label>
                                                <input type="text" class="form-control"  id="tank3_fe" required  autocomplete="off" value="<?php if(isset($res2[0]['tank3_fe']))echo $res2[0]['tank3_fe'];?>"   >
                                          </div>



                                          <div class="col-md-12">
                                            <hr>
                                            <h4>GALVANIZING : HCL Tank</h4>
                                          </div>

                                          <div class="col-md-3" >
                                                <label>Conc - Tank 1</label>
                                                <input type="text" class="form-control"  id="gl_tank1_connc" required  autocomplete="off" value="<?php if(isset($res2[0]['gl_tank1_connc']))echo $res2[0]['gl_tank1_connc'];?>"   >
                                          </div>

                                          <div class="col-md-3" >
                                                <label>Fe Content - Tank 1</label>
                                                <input type="text" class="form-control"  id="gl_tank1_fe" required  autocomplete="off" value="<?php if(isset($res2[0]['gl_tank1_fe']))echo $res2[0]['gl_tank1_fe'];?>"   >
                                          </div>


                                          <div class="col-md-3" >
                                                <label>Conc - Tank 2</label>
                                                <input type="text" class="form-control"  id="gl_tank2_connc" required  autocomplete="off" value="<?php if(isset($res2[0]['gl_tank2_connc']))echo $res2[0]['gl_tank2_connc'];?>"   >
                                          </div>

                                          <div class="col-md-3" >
                                                <label>Fe Content - Tank 2</label>
                                                <input type="text" class="form-control"  id="gl_tank2_fe" required  autocomplete="off" value="<?php if(isset($res2[0]['gl_tank2_fe']))echo $res2[0]['gl_tank2_fe'];?>"   >
                                          </div>

                                          <div class="col-md-12" style="margin-top:30px">
                                            <h5>FLUX</h5>
                                          </div>

                                          <div class="col-md-6" >
                                                <label>SP GRAVITY</label>
                                                <input type="text" class="form-control"  id="flux_gravity" required  autocomplete="off" value="<?php if(isset($res2[0]['flux_gravity']))echo $res2[0]['flux_gravity'];?>"   >
                                          </div>

                                          <div class="col-md-6" >
                                                <label>TEMP</label>
                                                <input type="text" class="form-control"  id="flux_temp" required  autocomplete="off" value="<?php if(isset($res2[0]['flux_temp']))echo $res2[0]['flux_temp'];?>"   >
                                          </div>

                                        
                                          <div class="col-md-12" >
                                                <label>WATER PH</label>
                                                <input type="text" class="form-control"  id="water_ph" required  autocomplete="off" value="<?php if(isset($res2[0]['water_ph']))echo $res2[0]['water_ph'];?>"   >
                                          </div>
                                        
                                        
                                          <div class="col-md-12">
                                            <hr>
                                            <h4>PHOSPHATE</h4>
                                          </div>

                                          <div class="col-md-2" >
                                                <label>Conc</label>
                                                <input type="text" class="form-control"  id="phos_connc" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_connc']))echo $res2[0]['phos_connc'];?>"   >
                                          </div>

                                          <div class="col-md-2" >
                                                <label>Fe Content</label>
                                                <input type="text" class="form-control"  id="phos_fe" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_fe']))echo $res2[0]['phos_fe'];?>"   >
                                          </div>


                                          <div class="col-md-2" >
                                                <label>FA</label>
                                                <input type="text" class="form-control"  id="phos_fa" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_fa']))echo $res2[0]['phos_fa'];?>"   >
                                          </div>

                                          <div class="col-md-2" >
                                                <label>Acc pointage</label>
                                                <input type="text" class="form-control"  id="phos_acc" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_acc']))echo $res2[0]['phos_acc'];?>"   >
                                          </div>


                                          <div class="col-md-2" >
                                                <label>Cl content</label>
                                                <input type="text" class="form-control"  id="phos_cl" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_cl']))echo $res2[0]['phos_cl'];?>"   >
                                          </div>

                                          <div class="col-md-2" >
                                                <label>Temparature</label>
                                                <input type="text" class="form-control"  id="phos_temp" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_temp']))echo $res2[0]['phos_temp'];?>"   >
                                          </div>

                                        

                                          <div class="col-md-12">
                                            <hr>
                                            <h4>BORAX</h4>
                                          </div>

                                          <div class="col-md-6" >
                                                <label>Conc</label>
                                                <input type="text" class="form-control"  id="borex_conc" required  autocomplete="off" value="<?php if(isset($res2[0]['borex_conc']))echo $res2[0]['borex_conc'];?>"   >
                                          </div>

                                          <div class="col-md-6" >
                                                <label>Temparature</label>
                                                <input type="text" class="form-control"  id="borex_temp" required  autocomplete="off" value="<?php if(isset($res2[0]['borex_temp']))echo $res2[0]['borex_temp'];?>"   >
                                          </div>


                                     
                                       
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="pickling_test_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/qc_js');?>


