<?php
class Aimodel extends CI_Model
{
	
    


    
    //Ai BOX
	public function ai_box()
	{
       ?>
            <div class="row" style="background-color:white; margin-left: 10%; margin-top:20px; width:80% ">

                <div class="col-md-12">
                    <div class="card mb-4" >
                        <div class="card-body">
                            

                            <div class="breadcrumb"  >
                                <div class="col-md-12" style="margin-bottom: 20px;">
                                    <h4 style=" color:#007bff">AI Assistance</h4>
                                </div>
                               

                                <div class="col-md-6">
                                    <label><b style=" color:#007bff">Data Form</b></label>
                                    <input type="text" class="form-control" id="search_date1"  value="<?php echo date('01-m-Y')?>" required  >
                                </div>
                                
                                <div class="col-md-6">
                                    <label><b style=" color:#007bff">Data To</b></label>
                                    <input type="text" class="form-control" id="search_date2"  value="<?php echo date('d-m-Y')?>" required>
                                </div>
                                
                                <?php /*
                                <div class="col-md-4">
                                    <label><b style=" color:#007bff">From Department</b></label>
                                    <select class="form-control select2" id="department" name="department[]" multiple>
                                        <option value="Production">Production</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Payment">Payment</option>
                                        <option value="Sales" disabled>Sales</option>
                                        <option value="Quality" disabled>Quality</option>
                                    </select>
                                </div>
                                */?>

                                <div class="col-md-12" style="margin-top: 20px;">
                                    <label><b style=" color:#007bff">Please select the departments that is relevant to your inquiry.</b></label>
                                    <ul >
                                        <li>
                                            <label>
                                                <input type="checkbox" name="department[]" value="Production"> Production
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="department[]" value="Maintenance"> Maintenance
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="department[]" value="Payment"> Payment
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="department[]" value="Sales" disabled> Sales
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="checkbox" name="department[]" value="Quality" disabled> Quality
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            

                                <div class="col-md-12" style="margin-top: 20px;">
                                    <label><b style=" color:#007bff">Type Your Query</b> </label>
                                    <textarea class="form-control"  id="question"></textarea>
                                    <i>(The more details you provide, the better I can understand and respond!)</i>
                                </div>
                            
                                

                                <div class="col-md-12" style="margin-top: 20px;">
                                    <ul >
                                        <li>
                                            <label>
                                                <input type="radio"  name="new_or_reply" value="New"> New Query
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" checked name="new_or_reply" value="Reply"> Follow-Up Query
                                            </label>
                                        </li>
                                    </ul>
                                </div>


                                <div class="col-md-12" style="margin-top: 20px;">
                                    <label><b style=" color:#007bff">Share Currect Ans. / Share how to calculate / Trend AI Model </b> </label>
                                    <textarea class="form-control"  id="feedback"></textarea>
                                </div>
                        
                                <div class="col-md-12" style="margin-top: 20px;">
                                   <button onclick="fun_ask_to_ai()" id="ai_search" class="btn btn-info btn-icon" type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text"> Get Answers</span></button>
                                </div>
                            </div>

                            <textarea style="display:none"  id="last_response"></textarea>


                           
                            
                            <div id="loading_box"></div> 
                            <div id="table_show_ai"></div> 
                        
                        </div>
                    </div>
                </div>
                  

                <script>
                    
                    $(function () {
                        $("#search_date1").datepicker({dateFormat: 'dd-mm-yy'});
                        $("#search_date2").datepicker({dateFormat: 'dd-mm-yy'});
                    });
 
                    function fun_ask_to_ai(customer_id)
                    {
                        let search_date1=$('#search_date1').val();if(search_date1==''){$('#search_date1').focus();fun_message('warning','Warning','Select From Date','toast-bottom-right');return false;}
                        let search_date2=$('#search_date2').val();if(search_date2==''){$('#search_date2').focus();fun_message('warning','Warning','Select To Date','toast-bottom-right');return false;}
                        //let department=$('#department').val();if(department==''){$('#department').focus();fun_message('warning','Warning','Select department','toast-bottom-right');return false;}
                        let question=$('#question').val();if(question==''){$('#question').focus();fun_message('warning','Warning','Write your question','toast-bottom-right');return false;}
                        let selectedDepartments = [];
                        $('input[name="department[]"]:checked').each(function() {
                            selectedDepartments.push($(this).val());
                        });

                        
                        
                        let last_response=$('#last_response').val();
                        let new_or_reply = $('input[name="new_or_reply"]:checked').val();
                        let feedback=$('#feedback').val();

                        let last_response2 = "";
                        if(new_or_reply === "New"){
                            last_response2 = "";
                            $('#table_show_ai').html('');
                        }else{
                            last_response2 = last_response;
                        }
                       

                        $('#loading_box').html("<div class='loader-bubble loader-bubble-info m-5'></div>");
                        //$('.loader').show();
                        setTimeout(function() {
                            jQuery.post("<?php echo base_url().'index.php/Ai/ask_qus_from_ai';?>", 
                            {
                                search1:1,
                                search_date1:search_date1,
                                search_date2:search_date2,
                                department:selectedDepartments,
                                question:question,
                                last_response:last_response2,
                                feedback:feedback,
                            }, 
                            function(data, textStatus)
                            {	
                                //alert(data);
                                $('#last_response').val(data);
                                
                                if(new_or_reply === "New"){
                                    $('#table_show_ai').html('<hr>' + data);
                                }else{
                                    $('#table_show_ai').prepend('<hr>' + data);
                                }

                                $('#loading_box').html("");
                                //$('.loader').hide();
                            });
                        });//loader
                        
                    }//fucntion close 
                </script>
            </div>
            
       <?php 
    }//function close


    
   
    //Payment
    public function payment_cr_dr($parameter)
    {
        $from_date = $parameter['from_date'];
		$to_date = $parameter['to_date'];

        $sql = "SELECT 
                    C.name as customer_name,
                    C.limit_of_dis as amount_limit_of_this_customer_in_rupree,
                    A.day_limit as days_limit_of_this_customer,
                    A.fin_year as financial_year,
                    A.entry_date as invoice_date_or_billing_date,
                    A.invoice_no as invoice_no,
                    
                    A.notifi_date as we_start_notification_from_date,
                    A.last_date as last_date_to_pay_amount,
                    A.debit_amount as amount_in_invoice_or_billing_amount_in_rupree,
                    A.credit_amount as paid_amount_in_rupree,
                    A.payment_date as last_payment_date,
                    A.rem_amount as remaining_amount_in_rupree,
                    A.remarks as remarks
                    
                     
                    FROM cr_dr_master as A left join customer as C on C.id = A.customer_id 
                    WHERE 1=1 and A.entry_date between '$from_date' and '$to_date'
                    ORDER by C.name,A.entry_date ASC 
                ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close


    //production
    public function production($parameter)
    {
        $from_date = $parameter['from_date'];
        $to_date = $parameter['to_date'];

        $sql="  SELECT 
                A.entry_date as production_date,
                J.name as department,
                I.name as machine_name,
                A.mc_speed as machine_speed,
                B.name as input_product_name,
                B.size as input_size,
                D.name as grade_name,
                E.name as product_type,
                C.name as output_product_name,
                C.size as output_size,
                F.name as unit_name,
                
                A.shift1 as day_shift,
                A.shift_hours1 as day_shift_hours,
                A.no_of_spool1 as no_of_spool_in_day_shift,
                A.qty1 as production_quantity_in_day_shift,
                G.first_name as operator_name_in_day_shift,
                A.operator_id_1 as operator_ID_of_day_shift,
                A.helper1 as helper_ID_or_name_in_day_shift,
                A.down_type1 as breakdown_reason_type_in_day_shift,
                A.down_reason1 as breakdown_reason_in_day_shift,
                A.down_total_time1 as total_breakdown_hours_in_day_shift,
                A.running_hours_1 as total_machine_running_hours_in_day_shift,
                A.effi1 as production_efficiency_in_day_shift,

                A.shift2 as night_shift,
                A.shift_hours2 as night_shift_hours,
                A.no_of_spool2 as no_of_spool_in_night_shift,
                A.qty2 as production_quantity_in_night_shift,
                H.first_name as operator_name_in_night_shift,
                A.operator_id_2 as operator_ID_of_night_shift,
                A.helper2 as helper_ID_or_name_in_night_shift,
                A.down_type2 as breakdown_reason_type_in_night_shift,
                A.down_reason2 as breakdown_reason_in_night_shift,
                A.down_total_time2 as total_breakdown_hours_in_night_shift,
                A.running_hours_2 as total_machine_running_hours_in_night_shift,
                A.effi2 as production_efficiency_in_day_shift,
                
                A.total_spool as total_spool_in_day_and_night_shift,
                A.total_qty as total_quantity_in_day_and_night_shift,
                A.total_eff as total_efficiency_in_day_and_night_shift
               
                
                FROM production_entry as A 
                LEFT JOIN product as B ON B.product_id = A.in_product_id
                LEFT JOIN product as C ON C.product_id = A.out_product_id  
                LEFT JOIN product_grade as D ON D.id = A.grade 
                LEFT JOIN product_type as E ON E.id = A.product_type
                LEFT JOIN unit as F ON F.unit_id = A.unit_id
                LEFT JOIN employee as G ON G.emp_code = A.operator_id_1
                LEFT JOIN employee as H ON H.emp_code = A.operator_id_2
                LEFT JOIN machine_list as I ON I.mc_id = A.mc_id
                LEFT JOIN department as J ON J.department_id = I.dept 
                WHERE 1=1  and A.entry_date between '$from_date' and '$to_date'  ORDER by A.entry_date,I.name ASC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close
    

    //maintenance
    public function maintenance($parameter)
    {
        $from_date = $parameter['from_date'];
        $to_date = $parameter['to_date'];

        $sql="  SELECT 
                A.break_down_date as machine_breakdown_date,
                A.break_down_time as machine_breakdown_time,
                B.name as department,
                C.name as machine_name,
                
                A.type as Critical_or_nonCritical_breakdown,
                A.type2 as MBD_or_EBD_breakdown,
                P.name as breakdown_problem_name,
                A.problem as breakdown_problem_details,
                E.first_name as machine_operator_name,
                A.person as machine_operator_ID,
                A.shift_incharge1 as machine_shift_incharge_name,
                
                A.action_taken as action_taken_to_solve_breakdown,
                A.part_change as any_machine_part_change,
                A.active as breakdown_status,
                A.comp_date as machine_breakdown_solve_date,
                A.comp_time as machine_breakdown_solve_time,
                A.breakdown_total_time_in_min as total_minutes_taken_to_solve_breakdown,
                A.attend_by as breakdown_solve_by_maintenance_person,
                A.checked_by as breakdown_solved_checked_by_maintenance_person,
                A.shift_incharge2 as shift_incharge_of_maintenance,
                A.md_review  as md_review
                   
                FROM maint_problem as A 
                LEFT JOIN breakdown_problem_list as P ON P.id = A.problem_type_id
                LEFT JOIN department as B ON A.dept = B.department_id
                LEFT JOIN machine_list as C ON A.mc_no = C.mc_id  
                LEFT JOIN employee as E ON E.emp_code = A.person  
                WHERE 1=1   and A.entry_date between '$from_date' and '$to_date' ORDER by A.entry_date ASC
            ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }//function close



    //Ai BOX
	public function ai_box_popup()
	{
       ?>
            <div class="row" id="ai_box" style="background-color:white; margin-left: 10%; margin-top:20px; width:80% ">

                <div class="col-md-12">
                    

                            <div class="breadcrumb"  >
                              
                              
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <label><b style=" color:#007bff">Next Query</b> </label>
                                    <textarea class="form-control"  id="question"></textarea>
                                </div>
                             

                                <div class="col-md-12" style="margin-top: 20px;">
                                    <ul >
                                        <li>
                                            <label>
                                                <input type="radio"  name="new_or_reply" value="New"> New Query
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type="radio" checked name="new_or_reply" value="Reply"> Follow-Up Query
                                            </label>
                                        </li>
                                    </ul>
                                </div>

                        
                                <div class="col-md-12" style="margin-top: 20px;">
                                   <button onclick="fun_ask_to_ai()" id="ai_search" class="btn btn-info btn-icon" type="button"><span class="ul-btn__icon"><i class="i-Shutter"></i></span><span class="ul-btn__text"> Get Answers</span></button>
                                </div>
                            </div>

                            <textarea style="display:none"  id="last_response"></textarea>

                            <div id="loading_box">Wait ...</div> 
                            <div id="table_show_ai"></div> 
 
                </div>
                  

                <script>
                   
                    function fun_ask_to_ai()
                    {
                        let pagedata = $('#page_show').html();
                        let tempDiv = $('<div>').html(pagedata);
                        tempDiv.find('div.row#ai_box').remove();
                        //tempDiv.find('script, style').remove();
                        let htmlData = tempDiv.html();
                       
                        //$('#table_show_ai').html(finalHTMLData);
                        //console.log(pagedata);
                        
                        let question=$('#question').val();
                        if(question==''){
                            question = `Please:
                            1. Summarize the overall information.
                            2. If possible, provide a performance rating or evaluation based on available data.
                            `;
                        }
                        
                        let last_response=$('#last_response').val();
                        let new_or_reply = $('input[name="new_or_reply"]:checked').val();
                       

                        let last_response2 = "";
                        if(new_or_reply === "New"){
                            last_response2 = "";
                            $('#table_show_ai').html('');
                        }else{
                            last_response2 = last_response;
                        }
                       

                        $('#loading_box').html("<div class='loader-bubble loader-bubble-info m-5'></div>");
                        //$('.loader').show();
                        setTimeout(function() {
                            jQuery.post("<?php echo base_url().'index.php/Ai/ask_qus_from_ai_popup_model';?>", 
                            {
                                search1:1,
                                htmlData:htmlData,
                                question:question,
                                last_response:last_response2,
                               
                            }, 
                            function(data, textStatus)
                            {	
                                //alert(data);
                                $('#last_response').val(data);
                                
                                if(new_or_reply === "New"){
                                    $('#table_show_ai').html('<hr>' + data);
                                }else{
                                    $('#table_show_ai').prepend('<hr>' + data);
                                }

                                $('#loading_box').html("");
                                //$('.loader').hide();
                            });
                        });//loader
                        
                    }//fucntion close 
                </script>
            </div>
            
       <?php 
    }//function close







    
}//class close



