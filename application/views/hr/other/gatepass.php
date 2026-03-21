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
                    <div class="col-md-4">
                          
                    </div>
                    <div class="col-md-6">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Gatepass</div>
                                    
                                      <form id="other_application_form">
                                        <div class="form-row">
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden"  id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                            <input type="hidden" class="form-control"  id="emp_code"  readonly  autocomplete="off"  value="<?php if(isset($login_emp_code))echo $login_emp_code;?>"  >
                                         
                                           
                                          <div class="col-md-12" style="margin-top:10px">
                                            <label >Type Of Work</label>
                                            <select class="form-control"   id="work_type">
                                              <option value="">Select</option>
                                              <option  <?php if(!empty($res2)){if($res2[0]['work_type']=='Personal'){echo "selected";}}?>>Personal</option>
                                              <option  <?php if(!empty($res2)){if($res2[0]['work_type']=='Company'){echo "selected";}}?>>Company</option>
                                            </select>
                                          </div>

                                          <div class="col-md-12" style="margin-top:10px">
                                            <label>Reason</label>
                                            <input type="text" class="form-control"  id="description" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['description'];?>" >
                                          </div>

                                          <div class="col-md-4" style="margin-top:10px">
                                            <label>Vehical No.</label>
                                            <input type="text" class="form-control"  id="vehical_name" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['vehical_name'];?>" >
                                          </div>

                                          <div class="col-md-4" style="margin-top:10px">
                                            <label>KM Start</label>
                                            <input type="number" class="form-control"  id="km_start" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['km_start'];?>" >
                                          </div>

                                          <div class="col-md-4" style="margin-top:10px">
                                            <label>KM End</label>
                                            <input type="number" class="form-control"  id="km_end" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['km_end'];?>" >
                                          </div>

                                          <div class="col-md-4" style="margin-top:10px">
                                            <label>Time Out</label>
                                            <input type="time" class="form-control"  id="time_out" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['time_out'];?>" >
                                          </div>

                                          <div class="col-md-4" style="margin-top:10px">
                                            <label >Duty Off</label>
                                            <select class="form-control"   id="duty_off">
                                              <option value="">Select</option>
                                              <option  <?php if(!empty($res2)){if($res2[0]['duty_off']=='Yes'){echo "selected";}}?>>Yes</option>
                                              <option  <?php if(!empty($res2)){if($res2[0]['duty_off']=='No'){echo "selected";}}?>>No</option>
                                            </select>
                                          </div>

                                          <div class="col-md-4" style="margin-top:10px">
                                            <label>Time In</label>
                                            <input type="time" class="form-control"  id="time_in" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['time_in'];?>" >
                                          </div>

                                            <div class="col-md-12" style="margin-top:10px">
                                                  <label >Remarks</label>
                                                  <input type="text" class="form-control"  id="remarks" required  autocomplete="off" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>" >
                                            </div>
                                     
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success"  onclick="emp_gatepass2()">Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                                      
                                    </div>
                                   </form>
                               
                            </div>
                        </div>
                    </div>

                  
                    
          </div><!-- end of main-content -->   

  

<script>
function emp_gatepass2()
{
    let emp_code     = $('#emp_code').val().trim();
    let work_type    = $('#work_type').val();
    let vehical_name = $('#vehical_name').val().trim();
    let km_start     = $('#km_start').val().trim();
    let km_end       = $('#km_end').val().trim();
    let time_out     = $('#time_out').val();
    let duty_off     = $('#duty_off').val();
    let time_in      = $('#time_in').val();
    let description     = $('#description').val();

    // Basic validation
    if(emp_code === ''){
        $('#emp_code').focus();
        fun_message('warning','Warning','Employee Code required','toast-bottom-right');
        return false;
    }

    if(description === ''){
        fun_message('warning','Warning','Reason required','toast-bottom-right');
        return false;
    }

    if(time_out === ''){
        fun_message('warning','Warning','Time Out required','toast-bottom-right');
        return false;
    }

    $('.loader').show();

    $.post(
        "<?php echo base_url().'index.php/Hr/emp_gatepass_save'; ?>",
        {
            emp_code     : emp_code,
            work_type    : work_type,
            vehical_name : vehical_name,
            km_start     : km_start,
            km_end       : km_end,
            time_out     : time_out,
            duty_off     : duty_off,
            time_in      : time_in,
            description   : description
        },
        function(data)
        {
            if(data === 'Save'){
                // Clear form
                $('#emp_code, #vehical_name, #km_start, #km_end, #time_out, #time_in').val('');
                $('#work_type, #duty_off, #description').val('');

                fun_message('success','Success','Gatepass saved successfully','toast-bottom-right');
            } else {
                fun_message('error','Error',data,'toast-bottom-right');
            }

            $('.loader').hide();
        }
    );
}


</script>
