<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Machine extends CI_Controller {

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



	//---get machine form dept_id in list format
	public function fun_get_machine_form_dept_id()
	{
		if(!empty($_REQUEST['dept_id']))
		{
			$dept_id = $_REQUEST['dept_id'];
			$machine = $this->Machinemodel->fun_get_machine_form_dept_id($dept_id);
				?><option value="">Select</option><?php 
			foreach($machine as $m)
			{
				?><option value="<?php echo $m['mc_id'];?>"><?php echo $m['name'];?></option><?php 
			}
		}
	}//function close





	

	//add /edit new machine
	public function add()
	{
		$result['dept'] = $this->Base->get_all_production_dept();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Machinemodel->get_machine_details_with_id($id);
			$result['ropes_mc_tools']=$this->Machinemodel->fun_get_machine_pro_tool_target($id);
			$result['res3']=$this->Machinemodel->fun_get_machine_pro_capicity_target($id);
		}//strlen
		$this->load->view('machine/entry',$result);
	}//function close

	//list search
	public function list()
	{
		$result['dept'] = $this->Base->get_all_production_dept();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['status'])){$status=$_REQUEST['status'];$where.=" and  A.status='$status'   ";}
			if(!empty($_REQUEST['hide_status'])){$hide_status=$_REQUEST['hide_status'];$where.=" and  A.hide_status='$hide_status'   ";}
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.dept='$dept'   ";}
			if(!empty($_REQUEST['name'])){$name=$_REQUEST['name'];$where.=" and  A.name like '%$name%'   ";}
			
			$where.=" ORDER by B.name,A.name ASC ";
			$result['res2'] = $this->Machinemodel->get_all_machine_with_search($where);
			$this->load->view('machine/show_table',$result);
		}
		else
		{
			$where=" and A.status='Working' and A.hide_status=0  ORDER by B.name,A.name ASC ";
			$result['res2']=$this->Machinemodel->get_all_machine_with_search($where);
			$this->load->view('machine/show',$result);
		}//search
	}//function close


	


	public function save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}
		if(isset($_REQUEST['name'])){$name=$_REQUEST['name'];}
		if(isset($_REQUEST['capstan'])){$capstan=$_REQUEST['capstan'];}else{$capstan='';}
		if(isset($_REQUEST['max_speed'])){$max_speed=$_REQUEST['max_speed'];}else{$max_speed='';}
		if(isset($_REQUEST['min_base_size'])){$min_base_size=$_REQUEST['min_base_size'];}else{$min_base_size='';}
		if(isset($_REQUEST['max_base_size'])){$max_base_size=$_REQUEST['max_base_size'];}else{$max_base_size='';}
		if(isset($_REQUEST['min_finish_size'])){$min_finish_size=$_REQUEST['min_finish_size'];}else{$min_finish_size='';}
		if(isset($_REQUEST['max_finish_size'])){$max_finish_size=$_REQUEST['max_finish_size'];}else{$max_finish_size='';}
		if(isset($_REQUEST['status'])){$status=$_REQUEST['status'];}else{$status='';}
		if(isset($_REQUEST['hide_status'])){$hide_status=$_REQUEST['hide_status'];}else{$hide_status='';}
		//--------------------------------------row
		if(isset($_REQUEST['machine_pro_tool_target_id'])){$machine_pro_tool_target_id=explode('~',$_REQUEST['machine_pro_tool_target_id']);$no_of_row=count($machine_pro_tool_target_id);}else{$machine_pro_tool_target_id='';}
		if(isset($_REQUEST['tool_id'])){$tool_id=explode('~',$_REQUEST['tool_id']);$no_of_row=count($tool_id);}else{$tool_id='';$no_of_row=0;}
		if(isset($_REQUEST['lenght'])){$lenght=explode('~',$_REQUEST['lenght']);}else{$lenght='';}
		if(isset($_REQUEST['goods'])){$goods=explode('~',$_REQUEST['goods']);$no_of_row2=count($goods);}else{$goods='';$no_of_row2=0;}
		if(isset($_REQUEST['details_id'])){$details_id=explode('~',$_REQUEST['details_id']);}else{$details_id='';}
		if(isset($_REQUEST['hours'])){$hours=explode('~',$_REQUEST['hours']);}else{$hours='';}
		if(isset($_REQUEST['qunt'])){$qunt=explode('~',$_REQUEST['qunt']);}else{$qunt='';}
		if(isset($_REQUEST['eff'])){$eff=explode('~',$_REQUEST['eff']);}else{$eff='';}
		//--------------------------------------row
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['name']))
		{
			$where=" dept='$dept' and name='$name' ";
			$res_chk=$this->Mymodel->select_where('machine_list',$where);
			if(!empty($res_chk)){$id2=$res_chk[0]['mc_id'];}
			if(!empty($id2))
			{
				echo "Not Save. $name M/C NO Already Available";
			}
			else
			{
				$data=array(
								'dept'=>"$dept",
								'name'=>"$name",
								'capstan'=>"$capstan",
								'max_speed'=>"$max_speed",
								'min_base_size'=>"$min_base_size",
								'max_base_size'=>"$max_base_size",
								'min_finish_size'=>"$min_finish_size",
								'max_finish_size'=>"$max_finish_size",
								'status'=>"$status",
								'hide_status'=>"$hide_status",
								'save_by'=>"$user_email",
								'save_date'=>"$today",
							);
				$save_id=$this->Mymodel->insertdata_withid('machine_list',$data);
				if($save_id>0 and $no_of_row>0)
				{
					for($i=0;$i<$no_of_row;$i++)
					{
						if($lenght[$i]>0)
						{
							$data2=array();
							$data2=array(
											'mc_id'=>"$save_id",
											'tool_id'=>"$tool_id[$i]",
											'lenght'=>"$lenght[$i]",
											'save_by'=>"$user_email",
											'save_date'=>"$today",
										);
							$this->Mymodel->insertdata('machine_pro_tool_target',$data2);
						}//if length
					}//for
				}//no of rows
				
				//---------------------------------------------------------max length
				if($save_id>0)
				{
					for($i=0;$i<$no_of_row2;$i++)
					{
						if($qunt[$i]>0)
						{
							//------------geting cat
							$data2=array();
							$data2=array(
											'mc_id'=>"$save_id",
											'product_id'=>"$goods[$i]",
											'total_hour'=>"$hours[$i]",
											'total_pro'=>"$qunt[$i]",
											'pro_eff'=>"$eff[$i]",
											'save_by'=>"$user_email",
											'save_date'=>"$today",
										);
							$this->Mymodel->insertdata('machine_pro_eff_target',$data2);
						}//qty
					}//for loop
				}//id
				echo "Save";
			}//not repeat
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['name']))
		{
			$where=" dept='$dept' and name='$name' ";
			$res_chk=$this->Mymodel->select_where('machine_list',$where);
			if(!empty($res_chk)){$id2=$res_chk[0]['mc_id'];}
			if(!empty($id2) and $id!=$id2)
			{
				echo "Not Save. $name M/C NO Already Available";
			}
			else
			{
				$data=array(
								'dept'=>"$dept",
								'name'=>"$name",
							  	'capstan'=>"$capstan",
								'max_speed'=>"$max_speed",
								'min_base_size'=>"$min_base_size",
								'max_base_size'=>"$max_base_size",
								'min_finish_size'=>"$min_finish_size",
								'max_finish_size'=>"$max_finish_size",
								'status'=>"$status",
								'hide_status'=>"$hide_status",
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
				$where=array('mc_id'=>"$id");   
				$this->Mymodel->update('machine_list',$data,$where);
				//-------------------------------------------------update tool life
				if($no_of_row>0)
				{
					for($i=0;$i<$no_of_row;$i++)
						{
							if($lenght[$i]>0)
							{
								if($machine_pro_tool_target_id[$i]>0)
								{
									$machine_pro_tool_target_id2=$machine_pro_tool_target_id[$i];
									$data2=array();
									$data2=array(
													'mc_id'=>"$id",
													'tool_id'=>"$tool_id[$i]",
													'lenght'=>"$lenght[$i]",
													'update_by'=>"$user_email",
													'update_date'=>"$today",
												);
									$where2=array('mc_tool_id'=>"$machine_pro_tool_target_id2");   
									$this->Mymodel->update('machine_pro_tool_target',$data2,$where2);
								}//update
								else
								{
									$data2=array();
									$data2=array(
													'mc_id'=>"$id",
													'tool_id'=>"$tool_id[$i]",
													'lenght'=>"$lenght[$i]",
													'save_by'=>"$user_email",
													'save_date'=>"$today",
												);
									$this->Mymodel->insertdata('machine_pro_tool_target',$data2);
								}//new
							}//if($lenght[$i]>0)
						}//for
				}//no of row
				
				
				//-------------------------------------------------update wet_mc_wire_details
				$where2=array('mc_id'=>"$id");   
				$this->Mymodel->deletedata('machine_pro_eff_target',$where2);
				//---------------------------------------------------------max length
				if($id>0)
				{
					for($i=0;$i<$no_of_row2;$i++)
					{
						if($qunt[$i]>0)
						{
							$data2=array();
							$data2=array(
											'mc_id'=>"$id",
											'product_id'=>"$goods[$i]",
											'total_hour'=>"$hours[$i]",
											'total_pro'=>"$qunt[$i]",
											'pro_eff'=>"$eff[$i]",
											'save_by'=>"$user_email",
											'save_date'=>"$today",
										);
							$this->Mymodel->insertdata('machine_pro_eff_target',$data2);
						}//amount
					}//for loop
				}//id
				echo "Update";
			}//not repeat
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
		
		
	}//function close
	
	
	
	
	
	
	
	

}//close class