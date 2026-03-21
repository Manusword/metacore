<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th colspan='13' style="background-color:white;color:black;">
                    <?php if(isset($res2[0]['shift_in_time'])){echo 'Date: '.$shift_in_time=$this->Base->change_date_dmy($res2[0]['shift_in_time']);}?>
                </th>
            </tr>
            <tr>
                <th>#</th>
                  <th>Pic</th>
                  <th>Emp code <br> Bio Code</th>
                  <th>From <br> Working</th>
                  <th>Name <br> Dept.</th>
                  <th>Working <br>Hrs</th>
                  <th>Duty</th>
                  <th>Shift</th>
                  
                  <th>OT</th>
                  <th>Shift <br>In Time</th>
                  <th>Punch <br> In Time</th>
                  <th>Diff. <br> Early / Late</th>
                  <th>Shift <br> Out Time</th>
                  <th>Punch <br> Out Time</th>
                  <th>Diff. <br> Early / Late</th>
                  <th>Extra Min</th> 
                  <th>location</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
           
            $i=1;
            foreach($res2 as $r)
            {
                if(isset($r['shift_in_time'])){$shift_in_time = $this->Base->change_date_dmy_hisa($r['shift_in_time']);}else{$shift_in_time='';}
                if(isset($r['in_time_mc']) and $r['in_time_mc'] != '0000-00-00 00:00:00'){$in_time_mc=$this->Base->change_date_dmy_hisa($r['in_time_mc']);}else{$in_time_mc='';}
                if(isset($r['in_time'])){$in_time=$this->Base->change_date_dmy_hisa($r['in_time']);}else{$in_time='';}
                if(isset($r['shift_out_time2'])){$shift_out_time2=$this->Base->change_date_dmy_hisa($r['shift_out_time2']);}else{$shift_out_time2='';}
                if(isset($r['out_time_mc']) and $r['out_time_mc'] != '0000-00-00 00:00:00'){$out_time_mc=$this->Base->change_date_dmy_hisa($r['out_time_mc']);}else{$out_time_mc='';}
                if(isset($r['out_time']) and $r['out_time'] != '0000-00-00 00:00:00'){$out_time=$this->Base->change_date_dmy_hisa($r['out_time']);}else{$out_time='';}

                if($r['in_status'] == 'L' and $r['in_min_late_early']>5){$color="#f2d37c";}else{$color="";}
                if($r['out_status'] == 'E' and $r['out_min_late_early']>5){$color2="#f2d37c";}else{$color2="";}
           
                    // ===== ROW COLOR (>180 min) =====
                    $rowStyle = (
                        ($r['in_min_late_early'] ?? 0) > 180 ||
                        ($r['out_min_late_early'] ?? 0) > 180
                    ) ? 'color:red;' : '';

                    // ===== DUTY TYPE BADGE =====
                    $duty = $r['duty_type'] ?? '';
                    $dutyClass = 'badge-primary';
                    if ($duty === 'P') $dutyClass = 'badge-success';
                    elseif ($duty === 'A' || $duty === 'L') $dutyClass = 'badge-danger';

                    // ===== MACHINE / MANUAL BADGE =====
                    $inPunchBadge = !empty($in_time_mc)
                        ? '<span class="badge badge-info"><i class="bi bi-cpu"></i> Machine</span>'
                        : '<span class="badge badge-secondary"><i class="bi bi-pencil"></i> Manual</span>';

                    $outPunchBadge = !empty($out_time_mc)
                        ? '<span class="badge badge-info"><i class="bi bi-cpu"></i> Machine</span>'
                        : '<span class="badge badge-secondary"><i class="bi bi-pencil"></i> Manual</span>';

                    // ===== IN LATE / EARLY BADGE =====
                    $inLateBadge = (
                        ($r['in_status'] ?? '') === 'L' &&
                        ($r['in_min_late_early'] ?? 0) > 0
                    )
                    ? '<span class="badge badge-danger">'.$r['in_min_late_early'].' min Late</span>'
                    : (
                        ($r['in_status'] ?? '') === 'E' && ($r['in_min_late_early'] ?? 0) > 0
                            ? '<span class="badge badge-success">'.$r['in_min_late_early'].' min Early</span>'
                            : '<span class="badge badge-secondary">On Time</span>'
                    );

                    // ===== OUT EARLY / LATE BADGE =====
                    $outEarlyBadge = (
                        ($r['out_status'] ?? '') === 'E' &&
                        ($r['out_min_late_early'] ?? 0) > 0
                    )
                    ? '<span class="badge badge-danger">'.$r['out_min_late_early'].' min Early</span>'
                    : (
                        ($r['out_status'] ?? '') === 'L' && ($r['out_min_late_early'] ?? 0) > 0
                            ? '<span class="badge badge-success">'.$r['out_min_late_early'].' min Late</span>'
                            : '<span class="badge badge-secondary">On Time</span>'
                    );

                    ?>

                    <tr style="<?= $rowStyle ?>">
                        <td><?= $i ?>.</td>

                        <td>
                            <?php $this->Base->emp_dp_from_emp_code($r['emp_code'],40,40); ?><br>
                            <?php if (($r['mater_roll'] ?? '') === 'Yes'): ?>
                                <span class="badge badge-danger">M</span>
                            <?php endif; ?>
                        </td>

                        <td><?= $r['emp_code'] ?? '' ?><br><?= $r['bio_code'] ?? '' ?></td>

                        <td><?= $r['company_role'] ?? '' ?><br><?= $r['plant'] ?? '' ?></td>

                        <td><?= ($r['first_name'] ?? '').' '.($r['last_name'] ?? '') ?><br><?= $r['dname'] ?? '' ?></td>

                        <td><?= $r['working_hr'] ?? '' ?></td>

                        <td><span class="badge <?= $dutyClass ?>"><?= $duty ?></span></td>

                        <td><?= $r['shift'] ?? '' ?> (<?= $r['shift_name'] ?? '' ?>)</td>

                        <td><?= ($r['ot_hours'] ?? 0) > 0 ? $r['ot_hours'] : '' ?></td>

                        <td><?= $shift_in_time ?></td>
                        <td><?= $in_time ?> <?= $inPunchBadge ?></td>
                        <td> <?= $inLateBadge ?></td>

                        <td><?= $shift_out_time2 ?></td>
                        <td><?= $out_time ?> <?= $outPunchBadge ?></td>
                        <td><?= $outEarlyBadge ?></td>

                        <td><?= (($r['late_punch_add'] ?? '') === 'Yes') ? ($r['extra_min'] ?? '') : '' ?></td>

                        <td><?= $r['location'] ?? '' ?></td>
                    </tr>

            <?php
            $i++; 
            }
            ?>
                    
        </tbody>
    </table>
</div>