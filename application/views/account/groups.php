<div class="breadcrumb">
    <h1>Account Groups</h1>
    <ul>
        <li><a href="#">Account</a></li>
        <li>Groups</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <!-- Add Group Form -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Create Account Group</div>
                <form id="form_create_group">
                    <div class="form-group">
                        <label for="group_name">Group Name</label>
                        <input type="text" class="form-control" id="group_name" name="name" required placeholder="e.g. Indirect Expenses" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Parent Group (Under)</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="">-- Primary Group --</option>
                            <?php foreach ($groups as $g): ?>
                                <option value="<?= $g['id'] ?>"><?= $g['name'] ?> (<?= $g['type'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="group_type">Group Type</label>
                        <select class="form-control" id="group_type" name="type" required>
                            <option value="Asset">Asset</option>
                            <option value="Liability">Liability</option>
                            <option value="Income">Income</option>
                            <option value="Expense">Expense</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save Group</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Groups List Table -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title">Account Groups List</div>
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr style="background-color: #34425A; color: white;">
                                <th>#</th>
                                <th>Group Name</th>
                                <th>Parent Group</th>
                                <th>Nature / Type</th>
                                <th>System Group</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($groups as $g): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td style="font-weight: bold;"><?= $g['name'] ?></td>
                                    <td><?= $g['parent_name'] ? $g['parent_name'] : '<span class="text-muted">Primary</span>' ?></td>
                                    <td>
                                        <span class="badge badge-secondary text-12"><?= $g['type'] ?></span>
                                    </td>
                                    <td>
                                        <?php if ($g['system_group']): ?>
                                            <span class="badge badge-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge badge-light">No</span>
                                        <?php endif; ?>
                                    </td>
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
    $('#form_create_group').on('submit', function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $('.loader').show();
        $.post('<?= base_url("index.php/account/groups/save") ?>', data, function(res) {
            $('.loader').hide();
            if(res.trim() == 'Save') {
                fun_message('success', 'Group Created', 'Account Group successfully created.', 'toast-bottom-right');
                showPage('Account/groups');
            } else {
                fun_message('error', 'Error', res, 'toast-bottom-right');
            }
        });
    });
</script>
