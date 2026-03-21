<?php 
    $loginId =$this->session->userdata('login_emp_id');
   if(!empty($res2[0]['ask_date']) and $res2[0]['ask_date']!='0000-00-00'){$ask_date=$this->Base->change_date_ymd($res2[0]['ask_date']);}else{$ask_date='';}
   if(!empty($res2[0]['doj']) and $res2[0]['doj']!='0000-00-00'){$doj=$this->Base->change_date_dmy($res2[0]['doj']);}else{$doj='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Advance</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-5">
                          <div class="card text-left">
                            <div class="card-body">
                                <h4 class="card-title mb-3"><span style="font-weight:bold;color:blue"><?php if(isset($res2[0]['first_name']))echo $res2[0]['first_name'].' '.$res2[0]['last_name'];?></span> Advance Application History: </h4>
                                  <div id="table_show">
                                    <?php 
                                    //getting adcance history
                                      if(isset($res2[0]['emp_code'])){
                                          //Last advance   
                                          $data = $this->Hrmodel->get_advance_history_emp_code($res2[0]['emp_code']);
                                          if(!empty($data)){$this->Hrmodel->get_advance_history_emp_code_table($data,0); }
                                    
                                          //DOJ
                                          echo "<br>";
                                          if(isset($res2[0]['doj']))echo "Date of last Join: ".$doj;
                                          echo "<br>";
                                          if(isset($res2[0]['last_org']))echo "Join History / last Org: ".$res2[0]['last_org'];
                                        
                                      } 
                                    ?>
                                  </div>
                              </div>
                            </div>
                    </div>
                    <div class="col-md-7">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Advance Application</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden"  id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                               
                                           
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
                                                  <input type="text" class="form-control"  id="father_name" required  autocomplete="off" value="<?php if(isset($res2[0]['father_name']))echo $res2[0]['father_name'];?>" >
                                            </div>

                                              <div class="col-md-3" style="margin-top:10px">
                                                  <label>Mobile</label>
                                                  <input type="text" class="form-control"  id="mob" required  autocomplete="off" value="<?php if(isset($res2[0]['mob']))echo $res2[0]['mob'];?>" >
                                            </div>

                                             <div class="col-md-3" style="margin-top:10px">
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

                                            
                                            <div class="col-md-3" style="margin-top:10px">
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

                                            

                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label>Present Address</label>
                                                  <input type="text" class="form-control"  id="present_address" required  autocomplete="off" value="<?php if(isset($res2[0]['present_address']))echo $res2[0]['present_address'];?>" >
                                            </div>

                                            <div class="col-md-12" style="margin-top:10px">
                                                  <label>Permanent Address</label>
                                                  <input type="text" class="form-control"  id="permanent_address" required  autocomplete="off" value="<?php if(isset($res2[0]['permanent_address']))echo $res2[0]['permanent_address'];?>" >
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label>Date</label>
                                                <input type="date" class="form-control"  id="ask_date" required  autocomplete="off" value="<?php if(isset($ask_date))echo $ask_date;?>"  >
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label>Ask Amount (Rs.)</label>
                                                  <input type="text" class="form-control"  id="ask_amount" required  autocomplete="off" value="<?php if(isset($res2[0]['ask_amount']))echo $res2[0]['ask_amount'];?>"  onchange="getDetils()">
                                            </div>

                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label>Reason</label>
                                                  <input type="text" class="form-control"  id="reason_for" required  autocomplete="off" value="<?php if(isset($res2[0]['reason_for']))echo $res2[0]['reason_for'];?>" >
                                            </div>

                                         
                                             <div class="col-md-12" style="margin-top:10px">
                                                  <label style="color:green">Approve Amount (Rs.)</label>
                                                  <input type="text" class="form-control"  id="approve_amount" required  autocomplete="off" value="<?php if(isset($res2[0]['approve_amount']))echo $res2[0]['approve_amount'];?>" >
                                            </div>

                                           
                                    
                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label style="color:blue">Status</label>
                                                  <select class="form-control"   id="status">
                                                      <option value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Approve'){echo "selected";}}?>>Approve</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Reject'){echo "selected";}}?>>Reject</option>
                                                  </select>
                                            </div>


                                             <div class="col-md-3" style="margin-top:10px">
                                                  <label style="color:blue">Payment Type</label>
                                                  <select class="form-control"   id="payment_type">
                                                      <option value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['payment_type'])){if($res2[0]['payment_type']=='Account'){echo "selected";}}?>>Account</option>
                                                      <option  <?php if(isset($res2[0]['payment_type'])){if($res2[0]['payment_type']=='Cash'){echo "selected";}}?>>Cash</option>
                                                  </select>
                                            </div>

                                             <div class="col-md-6" style="margin-top:10px">
                                                  <label style="color:green">Remarks</label>
                                                  <input type="text" class="form-control"  id="remarks" required  autocomplete="off" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>" >
                                            </div>
                                            
                                     
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="emp_advance_save" >Save</button>
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
  function getDetils(){
      
      let  id=$('#id').val();
      let  emp_code=$('#emp_code').val();
			let search1='1';
			
      if(id > 0){}else{
        //-------------------------------getting gst type
        $('.loader').show();
        setTimeout(function() {
          jQuery.post("<?php echo base_url().'index.php/Hr/getEmpAdvanceDetails';?>", 
          {
            emp_code:emp_code,
            search1:search1,
          }, 
          function(data, textStatus)
          {	
            //alert(data);
            $('#table_show').html(data);
            $('.loader').hide();
          });//jquery
        });//loader
      }
  }
</script>
