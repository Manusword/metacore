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

                <th>Cast</th>
                <th>Father</th>
                <th>Mother</th>
                <th>Marrige</th>
                <th>Spouse</th>
                <th>DOM</th>
                <th>Child-1</th>
                <th>Child-2</th>
                <th>Child-3</th>
                <th>Child-4</th>
                <th>Nominee Name</th>
                <th>Nominee Rel</th>
                <th>Present Add.</th>
                <th>Pram. Add.</th>
                <th>Home Mob.</th>
                <th>Pincode</th>
                
            </tr>
        </thead>
        <tbody>
            <?php 
                $i=1;
                foreach($res2 as $r)
                {
                    
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
                                <a href="<?php base_url()?>home?Hr/add_emp/<?php if(isset($r['id']))echo $r['id']?>" target="_blank"   class="btn btn-warning" >
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

                        <td><?php echo $r['emp_cast_category'];?></td>
                        <td><?php echo $r['father_name'];?></td>
                        <td><?php echo $r['mother_name'];?></td>
                        <td><?php echo $r['emp_marrige_status'];?></td>
                        <td><?php echo $r['spouse_name'];?></td>
                        <td>
                            <?php 
                                if(!empty($r['date_of_marriage']) and $r['date_of_marriage']!='0000-00-00')
                                {
                                    echo $this->Base->get_age_years($r['date_of_marriage']);
                                }
                            ?>
                        </td>
                        <td><?php echo $r['child_name1'];?></td>
                        <td><?php echo $r['child_name2'];?></td>
                        <td><?php echo $r['child_name3'];?></td>
                        <td><?php echo $r['child_name4'];?></td>

                        <td><?php echo $r['nominee_name'];?></td>
                        <td><?php echo $r['nominee_rel'];?></td>
                        <td style="font-size:10px;"><?php echo $r['present_address'];?></td>
                        <td style="font-size:10px;"><?php echo $r['permanent_address'];?></td>
                        <td><?php echo $r['home_town_no'];?></td>
                        <td><?php echo $r['pin_code_permanet'];?></td>
                       
                    </tr>
                    <?php
                $i++; 
                }
            ?>
        </tbody>
    </table>
</div>

