<?php 
$role_list='';
if (!empty($type_search_list) && is_array($type_search_list)) {    
    $role_list = implode(",", $type_search_list);
}

$attMap = [
    'P'  => 'att-P',
    'A'  => 'att-A',
    'L'  => 'att-A',
    'HA' => 'att-HA',
    'HL' => 'att-HL',
    'H'  => 'att-H',
    'R'  => 'att-R',
    'CL' => 'att-R',
    'SL' => 'att-R',
    'EL' => 'att-R',
    'OL' => 'att-R',
    'S'  => 'att-S',
    'T'  => 'att-T',
];

?>




<div id="print-area">
    <div align='center' > 
		<h2 align='center' ><?php echo $role_list;?></h2>
		<h3 align='center' >
		<?php 
			
			if(!empty($month) and !empty($year)){
				echo "Attendance Report of (".$this->Base->change_date_into_month_name(date("01-$month-$year")).')';
				
			}else{
				echo "No month & year Found.";
				exit;
			}
		?>
		</h3>
		<h5 align="left"  style="border-bottom: #000 1px dotted;border-top: #000 1px dotted;"><?php echo "Print Date: ".date("d-m-Y");?></h5>
	</div>






    <!-- ================= ATTENDANCE TABLE ================= -->

   
        <table class="table table-bordered table-sm" id="printed_table">
        <thead>
            <tr>
                  <th>Sno</th>
                <th>Emp Code</th>
                <!-- <th>Bio Code</th>
                <th>Employee Name</th>
                <th>Department</th> -->

                <?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
                for ($d = 1; $d <= $daysInMonth; $d++): ?>
                    <th><?= $d ?></th>
                <?php endfor; ?>

                <!-- <th>Ext. Min</th>
                <th>Ext. Day's</th> -->
                <th>Total Hrs.</th>
                <th>W.H</th>
                <th>Days</th>
                <th>Final Days</th>
                <th>Total A</th>
                
                <!-- <th>Fine</th>
                <th>Advance</th> -->
            </tr>
        </thead>
          
        <tbody>
        <?php $i=1; foreach ($finalReport as $emp): 
               $late_punch_add =  $emp['late_punch_add'];
               $lateTotal = 0;
               $TotalDutyHrs = 0;
               $TotalDutymin = 0;
            ?>
            <tr>

                 <td><?= $i++ ?></td>
                <!-- <td align="left"><strong><?= $emp['pay_code'] ?></strong></td>
                <td align="left"><?= $emp['bio_code'] ?></td>
                <td align="left" <?php if($emp['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>><?= htmlspecialchars($emp['full_name']) ?> </td>
                <td align="left"><?= htmlspecialchars($emp['department_name']) ?></td> -->

                <td>
                    <strong><?= $emp['pay_code'] ?></strong> <br>
                    <?= $emp['bio_code'] ?><br>
                    <span <?php if($emp['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>> <b><?= htmlspecialchars($emp['full_name']) ?> </b></span><br>
                    <?= htmlspecialchars($emp['department_name']) ?><br>
                </td>
                

               <?php
                for ($d = 1; $d <= $daysInMonth; $d++):

                    $cell   = $emp['days'][$d] ?? [];
                    $status = trim($cell['status'] ?? '');
                    $in     = $cell['in']   ?? '';
                    $out    = $cell['out']  ?? '';
                    $ot     = $cell['ot']   ?? '';
                    $duty_hours = (float)($cell['duty'] ?? 0);
                    $dutyMin    = (int)($cell['dutyMin'] ?? 0);
                    $lateHr     = (int)($cell['late'] ?? 0);

                    $displayOut = $out;   // default display OUT

                    // ===============================
                    // LIMIT DUTY HOURS TO 8
                    // ===============================
                    if (!empty($in) && !empty($out) && $duty_hours > 8) {

                        // extra hours (only whole hours)
                        $extraHr = floor($duty_hours - 8);

                        if ($extraHr > 0) {
                            $outTime = new DateTime($out);
                            $outTime->modify("-{$extraHr} hours");

                            $displayOut = $outTime->format('H:i');

                            // force duty to 8
                            $duty_hours = 8;
                        }
                    }
                    else if(!empty($out)){
                        $displayOut = date('H:i', strtotime($out));
                    }

                    // ===============================
                    // TOTALS
                    // ===============================
                    $TotalDutymin += $dutyMin;

                    if ($late_punch_add === 'Yes') {
                        $lateTotal += $lateHr;

                        if ($status === 'H') {
                            $duty_hours = 8;
                        }

                        $TotalDutyHrs += (float)$duty_hours;
                    }

                    // ===============================
                    // ATTENDANCE CLASS
                    // ===============================
                    if ($status === '') {
                        $class = 'att-empty';
                    }
                    elseif (array_key_exists($status, $attMap)) {
                        $class = $attMap[$status];
                    }
                    else {
                        $class = 'att-wrong';
                    }
                ?>
                <td class="att-cell <?php echo $class ?>" title="<?= $d ?>">

                    <div><?= htmlspecialchars($status) ?></div>

                    <!-- IN TIME -->
                    <div style="font-size:10px">
                        <?= $in ? date('H:i', strtotime($in)) : '' ?>
                    </div>

                    <!-- OUT TIME (ADJUSTED) -->
                    <div style="font-size:10px">
                        <?= $displayOut ? $displayOut : '' ?>
                    </div>

                   

                    <!-- SYSTEM HOURS -->
                    <?php if ($duty_hours > 0):

                        $sysHr = floor($duty_hours * 10) / 10;

                        $fontColor = "#7c2d12";

                        // mismatch highlight
                        if (!empty($dutyMinHr) && $dutyMinHr != $sysHr) {
                            $fontColor = "red";
                        }
                    ?>
                        <div style="font-size:10px;color:<?= $fontColor ?>;">
                            Hrs: <?= $sysHr ?>
                        </div>
                    <?php endif; ?>

                </td>
                <?php endfor; ?>

               
                <td>
                    <?php if($late_punch_add == 'Yes' ){?>
                        <div style="color:#6b21a8;"><?php  echo $TotalDutymin2 = floor(($TotalDutymin / 60) * 10) / 10 ?> </div>
                        <div style="color:#7c2d12;"><?php  echo $TotalDutyHrs ?> </div>
                    <?php   }?>
                </td>

                <td><?php  echo $emp['working_hr'] ?> </td>
                
                <td style="color:blue;">
                    <?php if($late_punch_add == 'Yes' and $TotalDutyHrs>0 and (int)$emp['working_hr']){?>
                            <div style="color:#6b21a8;"><?php  if(!empty($TotalDutymin2))echo round($TotalDutymin2/$emp['working_hr'],1); ?> </div>
                            <div style="color:#7c2d12;"><?php  echo round($TotalDutyHrs/$emp['working_hr'],1); ?> </div>
                    <?php   }?>
                </td>

                <td>
                    <strong><?= $emp['total_present'] ?></strong> 
                    <!-- <br><br> <?php if((float)$emp['total_ot']>0){?>OT: <span style="color:red"><?= $emp['total_ot'] ?></span> <?php }?> -->
                </td>
                <td><strong><?= $emp['total_absent'] ?></strong></td>

                <!-- <td><?= number_format($emp['lost_1_payable'],2) ?></td>
                <td><?= number_format($emp['advance_this_month_payable'],2) ?></td> -->

            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    
</div>