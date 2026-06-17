<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
		$this->load->model('Base');
		
		$user_email=$this->session->userdata('login_username');
		if(!$user_email>0){redirect('welcome/');}
	}//function close

	public function index()
	{
		redirect("welcome/");
	}//function close



		/*
	//update all breakdown list with its complte time
	public function get_breakdown_time_for_all()
	{
		$where = " active='Completed' ";
		$res = $this->Mymodel->select_where('maint_problem',$where);
		if(!empty($res))
		{
			foreach($res as $r)
			{
				if(!empty($r['comp_time']) and $r['comp_time']!='00:00:00')
				{
					$maint_it = $r['maint_problem_id'];
					
					$break_down_date = $r['break_down_date'];
					$break_down_time = $r['break_down_time'];

					$comp_date = $r['comp_date'];
					$comp_time2 = $this->Base->change_time_hisa($r['comp_time']);

					$to1="$break_down_date $break_down_time";
					$from1="$comp_date $comp_time2";
					
					$to_time = strtotime($to1);
					$from_time = strtotime($from1);
					$breakdown_total_time_in_min = round(abs($to_time - $from_time) / 60);

					$data=array('breakdown_total_time_in_min'=>"$breakdown_total_time_in_min");
					$where=array('maint_problem_id'=>"$maint_it");   
					$this->Mymodel->update('maint_problem',$data,$where);

				}//if
			}//foreach
		}
	}//function close
	*/



	



	//add /edit new add_breakdown
	public function add_breakdown()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Maintenancemodel->get_breakdown_data_with_id($id);
		}//strlen
		$result['dept']=$this->Base->get_maintenance_dept();
		$result['pl']=$this->Base->get_all_breakdown_problem_list();
		$this->load->view('maintenance/entry',$result);
	}//function close

	//list search
	public function list_breakdown()
	{
		$result['dept']=$this->Base->get_maintenance_dept();
		$result['pl']=$this->Base->get_all_breakdown_problem_list();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['status'])){$status=$_REQUEST['status'];$where.=" and  A.active='$status'   ";}
			if(!empty($_REQUEST['type1'])){$type1=$_REQUEST['type1'];$where.=" and  A.type2='$type1'   ";}
			if(!empty($_REQUEST['type2'])){$type2=$_REQUEST['type2'];$where.=" and  A.type='$type2'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.dept='$dept'   ";}
			if(!empty($_REQUEST['problem_type_id'])){$problem_type_id=$_REQUEST['problem_type_id'];$where.=" and  A.problem_type_id='$problem_type_id'   ";}
			if(!empty($_REQUEST['type_of_work'])){$type_of_work=$_REQUEST['type_of_work'];$where.=" and  A.type_of_work='$type_of_work'   ";}
			if(!empty($_REQUEST['priority'])){$priority=$_REQUEST['priority'];$where.=" and  A.priority='$priority'   ";}
			if(!empty($_REQUEST['rating'])){$rating=$_REQUEST['rating'];$where.=" and  A.rating='$rating'   ";}
			if(!empty($_REQUEST['attend_by'])){$attend_by=$_REQUEST['attend_by'];$where.=" and  A.attend_by='$attend_by'   ";}

			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.entry_date ASC ";
			$result['res2'] = $this->Maintenancemodel->get_all_breakdown_with_search($where);

			//machine wise breakdown min 
			$result['fdate_search'] = $search_date1;
			$result['tdate_search'] = $search_date2;
			//$result['res4'] = $this->Maintenancemodel->get_all_machine_breakdown_in_minute($search_date1,$search_date2);
			//$result['res5'] = $this->Maintenancemodel->get_all_problem_breakdown_in_minute($search_date1,$search_date2);
			$result['res6'] = $this->Maintenancemodel->get_all_person_attend_breakdown_in_minute($search_date1,$search_date2);
			$result['res7'] = $this->Maintenancemodel->get_all_type_of_work_breakdown_in_minute($search_date1,$search_date2);

			$this->load->view('maintenance/show_table',$result);
		}
		else
		{
			//breakdown list
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-d');
			$where = "  and A.entry_date between '$search_date1' and '$search_date2'  ORDER by A.entry_date ASC ";
			$result['res2'] = $this->Maintenancemodel->get_all_breakdown_with_search($where);
			
			//machine wise breakdown min 
			$result['fdate_search'] = $search_date1;
			$result['tdate_search'] = $search_date2;
			//$result['res4'] = $this->Maintenancemodel->get_all_machine_breakdown_in_minute($search_date1,$search_date2);
			//$result['res5'] = $this->Maintenancemodel->get_all_problem_breakdown_in_minute($search_date1,$search_date2);
			$result['res6'] = $this->Maintenancemodel->get_all_person_attend_breakdown_in_minute($search_date1,$search_date2);
			$result['res7'] = $this->Maintenancemodel->get_all_type_of_work_breakdown_in_minute($search_date1,$search_date2);
			
			$this->load->view('maintenance/show',$result);
			
		}//search
	}//function close


	//print mttr_format machine wise
	public function mttr_format()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$mc_id = $this->uri->segment(3);
			$search_date1 = $this->uri->segment(4);
			$search_date2 = $this->uri->segment(5);
			$where = " and  A.mc_no='$mc_id' and A.entry_date between '$search_date1' and '$search_date2'  ORDER by A.entry_date ASC ";
			$result['res2'] = $this->Maintenancemodel->get_all_breakdown_with_search($where);
			//print_r($result['res2']);
			$this->load->view('maintenance/mttr',$result);
		}//strlen
	}//function close

	//print mttr_format problem wise
	public function mttr_format2()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$problem_type_id = $this->uri->segment(3);
			$search_date1 = $this->uri->segment(4);
			$search_date2 = $this->uri->segment(5);
			$where = " and  A.problem_type_id='$problem_type_id' and A.entry_date between '$search_date1' and '$search_date2'  ORDER by A.entry_date ASC ";
			$result['res2'] = $this->Maintenancemodel->get_all_breakdown_with_search($where);
			//print_r($result['res2']);
			$this->load->view('maintenance/mttr',$result);
		}//strlen
	}//function close





	//breakdwon save
	public function breakdown_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['entry_date'])){$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date=date('Y-m-d');}
		if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}else{$dept='';}
		if(isset($_REQUEST['type'])){$type=$_REQUEST['type'];}else{$type='';}
		if(isset($_REQUEST['type2'])){$type2=$_REQUEST['type2'];}else{$type2='';}
		if(isset($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];}else{$mc_no='';}
		
		if(isset($_REQUEST['type_of_problem'])){$type_of_problem=$_REQUEST['type_of_problem'];}else{$type_of_problem='';}
		if(isset($_REQUEST['other_problem_type'])){$other_problem_type=$_REQUEST['other_problem_type'];}else{$other_problem_type='';}

		if($type_of_problem == 'Other')
		{
			//new insert
			$where = " name='$other_problem_type' ";
			$res_chk = $this->Mymodel->select_where('breakdown_problem_list',$where);
			if(!empty($res_chk))
			{
				//echo "old";
				$problem_type_id = $res_chk[0]['id'];
			}
			else
			{
				//echo "create new";
				$data=array('name'=>"$other_problem_type",'status'=>"Active");
				$problem_type_id = $this->Mymodel->insertdata_withid('breakdown_problem_list',$data);
			}
		}
		else
		{
			//echo "from list";
			$problem_type_id = $type_of_problem;
		}
		
		if(isset($_REQUEST['problem'])){$problem=$_REQUEST['problem'];}else{$problem='';}
		if(isset($_REQUEST['break_down_date'])){$break_down_date = $this->Base->change_date_ymd($_REQUEST['break_down_date']);}else{$break_down_date="";}
		if(isset($_REQUEST['break_down_time'])){$break_down_time = $this->Base->change_time_His($_REQUEST['break_down_time']);}else{$break_down_time="";}
		if(isset($_REQUEST['person'])){$person=$_REQUEST['person'];}else{$person='';}	
		if(isset($_REQUEST['shift_incharge1'])){$shift_incharge1=$_REQUEST['shift_incharge1'];}else{$shift_incharge1='';}	
		if(isset($_REQUEST['action_taken'])){$action_taken=$_REQUEST['action_taken'];}else{$action_taken='';}	
		if(isset($_REQUEST['part_change'])){$part_change=$_REQUEST['part_change'];}else{$part_change='';}	
		if(isset($_REQUEST['attend_by'])){$attend_by=$_REQUEST['attend_by'];}else{$attend_by='';}	
		if(isset($_REQUEST['active'])){$active=$_REQUEST['active'];}else{$active='';}	
		if(!empty($_REQUEST['comp_date'])){$comp_date = $this->Base->change_date_ymd($_REQUEST['comp_date']);}else{$comp_date="0000-00-00";}
		if(!empty($_REQUEST['comp_time'])){$comp_time = $this->Base->change_time_His($_REQUEST['comp_time']);}else{$comp_time="";}
		if(isset($_REQUEST['checked_by'])){$checked_by=$_REQUEST['checked_by'];}else{$checked_by='';}	
		if(isset($_REQUEST['shift_incharge2'])){$shift_incharge2=$_REQUEST['shift_incharge2'];}else{$shift_incharge2='';}	
		if(isset($_REQUEST['md_review'])){$md_review=$_REQUEST['md_review'];}else{$md_review='';}	
		if(isset($_REQUEST['shift'])){$shift=$_REQUEST['shift'];}else{$shift='';}
		if(isset($_REQUEST['root_cause'])){$root_cause=$_REQUEST['root_cause'];}else{$root_cause='';}
		if(isset($_REQUEST['priority'])){$priority=$_REQUEST['priority'];}else{$priority='';}
		if(isset($_REQUEST['rating'])){$rating=$_REQUEST['rating'];}else{$rating='';}
		if(isset($_REQUEST['type_of_work'])){$type_of_work=$_REQUEST['type_of_work'];}else{$type_of_work='';}
		

		if(!empty($_REQUEST['comp_time']) and $_REQUEST['comp_time']!='00:00:00' and !empty($_REQUEST['comp_date']) and $_REQUEST['comp_date']!='0000-00-00')
		{
		  $comp_time2 = $this->Base->change_time_hisa($_REQUEST['comp_time']);

		  $to1="$break_down_date $break_down_time";
		  $from1="$comp_date $comp_time2";
		  
		  $to_time = strtotime($to1);
		  $from_time = strtotime($from1);
		  $breakdown_total_time_in_min = round(abs($to_time - $from_time) / 60);
		}else{$breakdown_total_time_in_min="";}

		if($active != "Completed" and (empty($_REQUEST['comp_date']) OR $_REQUEST['comp_date']!='0000-00-00'))
		{
			$comp_time = "";
		}
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['problem']))
		{
			$data=array(
							  'entry_date'=>"$entry_date",
							  'dept'=>"$dept",
							  'type'=>"$type",
							  'type2'=>"$type2",
							  'mc_no'=>"$mc_no",
							  'problem_type_id'=>"$problem_type_id",
							  'problem'=>"$problem",
							  'break_down_date'=>"$break_down_date",
							  'break_down_time'=>"$break_down_time",
							  'person'=>"$person",
							  'shift_incharge1'=>"$shift_incharge1",
							  'action_taken'=>"$action_taken",
							  'part_change'=>"$part_change",
							  'attend_by'=>"$attend_by",
							  'active'=>"$active",
							  'comp_date'=>"$comp_date",
							  'comp_time'=>"$comp_time",
							  'breakdown_total_time_in_min'=>"$breakdown_total_time_in_min",
							  'checked_by'=>"$checked_by",
							  'shift_incharge2'=>"$shift_incharge2",
							  'md_review'=>"$md_review",

							  'shift'=>"$shift",
							  'root_cause'=>"$root_cause",
							  'priority'=>"$priority",
							  'rating'=>"$rating",
							   'type_of_work'=>"$type_of_work",

							  'save_by'=>"$user_email",
							  'save_date'=>"$today",
							);
			$cat_id=$this->Mymodel->insertdata_withid('maint_problem',$data);
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['problem']))
		{
			$data=array(
								'entry_date'=>"$entry_date",
								'dept'=>"$dept",
								'type'=>"$type",
								'type2'=>"$type2",
								'mc_no'=>"$mc_no",
								'problem_type_id'=>"$problem_type_id",
								'problem'=>"$problem",
								'break_down_date'=>"$break_down_date",
								'break_down_time'=>"$break_down_time",
								'person'=>"$person",
								'shift_incharge1'=>"$shift_incharge1",
								'action_taken'=>"$action_taken",
								'part_change'=>"$part_change",
								'attend_by'=>"$attend_by",
								'active'=>"$active",
								'comp_date'=>"$comp_date",
								'comp_time'=>"$comp_time",
								'breakdown_total_time_in_min'=>"$breakdown_total_time_in_min",
								'checked_by'=>"$checked_by",
								'shift_incharge2'=>"$shift_incharge2",
								'md_review'=>"$md_review",
								'shift'=>"$shift",
								'root_cause'=>"$root_cause",
								'priority'=>"$priority",
								'rating'=>"$rating",
								 'type_of_work'=>"$type_of_work",

								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
			$where=array('maint_problem_id'=>"$id");   
			$this->Mymodel->update('maint_problem',$data,$where);
			echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close



	//list2 search
	public function list2()
	{
		if(isset($_REQUEST['search1']))
		{
			//search
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$this->Maintenancemodel->get_breakdown_from_mc_and_problem3($search_date1,$search_date2);
			}
		}
		else
		{
			//url
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$this->Maintenancemodel->get_breakdown_from_mc_and_problem3($search_date1,$search_date2);
			}
			$this->load->view('maintenance/show2');
		}//search
	}//function close


	//list3 same as list2 but thrugh url search
	public function list3()
	{
		//url
		if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
		{
			$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
			$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
			$this->Maintenancemodel->get_breakdown_from_mc_and_problem3($search_date1,$search_date2);
		}
	}//function close




	





























	//add /edit new add_meter_reading
	public function add_meter_reading()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$date = $this->uri->segment(3);
			//$result['res2']=$this->Maintenancemodel->get_energy_meter_reading_with_date($date);
			$result['search_date']=$date;
		}//strlen
		else
		{
			$result['search_date']= date('Y-m-d');
		}
		
		$result['dept']=$this->Base->get_meter_reading_dept();
		$this->load->view('maintenance/reading/entry',$result);
	}//function close


	//list search
	public function list_meter_reading()
	{
		$result['dept']=$this->Base->get_meter_reading_dept();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.dept_id='$dept'   ";}
			if(!empty($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];$where.=" and  A.mc_id='$mc_no'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.entry_date,B.name,C.name DESC ";
			
			$result['res2'] = $this->Maintenancemodel->get_all_meter_reading_with_search($where);
			$this->load->view('maintenance/reading/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-d');
			$search_date2= date('Y-m-d');
			$where = " and A.entry_date between '$search_date1' and '$search_date2' ORDER by A.entry_date,B.name,C.name DESC ";
			$result['res2'] = $this->Maintenancemodel->get_all_meter_reading_with_search($where);
			$this->load->view('maintenance/reading/show',$result);
		}//search
	}//function close



	//meter_reading_save save
	public function meter_reading_save()
	{
		
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['entry_date'])){ $entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}
		
		if(isset($_REQUEST['deptclassid'])){$deptclassid=explode('~',$_REQUEST['deptclassid']);$no_of_row=count($deptclassid);}else{$deptclassid='';$no_of_row=0;}
		if(isset($_REQUEST['deptclassval'])){$deptclassval=explode('~',$_REQUEST['deptclassval']);}else{$deptclassval='';}
		if(isset($_REQUEST['machineclassid'])){$machineclassid=explode('~',$_REQUEST['machineclassid']);}else{$machineclassid='';}
		if(isset($_REQUEST['machineclassval'])){$machineclassval=explode('~',$_REQUEST['machineclassval']);}else{$machineclassval='';}
		
		
		//----------------------------------dept, machine and reading entry
		$i=0;
		foreach($machineclassid as $m)
		{
			if($machineclassval[$i] >0)
			{
				$exp = explode(',',$m);
				$dept_id = $exp[0];
				$mc_id = $exp[1];
				$reading = $machineclassval[$i];
				$where = " entry_date='$entry_date' and dept_id='$dept_id' and mc_id='$mc_id' ";
				$res_chk = $this->Mymodel->select_where('energy_meter_reading',$where);
				if(!empty($res_chk))
				{
					//update
					$data=array(
						'meter_reading'=>"$reading",
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
					$this->Mymodel->update('energy_meter_reading',$data,$where);
				}
				else
				{
					//new entry
					$data=array(
						'entry_date'=>"$entry_date",
						'dept_id'=>"$dept_id",
						'mc_id'=>"$mc_id",
						'meter_reading'=>"$reading",
						'save_by'=>"$user_email",
						'save_date'=>"$today",
					);
		  			$insert_id=$this->Mymodel->insertdata_withid('energy_meter_reading',$data);
				}//$res_chk
			}//>0
			$i++;
		}//foreach
		
		
		
		
		
		
		
		//----------------------------------dept and reading entry
		$i=0;
		foreach($deptclassid as $d)
		{
			if(isset($deptclassval[$i]) and $deptclassval[$i] >0)
			{
				$dept_id = $d;
				$reading = $deptclassval[$i];
				
				$where = " entry_date='$entry_date' and dept_id='$dept_id' ";
				$res_chk = $this->Mymodel->select_where('energy_meter_reading',$where);
				if(!empty($res_chk))
				{
					//update
					$data=array(
						'meter_reading'=>"$reading",
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
					$this->Mymodel->update('energy_meter_reading',$data,$where);
				}
				else
				{
					//new entry
					$data=array(
						'entry_date'=>"$entry_date",
						'dept_id'=>"$dept_id",
						'meter_reading'=>"$reading",
						'save_by'=>"$user_email",
						'save_date'=>"$today",
					);
		  			$insert_id=$this->Mymodel->insertdata_withid('energy_meter_reading',$data);
				}//$res_chk
			}
			$i++;
		}//foreach


		echo "Update";

	}//function close


	
	


	



	//list_meter_reading kg/KWH
	public function list_meter_reading2()
	{
		$result['dept']=$this->Base->get_meter_reading_dept();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.entry_date ASC ";
			
			$m = $this->Base->change_date_into_month($search_date1);
			$y = $this->Base->change_date_into_year($search_date1);

			$result['res2'] = $this->Base->get_day_full_date_on_month($m,$y);
			$this->load->view('maintenance/reading2/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');

			$m = $this->Base->change_date_into_month($search_date1);
			$y = $this->Base->change_date_into_year($search_date1);
			
			$result['res2'] = $this->Base->get_day_full_date_on_month($m,$y);
			$this->load->view('maintenance/reading2/show',$result);
		}//search
	}//function close







	
	















	//-------------------------------------------------------------Reminder
	//add /edit new add_reminder
	public function add_reminder()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Maintenancemodel->get_reminder_data_with_id($id);
		}//strlen
		$result['dept']=$this->Base->get_all_dept();
		$this->load->view('maintenance/reminder/entry',$result);
	}//function close

	//list search
	public function list_reminder()
	{
		$result['dept']=$this->Base->get_all_dept();
		
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['status'])){$status=$_REQUEST['status'];$where.=" and  A.status='$status'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.dept='$dept'   ";}
			if(!empty($_REQUEST['priority'])){$priority=$_REQUEST['priority'];$where.=" and  A.priority='$priority'   ";}
			if(!empty($_REQUEST['location'])){$location=$_REQUEST['location'];$where.=" and  A.location='$location'   ";}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.next_event_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by A.next_event_date ASC ";
			$result['res2'] = $this->Maintenancemodel->get_all_reminder_with_search($where);

			$this->load->view('maintenance/reminder/show_table',$result);
		}
		else
		{
			//breakdown list
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$where = "  and A.next_event_date between '$search_date1' and '$search_date2'  ORDER by A.next_event_date ASC ";
			$result['res2'] = $this->Maintenancemodel->get_all_reminder_with_search($where);
			
			
			$this->load->view('maintenance/reminder/show',$result);
			
		}//search
	}//function close




	//reminder_save 
	public function reminder_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['reminder_id'])){$reminder_id=$_REQUEST['reminder_id'];}else{$reminder_id='';}
		if(isset($_REQUEST['event_date'])){$event_date = $this->Base->change_date_ymd($_REQUEST['event_date']);}else{$entry_date=date('Y-m-d');}
		if(isset($_REQUEST['task'])){$task=$_REQUEST['task'];}else{$task='';}
		if(isset($_REQUEST['repeat_status'])){$repeat_status=$_REQUEST['repeat_status'];}else{$repeat_status='';}
		if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}else{$dept='';}
		if(isset($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];}else{$mc_no='';}
		if(isset($_REQUEST['status'])){$status=$_REQUEST['status'];}else{$status='';}	
		if(isset($_REQUEST['priority'])){$priority=$_REQUEST['priority'];}else{$priority='';}
		if(isset($_REQUEST['show_to'])){$show_to=$_REQUEST['show_to'];}else{$show_to='';} if($show_to != "Everyone"){$show_to=$user_email;}
		if(isset($_REQUEST['location'])){$location=$_REQUEST['location'];}else{$location='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		if(isset($_REQUEST['customer_id'])){$customer_id=$_REQUEST['customer_id'];}else{$customer_id='';}

		//getting next date
		$next_event_date = $this->Base->add_givin_days_in_date_ymd($event_date,$repeat_status);
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['reminder_id']) and !empty($_REQUEST['task']))
		{
			$data=array(
							  'event_date'=>"$event_date",
							  'location'=>"$location",
							  'customer_id'=>"$customer_id",
							  'task'=>"$task",
							  'repeat_status'=>"$repeat_status",
							  'next_event_date'=>"$next_event_date",
							  'dept'=>"$dept",
							  'mc_no'=>"$mc_no",

							  'status'=>"$status",
							  'priority'=>"$priority",
							  'show_to'=>"$show_to",
							  'remarks'=>"$remarks",
							  	
							  'save_by'=>"$user_email",
							  'save_date'=>"$today",
							);
			$cat_id=$this->Mymodel->insertdata_withid('reminder',$data);


			//update in customer table
			if($customer_id > 0){

					$data=array(
						'follow_up_date'=>"$event_date",
						'follow_up_last_status'=>"",
						'follow_up_comments'=>"$task",
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
					$where=array('id'=>"$customer_id");   
					$this->Mymodel->update('customer',$data,$where);
			}//update customer


			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['reminder_id']) and !empty($_REQUEST['task']))
		{
			$data=array(
								'event_date'=>"$event_date",
								'location'=>"$location",
								'customer_id'=>"$customer_id",
								'task'=>"$task",
								'repeat_status'=>"$repeat_status",
								'next_event_date'=>"$next_event_date",
								'dept'=>"$dept",
								'mc_no'=>"$mc_no",

								'status'=>"$status",
								'priority'=>"$priority",
								'show_to'=>"$show_to",
							  	'remarks'=>"$remarks",
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
			$where=array('reminder_id'=>"$reminder_id");   
			$this->Mymodel->update('reminder',$data,$where);
			echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close




}//close class
