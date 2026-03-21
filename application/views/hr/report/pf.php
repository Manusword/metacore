<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$role_list='';
if (!empty($type_search_list) && is_array($type_search_list)) {    
    $role_list = implode(",", $type_search_list);
}
$month_name = date('F Y', strtotime($year.'-'.$month.'-01'));

$rows = $rows ?? [];


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
    <h3 align="center">PF CHALLAN – <?= $month_name ?></h3>
    <h4 align='center' ><?php echo $role_list;?></h4>

    <p><b>Print Date:</b> <?= date('d-m-Y') ?></p>
    
    

<table id="printed_table">
    <thead>
        <tr>
            <th colspan="12">Data from Salary Sheet</th>
            <th>Total absent</th>
            <th>User Field</th>
            <th>From Master</th>
            <th>Create CSV file to upload on EPF Portal</th>
        </tr>
            
        <tr>
            <th>SNO</th>
            <th>UAN</th>
            <th>Emp Code</th>
             <th>Bio Code</th>
            <th>Member Name</th>
            <th>Gross Wages</th>
            <th>EPF Wages</th>
            <th>EPS Wages</th>
            <th>EDLI Wages</th>
            <th>EE Share</th>
            <th>EPS Share</th>
            <th>Diff Share</th>
            <th>NCP Days</th>
            <th>Refund</th>
            <th>Date of Exit</th>
            <th>Text File Line </th>
        </tr>
    </thead>

    <tbody>
    <?php if($rows): $i=1; foreach($rows as $r):

        // ===== SALARY PICK (MONTH PAYABLE ONLY) =====
        $gross      = (float)$r['current_ctc_payable'];

        $epf_wages  = (float)$r['basic_salary_payable'];
        $eps_wages  = (float)$r['basic_salary_payable'];
        $edli_wages = (float)$r['basic_salary_payable'];

        // ===== EMPLOYEE SHARE (ALREADY SAVED) =====
        $ee_share = round((float)$r['epf_payable']);

        // ===== EMPLOYER EPS CALCULATION =====
        $eps_share = round(min($eps_wages * 0.0833, 1250));

        // ===== DIFF SHARE (EMPLOYER EPF PART) =====
        $diff_share = max(0, $ee_share - $eps_share);

        // ===== NCP DAYS =====
        $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $ncp_days = max(0, $month_days - (int)$r['total_present']);

        

        $refund = 0;

        $exit_date = (!empty($r['dor']) && $r['dor']!='0000-00-00')
            ? date('d-m-Y', strtotime($r['dor']))
            : '';

        // ===== EPF ECR TEXT FORMAT =====
        $text_line = implode('#~#', [
            $r['emp_uan'],
            trim($r['first_name'].' '.$r['last_name']),
            $gross,
            $epf_wages,
            $eps_wages,
            $edli_wages,
            $ee_share,
            $eps_share,
            $diff_share,
            $ncp_days,
            $refund
        ]);
    ?>
    <tr>
        <td><?= $i++ ?></td>
        <td><?= $r['emp_uan'] ?></td>
        <td><?= $r['emp_code'] ?></td>
        <td><?= $r['bio_code'] ?></td>
        <td class="text-left" <?php if($r['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>><?= $r['first_name'].' '.$r['last_name'] ?></td>

        <td class="text-right"><?= $gross ?></td>
        <td class="text-right"><?= $epf_wages ?></td>
        <td class="text-right"><?= $eps_wages ?></td>
        <td class="text-right"><?= $edli_wages ?></td>

        <td class="text-right"><?= $ee_share ?></td>
        <td class="text-right"><?= $eps_share ?></td>
        <td class="text-right"><?= $diff_share ?></td>

        <td><?= $ncp_days ?></td>
        <td><?= $refund ?></td>
        <td><?= $exit_date ?></td>
        <td class="text-left epf-text-line"><?= $text_line ?></td>
    </tr>
    <?php endforeach; else: ?>
    <tr><td colspan="16">No PF Data Found</td></tr>
    <?php endif; ?>
    </tbody>

</table>


<br><br>
<button onclick="downloadEPFTxt()" class="btn btn-primary no-print">
    Download EPF Text File
</button>
                

<script>
function downloadEPFTxt() {

    let lines = [];
    document.querySelectorAll('.epf-text-line').forEach(td => {
        let text = td.innerText.trim();
        if (text !== '') {
            lines.push(text);
        }
    });

    if (lines.length === 0) {
        alert('No EPF data found');
        return;
    }

    // Windows Notepad safe newline
    let content = lines.join('\r\n');

    let blob = new Blob([content], { type: 'text/plain;charset=utf-8;' });
    let url = URL.createObjectURL(blob);

    let a = document.createElement('a');
    a.href = url;
    a.download = 'EPF_ECR_<?= $month ?>_<?= $year ?>.txt';
    document.body.appendChild(a);
    a.click();

    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}
</script>


    
 </div>