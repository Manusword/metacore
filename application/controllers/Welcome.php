<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
		$this->load->model('Base');		
	}//function close


	public function index()
	{
		$result['company'] = $this->Company->prime_company();
		$this->load->view('main/link_top',$result);
		$this->load->view('main/login',$result);
		$this->load->view('main/link_bottom',$result);
	}//function close

	public function login()
	{
		$result = array();
		$this->load->view('main/link_top',$result);
		$result['company'] = $this->Company->prime_company();
		$today_date_time=date("Y-m-d H:i:s");
		
		
		//adding details in user name 
		if(isset($_REQUEST['username']) and isset($_REQUEST['password']) )
		{
			$username  = $_REQUEST['username'];
			$password  = md5($_REQUEST['password']);
			
			//check username or pass word is valid or not
			$out  = $this->Base->check_id_pass_valid($username,$password);
			if($out['status'] == 'FALSE')
			{
				$result['msg'] = $out['msg'];
				$this->load->view('main/login',$result);
			}
			else
			{
				//check login form same net or diff
				$out  = $this->Base->check_login_status($username);
				if($out['status'] == 'FALSE')
				{
					$result['msg'] = $out['msg'];
					$this->load->view('main/login',$result);
				}
				else
				{
					//creating session
					$this->Base->create_session($username);
					redirect('Welcome/home');
					
				}
			}//if($out['status'] == 'FALSE')
		}
		else
		{
			$result['msg'] ="Please Enter username and password";
			$this->load->view('main/login',$result);
		}//username password not valid
		$this->load->view('main/link_bottom',$result);
	
	}//function close



	public function logout()
	{
		$login_emp_id=$this->session->userdata('login_emp_id');
		$ip=$this->input->ip_address();
		
		//-----------update login time
		$this->Base->update_login_ip($login_emp_id,'out',"logout");
		
		//-----------unset 
		$this->Base->unset_session();
		redirect('Welcome');
	}//function close


	
	public function password_update()
	{
		$login_emp_id=$this->session->userdata('login_emp_id');
		$where="id='$login_emp_id' ";
		$result['res2']=$this->Mymodel->select_where('employee',$where);
		
		$this->load->view('profile/password_update',$result);
	}
	
	public function password_update_save()
	{
		$login_emp_id=$this->session->userdata('login_emp_id');
		$last_password_change_time = date('Y-m-d H:i:s');
		
		$old_pass1=$_REQUEST['old_pass'];
		$old_pass=md5($old_pass1);
		$new_pass=$_REQUEST['new_pass'];
		$re_enter=$_REQUEST['re_pass'];
		
		$where="id='$login_emp_id' and pwd='$old_pass' ";
		$res2=$this->Mymodel->select_where('employee',$where);
		if(!empty($res2))
		{
			if($new_pass==$re_enter)
			{
				$new_pass1=md5($new_pass);
				$data=array('pwd'=>"$new_pass1",'last_password_change'=>"$last_password_change_time");
				$where=array('id'=>"$login_emp_id");   
				$this->Mymodel->update('employee',$data,$where);
				
				echo "Save";
			}
			else
			{
				echo "Re-Enter Password Not Matched";
				exit;
			}
		}
		else
		{
			echo "Invalid Old Password";
			exit;
		}
		
		
	}//function close














	//-----------------------------------Home page

	public function home()
	{
		//morning mail 
		$this->daily_mail_send();
		//morning mail
		$this->Base->check_session();
		$result['company'] = $this->Company->profile();
		$result['design'] = $this->Company->design();
		$this->load->view('main/link_top',$result);
		$this->load->view('main/header',$result);
		
		//default dashbord
		//$result['go_to_dashbord'] = "Welcome/production";
		$result['go_to_dashbord'] = "Welcome/blank";

		$this->load->view('main/home',$result);
	}//function close

	public function dispatch_dashboard()
	{
		$result['data']= '';
		$this->load->view('main/dashboard/dispatch',$result);
	}//function close

	public function energy_dashboard()
	{
		$result['data']= '';
		$this->load->view('main/dashboard/energy',$result);
	}//function close
	
	


	//------blank_dashbord   
	public function blank()
	{
		$result['company'] = $this->Company->profile();
		$result['design'] = $this->Company->design();
		$this->load->view('main/blank',$result);
	}//function close



	//------AI_dashbord   
	public function ai()
	{
		$result['company'] = $this->Company->profile();
		$result['design'] = $this->Company->design();
		$this->load->view('main/dashboard/ai',$result);
	}//function close


	//------production dashboard   
	public function production()
	{
		$result['data']= '';
		$this->load->view('main/dashboard/production',$result);
	}//function close


	//------hr dashboard   
	public function hr()
	{
		$result['data']= '';
		$this->load->view('main/dashboard/hr',$result);
	}//function close

	//------hr dashboard   
	public function hr2()
	{
		$result['data']= '';
		$this->load->view('main/dashboard/hr2',$result);
	}//function close


	
	
	

	//Dispatch print bill
	public function print_dispatch()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$this->Dispatchmodel->print_dispatch($id);
		}
	}//function close

	/*
	public function mail_dispatch()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$this->Dispatchmodel->mail_dispatch($id,'New');
		}
	}//function close
	*/

	public function print_po()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$this->Pomodel->print_po($id);
			
		}
	}//function close

	/*
	public function mail_po()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$this->Pomodel->po_action_email($id);
			
		}
	}//function close
	*/



	public function mail_type_1_body()
	{
		//------------------------------------------------------------------mail send
		if(!empty($_REQUEST['customer_id']) )
		{
			$customer_id =$_REQUEST['customer_id'];

			// customer details
			$where=" and A.customer_id = '$customer_id'  ";
			$result['cdet'] = $this->Customermodel->get_customer_with_id($customer_id);
			
			$result['res2'] = $this->Customermodel->get_cus_flowup_with_search($where);
			$this->load->view('customer/payment/flowup/mailTemp/type1',$result);
		
		}//update
	}//function close


	public function mail_type_2_body()
	{
		//------------------------------------------------------------------mail send
		if(!empty($_REQUEST['customer_id']) )
		{
			$customer_id =$_REQUEST['customer_id'];

			// customer details
			$where=" and A.customer_id = '$customer_id'  ";
			$result['cdet'] = $this->Customermodel->get_customer_with_id($customer_id);
			
			$result['res2'] = $this->Customermodel->get_cus_flowup_with_search($where);
			$this->load->view('customer/payment/flowup/mailTemp/type2',$result);
		
		}//update
	}//function close



	

	public function daily_production_mail_content()
	{
		$yesterday = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
		$year = date('Y');
		$month = date('m');
		
		echo "Production Summary ";
		
		
		//yeaterday_production
		$yes_production = $this->Productionmodel->create_production_report_on_date($yesterday);
		
		echo "<br><br><br><br><br><br><br><br>";
		$dept =5;//wet block
		$this->Hrmodel->get_dept_emp_detials($dept,$year,$month);
		$this->Hrmodel->get_dept_emp_full_detials($dept,$year,$month);
		$this->Productionmodel->get_all_production_report($dept,$year,$month);
		$this->Productionmodel->get_all_production_report2($dept,$year,$month);

		echo "<br>";
		$dept =6;//dry
		$this->Hrmodel->get_dept_emp_detials($dept,$year,$month);
		$this->Hrmodel->get_dept_emp_full_detials($dept,$year,$month);
		$this->Productionmodel->get_all_production_report($dept,$year,$month);
		$this->Productionmodel->get_all_production_report2($dept,$year,$month);

		echo "<br>";
		$dept =28;//mini
		$this->Hrmodel->get_dept_emp_detials($dept,$year,$month);
		$this->Hrmodel->get_dept_emp_full_detials($dept,$year,$month);
		$this->Productionmodel->get_all_production_report($dept,$year,$month);
		$this->Productionmodel->get_all_production_report2($dept,$year,$month);
	}//function close
	

	public function production_daily_mail()
	{
		$sql = "SELECT details4 FROM company_profile where id=20 ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		$mail_list = explode(',',$res8[0]['details4']);
		
		$current_date = date('d-m-Y');
		$yesterday_date = date( "d-m-Y",strtotime("-1 day",strtotime($current_date)));
		$sub = "$yesterday_date : Production Summary";
		
		//---api
		//getting data form  ERP
		$url = base_url()."index.php/Welcome/daily_production_mail_content";
		
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$body = curl_exec($ch);
		foreach($mail_list as $mail_id){$this->Base->send_mail($mail_id,$sub,$body);}
	}//function close
	
	public function sch_supp_daily_mail()
	{
		$sql = "SELECT details6 FROM company_profile where id=20 ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		$mail_list = explode(',',$res8[0]['details6']);

		$year = date('Y');
		$month = date('m');
		$search_date1= date("$year-$month-01");
		$search_date2= date("$year-$month-t");
		$where = " and B.type_of_bill='Tax Invoice' and A.from_date between '$search_date1' and '$search_date2' GROUP BY A.details_id   ORDER by B.schedule_id DESC ";
		$result['res2'] = $this->Dispatchmodel->schedule_serach_query($where);
		$body = $this->load->view('dispatch/schedule/show_table',$result,true);
		
		$current_month = date('M');
		$sub = " $current_month : Forecast Vs Supply Summary";
		foreach($mail_list as $mail_id){$this->Base->send_mail($mail_id,$sub,$body);}
	}//function close


	public function hr_daily_mail()
	{
		$sql = "SELECT details8 FROM company_profile where id=20 ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		$mail_list = explode(',',$res8[0]['details8']);
		
		
		$current_date= date('Y-m-d');
		$search_date1 = date( "Y-m-d 00:00:00",strtotime("-1 day",strtotime($current_date)));
		$search_date2= date( "Y-m-d 23:59:59",strtotime("-1 day",strtotime($current_date)));
		$yesterday_date = date( "d-m-Y",strtotime("-1 day",strtotime($current_date)));
		$where = " and A.shift_in_time between '$search_date1' and '$search_date2'  ORDER by A.shift_in_time ASC ";
		$result['res2'] = $this->Hrmodel->get_all_att_punch_with_search($where);
		$body = $this->load->view('hr/punch/show_table',$result,true);
		
		$result['search_date'] = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
		$body2 = $this->load->view('hr/attendance/show2',$result,true);
		
		$sub = "$yesterday_date : Man-Power Attendance ";
		$body3 = $body.$body2;
		foreach($mail_list as $mail_id){$this->Base->send_mail($mail_id,$sub,$body);}
		
	}//function close

	public function hr_daily_summary_mail()
	{
		$sql = "SELECT details8 FROM company_profile where id=20 ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		$mail_list = explode(',',$res8[0]['details8']);
		$current_date= date('Y-m-d');
		$yesterday_date = date( "d-m-Y",strtotime("-1 day",strtotime($current_date)));
		$result['search_date'] = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
		$body2 = $this->load->view('hr/attendance/show2',$result,true);
		
		$sub = "$yesterday_date : Man-Power Attendance Summary 2 ";
		foreach($mail_list as $mail_id){$this->Base->send_mail($mail_id,$sub,$body2);}
	}//function close


	public function hr_daily_summary_mail2()
	{
		$sql = "SELECT details8 FROM company_profile where id=20 ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		$mail_list = explode(',',$res8[0]['details8']);
		$current_date= date('Y-m-d');
		
		$yesterday_date = date( "d-m-Y",strtotime("-1 day",strtotime($current_date)));
		
		$result['search_date'] = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
		$body2 = $this->load->view('hr/attendance/show3',$result,true);
		
		$sub = "$yesterday_date : Man-Power Attendance Summary ";
		foreach($mail_list as $mail_id){$this->Base->send_mail($mail_id,$sub,$body2);}
	}//function close


	//update all reminder
	public function daily_reminder_update()
	{
		$today = date("Y-m-d");
        $sql="  SELECT reminder_id,next_event_date,repeat_status FROM reminder where next_event_date<'$today' and repeat_status != 'none'  ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		if(!empty($res8))
		{
			foreach($res8 as $r){
				$reminder_id = $r['reminder_id'];
				$next_event_date = $r['next_event_date'];
				$repeat_status = $r['repeat_status'];
				//getting next event date
				$new_next_event_date = $this->Base->add_givin_days_in_date_ymd($next_event_date,$repeat_status);
				//update reminder
				$data=array( 'next_event_date'=>"$new_next_event_date");
				$where=array('reminder_id'=>"$reminder_id");   
				$this->Mymodel->update('reminder',$data,$where);
			}
		}
		
	}//function close



	//function 2
	public function daily_mail()
	{
		$sql = "SELECT details1,details2,details4 FROM company_profile where id=20 ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		if($res8[0]['details1'] == "Yes" and $res8[0]['details2'] <=  date('Y-m-d H:i:s'))
		{
			$current_saved_date = date('Y-m-d 11:00:00');
			$next_date = date( "Y-m-d H:i:s",strtotime("+1 day",strtotime($current_saved_date)));;
			$sql = "update company_profile set details2 = '$next_date' WHERE id=20 ";
			$query = $this->db->query($sql);
			
			//$this->hr_daily_mail();
			//$this->hr_daily_summary_mail2();
			//$this->hr_daily_summary_mail();
			//$this->sch_supp_daily_mail();
			//$this->production_daily_mail();
			$this->daily_reminder_update();
		}
	}//function close

	//function 1
	public function daily_mail_send()
	{
		//---api
		$url = base_url()."index.php/Welcome/daily_mail";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$body = curl_exec($ch);
		
	}//function close







	//approve by mail
	public function po_approved_by_email()
	{
		$today_date=date("Y-m-d H:i:s");
		if(isset($_REQUEST['email'])){$email=$_REQUEST['email'];}
		if(isset($_REQUEST['newstage'])){$newstage=$_REQUEST['newstage'];}
		if(isset($_REQUEST['po_id'])){$po_id=$_REQUEST['po_id'];}
		if(isset($_REQUEST['current_status'])){$current_status=$_REQUEST['current_status'];}
		if(!empty($po_id) and !empty($email) and !empty($newstage))
		{
			$where5=" po_id='$po_id'  ";
			$out5=$this->Mymodel->select_where('po_entry',$where5);
			if(isset($out5) and count($out5)>0)
			{
				$current_stage2=$out5[0]['stage'];
				if($current_status!=$current_stage2)
				{
					echo "This Action is already taken";
				}
				else
				{
					$data2=array(
								  'stage'=>"$newstage",
								  'dept_aproved_by'=>"$email",
								  'dept_aproved_date'=>"$today_date",
								  'comment'=>"No comment update by email",
								  'update_by'=>"$email",
								  'update_date'=>"$today_date",
							  );
					$where2=array('po_id'=>"$po_id");   
					$this->Mymodel->update('po_entry',$data2,$where2);
					echo "Thank You. You are approved to this PO";
				}
			}//po id valid
		}//not empty
	}//function close

	//reject by mail
	public function po_reject_by_email()
	{
		$today_date=date("Y-m-d H:i:s");
		if(isset($_REQUEST['email'])){$email=$_REQUEST['email'];}
		if(isset($_REQUEST['newstage'])){$newstage=$_REQUEST['newstage'];}
		if(isset($_REQUEST['po_id'])){$po_id=$_REQUEST['po_id'];}
		if(isset($_REQUEST['current_status'])){$current_status=$_REQUEST['current_status'];}

		if(!empty($po_id) and !empty($email) and !empty($newstage))
		{
			$where5=" po_id='$po_id'  ";
			$out5=$this->Mymodel->select_where('po_entry',$where5);
			if(isset($out5) and count($out5)>0)
			{
				$current_stage2=$out5[0]['stage'];
				if($current_status!=$current_stage2)
				{
					echo "This Action is already taken";
				}
				else
				{
					$data2=array(
									  'stage'=>"$newstage",
									  'dept_aproved_by'=>"",
									  'dept_aproved_date'=>"",
									  'reject_by'=>"$email",
									  'reject_date'=>"$today_date",
									  'comment'=>"No comment update by email",
									  'update_by'=>"$email",
									  'update_date'=>"$today_date",
								  );
					$where2=array('po_id'=>"$po_id");   
					$this->Mymodel->update('po_entry',$data2,$where2);
					echo "Thank You. You are Rejected this PO";
				}
			}//po id valid
		}//not empty
	}//function close





















	//old code
	//employee attendance yesterday
	/*
	public function yesterday_emp_attend_api()
	{
		$sql = "SELECT details2,details3 FROM company_profile where id=19 ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		if($res8[0]['details2'] == "Yes" and $res8[0]['details3'] <=  date('Y-m-d H:i:s'))
		{
			
			$current_saved_date = $res8[0]['details3'];
			$date_time = date( "Y-m-d H:i:s",strtotime("-1 day",strtotime($current_saved_date)));
			$date = $this->Base->change_date_into_day($date_time);
			$month = $this->Base->change_date_into_month($date_time);
			$year = $this->Base->change_date_into_year($date_time);
			
			//creating column name
			$day_colomn = "d$date";

			//check entry is manual done or not like Sunday/ Rest
			$sql = "select att_monthly_id,emp_code FROM  daily_attendance_monthly where  att_year='$year' and att_month='$month' and  ($day_colomn = '' or $day_colomn is NULL)    ";
			$query = $this->db->query($sql);
			$res9 = $query->result_array();
			foreach($res9 as $r)
			{
			 	$erp_id = $r['emp_code'];
				$sql7 = "select active FROM  employee where  id='$erp_id'   ";
				$query7 = $this->db->query($sql7);
				$res7 = $query7->result_array();
				if(!empty($res7) and $res7[0]['active'] == 'Active')
				{
					$att_monthly_id = $r['att_monthly_id'];
					$sql = "Update daily_attendance_monthly set $day_colomn = 'A' where  att_monthly_id='$att_monthly_id'  ";
					$query = $this->db->query($sql);
					//calculate salary
					$this->Hrmodel->add_total_present_absent_attendance_monthly($att_monthly_id);
				}
				
			}//foreach
			
			$next_date = date( "Y-m-d H:i:s",strtotime("+1 day",strtotime($current_saved_date)));;
			$sql = "update company_profile set details3 = '$next_date' WHERE id=19 ";
			$query = $this->db->query($sql);
		}
	}//function close
	

	//last_shift_auto_out_emp_attend_api after 16 hours form out time
	
	public function last_shift_auto_out_emp_attend_api()
	{
		$sql = "SELECT details5,details6,details8,details9,details10 FROM company_profile where id=19 ";
		$query = $this->db->query($sql);
		$res8 = $query->result_array();
		if($res8[0]['details5'] == "Yes" and $res8[0]['details6'] <=  date('Y-m-d H:i:s'))
		{
			$current_saved_date = $res8[0]['details6'];
			$today = date('Y-m-d 00:00:00');
			$current_time = strtotime(date('Y-m-d H:i:s'));
			$query=" SELECT * FROM daily_attendance where   out_time='0000-00-00 00:00:00' and  shift_in_time < '$today' ";
			$out = $this->Mymodel->query1($query);
			//print_r($out);
			$emp_list_for_mail = array();
			foreach($out as $o)
			{	
				$shift_out_time2 = $o['shift_out_time2'];
				//adding 16 hours 
				$max_time_stay_in_company =  strtotime(date( "Y-m-d H:i:s",strtotime("+1 hour",strtotime($shift_out_time2))));
				//checking current time is greate than emp max time to stay
				if($current_time >= $max_time_stay_in_company )
				{
					$atten_id = $o['id'];
					$shift_in_time = $o['shift_in_time'];
					
					
					//full duty hours
					$to_time = strtotime($shift_in_time);
					$shift_out_time22 = strtotime($shift_out_time2);
					$in_min = round(abs($to_time - $shift_out_time22) / 60,2);
					$duty_hours = round(abs($in_min) / 60,1);
					$full_day_duty = "F";
					
					//save data
					$data = array(
						'out_time'=>"$shift_out_time2",
						'out_min_late_early'=>"0",
						'out_status'=>"E",
						'duty_hours'=>"$duty_hours",
						'full_day_duty'=>"$full_day_duty",
						'ot_hours'=>"0",
						'save_from'=>"Auto",
					);
					$where2=array('id'=>"$atten_id");   
					$this->Mymodel->update('daily_attendance',$data,$where2);
					//getting name for send me missing punch mail
					$emp_code = $o['emp_code'];
					$query7=" SELECT first_name,last_name FROM employee where   emp_code='$emp_code' ";
					$out7 = $this->Mymodel->query1($query7);
					$emp_name = $out7[0]['first_name'].' '.$out7[0]['last_name'];
					$shift_in_time2 = $this->Base->change_date_dmy_hisa($shift_in_time);
					$shift_out_time22 = $this->Base->change_date_dmy_hisa($shift_out_time2);
					$emp_list_for_mail[] = $emp_code." ($emp_name) In Time : $shift_in_time2 Out Time : $shift_out_time22 <br><br>";

				}//time diff
			}//foreach


			if(!empty($emp_list_for_mail))
			{
				//print_r($emp_list_for_mail);
				$all_emp_code = implode(",",$emp_list_for_mail);
				
				
				//send mail to hr that emp_code is not created in erp.
				$body = " 	These Employee didn't OUT punched into Machine. Emp Code are : <br><br> $all_emp_code <br><br> 
							System Auto out these employee on his/her shift time. <br><br>
							And System doesn't add his/her OT. So you have to add OT via manual entry
							";
				$body_footer2="<br><br> Thank You.";
				$body_footer2=$body_footer2."<br><br><span style='color:red;'>This is system generated email. No need to reply.</span>";
				$body2 = $body.$body_footer2;
				if($res8[0]['details9'] == "Yes")
				{
					$tolist = explode(",",$res8[0]['details10']);
					if(!empty($tolist))
					{
						foreach($tolist as $to)
						{
							$this->Base->send_mail($to,"Attendance Punch Missing",$body2);
						}
					}
				}//mail
			}//if(!empty($emp_list_for_mail))
			
			$next_date = date( "Y-m-d H:i:s",strtotime("+12 hour",strtotime($current_saved_date)));;
			$sql = "update company_profile set details6 = '$next_date' WHERE id=19 ";
			$query = $this->db->query($sql);
		}//details5
	}//function close
	

	//employee attendance
	
	public function emp_attend_api()
	{
		
		$this->yesterday_emp_attend_api();//absent all yesterday 
		$this->last_shift_auto_out_emp_attend_api();//last_shift_auto_out_emp_attend_api
		

		if(isset($_REQUEST['emp_code']))
		{
			$today = date('Y-m-d H:i:s');
			if(isset($_REQUEST['date_time'])){$date_time= $this->Base->change_date_ymd_hisa($_REQUEST['date_time']);}else{$date_time=date('Y-m-d H:i:s');}
			$emp_code = $_REQUEST['emp_code'];
			$data_list = array('emp_code'=>$emp_code,'date_time'=>$date_time);
			//check emp_code is ok or not
			$query=" SELECT id FROM employee where  emp_code='$emp_code' ";
			$emp = $this->Mymodel->query1($query);
			if(!empty($emp))
			{
				
				//checking last entry status
				$query=" SELECT * FROM daily_attendance where emp_code='$emp_code' ORDER BY shift_in_time DESC  LIMIT 1 ";
				$last_entry = $this->Mymodel->query1($query);
				//print_r($last_entry);
				if(!empty($last_entry))
				{
					//entry exits 
					//check last entry in/out or only out
					if($last_entry[0]['out_time'] == '0000-00-00 00:00:00')
					{
						//new entry
						//adding 10 min to check not repeat same entry
						$in_time_30_min_after = date( "Y-m-d H:i:s",strtotime("+30 min",strtotime($last_entry[0]['in_time'])));
						if($date_time > $in_time_30_min_after)
						{
							//if last shift out time is before 7 hours then it is new in duty punch
							$in_time_7_hours_after = date( "Y-m-d H:i:s",strtotime("+420 min",strtotime($last_entry[0]['shift_out_time2'])));
							if($date_time >= $in_time_7_hours_after)
							{
								//next day in punch
								$this->entry_attendance_via_machine('IN',$data_list);
							}
							else
							{
								//same day out punch
								$this->entry_attendance_via_machine('OUT',$data_list);
							}//7hours

							
						}//10 min
						
					}
					else
					{
						//same day 2 entry check
						$test = new DateTime($last_entry[0]['shift_in_time']);
						$last_shift_in_date =  date_format($test,'Y-m-d');
						$test = new DateTime($date_time);
						$punch_date =  date_format($test,'Y-m-d');
						if($punch_date != $last_shift_in_date)
						{
							//out time within 30 min then no in entry
							$out_time_30_min_after = date( "Y-m-d H:i:s",strtotime("+30 min",strtotime($last_entry[0]['out_time'])));
							if($date_time > $out_time_30_min_after)
							{
								$this->entry_attendance_via_machine('IN',$data_list);
							}//30 min out time
						}//same day
					}
				}
				else
				{	
					//first time entry IN entry
					$this->entry_attendance_via_machine('IN',$data_list);
					
				}//if(!empty($last_entry))
				
			}//if(!empty($emp)) if emp present in employee table
			else
			{ 
				//send mail to hr that emp_code is not created in erp.
				$body = " New attendance punch by $emp_code at $date_time. But this employee is not created in ERP.<br> So create this employee into ERP. ";
				$body_footer2="<br><br> Thank You.";
				$body_footer2=$body_footer2."<br><br><span style='color:red;'>This is system generated email. No need to reply.</span>";
				$body2 = $body.$body_footer2;
				
				$sql = "SELECT details8,details9,details10 FROM company_profile where id=19 ";
				$query = $this->db->query($sql);
				$res8 = $query->result_array();
				if($res8[0]['details9'] == "Yes")
				{
					$tolist = explode(",",$res8[0]['details10']);
					if(!empty($tolist))
					{
						foreach($tolist as $to)
						{
							$this->Base->send_po_mail($to,"Emp_code: $emp_code : $date_time",$body2);
						}
					}
				}//mail
				
			}//emp
		}//emp code
	}//function close
	

	//employee attendance
	
	public function entry_attendance_via_machine($flag,$data_list)
	{
		$today = date('Y-m-d H:i:s');
		$emp_code = $data_list['emp_code'];
		$date_time = $data_list['date_time'];
		$punch_time = strtotime($date_time);
		
		//convert all shift date & time 
		$punch_date = $this->Base->change_date_ymd($date_time);
		$punch_date_next_day = $this->Base->add_no_of_days_in_date_ymd($punch_date,1);// for b shift out
		$punch_date_add_2_early = strtotime($this->Base->sub_no_of_hours_in_date_ymd($date_time,2));//get 2 hours early form punch for detact shift is a or b
		$punch_date_add_2_late = strtotime($this->Base->add_no_of_hours_in_date_ymd($date_time,2));//get 2 hours late form punch for detact shift is a or b
		$general_in_time = $this->Base->change_date_ymd_hisa("$punch_date 09:00:00");
		$general_out_time = $this->Base->change_date_ymd_hisa("$punch_date 19:00:00");//same function in HR->attendance_entry_manual_save_employee_wise
		$shift_a_in_time = $this->Base->change_date_ymd_hisa("$punch_date 08:00:00");
		$shift_a_out_time = $this->Base->change_date_ymd_hisa("$punch_date 16:30:00");
		$shift_a_out_time2 = $this->Base->change_date_ymd_hisa("$punch_date 20:00:00");
		$shift_b_in_time = $this->Base->change_date_ymd_hisa("$punch_date 20:00:00");
		$shift_b_out_time = $this->Base->change_date_ymd_hisa("$punch_date_next_day 04:00:00");
		$shift_b_out_time2 = $this->Base->change_date_ymd_hisa("$punch_date_next_day 08:00:00");
		
		
		//getting shift details
		$query=" SELECT  id,company_role,shift_status,current_shift,get_overtime FROM employee where  emp_code='$emp_code' ";
		$emp = $this->Mymodel->query1($query);
		if(!empty($emp))
		{
			if(!empty($emp[0]['shift_status'])){$shift_status = $emp[0]['shift_status'];}else{$shift_status = 'General';}
			if(!empty($emp[0]['current_shift'])){$current_shift = $emp[0]['current_shift'];}else{$current_shift = 'General';}
			if(!empty($emp[0]['get_overtime'])){$get_overtime = $emp[0]['get_overtime'];}else{$get_overtime = 'No';}
			
			
			if($flag == 'IN')
			{
				//-------------------------------------------------in out time
				if($shift_status == "General")
				{
					$shift = "General";
					$shift_in_time = $general_in_time;
					$shift_out_time = $general_out_time;
					$shift_out_time2 = $general_out_time;
				}//shift
				else
				{
					//checking either shift A or B
					if(strtotime($shift_a_in_time) <= $punch_date_add_2_late and strtotime($shift_a_in_time) >= $punch_date_add_2_early)
					{
						$shift = "A";
						$shift_in_time = $shift_a_in_time;
						$shift_out_time = $shift_a_out_time;
						$shift_out_time2 = $shift_a_out_time2;
					}
					elseif(strtotime($shift_b_in_time) <= $punch_date_add_2_late and strtotime($shift_b_in_time) >= $punch_date_add_2_early)
					{
						$shift = "B";
						$shift_in_time = $shift_b_in_time;
						$shift_out_time = $shift_b_out_time;
						$shift_out_time2 = $shift_b_out_time2;
						
					}
					else
					{
						$shift = "General";
						$shift_in_time = $general_in_time;
						$shift_out_time = $general_out_time;
						$shift_out_time2 = $general_out_time;
					}
				}//shift
				//-------------------------------------------------in out time
				

				//calculating late min 
				$to_time = strtotime($shift_in_time);
				$in_min_late_early = round(abs($to_time - $punch_time) / 60,2);
				if($to_time<=$punch_time){$in_status="L";}else{$in_status="E";}
			
				//save data
				$data = array(
					'entry_date'=>"$today",
					'emp_code'=>"$emp_code",
					'shift'=>"$shift",
					'shift_in_time'=>"$shift_in_time",
					'in_time_mc'=>"$date_time",
					'in_time'=>"$date_time",
					'in_min_late_early'=>"$in_min_late_early",
					'in_status'=>"$in_status",
					'shift_out_time'=>"$shift_out_time",
					'shift_out_time2'=>"$shift_out_time2",
					'get_ot'=>"$get_overtime",
					'save_from'=>"Machine",
				);
				$atten_id = $this->Mymodel->insertdata_withid('daily_attendance',$data); 
				$duty = "P";
				$ot_hours = "0";
				$duty_hours = "0";
			}//flag IN
			else
			{
				//flag == OUT
				//-------------------------------------------------check OT time
				//checking last entry status
				$query=" SELECT * FROM daily_attendance where   emp_code='$emp_code' ORDER BY shift_in_time DESC  LIMIT 1 ";
				$last_entry = $this->Mymodel->query1($query);
				$atten_id = $last_entry[0]['id'];
				$shift_entry = $last_entry[0]['shift'];
				$shift_in_time = $last_entry[0]['shift_in_time'];
				$shift_out_time = $last_entry[0]['shift_out_time'];
				$shift_out_time2 = $last_entry[0]['shift_out_time2'];
				$get_overtime = $last_entry[0]['get_ot'];
				
				//full duty hours
				$to_time = strtotime($shift_in_time);
				$in_min = round(abs($to_time - $punch_time) / 60,2);
				$duty_hours = round(abs($in_min) / 60,1);
				
				//calculating late min 
				$to_time = strtotime($shift_out_time);
				$out_min_late_early = round(abs($to_time - $punch_time) / 60,2);
				if($to_time<=$punch_time)
				{
					//if late check its it will get ot or not
					$out_status="L";
					$duty = "P";
					$full_day_duty = "F";
					if($get_overtime == "Yes" and $out_min_late_early >= 60)
					{
						$ot_hours_point = round(abs($out_min_late_early) / 60,1);
						$ot_hours_nos  = explode('.',$ot_hours_point);
						if($ot_hours_nos[1] == 5)
						{
							$ot_hours = $ot_hours_point;
						}
						else
						{
							$ot_hours = round($ot_hours_point);
						}

						//set max ot 4
						if($shift_entry == 'B')
						{
							if($ot_hours > 4){$ot_hours = 4;}
						}
						elseif($shift_entry == 'A')
						{
							if($ot_hours > 3.5){$ot_hours = 3.5;}
						}
						
						
						
					}
					else
					{
						$ot_hours = 0;
					}
					
				}
				else
				{
					//if early check its half day or not
					$out_status="E";
					if($out_min_late_early >= 240)
					{
						//if out time is more then 4 hours 
						$duty = "A";
						if($shift_entry == "General"){$ot_hours = 4.5;}else{$ot_hours = 6;}
						$full_day_duty = "H";
					}
					else
					{
						$duty = "P";
						$ot_hours = 0;
						$full_day_duty = "F";
					}
				}//if($to_time<=$punch_time)
				//-------------------------------------------------check OT time
				

				//calculating late min 
				$to_time = strtotime($shift_out_time2);
				$out_min_late_early = round(abs($to_time - $punch_time) / 60,2);
				if($to_time<=$punch_time){$out_status="L";}else{$out_status="E";}
				
				
				//check ot is exits for this emp or not
				$ot_hours2 = $ot_hours;
				if($ot_hours2 == 3){  $ot_hours2 = 3.5;}
				if($ot_hours2 == 2){  $ot_hours2 = 2.5;}
				if($get_overtime != 'Yes'){$ot_hours2 = 0;}
				
				
				
				//save data
				$data = array(
					'out_time_mc'=>"$date_time",
					'out_time'=>"$date_time",
					'out_min_late_early'=>"$out_min_late_early",
					'out_status'=>"$out_status",
					'duty_hours'=>"$duty_hours",
					'full_day_duty'=>"$full_day_duty",
					'ot_hours'=>"$ot_hours2",
					'save_from'=>"Machine",
				);
				$where2=array('id'=>"$atten_id");   
				$this->Mymodel->update('daily_attendance',$data,$where2);
				$data_list['date_time'] = $shift_in_time;//in B shift attendance update date is yesterday
			}//flag OUT

		
			
			//data list
			$data_list['emp_id'] = $emp[0]['id'];
			$data_list['company_role'] = $emp[0]['company_role'];
			$data_list['duty'] = $duty;
			$data_list['ot'] = $ot_hours;
			$data_list['duty_hours'] = $duty_hours;
			//update monthly attendance table
			$this->update_in_employee_monthly($data_list);
			
			
		}//if(!empty($emp))
	}//function close
	*/


	public function put_missing_absent()
	{
		// 1️⃣ Company config
		$company = $this->db->select('details2, details3')
			->where('id', 19)
			->get('company_profile')
			->row_array();

		// Safety checks
		if (
			empty($company) ||
			$company['details2'] !== 'Yes' ||
			empty($company['details3'])
		) {
			return;
		}

		// 2️⃣ Dates setup
		$startDate = new DateTime(date('Y-m-d', strtotime($company['details3'])));
		$endDate   = new DateTime(date('Y-m-d')); // TODAY included


		// If nothing to process
		if ($startDate > $endDate) {
			return;
		}

		// 3️⃣ Loop date-wise
		while ($startDate <= $endDate) {

			echo $runDate = $startDate->format('Y-m-d');
			echo "<br>";

			// 👇 actual API / logic call
			$this->yesterday_emp_attend_api();

			// next day
			$startDate->modify('+1 day');
		}
		echo "Done";
	}




	public function yesterday_emp_attend_api()
	{
		$company_id = $this->session->userdata('company_id'); 
		$company = $this->db->select('details2, details3')
							->where('id', 19)
							->get('company_profile')
							->row_array();

		if ($company['details2'] !== "Yes" || $company['details3'] > date('Y-m-d H:i:s')) {
			return; // Exit if not scheduled
		}
		
		$current_saved_date = $company['details3']; //2026-01-04 08:00:00
		$yesterday_time     = strtotime("-1 day", strtotime($current_saved_date));//1767407400
		$yesterday_Days = date('D', $yesterday_time);
		
		$day   = $this->Base->change_date_into_day(date('Y-m-d', $yesterday_time));//3
		$month = (int)$this->Base->change_date_into_month(date('Y-m-d', $yesterday_time));//1
		$year  = $this->Base->change_date_into_year(date('Y-m-d', $yesterday_time));//2026
		$day_col = "d{$day}";//d3

		// Get employees with empty attendance for that day
		$employees = $this->db->select('att_monthly_id, emp_code, restday')
							->where('att_year', $year)
							->where('att_month', $month)
							->where('company_id', $company_id)
							->where("($day_col IS NULL OR $day_col = '')", null, false)
							->get('daily_attendance_monthly')
							->result_array();
		foreach ($employees as $emp) {
			// Check if active
			$is_active = $this->db->select('active')
								->where('id', $emp['emp_code'])
								->where('company_id', $company_id)
								->get('employee')
								->row('active') === 'Active';
			if ($is_active) {
				if ($emp['restday'] === $yesterday_Days) {
					// If rest day, mark as 'R'
					$this->db->set($day_col, 'R')
							->where('att_monthly_id', $emp['att_monthly_id'])
							->update('daily_attendance_monthly');
					
					// Recalculate salary
					$this->Hrmodel->add_total_present_absent_attendance_monthly($emp['att_monthly_id']);
					continue; // Skip to next employee
				}
				$this->db->set($day_col, 'A')
						->where('att_monthly_id', $emp['att_monthly_id'])
						->update('daily_attendance_monthly');

				// Recalculate salary
				$this->Hrmodel->add_total_present_absent_attendance_monthly($emp['att_monthly_id']);
			}
		}

		// Update next run date
		$next_date = date("Y-m-d H:i:s", strtotime("+1 day", strtotime($current_saved_date)));
		$this->db->set('details3', $next_date)
				->where('id', 19)
				->update('company_profile');
	
	}



	
	public function last_shift_auto_out_emp_attend_api()
	{
		$company_id = $this->session->userdata('company_id'); 
		$company = $this->db->query("SELECT details5, details6, details8, details9, details10 
									FROM company_profile 
									WHERE id = 19")
							->row_array();

		if ($company['details5'] !== "Yes" || $company['details6'] > date('Y-m-d H:i:s')) {
			return;
		}

		$current_time = time();
		$today_start = date('Y-m-d 00:00:00');

		$attendances = $this->Mymodel->query1("SELECT * FROM daily_attendance 
			WHERE company_id='$company_id' AND out_time = '0000-00-00 00:00:00' 
			AND shift_in_time < '$today_start'
		");

		$emp_list_for_mail = [];

		foreach ($attendances as $att) {
			$max_stay_time = strtotime("+1 hour", strtotime($att['shift_out_time2']));

			if ($current_time >= $max_stay_time) {
				$duty_hours = round(abs(strtotime($att['shift_in_time']) - strtotime($att['shift_out_time2'])) / 3600, 1);

				// Update attendance
				$this->Mymodel->update('daily_attendance', [
					'out_time'        => $att['shift_out_time2'],
					'out_min_late_early' => "0",
					'out_status'      => "E",
					'duty_hours'      => $duty_hours,
					'full_day_duty'   => "F",
					'ot_hours'        => "0",
					'save_from'       => "Auto"
				], ['id' => $att['id'],'company_id'=>$company_id]);

				// Prepare for email
				$emp = $this->Mymodel->query1("SELECT first_name, last_name FROM employee WHERE company_id ='$company_id' and emp_code = '{$att['emp_code']}'");
				if (!empty($emp)) {
					$emp_name = "{$emp[0]['first_name']} {$emp[0]['last_name']}";
					$emp_list_for_mail[] = "{$att['emp_code']} ($emp_name) In Time: " .
						$this->Base->change_date_dmy_hisa($att['shift_in_time']) .
						" Out Time: " .
						$this->Base->change_date_dmy_hisa($att['shift_out_time2']) . "<br><br>";
				}
			}
		}

		// Send email if required
		if (!empty($emp_list_for_mail) && $company['details9'] === "Yes") {
			$body = "These Employees didn't OUT punch into the machine:<br><br>" .
					implode(",", $emp_list_for_mail) .
					"<br><br>System auto-outed these employees at their shift time.<br><br>
					OT is not added, please update manually.<br><br>
					Thank You.<br><br>
					<span style='color:red;'>This is a system-generated email. No need to reply.</span>";

			foreach (explode(",", $company['details10']) as $to) {
				if (trim($to)) {
					$this->Base->send_mail($to, "Attendance Punch Missing", $body);
				}
			}
		}

		// Update next execution time
		$next_date = date("Y-m-d H:i:s", strtotime("+12 hours", strtotime($company['details6'])));
		$this->db->query("UPDATE company_profile SET details6 = '$next_date' WHERE id = 19");
	}

	public function isValidDateTime($datetime, $format = 'Y-m-d H:i:s') {
		$dt = DateTime::createFromFormat($format, $datetime);
		return $dt && $dt->format($format) === $datetime;
	}

	public function convertDDMMYYYYtoYMD($date)
	{
		$dt = DateTime::createFromFormat('Y-m-d', $date);

		// strict check (no auto-fix)
		if (!$dt || $dt->format('Y-m-d') !== $date) {
			return false;
		}

		return $dt->format('Y-m-d');
	}

	function isValidTime($time)
	{
		$dt = DateTime::createFromFormat('H:i', $time);
		return $dt && $dt->format('H:i') === $time;
	}
	
	public function emp_attend_api2()
	{
		$json = file_get_contents("php://input");
		$data = json_decode($json, true);
		$company_id = $this->session->userdata('company_id');

		if (empty($data['bio_code']) || empty($data['attendanceDate']) || empty($data['status'])) {
			$this->apiResponse('error', 'Invalid payload');
			return;
		}
		
		if($data['dutyMin'] == '')$data['dutyMin']=0;
		if (!is_numeric($data['dutyMin'])) {
			$this->apiResponse('error', 'Min must be a number');
			return;
		}

		
		$emp = $this->db->query(
			"SELECT id, emp_code, company_role, get_overtime, restday, working_hr,late_punch_add
			FROM employee
			WHERE bio_code=? AND company_id= ? AND active='Active'
			LIMIT 1",
			[trim($data['bio_code']),$company_id]
		)->row_array();

		if (!$emp) {
			$this->apiResponse('error', 'Employee not found');
			return;
		}

		//check attendance lock or not
		$lock = $this->Base->atten_lock_check($data['attendanceDate'],$emp['id']);
		if($lock) {
			$this->apiResponse('error', 'Attendance for this month and year is locked and cannot be modified.');
			return;
		}

		$att_date_raw = $data['attendanceDate'] ?? '';
		$att_date = $this->convertDDMMYYYYtoYMD($att_date_raw);
		if ($att_date === false) {
			$this->apiResponse(
				'error',
				'Invalid attendance date format. Required: DD-MM-YYYY'
			);
			return;
		}

		//$att_date = $data['attendanceDate'];
		//$in_dt  = !empty($data['in_time'])  ? "$att_date {$data['in_time']}"  : null;
		//$out_dt = !empty($data['out_time']) ? "$att_date {$data['out_time']}" : null;
		

		$in_dt  = null;
		$out_dt = null;

		if (!empty($data['in_time'])) {

			if (!$this->isValidTime($data['in_time'])) {
				$this->apiResponse(
					'error',
					'Invalid IN time format. Required: HH:MM:SS'
				);
				return;
			}

			$in_dt = $att_date . ' ' . $data['in_time'];
		}

		if (!empty($data['out_time'])) {

			if (!$this->isValidTime($data['out_time'])) {
				$this->apiResponse(
					'error',
					'Invalid OUT time format. Required: HH:MM:SS'
				);
				return;
			}

			$out_dt = $att_date . ' ' . $data['out_time'];
		}
		
		$att_monthly_id = $this->Base->processAttendanceCore([
			'emp_id'       => $emp['id'],
			'emp_code'     => $emp['emp_code'],
			'bio_code'     => $data['bio_code'],
			'company_role' => $emp['company_role'],
			'status'       => strtoupper(trim($data['status'])),
			'att_date'     => $att_date,
			'in_dt'        => $in_dt,
			'out_dt'       => $out_dt,
			'dutyMin'       => $data['dutyMin'] ?? 0,
			'get_ot'       => $emp['get_overtime'],
			'restday'      => $emp['restday'],
			'working_hr'   => $emp['working_hr'],
			'source'       => $data['company'] ?? 'API2',
			'location'     => $data['company'] ?? 'API2',
			'late_punch_add' =>  $emp['late_punch_add'] ?? 'No',
			'save_by'      => 'API2'
		]);

		if ($att_monthly_id) {
			$this->Hrmodel->add_total_present_absent_attendance_monthly($att_monthly_id);
		}

		$this->apiResponse('success', 'Attendance saved');
	}


	public function emp_attend_api2_old()
	{
		$json = file_get_contents("php://input");
		$data = json_decode($json, true);
		$company_id = $this->session->userdata('company_id'); 

		/* ================= BASIC VALIDATION ================= */

		if (
			empty($data['bio_code']) ||
			empty($data['attendanceDate']) ||
			empty($data['status'])
		) {
			$this->apiResponse('error', 'Invalid payload');
			return;
		}

		/* ================= GET EMPLOYEE ================= */

		$bio_code = trim($data['bio_code']);

		$emp = $this->db->query(
			"SELECT id, emp_code, company_role, get_overtime, restday, current_shift
			FROM employee
			WHERE bio_code=? AND active='Active'
			LIMIT 1",
			[$bio_code]
		)->row_array();

		if (empty($emp)) {
			$this->apiResponse('error', 'Employee not found');
			return;
		}

		$emp_id        = $emp['id'];
		$emp_code      = $emp['emp_code'];
		$company_role  = $emp['company_role'];
		$get_overtime  = $emp['get_overtime'];
		$restday       = $emp['restday'];
		$current_shift = $emp['current_shift'];

		/* ================= PAYLOAD ================= */

		$att_date = $data['attendanceDate']; // Y-m-d
		$in_time  = $data['in_time']  ?? null;
		$out_time = $data['out_time'] ?? null;
		$status   = strtoupper(trim($data['status']));
		$company  = trim($data['company'] ?? 'UNKNOWN');

		$day_name = date('D', strtotime($att_date));

		/* ================= SHIFT CALC ================= */

		$shift = $this->calculateShiftForApi2(
			$emp_code,
			$in_time ? strtotime("$att_date $in_time") : strtotime("$att_date 10:00:00")
		);

		/* ================= SHIFT TIMINGS ================= */

		$punch_date = $att_date;
		$next_day   = date('Y-m-d', strtotime("$punch_date +1 day"));

		$shifts = [
			'A' => ['in'=>"$punch_date 08:00:00",'out'=>"$punch_date 16:30:00",'out2'=>"$punch_date 20:00:00"],
			'B' => ['in'=>"$punch_date 20:00:00",'out'=>"$next_day 04:00:00",'out2'=>"$next_day 08:00:00"],
			'C' => ['in'=>"$punch_date 09:00:00",'out'=>"$punch_date 19:00:00",'out2'=>"$punch_date 19:00:00"],
			'General' => ['in'=>"$punch_date 10:00:00",'out'=>"$punch_date 19:00:00",'out2'=>"$punch_date 19:00:00"],
		];

		/* ================= DEFAULT VALUES ================= */

		$duty          = 'P';
		$full_day_duty = 'F';
		$ot_hours      = 0;
		$duty_hours    = 0;

		/* ================= STATUS LOGIC ================= */

		if ($status === 'P' && $in_time && $out_time) {

			$in_ts  = strtotime("$att_date $in_time");
			$out_ts = strtotime("$att_date $out_time");

			if ($out_ts > $in_ts) {

				// Duty hours = actual worked hours
				$duty_hours = round(($out_ts - $in_ts) / 3600, 1);

				// OT + duty decision → SAME AS OLD API
				[$duty, $full_day_duty, $ot_hours] =
					$this->calculateOT(
						$out_ts,
						$shift,
						strtotime($shifts[$shift]['out']),
						strtotime($shifts[$shift]['out2']),
						$get_overtime,
						$restday,
						$in_ts
					);

				// ❗ FINAL SAFETY
				if ($get_overtime !== 'Yes') {
					$ot_hours = 0;
				}
			}
		}
		elseif ($status === 'A') {

			if ($restday === $day_name) {
				$duty = 'R';
				$full_day_duty = 'R';
			} else {
				$duty = 'A';
				$full_day_duty = 'A';
			}

		} elseif ($status === 'WO') {

			$duty = 'R';
			$full_day_duty = 'R';

		}  
		elseif ($status === 'WOP' && $in_time && $out_time) 
		{

			$duty          = 'R';
			$full_day_duty = 'R';

			$in_ts  = strtotime("$att_date $in_time");
			$out_ts = strtotime("$att_date $out_time");

			if ($out_ts > $in_ts) {

				$worked_hours = round(($out_ts - $in_ts) / 3600, 1);
				$ot_hours   = $worked_hours;
				$duty_hours = $worked_hours;
			}
		}
		elseif (in_array($status, ['HALF','½P'])) {

			$duty = 'HA';
			$full_day_duty = 'H';
			$ot_hours = 0;
		}

		/* ================= DAILY ATTENDANCE UPSERT ================= */

		$existing = $this->db->query(
			"SELECT id FROM daily_attendance
			WHERE emp_code=? AND DATE(shift_in_time)=? AND company_id = ?
			LIMIT 1",
			[$emp_code, $att_date, $company_id]
		)->row_array();

		$save = [
			'entry_date'        => date('Y-m-d H:i:s'),
			'company_id'          => $company_id,
			'emp_code'          => $emp_code,
			'shift'             => $shift,
			'shift_in_time'     => $shifts[$shift]['in'],
			'shift_out_time'    => $shifts[$shift]['out'],
			'shift_out_time2'   => $shifts[$shift]['out2'],
			'get_ot'            => $get_overtime,
			'duty_hours'        => $duty_hours,
			'full_day_duty'     => $full_day_duty,
			'ot_hours'          => $ot_hours,
			'location'          => $company,
			'machine_id'        => 'API2',
			'save_from'         => 'API2'
		];

		if ($in_time) {
			$save['in_time']    = "$att_date $in_time";
			$save['in_time_mc'] = "$att_date $in_time";
			$save['in_status'] = 'L';
			$save['in_min_late_early'] = 0;
		}

		if ($out_time) {
			$save['out_time']    = "$att_date $out_time";
			$save['out_time_mc'] = "$att_date $out_time";
			$save['out_status'] = 'E';
			$save['out_min_late_early'] = 0;
		}

		if ($existing) {
			$save['update_by']   = 'API2';
			$save['update_date']= date('Y-m-d H:i:s');

			$this->db->where('id', $existing['id'])
					->update('daily_attendance', $save);
		} else {
			$save['save_by']   = 'API2';
			$save['save_date']= date('Y-m-d H:i:s');

			$this->db->insert('daily_attendance', $save);
		}

		/* ================= MONTHLY ATTENDANCE UPDATE ================= */
		$day   = date('j', strtotime($att_date));   // 1–31
		$month = date('n', strtotime($att_date));
		$year  = date('Y', strtotime($att_date));

		$day_col = "d".$day;
		$ot_col  = "o".$day;

		$total_day_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$total_sunday = count($this->Base->getSundays2($year, $month));

		/* --- REST DAY OVERRIDE (manual R already marked) --- */
		$monthly = $this->db->query(
			"SELECT att_monthly_id
			FROM daily_attendance_monthly
			WHERE emp_code=? AND att_year=? AND att_month=? AND company_id=?
			LIMIT 1",
			[$emp_id, $year, $month, $company_id]
		)->row_array();

		if (!empty($monthly)) {
			$this->db->where('att_monthly_id', $monthly['att_monthly_id'])
				->update('daily_attendance_monthly', [
					$day_col => $duty,
					$ot_col  => $ot_hours,
					'total_day_in_month' => $total_day_in_month,
					'total_sunday' => $total_sunday,
					'update_by' => 'API2',
					'update_date' => date('Y-m-d H:i:s')
				]);

			$att_monthly_id = $monthly['att_monthly_id'];

		} else {

			$insert = [
				'emp_code' => $emp_id,
				'company_id' => $company_id,
				'company_role_id' => $company_role,
				'att_year' => $year,
				'att_month' => $month,
				$day_col => $duty,
				$ot_col  => $ot_hours,
				'total_day_in_month' => $total_day_in_month,
				'total_sunday' => $total_sunday,
				'save_by' => 'API2',
				'save_date' => date('Y-m-d H:i:s')
			];

			$att_monthly_id = $this->Mymodel->insertdata_withid('daily_attendance_monthly', $insert);
		}

		/* ================= FINAL TOTAL RECALC ================= */

		if (!empty($att_monthly_id)) {
			$this->Hrmodel
				->add_total_present_absent_attendance_monthly($att_monthly_id);
		}


		$this->apiResponse('success', 'Attendance saved');
	}


	/* =========================================================
	SHIFT CALCULATION FOR API2 (REUSES OLD LOGIC)
	========================================================= */

	private function calculateShiftForApi2($emp_code, $in_datetime)
	{
		if (!$in_datetime) return 'General';
		$company_id = $this->session->userdata('company_id'); 

		$punch_time = $in_datetime;
		$punch_date = date('Y-m-d', $in_datetime);
		$next_day   = date('Y-m-d', strtotime($punch_date.' +1 day'));

		$emp = $this->Mymodel->query1(
			"SELECT shift_status, current_shift FROM employee WHERE company_id='$company_id' and emp_code='$emp_code'"
		);
		if (empty($emp)) return 'General';

		$shift_status  = $emp[0]['shift_status'] ?: 'General';
		$current_shift = $emp[0]['current_shift'];

		$shifts = [
			'A' => ['in'=>"$punch_date 08:00:00",'out'=>"$punch_date 16:30:00",'out2'=>"$punch_date 20:00:00"],
			'B' => ['in'=>"$punch_date 20:00:00",'out'=>"$next_day 04:00:00",'out2'=>"$next_day 08:00:00"],
			'C' => ['in'=>"$punch_date 09:00:00",'out'=>"$punch_date 19:00:00",'out2'=>"$punch_date 19:00:00"],
			'General' => ['in'=>"$punch_date 10:00:00",'out'=>"$punch_date 19:00:00",'out2'=>"$punch_date 19:00:00"],
		];

		return $this->detectShift(
			$shift_status,
			$punch_time,
			$shifts,
			date('Y-m-d H:i:s', $punch_time),
			$current_shift
		);
	}


	/* =========================================================
	OT + DUTY CALCULATION FOR API2 (REUSES OLD LOGIC)
	========================================================= */
	private function calculateOTForApi2($emp_code, $shift, $in_datetime, $out_datetime)
	{
		$company_id = $this->session->userdata('company_id'); 
		$duty = 'P';
		$full_day = 'F';
		$ot_hours = 0;
		$duty_hours = round(($out_datetime - $in_datetime) / 3600, 1);

		$emp = $this->Mymodel->query1(
			"SELECT get_overtime, restday FROM employee WHERE company_id='$company_id' and emp_code='$emp_code'"
		);
		if (!$emp) {
			return [$duty, $full_day, 0, $duty_hours];
		}

		$get_overtime = $emp[0]['get_overtime'];
		$restday      = $emp[0]['restday'];

		$shift_out  = strtotime(date('Y-m-d', $in_datetime).' 19:00:00');
		$shift_out2 = $shift_out;

		if ($shift === 'A') {
			$shift_out  = strtotime(date('Y-m-d', $in_datetime).' 16:30:00');
			$shift_out2 = strtotime(date('Y-m-d', $in_datetime).' 20:00:00');
		}

		if ($shift === 'B') {
			$shift_out  = strtotime(date('Y-m-d', $in_datetime).' 04:00:00 +1 day');
			$shift_out2 = strtotime(date('Y-m-d', $in_datetime).' 08:00:00 +1 day');
		}

		[$duty, $full_day, $ot_hours] =
			$this->calculateOT(
				$out_datetime,
				$shift,
				$shift_out,
				$shift_out2,
				$get_overtime,
				$restday,
				$in_datetime
			);

		return [$duty, $full_day, $ot_hours, $duty_hours];
	}





	private function apiResponse($status, $message, $data = [])
	{
		header('Content-Type: application/json');
		echo json_encode([
			'status'  => $status,
			'message' => $message,
			'data'    => $data
		]);
		exit;
	}

	public function emp_attend_api()
	{
		$this->yesterday_emp_attend_api();
		$company_id = $this->session->userdata('company_id'); 
	

		/* ================= EMP CODE RESOLUTION ================= */

		$emp_code = null;

		// 1️⃣ bio_code
		if (!empty($_REQUEST['bio_code'])) {

			$bio_code = trim($_REQUEST['bio_code']);

			$query = "SELECT emp_code 
					FROM employee 
					WHERE bio_code = ?  AND company_id = ?
					AND active = 'Active' 
					LIMIT 1";

			$row = $this->db->query($query, [$bio_code,$company_id])->row_array();

			if (!empty($row['emp_code'])) {
				$emp_code = $row['emp_code'];
			}
		}

		// 2️⃣ fallback emp_code
		if (empty($emp_code) && !empty($_REQUEST['emp_code'])) {
			$emp_code = trim($_REQUEST['emp_code']);
		}

		// 3️⃣ final validation
		if (empty($emp_code)) {
			$this->apiResponse('error', 'Employee code not found');
		}

		if (!$this->isEmployeeExists($emp_code)) {
			$this->apiResponse('error', 'Employee does not exist', [
				'emp_code' => $emp_code
			]);
		}

		/* ================= DATE VALIDATION ================= */

		$raw_date = $_REQUEST['date_time'] ?? '';

		if (empty($raw_date)) {
			$this->apiResponse(
				'error',
				'date_time is required. Attendance not marked.'
			);
		}

		$raw_date = trim($raw_date);

		$formats = ['Y-m-d H:i:s', 'Y-m-d H:i'];
		$dateObj = null;

		foreach ($formats as $format) {
			$d = DateTime::createFromFormat($format, $raw_date);
			if ($d && $d->format($format) === $raw_date) {
				$dateObj = $d;
				break;
			}
		}

		if (!$dateObj) {
			$this->apiResponse(
				'error',
				'Invalid date_time format. Allowed: Y-m-d H:i or Y-m-d H:i:s',
				['received' => $raw_date]
			);
		}

		// Normalize
		$date_time = $dateObj->format('Y-m-d H:i:s');

		/* ================= TIME SAFETY RULES ================= */

		$now = new DateTime();

		// ❌ Future punches blocked
		if ($dateObj > $now) {
			$this->apiResponse(
				'error',
				'Future date_time not allowed',
				['received' => $date_time]
			);
		}

		// // ❌ Back-date limit (2 days example)
		// $diffDays = $now->diff($dateObj)->days;

		// if ($dateObj < $now && $diffDays > 2) {
		//     $this->apiResponse(
		//         'error',
		//         'Back date beyond allowed limit',
		//         ['received' => $date_time]
		//     );
		// }

		/* ================= ATTENDANCE PROCESS ================= */

		$last_entry = $this->getLastAttendanceEntry($emp_code);

		// First ever punch → IN
		if (empty($last_entry)) {

			$this->entry_attendance_via_machine(
				'IN',
				compact('emp_code', 'date_time')
			);

			$this->apiResponse('success', 'IN punch marked', [
				'emp_code'  => $emp_code,
				'date_time' => $date_time,
				'punch'     => 'IN'
			]);
		}

		// Subsequent punch
		$status = $this->processAttendancePunch(
			$last_entry,
			$date_time,
			$emp_code
		);

		$this->apiResponse('success', 'Punch processed', [
			'emp_code'  => $emp_code,
			'date_time' => $date_time,
			'result'    => $status
		]);
	}

	
	//latest code before above 19-12-25 
	// public function emp_attend_api()
	// {
	// 	$this->yesterday_emp_attend_api(); // Mark yesterday's absentees
	// 	////$this->last_shift_auto_out_emp_attend_api(); // Auto out for last shift

	// 	$emp_code = null;

	// 	// 1️⃣ bio_code present hai?
	// 	if (!empty($_REQUEST['bio_code'])) {
	// 		$bio_code = $_REQUEST['bio_code'];
	// 		$query = " SELECT emp_code FROM employee WHERE bio_code = '$bio_code' AND active = 'Active' LIMIT 1";
	// 		$result = $this->db->query($query, [$bio_code])->row_array();
	// 		if (!empty($result['emp_code'])) {
	// 			$emp_code = $result['emp_code'];
	// 		}
	// 	}

	// 	// 2️⃣ agar bio_code se emp_code nahi mila
	// 	if (empty($emp_code) && !empty($_REQUEST['emp_code'])) {
	// 		$emp_code = $_REQUEST['emp_code'];
	// 	}

	// 	// 3️⃣ final validation
	// 	if (empty($emp_code)) {
	// 		return; // nothing to process
	// 	}
		

	// 	//if (empty($_REQUEST['emp_code'])) return;
	// 	//$emp_code  = $_REQUEST['emp_code'];
	// 	$date_time = isset($_REQUEST['date_time'])
	// 		? $this->Base->change_date_ymd_hisa($_REQUEST['date_time'])
	// 		: date('Y-m-d H:i:s');
		
	// 	if (!$this->isEmployeeExists($emp_code)) {
	// 		$this->notifyHRForMissingEmployee($emp_code, $date_time);
	// 		return;
	// 	}
		
	// 	$last_entry = $this->getLastAttendanceEntry($emp_code);
	// 	if (empty($last_entry)) {
	// 		$this->entry_attendance_via_machine('IN', compact('emp_code', 'date_time'));
	// 		return;
	// 	}

	// 	$this->processAttendancePunch($last_entry, $date_time, $emp_code);
	// }

	private function isEmployeeExists($emp_code)
	{
		$company_id = $this->session->userdata('company_id'); 
		$query = "SELECT id FROM employee WHERE emp_code='$emp_code' and company_id='$company_id' and active='Active' ";
		return !empty($this->Mymodel->query1($query));
	}

	private function getLastAttendanceEntry($emp_code)
	{
		$company_id = $this->session->userdata('company_id'); 
		$query = "SELECT * FROM daily_attendance 
				WHERE emp_code='$emp_code' and company_id='$company_id'
				ORDER BY shift_in_time DESC LIMIT 1";
		return $this->Mymodel->query1($query);
	}

	private function notifyHRForMissingEmployee($emp_code, $date_time)
	{
		$company_id = $this->session->userdata('company_id'); 
		$body = "New attendance punch by $emp_code at $date_time. 
				But this employee is not created in ERP.<br>
				Please create this employee in ERP.<br><br>
				Thank You.<br>
				<span style='color:red;'>This is a system generated email. No need to reply.</span>";

		$sql = "SELECT details9, details10 FROM company_profile WHERE id=19";
		$res = $this->db->query($sql)->row_array();

		if ($res['details9'] === "Yes" && !empty($res['details10'])) {
			foreach (explode(",", $res['details10']) as $to) {
				$this->Base->send_po_mail($to, "Emp_code: $emp_code : $date_time", $body);
			}
		}
	}

	private function processAttendancePunch($last_entry, $date_time, $emp_code)
	{
		$data_list = compact('emp_code', 'date_time');
		
		if ($last_entry[0]['out_time'] == '0000-00-00 00:00:00') {
			if ($this->isNewInPunch($last_entry[0]['in_time'], $date_time)) {
				if ($this->isNextDayPunch($last_entry[0]['shift_out_time2'], $date_time)) {
					$this->entry_attendance_via_machine('IN', $data_list);
				} else {
					$this->entry_attendance_via_machine('OUT', $data_list);
				}
			}
		} else {
			if ($this->isDifferentDayPunch($last_entry[0]['shift_in_time'], $date_time) &&
				$this->isAfter30Min($last_entry[0]['out_time'], $date_time)) {
				$this->entry_attendance_via_machine('IN', $data_list);
			}
		}
		
	}

	private function isNewInPunch($in_time, $current_time)
	{
		return $current_time > date("Y-m-d H:i:s", strtotime("$in_time +30 minutes"));
	}

	private function isNextDayPunch($shift_out_time, $current_time)
	{
		return $current_time >= date("Y-m-d H:i:s", strtotime("$shift_out_time +7 hours"));
	}

	private function isDifferentDayPunch($last_in_time, $current_time)
	{
		return date('Y-m-d', strtotime($last_in_time)) !== date('Y-m-d', strtotime($current_time));
	}

	private function isAfter30Min($out_time, $current_time)
	{
		return $current_time > date("Y-m-d H:i:s", strtotime("$out_time +30 minutes"));
	}


	






	
	public function entry_attendance_via_machine($flag, $data_list)
	{
		$company_id = $this->session->userdata('company_id'); 
		$today      = date('Y-m-d H:i:s');
		$emp_code   = $data_list['emp_code'];
		$date_time  = $data_list['date_time'];
		$punch_time = strtotime($date_time);
		$punch_date = $this->Base->change_date_ymd($date_time);
		$next_day   = $this->Base->add_no_of_days_in_date_ymd($punch_date, 1);

		// Get employee shift details
		$emp = $this->Mymodel->query1("SELECT id, company_role, shift_status, current_shift, get_overtime,restday FROM employee WHERE company_id='$company_id' AND emp_code='$emp_code'");
		if (empty($emp)) return;

		$shift_status  = $emp[0]['shift_status'] ?: 'General';
		$get_overtime  = $emp[0]['get_overtime'] ?: 'No';
		$restday= $emp[0]['restday'];
		$current_shift= $emp[0]['current_shift'];
		
		// All shifts in one array
		$shifts = [
			
			'A'       => ['in' => "$punch_date 08:00:00", 'out' => "$punch_date 16:30:00", 'out2' => "$punch_date 20:00:00"],
			'B'       => ['in' => "$punch_date 20:00:00", 'out' => "$next_day 04:00:00", 'out2' => "$next_day 08:00:00"],
			'C'       => ['in' => "$punch_date 09:00:00", 'out' => "$punch_date 19:00:00", 'out2' => "$punch_date 19:00:00"],
			'General' => ['in' => "$punch_date 10:00:00", 'out' => "$punch_date 19:00:00", 'out2' => "$punch_date 19:00:00"],
		];

		

		if ($flag == 'IN') {
			// Determine shift
			$shift = $this->detectShift($shift_status, $punch_time, $shifts, $date_time, $current_shift);
			
			// Late/Early calculation
			$in_diff = round(abs(strtotime($shifts[$shift]['in']) - $punch_time) / 60, 2);
			$in_status = (strtotime($shifts[$shift]['in']) <= $punch_time) ? "L" : "E";

			// Save IN record
			$this->Mymodel->insertdata_withid('daily_attendance', [
				'entry_date'      => $today,
				'emp_code'        => $emp_code,
				'company_id'        => $company_id,
				'shift'           => $shift,
				'shift_in_time'   => $shifts[$shift]['in'],
				'in_time_mc'      => $date_time,
				'in_time'         => $date_time,
				'in_min_late_early' => $in_diff,
				'in_status'       => $in_status,
				'shift_out_time'  => $shifts[$shift]['out'],
				'shift_out_time2' => $shifts[$shift]['out2'],
				'get_ot'          => $get_overtime,
				'save_from'       => "Machine"
			]);

			$duty = "P";
			$ot_hours = $duty_hours = 0;
		} 
		else { // OUT punch
			$last_entry = $this->Mymodel->query1("SELECT * FROM daily_attendance WHERE company_id='$company_id' AND emp_code='$emp_code' ORDER BY shift_in_time DESC LIMIT 1");
			if (empty($last_entry)) return;

			$atten_id    = $last_entry[0]['id'];
			$shift       = $last_entry[0]['shift'];
			$shift_in    = strtotime($last_entry[0]['shift_in_time']);
			$shift_out   = strtotime($last_entry[0]['shift_out_time']);
			$shift_out2  = strtotime($last_entry[0]['shift_out_time2']);
			$get_overtime= $last_entry[0]['get_ot'];
			

			// Duty hours
			$duty_hours = round(abs($punch_time - $shift_in) / 3600, 1);

			// OT calculation
			[$duty, $full_day_duty, $ot_hours] = $this->calculateOT($punch_time, $shift, $shift_out, $shift_out2, $get_overtime, $restday,$shift_in);
			
			// Final OT adjustments
			if ($ot_hours == 3) $ot_hours = 3.5;
			if ($ot_hours == 2) $ot_hours = 2.5;
			if ($get_overtime != 'Yes') $ot_hours = 0;

			// Save OUT record
			$this->Mymodel->update('daily_attendance', [
				'out_time_mc'       => $date_time,
				'out_time'          => $date_time,
				'out_min_late_early'=> round(abs($shift_out2 - $punch_time) / 60, 2),
				'out_status'        => ($shift_out2 <= $punch_time) ? "L" : "E",
				'duty_hours'        => $duty_hours,
				'full_day_duty'     => $full_day_duty,
				'ot_hours'          => $ot_hours,
				'save_from'         => "Machine"
			], ['id' => $atten_id]);

			$data_list['date_time'] = $last_entry[0]['shift_in_time'];
		}

		// Update monthly table
		$data_list['emp_id']      = $emp[0]['id'];
		$data_list['company_role']= $emp[0]['company_role'];
		$data_list['duty']        = $duty;
		$data_list['ot']          = $ot_hours;
		$data_list['duty_hours']  = $duty_hours;
		$data_list['current_shift']  = $shift;
		$this->update_in_employee_monthly($data_list);
	}

	// Detect shift logic
	private function detectShift($shift_status, $punch_time, $shifts, $date_time, $current_shift)
	{
		//if ($shift_status == "General") return "General";
		if (in_array($current_shift, ['General','C'])) return $current_shift;

		foreach (['A', 'B'] as $s) {
			$in_time = strtotime($shifts[$s]['in']);
			if ($punch_time >= strtotime("-2 hours", $in_time) && $punch_time <= strtotime("+2 hours", $in_time)) {
				return $s;
			}
		}
		return "General";
	}

	// OT calculation logic
	private function calculateOT($punch_time, $shift, $shift_out, $shift_out2, $get_overtime, $restday,$shift_in)
	{
		$duty = "P";
		$full_day_duty = "F";
		$ot_hours = 0;
		$Day_name = date('D', $punch_time);
		
		if ($restday == $Day_name) {
			$duty = "R";
			$full_day_duty = "R";
			// Full OT on rest day
			$ot_hours_point = round(($punch_time - $shift_in) / 3600, 1);
			$ot_hours = (fmod($ot_hours_point, 1) == 0.5) ? $ot_hours_point : round($ot_hours_point);
			return [$duty, $full_day_duty, $ot_hours];
		}

		if ($punch_time >= $shift_out) { // Stayed late
			if ($get_overtime == "Yes") {
				$ot_hours_point = round(($punch_time - $shift_out) / 3600, 1);
				$ot_hours = (fmod($ot_hours_point, 1) == 0.5) ? $ot_hours_point : round($ot_hours_point);

				// Max OT limits
				if ($shift == 'B' && $ot_hours > 4) $ot_hours = 4;
				if ($shift == 'A' && $ot_hours > 4) $ot_hours = 4;
			}
		} else { // Left early
			if ((($shift_out - $punch_time) / 60) >= 120) { // Early by >= 4 hrs
				//old code in half day put A and give OT
				// $duty = "A";
				// $ot_hours = ($shift == "General") ? 4.5 : 6;
				// $full_day_duty = "H";
				//new code put HA(half day) no OT
				$duty = "HA";
				$ot_hours = 0;
				$full_day_duty = "H";
			}
		}
		return [$duty, $full_day_duty, $ot_hours];
	}





	




	//employee attendance monthly
	public function update_in_employee_monthly($data_list)
	{
		$company_id = $this->session->userdata('company_id'); 
		$today = date('Y-m-d H:i:s');
		$emp_code = $data_list['emp_code'];
		$date_time = $data_list['date_time'];
		$emp_id = $data_list['emp_id'];
		$company_role_id = $data_list['company_role'];
		$date = $this->Base->change_date_into_day($date_time);
		$month = $this->Base->change_date_into_month($date_time);
		$year = $this->Base->change_date_into_year($date_time);
		$day_1 = $data_list['duty'];
		$ot_1 = $data_list['ot'];
		$duty_hours = $data_list['duty_hours'];
		$current_shift = $data_list['current_shift'];
		
		//creating column name
		$day_colomn = "d$date";
		$ot_column = "o$date";

		
		//--------checking no of days in this month
		$total_day_in_month=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		//---------------Getting no of sunday
		$no_of_sunday_array = $this->Base->getSundays2($year, $month);
		$total_sunday=count($no_of_sunday_array);
		$total_holiday=0;
		$company_off=($total_sunday+$total_holiday);
		$company_on=$total_day_in_month-$company_off;
		
		//update shift
		$data=array('current_shift'=>"$current_shift" );
		$where=array('id'=>"$emp_id",'company_id'=>"$company_id");   
		$this->Mymodel->update('employee',$data,$where);
		
		
		//attndance
		$out=$this->Hrmodel->get_atten_table_id($emp_id,$year,$month);
		if(!empty($out) and $out[0]['att_monthly_id']>0)
		{
			//update
			//check entry is manual done or not like Sunday/ Rest
			$sql = "SELECT $day_colomn as day FROM daily_attendance_monthly where company_id='$company_id' AND emp_code='$emp_id'  and att_year='$year' and att_month='$month'    ";
			$query = $this->db->query($sql);
			$res9 = $query->result_array();
			if(!empty($res9))
			{
				if($res9[0]['day']=='R'){
					$day_1 = $res9[0]['day'];
					$ot_1 = $duty_hours;
				}
				/*
				else{
					$day_1 = 'P';
					$ot_1 = '';
				}
					*/
			}


			
			
			$att_monthly_id=$out[0]['att_monthly_id'];
			$data=array(
						"$day_colomn"=>"$day_1",
						"$ot_column"=>"$ot_1",
						'total_day_in_month'=>"$total_day_in_month",
						'total_sunday'=>"$total_sunday",
						'update_by'=>"Machine",
						'update_date'=>"$today",
					  );
			$where=array('att_monthly_id'=>"$att_monthly_id");   
			$this->Mymodel->update('daily_attendance_monthly',$data,$where);
		}
		else
		{
			//new
			$data=array(
						'company_id'=>"$company_id",
						'emp_code'=>"$emp_id",
						'company_role_id'=>"$company_role_id",
						'att_year'=>"$year",
						'att_month'=>"$month",
						"$day_colomn"=>"$day_1",
						"$ot_column"=>"$ot_1",
						'total_day_in_month'=>"$total_day_in_month",
						'total_sunday'=>"$total_sunday",
						'save_by'=>"Machine",
						'save_date'=>"$today"
					  );
					//'total_day_in_month'=>"$total_day_in_month",
					//'total_sunday'=>"$total_sunday",
			$att_monthly_id = $this->Mymodel->insertdata_withid('daily_attendance_monthly',$data);
		}//att_monthly_id

		if(!empty($att_monthly_id))
		{
			//update total present and total absent and total sunday
			$this->Hrmodel->add_total_present_absent_attendance_monthly($att_monthly_id);
		}//$att_monthly_id

		

	}//function close













	/*
	public function emp_id_code()
	{
		$sql = "SELECT att_monthly_id,emp_code FROM daily_attendance_monthly   GROUP BY emp_code ";
        $query = $this->db->query($sql);
        $res =  $query->result_array();
		foreach($res as $r)
		{
			$att_monthly_id = $r['att_monthly_id'];
			$id = $r['emp_code'];
			$sql2 = "SELECT emp_code FROM employee WHERE id='$id'   ";
			$query2 = $this->db->query($sql2);
        	$res2 =  $query2->result_array();
			$emp_code2 = $res2[0]['emp_code'];
			
			
			$data2=array('emp_code'=>"$emp_code2");
			$where2=array('att_monthly_id'=>"$att_monthly_id"); 
			$this->Mymodel->update('daily_attendance_monthly',$data2,$where2);

		}

		echo "done";
	}
	*/



	//upload emp punch data from machine to server via pan drive or export
	public function import_attendance_form_machine()
	{
		/*Step
			1. download all attacndance log file from machine to pan drive
			2. clear all log data in machine
			3. Open file in pandrive and delete all pervious data
			4. Copy all new log data from pan drive and save into excel.csv file
			5. Only 3 coloumn in excel.csv file id,col1(Emp_code),col2(date_time)
			6. Import this csv file into temp_emp_att_upload table into data base
			7. Run import_attendance_form_machine function in new tab

			8. run on localhot URL to check
			9. run server URL / export table form local and import to main sever
		*/
		
		$sql = "SELECT * FROM temp_emp_att_upload WHERE flag =0    ";
        $query = $this->db->query($sql);
        $res =  $query->result_array();
		foreach($res as $r)
		{
			$id = $r['id'];
		 	$emp_code = $r['emp_code'];
			$date_time = urlencode($r['date_time']);
		
		    //*
		
    			//---api
    
				//localhost
				//$url = "http://localhost/class/keepcoding/index.php/Welcome/emp_attend_api?emp_code=$emp_code&date_time=$date_time";
				//http://localhost/class/keepcoding/index.php/Welcome/emp_attend_api?emp_code=203&date_time=2024-02-26%2019:23%20
    				
				//online server
				//$url =  base_url().'index.php/Welcome/emp_attend_api?emp_code=203&date_time=2024-02-26%2019:23%20'
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$body = curl_exec($ch);

				$sql = " UPDATE temp_emp_att_upload set flag=1 WHERE id = $id  ";
				$query = $this->db->query($sql);
			
				//---api
            //*/

		}//foreach

		echo "done";
	}//function close


	//upload party limit and notification & last date in cr_dr_master table
	public function fun_change_all_part_limit()
	{
		$noti_days = $this->Base->get_debit_payment_notifi_days();

		$sql = "SELECT id,limit_of_days from customer   where limit_of_days >0 ";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		if(!empty($res)){
			//print_r($res);
			foreach($res as $r){
				$id = $r['id'];
				$limit_of_days = $r['limit_of_days'];
				if($limit_of_days >$noti_days){$limit_of_days2 = $limit_of_days-$noti_days;}else{$limit_of_days2 =$limit_of_days;}

				$sql2 = "SELECT cr_dr_id,day_limit,entry_date,last_date,notifi_date from cr_dr_master  where customer_id ='$id'  ";
				//$sql2 = "SELECT cr_dr_id,day_limit,entry_date,last_date,notifi_date from cr_dr_master  where customer_id ='$id' and day_limit=0 ";
				$query2 = $this->db->query($sql2);
				$res3 = $query2->result_array();
				if(!empty($res3)){
					//print_r($res3);
					foreach($res3 as $m){
						$cr_dr_id = $m['cr_dr_id'];
						$entry_date = $m['entry_date'];
						//echo ", ";
						//echo $limit_of_days2;
						//echo ", ";
						//$new_last_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd(date($entry_date),"+$limit_of_days"));
						//echo ", ";
						$new_follow_date = $this->Base->change_date_ymd($this->Base->add_no_of_days_in_date_ymd(date($entry_date),"+$limit_of_days2"));
						//echo "<br>";

						//update table
						//'last_date'=>"$new_last_date", //no need to update last date
						//'day_limit'=>"$limit_of_days",
						$data5=array(
										'notifi_date'=>"$new_follow_date",
									);
						$where5=array('cr_dr_id'=>"$cr_dr_id");   
						$this->Mymodel->update('cr_dr_master',$data5,$where5);
						
					}

				}

			}
		}
		echo "done";
		//echo $new_date = $this->Base->change_date_dmy($this->Base->add_no_of_days_in_date_ymd(date('8-8-2023'),"+26"))
	
	}//function close

	
    /*

	//upload emp punch data from machine to server via pan drive or export
	public function gmail_mail()
	{

		
		 $customer_id = 87;

        //getting data form  ERP
        $url = base_url()."index.php/Welcome/mail_type_1_body?customer_id=$customer_id";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $mail_body = curl_exec($ch);

        $toemail = "kingmanu12801@gmail.com";
        $subject = "Keepcoding - ERP";
        $mesg = $mail_body;
		
		$this->Base->send_mail_test($toemail,$subject,$mesg);//sending mail
	}

  



	public function update_emp_code_all_batch()
	{
		$this->db->trans_begin();

		// ===== Mapping Array =====
		$bioToEmp = [
			"11557"=>"TZ2242","TZF0700"=>"TZ2243","TZF0701"=>"TZ2244","TZF0684"=>"TZ2245","TZF0632"=>"TZ2246",
			"11541"=>"TZ2247","11542"=>"TZ2248","11543"=>"TZ2249","11544"=>"TZ2250","11547"=>"TZ2251",
			"11550"=>"TZ2252","TZF0704"=>"TZ2253","TZF0705"=>"TZ2254","TZF0706"=>"TZ2255","TZF0707"=>"TZ2256",
			"TZF0708"=>"TZ2257","TZF0709"=>"TZ2258","TZF0710"=>"TZ2259","TZF0711"=>"TZ2260","TZF0721"=>"TZ2261",
			"11545"=>"TZ2262","11546"=>"TZ2263","11548"=>"TZ2264","11549"=>"TZ2265","11552"=>"TZ2266",
			"11553"=>"TZ2267","11554"=>"TZ2268","11556"=>"TZ2269","11558"=>"TZ2270","TZF0696"=>"TZ2271",
			"TZF0712"=>"TZ2272","TZF0713"=>"TZ2273","TZF0714"=>"TZ2274","TZF0715"=>"TZ2275","TZF0716"=>"TZ2276",
			"TZF0718"=>"TZ2277","TZF0719"=>"TZ2278","TZF0720"=>"TZ2279","11560"=>"TZ2280","11561"=>"TZ2281",
			"11562"=>"TZ2282","11551"=>"TZ2283","TZF0724"=>"TZ2284","TZF0726"=>"TZ2285","TZF0727"=>"TZ2286",
			"TZF0728"=>"TZ2287","TZF0729"=>"TZ2288","TZF0730"=>"TZ2289","TZF0731"=>"TZ2290","TZF0732"=>"TZ2291",
			"TZF0733"=>"TZ2292","TZF0736"=>"TZ2293","11563"=>"TZ2294","11565"=>"TZ2295","11566"=>"TZ2296",
			"11576"=>"TZ2297","TZF0734"=>"TZ2298","TZF0735"=>"TZ2299","TZF0737"=>"TZ2300","TZF0738"=>"TZ2301",
			"TZF0739"=>"TZ2302","TZF0740"=>"TZ2303","TZF0744"=>"TZ2304","TZF0752"=>"TZ2305","11569"=>"TZ2306",
			"11573"=>"TZ2307","11574"=>"TZ2308","11571"=>"TZ2309","TZF0746"=>"TZ2310","TZF0747"=>"TZ2311",
			"TZF0750"=>"TZ2312","TZF0751"=>"TZ2313","11575"=>"TZ2314","11578"=>"TZ2315","TZF0748"=>"TZ2316",
			"TZF0749"=>"TZ2317","TZF0754"=>"TZ2318","TZF0755"=>"TZ2319","11579"=>"TZ2320","11599"=>"TZ2321",
			"11580"=>"TZ2322","11581"=>"TZ2323","11582"=>"TZ2324","11583"=>"TZ2325","11584"=>"TZ2326",
			"11585"=>"TZ2327","11586"=>"TZ2328","11589"=>"TZ2329","11598"=>"TZ2330","TZF0756"=>"TZ2331",
			"TZF0758"=>"TZ2332","TZF0759"=>"TZ2333","TZF0760"=>"TZ2334","TZF0761"=>"TZ2335","TZF0786"=>"TZ2336",
			"11592"=>"TZ2337","11593"=>"TZ2338","11595"=>"TZ2339","TZF0763"=>"TZ2340","TZF0764"=>"TZ2341",
			"TZF0765"=>"TZ2342","TZF0766"=>"TZ2343","TZF0769"=>"TZ2344","TZF0772"=>"TZ2345","11600"=>"TZ2346",
			"11602"=>"TZ2347","11603"=>"TZ2348","11604"=>"TZ2349","TZF0770"=>"TZ2350","11605"=>"TZ2351",
			"11607"=>"TZ2352","TZF0771"=>"TZ2353","TZF0773"=>"TZ2354","11608"=>"TZ2355","11609"=>"TZ2356",
			"11611"=>"TZ2357","11612"=>"TZ2358","TZF0774"=>"TZ2359","TZF0777"=>"TZ2360","TZF0778"=>"TZ2361",
			"TZF0779"=>"TZ2362","11628"=>"TZ2363","TZF0793"=>"TZ2364","TZF0794"=>"TZ2365"
		];

		$tables = [
			'employee',
			'canteen_coupon_issue',
			'daily_attendance',
			'daily_attendance_monthly_emp_exp',
			'employee_loan',
			'employee_loan_emi_recovery',
			'emp_advance',
			'emp_leave',
			'emp_other_application',
			'emp_reimbursement_master',
			'emp_salary_transfer',
			'emp_tds'
		];

		$updatedList = [];
		$missingBio  = [];

		

		foreach ($bioToEmp as $bio_code => $new_emp_code) {

			$emp = $this->db
				->get_where('employee', ['bio_code' => $bio_code])
				->row_array();

			if (!$emp) {
				$missingBio[] = $bio_code;
				continue;
			}

			$old_emp_code = $emp['emp_code'];
			$temp_code    = 'TMP_'.$old_emp_code;

			// employee table
			$this->db->where('emp_code', $old_emp_code);
			$this->db->update('employee', [
				'emp_code' => $temp_code,
				'pay_code' => $temp_code
			]);

			// related tables
			foreach ($tables as $tbl) {

				if ($tbl == 'employee') continue;

				$this->db->where('emp_code', $old_emp_code);
				$this->db->update($tbl, ['emp_code' => $temp_code]);
			}
		}

	

		foreach ($bioToEmp as $bio_code => $new_emp_code) {

			$emp = $this->db
				->get_where('employee', ['bio_code' => $bio_code])
				->row_array();

			if (!$emp) continue;

			$temp_code = $emp['emp_code']; // TMP_xxx

			// employee table
			$this->db->where('bio_code', $bio_code);
			$this->db->update('employee', [
				'emp_code' => $new_emp_code,
				'pay_code' => $new_emp_code
			]);

			// related tables
			foreach ($tables as $tbl) {

				if ($tbl == 'employee') continue;

				$this->db->where('emp_code', $temp_code);
				$this->db->update($tbl, ['emp_code' => $new_emp_code]);
			}

			$updatedList[] = "$bio_code → $new_emp_code";
		}

		

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo "FAILED";
			return;
		}

		$this->db->trans_commit();

		echo "<h3>Updated</h3>";
		echo implode("<br>", $updatedList);

		echo "<h3>Missing Bio</h3>";
		echo implode("<br>", $missingBio);
	}

	public function fix_extra_time()
	{
		$sql = " SELECT * FROM temp_table_min GROUP BY bio_code ";
		$query = $this->db->query($sql);
        $att =  $query->result_array();
		//print_r($att);
		if(!empty($att)){
			foreach ($att as $a) {
				
					$bio_code = $a['bio_code'];
					$entry_date = $a['entry_date'];

					$sql = " SELECT emp_code FROM employee WHERE bio_code='$bio_code' ";
					$query = $this->db->query($sql);
					$emp =  $query->result_array();
					if(!empty($emp)){
						$emp_code = $emp[0]['emp_code'];

						$sql = " SELECT id,emp_code,shift_in_time,dutyMin FROM daily_attendance WHERE emp_code='$emp_code' and shift_in_time like '$entry_date%' ";
						$query = $this->db->query($sql);
						$res =  $query->result_array();
						if(!empty($res)){
							echo $res[0]['id'].', '.$res[0]['emp_code'].', '.$res[0]['shift_in_time'].', '.$res[0]['dutyMin'];
							echo "<br>";
							$data = array('dutyMin'=>$res[0]['dutyMin'], 'bio_code'=>$bio_code);
							$where=array('id'=>$res[0]['id']);   
							$this->Mymodel->update('daily_attendance',$data,$where);
						}
					}
			}
		}
		echo "done";
	}

 */


public function fix_extra_time()
{
   /*
	UPDATE daily_attendance da INNER JOIN ( SELECT t.emp_code, t.shift_date, t.bio_code, t.min FROM temp_table_min t INNER JOIN ( SELECT emp_code, shift_date, MAX(id) AS max_id FROM temp_table_min GROUP BY emp_code, shift_date ) x ON t.emp_code = x.emp_code AND t.shift_date = x.shift_date AND t.id = x.max_id ) clean ON da.emp_code = clean.emp_code AND DATE(da.shift_in_time) = clean.shift_date SET da.bio_code = clean.bio_code, da.dutyMin = clean.min
	*/
}



}//class close
