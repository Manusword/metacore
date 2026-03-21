<?php 
    $loginId =$this->session->userdata('login_emp_id');
    $company_id = $this->session->userdata('company_id');
    $year=date("Y");
    $today_date=date("Y-m-d");
    $yes_date=date("Y-m-d",strtotime("-1 day"));


    $first_day=date("Y-m-01");
    $last_day=date("Y-m-31");

    $date1 = date_create($first_day);
    $date2 = date_create($today_date);
    $dateDifference = date_diff($date1, $date2)->format('%d')+1;

    $current_year = date('Y');
    $last_year = date('Y')-1;
    $last_last_year = date('Y')-2;

    $entry_start_year = 2021;
    
   
    $dept_id= $res2[0]['department_id'];
    $where=" department_id='$dept_id' ";
    $out=$this->Mymodel->select_where('department',$where);
    $dept_name=$out[0]['name'];
    $role_in_department= $res2[0]['role_in_department'];
    $where=" role_id='$role_in_department' ";
    $out=$this->Mymodel->select_where('department_role',$where);
    $dept_role_name=$out[0]['name'];

    //age
    if(!empty($res2[0]['dob']) and $res2[0]['dob']!='0000-00-00')
    {
        $current_age = $this->Base->get_age_years($res2[0]['dob']);
        if($current_age <19 or $current_age > 59){$age_color = "red";}else{$age_color = "green";}
        $dobhtml =  "<br><span style='color:white;background-color:$age_color'>($current_age Year)</span>";
    }else{ $dobhtml=''; }

    if(!empty($res2[0]['doj']) and $res2[0]['doj']!='0000-00-00')
    {
        $doj = $this->Base->change_date_dmy($res2[0]['doj']);
        $current_exp = $this->Base->get_age_years_month($doj);
        if($current_exp <1){$age_color = "orange";}else{$age_color = "blue";}
        $dojhtml = "<span style='color:$age_color'>$current_exp Year</span>";
    }else {  $dojhtml='';}

    if(isset($res2[0]['dob']) && $res2[0]['dob'] != '0000-00-00'){$dob=$this->Base->change_date_dmy($res2[0]['dob']);}else{$dob='';}
    if(isset($res2[0]['doj']) && $res2[0]['doj'] != '0000-00-00'){$doj=$this->Base->change_date_dmy($res2[0]['doj']);}else{$doj='';}

    $loans = $this->Hrmodel->getEmpLoanstatus($res2[0]['emp_code']);

?> 
<script>
    const name = <?php echo json_encode($res2[0]['first_name'] . ' ' . $res2[0]['last_name']); ?>;
    document.title = name;
</script>
<style>
    .loan-wa-list {
    max-width: 100%;
}

.loan-wa-item {
    padding: 6px 8px;
    margin-bottom: 6px;
    border-radius: 6px;
    background: #f1f3f4;
    font-size: 12px;
    line-height: 1.4;
}

.loan-wa-item:last-child {
    margin-bottom: 0;
}

.wa-line-1 {
    display: flex;
    justify-content: space-between;
    font-weight: 600;
    font-size: 13px;
}

.wa-title {
    color: #222;
}

.wa-amount {
    color: #0b8043;
}

.wa-line-2 {
    font-size: 11px;
    color: #555;
    margin-top: 2px;
}

/* STATUS COLORS */
.wa-running {
    border-left: 4px solid #ff9800;
}

.wa-closed {
    border-left: 4px solid #4caf50;
    background: #e8f5e9;
}

</style>

    



    <div class="main-content">
        <div class="row" >  
            <div class="col-md-2 mb-4" >
                <div class="user-info mb-4" style="border-radius: 50%;">
                <?php  
                        $profile_pic=$res2[0]['profile_pic'];
                        if(strlen($profile_pic)>0)
                        {
                            ?>
                            <a target="_blank" href="<?php echo base_url().'pic/'.$company_id.'/employee/dp/'.$profile_pic?>">
                                <img class="profile-picture avatar-lg mb-2" src="<?php echo base_url().'pic/'.$company_id.'/employee/dp/'.$profile_pic?>" alt="" style="height:250px; width:250px; border-radius: 50%"  />
                            </a>
                            <?php
                        }
                        else
                        {
                            ?><img src="<?php echo base_url()?>assets/user.png" alt=""><?php
                        }
                    ?>
                </div>  
                
                <p>
                    <?php   $badge = ($res2[0]['active'] == 'Active') ? "success" : "danger"; ?>
                    Employee: <span class="badge badge-<?php echo $badge;?>"><?php echo $res2[0]['active'];?></span>
                </p>
                <p>
                    <?php   $badge = ($res2[0]['status'] == 'Active') ? "success" : "danger"; ?>
                    Login: <span class="badge badge-<?php echo $badge;?>"><?php echo $res2[0]['status'];?></span>
                </p>
                <?php if($this->Company->checkPermission3("Hr/add_emp")){ ?>
                <p>
                    <a  href="<?php base_url()?>home?Hr/add_emp/<?php if(isset($res2[0]['id']))echo $res2[0]['id']?>" target="_blank"   class="btn btn-warning" >Update Profile<i class="nav-icon i-Pen-2"></i></a>
                </p>
                <?php } ?>
            </div>  <!-- column -->
            
            

           <div class="col-md-2 mb-4" > 
                <h3 class="text-left"><?php echo $res2[0]['first_name'].' '.$res2[0]['last_name'];?></h3>
                <h5 class="text-left">Emp Code : <?php echo $emp_code=$res2[0]['emp_code'];?> </h5>  
                <h6 class="text-left">Bio Id : <?php echo $res2[0]['bio_code'];?></h6>              
                <ul class="list-unstyled text-left">
                    <li>From Unit: <?php if(isset($res2[0]['company_role']))echo $res2[0]['company_role'];?></li>
                    <li>Working Unit <?php if(isset($res2[0]['plant']))echo $res2[0]['plant'];?></li>
                    <br>
                    <li>Gender: <?php echo $res2[0]['gender']; echo $dobhtml;?> <?php echo $res2[0]['emp_marrige_status'];?></li>
                    <li>D.O.B: <?php echo $dob;?></li>
                    <br>
                    <li>Father Name: <?php echo $res2[0]['father_name'];?></li>
                    <li>Cast Category: <?php echo $res2[0]['emp_cast_category'];?></li>
                    <li>Mobile : <?php echo $res2[0]['mob'].' '.$res2[0]['home_town_no'];?></li>
                    <li>Email: <?php echo $res2[0]['email'];?></li>
                    <br>
                    <li>Present Address : <?php echo $res2[0]['present_address'];?></li>
                    <li>Permanent Address : <?php echo $res2[0]['permanent_address'].' '.$res2[0]['pin_code_permanet'].' '.$res2[0]['state_par_address'];?></li>
                </ul>
            </div> <!-- column -->  
            
            <div class="col-md-2 mb-4" >
                <ul class="list-unstyled text-left">
                    <li>D.O.J: <?php  echo $doj?></li>
                    <li>No of Year's: <?php  echo $dojhtml;?></li>
                    <li>Department: <?php echo $dept_name;?></li>
                    <li>Desigantion: <?php echo $dept_role_name;?></li>
                    <br>
                    <li>HOD: <?php echo $res2[0]['hod_status'];?></li>
                    <li>Staff / Tech.: <?php echo $res2[0]['staff_tech'];?></li>
                    <li>Qualification: <?php echo $res2[0]['quli'];?></li>
                    <br>
                    <li>Total Experience: <?php echo $res2[0]['total_exp'];?></li>
                    <li>Last Organisation: <br><?php echo $res2[0]['last_org'];?></li>
                </ul>
            </div> <!-- column --> 

            <div class="col-md-2 mb-4" >
                <ul class="list-unstyled text-left">
                    <li>Basic: <?php echo $res2[0]['basic_salary'];?></li>
                    <li>HRA: <?php echo $res2[0]['hra'];?></li>
                    <li>Conv.: <?php echo $res2[0]['conv'];?></li>
                    <li>City comp.: <?php echo $res2[0]['city_comp'];?></li>
                    <li>Other.: <?php echo $res2[0]['other_allow'];?></li>
                    <li>Gross Total: <?php echo $res2[0]['current_ctc'];?></li>
                    <li style="color:blue;">CTC: <?php echo $res2[0]['current_total_ctc'];?> Rs.</li>
                    <br>
                    <li>E.P.F. Deduction: <?php echo $res2[0]['pf_ded'];?></li>
                    <li>ESIC Deduction: <?php echo $res2[0]['esic_ded'];?></li>
                    <br>
                    <li>Overtime Status: <?php echo $res2[0]['get_overtime'];?></li>
                    <li>Working : <?php echo $res2[0]['working_hr'];?> Hrs</li>
                    <li>Shift Status: <?php echo $res2[0]['shift_status'];?></li>
                    <br>
                    <li>
                        <strong>Active Loans</strong>

                        <ul class="list-unstyled mt-2 loan-wa-list">
                            <?php if (!empty($loans)) {
                                $j = 1;
                                foreach ($loans as $l) {

                                    $statusClass = ($l['pending_amount'] <= 0) ? 'wa-closed' : 'wa-running';
                            ?>
                                <li class="loan-wa-item <?= $statusClass ?>">
                                    <div class="wa-line-1">
                                        <span class="wa-title">Loan #<?= $j ?></span>
                                        <span class="wa-amount">₹<?= number_format($l['loan_amount'],0) ?></span>
                                    </div>

                                    <div class="wa-line-2">
                                        Paid ₹<?= number_format($l['total_paid_amount'],0) ?> ·
                                        Pending ₹<?= number_format($l['pending_amount'],0) ?> ·
                                        EMI <?= $l['remaining_emi'] ?>/<?= $l['total_emi'] ?>
                                    </div>
                                </li>
                            <?php
                                $j++;
                                }
                            } else { ?>
                                <li class="text-muted small">No active loans</li>
                            <?php } ?>
                        </ul>
                    </li>

                </ul>
            </div> <!-- column --> 

            <div class="col-md-2 mb-4" >
                <ul class="list-unstyled text-left">
                    <li>Aadhar: <?php echo $res2[0]['aadhar_no'];?></li>
                    <li>PAN Number: <?php echo $res2[0]['pan_no'];?></li>
                    <li>Voter ID: <?php echo $res2[0]['voter_id'];?></li>
                    <br>
                    <li>UAN: <?php echo $res2[0]['emp_uan'];?></li>
                    <li>EPF Code: <?php echo $res2[0]['epf_code'];?></li>
                    <li>ESI Code: <?php echo $res2[0]['esi_code'];?></li>
                    <br>
                    <li>Bank Name: <?php echo $res2[0]['bank_name'];?></li>
                    <li>Bank Account No.: <?php echo $res2[0]['bank_account_no'];?></li>
                    <li>IFSC Code: <?php echo $res2[0]['co_mob_no'];?></li>
                    <br>
                    <li>Asset Issue List:<br>
                         <?php 
                            $selectedAssets = [];
                            if (!empty($res2[0]['asset_issue'])) {
                                $selectedAssets = array_map('trim', explode(',', $res2[0]['asset_issue']));
                            }
                            $assetList = $this->Base->get_all_hr_asset_list();

                            if(!empty($assetList)){
                                foreach($assetList as $key => $asset){

                                    $checked = in_array($asset, $selectedAssets) ? 'checked' : '';
                            ?>
                                    <div class="form-check form-check-inline">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            name="asset_issue[]" 
                                            id="asset_<?= $key ?>" 
                                            value="<?= htmlspecialchars($asset) ?>"
                                            <?= $checked ?>
                                        >
                                        <label class="form-check-label" for="asset_<?= $key ?>">
                                            <?= htmlspecialchars($asset) ?>
                                        </label>
                                    </div>
                            <?php 
                                }
                            } else {
                                echo '<span class="text-danger">No assets found</span>';
                            }
                            ?>
                    </li>
                </ul>
            </div> <!-- column --> 
             <div class="col-md-2 mb-4" >
                <ul class="list-unstyled text-left">
                    <li> In Master Roll: 
                        <?php 
                            //master roll
                            if(isset($res2[0]['mater_roll']) and $res2[0]['mater_roll'] == "Yes")
                            { 
                                ?><span class="badge badge-danger">Yes</span><?php
                            }else{echo "No";}
                        ?>
                    </li>
                   <li>
                        Login: 
                        <?php  if(isset($res2[0]['login_from_other_ip'])){if($res2[0]['login_from_other_ip']=='0'){echo "Only From Company";}else{echo "Everywhere";}}?>
                   </li>
                   <li class="mt-3">
                        <a class=" mt-1" target="_blank" href=" <?php echo base_url()."index.php/Hr/profile2/".$res2[0]['emp_code']?>">
                            Registration Form
                        </a>
                    </li>
                    <li >
                        <?php 
                            if(strlen($res2[0]['adhar_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/adhar/'.$res2[0]['adhar_photo']?>">Adhar View </a> <?php
                            }
                        ?>
                    </li>
                    <li>
                        <?php 
                            if(strlen($res2[0]['epf_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/epf/'.$res2[0]['epf_photo']?>">EPF View </a> <?php
                            }
                        ?>
                    </li>
                    <li>
                        <?php 
                            if(strlen($res2[0]['esi_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/esi/'.$res2[0]['esi_photo']?>">ESI View </a> <?php
                            }
                        ?>
                    </li>
                    <li>
                        <?php 
                            if(strlen($res2[0]['other_id_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/pan/'.$res2[0]['other_id_photo']?>">Other ID View </a> <?php
                            }
                        ?>
                    </li>
                    <li>
                        <?php 
                            if(strlen($res2[0]['bank_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/bank/'.$res2[0]['bank_photo']?>">Bank View </a> <?php
                            }
                        ?>
                    </li>
                    <li>
                        <?php 
                            if(strlen($res2[0]['resume_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/resume/'.$res2[0]['resume_photo']?>">Resume View </a> <?php
                            }
                        ?>
                    </li>
                    <li>
                        <?php 
                            if(strlen($res2[0]['other_docs_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/other_docs1/'.$res2[0]['other_docs_photo']?>">Other Docs View </a> <?php
                            }
                        ?>
                    </li>
                    <li>
                        <?php 
                            if(strlen($res2[0]['other_docs2_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/other_docs2/'.$res2[0]['other_docs2_photo']?>">Other Docs View </a> <?php
                            }
                        ?>
                    </li>
                    <li>
                        <?php 
                            if(strlen($res2[0]['other_docs3_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/other_docs3/'.$res2[0]['other_docs3_photo']?>">Other Docs View </a> <?php
                            }
                        ?>
                    </li>
                    <li>
                        <?php 
                            if(strlen($res2[0]['other_docs4_photo'])>0){
                            ?><a class="mt-5" target="_blank" href="<?php echo base_url().'pic/employee/other_docs4/'.$res2[0]['other_docs4_photo']?>">Other Docs View </a> <?php
                            }
                        ?>
                    </li>
                </ul>
            </div> <!-- column --> 
       
            <div class="col-md-12 mb-4" > <hr></div> <!-- column --> 


            <?php 
                for($now_year=date('Y');$now_year >= 2025;$now_year--){
                    if ($now_year == date('Y') && date('m') < 4) continue;
                ?>
                    <div class="col-md-12 mb-4" >
                        <ul class="nav nav-tabs mb-4" >
                            <li class="nav-item"><a class="nav-link active"><?php echo $now_year;?> Attendance </a></li>
                        </ul>
                        <div class="tab-content" >
                            
                            <div class="col-md-12 mb-4" >
                                <?php $this->Hrmodel->date_wise_attendance($now_year,$emp_code); ?>
                             </div>

                            <div class="col-md-12 mb-4" >
                                <?php $this->Hrmodel->emp_month_wise_salary($now_year,$res2[0]['id']); ?>
                            </div>
                            
                            <div class="col-md-12 mb-4" >
                                <?php
                                    $this->Hrmodel->date_wise_advance($now_year,$emp_code);
                                    $this->Hrmodel->date_wise_leave($now_year,$emp_code);
                                    $this->Hrmodel->date_wise_other_application_details($now_year,$emp_code,'Gatepass');
                                    $this->Hrmodel->date_wise_other_application_details($now_year,$emp_code,'Fine');
                                    $this->Hrmodel->date_wise_other_application_details($now_year,$emp_code,'Medical');
                                    $this->Hrmodel->date_wise_other_application_details($now_year,$emp_code,'MEMO');
                                    $this->Hrmodel->date_wise_other_application_details($now_year,$emp_code,'Others');
                                ?>
                            </div>
                        </div>
                    </div> <!-- column --> 
                <?php 
                 }//for loop
            ?>

         </div> <!-- row -->


            
    </div><!-- main -->

           
            