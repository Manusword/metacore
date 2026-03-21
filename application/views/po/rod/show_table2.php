
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr style="background-color:white; color:black;">
                <th colspan="3"></th>
                <th>Category 1</th>
                <th>Category 2</th>
                <th>Category 3</th>
                <th>Category 4</th>
                <th>Category 5</th>
            </tr>
            <tr>
                <th>#</th>
                <th>Invoice Date</th>
                <th style="color:black; font-weight:bolder">Product</th>
                <th>(B.L Min-Max) <br>No of Rods<br> Rod List </th>
                <th>(B.L Min-Max) <br>No of Rods<br> Rod List </th>
                <th>(B.L Min-Max) <br>No of Rods<br> Rod List </th>
                <th>(B.L Min-Max) <br>No of Rods<br> Rod List </th>
                <th>(B.L Min-Max) <br>No of Rods<br> Rod List </th>
            </tr>
        </thead>
        <tbody>
       
            <?php 

                $i=1;
               //print_r($res2);
                foreach($res2 as $r)
                {
                   
                    ?>
                    <tr>
                        <td><?php echo $i;?>.
                            <?php  if(isset($r['qc_check'])){if($r['qc_check']==1 or $r['qc_check']==3){?><i class="badge bg-green" >Q.C</i> <?php }}?>
                        </td>
                        <td>
                            Invoice Date: <?php echo $this->Base->change_date_dmy($r['details_save_date']);?><br>
                            Invoice No.: <?php echo  $r['invoice_no'];?><br>
                        </td>
                        <td>
                            Product: <?php echo $r['pname'];?><br>
                            Grade: <?php echo $r['gname'];?><br>
                            Total Rod: <span style='color:blue'><?php echo $r['total_coils'];?></span><br>
                            Min-Max B.L: <span style='color:blue'><?php echo $r['min_bl'].'-'.$r['max_bl'];?></span><br>
                        </td>
                        <td>
                            <?php 
                                $rods_result = $this->Pomodel->po_rod_show_table($r['details_id'],$r['min_bl'],$r['max_bl'],1,$issue);
                                if($rods_result[1] > 0){
                                    $cat1[] =  $rods_result[1]; 
                                    $this->Pomodel->po_rod_show_table_display_rod_box($rods_result);
                                }
                            ?>
                        </td>

                        <td>
                            <?php 
                                $rods_result = $this->Pomodel->po_rod_show_table($r['details_id'],$r['min_bl'],$r['max_bl'],2,$issue);
                                if($rods_result[1] > 0){
                                    $cat2[] =  $rods_result[1]; 
                                    $this->Pomodel->po_rod_show_table_display_rod_box($rods_result);
                                }
                            ?>
                        </td>

                        <td>
                            <?php 
                                $rods_result = $this->Pomodel->po_rod_show_table($r['details_id'],$r['min_bl'],$r['max_bl'],3,$issue);
                                if($rods_result[1] > 0){
                                    $cat3[] =  $rods_result[1]; 
                                    $this->Pomodel->po_rod_show_table_display_rod_box($rods_result);
                                }
                            ?>
                        </td>

                        <td>
                            <?php 
                                $rods_result = $this->Pomodel->po_rod_show_table($r['details_id'],$r['min_bl'],$r['max_bl'],4,$issue);
                                if($rods_result[1] > 0){
                                    $cat4[] =  $rods_result[1]; 
                                    $this->Pomodel->po_rod_show_table_display_rod_box($rods_result);
                                }
                            ?>
                        </td>

                        <td>
                            <?php 
                                $rods_result = $this->Pomodel->po_rod_show_table($r['details_id'],$r['min_bl'],$r['max_bl'],5,$issue);
                                if($rods_result[1] > 0){
                                    $cat5[] =  $rods_result[1]; 
                                    $this->Pomodel->po_rod_show_table_display_rod_box($rods_result);
                                }
                            ?>
                        </td>
                        
                        
                    </tr>
                    <?php
                    //*/
                    $i++; 
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>#</th>
                <th colspan="2">Total</th>
                <td><?php if(!empty($cat1))echo "No of Rods : ".array_sum($cat1);?></td>
                <td><?php if(!empty($cat2))echo "No of Rods : ".array_sum($cat2);?></td>
                <td><?php if(!empty($cat3))echo "No of Rods : ".array_sum($cat3);?></td>
                <td><?php if(!empty($cat4))echo "No of Rods : ".array_sum($cat4);?></td>
                <td><?php if(!empty($cat5))echo "No of Rods : ".array_sum($cat5);?></td>
            </tr>
        </tfoot>
    </table>
</div>