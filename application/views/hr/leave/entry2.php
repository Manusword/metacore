<?php 
    $loginId =$this->session->userdata('login_emp_id');
    $login_emp_code =$this->session->userdata('login_emp_code');
   if(!empty($res2[0]['ask_from_date']) and $res2[0]['ask_from_date']!='0000-00-00'){$ask_from_date=$this->Base->change_date_ymd($res2[0]['ask_from_date']);}else{$ask_from_date='';}
   if(!empty($res2[0]['ask_to_date']) and $res2[0]['ask_to_date']!='0000-00-00'){$ask_to_date=$this->Base->change_date_ymd($res2[0]['ask_to_date']);}else{$ask_to_date='';}
   if(!empty($res2[0]['approve_from_date']) and $res2[0]['approve_from_date']!='0000-00-00'){$approve_from_date=$this->Base->change_date_ymd($res2[0]['approve_from_date']);}else{$approve_from_date='';}
   if(!empty($res2[0]['approve_to_date']) and $res2[0]['approve_to_date']!='0000-00-00'){$approve_to_date=$this->Base->change_date_ymd($res2[0]['approve_to_date']);}else{$approve_to_date='';}
   if(!empty($res2[0]['doj']) and $res2[0]['doj']!='0000-00-00'){$doj=$this->Base->change_date_dmy($res2[0]['doj']);}else{$doj='';}
?>  
            
   

        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Leave</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >New Leave Application</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                            <input type="hidden"  id="id"  value="<?php if(isset($res2[0]['id']))echo $res2[0]['id'];?>">
                                             <input type="hidden" class="form-control"  id="emp_code"  readonly  autocomplete="off"  value="<?php if(isset($login_emp_code))echo $login_emp_code;?>"  >
                                               
                                           

                                            <div class="col-md-6" style="margin-top:10px">
                                                  <label> Ask Leave From</label>
                                                <input type="date" class="form-control"  id="ask_from_date" required  autocomplete="off" value="<?php if(isset($ask_from_date))echo $ask_from_date;?>" onchange="get_no_of_days()" >
                                            </div>

                                             <div class="col-md-6" style="margin-top:10px">
                                                  <label> Ask Leave To</label>
                                                  <input type="date" class="form-control"  id="ask_to_date" required  autocomplete="off" value="<?php if(isset($ask_to_date))echo $ask_to_date;?>" onchange="get_no_of_days()">
                                            </div>


                                             <div class="col-md-12" style="margin-top:10px">
                                                  <label>Ask Total Days</label>
                                                  <input type="text" class="form-control"  id="ask_total_days" readonly  autocomplete="off" value="<?php if(isset($res2[0]['ask_total_days']))echo $res2[0]['ask_total_days'];?>" >
                                            </div>

                                            <div class="col-md-12" style="margin-top:10px">
                                                  <label>Reason</label>
                                                  <input type="text" class="form-control"  id="reason_for" required  autocomplete="off" value="<?php if(isset($res2[0]['reason_for']))echo $res2[0]['reason_for'];?>"  <?php  if(isset($res2[0]['emp_code'])){ ?>  onchange="getDetils()"<?php }?> >
                                            </div>

                                           <div class="col-md-12" style="margin-top:10px">
                                                <label >Details</label>
                                                  <textarea  class="form-control"  id="reason" required  autocomplete="off"><?php if(isset($res2[0]['reason']))echo $res2[0]['reason'];?></textarea>
                                            </div>


                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-success" id="emp_leave_save2" onclick="emp_leave_save2()">Save</button>
                                                    </div>
                                                </div>
                                            </div>   
                          
                                    </div>
                                    
                               
                            </div>
                        </div>
                    </div>

                   
          </div><!-- end of main-content -->   


<script>

  function emp_leave_save2()
	{
		  let emp_code=$('#emp_code').val();if(emp_code==''){$('#emp_code').focus();fun_message('warning','Warning','Emp Code not valid.','toast-bottom-right');return false;}
			
			let ask_from_date=$('#ask_from_date').val();if(ask_from_date==''){$('#ask_from_date').focus();fun_message('warning','Warning','Enter From Date','toast-bottom-right');return false;}
			let ask_to_date=$('#ask_to_date').val();if(ask_to_date==''){$('#ask_to_date').focus();fun_message('warning','Warning','Enter To Date','toast-bottom-right');return false;}
			let ask_total_days=$('#ask_total_days').val();if(ask_total_days==''){$('#ask_to_date').focus();fun_message('warning','Warning','Re-select Both Dates','toast-bottom-right');return false;}
      let reason_for=$('#reason_for').val();if(reason_for==''){$('#reason_for').focus();fun_message('warning','Warning','Enter Reason','toast-bottom-right');return false;}
			let reason=$('#reason').val();


      $('.loader').show();
      setTimeout(function() {
        jQuery.post("<?php echo base_url().'index.php/Hr/emp_leave_save2';?>", 
        {
            emp_code:emp_code,
            reason_for:reason_for,
            reason:reason,
            ask_from_date:ask_from_date,
            ask_to_date:ask_to_date,
            ask_total_days:ask_total_days,
        }, 
        function(data, textStatus)
        {	
            if(data=='Save'){
                $('#ask_from_date').val('');
                $('#ask_to_date').val('');
                $('#ask_total_days').val('');
                $('#reason_for').val('');
                $('#reason').val('');
                fun_message('success',data,'Save Successfully','toast-bottom-right');
            }
            else{
              fun_message('error','Error',data,'toast-bottom-right');
            }
            $('#emp_leave_save2').show();
            $('.loader').hide();
        });
      });
	}//function close



function get_no_of_days() {

    let ask_from_date = $('#ask_from_date').val();
    let ask_to_date   = $('#ask_to_date').val();

    if (ask_from_date === '' || ask_to_date === '') {
        return;
    }

    // Convert to Date objects
    let fromDate = new Date(ask_from_date);
    let toDate   = new Date(ask_to_date);

    // Today (time removed)
    let today = new Date();
    today.setHours(0,0,0,0);

    // ❌ From date before today
    if (fromDate < today) {
        $('#ask_from_date').val('');
        $('#ask_total_days').val('');
        fun_message('warning','Warning','From date cannot be before today','toast-bottom-right');
        return false;
    }

    // ❌ To date before from date
    if (toDate < fromDate) {
        $('#ask_to_date').val('');
        $('#ask_total_days').val('');
        fun_message('warning','Warning','To date cannot be before From date','toast-bottom-right');
        return false;
    }

    // ✅ Valid → calculate days
    let daysDiff = get_day_diff(ask_from_date, ask_to_date);
    $('#ask_total_days').val(daysDiff);
}



  function get_day_diff(from_date,to_date){
      let fromDate = new Date(from_date);
      let toDate = new Date(to_date);

      let timeDiff = toDate - fromDate;
      return daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24))+1; // convert milliseconds to days
  }


</script>

