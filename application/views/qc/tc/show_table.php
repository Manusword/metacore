<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                    <th>#</th>
                    <th>Edit</th>
                    <th>Print</th>
                    <th>Date</th>
                    <th>Invoice Date</th>
                    <th>Customer</th>
                    <th>Invoice No.</th>
                    <th>Certificate No.</th>
                    <th>Product Type</th>
                    <th>Product Name</th>
                    <th>No. of Coils/Spools</th>
                    <th>Size (mm)</th>
                    <th>Weight (kg)</th>
            </tr>
      </thead>
      <tbody>
		<?php 
         
          $i=1;
          foreach($res2 as $r)
          {
            
            if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
            if(isset($r['invoice_date'])){$invoice_date=$this->Base->change_date_dmy($r['invoice_date']);}else{$invoice_date='';}
            ?>
              <tr>
                  <td><?php echo $i;?>.</td>
                  <td>
                      <a  href="<?php base_url()?>home?Qc/tc_add/<?php if(isset($r['tc_id']))echo $r['tc_id']?>" target="_blank"   class="btn btn-warning" >
                          <i class="nav-icon i-Pen-2"></i>
                      </a>
                  </td>
                  <td>
                        <a target="_blank" href="<?php echo base_url()?>index.php/Qc/tc_print/<?php echo $r['tc_id'];?>" class="btn btn-info">Print</a>
                  </td>
                 
                  <td><?php echo $entry_date;?></td>
                  <td><?php echo $invoice_date;?></td>
                  <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                  <td><?php if(isset($r['invoice_no']))echo $r['invoice_no'];?></td>
                  <td><?php if(isset($r['certificate_no']))echo $r['certificate_no'];?></td>
                  <td><?php if(isset($r['tname']))echo $r['tname'];?></td>
                  <td><?php if(isset($r['product_name']))echo $r['product_name'];?></td>
                  <td><?php if(isset($r['no_coil']))echo $t2[] =  $r['no_coil'];?></td>
                  <td><?php if(isset($r['size']))echo $r['size'];?></td>
                  <td><?php if(isset($r['weight']))echo $t3[] =   $r['weight'];?></td>
                 
                  
              </tr>
          <?php
          $i++; 
          }
          ?>

            <tr>
                <td>#</td>
                <td colspan="9"></td>
                <td><?php if(!empty($t2))echo array_sum($t2);?></td>
                <td></td>
                <td><?php if(!empty($t3))echo array_sum($t3);?></td>
                
            </tr>   
        </tbody>
    </table>
</div>