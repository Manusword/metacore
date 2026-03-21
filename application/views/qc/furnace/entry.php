   <?php 
      if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}
    
?>  
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Furnace Production Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Furnace Production Entry</div>
                                    <div class="form-row">
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                  
                                
                                          <div class="col-md-2" style="margin-top:10px">
                                                <label >Date</label>
                                                <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                          </div>


                                          <div class="col-md-2" style="margin-top:10px">
                                                <label >Size</label>
                                                <input type="text" class="form-control"  id="actual_size" required  autocomplete="off" value="<?php if(isset($res2[0]['actual_size']))echo $res2[0]['actual_size'];?>" >
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
                                                <label >Lotno</label>
                                                <select class="form-control" id="lotno">
                                                      <option value="">Lotno</option>
                                                      <?php 
                                                        $lotnoList = $this->Base->get_all_lotno_for_fur();
                                                        foreach($lotnoList as $l)
                                                        {
                                                              ?>
                                                                  <option <?php if(isset($res2[0]['lotno'])){if($l['id']==$res2[0]['lotno']){ echo "selected";}}?>   value="<?php echo $l['id'];?>" ><?php echo $l['name'];?></option>
                                                              <?php
                                                        }//foreach
                                                      ?>
                                                </select>
                                              </div>


                                          
                                          <table class="table table-sm table-bordered" style="margin-top: 50px;">
                                                <tr>
                                                      <th>#</th>
                                                      <th>New Coil no</th>
                                                     
                                                      <th>Base Size</th>
                                                      <th>Finish Size</th>
                                                      <th>Breakling Load</th>
                                                      <th>UTS</th>
                                                      <th>Zinc</th>
                                                      <th>RA %</th>
                                                      <th>Temp</th>
                                                      <th>Speed</th>
                                                      <th>Remarks</th>
                                                </tr>
                                                <?php 
                                                      if(empty($res2)){$no =30;}else{$no=1;}
                                                      for($i=1;$i<=$no;$i++){
                                                      ?>
                                                            <tr>
                                                                  <td><?php echo $i;?></td>      
                                                                  <td>
                                                                        <input type="hidden" class="form-control rowID"  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['id'];?>" placeholder="id" >      
                                                                        <input type="number" class="form-control newCoilNo"  autocomplete="off"  value="<?php if(!empty($res2))echo $res2[0]['new_coil_no'];?>">
                                                                  </td>
                                                                  <td><input type="number" class="form-control baseSize"  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['base_size'];?>"></td>
                                                                  
                                                                  <td><input type="number" class="form-control finishSize"  autocomplete="off"  value="<?php if(!empty($res2))echo $res2[0]['finish_size'];?>"></td>
                                                                  <td><input type="number" class="form-control BreaklingLoad"  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['bl'];?>"></td>
                                                                  <td><input type="number" class="form-control uts"  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['uts'];?>"></td>

                                                                  <td><input type="number" class="form-control zinc"  autocomplete="off"  value="<?php if(!empty($res2))echo $res2[0]['zinc'];?>"></td>
                                                                  <td><input type="number" class="form-control raPer"  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['ra'];?>"></td>
                                                                  <td><input type="number" class="form-control tempInC"  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['temp'];?>"></td>

                                                                  <td><input type="number" class="form-control speed"  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['speed'];?>"></td>
                                                                  <td><input type="text" class="form-control remarks"  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['remarks'];?>" ></td>
                                                            </tr>
                                                      <?php 
                                                      }//for
                                                      
                                                ?>
                                          </table>








                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="furnace_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/qc_js');?>


