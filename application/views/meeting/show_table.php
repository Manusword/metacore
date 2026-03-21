<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Entry Date</th>
                <th>Participants</th>
                <th>Review Points</th>
                <th>Current Status</th>
                <th>Action Taken</th>
                <th>RESP</th>
                <th>Target Date</th>
                <th>Completed Date</th>
                <th>Status</th>
                <th>MD</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
		   <?php 
            $i=1;
            foreach($res2 as $r)
            {
                if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
                if(isset($r['target_date'])){$target_date=$this->Base->change_date_dmy($r['target_date']);}else{$target_date='';}
                if(!empty($r['comp_date']) and $r['comp_date'] !='0000-00-00'){ $comp_date=$this->Base->change_date_dmy($r['comp_date']);}else{$comp_date='';}
                ?>
                <tr>
                    <td><?php echo $i;?>.</td>
                    <td><?php echo $entry_date;?></td>
                    <td><?php if(isset($r['participants']))echo $r['participants'];?></td>
                    <td><?php if(isset($r['review']))echo $r['review'];?></td>
                    <td><?php if(isset($r['current_status']))echo $r['current_status'];?></td>
                    <td><?php if(isset($r['action_taken']))echo $r['action_taken'];?></td>
                    <td><?php if(isset($r['resp']))echo $r['resp'];?></td>
                    <td><?php echo $target_date;?></td>
                    <td><?php echo $comp_date;?></td>
                    <td>
                        <?php  if(isset($r['status'])){if($r['status']=='Completed'){?><span class="badge badge-success">Completed</span> <?php }}?>
                        <?php  if(isset($r['status'])){if($r['status']=='Pending'){?><span class="badge badge-danger">Pending</span> <?php }}?>
                        <?php  if(isset($r['status'])){if($r['status']=='Under Progress'){?><span class="badge badge-warning">Under Progress</span> <?php }}?>
                    </td>                                          
                    <td><?php if(isset($r['md_review']))echo $r['md_review'];?></td>
                    <td>
                        <a  href="<?php base_url()?>home?Meeting/add/<?php if(isset($r['mom_id']))echo $r['mom_id']?>" target="_blank"   class="btn btn-warning" >
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