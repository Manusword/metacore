<div class="breadcrumb">
    <h1>Ledger Book Statement</h1>
    <ul>
        <li><a href="#">Account</a></li>
        <li>Ledger Statement</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <!-- Filter Card -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form id="form_filter_statement">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label for="ledger_id">Select Ledger Account</label>
                                <select class="form-control" id="ledger_id" name="ledger_id" required>
                                    <option value="">-- Select Ledger --</option>
                                    <?php foreach ($ledgers as $l): ?>
                                        <option value="<?= $l['id'] ?>" <?= ($l['id'] == $ledger_id) ? 'selected' : '' ?>><?= $l['name'] ?> (<?= $l['group_name'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2.5">
                            <div class="form-group mb-0">
                                <label for="from_date">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date" value="<?= $from_date ?>" required>
                            </div>
                        </div>
                        <div class="col-md-2.5">
                            <div class="form-group mb-0">
                                <label for="to_date">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date" value="<?= $to_date ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Show Statement</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($ledger_id) && !empty($statement)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-6">
                            <h3 class="card-title mb-0" style="font-weight: bold; font-size: 1.3rem;">
                                Statement of: <?= $statement['ledger']['name'] ?>
                            </h3>
                            <span class="text-muted">Under: <?= $statement['ledger']['description'] ?: 'General Account' ?></span>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-success" onclick="fun_export_xls()">Export Excel</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="printed_table">
                            <thead>
                                <tr style="background-color: #34425A; color: white;">
                                    <th>Date</th>
                                    <th>Particulars</th>
                                    <th>Voucher No</th>
                                    <th class="text-right">Debit (Dr) (₹)</th>
                                    <th class="text-right">Credit (Cr) (₹)</th>
                                    <th class="text-right">Balance (₹)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Opening Balance -->
                                <tr style="background-color: #f8f9fa; font-weight: bold;">
                                    <td><?= date('d-m-Y', strtotime($from_date)) ?></td>
                                    <td colspan="2">Opening Balance</td>
                                    <td class="text-right"><?= ($statement['opening_type'] === 'Dr') ? ind_money_format($statement['opening_balance']) : '0.00' ?></td>
                                    <td class="text-right"><?= ($statement['opening_type'] === 'Cr') ? ind_money_format($statement['opening_balance']) : '0.00' ?></td>
                                    <td class="text-right">
                                        <?= ind_money_format($statement['opening_balance'], true) ?> 
                                        <span class="text-muted text-small"><?= $statement['opening_type'] ?></span>
                                    </td>
                                </tr>

                                <?php 
                                    $running_bal = ($statement['opening_type'] === 'Dr') ? $statement['opening_balance'] : -$statement['opening_balance'];
                                    $total_dr = ($statement['opening_type'] === 'Dr') ? $statement['opening_balance'] : 0;
                                    $total_cr = ($statement['opening_type'] === 'Cr') ? $statement['opening_balance'] : 0;

                                    foreach ($statement['entries'] as $e):
                                        $dr_amt = ($e['entry_type'] === 'Dr') ? floatval($e['amount']) : 0;
                                        $cr_amt = ($e['entry_type'] === 'Cr') ? floatval($e['amount']) : 0;

                                        $total_dr += $dr_amt;
                                        $total_cr += $cr_amt;
                                        $running_bal += ($dr_amt - $cr_amt);

                                        $disp_running_bal = abs($running_bal);
                                        $disp_running_type = ($running_bal >= 0) ? 'Dr' : 'Cr';
                                ?>
                                    <tr>
                                        <td><?= date('d-m-Y', strtotime($e['date'])) ?></td>
                                        <td><?= $e['voucher_type'] ?> - <?= $e['narration'] ?></td>
                                        <td><span class="badge badge-light text-12"><?= $e['voucher_no'] ?></span></td>
                                        <td class="text-right text-success"><?= ($dr_amt > 0) ? ind_money_format($dr_amt) : '-' ?></td>
                                        <td class="text-right text-danger"><?= ($cr_amt > 0) ? ind_money_format($cr_amt) : '-' ?></td>
                                        <td class="text-right" style="font-weight: 500;">
                                            <?= ind_money_format($disp_running_bal, true) ?> 
                                            <span class="text-muted text-small"><?= $disp_running_type ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- Closing Balance Row -->
                                <tr style="background-color: #e9ecef; font-weight: bold; border-top: 2px solid #333;">
                                    <td colspan="3" class="text-right">Total transactions & Closing Balance:</td>
                                    <td class="text-right"><?= ind_money_format($total_dr, true) ?></td>
                                    <td class="text-right"><?= ind_money_format($total_cr, true) ?></td>
                                    <td class="text-right" style="font-weight: bold; color: green; font-size: 1.1rem;">
                                        <?= ind_money_format(abs($running_bal), true) ?> 
                                        <span class="text-muted text-small"><?= ($running_bal >= 0) ? 'Dr' : 'Cr' ?></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif (!empty($ledger_id)): ?>
    <div class="alert alert-warning text-center">No transaction records found for this ledger.</div>
<?php endif; ?>

<script>
    $('#form_filter_statement').on('submit', function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $('.loader').show();
        $.post('<?= base_url("index.php/account/ledger_statement") ?>', data, function(res) {
            $('.loader').hide();
            $('#page_show').html(res);
        });
    });
</script>
