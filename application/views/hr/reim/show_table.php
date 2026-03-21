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
                <th>Details</th>
                 <th>Status</th>
                <th>Amount</th>
                <th>Adjust in Salary</th>
                <th>Remarks</th>
               
                <th>Edit</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
                $i=1;
                $amount = array();
                foreach($res2 as $r)
                {
                       if(!empty($r['entry_date']) and $r['entry_date']!='0000-00-00'){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
                       ?>
                        <tr>
                            <th><?php echo $i;?></th>
                            <td><?php echo $entry_date; ?></td>
                            <td><?php echo $r['emp_code']?></td>
                            <td><?php echo $r['first_name'].' '.$r['last_name']?></td>
                            <td><?php echo $r['dname']?></td>
                            <td><?php echo $r['mob']?></td>
                            <td><?php echo $r['subject']?></td>
                            <?php
                                $status = trim($r['status']);

                                $badgeClass = 'bg-secondary'; // default (safety)

                                if ($status === 'Pending') {
                                    $badgeClass = 'bg-warning';
                                } elseif ($status === 'Approved') {
                                    $badgeClass = 'bg-success';
                                } elseif ($status === 'Paid') {
                                    $badgeClass = 'bg-info';
                                }
                                ?>
                                <td>
                                    <span class="badge  <?= $badgeClass ?> text-white">
                                        <?= htmlspecialchars($status) ?>
                                    </span>
                                </td>

                            <td><?php echo $amount[] = $r['amount']?></td>
                            <td><?php echo $r['adjust_in_salary']?></td>
                            <td><?php echo $r['remarks']?></td>
                            
                            <td>
                                <a  href="<?php base_url()?>home?Hr/add_reim/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                                    <i class="nav-icon i-Pen-2"></i>
                                </a>
                            </td>
						</tr>
                   
                <?php
                $i++; 
                }
            ?>
            <tr>
                <td colspan="8"></td>
                <td><?php if(!empty($amount))echo round(array_sum($amount));?></td>
                <td colspan="3"></td>
            </tr>
                 
        </tbody>
    </table>
</div>
