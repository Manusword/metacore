<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ddie extends CI_Controller {

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






	function ddie_no_check()
    {
        if(isset($_REQUEST['die_no']))
        {
            $die_no = $_REQUEST['die_no'];
            $out=$this->Ddiemodel->get_die_data_with_dieno($die_no);
            if(!empty($out) and count($out)>0)
            {
                $p= $out[0]['pname'].' ('.$out[0]['pcode'].')';
                echo $die_no." Already Exists. Manufacturing: ".$out[0]['menu_no'].", Size:".$out[0]['size'].', Pallet:'.$p.', Location:'.$out[0]['location'];
            }//state code 
        }//get id
    }//function close 


	function ddie_no_check2()
	  {
		if(isset($_REQUEST['die_no']))
		{
			$die_no = $_REQUEST['die_no'];
			$out=$this->Ddiemodel->get_die_data_with_dieno($die_no);
			if(!empty($out) and count($out)>0)
			{
				//--------------------------------------------get pallet
				$p= $out[0]['pname'].' ('.$out[0]['pcode'].')';
				$mc_name= $out[0]['mname'];
				echo $out[0]['id'].'~'.$out[0]['menu_no'].'~'.$out[0]['size'].'~'.$p.'~'.$out[0]['location'].'~'.$mc_name.'~'.$out[0]['mc_id'];
			}//state code 
			else
			{
				echo 0;
			}
		}//get id
	  }//function close 



	function get_today_die_history_list()
	{
		$today = date("Y-m-d");
		$date2 = $this->Base->change_date_dmy($today);
		$out = $this->Ddiemodel->get_today_die_history_list($today);
		?>
				<h3 align="center"><?php echo $date2;?> History</h3>
				<table class="table-hover" border=1 width="100%" id="printed_table">
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Die Type</th>
							<th>Die No</th>
							<th>Manufacturing No</th>
							<th>Pallet</th>
							<th>Current Size</th>
							<th>Location</th>
							<th>Machine</th>
						</tr>
					
					<?php 
					$i=1;
					foreach($out as $r)
					{
						if(isset($r['entry_date'])){$entry_date=$this->Base->change_date_dmy($r['entry_date']);}else{$entry_date='';}
						if($r['location'] == 'Stock'){
							$color="green";
						}
						elseif($r['location'] == 'M/C'){
							$color="red";
						}
						elseif($r['location'] == 'Repair'){
							$color="blue";
						}
						else{
							$color="";
						}
						?>
							<tr>
								<td><?php echo $i;?>.</td>
								<td><?php echo $entry_date;?></td>
								<td align="center"><?php if(isset($r['die_type']))echo $r['die_type'];?></td>
								<td><?php if(isset($r['die_no']))echo $r['die_no'];?></td>
								<td><?php if(isset($r['menu_no']))echo $r['menu_no'];?></td>
								<td><?php if(isset($r['pname']))echo $r['pname'];?></td>
								<td><?php if(isset($r['size']))echo $r['size'];?></td>
								<td style="font-weight:bold;color:<?php echo $color;?>"><?php if(isset($r['location']))echo $r['location'];?></td>
								<td><?php if(isset($r['mname']))echo $r['mname'];?></td>
							</tr>
						<?php
						$i++; 
					}
					?>
				
				</table>
			
		<?php
	}//function close 

   
 

	






















	//-------------------------------------------------------NEW DIE ENTRY
	public function new_die_entry()
	{
		$result['die']=$this->Base->get_ddie_pallet();
		$result['mc']=$this->Base->get_all_machine();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Ddiemodel->get_die_data_with_id($id);
			
		}//strlen
		$this->load->view('die/entry',$result);
	}//function close


	
	
	public function new_die_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['entry_date'])){$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date=date('Y-m-d');}
		if(isset($_REQUEST['die_type'])){$die_type=$_REQUEST['die_type'];}else{$die_type='';}
		if(isset($_REQUEST['die_no'])){$die_no=$_REQUEST['die_no'];}else{$die_no='';}
		if(isset($_REQUEST['menu_no'])){$menu_no=$_REQUEST['menu_no'];}else{$menu_no='';}
		if(isset($_REQUEST['size'])){$size=$_REQUEST['size'];}else{$size='';}
		if(isset($_REQUEST['pallet'])){$pallet=$_REQUEST['pallet'];}else{$pallet='';}
		if(isset($_REQUEST['location'])){$location=$_REQUEST['location'];}else{$location='Stock';}
		if(isset($_REQUEST['mc'])){$mc=$_REQUEST['mc'];}else{$mc='0';}
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['die_no']))
		{
			$die_no=$_REQUEST['die_no'];
			$out=$this->Ddiemodel->get_die_data_with_dieno($die_no);
            if(!empty($out) and count($out)>0)
            {
                $p= $out[0]['pname'].' ('.$out[0]['pcode'].')';
                echo $die_no." Already Exists. Manufacturing: ".$out[0]['menu_no'].", Size:".$out[0]['size'].', Pallet:'.$p.', Location:'.$out[0]['location'];
            }//state code 
			else
			{
				$data=array(
								'entry_date'=>"$entry_date",
								'die_no'=>"$die_no",
								'die_type'=>"$die_type",
								'menu_no'=>"$menu_no",
								'size'=>"$size",
								'pallet_id'=>"$pallet",
								'location'=>"$location",
								'mc_id'=>"$mc",
								're_mc_no'=>"0",
								
								'save_by'=>"$user_email",
								'save_date'=>"$today",
							);
				$ddie_id=$this->Mymodel->insertdata_withid('ddie',$data);
				if($ddie_id>0)
				{
					$data2=array(
									'entry_date'=>"$entry_date",
									'ddie_id'=>"$ddie_id",
									'size'=>"$size",
									'location'=>"$location",
									'mc_id'=>"$mc",
									're_mc_no'=>"0",
									'is_it_new'=>"1",
									
									'save_by'=>"$user_email",
									'save_date'=>"$today",
							);
					$ddie_id=$this->Mymodel->insertdata('ddie_his',$data2);
				}
				echo "Save";
			}//die no 
			
		}//insert
		
		
		
		
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['die_no']))
		{
			$die_no=$_REQUEST['die_no'];
			$res_chk=$this->Ddiemodel->get_die_data_with_dieno($die_no);
			if(!empty($res_chk) and count($res_chk)>0){$id2=$res_chk[0]['id'];}
			if(!empty($id2) and $id!=$id2)
			{
				echo "Not Save. $die_no Die NO Already Available";
			}
			else
			{
				$data=array(
								'entry_date'=>"$entry_date",			
								'die_no'=>"$die_no",
								'die_type'=>"$die_type",
								'menu_no'=>"$menu_no",
								'size'=>"$size",
								'pallet_id'=>"$pallet",
								'location'=>"$location",
								'mc_id'=>"$mc",
								're_mc_no'=>"0",
								
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
				$where=array('id'=>"$id");   
				$this->Mymodel->update('ddie',$data,$where);
				//----------------------------------------------------history
				$data2=array(
								'entry_date'=>"$entry_date",			
								'ddie_id'=>"$id",
								'size'=>"$size",
								'location'=>"$location",
								'mc_id'=>"$mc",
								're_mc_no'=>"0",
								
								'save_by'=>"$user_email",
								'save_date'=>"$today",
								'reset'=>"1",
							);
				$ddie_id=$this->Mymodel->insertdata('ddie_his',$data2);
				echo "Update";
			}
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
		
	}//functon close




	
	public function new_die_list()
	{
		$result['die']=$this->Base->get_ddie_pallet();
		$result['mc']=$this->Base->get_all_machine();
		if(isset($_REQUEST['search1']))
		{
			$where = "  ";
			if(!empty($_REQUEST['mc'])){$mc=$_REQUEST['mc'];$where.=" and  A.mc_id='$mc'   ";}
			if(!empty($_REQUEST['pallet'])){$pallet=$_REQUEST['pallet'];$where.=" and  A.pallet_id='$pallet'   ";}
			if(!empty($_REQUEST['die_no'])){$die_no=$_REQUEST['die_no'];$where.=" and  A.die_no='$die_no'   ";}
			if(!empty($_REQUEST['size'])){$size=$_REQUEST['size'];$where.=" and  A.size='$size'   ";}
			if(!empty($_REQUEST['menu_no'])){$menu_no=$_REQUEST['menu_no'];$where.=" and  A.menu_no='$menu_no'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER by A.entry_date,A.die_no ";
			
			$result['res2'] = $this->Ddiemodel->get_die_data_with_dieno_search($where);
			$this->load->view('die/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-d');
			$search_date2= date('Y-m-d');
			$where = "  and A.entry_date between '$search_date1' and '$search_date2'  ORDER BY A.entry_date,A.die_no   ";
			$result['res2'] = $this->Ddiemodel->get_die_data_with_dieno_search($where);
			$this->load->view('die/show',$result);
		}//search
	}//function close



	//size wise
	public function new_die_list_size_machine_wise()
	{
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['location'])){$location=$_REQUEST['location'];}else{$location="Stock";}
			if(!empty($_REQUEST['group_wise'])){$group_wise=$_REQUEST['group_wise'];}else{$group_wise="size";}
			
			if($group_wise == 'Size Wise')
			{
				$this->Ddiemodel->get_all_die_group_by_size($location);
			}
			elseif($group_wise == 'Machine Wise')
			{
				$this->Ddiemodel->get_all_die_group_by_machine($location);
			}
		}
		else
		{
			$result['location'] = "M/C";
			$result['group_wise'] = "Size Wise";
			$this->load->view('die/show2',$result);
		}//search
		
	}//function close
	









































































	//-------------------------------------------------------DIE ISSUE RETURN
	public function die_issue()
	{
		//$result['die']=$this->Base->get_ddie_pallet();
		$result['mc']=$this->Base->get_all_machine();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Ddiemodel->get_die_data_with_id($id);
			
		}//strlen
		$this->load->view('die/issue/entry',$result);
	}//function close

	
	public function die_issue_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(!empty($_REQUEST['id']) and !empty($_REQUEST['new_location']))
		{
			$id=$_REQUEST['id'];
			if(isset($_REQUEST['entry_date'])){
				$entry_date2=$_REQUEST['entry_date'];
				$entry_date1=explode('-',$entry_date2);
				$entry_date=$entry_date1[2].'-'.$entry_date1[1].'-'.$entry_date1[0];
			}else{$entry_date=$today;}
			$die_no=$_REQUEST['die_no'];
			$old_location=$_REQUEST['old_location'];
			$old_size=$_REQUEST['old_size'];
			
			if(isset($_REQUEST['new_location'])){$new_location=$_REQUEST['new_location'];}else{$new_location='';}
			if(isset($_REQUEST['new_size'])){$new_size=$_REQUEST['new_size'];}else{$new_size='';}
			if(isset($_REQUEST['new_mc'])){$new_mc=$_REQUEST['new_mc'];}else{$new_mc='';}

			if($new_location == 'Stock')
			{
				$size = $new_size;
				$mc_id = 0;
			}
			else if($new_location == 'M/C')
			{
				$size = $old_size;
				$mc_id = $new_mc;
			}
			else if($new_location == 'Repair')
			{
				$size = $new_size;
				$mc_id = 0;
			}
			else
			{
				echo "Not save. No Data Found";
				exit;
			}

			//update main die table
			$where=array('id'=>"$id");
			$data=array(
							'size'=>"$size",
							'location'=>"$new_location",
							'mc_id'=>"$mc_id",
							'entry_date'=>"$entry_date",
							'update_by'=>"$user_email",
							'update_date'=>"$today",
						);
			$ddie_id=$this->Mymodel->update('ddie',$data,$where);
			
			//history	
			$data2=array(
							'ddie_id'=>"$id",
							'size'=>"$size",
							'location'=>"$new_location",
							'mc_id'=>"$mc_id",
							'entry_date'=>"$entry_date",
							'save_by'=>"$user_email",
							'save_date'=>"$today",
						);
			$this->Mymodel->insertdata('ddie_his',$data2);
			echo "Save";
		}//if id
		else
		{
			echo "Not save. No Data Found";
			//redirect('Ddie/die_issue/new/2');
		}
		
	}//functon close
	

	

	//issue search
	public function issue_list()
	{
		$location = "M/C";
		$result['location'] = $location;
		$result['search_for'] = "Issue";
		
		
		
		$result['die']=$this->Base->get_ddie_pallet();
		$result['mc']=$this->Base->get_all_machine();
		
		$search_date1= date('Y-m-d');
		$search_date2= date('Y-m-d');
		
		$where = " and  H.location='$location' and H.entry_date between '$search_date1' and '$search_date2'  ORDER BY H.id DESC  ";
		$result['res2'] = $this->Ddiemodel->get_die_history_with_search($where);
		$this->load->view('die/issue/show',$result);
	}//function close


	//return search
	public function return_list()
	{
		$location = "Repair";
		$result['location'] = $location;
		$result['search_for'] = "Return";
		
		$result['die']=$this->Base->get_ddie_pallet();
		$result['mc']=$this->Base->get_all_machine();
		
		$search_date1= date('Y-m-d');
		$search_date2= date('Y-m-d');
		
		$where = " and  H.location='$location' and H.entry_date between '$search_date1' and '$search_date2'  ORDER BY H.id DESC  ";
		$result['res2'] = $this->Ddiemodel->get_die_history_with_search($where);
		$this->load->view('die/issue/show',$result);
	}//function close


	//return search
	public function stock_list()
	{
		$location = "Stock";
		$result['location'] = $location;
		$result['search_for'] = "Stock";
	
		$result['die']=$this->Base->get_ddie_pallet();
		$result['mc']=$this->Base->get_all_machine();
		
		$search_date1= date('Y-m-d');
		$search_date2= date('Y-m-d');
		
		$where = " and  H.location='$location' and H.entry_date between '$search_date1' and '$search_date2'  ORDER BY H.id DESC  ";
		$result['res2'] = $this->Ddiemodel->get_die_history_with_search($where);
		$this->load->view('die/issue/show',$result);
	}//function close


	//return search
	public function scrap_list()
	{
		$location = "Scrap";
		$result['location'] = $location;
		$result['search_for'] = "Scrap";
		
		$result['die']=$this->Base->get_ddie_pallet();
		$result['mc']=$this->Base->get_all_machine();
		
		$search_date1= date('Y-m-d');
		$search_date2= date('Y-m-d');
		
		$where = " and  H.location='$location' and H.entry_date between '$search_date1' and '$search_date2'  ORDER BY H.id DESC  ";
		$result['res2'] = $this->Ddiemodel->get_die_history_with_search($where);
		$this->load->view('die/issue/show',$result);
	}//function close


	//return search
	public function new_list()
	{
		$location = "Scrap";
		$result['location'] = $location;
		$result['search_for'] = "Scrap";
		
		$result['die']=$this->Base->get_ddie_pallet();
		$result['mc']=$this->Base->get_all_machine();
		
		$search_date1= date('Y-m-d');
		$search_date2= date('Y-m-d');
		
		$where = " and  H.location='$location' and H.entry_date between '$search_date1' and '$search_date2'  ORDER BY H.id DESC  ";
		$result['res2'] = $this->Ddiemodel->get_die_history_with_search($where);
		$this->load->view('die/issue/show',$result);
	}//function close




	public function issue_return_search_list()
	{
		$result['die']=$this->Base->get_ddie_pallet();
		$result['mc']=$this->Base->get_all_machine();
		if(isset($_REQUEST['search1']))
		{
			$where = "  ";
			if(!empty($_REQUEST['die_no'])){$die_no=$_REQUEST['die_no'];$where.=" and  A.die_no='$die_no'   ";}
			if(!empty($_REQUEST['menu_no'])){$menu_no=$_REQUEST['menu_no'];$where.=" and  A.menu_no='$menu_no'   ";}
			if(!empty($_REQUEST['pallet'])){$pallet=$_REQUEST['pallet'];$where.=" and  A.pallet_id='$pallet'   ";}
			if(!empty($_REQUEST['mc'])){$mc=$_REQUEST['mc'];$where.=" and  H.mc_id='$mc'   ";}
			if(!empty($_REQUEST['size'])){$size=$_REQUEST['size'];$where.=" and  H.size='$size'   ";}
			if(!empty($_REQUEST['location'])){$location=$_REQUEST['location'];$where.=" and  H.location='$location'   ";}
			if(isset($_REQUEST['is_it_new']) and $_REQUEST['is_it_new'] != 'All'){$is_it_new=$_REQUEST['is_it_new'];$where.=" and  H.is_it_new='$is_it_new' ";}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and H.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER BY H.id DESC ";
			
			$result['res2'] = $this->Ddiemodel->get_die_history_with_search($where);
			$this->load->view('die/issue/show_table',$result);
		}
	}//function close



	//-------------------------------------------------------Die Ledger
	public function die_ledger()
	{
		$result = "";
		if(isset($_REQUEST['search1']) and !empty($_REQUEST['die_no']))
		{
			$die_no=$_REQUEST['die_no'];
			$this->Ddiemodel->die_ledger($die_no);
		}//strlen
		else{
			$this->load->view('die/die_ledger',$result);
		}
		
	}//function close





















	
		
	
	
	
	
		
	
	
	  
	  
	  
	  
	  
	  
	  
	  
	

	

}//close class