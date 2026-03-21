<div class="table-responsive">
  <table class="table table-bordered  table-sm" id="printed_table">
    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      <tr>
          <th>#</th>
          <th>Date</th>
          <th>Customer</th>
          <th>Mobile</th>
          
          <th>Last Payment</th>
          <th>Total Debit</th>
          <th>Total Credit</th>
          <th>Total Rem. Payment (Rs)</th>
          <th>Credit Limit (Rs.)</th>
          <th>Balance (Rs.)</th>
          <th>Day's Limit</th>
          <th>Late (Day's)</th>
          
          <th>History</th>
          <th>Flowup</th>
        </tr>
    </thead>
    <tbody>
      <?php 
        //print_r($res2);
        $i=1;
        $amount1 = array();
        $amount2 = array();
        $amount3 = array();
        $amount4 = array();
        foreach($res2 as $r)
        {
          if(isset($r['last_date'])){$entry_date=$this->Base->change_date_dmy($r['last_date']);}else{$entry_date='';}
          if(isset($r['damt']) and isset($r['camt'])){ $rem_amt = round($r['damt']-$r['camt']); } else{$rem_amt = 0;}
          
          //amount limit
          if(isset($r['limit_of_dis'])){ $limit_amt =  $r['limit_of_dis']; $bal_amt = round($rem_amt - $r['limit_of_dis']);  } else{ $limit_amt= 0; $bal_amt=0;}
          if($bal_amt > 0){ $limit_color = "red";}else{ $limit_color = "black";}
          
          //day limit
          if(isset($r['limit_of_days'])){ $limit_days =  $r['limit_of_days'];  } else{ $limit_days = 0; }
          ?>
          <tr>
                <td><?php echo $i;?></td>
                <td><?php if(isset($entry_date))echo $entry_date;?></td>
                <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                <td> 
                    <?php 
                      if(!empty($r['telphone'])){echo $r['telphone'];}
                      if(!empty($r['con_mob1'])){echo ', '.$r['con_mob1'];}
                      if(!empty($r['con_mob2'])){echo ', '.$r['con_mob2'];}
                    ?>
                </td>
                <td></td>
                <td><?php if(isset($r['damt']))echo $amount1[] = (float)$r['damt'];?></td>
                <td><?php if(isset($r['camt']))echo $amount2[] = (float)$r['camt'];?></td>
                <td><?php if(!empty($rem_amt))echo $amount3[] = $rem_amt;?></td>
                
                <td><?php if(!empty($limit_amt))echo $limit_amt;?></td>
                <td style="color:<?php echo $limit_color;?>"><?php if(!empty($bal_amt))echo $amount4[] = $bal_amt;?></td>
                
                <td><?php if(!empty($limit_days))echo $limit_days;?></td>


                
            <tr>
					<?php
        $i++; 
      }
      ?>
    </tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><?php if(!empty($amount1))echo $a = array_sum($amount1);?></td>
                <td><?php if(!empty($amount2))echo $b = array_sum($amount2);?></td>
                <td><?php if(!empty($a) and !empty($b)) echo round($a-$b,2);?></td>
                <td></td>
            <tr>
  </table>
</div>