<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hr extends CI_Controller {

	public function __construct() 
	{
        parent::__construct();
		$this->load->model('Base');
		
		$user_email=$this->session->userdata('login_username');
		if(!$user_email>0){redirect('welcome/');}
	}//function close

	public function index()
	{
		redirect("welcome/");
	}//function close


	public function delete_emp_punch()
	{
		$company_id = $this->session->userdata('company_id');	
		if (empty($_REQUEST['emp_code']) && empty($_REQUEST['date_time']) ) return;
		$emp_code = $_REQUEST['emp_code'];
		$date_time = $this->Base->change_date_ymd($_REQUEST['date_time']);

		$where2 = " company_id = '$company_id' and emp_code='$emp_code' and  (shift_in_time like '%$date_time%' OR shift_out_time like '%$date_time%') ";
		$this->Mymodel->deletedata('daily_attendance',$where2);
	}


	
	//product_autocomplate_search 
	public function op_autocomplate_search()
	{
		$name =$_REQUEST['term'];
		echo  json_encode($this->Hrmodel->op_autocomplate_search_via_name($name));
	}//function close



	

	//check email Available
	public function fun_check_email()
	{
		$email=$_REQUEST['email'];
		if($this->Hrmodel->fun_check_email($email) == "TRUE"){echo "$email already exist."; }
	}//function close

	
	//check emp code Available
	public function fun_check_emp_code()
	{
		$emp_code=$_REQUEST['id'];
		if($this->Hrmodel->fun_check_emp_code($emp_code) == "TRUE"){echo "$emp_code already exist.";} 
	}//function close

	public function fun_check_bio_code()
	{
		$code=$_REQUEST['id'];
		if($this->Hrmodel->fun_check_bio_code($code) == "TRUE"){echo "$code already exist.";} 
	}//function close


	//Next Emp code via contract_code
	public function get_next_emp_code()
	{
		$company_id = $this->session->userdata('company_id');  
		// Use CI input only
		$company_role = trim($this->input->post('company_role'));

		if ($company_role === '') {
			echo json_encode(['error' => 'Company role missing']);
			return;
		}

		/* ================== FETCH PLANT / CONTRACTOR ================== */
		$plant = $this->db
			->where('name', $company_role)
			->where('company_id', $company_id)
			->get('contractor_code')
			->row_array();

		if (!$plant) {
			echo json_encode(['error' => 'Invalid company role']);
			return;
		}

		// If auto empcode disabled → return blank (this is correct)
		if ($plant['autoEmpcode_status'] !== 'Yes') {
			echo json_encode(['emp_code' => '']);
			return;
		}

		$prefix        = $plant['empcode_start'];   // TZ / TKZ
		$start         = (int) $plant['pay_code_start'];
		$end           = (int) $plant['pay_code_end']; // 0 or NULL = unlimited
		$manpowerLimit = (int) $plant['manpower_limit'];

		/* ================== MANPOWER CHECK ================== */
		$activeCount = $this->db
			->where('company_role', $company_role)
			->where('company_id', $company_id)
			->where('status', 'Active')
			->where('owner <', 1)
			->count_all_results('employee');

		$warnings = [];

		if ($manpowerLimit > 0 && $activeCount >= $manpowerLimit) {
			$warnings[] = 'Manpower limit exceeded';
		}

		/* ================== GET LAST EMP CODE ================== */
		$lastEmp = $this->db
			->select('emp_code')
			->where('company_role', $company_role)
			->where('company_id', $company_id)
			->like('emp_code', $prefix, 'after')
			->order_by('LENGTH(emp_code)', 'DESC', false)
			->order_by('emp_code', 'DESC')
			->limit(1)
			->get('employee')
			->row_array();

		if ($lastEmp) {
			$lastNumber = (int) preg_replace('/[^0-9]/', '', $lastEmp['emp_code']);
			$nextNumber = $lastNumber + 1;
		} else {
			$nextNumber = $start > 0 ? $start : 1;
		}

		/* ================== RANGE CHECK ================== */
		if ($start > 0 && $nextNumber < $start) {
			$nextNumber = $start;
		}

		if ($end > 0 && $nextNumber > $end) {
			$warnings[] = 'Empcode exceeds allowed range';
		}

		$nextEmpCode = $prefix . $nextNumber;

		/* ================== FINAL RESPONSE ================== */
		$response = [
			'emp_code' => $nextEmpCode,
			'info'     => 'OK'
		];

		if (!empty($warnings)) {
			$response['warning'] = implode(' | ', $warnings);
		}

		echo json_encode($response);
	}



	//emp name des dept
	public function get_emp_basic_details_form_emp_code()
	{
		$fieldname = $_REQUEST['fieldname'];
		if(!empty($_REQUEST['code'])){$code = $_REQUEST['code'];}else{$code=$fieldname;}

		if($fieldname  == 'emp_code'){
			$res = $this->Hrmodel->get_emp_details_with_emp_code($code);
		}else if($fieldname  == 'bio_code'){
			$res = $this->Hrmodel->get_emp_details_with_bio_code($code);
		}else{
			$res = $this->Hrmodel->get_emp_details_with_emp_code($fieldname);
		}
		

		if(!empty($res))
		{
			$id  = $res[0]['id'];
			$name  = $res[0]['first_name'].' '.$res[0]['last_name'];
			$department_name = $this->Base->get_name_form_dept_id($res[0]['department_id']);
			$role_name = $this->Base->get_name_form_role_id($res[0]['role_in_department']);
			echo $name.'~'.$department_name.'~'.$role_name.'~'.$id.'~'.$res[0]['company_role'].'~'.$res[0]['working_hr'].'~'.$res[0]['shift_status'].'~'.$res[0]['current_shift'].'~'.$res[0]['get_overtime'].'~'.$res[0]['father_name'].'~'.$res[0]['mob'].'~'.$res[0]['present_address'].'~'.$res[0]['permanent_address'].'~'.$res[0]['department_id'].'~'.$res[0]['role_in_department'].'~'.$res[0]['bio_code'].'~'.$res[0]['emp_code'];
		}
	}//function close


	//attendance entry single
	public function get_employee_attendance_date_wise()
	 {
		$company_id = $this->session->userdata('company_id');
		if(isset($_REQUEST['emp_id']))
		{
			$emp_code=$_REQUEST['emp_id'];
			$m=$_REQUEST['month_search'];
			$y=$_REQUEST['year_search'];

			//Employee details
			$out1 = $this->Hrmodel->get_active_emp_details_with_emp_code($emp_code);
			if(!empty($out1))
			{
				$emp_id = $out1[0]['id'];
				$late_punch_add = $out1[0]['late_punch_add'];
				
				// //check attendance lock or not
				$rem_date = date('Y-m-d', strtotime("$y-$m-01"));
				$lock = $this->Base->atten_lock_check($rem_date,$emp_id);
				if($lock) {
					echo "Attendance for this month and year is locked and cannot be modified for this $emp_code"; exit;
				}


				if($late_punch_add == "Yes"){
					?><h6 style="color:blue">Add Extra time in days</h6><?php 
				}
			?>
				
				<h2 align='center' style="color:red;font-weight:bold;"><?php if(isset($out1))echo $out1[0]['first_name'].' '.$out1[0]['last_name'];?></h2>
				
			
				<table border="1" width="100%" class="table-hover">
					<tr>
						<th width="50">Date</th>
						<th>Attendance</th>
						<th>O.T.</th>
						<th>In Time</th>
						<th>Out Time</th>
						<th>Shift</th>
						<th>Total Hrs</th>
						<th>Total Min</th>
						<th style="color:blue">Total Min M/C</th>
						<th>Remarks</th>
					</tr>
					<?php
					
					$test = new DateTime("$y-$m-01");
					$last_date= date_format($test, 't'); 
					$total_present = 0;
					$total_min = 0;
					$total_min2 = 0;
					$total_hrs = 0;
					for($i=1;$i<=$last_date;$i++)
                    {
                        $test = new DateTime("$i-$m-$y");
						$new_date = date_format($test, 'Y-m-d');
						$m1= date_format($test, 'm');
						$y1= date_format($test, 'Y');
						

						//attndance
						$column_atten = "d$i";
						$column_ot = "o$i";
						$out=$this->Hrmodel->get_atten_table_column($emp_id,$y1,$m1,$column_atten,$column_ot);
						if(!empty($out))
						{
							$emp_at_day1 = $out[0]['emp_at_day'];
							$emp_ot_day1 = $out[0]['emp_ot_day'];
							$total_present = $out[0]['total_present'];
							
							
							//print_r($out);
							if($emp_at_day1 == "P"){$bg_color="background-color:green;color:white;";}
							elseif($emp_at_day1 == "A"){$bg_color="background-color:red;color:white;";}
							elseif($emp_at_day1 == "HA"){$bg_color="background-color:orange;color:white;";}
							elseif($emp_at_day1 == "HL"){$bg_color="background-color:pink;color:white;";}
							elseif($emp_at_day1 == "L"){$bg_color="background-color:red;color:white;";}
							elseif($emp_at_day1 == "S"){$bg_color="background-color:blue;color:white;";}
							elseif($emp_at_day1 == "H"){$bg_color="background-color:yellow;color:black;";}
							elseif($emp_at_day1 == "R" or $emp_at_day1 == "SL" or $emp_at_day1 == "CL" or $emp_at_day1 == "EL" or $emp_at_day1 == "OL" or $emp_at_day1 == "T"){$bg_color="background-color:purple;color:white;";}
							else{$bg_color="background-color:white;color:black;";}
						}

						//in out time
						$query=" SELECT id,in_time,out_time,shift,in_time_mc,out_time_mc,save_from,duty_type,extra_min,duty_hours,dutyMin FROM daily_attendance where  company_id='$company_id' and emp_code='$emp_code' and shift_in_time between '$new_date 00:00:00' and '$new_date 23:59:59' ORDER BY shift_in_time DESC  LIMIT 1 ";
						$last_entry = $this->Mymodel->query1($query);
						if(!empty($last_entry))
						{
							$attenid1 = $last_entry[0]['id'];
							if($last_entry[0]['in_time'] != '0000-00-00 00:00:00'){ $intime1= $this->Base->change_time_His($last_entry[0]['in_time']);}else{$intime1='';}
							if($last_entry[0]['out_time'] != '0000-00-00 00:00:00'){ $outtime1= $this->Base->change_time_His($last_entry[0]['out_time']);}else{$outtime1='';}
							if($last_entry[0]['shift'] == 'General'){ $shift1="G";}else{$shift1=$last_entry[0]['shift'];}
							//print_r($last_entry);
							if(!empty($last_entry[0]['duty_hours'])){$duty_hours =(float)$last_entry[0]['duty_hours'];}else{$duty_hours = 0;}
							$minutes = (int)$last_entry[0]['dutyMin']; // invalid data safety
							
							
							if (
								!empty($last_entry[0]['in_time']) &&
								!empty($last_entry[0]['out_time']) &&
								$last_entry[0]['in_time'] != '0000-00-00 00:00:00' &&
								$last_entry[0]['out_time'] != '0000-00-00 00:00:00'
							) {
								

								 $in  = strtotime($last_entry[0]['in_time']);
								 $out = strtotime($last_entry[0]['out_time']);

								if ($out > $in) {
									$minutes2 = ($out - $in) / 60;
									
								}else{
									$minutes2 =0;
								}

							}

						}
						else
						{
							$attenid1 = '';
							$intime1='';
							$outtime1='';
							$intimemc1='';
							$outtimemc1='';
							//$shift1 = "";
							$minutes=0;
							$minutes2=0;
							$duty_hours=0;
							$emp_at_day1='';
						}

						
						// H => 8 hours , same in pa&ot report and HRmodel salary add
						if($late_punch_add == "Yes" && $emp_at_day1 == "H"){
							$duty_hours = 8;
							$minutes2 = round($duty_hours*60);
						}
						
						$total_min += $minutes;//mchine min add
						$total_min2 +=(int)$minutes2;
						$total_hrs += $duty_hours;//add 
						
						$bgColor='black';
						if(!empty($minutes2) and empty($duty_hours)){
							$bgColor='red';
						}

						?>
							<tr style="min-height:25px">
									<td><?php echo $i;?></td>
									<td style="width:110px"><input type="text" class="form-control emp_entry_at" id="dayentry_<?php echo $i;?>" onkeyup="checkvalidation(this.id); addPresent();"  max="2" maxlength="2" style="<?php if(isset($bg_color))echo $bg_color;?>"  name="d1[]"   autocomplete="off" value="<?php if(isset($emp_at_day1))echo $emp_at_day1;?>"></td>
									<td style="width:110px"><input type="text" class="form-control emp_entry_ot" id="otentry_<?php echo $i;?>" onkeyup="checkvalidation2(this.id)"  max="4" maxlength="4" style="<?php //if(isset($bg_color))echo $bg_color;?>"  name="o1[]"   autocomplete="off" value="<?php if(isset($emp_ot_day1))echo $emp_ot_day1;?>"></td>
									
									<td style="width:100px"><input type="time" class="form-control intime" id="intime_<?php echo $i;?>"    name="intime[]"   autocomplete="off" value="<?php if(isset($intime1) and $intime1 != '00:00:00')echo $intime1;?>"></td>
									
									<td style="width:100px"><input type="time" class="form-control outtime" id="outtime_<?php echo $i;?>"     name="outtime[]"   autocomplete="off" value="<?php if(isset($outtime1) and $outtime1 != '00:00:00')echo $outtime1;?>"></td>

									<td style="width:80px"><input type="text" class="form-control shift" id="shift_<?php echo $i;?>" onkeyup="checkvalidation4(this.id)"     name="shift[]"   autocomplete="off" value="<?php if(isset($shift1))echo $shift1;?>"></td>
									
									
									<input type="hidden" class="form-control attenid" id="attenid_<?php echo $i;?>"     name="attenid[]"  value="<?php if(isset($attenid1))echo $attenid1;?>">
									
									<input type="hidden" class="form-control intimemc" id="intimemc_<?php echo $i;?>"    name="intimemc[]"   autocomplete="off" value="<?php if(isset($last_entry[0]['in_time_mc']))echo $last_entry[0]['in_time_mc'];?>">
									
									<input type="hidden" class="form-control outtimemc" id="intimemc_<?php echo $i;?>"    name="intimemc[]"   autocomplete="off" value="<?php if(isset($last_entry[0]['out_time_mc']))echo $last_entry[0]['out_time_mc'];?>">

									
									<td style="width:100px"><input type="text" class="form-control sysHrs" id="sysHrs_<?php echo $i;?>"     name="sysHrs[]"  value="<?php if($duty_hours > 0) echo $duty_hours;?>" style=" border-color:<?php echo $bgColor;?>"></td>

									<?php 
										$bgColor='black';
										if(!empty($minutes2) and !empty($minutes) and $minutes != $minutes2){
											$bgColor='red';
										}
									?>
									<td style="width:100px"><input type="text" class="form-control sysMin" id="sysMin_<?php echo $i;?>"     name="sysMin[]"  value="<?php if(!empty($minutes2))echo $minutes2;?>" style=" border-color:<?php echo $bgColor;?>"></td>

									<td style="width:100px;"><input type="text" class="form-control mcMin" id="mcMin_<?php echo $i;?>"     name="mcMin[]"  value="<?php if(!empty($minutes))echo $minutes;?>" style=" border-color:blue"></td>
									
									
									<td style="width:100px"><input type="text" class="form-control savefrom" id="savefrom_<?php echo $i;?>"     name="savefrom[]"  value="<?php if(isset($last_entry[0]['save_from']))echo $last_entry[0]['save_from'];?>"></td>
							</tr>
						<?php 
						
						}
						?>
						<tr style="font-size:14px">
							<td></td>
							<td>Total Present : <span id='showTotalPresent'><?php echo $total_present;?></span></td>
							<td></td><td></td><td></td><td></td>
							<td>
								<span id='showTotalsysHrs'><?php echo round($total_hrs,2);?></span>
							</td>
							<td>
								Min: <span id='showTotalsysMin'><?php echo $total_min2;?></span>
								<br>
								Days: <span id='showTotalsysMinDay'>
									<?php 
									if($late_punch_add == "Yes"){
										echo round($total_min2/60/12,1);
									}
									?>
								</span>
							</td>
							<td style='color:blue'><span id='showTotalmcMin'><?php echo $total_min;?></span></td>
						</tr>
						</table>  

						<input type="hidden" id="is_leave_eligible" value="<?php if(!empty($out1[0]['is_leave_eligible'])  && $out1[0]['is_leave_eligible'] == "Yes"){echo "Yes";}else{echo "No";} ?>">
						<?php 
						if (!empty($out1[0]['is_leave_eligible']) && $out1[0]['is_leave_eligible'] == "Yes") {
							//get total leave in this year
							$where = " and B.emp_code='$emp_code' and a.att_year='$y' ";
							$leave_data = $this->Hrmodel->get_emp_leave_data($where);

							//get leave in this month
							$this_month_use = 0;
							$where = " and B.emp_code='$emp_code' and a.att_year='$y' and a.att_month='$m' ";
							$leave_this_month = $this->Hrmodel->get_emp_leave_of_current_month($where);
							//print_r($leave_this_month);
							if (!empty($leave_this_month)) { $this_month_use = (float)$leave_this_month[0]['use_leave_this_month'];} 
								

							if (!empty($leave_data)) {
								$r = $leave_data[0];
							?>
							<input type="hidden" id="base_cl_used" value="<?= $r['total_cl'] - ($leave_this_month[0]['total_cl'] ?? 0) ?>">
							<input type="hidden" id="base_sl_used" value="<?= $r['total_sl'] - ($leave_this_month[0]['total_sl'] ?? 0) ?>">
							<input type="hidden" id="base_el_used" value="<?= $r['total_el'] - ($leave_this_month[0]['total_el'] ?? 0) ?>">
							<input type="hidden" id="base_total_used" value="<?= $r['use_leave'] - $this_month_use ?>">
									
							<div class="card mt-3">
								<div class="card-body m2">
									<p p-2>Total Leave used in this month: <span id="totalLeaveOfMonth"><?php echo $this_month_use;?></span></p>
									<table class="table table-bordered table-sm mb-0 text-center">
										<thead class="table-light">
											<tr>
												<th>Type</th>
												<th>Allotted</th>
												<th>Used</th>
												<th>Rem</th>
											</tr>
											</thead>

											<tbody>

											<tr>
												<td>CL</td>
												<td id="cl_all"><?= $r['leave_cl'] ?></td>
												<td id="cl_used"><?= $r['total_cl'] ?></td>
												<td id="cl_rem"><?= $r['leave_cl'] - $r['total_cl'] ?></td>
											</tr>

											<tr>
												<td>SL</td>
												<td id="sl_all"><?= $r['leave_sl'] ?></td>
												<td id="sl_used"><?= $r['total_sl'] ?></td>
												<td id="sl_rem"><?= $r['leave_sl'] - $r['total_sl'] ?></td>
											</tr>

											<tr>
												<td>EL</td>
												<td id="el_all"><?= $r['leave_el'] ?></td>
												<td id="el_used"><?= $r['total_el'] ?></td>
												<td id="el_rem"><?= $r['leave_el'] - $r['total_el'] ?></td>
											</tr>

											
											</tbody>

											<tfoot>
											<tr>
												<th>Total</th>
												<th id="total_all"><?= $r['leave_yearly'] ?></th>
												<th id="total_used"><?= $r['use_leave'] ?></th>
												<th id="total_rem"><?= $r['rem_leave'] ?></th>
											</tr>
											</tfoot>
									</table>
								</div>
							</div>

							<?php 
								} else {
									echo "<div class='alert alert-warning mt-3'>No leave data found.</div>";
								}
							}
						else {
								echo "<div class='alert alert-warning mt-3'>No leave data found.</div>";
							}
						?>
			<?php
			}//employee id
			else{
				echo "<b>Employee id not created/Deactive.<b>";
			}
		}//emp_id
	 }//function close


	//hr all reports search
	public function fun_hr_reports_reports_search()
	{
		$master_roll_access = $this->session->userdata('admin');
		if(!empty($_REQUEST['type_search']) and !empty($_REQUEST['year_search']) and !empty($_REQUEST['month_search']))
		{
			$type_search = $_REQUEST['type_search'];
		
			if(isset($_REQUEST['year_search'])){$year_search = $_REQUEST['year_search'];}else{$year_search = '';}
			if(isset($_REQUEST['month_search'])){$month_search = $_REQUEST['month_search'];}else{$month_search = '';}	

			$link1 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&search=Search&attendance_time=No&canteenShow=No ";
			$link2 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&day_search=11&type2_search=Canteen&search=Search ";
			$link3 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&day_search=11&type2_search=Breakfast&search=Search ";
			$link4 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&search=Search ";
			$link5 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&day_search=11&type2_search=Canteen&search=Search ";

			// if($master_roll_access != 2)
			// {
			?>
				
				<div class="col-md-12" style="margin-top:5px; float:left;"><a  target="_blank" href="<?php echo base_url();?>index.php/Hr/attendance_entry_manual<?php echo $link1;?>"  class="btn btn-success" style="width:100%;" >Attendance & O.T Reports</a></div> 
				<!--
				<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/attendance_other_exp_list<?php echo $link2;?>"  class="btn btn-primary" style="width:100%;" >Canteen Exp. Reports</a></div> 
				<div class="col-md-4" style="margin-top:5px;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/attendance_other_exp_list<?php echo $link3;?>"  class="btn btn-primary" style="width:100%;" >Break Fast Exp. Reports</a></div> 
				-->
				<!-- <div class="col-md-6" style="margin-top:5px; float:left;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report/master/<?php echo $link4;?>&format_type=incentive"  class="btn btn-info" style="width:100%;" >Salary Report New </a></div> -->
				
				<div class="col-md-12" style="margin-top:20px; float:left;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report_1/master/<?php echo $link4;?>"  class="btn btn-info" style="width:100%;" >Master Salary Report </a></div> 
				 

				<!-- <div class="col-md-6" style="margin-top:5px; float:left;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report_1/master_roll/<?php echo $link4;?>&format_type=master_roll"  class="btn btn-primary" style="width:100%;" >Master Roll </a></div>  -->
				
				<!-- <div class="col-md-6" style="margin-top:5px; float:left;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report_1/without_ot/<?php echo $link4;?>&format_type=without_ot"  class="btn btn-primary" style="width:100%;" >Salary Report </a></div> 
				<div class="col-md-6" style="margin-top:5px; float:left;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report_1/incentive/<?php echo $link4;?>&format_type=incentive"  class="btn btn-primary" style="width:100%;" >Incentive Report </a></div>  -->
				
				
				<div class="col-md-12" style="margin-top:20px; float:left;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_day_calculate<?php echo $link4;?>"  class="btn btn-primary" style="width:100%;" >Attendance Generated</a></div> 

				<div class="col-md-12" style="margin-top:20px; float:left;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_generate_entry<?php echo $link4;?>"  class="btn btn-danger" style="width:100%;" >Salary Generated</a></div> 


				<div class="col-md-12" style="margin-top:20px; float:left;"><a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_lock_enable<?php echo $link4;?>"  class="btn btn-warning" style="width:100%;" >Salary permanent Save</a></div> 
				
			<?php
			/*
			}
			else
			{
				?>
				<br>
				<div class="col-md-12" style="margin-top:5px; float:left;">
					<a  target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_report_1/master_roll<?php echo $link4;?>"  class="btn btn-success" style="width:100%;" >Master Roll</a>
				
				</div> 
				<?php
			}//master roll access
			*/
		}//if(isset($_REQUEST['type_search']))
		else
		{
			?> <div class="col-md-4" style="margin-top:5px;"> <?php echo "Please Select Type, Year, Month.";?></div> <?php
		}
	}//function close
	














































	


	//new employee
	public function add_emp()
	{
		$result['state']=$this->Base->get_all_state();
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		$result['shifts']=$this->Base->get_all_active_shifts();
		$result['company_role']=$this->Base->get_all_contractor_code();
		if(strlen($this->uri->segment(3))>0)
		{
			if($this->Company->checkPermission3("Hr/emp_edit_access")){
				$id = $this->uri->segment(3);
				$result['res2'] = $this->Hrmodel->get_emp_deatis_with_id($id);
			}else{
				echo "You have no permission to edit."; return;
			}
			
		}
		$this->load->view('hr/emp/entry',$result);
	}//function close
	


	public function new_emp_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['company_role'])){$company_role=$_REQUEST['company_role'];}else{$company_role='';}
		if(isset($_REQUEST['shift_status'])){$shift_status=$_REQUEST['shift_status'];}else{$shift_status='';}
		if(isset($_REQUEST['current_shift'])){$current_shift=$_REQUEST['current_shift'];}else{$current_shift='';}
		if(isset($_REQUEST['get_overtime'])){$get_overtime=$_REQUEST['get_overtime'];}else{$get_overtime='';}
		if(isset($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];}else{$emp_code='';}
		if(isset($_REQUEST['bio_code'])){$bio_code=$_REQUEST['bio_code'];}else{$bio_code='';}
		if(isset($_REQUEST['plant'])){$plant=$_REQUEST['plant'];}else{$plant='';}
		if(isset($_REQUEST['first_name'])){$first_name=$_REQUEST['first_name'];}else{$first_name='';}
		if(isset($_REQUEST['last_name'])){$last_name=$_REQUEST['last_name'];}else{$last_name='';}
		if(isset($_REQUEST['gender'])){$gender=$_REQUEST['gender'];}else{$gender='';}	
		$pwd = "";
		if(isset($_REQUEST['telphone'])){
			$telphone=$_REQUEST['telphone'];
			$pwd = md5($telphone);
		}else{$telphone='';}
		
		if(isset($_REQUEST['email'])){$email=$_REQUEST['email'];}else{$email='';}	
		if(!empty($_REQUEST['doj'])){$test = new DateTime($_REQUEST['doj']);$doj= date_format($test, 'Y-m-d');}else{$doj='';}	
		if(!empty($_REQUEST['dob'])){$test = new DateTime($_REQUEST['dob']);$dob= date_format($test, 'Y-m-d');}else{$dob='';}	
		if(!empty($_REQUEST['dor'])){$test = new DateTime($_REQUEST['dor']);$dor= date_format($test, 'Y-m-d');}else{$dor='';}	
		if(isset($_REQUEST['age'])){$age=$_REQUEST['age'];}else{$age='';}	
		if(isset($_REQUEST['blood_group'])){$blood_group=$_REQUEST['blood_group'];}else{$blood_group='';}	
		if(isset($_REQUEST['quli'])){$quli=$_REQUEST['quli'];}else{$quli='';}	
		if(isset($_REQUEST['add_quli'])){$add_quli=$_REQUEST['add_quli'];}else{$add_quli='';}	
		if(isset($_REQUEST['last_org'])){$last_org=$_REQUEST['last_org'];}else{$last_org='';}	
		if(isset($_REQUEST['past_exp'])){$past_exp=$_REQUEST['past_exp'];}else{$past_exp='';}	
		if(isset($_REQUEST['pres_exp'])){$pres_exp=$_REQUEST['pres_exp'];}else{$pres_exp='';}	
		if(isset($_REQUEST['total_exp'])){$total_exp=$_REQUEST['total_exp'];}else{$total_exp='';}	
		if(isset($_REQUEST['join_desig'])){$join_desig=$_REQUEST['join_desig'];}else{$join_desig='';}	
		if(isset($_REQUEST['current_desig'])){$current_desig=$_REQUEST['current_desig'];}else{$current_desig='';}	
		if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}else{$dept='';}	
		if(isset($_REQUEST['sub_dept'])){$sub_dept=$_REQUEST['sub_dept'];}else{$sub_dept='';}	
		if(isset($_REQUEST['hod_status'])){$hod_status=$_REQUEST['hod_status'];}else{$hod_status='';}	
		if(isset($_REQUEST['staff_tech'])){$staff_tech=$_REQUEST['staff_tech'];}else{$staff_tech='';}	
		if(isset($_REQUEST['job_respons'])){$job_respons=$_REQUEST['job_respons'];}else{$job_respons='';}	
		if(isset($_REQUEST['payroll_area'])){$payroll_area=$_REQUEST['payroll_area'];}else{$payroll_area='';}	
		if(isset($_REQUEST['join_grade'])){$join_grade=$_REQUEST['join_grade'];}else{$join_grade='';}	
		if(isset($_REQUEST['current_grade'])){$current_grade=$_REQUEST['current_grade'];}else{$current_grade='';}	
		if(!empty($_REQUEST['last_promotion_date'])){$test = new DateTime($_REQUEST['last_promotion_date']);$last_promotion_date= date_format($test, 'Y-m-d');}else{$last_promotion_date='';}	
		if(isset($_REQUEST['ctc_at_join'])){$ctc_at_join=$_REQUEST['ctc_at_join'];}else{$ctc_at_join='';}	
		if(isset($_REQUEST['current_ctc'])){$current_ctc=$_REQUEST['current_ctc'];}else{$current_ctc='';}	
		if(isset($_REQUEST['total_rise_rs'])){$total_rise_rs=$_REQUEST['total_rise_rs'];}else{$total_rise_rs='';}	
		if(isset($_REQUEST['ctc_on_probation'])){$ctc_on_probation=$_REQUEST['ctc_on_probation'];}else{$ctc_on_probation='';}	
		if(isset($_REQUEST['trainee_probn_ctc'])){$trainee_probn_ctc=$_REQUEST['trainee_probn_ctc'];}else{$trainee_probn_ctc='';}	
		if(!empty($_REQUEST['trainee_probation_date'])){$test = new DateTime($_REQUEST['trainee_probation_date']);$trainee_probation_date= date_format($test, 'Y-m-d');}else{$trainee_probation_date='';}	
		
		if(!empty($_REQUEST['due_conf_date'])){$test = new DateTime($_REQUEST['due_conf_date']);$due_conf_date= date_format($test, 'Y-m-d');}else{$due_conf_date='';}	
		if(!empty($_REQUEST['actual_conf_date'])){$test = new DateTime($_REQUEST['actual_conf_date']);$actual_conf_date= date_format($test, 'Y-m-d');}else{$actual_conf_date='';}	
		if(!empty($_REQUEST['date_of_transfer'])){$test = new DateTime($_REQUEST['date_of_transfer']);$date_of_transfer= date_format($test, 'Y-m-d');}else{$date_of_transfer='';}	
		if(!empty($_REQUEST['increment_due_date'])){$test = new DateTime($_REQUEST['increment_due_date']);$increment_due_date= date_format($test, 'Y-m-d');}else{$increment_due_date='';}	
		if(isset($_REQUEST['increment_due_month'])){$increment_due_month=$_REQUEST['increment_due_month'];}else{$increment_due_month='';}	
		if(isset($_REQUEST['plan_name_tranfer'])){$plan_name_tranfer=$_REQUEST['plan_name_tranfer'];}else{$plan_name_tranfer='';}	
		if(isset($_REQUEST['basic_salary'])){$basic_salary=$_REQUEST['basic_salary'];}else{$basic_salary='';}	
		if(isset($_REQUEST['hra'])){$hra=$_REQUEST['hra'];}else{$hra='';}	
		if(isset($_REQUEST['conv'])){$conv=$_REQUEST['conv'];}else{$conv='';}	
		if(isset($_REQUEST['city_comp'])){$city_comp=$_REQUEST['city_comp'];}else{$city_comp='';}	
		if(isset($_REQUEST['other_allow'])){$other_allow=$_REQUEST['other_allow'];}else{$other_allow='';}	
		if(isset($_REQUEST['spl_pay'])){$spl_pay=$_REQUEST['spl_pay'];}else{$spl_pay='';}	
		if(isset($_REQUEST['medi_rem'])){$medi_rem=$_REQUEST['medi_rem'];}else{$medi_rem='';}	
		if(isset($_REQUEST['fuel_reimb'])){$fuel_reimb=$_REQUEST['fuel_reimb'];}else{$fuel_reimb='';}	
		if(isset($_REQUEST['esic'])){$esic=$_REQUEST['esic'];}else{$esic='';}	
		if(isset($_REQUEST['epf'])){$epf=$_REQUEST['epf'];}else{$epf='';}	
		if(isset($_REQUEST['bonus'])){$bonus=$_REQUEST['bonus'];}else{$bonus='';}	
		if(isset($_REQUEST['ex_gratia'])){$ex_gratia=$_REQUEST['ex_gratia'];}else{$ex_gratia='';}	
		if(isset($_REQUEST['old_ex_gratia'])){$old_ex_gratia=$_REQUEST['old_ex_gratia'];}else{$old_ex_gratia='';}	
		if(isset($_REQUEST['current_total_ctc'])){$current_total_ctc=$_REQUEST['current_total_ctc'];}else{$current_total_ctc='';}	
		if(isset($_REQUEST['get_attendance_all'])){$get_attendance_all=$_REQUEST['get_attendance_all'];}else{$get_attendance_all='';}	
		if(isset($_REQUEST['get_el_encashment'])){$get_el_encashment=$_REQUEST['get_el_encashment'];}else{$get_el_encashment='';}	
		if(isset($_REQUEST['get_cl_encashment'])){$get_cl_encashment=$_REQUEST['get_cl_encashment'];}else{$get_cl_encashment='';}	
		if(isset($_REQUEST['get_other1'])){$get_other1=$_REQUEST['get_other1'];}else{$get_other1='';}	
		if(isset($_REQUEST['get_other2'])){$get_other2=$_REQUEST['get_other2'];}else{$get_other2='';}	
		if(isset($_REQUEST['get_other3'])){$get_other3=$_REQUEST['get_other3'];}else{$get_other3='';}	
		if(isset($_REQUEST['get_other4'])){$get_other4=$_REQUEST['get_other4'];}else{$get_other4='';}	
		if(isset($_REQUEST['lost_canteen'])){$lost_canteen=$_REQUEST['lost_canteen'];}else{$lost_canteen='';}	
		if(isset($_REQUEST['lost_breakfast'])){$lost_breakfast=$_REQUEST['lost_breakfast'];}else{$lost_breakfast='';}	
		if(isset($_REQUEST['lost_bus'])){$lost_bus=$_REQUEST['lost_bus'];}else{$lost_bus='';}	
		if(isset($_REQUEST['lost_advance'])){$lost_advance=$_REQUEST['lost_advance'];}else{$lost_advance='';}	
		if(isset($_REQUEST['lost_1'])){$lost_1=$_REQUEST['lost_1'];}else{$lost_1='';}	
		if(isset($_REQUEST['lost_2'])){$lost_2=$_REQUEST['lost_2'];}else{$lost_2='';}	
		if(isset($_REQUEST['lost_3'])){$lost_3=$_REQUEST['lost_3'];}else{$lost_3='';}	
		if(isset($_REQUEST['lost_4'])){$lost_4=$_REQUEST['lost_4'];}else{$lost_4='';}	
		if(isset($_REQUEST['working_hr'])){$working_hr=$_REQUEST['working_hr'];}else{$working_hr='';}	
		if(isset($_REQUEST['epf_code'])){$epf_code=$_REQUEST['epf_code'];}else{$epf_code='';}	
		if(isset($_REQUEST['esi_code'])){$esi_code=$_REQUEST['esi_code'];}else{$esi_code='';}	
		if(isset($_REQUEST['pan_no'])){$pan_no=$_REQUEST['pan_no'];}else{$pan_no='';}	
		if(isset($_REQUEST['aadhar_no'])){$aadhar_no=$_REQUEST['aadhar_no'];}else{$aadhar_no='';}	
		if(isset($_REQUEST['voter_id'])){$voter_id=$_REQUEST['voter_id'];}else{$voter_id='';}	
		if(isset($_REQUEST['bank_name'])){$bank_name=$_REQUEST['bank_name'];}else{$bank_name='';}	
		if(isset($_REQUEST['bank_account_no'])){$bank_account_no=$_REQUEST['bank_account_no'];}else{$bank_account_no='';}	
		if(isset($_REQUEST['co_mob_no'])){$co_mob_no=$_REQUEST['co_mob_no'];}else{$co_mob_no='';}	
		if(isset($_REQUEST['personal_no2'])){$personal_no2=$_REQUEST['personal_no2'];}else{$personal_no2='';}	
		if(isset($_REQUEST['nominee_name'])){$nominee_name=$_REQUEST['nominee_name'];}else{$nominee_name='';}	
		if(isset($_REQUEST['nominee_rel'])){$nominee_rel=$_REQUEST['nominee_rel'];}else{$nominee_rel='';}	
		if(isset($_REQUEST['owner_comp_assets'])){$owner_comp_assets=$_REQUEST['owner_comp_assets'];}else{$owner_comp_assets='';}	
		if(isset($_REQUEST['conf_undertaking'])){$conf_undertaking=$_REQUEST['conf_undertaking'];}else{$conf_undertaking='';}	
		if(isset($_REQUEST['warning_letter'])){$warning_letter=$_REQUEST['warning_letter'];}else{$warning_letter='';}	
		if(!empty($_REQUEST['date_of_leave'])){$test = new DateTime($_REQUEST['date_of_leave']);$date_of_leave= date_format($test, 'Y-m-d');}else{$date_of_leave='';}	
		if(isset($_REQUEST['reason_leaving1'])){$reason_leaving1=$_REQUEST['reason_leaving1'];}else{$reason_leaving1='';}	
		if(isset($_REQUEST['reason_leaving2'])){$reason_leaving2=$_REQUEST['reason_leaving2'];}else{$reason_leaving2='';}	
		if(isset($_REQUEST['present_address'])){$present_address=$_REQUEST['present_address'];}else{$present_address='';}	
		if(isset($_REQUEST['permanent_address'])){$permanent_address=$_REQUEST['permanent_address'];}else{$permanent_address='';}	
		if(isset($_REQUEST['home_town_no'])){$home_town_no=$_REQUEST['home_town_no'];}else{$home_town_no='';}	
		if(isset($_REQUEST['pin_code_permanet'])){$pin_code_permanet=$_REQUEST['pin_code_permanet'];}else{$pin_code_permanet='';}	
		if(isset($_REQUEST['state_par_address'])){$state_par_address=$_REQUEST['state_par_address'];}else{$state_par_address='';}	
		if(isset($_REQUEST['father_name'])){$father_name=$_REQUEST['father_name'];}else{$father_name='';}	
		if(!empty($_REQUEST['fater_dob'])){$test = new DateTime($_REQUEST['fater_dob']);$fater_dob= date_format($test, 'Y-m-d');}else{$fater_dob='';}	
		if(!empty($_REQUEST['mother_name'])){$mother_name=$_REQUEST['mother_name'];}else{$mother_name='';}	
		if(!empty($_REQUEST['mother_dob'])){$test = new DateTime($_REQUEST['mother_dob']);$mother_dob= date_format($test, 'Y-m-d');}else{$mother_dob='';}	
		if(isset($_REQUEST['spouse_name'])){$spouse_name=$_REQUEST['spouse_name'];}else{$spouse_name='';}	
		if(!empty($_REQUEST['spouse_no'])){$test = new DateTime($_REQUEST['spouse_no']);$spouse_no= date_format($test, 'Y-m-d');}else{$spouse_no='';}	
		if(!empty($_REQUEST['date_of_marriage'])){$test = new DateTime($_REQUEST['date_of_marriage']);$date_of_marriage= date_format($test, 'Y-m-d');}else{$date_of_marriage='';}	
		if(isset($_REQUEST['child_name1'])){$child_name1=$_REQUEST['child_name1'];}else{$child_name1='';}	
		if(isset($_REQUEST['child_gender1'])){$child_gender1=$_REQUEST['child_gender1'];}else{$child_gender1='';}	
		if(!empty($_REQUEST['child_dob1'])){$test = new DateTime($_REQUEST['child_dob1']);$child_dob1= date_format($test, 'Y-m-d');}else{$child_dob1='';}	
		if(isset($_REQUEST['child_name2'])){$child_name2=$_REQUEST['child_name2'];}else{$child_name2='';}	
		if(isset($_REQUEST['child_gender2'])){$child_gender2=$_REQUEST['child_gender2'];}else{$child_gender2='';}	
		if(!empty($_REQUEST['child_dob2'])){$test = new DateTime($_REQUEST['child_dob2']);$child_dob2= date_format($test, 'Y-m-d');}else{$child_dob2='';}	
		if(isset($_REQUEST['child_name3'])){$child_name3=$_REQUEST['child_name3'];}else{$child_name3='';}	
		if(isset($_REQUEST['child_gender3'])){$child_gender3=$_REQUEST['child_gender3'];}else{$child_gender3='';}	
		if(!empty($_REQUEST['child_dob3'])){$test = new DateTime($_REQUEST['child_dob3']);$child_dob3= date_format($test, 'Y-m-d');}else{$child_dob3='';}	
		if(isset($_REQUEST['child_name4'])){$child_name4=$_REQUEST['child_name4'];}else{$child_name4='';}	
		if(isset($_REQUEST['child_gender4'])){$child_gender4=$_REQUEST['child_gender4'];}else{$child_gender4='';}	
		if(!empty($_REQUEST['child_dob4'])){$test = new DateTime($_REQUEST['child_dob4']);$child_dob4= date_format($test, 'Y-m-d');}else{$child_dob4='';}	
		if(isset($_REQUEST['active'])){$active=$_REQUEST['active'];}else{$active='';}	
		if(isset($_REQUEST['attendance_entry'])){$attendance_entry=$_REQUEST['attendance_entry'];}else{$attendance_entry='';}	
		if(isset($_REQUEST['draft_entry'])){$draft_entry=$_REQUEST['draft_entry'];}else{$draft_entry=1;}	

		if(isset($_REQUEST['esic_ded'])){$esic_ded=$_REQUEST['esic_ded'];}else{$esic_ded='';}	
		if(isset($_REQUEST['pf_ded'])){$pf_ded=$_REQUEST['pf_ded'];}else{$pf_ded='';}	
		if(isset($_REQUEST['basic_salary_master_roll'])){$basic_salary_master_roll=$_REQUEST['basic_salary_master_roll'];}else{$basic_salary_master_roll='';}	
		if(isset($_REQUEST['hra_master_roll'])){$hra_master_roll=$_REQUEST['hra_master_roll'];}else{$hra_master_roll='';}	
		if(isset($_REQUEST['conv_master_roll'])){$conv_master_roll=$_REQUEST['conv_master_roll'];}else{$conv_master_roll='';}	
		if(isset($_REQUEST['lost_advance_master_roll'])){$lost_advance_master_roll=$_REQUEST['lost_advance_master_roll'];}else{$lost_advance_master_roll='';}	
		if(isset($_REQUEST['other_advance_master_roll'])){$other_advance_master_roll=$_REQUEST['other_advance_master_roll'];}else{$other_advance_master_roll='';}
		
		if(!empty($_REQUEST['doj_master_roll'])){$test = new DateTime($_REQUEST['doj_master_roll']);$doj_master_roll= date_format($test, 'Y-m-d');}else{$doj_master_roll='';}	
		if(!empty($_REQUEST['dor_master_roll'])){$test = new DateTime($_REQUEST['dor_master_roll']);$dor_master_roll= date_format($test, 'Y-m-d');}else{$dor_master_roll='';}
		if(isset($_REQUEST['mater_roll'])){$mater_roll=$_REQUEST['mater_roll'];}else{$mater_roll='No';}	
		if(isset($_REQUEST['emp_uan'])){$emp_uan=$_REQUEST['emp_uan'];}else{$emp_uan='';}	
		if(isset($_REQUEST['restday'])){$restday=$_REQUEST['restday'];}else{$restday='';}
		if(isset($_REQUEST['asset_issue'])){$asset_issue=$_REQUEST['asset_issue'];}else{$asset_issue='';}	
		
		if(isset($_REQUEST['emp_team'])){$emp_team=$_REQUEST['emp_team'];}else{$emp_team='';}	
		if(isset($_REQUEST['emp_cast_category'])){$emp_cast_category=$_REQUEST['emp_cast_category'];}else{$emp_cast_category='';}
		if(isset($_REQUEST['emp_marrige_status'])){$emp_marrige_status=$_REQUEST['emp_marrige_status'];}else{$emp_marrige_status='';}
		if(isset($_REQUEST['login_from_other_ip'])){$login_from_other_ip=$_REQUEST['login_from_other_ip'];}else{$login_from_other_ip=0;}
		
		if(isset($_REQUEST['late_punch_add'])){$late_punch_add=$_REQUEST['late_punch_add'];}else{$late_punch_add='';}
		if(isset($_REQUEST['on_daily_wages'])){$on_daily_wages=$_REQUEST['on_daily_wages'];}else{$on_daily_wages='';}
		if(isset($_REQUEST['daily_wages_rs'])){$daily_wages_rs=$_REQUEST['daily_wages_rs'];}else{$daily_wages_rs='';}

		

		
							

		if(isset($_REQUEST['status'])){
			$status=$_REQUEST['status'];
		}else{$status='Deactive';}

		
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['emp_code']))
		{
			$where = " company_id = '$company_id' and (emp_code='$emp_code' OR bio_code='$bio_code') ";
			$res_chk = $this->Mymodel->select_where('employee', $where);
			if (!empty($res_chk)) {
				if ($res_chk[0]['emp_code'] == $emp_code) {
					echo "$emp_code Employee Code Already Available";
				} elseif ($res_chk[0]['bio_code'] == $bio_code) {
					echo "$bio_code Bio Code Already Available";
				}
				exit;
			}

				$data=array(
								'username'=>"$emp_code",
								'pwd'=>"$pwd",
								'login_from_other_ip'=>"$login_from_other_ip",
								'emp_code'=>"$emp_code",
								'pay_code'=>"$emp_code",
								'bio_code'=>"$bio_code",
								'plant'=>"$plant",
								'first_name'=>"$first_name",
								'last_name'=>"$last_name",
								'gender'=>"$gender",
								'mob'=>"$telphone",
								'email'=>"$email",
								'doj'=>"$doj",
								'dob'=>"$dob",
								'dor'=>"$dor",
								'age'=>"$age",
								'blood_group'=>"$blood_group",
								'quli'=>"$quli",
								'add_quli'=>"$add_quli",
								'last_org'=>"$last_org",
								'past_exp'=>"$past_exp",
								'pres_exp'=>"$pres_exp",
								'total_exp'=>"$total_exp",
								'join_desig'=>"$join_desig",
							  	'role_in_department'=>"$current_desig",
							  	'department_id'=>"$dept",
							  	'sub_department_id'=>"$sub_dept",
								'hod_status'=>"$hod_status",
								'staff_tech'=>"$staff_tech",
								'job_respons'=>"$job_respons",
								'payroll_area'=>"$payroll_area",
								'join_grade'=>"$join_grade",
								'current_grade'=>"$current_grade",
								'last_promotion_date'=>"$last_promotion_date",
								'ctc_at_join'=>"$ctc_at_join",
								'current_ctc'=>"$current_ctc",
								'total_rise_rs'=>"$total_rise_rs",
								'ctc_on_probation'=>"$ctc_on_probation",
								'trainee_probn_ctc'=>"$trainee_probn_ctc",
								'trainee_probation_date'=>"$trainee_probation_date",
								'due_conf_date'=>"$due_conf_date",
								'actual_conf_date'=>"$actual_conf_date",
								'increment_due_date'=>"$increment_due_date",
								'date_of_transfer'=>"$date_of_transfer",
								'increment_due_month'=>"$increment_due_month",
								'plan_name_tranfer'=>"$plan_name_tranfer",
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
								'ex_gratia'=>"$ex_gratia",
								'old_ex_gratia'=>"$old_ex_gratia",
								'current_total_ctc'=>"$current_total_ctc",
								'get_attendance_all'=>"$get_attendance_all",
								'get_el_encashment'=>"$get_el_encashment",
								'get_cl_encashment'=>"$get_cl_encashment",
								'get_other1'=>"$get_other1",
								'get_other2'=>"$get_other2",
								'get_other3'=>"$get_other3",
								'get_other4'=>"$get_other4",
								'lost_canteen'=>"$lost_canteen",
								'lost_breakfast'=>"$lost_breakfast",
								'lost_bus'=>"$lost_bus",
								'lost_advance'=>"$lost_advance",
								'lost_1'=>"$lost_1",
								'lost_2'=>"$lost_2",
								'lost_3'=>"$lost_3",
								'lost_4'=>"$lost_4",
					  			'working_hr'=>"$working_hr",
								'epf_code'=>"$epf_code",
								'esi_code'=>"$esi_code",
								'pan_no'=>"$pan_no",
								'aadhar_no'=>"$aadhar_no",
								'voter_id'=>"$voter_id",
								'bank_name'=>"$bank_name",
								'bank_account_no'=>"$bank_account_no",
								'co_mob_no'=>"$co_mob_no",
								'personal_no2'=>"$personal_no2",
								'nominee_name'=>"$nominee_name",
								'nominee_rel'=>"$nominee_rel",
								'owner_comp_assets'=>"$owner_comp_assets",
								'conf_undertaking'=>"$conf_undertaking",
								'warning_letter'=>"$warning_letter",
								'date_of_leave'=>"$date_of_leave",
								'reason_leaving1'=>"$reason_leaving1",
								'reason_leaving2'=>"$reason_leaving2",
					  			'present_address'=>"$present_address",
								'permanent_address'=>"$permanent_address",
								'home_town_no'=>"$home_town_no",
								'pin_code_permanet'=>"$pin_code_permanet",
								'state_par_address'=>"$state_par_address",
								'father_name'=>"$father_name",
								'fater_dob'=>"$fater_dob",
								'mother_name'=>"$mother_name",
								'mother_dob'=>"$mother_dob",
								'spouse_name'=>"$spouse_name",
								'spouse_no'=>"$spouse_no",
								'date_of_marriage'=>"$date_of_marriage",
								'child_name1'=>"$child_name1",
								'child_gender1'=>"$child_gender1",
								'child_dob1'=>"$child_dob1",
					  			'child_name2'=>"$child_name2",
								'child_gender2'=>"$child_gender2",
								'child_dob2'=>"$child_dob2",
					  			'child_name3'=>"$child_name3",
							  	'child_gender3'=>"$child_gender3",
							  	'child_dob3'=>"$child_dob3",
					  			'child_name4'=>"$child_name4",
								'child_gender4'=>"$child_gender4",
								'child_dob4'=>"$child_dob4",
								'company_role'=>"$company_role",
								'shift_status'=>"$shift_status",
								'current_shift'=>"$current_shift",
								'get_overtime'=>"$get_overtime",
								'active'=>"$active",
								'status'=>"$status", 
								'attendance_entry'=>"$attendance_entry",
								'draft_entry'=>"$draft_entry",
								'esic_ded'=>"$esic_ded",
								'pf_ded'=>"$pf_ded",
								'basic_salary_master_roll'=>"$basic_salary_master_roll",
								'hra_master_roll'=>"$hra_master_roll",
								'conv_master_roll'=>"$conv_master_roll",
								'lost_advance_master_roll'=>"$lost_advance_master_roll",
								'other_advance_master_roll'=>"$other_advance_master_roll",
								'doj_master_roll'=>"$doj_master_roll",
								'dor_master_roll'=>"$dor_master_roll",
								'mater_roll'=>"$mater_roll",
								'emp_uan'=>"$emp_uan",
								'asset_issue'=>"$asset_issue",
								'restday'=>"$restday",
								'emp_team'=>"$emp_team",
								'emp_cast_category'=>"$emp_cast_category",
								'emp_marrige_status'=>"$emp_marrige_status",
								'on_daily_wages'=>"$on_daily_wages",
								'daily_wages_rs'=>"$daily_wages_rs",
								'late_punch_add'=>"$late_punch_add",
								'save_by'=>"$user_email",
								'save_date'=>"$today",
								'company_id'=>"$company_id",
							);
				$cat_id=$this->Mymodel->insertdata_withid('employee',$data);
				echo "Save";
			
			
		}//insert
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['emp_code']))
		{
			$where = "(emp_code='$emp_code' OR bio_code='$bio_code') AND id != '$id' and company_id = '$company_id' ";
			$res_chk = $this->Mymodel->select_where('employee', $where);

			if (!empty($res_chk)) {
				if ($res_chk[0]['emp_code'] == $emp_code) {
					echo "$emp_code Employee Code Already Available";
				} elseif ($res_chk[0]['bio_code'] == $bio_code) {
					echo "$bio_code Bio Code Already Available";
				}
				exit;
			}

				//updating emp table
				//login update
				if(!empty($res_chk[0]['status']) && !empty($res_chk[0]['username']) && !empty($res_chk[0]['pwd']))
				if($status == 'Active' and $res_chk[0]['username'] == '' and $res_chk[0]['pwd']==''){
					$data5 = array(
								'username'=>"$emp_code",
								'pwd'=>"$pwd",
								'status'=>"Active",
								'login_from_other_ip'=>"$login_from_other_ip"
					);
					$where5=array('id'=>"$id",'company_id'=>"$company_idd");   
					$this->Mymodel->update('employee',$data5,$where5);
				}
				
				$data=array(
								'bio_code'=>"$bio_code",
								'company_role'=>"$company_role",
								'plant'=>"$plant",			
								'first_name'=>"$first_name",
								'last_name'=>"$last_name",
								'gender'=>"$gender",
								'mob'=>"$telphone",
								'email'=>"$email",
								'doj'=>"$doj",
								'dob'=>"$dob",
								'dor'=>"$dor",
								'age'=>"$age",
								'blood_group'=>"$blood_group",
								'quli'=>"$quli",
								'add_quli'=>"$add_quli",
								'last_org'=>"$last_org",
								'past_exp'=>"$past_exp",
								'pres_exp'=>"$pres_exp",
								'total_exp'=>"$total_exp",
								'join_desig'=>"$join_desig",
								'role_in_department'=>"$current_desig",
								'department_id'=>"$dept",
								'sub_department_id'=>"$sub_dept",
							  	'hod_status'=>"$hod_status",
							  	'staff_tech'=>"$staff_tech",
							  	'job_respons'=>"$job_respons",
								'payroll_area'=>"$payroll_area",
								'join_grade'=>"$join_grade",
								'current_grade'=>"$current_grade",
								'last_promotion_date'=>"$last_promotion_date",
								'ctc_at_join'=>"$ctc_at_join",
								'current_ctc'=>"$current_ctc",
								'total_rise_rs'=>"$total_rise_rs",
								'ctc_on_probation'=>"$ctc_on_probation",
								'trainee_probn_ctc'=>"$trainee_probn_ctc",
								'trainee_probation_date'=>"$trainee_probation_date",
								'due_conf_date'=>"$due_conf_date",
							  	'actual_conf_date'=>"$actual_conf_date",
							  	'increment_due_date'=>"$increment_due_date",
							  	'date_of_transfer'=>"$date_of_transfer",
								'increment_due_month'=>"$increment_due_month",
								'plan_name_tranfer'=>"$plan_name_tranfer",
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
								'ex_gratia'=>"$ex_gratia",
								'old_ex_gratia'=>"$old_ex_gratia",
								'current_total_ctc'=>"$current_total_ctc",
								'get_attendance_all'=>"$get_attendance_all",
								'get_el_encashment'=>"$get_el_encashment",
								'get_cl_encashment'=>"$get_cl_encashment",
								'get_other1'=>"$get_other1",
								'get_other2'=>"$get_other2",
								'get_other3'=>"$get_other3",
								'get_other4'=>"$get_other4",
								'lost_canteen'=>"$lost_canteen",
								'lost_breakfast'=>"$lost_breakfast",
								'lost_bus'=>"$lost_bus",
								'lost_advance'=>"$lost_advance",
								'lost_1'=>"$lost_1",
								'lost_2'=>"$lost_2",
								'lost_3'=>"$lost_3",
								'lost_4'=>"$lost_4",
					  			'working_hr'=>"$working_hr",
								'epf_code'=>"$epf_code",
								'esi_code'=>"$esi_code",
								'pan_no'=>"$pan_no",
								'aadhar_no'=>"$aadhar_no",
								'voter_id'=>"$voter_id",
								'bank_name'=>"$bank_name",
								'bank_account_no'=>"$bank_account_no",
								'co_mob_no'=>"$co_mob_no",
							  	'personal_no2'=>"$personal_no2",
							  	'nominee_name'=>"$nominee_name",
							  	'nominee_rel'=>"$nominee_rel",
								'owner_comp_assets'=>"$owner_comp_assets",
								'conf_undertaking'=>"$conf_undertaking",
								'warning_letter'=>"$warning_letter",
								'date_of_leave'=>"$date_of_leave",
								'reason_leaving1'=>"$reason_leaving1",
								'reason_leaving2'=>"$reason_leaving2",
					  			'present_address'=>"$present_address",
								'permanent_address'=>"$permanent_address",
								'home_town_no'=>"$home_town_no",
								'pin_code_permanet'=>"$pin_code_permanet",
								'state_par_address'=>"$state_par_address",
								'father_name'=>"$father_name",
								'fater_dob'=>"$fater_dob",
								'mother_name'=>"$mother_name",
								'mother_dob'=>"$mother_dob",
								'spouse_name'=>"$spouse_name",
								'spouse_no'=>"$spouse_no",
								'date_of_marriage'=>"$date_of_marriage",
								'child_name1'=>"$child_name1",
								'child_gender1'=>"$child_gender1",
								'child_dob1'=>"$child_dob1",
					  			'child_name2'=>"$child_name2",
								'child_gender2'=>"$child_gender2",
								'child_dob2'=>"$child_dob2",
					  			'child_name3'=>"$child_name3",
							  	'child_gender3'=>"$child_gender3",
							  	'child_dob3'=>"$child_dob3",
					  			'child_name4'=>"$child_name4",
							  	'child_gender4'=>"$child_gender4",
							  	'child_dob4'=>"$child_dob4",
								'shift_status'=>"$shift_status",
								'current_shift'=>"$current_shift",
								'get_overtime'=>"$get_overtime",
								'active'=>"$active",
								'status'=>"$status",
								'attendance_entry'=>"$attendance_entry",
								'draft_entry'=>"$draft_entry",
								'esic_ded'=>"$esic_ded",
								'pf_ded'=>"$pf_ded",
								'basic_salary_master_roll'=>"$basic_salary_master_roll",
								'hra_master_roll'=>"$hra_master_roll",
								'conv_master_roll'=>"$conv_master_roll",
								'lost_advance_master_roll'=>"$lost_advance_master_roll",
								'other_advance_master_roll'=>"$other_advance_master_roll",
								'doj_master_roll'=>"$doj_master_roll",
								'dor_master_roll'=>"$dor_master_roll",
								'mater_roll'=>"$mater_roll",
								'emp_uan'=>"$emp_uan",
								'restday'=>"$restday",
								'asset_issue'=>"$asset_issue",
								'emp_team'=>"$emp_team",
								'emp_cast_category'=>"$emp_cast_category",
								'emp_marrige_status'=>"$emp_marrige_status",
								'on_daily_wages'=>"$on_daily_wages",
								'daily_wages_rs'=>"$daily_wages_rs",
								'late_punch_add'=>"$late_punch_add",
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
				$where2=array('id'=>"$id");   
				$this->Mymodel->update('employee',$data,$where2);
				echo "Update";	
			
		}
		else 
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
		
	}//function close




	public function emp_list()
	{
		//$result['dept']=$this->Base->get_hr_dept();
		//$result['con']=$this->Base->get_all_contractor_code();
		$result['dept']=$this->Base->get_hr_dept();
		// $result['conMaster']=$this->Base->get_payroll_master();
		// $result['con']=$this->Base->get_payroll_contractor();
		// $result['con2']=$this->Base->get_all_contractor_code();
		
		$where=" ";
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['name'])){$name=$_REQUEST['name'];$where.=" and  B.first_name like '$name%' ";}
			//if(!empty($_REQUEST['company_role'])){$company_role=$_REQUEST['company_role'];$where.=" and  B.company_role = '$company_role' ";}
			if(!empty($_REQUEST['mob'])){$mob=$_REQUEST['mob'];$where.=" and  B.mob='$mob' ";}
			if(!empty($_REQUEST['emp_id'])){$emp_id=$_REQUEST['emp_id'];$where.=" and  B.emp_code='$emp_id'   ";}
			if(!empty($_REQUEST['bio_id'])){$bio_id=$_REQUEST['bio_id'];$where.=" and  B.bio_code='$bio_id'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  B.department_id='$dept'   ";}
			if(!empty($_REQUEST['hod'])){$hod=$_REQUEST['hod'];$where.=" and  B.hod_status='$hod'   ";}
			if(!empty($_REQUEST['staff'])){$staff=$_REQUEST['staff'];$where.=" and  B.staff_tech='$staff'   ";}
			if(!empty($_REQUEST['active'])){$active=$_REQUEST['active'];$where.=" and  B.active='$active'   ";}
			if(!empty($_REQUEST['shift_status'])){$shift_status=$_REQUEST['shift_status'];$where.=" and  B.shift_status='$shift_status'   ";}
			//if(!empty($_REQUEST['search_plant'])){$search_plant=$_REQUEST['search_plant'];$where.=" and  B.plant='$search_plant'   ";}
			if(!empty($_REQUEST['current_shift'])){$current_shift=$_REQUEST['current_shift'];$where.=" and  B.current_shift='$current_shift'   ";}
			if(!empty($_REQUEST['mater_roll'])){$mater_roll=$_REQUEST['mater_roll'];$where.=" and  B.mater_roll='$mater_roll'   ";}
			if(!empty($_REQUEST['report_type1'])){$report_type1=(int)$_REQUEST['report_type1'];}else{$report_type1=1;}

			$company_role = $_REQUEST['company_role'] ?? [];
			if (!empty($company_role) && is_array($company_role)) {
				$company_role = array_map('trim', $company_role);
				$role_list = "'" . implode("','", $company_role) . "'";
				$where .= " AND B.company_role IN ($role_list) ";
			}

			$search_plant = $_REQUEST['search_plant'] ?? [];
			if (!empty($search_plant) && is_array($search_plant)) {
				$search_plant = array_map('trim', $search_plant);
				$role_list2 = "'" . implode("','", $search_plant) . "'";
				$where .= " AND B.plant IN ($role_list2) ";
			}


			if (!empty($_REQUEST['doj1'])) {
				$doj1 = $_REQUEST['doj1']; // format: YYYY-MM
				$startDate = $doj1 . '-01';
				$endDate   = date('Y-m-t', strtotime($startDate)); // last day of month
				$where .= " AND B.doj BETWEEN '$startDate' AND '$endDate' ";
			}

			if(!empty($_REQUEST['dor1'])){
				$dor1 = $_REQUEST['dor1']; // format: YYYY-MM
				$startDate = $dor1 . '-01';
				$endDate   = date('Y-m-t', strtotime($startDate)); // last day of month
				$where .= " AND B.dor BETWEEN '$startDate' AND '$endDate' ";
			}

			$where.=" and owner < 1 GROUP BY B.id   ORDER by B.department_id,B.role_in_department,B.first_name Asc  ";
			$result['res2']=$this->Hrmodel->get_emp_deatis_search($where);
			
			if($report_type1 ==1){
				$this->load->view('hr/emp/show_table',$result);
			}
			elseif($report_type1 ==2){
				$this->load->view('hr/emp/payment',$result);
			}
			elseif($report_type1 ==3){
				$this->load->view('hr/emp/doucument',$result);
			}
			elseif($report_type1 ==4){
				$this->load->view('hr/emp/address',$result);
			}
			elseif($report_type1 ==5){
				$this->load->view('hr/emp/master_roll',$result);
			}
			elseif($report_type1 ==6){
				$this->load->view('hr/emp/assets',$result);
			}
			elseif($report_type1 ==7){
				$this->load->view('hr/emp/login_status',$result);
			}
			elseif($report_type1 ==8){
				$this->load->view('hr/emp/latter',$result);
			}
			elseif($report_type1 ==9){
				$this->load->view('hr/emp/epf',$result);
			}
			elseif($report_type1 ==10){
				$this->load->view('hr/emp/draft',$result);
			}
			elseif($report_type1 ==11){
				$this->load->view('hr/emp/leave',$result);
			}
			
		}
		else
		{
			$login_emp_code = $this->session->userdata('login_emp_code');
			$basicDetails   = $this->Hrmodel->get_emp_details_with_emp_code($login_emp_code);
			$defaultUnit    = $basicDetails[0]['company_role'] ?? '';
			$result['def_dept']='';
			$where.=" and B.company_role = '$defaultUnit'  and owner < 1 and  B.active='Active'  and B.mater_roll='Yes'  GROUP BY B.id   ORDER by B.department_id,B.role_in_department,B.first_name Asc  ";
			$result['res2']=$this->Hrmodel->get_emp_deatis_search($where);
			$this->load->view('hr/emp/show',$result);
		}
		
	}//function close

	public function emp_list_master_list()
	{
		$result['def_dept']='';
		$where =" and owner < 1 and  B.active='Active'  and B.mater_roll='Yes'  GROUP BY B.id   ORDER by B.department_id,B.role_in_department,B.first_name Asc  ";
		$result['res2']=$this->Hrmodel->get_emp_deatis_search($where);
		$this->load->view('hr/emp/show2',$result);
	
	}//function close












































	//attendance entry single
	public function att_entry()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$this->load->view('hr/attendance/attendance_entry2',$result);
	}//function close

	public function check_attendance_entry_manual_save_employee_wise()
	{
		if(isset($_REQUEST['emp_code']))
		{
			$emp_code=$_REQUEST['emp_code'];
			$res = $this->Hrmodel->get_emp_details_with_emp_code($emp_code);
			if(!empty($res))
			{
				$emp_id  = $res[0]['id'];
			}
			else
			{
				echo "ID not found";
				exit;
			}
			
			$month=$_REQUEST['month_search'];
			$year=$_REQUEST['year_search'];
			$company_role_id=$_REQUEST['company_role'];
			$out = $this->Hrmodel->get_atten_table_id($emp_id,$year,$month);
			if(!empty($out))
			{
				$att_monthly_id = $out[0]['att_monthly_id'];
				
				$sql9 = "SELECT * FROM daily_attendance_monthly WHERE att_monthly_id='$att_monthly_id'   ";
				$query9 = $this->db->query($sql9);
				$out9 = $query9->result_array();
				$emp_id =$out9[0]['emp_code'];
				
				$sql8 = "SELECT emp_code,first_name,last_name FROM employee WHERE id='$emp_id'   ";
				$query8 = $this->db->query($sql8);
				$out8 = $query8->result_array();
				$emp_code =$out8[0]['emp_code'];
				$first_name =$out8[0]['first_name'];
				$last_name =$out8[0]['last_name'];
				
				echo "($emp_code), $first_name $last_name : $year, $month ";
				echo "\n";
				echo 	$out9[0]['d1'].','.$out9[0]['d2'].','.$out9[0]['d3'].','.$out9[0]['d4'].','.$out9[0]['d5']
						.','.$out9[0]['d6'].','.$out9[0]['d7'].','.$out9[0]['d8'].','.$out9[0]['d9'].','.$out9[0]['d10']
						.','.$out9[0]['d11'].','.$out9[0]['d12'].','.$out9[0]['d13'].','.$out9[0]['d14'].','.$out9[0]['d15']
						.','.$out9[0]['d16'].','.$out9[0]['d17'].','.$out9[0]['d18'].','.$out9[0]['d19'].','.$out9[0]['d20']
						.','.$out9[0]['d21'].','.$out9[0]['d22'].','.$out9[0]['d23'].','.$out9[0]['d24'].','.$out9[0]['d25']
						.','.$out9[0]['d26'].','.$out9[0]['d27'].','.$out9[0]['d28'].','.$out9[0]['d29'].','.$out9[0]['d30'].','.$out9[0]['d31'];
				echo "\n";
				echo 	$out9[0]['o1'].','.$out9[0]['o2'].','.$out9[0]['o3'].','.$out9[0]['o4'].','.$out9[0]['o5']
						.','.$out9[0]['o6'].','.$out9[0]['o7'].','.$out9[0]['o8'].','.$out9[0]['o9'].','.$out9[0]['o10']
						.','.$out9[0]['o11'].','.$out9[0]['o12'].','.$out9[0]['o13'].','.$out9[0]['o14'].','.$out9[0]['o15']
						.','.$out9[0]['o16'].','.$out9[0]['o17'].','.$out9[0]['o18'].','.$out9[0]['o19'].','.$out9[0]['o20']
						.','.$out9[0]['o21'].','.$out9[0]['o22'].','.$out9[0]['o23'].','.$out9[0]['o24'].','.$out9[0]['o25']
						.','.$out9[0]['o26'].','.$out9[0]['o27'].','.$out9[0]['o28'].','.$out9[0]['o29'].','.$out9[0]['o30'].','.$out9[0]['o31'];
			}//!empty $out
			else
			{
				echo "1st entry in this month";
			}
		}
		else
		{
			echo "Emp Code not found";
			exit;
		}
	}//function close




	//manual entry through popup model in attendance_entry_manual page
	public function attendance_entry_manual_popup_model()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id'); 
		
		if(!empty($_REQUEST['empid']) and !empty($_REQUEST['current_day']) and !empty($_REQUEST['current_status']) ){
			$emp_id = $_REQUEST['empid'];
			$current_day = $_REQUEST['current_day'];
			$year = $_REQUEST['year_search'];
			$month = $_REQUEST['month_search'];
			$current_status = $_REQUEST['current_status'];
			$current_ot = $_REQUEST['current_ot'];
			$current_restday = $_REQUEST['current_restday'];

			//check attendance lock or not
			$rem_date = date('Y-m-d', strtotime("$year-$month-01"));
			$lock = $this->Base->atten_lock_check($rem_date,$emp_id);
			if($lock) {
				echo "Attendance for this month and year is locked and cannot be modified.";
				exit;
			}

			

			$day_colomn = "d$current_day";
			$ot_column = "o$current_day";

			$out = $this->Hrmodel->get_atten_table_id($emp_id,$year,$month);
			if(!empty($out) and $out[0]['att_monthly_id']>0)
			{
				$att_monthly_id=$out[0]['att_monthly_id'];
				$data2=array(
							"$day_colomn"=>"$current_status",
							"$ot_column"=>"$current_ot",
							"restday"=>"$current_restday",
							'update_by'=>"$user_email",
							'update_date'=>"$today",
							);
				$where2=array('att_monthly_id'=>"$att_monthly_id");   
				$this->Mymodel->update('daily_attendance_monthly',$data2,$where2); 
				$this->Hrmodel->add_total_present_absent_attendance_monthly($att_monthly_id);
				//update rest day
				$data3=array("restday"=>"$current_restday");
				$where3=array('id'=>"$emp_id");   
				$this->Mymodel->update('employee',$data3,$where3); 
				

				//get updated data
				$query=" SELECT  total_present,total_absent,total_ot FROM daily_attendance_monthly where  att_monthly_id='$att_monthly_id' and company_id='$company_id' ";
				$out2 = $this->Mymodel->query1($query);
				echo "success".'~'.$out2[0]['total_present'].'~'.$out2[0]['total_absent'].'~'.$out2[0]['total_ot'];
			}else{
				echo "error";
			}
		}else{
			echo "emp id, day or day Status not found";
		}
		
	}//function close

	/*
	public function attendance_entry_manual_save_employee_wise()
	{
		$today=date("Y-m-d H:i:s");
	 	$user_email=$this->session->userdata('login_emp_id');
		
		 //save
		if(isset($_REQUEST['emp_code']))
		{
			$emp_code=$_REQUEST['emp_code'];
			$res = $this->Hrmodel->get_emp_details_with_emp_code($emp_code);
			if(!empty($res))
			{
				$emp_id  = $res[0]['id'];
			}
			else
			{
				echo "ID not found";
				exit;
			}
			
			
			$month=$_REQUEST['month_search'];
			$year=$_REQUEST['year_search'];
			$company_role_id=$_REQUEST['company_role'];
			
			//--------checking no of days in this month
			$total_day_in_month=cal_days_in_month(CAL_GREGORIAN,$month,$year);
			//---------------Getting no of sunday
			$no_of_sunday_array = $this->Base->getSundays2($year, $month);
			$total_sunday=count($no_of_sunday_array);
			$total_holiday=0;
			$company_off=($total_sunday+$total_holiday);
			$company_on=$total_day_in_month-$company_off;
			
			
			
			$test = new DateTime("$year-$month-01");
			$last_date= date_format($test, 't'); 


			//emp_details
			$emp_entry_at = explode('~',$_REQUEST['emp_entry_at']);
			$emp_entry_ot = explode('~',$_REQUEST['emp_entry_ot']);
			$attenid = explode('~',$_REQUEST['attenid']);
			$intime = explode('~',$_REQUEST['intime']);
			$outtime = explode('~',$_REQUEST['outtime']);
			$shift = explode('~',$_REQUEST['shift']);
			
			$intimemc = explode('~',$_REQUEST['intimemc']);
			$outtimemc = explode('~',$_REQUEST['outtimemc']);
			$savefrom = explode('~',$_REQUEST['savefrom']);

			
			
			for($i=1;$i<=$last_date;$i++)
			{
				$test = new DateTime("$i-$month-$year");
				$new_date = date_format($test, 'Y-m-d');
				$m1= date_format($test, 'm');
				$y1= date_format($test, 'Y');
				
				$day_colomn = "d$i";
				$ot_column = "o$i";
				$day_1 = $emp_entry_at[$i];
				$ot_1 = $emp_entry_ot[$i];

				//same details from punching machine
			 	if(!empty($intimemc[$i])){$in_time_mc = $intimemc[$i];}else{$in_time_mc ='';}
				if(!empty($intimemc[$i])){$out_time_mc = $outtimemc[$i];}else{$out_time_mc ='';}
				if(!empty($intimemc[$i])){if($savefrom[$i] == 'Machine'){ $savefrom_mc = 'Machine';}else{$savefrom_mc ='Manual';}}else{$savefrom_mc ='';}
				
				
				//attndance
				$out = $this->Hrmodel->get_atten_table_id($emp_id,$year,$month);
				
				if(!empty($out) and $out[0]['att_monthly_id']>0)
				{
					//update
					$att_monthly_id=$out[0]['att_monthly_id'];
					$data2=array(
								"$day_colomn"=>"$day_1",
								"$ot_column"=>"$ot_1",
								'total_day_in_month'=>"$total_day_in_month",
								'total_sunday'=>"$total_sunday",
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							  );
				 	$where2=array('att_monthly_id'=>"$att_monthly_id");   
					$this->Mymodel->update('daily_attendance_monthly',$data2,$where2); 
					 
				}
				else
				{
					//new
					$data2=array(
								'emp_code'=>"$emp_id",
								'company_role_id'=>"$company_role_id",
								'att_year'=>"$year",
								'att_month'=>"$month",
								"$day_colomn"=>"$day_1",
								"$ot_column"=>"$ot_1",
								'total_day_in_month'=>"$total_day_in_month",
								'total_sunday'=>"$total_sunday",
								
								'save_by'=>"$user_email",
								'save_date'=>"$today"
							  );
					$att_monthly_id = $this->Mymodel->insertdata_withid('daily_attendance_monthly',$data2);
				}//att_monthly_id
			
				
				
				if(!empty($att_monthly_id))
				{
					//update total present and total absent and total sunday
					$this->Hrmodel->add_total_present_absent_attendance_monthly($att_monthly_id);
				}//$att_monthly_id
				else
				{
					echo "No employee data found";
					exit;
				}
				


				//------------------------------------------------shift IN / Out
				
				$query=" SELECT  id,get_overtime,emp_code FROM employee where  id='$emp_id' ";
				$emp = $this->Mymodel->query1($query);
				if(!empty($emp[0]['get_overtime'])){$get_overtime = $emp[0]['get_overtime'];}else{$get_overtime = 'No';}
				$emp_code = $emp[0]['emp_code'];
				

				$tomorrow_date = date( "Y-m-d",strtotime("+1 day",strtotime($new_date)));// for b shift out
				$attenid_day = $attenid[$i];
				$punch_in = $intime[$i];
				$punch_out = $outtime[$i];
				
				
				if($shift[$i] == "G")
				{
					$shift_day = "General";
					$shift_in_time = $this->Base->change_date_ymd_hisa("$new_date 09:00:00");
					$shift_out_time = $this->Base->change_date_ymd_hisa("$new_date 19:00:00");
					$shift_out_time2 = $this->Base->change_date_ymd_hisa("$new_date 19:00:00");
					$in_time = $this->Base->change_date_ymd_hisa("$new_date $punch_in");
					$out_time = $this->Base->change_date_ymd_hisa("$new_date $punch_out");
				}
				if($shift[$i] == "A")
				{
					$shift_day = "A";
					$shift_in_time = $this->Base->change_date_ymd_hisa("$new_date 08:00:00");
					$shift_out_time = $this->Base->change_date_ymd_hisa("$new_date 16:30:00");
					$shift_out_time2 = $this->Base->change_date_ymd_hisa("$new_date 20:00:00");
					$in_time = $this->Base->change_date_ymd_hisa("$new_date $punch_in");
					$out_time = $this->Base->change_date_ymd_hisa("$new_date $punch_out");
				}
				elseif($shift[$i] == "B")
				{
					$shift_day = "B";
					$shift_in_time = $this->Base->change_date_ymd_hisa("$new_date 20:00:00");//today
					$shift_out_time = $this->Base->change_date_ymd_hisa("$tomorrow_date 04:00:00");
					$shift_out_time2 = $this->Base->change_date_ymd_hisa("$tomorrow_date 08:00:00");
					$in_time = $this->Base->change_date_ymd_hisa("$new_date $punch_in");//today
					$out_time = $this->Base->change_date_ymd_hisa("$tomorrow_date $punch_out");
				}
				else
				{
					$shift_day = "General";
					$shift_in_time = $this->Base->change_date_ymd_hisa("$new_date 09:00:00");
					$shift_out_time = $this->Base->change_date_ymd_hisa("$new_date 19:00:00");
					$shift_out_time2 = $this->Base->change_date_ymd_hisa("$new_date 19:00:00");
					$in_time = $this->Base->change_date_ymd_hisa("$new_date $punch_in");
					$out_time = $this->Base->change_date_ymd_hisa("$new_date $punch_out");
				}
				
				//delete data
				$test = new DateTime($shift_in_time);
				$delete_shift =  date_format($test,'Y-m-d');
				$where2 = " emp_code='$emp_code' and  shift_in_time like '%$delete_shift%' ";
				$this->Mymodel->deletedata('daily_attendance',$where2);
			
				if(strlen($punch_in)>0 and strlen($punch_out)>0)
				{
					//calculating late min in IN time
					$to_time = strtotime($shift_in_time);
					$in_min_late_early = round(abs($to_time - strtotime($in_time)) / 60,2);
					if($to_time<=strtotime($in_time)){$in_status="L";}else{$in_status="E";}

					//calculating late min 
					$to_time = strtotime($shift_out_time2);
					$out_min_late_early = round(abs($to_time - strtotime($out_time)) / 60,2);
					if($to_time<=strtotime($out_time)){$out_status="L";}else{$out_status="E";}

					//full duty hours
					$to_time = strtotime($shift_in_time);
					$in_min = round(abs($to_time - strtotime($out_time)) / 60,2);
					$duty_hours = round(abs($in_min) / 60,1);

					//save in table
					$data = array(
						'entry_date'=>"$today",
						'emp_code'=>"$emp_code",
						'shift'=>"$shift_day",
						'shift_in_time'=>"$shift_in_time",
						'in_time_mc'=>"$in_time_mc",
						'in_time'=>"$in_time",
						'in_min_late_early'=>"$in_min_late_early",
						'in_status'=>"$in_status",
						'shift_out_time'=>"$shift_out_time",
						'shift_out_time2'=>"$shift_out_time2",
						'out_time_mc'=>"$out_time_mc",
						'out_time'=>"$out_time",
						'out_min_late_early'=>"$out_min_late_early",
						'out_status'=>"$out_status",
						'duty_hours'=>"$duty_hours",
						'full_day_duty'=>"F",
						'ot_hours'=>"$ot_1",
						'get_ot'=>"$get_overtime",
						'save_from'=>"$savefrom_mc",
						'save_by'=>"$user_email",
						'save_date'=>"$today"
					);
					$attenid_day = $this->Mymodel->insertdata_withid('daily_attendance',$data); 
					//save in table
					
				}
				elseif(strlen($punch_in)>0 and strlen($punch_out)<1)
				{
					//only in not out
					$in_time = $this->Base->change_date_ymd_hisa("$new_date $punch_in");
					
					//calculating late min in IN time
					$to_time = strtotime($shift_in_time);
					$in_min_late_early = round(abs($to_time - strtotime($in_time)) / 60,2);
					if($to_time<=strtotime($in_time)){$in_status="L";}else{$in_status="E";}

					//save in table
					$data = array(
						'entry_date'=>"$today",
						'emp_code'=>"$emp_code",
						'shift'=>"$shift_day",
						'shift_in_time'=>"$shift_in_time",
						'in_time_mc'=>"$in_time_mc",
						'in_time'=>"$in_time",
						'in_min_late_early'=>"$in_min_late_early",
						'in_status'=>"$in_status",
						'shift_out_time'=>"$shift_out_time",
						'shift_out_time2'=>"$shift_out_time2",
						'out_time_mc'=>"$out_time_mc",
						'out_time'=>"0000-00-00 00:00:00",
						'out_min_late_early'=>"0",
						'out_status'=>"",
						'duty_hours'=>"",
						'full_day_duty'=>"",
						'ot_hours'=>"$ot_1",
						'get_ot'=>"$get_overtime",
						'save_from'=>"$savefrom_mc",
						'save_by'=>"$user_email",
						'save_date'=>"$today"
					);
					//new entry save
					$attenid_day = $this->Mymodel->insertdata_withid('daily_attendance',$data); 
							
					
				}
				//------------------------------------------------shift IN / Out
			
				
			}//for

		
			
			echo "Save";

		}//emp_id
	}//function close
	*/
	

	public function attendance_entry_manual_save_employee_wise()
	{
		$today = date("Y-m-d H:i:s");
		$user  = $this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id'); 

		if (empty($_REQUEST['emp_code'])) {
			echo "Invalid Request"; return;
		}

		$emp = $this->Hrmodel->get_emp_details_with_emp_code($_REQUEST['emp_code']);
		if (empty($emp[0])) {
			echo "Employee not found"; return;
		}

		$emp_id     = $emp[0]['id'];
		$emp_code   = $emp[0]['emp_code'];
		$bio_code   = $emp[0]['bio_code'];
		$get_ot     = $emp[0]['get_overtime'] ?? 0;
		$restday    = $emp[0]['restday'] ?? '';
		$working_hr = $emp[0]['working_hr'] ?? 8;
		$company_role = $emp[0]['company_role'] ?? '';
		$late_punch_add = $emp[0]['late_punch_add'] ?? 'No';

		$month = (int)($_REQUEST['month_search'] ?? 0);
		$year  = (int)($_REQUEST['year_search'] ?? 0);
		if (!$month || !$year) { echo "Invalid Month/Year"; return; }

		// //check attendance lock or not
		$rem_date = date('Y-m-d', strtotime("$year-$month-01"));
		$lock = $this->Base->atten_lock_check($rem_date,$emp[0]['id']);
		if($lock) {
			echo "Attendance for this month and year is locked and cannot be modified."; return;
		}
		

		$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		$in  = !empty($_REQUEST['intime'])       ? explode('~', $_REQUEST['intime'])      : [];
		$out = !empty($_REQUEST['outtime'])      ? explode('~', $_REQUEST['outtime'])     : [];
		$att = !empty($_REQUEST['emp_entry_at']) ? explode('~', $_REQUEST['emp_entry_at']): [];
		$emp_entry_ot = explode('~',$_REQUEST['emp_entry_ot']);//OT hours manual entry agr yha value hai to OT me ye jayega.OT calculation nhi hoga.
		$attenid = explode('~',$_REQUEST['attenid']); //daily_attendance id use in update
		$shift = explode('~',$_REQUEST['shift']);//agr G hai to General ho jayega or agr shift ki value hai to wo ayega
		$savefrom = explode('~',$_REQUEST['savefrom']);
		$mcMin = explode('~',$_REQUEST['mcMin']);

		for ($d = 1; $d <= $days; $d++) {

			if (empty($att[$d]) || empty($att[$d])) continue;

			$date   = date('Y-m-d', strtotime("$year-$month-$d"));
			$in_dt  = "$date {$in[$d]}";
			$out_dt = "$date {$out[$d]}";


			$att_monthly_id = $this->Base->processAttendanceCore([
				'emp_id'     => $emp_id,
				'emp_code'   => $emp_code,
				'bio_code'   => $bio_code,
				'company_role' => $company_role,
				'status'     => $att[$d] ?? 'A',
				'manual_duty'    => $att[$d] ?? 'A',
				'manual_ot'     => $emp_entry_ot[$d] ?? '0',
				'manual_shift'  => $shift[$d] ?? '',
				'attenid'      => $attenid[$d] ?? '',
				'att_date'   => $date,
				'in_dt'      => $in_dt,
				'out_dt'     => $out_dt,
				'get_ot'     => $get_ot,
				'restday'    => $restday,
				'working_hr' => $working_hr,
				'dutyMin'       => $mcMin[$d],
				'late_punch_add' => $late_punch_add,
				'source'     => $savefrom[$d],
				'location'   => 'Manual',
				'save_by'    => $user
			]);
		}

		if (!empty($att_monthly_id)) {
			$this->Hrmodel->add_total_present_absent_attendance_monthly($att_monthly_id);
		}

		echo "Save";
	}

	public function attendance_entry_day_fix_save()
	{
		$today = date("Y-m-d H:i:s");
		$user  = $this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id'); 

		$rows = $this->input->post('rows');
		if (empty($rows) || !is_array($rows)) {
			echo json_encode([
				'status' => false,
				'message' => 'Invalid data'
			]);
			return;
		}

		foreach ($rows as $r) {

			$att_monthly_id = $r['att_monthly_id'];
			$entry_date     = $r['entry_date']; // DD-MM-YYYY
			$new_value      = $r['new_value'];

			if (!$att_monthly_id || !$entry_date) continue;

			// DD-MM-YYYY → Y-m-d
			$dt = DateTime::createFromFormat('d-m-Y', $entry_date);
			if (!$dt) continue;

			$day   = (int)$dt->format('d');
			$month = $dt->format('m');
			$year  = $dt->format('Y');

			$day_column = 'd'.$day;

			// update array
			$data = [$day_column => $new_value];
			

			$this->Mymodel->update(
				'daily_attendance_monthly',
				$data,
				['att_monthly_id' => $att_monthly_id,'company_id' => $company_id]
			);

			// recalc present/absent
			$this->Hrmodel
				->add_total_present_absent_attendance_monthly($att_monthly_id);
		}

		echo json_encode([
			'status' => true,
			'message' => 'Saved'
		]);
	}



	//all reports
	public function reports()
	{
		$result['company_role']=$this->Base->get_all_contractor_code();
		$this->load->view('hr/reports',$result);
	}//function close

	//attendance list
	public function attendance_entry_manual()
	{
		$this->Company->checkPermission2("Hr/attendance_entry_manual");
		$result['company_role']=$this->Base->get_all_contractor_code();
		//search
		if(isset($_REQUEST['search']))
		{
			if(isset($_REQUEST['type_search'])){$type_search=$_REQUEST['type_search'];}else{$type_search='';}
			if(isset($_REQUEST['year_search'])){$year_search=$_REQUEST['year_search'];}else{$year_search='';}
			if(isset($_REQUEST['month_search'])){$month_search=$_REQUEST['month_search'];}else{$month_search='';}
			if(isset($_REQUEST['day_search'])){$day_search=$_REQUEST['day_search'];}else{$day_search='';}

			$result['type']=$type_search;
			$result['year']=$year_search;
			$result['month']=$month_search;
			$result['day_search']=$day_search;

			//getting month details like total days, total sunday 
			$result['res2']=$this->Hrmodel->get_atten_details_ym($year_search,$month_search);
			if(strlen($type_search)>1)
			{
				//emp list
				$result['emp']=$this->Hrmodel->get_all_emp_list_for_attendane_type_salary_reports($type_search,$year_search,$month_search);
			}
		}//search
		else
		{
			$result['emp']=array();
		}
		
		$this->load->view('hr/attendance/page1_monthly_report',$result);
	}//function close

	//salary amount report
	public function salary_report_1()
	{
		$format_type = $this->uri->segment(3);
		$result['company_role']=$this->Base->get_all_contractor_code();

		//search
		if(isset($_REQUEST['search']))
		{
			if(isset($_REQUEST['type_search'])){$type_search=$_REQUEST['type_search'];}else{$type_search='';}
			if(isset($_REQUEST['year_search'])){$year_search=$_REQUEST['year_search'];}else{$year_search='';}
			if(isset($_REQUEST['month_search'])){$month_search=$_REQUEST['month_search'];}else{$month_search='';}
			if(isset($_REQUEST['day_search'])){$day_search=$_REQUEST['day_search'];}else{$day_search='';}
			$result['type']=$type_search;
			$result['year']=$year_search;
			$result['month']=$month_search;
			$result['day_search']=$day_search;
			
			//getting month details like total days, total sunday 
			$result['res2']=$this->Hrmodel->get_atten_details_ym($year_search,$month_search);
			if(strlen($type_search)>1)
			{
				$result['emp']=$this->Hrmodel->get_all_emp_list_for_attendane_type_salary_reports($type_search,$year_search,$month_search);//all emp
			}
		}//search
		else
		{
			$result['emp']=array();
		}
		
		
		if($format_type == 'without_ot')
		{
			$this->Company->checkPermission2("Hr/salary_report_1/without_ot");
			$this->load->view('hr/attendance/salary_report_2',$result);
		}
		elseif($format_type == 'incentive')
		{
			$this->Company->checkPermission2("Hr/salary_report_1/incentive");
			$this->load->view('hr/attendance/salary_report_3',$result);
		}
		elseif($format_type == 'master_roll')
		{
			$this->Company->checkPermission2("Hr/salary_report_1/master_roll");
			$this->load->view('hr/attendance/salary_report_21',$result);
		}
		else
		{
			//master
			$this->Company->checkPermission2("Hr/salary_report_1/master");
			$this->load->view('hr/attendance/salary_report_1',$result);
		}
	}//function close



	
	public function salary_report()
	{
		$this->Company->checkPermission2("Hr/salary_report");
		
		if (!$this->input->get('search')) {
			$this->load->view('hr/attendance/salary_report_5', [
				'company_name' => '',
				'rows'         => [],
				'month'        => '',
				'year'         => ''
			]);
			return;
		}

		$company_role = trim($this->input->get('type_search', true));
		$year         = (int) $this->input->get('year_search', true);
		$month        = (int) $this->input->get('month_search', true);

		if (!$company_role || !$year || !$month) {
			show_error('Invalid parameters', 400);
		}

		$company = $this->Base->get_details_contractor_with_id($company_role);
		
		$where = " and a.company_role_id='$company_role' and a.att_year='$year' and a.att_month='$month' ORDER BY B.pay_code ASC ";
		$rows = $this->Hrmodel->get_salary_report($where);

		$data = [
			'company' => $company,
			'rows'         => $rows,
			'month'        => $month,
			'year'         => $year
		];

		$this->load->view('hr/attendance/salary_report_5', $data);
	}







	//salary slip
	public function salary_slip_print_1()
	{
		//company details
		$result['comp'] = $this->Company->profile();
		$result['address'] = $this->Company->dispatch_details();

		
		if(isset($_REQUEST['type_search'])){$type_search=$_REQUEST['type_search'];}else{$type_search='';}
		if(isset($_REQUEST['year_search'])){$year_search=$_REQUEST['year_search'];}else{$year_search='';}
		if(isset($_REQUEST['month_search'])){$month_search=$_REQUEST['month_search'];}else{$month_search='';}
		if(isset($_REQUEST['pay_code'])){$pay_code=$_REQUEST['pay_code'];}else{$pay_code='';}
		
		$result['type']=$type_search;
		$result['year']=$year_search;
		$result['month']=$month_search;
		$result['pay_code']=$pay_code;

		//employee details
		$result['emp'] = $this->Hrmodel->get_emp_deatis_with_id($pay_code);
		$result['res2'] = $this->Hrmodel->get_atten_details_limit($type_search,$pay_code,$year_search,$month_search,1);
		if(!empty($result['res2']))
		{
			$this->load->view('hr/attendance/salary_slip_print_1',$result);
		}//if(!empty($res9))
		else
		{
			echo "Attendance not created of this Month : $month_search, Year : $year_search,  emp_code: $pay_code  ";
		}
		
		
	}//function close


	//salary paramant lock
	public function salary_lock_enable()
	{
		$company_id = $this->session->userdata('company_id');    
		$this->Company->checkPermission2("Hr/salary_generate_entry");
		if(isset($_REQUEST['type_search'])){$type_search=$_REQUEST['type_search'];}else{$type_search='';}
		if(isset($_REQUEST['year_search'])){$year_search=$_REQUEST['year_search'];}else{$year_search='';}
		if(isset($_REQUEST['month_search'])){$month_search=$_REQUEST['month_search'];}else{$month_search='';}
		if(isset($_REQUEST['type2_search'])){$type2_search=$_REQUEST['type2_search'];}else{$type2_search='Canteen';}

		$result['type']=$type_search;
		$result['year']=$year_search;
		$result['month']=$month_search;
		$result['type2']=$type2_search;

		//lock
		$data2=array('edit_disable'=>1);
		$where2=array('company_role_id'=>"$type_search",'att_month'=>"$month_search",'att_year'=>"$year_search", "company_id"=>$company_id);   
		$this->Mymodel->update('daily_attendance_monthly',$data2,$where2);
		echo "$type_search Attendance of this Month: $month_search, Year: $year_search is now locked.";
	}//function close

	//lock remove
	public function salary_lock_disable()
	{
		$company_id = $this->session->userdata('company_id');  
		$this->Company->checkPermission2("Hr/salary_generate_entry");
		if(isset($_REQUEST['type_search'])){$type_search=$_REQUEST['type_search'];}else{$type_search='';}
		if(isset($_REQUEST['year_search'])){$year_search=$_REQUEST['year_search'];}else{$year_search='';}
		if(isset($_REQUEST['month_search'])){$month_search=$_REQUEST['month_search'];}else{$month_search='';}
		if(isset($_REQUEST['type2_search'])){$type2_search=$_REQUEST['type2_search'];}else{$type2_search='Canteen';}

		$result['type']=$type_search;
		$result['year']=$year_search;
		$result['month']=$month_search;
		$result['type2']=$type2_search;

		//lock
		$data2=array('edit_disable'=>0);
		$where2=array('company_role_id'=>"$type_search",'att_month'=>"$month_search",'att_year'=>"$year_search","company_id"=>$company_id);   
		$this->Mymodel->update('daily_attendance_monthly',$data2,$where2);
		echo "$type_search Attendance of this Month: $month_search, Year: $year_search lock remove.";
	}//function close
	
	//------------------------------------Salary Generate start
	public function salary_generate_entry()
	{
		$company_id = $this->session->userdata('company_id');
		$this->Company->checkPermission2("Hr/salary_generate_entry");
		if(isset($_REQUEST['type_search'])){$type_search=$_REQUEST['type_search'];}else{$type_search='';}
		if(isset($_REQUEST['year_search'])){$year_search=$_REQUEST['year_search'];}else{$year_search='';}
		if(isset($_REQUEST['month_search'])){$month_search=$_REQUEST['month_search'];}else{$month_search='';}
		if(isset($_REQUEST['type2_search'])){$type2_search=$_REQUEST['type2_search'];}else{$type2_search='Canteen';}

		$result['type']=$type_search;
		$result['year']=$year_search;
		$result['month']=$month_search;
		$result['type2']=$type2_search;

		$query=" SELECT emp_code FROM daily_attendance_monthly where  company_id='$company_id' and att_year='$year_search' and att_month='$month_search'  GROUP BY emp_code ";
		$res9=$this->Mymodel->query1($query);
		if(!empty($res9))
		{
			foreach($res9 as $e){
				$id = $e['emp_code'];
				$emp=$this->Hrmodel->get_all_emp_list_for_attendane_type_salary_details($id,$type_search,$year_search,$month_search);
			}//foreach
			echo "Salary Generated for $type_search, Month : $month_search, Year : $year_search ";
			echo "<br>";
			echo "if You added new employee then 1st enter one day attendace and than generate salary";
		}//if(!empty($res9))
		else
		{
			echo "Attendance not created of this Month : $month_search, Year : $year_search";
		}
		
		/*
		//------------------------******************************----------------------not permanent save
		$query=" SELECT edit_disable FROM daily_attendance_monthly where   att_year='$year_search' and att_month='$month_search'   LIMIT 1 ";
		$res9=$this->Mymodel->query1($query);
		if(!empty($res9))
		{
			if($res9[0]['edit_disable']==1)
			{
				echo " Attendance or salary saved permanent Month : $month_search, Year : $year_search";
			}
			else
			{
				if(strlen($type_search)>1)
				{
					//emp list
					$emp=$this->Hrmodel->get_all_emp_list_for_attendane_type($type_search);
					foreach($emp as $e)
					{
						//updateing
						echo $id = $e['id'];
						echo "<br>";
						$emp=$this->Hrmodel->get_all_emp_list_for_attendane_type_salary_details($id,$type_search,$year_search,$month_search);	
					}//foreach

					echo "Salary Generated for $type_search, Month : $month_search, Year : $year_search ";
					echo "<br>";
					echo "if You added new employee then 1st enter one day attendace and than generate salary";
				}
				else
				{
					echo "No Search query found.";
				}
			}//if($res9[0]['edit_disable']==1)
		}//if(!empty($res9))
		else
		{
			echo "Attendance not created of this Month : $month_search, Year : $year_search";
		}
		*/
	}//function close


	//------------------------------------Salary Generate start
	public function salary_day_calculate()
	{
		$company_id = $this->session->userdata('company_id');
		$this->Company->checkPermission2("Hr/salary_generate_entry");
		if(isset($_REQUEST['type_search'])){$type_search=$_REQUEST['type_search'];}else{$type_search='';}
		if(isset($_REQUEST['year_search'])){$year_search=$_REQUEST['year_search'];}else{$year_search='';}
		if(isset($_REQUEST['month_search'])){$month_search=$_REQUEST['month_search'];}else{$month_search='';}
		if(isset($_REQUEST['type2_search'])){$type2_search=$_REQUEST['type2_search'];}else{$type2_search='Canteen';}

		$result['type']=$type_search;
		$result['year']=$year_search;
		$result['month']=$month_search;
		$result['type2']=$type2_search;

		$query=" SELECT att_monthly_id FROM daily_attendance_monthly where  company_id='$company_id' and att_year='$year_search' and att_month='$month_search' and company_role_id='$type_search' ";
		$res9=$this->Mymodel->query1($query);
		if(!empty($res9))
		{
			foreach($res9 as $e){
				$att_monthly_id = $e['att_monthly_id'];
				$this->Hrmodel->add_total_present_absent_attendance_monthly($att_monthly_id);
			}//foreach
			echo "Attendance P/A Generated for $type_search, Month : $month_search, Year : $year_search ";
			echo "<br>";
			echo "if You added new employee then 1st enter one day attendace and than generate salary";
		}//if(!empty($res9))
		else
		{
			echo "Attendance not created of this Month : $month_search, Year : $year_search";
		}
		
	
		
	}//function close


	



	
	

	//Atten Punch list search
	//admin
	public function punch_reports()
	{
		$master_roll_access = $this->session->userdata('admin');
		$result['dept']=$this->Base->get_hr_dept();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['shift'])){$shift=$_REQUEST['shift'];$where.=" and  A.shift='$shift'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  B.department_id='$dept'   ";}
			if(!empty($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];$where.=" and  B.emp_code='$emp_code'   ";}
			$where.=" and  B.mater_roll='Yes'   ";
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.shift_in_time between '$search_date1 00:00:00' and '$search_date2 23:59:59'  ";
			}
			$where.=" ORDER by B.first_name,B.last_name,A.in_time ASC ";
			$result['res2'] = $this->Hrmodel->get_all_att_punch_with_search($where);
			$this->load->view('hr/punch/show_table2',$result);
		}
		else
		{
			$search_date1= date('Y-m-d 00:00:00');
			$search_date2= date('Y-m-d 23:59:59');
			$where = " and A.shift_in_time between '$search_date1' and '$search_date2'  ";
			$where.=" and  B.mater_roll='Yes'   ";
			$where.=" ORDER by B.first_name,B.last_name,A.in_time ASC ";
			$result['res2'] = $this->Hrmodel->get_all_att_punch_with_search($where);
			$this->load->view('hr/punch/show2',$result);
		}//search
	}//function close

	
	public function punch_reports2()
	{
		//$master_roll_access = $this->session->userdata('admin');
		$result['dept']=$this->Base->get_hr_dept();
		$result['con']=$this->Base->get_all_contractor_code();
		$result['shifts']=$this->Base->get_all_active_shifts();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['shift'])){$shift=$_REQUEST['shift'];$where.=" and  A.shift='$shift'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  B.department_id='$dept'   ";}
			if(!empty($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];$where.=" and  B.emp_code='$emp_code'   ";}
			
			if(!empty($_REQUEST['bio_id1'])){$bio_id1=$_REQUEST['bio_id1'];$where.=" and  B.bio_code='$bio_id1'   ";}
			if(!empty($_REQUEST['name1'])){$name1=$_REQUEST['name1'];$where.=" and  B.first_name like '%$name1%'   ";}
			if(!empty($_REQUEST['company_role1'])){$company_role1=$_REQUEST['company_role1'];$where.=" and  B.company_role='$company_role1'   ";}
			if(!empty($_REQUEST['search_plant'])){$search_plant=$_REQUEST['search_plant'];$where.=" and  B.plant='$search_plant'   ";}
			
			//if($master_roll_access == 2){$where.=" and  B.mater_roll='Yes'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.shift_in_time between '$search_date1 00:00:00' and '$search_date2 23:59:59'  ";
			}
			$where.=" ORDER by B.first_name,B.last_name,A.in_time ASC ";
			$result['res2'] = $this->Hrmodel->get_all_att_punch_with_search($where);
			$this->load->view('hr/punch/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-d 00:00:00');
			$search_date2= date('Y-m-d 23:59:59');
			$where = " and A.shift_in_time between '$search_date1' and '$search_date2'  ";
			//if($master_roll_access == 2){$where.=" and  B.mater_roll='Yes'   ";}
			$where.=" ORDER by B.first_name,B.last_name,A.in_time ASC ";
			$result['res2'] = $this->Hrmodel->get_all_att_punch_with_search($where);
			$this->load->view('hr/punch/show',$result);
		}//search
	}//function close


	






	
	//liest2 search
	public function list2()
	{
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['search_date1']))
			{
				$search_date= $this->Base->change_date_ymd($_REQUEST['search_date1']);
			}
			else
			{
				$search_date = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			}
			$this->Hrmodel->date_wise_attendance_summary($search_date);
		}
		else
		{
			$result['search_date'] = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			$this->load->view('hr/attendance/show2',$result);
		}//search
	}//function close



	//liest2 search
	public function list3()
	{
		if(isset($_REQUEST['search1']))
		{
			
			if(isset($_REQUEST['show_array'])){$show_array = $_REQUEST['show_array'];}else{$show_array ='No';}
			//if(isset($_REQUEST['show_pic'])){$show_pic = $_REQUEST['show_pic'];}else{$show_pic ='No';}

			if(!empty($_REQUEST['search_date1']))
			{
				$search_date=$_REQUEST['search_date1'];
				
				$this->Hrmodel->get_salary_day_dept_wise($search_date,$show_array);
			}else{
				echo "no search date found";
			}
		}
		else
		{
			$result['search_date'] = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			$this->load->view('hr/attendance/show3',$result);
		}//search
	}//function close


	




	//dept_transfer search
	public function dept_transfer()
	{
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['shift']))
			{
				$test = new DateTime($_REQUEST['search_date1']);$attendance_date = date_format($test, 'Y-m-d');
			 	$shift = $_REQUEST['shift'];
				$dept_list = $this->Base->get_all_dept();
				//print_r($dept_list);
				?>
					<input type="hidden" id="attendance_date"  value="<?php echo $attendance_date;?>"  >
					<input type="hidden" id="attendance_shift"  value="<?php echo $shift;?>"  >
					<div class="table-responsive">
						<h3 align='center'>Date : <?php echo $_REQUEST['search_date1'];?>, Shift : <?php echo $shift;?></h3>
						<table border=1 style="width:100%" id="printed_table">
							<thead style="background-color:<?php //echo $this->Company->table_bg_color();?>; color:<?php //echo $this->Company->table_ft_color();?>;">
								<tr style="font-weight:bold;">
									<td>#</td>
									<td>Dept. ID</td>
									<td>Dept. Name.</td>
									<td>Tranfer Emp. code (eg: 203,204)</td>
								</tr>
							</thead>
							<tbody>
									<?php 
									$i=1;
									$all_list = "";
									foreach($dept_list as $d)
									{
										$dept_id = $d['department_id'];
										$query5=" SELECT * FROM daily_attendance_dept_wise where dept_name ='$dept_id' and attendance_date='$attendance_date' and shift='$shift' ";
										$out5 = $this->Mymodel->query1($query5);
										if(!empty($out5)){$all_list.= ','.$out5[0]['emp_list'];}
										
										?>
											<tr>
												<td width='50'><?php echo $i;?></td>
												<td width='50'><input type="text" class="form-control dept_trs_dept_list" readonly style="height:30px;"   autocomplete="off" value="<?php echo $dept_id;?>"  ></td>
												<td width='180'><?php echo $d['name'];?></td>
												<td><input type="text" class="form-control dept_trs_emp_code_list"  style="height:30px;"   autocomplete="off" value="<?php if(isset($out5[0]['emp_list']))echo $out5[0]['emp_list'];?>"  ></td>
											</tr>
										<?php
										$i++;
									}
									?>
							</tbody>
						</table>

						<div class="col-md-12" style="margin-top:50px;"> 
									<?php 
									$all_list2 = explode(',',$all_list);
									if(!empty($all_list2))
									{
										echo "<h3>These Emp code doesn't have attendance entry in this date</h3>";
										foreach($all_list2 as $a)
										{
											if($a>0)
											{
												$msg2 = $this->Hrmodel->get_emp_attendance_on_this_date($a,$attendance_date);
												if($msg2 != 'YES')
												{
													echo $msg2;
													echo "<br>";
												}
												
											}//$a
										}//foreach
									}//if
									?> 
							</div> 

							<div class="col-md-12" style="margin-top:50px;">                            
								<div class="box-footer">
									<div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
										<button type="button" class="btn btn-success" id="emp_tranfser_save" ><?php echo $attendance_date.','.$shift;?>, Save</button>
									</div>
								</div>
							</div>  

							 
					</div>




					<script>
						$(document).ready(function(e) {
							//attendacne save
							$('#emp_tranfser_save').click(function(){
												
								var attendance_date=$('#attendance_date').val();
								var attendance_shift=$('#attendance_shift').val();
								
								var dept_trs_dept_list = "";
								var dept_trs_emp_code_list = "";
								$(".dept_trs_dept_list").each(function(){	dept_trs_dept_list=dept_trs_dept_list.concat('~').concat($(this).val());	});
								$(".dept_trs_emp_code_list").each(function(){	dept_trs_emp_code_list=dept_trs_emp_code_list.concat('~').concat($(this).val());	});
								
								//-------------------------------save
								$('#wait').show();
								$('#emp_tranfser_save').hide();
								setTimeout(function() {
								jQuery.post("<?php echo base_url().'index.php/Hr/dept_transfer_save';?>", 
										{
											attendance_date:attendance_date,
											attendance_shift:attendance_shift,
											dept_trs_dept_list:dept_trs_dept_list,
											dept_trs_emp_code_list:dept_trs_emp_code_list,
										}, 
										function(data, textStatus)
										{	
											if(data=='Save')
											{
												fun_message('success',data,'Save Successfully','toast-bottom-right');
												//showPage(url);
											}
											else
											{
												fun_message('error','Error',data,'toast-bottom-right');
											}
											$('#wait').hide();
											$('#emp_tranfser_save').show();
										});
								});
			
		
										
							});//function close
						});<!---------document--->
					</script>
						
				<?php
			}
			else
			{
				echo "Select Date & Shift";
			}
			
		}
		else
		{
			$result['search_date'] = date("Y-m-d");
			$this->load->view('hr/dept_transfer',$result);
		}//search
	}//function close





	//dept_transfer search
	public function dept_transfer_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		if(!empty($_REQUEST['attendance_date']) and !empty($_REQUEST['attendance_shift']))
		{
			$attendance_date = $_REQUEST['attendance_date'];
			$attendance_shift = $_REQUEST['attendance_shift'];

			//--------------------------------------row
			if(isset($_REQUEST['dept_trs_dept_list'])){$dept_trs_dept_list = explode('~',$_REQUEST['dept_trs_dept_list']);$no_of_row=count($dept_trs_dept_list);}else{$dept_trs_dept_list='';$no_of_row='';}
			if(isset($_REQUEST['dept_trs_emp_code_list'])){$dept_trs_emp_code_list = explode('~',$_REQUEST['dept_trs_emp_code_list']);}else{$dept_trs_emp_code_list='';} 
			
			$i=0;
			foreach($dept_trs_dept_list as $d)
			{
				if(!empty($d))
				{
					
					$emp_code_list =  $dept_trs_emp_code_list[$i];
					//now check if entry exits in daily_attendance_dept_wise than update else new entry
					$query5=" SELECT id FROM daily_attendance_dept_wise where dept_name ='$d' and attendance_date='$attendance_date' and shift='$attendance_shift' ";
					$out5 = $this->Mymodel->query1($query5);
					if(!empty($out5) and $out5[0]['id']>0)
					{
						$daily_attendance_dept_wise_id = $out5[0]['id'];
						//echo "update";
						$data2 = array(
											'emp_list'=>"$emp_code_list",
											'update_by'=>"$user_email",
											'update_date'=>"$today",
										);
						$where2 = array('id'=>"$daily_attendance_dept_wise_id");   
						$this->Mymodel->update('daily_attendance_dept_wise',$data2,$where2);
					}
					else
					{
						//echo "new";
						$data2 = array(
										'dept_name'=>"$d",
										'attendance_date'=>"$attendance_date",
										'shift'=>"$attendance_shift",
										'emp_list'=>"$emp_code_list",
										'status'=>"Active",
										'save_by'=>"$user_email",
										'save_date'=>"$today",
									);
		  				$daily_attendance_dept_wise_id = $this->Mymodel->insertdata_withid('daily_attendance_dept_wise',$data2);
					}//entry
					//echo "<br>";
				}//if(!empty($d)
				$i++;
			}//foreach
			echo "Save";
		}
		else
		{
			echo "Select Date & Shift";
		}
	}//function close







	//liest2 search
	public function emp_dp2()
	{
		$company_id = $this->session->userdata('company_id');
		?>
			<style>
				@media print {
					.pagebreak { page-break-before: always; } /* page-break-after works, as well */
				}
			</style>
		<?php
		if(isset($_REQUEST['vd'])){$valid = $_REQUEST['vd'];}else{$valid ='31/12/2021';}
		$url =  './pic/employee/dp';
		
		if ($handle = opendir($url)) {
			$i=1;
			while (false !== ($entry = readdir($handle))) 
			{
				if ($entry != "." && $entry != ".." && $entry !='index.html') {
					$j= $i-2;
					$full_file_name = explode('.',$entry);
					$emp_code = $full_file_name[0];
					$query5=" SELECT A.first_name,A.last_name,R.name as rname FROM employee as A LEFT JOIN department_role as R ON R.role_id = A.role_in_department where A.company_id='$company_id' and A.emp_code='$emp_code' ";
					$out5 = $this->Mymodel->query1($query5);
					if(!empty($out5))
					{
						$emp_name = $out5[0]['first_name'].' '.$out5[0]['last_name'];
						$role_name = $out5[0]['rname'];
						$img_url = base_url().'pic/employee/dp/'.$entry;
						
						?>
						
						
							<table cellspacing="0" border="0" style="float:left; margin:5px; width:240px; ">
								
								<tr>
									<td style="border-top: 1px solid #000000;  border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="35" align="center" valign=middle><font color="#000000"><img src="<?php echo base_url().'pic/company/rks_logo.png';?>" style="height:35; width:35px;"></font></td>
									
									</tr>
								<tr>
									<td style="  border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3  align="center" valign=middle><b><font size=3 color="#000000">IDENTITY CARD</font></b></td>
									</tr>
								<tr>
									<td style="border-left: 1px solid #000000" height="100" align="center" valign=middle><font color="#000000"></font></td>
									<td align="center" valign=middle><font color="#000000"><img src="<?php echo $img_url;?>" style="height:130px; width:120px;border: 1px solid #000000; "></font></td>
									<td style="border-right: 1px solid #000000" align="center" valign=middle><font color="#000000"></font></td>
								</tr>
								<tr>
									<td style="  border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan=3  align="center" valign=middle><font size=3 color="#000000"><b><?php echo $emp_name;?></b></font></td>
								</tr>
								<tr>
									<td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;font-size:14px;" colspan=3  align="left" valign=bottom><font color="#000000">Desig : <span style="padding-left:40px;"><?php echo $role_name;?></span></font></td>
								</tr>
								
								<tr>
									<td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;font-size:14px;" colspan=3  align="left" valign=bottom><font color="#000000">Emp. Code : <span style="padding-left:10px;"><?php echo $emp_code;?></span></font></td>
									</tr>
								<tr>
									<td style="  border-left: 1px solid #000000; border-right: 1px solid #000000;font-size:12px;" colspan=3   valign=bottom><font color="#000000">Valid Till : <?php echo $valid;?> <span style="padding-left:80px;">Auth. Sign</span> </font></td>
									</tr>
								<tr>
									<td style="background-color:;  border-top: 1px solid #000000; border-bottom: 1px solid #000000;  border-left: 1px solid #000000; border-right: 1px solid #000000;font-size:12px;" colspan=3  align="center" valign=middle><font color="#000000">
										<span style="color:black;">Address</span>
										
										</font>
										<?php 
											if($j % 8 == 0)  
											{
												?>
												<div class="pagebreak"> </div>
												<?php
											}
										?>
										</td>
								</tr>
								
							</table>

						
									
						
					
						<?php
						
					}//!empty
				}//if

				$i++;
			}//while
		
			closedir($handle);
		}
	}//function close


	public function emp_dp()
	{
		$company_id = $this->session->userdata('company_id');
		if(isset($_REQUEST['vd'])){$valid = $_REQUEST['vd'];}else{$valid ='31/12/2021';}
		$url =  './pic/employee/dp';
		?>
			<style>
				@media print {
					.pagebreak { page-break-before: always; } /* page-break-after works, as well */
				}
			</style>
			<?php
		
				$query5=" 	SELECT A.emp_code,A.first_name,A.last_name,A.profile_pic,R.name as rname FROM employee as A 
							LEFT JOIN department_role as R ON R.role_id = A.role_in_department 
							where A.attendance_entry=0 and A.status='Active' and A.company_id='$company_id' ";
				$res = $this->Mymodel->query1($query5);
		
		
				$i=1;
				foreach($res as $r)	
				{
						$emp_code = $r['emp_code'];
						$emp_name = $r['first_name'].' '.$r['last_name'];
						$role_name = $r['rname'];
						$img_url = base_url().'pic/employee/dp/'.$r['profile_pic'];
						
						?>
						
						
							<table cellspacing="0" border="0" style="float:left; margin:5px; width:240px; ">
								
								<tr>
									<td style="border-top: 1px solid #000000;  border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="35" align="center" valign=middle><font color="#000000"><img src="<?php echo base_url().'pic/company/rks_logo.png';?>" style="height:35; width:35px;"></font></td>
									
									</tr>
								<tr>
									<td style="  border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3  align="center" valign=middle><b><font size=3 color="#000000">IDENTITY CARD</font></b></td>
									</tr>
								<tr>
									<td style="border-left: 1px solid #000000" height="100" align="center" valign=middle><font color="#000000"></font></td>
									<td align="center" valign=middle><font color="#000000"><img src="<?php echo $img_url;?>" style="height:130px; width:120px;border: 1px solid #000000; "></font></td>
									<td style="border-right: 1px solid #000000" align="center" valign=middle><font color="#000000"></font></td>
								</tr>
								<tr>
									<td style="  border-left: 1px solid #000000; border-right: 1px solid #000000;" colspan=3  align="center" valign=middle><font size=3 color="#000000"><b><?php echo $emp_name;?></b></font></td>
								</tr>
								<tr>
									<td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;font-size:14px;" colspan=3  align="left" valign=bottom><font color="#000000">Desig : <span style="padding-left:40px;"><?php echo $role_name;?></span></font></td>
								</tr>
								
								<tr>
									<td style=" border-left: 1px solid #000000; border-right: 1px solid #000000;font-size:14px;" colspan=3  align="left" valign=bottom><font color="#000000">Emp. Code : <span style="padding-left:10px;"><?php echo $emp_code;?></span></font></td>
									</tr>
								<tr>
									<td style="  border-left: 1px solid #000000; border-right: 1px solid #000000;font-size:12px;" colspan=3   valign=bottom><font color="#000000">Valid Till : <?php echo $valid;?> <span style="padding-left:80px;">Auth. Sign</span> </font></td>
									</tr>
								<tr>
									<td style="background-color:;  border-top: 1px solid #000000; border-bottom: 1px solid #000000;  border-left: 1px solid #000000; border-right: 1px solid #000000;font-size:12px;" colspan=3  align="center" valign=middle><font color="#000000">
										<span style="color:black;"></span>
										
										</font>
										<?php 
											if($i % 8 == 0)  
											{
												?>
												<div class="pagebreak"> </div>
												<?php
											}
										?>
										</td>
								</tr>
								
							</table>

						
									
						
					
						<?php
				$i++;
			}//for
	}//function close





	

	//emp_dp_save
	public function emp_dp_save()
	{
		$company_id = $this->session->userdata('company_id');
		if(isset($_REQUEST['emp_dp_save']) and !empty($_REQUEST['emp_code']))
		{
			$emp_code2 = $_REQUEST['emp_code'];

			//check_emp_code
			$emp = $this->Hrmodel->get_emp_code($emp_code2);
			if(empty($emp)){
				echo "Empcode not valid";
				exit;
			}else{
				$emp_id = $emp[0]['id'];
				$emp_code = $emp[0]['emp_code'];
			}
			
			if(isset($_FILES['img1']))
			{
				$img1 = $_FILES['img1'];
				$img_name = $img1['name'];
				$img_temp = $img1['tmp_name'];
			}
			else
			{
				$img_name='';
			}

			//dp
			if(strlen($img_name)>0)
			{
				echo $path1 = "pic/employee/dp/$img_name";  
				move_uploaded_file($img_temp,$path1);
				$data2=array('profile_pic'=>"$img_name");
				$where2=array('emp_code'=>"$emp_code",'company_id'=>"$company_id");   
				$this->Mymodel->update('employee',$data2,$where2);
			}
			redirect(base_url().'index.php/Welcome/home?Hr/emp_dp_save');
		}
		else
		{
			$result['msg'] = '';
			$this->load->view('hr/emp_dp',$result);
		}
	}//function close
	

	public function emp_dp_save2()
	{
		header('Content-Type: application/json');
		$company_id = $this->session->userdata('company_id');

		if (empty($_POST)) {
			echo json_encode(['status'=>'error','message'=>'No POST data']);
			exit;
		}

		$emp_code2 = preg_replace('/[^A-Za-z0-9]/', '', $this->input->post('emp_code'));
		$type     = $this->input->post('type');

		if (!$emp_code2 || !$type) {
			echo json_encode(['status'=>'error','message'=>'Invalid data']);
			exit;
		}

		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}

		if (empty($_FILES['img1']['name'])) {
			echo json_encode(['status'=>'error','message'=>'No file selected']);
			exit;
		}

		/* ---------- Folder + Allowed Types ---------- */
		$map = [
			'profile_pic'  => ['folder'=>'dp',     'types'=>'jpg|jpeg|png',        'resize'=>true],
			'resume_photo' => ['folder'=>'resume', 'types'=>'pdf|doc|docx',         'resize'=>false],
			'epf_photo'    => ['folder'=>'epf',    'types'=>'jpg|jpeg|png|pdf',     'resize'=>false],
			'esi_photo'    => ['folder'=>'esi',    'types'=>'jpg|jpeg|png|pdf',     'resize'=>false],
			'adhar_photo'    => ['folder'=>'adhar',    'types'=>'jpg|jpeg|png|pdf',     'resize'=>false],
			'bank_photo'    => ['folder'=>'bank',    'types'=>'jpg|jpeg|png|pdf',     'resize'=>false],
			'other_id_photo'    => ['folder'=>'pan',    'types'=>'jpg|jpeg|png|pdf',     'resize'=>false],
			'other_docs2_photo'    => ['folder'=>'other_docs2',    'types'=>'jpg|jpeg|png|pdf',     'resize'=>false],
			'other_docs3_photo'    => ['folder'=>'other_docs3',    'types'=>'jpg|jpeg|png|pdf',     'resize'=>false],
			'other_docs4_photo'    => ['folder'=>'other_docs4',    'types'=>'jpg|jpeg|png|pdf',     'resize'=>false],
			'other_docs_photo'    => ['folder'=>'other_docs1',    'types'=>'jpg|jpeg|png|pdf',     'resize'=>false],
		];

		if (!isset($map[$type])) {
			echo json_encode([
				'status'  => 'error',
				'message' => 'Invalid file format. Please check allowed formats shown below.'
			]);
			exit;
		}

		$cfg = $map[$type];
		$uploadPath = FCPATH.'pic/'.$company_id.'/employee/'.$cfg['folder'].'/';

		if (!is_dir($uploadPath)) mkdir($uploadPath, 0755, true);

		/* ---------- Old file delete ---------- */
		$old = $this->Mymodel->select_where('employee', ['emp_code'=>$emp_code,'company_id'=>$company_id]);
		if (!empty($old[0][$type])) {
			@unlink($uploadPath.$old[0][$type]);
		}

		$ext = pathinfo($_FILES['img1']['name'], PATHINFO_EXTENSION);
		$filename = $company_id.'_'.$emp_code.'_'.$type.'_'.time().'.'.$ext;

		$config = [
			'upload_path'   => $uploadPath,
			'allowed_types' => $cfg['types'],
			'file_name'     => $filename,
			'max_size'      => 4096,
			'overwrite'     => true
		];

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('img1')) {
			echo json_encode(['status'=>'error','message'=>strip_tags($this->upload->display_errors())]);
			exit;
		}

		$data = $this->upload->data();

		/* ---------- Resize DP ---------- */
		if ($cfg['resize'] && $data['is_image']) {
			$this->load->library('image_lib');
			$this->image_lib->initialize([
				'image_library'=>'gd2',
				'source_image'=>$data['full_path'],
				'maintain_ratio'=>true,
				'width'=>150,
				'height'=>150,
				'quality'=>'70%'
			]);
			$this->image_lib->resize();
		}
		$this->Mymodel->update('employee', [$type=>$filename], ['emp_code'=>$emp_code,'company_id'=>$company_id]);

	

		echo json_encode([
			'status'  => 'success',
			'message' => 'File uploaded successfully',
			'file'    => $filename
		]);
		exit;
	}


	






	//-------------------------------------------------------------Leave
	public function get_emp_leave_master_data()
	{
		$company_id = $this->session->userdata('company_id');
		if(isset($_REQUEST['emp_code'])){$emp_code2=$_REQUEST['emp_code'];}else{$emp_code2='';}
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}

		$query=" SELECT B.is_leave_eligible,
						B.leave_yearly,
						B.leave_cl,
						B.leave_sl,
						B.leave_el
					FROM employee B 
					WHERE B.emp_code='$emp_code' and company_id='$company_id'
			";
		$res=$this->Mymodel->query1($query);
		if(!empty($res)){
			echo json_encode($res[0]);   // single record
		}else{
			echo json_encode([]);
		}
	}
	
	public function add_emp_leave()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_advance_data_with_id($id);
		}//strlen
		$this->load->view('hr/leave/emp_leave',$result);
	}//function close
	public function emp_leave_master_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['emp_code'])){$emp_code2=$_REQUEST['emp_code'];}else{$emp_code2='';}
		if(isset($_REQUEST['is_leave_eligible'])){$is_leave_eligible=$_REQUEST['is_leave_eligible'];}else{$is_leave_eligible='No';}
		if(isset($_REQUEST['leave_yearly'])){$leave_yearly=$_REQUEST['leave_yearly'];}else{$leave_yearly='';}
		if(isset($_REQUEST['leave_cl'])){$leave_cl=$_REQUEST['leave_cl'];}else{$leave_cl='';}
		if(isset($_REQUEST['leave_sl'])){$leave_sl=$_REQUEST['leave_sl'];}else{$leave_sl='';}
		if(isset($_REQUEST['leave_el'])){$leave_el=$_REQUEST['leave_el'];}else{$leave_el='';}
		
		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}
		
		
		$data=array(
						'is_leave_eligible'=>"$is_leave_eligible",
						'leave_yearly'=>"$leave_yearly",
						'leave_cl'=>"$leave_cl",
						'leave_sl'=>"$leave_sl",
						'leave_el'=>"$leave_el",
					);
		$where=array('id'=>"$emp_id");  
		$this->Mymodel->update('employee',$data,$where);
		echo "Save";
		
	}//function close


	public function add_leave()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_leave_data_with_id($id);
		}//strlen
		$this->load->view('hr/leave/entry',$result);
	}//function close

	public function add_leave2()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_leave_data_with_id($id);
		}//strlen
		$this->load->view('hr/leave/entry2',$result);
	}//function close


	//form entry page
	public function getEmpLeaveDetails()
	{
		if(isset($_REQUEST['search1']))
		{
			 $data = $this->Hrmodel->get_leave_history_emp_code($_REQUEST['emp_code']);
            if(!empty($data)){
				$this->Hrmodel->get_leave_history_emp_code_table($data,0); 
			}
		}
	}//function close


	//list search
	public function list_leave()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['status'])){$status=$_REQUEST['status'];$where.=" and  A.status='$status'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  E.department_id='$dept'   ";}
			if(!empty($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];$where.=" and  A.emp_code='$emp_code'   ";}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.ask_from_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.ask_from_date DESC ";
			$result['res2'] = $this->Hrmodel->get_all_leave_with_search($where);

			$this->load->view('hr/leave/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$where = " and A.ask_from_date between '$search_date1' and '$search_date2'  ORDER by A.ask_from_date DESC ";
			$result['res2'] = $this->Hrmodel->get_all_leave_with_search($where);
			$this->load->view('hr/leave/show',$result);
		}//search
	}//function close
								
						
	//emp_leave_save 
	public function emp_leave_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id'); 
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		
		if(isset($_REQUEST['emp_code'])){$emp_code2=$_REQUEST['emp_code'];}else{$emp_code2='';}
		if(isset($_REQUEST['father_name'])){$father_name=$_REQUEST['father_name'];}else{$father_name='';}
		if(isset($_REQUEST['mob'])){$mob=$_REQUEST['mob'];}else{$mob='';}
		if(isset($_REQUEST['department_id'])){$department_id=$_REQUEST['department_id'];}else{$department_id='';}
		if(isset($_REQUEST['role_id'])){$role_id=$_REQUEST['role_id'];}else{$role_id='';}	
		if(isset($_REQUEST['present_address'])){$present_address=$_REQUEST['present_address'];}else{$present_address='';}
		if(isset($_REQUEST['permanent_address'])){$permanent_address=$_REQUEST['permanent_address'];}else{$permanent_address='';} 
		if(isset($_REQUEST['reason_for'])){$reason_for=$_REQUEST['reason_for'];}else{$reason_for='';}
		if(isset($_REQUEST['reason'])){$reason=$_REQUEST['reason'];}else{$reason='';}

		if(!empty($_REQUEST['ask_from_date'])){$ask_from_date = $this->Base->change_date_ymd($_REQUEST['ask_from_date']);}else{$ask_from_date="0000-00-00";}
		if(!empty($_REQUEST['ask_to_date'])){$ask_to_date = $this->Base->change_date_ymd($_REQUEST['ask_to_date']);}else{$ask_to_date="0000-00-00";}
		if(isset($_REQUEST['ask_total_days'])){$ask_total_days=$_REQUEST['ask_total_days'];}else{$ask_total_days='';}
		if(!empty($_REQUEST['approve_from_date'])){$approve_from_date = $this->Base->change_date_ymd($_REQUEST['approve_from_date']);}else{$approve_from_date="0000-00-00";}
		if(!empty($_REQUEST['approve_to_date'])){$approve_to_date = $this->Base->change_date_ymd($_REQUEST['approve_to_date']);}else{$approve_to_date="0000-00-00";}
		if(isset($_REQUEST['approve_total_days'])){$approve_total_days=$_REQUEST['approve_total_days'];}else{$approve_total_days='';}
		
		if(isset($_REQUEST['sign_supervisor'])){$sign_supervisor=$_REQUEST['sign_supervisor'];}else{$sign_supervisor='';}
		if(isset($_REQUEST['sup_name'])){$sup_name=$_REQUEST['sup_name'];}else{$sup_name='';}
		if(isset($_REQUEST['status'])){$status=$_REQUEST['status'];}else{$status='';}

		if($sign_supervisor == 'Reject'){
			$approve_from_date="0000-00-00";
			$approve_to_date="0000-00-00";
		}

		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}

		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['emp_code']))
		{
			$data=array(
							'company_id'=>"$company_id",
							'emp_code'=>"$emp_code",
							'reason_for'=>"$reason_for",
							'reason'=>"$reason",
							
							'ask_from_date'=>"$ask_from_date",
							'ask_to_date'=>"$ask_to_date",
							'ask_total_days'=>"$ask_total_days",
							'approve_from_date'=>"$approve_from_date",
							'approve_to_date'=>"$approve_to_date",
							'approve_total_days'=>"$approve_total_days",
							
							'sign_supervisor'=>"$sign_supervisor",
							'sup_name'=>"$sup_name",
							'status'=>"$status",
								
							'save_by'=>"$user_email",
							'save_date'=>"$today",
							
							);
			$cat_id=$this->Mymodel->insertdata_withid('emp_leave',$data);
			if($status == "Approve"){$this->leave_update_in_attendance($emp_code,$approve_from_date,$approve_to_date);}
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['emp_code']))
		{
			$data=array(
								'emp_code'=>"$emp_code",
								'reason_for'=>"$reason_for",
								'reason'=>"$reason",
								
								'ask_from_date'=>"$ask_from_date",
								'ask_to_date'=>"$ask_to_date",
								'ask_total_days'=>"$ask_total_days",
								'approve_from_date'=>"$approve_from_date",
								'approve_to_date'=>"$approve_to_date",
								'approve_total_days'=>"$approve_total_days",
								
								'sign_supervisor'=>"$sign_supervisor",
								'sup_name'=>"$sup_name",
								'status'=>"$status",
							 
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
			$where=array('id'=>"$id");   
			$this->Mymodel->update('emp_leave',$data,$where);
			
			if($status == "Approve"){$this->leave_update_in_attendance($emp_code,$approve_from_date,$approve_to_date);}
			echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close


	public function emp_leave_save2()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['emp_code'])){$emp_code2=$_REQUEST['emp_code'];}else{$emp_code2='';}
		if(isset($_REQUEST['reason_for'])){$reason_for=$_REQUEST['reason_for'];}else{$reason_for='';}
		if(isset($_REQUEST['reason'])){$reason=$_REQUEST['reason'];}else{$reason='';}
		if(!empty($_REQUEST['ask_from_date'])){$ask_from_date = $this->Base->change_date_ymd($_REQUEST['ask_from_date']);}else{$ask_from_date="0000-00-00";}
		if(!empty($_REQUEST['ask_to_date'])){$ask_to_date = $this->Base->change_date_ymd($_REQUEST['ask_to_date']);}else{$ask_to_date="0000-00-00";}
		if(isset($_REQUEST['ask_total_days'])){$ask_total_days=$_REQUEST['ask_total_days'];}else{$ask_total_days='';}

		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['emp_code']))
		{
			$data=array(
							'emp_code'=>"$emp_code",
							'company_id'=>"$company_id",
							'reason_for'=>"$reason_for",
							'reason'=>"$reason", 
							
							'ask_from_date'=>"$ask_from_date",
							'ask_to_date'=>"$ask_to_date",
							'ask_total_days'=>"$ask_total_days",
								
							'save_by'=>"$user_email",
							'save_date'=>"$today",
							);
			$save_id=$this->Mymodel->insertdata_withid('emp_leave',$data);
			echo "Save";
		}//insert
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close


	public function leave_update_in_attendance($emp_code,$from_date,$to_date)
	{
		$company_id = $this->session->userdata('company_id');
		$res = $this->Hrmodel->get_emp_details_with_emp_code($emp_code);
		if(!empty($res))
		{
			$emp_id  = $res[0]['id'];
			$company_role_id  = $res[0]['company_role'];
		
			$date_list = $this->Base->get_day_list_bet_two_dates($from_date,$to_date);
			foreach($date_list as $date)
			{
				$test = new DateTime($date);
				$day = (int)date_format($test, 'd');
				$month = date_format($test, 'm');
				$year = date_format($test, 'Y');
				$day_colomn = "d$day";

				if(empty($month) or empty($year)){echo "Leave not able to update in attendance table";exit;}
			
				//--------checking no of days in this month
				$total_day_in_month=cal_days_in_month(CAL_GREGORIAN,$month,$year);
				//---------------Getting no of sunday
				$no_of_sunday_array = $this->Base->getSundays2($year, $month);
				$total_sunday=count($no_of_sunday_array);
				
				
				//attndance
				$out = $this->Hrmodel->get_atten_table_id($emp_id,$year,$month);
				if(!empty($out) and $out[0]['att_monthly_id']>0)
				{
					//update
					$att_monthly_id=$out[0]['att_monthly_id'];
					$data2=array(
								"$day_colomn"=>"L",
								'total_day_in_month'=>"$total_day_in_month",
								'total_sunday'=>"$total_sunday",
							);
				 	$where2=array('att_monthly_id'=>"$att_monthly_id",'company_id'=>"$company_id");   
					$this->Mymodel->update('daily_attendance_monthly',$data2,$where2); 
					 
				}
				else
				{
					//new
					$data2=array(
								'company_id'=>"$company_id",
								'emp_code'=>"$emp_id",
								'company_role_id'=>"$company_role_id",
								'att_year'=>"$year",
								'att_month'=>"$month",
								"$day_colomn"=>"L",
								'total_day_in_month'=>"$total_day_in_month",
								'total_sunday'=>"$total_sunday",
							);
					$att_monthly_id = $this->Mymodel->insertdata_withid('daily_attendance_monthly',$data2);
				}//att_monthly_id

				if(!empty($att_monthly_id))
				{
					//update total present and total absent and total sunday
					$this->Hrmodel->add_total_present_absent_attendance_monthly($att_monthly_id);
				}//$att_monthly_id
				else
				{
					echo "No employee data found";
					exit;
				}
				
				
			}//forech date
		}//if(!empty($res))
	}//function close

	
	

	//-------------------------------------------------------------advance
	public function add_advance()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_advance_data_with_id($id);
		}//strlen
		$this->load->view('hr/advance/entry',$result);
	}//function close

	//form entry page
	public function getEmpAdvanceDetails()
	{
		if(isset($_REQUEST['search1']))
		{
			$data = $this->Hrmodel->get_advance_history_emp_code($_REQUEST['emp_code']);
			if(!empty($data)){
				$this->Hrmodel->get_advance_history_emp_code_table($data,0); 
				
				//DOJ
				echo "<br>";
				if(!empty($data[0]['doj']) and $data[0]['doj']!='0000-00-00'){ echo "Date of last Join: ".$this->Base->change_date_dmy($data[0]['doj']);}
			}
		}

		if(isset($_REQUEST['search2']))
		{
			$data = $this->Hrmodel->get_other_application_emp_code_type($_REQUEST['emp_code'],$_REQUEST['type']);
			if(!empty($data)){
				$this->Hrmodel->get_other_appli_history_emp_code_table($data,0,$_REQUEST['type']); 
				
				//DOJ
				echo "<br>";
				if(!empty($data[0]['doj']) and $data[0]['doj']!='0000-00-00'){ echo "Date of last Join: ".$this->Base->change_date_dmy($data[0]['doj']);}
			}
		}
	}//function close



	//list search
	public function list_advance()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['status'])){$status=$_REQUEST['status'];$where.=" and  A.status='$status'   ";}
			if(!empty($_REQUEST['payment_type'])){$payment_type=$_REQUEST['payment_type'];$where.=" and  A.payment_type='$payment_type'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  E.department_id='$dept'   ";}
			if(!empty($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];$where.=" and  A.emp_code='$emp_code'   ";}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.ask_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.ask_date ASC ";
			$result['res2'] = $this->Hrmodel->get_all_advance_with_search($where);
			$year = (int)$this->Base->change_date_into_year($search_date1);
			$month = (int)$this->Base->change_date_into_month($search_date1);
			//get attendance of given month
			$result['att'] = $this->Hrmodel->get_all_emp_code_from_salary_list($year,$month);
			$this->load->view('hr/advance/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$year = (int)$this->Base->change_date_into_year($search_date1);
			$month = (int)$this->Base->change_date_into_month($search_date1);
			//get attendance of given month
			$result['att'] = $this->Hrmodel->get_all_emp_code_from_salary_list($year,$month);

			$where = " and A.ask_date between '$search_date1' and '$search_date2'  ORDER by A.ask_date ASC ";
			$result['res2'] = $this->Hrmodel->get_all_advance_with_search($where);
			$this->load->view('hr/advance/show',$result);
		}//search
	}//function close

	//emp_advance_save 
	public function emp_advance_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		
		if(isset($_REQUEST['emp_code'])){$emp_code2=$_REQUEST['emp_code'];}else{$emp_code2='';}
		if(isset($_REQUEST['father_name'])){$father_name=$_REQUEST['father_name'];}else{$father_name='';}
		if(isset($_REQUEST['mob'])){$mob=$_REQUEST['mob'];}else{$mob='';}
		if(isset($_REQUEST['department_id'])){$department_id=$_REQUEST['department_id'];}else{$department_id='';}
		if(isset($_REQUEST['role_id'])){$role_id=$_REQUEST['role_id'];}else{$role_id='';}	
		if(isset($_REQUEST['present_address'])){$present_address=$_REQUEST['present_address'];}else{$present_address='';}
		if(isset($_REQUEST['permanent_address'])){$permanent_address=$_REQUEST['permanent_address'];}else{$permanent_address='';} 
		
		if(!empty($_REQUEST['ask_date'])){$ask_date = $this->Base->change_date_ymd($_REQUEST['ask_date']);}else{$ask_date="0000-00-00";}
		if(isset($_REQUEST['ask_amount'])){$ask_amount=$_REQUEST['ask_amount'];}else{$ask_amount='';}
		if(isset($_REQUEST['reason_for'])){$reason_for=$_REQUEST['reason_for'];}else{$reason_for='';}

		if(isset($_REQUEST['approve_amount'])){$approve_amount=$_REQUEST['approve_amount'];}else{$approve_amount='';}
		if(isset($_REQUEST['payment_type'])){$payment_type=$_REQUEST['payment_type'];}else{$payment_type='';}
		if(isset($_REQUEST['status'])){$status=$_REQUEST['status'];}else{$status='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}

		
		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}


		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['emp_code']))
		{
			$data=array(
							'emp_code'=>"$emp_code",
							'company_id'=>"$company_id",
							'ask_date'=>"$ask_date",
							'ask_amount'=>"$ask_amount",
							'reason_for'=>"$reason_for",
							
							'approve_amount'=>"$approve_amount",
							'payment_type'=>"$payment_type",
							'status'=>"$status", 
							'remarks'=>"$remarks",
								
							'save_by'=>"$user_email",
							'save_date'=>"$today",
							);
			$cat_id=$this->Mymodel->insertdata_withid('emp_advance',$data);
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['emp_code']))
		{
			$data=array(
								'emp_code'=>"$emp_code",
								
								'ask_date'=>"$ask_date",
								'ask_amount'=>"$ask_amount",
								'reason_for'=>"$reason_for",
								
								'approve_amount'=>"$approve_amount",
								'payment_type'=>"$payment_type",
								'status'=>"$status",
								'remarks'=>"$remarks",
							 
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
			$where=array('id'=>"$id");   
			$this->Mymodel->update('emp_advance',$data,$where);
			echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close



	//---------------------------------------------------Loan
	public function add_emp_loan()
	{
		$result['dept'] = $this->Base->get_hr_dept();
		$result['role'] = $this->Base->get_all_dept_role();

		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Hrmodel->get_loan_data_with_id($id);
		}
		$this->load->view('hr/loan/entry', $result);
	}

	public function list_emp_loan()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['status'])){$status=$_REQUEST['status'];$where.=" and  A.status='$status'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  E.department_id='$dept'   ";}
			if(!empty($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];$where.=" and  A.emp_code='$emp_code'   ";}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.created_at between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ";
			$result['res2'] = $this->Hrmodel->get_all_loan_with_search($where);
			$this->load->view('hr/loan/show_table',$result);
		}
		else
		{
			$where = " and A.status='RUNNING'  ";
			$result['res2'] = $this->Hrmodel->get_all_loan_with_search($where);
			$this->load->view('hr/loan/show',$result);
		}//search
	}//function close

		
	public function loan_statement($loan_id)
	{
		$company_id = $this->session->userdata('company_id');
		// 1️⃣ Loan master
		$loan = $this->db
			->get_where('employee_loan', ['loan_id' => $loan_id,'company_id' => $company_id])
			->row_array();

		if (empty($loan)) {
			show_error('Invalid Loan ID');
		}

		// 2️⃣ EMI recovery history (SOURCE OF TRUTH)
		$emis = $this->db->query("
			SELECT 
				r.pay_month,
				r.deducted_amount,
				r.payroll_run_id,
				r.created_at
			FROM employee_loan_emi_recovery r
			WHERE r.loan_id = ? and r.company_id = ?
			ORDER BY r.pay_month ASC, r.created_at ASC
		", [$loan_id,$company_id])->result_array();

		// 3️⃣ Running balance
		$balance = (float)$loan['loan_amount'];

		foreach ($emis as &$e) {
			$e['opening_balance'] = $balance;
			$balance -= (float)$e['deducted_amount'];
			$e['closing_balance'] = max($balance, 0);
		}
		unset($e);

		// 4️⃣ Send to view
		$data = [
			'loan' => $loan,
			'emis' => $emis
		];

		$this->load->view('hr/loan/loan_statement_view', $data);
	}

	public function employee_full_loan_ledger($emp_code)
	{
		$company_id = $this->session->userdata('company_id');
		// Employee + Dept
		$emp = $this->db->query("
			SELECT 
				E.emp_code,
				CONCAT(E.first_name,' ',E.last_name) AS emp_name,
				D.name AS dname
			FROM employee E
			LEFT JOIN department D ON E.department_id = D.department_id
			WHERE E.emp_code = ? and E.company_id = ?
		", [$emp_code,$company_id])->row_array();

		if (empty($emp)) {
			show_error('Invalid Employee');
		}

		// Loan + Recovery Ledger
		$rows = $this->db->query("
			SELECT 
				L.loan_id,
				L.loan_amount,
				R.pay_month,
				R.deducted_amount,
				R.created_at
			FROM employee_loan L
			JOIN employee_loan_emi_recovery R 
				ON R.loan_id = L.loan_id
			WHERE L.emp_code = ? and L.company_id = ?
			ORDER BY L.loan_id ASC, R.pay_month ASC, R.created_at ASC
		", [$emp_code,$company_id])->result_array();

		// Running balance per loan
		$ledger = [];
		foreach ($rows as $r) {
			$loan_id = $r['loan_id'];

			if (!isset($ledger[$loan_id])) {
				$ledger[$loan_id]['loan_amount'] = $r['loan_amount'];
				$ledger[$loan_id]['balance']     = $r['loan_amount'];
				$ledger[$loan_id]['rows']        = [];
			}

			$opening = $ledger[$loan_id]['balance'];
			$closing = max($opening - $r['deducted_amount'], 0);

			$ledger[$loan_id]['rows'][] = [
				'pay_month'        => $r['pay_month'],
				'opening_balance' => $opening,
				'deducted'        => $r['deducted_amount'],
				'closing_balance' => $closing,
			];

			$ledger[$loan_id]['balance'] = $closing;
		}

		$data = [
			'emp'    => $emp,
			'ledger' => $ledger
		];

		$this->load->view('hr/loan/employee_full_loan_ledger', $data);
	}







	public function saveEmployeeLoan()
	{
		$today    = date("Y-m-d H:i:s");
		$login_id = $this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');

		$id            = $this->input->post('id');
		$emp_code2      = $this->input->post('emp_code');
		$interest_type = $this->input->post('interest_type');
		$loan_amount   = (float)$this->input->post('loan_amount');
		$interest_rate = (float)$this->input->post('interest_rate');
		$tenure        = (int)$this->input->post('tenure');
		$emi_amount    = (float)$this->input->post('emi_amount');
		$remarks       = $this->input->post('remarks');
		$status        = $this->input->post('status');

		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}

		$start_month_raw = $this->input->post('start_month');
		$start_month     = date('Y-m-01', strtotime($start_month_raw));

		if (empty($status)) $status = 'RUNNING';

		/* ================= VALIDATION ================= */
		if (
			empty($emp_code) ||
			empty($interest_type) ||
			$loan_amount <= 0 ||
			$tenure <= 0 ||
			$emi_amount <= 0 ||
			empty($start_month_raw)
		) {
			echo "Invalid Data";
			return;
		}

		if (
			($interest_type === 'FLAT' || $interest_type === 'REDUCING') &&
			$interest_rate <= 0
		) {
			echo "Interest rate required";
			return;
		}

		/* ================= INSERT ================= */
		if (empty($id)) {

			$data = [
				'company_id'       => $company_id,
				'emp_code'       => $emp_code,
				'interest_type'  => $interest_type,
				'loan_amount'    => $loan_amount,
				'interest_rate'  => $interest_rate,
				'tenure_months'  => $tenure,
				'emi_amount'     => $emi_amount,
				'start_month'    => $start_month,
				'status'         => 'RUNNING',
				'remarks'        => $remarks,
				'created_by'     => $login_id,
				'created_at'     => $today
			];

			$loan_id = $this->Mymodel->insertdata_withid('employee_loan', $data);
			$this->generateLoanEMI($loan_id);

			echo "Save";
			return;
		}

		/* ================= UPDATE ================= */

		// ❌ Cannot modify structure if any recovery exists
		$recovery_exists = $this->db
			->where('loan_id', $id)
			->count_all_results('employee_loan_emi_recovery');

		if ($recovery_exists > 0) {

			// Only remarks & status allowed
			if ($status === 'CLOSED') {

				$pending = $this->db->where('loan_id', $id)
									->where_in('status', ['PENDING','PARTIAL'])
									->count_all_results('employee_loan_emi');

				if ($pending > 0) {
					echo "Cannot close loan. Pending / Partial EMI exists.";
					return;
				}
			}

			$this->Mymodel->update(
				'employee_loan',
				[
					'remarks'    => $remarks,
					'status'     => $status,
					'updated_by' => $login_id,
					'updated_at' => $today
				],
				['loan_id' => $id]
			);

			echo "Update";
			return;
		}

		// ✅ SAFE TO MODIFY & REGENERATE EMI
		$this->Mymodel->update(
			'employee_loan',
			[
				'interest_type' => $interest_type,
				'loan_amount'   => $loan_amount,
				'interest_rate' => $interest_rate,
				'tenure_months' => $tenure,
				'emi_amount'    => $emi_amount,
				'start_month'   => $start_month,
				'remarks'       => $remarks,
				'status'        => $status,
				'updated_by'    => $login_id,
				'updated_at'    => $today
			],
			['loan_id' => $id]
		);

		$this->db->where('loan_id', $id)->delete('employee_loan_emi');
		$this->generateLoanEMI($id);

		echo "Update";
	}



		/* =========================================================
		EMI GENERATION FUNCTION (FINAL & SAFE)
		========================================================= */
		private function generateLoanEMI($loan_id)
	{
		// Prevent duplicate generation
		$exists = $this->db->where('loan_id', $loan_id)
						->count_all_results('employee_loan_emi');
		if ($exists > 0) return;

		$loan = $this->Mymodel->select_where(
			'employee_loan',
			"loan_id='$loan_id'"
		);

		if (empty($loan) || !isset($loan[0])) return;

		$loan = $loan[0];

		$amount = (float)$loan['loan_amount'];
		$rate   = (float)$loan['interest_rate'];
		$tenure = (int)$loan['tenure_months'];
		$emi    = (float)$loan['emi_amount'];
		$type   = $loan['interest_type'];

		$balance = $amount;
		$start   = date('Y-m-01', strtotime($loan['start_month']));

		for ($i = 0; $i < $tenure; $i++) {

			$emi_month = date('Y-m-01', strtotime("+$i month", strtotime($start)));

			$interest  = 0;
			$principal = $emi;

			if ($type === 'REDUCING') {
				$r = $rate / 12 / 100;
				$interest  = round($balance * $r, 2);
				$principal = round($emi - $interest, 2);
			}

			$balance = round($balance - $principal, 2);
			if ($balance < 0) $balance = 0;

			$this->Mymodel->insertdata('employee_loan_emi', [
				'loan_id'          => $loan_id,
				'emi_month'        => $emi_month,
				'emi_amount'       => $emi,
				'principal_amount' => $principal,
				'interest_amount'  => $interest,
				'recovered_amount' => 0,
				'status'           => 'PENDING'
			]);
		}
	}


	//------------------------------------------------other application form like gatepass/ fine/ complain/ memo/ accident/ resign
	public function add_other()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_other_application_with_id($id);
		}//strlen
		$this->load->view('hr/other/entry',$result);
	}//function close

	public function add_gatepass()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_other_application_with_id($id);
		}//strlen
		$this->load->view('hr/other/gatepass',$result);
	}//function close

	public function add_tds()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_emp_tds_id($id);
		}//strlen
		$this->load->view('hr/tds/entry',$result);
	}//function close

	public function tds_list()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['search_type'])){$search_type=$_REQUEST['search_type'];$where.=" and  A.type='$search_type'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  E.department_id='$dept'   ";}
			if(!empty($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];$where.=" and  A.emp_code='$emp_code'   ";}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.entry_date DESC ";
			$result['res2'] = $this->Hrmodel->get_emp_tds_with_search($where);
			$this->load->view('hr/tds/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$where = "  and A.entry_date between '$search_date1' and '$search_date2'  ORDER by A.entry_date DESC ";
			$result['res2'] = $this->Hrmodel->get_emp_tds_with_search($where);
			$this->load->view('hr/tds/show',$result);
		}//search
	}//function close

	public function add_tds_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['emp_code'])){
			$emp_code2=$_REQUEST['emp_code'];
		}else{
			echo "Enter empcode";
			exit;
		}
		if(!empty($_REQUEST['entry_date'])){$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}else{
			echo "Entry date not valid";
			exit;
		}
		if(isset($_REQUEST['amount'])){$amount=$_REQUEST['amount'];}else{$amount='';}	
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		if(isset($_REQUEST['status'])){$status=$_REQUEST['status'];}else{$status='Pending';}

		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}
		
		// Prepare data for insert/update
		$data = [
				'company_id' => $company_id,
				'emp_code' => $emp_code,
				'entry_date' => $entry_date,
				'amount' => $amount,
				'remarks' => $remarks,
				'status' => $status,
				'adjust_in_salary' => "No",
			];


		// Insert or Update
		if (empty($id) && !empty($emp_code)) {
			$data['save_by'] = $user_email;
			$data['save_date'] = $today;

			$this->Mymodel->insertdata_withid('emp_tds', $data);
			echo "Save";
		} elseif (!empty($id) && !empty($emp_code)) {
			$data['update_by'] = $user_email;
			$data['update_date'] = $today;

			$this->Mymodel->update('emp_tds', $data, ['id' => $id]);
			echo "Update";
		} else {
			echo "Not Save. Try Again. No Data Found.";
		}
	}//function close

	public function add_reim()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_emp_reim_id($id);
		}//strlen
		$this->load->view('hr/reim/entry',$result);
	}//function close

	public function reim_list()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['search_type'])){$search_type=$_REQUEST['search_type'];$where.=" and  A.type='$search_type'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  E.department_id='$dept'   ";}
			if(!empty($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];$where.=" and  A.emp_code='$emp_code'   ";}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.entry_date DESC ";
			$result['res2'] = $this->Hrmodel->get_emp_reim_with_search($where);
			$this->load->view('hr/reim/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$where = "  and A.entry_date between '$search_date1' and '$search_date2'  ORDER by A.entry_date DESC ";
			$result['res2'] = $this->Hrmodel->get_emp_reim_with_search($where);
			$this->load->view('hr/reim/show',$result);
		}//search
	}//function close

	public function add_reim_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['emp_code'])){
			$emp_code2=$_REQUEST['emp_code'];
		}else{
			echo "Enter empcode";
			exit;
		}
		if(!empty($_REQUEST['entry_date'])){$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}else{
			echo "Entry date not valid";
			exit;
		} 
		if(isset($_REQUEST['subject'])){$subject=$_REQUEST['subject'];}else{$subject='';}	
		if(isset($_REQUEST['amount'])){$amount=$_REQUEST['amount'];}else{$amount='';}	
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		if(isset($_REQUEST['status'])){$status=$_REQUEST['status'];}else{$status='Pending';}

		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}
		
		// Prepare data for insert/update
		$data = [
				'company_id' => $company_id,
				'emp_code' => $emp_code,
				'entry_date' => $entry_date,
				'subject' => $subject,
				'amount' => $amount,
				'remarks' => $remarks,
				'status' => $status,
				'adjust_in_salary' => "No",
			];


		// Insert or Update
		if (empty($id) && !empty($emp_code)) {
			$data['save_by'] = $user_email;
			$data['save_date'] = $today;

			$this->Mymodel->insertdata_withid('emp_reimbursement_master', $data);
			echo "Save";
		} elseif (!empty($id) && !empty($emp_code)) {
			$data['update_by'] = $user_email;
			$data['update_date'] = $today;

			$this->Mymodel->update('emp_reimbursement_master', $data, ['id' => $id]);
			echo "Update";
		} else {
			echo "Not Save. Try Again. No Data Found.";
		}
	}//function close

	public function add_unit_transfer()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		$result['company_role']=$this->Base->get_all_contractor_code();
		$this->load->view('hr/change/unit',$result);
	}//function close

	public function unit_transfer_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['emp_code'])){
			$emp_code2=$_REQUEST['emp_code'];
		}else{
			echo "Enter empcode";
			exit;
		}
		
		if(isset($_REQUEST['new_company_role'])){
			$new_company_role=$_REQUEST['new_company_role'];
		}else{
			echo "Select new unit";
			exit;
		}	
		

		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}
		
		//update employee table
		$data = ['company_role' => $new_company_role];
		$this->Mymodel->update('employee', $data, ['emp_code' => $emp_code,'company_id' => $company_id]);

		//update in daily_attendance_monthly
		$data = ['company_role_id' => $new_company_role];
		$this->Mymodel->update('daily_attendance_monthly', $data, ['emp_code' => $emp_id,'company_id' => $company_id]);


		echo "Update";
	}//function close

	public function update_emp_code()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		$result['company_role']=$this->Base->get_all_contractor_code();
		$this->load->view('hr/change/empcode',$result);
	}//function close

	
	

	public function update_emp_code_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['old_emp_code'])){
			$old_emp_code=$_REQUEST['old_emp_code'];
		}else{
			echo "Enter empcode";
			exit;
		}
		
		if(isset($_REQUEST['new_emp_code'])){
			$new_emp_code=$_REQUEST['new_emp_code'];
		}else{
			echo "Select new empcode";
			exit;
		}	
		

		//check old emp code valid or not
		$emp = $this->Hrmodel->get_emp_code($old_emp_code);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}

		//check new emp code already exits or not
		$emp2 = $this->Hrmodel->get_emp_code($new_emp_code);
		if(!empty($emp2)){
			echo "$new_emp_code new empcode already exists.";
			exit;
		}
		
		
		//update table
		$where = ['emp_code' => $emp_code,'company_id' => $company_id];
		$data2 = [
					'emp_code' => $new_emp_code,
				  	'pay_code' => $new_emp_code,
				];
		$this->Mymodel->update('employee', $data2, $where);
		
		$data = ['emp_code' => $new_emp_code];
		$this->Mymodel->update('canteen_coupon_issue', $data, $where);
		$this->Mymodel->update('daily_attendance', $data, $where);
		$this->Mymodel->update('daily_attendance_monthly_emp_exp', $data, $where);
		$this->Mymodel->update('employee_loan', $data, $where);
		$this->Mymodel->update('employee_loan_emi_recovery', $data, $where);
		$this->Mymodel->update('emp_advance', $data, $where);
		$this->Mymodel->update('emp_leave', $data, $where);
		$this->Mymodel->update('emp_other_application', $data, $where);
		$this->Mymodel->update('emp_reimbursement_master', $data, $where);
		$this->Mymodel->update('emp_salary_transfer', $data, $where);
		$this->Mymodel->update('emp_tds', $data, $where);
		
		echo "Update";
	}//function close

	public function delete_emp_code()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		$result['company_role']=$this->Base->get_all_contractor_code();
		$this->load->view('hr/change/delete_emp',$result);
	}//function close

	
	public function delete_emp_code_info()
	{
		$company_id = $this->session->userdata('company_id');
		if (empty($_REQUEST['emp_code'])) {
			echo json_encode(['error' => 'Enter empcode']);
			exit;
		}

		$emp_code2 = $_REQUEST['emp_code'];

		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if (empty($emp)) {
			echo json_encode(['error' => 'Empcode not valid']);
			exit;
		}

		$emp_id   = $emp[0]['id'];
		$emp_code = $emp[0]['emp_code'];

		
		$tables = [
			'Employee master Table' => ['table' => 'employee', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'Attendance & salary table' => ['table' => 'daily_attendance_monthly', 'where' => ['emp_code' => $emp_id,'company_id'=>$company_id]],
			'Punching Table' => ['table' => 'daily_attendance', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'loan Table' => ['table' => 'employee_loan', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'loan_emi Table' => ['table' => 'employee_loan_emi_recovery', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'emp_advance Table' => ['table' => 'emp_advance', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'emp_leave Table' => ['table' => 'emp_leave', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'emp_other_application' => ['table' => 'emp_other_application', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'emp_reimbursement_master' => ['table' => 'emp_reimbursement_master', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'emp_salary_transfer' => ['table' => 'emp_salary_transfer', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'emp_tds' => ['table' => 'emp_tds', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			
			'canteen_coupon_issue' => ['table' => 'canteen_coupon_issue', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			'daily_attendance_monthly_emp_exp' => ['table' => 'daily_attendance_monthly_emp_exp', 'where' => ['emp_code' => $emp_code,'company_id'=>$company_id]],
			
		];

		$response = [];

		foreach ($tables as $label => $info) {
			$cnt = $this->db
						->where($info['where'])
						->from($info['table'])
						->count_all_results();

			$response[$label] = $cnt;
		}
		

		echo json_encode([
			'emp_code' => $emp_code,
			'counts'   => $response
		]);
		exit;
	}

	public function delete_emp_code_save()
	{
		$company_id = $this->session->userdata('company_id');
		if(isset($_REQUEST['emp_code'])){
			$emp_code2=$_REQUEST['emp_code'];
		}else{
			echo "Enter empcode";
			exit;
		}
		
		
		//check old emp code valid or not
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}

	
		
		//daily_attendance_monthly
		$where = ['emp_code' => $emp_id,'company_id' => $company_id];
		$this->Mymodel->deletedata('daily_attendance_monthly', $where);


		$where = ['emp_code' => $emp_code,'company_id' => $company_id];

		// main employee
		$this->Mymodel->deletedata('employee', $where);
		// related tables
		$this->Mymodel->deletedata('canteen_coupon_issue', $where);
		$this->Mymodel->deletedata('daily_attendance', $where);
		$this->Mymodel->deletedata('daily_attendance_monthly_emp_exp', $where);
		$this->Mymodel->deletedata('employee_loan', $where);
		$this->Mymodel->deletedata('employee_loan_emi_recovery', $where);
		$this->Mymodel->deletedata('emp_advance', $where);
		$this->Mymodel->deletedata('emp_leave', $where);
		$this->Mymodel->deletedata('emp_other_application', $where);
		$this->Mymodel->deletedata('emp_reimbursement_master', $where);
		$this->Mymodel->deletedata('emp_salary_transfer', $where);
		$this->Mymodel->deletedata('emp_tds', $where);

		
		echo "Update";
	}//function close


	public function delete_emp_att()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		$result['company_role']=$this->Base->get_all_contractor_code();
		$this->load->view('hr/change/delete_att',$result);
	}//function close

	public function delete_emp_code_att_save()
	{
		$company_id = $this->session->userdata('company_id');
		if(isset($_REQUEST['search_year'])){
			$search_year=$_REQUEST['search_year'];
		}else{ echo "Select Year";exit;}

		if(isset($_REQUEST['search_month'])){
			$search_month=$_REQUEST['search_month'];
		}else{ echo "Select Month";exit;}

		if(isset($_REQUEST['emp_code'])){
			$emp_code2=$_REQUEST['emp_code'];
		}else{
			echo "Enter empcode";
			exit;
		}

		$fromDate = date('Y-m-d 00:00:00', strtotime($search_year.'-'.$search_month.'-01'));
		$toDate   = date('Y-m-t 23:59:59', strtotime($search_year.'-'.$search_month.'-01'));


		//check old emp code valid or not
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}

	
		
		//daily_attendance_monthly
		$where = ['emp_code' => $emp_id,'att_year' => $search_year,'att_month' => $search_month,'company_id'=>$company_id];
		$this->Mymodel->deletedata('daily_attendance_monthly', $where);

		//punch
		$where = ['emp_code' => $emp_code,'company_id' => $company_id];
		$this->db->where($where);
		$this->db->where('shift_in_time >=', $fromDate);
		$this->db->where('shift_in_time <=', $toDate);
		$this->db->delete('daily_attendance');

		
		echo "Update";
	}//function close






	//emp_other_application_save 
	public function emp_gatepass_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		$entry_date = date('Y-m-d');//always today
		if(isset($_REQUEST['emp_code'])){$emp_code2=$_REQUEST['emp_code'];}else{$emp_code2='';}
		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}

		$type = 'Gatepass';
		// Gatepass-specific
		$work_type = $_REQUEST['work_type'] ?? '';
		$vehical_name = $_REQUEST['vehical_name'] ?? '';
		$km_start = $_REQUEST['km_start'] ?? '';
		$km_end = $_REQUEST['km_end'] ?? '';
		$time_out = $_REQUEST['time_out'] ?? '';
		$duty_off = $_REQUEST['duty_off'] ?? '';
		$time_in = $_REQUEST['time_in'] ?? '';
		$description = $_REQUEST['description'] ?? '';
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}

		
		// Prepare data for insert/update
		$data = [
			'company_id' => $company_id,
			'emp_code' => $emp_code,
			'type' => $type,
			'entry_date' => $entry_date,
			'description' => $description,
			'work_type' => $work_type,
			'vehical_name' => $vehical_name,
			'km_start' => $km_start,
			'km_end' => $km_end,
			'time_out' => $time_out,
			'duty_off' => $duty_off,
			'time_in' => $time_in,
			];


		// Insert or Update
		if (empty($id) && !empty($emp_code)) {
			$data['save_by'] = $user_email;
			$data['save_date'] = $today;

			$this->Mymodel->insertdata_withid('emp_other_application', $data);
			echo "Save";
		} else {
			echo "Not Save. Try Again. No Data Found.";
		}
	}//function close



	//get_other_application_form
	public function get_other_application_form()
	{
		if(isset($_REQUEST['search1']))
		{
			$res2 = array();
			$this->Hrmodel->other_appication_form($_REQUEST['type'],$res2);
		}
	}//function close

	//list search
	public function list_gatepass()
	{
		$result['dept']=$this->Base->get_all_dept();
		$search_date1= date('Y-m-01');
		$search_date2= date('Y-m-t');
		$year = (int)$this->Base->change_date_into_year($search_date1);
		$month = (int)$this->Base->change_date_into_month($search_date1);
		
		//get attendance of given month
		$result['att'] = $this->Hrmodel->get_all_emp_code_from_salary_list($year,$month);
		$result['page'] = 'onlyPendingGatepass';
		$result['type'] = 'Gatepass';
		$where = " and A.status='' and A.type='Gatepass'  ORDER by A.entry_date DESC ";
		$result['res2'] = $this->Hrmodel->get_all_other_appli_with_search($where);
		$this->load->view('hr/other/show',$result);
	}//function close


	//list search
	public function list_other_application()
	{
		$result['dept']=$this->Base->get_all_dept();
		$result['page'] = '';
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['search_type'])){$search_type=$_REQUEST['search_type'];$where.=" and  A.type='$search_type'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  E.department_id='$dept'   ";}
			if(!empty($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];$where.=" and  A.emp_code='$emp_code'   ";}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.entry_date ASC ";
			$result['res2'] = $this->Hrmodel->get_all_other_appli_with_search($where);
			$year = (int)$this->Base->change_date_into_year($search_date1);
			$month = (int)$this->Base->change_date_into_month($search_date1);
			//get attendance of given month
			$result['type'] = $search_type;
			$result['att'] = $this->Hrmodel->get_all_emp_code_from_salary_list($year,$month);
			$this->load->view('hr/other/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$year = (int)$this->Base->change_date_into_year($search_date1);
			$month = (int)$this->Base->change_date_into_month($search_date1);
			//get attendance of given month
			$result['att'] = $this->Hrmodel->get_all_emp_code_from_salary_list($year,$month);
			$result['type'] = 'Gatepass';
			$where = " and A.type='Gatepass' and A.entry_date between '$search_date1' and '$search_date2'  ORDER by A.entry_date ASC ";
			$result['res2'] = $this->Hrmodel->get_all_other_appli_with_search($where);
			$this->load->view('hr/other/show',$result);
		}//search
	}//function close
	


	//emp_other_application_save 
	public function emp_other_application_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		
		if(isset($_REQUEST['emp_code'])){$emp_code2=$_REQUEST['emp_code'];}else{$emp_code2='';}
		//check_emp_code
		$emp = $this->Hrmodel->get_emp_code($emp_code2);
		if(empty($emp)){
			echo "Empcode not valid";
			exit;
		}else{
			$emp_id = $emp[0]['id'];
			$emp_code = $emp[0]['emp_code'];
		}
		if(isset($_REQUEST['father_name'])){$father_name=$_REQUEST['father_name'];}else{$father_name='';}
		if(isset($_REQUEST['mob'])){$mob=$_REQUEST['mob'];}else{$mob='';}
		if(isset($_REQUEST['department_id'])){$department_id=$_REQUEST['department_id'];}else{$department_id='';}
		if(isset($_REQUEST['role_id'])){$role_id=$_REQUEST['role_id'];}else{$role_id='';}	
		if(isset($_REQUEST['present_address'])){$present_address=$_REQUEST['present_address'];}else{$present_address='';}
		if(isset($_REQUEST['permanent_address'])){$permanent_address=$_REQUEST['permanent_address'];}else{$permanent_address='';} 
		
		if(!empty($_REQUEST['entry_date'])){$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date="0000-00-00";}
		
		
		$type = $_REQUEST['type'] ?? '';
			
		$description = $_REQUEST['description'] ?? '';
		$subject = $_REQUEST['subject'] ?? '';
		$action = $_REQUEST['action'] ?? '';
		$amount = $_REQUEST['amount'] ?? '';
		$remarks = $_REQUEST['remarks'] ?? '';

		// Gatepass-specific
		$work_type = $_REQUEST['work_type'] ?? '';
		$vehical_name = $_REQUEST['vehical_name'] ?? '';
		$km_start = $_REQUEST['km_start'] ?? '';
		$km_end = $_REQUEST['km_end'] ?? '';
		$time_out = $_REQUEST['time_out'] ?? '';
		$duty_off = $_REQUEST['duty_off'] ?? '';
		$time_in = $_REQUEST['time_in'] ?? '';
		$sup_id = $_REQUEST['sup_id'] ?? '';

		// Accident-specific
		$entry_time = $_REQUEST['entry_time'] ?? '';
		$location = $_REQUEST['location'] ?? '';
		$accident_type = $_REQUEST['accident_type'] ?? '';
		$accident_nature = $_REQUEST['accident_nature'] ?? '';
		$accident_action = $_REQUEST['accident_action'] ?? '';
		$accident_root = $_REQUEST['accident_root'] ?? '';
		$accident_factors = $_REQUEST['accident_factors'] ?? '';

		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		if(isset($_REQUEST['status'])){$status=$_REQUEST['status'];}else{$status='';}

		
		// Prepare data for insert/update
		$data = [
			'company_id' => $company_id,
			'emp_code' => $emp_code,
			'type' => $type,
			'entry_date' => $entry_date,
			'description' => $description,
			'subject' => $subject,
			'action' => $action,
			'amount' => $amount,
			'remarks' => $remarks,
			'status' => $status,

			// Gatepass
			'work_type' => $work_type,
			'vehical_name' => $vehical_name,
			'km_start' => $km_start,
			'km_end' => $km_end,
			'time_out' => $time_out,
			'duty_off' => $duty_off,
			'time_in' => $time_in,
			'sup_id' => $sup_id,

			// Accident
			'entry_time' => $entry_time,
			'location' => $location,
			'accident_type' => $accident_type,
			'accident_nature' => $accident_nature,
			'accident_action' => $accident_action,
			'accident_root' => $accident_root,
			'accident_factors' => $accident_factors,
		];


		// Insert or Update
		if (empty($id) && !empty($emp_code)) {
			$data['save_by'] = $user_email;
			$data['save_date'] = $today;

			$this->Mymodel->insertdata_withid('emp_other_application', $data);
			echo "Save";
		} elseif (!empty($id) && !empty($emp_code)) {
			$data['update_by'] = $user_email;
			$data['update_date'] = $today;

			$this->Mymodel->update('emp_other_application', $data, ['id' => $id]);
			echo "Update";
		} else {
			echo "Not Save. Try Again. No Data Found.";
		}
	}//function close


	

	public function profile()
	{
		$company_id = $this->session->userdata('company_id');
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$where=" emp_code='$id' and company_id='$company_id' ";
			$result['res2']=$this->Mymodel->select_where('employee',$where);
			$this->load->view('hr/emp/docs/profile',$result);
		}//strlen
	}//function close

	public function profile2()
	{
		$company_id = $this->session->userdata('company_id');
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$where=" emp_code='$id' and company_id='$company_id'";
			$result['res2']=$this->Mymodel->select_where('employee',$where);
			$this->load->view('hr/emp/docs/profile2',$result);
		}//strlen
	}//function close

	public function appointment_latter()
	{
		$company_id = $this->session->userdata('company_id');
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$where=" emp_code='$id' and company_id='$company_id' ";
			$result['res2']=$this->Mymodel->select_where('employee',$where);
			$this->load->view('hr/emp/docs/appointment_latter',$result);
		}//strlen
	}//function close






	//-------------------------------------------------------------Canteen Coupon issue
	public function add_coupon()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['role']=$this->Base->get_all_dept_role();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_coupon_issue_data_with_id($id);
		}//strlen
		$this->load->view('hr/canteen/coupon_issue_entry',$result);
	}//function close

	
	//list search
	public function list_coupon_issue()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['type'])){$type=$_REQUEST['type'];$where.=" and  A.type='$type'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  E.department_id='$dept'   ";}
			if(!empty($_REQUEST['emp_code'])){$emp_code=$_REQUEST['emp_code'];$where.=" and  A.emp_code='$emp_code'   ";}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.issue_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.issue_date,E.first_name ";
			$result['res2'] = $this->Hrmodel->get_all_coupon_issue_with_search($where);

			$this->load->view('hr/canteen/show_table',$result);
		}
		else
		{
			$today= date('Y-m-d');
			//$search_date2= date('Y-m-t');
			$where = " and A.issue_date = '$today'  ORDER by A.issue_date,E.first_name ";
			$result['res2'] = $this->Hrmodel->get_all_coupon_issue_with_search($where);
			$this->load->view('hr/canteen/show',$result);
		}//search
	}//function close


	//list search
	public function list_coupon_issue_group_by_name()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$result['fdate'] = $search_date1;
				$result['tdate'] = $search_date2;
				$result['res2'] = $this->Hrmodel->get_all_coupon_issue_with_empcode_group_by($search_date1,$search_date2);//employee
				$result['res22'] = $this->Hrmodel->get_all_coupon_issue_with_other_name_group_by($search_date1,$search_date2);//other_name

				$year = (int)$this->Base->change_date_into_year($search_date1);
				$month = (int)$this->Base->change_date_into_month($search_date1);
				//get attendance of given month
				$result['att'] = $this->Hrmodel->get_all_emp_code_from_salary_list($year,$month);
				
				$this->load->view('hr/canteen/show_table_group',$result);
			}
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$result['fdate'] = $search_date1;
			$result['tdate'] = $search_date2;
			$year = (int)$this->Base->change_date_into_year($search_date1);
			$month = (int)$this->Base->change_date_into_month($search_date1);
			//get attendance of given month
			$result['att'] = $this->Hrmodel->get_all_emp_code_from_salary_list($year,$month);
			
			$result['res2'] = $this->Hrmodel->get_all_coupon_issue_with_empcode_group_by($search_date1,$search_date2);//employee
			$result['res22'] = $this->Hrmodel->get_all_coupon_issue_with_other_name_group_by($search_date1,$search_date2);//other_name
			
			
			$this->load->view('hr/canteen/show_group',$result);
		}//search
	}//function close



	//list search
	public function list_coupon_issue_group_by_date()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				
				$result['res2'] = $this->Hrmodel->get_all_coupon_issue_with_date_group_by($search_date1,$search_date2);//date
				$this->load->view('hr/canteen/show_table_group_date',$result);
			}
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$result['res2'] = $this->Hrmodel->get_all_coupon_issue_with_date_group_by($search_date1,$search_date2);//date
			$this->load->view('hr/canteen/show_group_date',$result);
		}//search
	}//function close


	// top high coupon issue
	public function get_top_lunch_coupon_issue()
	{
		$search_date1= date('Y-m-01');
		$search_date2= date('Y-m-t');
		$res2 = $this->Hrmodel->get_top_most_lunch_coupon_issue($search_date1,$search_date2,"HIGH",2000);
		$this->Hrmodel->print_data_table($res2);
	}//function close
	// top low coupon issue
	public function get_low_lunch_coupon_issue()
	{
		$search_date1= date('Y-m-01');
		$search_date2= date('Y-m-t');
		$res2 = $this->Hrmodel->get_top_most_lunch_coupon_issue($search_date1,$search_date2,"LOW",2000);
		$this->Hrmodel->print_data_table($res2);
	}//function close


	// top high coupon issue
	public function get_top_bf_coupon_issue()
	{
		$search_date1= date('Y-m-01');
		$search_date2= date('Y-m-t');
		$res2 = $this->Hrmodel->get_top_most_breakfast_coupon_issue($search_date1,$search_date2,"HIGH",2000);
		$this->Hrmodel->print_data_table($res2);
	}//function close
	// top low coupon issue
	public function get_low_bf_coupon_issue()
	{
		$search_date1= date('Y-m-01');
		$search_date2= date('Y-m-t');
		$res2 = $this->Hrmodel->get_top_most_breakfast_coupon_issue($search_date1,$search_date2,"LOW",2000);
		$this->Hrmodel->print_data_table($res2);
	}//function close



	// 3 month coupon issue data
	public function get_last_3month_lunch_coupon_issue()
	{
		$this->Hrmodel->get_last_3month_lunch_coupon_issue();
	}//function close

	
	public function canteen_full_charge_update()
	{
		$company_id = $this->session->userdata('company_id');
		if(!empty($_REQUEST['emp_code']) and !empty($_REQUEST['fdate']) and !empty($_REQUEST['tdate']))
		{
			$fdate = $this->Base->change_date_ymd($_REQUEST['fdate']);
			$tdate = $this->Base->change_date_ymd($_REQUEST['tdate']);
			$emp_code2 = $_REQUEST['emp_code'];
			
			if(!empty($_REQUEST['fullCharge'])){$fullCharge=$_REQUEST['fullCharge'];}else{$fullCharge='No';}
			
			$brk = 0;
			$food = 0;
			if($fullCharge == "Yes"){
				$brk = 15;
				$food = 50;
			}
			elseif($fullCharge == "No"){
				$brk = 7.5;
				$food = 25;
			}else{
				echo "Charge value is wrong. Either Yes or No";
				exit;
			}
		
			//select
			$query=" SELECT * FROM canteen_coupon_issue WHERE company_id='$company_id' and emp_code='$emp_code' and issue_date between '$fdate' and '$tdate'  ";
			$res9=$this->Mymodel->query1($query);
			if(!empty($res9))
			{
				foreach($res9 as $r)
				{
					$id = $r['id'];
					$lunch_coupon_no = (float)$r['lunch_coupon_no'];
					$dinner_coupon_no = (float)$r['dinner_coupon_no'];
					$breakfast_coupon_no = (float)$r['breakfast_coupon_no'];
					
					//set new amount
					$total_coupon = $dinner_coupon_no+$lunch_coupon_no + $breakfast_coupon_no;
					$dinner_coupon_amt = round($dinner_coupon_no*$food);
					$lunch_coupon_amt = round($lunch_coupon_no*$food);
					$breakfast_coupon_amt = round($breakfast_coupon_no*$brk,1);
					$total_amt = round($dinner_coupon_amt+$lunch_coupon_amt+$breakfast_coupon_amt,1);
					$data=array(
									'fullCharge'=>"$fullCharge",
									'emp_code'=>"$emp_code",

									'dinner_coupon_no'=>"$dinner_coupon_no",
									'lunch_coupon_no'=>"$lunch_coupon_no",
									'breakfast_coupon_no'=>"$breakfast_coupon_no",
									'total_coupon'=>"$total_coupon",
									'dinner_coupon_amt'=>"$dinner_coupon_amt",
									'lunch_coupon_amt'=>"$lunch_coupon_amt",
									'breakfast_coupon_amt'=>"$breakfast_coupon_amt",
									'total_amt'=>"$total_amt",

									'remarks'=>"Full Charge",
								);
					$where=array('id'=>"$id",'company_id'=>$company_id);   
					$this->Mymodel->update('canteen_coupon_issue',$data,$where);
					//print_r($data);
					//echo "<br>";
				}//foreach
				echo "Update";
			}
		}else{
			echo "Not update. empcode, date not valid";
			exit;
		}
	}//function close


	public function emp_coupon_issue_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		
		if(!empty($_REQUEST['issue_date'])){$issue_date = $this->Base->change_date_ymd($_REQUEST['issue_date']);}else{$issue_date="0000-00-00";}
		if(isset($_REQUEST['type'])){$type=$_REQUEST['type'];}else{$type='';}
		if(isset($_REQUEST['fullCharge'])){$fullCharge=$_REQUEST['fullCharge'];}else{$fullCharge='';}
		if(isset($_REQUEST['emp_code'])){$emp_code2=$_REQUEST['emp_code'];}else{$emp_code2='';} 
		
		
		if(isset($_REQUEST['breakfast_coupon_no'])){$breakfast_coupon_no=(float)$_REQUEST['breakfast_coupon_no'];}else{$breakfast_coupon_no=0;}
		if(isset($_REQUEST['lunch_coupon_no'])){$lunch_coupon_no=(float)$_REQUEST['lunch_coupon_no'];}else{$lunch_coupon_no=0;}
		if(isset($_REQUEST['dinner_coupon_no'])){$dinner_coupon_no=(float)$_REQUEST['dinner_coupon_no'];}else{$dinner_coupon_no=0;}
		
		if(isset($_REQUEST['other_name'])){$other_name=$_REQUEST['other_name'];}else{$other_name='';}
		if(isset($_REQUEST['other_dept'])){$other_dept=$_REQUEST['other_dept'];}else{$other_dept='';}	
		if(isset($_REQUEST['other_ref'])){$other_ref=$_REQUEST['other_ref'];}else{$other_ref='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';} 
	
		if($type == 'No' && !empty($emp_code)){
			$type = "Yes";
		}

		$brk = 0;
		$food = 0;
		if($fullCharge == "Yes"){
			$brk = 15;
			$food = 50;
		}else{
			$brk = 7.5;
			$food = 25;
		}
		
		$total_coupon = $dinner_coupon_no+$lunch_coupon_no + $breakfast_coupon_no;
		$dinner_coupon_amt = round($dinner_coupon_no*$food);
		$lunch_coupon_amt = round($lunch_coupon_no*$food);
		$breakfast_coupon_amt = round($breakfast_coupon_no*$brk,1);
		$total_amt = round($dinner_coupon_amt+$lunch_coupon_amt+$breakfast_coupon_amt,1);
		// if($total_amt < 1){
		// 	echo "Amount not valid";
		// 	exit;
		// }

		

		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']))
		{
			$data=array(
							'issue_date'=>"$issue_date",			
							'fullCharge'=>"$fullCharge",
							'type'=>"$type",
							'emp_code'=>"$emp_code",
							'company_id'=>"$company_id",

							'other_name'=>"$other_name",
							'other_dept'=>"$other_dept",
							'other_ref'=>"$other_ref",
							
							'dinner_coupon_no'=>"$dinner_coupon_no",
							'lunch_coupon_no'=>"$lunch_coupon_no",
							'breakfast_coupon_no'=>"$breakfast_coupon_no",
							'total_coupon'=>"$total_coupon",
							'dinner_coupon_amt'=>"$dinner_coupon_amt",
							'lunch_coupon_amt'=>"$lunch_coupon_amt",
							'breakfast_coupon_amt'=>"$breakfast_coupon_amt",
							'total_amt'=>"$total_amt",

							'remarks'=>"$remarks",
							
							'save_by'=>"$user_email",
							'save_date'=>"$today",
							);
			$cat_id=$this->Mymodel->insertdata_withid('canteen_coupon_issue',$data);
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']))
		{
			$data=array(
								'issue_date'=>"$issue_date",			
								'type'=>"$type",
								'fullCharge'=>"$fullCharge",
								'emp_code'=>"$emp_code",
								'company_id'=>"$company_id",
								'other_name'=>"$other_name",
								'other_dept'=>"$other_dept",
								'other_ref'=>"$other_ref",
								
								'dinner_coupon_no'=>"$dinner_coupon_no",
								'lunch_coupon_no'=>"$lunch_coupon_no",
								'breakfast_coupon_no'=>"$breakfast_coupon_no",
								'total_coupon'=>"$total_coupon",
								'dinner_coupon_amt'=>"$dinner_coupon_amt",
								'lunch_coupon_amt'=>"$lunch_coupon_amt",
								'breakfast_coupon_amt'=>"$breakfast_coupon_amt",
								'total_amt'=>"$total_amt",

								'remarks'=>"$remarks",
							 
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
			$where=array('id'=>"$id");   
			$this->Mymodel->update('canteen_coupon_issue',$data,$where);
			echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close


	/*
	//upload from excel
	public function emp_coupon_save_from_temp_table()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');

		$query=" SELECT * FROM temp_table ";
		$res9=$this->Mymodel->query1($query);
		if(!empty($res9))
		{
			foreach($res9 as $r){
				$name =  $r['c1'];
				$emp_code =  $r['c2'];
				$issue_date = $this->Base->change_date_ymd($r['c6']);
				$dept =  $r['c9'];

				$lunch =  (float)$r['c7'];
				$bf =  (float)$r['c8'];
				$total_no = $lunch+$bf;
				$lunch_amt = round($lunch*25);
				$bf_amt = round($bf*7.5,1);
				$total_amt = round($bf_amt+$lunch_amt,1);
				
				if($emp_code > 0){
					$data=array(
							'issue_date'=>"$issue_date",			
							'type'=>"Yes",
							'emp_code'=>"$emp_code",

							'lunch_coupon_no'=>"$lunch",
							'breakfast_coupon_no'=>"$bf",
							'total_coupon'=>"$total_no",
							'lunch_coupon_amt'=>"$lunch_amt",
							'breakfast_coupon_amt'=>"$bf_amt",
							'total_amt'=>"$total_amt",

							'remarks'=>"upload via excel",
							
							'save_by'=>"$user_email",
							'save_date'=>"$today",
							);
					$cat_id=$this->Mymodel->insertdata_withid('canteen_coupon_issue',$data);
					//print_r($data);
				}else{
					$data=array(
							'issue_date'=>"$issue_date",			
							'type'=>"No",
							'emp_code'=>"",

							'other_name'=>"$name",
							'other_dept'=>"$dept",
							'other_ref'=>"",
							
							'lunch_coupon_no'=>"$lunch",
							'breakfast_coupon_no'=>"$bf",
							'total_coupon'=>"$total_no",
							'lunch_coupon_amt'=>"$lunch_amt",
							'breakfast_coupon_amt'=>"$bf_amt",
							'total_amt'=>"$total_amt",

							'remarks'=>"upload via excel",
							
							'save_by'=>"$user_email",
							'save_date'=>"$today",
							);
					$cat_id=$this->Mymodel->insertdata_withid('canteen_coupon_issue',$data);
					//print_r($data);
				}
				
				//echo "<br>";
			}
			echo "done";
		}
	}//function close
	


	//upload from excel
	public function emp_doj_from_temp_table()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');

		$query=" SELECT * FROM temp_table ";
		$res9=$this->Mymodel->query1($query);
		if(!empty($res9))
		{
			foreach($res9 as $r){
				$emp_code =  $r['c1'];
				
				$c3 =  $r['c3'];
				
				if(!empty($r['c3'])){

					$str = "RKS Join History : D.O.J : $c3,";
					
					$rdoj2 = $this->Base->change_date_ymd($r['c3']);

					$data=array(
							'doj'=>"$rdoj2",			
							'last_org'=>"$str",
							);
					$where=array('emp_code'=>"$emp_code");   
					$this->Mymodel->update('employee',$data,$where);
					print_r($data);
				}


				
				echo "<br>";
			}
			echo "done";
		}
	}//function close
	*/



	public function receive_coupon()
	{
		$result['dept']=$this->Base->get_hr_dept();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_coupon_receive_data_with_id($id);
		}//strlen
		$this->load->view('hr/canteen/receive/coupon_receive_entry',$result);
	}//function close

	//list search
	public function list_coupon_receive()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.receive_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.receive_date ";
			$result['res2'] = $this->Hrmodel->get_all_coupon_receive_with_search($where);

			$this->load->view('hr/canteen/receive/show_table',$result);
		}
		else
		{
			$today= date('Y-m-d');
			//$search_date2= date('Y-m-t');
			$where = " and A.receive_date = '$today'   ";
			$result['res2'] = $this->Hrmodel->get_all_coupon_receive_with_search($where);
			$this->load->view('hr/canteen/receive/show',$result);
		}//search
	}//function close


	//list search
	public function list_coupon_receive_group_by_date()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				
				$result['res2'] = $this->Hrmodel->get_all_coupon_receive_with_date_group_by($search_date1,$search_date2);//date
				$this->load->view('hr/canteen/receive/show_table_group_date',$result);
			}
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$result['res2'] = $this->Hrmodel->get_all_coupon_receive_with_date_group_by($search_date1,$search_date2);//date
			$this->load->view('hr/canteen/receive/show_group_date',$result);
		}//search
	}//function close


	public function emp_coupon_receive_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		
		if(!empty($_REQUEST['receive_date'])){$receive_date = $this->Base->change_date_ymd($_REQUEST['receive_date']);}else{$issue_date="0000-00-00";}
		if(isset($_REQUEST['dinner_coupon_no'])){$dinner_coupon_no=(float)$_REQUEST['dinner_coupon_no'];}else{$dinner_coupon_no=0;}
		if(isset($_REQUEST['lunch_coupon_no'])){$lunch_coupon_no=(float)$_REQUEST['lunch_coupon_no'];}else{$lunch_coupon_no=0;}
		if(isset($_REQUEST['breakfast_coupon_no'])){$breakfast_coupon_no=(float)$_REQUEST['breakfast_coupon_no'];}else{$breakfast_coupon_no=0;}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		
		$total_coupon = $dinner_coupon_no+$lunch_coupon_no + $breakfast_coupon_no;
		$dinner_coupon_amt = round($dinner_coupon_no*25);
		$lunch_coupon_amt = round($lunch_coupon_no*25);
		$breakfast_coupon_amt = round($breakfast_coupon_no*7.5,1);
		$total_amt = round($dinner_coupon_amt+$lunch_coupon_amt+$breakfast_coupon_amt,1);
		if($total_amt < 1){
			echo "Amount not valid";
			exit;
		}

		

		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']))
		{
			$data=array(
							'receive_date'=>"$receive_date",
							'company_id'=>"$company_id",			
							
							'dinner_coupon_no'=>"$dinner_coupon_no",
							'lunch_coupon_no'=>"$lunch_coupon_no",
							'breakfast_coupon_no'=>"$breakfast_coupon_no",
							'total_coupon'=>"$total_coupon",
							'lunch_coupon_amt'=>"$lunch_coupon_amt",
							'breakfast_coupon_amt'=>"$breakfast_coupon_amt",
							'dinner_coupon_amt'=>"$dinner_coupon_amt",
							'total_amt'=>"$total_amt",

							'remarks'=>"$remarks",
							
							'save_by'=>"$user_email",
							'save_date'=>"$today",
							);
			$cat_id=$this->Mymodel->insertdata_withid('canteen_coupon_receive',$data);
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']))
		{
			$data=array(
								'receive_date'=>"$receive_date",			
								'company_id'=>"$company_id",	
								'dinner_coupon_no'=>"$dinner_coupon_no",
								'lunch_coupon_no'=>"$lunch_coupon_no",
								'breakfast_coupon_no'=>"$breakfast_coupon_no",
								'total_coupon'=>"$total_coupon",
								'lunch_coupon_amt'=>"$lunch_coupon_amt",
								'breakfast_coupon_amt'=>"$breakfast_coupon_amt",
								'dinner_coupon_amt'=>"$dinner_coupon_amt",
								'total_amt'=>"$total_amt",

								'remarks'=>"$remarks",
							 
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
			$where=array('id'=>"$id");   
			$this->Mymodel->update('canteen_coupon_receive',$data,$where);
			echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close





	
	public function upload_coupon()
	{
		$result['dept']=$this->Base->get_hr_dept();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Hrmodel->get_coupon_receive_data_with_id($id);
		}//strlen
		$this->load->view('hr/canteen/upload/upload',$result);
	}//function close





	public function upload_coupon_save()
	{
		$today = date("Y-m-d H:i:s");
		$user_email = $this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		$logData = isset($_REQUEST['logData']) ? $_REQUEST['logData'] : '';
		$saveValue = isset($_REQUEST['saveValue']) ? $_REQUEST['saveValue'] : 'No';

		$logArray = json_decode($logData, true);
		$report = [];

		foreach ($logArray as $entry) {
			
			$emp_code = $entry['emp_code'];
			$date = $entry['entry_date'];
			$time = $entry['entry_time'];
			$hour = (int)date('H', strtotime($time));
			$minute = (int)date('i', strtotime($time));
			$key = $date . '_' . $emp_code;

			// If employee data not already fetched, fetch from DB
			if (!isset($report[$key])) {
				$query = "SELECT E.first_name, E.last_name, D.name as dname 
						FROM employee as E
						LEFT JOIN department as D ON D.department_id = E.department_id
						WHERE emp_code = '$emp_code' and company_id='$company_id' ";
				$emp = $this->Mymodel->query1($query);

				if (!empty($emp)) {
					$emp_name = $emp[0]['first_name'] . ' ' . $emp[0]['last_name'];
					$department = $emp[0]['dname'];
					$type = "Yes";
					$other_name = "";
					$valid = true;
				} else {
					$emp_name = 'Invalid Employee';
					$department = '-';
					$type = "No";
					$other_name = $emp_code . " Invalid Code";
					$valid = false;
				}

				$report[$key] = [
					'date' => $date,
					'company_id' => $company_id,
					'emp_code' => $emp_code,
					'name' => $emp_name,
					'department' => $department,
					'type' => $type,
					'other_name' => $other_name,
					'valid' => $valid,
					'breakfast' => 0,
					'lunch' => 0,
					'dinner' => 0
				];
			}

			// Meal category based on time
			if ($hour >= 7 && $hour < 9 || ($hour == 9 && $minute == 0)) {
				$report[$key]['breakfast']++;
			} elseif ($hour >= 12 && $hour < 15 || ($hour == 15 && $minute == 0)) {
				$report[$key]['lunch']++;
			} elseif ($hour >= 19 && $hour < 22 || ($hour == 22 && $minute == 0)) {
				$report[$key]['dinner']++;
			}
		}
		
		

		// Output HTML table
		echo "<table class='table table-bordered table-striped table-sm'>";
		echo "<tr style='background:#f0f0f0'>
				<th>Sno</th>
				<th>Date</th>
				<th>Emp Code</th>
				<th>Employee Name</th>
				<th>Department</th>
				<th>Breakfast</th>
				<th>Lunch</th>
				<th>Dinner</th>
				<th>Type</th>
				<th>Other Name</th>
			</tr>";

		$j=1;
		foreach ($report as $row) {
			// Skip rows where all meal counts are 0
			if ($row['breakfast'] == 0 && $row['lunch'] == 0 && $row['dinner'] == 0) {
				continue;
			}
			
			$rowStyle = ($row['type'] === 'No') ? "style='background-color: #ffcccc'" : '';
			echo "<tr $rowStyle>
					<td>{$j}</td>
					<td>{$row['date']}</td>
					<td>{$row['emp_code']}</td>
					<td>{$row['name']}</td>
					<td>{$row['department']}</td>
					<td>{$row['breakfast']}</td>
					<td>{$row['lunch']}</td>
					<td>{$row['dinner']}</td>
					<td>{$row['type']}</td>
					<td>{$row['other_name']}</td>
				</tr>";
			$j++;
		}

		echo "</table> <p>If more than two coupons are issued on the same day, only one will be considered.</p>";

		if($saveValue == "Yes"){
			$this->upload_coupon_save1($report);
		}
	}


	public function upload_coupon_save1($report)
	{
		$today = date("Y-m-d H:i:s");
		$user_email = $this->session->userdata('login_emp_id');
		$company_id = $this->session->userdata('company_id');
		
		// ✅ Save to DB (insert or update)
		foreach ($report as $row) {
			// Skip rows where all meal counts are 0
			if ($row['breakfast'] == 0 && $row['lunch'] == 0 && $row['dinner'] == 0) {
				continue;
			}
			
			$emp_code = $row['emp_code'];
			$issue_date = $row['date'];
			$isValid = $row['valid'];
			$type = $row['type'];
			$other_name = $row['other_name'];

			$breakfast = ($row['breakfast'] > 0) ? 1 : 0;
			$lunch     = ($row['lunch'] > 0) ? 1 : 0;
			$dinner    = ($row['dinner'] > 0) ? 1 : 0;

			$total_coupon   = $breakfast + $lunch + $dinner;
			$breakfast_amt  = $breakfast * 7.5;
			$lunch_amt      = $lunch * 25;
			$dinner_amt     = $dinner * 25;
			$total_amt      = $breakfast_amt + $lunch_amt + $dinner_amt;

			// Check existing record
			$checkQuery = "SELECT * FROM canteen_coupon_issue WHERE company_id='$company_id' and emp_code = '$emp_code' AND issue_date = '$issue_date' and remarks = 'machine' LIMIT 1 ";
			$existing = $this->Mymodel->query1($checkQuery);

			if (!empty($existing)) {
				$prev = $existing[0];
				$entry_id = $prev['id'];

				$new_breakfast = ($prev['breakfast_coupon_no'] == 0 && $breakfast == 1) ? 1 : $prev['breakfast_coupon_no'];
				$new_lunch     = ($prev['lunch_coupon_no'] == 0 && $lunch == 1) ? 1 : $prev['lunch_coupon_no'];
				$new_dinner    = ($prev['dinner_coupon_no'] == 0 && $dinner == 1) ? 1 : $prev['dinner_coupon_no'];

				$new_total_coupon  = $new_breakfast + $new_lunch + $new_dinner;
				$new_breakfast_amt = $new_breakfast * 7.5;
				$new_lunch_amt     = $new_lunch * 25;
				$new_dinner_amt    = $new_dinner * 25;
				$new_total_amt     = $new_breakfast_amt + $new_lunch_amt + $new_dinner_amt;

				$updateData = [
					'company_id'  => $company_id,
					'breakfast_coupon_no'  => $new_breakfast,
					'lunch_coupon_no'      => $new_lunch,
					'dinner_coupon_no'     => $new_dinner,
					'total_coupon'         => $new_total_coupon,
					'breakfast_coupon_amt' => $new_breakfast_amt,
					'lunch_coupon_amt'     => $new_lunch_amt,
					'dinner_coupon_amt'    => $new_dinner_amt,
					'total_amt'            => $new_total_amt,
					'remarks'              => 'machine',
					'type'                 => $type,
					'other_name'           => $other_name
				];

				//$this->db->where('emp_code', $emp_code);
				//$this->db->where('issue_date', $issue_date);
				$this->db->where('id', $entry_id);
				$this->db->update('canteen_coupon_issue', $updateData);
			} else {
				$insertData = [
					'company_id'  => $company_id,
					'issue_date'           => $issue_date,
					'emp_code'             => $emp_code,
					'breakfast_coupon_no'  => $breakfast,
					'lunch_coupon_no'      => $lunch,
					'dinner_coupon_no'     => $dinner,
					'total_coupon'         => $total_coupon,
					'breakfast_coupon_amt' => $breakfast_amt,
					'lunch_coupon_amt'     => $lunch_amt,
					'dinner_coupon_amt'    => $dinner_amt,
					'total_amt'            => $total_amt,
					'remarks'              => 'machine',
					'type'                 => $type,
					'other_name'           => $other_name
				];

				$this->db->insert('canteen_coupon_issue', $insertData);
			}
		}//foreach

		
	}//function close




	
	
	public function upload_attendance()
	{
		$result['company_role']=$this->Base->get_all_contractor_code();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			//$result['res2']=$this->Hrmodel->get_coupon_receive_data_with_id($id);
			$result['res2']=[];
		}//strlen
		$this->load->view('hr/attendance/upload/upload',$result);
	}//function close

	
	//----------------------------------------------------update fix
	public function set_day_in_attendance()
	{
		$result['company_role']=$this->Base->get_all_contractor_code();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			//$result['res2']=$this->Hrmodel->get_coupon_receive_data_with_id($id);
			$result['res2']=[];
		}//strlen
		$this->load->view('hr/attendance/upload/dayfix',$result);
	}//function close

	//attendance entry single
	public function get_employee_attendance_date_wise2()
	{
		$company_id = $this->session->userdata('company_id');
		$result = [];
		if(isset($_REQUEST['location']) and !empty($_REQUEST['entry_date']))
		{
			$company_role_id=$_REQUEST['location'];
			$day_before=$_REQUEST['day_before'];
			$day_after=$_REQUEST['day_after'];
			$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);
			
			$from_date = date('Y-m-d', strtotime($entry_date . " -$day_before day"));
			$to_date = date('Y-m-d', strtotime($entry_date . " +$day_after day"));
			$start = strtotime($from_date);
			$end   = strtotime($to_date);

			
			for ($ts = $start; $ts <= $end; $ts = strtotime('+1 day', $ts)) {
				$d =  date('j', $ts);
				$m =  date('m', $ts);
				$y =  date('Y', $ts);

				$query = " SELECT 
							A.att_monthly_id,E.emp_code,A.att_year,A.att_month, A.d$d as emp_at_day, A.o$d as emp_ot_day,
							E.first_name, E.last_name, D.name as dname
						FROM daily_attendance_monthly as A
						LEFT JOIN employee as E ON A.emp_code = E.id
				 		LEFT JOIN department as D ON D.department_id = E.department_id
						WHERE A.company_id = '$company_id' and A.company_role_id = '$company_role_id'  AND A.att_year = '$y' AND A.att_month = '$m' ";
				$result[date('Y-m-d', $ts)] = $this->Mymodel->query1($query);
				
			}
			//print_r($result);

		}

		$this->_json([
			'status' => true,
			'data' => $result
		]);
	 }//function close


	
	public function upload_emp_master()
	{
		$result['company_role']=$this->Base->get_all_contractor_code();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			//$result['res2']=$this->Hrmodel->get_coupon_receive_data_with_id($id);
			$result['res2']=[];
		}//strlen
		$this->load->view('hr/emp/upload/upload',$result);
	}//function close

	private function _json($data)
	{
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}


	public function upload_emp_master_save()
	{
		$company_id = $this->session->userdata('company_id');
		$this->load->database();

		$payload = json_decode(file_get_contents("php://input"), true);

		if (!is_array($payload) || empty($payload['data'])) {
			return $this->_json([
				'status' => false,
				'message' => 'Invalid or empty payload'
			]);
		}

		$mode = $payload['mode'] ?? 'new'; // new | update | both
		$rows = $payload['data'];
		$table = 'employee';

		$dbCols = array_column(
			$this->db->query("SHOW COLUMNS FROM {$table}")->result_array(),
			'Field'
		);

		/* ===== Fetch existing emp_code once ===== */
		$empCodes = [];
		foreach ($rows as $r) {
			if (!empty($r['emp_code'])) {
				$empCodes[] = $r['emp_code'];
			}
		}
		
		$existingCodes = [];
		if ($empCodes) {
			$existingCodes = array_column(
				$this->db->select('emp_code')
						->where_in('emp_code', $empCodes)
						->where(['company_id'=>$company_id])
						->get($table)
						->result_array(),
				'emp_code'
			);
		}

		/* ===== PROCESS ===== */
		$this->db->trans_begin();

		$resultRows = [];
		$summary = ['inserted'=>0,'updated'=>0,'rejected'=>0];

		foreach ($rows as $index => $row) {

			$clean = [];
			$empCodeValue = null;

			foreach ($row as $col => $val) {

				if (!in_array($col, $dbCols)) continue;

				$val = trim((string)$val);

				/* emp_code */
				if ($col === 'emp_code') {
					if ($val === '') {
						$resultRows[] = [
							'row_index'=>$index,
							'status'=>'Rejected',
							'message'=>'Invalid emp_code'
						];
						$summary['rejected']++;
						continue 2;
					}
					$empCodeValue = $val;
					$clean['emp_code'] = $val;
					continue;
				}

				/* date normalize */
				if (preg_match('/_date$|^doj$|^dob$/i', $col)) {
					if ($val === '') {
						$clean[$col] = '';
						continue;
					}

					$ts = strtotime(str_replace('/', '-', $val));
					if ($ts === false) {
						$resultRows[] = [
							'row_index'=>$index,
							'status'=>'Rejected',
							'message'=>"Invalid date in {$col}"
						];
						$summary['rejected']++;
						continue 2;
					}
					$clean[$col] = date('Y-m-d', $ts);
					continue;
				}

				/* enums & defaults */
				switch ($col) {

					case 'restday':
						$allowed = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
						$clean[$col] = $val === '' ? 'Sun' : $val;
						if (!in_array($clean[$col], $allowed)) {
							$resultRows[]=['row_index'=>$index,'status'=>'Rejected','message'=>'Invalid restday'];
							$summary['rejected']++;
							continue 3;
						}
						break;

					case 'working_hr':
						$clean[$col] = $val === '' ? '8' : $val;
						if (!ctype_digit($clean[$col])) {
							$resultRows[]=['row_index'=>$index,'status'=>'Rejected','message'=>'Invalid working_hr'];
							$summary['rejected']++;
							continue 3;
						}
						break;

					case 'shift_status':
						$allowed = ['In Shift','General'];
						$clean[$col] = $val === '' ? 'In Shift' : $val;
						if (!in_array($clean[$col], $allowed)) {
							$resultRows[]=['row_index'=>$index,'status'=>'Rejected','message'=>'Invalid shift_status'];
							$summary['rejected']++;
							continue 3;
						}
						break;

					case 'current_shift':
						$allowed = ['General','A','B','C','D','E','F','G'];
						$clean[$col] = $val === '' ? 'A' : $val;
						if (!in_array($clean[$col], $allowed)) {
							$resultRows[]=['row_index'=>$index,'status'=>'Rejected','message'=>'Invalid current_shift'];
							$summary['rejected']++;
							continue 3;
						}
						break;

					case 'get_overtime':
					case 'esic_ded':
					case 'pf_ded':
						$allowed = ['Yes','No'];
						$clean[$col] = $val === '' ? 'No' : $val;
						if (!in_array($clean[$col], $allowed)) {
							$resultRows[]=['row_index'=>$index,'status'=>'Rejected','message'=>"Invalid {$col}"];
							$summary['rejected']++;
							continue 3;
						}
						break;

					default:
						$clean[$col] = $val;
				}
			}

			/* defaults */
			$clean['pay_code'] = $clean['pay_code'] ?? $empCodeValue;
			$clean['status']   = 'Deactive';
			$clean['company_id']   = $company_id;
			$clean['active']   = $clean['active'] ?? 'Active';
			$clean['plant']    = $clean['plant'] ?? 'UNIT 1';

			$exists = in_array($empCodeValue, $existingCodes);

			/* ===== MODE ENFORCEMENT ===== */

			if ($mode === 'new' && $exists) {
				$resultRows[]=['row_index'=>$index,'status'=>'Rejected','message'=>'emp_code already exists'];
				$summary['rejected']++;
				continue;
			}

			if ($mode === 'update' && !$exists) {
				$resultRows[]=['row_index'=>$index,'status'=>'Rejected','message'=>'emp_code not found for update'];
				$summary['rejected']++;
				continue;
			}

			/* ===== INSERT / UPDATE ===== */

			if ($exists) {
				$this->db->where('emp_code',$empCodeValue)->where('company_id',$company_id)->update($table,$clean);
				$resultRows[]=['row_index'=>$index,'status'=>'Updated'];
				$summary['updated']++;
			} else {
				$this->db->insert($table,$clean);
				if ($this->db->affected_rows() === 1) {
					$resultRows[]=['row_index'=>$index,'status'=>'Inserted'];
					$summary['inserted']++;
				} else {
					$resultRows[]=['row_index'=>$index,'status'=>'Rejected','message'=>'Insert failed'];
					$summary['rejected']++;
				}
			}
		}

		if (!$this->db->trans_status()) {
			$this->db->trans_rollback();
			return $this->_json(['status'=>false,'message'=>'Transaction failed']);
		}

		$this->db->trans_commit();

		return $this->_json([
			'status'=>true,
			'message'=>'Import completed',
			'summary'=>$summary,
			'rows'=>$resultRows
		]);
	}

	public function upload_salary_transfer_save()
	{
		$company_id = $this->session->userdata('company_id');
		$this->load->database();

		// ===== JSON PAYLOAD =====
		$payload = json_decode(file_get_contents("php://input"), true);

		if (empty($payload['data']) || !is_array($payload['data'])) {
			return $this->_json([
				'status' => false,
				'message' => 'Invalid or empty payload'
			]);
		}

		// ===== SALARY MONTH / YEAR =====
		$salary_month = (int) ($payload['salary_month'] ?? 0);
		$salary_year  = (int) ($payload['salary_year'] ?? 0);

		if ($salary_month < 1 || $salary_month > 12 || $salary_year < 2000) {
			return $this->_json([
				'status' => false,
				'message' => 'Invalid salary month or year'
			]);
		}

		$rows  = $payload['data'];
		$table = 'emp_salary_transfer';

		// ===== PRE-FETCH VALID EMP CODES (PERFORMANCE + SECURITY) =====
		$empCodes = array_unique(array_column($rows, 'emp_code'));

		$validEmpCodes = [];
		if ($empCodes) {
			$validEmpCodes = array_column(
				$this->db->select('emp_code')
						->where_in('emp_code', $empCodes)
						->get('employee')
						->result_array(),
				'emp_code'
			);
		}

		// ===== TRANSACTION =====
		$this->db->trans_begin();

		$resultRows = [];
		$summary = ['inserted'=>0,'rejected'=>0];

		foreach ($rows as $index => $row) {

			// ===== REQUIRED FIELDS =====
			$required = [
				'emp_code','net_salary',
				'account_no','trfd_amt','curr',
				'emp_acc','emp_ifsc'
			];

			foreach ($required as $col) {
				if (!isset($row[$col]) || trim($row[$col]) === '') {
					$resultRows[] = [
						'row_index'=>$index,
						'status'=>'Rejected',
						'message'=>"$col missing"
					];
					$summary['rejected']++;
					continue 2;
				}
			}

			// ===== EMP CODE EXISTS CHECK =====
			if (!in_array($row['emp_code'], $validEmpCodes, true)) {
				$resultRows[] = [
					'row_index'=>$index,
					'status'=>'Rejected',
					'message'=>'emp_code not found in employee master'
				];
				$summary['rejected']++;
				continue;
			}

			// ===== NUMERIC & VALUE SANITY =====
			if ((float)$row['net_salary'] <= 0 || (float)$row['trfd_amt'] <= 0) {
				$resultRows[] = [
					'row_index'=>$index,
					'status'=>'Rejected',
					'message'=>'Invalid salary or transfer amount'
				];
				$summary['rejected']++;
				continue;
			}

			if (!in_array($row['curr'], ['INR'], true)) {
				$resultRows[] = [
					'row_index'=>$index,
					'status'=>'Rejected',
					'message'=>'Invalid currency'
				];
				$summary['rejected']++;
				continue;
			}

			// ===== DUPLICATE MONTH CHECK (DB LEVEL) =====
			$exists = $this->db->where([
					'emp_code'     => $row['emp_code'],
					'salary_month' => $salary_month,
					'salary_year'  => $salary_year
				])
				->count_all_results($table);

			if ($exists) {
				$resultRows[] = [
					'row_index'=>$index,
					'status'=>'Rejected',
					'message'=>'Salary already uploaded for this month'
				];
				$summary['rejected']++;
				continue;
			}

			// ===== CLEAN INSERT (WHITELIST ONLY) =====
			$insert = [
				'emp_code'        => trim($row['emp_code']),
				'company_id'    => $company_id,
				'salary_month'    => $salary_month,
				'salary_year'     => $salary_year,
				'net_salary'      => (float)$row['net_salary'],
				'transfer_amount' => (float)$row['trfd_amt'],
				'transfer_mode'   => in_array(($row['neft'] ?? 'NEFT'), ['NEFT','NFT']) ? $row['neft'] : 'NEFT',
				'account_no'      => trim($row['account_no']),
				'emp_acc'         => trim($row['emp_acc']),
				'emp_ifsc'        => strtoupper(trim($row['emp_ifsc'])),
				'currency'        => 'INR',
				'remarks'         => $row['remarks'] ?? '',
				'uploaded_by'     => (int)$this->session->userdata('login_emp_id'),
				'uploaded_at'     => date('Y-m-d H:i:s')
			];

			$this->db->insert($table, $insert);

			if ($this->db->affected_rows() !== 1) {
				$resultRows[] = [
					'row_index'=>$index,
					'status'=>'Rejected',
					'message'=>'Insert failed'
				];
				$summary['rejected']++;
				continue;
			}

			$resultRows[] = [
				'row_index'=>$index,
				'status'=>'Inserted'
			];
			$summary['inserted']++;
		}

		// ===== TRANSACTION END =====
		if (!$this->db->trans_status()) {
			$this->db->trans_rollback();
			return $this->_json([
				'status'=>false,
				'message'=>'Transaction failed'
			]);
		}

		$this->db->trans_commit();

		return $this->_json([
			'status'=>true,
			'message'=>'Salary transfer upload completed',
			'summary'=>$summary,
			'rows'=>$resultRows
		]);
	}



	public function upload_salary_transfer()
	{
		$result['company_role']=$this->Base->get_all_contractor_code();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			//$result['res2']=$this->Hrmodel->get_coupon_receive_data_with_id($id);
			$result['res2']=[];
		}//strlen
		$this->load->view('hr/emp/upload/salary_transfer',$result);
	}//function close


public function add_full_final()
{
	$company_id = $this->session->userdata('company_id');
    if(strlen($this->uri->segment(3))>0)
	{
		$id = $this->uri->segment(3);
	}
	
	$year  = date('Y');
    $month = date('m');

    /* =========================
       1️⃣ EMPLOYEE BASIC DATA
       ========================= */
    $emp = $this->db->query("
        SELECT 
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
            B.increment_due_month,
            B.co_mob_no,
            B.plant,
            d.name AS department,
            r.name AS designation
        FROM employee B
        LEFT JOIN department d ON d.department_id = B.department_id
        LEFT JOIN department_role r ON r.role_id = B.role_in_department
        WHERE B.id = ? and B.company_id='$company_id'
    ", [$id,$company_id])->row_array();

    if (empty($emp)) {
        show_error('Invalid Employee');
    }

	
	$emp_code = $emp['emp_code'];

    /* =========================
       2️⃣ CURRENT MONTH SALARY
       ========================= */
    $current_salary = $this->db->query("
        SELECT *
        FROM daily_attendance_monthly
        WHERE emp_code = ?
          AND att_year = ?
          AND att_month = ?
		  AND company_id = ?
    ", [$emp_code, $year, $month,$company_id])->row_array();

    /* =========================
       3️⃣ LAST 3 MONTH SALARY
       ========================= */
    $last_3_month_salary = $this->db->query("
        SELECT *
        FROM daily_attendance_monthly
        WHERE emp_code = ? AND company_id = ?
        ORDER BY att_year DESC, att_month DESC
        LIMIT 3
    ", [$emp_code,$company_id])->result_array();

    /* =========================
       4️⃣ LOAN SUMMARY (RUNNING)
       ========================= */
    $loan_summary = $this->db->query("
        SELECT 
            L.loan_id,
            L.loan_amount,
            L.status,
            SUM(EMI.emi_amount) AS total_emi,
            SUM(EMI.recovered_amount) AS total_paid,
            (SUM(EMI.emi_amount) - SUM(EMI.recovered_amount)) AS remaining_amount,
            SUM(
                CASE 
                    WHEN EMI.status IN ('PENDING','PARTIAL') THEN 1 
                    ELSE 0 
                END
            ) AS remaining_emi_count
        FROM employee_loan L
        LEFT JOIN employee_loan_emi EMI 
            ON EMI.loan_id = L.loan_id
        WHERE L.emp_code = ? and company_id=?
          AND L.status = 'RUNNING'
        GROUP BY L.loan_id
    ", [$emp_code,$company_id])->result_array();

    /* =========================
       5️⃣ FINAL DATA PACKAGE
       ========================= */
    $data = [
        'employee'          => $emp,
        'current_salary'    => $current_salary,
        'last_3_salary'     => $last_3_month_salary,
        'loan_summary'      => $loan_summary,
    ];

    // abhi sirf data dekhne ke liye
    $this->load->view('hr/emp/full_final', $data);
}



	

	public function salary_reports()
	{
		$result['dept']=$this->Base->get_hr_dept();
		$result['conMaster']=$this->Base->get_payroll_master();
		$result['con']=$this->Base->get_payroll_contractor();
		$result['con2']=$this->Base->get_all_contractor_code();
		$where=" ";
		if(isset($_REQUEST['search1']))
		{
			if(isset($_REQUEST['report_type'])){$report_type=$_REQUEST['report_type'];}else{$report_type='1';}

			if(!empty($_REQUEST['name'])){$name=$_REQUEST['name'];$where.=" and  B.first_name like '$name%' ";}
			
			$company_role = $_REQUEST['company_role'] ?? [];
			if (!empty($company_role) && is_array($company_role)) {
				$company_role = array_map('trim', $company_role);
				$role_list = "'" . implode("','", $company_role) . "'";
				$where .= " AND B.company_role IN ($role_list) ";
			}

			$search_plant = $_REQUEST['search_plant'] ?? [];
			if (!empty($search_plant) && is_array($search_plant)) {
				$search_plant = array_map('trim', $search_plant);
				$role_list2 = "'" . implode("','", $search_plant) . "'";
				$where .= " AND B.plant IN ($role_list2) ";
			}

			
			if(!empty($_REQUEST['mob'])){$mob=$_REQUEST['mob'];$where.=" and  B.mob='$mob' ";}
			if(!empty($_REQUEST['emp_id'])){$emp_id=$_REQUEST['emp_id'];$where.=" and  B.emp_code='$emp_id'   ";}
			if(!empty($_REQUEST['bio_id'])){$bio_id=$_REQUEST['bio_id'];$where.=" and  B.bio_code='$bio_id'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  B.department_id='$dept'   ";}
			if(!empty($_REQUEST['hod'])){$hod=$_REQUEST['hod'];$where.=" and  B.hod_status='$hod'   ";}
			if(!empty($_REQUEST['staff'])){$staff=$_REQUEST['staff'];$where.=" and  B.staff_tech='$staff'   ";}
			if(!empty($_REQUEST['active'])){$active=$_REQUEST['active'];$where.=" and  B.active='$active'   ";}else{$active = '';}
			if(!empty($_REQUEST['shift_status'])){$shift_status=$_REQUEST['shift_status'];$where.=" and  B.shift_status='$shift_status'   ";}
			if(!empty($_REQUEST['current_shift'])){$current_shift=$_REQUEST['current_shift'];$where.=" and  B.current_shift='$current_shift'   ";}
			if(!empty($_REQUEST['mater_roll'])){$mater_roll=$_REQUEST['mater_roll'];$where.=" and  B.mater_roll='$mater_roll'   ";}
			$where.=" and owner < 1   ";
			$filteredEmp = $where;

			$month = $_REQUEST['search_month'];
			$year  = $_REQUEST['search_year'];
			$result['month'] = $month;
			$result['year'] = $year;
			// $result['type_search'] = $company_role;
			// $result['company'] = $this->Base->get_details_contractor_with_id($company_role);
			$result['type_search_list'] = $company_role;
			$result['company_list']  = $this->Base->get_details_contractor_with_id_list($company_role);

			$finalReport = array();
			if($report_type==1){
				$finalReport = $this->salary_reports_get_emp($month,$year,$filteredEmp);
				//print_r($finalReport);
				$result['finalReport']=$finalReport;
				$this->load->view('hr/report/p&a',$result);
			}
			elseif($report_type==2){
				$monthlyRows = $this->salary_reports_get_emp($month,$year,$filteredEmp);
				$dailyRows = $this->emp_daily_in_out($month,$year,$filteredEmp);
				$finalReport = $this->salary_reports_p_a($month,$year,$monthlyRows,$dailyRows);
				$result['finalReport']=$finalReport;
				$this->load->view('hr/report/pa&ot',$result);
			}
			elseif($report_type==13){
				$monthlyRows = $this->salary_reports_get_emp($month,$year,$filteredEmp);
				$dailyRows = $this->emp_daily_in_out($month,$year,$filteredEmp);
				$finalReport = $this->salary_reports_p_a($month,$year,$monthlyRows,$dailyRows);
				$result['finalReport']=$finalReport;
				$this->load->view('hr/report/pa&ot2',$result);
			}
			elseif($report_type==3){
				$where.= "  and a.att_year='$year' and a.att_month='$month' ORDER BY B.pay_code ASC ";
				$result['rows']= $this->Hrmodel->get_salary_report($where);
				$this->load->view('hr/report/salary1', $result);
			}
			elseif($report_type==4){
				$where.= "  and a.att_year='$year' and a.att_month='$month' ORDER BY B.pay_code ASC ";
				$result['rows']= $this->Hrmodel->get_salary_report($where);
				$this->load->view('hr/report/salary_traf', $result);
			}
			elseif($report_type==5){
				$where.= " and a.att_year='$year' and a.att_month='$month' ORDER BY B.pay_code ASC ";
				$result['rows']= $this->Hrmodel->get_salary_report($where);
				$this->load->view('hr/report/gratuity', $result);
			}
			elseif($report_type==6){
				$where.= " and a.att_year='$year' and a.att_month='$month' ORDER BY B.pay_code ASC ";
				$result['rows']= $this->Hrmodel->get_salary_report($where);
				$this->load->view('hr/report/bonus', $result);
			}
			elseif($report_type==7){
				$where.= "  and B.pf_ded = 'Yes'  and a.att_year='$year' and a.att_month='$month' ORDER BY B.pay_code ASC ";
				$result['rows']= $this->Hrmodel->get_salary_report($where);
				$this->load->view('hr/report/pf', $result);
			}
			elseif($report_type==8){
				$where.= "  and B.esic_ded = 'Yes'  and a.att_year='$year' and a.att_month='$month' ORDER BY B.pay_code ASC ";
				$result['rows']= $this->Hrmodel->get_salary_report($where);
				$this->load->view('hr/report/esi', $result);
			}
			elseif($report_type==9){
				$result['rows'] = $this->Hrmodel ->get_employees_without_attendance($year, $month, $company_role,$search_plant,$active); //only this in where
                $this->load->view('hr/report/no_att', $result);
			}
			elseif($report_type==10){
				$where.= "  and a.att_year='$year' and a.att_month='$month' ORDER BY B.pay_code ASC ";
				$result['rows']= $this->Hrmodel->get_salary_report($where);
				$this->load->view('hr/report/slip1', $result);
			}
			elseif($report_type==11){
				$where = " and owner < 1 and a.att_year='$year' and a.att_month='$month' "; //only this in where
				$result['rows']= $this->Hrmodel->get_salary_report_dept_wise($where);
				$this->load->view('hr/report/salary_dept', $result);
			}
			elseif($report_type==12){
				$where = " and B.owner < 1 and B.is_leave_eligible='Yes' and a.att_year='$year'  "; //only this in where
				$result['rows']= $this->Hrmodel->get_emp_leave_data($where);
				$this->load->view('hr/report/emp_leave', $result);
			}
			
			
		}
		else
		{
			$result['res2']=array();
			$this->load->view('hr/report/show',$result);
		}
	}//function close

	public function salary_reports_get_emp($month,$year,$filteredEmp)
	{
		$company_id = $this->session->userdata('company_id');
		$query1 = "
			SELECT 
				B.pay_code,B.bio_code,B.working_hr as job_hours,
				CONCAT(B.first_name,' ',B.last_name) AS full_name,B.active,B.late_punch_add,
				D.name AS department_name,
				A.*
			FROM daily_attendance_monthly AS A
			LEFT JOIN employee AS B ON A.emp_code = B.id
			LEFT JOIN department AS D ON D.department_id = B.department_id
			WHERE A.company_id = '$company_id' AND A.att_month = '$month' AND A.att_year  = '$year' $filteredEmp
		";
		return $this->Mymodel->query1($query1);
	}//function close

	public function emp_daily_in_out($month,$year)
	{
		$company_id = $this->session->userdata('company_id');
		$from_date = date('Y-m-d', strtotime("$year-$month-01"));
		$to_date   = date('Y-m-t', strtotime($from_date)); // last day
		$query2 = "SELECT
				emp_code,duty_hours,dutyMin,
				DATE(in_time)  AS attendance_date,
				TIME(in_time) AS in_time,
				TIME(out_time) AS out_time,
				CASE 
					WHEN extra_min > 0 
					THEN extra_min 
					ELSE NULL 
				END AS extra_min
			FROM daily_attendance
			WHERE company_id='$company_id' AND DATE(in_time) BETWEEN '$from_date' AND '$to_date'
			ORDER BY in_time ASC
		";
		return $this->Mymodel->query1($query2);
	}//function close

	public function salary_reports_p_a($month,$year,$monthlyRows,$dailyRows)
	{
		$inOutMap = [];
		
		foreach ($dailyRows as $r) {

			$day = (int)date('j', strtotime($r['attendance_date'])); // 1–31 

			$inOutMap[$r['emp_code']][$day] = [
				'in'  => $r['in_time'],   // HH:MM:SS
				'out' => $r['out_time'],   // HH:MM:SS
				'duty_hours' => $r['duty_hours'], 
				'dutyMin' => $r['dutyMin'], 
				'late' => $r['extra_min'] ?? 0
			];
		}

		/* 5️⃣ Monthly + Daily MERGE */
		$finalReport = [];
		
		foreach ($monthlyRows as $emp) {

			$payCode = $emp['pay_code'];
			$bio_code = $emp['bio_code'];

			$row = [
				'pay_code' => $payCode,
				'bio_code' => $bio_code,
				'working_hr' => $emp['job_hours'],
				'full_name' => $emp['full_name'],
				'active' => $emp['active'],
				'department_name' => $emp['department_name'],
				'total_present' => $emp['total_present'],
				'total_absent' => $emp['total_absent'],
				'total_ot' => $emp['total_ot'],
				'lost_1_payable' => $emp['lost_1_payable'],
				'advance_this_month_payable' => $emp['advance_this_month_payable'],
				'late_punch_add' => $emp['late_punch_add'],
				'days' => []
			];

			for ($d = 1; $d <= 31; $d++) {

				$row['days'][$d] = [
					'status' => $emp["d$d"] ?? '',      // P / A / R
					'ot'     => $emp["o$d"] ?? '',      // OT hours
					'in'     => $inOutMap[$payCode][$d]['in']  ?? '',
					'out'    => $inOutMap[$payCode][$d]['out'] ?? '',
					'duty'    => $inOutMap[$payCode][$d]['duty_hours'] ?? '',
					'dutyMin'    => $inOutMap[$payCode][$d]['dutyMin'] ?? '',
					'late'   => $inOutMap[$payCode][$d]['late'] ?? 0
				];
			}

			$finalReport[] = $row;
		}
		
		return $finalReport;
	}

	
	//attendance list
	public function menu_access()
	{
		$result['menu']=$this->Base->get_all_main_menu();
		$result['sab_menu_list']=$this->Base->get_all_sub_menu();
		$result['role']=$this->Base->get_all_dept_role();
		$result['con']=$this->Base->get_all_contractor_code();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Hrmodel->get_emp_deatis_with_id($id);
		}
		$this->load->view('setting/access/entry',$result);
	}//function close

	//get_access_of_role_id list
	public function get_access_of_role_id()
	{
		$role_id = $this->input->post('rol_id');
		if (!$role_id) {
			echo json_encode([]);
			return;
		}

		$data = $this->Company->get_access_by_role($role_id);
		echo json_encode($data);
	}

	public function get_menu_access_from_role_id()
	{
		$role_id = $this->input->post('rol_id');
		if (!$role_id) {
			echo json_encode([]);
			return;
		}
		$data = $this->Base->get_menu_access_role_id($role_id);
		echo json_encode($data);
	}

	public function get_access_save()
	{
		$role_id   = $this->input->post('role_id');
		$menus     = $this->input->post('menus');
		$sub_menus = $this->input->post('sub_menus');
		
		if (!$role_id) {
			echo 'Role missing';
			return;
		}


		$company_role = $_REQUEST['company_role'] ?? [];
		if (!empty($company_role) && is_array($company_role)) {
			$company_role = array_map('trim', $company_role);
			$role_list = implode(",", $company_role);
		}
		
		$data = array('menu_access'=>$role_list);
		$where=array('role_id '=>$role_id);   
		$this->Mymodel->update('department_role',$data,$where);

		

		// 🔥 Step 1: Clear old permissions
		$this->db->where('role_id', $role_id)->delete('erp_role_permission');

		// 🔥 Step 2: Insert menu access
		if (!empty($menus)) {
			foreach ($menus as $m) {
				if ($m['full_access'] == 1) {
					$this->db->insert('erp_role_permission', [
						'role_id'    => $role_id,
						'menu_id'    => $m['menu_id'],
						'sub_menu_id'=> NULL
					]);
				}
			}
		}

		// 🔥 Step 3: Insert sub-menu access
		if (!empty($sub_menus)) {
			foreach ($sub_menus as $s) {
				$this->db->insert('erp_role_permission', [
					'role_id'     => $role_id,
					'menu_id'     => $s['menu_id'],
					'sub_menu_id' => $s['sub_menu_id']
				]);
			}
		}

		echo 'Save';
	}



	public function download_employee_csv()
	{
		$company_id = $this->session->userdata('company_id');
		$this->Company->checkPermission2("Hr/download_employee_csv");
		
		if (ob_get_length()) {
			ob_end_clean();
		}

		header("Content-Type: text/csv; charset=utf-8");
		header("Content-Disposition: attachment; filename=employee_master.csv");

		// UTF-8 BOM (Excel safe)
		echo "\xEF\xBB\xBF";

		$out = fopen("php://output", "w");

		// Columns to exclude
		$exclude_columns = [
			'id',
			'username',
			'company_id',
			'pwd',
			'last_password_change',
			'status',
			'login_from_other_ip',
			'last_online',
			'login_ip',
			'last_logout',
			'logout_ip',
			'last_name',
			'profile',
			'created_by',
			'owner',

			'profile_pic',
			'sign',
			'resume_photo',
			'epf_photo',
			'esi_photo',
			'adhar_photo',
			'bank_photo',
			'other_id_photo',
			'other_docs_photo',
			'other_docs2_photo',
			'other_docs3_photo',
			'other_docs4_photo',
			'approvel_for_mc',
			'approvel_for_part',
			'save_by',
			'save_date',
			'update_by',
			'update_date',
			'owner',
			'owner',


			'active'
		];

		// Fetch data
		$query = $this->db->where('owner <', 1)->where('active', 'Active')->where('company_id', $company_id)->get('employee');

		$result = $query->result_array();

		if (empty($result)) {
			fputcsv($out, ['No data found']);
			fclose($out);
			exit;
		}

		/* ===== FILTER HEADERS ===== */
		$headers = array_keys($result[0]);
		$headers = array_values(array_diff($headers, $exclude_columns));
		fputcsv($out, $headers);

		/* ===== FILTER DATA ===== */
		foreach ($result as $row) {
			foreach ($exclude_columns as $col) {
				unset($row[$col]);
			}
			fputcsv($out, $row);
		}

		fclose($out);
		exit;
	}





	public function get_attendance_upload_matrix()
	{
		$company_id = $this->session->userdata('company_id');
		$month = $this->input->post('month');
		$year  = $this->input->post('year');

		if (!$month || !$year) {
			echo json_encode(['status' => false, 'message' => 'Month and Year required']);
			return;
		}

		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		// 1️⃣ Get all units from EMPLOYEE (master source)
		$units = $this->db
		->distinct()
		->select('company_role')
		->from('employee')
		->where('company_id', $company_id)
		->where('active', 'Active')
		->where('company_role IS NOT NULL', null, false)
		->where('company_role !=', '')
		->get()
		->result_array();


						
		$matrix = [];
		$days   = [];

		for ($d = 1; $d <= $daysInMonth; $d++) {

			$col  = 'd' . $d;
			$date = sprintf('%04d-%02d-%02d', $year, $month, $d);
			$days[] = $date;

			foreach ($units as $u) {

				if (empty($u['company_role'])) {
					continue;
				}

				$count = $this->db
					->select("COUNT(emp_code) AS total", false)
					->from('daily_attendance_monthly')
					->where([
						'company_id'        => $company_id,
						'att_year'        => $year,
						'att_month'       => $month,
						'company_role_id' => $u['company_role']
					])
					->where("$col IS NOT NULL", null, false)
					->where("$col != ''", null, false)
					->where("$col != '0'", null, false)
					->get()
					->row()
					->total ?? 0;

				$matrix[$u['company_role']]['days'][$date] = (int)$count;
			}
		}

		// 2️⃣ Total employees per unit
		// foreach ($units as $u) {
		// 	$totalEmp = $this->db
		// 		->where([
		// 			'company_role' => $u['company_role'],
		// 			'active'       => 'Active'
		// 		])
		// 		->count_all_results('employee');

		// 	$matrix[$u['company_role']]['total_emp'] = $totalEmp;
		// }

		// 2️⃣ Total employees per unit
		foreach ($units as $u) {

			// total active employees (master)
			$totalEmp = $this->db
				->where([
					'company_role' => $u['company_role'],
					'company_id'       => $company_id,
					'active'       => 'Active'
				])
				->count_all_results('employee');

			$matrix[$u['company_role']]['total_emp'] = (int)$totalEmp;

			// 🔥 total employees whose attendance data exists for this month
			$totalEmpPunch = $this->db
				->select('COUNT(DISTINCT emp_code) AS total', false)
				->from('daily_attendance_monthly')
				->where([
					'company_id'       => $company_id,
					'att_year'        => $year,
					'att_month'       => $month,
					'company_role_id' => $u['company_role']
				])
				->get()
				->row()
				->total ?? 0;

			$matrix[$u['company_role']]['total_emp_punch'] = (int)$totalEmpPunch;
		}


		echo json_encode([
			'status' => true,
			'units'  => $matrix,
			'days'   => $days
		]);
	}


	public function get_missing_employees()
	{
		$company_id = $this->session->userdata('company_id');
		$unit = $this->input->post('unit');   // company_role_id
		$date = $this->input->post('date');   // YYYY-MM-DD

		if (!$unit || !$date) {
			echo json_encode([
				'status' => false,
				'message' => 'Invalid request'
			]);
			return;
		}

		$day = (int)date('d', strtotime($date));
		$col = 'd'.$day;

		$this->db->select("
					B.emp_code,
					$col as att_status,

					B.first_name,
					B.last_name,

					d.name AS department,
					r.name AS designation
		");

		$this->db->from('daily_attendance_monthly as a');
		$this->db->join('employee as B', 'B.id = a.emp_code', 'left');
		$this->db->join('department as d', 'd.department_id = B.department_id', 'left');
		$this->db->join('department_role as r', 'r.role_id = B.role_in_department', 'left');
		$this->db->where('a.company_role_id', $unit);
		$this->db->where('a.company_id', $company_id);
		$this->db->where("a.att_year = YEAR('$date')", null, false);
		$this->db->where("a.att_month = MONTH('$date')", null, false);

		// $this->db->where("
		// 	a.emp_code NOT IN (
		// 		SELECT emp_code
		// 		FROM daily_attendance_monthly
		// 		WHERE company_role_id = '$unit'
		// 		AND att_year = YEAR('$date')
		// 		AND att_month = MONTH('$date')
		// 		AND $col IN ('P','HA','H','HL','CL','R','S','OL','L')
		// 	)
		// ", null, false);
		// $this->db->where("($col IS NULL OR $col = '' OR $col = 'A' OR $col = '0')", null, false);
		$this->db->group_by('a.emp_code');
		$this->db->order_by($col, 'DESC');

		$rows = $this->db->get()->result_array();
		

		echo json_encode([
			'status' => true,
			'data'   => $rows
		]);
	}


	public function get_attendance_status_summary()
	{
		$company_id = $this->session->userdata('company_id');
		$month = $this->input->post('month');
		$year  = $this->input->post('year');

		if (!$month || !$year) {
			echo json_encode(['status'=>false,'message'=>'Month & Year required']);
			return;
		}

		$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		$statuses = ['P','A','HL','HA','L','R','S','H','OL','CL','SL','EL'];

		$summary = [];

		foreach ($statuses as $st) {
			for ($d = 1; $d <= $days; $d++) {

				$col = 'd'.$d;

				$count = $this->db
					->where('att_year', $year)
					->where('att_month', $month)
					->where($col, $st)
					->where('company_id', $company_id)
					->count_all_results('daily_attendance_monthly');

				$summary[$st][$d] = $count;
			}
		}

		echo json_encode([
			'status' => true,
			'days'   => $days,
			'data'   => $summary
		]);
	}

	public function get_status_wise_employees()
	{
		$company_id = $this->session->userdata('company_id');
		$status = $this->input->post('status');
		$date   = $this->input->post('date');

		if (!$status || !$date) {
			echo json_encode(['status'=>false,'message'=>'Invalid request']);
			return;
		}

		$day   = (int)date('d', strtotime($date));
		$month = (int)date('m', strtotime($date));
		$year  = (int)date('Y', strtotime($date));

		$col = 'd'.$day;

		$this->db->select("
			B.emp_code,
			B.company_role,
			CONCAT(B.first_name,' ',B.last_name) as name,
			d.name as department,
			r.name as designation
		");
		$this->db->from('daily_attendance_monthly a');
		$this->db->join('employee B','B.id = a.emp_code','left');
		$this->db->join('department d','d.department_id = B.department_id','left');
		$this->db->join('department_role r','r.role_id = B.role_in_department','left');

		// 🔥 CRITICAL FILTERS (MISSING THE)
		$this->db->where('a.att_year', $year);
		$this->db->where('a.att_month', $month);
		$this->db->where("a.$col", $status);
		$this->db->where('a.company_id', $company_id);

		$this->db->order_by('B.company_role', 'ASC');
		$this->db->order_by('B.emp_code', 'ASC');

		$rows = $this->db->get()->result_array();

		echo json_encode([
			'status'=>true,
			'data'=>$rows
		]);
	}


	public function late_widgets_fun()
	{
		$date = $this->input->post('date');
		if (!$date) {
			echo json_encode(['status'=>false,'msg'=>'Date required']);
			return;
		}
		
		$data = $this->Hrmodel->get_late_widgets_data($date);

		echo json_encode([
			'status' => true,
			'data'   => $data
		]);
	}

	public function habitual_late_breakdown()
	{
		$emp_code = $this->input->post('emp_code');
		$date     = $this->input->post('date');

		if (!$emp_code || !$date) {
			echo json_encode([
				'status' => false,
				'msg' => 'Invalid params'
			]);
			return;
		}

		$data = $this->Hrmodel->get_habitual_late_breakdown($emp_code, $date);

		echo json_encode([
			'status' => true,
			'data'   => $data
		]);
	}


	public function late_modal_data()
	{
		$type = $this->input->post('type');
		$date = $this->input->post('date');

		switch ($type) {
			case 'late_in':
				$data = $this->Hrmodel->modal_late_in($date);
				break;
			case 'early_out':
				$data = $this->Hrmodel->modal_early_out($date);
				break;
			case 'approved_leave':
				$data = $this->Hrmodel->modal_approved_leave($date);
				break;
			case 'unapproved_leave':
				$data = $this->Hrmodel->modal_unapproved_leave($date);
				break;
			case 'half_day':
				$data = $this->Hrmodel->modal_half_day($date);
				break;
			case 'habitual_late':
				$data = $this->Hrmodel->modal_habitual_late($date);
				break;
			default:
				$data = [];
		}

		echo json_encode(['status'=>true,'data'=>$data]);
	}







	public function salary_compare()
	{
		$company_id = $this->session->userdata('company_id');
		if(!empty($_REQUEST['allSalary'])){$showAllSalary = $_REQUEST['allSalary'];}else{$showAllSalary='Yes';}
		/* ================= PAYROLL ================= */
		$payroll_rs = $this->Mymodel->query1("SELECT * FROM payroll_salary_sheet");

		$payroll = [];
		foreach ($payroll_rs as $p) {
			$code = trim($p['emp_code']); // STRING like 7STR113
			$payroll[$code] = $p;
		}

		/* ================= ATTENDANCE (FIXED) ================= */
		$att_rs = $this->Mymodel->query1("SELECT
				E.emp_code AS real_emp_code,
				E.company_role,
				E.first_name,
				A.basic_salary,
				A.hra AS att_hra,
				A.other_allow,
				A.current_ctc,
				A.total_present,
				A.basic_salary_payable,
				A.hra_payable,
				A.other_allow_payable,
				A.current_ctc_payable,
				A.epf_payable,
				A.esic_payable,
				A.advance_this_month_payable,
				A.total_deduction,
				A.current_total_ctc_payable
			FROM daily_attendance_monthly A
			JOIN employee E ON A.emp_code = E.id WHERE A.att_month=2 and A.att_year=2026 and A.company_id='$company_id'
		");

		$attendance = [];
		foreach ($att_rs as $a) {
			$code = trim($a['real_emp_code']); // NOW SAME FORMAT
			$attendance[$code] = $a;
		}

		/* ================= MERGE ================= */
		$all_emp_codes = array_unique(
			array_merge(array_keys($payroll), array_keys($attendance))
		);
	?>
	
	<style>
		table { border-collapse: collapse; width: 100%; }
		th, td { border: 1px solid #333; padding: 6px; font-size: 13px; }

		/* Payroll headers */
		.payroll { background:#d1ecf1; }

		/* Attendance headers */
		.attendance { background:#ffeeba; }

		/* Common */
		.key { background:#c3e6cb; }
		.status { background:#e2e3e5; }
	</style>

	<table>
		<thead>
			<tr>
				<th class="key">emp_code</th>

				<!-- PAYROLL -->
			
				<th class="payroll">reff</th>
				<th class="attendance">company_role</th>
				<th class="payroll">empl_bio_id</th>
				<th class="payroll">name</th>
				<th class="attendance">first_name</th>


				<th class="payroll">basic</th>
				<th class="payroll">hra</th>
				<th class="payroll">oth_allow</th>
				<th class="payroll">gross_salary</th>

				<th class="attendance">basic_salary</th>
				<th class="attendance">att_hra</th>
				<th class="attendance">other_allow</th>
				<th class="attendance">current_ctc</th>


				<th class="payroll">working_days</th>
				<th class="payroll">total_working_days</th>
				<th class="attendance">total_present</th>


				<th class="payroll">basic_earn</th>
				<th class="payroll">hra_earn</th>
				<th class="payroll">oth_allow_earn</th>
				<th class="payroll">gross_salary_net</th>

				<th class="attendance">basic_salary_payable</th>
				<th class="attendance">hra_payable</th>
				<th class="attendance">other_allow_payable</th>
				<th class="attendance">current_ctc_payable</th>


				<th class="payroll">epf_wages</th>
				<th class="payroll">epf</th>
				<th class="payroll">esi</th>
				<th class="payroll">adv</th>
				<th class="attendance">epf_payable</th>
				<th class="attendance">esic_payable</th>
				<th class="attendance">advance_this_month_payable</th>


				<th class="payroll">total_salary_deduction</th>
				<th class="attendance">total_deduction</th>


				<th class="payroll">net_pay_salary</th>
				<th class="attendance">current_total_ctc_payable</th>


				<th class="payroll">unit</th>
				<th class="payroll">net_pay_bank_trfd</th>
				<th class="payroll">days_final</th>

			
				<th class="status">row_type</th>
			</tr>
		</thead>

		<tbody>

		<?php
			foreach ($all_emp_codes as $emp_code) {

				$p = $payroll[$emp_code] ?? [];
				$a = $attendance[$emp_code] ?? [];

				if ($p && $a) {
					$bg = '#e8ffe8';
					$type = 'BOTH';
				} elseif ($p) {
					$bg = '#fff3cd';
					$type = 'PAYROLL_ONLY';
				} else {
					$bg = '#f8d7da';
					$type = 'ATTENDANCE_ONLY';
				}

				$day_color='black';
				if(!empty($p['total_working_days']) && !empty($a['total_present'])){
					if((float)$p['total_working_days'] != (float)$a['total_present']){
						$day_color='red';
					}else{
						if($showAllSalary == 'No')continue;
						$day_color='green';
					}
				}

				$totol_ctc='black';
				if(!empty($p['gross_salary']) && !empty($a['current_ctc'])){
					if((float)$p['gross_salary'] != (float)$a['current_ctc']){
						
						$totol_ctc='red';
					}else{
						$totol_ctc='green';
					}
				}

				$totol_color='black';
				if(!empty($p['net_pay_salary']) && !empty($a['current_total_ctc_payable'])){
					if((float)$p['net_pay_salary'] != (float)$a['current_total_ctc_payable']){
						$totol_color='red';
					}else{
						$totol_color='green';
					}
				}


			?>
			<tr style="background:<?= $bg ?>">
				<td><?= $emp_code ?></td>

				<!-- PAYROLL -->
			
				<td><?= $p['reff'] ?? '' ?></td>
				<td><?= $a['company_role'] ?? '' ?></td>
				<td><?= $p['empl_bio_id'] ?? '' ?></td>
				<td><?= $p['name'] ?? '' ?></td>
				<td><?= $a['first_name'] ?? '' ?></td>
				
				<td><?= $p['basic'] ?? '' ?></td>
				<td><?= $p['hra'] ?? '' ?></td>
				<td><?= $p['oth_allow'] ?? '' ?></td>
				<td><?= $p['gross_salary'] ?? '' ?></td>

				<td><?= $a['basic_salary'] ?? '' ?></td>
				<td><?= $a['att_hra'] ?? '' ?></td>
				<td><?= $a['other_allow'] ?? '' ?></td>
				<td style="color:<?php echo $totol_ctc;?>"><?= $a['current_ctc'] ?? '' ?></td>
				
				<td><?= $p['working_days'] ?? '' ?></td>
				<td ><?= $p['total_working_days'] ?? '' ?></td>
				<td style="color:<?php echo $day_color;?>"><?= $a['total_present'] ?? '' ?></td>


				<td><?= $p['basic_earn'] ?? '' ?></td>
				<td><?= $p['hra_earn'] ?? '' ?></td>
				<td><?= $p['oth_allow_earn'] ?? '' ?></td>
				<td><?= $p['gross_salary_net'] ?? '' ?></td>
				
				<td><?= $a['basic_salary_payable'] ?? '' ?></td>
				<td><?= $a['hra_payable'] ?? '' ?></td>
				<td><?= $a['other_allow_payable'] ?? '' ?></td>
				<td><?= $a['current_ctc_payable'] ?? '' ?></td>


				<td><?= $p['epf_wages'] ?? '' ?></td>
				<td><?= $p['epf'] ?? '' ?></td>
				<td><?= $p['esi'] ?? '' ?></td>
				<td><?= $p['adv'] ?? '' ?></td>
				<td><?= $a['epf_payable'] ?? '' ?></td>
				<td><?= $a['esic_payable'] ?? '' ?></td>
				<td><?= $a['advance_this_month_payable'] ?? '' ?></td>

				<td><?= $p['total_salary_deduction'] ?? '' ?></td>
				<td><?= $a['total_deduction'] ?? '' ?></td>

				<td><?= $p['net_pay_salary'] ?? '' ?></td>
				<td style="color:<?php echo $totol_color;?>"><?= $a['current_total_ctc_payable'] ?? '' ?></td>

				<td><?= $p['unit'] ?? '' ?></td>
				<td><?= $p['net_pay_bank_trfd'] ?? '' ?></td>
				<td><?= $p['days_final'] ?? '' ?></td>

				
				<td><?= $type ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

	<?php
	}




	public function salary_update_in_master()
	{
		$company_id = $this->session->userdata('company_id');
		/* ================= PAYROLL ================= */
		$payroll_rs = $this->Mymodel->query1("SELECT * FROM payroll_salary_sheet");
		foreach($payroll_rs as $p){
			$emp_code = $p['emp_code'];
			//if($emp_code != 'TZ649') continue;

			$basic = (int)$p['basic'];
			$hra = (int)$p['hra'];
			$oth_allow = (int)$p['oth_allow'];
			$gross_salary = (int)$p['gross_salary'];
			
			
			//echo "$emp_code, $basic, $hra, $oth_allow, $gross_salary";
			//echo "<br>";

			$emp = $this->Mymodel->query1("SELECT id,company_role,emp_code,current_ctc,basic_salary,hra,other_allow,current_total_ctc FROM employee WHERE emp_code = '$emp_code' and company_id='$company_id' ");
			if(!empty($emp)){
				continue;
				//print_r($emp);
				// $data = array(
				// 				'basic_salary'=>$basic,
				// 				'hra'=>$hra,
				// 				'other_allow'=>$oth_allow,
				// 				'current_ctc'=>$gross_salary,
				// 				'current_total_ctc'=>$gross_salary,
				// 				);
				// $where=array('emp_code'=>$emp_code);   
				// $this->Mymodel->update('employee',$data,$where);
				//echo "<br>";
			}else{
				//emp not found
				
				
				$pf1 = "";$pf2 = "";
				$esi1='';$esi2='';
				if($gross_salary < 16000){
					$pf1='Yes';$pf2='12';
					$esi1='Yes';$esi2='0.75';
				}
				$data = array(
							'status'=>'Deactive',
							'Active'=>'Active',
							'owner'=>0,
							'company_id'=>$company_id,
							
							'first_name'=>$p['name'],
							'emp_code'=>$p['emp_code'],
							'pay_code'=>$p['emp_code'],
							'bio_code'=>$p['empl_bio_id'],
							
							'company_role'=>'7START',
							'plant'=>'7START',

							'esic'=>$esi2,
							'epf'=>$pf2,
							'esic_ded'=>$esi1,
							'pf_ded'=>$pf1,
							
							'restday'=>'Sun',
							'working_hr'=>12,
							'shift_status'=>'In Shift',
							'current_shift'=>'A',
							'get_overtime'=>'No',
							
							'basic_salary'=>$basic,
							'hra'=>$hra,
							'other_allow'=>$oth_allow,
							'current_ctc'=>$gross_salary,
							'current_total_ctc'=>$gross_salary,
				);
				//$this->Mymodel->insertdata('employee',$data);
				//echo "$emp_code, $basic, $hra, $oth_allow, $gross_salary";
				echo $emp_code;
				//print_r($data);
				echo "<br>";
				
			}
		}
		echo "done";
	}




	public function update_in_att_p_a()
	{
		$company_id = $this->session->userdata('company_id');
		/* ================= PAYROLL ================= */
		$payroll_rs = $this->Mymodel->query1("SELECT emp_code,total_working_days FROM payroll_salary_sheet");
		foreach($payroll_rs as $p){
			$emp_code = $p['emp_code'];
			$total_working_days = (float)$p['total_working_days'];
			//if($emp_code!= '7STR586')continue;
			
		
			$emp = $this->Mymodel->query1("SELECT id FROM employee WHERE emp_code = '$emp_code' ");
			if(!empty($emp)){
				$emp_id = $emp[0]['id'];
				$att = $this->Mymodel->query1("SELECT att_monthly_id,total_present,d1,d2,d3,d4,d5,d6,d6,d7,d8,d9,d10,d11,d12,d13,d14,d15,d16,d17,d18,d19,d20,d21,d22,d23,d24,d25,d26,d27,d28,d29,d30,d31 FROM daily_attendance_monthly WHERE company_id='$company_id' and emp_code = '$emp_id' and  att_year='2025' and att_month='12'  ");
				if(!empty($att)){
					$td = $att[0]['total_present'];
					$att_monthly_id = $att[0]['att_monthly_id'];

					echo "$emp_code, $total_working_days, $td";
					echo "<br>";

					if ($total_working_days > $td) {
						$attRow = $att[0];
						$requiredDays = (float)$total_working_days;

						// load days
						$days = [];
						for ($i = 1; $i <= 31; $i++) {
							$days["d$i"] = $attRow["d$i"] ?? '';
						}
						//print_r($days);
						// recalc current present
						$currentPresent = 0;
						foreach ($days as $v) {
							if ($v === 'P') $currentPresent += 1;
							elseif ($v === 'HA') $currentPresent += 0.5;
						}

						$diff = $requiredDays - $currentPresent;
						if ($diff <= 0) return;

						/* ===== ADD LOGIC ===== */

						// 1) HA -> P (+0.5)
						foreach ($days as $day => $value) {
							if ($diff < 0.5) break;
							if ($value === 'HA') {
								$days[$day] = 'P';
								$diff -= 0.5;
							}
						}

						// 2) A / '' / R -> P (+1)
						foreach ($days as $day => $value) {
							if ($diff < 1) break;
							if ($value === '' || $value === 'A' || $value === 'R') {
								$days[$day] = 'P';
								$diff -= 1;
							}
						}

						// 3) remaining 0.5 -> HA
						if ($diff >= 0.5) {
							foreach ($days as $day => $value) {
								if ($value === '' || $value === 'A' || $value === 'R') {
									$days[$day] = 'HA';
									break;
								}
							}
						}
						//print_r($days);
						//exit;
						// update DB
						$this->db->where('att_monthly_id', $attRow['att_monthly_id'])->where('company_id', $company_id);
						$this->db->update('daily_attendance_monthly', $days);

						$this->Hrmodel->add_total_present_absent_attendance_monthly(
							$attRow['att_monthly_id']
						);
					}


					elseif ($td > $total_working_days) {

						$attRow = $att[0];
						$requiredDays = (float)$total_working_days;

						// load days
						$days = [];
						for ($i = 1; $i <= 31; $i++) {
							$days["d$i"] = $attRow["d$i"] ?? '';
						}
						print_r($days);
						// ❗ USE DB total_present (NOT recalculated)
						$currentPresent = (float)$td;

						$excess = $currentPresent - $requiredDays;
						if ($excess <= 0) return;

						/* ===== FORCE MINUS LOGIC ===== */

						// 1) P -> A (-1)
						$days = [];
						for ($i = 1; $i <= 31; $i++) {
							$days["d$i"] = $attRow["d$i"] ?? '';
						}

						/* ===== STEP 1: HANDLE 0.5 FIRST ===== */
						if (fmod($excess, 1) == 0.5) {

							$done = false;

							// HA → A  (−0.5)
							foreach ($days as $d => $v) {
								if ($v === 'HA') {
									$days[$d] = 'A';
									$excess -= 0.5;
									$done = true;
									break;
								}
							}

							// fallback: P → HA (−0.5)
							if (!$done) {
								foreach ($days as $d => $v) {
									if ($v === 'P') {
										$days[$d] = 'HA';
										$excess -= 0.5;
										break;
									}
								}
							}
						}

						/* ===== STEP 2: HANDLE FULL DAYS ===== */
						while ($excess >= 1) {
							foreach ($days as $d => $v) {
								if ($v === 'P') {
									$days[$d] = 'A';
									$excess -= 1;
									break;
								}
							}
						}
						//print_r($days);
						
						// update DB
						$this->db->where('att_monthly_id', $attRow['att_monthly_id'])->where('company_id', $company_id);
						$this->db->update('daily_attendance_monthly', $days);

						$this->Hrmodel->add_total_present_absent_attendance_monthly(
							$attRow['att_monthly_id']
						);

						print_r($days);
					}
		
				}else{
					//echo "$emp_code, $total_working_days";
					//echo "<br>";
				}
			}else{
				//emp not found
				//echo "$emp_code, $basic, $hra, $oth_allow, $gross_salary";
				// echo $emp_code;
				//print_r($data);
				// echo "<br>";
			}
		}
		echo "done";
	}


	public function duplicate_emp()
	{
		$q = "
			SELECT id, emp_code, bio_code
			FROM employee
			WHERE owner < 1
			AND bio_code IN (
				SELECT bio_code
				FROM employee
				WHERE owner < 1
				GROUP BY bio_code
				HAVING COUNT(*) > 1
			)
			ORDER BY bio_code, id
		";

		$emp = $this->Mymodel->query1($q);

		if (!empty($emp)) {

		// Step 1: group by bio_code
		$grouped = [];
		foreach ($emp as $row) {
			$grouped[$row['bio_code']][] = $row;
		}

		

		echo '<table border="1" cellpadding="6" cellspacing="0">';
		echo '<tr>
				<th>Bio Code</th>
				<th>ID 1</th>
				<th>Emp Code 1</th>
				<th>old Att ID 1</th>
				<th>new Att ID 1</th>

				<th>ID 2</th>
				<th>Emp Code 2</th>
				<th>old Att ID 2</th>
				<th>new Att ID 2</th>
			</tr>';

		foreach ($grouped as $bio_code => $rows) {

			// At least 2 honge, warna duplicate hi nahi hota
			$r1 = $rows[0];
			$r2 = $rows[1];
			$e1= $r1['id'];
			$e2= $r2['id'];

			$emp_code_att1 =0;
			$att_monthly_id1 =0;
			$att1 = $this->Mymodel->query1("SELECT att_monthly_id,emp_code FROM daily_attendance_monthly WHERE emp_code = '$e1'   ");
		
			if(!empty($att1)){
				$emp_code_att1 = $att1[0]['emp_code'];
				$att_monthly_id1 = $att1[0]['att_monthly_id'];
			}

			$emp_code_att2 =0;
			$att_monthly_id2 =0;
			$att2 = $this->Mymodel->query1("SELECT att_monthly_id,emp_code FROM daily_attendance_monthly WHERE emp_code = '$e2'   ");
				//print_r($att2);
			if(!empty($att2)){
				
				$emp_code_att2 = $att2[0]['emp_code'];
				$att_monthly_id2 = $att2[0]['att_monthly_id'];
			}

			$new_code = "";
			if($att_monthly_id1 >1 && $emp_code_att2>1)
				{
					//old wala 
					$new_code = "$emp_code_att1-$e2-delete ";
					// $this->Mymodel->update('daily_attendance_monthly',['emp_code'    => $new_code,],['emp_code' => $e1]);
					// $this->Mymodel->update('daily_attendance_monthly',['emp_code'    => $emp_code_att1,],['emp_code' => $e2]);
				}

			


			

			echo '<tr>';
			echo '<td>' . $bio_code . '</td>';
			echo '<td>' . $r1['id'] . '</td>';
			echo '<td>' . $r1['emp_code'] . '</td>';
			echo '<td>' . $emp_code_att1 . '</td>';
			echo '<td>' . $new_code . '</td>';

			echo '<td>' . $r2['id'] . '</td>';
			echo '<td>' . $r2['emp_code'] . '</td>';
			
			echo '<td>' . $emp_code_att2 . '</td>';
			
			echo '<td>' . $emp_code_att1 . '</td>';
			echo '</tr>';

			
			// //update emp code 2
			// $excel_emp_code = $r2['emp_code'];//New wala hai ise delete krna hai 
			// $new_excel_emp_code = $r2['emp_code'].'_DEL';
			// $where = ['emp_code' => $excel_emp_code];
			// $data2 = [
			// 			'emp_code' => "$new_excel_emp_code",
			// 		  	'pay_code' => $new_excel_emp_code,
			// 		];
			// $this->Mymodel->update('employee', $data2, $where);
			
			// $data = ['emp_code' => $new_excel_emp_code];
			// $this->Mymodel->update('canteen_coupon_issue', $data, $where);
			// $this->Mymodel->update('daily_attendance', $data, $where);
			// $this->Mymodel->update('daily_attendance_monthly_emp_exp', $data, $where);
			// $this->Mymodel->update('employee_loan', $data, $where);
			// $this->Mymodel->update('employee_loan_emi_recovery', $data, $where);
			// $this->Mymodel->update('emp_advance', $data, $where);
			// $this->Mymodel->update('emp_leave', $data, $where);
			// $this->Mymodel->update('emp_other_application', $data, $where);
			// $this->Mymodel->update('emp_reimbursement_master', $data, $where);
			// $this->Mymodel->update('emp_salary_transfer', $data, $where);
			// $this->Mymodel->update('emp_tds', $data, $where);


			// //update emp code 1
			// $excel_emp_code = $r1['emp_code'];//New wala hai ise delete krna hai 
			// $new_excel_emp_code = $r2['emp_code'];
			// $where = ['emp_code' => $excel_emp_code];
			// $data2 = [
			// 			'emp_code' => "$new_excel_emp_code",
			// 		  	'pay_code' => $new_excel_emp_code,
			// 		];
			// $this->Mymodel->update('employee', $data2, $where);
			
			// $data = ['emp_code' => $new_excel_emp_code];
			// $this->Mymodel->update('canteen_coupon_issue', $data, $where);
			// $this->Mymodel->update('daily_attendance', $data, $where);
			// $this->Mymodel->update('daily_attendance_monthly_emp_exp', $data, $where);
			// $this->Mymodel->update('employee_loan', $data, $where);
			// $this->Mymodel->update('employee_loan_emi_recovery', $data, $where);
			// $this->Mymodel->update('emp_advance', $data, $where);
			// $this->Mymodel->update('emp_leave', $data, $where);
			// $this->Mymodel->update('emp_other_application', $data, $where);
			// $this->Mymodel->update('emp_reimbursement_master', $data, $where);
			// $this->Mymodel->update('emp_salary_transfer', $data, $where);
			// $this->Mymodel->update('emp_tds', $data, $where);
			
		}

		echo '</table>';

	} else {
		echo 'No duplicate records found';
	}


	// echo 'done';
	}





	/*
	//one time use function
	//temp table
	public function temp_dept_update()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		$query=" SELECT * FROM temp_table";
		$res = $this->Mymodel->query1($query);
		$i=1;
		foreach($res as $r){
			if(!empty($r['c1'])){
				

				$data = array(
								'department_id'=>$r['c2'],
								'sub_department_id'=>$r['c2'],
								'emp_code'=>$r['c1'],
							);
				$where=array('emp_code'=>$r['c1']);   
				$this->Mymodel->update('employee',$data,$where);
				print_r($data);
				echo "<br>";
				$i++;
			
			}
		}//foreach
		echo "Save";
	}//function close
	


	public function copy_account_no()
	{
		$query=" SELECT emp_code FROM daily_attendance_monthly GROUP BY emp_code";
		$res = $this->Mymodel->query1($query);
		
		foreach($res as $r){
			$emp_id = $r['emp_code'];
			//echo "<br>";
				
				$emp = array();
				$query=" SELECT bank_account_no,co_mob_no FROM employee WHERE id='$emp_id'";
				$emp = $this->Mymodel->query1($query);
				//print_r($emp);
				$bank_account_no = $emp[0]['bank_account_no'];
				$co_mob_no = $emp[0]['co_mob_no'];
				//echo "<br>";

				$data = array(
								'bank_account'=>$bank_account_no,
								'bank_ifsc'=>$co_mob_no,
							);
				$where=array('emp_code'=>$emp_id);   
				$this->Mymodel->update('daily_attendance_monthly',$data,$where);
				
		}//foreach
		echo "Save";
	}//function close
	

	

	public function out_punch_mis_match()
	{
		$query = "SELECT id, emp_code, in_time, out_time 
				FROM daily_attendance 
				WHERE shift='B'
				AND in_time != '0000-00-00 00:00:00'
				AND out_time != '0000-00-00 00:00:00'";

		$res = $this->Mymodel->query1($query);

		foreach ($res as $r) {

			$id       = $r['id'];
			$in_dt    = $r['in_time'];
			$out_dt   = $r['out_time'];

			$inTime  = strtotime($in_dt);
			$outTime = strtotime($out_dt);

			// If OUT is earlier than IN → fix date
			if ($outTime < $inTime) {

				$newOut = date("Y-m-d H:i:s", $outTime + 86400);

			
				$data5 = array(
								'out_time'=>"$newOut",
								'out_time_mc'=>"$newOut",
							);
				$where5=array('id'=>"$id");   
				$this->Mymodel->update('daily_attendance',$data5,$where5);

				echo "<br>Updated $id → $out_dt -> $newOut";
			}
		}

		echo "<br>Done";
	}
		*/







public function emp_hierarchy_report()
{
    // $query = "SELECT 
    //             e.emp_code,
    //             e.first_name AS emp_name,
    //             e.manager_emp_code,
    //             e.emp_team AS level,
    //             d.name AS department,
    //             r.name AS designation
    //           FROM employee e
    //           LEFT JOIN department d 
    //             ON d.department_id = e.department_id
    //           LEFT JOIN department_role r 
    //             ON r.role_id = e.role_in_department
    //           WHERE e.active='Active'
    //           ORDER BY e.manager_emp_code ASC";

    // $rows = $this->Mymodel->query1($query);

	$rows = [

    // LEVEL 1 (TOP)
    [
        'emp_code' => 'E001',
        'emp_name' => 'Rakesh Sharma',
        'manager_emp_code' => '',
        'level' => 1,
        'department' => 'Management',
        'designation' => 'CEO'
    ],

    // LEVEL 2
    [
        'emp_code' => 'E010',
        'emp_name' => 'Neha Verma',
        'manager_emp_code' => 'E001',
        'level' => 2,
        'department' => 'Production',
        'designation' => 'Plant Head'
    ],
    [
        'emp_code' => 'E020',
        'emp_name' => 'Amit Joshi',
        'manager_emp_code' => 'E001',
        'level' => 2,
        'department' => 'HR',
        'designation' => 'HR Head'
    ],
    [
        'emp_code' => 'E030',
        'emp_name' => 'Sandeep Singh',
        'manager_emp_code' => 'E001',
        'level' => 2,
        'department' => 'Accounts',
        'designation' => 'Finance Head'
    ],

    // LEVEL 3
    [
        'emp_code' => 'E011',
        'emp_name' => 'Vikas Yadav',
        'manager_emp_code' => 'E010',
        'level' => 3,
        'department' => 'Production',
        'designation' => 'Shift Manager'
    ],
    [
        'emp_code' => 'E012',
        'emp_name' => 'Pooja Meena',
        'manager_emp_code' => 'E010',
        'level' => 3,
        'department' => 'Maintenance',
        'designation' => 'Maintenance Manager'
    ],
    [
        'emp_code' => 'E021',
        'emp_name' => 'Rahul Jain',
        'manager_emp_code' => 'E020',
        'level' => 3,
        'department' => 'HR',
        'designation' => 'Recruitment Manager'
    ],

    // LEVEL 4
    [
        'emp_code' => 'E111',
        'emp_name' => 'Lokesh',
        'manager_emp_code' => 'E011',
        'level' => 4,
        'department' => 'Production',
        'designation' => 'Supervisor'
    ],
    [
        'emp_code' => 'E112',
        'emp_name' => 'Imran',
        'manager_emp_code' => 'E011',
        'level' => 4,
        'department' => 'Production',
        'designation' => 'Supervisor'
    ],
    [
        'emp_code' => 'E121',
        'emp_name' => 'Deepak',
        'manager_emp_code' => 'E012',
        'level' => 4,
        'department' => 'Maintenance',
        'designation' => 'Technician Lead'
    ],

    // LEVEL 5
    [
        'emp_code' => 'E211',
        'emp_name' => 'Ravi',
        'manager_emp_code' => 'E111',
        'level' => 5,
        'department' => 'Production',
        'designation' => 'Operator'
    ],
    [
        'emp_code' => 'E212',
        'emp_name' => 'Sunil',
        'manager_emp_code' => 'E111',
        'level' => 5,
        'department' => 'Production',
        'designation' => 'Operator'
    ],
    [
        'emp_code' => 'E213',
        'emp_name' => 'Arjun',
        'manager_emp_code' => 'E112',
        'level' => 5,
        'department' => 'Production',
        'designation' => 'Operator'
    ],
];
    $children = [];
    $info = [];

    foreach ($rows as $r) {
        $manager = $r['manager_emp_code'] ?: 'ROOT';
        $children[$manager][] = $r['emp_code'];
        $info[$r['emp_code']] = $r;
    }

    // build tree
    function buildTree($parent, &$children) {
        $branch = [];
        if(isset($children[$parent])){
            foreach ($children[$parent] as $emp) {
                $branch[$emp] = buildTree($emp, $children);
            }
        }
        return $branch;
    }

    $tree = buildTree('ROOT', $children);

    // analytics
    function countTeam($node){
        $count=0;
        foreach($node as $child){
            $count += 1 + countTeam($child);
        }
        return $count;
    }

    $analytics=[];
    foreach($tree as $boss=>$team){
        $analytics[$boss]=countTeam($team);
    }

    $data['tree']=$tree;
    $data['info']=$info;
    $data['analytics']=$analytics;

    $this->load->view('hr/hierarchy',$data);
}
	












}//close class