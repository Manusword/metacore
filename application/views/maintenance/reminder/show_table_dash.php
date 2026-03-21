<style>
/* ===== REMINDER DASHBOARD CARD ===== */
.reminder-box{
    max-height:180px;
    overflow-y:auto;
}

.reminder-row{
    display:flex;
    justify-content:space-between;
    padding:8px 6px;
    border-bottom:1px dashed #ddd;
}

.reminder-row:last-child{
    border-bottom:none;
}

.reminder-left{
    flex:1;
    min-width:0;
}

.task{
    font-size:14px;
    font-weight:600;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.meta{
    font-size:11px;
    color:#666;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.reminder-right{
    min-width:95px;
    text-align:right;
    font-size:11px;
}

.next-date{
    color:#007bff;
    font-size:11px;
    margin-top:2px;
}
</style>


   
       

<!-- REMINDER CARD -->
<div class="card-body p-2">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header py-2 d-flex justify-content-between align-items-center">
            <span>⏰ Upcoming Reminders</span>
            <a href="<?php base_url()?>home?Maintenance/list_reminder" target="_blank"
                class="btn btn-sm btn-dark">
                View All
            </a>
        </div>

        <!-- BODY -->
        <div class="card-body p-2 reminder-box">

            <?php 
            $login_emp_id = $this->session->userdata('login_emp_id');
            if(!empty($res2)){ foreach($res2 as $r){

                $event_date = !empty($r['event_date']) ? $this->Base->change_date_dmy($r['event_date']) : '';
                $next_date  = !empty($r['next_event_date']) ? $this->Base->change_date_dmy($r['next_event_date']) : '';

                $priorityClass='secondary';
                if($r['priority']=='Low') $priorityClass='info';
                if($r['priority']=='Medium') $priorityClass='warning';
                if($r['priority']=='High' || $r['priority']=='Urgent') $priorityClass='danger';

                $statusClass='secondary';
                if($r['status']=='Completed') $statusClass='success';
                if($r['status']=='Pending') $statusClass='info';
                if($r['status']=='Under Process') $statusClass='warning';
                if($r['status']=='Canceled') $statusClass='danger';
            ?>

                    <div class="reminder-row">
                        <div class="reminder-left">
                        <?php 
                        if($r['save_by'] == $login_emp_id){
                        ?>    
                            <a target="_blank" href="<?php base_url()?>home?Maintenance/add_reminder/<?php if(isset($r['reminder_id']))echo $r['reminder_id']?>" class="text-dark">    
                                <div class="task"><?= !empty($r['task']) ? $r['task'] : '' ?></div>
                            </a>
                        <?php }else{?>
                             <div class="task"><?= !empty($r['task']) ? $r['task'] : '' ?></div>
                        <?php }?>
                            <div class="meta">
                                <?= $event_date ?>
                                <?php if(!empty($r['dname'])) echo ' | '.$r['dname']; ?>
                                <?php if(!empty($r['mname'])) echo ' | M/C '.$r['mname']; ?>
                            </div>
                        </div>

                        <div class="reminder-right">
                            <span class="badge badge-<?= $priorityClass ?>">
                                <?= $r['priority'] ?>
                            </span><br>

                            <span class="badge badge-<?= $statusClass ?>">
                                <?= $r['status'] ?>
                            </span>

                            <?php if($next_date){ ?>
                                <div class="next-date"><?= $next_date ?></div>
                            <?php } ?>
                        </div>
                    </div>

            <?php }}else{ ?>

            <div class="text-center text-muted py-3">
                No reminders available
            </div>

            <?php } ?>

        </div>
    </div>

</div>


