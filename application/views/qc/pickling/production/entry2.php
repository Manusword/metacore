<?php 
  $year = date('Y');
  $month= date('m');

  if(isset($res2[0]['entry_date']) and $res2[0]['entry_date']!='0000-00-00') {$entry_date = $this->Base->change_date_dmy($res2[0]['entry_date']);} else {$entry_date = date('Y-m-d');}
  //if(isset($res2[0]['heater_on']) and $res2[0]['heater_on']!='0000-00-00 00:00:00') {$heater_on = $this->Base->change_date_ymd_hisa($res2[0]['heater_on']);} else {$heater_on = '';}
  if(isset($res2[0]['washing_time1']) and $res2[0]['washing_time1']!='0000-00-00 00:00:00') {$washing_time1 = $this->Base->change_time_His($res2[0]['washing_time1']);} else {$washing_time1 = '';}
  if(isset($res2[0]['hcl_in']) and $res2[0]['hcl_in']!='0000-00-00 00:00:00') {$hcl_in = $this->Base->change_time_His($res2[0]['hcl_in']);} else {$hcl_in = '';}
  if(isset($res2[0]['hcl_out']) and $res2[0]['hcl_out']!='0000-00-00 00:00:00') {$hcl_out = $this->Base->change_time_His($res2[0]['hcl_out']);} else {$hcl_out = '';}

  if(isset($res2[0]['washing_time2']) and $res2[0]['washing_time2']!='0000-00-00 00:00:00') {$washing_time2 = $this->Base->change_time_His($res2[0]['washing_time2']);} else {$washing_time2 = '';}
  if(isset($res2[0]['phos_in']) and $res2[0]['phos_in']!='0000-00-00 00:00:00') {$phos_in = $this->Base->change_time_His($res2[0]['phos_in']);} else {$phos_in = '';}
  if(isset($res2[0]['phos_out']) and $res2[0]['phos_out']!='0000-00-00 00:00:00') {$phos_out = $this->Base->change_time_His($res2[0]['phos_out']);} else {$phos_out = '';}
  if(isset($res2[0]['borax_in']) and $res2[0]['borax_in']!='0000-00-00 00:00:00') {$borax_in = $this->Base->change_time_His($res2[0]['borax_in']);} else {$borax_in = '';}
  if(isset($res2[0]['borax_out']) and $res2[0]['borax_out']!='0000-00-00 00:00:00') {$borax_out = $this->Base->change_time_His($res2[0]['borax_out']);} else {$borax_out = '';}
  if(isset($res2[0]['heater_off']) and $res2[0]['heater_off']!='0000-00-00 00:00:00') {$heater_off = $this->Base->change_date_ymd_hisa($res2[0]['heater_off']);} else {$heater_off = '';}

  if(!empty($res2[0]['coil_test_d'])){
    $coil_test_d = $res2[0]['coil_test_d'];
    $coilList = $this->Pomodel->get_all_not_issue_colino_search(" and coil_test_d= '$coil_test_d' ");
  }
?> 
         

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Pickling Entry</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                <div class="col-md-1"></div>
                    <div class="col-md-10">
                      <div class="card mb-12">
                            <div class="card-body">
                              <div class="card-title" style="color:<?php echo $this->Company->table_bg_color();?>;" >Pickling Entry </div>
                                    <div class="form-row">
                                      
             
                                    
                                  <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                  <input type="hidden" name="id" id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                  <input type="hidden" name="id" id="old_coil_test_d"  value="<?php if(isset($res2[0]['coil_test_d']))echo $res2[0]['coil_test_d'];?>">
                
                                          
                                           <div class="col-md-2" >
                                              <div class="form-group" >
                                                <label >Pickled Date</label>
                                                <input type="text" class="form-control"    id="entry_date" required  autocomplete="off" value="<?php echo $entry_date;?>">
                                              </div>
                                            </div>



                                  
                                            <div class="col-md-2" >
                                              <div class="form-group" >
                                                <label >Size</label>
                                                  <select class="form-control"  id='size' onchange="getRod()">
                                                      <option value="">Select</option>
                                                      <?php 
                                                        foreach($size as $h)
                                                        {
                                                              ?>
                                                              <option value="<?php echo $h['finish_size'];?>" ><?php echo $h['finish_size'];?></option>
                                                              <?php
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                            </div>


                                            <div class="col-md-2" >
                                              <div class="form-group" >
                                                <label >Grade</label>
                                                  <select class="form-control"  id="grade" onchange="getRod()">
                                                      <option value="">Select</option>
                                                      <?php 
                                                        foreach($grade as $h)
                                                        {
                                                              ?>
                                                              <option value="<?php echo $h['product_grade'];?>" ><?php echo $h['gname'];?></option>
                                                              <?php
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                            </div>

                                            


                                            <div class="col-md-2" >
                                              <div class="form-group" >
                                                <label >Heat No</label>
                                                  <select class="form-control"  id="heat" onchange="getRod()">
                                                      <option value="">All</option>
                                                      <?php 
                                                        foreach($heat as $h)
                                                        {
                                                              ?>
                                                              <option value="<?php echo $h['heat_no'];?>" ><?php echo $h['heat_no'];?></option>
                                                              <?php
                                                        }
                                                      ?>
                                                  </select>
                                              </div>
                                            </div>



                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                <label >Coil No</label>
                                                  <select class="form-control" id="rod_id">
                                                    <option value="">All</option>
                                                    <?php 
                                                    foreach($result as $h)
                                                    {
                                                      ?>
                                                        <option value="<?php echo $h['coil_test_d'];?>" ><?php echo $h['coil_no'];?></option>
                                                      <?php
                                                    }

                                                    
                                                      
                                                    if(!empty($coilList)){
                                                      ?>
                                                        <option selected value="<?php echo $coilList[0]['coil_test_d'];?>" ><?php echo $coilList[0]['coil_no'];?></option>
                                                      <?php
                                                    }
                                                   
                                                    ?>
                                                  </select>
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Other details of coil</label>
                                                  <input type="text" class="form-control"    id="other_details" required  autocomplete="off" value="<?php if(isset($res2[0]['other_details']))echo $res2[0]['other_details'];?>">
                                                </div>
                                              </div>

                                               <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Sno / Rank</label>
                                                  <input type="text" class="form-control"    id="rank" required  autocomplete="off" value="<?php if(isset($res2[0]['rank']))echo $res2[0]['rank'];?>">
                                                </div>
                                              </div>


                                           

                                              <div class="col-md-2" >
                                                <label >Lotno</label>
                                                <select class="form-control" id="lotno">
                                                      <option value="">Lotno</option>
                                                      <?php 
                                                        $lotnoList = $this->Base->get_all_lotno_for_pickling();
                                                        foreach($lotnoList as $l)
                                                        {
                                                              ?>
                                                                  <option <?php if(isset($res2[0]['lotno'])){if($l['id']==$res2[0]['lotno']){ echo "selected";}}?>   value="<?php echo $l['id'];?>" ><?php echo $l['name'];?></option>
                                                              <?php
                                                        }//foreach
                                                      ?>
                                                </select>
                                              </div>



                                              <div class="col-md-12" > <hr>  </div>
                                              
                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Heater On</label>
                                                  <input type="datetime-local" class="form-control"    id="heater_on" required  autocomplete="off" value="<?php if(isset($res2[0]['heater_on']))echo $res2[0]['heater_on'];?>">
                                                </div>
                                              </div>

                                               
                                            
                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Washing Time</label>
                                                  <input type="time" class="form-control"    id="washing_time1" required  autocomplete="off" value="<?php echo $washing_time1;?>" onchange="change_washing_time1()">
                                                  <span class="washing_daytime1"></span>
                                                </div>
                                              </div>


                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >HCL In Time</label>
                                                  <input type="time" class="form-control"    id="hcl_in" required  autocomplete="off" value="<?php echo $hcl_in;?>" onchange="change_hcl_in()">
                                                   <span class="hcl_in_daytime"></span>
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >HCL Out Time</label>
                                                  <input type="time" class="form-control"    id="hcl_out" required  autocomplete="off" value="<?php echo $hcl_out;?>" onchange="change_hcl_out()">
                                                   <span class="hcl_out_datetime"></span>
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Total Time</label>
                                                  <input type="text" class="form-control"    id="hcl_total_time" required  autocomplete="off" value="<?php if(isset($res2[0]['hcl_total_time']))echo $res2[0]['hcl_total_time'];?>">
                                                </div>
                                              </div>

                                               <div class="col-md-2" >
                                                 <div class="form-group" >
                                                  <label >Washing Time</label>
                                                  <input type="time" class="form-control"    id="washing_time2" required  autocomplete="off" value="<?php echo $washing_time2;?>"  onchange="change_washing_time2()">
                                                  <span class="washing_daytime2"></span>
                                                </div>
                                              </div>
                                          </div>
 



                                             <!-- phos -->

                                          <div class="form-row">
                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Phos In Time</label>
                                                  <input type="time" class="form-control"    id="phos_in" required  autocomplete="off" value="<?php echo $phos_in;?>"  onchange="change_phos_in()">
                                                   <span class="phos_in_daytime"></span>
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Phos Out Time</label>
                                                  <input type="time" class="form-control"    id="phos_out" required  autocomplete="off" value="<?php echo $phos_out;?>"  onchange="change_phos_out()">
                                                   <span class="phos_out_daytime"></span>
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Total Time</label>
                                                  <input type="text" class="form-control"    id="phos_total_time" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_total_time']))echo $res2[0]['phos_total_time'];?>">
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Temp In</label>
                                                  <input type="text" class="form-control"    id="phos_in_temp" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_in_temp']))echo $res2[0]['phos_in_temp'];?>" onkeyup="setDiffTemp()">
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Temp Out</label>
                                                  <input type="text" class="form-control"    id="phos_out_temp" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_out_temp']))echo $res2[0]['phos_out_temp'];?>" onkeyup="setDiffTemp()">
                                                </div>
                                              </div>

                                               <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Diff Temp</label>
                                                  <input type="text" class="form-control"    id="phos_temp_diff" required  autocomplete="off" value="<?php if(isset($res2[0]['phos_temp_diff']))echo $res2[0]['phos_temp_diff'];?>">
                                                </div>
                                              </div>
                                          </div>

                                              <!-- Borax -->

                                          <div class="form-row">
                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Borax In Time</label>
                                                  <input type="time" class="form-control"    id="borax_in" required  autocomplete="off" value="<?php echo $borax_in;?>" onchange="change_borax_in()">
                                                   <span class="borax_in_daytime"></span>
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Borax Out Time</label>
                                                  <input type="time" class="form-control"    id="borax_out" required  autocomplete="off" value="<?php echo $borax_out;?>" onchange="change_borax_out()">
                                                   <span class="borax_out_time"></span>
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Total Time</label>
                                                  <input type="text" class="form-control"    id="borax_total_time" required  autocomplete="off" value="<?php if(isset($res2[0]['borax_total_time']))echo $res2[0]['borax_total_time'];?>">
                                                </div>
                                              </div>

                                              <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Temp In</label>
                                                  <input type="text" class="form-control"    id="borax_in_temp" required  autocomplete="off" value="<?php if(isset($res2[0]['borax_in_temp']))echo $res2[0]['borax_in_temp'];?>" onkeyup="setDiffTemp()">
                                                </div>
                                              </div>

                                               <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Temp Out</label>
                                                  <input type="text" class="form-control"    id="borax_out_temp" required  autocomplete="off" value="<?php if(isset($res2[0]['borax_out_temp']))echo $res2[0]['borax_out_temp'];?>"  onkeyup="setDiffTemp()">
                                                </div>
                                              </div>

                                               <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Diff Temp</label>
                                                  <input type="text" class="form-control"    id="borax_temp_diff" required  autocomplete="off" value="<?php if(isset($res2[0]['borax_temp_diff']))echo $res2[0]['borax_temp_diff'];?>">
                                                </div>
                                              </div>

                                      </div>

                                          <!-- Borax -->

                                      <div class="form-row">
                                          
                                          <div class="col-md-2" >
                                            <div class="form-group" >
                                              <label >Total Time From Wash to Borax</label>
                                              <input type="text" class="form-control"    id="wash_to_borex_out_time" required  autocomplete="off" value="<?php if(isset($res2[0]['wash_to_borex_out_time']))echo $res2[0]['wash_to_borex_out_time'];?>">
                                              <span class="wash_to_borex_out_time_daytime"></span>
                                            </div>
                                          </div>


                                          <div class="col-md-2" >
                                            <div class="form-group" >
                                              <label >Supervisor Name</label>
                                              <input type="text" class="form-control"    id="sup_id" required  autocomplete="off" value="<?php if(isset($res2[0]['sup_id']))echo $res2[0]['sup_id'];?>">
                                            </div>
                                          </div>

                                          <div class="col-md-2" >
                                            <div class="form-group" >
                                              <label >OP Name</label>
                                              <input type="text" class="form-control"    id="op_id" required  autocomplete="off" value="<?php if(isset($res2[0]['op_id']))echo $res2[0]['op_id'];?>">
                                            </div>
                                          </div>

                                           <div class="col-md-2" >
                                            <div class="form-group" >
                                              <label >Helper 1 Name</label>
                                              <input type="text" class="form-control"    id="hel1_id" required  autocomplete="off" value="<?php if(isset($res2[0]['hel1_id']))echo $res2[0]['hel1_id'];?>">
                                            </div>
                                          </div>

                                           <div class="col-md-2" >
                                            <div class="form-group" >
                                              <label >Helper 2 Name</label>
                                              <input type="text" class="form-control"    id="hel2_id" required  autocomplete="off" value="<?php if(isset($res2[0]['hel2_id']))echo $res2[0]['hel2_id'];?>">
                                            </div>
                                          </div>

                                            <div class="col-md-2" >
                                                <div class="form-group" >
                                                  <label >Heater Off</label>
                                                  <input type="datetime-local" class="form-control"    id="heater_off" required  autocomplete="off" value="<?php if(isset($res2[0]['heater_off']))echo $res2[0]['heater_off'];?>">
                                                </div>
                                              </div>

                                              <div class="col-md-12" >
                                                <div class="form-group" >
                                                  <label >Remarks</label>
                                                  <input type="text" class="form-control"    id="remarks" required  autocomplete="off" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>">
                                                </div>
                                              </div>
                            
                            
                                        
                                          <div class="col-md-12" style="margin-top:50px;">                            
                                                <div class="box-footer">
                                                      <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                        <button type="button" class="btn btn-success" id="pickling_coil_test_save2" >Pickling Save</button>
                                                      </div>
                                                  </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>
                    
                </div><!-- end of main-content -->   





<?php $this->load->view('js/qc_js');?>

<script>
  
	//-----------All reports search
	function getRod()
	{
		var size=$('#size').val();
		var grade=$('#grade').val();
		var heat=$('#heat').val();
    var blcategory=$('#blcategory').val();
    var rodStatus=$('#rodStatus').val();
    var search1='1';
		$('#wait').show();
    $('#dis_output').html('Please wait...');
    jQuery.post("<?php echo base_url().'index.php/Qc/fun_get_rod_search2';?>", 
		{
			size:size,
      grade:grade,
      heat:heat,
			blcategory:blcategory,
			rodStatus:rodStatus,
      search1:search1,
		}, 
		function(data, textStatus)
		{	
			$('#rod_id').html(data);
      $('#wait').hide();
		});
	}//function close

//set temp
function setDiffTemp() {
  $('#phos_temp_diff').val($('#phos_out_temp').val() - $('#phos_in_temp').val());
  $('#borax_temp_diff').val($('#borax_out_temp').val() - $('#borax_in_temp').val());
}


// Safely parse time "HH:MM" to Date object (today's date)
function parseTime(timeStr) {
    if (!timeStr || !timeStr.includes(':')) return null;
    let [h, m] = timeStr.split(':').map(Number);
    if (isNaN(h) || isNaN(m)) return null;
    let d = new Date();
    d.setHours(h, m, 0, 0);
    return d;
}

// Format Date object to "HH:MM"
function formatTime(dateObj) {
    let h = ('0' + dateObj.getHours()).slice(-2);
    let m = ('0' + dateObj.getMinutes()).slice(-2);
    return `${h}:${m}`;
}

// Add minutes to a time string
function new_time(oldTime, addMinute) {
    let d = parseTime(oldTime);
    if (!d) return '';

    d.setMinutes(d.getMinutes() + addMinute);

    return formatTime(d); // Only "HH:mm" format
}



// Difference between two times in minutes
function subtract2Time(time1, time2) {
    let t1 = parseTime(time1);
    let t2 = parseTime(time2);
    if (!t1 || !t2) return 0;

    let diff = Math.round((t2 - t1) / 60000); // ms to minutes

    // If t2 is "earlier" than t1, add 24 hours (next day)
    if (diff < 0) {
        diff += 24 * 60; // 1440 minutes
    }

    return diff;
}


// ---------- Core Logic ----------

// Update a field based on another field + offset
function updateTime(fromSelector, toSelector, offsetMinutes, nextFn) {
    let time1 = $(fromSelector).val();
    let time2 = new_time(time1, offsetMinutes);
    $(toSelector).val(time2);
    if (typeof nextFn === "function") nextFn();
}

// Update total times
function setTotalTime() {
    $('#hcl_total_time').val(subtract2Time($('#hcl_in').val(), $('#hcl_out').val()));
    $('#phos_total_time').val(subtract2Time($('#phos_in').val(), $('#phos_out').val()));
    $('#borax_total_time').val(subtract2Time($('#borax_in').val(), $('#borax_out').val()));
    $('#wash_to_borex_out_time').val(subtract2Time($('#washing_time1').val(), $('#borax_out').val()));
}

// ---------- Chained Updates ----------
function change_washing_time1() {
    updateTime('#washing_time1', '#hcl_in', 3, change_hcl_in);
    setDateTimeInSpan();
}

function change_hcl_in() {
    updateTime('#hcl_in', '#hcl_out', 40, change_hcl_out);
    setDateTimeInSpan();
}

function change_hcl_out() {
    updateTime('#hcl_out', '#washing_time2', 2, change_washing_time2);
    setDateTimeInSpan();
}

function change_washing_time2() {
    updateTime('#washing_time2', '#phos_in', 4, change_phos_in);
    setDateTimeInSpan();
}

function change_phos_in() {
    let phosIn = $('#phos_in').val();
    $('#phos_out').val(new_time(phosIn, 12));
    $('#borax_in').val(new_time(new_time(phosIn, 12), 2));
    change_borax_in();
    setDateTimeInSpan();
}

function change_phos_out() {
    updateTime('#phos_out', '#borax_in', 2, change_borax_in);
    setDateTimeInSpan();
}

function change_borax_in() {
    updateTime('#borax_in', '#borax_out', 2, setTotalTime);
    setDateTimeInSpan();
}

function change_borax_out() {
    $('#borax_total_time').val(subtract2Time($('#borax_in').val(), $('#borax_out').val()));
    $('#wash_to_borex_out_time').val(subtract2Time($('#washing_time1').val(), $('#borax_out').val()));
    setTotalTime();
    setDateTimeInSpan();
}


// Helper: Format Date to "DD-MM-YYYY HH:mm"
function formatDateTime(dateObj) {
    let dd = ('0' + dateObj.getDate()).slice(-2);
    let mm = ('0' + (dateObj.getMonth() + 1)).slice(-2);
    let yyyy = dateObj.getFullYear();
    let hh = ('0' + dateObj.getHours()).slice(-2);
    let min = ('0' + dateObj.getMinutes()).slice(-2);
    return `${dd}-${mm}-${yyyy} ${hh}:${min}`;
}

// Helper: Returns a Date based on previous time to handle rollover
function getDateWithRollover(baseDate, currentTime) {
    if (!currentTime || !currentTime.includes(':')) return null;
    let [h, m] = currentTime.split(':').map(Number);
    let d = new Date(baseDate);
    d.setHours(h, m, 0, 0);
    if (d < baseDate) d.setDate(d.getDate() + 1); // If rolled over midnight
    return d;
}

// Main Function: Set all span date-times
function setDateTimeInSpan() {
    let baseDate = new Date(); // Start with today
    let times = [
        { input: '#hcl_in',  span: '.hcl_in_daytime' },
        { input: '#hcl_out', span: '.hcl_out_datetime' },
        { input: '#washing_time2', span: '.washing_daytime2' },
        { input: '#phos_in',  span: '.phos_in_daytime' },
        { input: '#phos_out', span: '.phos_out_daytime' },
        { input: '#borax_in', span: '.borax_in_daytime' },
        { input: '#borax_out', span: '.borax_out_time' }
    ];

    let prevDate = baseDate;
    times.forEach(item => {
        let timeStr = $(item.input).val();
        if (timeStr) {
            let currentDate = getDateWithRollover(prevDate, timeStr);
            $(item.span).text(formatDateTime(currentDate));
            prevDate = currentDate; // Next time is relative to this
        }
    });

    // Special: Show washing_time1 → borax_out duration
    let wash1 = $('#washing_time1').val();
    let boraxOut = $('#borax_out').val();
    if (wash1 && boraxOut) {
        let d1 = getDateWithRollover(baseDate, wash1);
        let d2 = getDateWithRollover(d1, boraxOut);
        $('.wash_to_borex_out_time_daytime').text(
            `${formatDateTime(d1)} → ${formatDateTime(d2)}`
        );
    }
}




  </script>



