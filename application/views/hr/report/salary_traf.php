<?php


$role_list='';
if (!empty($type_search_list) && is_array($type_search_list)) {    
    $role_list = implode(",", $type_search_list);
}
    $month_name = date('F Y', strtotime($year.'-'.$month.'-01'));

    $rows = $rows ?? [];

    /* INIT TOTALS */
    $tot = [
        'current_total_ctc_payable' => 0,
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
                    <th>Net Salary / Wages</th>
                    <th>NEFT</th>
                    <th>Debt. Account No.</th>
                    <th>Transfer Amt.</th>
                    <th>Curr</th>
                    <!-- <th>Bank Name</th> -->
                    <th>Emp. Account No</th>
                    <th>IFSC</th>
                    <th>Remarks</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($rows): ?>
                <?php $i=1; foreach ($rows as $r): 

                foreach ($tot as $k => $v) {
                    $tot[$k] += (float)($r[$k] ?? 0);
                }
                $a = '0605008700007056';
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $r['emp_code'] ?> </td>
                    <td><?= $r['bio_code'] ?> </td>
                    <td class="text-left" <?php if($r['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>><?= $r['first_name'].' '.$r['last_name'] ?> </span></td>
                    <td><?= $r['department'] ?> </td>
                    <td class="text-right bold"><?= number_format($r['current_total_ctc_payable'],2) ?></td>
                    <td>NFT </td>
                    <td data-value="<?= (string)$a ?>">
                        <?= (string)$a ?>
                    </td>
                    <td class="text-right bold"><?= number_format($r['current_total_ctc_payable'],2) ?></td>
                    <td>INR</td>
                   
                    <!-- <td><?= $r['bank_name'] ?> </td> -->
                    <!-- <td style="mso-number-format:'\@';"><?= $r['bank_account'] ?></td> -->
                   <td data-value="<?= (string)$r['bank_account'] ?>">
                        <?= (string)$r['bank_account'] ?>
                    </td>
                    <td><?= $r['bank_ifsc'] ?> </td>
                    <td><?= $month_name ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="13">No Records Found</td></tr>
                <?php endif; ?>
            </tbody>

            <tfoot>
                <tr class="bold">
                    <td colspan="5">GRAND TOTAL</td>
                    <td class="text-right"><?= number_format($tot['current_total_ctc_payable'],2) ?></td>
                    <td colspan="2"></td>
                    <td class="text-right"><?= number_format($tot['current_total_ctc_payable'],2) ?></td>
                    <td colspan="4"></td>
                </tr>
            </tfoot>

        </table>
    
 </div>