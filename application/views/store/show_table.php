
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Category</th>
                <th>Name</th>
                <th>Details</th>
                <th>Grade</th>
                <th>Size</th>
                <th>Min Level</th>
                <th>Re-order Level</th>
                <th>Max Level</th>
                <th></th>
                <th>Total Qty</th>
                <th>Total Cost</th>
                <th>Total Pkg</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
		   <?php 
                $i=1;
                foreach($res2 as $r)
                {
                    $graph = $this->Storemodel->get_compair_graph($r['total_qty'],$r['economic'],$r['reorder'],$r['max_level']);
                    ?>
                    <tr>
                        <td><?php echo $i;?>.</td>
                        <td><?php if(isset($r['product_id'])){echo $r['product_id'];}?></td>
                        <td><?php if(isset($r['cname'])){echo $r['cname'];}?></td>
                        <td><?php if(isset($r['pname']))echo $r['pname'];?></td>
                        <td><?php if(isset($r['details']))echo $r['details'];?></td>
                        <td><?php if(isset($r['gname']))echo $r['gname'];?></td>
                        <td><?php if(isset($r['size']))echo $r['size'];?></td>
                        <td><?php if(isset($r['economic']))echo $r['economic'];?></td>
                        <td><?php if(isset($r['reorder']))echo $r['reorder'];?></td>
                        <td><?php if(isset($r['max_level']))echo $r['max_level'];?></td>
                        <td style="width:150px">
                            <div class="progress mb-3">
                                <div class="progress-bar progress-bar-striped bg-<?php echo $graph[1];?>" role="progressbar" style="width:<?php echo $graph[0];?>%"  aria-valuenow="<?php echo $graph[0];?>" aria-valuemin="0" aria-valuemax="100"><?php echo $graph[0];?>%</div>
                            </div>
                        </td>
                        <td><?php if(isset($r['total_qty']))echo $total_qty[] = $r['total_qty'];?></td>
                        <td><?php if(isset($r['total_cost']))echo $total_cost[] = $r['total_cost'];?></td>
                        <td><?php if(isset($r['total_pkg']))echo $total_pkg[] = $r['total_pkg'];?></td>
                        <td><?php if(!empty($r['uname'])){echo $r['uname'];}?></td>
                    </tr>
                    <?php
                    $i++; 
                }
            ?>
            <tr>
                <td>#</td>
                <td colspan="10"></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($total_qty))echo $a1=array_sum($total_qty);?></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($total_cost))echo $a1=array_sum($total_cost);?> Rs.</td>
                <td style="color:black; font-weight:bold"><?php if(!empty($total_pkg))echo $a3=array_sum($total_pkg);?></td>
                <td colspan="1"></td>
            </tr>
        </tbody>
    </table>
</div>