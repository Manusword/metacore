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
                  <th>Emp. Code</th>
                  <th>Name</th>
                  <th>Dept.</th>
                  <th>Shift</th>
                  <th>In Punch Time</th>
                  <th>Time Diff</th>
                  <th>Status</th>
                  <th>Out Punch Time</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
           
            $i=1;
            foreach($res2 as $r)
            {
                if(isset($r['in_time'])){$in_time=$this->Base->change_date_dmy_hisa($r['in_time']);}else{$in_time='';}
                if(isset($r['shift_out_time2'])){$shift_out_time2=$this->Base->change_date_dmy_hisa($r['shift_out_time2']);}else{$shift_out_time2='';}
                $out_time = $this->Base->change_date_dmy_hisa($this->Base->add_no_of_hours_in_date_ymd($in_time,8));
                if($r['in_status'] == 'L' and $r['in_min_late_early']>10){$color="#f2d37c";}else{$color="";}
            ?>
                <tr  style="background-color:<?php if($r['out_time_mc'] == '0000-00-00 00:00:00' and $r['shift_in_time'] < date('Y-m-d 00:00:00') ){echo "#f5e7bf";}?>;
                        color:<?php if($r['in_min_late_early'] >180 OR $r['out_min_late_early']>180 ){echo "red";}?>;">
                    <td>
                        <?php echo $i;?>.
                        <br>
                            <?php 
                                //master roll
                                if(isset($r['mater_roll']) and $r['mater_roll'] == "Yes")
                                { 
                                    ?>
                                        <span class="badge badge-danger">M</span>
                                    <?php
                                }
                            ?>
                    </td> 
                    <td><?php if(isset($r['emp_code']))echo $r['emp_code'];?></td>
                    <td><?php if(isset($r['first_name']))echo $r['first_name'].' '.$r['last_name'];?></td>
                    <td><?php if(isset($r['dname']))echo $r['dname'];?></td>
                    <td>General</td>
                    <td><?php echo $in_time;?></td>
                    <td style="background-color:<?php echo $color;?>"><?php if(isset($r['in_min_late_early']))echo $r['in_min_late_early'];?></td>
                    <td><?php if(isset($r['in_status']))echo $r['in_status'];?></td>
                    <td><?php echo $out_time;?></td>
                </tr>
            <?php
            $i++; 
            }
            ?>
                    
        </tbody>
    </table>
</div>