
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Dept</th>
                <th>M/C</th>
                <th>Capstan</th>
                <th>Max Speed (RPM)</th>
                <th>Min-Max Base Size (MM)</th>
                <th>Min-Max Finish Size (MM)</th>
                <th>Status</th>
                <th>Display</th>
                <th>Edit</th>
            </tr>
        </thead>    
        <tbody>
        <?php 
        $i=1;
        foreach($res2 as $r)
        {
            ?>
            <tr>
                <td><?php echo $i;?>.</td>
                <td><?php if(!empty($r['dname']))echo $r['dname'];?></td>
                <td><?php if(!empty($r['name']))echo $r['name'];?></td>
                <td><?php if(!empty($r['capstan']))echo $r['capstan'];?></td>
                <td><?php if(!empty($r['max_speed']))echo $r['max_speed'];?></td>
                <td><?php if(!empty($r['min_base_size']) and !empty($r['max_base_size']))echo '('.$r['min_base_size'].' - '.$r['max_base_size'].')';?></td>
                <td><?php if(!empty($r['min_finish_size']) and !empty($r['max_finish_size']))echo '('.$r['min_finish_size'].' - '.$r['max_finish_size'].')';?></td>
                <td>
                    <?php  if($r['status']=='Working'){?><span class="badge badge-success">Working</span> <?php }?>
                    <?php  if($r['status']=='Under Maintenance'){?><span class="badge badge-warning">Under Maintenance</span> <?php }?>
                    <?php  if($r['status']=='Rejected'){?><span class="badge badge-danger">Rejected</span> <?php }?>
                </td>
                <td>
                    <?php  if($r['hide_status']==1){?><span class="badge badge-danger">No</span> <?php }?>
                    <?php  if($r['status'] == 0){?><span class="badge badge-success">Yes</span> <?php }?>
                </td>
                <td>
                    <a  href="<?php base_url()?>home?Machine/add/<?php if(isset($r['mc_id']))echo $r['mc_id']?>" target="_blank"   class="btn btn-warning" >
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