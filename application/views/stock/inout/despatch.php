<?php 
  if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}

?>  
            
   
           

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Despatch material in FG</h1>
                </div>
                <div class="separator-breadcrumb border-top " ></div>
                <div class="row">
                  <div class="col-md-3" id="today_debit_history_list"></div>
                  <div class="col-md-6">
                      <div class="card mb-4 ">
                            <div class="card-body ">
                              <div class="card-title  ">Material Details</div>
                                    <div class="form-row">
                                     
                                    <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                    <input type="hidden"  id="stock_inout_id"  value="<?php if(isset($res2[0]['stock_inout_id']))echo $res2[0]['stock_inout_id'];?>">
                                          
                                          <div class="col-md-4" style="margin-top:20px">
                                                <label >Dept.</label>
                                                <select class="form-control select2"    id="dept">
                                                      <option <?php if(isset($res2[0]['dept'])){if($res2[0]['dept']=="FG"){ echo "selected"; }}?> value="FG">FG</option>
                                                </select>
                                          </div> 
                                        

                                          <div class="col-md-4" style="margin-top:20px">
                                                <label >Despatch To</label>
                                                <select class="form-control select2"    id="out_to">
                                                      <option  <?php if(isset($res2[0]['out_to'])){if($res2[0]['out_to']==''){echo "selected";}}?>  value="">Select</option>

                                                      <option  <?php if(isset($res2[0]['out_to'])){if($res2[0]['out_to']=='Party'){echo "selected";}}?>  value="Party">Party</option>

                                                      <option <?php if(isset($res2[0]['out_to'])){if($res2[0]['out_to']=="WD"){ echo "selected"; }}?> >WD</option>

                                                      <option <?php if(isset($res2[0]['out_to'])){if($res2[0]['out_to']=="Wet"){ echo "selected"; }}?> >Wet</option>

                                                      <option <?php if(isset($res2[0]['out_to'])){if($res2[0]['out_to']=="Mini"){ echo "selected"; }}?> >Mini</option>

                                                      <option <?php if(isset($res2[0]['out_to'])){if($res2[0]['out_to']=="GI"){ echo "selected"; }}?> >GI</option>

                                                      <option <?php if(isset($res2[0]['out_to'])){if($res2[0]['out_to']=="Rope"){ echo "selected"; }}?> >Rope</option>

                                                      <option <?php if(isset($res2[0]['out_to'])){if($res2[0]['out_to']=="Party"){ echo "selected"; }}?> >Party</option>

                                                      <option <?php if(isset($res2[0]['out_to'])){if($res2[0]['out_to']=="Other"){ echo "selected"; }}?> >Other</option>
                                                </select>
                                          </div> 

                                          <div class="col-md-4" style="margin-top:20px">
                                                <label >Date</label>
                                                <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                          </div>

                                          <div class="col-md-3" style="margin-top:20px">
                                                <label >Size</label>
                                                <input type="text"    class="form-control"   id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','diff_id_one_search2')" value="<?php if(isset($res2[0]['pname']))echo $res2[0]['pname'];?>" onchange="getAllWdCoils()"  />
                                                <input type="hidden"  class="goods"   id="goods_" value="<?php if(isset($res2[0]['product_id']))echo $res2[0]['product_id'];?>"  />
                                          </div>

                                          

                                          <div class="col-md-3" style="margin-top:20px">
                                                <label >Dia</label>
                                                <input type="text" class="form-control"  id="dia" onKeyUp="getAllWdCoils()" required  autocomplete="off" value="<?php  if(isset($res2[0]['dia']))echo $res2[0]['dia'];?>" >
                                          </div>

                                          <div class="col-md-3" style="margin-top:20px">
                                                <label >Oil</label>
                                                <select class="form-control select2"    id="oil" onchange="getAllWdCoils()">
                                                      <option  <?php if(isset($res2[0]['oil'])){if($res2[0]['oil']==''){echo "selected";}}?>  value="">Select</option>
                                                      <option <?php if(isset($res2[0]['oil'])){if($res2[0]['oil']=="Oil"){ echo "selected"; }}?> value="Oil">Oil</option>
                                                      <option <?php if(isset($res2[0]['oil'])){if($res2[0]['oil']=="Without Oil"){ echo "selected"; }}?> value="Without Oil">Without Oil</option>
                                                </select>
                                          </div>

                                         


                                          <div class="col-md-3" style="margin-top:20px">
                                                <label >Grade</label>
                                                <select class="form-control select2"    id="grade" onchange="getAllWdCoils()">
                                                      <option  <?php if(isset($res2[0]['grade_id'])){if($res2[0]['grade_id']==''){echo "selected";}}?>  value="">Select</option>
                                                            <?Php 
                                                            foreach($grade as $c)
                                                            {
                                                            
                                                            ?>
                                                                  <option <?php if(isset($res2[0]['grade_id'])){
                                                                  if($res2[0]['grade_id']==$c['id']){
                                                                        echo "selected";
                                                                  }}?> value="<?php echo $c['id'];?>">
                                                                        <?php echo $c['name'];?>
                                                                  </option>
                                                            <?php
                                                            }
                                                            ?>		
                                                </select>
                                          </div> 

                                          <div class="col-md-12" style="margin-top:20px" id="dis_output">
                                                   To get coils list please select above filter.
                                          </div> 

                                          <div class="col-md-4" style="margin-top:20px">
                                                <label >No. of Coils</label>
                                                <input type="text" class="form-control"  id="no_of_coils" required  autocomplete="off" value="<?php  if(isset($res2[0]['no_of_coils']))echo $res2[0]['no_of_coils'];?>" >
                                          </div>


                                          <div class="col-md-4" style="margin-top:20px">
                                                <label >Weight</label>
                                                <input type="text" class="form-control"  id="weight" required  autocomplete="off" value="<?php  if(isset($res2[0]['weight']))echo $res2[0]['weight'];?>" >
                                          </div>


                                          <div class="col-md-4" style="margin-top:20px">
                                                <label >Unit</label>
                                                <select class="form-control select2"    id="unit">
                                                      <option  <?php if(isset($res2[0]['unit'])){if($res2[0]['unit']==''){echo "selected";}}?>  value="">Select</option>
                                                            <?Php 
                                                            foreach($unit as $c)
                                                            {
                                                                  if($c['unit_id'] != 1 and $c['unit_id'] != 3){
                                                                        continue;
                                                                  }
                                                            ?>
                                                                  <option <?php if(isset($res2[0]['unit'])){
                                                                  if($res2[0]['unit']==$c['unit_id']){
                                                                        echo "selected";
                                                                  }}?> value="<?php echo $c['unit_id'];?>">
                                                                        <?php echo $c['name'];?>
                                                                  </option>
                                                            <?php
                                                            }
                                                            ?>		
                                                </select>
                                          </div> 



                                            <div class="col-md-12" style="margin-top:20px">
                                                  <label >Remarks</label>
                                                  <input type="text" class="form-control"   id="remarks"  autocomplete="off" value="<?php  if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>">
                                            </div>
                                            
                                          
                                            
                                            
                                            
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="despatch_stock_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                  </div>
                  
                    
                </div><!-- end of main-content -->   


<?php $this->load->view('js/product_js');?>

            
                                         
              
              
              
    
              
   
            






  