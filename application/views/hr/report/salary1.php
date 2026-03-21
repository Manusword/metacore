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
    'hra' => 0,
    'other_allow' => 0,
    'current_ctc' => 0,
    'total_present' => 0,

    'basic_salary_payable' => 0,
    'hra_payable' => 0,
    'other_allow_payable' => 0,
    'current_ctc_payable' => 0,

    'epf_payable' => 0,
    'esic_payable' => 0,

    'advance_this_month_payable' => 0,
    'lost_1_payable' => 0,
    'lost_2_payable' => 0,
    'lost_3_payable' => 0,

    'total_deduction' => 0,
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
    <!-- <h2 align='center' ><?php echo $role_list;?></h2> -->
    <h3 align="center"><b>FORM XVII</b></h3>
    <p align="center">
        [See Rule 78(1)(a)]<br>
        Register of Wages<br>
        Wage Period:<b> <?= $month_name ?></b>
    </p>
    

    <?php /*
    <table width="100%" border="1" cellspacing="0" cellpadding="4" style="font-size:12px;" class="no-print">
        <thead>
            <tr style="background:#f2f2f2;">
                <th>#</th>
                <th>Code</th>
                <th>Company Name</th>
                <th>Address</th>
                <th>PF Code</th>
                <th>ESI No</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($company_list as $i => $c): ?>
                <tr>
                    <td><?= $i+1 ?></td>
                    <td><?= $c['name'] ?? '' ?></td>
                    <td><?= $c['full_name'] ?? '' ?></td>
                    <td><?= $c['address'] ?? '' ?></td>
                    <td><?= $c['pf_code'] ?? '-' ?></td>
                    <td><?= $c['esi_no'] ?? '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    */?>



    <p>Print Date:<b><?= date('d-m-Y') ?></b> </p>
    
        <table  style="font-size: 12px;" id="printed_table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Emp Code <br><span class="bordet-top">Bio Code</span></th>
                    <!-- <th>Bio</th> -->
                    <th width="100">Emp Name <br><span class="bordet-top">Father Name</span></th>
                    <th width="50">Payroll Unit. <br><span class="bordet-top">Working Unit.</span></th>
                    <!-- <th>Father</th> -->
                    <th>DOJ</th>
                    <th width="60">Dept. <br><span class="bordet-top">Desig.</span></th>
                    <!-- <th>Desig</th> -->
                    <th>ESI</th>
                    <th>EPF</th>

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

                    

                    <th>Epf wages</th>
                    <th>EPF</th>
                    <th>ESIC</th>
                    <th>Loan <br> Advance <br> Fine, TDS</th>
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
                <?php $i=1; $toalpf=array(); foreach ($rows as $r): 

                foreach ($tot as $k => $v) {
                    $tot[$k] += (float)($r[$k] ?? 0);
                }
                ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $r['emp_code'] ?> <br><span class="bordet-top"><?= $r['bio_code'] ?></span></td>
                    <!-- <td><?= $r['bio_code'] ?></td> -->
                    <td class="text-left" <?php if($r['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>><?= $r['first_name'].' '.$r['last_name'] ?> <br><span class="bordet-top"><?= $r['father_name'] ?></span></td>
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
                    
                    <td class="text-right"><?php if($r['pf_ded'] == "Yes"){ $toalpf[] = $r['basic_salary_payable']; echo number_format($r['basic_salary_payable'],2);} ?></td>
                    <td class="text-right"><?= number_format($r['epf_payable'],2) ?></td>
                    <td class="text-right"><?= number_format($r['esic_payable'],2) ?></td>
                    <td class="text-right"><?= number_format(($r['advance_this_month_payable'] + $r['lost_1_payable'] + $r['lost_2_payable'] + $r['lost_3_payable']),2) ?></td>
                    <td class="text-right"><?= number_format($r['total_deduction'],2) ?></td>
                    <td class="text-right bold"><?= number_format($r['current_total_ctc_payable'],2) ?></td>
                    <td><?= $r['increment_amt'] ?></td>
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
                    <td class="text-right"><?= number_format(array_sum($toalpf)) ?></td>
                    <td class="text-right"><?= number_format($tot['epf_payable'],2) ?></td>
                    <td class="text-right"><?= number_format($tot['esic_payable'],2) ?></td>
                    <td class="text-right">
                    <?= number_format(
                        $tot['advance_this_month_payable']
                    + $tot['lost_1_payable']
                    + $tot['lost_2_payable']
                    + $tot['lost_3_payable'], 2
                    ) ?>
                    </td>
                    <td class="text-right"><?= number_format($tot['total_deduction'],2) ?></td>
                    <td class="text-right"><?= number_format($tot['current_total_ctc_payable'],2) ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>

        </table>
    
 </div>