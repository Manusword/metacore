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
                <div class="row">
                    <div class="col-md-3">
                          
                    </div>
                    <div class="col-md-7">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Employee Leave Master</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden"  id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                               
                                           
                                            <div class="col-md-3" style="margin-top:10px">
                                                  <label >Emp Code</label>
                                                    <input type="text" class="form-control"  id="emp_code" onKeyUp="op_search(this.id)" required  autocomplete="off"  value="<?php if(isset($res2[0]['emp_code']))echo $res2[0]['emp_code'];?>" onchange="get_emp_basic_data(this.value),get_emp_leave_master_data()" >
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
                                                  <label>Current Payroll Unit</label>
                                                  <input type="text" class="form-control" id="company_role" required="" autocomplete="off" value="">
                                            </div>

                                            

                                            <input type="hidden" class="form-control"  id="present_address" required  autocomplete="off" value="<?php if(isset($res2[0]['present_address']))echo $res2[0]['present_address'];?>" >

                                            <input type="hidden" class="form-control"  id="permanent_address" required  autocomplete="off" value="<?php if(isset($res2[0]['permanent_address']))echo $res2[0]['permanent_address'];?>" >

                                            <div class="col-md-12" style="margin-top:30px;">
                                              <div class="panel-heading clearfix">
                                                  <h4 align="left" style="color:<?php echo $this->Company->table_bg_color();?>;" >Leave Details</h4>
                                              </div>
                                            </div>


                                           
                                            <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Leave Eligible ?</label>
                                                <select class="form-control"  id="is_leave_eligible">
                                                <option value="">Select</option>
                                                <option  <?php if(isset($res2[0]['is_leave_eligible'])){if($res2[0]['is_leave_eligible']=='No'){echo "selected";}};?>  >No</option>
                                                <option <?php if(isset($res2[0]['is_leave_eligible'])){if($res2[0]['is_leave_eligible']=='Yes'){echo "selected";}};?>  >Yes</option>
                                                </select>
                                          </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group" >
                                        <label > Total Leave Allotted</label>
                                        <input type="number" class="form-control"  id="leave_yearly" required  autocomplete="off" value="<?php  if(isset($res2[0]['leave_yearly']))echo $res2[0]['leave_yearly'];?>">
                                      </div>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="form-group" >
                                        <label >CL Allotted</label>
                                        <input type="number" class="form-control"  id="leave_cl" required  autocomplete="off" value="<?php  if(isset($res2[0]['leave_cl']))echo $res2[0]['leave_cl'];?>">
                                      </div>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="form-group" >
                                        <label >SL Allotted</label>
                                        <input type="number" class="form-control"  id="leave_sl" required  autocomplete="off" value="<?php  if(isset($res2[0]['leave_sl']))echo $res2[0]['leave_sl'];?>">
                                      </div>
                                    </div>

                                     <div class="col-md-4">
                                      <div class="form-group" >
                                        <label >EL Allotted</label>
                                        <input type="number" class="form-control"  id="leave_el" required  autocomplete="off" value="<?php  if(isset($res2[0]['leave_el']))echo $res2[0]['leave_el'];?>">
                                      </div>
                                    </div>

                                    

                                            
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="emp_leave_master_save" >Save</button>
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
function get_emp_leave_master_data() {
    $('#is_leave_eligible').val('');
     $('#leave_yearly').val('');
    $('#leave_cl').val('');
    $('#leave_sl').val('');
    $('#leave_el').val('');

    const emp_code = ($('#emp_code').val() || '').trim();
    if (!emp_code) return;

    $.post(
        "<?php echo base_url().'index.php/Hr/get_emp_leave_master_data';?>",
        { emp_code: emp_code },
        function (data) {

           // console.log('RAW:', data);

            // 🔴 if string returned instead of JSON
            if (typeof data === "string") {
                try { data = JSON.parse(data); }
                catch(e){ console.error('JSON parse fail'); return; }
            }

            if (!data || data.error) {
                alert(data?.error || 'No data found');
                return;
            }

            //console.log('PARSED:', data);

            // dropdown (works for normal + select2)
            $('#is_leave_eligible')
                .val(data.is_leave_eligible)
                .trigger('change');

            // numbers
            $('#leave_yearly').val(data.leave_yearly);
            $('#leave_cl').val(data.leave_cl);
            $('#leave_sl').val(data.leave_sl);
            $('#leave_el').val(data.leave_el);

        },
        'json'  
    );
}

 $('#emp_leave_master_save').on('click', function () {

    const btn = $(this);
    const emp_code = $('#emp_code').val().trim();
    const eligible = $('#is_leave_eligible').val() || "No";
    const url = $('#url').val()

    if (!emp_code) {
        $('#emp_code').focus();
        fun_message('warning','Warning','Enter Empcode','toast-bottom-right');
        return;
    }

    let yearly = parseFloat($('#leave_yearly').val()) || 0;
    let cl = parseFloat($('#leave_cl').val()) || 0;
    let sl = parseFloat($('#leave_sl').val()) || 0;
    let el = parseFloat($('#leave_el').val()) || 0;

    // if not eligible → force zero
    if (eligible !== "Yes") {
        yearly = cl = sl = el = 0;
    } else {

        if (yearly <= 0) {
            fun_message('warning','Warning','Enter total no of leave','toast-bottom-right');
            return;
        }

        if (cl < 0 || sl < 0 || el < 0) {
            fun_message('warning','Warning','Leave values cannot be negative','toast-bottom-right');
            return;
        }

        const total = cl + sl + el;

        // float-safe comparison
        if (Math.abs(yearly - total) > 0.01) {
            fun_message('warning','Warning','Total is not equal','toast-bottom-right');
            return;
        }
    }

    // prevent double click
    btn.prop('disabled', true);
    $('#wait').show();

    $.post(
        "<?php echo base_url().'index.php/Hr/emp_leave_master_save';?>",
        {
            emp_code: emp_code,
            is_leave_eligible: eligible,
            leave_yearly: yearly,
            leave_cl: cl,
            leave_el: el,
            leave_sl: sl
        },
        function(data, textStatus) {

            if(data=='Save') {
                fun_message('success','Success','Save Successfully','toast-bottom-right');
                showPage(url);
            } else {
                fun_message('error','Error',res,'toast-bottom-right');
            }

        }
    )
    .fail(function () {
        fun_message('error','Error','Server error','toast-bottom-right');
    })
    .always(function () {
        btn.prop('disabled', false);
        $('#wait').hide();
    });

});
</script>
