<div class="table-responsive">
   <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Edit</th>
                <th>Type</th>
                <th>Date</th>
                <th>Emp Code</th>
                <th>Name</th>
                <th>Dept.</th>
                <th>Mobile</th>
                
                
                <?php if(!empty($type) && $type == 'Accident'){ ?> 
                    <th>Time</th>
                    <th>Type</th>
                    <th>Nature</th>
                    <th>Location</th>
                    <th>Action</th>
                    <th>Amount</th>
                <?php }elseif(!empty($type) && $type == 'Gatepass'){?>
                    <th>Work Type</th>
                    <th>Duty Off ?</th>
                    <th>Time Out</th>
                    <th>Time In</th>
                    <th>Vehical Name</th>
                    <th>KM_start</th>
                    <th>Km_end</th>
                    <th>Sup.</th>
                <?php }elseif(!empty($type) && $type == 'Fine'){?>
                    <th>Subject</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>Amount</th>
                <?php }else{?>
                    <th>Subject</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>action</th>
                <?php }?>

                    <th>remarks</th>
                
            </tr>
      </thead>
      <tbody>
		    <?php 
                $i=1;
                foreach($res2 as $r)
                {
                       if(!empty($r['entry_date']) and $r['entry_date']!='0000-00-00'){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
                        if(!empty($r['entry_time']) and $r['entry_time']!='00:00:00'){$entry_time=$this->Base->change_time_His($r['entry_time']);}else{$entry_time='';}
                        if(!empty($r['time_out']) and $r['time_out']!='00:00:00'){$time_out=$this->Base->change_time_His($r['time_out']);}else{$time_out='';}
                        if(!empty($r['time_in']) and $r['time_in']!='00:00:00'){$time_in=$this->Base->change_time_His($r['time_in']);}else{$time_in='';}
                        $color = in_array($r['emp_code'], $att) ? '' : 'style="color:red;"';   
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i;?></th>
                             <td>
                                <a  href="<?php base_url()?>home?Hr/add_other/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                                    <i class="nav-icon i-Pen-2"></i>
                                </a>
                            </td>
                            <td><?php echo $r['type']?></td>
                            <td><?php echo $entry_date; ?></td>
                            <td><?php echo $r['emp_code']?></td>
                            <td  <?php echo $color;?>><?php echo $r['first_name'].' '.$r['last_name']?></td>
                            <td><?php echo $r['dname']?></td>
                            <td><?php echo $r['mob']?></td>

                            <?php if(!empty($type) && $type == 'Accident'){?> 
                                <td><?php echo $entry_time; ?></td>
                                <td><?php echo $r['accident_type']?></td>
                                <td><?php echo $r['accident_nature']?></td>
                                <td><?php echo $r['location']?></td>
                                <td><?php echo $r['accident_action']?></td>
                                <td style="color:green"><?php echo $amount[] = $r['amount']?></td>

                            <?php }elseif(!empty($type) && $type == 'Gatepass'){?>
                                <td><?php echo $r['work_type']?></td>
                                <td><?php echo $time_out; ?></td>
                                <td><?php echo $r['duty_off']?></td>
                                <td><?php echo $time_in; ?></td>
                                <td><?php echo $r['vehical_name']?></td>
                                <td><?php echo $r['km_start']?></td>
                                <td><?php echo $r['km_end']?></td>
                                <td><?php echo $r['sup_id']?></td>
                                
                                 
                                
                            <?php }elseif(!empty($type) && $type == 'Fine'){?>
                                <td><?php echo $r['subject']?></td>
                                <td><?php echo $r['description']?></td>
                                <td><?php echo $r['action']?></td>
                                <td style="color:green"><?php echo $amount[] = $r['amount']?></td>

                            <?php }else{?>
                                <td><?php echo $r['subject']?></td>
                                <td><?php echo $r['description']?></td>
                                <td><?php echo $r['action']?></td>
                            <?php }?>
									

                           <td><?php echo $r['remarks']?></td>
						</tr>
                   
                <?php
                $i++; 
                }
            ?>
                 
        </tbody>
    </table>
</div>
