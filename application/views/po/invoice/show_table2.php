
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>No</th>
                <th style="color:black; font-weight:bolder">Description Of Goods</th>
                <th style="color:black; font-weight:bolder">HSN Code</th>
                <th style="color:black; font-weight:bolder">Pckgs No.</th>
                <th style="color:black; font-weight:bolder">Qty</th>
                <th style="color:black; font-weight:bolder">Unit</th>
                <th style="color:black; font-weight:bolder">Price</th>
                <th style="color:black; font-weight:bolder">Amount (₹)</th>
                <th>Supplier Name</th>
                <th>Invoice Edit</th>
                <th>Qc Entry / Edit</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $i=1;
                foreach($res2 as $r)
                {
                    ?>
                    <tr>
                        <td><?php echo $i;?>.
                            <?php  if(isset($r['qc_check'])){if($r['qc_check']==1 or $r['qc_check']==3){?><i class="badge bg-green" >Q.C</i> <?php }}?>
                        </td>
                        <td><?php echo $this->Base->change_date_dmy($r['details_save_date']);?></td>
                        <td><?php echo $r['product_invoice_save_no'];?></td>
                        <td><?php echo $r['pname'];?></td>
                        <td><?php echo $r['hsn'];?></td>
                        <td><?php echo $pkg[]=$r['total_package_list'];?></td>
                        <td><?php echo $qty[]=$r['total_qty_list'];?></td>
                        <td><?php echo $r['uname'];?></td>
                        <td><?php echo $r['price'];?></td>
                        <td><?php echo $rs[]=$r['total_amount_list'];?></td>
                        <td><?php echo $r['sname'];?></td>
                        <td style="width:130px;">   
                            <a target="_blank"   href="<?php echo base_url().'index.php/Welcome/home?';?>Po/add_invoice/<?php if(isset($r['product_invoice_entry_id']))echo $r['product_invoice_entry_id']?>"  class="btn btn-warning" style=" float:left;">
                                <i class="nav-icon i-Pen-2"></i>
                            </a>
                        </td>
                        <td style="width:130px;">   
                            <?php  if(!empty($r['raw_material_from'])){
                                
                                $res6 = $this->Pomodel->get_po_invoice_qc_row_test_coils_with_category($r['details_id']);
                                //print_r($res6);
                                ?>
                                <a target="_blank"   href="<?php echo base_url().'index.php/Welcome/home?';?>Qc/add_incoming_qc_test/<?php if(isset($r['details_id']))echo $r['details_id']?>"  
                                <?php if(!empty($res6)){echo " class='btn btn-success' ";} else {echo " class='btn btn-danger' ";} ?>
                                 style=" float:left;">
                                    <i class="nav-icon i-Pen-2"></i>
                                </a>

                               
                            <?php }?>
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
                <th colspan="4"></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($pkg))echo round(array_sum($pkg),2);?></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($qty))echo round(array_sum($qty),2);?></th>
                <th></th>
                <th></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($rs))echo number_format(array_sum($rs),2);?></th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>
</div>