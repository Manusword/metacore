<?php 
  if(isset($res2[0]['entry_date'])){$entry_date=$this->Base->change_date_dmy($res2[0]['entry_date']);}else{$entry_date='';}

  
  $fin_year = $this->Customermodel->get_financial_year_last_bill();
?>  
            
   
           

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Customer Billing Amount</h1>
                </div>
                <div class="separator-breadcrumb border-top " ></div>
                <div class="row">
                  <div class="col-md-3" id="today_debit_history_list"></div>
                  <div class="col-md-6">
                      <div class="card mb-4 ">
                            <div class="card-body ">
                              <div class="card-title ">Customer Invoice Entry</div>
                                    <div class="form-row">
                                     
                                    <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                    <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['cr_dr_id']))echo $res2[0]['cr_dr_id'];?>">
                                            
                                          <div class="col-md-4">
                                                <label >Invoice Date</label>
                                                <input type="text" class="form-control"  id="entry_date" required  autocomplete="off" value="<?php if(isset($entry_date))echo $entry_date;?>" >
                                          </div>

                                          <div class="col-md-4">
                                                <label >Invoice No.</label>
                                                <input type="text" class="form-control"  id="invoice_no" required  autocomplete="off" value="<?php  if(isset($res2[0]['invoice_no']))echo $res2[0]['invoice_no'];?>" >
                                          </div>

                                          <div class="col-md-4">
                                                <label >Financial Year</label>
                                                <input type="text" class="form-control"  id="fin_year" required  autocomplete="off" value="<?php if(isset($fin_year))echo $fin_year;?>" >
                                          </div>


                                          <div class="col-md-12" style="margin-top:20px">
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

                                        
                                            <div class="col-md-12" style="margin-top:20px">
                                                  <label >Amount (Rs.)</label>
                                                  <input type="number" class="form-control"   id="debit_amount"  autocomplete="off" value="<?php  if(isset($res2[0]['debit_amount']))echo $res2[0]['debit_amount'];?>">
                                            </div>

                                            <div class="col-md-12" style="margin-top:20px">
                                                  <label >Remarks</label>
                                                  <input type="text" class="form-control"   id="remarks"  autocomplete="off" value="<?php  if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>">
                                            </div>
                                            
                                          
        
                                        
                                            
                                            
                                            
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-danger" id="debit_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                  </div>
                  
                    
                </div><!-- end of main-content -->   


<?php $this->load->view('js/customer');?>
            
                                         
              
              
              
    
              
   
            






  