<div class="table-responsive">
   <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Emp Code</th>
                <th>Name</th>
                <th>Dept.</th>
                <th>Mobile</th>
                
                <th>Ask Amount (Rs.)</th>
                <th>Reason</th>
                <th>Approve Amount (Rs.)</th>
                <th>Status</th>
                <th>Payment Type</th>
                <th>Remarks</th>
                <th>Edit</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
           
                $i=1;
                foreach($res2 as $r)
                {
                       
                        if(!empty($r['ask_date']) and $r['ask_date']!='0000-00-00'){$ask_date=$this->Base->change_date_dmy($r['ask_date']);}else{$ask_date='';}
                        $color = in_array($r['emp_code'], $att) ? '' : 'style="color:red;"';   
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i;?></th>
                            <td><?php echo $ask_date; ?></td>
                            <td><?php echo $r['emp_code']?></td>
                            <td  <?php echo $color;?>><?php echo $r['first_name'].' '.$r['last_name']?></td>
                            <td><?php echo $r['dname']?></td>
                            <td><?php echo $r['mob']?></td>

                            <td><?php echo $total_ask_amount[] = $r['ask_amount']?></td>
                            <td><?php echo $r['reason_for']?></td>
                            <td style="color:green"><?php echo $total_approve_amount[] = $r['approve_amount']?></td>
                            <td>
                                <?php  if(isset($r['status'])){if($r['status']=='Approve'){?><span class="badge badge-success">Approve</span> <?php }}?>
                                <?php  if(isset($r['status'])){if($r['status']=='Reject'){?><span class="badge badge-danger">Reject</span> <?php }}?>
                            </td> 
                            <td><?php echo $r['payment_type']?></td>
                            <td><?php echo $r['remarks']?></td>

                            <td>
                                <a  href="<?php base_url()?>home?Hr/add_advance/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
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
                    <td><?php if(!empty($total_ask_amount))echo array_sum($total_ask_amount);?> Rs.</td>
                    <td ></td>	
                    <td style="color:green"><?php if(!empty($total_approve_amount))echo array_sum($total_approve_amount);?> Rs.</td>
                    <td colspan="4"></td>
                </tr>
        </tbody>
    </table>
</div>
