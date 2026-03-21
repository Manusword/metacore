<div class="table-responsive">
  <table class="table table-bordered  table-sm" id="printed_table">
    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      <tr>
          <th>#</th>
          <th>Customer Name</th>
          <th>Receive Date</th>
          <th>Bank name</th>
          <th>Account No.</th>
          <th>IFSC Code</th>
          <th>Address</th>
          <th>Cheque No.</th>
          <th>Authorized Person</th>
          <th>Amount Status</th>
          <th>Amount (Rs.)</th>
          <th>Expiry Date</th>
          <th>Remarks</th>
          <th>Edit</th>
        </tr>
    </thead>
    <tbody>
      <?php 
      //----------------------------------------Same as coustomer controller
        $i=1;
        $cheque_amount = array();
        foreach($res2 as $r)
        {
           
          if(isset($r['receive_date'])){$receive_date=$this->Base->change_date_dmy($r['receive_date']);}else{$receive_date='';}
          if(isset($r['expiry_date']) and $r['expiry_date'] != '0000-00-00'){$expiry_date=$this->Base->change_date_dmy($r['expiry_date']);}else{$expiry_date='';}
          ?>
          <tr>
                <td><?php echo $i;?></td>
                <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                <td><?php if(isset($receive_date))echo $receive_date;?></td>
                <td><?php if(isset($r['bank_name']))echo $r['bank_name'];?></td>
                <td><?php if(isset($r['account_no']))echo $r['account_no'];?></td>
                <td><?php if(isset($r['ifsc_code']))echo $r['ifsc_code'];?></td>
                <td><?php if(isset($r['bank_address']))echo $r['bank_address'];?></td>
               
                <td><?php if(isset($r['cheque_no']))echo $r['cheque_no'];?></td>
                <td><?php if(isset($r['authorized_person']))echo $r['authorized_person'];?></td>
               
                <td><?php if(isset($r['amount_status']))echo $r['amount_status'];?></td>
                

                <td><?php if(isset($r['cheque_amount']) and $r['cheque_amount']>0){ $cheque_amount[] = round($r['cheque_amount']); echo  $this->Base->money($r['cheque_amount']);}?></td>
                <td><?php if(isset($expiry_date))echo $expiry_date;?></td>
                <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
                
                <td>
                  <a href="<?php base_url()?>home?Customer/cheque_entry/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"  class="btn btn-warning" style=" float:left;">
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total</td>
                <td><?php if(!empty($cheque_amount)){$a = round(array_sum($cheque_amount),2); echo  $this->Base->money($a);}?></td>
                <td></td>
                <td></td>
                <td></td>
            <tr>
  </table>
</div>