<?php 
  $canEdit = $this->Company->checkPermission3("Hr/emp_edit_access");
?>

<div class="">
    <table class="table table-bordered table-striped table-sm" id="printed_table" >
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
               
                <th>#</th>
                <th>Edit</th>
                <th>DP <br> </th>
                <th>Name <br> Age<br> F.Name<br>Cast</th>
                <th>Mob</th>
                <th>Emp Code <br> Bio Code</th>
                <th>Payroll <br> Working</th>
                <th>Dept.<br> Desi.</th>

                <th>Salary</th>
                <th>Pf, Esi</th>
               
                <th>UAN</th>
                <th>EPF Code</th>
                <th>ESIC Code</th>
                <th>PAN No</th>
                <th>Aadhar No</th>
                <th>Voter Id</th>
                <th>Bank Name</th>
                <th>Account</th>
                <th>IFSC</th>
                
                
                
            </tr>
        </thead>
        <tbody>
            <?php 
                $i=1;
                foreach($res2 as $r)
                {
                      if((int)$r['draft_entry'] != 1) continue;
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
                            <a target="_blank" href=" <?php echo base_url()."index.php/Welcome/home?Hr/profile/".$r['emp_code']?>">
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
                            </a>
                        </td>


														
                        <td>
                             <a target="_blank" href=" <?php echo base_url()."index.php/Welcome/home?Hr/profile/".$r['emp_code']?>">
                                <?php 
                                    if($r['active']=='Active'){ 
                                        if(isset($r['first_name'])){echo $name1=$r['first_name'].' ';}if(isset($r['last_name'])){echo $r['last_name'];}
                                    }else{
                                        ?><span style="color:red;" title="Deactive"><?php if(isset($r['first_name'])){echo $name1=$r['first_name'].' ';}if(isset($r['last_name'])){echo $r['last_name'];}?></span><?php
                                    }
                                ?>
                            </a>
                                <?php
                                 echo "<br>";
                                if(!empty($r['gender'])){echo "(".$r['gender'][0].") ";}
                                //age
                                if(!empty($r['dob']) and $r['dob']!='0000-00-00')
                                {
                                    $current_age = $this->Base->get_age_years($r['dob']);
                                    if($current_age <19 or $current_age > 59){$age_color = "red";}else{$age_color = "blue";}
                                    echo "<span style='color:$age_color'>($current_age Year)</span>";
                                }
                                
                                echo "<br>";
                                 if(isset($r['father_name']))echo $r['father_name'];
                                echo "<br>";
                                 if(isset($r['emp_cast_category']))echo $r['emp_cast_category'];
                                
                            ?>
                        </td>	
                       
                        <td><a href="tel:<?php if(isset($r['mob']))echo $r['mob'];?>"><?php if(isset($r['mob']))echo $r['mob'];?></a></td>
                       
                        <td><?php if(isset($r['emp_code']))echo $id=$r['emp_code'];?> <br> <?php if(isset($r['bio_code']))echo $r['bio_code'];?></td>
                        <td><?php if(isset($r['company_role']))echo $r['company_role'];?><br><?php if(isset($r['plant']))echo $r['plant'];?></td>
                        <td>
                            <?php if(isset($r['dname']))echo $r['dname'];?> 
                            <br> 
                            <?php if(isset($r['rname']))echo $r['rname'];?>
                        </td>

                          <td><?php echo $r['current_total_ctc'];?></td>
                         <td><?php echo $r['pf_ded'].', '.$r['esic_ded'];?></td>
                         
                        <td><?php echo $r['emp_uan'];?></td>
                        <td><?php echo $r['epf_code'];?></td>
                         <td><?php echo $r['esi_code'];?></td>
                        <td><?php echo $r['pan_no'];?></td>
                        <td><?php echo $r['aadhar_no'];?></td>
                        <td><?php echo $r['voter_id'];?></td>
                        <td><?php echo $r['bank_name'];?></td>
                        <td><?php echo $r['bank_account_no'];?></td>
                        <td><?php echo $r['co_mob_no'];?></td>
                        
                       
                        
                    </tr>
                    <?php
                $i++; 
                }
            ?>
        </tbody>
    </table>
</div>

