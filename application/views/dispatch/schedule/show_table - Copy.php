<?php 
    //geting last no of day rem
    $rem_day_no = $this->Base->get_diff_no_bw_two_days('TODAY','MONTH LAST');
?>
<div class="table-responsive">
    <table class="table table-bordered table- table-sm" id="printed_table" border=1>
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Edit</th>
                <th>ID</th>
                <th>Date</th>
                <th>W.Ord No.</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Grade</th>
                <th>Forecast Qty</th>
                <th>Order Qty</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Order Amt.</th>
                <th>Dispatch Qty</th>
                <th>Dispatch Amt.</th>
                <th></th>
                <th>For. - Dis. Qty.</th>
                <th>Qrd - Dis Qty</th>
                
                <th>Avg</th>
            </tr>
        </thead>
        <tbody>
           <?php 
           
          


                $i=1;$old_schedule_no=0;
                foreach($res2 as $r)
                {
                    //coutomer limit 
                    $limit_status = $this->Customermodel->get_customer_amt_limtit_status($r['customer_id']);
                    print_r($limit_status);

                    if(!empty($r['order_qty']) and !empty($r['send_qty']))
                    {
                        $per = round(($r['send_qty']/$r['order_qty'])*100);
                    }else{$per = 0;}

                    if(isset($r['schedule_id'])){$schedule_id =  $r['schedule_id'];}else{$schedule_id='';}
                    if(isset($r['schedule_save_date'])){$schedule_save_date =  $this->Base->change_date_dmy($r['schedule_save_date']);}else{$schedule_save_date='';}
                    if(isset($r['customer_po'])){$customer_po =  $r['customer_po'];}else{$customer_po='';}
                    if(isset($r['cname'])){$cname =  $r['cname'];}else{$cname='';}
                    ?>
                    <tr>
                        <td><?php echo $i;?>.</td>
                        <td>
                            <?php if($old_schedule_no != $schedule_id){?>
                            <a  href="<?php base_url()?>home?Dispatch/add_schedule/<?php if(isset($r['schedule_id']))echo $r['schedule_id']?>" target="_blank"   class="btn btn-warning" >
                                <i class="nav-icon i-Pen-2"></i>
                            </a>
                            <?php }?>
                        </td>
                        <td><?php  if($old_schedule_no != $schedule_id)echo $schedule_id;?></td>
                        <td><?php  if($old_schedule_no != $schedule_id){echo $schedule_save_date; echo "<br>"; echo ''.$r['area_location'].'';}?></td>
                        <td><?php  if($old_schedule_no != $schedule_id){echo $customer_po; echo "<br>"; echo ''.$r['sales_person'].''; }?></td>
                        <td><?php  if($old_schedule_no != $schedule_id){echo $cname;}?></td>
                        <td><?php if(isset($r['pname']))echo $r['pname'];?></td>
                        <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                        <td style="color:orange; font-weight:bold"><?php if(isset($r['forecast_qty']))echo $forecast_qty[] = $r['forecast_qty'];?></td>
                        <td style="color:blue; font-weight:bold"><?php if(isset($r['order_qty']))echo $order_qty[] = $r['order_qty'];?></td>
                        <td><?php if(isset($r['unit']))echo $r['unit'];?></td>
                        <td><?php if(isset($r['rate']))echo $r['rate'];?></td>
                        <td><?php if(isset($r['amt']))echo $order_amt2[] = $r['amt'];?></td>
                        <td style="color:blue; font-weight:bold"><?php if(isset($r['send_qty']))echo $send_qty[] = $r['send_qty'];?></td>
                        <td><?php if(isset($r['send_amt']))echo $send_amt[] = $r['send_amt'];?></td>
                        <td style="width:150px">
                            <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width:<?php echo $per;?>%"  aria-valuenow="<?php echo $per;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $per;?>%</div>
                            </div>
                        </td>
                        <td style="color:orange;"><?php if(!empty($r['forecast_qty'])){echo $rem3 = round((float)$r['forecast_qty'] - (float)$r['send_qty'],3); $rem33[] = $rem3;}else{$rem3 = 0;}?></td>
                        <td style="color:blue; "><?php if(!empty($r['order_qty'])){echo $rem = round((float)$r['order_qty'] - (float)$r['send_qty'],3); $rem2[] = $rem;}else{$rem= 0;}?></td>
                        
                        <td><?php if($rem>0 and $rem_day_no>0){echo round($rem/$rem_day_no);}?></td>
                    </tr>
                    <?php
                    $i++;
                    $old_schedule_no = $schedule_id; 
                }
            ?>
            <tr>
                <td>#</td>
                <td colspan="7"></td>
                <td style="color:orange; font-weight:bold"><?php if(!empty($forecast_qty))echo $a2 = array_sum($forecast_qty);?></td>
                <td style="color:blue; font-weight:bold"><?php if(!empty($order_qty))echo $a1 = array_sum($order_qty);?></td>
                <td></td>
                <td></td>
                <td style="color:black; font-weight:bold"><?php //if(!empty($order_amt2))echo $a7 = array_sum($order_amt2);?></td>
                <td style="color:blue; font-weight:bold"><?php if(!empty($send_qty))echo $a3 = array_sum($send_qty);?></td>
                <td style="color:black; font-weight:bold"><?php //if(!empty($send_amt))echo $a4 = array_sum($send_amt);?></td>
                <td></td>
                <td style="color:orange; font-weight:bold"><?php if(!empty($rem33)){echo $a6 = array_sum($rem33);}else{$a6=0;}?></td>
                <td style="color:blue; font-weight:bold"><?php if(!empty($rem2)){echo $a5 = array_sum($rem2);}else{$a5=0;}?></td>
               
                <td><?php if($a5>0 and $rem_day_no>0){echo round($a5/$rem_day_no);}?></td>
            </tr>
        </tbody>
    </table>
</div>