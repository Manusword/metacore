 
<div class="table-responsive">
    <div class="row">     
        <div class="col-md-4">
            <table class="table table-bordered table- table-sm" id="printed_table_101" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='5' align="center">State Wise </td>
                        <td  align="right"><button  onClick="fun_export_xls2(1)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>State (Code)</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($state_wise as $r)
                        {
                        ?>
                            <tr>
                                <td><?php echo $i;?>. </td>
                                <td><?php echo $r['state'];?> </td>
                                <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                                <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                                <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                                <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                            </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>









        <div class="col-md-4">               
            <table class="table table-bordered table- table-sm" id="printed_table_102" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='5' align="center">Company Type Wise</td>
                        <td  align="right"><button  onClick="fun_export_xls2(2)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Company Type</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($com_type_wise as $r)
                        {
                        ?>
                        <tr>
                            <td><?php echo $i;?>. </td>
                            <td><?php echo $r['type'];?> </td>
                            <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                            <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                            <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                            <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                        </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>









        <div class="col-md-4">           
            <table class="table table-bordered table- table-sm" id="printed_table_103" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='5' align="center">Sales Person Wise</td>
                        <td  align="right"><button  onClick="fun_export_xls2(3)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Sales Person</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($person_wise as $r)
                        {
                        ?>
                        <tr>
                            <td><?php echo $i;?>. </td>
                            <td><?php echo $r['sales_person'];?> </td>
                            <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                            <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                            <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                            <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                        </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>


        <div class="col-md-6">           
            <table class="table table-bordered table- table-sm" id="printed_table_105" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='5' align="center">Manufacturer Customer Wise</td>
                        <td  align="right"><button  onClick="fun_export_xls2(5)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Customer Name</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($customer_wise1 as $r)
                        {
                        ?>
                        <tr>
                            <td><?php echo $i;?>. </td>
                            <td><?php echo $r['cname'];?> </td>
                            <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                            <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                            <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                            <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                        </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>


        <div class="col-md-6">           
            <table class="table table-bordered table- table-sm" id="printed_table_110" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='5' align="center">Trader Customer Wise</td>
                        <td  align="right"><button  onClick="fun_export_xls2(10)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Trader Name</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($customer_wise2 as $r)
                        {
                        ?>
                        <tr>
                            <td><?php echo $i;?>. </td>
                            <td><?php echo $r['cname'];?> </td>
                            <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                            <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                            <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                            <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                        </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>

       
    </div>























































    <div class="row">
        <div class="col-md-6">           
            <table class="table table-bordered table- table-sm" id="printed_table_106" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='6' align="center">Product Size Wise</td>
                        <td  align="right"><button  onClick="fun_export_xls2(6)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($product_wise as $r)
                        {
                        ?>
                        <tr>
                            <td><?php echo $i;?>. </td>
                            <td><?php echo $r['pname'];?> </td>
                            <td><?php echo $r['size'];?> </td>
                            <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                            <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                            <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                            <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                        </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>



        <div class="col-md-6">           
            <table class="table table-bordered table- table-sm" id="printed_table_107" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='7' align="center">Product Size & Grade Wise </td>
                        <td  align="right"><button  onClick="fun_export_xls2(7)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Size</th>
                        <th>Grade Name</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($product_grade_wise as $r)
                        {
                        ?>
                        <tr>
                            <td><?php echo $i;?>. </td>
                            <td><?php echo $r['pname'];?> </td>
                            <td><?php echo $r['size'];?> </td>
                            <td><?php echo $r['gname'];?> </td>
                            <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                            <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                            <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                            <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                        </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>






















    <div class="row">
        
        <div class="col-md-6">           
            <table class="table table-bordered table- table-sm" id="printed_table_104" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='5' align="center">Grade Wise</td>
                        <td  align="right"><button  onClick="fun_export_xls2(4)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Grade</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($grade_wise as $r)
                        {
                        ?>
                        <tr>
                            <td><?php echo $i;?>. </td>
                            <td><?php echo $r['gname'];?> </td>
                            <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                            <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                            <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                            <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                        </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>           



        <div class="col-md-6">           
            <table class="table table-bordered table- table-sm" id="printed_table_108" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='7' align="center">Grade & Product Size Wise </td>
                        <td  align="right"><button  onClick="fun_export_xls2(8)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Grade Name</th>
                        <th>Product Name</th>
                        <th>Size</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($grade_product_wise as $r)
                        {
                        ?>
                        <tr>
                            <td><?php echo $i;?>. </td>
                            <td><?php echo $r['gname'];?> </td>
                            <td><?php echo $r['pname'];?> </td>
                            <td><?php echo $r['size'];?> </td>
                            <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                            <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                            <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                            <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                        </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    
        
    </div>










    


    <div class="row">
        <div class="col-md-12">           
            <table class="table table-bordered table- table-sm" id="printed_table_109" style="width:100%;">
                <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                    <tr style="font-weight:bold;background-color:gray">
                        <td colspan='10' align="center">Sales Person, State, Company, Product Size & Grade Wise </td>
                        <td  align="right"><button  onClick="fun_export_xls2(9)" >Export to Exls</button></td>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>Sales Person Name</th>
                        <th>State</th>
                        <th>Company</th>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Grade</th>
                        <th>Forecast Qty</th>
                        <th>Order Qty</th>
                        <th>Dispatch Qty</th>
                        <th>Dispatch Amt</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                
                        $i=1;
                         $forecast_qty =array();$order_qty =array();$send_qty =array();$send_amt = array();
                        foreach($sscp_wise as $r)
                        {
                        ?>
                        <tr>
                            <td><?php echo $i;?>. </td>
                            <td><?php echo $r['sales_person'];?> </td>
                            <td><?php echo $r['state'];?> </td>
                            <td><?php echo $r['cname'];?> </td>
                            <td><?php echo $r['pname'];?> </td>
                            <td><?php echo $r['size'];?> </td>
                            <td><?php echo $r['gname'];?> </td>
                            <td align="right"><?php echo $forecast_qty[] = round($r['forecast_qty'],3);?> </td>
                            <td align="right"><?php echo $order_qty[] = round($r['order_qty'],3);?> </td>
                            <td align="right"><?php echo $send_qty[] = round($r['send_qty'],3);?> </td>
                            <td align="right"><?php echo $send_amt[] = round($r['send_amt'],2);?> </td>
                        </tr>
                        <?php
                        $i++; 
                        }
                        ?>
                </tbody>
                <tfoot>
                    <tr style="background-color:white;">
                        <th>Total</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($forecast_qty))echo array_sum($forecast_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($order_qty))echo array_sum($order_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_qty))echo array_sum($send_qty);?> </td>
                        <td style="color:black; font-weight:bolder" align="right"><?php  if(!empty($send_amt))echo array_sum($send_amt);?> </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
















</div>