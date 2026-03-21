

<?php /*


   
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Zero configuration</h4>
                    <p>DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</p>
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered" id="multicolumn_ordering_table" style="width:100%">
                        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </thead>
                            
                            
                            <tbody>
                                <tr>
                                    <td>Tiger Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011/04/25</td>
                                    <td>$320,800</td>
                                </tr>
                                
                                
                                <tr>
                                    <td>Shad Decker</td>
                                    <td>Regional Director</td>
                                    <td>Edinburgh</td>
                                    <td>51</td>
                                    <td>2008/11/13</td>
                                    <td>$183,000</td>
                                </tr>
                                <tr>
                                    <td>Michael Bruce</td>
                                    <td>Javascript Developer</td>
                                    <td>Singapore</td>
                                    <td>29</td>
                                    <td>2011/06/27</td>
                                    <td>$183,000</td>
                                </tr>
                                <tr>
                                    <td>Donna Snider</td>
                                    <td>Customer Support</td>
                                    <td>New York</td>
                                    <td>27</td>
                                    <td>2011/01/25</td>
                                    <td>$112,000</td>
                                </tr>
                            </tbody>
                            
                            
                            
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
                    
*/?>





<div class="table-responsive">
<table class="table table-bordered"  style="width:100%">
    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      <tr>
          <th>#</th>
          
          <th>Customer</th>
         

          <?php /*
          <th>Date</th>
           <th>Mobile</th>
          <th>Total Dr.</th>
          <th>Total Cr.</th>
          <th>Total Rem.</th>
          <th>Limit.</th>
          <th>Rem.</th>
          */?>
          
          <th>Day's Limit</th>
          <th> > 60 Day's</th>
          <th> > 45 Day's</th>
          <th> > 30 Day's</th>
          <th> 20-30 Day's</th>
          <th>New Payment 0-20 Day's</th>

          <th>Total Rem. Payment (Rs)</th>
          <th>Credit Limit (Rs.)</th>
          <th>Balance (Rs.)</th>

          
          <th>Flow-up</th>
        </tr>
    </thead>
    <tbody>
      <?php 
        //print_r($res2);
        $i=1;
        $amount1 = array();
        $amount2 = array();
        $amount3 = array();
        $amount4 = array();
        foreach($res2 as $r)
        {
          $customer_id = $r['customer_id'];
          
          if(isset($r['last_date'])){$entry_date=$this->Base->change_date_dmy($r['last_date']);}else{$entry_date='';}
          if(isset($r['damt']) and isset($r['camt'])){ $rem_amt = round($r['damt']-$r['camt']); } else{$rem_amt = 0;}
          
          //amount limit
          if(isset($r['limit_of_dis'])){ $limit_amt =  $r['limit_of_dis']; $bal_amt = round($rem_amt - $r['limit_of_dis']);  } else{ $limit_amt= 0; $bal_amt=0;}
          
          
          //day limit
          if(isset($r['limit_of_days'])){ $limit_days =  $r['limit_of_days'];  } else{ $limit_days = 0; }
          ?>
          <tr>
                <td><?php echo $i;?></td>
                
                <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                
                
                <?php /*
                <td><?php if(isset($entry_date))echo $entry_date;?></td>
                <td> 
                    <?php 
                      if(!empty($r['telphone'])){echo $r['telphone'];}
                      if(!empty($r['con_mob1'])){echo ', '.$r['con_mob1'];}
                      if(!empty($r['con_mob2'])){echo ', '.$r['con_mob2'];}
                    ?>
                </td>
                <td><?php if(isset($r['damt']))echo $amount1[] = (float)$r['damt'];?></td>
                <td><?php if(isset($r['camt']))echo $amount2[] = (float)$r['camt'];?></td>
                <td><?php if(!empty($rem_amt))echo $amount3[] = $rem_amt;?></td>
                <td><?php if(!empty($limit_amt))echo $limit_amt;?></td>
                <td><?php if(!empty($bal_amt))echo $amount4[] = $bal_amt;?></td>
                */?>
                
                
                <td><?php if(!empty($limit_days))echo $limit_days;?></td>
                <td ><?php  $rem_60 = $this->Customermodel->get_payment_within_date(60,$customer_id); if($rem_60 >0){echo $rem_60;}  ?> </td>
                <td ><?php  $rem_45 = $this->Customermodel->get_payment_within_date2(60,45,$customer_id);  if($rem_45 >0){echo $rem_45;} //fromDay is > -60 and <=to date ?> </td>
                <td ><?php  $rem_30 = $this->Customermodel->get_payment_within_date2(45,30,$customer_id);  if($rem_30 >0){echo $rem_30;} ?> </td>
                
                <td style="color:orange;font-weight:bold"><?php  $rem_20 = $this->Customermodel->get_payment_within_date2(30,20,$customer_id);  if($rem_20 >0){echo $rem_20;} ?> </td>
                <td style="color:green;font-weight:bold"><?php  $rem_1 = $this->Customermodel->get_payment_within_date2(20,0,$customer_id);  if($rem_1 >0){echo $rem_1;} ?> </td>
                
                <td><?php  echo $total_rem = ($rem_60 + $rem_45 + $rem_30 + $rem_20 + $rem_1); // ?> </td>
                <td><?php if(!empty($limit_amt))echo $limit_amt;?></td>
                
                <?php 
                  $bal_limit_min_total_rem = round($total_rem - $limit_amt);
                  if($bal_limit_min_total_rem > 0){ $limit_color = "red";}else{ $limit_color = "green";}
                ?>
                <td style="color:<?php echo $limit_color;?>;font-weight:bold"><?php echo $bal_limit_min_total_rem;?></td>
                
                
               

                <td>
                  <?php 
                    $all_value = $limit_days.'~'.$rem_60.'~'.$rem_45.'~'.$rem_30.'~'.$total_rem.'~'.$limit_amt.'~'.$bal_limit_min_total_rem.'~'.$rem_20.'~'.$rem_1;
                  ?>
                  <button  style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;" type="button" data-toggle="modal" id="<?php echo $customer_id?>" onclick='fun_get_cust_details(this.id,"<?php echo $all_value;?>")'   data-target=".bd-example-modal-lg">Follow up</button>
                </td>


            <tr>
					<?php
        $i++; 
      }
      ?>
    </tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><?php if(!empty($amount1))echo $a = array_sum($amount1);?></td>
                <td><?php if(!empty($amount2))echo $b = array_sum($amount2);?></td>
                <td><?php if(!empty($a) and !empty($b)) echo round($a-$b,2);?></td>
                <td></td>
            <tr>
  </table>


   
   
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
        targets: [4],
        orderData: [4, 0]
      }]
    }); // hidden column
  });
</script>
 
