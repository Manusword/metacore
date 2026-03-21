<?php 

$type_search = $_REQUEST['type_search'];
$year_search = $_REQUEST['year_search'];
$month_search = $_REQUEST['month_search'];

$name = $this->Base->get_details_contractor_with_id($type_search);
if(!empty($name))
{
	$company_full_name = $name[0]['full_name'];
	$company_address= $name[0]['address'];
	$company_gst = $name[0]['gst'];
	$company_pf_code = $name[0]['pf_code'];
	$company_esi_no= $name[0]['esi_no'];
}
else
{
	$company_full_name = "";
	$company_address = "";
	$company_gst = "";
	$company_pf_code = "";
	$company_esi_no = "";
}




?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>Attendance Monthly Report</title>
		<meta name="author" content="Manorajan Sharma,keepcoding.in,manu"/>
		<meta name="changedby" content="Manu"/>
		<link href="<?php echo base_url();?>dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
   
		<style>
			.day{ font-weight:bold;}
			.table-striped tr:hover {
				background:#CFF !important;
			}
		</style>
	</head>

<body style="font-size:12px;" >
<div class="table-responsive">

<?php 
if(!empty($emp))
{
	
	
	//same on employee profile page	
	
	$last_month_from=date("$year_search-$month_search-01");
	$month_name =  date("M", strtotime($last_month_from));
?>
	<div align='center' > 
		<h2 align='center' ><?php echo $company_full_name;?></h2>
		<h4 align='center' ><?php echo $company_address;?></h4>
		<h3 align='center' >
		<?php 
			
			if(!empty($month_search) and !empty($year_search)){
				echo "Attendance Report of (".$this->Base->change_date_into_month_name(date("01-$month_search-$year_search")).')';
				
			}else{
				echo "No month & year Found.";
				exit;
			}
		?>
		</h3>
		<h5 align="left"  style="border-bottom: #000 1px dotted;border-top: #000 1px dotted;"><?php echo "Print Date: ".date("d-m-Y");?></h5>
	</div>
    
    <table width="100%" border="1" class="table-striped " style="font-size:15px;"   >
    	<thead>
        
		<tr style="font-weight:bold;">
			<td align='center' colspan='5'>PF Code:- <?php echo $company_pf_code;?></td>
			<td align='center' colspan='5'>ESIC:- <?php echo $company_esi_no; ?></td>
			<td align='center' colspan='20'>[Form XVII ( See Rule 78(a)(i)] Register of Wage </td>
			<td align='center' colspan='12'></td>
			<td align='center' colspan='12' style="background-color:pink"></td>
		</tr>
		
		<tr style="font-weight:bold;">
			<td align='center' colspan='8'></td>
			<td align='center' colspan='11'>Rate</td>
			<td align='center' colspan='2'>Days & OT</td>
			<td align='center' colspan='12'>Earning</td>
			<td align='center' colspan='9'>Deductions</td>
			<td align='center' colspan='12' style="background-color:pink">Master Roll</td>
		</tr>
		
		<tr>
        	<th >#</th>
			<th  width="70px;">E. Code</th>
        	<th  width="150px;">Name</th>
			<th>Father Name</th>
			<th>PF UAN</th>
			<th>ESIC No</th>
			<th>Designation</th>
			<th>Dept.</th>
			<td align='right' width="70px;">Basic</td>
			<td align='right' width="70px;">HRA</td>
			<td align='right' width="70px;">Conv</td>
			<td align='right' width="70px;">CCA</td>
			<td align='right' width="70px;">Other Allow</td>
			<td align='right' width="70px;">Spl Pay</td>
			<td align='right' width="70px;">Medi Rem</td>
			<td align='right' width="70px;">Arrear</td>
			<td align='right' width="70px;">Ext.Atten.</td>
			<td align='right' width="70px;">Bonus</td>
			<td align='right' width="70px;">Gross Salary</td>
			<td align='right' width="70px;">Paid Days</td>
			<td align='right' width="70px;">OT Hours</td>
			<td align='right' width="70px;">Basic</td>
			<td align='right' width="70px;">HRA</td>
			<td align='right' width="70px;">Conv</td>
			<td align='right' width="70px;">CCA</td>
			<td align='right' width="70px;">Other Allow</td>
			<td align='right' width="70px;">Spl Pay</td>
			<td align='right' width="70px;">Medi Rem</td>
			<td align='right' width="70px;">Arrear</td>
			<td align='right' width="70px;">Ext.Atten.</td>
			<td align='right' width="70px;">Bonus</td>
			<td align='right' width="70px;">OT</td>
			<td align='right' width="70px;">Total Gross</td>
			<td align='right' width="70px;">EPF (12%)</td>
			<td align='right' width="70px;">ESIC (0.75%)</td>
			<td align='right' width="70px;">Canteen</td>
			<td align='right' width="70px;">Snacks</td>
			<td align='right' width="70px;">Conveyance</td>
			<td align='right' width="70px;">Advance</td>
			<td align='right' width="70px;">Total Deduction</td>
			<td align='right' width="70px;">Net Pay</td>
			<td align='right' width="100px;">Mode Of Payment</td>

			<td align='right' width="70px;" style="background-color:pink">Basic Salary (M)</td>
			<td align='right' width="70px;" style="background-color:pink">HRA Salary (M)</td>
			<td align='right' width="70px;" style="background-color:pink">Conv Salary</td>
			<td align='right' width="70px;" style="background-color:pink">Payable Basic</td>
			<td align='right' width="70px;" style="background-color:pink">Payable HRA</td>
			<td align='right' width="70px;" style="background-color:pink">Payable Conv.</td>
			<td align='right' width="70px;" style="background-color:pink">Advance Deduction</td>
			<td align='right' width="70px;" style="background-color:pink">Other Deduction</td>
			<td align='right' width="70px;" style="background-color:pink">EPF</td>
			<td align='right' width="70px;" style="background-color:pink">ESIC</td>
			<td align='right' width="70px;" style="background-color:pink">Total Deduction </td>
			<td align='right' width="70px;" style="background-color:pink">Net Payable (M)</td>
			
		</tr>
        </thead> 
        <tbody>
		<?php 
		$i=1;
		foreach($emp as $e)
		{
			if(!empty($e['id'])){

			$pay_code2=$e['id'];
			$pay_code = $e['pay_code'];
			$query=" 
						SELECT E.father_name,E.epf_code,E.esi_code,E.bank_account_no,D.name as dname, R.name as rname
						FROM employee as E 
						LEFT JOIN department as D ON D.department_id =  E.department_id 
						LEFT JOIN department_role as R ON R.role_id =  E.role_in_department 
						WHERE  E.id='$pay_code2'  
					";
			$out_emp=$this->Mymodel->query1($query);

			$link4 = "?type_search=$type_search&year_search=$year_search&month_search=$month_search&pay_code=$pay_code2&search=Search ";
			
			$out=array();
			$query=" SELECT * FROM daily_attendance_monthly where emp_code='$pay_code2'  and att_year='$year' and att_month='$month' ";
			$out=$this->Mymodel->query1($query);
			$fullname =  $e['first_name'].' '.$e['last_name'];
			?>
            
            <tr style="height:40px">
            	<td  width="10px;"><?php echo $i;?></td>
				<td  width="100px;">
					<a target="_blank" href="<?php echo base_url();?>index.php/Hr/salary_slip_print_1<?php echo $link4;?>" ><?php echo $pay_code;?></a>
				</td>
            	<td  width="250px;">
					 <a  target="_blank"  href="<?php echo base_url().'index.php/Welcome/home?';?>Hr/profile/<?php echo $pay_code;?>"><?php echo $fullname;?></a>	
				</td>
				<td  width="100px;"><?php if(isset($out_emp[0]['father_name']))echo $out_emp[0]['father_name'];?> </td>
				<td  width="100px;"><?php if(isset($out_emp[0]['epf_code']))echo $out_emp[0]['epf_code'];?> </td>
				<td  width="100px;"><?php if(isset($out_emp[0]['esi_code']))echo $out_emp[0]['esi_code'];?> </td>
				<td  width="100px;"><?php if(isset($out_emp[0]['rname']))echo $out_emp[0]['rname'];?> </td>
				<td  width="100px;"><?php if(isset($out_emp[0]['dname']))echo $out_emp[0]['dname'];?> </td>
				<td align='right'><span style="margin-left:5px; font-size:14px;  "><?php if(isset($out[0]['basic_salary'])){ echo $a1[] = $out[0]['basic_salary'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['hra'])){ echo $a2[] = $out[0]['hra'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['conv'])){ echo $a3[] = $out[0]['conv'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['city_comp'])){ echo $a4[] = $out[0]['city_comp'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['other_allow'])){ echo $a5[] = $out[0]['other_allow'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['spl_pay'])){ echo $a6[] = $out[0]['spl_pay'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['medi_rem'])){ echo $a7[] = $out[0]['medi_rem'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['fuel_reimb'])){ echo $a8[] = $out[0]['fuel_reimb'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['get_attendance_all'])){ echo $a9[] = $out[0]['get_attendance_all'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['bonus'])){ echo $a10[] = $out[0]['bonus'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['current_ctc'])){ echo $a11[] = $out[0]['current_ctc'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['total_present'])){ echo $a12[] = $out[0]['total_present'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['total_ot'])){ echo $a13[] = $out[0]['total_ot'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['basic_salary_payable'])){ echo $a14[] = $out[0]['basic_salary_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['hra_payable'])){ echo $a15[] = $out[0]['hra_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['conv_payable'])){ echo $a16[] = $out[0]['conv_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['city_comp_payable'])){ echo $a17[] = $out[0]['city_comp_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['other_allow_payable'])){ echo $a18[] = $out[0]['other_allow_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['spl_pay_payable'])){ echo $a19[] = $out[0]['spl_pay_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['medi_rem_payable'])){ echo $a20[] = $out[0]['medi_rem_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['fuel_reimb_payable'])){ echo $a21[] = $out[0]['fuel_reimb_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['get_attendance_all_payable'])){ echo $a22[] = $out[0]['get_attendance_all_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['bonus_payable'])){ echo $a23[] = $out[0]['bonus_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['total_ot_rs'])){ echo $a24[] = $out[0]['total_ot_rs'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['current_ctc_payable'])){ echo $a25[] = $out[0]['current_ctc_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['epf_payable'])){ echo $a26[] = $out[0]['epf_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['esic_payable'])){ echo $a27[] = $out[0]['esic_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['lost_canteen_payable'])){ echo $a28[] = $out[0]['lost_canteen_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['lost_breakfast_payable'])){ echo $a29[] = $out[0]['lost_breakfast_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['lost_bus_payable'])){ echo $a30[] = $out[0]['lost_bus_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['advance_this_month_payable'])){ echo $a31[] = $out[0]['advance_this_month_payable'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['total_deduction'])){ echo $a33[] = $out[0]['total_deduction'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;"><?php if(isset($out[0]['current_total_ctc_payable'])){ echo $a32[] = $out[0]['current_total_ctc_payable'];}?></span></td>
				<td><?php echo $out_emp[0]['bank_account_no'];?></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['basic_salary_master_roll'])){ echo $a41[] = $out[0]['basic_salary_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['hra_master_roll'])){ echo $a42[] = $out[0]['hra_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['conv_master_roll'])){ echo $a43[] = $out[0]['conv_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['get_basic_salary_master_roll'])){ echo $a44[] = $out[0]['get_basic_salary_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['get_hra_master_roll'])){ echo $a45[] = $out[0]['get_hra_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['get_conv_master_roll'])){ echo $a46[] = $out[0]['get_conv_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['lost_advance_master_roll'])){ echo $a347[] = $out[0]['lost_advance_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['other_advance_master_roll'])){ echo $a48[] = $out[0]['other_advance_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['epf_payable_master_roll'])){ echo $a49[] = $out[0]['epf_payable_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['esic_payable_master_roll'])){ echo $a50[] = $out[0]['esic_payable_master_roll'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['master_roll_total_loss'])){ echo $a51[] = $out[0]['master_roll_total_loss'];}?></span></td>
				<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['master_roll_total_net_pay'])){ echo $a52[] = $out[0]['master_roll_total_net_pay'];}?></span></td>
			</tr>
            <?php
			$i++;
			}//!empty(e['pay_code']);
		}//foreach
		?>

		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a1)){ echo round(array_sum($a1)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a2)){ echo round(array_sum($a2)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a3)){ echo round(array_sum($a3)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a4)){ echo round(array_sum($a4)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a5)){ echo round(array_sum($a5)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a6)){ echo round(array_sum($a6)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a7)){ echo round(array_sum($a7)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a8)){ echo round(array_sum($a8)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a9)){ echo round(array_sum($a9)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a10)){ echo round(array_sum($a10)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a11)){ echo round(array_sum($a11)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a12)){ echo round(array_sum($a12)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a13)){ echo round(array_sum($a13)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a14)){ echo round(array_sum($a14)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a15)){ echo round(array_sum($a15)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a16)){ echo round(array_sum($a16)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a17)){ echo round(array_sum($a17)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a18)){ echo round(array_sum($a18)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a19)){ echo round(array_sum($a19)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a20)){ echo round(array_sum($a20)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a21)){ echo round(array_sum($a21)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a22)){ echo round(array_sum($a22)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a23)){ echo round(array_sum($a23)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a24)){ echo round(array_sum($a24)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a25)){ echo round(array_sum($a25)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a26)){ echo round(array_sum($a26)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a27)){ echo round(array_sum($a27)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a28)){ echo round(array_sum($a28)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a29)){ echo round(array_sum($a29)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a30)){ echo round(array_sum($a30)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a31)){ echo round(array_sum($a31)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a33)){ echo round(array_sum($a33)); }?></span></td>
			<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a32)){ echo round(array_sum($a32)); }?></span></td>
			<td></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a41)){ echo round(array_sum($a41)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a42)){ echo round(array_sum($a42)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a43)){ echo round(array_sum($a43)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a44)){ echo round(array_sum($a44)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a45)){ echo round(array_sum($a45)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a46)){ echo round(array_sum($a46)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a47)){ echo round(array_sum($a47)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a48)){ echo round(array_sum($a48)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a49)){ echo round(array_sum($a49)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a50)){ echo round(array_sum($a50)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a51)){ echo round(array_sum($a51)); }?></span></td>
			<td align='right' style="background-color:pink"><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a52)){ echo round(array_sum($a52)); }?></span></td>
			
		</tr>
	</tbody>
    </table>
   
   <?php 
}
?>

<div style="height:100px; width:100%;"></div>
</div>
</body>

</html>
