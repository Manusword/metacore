<?php 
    $loginId =$this->session->userdata('login_emp_id');
    $login_emp_code =$this->session->userdata('login_emp_code');
  
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Change Employee Unit</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2">
                          
                    </div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Change Employee Unit</div>
                                    
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
                                                  <label>Current Payroll Unit</label>
                                                  <input type="text" class="form-control"  id="company_role" required  autocomplete="off" value="<?php if(isset($res2[0]['company_role']))echo $res2[0]['permanent_address'];?>" >
                                            </div>

                                          

                                             <div class="col-md-12" style="margin-top:10px">
                                                <label style="color:blue">New Payroll Unit</label>
                                                <select class="form-control"  id="new_company_role" >
                                                    <option value="">Select</option>
                                                    <?Php 
                                                      foreach($company_role as $c)
                                                      {
                                                        ?>
                                                          <option  value="<?php echo $c['name'];?>" >
                                                              <?php echo $c['name'];?>
                                                          </option>
                                                        <?php
                                                      }
                                                    ?>	
                                                </select>
                                            </div> 
                                     

                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" onclick="update_unit()" >Update</button>
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

function update_unit(){
      let  emp_code=$('#emp_code').val();
      let  company_role=$('#company_role').val();
      let  new_company_role=$('#new_company_role').val();
      let search1='1';
      const url = $('#url').val(); 
      
      if(emp_code==''){$('#emp_code').focus();fun_message('warning','Warning','Enter Empcode','toast-bottom-right');return false;}
      if(new_company_role==''){$('#new_company_role').focus();fun_message('warning','Warning','Enter New Company Role','toast-bottom-right');return false;}
     
      if(company_role==new_company_role){fun_message('warning','Warning','Old and New Company Role are same','toast-bottom-right');return false;}
       
          //-------------------------------getting gst type
          $('.loader').show();
          setTimeout(function() {
            jQuery.post("<?php echo base_url().'index.php/Hr/unit_transfer_save';?>", 
            {
              emp_code:emp_code,
              new_company_role:new_company_role,
              search1:search1,
            }, 
            function(data, textStatus)
            {	
              //alert(data);
              if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									showPage(url);
                 
								}
								else if(data=='Update')
								{
									fun_message('success',data,'Updated Successfully','toast-bottom-right');
									showPage(url);
								}
								else
								{
									fun_message('error','Error',data,'toast-bottom-right');
								}
								$('.loader').hide();
            });//jquery
          });//loader

      
  }



</script>
