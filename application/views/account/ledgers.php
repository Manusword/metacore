<div class="breadcrumb">
    <h1>Account Ledgers</h1>
    <ul>
        <li><a href="#">Account</a></li>
        <li>Ledgers</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <!-- Add Ledger Form -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Create Account Ledger</div>
                <form id="form_create_ledger">
                    <div class="form-group">
                        <label for="ledger_name">Ledger Name</label>
                        <input type="text" class="form-control" id="ledger_name" name="name" required placeholder="e.g. SBI Bank Account" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="group_id">Under Group</label>
                        <select class="form-control" id="group_id" name="group_id" required>
                            <option value="">-- Select Group --</option>
                            <?php foreach ($groups as $g): ?>
                                <option value="<?= $g['id'] ?>"><?= $g['name'] ?> (<?= $g['type'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="opening_balance">Opening Balance</label>
                                <input type="number" step="0.01" class="form-control" id="opening_balance" name="opening_balance" value="0.00">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="opening_type">Type</label>
                                <select class="form-control" id="opening_type" name="opening_type">
                                    <option value="Dr">Debit (Dr)</option>
                                    <option value="Cr">Credit (Cr)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description/Notes</label>
                        <textarea class="form-control" id="description" name="description" rows="2" placeholder="Account details, account number etc."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save Ledger</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Ledgers List Table -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Account Ledgers List</div>
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr style="background-color: #34425A; color: white;">
                                <th>#</th>
                                <th>Ledger Name</th>
                                <th>Group (Under)</th>
                                <th>Opening Balance</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($ledgers as $l): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td style="font-weight: bold; color: #111;"><?= $l['name'] ?></td>
                                    <td><span class="badge badge-secondary"><?= $l['group_name'] ?></span></td>
                                    <td style="font-weight: 500;">
                                        <?= ind_money_format($l['opening_balance'], true) ?> 
                                        <span class="text-small text-muted"><?= $l['opening_type'] ?></span>
                                    </td>
                                    <td style="font-size: 13px;"><?= $l['description'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#form_create_ledger').on('submit', function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $('.loader').show();
        $.post('<?= base_url("index.php/account/ledgers/save") ?>', data, function(res) {
            $('.loader').hide();
            if(res.trim() == 'Save') {
                fun_message('success', 'Ledger Created', 'Account Ledger successfully created.', 'toast-bottom-right');
                showPage('Account/ledgers');
            } else {
                fun_message('error', 'Error', res, 'toast-bottom-right');
            }
        });
    });
</script>
