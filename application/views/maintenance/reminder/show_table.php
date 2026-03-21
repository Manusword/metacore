<div class="table-responsive">
   <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                
                <th>1st Event Date</th>
                <th>From</th>
                <th>Task</th>
               
                <th>Priority</th>
                <th>Dept</th>
                <th>M/C No</th>
                <th>Status</th>
                 <th>Next Event Date</th>
                <th>Repeat</th>
                <th>Visible To</th>
                 <th>Remarks</th>
                <th>Edit</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
          
                $i=1;
                foreach($res2 as $r)
                {
                        if(isset($r['event_date'])){$event_date=$this->Base->change_date_dmy($r['event_date']);}else{$event_date='';}
                        if(isset($r['next_event_date'])){$next_event_date=$this->Base->change_date_dmy($r['next_event_date']);}else{$next_event_date='';}
                        ?>
                        <tr <?php if(isset($r['priority'])){if($r['priority']=='Urgent'){ echo "style='color:red'"; }}?>>
                            <td><?php echo $i;?>.</td>
                        
                            <td><?php echo $event_date;?></td>
                           
                            <td>
                                <?php if(isset($r['location']))
                                {
                                    if($r['location'] == "Customer"){
                                        ?> <b style="color: blue;"><?php if(!empty($r['cname']))echo $r['cname']; ?></b>  <?php
                                    }else{
                                       echo $r['location']; 
                                    }
                                }
                                ?>
                            </td>
                            <td><?php if(isset($r['task']))echo $r['task'];?></td>
                           
                            <td>
                                <?php  if(isset($r['priority'])){if($r['priority']=='Low'){?><span class="badge badge-info">Low</span> <?php }}?>
                                <?php  if(isset($r['priority'])){if($r['priority']=='Medium'){?><span class="badge badge-warning">Medium</span> <?php }}?>
                                <?php  if(isset($r['priority'])){if($r['priority']=='High'){?><span class="badge badge-danger">High</span> <?php }}?>
                                <?php  if(isset($r['priority'])){if($r['priority']=='Urgent'){?><span class="badge badge-danger">Urgent</span> <?php }}?>
                            </td>
                            <td><?php if(isset($r['dname']))echo $r['dname'];?></td>
                            <td><?php if(isset($r['mname']))echo $r['mname'];?></td>
                            
                            <td>
                                <?php  if(isset($r['status'])){if($r['status']=='Completed'){?><span class="badge badge-success">Completed</span> <?php }}?>
                                <?php  if(isset($r['status'])){if($r['status']=='Pending'){?><span class="badge badge-info">Pending</span> <?php }}?>
                                <?php  if(isset($r['status'])){if($r['status']=='Under Process'){?><span class="badge badge-warning">Under Process</span> <?php }}?>
                                <?php  if(isset($r['status'])){if($r['status']=='Canceled'){?><span class="badge badge-danger">Canceled</span> <?php }}?>
                            </td>                                          
                             <td style="color:blue"><?php echo $next_event_date;?></td>
                            <td><?php if(isset($r['repeat_status']))echo $r['repeat_status'];?></td>
                            <td>
                                <?php  
                                    if(isset($r['show_to'])){
                                        if($r['show_to']=='Everyone'){ echo "Everyone";}else{echo "Me";}
                                    } 
                                ?>
                            </td>
                             <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
                            <td>
                                <a  href="<?php base_url()?>home?Maintenance/add_reminder/<?php if(isset($r['reminder_id']))echo $r['reminder_id']?>" target="_blank"   class="btn btn-warning" >
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
