
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>No</th>
                <th>Supplier Name</th>
                <th>Invoice No</th>
                <th>Invoice Date</th>
                <th>Gate Pass No</th>
                <th>Total Qty</th>
                <th>Amt (₹)</th>
                <th>FFC Amt.</th>
                <th>GST Amt.</th>
                <th>Grand Total</th>
                <th>Edit</th>
                <th>Print</th>
        </tr>
        </thead>
        <tbody>
		    <?php 
                $i=1;
                foreach($res2 as $r)
                {
                    ?>
                    <tr>
                        <td>
                            <?php echo $i;?>.
                            <?php  if(isset($r['print_status'])){if($r['print_status']=='1'){?><span class="label label-success" title="Printed">P</span> <?php }}?>
                            <?php  if(isset($r['print_status'])){if($r['print_status']=='0'){?><span class="label label-danger" title="Not Printed">N.P</span><?php }}?>
                        </td>
                        <td><?php echo $this->Base->change_date_dmy($r['product_invoice_save_date']);?></td>
                        <td><?php echo $r['product_invoice_save_no'];?></td>
                        <td><?php echo $r['sname'];?></td>
                        <td><?php echo $r['invoice_no'];?></td>
                        <td><?php echo $this->Base->change_date_dmy($r['invoice_date']);?></td>
                        <td><?php echo $r['gate_pass_no'];?></td>
                        <td><?php echo $weight[]=(int)$r['amount_weight_sum'];?></td>
                        <td><?php echo $rs_total[]=(int)$r['total'];?></td>
                        <td><?php echo $rs_ffc[]=(int)$r['ffc_charge'];?></td>
                        <td><?php echo $rs_gst[]=(int)$r['gstcharge']+(int)$r['ffc_gst_amt'];?></td>
                        <td><?php echo $rs[]=(int)$r['grandtotal'];?></td>
                        <td style="width:130px;">   
                            <a target="_blank"   href="<?php echo base_url().'index.php/Welcome/home?';?>Po/add_invoice/<?php if(isset($r['product_invoice_entry_id']))echo $r['product_invoice_entry_id']?>"  class="btn btn-warning" style=" float:left;">
                                <i class="nav-icon i-Pen-2"></i>
                            </a>
                        </td>
                        <td style="width:130px;">   
                            <a href="<?php echo base_url()?>index.php/Ajex/invoice_receive_print/<?php echo $r['product_invoice_entry_id']?>" target="_blank" title="Print / View" class="btn btn-info" style=" float:left;" >
                                Print
                            </a>
                        </td>
                    </tr>
                    <?php
                $i++; 
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th colspan="6"></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($weight))echo array_sum($weight);?></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($rs_total))echo number_format(array_sum($rs_total),2);?></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($rs_ffc))echo number_format(array_sum($rs_ffc),2);?></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($rs_gst))echo number_format(array_sum($rs_gst),2);?></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($rs))echo number_format(array_sum($rs),2);?></th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>