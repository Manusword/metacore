<?php 
  if(isset($res2[0]['receive_date'])){$receive_date=$this->Base->change_date_dmy($res2[0]['receive_date']);}else{$receive_date='';}
  if(isset($res2[0]['expiry_date']) and $res2[0]['expiry_date'] != '0000-00-00'){$expiry_date=$this->Base->change_date_dmy($res2[0]['expiry_date']);}else{$expiry_date='';}
  
  
  $fin_year = $this->Customermodel->get_financial_year_last_bill();
?>  
            
   
           

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Customer Cheque Amount Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top " ></div>
                <div class="row">
                  <div class="col-md-3" id="today_debit_history_list"></div>
                  <div class="col-md-6">
                      <div class="card mb-4 ">
                            <div class="card-body ">
                              <div class="card-title ">Customer Cheque Entry</div>
                                    <div class="form-row">
                                     
                                    <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                    <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                            
                                          
                                       


                                          <div class="col-md-6" style="margin-top:20px">
                                                <label for="exampleInputPassword1">Select Customer</label>
                                                <select class="form-control select2"    id="customer_id">
                                                      <option  <?php if(isset($res2[0]['customer_id'])){if($res2[0]['customer_id']==''){echo "selected";}}?>  value="">Select</option>
                                                            <?Php 
                                                            foreach($cus as $c)
                                                            {
                                                            ?>
                                                                  <option <?php if(isset($res2[0]['customer_id'])){
                                                                  if($res2[0]['customer_id']==$c['id']){
                                                                        echo "selected";
                                                                  }}?> value="<?php echo $c['id'];?>">
                                                                        <?php echo $c['name'];?>
                                                                  </option>
                                                            <?php
                                                            }
                                                            ?>		
                                                </select>
                                          </div> 

                                          <div class="col-md-6" style="margin-top:20px">
                                                <label >Cheque Receive Date</label>
                                                <input type="text" class="form-control"  id="receive_date" required  autocomplete="off" value="<?php if(isset($receive_date))echo $receive_date;?>" >
                                          </div>

                                         

                                          <div class="col-md-4" style="margin-top:20px">
                                                <label >Bank name</label>
                                                <input type="text" class="form-control"  id="bank_name" required  autocomplete="off" value="<?php  if(isset($res2[0]['bank_name']))echo $res2[0]['bank_name'];?>" >
                                          </div>

                                          <div class="col-md-4" style="margin-top:20px">
                                                <label >Account No.</label>
                                                <input type="text" class="form-control"  id="account_no" required  autocomplete="off" value="<?php  if(isset($res2[0]['account_no']))echo $res2[0]['account_no'];?>" >
                                          </div>

                                          <div class="col-md-4" style="margin-top:20px">
                                                <label >IFSC Code</label>
                                                <input type="text" class="form-control"  id="ifsc_code" required  autocomplete="off" value="<?php  if(isset($res2[0]['ifsc_code']))echo $res2[0]['ifsc_code'];?>" >
                                          </div>

                                          <div class="col-md-12" style="margin-top:20px">
                                                <label >Bank Address</label>
                                                <input type="text" class="form-control"  id="bank_address" required  autocomplete="off" value="<?php  if(isset($res2[0]['bank_address']))echo $res2[0]['bank_address'];?>" >
                                          </div>

                                          <div class="col-md-3" style="margin-top:20px">
                                                <label >Cheque No.</label>
                                                <input type="text" class="form-control"  id="cheque_no" required  autocomplete="off" value="<?php  if(isset($res2[0]['cheque_no']))echo $res2[0]['cheque_no'];?>" >
                                          </div>

                                          <div class="col-md-3" style="margin-top:20px">
                                                <label >Authorized Person</label>
                                                <input type="text" class="form-control"  id="authorized_person" required  autocomplete="off" value="<?php  if(isset($res2[0]['authorized_person']))echo $res2[0]['authorized_person'];?>" >
                                          </div>



                                          <div class="col-md-3" style="margin-top:20px">
                                                <label for="exampleInputPassword1">With Amount / Without Amout</label>
                                                <select class="form-control select2"    id="amount_status">
                                                      <option  <?php if(isset($res2[0]['amount_status'])){if($res2[0]['amount_status']==''){echo "selected";}}?>  value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['amount_status'])){if($res2[0]['amount_status']=='With Amount'){echo "selected";}}?>  value="With Amount">With Amount</option>
                                                      <option  <?php if(isset($res2[0]['amount_status'])){if($res2[0]['amount_status']=='Without Amount'){echo "selected";}}?>  value="Without Amount">Without Amount</option>
                                                </select>
                                          </div> 
 

                                        
                                          <div class="col-md-3" style="margin-top:20px">
                                                <label>Amount (Rs.)</label>
                                                <input type="number" class="form-control"   id="cheque_amount"  autocomplete="off" value="<?php  if(isset($res2[0]['cheque_amount']))echo $res2[0]['cheque_amount'];?>">
                                          </div>

                                          <div class="col-md-6" style="margin-top:20px">
                                                <label>Expiry Date if any</label>
                                                <input type="text" class="form-control"  id="expiry_date" required  autocomplete="off" value="<?php if(isset($expiry_date))echo $expiry_date;?>" >
                                          </div>

                                          <div class="col-md-6" style="margin-top:20px">
                                                <label >Remarks</label>
                                                <input type="text" class="form-control"   id="remarks"  autocomplete="off" value="<?php  if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>">
                                          </div>
                                            
                                             
                                            
                                          <div class="col-md-12" style="margin-top:50px;">                            
                                                <div class="box-footer">
                                                      <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-info" id="cheque_save" >Save</button>
                                                      </div>
                                                </div>
                                          </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                  </div>
                  
                    
                </div><!-- end of main-content -->   


<?php $this->load->view('js/customer');?>
            
                                         
              
              
              
    
              
   
            






  