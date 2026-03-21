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
		<title>Salary Incentive</title>
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
		<h2 align='center' ><?php echo $company_full_name; //Rahul Wire Ropes?></h2>
		<h4 align='center' ><?php echo $company_address; //A-43, Kaharani Industrial Area Bhiwadi ,Teh. Tijara, Dist. Alwar (Raj)-301019?></h4>
		<h3 align='center' > <?php if(!empty($type_search)){echo $type_search;}?> - <?php if(!empty($month_name)){echo $month_name;}?> / <?php if(!empty($year_search)){echo $year_search;}?>	</h3>
		
		<table border="1" class="table-striped " style="font-size:15px; width:98%; margin-left:1%"   >
			<thead>
			<tr>
				<th >#</th>
				<th  >E. Code</th>
				<th  width="150px;">Name</th>
				<th>Father Name</th>
				<td align='right' width="70px;">Incentive Amt</td>
				<td align='right' width="70px;">ESIC (0.75%)</td>
				<td align='right' width="70px;">Net Pay</td>
			</tr>
			</thead> 
			<tbody>
				<?php 
				$i=1;
				foreach($emp as $e)
				{
					if(!empty($e['id'])){
					$pay_code2=$e['id'];
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
				
					?>
					<tr style="height:40px">
						<td><?php echo $i;?></td>
						<td ><?php echo $e['pay_code'];?> </td>
						<td ><?php echo $e['first_name'].' '.$e['last_name'];?></td>
						<td  ><?php echo $out_emp[0]['father_name'];?> </td>
						
						<?php if(isset($out[0]['total_ot'])){  $a13[] = $out[0]['total_ot'];}?>
						<td align='right'><span style="margin-left:5px; font-size:14px; "><?php if(isset($out[0]['total_ot_rs'])){ echo $total_ot_rs = $out[0]['total_ot_rs']; $a24[] =$total_ot_rs; }?></span></td>
						<td align='right'>
							<span style="margin-left:5px; font-size:14px; ">
								<?php 
									//if(isset($out[0]['esic_payable'])){ echo $a27[] = $out[0]['esic_payable'];}
									echo $sub_total_esi = round(($total_ot_rs*0.75)/100); 
									$a27[] =  $sub_total_esi;
								?>
							</span>
						</td>
						<td align='right'>
							<span style="margin-left:5px; font-size:14px;  color:black; font-weight:bold;">
								<?php 
									//if(isset($out[0]['current_total_ctc_payable'])){ echo $a32[] = $out[0]['current_total_ctc_payable'];}
									echo $a32[] = $total_ot_rs-$sub_total_esi;
								?>
							</span>
						</td>
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
					<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a13)){ echo round(array_sum($a24)); }?></span></td>
					<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a24)){ echo round(array_sum($a27)); }?></span></td>
					<td align='right'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold; "><?php if(!empty($a32)){ echo round(array_sum($a32)); }?></span></td>
				</tr>
			</tbody>
		</table>
	<?php 
	}
	?>

	<div style="height:100px; width:100%;"></div>
</body>
</html>
