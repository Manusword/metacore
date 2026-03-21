<div class="table-responsive">
  <table class="table table-bordered  table-sm" id="printed_table">
    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      <tr>
          <th>#</th>
          <th>Customer Name</th>
          <th>Sales Person Name</th>
          <th>Invoice No</th>
          <th>Billing Date</th>
          <th>Day Limit</th>
          <th>Reminder Date</th>
          <th>Last Date</th>
          <th>Bill Amt.</th>
          <th>Paid Amt.</th>
          <th>Rem. Amt.</th>
          <th>Paid Day History</th>
          <th>Remarks</th>
          
        </tr>
    </thead>
    <tbody>
      <?php 
        $i=1;
        $debit_amount_arr = array();
        $cr_amount_arr = array();
        $rem_amount_arr = array();
        $today_date = date('Y-m-d');
        foreach($res2 as $r)
        {
            if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
            if(isset($r['last_date'])){$last_date=$this->Base->change_date_dmy($r['last_date']);}else{$last_date='';}
            if(isset($r['notifi_date'])){$notifi_date=$this->Base->change_date_dmy($r['notifi_date']);}else{$notifi_date='';}
            if(isset($r['payment_date']) and $r['payment_date']!='0000-00-00'){$payment_date=$this->Base->change_date_dmy($r['payment_date']);}else{$payment_date='';}

            
            if($today_date > $r['last_date']){$text_color = "red";}
            else if($today_date >= $r['notifi_date'] and $today_date <= $r['last_date'] ){$text_color = "orange";}
            else if($today_date < $r['notifi_date']  ){$text_color = "green";}
            else{$text_color = "black";}
          ?>
          <tr>
                <td><?php echo $i;?></td>
                <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                <td><?php if(isset($r['sales_person']))echo $r['sales_person'];?></td>
                <td><?php if(isset($r['invoice_no']))echo $r['invoice_no'];?></td>
                <td><?php if(isset($entry_date))echo $entry_date;?></td>
                <td><?php if(isset($r['day_limit']))echo $r['day_limit'];?></td>
                <td><?php if(isset($notifi_date))echo $notifi_date;?></td>
                <td><?php if(isset($last_date))echo $last_date;?></td>
                <td style="color:<?php echo $text_color;?>;font-weight:bold">
                  <?php if(!empty($r['debit_amount'])) $debit_amount_arr[] = round($r['debit_amount'],2);echo  $this->Base->money($r['debit_amount']);?>
                </td>
                <td>
                    <?php if(!empty($r['debit_amount'])) $cr_amount_arr[] = round($r['credit_amount'],2);echo  $this->Base->money($r['credit_amount']);?>
                </td>
                <td style="color:<?php echo $text_color;?>;font-weight:bold">
                  <?php if(!empty($r['rem_amount'])) $rem_amount_arr[] = round($r['rem_amount'],2);echo  $this->Base->money($r['rem_amount']);?>
                </td>
                <td>
                    <?php 
                      //if(isset($payment_date))echo $payment_date;
                      $this->Customermodel->get_payment_receive_history($r['cr_dr_id']);
                    ?>
                </td>
                <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
                
            <tr>
					<?php
        $i++; 
      }
      ?>
    </tbody>
        <tr style="font-weight:bold">
                <td></td>
                <td>Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php if(!empty($debit_amount_arr)){ $a = round(array_sum($debit_amount_arr),2);  echo  $this->Base->money($a);}?></td>
                <td><?php if(!empty($cr_amount_arr)) {$b = round(array_sum($cr_amount_arr),2);  echo  $this->Base->money($b);}?></td>
                <td><?php if(!empty($rem_amount_arr)) {$c = round(array_sum($rem_amount_arr),2);  echo  $this->Base->money($c);}?></td>
                <td></td>
                <td></td>
               
        <tr>
  </table>
</div>