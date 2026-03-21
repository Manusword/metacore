 
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
                    <h1>Upload Employee Salary Data</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    
                    <div class="col-md-5">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="card-title">Upload Employee CSV</div>

                                <div class="form-group">
                                    <label>Salary Month</label>
                                    <select id="salary_month" class="form-control">
                                        <option value="">Select Month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Salary Year</label>
                                    <select id="salary_year" class="form-control">
                                        <option value="">Select Year</option>
                                        <?php
                                            $y = date('Y');
                                            for ($i = $y; $i <= $y + 5; $i++) {
                                                echo "<option value='{$i}'>{$i}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>CSV File</label>
                                    <input type="file" id="csvFile" accept=".csv" class="form-control">
                                </div>

                                <button class="btn btn-info btn-block" onclick="readCSV()">
                                    Fetch Data
                                </button>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12">
                         <div class="card mb-4" id="outputBox" >    
                              <div class="card-body">
                                    <div class="card-title" >Data in csv file</div>
                                                            
                                    <div id="table_show" style="margin-top:15px; overflow:auto;"></div>

                                  

                                   <button class="btn btn-success mt-2" onclick="uploadData()">
                                        Upload Selected Columns
                                    </button>

                                    <div id="upload_msg" style="margin-top:10px;"></div>


                                </div>
                            </div>
                    </div>
                    
                </div><!-- end of main-content -->  
 
<script>
/* =========================================================
   CONFIG
========================================================= */

const LOCKED_COLUMNS = ["emp_code"];
const NUMERIC_COLUMNS = ["net_salary", "trfd_amt"];

const FIXED_VALUE_COLUMNS = {
    curr: ["INR"],
    neft: ["NFT", "NEFT"]
};

const REQUIRED_COLUMNS = [
    "emp_code","emp_name","net_salary",
    "account_no","trfd_amt","curr",
    "emp_acc","emp_ifsc"
];

let rowStatus = {}; // approved | rejected

/* =========================================================
   CSV READ
========================================================= */

function readCSV() {

    const month = document.getElementById("salary_month").value;
    const year  = document.getElementById("salary_year").value;
    const fileInput = document.getElementById("csvFile");

    if (!month || !year) {
        alert("Salary month & year required");
        return;
    }

    if (!fileInput.files.length) {
        alert("Please select CSV file");
        return;
    }

    Papa.parse(fileInput.files[0], {
        header: true,
        skipEmptyLines: true,
        complete: res => renderTable(res.meta.fields, res.data)
    });
}

/* =========================================================
   TABLE RENDER
========================================================= */

function renderTable(headers, rows) {

    const missing = REQUIRED_COLUMNS.filter(c => !headers.includes(c));
    if (missing.length) {
        showMsg("Missing required columns: " + missing.join(", "), "danger");
        return;
    }

    rowStatus = {};

    let html = `<table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Action</th>`;

    headers.forEach(h => {
        html += `
            <th>
                <input type="checkbox" class="col-check" data-col="${h}" checked><br>
                ${h}
            </th>`;
    });

    html += `</tr></thead><tbody>`;

    rows.forEach((row, r) => {

        rowStatus[r] = "approved";

        html += `<tr data-row="${r}">
            <td>
                <button class="btn btn-success btn-sm" onclick="approveRow(${r})">✔</button>
                <button class="btn btn-danger btn-sm" onclick="rejectRow(${r})">✖</button>
            </td>`;

        headers.forEach(h => {

            const val = row[h] ?? "";
            const readonly = LOCKED_COLUMNS.includes(h) ? "readonly" : "";

            html += `
                <td>
                    <input type="text"
                        class="form-control form-control-sm"
                        data-row="${r}"
                        data-col="${h}"
                        value="${val}"
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

/* =========================================================
   COLUMN TOGGLE
========================================================= */

function bindColumnToggle() {
    document.querySelectorAll(".col-check").forEach(cb => {
        cb.onchange = () => {
            document
                .querySelectorAll(`[data-col="${cb.dataset.col}"]`)
                .forEach(el => el.closest("td").style.display = cb.checked ? "" : "none");
        };
    });
}

/* =========================================================
   ROW VALIDATION
========================================================= */

function validateRow(r) {

    const tr = document.querySelector(`tr[data-row="${r}"]`);
    if (rowStatus[r] === "rejected") return;

    let hasError = false;

    tr.querySelectorAll("input[data-col]").forEach(inp => {

        const col = inp.dataset.col;
        const val = inp.value.trim();
        let fieldError = false;

        inp.style.border = "";

        if (REQUIRED_COLUMNS.includes(col) && !val) fieldError = true;

        if (NUMERIC_COLUMNS.includes(col) && val && !/^\d+(\.\d+)?$/.test(val))
            fieldError = true;

        if (FIXED_VALUE_COLUMNS[col] && val &&
            !FIXED_VALUE_COLUMNS[col].includes(val))
            fieldError = true;

        if (fieldError) {
            inp.style.border = "2px solid red";
            hasError = true;
        }
    });

    tr.classList.toggle("error-row", hasError);
}

/* =========================================================
   DUPLICATE EMP CODE
========================================================= */

function detectDuplicateEmpCode() {

    let map = {};

    document.querySelectorAll('input[data-col="emp_code"]').forEach(inp => {
        const v = inp.value.trim().toUpperCase();
        if (!v) return;
        map[v] = map[v] ? [...map[v], inp] : [inp];
    });

    document.querySelectorAll("tr").forEach(tr =>
        tr.classList.remove("duplicate-row")
    );

    Object.values(map).forEach(arr => {
        if (arr.length > 1) {
            arr.forEach(inp =>
                inp.closest("tr").classList.add("duplicate-row")
            );
        }
    });
}

/* =========================================================
   APPROVE / REJECT
========================================================= */

function approveRow(r) {
    rowStatus[r] = "approved";
    document.querySelector(`tr[data-row="${r}"]`)
        .classList.remove("rejected-row");
}

function rejectRow(r) {
    rowStatus[r] = "rejected";
    document.querySelector(`tr[data-row="${r}"]`)
        .classList.add("rejected-row");
}

/* =========================================================
   UPLOAD
========================================================= */

function uploadData() {

    const month = document.getElementById("salary_month").value;
    const year  = document.getElementById("salary_year").value;

    if (!month || !year) {
        showMsg("Salary month & year required", "danger");
        return;
    }

    if (document.querySelectorAll(".duplicate-row").length) {
        showMsg("Duplicate emp_code found. Fix before upload.", "danger");
        return;
    }

    if (document.querySelectorAll(".error-row").length) {
        showMsg("Validation errors exist. Fix them first.", "danger");
        return;
    }

    let payload = [];

    document.querySelectorAll('tr[data-row]').forEach(tr => {

        const r = tr.dataset.row;
        if (rowStatus[r] === "rejected") return;

        let rowObj = {};

        tr.querySelectorAll('input[data-col]').forEach(inp => {
            if (inp.closest("td").style.display === "none") return;
            rowObj[inp.dataset.col] = inp.value.trim();
        });

        if (Object.keys(rowObj).length) {
            rowObj.__row_index = r;
            payload.push(rowObj);
        }
    });

    if (!payload.length) {
        showMsg("No valid rows to upload", "danger");
        return;
    }

    fetch("<?php echo base_url().'index.php/Hr/upload_salary_transfer_save'; ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            salary_month: month,
            salary_year: year,
            data: payload
        })
    })
    .then(r => r.json())
    .then(res => handleUploadResponse(res))
    .catch(() => showMsg("Server error", "danger"));
}

/* =========================================================
   UPLOAD RESPONSE
========================================================= */

function handleUploadResponse(res) {

    if (!res || res.status !== true) {
        showMsg(res.message || "Upload failed", "danger");
        return;
    }

    let rejectedMsgs = [];

    res.rows.forEach(r => {

        const tr = document.querySelector(`tr[data-row="${r.row_index}"]`);
        if (!tr) return;

        tr.classList.remove("row-error", "row-success");

        const actionCell = tr.querySelector("td"); // first column (Action)

        if (r.status === "Inserted") {
            tr.classList.add("row-success");
            actionCell.innerHTML = `<span class="text-success">✔ Inserted</span>`;
        }

        if (r.status === "Rejected") {
            tr.classList.add("row-error");
            actionCell.innerHTML = `
                <span class="text-danger" title="${r.message}">
                    ✖ Rejected
                </span>
                <div class="text-danger small">${r.message}</div>
            `;
            rejectedMsgs.push(`Row ${parseInt(r.row_index)+1}: ${r.message}`);
        }
    });

    // ===== TOP SUMMARY MESSAGE =====
    let msg = `
        Inserted: ${res.summary.inserted},
        Rejected: ${res.summary.rejected}
    `;

    if (rejectedMsgs.length) {
        msg += `<br><strong>Errors:</strong><br>` + rejectedMsgs.join("<br>");
        showMsg(msg, "danger");
    } else {
        showMsg(msg, "success");
    }
}


/* =========================================================
   MESSAGE
========================================================= */

function showMsg(msg, type) {
    document.getElementById("upload_msg").innerHTML =
        `<div class="alert alert-${type}">${msg}</div>`;
}
</script>
