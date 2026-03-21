   
<?php
$canEdit = $this->Company->checkPermission3("Hr/show_all_unit");
$defaultUnit = '';

if(!$canEdit){
    $login_emp_code = $this->session->userdata('login_emp_code');
    $basicDetails   = $this->Hrmodel->get_emp_details_with_emp_code($login_emp_code);
    $defaultUnit    = $basicDetails[0]['company_role'] ?? '';
}

 $menuaccess = $this->Base->get_menu_access_of_role() ?? [];
$visibleCompanies = [];

if ($canEdit) {
    // edit mode → sab companies
    $visibleCompanies = $con;
} elseif (!empty($menuaccess)) {
    // view mode → sirf allowed companies
    foreach ($con as $c) {
        if (in_array($c['name'], $menuaccess, true)) {
            $visibleCompanies[] = $c;
        }
    }
} elseif ($defaultUnit) {
    // fallback → default unit
    $visibleCompanies[] = ['name' => $defaultUnit];
}
?>

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">

                                        <div class="col-md-1">
                                        <label>Payroll Unit</label>
                                        <select class="form-control" name="company_role1" id="company_role1">

                                            <?php if ($canEdit): ?>
                                                <option value="">All Payroll Units</option>

                                                <?php foreach ($visibleCompanies as $d): ?>
                                                    <option value="<?= htmlspecialchars($d['name']) ?>">
                                                        <?= htmlspecialchars($d['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            <?php else: ?>

                                                <?php if (!empty($visibleCompanies)): ?>
                                                    <?php foreach ($visibleCompanies as $d): ?>
                                                        <option value="<?= htmlspecialchars($d['name']) ?>" selected>
                                                            <?= htmlspecialchars($d['name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <option value="<?= htmlspecialchars($defaultUnit) ?>" selected>
                                                        <?= htmlspecialchars($defaultUnit) ?>
                                                    </option>
                                                <?php endif; ?>

                                            <?php endif; ?>

                                        </select>
                                    </div>



                                        <div class="col-md-1" >
                                            <label >Working Unit</label>
                                            <select class="form-control" id="search_plant" >
                                            	<option value="">All</option>
                                               <?php 
                                               	foreach($con as $d)
												{
											   		?>
                                               			<option   value="<?php echo $d['name'];?>"><?php echo $d['name'];?></option>
                                               		<?php 
											   	}
											   ?>
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <label>Form Date</label>
                                            <input type="text" class="form-control" id="search_date1" name="search_date1" value="<?php if(isset($search_date1)){echo $search_date1;}else{echo date('d-m-Y');}?>" required  >
                                        </div>
                                        
                                        <div class="col-md-1">
                                            <label>To Date</label>
                                            <input type="text" class="form-control" id="search_date2" name="search_date2" value="<?php if(isset($search_date2)){echo $search_date2;}else{echo date('d-m-Y');}?>" required>
                                        </div>
                                        
                                        
                                        <div class="col-md-1">
                                         <label >Shift</label>
                                              <select class="form-control"   id="shift">
                                                  <option  value="">All</option>
                                                  <?Php 
                                                      foreach($shifts as $s)
                                                      {
                                                        ?>
                                                          <option <?php if(isset($res2[0]['current_shift'])){if($res2[0]['current_shift']==$s['shift_code']){echo "selected";}}?> value="<?php echo $s['shift_code'];?>" >
                                                              <?php echo $s['shift_code'].', '.$s['in_time'].'-'.$s['out_time_ot'];?>
                                                          </option>
                                                        <?php
                                                      }
                                                    ?>	
                                              </select>
                                        </div>


                                        <div class="col-md-1">
                                            <label>Emp Code</label>
                                            <input type="text" class="form-control" id="emp_code" name="emp_code" >
                                        </div>

                                        <div class="col-md-1">
                                            <label >Bio code</label>
                                            <input type="text" class="form-control"  id="bio_id1"  >
                                        </div>

                                        <div class="col-md-1">
                                            <label >Name</label>
                                            <input type="text" class="form-control"  id="name1"  >
                                        </div> 

                                        
                                        <div class="col-md-1" >
                                            <label >Dept.</label>
                                            <select class="form-control" id="dept" >
                                            	<option value="">All</option>
                                               <?php 
											   	foreach($dept as $d)
												{
											   		?>
                                               			<option <?php if(!empty($def_dept)){if($d['department_id']==$def_dept){ echo "selected";}}?>  value="<?php echo $d['department_id'];?>"><?php echo $d['name'];?></option>
                                               		<?php 
											   	}
											   ?>
                                            </select>
                                        </div>
                                        
                                     
                    
                    
                     <div class="col-md-1">
                        <input type="button" id="att_punch_search2" class="btn" style=" margin-top:25px; background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;"  name="search" value="Search" >
                    </div>

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Attendance Punching details List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                    <?php $this->load->view('hr/punch/show_table',$res2);?>
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   







<?php $this->load->view('js/hr_js');?>

                
