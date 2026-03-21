
<div class="table-responsive">
	<table class="table table-bordered table-striped table-sm" id="printed_table">
	    <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
      		<tr>
                <th>#</th>
                <th>PO Date</th>
                <th>PO No</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Disc</th>
                <th>Net</th>
                <th>Amount</th>
                <th>Process</th>
                <th>Received</th>
                <th>Rem</th>
                <th>Print</th>
            </tr>
        </thead>
        <tbody>
		   <?php 
                $i=1;
                $rs=array();
                foreach($res2 as $r)
                {
                    ?>
                    <tr>
                        <td><?php echo $i;?>.</td>
                        <td style="width:100px;"><?php echo $this->Base->change_date_dmy($r['po_date']);?></td>
                        <td><?php if(isset($r['po_no']))echo $r['po_no'];?></td>
                        <td><?php echo $r['sname'];?></td>
                        <td><?php echo $r['pname'];?></td>
                        <td><?php echo $qty[]=$r['qunt'];?></td>
                        <td><?php echo $r['uname']; ?></td>                
                        <td><?php echo $r['rate'];?></td>
                        <td><?php echo $r['disc'];?></td>
                        <td><?php echo $r['net'];?></td>
                        <td><?php echo $rs[]=$r['amount'];?></td>
                        <td width="100px">
				        <?php 
                            $rev2=$r['rev_qunt'];
                            if($rev2>0)
                            {
                                $per=($rev2/$r['qunt']);
                                $per=round(($per*100));
                            }else{$per=0;}
                            echo $per."%";
                            
                            if($rev2<$r['qunt'])
                            {
                                ?>
                                <div class="progress progress-sm">
                                    <div class="progress-bar progress-bar-danger" role="progressbar"  style="width: <?php echo $per;?>%">
                                    </div>
                                </div>
                                <?php 
                            }
                            else
                            {
                                ?>
                                <div class="progress progress-sm">
                                    <div class="progress-bar progress-bar-success" role="progressbar"  style="width: <?php echo $per;?>%">
                                    </div>
                                </div>
                                <?php 
						    }
						?>
                        </td>      
                        <td><?php echo $rev[]=$r['rev_qunt'];?></td>
                        <td><?php if($r['qunt']>0 and $r['rev_qunt']>0){echo $rem[]=$r['qunt']-$r['rev_qunt'];}else{echo $rem[]=0;}?></td>
                        <td> 
                            <a target="_blank" href="<?php echo base_url()?>index.php/Welcome/print_po/<?php echo $r['po_id'];?>" class="btn btn-info">Print</a>
                        </td>
                    </tr>
                    <?php
                    $i++; 
                }//foreach
            ?>
        </tbody>    
        <tfoot>
            <tr>
                <th>#</th>
                <th colspan="3"></th>
                <th style="color:black; font-weight:bolder"></th>
                <th style="color:black; font-weight:bolder"><?php if(!empty($qty))echo number_format(array_sum($qty),2);?></th>
                <th colspan="4"></th>
                <th style="color:blue; font-weight:bolder"><?php if(!empty($rs))echo number_format(array_sum($rs),2);?></th>
                <th></th>
                <th style="color:black; font-weight:bolder"><?php if(!empty($rev))echo number_format(array_sum($rev),2);?></th>
                <th style="color:black; font-weight:bolder"><?php if(!empty($rem))echo number_format(array_sum($rem),2);?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>