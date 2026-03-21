<?php


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
        

    <p align="center">
        <b>Name & Address of Establishment:</b><br>
        <?= $role_list ?><br>
    </p>

    <p align="center">
        <b>Wage Period:</b> <?= $month_name ?><br>
    </p>


    <h3 align="center"></h3>

    <p><b>Print Date:</b> <?= date('d-m-Y') ?></p>
    
        <table  style="font-size: 12px;" id="printed_table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Emp Code </th>
                    <th>Bio Code </th>
                    <th>Employee Name </th>
                    <th>Dept </th>
                    
                    <th>Leave Eligible ?</th>
                    <th>Total Leave Allotted</th>
                    <th>CL Allotted</th>
                    <th>SL Allotted</th>
                    <th>EL Allotted</th>
                    <!-- <th>OL Allotted</th> -->
                    <th>CL Taken</th>
                    <th>SL Taken</th>
                    <th>EL Taken</th>
                    <!-- <th>OL Taken</th> -->
                    <th>Total Leave Taken</th>
                    <th>Rem. Leave</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($rows): ?>
                <?php $i=1; foreach ($rows as $r): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $r['emp_code'] ?></td>
                    <td><?= $r['bio_code'] ?></td>

                    <td class="text-left" <?= ($r['active'] == 'Deactive') ? "style='background-color:red;color:#fff;'" : '' ?>>
                        <?= $r['first_name'].' '.$r['last_name'] ?>
                    </td>

                    <td><?= $r['department'] ?></td>

                    <td><?= $r['is_leave_eligible'] ?></td>

                    <!-- Leave Allotted (Show only if > 0) -->
                    <td><?= ($r['leave_yearly'] > 0) ? $r['leave_yearly'] : '' ?></td>
                    <td><?= ($r['leave_cl'] > 0) ? $r['leave_cl'] : '' ?></td>
                    <td><?= ($r['leave_sl'] > 0) ? $r['leave_sl'] : '' ?></td>
                    <td><?= ($r['leave_el'] > 0) ? $r['leave_el'] : '' ?></td>
                    <!-- <td><?= ($r['leave_ol'] > 0) ? $r['leave_ol'] : '' ?></td> -->

                    <!-- Leave Used (Red if limit cross or equal) -->
                    <td>
                        <?php
                        if ($r['total_cl'] > 0) {
                            $class = ($r['total_cl'] >= $r['leave_cl']) ? 'text-danger fw-bold' : '';
                            echo "<span class='$class'>{$r['total_cl']}</span>";
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        if ($r['total_sl'] > 0) {
                            $class = ($r['total_sl'] >= $r['leave_sl']) ? 'text-danger fw-bold' : '';
                            echo "<span class='$class'>{$r['total_sl']}</span>";
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        if ($r['total_el'] > 0) {
                            $class = ($r['total_el'] >= $r['leave_el']) ? 'text-danger fw-bold' : '';
                            echo "<span class='$class'>{$r['total_el']}</span>";
                        }
                        ?>
                    </td>

                    <!-- <td>
                        <?php
                        if ($r['total_ol'] > 0) {
                            $class = ($r['total_ol'] >= $r['leave_ol']) ? 'text-danger fw-bold' : '';
                            echo "<span class='$class'>{$r['total_ol']}</span>";
                        }
                        ?>
                    </td> -->

                    <!-- Total Used -->
                    <td>
                        <?= ($r['use_leave'] > 0) ? $r['use_leave'] : '' ?>
                    </td>

                    <!-- Remaining Leave Badge -->
                    <td>
                        <?php if ($r['rem_leave'] <= 0): ?>
                            <span class="badge bg-danger">0</span>
                        <?php else: ?>
                            <span class="badge bg-success"><?= $r['rem_leave'] ?></span>
                        <?php endif; ?>
                    </td>

                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="18">No Records Found</td></tr>
                <?php endif; ?>
                </tbody>

            

        </table>
    
 </div>