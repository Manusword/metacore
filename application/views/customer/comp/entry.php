<?php 
  if(isset($res2[0]['complain_date']) and $res2[0]['complain_date'] != '0000-00-00'){$complain_date=$this->Base->change_date_dmy($res2[0]['complain_date']);}else{$complain_date='';}
  if(isset($res2[0]['tag_date1']) and $res2[0]['tag_date1'] != '0000-00-00'){$tag_date1=$this->Base->change_date_dmy($res2[0]['tag_date1']);}else{$tag_date1='';}
  if(isset($res2[0]['tag_date2']) and $res2[0]['tag_date2'] != '0000-00-00'){$tag_date2=$this->Base->change_date_dmy($res2[0]['tag_date2']);}else{$tag_date2='';}
  if(isset($res2[0]['resolution']) and $res2[0]['resolution'] != '0000-00-00'){$resolution=$this->Base->change_date_dmy($res2[0]['resolution']);}else{$resolution='';}
?>  
            
     
           

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Customer</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Customer Complaint Enter</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['comp_id']))echo $res2[0]['comp_id'];?>">
                                            
                                            <div class="col-md-4">
                                                  <label>Type</label>
                                                    <select class="form-control" id="type">
                                                      <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Complaint'){echo "selected";}?>  value="Complaint">Complaint</option>
                                                      <option  <?php if(isset($res2[0]['type']))if($res2[0]['type']=='Dispute'){echo "selected";}?> value="Dispute">Dispute</option>
                                                    </select>
                                            </div> 

                                            



                                            <div  class="col-md-4">
                                                <label>Complain Date</label>
                                                <input type="text" class="form-control" id="complain_date" value="<?php echo $complain_date;?>">
                                            </div>

                                           

                                            <div  class="col-md-4">
                                                <label  >Customer Name</label>
                                                <select  class="form-control"  style=" width: 100%"  id="customer_name">
                                                        <option value="">Select</option>
                                                        <?Php 
                                                            foreach($customer as $c)
                                                            {
                                                        ?>
                                                            <option <?php if(isset($res2[0]['customer_name'])){if($res2[0]['customer_name']==$c['id']){echo "selected";}}?> value="<?php echo $c['id'];?>">
                                                                <?php echo $c['name'];?>
                                                            </option>
                                                        <?php
                                                            }
                                                        ?>		
                                                </select>
                                            </div>

                                          
                                        
                                            <div  class="col-md-3  mt-4">
                                                <label>Qty</label>
                                                <input type="number" class="form-control" id="defect_qty" value="<?php if(isset($res2[0]['defect_qty']))echo $res2[0]['defect_qty'];?>">
                                            </div>

                                            <div  class="col-md-3  mt-4">
                                                <label>Amount (Rs)</label>
                                                <input type="number" class="form-control" id="defect_amount" value="<?php if(isset($res2[0]['defect_amount']))echo $res2[0]['defect_amount'];?>">
                                            </div>

                                            <div  class="col-md-3  mt-4">
                                                <label>Unit</label>
                                                <input type="text" class="form-control" id="defect_unit" value="<?php if(isset($res2[0]['defect_unit'])){echo $res2[0]['defect_unit'];}else{echo "kgs.";}?>">
                                            </div>
                                            
                                            
                                            <div  class="col-md-3 mt-4">
                                                <label>No of Coils</label>
                                                <input type="number" class="form-control" id="defect_bobbin" value="<?php if(isset($res2[0]['defect_bobbin']))echo $res2[0]['defect_bobbin'];?>">
                                            </div>

                                            
                                            

                                            <div class="col-md-12">
                                                <hr>
                                                <h4>Tag Details</h4>
                                            </div>

                                            <div  class="col-md-2  mt-4">
                                                <label>Tag 1 : Type of wire</label>
                                                <input type="text" class="form-control" id="type_of_wire1" value="<?php if(isset($res2[0]['type_of_wire1']))echo $res2[0]['type_of_wire1'];?>">
                                            </div>

                                            <div  class="col-md-2  mt-4">
                                                <label>Size</label>
                                                <input type="text" class="form-control" id="tag_size1" value="<?php if(isset($res2[0]['tag_size1']))echo $res2[0]['tag_size1'];?>">
                                            </div>

                                            <div  class="col-md-2  mt-4">
                                                <label>Grade</label>
                                                <input type="text" class="form-control" id="tag_grade1" value="<?php if(isset($res2[0]['tag_grade1']))echo $res2[0]['tag_grade1'];?>">
                                            </div>
                                            

                                            <div  class="col-md-2  mt-4">
                                                <label>Coil No</label>
                                                <input type="text" class="form-control" id="tag_coil_no1" value="<?php if(isset($res2[0]['tag_coil_no1']))echo $res2[0]['tag_coil_no1'];?>">
                                            </div>

                                            <div  class="col-md-2  mt-4">
                                                <label>Date</label>
                                                <input type="text" class="form-control" id="tag_date1" value="<?php echo $tag_date1;?>">
                                            </div>

                                            <div  class="col-md-2  mt-4">
                                                <label>Shift</label>
                                                <input type="text" class="form-control" id="tag_shift1" value="<?php if(isset($res2[0]['tag_shift1']))echo $res2[0]['tag_shift1'];?>">
                                            </div>


                                            <div  class="col-md-2  mt-4">
                                                <label>Tag 2 : Type of wire</label>
                                                <input type="text" class="form-control" id="type_of_wire2" value="<?php if(isset($res2[0]['type_of_wire2']))echo $res2[0]['type_of_wire2'];?>">
                                            </div>

                                            <div  class="col-md-2  mt-4">
                                                <label>Size</label>
                                                <input type="text" class="form-control" id="tag_size2" value="<?php if(isset($res2[0]['tag_size2']))echo $res2[0]['tag_size2'];?>">
                                            </div>

                                            <div  class="col-md-2  mt-4">
                                                <label>Grade</label>
                                                <input type="text" class="form-control" id="tag_grade2" value="<?php if(isset($res2[0]['tag_grade2']))echo $res2[0]['tag_grade2'];?>">
                                            </div>
                                            

                                            <div  class="col-md-2  mt-4">
                                                <label>Coil No</label>
                                                <input type="text" class="form-control" id="tag_coil_no2" value="<?php if(isset($res2[0]['tag_coil_no2']))echo $res2[0]['tag_coil_no2'];?>">
                                            </div>

                                            <div  class="col-md-2  mt-4">
                                                <label>Date</label>
                                                <input type="text" class="form-control" id="tag_date2" value="<?php echo $tag_date2;?>">
                                            </div>

                                            <div  class="col-md-2  mt-4">
                                                <label>Shift</label>
                                                <input type="text" class="form-control" id="tag_shift2" value="<?php if(isset($res2[0]['tag_shift2']))echo $res2[0]['tag_shift2'];?>">
                                            </div>



                                            <div  class="col-md-6 mt-4">
                                                <label  >Description of Problem</label>
                                                <textarea class="form-control" id="desc_problem"><?php if(isset($res2[0]['desc_problem']))echo $res2[0]['desc_problem'];?></textarea>
                                            </div>

                                            <div  class="col-md-6 mt-4">
                                                <label  >Scope</label>
                                                <textarea class="form-control" id="scope"><?php if(isset($res2[0]['scope']))echo $res2[0]['scope'];?></textarea>
                                            </div>










                                            <div class="col-md-12"><hr></div>

                                            <div  class="col-md-2 mt-4">
                                                <label  >Complaint By</label>
                                                <input type="text" class="form-control" id="comp_by" value="<?php if(isset($res2[0]['comp_by']))echo $res2[0]['comp_by'];?>">
                                            </div>
                                            <div  class="col-md-2 mt-4">
                                                <label  >Receive By</label>
                                                <input type="text" class="form-control" id="rece_by" value="<?php if(isset($res2[0]['rece_by']))echo $res2[0]['rece_by'];?>">
                                            </div>

                                            
                                            
                                           

                                            <div class="col-md-2 mt-4">
                                                  <label>Priority</label>
                                                    <select class="form-control" id="priority">
                                                      <option  <?php if(isset($res2[0]['priority']) && $res2[0]['priority'] == "")echo "selected";?>  value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['priority']) && $res2[0]['priority'] == "Low")echo "selected";?>  value="Low">Low</option>
                                                      <option  <?php if(isset($res2[0]['priority']) && $res2[0]['priority'] == "Medium")echo "selected";?> value="Medium">Medium</option>
                                                      <option  <?php if(isset($res2[0]['priority']) && $res2[0]['priority'] == "High")echo "selected";?> value="High">High</option>
                                                    </select>
                                            </div> 

                                            <div class="col-md-2 mt-4">
                                                  <label>Department</label>
                                                    <select class="form-control" id="department">
                                                      <option  <?php if(isset($res2[0]['department']))if($res2[0]['department']==''){echo "selected";}?>  value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['department']))if($res2[0]['department']=='Production'){echo "selected";}?>  value="Production">Production</option>
                                                      <option  <?php if(isset($res2[0]['department']))if($res2[0]['department']=='Quality'){echo "selected";}?> value="Quality">Quality</option>
                                                      <option  <?php if(isset($res2[0]['department']))if($res2[0]['department']=='Sales'){echo "selected";}?> value="Sales">Sales</option>
                                                      <option  <?php if(isset($res2[0]['department']))if($res2[0]['department']=='Billing'){echo "selected";}?> value="Billing">Billing</option>
                                                    </select>
                                            </div> 

                                           


                                            <div  class="col-md-4 mt-4">
                                                <label  >Assigned To</label>
                                                <input type="text" class="form-control" id="assigned_to" value="<?php if(isset($res2[0]['assigned_to']))echo $res2[0]['assigned_to'];?>">
                                            </div>

                                          
                                            <div  class="col-md-12 mt-4">
                                                <label  >Root Cause</label>
                                                <textarea class="form-control" id="root_cause"><?php if(isset($res2[0]['root_cause']))echo $res2[0]['root_cause'];?></textarea>
                                            </div>

                                            <div  class="col-md-4 mt-4">
                                                <label  >Corrective Action</label>
                                                <textarea class="form-control" id="corrective_action"><?php if(isset($res2[0]['corrective_action']))echo $res2[0]['corrective_action'];?></textarea>
                                            </div>

                                            <div  class="col-md-4 mt-4">
                                                <label  >Preventive Action</label>
                                                <textarea class="form-control" id="preventive_action"><?php if(isset($res2[0]['preventive_action']))echo $res2[0]['preventive_action'];?></textarea>
                                            </div>

                                            <div  class="col-md-4 mt-4">
                                                <label  >Verification</label>
                                                <textarea class="form-control" id="verification"><?php if(isset($res2[0]['verification']))echo $res2[0]['verification'];?></textarea>
                                            </div>





                                            <div class="col-md-12"><hr></div>


                                           
                                            
                                            <div class="col-md-3 mt-4">
                                                  <label>Status</label>
                                                    <select class="form-control" id="status">
                                                      <option  <?php if(isset($res2[0]['status']))if($res2[0]['status']==''){echo "selected";}?>  value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['status']))if($res2[0]['status']=='Open'){echo "selected";}?>  value="Open">Open</option>
                                                      <option  <?php if(isset($res2[0]['status']))if($res2[0]['status']=='In Progress'){echo "selected";}?>  value="In Progress">In Progress</option>
                                                        <option  <?php if(isset($res2[0]['status']))if($res2[0]['status']=='Resolved'){echo "selected";}?> value="Resolved">Resolved</option>
                                                    </select>
                                            </div> 

                                            <div  class="col-md-3 mt-4">
                                                <label  >Resolution Date</label>
                                                <input type="text" class="form-control" id="resolution" value="<?php echo $resolution;?>">
                                            </div>

                                            <div class="col-md-3 mt-4">
                                                  <label>Follow-up Required</label>
                                                    <select class="form-control" id="followup_req">
                                                      <option  <?php if(isset($res2[0]['followup_req']))if($res2[0]['followup_req']==''){echo "selected";}?>  value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['followup_req']))if($res2[0]['followup_req']=='Yes'){echo "selected";}?>  value="Yes">Yes</option>
                                                      <option  <?php if(isset($res2[0]['followup_req']))if($res2[0]['followup_req']=='No'){echo "selected";}?> value="No">No</option>
                                                    </select>
                                            </div> 

                                            <div  class="col-md-3 mt-4">
                                                <label  >Remarks</label>
                                                <input type="text" class="form-control" id="remarks" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>">
                                            </div>



                                            <div class="col-md-12">
                                                  <label>Upload Multiple Photo</label>
                                                  <input type="file" class="form-control" name="img1[]" id="img1" multiple>
                                            </div>

                                            <div class="col-md-12">
                                                <?php
                                                if (isset($res2[0]['comp_id'])) {
                                                    $customer_name = $res2[0]['customer_name'];
                                                    $comp_id = $res2[0]['comp_id'];
                                                    $this->Customermodel->get_all_cust_comp_photo_with_comp_id($customer_name,$comp_id);
                                                }
                                                ?>
                                            </div>

                                                        
                                           
                                           
                                            
                                            
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="complaint_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   


<?php $this->load->view('js/customer');?>
            
                                         
              
              
              
    
              
   
            






  