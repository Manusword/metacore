<!-- ========= MENU MANAGEMENT PAGE ========= -->
<div class="main-content">
    <div class="breadcrumb">
        <h1>Department Management</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- ACTION BAR -->
    <div class="mb-3 text-right">
        <button class="btn btn-success" onclick="openDeptModal()">+ New Department</button>
    </div>

    <!-- MENU LIST -->
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-hover" style="width: 50%;" align="center">
                <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Id</th>
                    <th>Dept. Name</th>
                    <th>Status</th>
                    <th width="120">Action</th>
                </tr>
                </thead>

                <tbody>
                <?php $i=1; foreach($dept as $m): ?>
                    <tr >
                        <td><?= $i++ ?></td>
                        <td><strong><?= $m['department_id'] ?></strong></td>
                        <td><strong><?= $m['name'] ?></strong></td>
                        <td>
                            <span class="badge <?= $m['status']=='Active'?'badge-success':'badge-danger' ?>">
                                <?= $m['status'] ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick='editDept(<?= json_encode($m) ?>)'>
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
        <h5 id="deptTitle">Department</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="dept_id">

        <div class="form-group">
          <label>Department Name</label>
          <input type="text" id="dept_name" class="form-control">
        </div>

        <div class="form-group">
          <label>Status</label>
          <select id="dept_status" class="form-control">
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


function openDeptModal() {
    $('#dept_id').val('');
    $('#dept_name').val('');
    $('#dept_status').val('Active');
    $('#deptTitle').text('Add Department');
    $('#deptModal').modal('show');
}

function editDept(d) {
    $('#dept_id').val(d.department_id );
    $('#dept_name').val(d.name);
    $('#dept_status').val(d.status);
    $('#deptTitle').text('Edit Department');
    $('#deptModal').modal('show');
}

function saveDept() {
    let payload = {
        id: $('#dept_id').val(),
        name: $('#dept_name').val().trim(),
        status: $('#dept_status').val()
    };

    if (!payload.name) {
        alert('Department name required');
        return;
    }

    $.post("<?= base_url('index.php/Page/add_department_save') ?>", payload, function (res) {
        if (res === 'OK') {
            location.reload();
        } else {
            alert(res);
        }
    });
}
</script>
