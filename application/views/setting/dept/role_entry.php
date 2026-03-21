<!-- ========= MENU MANAGEMENT PAGE ========= -->
<div class="main-content">
    <div class="breadcrumb">
        <h1>Designation Management</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- ACTION BAR -->
    <div class="mb-3 text-right">
        <button class="btn btn-success" onclick="openDesignationModal()">+ New Designation</button>
    </div>

    <!-- MENU LIST -->
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-hover" style="width: 50%;" align="center">
                <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Id</th>
                     <th>Designation Name</th>
                    <th>Status</th>
                    <th width="120">Action</th>
                </tr>
                </thead>

                <tbody>
                <?php $i=1; foreach($role as $m): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><strong><?= $m['role_id'] ?></strong></td>
                        <td><strong><?= $m['name'] ?></strong></td>
                        <td>
                            <span class="badge <?= $m['status']=='Active'?'badge-success':'badge-danger' ?>">
                                <?= $m['status'] ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick='editDesignation(<?= json_encode($m) ?>)'>
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


<div class="modal fade" id="designationModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="designationTitle">Designation</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="designation_id">

        <div class="form-group">
          <label>Designation Name</label>
          <input type="text" id="designation_name" class="form-control">
        </div>

        <div class="form-group">
          <label>Status</label>
          <select id="designation_status" class="form-control">
            <option value="Active">Active</option>
            <option value="Deactive">Deactive</option>
          </select>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-success" onclick="saveDesignation()">Save</button>
      </div>

    </div>
  </div>
</div>


<script>


function openDesignationModal() {
    $('#designation_id').val('');
    $('#designation_name').val('');
    $('#designation_status').val('Active');
    $('#designationTitle').text('Add Designation');
    $('#designationModal').modal('show');
}

function editDesignation(d) {
    $('#designation_id').val(d.role_id);
    $('#designation_name').val(d.name);
    $('#designation_status').val(d.status);
    $('#designationTitle').text('Edit Designation');
    $('#designationModal').modal('show');
}

function saveDesignation() {
    let payload = {
        id: $('#designation_id').val(),
        name: $('#designation_name').val().trim(),
        status: $('#designation_status').val()
    };

    if (!payload.name) {
        alert('Designation name is required');
        return;
    }

    $.post("<?= base_url('index.php/Page/add_designation_save') ?>", payload, function (res) {
        if (res === 'OK') {
            location.reload();
        } else {
            alert(res);
        }
    });
}
</script>

