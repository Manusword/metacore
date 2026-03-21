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
                <th>Dept. Desi.</th>
               
                <th>UAN</th>
                <th>EPF Code</th>
                <th>ESIC Code</th>
                <th>PAN No</th>
                <th>Aadhar No</th>
                <th>Voter Id</th>
                <th>Bank Name</th>
                <th>Account</th>
                <th>IFSC</th>
                
                <th>Aadhar </th>
                <th>EPF</th>
                <th>ESIC</th>
                <th>PAN</th>
                <th>Bank</th>
                <th>Resume</th>
                <th>Other 1</th>
                <th>Other 2</th>
                <th>Other 3</th>
                <th>Other 4</th>
                
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

                                if(isset($r['emp_code']))echo $id=$r['emp_code'];
                                echo ",";
                                if(isset($r['bio_code']))echo $r['bio_code'];
                                echo "<br>";
                                if(isset($r['company_role']))echo $r['company_role'];
                                echo ",";
                                if(isset($r['plant']))echo $r['plant'];
                            ?>
                        </td>	
                        
                        <td><?php if(isset($r['dname']))echo $r['dname'];?> <br> <?php if(isset($r['rname']))echo $r['rname'];?></td>

                        <td><?php echo $r['emp_uan'];?></td>
                        <td><?php echo $r['epf_code'];?></td>
                         <td><?php echo $r['esi_code'];?></td>
                        <td><?php echo $r['pan_no'];?></td>
                        <td><?php echo $r['aadhar_no'];?></td>
                        <td><?php echo $r['voter_id'];?></td>
                        <td><?php echo $r['bank_name'];?></td>
                        <td><?php echo $r['bank_account_no'];?></td>
                        <td><?php echo $r['co_mob_no'];?></td>
                        
                        <td>
                            <?php 
                                if(strlen($r['adhar_photo'])>0){
                                ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/adhar/'.$r['adhar_photo']?>">View </a> <?php
                                }
                            ?>
                        </td>

                        <td>
                           <?php 
                            if(strlen($r['epf_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/epf/'.$r['epf_photo']?>">View </a> <?php
                            }
                        ?>
                        </td>

                        <td>
                           <?php 
                            if(strlen($r['esi_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/esi/'.$r['esi_photo']?>">View </a> <?php
                            }
                        ?>
                        </td>

                        <td>
                            <?php 
                            if(strlen($r['other_id_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/pan/'.$r['other_id_photo']?>">View </a> <?php
                            }
                        ?>
                        </td>

                         <td>
                           <?php 
                            if(strlen($r['bank_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/bank/'.$r['bank_photo']?>">View </a> <?php
                            }
                        ?>
                        </td>

                         <td>
                           <?php 
                            if(strlen($r['resume_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/resume/'.$r['resume_photo']?>">View </a> <?php
                            }
                        ?>
                        </td>

                         <td>
                           <?php 
                            if(strlen($r['other_docs_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/other_docs1/'.$r['other_docs_photo']?>">View </a> <?php
                            }
                        ?>
                        </td>

                         <td>
                           <?php 
                            if(strlen($r['other_docs2_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/other_docs2/'.$r['other_docs2_photo']?>">View </a> <?php
                            }
                        ?>
                        </td>

                        <td>
                           <?php 
                            if(strlen($r['other_docs3_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/other_docs3/'.$r['other_docs3_photo']?>">View </a> <?php
                            }
                        ?>
                        </td>

                        <td>
                           <?php 
                            if(strlen($r['other_docs4_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/other_docs4/'.$r['other_docs4_photo']?>">View </a> <?php
                            }
                            ?>
                        </td>

                        
                    </tr>
                    <?php
                $i++; 
                }
            ?>
        </tbody>
    </table>
</div>

