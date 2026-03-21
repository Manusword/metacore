




   
           
                    
                    <div class="table-responsive">
                        <table id="printed_table" class="display table table-striped table-bordered" id="multicolumn_ordering_table" style="width:100%">
                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                <tr>
                                    <!-- <th># <input type="checkbox" class="form-control" id="search_mail_all_check"  > </th> -->
                                    <th>#</th>
                                    <th>Party</th>
                                    <th>Sales Person</th>
                                    <th>Day's Limit</th>
                                    <th>Amount Limit</th>
                                    
                                    <th>Red (Overdue) </th>
                                    <th>Orange (In a Week)</th>
                                    <th>Green Zone </th>
                                    <th>Total Rem. Payment</th>
                                    
                                    <th>Limit Balance</th>
                                    <th>Follow up On</th>
                                    
                                    <th>#</th>
                                </tr>
                            </thead>
                            
                            
                            <tbody>
                                <?php 
                                  //print_r($res2);
                                  $i=1;
                                  $redzone_amt_arr = array();
                                  $orangezone_amt_arr = array();
                                  $greenzone_amt_arr = array();
                                  $zone_total_arr = array();
                                  foreach($res2 as $r)
                                  {
                                      $customer_id = $r['customer_id'];
                                      if(isset($r['follow_up_date']) and $r['follow_up_date'] != '0000-00-00'){$follow_up_date=$this->Base->change_date_dmy($r['follow_up_date']);}else{$follow_up_date='';}
                                      
                                      if(isset($r['limit_of_days'])){ $limit_days =  $r['limit_of_days'];  } else{ $limit_days = 0; } //day limit
                                      if(isset($r['limit_of_dis'])){ $limit_amt =  $r['limit_of_dis'];  } else{ $limit_amt= 0; }  //limit amt

                                      if(isset($r['redzone_amt'])){ $redzone_amt =  round($r['redzone_amt']);  } else{ $redzone_amt = 0; }  //red zone amt
                                      if(isset($r['orangezone_amt'])){ $orangezone_amt =  round($r['orangezone_amt']);  } else{ $orangezone_amt = 0; }  //orange zone amt
                                      if(isset($r['greenzone_amt'])){ $greenzone_amt =  round($r['greenzone_amt']);  } else{ $greenzone_amt = 0; }  //green zone amt

                                      $zone_total = round($r['redzone_amt'] + $r['orangezone_amt'] + $r['greenzone_amt']);
                                      $limit_balance = round($r['limit_of_dis'] - $zone_total);
                                      if($limit_balance > 0){ $limit_text = $this->Base->money($limit_balance); $limit_color="green";}else{$limit_text = $limit_balance." Limit already exceeded"; $limit_color="red";}
                                    
                                      //array sum
                                      $redzone_amt_arr[] = $r['redzone_amt'];
                                      $orangezone_amt_arr[] = $r['orangezone_amt'];
                                      $greenzone_amt_arr[] = $r['greenzone_amt'];
                                      $zone_total_arr[] = $zone_total;
                                  
                                      //email
                                      if(isset($r['email'])){$email1 =  $r['email'];}
                                      if(isset($r['con_email1'])){ $email2 =$r['con_email1'];}
                                      if(isset($r['con_email2'])){ $email3 =$r['con_email2'];}

                                      
                                      ?>
                                        <tr>
                                            <td>
                                              <?php 
                                                echo $i;
                                                /*
                                                if(strlen($email1) >5 or strlen($email2)>5 or strlen($email3)>5 ){
                                                  ?> 
                                                    <input type="checkbox" class="form-control all_mall_id" name="all_mall_name" value="<?php echo $customer_id?>"  >
                                                  <?php 
                                                }
                                                */
                                                ?>
                                                
                                            </td>

                                                <td>
                                                <span style="color:<?php if(isset($r['disputed_issue']) && $r['disputed_issue'] ==1 )echo "red";?>; "><?php if(isset($r['cname'])){ echo $r['cname'];}?> <?php if(isset($r['disputed_issue']) && $r['disputed_issue'] ==1 )echo "*";?></span>
                                               
                                                
                                                <?php if(!empty($r['con_mob1']) && $r['con_mob1']>0){?>
                                                  <?php echo "<br>".$r['con_name1'].' : '.$r['con_mob1'];?>
                                                <?php } ?>

                                                <?php if(!empty($r['con_mob2']) && $r['con_mob2']>0){?>
                                                  <?php echo "<br>".$r['con_name2'].' : '.$r['con_mob2'];?>
                                                <?php } ?>

                                                <?php if(!empty($email1)){?>
                                                  <a href="mailto:<?php echo $email1;?>">
                                                    <span id="emailBox_<?php echo $i;?>"><?php echo "<br>".$email1;?></span>
                                                  </a>
                                                <?php } ?>
                                                <br>
                                                <span style="color:black; ">No Of Cheque's : <?php if(isset($r['cheque_no']))echo $r['cheque_no'];?></span>
                                              </td>
                                            
                                            <td><?php if(isset($r['sales_person']))echo $r['sales_person'];?></td>
                                            <td><?php if(!empty($limit_days))echo $limit_days;?></td>
                                            <td><?php if(!empty($limit_amt))echo  $this->Base->money($limit_amt); ?></td>
                                            
                                            <td style="color:red;font-weight:bold"><?php  echo  $this->Base->money($redzone_amt); //if($redzone_amt != ''){  echo  $this->Base->money($redzone_amt);}?></td>
                                            <td style="color:orange;font-weight:bold"><?php echo  $this->Base->money($orangezone_amt); //if($orangezone_amt >0 ){ echo  $this->Base->money($orangezone_amt);}?></td>
                                            <td style="color:green;font-weight:bold"><?php echo  $this->Base->money($greenzone_amt); //if($greenzone_amt >0 ){ echo  $this->Base->money($greenzone_amt);}?></td>
                                            <td style="font-weight:bold"><?php echo  $this->Base->money($zone_total); //if($zone_total >0 ){echo  $this->Base->money($zone_total);}?></td>
                                            
                                            <td style="color:<?php echo $limit_color;?>;font-weight:bold"><?php echo $limit_text; ?></td>
                                            
                                            <td>
                                                <?php  
                                                    //agr red + orange abhi bacha hua hai to follow up date pr isse call krna hai 
                                                    echo $follow_up_date;
                                                    
                                                    if( round($redzone_amt + $orangezone_amt) > 0){
                                                      if(date('Y-m-d') >= $this->Base->change_date_ymd($follow_up_date)){echo " <span style='color:red'>Call Now</span> ";} 
                                                    }
                                                    else{
                                                      echo " <span style='color:black'>No Need to call</span> ";
                                                    }
                                                ?>
                                            </td>
                                            
                                            
                                            <td>
                                                <?php $all_value = $limit_days.'~'.$limit_amt.'~'.$redzone_amt.'~'.$orangezone_amt.'~'.$greenzone_amt.'~'.$zone_total.'~'.$limit_text;?>
                                                <button  style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;" type="button" data-toggle="modal" id="<?php echo $customer_id?>" onclick='fun_get_cust_details(this.id,"<?php echo $all_value;?>")'   data-target=".bd-example-modal-lg"> <i class="nav-icon i-Pen-2"></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                  $i++; 
                                }
                                ?>
                            </tbody>
                            
                           
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Total</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <td style="color:red;font-weight:bold"><?php if(!empty($redzone_amt_arr)) {$a = array_sum($redzone_amt_arr);echo  $this->Base->money($a);}?></td>
                                    <td style="color:orange;font-weight:bold"><?php if(!empty($orangezone_amt_arr)) {$b = array_sum($orangezone_amt_arr);echo  $this->Base->money($b);}?></td>
                                    <td style="color:green;font-weight:bold"><?php if(!empty($greenzone_amt_arr)) {$c = array_sum($greenzone_amt_arr);echo  $this->Base->money($c);}?></td>
                                    <td style="font-weight:bold"><?php if(!empty($zone_total_arr)) {$d = array_sum($zone_total_arr);echo  $this->Base->money($d);}?></td>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                
                    



   
   
<script>

  $(document).ready(function () {
    $('#multicolumn_ordering_table').DataTable({
      columnDefs: [{
        targets: [0],
        orderData: [0, 1]
      }, {
        targets: [1],
        orderData: [1, 0]
      }, {
        targets: [5],
        orderData: [5, 0]
      }]
    }); // hidden column
  });
</script>
 
