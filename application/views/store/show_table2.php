
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Category</th>
                <th>Name</th>
                <th>Details</th>
                <th>Size</th>
                
                <th>Grade</th>
                <th>Total Qty</th>
                <th>Total Cost</th>
                <th>Total Pkg.</th>
                <th>Unit</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
		   <?php 
                $i=1;
                foreach($res2 as $r)
                {
                    ?>
                    <tr id="fullrowid_<?php echo $i;?>">
                        <td><?php echo $i;?>.<input type="hidden" class=" productid" id="productid_<?php echo $i;?>" value="<?php if(isset($r['product_id']))echo$r['product_id'];?>"></td>
                        <td><?php if(isset($r['product_id'])){echo $r['product_id'];}?></td>
                        <td><?php if(isset($r['cname'])){echo $r['cname'];}?></td>
                        <td><?php if(isset($r['pname']))echo $r['pname'];?></td>
                        <td><?php if(isset($r['details']))echo $r['details'];?></td>
                        <td><?php if(isset($r['size']))echo $r['size'];?></td>
                        <td>
                            <select class="form-control" id="totalgrade_<?php echo $i;?>">
                                <option value="">None</option>
                                <?php 
                                foreach($grade as $d){
                                ?>
                                    <option <?php if(isset($r['product_grade_id'])){if($r['product_grade_id']==$d['id']){echo "selected";}}?> value="<?php echo $d['id'];?>">
                                        <?php echo $d['name'];?>
                                    </option>
                                <?php }?>
                            </select>
                        </td>
                        <td><input type="number" class="form-control totalqty" id="totalqty_<?php echo $i;?>" value="<?php if(isset($r['recive_stock_level']))echo $total_qty[] = $r['recive_stock_level'];?>"></td>
                        <td><input type="number" class="form-control totalcost" id="totalcost_<?php echo $i;?>" value="<?php if(isset($r['recive_stock_level_cost']))echo $total_cost[] = $r['recive_stock_level_cost'];?>"></td>
                        <td><input type="number" class="form-control totalpkg" id="totalpkg_<?php echo $i;?>" value="<?php if(isset($r['pkg']))echo $total_pkg[] = $r['pkg'];?>"></td>
                        <td><?php if(!empty($r['uname'])){echo $r['uname'];}?></td>
                        <td>
                            <select class="form-control" id="status_<?php echo $i;?>">
                                <option <?php if(isset($r['status'])){if($r['status']==0){echo "selected";}}?> value="0">Active</option>
                                <option <?php if(isset($r['status'])){if($r['status']==1){echo "selected";}}?> value="1">Deleted</option>
                            </select>
                        </td>
                        <td><input type="button" class="btn btn-success" onclick="fun_update_stock_row(this.id)" id="storeupdaterow_<?php echo $i;?>" class="btn" name="update" value="Update" ></td>
                        
                    </tr>
                    <?php
                    $i++; 
                }
            ?>
           
        </tbody>
    </table>
</div>