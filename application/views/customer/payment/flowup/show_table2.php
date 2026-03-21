<?php 

$date = [];
$orangeData = [];
foreach($res2['orange'] as $r){
  $d = $r['notifi_date'];
  $a = $r['rem_amount'];
  $orangeData[$d] = $a;
  $date[] = $d;
}


$redData = [];
foreach($res2['red'] as $r){
  $d = $r['last_date'];
  $a = $r['rem_amount'];
  $redData[$d] = $a;
  $date[] = $d;
}

$dateList = array_unique($date);

sort($dateList); 
$arrlength = count($dateList); 
for($x = 0; $x < $arrlength; $x++) { 
   $dateList[$x]; 
} 
//print_r($dateList);


?>

<style>
  .listclass{
    display:none;
  }
</style>

<div class="row">


              <div class="card text-center col-sm-2 mb-3 p-1">
                <div class="card-header p-3 bg-dark"  >
                  <h4 style="color:white">Last Month Balance </h4>
                </div>
                <div class="p-3">
                  <h6 >Last Date (End) Amount : 
                    
                  <br>
                  <br>
                  <span style="color:red"><?php if(!empty($res2['total_red_last'][0]['rem_amount'])){echo $this->Base->money($res2['total_red_last'][0]['rem_amount']);}?></span></h6>
                  <br>
                  <button class="btn btn-dark" onclick="fun_show_part_payment_list_datewise('list_00')">Details</button>
                </div>
              </div>

              <div class="listclass alert alert-light col-sm-12  " id="list_00" role="alert">
                  <?php 
                    $filter = array("date wise");
                    if(!empty($fdate_last) and !empty($tdate_last)){ $filter['fdate'] =$fdate_last;  $filter['tdate'] =$tdate_last;}  
                    $total_rem_amount_here = $this->Customermodel->get_payment_history_with_table($search_customer_id,$filter);
                  ?>
              </div>



                <?php 
                  if(!empty($res2['total_red_last'][0]['rem_amount'])){$last_amt = $res2['total_red_last'][0]['rem_amount'];}else{$last_amt=0;}
                  $i = 1;
                  foreach($dateList as $d){

                    ?>
                          
                          <div class="card text-center col-sm-2 mb-3 p-1">
                            <div class="card-header p-3 bg-info"  >
                              <h4 style="color:white"><?php if(!empty($d)){echo $this->Base->change_date_dmy($d);}?></h4>
                            </div>
                            <div class="p-3">
                              
                              <h6 >Reminder (Start) Amount : <span style="color:orange"> <?php if(!empty($orangeData[$d])){echo $this->Base->money($orangeData[$d]);}?></span></h6>
                              
                              <h6 >Last Date (End) Amount : <span style="color:red"><?php if(!empty($redData[$d])){echo $this->Base->money($redData[$d]);}?></span></h6>
                              <h6 >Remi + Last Amount : <span style=""><?php if(!empty($redData[$d]) && !empty($orangeData[$d])){echo $this->Base->money($redData[$d] +  $orangeData[$d]);}?></span></h6>
                              <br>
                              <h6 >Total Rem. Amount : <span style="color:red; font-weight:bold"><?php if(!empty($redData[$d])){ $last_amt = $last_amt + $redData[$d]; echo $this->Base->money($last_amt);}?></span></h6>
                              <button class="btn btn-info" onclick="fun_show_part_payment_list_datewise('list_<?php echo $i;?>')">Details</button>
                            </div>
                              
                          </div>

                          <div class="listclass alert alert-light col-sm-12  " id="list_<?php echo $i;?>" role="alert">
                              <?php 
                                $filter = array("date wise");
                                if(!empty($d)){ $filter['search_date'] =$d;}  
                                $total_rem_amount_here = $this->Customermodel->get_payment_history_with_table($search_customer_id,$filter);
                              ?>
                          </div>
                        
                      <?php
                      $i++;
                  }
                  $i++;
                ?>

              <div class="card text-center col-sm-2 mb-3 p-1">
                <div class="card-header p-3 bg-danger"  >
                  <h4 style="color:white">TOTAL</h4>
                </div>
                <div class="p-3">
                  <h6 >Current Month Amount : 
                  
                  <span style="color:red"><?php if(!empty($res2['total_red'][0]['rem_amount'])){echo $this->Base->money($res2['total_red'][0]['rem_amount']);}?></span></h6>
                  <br>
                  
                  <button class="btn btn-danger" onclick="fun_show_part_payment_list_datewise('list_<?php echo $i;?>')">Details</button>
                </div>
              </div>

              <div class="listclass alert alert-light col-sm-12  " id="list_<?php echo $i;?>" role="alert">
                  <?php 
                    $filter = array("date wise");
                    if(!empty($fdate) and !empty($tdate)){ $filter['fdate'] =$fdate;  $filter['tdate'] =$tdate;}  
                    $total_rem_amount_here = $this->Customermodel->get_payment_history_with_table($search_customer_id,$filter);
                  ?>
              </div>





              <div class="card text-center col-sm-2 mb-3 p-1">
                <div class="card-header p-3 bg-dark"  >
                  <h4 style="color:white">GRAND TOTAL</h4>
                </div>
                <div class="p-3">
                  <h6 >Last Month Pending Amount : 
                    <span style="color:red"><?php if(!empty($res2['total_red_last'][0]['rem_amount'])){echo $this->Base->money($res2['total_red_last'][0]['rem_amount']);}?></span>
                  </h6>

                  <h6 >Current Month Pending Amount : 
                    <span style="color:red"><?php if(!empty($res2['total_red'][0]['rem_amount'])){echo $this->Base->money($res2['total_red'][0]['rem_amount']);}?></span>
                  </h6>
                  
                  <br>
                  
                  <h6 >Total Amount : 
                    <span style="color:red"><?php if(!empty($res2['total_red'][0]['rem_amount']) && !empty($res2['total_red_last'][0]['rem_amount'])){ 
                      echo $this->Base->money($res2['total_red'][0]['rem_amount'] + $res2['total_red_last'][0]['rem_amount']); }?>
                    </span>
                  </h6>


                  <br>
                  
                </div>
              </div>

             
              

</div>









<script>
  //---------------------------------receive payment
  function fun_show_part_payment_list_datewise(id){
    var x = document.getElementById(id);
    if (x.style.display === 'block') {
      x.style.display = 'none';
    } else {
      x.style.display = 'block';
    }

  }
</script>


