
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
                                     
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                         <div class="card mb-4" id="outputBox" >    
                              <div class="card-body">
                                    <div class="card-title" >Data After Trim</div>
                                    <div class="card-body">

                                            <button type="button" class="btn btn-success"  onclick="upload_data2()">Upload to Save</button>
                                            
                                            <div class="progress" style="height:25px; display:none; margin-top:10px" id="progressBox">
                                                <div 
                                                        class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                        id="progressBar"
                                                        role="progressbar"
                                                        style="width:0%">
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


/* ================= PROGRESS ================= */
function updateProgress(done, total) {
    const percent = total ? Math.round((done / total) * 100) : 100;
    const bar = document.getElementById("progressBar");
    bar.style.width = percent + "%";
    bar.innerText = percent + "%";
}

/* ================= VALIDATIONS ================= */
function isValidTime(t) {
    if (!t) return false;
    t = t.trim();
    return !(t === "00:00" || t === "00:00:00");
}

function isAllowedStatus(s) {
    if (!s) return false;
    s = s.trim().toUpperCase();
    return (s === "P" || s === "WOP" || s === "½P");
}

/* ================= DATE FIX ================= */
// CSV: 15-12-2025 → 2025-12-15
function convertDate(d) {
    const [dd, mm, yyyy] = d.trim().split("-");
    return `${yyyy}-${mm}-${dd}`;
}

/* ================= API ================= */
function callAPI(empCode, dateTime, baseUrl) {
    const url = `${baseUrl}?bio_code=${encodeURIComponent(empCode)}&date_time=${encodeURIComponent(dateTime)}`;

    return fetch(url)
        .then(r => {
            if (!r.ok) throw new Error("HTTP " + r.status);
            return r.json();
        })
        .then(res => {
            //console.log("API RESPONSE:", res);

            if (res.status !== 'success') {
                console.error("Attendance Failed:", res.message);
            }

            return res;
        })
        .catch(err => {
            console.error("API FAIL:", err);
            throw err;
        });
}


/* ================= CSV READ ================= */

function readCSV() {

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



/* ================= HEADER NORMALIZE ================= */
function normalizeHeader(h) {
    return h
        .toLowerCase()
        .replace(/\s+/g, '')
        .replace(/[^a-z]/g, '');
}

/* ================= UPLOAD ================= */
async function upload_data2() {

    const table = document.querySelector("#table_show table");
    if (!table) {
        alert("Table nahi bani");
        return;
    }

    const baseUrl = "<?php echo base_url().'index.php/Welcome/emp_attend_api'?>";

    const rawHeaders = [...table.querySelectorAll("thead th")]
        .map(th => th.innerText.trim());

    const headers = rawHeaders.map(normalizeHeader);

    const COL = {
        emp    : headers.indexOf("employeecode"),
        date   : headers.indexOf("attendancedate"),
        inT    : headers.indexOf("intime"),
        outT   : headers.indexOf("outtime"),
        status : headers.indexOf("statuspa")
    };

    if (Object.values(COL).includes(-1)) {
        alert("CSV header mismatch");
        return;
    }

    let rows = [...table.querySelectorAll("tbody tr")];

    /* ================= PREPARE DATA ================= */
    let data = [];

    rows.forEach((row, index) => {

        const td = row.querySelectorAll("td");
        const status = td[COL.status].innerText;

        if (!isAllowedStatus(status)) return;

        const date = convertDate(td[COL.date].innerText.trim());

        data.push({
            rowIndex : index,
            rowEl    : row,
            emp      : td[COL.emp].innerText.trim(),
            date     : date,
            inT      : isValidTime(td[COL.inT].innerText)  ? td[COL.inT].innerText.trim()  : null,
            outT     : isValidTime(td[COL.outT].innerText) ? td[COL.outT].innerText.trim() : null
        });
    });
   
    if (!data.length) {
        alert("Not Found Valid data");
        return;
    }

    /* ================= COUNT ================= */
    let total = 0;
    data.forEach(r => {
        if (r.inT) total++;
        if (r.outT) total++;
    });

    document.getElementById("progressBox").style.display = "block";
    let done = 0;

    successCount = 0;
    errorCount   = 0;
    errorRows    = [];

    /* ================= PROCESS ================= */
    for (const r of data) {

        try {
            if (r.inT) {
                const res = await callAPI(r.emp, `${r.date} ${r.inT}`, baseUrl);
                handleRowResult(res, r, "IN");
                updateProgress(++done, total);
            }

            if (r.outT) {
                const res = await callAPI(r.emp, `${r.date} ${r.outT}`, baseUrl);
                handleRowResult(res, r, "OUT");
                updateProgress(++done, total);
            }

        } catch (e) {
            markRowError(r, "API Failed");
            updateProgress(++done, total);
        }
    }

    document.getElementById("progressBar").innerText = "Completed";

    buildErrorTable();
    showSummary(total);
    toggleErrorButtons();

}

function handleRowResult(res, rowData, punchType) {

    if (res.status === 'success') {

        // Duplicate punch handling
        if (res.message && res.message.toLowerCase().includes("duplicate")) {
            rowData.rowEl.style.background = "#fff3cd"; // yellow
            rowData.rowEl.title = "Duplicate Punch";
            successCount++;
            return;
        }

        rowData.rowEl.style.background = "#d4edda"; // green
        successCount++;

    } else {
        markRowError(rowData, res.message);
    }
}

function markRowError(rowData, message) {

    rowData.rowEl.style.background = "#f8d7da"; // red
    rowData.rowEl.title = message;

    errorCount++;

    const failed = {
        emp   : rowData.emp,
        date  : rowData.date,
        inT   : rowData.inT,
        outT  : rowData.outT,
        error : message,
        rowEl : rowData.rowEl
    };

    errorRows.push(failed);
    failedQueue.push(failed);
}


function buildErrorTable() {

    if (!errorRows.length) return;

    let html = `<h5 style="margin-top:20px;color:red">Failed Records</h5>
        <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Emp Code</th>
                <th>Date</th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Error</th>
            </tr>
        </thead><tbody>`;

    errorRows.forEach(r => {
        html += `<tr>
            <td>${r.emp}</td>
            <td>${r.date}</td>
            <td>${r.inT ?? ''}</td>
            <td>${r.outT ?? ''}</td>
            <td style="color:red">${r.error}</td>
        </tr>`;
    });

    html += `</tbody></table>`;

    document.getElementById("response_message").innerHTML += html;
}
function showSummary(total) {

    const msg = `
        <div class="alert alert-info">
            <b>Total Punches:</b> ${total}<br>
            <b style="color:green">Success:</b> ${successCount}<br>
            <b style="color:red">Failed:</b> ${errorCount}
        </div>
    `;

    document.getElementById("response_message").innerHTML =
        msg + document.getElementById("response_message").innerHTML;
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

async function retryFailedRows() {

    if (!failedQueue.length) {
        alert("No failed rows to retry");
        return;
    }

    const baseUrl = "<?php echo base_url().'index.php/Welcome/emp_attend_api'?>";

    document.getElementById("progressBox").style.display = "block";
    let done = 0;
    let total = failedQueue.length * 2;

    const retryQueue = [...failedQueue];
    failedQueue = [];
    errorRows   = [];
    errorCount  = 0;

    for (const r of retryQueue) {

        try {
            if (r.inT) {
                const res = await callAPI(r.emp, `${r.date} ${r.inT}`, baseUrl);
                handleRowResult(res, r, "IN");
                updateProgress(++done, total);
            }

            if (r.outT) {
                const res = await callAPI(r.emp, `${r.date} ${r.outT}`, baseUrl);
                handleRowResult(res, r, "OUT");
                updateProgress(++done, total);
            }

        } catch (e) {
            markRowError(r, "Retry failed");
            updateProgress(++done, total);
        }
    }

    toggleErrorButtons();
}

function toggleErrorButtons() {

    document.getElementById("downloadErrorBtn").style.display =
        errorRows.length ? "inline-block" : "none";

    document.getElementById("retryFailedBtn").style.display =
        failedQueue.length ? "inline-block" : "none";
}


</script>
