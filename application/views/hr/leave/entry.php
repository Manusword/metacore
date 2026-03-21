<?php 
    $loginId =$this->session->userdata('login_emp_id');
    $login_emp_code =$this->session->userdata('login_emp_code');
   if(!empty($res2[0]['ask_from_date']) and $res2[0]['ask_from_date']!='0000-00-00'){$ask_from_date=$this->Base->change_date_ymd($res2[0]['ask_from_date']);}else{$ask_from_date='';}
   if(!empty($res2[0]['ask_to_date']) and $res2[0]['ask_to_date']!='0000-00-00'){$ask_to_date=$this->Base->change_date_ymd($res2[0]['ask_to_date']);}else{$ask_to_date='';}
   if(!empty($res2[0]['approve_from_date']) and $res2[0]['approve_from_date']!='0000-00-00'){$approve_from_date=$this->Base->change_date_ymd($res2[0]['approve_from_date']);}else{$approve_from_date=$ask_from_date;}
   if(!empty($res2[0]['approve_to_date']) and $res2[0]['approve_to_date']!='0000-00-00'){$approve_to_date=$this->Base->change_date_ymd($res2[0]['approve_to_date']);}else{$approve_to_date=$ask_to_date;}
   if(!empty($res2[0]['doj']) and $res2[0]['doj']!='0000-00-00'){$doj=$this->Base->change_date_dmy($res2[0]['doj']);}else{$doj='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Leave</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-5">
                          <div class="card text-left">
                            <div class="card-body">
                                <h4 class="card-title mb-3"><span style="font-weight:bold;color:blue"><?php if(isset($res2[0]['first_name']))echo $res2[0]['first_name'].' '.$res2[0]['last_name'];?></span> Leave Application History: </h4>
                                  <div id="table_show">
                                    <?php 
                                    //getting leave history
                                      if(isset($res2[0]['emp_code'])){
                                          //Last Leave   
                                          $data = $this->Hrmodel->get_leave_history_emp_code($res2[0]['emp_code']);
                                          if(!empty($data)){$this->Hrmodel->get_leave_history_emp_code_table($data,0); }
                                    
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
                              <div class="card-title" >New Leave Application</div>
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

                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label> Ask Leave From</label>
                                                <input type="date" class="form-control"  id="ask_from_date" required  autocomplete="off" value="<?php if(isset($ask_from_date))echo $ask_from_date;?>" onchange="get_no_of_days()" >
                                            </div>

                                             <div class="col-md-4" style="margin-top:10px">
                                                  <label> Ask Leave To</label>
                                                  <input type="date" class="form-control"  id="ask_to_date" required  autocomplete="off" value="<?php if(isset($ask_to_date))echo $ask_to_date;?>" onchange="get_no_of_days()">
                                            </div>


                                             <div class="col-md-4" style="margin-top:10px">
                                                  <label>Ask Total Days</label>
                                                  <input type="text" class="form-control"  id="ask_total_days" required  autocomplete="off" value="<?php if(isset($res2[0]['ask_total_days']))echo $res2[0]['ask_total_days'];?>" >
                                            </div>

                                            <div class="col-md-12" style="margin-top:10px">
                                                  <label>Reason</label>
                                                  <input type="text" class="form-control"  id="reason_for" required  autocomplete="off" value="<?php if(isset($res2[0]['reason_for']))echo $res2[0]['reason_for'];?>"  onchange="getDetils()">
                                            </div>

                                           <div class="col-md-12" style="margin-top:10px">
                                                <label >Details</label>
                                                  <textarea  class="form-control"  id="reason" required  autocomplete="off"><?php if(isset($res2[0]['reason']))echo $res2[0]['reason'];?></textarea>
                                            </div>


                                          
                                            
                                           

                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label>Approve Leave From</label>
                                                  <input type="date" class="form-control"  id="approve_from_date" required  autocomplete="off" value="<?php if(isset($approve_from_date))echo $approve_from_date;?>" onchange="get_no_of_days2()">
                                            </div>

                                             <div class="col-md-4" style="margin-top:10px">
                                                  <label> Approve Leave To</label>
                                                  <input type="date" class="form-control"  id="approve_to_date" required  autocomplete="off" value="<?php if(isset($approve_to_date))echo $approve_to_date;?>" onchange="get_no_of_days2()">
                                            </div>


                                             <div class="col-md-4" style="margin-top:10px">
                                                  <label>Approve Total Days</label>
                                                  <input type="text" class="form-control"  id="approve_total_days" required  autocomplete="off" value="<?php if(isset($res2[0]['approve_total_days']))echo $res2[0]['approve_total_days'];?>" >
                                            </div>
                                            

                                             <div class="col-md-4" style="margin-top:10px">
                                                  <label >Status By Sup.</label>
                                                    <select class="form-control" id="sign_supervisor">
                                                        <option value="">Select</option>
                                                        <option  <?php if(isset($res2[0]['sign_supervisor'])){if($res2[0]['sign_supervisor']=='Approve'){echo "selected";}}?>>Approve</option>
                                                        <option  <?php if(isset($res2[0]['sign_supervisor'])){if($res2[0]['sign_supervisor']=='Reject'){echo "selected";}}?>>Reject</option>
                                                    </select>
                                            </div>

                                              <div class="col-md-4" style="margin-top:10px">
                                                  <label>Sup./Section Head Name</label>
                                                  <input type="text" class="form-control"  id="sup_name" readonly  autocomplete="off" value="<?php if(!empty($res2[0]['sup_name'])){echo $res2[0]['sup_name'];}else{echo $login_emp_code;}?>" >
                                            </div>

                                           
                                            
                                           
                                      <?php if($this->Company->checkPermission3("Hr/leave_approve_hr")){ ?>
                                            <div class="col-md-4" style="margin-top:10px">
                                                  <label style="color:blue">Status</label>
                                                  <select class="form-control"   id="status">
                                                      <option value="">Select</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Approve'){echo "selected";}}?>>Approve</option>
                                                      <option  <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Reject'){echo "selected";}}?>>Reject</option>
                                                  </select>
                                            </div>
                                        <?php } ?>
                                            
                                     
                                                            
                                          
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="emp_leave_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>

                   <?php if(isset($res2[0]['status'])){?>
                    <div class="col-md-12">
                          <div class="card text-left">
                            <div class="card-body">
                                <h4 class="card-title mb-3"><span style="font-weight:bold;color:blue"><?php if(isset($res2[0]['first_name']))echo $res2[0]['first_name'].' '.$res2[0]['last_name'];?></span>Attendance History: </h4>
                                  <?php 
                                  //getting leave history
                                    if(isset($res2[0]['emp_code'])){
                                       
                                        //Attendance
                                        echo "<hr>";
                                        $this->Hrmodel->date_wise_attendance(date("Y"),$res2[0]['emp_code']); 
                                    } 
                                  ?>
                              </div>
                            </div>
                    </div>
                   <?php } ?>
                    
          </div><!-- end of main-content -->   




        
   

    

<?php $this->load->view('js/hr_js');?>

<script>
  function get_no_of_days(){
    let ask_from_date = $('#ask_from_date').val();
    let ask_to_date = $('#ask_to_date').val();

    if(ask_from_date != '' && ask_to_date != ''){
      if(ask_to_date >= ask_from_date){
        let daysDiff = get_day_diff(ask_from_date,ask_to_date);
        $('#ask_total_days').val(daysDiff);
      }else{
        $('#ask_total_days').val('');
        let ask_to_date = $('#ask_to_date').val("");
        fun_message('warning','Warning','Invalid Dates','toast-bottom-right');return false;
      }
    }
  }



  function get_no_of_days2(){
    let approve_from_date = $('#approve_from_date').val();
    let approve_to_date = $('#approve_to_date').val();
    
    if(approve_from_date != '' && approve_to_date != ''){
      let daysDiff = get_day_diff(approve_from_date,approve_to_date);
      $('#approve_total_days').val(daysDiff);
    }
  }

  function get_day_diff(from_date,to_date){
      let fromDate = new Date(from_date);
      let toDate = new Date(to_date);

      let timeDiff = toDate - fromDate;
      return daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24))+1; // convert milliseconds to days
  }



  //get details
    function getDetils(){
      
      let  id=$('#id').val();
      let  emp_code=$('#emp_code').val();
			let search1='1';
			
      if(id > 0){}else{
        //-------------------------------getting gst type
        $('.loader').show();
        setTimeout(function() {
          jQuery.post("<?php echo base_url().'index.php/Hr/getEmpLeaveDetails';?>", 
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

