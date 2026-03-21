<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$role_list='';
if (!empty($type_search_list) && is_array($type_search_list)) {    
    $role_list = implode(",", $type_search_list);
}
$month_name = date('F Y', strtotime($year.'-'.$month.'-01'));

$rows = $rows ?? [];

/* TOTALS */
$tot = [
    'gross' => 0,
    'ee' => 0,
    'er' => 0,
    'total' => 0,
];
?>


<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #000;
        padding: 3px;
        text-align: center;
    }

    th {
        background: #eaeaea;
        font-size: 9px;
    }

    .text-left { text-align: left; }
    .text-right { text-align: right; }

    thead { display: table-header-group; }
    tfoot { display: table-row-group; }

    .bold { font-weight: bold; }

    /* .bordet-top{ border-top: black solid 1px;} */
</style>



<div id="print-area">
        


    <h3 align="center">ESI CHALLAN – <?= $month_name ?></h3>
     <h4 align='center' ><?php echo $role_list;?></h4>

    <p><b>Print Date:</b> <?= date('d-m-Y') ?></p>
    
 <table id="printed_table">
<thead>
<tr>
    <th>SNO</th>
    <th>ESI No</th>
    <th>Emp Code</th>
     <th>Bio Code</th>
    <th>Member Name</th>
    <th>Days</th>
    <th>ESI Wages</th>
    <th>Employee ESI (0.75%)</th>
    <th>Employer ESI (3.25%)</th>
    <th>Total ESI</th>
    <th>Text File Line</th>
</tr>
</thead>

<tbody>
<?php
if ($rows):
$i = 1;
foreach ($rows as $r):

    // ================= ESIC BASE =================
    // ESIC is ALWAYS on earned wages (present-day based)
    $esi_wages = round((float)$r['current_ctc_payable'], 2);

    // ESIC eligibility limit
    $esi_limit = 21000;

    $eligible = ($esi_wages > 0 && $esi_wages <= $esi_limit);

    // ================= CONTRIBUTIONS =================
    if ($eligible) {
        // Employee share already deducted & saved
        $emp_esi = round((float)$r['esic_payable'], 2);

        // Employer share calculated
        $employer_esi = round($esi_wages * 0.0325, 2);

        $total_esi = round($emp_esi + $employer_esi, 2);
    } else {
        $esi_wages   = 0;
        $emp_esi     = 0;
        $employer_esi= 0;
        $total_esi   = 0;
    }

    // ================= TEXT FILE LINE =================
    // Only eligible employees go in file
    $text_line = $eligible ? implode('|', [
        $r['esi_code'],
        trim($r['first_name'].' '.$r['last_name']),
        number_format($esi_wages,2,'.',''),
        number_format($emp_esi,2,'.',''),
        number_format($employer_esi,2,'.',''),
        number_format($total_esi,2,'.','')
    ]) : '';
?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= $r['esi_code'] ?></td>
    <td><?= $r['emp_code'] ?></td>
    <td><?= $r['bio_code'] ?></td>
    <td class="text-left" <?php if($r['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>><?= $r['first_name'].' '.$r['last_name'] ?></td>
    <td><?= $r['total_present'] ?></td>
    <td class="text-right"><?= number_format($esi_wages,2) ?></td>
    <td class="text-right"><?= number_format($emp_esi,2) ?></td>
    <td class="text-right"><?= number_format($employer_esi,2) ?></td>
    <td class="text-right bold"><?= number_format($total_esi,2) ?></td>

    <td class="text-left esi-text-line"><?= $text_line ?></td>
</tr>
<?php
endforeach;
else:
?>
<tr><td colspan="11">No ESI Data Found</td></tr>
<?php endif; ?>
</tbody>
</table>



<br><br>
<button onclick="downloadESITxt()" class="btn btn-primary no-print">
    Download ESI Text File
</button>


                
<script>
function downloadESITxt() {

    let lines = [];
    document.querySelectorAll('.esi-text-line').forEach(td => {
        let text = td.innerText.trim();
        if (text !== '') {
            lines.push(text);
        }
    });

    if (lines.length === 0) {
        alert('No ESI data found');
        return;
    }

    let content = lines.join('\r\n'); // Notepad safe

    let blob = new Blob([content], { type: 'text/plain;charset=utf-8;' });
    let url = URL.createObjectURL(blob);

    let a = document.createElement('a');
    a.href = url;
    a.download = 'ESI_CHALLAN_<?= $month ?>_<?= $year ?>.txt';
    document.body.appendChild(a);
    a.click();

    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
</script>


    
 </div>