 
<div class="table-responsive">
    <div class="row"> 

        <?php 
        $i=1;
        $forecast_qty =array();$order_qty =array();$send_qty =array();
        foreach($res2 as $r)
        {
            $grade_id = $r['id'];
            $grade_name = $r['name'];

            $product = $this->Dispatchmodel->product_grade_wise_sales_from_schedule_with_grade_id($grade_id,$search_date1,$search_date2);
            ?>
            <div class="col-md-12" style="margin-top:50px;">
                <table class="table table-bordered table- table-sm" id="printed_table_<?php echo $i;?>" style="width:100%;">
                    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                        <tr style="font-weight:bold;background-color:gray">
                            <td  align="right" style="width:120px"><button  onClick="fun_export_xls3('printed_table_<?php echo $i;?>')" >Export to Exls</button></td>
                            <td colspan='<?php echo count($product)+1;?>' align="center"><?php echo $grade_name;?></td>
                            
                        </tr>
                        <tr>
                            <th>#</th>
                            <?php 
                            foreach($product as $p)
                            {
                                ?> <th><?php echo $p['pname'];?></th> <?php 
                            }
                            ?>
                            <th>Total</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Forecast Qty</td>
                            <?php 
                            $f_qty = array();
                            foreach($product as $p)
                            {
                                
                                ?><td align='center'><?php echo $f_qty[] = round($p['forecast_qty']);?></td> <?php 
                            }
                            ?>
                            <td style="color:black; font-weight:bolder" align="center"><?php  if(!empty($f_qty))echo array_sum($f_qty);?> </td>
                        </tr>

                        <tr>
                            <td>Actual Qty</td>
                            <?php 
                            $o_qty = array();
                            foreach($product as $p)
                            {
                                
                                ?><td align='center'><?php echo $o_qty[] = round($p['order_qty']);?></td> <?php 
                            }
                            ?>
                            <td style="color:black; font-weight:bolder" align="center"><?php  if(!empty($o_qty))echo array_sum($o_qty);?> </td>
                        </tr>


                        <tr>
                            <td>Dispatch Qty</td>
                            <?php 
                            $s_qty = array();
                            foreach($product as $p)
                            {
                                
                                ?><td align='center'><?php echo $s_qty[] = round($p['send_qty']);?></td> <?php 
                            }
                            ?>
                            <td style="color:black; font-weight:bolder" align="center"><?php  if(!empty($s_qty))echo array_sum($s_qty);?> </td>
                        </tr>
                    </tbody>

                </table>
            </div>
            <?php
            $i++; 
        }
        
        ?>




















</div>