<?php 
    //geting last no of day rem
    $rem_day_no = $this->Base->get_diff_no_bw_two_days('TODAY','MONTH LAST');
    
    $today_date=date('Y-m-d');
    $last_day_month= date("Y-m-t", strtotime($today_date));
    $date1 = new DateTime($today_date);
    $date2 = new DateTime($last_day_month);
    $interval = $date1->diff($date2);
    $dateDifference= $interval->days;
?>
<style>
   .table-responsive table tbody tr:hover { background-color: transparent; }
</style>


    <div class="table-responsive">
        <table class="table table-bordered" id="printed_table">
            <thead>
                <tr style=" background-color:#e9edf2">
                    <th>#</th>
                    <th style="color:black; font-weight:bolder">Date</th>
                    <th>Customer</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>

            <?php 
                 $i=1;
            
                 foreach($res2 as $r)
                 {
                    $customer_id=$r['customer_id'];  
                    //coutomer limit 
                    $limit_status = $this->Customermodel->get_customer_amt_limtit_status($r['customer_id']);
                   // print_r($limit_status);
                   
                    ?>
                    <tr >
                        <?php  if($r['stage']=='1'){?>
                            <td  title="Full Qty are sended">
                                <?php echo $i;?>. <span class="badge bg-success" >F</span> 
                                <a  href="<?php base_url()?>home?Dispatch/add_schedule/<?php if(isset($r['schedule_id']))echo $r['schedule_id']?>" target="_blank"   class="btn btn-warning" >
                                    <i class="nav-icon i-Pen-2"></i>
                                </a>
                            </td>
                        <?php }else{?>
                            
                            <td title="Some qty us still remaining to send" ><?php echo $i;?>. <span class="badge bg-danger" >R</span>
                                <a  href="<?php base_url()?>home?Dispatch/add_schedule/<?php if(isset($r['schedule_id']))echo $r['schedule_id']?>" target="_blank"   class="btn btn-warning" >
                                    <i class="nav-icon i-Pen-2"></i>
                                </a>
                            </td>
                        <?php }?>

                        <td>
                            <?php  echo $r['customer_po'];?>
                            <br>
                            <span style="color:blue"><?php  echo $r['actual_month'];?></span>
                            <br>
                            <br>
                            <br>
                            From:
                                <br> 
                                <?php echo $invoice_date1 =  $this->Base->change_date_dmy($r['from_date']); ?>
                                <br>
                            To: 
                                <br>
                                <?php echo $invoice_date1 =  $this->Base->change_date_dmy($r['to_date']);?>
                        </td>
                   
                  
                        <td style="width:200px;">
                            <?php echo $r['cname'];?>	 
                            
                            <!--
                            <br>
                            <br>
                            <textarea style="height:100px; width:100%;" id="remarks_<?php echo $r['schedule_id'];?>" onKeyUp="fun_save_schedule_remarks(this.id,this.value)" ><?php if(isset($r['plan_remarks']))echo $r['plan_remarks'];?></textarea>
                        -->
                        </td>
                 
                        <td>
                            <table class="table table-bordered" >
                                    <thead>
                                        <tr style=" background-color:#DFF">
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Grade</th>
                                            <th>Forecast</th>
                                            <th style="color:blue">Qty</th>
                                            <th>Unit</th>
                                            <th>Rate</th>
                                            <th>Amt.</th>
                                            <th style="color:blue">Send Qty</th>
                                            <th>Send Amt</th>
                                            <th style="width:150px;">Progress</th>
                                            <th style="color:#F30">Remaining</th>
                                            <th style="color:#F90">Unit / Day</th>
                                            <th>Dispatch Plan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $send_qty=array();
                                            $qty=array();
                                            $forecast_qty=array();
                                            $send_amt=array();
                                            $total_amt=array();
                                            $rem_qty1=array();
                                            $j=1;
                                            $schedule_id=$r['schedule_id'];
                                            
                                            $where3=" schedule_id='$schedule_id' ";
                                            //from search filter
                                            if(isset($product1))
                                            {
                                                $where3.=" and product_id='$product1' ";
                                            }
                                            if(isset($oil1))
                                            {
                                                $where3.=" and oil='$oil1' ";
                                            }
                                            //echo $where3;
                                            
                                            $out=$this->Mymodel->select_where('customer_schedule_details',$where3);
                                            foreach($out as $o)
                                            {
                                                $product_id = $o['product_id'];
                                                $where3=" product_id='$product_id' ";
                                                $out2=$this->Mymodel->select_where('product',$where3);

                                                ?>
                                                <tr>
                                                    <td><?php echo $j;?></td>
                                                    <td>
                                                        <a style="text-decoration:underline; color:blue" href="#" tittle="Our Product Name" id="id_<?php echo $o['details_id'];?>" onClick="popup_product_his_fun(this.id)" data-toggle="modal" data-target=".popup_product_his" title="Check History">
                                                        <?php echo $out2[0]['name'];?>
                                                        </a>
                                                        <br><span style="font-weight:bold"><?php  echo $o['oil'];?></span>
                                                    </td>
                                                    
                                                    <td><?php if(isset($o['product_grade']))echo $this->Base->get_grade_name_from_id($o['product_grade']);?></td>
                                                    <td style="color:orange; font-weight:bold"><?php if(isset($o['forecast_qty']))echo $forecast_qty[] = $o['forecast_qty'];?></td>
                                                    <td style="font-weight:bolder;color:blue" ><?php echo $qty[]=$o['order_qty'];?></td>
                                                    <td><?php echo $o['unit'];?></td>
                                                    <td style="background-color:<?php if(empty($o['rate'])){ echo "orange";}?>;" ><?php echo $o['rate'];?></td>
                                                    <td><?php echo $total_amt[]=$o['amt'];?></td>
                                                    <td style="font-weight:bolder;color:blue"><?php echo $send_qty[]=$o['send_qty'];?></td>
                                                    <td><?php echo $send_amt[]=$o['send_amt'];?></td>
                                                    <td>
                                                        <?php 
                                                        if($o['send_qty']>0)
                                                        {
                                                            $per=($o['send_qty']/$o['order_qty']);
                                                            $per=round(($per*100));
                                                            
                                                            if($per>0){echo $per."%";}
                                                            {
                                                            ?>
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar progress-bar-success" role="progressbar"  style="width: <?php echo $per;?>%">
                                                                </div>
                                                            </div>
                                                            <?php
                                                            }
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar progress-bar-success" role="progressbar"  style="width:0%">
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        </td>
                                                                
                                                        <td style="color:#F30">
                                                        <?php  
                                                        if($o['send_qty']>0)
                                                        {
                                                            $rem_qty=$o['order_qty']-$o['send_qty'];
                                                            if($rem_qty>0){echo $rem_qty1[]=$rem_qty;}else{$rem_qty1[]=0;}
                                                        }
                                                        ?>
                                                        </td>
                                                        <td style="color:#F90">
                                                        <?php 
                                                        if($o['send_qty']>0)
                                                        {
                                                            if($rem_qty>0 and $dateDifference>0){echo round($rem_qty/$dateDifference);}
                                                        }
                                                        else
                                                        {
                                                            $rem_qty=0;
                                                        }
                                                        echo " ";
                                                        //echo $last_bill_unit_name;
                                                        ?>
                                                        </td>
                                                                                
                                                        <td style=" width:200px;">
                                                        <textarea style="height:50px; width:150px;" id="remarks_<?php echo $o['details_id'];?>" onKeyUp="fun_save_schedule_remarks2(this.id,this.value)" ><?php if(isset($o['plan_remarks']))echo $o['plan_remarks'];?></textarea>
                                                        <br><span style=""><?php  echo $o['proremarks'];?></span>    
                                                    </td>
                                                                                    
                                                </tr>
                                                <?php
                                            $j++;
                                            }
                                        ?>
                                            <tr>
                                                <td>Total</td>
                                                <td></td>
                                                <td></td>
                                                <td style="color:black; font-weight:bolder"><?php  if(!empty($forecast_qty))echo $forecast_qty1=array_sum($forecast_qty);$forecast_qty2[]=$forecast_qty1;?></td>
                                                <td style="color:black; font-weight:bolder"><?php  if(!empty($qty))echo $qty1=array_sum($qty);$qty2[]=$qty1;?></td>
                                            
                                                <td></td>
                                                <td></td>
                                                <td style="font-weight:bolder">
                                                    <?php  if(!empty($total_amt))echo $total_amt1=array_sum($total_amt);$total_amt2[]=$total_amt1;?>
                                                    <br>
                                                    <span style="color:<?php echo $limit_status[2];?>"><?php echo "<br>Limit Balc.: ".$limit_status[1]."<br>";?></span>
                                                </td>
                                                <td style="color:black; font-weight:bolder"><?php  if(!empty($send_qty))echo $send_qty1=array_sum($send_qty);$send_qty2[]=$send_qty1;?></td>
                                                
                                                <td style=" font-weight:bolder"><?php  if(!empty($send_amt))echo $send_amt1=array_sum($send_amt);$send_amt2[]=$send_amt1;?></td>
                                                <td></td>
                                                <td><?php  if(!empty($rem_qty1)){echo $rem_qty2=array_sum($rem_qty1);}else{$rem_qty2=0;}?></td>
                                                <td><?php if($rem_qty2>0 and $dateDifference>0){echo round($rem_qty2/$dateDifference);}?></td>
                                                <td></td>
                                            </tr>
                                </tbody>
                            </table>
                        </td>
                </tr>                            
                <?php
                $i++; 
                }
            ?>

                <tr>
                    <th>#</th>
                    <th colspan="2"></th>
                    <th>
                        <table class="table table-bordered">
                            <tr style=" background-color:#e9edf2">
                                <td style="color:blue; font-weight:bold">Forecast Qty:  </td>
                                <td style="color:blue; font-weight:bold">Total Order Qty:  </td>
                                <td style=" font-weight:bold">Total Amt</td>
                                <td style="color:blue; font-weight:bold">Total Send Qty:</td>
                                <td style=" font-weight:bold">Total Send Amt:</td>
                                <td style="color:black; font-weight:bold">Percent Send</td>
                                <td style="color:blue; font-weight:bold">Remaining</td>
                                <td style="color:blue; font-weight:bold">Avg/Day</td>
                            </tr>
                            <tr>
                                <td style="color:black; font-weight:bold"><?php if(!empty($forecast_qty2))echo $f2=array_sum($forecast_qty2);?> </td>
                                <td style="color:black; font-weight:bold"><?php if(!empty($qty2))echo $a2=array_sum($qty2);?> </td>
                                <td style=" font-weight:bold"><?php  if(!empty($total_amt2))echo array_sum($total_amt2);?></td>
                                <td style="color:black; font-weight:bold"><?php  if(!empty($send_qty2))echo $b2=array_sum($send_qty2);?></td>
                                <td style=" font-weight:bold"><?php  if(!empty($send_amt2))echo array_sum($send_amt2);?></td>
                                <td style="color:black; font-weight:bold"><?php  if(!empty($a2) and !empty($b2))echo round(($b2/$a2)*100);?> %</td>
                                <td style="color:black; font-weight:bold"><?php  if(!empty($a2))echo $rem_qty4=$a2-$b2;?></td>
                                <td style="color:black; font-weight:bold"><?php  if(!empty($a2) and $dateDifference>0)echo round($rem_qty4/$dateDifference);?></td>
                            </tr>
                        </table>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
         
         
<?php 

/*
//old code                
           
          


                $i=1;$old_schedule_no=0;
                foreach($res2 as $r)
                {
                    
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

*/
?>