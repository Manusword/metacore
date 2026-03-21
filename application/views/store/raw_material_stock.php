<?php 
    
    $row = $this->Productmodel->get_row_product_list();
    $row_grade = $this->Base->get_all_grade_row();
    
?>       

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                
                    

                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Raw Materials List</div>
                                <button  onClick="fun_export_xls()" class="btn btn-default">Export to Exls</button>
                                <div id="table_show">
                                
                               
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-sm" id="printed_table">
                                            <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
                                                <tr>
                                                    <th>#</th>
                                                    <th>ID</th>
                                                    <?php 
                                                        foreach($row_grade as $g)
                                                        {
                                                            ?>
                                                            <th><?php echo $g['name'];?></th>
                                                            <?php 
                                                        }
                                                    ?>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                    $grand_total = array();
                                                    $i=1;
                                                    foreach($row as $r)
                                                    {
                                                        $product_id = $r['product_id'];
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i;?>.</td>
                                                            <td><?php if(isset($r['name'])){echo $r['name'];}?></td>
                                                            <?php 
                                                                $total = array();
                                                                foreach($row_grade as $g)
                                                                {
                                                                    $grade_id = $g['id'];
                                                                    $qty = $this->Storemodel->get_stock_qty_from_plg($product_id,'',$grade_id);
                                                                    ?>
                                                                    <td><?php echo $total[] = $qty;?></td>
                                                                    <?php 
                                                                }
                                                                $grand_total[] = $total;
                                                            ?>
                                                            <td style="color:black; font-weight:bold"><?php if(!empty($total))echo $a1[] = array_sum($total);?></td>
                                                        </tr>
                                                        <?php
                                                        $i++; 
                                                    }
                                                ?>
                                                <tr>
                                                    <td>#</td>
                                                    <td colspan="1"></td>
                                                    <?php 
                                                    $gt = $this->Base->add_multi_array($grand_total);
                                                    foreach($gt as $t)
                                                    {
                                                        ?><td style="color:black; font-weight:bold"><?php echo $t;?></td><?php 
                                                    }
                                                    ?>
                                                    <td style="color:black; font-weight:bold"><?php if(!empty($a1))echo array_sum($a1);?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>








                                
                                </div>  
                                 
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/product_js');?>


 
