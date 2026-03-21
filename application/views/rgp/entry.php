        

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>RGP</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New RGP</div>
                                    <div class="form-row">
                                      
                                      <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                      <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['product_id']))echo $res2[0]['product_id'];?>">
                                
                                                             
                                        <?php 
                                          if(isset($res2[0]['entry_date']))
                                          {
                                            $po_date=$res2[0]['entry_date'];
                                            $po_date2=explode('-',$po_date);
                                            $entry_date1=$po_date2[2].'-'.$po_date2[1].'-'.$po_date2[0];
											                    ?>
                                            <div class="col-md-4">
                                                <label for="exampleInputPassword1">Date <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" readonly  id="save_date" name="save_date"  required value="<?php echo $entry_date1;?>"  >
                                            </div>
                                        <?php									
									                        }
                                          else
                                          {
                                            $entry_date1=date('d-m-Y');
                                            ?>
                                            <div class="col-md-4">
                                                <label for="exampleInputPassword1">Date <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control"  id="save_date" name="save_date"  required value="<?php echo $entry_date1;?>"  >
                                            </div>
                                        <?php
									                         }
                                        ?>





<div class="col-md-4">
                                           <label for="exampleInputPassword1">For <span style="color:red;">*</span></label>
                                               <select  class="form-control"  style=" width: 100%" name="nrgp_for" id="nrgp_for" onchange="get_list_for_rgp_nrgp(this.value)">
                                                  <option  <?php if(isset($res2[0]['nrgp_for'])){if($res2[0]['nrgp_for']==''){echo "selected";}}?>  value="">Select</option>
                                                  <option <?php if(isset($res2[0]['nrgp_for'])){if($res2[0]['nrgp_for']=='Supplier'){echo "selected";}}?> value="Supplier">Supplier</option>
                                                  <option <?php if(isset($res2[0]['nrgp_for'])){if($res2[0]['nrgp_for']=='Customer'){echo "selected";}}?> value="Customer">Customer</option>
                                               </select>
                                        </div>
                                        
                                      

                                        <?php 
                                        if(isset($res2[0]['nrgp_for']) and $res2[0]['nrgp_for']=='Supplier')
                                        {
                                          ?>
                                          <div class="col-md-4">
                                           <label for="exampleInputPassword1">Select Name From Supplier <span style="color:red;">*</span></label>
                                               <select  class="js-states form-control"  style=" width: 100%" name="job_work_supplier_id" id="job_work_supplier_id" >
                                                    <option  <?php if(isset($res2[0]['supplier_id'])){if($res2[0]['supplier_id']==''){echo "selected";}}?>  value="">Select From Supplier </option>
                                                      <?Php 
                                                        foreach($supplier as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['job_work_supplier_id'])){if($res2[0]['job_work_supplier_id']==$c['id'] and $res2[0]['nrgp_for']=='Supplier'){echo "selected";}}?> value="<?php echo $c['id'];?>">
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>
                                               </select>
                                        </div>
                                        <?php
                                        }
                                        elseif(isset($res2[0]['nrgp_for']) and $res2[0]['nrgp_for']=='Customer')
                                        {
                                          ?>
                                          <div class="col-md-4">
                                           <label for="exampleInputPassword1">Select Name From Customer <span style="color:red;">*</span></label>
                                               <select  class="js-states form-control"  style=" width: 100%" name="job_work_supplier_id" id="job_work_supplier_id" >
                                                    <option  <?php if(isset($res2[0]['supplier_id'])){if($res2[0]['supplier_id']==''){echo "selected";}}?>  value="">Select From Customer </option>
                                                    <?Php 
                                                        foreach($customer as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['job_work_supplier_id'])){if($res2[0]['job_work_supplier_id']==$c['id'] and $res2[0]['nrgp_for']=='Customer'){echo "selected";}}?> value="<?php echo $c['id'];?>">
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>	
                                               </select>
                                        </div>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                          <div class="col-md-4">
                                            <label for="exampleInputPassword1">Select Name <span style="color:red;">*</span></label>
                                                <select  class="js-states form-control"  style=" width: 100%"  id="job_work_supplier_id" >
                                                    <option  value="">Select</option>
                                                </select>
                                          </div>
                                        <?php
                                        } 
                                        /*
                                        
                                        <div class="col-md-4">
                                           <label for="exampleInputPassword1">Select Job Work Supplier <span style="color:red;">*</span></label>
                                               <select  class="js-states form-control"  style=" width: 100%" name="job_work_supplier_id" id="job_work_supplier_id" >
                                                    <option  <?php if(isset($res2[0]['supplier_id'])){if($res2[0]['supplier_id']==''){echo "selected";}}?>  value="">Select</option>
                                                      <?Php 
                                                        foreach($supplier as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['job_work_supplier_id'])){if($res2[0]['job_work_supplier_id']==$c['id'] and $res2[0]['nrgp_for']=='Supplier'){echo "selected";}}?> value="<?php echo $c['id'];?>">
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>
                                                     <option disabled> Customer List</option> 
                                                      
                                                       <?Php 
                                                        foreach($customer as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['job_work_supplier_id'])){if($res2[0]['job_work_supplier_id']==$c['id'] and $res2[0]['nrgp_for']=='Customer'){echo "selected";}}?> value="<?php echo $c['id'];?>">
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>	
                                                      
                                                      		
                                               </select>
                                        </div>
                                        */
                                        ?>


   
   
   
    <!------------Row 3 start------------>
    <div class="col-md-12"    style=" margin-top:50px;">
				<div class="row-fluid">
					<div class="span12" >
						<div class="widget-box">
							
                            <!------------From start------------>
                            <div class="widget-content nopadding">
	


<div style=" margin-left:40px;">
     <input class="form-control-new" readonly  value="Description" type="text" style=" height:30px; width:200px; border:none; background-color:#f7f7f5; margin-left:5px;" />
     
     <input class="form-control-new" readonly value="Unit" type="text" style=" height:30px; width:100px; border:none; background-color:#f7f7f5;" />
     <input class="form-control-new" readonly  value="Quantity"  type="text" style=" height:30px; width:100px;border:none; background-color:#f7f7f5;" />
     <input class="form-control-new" readonly  value="Remarks"  type="text" style=" height:30px; width:200px;border:none; background-color:#f7f7f5;" />
     

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
		$product2=$this->Mymodel->select_where('product',$where);
	?>
	
    <div id="readrootjr<?php echo $k;?>" style="display:;  margin-bottom:20px; margin-top:10px;">
             <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="delete_item(this.id);this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_<?php echo $k;?>">
                <span class="fa fa-trash"></span>
            </a>
            <input type="hidden" name="rgpdetails_id[]" class="rgpdetails_id"  value="<?php echo $w['rgp_details_id'];?>" id="rgpdetails_id_<?php echo $k;?>">
            <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_<?php echo $k;?>" onKeyUp="fun_auto(this.id)" value="<?php echo $product2[0]['name'];?>" />
            <input type="hidden"   style="height:33px;   width:40px; " id="goods_<?php echo $k;?>"  name="goods[]" class="goods" placeholder="P.id"  value="<?php echo $w['product_id'];?>"/>
          
          
          
            <select  style="height:33px;   width:100px; " id="unitname_<?php echo $k;?>" name="unitname[]" class="unitname">
                  <option value="">Select</option>
                  <?Php 
                    foreach($unit as $c)
                    {
                  ?>
                    <option <?php if(isset($w['unitname_id'])){if($w['unitname_id']==$c['unit_id']){echo "selected";}}?>  value="<?php echo $c['unit_id'];?>">
                        <?php echo $c['name'];?>
                    </option>
                  <?php
                    }
                  ?>
             </select>
                    
            <input type="text"   style="height:33px; width:100px; " class="qunt" id="qunt_<?php echo $k;?>" name="qunt[]" value="<?php echo $w['qunt'];?>" />
            <input type="text"   style="height:33px; width:200px; " class="rowremrks" id="rowremrks_<?php echo $k;?>" name="rowremrks[]" value="<?php echo $w['rowremrks'];?>" />
    
    </div>

    <?php
	$k++;
	}
}
else
{
	?>
     

 
 
<div id="readrootjr101" style="display:;  margin-bottom:20px; margin-top:10px;">
         <a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="delete_item(this.id);this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
        	<span class="fa fa-trash"></span>
        </a>
        <input type="hidden" name="rgpdetails_id[]" class="rgpdetails_id"  value="0" id="rgpdetails_id_">
        <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_" onKeyUp="fun_auto(this.id)" />
        <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />
        <select  style="height:33px;   width:100px; " id="unitname_" name="unitname[]" class="unitname">
              <option value="">Select</option>
              <?Php 
                foreach($unit as $c)
                {
              ?>
                <option  value="<?php echo $c['unit_id'];?>">
                    <?php echo $c['name'];?>
                </option>
              <?php
                }
              ?>
         </select>
                
        <input type="text"   style="height:33px; width:100px; " class="qunt" id="qunt_" name="qunt[]" />
        <input type="text"   style="height:33px; width:200px; " class="rowremrks" id="rowremrks_" name="rowremrks[]" />

</div>

<?php 
}
?>



<div class="form-group">
		<span id="writerootjr"></span>
		<input type="button" id="moreFields" class="btn btn-warning pull-left" style="width:80px" onclick="javascript:moreFields1();" value="Add" /> 
</div>   

<br />
<br />
<br />



<div id="readrootjr" style="display:none;  margin-bottom:20px; margin-top:10px;">
		<a style="margin-top:3px;" class="btn btn-danger pull-left"  onclick="delete_item(this.id);this.parentNode.parentNode.removeChild(this.parentNode); " id="closebutton_">
        	<span class="fa fa-trash"></span>
    </a>
        
        <input type="hidden" name="rgpdetails_id[]" class="rgpdetails_id"  value="0" id="rgpdetails_id_">
        <input type="text"   style="height:33px;   width:200px; margin-left:5px; " class="goods2" id="goods2_" onKeyUp="fun_auto(this.id)" />
        <input type="hidden"   style="height:33px;   width:40px; " id="goods_"  name="goods[]" class="goods" placeholder="P.id"  />
        <select  style="height:33px;   width:100px; " id="unitname_" name="unitname[]" class="unitname">
              <option value="">Select</option>
              <?Php 
                foreach($unit as $c)
                {
              ?>
                <option  value="<?php echo $c['unit_id'];?>">
                    <?php echo $c['name'];?>
                </option>
              <?php
                }
              ?>
         </select>
                
        <input type="text"   style="height:33px; width:100px; " class="qunt" id="qunt_" name="qunt[]" />
        <input type="text"   style="height:33px; width:200px; " class="rowremrks" id="rowremrks_" name="rowremrks[]" />


</div><!--readrootjr end-->

    					
                        
                        
                        
                        
                        
							</div>
						<!------------form close------------>
                        </div>			
					</div>
				</div>
              </div>
			<!------------Row 3 close------------>  
   
   
    									
   
   
                                 
      <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
          		<div style=" height:1px; width:100%; background-color:#74767d"></div>
            </div>
            
            
            
 
           
             <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">   
            			<div class="panel-body">
                                       
                                         <div class="col-md-12" style="height:80px;">
                                            <label  >Comment </label>
                                            <input type="text" class="form-control" id="comment" name="comment" value="<?php if(isset($res2[0]['comment'])){echo $res2[0]['comment'];}?>">
                                        </div>
                                        
                                        
                                        <div class="col-md-12" style="height:80px;">
                                            <label  >Sending Through  <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="sending" name="sending" value="<?php if(isset($res2[0]['sending'])){echo $res2[0]['sending'];}?>">
                                        </div>
                                         
                                         
                                         <div class="col-md-12" style="height:80px;">
                                            <label  >Requested By  <span style="color:red;">*</span></label>
                                            <input type="text" class="form-control" id="request_by" name="request_by" value="<?php if(isset($res2[0]['request_by'])){echo $res2[0]['request_by'];}?>">
                                        </div>
                                        
                                        
                                          <div class="col-md-12" style="height:80px;">
                                            <label  >Received By</label>
                                            <input type="text" class="form-control" id="received_by" name="received_by" value="<?php if(isset($res2[0]['received_by'])){echo $res2[0]['received_by'];}?>">
                                        </div>
                                        
                                        
                                  
                                        
                                     
                                </div>
                           </div>   
                           
                           


                           
                           <div class="col-md-12" style="margin-top:30px; margin-bottom:30px;">     
          		<div style=" height:1px; width:100%; background-color:#74767d"></div>
            </div>
                
            
            
             <div class="col-md-12" >
                <div class="col-sm-4"></div>
                
                <div class="col-sm-1">
                	<input type="checkbox"  id="chk" name="checkbox[]" class="form-control" >
                </div>
                <div class="col-sm-2">Want to save</div>
                
                <div class="col-sm-4">
                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;">Please Wait...</span>
                      <?php
                        // $emp_id=$this->session->userdata('emp_id');
                        // //---------for approved
                        // $where=" emp_id='$emp_id' and access_name='8' ";
                        // $out=$this->Mymodel->select_where('emp_access',$where);
                        
                        // //---------for edit
                        // $where=" emp_id='$emp_id' and access_name='9' ";
                        // $out2=$this->Mymodel->select_where('emp_access',$where);

                        // if(!empty($res2[0]['stage']) and $res2[0]['stage']==1)
                        // {
                        //   if(!empty($out) and $out[0]['emp_access']>0)
                        //   {
                      ?>
							 
                      <button type="button" class="btn btn-danger" id="reject" style=" margin-left:20px;" >Reject</button>
                      <button type="button" class="btn btn-success" id="save" style=" margin-left:20px;" >Approved</button>
                      <?php
								    //       }
							      //     }
                    //   elseif(!empty($res2[0]['stage']) and $res2[0]['stage']==2)
                    //   {
                    //     if(!empty($out2) and $out2[0]['emp_access']>0)
                    //     {
                    //   ?>
                    //     <button type="button" class="btn btn-success" id="save" style=" margin-left:20px;" >
                    //       Update Only Received By
                    //     </button>
                    //   <?php
                    //     }
                    //   }
                    //   else
                    //   {
                    //   ?>
                    //   <button type="button" class="btn btn-success" id="save" style=" margin-left:20px;" >
                    //     Save
                    //   </button>
                    // <?php
                    // }
                    ?>
							      
                  </div>
                </div>
            </div>
            
   
  



















                                        
                                         
                                            
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="product_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/product_js');?>


