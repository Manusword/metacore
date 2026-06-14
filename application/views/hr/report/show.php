<style>
    /* Attendance colors */
    /* .att-P { background:#d4edda; color:#155724; font-weight:bold; }
    .att-HA { background:#d4edda; color:#155724; font-weight:bold; }
    .att-HL { background:#d4edda; color:#155724; font-weight:bold; }
    .att-A { background:#f8d7da; color:#721c24; font-weight:bold; }
    .att-H { background:#d4edda; color:#155724; font-weight:bold; }
    .att-R { background:#d1ecf1; color:#0c5460; font-weight:bold; }
    .att-S { background:#d4edda; color:#155724; font-weight:bold; }
    .att-T { background:#d4edda; color:#155724; font-weight:bold; } */
    .att-P {
        background:#d4edda;   /* green light */
        color:#155724;
        font-weight:bold;
    }

    .att-A,
    .att-L {
        background:#f8d7da;   /* red light */
        color:#721c24;
        font-weight:bold;
    }

    .att-HA {
        background:#fff3cd;   /* orange/yellow light */
        color:#856404;
        font-weight:bold;
    }

    .att-HL {
        background:#fce4ec;   /* pink light */
        color:#880e4f;
        font-weight:bold;
    }

    .att-S {
        background:#d1ecf1;   /* blue light */
        color:#0c5460;
        font-weight:bold;
    }

    .att-H {
        background:#fff3cd;   /* yellow light */
        color:#856404;
        font-weight:bold;
    }

    .att-R,
    .att-SL,
    .att-CL,
    .att-EL,
    .att-OL,
    .att-T {
        background:#e2e3f3;   /* purple light */
        color:#383d7c;
        font-weight:bold;
    }

    .att-empty { background:#fff; }
    .att-wrong {
        background-color:red;
        color:#fff;
    }

    /* Late / Early */
    /* Early punch – light green */
    .early {
        background:#e8f5e9 !important;   /* light green */
    }

    /* Late punch – darker green */
    .late {
        background:#a5d6a7 !important;   /* dark-ish green */
    }
     body {
                color: #000 !important;
            }

    @media print {
        @page {
            size: A4 landscape;
           
        }

         * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                color: #000 !important;
            }

            #print-area th,
            #print-area td {
                border: 1.5px solid #000 !important;
                font-weight: 600;
            }

        html, body {
            margin: 0 !important;
            padding: 0 !important;
        }

        .breadcrumb,
        .separator-breadcrumb,
        .no-print {
            display: none !important;
        }

        body {
            transform: none !important;
        }

        #print-area {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            margin-top: -22mm
        }
    }

    /* ================= PDF MODE ================= */

    .pdf-mode{
        zoom: 1 !important;               /* ❌ transform / scale bilkul nahi */
    }

    .pdf-mode table{
        table-layout: fixed !important;
        width: 297mm !important;          /* full A4 landscape */
        font-size: 8px !important;        /* readable */
        border-collapse: collapse;
    }

    .pdf-mode th,
    .pdf-mode td{
        padding: 1px 2px !important;
        line-height: 1.15 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
    }

    /* ================= TABLE ================= */
    #print-area table{
        width:100%;
        border-collapse:collapse;
    }
    #print-area th,
    #print-area td{
        border:1px solid #000;
        text-align:center;
    }

    /* 🔥 HEADER ON EVERY PAGE */
    thead{
        display: table-header-group;
    }
    tfoot{
        display: table-row-group;
    }

    .text-left{ text-align:left; }
    .text-right{ text-align:right; }


</style>

<?php
    $this->Hrmodel->all_unit_filter();//payroll units filter
?>

<div class="breadcrumb" style=" margin-top:-30px">
			<div class="row w-100">
       
   

        <div class="col-md-1">
            <label>Year</label>
            <select class="form-control" id="search_year">
                <?php
                $currentYear = date('Y');
                for ($y = 2025; $y <= 2030; $y++) {
                ?>
                    <option value="<?= $y ?>" <?= ($y == $currentYear) ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-1">
            <label>Month</label>
            <select class="form-control" id="search_month">
                <?php
                $months = [
                    1=>'January',2=>'February',3=>'March',4=>'April',
                    5=>'May',6=>'June',7=>'July',8=>'August',
                    9=>'September',10=>'October',11=>'November',12=>'December'
                ];
                $currentMonth = (int)date('n');
                foreach ($months as $k=>$v) {
                ?>
                    <option value="<?= $k ?>" <?= ($k==$currentMonth)?'selected':'' ?>>
                        <?= $v ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-1">
            <label>Dept.</label>
            <select class="form-control" id="dept1">
                <option value="">All</option>
                <?php foreach($dept as $d){ ?>
                    <option value="<?= $d['department_id'] ?>"
                        <?= (!empty($def_dept) && $d['department_id']==$def_dept)?'selected':'' ?>>
                        <?= $d['name'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-1">
            <label >Emp code</label>
            <input type="text" class="form-control"  id="emp_id1"  >
        </div> 

            <div class="col-md-1">
            <label >Bio code</label>
            <input type="text" class="form-control"  id="bio_id1"  >
        </div> 

        <div class="col-md-1">
            <label>Name</label>
            <input type="text" class="form-control" id="name1">
        </div>

       
        <div class="col-md-1">
            <label>Active</label>
            <select class="form-control" id="active1">
                <option selected value="">All</option>
                <option >Active</option>
                <option>Deactive</option>
            </select>
        </div>

        <div class="col-md-1">
            <label>Report Type</label>
            <select class="form-control" id="report_type">
                <option value="1">P & A</option>
                <option value="2">P/A & Time</option>
                <option value="13">P/A & Time2</option>
                <option value="3">Salary Sheet</option>
                <option value="4">Salary Transfer</option>
                <option value="11">Salary Dept. wise</option>
                <option value="10">Salary Slip</option>
                <option value="5">Gratuity</option>
                <option value="6">Bonus</option>
                <option value="7">EPF Challan</option>
                <option value="8">ESI Challan</option>
                <option value="9">No Attendance</option>
                <option value="12">Leave Rem.</option>
            </select>
        </div>

        <div class="col-md-1">
            <input type="button" id="salary_search" class="btn"
                   style="margin-top:28px;background:<?= $this->Company->table_bg_color();?>;color:<?= $this->Company->table_ft_color();?>"
                   value="Search">
        </div>

    </div>
</div>

<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">

                <div class="no-print d-flex justify-content-end gap-2 mb-2">
                    <button class="btn btn-dark m-1" onclick="zoomReset()">Reset</button>    
                    <button class="btn btn-default m-1" onclick="zoomOut()">➖</button>
                    <button class="btn btn-default m-1" onclick="zoomIn()">➕</button>
                    <button class="btn btn-info m-1" onclick="savePDF()">📄 PDF</button>
                    <button class="btn btn-success m-1" onclick="fun_export_old_xls()">📥 Excel (xls)</button>
                    <button class="btn btn-success m-1" onclick="fun_export_xls()">📥 Excel (xlsx)</button>
                    <button class="btn btn-danger m-1" onclick="window.print()">🖨 Print</button>
                </div>

                <hr>

                <!-- IMPORTANT -->
                <div id="table_show">
                    <div id="print-area">
                        <!-- AJAX TABLE  -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
function toggleAll(source) {
    document.querySelectorAll('input[name="company_role1[]"]').forEach(cb => {
        cb.checked = source.checked;
    });
}
function savePDF(){
    const el = document.getElementById('print-area');

    el.classList.add('pdf-mode');

    html2pdf().set({
        margin: 5,
        filename: 'Report.pdf',
        html2canvas: {
            scale: 4,          /* 🔥 MAX CLARITY */
            useCORS: true,
            letterRendering: true
        },
        jsPDF: {
            unit: 'mm',
            format: 'a4',
            orientation: 'landscape'
        }
    }).from(el).save().then(()=>{
        el.classList.remove('pdf-mode');
    });
}
</script>



<script>
let zoomLevel = 1;
const MIN_ZOOM = 0.5;
const MAX_ZOOM = 1.5;

function getPrintArea(){
    return document.getElementById('print-area');
}

function applyZoom(){
    const el = getPrintArea();
    if(!el) return;

    zoomLevel = Math.min(MAX_ZOOM, Math.max(MIN_ZOOM, zoomLevel));
    el.style.transform = `scale(${zoomLevel})`;
    el.style.transformOrigin = 'top left';
}

function zoomIn(){
    zoomLevel += 0.1;
    applyZoom();
}

function zoomOut(){
    zoomLevel -= 0.1;
    applyZoom();
}

function zoomReset(){
    zoomLevel = 1;
    applyZoom();
}

window.onbeforeprint = () => {
    const el = getPrintArea();
    if(el) el.style.transform = 'scale(1)';
};

window.onafterprint = () => {
    applyZoom();
};
</script>

<?php $this->load->view('js/hr_js'); ?>
