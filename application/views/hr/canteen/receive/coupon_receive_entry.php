<?php 
    $loginId =$this->session->userdata('login_emp_id');
   if(!empty($res2[0]['receive_date']) and $res2[0]['receive_date']!='0000-00-00'){$receive_date=$this->Base->change_date_ymd($res2[0]['receive_date']);}else{$receive_date='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Canteen Coupon Receive</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-5">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Coupon Receive</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden"  id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                              
                                            
                                            <div class="col-md-12" style="margin-top:10px">
                                                <label>Receive Date</label>
                                                <input type="date" class="form-control"  id="receive_date" required  autocomplete="off" value="<?php if(isset($receive_date))echo $receive_date;?>" >
                                            </div>
                                            
                                             <div class="col-md-6" style="margin-top:10px">
                                                  <label>Breakfast Coupon</label>
                                                  <input type="text" class="form-control"  id="breakfast_coupon_no" required  autocomplete="off" value="<?php if(isset($res2[0]['breakfast_coupon_no']))echo $res2[0]['breakfast_coupon_no'];?>" onkeyup="get_amt()" >
                                            </div>

                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label style="color:red">Breakfast Coupon Amount</label>
                                                  <input type="text" class="form-control" readonly id="breakfast_coupon_amt" required  autocomplete="off" value="<?php if(isset($res2[0]['breakfast_coupon_amt']))echo $res2[0]['breakfast_coupon_amt'];?>" >
                                            </div>
                                            
                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label>Lunch Coupon</label>
                                                  <input type="text" class="form-control"  id="lunch_coupon_no" required  autocomplete="off" value="<?php if(isset($res2[0]['lunch_coupon_no']))echo $res2[0]['lunch_coupon_no'];?>" onkeyup="get_amt()">
                                            </div>

                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label style="color:red">Lunch Coupon Amount</label>
                                                  <input type="text" class="form-control" readonly id="lunch_coupon_amt" required  autocomplete="off" value="<?php if(isset($res2[0]['lunch_coupon_amt']))echo $res2[0]['lunch_coupon_amt'];?>" >
                                            </div>


                                             <div class="col-md-6" style="margin-top:10px">
                                                  <label>Dinner Coupon</label>
                                                  <input type="text" class="form-control"  id="dinner_coupon_no" required  autocomplete="off" value="<?php if(isset($res2[0]['dinner_coupon_no']))echo $res2[0]['dinner_coupon_no'];?>" onkeyup="get_amt()">
                                            </div>

                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label style="color:red">Dinner Coupon Amount</label>
                                                  <input type="text" class="form-control" readonly id="dinner_coupon_amt" required  autocomplete="off" value="<?php if(isset($res2[0]['dinner_coupon_amt']))echo $res2[0]['dinner_coupon_amt'];?>" >
                                            </div>


                                            
                                           
                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label style="color:red">Total Receive Coupon</label>
                                                  <input type="text" class="form-control" readonly id="total_issue_coupon" required  autocomplete="off" value="<?php if(isset($res2[0]['total_coupon']))echo $res2[0]['total_coupon'];?>" >
                                            </div>

                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label style="color:red">Total Coupon Amount</label>
                                                  <input type="text" class="form-control" readonly id="total_coupon_amt" required  autocomplete="off" value="<?php if(isset($res2[0]['total_amt']))echo $res2[0]['total_amt'];?>" >
                                            </div>

                                             <div class="col-md-12" style="margin-top:10px">
                                                  <label >Remarks</label>
                                                  <input type="text" class="form-control"   id="remarks" required  autocomplete="off" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>" >
                                            </div>
                                     
                                                            
                                          
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="emp_coupon_receive_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>

                 
                    
          </div><!-- end of main-content -->   




        
   

    

<?php $this->load->view('js/hr_js');?>

<script>


  function get_amt(){
      let lunch_coupon_no = (+$('#lunch_coupon_no').val());
      let breakfast_coupon_no = (+$('#breakfast_coupon_no').val());
      let dinner_coupon_no = (+$('#dinner_coupon_no').val());

      let dinner_amt = dinner_coupon_no*25;
      let lunch_amt = lunch_coupon_no*25;
      let breakfast_amt = breakfast_coupon_no*7.5;
      
      let total_amt = dinner_amt+lunch_amt+breakfast_amt;
      let total_issue_coupon = dinner_coupon_no+lunch_coupon_no+breakfast_coupon_no

      $('#dinner_coupon_amt').val(dinner_amt)
      $('#lunch_coupon_amt').val(lunch_amt)
      $('#breakfast_coupon_amt').val(breakfast_amt)
      $('#total_coupon_amt').val(total_amt)
      $('#total_issue_coupon').val(total_issue_coupon)
  }//fun


</script>

