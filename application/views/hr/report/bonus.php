<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$role_list='';
if (!empty($type_search_list) && is_array($type_search_list)) {    
    $role_list = implode(",", $type_search_list);
}
$month_name = date('F Y', strtotime($year.'-'.$month.'-01'));

$rows = $rows ?? [];

/* INIT TOTALS */
$tot = [
    'basic_salary' => 0,
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

<h3 align="center"><b>BONUS REPORT</b></h3>
<p align="center">
<b><?= $role_list ?></b><br>

<b>Bonus Period:</b> <?= $month_name ?>
</p>

<table style="font-size:12px;" id="printed_table">
<thead>
<tr>
    <th>S.No</th>
    <th>Emp Code</th>
    <th>Bio Code</th>
    <th>Employee Name</th>
    <th>Days Worked</th>
    <th>Basic Salary</th>
    <th>Bonus %</th>
    <th>Bonus Amount</th>
</tr>
</thead>

<tbody>
<?php if($rows): $i=1; foreach($rows as $r):

$bonus_percent = 8.33; // change if required
$bonus_amount = ($r['basic_salary'] * $bonus_percent) / 100;
?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= $r['emp_code'] ?></td>
    <td><?= $r['bio_code'] ?></td>
    <td class="text-left" <?php if($r['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>><?= $r['first_name'].' '.$r['last_name'] ?></td>
    <td><?= $r['total_present'] ?></td>
    <td class="text-right"><?= number_format($r['basic_salary'],2) ?></td>
    <td><?= $bonus_percent ?>%</td>
    <td class="text-right"><?= number_format($bonus_amount,2) ?></td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="8">No Records Found</td></tr>
<?php endif; ?>
</tbody>
</table>

</div>
