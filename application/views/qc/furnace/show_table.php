<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                
                <th>Date</th>
                <th>Size</th>
                <th>Grade</th>
                <th>Lotno</th>
                <th>Coil No</th>
                <th>Base Size</th>
                <th>Finish Size</th>
                
                <th>B.L</th>
                <th>UtS</th>
                <th>Zinc</th>
                <th>Ra%</th>
                <th>Temp.</th>
                <th>Speed</th>
                <th>Remarks</th>
                <th>Edit</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
            $i=1;
            foreach($res2 as $r)
            {
                $entry_date=$this->Base->change_date_dmy($r['entry_date']);
                ?>
                <tr>
                        <td><?php  echo $i;?>.</td>
                        
                        <td><?php echo $entry_date;?></td>
                        <td><?php if(isset($r['actual_size']))echo $r['actual_size'];?></td>
                        <td><?php if(isset($r['gname']))echo $r['gname'];?></td>
                        <td><?php if(isset($r['lotno']))echo $r['lotno'];?></td>
                        <td><?php if(isset($r['new_coil_no']))echo $r['new_coil_no'];?></td>
                        <td><?php if(isset($r['base_size']))echo $r['base_size'];?></td>
                        <td><?php if(isset($r['finish_size']))echo $r['finish_size'];?></td>
                        <td><?php if(isset($r['bl']))echo $r['bl'];?></td>
                        <td><?php if(isset($r['uts']))echo $r['uts'];?></td>
                        <td><?php if(isset($r['zinc']))echo $r['zinc'];?></td>
                        <td><?php if(isset($r['ra']))echo $r['ra'];?></td>
                        <td><?php if(isset($r['temp']))echo $r['temp'];?></td>
                        <td><?php if(isset($r['speed']))echo $r['speed'];?></td>
                        <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
                        <td>
                            <a  href="<?php base_url()?>home?Qc/furnace_add/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                                <i class="nav-icon i-Pen-2"></i>
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