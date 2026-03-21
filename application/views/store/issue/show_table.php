<?php 
   //print_r($res2);
   if(!empty($res2)){
    $date2 = $res2[0]['entry_date'];
    }else{
        $date2 = date('Y-m-d');
    }
   
?>
<div>
    <a target="_blank" href="<?php echo base_url()."index.php/Store/issue_list2?search_date=$date2";?>">
        CONSUMPTION REPORT
    </a>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Edit</th>
                <th>ID</th>
                <th>Date</th>
                <th>Slip No.</th>
                <th>Dept.</th>
                <th>M/C No.</th>
                <th>Category</th>
                <th>Grade</th>
                <th>Lotno</th>
                <th>Product</th>
                <th>Issue Qty</th>
                <th>Issue Pkg</th>
                <th>Issue Amt.</th>
                <th>Received By</th>
                <th>Indentor</th>
                <th>Requested By</th>
            </tr>
        </thead>
        <tbody>
		   <?php 
                $i=1;
               //print_r($res2);
                foreach($res2 as $r)
                {
                    $entry_date = $this->Base->change_date_dmy($r['entry_date']);
                    ?>
                    <tr>
                        <td><?php echo $i;?>.</td>
                        <td>
                            <a  href="<?php base_url()?>home?Store/issue_request/<?php if(isset($r['indent_store_req_id']))echo $r['indent_store_req_id']?>" target="_blank"   class="btn btn-warning" >
                                <i class="nav-icon i-Pen-2"></i>
                            </a>
                        </td>
                        <td><?php if(isset($r['indent_store_req_id'])){echo $r['indent_store_req_id'];}?></td>
                        <td><?php  echo $this->Base->change_date_dmy($r['entry_date']);?>.</td>
                        <td><?php if(isset($r['indent_no'])){echo $r['indent_no'];}?></td>
                        <td><?php if(isset($r['dept_name'])){echo $r['dept_name'];}?></td>
                        <td><?php if(isset($r['mc_name']))echo $r['mc_name'];?></td>
                        <td><?php if(isset($r['cname']))echo $r['cname'];?></td>
                        <td><?php if(isset($r['grade_name']))echo $r['grade_name'];?></td>
                        <td><?php if(isset($r['lotno']))echo $r['lotno'];?></td>
                        <td><?php if(isset($r['pname']))echo $r['pname'];?></td>
                        <td><?php if(isset($r['issuequnt']))echo $issuequnt[] = $r['issuequnt'];?></td>
                        <td><?php if(isset($r['pkg']))echo $pkg[] = $r['pkg'];?></td>
                        <td><?php if(isset($r['amt']))echo $amt[] = $r['amt'];?></td>
                       <td><?php if(!empty($r['receivedby_name'])){echo $r['receivedby_name'];}else{ echo $r['receivedby'];}?></td>
                        <td><?php if(!empty($r['indentor_name'])){echo $r['indentor_name'];}else{ echo $r['indentor'];}?></td>
                        <td><?php if(!empty($r['request_by_name'])){echo $r['request_by_name'];}else{ echo $r['request_by'];}?></td>
                    </tr>
                    <?php
                    $i++; 
                }
            ?>
            <tr>
                <td>#</td>
                <td colspan="10"></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($issuequnt))echo $a1=array_sum($issuequnt);?></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($pkg))echo $a3=array_sum($pkg);?></td>
                <td style="color:black; font-weight:bold"><?php if(!empty($amt))echo $a1=array_sum($amt);?></td>
                
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
</div>