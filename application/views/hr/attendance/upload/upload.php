<style>
.invalid-cell{
    background:#f8d7da !important;
    color:#721c24;
    font-weight:600;
}
</style>
        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Upload Employee Attendance</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    
                  <div class="col-md-3">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Select Your File</div>
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

                                            <br>
                                            <br>
                                             <div class="col-md-12" style="margin-top:50px;">     
                                                <p>
                                                    
                                                    <ul>
                                                        <li><b>Table column must have:</b></li>
                                                        <li>Employee Code <span style='color:blue'>Bio-code</span></li>
                                                        <li>AttendanceDate <span style='color:blue'>DD-MM-YYYY</span></li>
                                                        <li>InTime</li>
                                                        <li>OutTime</li>
                                                        <li>Status (P/A)</li>
                                                        <li>Duration <span style='color:blue'>Number</span></li>
                                                        <li>Overtime <span style='color:blue'>Number</span></li>
                                                        <li>MIN <span style='color:blue'>Number</span></li>
                                                        <li>PunchRecords</li>
                                                        <li>Department</li>
                                                        <li>Designation</li>
                                                        <li>Company</li>
                                                        <li>Employee Name</li>
                                                    </ul>
                                                </p>
                                            </div>  
                                           
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>

                   
                    <div class="col-md-9">
                         <div class="card mb-4" id="outputBox" >    
                              <div class="card-body">
                                    <div class="card-title" >Data After Trim</div>
                                    <div class="card-body">

                                            <button type="button" class="btn btn-warning" id="verifyBtn" onclick="verifyData()">
                                                Verify Data
                                            </button>
                                            <div id="verifyStatus" style="display:none; margin-top:10px;">
                                                <div class="spinner spinner-warning mr-2"></div>
                                                <span id="verifyText">Verifying data...</span>
                                            </div>

                                            <button type="button" class="btn btn-success" id="uploadBtn" onclick="upload_data2()" style="display:none;">
                                                Upload to Save
                                            </button>

                                            <div class="progress" style="height:25px; display:none; margin-top:10px" id="progressBox">
                                                <div 
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                        id="progressBar"
                                                        role="progressbar"
                                                        style="width:0%; height:25px;">
                                                        0%
                                                </div>
                                            </div>
    
                                            <button type="button" class="btn btn-danger" onclick="downloadErrorCSV()" id="downloadErrorBtn" style="display:none;">
                                                Download Failed CSV
                                            </button>

                                            <button type="button" class="btn btn-warning" onclick="retryFailedRows()" id="retryFailedBtn" style="display:none;">
                                                Retry Failed Rows
                                            </button>
                                    </div>
                                    <div id="response_message"></div>


                                    <div id="table_show" style="margin-top:10px">
                                           <table> 							
                                                <tr>
                                                      <th>S.No</th>
                                                      <th>Attendance Date</th>
                                                      <th>Employee Name</th>
                                                      <th>Department</th>
                                                      <th>In Time</th>
                                                      <th>Out Time</th>
                                                      <th>Duration</th>
                                                      <th>Status Code</th>
                                                </tr>
                                          </table>
                                    </div>

                                   

                                 
                             
                    </div>
                    
                </div><!-- end of main-content -->   




<script>
let successCount = 0;
let errorCount   = 0;
let errorRows    = [];
let failedQueue  = [];



/* ================= CSV READ ================= */

function readCSV() {

    document.getElementById("uploadBtn").style.display = "none";
    document.getElementById("progressBox").style.display = "none";

    const fileInput = document.getElementById('csvFile');
    if (!fileInput.files.length) {
        alert("Select CSV");
        return;
    }

    const reader = new FileReader();

    reader.onload = function (e) {

        const lines = e.target.result.replace(/\r/g, '').trim().split("\n");
        const headers = lines[0].split(",").map(h => h.trim());

        const normHeaders = headers.map(normalizeHeader);

        const dateIndex = normHeaders.indexOf("attendancedate");
        if (dateIndex === -1) {
            alert("AttendanceDate column missing");
            return;
        }

        /* ===== BUILD ROW OBJECTS ===== */
        let rows = [];

        for (let i = 1; i < lines.length; i++) {
            if (!lines[i].trim()) continue;

            const cols = lines[i].split(",").map(c => c.trim());

            rows.push({
                raw  : cols,
                date : convertDate(cols[dateIndex]) // YYYY-MM-DD
            });
        }

        /* ===== DATE WISE ASC SORT ===== */
        rows.sort((a, b) => a.date.localeCompare(b.date));

        /* ===== BUILD TABLE ===== */
        let html = `<table class="table table-bordered table-sm">
            <thead><tr>`;

        headers.forEach(h => html += `<th>${h}</th>`);
        html += `</tr></thead><tbody>`;

        rows.forEach(r => {
            html += `<tr>`;
            r.raw.forEach(c => html += `<td>${c}</td>`);
            html += `</tr>`;
        });

        html += `</tbody></table>`;

        document.getElementById("table_show").innerHTML = html;
    };

    reader.readAsText(fileInput.files[0]);
}




function downloadErrorCSV() {

    if (!errorRows.length) {
        alert("No failed records");
        return;
    }

    let csv = "Employee Code,Date,In Time,Out Time,Error\n";

    errorRows.forEach(r => {
        csv += `${r.emp},${r.date},${r.inT ?? ''},${r.outT ?? ''},"${r.error}"\n`;
    });

    const blob = new Blob([csv], { type: "text/csv" });
    const url  = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = "attendance_failed.csv";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}




/* ================= HELPERS ================= */
function updateProgress(done, total) {
    const percent = Math.round((done / total) * 100);
    const bar = document.getElementById("progressBar");

    // width + text
    bar.style.width = percent + "%";
    bar.innerText = percent + "%";

    // remove all bootstrap bg classes
    bar.classList.remove(
        "bg-primary",
        "bg-info",
        "bg-warning",
        "bg-success"
    );

    // color logic
    if (percent <= 40) {
        bar.classList.add("bg-primary");
    } else if (percent <= 70) {
        bar.classList.add("bg-info");
    } else if (percent < 100) {
        bar.classList.add("bg-warning");
    } else {
        bar.classList.add("bg-success"); // ONLY 100%
    }
}


function isAllowedStatus(s) {
    if (!s) return false;
    s = s.trim().toUpperCase();
    return ["P","A","WO","WOP","½P"].includes(s);
}

function isValidTime(t) {
    if (!t) return null;
    t = t.trim();
    return (t === "00:00" || t === "00:00:00") ? null : t;
}

function convertDate(d) {
    const [dd, mm, yyyy] = d.trim().split("-");
    return `${yyyy}-${mm}-${dd}`;
}

function normalizeHeader(h) {
    return h.toLowerCase().replace(/\s+/g,'').replace(/[^a-z]/g,'');
}

/* ================= API ================= */
function callAttendanceAPI(payload) {
    return fetch("<?php echo base_url('index.php/Welcome/emp_attend_api2')?>", {
        method : "POST",
        headers: { "Content-Type": "application/json" },
        body   : JSON.stringify(payload)
    }).then(r => r.json());
}

function normalizeTime(t) {
    if (!t) return "00:00";
    t = t.trim();
    return t === "" ? "00:00" : t;
}


/* ================= UPLOAD ================= */
async function upload_data2() {

    const table = document.querySelector("#table_show table");
    if (!table) return alert("Table missing");

    const headers = [...table.querySelectorAll("thead th")]
        .map(th => normalizeHeader(th.innerText));

    const COL = {
        emp     : headers.indexOf("employeecode"),
        date    : headers.indexOf("attendancedate"),
        inT     : headers.indexOf("intime"),
        outT    : headers.indexOf("outtime"),
        status  : headers.indexOf("statuspa"),
        company : headers.indexOf("company"),
        dutyTime : headers.indexOf("min")
    };

    
    if (Object.values(COL).includes(-1))
        return alert("CSV header mismatch");

    const rows  = [...table.querySelectorAll("tbody tr")];
    const total = rows.length;

    successCount = errorCount = 0;
    errorRows = failedQueue = [];

    document.getElementById("progressBox").style.display = "block";

    let done = 0;

    for (const row of rows) {

        const td = row.querySelectorAll("td");
        const status = td[COL.status].innerText.trim().toUpperCase();

        // if (!isAllowedStatus(status)) {
        //     updateProgress(++done, total);
        //     continue;
        // }

       const payload = {
            bio_code       : td[COL.emp].innerText.trim(),
            attendanceDate : convertDate(td[COL.date].innerText),
            in_time        : normalizeTime(td[COL.inT].innerText),
            out_time       : normalizeTime(td[COL.outT].innerText),
            status         : td[COL.status].innerText.trim().toUpperCase(),
            company        : td[COL.company].innerText.trim(),
            dutyMin        : td[COL.dutyTime].innerText.trim()
        };


        try {
            const res = await callAttendanceAPI(payload);

            if (res.status === "success") {
                row.style.background = "#d4edda";
                successCount++;
            } else {
                throw res.message;
            }

        } catch (err) {
            row.style.background = "#f8d7da";
            errorCount++;

            payload.error = err;
            payload.rowEl = row;

            errorRows.push(payload);
            failedQueue.push(payload);
        }

        updateProgress(++done, total);
    }

    buildErrorTable();
    showSummary(total);
    toggleErrorButtons();
}

/* ================= RETRY ================= */
async function retryFailedRows() {

    if (!failedQueue.length) return alert("No failed rows");

    const retry = [...failedQueue];
    failedQueue = [];
    errorRows   = [];
    errorCount  = 0;

    let done = 0;
    const total = retry.length;

    for (const r of retry) {
        try {
            const res = await callAttendanceAPI(r);

            if (res.status === "success") {
                r.rowEl.style.background = "#d4edda";
                successCount++;
            } else {
                throw res.message;
            }

        } catch (err) {
            r.rowEl.style.background = "#f8d7da";
            r.error = err;
            errorRows.push(r);
            failedQueue.push(r);
            errorCount++;
        }

        updateProgress(++done, total);
    }

    buildErrorTable();
    toggleErrorButtons();
}

/* ================= UI ================= */
function buildErrorTable() {

    if (!errorRows.length) return;

    let html = `<h5 style="color:red">Failed Records</h5>
    <table class="table table-sm table-bordered">
    <tr><th>Emp</th><th>Date</th><th>In</th><th>Out</th><th>Error</th></tr>`;

    errorRows.forEach(r => {
        html += `<tr>
            <td>${r.bio_code}</td>
            <td>${r.attendanceDate}</td>
            <td>${r.in_time ?? ''}</td>
            <td>${r.out_time ?? ''}</td>
            <td style="color:red">${r.error}</td>
        </tr>`;
    });

    html += `</table>`;
    document.getElementById("response_message").innerHTML = html;
}

function showSummary(total) {
    document.getElementById("response_message").innerHTML =
    `<div class="alert alert-info">
        <b>Total Records:</b> ${total}<br>
        <b style="color:green">Success:</b> ${successCount}<br>
        <b style="color:red">Failed:</b> ${errorCount}
    </div>` + document.getElementById("response_message").innerHTML;
}

function toggleErrorButtons() {
    document.getElementById("retryFailedBtn").style.display =
        failedQueue.length ? "inline-block" : "none";
}


function isValidDateDDMMYYYY(d) {
    return /^\d{2}-\d{2}-\d{4}$/.test(d);
}

function isValidTime24(t) {
    return /^([01]\d|2[0-3]):[0-5]\d$/.test(t);
}

function isValidMin(m) {
    if (m === "") return true;
    if (m === "0") return true;
    return !isNaN(m);
}



// async function verifyData1() {

//     const table = document.querySelector("#table_show table");
//     if (!table) {
//         alert("No data found");
//         return;
//     }

//     const headers = [...table.querySelectorAll("thead th")]
//         .map(th => normalizeHeader(th.innerText));

//     const COL = {
//         date   : headers.indexOf("attendancedate"),
//         inT    : headers.indexOf("intime"),
//         outT   : headers.indexOf("outtime"),
//         status : headers.indexOf("statuspa"),
//         min    : headers.indexOf("min")
//     };

//     const rows = [...table.querySelectorAll("tbody tr")];
//     const total = rows.length;

//     let hasError = false;
//     let checked  = 0;

//     // show loader
//     document.getElementById("verifyStatus").style.display = "block";
//     document.getElementById("verifyText").innerText = `Verifying 0 / ${total}`;

//     document.getElementById("uploadBtn").style.display = "none";

//     const BATCH_SIZE = 200; // tune this if needed

//     for (let i = 0; i < rows.length; i += BATCH_SIZE) {

//         const batch = rows.slice(i, i + BATCH_SIZE);

//         batch.forEach(row => {

//             const td = row.querySelectorAll("td");
//             td.forEach(c => c.classList.remove("invalid-cell"));

//             const date   = td[COL.date]?.innerText.trim();
//             const inT    = td[COL.inT]?.innerText.trim();
//             const outT   = td[COL.outT]?.innerText.trim();
//             const status = td[COL.status]?.innerText.trim();
//             const min    = td[COL.min]?.innerText.trim();

//             if (!isValidDateDDMMYYYY(date)) {
//                 td[COL.date].classList.add("invalid-cell");
//                 hasError = true;
//             }

//             if (inT && !isValidTime24(inT)) {
//                 td[COL.inT].classList.add("invalid-cell");
//                 hasError = true;
//             }

//             if (outT && !isValidTime24(outT)) {
//                 td[COL.outT].classList.add("invalid-cell");
//                 hasError = true;
//             }

//             if (!status) {
//                 td[COL.status].classList.add("invalid-cell");
//                 hasError = true;
//             }

//             if (!isValidMin(min)) {
//                 td[COL.min].classList.add("invalid-cell");
//                 hasError = true;
//             }

//             checked++;
//         });

//         // update counter
//         document.getElementById("verifyText").innerText =
//             `Verifying ${checked} / ${total}`;

//         // allow UI to breathe
//         await new Promise(r => setTimeout(r, 0));
//     }

//     // hide loader
//     document.getElementById("verifyStatus").style.display = "none";

//     if (hasError) {
//         alert("Invalid data found. Fix highlighted cells before uploading.");
//     } else {
//         //alert("All data verified successfully. You can upload now.");
//         document.getElementById("uploadBtn").style.display = "inline-block";
//         document.getElementById("progressBox").style.display = "block";
//     }
// }

function findColumnIndex(headers, keywords) {
    return headers.findIndex(h =>
        keywords.some(k => h.includes(k))
    );
}

async function verifyData() {

    const table = document.querySelector("#table_show table");
    if (!table) {
        alert("No data found");
        return;
    }


    const headers = [...table.querySelectorAll("thead th")]
    .map(th => normalizeHeader(th.innerText));

    const COL = {
        date   : findColumnIndex(headers, ["attendancedate", "date"]),
        inT    : findColumnIndex(headers, ["intime", "in"]),
        outT   : findColumnIndex(headers, ["outtime", "out"]),
        status : findColumnIndex(headers, ["status", "pa"]),
        min    : findColumnIndex(headers, ["min", "minute"])
    };

    const missing = [];

    if (COL.date === -1)   missing.push("Attendance Date");
    if (COL.inT === -1)    missing.push("In Time");
    if (COL.outT === -1)   missing.push("Out Time");
    if (COL.status === -1) missing.push("Status");
    if (COL.min === -1)    missing.push("Min");

    if (missing.length > 0) {
        alert("Missing required columns:\n\n" + missing.join("\n"));
        return;
    }

    // // 🔴 HARD STOP if header mismatch
    // if (Object.values(COL).includes(-1)) {
    //     alert("CSV header mismatch. Required columns missing.");
    //     return;
    // }

    const rows = [...table.querySelectorAll("tbody tr")];
    const total = rows.length;

    let hasError = false;
    let checked  = 0;

    document.getElementById("verifyStatus").style.display = "block";
    document.getElementById("verifyText").innerText = `Verifying 0 / ${total}`;
    document.getElementById("uploadBtn").style.display = "none";

    const BATCH_SIZE = 200;

    for (let i = 0; i < rows.length; i += BATCH_SIZE) {

        const batch = rows.slice(i, i + BATCH_SIZE);

        batch.forEach(row => {

            const td = row.querySelectorAll("td");
            td.forEach(c => c.classList.remove("invalid-cell"));

            const date   = td[COL.date]?.innerText.trim()   || "";
            const inT    = td[COL.inT]?.innerText.trim()    || "";
            const outT   = td[COL.outT]?.innerText.trim()   || "";
            const status = td[COL.status]?.innerText.trim() || "";
            const min    = td[COL.min]?.innerText.trim()    || "";

            if (!isValidDateDDMMYYYY(date)) {
                td[COL.date]?.classList.add("invalid-cell");
                hasError = true;
            }

            if (inT && !isValidTime24(inT)) {
                td[COL.inT]?.classList.add("invalid-cell");
                hasError = true;
            }

            if (outT && !isValidTime24(outT)) {
                td[COL.outT]?.classList.add("invalid-cell");
                hasError = true;
            }

            if (!status) {
                td[COL.status]?.classList.add("invalid-cell");
                hasError = true;
            }

            if (!isValidMin(min)) {
                td[COL.min]?.classList.add("invalid-cell");
                hasError = true;
            }

            checked++;
        });

        document.getElementById("verifyText").innerText =
            `Verifying ${checked} / ${total}`;

        await new Promise(r => setTimeout(r, 0));
    }

    document.getElementById("verifyStatus").style.display = "none";

    if (hasError) {
        alert("Invalid data found. Fix highlighted cells before uploading.");
    } else {
        document.getElementById("uploadBtn").style.display = "inline-block";
    }
}
</script>



