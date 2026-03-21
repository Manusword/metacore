<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color(); ?>; color:<?php echo $this->Company->table_ft_color(); ?>;">
            <tr>
                <th>#</th>
                <th>Process</th>
                <th>Log Id</th>
                <th>Coil no</th>
                <th>Production Date</th>
                <th>Shift</th>
                <th>Dept</th>
                <th>M/C No</th>

                <th>Grade</th>
                <th>Heat no</th>
                <th>Base Size (mm)</th>
                <th>Finish Size (mm)</th>
                <th>Size (mm) Min,&nbsp;&nbsp;Current,&nbsp;&nbsp;Max</th>

                <th>Breaking Load</th>
                <th>UTS</th>
                <th>Spec. 1</th>
                <th>Spec. 2</th>
                <th>Spec. 3</th>
                <th>Torsion</th>
                <th>Band</th>
                <th>% RA</th>
                <th>Bright.</th>
                <th>Remarks</th>
                <th>Rod Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //print_r($res2);
            $i = 1;
            foreach ($res2 as $r) {
                //test check    
                $res3 = $this->Qcmodel->get_spec1_details_for_test1_check($r['product_grade'], $r['main_finish_size']);

                if (!empty($res3)) {
                    $min_size =  $res3[0]['min_size'];
                    $max_size =  $res3[0]['max_size'];

                    $ts_min_ss1 =  $res3[0]['ts_min_ss1'];
                    $ts_max_ss1 =  $res3[0]['ts_max_ss1'];
                    $ts_min_ss2 =  $res3[0]['ts_min_ss2'];
                    $ts_max_ss2 =  $res3[0]['ts_max_ss2'];
                    $ts_min_ss3 =  $res3[0]['ts_min_ss3'];
                    $ts_max_ss3 =  $res3[0]['ts_max_ss3'];

                    if ($r['finish_size_test'] >= $min_size  and  $r['finish_size_test'] <= $max_size) {
                        $size_color = "#b4f0c2";
                        $size_color2 = "green";
                    } else {
                        $size_color = "#f0b4b5";
                        $size_color2 = "red";
                    }
                    if ($r['uts'] >= $ts_min_ss1  and  $r['uts'] <= $ts_max_ss1) {
                        $ts1_color = "blue";
                    } else {
                        $ts1_color = "";
                    }
                    if ($r['uts'] >= $ts_min_ss2  and  $r['uts'] <= $ts_max_ss2) {
                        $ts2_color = "blue";
                    } else {
                        $ts2_color = "";
                    }
                    if ($r['uts'] >= $ts_min_ss3  and  $r['uts'] <= $ts_max_ss3) {
                        $ts3_color = "blue";
                    } else {
                        $ts3_color = "";
                    }
                } else {
                    $min_size = '';
                    $max_size = '';
                    $ts_min_ss1 = '';
                    $ts_max_ss1 = '';
                    $ts_min_ss2 = '';
                    $ts_max_ss2 = '';
                    $ts_min_ss3 = '';
                    $ts_max_ss3 = '';
                    $size_color = '';
                    $ts1_color = 'green';
                    $ts2_color = 'green';
                    $ts3_color = 'green';
                }
                //test check
                if (isset($r['entry_date'])) {
                    $entry_date = $this->Base->change_date_dmy($r['entry_date']);
                } else {
                    $entry_date = '';
                }
            ?>
                <tr>
                    <td>
                        <?php echo $i; ?>.
                        <?php if (!empty($res3)) {
                        } else {
                            echo "<span style='color:red'>Spec. NF </span>";
                        } ?>
                    </td>
                    <td>
                        <a href="<?php base_url() ?>home?Qc/test1_add/<?php if (isset($r['qc_log_test_id'])) echo $r['qc_log_test_id'] ?>" target="_blank" class="btn btn-info">
                            <i class="nav-icon i-Pen-2"></i>
                        </a>
                    </td>
                    <td>
                        <a href="<?php base_url() ?>home?Qc/long_test_add/<?php if (isset($r['qc_log_test_id'])) echo $r['qc_log_test_id'] ?>" target="_blank">
                            <?php echo $r['qc_log_test_id'] ?>
                        </a>
                    </td>
                    <td><?php if (isset($r['coil_no'])) echo $r['coil_no']; ?></td>
                    <td><?php echo $entry_date; ?></td>
                    <td><?php if (isset($r['shift'])) echo $r['shift']; ?></td>
                    <td><?php if (isset($r['dname'])) echo $r['dname']; ?></td>
                    <td><?php if (isset($r['mname'])) echo $r['mname']; ?></td>

                    <td><?php if (isset($r['grade_name'])) echo $r['grade_name']; ?></td>
                    <td><?php if (isset($r['lotno'])) echo $r['lotno']; ?></td>
                    <td><?php if (isset($r['base_size'])) echo $r['base_size']; ?></td>
                    <td><?php if (isset($r['main_finish_size'])) echo $r['main_finish_size']; ?></td>
                    <td style="background-color:<?php echo $size_color; ?>; float:left" >
                        <?php
                        if (!empty($res3)) {
                            if (!empty($r['finish_size_test'])) {
                                //echo '' . $min_size . ', &nbsp;&nbsp;<b>' . $r['finish_size_test'] . '</b>,&nbsp;&nbsp; ' . $max_size;
                                echo '' . $min_size . ', &nbsp;&nbsp;';
                                echo "<b> <span style='color: $size_color2'>". $r['finish_size_test'] ."<span></b>";
                                echo ',&nbsp;&nbsp; ' . $max_size;
                            } else {
                                echo "<span style='color:red'> Not Tested<span>";
                            }
                        } else {
                            //echo "Spec. Not Found. <br>";
                            if (!empty($r['finish_size_test'])){echo $r['finish_size_test'];}else{echo "<span style='color:red'> Not Tested<span>";}
                        }
                        ?>
                    </td>

                    <td><?php if (isset($r['breaking_load'])) echo $r['breaking_load']; ?></td>
                    <td><?php if (isset($r['uts'])) echo $r['uts']; ?></td>
                    
                    <td><span style="color:<?php echo $ts1_color; ?>"> <?php if (!empty($res3)) {echo $ts_min_ss1 . '-' . $ts_max_ss1;} ?></span></td>
                    <td><span style="color:<?php echo $ts2_color; ?>"> <?php if (!empty($res3)) {echo $ts_min_ss2 . '-' . $ts_max_ss2;} ?></span></td>
                    <td><span style="color:<?php echo $ts3_color; ?>"> <?php if (!empty($res3)) {echo $ts_min_ss3 . '-' . $ts_max_ss3; } ?></span></td>
                    
                    <td><?php if (isset($r['torsion_test'])) echo $r['torsion_test']; ?></td>
                    <td><?php if (isset($r['bend_test'])) echo $r['bend_test']; ?></td>
                    <td><?php if (isset($r['ra_per'])) echo $r['ra_per']; ?></td>
                    <td><?php if (isset($r['scratch_brigitness'])) echo $r['scratch_brigitness']; ?></td>
                    <td><?php if (isset($r['remarks'])) echo $r['remarks']; ?></td>
                    <td>
                        <?php 
                            $type= "";
                            if (!empty($r['baseCoilId2']) and $r['baseCoilId2'] > 0){
                                $type= "Simi";
                            }
                        ?>
                        <a href="<?php base_url() ?>home?Qc/track_finish_rod_form/<?php if (isset($r['id'])) echo $r['id'] ?>/<?php echo $type;?>" target="_blank" class="btn btn-dark">
                            Rod Details
                        </a>
                    </td>
                </tr>
            <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>