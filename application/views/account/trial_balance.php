<div class="breadcrumb">
    <h1>Trial Balance</h1>
    <ul>
        <li><a href="#">Account</a></li>
        <li>Trial Balance</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12 text-right mb-3">
        <button type="button" class="btn btn-success" onclick="fun_export_xls()">Export Excel</button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Trial Balance Sheet</div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped" id="printed_table">
                        <thead>
                            <tr style="background-color: #34425A; color: white;">
                                <th>#</th>
                                <th>Ledger Account Name</th>
                                <th>Under Group</th>
                                <th>Opening Balance</th>
                                <th class="text-right">Debit Total (₹)</th>
                                <th class="text-right">Credit Total (₹)</th>
                                <th class="text-right">Closing Balance (Dr/Cr) (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($rows)): ?>
                                <?php $i = 1; foreach ($rows as $r): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td style="font-weight: bold; color: #111;"><?= $r['name'] ?></td>
                                        <td><span class="badge badge-secondary"><?= $r['group'] ?></span></td>
                                        <td><?= $r['opening'] ?></td>
                                        <td class="text-right text-success"><?= ($r['dr_total'] > 0) ? ind_money_format($r['dr_total']) : '-' ?></td>
                                        <td class="text-right text-danger"><?= ($r['cr_total'] > 0) ? ind_money_format($r['cr_total']) : '-' ?></td>
                                        <td class="text-right" style="font-weight: 500;">
                                            <?= ind_money_format($r['closing_amount'], true) ?> 
                                            <span class="text-muted text-small"><?= $r['closing_type'] ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                
                                <!-- Grand Total Row -->
                                <tr style="background-color: #e9ecef; font-weight: bold; border-top: 2px solid #333;">
                                    <td colspan="4" class="text-right">Grand Total (Dr / Cr Balance matching Check):</td>
                                    <td class="text-right" style="font-size: 1.1rem; color: green;"><?= ind_money_format($total_dr, true) ?></td>
                                    <td class="text-right" style="font-size: 1.1rem; color: green;"><?= ind_money_format($total_cr, true) ?></td>
                                    <td class="text-center">
                                        <?php if (abs($total_dr - $total_cr) < 0.01): ?>
                                            <span class="badge badge-success text-13">Matched ✓</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger text-13">Difference: <?= ind_money_format(abs($total_dr - $total_cr), true) ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No trial balance records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
