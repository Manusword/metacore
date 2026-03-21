<?php //print_r($com);?>
<!-- ============ Body content start ============= -->
<div class="main-content">
    <div class="breadcrumb">
        <h1>Settings</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-8">

        <!-- TABS -->
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-company">Company</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-other">Attendance</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-print">Print</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-design">Design</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-email">Email</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-security">Security</a></li>
        </ul>

        <div class="tab-content">

            <!-- ================= COMPANY ================= -->
            <div class="tab-pane fade show active" id="tab-company">
                <div class="card">
                    <div class="card-body">
                        <h4>Company Settings</h4>
                        <div class="row">

                            <div class="col-md-12">
                                <label>Company Name</label>
                                <input type="text" id="company_name" class="form-control"  value="<?php if(!empty($com[0])) echo $com[0]['full_name'];?>">
                            </div>

                           
                            <div class="col-md-4">
                                <label>City</label>
                                <input type="text" id="company_city" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['city'];?>">
                            </div>

                            <div class="col-md-4">
                                <label>State</label>
                                <input type="text" id="company_state" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['state'];?>">
                            </div>

                            <div class="col-md-4">
                                <label>State Code</label>
                                <input type="text" id="state_code" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['state_code'];?>">
                            </div>

                            <div class="col-md-12">
                                <label>GST No</label>
                                <input type="text" id="company_gst" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['gstno'];?>">
                            </div>

                            <div class="col-md-12">
                                <label>Full Address (Print)</label>
                                <textarea id="company_address" class="form-control"><?php if(!empty($com[0])) echo $com[0]['full_address'];?></textarea>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-success" onclick="saveCompany()">Save Company Page</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= PRINT ================= -->
            <div class="tab-pane fade" id="tab-print">
                <div class="card">
                    <div class="card-body">
                        <h4>Print Settings</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Print Email</label>
                                <input type="text" id="print_email" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['email'];?>">
                            </div>

                            <div class="col-md-6">
                                <label>Print Mobile</label>
                                <input type="text" id="print_mobile" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['mob1'];?>">
                            </div>

                             <div class="col-md-12">
                                <label>Asset List</label>
                                <input type="text" id="asset_list" class="form-control" value="<?php if(!empty($com[00])) echo $com[0]['assetList'];?>">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-success" onclick="savePrint()">Save Print Page</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= EMAIL ================= -->
            <div class="tab-pane fade" id="tab-email">
                <div class="card">
                    <div class="card-body">
                        <h4>Email / SMTP</h4>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Enable Email</label> 
                                <!-- NOT in USE -->
                                <select id="smtp_enabled" class="form-control">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>SMTP Server</label>
                                <input type="text" id="smtp_server" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['mail_server'];?>">
                            </div>

                            <div class="col-md-4">
                                <label>SMTP Port</label>
                                <input type="number" id="smtp_port" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['mail_port'];?>">
                            </div>

                            <div class="col-md-6">
                                <label>Email ID</label>
                                <input type="text" id="smtp_email" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['mail_username'];?>">
                            </div>

                            <div class="col-md-6">
                                <label>Password</label>
                                <input type="text" id="smtp_password" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['mail_pass'];?>">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-success" onclick="saveEmail()">Save Email Page</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= SECURITY ================= -->
            <div class="tab-pane fade" id="tab-security">
                <div class="card">
                    <div class="card-body">
                        <h4>Security</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Allowed Login IPs</label>
                                <input type="text" id="login_ips" class="form-control" placeholder="Comma separated" value="<?php if(!empty($com[0])) echo $com[0]['login_ip_from'];?>">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-success" onclick="saveSecurity()">Save Security Page</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= DESIGN ================= -->
            <div class="tab-pane fade" id="tab-design">
                <div class="card">
                    <div class="card-body">
                        <h4>Design</h4>

                        <div class="row">
                            <div class="col-md-4">
                                <label>Header Background</label>
                                <input type="text" id="header_bg_color" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['design1_bg_color'];?>">
                            </div>

                            <div class="col-md-4">
                                <label>Header Text Color</label>
                                <input type="text" id="header_text_color" class="form-control" value="<?php if(!empty($com[0])) echo $com[0]['design1_ft_color'];?>">
                            </div>

                            <div class="col-md-4">
                                <label>Menu Type</label>
                                <select id="menu_type_design" class="form-control">
                                    <!-- NOT in USE -->
                                    <option value="Type1">Type 1</option>
                                    <option value="Type2">Type 2</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-success" onclick="saveDesign()">Save Design Page</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================= Attendance ================= -->
            <div class="tab-pane fade" id="tab-other">
                <div class="card">
                    <div class="card-body">
                        <h4>Attendance</h4>

                        <div class="col-md-12">
                            <input 
                                    type="text"
                                    id="back_date_absent"
                                    class="form-control"
                                    placeholder="YYYY-MM-DD HH:MM:SS"
                                    value="<?php if(!empty($com[0]) && $com[0]['attendance_date'] !='0000-00-00 00:00:00') echo $com[0]['attendance_date'];?>"
                                >
                                <small class="text-danger d-none" id="backDateError">
                                    Format must be YYYY-MM-DD HH:MM:SS
                                </small>
                                <!-- <br>
                                <p>
                                    Click here to put absent where attendance is blank or null
                                    <br>
                                    <a target="_blank" href="<?= base_url('index.php/Welcome/put_missing_absent') ?>">Run from <?php if(!empty($com[0]) && $com[0]['attendance_date'] !='0000-00-00 00:00:00') echo $com[0]['attendance_date'];?> </a>
                                </p> -->
                        </div>

                       


                        <div class="text-center mt-4">
                            <button class="btn btn-success" onclick="saveOther()">Save Attendance Page</button>
                        </div>
                    </div>
                </div>
            </div>

      </div>
    </div>
    </div>
</div>

<script>


function postSettings(group, data) {
    data.group = group;
    $.post("<?= base_url('index.php/Page/save_settings') ?>", data, function (res) {
        if (res === 'OK') {
            alert(group + ' settings saved');
        } else {
            alert(res);
        }
    });
}

function saveCompany() {
    postSettings('company', {
        company_name: $('#company_name').val(),
        city: $('#company_city').val(),
        state: $('#company_state').val(),
        state_code: $('#state_code').val(),
        gst: $('#company_gst').val(),
        address: $('#company_address').val()
    });
}

function savePrint() {
    postSettings('print', {
        print_email: $('#print_email').val(),
        print_mobile: $('#print_mobile').val(),
        asset_list:$('#asset_list').val()
    });
}

function saveEmail() {
    postSettings('email', {
        enabled: $('#smtp_enabled').val(),
        server: $('#smtp_server').val(),
        port: $('#smtp_port').val(),
        email: $('#smtp_email').val(),
        password: $('#smtp_password').val()
    });
}

function saveSecurity() {
    postSettings('security', {
        login_ips: $('#login_ips').val()
    });
}

function saveDesign() {
    postSettings('design', {
        header_bg: $('#header_bg_color').val(),
        header_text: $('#header_text_color').val(),
        menu_type: $('#menu_type_design').val()
    });
}

function saveOther() {

    let val = $('#back_date_absent').val().trim();

    // strict regex
    const regex = /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]) ([01]\d|2[0-3]):[0-5]\d:[0-5]\d$/;

    if (!regex.test(val)) {
        $('#backDateError').removeClass('d-none');
        $('#back_date_absent').addClass('is-invalid');
        return;
    }

    $('#backDateError').addClass('d-none');
    $('#back_date_absent').removeClass('is-invalid');

    postSettings('other', {
        back_date_absent: val,
    });
}

</script>
