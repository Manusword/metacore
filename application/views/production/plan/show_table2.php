
<div class="table-responsive" >
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
           <tr>
                <th>#</th>
                <th>Dept</th>
                <th>M/C</th>
                <th>Order No</th>
                <th>Plan Rank</th>
                <th>Coating</th>
                <th>Inlet Grade</th>
                <th>Inlet Size</th>
                <th>Outlet Size</th>
                <th>Outlet Grade</th>
                <th>Order Qty. (kg)</th>
                <th>Prod Qty. (kg)</th>
                <th>Bal Qty. (kg)</th>
                <th>Oil / Dry</th>
                <th>Current Speed</th>
                <th>Coil Wt. (kg)</th>
                <th>Reading (mtr)</th>
                <th>Prod. 100%</th>
                <th>Prod. 75%</th>
                <th>Party Name</th>
                <th>USE ROD No.</th>
                <th>Remarks</th>
                <th>Hours req</th>
                <th>Days req</th>
                <th>Start Date & Time</th>
                <th>End Date Date & Time</th>
                <th>Status</th>
                  
            </tr>
        </thead>
        <tbody>
		    <?php 
            $i=1;
            //print_r($res2);
            $orderArray = array();
            $proArray = array();
            $balArray = array();
            foreach($res2 as $r)
            {
                if(isset($r['startDateTime'])){$startDateTime=$this->Base->change_date_dmy_hisa($r['startDateTime']);}else{$startDateTime='';}
                if(isset($r['startDateTime'])){$startDateTime=$this->Base->change_date_dmy_hisa($r['startDateTime']);}else{$startDateTime='';}
                ?>
                <tr>
                    <td><?php echo $i;?>.</td>
                  
                    <td><?php if(isset($r['dept_name']))echo $r['dept_name'];?></td>
                    <td><?php if(isset($r['mc_name']))echo $r['mc_name'];?></td>
                    <td><?php if(isset($r['orderNo']))echo $r['orderNo'];?></td>
                    <td><?php if(isset($r['planRank']))echo $r['planRank'];?></td>
                    <td><?php if(isset($r['coating']))echo $r['coating'];?></td>
                    <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                    <td><?php if(isset($r['in_size']))echo $r['in_size'];?></td>
                    <td><?php if(isset($r['product_type_name']))echo $r['product_type_name'];?></td>
                    <td><?php if(isset($r['out_size']))echo $r['out_size'];?></td>

                    <td><?php if(isset($r['orderQty']))echo $orderArray[] = $r['orderQty'];?></td>
                    <td><?php if(isset($r['prodQty']))echo $proArray[] = $r['prodQty'];?></td>
                    <td><?php if(isset($r['balQty']))echo $balArray[] = $r['balQty'];?></td>

                    <td><?php if(isset($r['oilDry']))echo $r['oilDry'];?></td>
                    <td><?php if(isset($r['currentSpeed']))echo $r['currentSpeed'];?></td>
                    <td><?php if(isset($r['coilWeight']))echo $r['coilWeight'];?></td>
                    <td><?php if(isset($r['readingMtr']))echo $r['readingMtr'];?></td>
           
                    <td><?php if(isset($r['pro100Per']))echo $r['pro100Per'];?></td>
                    <td><?php if(isset($r['pro75per']))echo $r['pro75per'];?></td>
                    <td><?php if(isset($r['cname']))echo $r['cname'];?></td>

                    <td><?php if(isset($r['useRodList']))echo $r['useRodList'];?></td>
                    <td><?php if(isset($r['remarks']))echo $r['remarks'];?></td>
                    <td><?php if(isset($r['hoursReq']))echo $r['hoursReq'];?></td>
                    <td><?php if(isset($r['DaysReq']))echo $r['DaysReq'];?></td>

                    <td><?php echo $startDateTime;?></td>
                    <td><?php echo $startDateTime;?></td>
                    <td><?php if(isset($r['status']))echo $r['status'];?></td>

                   
                </tr>
            <?php
            $i++; 
            }
            ?>
            <tr>
                <td>#</td>
                <td colspan="9"></td>
                <td><?php if(!empty($orderArray))echo array_sum($orderArray);?></td>
                <td><?php if(!empty($proArray))echo array_sum($proArray);?></td>
                <td><?php if(!empty($balArray))echo array_sum($balArray);?></td>
                <td colspan="14"></td>
            </tr>            
        </tbody>
    </table>
</div>