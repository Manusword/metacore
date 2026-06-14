<div class="breadcrumb">
    <h1>Double Entry Voucher Entry</h1>
    <ul>
        <li><a href="#">Account</a></li>
        <li>Voucher</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Accounting Voucher (Tally Mode)</div>
                <form id="form_voucher_entry">
                    <!-- Voucher Header -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="voucher_type">Voucher Type</label>
                                <select class="form-control" id="voucher_type" name="type" required>
                                    <option value="Receipt">Receipt (F6)</option>
                                    <option value="Payment">Payment (F5)</option>
                                    <option value="Contra">Contra (F4)</option>
                                    <option value="Journal">Journal (F7)</option>
                                    <option value="Sales">Sales (F8)</option>
                                    <option value="Purchase">Purchase (F9)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="voucher_date">Voucher Date</label>
                                <input type="date" class="form-control" id="voucher_date" name="date" required value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Voucher Entries Table -->
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-striped" id="table_voucher_entries">
                            <thead>
                                <tr style="background-color: #34425A; color: white;">
                                    <th style="width: 10%;">Dr / Cr</th>
                                    <th style="width: 25%;">Category / Group Filter</th>
                                    <th style="width: 35%;">Ledger Account</th>
                                    <th style="width: 20%;">Amount (₹)</th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_voucher_rows">
                                <!-- Dynamic rows will be inserted here by JS -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right" style="font-weight: bold; vertical-align: middle;">Total Debit:</td>
                                    <td>
                                        <input type="text" class="form-control" id="total_debit_display" readonly style="font-weight: bold; color: green; background-color: #f1f1f1;" value="0.00">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right" style="font-weight: bold; vertical-align: middle;">Total Credit:</td>
                                    <td>
                                        <input type="text" class="form-control" id="total_credit_display" readonly style="font-weight: bold; color: green; background-color: #f1f1f1;" value="0.00">
                                    </td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #fff3cd;">
                                    <td colspan="3" class="text-right" style="font-weight: bold; vertical-align: middle;">Difference:</td>
                                    <td>
                                        <input type="text" class="form-control" id="difference_display" readonly style="font-weight: bold; color: red; background-color: #f1f1f1;" value="0.00">
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Add Row Button -->
                    <button type="button" class="btn btn-secondary btn-sm mb-3" id="btn_add_voucher_row">
                        <i class="i-Add"></i> Add Row
                    </button>

                    <!-- Narration -->
                    <div class="form-group mt-3">
                        <label for="narration">Narration / Remarks</label>
                        <textarea class="form-control" id="narration" name="narration" rows="3" placeholder="Enter transaction explanation..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block" id="btn_submit_voucher">Save Voucher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Load options JSON for Javascript usage -->
<script type="text/javascript">
    var ledgerOptions = [
        <?php foreach ($ledgers as $l): ?>
            { id: "<?= $l['id'] ?>", name: "<?= addslashes($l['name']) ?>", group_id: "<?= $l['group_id'] ?>", group_name: "<?= addslashes($l['group_name']) ?>" },
        <?php endforeach; ?>
    ];
</script>

<!-- Load external modular JS view file -->
<?php $this->load->view('js/account/voucher_js'); ?>
