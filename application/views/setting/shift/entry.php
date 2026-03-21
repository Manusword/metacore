<!-- ========= MENU MANAGEMENT PAGE ========= -->
<div class="main-content">
    <div class="breadcrumb">
        <h1>Shift Management</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- ACTION BAR -->
    <div class="mb-3 text-right">
        <button class="btn btn-success" onclick="openShiftModal()">+ New Shift</button>
    </div>

    <!-- MENU LIST -->
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-hover" style="width: 90%;" align="center">
                <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Id</th>
                    <th>Shift. Code</th>
                    <th>Shift. Name</th>
                    <th>In Time</th>
                    <th>Out Time (8hrs)</th>
                    <th>Out Time (12 hrs)</th>
                    <th>Status</th>
                    <th width="120">Action</th>
                </tr>
                </thead>

                <tbody>
                <?php $i=1; foreach($shifts as $m): ?>
                    <tr >
                        <td><?= $i++ ?></td>
                        <td><strong><?= $m['shift_id'] ?></strong></td>
                        <td><strong><?= $m['shift_code'] ?></strong></td>
                        <td><strong><?= $m['shift_name'] ?></strong></td>
                        <td><strong><?= $m['in_time'] ?></strong></td>
                        <td><strong><?= $m['out_time'] ?></strong></td>
                        <td><strong><?= $m['out_time_ot'] ?></strong></td>
                        <td>
                            <span class="badge <?= $m['status']=='Active'?'badge-success':'badge-danger' ?>">
                                <?= $m['status'] ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick='editShift(<?= json_encode($m) ?>)'>
                                Edit
                            </button>
                          </td>
                    </tr>

                    

                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>



<div class="modal fade" id="deptModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="deptTitle">Shift</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="shift_id">

        <div class="form-group">
        <label>Shift Code (Can't Update)</label>
        <input type="text" id="shift_code" class="form-control">
        </div>

        <div class="form-group">
        <label>Shift Name</label>
        <input type="text" id="shift_name" class="form-control">
        </div>

        <div class="form-group">
        <label>In Time (Write in 24 hours format)</label>
        <input type="time" id="in_time" class="form-control">
        </div>

        <div class="form-group">
        <label>Out Time  (Write in 24 hours format)</label>
        <input type="time" id="out_time" class="form-control">
        </div>

        <div class="form-group">
        <label>Out Time  (Write in 24 hours format) </label>
        <input type="time" id="out_time_ot" class="form-control">
        </div>

        <div class="form-group">
        <label>Status</label>
        <select id="status" class="form-control">
            <option value="Active">Active</option>
            <option value="Deactive">Deactive</option>
        </select>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-success" onclick="saveDept()">Save</button>
      </div>

    </div>
  </div>
</div>


<script>

function openShiftModal() {
    $('#shift_id').val('');
   $('#shift_code').val('').prop('readonly', false); // ENABLE
    $('#shift_name').val('');
    $('#in_time').val('');
    $('#out_time').val('');
    $('#out_time_ot').val('');
    $('#status').val('Active');
    $('#deptTitle').text('Add Shift');
    $('#deptModal').modal('show');
}

function editShift(d) {
    $('#shift_id').val(d.shift_id);
     $('#shift_code').val(d.shift_code).prop('readonly', true); // READONLY
    $('#shift_name').val(d.shift_name);
    $('#in_time').val(d.in_time);
    $('#out_time').val(d.out_time);
    $('#out_time_ot').val(d.out_time_ot);
    $('#status').val(d.status);
    $('#deptTitle').text('Edit Shift');
    $('#deptModal').modal('show');
}

function saveDept() {
    let payload = {
        shift_id: $('#shift_id').val(),
        shift_code: $('#shift_code').val().trim(),
        shift_name: $('#shift_name').val().trim(),
        in_time: $('#in_time').val(),
        out_time: $('#out_time').val(),
        out_time_ot: $('#out_time_ot').val(),
        status: $('#status').val()
    };

    if (!payload.shift_code || !payload.shift_name) {
        alert('Shift Code and Name are required');
        return;
    }

    $.post("<?= base_url('index.php/Page/add_shift_save') ?>", payload, function(res) {
        if (res === 'OK') {
            location.reload();
        } else {
            alert(res);
        }
    });
}

</script>
