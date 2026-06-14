<?php
class Hrmodel extends CI_Model
{
    //check email
    public function fun_check_email($email)
	{
		$sql = "SELECT email FROM employee WHERE email='$email'   ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res)){ return "TRUE";}else{ return "FALSE";}
    }//function close


	public function all_unit_filter()
	{
		//$result['dept']=$this->Base->get_hr_dept();
		$conMaster=$this->Base->get_payroll_master();
		$con=$this->Base->get_payroll_contractor();
		$con2=$this->Base->get_all_contractor_code();

		$canEdit = $this->Company->checkPermission3("Hr/show_all_unit");
		$defaultUnit = '';

		if(!$canEdit){
			$login_emp_code = $this->session->userdata('login_emp_code');
			$basicDetails   = $this->Hrmodel->get_emp_details_with_emp_code($login_emp_code);
			$defaultUnit    = $basicDetails[0]['company_role'] ?? '';
		}
		?>

		<div class="breadcrumb" style=" margin-top:-30px">
			<div class="row w-100">



			
		<?php
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

		




		<!-- COMPANY (checkbox like payroll) -->
		<div class="col-md-12">
			<div class="border-top p-2 d-flex flex-wrap align-items-center"
				style="gap:10px; max-height:80px; overflow:auto;">

				<strong class="mr-2">Company:</strong>

				<label class="m-0">
					<input type="checkbox" name="company_master[]" value="">
					All
				</label>

				<?php foreach($conMaster as $i => $d): ?>
					<label class="m-0">
						<input type="checkbox"
							name="company_master[]"
							value="<?= htmlspecialchars($d['master_unit_id']) ?>"
							id="company<?= $i ?>">
						<?= htmlspecialchars($d['master_unit_id']) ?>
					</label>
				<?php endforeach; ?>

			</div>
		</div>

		<div class="col-md-12">
			<div class="border-top p-2 d-flex flex-wrap align-items-center"
				style="gap:10px; max-height:80px; overflow:auto;">

				<strong class="mr-2">Payroll Unit:</strong>

				<?php if ($canEdit): ?>
					<label class="m-0">
						<input type="checkbox" id="all_units" onclick="toggleAll(this)">
						All
					</label>
				<?php endif; ?>

				<?php foreach ($visibleCompanies as $i => $d): ?>
					<label class="m-0">
						<input type="checkbox"
							name="company_role1[]"
							value="<?= htmlspecialchars($d['name']) ?>"
							id="unit<?= $i ?>"
							data-master="<?= $d['master_unit_id'] ?>"
							>
						<?= htmlspecialchars($d['display_name']) ?>
					</label>
				<?php endforeach; ?>

				<?php if (empty($visibleCompanies)): ?>
					<span class="text-muted">No Payroll Unit Access</span>
				<?php endif; ?>

			</div>
		</div>

		<!-- WORKING UNIT (checkbox like payroll) -->
		<div class="col-md-12">
			<div class="border-top p-2 d-flex flex-wrap align-items-center"
				style="gap:10px; max-height:80px; overflow:auto;">

				<strong class="mr-2">Working Unit:</strong>

				<label class="m-0">
					<input type="checkbox" checked name="working_unit[]" value="">
					All
				</label>

				<?php foreach($con2 as $i => $d): ?>
					<label class="m-0">
						<input type="checkbox" checked
							name="working_unit[]"
							value="<?= htmlspecialchars($d['name']) ?>"
							id="working<?= $i ?>">
						<?= htmlspecialchars($d['display_name']) ?>
					</label>
				<?php endforeach; ?>

			</div>
		</div>
		</div>
		</div>



		<script>
			// ✅ WORKING UNIT ALL toggle
		document.querySelector('input[name="working_unit[]"][value=""]').addEventListener('change', function () {
			let checked = this.checked;

			let workingCheckboxes = document.querySelectorAll('input[name="working_unit[]"]');

			workingCheckboxes.forEach(cb => {
				cb.checked = checked;
			});
		});

		// ✅ COMPANY ALL (top wala)
		document.querySelector('input[name="company_master[]"][value=""]').addEventListener('change', function () {
			let checked = this.checked;

			let companyCheckboxes = document.querySelectorAll('input[name="company_master[]"]');
			let payrollCheckboxes = document.querySelectorAll('input[name="company_role1[]"]');

			// company sab check/uncheck
			companyCheckboxes.forEach(cb => cb.checked = checked);

			// payroll bhi sab check/uncheck
			payrollCheckboxes.forEach(p => p.checked = checked);

			// payroll ALL checkbox sync
			let allUnits = document.getElementById('all_units');
			if (allUnits) allUnits.checked = checked;
		});

		// ✅ COMPANY individual → payroll control
		document.querySelectorAll('input[name="company_master[]"]:not([value=""])').forEach(function (cb) {
			cb.addEventListener('change', function () {

				let selectedCompanies = Array.from(document.querySelectorAll('input[name="company_master[]"]:checked'))
					.map(el => el.value)
					.filter(v => v !== "");

				let payrollCheckboxes = document.querySelectorAll('input[name="company_role1[]"]');

				// reset payroll
				payrollCheckboxes.forEach(p => p.checked = false);

				if (selectedCompanies.length === 0) {
					let allUnits = document.getElementById('all_units');
					if (allUnits) allUnits.checked = false;
					return;
				}

				// match
				payrollCheckboxes.forEach(function (p) {
					if (selectedCompanies.includes(p.getAttribute('data-master'))) {
						p.checked = true;
					}
				});

				// ALL off
				let allUnits = document.getElementById('all_units');
				if (allUnits) allUnits.checked = false;
			});
		});
		</script>
		<?php
    
 
    }//function close





	//product_autocomplate_search
    public function op_autocomplate_search_via_name($name)
	{
        $company_id = $this->session->userdata('company_id');  
		$sql = " SELECT E.emp_code,E.first_name,E.last_name,D.name as dname 
				FROM employee as E
				LEFT join department as D on D.department_id = E.department_id
				WHERE E.first_name like '%$name%' and E.status='Active' and E.owner<1 and E.company_id='$company_id'  ORDER by E.first_name,E.last_name ASC LIMIT 10  ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $output=array();
		foreach($result as $row)
		{
			$output[] = array("value" =>$row['emp_code'], "label" =>$row['first_name'].' '.$row['last_name'].', '.$row['emp_code'].', '.$row['dname']);
		}
        return $output;
    }//function close

	public function get_emp_code($emp_code)
	{
    	$company_id = $this->session->userdata('company_id');     
		$sql = "SELECT id,emp_code,bio_code FROM employee WHERE emp_code='$emp_code' and company_id='$company_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


	//check emp code
	public function fun_check_emp_code($emp_code)
	{
		$company_id = $this->session->userdata('company_id'); 
		$sql = "SELECT emp_code FROM employee WHERE emp_code='$emp_code' and company_id='$company_id'  ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res)){ return "TRUE";}else{ return "FALSE";}
    }//function close

	//check bio code
	public function fun_check_bio_code($bio_code)
	{
		$company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT bio_code FROM employee WHERE bio_code='$bio_code' and company_id='$company_id'    ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res)){ return "TRUE";}else{ return "FALSE";}
    }//function close

    //salary generate 
    public function get_all_emp_list_for_attendane_type($type_search)
	{
		$company_id = $this->session->userdata('company_id'); 	
		$query=" SELECT id,pay_code,first_name,last_name FROM employee where company_role='$type_search' and active='Active'  and attendance_entry='0' and company_id='$company_id' ORDER by pay_code ASC   ";
		return $res=$this->Mymodel->query1($query);
	}//function close

	

	public function get_employees_without_attendance($year, $month, $company_role,$search_plantUnit, $active)
	{
		$company_id = $this->session->userdata('company_id'); 	
		// company_role
		if (!empty($company_role) && is_array($company_role)) {
			$company_role = array_map('trim', $company_role);
			$company_role = array_map(function($v){
				return "'" . addslashes($v) . "'";
			}, $company_role);
			$company_role = implode(",", $company_role);
		}

		// plant
		if (!empty($search_plantUnit) && is_array($search_plantUnit)) {
			$search_plantUnit = array_map('trim', $search_plantUnit);
			$search_plantUnit = array_map(function($v){
				return "'" . addslashes($v) . "'";
			}, $search_plantUnit);
			$search_plantUnit = implode(",", $search_plantUnit);
		}

		if(!empty($active)){
			$activeCol = " AND B.active = '$active' ";
		}else{
			$activeCol = "";
		}

		$lastDate = date('Y-m-t', strtotime("$year-$month-01"));
		$firstDate = "$year-$month-01";


	
		$sql = " SELECT
					B.company_role,
					B.emp_code,
					B.bio_code,
					B.first_name,
					B.last_name,
					B.father_name,
					B.doj,
					B.dor,
					B.department_id,
					B.role_in_department,
					B.esi_code,
					B.emp_uan,
					B.bank_name,
					B.bank_account_no,
					B.co_mob_no,
					B.plant,
					B.active,
					d.name AS department,
					r.name AS designation
				FROM employee B
				LEFT JOIN department d 
					ON d.department_id = B.department_id
				LEFT JOIN department_role r 
					ON r.role_id = B.role_in_department
				WHERE 1=1
					$activeCol
					AND B.owner < 1
					AND B.company_id='$company_id'
					AND B.doj <= '$lastDate'
					AND B.company_role IN ($company_role)
					AND B.plant IN ($search_plantUnit)
					AND (
						B.attendance_entry = '0'
						OR B.attendance_entry IS NULL
						OR B.attendance_entry = 'No'
					)
					AND NOT EXISTS (
						SELECT 1
						FROM daily_attendance_monthly a
						WHERE a.emp_code = B.id
						AND a.att_year = '$year'
						AND a.att_month = '$month'
						AND a.company_role_id IN ($company_role)
						AND a.company_id='$company_id'
					)
				ORDER BY B.pay_code ASC
				";


		return $this->db->query($sql, [$year, $month, $company_role])->result_array();
	}


	public function get_salary_report($where)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT  
						B.company_role,
							B.emp_code,
							B.bio_code,
							B.first_name,
							B.last_name,
							B.father_name,
							B.doj,
							B.dor,
							B.department_id,
							B.role_in_department,
							B.esi_code,
							B.emp_uan,
							B.epf_code,
							-- B.bank_name,
							-- B.bank_account_no,
							-- B.increment_due_month,
							-- B.co_mob_no,
							B.plant,
							B.active,
							B.pf_ded,

							d.name AS department,
							r.name AS designation,

							a.increment_amt,
							a.bank_account,
							a.bank_ifsc,
							a.increment_date,
							
							a.basic_salary,
							a.hra,
							a.conv,
							a.city_comp,
							a.other_allow,
							a.spl_pay,
							a.medi_rem,
							a.fuel_reimb,
							a.get_attendance_all,
							a.bonus,
							a.current_ctc,

							a.total_present,
							a.total_ot,
							a.total_absent,
							a.total_day_in_month,

							a.basic_salary_payable,
							a.hra_payable,
							a.conv_payable,
							a.city_comp_payable,
							a.other_allow_payable,
							a.spl_pay_payable,
							a.medi_rem_payable,
							a.fuel_reimb_payable,
							a.get_attendance_all_payable,
							a.bonus_payable,
							a.total_ot_rs,
							a.current_ctc_payable,

							a.epf_payable,
							a.esic_payable,
							a.lost_canteen_payable,
							a.lost_breakfast_payable,
							a.lost_bus_payable,
							a.advance_this_month_payable,
							a.total_deduction,
							a.current_total_ctc_payable,
							a.lost_1_payable,
							a.lost_2_payable,
							a.lost_3_payable,
							a.lost_4_payable,

							a.basic_salary_master_roll,
							a.hra_master_roll,
							a.conv_master_roll,
							a.get_basic_salary_master_roll,
							a.get_hra_master_roll,
							a.get_conv_master_roll,
							a.lost_advance_master_roll,
							a.other_advance_master_roll,
							a.epf_payable_master_roll,
							a.esic_payable_master_roll,
							a.master_roll_total_loss,
							a.master_roll_total_net_pay,

							CC.bank_account as company_bank_acc
				FROM daily_attendance_monthly  as a
				LEFT JOIN employee as B ON B.id = a.emp_code
				LEFT JOIN department as d ON d.department_id = B.department_id
				LEFT JOIN department_role as r ON r.role_id = B.role_in_department
				LEFT JOIN contractor_code as CC ON a.company_role_id = CC.name
				
				WHERE 1=1 and a.company_id='$company_id' and B.company_id='$company_id' $where
				";
		$res=$this->Mymodel->query1($query);
		if(isset($res) and !empty($res)){ return $res;}else{ return [];}
				

	}

	public function get_salary_report_dept_wise($where)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT
					d.name AS dept,
					B.company_role AS company,
					SUM(a.current_total_ctc_payable) AS amount
				FROM daily_attendance_monthly a
				INNER JOIN employee B ON B.id = a.emp_code
				INNER JOIN department d ON d.department_id = B.department_id
				WHERE 1=1 and a.company_id='$company_id' and B.company_id='$company_id'
					$where
				GROUP BY d.department_id, d.name, B.company_role
				ORDER BY d.name, B.company_role;
				";
		$res=$this->Mymodel->query1($query);
		if(isset($res) and !empty($res)){ return $res;}else{ return [];}
	}

	public function get_emp_leave_data($where)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT 
						B.company_role AS company,
						B.emp_code,
						B.bio_code,
						B.first_name,B.last_name,
						B.active,
						B.is_leave_eligible,
						B.leave_yearly,
						B.leave_cl,
						B.leave_sl,
						B.leave_el,
						B.leave_ol,
						d.name as department,

						SUM(a.total_sl) AS total_sl,
						SUM(a.total_cl) AS total_cl,
						SUM(a.total_el) AS total_el,
						SUM(a.total_ol) AS total_ol,

						(
							SUM(a.total_sl) +
							SUM(a.total_cl) +
							SUM(a.total_el)
						) AS use_leave,

						(
							B.leave_yearly -
							(
								SUM(a.total_sl) +
								SUM(a.total_cl) +
								SUM(a.total_el)
							)
						) AS rem_leave

					FROM daily_attendance_monthly a
					INNER JOIN employee B ON B.id = a.emp_code
					INNER JOIN department d ON d.department_id = B.department_id

					WHERE 1=1 and a.company_id='$company_id' and B.company_id='$company_id'
						$where

					GROUP BY 
						B.emp_code,
						d.name,
						B.company_role,
						B.is_leave_eligible,
						B.leave_yearly,
						B.leave_cl,
						B.leave_sl,
						B.leave_el,
						B.leave_ol

					ORDER BY B.first_name;
				";
		$res=$this->Mymodel->query1($query);
		if(isset($res) and !empty($res)){ return $res;}else{ return [];}
	}

	
	public function get_emp_leave_of_current_month($where)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT SUM(a.total_sl) AS total_sl,
						SUM(a.total_cl) AS total_cl,
						SUM(a.total_el) AS total_el,
						SUM(a.total_ol) AS total_ol,

						(
							SUM(a.total_sl) +
							SUM(a.total_cl) +
							SUM(a.total_el) +
							SUM(a.total_ol)
						) AS  use_leave_this_month
					FROM daily_attendance_monthly a
					INNER JOIN employee B ON B.id = a.emp_code
					WHERE 1=1 and a.company_id='$company_id' and B.company_id='$company_id' $where
			";
				$res=$this->Mymodel->query1($query);
		if(isset($res) and !empty($res)){ return $res;}else{ return [];}
	}






    //hr all reports
	public function get_all_emp_list_for_attendane_type_salary_reports($type_search,$year_search,$month_search)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT  B.id,B.pay_code,B.first_name,B.last_name  
				FROM daily_attendance_monthly  as A
				 LEFT JOIN employee as B ON B.id = A.emp_code
				 WHERE   A.company_role_id='$type_search' and  A.att_year='$year_search' and A.att_month='$month_search' and A.company_id='$company_id'  GROUP BY A.emp_code ORDER BY B.first_name,B.last_name
				";
		return $res=$this->Mymodel->query1($query);
	}//function close

	//all emp_code present in given month
	public function get_all_emp_code_from_salary_list($year_search,$month_search)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT  B.pay_code  
				FROM daily_attendance_monthly  as A
				LEFT JOIN employee as B ON B.id = A.emp_code
				WHERE    A.att_year='$year_search' and A.att_month='$month_search' and A.company_id='$company_id' GROUP BY A.emp_code ORDER BY B.pay_code
				";
		$res = $this->Mymodel->query1($query);
		return array_column($res, 'pay_code');
	}//function close

	public function get_all_emp_list_for_attendane_type_salary_reports_master_roll($type_search,$year_search,$month_search)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT  B.id,B.pay_code,B.first_name,B.last_name  FROM daily_attendance_monthly  as A
				 LEFT JOIN employee as B ON B.id = A.emp_code
				 WHERE B.mater_roll='Yes' and  A.company_role_id='$type_search' and  A.att_year='$year_search' and A.att_month='$month_search'  and A.company_id='$company_id' GROUP BY A.emp_code
				";
		return $res=$this->Mymodel->query1($query);
	}//function close


    //get emp detials from emp code
	public function get_emp_details_with_emp_code($emp_code)
	{
		$company_id = $this->session->userdata('company_id');
        $sql = "SELECT 
					id,plant,company_role,first_name,last_name,department_id,role_in_department,working_hr,
					father_name,mob,present_address,permanent_address,restday,working_hr,
					shift_status,current_shift,get_overtime,bio_code,emp_code,late_punch_add

		FROM employee WHERE emp_code='$emp_code' and company_id='$company_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	public function get_emp_details_with_bio_code($bio_code)
	{
		$company_id = $this->session->userdata('company_id');
        $sql = "SELECT 
					id,plant,company_role,first_name,last_name,department_id,role_in_department,working_hr,
					father_name,mob,present_address,permanent_address,restday,working_hr
					shift_status,current_shift,get_overtime,bio_code,emp_code,late_punch_add

		FROM employee WHERE bio_code='$bio_code' and company_id='$company_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//get active emp detials from emp code
	public function get_active_emp_details_with_emp_code($emp_code)
	{
		$company_id = $this->session->userdata('company_id');
        $sql = "SELECT 
					id,plant,company_role,first_name,last_name,department_id,role_in_department,working_hr,
					father_name,mob,present_address,permanent_address,
					shift_status,current_shift,get_overtime,late_punch_add,is_leave_eligible

		FROM employee WHERE emp_code='$emp_code'  and active='Active' and company_id='$company_id' ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

    public function get_emp_details_with_id($id)
	{
		$company_id = $this->session->userdata('company_id');
        $sql = "SELECT id,plant,company_role,first_name,last_name,department_id,role_in_department,
				emp_code,working_hr,late_punch_add,on_daily_wages,daily_wages_rs
		FROM employee WHERE id='$id'  and company_id='$company_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//get all employee details with id
    public function get_emp_deatis_with_id($id)
	{
		$company_id = $this->session->userdata('company_id');
        $sql = "SELECT 
                A.*,
                B.name as main_dept_name,
                C.name as sub_dept_name,
                D.name as role_name,
                E.name as join_role_name
                FROM employee as A
                LEFT JOIN department as B on B.department_id = A.department_id
                LEFT JOIN department as C on C.department_id = A.sub_department_id
                LEFT JOIN department_role as D on D.role_id = A.role_in_department
                LEFT JOIN department_role as E on E.role_id = A.join_desig

                WHERE A.id='$id'  and A.company_id='$company_id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//get all employee details with id
    public function get_emp_deatis_with_emp_code($emp_code)
	{
        $company_id = $this->session->userdata('company_id');
		$sql = "SELECT 
                A.*,
                B.name as main_dept_name,
                C.name as sub_dept_name,
                D.name as role_name,
                E.name as join_role_name
                FROM employee as A
                LEFT JOIN department as B on B.department_id = A.department_id
                LEFT JOIN department as C on C.department_id = A.sub_department_id
                LEFT JOIN department_role as D on D.role_id = A.role_in_department
                LEFT JOIN department_role as E on E.role_id = A.join_desig

                WHERE A.emp_code='$emp_code'  and A.company_id='$company_id'
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
	

	//get all employee dept id
    public function get_emp_deatis_with_dept_id($dept_id)
	{
		$company_id = $this->session->userdata('company_id');
        $sql = "SELECT 
                A.*,
                B.name as main_dept_name,
                C.name as sub_dept_name,
                D.name as role_name,
                E.name as join_role_name
                FROM employee as A
                LEFT JOIN department as B on B.department_id = A.department_id
                LEFT JOIN department as C on C.department_id = A.sub_department_id
                LEFT JOIN department_role as D on D.role_id = A.role_in_department
                LEFT JOIN department_role as E on E.role_id = A.join_desig

                WHERE A.sub_department_id='$dept_id'  and A.company_id='$company_id'  GROUP by A.id
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    


    //get all employee details search
    public function get_emp_deatis_search($search)
	{
		$company_id = $this->session->userdata('company_id');
        $sql = "SELECT 
                B.id,B.first_name,B.last_name,B.emp_code,B.mob,B.active,B.email,B.hod_status,B.staff_tech,B.shift_status,B.current_shift,B.get_overtime,B.bio_code,B.dor,
                B.quli,B.add_quli,B.past_exp,B.gender,B.department_id,B.profile_pic,B.total_exp,B.current_level,B.father_name,B.emp_cast_category,B.emp_team,
                B.department_id,B.doj,B.dob,B.approvel_for_mc,B.approvel_for_part,B.company_role,B.mater_roll,B.plant,
				B.basic_salary,B.hra,B.other_allow,B.conv,B.city_comp,B.current_total_ctc,B.current_ctc,B.pf_ded,B.esic_ded,
				B.working_hr,B.restday,B.late_punch_add,B.on_daily_wages,B.spl_pay,B.medi_rem,B.fuel_reimb,B.esic,B.epf,B.lost_canteen,
				B.lost_breakfast,B.lost_bus,B.bonus,B.adhar_photo,B.epf_photo,B.esi_photo,B.other_id_photo,B.bank_photo,B.resume_photo,
				B.other_docs_photo,B.other_docs2_photo,B.other_docs3_photo,B.other_docs4_photo,B.emp_uan,B.epf_code,B.esi_code,B.pan_no,
				B.aadhar_no,B.voter_id,B.bank_name,B.bank_account_no,B.co_mob_no,mother_name,B.emp_marrige_status,
				B.spouse_name,B.child_name1,B.child_name2,B.child_name3,B.child_name4,B.nominee_name,B.nominee_rel,B.present_address,
				B.permanent_address,B.home_town_no,B.pin_code_permanet,B.basic_salary_master_roll,B.hra_master_roll,B.conv_master_roll,
				B.lost_advance_master_roll,B.other_advance_master_roll,B.doj_master_roll,B.dor_master_roll,B.asset_issue,B.status,B.login_from_other_ip,B.draft_entry,
				B.is_leave_eligible,B.leave_yearly,B.leave_cl,B.leave_sl,B.leave_el,B.leave_ol,
                D.name as dname,
                R.name as rname
                
                FROM employee as B

                LEFT JOIN department as D ON D.department_id = B.department_id
                LEFT JOIN department_role as R ON R.role_id = B.role_in_department
               
                WHERE  1=1 and B.company_id='$company_id' $search 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close




	 //punch search 
	 public function get_all_att_punch_with_search($search)
	 {
		$company_id = $this->session->userdata('company_id');
		$sql="  	SELECT 
					A.*,
					B.first_name,B.last_name,B.mater_roll,B.bio_code,B.current_shift,B.working_hr,B.late_punch_add,B.company_role,B.plant,
					D.name as dname,
					S.shift_name 
					FROM `daily_attendance` as A 
					left Join employee as B ON A.emp_code=B.emp_code 
					left Join department as D ON D.department_id=B.department_id 
					left Join emp_shift_master as S ON A.shift=S.shift_code
					where 1=1 and A.company_id='$company_id' and B.company_id='$company_id' $search 
			  ";
		 $query = $this->db->query($sql);
		 return $query->result_array();
	 }//function close

	

    




























    //------------Attendance table
	//get attendance table colomn 
	public function get_atten_table_id($emp_id,$year,$month)
	{
		$company_id = $this->session->userdata('company_id');
		$sql = "SELECT att_monthly_id FROM daily_attendance_monthly where emp_code='$emp_id'  and att_year='$year' and att_month='$month'  and company_id='$company_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    public function get_atten_table_column($emp_id,$year,$month,$col_at,$col_ot)
	{
     	$company_id = $this->session->userdata('company_id');
		$sql = "SELECT $col_at as emp_at_day,$col_ot as emp_ot_day,current_total_ctc,total_ot,total_ot_rs,working_hr,total_present 
				FROM daily_attendance_monthly 
				where  emp_code = '$emp_id' and att_year='$year' and att_month='$month'  and company_id='$company_id'  ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//part 5
	public function get_emp_salary_on_a_single_date($emp_code,$attendance_date)
	{
		$year = $this->Base->change_date_into_year($attendance_date); 
		$month = $this->Base->change_date_into_month($attendance_date); 
		$day = $this->Base->change_date_into_day($attendance_date); 
		$day_name = 'd'.$day;
		$ot_name = 'o'.$day;
	
		$res = $this->Hrmodel->get_emp_details_with_emp_code($emp_code);
		if(!empty($res))
		{
			$emp_id = $res[0]['id'];
			$att_res = $this->get_atten_table_column($emp_id,$year,$month,$day_name,$ot_name);
			if(!empty($att_res[0]['emp_ot_day'])){$ot_hours = (float)$att_res[0]['emp_ot_day'];}else{$ot_hours =0;}
			if(!empty($att_res[0]['emp_ot_day'])){$working_hr = (float)$att_res[0]['working_hr'];}else{$working_hr =0;}
			//$working_hr = (float)$att_res[0]['working_hr'];
			if(!empty($att_res))
			{
				if($att_res[0]['emp_at_day'] == 'A' OR $att_res[0]['emp_at_day'] == 'L'  OR $att_res[0]['emp_at_day'] == '' or $att_res[0]['emp_at_day'] == ' ' or $att_res[0]['emp_at_day'] == NULL)
				{
					//echo $msg = "$emp_code is absent ";
				}
				else
				{
					//calculate salay of this date
					//salary per day
					$last_date = $this->Base->get_last_date_of_month($month,$year);
					if($att_res[0]['current_total_ctc'] >0)
					{
						$one_day_salary = round($att_res[0]['current_total_ctc']/$last_date,2);
						if($working_hr>0){$single_hours_ot_in_rs = round($one_day_salary/$working_hr,2);}else{$single_hours_ot_in_rs =0;}
					}
					else
					{
						$one_day_salary=0;
						$single_hours_ot_in_rs = 0;
					}
					
					
					

					//OT
					if($att_res[0]['total_ot'] >0 and $att_res[0]['total_ot_rs']>0)
					{
						$one_day_ot =  round($ot_hours*$single_hours_ot_in_rs,2);
					}
					else
					{
						$one_day_ot = 0;
					}
					
					$total_salary_on_this_day = $one_day_salary+$one_day_ot;
					return $total_salary_on_this_day;
					//echo $emp_code;
					//echo "<br>";
					//echo "$emp_code, Salary $one_day_salary, OT Hours: $ot_hours, OT Rs: $one_day_ot, Total Rs: $total_salary_on_this_day <br>";
					
				}
			}
			else
			{
				//echo $msg = "$emp_code no attendance entry on this date. ";
			}
		}
		else
		{
			//echo $msg = "$emp_code Employee not created in ERP";
		}
		
    }//function close

	//part 2
	public function get_emp_attendance_on_this_date($emp_code,$attendance_date)
	{
		$year = $this->Base->change_date_into_year($attendance_date); 
		$month = $this->Base->change_date_into_month($attendance_date); 
		$day = $this->Base->change_date_into_day($attendance_date); 
		$day_name = 'd'.$day;
		$ot_name = 'o'.$day;

		$res = $this->Hrmodel->get_emp_details_with_emp_code($emp_code);
		if(!empty($res))
		{
			$emp_id = $res[0]['id'];
			$att_res = $this->get_atten_table_column($emp_id,$year,$month,$day_name,$ot_name);
			if(!empty($att_res))
			{
				if($att_res[0]['emp_at_day'] == 'A' OR $att_res[0]['emp_at_day'] == 'L'  OR $att_res[0]['emp_at_day'] == '' or $att_res[0]['emp_at_day'] == ' ' or $att_res[0]['emp_at_day'] == NULL)
				{
					$msg = "$emp_code is absent on $attendance_date";
				}
				else
				{
					$msg = "YES";
				}
			}
			else
			{
				$msg = "$emp_code no attendance entry on $attendance_date ";
			}
		}
		else
		{
			$msg = "$emp_code Employee not created in ERP";
		}
		return $msg;
    }//function close


	





	//part 3 check list 
	public function get_op_hp_salary_on_date_wise_via_machine($same_mc_list,$other_mc_list,$date,$show_details)
	{
		//print_r($same_mc_list);
		$salary_all = array();
		foreach($same_mc_list as $e)
		{
			if(!empty($e))
			{
				$msg = $this->get_emp_attendance_on_this_date($e,$date);
				if($msg == 'YES')
				{
					//echo "get_salary";
					$salary = $this->get_emp_salary_on_a_single_date($e,$date);
					$nos = count(array_keys($other_mc_list, $e))+1;
					if($nos > 1)
					{
						if($show_details == 'Y'){echo $e . " working on $nos machine in $date";}
						$salary_per_mc = round($salary/$nos)+round(100/$nos);
					}
					else
					{
						$salary_per_mc = $salary;
					}

					$salary_all[] = $salary_per_mc;
				}
				else
				{
					if($show_details == 'Y'){echo $msg;}
					//echo "<br>";
				}
				if($show_details == 'Y'){echo "<br>";}
			}
		}
		
		//print_r($salary_all);
		if(!empty($salary_all)){ $total_salary = array_sum($salary_all);}else{$total_salary=0;}
		return  $total_salary;
	}//function close






    //get attendance all details 
	public function get_atten_details_limit($type_search,$pay_code,$year_search,$month_search,$limit)
	{
		$company_id = $this->session->userdata('company_id');    
		$sql = "SELECT * FROM daily_attendance_monthly where company_role_id='$type_search' and emp_code='$pay_code' and  att_year='$year_search' and att_month='$month_search' and company_id='$company_id' LIMIT $limit ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //get attendance all details 
	public function get_atten_details_ym($year_search,$month_search)
	{
		$company_id = $this->session->userdata('company_id'); 
        $sql = "SELECT * FROM daily_attendance_monthly where  att_year='$year_search' and att_month='$month_search' and company_id='$company_id'  LIMIT 1 ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    public function add_total_present_absent_attendance_monthly($id)
	{
		$company_id = $this->session->userdata('company_id'); 
		$query=" SELECT DISTINCT d1,d2,d3,d4,d5,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31
				 FROM daily_attendance_monthly where att_monthly_id='$id' and company_id='$company_id' ";
		$out=$this->Mymodel->query1($query);
		
		$ar = array_replace($out[0],array_fill_keys(array_keys($out[0], null),''));
		$vals = array_count_values($ar);
		//echo 'No. of NON Duplicate Items: '.count($vals).'<br><br>';
		//print_r($vals);
		if(isset($vals['P'])){$total_persent = $vals['P'];}else{$total_persent = 0;}
		if(isset($vals['A'])){$total_a = $vals['A'];}else{$total_a = 0;}
		if(isset($vals['S'])){$total_sunday = $vals['S'];}else{$total_sunday = 0;}
		if(isset($vals['H'])){$total_holiday = $vals['H'];}else{$total_holiday = 0;}
		if(isset($vals['L'])){$total_leave = $vals['L'];}else{$total_leave = 0;}
		if(isset($vals['R'])){$total_rest = $vals['R'];}else{$total_rest = 0;}
		if(isset($vals['SL'])){$total_leave_sl = $vals['SL'];}else{$total_leave_sl = 0;}
		if(isset($vals['CL'])){$total_leave_cl = $vals['CL'];}else{$total_leave_cl = 0;}
		if(isset($vals['EL'])){$total_leave_el = $vals['EL'];}else{$total_leave_el = 0;}
		if(isset($vals['OL'])){$total_leave_ol = $vals['OL'];}else{$total_leave_ol = 0;}

		//late punch calculation
		$query=" SELECT emp_code,att_year,att_month,total_day_in_month FROM daily_attendance_monthly where att_monthly_id='$id' and company_id='$company_id' ";
		$attData = $this->Mymodel->query1($query);
		$emp_id = $attData[0]['emp_code'];
		$att_year = $attData[0]['att_year'];
		$att_month = $attData[0]['att_month'];
		$total_day_in_month = (int)$attData[0]['total_day_in_month'];
		//total day in month
		if ($total_day_in_month <= 0 && $att_year > 0 && $att_month >= 1 && $att_month <= 12) {
			$total_day_in_month = cal_days_in_month(
				CAL_GREGORIAN,
				$att_month,
				$att_year
			);
		}


		//check attendance lock or not
		$rem_date = date('Y-m-d', strtotime("$att_year-$att_month-01"));
		$lock = $this->Base->atten_lock_check($rem_date,$emp_id);
		if($lock) {
			echo "Attendance for this month and year is locked and cannot be modified."; exit;
		}

		
		
		$emp = $this->get_emp_details_with_id($emp_id);
		$pay_code = $emp[0]['emp_code'];
		$working_hr = $emp[0]['working_hr'];
		if(!empty($working_hr) and $working_hr >0){
			$working_hr = $working_hr;
		}else{
			$working_hr = 8;
		}
		

		//if give present day + extra min
		$late_punch_total_days = 0;
		// if ($emp[0]['late_punch_add'] === 'Yes') {
		// 	$late_punch_total_days = (float) $this->get_days_via_late_punch($att_year,$att_month,$pay_code,$working_hr);
		// }
		
		
		//add total days
		$half_present = isset($vals['HA']) ? $vals['HA'] : 0; // Half Present only
		$half_cl      = isset($vals['HL']) ? $vals['HL'] : 0; // Half Present + Half CL
		$total_persent = $total_persent + $late_punch_total_days + (($half_present + $half_cl) * 0.5);
		$total_p = $total_persent;
		
		$total_leave_cl = $total_leave_cl + ($half_cl * 0.5);
		$total_absent = $total_a+$total_leave + (($half_present) * 0.5) ;
		$total_sl = $total_leave_sl;
		$total_cl = $total_leave_cl;
		$total_el = $total_leave_el;
		$total_ol = $total_leave_ol;
		
		$total_persent_with_all = $total_persent+$total_sunday+$total_holiday+$total_leave_sl+$total_leave_cl+$total_leave_el+$total_leave_ol+$total_rest;
		

		//---------- getting total ot in this month
		$query=" SELECT  sum(o1+o2+o3+o4+o5+o6+o7+o8+o9+o10+o11+o12+o13+o14+o15+o16+o17+o18+o19+o20+o21+o22+o23+o24+o25+o26+o27+o28+o29+o30+o31) as total_ot
				 FROM daily_attendance_monthly where att_monthly_id='$id'  and company_id='$company_id' ";
		$out=$this->Mymodel->query1($query);
		$total_ot = $out[0]['total_ot'];

		//if give present day + extra min
		if ($emp[0]['late_punch_add'] === 'Yes') {
			$total_persent = (float) $this->get_duty_hrs_form_punch($att_year,$att_month,$pay_code,$working_hr,$total_holiday);
			if($total_persent > $total_day_in_month)$total_persent=$total_day_in_month;
			$total_a = $total_day_in_month-$total_persent;
			$total_leave = 0;
			$total_absent = $total_a;
			$total_holiday = 0;
			$late_punch_total_days = 0;
			$total_rest = 0;
			$total_leave_sl = 0;
			$total_leave_cl = 0;
			$total_leave_el = 0;
			$total_leave_ol = 0;
			$total_persent_with_all = $total_persent;
			$total_ot = 0;
		}
		
		//-----------updateing table
		$data=array(
			'total_p'=>"$total_persent",
			'total_a'=>"$total_a",
			'total_l'=>"$total_leave",
			'total_absent'=>"$total_absent",
			'total_holiday'=>"$total_holiday",
			'extra_punch_days'=>"$late_punch_total_days",
			'total_rest'=>"$total_rest",
			'total_sl'=>"$total_leave_sl",
			'total_cl'=>"$total_leave_cl",
			'total_el'=>"$total_leave_el",
			'total_ol'=>"$total_leave_ol",
			
			'total_present'=>"$total_persent_with_all",
			'total_ot'=>"$total_ot",
		);
  		$where=array('att_monthly_id'=>"$id");   
 		$this->Mymodel->update('daily_attendance_monthly',$data,$where);
		//return $product_name;


		//----updating salary
		$this->get_all_employee_generating_salary($id);

	}//close funtion


    /*
	//hr    canteen and breakfast
		public function add_total_present_absent_attendance_monthly_other($id)
	{
		//---------- getting total ot in this month
		$query=" SELECT  sum(d1+d2+d3+d4+d5+d6+d7+d8+d9+d10+d11+d12+d13+d14+d15+d16+d17+d18+d19+d20+d21+d22+d23+d24+d25+d26+d27+d28+d29+d30+d31) as total_ot,company_role_id,emp_code,att_year,att_month
				 FROM daily_attendance_monthly_emp_exp where att_monthly_id='$id' ";
		$out=$this->Mymodel->query1($query);
		$total_ot = $out[0]['total_ot'];
		
		$company_role_id = $out[0]['company_role_id'];
		$emp_code = $out[0]['emp_code'];
		$att_year = $out[0]['att_year'];
		$att_month = $out[0]['att_month'];
		
		//-----------updateing table
		$data=array('total_rs'=>"$total_ot");
  		$where=array('att_monthly_id'=>"$id");   
 		$this->Mymodel->update('daily_attendance_monthly_emp_exp',$data,$where);
		//return $product_name;

		
		
		//----updating salary
		$where2=array('emp_code'=>"$emp_code",'company_role_id'=>"$company_role_id",'att_year'=>"$att_year",'att_month'=>"$att_month");   
		$res2=$this->Mymodel->select_where('daily_attendance_monthly',$where2);
	    if(!empty($res2))
	    {
		   //----updating salary
		   $this->Mymodel->get_all_employee_generating_salary($r['att_monthly_id']);
	    }//if(!empty($res2))
		

	}//close funtion
    */

	public function get_salary_devide_by_month_days($company_role_id, $att_year, $att_month, $save_days = 0)
	{
		$company_id = $this->session->userdata('company_id'); 
		/* ================== DEFAULT ================== */
		$nos = (int) $save_days;

		/* ================== FETCH SETTING ================== */
		$row = $this->db
			->select('salaryDivide_days')
			->where('name', $company_role_id)
			->where('company_id', $company_id)
			->get('contractor_code')
			->row_array();

		$divideSetting = isset($row['salaryDivide_days'])
			? trim($row['salaryDivide_days'])
			: '';

		/* ================== FIXED DAYS ================== */
		if ($divideSetting === '26' || $divideSetting === 26) {
			return 26;
		}

		if ($divideSetting === '30' || $divideSetting === 30) {
			return 30;
		}

		/* ================== FULL MONTH ================== */
		if (
			$divideSetting === '' ||
			$divideSetting === ' ' ||
			strtoupper($divideSetting) === 'FULL'
		) {
			if ($att_year > 0 && $att_month > 0) {
				return cal_days_in_month(
					CAL_GREGORIAN,
					(int)$att_month,
					(int)$att_year
				);
			}
		}

		/* ================== FALLBACK ================== */
		if ($nos > 0) {
			return $nos;
		}

		// Absolute safe fallback
		return 30;
	}


	//---------------------------------------------------Loan
	public function get_all_loan_with_search($search)
	{
		$company_id = $this->session->userdata('company_id'); 
		$sql = "
			SELECT 
				A.loan_id,
				A.emp_code,
				A.loan_amount,
				A.tenure_months,
				A.emi_amount,
				A.interest_rate,
				A.status,
				A.created_at,

				E.id AS empid,
				E.first_name,
				E.last_name,
				E.department_id,
				E.role_in_department,
				E.father_name,
				E.mob,

				D.name AS dname,

				COUNT(EMI.emi_id)                     AS total_emi_count,
				SUM(EMI.emi_amount)                   AS total_emi_amount,
				SUM(EMI.recovered_amount)             AS total_paid_amount,
				(SUM(EMI.emi_amount) - SUM(EMI.recovered_amount)) AS remaining_amount,

				SUM(CASE WHEN EMI.status IN ('PENDING','PARTIAL') THEN 1 ELSE 0 END)
													AS remaining_emi_count,

				GROUP_CONCAT(
					DATE_FORMAT(EMI.emi_month,'%Y-%m')
					ORDER BY EMI.emi_month ASC
				) AS emi_months

			FROM employee_loan A
			LEFT JOIN employee E 
				ON A.emp_code = E.emp_code
			LEFT JOIN department D 
				ON E.department_id = D.department_id
			LEFT JOIN employee_loan_emi EMI
				ON EMI.loan_id = A.loan_id

			WHERE 1=1 and A.company_id='$company_id' and E.company_id='$company_id' $search

			GROUP BY A.loan_id
			ORDER BY A.created_at ASC
		";

		return $this->db->query($sql)->result_array();
	}



	public function deductLoanEMIFromPayroll($emp_code, $pay_month, $available_salary, $payroll_run_id)
	{
		$company_id = $this->session->userdata('company_id'); 
		if ($available_salary <= 0) return 0;

		$pay_month = date('Y-m', strtotime($pay_month));
		$total_deducted = 0;
		$loanIds = [];

		$emis = $this->db
			->select('e.*')
			->from('employee_loan_emi e')
			->join('employee_loan l','l.loan_id=e.loan_id')
			->where('l.emp_code',$emp_code)
			->where('l.company_id',$company_id)
			->where_in('e.status',['PENDING','PARTIAL'])
			->where('e.emi_month <=', $pay_month.'-01')
			->order_by('e.emi_month','ASC')
			->get()
			->result();

		foreach ($emis as $emi) {

			if ($available_salary <= 0) break;

			$loanIds[$emi->loan_id] = true;

			$remaining = $emi->emi_amount - $emi->recovered_amount;
			$deduct    = min($remaining, $available_salary);

			$this->db->insert('employee_loan_emi_recovery',[
				'emi_id'         => $emi->emi_id,
				'loan_id'        => $emi->loan_id,
				'emp_code'       => $emp_code,
				'company_id'       => $company_id,
				'payroll_run_id' => $payroll_run_id,
				'pay_month'      => $pay_month,
				'deducted_amount'=> $deduct,
				'created_at'     => date('Y-m-d H:i:s')
			]);

			$new_recovered = $emi->recovered_amount + $deduct;

			$this->db->where('emi_id',$emi->emi_id)->update(
				'employee_loan_emi',[
					'recovered_amount'=>$new_recovered,
					'status'=>($new_recovered >= $emi->emi_amount) ? 'RECOVERED':'PARTIAL'
				]
			);

			$available_salary -= $deduct;
			$total_deducted   += $deduct;
		}

		// ✅ NOW auto close loan (single responsibility)
		foreach (array_keys($loanIds) as $loan_id) {
			$this->autoCloseLoanIfCompleted($loan_id);
		}

		return $total_deducted;
	}


	private function rollbackLoanRecoveryByPayrollRun($payroll_run_id)
	{
		$company_id = $this->session->userdata('company_id'); 
		$rows = $this->db
			->where('payroll_run_id', $payroll_run_id)
			->where('company_id', $company_id)
			->get('employee_loan_emi_recovery')
			->result();

		foreach ($rows as $r) {

			// subtract recovered amount
			$this->db->set(
				'recovered_amount',
				'recovered_amount - ' . (float)$r->deducted_amount,
				false
			)->where('emi_id', $r->emi_id)
			->update('employee_loan_emi');

			// restore status
			$emi = $this->db
				->where('emi_id', $r->emi_id)
				->get('employee_loan_emi')
				->row();

			if ($emi->recovered_amount <= 0) {
				$this->db->where('emi_id', $r->emi_id)
						->update('employee_loan_emi', ['status'=>'PENDING']);
			} elseif ($emi->recovered_amount < $emi->emi_amount) {
				$this->db->where('emi_id', $r->emi_id)
						->update('employee_loan_emi', ['status'=>'PARTIAL']);
			}
		}

		// delete recovery log
		$this->db->where('payroll_run_id', $payroll_run_id)->where('company_id', $company_id)
				->delete('employee_loan_emi_recovery');
	}

	public function getLoanDeductionForSalarySlip($emp_code, $pay_month, $payroll_run_id)
	{
		$company_id = $this->session->userdata('company_id'); 
		$pay_month = date('Y-m', strtotime($pay_month));

		$row = $this->db
			->select_sum('deducted_amount')
			->where([
				'company_id'       => $company_id,
				'emp_code'       => $emp_code,
				'pay_month'      => $pay_month,
				'payroll_run_id' => $payroll_run_id
			])
			->get('employee_loan_emi_recovery')
			->row();

		return (float)($row->deducted_amount ?? 0);
	}

	private function autoCloseLoanIfCompleted($loan_id)
	{
		$company_id = $this->session->userdata('company_id'); 
		$pending = $this->db
			->where('loan_id', $loan_id)
			->where_in('status', ['PENDING','PARTIAL'])
			->count_all_results('employee_loan_emi');

		if ($pending == 0) {
			$this->db->where('loan_id', $loan_id)->where('company_id', $company_id)
				->update('employee_loan', [
					'status'     => 'CLOSED',
					'closed_on'  => date('Y-m-d'),
					'updated_at' => date('Y-m-d H:i:s')
				]);
		}
	}

	public function getEmpLoanstatus($emp_code)
	{
		$company_id = $this->session->userdata('company_id'); 
		$sql = "
			SELECT
				L.loan_id,
				L.emp_code,
				L.loan_amount,
				L.tenure_months,
				L.emi_amount,
				L.interest_rate,
				L.start_month,
				L.status,
				L.closed_on,
				L.created_at,

				COUNT(E.emi_id) AS total_emi,
				SUM(E.emi_amount) AS total_emi_amount,
				SUM(E.recovered_amount) AS total_paid_amount,

				(SUM(E.emi_amount) - SUM(E.recovered_amount)) AS pending_amount,

				SUM(
					CASE 
						WHEN E.status IN ('PENDING','PARTIAL') 
						THEN 1 ELSE 0 
					END
				) AS remaining_emi,

				SUM(
					CASE 
						WHEN E.status = 'RECOVERED' 
						THEN 1 ELSE 0 
					END
				) AS completed_emi

			FROM employee_loan L
			LEFT JOIN employee_loan_emi E 
				ON E.loan_id = L.loan_id

			WHERE L.emp_code = '$emp_code' and L.company_id = '$company_id'
			GROUP BY L.loan_id
			ORDER BY L.created_at DESC
		";

		return $this->db->query($sql, [$emp_code])->result_array();
	}


	//calculate days via late punch
	public function get_days_via_late_punch($year, $month, $emp_code,$working_hr)
	{
		$company_id = $this->session->userdata('company_id'); 	
		$late_punch_days = 0;
		$from_date = date('Y-m-01 00:00:00', strtotime("$year-$month-01"));
		$to_date   = date('Y-m-t 23:59:59', strtotime("$year-$month-01"));
		
		$sql = "SELECT IFNULL(SUM(A.extra_min), 0) AS extra_min
			FROM daily_attendance A
			WHERE emp_code = ? AND company_id = ?
			AND shift_in_time BETWEEN ? AND ?
		";
		$res = $this->db->query($sql, [$emp_code, $company_id, $from_date, $to_date])->row_array();
		if(!empty($res) and isset($res['extra_min'])){
			$late_punch_minutes = (int)$res['extra_min'];
			if ($working_hr > 0 && $late_punch_minutes > 0) {
				$late_punch_days = $this->Base->cal_min_into_days_latepunch($late_punch_minutes,$working_hr);
			}
		}
		return $late_punch_days;
	}

	public function get_duty_hrs_form_punch($year, $month, $emp_code,$working_hr,$total_holiday)
	{
		$company_id = $this->session->userdata('company_id'); 	
		$total_present_days = 0;
		$from_date = date('Y-m-01 00:00:00', strtotime("$year-$month-01"));
		$to_date   = date('Y-m-t 23:59:59', strtotime("$year-$month-01"));
		
		$sql = "SELECT IFNULL(SUM(A.duty_hours), 0) AS duty_hours
			FROM daily_attendance A
			WHERE emp_code = ? AND company_id = ?
			AND shift_in_time BETWEEN ? AND ?
		";
		$res = $this->db->query($sql, [$emp_code, $company_id, $from_date, $to_date])->row_array();
		if(!empty($res) and isset($res['duty_hours'])){
			$duty_hours = (float)$res['duty_hours'];
			$duty_hours = $duty_hours + ($total_holiday * 8);//add holiday
			if ($working_hr > 0 && $duty_hours > 0) {
				$total_present_days = $this->Base->roud_days($duty_hours / $working_hr);
			}
		}
		return $total_present_days;
	}

	
	
    
    //generating salary 
	public function get_all_employee_generating_salary($id)
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id'); 

		$where=array('att_monthly_id'=>"$id");
		$res=$this->Mymodel->select_where('daily_attendance_monthly',$where);  
		
		$company_role_id = $res[0]['company_role_id'];
		$emp_id = $res[0]['emp_code'];
		$att_year = $res[0]['att_year'];
		$att_month = $res[0]['att_month'];
		$total_present = $res[0]['total_present'];
		$total_ot = $res[0]['total_ot'];

		// //check attendance lock or not
		$rem_date = date('Y-m-d', strtotime("$att_year-$att_month-01"));
		$lock = $this->Base->atten_lock_check($rem_date,$emp_id);
		if($lock) {
			echo "Attendance for this month and year is locked and cannot be modified."; return;
		}

		$emp = $this->get_emp_details_with_id($emp_id);
		$pay_code = $emp[0]['emp_code'];
		$working_hr = $emp[0]['working_hr'];
		if(!empty($working_hr) and $working_hr >0){
			$working_hr = $working_hr;
		}else{
			$working_hr = 8;
		}

		
		//-----------------------------------------------total attendance and ot
		//$total_day_in_month = $res[0]['total_day_in_month'];
		$total_day_in_month = $this->get_salary_devide_by_month_days($company_role_id,$att_year,$att_month,$res[0]['total_day_in_month']);
		
		
		
		//-----------------------------------------------creating current month salary
		//---------master roll
		$basic_salary_master_roll = $res[0]['basic_salary_master_roll'];	$get_basic_salary_master_roll = round(((int)$basic_salary_master_roll/$total_day_in_month)*$total_present) ;
		$hra_master_roll = $res[0]['hra_master_roll'];						$get_hra_master_roll = round(((int)$hra_master_roll/$total_day_in_month)*$total_present) ;
		$conv_master_roll =$res[0]['conv_master_roll'];						$get_conv_master_roll = round(((int)$conv_master_roll/$total_day_in_month)*$total_present) ;
		$master_roll_total_get = round($get_basic_salary_master_roll+$get_hra_master_roll+$get_conv_master_roll);
		//---------master roll

		$current_ctc = $res[0]['current_ctc'];		
		$basic_salary = $res[0]['basic_salary'];		$basic_salary_payable = round(($basic_salary/$total_day_in_month)*$total_present) ;
		$hra = $res[0]['hra'];							$hra_payable = round(($hra/$total_day_in_month)*$total_present) ;
		$conv =$res[0]['conv'];							$conv_payable = round(($conv/$total_day_in_month)*$total_present) ;
		$city_comp = $res[0]['city_comp'];				$city_comp_payable = round(($city_comp/$total_day_in_month)*$total_present) ;
		$other_allow = $res[0]['other_allow'];			$other_allow_payable = round(($other_allow/$total_day_in_month)*$total_present) ;
		$spl_pay = $res[0]['spl_pay'];					$spl_pay_payable = round(($spl_pay/$total_day_in_month)*$total_present) ;
		$medi_rem = $res[0]['medi_rem'];				$medi_rem_payable = round(($medi_rem/$total_day_in_month)*$total_present) ;

		//--direct payable
		$fuel_reimb_payable = $res[0]['fuel_reimb'];			
		$bonus_payable = $res[0]['bonus'];
		$get_el_encashment_payable = $res[0]['get_el_encashment'];
		$get_cl_encashment_payable = $res[0]['get_cl_encashment'];
		$get_attendance_all_payable = $res[0]['get_attendance_all'];
		$get_other1_payable = $res[0]['get_other1'];
		$get_other2_payable = $res[0]['get_other2'];
		$get_other3_payable = $res[0]['get_other3'];
		$get_other4_payable = $res[0]['get_other4'];
		$grand_total1 = round($basic_salary_payable+$hra_payable+$conv_payable+$city_comp_payable+$other_allow_payable+$spl_pay_payable+$medi_rem_payable+$fuel_reimb_payable+$bonus_payable+$get_el_encashment_payable+$get_cl_encashment_payable+$get_attendance_all_payable+$get_other1_payable+$get_other2_payable+$get_other3_payable +$get_other4_payable);
		//$total_ot_rs =  round((($current_ctc/$total_day_in_month)/$working_hr)*$total_ot) ;
		$total_ot_rs =  round((($basic_salary/$total_day_in_month)/$working_hr)*$total_ot) ;
		$grand_total2 = round($grand_total1+$total_ot_rs);
		$current_ctc_payable = $grand_total2;

        ///PF
		if($res[0]['pf_ded'] == "Yes")
		{
			 $epf = (float)$res[0]['epf'];
			if($epf>0)
			{
				$epf_payable = round(($basic_salary_payable*$epf)/100);
				$epf1 = $epf;
				$epf_payable_master_roll = round(($get_basic_salary_master_roll*$epf)/100);
				
				if((int)$basic_salary > 15000 and $epf_payable > 1800){
					$epf_payable = 1800;
				}
			}
			else
			{
				$epf_payable = 0;
				$epf1 = 0;
				$epf_payable_master_roll = 0;
			}
		}else{$epf_payable = 0;$epf1 = 0;$epf_payable_master_roll =0;}
		 
		
        //getting esic
		if($res[0]['esic_ded'] == "Yes")
		{
			$esic = $res[0]['esic']; 
			if($esic>0)
			{
				$esic_payable = round(($grand_total2*$esic)/100); 
				$esic1 = $esic;
				$esic_payable_master_roll = round(($master_roll_total_get*$esic)/100); 
			}
			else
			{
				$esic_payable = 0;
				$esic1 = 0;
				$esic_payable_master_roll = 0;
			}
		}else{$esic_payable = 0;$esic1 = 0;$esic_payable_master_roll = 0;}
		
		
		$canteen = $this->get_total_amt_of_emp(date("$att_year-$att_month-01"),date("$att_year-$att_month-t"),$pay_code);
		if(!empty($canteen[0]['total_amt'])){$lost_canteen_payable = (int)$canteen[0]['total_amt'];}else{$lost_canteen_payable=0;}
		$lost_breakfast_payable =0;

		
		$advance_amt = $this->get_total_advance_amt_of_emp(date("$att_year-$att_month-01"),date("$att_year-$att_month-t"),$pay_code);
		//$advance_this_month_payable = $res[0]['advance_this_month'];
		$advance_this_month_payable = $advance_amt;
		
		$lost_bus_payable = $res[0]['lost_bus'];
		$fine_amt = $this->get_total_fine_amt_of_emp(date("$att_year-$att_month-01"),date("$att_year-$att_month-t"),$pay_code);
		$lost_1_payable = (float)$res[0]['lost_1']+$fine_amt;
		//loan
		// 🔥 rollback old EMI for this salary run
		$this->rollbackLoanRecoveryByPayrollRun($id);
		$loan_emi = (float)$this->deductLoanEMIFromPayroll(
			$pay_code,
			date("$att_year-$att_month-01"),
			$grand_total2,
			$id
		);
		$lost_2_payable = (float)$res[0]['lost_2'] + $loan_emi;

		//get TDS of this maonth
		$tds_amt = (int)$this->get_total_tds_amt_of_emp(date("$att_year-$att_month-01"),date("$att_year-$att_month-t"),$pay_code);

		$lost_3_payable = (int)($res[0]['lost_3'] + $tds_amt);
		$lost_4_payable = $res[0]['lost_4'];
		
		$ex_gratia_payable = $res[0]['ex_gratia'];////not doning aothing
		$total_deduction = round((int)$esic_payable + (int)$epf_payable + (int)$lost_canteen_payable + (int)$lost_breakfast_payable + (int)$lost_bus_payable + (int)$lost_1_payable + (int)$lost_2_payable + (int)$lost_3_payable + (int)$lost_4_payable + (int)$advance_this_month_payable);
		
		//---greant total payable amt
		$current_total_ctc_payable = round($grand_total2-$total_deduction);



		//total lost master roll
		$lost_advance_master_roll = (float)$res[0]['lost_advance_master_roll'];
		$other_advance_master_roll = (float)$res[0]['other_advance_master_roll'];
		$total_loss = round($epf_payable_master_roll+$esic_payable_master_roll+$lost_advance_master_roll+$other_advance_master_roll);
		$master_roll_total_net_pay = round($master_roll_total_get-$total_loss);
		
		//updateing into table
		$data2=array(
						'current_ctc_payable'=>"$current_ctc_payable",
						'basic_salary_payable'=>"$basic_salary_payable",
						'working_hr'=>"$working_hr",
						'hra_payable'=>"$hra_payable",
						'conv_payable'=>"$conv_payable",
						'city_comp_payable'=>"$city_comp_payable",
						
						'other_allow_payable'=>"$other_allow_payable",
						'spl_pay_payable'=>"$spl_pay_payable",
						'medi_rem_payable'=>"$medi_rem_payable",
						
						'fuel_reimb_payable'=>"$fuel_reimb_payable",
						'esic'=>"$esic1",
						'epf'=>"$epf1",
						'esic_payable'=>"$esic_payable",
						'epf_payable'=>"$epf_payable",
						
						'bonus_payable'=>"$bonus_payable",
						'get_el_encashment_payable'=>"$get_el_encashment_payable",
						'get_cl_encashment_payable'=>"$get_cl_encashment_payable",
						
						'get_attendance_all_payable'=>"$get_attendance_all_payable",
						'get_other1_payable'=>"$get_other1_payable",
						'get_other2_payable'=>"$get_other2_payable",
						
						'get_other3_payable'=>"$get_other3_payable",
						'get_other4_payable'=>"$get_other4_payable",
						'lost_canteen_payable'=>"$lost_canteen_payable",

						'total_ot_rs'=>"$total_ot_rs",
						
						'lost_breakfast_payable'=>"$lost_breakfast_payable",
						'lost_bus_payable'=>"$lost_bus_payable",
						'lost_1_payable'=>"$lost_1_payable",
						'lost_2_payable'=>"$lost_2_payable",
						'lost_3_payable'=>"$lost_3_payable",
						'lost_4_payable'=>"$lost_4_payable",
						'advance_this_month_payable'=>"$advance_this_month_payable",
						'total_deduction'=>"$total_deduction",
						'current_total_ctc_payable'=>"$current_total_ctc_payable",

						'get_basic_salary_master_roll'=>"$get_basic_salary_master_roll",
						'get_hra_master_roll'=>"$get_hra_master_roll",
						'get_conv_master_roll'=>"$get_conv_master_roll",
						'master_roll_total_get'=>"$master_roll_total_get",
						'epf_payable_master_roll'=>"$epf_payable_master_roll",
						'esic_payable_master_roll'=>"$esic_payable_master_roll",
						'master_roll_total_loss'=>"$total_loss",
						'master_roll_total_net_pay'=>"$master_roll_total_net_pay",
						
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
			$where2=array('att_monthly_id'=>"$id");   
			$this->Mymodel->update('daily_attendance_monthly',$data2,$where2);
		
    }//function close




	public function generate_daily_wages_salary($id,$type_search,$year_search,$month_search)
	{
		$today = date("Y-m-d H:i:s");
		$user_email = $this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id'); 

		// ===== Attendance row =====
		$where = [
			'emp_code'=>$id,
			'company_id'=>$company_id,
			'company_role_id'=>$type_search,
			'att_year'=>$year_search,
			'att_month'=>$month_search
		];
		$res = $this->Mymodel->select_where('daily_attendance_monthly',$where);
		if(empty($res)) return;

		$row = $res[0];
		$total_present = (int)$row['total_present'];

		// ===== Employee =====
		$emp = $this->Mymodel->query1("
			SELECT emp_code,daily_wages_rs,working_hr,esic_ded,esic,pf_ded,epf
			FROM employee WHERE id='$id' and company_id='$company_id'
		");
		if(empty($emp)) return;

		$pay_code       = $emp[0]['emp_code'];
		$daily_wages_rs = (float)$emp[0]['daily_wages_rs'];
		$working_hr     = !empty($emp[0]['working_hr']) ? $emp[0]['working_hr'] : 8;

		$pf_ded  = $emp[0]['pf_ded'];
		$epf_pct = (float)$emp[0]['epf'];
		$esic_ded = $emp[0]['esic_ded'];
		$esic_pct = (float)$emp[0]['esic'];

		// ===== Month days =====
		$month_days = $this->get_salary_devide_by_month_days(
			$row['company_role_id'],
			$row['att_year'],
			$row['att_month'],
			$row['total_day_in_month']
		);

		// =====================================================
		// 1️⃣ MONTHLY CTC (DISPLAY ONLY)
		// =====================================================
		$monthly_ctc = round($daily_wages_rs * $month_days);

		// =====================================================
		// 2️⃣ FINAL EARNED AMOUNT (ABSOLUTE TRUTH)
		// =====================================================
		$earned_amount = round($daily_wages_rs * $total_present); // 500 × 15 = 7500 / 15500 etc

		// =====================================================
		// 3️⃣ PF / ESIC (BACK CALCULATION – NET KO NAHI CHHEDNA)
		// =====================================================
		$epf_payable  = 0;
		$esic_payable = 0;

		if($pf_ded=="Yes" && $epf_pct>0){
			$epf_payable = round(($earned_amount * $epf_pct)/100);
		}
		if($esic_ded=="Yes" && $esic_pct>0){
			$esic_payable = round(($earned_amount * $esic_pct)/100);
		}

		// =====================================================
		// 4️⃣ COMPONENT SPLIT (REVERSE CALCULATION)
		// =====================================================
		$basic_ratio = 0.50;
		$hra_ratio   = 0.30;
		$other_ratio = 0.20;

		$basic_salary_payable = round($earned_amount * $basic_ratio);
		$hra_payable          = round($earned_amount * $hra_ratio);
		$other_allow_payable  = $earned_amount - ($basic_salary_payable + $hra_payable);

		// =====================================================
		// 5️⃣ OTHER DEDUCTIONS
		// =====================================================
		$canteen = $this->get_total_amt_of_emp(
			date("$year_search-$month_search-01"),
			date("$year_search-$month_search-t"),
			$pay_code
		);
		$lost_canteen = !empty($canteen[0]['total_amt']) ? (int)$canteen[0]['total_amt'] : 0;

		$advance_amt = $this->get_total_advance_amt_of_emp(
			date("$year_search-$month_search-01"),
			date("$year_search-$month_search-t"),
			$pay_code
		);

		// Loan
		$this->rollbackLoanRecoveryByPayrollRun($row['att_monthly_id']);
		$loan_emi = (float)$this->deductLoanEMIFromPayroll(
			$pay_code,
			date("$year_search-$month_search-01"),
			$earned_amount,
			$row['att_monthly_id']
		);

		$tds_amt = (int)$this->get_total_tds_amt_of_emp(
			date("$year_search-$month_search-01"),
			date("$year_search-$month_search-t"),
			$pay_code
		);

		// =====================================================
		// 6️⃣ FINAL NET PAYABLE
		// =====================================================
		$total_deduction =
			$lost_canteen +
			$advance_amt +
			$loan_emi +
			$tds_amt;

		$final_net_payable = $earned_amount - $total_deduction;

		
		$data = [

				// ===== MONTHLY STRUCTURE (REFERENCE ONLY) =====
				'current_ctc'   => $monthly_ctc,

				'basic_salary'  => round($monthly_ctc * $basic_ratio),
				'hra'           => round($monthly_ctc * $hra_ratio),
				'other_allow'   => $monthly_ctc 
									- (round($monthly_ctc * $basic_ratio)
									+ round($monthly_ctc * $hra_ratio)),

				// ===== STATUTORY FLAGS =====
				'epf'      => $epf_pct,
				'esic'     => $esic_pct,
				'pf_ded'   => $pf_ded,
				'esic_ded' => $esic_ded,

				// ===== EARNED (ACTUAL PAYABLE) =====
				'basic_salary_payable' => $basic_salary_payable,
				'hra_payable'          => $hra_payable,
				'other_allow_payable'  => $other_allow_payable,

				'current_ctc_payable' => $earned_amount,
				'current_total_ctc'   => $earned_amount,

				// ===== DEDUCTIONS =====
				'epf_payable'                 => $epf_payable,
				'esic_payable'                => $esic_payable,
				'lost_canteen_payable'        => $lost_canteen,
				'lost_2_payable'              => $loan_emi,
				'lost_3_payable'              => $tds_amt,
				'advance_this_month'          => $advance_amt,
				'advance_this_month_payable'  => $advance_amt,

				'total_deduction'             => $total_deduction,

				// ===== FINAL NET =====
				'current_total_ctc_payable' => $final_net_payable,

				// ===== META =====
				'working_hr'  => $working_hr,
				'update_by'   => $user_email,
				'update_date'=> $today
			];


		$this->Mymodel->update('daily_attendance_monthly',$data,$where);
	}


    
	//generating canteen // not in use
	public function get_employee_canteen_bill_from_id($emp_code,$att_year,$att_month)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT  total_rs
				 FROM daily_attendance_monthly_emp_exp where company_id='$company_id' and emp_code='$emp_code' and att_year='$att_year' and att_month='$att_month' and type2='Canteen' ";
		$out=$this->Mymodel->query1($query);
		if(!empty($out))
		{
			return $out[0]['total_rs'];
		}
		else
		{
			return 0;
		}
	}//function close

	
	//generating breakfast  // not in use
	public function get_employee_breakfast_bill_from_id($emp_code,$att_year,$att_month)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT  total_rs
				 FROM daily_attendance_monthly_emp_exp where  company_id='$company_id' and  emp_code='$emp_code' and att_year='$att_year' and att_month='$att_month' and type2='Breakfast' ";
		$out=$this->Mymodel->query1($query);
		if(!empty($out))
		{
			return $out[0]['total_rs'];
		}
		else
		{
			return 0;
		}
	}//function close
    

    
	//update salary 
	public function get_all_emp_list_for_attendane_type_salary_details($id,$type_search,$year_search,$month_search)
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		$query=" SELECT id,pay_code, 
						current_ctc,bank_account_no,co_mob_no,increment_due_date,increment_due_month,
						basic_salary,hra,conv,city_comp,other_allow,
						spl_pay,medi_rem,fuel_reimb,esic,epf,bonus,
						get_el_encashment,get_cl_encashment,get_attendance_all,get_other1,
						get_other2,get_other3,get_other4,lost_canteen,lost_breakfast,lost_bus,
						lost_1,lost_2,lost_3,lost_4,lost_advance,ex_gratia,current_total_ctc,working_hr,
						esic_ded,pf_ded,basic_salary_master_roll,hra_master_roll,conv_master_roll,lost_advance_master_roll,other_advance_master_roll,on_daily_wages,daily_wages_rs
				 FROM employee where id='$id' and company_id='$company_id'  ";
		$res=$this->Mymodel->query1($query);
		$pay_code = $res[0]['pay_code'];

		$bank_account = $res[0]['bank_account_no'];		
		$bank_ifsc = $res[0]['co_mob_no'];
		if($res[0]['increment_due_date']!='0000-00-00'){$increment_date= $res[0]['increment_due_date'];}else{$increment_date='';}
		$increment_amt = $res[0]['increment_due_month'];

		

		// //check attendance lock or not
		$rem_date = date('Y-m-d', strtotime("$year_search-$month_search-01"));
		$lock = $this->Base->atten_lock_check($rem_date,$id);
		if($lock) {
			echo "Attendance for this month and year is locked and cannot be modified of $pay_code <br><br><br>"; return;
		}
		

		$on_daily_wages = $res[0]['on_daily_wages'];//Yes/No
		if ($on_daily_wages == "Yes") {
			$this->generate_daily_wages_salary($id,$type_search,$year_search,$month_search);
			return; // ❗ VERY IMPORTANT
		}

        
		$current_ctc = $res[0]['current_ctc'];
        $basic_salary = $res[0]['basic_salary'];
        $hra = $res[0]['hra'];
        $conv =$res[0]['conv'];
        $city_comp = $res[0]['city_comp'];
        $other_allow = $res[0]['other_allow'];
        $spl_pay = $res[0]['spl_pay'];
        $medi_rem = $res[0]['medi_rem'];
        $fuel_reimb = $res[0]['fuel_reimb'];
        $esic = $res[0]['esic'];
        $epf = $res[0]['epf'];
        $bonus = $res[0]['bonus'];
        $get_el_encashment = $res[0]['get_el_encashment'];
        $get_cl_encashment = $res[0]['get_cl_encashment'];
        $get_attendance_all = $res[0]['get_attendance_all'];
        $get_other1 = $res[0]['get_other1'];
        $get_other2 = $res[0]['get_other2'];
        $get_other3 = $res[0]['get_other3'];
        $get_other4 = $res[0]['get_other4'];
        $lost_canteen = $res[0]['lost_canteen'];
        $lost_breakfast = $res[0]['lost_breakfast'];
        $lost_bus = $res[0]['lost_bus'];
        $lost_1 = $res[0]['lost_1'];
        $lost_2 = $res[0]['lost_2'];
        $lost_3 = $res[0]['lost_3'];
        $lost_4 = $res[0]['lost_4'];
        $advance_this_month = $res[0]['lost_advance'];
        $ex_gratia = $res[0]['ex_gratia'];
        $current_total_ctc = $res[0]['current_total_ctc'];
		$working_hr = $res[0]['working_hr'];

		$esic_ded = $res[0]['esic_ded'];
		$pf_ded = $res[0]['pf_ded'];
		$basic_salary_master_roll = $res[0]['basic_salary_master_roll'];
		$hra_master_roll = $res[0]['hra_master_roll'];
		$conv_master_roll = $res[0]['conv_master_roll'];
		$lost_advance_master_roll = $res[0]['lost_advance_master_roll'];
		$other_advance_master_roll = $res[0]['other_advance_master_roll'];
        

        $data2=array(
                        'working_hr'=>"$working_hr",
						'current_ctc'=>"$current_ctc",
                        'basic_salary'=>"$basic_salary",
                        'hra'=>"$hra",
                        'conv'=>"$conv",
                        'city_comp'=>"$city_comp",
                        'other_allow'=>"$other_allow",
                        'spl_pay'=>"$spl_pay",
                        'medi_rem'=>"$medi_rem",
                        'fuel_reimb'=>"$fuel_reimb",
                        'esic'=>"$esic",
                        'epf'=>"$epf",
                        'bonus'=>"$bonus",
                        'get_el_encashment'=>"$get_el_encashment",
                        'get_cl_encashment'=>"$get_cl_encashment",
                        'get_attendance_all'=>"$get_attendance_all",
                        'get_other1'=>"$get_other1",
                        'get_other2'=>"$get_other2",
                        'get_other3'=>"$get_other3",
                        'get_other4'=>"$get_other4",
                        'lost_canteen'=>"$lost_canteen",
                        'lost_breakfast'=>"$lost_breakfast",
                        'lost_bus'=>"$lost_bus",
                        'lost_1'=>"$lost_1",
                        'lost_2'=>"$lost_2",
                        'lost_3'=>"$lost_3",
                        'lost_4'=>"$lost_4",
                        'advance_this_month'=>"$advance_this_month",
                        'ex_gratia'=>"$ex_gratia",
                        'current_total_ctc'=>"$current_total_ctc",
						'esic_ded'=>"$esic_ded",
						'pf_ded'=>"$pf_ded",
						'basic_salary_master_roll'=>"$basic_salary_master_roll",
						'hra_master_roll'=>"$hra_master_roll",
						'conv_master_roll'=>"$conv_master_roll",
						'lost_advance_master_roll'=>"$lost_advance_master_roll",
						'other_advance_master_roll'=>"$other_advance_master_roll",
						'bank_account'=>"$bank_account",
						'bank_ifsc'=>"$bank_ifsc",
						'increment_date'=>"$increment_date",
						'increment_amt'=>"$increment_amt",
                        'update_by'=>"$user_email",
                        'update_date'=>"$today",
					 );
        $where2=array('emp_code'=>"$id",'company_role_id'=>"$type_search",'att_year'=>"$year_search",'att_month'=>"$month_search");   
        $this->Mymodel->update('daily_attendance_monthly',$data2,$where2);

		//getting id of this row
		$res2=$this->Mymodel->select_where('daily_attendance_monthly',$where2);
		if(!empty($res2))
		{
			//----updating salary
			$this->get_all_employee_generating_salary($res2[0]['att_monthly_id']);
		}//if(!empty($res2))
	
	}//function close





	/*
	//---------------Salary details
	public function get_salary_details($data)
	{
        $from_date = $data[0];
		$to_date = $data[1];
		$dept = $data[2];
		//$contractor = $data[3];


		$sql = "
				SELECT 
				D.name as dname,A.company_role_id, sum(A.total_present) as total_present, sum(A.total_ot) as total_ot,sum(A.esic_payable) as esic_payable,
				sum(A.epf_payable) as epf_payable,sum(A.current_total_ctc_payable) as current_total_ctc_payable
				
				FROM daily_attendance_monthly as A
				
				LEFT JOIN employee E ON A.emp_code=E.emp_code
				LEFT JOIN department D ON E.department_id=D.department_id
				
				WHERE  E.department_id='$department_id' and   A.att_year='$att_year' and A.att_month='$att_month'  GROUP BY E.department_id   ";
													
													
        $query = $this->db->query($sql);
        $res = $query->result_array();
        if(isset($res) and !empty($res)){ return "TRUE";}else{ return "FALSE";}
    }//function close
	*/


























	//----------------------------production->get_dept_emp_detials
	/*
	public function get_dept_emp_detials($dept,$year,$month)
	{
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
        $label = $this->Base->get_day_no_on_month($month,$year);
		?>
			<h2 align="center"><?php echo $this->Base->get_name_form_dept_id($dept);?> Production Report (<?php echo $month.' / '.$year?>)</h2>
		
			<table border=1 id="printed_table" class="table-hover" width="100%">
				<tr>
					<th colspan=4>Date</th>
					<?php 
						foreach($label as $l)
						{
							?><td align="center" colspan=2><b><?php echo $l;?></b></td><?php 
						}
					?>
					<th colspan=3></th>
					<th></th>
					<th colspan=6>Incentive in Rs. (Day's)</th>
				</tr>
				<tr>
					
					<th>#</th>
					<th>Emp Code</th>
					<th>Name</th>
					<?php /*
					<th>Machine</th>
					<th>Hr Dept</th>
					<th>Designation </th>
					*-/?>
					<th>Gross Salary</th>
					<?php 
						foreach($label as $l)
						{
							?>
								<td align="right">Qty</td>
								<td align="right" style="color:blue">Eff</td>
							<?php 
						}
					?>
					
					<th>Total Qty</th>
					<th>Avg. Qty (Wt.kg)</th>
					<th>Avg Eff.</th>
					<th>Present</th>
					
					<th>75% Eff.</th>
					<th>80% Eff.</th>
					<th>85% Eff.</th>
					<th>90% Eff.</th>
					<th>100% Eff.</th>
					<th>Total Inc. Rs.</th>
				</tr>



				<?php
					//incentive rs
					$rs_eff_75 = 10;
					$rs_eff_80 = 15;
					$rs_eff_85 = 20;
					$rs_eff_90 = 30;
					$rs_eff_100 = 35;

					$total_rs_eff_751 = array();
					$total_rs_eff_801 = array();
					$total_rs_eff_851 = array();
					$total_rs_eff_901 = array();
					$total_rs_eff_1001 = array();
					$inc_grand_total_per_person1 = array();
					

					//op 
					$total = array();
					$total_eff = array();
					$totalForDay2 = array();
					$totalEffForDay2 = array();
					$row_total1 = array();
					$row_total2 = array();
					$row_total3 = array();
					$i=1;
					//all emp list
					$out2 = $this->Productionmodel->get_emp_list_in_given_date($dept,$from_date,$to_date,'Operator');
					foreach($out2 as $o)
					{
						$out3 = $this->get_emp_deatis_with_emp_code($o);
						if(!empty($out3))
						{
							?>
							<tr height="30">
								<td><?php echo $i;?></td>
								<td><?php echo $o;?></td>
								<td><?php if(isset($out3[0]['first_name']))echo $out3[0]['first_name'];?></td>
								<!--<td><?php //$this->Productionmodel->get_pro_of_emp_machine_name_in_given_date($dept,$from_date,$to_date,$o);?></td>
								<td><?php //if(isset($out3[0]['sub_dept_name']))echo $out3[0]['sub_dept_name'];?></td>
								<td><?php //if(isset($out3[0]['role_name']))echo $out3[0]['role_name'];?></td>-->
								<td><?php if(isset($out3[0]['current_total_ctc'])){echo $salary = $out3[0]['current_total_ctc'];}else{$salary=0;}?></td>
								<?php 
									$total = array();
									$total_eff = array();
									$totalForDay = array();
									$totalEffForDay = array();

									

									$eff_75 = 0;
									$eff_80 = 0;
									$eff_85 = 0;
									$eff_90 = 0;
									$eff_100 = 0;
									$total_rs_eff_75 = 0;
									$total_rs_eff_80 = 0;
									$total_rs_eff_85 = 0;
									$total_rs_eff_90 = 0;
									$total_rs_eff_100 = 0;
									foreach($label as $l)
									{
										$current_date = $this->Base->change_date_ymd("$l-$month-$year");
										$pro = $this->Productionmodel->get_pro_on_emp_dept_date($o,$dept,$current_date,$current_date,'Operator');
										?>
											<td width="40" align='right'>
												<?php 
													if($pro['qty']>0){echo  $proTotal = $pro['qty']; $total[] = $proTotal; $totalForDay[$l] =$proTotal; }
												?>
											</td>
											<td width="40" align='right' style="color:blue">
												<?php 
													if($pro['eff']>0)
														{
															echo $effTotal = $pro['eff'];echo '%';  $total_eff[] = $effTotal; $totalEffForDay[$l] =$effTotal;
															if($effTotal >=75 and $effTotal <80){$eff_75 = $eff_75+1;}
															if($effTotal >=80 and $effTotal <85){ $eff_80 = $eff_80+ 1;}
															if($effTotal >=85 and $effTotal <90){$eff_85 = $eff_85+1;}
															if($effTotal >=90 and $effTotal <100){$eff_90 = $eff_90+1;}
															if($effTotal >=100){$eff_100 = $eff_100+1;}
														}
												?>
											</td>
										<?php 
									}
									$totalForDay2[] = $totalForDay;
									$totalEffForDay2[] = $totalEffForDay;
									//print_r($totalForDay);
								?>
								<td align='right'><?php echo $total2 =  round(array_sum($total));  $total_eff2 =  $total2; $row_total1[]=$total2;?></td>
								<td align='right'><?php if(!empty($total2)){ echo $row_avg2 = round($total2/count($total)); $row_total2[]=$row_avg2;}  ?></td>
								<td align='right'><?php if(!empty($total_eff)){  echo $row_eff2 = round(array_sum($total_eff)/count($total_eff)).'%'; $row_total3[]=$row_eff2;}?></td>
								
								<td align='right'><?php if(!empty($total2)){ echo count($total); }?></td>
								<td align='right'><?php if(!empty($eff_75)){ $total_rs_eff_75 = round($rs_eff_75*$eff_75); echo $total_rs_eff_75 .' ('.$eff_75.')'; $total_rs_eff_751[] = $total_rs_eff_75; }?></td>
								<td align='right'><?php if(!empty($eff_80)){ $total_rs_eff_80 = round($rs_eff_80*$eff_80); echo $total_rs_eff_80.' ('.$eff_80.')'; $total_rs_eff_801[]=$total_rs_eff_80; }?></td>
								<td align='right'><?php if(!empty($eff_85)){ $total_rs_eff_85 = round($rs_eff_85*$eff_85); echo $total_rs_eff_85.' ('.$eff_85.')'; $total_rs_eff_851[]= $total_rs_eff_85; }?></td>
								<td align='right'><?php if(!empty($eff_90)){ $total_rs_eff_90 = round($rs_eff_90*$eff_90); echo $total_rs_eff_90 .' ('.$eff_90.')'; $total_rs_eff_901[]= $total_rs_eff_90; }?></td>
								<td align='right'><?php if(!empty($eff_100)){ $total_rs_eff_100 = round($rs_eff_100*$eff_100); echo $total_rs_eff_100 .' ('.$eff_100.')'; $total_rs_eff_1001[] = $total_rs_eff_100; }?></td>
								
								<td align='right'><?php $inc_grand_total_per_person = round((float)$total_rs_eff_75 + (float)$total_rs_eff_80 + (float)$total_rs_eff_85 + (float)$total_rs_eff_90 + (float)$total_rs_eff_100 ); if($inc_grand_total_per_person>0)echo $inc_grand_total_per_person1[] = $inc_grand_total_per_person;?></td>
								
							
							</tr>
							<?php
							$i++;
						}
					}
				?>
				<tr style ="background-color:yellow">
						<td colspan="4">Total</td>
						<?php 
						$finalDayWiseTotal = $this->Base->add_multi_array($totalForDay2);
						$finalDayWiseeff = $this->Base->avg_multi_array1($totalEffForDay2);
						//print_r($finalDayWiseeff);
						foreach($label as $l)
						{
							?>
								<td align="right"><?php  if(!empty($finalDayWiseTotal[$l]))echo $finalDayWiseTotal[$l];?></td>
								<td align="right" style="color:blue"><?php if(!empty($finalDayWiseeff[$l]))echo $this->Base->avg_multi_array2($finalDayWiseeff[$l]);echo "%";?></td>
							<?php 
						}
					?>
					<td align='right'><?php  if(!empty($row_total1)){ echo $row_total11 =  round(array_sum($row_total1));}?></td>
					<td align='right'><?php if(!empty($row_total2)){ echo round(array_sum($row_total2)/count($row_total2));}  ?></td>
					<td align='right'><?php if(!empty($row_total3)){ echo round(array_sum($row_total3)/count($row_total3)); echo "%";}  ?></td>
					<td></td>
					<td align='right'><?php if(!empty($total_rs_eff_751)){ echo round(array_sum($total_rs_eff_751));}  ?></td>
					<td align='right'><?php if(!empty($total_rs_eff_801)){ echo round(array_sum($total_rs_eff_801));}  ?></td>
					<td align='right'><?php if(!empty($total_rs_eff_851)){ echo round(array_sum($total_rs_eff_851));}  ?></td>
					<td align='right'><?php if(!empty($total_rs_eff_901)){ echo round(array_sum($total_rs_eff_901));}  ?></td>
					<td align='right'><?php if(!empty($total_rs_eff_1001)){ echo round(array_sum($total_rs_eff_1001));}  ?></td>
					<td align='right'><?php if(!empty($inc_grand_total_per_person1)){ echo round(array_sum($inc_grand_total_per_person1));}  ?></td>

				</tr>
		
				<tr style ="background-color:yellow">
					<td colspan="74">Helper</td>
				</tr>
				<?php
					//helper 
					$total = array();
					$total_eff = array();
					$totalForDay2 = array();
					$totalEffForDay2 = array();
					$row_total1 = array();
					$row_total2 = array();
					$row_total3 = array();
					
					$total_rs_eff_751 = array();
					$total_rs_eff_801 = array();
					$total_rs_eff_851 = array();
					$total_rs_eff_901 = array();
					$total_rs_eff_1001 = array();
					$inc_grand_total_per_person1 = array();
					

					$i=1;
					//all emp list
					$out2 = $this->Productionmodel->get_emp_list_in_given_date($dept,$from_date,$to_date,'Helper');
					foreach($out2 as $o)
					{
						$out3 = $this->get_emp_deatis_with_emp_code($o);
						if(!empty($out3))
						{
							?>
							<tr height="30">
								<td><?php echo $i;?></td>
								<td><?php echo $o;?></td>
								<td><?php if(isset($out3[0]['first_name']))echo $out3[0]['first_name'];?></td>
								<!--<td><?php //$this->Productionmodel->get_pro_of_emp_machine_name_in_given_date($dept,$from_date,$to_date,$o);?></td>
								<td><?php //if(isset($out3[0]['sub_dept_name']))echo $out3[0]['sub_dept_name'];?></td>
								<td><?php //if(isset($out3[0]['role_name']))echo $out3[0]['role_name'];?></td>-->
								<td><?php if(isset($out3[0]['current_total_ctc'])){echo $salary = $out3[0]['current_total_ctc'];}else{$salary=0;}?></td>
								<?php 
									$total = array();
									$total_eff = array();
									$totalForDay = array();
									$totalEffForDay = array();

									

									$eff_75 = 0;
									$eff_80 = 0;
									$eff_85 = 0;
									$eff_90 = 0;
									$eff_100 = 0;
									$total_rs_eff_75 = 0;
									$total_rs_eff_80 = 0;
									$total_rs_eff_85 = 0;
									$total_rs_eff_90 = 0;
									$total_rs_eff_100 = 0;
									foreach($label as $l)
									{
										$current_date = $this->Base->change_date_ymd("$l-$month-$year");
										$pro = $this->Productionmodel->get_pro_on_emp_dept_date($o,$dept,$current_date,$current_date,'Helper');
										?>
											<td width="40" align='right'>
												<?php 
													if($pro['qty']>0){echo  $proTotal = $pro['qty']; $total[] = $proTotal; $totalForDay[$l] =$proTotal; }
												?>
											</td>
											<td width="40" align='right' style="color:blue">
												<?php 
													if($pro['eff']>0)
													{	
														echo $effTotal = $pro['eff'];echo '%';  $total_eff[] = $effTotal; $totalEffForDay[$l] =$effTotal;
														if($effTotal >=75 and $effTotal <80){$eff_75 = $eff_75+1;}
														if($effTotal >=80 and $effTotal <85){ $eff_80 = $eff_80+ 1;}
														if($effTotal >=85 and $effTotal <90){$eff_85 = $eff_85+1;}
														if($effTotal >=90 and $effTotal <100){$eff_90 = $eff_90+1;}
														if($effTotal >=100){$eff_100 = $eff_100+1;}
													}

												?>
											</td>
										<?php 
									}
									$totalForDay2[] = $totalForDay;
									$totalEffForDay2[] = $totalEffForDay;
									//print_r($totalForDay);
								?>
								<td align='right'><?php echo $total2 =  round(array_sum($total));  $total_eff2 =  $total2; $row_total1[]=$total2;?></td>
								<td align='right'><?php if(!empty($total2)){ echo $row_avg2 = round($total2/count($total)); $row_total2[]=$row_avg2;}  ?></td>
								<td align='right'><?php if(!empty($total_eff)){  echo $row_eff2 = round(array_sum($total_eff)/count($total_eff)).'%'; $row_total3[]=$row_eff2;}?></td>
								<td align='right'><?php if(!empty($total2)){ echo count($total); }?></td>
								<td align='right'><?php if(!empty($eff_75)){ $total_rs_eff_75 = round($rs_eff_75*$eff_75); echo $total_rs_eff_75 .' ('.$eff_75.')'; $total_rs_eff_751[] = $total_rs_eff_75; }?></td>
								<td align='right'><?php if(!empty($eff_80)){ $total_rs_eff_80 = round($rs_eff_80*$eff_80); echo $total_rs_eff_80.' ('.$eff_80.')'; $total_rs_eff_801[]=$total_rs_eff_80; }?></td>
								<td align='right'><?php if(!empty($eff_85)){ $total_rs_eff_85 = round($rs_eff_85*$eff_85); echo $total_rs_eff_85.' ('.$eff_85.')'; $total_rs_eff_851[]= $total_rs_eff_85; }?></td>
								<td align='right'><?php if(!empty($eff_90)){ $total_rs_eff_90 = round($rs_eff_90*$eff_90); echo $total_rs_eff_90 .' ('.$eff_90.')'; $total_rs_eff_901[]= $total_rs_eff_90; }?></td>
								<td align='right'><?php if(!empty($eff_100)){ $total_rs_eff_100 = round($rs_eff_100*$eff_100); echo $total_rs_eff_100 .' ('.$eff_100.')'; $total_rs_eff_1001[] = $total_rs_eff_100; }?></td>
								
								<td align='right'> <?php $inc_grand_total_per_person = round((float)$total_rs_eff_75 + (float)$total_rs_eff_80 + (float)$total_rs_eff_85 + (float)$total_rs_eff_90 + (float)$total_rs_eff_100 ); if($inc_grand_total_per_person>0)echo $inc_grand_total_per_person1[] = $inc_grand_total_per_person;?></td>
							</tr>
							<?php
							$i++;
						}
					}
				?>
				<tr style ="background-color:yellow">
						<td colspan="4">Total</td>
						<?php 
						$finalDayWiseTotal = $this->Base->add_multi_array($totalForDay2);
						$finalDayWiseeff = $this->Base->avg_multi_array1($totalEffForDay2);
						//print_r($finalDayWiseeff);
						foreach($label as $l)
						{
							?>
								<td align="right"><?php  if(!empty($finalDayWiseTotal[$l]))echo $finalDayWiseTotal[$l];?></td>
								<td align="right" style="color:blue"><?php if(!empty($finalDayWiseeff[$l]))echo $this->Base->avg_multi_array2($finalDayWiseeff[$l]);echo "%";?></td>
							<?php 
						}
					?>
					<td align='right'><?php  if(!empty($row_total1)){ echo $row_total11 =  round(array_sum($row_total1));}?></td>
					<td align='right'><?php if(!empty($row_total2)){ echo round(array_sum($row_total2)/count($row_total2));}  ?></td>
					<td align='right'><?php if(!empty($row_total3)){ echo round(array_sum($row_total3)/count($row_total3)); echo "%";}  ?></td>
					<td></td>
					<td align='right'><?php if(!empty($total_rs_eff_751)){ echo round(array_sum($total_rs_eff_751));}  ?></td>
					<td align='right'><?php if(!empty($total_rs_eff_801)){ echo round(array_sum($total_rs_eff_801));}  ?></td>
					<td align='right'><?php if(!empty($total_rs_eff_851)){ echo round(array_sum($total_rs_eff_851));}  ?></td>
					<td align='right'><?php if(!empty($total_rs_eff_901)){ echo round(array_sum($total_rs_eff_901));}  ?></td>
					<td align='right'><?php if(!empty($total_rs_eff_1001)){ echo round(array_sum($total_rs_eff_1001));}  ?></td>
					<td align='right'><?php if(!empty($inc_grand_total_per_person1)){ echo round(array_sum($inc_grand_total_per_person1));}  ?></td>
				</tr>
			</table>
		<?php
		 
	}//function close
	*/

	


	//----------------------------production->get_dept_emp_full_detials
	public function get_dept_emp_full_detials($dept,$year,$month)
	{
        $from_date = date("$year-$month-01");
        $to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
       	?>
			<h2 align="left"><?php echo $dept_name = $this->Base->get_name_form_dept_id($dept);?> Production Report (<?php echo $month.' / '.$year?>)</h2>
			<?php
			//all Operator
			$out2 = $this->Productionmodel->get_emp_list_in_given_date($dept,$from_date,$to_date,'Operator');
			?>
			<table border=1 id="printed_table" class="table-hover" width="100%">
				<tr>
					<th>#</th>
					<th>Designation </th>
					<th>Emp Code</th>
					<th>Name</th>
					<th>Dept</th>
					<th>Machine</th>
					<th>Production (Wt.kg)</th>
					<th>Eff.(%)</th>
					<th>Scrap</th>
					<th>Short Length</th>
					<th>Gross Salary</th>
					<th>Present</th>
					<th>Absent</th>
					<th>Total OT</th>
					<th>Net Salary</th>
				</tr>
				<?php 
					//Operator
					$i=1;
					foreach($out2 as $emp_code)
					{
						//emp detials
						$out3 = $this->get_emp_deatis_with_emp_code($emp_code);
						if(!empty($out3))
						{
							//production and eff
							$pro = $this->Productionmodel->get_pro_on_emp_dept_date($emp_code,$dept,$from_date,$to_date,'Operator');

							//attendance
							$company_role = $out3[0]['company_role'];
							$emp_id = $out3[0]['id'];
							$att = $this->get_atten_details_limit($company_role,$emp_id,$year,$month,1);
							?>
							<tr height="30">
								<td><?php echo $i;?></td>
								<td>Operator</td>
								<td><?php echo $emp_code;?></td>
								<td><?php if(isset($out3[0]['first_name']))echo $out3[0]['first_name'];?></td>
								<td><?php echo $dept_name;?></td>
								<td><?php $this->Productionmodel->get_pro_of_emp_machine_name_in_given_date($dept,$from_date,$to_date,$emp_code);?></td>
								<td><?php echo $qty=  $pro['qty'];?></td>
								<td><?php if($pro['eff']>0)echo $pro['eff'].' %';?></td>
								<td><?php //echo $o;?></td>
								<td><?php //echo $o;?></td>
								<td><?php if(isset($out3[0]['current_total_ctc'])){echo $salary = $out3[0]['current_total_ctc'];}else{$salary=0;}?></td>
								<td><?php if(isset($att[0]['total_present']))echo $att[0]['total_present'];?></td>
								<td><?php if(isset($att[0]['total_absent']))echo $att[0]['total_absent'];?></td>
								<td><?php if(isset($att[0]['total_ot']))echo $att[0]['total_ot'];?></td>
								<td><?php if(isset($att[0]['current_total_ctc_payable']))echo $att[0]['current_total_ctc_payable'];?></td>
								
							</tr>
							<?php
							$i++;
						}//out
					}//foreach
					?>
					<tr style ="background-color:#CCC">
						<td colspan="15">Helper</td>
					</tr>
					<?php

					
					//all helper
					$out2 = $this->Productionmodel->get_emp_list_in_given_date($dept,$from_date,$to_date,'Helper');
					$i=1;
					foreach($out2 as $emp_code)
					{
						//emp detials
						$out3 = $this->get_emp_deatis_with_emp_code($emp_code);
						if(!empty($out3))
						{
							//production and eff
							$pro = $this->Productionmodel->get_pro_on_emp_dept_date($emp_code,$dept,$from_date,$to_date,'Helper');

							//attendance
							$company_role = $out3[0]['company_role'];
							$emp_id = $out3[0]['id'];
							$att = $this->get_atten_details_limit($company_role,$emp_id,$year,$month,1);
							?>
							<tr height="30">
								<td><?php echo $i;?></td>
								<td>Helper</td>
								<td><?php echo $emp_code;?></td>
								<td><?php if(isset($out3[0]['first_name']))echo $out3[0]['first_name'];?></td>
								
								<td><?php echo $dept_name;?></td>
								<td><?php $this->Productionmodel->get_pro_of_emp_machine_name_in_given_date($dept,$from_date,$to_date,$emp_code);?></td>
								<td><?php echo $qty=  $pro['qty'];?></td>
								<td><?php if($pro['eff']>0)echo $pro['eff'].' %';?></td>
								<td><?php //echo $o;?></td>
								<td><?php //echo $o;?></td>
								
								<td><?php if(isset($out3[0]['current_total_ctc'])){echo $salary = $out3[0]['current_total_ctc'];}else{$salary=0;}?></td>
								<td><?php if(isset($att[0]['total_present']))echo $att[0]['total_present'];?></td>
								<td><?php if(isset($att[0]['total_absent']))echo $att[0]['total_absent'];?></td>
								<td><?php if(isset($att[0]['total_ot']))echo $att[0]['total_ot'];?></td>
								<td><?php if(isset($att[0]['current_total_ctc_payable']))echo $att[0]['current_total_ctc_payable'];?></td>
								
							</tr>
							<?php
							$i++;
						}//out
					}//foreach
				?>
			</table>
		<?php 


		
    }//function close










	//----------------------------production->get_dept_emp_full_detials
	public function print_attendance_date_time($emp_code,$day,$month,$year)
	{
		$company_id = $this->session->userdata('company_id');
		//in out time
		$new_date = $this->Base->change_date_ymd("$day-$month-$year");
		$query=" SELECT id,in_time,out_time,shift FROM daily_attendance where   emp_code='$emp_code' and company_id='$company_id' and shift_in_time between '$new_date 00:00:00' and '$new_date 23:59:59' ORDER BY shift_in_time DESC  LIMIT 1 ";
		$last_entry = $this->Mymodel->query1($query);
		//print_r($last_entry);
		if(!empty($last_entry))
		{
			echo $this->Base->change_time_Hi($last_entry[0]['in_time']);
			echo "<br>";
			if($last_entry[0]['out_time'] != '0000-00-00 00:00:00'){echo $this->Base->change_time_Hi($last_entry[0]['out_time']);}
		}
	}//function close









	//count no of emp in thid dept in this post
	public function get_dept_and_post_wise_total_emp($dept_id,$role)
	{
		$company_id = $this->session->userdata('company_id');
		if($role == 'HEL')
		{
			$role_line = "  and E.role_in_department='18' ";
		}
		elseif($role == 'OP')
		{
			//$role_line = " and E.role_in_department='16' ";
			$role_line = "  and (E.role_in_department = '16'  or E.role_in_department ='25' or  E.role_in_department ='26' or  E.role_in_department ='31' or  E.role_in_department ='32') ";
		}
		elseif($role == 'OT')
		{
			$role_line = "  and (E.role_in_department != '16' and E.role_in_department != '18'  and E.role_in_department !='25' and  E.role_in_department !='26' and  E.role_in_department !='31' and  E.role_in_department !='32') ";
		}
		else
		{
			$role_line = "  ";
		}


	 	$query=" 	SELECT E.emp_code
					FROM employee as E 
					where  E.company_id='$company_id' and E.attendance_entry != 1 and E.department_id in ($dept_id)  $role_line and E.status='Active' and E.active='Active'
					GROUP BY E.emp_code 
				";
		$out = $this->Mymodel->query1($query);
		//print_r($out);
		if(!empty($out)){ return count($out);}
	}//function close



	//dept wise present 
	public function get_emp_att_status_dept_wise($new_date,$dept_id,$role,$status,$return_value)
	{
		$company_id = $this->session->userdata('company_id');
		if($role == 'HEL')
		{
			$role_line = "  and E.role_in_department='18' ";
		}
		elseif($role == 'OP')
		{
			//$role_line = " and E.role_in_department='16' ";
			$role_line = "   and (E.role_in_department = '16'  or E.role_in_department ='25' or  E.role_in_department ='26' or  E.role_in_department ='31' or  E.role_in_department ='32') ";
		}
		elseif($role == 'OT')
		{
			$role_line = "  and (E.role_in_department != '16' and E.role_in_department != '18'  and E.role_in_department !='25' and  E.role_in_department !='26' and  E.role_in_department !='31' and  E.role_in_department !='32') ";
		}
		else
		{
			$role_line = "";
		}


		$day = $this->Base->change_date_into_day($new_date);
		$month = $this->Base->change_date_into_month($new_date);
		$year = $this->Base->change_date_into_year($new_date);
		
		
		$column = "d$day";
		if($status == 'R/L')
		{
			$query=" 	SELECT E.emp_code
					FROM daily_attendance_monthly as A 
					LEFT JOIN employee as E ON E.id = A.emp_code
					where  A.company_id='$company_id' and E.attendance_entry != 1 and A.att_year='$year' and att_month='$month' and ($column='R' OR $column='L' OR $column='CL' OR $column='EL' OR $column='SL' OR $column='OL') and E.department_id in ($dept_id)  $role_line
					GROUP BY E.emp_code
				";
		}
		if($status == 'P/S/R')
		{
			$query=" 	SELECT E.emp_code
					FROM daily_attendance_monthly as A 
					LEFT JOIN employee as E ON E.id = A.emp_code
					where  A.company_id='$company_id' and E.attendance_entry != 1 and A.att_year='$year' and att_month='$month' and ($column='P' OR $column='S' OR $column='R' OR $column='CL' OR $column='EL' OR $column='SL' OR $column='OL') and E.department_id in ($dept_id)  $role_line
					GROUP BY E.emp_code
				";
		}
		else
		{
			$query=" 	SELECT E.emp_code
					FROM daily_attendance_monthly as A 
					LEFT JOIN employee as E ON E.id = A.emp_code
					where  A.company_id='$company_id' andE.attendance_entry != 1 and A.att_year='$year' and att_month='$month' and $column='$status' and E.department_id in ($dept_id)  $role_line
					GROUP BY E.emp_code
				";
		}
		
		$out = $this->Mymodel->query1($query);
		if(!empty($out))
		{ 
			if($return_value == 'Count')
			{
				return count($out);
			}
			if($return_value == 'Array')
			{
				$erp_id = array();
				foreach($out as $o)
				{
					$erp_id[] = $o['emp_code'];
				}
				return $erp_id;
			}
			else
			{
				return '';
			}
		}
	}//function close






	 //-----------------------------------------------------------report
    public function date_wise_attendance_summary($search_date)
    {
    	$next_date = $this->Base->add_no_of_days_in_date_ymd($search_date,'+1');
		?>
        	<div class="table-responsive">
                <table border=1 style="width:100%" class="table-hover" id="printed_table">
                    <thead style="background-color:<?php //echo $this->Company->table_bg_color();?>; color:<?php //echo $this->Company->table_ft_color();?>;">
						<tr style="font-weight:bold;">
                            <td colspan="1" align="center"></td>
							<td colspan="4" align="center"></td>
							<td colspan="4" align="center"></td>
							<td colspan="10" align="center"><?php echo $this->Base->change_date_dmy($search_date);?></td>
							<td colspan="4" align="center"><?php echo $this->Base->change_date_dmy($next_date);?></td>
							<td colspan="19" align="center"><?php //echo $this->Base->change_date_dmy($search_date);?></td>
                        </tr>
						<tr>
                            <th colspan="1">DEPARTMENT</th>
							<th colspan="4">TOTAL  REQUIREMENT</th>
							<th colspan="4">TOT. RAGISTER EMP. (PRESENT)</th>
                            <th colspan="10"> EMPLOYEE STATUS  (SHIFT A+B)</th>
                           
							<th colspan="1">PRESENT EMP.</th>
							<th colspan="3">UTILIZED MANPOWER </th>
							<th colspan="4">Balance Requirement</th>
                        </tr>
						<tr>
							<td colspan="1" align="center"></td>
							<td colspan="4" align="center"></td>
							<td colspan="4" align="center"></td>
							<th colspan="3" style="color:blue">LEAVE /REST</th>
							<th colspan="3" style="color:red">ABSENT</th>
                            <th colspan="4" style="color:green">PRESENT EMP</th>
                            <th colspan="1">RAGIS.</th>
							<th colspan="3"></th>
							<th colspan="4"></th>
                        </tr>
						<tr>
                            <th></th>
                            <th>SUP</th>
							<th>OPR</th>
							<th>HEL</th>
							<th>TOT.</th>
							<th>SUP</th>
							<th>OPR</th>
							<th>HEL</th>
							<th>TOT.</th>
							<th style="color:blue">SUP</th>
							<th style="color:blue">OPR</th>
							<th style="color:blue">HEL</th>
							<th style="color:red">SUP</th>
							<th style="color:red">OPR</th>
							<th style="color:red">HEL</th>
							<th style="color:green">SUP</th>
							<th style="color:green">OPR</th>
							<th style="color:green">HEL</th>
							<th style="color:green">TOT.</th>
							<th>DAY SHIFT.</th>
							<th>SUP</th>
							<th>OPR</th>
							<th>HEL</th>
							
							<th>SUP</th>
							<th>OPR</th>
							<th>HEL</th>
							<th>TOT.</th>
                        </tr>
                    </thead>
                    <tbody>
							<?php
							 	//$dept_list = array('Office','PPC','STORE','QUALITY','DIE ROOM','PAINTER','E.T.P','HYDRA  & FORKLIFT','SWEEPER','CIVIL','SECURITY','ELECT','MECH','PICKLING','MINI-BLOCK','WIRE DRAWING','WET','GI. PATT.','DISPATCH & PACKING','Cont.');
								$dept_list = $this->Base->hr_attendance_dept_list_all();
								//$dept_list = array('ELECT');
								foreach($dept_list as $l)
								{
									$random_name = $l;
									$ans = $this->Base->get_dept_name_from_random_name($random_name);
									$dept_id = $ans[0];
									?>
									<tr align="center">
										<td align="left"><?php echo $random_name ;?></td>
										<td ><?php echo $t1[] = $ans[1];?></td>
										<td ><?php echo $t2[] =$ans[2];?></td>
										<td ><?php echo $t3[] =$ans[3];?></td>
										<td><?php echo $t4[] =$ans[4];?></td>

										<td><?php echo $a = $this->get_dept_and_post_wise_total_emp($dept_id,'OT');$t5[] = $a;?></td>
										<td><?php echo $b = $this->get_dept_and_post_wise_total_emp($dept_id,'OP');$t6[] = $b;?></td>
										<td><?php echo $c = $this->get_dept_and_post_wise_total_emp($dept_id,'HEL');$t7[] = $c;?></td>
										<td><?php echo $d= $a+$b+$c;$t8[] = $d;?></td>
										
										<td style="color:blue"><?php echo $t9[] = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'OT','R/L','Count');?></td>
										<td style="color:blue"><?php echo $t10[] = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'OP','R/L','Count');?></td>
										<td style="color:blue"><?php echo $t11[] = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'HEL','R/L','Count');?></td>
										
										<td style="color:red"><?php echo $t12[] = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'OT','A','Count');?></td>
										<td style="color:red"><?php echo $t13[] = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'OP','A','Count');?></td>
										<td style="color:red"><?php echo $t14[] = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'HEL','A','Count');?></td>
										
										
										<td style="color:green"><?php echo $x3 = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'OT','P','Count');$t15[] = $x3;?></td>
										<td style="color:green"><?php echo $y3 = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'OP','P','Count');$t16[] = $y3;?></td>
										<td style="color:green"><?php echo $z3 = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'HEL','P','Count');$t17[] = $z3;?></td>
										<td style="color:green"><?php echo $t18[] = $x3+$y3+$z3;?></td>
										
										<td ><?php echo $t19[] =  $this->get_emp_att_status_dept_wise($next_date,$dept_id,'ALL','P','Count');?></td>
										<td ><?php echo $t20[] =  $this->get_emp_att_status_dept_wise($next_date,$dept_id,'OT','P','Count');?></td>
										<td ><?php echo $t21[] =  $this->get_emp_att_status_dept_wise($next_date,$dept_id,'OP','P','Count');?></td>
										<td ><?php echo $t22[] =  $this->get_emp_att_status_dept_wise($next_date,$dept_id,'HEL','P','Count');?></td>

										<td><?php echo $t23[] = $ans[1]-$a;?></td>
										<td><?php echo $t24[] = $ans[2]-$b;?></td>
										<td><?php echo $t25[] = $ans[3]-$c;?></td>
										<td><?php echo $t26[] = $ans[4]-$d;?></td>
									</tr>
								<?php
							}//foreach
							?>
							<tr style="font-weight:bold" align="center">
								<td>Total</td>
								<td><?php if(!empty($t1))echo $t1 = array_sum($t1);?></td>
								<td><?php if(!empty($t2))echo $t2 = array_sum($t2);?></td>
								<td><?php if(!empty($t3))echo $t3 = array_sum($t3);?></td>
								<td><?php if(!empty($t4))echo $t4 = array_sum($t4);?></td>
								<td><?php if(!empty($t5))echo $t5 = array_sum($t5);?></td>
								<td><?php if(!empty($t6))echo $t6 = array_sum($t6);?></td>
								<td><?php if(!empty($t7))echo $t7 = array_sum($t7);?></td>
								<td><?php if(!empty($t8))echo $t8 = array_sum($t8);?></td>
								<td><?php if(!empty($t9))echo $t9 = array_sum($t9);?></td>
								<td><?php if(!empty($t10))echo $t10 = array_sum($t10);?></td>
								<td><?php if(!empty($t11))echo $t11 = array_sum($t11);?></td>
								<td><?php if(!empty($t12))echo $t12 = array_sum($t12);?></td>
								<td><?php if(!empty($t13))echo $t13 = array_sum($t13);?></td>
								<td><?php if(!empty($t14))echo $t14 = array_sum($t14);?></td>
								<td><?php if(!empty($t15))echo $t15 = array_sum($t15);?></td>
								<td><?php if(!empty($t16))echo $t16 = array_sum($t16);?></td>
								<td><?php if(!empty($t17))echo $t17 = array_sum($t17);?></td>
								<td><?php if(!empty($t18))echo $t18 = array_sum($t18);?></td>
								<td><?php if(!empty($t19))echo $t19 = array_sum($t19);?></td>
								<td><?php if(!empty($t20))echo $t20 = array_sum($t20);?></td>
								<td><?php if(!empty($t21))echo $t21 = array_sum($t21);?></td>
								<td><?php if(!empty($t22))echo $t22 = array_sum($t22);?></td>
								<td><?php if(!empty($t23))echo $t23 = array_sum($t23);?></td>
								<td><?php if(!empty($t24))echo $t24 = array_sum($t24);?></td>
								<td><?php if(!empty($t25))echo $t25 = array_sum($t25);?></td>
								<td><?php if(!empty($t26))echo $t26 = array_sum($t26);?></td>
							</tr>
						</tbody>
                </table>
			<br><br>
        	<?php
				$month = $this->Base->change_date_into_month($search_date);
				$year = $this->Base->change_date_into_year($search_date);

				$from_date = date("$year-$month-01");
				$to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
				$label = $this->Base->get_day_no_on_month($month,$year);
				?>
				<table border=1 id="printed_table" class="table-hover" width="100%">
					<tr>
						<th>#</th>
						<?php 
							foreach($label as $l)
							{
								?><th><?php echo $l;?></th><?php 
							}
						?>
					</tr>
					<?php
					foreach($dept_list as $l)
					{
						$random_name = $l;
						$ans = $this->Base->get_dept_name_from_random_name($random_name);
						$dept_id = $ans[0];
						?>
							<tr align="center">
								<td align="left"><?php echo $random_name ;?></td>
								<?php 
									//date
									foreach($label as $l)
									{
										$current_date = $this->Base->change_date_ymd("$l-$month-$year");
										
										?><td ><?php echo  $this->get_emp_att_status_dept_wise($current_date,$dept_id,'ALL','P','Count');?></td><?php 
									}
								?>
							</tr>
						<?php 
					}//foreach
					?>
					
				</table>
				</div>
				<?php 
    }//function close



	public function daily_attendance_dept_wise_all_list($date,$same_diff,$dept)
	{
		if($same_diff == 'Yes'){$symbol = '=';}else{$symbol = '!=';}
		
		//$dept_list = $this->Base->hr_attendance_dept_list_all();
		//print_r($dept_list[$dept]);

		$query=" 	SELECT *
					FROM daily_attendance_dept_wise as A 
					where status='Active' and attendance_date='$date' and dept_name $symbol '$dept'
				";
		$out = $this->Mymodel->query1($query);
		
		$all_list = array();
		foreach($out as $o)
		{
			//echo $o['emp_list'];
			$exp_list = explode(',',$o['emp_list']);
			foreach($exp_list as $e)
			{
				$all_list[] = $e;
 				//echo $e;echo "<br>";
			}//foreach
		}//foreach
		//print_r($all_list);
		return $all_list;
		
	}//function close

	public function get_unique_id_that_not_present_in_other_dept_present_entry($this_dept_attendence_punch,$other_dept_list)
	{
		//print_r($this_dept_attendence_punch);
		$unique_list = array();
		if(!empty($this_dept_attendence_punch))
		{
			foreach($this_dept_attendence_punch as $a1)
			{
				if(in_array($a1,$other_dept_list))
				{
					//this id is exits in other dept direct entry attendance list, so this will not count in this dept present enrty. 
					//echo $a1;echo "<br>";
				}
				else
				{
					$unique_list[] = $a1;
					//echo $a1;echo "<br>";
				}
			}
		}
		return $unique_list;
	}//function close

	//add emp salary form array
	public function get_emp_per_day_salary_sum_form_emp_code_array($emp_list,$attendance_date)
	{
		$company_id = $this->session->userdata('company_id');
		//print_r($emp_list);
		$salary_list = array();
		foreach($emp_list as $e)
		{
			
			//old code 
			$query6=" SELECT current_total_ctc FROM employee where emp_code ='$e' and company_id='$company_id' ";
			$out6 = $this->Mymodel->query1($query6);
			if(!empty($out6) and $out6[0]['current_total_ctc']>0)
			{
				//$salary_list[] = round($out6[0]['current_total_ctc']/30);
				$salary_list[] = $this->get_emp_salary_on_a_single_date($e,$attendance_date);
			}
		
		}
		//print_r(round(array_sum($salary_list)));
		return round(array_sum($salary_list));
	}//function close





	


	//-----------------------------------------------------------report
	public function date_wise_attendance_summary2($search_date,$show_array,$show_pic)
	{
		$next_date = $this->Base->add_no_of_days_in_date_ymd($search_date,'+1');
		
		?>
		
				<table style="float:left;margin-left:20px;" border=1 style="width:<?php if($show_array == 'Yes' or $show_pic == 'Yes'){ echo "100";}else{echo "50";}?>%" id="printed_table">
					<thead style="background-color:<?php //echo $this->Company->table_bg_color();?>; color:<?php //echo $this->Company->table_ft_color();?>;">
						<tr style="font-weight:bold;">
							<td colspan="7" align="center"><?php echo $this->Base->change_date_dmy($search_date); if($search_date == date('Y-m-d')){echo " (A)";}else{echo " (A+B)";}?></td>
							<td colspan="7" align="center"><?php echo $this->Base->change_date_dmy($next_date); if($next_date == date('Y-m-d')){echo " (A)";}else{echo " (A+B)";}?></td>
					</tr>
						
						<tr>
							<th></th>
							<th colspan="2" style="color:green">PRESENT MANPOWER </th>
							<?php if($show_array == 'Yes'){?><td colspan='7'></td><?php }?>
							<th colspan="2" style="color:blue">UTILIZED  MANPOWER</th>
							<th></th>
							<?php if($show_pic == 'Yes'){?><td></td><?php }?>
							<th></th>
							<th colspan="2" style="color:green">PRESENT MANPOWER </th>
							<th colspan="2" style="color:blue">UTILIZED  MANPOWER</th>
							<th></th>
							<th></th>
						</tr>
						<tr>
							<th></th>
							<th colspan="1" style="color:green">(SUP+OP+HEL)</th>
							<th colspan="1" style="color:green">Total</th>
							<?php if($show_array == 'Yes'){?>
							<th colspan="1" style="color:black">today present in this list</th>
							<th colspan="1" style="color:black">other dept entry list</th>
							<th colspan="1" style="color:black">unique Sup</th>
							<th colspan="1" style="color:black">unique OP</th>
							<th colspan="1" style="color:black">unique Hel</th>
							<th colspan="1" style="color:black">unique Extra</th>
							<th colspan="1" style="color:black">Total unique</th>
							<?php }?>
							<th colspan="1" style="color:blue">(SUP+OP+HEL+EXT)</th>
							<th colspan="1" style="color:blue">Total</th>
							<th colspan="1" style="color:black">Salary</th>
							<?php if($show_pic == 'Yes'){?><td></td><?php }?>
							<th colspan="1" style="color:black">Production</th>


							<th colspan="1" style="color:green">(SUP+OP+HEL)</th>
							<th colspan="1" style="color:green">Total</th>
							<th colspan="1" style="color:blue">(SUP+OP+HEL+EXT)</th>
							<th colspan="1" style="color:blue">Total</th>
							<th colspan="1" style="color:black">Salary</th>
							<th colspan="1" style="color:black">Production</th>
						</tr>
					</thead>
					<tbody>
							<?php
								//$dept_list = array('Office','PPC','STORE','QUALITY','DIE ROOM','PAINTER','E.T.P','HYDRA  & FORKLIFT','SWEEPER','CIVIL','SECURITY','ELECT','MECH','PICKLING','MINI-BLOCK','WIRE DRAWING','WET','GI. PATT.','DISPATCH & PACKING','Cont.');
								$dept_list = $this->Base->hr_attendance_dept_list_all();
								$dept_list_nick_name = $this->Base->hr_attendance_dept_list_all_nick_name();
								//$dept_list = array('HR');
								$i=0;
								foreach($dept_list as $l)
								{
									$other_dept_list = $this->daily_attendance_dept_wise_all_list($search_date,'No',$l);
									$same_dept_list = $this->daily_attendance_dept_wise_all_list($search_date,'Yes',$l);
									
									$random_name = $l;
									$ans = $this->Base->get_dept_name_from_random_name($random_name);
									$dept_id = $ans[0];
									?>
									<tr align="center">
										<td align="left"><?php echo $dept_list_nick_name[$i];//$random_name ;?></td>
										<td>
											<?php 
												$list1 = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'OT','P','Array');if(!empty($list1 )){$x = count($list1);}else{$x = 0;}
												$list2 = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'OP','P','Array');if(!empty($list2 )){$y = count($list2);}else{$y = 0;}
												$list3 = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'HEL','P','Array');if(!empty($list3 )){$z = count($list3);}else{$z = 0;}
												$total1 = $x+$y+$z;
												echo " $x+$y+$z";
											?>
										</td>
										<td><?php echo $t1[] = $total1;?></td>
										<?php 
										$all_unique_s = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list1,$other_dept_list);
										$all_unique_o = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list2,$other_dept_list);
										$all_unique_h = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list3,$other_dept_list);
										$list_marge = array_unique(array_merge($all_unique_s,$all_unique_o,$all_unique_h));
										$unique_list_all_same_dept = $this->get_unique_id_that_not_present_in_other_dept_present_entry($same_dept_list,$list_marge);
										$k=0;
										foreach($unique_list_all_same_dept as $e)
										{
											if($e>0)
											{
												$k++;
											}
										}
										$total_extra = $k;
										$unique_list_all = array_unique(array_merge($all_unique_s,$all_unique_o,$all_unique_h,$unique_list_all_same_dept));
										$total_hel = count($all_unique_h);
										$total_op = count($all_unique_o);
										$total_sup = count($all_unique_s);
										
										if($show_array == 'Yes'){
										?>
												<td><?php print_r($list1);print_r($list2);print_r($list3);?></td>
												<td><?php print_r($other_dept_list);?></td>
												<td><?php print_r($all_unique_s);?></td>
												<td><?php print_r($all_unique_o);?></td>
												<td><?php print_r($all_unique_h);?></td>
												<td><?php print_r($unique_list_all_same_dept);?> </td>
												<td><?php $unique_list_all2[] = $unique_list_all;print_r($unique_list_all);?></td>
										<?php }?>
										<td><?php echo " $total_sup+$total_op+$total_hel+$total_extra";?></td>
										<td><?php echo $t2[] = round($total_sup+$total_op+$total_hel+$total_extra);?></td>
										<td><?php echo $total_salary[] = $this->get_emp_per_day_salary_sum_form_emp_code_array($unique_list_all,$search_date);?></td>
										<?php if($show_pic == 'Yes'){?>
											<td>
												<?php 
													foreach($unique_list_all as $u)
													{
														if($u>0)
														{
															$this->Base->emp_dp_from_emp_code($u,80,80);
														}
													}
												?>
											</td>
										<?php }?>
										<td>
											<?php 
												$production = $this->Productionmodel->get_production_date_dept_wise($search_date,$search_date,$dept_id);
												if(!empty($production)){echo $total_production[] = $production[0]['qty'];}else{echo $total_production[] ='';}
											?>
										</td>




										<?php 
												/*----------------     next date    ----------------*/
												$other_dept_listq = $this->daily_attendance_dept_wise_all_list($next_date,'No',$l);
												$same_dept_listq = $this->daily_attendance_dept_wise_all_list($next_date,'Yes',$l);
												
												/* old
												
												$kq=0;
												foreach($same_dept_listq as $eq)
												{
													if($eq>0)
													{
														$kq++;
													}
												}
												$total_extraq = $kq;
												$list1q = $this->get_emp_att_status_dept_wise($next_date,$dept_id,'OT','P','Array');if(!empty($list1q)){$xq = count($list1q);}else{$xq = 0;}
												$list2q = $this->get_emp_att_status_dept_wise($next_date,$dept_id,'OP','P','Array');if(!empty($list2q)){$yq = count($list2q);}else{$yq = 0;}
												$list3q = $this->get_emp_att_status_dept_wise($next_date,$dept_id,'HEL','P','Array');if(!empty($list3q)){$zq = count($list3q);}else{$zq = 0;}
												$all_unique_sq = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list1q,$other_dept_listq);
												$all_unique_sq = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list1q,$other_dept_listq);
												$all_unique_oq = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list2q,$other_dept_listq);
												$all_unique_hq = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list3q,$other_dept_listq);
												$unique_list_allq = array_unique(array_merge($all_unique_sq,$all_unique_oq,$all_unique_hq,$same_dept_listq));
												$total_helq = count($all_unique_hq);
												$total_opq = count($all_unique_oq);
												$total_supq = count($all_unique_sq);
												$total1q = $xq+$yq+$zq;
												*/
										?>
										<td>
											<?php 
												$list1q = $this->get_emp_att_status_dept_wise($next_date,$dept_id,'OT','P','Array');if(!empty($list1q)){$xq = count($list1q);}else{$xq = 0;}
												$list2q = $this->get_emp_att_status_dept_wise($next_date,$dept_id,'OP','P','Array');if(!empty($list2q)){$yq = count($list2q);}else{$yq = 0;}
												$list3q = $this->get_emp_att_status_dept_wise($next_date,$dept_id,'HEL','P','Array');if(!empty($list3q)){$zq = count($list3q);}else{$zq = 0;}
												
												$total1q = $xq+$yq+$zq;
												echo " $xq+$yq+$zq";
											?>
										</td>
										<td><?php echo $t1q[] = $total1q;?></td>
										<?php 
										$all_unique_sq = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list1q,$other_dept_listq);
										$all_unique_oq = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list2q,$other_dept_listq);
										$all_unique_hq = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list3q,$other_dept_listq);
										$list_margeq = array_unique(array_merge($all_unique_sq,$all_unique_oq,$all_unique_hq));
										$unique_list_all_same_deptq = $this->get_unique_id_that_not_present_in_other_dept_present_entry($same_dept_listq,$list_margeq);
										$kq=0;
										foreach($unique_list_all_same_deptq as $eq)
										{
											if($eq>0)
											{
												$kq++;
											}
										}
										$total_extraq = $kq;
										$unique_list_allq = array_unique(array_merge($all_unique_sq,$all_unique_oq,$all_unique_hq,$unique_list_all_same_deptq));
										$total_helq = count($all_unique_hq);
										$total_opq = count($all_unique_oq);
										$total_supq = count($all_unique_sq);
										
									
										?>
										<td><?php echo " $total_supq+$total_opq+$total_helq+$total_extraq";?></td>
										<td><?php echo $t2q[] = round($total_supq+$total_opq+$total_helq+$total_extraq);?></td>
										<td><?php echo $total_salaryq[] = $this->get_emp_per_day_salary_sum_form_emp_code_array($unique_list_allq,$next_date);?></td>		
										<td>
											<?php 
												$production1 = $this->Productionmodel->get_production_date_dept_wise($next_date,$next_date,$dept_id);
												if(!empty($production1)){echo $total_productionq[] = $production1[0]['qty'];}else{echo $total_productionq[] ='';}
											?>
										</td>	
									</tr>
								<?php
								$i++;
							}//foreach
							?>
							<tr style="font-weight:bold" align="center">
								<td>Total</td>
								<td></td>
								<td><?php if(!empty($t1))echo $t1 = array_sum($t1);?></td>
								<?php if($show_array == 'Yes'){?><td colspan='7'></td><?php }?>
								<td></td>
								<td><?php if(!empty($t2))echo $t2 = array_sum($t2);?></td>
								<td><?php if(!empty($total_salary))echo $total_salary2 = array_sum($total_salary);?></td>
								<?php if($show_pic == 'Yes'){?><td></td><?php }?>
								<td><?php if(!empty($total_production))echo $total_production2 = array_sum($total_production);?></td>
								<td></td>
								<td><?php if(!empty($t1q))echo $t1q = array_sum($t1q);?></td>
								<td></td>
								<td><?php if(!empty($t2q))echo $t2q = array_sum($t2q);?></td>
								<td><?php if(!empty($total_salaryq))echo $total_salary2q = array_sum($total_salaryq);?></td>
								<td><?php if(!empty($total_productionq))echo $total_production2q = array_sum($total_productionq);?></td>
							</tr>

							<?php //if($show_array == 'Yes'){?>
								<tr>
									<td colspan='11'>
										<?php if(!empty($unique_list_all2))
										{
											//$arrayMult = [ ['a','b'] , ['c', 'd'] ];
											$arraySingle = call_user_func_array('array_merge', $unique_list_all2);
											print_r($arraySingle);
											echo "<br><br>";
											echo "Total : ".count($arraySingle);
										}
										?>
									</td>

									<td colspan='9'>
										<?php 
										if(!empty($arraySingle))
										{
											$array2 = array_count_values($arraySingle);
											foreach($array2 as $q)
											{
												if($q > 1)
												{
													print_r(array_keys($array2,$q));
													echo " : ";
													echo $q;
													echo "<br>";
												}
											}
										}
										?>
									</td>

									
								</tr>
							<?php //}?>
						</tbody>
				</table>
				<br>
				<br>
				<div class="table-responsive">
					<?php
					//---monthly
					$month = $this->Base->change_date_into_month($search_date);
					$year = $this->Base->change_date_into_year($search_date);

					$from_date = date("$year-$month-01");
					$to_date = $this->Base->get_last_full_date_of_month_ymd($month,$year);
					$label = $this->Base->get_day_no_on_month($month,$year);
					?>
					<h3>Dept. wise man-power salary on daily basis</h3>
					<table border=1 id="printed_table" class="table-hover" width="100%">
						<tr align="right">
							<td>#</td>
							<?php 
								foreach($label as $l)
								{
									?><td><?php echo $l;?></td><?php 
								}
							?>
							<td>Total</td>
							<td>Production</td>
						</tr>
						<?php
						$grand_total_salary = array();
						$total_production = array();
						foreach($dept_list as $dl)
						{
							$random_name = $dl;
							$ans = $this->Base->get_dept_name_from_random_name($random_name);
							$dept_id = $ans[0];
							?>
								<tr align="right">
									<td align="left"><?php echo $random_name ;?></td>
									<?php 
										//date
										$total_salary = array();
										foreach($label as $l)
										{
											$current_date = $this->Base->change_date_ymd("$l-$month-$year");
											//echo  $this->get_emp_salary_dept_wise($current_date,$dept_id,'ALL','P','Count');
											?>
												<td>
													<?php  
														echo $total_salary[] = $this->get_emp_salary_dept_wise($current_date,$dept_id,$dl);
													?>
												</td>
											<?php 
										}
									?>
									<td><?php if(!empty($total_salary))echo $grand_total_salary[]= array_sum($total_salary);?></td>
									<td>
										<?php 
											$production = $this->Productionmodel->get_production_date_dept_wise($from_date,$to_date,$dept_id);
											if(!empty($production)){echo $total_production[] = $production[0]['qty'];}else{echo $total_production[] ='';}
										?>
									</td>	
								</tr>
							<?php 
						}//foreach
						?>
						<tr align="right">
							<td colspan='<?php echo $l+1;?>'></td>
							<td><?php if(!empty($grand_total_salary))echo array_sum($grand_total_salary);?></td>
							<td><?php if(!empty($total_production))echo $total_production2 = array_sum($total_production);?></td>
						</tr>
						
						
					</table>
				</div>


				<br>
				<br>
				<div class="table-responsive">
					<?php
					//---monthly
					$month = $this->Base->change_date_into_month($search_date);
					$year = $this->Base->change_date_into_year($search_date);

					?>
					<h3>Actual Salary</h3>
					<table border=1 id="printed_table" width="20%" class="table-hover">
						<tr align="right" style="font-weight:bold">
							<td align="left" >Dept.</td>
							<td>Salary</td>
						</tr>
						<?php
						$grand_total_salary2 = array();
						foreach($dept_list as $l)
						{
							$random_name = $l;
							$ans = $this->Base->get_dept_name_from_random_name($random_name);
							$dept_id = $ans[0];
							?>
								<tr align="right">
									<td align="left"><?php echo $random_name ;?></td>
									<td>
									<?php 
										//salary
										$sal = $this->get_emp_actual_salary_dept_wise($dept_id,$year,$month);
										if(!empty($sal[0]['without_did'])){echo $grand_total_salary2[] = $sal[0]['without_did'];}else{echo 0;}
									?>
									</td>
								</tr>
							<?php 
						}//foreach
						?>
						<tr align="right" style="font-weight:bold">
							<td>Total</td>
							<td><?php if(!empty($grand_total_salary2))echo array_sum($grand_total_salary2);?></td>
						</tr>
						
						
					</table>
				</div>
				
				
				<?php 
	}//function close


	
		
	//get day & dept wise attendance salary
	public function get_salary_day_dept_wise($search_date,$showId)
	{
		$company_id = $this->session->userdata('company_id');
		// $showId = "No";
		$timestamp = strtotime($search_date); 

		$month = date("m", $timestamp); 
		$year  = date("Y", $timestamp); 
		$fdate = date("Y-m-d", strtotime("$year-$month-01"));
		$tdate = date("Y-m-t", strtotime("$year-$month-01"));

		$query = " SELECT 
					E.emp_code,
					E.department_id,D.name as department_name,
					A.total_present,A.current_total_ctc_payable as payable_salary,
					(A.current_total_ctc_payable/A.total_present) as per_day_salary,
					D1,D2,D3,D4,D5,D6,D7,D8,D9,D10,D11,D12,D13,D14,D15,D16,D17,D18,D19,D20,D21,D22,D23,D24,D25,D26,D27,D28,D29,D30,D31,
					A.att_year,A.att_month
					
					

					FROM daily_attendance_monthly as A
					LEFT JOIN employee E ON A.emp_code=E.id
					LEFT JOIN department D ON E.department_id=D.department_id
					where A.att_year ='$year' and A.att_month='$month' and A.company_id='$company_id' ";
		$att = $this->Mymodel->query1($query);
		//print_r($att);
		//echo "<br><br><br>";



		
		$query = " SELECT department_id,name FROM department ";
		$dept_list = $this->Mymodel->query1($query);
		//print_r($dept_list);
		$deptMap = [];
		foreach ($dept_list as $dept) {
			if (isset($dept['department_id']) && isset($dept['name'])) {
				$deptMap[$dept['department_id']] = $dept['name'];
			}
		}
		
		//print_r($deptMap);
		//echo "<br><br><br>";

		

		// Sample input array (replace this with your actual data)
		$attendanceData = $att;

		// Define the month and year
		$month = $attendanceData[0]['att_month'];
		$year = $attendanceData[0]['att_year'];

		// Initialize day-wise result
		$dayWise = [];

		// Loop through days D1 to D31
		for ($day = 1; $day <= 31; $day++) {
			$dayKey = 'D' . $day;
			$date = str_pad($day, 2, '0', STR_PAD_LEFT) . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . $year;
			$dayWise[$date] = [];

			// Loop through each employee
			foreach ($attendanceData as $emp) {
				$status = isset($emp[$dayKey]) ? strtoupper($emp[$dayKey]) : '';
				if (in_array($status, ['P', 'S', 'R'])) {
					$dayWise[$date][] = [
						'emp_code' => $emp['emp_code'],
						'dept_id' => $emp['department_id'],
						'department_name' => $emp['department_name'],
						'perDaySalary' => $emp['per_day_salary'],
					];
				}
			}
		}

		//print_r($dayWise);
		//echo "<br><br><br>";

		//dept wise 
		$query = " SELECT 
					attendance_date as date, dept_name as dept_id,emp_list
					FROM daily_attendance_dept_wise as A
					WHERE A.company_id='$company_id' and attendance_date between '$fdate' and '$tdate' ";
		$deptAtt = $this->Mymodel->query1($query);
		
		

		$data1 = $dayWise;
		$data2 = $deptAtt;
		// print_r($data1);
		// echo "<br><br><br>";
		// print_r($data2);
		// echo "<br><br><br>";
		

		// Step 1: Prepare date list (1 to 31 of June 2025)
		// Step 1: Prepare date list for July 2025
		$dates = [];
		for ($d = 1; $d <= 31; $d++) {
			$dates[] = str_pad($d, 2, '0', STR_PAD_LEFT) . "-07-2025";
		}

		// Step 2: Build override mapping from data2
		$overrides = [];
		foreach ($data2 as $row) {
			$dateKey = date('d-m-Y', strtotime($row['date']));
			$empList = explode(',', $row['emp_list']);
			foreach ($empList as $emp) {
				$overrides[$dateKey][trim($emp)] = $row['dept_id'];
			}
		}

		// Step 3: Build final dataset
		$final = [];
		$dayTotals = array_fill(1, 31, 0);

		foreach ($data1 as $date => $records) {
			if (empty($records)) continue; // skip days without attendance
			
			foreach ($records as $rec) {
				$deptId = $rec['dept_id'];
				$salary = round($rec['perDaySalary']);
				$empCode = $rec['emp_code'];
				
				if (!isset($final[$deptId][$date])) {
					$final[$deptId][$date] = [
						'employees' => [],
						'total' => 0
					];
				}
				
				$final[$deptId][$date]['employees'][] = "{$empCode} ({$salary})";
				$final[$deptId][$date]['total'] += $salary;
				
				// track totals per day
				$dayNumber = (int) date('d', strtotime($date));
				$dayTotals[$dayNumber] += $salary;
				
				// track dept grand total
				if (!isset($final[$deptId]['grand_total'])) {
					$final[$deptId]['grand_total'] = 0;
				}
				$final[$deptId]['grand_total'] += $salary;
			}
		}
		//print_r($final);

		// Get month/year from search date
		list($month, $year) = explode('-', date('m-Y', strtotime($search_date)));

		// Step 4: Show table
		echo "<table border='1' cellpadding='5' cellspacing='0'>";
		echo "<tr><th>S.No</th><th>Dept</th>";
		for ($d = 1; $d <= 31; $d++) {
			echo "<th>Day $d</th>";
		}
		echo "<th>Total</th></tr>";

		$sno = 1;
		foreach ($final as $deptId => $days) {
			if (!is_numeric($deptId)) continue;
			echo "<tr>";
			echo "<td>{$sno}</td>";
			echo "<td>{$deptMap[$deptId]} : {$deptId}</td>";
			for ($d = 1; $d <= 31; $d++) {
				$date = str_pad($d, 2, '0', STR_PAD_LEFT) . "-{$month}-{$year}";
				if (isset($days[$date])) {
					$empStr = implode(', ', $days[$date]['employees']);
					$total  = round($days[$date]['total']);
					if ($showId == "Yes") {
						echo "<td>{$empStr} | Total: {$total}</td>";
					} else {
						echo "<td>{$total}</td>";
					}
				} else {
					echo "<td></td>";
				}
			}
			$deptTotal = round($days['grand_total'] ?? 0);
			echo "<td><b>{$deptTotal}</b></td>";
			echo "</tr>";
			$sno++;
		}

		// Step 5: Grand Total Row
		echo "<tr style='font-weight:bold; background:#f0f0f0;'>";
		echo "<td colspan='2'>Grand Total</td>";
		$monthTotal = 0;
		for ($d = 1; $d <= 31; $d++) {
			$dayTotal = round($dayTotals[$d]);
			echo "<td>{$dayTotal}</td>";
			$monthTotal += $dayTotal;
		}
		echo "<td>" . round($monthTotal) . "</td>";
		echo "</tr>";

		echo "</table>";

	}//function close



	//---------------------------------------------------------------------------get dept wise emp salary on date
	public function get_emp_salary_dept_wise($search_date,$dept_id,$dept_name)
	{
		$other_dept_list = $this->daily_attendance_dept_wise_all_list($search_date,'No',$dept_name);
		$same_dept_list = $this->daily_attendance_dept_wise_all_list($search_date,'Yes',$dept_name);

		$list4 = $this->get_emp_att_status_dept_wise($search_date,$dept_id,'','P/S/R','Array');if(!empty($list3 )){$z = count($list3);}else{$z = 0;}
		$all_unique = $this->get_unique_id_that_not_present_in_other_dept_present_entry($list4,$other_dept_list);
		$unique_list_all = array_unique(array_merge($all_unique,$same_dept_list));
		//print_r($same_dept_list);
		return  $this->get_emp_per_day_salary_sum_form_emp_code_array($unique_list_all,$search_date);
	}//function close



	//---------------------------------------------------------------------------get dept wise emp salary on date
	public function get_emp_actual_salary_dept_wise($dept_id,$year,$month)
	{
		$company_id = $this->session->userdata('company_id');
		$query="
			SELECT 
			D.name as dname,A.company_role_id, sum(A.total_present) as total_present, sum(A.total_ot) as total_ot,sum(A.esic_payable) as esic_payable,
			sum(A.epf_payable) as epf_payable,sum(A.current_total_ctc_payable) as payable_amt,sum(A.current_ctc_payable) as without_did
			
			FROM daily_attendance_monthly as A
			
			LEFT JOIN employee E ON A.emp_code=E.id
			LEFT JOIN department D ON E.department_id=D.department_id
			
			WHERE  A.company_id='$company_id' and E.department_id in ($dept_id) and   A.att_year='$year' and A.att_month='$month'  GROUP BY E.department_id   ";
		return $res2 = $this->Mymodel->query1($query);
	}//function close
	
	
	
	
	
	










    //-----------------------------------------------------------------------Leave
    //Leave data with id 
    public function get_leave_data_with_id($id)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="  SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,E.present_address,E.permanent_address,E.doj,E.last_org
                FROM emp_leave as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                WHERE A.id ='$id' and A.company_id='$company_id'
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//leave search 
    public function get_all_leave_with_search($search)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM emp_leave as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
               	WHERE 1=1  and A.company_id='$company_id' and E.company_id='$company_id'  $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



	public function get_leave_history_emp_code($emp_code)
	{
		$company_id = $this->session->userdata('company_id');
        $today = date('Y-m-d');
		$from_date = $this->Base->get_choise_gap_ymd($today,"-1 Year");
		$to_date = $this->Base->get_choise_gap_ymd($today,"+1 Year");
		$sql="  SELECT A.*,E.id as empid
				FROM emp_leave as A 
				LEFT JOIN employee as E ON A.emp_code = E.emp_code
				WHERE A.company_id='$company_id' and E.company_id='$company_id' and A.emp_code ='$emp_code' and A.status != '' and A.ask_from_date between '$from_date' and '$to_date' ORDER BY A.ask_from_date DESC 
				";
        $query = $this->db->query($sql);
        return $out2 =  $query->result_array();
	}//function close

	public function get_leave_history_emp_code_date($emp_code,$from_date,$to_date)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="  SELECT A.*,E.first_name,E.last_name,E.father_name,E.mob,D.name as dname
				FROM emp_leave as A 
				LEFT JOIN employee as E ON A.emp_code = E.emp_code
				LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE A.company_id='$company_id' and A.emp_code ='$emp_code'  and A.ask_from_date between '$from_date' and '$to_date' ORDER BY A.ask_from_date DESC 
				";
        $query = $this->db->query($sql);
        return $out2 =  $query->result_array();
	}//function close

	
	public function get_dashboard_leave()
	{
		$company_id = $this->session->userdata('company_id');
        $sql="  SELECT A.*,E.first_name,E.last_name,E.father_name,E.mob,D.name as dname
                FROM emp_leave as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE A.company_id='$company_id' and A.status = ''  ORDER BY A.ask_from_date DESC ";
        $query = $this->db->query($sql);
        return $out2 =  $query->result_array();
	}//function close

	

	// attendance function 2
	function date_wise_leave($year,$emp_code)
    {
		$nextYear = $year+1;
		$fdate = date("$year-01-01");
		$tdate = date("$nextYear-03-31");
		$data = $this->get_leave_history_emp_code_date($emp_code,$fdate,$tdate);
		if(!empty($data))$this->Hrmodel->get_leave_history_emp_code_table($data,1);
	}//function close

	public function get_leave_history_emp_code_table($data,$dashboard)
	{
       if(!empty($data)){
		?>
 			<div class="table-responsive">
				<h5>Leave List</h5>
				<table class="table table-bordered table-striped table-sm">
					<thead>
						<tr>
							<th scope="col">#</th>
							<?php if(!empty($dashboard)){?> 
								<th scope="col">Name</th> 
								<th scope="col">Dept</th> 
								<th scope="col">Mobile</th> 
							<?php }?>
							
							
							<th scope="col">Reason</th>
							

							<?php if(!empty($dashboard)){?> 
								<th scope="col">From Date</th>
								<th scope="col">To Date</th>
								<th scope="col">Total Day's <br> Aprrove By head</th>
								<?php if($this->Company->checkPermission3("Hr/leave_edit")){?> <th scope="col">Edit</th><?php }?>
							<?php }else{?>
								<th scope="col">Ask From-To </th>
								<th scope="col">Approve From-To</th>
								<th scope="col">Status</th>
								<th scope="col">Next Present</th>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						
						<?php 
						$i=1;
						foreach($data as $r)
						{
							 if(!empty($r['ask_from_date']) and $r['ask_from_date']!='0000-00-00'){$ask_from_date=$this->Base->change_date_dmy($r['ask_from_date']);}else{$ask_from_date='';}
							if(!empty($r['ask_to_date']) and $r['ask_to_date']!='0000-00-00'){$ask_to_date=$this->Base->change_date_dmy($r['ask_to_date']);}else{$ask_to_date='';}
							if(!empty($r['approve_from_date']) and $r['approve_from_date']!='0000-00-00'){$approve_from_date=$this->Base->change_date_dmy($r['approve_from_date']);}else{$approve_from_date='';}
							if(!empty($r['approve_to_date']) and $r['approve_to_date']!='0000-00-00'){$approve_to_date=$this->Base->change_date_dmy($r['approve_to_date']);}else{$approve_to_date='';}
							?>
								<tr>
									<th scope="row"><?php echo $i;?></th>
									
									<?php if(!empty($dashboard)){?> 
										<td><?php echo $r['first_name'].' '.$r['last_name']?></td>
										<td><?php echo $r['dname']?></td>
										<td><?php echo $r['mob']?></td>
									<?php }?>
									
									
									<td><?php echo $r['reason_for']?></td>

									<?php if(!empty($dashboard)){?> 
										<td><?php echo $ask_from_date; ?></td>
										<td><?php echo $ask_to_date; ?></td>
										<td>
											<span style="font-size:12px" class="badge badge-light"><?php echo $ask_total_days_list[] = $r['ask_total_days']?></span>
											<?php  if(isset($r['sign_supervisor'])){if($r['sign_supervisor']=='Approve'){?><span class="badge badge-success">Approve</span> <?php }}?>
											<?php  if(isset($r['sign_supervisor'])){if($r['sign_supervisor']=='Reject'){?><span class="badge badge-danger">Reject</span> <?php }}?>
										</td>
										<?php if($this->Company->checkPermission3("Hr/leave_edit") and $r['status'] ==''){?> 
											 <td>
												<a  href="<?php base_url()?>home?Hr/add_leave/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
													<i class="nav-icon i-Pen-2"></i>
												</a>
											</td>
										<?php }?>

										
									<?php }else{?>
											<td>
												<?php echo $ask_from_date; ?>
												<br>
												<?php echo $ask_to_date; ?>
												<span style="font-size:12px" class="badge badge-info"><?php echo $ask_total_days_list[] = $r['ask_total_days']?></span>
											</td>

											<td>
												<?php echo $approve_from_date; ?>
												<br>
												<?php echo $approve_to_date; ?>
												<span style="font-size:12px" class="badge badge-info"><?php if($r['approve_total_days']>0)echo $approve_total_days_list[] = $r['approve_total_days']?></span>
											</td>

											<td>
												<?php  if(isset($r['status'])){if($r['status']=='Approve'){?><span class="badge badge-success">Approve</span> <?php }}?>
												<?php  if(isset($r['status'])){if($r['status']=='Reject'){?><span class="badge badge-danger">Reject</span> <?php }}?>
											</td>   
											<td>
												<?php 
													//getting next pesent day 
													if(isset($r['empid'])){
														if(!empty($approve_to_date)){
															$send_date = $approve_to_date;
														}else{
															$send_date = $ask_to_date;
														}
														$this->Hrmodel->get_first_P_after_leave_ask_date($r['empid'],$send_date);
													} 
												?>
											</td>  
									<?php }?>



									
								</tr>
							<?php 
							$i++;
						}
						?>

						<?php 
						//$loginId =$this->session->userdata('login_emp_id');
						//if($loginId == 1 && empty($dashboard)){
						if(empty($dashboard)){
						?> 
							<tr style="font-weight: bold;">
								<td colspan="2"></td>	
								<td>Total Ask  : <?php if(!empty($ask_total_days_list))echo array_sum($ask_total_days_list);?> Day's</td>
								<td>Total Approve  : <?php if(!empty($approve_total_days_list))echo array_sum($approve_total_days_list);?> Day's</td>
								<td colspan="2"></td>	
							</tr>
						<?php }?>

						
						
					</tbody>
				</table>
			</div>
		<?php
		}//data
	}//function close



	//-----------------------------------------------------------------------Advance
    public function get_advance_data_with_id($id)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="  SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,E.present_address,E.permanent_address,E.doj,E.last_org
                FROM emp_advance as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                WHERE A.id ='$id' and A.company_id='$company_id'
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	public function get_loan_data_with_id($id)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="  SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,E.present_address,E.permanent_address,E.doj,E.last_org
                FROM employee_loan as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                WHERE A.loan_id ='$id' and A.company_id='$company_id'
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//total advance Amount 
    public function get_total_advance_amt_of_emp($fdate,$tdate,$emp_code)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT 
					sum(A.approve_amount) as total_amt
				FROM emp_advance as A 
                WHERE A.emp_code='$emp_code' and A.company_id='$company_id' and  A.ask_date between '$fdate' and '$tdate'   GROUP BY A.emp_code 
             ";
		$query = $this->db->query($sql);
        $res2 = $query->result_array();
		//print_r($res2);
		if(!empty($res2)){
			return round($res2[0]['total_amt']);
		}
    }//function close

	//total tds Amount 
    public function get_total_tds_amt_of_emp($fdate,$tdate,$emp_code)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT 
					sum(A.amount) as total_amt
				FROM emp_tds as A 
                WHERE A.emp_code='$emp_code' and A.company_id='$company_id' and   A.entry_date between '$fdate' and '$tdate'   GROUP BY A.emp_code 
             ";
		$query = $this->db->query($sql);
        $res2 = $query->result_array();
		//print_r($res2);
		if(!empty($res2)){
			return round($res2[0]['total_amt']);
		}
    }//function close

	//advance search 
    public function get_all_advance_with_search($search)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM emp_advance as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
               	WHERE 1=1  and A.company_id='$company_id' and E.company_id='$company_id' $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	public function get_advance_history_emp_code($emp_code)
	{
		$company_id = $this->session->userdata('company_id');
        $today = date('Y-m-d');
		$from_date = $this->Base->get_choise_gap_ymd($today,"-1 Year");
		$sql="  SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,E.doj,D.name as dname
                FROM emp_advance as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE A.emp_code ='$emp_code' and A.company_id='$company_id' and E.company_id='$company_id' and A.status != '' and A.ask_date between '$from_date' and '$today' ORDER BY A.ask_date  
				";
        $query = $this->db->query($sql);
        return $out2 =  $query->result_array();
	}//function close

	public function get_dashboard_advance($days)
	{
		$company_id = $this->session->userdata('company_id');
        $today = date('Y-m-d');
		$from_date = $this->Base->get_choise_gap_ymd($today,"$days day");
		$sql="  SELECT A.*,E.id as empid,E.emp_code,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM emp_advance as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE A.company_id='$company_id' and E.company_id='$company_id' and A.ask_date between '$from_date' and '$today' ORDER BY A.ask_date DESC ";
        $query = $this->db->query($sql);
        return $out2 =  $query->result_array();
	}//function close

	public function get_advance_empCode_date($emp_code,$fdate,$tdate)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="  SELECT A.*,E.id as empid,E.emp_code,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM emp_advance as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE A.emp_code = '$emp_code' and A.company_id='$company_id' and E.company_id='$company_id' and A.ask_date between '$fdate' and '$tdate' ORDER BY A.ask_date  ";
        $query = $this->db->query($sql);
        return $out2 =  $query->result_array();
	}//function close

	// attendance function 2
	function date_wise_advance($year,$emp_code)
    {
		$company_id = $this->session->userdata('company_id');
		$nextYear = $year+1;
		$fdate = date("$year-01-01");
		$tdate = date("$nextYear-03-31");
		$data = $this->get_advance_empCode_date($emp_code,$fdate,$tdate);
		if(!empty($data))$this->Hrmodel->get_advance_history_emp_code_table($data,1);
	}//function close

	//total fine Amount 
    public function get_total_fine_amt_of_emp($fdate,$tdate,$emp_code)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT 
					sum(A.amount) as amount
				FROM emp_other_application as A 
                WHERE A.emp_code='$emp_code' and A.company_id='$company_id' and  A.entry_date between '$fdate' and '$tdate'   GROUP BY A.emp_code 
             ";
		$query = $this->db->query($sql);
        $res2 = $query->result_array();
		//print_r($res2);
		if(!empty($res2)){
			return round($res2[0]['amount']);
		}
    }//function close

	//other application
	public function get_other_application_with_id($id)
	{
		$company_id = $this->session->userdata('company_id');
         $sql="  SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,E.doj,D.name as dname
                FROM emp_other_application as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE A.id = '$id' and A.company_id='$company_id' and E.company_id='$company_id'
				";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//other application
	public function get_emp_tds_id($id)
	{
		$company_id = $this->session->userdata('company_id');
         $sql="  SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,E.doj,D.name as dname
                FROM emp_tds as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE A.id = '$id' and A.company_id='$company_id' and E.company_id='$company_id'
				";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	public function get_emp_reim_id($id)
	{
		$company_id = $this->session->userdata('company_id');
         $sql="  SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,E.doj,D.name as dname
                FROM emp_reimbursement_master as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE A.id = '$id' and A.company_id='$company_id' and E.company_id='$company_id'
				";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	public function get_other_application_emp_code_type($emp_code,$type)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="  SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,E.doj,D.name as dname
                FROM emp_other_application as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE A.company_id='$company_id' and E.company_id='$company_id' and A.emp_code ='$emp_code' and type='$type' ORDER BY A.entry_date  
				";
        $query = $this->db->query($sql);
        return $out2 =  $query->result_array();
	}//function close

	//Other application search 
    public function get_all_other_appli_with_search($search)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM emp_other_application as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
               	WHERE 1=1 and A.company_id='$company_id' and E.company_id='$company_id' $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


	public function get_emp_tds_with_search($search)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM emp_tds as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
               	WHERE 1=1 and A.company_id='$company_id' and E.company_id='$company_id' $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	public function get_emp_reim_with_search($search)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM emp_reimbursement_master as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
               	WHERE 1=1 and A.company_id='$company_id' and E.company_id='$company_id' $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	

	public function get_dashboard_other_application($emp_code,$type)
	{
		$company_id = $this->session->userdata('company_id');
        if($type=='All'){
			$searchType= "";
		}elseif($type=='Others'){
			$searchType= " and (A.type !='Gatepass' and A.type !='Fine' and A.type !='Medical' and A.type !='MEMO') ";
		}else{
			$searchType= " and A.type='$type'";
		}

		if($emp_code == "All"){
			$searchEmp = "";
		}else{
			$searchEmp = " and A.emp_code = '$emp_code' ";
		}

		$today = date('Y-m-d');
		$from_date = $this->Base->get_choise_gap_ymd($today,"-35 day");
		$sql="  SELECT A.*,E.id as empid,E.emp_code,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM emp_other_application as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE 1=1 and A.company_id='$company_id' and E.company_id='$company_id' $searchType $searchEmp and  A.entry_date between '$from_date' and '$today' ORDER BY A.entry_date  ";
        $query = $this->db->query($sql);
        return $out2 =  $query->result_array();
	}//function close


	public function get_dashboard_other_application_with_date($emp_code,$type,$fdate,$tdate)
	{
		$company_id = $this->session->userdata('company_id');
        if($type=='All'){
			$searchType= "";
		}elseif($type=='Others'){
			$searchType= " and (A.type !='Gatepass' and A.type !='Fine' and A.type !='Medical' and A.type !='MEMO') ";
		}else{
			$searchType= " and A.type='$type'";
		}

		if($emp_code == "All"){
			$searchEmp = "";
		}else{
			$searchEmp = " and A.emp_code = '$emp_code' ";
		}

		$sql="  SELECT A.*,E.id as empid,E.emp_code,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM emp_other_application as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
				WHERE 1=1 and A.company_id='$company_id' and E.company_id='$company_id'  $searchType $searchEmp and  A.entry_date between '$fdate' and '$tdate' ORDER BY A.entry_date  ";
        $query = $this->db->query($sql);
        return $out2 =  $query->result_array();
	}//function close

	// attendance function 2
	function date_wise_other_application_details($year,$emp_code,$type)
    {
		$nextYear = $year+1;
		$fdate = date("$year-01-01");
		$tdate = date("$nextYear-03-31");
		$data = $this->get_dashboard_other_application_with_date($emp_code,$type,$fdate,$tdate);
		if(!empty($data))$this->Hrmodel->get_other_appli_history_emp_code_table($data,1,$type);
	}//function close



	// get dashbord function
	function get_dashbord_to_display_all_table($advacedata,$leavedata,$otherdata)
    {
		
		// Step 1: Add "type" for Advance & Leave
		foreach ($advacedata as &$a) {
			$a['type'] = 'Advance';
		}
		foreach ($leavedata as &$l) {
			$l['type'] = 'Leave';
		}

		// Step 2: Merge all arrays
		$allData = array_merge($advacedata, $leavedata, $otherdata);
		


		// Step 3: Find all unique types
		$allTypes = [];
		foreach ($allData as $row) {
			$allTypes[$row['type']] = true;
		}
		$allTypes = array_keys($allTypes); // unique type list

		// Step 4: Group and sum
		$report = [];
		foreach ($allData as $row) {
			$code = $row['emp_code'];
			if (!isset($report[$code])) {
				$report[$code] = [
					'emp_code' => $code,
					'name'     => trim($row['first_name'] . ' ' . $row['last_name']),
					'dname'    => $row['dname']
				];
				foreach ($allTypes as $t) {
					$report[$code][$t] = ['count' => 0, 'amount' => 0];
				}
			}

			$amount = 0;
			if ($row['type'] === 'Advance' && isset($row['approve_amount'])) {
				$amount = (float)$row['approve_amount'];
			} elseif (isset($row['amount']) && $row['amount'] !== '') {
				$amount = (float)$row['amount'];
			}

			$report[$code][$row['type']]['count']++;
			$report[$code][$row['type']]['amount'] += $amount;
		}
		//print_r($report);
		?>
			<!-- Step 5: Output -->
			<table class="table table-bordered table-striped table-sm">
				<tr>
					<th>S.No</th>
					<th>Code</th>
					<th>Name</th>
					<th>Department</th>
					<?php foreach ($allTypes as $type): ?>
						<th><?= htmlspecialchars($type) ?> Appl.</th>
					<?php endforeach; ?>
				</tr>

				<?php $sno = 1; ?>
				<?php foreach ($report as $r): ?>
					<tr>
						<td><?= $sno ?></td>
						<td><?= htmlspecialchars($r['emp_code']) ?></td>
						<td><?= htmlspecialchars($r['name']) ?></td>
						<td><?= htmlspecialchars($r['dname']) ?></td>

						<?php foreach ($allTypes as $type): ?>
							<?php
								$count  = $r[$type]['count'] > 0 ? $r[$type]['count'] : '';
								$amount = $r[$type]['amount'] > 0 ? "(" . $r[$type]['amount'] . ")" : "";
							?>
							<td title="<?= $type ?>"><?= $count ?> <?= $amount ?></td>
						<?php endforeach; ?>
					</tr>
					<?php $sno++; ?>
				<?php endforeach; ?>
			</table>

		<?php
	}//function close

	function get_dashbord_to_display_all_diff_table_html()
    {
		?>
  				<!--  Advance -->
				<div class="card text-left" style="margin-top:30px">
					<div class="card-body">
							<div class="table-responsive">
								<?php 
								$type="Gatepass";
								$data = $this->Hrmodel->get_dashboard_other_application("All",$type);
								if(!empty($data))$this->Hrmodel->get_other_appli_history_emp_code_table($data,1,$type);
								?>
							</div>

							<div class="table-responsive">
								<?php 
								$type="Fine";
								$data = $this->Hrmodel->get_dashboard_other_application("All",$type);
								if(!empty($data))$this->Hrmodel->get_other_appli_history_emp_code_table($data,1,$type);
								?>
							</div>

							<div class="table-responsive">
								<?php 
								$type="Medical";
								$data = $this->Hrmodel->get_dashboard_other_application("All",$type);
								if(!empty($data))$this->Hrmodel->get_other_appli_history_emp_code_table($data,1,$type);
								?>
							</div>

							<div class="table-responsive">
								<?php 
								$type="MEMO";
								$data = $this->Hrmodel->get_dashboard_other_application("All",$type);
								if(!empty($data))$this->Hrmodel->get_other_appli_history_emp_code_table($data,1,$type);
								?>
							</div>

							<div class="table-responsive">
								<?php 
								$type="Others";
								$data = $this->Hrmodel->get_dashboard_other_application("All",$type);
								if(!empty($data))$this->Hrmodel->get_other_appli_history_emp_code_table($data,1,$type);
								?>
							</div>
					</div>
				</div>
				</div>
				<!--  end of col -->

		<?php
	}//function close

	public function get_advance_history_emp_code_table($data,$dashboard)
	{
       if(!empty($data)){
		$att = $this->Hrmodel->get_all_emp_code_from_salary_list(date("Y"),date("m"));
		?>
 			<div class="table-responsive">
				<h5>Advance List</h5>
				<table class="table table-bordered table-striped table-sm ">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th>Date</th>
							<?php if(!empty($dashboard)){?> 
								<th scope="col">Name</th> 
								<th scope="col">Dept</th> 
								<th scope="col">Mobile</th> 
							<?php }?>
							
							<th>Ask Amount (Rs.)</th>
							<th>Reason</th>
							<th>Approve Amount (Rs.)</th>
							<th>Status</th>
							<th>Payment Type</th>
							<th>Remarks</th>
						</tr>
					</thead>
					<tbody>
						
						<?php 
						$i=1;
						foreach($data as $r)
						{
							if(!empty($r['ask_date']) and $r['ask_date']!='0000-00-00'){$ask_date=$this->Base->change_date_dmy($r['ask_date']);}else{$ask_date='';}
							// Check if emp_code is in the pay_code list
                    		$color = in_array($r['emp_code'], $att) ? '' : 'style="color:red;"';  
							?>
								<tr>
									<th scope="row"><?php echo $i;?></th>
									
									 <td><?php echo $ask_date; ?></td>
									<?php if(!empty($dashboard)){?> 
										<td <?php echo $color;?>><?php echo $r['first_name'].' '.$r['last_name']?> <br>(<?php echo $r['emp_code']?>)</td>
										<td><?php echo $r['dname']?></td>
										<td><?php echo $r['mob']?></td>
									<?php }?>
									
									
									
									<td><?php echo $total_ask_amount[] = $r['ask_amount']?></td>
									<td><?php echo $r['reason_for']?></td>
									<td style="color:green"><?php echo $total_approve_amount[] = $r['approve_amount']?></td>
									<td>
										<?php  if(isset($r['status'])){if($r['status']=='Approve'){?><span class="badge badge-success">Approve</span> <?php }}?>
										<?php  if(isset($r['status'])){if($r['status']=='Reject'){?><span class="badge badge-danger">Reject</span> <?php }}?>
									</td> 
									<td><?php echo $r['payment_type']?></td>
									<td><?php echo $r['remarks']?></td>
								</tr>
							<?php 
							$i++;
						}
						?>

						

						<?php 
						//$loginId =$this->session->userdata('login_emp_id');
						//if($loginId == 1 && empty($dashboard)){
						if(empty($dashboard)){
						?> 
							<tr style="font-weight: bold;">
								<td colspan="2"></td>	
								<td><?php if(!empty($total_ask_amount))echo array_sum($total_ask_amount);?> Rs.</td>
								<td ></td>	
								<td style="color:green"><?php if(!empty($total_approve_amount))echo array_sum($total_approve_amount);?> Rs.</td>
								<td colspan="4"></td>
							</tr>
						<?php }?>

						
						
					</tbody>
				</table>
			</div>
		<?php
		}//data
	}//function close



	public function get_other_appli_history_emp_code_table($data,$dashboard,$type)
	{
       
		if(!empty($data)){
		//$att = $this->Hrmodel->get_all_emp_code_from_salary_list(date("Y"),date("m"));
		$att = array();
		?>
 			<div class="table-responsive">
				<h5><?php echo $type;?> History</h5>
				<table class="table table-bordered table-striped table-sm ">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th>Date</th>
							<?php if(!empty($dashboard)){?> 
								<th style="color:blue">Type</th>	
								<th scope="col">Name</th> 
								<th scope="col">Dept</th> 
								<th scope="col">Mobile</th> 
								
							<?php }?>
							

							<?php if(!empty($type) && $type == 'Medical'){ ?> 
								<th>Time</th>
								<th>Type</th>
								<th>Nature</th>
								<th>Location</th>
								<th>Action</th>
								<th>Amount</th>
							<?php }elseif(!empty($type) && $type == 'Gatepass'){?>
								<th>Work Type</th>
								<th>Time Out</th>
								<th>Duty Off ?</th>
								<th>Time In</th>
							<?php }elseif(!empty($type) && $type == 'Fine'){?>
								<th>Subject</th>
								<th>Action</th>
								<th>Amount</th>
							<?php }else{?>
								<th>Subject</th>
								<th>Action</th>
							<?php }?>
							
						</tr>
					</thead>
					<tbody>
						
						<?php 
						$i=1;
						foreach($data as $r)
						{
							if(!empty($r['entry_date']) and $r['entry_date']!='0000-00-00'){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
							if(!empty($r['entry_time']) and $r['entry_time']!='00:00:00'){$entry_time=$this->Base->change_time_His($r['entry_time']);}else{$entry_time='';}
							if(!empty($r['time_out']) and $r['time_out']!='00:00:00'){$time_out=$this->Base->change_time_His($r['time_out']);}else{$time_out='';}
							if(!empty($r['time_in']) and $r['time_in']!='00:00:00'){$time_in=$this->Base->change_time_His($r['time_in']);}else{$time_in='';}
							// Check if emp_code is in the pay_code list
                    		//$color = in_array($r['emp_code'], $att) ? '' : 'style="color:red;"';  
							$color="";
							?>
								<tr>
									<th scope="row"><?php echo $i;?></th>
									
									<td><?php echo $entry_date; ?></td>
									<?php if(!empty($dashboard)){?> 
										<td style="font-weight:bolder"><?php echo $r['type']?></td>
										<td <?php echo $color;?>><?php echo $r['first_name'].' '.$r['last_name']?> <br>(<?php echo $r['emp_code']?>)</td>
										<td><?php echo $r['dname']?></td>
										<td><?php echo $r['mob']?></td>
										
									<?php }?>

									
									
									<?php if(!empty($type) && $type == 'Medical'){?> 
										<td><?php echo $entry_time; ?></td>
										<td><?php echo $r['accident_type']?></td>
										<td><?php echo $r['accident_nature']?></td>
										<td><?php echo $r['location']?></td>
										<td><?php echo $r['accident_action']?></td>
										<td style="color:green"><?php echo $amount[] = $r['amount']?></td>

									<?php }elseif(!empty($type) && $type == 'Gatepass'){?>
										<td><?php echo $r['work_type']?></td>
										<td><?php echo $time_out; ?></td>
										<td><?php echo $r['duty_off']?></td>
										<td><?php echo $time_in; ?></td>
										
									<?php }elseif(!empty($type) && $type == 'Fine'){?>
										<td><?php echo $r['subject']?></td>
										<td><?php echo $r['action']?></td>
										<td style="color:green"><?php echo $amount[] = $r['amount']?></td>

									<?php }else{?>
										<td><?php echo $r['subject']?></td>
										<td><?php echo $r['action']?></td>
									<?php }?>
									
										
								</tr>
							<?php 
							$i++;
						}
						?>

						
					</tbody>
				</table>
			</div>
		<?php
		}//data
	}//function close













	

	// attendance function 1
	function date_wise_attendance($year,$emp_code)
    {
		$company_id = $this->session->userdata('company_id');
		$query = " SELECT id,first_name,last_name FROM employee WHERE emp_code = '$emp_code' and company_id='$company_id' ";
		$out=$this->Mymodel->query1($query);
		?>       
                 <div class="col-md-12">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <!-- <h3 class="panel-title">
                                    	<?php echo $out[0]['first_name'].' '.$out[0]['last_name'];?> your daily attendance reports - <?php echo $year;?>
                                    </h3> -->
                                   
                                </div>
                                <div class="panel-body">
								<div class="table-responsive" style="margin-top:10px;">
									<p>
										P : Present, L : Leave,  A : Absent, H : Holiday, S : Sunday, R : Rest, HA : Halfday,
										HL : Halfday+Leave, SL : Sick Leave, CL : Casual Leave, EL : Emergency Leave, OL : Other Leave, 
									</p>
									<br>
										<table  border="1" width="100%">
											<tr>
												<th>Month / Date</th>
												<?php 
													for($i=1;$i<=31;$i++)
													{
													?>
														<th><?php if($i<10){echo "0";}echo $i;?></th>
													<?php 
													}
												?>
												<th>Month Days</th>
												<th>Total Sunday</th>
												<th>Total Holiday</th>
												
												
												<th>Present</th>
												<th>Rest</th>
												<th>Total Present</th>
												<th>Leave</th>
												<th>Absent</th>
												<th>Total L+A</th>
												<th>Total OT Hrs.</th>
												<th>Total GatePass</th>
												<!--<th>Total Kaizen</th>
												<th>Total Traning</th>-->
											</tr>
											<?php 
											 	$this->date_wise_attendance_rows($year,$out[0]['id']);
											?>
										
										</table>
									</div>
								</div>
                            </div>
                </div>    
        <?php 
		}//function close

	
	
		// attendance function 2
	function date_wise_attendance_rows($year,$emp_code)
    {
		$loginId =$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');

		$current_month = (int)date('m');
		$current_year = date('Y');
		if($year == $current_year && $current_month<4)$year = $year-1;

		$list = $this->Base->get_all_month_list_from_given_finc_year($year);
		$month_list = $list[0];
		$year_list = $list[1];
		//print_r($list);

		$c=0;
		foreach($month_list as $m)
		{
			$j = (int)$m;
			$year2 = $year_list[$c];

			
		//for($j=$form_month;$j<=$to_month;$j++){

			if($j==1){$last_day_of_month=31;}
			elseif($j==2){$last_day_of_month=29;}
			elseif($j==3){$last_day_of_month=31;}
			elseif($j==4){$last_day_of_month=30;}
			elseif($j==5){$last_day_of_month=31;}
			elseif($j==6){$last_day_of_month=30;}
			elseif($j==7){$last_day_of_month=31;}
			elseif($j==8){$last_day_of_month=31;}
			elseif($j==9){$last_day_of_month=30;}
			elseif($j==10){$last_day_of_month=31;}
			elseif($j==11){$last_day_of_month=30;}
			elseif($j==12){$last_day_of_month=31;}
			
			
			$test = new DateTime("1-$j-$year2");
			$month= date_format($test, 'M');
			$from_date = date_format($test, 'Y-m-d');
			$to_date = date_format($test, 'Y-m-t');
			
			//geting data from attendance table
			$query=" SELECT * FROM daily_attendance_monthly where emp_code='$emp_code'  and att_year='$year2' and att_month='$j' and company_id='$company_id' ";
			$out=$this->Mymodel->query1($query);
			
			//$query=" SELECT count(id) as nos FROM emp_gatepass where emp_id='$emp_code' and   entry_date between '$from_date' and '$to_date'  ";
			//$gatepass=$this->Mymodel->query1($query);
			
			?>
			<tr style="height:10px; ">
			  	<td><?php echo $month.', '.$year2;?></td>
			  	<?php if(isset($out[0]['d1'])){echo $this->Base->get_attendance_p_a($out[0]['d1'],$out[0]['o1']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d2'])){echo $this->Base->get_attendance_p_a($out[0]['d2'],$out[0]['o2']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d3'])){echo $this->Base->get_attendance_p_a($out[0]['d3'],$out[0]['o3']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d4'])){echo $this->Base->get_attendance_p_a($out[0]['d4'],$out[0]['o4']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d5'])){echo $this->Base->get_attendance_p_a($out[0]['d5'],$out[0]['o5']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d6'])){echo $this->Base->get_attendance_p_a($out[0]['d6'],$out[0]['o6']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d7'])){echo $this->Base->get_attendance_p_a($out[0]['d7'],$out[0]['o7']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d8'])){echo $this->Base->get_attendance_p_a($out[0]['d8'],$out[0]['o8']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d9'])){echo $this->Base->get_attendance_p_a($out[0]['d9'],$out[0]['o9']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d10'])){echo $this->Base->get_attendance_p_a($out[0]['d10'],$out[0]['o10']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d11'])){echo $this->Base->get_attendance_p_a($out[0]['d11'],$out[0]['o11']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d12'])){echo $this->Base->get_attendance_p_a($out[0]['d12'],$out[0]['o12']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d13'])){echo $this->Base->get_attendance_p_a($out[0]['d13'],$out[0]['o13']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d14'])){echo $this->Base->get_attendance_p_a($out[0]['d14'],$out[0]['o14']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d15'])){echo $this->Base->get_attendance_p_a($out[0]['d15'],$out[0]['o15']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d16'])){echo $this->Base->get_attendance_p_a($out[0]['d16'],$out[0]['o16']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d17'])){echo $this->Base->get_attendance_p_a($out[0]['d17'],$out[0]['o17']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d18'])){echo $this->Base->get_attendance_p_a($out[0]['d18'],$out[0]['o18']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d19'])){echo $this->Base->get_attendance_p_a($out[0]['d19'],$out[0]['o19']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d20'])){echo $this->Base->get_attendance_p_a($out[0]['d20'],$out[0]['o20']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d21'])){echo $this->Base->get_attendance_p_a($out[0]['d21'],$out[0]['o21']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d22'])){echo $this->Base->get_attendance_p_a($out[0]['d22'],$out[0]['o22']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d23'])){echo $this->Base->get_attendance_p_a($out[0]['d23'],$out[0]['o23']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d24'])){echo $this->Base->get_attendance_p_a($out[0]['d24'],$out[0]['o24']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d25'])){echo $this->Base->get_attendance_p_a($out[0]['d25'],$out[0]['o25']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d26'])){echo $this->Base->get_attendance_p_a($out[0]['d26'],$out[0]['o26']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d27'])){echo $this->Base->get_attendance_p_a($out[0]['d27'],$out[0]['o27']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d28'])){echo $this->Base->get_attendance_p_a($out[0]['d28'],$out[0]['o28']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d29'])){echo $this->Base->get_attendance_p_a($out[0]['d29'],$out[0]['o29']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d30'])){echo $this->Base->get_attendance_p_a($out[0]['d30'],$out[0]['o30']);}else{echo "<td></td>";} ?>
				<?php if(isset($out[0]['d31'])){echo $this->Base->get_attendance_p_a($out[0]['d31'],$out[0]['o31']);}else{echo "<td></td>";} ?>
				
				<td align="center"><b><?php if(isset($out[0]['total_day_in_month'])){echo $total_day_in_month[]=$out[0]['total_day_in_month'];}else{echo "";} ?></b></td>
				
				<td align="center"><b><?php if(isset($out[0]['total_sunday'])){echo $total_sunday[]=$out[0]['total_sunday'];}else{echo "";} ?></b></td>
				<td align="center"><b><?php if(isset($out[0]['total_holiday'])){echo $total_holiday[]=$out[0]['total_holiday'];}else{echo "";} ?></b></td>
				
				
				<td align="center"><b><?php if(isset($out[0]['total_p'])){echo $total_p[]=$out[0]['total_p'];}else{echo "";} ?></b></td>
				<td align="center"><b><?php if(isset($out[0]['total_rest'])){echo $total_rest[]=$out[0]['total_rest'];}else{echo "";} ?></b></td>
				<td align="center"><b><?php if(isset($out[0]['total_present'])){echo $total_present[]=$out[0]['total_present'];}else{echo "";} ?></b></td>
				<td align="center"><b><?php if(isset($out[0]['total_l'])){echo $total_l[]=$out[0]['total_l'];}else{echo "";} ?></b></td>
				<td align="center"><b><?php if(isset($out[0]['total_a'])){echo $total_a[]=$out[0]['total_a'];}else{echo "";} ?></b></td>
				<td align="center"><b><?php if(isset($out[0]['total_absent'])){echo $total_absent[]=$out[0]['total_absent'];}else{echo "";} ?></b></td>
				
				<td align="center"><b><?php if(isset($out[0]['total_ot'])){echo $total_ot[]=$out[0]['total_ot'];}else{echo "";} ?></b></td>
				
				<td align="center"><b><?php if(isset($gatepass)){ echo $gatepass2[]=$gatepass[0]['nos'];}else{echo "";} ?></b></td>
			</tr>
		 <?php
		 $c++;
		}//foreach
		?>
			<tr>
			<td></td>
				<td colspan="31"><b>Total</b></td>
				<td align="center"><b><?php if(!empty($total_day_in_month)){echo array_sum($total_day_in_month);}?></b></td>
				<td align="center"><b><?php if(!empty($total_sunday)){echo array_sum($total_sunday);}?></b></td>
				<td align="center"><b><?php if(!empty($total_holiday)){echo array_sum($total_holiday);}?></b></td>

				
				<td align="center"><b><?php if(!empty($total_p)){echo array_sum($total_p);}?></b></td>
				<td align="center"><b><?php if(!empty($total_rest)){echo array_sum($total_rest);}?></b></td>
				<td align="center"><b><?php if(!empty($total_present)){echo array_sum($total_present);}?></b></td>
				<td align="center"><b><?php if(!empty($total_l)){echo array_sum($total_l);}?></b></td>
				<td align="center"><b><?php if(!empty($total_a)){echo array_sum($total_a);}?></b></td>
				<td align="center"><b><?php if(!empty($total_absent)){echo array_sum($total_absent);}?></b></td>
				<td align="center"><b><?php if(!empty($total_ot)){echo array_sum($total_ot);}?></b></td>
				<td align="center"><b><?php if(!empty($gatepass2)){echo array_sum($gatepass2);}?></b></td>
			</tr>   
		<?php
	
	}//function close
	

	function emp_month_wise_salary($year, $emp_code)
	{
		$current_month = (int)date('m');
		$current_year  = date('Y');
		$company_id = $this->session->userdata('company_id');

		// SAME AS ATTENDANCE
		$list = $this->Base->get_all_month_list_from_given_finc_year($year);
		$month_list = $list[0];
		$year_list  = $list[1];

		$c = 0;
		?>
		<div class="col-md-12">
			<div class="panel panel-info">
				<div class="panel-body">
					<p>Salary Details: </p>
					<div class="table-responsive">
						<table border="1" width="100%">
							<tr>
								<th>Month</th>
								<th class="text-right">Basic</th>
								<th class="text-right">HRA</th>
								<th class="text-right">Other</th>
								<th class="text-right">CTC</th>
								<th class="text-right">Present</th>
								<th class="text-right">OT</th>
								<th class="text-right">Total Earn</th>
								<th class="text-right">Total Ded</th>
								<th class="text-right">Net Pay</th>
							</tr>

							<?php
							foreach($month_list as $m)
							{
								$year2 = $year_list[$c];

								if($year2 == $current_year && $m > $current_month) break;
								
								$test = new DateTime("1-$m-$year2");
								$month= date_format($test, 'M');
								$monthName = date('M', strtotime("1-$m-$year2"));

								$q = "SELECT * FROM daily_attendance_monthly
									WHERE emp_code='$emp_code' AND company_id='$company_id'
									AND att_year='$year2'
									AND att_month='$m'";
								$out = $this->Mymodel->query1($q);

								if(empty($out)) { $c++; continue; }

								if(!empty($out[0]['company_role_id'])){
									$company_role_id = $out[0]['company_role_id'];
									$link4 = "?type_search=$company_role_id&year_search=$year2&month_search=$m&pay_code=$emp_code&search=Search ";
								}else{$link4='';}
							?>
							<tr>
								<td>
									<a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_slip_print_1<?php echo $link4;?>" ><?php echo $month.', '.$year2;?></a>
								</td>
								<td class="text-right"><?= number_format($out[0]['basic_salary'],2) ?></td>
								<td class="text-right"><?= number_format($out[0]['hra'],2) ?></td>
								<td class="text-right"><?= number_format($out[0]['other_allow'],2) ?></td>
								<td class="text-right"><?= number_format($out[0]['current_ctc'],2) ?></td>
								<td class="text-right"><?= $out[0]['total_present'] ?></td>
								<td class="text-right"><?= $out[0]['total_ot'] ?></td>
								<td class="text-right"><?= number_format($out[0]['current_ctc_payable'],2) ?></td>
								<td class="text-right"><?= number_format($out[0]['total_deduction'],2) ?></td>
								<td class="text-right"><b><?= number_format($out[0]['current_total_ctc_payable'],2) ?></b></td>
							</tr>
							<?php
								$c++;
							}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php
	}






	//1st present after leave
	function get_first_P_after_leave_ask_date($empid,$ask_to_date)
	{
		$test = new DateTime($ask_to_date);
		$month = (int)date_format($test, 'm');
		$year = date_format($test, 'Y');
		$company_id = $this->session->userdata('company_id');

		$query = "SELECT * FROM daily_attendance_monthly
				WHERE emp_code = '$empid' and company_id='$company_id'
				AND (att_year > $year OR (att_year = $year AND att_month >= $month))
				ORDER BY att_year, att_month";

		$out = $this->Mymodel->query1($query); // assume this returns an array of rows

		$leave_ts = strtotime($ask_to_date);
		$first_present = false;

		foreach ($out as $row) {
			$y = $row['att_year'];
			$m = $row['att_month'];

			for ($d = 1; $d <= 31; $d++) {
				$col = 'd' . $d;

				if (!isset($row[$col])) continue;

				if ($row[$col] === 'P') {
					$date_str = sprintf('%04d-%02d-%02d', $y, $m, $d);
					$date_ts = strtotime($date_str);

					if ($date_ts > $leave_ts) {
						$first_present = $date_str;
						break 2; // exit both loops
					}
				}
			}
		}

		if ($first_present) {
			echo $this->Base->change_date_dmy($first_present);
			$diff =  $this->Base->get_diff_no_bw_two_days($first_present,$ask_to_date)-1;
			?>
			<span style="font-size:12px" class="badge badge-danger"><?php echo $diff;?></span>
			<?php
		} else {
			echo "-";
		}
	}//function close



	
	public function get_today_emp_absent()
	{
		$today_col = 'd' . date('j'); // Today's column (d1...d31)
		$year = date('Y');
		$month = date('n');
		$company_id = $this->session->userdata('company_id');

		// Fetch all attendance data for the month in one query
		$sql = "
			SELECT 
				dam.*,
				e.emp_code, 
				e.first_name, 
				e.last_name, 
				D.name AS department_name,
				(
					SELECT DA2.shift 
					FROM daily_attendance DA2
					WHERE DA2.emp_code = e.emp_code AND DA2.company_id='$company_id'
					ORDER BY DA2.shift_in_time DESC
					LIMIT 1
				) AS last_shift
			FROM daily_attendance_monthly dam
			INNER JOIN employee e ON dam.emp_code = e.id
			LEFT JOIN department D ON e.department_id = D.department_id
			WHERE dam.company_id='$company_id' AND dam.att_year = '$year'
			AND dam.att_month = '$month'
			AND (
				TRIM(UPPER(dam.$today_col)) NOT IN ('P','S','R') 
				OR dam.$today_col IS NULL 
				OR TRIM(dam.$today_col) = ''
			)
		";

		$query = $this->db->query($sql);
		$result = $query->result_array();
		//print_r($result);
		$absent_list = [];

		foreach ($result as $row) {
			$absent_days = 0;

			// Loop backward from today to day 1 to count consecutive absences
			for ($d = date('j'); $d >= 1; $d--) {
				$col = 'd' . $d;
				$day_status = isset($row[$col]) ? trim($row[$col]) : '';

				if ($day_status === '' || !in_array($day_status, ['P', 'S', 'R'])) {
					$absent_days++;
				} else {
					break; // Stop counting when first present day found
				}
			}

			$absent_list[] = [
				'emp_code'        => $row['emp_code'],
				'name'            => $row['first_name'] . ' ' . $row['last_name'],
				'department_name' => $row['department_name'] ?? 'No Department',
				'last_shift' => $row['last_shift'] ?? '',
				'absent_days'     => $absent_days
			];
		}

		return $absent_list;
	}

	
	public function display_absent()
	{
		$absent_emps = $this->get_today_emp_absent();
		if(empty($absent_emps))return;

		// Group employees by department
		$dept_groups = [];
		foreach ($absent_emps as $emp) {
			$dept_groups[$emp['department_name']][] = $emp;
		}
		?>

		<div class="col-md-12 mb-4" style="margin-top: 20px;">
			<div class="table-responsive">
				<table class="table table-bordered table-sm" style="font-size: 13px;" id="absentTable">
					<thead class="table-light">
						<tr>
							<?php foreach ($dept_groups as $dept => $emps): ?>
								<th><?= htmlspecialchars($dept) ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php
						$max_rows = max(array_map('count', $dept_groups));

						for ($i = 0; $i < $max_rows; $i++):
                            echo "<tr>";
                            foreach ($dept_groups as $emps) {
                                if (isset($emps[$i])) {
                        
                                    // Rearrange $emps so that General → A → B
                                    usort($emps, function($a, $b) {
                                        $order = ['General' => 1, 'A' => 2, 'B' => 3];
                                        return ($order[$a['last_shift']] ?? 99) <=> ($order[$b['last_shift']] ?? 99);
                                    });
                        
                                    $emp = $emps[$i];
                                    ?>
                                        <td>
                                            <input type="checkbox" class="emp-check" value="<?php echo $emp['emp_code']; ?>">
                                            <?php
                                                $shift_display = $emp['last_shift'];
                                                if ($shift_display === 'B') {
                                                    $shift_display = "<span class='badge bg-warning' style='color:white'>B</span>";
                                                } elseif ($shift_display === 'A') {
                                                    $shift_display = "<span class='badge bg-danger' style='color:white'>A</span>";
                                                } else { // General
                                                    $shift_display = "<span class='badge bg-danger' style='color:white'>{$shift_display}</span>";
                                                }
                        
                                                echo " {$shift_display} : {$emp['emp_code']}: "
                                                    . htmlspecialchars($emp['name'])
                                                    . " ({$emp['absent_days']})";
                                            ?>
                                        </td>
                                    <?php
                                } else {
                                    echo "<td></td>";
                                }
                            }
                            echo "</tr>";
                        endfor;
						?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-md-12 mb-4" >
			<div class="row">

				<div class="col-md-2">
					<label>Select Date</label>
					<input type="date" class="form-control" id="In_date">
				</div>

				<div class="col-md-2">
					<label>Shift</label>
					<select class="form-control" id="SHIFT">
						<option value="">Select</option>
						<option value="A">A</option>
						<option value="B">B</option>
						<option value="General">General</option>
					</select>
				</div>

				<div class="col-md-2">
					<label>Set In Time</label>
					<input type="time" class="form-control" id="In_time">
				</div>

				<div class="col-md-2" style="margin-top: 30px;">
					<button type="button" class="btn btn-dark" id="in_punch">Save</button>
				</div>
			</div>
		</div>
		

	<script>
			document.getElementById('SHIFT').addEventListener('change', function () {
				let shift = this.value;
				let inTime = document.getElementById('In_time');
				
				if (shift === 'A') {
					inTime.value = '08:00';
				} else if (shift === 'B') {
					inTime.value = '20:00';
				} else if (shift === 'General') {
					inTime.value = '09:00';
				} else {
					inTime.value = '';
				}
			});

			document.getElementById('in_punch').addEventListener('click', function () {
				let selected = [];
				document.querySelectorAll('.emp-check:checked').forEach(cb => selected.push(cb.value));

				if (selected.length === 0) {
					alert('No employees selected.');
					return;
				}

				let inTime = document.getElementById('In_time').value;
				let inDate = document.getElementById('In_date').value;

				if (!inTime || !inDate) {
					alert("Please select shift and date so In Time is set.");
					return;
				}

				// Check if inDate is greater than today's date
				let todayStr = new Date().toISOString().split('T')[0];
				if (inDate > todayStr) {
					alert("Selected date cannot be greater than today's date.");
					return;
				}

				

				//let ERP_URL = 'http://localhost/class/rks/index.php/';
				let ERP_URL = "<?php echo base_url().'index.php/'?>";

				let successMsgs = [];
				let errorMsgs = [];

				let promises = selected.map(function (emp_code) {
					//let dateTime = `${dateStr} ${inTime}`;
					let dateTime = `${inDate} ${inTime}`;
					let apiUrl1 = `${ERP_URL}Hr/delete_emp_punch?emp_code=${emp_code}&date_time=${encodeURIComponent(dateTime)}`;
					let apiUrl2 = `${ERP_URL}Welcome/emp_attend_api?emp_code=${emp_code}&date_time=${encodeURIComponent(dateTime)}`;

					return fetch(apiUrl1)
						.then(res => res.text())
						.then(data => {
							console.log(`Delete API Response for ${emp_code}:`, data);
							return fetch(apiUrl2);
						})
						.then(res => res.text())
						.then(data => {
							console.log(`API Response for ${emp_code}:`, data);
							let cb = document.querySelector(`.emp-check[value="${emp_code}"]`);
							if (cb) cb.closest('td').innerHTML = '';
							successMsgs.push(`${emp_code}: Success`);
						})
						.catch(err => {
							console.error(`Error for ${emp_code}:`, err);
							errorMsgs.push(`${emp_code}: ${err}`);
						});
				});

				Promise.all(promises).then(() => {
					let finalMsg = "";
					if (successMsgs.length > 0) {
						document.getElementById('In_time').value="";
						document.getElementById('In_date').value="";
						document.getElementById('SHIFT').value="";
						finalMsg += "✅ Success:\n" + successMsgs.join("\n") + "\n\n";
					}
					if (errorMsgs.length > 0) {
						finalMsg += "❌ Errors:\n" + errorMsgs.join("\n");
					}
					if (finalMsg) alert(finalMsg);
				});
			});
		</script>




		<?php
	}












	//-----------------------------------------------------------------------canteen
    public function get_coupon_issue_data_with_id($id)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="  SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,E.present_address,E.permanent_address,E.doj,E.last_org
                FROM canteen_coupon_issue as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                WHERE A.id ='$id' AND A.company_id='$company_id'
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//coupon issue search 
    public function get_all_coupon_issue_with_search($search)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.*,E.id as empid,E.first_name,E.last_name,E.department_id,E.role_in_department,E.father_name,E.mob,
						D.name as dname
                FROM canteen_coupon_issue as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
               	WHERE 1=1  AND A.company_id='$company_id' $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


	//coupon issue search group by emp_code
    public function get_all_coupon_issue_with_empcode_group_by($fdate,$tdate)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.emp_code, sum(A.lunch_coupon_no) as lunch_coupon_no,
									sum(A.breakfast_coupon_no) as breakfast_coupon_no,
									sum(A.total_coupon) as total_coupon,
									sum(A.lunch_coupon_amt) as lunch_coupon_amt,
									sum(A.breakfast_coupon_amt) as breakfast_coupon_amt,
									sum(A.dinner_coupon_no) as dinner_coupon_no,
									sum(A.dinner_coupon_amt) as dinner_coupon_amt,
									sum(A.total_amt) as total_amt,
						E.first_name,E.last_name,E.father_name,E.mob,
						D.name as dname
                FROM canteen_coupon_issue as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
               	WHERE  A.emp_code != '' AND A.company_id='$company_id' and  A.issue_date between '$fdate' and '$tdate'   GROUP BY A.emp_code ORDER by E.first_name
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


	//coupon issue search group by other_name
    public function get_all_coupon_issue_with_other_name_group_by($fdate,$tdate)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.other_name,A.other_dept,A.other_ref,
									sum(A.lunch_coupon_no) as lunch_coupon_no,
									sum(A.breakfast_coupon_no) as breakfast_coupon_no,
									sum(A.total_coupon) as total_coupon,
									sum(A.lunch_coupon_amt) as lunch_coupon_amt,
									sum(A.breakfast_coupon_amt) as breakfast_coupon_amt,
									sum(A.dinner_coupon_no) as dinner_coupon_no,
									sum(A.dinner_coupon_amt) as dinner_coupon_amt,
									sum(A.total_amt) as total_amt
                FROM canteen_coupon_issue as A 
                WHERE  A.emp_code = '' AND A.company_id='$company_id' and A.other_name != '' and  A.issue_date between '$fdate' and '$tdate'   GROUP BY A.other_name,A.other_dept,A.other_ref ORDER by A.other_name
             ";
		$query = $this->db->query($sql);
        return $query->result_array();
    }//function close


	//coupon issue search group by date
    public function get_total_amt_of_emp($fdate,$tdate,$emp_code)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT 
					sum(A.breakfast_coupon_no) as br_coupon,
					sum(A.lunch_coupon_no) as lunch_coupon,
					sum(A.dinner_coupon_no) as dinner_coupon,
					sum(A.lunch_coupon_no) + sum(A.dinner_coupon_no)  as food_coupon,
					sum(A.total_amt) as total_amt
                FROM canteen_coupon_issue as A 
                WHERE A.emp_code='$emp_code' AND A.company_id='$company_id' and  A.issue_date between '$fdate' and '$tdate'   GROUP BY A.emp_code 
             ";
		$query = $this->db->query($sql);
        return $res2 = $query->result_array();
		//print_r($res2);
		// if(!empty($res2)){
		// 	return $res2[0]['total_amt'];
		// }else{
		// 	return '';
		// }
    }//function close


	//coupon issue search group by date
    public function get_all_coupon_issue_with_date_group_by($fdate,$tdate)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.issue_date,
									sum(A.lunch_coupon_no) as lunch_coupon_no,
									sum(A.breakfast_coupon_no) as breakfast_coupon_no,
									sum(A.total_coupon) as total_coupon,
									sum(A.lunch_coupon_amt) as lunch_coupon_amt,
									sum(A.breakfast_coupon_amt) as breakfast_coupon_amt,
									sum(A.dinner_coupon_no) as dinner_coupon_no,
									sum(A.dinner_coupon_amt) as dinner_coupon_amt,
									sum(A.total_amt) as total_amt
                FROM canteen_coupon_issue as A 
                WHERE  A.company_id='$company_id' AND A.issue_date between '$fdate' and '$tdate'   GROUP BY A.issue_date ORDER by A.issue_date
             ";
		$query = $this->db->query($sql);
        return $query->result_array();
    }//function close


	//TOP user of lunch
    public function get_top_most_lunch_coupon_issue($fdate,$tdate,$top,$limit)
	{
		$company_id = $this->session->userdata('company_id');
        if($top=='HIGH'){
			$ASC_DESC = "DESC";
		}else{
			$ASC_DESC = "ASC";
		}
		$sql="   SELECT A.emp_code,  SUM(lunch_coupon_no)+SUM(dinner_coupon_no) AS total_coupons,
						E.first_name,E.last_name,E.father_name,E.mob,
						D.name as dname
                FROM canteen_coupon_issue as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
               	WHERE  A.emp_code != '' AND A.company_id='$company_id' and  A.issue_date between '$fdate' and '$tdate'   GROUP BY A.emp_code ORDER BY total_coupons $ASC_DESC LIMIT $limit
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//TOP user of lunch
    public function get_top_most_breakfast_coupon_issue($fdate,$tdate,$top,$limit)
	{
		$company_id = $this->session->userdata('company_id');
        if($top=='HIGH'){
			$ASC_DESC = "DESC";
		}else{
			$ASC_DESC = "ASC";
		}
		$sql="   SELECT A.emp_code,  SUM(breakfast_coupon_no) AS total_coupons,
						E.first_name,E.last_name,E.father_name,E.mob,
						D.name as dname
                FROM canteen_coupon_issue as A 
                LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
               	WHERE  A.emp_code != '' AND A.company_id='$company_id' and  A.issue_date between '$fdate' and '$tdate'   GROUP BY A.emp_code ORDER BY total_coupons $ASC_DESC LIMIT $limit
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


	public function get_last_3month_lunch_coupon_issue()
	{
		$company_id = $this->session->userdata('company_id');
        $sql=" SELECT 
				A.emp_code,
				
				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE() - INTERVAL 3 MONTH, '%Y-%m') THEN breakfast_coupon_no ELSE 0 END) AS m4_BF,
				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE() - INTERVAL 3 MONTH, '%Y-%m') THEN lunch_coupon_no ELSE 0 END) AS m4_Lunch,
				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE() - INTERVAL 3 MONTH, '%Y-%m') THEN dinner_coupon_no ELSE 0 END) AS m4_dinner,

				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH, '%Y-%m') THEN breakfast_coupon_no ELSE 0 END) AS m3_BF,
				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH, '%Y-%m') THEN lunch_coupon_no ELSE 0 END) AS m3_Lunch,
				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH, '%Y-%m') THEN dinner_coupon_no ELSE 0 END) AS m3_dinner,

				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m') THEN breakfast_coupon_no ELSE 0 END) AS m2_BF,
				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m') THEN lunch_coupon_no ELSE 0 END) AS m2_Lunch,
				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, '%Y-%m') THEN dinner_coupon_no ELSE 0 END) AS m2_dinner,

				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m') THEN breakfast_coupon_no ELSE 0 END) AS m1_BF,
				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m') THEN lunch_coupon_no ELSE 0 END) AS m1_Lunch,
				SUM(CASE WHEN DATE_FORMAT(issue_date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m') THEN dinner_coupon_no ELSE 0 END) AS m1_dinner,
				E.first_name,E.last_name,E.father_name,E.mob,
				D.name as dname

			FROM canteen_coupon_issue as A
				LEFT JOIN employee as E ON A.emp_code = E.emp_code
                LEFT JOIN department as D ON E.department_id = D.department_id
			WHERE 
			 	A.company_id='$company_id' AND
				A.issue_date >= DATE_FORMAT(CURDATE() - INTERVAL 3 MONTH, '%Y-%m-01')
			GROUP BY 
				A.emp_code
			ORDER BY 
				E.first_name
			";
        $query = $this->db->query($sql);
        $res2 = $query->result_array();
		//print_r($out);
		if(!empty($res2)){
		?>
				<div class="table-responsive">
					<h3>Last 3 month lunch & breakfast coupon issue data employee wise</h3>
					<table class="table table-bordered table-striped table-sm" id="printed_table">
							<thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
								<tr>
									<th>#</th>
									<th>Emp Code</th>
									<th>Name</th>
									<th>Dept.</th>
									

									<th>B.F Coupon <?php echo $this->Base->subtractMonthsGetMonthName(3);?></th>
									<th>B.F Coupon <?php echo $this->Base->subtractMonthsGetMonthName(2);?></th>
									<th>B.F Coupon <?php echo $this->Base->subtractMonthsGetMonthName(1);?></th>
									<th>B.F Coupon <?php echo $this->Base->subtractMonthsGetMonthName(0);?></th>

									<th>Lunch Coupon <?php echo $this->Base->subtractMonthsGetMonthName(3);?></th>
									<th>Lunch Coupon <?php echo $this->Base->subtractMonthsGetMonthName(2);?></th>
									<th>Lunch Coupon <?php echo $this->Base->subtractMonthsGetMonthName(1);?></th>
									<th>Lunch Coupon <?php echo $this->Base->subtractMonthsGetMonthName(0);?></th>

									<th>Dinner Coupon <?php echo $this->Base->subtractMonthsGetMonthName(3);?></th>
									<th>Dinner Coupon <?php echo $this->Base->subtractMonthsGetMonthName(2);?></th>
									<th>Dinner Coupon <?php echo $this->Base->subtractMonthsGetMonthName(1);?></th>
									<th>Dinner Coupon <?php echo $this->Base->subtractMonthsGetMonthName(0);?></th>

									
								</tr>
						</thead>
						<tbody>
								<?php 
									$i=1;
									foreach($res2 as $r)
									{
										?>
											<tr>
												<th scope="row"><?php echo $i;?></th>
												<td><?php echo $r['emp_code']?></td>
												<td><?php echo $r['first_name'].' '.$r['last_name'];?></td>
												<td><?php echo $r['dname']?></td>
												
												

												<td><?php echo $r['m4_BF']?></td>
												<td><?php echo $r['m3_BF']?></td>
												<td><?php echo $r['m2_BF']?></td>
												<td><?php echo $r['m1_BF']?></td>

												<td><?php echo $r['m4_Lunch']?></td>
												<td><?php echo $r['m3_Lunch']?></td>
												<td><?php echo $r['m2_Lunch']?></td>
												<td><?php echo $r['m1_Lunch']?></td>

												<td><?php echo $r['m4_dinner']?></td>
												<td><?php echo $r['m3_dinner']?></td>
												<td><?php echo $r['m2_dinner']?></td>
												<td><?php echo $r['m1_dinner']?></td>
											</tr>
									<?php
									$i++; 
									}
								?>
							</tbody>
						</table>
					</div>
		<?php
		}//empty
    }//function close


	public function print_data_table($res2)
	{
       if(!empty($res2)){
		?>
				<div class="table-responsive">
					<h6>This Month Data</h6>
					<table class="table table-bordered table-striped table-sm" id="printed_table">
							<thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
								<tr>
									<th>#</th>
									<th>Emp Code</th>
									<th>Name</th>
									<th>Dept.</th>
									<th>Total Coupons</th>
								</tr>
						</thead>
						<tbody>
								<?php 
									$i=1;
									foreach($res2 as $r)
									{
										?>
											<tr>
												<th scope="row"><?php echo $i;?></th>
												<td><?php echo $r['emp_code']?></td>
												<td><?php echo $r['first_name'].' '.$r['last_name'];?></td>
												<td><?php echo $r['dname']?></td>
												<td><?php echo $r['total_coupons']?></td>
											</tr>
									<?php
									$i++; 
									}
								?>
							</tbody>
						</table>
					</div>
		<?php
		}//empty
    }//function close




	//-------------------------------------------------------------------------------Coupon Receive
	public function get_coupon_receive_data_with_id($id)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="  SELECT A.*
                FROM canteen_coupon_receive as A 
                WHERE A.id ='$id' and A.company_id='$company_id'
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//coupon receive search 
    public function get_all_coupon_receive_with_search($search)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.*
                FROM canteen_coupon_receive as A 
                WHERE 1=1 and A.company_id='$company_id' $search 
             ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close

	//coupon receive search group by date
    public function get_all_coupon_receive_with_date_group_by($fdate,$tdate)
	{
		$company_id = $this->session->userdata('company_id');
        $sql="   SELECT A.receive_date,
						sum(A.dinner_coupon_no) as dinner_coupon_no,
						sum(A.dinner_coupon_amt) as dinner_coupon_amt,

						sum(A.lunch_coupon_no) as lunch_coupon_no,
						sum(A.breakfast_coupon_no) as breakfast_coupon_no,
						sum(A.total_coupon) as total_coupon,
						sum(A.lunch_coupon_amt) as lunch_coupon_amt,
						sum(A.breakfast_coupon_amt) as breakfast_coupon_amt,
						sum(A.total_amt) as total_amt
                FROM canteen_coupon_receive as A 
                WHERE A.company_id='$company_id' AND A.receive_date between '$fdate' and '$tdate'   GROUP BY A.receive_date ORDER by A.receive_date
             ";
		$query = $this->db->query($sql);
        return $query->result_array();
    }//function close




	//chart
	public function coupon_issue_chart_display($days)
    {
        $search_date1= $this->Base->get_choise_gap_ymd(date('Y-m-d'),"-$days Days") ;
		$search_date2= date('Y-m-d');
		$res2 = $this->Hrmodel->get_all_coupon_receive_with_date_group_by($search_date1,$search_date2);
        if(!empty($res2)){
			$dateList = []; 
			$dinner_coupon_no = [];
			$lunch_coupon_no = [];
			$breakfast_coupon_no = [];
			foreach ($res2 as $item) {
				$dateList[] = date('d', strtotime($item['receive_date']));
				$dinner_coupon_no[] = $item['dinner_coupon_no'];
				$lunch_coupon_no[] = $item['lunch_coupon_no'];
				$breakfast_coupon_no[] = $item['breakfast_coupon_no'];
			}

		?>
                    
						<div class="card-body">
								<div class="card-title">Canteen details Date wise
									<span style="color:#ff5721">Brekfast</span>
									<span style="color:#5f6cc1">Lunch</span>
									<span style="color:#4cae50">Dinner</span>
								</div>
								<div id="lineChartWIthDataLabel"></div>
						</div>
						

					<script>
							var options = {
								chart: {
								height: 350,
								type: 'line',
								shadow: {
									enabled: true,
									color: '#000',
									top: 18,
									left: 7,
									blur: 10,
									opacity: 1
								},
								toolbar: {
									show: false
								},
								animations: {
									enabled: true,
									easing: 'linear',
									speed: 500,
									animateGradually: {
									enabled: true,
									delay: 150
									},
									dynamicAnimation: {
									enabled: true,
									speed: 550
									}
								}
								},
								colors: ['#ff5721', '#5f6cc1', '#4cae50'], // breakfast, lunch, dinner
								dataLabels: {
								enabled: true
								},
								stroke: {
								curve: 'smooth'
								},
								series: [{
								name: "Breakfast",
								data: <?php echo json_encode($breakfast_coupon_no); ?>
								}, {
								name: "Lunch",
								data: <?php echo json_encode($lunch_coupon_no); ?>
								}, {
								name: "Dinner",
								data: <?php echo json_encode($dinner_coupon_no); ?>
								}],
								grid: {
								borderColor: '#e7e7e7',
								row: {
									colors: ['#f3f3f3', 'transparent'],
									opacity: 0.5
								}
								},
								markers: {
								size: 6
								},
								xaxis: {
								categories: <?php echo json_encode($dateList); ?>,
								title: {
									text: 'Date'
								}
								},
								yaxis: {
								title: {
									text: 'Coupons'
								},
								min: 0 // optional: adjust based on your lowest values
								},
								legend: {
								position: 'top',
								horizontalAlign: 'right',
								floating: true,
								offsetY: -25,
								offsetX: -5
								}
							};

							var chart = new ApexCharts(document.querySelector("#lineChartWIthDataLabel"), options);
							chart.render();
					</script>

                <?php
        }//empty
    }//function close




	//----------------------------------------other application form
	public function other_appication_form($type,$res2)
    {
		$login_emp_code =$this->session->userdata('login_emp_code');
		?> 
		<div class="form-row">
				<div class="col-md-3" style="margin-top:10px">
						<label>Date</label>
					<input type="date" class="form-control"  id="entry_date1" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['entry_date'];?>"  >
				</div>  
		<?php 
		if($type == "Gatepass"){
		?> 
                                              
				<div class="col-md-9" style="margin-top:10px">
					<label>Reason</label>
					<input type="text" class="form-control"  id="description" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['description'];?>" >
				</div>

				<div class="col-md-3" style="margin-top:10px">
					<label >Type Of Work</label>
					<select class="form-control"   id="work_type">
						<option value="">Select</option>
						<option  <?php if(!empty($res2)){if($res2[0]['work_type']=='Personal'){echo "selected";}}?>>Personal</option>
						<option  <?php if(!empty($res2)){if($res2[0]['work_type']=='Company'){echo "selected";}}?>>Company</option>
					</select>
				</div>

				<div class="col-md-3" style="margin-top:10px">
					<label>Vehical Name (if used)</label>
					<input type="text" class="form-control"  id="vehical_name" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['vehical_name'];?>" >
				</div>

				<div class="col-md-3" style="margin-top:10px">
					<label>KM Start</label>
					<input type="number" class="form-control"  id="km_start" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['km_start'];?>" >
				</div>

				<div class="col-md-3" style="margin-top:10px">
					<label>KM End</label>
					<input type="number" class="form-control"  id="km_end" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['km_end'];?>" >
				</div>

				<div class="col-md-3" style="margin-top:10px">
					<label>Time Out</label>
					<input type="time" class="form-control"  id="time_out" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['time_out'];?>" >
				</div>

				<div class="col-md-3" style="margin-top:10px">
					<label >Duty Off</label>
					<select class="form-control"   id="duty_off">
						<option value="">Select</option>
						<option  <?php if(!empty($res2)){if($res2[0]['duty_off']=='Yes'){echo "selected";}}?>>Yes</option>
						<option  <?php if(!empty($res2)){if($res2[0]['duty_off']=='No'){echo "selected";}}?>>No</option>
					</select>
				</div>

				<div class="col-md-3" style="margin-top:10px">
					<label>Time In</label>
					<input type="time" class="form-control"  id="time_in" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['time_in'];?>" >
				</div>

				<div class="col-md-3" style="margin-top:10px">
					<label>Sup. name</label>
					<input type="text" class="form-control"  id="sup_id"  readonly  autocomplete="off" value="<?php if(!empty($res2[0]['sup_id'])){echo $res2[0]['sup_id'];}else{echo $login_emp_code;}?>">
				</div>

				
		

		<?php 
		}elseif($type == "EPF/ESI" || $type == "Fight" || $type == "Increment" || $type == "MEMO" || $type == "Mobile" || $type == "Rest Change" || $type == "Re-Join" || $type == "Salary" || $type == "Shift Change" || $type == "Fine"  || $type == "Resign"  || $type == "Other")
		{
		?>  
				<div class="col-md-9" style="margin-top:10px">
					<label>Subject</label>
					<input type="text" class="form-control"  id="subject" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['subject'];?>" >
				</div>

				<div class="col-md-12" style="margin-top:10px">
					<label>Description</label>
					<input type="text" class="form-control"  id="description" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['description'];?>" >
				</div>

				<div class="col-md-12" style="margin-top:10px">
					<label>Action</label>
					<input type="text" class="form-control"  id="action" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['action'];?>" >
				</div>

				<?php if($type == "Fine"){?>
					<div class="col-md-12" style="margin-top:10px">
						<label> Amount (Rs.)</label>
						<input type="number" class="form-control"  id="amount" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['amount'];?>" >
					</div>
				<?php }?>
			
		<?php }elseif($type == "Medical"){?>

			<div class="col-md-3" style="margin-top:10px">
					<label>Time</label>
				<input type="time" class="form-control"  id="entry_time" required  autocomplete="off" value="<?php if(isset($ask_date))echo $ask_date;?>"  >
			</div> 

			

			<div class="col-md-3" style="margin-top:10px">
					<label>Location </label>
					<input type="text" class="form-control"  id="location" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['location'];?>" >
			</div>

			<div class="col-md-3" style="margin-top:10px">
					<label >Type of Accident</label>
					<select class="form-control"   id="accident_type">
						<option value="">Select</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_type']=='Slip / Fall'){echo "selected";}}?>>Slip / Fall</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_type']=='Machinery-related'){echo "selected";}}?>>Machinery-related</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_type']=='Electrical'){echo "selected";}}?>>Electrical</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_type']=='Fire'){echo "selected";}}?>>Fire</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_type']=='Chemical Spil'){echo "selected";}}?>>Chemical Spil</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_type']=='Crane'){echo "selected";}}?>>Crane</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_type']=='Human'){echo "selected";}}?>>Human</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_type']=='Animal / Insects'){echo "selected";}}?>>Animal / Insects</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_type']=='Other'){echo "selected";}}?>>Other</option>
					</select>
			</div>

			<div class="col-md-3" style="margin-top:10px">
					<label >Nature of Injury</label>
					<select class="form-control"   id="accident_nature">
						<option value="">Select</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_nature']=='Minor'){echo "selected";}}?>>Minor</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_nature']=='Major'){echo "selected";}}?>>Major</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_nature']=='Fatal'){echo "selected";}}?>>Fatal</option>
					</select>
			</div>

			<div class="col-md-3" style="margin-top:10px">
					<label >Action</label>
					<select class="form-control"   id="accident_action">
						<option value="">Select</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_nature']=='First Aid Only'){echo "selected";}}?>>First Aid Only</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_nature']=='Doctor'){echo "selected";}}?>>Doctor</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_nature']=='Hospitalization Required'){echo "selected";}}?>>Hospitalization Required</option>
					</select>
			</div>

			<div class="col-md-6" style="margin-top:10px">
					<label>Description</label>
					<input type="text" class="form-control"  id="description" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['description'];?>" >
			</div>

			<div class="col-md-4" style="margin-top:10px">
					<label>Root Cause</label>
					<input type="text" class="form-control"  id="accident_root" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['accident_root'];?>" >
			</div>

			<div class="col-md-4" style="margin-top:10px">
					<label >Contributing Factors</label>
					<select class="form-control"   id="accident_factors">
						<option value="">Select</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_factors']=='Human Error'){echo "selected";}}?>>Human Error</option>
						<option  <?php if(!empty($res2)){if($res2[0]['accident_factors']=='Lack of Training'){echo "selected";}}?>>Lack of Training</option>
					<option  <?php if(!empty($res2)){if($res2[0]['accident_factors']=='Poor Maintenance'){echo "selected";}}?>>Poor Maintenance</option>
					<option  <?php if(!empty($res2)){if($res2[0]['accident_factors']=='Unsafe Work Condition'){echo "selected";}}?>>Unsafe Work Condition</option>
					<option  <?php if(!empty($res2)){if($res2[0]['accident_factors']=='Non-compliance with SOPs'){echo "selected";}}?>>Non-compliance with SOPs</option> 
					<option  <?php if(!empty($res2)){if($res2[0]['accident_factors']=='Others'){echo "selected";}}?>>Others</option> 
					</select>
			</div>


			<div class="col-md-4" style="margin-top:10px">
					<label>Total Invoice Amount (Rs.)</label>
					<input type="number" class="form-control"  id="amount" required  autocomplete="off" value="<?php if(!empty($res2))echo $res2[0]['amount'];?>" >
			</div>

      <?php 
      }
	  ?></div><?php 
	}//function close







	//-------------------------------------------------------------------------------Dashboard

	public function get_all_emp_list($where)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT count(id) as total FROM employee where $where and  active='Active' and company_id='$company_id' and attendance_entry='0'  ORDER by pay_code ASC  ";
		$res=$this->Mymodel->query1($query);
		return $res[0]['total'];
	}//function close

	public function get_deactive_emp_list($where)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT count(id) as total FROM employee where $where and  active='Deactive'  and company_id='$company_id' and attendance_entry='0'  ORDER by pay_code ASC  ";
		$res=$this->Mymodel->query1($query);
		return $res[0]['total'];
	}//function close

	public function emp_total_salary($where)
	{
		$company_id = $this->session->userdata('company_id');
		$query=" SELECT sum(current_ctc) as total FROM employee where  $where and active='Active'  and company_id='$company_id'  and attendance_entry='0'  ORDER by pay_code ASC  ";
		$res=$this->Mymodel->query1($query);
		return $res[0]['total'];
	}//function close

	public function emp_total_salary_from_attendance_monthly($company_role_id,$att_month,$att_year)
	{
		$company_id = $this->session->userdata('company_id');
		if($company_role_id=='All')
		{
			$query=" SELECT  company_role_id, sum(total_present) as total_present, sum(total_ot) as total_ot,sum(esic_payable) as esic_payable,sum(epf_payable) as epf_payable,sum(current_total_ctc_payable) as current_total_ctc_payable  FROM daily_attendance_monthly WHERE   att_year='$att_year' and att_month='$att_month'  and company_id='$company_id' ";
		}
		else
		{
			$query=" SELECT  company_role_id, sum(total_present) as total_present, sum(total_ot) as total_ot,sum(esic_payable) as esic_payable,sum(epf_payable) as epf_payable,sum(current_total_ctc_payable) as current_total_ctc_payable  FROM daily_attendance_monthly WHERE company_role_id='$company_role_id' and  att_year='$att_year' and att_month='$att_month'  and company_id='$company_id'  ";
		}
		return $res=$this->Mymodel->query1($query);
		
	}//function close


	public function emp_total_salary_from_attendance_monthly_vs_total_sales($company_role_id,$att_month,$att_year)
	{
		$company_id = $this->session->userdata('company_id');
		if($company_role_id=='All')
		{
			$query=" SELECT  sum(current_total_ctc_payable) as current_total_ctc_payable  FROM daily_attendance_monthly WHERE   att_year='$att_year' and att_month='$att_month' and company_id='$company_id'  ";
		}
		else
		{
			$query=" SELECT  sum(current_total_ctc_payable) as current_total_ctc_payable  FROM daily_attendance_monthly WHERE company_role_id='$company_role_id' and  att_year='$att_year' and att_month='$att_month'  and company_id='$company_id' ";
		}
		$res=$this->Mymodel->query1($query);
		if(!empty($res[0]['current_total_ctc_payable'])){ $payable_salary = $res[0]['current_total_ctc_payable']; }else{ $payable_salary = 0;} 

		//getting this month total sales with gst
		$sales = $this->Dashbord->get_total_sale_formdate_todate(date("$att_year-$att_month-01"),date("$att_year-$att_month-31"));
		if(!empty($sales)){ $sales2 = $sales;}else{ $sales2 = 0;}
		
		//getting percentage
		if($sales >0 and $payable_salary>0){ $per = round(($payable_salary*100)/$sales2); }else{ $per = 0;}
		return $per;
	}//function close

	


	//----------------------------------------------HR ------------------------------------------------
	function hr_total_employee_box($div_length,$div_background_color,$div_color)
	{
		$where = " 1=1 ";
		$emp_total=$this->get_all_emp_list($where);
		?>
		  	<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-icon mb-4">
					<div class="card-body text-center"><i class="i-Add-User"></i>
						<p class="text-muted mt-2 mb-2">Total Employee</p>
						<p class="text-info text-24 line-height-1 m-0"><?php echo $emp_total?></p>
					</div>
				</div>
			</div>
		<?php
	}//function close

	function hr_total_employee_staff_box($div_length,$div_background_color,$div_color)
	{
		$where = " staff_tech='Staff' ";
		$emp_total=$this->get_all_emp_list($where);
		?>
		<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-icon mb-4">
					<div class="card-body text-center"><i class="i-Add-User"></i>
						<p class="text-muted mt-2 mb-2">Total Staff</p>
						<p class="text-info text-24 line-height-1 m-0"><?php echo $emp_total?></p>
					</div>
				</div>
			</div>
		<?php
	}//function close

	function hr_total_employee_tech_box($div_length,$div_background_color,$div_color)
	{
		$where = " staff_tech='Tech' ";
		$emp_total=$this->get_all_emp_list($where);
		?>
		<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-icon mb-4">
					<div class="card-body text-center"><i class="i-Add-User"></i>
						<p class="text-muted mt-2 mb-2">Total Associate</p>
						<p class="text-info text-24 line-height-1 m-0"><?php echo $emp_total?></p>
					</div>
				</div>
			</div>
		
			
		<?php
	}//function close
	function hr_total_employee_male_box($div_length,$div_background_color,$div_color)
	{
		$where = " gender='Male' ";
		$emp_total=$this->get_all_emp_list($where);
		?>
		<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-icon mb-4">
					<div class="card-body text-center"><i class="i-Add-User"></i>
						<p class="text-muted mt-2 mb-2">Total Male</p>
						<p class="text-info text-24 line-height-1 m-0"><?php echo $emp_total?></p>
					</div>
				</div>
			</div>
		<?php
	}//function close

	function hr_total_employee_female_box($div_length,$div_background_color,$div_color)
	{
		$where = " gender='Female' ";
		$emp_total=$this->get_all_emp_list($where);
		?>
		<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-icon mb-4">
					<div class="card-body text-center"><i class="i-Add-User"></i>
						<p class="text-muted mt-2 mb-2">Total Female</p>
						<p class="text-info text-24 line-height-1 m-0"><?php echo $emp_total?></p>
					</div>
				</div>
			</div>
		<?php
	}//function close

	function hr_total_employee_newjoin_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$day1=date("Y-m-01");
		
		$where = " doj between '$day1' and '$today' ";
		$emp_total=$this->get_all_emp_list($where);
		?>
		<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-icon mb-4">
					<div class="card-body text-center"><i style="color:green" class="i-Add-User"></i>
						<p class="text-muted mt-2 mb-2">New Joining</p>
						<p class="text-success text-24 line-height-1 m-0"><?php echo $emp_total?></p>
					</div>
				</div>
			</div>
		<?php
	}//function close

	function hr_total_deactive_employee_box($div_length,$div_background_color,$div_color)
	{
		$where = " 1=1 ";
		$emp_total = $this->get_deactive_emp_list($where);
		?>
		  	<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-icon mb-4">
					<div class="card-body text-center"><i style="color:red" class="i-Add-User"></i>
						<p class="text-muted mt-2 mb-2">Total Deactive</p>
						<p class="text-danger text-24 line-height-1 m-0"><?php echo $emp_total?></p>
					</div>
				</div>
			</div>
		<?php
	}//function close

	function hr_total_employee_resign_box($div_length,$div_background_color,$div_color)
	{
		//---geting sale today data
		$today=date("Y-m-d");
		$day1=date("Y-m-01");
		$yesterday=date("Y-m-d",strtotime ( "-1 day"));
		
		$where = " dor between '$day1' and '$today' ";
		$emp_total=$this->get_all_emp_list($where);
	?>
		<div class="col-lg-3 col-md-6 col-sm-6">
				<div class="card card-icon mb-4">
					<div class="card-body text-center"><i style="color:red" class="i-Add-User"></i>
						<p class="text-muted mt-2 mb-2">Resign</p>
						<p class="text-danger text-24 line-height-1 m-0"><?php echo $emp_total?></p>
					</div>
				</div>
			</div>
		
		<?php
	}//function close

	function contract_wise_salary_graph($div_length,$div_background_color,$height,$width)
    {
		$company_id = $this->session->userdata('company_id');
        $lastday = date('t',strtotime('today'));
		$m=date('m');
		$firstday = date("Y-$m-01");
		$lastday2 = date("Y-$m-$lastday");
		$day1=date("Y-m-01");
		$today = date('Y-m-d');

		$att_year = date('Y');
		$att_month = date('m');

		$query=" SELECT  
				A.company_role,

				COUNT(*) AS total_emp,

				SUM(A.current_total_ctc) AS salary_amt,

				SUM(CASE WHEN A.doj BETWEEN '$day1' AND '$today' THEN 1 ELSE 0 END) AS joined_between,

				SUM(CASE WHEN A.dor BETWEEN '$day1' AND '$today' THEN 1 ELSE 0 END) AS relieved_between,

				SUM(CASE WHEN A.staff_tech='Staff' THEN 1 ELSE 0 END) AS total_staff,
				SUM(CASE WHEN A.staff_tech='Tech' THEN 1 ELSE 0 END) AS total_tech,

				SUM(CASE WHEN A.gender='Male' THEN 1 ELSE 0 END) AS total_male,
				SUM(CASE WHEN A.gender='Female' THEN 1 ELSE 0 END) AS total_female,

				C.full_name AS company_full_name,
				C.manpower_limit

			FROM employee AS A
			LEFT JOIN contractor_code AS C 
				ON A.company_role = C.name

			WHERE A.active = 'Active' and A.company_id='$company_id'
			AND A.owner < 1

			GROUP BY A.company_role
			ORDER BY A.company_role;
			";
		$res=$this->Mymodel->query1($query);
		//print_r($res);
		//exit;
		?>
                    <div class="col-md-<?php echo $width;?>" >
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Unit Manpower Details</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive project-stats">  
                                       <table class="table table-bordered ">
                                           <thead>
                                               <tr>
                                                   <th>#</th>
                                                   <th>Unit</th>
												   <th>Name</th>
                                                   <th>New Join</th>
                                                   <th>New Resign</th>
												   <th>Staff</th>
												   <th>Worker</th>
												   <th>Male</th>
												   <th>Female</th>
                                                   <th>Total Employee</th>
												   <th>Employee Limit</th>
                                                   <th>% Employee</th>
												   <th>Salary Amt.(Rs.)</th>
												   
                                               </tr>
                                           </thead>
                                           
                                           <tbody>
											   <?php 
												 $i=1;
												 $a1 = array();$a2 = array();$a3 = array();$a4 = array();$a5 = array();
												 $a6 = array();$a7 = array();$a8 = array();$a9 = array();$a10 = array();
												 $a11 = array();$a12 = array();$a13 = array();$a14 = array();$a15 = array();
												 foreach($res as $r)
												 {  
													$manpower_limit = $r['manpower_limit'];
													$emp_total_join = $r['joined_between'];
													$emp_total_rej= $r['relieved_between'];
													$all_emp = $r['total_emp'];

													//percentage calculation
													if($manpower_limit > 0 and $all_emp > 0){ 
														$percentage = ($all_emp / $manpower_limit) * 100;
													} else {
														$percentage = 0;
													}
													$percentage = (int)$percentage; // make sure it's numeric

													if ($percentage >= 95) {
														$barClass = 'bg-danger';   
													} elseif ($percentage >= 80) {
														$barClass = 'bg-warning';   
													} else {
														$barClass = 'bg-success'; 
													}
											   ?>
											   <tr>
                                                   <th scope="row"><?php echo $i;?></th>
												   <td><?php echo $r['company_role']; ?></td>
												   <td><?php echo $r['company_full_name']; ?></td>
													<td><?php echo $a1[] = $emp_total_join;?></td>
												   <td><?php echo $a2[] = $emp_total_rej;?></td>
												   <td><?php echo $a9[] =$r['total_staff']; ?></td>
													<td><?php echo $a10[] =$r['total_tech']; ?></td>
													<td><?php echo $a11[] =$r['total_male']; ?></td>
													<td><?php echo $a12[] =$r['total_female']; ?></td>
												   <td><?php echo $a3[] = $all_emp;?></td>
												   <td><?php echo $a4[] = $manpower_limit;?></td>
												   <td style="min-width:150px;">
														<div class="progress" style="height:20px;">
															<div 
																class="progress-bar <?php echo $barClass; ?>" 
																role="progressbar"
																style="width: <?php echo $percentage; ?>%;"
																aria-valuenow="<?php echo $percentage; ?>"
																aria-valuemin="0"
																aria-valuemax="100">
																<?php echo $percentage; ?>%
															</div>
														</div>
													</td>
													<td><?php $rs = round($r['salary_amt']); $a8[] = $rs; echo $this->Base->numFormatIndia($rs); ?></td>
													
													
                                               </tr>
												 <?php 
												$i++;
												}
												?>

												<tr style="font-weight:bold">
														<td></td>
														<td></td>
														<td>Total</td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a1)); }?></td>
														<td><?php if(!empty($a1)){ echo round(array_sum($a2)); }?></td>
														<td><?php if(!empty($a9)){ echo round(array_sum($a9)); }?></td>
														<td><?php if(!empty($a10)){ echo round(array_sum($a10)); }?></td>
														<td><?php if(!empty($a11)){ echo round(array_sum($a11)); }?></td>
														<td><?php if(!empty($a12)){ echo round(array_sum($a12)); }?></td>
														<td><?php if(!empty($a3)){ echo round(array_sum($a3)); }?></td>
														<td><?php if(!empty($a4)){ echo round(array_sum($a4)); }?></td>
														<td></td>
														<td><?php if(!empty($a8)){ echo $this->Base->numFormatIndia(round(array_sum($a8))); }?></td>
												</tr>
											</tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
		<?php
	}//function close

	function dept_wise_salary_graph($div_length,$div_background_color,$height,$width)
	{
		$company_id = $this->session->userdata('company_id');
		$today = date('Y-m-d');
		$day1  = date('Y-m-01');

		$query = "SELECT  
				A.company_role,
				C.full_name AS company_name,
				D.name AS dept_name,

				COUNT(*) AS total_emp,
				SUM(A.current_total_ctc) AS salary_amt,

				SUM(CASE WHEN A.doj BETWEEN '$day1' AND '$today' THEN 1 ELSE 0 END) AS joined_between,
				SUM(CASE WHEN A.dor BETWEEN '$day1' AND '$today' THEN 1 ELSE 0 END) AS relieved_between,

				SUM(CASE WHEN A.staff_tech='Staff' THEN 1 ELSE 0 END) AS total_staff,
				SUM(CASE WHEN A.staff_tech='Tech' THEN 1 ELSE 0 END) AS total_tech,

				SUM(CASE WHEN A.gender='Male' THEN 1 ELSE 0 END) AS total_male,
				SUM(CASE WHEN A.gender='Female' THEN 1 ELSE 0 END) AS total_female

			FROM employee A
			LEFT JOIN department D ON A.department_id = D.department_id
			LEFT JOIN contractor_code C ON A.company_role = C.name
			WHERE A.active='Active' AND A.owner < 1 and A.company_id='$company_id'
			GROUP BY A.company_role, A.department_id
			ORDER BY A.company_role, D.name
		";

		$res = $this->Mymodel->query1($query);
		if (empty($res)) return;

		$currentCompany = '';
		$companyTotal = ['join'=>0,'resign'=>0,'emp'=>0,'sal'=>0,'staff'=>0,'tech'=>0,'male'=>0,'female'=>0];

		$box = 0;
		echo '<div class="row">';

		foreach ($res as $r) {

			if ($currentCompany !== '' && $currentCompany !== $r['company_role']) {
				echo $this->company_total_row($companyTotal);
				echo '</tbody></table></div></div></div>';
				$companyTotal = array_fill_keys(array_keys($companyTotal),0);
				$box++;
				if ($box % 3 == 0) echo '</div><div class="row">';
			}

			if ($currentCompany !== $r['company_role']) {
				$currentCompany = $r['company_role'];
				?>
				<div class="col-md-6">
					<div class="panel panel-white">
						<div class="panel-heading p-1">
							<strong><?= $r['company_role'].' - '.$r['company_name']; ?></strong>
						</div>
						<div class="panel-body p-1">
							<table class="table table-bordered table-sm table-condensed mb-0" >
								<thead>
									<tr>
										<th>Dept</th><th>New</th><th>Resign</th><th>Total</th>
										<th>Salary</th><th>Staff</th><th>Worker</th><th>Male</th><th>Female</th>
									</tr>
								</thead>
								<tbody>
				<?php
			}

			$companyTotal['join']   += $r['joined_between'];
			$companyTotal['resign'] += $r['relieved_between'];
			$companyTotal['emp']    += $r['total_emp'];
			$companyTotal['sal']    += $r['salary_amt'];
			$companyTotal['staff']  += $r['total_staff'];
			$companyTotal['tech']   += $r['total_tech'];
			$companyTotal['male']   += $r['total_male'];
			$companyTotal['female'] += $r['total_female'];
			?>

			<tr>
				<td><?= $r['dept_name']; ?></td>
				<td><?= $r['joined_between']; ?></td>
				<td><?= $r['relieved_between']; ?></td>
				<td><?= $r['total_emp']; ?></td>
				<td><?= round($r['salary_amt']); ?></td>
				<td><?= $r['total_staff']; ?></td>
				<td><?= $r['total_tech']; ?></td>
				<td><?= $r['total_male']; ?></td>
				<td><?= $r['total_female']; ?></td>
			</tr>
		<?php
		}

		echo $this->company_total_row($companyTotal);
		echo '</tbody></table></div></div></div></div>';
	}
	function company_total_row($t)
	{
		return '
		<tr style="font-weight:bold;background:#ccc">
			<td>Total</td>
			<td>'.$t['join'].'</td>
			<td>'.$t['resign'].'</td>
			<td>'.$t['emp'].'</td>
			<td>'.round($t['sal']).'</td>
			<td>'.$t['staff'].'</td>
			<td>'.$t['tech'].'</td>
			<td>'.$t['male'].'</td>
			<td>'.$t['female'].'</td>
		</tr>';
	}


	function yearly_salary_graph($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		$att_year = date('Y');
		$att_month = date('m');
		$out1 = $this->emp_total_salary_from_attendance_monthly('All','1',$att_year);
		$out2 = $this->emp_total_salary_from_attendance_monthly('All','2',$att_year);
		$out3 = $this->emp_total_salary_from_attendance_monthly('All','3',$att_year);
		$out4 = $this->emp_total_salary_from_attendance_monthly('All','4',$att_year);
		$out5 = $this->emp_total_salary_from_attendance_monthly('All','5',$att_year);
		$out6 = $this->emp_total_salary_from_attendance_monthly('All','6',$att_year);
		$out7 = $this->emp_total_salary_from_attendance_monthly('All','7',$att_year);
		$out8 = $this->emp_total_salary_from_attendance_monthly('All','8',$att_year);
		$out9 = $this->emp_total_salary_from_attendance_monthly('All','9',$att_year);
		$out10 = $this->emp_total_salary_from_attendance_monthly('All','10',$att_year);
		$out11 = $this->emp_total_salary_from_attendance_monthly('All','11',$att_year);
		$out12 = $this->emp_total_salary_from_attendance_monthly('All','12',$att_year);
		?>
						
						
					<div class="col-md-12">
					<div class="panel panel-<?php echo $div_background_color;?>">
						<div class="panel-heading">
							<h3 class="panel-title">Mothly Salary Chart (Payable Amount)</h3>
						</div>
						<div class="panel-body">
							<div>
								<div id="chart46" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></div>
							</div>
						</div>
					</div>
				</div>

				<script>
					
					var chartDom = document.getElementById('chart46');
					var myChart = echarts.init(chartDom);

					var option = {
						tooltip: { trigger: 'axis' },
						xAxis: {
							type: 'category',
							data: [
								"January","February","March","April","May","June",
								"July","August","September","October","November","December"
							]
						},
						yAxis: { type: 'value' },

						series: [{
							type: 'bar',
							name: 'Payable Amount',
							barWidth: '55%',
							itemStyle: { color: 'rgba(34,186,160,0.8)' },
							label: { show: true, position: 'top' },
							data: [
								<?php if(isset($out1[0]['current_total_ctc_payable'])){echo $out1[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out2[0]['current_total_ctc_payable'])){echo $out2[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out3[0]['current_total_ctc_payable'])){echo $out3[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out4[0]['current_total_ctc_payable'])){echo $out4[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out5[0]['current_total_ctc_payable'])){echo $out5[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out6[0]['current_total_ctc_payable'])){echo $out6[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out7[0]['current_total_ctc_payable'])){echo $out7[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out8[0]['current_total_ctc_payable'])){echo $out8[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out9[0]['current_total_ctc_payable'])){echo $out9[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out10[0]['current_total_ctc_payable'])){echo $out10[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out11[0]['current_total_ctc_payable'])){echo $out11[0]['current_total_ctc_payable'];}else{echo 0;}?>,
								<?php if(isset($out12[0]['current_total_ctc_payable'])){echo $out12[0]['current_total_ctc_payable'];}else{echo 0;}?>
							]
						}]
					};

					myChart.setOption(option);
				</script>
		<?php
	}//function close

	
	function yearly_ot_hours_graph($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		$att_year = date('Y');
		$att_month = date('m');
		$out1 = $this->emp_total_salary_from_attendance_monthly('All','1',$att_year);
		$out2 = $this->emp_total_salary_from_attendance_monthly('All','2',$att_year);
		$out3 = $this->emp_total_salary_from_attendance_monthly('All','3',$att_year);
		$out4 = $this->emp_total_salary_from_attendance_monthly('All','4',$att_year);
		$out5 = $this->emp_total_salary_from_attendance_monthly('All','5',$att_year);
		$out6 = $this->emp_total_salary_from_attendance_monthly('All','6',$att_year);
		$out7 = $this->emp_total_salary_from_attendance_monthly('All','7',$att_year);
		$out8 = $this->emp_total_salary_from_attendance_monthly('All','8',$att_year);
		$out9 = $this->emp_total_salary_from_attendance_monthly('All','9',$att_year);
		$out10 = $this->emp_total_salary_from_attendance_monthly('All','10',$att_year);
		$out11 = $this->emp_total_salary_from_attendance_monthly('All','11',$att_year);
		$out12 = $this->emp_total_salary_from_attendance_monthly('All','12',$att_year);
		?>
						<div class="col-md-12">
							<div class="panel panel-<?php echo $div_background_color;?>">
								<div class="panel-heading">
									<h3 class="panel-title">Mothly O.T Chart (Hours)</h3>
								</div>
								<div class="panel-body">
									<div>
										<div id="chart47" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></div>
									</div>
								</div>
							</div>
						</div>
						

						<script>
					
							var chartDom = document.getElementById('chart47');
							var myChart = echarts.init(chartDom);

							var option = {
								tooltip: { trigger: 'axis' },
								xAxis: {
									type: 'category',
									data: [
										"January","February","March","April","May","June",
										"July","August","September","October","November","December"
									]
								},
								yAxis: { type: 'value' },

								series: [{
									type: 'bar',
									name: 'Payable Amount',
									barWidth: '55%',
									itemStyle: { color: 'red' },
									label: { show: true, position: 'top' },
									data: [
										<?php if(isset($out1[0]['total_ot'])){echo round($out1[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out2[0]['total_ot'])){echo round($out2[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out3[0]['total_ot'])){echo round($out3[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out4[0]['total_ot'])){echo round($out4[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out5[0]['total_ot'])){echo round($out5[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out6[0]['total_ot'])){echo round($out6[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out7[0]['total_ot'])){echo round($out7[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out8[0]['total_ot'])){echo round($out8[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out9[0]['total_ot'])){echo round($out9[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out10[0]['total_ot'])){echo round($out10[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out11[0]['total_ot'])){echo round($out11[0]['total_ot']);}else{echo 0;}?>,
														<?php if(isset($out12[0]['total_ot'])){echo round($out12[0]['total_ot']);}else{echo 0;}?>
									]
								}]
							};

							myChart.setOption(option);
						</script>
		<?php
	}//function close

	function emp_join_monthly($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		//$att_year = date('Y');
		//$att_month = date('m');

		//total join
		$day1=date("Y-01-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out1=$this->get_all_emp_list($where); // month 1
		$day1=date("Y-02-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out2=$this->get_all_emp_list($where); // month 2
		$day1=date("Y-03-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out3=$this->get_all_emp_list($where); // month 3
		$day1=date("Y-04-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out4=$this->get_all_emp_list($where); // month 4
		$day1=date("Y-05-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out5=$this->get_all_emp_list($where); // month 5
		$day1=date("Y-06-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out6=$this->get_all_emp_list($where); // month 6
		$day1=date("Y-07-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out7=$this->get_all_emp_list($where); // month 7
		$day1=date("Y-08-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out8=$this->get_all_emp_list($where); // month 8
		$day1=date("Y-09-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out9=$this->get_all_emp_list($where); // month 9
		$day1=date("Y-10-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out10=$this->get_all_emp_list($where); // month 10
		$day1=date("Y-11-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out11=$this->get_all_emp_list($where); // month 11
		$day1=date("Y-12-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  doj between '$day1' and '$day2' ";$out12=$this->get_all_emp_list($where); // month 12

		
		$total = round($out1+$out2+$out3+$out4+$out5+$out6+$out7+$out8+$out9+$out10+$out11+$out12);
		$avg = round($total/date('m'));
		?>
						
						
						

						<div class="col-md-12">
							<div class="panel panel-<?php echo $div_background_color;?>">
								<div class="panel-heading">
									<h3 class="panel-title">Employee New Join <?php echo date('Y');?> in nos</h3>
								</div>
								<div class="panel-body">
									<div>
										<div id="chart50" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></div>
									</div>
									Total : <?php echo $total ;?>, Avg : <?php echo $avg ;?>
								</div>
							</div>
						</div>
						

						<script>
					
							var chartDom = document.getElementById('chart50');
							var myChart = echarts.init(chartDom);

							var option = {
								tooltip: { trigger: 'axis' },
								xAxis: {
									type: 'category',
									data: [
										"January","February","March","April","May","June",
										"July","August","September","October","November","December"
									]
								},
								yAxis: { type: 'value' },

								series: [{
									type: 'bar',
									name: 'Payable Amount',
									barWidth: '55%',
									itemStyle: { color: 'rgba(34,186,160,0.8)' },
									label: { show: true, position: 'top' },
									data: [
											<?php if(!empty($out1)){echo $out1;}else{echo 0;}?>,
											<?php if(!empty($out2)){echo $out2;}else{echo 0;}?>,
											<?php if(!empty($out3)){echo $out3;}else{echo 0;}?>,
											<?php if(!empty($out4)){echo $out4;}else{echo 0;}?>,
											<?php if(!empty($out5)){echo $out5;}else{echo 0;}?>,
											<?php if(!empty($out6)){echo $out6;}else{echo 0;}?>,
											<?php if(!empty($out7)){echo $out7;}else{echo 0;}?>,
											<?php if(!empty($out8)){echo $out8;}else{echo 0;}?>,
											<?php if(!empty($out9)){echo $out9;}else{echo 0;}?>,
											<?php if(!empty($out10)){echo $out10;}else{echo 0;}?>,
											<?php if(!empty($out11)){echo $out11;}else{echo 0;}?>,
											<?php if(!empty($out12)){echo $out12;}else{echo 0;}?>
									]
								}]
							};

							myChart.setOption(option);
						</script>
		<?php
	}//function close

	function emp_attrition_monthly($div_background_color,$height,$width,$g_color1,$g_color2)
	{
		//$att_year = date('Y');
		//$att_month = date('m');

		//getting resign
		$day1=date("Y-01-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out1=$this->get_all_emp_list($where); // month 1
		$day1=date("Y-02-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out2=$this->get_all_emp_list($where); // month 2
		$day1=date("Y-03-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out3=$this->get_all_emp_list($where); // month 3
		$day1=date("Y-04-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out4=$this->get_all_emp_list($where); // month 4
		$day1=date("Y-05-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out5=$this->get_all_emp_list($where); // month 5
		$day1=date("Y-06-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out6=$this->get_all_emp_list($where); // month 6
		$day1=date("Y-07-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out7=$this->get_all_emp_list($where); // month 7
		$day1=date("Y-08-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out8=$this->get_all_emp_list($where); // month 8
		$day1=date("Y-09-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out9=$this->get_all_emp_list($where); // month 9
		$day1=date("Y-10-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out10=$this->get_all_emp_list($where); // month 10
		$day1=date("Y-11-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out11=$this->get_all_emp_list($where); // month 11
		$day1=date("Y-12-01");$day2 = date('Y-m-t',strtotime($day1));$where = "  dor between '$day1' and '$day2' ";$out12=$this->get_all_emp_list($where); // month 12

		
		//total join
		//$where = " company_role='$company_role_id' and doj between '$day1' and '$today' ";
		//$emp_total_join =$this->get_all_emp_list($where);

		$total = round($out1+$out2+$out3+$out4+$out5+$out6+$out7+$out8+$out9+$out10+$out11+$out12);
		$avg = round($total/date('m'));
		?>
						
						
								
								
						<div class="col-md-12">
							<div class="panel panel-<?php echo $div_background_color;?>">
								<div class="panel-heading">
									<h3 class="panel-title">Employee Attrition <?php echo date('Y');?> in nos</h3>
								</div>
								<div class="panel-body">
									<div>
										<div id="chart51" style="height:<?php echo $height;?>; width:<?php echo $width;?>;"></div>
									</div>
									Total : <?php echo $total ;?>, Avg : <?php echo $avg ;?>
								</div>
							</div>
						</div>

						<script>
					
							var chartDom = document.getElementById('chart51');
							var myChart = echarts.init(chartDom);

							var option = {
								tooltip: { trigger: 'axis' },
								xAxis: {
									type: 'category',
									data: [
										"January","February","March","April","May","June",
										"July","August","September","October","November","December"
									]
								},
								yAxis: { type: 'value' },

								series: [{
									type: 'bar',
									name: 'Payable Amount',
									barWidth: '55%',
									itemStyle: { color: 'red' },
									label: { show: true, position: 'top' },
									data: [
											<?php if(!empty($out1)){echo $out1;}else{echo 0;}?>,
												<?php if(!empty($out2)){echo $out2;}else{echo 0;}?>,
												<?php if(!empty($out3)){echo $out3;}else{echo 0;}?>,
												<?php if(!empty($out4)){echo $out4;}else{echo 0;}?>,
												<?php if(!empty($out5)){echo $out5;}else{echo 0;}?>,
												<?php if(!empty($out6)){echo $out6;}else{echo 0;}?>,
												<?php if(!empty($out7)){echo $out7;}else{echo 0;}?>,
												<?php if(!empty($out8)){echo $out8;}else{echo 0;}?>,
												<?php if(!empty($out9)){echo $out9;}else{echo 0;}?>,
												<?php if(!empty($out10)){echo $out10;}else{echo 0;}?>,
												<?php if(!empty($out11)){echo $out11;}else{echo 0;}?>,
												<?php if(!empty($out12)){echo $out12;}else{echo 0;}?>
									]
								}]
							};

							myChart.setOption(option);
						</script>
						
						
		<?php
	}//function close


	public function get_celebrations()
	{
		$company_id = $this->session->userdata('company_id');
		$today = date('m-d');

		$query = "SELECT 
				E.emp_code,
				E.first_name,
				E.profile_pic,
				E.dob,
				E.date_of_marriage,
				D.name AS department,
				R.name AS designation
			FROM employee AS E
			LEFT JOIN department AS D 
				ON D.department_id = E.department_id
			LEFT JOIN department_role AS R 
				ON R.role_id = E.role_in_department
			WHERE 
				E.active = 'Active'
				AND E.company_id='$company_id'
				AND E.attendance_entry = '0'
				AND E.owner < 1
				AND (
					DATE_FORMAT(E.dob,'%m-%d') = '$today'
					OR DATE_FORMAT(E.date_of_marriage,'%m-%d') = '$today'
				)
		";

		$res = $this->Mymodel->query1($query);
			if(!empty($res)){
				?>
					
		<div class="card shadow-sm">

			<!-- CARD HEADER -->
			<div class="card-header  py-2 d-flex align-items-center justify-content-between" >
				<span>🎉 Today’s Celebrations</span>

				<div class="btn-group btn-group-sm">
					<!-- <button class="btn btn-warning" onclick="sendMessageAll()">SMS</button>
					<button class="btn btn-success" onclick="sendWhatsAppAll()">WhatsApp</button> -->
					<button class="btn btn-dark" onclick="sendEmailAll()">Send Mail</button>
				</div>
			</div>

			<div class="card-body p-2 celebration-box">

				<?php foreach($res as $row): ?>

				<?php
					// decide type
					$type = '';
					if(date('m-d',strtotime($row['dob'])) == $today){
						$type = 'birthday';
						$icon = '🎂';
					}else{
						$type = 'anniversary';
						$icon = '💍';
					}

					// initials fallback
					$nameParts = explode(' ', $row['first_name']);
					$initials = strtoupper(
						substr($nameParts[0],0,1) .
						(isset($nameParts[1]) ? substr($nameParts[1],0,1) : '')
					);
				?>

				<div class="celebration-row <?= $type ?>">

					<div class="avatar">
						<?php if(!empty($row['profile_pic'])): ?>
							<img src="<?= base_url().'pic/employee/dp/'.$row['profile_pic'] ?>">
						<?php else: ?>
							<span><?= $initials ?></span>
						<?php endif; ?>
					</div>

					<div class="info">
						<div class="name"><?= $row['first_name'] ?></div>
						<div class="meta">
							<?= $row['emp_code'] ?> |
							<?= $row['department'] ?> |
							<?= $row['designation'] ?>
						</div>
					</div>

					<div class="icon"><?= $icon ?></div>

				</div>

				<?php endforeach; ?>

			</div>
		</div>
	
	<?php
		}
	}

	
	
	
	public function get_late_widgets_data($date)
	{
		$company_id = $this->session->userdata('company_id');
		// 1️⃣ Attendance based counts
		$att = $this->db->query("
			SELECT
				SUM(in_status = 'L')                       AS late_in,
				SUM(out_status = 'E')                      AS early_out,
				SUM(full_day_duty = 'H')                   AS half_day,
				SUM(in_time IS NULL OR out_time IS NULL)   AS missing_punch
			FROM daily_attendance
			WHERE DATE(shift_in_time) = ? AND company_id=?
		", [$date,$company_id])->row_array();

		// 2️⃣ Approved Leave on date
		$approved_leave = $this->db->query("
			SELECT COUNT(DISTINCT emp_code) cnt
			FROM emp_leave
			WHERE status = 'Approve' AND company_id=?
			AND ? BETWEEN approve_from_date AND approve_to_date
		", [$company_id,$date])->row()->cnt ?? 0;

		// 3️⃣ Unapproved Leave
		// Rule: Absent + no approved leave
		$unapproved_leave = $this->db->query("
			SELECT COUNT(DISTINCT d.emp_code) cnt
			FROM daily_attendance d
			LEFT JOIN emp_leave l
				ON d.emp_code = l.emp_code
				AND l.status = 'Approve'
				AND ? BETWEEN l.approve_from_date AND l.approve_to_date
			WHERE DATE(d.shift_in_time) = ?
			AND l.company_id=?
			AND d.in_status = 'A'
			AND l.id IS NULL
		", [$date,$company_id, $date])->row()->cnt ?? 0;

		$habitual_late = $this->Hrmodel->get_habitual_late_count($date);


		return [
			'late_in'          => (int)$att['late_in'],
			'early_out'        => (int)$att['early_out'],
			'approved_leave'   => (int)$approved_leave,
			'unapproved_leave' => (int)$unapproved_leave,
			'half_day'         => (int)$att['half_day'],
			'missing_punch'    => (int)$att['missing_punch'],
			'habitual_late' => $habitual_late
		];
	}

	public function get_habitual_late_count($date)
	{
		$company_id = $this->session->userdata('company_id');
		/*
			Habitual Late:
			Employee jiske last 7 days me
			in_status = 'L' at least 3 baar ho
		*/

		$sql = "
			SELECT COUNT(*) AS total
			FROM (
				SELECT emp_code
				FROM daily_attendance
				WHERE in_status = 'L' AND company_id=?
				AND DATE(shift_in_time) BETWEEN DATE_SUB(?, INTERVAL 6 DAY) AND ?
				GROUP BY emp_code
				HAVING COUNT(*) >= 3
			) t
		";

		$q = $this->db->query($sql, [$company_id, $date, $date]);
		$row = $q->row_array();

		return (int) ($row['total'] ?? 0);
	}

	public function modal_habitual_late($date)
	{
		$company_id = $this->session->userdata('company_id');
		return $this->db->query("
			SELECT 
				d.emp_code,
				e.bio_code,
				e.first_name,
				dept.name AS department,
				role.name AS designation,

				COUNT(*) AS late_count,
				MIN(DATE(d.shift_in_time)) AS from_date,
				MAX(DATE(d.shift_in_time)) AS to_date,

				'Habitual Late (≥3 times in last 7 days)' AS remark

			FROM daily_attendance d
			JOIN employee e 
				ON e.emp_code = d.emp_code
			LEFT JOIN department dept 
				ON dept.department_id = e.department_id
			LEFT JOIN department_role role 
				ON role.role_id = e.role_in_department

			WHERE d.in_status = 'L' AND d.company_id=?
			AND DATE(d.shift_in_time)
				BETWEEN DATE_SUB(?, INTERVAL 6 DAY) AND ?

			GROUP BY 
				d.emp_code,
				e.bio_code,
				e.first_name,
				dept.name,
				role.name

			HAVING COUNT(*) >= 3
			ORDER BY late_count DESC
		", [$company_id,$date, $date])->result_array();
	}


	public function modal_late_in($date)
	{
		$company_id = $this->session->userdata('company_id');
		return $this->db->query("
			SELECT 
				d.emp_code,
				e.bio_code,
				e.first_name,
				dept.name AS department,
				role.name AS designation,

				d.shift,
				TIME(d.shift_in_time) AS shift_in_time,
				TIME(d.in_time)       AS actual_in_time,
				d.in_min_late_early   AS late_minutes,

				DATE(d.shift_in_time) AS att_date,
				'Late In' AS remark

			FROM daily_attendance d
			JOIN employee e 
				ON e.emp_code = d.emp_code
			LEFT JOIN department dept 
				ON dept.department_id = e.department_id
			LEFT JOIN department_role role 
				ON role.role_id = e.role_in_department

			WHERE d.in_status = 'L' AND d.company_id=?
			AND DATE(d.shift_in_time) = ?

			ORDER BY d.in_min_late_early DESC
		", [$company_id,$date])->result_array();
	}

	public function modal_early_out($date)
	{
		$company_id = $this->session->userdata('company_id');
		return $this->db->query("
			SELECT 
				d.emp_code,
				e.bio_code,
				e.first_name,
				dept.name AS department,
				role.name AS designation,

				d.shift,
				TIME(d.shift_out_time2) AS shift_out_time,
				TIME(d.out_time)       AS actual_out_time,
				d.out_min_late_early   AS early_minutes,

				DATE(d.shift_in_time) AS att_date,
				'Early Out' AS remark

			FROM daily_attendance d
			JOIN employee e 
				ON e.emp_code = d.emp_code
			LEFT JOIN department dept 
				ON dept.department_id = e.department_id
			LEFT JOIN department_role role 
				ON role.role_id = e.role_in_department

			WHERE d.out_status = 'E' AND d.company_id=?
			AND DATE(d.shift_in_time) = ?

			ORDER BY d.out_min_late_early DESC
		", [$company_id,$date])->result_array();
	}

	public function modal_half_day($date)
	{
		$company_id = $this->session->userdata('company_id');
		return $this->db->query("
			SELECT 
				d.emp_code,
				e.bio_code,
				e.first_name,
				dept.name AS department,
				role.name AS designation,

				d.shift,
				d.duty_hours,
				DATE(d.shift_in_time) AS att_date,
				'Half Day' AS remark

			FROM daily_attendance d
			JOIN employee e 
				ON e.emp_code = d.emp_code
			LEFT JOIN department dept 
				ON dept.department_id = e.department_id
			LEFT JOIN department_role role 
				ON role.role_id = e.role_in_department

			WHERE d.full_day_duty = 'H' AND d.company_id=?
			AND DATE(d.shift_in_time) = ?
		", [$company_id,$date])->result_array();
	}


	public function modal_approved_leave($date)
	{
		$company_id = $this->session->userdata('company_id');
		return $this->db->query("
			SELECT 
				l.emp_code,
				e.bio_code,
				e.first_name,
				dept.name AS department,
				role.name AS designation,
				e.mob,
				e.email,
				'Approved Leave' AS remark
			FROM emp_leave l
			JOIN employee e ON e.emp_code = l.emp_code
			LEFT JOIN department dept ON dept.department_id = e.department_id
			LEFT JOIN department_role role ON role.role_id = e.role_in_department
			WHERE l.status = 'Approve' AND l.company_id= ?
			AND ? BETWEEN l.approve_from_date AND l.approve_to_date
		", [$company_id,$date])->result_array();
	}
	public function modal_unapproved_leave($date)
	{
		$company_id = $this->session->userdata('company_id');
		return $this->db->query("
			SELECT 
				d.emp_code,
				e.bio_code,
				e.first_name,
				dept.name AS department,
				role.name AS designation,
				e.mob,
				e.email,
				'Absent without approval' AS remark
			FROM daily_attendance d
			JOIN employee e ON e.emp_code = d.emp_code
			LEFT JOIN emp_leave l 
				ON l.emp_code = d.emp_code
				AND l.status = 'Approve'
				AND ? BETWEEN l.approve_from_date AND l.approve_to_date
			LEFT JOIN department dept ON dept.department_id = e.department_id
			LEFT JOIN department_role role ON role.role_id = e.role_in_department
			WHERE DATE(d.shift_in_time) = ? AND d.company_id= ?
			AND d.in_status = 'A'
			AND l.id IS NULL
		", [$date,$company_id, $date])->result_array();
	}
	public function get_habitual_late_breakdown($emp_code, $date)
	{
		$company_id = $this->session->userdata('company_id');
		return $this->db->query("
			SELECT
				DATE(d.shift_in_time) AS att_date,
				d.shift,
				TIME(d.shift_in_time) AS shift_in,
				TIME(d.in_time)       AS in_time,
				d.in_min_late_early,
				d.in_status
			FROM daily_attendance d
			WHERE d.emp_code = ? AND d.company_id= ?
			AND d.in_status = 'L'
			AND DATE(d.shift_in_time)
				BETWEEN DATE_SUB(?, INTERVAL 6 DAY) AND ?
			ORDER BY d.shift_in_time DESC
		", [$emp_code,$company_id, $date, $date])->result_array();
	}






    

	
	
}//class close



