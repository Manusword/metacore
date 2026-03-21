
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Dept.</th>
                <th>Date</th>
                <th>Rec. / Des.</th>
                <th>Receive From</th>
                <th>Despatch To</th>
                <th>Product</th>
                <th>Size</th>
                <th>Dia</th>
                <th>Oil/ W.O</th>
                <th>Grade</th>
                <th>No. of coil</th>
                <th>Weight</th>
                <th>Unit</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
		   <?php 
                $i=1;
                foreach($res2 as $r)
                {
                    if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
                   ?>
                    <tr>
                        <td><?php echo $i;?>.</td>
                        <td><?php if(isset($r['stock_dept'])){echo $r['stock_dept'];}?></td>
                        <td><?php if(isset($entry_date))echo $entry_date;?></td>
                        
                        <td>
                            <?php if(isset($r['inout'])){
                                if($r['inout'] =="IN"){
                                    echo "Receive";
                                }
                                elseif($r['inout'] =="OUT"){
                                    echo "Despatch";
                                }
                            }?>
                        </td>
                        
                        <td><?php if(isset($r['in_from'])){echo $r['in_from'];}?></td>
                        <td><?php if(isset($r['out_to'])){echo $r['out_to'];}?></td>
                        <td><?php if(isset($r['pname'])){echo $r['pname'];}?></td>
                        <td><?php if(isset($r['psize'])){echo $r['psize'];}?></td>
                        <td><?php if(isset($r['dia']))echo $r['dia'];?></td>
                        <td><?php if(isset($r['oil']))echo $r['oil'];?></td>
                        <td><?php if(isset($r['gname']))echo $r['gname'];?></td>
                        <td><?php if(isset($r['no_of_coils']))echo $no_of_coils[] = $r['no_of_coils'];?></td>
                        <td><?php if(isset($r['weight']))echo $weight[] = $r['weight'];?></td>
                        <td><?php if(!empty($r['uname'])){echo $r['uname'];}?></td>
                        
                        <?php if(isset($r['inout'])){
                            if($r['inout'] =="IN"){
                               ?>
                                <td>
                                    <a href="<?php base_url()?>home?Store/receive_stock_entry/<?php if(isset($r['stock_inout_id']))echo $r['stock_inout_id']?>" target="_blank"  class="btn btn-success" style=" float:left;">
                                    <i class="nav-icon i-Pen-2"></i>
                                    </a>
                                </td>
                               <?php
                            }
                            elseif($r['inout'] =="OUT"){
                                ?>
                                <td>
                                    <a href="<?php base_url()?>home?Store/despatch_stock_entry/<?php if(isset($r['stock_inout_id']))echo $r['stock_inout_id']?>" target="_blank"  class="btn btn-danger" style=" float:left;">
                                    <i class="nav-icon i-Pen-2"></i>
                                    </a>
                                </td>
                               <?php
                            }
                        }?>


                        
                    
                    
                    </tr>
                    <?php
                    $i++; 
                }
            ?>
            <tr>
                <td>#</td>
                <td colspan="10"></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($no_of_coils))echo array_sum($no_of_coils);?></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($weight))echo array_sum($weight);?></td>
               <td></td>
               <td></td>
            </tr>
        </tbody>
    </table>
</div>