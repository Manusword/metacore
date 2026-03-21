   
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Access</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Select Access</div>
                                    <div class="form-row">

                                    <div class="col-md-12">
                                      <div class="form-group">
                                          <label >Joining Desigantion</label>
                                              <select class="form-control"   id="join_desig" onchange="getPer(this.value)">
                                                    <option value="">Select</option>
                                                      <?Php 
                                                        foreach($role as $c)
                                                        {
                                                            if ($c['role_id'] == 35) continue;
                                                        ?>
                                                            <option  value="<?php echo $c['role_id'];?>" >
                                                                <?php echo $c['name'];?>
                                                            </option>
                                                        <?php
                                                        }
                                                      ?>		
                                              </select>
                                        </div>
                                      </div> 


                                    <div class="col-md-12">
                                        <div class="border-top p-2 d-flex flex-wrap align-items-center" style="gap:10px; max-height:80px; overflow:auto;">
                                                
                                                <label class="m-0">
                                                    <input type="checkbox" id="all_units" onclick="toggleAll(this)"> All Payroll Unit
                                                </label>

                                                <?php foreach($con as $i => $d): ?>
                                                    <label class="m-0">
                                                        <input type="checkbox"
                                                            name="company_role1[]"
                                                            value="<?= $d['name']; ?>"
                                                            id="unit<?= $i ?>">
                                                        <?= $d['name']; ?>
                                                    </label>
                                                <?php endforeach; ?>
                                        </div>
                                    </div>
                                      
                                     
                                            <div class="col-md-12" style="margin-top:50px;"> 
                                                <?php 
                                                $ms2[]= $menu;
                                                $sm2[]= $sab_menu_list;


                                                $i=1;
                                                foreach($menu as $m)
                                                {
                                                    $menu_id=$m['id'];
                                                    $where=" main_menu_id='$menu_id' and status='Active' ORDER BY menu_order ";
                                                    $sub=$this->Mymodel->select_where('erp_sub_menu',$where);
                                                    if(isset($sub) and count($sub)>0)
                                                    {
                                                        ?><div class="col-md-12">
                                                                <div class="panel panel-white">
                                                                    <div class="panel-heading clearfix">
                                                                        <h4 class="panel-title">
                                                                            <?php echo  $m['name'];?> 
                                                                            <input type="checkbox" name="menu_access[]"  <?php if(in_array($menu_id,$ms2)){echo "checked";}?> value="<?php echo $menu_id;?>" id="menulist_<?php echo $i;?>" class="menu_access" onClick="fun_show_sub_menu(this.id)">
                                                                            
                                                                            
                                                                        </h4>
                                                                    </div>
                                                                    <div class="panel-body" id="submenulist_<?php echo $i;?>">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>#</th>
                                                                                        
                                                                                        <th>Sub Menu</th>
                                                                                        <th>Access</th>
                                                                                        
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>

                                                                                <?php 
                                                                                    $j=1;
                                                                                    foreach($sub as $s)
                                                                                    {
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td width="5%"><?php echo $j;?></td>
                                                                                        <td width="50%"><?php echo $s['name'];?></td>
                                                                                        <td width="45%">                                                
                                                                                        <input type="checkbox" class="sub_menu_access" name="sub_menu_access[]" <?php if(in_array($s['id'],$sm2)){echo "checked";}?> value="<?php echo $s['id'];?>">
                                                                                        
                                                                                
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php 
                                                                                    $j++;
                                                                                }
                                                                                ?>
                                                                                
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                         
                                                    <?php 
                                                    }
                                                $i++;
                                                }
                                                
                                                ?>
                                                                
                                            </div>          
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" onclick="save_access()" >Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   

<script>
function toggleAll(source) {
    document.querySelectorAll('input[name="company_role1[]"]').forEach(cb => {
        cb.checked = source.checked;
    });
}

function save_access()
{
    let role_id = $('#join_desig').val();

    if (!role_id) {
        alert('please select role');
        return;
    }

    // collect checked payroll units
    let company_role = [];
    $('input[name="company_role1[]"]:checked').each(function () {
        company_role.push($(this).val());
    });

    // at least one unit
    if (company_role.length === 0) {
        fun_message('warning','Warning','Please select at least one Payroll Unit','toast-bottom-right');return false;
    }

    let menus = [];
    let sub_menus = [];

    $('.menu_access:checked').each(function () {
        let menu_id = $(this).val();

        let subChecks = $(this)
            .closest('.panel')
            .find('.sub_menu_access:checked');

        if (subChecks.length === 0) {
            // 🔥 FULL ACCESS
            menus.push({
                menu_id: menu_id,
                full_access: 1
            });
        } else {
            // PARTIAL ACCESS
            menus.push({
                menu_id: menu_id,
                full_access: 0
            });

            subChecks.each(function () {
                sub_menus.push({
                    menu_id: menu_id,
                    sub_menu_id: $(this).val()
                });
            });
        }
    });

    $('#wait').show();
    $.post(
        "<?php echo base_url().'index.php/Hr/get_access_save'; ?>",
        {
            role_id: role_id,
            company_role:company_role,
            menus: menus,
            sub_menus: sub_menus
        },
        function (data) {
           if (data === 'Save') {

                fun_message('success', data, 'Save Successfully', 'toast-bottom-right');

                // 🔥 CLEAR ALL CHECKBOXES
                $('.menu_access').prop('checked', false);
                $('.sub_menu_access').prop('checked', false);

                // 🔥 RESET ROLE DROPDOWN
                $('#join_desig').val('');

            } 
            else{
                fun_message('error','Error',data,'toast-bottom-right');
            }
            $('#wait').hide();
        }
    );
}

function getPer(role_id)
{
    $('.menu_access').prop('checked', false);
    $('.sub_menu_access').prop('checked', false);
    $('input[name="company_role1[]"]').prop('checked', false);
    
    if (!role_id) return;

    $.post(
        "<?php echo base_url().'index.php/Hr/get_access_of_role_id';?>",
        { rol_id: role_id },
        function(res)
        {
            let data = JSON.parse(res);

            // MAIN MENUS
            data.menus.forEach(function(menu_id){

                // check main menu
                let menuCheckbox = $('.menu_access[value="'+menu_id+'"]');
                menuCheckbox.prop('checked', true);

                // 🔥 IMPORTANT PART
                if (data.sub_menus.length === 0) {
                    // FULL ACCESS → check all submenus of this menu
                    menuCheckbox
                        .closest('.panel')
                        .find('.sub_menu_access')
                        .prop('checked', true);
                }
            });

            // PARTIAL SUBMENU ACCESS
            data.sub_menus.forEach(function(sub_id){
                $('.sub_menu_access[value="'+sub_id+'"]').prop('checked', true);
            });
        }
    );
     getdeptmanuaccess(role_id);
}

function getdeptmanuaccess(role_id)
{
    if (!role_id) return;

    $.post(
        "<?php echo base_url().'index.php/Hr/get_menu_access_from_role_id';?>",
        { rol_id: role_id },
        function(res)
        {
            let data = JSON.parse(res);
            console.log(data);

            // pehle sab unchecked
            $('input[name="company_role1[]"]').prop('checked', false);

            // agar simple array hai ["Fortune","Tata"]
            if (Array.isArray(data)) {
                data.forEach(function(company){
                    $('input[name="company_role1[]"][value="'+company+'"]')
                        .prop('checked', true);
                });
            }
        }
    );
}

</script>

