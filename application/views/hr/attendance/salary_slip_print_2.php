<?php 
    if(isset($_REQUEST['type_search'])){$type_search=$_REQUEST['type_search'];}else{$type_search='';}
    if(isset($_REQUEST['year_search'])){$year_search=$_REQUEST['year_search'];}else{$year_search='';}
    if(isset($_REQUEST['month_search'])){$month_search=$_REQUEST['month_search'];}else{$month_search='';}
    if(isset($_REQUEST['pay_code'])){$pay_code=$_REQUEST['pay_code'];}else{$pay_code='';}

    $month_search = date("F", mktime(0, 0, 0, $month_search, 10));

    if(!empty($emp[0]['doj']) and $emp[0]['doj']!='0000-00-00')
    {
        $test = new DateTime($emp[0]['doj']);
        $doj = date_format($test, 'd-M-y');
    }
    else
    {
        $doj = '';
    }


    if(isset($res2[0]['esic_payable'])){ $a = round($res2[0]['esic_payable'],2);}else{ $a = 0; }
    if(isset($res2[0]['epf_payable'])){ $b = round($res2[0]['epf_payable'],2);}else{ $b = 0; }
    if(isset($res2[0]['lost_canteen_payable'])){ $c = round($res2[0]['lost_canteen_payable'],2);}else{ $c = 0; }
    if(isset($res2[0]['lost_breakfast_payable'])){  $d = round($res2[0]['lost_breakfast_payable'],2);}else{ $d = 0; }
    if(isset($res2[0]['lost_bus_payable'])){ $e = round($res2[0]['lost_bus_payable'],2);}else{ $e = 0; }
    $deduction_amt = $a+$b+$c+$d+$e;


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title><?php echo $emp[0]['first_name'].' '.$emp[0]['last_name'];?> Slip</title>
	<meta name="author" content="Manu Sharma,keepcoding.in"/>
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Calibri"; font-size:12px; }
		@media print {
			a {text-decoration: none; color:#000}
			#attendanceModal{
				display: none;
			}
			body, html {
				margin: 0;
				padding: 0;
				color: #000 !important;
				background: #fff !important;
				font-size: 10px;
			}
			table{
				width: 99%;
			}

			.no-print, .sidebar, .navbar, .footer {
				display: none !important;
			}

			
			a::after {
				content: "" !important;
			}
		}
		</style>
	
</head>

<body>
<table cellspacing="0" border="0">
	
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="28" align="center" valign=bottom><font size=4 color="#000000"><?php echo $comp[0]['details1'];?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="21" align="center" valign=bottom><font color="#000000"><?php echo $address[0]['details2'];?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=13 height="21" align="center" valign=bottom><font color="#000000">Salary Slip For The Month Of : <?php echo $month_search.'/'.$year_search; ?></font></td>
	</tr>
	
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000">Paycode:</font></td>
		<td align="left" valign=bottom><font color="#000000"><?php if(isset($emp[0]['emp_code']))echo $emp[0]['emp_code'];?></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">Name :</font></td>
		<td align="left" valign=bottom><font color="#000000"><?php echo $emp[0]['first_name'].' '.$emp[0]['last_name'];?></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">Doj: <?php echo $doj;?></font></td>
		<td style="border-right: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000">F/H Name:</font></td>
		<td align="left" valign=bottom><font color="#000000"><?php if(isset($emp[0]['father_name']))echo $emp[0]['father_name'];?></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">Dept :</font></td>
		<td align="left" valign=bottom><font color="#000000"><?php if(isset($emp[0]['main_dept_name']))echo $emp[0]['main_dept_name'];?></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">Print Date :</font></td>
		<td style="border-right: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000">UAN No.:</font></td>
		<td align="left" valign=bottom sdval="0" sdnum="1033;"><font color="#000000"><?php if(isset($emp[0]['emp_uan']))echo $emp[0]['emp_uan'];?></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">Desig:</font></td>
		<td align="left" valign=bottom><font color="#000000"><?php if(isset($emp[0]['join_role_name']))echo $emp[0]['join_role_name'];?></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"><?php echo date('d-M-Y');?></font></td>
		<td style="border-right: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000">DOJ :</font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"><?php echo $doj;?></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
	</tr>
	
    
    
    <tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 height="43" align="center" valign=bottom><font color="#000000"></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b><font color="#000000">Rate</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b><font color="#000000">Days </font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b><font color="#000000">Earnings</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b><font color="#000000">Deductions</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=bottom><font color="#000000"></font></td>
	</tr>
	<tr>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000">PF No. :</font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-top: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"><?php if(isset($emp[0]['epf_code']))echo $emp[0]['epf_code'];?></font></td>
		<td align="left" valign=bottom><font color="#000000">Basic</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="20000" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['basic_salary']))echo round($res2[0]['basic_salary'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Days Worked</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="27" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['total_p']))echo round($res2[0]['total_p']);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Basic</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="20000" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['basic_salary_payable']))echo round($res2[0]['basic_salary_payable'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">ESI</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['esic_payable']))echo round($res2[0]['esic_payable'],2);?></font></td>
		<td align="left" valign=bottom><font color="#000000">Total Payable </font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="36500" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['current_ctc']))echo round($res2[0]['current_ctc'],2);?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000">ESI No. :</font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"><?php if(isset($emp[0]['esi_code']))echo $emp[0]['esi_code'];?></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">OT Hours.</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="4" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['total_ot']))echo round($res2[0]['total_ot'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">PF</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['epf_payable']))echo round($res2[0]['epf_payable'],2);?></font></td>
		<td align="left" valign=bottom><font color="#000000">Deductions </font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php echo $deduction_amt;?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000">Pan No. :</font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"><?php if(isset($emp[0]['pan_no']))echo $emp[0]['pan_no'];?></font></td>
		<td align="left" valign=bottom><font color="#000000">HRA</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="6600" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['hra']))echo round($res2[0]['hra'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">CL Leave</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php  if(isset($res2[0]['total_cl']))echo round($res2[0]['total_cl'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">HRA</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="6600" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['hra_payable']))echo round($res2[0]['hra_payable'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">VPF</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000">0</font></td>
		<td align="left" valign=bottom><font color="#000000">Advance</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['advance_this_month_payable']))echo round($res2[0]['advance_this_month_payable']);?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000">Bank A/c :</font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"><?php if(isset($emp[0]['bank_account_no']))echo $emp[0]['bank_account_no'];?></font></td>
		<td align="left" valign=bottom><font color="#000000">Conv.</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="4950" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['conv']))echo round($res2[0]['conv'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">EL Leave</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['total_el']))echo round($res2[0]['total_el'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Conv.</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="4950" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['conv_payable']))echo round($res2[0]['conv_payable'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Emp Wel</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000">0</font></td>
		<td align="left" valign=bottom><font color="#000000">Loan</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">MEDI</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['medi_rem']))echo round($res2[0]['medi_rem'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">SL Leave</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['total_sl']))echo round($res2[0]['total_sl'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">MEDI</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['medi_rem_payable']))echo round($res2[0]['medi_rem_payable'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Canteen</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['lost_canteen_payable']))echo round($res2[0]['lost_canteen_payable'],2);?></font></td>
		<td align="left" valign=bottom><font color="#000000">Fine </font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['lost_1_payable']))echo round($res2[0]['lost_1_payable']);?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000">Bank Name :</font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"><?php if(isset($emp[0]['bank_name']))echo $emp[0]['bank_name'];?></font></td>
		<td align="left" valign=bottom><font color="#000000">CCA</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="3300" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['city_comp']))echo round($res2[0]['city_comp'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Other Leave</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['total_ol']))echo round($res2[0]['total_ol'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">CCA</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="3300" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['city_comp_payable']))echo round($res2[0]['city_comp_payable'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">BreakFast</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="2" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['lost_breakfast_payable']))echo round($res2[0]['lost_breakfast_payable'],2);?></font></td>
		<td align="left" valign=bottom><font color="#000000">Total Deductions</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="2" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['total_deduction']))echo round($res2[0]['total_deduction']);?></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000"></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">Fuel</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1650" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['fuel_reimb']))echo round($res2[0]['fuel_reimb'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Fuel</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1650" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['fuel_reimb_payable']))echo round($res2[0]['fuel_reimb_payable'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Transport</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="3" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['lost_bus_payable']))echo round($res2[0]['lost_bus_payable'],2);?></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="3" sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>

    <tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><!--Leave Bal. As On 31-Mar-2020--></td>
		<td align="left" valign=bottom ><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">SPECIAL AL</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1650" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['spl_pay']))echo round($res2[0]['spl_pay'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">SPECIAL AL</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1650" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['spl_pay_payable']))echo round($res2[0]['spl_pay_payable'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="3" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="3" sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>
	
    <tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000"><!--CL--></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">Attend.</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"><?php if(isset($res2[0]['get_attendance_all']))echo round($res2[0]['get_attendance_all'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Attend.</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="2" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['get_attendance_all_payable']))echo round($res2[0]['get_attendance_all_payable'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="5" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="5" sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>
    

    <tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000"><!--EL/PL--></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">Bonus</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"><?php if(isset($res2[0]['bonus']))echo round($res2[0]['bonus'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Bonus</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="3" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['bonus_payable']))echo round($res2[0]['bonus_payable'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="6" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="6" sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>

    <tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000"><!--SL--></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">OT</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="4" sdnum="1033;0;0.00"><font color="#000000"><?php if(isset($res2[0]['total_ot_rs']))echo round($res2[0]['total_ot_rs'],2);?></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="7" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="7" sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>

    <tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000"><!--PF/ESI Rate--></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="5" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="8" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="8" sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>
   
    <?php /*?>
    
   
	
	
	
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000"><!--PF--> </font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="6" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="9" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="9" sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000"><!--FPF--></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="7" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="10" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="10" sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>

    <?php */?>
	<tr>
		<td style="border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000"><!--ESI--></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="8" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">Prof Tax</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000">0.00</font></td>
		<td align="left" valign=bottom><font color="#000000">Includes Arrears</font></td>
		<td style="border-right: 1px solid #000000" align="left" valign=bottom sdnum="1033;0;0.00"><font color="#000000"></font></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000" height="21" align="left" valign=bottom><font color="#000000"><!--VPF--></font></td>
		<td align="left" valign=bottom sdnum="1033;0;@"><font color="#000000"></font></td>
		<td style="border-bottom: 1px solid #000000; border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td align="left" valign=bottom><font color="#000000">Arrears if Any</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="1" sdnum="1033;"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000"></font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="9" sdnum="1033;0;0.00"><font color="#000000"></font></td>
		<td style="border-left: 1px solid #000000" align="left" valign=bottom><font color="#000000">TDS</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000">0.00</font></td>
		<td align="left" valign=bottom><font color="#000000">Arrear Amt</font></td>
		<td style="border-right: 1px solid #000000" align="right" valign=bottom sdval="0" sdnum="1033;0;0.00"><font color="#000000">0.00</font></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000" colspan=3 rowspan=2 height="43" align="center" valign=bottom><font color="#000000"></font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b><font color="#000000">Gross       <?php if(isset($res2[0]['current_ctc']))echo round($res2[0]['current_ctc'],2);?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b><font color="#000000">Days Payable      <?php if(isset($res2[0]['total_present']))echo round($res2[0]['total_present'],2);?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b><font color="#000000">Gross Pay    <?php if(isset($res2[0]['current_ctc_payable']))echo round($res2[0]['current_ctc_payable'],2);?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b><font color="#000000">Deduction        <?php echo $deduction_amt;?></font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle><b><font color="#000000">Net Pay   <?php if(isset($res2[0]['current_total_ctc_payable']))echo round($res2[0]['current_total_ctc_payable'],2);?></font></b></td>
		</tr>
	
</table>
<!-- ************************************************************************** -->

This is Computer Generated Statement, Does not required Signature .......................................................
</body>

</html>
