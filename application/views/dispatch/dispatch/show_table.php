
<div >
    <table class="table table-bordered table- table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>No</th>
                <th>Customer</th>
                <th>Vehicle</th>
                <th>Details</th>
                <th style=" color:blue">Total</th>
                <th>Sub Total</th>
                <th>TCS Value</th>
                <th>Grand Total</th>
                <th>Edit</th>
                <th style="width:80px;">Print</th>
            </tr>
        </thead>
        <tbody>
		   <?php 
                 $i=1;
                 foreach($res2 as $r)
                 {
                    $customer_id=$r['customer_id']; 
                    ?>
                    <tr>
                    	<td><?php echo $i;?>. </td>
                        <td><?php echo $this->Base->change_date_dmy($r['entry_date']);?></td>
                        <td>
                            <?php 
                                   echo $r['dispatch_no'];//$this->Dispatchmodel->get_next_bill_no_display($r['dispatch_id']);
                                    if($r['is_it_cancel']==1)
                                    {
                                        ?><br><b><span class="label label-danger">Cancel</span></b><?php
                                    }
                            ?>
                        </td>
                        <td><?php echo $r['cname'];?> </td>
                        <td><?php echo $r['vehicle_no'];?></td>
                        <td>
               						<table class="table table-bordered">
                                            <thead>
                                                <tr  <?php if($r['is_it_cancel']==1){?>style=" background-color:#FFDFEF"<?php }else{?>style=" background-color:#DFF" <?php }?>>
                                                    <th>#</th>
                                                    <th>Product</th>
                                                    <th>Qty</th>
                                                    <th>Unit</th>
                                                    <th>HSN</th>
                                                    <th>Package</th>
                                                    <th>Rate</th>
                                                    <th style=" color:blue">Amount</th>
                                                    <th>Sch. Rate</th>
                                                    <th>Diff. Rate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	<?php
												$package_no=array();
												$qty=array();
												$rate=array();
												$total_amt=array();
												$j=1;
												$dispatch_id=$r['dispatch_id'];
												
												
												$where3=" dispatch_id='$dispatch_id' ";
												//from search filter
												if(!empty($product1))
												{
													$where3.=" and product_id='$product1' ";
												}
												//echo $where3;
												$out=$this->Mymodel->select_where('dispatch_details',$where3);
												foreach($out as $o)
												{
                                                    $product_id=$o['product_id'];
													$where3=" product_id='$product_id' ";
                                                    $out2=$this->Mymodel->select_where('product',$where3);
                                                    
                                                    //schedule rate
                                                    $schedule_details_id = $o['customer_schedule_details_id'];
                                                    $where3=" details_id='$schedule_details_id' ";
                                                    $schDetails = $this->Mymodel->select_where('customer_schedule_details',$where3);
                                                    if(!empty($schDetails)){ 
                                                        $schRate = $schDetails[0]['rate']; 
                                                        $rateDiff = (int)$o['rate'] - (int)$schRate;
                                                    }else{
                                                        $rateDiff = 0;
                                                    }
                                                    
                                                    //Getting customer product name
                                                    //$product_name_customer_called = $this->Mymodel->get_customer_product_name($customer_id,$product_id);
													?>
													<tr style="background-color:white;">
                                                        <td><?php echo $j;?></td>
                                                        <td><?php echo $out2[0]['name'];?></td>
                                                        <td><?php echo $o['qty'];if($r['is_it_cancel']==1){$qty[]=0;}else{$qty[]=$o['qty'];}?></td>
                                                        <td><?php echo $o['unit_name'];?></td>
                                                        <td><?php echo $o['hsn'];?></td>
                                                        <td><?php echo $package_no[]=$o['package_no'];?></td>
                                                        <td><?php echo $rate[]=$o['rate'];?></td>
                                                        <td><?php echo $total_amt[]=$o['total_amt'];?></td>
                                                        <td <?php if($rateDiff != 0) {?>  style="color:red;" <?php }?>>
                                                        <?php 
                                                            //if(!empty($schRate) or $schRate > 0 or $schRate != '0.00' or $schRat != 0.00){echo $schRate;}else{echo "Empty";}
                                                            $emptyVal = 0;
                                                            if(!empty($schDetails[0]['rate']) and (int)$schDetails[0]['rate'] >0){echo $schDetails[0]['rate'];}else{echo "Empty";$emptyVal=1;}
                                                        ?>
                                                        </td>
                                                        <td <?php if($rateDiff != 0) {?>  style="color:red;" <?php }?> ><?php if($rateDiff != 0 and $emptyVal ==0 ) { echo $rateDiff;}?></td>
													</tr>
													<?php
													$j++;
												}
												?>
                                                <tr>
                                                        <td>#</td>
                                                        <td></td>
                                                        <td style="color:black; font-weight:bolder"><?php  if(!empty($qty))echo $qty_total[]= array_sum($qty);?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td style="color:black; font-weight:bolder"><?php  if(!empty($package_no))echo array_sum($package_no);?></td>
                                                        <td style="color:black; font-weight:bolder"><?php  if(!empty($rate))echo array_sum($rate);?></td>
                                                        <td style="color:blue; font-weight:bolder"><?php  if(!empty($total_amt))echo array_sum($total_amt);?></td>
                                                 </tr>
                                            </tbody>
                                    </table>   
                        </td>
                        <td>
                                <span style=" color:blue">
                                <?php  echo $r['total']; if($r['is_it_cancel']==1){$total[]=0;}else{$total[]=$r['total'];}?> 
                                </span>
                                <br>
                                <?php  if(!empty($r['discount_offer'])){echo 'Discount '.$r['discount_offer'].'%';}?> 
                                <br>
                                <?php  if(!empty($r['other_discount_per'])){echo 'Extra Discount '.$r['other_discount_per'].'%';}?> 
                        </td>
                        <td><?php echo $r['grandtotal']; if($r['is_it_cancel']==1){$gtotal[]=0;}else{$gtotal[]=$r['grandtotal'];}?></td>
                        <td><?php echo $r['tds_val']; $tds_val[]=$r['tds_val'];?></td>
                        <td><?php echo $r['grandtotal2']; if($r['is_it_cancel']==1){$gtotal2[]=0;}else{$gtotal2[]=$r['grandtotal2'];}?></td>
                        <td>
                            <a  href="<?php base_url()?>home?Dispatch/add_dispatch/<?php if(isset($r['dispatch_id']))echo $r['dispatch_id']?>" target="_blank"   class="btn btn-warning" >
                                <i class="nav-icon i-Pen-2"></i>
                            </a>
                        </td>
                        <td>
                            <?php $id=$r['dispatch_id']; //$this->Base->encode($r['dispatch_id']);?>
                            <a target="_blank" href="<?php echo base_url()?>index.php/Welcome/print_dispatch/<?php echo $id;?>?page_no=1&item=18" >Page 1</a>
                            <!-- <br><br>
                            <a target="_blank" href="<?php echo base_url()?>index.php/Welcome/print_dispatch/<?php echo $id;?>?page_no=2&item=18" >Page 2</a>
                            <br><br>
                            <a target="_blank" href="<?php echo base_url()?>index.php/Welcome/print_dispatch/<?php echo $id;?>?page_no=3&item=18" >Page 3</a>
                            <br><br>
                            <a target="_blank" href="<?php echo base_url()?>index.php/Welcome/print_dispatch/<?php echo $id;?>?page_no=4&item=18" >Page 4</a> -->
                        </td>
               
                    </tr>
                <?php
                $i++; 
                }
                ?>
        </tbody>
        <tfoot>
            <tr style="background-color:white;">
                <th>#</th>
                <th colspan="4"></th>
                <th style="color:black; font-weight:bolder">Qty Total: <?php  if(!empty($qty_total))echo array_sum($qty_total);?> </th>
                <th style="color:blue; font-weight:bolder"><?php  if(!empty($total))echo array_sum($total);?></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($gtotal))echo array_sum($gtotal);?></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($tds_val))echo array_sum($tds_val);?></th>
                <th style="color:black; font-weight:bolder"><?php  if(!empty($gtotal2))echo array_sum($gtotal2);?></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
<p>In Total cancel bill amt is not added.</p>

</div>