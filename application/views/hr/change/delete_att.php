<?php 
    $loginId =$this->session->userdata('login_emp_id');
    $login_emp_code =$this->session->userdata('login_emp_code');
  
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Delete Employee Attendance</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-2">
                          
                    </div>
                    <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" style="color:red">Delete Employee Attendance</div>
                                    
                                      <form id="other_application_form">
                                        <div class="form-row">
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden"  id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                               
                                           
                                             <div class="col-md-3">
                                                <label>Year</label>
                                                <select class="form-control" id="search_year">
                                                  <option value="">Select</option>
                                                    <?php
                                                    $currentYear = date('Y');
                                                    for ($y = 2025; $y <= 2030; $y++) {
                                                    ?>
                                                        <option value="<?= $y ?>" >
                                                            <?= $y ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Month</label>
                                                <select class="form-control" id="search_month">
                                                  <option value="">Select</option>
                                                    <?php
                                                    $months = [
                                                        1=>'January',2=>'February',3=>'March',4=>'April',
                                                        5=>'May',6=>'June',7=>'July',8=>'August',
                                                        9=>'September',10=>'October',11=>'November',12=>'December'
                                                    ];
                                                    $currentMonth = (int)date('n');
                                                    foreach ($months as $k=>$v) {
                                                    ?>
                                                        <option value="<?= $k ?>" >
                                                            <?= $v ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>


                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label>Emp Code</label>
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

                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label>Payroll Unit</label>
                                                  <input type="text" class="form-control"  id="company_role" required  autocomplete="off" value="<?php if(isset($res2[0]['company_role']))echo $res2[0]['permanent_address'];?>" >
                                            </div>

                                               <div class="col-md-12" style="margin-top:30px">
                                              If the employee has any loan EMI entry in the selected month, then do not delete the employee’s attendance records. Instead, mark the attendance as “Absent” manually by updating the records.    
                                            </div>
                                         
                                               
                                            <div class="col-md-12" id='delete_button' style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-danger" onclick="delete_emp_att()" >Delete Attendance</button>
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


function delete_emp_att(){
      let  emp_code=$('#emp_code').val();
      let  search_year=$('#search_year').val();
      let  search_month=$('#search_month').val();
      
      
      if(search_year==''){$('#search_year').focus();fun_message('warning','Warning','Select Year','toast-bottom-right');return false;}
      if(search_month==''){$('#search_month').focus();fun_message('warning','Warning','Select Month','toast-bottom-right');return false;}
      if(emp_code==''){$('#emp_code').focus();fun_message('warning','Warning','Enter Employee Code','toast-bottom-right');return false;}

      if(!confirm('Are you sure you want to DELETE this employee permanently?\nThis action cannot be undone.')){
        return false;
      }
     
      
      let search1='1';
      const url = $('#url').val(); 
      
       
          //-------------------------------getting gst type
          $('.loader').show();
          setTimeout(function() {
            jQuery.post("<?php echo base_url().'index.php/Hr/delete_emp_code_att_save';?>", 
            {
              search_year:search_year,
              search_month:search_month,
              emp_code:emp_code,
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
									fun_message('success',data,'Deleted Successfully','toast-bottom-right');
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
