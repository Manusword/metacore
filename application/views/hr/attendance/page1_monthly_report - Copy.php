<?php 

$type_search = $_REQUEST['type_search'];
$year_search = $_REQUEST['year_search'];
$month_search = $_REQUEST['month_search'];
if(isset($_REQUEST['attendance_time'])){$attendance_time = $_REQUEST['attendance_time'];}else{$attendance_time = "NO";}

	//----------------------------------getting Sunday
	function getSundays($y, $m,$day)
	{
		return new DatePeriod(
			new DateTime("first $day of $y-$m"),
			DateInterval::createFromDateString("next $day"),
			new DateTime("last day of $y-$m 23:59:59")
		);
	}
	
	function getSundays2($y, $m,$day)
	{
		foreach (getSundays($y, $m,$day) as $sunday) {
			$no_of_sunday_array2= $sunday->format("d,\n");
			$no_of_sunday_array[] = "$no_of_sunday_array2";
		}
		
		return $no_of_sunday_array;
	}
	//----------------------------------getting Sunday
	//---------------Getting no of sunday
	$no_of_sunday_array = getSundays2($year, $month,'sunday');
	$no_of_sunday=count($no_of_sunday_array);



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>Attendance Monthly Report</title>
		<meta name="author" content="Manorajan Sharma,keepcoding.in,manu"/>
		<meta name="changedby" content="Manu"/>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<style>
			/* .day{ font-weight:bold;}
			.table-striped tr:hover {
				background:#CFF !important;
			} */
		</style>
	</head>

<body style="font-size:12px;" >
<div class="table-responsive">

<?php 

if(!empty($emp))
{
	
	//seting day value 0 or 1
		function check_data($cloumn,$year,$month,$day)
		{
			$current_date=date('Ymd');
			if($month<10){$month2='0'.$month;}else{$month2=$month;}
			if(strlen($day)<2){$day2='0'.$day;}else{$day2=$day;}
			
			$date2=$year.'-'.$month2.'-'.$day2;
			$test = new DateTime($date2);$check_date= date_format($test, 'Ymd');

			if($check_date<=$current_date)
			{
				echo $cloumn;
			}
			
		}//close
		

		function get_color($data,$no,$no_of_restday_array)
		{
			if(in_array($no,$no_of_restday_array)){$bgcolor= "#f6f7dc";}else{$bgcolor= "";} //for rest day
			//echo "style='background-color:yellow;border:yellow 1px solid;'";
			if($data == "P"){echo "style='color:green; font-weight:bold; background-color:$bgcolor; '";}
			elseif($data == "A"){echo "style='color:red; font-weight:bold; background-color:$bgcolor; '";}
			elseif($data == "H"){echo "style='color:orange; font-weight:bold; background-color:$bgcolor; '";}
			elseif($data == "L"){echo "style='color:orange; font-weight:bold; background-color:$bgcolor; '";}
			elseif($data == "S"){echo "style='color:blue; font-weight:bold; background-color:$bgcolor; '";}
			elseif($data == "R"){echo "style='color:blue; font-weight:bold; background-color:$bgcolor; '";}
			else{echo "style=' background-color:$bgcolor; '";}
			
		}//close
		
		
		//--------checking no of days in this month
	 	$no_of_days_in_month=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		
		
		

		
?>
	<h2 align='center' > <?php if(!empty($type_search)){echo $type_search;}?> - <?php if(!empty($month_search)){echo $month_search;}?> / <?php if(!empty($year_search)){echo $year_search;}?>	</h2>
    
	<table class="table table-bordered table-sm" width="100%" >
        <thead >
            <tr>
        	<th >#</th>
        	<th>Name</th>
        	<th>E. Code</th>
			<th>Dept.</th>
			<th>Designation</th>
			<th>Rest Day</th>
        	<td align='center' <?php if(in_array(1,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>01</td>
        	<td align='center' <?php if(in_array(2,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>02</td>
        	<td align='center' <?php if(in_array(3,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>03</td>
        	<td align='center' <?php if(in_array(4,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>04</td>
        	<td align='center' <?php if(in_array(5,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>05</td>
        	<td align='center' <?php if(in_array(6,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>06</td>
        	<td align='center' <?php if(in_array(7,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>07</td>
        	<td align='center' <?php if(in_array(8,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>08</td>
        	<td align='center' <?php if(in_array(9,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>09</td>
        	<td align='center' <?php if(in_array(10,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>10</td>
        	<td align='center' <?php if(in_array(11,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>11</td>
        	<td align='center' <?php if(in_array(12,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>12</td>
        	<td align='center' <?php if(in_array(13,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>13</td>
        	<td align='center' <?php if(in_array(14,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>14</td>
        	<td align='center' <?php if(in_array(15,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>15</td>
        	<td align='center' <?php if(in_array(16,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>16</td>
        	<td align='center' <?php if(in_array(17,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>17</td>
        	<td align='center' <?php if(in_array(18,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>18</td>
        	<td align='center' <?php if(in_array(19,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>19</td>
        	<td align='center' <?php if(in_array(20,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>20</td>
        	<td align='center' <?php if(in_array(21,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>21</td>
        	<td align='center' <?php if(in_array(22,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>22</td>
        	<td align='center' <?php if(in_array(23,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>23</td>
        	<td align='center' <?php if(in_array(24,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>24</td>
        	<td align='center' <?php if(in_array(25,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>25</td>
        	<td align='center' <?php if(in_array(26,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>26</td>
        	<td align='center' <?php if(in_array(27,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>27</td>
        	<td align='center' <?php if(in_array(28,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>28</td>
        	
			<?php  if(29<=$no_of_days_in_month){?><td align='center' <?php if(in_array(29,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>29</td><?php }?>
        	<?php  if(30<=$no_of_days_in_month){?><td align='center' <?php if(in_array(30,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>30</td><?php }?>
        	<?php  if(31<=$no_of_days_in_month){?><td align='center' <?php if(in_array(31,$no_of_sunday_array)){echo "style='background-color:yellow;'";}?>>31</td><?php }?>
        	
			<td align='center' width="70px;">Total Present</td>
			<td align='center' width="70px;">Total Absent</td>
			<td align='center' width="70px;">Total O.T</td>
			
        </tr>
        </thead> 
        <tbody id="tablebody">
		<?php 
		$i=1;
		foreach($emp as $e)
		{
			if($i ==13){
				break;
			}


			$pay_code = $e['pay_code'];
			$pay_code2=$e['id'];
			$query=" 
						SELECT E.father_name,E.epf_code,E.esi_code,E.bank_account_no,E.restday,D.name as dname, R.name as rname
						FROM employee as E 
						LEFT JOIN department as D ON D.department_id =  E.department_id 
						LEFT JOIN department_role as R ON R.role_id =  E.role_in_department 
						WHERE  E.id='$pay_code2'  
					";
			$out_emp=$this->Mymodel->query1($query);
			//rest day
			if(!empty($out_emp[0]['restday'])){
				$restDay = $out_emp[0]['restday'];
			}else{
				$restDay = 'sunday';
			}
			$no_of_restday_array = getSundays2($year, $month,$restDay);
			
			$out=array();
			$query=" SELECT * FROM daily_attendance_monthly where emp_code='$pay_code2'  and att_year='$year' and att_month='$month' ";
			$out=$this->Mymodel->query1($query);
			
			if(isset($out[0]['d1'])){ $d1 = $out[0]['d1'];}else{$d1 = '';}
			if(isset($out[0]['d2'])){ $d2 = $out[0]['d2'];}else{$d2 = '';}
			if(isset($out[0]['d3'])){ $d3 = $out[0]['d3'];}else{$d3 = '';}
			if(isset($out[0]['d4'])){ $d4 = $out[0]['d4'];}else{$d4 = '';}
			if(isset($out[0]['d5'])){ $d5 = $out[0]['d5'];}else{$d5 = '';}
			if(isset($out[0]['d6'])){ $d6 = $out[0]['d6'];}else{$d6 = '';}
			if(isset($out[0]['d7'])){ $d7 = $out[0]['d7'];}else{$d7 = '';}
			if(isset($out[0]['d8'])){ $d8 = $out[0]['d8'];}else{$d8 = '';}
			if(isset($out[0]['d9'])){ $d9 = $out[0]['d9'];}else{$d9 = '';}
			if(isset($out[0]['d10'])){ $d10 = $out[0]['d10'];}else{$d10 = '';}
			
			if(isset($out[0]['d11'])){ $d11 = $out[0]['d11'];}else{$d11 = '';}
			if(isset($out[0]['d12'])){ $d12 = $out[0]['d12'];}else{$d12 = '';}
			if(isset($out[0]['d13'])){ $d13 = $out[0]['d13'];}else{$d13 = '';}
			if(isset($out[0]['d14'])){ $d14 = $out[0]['d14'];}else{$d14 = '';}
			if(isset($out[0]['d15'])){ $d15 = $out[0]['d15'];}else{$d15 = '';}
			if(isset($out[0]['d16'])){ $d16 = $out[0]['d16'];}else{$d16 = '';}
			if(isset($out[0]['d17'])){ $d17 = $out[0]['d17'];}else{$d17 = '';}
			if(isset($out[0]['d18'])){ $d18 = $out[0]['d18'];}else{$d18 = '';}
			if(isset($out[0]['d19'])){ $d19 = $out[0]['d19'];}else{$d19 = '';}
			if(isset($out[0]['d20'])){ $d20 = $out[0]['d20'];}else{$d20 = '';}

			if(isset($out[0]['d21'])){ $d21 = $out[0]['d21'];}else{$d21 = '';}
			if(isset($out[0]['d22'])){ $d22 = $out[0]['d22'];}else{$d22 = '';}
			if(isset($out[0]['d23'])){ $d23 = $out[0]['d23'];}else{$d23 = '';}
			if(isset($out[0]['d24'])){ $d24 = $out[0]['d24'];}else{$d24 = '';}
			if(isset($out[0]['d25'])){ $d25 = $out[0]['d25'];}else{$d25 = '';}
			if(isset($out[0]['d26'])){ $d26 = $out[0]['d26'];}else{$d26 = '';}
			if(isset($out[0]['d27'])){ $d27 = $out[0]['d27'];}else{$d27 = '';}
			if(isset($out[0]['d28'])){ $d28 = $out[0]['d28'];}else{$d28 = '';}
			if(isset($out[0]['d29'])){ $d29 = $out[0]['d29'];}else{$d29 = '';}
			if(isset($out[0]['d30'])){ $d30 = $out[0]['d30'];}else{$d30 = '';}
			if(isset($out[0]['d31'])){ $d31 = $out[0]['d31'];}else{$d31 = '';}


			
			//ot
			if(isset($out[0]['o1'])){ $o1 = $out[0]['o1'];}else{$o1 = '';}
			if(isset($out[0]['o2'])){ $o2 = $out[0]['o2'];}else{$o2 = '';}
			if(isset($out[0]['o3'])){ $o3 = $out[0]['o3'];}else{$o3 = '';}
			if(isset($out[0]['o4'])){ $o4 = $out[0]['o4'];}else{$o4 = '';}
			if(isset($out[0]['o5'])){ $o5 = $out[0]['o5'];}else{$o5 = '';}
			if(isset($out[0]['o6'])){ $o6 = $out[0]['o6'];}else{$o6 = '';}
			if(isset($out[0]['o7'])){ $o7 = $out[0]['o7'];}else{$o7 = '';}
			if(isset($out[0]['o8'])){ $o8 = $out[0]['o8'];}else{$o8 = '';}
			if(isset($out[0]['o9'])){ $o9 = $out[0]['o9'];}else{$o9 = '';}
			if(isset($out[0]['o10'])){ $o10 = $out[0]['o10'];}else{$o10 = '';}
			
			if(isset($out[0]['o11'])){ $o11 = $out[0]['o11'];}else{$o11 = '';} 
			if(isset($out[0]['o12'])){ $o12 = $out[0]['o12'];}else{$o12 = '';}
			if(isset($out[0]['o13'])){ $o13 = $out[0]['o13'];}else{$o13 = '';}
			if(isset($out[0]['o14'])){ $o14 = $out[0]['o14'];}else{$o14 = '';}
			if(isset($out[0]['o15'])){ $o15 = $out[0]['o15'];}else{$o15 = '';}
			if(isset($out[0]['o16'])){ $o16 = $out[0]['o16'];}else{$o16 = '';}
			if(isset($out[0]['o17'])){ $o17 = $out[0]['o17'];}else{$o17 = '';}
			if(isset($out[0]['o18'])){ $o18 = $out[0]['o18'];}else{$o18 = '';}
			if(isset($out[0]['o19'])){ $o19 = $out[0]['o19'];}else{$o19 = '';}
			if(isset($out[0]['o20'])){ $o20 = $out[0]['o20'];}else{$o20 = '';}

			if(isset($out[0]['o21'])){ $o21 = $out[0]['o21'];}else{$o21 = '';}
			if(isset($out[0]['o22'])){ $o22 = $out[0]['o22'];}else{$o22 = '';}
			if(isset($out[0]['o23'])){ $o23 = $out[0]['o23'];}else{$o23 = '';}
			if(isset($out[0]['o24'])){ $o24 = $out[0]['o24'];}else{$o24 = '';}
			if(isset($out[0]['o25'])){ $o25 = $out[0]['o25'];}else{$o25 = '';}
			if(isset($out[0]['o26'])){ $o26 = $out[0]['o26'];}else{$o26 = '';}
			if(isset($out[0]['o27'])){ $o27 = $out[0]['o27'];}else{$o27 = '';}
			if(isset($out[0]['o28'])){ $o28 = $out[0]['o28'];}else{$o28 = '';}
			if(isset($out[0]['o29'])){ $o29 = $out[0]['o29'];}else{$o29 = '';}
			if(isset($out[0]['o30'])){ $o30 = $out[0]['o30'];}else{$o30 = '';}
			if(isset($out[0]['o31'])){ $o31 = $out[0]['o31'];}else{$o31 = '';}


			if(isset($out[0]['total_present'])){ $total_present = $out[0]['total_present'];}else{$total_present = '';}
			if(isset($out[0]['total_absent'])){ $total_absent = $out[0]['total_absent'];}else{$total_absent = '';}
			if(isset($out[0]['total_ot'])){ $total_ot = $out[0]['total_ot'];}else{$total_ot = '';}
			
			
			$fullname =  $e['first_name'].' '.$e['last_name'];
			
			?>
            
            <tr >
            	<td  width="10px;"><?php echo $i;?></td>
            	<td  width="250px;"><?php echo $fullname;?></td>
            	<td  width="100px;"><?php echo $pay_code;?> </td>
				<td  width="100px;"><?php echo $out_emp[0]['dname'];?> </td>
				<td  width="100px;"><?php echo $out_emp[0]['rname'];?> </td>
				<td  width="100px;" id="<?php echo "restday_".$pay_code2;?>"><?php echo $restDay;?> </td>
                
 				<td onclick="fun_get_popup_data(this.id)" id="<?php echo $pay_code2.'~'.$pay_code.'~'.'1'.'~'.$d1.'~'.$o1.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d1-".$pay_code2;?>" title="1" align='center'  <?php echo get_color($d1,1,$no_of_restday_array)?>  >  <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'01',$month,$year);  ?>  <?php echo $d1;?><br> <span style="background-color:<?php if($o1>4){echo "yellow";}?>;"><?php echo $o1;?></span> </td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'2'.'~'.$d2.'~'.$o2.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d2-".$pay_code2;?>" title="2" align='center'  <?php echo get_color($d2,2,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'02',$month,$year); ?> <?php echo $d2;?><br><span style="background-color:<?php if($o2>4){echo "yellow";}?>;"><?php echo $o2;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'3'.'~'.$d3.'~'.$o3.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d3-".$pay_code2;?>" title="3" align='center'  <?php echo get_color($d3,3,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'03',$month,$year); ?> <?php echo $d3;?><br><span style="background-color:<?php if($o3>4){echo "yellow";}?>;"><?php echo $o3;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'4'.'~'.$d4.'~'.$o4.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d4-".$pay_code2;?>" title="4" align='center'  <?php echo get_color($d4,4,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'04',$month,$year); ?> <?php echo $d4;?><br><span style="background-color:<?php if($o4>4){echo "yellow";}?>;"><?php echo $o4;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'5'.'~'.$d5.'~'.$o5.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d5-".$pay_code2;?>" title="5" align='center'  <?php echo get_color($d5,5,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'05',$month,$year); ?> <?php echo $d5;?><br><span style="background-color:<?php if($o5>4){echo "yellow";}?>;"><?php echo $o5;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'6'.'~'.$d6.'~'.$o6.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d6-".$pay_code2;?>" title="6" align='center'  <?php echo get_color($d6,6,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'06',$month,$year); ?> <?php echo $d6;?><br><span style="background-color:<?php if($o6>4){echo "yellow";}?>;"><?php echo $o6;?></span></td>

				<td onclick="fun_get_popup_data(this.id)" id="<?php echo $pay_code2.'~'.$pay_code.'~'.'7'.'~'.$d7.'~'.$o7.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d7-".$pay_code2;?>" title="7" align='center'  <?php echo get_color($d7,7,$no_of_restday_array)?> > 
				<?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'07',$month,$year); ?> <?php echo $d7;?><br><span style="background-color:<?php if($o7>4){echo "yellow";}?>;"><?php echo $o7;?></span></td>


				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'8'.'~'.$d8.'~'.$o8.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d8-".$pay_code2;?>" title="8" align='center'  <?php echo get_color($d8,8,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'08',$month,$year); ?> <?php echo $d8;?><br><span style="background-color:<?php if($o8>4){echo "yellow";}?>;"><?php echo $o8;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'9'.'~'.$d9.'~'.$o9.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d9-".$pay_code2;?>" title="9" align='center'  <?php echo get_color($d9,9,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'09',$month,$year); ?> <?php echo $d9;?><br><span style="background-color:<?php if($o9>4){echo "yellow";}?>;"><?php echo $o9;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'10'.'~'.$d10.'~'.$o10.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d10-".$pay_code2;?>" title="10" align='center'  <?php echo get_color($d10,10,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'10',$month,$year); ?>  <?php echo $d10;?><br><span style="background-color:<?php if($o10>4){echo "yellow";}?>;"><?php echo $o10;?></span></td>

				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'11'.'~'.$d11.'~'.$o11.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d11-".$pay_code2;?>" title="11" align='center'  <?php echo get_color($d11,11,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'11',$month,$year); ?>  <?php echo $d11;?><br><span style="background-color:<?php if($o11>4){echo "yellow";}?>;"><?php echo $o11;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'12'.'~'.$d12.'~'.$o12.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d12-".$pay_code2;?>" title="12" align='center'  <?php echo get_color($d12,12,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'12',$month,$year); ?>  <?php echo $d12;?><br><span style="background-color:<?php if($o12>4){echo "yellow";}?>;"><?php echo $o12;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'13'.'~'.$d13.'~'.$o13.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d13-".$pay_code2;?>" title="13" align='center'  <?php echo get_color($d13,13,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'13',$month,$year); ?>  <?php echo $d13;?><br><span style="background-color:<?php if($o13>4){echo "yellow";}?>;"><?php echo $o13;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'14'.'~'.$d14.'~'.$o14.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d14-".$pay_code2;?>" title="14" align='center'  <?php echo get_color($d14,14,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'14',$month,$year); ?>  <?php echo $d14;?><br><span style="background-color:<?php if($o14>4){echo "yellow";}?>;"><?php echo $o14;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'15'.'~'.$d15.'~'.$o15.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d15-".$pay_code2;?>" title="15" align='center'  <?php echo get_color($d15,15,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'15',$month,$year); ?>  <?php echo $d15;?><br><span style="background-color:<?php if($o15>4){echo "yellow";}?>;"><?php echo $o15;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'16'.'~'.$d16.'~'.$o16.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d16-".$pay_code2;?>" title="16" align='center'  <?php echo get_color($d16,16,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'16',$month,$year); ?>  <?php echo $d16;?><br><span style="background-color:<?php if($o16>4){echo "yellow";}?>;"><?php echo $o16;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'17'.'~'.$d17.'~'.$o17.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d17-".$pay_code2;?>" title="17" align='center'  <?php echo get_color($d17,17,$no_of_restday_array)?> > <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'17',$month,$year); ?>  <?php echo $d17;?><br><span style="background-color:<?php if($o17>4){echo "yellow";}?>;"><?php echo $o17;?></span></td>
			
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'18'.'~'.$d18.'~'.$o18.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d18-".$pay_code2;?>" title="18" align='center'  <?php echo get_color($d18,18,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'18',$month,$year); ?>  <?php echo $d18;?><br><span style="background-color:<?php if($o18>4){echo "yellow";}?>;"><?php echo $o18;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'19'.'~'.$d19.'~'.$o19.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d19-".$pay_code2;?>" title="19" align='center'  <?php echo get_color($d19,19,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'19',$month,$year); ?>  <?php echo $d19;?><br><span style="background-color:<?php if($o19>4){echo "yellow";}?>;"><?php echo $o19;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'20'.'~'.$d20.'~'.$o20.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d20-".$pay_code2;?>" title="20" align='center'  <?php echo get_color($d20,20,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'20',$month,$year); ?>  <?php echo $d20;?><br><span style="background-color:<?php if($o20>4){echo "yellow";}?>;"><?php echo $o20;?></span></td>

				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'21'.'~'.$d21.'~'.$o21.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d21-".$pay_code2;?>" title="21" align='center'  <?php echo get_color($d21,21,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'21',$month,$year); ?>  <?php echo $d21;?><br><span style="background-color:<?php if($o21>4){echo "yellow";}?>;"><?php echo $o21;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'22'.'~'.$d22.'~'.$o22.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d22-".$pay_code2;?>" title="22" align='center'  <?php echo get_color($d22,22,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'22',$month,$year); ?>  <?php echo $d22;?><br><span style="background-color:<?php if($o22>4){echo "yellow";}?>;"><?php echo $o22;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'23'.'~'.$d23.'~'.$o23.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d23-".$pay_code2;?>" title="23" align='center'  <?php echo get_color($d23,23,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'23',$month,$year); ?>  <?php echo $d23;?><br><span style="background-color:<?php if($o23>4){echo "yellow";}?>;"><?php echo $o23;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'24'.'~'.$d24.'~'.$o24.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d24-".$pay_code2;?>" title="24" align='center'  <?php echo get_color($d24,24,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'24',$month,$year); ?>  <?php echo $d24;?><br><span style="background-color:<?php if($o24>4){echo "yellow";}?>;"><?php echo $o24;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'25'.'~'.$d25.'~'.$o25.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d25-".$pay_code2;?>" title="25" align='center'  <?php echo get_color($d25,25,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'25',$month,$year); ?>  <?php echo $d25;?><br><span style="background-color:<?php if($o25>4){echo "yellow";}?>;"><?php echo $o25;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'26'.'~'.$d26.'~'.$o26.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d26-".$pay_code2;?>" title="26" align='center'  <?php echo get_color($d26,26,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'26',$month,$year); ?>  <?php echo $d26;?><br><span style="background-color:<?php if($o26>4){echo "yellow";}?>;"><?php echo $o26;?></span></td>
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'27'.'~'.$d27.'~'.$o27.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d27-".$pay_code2;?>" title="27" align='center'  <?php echo get_color($d27,27,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'27',$month,$year); ?>  <?php echo $d27;?><br><span style="background-color:<?php if($o27>4){echo "yellow";}?>;"><?php echo $o27;?></span></td>
				
				<td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'28'.'~'.$d28.'~'.$o28.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d28-".$pay_code2;?>" title="28" align='center'  <?php echo get_color($d28,28,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'28',$month,$year); ?>  <?php echo $d28;?><br><span style="background-color:<?php if($o28>4){echo "yellow";}?>;"><?php echo $o28;?></span></td>
				
				 
				
				<?php  if(29<=$no_of_days_in_month){?><td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'29'.'~'.$d29.'~'.$o29.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d29-".$pay_code2;?>" title="29" align='center'  <?php echo get_color($d29,29,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'29',$month,$year); ?>  <span style="background-color:<?php if($o29>4){echo "yellow";}?>;"><?php echo $d29;?><br><?php echo $o29;?></span></td><?php }?>
				<?php  if(30<=$no_of_days_in_month){?><td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'30'.'~'.$d30.'~'.$o30.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d30-".$pay_code2;?>" title="30" align='center'  <?php echo get_color($d30,30,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'30',$month,$year); ?>  <span style="background-color:<?php if($o30>4){echo "yellow";}?>;"><?php echo $d30;?><br><?php echo $o30;?></span></td><?php }?>
				<?php  if(31<=$no_of_days_in_month){?><td onclick="fun_get_popup_data(this.id)"id="<?php echo $pay_code2.'~'.$pay_code.'~'.'31'.'~'.$d31.'~'.$o31.'~'.$fullname.'~'.$restDay;?>" class="<?php echo "d31-".$pay_code2;?>" title="31" align='center'  <?php echo get_color($d31,31,$no_of_restday_array)?>> <?php if($attendance_time == 'Yes')$out9=$this->Hrmodel->print_attendance_date_time($pay_code,'31',$month,$year); ?>  <span style="background-color:<?php if($o31>4){echo "yellow";}?>;"><?php echo $d31;?><br><?php echo $o31;?></span></td> <?php }?>

                
                
                <td align='center'><span style="margin-left:5px; font-size:14px; color:green; font-weight:bold;" id="<?php echo "total_present_".$pay_code2;?>"><?php echo $total_present;?></span></td>
				<td align='center'><span style="margin-left:5px; font-size:14px; color:red; font-weight:bold;" id="<?php echo "total_absent_".$pay_code2;?>"><?php echo $total_absent;?></span></td>
				<td align='center'><span style="margin-left:5px; font-size:14px; color:black; font-weight:bold;" id="<?php echo "total_ot_".$pay_code2;?>"><?php echo $total_ot;?></span></td>
            </tr>
            <?php
			$i++;
		}
		?>
    </tbody>
    </table>
    
   

		
			


<?php 
}
?>
<script src="<?php echo base_url();?>dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



<!-- Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="font-size:18px">
	  			<input type="hidden" id="current_div_id"  />
				<input type="hidden" id="model_empid"  />
				<input type="hidden" id="model_day"  />

			<div class="row">
				<div class="col">
					Present : <input type="radio"  name="now_attendance" value="P"><br>
					Absent : <input type="radio"  name="now_attendance" value="A"><br>
					Rest : <input type="radio"  name="now_attendance" value="R"><br>
					Holiday : <input type="radio"  name="now_attendance" value="H"><br>
					Sunday : <input type="radio"  name="now_attendance" value="S"><br>
					Leave : <input type="radio"  name="now_attendance" value="L"><br>
				</div>
				<div class="col">
					Over Time <br>
						2.5 : 	<input type="radio"  name="model_ot" value="2.5"><br>
						3 : 	<input type="radio"  name="model_ot" value="3"><br>
						3.5 : 	<input type="radio"  name="model_ot" value="3.5"><br>
						4 : 	<input type="radio"  name="model_ot" value="4"><br>
				</div>
			</div>
			<br>

			<div class="row">
				<div class="col">
					Rest Day : 	<select id="model_restday" class="form-control">
						<option>sunday</option>
						<option>monday</option>
						<option>tuesday</option>
						<option>wednesday</option>
						<option>thursday</option>
						<option>friday</option>
						<option>saturday</option>
					</select>
				</div>
			</div>
			<br>

			<div class="row">
				<div class="col">
					Shift <br>
						A : <input type="radio"  name="shift" value="A"><br>
						B : <input type="radio"  name="shift" value="B"><br>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col">
					In Time <br>
					7:00 AM : <input type="radio"  name="inTime" value="7:00 AM"><br>
					8:00 AM : <input type="radio"  name="inTime" value="8:00 AM"><br>
					9:00 AM : <input type="radio"  name="inTime" value="9:00 AM"><br>
					10:00 AM : <input type="radio"  name="inTime" value="10:00 AM"><br>
					
					7:00 PM : <input type="radio"  name="inTime" value="7:00 PM"><br>
					8:00 PM : <input type="radio"  name="inTime" value="8:00 PM"><br>
					9:00 PM : <input type="radio"  name="inTime" value="9:00 PM"><br>
				</div>
				<div class="col">
				Out Time <br>
					7:00 PM : <input type="radio"  name="outTime" value="7:00 PM"><br>
					8:00 PM : <input type="radio"  name="outTime" value="8:00 PM"><br>
					9:00 PM : <input type="radio"  name="outTime" value="9:00 PM"><br>

					7:00 AM : <input type="radio"  name="outTime" value="7:00 AM"><br>
					8:00 AM : <input type="radio"  name="outTime" value="8:00 AM"><br>
					9:00 AM : <input type="radio"  name="outTime" value="9:00 AM"><br>
					10:00 AM : <input type="radio"  name="outTime" value="10:00 AM"><br>
					
					
				</div>
			</div>

       
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="attendance_update()" >Update</button>
      </div>
    </div>
  </div>
</div>
<script>

	let year_search = <?php echo $year_search;?>;
	let month_search = <?php echo $month_search;?>;

	function fun_get_popup_data(id){
		let data = id.split("~");
		let classname = document.getElementById(id).className;

		//blank
		$('.modal-title').html('');
		$('#model_empcode').val('');
		$('#model_day').val('');
		$(`input:radio`).prop("checked", false);
		//$('#model_ot').val('');
		$('#current_div_id').val('');
		$('#model_restday').val('');
		$('#current_div_id').val(classname);
		
		
		let current_emp_id = data[0];
		if(current_emp_id > 0){
			let current_emp_code = data[1];
			let current_day = data[2];
			let current_status = data[3];
			let current_ot = data[4];
			let current_name = data[5];
			let current_restday = data[6];


			$('.modal-title').html(`${current_name} : ${current_emp_code} `);
			$('#model_empid').val(current_emp_id);
			$('#model_day').val(current_day);
			if(current_status.length > 0){
				$(`input[name="now_attendance"][value=${current_status}]`).prop("checked", true);
			}
			
			
			//$('#model_ot').val(current_ot);
			$('#model_restday').val(current_restday);
			
			
  			
			//LOAD MODEL
			$("#attendanceModal").modal('show');
		}
		
	}//function close

	/*
	document.querySelector('#tablebody').onclick = function(event) { 
    	//blank
		$('.modal-title').html('');
		$('#model_empcode').val('');
		$('#model_day').val('');
		$(`input:radio[value='']`).prop("checked", true);
		$('#model_ot').val('');
		$('#current_div_id').val('');
		$('#model_restday').val('');
		$('#current_div_id').val(event.target.classList);
		//console.log(event.target)
		
		let data = event.target.id.split("~");
		let current_emp_id = data[0];
		if(current_emp_id > 0){
			let current_emp_code = data[1];
			let current_day = data[2];
			let current_status = data[3];
			let current_ot = data[4];
			let current_name = data[5];
			let current_restday = data[6];

			$('.modal-title').html(`${current_name} : ${current_emp_code} `);
			$('#model_empid').val(current_emp_id);
			$('#model_day').val(current_day);
			$(`input:radio[value=${current_status}]`).prop("checked", true); 
			$('#model_ot').val(current_ot);
			$('#model_restday').val(current_restday);
			
			
  			
			//LOAD MODEL
			$("#attendanceModal").modal('show');
		}
	}
	*/


	//update
	function attendance_update() 
	{
		let empid = $('#model_empid').val();
		let current_day = $('#model_day').val();
		let current_status = $('input[name="now_attendance"]:checked').val();
		//let current_ot = $('#model_ot').val();
		let current_ot = $('input[name="model_ot"]:checked').val();if(!current_ot){current_ot= "0";}
		//get current box td id
		let current_box_classname = $('#current_div_id').val();
		let current_restday = $('#model_restday').val();
		
		let shift = $('input[name="shift"]:checked').val(); if(!shift){shift= "A";}
		let inTime = $('input[name="inTime"]:checked').val(); if(!inTime){inTime = "8:00 AM"}
		let outTime = $('input[name="outTime"]:checked').val(); if(!outTime){outTime = "8:00 PM"}

		

		//console.log(empid,current_day,year_search,month_search,current_status,current_ot,current_restday)
		
		
		jQuery.post("<?php echo base_url().'index.php/Hr/attendance_entry_manual_popup_model';?>", 
			{
				empid:empid,
				current_day:current_day,
				year_search:year_search,
				month_search:month_search,
				current_status:current_status,
				current_ot:current_ot,
				current_restday:current_restday,
				shift:shift,
				inTime:inTime,
				outTime:outTime,
			}, 
			
			function(data, textStatus)
			{	
				let result = data.split("~");
				let result_status = result[0];
				if(result_status === 'success'){
					//console.log(data)
					let total_present = result[1];
					let total_absent = result[2];
					let total_ot = result[3];

					$(`.${current_box_classname}`).html(`${current_status} <br> ${current_ot}`).css("background-color", "blue").css("color", "white");
					let classdiv = current_box_classname.split("-");
					$(`#total_present_${classdiv[1]}`).html(`${total_present}`);
					$(`#total_absent_${classdiv[1]}`).html(`${total_absent}`);
					$(`#total_ot_${classdiv[1]}`).html(`${total_ot}`);
					$(`#restday_${classdiv[1]}`).html(`${current_restday}`);
					

					$("#attendanceModal").modal('hide');
				}else{
					alert(result_status)
				}
				
			});
			
		
	}//function close
	
</script>


<div style="height:100px; width:100%"></div>

</div>
</body>

</html>
