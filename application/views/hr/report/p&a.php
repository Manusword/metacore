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
                <th>Bio Code</th>
                <th>Employee Name</th>
                <th>Department</th>

                <?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
                for ($d = 1; $d <= $daysInMonth; $d++): ?>
                    <th><?= $d ?></th>
                <?php endfor; ?>

                <th>Total P</th>
                <th>Total A</th>
                <th>Fine</th>
                <th>Advance</th>
            </tr>
        </thead>

        <tbody>
        <?php $i=1; foreach ($finalReport as $emp): ?> 
            <tr>
                <td><?= $i++ ?></td>
                <td align="left"><strong><?= $emp['pay_code'] ?></strong></td>
                <td align="left"><?= $emp['bio_code'] ?></td>
                <td align="left" <?php if($emp['active'] == 'Deactive') echo "style='background-color:red;' " ; ?>><?= htmlspecialchars($emp['full_name']) ?> </td>
                <td align="left"><?= htmlspecialchars($emp['department_name']) ?></td>
               
                <?php
                    for ($d = 1; $d <= $daysInMonth; $d++):
                        $p_a = trim($emp["d$d"]);   // attendance code
                        $ot  = $emp["o$d"];

                        if ($p_a === '') {
                            $class = 'att-empty';
                        }
                        elseif (array_key_exists($p_a, $attMap)) {
                            $class = $attMap[$p_a];
                        }
                        else {
                            $class = 'att-wrong';   // ❌ invalid / unexpected value
                        }
                    ?>
                        <td class="att-cell <?= $class ?>" title="<?= $d ?>">
                            <?= htmlspecialchars($p_a) ?>
                            <?php if ($ot !== '' && $ot !== '0'): ?>
                                <div style="font-size:10px">OT: <?= $ot ?></div>
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>


                <td><strong><?= $emp['total_present'] ?></strong></td>
                <td><strong><?= $emp['total_absent'] ?></strong></td>
                <td><?= number_format($emp['lost_1_payable'],2) ?></td>
                <td><?= number_format($emp['advance_this_month_payable'],2) ?></td>

            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
    
</div>