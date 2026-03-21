<?php
$loginId = $this->session->userdata('login_emp_id');
?>
<!-- ============ Body content start ============= -->
<div class="main-content">
    <div class="breadcrumb">
        <h1>Loan Application</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-7 offset-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title">New Loan Application</div>

                     <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                    <input type="hidden" id="id" value="<?php if(isset($res2[0]['loan_id'])) echo $res2[0]['loan_id']; ?>">

                    <div class="form-row">

                        <!-- EMP CODE -->
                        <div class="col-md-3 mt-2">
                            <label>Emp Code</label>
                            <input type="text"
                                   class="form-control"
                                   id="emp_code"
                                   value="<?php if(isset($res2[0]['emp_code'])) echo $res2[0]['emp_code']; ?>"
                                   onkeyup="op_search(this.id)"
                                   onchange="get_emp_basic_data(this.value)"
                                   autocomplete="off"
                                   required>
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

                        <!-- LOAN TYPE -->
                        <div class="col-md-3 mt-2">
                            <label>Loan Type</label>
                            <select class="form-control" id="interest_type" onchange="calculateEMI()" required>
                                <option value="">-- Select Loan Type --</option>
                                <option <?php if(isset($res2[0]['interest_type'])){if($res2[0]['interest_type']=="NONE"){echo "selected";}}?> value="NONE">Loan (No Interest)</option>
                                <!-- <option value="FLAT">Loan (Flat Interest)</option>
                                <option value="REDUCING">Loan (Reducing)</option> -->
                            </select>
                        </div>

                        <!-- LOAN AMOUNT -->
                        <div class="col-md-3 mt-2">
                            <label>Loan Amount</label>
                            <input type="number" class="form-control" id="loan_amount" onkeyup="calculateEMI()" required value="<?php if(isset($res2[0]['loan_amount']))echo $res2[0]['loan_amount'];?>">
                        </div>

                        <!-- INTEREST RATE -->
                        <div class="col-md-3 mt-2">
                            <label>Interest Rate (%)</label>
                            <input type="number" class="form-control" id="interest_rate" value="0" onkeyup="calculateEMI()" value="<?php if(isset($res2[0]['interest_rate']))echo $res2[0]['interest_rate'];?>">
                        </div>

                        <!-- TENURE -->
                        <div class="col-md-3 mt-2">
                            <label>Tenure (Months)</label>
                            <input type="number" class="form-control" id="tenure" onkeyup="calculateEMI()" required value="<?php if(isset($res2[0]['tenure_months']))echo $res2[0]['tenure_months'];?>">
                        </div>

                        <!-- EMI -->
                        <div class="col-md-3 mt-2">
                            <label>EMI Amount</label>
                            <input type="text" class="form-control" id="emi_amount" readonly value="<?php if(isset($res2[0]['emi_amount']))echo $res2[0]['emi_amount'];?>">
                        </div>

                        <!-- START MONTH -->
                         <?php
                            $start_month = '';
                            if (!empty($res2[0]['start_month']) && $res2[0]['start_month'] != '0000-00-00') {
                                // DB: 2025-12-01 → Input: 2025-12
                                $start_month = date('Y-m', strtotime($res2[0]['start_month']));
                            }
                            ?>

                          <div class="col-md-3 mt-2">
                                <label>Start Month</label>
                                <input
                                    type="month"
                                    class="form-control"
                                    id="start_month"
                                    name="start_month"
                                    required
                                    value="<?= $start_month ?>"
                                >
                            </div>


                        <div class="col-md-3 mt-2">
                            <label>Status</label>
                            <select class="form-control" id="status">
                                <option <?php if(isset($res2[0]['status'])){if($res2[0]['status']=="RUNNING"){echo "selected";}}?> value="RUNNING">Running</option>
                                <option <?php if(isset($res2[0]['status'])){if($res2[0]['status']=="CLOSED"){echo "selected";}}?> value="CLOSED">Closed</option>
                            </select>
                        </div>


                        <!-- REMARKS -->
                        <div class="col-md-3 mt-2">
                            <label style="color:green">Remarks</label>
                            <input type="text"
                                   class="form-control"
                                   id="remarks"
                                   value="<?php if(isset($res2[0]['remarks'])) echo $res2[0]['remarks']; ?>"
                                   autocomplete="off">
                        </div>

                        <!-- SAVE BUTTON -->
                        <div class="col-md-12 mt-4 text-center">
                            <span id="wait" style="display:none;color:orange;">
                                <div class="spinner spinner-info mr-3"></div>
                            </span>
                            <button type="button" class="btn btn-success" onclick="saveLoan()">Save</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============ Body content end ============= -->



<script>

function calculateEMI() {

    let type   = $('#interest_type').val();
    let amount = parseFloat($('#loan_amount').val()) || 0;
    let rate   = parseFloat($('#interest_rate').val()) || 0;
    let tenure = parseInt($('#tenure').val()) || 0;

    if (!type || amount <= 0 || tenure <= 0) {
        $('#emi_amount').val('');
        return;
    }

    let emi = 0;

    // 1️⃣ No Interest Loan
    if (type === 'NONE') {
        emi = amount / tenure;
    }

    // 2️⃣ Flat Interest Loan
    else if (type === 'FLAT') {
        let total = amount + (amount * rate * tenure / 12 / 100);
        emi = total / tenure;
    }

    // 3️⃣ Reducing Balance Loan
    else if (type === 'REDUCING') {
        if (rate <= 0) {
            alert('Interest rate required for reducing loan');
            $('#emi_amount').val('');
            return;
        }
        let r = rate / 12 / 100;
        emi = amount * r * Math.pow(1 + r, tenure) /
              (Math.pow(1 + r, tenure) - 1);
    }

    $('#emi_amount').val(emi.toFixed(2));
}



function saveLoan() {
  var url=$('#url').val();
  let emp_code= $('#emp_code').val();
  let interest_type= $('#interest_type').val();
  let loan_amount= $('#loan_amount').val();
  let tenure= $('#tenure').val();
  let emi_amount= $('#emi_amount').val();
  let start_month= $('#start_month').val();

  if(emp_code==''){$('#emp_code').focus();fun_message('warning','Warning','Enter emp_code','toast-bottom-right');return false;}
  if(interest_type==''){$('#interest_type').focus();fun_message('warning','Warning','Select interest_type','toast-bottom-right');return false;}
  if(loan_amount==''){$('#loan_amount').focus();fun_message('warning','Warning','Enter loan_amount','toast-bottom-right');return false;}
  if(tenure==''){$('#tenure').focus();fun_message('warning','Warning','Enter tenure','toast-bottom-right');return false;}
  if(emi_amount <1){
    fun_message('warning','Warning','Invalid amount','toast-bottom-right');return false;
  }
  if(start_month==''){$('#start_month').focus();fun_message('warning','Warning','Enter start_month','toast-bottom-right');return false;}

    let data1 = { 
        id: $('#id').val(),
        emp_code: $('#emp_code').val(),
        interest_type: $('#interest_type').val(),
        loan_amount: $('#loan_amount').val(),
        interest_rate: $('#interest_rate').val(),
        tenure: $('#tenure').val(),
        emi_amount: $('#emi_amount').val(),
        start_month: $('#start_month').val(),
        remarks: $('#remarks').val(),
        status: $('#status').val()
    };

    $('#wait').show();

    $.post("<?php echo base_url('index.php/Hr/saveEmployeeLoan'); ?>", data1, function(data){
        $('#wait').hide();
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
        $('#wait').hide();
				//location.reload();
    });
}
</script>
<?php $this->load->view('js/hr_js');?>