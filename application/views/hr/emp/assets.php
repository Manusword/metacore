<?php 
  $canEdit = $this->Company->checkPermission3("Hr/emp_edit_access");
?>

<div class="">
    <table class="table table-bordered table-striped table-sm" id="printed_table" >
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Edit</th>
                <th>DP</th>
                <th>Name</th>
                <th>Mob</th>
                <th>Emp Code</th>
                <th>Unit</th>
                <th>Dept. Desi.</th>

                <th>Asset Issue</th>
               
            </tr>
        </thead>
        <tbody>
            <?php 
                $i=1;
                foreach($res2 as $r)
                {
                   if(empty($r['asset_issue'])) continue;
                    ?>
                    <tr>
                        <td>
                            <?php echo $i;?>
                             <br>
                                <?php 
                                    //master roll
                                    if(isset($r['mater_roll']) and $r['mater_roll'] == "Yes")
                                    { 
                                        ?>
                                            <span class="badge badge-danger">M</span>
                                        <?php
                                    }
                                ?>
                        </td>
                        <td> 
                            <?php if($canEdit): ?>
                                <a  href="<?php base_url()?>home?Hr/add_emp/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
                                    <i class="nav-icon i-Pen-2"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php
                                $profile_pic = $r['profile_pic'] ?? '';
                                $fname = trim($r['first_name'] ?? '');
                                $letter = $fname !== '' ? strtoupper($fname[0]) : '?';

                                if (strlen($profile_pic) > 0) {
                                    $this->Base->emp_dp_from_emp_code($r['emp_code'], 40, 40);
                                } else {
                                    ?>
                                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold"
                                        style="width:40px;height:40px;">
                                        <?= $letter ?>
                                    </div>
                                    <?php
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                                if(isset($r['active']) and $r['active']=='Active')
                                { 
                                    if(isset($r['first_name'])){echo $name1=$r['first_name'].' ';}if(isset($r['last_name'])){echo $r['last_name'];}
                                }
                                if(isset($r['active']) and $r['active']=='Deactive')
                                {
                                    ?><span style="color:red;" title="Deactive"><?php if(isset($r['first_name'])){echo $name1=$r['first_name'].' ';}if(isset($r['last_name'])){echo $r['last_name'];}?></span><?php
                                }
                            ?>
                        </td>	
                        <td><a href="tel:<?php if(isset($r['mob']))echo $r['mob'];?>"><?php if(isset($r['mob']))echo $r['mob'];?></a></td>
                        <td><?php if(isset($r['emp_code']))echo $id=$r['emp_code'];?> <br> <?php if(isset($r['bio_code']))echo $r['bio_code'];?></td>
                        <td><?php if(isset($r['company_role']))echo $r['company_role'];?><br><?php if(isset($r['plant']))echo $r['plant'];?></td>
                        <td><?php if(isset($r['dname']))echo $r['dname'];?> <br> <?php if(isset($r['rname']))echo $r['rname'];?></td>

                        <td><?php echo $r['asset_issue'];?></td>
                       
                    </tr>
                    <?php
                $i++; 
                }
            ?>
        </tbody>
    </table>
</div>

