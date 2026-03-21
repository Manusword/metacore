<?php 
    $loginId =$this->session->userdata('login_emp_id');
   if(!empty($res2[0]['issue_date']) and $res2[0]['issue_date']!='0000-00-00'){$issue_date=$this->Base->change_date_ymd($res2[0]['issue_date']);}else{$issue_date='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Canteen Coupon Issue</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-5">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Coupon Issue</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden"  id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                              
                                            
                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label>Issue Date</label>
                                                <input type="date" class="form-control"  id="issue_date" required  autocomplete="off" value="<?php if(isset($issue_date))echo $issue_date;?>" >
                                            </div>
                                            
                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label>Code ?</label>
                                                  <select class="form-control"   id="type">
                                                    <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Yes'){echo "selected";}}?> >Yes</option>
                                                    <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='No'){echo "selected";}}?> >No</option> 
                                                  </select>
                                            </div>

                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label>Full Charge</label>
                                                  <select class="form-control"   id="fullCharge" onchange="get_amt()" >
                                                      <option  <?php if(isset($res2[0]['fullCharge'])){if($res2[0]['fullCharge']=='No'){echo "selected";}}?> >No</option> 
                                                      <option  <?php if(isset($res2[0]['fullCharge'])){if($res2[0]['fullCharge']=='Yes'){echo "selected";}}?> >Yes</option>
                                                  </select>
                                            </div>
                                           
                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label >Emp Code</label>
                                                    <input type="text" class="form-control"  id="emp_code" onKeyUp="op_search(this.id)" required  autocomplete="off"  value="<?php if(isset($res2[0]['emp_code']))echo $res2[0]['emp_code'];?>" onchange="get_emp_basic_data(this.value)" >
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label>Name</label>
                                                  <input type="text" class="form-control" readonly  id="emp_name" required  autocomplete="off" value="<?php if(isset($res2[0]['first_name']))echo $res2[0]['first_name'].' '.$res2[0]['last_name'];?>" >
                                            </div>


                                             <div class="col-md-3" style="margin-top:10px">
                                                  <label>Father Name</label>
                                                  <input type="text" class="form-control" readonly id="father_name" required  autocomplete="off" value="<?php if(isset($res2[0]['father_name']))echo $res2[0]['father_name'];?>" >
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label>Mobile</label>
                                                  <input type="text" class="form-control" readonly id="mob" required  autocomplete="off" value="<?php if(isset($res2[0]['mob']))echo $res2[0]['mob'];?>" >
                                            </div>

                                             <div class="col-md-6" style="margin-top:10px">
                                                  <label>Dept.</label>
                                                 <select class="form-control"   id="department_id">
                                                    <option  <?php if(isset($res2[0]['department_id'])){if($res2[0]['department_id']==''){echo "selected";}}?>  value="">Select</option>
                                                      <?Php 
                                                        foreach($dept as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['department_id'])){if($res2[0]['department_id']==$c['department_id']){echo "selected";}}?> value="<?php echo $c['department_id'];?>" >
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>		
                                              </select>
                                            </div>

                                            
                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label>Desi.</label>
                                                  <select class="form-control"   id="role_id">
                                                    <option <?php if(isset($res2[0]['role_id'])){if($res2[0]['role_id']==''){echo "selected";}}?>  value="">Select</option>
                                                      <?Php 
                                                        foreach($role as $c)
                                                        {
                                                      ?>
                                                        <option <?php if(isset($res2[0]['role_in_department'])){if($res2[0]['role_in_department']==$c['role_id']){echo "selected";}}?> value="<?php echo $c['role_id'];?>" >
                                                            <?php echo $c['name'];?>
                                                        </option>
                                                      <?php
                                                        }
                                                      ?>		
                                              </select>
                                            </div>

                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label style="color:blue">Other Name</label>
                                                  <input type="text" class="form-control"   id="other_name" required  autocomplete="off" value="<?php if(isset($res2[0]['other_name']))echo $res2[0]['other_name'];?>" >
                                            </div>
                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label style="color:blue">Dept.</label>
                                                  <input type="text" class="form-control"   id="other_dept" required  autocomplete="off" value="<?php if(isset($res2[0]['other_dept']))echo $res2[0]['other_dept'];?>" >
                                            </div>
                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label style="color:blue">Referance Person</label>
                                                  <input type="text" class="form-control"   id="other_ref" required  autocomplete="off" value="<?php if(isset($res2[0]['other_ref']))echo $res2[0]['other_ref'];?>" >
                                            </div>

                                            
                                            

                                            




                                             <div class="col-md-4" style="margin-top:10px">
                                                  <label>Breakfast Coupon</label>
                                                  <input type="text" class="form-control"  id="breakfast_coupon_no" required  autocomplete="off" value="<?php if(isset($res2[0]['breakfast_coupon_no']))echo $res2[0]['breakfast_coupon_no'];?>" onkeyup="get_amt()" >
                                            </div>


                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label>Lunch Coupon</label>
                                                  <input type="text" class="form-control"  id="lunch_coupon_no" required  autocomplete="off" value="<?php if(isset($res2[0]['lunch_coupon_no']))echo $res2[0]['lunch_coupon_no'];?>" onkeyup="get_amt()">
                                            </div>

                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label>Dinner Coupon</label>
                                                  <input type="text" class="form-control"  id="dinner_coupon_no" required  autocomplete="off" value="<?php if(isset($res2[0]['dinner_coupon_no']))echo $res2[0]['dinner_coupon_no'];?>" onkeyup="get_amt()">
                                            </div>





                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label style="color:red">Breakfast Coupon Amount</label>
                                                  <input type="text" class="form-control" readonly id="breakfast_coupon_amt" required  autocomplete="off" value="<?php if(isset($res2[0]['breakfast_coupon_amt']))echo $res2[0]['breakfast_coupon_amt'];?>" >
                                            </div>

                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label style="color:red">Lunch Coupon Amount</label>
                                                  <input type="text" class="form-control" readonly id="lunch_coupon_amt" required  autocomplete="off" value="<?php if(isset($res2[0]['lunch_coupon_amt']))echo $res2[0]['lunch_coupon_amt'];?>" >
                                            </div>


                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label style="color:red">Dinner Coupon Amount</label>
                                                  <input type="text" class="form-control" readonly id="dinner_coupon_amt" required  autocomplete="off" value="<?php if(isset($res2[0]['dinner_coupon_amt']))echo $res2[0]['dinner_coupon_amt'];?>" >
                                            </div>



                                           
                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label style="color:red">Total issue Coupon</label>
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
                                                      <button type="button" class="btn btn-success" id="emp_coupon_issue_save" >Save</button>
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
   
      let breakfast_coupon_no = (+$('#breakfast_coupon_no').val());
      let lunch_coupon_no = (+$('#lunch_coupon_no').val());
      let dinner_coupon_no = (+$('#dinner_coupon_no').val());
      let fullCharge = $('#fullCharge').val();

      let bre = 0;
      let food = 0;
      if(fullCharge == "Yes"){
             brk = 15;
             food = 50;
      }else{
             brk = 7.5;
             food = 25;
      }
     
    
      let breakfast_amt = breakfast_coupon_no*brk;
      let lunch_amt = lunch_coupon_no*food;
      let dinner_amt = dinner_coupon_no*food;

      let total_amt = dinner_amt+lunch_amt+breakfast_amt;
      let total_issue_coupon = dinner_coupon_no+lunch_coupon_no+breakfast_coupon_no

      $('#dinner_coupon_amt').val(dinner_amt)
      $('#lunch_coupon_amt').val(lunch_amt)
      $('#breakfast_coupon_amt').val(breakfast_amt)
      $('#total_coupon_amt').val(total_amt)
      $('#total_issue_coupon').val(total_issue_coupon)
     
  }//fun


</script>

