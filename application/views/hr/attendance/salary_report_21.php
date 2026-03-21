<?php 

$type_search = $_REQUEST['type_search'];
$year_search = $_REQUEST['year_search'];
$month_search = $_REQUEST['month_search'];
$last_month_from=date("$year_search-$month_search-01");
$month_name =  date("M", strtotime($last_month_from));

$name = $this->Base->get_details_contractor_with_id($type_search);
//print_r($name);
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
	
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title>Salary Report 2</title>
	<meta name="author" content="Manorajan Sharma,keepcoding.in,manu"/>
	<meta name="changedby" content="Manu"/>
	<link href="<?php echo base_url();?>dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
	
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p { font-family:"Times New Roman"; font-size:x-small }
		a.comment-indicator:hover + comment { background:#ffd; position:absolute; display:block; border:1px solid black; padding:0.5em;  } 
		a.comment-indicator { background:red; display:inline-block; border:1px solid black; width:0.5em; height:0.5em;  } 
		comment { display:none;  } 
	</style>
	
</head>



<body>
<table cellspacing="0" border="0">
	<colgroup width="47"></colgroup>
	<colgroup width="133"></colgroup>
	<colgroup width="54"></colgroup>
	<colgroup width="62"></colgroup>
	<colgroup width="63"></colgroup>
	<colgroup width="62"></colgroup>
	<colgroup width="63"></colgroup>
	<colgroup width="62"></colgroup>
	<colgroup width="63"></colgroup>
	<colgroup width="62"></colgroup>
	<colgroup width="63"></colgroup>
	<colgroup width="62"></colgroup>
	<colgroup width="63"></colgroup>
	<colgroup width="98"></colgroup>
	<colgroup width="63"></colgroup>
	<colgroup width="83"></colgroup>
	<colgroup width="98"></colgroup>
	<tr>
		<td colspan='18' >
			<h2 align='center' ><?php echo $company_full_name; ?></h2>
			<h4 align='center' ><?php echo $company_address;?></h4>
			<h3 align='center' > <?php if(!empty($type_search)){echo $type_search;}?> - <?php if(!empty($month_name)){echo $month_name;}?> / <?php if(!empty($year_search)){echo $year_search;}?>	</h3>
		</td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 height="108" align="left" valign=top><b><font face="Verdana" size=1>Sl.No. EmpID</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=top><font color="#000000">Name UAN DOJ PF No.<br>ESI No.<br>DOB</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="left" valign=top><font color="#000000">Pay Days<br>Present Days<br>Leave<br>With Pay<br>Without Pay<br>WO    GH</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=top><b><font face="Verdana" size=1>Actual Rate</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=top><b><font face="Verdana" size=1>Earnings</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="left" valign=middle><b><font face="Verdana" size=1>Total Earnings</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="center" valign=top><b><font face="Verdana" size=1>Deductions</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="left" valign=middle><b><font face="Verdana" size=1>Total Deductions</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="left" valign=middle><b><font face="Verdana" size=1>Net Amount</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="left" valign=top><b><font face="Verdana" size=1>Date of Payment</font></b></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="left" valign=top><b><font face="Verdana" size=1>Remarks if any and Signature</font></b></td>
	</tr>
	<tr>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top><font face="Verdana" size=1>BASIC</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top><font color="#000000">HRA</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top><font color="#000000">CON</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top><font face="Verdana" size=1>BASIC</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top><font color="#000000">HRA</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top><font color="#000000">CON</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top><font face="Verdana" size=1>PF</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top><font color="#000000">ESI</font></td>
		<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=top><font color="#000000">Advance <br> Other</font></td>
		</tr>
	<tr>
		<td height="18" align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
		<td align="left" valign=bottom><font color="#000000"><br></font></td>
	</tr>


	<?php 
		$i=1;
		
		foreach($emp as $e)
		{
			if(!empty($e['id']))
			{
				$pay_code2=$e['id'];
				$query=" 	SELECT 
							E.aadhar_no,E.first_name,E.last_name,E.father_name,E.epf_code,E.esi_code,E.bank_account_no,E.dob,E.doj_master_roll,E.dor_master_roll,
							E.emp_uan,E.basic_salary_master_roll,E.hra_master_roll,E.conv_master_roll,
							D.name as dname, 
							R.name as rname
							FROM employee as E 
							LEFT JOIN department as D ON D.department_id =  E.department_id 
							LEFT JOIN department_role as R ON R.role_id =  E.role_in_department 
							WHERE  E.id='$pay_code2' 
						";
				$out_emp = $this->Mymodel->query1($query);

				if(isset($out_emp[0]['dob']) and $out_emp[0]['dob']!='0000-00-00'){$test = new DateTime($out_emp[0]['dob']);$dob= date_format($test, 'd-m-Y');}else{$dob='';}
				if(isset($out_emp[0]['doj_master_roll']) and $out_emp[0]['doj_master_roll']!='0000-00-00'){$test = new DateTime($out_emp[0]['doj_master_roll']);$doj_master_roll= date_format($test, 'd-m-Y');}else{$doj_master_roll='';}
				if(isset($out_emp[0]['dor_master_roll']) and $out_emp[0]['dor_master_roll']!='0000-00-00'){$test = new DateTime($out_emp[0]['dor_master_roll']);$dor_master_roll= date_format($test, 'd-m-Y');}else{$dor_master_roll='';}

				$out=array();
				$query=" SELECT * FROM daily_attendance_monthly where emp_code='$pay_code2'  and att_year='$year' and att_month='$month' and basic_salary_master_roll>0 ";
				$out=$this->Mymodel->query1($query);
				if(!empty($out))
				{
					$total_p = $out[0]['total_present'];
					$total_a = $out[0]['total_absent'];
					


					$basic = $out[0]['basic_salary_master_roll'];
					$hra = $out[0]['hra_master_roll'];
					$cov = $out[0]['conv_master_roll'];
					
					$basic1 = (int)$out[0]['get_basic_salary_master_roll'];
					$hra1 = (int)$out[0]['get_hra_master_roll'];
					$cov1 = (int)$out[0]['get_conv_master_roll'];
					//$total_get = round($basic1+$hra1+$cov1);
					$total_get = (int)$out[0]['master_roll_total_get'];

					
					$esic_ded = (int)$out[0]['esic_payable_master_roll'];
					$pf_ded = (int)$out[0]['epf_payable_master_roll'];
					$advance = (int)$out[0]['lost_advance_master_roll'];
					$other = (int)$out[0]['other_advance_master_roll'];
					//$total_lost = round($esic_ded+$pf_ded+$advance+$other);
					//$net = round($total_get-$total_lost);
					$total_lost = (int)$out[0]['other_advance_master_roll'];
					$net = (int)$out[0]['master_roll_total_net_pay'];
					
					
				
				?>



				<tr>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="20" align="left" valign=top><b><font face="Verdana" size=1><?php echo $out_emp[0]['first_name'].' '.$out_emp[0]['last_name'];?></font></b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=top><b><font face="Verdana" size=1>Father Name</font></b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="left" valign=top><font face="Verdana" size=1><?php echo $out_emp[0]['father_name'];?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=top><b><font face="Verdana" size=1>Designation</font></b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 align="left" valign=top><font face="Verdana" size=1><?php echo $out_emp[0]['rname'];?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=top><b><font face="Verdana" size=1>AADHAR No.</font></b></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="left" valign=middle><font color="#000000"><?php echo $out_emp[0]['aadhar_no'];?></font></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=top sdval="1" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"><?php echo $i;?></font></td>
					<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top sdval="101363550876" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"><?php echo $out_emp[0]['emp_uan'];?></font></td>
					<td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top sdval="30" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"><?php echo $total_p;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $basic;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $hra;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $cov;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $basic1;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $hra1;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $cov1;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $total_get;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $pf_ded;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $esic_ded;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $advance;?><br><?php echo $other;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $total_lost;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=top sdnum="1033;0;#,##0.00"><font face="Verdana" size=1 color="#000000"><?php echo $net;?></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="left" valign=top><font color="#000000"><br></font></td>
					<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="left" valign=top><font color="#000000"><br></font></td>
				</tr>
				<tr>
					<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=top sdval="2" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"></font></td>
					<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top sdval="43770" sdnum="1033;0;DD-MMM-YYYY;@"><font face="Verdana" size=1 color="#000000"><?php echo $doj_master_roll;?></font></td>
					<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top sdval="29" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"><?php echo $total_a;?></font></td>
				</tr>
				<tr>
					<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=top sdval="3" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"></font></td>
					<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top><font face="Verdana" size=1><?php echo $out_emp[0]['epf_code'];?></font></td>
					<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top sdval="28" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"></font></td>
				</tr>
				<tr>
					<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=top sdval="4" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"></font></td>
					<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top sdval="1509830168" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"><?php echo $out_emp[0]['esi_code'];?></font></td>
					<td style="border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top sdval="27" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"></font></td>
				</tr>
				<tr>
					<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="left" valign=top sdval="5" sdnum="1033;0;0"><font face="Verdana" size=1 color="#000000"></font></td>
					<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top sdval="34919" sdnum="1033;0;DD-MMM-YYYY;@"><font face="Verdana" size=1 color="#000000"><?php echo $dob;?></font></td>
					<td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=top sdval="26" sdnum="1033;"><font face="Verdana" size=1></font></td>
				</tr>


			<?php 
			$i++;
			}//out
		}
	}
	?>








</table>
<!-- ************************************************************************** -->
</body>

</html>
