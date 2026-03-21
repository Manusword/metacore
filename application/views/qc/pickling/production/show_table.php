<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Edit</th>
                <th>Date</th>
                <th>Coil No</th>
                <th>Size</th>
                <th>Grade</th>
                <th>Heat No.</th>
                <th>Other Details</th>
                <th>Lotno</th>
                <th>Rank</th>
                <th>Washing Time</th>
                <th>HCL Time</th>
                <th>Washing2 Time</th>
                <th>PHOS TIME</th>
                <th>Borax TIME</th>
                <th>Sup</th>
                <th>OP</th>
                <th>Helper 1</th>
                <th>Helper 2</th>
                <th>Remarks</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
            $i=1;
            foreach($res2 as $pi)
            {
               if(!empty($pi['entry_date']) and $pi['entry_date'] != "0000-00-00 00:00:00"){ $entry_date = $this->Base->change_date_dmy($pi['entry_date']);}else{$entry_date = ""; }
               if(!empty($pi['washing_time1']) and $pi['washing_time1'] != "0000-00-00 00:00:00"){ $washing_time1 = $this->Base->change_date_dmy_hisa($pi['washing_time1']);}else{$washing_time1 = ""; }
                if(!empty($pi['hcl_in']) and $pi['hcl_in'] != "0000-00-00 00:00:00"){ $hcl_in = $this->Base->change_datetime_hi($pi['hcl_in']);}else{$hcl_in = ""; }
                if(!empty($pi['hcl_out']) and $pi['hcl_out'] != "0000-00-00 00:00:00"){ $hcl_out = $this->Base->change_datetime_hi($pi['hcl_out']);}else{$hcl_out = ""; }

                if(!empty($pi['washing_time2']) and $pi['washing_time2'] != "0000-00-00 00:00:00"){ $washing_time2 = $this->Base->change_datetime_hi($pi['washing_time2']);}else{$washing_time2 = ""; }
                if(!empty($pi['phos_in']) and $pi['phos_in'] != "0000-00-00 00:00:00"){ $phos_in = $this->Base->change_datetime_hi($pi['phos_in']);}else{$phos_in = ""; }
                if(!empty($pi['phos_out']) and $pi['phos_out'] != "0000-00-00 00:00:00"){ $phos_out = $this->Base->change_datetime_hi($pi['phos_out']);}else{$phos_out = ""; }
                if(!empty($pi['borax_in']) and $pi['borax_in'] != "0000-00-00 00:00:00"){ $borax_in = $this->Base->change_datetime_hi($pi['borax_in']);}else{$borax_in = ""; }
                if(!empty($pi['borax_out']) and $pi['borax_out'] != "0000-00-00 00:00:00"){ $borax_out = $this->Base->change_datetime_hi($pi['borax_out']);}else{$borax_out = ""; }
                ?>
                <tr>
                        <td><?php  echo $i;?>.</td>
                         <td>
                            <a  href="<?php base_url()?>home?Qc/pickling_production_entry2/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                                <i class="nav-icon i-Pen-2"></i>
                            </a>
                        </td>
                        <td><?php echo $entry_date;?></td>
                        <td><?php  if(!empty($pi['coil_no'])) echo $pi['coil_no'];?></td>
                        <td><?php  if(!empty($pi['finish_size'])) echo $pi['finish_size'];?></td>
                        <td><?php  if(!empty($pi['gname'])) echo $pi['gname'];?></td>
                        <td><?php  if(!empty($pi['heat_no'])) echo $pi['heat_no'];?></td>
                        <td><?php  if(!empty($pi['other_details'])) echo $pi['other_details'];?></td>
                        <td><?php  if(!empty($pi['lotname'])) echo $pi['lotname'];?></td>
                        <td><?php  if(!empty($pi['rank'])) echo $pi['rank'];?></td>
                       
                        <td><?php echo $washing_time1;?></td>
                        <td>
                            <?php echo $hcl_in;?>-<?php echo $hcl_out;?> <br> 
                            <span style="color:blueviolet"><?php if(!empty($pi['hcl_total_time']) and $pi['hcl_total_time']>0) echo $hcl_total_time[] = $pi['hcl_total_time']?> min</span>
                        </td>
                        <td>
                            <?php echo $washing_time2;?> <br> <span style="color:blueviolet">
                            <?php if(!empty($pi['washing2_total_time'])  and $pi['washing2_total_time']>0) echo $washing2_total_time[] = $pi['washing2_total_time']?> min</span>
                        </td>
                        <td>
                            <?php echo $phos_in;?>-<?php echo $phos_out;?> <br> 
                            <span style="color:blueviolet"><?php if(!empty($pi['phos_total_time'])  and $pi['phos_total_time']>0) echo $phos_total_time[] = $pi['phos_total_time']?> min</span>
                        </td>
                        <td>
                            <?php echo $borax_in;?>-<?php echo $borax_out;?> <br> 
                            <span style="color:blueviolet"><?php if(!empty($pi['borax_total_time'])  and $pi['borax_total_time']>0) echo $borax_total_time[] = $pi['borax_total_time']?> min</span>
                        </td>
                        <td><?php  if(!empty($pi['sup_id'])) echo $pi['sup_id'];?></td>
                        <td><?php  if(!empty($pi['op_id'])) echo $pi['op_id'];?></td>
                        <td><?php  if(!empty($pi['hel1_id'])) echo $pi['hel1_id'];?></td>
                        <td><?php  if(!empty($pi['hel2_id'])) echo $pi['hel2_id'];?></td>
                        <td><?php  if(!empty($pi['remarks'])) echo $pi['remarks'];?></td>
                </tr>
            <?php
            $i++; 
            }
          ?>
                  <tr style="color:blueviolet; font-weight:bold">
                    <td colspan="11">Avg Time.</td>
                    <td  colspan=""><?php if(!empty($hcl_total_time))echo $a4 = round(array_sum($hcl_total_time)/count($hcl_total_time));?> min</td> 
                    <td  colspan=""><?php if(!empty($washing2_total_time))echo $a4 = round(array_sum($washing2_total_time)/count($washing2_total_time));?> min</td> 
                    <td  colspan=""><?php if(!empty($phos_total_time))echo $a4 = round(array_sum($phos_total_time)/count($phos_total_time));?> min</td>
                    <td  colspan=""><?php if(!empty($borax_total_time))echo $a4 = round(array_sum($borax_total_time)/count($borax_total_time));?> min</td>
                    <td colspan="5"></td>
                  </tr>
        </tbody>
    </table>
</div>