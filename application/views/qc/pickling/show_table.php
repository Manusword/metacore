<?php 
 $l = count($res2);
?>
<div class="table-responsive">
    <table class="table table-bordered  table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
        <?php if($l>0){?>
            <tr>
                <th style="width:250px">Date</th>
                <th style="width:100px">Range</th>
                <?php 
                    for($i=0; $i<$l; $i++){
                        $date = $this->Base->change_date_dmy($res2[$i]['entry_date']);
                        $shift = $res2[$i]['shift'];
                        echo "<th>".$date.' <br>('.$shift.")</th>";
                    }
                ?>
            </tr>
        <?php }// l?>
      </thead>
      <tbody>
            <?php if($l>0){?>

                <tr><td>QC Person</td> <td></td> <?php for($i=0; $i<$l; $i++){ echo "<td>".$res2[$i]['qc_person']."</td>"; }?></tr>
                
                <tr><td>HCL Tank 1,  Concentration</td> <td><?php echo $min = 3;echo " - "; echo $max= 20; ?></td>  
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['tank1_connc']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                
                
                <tr><td>HCL Tank 1,  Fe (Iron)</td> <td><?php echo $min = 1;echo " - "; echo $max= 12; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['tank1_fe']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>

                <tr><td>HCL Tank 2,  Concentration</td> <td><?php echo $min = 3;echo " - "; echo $max= 16; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['tank2_connc']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>

                <tr><td>HCL Tank 2,   Fe (Iron)</td> <td><?php echo $min = 1;echo " - "; echo $max= 12; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['tank2_fe']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>

                <tr><td>HCL Tank 3,  Concentration</td> <td><?php echo $min = 3;echo " - "; echo $max= 16; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['tank3_connc']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>

                <tr><td>HCL Tank 3,   Fe (Iron)</td> <td><?php echo $min = 1;echo " - "; echo $max= 12; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['tank3_fe']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr style="height:30px;"></tr>



                <tr><td>Flux Gravity</td> <td><?php echo $min = 1;echo " - "; echo $max= 1.02; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['flux_gravity']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                    <tr><td>Flux Temperature</td> <td><?php echo $min = 60;echo " - "; echo $max= 70; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['flux_temp']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>Water PH (Potential of Hydrogen)</td> <td><?php echo $min = 4;echo " - "; echo $max= 6; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['water_ph']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr style="height:30px;"></tr>


                
                <tr><td>PHOSPHATE Concentration</td> <td><?php echo $min = 16;echo " - "; echo $max= 22; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['phos_connc']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>PHOSPHATE  Fe (Iron)</td> <td><?php echo $min = 0;echo " - "; echo $max= 0.48; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['phos_fe']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>PHOSPHATE FA (Phosphoric Acid)</td> <td><?php echo $min = 1;echo " - "; echo $max= 3; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['phos_fa']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>PHOSPHATE Accelerator</td> <td><?php echo $min = 1;echo " - "; echo $max= 3; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['phos_acc']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>PHOSPHATE CL (Chloride)</td> <td><?php echo $min = 1500;echo " - "; echo $max= 1500; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['phos_cl']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>PHOSPHATE Temperature.</td> <td><?php echo $min = 65;echo " - "; echo $max= 75; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['phos_temp']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
               



                <tr><td>Borex Concentration.</td> <td><?php echo $min = 10;echo " - "; echo $max= 15; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['borex_conc']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>Borex Temperature.</td> <td><?php echo $min = 90;echo " - "; echo $max= 95; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['borex_temp']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                

                <tr style="height:40px;"></tr>
                <tr><td>GALVANIZING HCL Tank 1, Concentration</td> <td><?php echo $min = 5;echo " - "; echo $max= 18; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['gl_tank1_connc']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>GALVANIZING HCL Tank 1,  Fe (Iron)</td> <td><?php echo $min = 1;echo " - "; echo $max= 12; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['gl_tank1_fe']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>GALVANIZING HCL Tank 2, Concentration</td> <td><?php echo $min = 5;echo " - "; echo $max= 18; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['gl_tank2_connc']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr><td>GALVANIZING HCL Tank 2,  Fe (Iron)</td> <td><?php echo $min = 1;echo " - "; echo $max= 12; ?></td> 
                    <?php for($i=0; $i<$l; $i++){ $out = $res2[$i]['gl_tank2_fe']; if($out < $min or $out > $max){ $color = "red";}else{$color="";} echo "<td style='color:$color'>".$out."</td>"; }?>
                </tr>
                <tr style="height:40px;"></tr>


            <?php }// l?>

		
              
        </tbody>
    </table>
</div>