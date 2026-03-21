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
                    $duty_hours     = $cell['duty']   ?? '';
                    $dutyMin     = (int)$cell['dutyMin']   ?? '';
                    $lateHr = (int)($cell['late'] ?? 0);

                    $TotalDutymin += $dutyMin;//total duty min via machine

                    if ($late_punch_add === 'Yes') {
                        $lateTotal += $lateHr;

                        if ($status === 'H') {
                            $duty_hours = 8;
                        }
                        $TotalDutyHrs += (float)$duty_hours;
                    }

                    // ---- main attendance class ----
                    if ($status === '') {
                        $class = 'att-empty';
                    }
                    elseif (array_key_exists($status, $attMap)) {
                        $class = $attMap[$status];
                    }
                    else {
                        $class = 'att-wrong';   // ❌ invalid code
                    }

                    // ---- extra flags (only for Present) ----
                    $extraClass = '';
                    if ($status === 'P') {
                        if ($in && strtotime($in) > strtotime('09:15')) {
                            $extraClass = 'late';
                        }
                        if ($out && strtotime($out) < strtotime('18:00')) {
                            $extraClass = 'early';
                        }
                    }
                ?>
                    <td class="att-cell <?= $class ?> <?= $extraClass ?>" title="<?= $d ?>">
                        <div><?= htmlspecialchars($status) ?></div>

                        <div style="font-size:10px">
                            <?= $in ? date('H:i', strtotime($in)) : '' ?>
                        </div>
                        <div style="font-size:10px">
                            <?= $out ? date('H:i', strtotime($out)) : '' ?>
                        </div>

                        <?php /*if ($ot !== '' && $ot !== '0'): ?>
                            <div style="font-size:10px; color:red; font-weight:blod;">OT: <?= htmlspecialchars($ot) ?></div>
                        <?php endif; */ ?>
                            
                       

                        <?php if ($dutyMin > 0): 
                            $dutyMinHr = floor(($dutyMin / 60) * 10) / 10;
                        ?>
                            <div style="font-size:10px;color:#6b21a8;" title="Machine">
                                m/c: <?= $dutyMin . ', ' . $dutyMinHr ?>
                            </div>
                        <?php endif; ?>


                        <?php if ($duty_hours > 0): 
                            $sysHr = floor($duty_hours * 10) / 10;

                            // default color
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

                <?php /*
                <td style="color:red;"><?php if($late_punch_add == 'Yes' ){?><?php  echo $lateTotal ?> <?php   }?></td>
                <td style="color:red;"><?php if($late_punch_add == 'Yes' ){?><?php echo $addDays =$this->Base->cal_min_into_days_latepunch($lateTotal,$emp['working_hr']);?> <?php   }?></td>
                */?>

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