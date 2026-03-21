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

    //getcompnay details form company_role
    $comp = array();
    if(isset($emp[0]['company_role'])){
        $comp = $this->Base->get_details_contractor_with_id($emp[0]['company_role']);
    }
    



    // if(isset($res2[0]['esic_payable'])){ $a = round($res2[0]['esic_payable'],2);}else{ $a = 0; }
    // if(isset($res2[0]['epf_payable'])){ $b = round($res2[0]['epf_payable'],2);}else{ $b = 0; }
    // if(isset($res2[0]['lost_canteen_payable'])){ $c = round($res2[0]['lost_canteen_payable'],2);}else{ $c = 0; }
    // if(isset($res2[0]['lost_breakfast_payable'])){  $d = round($res2[0]['lost_breakfast_payable'],2);}else{ $d = 0; }
    // if(isset($res2[0]['lost_bus_payable'])){ $e = round($res2[0]['lost_bus_payable'],2);}else{ $e = 0; }
   
    // if(isset($res2[0]['lost_2'])){ $f = round($res2[0]['lost_2'],2);}else{ $f = 0; } //loan
    // if(isset($res2[0]['lost_3'])){ $tds = round($res2[0]['lost_3'],2);}else{ $tds = 0; } //tds
    // if(isset($res2[0]['lost_1'])){ $h = round($res2[0]['lost_1'],2);}else{ $h = 0; } //fine
    // if(isset($res2[0]['advance_this_month_payable'])){ $ad = round($res2[0]['advance_this_month_payable'],2);}else{ $ad = 0; } //advance
    // if(isset($res2[0]['lost_4'])){ $k = round($res2[0]['lost_4'],2);}else{ $k = 0; } //tds
    // $deduction_amt = $a+$b+$c+$d+$e+$f+$tds+$h+$ad+$k;


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $emp[0]['first_name'].' '.$emp[0]['last_name'];?> Slip</title>
<meta name="author" content="Manu Sharma,keepcoding.in"/>

<style>
@page {
    size: A4;
    margin: 10mm;
}

body {
    margin: 0;
    padding: 0;
    font-family: "Courier New", monospace;
}

.page {
    width: 190mm;
    height: 277mm;
}

/* ---------- SALARY SLIP ---------- */
.salary-slip {
    height: 135mm;
    border: 3px solid #000;
    box-sizing: border-box;
    padding: 5mm;
}

.cut-line {
    border-top: 2px dashed #000;
    margin: 6mm 0;
}

/* ---------- TABLE ---------- */
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

td, th {
    border: 1px solid #000;
    padding: 4px;
    vertical-align: top;
}

.no-border { border: none !important; }
.center { text-align: center; }
.right { text-align: right; }
.bold { font-weight: bold; }

.title {
    font-size: 16px;
    font-weight: bold;
}

.subtitle {
    font-size: 13px;
    font-weight: bold;
}

.section-title {
    font-weight: bold;
    text-align: center;
    background: #f2f2f2;
}

.big {
    font-size: 16px;
    font-weight: bold;
}

.signature {
    text-align: right;
    padding-top: 22px;
    font-weight: bold;
}

@media print {
    .page {
        page-break-after: always;
    }
}

.no-row-border td {
    border-bottom: none !important;
	border-top: none !important;
}

</style>
</head>

<body>

<div class="page">

<!-- ================= SLIP 1 ================= -->
<div class="salary-slip">

<table>
<tr>
    <td colspan="4" class="center no-border">
        <div class="title"><?php if(!empty($comp))echo $comp[0]['full_name'];?></div>
        <div class="subtitle"><?php if(!empty($comp))echo $comp[0]['address'];?></div>
        <div class="subtitle">SALARY SLIP FOR THE MONTH OF <?php echo $month_search.'/'.$year_search; ?></div>
    </td>
</tr>
</table>

<table>
<tr class="no-row-border" style=" border-top: 1px solid #000;">
    <td >Emp No.</td>
	<td >Employee Name</td>
	<td >Department</td>
    <td >Designation</td>
</tr>
<tr class="no-row-border">
    <td class="bold"><?php if(isset($emp[0]['emp_code']))echo $emp[0]['emp_code'];?></td>
	<td class="bold"><?php echo $emp[0]['first_name'].' '.$emp[0]['last_name'];?></td>
	<td class="bold"><?php if(isset($emp[0]['main_dept_name']))echo $emp[0]['main_dept_name'];?></td>
    <td class="bold"><?php if(isset($emp[0]['join_role_name']))echo $emp[0]['join_role_name'];?></td>
</tr>
<tr class="no-row-border"  style=" border-top: 1px solid #000;">
	<td></td>    
	<td >Father / Husband Name</td>
	<td >Salary (CTC)</td>
	<td >Date of Joining</td>
</tr>
<tr class="no-row-border">
	<td></td>    
	<td class="bold"><?php if(isset($emp[0]['father_name']))echo $emp[0]['father_name'];?></td>
    <td class="bold"><?php if(isset($res2[0]['current_ctc']))echo round($res2[0]['current_ctc'],2);?></td>
	<td class="bold"><?php echo $doj;?></td>
</tr>
<tr class="no-row-border"  style=" border-top: 1px solid #000;">
    <td>Total Monthly Days</td>
	<td>No. of Days Worked</td>
	<td>Payment Mode</td>
	<td>NEFT</td>
</tr>
<tr class="no-row-border">
    <td class="bold"><?php if(isset($res2[0]['total_day_in_month']))echo $res2[0]['total_day_in_month'];?></td>
	<td class="bold"><?php if(isset($res2[0]['total_present']))echo $res2[0]['total_present'];?></td>
    <td class="bold"><?php if(isset($emp[0]['bank_account_no']))echo $emp[0]['bank_account_no'];?></td>
	<td class="bold"><?php if(isset($emp[0]['co_mob_no']))echo $emp[0]['co_mob_no'];?></td>
</tr>
</table>

<table>
<tr>
    <td class="section-title" colspan="2">EARNINGS</td>
    <td class="section-title" colspan="2">DEDUCTIONS</td>
</tr>
<tr class="no-row-border">
    <td style="border-right: none !important;">Earned Basic</td>
	<td class="right" style="border: none !important;"><?php if(isset($res2[0]['basic_salary_payable']))echo round($res2[0]['basic_salary_payable'],2);?></td>
    <td style="border-right: none !important;">EPF No:  <?php if(isset($emp[0]['epf_code']))echo $emp[0]['epf_code'];?></td></td>
	<td class="right" style="border-left: none !important;"><?php if(!empty($res2[0]['epf_payable'])){echo round($res2[0]['epf_payable'],2);}else{echo "FALSE";}?></td>
</tr>
<tr class="no-row-border">
    <td style="border-right: none !important;">Earned HRA</td>
	<td class="right"  style="border: none !important;"><?php if(isset($res2[0]['hra_payable']))echo round($res2[0]['hra_payable'],2);?></td>
    <td style="border-right: none !important;">ESI No: <?php if(isset($emp[0]['esi_code']))echo $emp[0]['esi_code'];?></td>
	<td class="right"  style="border-left: none !important;"><?php if(!empty($res2[0]['esic_payable'])){echo round($res2[0]['esic_payable'],2);}else{echo "FALSE";}?></td>
</tr>
<tr class="no-row-border">
    <td style="border-right: none !important;">Earned Special Allowance</td>
	<td class="right"  style="border: none !important;"><?php if(isset($res2[0]['other_allow_payable']))echo round($res2[0]['other_allow_payable'],2);?></td>
    <td style="border-right: none !important;">Staff Advance</td>
	<td class="right"  style="border-left: none !important;"><?php if(isset($res2[0]['advance_this_month_payable']))echo round($res2[0]['advance_this_month_payable'],2);?></td>
</tr>
<tr class="no-row-border">
    <td style="border-right: none !important;">Education Allowance</td>
	<td class="right"  style="border: none !important;"><?php if(isset($res2[0]['conv_payable']))echo round($res2[0]['conv_payable'],2);?></td>
    <td style="border-right: none !important;">TDS Recovery</td>
	<td class="right"  style="border-left: none !important;"><?php if(isset($res2[0]['lost_3']))echo round($res2[0]['lost_3'],2);?></td>
</tr>
<tr class="no-row-border">
    <td style="border-right: none !important;">Others</td>
	<td class="right"  style="border: none !important;"><?php if(isset($res2[0]['city_comp_payable']))echo round($res2[0]['city_comp_payable'],2);?></td>
    <td style="border-right: none !important;">Other Deduction</td>
	<td class="right"  style="border-left: none !important;"><?php if(isset($res2[0]['lost_canteen_payable']))echo round($res2[0]['lost_canteen_payable'],2);?></td>
</tr>
<tr>
    <td colspan="2" class="bold right" ><?php if(isset($res2[0]['current_ctc_payable']))echo round($res2[0]['current_ctc_payable'],2);?></td>
   	<td colspan="2" class="bold right"><?php if(isset($res2[0]['total_deduction']))echo round($res2[0]['total_deduction'],2);?></td>
</tr>
</table>

<table>
<tr>
    <td class="bold" colspan="2">Nett Salary Payable : <?php if(isset($res2[0]['current_total_ctc_payable']))echo round($res2[0]['current_total_ctc_payable'],2);?> </td>
    <td class="center">for <?php if(!empty($comp))echo $comp[0]['full_name'];?></td>
</tr>
<tr>
    <td colspan="2"><?php if(isset($res2[0]['current_total_ctc_payable']))echo $this->Base->convert_number_to_words($res2[0]['current_total_ctc_payable']); ?></td>
    <td class="signature">Authorised Signatory</td>
</tr>
</table>

</div>

<div class="cut-line"></div>

<!-- ================= SLIP 2 (IDENTICAL) ================= -->
<!-- SAME DATA / OR DIFFERENT EMPLOYEE -->
<!-- DUPLICATE FOR SECOND EMPLOYEE -->


</div>

</body>
</html>
