<?php 
 $l = count($res2);
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <tdead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                    <td>#</td>
                    <td>Edit</td>
                    <td>Date</td>
                    <td>Shift</td>
                    <th>Qc Person</th>
                    <th colspan="3">Details</th>
            </tr>
      </thead>
      <tbody>
       

		<?php 
       // print_r($res2);
        
          $i=1;
          foreach($res2 as $r)
          {
            
            if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
            ?>
              <tr>
                  <td><?php echo $i;?>.</td>
                  <td>
                      <a  href="<?php base_url()?>home?Qc/pickling_test_add/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                          <i class="nav-icon i-Pen-2"></i>
                      </a>
                  </td>
                  
                  <td><?php echo $entry_date;?></td>
                  <td><?php if(isset($r['shift']))echo $r['shift'];?></td>
                  <td><?php if(isset($r['qc_person']))echo $r['qc_person'];?></td>
                  <td>
                        <table>
                            <tr>
                                <th colspan="2">Tank 1</th>
                                <th colspan="2">Tank 2</th>
                                <th colspan="2">Tank 3</th>
                            </tr>
                            <tr>
                                <th>Conc</th>
                                <th>Fe Content</th>
                                <th>Conc</th>
                                <th>Fe Content</th>
                                <th>Conc</th>
                                <th>Fe Content</th>
                            </tr>
                            <tr>
                                <td><?php if(isset($r['tank1_connc']))echo $r['tank1_connc'];?></td>
                                <td><?php if(isset($r['tank1_fe']))echo $r['tank1_fe'];?></td>
                                <td><?php if(isset($r['tank2_connc']))echo $r['tank2_connc'];?></td>
                                <td><?php if(isset($r['tank2_fe']))echo $r['tank2_fe'];?></td>
                                <td><?php if(isset($r['tank3_connc']))echo $r['tank3_connc'];?></td>
                                <td><?php if(isset($r['tank3_fe']))echo $r['tank3_fe'];?></td>
                            </tr>
                        </table>
                  </td>


                  <td>
                        <table>
                            <tr>
                                <th colspan="2">GI Tank 1</th>
                                <th colspan="2">GI Tank 2</th>
                                <th >Water Ph</th>
                                <th colspan="2">Flux</th>
                            </tr>
                            <tr>
                                <th>Conc</th>
                                <th>Fe Content</th>
                                <th>Conc</th>
                                <th>Fe Content</th>
                                <th>Water PH</th>
                                <th>flux_gravity</th>
                                <th>flux_temp</th>
                            </tr>
                            <tr>
                                <td><?php if(isset($r['gl_tank1_connc']))echo $r['gl_tank1_connc'];?></td>
                                <td><?php if(isset($r['gl_tank1_fe']))echo $r['gl_tank1_fe'];?></td>
                                <td><?php if(isset($r['gl_tank2_connc']))echo $r['gl_tank2_connc'];?></td>
                                <td><?php if(isset($r['gl_tank2_fe']))echo $r['gl_tank2_fe'];?></td>
                                
                                <td><?php if(isset($r['water_ph']))echo $r['water_ph'];?></td>
                                <td><?php if(isset($r['flux_gravity']))echo $r['flux_gravity'];?></td>
                                <td><?php if(isset($r['flux_temp']))echo $r['flux_temp'];?></td>
                            </tr>
                        </table>
                  </td>

                  <td>
                        <table >
                            <tr>
                                <th colspan="6">PHOSPHATE</th>
                                <th colspan="2">Borex</th>
                            </tr>
                            <tr>
                                <th>Connc</th>
                                <th>Fe</th>
                                <th>FA</th>
                                <th>Acc</th>
                                <th>Cl</th>
                                <th>Temp</th>
                                <th>Connc</th>
                                <th>Temp</th>
                            </tr>
                            <tr>
                                <td><?php if(isset($r['phos_connc']))echo $r['phos_connc'];?></td>
                                <td><?php if(isset($r['phos_fe']))echo $r['phos_fe'];?></td>
                                <td><?php if(isset($r['phos_fa']))echo $r['phos_fa'];?></td>
                                <td><?php if(isset($r['phos_acc']))echo $r['phos_acc'];?></td>

                                <td><?php if(isset($r['phos_cl']))echo $r['phos_cl'];?></td>
                                <td><?php if(isset($r['phos_temp']))echo $r['phos_temp'];?></td>
                                <td><?php if(isset($r['borex_conc']))echo $r['borex_conc'];?></td>
                                <td><?php if(isset($r['borex_temp']))echo $r['borex_temp'];?></td>
                            </tr>
                        </table>
                  </td>
                  
              </tr>
          <?php
          $i++; 
          }
         
          ?>

              
        </tbody>
    </table>
</div>