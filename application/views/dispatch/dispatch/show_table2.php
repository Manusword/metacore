 
<div class="table-responsive">
    <table class="table table-bordered table- table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <?php if($customer_hide != 'Yes'){?><th>Customer</th><?php }?>
                <th>Product</th>
                <th>Dispatch Qty</th>
            </tr>
        </thead>
        <tbody>
		   <?php 
                 $i=1;
                 foreach($res2 as $r)
                 {
                   ?>
                    <tr>
                    	<td><?php echo $i;?>. </td>
                        <?php if($customer_hide != 'Yes'){?><td><?php echo $r['cname'];?> </td><?php }?>
                        <td><?php echo $r['pname'];?> </td>
                        <td><?php echo $qty_total[] = round($r['qty'],3);?> </td>
                    </tr>
                <?php
                $i++; 
                }
                ?>
        </tbody>
        <tfoot>
            <tr style="background-color:white;">
                <th>#</th>
                <?php if($customer_hide != 'Yes'){?><th></th><?php }?>
                <th></th>
                <th style="color:black; font-weight:bolder">Qty Total: <?php  if(!empty($qty_total))echo array_sum($qty_total);?> </th>
            </tr>
        </tfoot>
    </table>
<p>In Total cancel bill amt is not added.</p>

</div>