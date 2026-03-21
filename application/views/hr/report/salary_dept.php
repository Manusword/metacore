<?php
$month_name = date('F Y', strtotime($year.'-'.$month.'-01'));
$rows = $rows ?? [];

/* collect companies */
$companies = [];
foreach ($rows as $r) {
    $companies[$r['company']] = true;
}
$companies = array_keys($companies);

/* pivot data */
$report = [];
$grand = array_fill_keys($companies, 0);
$grand['total'] = 0;

foreach ($rows as $r) {
    $dept = $r['dept'];
    $comp = $r['company'];
    $amt  = (float)$r['amount'];

    if (!isset($report[$dept])) {
        $report[$dept] = array_fill_keys($companies, 0);
        $report[$dept]['total'] = 0;
    }

    $report[$dept][$comp] += $amt;
    $report[$dept]['total'] += $amt;

    $grand[$comp] += $amt;
    $grand['total'] += $amt;
}
?>


<style>
table{width:100%;border-collapse:collapse;font-size:12px}
th,td{border:1px solid #000;padding:4px;text-align:right}
th{background:#eaeaea;text-align:center}
.text-left{text-align:left}
.bold{font-weight:bold}
</style>


<div id="print-area">

<p align="center"><b>Department wise Company Salary Summary</b></p>
<p align="center"><b>Wage Period:</b> <?= $month_name ?></p>
<p><b>Print Date:</b> <?= date('d-m-Y') ?></p>

<table id="printed_table">
    <thead>
        <tr>
            <th width='30px'>Sno</th>
            <th>Dept</th>
            <?php foreach ($companies as $c): ?>
                <th><?= htmlspecialchars($c) ?></th>
            <?php endforeach; ?>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php $i=1;if ($report): ?>
            <?php foreach ($report as $dept => $data): ?>
            <tr>
                <td class="text-left bold"><?= $i ?></td>
                <td class="text-left bold"><?= htmlspecialchars($dept) ?></td>
                <?php foreach ($companies as $c): ?>
                    <td><?= number_format($data[$c],2) ?></td>
                <?php endforeach; ?>
                <td class="bold"><?= number_format($data['total'],2) ?></td>
            </tr>
            <?php $i++; endforeach; ?>
        <?php else: ?>
            <tr><td colspan="<?= count($companies)+2 ?>">No Records Found</td></tr>
        <?php endif; ?>
    </tbody>

    <tfoot>
        <tr class="bold">
            <td></td>
             <td>GRAND TOTAL</td>
            <?php foreach ($companies as $c): ?>
                <td><?= number_format($grand[$c],2) ?></td>
            <?php endforeach; ?>
            <td><?= number_format($grand['total'],2) ?></td>
        </tr>
    </tfoot>
</table>

</div>