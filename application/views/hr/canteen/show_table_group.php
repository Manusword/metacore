<div class="table-responsive">
    <p><span style="color:red;">Red color</span> indicates that attendance was not registered in the table; therefore, the coupon amount could not be recorded </p>
   <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Emp Code</th>
                <th>Name</th>
                <th>Dept.</th>
                
                <th style="color:blue">Breakfast Coupon Nos.</th>
                <th>Breakfast Coupon Amt.</th>

                <th style="color:blue">Lunch Coupon Nos.</th>
                <th>Lunch Coupon Amt.</th>
                
                <th style="color:blue">Dinner Coupon Nos.</th>
                <th>Dinner Coupon Amt.</th>

                
                <th>Total Coupon Nos.</th>
                <th>Total Coupon Amt.</th>
                <th>Set Full Charge</th>
            </tr>
      </thead>
      <tbody>
		    <?php 
           
                $dinner_coupon_no = array();
                $dinner_coupon_amt = array();
                $lunch_coupon_no = array();
                $lunch_coupon_amt = array();
                $breakfast_coupon_no = array();
                $breakfast_coupon_amt = array();
                $total_coupon = array();
                $total_amt = array();
                $i=1;
                foreach($res2 as $r)
                {
                    // Check if emp_code is in the pay_code list
                    $color = in_array($r['emp_code'], $att) ? '' : 'style="color:red;"';   
                    if(!empty($r['issue_date']) and $r['issue_date']!='0000-00-00'){$issue_date=$this->Base->change_date_dmy($r['issue_date']);}else{$ask_frissue_dateom_date='';}
                       ?>
                        <tr>
                            <th scope="row"><?php echo $i;?></th>
                            <td> <?php echo $r['emp_code']?></td>
                            <td <?php echo $color;?>><?php echo $r['first_name'].' '.$r['last_name']?></td>
                            <td><?php echo $r['dname']?></td>
                            
                             <td style="color:blue"><?php echo $breakfast_coupon_no[] = $r['breakfast_coupon_no']?></td>
                            <td><?php echo $breakfast_coupon_amt[] = $r['breakfast_coupon_amt']?></td>
                           
                            <td style="color:blue"><?php echo $lunch_coupon_no[] = $r['lunch_coupon_no']?></td>
                            <td><?php echo $lunch_coupon_amt[] = $r['lunch_coupon_amt']?></td>

                            <td style="color:blue"><?php echo $dinner_coupon_no[] = $r['dinner_coupon_no']?></td>
                            <td><?php echo $dinner_coupon_amt[] = $r['dinner_coupon_amt']?></td>

                            
                            <td><?php echo $total_coupon[] = $r['total_coupon']?></td>
                            <td><?php echo $total_amt[] = $r['total_amt']?></td>
                            <td>
                                
                                <a  href="<?php echo base_url()."index.php/Hr/canteen_full_charge_update?emp_code=".$r['emp_code']."&fdate=$fdate&tdate=$tdate";?>&fullCharge=Yes" target="_blank"   class="btn btn-warning" >
                                    Full Charge
                                </a>
                            </td>
                        </tr>
                <?php
                $i++; 
                }
            ?>
                 <tr style="font-weight: bold;background-color:pink">
                    <td colspan="4">Total</td>	
                    
                    <td><?php if(!empty($breakfast_coupon_no)){echo $c = array_sum($breakfast_coupon_no);}else{$c=0;}?></td>
                    <td><?php if(!empty($breakfast_coupon_amt)){echo $d = array_sum($breakfast_coupon_amt);}else{$d=0;}?> Rs.</td>
                    
                    <td><?php if(!empty($lunch_coupon_no)){echo $a = array_sum($lunch_coupon_no);}else{$a=0;}?></td>
                    <td><?php if(!empty($lunch_coupon_amt)){echo $b = array_sum($lunch_coupon_amt);}else{$b=0;}?> Rs.</td>

                    <td><?php if(!empty($dinner_coupon_no)){echo $g = array_sum($dinner_coupon_no);}else{$g=0;}?></td>
                    <td><?php if(!empty($dinner_coupon_amt)){echo $h = array_sum($dinner_coupon_amt);}else{$h=0;}?> Rs.</td>
                   
                    <td><?php if(!empty($total_coupon)){echo $e = array_sum($total_coupon);}else{$e=0;}?></td>
                    <td><?php if(!empty($total_amt)){echo $f = array_sum($total_amt);}else{$f=0;}?> Rs.</td>
                     <td></td>	
                </tr>

                <tr style="font-weight: bold; height:50px">
                    <td colspan="13"></td>	
                </tr>

                 <tr style="font-weight: bold;">
                    <td colspan="13"><h4>Without employee code : </h4></td>	
                </tr>

                <tr>
                    <th>#</th>
                    <th>Other Person Ref.</th>
                    <th>Other Person Name</th>
                    <th>Other Person Dept</th>
                    
                     <th style="color:blue">Breakfast Coupon Nos.</th>
                    <th>Breakfast Coupon Amt.</th>

                    <th style="color:blue">Lunch Coupon Nos.</th>
                    <th>Lunch Coupon Amt.</th>
                    
                    <th style="color:blue">Dinner Coupon Nos.</th>
                    <th>Dinner Coupon Amt.</th>

                    <th>Total Coupon Nos.</th>
                    <th>Total Coupon Amt.</th>
                </tr>

                 <?php 
                        $dinner_coupon_no = array();
                        $dinner_coupon_amt = array();
                        $lunch_coupon_no = array();
                        $lunch_coupon_amt = array();
                        $breakfast_coupon_no = array();
                        $breakfast_coupon_amt = array();
                        $total_coupon = array();
                        $total_amt = array();
                        $i=1;
                        foreach($res22 as $r)
                        {
                            if(!empty($r['issue_date']) and $r['issue_date']!='0000-00-00'){$issue_date=$this->Base->change_date_dmy($r['issue_date']);}else{$issue_date='';}
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $i;?></th>
                                     <td><?php echo $r['other_ref']?></td>
                                    <td><?php echo $r['other_name']?></td>
                                    <td><?php echo $r['other_dept'];?></td>
                                   
                                    
                                    <td style="color:blue"><?php echo $breakfast_coupon_no[] = $r['breakfast_coupon_no']?></td>
                                    <td><?php echo $breakfast_coupon_amt[] = $r['breakfast_coupon_amt']?></td>
                                
                                    <td style="color:blue"><?php echo $lunch_coupon_no[] = $r['lunch_coupon_no']?></td>
                                    <td><?php echo $lunch_coupon_amt[] = $r['lunch_coupon_amt']?></td>

                                    <td style="color:blue"><?php echo $dinner_coupon_no[] = $r['dinner_coupon_no']?></td>
                                    <td><?php echo $dinner_coupon_amt[] = $r['dinner_coupon_amt']?></td>

                                    <td><?php echo $total_coupon[] = $r['total_coupon']?></td>
                                    <td><?php echo $total_amt[] = $r['total_amt']?></td>
                                </tr>
                        <?php
                        $i++; 
                        }
                    ?>
                    <tr style="font-weight: bold;background-color:pink">
                        <td colspan="4">Total</td>	
                       
                        <td><?php if(!empty($breakfast_coupon_no)){echo $c1 = array_sum($breakfast_coupon_no);}else{$c1=0;}?></td>
                        <td><?php if(!empty($breakfast_coupon_amt)){echo $d1 = array_sum($breakfast_coupon_amt);}else{$d1=0;}?> Rs.</td>
                        
                        <td><?php if(!empty($lunch_coupon_no)){echo $a1 = array_sum($lunch_coupon_no);}else{$a1=0;}?></td>
                        <td><?php if(!empty($lunch_coupon_amt)){echo $b1 = array_sum($lunch_coupon_amt);}else{$b1=0;}?> Rs.</td>
                        
                        <td><?php if(!empty($dinner_coupon_no)){echo $g1 = array_sum($dinner_coupon_no);}else{$g1=0;}?></td>
                        <td><?php if(!empty($dinner_coupon_amt)){echo $h1 = array_sum($dinner_coupon_amt);}else{$h1=0;}?> Rs.</td>

                        <td><?php if(!empty($total_coupon)){echo $e1 = array_sum($total_coupon);}else{$e1=0;}?></td>
                        <td><?php if(!empty($total_amt)){echo $f1 = array_sum($total_amt);}else{$f1=0;}?> Rs.</td>
                    </tr>

                    <tr style="font-weight: bold; height:50px">
                        <td colspan="13"></td>	
                    </tr>

                    <tr style="font-weight: bold; background-color:yellow">
                        <td colspan="4">G.Total</td>	
                        <td><?php echo $c+$c1;?></td>
                        <td><?php echo $d+$d1;?></td>
                        
                        <td><?php echo $a+$a1;?></td>
                        <td><?php echo $b+$b1;?></td>

                         <td><?php echo $g+$g1;?></td>
                        <td><?php echo $h+$h1;?></td>
                       
                       <td><?php echo $e+$e1;?></td>
                       <td><?php echo $f+$f1;?> Rs.</td>
                    </tr>
        </tbody>

       
    </table>
</div>



