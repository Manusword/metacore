<?php 
    $loginId =$this->session->userdata('login_emp_id');
   if(!empty($res2[0]['issue_date']) and $res2[0]['issue_date']!='0000-00-00'){$issue_date=$this->Base->change_date_ymd($res2[0]['issue_date']);}else{$issue_date='';}
?>  
            
   

      <!-- ============ Body content start ============= -->
      <div class="main-content">
                  <div class="breadcrumb">
                        <h1>Canteen Coupon Upload</h1>
                  </div>
                  <div class="separator-breadcrumb border-top" ></div>
                  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Upload List</div>
                                    <div class="form-row">
                                      
                                            <input type="hidden" id="url"  value="<?php echo $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);?>">
                                           
                                          

                                            <div class="col-md-12" style="margin-top:10px">
                                                  <label>Paste Data</label>
                                                  <textarea id="attendanceLog" class="form-control" style="height:100px"></textarea>
                                            </div>

                                          
                                            
                                          
                                               
                                            <div class="col-md-12" style="margin-top:50px;">                            
                                              <div class="box-footer">
                                                    <div class="col-md" align="center" ><span id="wait" style="color:orange; display:none;"><div class="spinner spinner-info mr-3"></div></span>
                                                      <button type="button" class="btn btn-info"  onclick="trim_data('No')">Trim Data</button>
                                                    </div>
                                                </div>

                                                <p><i>If the trimmed data is invalid, please make the necessary corrections such as removing incorrect lines, correcting the employee code, and setting the correct date and time. Once done, press the 'Trim' button again.</i></p>
                                            </div>  

                                    </div>
                              </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                              <div class="card-title" >Upload List</div>
                                    <div class="form-row">
                                      
                                         

                                          <div class="col-md-12" style="margin-top:10px">
                                                <button type="button" class="btn btn-info"  onclick="join_data()">Join Data</button>
                                          </div>

                                          <div class="col-md-12" style="margin-top:10px">
                                                <label>Date</label>
                                                <input type="date" id="dateLog" class="form-control" />
                                          </div>

                                           <div class="col-md-4" style="margin-top:10px">
                                                <label>Breakfast Data</label>
                                                <textarea id="breakfastLog" class="form-control" style="height:500px"></textarea>
                                          </div>


                                          <div class="col-md-4" style="margin-top:10px">
                                                <label>Lunch Data</label>
                                                <textarea id="lunchLog" class="form-control" style="height:500px"></textarea>
                                          </div>

                                          <div class="col-md-4" style="margin-top:10px">
                                                <label>Dinner Data</label>
                                                <textarea id="dinnerLog" class="form-control" style="height:500px"></textarea>
                                          </div>

                                            

                                    </div>
                              </div>
                        </div>

                    </div>

                    <div class="col-md-6" > 
                        <div class="card mb-4" id="outputBox" style="display: none;">    
                              <div class="card-body">
                                    <div class="card-title" >Data After Trim</div>
                                    <div id="table_show" style="margin-top:10px"></div>
                                  <button type="button" class="btn btn-success"  onclick="trim_data('Yes')">Upload to Save</button>
                              <div class="card-body">
                        </div>
                  </div>
                  </div><!-- row --> 
      </div><!-- end of main-content -->   




        
   

    

<?php $this->load->view('js/hr_js');?>



<script>

      function join_data() {
            const date = document.getElementById("dateLog").value;
            if (!date) {
                  alert("Select Date First");
                  return;
            }

            const breakfast = document.getElementById("breakfastLog").value.trim().split("\n").filter(x => x.trim() !== "");
            const lunch = document.getElementById("lunchLog").value.trim().split("\n").filter(x => x.trim() !== "");
            const dinner = document.getElementById("dinnerLog").value.trim().split("\n").filter(x => x.trim() !== "");

            let finalList = [];
            let sno = 1;

            // BREAKFAST
            breakfast.forEach(code => {
                  finalList.push(
                        sno + "\t" + code.trim() + "\t" + date + "\t08:00:00"
                  );
                  sno++;
            });

            // LUNCH
            lunch.forEach(code => {
                  finalList.push(
                        sno + "\t" + code.trim() + "\t" + date + "\t13:00:00"
                  );
                  sno++;
            });

            // DINNER
            dinner.forEach(code => {
                  finalList.push(
                        sno + "\t" + code.trim() + "\t" + date + "\t20:00:00"
                  );
                  sno++;
            });

            //console.log(finalList.join("\n"));
            document.getElementById("attendanceLog").value = finalList.join("\n");
            // document.getElementById("breakfastLog").value = '';
            // document.getElementById("lunchLog").value = '';
            // document.getElementById("dinnerLog").value = '';
      }


      //--------------------------------------------------------------------Canteen Coupon upload
	function trim_data(saveValue)
      {
		$('#outputBox').show();
            let url=$('#url').val();
            let id=$('#id').val();
           
            const rawData = document.getElementById("attendanceLog").value;
            if(rawData==''){$('#rawData').focus();fun_message('warning','Warning','Enter Data','toast-bottom-right');return false;}
            const lines = rawData
            .trim()
            .split("\n")
            .map(line => line.trim())
            .filter(line => line); // remove empty lines

            const attendanceArray = lines.map(line => {
            const parts = line.split(/\s+/); // split by any whitespace
            const emp_code = parts[1].replace(/^0+/, ''); // remove leading zeros
            const entry_date = parts[2];
            const entry_time = parts[3];
            const entry_date_time = `${entry_date} ${entry_time}`;
            return { emp_code, entry_date, entry_time, entry_date_time };
            });

            //console.log(JSON.stringify(attendanceArray));
            let logData = JSON.stringify(attendanceArray);
            
            //-------------check data is going to save valid or not
            $('#emp_coupon_upload').hide();
            $('.loader').show();
            setTimeout(function() {
            jQuery.post("<?php echo base_url().'index.php/Hr/upload_coupon_save';?>", 
                  {
                        id:id,
                        logData:logData,
                        saveValue:saveValue
                  }, 
                  function(data, textStatus)
                  {	
                        $('#table_show').html(data);
                        $('#emp_coupon_upload').show();
                        $('.loader').hide();

                        if(saveValue == "Yes" && textStatus=="success"){
                            //console.log(textStatus)  
                            alert("Data uploaded successfully")
                            showPage(url);
                        }
                  });
            });
            
			
	}
</script>