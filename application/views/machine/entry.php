   
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Machine</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Machine</div>
                                    <div class="form-row">
                                      
                                     
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['mc_id']))echo $res2[0]['mc_id'];?>">
                                                    
                                                                            
                                           

                                            <div class="col-md-3">
                                                <label >Dept. Name</label>
                                                <select class="form-control"   id="dept">
                                                    <option  <?php if(isset($res2[0]['dept'])){if($res2[0]['dept']==''){echo "selected";}}?>  value="">Select</option>
                                                        <?Php 
                                                        foreach($dept as $d)
                                                        {
                                                            ?>
                                                            <option <?php if(isset($res2[0]['dept'])){if($res2[0]['dept']==$d['department_id']){echo "selected";}}?> value="<?php echo $d['department_id'];?>">
                                                                <?php echo $d['name'];?>
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>		
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                    <label >Machine Name or No</label>
                                                    <input type="text" class="form-control"  id="name"   autocomplete="off" value="<?php if(isset($res2[0]['name']))echo $res2[0]['name'];?>"  >
                                            </div> 

                                            <div class="col-md-3">
                                                <div class="form-group" >
                                                <label for="exampleInputEmail1">Capstan Size</label>
                                                <input type="number" class="form-control"   id="capstan"   autocomplete="off" value="<?php if(isset($res2[0]['capstan']))echo $res2[0]['capstan'];?>"  >
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-3">
                                                <div class="form-group" >
                                                <label for="exampleInputEmail1">Max Speed (RPM)</label>
                                                <input type="number" class="form-control"  id="max_speed"   autocomplete="off" value="<?php if(isset($res2[0]['max_speed']))echo $res2[0]['max_speed'];?>"  >
                                                </div>
                                            </div>

                                           

                                            <div class="col-md-3">
                                                <div class="form-group" >
                                                <label for="exampleInputEmail1">Min Base Size (mm)</label>
                                                <input type="number" class="form-control"   id="min_base_size"   autocomplete="off" value="<?php if(isset($res2[0]['min_base_size']))echo $res2[0]['min_base_size'];?>"  >
                                                </div>
                                            </div>
                                        
                                        
                                        
                                            <div class="col-md-3">
                                                <div class="form-group" >
                                                <label for="exampleInputEmail1">Max Base  Size (mm)</label>
                                                <input type="number" class="form-control" id="max_base_size"   autocomplete="off" value="<?php if(isset($res2[0]['max_base_size']))echo $res2[0]['max_base_size'];?>"  >
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="col-md-3">
                                                <div class="form-group" >
                                                <label for="exampleInputEmail1">Min Finish Size (mm)</label>
                                                <input type="number" class="form-control"  id="min_finish_size"   autocomplete="off" value="<?php if(isset($res2[0]['min_finish_size']))echo $res2[0]['min_finish_size'];?>"  >
                                                </div>
                                            </div>
                                        
                                        
                                        
                                            <div class="col-md-3">
                                                <div class="form-group" >
                                                <label for="exampleInputEmail1">Max Finish  Size (mm)</label>
                                                <input type="number" class="form-control"  id="max_finish_size"   autocomplete="off" value="<?php if(isset($res2[0]['max_finish_size']))echo $res2[0]['max_finish_size'];?>"  >
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            
               


                                           
                                            <!------------Row 3 start------------>
                                                <div class="col-md-12" style="margin-top:50px;" >
                                                    <div class="row-fluid">
                                                        <table  class="table" style="width:100%">
                                                            <thead>
                                                                <!--<tr>
                                                                    <th>Tool Name</th>
                                                                    <th>Length (mtr.)</th>
                                                                </tr>-->
                                                            </thead>
                                                        <tbody>
                                                                <?php 
                                                                /*
                                                                foreach($ropes_mc_tools as $r)
                                                                {
                                                                    $tool_id=$r['ropes_mc_tools_id'];
                                                                    
                                                                    if(isset($res2[0]['mc_id']))
                                                                    {
                                                                        $id=$res2[0]['mc_id'];
                                                                        $where="mc_id='$id' and tool_id='$tool_id' ";
                                                                        $out=$this->Mymodel->select_where('rope_mc_details',$where);
                                                                        if(!empty($out))
                                                                        {
                                                                            $l=$out[0]['lenght'];
                                                                            $tool_id=$out[0]['wet_mc_wire_details_id'];
                                                                        }
                                                                        else
                                                                        {
                                                                            //$l=$r['default_length'];
                                                                            $l=0;
                                                                            $tool_id=0;
                                                                        }
                                                                    }
                                                                    */
                                                                ?>
                                                                <tr>
                                                                    <td>
                                                                        <input type="hidden" class="rope_mc_details_id" value="<?php //echo $tool_id;?>1" >
                                                                        <input type="hidden" class="tool_id" value="<?php //echo $r['ropes_mc_tools_id'];?>1" ><?php //echo $r['name'];?>
                                                                    </td>
                                                                    <td><input type="hidden" class="lenght" value="<?php //if(!empty($l))echo $l;?>" style="height:100; width:150px;"></td>
                                                                </tr>
                                                                <?php 
                                                                //}//foreach
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            <!------------Row 3 close------------>  
                                        



                                            <!------------Row 3 start------------>
                                            <div class="col-md-12"    style=" margin-top:50px;">
                                                <div class="row-fluid">
                                                    <div class="span12" >
                                                        <div class="widget-box">
                                                            
                                                            <!------------From start------------>
                                                            <div class="widget-content nopadding">
                                    
                                                                <div style=" margin-left:40px;">
                                                                    <input class="form-control-new" readonly  value="Description" type="text" style=" height:30px; width:200px; border:none; background-color:#f7f7f5; margin-left:5px;" />
                                                                    <input class="form-control-new" readonly value="Hours" type="text" style=" height:30px; width:100px; border:none; background-color:#f7f7f5;" />
                                                                    <input class="form-control-new" readonly  value="Max Lenght"  type="text" style=" height:30px; width:100px;border:none; background-color:#f7f7f5;" />
                                                                    <input class="form-control-new" readonly value="80% length" type="text" style=" height:30px; width:100px; border:none; background-color:#f7f7f5;" />
                                                                </div>

                                                                <?php 
                                                                //----------------------------------update case
                                                                if(isset($res3) and count($res3)>0)
                                                                {
                                                                    $k=1000;
                                                                    foreach($res3 as $w)
                                                                    {
                                                                        $product_id2=$w['product_id'];
                                                                        $where=" product_id='$product_id2' ";
                                                                        $product2 = $this->Mymodel->select_where('product',$where);
                                                                        ?>
                                                                        <div id="readrootjr<?php echo $k;?>" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                                <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_<?php echo $k;?>">
                                                                                    <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                                </a>
                                                                                <input type="hidden" name="detailsid[]" class="detailsid"  value="<?php echo $w['mc_eff_id'];?>" id="detailsid_<?php echo $k;?>">
                                                                                <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_<?php echo $k;?>" onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_rate')" value="<?php echo $product2[0]['name'];?>" />
                                                                                <input type="hidden"   style="height:33px;   width:40px; " id="goods_<?php echo $k;?>"  name="goods[]" class="goods" placeholder="P.id"  value="<?php echo $w['product_id'];?>"/>
                                                                                <input type="text"   style="height:33px; width:100px; " class="hours" id="hours_<?php echo $k;?>" name="hours[]" value="<?php echo $w['total_hour'];?>" onKeyUp="fun_get_weight(this.id)"/>
                                                                                <input type="text"   style="height:33px; width:100px; " class="qunt" id="qunt_<?php echo $k;?>" name="qunt[]" value="<?php echo $w['total_pro'];?>" onKeyUp="fun_get_weight(this.id)"/>
                                                                                <input type="text"   style="height:33px; width:100px; " class="eff" id="eff_<?php echo $k;?>" name="eff[]" value="<?php echo $w['pro_eff'];?>" />
                                                                        </div>
                                                                        <?php
                                                                        $k++;
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    ?>
                                                                    <div id="readrootjr" style="display:;  margin-bottom:20px; margin-top:10px;">
                                                                            <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
                                                                                <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                            </a>
                                                                            <input type="hidden" name="details_id[]" class="details_id"  value="0" id="detailsid_">
                                                                            <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_rate')" />
                                                                            <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />
                                                                            
                                                                            <input type="text"   style="height:33px; width:100px; " value="24" class="hours" id="hours_" name="hours[]" onKeyUp="fun_get_weight(this.id)"/>
                                                                            <input type="text"   style="height:33px; width:100px; " class="qunt" id="qunt_" name="qunt[]" onKeyUp="fun_get_weight(this.id)" />
                                                                            <input type="text"   style="height:33px; width:100px; " class="eff" id="eff_" name="eff[]" />
                                                                    </div>
                                                                    <?php 
                                                                }
                                                                ?>
                                                                <div class="form-group">
                                                                        <span id="writerootjr2"></span>
                                                                        <input type="button" id="moreFields" class="btn btn-warning pull-left" style="width:80px" onclick="javascript:moreFields1('readrootjr2','writerootjr2');" value="Add" /> 
                                                                </div>   
                                                                <br />
                                                                <br />
                                                                <br />
                                                                <div id="readrootjr2" style="display:none;  margin-bottom:20px; margin-top:10px;">
                                                                        <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
                                                                            <i class="nav-icon i-Close-Window" style="color:white;"></i>
                                                                        </a>
                                                                        <input type="hidden" name="detailsid[]" class="detailsid"  value="0" id="detailsid_">
                                                                        <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_" onKeyUp="fun_get_product(this.id,'goods2_','goods_','get_rate')" />
                                                                        <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />
                                                                        <input type="text"   style="height:33px; width:100px; " value="24" class="hours" id="hours_" name="hours[]"  onKeyUp="fun_get_weight(this.id)" />
                                                                        <input type="text"   style="height:33px; width:100px; " class="qunt" id="qunt_" name="qunt[]" onKeyUp="fun_get_weight(this.id)" />
                                                                        <input type="text"   style="height:33px; width:100px; " class="eff" id="eff_" name="eff[]" />
                                                                </div><!--readrootjr end-->

                                                        
                                                            </div>
                                                            <!------------form close------------>
                                                        </div>			
                                                    </div>
                                                </div>
                                            </div>
                                            <!------------Row 3 close------------> 

                                            <div class="col-md-12" style=" margin-top:50px;"><hr></div>
                                            <div class="col-md-6" >
                                                <label >Status</label>
                                                <select class="form-control" name="status" id="status">
                                                        <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']==''){echo "selected";}}?> value="" >Select</option>
                                                        <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Working'){echo "selected";}}?> >Working</option>
                                                        <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Under Maintenance'){echo "selected";}}?>>Under Maintenance</option>
                                                        <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Rejected'){echo "selected";}}?>>Rejected</option>
                                                </select>
                                            </div> 

                                            <div class="col-md-6">
                                                <label >Show / Hide in Product entry List</label>
                                                <select class="form-control" name="hide_status" id="hide_status">
                                                        <option  <?php if(isset($res2[0]['hide_status'])){if($res2[0]['hide_status'] == 0){echo "selected";}}?> value="0">Yes</option>
                                                        <option  <?php if(isset($res2[0]['hide_status'])){if($res2[0]['hide_status'] == '1'){echo "selected";}}?> value="1">No</option>
                                                </select>
                                            </div> 
   
   
                                        
                                               
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="machine_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   



<?php $this->load->view('js/machine_js');?>
<script>
    //---------------------------------------getting weight
    function fun_get_weight(id)
    {

        var id2 = id.split("_");
        var id_no=id2[1];
        
        var hours_id = "#hours_".concat(id_no);
        var hours_val=$(hours_id).val();
        
        
        //-------------------------------------------------- houres
        var qunt_id = "#qunt_".concat(id_no);
        var qunt_val=$(qunt_id).val();
        //var pro24=(24)/(+qunt_val);
        //alert(pro24);
        
        
        var eff1=(80/100)*(qunt_val);
        var eff2=eff1.toFixed(0);
        var eff_id = "#eff_".concat(id_no);
        $(eff_id).val(eff2);

    }//function close
</script>