<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RKS Steel Industries Pvt. Ltd</title>
    <style>
        body{
            background-color: #F6F6F6; 
            margin: 0;
            padding: 0; 
        }
        h1,h2,h3,h4,h5,h6{
            margin: 0;
            padding: 0;
        }
        p{
            margin: 0;
            padding: 0;
        }
        .container{
            width: 90%;
            margin-right: auto;
            margin-left: auto;
        }
        .brand-section{
           background-color: #aa1f34;
           padding: 10px 20px;
        }
        .logo{
            width: 50%;
        }
        .row{
            display: flex;
            flex-wrap: wrap;
        }
        .col-6{
            width: 50%;
            flex: 0 0 auto;
        }
        .text-white{
            color: #fff;
        }
        .company-details{
            float: right;
            text-align: right;
        }
        .body-section{
            padding: 16px;
            border: 1px solid gray;
        }
        .heading{
            font-size: 20px;
            margin-bottom: 08px;
        }
        .sub-heading{
            color: #262626;
            margin-bottom: 05px;
        }
        table{
            background-color: #fff;
            width: 80%;
            border-collapse: collapse;
        }
        table thead tr{
            border: 1px solid #111;
            background-color: #f2f2f2;
        }
        table td {
            vertical-align: middle !important;
            text-align: left;
        }
        table th, table td {
            padding-top: 08px;
            padding-bottom: 08px;
        }
        .table-bordered{
            box-shadow: 0px 0px 5px 0.5px gray;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .text-right{
            text-align: end;
        }
        .w-20{
            width: 20%;
        }
        .float-right{
            float: right;
        }	
</style>
</head>
<body>




    <div class="container">
        <div class="brand-section"><center><h2 class="text-white"><u>RKS Steel Industries Pvt. Ltd</h2></u></center>
            <div class="row" style="margin-top:10px; color:white">
                 <br>
                    <p class="card-text">
                            SP-6, RIICO Industrial Estate, Khushkhera (Bhiwadi) 
                        <br>
                            Teh. Tijara, Dist. Alwar, 301707 Rajasthan(08).
                        <br>
                            Sales Person Name : <?php echo $cdet[0]['sales_person'];?>
                        <br>
                            Contact No : +91-80100 96999
                        <br>
                            Email : gaurav@rkssteel.in
                            
                    </p>
            </div>
        </div>

        <div class="body-section">
            <div class="row">
                <div class="col-6">                  
                    <h3 > Customer Name :  <?php echo $res2[0]['cname'];?>  </h3>
                    <p class="card-text">
                        Address : <?php echo $cdet[0]['address'].', '.$cdet[0]['city'].', '.$cdet[0]['state'];?>
                        <br>
                            <?php if(!empty($cdet[0]['telphone']))echo "Tele : ".$cdet[0]['telphone'];?>, 
                            <?php if(!empty($cdet[0]['email']))echo "Email : ".$cdet[0]['email'];?>  
                        <br>
                            Contact Person 1: <?php echo $cdet[0]['con_name1'];?>, 
                            <?php if(!empty($cdet[0]['con_mob1']))echo "Mob : ".$cdet[0]['con_mob1'];?>, 
                            <?php if(!empty($cdet[0]['con_email1']))echo "Email : ".$cdet[0]['con_email1'];?> 
                        <br>
                            Contact Person 2: <?php echo $cdet[0]['con_name2'];?>, 
                            <?php if(!empty($cdet[0]['con_mob2']))echo "Mob : ".$cdet[0]['con_mob2'];?>, 
                            <?php if(!empty($cdet[0]['con_email2']))echo "Email : ".$cdet[0]['con_email2'];?> 
                    </p>
                </div>
            </div>
        </div> 
                    
        <div class="body-section">

            
            <p class="sub-heading" style="background-color:white; padding:10px; border-radius: 10px;">
                Dear Sir, 
                <br><br>
                Hope you are doing well.
                <br><br>
                This is to draw your kind attention to the gentle reminder to let you know that we have yet to receive payment from your side of the following amount. 
                
                
                <?php 
                    //This is to draw your kind attention to the gentle reminder  of the overdue payments as per the statement of accounts as per attached annexure 
                ?>
                <br><br>
                Since, the payment is getting delayed from your agreed time and credit limit.
                <br><br>
            </p> 

            
            




            <h1 class="heading">
                <center>
                    <u>
                        <i>Payment Details</i>
                    </u>
                </center>
            </h1>
            
             
            
            
            <table class="table-hover" border=1  style="width:100%"  >
                <thead>
                    <tr>
                        <th>Day's Limit</th>
                        <th>Payment Limit (Rs.)</th>
                        <th>Limit Expiry Payment (Rs.)</th>
                        <th>Upcoming Payment (Rs.)</th>
                        <th>Newly Added Payment (Rs.)</th>
                        <th>Total Rem. Payment (Rs.)</th>
                        <th>Limit Balance (Rs.)</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php   
                        $limit_balance = round($cdet[0]['limit_of_dis'] - $res2[0]['rem_amount']);
                        if($limit_balance > 0){ $limit_text = $this->Base->money($limit_balance); $limit_color="green";}else{$limit_text = "Limit already exceeded"; $limit_color="red";}
                    ?>

                    <tr style="font-size:14px">
                        <th><?php  echo $day_limit = $cdet[0]['limit_of_days'];?></th>
                        <th><?php  echo $cdet[0]['limit_of_dis'];?></th>
                        
                        <th style="color:red;font-weight:bold"><?php  if(!empty($res2[0]['redzone_amt']))echo  $this->Base->money($res2[0]['redzone_amt']); ?></th>
                        <th style="color:orange;font-weight:bold"><?php  if(!empty($res2[0]['orangezone_amt']))echo $this->Base->money($res2[0]['orangezone_amt']); ?></th>
                        <th style="color:green;font-weight:bold"><?php  if(!empty($res2[0]['greenzone_amt']))echo $this->Base->money($res2[0]['greenzone_amt']); ?></th>
                        <th><?php  if(!empty($res2[0]['rem_amount']))echo $this->Base->money($res2[0]['rem_amount']); ?></th>

                        
                        
                        
                        <th style="color:<?php echo $limit_color;?>;font-weight:bold">
                            <?php   
                                echo $limit_text;
                            ?>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="body-section" >
            <?php 
                //rem payment in red color
                $filter = array("red rem amt");
                $total_rem_amount_here = $this->Customermodel->get_payment_history_with_table($cdet[0]['id'],$filter);

                $dueDateStart = $this->Customermodel->get_due_date_start_from($cdet[0]['id'],$filter);
                $last_limit_date = "";
                if(!empty($dueDateStart)){
                    $last_limit_date = "since ".$this->Base->change_date_dmy($dueDateStart);
                }
                
                
            ?>
        </div>


        <div class="body-section" style="background-color:white;">
            <p> 
                <br><br>
                    <p>
                        <?php 
                           

                            if(!empty($res2[0]['redzone_amt']) and  $res2[0]['redzone_amt']> 0){
                                echo  "Your overdue amount is Rs. <b>".$this->Base->money($res2[0]['redzone_amt'])."/-</b>";
                                echo "   $last_limit_date.";
                            } 


                        ?> 
                    </p>

                    <br>
                    <p> <span style="font-weight:bold;color:red; ">  Important note:</span> <b>Kindly release the payment immediately otherwise you have to bear the interest @24% p.a. as mentioned.  </b></p>


                    <br>
                    <p style="font-weight:bold;color:orange; ">Please Note: Its a humble request that we do not accept payment through cheques, only through RTGS and NEFT payments are accepted.</p>

                    <p>
                        <?php 
                            $next_limit_date = $this->Base->change_date_dmy($this->Base->add_no_of_days_in_date_ymd(date('d-m-Y'),"+7"));

                            if(!empty($res2[0]['orangezone_amt']) and  $res2[0]['orangezone_amt']> 0){
                                echo  "Next payment Rs. <b>".$this->Base->money($res2[0]['orangezone_amt'])."/-</b>";
                                echo "  is getting due by $next_limit_date.";
                            } 
                        ?> 
                    </p>
                    <br>

                    <p>
                        <?php 
                            if((!empty($res2[0]['limit_of_dis'])) and (!empty($res2[0]['rem_amount'])) and $cdet[0]['limit_of_dis'] >0 and $limit_balance <= 0){
                                $limit_of_dis_payment = $res2[0]['limit_of_dis'];
                                $total_rem_payment = $res2[0]['rem_amount'];
                                if($total_rem_payment > $limit_of_dis_payment){
                                    $over_limit = round($total_rem_payment - $limit_of_dis_payment);
                                    echo " This amount Rs. <b>". $this->Base->money($over_limit)."/-</b> is exceeding from your credit limit.  ";
                               }
                            } 
                        ?> 
                    </p>
                    <br>
                    
                   
                
                <br>
                Hence, you are requested to kindly release the overdue payment as per account details as mentioned above.
                <br><br>
                
                <p style="font-weight:bold;color:#240a94; text-decoration:underline">
                As per government guidelines of MSME, the payment is to be released within 15 days, if terms are not agreed, and maximum 45 days if the terms are agreed. Otherwise if the payment is not done in these manner, the overdue amount will be considered as income and will also attract income tax, interest and penalty etc.
                </p> 
                <br><br>

                Your prompt action will be highly appreciated.
                <br><br>
                This will help us strengthen our business relationship and grow mutually.
                <br><br>
                

                Thanking You,
                <br><br>
                From:
                <br>
                <b>RKS STEEL INDUSTRIES PVT.LTD.</b>

                <br><br>
                <h2 style="font-weight:bold;color:red; ">This is system generated mail.</h2>
            </p>
        </div> 
    </div>             
</body>
</html>