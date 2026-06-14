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
                <th>Team</th>
                <th>Staff</th>
                <th>Quli</th>
                <th>DOJ / DOR</th>
                <th>Salary</th>
                <th>Pf, Esi</th>
                <th>Duty</th>
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
                        <td><?php if(isset($r['emp_team']) and $r['emp_team']>0)echo $r['emp_team'];?></td>
                        <td><?php if(isset($r['staff_tech']))echo $r['staff_tech'];?></td>
                        <td><?php if(isset($r['quli'])){echo $r['quli'].' ';} if(isset($r['add_quli']))echo $r['add_quli']?></td>
                        <td style="font-size:10px;">
                            <?php 
                                if(!empty($r['past_exp']))echo 'Past Exp: '.$r['past_exp'];
                                echo "<br>";
                                $current_exp= null;
                                if(!empty($r['doj']) and $r['doj']!='0000-00-00')
                                {
                                    echo "DOJ : ";    
                                    echo $doj = $this->Base->change_date_dmy($r['doj']);
                                    echo "<br>";
                                    $current_exp = $this->Base->get_age_years_month($doj);
                                    if($current_exp <1){$age_color = "orange";}else{$age_color = "blue";}
                                    echo "<span style='color:$age_color'>($current_exp Year)</span>";
                                }
                                echo "<br>";
                                if(!empty($r['past_exp'])){
                                    $total_exp =  $r['past_exp'] +  $current_exp;
                                }else{ $total_exp = $current_exp; }
                                echo "Total Exp: <span style='color:blue'>($total_exp Year)</span>";
                                
                                
                                echo "<br>";
                                
                                if(!empty($r['dor']) and $r['dor']!='0000-00-00')
                                {
                                    echo "DOR : ";
                                    echo $dor = $this->Base->change_date_dmy($r['dor']);
                                }
                            ?>
                        </td>
                       
                        <td><?php echo $r['current_total_ctc'];?></td>
                         <td><?php echo $r['pf_ded'].', '.$r['esic_ded'];?></td>
                         
                        <td style="font-size:12px; line-height:1.1; padding:2px 4px;">
                            <span style="display:block">
                                <b>Duty Hr:</b> <span class="badge badge-primary"><?= $r['working_hr'] ?></span>
                        
                                <b>Shift:</b> <span class="badge badge-info"><?= $r['current_shift'] ?></span>

                                <b>OT:</b>
                                <?= ($r['get_overtime'] == 'Yes')
                                    ? '<span class="badge badge-success">'.$r['get_overtime'].'</span>'
                                    : '<span class="badge badge-secondary">No</span>' ?>

                                <br>
                                <br>

                                <b>Restday:</b> <span class="badge badge-info"><?= $r['restday'] ?></span>
                        
                                <b>Ext.Min?:</b>
                                <?= ($r['late_punch_add'] == 'Yes')
                                    ? '<span class="badge badge-warning">Yes</span>'
                                    : '<span class="badge badge-light">No</span>' ?>

                                <b>DW?:</b>
                                <?= ($r['on_daily_wages'] == 'Yes')
                                    ? '<span class="badge badge-danger">Yes</span>'
                                    : '<span class="badge badge-light">No</span>' ?>

                                <br>
                                <br>

                                <b>Draft?:</b>
                                <?= ($r['draft_entry'] == 1)
                                    ? '<span class="badge badge-warning">Yes</span>'
                                    : '<span class="badge badge-light">No</span>' ?>
                            </span>
                        </td>



                    </tr>
                    <?php
                $i++; 
                }
            ?>
        </tbody>
    </table>
</div>

