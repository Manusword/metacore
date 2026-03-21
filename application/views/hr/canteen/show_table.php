<div class="table-responsive">
   <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Issue Date</th>
                <th>Emp Code</th>
                <th>Name</th>
                <th>Dept.</th>
                <th>Code ?</th>
                <th>Other Person Name</th>
                <th>Other Person Dept.</th>
                <th>Other Person Ref.</th>
                
                <th style="color:blue">Breakfast Coupon Nos.</th>
                <th>Breakfast Coupon Amt.</th>

                <th style="color:blue">Lunch Coupon Nos.</th>
                <th>Lunch Coupon Amt.</th>
                
                <th style="color:blue">Dinner Coupon Nos.</th>
                <th>Dinner Coupon Amt.</th>

                
                <th>Total Coupon Amt.</th>
                <th>Remarks</th>
               
                <th>Edit</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
                $i=1;
                foreach($res2 as $r)
                {
                       
                        if(!empty($r['issue_date']) and $r['issue_date']!='0000-00-00'){$issue_date=$this->Base->change_date_dmy($r['issue_date']);}else{$issue_date='';}
                       ?>
                        <tr>
                            <th scope="row"><?php echo $i;?></th>
                            <td><?php echo $issue_date; ?></td>
                            <td><?php echo $r['emp_code']?></td>
                            <td><?php echo $r['first_name'].' '.$r['last_name']?></td>
                            <td><?php echo $r['dname']?></td>
                            <td><?php echo $r['type']?></td>
                            
                            <td><?php echo $r['other_name']?></td>
                            <td><?php echo $r['other_dept']?></td>
                            <td><?php echo $r['other_ref']?></td>

                            <td style="color:blue"><?php echo $breakfast_coupon_no[] = $r['breakfast_coupon_no']?></td>
                            <td><?php echo $breakfast_coupon_amt[] = $r['breakfast_coupon_amt']?></td>
                           
                            <td style="color:blue"><?php echo $lunch_coupon_no[] = $r['lunch_coupon_no']?></td>
                            <td><?php echo $lunch_coupon_amt[] = $r['lunch_coupon_amt']?></td>

                            <td style="color:blue"><?php echo $dinner_coupon_no[] = $r['dinner_coupon_no']?></td>
                            <td><?php echo $dinner_coupon_amt[] = $r['dinner_coupon_amt']?></td>
                            
                           
                            <td><?php echo $total_amt[] = $r['total_amt']?></td>
                           
                            <td><?php echo $r['remarks']?></td>
                           
                            <td>
                                <a  href="<?php base_url()?>home?Hr/add_coupon/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                                    <i class="nav-icon i-Pen-2"></i>
                                </a>
                            </td>
						</tr>
                           
                   
                <?php
                $i++; 
                }
            ?>
                 <tr style="font-weight: bold;background-color:pink">
                    <td colspan="9"></td>	
                    
                    <td style="color:blue"><?php if(!empty($breakfast_coupon_no))echo array_sum($breakfast_coupon_no);?></td>
                    <td><?php if(!empty($breakfast_coupon_amt))echo array_sum($breakfast_coupon_amt);?> Rs.</td>
                    
                    <td style="color:blue"><?php if(!empty($lunch_coupon_no))echo array_sum($lunch_coupon_no);?></td>
                    <td><?php if(!empty($lunch_coupon_amt))echo array_sum($lunch_coupon_amt);?> Rs.</td>
                    
                    <td style="color:blue"><?php if(!empty($dinner_coupon_no))echo array_sum($dinner_coupon_no);?></td>
                    <td><?php if(!empty($dinner_coupon_amt))echo array_sum($dinner_coupon_amt);?> Rs.</td>
                   
                    
                    <td><?php if(!empty($total_amt))echo array_sum($total_amt);?> Rs.</td>
                    <td colspan="2"></td>
                </tr>
        </tbody>
    </table>
</div>
