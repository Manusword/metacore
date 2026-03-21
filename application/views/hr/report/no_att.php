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
table{
    width:100%;
    border-collapse:collapse;
    font-size:11px;
}
th,td{
    border:1px solid #000;
    padding:4px;
    text-align:center;
}
th{
    background:#eaeaea;
}
.text-left{ text-align:left; }
.bold{ font-weight:bold; }
</style>

<div id="print-area">

    <h3 align="center"><b>NO ATTENDANCE EMPLOYEE REPORT</b></h3>

    <p align="center">
        <b><?= $role_list ?></b>
    </p>

    <p align="center">
        <b>Month :</b> <?= $month_name ?>
    </p>

    <p>
        <b>Print Date :</b> <?= date('d-m-Y') ?>
    </p>

    <table id="printed_table">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Emp Code</th>
                 <th>Bio Code</th>
                <th>Employee Name</th>
                 <th>Father Name</th>
                <th>Department</th>
                 <th>Designation</th>
                <th>Working Unit</th>
                <th>DOJ</th>
                <th>ESI No</th>
                <th>UAN</th>
                <th>Status</th>
                <th>Remark</th>
            </tr>
        </thead>

        <tbody>
        <?php if($rows): ?>
            <?php $i=1; foreach($rows as $r): ?>
            <tr>
                <td><?= $i++ ?></td>

                <td>
                    <?= $r['emp_code'] ?><br>
                </td>
                <td>
                    <?= $r['bio_code'] ?>
                </td>

                <td class="text-left" <?php if($r['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>>
                    <?= $r['first_name'].' '.$r['last_name'] ?><br>
                </td>
                <td class="text-left">
                    <?= $r['father_name'] ?>
                </td>

                <td>
                    <?= $r['department'] ?><br>
                </td>
                <td>
                    <?= $r['designation'] ?>
                </td>

                <td><?= $r['plant'] ?></td>

                <td>
                    <?php
                    if(!empty($r['doj']) && $r['doj']!='0000-00-00'){
                        echo date('d-m-Y',strtotime($r['doj']));
                    }
                    ?>
                </td>

                <td><?= $r['esi_code'] ?></td>
                <td><?= $r['emp_uan'] ?></td>

               <td class="bold" style="<?= ($r['active']=='Deactive')?'color:red':'' ?>">
                    <?= $r['active'] ?>
                </td>
                <td class="bold">NO ATTENDANCE FOUND</td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="13">No Records Found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>
