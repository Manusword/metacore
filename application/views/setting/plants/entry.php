<!-- ========= MENU MANAGEMENT PAGE ========= -->
<div class="main-content">
    <div class="breadcrumb">
        <h1>Plant Management</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- ACTION BAR -->
    <div class="mb-3 text-right">
        <button class="btn btn-success" onclick="openPlantModal()">+ New Plant</button>
    </div>

    <!-- MENU LIST -->
    <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm" style="font-size:10px">
                <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Name</th>
                    <th>Full Name</th>
                    <th>Display Name</th>
                    <th>Address</th>
                    <th>GST no</th>
                    <th>EPF Code no</th>
                    <th>ESIC no</th>
                    <th>Manpower Limit</th>
                    <th>Empcode Start From</th>
                    <th>Empcode End To</th>
                    <th>Count Auto Empcode</th>
                    <th>Emp Start with</th>
                    <th>Slary Devide by</th>
                    <th>Bank Details</th>
                    <th>Only Working Unit</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th width="120">Action</th>
                </tr>
                </thead>

                <tbody>
                <?php $i=1; foreach($plant as $m): ?>
                    <tr >
                        <td><?= $i++ ?></td>
                        <td><?= $m['name'] ?></td>
                        <td><?= $m['full_name'] ?></td>
                        <td><?= $m['display_name'] ?></td>
                        <td><?= $m['address'] ?></td>
                        <td><?= $m['gst'] ?></td>
                        <td><?= $m['pf_code'] ?></td>
                        <td><?= $m['esi_no'] ?></td>
                        <td><?= $m['manpower_limit'] ?></td>
                        <td><?= $m['pay_code_start'] ?></td>
                        <td><?= $m['pay_code_end'] ?></td>
                        <td><?= $m['autoEmpcode_status'] ?></td>
                        <td><?= $m['empcode_start'] ?></td>
                        <td>
                            
                                <?php
                                if ($m['salaryDivide_days'] === '30') {
                                    echo 'Always 30';
                                } elseif ($m['salaryDivide_days'] === '26') {
                                    echo 'Always 26';
                                } else {
                                    echo 'Full Month Days';
                                }
                                ?>
                            
                        </td>

                        <td>
                                <?php
                                  echo $m['bank_name'];
                                  echo "<br>";
                                  echo $m['bank_account'];
                                  echo "<br>";
                                  echo $m['bank_ifsc'];
                                  echo "<br>";
                                ?>
                        </td>
                        <td>
                            
                                <?php
                                if ((int)$m['working_unit'] === 1) {
                                    echo 'Yes';
                                } else {
                                    echo 'No';
                                }
                                ?>
                            
                        </td>
                        <td><?= $m['order_no'] ?></td>

                        <td>
                            <span class="badge <?= $m['status']=='Active'?'badge-success':'badge-danger' ?>">
                                <?= $m['status'] ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info"
                                onclick='editPlant(<?= json_encode($m) ?>)'>
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
</div>


<div class="modal fade" id="plantModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 id="plantTitle">Plant</h5>
        <button class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="plant_id">

        <div class="row">
          <div class="col-md-2">
            <label>Plant Code</label>
            <input type="text" id="plant_name" class="form-control">
          </div>

          <div class="col-md-6">
            <label>Full Name</label>
            <input type="text" id="plant_full_name" class="form-control">
          </div>

          <div class="col-md-4">
            <label>Display Name</label>
            <input type="text" id="display_name" class="form-control">
          </div>

          <div class="col-md-12">
            <label>Address</label>
            <input type="text" id="plant_address" class="form-control">
          </div>

          <div class="col-md-4">
            <label>GST</label>
            <input type="text" id="plant_gst" class="form-control">
          </div>

           <div class="col-md-4">
            <label>EPF Code no</label>
            <input type="text" id="plant_pf" class="form-control">
          </div>

           <div class="col-md-4">
            <label>ESIC No.</label>
            <input type="text" id="plant_esi" class="form-control">
          </div>

          <div class="col-md-4">
            <label>Manpower Limit</label>
            <input type="number" id="plant_manpower" class="form-control">
          </div>

          <div class="col-md-4">
            <label>Salary & OT Divide by</label>
            <select id="salaryDivide_days" class="form-control">
              <option value="Full">Full Month Day's</option>
              <option value="30">Always 30</option>
              <option value="26">Always 26</option>
            </select>
          </div>

            <div class="col-md-4">
            <label>Count Auto EmpCode</label>
            <select id="autoEmpcode_status" class="form-control">
              <option value="Yes">Yes</option>
              <option value="No">No</option>
            </select>
          </div>

          <div class="col-md-4">
            <label>Emp Code Start</label>
            <input type="text" id="pay_code_start" class="form-control">
          </div>

          <div class="col-md-4">
            <label>Emp Code End</label>
            <input type="text" id="pay_code_end" class="form-control">
          </div>
        

        

           <div class="col-md-4">
            <label>EmpCode Start with (KC)</label>
            <input type="text" id="empcode_start" class="form-control" placeholder="KC0001">
          </div>

           <div class="col-md-4">
            <label>Bank Name</label>
            <input type="text" id="bank_name" class="form-control" >
          </div>

           <div class="col-md-4">
            <label>Bank Account</label>
            <input type="text" id="bank_account" class="form-control" >
          </div>

           <div class="col-md-4">
            <label>Bank IFSC</label>
            <input type="text" id="bank_ifsc" class="form-control" >
          </div>

           <div class="col-md-4">
            <label>Only Working unit ?</label>
            <select id="working_unit" class="form-control">
               <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>

           <div class="col-md-4">
            <label>Order No</label>
            <input type="number" id="order_no" class="form-control">
          </div>

        

           
          <div class="col-md-4">
            <label>Status</label>
            <select id="plant_status" class="form-control">
              <option value="Active">Active</option>
              <option value="Deactive">Deactive</option>
            </select>
          </div>

          </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-success" onclick="savePlant()">Save</button>
      </div>

    </div>
  </div>
</div>

<script>

 
function openPlantModal() {
    $('#plantModal input').val('');
    $('#plant_name').val('').prop('readonly', false);
    $('#plant_status').val('Active');
    $('#plantTitle').text('Add Plant');
    $('#plantModal').modal('show');
}

function editPlant(p) {
    $('#plant_id').val(p.id);
    $('#plant_name').val(p.name).prop('readonly', true);
    $('#display_name').val(p.display_name);
    $('#plant_full_name').val(p.full_name);
    $('#plant_address').val(p.address);
    $('#plant_gst').val(p.gst);
    $('#plant_pf').val(p.pf_code);
    $('#plant_esi').val(p.esi_no);
    $('#plant_manpower').val(p.manpower_limit);
    $('#salaryDivide_days').val(p.salaryDivide_days);
    $('#pay_code_start').val(p.pay_code_start);
    $('#pay_code_end').val(p.pay_code_end);
    $('#autoEmpcode_status').val(p.autoEmpcode_status);
    $('#empcode_start').val(p.empcode_start);
    $('#plant_status').val(p.status);

    $('#bank_name').val(p.bank_name);
    $('#bank_account').val(p.bank_account);
    $('#bank_ifsc').val(p.bank_ifsc);
    $('#working_unit').val(p.working_unit);
    $('#order_no').val(p.order_no);

    $('#plantTitle').text('Edit Plant');
    $('#plantModal').modal('show');
}

function savePlant() {
    let payload = {
        id: $('#plant_id').val(),
        name: $('#plant_name').val().trim(),
        display_name: $('#display_name').val().trim(),
        full_name: $('#plant_full_name').val().trim(),
        address: $('#plant_address').val().trim(),
        gst: $('#plant_gst').val().trim(),
        pf_code: $('#plant_pf').val().trim(),
        esi_no: $('#plant_esi').val().trim(),
        manpower_limit: parseInt($('#plant_manpower').val(), 10),
        salaryDivide_days: $('#salaryDivide_days').val(),
        pay_code_start: $('#pay_code_start').val().trim(),
        pay_code_end: $('#pay_code_end').val().trim(),
        autoEmpcode_status: $('#autoEmpcode_status').val(),
        empcode_start: $('#empcode_start').val().trim(),
        status: $('#plant_status').val(),

        bank_name: $('#bank_name').val(),
        bank_account: $('#bank_account').val(),
        bank_ifsc: $('#bank_ifsc').val(),
        working_unit: $('#working_unit').val(),
        order_no: $('#order_no').val()
    };

    /* HARD VALIDATION */
    if (!payload.name) return alert('Plant name required');
    if (!payload.full_name) return alert('Full name required');
    if (!payload.address) return alert('Address required');

    if (payload.manpower_limit <= 0)
        return alert('Manpower must be greater than 0');

    if (payload.pay_code_start && payload.pay_code_end &&
        payload.pay_code_start > payload.pay_code_end)
        return alert('Emp Code Start cannot be greater than End');

    if (payload.gst && !/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/.test(payload.gst))
        return alert('Invalid GST format');

    // if (payload.empcode_start && !/^[A-Z]{2}[0-9]+$/.test(payload.empcode_start))
    //     return alert('EmpCode must be like KC0001');

    $.post("<?= base_url('index.php/Page/add_plants_save') ?>", payload, function (res) {
        if (res === 'OK') location.reload();
        else alert(res);
    });
}

</script>
