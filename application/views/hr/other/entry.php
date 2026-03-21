<?php 
    $loginId =$this->session->userdata('login_emp_id');
    $login_emp_code =$this->session->userdata('login_emp_code');
   if(!empty($res2[0]['ask_date']) and $res2[0]['ask_date']!='0000-00-00'){$ask_date=$this->Base->change_date_ymd($res2[0]['ask_date']);}else{$ask_date='';}
   if(!empty($res2[0]['doj']) and $res2[0]['doj']!='0000-00-00'){$doj=$this->Base->change_date_dmy($res2[0]['doj']);}else{$doj='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Other Application Form </h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-5">
                          <div class="card text-left">
                            <div class="card-body">
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
                              <div class="card-title" >New Application Form</div>
                                    
                                      <form id="other_application_form">
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

                                            

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label>Present Address</label>
                                                  <input type="text" class="form-control"  id="present_address" required  autocomplete="off" value="<?php if(isset($res2[0]['present_address']))echo $res2[0]['present_address'];?>" >
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label>Permanent Address</label>
                                                  <input type="text" class="form-control"  id="permanent_address" required  autocomplete="off" value="<?php if(isset($res2[0]['permanent_address']))echo $res2[0]['permanent_address'];?>" >
                                            </div>

                                             
                                            
                                            <div class="col-md-12" style="margin-top:10px">
                                                  <label style="color:blue">Type of Application</label>
                                                  <select class="form-control"   id="type" onchange="get_form()">
                                                      <option value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Medical'){echo "selected";}}?>>Medical</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='EPF/ESI'){echo "selected";}}?>>EPF/ESI</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Fight'){echo "selected";}}?>>Fight</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Fine'){echo "selected";}}?>>Fine</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Gatepass'){echo "selected";}}?>>Gatepass</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Increment'){echo "selected";}}?>>Increment</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='MEMO'){echo "selected";}}?>>MEMO</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Mobile'){echo "selected";}}?>>Mobile</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Resign'){echo "selected";}}?>>Resign</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Rest Change'){echo "selected";}}?>>Rest Change</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Re-Join'){echo "selected";}}?>>Re-Join</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Salary'){echo "selected";}}?>>Salary</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Shift Change'){echo "selected";}}?>>Shift Change</option>
                                                      <option  <?php if(isset($res2[0]['type'])){if($res2[0]['type']=='Other'){echo "selected";}}?>>Other</option>
                                                  </select>
                                            </div>

                                            

                                            <div  class="col-md-12" id="out_html">
                                              <?php 
                                                if(!empty($res2)){
                                                  $this->Hrmodel->other_appication_form($res2[0]['type'],$res2);
                                                }
                                              ?>  
                                            </div>                                   
                              
                                            
                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label >Remarks</label>
                                                  <input type="text" class="form-control"  id="remarks" required  autocomplete="off" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>" >
                                            </div>
                                     

                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label style="color:blue">Status</label>
                                                  <select class="form-control"   id="status">
                                                      <option value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Approve'){echo "selected";}}?>>Approve</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Reject'){echo "selected";}}?>>Reject</option>
                                                  </select>
                                            </div>


                                     
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="other_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                                      
                                    </div>
                                   </form>
                               
                            </div>
                        </div>
                    </div>

                  
                    
          </div><!-- end of main-content -->   

  

<?php $this->load->view('js/hr_js');?>
<script>

function get_form(){
        
        let  type=$('#type').val();
        let search1='1';
      
          //-------------------------------getting gst type
          $('.loader').show();
          setTimeout(function() {
            jQuery.post("<?php echo base_url().'index.php/Hr/get_other_application_form';?>", 
            {
              type:type,
              search1:search1,
            }, 
            function(data, textStatus)
            {	
              //alert(data);
              $('#out_html').html(data);
              
              $('.loader').hide();
            });//jquery
          });//loader

       getDetils();
  }





  function getDetils(){
      $('#table_show').html('');
       let  type=$('#type').val();
       let  emp_code=$('#emp_code').val();
       let search2='1';
       //-------------------------------getting gst type
        $('.loader').show();
       setTimeout(function() {
          jQuery.post("<?php echo base_url().'index.php/Hr/getEmpAdvanceDetails';?>", 
          {
            emp_code:emp_code,
            type:type,
            search2:search2,
          }, 
          function(data, textStatus)
          {	
            //alert(data);
            $('#table_show').html(data);
             $('.loader').hide();
          });//jquery
        });//loader
       
  }
</script>
