<div class="table-responsive">
   <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
               <th>Issue Date</th>
                <th>Breakfast Coupon Nos.</th>
                <th>Breakfast Coupon Amt.</th>
                <th>Lunch Coupon Nos.</th>
                <th>Lunch Coupon Amt.</th>
                <th>Dinner Coupon Nos.</th>
                <th>Dinner Coupon Amt.</th>
                <th>Total Coupon Nos.</th>
                <th>Total Coupon Amt.</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
               $lunch_coupon_no = array();
                $lunch_coupon_amt = array();
                $dinner_coupon_no = array();
                $dinner_coupon_amt = array();
                $breakfast_coupon_no = array();
                $breakfast_coupon_amt = array();
                $total_coupon = array();
                $total_amt = array();
                $i=1;
                foreach($res2 as $r)
                {
                       if(!empty($r['receive_date']) and $r['receive_date']!='0000-00-00'){$receive_date=$this->Base->change_date_dmy($r['receive_date']);}else{$receive_date='';}
                       ?>
                        <tr>
                            <th scope="row"><?php echo $i;?></th>
                            <td><?php echo $receive_date;?></td>
                            <td><?php echo $breakfast_coupon_no[] = $r['breakfast_coupon_no']?></td>
                            <td><?php echo $breakfast_coupon_amt[] = $r['breakfast_coupon_amt']?></td>
                            <td><?php echo $lunch_coupon_no[] = $r['lunch_coupon_no']?></td>
                            <td><?php echo $lunch_coupon_amt[] = $r['lunch_coupon_amt']?></td>
                            <td><?php echo $dinner_coupon_no[] = $r['dinner_coupon_no']?></td>
                            <td><?php echo $dinner_coupon_amt[] = $r['dinner_coupon_amt']?></td>

                            <td><?php echo $total_coupon[] = $r['total_coupon']?></td>
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

                    <td><?php if(!empty($dinner_coupon_no)){echo $g = array_sum($dinner_coupon_no);}else{$a=0;}?></td>
                    <td><?php if(!empty($dinner_coupon_amt)){echo $h = array_sum($dinner_coupon_amt);}else{$b=0;}?> Rs.</td>
                    
                    <td><?php if(!empty($total_coupon)){echo $e = array_sum($total_coupon);}else{$e=0;}?></td>
                    <td><?php if(!empty($total_amt)){echo $f = array_sum($total_amt);}else{$f=0;}?> Rs.</td>
                </tr>

                <tr style="font-weight: bold; height:50px">
                        <td colspan="10"></td>	
                    </tr>

                 <tr style="font-weight: bold;background-color:yellow">
                    <td colspan="2">G.Total</td>	
                    <td><?php ?></td>
                    <td><?php if(!empty($d))echo $d+$d;?> Rs.</td>
                    <td><?php ?></td>
                    <td><?php if(!empty($b))echo $b+$b;?> Rs.</td>
                    <td><?php ?></td>
                    <td><?php if(!empty($h))echo $h+$h;?> Rs.</td>
                    <td><?php ?></td>
                    <td><?php if(!empty($f))echo $f+$f;?> Rs.</td>

                </tr>
              
        </tbody>

       
    </table>
</div>



