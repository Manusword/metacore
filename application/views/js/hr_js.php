<script>
	function get_emp_basic_data(fieldname,code){
		$('.loader').show();	
		setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/get_emp_basic_details_form_emp_code';?>", 
				{
					fieldname:fieldname,
					code:code,
				}, 
				function(data, textStatus)
				{	
					if(data.length>3)
					{
						var id2 = data.split("~");
						$('#emp_name').val(id2[0]);
						$('#emp_dept').val(id2[1]);
						$('#emp_des').val(id2[2]);
						$('#erp_id').val(id2[3]);
						$('#company_role').val(id2[4]);
						$('#working_hrs').val(id2[5]);
						$('#shift_status').val(id2[6]);
						$('#current_shift').val(id2[7]);
						$('#get_overtime').val(id2[8]);

						$('#father_name').val(id2[9]);
						$('#mob').val(id2[10]);
						$('#present_address').val(id2[11]);
						$('#permanent_address').val(id2[12]);
						$('#department_id').val(id2[13]);
						$('#role_id').val(id2[14]);
						$('#bio_id').val(id2[15]);
						$('#emp_id').val(id2[16]);

						$('.loader').hide();
					}
					else
					{
						$('#emp_name').val('');
						$('#emp_dept').val('');
						$('#emp_des').val('');
						$('#erp_id').val('');
						$('#company_role').val('');
						$('#working_hrs').val('');
						$('#shift_status').val('');
						$('#current_shift').val('');
						$('#get_overtime').val('');
						$('#dis_output').html('');

						$('#father_name').val('');
						$('#mob').val('');
						$('#present_address').val('');
						$('#permanent_address').val('');
						$('#department_id').val('');
						$('#role_id').val('');
						// $('#bio_id').val('');
						// $('#emp_id').val('');

						$('.loader').hide();
					}
				});	
			});	
	}


function fun_check_emp_code(str)
{
	//$('#pay_code').val(str);
	jQuery.post("<?php echo base_url().'index.php/Hr/fun_check_emp_code';?>", 
	{
		id:str,
	}, 
	function(data, textStatus)
	{	
		$('#emp_dis').html(data);
	});
}//function close

function fun_check_bio_code(str)
{
	//$('#pay_code').val(str);
	jQuery.post("<?php echo base_url().'index.php/Hr/fun_check_bio_code';?>", 
	{
		id:str,
	}, 
	function(data, textStatus)
	{	
		$('#bio_dis').html(data);
	});
}//function close

function fun_check_email(str)
{
	jQuery.post("<?php echo base_url().'index.php/Hr/fun_check_email';?>", 
	{
		email:str,
	}, 
	function(data, textStatus)
	{	
		$('#email_dis').html(data);
	});
}//function close



$(function () {
	$( "#entry_date" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#search_date1" ).datepicker({dateFormat: 'dd-mm-yy' });
	$( "#search_date2" ).datepicker({ dateFormat: 'dd-mm-yy'});

	$( "#doj" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#dob" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#dor" ).datepicker({ dateFormat: 'dd-mm-yy'});

	$( "#last_promotion_date" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#trainee_probation_date" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#due_conf_date" ).datepicker({ dateFormat: 'dd-mm-yy'});

	$( "#actual_conf_date" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#increment_due_date" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#date_of_transfer" ).datepicker({ dateFormat: 'dd-mm-yy'});

	$( "#date_of_leave" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#fater_dob" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#mother_dob" ).datepicker({ dateFormat: 'dd-mm-yy'});

	$( "#spouse_no" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#date_of_marriage" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#child_dob1" ).datepicker({ dateFormat: 'dd-mm-yy'});

	$( "#child_dob2" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#child_dob3" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#child_dob4" ).datepicker({ dateFormat: 'dd-mm-yy'});

	$( "#doj_master_roll" ).datepicker({ dateFormat: 'dd-mm-yy'});
	$( "#dor_master_roll" ).datepicker({ dateFormat: 'dd-mm-yy'});
});




$(document).ready(function(e) {

	$('#new_emp_save').click(function(){
	 		var url=$('#url').val();
			var id=$('#id').val();
			var company_role=$('#company_role').val();
			var shift_status=$('#shift_status').val();
			var current_shift=$('#current_shift').val();
			var get_overtime=$('#get_overtime').val();
			var emp_code=$('#emp_code').val();
			//var pay_code=$('#pay_code').val();
			var bio_code=$('#bio_code').val();
			var plant=$('#plant').val();
			var first_name=$('#first_name').val();
			var last_name=$('#last_name').val();
			var gender=$('#gender').val();
			var telphone=$('#telphone').val();
			var email=$('#email').val();
			var doj=$('#doj').val();
			var dob=$('#dob').val();
			var dor=$('#dor').val();
			var age=$('#age').val();
			var blood_group=$('#blood_group').val();
			var quli=$('#quli').val();
			var add_quli=$('#add_quli').val();
			var last_org=$('#last_org').val();
			var past_exp=$('#past_exp').val();
			var pres_exp=$('#pres_exp').val();
			var total_exp=$('#total_exp').val();
			var join_desig=$('#join_desig').val();
			var current_desig=$('#current_desig').val();
			var dept=$('#dept').val();
			var sub_dept=$('#sub_dept').val();
			var hod_status=$('#hod_status').val();
			var staff_tech=$('#staff_tech').val();
			var job_respons=$('#job_respons').val();
			var payroll_area=$('#payroll_area').val();
			var join_grade=$('#join_grade').val();
			var current_grade=$('#current_grade').val();
			var last_promotion_date=$('#last_promotion_date').val();
			var ctc_at_join=$('#ctc_at_join').val();
			var current_ctc=$('#current_ctc').val();
			var total_rise_rs=$('#total_rise_rs').val();
			var ctc_on_probation=$('#ctc_on_probation').val();
			var trainee_probn_ctc=$('#trainee_probn_ctc').val();
			var trainee_probation_date=$('#trainee_probation_date').val();
			var due_conf_date=$('#due_conf_date').val();
			var actual_conf_date=$('#actual_conf_date').val();
			var increment_due_date=$('#increment_due_date').val();
			var increment_due_month=$('#increment_due_month').val();
			var date_of_transfer=$('#date_of_transfer').val();
			var plan_name_tranfer=$('#plan_name_tranfer').val();
			var basic_salary=$('#basic_salary').val();
			var hra=$('#hra').val();
			var conv=$('#conv').val();
			var city_comp=$('#city_comp').val();
			var other_allow=$('#other_allow').val();
			var spl_pay=$('#spl_pay').val();
			var medi_rem=$('#medi_rem').val();
			var fuel_reimb=$('#fuel_reimb').val();
			var esic=$('#esic').val();
			var epf=$('#epf').val();
			var bonus=$('#bonus').val();
			var ex_gratia=$('#ex_gratia').val();
			var old_ex_gratia=$('#old_ex_gratia').val();
			var current_total_ctc=$('#current_total_ctc').val();
			var working_hr=$('#working_hr').val();
			var get_attendance_all=$('#get_attendance_all').val();
			var get_el_encashment=$('#get_el_encashment').val();
			var get_cl_encashment=$('#get_cl_encashment').val();
			var get_other1=$('#get_other1').val();
			var get_other2=$('#get_other2').val();
			var get_other3=$('#get_other3').val();
			var get_other4=$('#get_other4').val();
			var lost_canteen=$('#lost_canteen').val();
			var lost_breakfast=$('#lost_breakfast').val();
			var lost_bus=$('#lost_bus').val();
			var lost_advance=$('#lost_advance').val();
			var lost_1=$('#lost_1').val();
			var lost_2=$('#lost_2').val();
			var lost_3=$('#lost_3').val();
			var lost_4=$('#lost_4').val();
			var epf_code=$('#epf_code').val();
			var esi_code=$('#esi_code').val();
			var pan_no=$('#pan_no').val();
			var aadhar_no=$('#aadhar_no').val();
			var voter_id=$('#voter_id').val();
			var bank_name=$('#bank_name').val();
			var bank_account_no=$('#bank_account_no').val();
			var co_mob_no=$('#co_mob_no').val();
			var personal_no2=$('#personal_no2').val();
			var nominee_name=$('#nominee_name').val();
			var nominee_rel=$('#nominee_rel').val();
			var owner_comp_assets=$('#owner_comp_assets').val();
			var conf_undertaking=$('#conf_undertaking').val();
			var warning_letter=$('#warning_letter').val();
			var date_of_leave=$('#date_of_leave').val();
			var reason_leaving1=$('#reason_leaving1').val();
			var reason_leaving2=$('#reason_leaving2').val();
			var present_address=$('#present_address').val();
			var permanent_address=$('#permanent_address').val();
			var home_town_no=$('#home_town_no').val();
			var pin_code_permanet=$('#pin_code_permanet').val();
			var state_par_address=$('#state_par_address').val();
			var father_name=$('#father_name').val();
			var fater_dob=$('#fater_dob').val();
			var mother_name=$('#mother_name').val();
			var mother_dob=$('#mother_dob').val();
			var spouse_name=$('#spouse_name').val();
			var spouse_no=$('#spouse_no').val();
			var date_of_marriage=$('#date_of_marriage').val();
			var child_name1=$('#child_name1').val();
			var child_gender1=$('#child_gender1').val();
			var child_dob1=$('#child_dob1').val();
			var child_name2=$('#child_name2').val();
			var child_gender2=$('#child_gender2').val();
			var child_dob2=$('#child_dob2').val();
			var child_name3=$('#child_name3').val();
			var child_gender3=$('#child_gender3').val();
			var child_dob3=$('#child_dob3').val();
			var child_name4=$('#child_name4').val();
			var child_gender4=$('#child_gender4').val();
			var child_dob4=$('#child_dob4').val();
			var active=$('#active').val();
			var attendance_entry=$('#attendance_entry').val();
			var esic_ded=$('#esic_ded').val();
			var pf_ded=$('#pf_ded').val();
			var basic_salary_master_roll=$('#basic_salary_master_roll').val();
			var hra_master_roll=$('#hra_master_roll').val();
			var conv_master_roll=$('#conv_master_roll').val();
			var lost_advance_master_roll=$('#lost_advance_master_roll').val();
			var other_advance_master_roll=$('#other_advance_master_roll').val();
			var doj_master_roll=$('#doj_master_roll').val();
			var dor_master_roll=$('#dor_master_roll').val();
			var mater_roll=$('#mater_roll').val();
			var emp_uan=$('#emp_uan').val();
			var restday=$('#restday').val();
			let emp_team = $('#emp_team').val();
			let emp_cast_category = $('#emp_cast_category').val();
			let emp_marrige_status = $('#emp_marrige_status').val();
			let status = $('#status').val();
			let login_from_other_ip = $('#login_from_other_ip').val();

			let late_punch_add = $('#late_punch_add').val();
			let on_daily_wages = $('#on_daily_wages').val();
			let daily_wages_rs = $('#daily_wages_rs').val();
			let draft_entry=$('#draft_entry').val();


			

			
			

			let asset_issue = [];

			$('input[name="asset_issue[]"]:checked').each(function () {
				asset_issue.push($(this).val());
			});

			// Comma separated string
			asset_issue = asset_issue.join(',');

			/*
			//-----------------------------------------------------Validation 
			if(company_role==''){$('#company_role').focus();fun_message('warning','Warning','Select From Unit','toast-bottom-right');return false;}
			if(plant==''){$('#plant').focus();fun_message('warning','Warning','Select Working Unit','toast-bottom-right');return false;}
			if(emp_code==''){$('#emp_code').focus();fun_message('warning','Warning','Enter emp_code','toast-bottom-right');return false;}
			//if(pay_code==''){$('#pay_code').focus();fun_message('warning','Warning','Enter pay_code','toast-bottom-right');return false;}
			//if(plant==''){$('#plant').focus();fun_message('warning','Warning','Enter plant','toast-bottom-right');return false;}
			if(first_name==''){$('#first_name').focus();fun_message('warning','Warning','Enter first_name','toast-bottom-right');return false;}
			//if(last_name==''){$('#last_name').focus();fun_message('warning','Warning','Enter last_name','toast-bottom-right');return false;}
			if(gender==''){$('#gender').focus();fun_message('warning','Warning','Select gender','toast-bottom-right');return false;}
			if(telphone==''){$('#telphone').focus();fun_message('warning','Warning','Enter telphone','toast-bottom-right');return false;}
			
			if(join_desig==''){$('#join_desig').focus();fun_message('warning','Warning','Enter join_desig','toast-bottom-right');return false;}
			if(current_desig==''){$('#current_desig').focus();fun_message('warning','Warning','Enter current_desig','toast-bottom-right');return false;}
			if(dept==''){$('#dept').focus();fun_message('warning','Warning','Enter dept','toast-bottom-right');return false;}
			if(emp_team==''){$('#emp_team').focus();fun_message('warning','Warning','Select Team','toast-bottom-right');return false;}
			//if(hod_status==''){$('#hod_status').focus();fun_message('warning','Warning','Enter hod_status','toast-bottom-right');return false;}
			if(staff_tech==''){$('#staff_tech').focus();fun_message('warning','Warning','Enter staff_tech','toast-bottom-right');return false;}
			if(aadhar_no=='' || aadhar_no.length != 12){$('#aadhar_no').focus();fun_message('warning','Warning','Invalid Aadhar','toast-bottom-right');return false;}
			if(emp_cast_category==''){$('#emp_cast_category').focus();fun_message('warning','Warning','Select Cast Category','toast-bottom-right');return false;}
			*/
			
			
			//-------------------------------save 
			$('#wait').show();
			$('#new_emp_save').hide();
			setTimeout(function() {
					  	jQuery.post("<?php echo base_url().'index.php/Hr/new_emp_save';?>", 
							  	{
									id:id,
									status:status,
									login_from_other_ip:login_from_other_ip,
									asset_issue:asset_issue,
									emp_code:emp_code,
									bio_code:bio_code,
									company_role:company_role,
									plant:plant,
									first_name:first_name,
									last_name:last_name,
									gender:gender,
									telphone:telphone,
									email:email,
									doj:doj,
									dob:dob,
									dor:dor,
									age:age,
									blood_group:blood_group,
								  	quli:quli,
									add_quli:add_quli,
									last_org:last_org,
									past_exp:past_exp,
									pres_exp:pres_exp,
									total_exp:total_exp,
									join_desig:join_desig,
									current_desig:current_desig,
									dept:dept,
									sub_dept:sub_dept,
									hod_status:hod_status,
									staff_tech:staff_tech,
									job_respons:job_respons,
									payroll_area:payroll_area,
									join_grade:join_grade,
									current_grade:current_grade,
									last_promotion_date:last_promotion_date,
									ctc_at_join:ctc_at_join,
									current_ctc:current_ctc,
									total_rise_rs:total_rise_rs,
									ctc_on_probation:ctc_on_probation,
									trainee_probn_ctc:trainee_probn_ctc,
									trainee_probation_date:trainee_probation_date,
									due_conf_date:due_conf_date,
									actual_conf_date:actual_conf_date,
									increment_due_date:increment_due_date,
									date_of_transfer:date_of_transfer,
									increment_due_month:increment_due_month,
									plan_name_tranfer:plan_name_tranfer,
									basic_salary:basic_salary,
									hra:hra,
									conv:conv,
									city_comp:city_comp,
									other_allow:other_allow,
									spl_pay:spl_pay,
									medi_rem:medi_rem,
									fuel_reimb:fuel_reimb,
									esic:esic,
									epf:epf,
									bonus:bonus,
									ex_gratia:ex_gratia,
									old_ex_gratia:old_ex_gratia,
									current_total_ctc:current_total_ctc,
									working_hr:working_hr,
									get_attendance_all:get_attendance_all,
									get_el_encashment:get_el_encashment,
									get_cl_encashment:get_cl_encashment,
									get_other1:get_other1,
									get_other2:get_other2,
									get_other3:get_other3,
									get_other4:get_other4,
									lost_canteen:lost_canteen,
									lost_breakfast:lost_breakfast,
									lost_bus:lost_bus,
									lost_advance:lost_advance,
									lost_1:lost_1,
									lost_2:lost_2,
									lost_3:lost_3,
									lost_4:lost_4,
									epf_code:epf_code,
									esi_code:esi_code,
									pan_no:pan_no,
									aadhar_no:aadhar_no,
									voter_id:voter_id,
									bank_name:bank_name,
									bank_account_no:bank_account_no,
									co_mob_no:co_mob_no,
									personal_no2:personal_no2,
									nominee_name:nominee_name,
									nominee_rel:nominee_rel,
									owner_comp_assets:owner_comp_assets,
									conf_undertaking:conf_undertaking,
									warning_letter:warning_letter,
									date_of_leave:date_of_leave,
									reason_leaving1:reason_leaving1,
									reason_leaving2:reason_leaving2,
									present_address:present_address,
									permanent_address:permanent_address,
									home_town_no:home_town_no,
									pin_code_permanet:pin_code_permanet,
									state_par_address:state_par_address,
									father_name:father_name,
									fater_dob:fater_dob,
									mother_name:mother_name,
									mother_dob:mother_dob,
									spouse_name:spouse_name,
									spouse_no:spouse_no,
									date_of_marriage:date_of_marriage,
									child_name1:child_name1,
									child_gender1:child_gender1,
									child_dob1:child_dob1,
									child_name2:child_name2,
									child_gender2:child_gender2,
									child_dob2:child_dob2,
									child_name3:child_name3,
									child_gender3:child_gender3,
									child_dob3:child_dob3,
									child_name4:child_name4,
									child_gender4:child_gender4,
									child_dob4:child_dob4,
								  	company_role:company_role,
									shift_status:shift_status,
									current_shift:current_shift,
									get_overtime:get_overtime,
									active:active,
								  	attendance_entry:attendance_entry,
									draft_entry:draft_entry,
									esic_ded:esic_ded,
									pf_ded:pf_ded,
									basic_salary_master_roll:basic_salary_master_roll,
									hra_master_roll:hra_master_roll,
									conv_master_roll:conv_master_roll,
									lost_advance_master_roll:lost_advance_master_roll,
									other_advance_master_roll:other_advance_master_roll,
									doj_master_roll:doj_master_roll,
									dor_master_roll:dor_master_roll,
									mater_roll:mater_roll,
									emp_uan:emp_uan,
									restday:restday,
									emp_team:emp_team,
									emp_cast_category:emp_cast_category,
									emp_marrige_status:emp_marrige_status,
									late_punch_add:late_punch_add,
									on_daily_wages:on_daily_wages,
									daily_wages_rs:daily_wages_rs,
							}, 
							function(data, textStatus)
							{	
								if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									showPage(url);
								}
								else if(data=='Update')
								{
									fun_message('success',data,'Updated Successfully','toast-bottom-right');
									showPage(url);
								}
								else
								{
									fun_message('error','Error',data,'toast-bottom-right');
								}
								$('#wait').hide();
								$('#new_emp_save').show();
								
								  
							  });
						
							  
				   });
			
		});//-------------------------------save




		
	//-----------------------------------------------search
	$('#emp_search').click(function(){
		
		let name=$('#name1').val();
		//let company_role=$('#company_role1').val();
		let mob=$('#mob1').val();
		let emp_id=$('#emp_id1').val();
		let bio_id=$('#bio_id1').val();
		let dept=$('#dept1').val();
		let hod=$('#hod1').val();
		let staff=$('#staff1').val();
		let active=$('#active1').val();
		let mater_roll=$('#mater_roll').val();
		let current_shift=$('#current_shift').val();
		//let search_plant=$('#search_plant').val();
		
		let doj1=$('#doj1').val();
		let dor1=$('#dor1').val();
		let report_type1=$('#report_type1').val();
		let search1=1;

		// collect checked payroll units
		let company_role = [];
		$('input[name="company_role1[]"]:checked').each(function () {
			company_role.push($(this).val());
		});

		let working_unit = [];
		$('input[name="working_unit[]"]:checked').each(function () {
			working_unit.push($(this).val());
		});

		

		// at least one unit
		if (company_role.length === 0) {
			fun_message('warning','Warning','Please select at least one Payroll Unit','toast-bottom-right');return false;
		}

		if (working_unit.length === 0) {
			fun_message('warning','Warning','Please select at least one Working Unit','toast-bottom-right');return false;
		}

		
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Hr/emp_list';?>", 
				{
					company_role:company_role,
					name:name,
					mob:mob,
					emp_id:emp_id,
					bio_id:bio_id,
					dept:dept,
					hod:hod,
					staff:staff,
					active:active,
					mater_roll:mater_roll,
					current_shift:current_shift,
					search_plant:working_unit,
					doj1:doj1,
					dor1:dor1,
					report_type1:report_type1,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});
		});
	});//search close


	//-----------------------------------------------search
	$('#salary_search').click(function(){
		
		let name=$('#name1').val();
		//var company_role=$('#company_role1').val();
		let mob=$('#mob1').val();
		let emp_id=$('#emp_id1').val();
		let bio_id=$('#bio_id1').val();
		let dept=$('#dept1').val();
		let hod=$('#hod1').val();
		let staff=$('#staff1').val();
		let active=$('#active1').val();
		let mater_roll=$('#mater_roll').val();
		let search_year=$('#search_year').val();
		let search_month=$('#search_month').val();
		let report_type=$('#report_type').val();
		//let search_plant=$('#search_plant').val();

		

		let singleUnitReports = ['9'];   // future me ['9','12','15'] bhi ho sakta hai

		// collect checked payroll units
		let company_role = [];
		$('input[name="company_role1[]"]:checked').each(function () {
			company_role.push($(this).val());
		});

		let working_unit = [];
		$('input[name="working_unit[]"]:checked').each(function () {
			working_unit.push($(this).val());
		});

		

		// at least one unit
		if (company_role.length === 0) {
			fun_message('warning','Warning','Please select at least one Payroll Unit','toast-bottom-right');return false;
		}

		if (working_unit.length === 0) {
			fun_message('warning','Warning','Please select at least one Working Unit','toast-bottom-right');return false;
		}

		// single-unit validation
		if (singleUnitReports.includes(report_type) && company_role.length > 1) {
			fun_message('warning','Warning','Select Only one unit in this report','toast-bottom-right');return false;
		}

		
		
		let search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Hr/salary_reports';?>", 
				{
					company_role:company_role,
					name:name,
					mob:mob,
					emp_id:emp_id,
					bio_id:bio_id,
					dept:dept,
					hod:hod,
					staff:staff,
					active:active,
					mater_roll:mater_roll,
					search_year:search_year,
					search_month:search_month,	
					report_type:report_type,
					search_plant:working_unit,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});
		});
	});//search close
 
	
	
	


	//attendane entry single
	$('#emp_id').keyup(function(){
		$('#dis_output').html('');
		$('#bio_id').val('');
		$('#csv_section').hide();
		var str=$('#emp_id').val();
		str2 = str.toUpperCase();
		$('#emp_id').val(str2);
		if(str2.length > 2)
		{
			//$('.loader').show();	
			get_emp_basic_data('emp_code',str2); //getting data
			//$('.loader').hide();	
		}
	});

	$('#bio_id').keyup(function(){
		$('#dis_output').html('');
		$('#emp_id').val('');
		$('#csv_section').hide();
		var str=$('#bio_id').val();
		str2 = str.toUpperCase();
		$('#bio_id').val(str2);
		if(str2.length > 1)
		{
			//$('.loader').show();	
			get_emp_basic_data('bio_code',str2); //getting data
			//$('.loader').hide();	
		}
	});
	
	//-------------------------------save
	
	//attendane entry single entry form
	$('#get_employee_attendance_date_wise').click(function(){
	 		var emp_id=$('#emp_id').val();
			var month_search=$('#month_search').val();
			var year_search=$('#year_search').val();

			var emp_name = $('#emp_name').val();
			if(emp_name==''){$('#emp_id').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}
			
			$('.loader').show();
			setTimeout(function() {
					jQuery.post("<?php echo base_url().'index.php/Hr/get_employee_attendance_date_wise';?>", 
							{
								emp_id:emp_id,
								month_search:month_search,
								year_search:year_search,
							}, 
							function(data, textStatus)
							{	
								$('#dis_output').html(data);
								$('#csv_section').show();
								$('.loader').hide();
							});
			});
	});

	//attendacne save
	$('#emp_attendance_emp_wise_save').click(function(){
							
		var emp_code=$('#emp_id').val();
		var company_role=$('#company_role').val();
		var month_search=$('#month_search').val();
		var year_search=$('#year_search').val();
		
		var emp_name = $('#emp_name').val();
		if(emp_name==''){$('#emp_id').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}

		var emp_entry_at = "";
		var emp_entry_ot = "";
		var attenid = "";
		var intime = "";
		var outtime = "";
		var shift = "";
		var intimemc = "";
		var outtimemc = "";
		var savefrom = "";
		var mcMin = "";

		$(".emp_entry_at").each(function(){	emp_entry_at=emp_entry_at.concat('~').concat($(this).val());	});
		$(".emp_entry_ot").each(function(){	emp_entry_ot=emp_entry_ot.concat('~').concat($(this).val());	});
		$(".attenid").each(function(){	attenid=attenid.concat('~').concat($(this).val());	});
		$(".intime").each(function(){	intime=intime.concat('~').concat($(this).val());	});
		$(".outtime").each(function(){	outtime=outtime.concat('~').concat($(this).val());	});
		$(".shift").each(function(){	shift=shift.concat('~').concat($(this).val());	});
		$(".intimemc").each(function(){	intimemc=intimemc.concat('~').concat($(this).val());	});
		$(".outtimemc").each(function(){	outtimemc=outtimemc.concat('~').concat($(this).val());	});
		$(".savefrom").each(function(){	savefrom=savefrom.concat('~').concat($(this).val());	});
		$(".mcMin").each(function(){	mcMin=mcMin.concat('~').concat($(this).val());	});
		if(emp_entry_at==''){$('#emp_entry_at').focus();fun_message('warning','Warning','Enter Attendance','toast-bottom-right');return false;}


		var txt= 0;
		//-------------check data is going to save valid or not
		jQuery.post("<?php echo base_url().'index.php/Hr/check_attendance_entry_manual_save_employee_wise';?>", 
		{
			emp_code:emp_code,
			company_role:company_role,
			month_search:month_search,
			year_search:year_search,
		}, 
		function(data, textStatus)
		{	
			//if(confirm(data))
			//{
						$('.loader').show();	
						setTimeout(function() {
						jQuery.post("<?php echo base_url().'index.php/Hr/attendance_entry_manual_save_employee_wise';?>", 
									{
										emp_code:emp_code,
										company_role:company_role,
										month_search:month_search,
										year_search:year_search,
										emp_entry_at:emp_entry_at,
										emp_entry_ot:emp_entry_ot,
										attenid:attenid,
										intime:intime,
										outtime:outtime,
										shift:shift,
										intimemc:intimemc,
										outtimemc:outtimemc,
										savefrom:savefrom,
										mcMin:mcMin,
									}, 
									function(data, textStatus)
									{	
										if(data=='Save')
										{
											fun_message('success',data,'Save Successfully','toast-bottom-right');
											//showPage(url);
										}
										else if(data=='Update')
										{
											fun_message('success',data,'Updated Successfully','toast-bottom-right');
											showPage(url);
										}
										else
										{
											fun_message('error','Error',data,'toast-bottom-right');
										}
										$('.loader').hide();
									});
						});
				//} //confirm
		});
		
	});//function close



	$('#att_punch_search').click(function(){
		var search_date1=$('#search_date1').val();
		var search_date2=$('#search_date2').val();
		var shift=$('#shift').val();
		var dept=$('#dept').val();
		var emp_code=$('#emp_code').val();
		var search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Hr/punch_reports';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				shift:shift,
				dept:dept,
				emp_code:emp_code,
				search1:search1,
			}, 
			function(data, textStatus)
			{	
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});
	});//search close


	$('#att_punch_search2').click(function(){
		let search_date1=$('#search_date1').val();
		let search_date2=$('#search_date2').val();
		let shift=$('#shift').val();
		let dept=$('#dept').val();
		let emp_code=$('#emp_code').val();
		
		let company_role1=$('#company_role1').val();
		let search_plant=$('#search_plant').val();
		let bio_id1=$('#bio_id1').val();
		let name1=$('#name1').val();
		let search1=1;
		//-------------------------------getting gst type
		$('.loader').show();
		setTimeout(function() {
			jQuery.post("<?php echo base_url().'index.php/Hr/punch_reports2';?>", 
			{
				search_date1:search_date1,
				search_date2:search_date2,
				shift:shift,
				dept:dept,
				emp_code:emp_code,

				company_role1:company_role1,
				search_plant:search_plant,
				bio_id1:bio_id1,
				name1:name1,

				search1:search1,
			}, 
			function(data, textStatus)
			{	
				$('#table_show').html(data);
				$('.loader').hide();
			});
		});
	});//search close
	












		//-----------------------------------------------search 2
		$('#list2_search').click(function(){
		
			var search_date1=$('#search_date1').val();
			var search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list2';?>", 
				{
					search_date1:search_date1,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close



		//-----------------------------------------------search 2
		$('#list3_search').click(function(){
		
			var search_date1=$('#search_date1').val();
			var show_array=$('#show_array').val();
			var show_pic=$('#show_pic').val();
			var search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list3';?>", 
				{
					search_date1:search_date1,
					show_array:show_array,
					show_pic:show_pic,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close


		//-----------------------------------------------search 2
		$('#dept_transfer_search').click(function(){
			var shift=$('#shift').val();
			if(shift==''){$('#shift').focus();fun_message('warning','Warning','Select Shift','toast-bottom-right');return false;}
			var search_date1=$('#search_date1').val();
			var search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/dept_transfer';?>", 
				{
					search_date1:search_date1,
					shift:shift,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close


		


		//--------------------------------------------------------------------Leave
		$('#emp_leave_save').click(function(){
								
			let url=$('#url').val();
			let id=$('#id').val();
			
			let emp_code=$('#emp_code').val();if(emp_code==''){$('#emp_code').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}
			let emp_name = $('#emp_name').val();
			if(emp_name==''){$('#emp_code').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}
			
			let ask_from_date=$('#ask_from_date').val();if(ask_from_date==''){$('#ask_from_date').focus();fun_message('warning','Warning','Enter From Date','toast-bottom-right');return false;}
			let ask_to_date=$('#ask_to_date').val();if(ask_to_date==''){$('#ask_to_date').focus();fun_message('warning','Warning','Enter To Date','toast-bottom-right');return false;}
			let ask_total_days=$('#ask_total_days').val();if(ask_total_days==''){$('#ask_to_date').focus();fun_message('warning','Warning','Re-select Both Dates','toast-bottom-right');return false;}

			let father_name=$('#father_name').val();
			let mob=$('#mob').val();
			let department_id=$('#department_id').val();
			let role_id=$('#role_id').val();
			let present_address=$('#present_address').val();
			let permanent_address=$('#permanent_address').val();
			
			let reason_for=$('#reason_for').val();if(reason_for==''){$('#reason_for').focus();fun_message('warning','Warning','Enter Reason','toast-bottom-right');return false;}
			let reason=$('#reason').val();
			
			

			
			let approve_from_date=$('#approve_from_date').val();
			let approve_to_date=$('#approve_to_date').val();
			let approve_total_days=$('#approve_total_days').val();

			let sign_supervisor=$('#sign_supervisor').val();
			let sup_name=$('#sup_name').val();
			let status=$('#status').val();
			
			if(status == "Approve"){
				if(approve_from_date==''){$('#approve_from_date').focus();fun_message('warning','Warning','Enter Approve From Date','toast-bottom-right');return false;}
				if(approve_to_date==''){$('#approve_to_date').focus();fun_message('warning','Warning','Enter Approve To Date','toast-bottom-right');return false;}
			}

			
			
			//-------------check data is going to save valid or not
			$('#emp_leave_save').hide();
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/emp_leave_save';?>", 
							{
								id:id,
								emp_code:emp_code,
								emp_name:emp_name,
								father_name:father_name,
								mob:mob,
								department_id:department_id,
								role_id:role_id,
								present_address:present_address,
								permanent_address:permanent_address,
								reason_for:reason_for,
								reason:reason,
								
								ask_from_date:ask_from_date,
								ask_to_date:ask_to_date,
								ask_total_days:ask_total_days,
								approve_from_date:approve_from_date,
								approve_to_date:approve_to_date,
								approve_total_days:approve_total_days,

								sign_supervisor:sign_supervisor,
								sup_name:sup_name,
								status:status,
							}, 
							function(data, textStatus)
							{	
								if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									showPage(url);
								}
								else if(data=='Update')
								{
									fun_message('success',data,'Updated Successfully','toast-bottom-right');
									showPage(url);
								}
								else
								{
									fun_message('error','Error',data,'toast-bottom-right');
								}
								$('#emp_leave_save').show();
								$('.loader').hide();
							});
				});
			
			
		});//function close




		
		//-----------------------------------------------Leave search
		$('#leave_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			let emp_code=$('#emp_code').val();
			let dept=$('#dept').val();
			let status=$('#status').val();
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list_leave';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					emp_code:emp_code,
					dept:dept,
					status:status,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close





		//--------------------------------------------------------------------Advance
		$('#emp_advance_save').click(function(){
								
			let url=$('#url').val();
			let id=$('#id').val();
			
			let emp_code=$('#emp_code').val();if(emp_code==''){$('#emp_code').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}
			let emp_name = $('#emp_name').val();
			if(emp_name==''){$('#emp_code').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}

			let father_name=$('#father_name').val();
			let mob=$('#mob').val();
			let department_id=$('#department_id').val();
			let role_id=$('#role_id').val();
			let present_address=$('#present_address').val();
			let permanent_address=$('#permanent_address').val();
				
			let ask_date=$('#ask_date').val();if(ask_date==''){$('#ask_date').focus();fun_message('warning','Warning','Date','toast-bottom-right');return false;}
			let ask_amount=$('#ask_amount').val();if(ask_amount==''){$('#ask_amount').focus();fun_message('warning','Warning','Date','toast-bottom-right');return false;}
			let reason_for=$('#reason_for').val();if(reason_for==''){$('#reason_for').focus();fun_message('warning','Warning','Enter Reason','toast-bottom-right');return false;}
			let approve_amount=$('#approve_amount').val();
			let status=$('#status').val();
			let payment_type=$('#payment_type').val();
			let remarks=$('#remarks').val();
			if(status == "Approve"){
				if(approve_amount==''){$('#approve_amount').focus();fun_message('warning','Warning','Enter Approve Amount','toast-bottom-right');return false;}
				if(payment_type==''){$('#payment_type').focus();fun_message('warning','Warning','Select Payment type','toast-bottom-right');return false;}
			}

			if(approve_amount != ''){
				if(status != "Approve"){$('#status').focus();fun_message('warning','Warning','Status not valid','toast-bottom-right');return false;}
				if(payment_type==''){$('#payment_type').focus();fun_message('warning','Warning','Select Payment type','toast-bottom-right');return false;}
			}

			//-------------check data is going to save valid or not
			$('#emp_advance_save').hide();
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/emp_advance_save';?>", 
							{
								id:id,
								emp_code:emp_code,
								emp_name:emp_name,
								father_name:father_name,
								mob:mob,
								department_id:department_id,
								role_id:role_id,
								present_address:present_address,
								permanent_address:permanent_address,
								
								ask_date:ask_date,
								ask_amount:ask_amount,
								reason_for:reason_for,
								approve_amount:approve_amount,
								status:status,
								remarks:remarks,
								payment_type:payment_type,
							}, 
							function(data, textStatus)
							{	
								if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									showPage(url);
								}
								else if(data=='Update')
								{
									fun_message('success',data,'Updated Successfully','toast-bottom-right');
									showPage(url);
								}
								else
								{
									fun_message('error','Error',data,'toast-bottom-right');
								}
								$('#emp_advance_save').show();
								$('.loader').hide();
							});
				});
			
			
		});//function close


		//-----------------------------------------------Advance search
		$('#advance_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			let emp_code=$('#emp_code').val();
			let dept=$('#dept').val();
			let status=$('#status').val();
			let payment_type=$('#payment_type').val();
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list_advance';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					emp_code:emp_code,
					dept:dept,
					status:status,
					payment_type:payment_type,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close

		$('#loan_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			let emp_code=$('#emp_code').val();
			let dept=$('#dept').val();
			let status=$('#status').val();
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list_emp_loan';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					emp_code:emp_code,
					dept:dept,
					status:status,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close


		//-----------------------------------------------Advance search
		$('#other_appli_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			let emp_code=$('#emp_code').val();
			let dept=$('#dept').val();
			let search_type=$('#search_type').val();
			
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list_other_application';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					emp_code:emp_code,
					dept:dept,
					search_type:search_type,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close


		$('#emp_tds_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			let emp_code=$('#emp_code').val();
			let dept=$('#dept').val();
			let search_type=$('#search_type').val();
			
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/tds_list';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					emp_code:emp_code,
					dept:dept,
					search_type:search_type,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close

		$('#emp_reim_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			let emp_code=$('#emp_code').val();
			let dept=$('#dept').val();
			let search_type=$('#search_type').val();
			
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/reim_list';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					emp_code:emp_code,
					dept:dept,
					search_type:search_type,
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close



		//--------------------------------------------------------------------Canteen Coupon
		$('#emp_coupon_issue_save').click(function(){
								
			let url=$('#url').val();
			let id=$('#id').val();
			
			let issue_date=$('#issue_date').val();if(issue_date==''){$('#issue_date').focus();fun_message('warning','Warning','Enter From Date','toast-bottom-right');return false;}
			let type=$('#type').val();
			let emp_code=$('#emp_code').val();
			let emp_name = $('#emp_name').val();
			let fullCharge = $('#fullCharge').val();

			let dinner_coupon_no=$('#dinner_coupon_no').val();
			let lunch_coupon_no=$('#lunch_coupon_no').val();
			let breakfast_coupon_no=$('#breakfast_coupon_no').val();
			let total_coupon_amt=$('#total_coupon_amt').val();

			let other_name=$('#other_name').val();
			let other_dept=$('#other_dept').val();
			let other_ref=$('#other_ref').val();
			let remarks=$('#remarks').val();
			
			if(type == "Yes"){
				if(emp_code==''){$('#emp_code').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}
				if(emp_name==''){$('#emp_code').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}
			}else{
				//if no 
				if(other_name==''){$('#other_name').focus();fun_message('warning','Warning','Enter other person name','toast-bottom-right');return false;}
				if(other_ref==''){$('#other_ref').focus();fun_message('warning','Warning','Enter other person ref.','toast-bottom-right');return false;}
			}

			/*
			if(total_coupon_amt > 0){
				//alert("ok");
			}else{
				fun_message('warning','Warning','Amount not valid, please check coupon no entry','toast-bottom-right');
				return false;
			}
			*/

			
			
			//-------------check data is going to save valid or not
			$('#emp_coupon_issue_save').hide();
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/emp_coupon_issue_save';?>", 
							{
								id:id,
								type:type,
								emp_code:emp_code,
								emp_name:emp_name,
								fullCharge:fullCharge,
								issue_date:issue_date,
								dinner_coupon_no:dinner_coupon_no,
								lunch_coupon_no:lunch_coupon_no,
								breakfast_coupon_no:breakfast_coupon_no,

								other_name:other_name,
								other_dept:other_dept,
								other_ref:other_ref,
								remarks:remarks,
							}, 
							function(data, textStatus)
							{	
								if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									//showPage(url);
									$('#id').val('');
			
									$('#type').val('Yes');
									$('#emp_code').val('');
									$('#emp_name').val('');

									$('#lunch_coupon_no').val('');
									$('#breakfast_coupon_no').val('');
									$('#total_coupon_amt').val('');

									$('#lunch_coupon_amt').val('')
									$('#breakfast_coupon_amt').val('')
									$('#total_coupon_amt').val('')
									$('#total_issue_coupon').val('')

									$('#dinner_coupon_no').val('')
									$('#dinner_coupon_amt').val('')

									$('#other_name').val('');
									$('#other_dept').val('');
									$('#other_ref').val('');
									$('#remarks').val('');
								}
								else if(data=='Update')
								{
									fun_message('success',data,'Updated Successfully','toast-bottom-right');
									showPage(url);
								}
								else
								{
									fun_message('error','Error',data,'toast-bottom-right');
								}
								
								$('#emp_coupon_issue_save').show();
								$('.loader').hide();
							});
				});
			
			
		});//function close



		
		
		//-----------------------------------------------Leave search
		$('#coupon_issue_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			let emp_code=$('#emp_code').val();
			let type=$('#type').val();
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list_coupon_issue';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					emp_code:emp_code,
					type:type,
					
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close


		//-----------------------------------------------Leave search
		$('#coupon_issue_group_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list_coupon_issue_group_by_name';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close


		//-----------------------------------------------Leave search
		$('#coupon_issue_date_group_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list_coupon_issue_group_by_date';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close



		//--------------------------------------------------------------------Canteen Coupon Receive
		$('#emp_coupon_receive_save').click(function(){
								
			let url=$('#url').val();
			let id=$('#id').val();
			
			let receive_date=$('#receive_date').val();if(receive_date==''){$('#receive_date').focus();fun_message('warning','Warning','Enter From Date','toast-bottom-right');return false;}
			
			let dinner_coupon_no=$('#dinner_coupon_no').val();
			let lunch_coupon_no=$('#lunch_coupon_no').val();
			let breakfast_coupon_no=$('#breakfast_coupon_no').val();
			let total_coupon_amt=$('#total_coupon_amt').val();
			let remarks=$('#remarks').val();

			if(total_coupon_amt > 0){
				//alert("ok");
			}else{
				fun_message('warning','Warning','Amount not valid, please check coupon no entry','toast-bottom-right');
				return false;
			}

			
			
			//-------------check data is going to save valid or not
			$('#emp_coupon_receive_save').hide();
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/emp_coupon_receive_save';?>", 
							{
								id:id,
								
								receive_date:receive_date,
								dinner_coupon_no:dinner_coupon_no,
								lunch_coupon_no:lunch_coupon_no,
								breakfast_coupon_no:breakfast_coupon_no,
								remarks:remarks,
							}, 
							function(data, textStatus)
							{	
								if(data=='Save')
								{
									fun_message('success',data,'Save Successfully','toast-bottom-right');
									showPage(url);
								}
								else if(data=='Update')
								{
									fun_message('success',data,'Updated Successfully','toast-bottom-right');
									showPage(url);
								}
								else
								{
									fun_message('error','Error',data,'toast-bottom-right');
								}
								
								$('#emp_coupon_receive_save').show();
								$('.loader').hide();
							});
				});
			
			
		});//function close


		//---------------------------------------------
		$('#coupon_receive_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list_coupon_receive';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close

		//---------------------------------------------
		$('#coupon_receive_date_group_search').click(function(){
			
			let search_date1=$('#search_date1').val();
			let search_date2=$('#search_date2').val();
			
			let search1='1';
			//-------------------------------getting gst type
			$('.loader').show();
			setTimeout(function() {
				jQuery.post("<?php echo base_url().'index.php/Hr/list_coupon_receive_group_by_date';?>", 
				{
					search_date1:search_date1,
					search_date2:search_date2,
					
					search1:search1,
				}, 
				function(data, textStatus)
				{	
					//alert(data);
					$('#table_show').html(data);
					$('.loader').hide();
				});//jquery
			});//loader
		});//search close



		let url=$('#url').val();
			




		//Other application Save
		$('#other_save').click(function () {
			let url = $('#url').val(); 
			let id=$('#id').val();
			
			let emp_code=$('#emp_code').val();if(emp_code==''){$('#emp_code').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}
			let emp_name = $('#emp_name').val();
			if(emp_name==''){$('#emp_code').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}

			let father_name=$('#father_name').val();
			let mob=$('#mob').val();
			let department_id=$('#department_id').val();
			let role_id=$('#role_id').val();
			let present_address=$('#present_address').val();
			let permanent_address=$('#permanent_address').val();
			let type=$('#type').val();
			let status=$('#status').val();
			
			
			let formData = {
				
				id:id,
				status:status,
				emp_code:emp_code,
				emp_name:emp_name,
				father_name:father_name,
				mob:mob,
				department_id:department_id,
				role_id:role_id,
				present_address:present_address,
				permanent_address:permanent_address,
				
				type: type,
				entry_date: $('#entry_date1').val(),
				description: $('#description').val(),
				subject: $('#subject').val(),
				action: $('#action').val(),
				amount: $('#amount').val(),

				// Gatepass specific
				work_type: $('#work_type').val(),
				vehical_name: $('#vehical_name').val(),
				km_start: $('#km_start').val(),
				km_end: $('#km_end').val(),
				time_out: $('#time_out').val(),
				duty_off: $('#duty_off').val(),
				time_in: $('#time_in').val(),
				sup_id: $('#sup_id').val(),

				// Accident specific
				entry_time: $('#entry_time').val(),
				location: $('#location').val(),
				accident_type: $('#accident_type').val(),
				accident_nature: $('#accident_nature').val(),
				accident_action: $('#accident_action').val(),
				accident_root: $('#accident_root').val(),
				accident_factors: $('#accident_factors').val(),
				remarks: $('#remarks').val(),
				search1: '1',
			};

			$('#wait').show();
			$('#other_save').hide();

			$.post("<?php echo base_url().'index.php/hr/emp_other_application_save';?>", formData, function (data) {
				if (data == 'Save') {
					fun_message('success', data, 'Save Successfully', 'toast-bottom-right');
					// all form reset here 
					// Reset all form fields
					$('#other_application_form')[0].reset(); // Make sure your form has id="other_application_form"
					$('#id').val('');
					$('#url').val(url); // if needed again for further use
					$('#type').val(type);
				} else if (data == 'Update') {
					fun_message('success', data, 'Updated Successfully', 'toast-bottom-right');
					showPage(url);
				} else {
					fun_message('error', 'Error', data, 'toast-bottom-right');
				}
				$('#wait').hide();
				$('#other_save').show();
			});
		});











});<!---------document--->



	//attendance entry single
	function checkvalidation(id)
	{
		var id2 = "#".concat(id);
		var val = $(id2).val();
		var val2 = val.toUpperCase();
		$(id2).val(val2);
		
		if(val2 == 'P' || val2 == 'R' || val2 == 'L' || val2 == 'A' || val2 == 'H' || val2 == 'HA'|| val2 == 'HL' || val2 == 'S' || val2 == 'SL' || val2 == 'CL' || val2 == 'EL' || val2 == 'OL' || val2 == 'C' || val2 == 'E' || val2 == 'O' || val2 == 'T')
		{
			if(val2=='P')
			{
				$(id2).css("background-color", "green");
				$(id2).css("color", "white");
			}
			else if(val2=='HA')
			{
				$(id2).css("background-color", "orange");
				$(id2).css("color", "white");
			}
			else if(val2=='HL')
			{
				$(id2).css("background-color", "pink");
				$(id2).css("color", "white");
			}
			else if(val2=='A' || val2=='L')
			{
				$(id2).css("background-color", "red");
				$(id2).css("color", "white");
			}
			else if(val2=='H')
			{
				$(id2).css("background-color", "yellow");
				$(id2).css("color", "Black");
			}
			else if(val2=='S')
			{
				$(id2).css("background-color", "blue");
				$(id2).css("color", "white");
			}
			else if(val2 == 'R' || val2 == 'SL' || val2 == 'CL' || val2 == 'EL' || val2 == 'OL' || val2 == 'T')
			{
				$(id2).css("background-color", "purple");
				$(id2).css("color", "white");
			}
			else
			{
				$(id2).css("background-color", "white");
				$(id2).css("color", "black");
			}//if(this.value=='P')
		}
		else
		{
			$(id2).val('');
			//alert('Please Enter Only these letters :  P, A, H, S');
			return false;
		}//if(val2 == 'P' || val2 == 'A' || val2 == 'H' || val2 == 'S')
		
	}//function checkvalidation(id)
	


	//attendance entry single
	function checkvalidation2(id)
	{
		var id2 = "#".concat(id);
		var val = $(id2).val();
		var val2 = val.toUpperCase();
		$(id2).val(val2);
		
		if(val2 >= 1 && val2<=100)
		{
			$(id2).css("background-color", "green");
			$(id2).css("color", "white");
			
		}
		else
		{
			$(id2).css("background-color", "red");
			$(id2).css("color", "white");
			//$(id2).val('');
			//alert('Please Enter Only these letters :  P, A, H, S');
			return false;
		}//if(val2 == 'P' || val2 == 'A' || val2 == 'H' || val2 == 'S')
		
	}//function checkvalidation(id)



	//attendance entry single
	function checkvalidation4(id)
	{
		var id2 = "#".concat(id);
		var val = $(id2).val();
		var val2 = val.toUpperCase();
		$(id2).val(val2);
		
		// if(val2 == 'G' || val2 == 'A' || val2 == 'B'|| val2 == 'C')
		// {
			if(val2 == 'G' || val2 == 'A' || val2 == 'B' || val2 == 'C')
			{
				$(id2).css("background-color", "green");
				$(id2).css("color", "white");
			}
			else
			{
				$(id2).css("background-color", "white");
				$(id2).css("color", "black");
			}//if(this.value=='P')
		// }
		// else
		// {
		// 	$(id2).val('');
		// 	//alert('Please Enter Only these letters :  P, A, H, S');
		// 	return false;
		// }//if(val2 == 'P' || val2 == 'A' || val2 == 'H' || val2 == 'S')
		
	}//function checkvalidation(id)








	









	//-----------All reports search
	function reports_search()
	{
		var type_search=$('#type_search').val();
		var year_search=$('#year_search').val();
		var month_search=$('#month_search').val();
		jQuery.post("<?php echo base_url().'index.php/Hr/fun_hr_reports_reports_search';?>", 
		{
			type_search:type_search,
			year_search:year_search,
			month_search:month_search,
		}, 
		function(data, textStatus)
		{	
			$('#result_reports_search').html(data);
		});
	}//function close





</script>

   
 
       
 