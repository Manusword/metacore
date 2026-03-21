
        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Update Attendance in date</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    
                  <div class="col-md-3">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Select Date</div>
                                    <div class="form-row">
                                            
                                          <div class="col-md-6">
                                                <label >Company</label>
                                                <select class="form-control"  id="location" name="location" >
                                                    <option value="" >Select</option>
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
                                           
                                            <div class="col-md-6" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Select Date</label>
                                                <input type="text" class="form-control"    id="entry_date"  autocomplete="off">
                                              </div>
                                            </div>

                                            <div class="col-md-6" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Day Before</label>
                                                <input type="text" class="form-control" value="2"   id="day_before"  autocomplete="off">
                                              </div>
                                            </div>

                                            <div class="col-md-6" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Day After</label>
                                                <input type="text" class="form-control" value="2"   id="day_after"  autocomplete="off">
                                              </div>
                                            </div>
                                            
                                                   
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                                    <button type="button" class="btn btn-info" onclick="getData()">
                                                        Get Data
                                                    </button>
                                            </div>  
                                     
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                            

                   
                        <div class="card mb-4">
                                <div class="card-body">

                                    <h5 class="mb-3">Attendance Filter & Update</h5>

                                    <div class="row align-items-start">

                                        <!-- ================= LEFT ================= -->
                                        <div class="col-md-4 border-right">
                                            <h6 class="text-primary mb-2">Left Side (Before Date)</h6>

                                            <div class="filter-box">
                                                <label><input type="checkbox" class="leftFilter" value="null"> Empty</label>
                                                <label><input type="checkbox" class="leftFilter" value="P" checked> P</label>
                                                <label><input type="checkbox" class="leftFilter" value="HA"> HA</label>
                                                <label><input type="checkbox" class="leftFilter" value="R"> R</label>
                                                <label><input type="checkbox" class="leftFilter" value="H"> H</label>
                                                <label><input type="checkbox" class="leftFilter" value="S"> S</label>
                                                <label><input type="checkbox" class="leftFilter" value="A"> A</label>
                                                <label><input type="checkbox" class="leftFilter" value="L"> L</label>
                                                <label><input type="checkbox" class="leftFilter" value="OL"> OL</label>
                                                <label><input type="checkbox" class="leftFilter" value="CL"> CL</label>
                                                <label><input type="checkbox" class="leftFilter" value="SL"> SL</label>
                                                <label><input type="checkbox" class="leftFilter" value="EL"> EL</label>
                                            </div>
                                        </div>

                                        <!-- ================= CENTER ================= -->
                                     


                                       
                                        <div class="col-md-4 border-left">
                                            <h6 class="text-success mb-2">Right Side (After Date)</h6>

                                            <div class="filter-box">
                                                <label><input type="checkbox" class="rightFilter" value="null"> Empty</label>
                                                <label><input type="checkbox" class="rightFilter" value="P" checked> P</label>
                                                <label><input type="checkbox" class="rightFilter" value="HA"> HA</label>
                                                <label><input type="checkbox" class="rightFilter" value="R"> R</label>
                                                <label><input type="checkbox" class="rightFilter" value="H"> H</label>
                                                <label><input type="checkbox" class="rightFilter" value="S"> S</label>
                                                <label><input type="checkbox" class="rightFilter" value="A"> A</label>
                                                <label><input type="checkbox" class="rightFilter" value="L"> L</label>
                                                <label><input type="checkbox" class="rightFilter" value="OL"> OL</label>
                                                <label><input type="checkbox" class="rightFilter" value="CL"> CL</label>
                                                <label><input type="checkbox" class="rightFilter" value="SL"> SL</label>
                                                <label><input type="checkbox" class="rightFilter" value="EL"> EL</label>
                                            </div>
                                        </div>

                                         <!-- ================= RIGHT ================= -->
                                         <div class="col-md-4">


                                                    <!-- PART 1 : FROM CURRENT DAY -->
                                                   
                                                        <h6 class="text-dark font-weight-bold mb-2">
                                                            From 
                                                        </h6>
                                                        <select id="fromCurrentDay" class="form-control">
                                                            <option value="">Select Condition</option>
                                                            <option value="P">Present (P)</option>
                                                            <option value="HA">Half Day (HA)</option>
                                                            <option value="R">Rest Day (R)</option>
                                                            <option value="H">Holiday (H)</option>
                                                            <option value="S">Sunday (S)</option>
                                                            <option value="A">Absent (A)</option>
                                                            <option value="L">Leave (L)</option>
                                                            <option value="OL">OD (OL)</option>
                                                            <option value="CL">CL</option>
                                                            <option value="SL">SL</option>
                                                            <option value="EL">EL</option>
                                                            <option value="Blank">Blank</option>
                                                            <option selected value="Anything">Anything</option>
                                                        </select>
                                                   
                                                        <h6 class="text-dark font-weight-bold  mt-2 ">
                                                            To 
                                                        </h6>
                                                        <select id="setDay" class="form-control">
                                                            <option value="">Select New Value</option>
                                                            <option value="P">Present (P)</option>
                                                            <option value="HA">Half Day (HA)</option>
                                                            <option value="R">Rest Day (R)</option>
                                                            <option value="H">Holiday (H)</option>
                                                            <option value="S">Sunday (S)</option>
                                                            <option value="A">Absent (A)</option>
                                                            <option value="L">Leave (L)</option>
                                                            <option value="OL">OD (OL)</option>
                                                            <option value="CL">CL</option>
                                                            <option value="SL">SL</option>
                                                            <option value="EL">EL</option>
                                                            <option value="Blank">Blank</option>
                                                        </select>
                                                   

                                                    <hr>

                                                    <!-- PART 3 : UPLOAD -->
                                                    <div class="text-center">
                                                        <button class="btn btn-success btn-block" id="uploadBtn">
                                                            <i class="fa fa-upload mr-1"></i> Upload Attendance
                                                        </button>

                                                        <small class="text-muted d-block mt-2">
                                                            Only checked rows will be uploaded
                                                        </small>
                                                    </div>

                                            
                                        </div>

                                    </div>

                                    <hr>
                                    <div id="table_show"></div>

                                </div>
                            </div>
                        </div>

              
                    
        </div><!-- end of main-content -->   






<script>


$('#uploadBtn').on('click', function () {

    let setDay = $('#setDay').val();
    if (!setDay) {
        alert('Select Set Day value first');
        return;
    }

    let entry_date = $('#entry_date').val(); // DD-MM-YYYY
    let rows = [];

    

    $('#table_show .rowCheck:checked').each(function () {

        let attMonthlyId = $(this).val(); // ✅ THIS IS THE ID

        if (!attMonthlyId) return;

        rows.push({
            att_monthly_id: attMonthlyId,
            entry_date: entry_date,
            new_value: setDay
        });
    });

    console.log($('#table_show .rowCheck:checked').map((i,e)=>e.value).get());


    if (!rows.length) {
        alert('No valid rows selected');
        return;
    }

    if (!confirm('Confirm upload for selected employees?')) return;

    $.ajax({
        url: "<?= base_url().'index.php/Hr/attendance_entry_day_fix_save'; ?>",
        type: "POST",
        dataType: "json",
        data: { rows: rows },
        success: function (res) {
            if (!res || !res.status) {
                alert(res?.message || 'Failed');
                return;
            }
            alert('Attendance updated successfully');
            getData();
        },
        error: function () {
            alert('Server error');
        }
    });
});





/* ================== DATE HELPERS ================== */
function dmyToYmd(dmy) {
    let p = dmy.split('-');
    return `${p[2]}-${p[1]}-${p[0]}`;
}
function ymdToDmy(ymd) {
    let p = ymd.split('-');
    return `${p[2]}-${p[1]}-${p[0]}`;
}


/* ================== DATA LOAD ================== */
function getData() {

     let location       = $('#location').val();
    let entry_date_raw = $('#entry_date').val();
    let day_before     = $('#day_before').val();
    let day_after      = $('#day_after').val();

    // 🔴 HARD VALIDATION
    if (!location) {
        alert('Please select Company');
        return;
    }

    if (!entry_date_raw) {
        alert('Please select Entry Date');
        return;
    }

    if (day_before === '' || day_before === null) {
        alert('Please enter Day Before value');
        return;
    }

    if (day_after === '' || day_after === null) {
        alert('Please enter Day After value');
        return;
    }

    // 🔴 Numeric check (optional but sane)
    if (isNaN(day_before) || isNaN(day_after)) {
        alert('Day Before / Day After must be numbers');
        return;
    }

    let entryYMD = dmyToYmd(entry_date_raw);

    $.post(
        "<?= base_url().'index.php/Hr/get_employee_attendance_date_wise2'; ?>",
        { location, entry_date: entry_date_raw, day_before, day_after },
        function (res) {

            if (typeof res === 'string') res = JSON.parse(res);
            if (!res.status) {
                $('#table_show').html('No data');
                return;
            }

            let raw   = res.data;
            let dates = Object.keys(raw).sort();

            let employees = {};

            dates.forEach(d => {
                raw[d].forEach(e => {
                    if (!employees[e.emp_code]) {
                        employees[e.emp_code] = {
                            emp_code: e.emp_code,
                            name: (e.first_name + ' ' + e.last_name).trim(),
                            dept: e.dname,
                            att: {}
                        };
                    }
                    employees[e.emp_code].att[d] = {
                        status: e.emp_at_day || '',
                        att_monthly_id: e.att_monthly_id   
                    };
                });
            });

            function attHtml(s) {
                if (!s) return '';
                let c = (s === 'P') ? 'green' : (s === 'A') ? 'red' : 'blue';
                return `<span class="att-val" style="color:${c};font-weight:bold">${s}</span>`;
            }

            let html = `<table class="table table-bordered table-sm">
                        <thead><tr>
                        <th>#</th><th>Code</th><th>Name</th><th>Dept</th>`;

            dates.forEach(d => {
                let bg = d === entryYMD ? 'style="background:#fff3cd"' : '';
                html += `<th ${bg}>${ymdToDmy(d)}</th>`;
            });

            html += `</tr></thead><tbody>`;

            let i = 1;

            Object.values(employees).forEach(emp => {

                let entryAttId = emp.att[entryYMD]?.att_monthly_id || '';

                html += `<tr 
                    data-att='${JSON.stringify(emp.att)}'
                    data-att-id="${entryAttId}"
                >
                    <td>
                        <input 
                            type="checkbox" 
                            class="rowCheck" 
                            value="${entryAttId}"
                        > ${i++}
                    </td>
                    <td>${emp.emp_code}</td>
                    <td>${emp.name}</td>
                    <td>${emp.dept}</td>`;

                dates.forEach(d => {
                    let bg   = d === entryYMD ? 'style="background:#fff3cd"' : '';
                    let mark = d === entryYMD ? 'data-entry="1"' : '';
                    let a    = emp.att[d] || {};
                    html += `<td ${bg} ${mark}>${attHtml(a.status)}</td>`;
                });

                html += `</tr>`;
            });

            html += `</tbody></table>`;
            $('#table_show').html(html);
            setTimeout(applyCombinedFilter, 0);
        }
    );
  
}





/* ================== HELPERS ================== */
function getTableDates() {
    let arr = [];
    $('#table_show thead th').each(function (i) {
        if (i >= 4) {
            let p = $(this).text().trim().split('-');
            arr.push(`${p[2]}-${p[1]}-${p[0]}`);
        }
    });
    return arr;
}

function clearPreview() {
    $('#table_show tbody tr').each(function () {
        $(this).find('.rowCheck').prop('checked', false);
        $(this).css('background', '');
        let cell = $(this).find('td[data-entry="1"]');
        cell.find('.setday-badge').remove();
    });
}

function makeBadge(v) {
    return `<span class="badge badge-info ml-1 setday-badge">${v}</span>`;
}

/* ================== FILTER CORE ================== */
function applyCombinedFilter() {

    let setDay = $('#setDay').val();
    //if (!setDay) return; // upload se pehle alert aayega

    let fromCurrent = $('#fromCurrentDay').val();

    let leftDays  = parseInt($('#day_before').val(), 10) || 0;
    let rightDays = parseInt($('#day_after').val(), 10) || 0;

    let leftSel  = $('.leftFilter:checked').map((i,e)=>e.value).get();
    let rightSel = $('.rightFilter:checked').map((i,e)=>e.value).get();

    // kuch bhi select nahi → clear
    if (!leftSel.length && !rightSel.length) {
        clearPreview();
        return;
    }
    
    let dates    = getTableDates();
    let entryYMD = dmyToYmd($('#entry_date').val());
    let idx      = dates.indexOf(entryYMD);
    if (idx === -1) return;

    $('#table_show tbody tr').each(function () {

        let row = $(this);
        let att = JSON.parse(row.attr('data-att'));

        /* ================= CENTER FILTER ================= */
        let centerStatus = att[entryYMD]?.status || '';

        let centerMatch = true;

        if (fromCurrent && fromCurrent !== 'Anything') {
            if (fromCurrent === 'Blank') {
                centerMatch = !centerStatus;
            } else {
                centerMatch = centerStatus === fromCurrent;
            }
        }

        /* ================= LEFT FILTER ================= */
        let leftHit = false;
        if (leftDays && leftSel.length) {
            for (let i = 1; i <= leftDays; i++) {
                let d = dates[idx - i];
                if (!d) continue;
                if (leftSel.includes(att[d]?.status || 'null')) {
                    leftHit = true;
                    break;
                }
            }
        }

        /* ================= RIGHT FILTER ================= */
        let rightHit = false;
        if (rightDays && rightSel.length) {
            for (let i = 1; i <= rightDays; i++) {
                let d = dates[idx + i];
                if (!d) continue;
                if (rightSel.includes(att[d]?.status || 'null')) {
                    rightHit = true;
                    break;
                }
            }
        }

        let finalMatch = centerMatch && (leftHit || rightHit);

        let cell = row.find('td[data-entry="1"]');
        cell.find('.setday-badge').remove();

        if (finalMatch) {
            row.find('.rowCheck').prop('checked', true);
            row.css('background', '#d4edda');
            cell.append(makeBadge(setDay));
        } else {
            row.find('.rowCheck').prop('checked', false);
            row.css('background', '');
        }
    });
}


/* ================== EVENTS ================== */
$(document).on('change', '.leftFilter, .rightFilter', applyCombinedFilter);
$(document).on(
    'keyup change',
    '#day_before, #day_after, #setDay, #fromCurrentDay',
    applyCombinedFilter
);


</script>


<?php $this->load->view('js/hr_js');?>