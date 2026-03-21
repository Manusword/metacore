<!-- ========= MENU MANAGEMENT PAGE ========= -->
<div class="main-content">
    <div class="breadcrumb">
        <h1>Menu Management</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- ACTION BAR -->
    <div class="mb-3 text-right">
        <button class="btn btn-success" onclick="openMenuModal()">+ New Menu</button>
        <button class="btn btn-primary" onclick="openSubMenuModal()">+ New Sub Menu</button>
    </div>

    <!-- MENU LIST -->
    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                <tr>
                    <th width="40">#</th>
                    <th>Menu</th>
                    <th>ID Name</th>
                    <th>Link</th>
                    <th>Url</th>
                    <th>Order</th>
                    <th>Show in List</th>
                    <th>Status</th>
                    <th width="120">Action</th>
                </tr>
                </thead>

                <tbody>
                <?php $i=1; foreach($menu as $m): ?>
                    <tr class="table-info">
                        <td><?= $i++ ?></td>
                        <td><strong><?= $m['name'] ?></strong></td>
                        <td><?= $m['id_name'] ?></td>
                        <td><?= $m['is_direct_link'] ?></td>
                        <td><?= $m['link'] ?></td>
                        <td><?= $m['menu_order'] ?></td>
                        <td><?= $m['show_in_list'] ?></td>
                        <td>
                            <span class="badge <?= $m['status']=='Active'?'badge-success':'badge-danger' ?>">
                                <?= $m['status'] ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick='editMenu(<?= json_encode($m) ?>)'>
                                Edit
                            </button>
                        </td>
                    </tr>

                    <!-- SUB MENUS -->
                    <?php
                    $subs = $this->Base->get_all_sub_menu_from_main_id2($m['id']);
                    foreach($subs as $s):
                    ?>
                        <tr>
                            <td></td>
                            <td class="pl-4">↳ <?= $s['name'] ?></td>
                            <td><?= $s['id_name'] ?></td>
                            <td><?= $s['is_direct_link'] ?></td>
                            <td><?= $s['link'] ?></td>
                            <td><?= $s['menu_order'] ?></td>
                            <td><?= $s['show_in_list'] ?></td>
                            <td>
                                <span class="badge <?= $s['status']=='Active'?'badge-success':'badge-danger' ?>">
                                    <?= $s['status'] ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick='editSubMenu(<?= json_encode($s) ?>)'>
                                    Edit
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>



<div class="modal fade" id="menuModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="menuTitle">Menu</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="menu_id">

        <div class="form-group">
          <label>Menu Name</label>
          <input type="text" id="menu_name" class="form-control">
        </div>

        <div class="form-group">
          <label>ID Name</label>
          <input type="text" id="menu_id_name" class="form-control">
        </div>

        <div class="form-group">
          <label>Direct Link</label>
          <select id="menu_is_direct" class="form-control">
             <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </div>

        <div class="form-group">
          <label>URL</label>
          <input type="text" id="menu_link_url" class="form-control">
        </div>

        <div class="form-group">
          <label>Order Number</label>
          <input type="number" id="menu_order_no" class="form-control">
        </div>

        <div class="form-group">
          <label>Status</label>
          <select id="menu_status" class="form-control">
            <option value="Active">Active</option>
            <option value="Deactive">Deactive</option>
          </select>
        </div>

        <div class="form-group">
          <label>Show In Navbar</label>
          <select id="menu_show_nav" class="form-control">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </div>


      </div>

      <div class="modal-footer">
        <button class="btn btn-success" onclick="saveMenu()">Save</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="subMenuModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="subMenuTitle">Sub Menu</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">

        <input type="hidden" id="sub_id">

        <div class="form-group">
          <label>Main Menu</label>
          <select id="sub_main_menu_id" class="form-control">
            <?php foreach($menu as $m): ?>
              <option value="<?= $m['id'] ?>"><?= $m['name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

          <div class="form-group">
            <label>Name</label>
            <input type="text" id="sub_name" class="form-control">
          </div>

          <div class="form-group">
            <label>ID Name</label>
            <input type="text" id="sub_id_name" class="form-control">
          </div>

          <div class="form-group">
            <label>Direct Link</label>
            <select id="sub_is_direct" class="form-control">
              <option value="No">No</option>
              <option value="Yes">Yes</option>
            </select>
          </div>

          <div class="form-group">
            <label>URL</label>
            <input type="text" id="sub_link_url" class="form-control">
          </div>

          <div class="form-group">
            <label>Order Number</label>
            <input type="number" id="sub_menu_order" class="form-control">
          </div>

          <div class="form-group">
            <label>Status</label>
            <select id="sub_status" class="form-control">
              <option value="Active">Active</option>
              <option value="Deactive">Deactive</option>
            </select>
          </div>

          <div class="form-group">
            <label>Show In Navbar</label>
            <select id="sub_show_nav" class="form-control">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>

      <div class="modal-footer">
        <button class="btn btn-primary" onclick="saveSubMenu()">Save</button>
      </div>

    </div>
  </div>
</div>

<script>

function resetForm(modal) {
    $(modal).find('input[type=text],input[type=number],input[type=hidden]').val('');
    $(modal).find('select').each(function () {
        this.selectedIndex = 0;
    });
}

function openMenuModal() {
    resetForm('#menuModal');
    $('#menuTitle').text('Add Menu');
    $('#menu_status').val('Active');
    $('#menuModal').modal('show');
}

function openSubMenuModal() {
    resetForm('#subMenuModal');
    $('#sub_status').val('Active');
    $('#subMenuModal').modal('show');
}

function editMenu(m){
    $('#menuTitle').text('Edit Menu');

    $('#menu_id').val(m.id);
    $('#menu_name').val(m.name);
    $('#menu_id_name').val(m.id_name);
    $('#menu_is_direct').val(m.is_direct_link);

    // 🔥 IMPORTANT FIX
    $('#menu_link_url').val(m.link);
    $('#menu_order_no').val(m.menu_order);

    $('#menu_status').val(m.status);
    $('#menu_show_nav').val(m.show_in_list);

    $('#menuModal').modal('show');
}

function editSubMenu(s){
    $('#sub_id').val(s.id);
    $('#sub_main_menu_id').val(s.main_menu_id);
    $('#sub_name').val(s.name);
    $('#sub_id_name').val(s.id_name);
    $('#sub_is_direct').val(s.is_direct_link);

    // 🔥 IMPORTANT FIX
    $('#sub_link_url').val(s.link);
    $('#sub_menu_order').val(s.menu_order);

    $('#sub_status').val(s.status);
    $('#sub_show_nav').val(s.show_in_list);

    $('#subMenuModal').modal('show');
}

function saveMenu() {
    let payload = {
        id: $('#menu_id').val(),
        name: $('#menu_name').val().trim(),
        id_name: $('#menu_id_name').val().trim(),
        is_direct_link: $('#menu_is_direct').val(),
        link: $('#menu_link_url').val().trim(),
        menu_order: $('#menu_order_no').val(),
        status: $('#menu_status').val(),
        show_in_list: $('#menu_show_nav').val()
    };

    if (!payload.name || !payload.id_name) {
        alert('Menu Name and ID Name are required');
        return;
    }

    $.post("<?= base_url('index.php/Page/add_menu_save') ?>", payload, res => handleResponse(res));
}

function saveSubMenu() {
    let payload = {
        id: $('#sub_id').val(),
        main_menu_id: $('#sub_main_menu_id').val(),
        name: $('#sub_name').val().trim(),
        id_name: $('#sub_id_name').val().trim(),
        is_direct_link: $('#sub_is_direct').val(),
        link: $('#sub_link_url').val().trim(),
        menu_order: $('#sub_menu_order').val(),
        status: $('#sub_status').val(),
        show_in_list: $('#sub_show_nav').val()
    };

    if (!payload.name || !payload.id_name) {
        alert('Sub Menu Name and ID Name are required');
        return;
    }

    $.post("<?= base_url('index.php/Page/add_sub_menu_save') ?>", payload, res => handleResponse(res));
}

function handleResponse(res) {
    if (res === 'OK') {
        location.reload();
    } else {
        alert(res);
    }
}
</script>
