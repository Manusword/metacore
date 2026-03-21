<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$company_full_name = $company[0]['full_name'] ?? '';
$company_address   = $company[0]['address'] ?? '';
$month_name = date('F Y', strtotime($year.'-'.$month.'-01'));

$rows = $rows ?? [];

/* INIT TOTALS */
$tot = [
    'basic_salary' => 0,
    'hra' => 0,
    'other_allow' => 0,
    'current_ctc' => 0,
    'total_present' => 0,
    'total_ot' => 0,
    'basic_salary_payable' => 0,
    'hra_payable' => 0,
    'other_allow_payable' => 0,
    'total_ot_rs' => 0,
    'current_ctc_payable' => 0,
    'epf_payable' => 0,
    'esic_payable' => 0,
    'advance_this_month_payable' => 0,
    'total_deduction' => 0,
    'current_total_ctc_payable' => 0,
];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Register of Wages</title>

<style>
@page {
    size: A4 landscape;
    margin: 10mm;
}

body {
    font-family: Arial;
    font-size: 10px;
}

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
</head>

<body>

<h3 align="center"><b>FORM XVII</b></h3>
<p align="center">
[See Rule 78(1)(a)]<br>
Register of Wages
</p>

<p align="center">
	<b>Name & Address of Establishment:</b><br>
	<?= $company_full_name ?><br>
	<?= $company_address ?>
</p>

<p align="center">
	<b>Wage Period:</b> <?= $month_name ?><br>
	<b>PF Code: <?= $company[0]['pf_code'] ?></b>  &nbsp;&nbsp;
	<b>ESI No: <?= $company[0]['esi_no'] ?></b>
</p>




<h3 align="center"></h3>

<p><b>Print Date:</b> <?= date('d-m-Y') ?></p>

<table>
<thead>
<tr>
<th>S.No</th>
<th>Emp Code <br><span class="bordet-top">Bio Code</span></th>
<!-- <th>Bio</th> -->
<th>Emp Name <br><span class="bordet-top">Father Name</span></th>
<th>From Unit. <br><span class="bordet-top">Working Unit.</span></th>
<!-- <th>Father</th> -->
<th>DOJ</th>
<th>Dept. <br><span class="bordet-top">Desig.</span></th>
<!-- <th>Desig</th> -->
<th>ESI</th>
<th>UAN</th>

<th>Basic</th>
<th>HRA</th>
<th>Other</th>
<th>CTC</th>

<th>Present</th>
<!-- <th>OT</th> -->

<th>Basic Earn</th>
<th>HRA Earn</th>
<th>Other Earn</th>
<!-- <th>OT Rs</th> -->
<th>Total Earn</th>

<th>EPF</th>
<th>ESIC</th>
<th>Advance</th>
<th>Total Ded</th>
<th>Net Pay</th>

<th>Any Inc</th>
<th>DOR</th>
<!-- <th>Bank Name</th>
<th>Account No</th>
<th>IFSC</th> -->


</tr>
</thead>

<tbody>
<?php if ($rows): ?>
<?php $i=1; foreach ($rows as $r): 

foreach ($tot as $k => $v) {
    $tot[$k] += (float)($r[$k] ?? 0);
}
?>
<tr>
<td><?= $i++ ?></td>
<td><?= $r['emp_code'] ?> <br><span class="bordet-top"><?= $r['bio_code'] ?></span></td>
<!-- <td><?= $r['bio_code'] ?></td> -->
<td class="text-left"><?= $r['first_name'].' '.$r['last_name'] ?> <br><span class="bordet-top"><?= $r['father_name'] ?></span></td>
<!-- <td class="text-left"><?= $r['father_name'] ?></td> -->
 <td><?= $r['company_role'] ?> <br><span class="bordet-top"><?= $r['plant'] ?></span></td>
<td>
<?php
if (!empty($r['doj']) && $r['doj'] != '0000-00-00') {
    echo date('d-m-Y', strtotime($r['doj']));
}
?>
</td>

<td><?= $r['department'] ?> <br><span class="bordet-top"><?= $r['designation'] ?></span></td>
<!-- <td><?= $r['designation'] ?></td> -->
<td><?= $r['esi_code'] ?></td>
<td><?= $r['emp_uan'] ?></td>

<td class="text-right"><?= number_format($r['basic_salary'],2) ?></td>
<td class="text-right"><?= number_format($r['hra'],2) ?></td>
<td class="text-right"><?= number_format($r['other_allow'],2) ?></td>
<td class="text-right"><?= number_format($r['current_ctc'],2) ?></td>

<td><?= $r['total_present'] ?></td>
<!-- <td><?= $r['total_ot'] ?></td> -->

<td class="text-right"><?= number_format($r['basic_salary_payable'],2) ?></td>
<td class="text-right"><?= number_format($r['hra_payable'],2) ?></td>
<td class="text-right"><?= number_format($r['other_allow_payable'],2) ?></td>
<!-- <td class="text-right"><?= number_format($r['total_ot_rs'],2) ?></td> -->
<td class="text-right"><?= number_format($r['current_ctc_payable'],2) ?></td>

<td class="text-right"><?= number_format($r['epf_payable'],2) ?></td>
<td class="text-right"><?= number_format($r['esic_payable'],2) ?></td>
<td class="text-right"><?= number_format($r['advance_this_month_payable'],2) ?></td>
<td class="text-right"><?= number_format($r['total_deduction'],2) ?></td>
<td class="text-right bold"><?= number_format($r['current_total_ctc_payable'],2) ?></td>
<td><?= $r['increment_due_month'] ?></td>
<td>
<?php
if (!empty($r['dor']) && $r['dor'] != '0000-00-00') {
    echo date('d-m-Y', strtotime($r['dor']));
}
?>
</td>

</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="26">No Records Found</td></tr>
<?php endif; ?>
</tbody>

<tfoot>
<tr class="bold">
<td colspan="8">GRAND TOTAL</td>
<td class="text-right"><?= number_format($tot['basic_salary'],2) ?></td>
<td class="text-right"><?= number_format($tot['hra'],2) ?></td>
<td class="text-right"><?= number_format($tot['other_allow'],2) ?></td>
<td class="text-right"><?= number_format($tot['current_ctc'],2) ?></td>
<td><?= $tot['total_present'] ?></td>
<!-- <td><?= $tot['total_ot'] ?></td> -->
<td class="text-right"><?= number_format($tot['basic_salary_payable'],2) ?></td>
<td class="text-right"><?= number_format($tot['hra_payable'],2) ?></td>
<td class="text-right"><?= number_format($tot['other_allow_payable'],2) ?></td>
<!-- <td class="text-right"><?= number_format($tot['total_ot_rs'],2) ?></td> -->
<td class="text-right"><?= number_format($tot['current_ctc_payable'],2) ?></td>
<td class="text-right"><?= number_format($tot['epf_payable'],2) ?></td>
<td class="text-right"><?= number_format($tot['esic_payable'],2) ?></td>
<td class="text-right"><?= number_format($tot['advance_this_month_payable'],2) ?></td>
<td class="text-right"><?= number_format($tot['total_deduction'],2) ?></td>
<td class="text-right"><?= number_format($tot['current_total_ctc_payable'],2) ?></td>
<td></td>
<td></td>


</tr>
</tfoot>

</table>

</body>
</html>
