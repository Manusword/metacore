<?php 
  $year = date('Y');
  $month= date('m');
?> 
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Attendance Entry Employee wise</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">

                <div class="col-md-4" >
                  <div id="csv_section" style="display:none;">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >To upload Attendance (Match with Bio ID) </div>
                                    <div class="form-row">
                                            <div class="col-md-12">
                                                  <label>Select csv/exl file</label>
                                                  <input type="file" id="csvFile" accept=".csv" class="form-control">
                                            </div>
                                              
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-info" onclick="readCSV()">
                                                            Fetch Data
                                                      </button>
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="col-md-12" id="csv_result" style="margin-top:20px;">
                                                 
                                            </div>
 
                                    </div>
                                  
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="col-md-8">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" style="color:<?php echo $this->Company->table_bg_color();?>;" >Employee Daily Attendance Card</div>
                                    <div class="form-row">
                                      
              
         
                                    
                                  <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                  <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                
                                          <div class="col-md-6" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Year</label>
                                                  <select class="form-control" name="year_search" id='year_search'>
                                                      <option value="">Select</option>
                                                      <option <?php if(!empty($year))if($year=='2025'){ echo "selected";}?>>2025</option>
                                                      <option <?php if(!empty($year))if($year=='2026'){ echo "selected";}?>>2026</option>
                                                      <option <?php if(!empty($year))if($year=='2027'){ echo "selected";}?>>2027</option>
                                                      <option <?php if(!empty($year))if($year=='2028'){ echo "selected";}?>>2028</option>
                                                      <option <?php if(!empty($year))if($year=='2029'){ echo "selected";}?>>2029</option>
                                                      <option <?php if(!empty($year))if($year=='2030'){ echo "selected";}?>>2030</option>

                                                  </select>
                                              </div>
                                            </div>


                                            <div class="col-md-6" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Month</label>
                                                  <select class="form-control" name="month_search" id="month_search">
                                                      <option value="">Select</option>
                                                      <option <?php if(!empty($month))if($month=='1'){ echo "selected";}?> value="1">Jan</option>
                                                      <option <?php if(!empty($month))if($month=='2'){ echo "selected";}?> value="2">Feb</option>
                                                      <option <?php if(!empty($month))if($month=='3'){ echo "selected";}?> value="3">Mar</option>
                                                      <option <?php if(!empty($month))if($month=='4'){ echo "selected";}?> value="4">Apr</option>
                                                      <option <?php if(!empty($month))if($month=='5'){ echo "selected";}?> value="5">May</option>
                                                      <option <?php if(!empty($month))if($month=='6'){ echo "selected";}?> value="6">Jun</option>
                                                      <option <?php if(!empty($month))if($month=='7'){ echo "selected";}?> value="7">Jul</option>
                                                      <option <?php if(!empty($month))if($month=='8'){ echo "selected";}?> value="8">Aug</option>
                                                      <option <?php if(!empty($month))if($month=='9'){ echo "selected";}?> value="9">Sep</option>
                                                      <option <?php if(!empty($month))if($month=='10'){ echo "selected";}?> value="10">Qct</option>
                                                      <option <?php if(!empty($month))if($month=='11'){ echo "selected";}?> value="11">Nov</option>
                                                      <option <?php if(!empty($month))if($month=='12'){ echo "selected";}?> value="12">Dec</option>
                                                  </select>
                                              </div>
                                            </div>


                                            <div class="col-md-4" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Emp. Code</label>
                                                <input type="text" class="form-control"    id="emp_id" required  autocomplete="off" >
                                              </div>
                                            </div>

                                            <div class="col-md-4" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label style="color:blue">Bio Code</label>
                                                <input type="text" class="form-control"    id="bio_id" required  autocomplete="off" v>
                                              </div>
                                            </div>

                                            <div class="col-md-4" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Contractor Code</label>
                                                <input type="text" class="form-control"  readonly  id="company_role" required readonly autocomplete="off">
                                              </div>
                                            </div>

                                            <input type="hidden" class="form-control"  readonly   id="erp_id" required  autocomplete="off" >
                                            

                                            <div class="col-md-4" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Name</label>
                                                <input type="text" class="form-control"    id="emp_name" required readonly autocomplete="off" >
                                              </div>
                                            </div>

                                           

                                            <div class="col-md-4" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Designation</label>
                                                <input type="text" class="form-control"    id="emp_des" required readonly  autocomplete="off" >
                                              </div>
                                            </div>



                                            <div class="col-md-4" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Department</label>
                                                <input type="text" class="form-control"    id="emp_dept" required readonly autocomplete="off" >
                                              </div>
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label style="color:red">Get Overtime</label>
                                                <input type="text" class="form-control"    id="get_overtime" required readonly autocomplete="off" >
                                              </div>
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Working Hrs(Without OT)</label>
                                                <input type="text" class="form-control"    id="working_hrs" required readonly autocomplete="off" >
                                              </div>
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Shift Status</label>
                                                <input type="text" class="form-control"    id="shift_status" required readonly autocomplete="off" >
                                              </div>
                                            </div>

                                            <div class="col-md-3" style="margin-top:10px;">
                                              <div class="form-group" >
                                                <label >Current Shift</label>
                                                <input type="text" class="form-control"    id="current_shift" required readonly autocomplete="off" >
                                              </div>
                                            </div>

                                           
 



                                            <div class="col-md-12" style="margin-top:20px" >                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="left" >
                                                      <button type="button" class="btn btn-warning" id="get_employee_attendance_date_wise" >Get Attendance Detail</button>
                                                    </div>
                                              </div>
                                            </div>   


                                            <div class="col-md-12" style="margin-top:20px" >  
                                                  <h5 align="center"> 
                                                    <b>P</b> : Present, 
                                                    <b>HA</b> : Half Day, 
                                                    <b>A</b> : Absent, 
                                                    <b>H</b> : Holiday, 
                                                    <b>S</b> : Sunday, 
                                                    <b>R</b> : Rest,
                                                    <b>L</b> : Leave,  
                                                    <b>SL</b> : Sick Leave, 
                                                    <b>CL</b> : Casual Leave,  
                                                    <b>EL</b> : Emergency Leave, 
                                                    <b>OL</b> : Other Leave(OD), 
                                                    <b>HL</b> : Half Day + Half Leave,
                                                    <b>T</b> : Extra Day through Time,
                                                   <br>
                                                    For Half Day enter A and add hours in OT Sheet.
                                                  </h5>


                                                <div class="col-md-12" style="margin-top:20px" id="dis_output">
                                                   
                                                </div> 

                                            </div>   




                                          
                                        
                          
                                      
                                      <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="emp_attendance_emp_wise_save" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<script>

  function applyColorByStatus(id2, val2)
{
    if(val2=='P')
    {
        $(id2).css({"background-color":"green","color":"white"});
    }
    else if(val2=='HA')
    {
        $(id2).css({"background-color":"orange","color":"white"});
    }
    else if(val2=='A' || val2=='L')
    {
        $(id2).css({"background-color":"red","color":"white"});
    }
    else if(val2=='H')
    {
        $(id2).css({"background-color":"yellow","color":"black"});
    }
    else if(val2=='S')
    {
        $(id2).css({"background-color":"blue","color":"white"});
    }
    else if(val2=='R' || val2=='SL' || val2=='CL' || val2=='EL' || val2=='OL')
    {
        $(id2).css({"background-color":"purple","color":"white"});
    }
    else
    {
        $(id2).css({"background-color":"white","color":"black"});
    }
}

function applyShiftByInTime(day, inTime) {

    if (!inTime || inTime === '00:00') return;

    const parts = inTime.split(':');
    if (parts.length !== 2) return;

    const hour = parseInt(parts[0], 10);
    if (isNaN(hour)) return;

    let shift = (hour >= 18) ? 'B' : 'A';

    const shiftId = `#shift_${day}`;
    if ($(shiftId).length) {
        $(shiftId).val(shift);
    }
}


// function readCSV() {

//     let year_search  = document.getElementById('year_search').value;
//     let month_search = document.getElementById('month_search').value; // 1–12
//     let bio_id  = document.getElementById('bio_id').value;
    

//     const fileInput = document.getElementById('csvFile');
//     if (!fileInput.files.length) {
//         alert("CSV file select kar");
//         return;
//     }

//     const reader = new FileReader();
//     reader.onload = function (e) {

//         const rows = e.target.result.trim().split('\n');
//         const headers = rows[0].split(',');

//        // normalize headers once (trim + remove extra spaces)
//         const cleanHeaders = headers.map(h => h ? h.toString().trim() : h);

//         const idxDate     = cleanHeaders.indexOf("AttendanceDate");
//         const idxIn       = cleanHeaders.indexOf("InTime");
//         const idxOut      = cleanHeaders.indexOf("OutTime");
//         const idxStatus   = cleanHeaders.indexOf("Status (P/A)");
//         const idxDuration = cleanHeaders.indexOf("Duration");
//         const idxOt = cleanHeaders.indexOf("Overtime");
//         const idxMin = cleanHeaders.indexOf("MIN");
//         const idxEmpCode  = cleanHeaders.indexOf("Employee Code");


//         if (idxEmpCode === -1) {
//             alert("In CSV Employee Code column missing");
//             return;
//         }

//         if (idxDate === -1 || idxStatus === -1 || idxMin === -1) {
//             alert("CSV header column missing (Date,Statue, MIN)");
//             return;
//         }

//         let data = [];

//         for (let r = 1; r < rows.length; r++) {
//           const cols = rows[r].split(',');
//           if (!cols[idxDate]) continue;

//           const csvEmpCode = cols[idxEmpCode].trim();

//           // 🚨 EMP CODE MISMATCH = STOP EVERYTHING
//           if (csvEmpCode !== bio_id) {
//               alert(
//                   `Employee Code mismatch!\n\n` +
//                   `Selected: ${bio_id}\n` +
//                   `CSV Row ${r}: ${csvEmpCode}`
//               );
//               return; // ⛔ HARD STOP
//           }

//           const dateStr = cols[idxDate].trim();
//           const parts = dateStr.split('-');
//           if (parts.length !== 3) continue;

//           const day   = parseInt(parts[0]);
//           const month = parseInt(parts[1]);
//           const year  = parseInt(parts[2]);

//           data.push({
//               dateStr,
//               day,
//               month,
//               year,
//               dateObj: new Date(year, month - 1, day),
//               status: cols[idxStatus].trim(),
//               inTime: cols[idxIn] ? cols[idxIn].trim() : '',
//               outTime: cols[idxOut] ? cols[idxOut].trim() : '',
//               duration: cols[idxDuration] ? cols[idxDuration].trim() : '0',
//               rowOT: cols[idxOt] ? cols[idxOt].trim() : '0',
//               rowMin: cols[idxMin] ? cols[idxMin].trim() : '0'
//           });
//       }
//         // Sort ASC
//         data.sort((a, b) => a.dateObj - b.dateObj);

//         let table = `
//             <table class="table table-bordered table-striped">
//                 <thead>
//                     <tr>
//                         <th>Date</th>
//                         <th>Status</th>
//                         <th>In</th>
//                         <th>Out</th>
//                         <th>Dur.</th>
//                         <th>OT</th>
//                         <th>MIN</th>
//                         <th>Remark</th>
//                     </tr>
//                 </thead>
//                 <tbody>
//         `;

//         data.forEach(row => {

//             const match =
//                 row.month == month_search &&
//                 row.year == year_search;

//             // 🔴 Red row if not matching search month/year
//             let trStyle = match ? '' : 'style="background:#f8d7da"';

//             // Fill inputs ONLY if matched
//             if (match) {

//                 let dayValue = '';
//                 if (row.status === 'P') dayValue = 'P';
//                 else if (row.status === 'A') dayValue = 'A';
//                 else if (row.status === 'WO' || row.status === 'WOP') dayValue = 'R';
//                 else if (row.status === 'S') dayValue = 'S';

//                 const dayId = `#dayentry_${row.day}`;
//                 const otId  = `#otentry_${row.day}`;
//                 const inId  = `#intime_${row.day}`;
//                 const outId = `#outtime_${row.day}`;
//                 const minId = `#mcMin_${row.day}`;
                

//                 if ($(dayId).length) {
//                     $(dayId).val(dayValue);
//                     applyColorByStatus(dayId, dayValue);   // 🔥 COLOR APPLIED
//                 }

//                 if ($(otId).length)  $(otId).val((row.status === 'WOP') ? '12' : '');
//                 //if ($(inId).length)  $(inId).val(row.inTime);
//                 if ($(inId).length) {
//                     $(inId).val(row.inTime);
//                     applyShiftByInTime(row.day, row.inTime); // 🔥 SHIFT AUTO-FILL
//                 }

//                 if ($(outId).length) $(outId).val(row.outTime);
//                 if ($(minId).length) $(minId).val(row.rowMin);
               
//             }

//             table += `
//                 <tr ${trStyle}>
//                     <td>${row.dateStr}</td>
//                     <td>${row.status}</td>
//                     <td>${row.inTime}</td>
//                     <td>${row.outTime}</td>
//                     <td>${row.duration}</td>
//                     <td>${row.idxOt}</td>
//                     <td>${row.idxMin}</td>
//                     <td>${match ? 'Matched' : 'Different Month/Year'}</td>
//                 </tr>
//             `;
//         });

//         table += `</tbody></table>`;
//         document.getElementById('csv_result').innerHTML = table;
//     };

//     reader.readAsText(fileInput.files[0]);
// }

function readCSV() {

    let year_search  = document.getElementById('year_search').value;
    let month_search = document.getElementById('month_search').value;
    let bio_id       = document.getElementById('bio_id').value;

    const fileInput = document.getElementById('csvFile');
    if (!fileInput.files.length) {
        alert("CSV file select kar");
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {

        const rows = e.target.result.trim().split(/\r?\n/);

        if (rows.length < 2) {
            alert("CSV empty hai");
            return;
        }

        const headers = rows[0].split(',');

        // normalize header
        function normalizeHeader(h) {
            return h
                .toString()
                .toLowerCase()
                .replace(/\s+/g, '')
                .replace(/[^a-z0-9]/g, '');
        }

        function findColumnIndex(headers, keywords) {
            return headers.findIndex(h =>
                keywords.some(k => h.includes(k))
            );
        }

        const normalizedHeaders = headers.map(h => normalizeHeader(h));

        const idxEmpCode  = findColumnIndex(normalizedHeaders, ["employeecode","empcode","bio"]);
        const idxDate     = findColumnIndex(normalizedHeaders, ["attendancedate","date"]);
        const idxIn       = findColumnIndex(normalizedHeaders, ["intime","in"]);
        const idxOut      = findColumnIndex(normalizedHeaders, ["outtime","out"]);
        const idxStatus   = findColumnIndex(normalizedHeaders, ["status"]);
        const idxDuration = findColumnIndex(normalizedHeaders, ["duration"]);
        const idxOt       = findColumnIndex(normalizedHeaders, ["overtime","ot"]);
        const idxMin      = findColumnIndex(normalizedHeaders, ["min","minute"]);

        let missing = [];

        if (idxEmpCode === -1) missing.push("Employee Code");
        if (idxDate === -1)    missing.push("Attendance Date");
        if (idxStatus === -1)  missing.push("Status");
        if (idxMin === -1)     missing.push("MIN");

        if (missing.length > 0) {
            alert("Missing required columns:\n\n" + missing.join("\n"));
            return;
        }

        let data = [];

        for (let r = 1; r < rows.length; r++) {

            const cols = rows[r].split(',');
            if (!cols[idxDate]) continue;

            const csvEmpCode = cols[idxEmpCode].trim();

            // HARD STOP if mismatch
            if (csvEmpCode !== bio_id) {
                alert(
                    `Employee Code mismatch!\n\n` +
                    `Selected: ${bio_id}\n` +
                    `CSV Row ${r}: ${csvEmpCode}`
                );
                return;
            }

            const dateStr = cols[idxDate].trim();
            const parts = dateStr.split('-');
            if (parts.length !== 3) continue;

            const day   = parseInt(parts[0]);
            const month = parseInt(parts[1]);
            const year  = parseInt(parts[2]);

            data.push({
                dateStr,
                day,
                month,
                year,
                dateObj: new Date(year, month - 1, day),
                status: cols[idxStatus] ? cols[idxStatus].trim() : '',
                inTime: cols[idxIn] ? cols[idxIn].trim() : '',
                outTime: cols[idxOut] ? cols[idxOut].trim() : '',
                duration: cols[idxDuration] ? cols[idxDuration].trim() : '0',
                rowOT: cols[idxOt] ? cols[idxOt].trim() : '0',
                rowMin: cols[idxMin] ? cols[idxMin].trim() : '0'
            });
        }

        // sort ascending
        data.sort((a, b) => a.dateObj - b.dateObj);

        let table = `
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Dur.</th>
                        <th>OT</th>
                        <th>MIN</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
        `;

        data.forEach(row => {

            const match =
                row.month == month_search &&
                row.year == year_search;

            let trStyle = match ? '' : 'style="background:#f8d7da"';

            if (match) {

                let dayValue = '';

                if (row.status === 'P') dayValue = 'P';
                else if (row.status === 'A') dayValue = 'A';
                else if (row.status === 'WO' || row.status === 'WOP') dayValue = 'R';
                else if (row.status === 'S') dayValue = 'S';

                const dayId = `#dayentry_${row.day}`;
                const otId  = `#otentry_${row.day}`;
                const inId  = `#intime_${row.day}`;
                const outId = `#outtime_${row.day}`;
                const minId = `#mcMin_${row.day}`;

                if ($(dayId).length) {
                    $(dayId).val(dayValue);
                    applyColorByStatus(dayId, dayValue);
                }

                if ($(otId).length)
                    $(otId).val((row.status === 'WOP') ? '12' : '');

                if ($(inId).length) {
                    $(inId).val(row.inTime);
                    applyShiftByInTime(row.day, row.inTime);
                }

                if ($(outId).length)
                    $(outId).val(row.outTime);

                if ($(minId).length)
                    $(minId).val(row.rowMin);
            }

            table += `
                <tr ${trStyle}>
                    <td>${row.dateStr}</td>
                    <td>${row.status}</td>
                    <td>${row.inTime}</td>
                    <td>${row.outTime}</td>
                    <td>${row.duration}</td>
                    <td>${row.rowOT}</td>
                    <td>${row.rowMin}</td>
                    <td>${match ? 'Matched' : 'Different Month/Year'}</td>
                </tr>
            `;
        });

        table += `</tbody></table>`;

        document.getElementById('csv_result').innerHTML = table;
    };

    reader.readAsText(fileInput.files[0]);
}
</script>


<?php $this->load->view('js/hr_js');?>


<script>
  function addPresent() {
    let total = 0;

    document.querySelectorAll('.emp_entry_at').forEach(input => {
      let val = input.value.trim().toUpperCase();

      if (val === '') return;

      // FULL DAY (1)
      const fullDay = ['P','H','S','R','SL','CL','EL','OL','1'];
      // HALF DAY (0.5)
      const halfDay = ['HA','HL'];

      if (fullDay.includes(val)) {
        total += 1;
      } else if (halfDay.includes(val)) {
        total += 0.5;
      }
      // anything else = ignored
    });

    document.getElementById('showTotalPresent').innerText = total;
  }
				
function toMinutes(h){
    h = parseFloat(h);
    if (isNaN(h)) return 0;
    return Math.round(h * 60);
}
function toHours(m){
    m = parseInt(m);
    if (isNaN(m)) return 0;
    return +(m / 60).toFixed(2);
}
function diffMinutes(inT, outT){
    if(!inT || !outT) return 0;
    let i = new Date('1970-01-01T'+inT+':00');
    let o = new Date('1970-01-01T'+outT+':00');
    if(o < i) o.setDate(o.getDate()+1);
    return Math.round((o - i) / 60000);
}

function recalcTotals(){
    let th=0, tm=0, tmc=0;

    document.querySelectorAll('.sysHrs').forEach(e=>{
        let v=parseFloat(e.value);
        if(!isNaN(v)) th+=v;
    });
    document.querySelectorAll('.sysMin').forEach(e=>{
        let v=parseInt(e.value);
        if(!isNaN(v)) tm+=v;
    });
    document.querySelectorAll('.mcMin').forEach(e=>{
        let v=parseInt(e.value);
        if(!isNaN(v)) tmc+=v;
    });

    document.getElementById('showTotalsysHrs').innerText = th.toFixed(2);
    document.getElementById('showTotalsysMin').innerText = tm;
    document.getElementById('showTotalmcMin').innerText = tmc;
}

document.addEventListener('input',function(e){
    let id=e.target.id;
    let i=id.split('_')[1];

    // sysHrs → sysMin
    if(e.target.classList.contains('sysHrs')){
        let m=toMinutes(e.target.value);
        document.getElementById('sysMin_'+i).value = m || '';
        recalcTotals();
    }

    // sysMin → sysHrs
    if(e.target.classList.contains('sysMin')){
        let h=toHours(e.target.value);
        document.getElementById('sysHrs_'+i).value = h || '';
        recalcTotals();
    }

    // mcMin total update
    if(e.target.classList.contains('mcMin')){
        recalcTotals();
    }

    // intime / outtime
    if(e.target.classList.contains('intime') || e.target.classList.contains('outtime')){
        let inT=document.getElementById('intime_'+i).value;
        let outT=document.getElementById('outtime_'+i).value;
        let m=diffMinutes(inT,outT);
        if(m>0){
            document.getElementById('sysMin_'+i).value=m;
            document.getElementById('sysHrs_'+i).value=toHours(m);
        }else{
            document.getElementById('sysMin_'+i).value='';
            document.getElementById('sysHrs_'+i).value='';
        }
        recalcTotals();
    }

    // emp_entry_at logic
    if(e.target.classList.contains('emp_entry_at')){
        let v=e.target.value.trim().toUpperCase();

        if(v==='H'){
            document.getElementById('sysHrs_'+i).value=8;
            document.getElementById('sysMin_'+i).value=480;
        }else{
            // H remove hone par reset
            document.getElementById('sysHrs_'+i).value='';
            document.getElementById('sysMin_'+i).value='';
        }
        recalcTotals();
        addPresent();
        updateLeave();
    }
});






function updateLeave(){

    let eligibleEl = document.getElementById("is_leave_eligible");
    let is_leave_eligible = eligibleEl ? eligibleEl.value : "No";

    const leaveMap = {
        "CL": { used: "cl_used", rem: "cl_rem", all: "cl_all", base: "base_cl_used", add: 1 },
        "SL": { used: "sl_used", rem: "sl_rem", all: "sl_all", base: "base_sl_used", add: 1 },
        "EL": { used: "el_used", rem: "el_rem", all: "el_all", base: "base_el_used", add: 1 },
        "HL": { used: "cl_used", rem: "cl_rem", all: "cl_all", base: "base_cl_used", add: 0.5 }
    };

    const blockedLeaves = ["CL","SL","EL","HL"];
    if(is_leave_eligible !== "Yes"){

        document.querySelectorAll('.emp_entry_at').forEach(input=>{

            let val = input.value.trim().toUpperCase();

            if(blockedLeaves.includes(val)){
                input.value = "";
            }

        });

        return; 
    }
    console.log(is_leave_eligible);

    let baseTotalEl = document.getElementById("base_total_used");
    let totalBaseUsed = baseTotalEl ? (parseFloat(baseTotalEl.value) || 0) : 0;
    let totalUsed = totalBaseUsed;

    Object.keys(leaveMap).forEach(k=>{
        let cfg = leaveMap[k];

        let baseEl = document.getElementById(cfg.base);
        let allEl  = document.getElementById(cfg.all);
        let usedEl = document.getElementById(cfg.used);
        let remEl  = document.getElementById(cfg.rem);

        if(!baseEl || !allEl || !usedEl || !remEl) return;

        let base = parseFloat(baseEl.value) || 0;
        let all  = parseFloat(allEl.innerText) || 0;

        usedEl.innerText = base.toFixed(1);
        remEl.innerText  = (all - base).toFixed(1);
    });

    // calculate current month from inputs
    document.querySelectorAll('.emp_entry_at').forEach(input=>{

        let val = input.value.trim().toUpperCase();
        if(!leaveMap[val]) return;

        let cfg = leaveMap[val];

        let usedEl = document.getElementById(cfg.used);
        let remEl  = document.getElementById(cfg.rem);
        let allEl  = document.getElementById(cfg.all);

        if(!usedEl || !remEl || !allEl) return;

        let used = parseFloat(usedEl.innerText) || 0;
        let rem  = parseFloat(remEl.innerText) || 0;
        let all  = parseFloat(allEl.innerText) || 0;

        if(rem < cfg.add){
            input.value = "";
            return;
        }

        used += cfg.add;
        rem  -= cfg.add;

        usedEl.innerText = used.toFixed(1);
        remEl.innerText  = rem.toFixed(1);

        if(used >= all){
            usedEl.classList.add("text-danger","fw-bold");
        } else {
            usedEl.classList.remove("text-danger","fw-bold");
        }

        totalUsed += cfg.add;
    });

    let totalAllEl = document.getElementById("total_all");
    if(!totalAllEl) return;

    let totalAll = parseFloat(totalAllEl.innerText) || 0;
    let totalRem = totalAll - totalUsed;

    let totalUsedEl = document.getElementById("total_used");
    let totalRemEl  = document.getElementById("total_rem");

    if(totalUsedEl) totalUsedEl.innerText = totalUsed.toFixed(1);

    if(totalRemEl){
        if(totalRem <= 0){
            totalRemEl.innerHTML = '<span class="badge bg-danger">0</span>';
        } else {
            totalRemEl.innerText = totalRem.toFixed(1);
        }
    }
}
</script>