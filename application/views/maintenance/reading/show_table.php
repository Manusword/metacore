<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                  <th>Entry Date</th>
                  <th>Dept</th>
                  <th>M/C No</th>
                  <th>Meater Reading</th>
                  <th>Edit</th>
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
                        <td><?php echo $entry_date;?></td>
                        <td><?php if(isset($r['dname']))echo $r['dname'];?></td>
                        <td><?php if(isset($r['mname']))echo $r['mname'];?></td>
                        <td><?php if(isset($r['meter_reading']))echo $total_reading[] = $r['meter_reading'];?></td>
                        <td>
                            <a  href="<?php base_url()?>home?Maintenance/add_meter_reading/<?php if(isset($r['entry_date']))echo $r['entry_date'];?>" target="_blank"   class="btn btn-warning" >
                                <i class="nav-icon i-Pen-2"></i>
                            </a>
                        </td>
                    </tr>
                <?php
        $i++; 
        }
        ?>
          <tr>
              <td>#</td>
                <td colspan="3"></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($total_reading))echo $a2=array_sum($total_reading);?></td>
                <td></td>                                         
          </tr>            
        </tbody>
    </table>
</div>