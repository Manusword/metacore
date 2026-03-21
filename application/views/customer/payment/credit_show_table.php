<div class="table-responsive">
  <table class="table table-bordered  table-sm" id="printed_table">
    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      <tr>
          <th>#</th>
          <th>Payment Date</th>
          <th>Customer Name</th>
          <th>Invoice No.</th>
          <th>Paid Amount (Rs.)</th>
          <th>Paid Day History</th>
          <th>Edit</th>
        </tr>
    </thead>
    <tbody>
      <?php 
        $i=1;
        $credit_amt = array();
        foreach($res2 as $r)
        {
          if(isset($r['payment_date'])){$payment_date=$this->Base->change_date_dmy($r['payment_date']);}else{$payment_date='';}
          ?>
          <tr>
                <td><?php echo $i;?></td>
                <td><?php if(isset($payment_date))echo $payment_date;?></td>
                <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                <td><?php if(isset($r['invoice_no']))echo $r['invoice_no'];?></td>
                <td><?php if(isset($r['credit_amount'])) $credit_amt[] = round($r['credit_amount'],2); echo  $this->Base->money($r['credit_amount']);?></td>
                <td>
                    <?php 
                      //if(isset($payment_date))echo $payment_date;
                      $this->Customermodel->get_payment_receive_history($r['cr_dr_id']);
                    ?>
                </td>
                <td>
                  <a href="<?php base_url()?>home?Customer/credit_entry2/<?php if(isset($r['cr_dr_id']))echo $r['cr_dr_id']?>" target="_blank"  class="btn btn-warning" style=" float:left;">
                      <i class="nav-icon i-Pen-2"></i>
                    </a>
                </td>
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
              
              <td>Total</td>
              <td><?php if(!empty($credit_amt)){$a = round(array_sum($credit_amt),2);  echo  $this->Base->money($a);}?></td>
              <td></td>
              <td></td>
          <tr>
  </table>
</div>