<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>Date</th>
                  <th colspan="3" align='center'>9HA</th>
                  <th colspan="3" align='center'>9HB</th>
                  <th colspan="3" align='center'>9HC</th>
                  <th colspan="3" align='center'>10-H.SL</th>
                  <th colspan="3" align='center'>WD  7-H</th>
                  <th colspan="3" align='center'>3 H</th>
                  <th colspan="3" align='center'>6 H</th>
                 
                  
                  <th colspan="3" align='center'>7-H-  (STL) (400)</th>
                  <th colspan="3" align='center'>10-H (STL)</th>
                  <th colspan="3" align='center'>09-H MINI-2 (400)</th>
                  <th colspan="3" align='center'>Mini 4</th>
                  <th colspan="3" align='center'>Mini 5</th>


                  <th colspan="3" align='center'>W-01</th>
                  <th colspan="3" align='center'>W-02</th>
                  <th colspan="3" align='center'>W-03</th>
                  <th colspan="3" align='center'>W-04</th>
                  <th colspan="3" align='center'>W-05</th>
                  <th colspan="3" align='center'>W-06</th>
                  <th colspan="3" align='center'>W-07</th>
                  <th colspan="3" align='center'>W-08</th>
                  <th colspan="3" align='center'>W-09</th>
                  <th colspan="3" align='center'>W-10</th>
                  <th colspan="3" align='center'>W-11</th>
                  <th colspan="3" align='center'>W-12</th>
                  <th colspan="3" align='center'>W-13</th>
                  <th colspan="3" align='center'>W-14</th>
                  <th colspan="3" align='center'>W-15</th>
                  <th colspan="3" align='center'>W-16</th>
                  <th colspan="3" align='center'>W-17</th>
                  <th colspan="3" align='center'>W-18</th>
                  


                  
            </tr>
        </thead>

            <tr>
                <td></td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>
                <td>KG</td><td>KWH</td><td>KWH/KG</td>

            
            </tr>
      <tbody>
        <?php 
        $today = date('Y-m-d');
        $i=0;
        foreach($res2 as $r)
        {
                if(isset($r)){$entry_date2 = $this->Base->change_date_ymd($r);}else{$entry_date2='';}
                
                $pro = $this->Maintenancemodel->get_kg_kwh_with_search($entry_date2);
			    $kwh = $this->Productionmodel->get_kg_kwh_with_search($entry_date2);

               if($entry_date2 <= $today)
               {
                
                    ?>
                        <tr>
                            <td><?php echo $r;?></td>
                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WD1'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WD1'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WD2'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WD2'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WD3'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WD3'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WD4'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WD4'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WD5'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WD5'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WD6'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WD6'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WD7'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WD7'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>




                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['MINI1'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['MINI1'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['MINI2'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['MINI2'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['MINI3'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['MINI3'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['MINI4'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['MINI4'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['MINI5'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['MINI5'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>


                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET1'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET1'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET2'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET2'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET3'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET3'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET4'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET4'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET5'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET5'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET6'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET6'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET7'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET7'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET8'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET8'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET9'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET9'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET10'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET10'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET11'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET11'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET12'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET12'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>
                            
                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET13'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET13'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET14'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET14'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET15'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET15'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET16'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET16'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET17'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET17'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>

                            <td align="right"><?php if(isset($kwh[0]['WD1']))echo $ec = $kwh[0]['WET18'];?></td>
                            <td align="right"><?php if(isset($pro[0]['WD1']))echo $kg = $pro[0]['WET18'];?></td>
                            <td align="right"><?php if($ec >0 and $kg>0)echo round($ec/$kg,2);?></td>



                            
                        </tr>
                    <?php
               }//today date

        $i++;
        }
        ?>
          <tr>
              <td>#</td>
                <td colspan="3"></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($total_reading))echo $a2=array_sum($total_reading);?></td>
                <td></td>                                         
          </tr>            
        </tbody>
    </table>
</div>