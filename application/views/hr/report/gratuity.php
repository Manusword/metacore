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

<h3 align="center"><b>GRATUITY REPORT</b></h3>
<p align="center">
<b><?= $role_list ?></b><br>

<b>As on:</b> <?= date('d-m-Y') ?>
</p>

<table style="font-size:12px;" id="printed_table">
<thead>
<tr>
    <th>S.No</th>
    <th>Emp Code</th>
    <th>Bio Code</th>
    <th>Employee Name</th>
    <th>Date of Joining</th>
    <th>Date of Relieving</th>
    <th>Service (Years)</th>
    <th>Last Basic</th>
    <th>Gratuity Amount</th>
</tr>
</thead>

<tbody>
<?php if($rows): $i=1; foreach($rows as $r):

$doj = new DateTime($r['doj']);
$dor = !empty($r['dor']) && $r['dor']!='0000-00-00'
        ? new DateTime($r['dor'])
        : new DateTime();

$years = $doj->diff($dor)->y;
$gratuity = ($r['basic_salary'] * $years * 15) / 26;
?>
<tr>
    <td><?= $i++ ?></td>
    <td><?= $r['emp_code'] ?></td>
    <td><?= $r['bio_code'] ?></td>
    <td class="text-left" <?php if($r['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>><?= $r['first_name'].' '.$r['last_name'] ?></td>
    <td><?= date('d-m-Y',strtotime($r['doj'])) ?></td>
    <td><?= !empty($r['dor']) && $r['dor']!='0000-00-00' ? date('d-m-Y',strtotime($r['dor'])) : '-' ?></td>
    <td><?= $years ?></td>
    <td class="text-right"><?= number_format($r['basic_salary'],2) ?></td>
    <td class="text-right"><?= number_format($gratuity,2) ?></td>
</tr>
<?php endforeach; else: ?>
<tr><td colspan="9">No Records Found</td></tr>
<?php endif; ?>
</tbody>
</table>

</div>
