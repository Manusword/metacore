<div class="table-responsive">
   <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Emp Code</th>
                <th>Name</th>
                <th>Dept.</th>
                <th>Mobile</th>
                <th>Reason</th>
                <th>Ask From-To</th>
                <th>Approve From-To</th>
                <th>Sup. Status</th>
                <th>Sup. Name</th>
                <th>Status</th>
                <th>Edit</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
           
                $i=1;
                foreach($res2 as $r)
                {
                       
                        if(!empty($r['ask_from_date']) and $r['ask_from_date']!='0000-00-00'){$ask_from_date=$this->Base->change_date_dmy($r['ask_from_date']);}else{$ask_from_date='';}
                        if(!empty($r['ask_to_date']) and $r['ask_to_date']!='0000-00-00'){$ask_to_date=$this->Base->change_date_dmy($r['ask_to_date']);}else{$ask_to_date='';}
                        if(!empty($r['approve_from_date']) and $r['approve_from_date']!='0000-00-00'){$approve_from_date=$this->Base->change_date_dmy($r['approve_from_date']);}else{$approve_from_date='';}
                        if(!empty($r['approve_to_date']) and $r['approve_to_date']!='0000-00-00'){$approve_to_date=$this->Base->change_date_dmy($r['approve_to_date']);}else{$approve_to_date='';}
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i;?></th>
                            <td><?php echo $r['emp_code']?></td>
                            <td><?php echo $r['first_name'].' '.$r['last_name']?></td>
                            <td><?php echo $r['dname']?></td>
                            <td><?php echo $r['mob']?></td>
                            <td><?php echo $r['reason_for']?></td>
                            <td>
                                <?php echo $ask_from_date; ?>
                                ,
                                <?php echo $ask_to_date; ?>
                                <span style="font-size:12px" class="badge badge-light"><?php echo $ask_total_days_list[] = $r['ask_total_days']?></span>
                            </td>

                            <td>
                                <?php echo $approve_from_date; ?>
                                ,
                                <?php echo $approve_to_date; ?>
                                <span style="font-size:12px" class="badge badge-dark"><?php if($r['approve_total_days']>0)echo $approve_total_days_list[] = $r['approve_total_days']?></span>
                            </td>
                            <td><?php echo $r['sign_supervisor']?></td>
                            <td><?php echo $r['sup_name']?></td>
                            <td>
                                <?php  if(isset($r['status'])){if($r['status']=='Approve'){?><span class="badge badge-success">Approve</span> <?php }}?>
                                <?php  if(isset($r['status'])){if($r['status']=='Reject'){?><span class="badge badge-danger">Reject</span> <?php }}?>
                            </td>   

                            <td>
                                <a  href="<?php base_url()?>home?Hr/add_leave/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                                    <i class="nav-icon i-Pen-2"></i>
                                </a>
                            </td>
						</tr>
                           
                   
                <?php
                $i++; 
                }
          ?>
                 <tr style="font-weight: bold;">
                    <td colspan="6"></td>	
                    <td>Total Ask  : <?php if(!empty($ask_total_days_list))echo array_sum($ask_total_days_list);?> Day's</td>
                    <td>Total Approve  : <?php if(!empty($approve_total_days_list))echo array_sum($approve_total_days_list);?> Day's</td>
                     <td colspan="4"></td>
                </tr>
        </tbody>
    </table>
</div>
