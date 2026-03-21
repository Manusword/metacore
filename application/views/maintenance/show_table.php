<div class="table-responsive">
     <h3>Search Report</h3>
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Edit</th>
                <th>Date, Shift</th>
                <th>Type of Work</th>
                <th>Dept</th>
                <th>M/C No</th>
                <th>Critical</th>
                <th>MBD / EBD</th>
                <th>Problem Type</th>
                <th>Problem</th>
                <th>Observation </th>
                <th>Root Cause</th>
                <th>Part Change</th>
                <th>Brk. Date</th>
                <th>Comp. Date</th>
                <th>Status</th>
                <th>Rating</th>
                <th>Attend By</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
          $i=1;
          foreach($res2 as $r)
          {
              if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
              if(isset($r['break_down_date'])){$break_down_date=$this->Base->change_date_dmy($r['break_down_date']);}else{$break_down_date='';}
              if(!empty($r['comp_date']) and $r['comp_date']!='0000-00-00'){$comp_date=$this->Base->change_date_dmy($r['comp_date']);}else{$comp_date='';}
              if(isset($r['break_down_time'])){$break_down_time=$this->Base->change_time_hisa($r['break_down_time']);}else{$break_down_time='';}
              if(!empty($r['comp_time']) and $r['comp_time']!='00:00:00'){ $comp_time=$this->Base->change_time_hisa($r['comp_time']);}else{$comp_time='';}
              /*
              if(!empty($r['comp_time']) and $r['comp_time']!='00:00:00')
              {
                $comp_time=$this->Base->change_time_hisa($r['comp_time']);

                $to1="$break_down_date $break_down_time";
                $from1="$comp_date $comp_time";
                
                $to_time = strtotime($to1);
                $from_time = strtotime($from1);
                $vr= round(abs($to_time - $from_time) / 60,2);
              }else{$comp_time='';$vr='';}
              */

              if(isset($r['breakdown_total_time_in_min'])){ $vr = (int)$r['breakdown_total_time_in_min'];}else{$vr=0;}
          ?>
              <tr>
                  <td><?php echo $i;?>.</td>
                  <td>
                      <a  href="<?php base_url()?>home?Maintenance/add_breakdown/<?php if(isset($r['maint_problem_id']))echo $r['maint_problem_id']?>" target="_blank"   class="btn btn-warning" >
                          <i class="nav-icon i-Pen-2"></i>
                      </a>
                  </td>
                  <td><?php echo $entry_date; if(isset($r['shift']))echo ", ".$r['shift'];?></td>
                  <td><?php if(isset($r['type_of_work']))echo $r['type_of_work'];?> <span class="badge badge-dark"><?php if(isset($r['priority']))echo $r['priority'];?></span></td>
                  <td><?php if(isset($r['dname']))echo $r['dname'];?></td>
                  <td><?php if(isset($r['mname']))echo $r['mname'];?></td>
                  <td><?php if(isset($r['type']))echo $r['type'];?></td>
                  <td><?php if(isset($r['type2']))echo $r['type2'];?></td>
                  <td><?php if(isset($r['problem_name']))echo $r['problem_name'];?></td>
                  <td><?php if(isset($r['problem']))echo $r['problem'];?></td>
                  <td><?php if(isset($r['action_taken']))echo $r['action_taken'];?></td>
                  <td><?php if(isset($r['root_cause']))echo $r['root_cause'];?></td>
                  <td><?php if(isset($r['part_change']))echo $r['part_change'];?></td>
                  <td><?php echo $break_down_date.' '.$break_down_time;;?></td>
                  <td><?php echo $comp_date.' '. $comp_time;?> <span class="badge badge-info"><?php echo $total_time_taken[]=$vr;?> min</span></td>
                 
                  <td>
                    <?php  if(isset($r['active'])){if($r['active']=='Completed'){?><span class="badge badge-success">Completed</span> <?php }}?>
                    <?php  if(isset($r['active'])){if($r['active']=='Pending'){?><span class="badge badge-info">Pending</span> <?php }}?>
                    <?php  if(isset($r['active'])){if($r['active']=='Under Process'){?><span class="badge badge-warning">Under Process</span> <?php }}?>
                    <?php  if(isset($r['active'])){if($r['active']=='Canceled'){?><span class="badge badge-danger">Canceled</span> <?php }}?>
                  </td>                                          
                
                  <td><?php if(isset($r['rating']))echo $avg_rating[] = $r['rating'];?></td>
                  <td><?php if(!empty($r['fname2']) and strlen($r['fname2'])>1){ echo $r['fname2'].' '.$r['lname2']; }else{echo $r['attend_by'];}?></td>
                 
                  
              </tr>
          <?php
          $i++; 
          }
          ?>
          <tr>
              <td>#</td>
                <td colspan="13"></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($total_time_taken))echo $a2=array_sum($total_time_taken);?> minute</td>
                <td colspan="2"></td>          
                <td style="color:black; font-weight:bold"><?php if(!empty($avg_rating))echo $b2=round(array_sum($avg_rating)/count($avg_rating));?></td>
                <td></td>                                      
          </tr>            
        </tbody>
    </table>
</div>















<div class="row">
    
    <div class="col-md-8" style="margin-top:40px;">
        <div class="table-responsive">
             <h3>Type wise</h3>
             <?php $this->Maintenancemodel->get_breakdwon_type2_wise($res2);?>
        </div>
    </div>

    <div class="col-md-8" style="margin-top:40px;">
        <div class="table-responsive">
            <h3>Machine wise</h3>
            <?php $this->Maintenancemodel->get_breakdwon_machine_wise($res2);?>
        </div>
    </div>

    <div class="col-md-8" style="margin-top:40px;">
        <div class="table-responsive">
             <h3>Problem wise</h3>
             <?php $this->Maintenancemodel->get_breakdwon_problem_wise($res2);?>
        </div>
    </div>

    



    <div class="col-md-8" style="margin-top:40px;">
        <div class="table-responsive">
             <h3>Attend Person wise</h3>
            <table class="table table-bordered table-striped table-sm" id="printed_table">
            <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr>
                        <th>#</th>
                        <th>Attend Person Name</th>
                        <th>Total Minute</th>
                        <th>No of Work</th>
                        
                        <th>Pending</th>
                        <th>Under Process</th>
                        <th>Completed</th>
                        <th>Canceled</th>
                        
                        <th>Avg Rating</th>
                        <th>Efficiency %</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php 
                   
                        $i=1;
                        $total_no_list = array();
                        $total_min_list = array();
                        foreach($res6 as $r)
                        {
                            if(isset($r['total_min'])){ $total_min = (int)$r['total_min'];}else{$total_min=0;}
                            ?>
                            <tr>
                                <td><?php echo $i;?>.</td>
                                 <td><?php if(!empty($r['fname2']) and strlen($r['fname2'])>1){ echo $r['fname2'].' '.$r['lname2']; }else{echo $r['attend_by'];}?></td>
                                <td><?php echo $total_min_list[] = $total_min;?></td>
                                <td><?php if(isset($r['no_of_bk']))echo $total_no_list[] =  $r['no_of_bk'];?></td>

                                <td><?php if(isset($r['pending_count']))echo $pending_count_list[] =  $r['pending_count'];?></td>
                                <td><?php if(isset($r['under_process_count']))echo $under_process_count_list[] =  $r['under_process_count'];?></td>
                                <td><?php if(isset($r['completed_count']))echo $completed_count_list[] =  $r['completed_count'];?></td>
                                <td><?php if(isset($r['canceled_count']))echo $canceled_count_list[] =  $r['canceled_count'];?></td>

                                <td><?php if(isset($r['avg_rating']))echo $avg_rating_list[] =  round($r['avg_rating']);?></td> 
                                <td><?php if(isset($r['efficiency_percent']))echo $efficiency_percent_list[] =  round($r['efficiency_percent']);?></td> 
                            </tr>
                            <?php
                        $i++; 
                        }
                    ?>
                    <tr style="color:black; font-weight:bold">
                        <td>#</td>
                        <td colspan="">Total</td>
                        <td ><?php if(!empty($total_min_list))echo $a3 = array_sum($total_min_list);?> minute</td> 
                        <td><?php if(!empty($total_no_list))echo $a2 = array_sum($total_no_list);?></td>

                        <td><?php if(!empty($pending_count_list))echo array_sum($pending_count_list);?></td>
                       <td><?php if(!empty($under_process_count_list))echo array_sum($under_process_count_list);?></td>
                       <td><?php if(!empty($completed_count_list))echo array_sum($completed_count_list);?></td>
                       <td><?php if(!empty($canceled_count_list))echo array_sum($canceled_count_list);?></td>

                        <td  colspan=""><?php if(!empty($avg_rating_list))echo $a4 = round(array_sum($avg_rating_list)/count($avg_rating_list));?></td>   
                        <td><?php if(!empty($efficiency_percent_list))echo $a4 = round(array_sum($efficiency_percent_list)/count($efficiency_percent_list));?></td>                 
                    </tr>            
                </tbody>
            </table>
        </div>
    </div>



     <div class="col-md-8" style="margin-top:40px;">
        <div class="table-responsive">
             <h3>Type of Work wise</h3>
            <table class="table table-bordered table-striped table-sm" id="printed_table">
            <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr>
                        <th>#</th>
                        <th>Type of Work</th>
                        <th>Total Minute</th>
                        <th>No of Work</th>

                        <th>Pending</th>
                        <th>Under Process</th>
                        <th>Completed</th>
                        <th>Canceled</th>
                        
                        <th>Avg Rating</th>
                        <th>Efficiency %</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php 
                        $i=1;
                        $total_no_list = array();
                        $total_min_list = array();
                        foreach($res7 as $r) 
                        {
                            if(isset($r['total_min'])){ $total_min = (int)$r['total_min'];}else{$total_min=0;}
                            ?>
                            <tr>
                                <td><?php echo $i;?>.</td>
                                <td><?php if(isset($r['type_of_work']))echo $r['type_of_work'];?></td>
                                <td><?php echo $total_min_list[] = $total_min;?></td>
                                <td><?php if(isset($r['no_of_bk']))echo $total_no_list[] =  $r['no_of_bk'];?></td>

                                <td><?php if(isset($r['pending_count']))echo $pending_count[] =  $r['pending_count'];?></td>
                                <td><?php if(isset($r['under_process_count']))echo $under_process_count[] =  $r['under_process_count'];?></td>
                                <td><?php if(isset($r['completed_count']))echo $completed_count[] =  $r['completed_count'];?></td>
                                <td><?php if(isset($r['canceled_count']))echo $canceled_count[] =  $r['canceled_count'];?></td>

                                <td><?php if(isset($r['avg_rating']))echo $avg_rating_list[] =  round($r['avg_rating']);?></td> 
                                <td><?php if(isset($r['efficiency_percent']))echo $efficiency_percent[] =  round($r['efficiency_percent']);?></td> 
                            </tr>
                            <?php
                        $i++; 
                        }
                    ?>
                    <tr style="color:black; font-weight:bold">
                        <td>#</td>
                        <td colspan="">Total</td>
                        <td  colspan=""><?php if(!empty($total_min_list))echo $a3 = array_sum($total_min_list);?> minute</td> 
                        <td  colspan=""><?php if(!empty($total_no_list))echo $a2 = array_sum($total_no_list);?></td>
                        <td><?php if(!empty($pending_count_list))echo array_sum($pending_count_list);?></td>
                       <td><?php if(!empty($under_process_count_list))echo array_sum($under_process_count_list);?></td>
                       <td><?php if(!empty($completed_count_list))echo array_sum($completed_count_list);?></td>
                       <td><?php if(!empty($canceled_count_list))echo array_sum($canceled_count_list);?></td>

                        <td  colspan="">Avg : <?php if(!empty($avg_rating_list))echo $a4 = round(array_sum($avg_rating_list)/count($avg_rating_list));?></td>   
                        <td><?php if(!empty($efficiency_percent_list))echo $a4 = round(array_sum($efficiency_percent_list)/count($efficiency_percent_list));?></td>                          
                    </tr>            
                </tbody>
            </table>
        </div>
    </div>


    <div class="col-md-12" style="margin-top:40px;">
        <div class="table-responsive">
             <?php $this->Maintenancemodel->get_breakdwon_mc_type2_problem_wise($res2);?>
        </div>
    </div>

</div>