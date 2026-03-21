
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th colspan="12"></th>
                <td colspan="9" align="center" class="dis_td shift_a" >Shift (A)</td>
                <td colspan="9"  align="center" class="dis_td shift_b">Shift (B)</td>
                <th colspan="4"></th>
            </tr>
            <tr>
                <th>#</th>
                <th>Edit</th>
                  <th>Date</th>
                  <th>Dept</th>
                  <th>M/C</th>
                  <th style="width:100px">Base</th>
                  <th>Size</th>
                  <th>Grade</th>
                  <th>Product Type</th>
                  <th>Finish</th>
                  <th>Size</th>
                  <th>Speed</th>
                  
                  <th class="shift_a">Coil</th>
                  <th class="shift_a">Wt.</th>
                  <th class="shift_a">Eff</th>
                  <th class="shift_a">OP</th>
                  <th class="shift_a">H.OP</th>
                  <th class="shift_a">Brk.Down</th>
                  <th class="shift_a">Reason</th>
                  <th class="shift_a">Brk.Hours</th>
                  <th class="shift_a">Run.Hours</th>
                 
                  <th class="shift_b">Coil</th>
                  <th class="shift_b">Wt.</th>
                  <th class="shift_b">Eff</th>
                  <th class="shift_b">OP</th>
                  <th class="shift_b">H.OP</th>
                  <th class="shift_b">Brk.Down</th>
                  <th class="shift_b">Reason</th>
                  <th class="shift_b">Brk.Hours</th>
                  <th class="shift_b">Run.Hours</th>
                  
                  
                  <th>Coil</th>
                  <th>Wt.</th>
                  <th>Unit</th>
                  <th>Eff</th>
                  
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
                        <a  href="<?php base_url()?>home?Production/add/<?php if(isset($r['production_id']))echo $r['production_id']?>" target="_blank"   class="btn btn-warning" >
                            <i class="nav-icon i-Pen-2"></i>
                        </a>
                    </td>
                    <td><?php echo $entry_date;?></td>
                    <td><?php if(isset($r['dept_name']))echo $r['dept_name'];?></td>
                    <td><?php if(isset($r['mc_name']))echo $r['mc_name'];?></td>
                    <td width="100"><?php if(isset($r['in_product_name']))echo $r['in_product_name'];?></td>
                    <td><?php if(isset($r['in_size']))echo $r['in_size'];?></td>
                    <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                    <td><?php if(isset($r['product_type_name']))echo $r['product_type_name'];?></td>
                    <td><?php if(isset($r['out_product_name']))echo $r['out_product_name'];?></td>
                    <td><?php if(isset($r['out_size']))echo $r['out_size'];?></td>
                    <td><?php if(isset($r['mc_speed']))echo $r['mc_speed'];?></td>
                    
                    <td><?php if(isset($r['no_of_spool1']))echo $t1[] = $r['no_of_spool1'];?></td>
                    <td style="font-weight:bold"><?php if(isset($r['qty1']))echo $t2[] = $r['qty1'];?></td>
                    <td><?php if(isset($r['effi1']))echo $t3[] = $r['effi1'];echo "%";?></td>
                    <td><?php if(isset($r['op_name1'])){echo $r['op_name1'];}else{echo $r['operator_id_1'];}?></td>
                    <td><?php if(isset($r['helper1'])){echo $r['helper1'];}else{echo $r['helper1'];}?></td>
                    <td><?php if(isset($r['down_type1']))echo $r['down_type1'];?></td>
                    <td><?php if(isset($r['down_reason1']))echo $r['down_reason1'];?></td>
                    <td><?php if(isset($r['down_total_time1']))echo $t4[] = $r['down_total_time1'];?></td>
                    <td><?php if(isset($r['running_hours_1']))echo $t14[] = $r['running_hours_1'];?></td>
                   
                    
                    <td><?php if(isset($r['no_of_spool2']))echo $t5[] = $r['no_of_spool2'];?></td>
                    <td style="font-weight:bold"><?php if(isset($r['qty2']))echo $t6[] = $r['qty2'];?></td>
                    <td><?php if(isset($r['effi2']))echo $t7[] = $r['effi2'];echo "%";?></td>
                    <td><?php if(isset($r['op_name2'])){echo $r['op_name2'];}else{echo $r['operator_id_2'];}?></td>
                    <td><?php if(isset($r['helper2'])){echo $r['helper2'];}else{echo $r['helper2'];}?></td>
                    <td><?php if(isset($r['down_type2']))echo $r['down_type2'];?></td>
                    <td><?php if(isset($r['down_reason2']))echo $r['down_reason2'];?></td>
                    <td><?php if(isset($r['down_total_time2']))echo $t8[] = $r['down_total_time2'];?></td>
                    <td><?php if(isset($r['running_hours_2']))echo $t16[] = $r['running_hours_2'];?></td>
                    
                    <td><?php if(isset($r['total_spool']))echo $t9[] = $r['total_spool'];?></td>
                    <td style="font-weight:bold"><?php if(isset($r['total_qty']))echo $t10[] = $r['total_qty'];?></td>
                    <td><?php if(isset($r['unit_name']))echo $r['unit_name'];?></td>
                    <td><?php if(isset($r['total_eff']))echo $t11[] = $r['total_eff'];echo "%";?></td>
                   
                </tr>
            <?php
            $i++; 
            }
            ?>
            <tr>
              <td>#</td>
              <td></td>   
                <td colspan="10"></td>
                <td class="shift_a"><?php if(!empty($t1))echo $a1 = array_sum($t1);?> coil</td>
                <td class="shift_a" style="font-weight:bold"><?php if(!empty($t2))echo $a2 = array_sum($t2);?> Wt.</td>
                <td class="shift_a"><?php if(!empty($t3)){$a3 = array_sum($t3); if($a3>0){  echo round($a3/count($t3));echo "%";} }?></td>
                <td class="shift_a"></td>
                <td class="shift_a"></td>
                <td class="shift_a"></td>
                <td class="shift_a"></td>
                <td class="shift_a"><?php if(!empty($t4))echo $a4 = array_sum($t4);?> Hours</td>
                <td class="shift_a"><?php if(!empty($t14))echo $a14 = array_sum($t14);?> Hours</td>
                
                <td class="shift_b"><?php if(!empty($t5))echo $a5 = array_sum($t5);?> coil</td>
                <td class="shift_b" style="font-weight:bold"><?php if(!empty($t6))echo $a6 = array_sum($t6);?> Wt.</td>
                <td class="shift_b"><?php if(!empty($t7)){$a7 = array_sum($t7); if($a7>0){  echo round($a7/count($t7));echo "%";} }?></td>
                <td class="shift_b"></td>
                <td class="shift_b"></td>
                <td class="shift_b"></td>
                <td class="shift_b"></td>
                <td class="shift_b"><?php if(!empty($t8))echo $a8 = array_sum($t8);?> Hours</td>
                <td class="shift_b"><?php if(!empty($t16))echo $a16 = array_sum($t16);?> Hours</td>
                
                <td><?php if(!empty($t9))echo $a9 = array_sum($t9);?> Coil</td>
                <td style="font-weight:bold"><?php if(!empty($t10))echo $a10 = array_sum($t10);?> Wt.</td>
                <td></td>
                <td><?php if(!empty($t11)){$a11 = array_sum($t11); if($a11>0){  echo round($a11/count($t11));echo "%";} }?></td>
                
                                                     
            </tr>            
        </tbody>
    </table>

    <?php 
        $this->Productionmodel->get_all_emp_ef_between_date($fdate,$tdate);
        $this->Productionmodel->get_all_machine_ef_between_date($fdate,$tdate);
    ?>
</div>