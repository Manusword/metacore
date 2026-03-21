 
 <script src="https://cdn.jsdelivr.net/npm/papaparse@5.4.1/papaparse.min.js"></script>

    <style>
        tr.error-row { background:#ffe6e6 !important; }
        tr.duplicate-row { background:#ffcccc !important; }
        tr.rejected-row { background:#f2f2f2 !important; opacity:0.6; }
        .approve-btn { background:#5cb85c; color:#fff; }
        .reject-btn { background:#d9534f; color:#fff; }
        .row-error   { background:#ffe0e0; }
        .row-success { background:#e6ffea; }
        .row-update  { background:#fff6cc; }

    </style>


        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Upload Employee Master Data</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    
                    <div class="col-md-3">
                      <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title" >Download sample csv/xls file</div>
                                    <div class="form-row">
                                            
                                            <div class="col-md-12" style="margin-top:0px;">                            
                                                <a target="_blank" class="btn btn-light" href="<?= base_url('index.php/Hr/download_employee_csv') ?>"
                                                class="btn btn-sm btn-success">
                                                    Download Employee CSV
                                                </a>
                                            </div>  
                                    
                                    </div>
                            </div>
                        </div>
                    </div>


                     <div class="col-md-3">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Upload Employee csv</div>
                                    <div class="form-row">
                                            <input type="file" id="csvFile" accept=".csv" class="form-control" />
                                            <button class="btn btn-info mt-2" onclick="readCSV()">Fetch Data</button>
                                    </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                         <div class="card mb-4" id="outputBox" >    
                              <div class="card-body">
                                    <div class="card-title" >Data in csv file</div>
                                                            
                                    <div id="table_show" style="margin-top:15px; overflow:auto;"></div>

                                    <div class="form-group" style="margin-top:10px;">
                                        <label><strong>Upload Mode</strong></label><br>

                                        <label class="radio-inline">
                                            <input type="radio" name="upload_mode" value="new" checked>
                                            Only New Entry
                                        </label>

                                        <label class="radio-inline">
                                            <input type="radio" name="upload_mode" value="update">
                                            Only Update Existing
                                        </label>

                                        <label class="radio-inline">
                                            <input type="radio" name="upload_mode" value="both">
                                            New + Update Both
                                        </label>
                                    </div>


                                   <button class="btn btn-success mt-2" onclick="uploadData()">
                                        Upload Selected Columns
                                    </button>

                                    <div id="upload_msg" style="margin-top:10px;"></div>


                                </div>
                            </div>
                    </div>
                    
                </div><!-- end of main-content -->   



<script>
/* ================= CONFIG ================= */

const LOCKED_COLUMNS = ["id", "emp_code"];
const NUMERIC_COLUMNS = [
  "current_ctc","basic_salary","hra","conv","city_comp",
  "other_allow","spl_pay","medi_rem","fuel_reimb","esic","epf","bonus",
  "lost_canteen","lost_breakfast","lost_bus","current_total_ctc"
];
const DATE_COLUMNS = ["doj", "dob"];

let parsedData = [];
let rowStatus = {}; // approved | rejected

/* ================= CSV READ ================= */

function readCSV() {
    const file = document.getElementById("csvFile").files[0];
    if (!file) {
        alert("Select CSV file");
        return;
    }

    Papa.parse(file, {
        header: true,
        skipEmptyLines: true,
        complete: function(res) {
            parsedData = res.data;
            renderTable(res.meta.fields, parsedData);
        }
    });
}

/* ================= TABLE RENDER ================= */

function renderTable(headers, rows) {

    let html = `<table class="table table-bordered table-condensed">
        <thead><tr>
        <th style="min-width:100px">Action</th>`;

    headers.forEach(h => {
        html += `
        <th style="min-width:130px">
            <input type="checkbox" class="col-check" data-col="${h}" checked><br>${h}
        </th>`;
    });

    html += `</tr></thead><tbody>`;

    rows.forEach((row, r) => {
        rowStatus[r] = "approved";
        html += `<tr data-row="${r}">`;

        html += `
        <td>
            <button class="btn btn-success btn-sm approve-btn" onclick="approveRow(${r})" >✔</button>
            <button class="btn btn-danger btn-sm reject-btn" onclick="rejectRow(${r})">✖</button>
        </td>`;

        headers.forEach(h => {

            let value = row[h] ?? "";
            let type = "text";

            if (DATE_COLUMNS.includes(h)) {
                type = "date";
                if (/^\d{2}-\d{2}-\d{4}$/.test(value)) {
                    const [d,m,y] = value.split("-");
                    value = `${y}-${m}-${d}`;
                }
            }

            const readonly = LOCKED_COLUMNS.includes(h) ? "readonly" : "";
            const numCls = NUMERIC_COLUMNS.includes(h) ? "numeric" : "";

            html += `
            <td>
                <input type="${type}"
                    class="form-control input-sm ${numCls}"
                    data-row="${r}"
                    data-col="${h}"
                    value="${value}"
                    ${readonly}
                    oninput="validateRow(${r})">
            </td>`;
        });

        html += `</tr>`;
    });

    html += `</tbody></table>`;

    document.getElementById("table_show").innerHTML = html;

    bindColumnToggle();
    detectDuplicateEmpCode();
}
</script>

<script>
/* ================= COLUMN TOGGLE ================= */

function bindColumnToggle() {
    document.querySelectorAll(".col-check").forEach(cb => {
        cb.onchange = function() {
            document.querySelectorAll(`[data-col="${this.dataset.col}"]`)
            .forEach(el => el.closest("td").style.display = this.checked ? "" : "none");
        };
    });
}
</script>

<script>
/* ================= ROW VALIDATION ================= */

function validateRow(r) {

    const tr = document.querySelector(`tr[data-row="${r}"]`);
    if (rowStatus[r] === "rejected") return;

    let error = false;

    tr.querySelectorAll("input").forEach(inp => {

        if (inp.classList.contains("numeric")) {
            if (inp.value && isNaN(inp.value)) {
                inp.style.border = "2px solid red";
                error = true;
            } else inp.style.border = "";
        }

        if (inp.type === "date" && inp.value && !/^\d{4}-\d{2}-\d{2}$/.test(inp.value)) {
            error = true;
        }
    });

    tr.classList.toggle("error-row", error);
}
</script>

<script>
/* ================= DUPLICATE emp_code ================= */

function detectDuplicateEmpCode() {

    let map = {};
    document.querySelectorAll('input[data-col="emp_code"]').forEach(inp => {
        const v = inp.value.trim();
        if (!v) return;
        map[v] = map[v] ? [...map[v], inp] : [inp];
    });

    document.querySelectorAll("tr").forEach(tr => tr.classList.remove("duplicate-row"));

    Object.keys(map).forEach(k => {
        if (map[k].length > 1) {
            map[k].forEach(inp => inp.closest("tr").classList.add("duplicate-row"));
        }
    });
}
</script>

<script>
/* ================= APPROVE / REJECT ================= */

function approveRow(r) {
    rowStatus[r] = "approved";
    const tr = document.querySelector(`tr[data-row="${r}"]`);
    tr.classList.remove("rejected-row");
}

function rejectRow(r) {
    rowStatus[r] = "rejected";
    const tr = document.querySelector(`tr[data-row="${r}"]`);
    tr.classList.add("rejected-row");
}
</script>

<script>
/* ================= UPLOAD ================= */
function uploadData(onlyRejected = false) {

    document.getElementById("upload_msg").innerHTML = "";

    const uploadMode = document.querySelector(
        'input[name="upload_mode"]:checked'
    ).value;

    let payload = [];

    document.querySelectorAll('tr[data-row]').forEach(tr => {

        const r = tr.dataset.row;

        // skip rejected rows
        if (!onlyRejected && rowStatus[r] === "rejected") return;

        let rowObj = {};

        tr.querySelectorAll('input[data-col]').forEach(inp => {

            // skip hidden columns
            if (inp.closest("td").style.display === "none") return;

            rowObj[inp.dataset.col] = inp.value.trim();
        });

        // empty row guard
        if (Object.keys(rowObj).length > 0) {
            rowObj.__row_index = r; // backend mapping ke liye
            payload.push(rowObj);
        }
    });

    if (!payload.length) {
        showMsg("No approved rows to upload", "danger");
        return;
    }

    fetch("<?php echo base_url().'index.php/Hr/upload_emp_master_save';?>", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            mode: uploadMode,
            data: payload
        })
    })
    .then(r => r.json())
    .then(res => {

        if (!res.status) {
            showMsg(res.message, "danger");
            return;
        }

        res.rows.forEach(r => {

            const tr = document.querySelector(`tr[data-row="${r.row_index}"]`);
            if (!tr) return;

            tr.classList.remove('row-error','row-success','row-update');

            if (r.status === 'Rejected') tr.classList.add('row-error');
            if (r.status === 'Inserted') tr.classList.add('row-success');
            if (r.status === 'Updated')  tr.classList.add('row-update');
        });

        showMsg(
            `Inserted: ${res.summary.inserted}, Updated: ${res.summary.updated}, Rejected: ${res.summary.rejected}`,
            "success"
        );
    });
}


function showMsg(msg, type) {
    document.getElementById("upload_msg").innerHTML =
        `<div class="alert alert-${type}">${msg}</div>`;
}

    

</script>
