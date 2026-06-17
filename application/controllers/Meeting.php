<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meeting extends CI_Controller {

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





	

	//add /edit new mom
	public function add()
	{
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Meetingmodel->get_mom_data_with_id($id);
		}//strlen
		else{ $result=array();}
		$this->load->view('meeting/entry',$result);
	}//function close

	//list search
	public function list_mom()
	{
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['status'])){$status=$_REQUEST['status'];$where.=" and  status='$status'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" ORDER by entry_date DESC ";
			$result['res2'] = $this->Meetingmodel->get_all_mom_with_search($where);
			$this->load->view('meeting/show_table',$result);
		}
		else
		{
			$search_date1 = date('Y-m-d');
			$where = "  and entry_date='$search_date1' ORDER by entry_date DESC ";
			$result['res2'] = $this->Meetingmodel->get_all_mom_with_search($where);
			$this->load->view('meeting/show',$result);
		}//search
	}//function close




	public function save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['entry_date'])){$entry_date=$this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date='';}
		if(isset($_REQUEST['chair_person'])){$chair_person=$_REQUEST['chair_person'];}else{$chair_person='';}
		if(isset($_REQUEST['participants'])){$participants=$_REQUEST['participants'];}else{$participants='';}
		if(isset($_REQUEST['review_point'])){$review_point=$_REQUEST['review_point'];}else{$review_point='';}
		if(isset($_REQUEST['current_status'])){$current_status=$_REQUEST['current_status'];}else{$current_status='';}
		if(isset($_REQUEST['action_taken'])){$action_taken=$_REQUEST['action_taken'];}else{$action_taken='';}
		if(isset($_REQUEST['resp'])){$resp=$_REQUEST['resp'];}else{$resp='';}	
		if(isset($_REQUEST['target_date'])){$target_date=$this->Base->change_date_ymd($_REQUEST['target_date']);}else{$target_date='';}	
		if(!empty($_REQUEST['comp_date'])){$comp_date=$this->Base->change_date_ymd($_REQUEST['comp_date']);}else{$comp_date='0000-00-00';}	
		if(isset($_REQUEST['active'])){$active=$_REQUEST['active'];}else{$active='';}	
		if(isset($_REQUEST['md_review'])){$md_review=$_REQUEST['md_review'];}else{$md_review='';}	
		
		//-----------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['review_point']))
		{
			$data=array(
							  'entry_date'=>"$entry_date",
							  'chair_person'=>"$chair_person",
							  'participants'=>"$participants",
							  
							  'review'=>"$review_point",
							  'current_status'=>"$current_status",
							  'action_taken'=>"$action_taken",
							  'resp'=>"$resp",
							  'target_date'=>"$target_date",
							  'comp_date'=>"$comp_date",
							  'status'=>"$active",
							  'md_review'=>"$md_review",
							  
							  
							  'save_by'=>"$user_email",
							  'save_date'=>"$today",
							);
			$cat_id=$this->Mymodel->insertdata_withid('mom',$data);
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['review_point']))
		{
			$data=array(
							  'entry_date'=>"$entry_date",
							  'chair_person'=>"$chair_person",
							  'participants'=>"$participants",
							  
							  'review'=>"$review_point",
							  'current_status'=>"$current_status",
							  'action_taken'=>"$action_taken",
							  'resp'=>"$resp",
							  'target_date'=>"$target_date",
							  'comp_date'=>"$comp_date",
							  'status'=>"$active",
							  'md_review'=>"$md_review",
							  
							  'save_by'=>"$user_email",
							  'save_date'=>"$today",
							);
			$where=array('mom_id'=>"$id");   
			$this->Mymodel->update('mom',$data,$where);
			echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
		
		
	}//function close
	
	
	
	
	
	
	
	

}//close class