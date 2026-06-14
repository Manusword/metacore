<?php 
    $login_emp_id = $this->session->userdata('login_emp_id');
    $empData = $this->Base->emp_details_from_emp_code($login_emp_id);
?>

                                        
<style>
  .celebration-box {
    max-height: 180px;   /* CARD HEIGHT CONTROL */
    overflow-y: auto;
}

.celebration-row {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 4px;
    border-bottom: 1px dashed #ddd;
    width: 220px; float:left;
}

.celebration-row:last-child {
    border-bottom: none;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    font-weight: bold;
    font-size: 14px;
}

.avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.info {
    flex: 1;
    min-width: 0;
}

.name {
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.meta {
    font-size: 11px;
    color: #666;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.icon {
    font-size: 20px;
}

.birthday .icon {
    color: #ff9800;
}

.anniversary .icon {
    color: #e91e63;
}
.bg-pink {
    background:#e83e8c !important;
}

.dashboard-widget {
    background:#fff;
    border-radius:12px;
    padding:18px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
    cursor:pointer;
    transition:.2s;
    border-left:6px solid #dee2e6;
}
.dashboard-widget:hover {
    transform:translateY(-3px);
}
.widget-title {
    font-size:13px;
    color:#6c757d;
    text-transform:uppercase;
    letter-spacing:.5px;
}
.widget-count {
    font-size:30px;
    font-weight:700;
    color:#212529;
}
.border-danger { border-left-color:#dc3545; }
.border-warning { border-left-color:#ffc107; }
.border-primary { border-left-color:#0d6efd; }
.border-success { border-left-color:#198754; }
.border-dark { border-left-color:#343a40; }
.col-md-2{margin-bottom: 10px;}

</style>



            <!-- ============ Body content start ============= -->
            <div class="main-content" >
                 

                    
    
   
                            
                    <div class="d-flex justify-content-end mb-2">
                        <input type="date"
                            id="widgetDate"
                            class="form-control form-control-sm"
                            value="<?= date('Y-m-d') ?>"
                            style="max-width:150px;">
                    </div>



                    <div class="row g-3">
                            <div class="col-md-2">
                                <div class="dashboard-widget border-danger" onclick="openLateModal('late_in')">
                                    <div class="widget-title">Late In</div>
                                    <div class="widget-count" id="late_in_count">0</div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="dashboard-widget border-primary" onclick="openLateModal('habitual_late')">
                                    <div class="widget-title"> Habitual Late</div>
                                    <div class="widget-count" id="habitual_late_count">0</div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="dashboard-widget border-warning" onclick="openLateModal('early_out')">
                                    <div class="widget-title">Early Out</div>
                                    <div class="widget-count" id="early_out_count">0</div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="dashboard-widget border-success" onclick="openLateModal('approved_leave')">
                                    <div class="widget-title">Approved Leave</div>
                                    <div class="widget-count" id="approved_leave_count">0</div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="dashboard-widget border-danger" onclick="openLateModal('unapproved_leave')">
                                    <div class="widget-title">Without Approval</div>
                                    <div class="widget-count" id="unapproved_leave_count">0</div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="dashboard-widget border-primary" onclick="openLateModal('half_day')">
                                    <div class="widget-title">Half Day</div>
                                    <div class="widget-count" id="half_day_count">0</div>
                                </div>
                            </div>
                    </div>


                    <div class="row" >

                        <div class="col-md-6 mb-4" style="margin-top:20px;">
                            <?php $this->Hrmodel->get_celebrations();?>
                        </div>
                        
                        <div class="col-md-6 mb-4" style="margin-top:10px;">
                            <?php 
                            $result=array(); 
                            $res2=array(); 
                            //$result['res2'] = $this->Maintenancemodel->get_dashboard_reminder(date('Y-m-d'));
                            //$this->load->view('maintenance/reminder/show_table_dash',$result);
                            ?>
                        </div>
                        
                    </div><!--  Row -->



                
                    <div class="card mt-4">

                        <div class="card-header  d-flex justify-content-between align-items-center" >
                          <strong>Attendance Upload Matrix: Uploaded vs Total Employees <i>(Click any date to view absent employees)</i></strong>

                          <div class="d-flex gap-2 align-items-center">
                            <input type="month" id="matrixMonth"
                                  class="form-control form-control-sm"
                                  value="<?php echo date('Y-m'); ?>">

                            <button class="btn btn-sm btn-danger" id="loadMatrixBtn">
                              Load
                            </button>
                          </div>
                        </div>

                        <div class="card-body p-0" style="overflow:auto">
                          <div id="matrixContainer">
                            <p class="text-center p-3 text-muted">
                              Select Month & Year to load data
                            </p>
                          </div>
                        </div>
                        <hr>

                        <div class="card-header d-flex justify-content-between align-items-center">
                             <strong>Attendance Details</i></strong>
                        </div>
                        <div class="card-body p-0" style="overflow:auto">
                          <div id="matrixContainer2">
                            <p class="text-center p-3 text-muted">
                              Select Month & Year to load data
                            </p>
                          </div>
                        </div>
                         

                    </div>


                    






                    <div class="row" >
                        <?php if($this->Company->checkPermission3("Hr/list_advance")){ ?>
                        <div class="col-md-12 mb-4" style="margin-top: 20px;">
                            <div class="card text-left">
                                <div class="card-body">
                                        <div class="table-responsive">
                                            <?php 
                                            $gapDays = "-35";
                                            $today = date('Y-m-d');
                                                $from_date = $this->Base->get_choise_gap_ymd($today,"$gapDays day");

                                            $advacedata = $this->Hrmodel->get_dashboard_advance($gapDays);
                                            $this->Hrmodel->get_advance_history_emp_code_table($advacedata,1);
                                            ?>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                                          
                        <?php if($this->Company->checkPermission3("Hr/list_leave")){ ?>
                        <div class="col-md-12 mb-4" style="margin-top: 20px;">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php 
                                            $leavedata = $this->Hrmodel->get_dashboard_leave();
                                            $this->Hrmodel->get_leave_history_emp_code_table($leavedata,1);
                                            //$this->Hrmodel->get_dashbord_to_display_all_diff_table_html();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div><!--  Row -->
                  
            </div><!-- end of main-content -->
      
        <!-- MODAL -->
        <div class="modal fade" id="missingModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">
                        Attendance Detail –
                        <span id="modalUnit"></span> |
                        <span id="modalDate"></span>
                        </h5>
                        <!-- <button style="float: right; margin-left:45%"  onClick="fun_export_xls()" class="btn btn-default">📥 Export Excel</button> -->
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        
                        <div id="missingModalBody">
                        <p class="text-muted text-center">Loading...</p>
                        </div>
                    </div>

                    </div>
                </div>
        </div>     

 
<script>
/* ================= CONFIG ================= */

const STATUS_COLORS = {
    P:  'bg-success text-white',
    A:  'bg-danger text-white',
    L:  'bg-danger text-white',
    R:  'bg-primary text-white',
    S:  'bg-primary text-white',
    HA: 'bg-warning text-dark',
    HL: 'bg-pink text-white',
    CL: 'bg-info text-white',
    SL: 'bg-info text-white',
    EL: 'bg-info text-white',
    H:  'bg-warning text-dark',
    OL: 'bg-warning text-dark'
};

const URLS = {
    STATUS_SUMMARY : "<?= base_url('index.php/Hr/get_attendance_status_summary') ?>",
    STATUS_EMP     : "<?= base_url('index.php/Hr/get_status_wise_employees') ?>",
    UPLOAD_MATRIX  : "<?= base_url('index.php/Hr/get_attendance_upload_matrix') ?>",
    MISSING_EMP    : "<?= base_url('index.php/Hr/get_missing_employees') ?>",
    PROFILE_EMP    : "<?= base_url('index.php/Welcome/home?Hr/profile/') ?>"
};

/* ================= HELPERS ================= */

function showModal(title, bodyHtml) {
    $('.modal-title').text(title);
    $('#missingModalBody').html(bodyHtml);
    $('#missingModal').modal('show');
}

function ajaxPost(url, data, onSuccess) {
    $.post(url, data)
        .done(res => {
            if (typeof res === 'string') res = JSON.parse(res);
            if (!res.status) {
                showModal('Error', `<div class="alert alert-danger">${res.message || 'Failed'}</div>`);
                return;
            }
            onSuccess(res);
        })
        .fail(() => {
            showModal('Server Error', `<div class="alert alert-danger">Unable to connect to server</div>`);
        });
}

function loadingHtml() {
    return `<p class="text-center text-muted">Loading...</p>`;
}

/* ================= STATUS SUMMARY ================= */

function loadStatusSummary(month, year) {

    ajaxPost(URLS.STATUS_SUMMARY, { month, year }, res => {

        let { days, data } = res;

        let html = `<table class="table table-bordered table-sm text-center">
            <thead>
                <tr>
                    <th>Status</th>`;

        for (let d = 1; d <= days; d++) html += `<th>${d}</th>`;
        html += `<th>Total</th></tr></thead><tbody>`;

        Object.keys(data).forEach(status => {

            let total = 0;
            let cls = STATUS_COLORS[status] || '';

            html += `<tr><th>${status}</th>`;

            for (let d = 1; d <= days; d++) {

                let val = data[status][d] || 0;
                total += val;

                let date = `${year}-${month.padStart(2,'0')}-${String(d).padStart(2,'0')}`;

                // 🚫 ZERO → EMPTY CELL (NO TEXT, NO COLOR, NO CLICK)
                if (val === 0) {
                    html += `<td></td>`;
                } 
                // ✅ VALUE → COLOR + CLICK
                else {
                    html += `
                        <td class="${cls} status-cell"
                            data-status="${status}"
                            data-date="${date}">
                            ${val}
                        </td>`;
                }
            }

            html += `<td><strong>${total}</strong></td></tr>`;
        });

        html += `</tbody></table>`;
        $('#matrixContainer2').html(html);
    });
}

/* ================= STATUS CELL CLICK ================= */

$(document)
.off('click.statusCell')
.on('click.statusCell', '.status-cell', function () {

    let status = $(this).data('status');
    let date   = $(this).data('date');

    showModal(`Attendance Detail – ${status} | ${date}`, loadingHtml());

    ajaxPost(URLS.STATUS_EMP, { status, date }, res => {

        if (!res.data.length) {
            showModal(`Attendance Detail – ${status} | ${date}`,
                `<div class="alert alert-info text-center">No data found</div>`);
            return;
        }

        let html = `<table class="table table-sm table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Unit</th>
                    <th>Emp Code</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Status</th>
                </tr>
            </thead><tbody>`;

        res.data.forEach((e,i) => {
            html += `
                <tr>
                    <td>${i+1}</td>
                    <td>${e.company_role || '-'}</td>
                    <td>${e.emp_code}</td>
                    <td>
                        <a target='_blank' href="${URLS.PROFILE_EMP}${e.emp_code}" class="emp-profile-link">
                            ${e.name ?? '-'}
                        </a>
                    </td>
                    <td>${e.department}</td>
                    <td>${e.designation}</td>
                    <td>${status}</td>
                </tr>`;
        });

        html += `</tbody></table>`;
        $('#missingModalBody').html(html);
    });
});

/* ================= UPLOAD MATRIX ================= */

function loadAttendanceUploadMatrix(month, year) {

    ajaxPost(URLS.UPLOAD_MATRIX, { month, year }, res => {
         renderMatrixTable(res, month, year);
    });
}


function renderMatrixTable(res, month, year) {

    if (!res || !res.units || !res.days) {
        console.error('Invalid matrix response', res);
        return;
    }

    const unitsData = res.units;
    const dates = res.days;

    let html = `
        <table class="table table-bordered table-sm text-center align-middle">
            <thead>
                <tr>
                    <th>Unit</th>
                    <th>Total Emp</th>
                    <th>Att.</th>`;

    dates.forEach(d => {
        html += `<th>${d.slice(8,10)}</th>`;
    });

    html += `</tr></thead><tbody>`;

    Object.entries(unitsData).forEach(([unit, unitRow]) => {

        const totalEmp = Number(unitRow.total_emp || 0);
        const total_emp_punch = Number(unitRow.total_emp_punch || 0);
        const daysData = unitRow.days || {};

        html += `
            <tr>
                <td><strong>${unit}</strong></td>
                <td><strong>${totalEmp}</strong></td>
                <td><strong>${total_emp_punch}</strong></td>`;

        dates.forEach(date => {

            const uploaded = Number(daysData[date] || 0);
            const percent  = totalEmp > 0
                ? Math.round((uploaded / totalEmp) * 100)
                : 0;

            let barClass = 'bg-secondary'; // ⚪ none

            if (percent === 100) barClass = 'bg-success';   // 🟢 full
            else if (percent > 0) barClass = 'bg-warning';  // 🟡 partial

            const missing = totalEmp - uploaded;

            let tooltipText = '';
            if (uploaded === 0) {
                tooltipText = 'No data uploaded';
            } else if (missing === 0) {
                tooltipText = 'All employees uploaded';
            } else {
                tooltipText = `${missing} employees missing`;
            }

            html += `
                <td class="upload-cell"
                    data-unit="${unit}"
                    data-date="${date}"
                    data-uploaded="${uploaded}"
                    data-total="${totalEmp}"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top"
                    title="${tooltipText}">

                    <div class="progress" style="height:14px;">
                        <div class="progress-bar ${barClass}"
                            role="progressbar"
                            style="width:${percent}%">
                        </div>
                    </div>
                    <small class="fw-bold">${uploaded}/${totalEmp}</small>
                </td>`;
        });

        html += `</tr>`;
    });

    html += `</tbody></table>`;
    $('#matrixContainer').html(html);
}

setTimeout(() => {
    $('[data-bs-toggle="tooltip"]').tooltip();
}, 100);


$(document)
.off('click.uploadCell')
.on('click.uploadCell', '.upload-cell', function () {

    const unit = $(this).data('unit');
    const date = $(this).data('date');

    showModal(`Upload Detail – ${unit} | ${date}`, loadingHtml());

    ajaxPost(URLS.MISSING_EMP, { unit, date }, res => {

        if (!res.data || !res.data.length) {
            $('#missingModalBody').html(
                `<div class="alert alert-info text-center">No employees found</div>`
            );
            return;
        }

        let html = `
            <table class="table table-sm table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Emp Code</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Status</th>
                    </tr>
                </thead><tbody>`;

        res.data.forEach((e,i) => {
            html += `
                <tr>
                    <td>${i+1}</td>
                    <td>${e.emp_code}</td>
                    <td align='left'>${e.first_name ?? '-'}</td>
                    <td>${e.department ?? '-'}</td>
                    <td>${e.designation ?? '-'}</td>
                    <td>${e.att_status ?? '-'}</td>
                </tr>`;
        });

        html += `</tbody></table>`;
        $('#missingModalBody').html(html);
    });
});



/* ================= MISSING CELL CLICK ================= */

$(document)
.off('click.missingCell')
.on('click.missingCell', '.missing-cell', function () {

    let unit = $(this).data('unit');
    let date = $(this).data('date');

    showModal(`Missing Attendance – ${unit} | ${date}`, loadingHtml());

    ajaxPost(URLS.MISSING_EMP, { unit, date }, res => {

        if (!res.data.length) {
            showModal(`Missing Attendance – ${unit} | ${date}`,
                `<div class="alert alert-success text-center">No missing employees</div>`);
            return;
        }

        let html = `<table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Emp Code</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Status</th>
                </tr>
            </thead><tbody>`;

        res.data.forEach((e,i) => {
            let name = `${e.first_name || ''} ${e.last_name || ''}`.trim();
            html += `
                <tr>
                    <td>${i+1}</td>
                    <td>${e.emp_code}</td>
                    <td>
                        <a align='left' target='_blank' href="${URLS.PROFILE_EMP}${e.emp_code}" class="emp-profile-link">
                            ${e.name ?? '-'}
                        </a>
                    </td>
                    <td>${e.department || '-'}</td>
                    <td>${e.designation || '-'}</td>
                    <td><span class="badge badge-danger">${e.att_status || 'Missing'}</span></td>
                </tr>`;
        });

        html += `</tbody></table>`;
        $('#missingModalBody').html(html);
    });
});

/* ================= INIT ================= */

$(document).ready(() => {

    loadLateWidgets();//load widgtets on page load

    let d = new Date();
    let month = String(d.getMonth() + 1).padStart(2,'0');
    let year  = d.getFullYear();

    // AUTO LOAD (page open par)
    loadAttendanceUploadMatrix(month, year);
    loadStatusSummary(month, year);

    // 🔥 BUTTON CLICK HANDLER (MISSING THA)
    $('#loadMatrixBtn').off('click').on('click', function () {

        let val = $('#matrixMonth').val();

        if (!val) {
            alert('Month select karo');
            return;
        }

        let [year, month] = val.split('-');

        loadAttendanceUploadMatrix(month, year);
        loadStatusSummary(month, year);
    });
});

/* ---------- GET MODAL TITLE ---------- */
function getModalTitle(type) {
    const map = {
        late_in: 'Late In',
        early_out: 'Early Out',
        approved_leave: 'Approved Leave',
        unapproved_leave: 'Unapproved Leave',
        half_day: 'Half Day',
        habitual_late: 'Habitual Late'
    };
    return map[type] || type;
}

/* ---------- LOAD WIDGET COUNTS ---------- */
function loadLateWidgets(date = null) {
    date = date || $('#widgetDate').val();

    $.post("<?= base_url('index.php/Hr/late_widgets_fun') ?>",
        { date },
        function (res) {
            if (typeof res === 'string') res = JSON.parse(res);
            if (!res.status) return;

            $('#late_in_count').text(res.data.late_in);
            $('#early_out_count').text(res.data.early_out);
            $('#approved_leave_count').text(res.data.approved_leave);
            $('#unapproved_leave_count').text(res.data.unapproved_leave);
            $('#half_day_count').text(res.data.half_day);
            $('#habitual_late_count').text(res.data.habitual_late);
        }
    );
}

$('#widgetDate').on('change', function () {
    loadLateWidgets(this.value);
});

/* ---------- HABITUAL BREAKDOWN (LAST 7 DAYS) ---------- */
function openHabitualBreakdown(emp_code, date) {
    $('#missingModal .modal-title').text(
        'Habitual Late Breakdown – ' + emp_code
    );
    $('#missingModalBody').html('<p class="text-center">Loading...</p>');

    $.post(
        "<?= base_url('index.php/Hr/habitual_late_breakdown') ?>",
        { emp_code, date },
        function (res) {
            if (typeof res === 'string') res = JSON.parse(res);

            if (!res.status || !res.data.length) {
                $('#missingModalBody').html(
                    '<div class="alert alert-info text-center">No data</div>'
                );
                return;
            }

            let html = `
            <table class="table table-sm table-bordered text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Shift In</th>
                        <th>Actual In</th>
                        <th>Late (Min)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>`;

            res.data.forEach(r => {
                html += `
                <tr>
                    <td>${r.att_date}</td>
                    <td>${r.shift}</td>
                    <td>${r.shift_in}</td>
                    <td>${r.in_time}</td>
                    <td class="text-danger fw-bold">${r.in_min_late_early}</td>
                    <td>${r.in_status}</td>
                </tr>`;
            });

            html += '</tbody></table>';
            $('#missingModalBody').html(html);
        }
    );
}

function openLateModal(type)
{
    let date = $('#widgetDate').val();
    if (!date) {
        alert('Date select karo');
        return;
    }

    $('#missingModal').modal('show');
    $('#missingModalBody').html('<p class="text-center text-muted">Loading...</p>');

    const titleMap = {
        late_in: 'Late In',
        early_out: 'Early Out',
        half_day: 'Half Day',
        habitual_late: 'Habitual Late',
        approved_leave: 'Approved Leave',
        unapproved_leave: 'Unapproved Leave'
    };

    $('#missingModal .modal-title').text(
        (titleMap[type] ?? type) + ' – ' + date
    );

    $.post(
        "<?= base_url('index.php/Hr/late_modal_data') ?>",
        { type, date },
        function(res)
        {
            if (typeof res === 'string') res = JSON.parse(res);

            if (!res.status || !res.data.length) {
                $('#missingModalBody').html(
                    '<div class="alert alert-info text-center">No data found</div>'
                );
                return;
            }

            /* 🔴 IMPORTANT FIX */
            let headCols = '';
            let rowCols  = () => '';   // 👈 DEFAULT EMPTY FUNCTION

            /* ---------- LATE IN ---------- */
            if (type === 'late_in') {
                headCols = `
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Shift In</th>
                    <th>Actual In</th>
                    <th>Late (Min)</th>`;
                
                rowCols = (e)=>`
                    <td>${e.att_date}</td>
                    <td>${e.shift}</td>
                    <td>${e.shift_in_time}</td>
                    <td>${e.actual_in_time}</td>
                    <td class="fw-bold text-danger">${e.late_minutes}</td>`;
            }

            /* ---------- EARLY OUT ---------- */
            else if (type === 'early_out') {
                headCols = `
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Shift Out</th>
                    <th>Actual Out</th>
                    <th>Early (Min)</th>`;
                
                rowCols = (e)=>`
                    <td>${e.att_date}</td>
                    <td>${e.shift}</td>
                    <td>${e.shift_out_time}</td>
                    <td>${e.actual_out_time}</td>
                    <td class="fw-bold text-warning">${e.early_minutes}</td>`;
            }

            /* ---------- HALF DAY ---------- */
            else if (type === 'half_day') {
                headCols = `
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Duty Hours</th>`;
                
                rowCols = (e)=>`
                    <td>${e.att_date}</td>
                    <td>${e.shift}</td>
                    <td class="fw-bold">${e.duty_hours}</td>`;
            }

            /* ---------- HABITUAL LATE ---------- */
            else if (type === 'habitual_late') {
                headCols = `
                    <th>Late Count</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Action</th>`;

                rowCols = (e)=>`
                    <td class="fw-bold text-danger">${e.late_count}</td>
                    <td>${e.from_date}</td>
                    <td>${e.to_date}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary"
                            onclick="openHabitualBreakdown('${e.emp_code}','${date}')">
                            View 7 Days
                        </button>
                    </td>`;
            }

            /* ---------- LEAVES ---------- */
            else if (type === 'approved_leave' || type === 'unapproved_leave') {
                headCols = `
                    <th>Mobile</th>
                    <th>Email</th>`;
                
                rowCols = (e)=>`
                    <td>${e.mob ?? '-'}</td>
                    <td>${e.email ?? '-'}</td>`;
            }

            let html = `
            <table class="table table-sm table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Emp Code</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        ${headCols}
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>`;

            res.data.forEach((e,i)=>{
                html += `
                <tr>
                    <td>${i+1}</td>
                    <td>${e.emp_code}</td>
                    <td align='left'>${e.first_name}</td>
                    <td>${e.department}</td>
                    <td>${e.designation}</td>
                    ${rowCols(e)}
                    <td>${e.remark}</td>
                </tr>`;
            });

            html += '</tbody></table>';
            $('#missingModalBody').html(html);
        }
    );
}
</script>

