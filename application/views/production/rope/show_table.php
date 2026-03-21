<div class="table-responsive" style="overflow:auto;">
    <table class="table table-bordered table-striped table-sm"  id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                    <th>#</th>
                    <th>Edit</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>M/C</th>
                    
                    <th>Size</th>
                    <th>Operation</th>
                    <th>Type</th>
                    <th>Construction</th>
                    <th>Grade</th>
                    <th>WT/Mtr</th>
                    <th>Speed (RPM)</th>
                  
                    <th>Pitch</th>
                    <th>Line Speed</th>
                    <th>Capacity</th>

                    <th>Target 100%</th>
                    <th>Qty (mtr)</th>
                    <th>Qty (kgs)</th>
                    <th>Eff %</th>
                    <th>Operator</th>
                    <th>Helper</th>
                    
                    <!-- <th>Down Type</th>
                    <th>Down Reason</th>
                    <th>Down (Hours)</th>
                     -->
                    <th>Running (Hours)</th>
                    <th>Scrap (kg)</th>
                    <th>Down Type</th>
                    <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
		    <?php 
            $i=1;
            foreach($res2 as $r)
            {
                if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
                ?>
                <tr>
                    <td><?php echo $i;?>.</td>
                    <td>
                        <a  href="<?php base_url()?>home?Production/rope_pro_add/<?php if(isset($r['production_id']))echo $r['production_id']?>" target="_blank"   class="btn btn-warning" >
                            <i class="nav-icon i-Pen-2"></i>
                        </a>
                    </td>
                    <td><?php echo $entry_date;?></td>
                    <td><?php if(isset($r['shift1']))echo $r['shift1'];?></td>
                    <td><?php if(isset($r['mc_name']))echo $r['mc_name'];?></td>

                    <td><?php if(isset($r['size']))echo $r['size'];?></td>
                    <td><?php if(isset($r['operation']))echo $r['operation'];?></td>
                    <td><?php if(isset($r['type']))echo $r['type'];?></td>
                    <td><?php if(isset($r['construction']))echo $r['construction'];?></td>
                    <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                   
                    <td><?php if(isset($r['wt_mt']))echo $r['wt_mt'];?></td>
                    <td><?php if(isset($r['mc_speed']))echo $r['mc_speed'];?></td>

                    <td><?php if(isset($r['pitch']))echo $r['pitch'];?></td>
                    <td><?php if(isset($r['line_speed']))echo $r['line_speed'];?></td>
                    <td><?php if(isset($r['mc_capacity']))echo $r['mc_capacity'];?></td>
                    <td><?php if(isset($r['target']))echo $r['target'];?></td>
                    <td><?php if(isset($r['qty_in_meter']))echo $t1[] = $r['qty_in_meter'];?></td>
                    <td><?php if(isset($r['qty_in_kg']))echo  $t2[] =  $r['qty_in_kg'];?></td>
                    <td><?php if(isset($r['eff1']) and (int)$r['eff1'] > 0){echo  $t3[] =  $r['eff1']; echo " %";}?> </td>
                    <td><?php if(!empty($r['op_name'])){echo $r['op_name'];}else{echo $r['operator1'];}?></td>
                    <td><?php if(!empty($r['hp_name'])){echo $r['hp_name'];}else{echo $r['helper1'];}?></td>
                    <td><?php if(isset($r['running_hours_1']))echo $t4[] = $r['running_hours_1'];?></td>
                    <td><?php if(isset($r['scrap']))echo $t5[] = $r['scrap'];?></td>
                    <td><?php if(isset($r['down_type1'])){echo $r['down_type1'];}?></td>
                    <td><?php if(isset($r['remarks'])){echo $r['remarks'];}?></td>
                </tr>
            <?php
            $i++; 
            }
            ?>
            <tr>
              <td>#</td>
              <td></td>   
                <td colspan="14"></td>
                <td ><?php if(!empty($t1))echo $a1 = array_sum($t1);?> mtr</td>
                <td ><?php if(!empty($t2))echo $a2 = array_sum($t2);?> kgs</td>
                <td ><?php if(!empty($t3)){$a3 = array_sum($t3); if($a3>0){  echo round($a3/count($t3));echo "%";} }?></td>
                <td colspan="3"></td>
                <td ><?php  if(!empty($t5))echo $a5 = array_sum($t5);?> kgs</td>
                <td></td>  
                <td></td> 
            </tr>            
        </tbody>
    </table>
</div>


<style>

    .newtable {
        width:29%; 
        margin-left:3%; 
        float:left;
    }
        
</style>


           
                    <div style="margin-top:50px; width:100%;">

 <!-- Shift wise -->
                                    <table class="table table-bordered table-striped table-sm newtable"  >
                                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                            <tr>
                                                <th colspan="6">Shift Wise</th>
                                            </tr>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Shift</th>
                                                <th>Qty (mtr)</th>
                                                <th>Qty (kgs)</th>
                                                <th>Eff %</th>
                                                <th>Scrap</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=1;
                                                $mtr = array();
                                                $kgs = array();
                                                $eff = array();
                                                $scrap = array();
                                                foreach($res_shift as $r)
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?>.</td>
                                                            <td><?php if(isset($r['shift1']))echo $r['shift1'];?></td>
                                                            <td><?php if(isset($r['mtr']))echo $mtr[] = round($r['mtr'],1);?></td>
                                                            <td><?php if(isset($r['kgs']))echo $kgs[] = round($r['kgs'],1);?></td>
                                                            <td><?php if(isset($r['eff'])){echo $eff[] = round($r['eff']); echo " %";}?></td>
                                                            <td><?php if(isset($r['scrap']))echo $scrap[] = round($r['scrap'],1);?></td>
                                                        </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>   
                                                <td ><?php if(!empty($mtr))echo $a1 = array_sum($mtr);?> mtr</td>
                                                <td ><?php if(!empty($kgs))echo $a2 = array_sum($kgs);?> kgs</td>
                                                <td ><?php if(!empty($eff)){$a3 = array_sum($eff); if($eff>0){  echo round($a3/count($eff));echo "%";} }?></td>
                                                <td ><?php if(!empty($scrap))echo $a4 = array_sum($scrap);?> kgs</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                </div>



                                <div style="margin-top:50px; width:100%;">
<!-- Machine wise -->
                               
                                    <table class="table table-bordered table-striped table-sm newtable"  >
                                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                            <tr>
                                                <th colspan="6">Machine Wise</th>
                                            </tr>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Machine</th>
                                                <th>Qty (mtr)</th>
                                                <th>Qty (kgs)</th>
                                                <th>Eff %</th>
                                                <th>Scrap</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=1;
                                                $mtr = array();
                                                $kgs = array();
                                                $eff = array();
                                                $scrap = array();
                                                foreach($res_mc as $r)
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?>.</td>
                                                            <td><?php if(isset($r['mc_name']))echo $r['mc_name'];?></td>
                                                            <td><?php if(isset($r['mtr']))echo $mtr[] = round($r['mtr'],1);?></td>
                                                            <td><?php if(isset($r['kgs']))echo $kgs[] = round($r['kgs'],1);?></td>
                                                            <td><?php if(isset($r['eff'])){echo $eff[] = round($r['eff']); echo " %";}?></td>
                                                            <td><?php if(isset($r['scrap']))echo $scrap[] = round($r['scrap'],1);?></td>
                                                        </tr>
                                                   <?php
                                                    $i++;
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>   
                                                <td ><?php if(!empty($mtr))echo $a1 = array_sum($mtr);?> mtr</td>
                                                <td ><?php if(!empty($kgs))echo $a2 = array_sum($kgs);?> kgs</td>
                                                <td ><?php if(!empty($eff)){$a3 = array_sum($eff); if($eff>0){  echo round($a3/count($eff));echo "%";} }?></td>
                                                <td ><?php if(!empty($scrap))echo $a4 = array_sum($scrap);?> kgs</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                               

<!-- Size wise -->
                                <div style="margin-top:50px; width:100%;">
                                    <table class="table table-bordered table-striped table-sm newtable"  >
                                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                            <tr>
                                                <th colspan="6">Size Wise</th>
                                            </tr>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Size</th>
                                                <th>Qty (mtr)</th>
                                                <th>Qty (kgs)</th>
                                                <th>Eff %</th>
                                                <th>Scrap</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=1;
                                                $mtr = array();
                                                $kgs = array();
                                                $eff = array();
                                                $scrap = array();
                                                foreach($res_size as $r)
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?>.</td>
                                                            <td><?php if(isset($r['size']))echo $r['size'];?></td>
                                                            <td><?php if(isset($r['mtr']))echo $mtr[] = round($r['mtr'],1);?></td>
                                                            <td><?php if(isset($r['kgs']))echo $kgs[] = round($r['kgs'],1);?></td>
                                                            <td><?php if(isset($r['eff'])){echo $eff[] = round($r['eff']); echo " %";}?></td>
                                                            <td><?php if(isset($r['scrap']))echo $scrap[] = round($r['scrap'],1);?></td>
                                                        </tr>
                                                    <?php 
                                                    $i++;
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>   
                                                <td ><?php if(!empty($mtr))echo $a1 = array_sum($mtr);?> mtr</td>
                                                <td ><?php if(!empty($kgs))echo $a2 = array_sum($kgs);?> kgs</td>
                                                <td ><?php if(!empty($eff)){$a3 = array_sum($eff); if($eff>0){  echo round($a3/count($eff));echo "%";} }?></td>
                                                <td ><?php if(!empty($scrap))echo $a4 = array_sum($scrap);?> kgs</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                               

<!-- Operation wise -->
                                <div style="margin-top:50px; width:100%;">
                                    <table class="table table-bordered table-striped table-sm newtable"   >
                                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                            <tr>
                                                <th colspan="6">Operation Wise</th>
                                            </tr>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Operation</th>
                                                <th>Qty (mtr)</th>
                                                <th>Qty (kgs)</th>
                                                <th>Eff %</th>
                                                <th>Scrap</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=1;
                                                $mtr = array();
                                                $kgs = array();
                                                $eff = array();
                                                $scrap = array();
                                                foreach($res_op as $r)
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?>.</td>
                                                            <td><?php if(isset($r['operation']))echo $r['operation'];?></td>
                                                            <td><?php if(isset($r['mtr']))echo $mtr[] = round($r['mtr'],1);?></td>
                                                            <td><?php if(isset($r['kgs']))echo $kgs[] = round($r['kgs'],1);?></td>
                                                            <td><?php if(isset($r['eff'])){echo $eff[] = round($r['eff']); echo " %";}?></td>
                                                            <td><?php if(isset($r['scrap']))echo $scrap[] = round($r['scrap'],1);?></td>
                                                        </tr>
                                                    <?php 
                                                    $i++;
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>   
                                                <td ><?php if(!empty($mtr))echo $a1 = array_sum($mtr);?> mtr</td>
                                                <td ><?php if(!empty($kgs))echo $a2 = array_sum($kgs);?> kgs</td>
                                                <td ><?php if(!empty($eff)){$a3 = array_sum($eff); if($eff>0){  echo round($a3/count($eff));echo "%";} }?></td>
                                                <td ><?php if(!empty($scrap))echo $a4 = array_sum($scrap);?> kgs</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                               

<!-- Construction wise -->
                                <div style="margin-top:50px; width:100%;">
                                    <table class="table table-bordered table-striped table-sm newtable"   >
                                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                            <tr>
                                                <th colspan="6">Construction Wise</th>
                                            </tr>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Construction</th>
                                                <th>Qty (mtr)</th>
                                                <th>Qty (kgs)</th>
                                                <th>Eff %</th>
                                                <th>Scrap</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=1;
                                                $mtr = array();
                                                $kgs = array();
                                                $eff = array();
                                                $scrap = array();
                                                foreach($res_con as $r)
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?>.</td>
                                                            <td><?php if(isset($r['construction']))echo $r['construction'];?></td>
                                                            <td><?php if(isset($r['mtr']))echo $mtr[] = round($r['mtr'],1);?></td>
                                                            <td><?php if(isset($r['kgs']))echo $kgs[] = round($r['kgs'],1);?></td>
                                                            <td><?php if(isset($r['eff'])){echo $eff[] = round($r['eff']); echo " %";}?></td>
                                                            <td><?php if(isset($r['scrap']))echo $scrap[] = round($r['scrap'],1);?></td>
                                                        </tr>
                                                    <?php
                                                    $i++; 
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>   
                                                <td ><?php if(!empty($mtr))echo $a1 = array_sum($mtr);?> mtr</td>
                                                <td ><?php if(!empty($kgs))echo $a2 = array_sum($kgs);?> kgs</td>
                                                <td ><?php if(!empty($eff)){$a3 = array_sum($eff); if($eff>0){  echo round($a3/count($eff));echo "%";} }?></td>
                                                <td ><?php if(!empty($scrap))echo $a4 = array_sum($scrap);?> kgs</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                


<!-- Grade wise -->
                                <div style="margin-top:50px; width:100%;">
                                    <table class="table table-bordered table-striped table-sm newtable"   >
                                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                            <tr>
                                                <th colspan="6">Grade Wise</th>
                                            </tr>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Grade</th>
                                                <th>Qty (mtr)</th>
                                                <th>Qty (kgs)</th>
                                                <th>Eff %</th>
                                                <th>Scrap</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=1;
                                                $mtr = array();
                                                $kgs = array();
                                                $eff = array();
                                                $scrap = array();
                                                foreach($res_grade as $r)
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?>.</td>
                                                            <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                                                            <td><?php if(isset($r['mtr']))echo $mtr[] = round($r['mtr'],1);?></td>
                                                            <td><?php if(isset($r['kgs']))echo $kgs[] = round($r['kgs'],1);?></td>
                                                            <td><?php if(isset($r['eff'])){echo $eff[] = round($r['eff']); echo " %";}?></td>
                                                            <td><?php if(isset($r['scrap']))echo $scrap[] = round($r['scrap'],1);?></td>
                                                        </tr>
                                                    <?php 
                                                    $i++;
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>   
                                                <td ><?php if(!empty($mtr))echo $a1 = array_sum($mtr);?> mtr</td>
                                                <td ><?php if(!empty($kgs))echo $a2 = array_sum($kgs);?> kgs</td>
                                                <td ><?php if(!empty($eff)){$a3 = array_sum($eff); if($eff>0){  echo round($a3/count($eff));echo "%";} }?></td>
                                                <td ><?php if(!empty($scrap))echo $a4 = array_sum($scrap);?> kgs</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                


<!-- Operator wise -->
                                <div style="margin-top:50px; width:100%;">
                                    <table class="table table-bordered table-striped table-sm newtable"   >
                                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                            <tr>
                                                <th colspan="6">Operator Wise</th>
                                            </tr>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Name</th>
                                                <th>Qty (mtr)</th>
                                                <th>Qty (kgs)</th>
                                                <th>Eff %</th>
                                                <th>Scrap</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=1;
                                                $mtr = array();
                                                $kgs = array();
                                                $eff = array();
                                                $scrap = array();
                                                foreach($res_opman as $r)
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?>.</td>
                                                            <td><?php if(isset($r['op_name']))echo $r['op_name'];?></td>
                                                            <td><?php if(isset($r['mtr']))echo $mtr[] = round($r['mtr'],1);?></td>
                                                            <td><?php if(isset($r['kgs']))echo $kgs[] = round($r['kgs'],1);?></td>
                                                            <td><?php if(isset($r['eff'])){echo $eff[] = round($r['eff']); echo " %";}?></td>
                                                            <td><?php if(isset($r['scrap']))echo $scrap[] = round($r['scrap'],1);?></td>
                                                        </tr>
                                                   <?php
                                                    $i++;
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>   
                                                <td ><?php if(!empty($mtr))echo $a1 = array_sum($mtr);?> mtr</td>
                                                <td ><?php if(!empty($kgs))echo $a2 = array_sum($kgs);?> kgs</td>
                                                <td ><?php if(!empty($eff)){$a3 = array_sum($eff); if($eff>0){  echo round($a3/count($eff));echo "%";} }?></td>
                                                <td ><?php if(!empty($scrap))echo $a4 = array_sum($scrap);?> kgs</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                               

                                <!-- helper wise -->
                                <div style="margin-top:50px; width:100%;">
                                    <table class="table table-bordered table-striped table-sm newtable"   >
                                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                            <tr>
                                                <th colspan="6">Helper Wise</th>
                                            </tr>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Name</th>
                                                <th>Qty (mtr)</th>
                                                <th>Qty (kgs)</th>
                                                <th>Eff %</th>
                                                <th>Scrap</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $i=1;
                                                $mtr = array();
                                                $kgs = array();
                                                $eff = array();
                                                $scrap = array();
                                                foreach($res_helman as $r)
                                                {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i;?>.</td>
                                                            <td><?php if(isset($r['hp_name']))echo $r['hp_name'];?></td>
                                                            <td><?php if(isset($r['mtr']))echo $mtr[] = round($r['mtr'],1);?></td>
                                                            <td><?php if(isset($r['kgs']))echo $kgs[] = round($r['kgs'],1);?></td>
                                                            <td><?php if(isset($r['eff'])){echo $eff[] = round($r['eff']); echo " %";}?></td>
                                                            <td><?php if(isset($r['scrap']))echo $scrap[] = round($r['scrap'],1);?></td>
                                                        </tr>
                                                   <?php
                                                    $i++;
                                                }
                                            ?>
                                            <tr>
                                                <td></td>
                                                <td></td>   
                                                <td ><?php if(!empty($mtr))echo $a1 = array_sum($mtr);?> mtr</td>
                                                <td ><?php if(!empty($kgs))echo $a2 = array_sum($kgs);?> kgs</td>
                                                <td ><?php if(!empty($eff)){$a3 = array_sum($eff); if($eff>0){  echo round($a3/count($eff));echo "%";} }?></td>
                                                <td ><?php if(!empty($scrap))echo $a4 = array_sum($scrap);?> kgs</td>
                                            </tr> 
                                        </tbody>
                                    </table>
                        
                        
                        </div>