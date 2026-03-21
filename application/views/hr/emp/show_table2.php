
<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" id="printed_table">
        <thead style="background-color:<?php echo $this->Company->table_bg_color();?>; color:<?php echo $this->Company->table_ft_color();?>;">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Emp Code</th>
                <th>Dept.</th>
                <th>Post</th>
                <th>HOD Status</th>
                <th>Staff Status</th>
                <th>Quli</th>
                <th>Join Date</th>
                <th>Exp.</th>
                <th>Level</th>
                <th>Mob</th>
                
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
                            <div class="btn-group m-b-sm" >
                                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <?php echo $i;?>.<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu" style=" background-color:#ddd; ">
                                        <li>
                                            <a  target="_blank" style="color:red;"  href="<?php echo base_url().'index.php/Welcome/home?';?>Hr/add_emp/<?php if(isset($r['id']))echo $r['id']?>">Edit</a>
                                        </li>
                                    </ul>
                            </div>
                           
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
                            <?php 
                               
                                if(isset($r['active']) and $r['active']=='Active')
                                { 
                                    if(isset($r['first_name'])){echo $name1=$r['first_name'].' ';}if(isset($r['last_name'])){echo $r['last_name'];}
                                }
                                if(isset($r['active']) and $r['active']=='Deactive')
                                {
                                    ?><span style="color:red;" title="Deactive"><?php if(isset($r['first_name'])){echo $name1=$r['first_name'].' ';}if(isset($r['last_name'])){echo $r['last_name'];}?></span><?php
                                }
                                
                                //age
                                if(!empty($r['dob']) and $r['dob']!='0000-00-00')
                                {
                                    $current_age = $this->Base->get_age_years($r['dob']);
                                    if($current_age <19 or $current_age > 59){$age_color = "red";}else{$age_color = "blue";}
                                    echo "<br><span style='color:$age_color'>($current_age Year)</span>";
                                }
                                else
                                {
                                    echo $dob='';
                                }
                            ?>
                        </td>	
                        <td><?php if(isset($r['emp_code']))echo $id=$r['emp_code'];?></td>
                        <td><?php if(isset($r['dname']))echo $r['dname'];?></td>
                        <td><?php if(isset($r['rname']))echo $r['rname'];?></td>
                        <td><?php if(isset($r['hod_status']))echo $r['hod_status'];?></td>
                        <td><?php if(isset($r['staff_tech']))echo $r['staff_tech'];?></td>
                        <td><?php if(isset($r['quli'])){echo $r['quli'].' ';}//if(isset($r['add_quli']))echo $r['add_quli']?></td>
                        <td style="width:110px">
                            <?php 
                                if(!empty($r['doj_master_roll']) and $r['doj_master_roll']!='0000-00-00')
                                {
                                    echo $doj = $this->Base->change_date_dmy($r['doj_master_roll']);
                                    echo "<br>";
                                    $current_exp = $this->Base->get_age_years_month($doj);
                                    if($current_exp <1){$age_color = "orange";}else{$age_color = "blue";}
                                    echo "<span style='color:$age_color'>($current_exp Year)</span>";
                                }
                                else
                                {
                                    echo $doj='';
                                }
                            ?>
                        </td>
                        <td><?php if(isset($r['total_exp']))echo $id=$r['total_exp'];?></td>
                        <td><?php if(isset($r['current_level']) and strlen($r['current_level'])>0)echo 'Level '.$id=$r['current_level'];?></td>
                        <td><a href="tel:<?php if(isset($r['mob']))echo $r['mob'];?>"><?php if(isset($r['mob']))echo $r['mob'];?></a></td>
                        
                    </tr>
                    <?php
                $i++; 
                }
            ?>
        </tbody>
    </table>
</div>