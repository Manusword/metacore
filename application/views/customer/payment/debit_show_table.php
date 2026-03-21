<div class="table-responsive">
  <table class="table table-bordered  table-sm" id="printed_table">
    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      <tr>
          <th>#</th>
          
          <th>Date</th>
          <th>Customer Name</th>
          <th>Invoice No.</th>
          <th>Financial  Year</th>
          <th>Amount (Rs.)</th>
          <th>Remarks</th>
          <th>Edit</th>
        </tr>
    </thead>
    <tbody>
      <?php 
        $i=1;
        $debit_amt = array();
        foreach($res2 as $r)
        {
           

          if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
          ?>
          <tr>
                <td><?php echo $i;?></td>
                <td><?php if(isset($entry_date))echo $entry_date;?></td>
                <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                <td><?php if(isset($r['invoice_no']))echo $r['invoice_no'];?></td>
                <td><?php if(isset($r['fin_year']))echo $r['fin_year'];?></td>
                <td><?php if(isset($r['debit_amount'])) $debit_amt[] = round($r['debit_amount']); echo  $this->Base->money($r['debit_amount']);?></td>
                <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
                
                <td>
                  <a href="<?php base_url()?>home?Customer/debit_entry/<?php if(isset($r['cr_dr_id']))echo $r['cr_dr_id']?>" target="_blank"  class="btn btn-warning" style=" float:left;">
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
                <td>Total</td>
                <td><?php if(!empty($debit_amt)){$a = round(array_sum($debit_amt),2); echo  $this->Base->money($a);}?></td>
                <td></td>
                <td></td>
            <tr>
  </table>
</div>