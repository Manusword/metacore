
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                    <th>Status</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Details</th>
                    <th>No Of Days Min Level</th>
                    <th>Min Level</th>
                    <th>Re-order Level</th>
                    <th>Max Level</th>
                    <th>Unit</th>
                    <th>Size</th>
                    <th>Repeated</th>
                    <th>Product Type</th>
                    <th>HSN Code</th>
                    <th>Brand</th>
                    <th>GST% (C/S/I)</th>
                    <th>Rates (P/S)</th>
                    <th>ID</th>
                    <th>Edit / Ledger</th>
            </tr>
        </thead>
        <tbody>
		   <?php 
                 $i=1;
                 foreach($res2 as $r)
                 {
                 ?>
                    <tr>
                        <td><?php echo $i;?>.</td>
                        <td>
                            <?php  if(isset($r['status'])){if($r['status']=='Active'){?><span class="badge badge-success">A</span> <?php }}?>
                            <?php  if(isset($r['status'])){if($r['status']=='Deactive'){?><span class="badge badge-danger">D</span> <?php }}?>
                            <?php  if(isset($r['status'])){if($r['status']=='Pending'){?><span class="badge badge-warning">P</span> <?php }}?>
                            <?php  if(isset($r['status'])){if($r['status']=='Banned'){?><span class="badge badge-warning">B</span> <?php }}?>
                        </td>
                        <td><?php if(isset($r['cat'])){echo $cat= $r['cat'];}?></td>
                        <td><?php if(isset($r['name']))echo $r['name'];?></td>
                        <td><?php if(isset($r['details']))echo $r['details'];?></td>
                        <td><?php if(isset($r['no_of_days']))echo $r['no_of_days'];?></td>
                        <td><?php if(isset($r['economic']))echo $r['economic'];?></td>
                        <td><?php if(isset($r['reorder']))echo $r['reorder'];?></td>
                        <td><?php if(isset($r['max_level']))echo $r['max_level'];?></td>
                        <td><?php if(!empty($r['unit'])){echo $cat= $r['unit'];}?></td>
                        <td><?php if(isset($r['size']))echo $r['size'];?></td>
                        <td>
                            <?php  if(isset($r['repeated'])){if($r['repeated']=='1'){?><span class="badge badge-success">Yes</span> <?php }}?>
                            <?php  if(isset($r['repeated'])){if($r['repeated']=='0'){?><span class="badge badge-danger">NO</span> <?php }}?>
                        </td>
                        <td>
                            <?php 
                            $pt = isset($r['product_type']) ? $r['product_type'] : '';
                            if ($pt === 'RM') {
                                echo '<span class="badge badge-primary">RM</span>';
                            } elseif ($pt === 'Consumable') {
                                echo '<span class="badge badge-warning" style="color: white !important;">Consumable</span>';
                            } else {
                                echo '<span class="badge badge-secondary">Other</span>';
                            }
                            ?>
                        </td>
                        <td><?php if(isset($r['hsn_code'])) echo $r['hsn_code'];?></td>
                        <td><?php if(isset($r['brand'])) echo $r['brand'];?></td>
                        <td>
                            <?php 
                            $cgst = isset($r['cgst']) ? $r['cgst'] : 0;
                            $sgst = isset($r['sgst']) ? $r['sgst'] : 0;
                            $igst = isset($r['igst']) ? $r['igst'] : 0;
                            echo "$cgst% / $sgst% / $igst%";
                            ?>
                        </td>
                        <td>
                            <?php 
                            $p_rate = isset($r['purchase_rate']) ? $r['purchase_rate'] : 0;
                            $s_rate = isset($r['sales_rate']) ? $r['sales_rate'] : 0;
                            echo "P: $p_rate / S: $s_rate";
                            ?>
                        </td>
                        <td><?php if(isset($r['product_id'])){echo $r['product_id'];}?></td>
                        <td>
                            <a  href="<?php base_url()?>home?Product/add/<?php if(isset($r['product_id']))echo $r['product_id']?>" target="_blank"   class="btn btn-warning" >
                                <i class="nav-icon i-Pen-2"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                $i++; 
            }
            ?>
        </tbody>
    </table>
</div>