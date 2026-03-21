<div class="table-responsive">
   <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Issue Date</th>
                 <th style="color:blue">Breakfast Coupon Nos.</th>
                <th>Breakfast Coupon Amt.</th>

                <th style="color:blue">Lunch Coupon Nos.</th>
                <th>Lunch Coupon Amt.</th>
                
                <th style="color:blue">Dinner Coupon Nos.</th>
                <th>Dinner Coupon Amt.</th>

                
                <th>Total Coupon Amt.</th>
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
                            <td><?php echo $issue_date;?></td>
                              <td style="color:blue"><?php echo $breakfast_coupon_no[] = $r['breakfast_coupon_no']?></td>
                            <td><?php echo $breakfast_coupon_amt[] = $r['breakfast_coupon_amt']?></td>
                           
                            <td style="color:blue"><?php echo $lunch_coupon_no[] = $r['lunch_coupon_no']?></td>
                            <td><?php echo $lunch_coupon_amt[] = $r['lunch_coupon_amt']?></td>

                            <td style="color:blue"><?php echo $dinner_coupon_no[] = $r['dinner_coupon_no']?></td>
                            <td><?php echo $dinner_coupon_amt[] = $r['dinner_coupon_amt']?></td>

                           
                            <td><?php echo $total_amt[] = $r['total_amt']?></td>
                        </tr>
                <?php
                $i++; 
                }
            ?>
                 <tr style="font-weight: bold;background-color:pink">
                    <td colspan="2">Total</td>	
                    <td><?php if(!empty($breakfast_coupon_no)){echo $c = array_sum($breakfast_coupon_no);}else{$c=0;}?></td>
                    <td><?php if(!empty($breakfast_coupon_amt)){echo $d = array_sum($breakfast_coupon_amt);}else{$d=0;}?> Rs.</td>
                    
                    <td><?php if(!empty($lunch_coupon_no)){echo $a = array_sum($lunch_coupon_no);}else{$a=0;}?></td>
                    <td><?php if(!empty($lunch_coupon_amt)){echo $b = array_sum($lunch_coupon_amt);}else{$b=0;}?> Rs.</td>

                    <td><?php if(!empty($dinner_coupon_no)){echo $g = array_sum($dinner_coupon_no);}else{$g=0;}?></td>
                    <td><?php if(!empty($dinner_coupon_amt)){echo $h = array_sum($dinner_coupon_amt);}else{$h=0;}?> Rs.</td>
                   
                    <td><?php if(!empty($total_amt)){echo $f = array_sum($total_amt);}else{$f=0;}?> Rs.</td>
                </tr>

              
        </tbody>

       
    </table>
</div>



