<div class="breadcrumb">
    <h1>Day Book</h1>
    <ul>
        <li><a href="#">Account</a></li>
        <li>Day Book</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <!-- Filter Card -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form id="form_filter_daybook">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label for="from_date">From Date</label>
                                <input type="date" class="form-control" id="from_date" name="from_date" value="<?= $from_date ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label for="to_date">To Date</label>
                                <input type="date" class="form-control" id="to_date" name="to_date" value="<?= $to_date ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Filter Vouchers</button>
                        </div>
                        <div class="col-md-3 text-right">
                            <button type="button" class="btn btn-success" onclick="fun_export_xls()">Export Excel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Vouchers List (Day Book)</div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="printed_table">
                        <thead>
                            <tr style="background-color: #34425A; color: white;">
                                <th>#</th>
                                <th>Date</th>
                                <th>Voucher No</th>
                                <th>Voucher Type</th>
                                <th>Ledger Account Entries (Double Entry)</th>
                                <th>Narration</th>
                                <th class="text-right">Total Amount (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($vouchers)): ?>
                                <?php $i = 1; foreach ($vouchers as $v): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= date('d-m-Y', strtotime($v['date'])) ?></td>
                                        <td><span class="badge badge-primary text-13"><?= $v['voucher_no'] ?></span></td>
                                        <td><span class="badge badge-warning text-13"><?= $v['type'] ?></span></td>
                                        <td style="font-size: 13px; color: #555;"><?= $v['entry_details'] ?></td>
                                        <td><?= $v['narration'] ?></td>
                                        <td class="text-right" style="font-weight: bold; color: #111;"><?= ind_money_format($v['total_amount'], true) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No vouchers found in this date range.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#form_filter_daybook').on('submit', function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $('.loader').show();
        $.post('<?= base_url("index.php/account/daybook") ?>', data, function(res) {
            $('.loader').hide();
            $('#page_show').html(res);
        });
    });
</script>
