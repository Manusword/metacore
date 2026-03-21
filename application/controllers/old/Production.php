<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Production extends CI_Controller {

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



	
	//get last production entry on this mahcine
	public function fun_get_last_machine_details()
	{
		if(isset($_REQUEST['mc_id']))
		{
			$mc_id = $_REQUEST['mc_id'];
			$result = $this->Productionmodel->fun_get_last_machine_production($mc_id);
			if(!empty($result)){
				echo $result[0]['mc_speed'].'~'.
				$result[0]['in_product_id'].'~'.
				$result[0]['grade'].'~'.
				$result[0]['product_type'].'~'.
				$result[0]['out_product_id'].'~'.
				$result[0]['unit_id'].'~'.
				$result[0]['bname'].'~'.
				$result[0]['cname'];
			}
		}//strlen
	}//function close
	
	public function fun_get_last_machine_details_rope()
	{
		if(isset($_REQUEST['mc_id']) and isset($_REQUEST['size']))
		{
			$mc_id = $_REQUEST['mc_id'];
			$size = $_REQUEST['size'];

			$result = $this->Productionmodel->fun_get_last_machine_production_rope($mc_id,$size);
			if(!empty($result)){
				print_r($result);
				echo '~'.$result[0]['operation'].'~'.
				$result[0]['construction'].'~'.
				$result[0]['grade'].'~'.
				$result[0]['wt_mt'].'~'.
				$result[0]['mc_speed'].'~'.
				$result[0]['pitch'].'~'.
				$result[0]['line_speed'].'~'.
				$result[0]['mc_capacity'].'~'.
				$result[0]['target'];
			}
		}//strlen
	}//function close



	//update all eff
	public function update_eff()
	{
		$sql = "SELECT A.*,
		C.name as out_product_name,C.size as out_size 
		FROM production_entry as A 
		LEFT JOIN product as C ON C.product_id = A.out_product_id  
		WHERE A.production_id !='' ";
        $query = $this->db->query($sql);
        $res = $query->result_array();
        //print_r($res);
		foreach($res as $r)
		{
			$id = $r['production_id'];
			$running_hours_1 = (float)$r['shift_hours1']-(float)$r['down_total_time1'];
			$running_hours_2 = (float)$r['shift_hours2']-(float)$r['down_total_time2'];
			$effi1 = $this->Base->get_eff($r['qty1'],$r['out_size'],$r['mc_speed'],'A',$running_hours_1);
			$effi2 = $this->Base->get_eff($r['qty2'],$r['out_size'],$r['mc_speed'],'B',$running_hours_2);
			//echo $eff3 = $this->Base->get_per($eff1,$eff2);
			if($effi2>0){if($effi1>0){$total_eff = round(($effi1 + $effi2)/2);}else{$total_eff = $effi2;}  }else{$total_eff = $effi1;}
		
			//update
			$data=array(
						'effi1'=>"$effi1",
						'effi2'=>"$effi2",
						'total_eff'=>"$total_eff",
					);
			$where=array('production_id'=>"$id");   
			$this->Mymodel->update('production_entry',$data,$where);
		}
		echo "done";
	}//function close



	

	//add /edit new production
	public function add()
	{
		$result['dept'] = $this->Base->get_all_production_dept();
		$result['unit'] = $this->Base->get_all_unit();
		$result['grade'] = $this->Base->get_all_grade();
		$result['product_type'] = $this->Base->get_all_product_type();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Productionmodel->get_production_data_with_id($id);
		}//strlen
		$this->load->view('production/entry',$result);
	}//function close

	

	//add /edit new production
	public function rope_pro_add()
	{
		//$result['dept'] = $this->Base->get_all_production_dept();
		$result['machine'] = $this->Machinemodel->fun_get_machine_form_dept_id(11);
		$result['unit'] = $this->Base->get_all_unit();
		$result['grade'] = $this->Base->get_all_grade();
		$result['product_type'] = $this->Base->get_all_product_type();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Productionmodel->get_rope_production_data_with_id($id);
		}//strlen
		$this->load->view('production/rope/entry',$result);
	}//function close


	
	//list search
	public function list()
	{
		$result['dept'] = $this->Base->get_all_production_dept();
		$result['unit'] = $this->Base->get_all_unit();
		$result['grade'] = $this->Base->get_all_grade();
		$result['product_type'] = $this->Base->get_all_product_type();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  J.department_id ='$dept'   ";}
			if(!empty($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];$where.=" and  A.mc_id='$mc_no'   ";}
			if(!empty($_REQUEST['base_id'])){$base_id=$_REQUEST['base_id'];$where.=" and  A.in_product_id='$base_id'   ";}
			if(!empty($_REQUEST['finish_id'])){$finish_id=$_REQUEST['finish_id'];$where.=" and  A.out_product_id='$finish_id'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.grade='$grade'   ";}
			if(!empty($_REQUEST['product_type'])){$product_type=$_REQUEST['product_type'];$where.=" and  A.product_type='$product_type'   ";}
			if(!empty($_REQUEST['down_type'])){$down_type=$_REQUEST['down_type'];$where.=" and  (A.down_type1='$down_type' OR  A.down_type2='$down_type')  ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER by A.entry_date,I.name ASC ";
			$result['fdate']=$search_date1;
			$result['tdate']=$search_date2;
			$result['res2'] = $this->Productionmodel->get_all_production_with_search($where);
			$this->load->view('production/show_table',$result);
		}
		else
		{
			$search_date = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			$result['fdate']=$search_date;
			$result['tdate']=$search_date;
			$where=" and A.entry_date = '$search_date'  ORDER by A.entry_date,I.name ASC ";
			$result['res2']=$this->Productionmodel->get_all_production_with_search($where);
			$this->load->view('production/show',$result);
			
		}//search
	}//function close


	//Rope list search
	public function ropelist()
	{
		//$result['dept'] = $this->Base->get_all_production_dept();
		$result['machine'] = $this->Machinemodel->fun_get_machine_form_dept_id(11);
		$result['unit'] = $this->Base->get_all_unit();
		$result['grade'] = $this->Base->get_all_grade();
		$result['product_type'] = $this->Base->get_all_product_type();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['shift1'])){$shift1=$_REQUEST['shift1'];$where.=" and  A.shift1 ='$shift1'   ";}
			if(!empty($_REQUEST['type'])){$type=$_REQUEST['type'];$where.=" and  A.type ='$type'   ";}
			if(!empty($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];$where.=" and  A.mc_id='$mc_no'   ";}
			if(!empty($_REQUEST['dept_type'])){$dept_type=$_REQUEST['dept_type'];$where.=" and  I.type ='$dept_type'   ";}
			if(!empty($_REQUEST['size'])){$size=$_REQUEST['size'];$where.=" and  A.size='$size'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.grade='$grade'   ";}
			if(!empty($_REQUEST['operation'])){$operation=$_REQUEST['operation'];$where.=" and  A.operation='$operation'   ";}
			if(!empty($_REQUEST['construction'])){$construction=$_REQUEST['construction'];$where.=" and  A.construction='$construction'   ";}
			if(!empty($_REQUEST['down_type'])){$down_type=$_REQUEST['down_type'];$where.=" and  A.down_type1='$down_type'   ";}
			if(!empty($_REQUEST['operator'])){$operator=$_REQUEST['operator'];$where.=" and  A.operator1='$operator'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}else{
				$search_date1 = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
				$search_date2 =$search_date1;
			}
			$where.="  ORDER by A.entry_date,A.shift1,I.type,I.name ASC ";
			$result['res2'] = $this->Productionmodel->get_all_rope_production_with_search($where);
			

			//group by
			$result['res_shift'] = $this->Productionmodel->rope_production_groupby_shift('Rope',$search_date1,$search_date2);
			$result['res_mc'] = $this->Productionmodel->rope_production_groupby_mc('Rope',$search_date1,$search_date2);
			$result['res_size'] = $this->Productionmodel->rope_production_groupby_size('Rope',$search_date1,$search_date2);
			$result['res_op'] = $this->Productionmodel->rope_production_groupby_op('Rope',$search_date1,$search_date2);
			$result['res_con'] = $this->Productionmodel->rope_production_groupby_con('Rope',$search_date1,$search_date2);
			$result['res_grade'] = $this->Productionmodel->rope_production_groupby_grade('Rope',$search_date1,$search_date2);
			$result['res_opman'] = $this->Productionmodel->rope_production_groupby_opman('Rope',$search_date1,$search_date2);
			$result['res_helman'] = $this->Productionmodel->rope_production_groupby_helman('Rope',$search_date1,$search_date2);
			
			$this->load->view('production/rope/show_table',$result);
		}
		else
		{
			$search_date = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			$where=" and A.entry_date = '$search_date' and I.type ='Rope'   ORDER by A.entry_date,A.shift1,I.type,I.name ASC ";
			$result['res2']=$this->Productionmodel->get_all_rope_production_with_search($where);
			
			//group by
			$result['res_shift'] = $this->Productionmodel->rope_production_groupby_shift('Rope',$search_date,$search_date);
			$result['res_mc'] = $this->Productionmodel->rope_production_groupby_mc('Rope',$search_date,$search_date);
			$result['res_size'] = $this->Productionmodel->rope_production_groupby_size('Rope',$search_date,$search_date);
			$result['res_op'] = $this->Productionmodel->rope_production_groupby_op('Rope',$search_date,$search_date);
			$result['res_con'] = $this->Productionmodel->rope_production_groupby_con('Rope',$search_date,$search_date);
			$result['res_grade'] = $this->Productionmodel->rope_production_groupby_grade('Rope',$search_date,$search_date);
			$result['res_opman'] = $this->Productionmodel->rope_production_groupby_opman('Rope',$search_date,$search_date);
			$result['res_helman'] = $this->Productionmodel->rope_production_groupby_helman('Rope',$search_date,$search_date);
			//print_r($result['res_shift']);
			
			
			$this->load->view('production/rope/show',$result);
		}//search
	}//function close


	//liest2 search
	public function list2()
	{
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['search_date1']))
			{
				$search_date= $this->Base->change_date_ymd($_REQUEST['search_date1']);
			}
			else
			{
				$search_date = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			}
			$this->Productionmodel->create_production_report_on_date($search_date);
		}
		else
		{
			$result['search_date'] = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			$this->load->view('production/show2',$result);
		}//search
	}//function close


	


	public function save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		//if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}else{$dept='';}
		if(isset($_REQUEST['entry_date'])){$entry_date=$this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date='';}
		if(isset($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];}else{$mc_no='';}
		if(isset($_REQUEST['mc_speed'])){$mc_speed=$_REQUEST['mc_speed'];}else{$mc_speed='';}
		
		if(isset($_REQUEST['in_item'])){$in_product_id=$_REQUEST['in_item'];}else{$in_product_id='';}
		if(isset($_REQUEST['grade'])){$grade=$_REQUEST['grade'];}else{$grade='';}
		if(isset($_REQUEST['product_type'])){$product_type=$_REQUEST['product_type'];}else{$product_type='';}
		if(isset($_REQUEST['out_item']))
		{
			$out_product_id=$_REQUEST['out_item'];
			$out2 = $this->Productmodel->get_product_data_with_id($out_product_id);
			$out_product_size = $out2[0]['size'];
		}else{$out_product_id='';$out_product_size='';}
		
		if(isset($_REQUEST['unit1'])){$unit1=$_REQUEST['unit1'];}else{$unit1='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		
		if(isset($_REQUEST['shift1'])){$shift1=$_REQUEST['shift1'];}else{$shift1='';}
		if(isset($_REQUEST['shift_hours1'])){$shift_hours1=$_REQUEST['shift_hours1'];}else{$shift_hours1='12';}
		if(isset($_REQUEST['no_of_spool1'])){$no_of_spool1=$_REQUEST['no_of_spool1'];}else{$no_of_spool1='';}
		if(isset($_REQUEST['qty1'])){$qty1=$_REQUEST['qty1'];}else{$qty1='';}
		if(isset($_REQUEST['operator1'])){$operator1=$_REQUEST['operator1'];}else{$operator1='';}
		if(isset($_REQUEST['down_type1'])){$down_type1=$_REQUEST['down_type1'];}else{$down_type1='';}
		if(isset($_REQUEST['down_reason1'])){$down_reason1=$_REQUEST['down_reason1'];}else{$down_reason1='';}
		if(isset($_REQUEST['down_total_time1'])){$down_total_time1=$_REQUEST['down_total_time1'];}else{$down_total_time1=0;}

		if(isset($_REQUEST['shift2'])){$shift2=$_REQUEST['shift2'];}else{$shift2='';}
		if(isset($_REQUEST['shift_hours2'])){$shift_hours2=$_REQUEST['shift_hours2'];}else{$shift_hours2='12';}
		if(isset($_REQUEST['no_of_spool2'])){$no_of_spool2=$_REQUEST['no_of_spool2'];}else{$no_of_spool2='';}
		if(isset($_REQUEST['qty2'])){$qty2=$_REQUEST['qty2'];}else{$qty2=0;}
		if(isset($_REQUEST['operator2'])){$operator2=$_REQUEST['operator2'];}else{$operator2='';}
		if(isset($_REQUEST['down_type2'])){$down_type2=$_REQUEST['down_type2'];}else{$down_type2='';}
		if(isset($_REQUEST['down_reason2'])){$down_reason2=$_REQUEST['down_reason2'];}else{$down_reason2='';}
		if(isset($_REQUEST['down_total_time2'])){$down_total_time2=$_REQUEST['down_total_time2'];}else{$down_total_time2='0';}

		if(isset($_REQUEST['helper1'])){$helper1=$_REQUEST['helper1'];}else{$helper1='';}
		if(isset($_REQUEST['running_hours_1'])){$running_hours_1=$_REQUEST['running_hours_1'];}else{$running_hours_1='';}
		
		if(isset($_REQUEST['helper2'])){$helper2=$_REQUEST['helper2'];}else{$helper2='';}
		if(isset($_REQUEST['running_hours_2'])){$running_hours_2=$_REQUEST['running_hours_2'];}else{$running_hours_2='';}

		if(isset($_REQUEST['stage1'])){$stage1=$_REQUEST['stage1'];}else{$stage1='';}
		if(isset($_REQUEST['stage2'])){$stage2=$_REQUEST['stage2'];}else{$stage2='';}

		
		//check input product is real
		if(!empty($this->Productmodel->get_product_data_with_id($in_product_id))){}else{echo "Not Save. Base size not found in Product";exit;}
		//check output product is real
		if(!empty($this->Productmodel->get_product_data_with_id($out_product_id))){}else{echo "Not Save. Finish size not found in Product";exit;}
		
		//check in WIP
		//do function
		
		
		//total qty
		$total_spool = (int)$no_of_spool1 + (int)$no_of_spool2;
		$total_qty = (int)$qty1 + (int)$qty2;


		//get eff of product shift A
		//$effi1 = $this->Machinemodel->calculate_machine_eff($mc_no,$out_product_id,$qty1,$running_hours_1);
		$running_hours_1 = (float)$shift_hours1-(float)$down_total_time1;
		$effi1 = $this->Base->get_eff((int)$qty1,$out_product_size,$mc_speed,'A',$running_hours_1);
		
		//get eff of product shift B
		if($qty2>0)
		{
			//$effi2 = $this->Machinemodel->calculate_machine_eff($mc_no,$out_product_id,$qty2,$running_hours_2);
			$running_hours_2 = (float)$shift_hours2-(float)$down_total_time2;
			$effi2 = $this->Base->get_eff((int)$qty2,$out_product_size,$mc_speed,'B',$running_hours_2);
			//if($effi2>0){if($effi1>0){$total_eff = round(($effi1 + $effi2)/2);}else{$total_eff = $effi2;}  }else{$total_eff = $effi1;}
		}
		else
		{
			$effi2 = 0;
			//$total_eff = $effi1; 
		}


		// Calculate total_eff
		if ($effi1 > 0 && $effi2 > 0) {
			$total_eff = round(($effi1 + $effi2) / 2);
		} else {
			$total_eff = max($effi1, $effi2, 0);
		}

		

		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['mc_no']))
		{
			$data=array(
						'entry_date'=>"$entry_date",
						'mc_id'=>"$mc_no",
						'mc_speed'=>"$mc_speed",
						'in_product_id'=>"$in_product_id",
						'grade'=>"$grade",
						'product_type'=>"$product_type",
						'out_product_id'=>"$out_product_id",
						'unit_id'=>"$unit1",
						'remarks'=>"$remarks",
						
						'shift1'=>"$shift1",
						'shift_hours1'=>"$shift_hours1",
						'no_of_spool1'=>"$no_of_spool1",
						'qty1'=>"$qty1",
						'operator_id_1'=>"$operator1",
						'down_type1'=>"$down_type1",
						'down_reason1'=>"$down_reason1",
						'down_total_time1'=>"$down_total_time1",
						'effi1'=>"$effi1",
						
						'shift2'=>"$shift2",
						'shift_hours2'=>"$shift_hours2",
						'no_of_spool2'=>"$no_of_spool2",
						'qty2'=>"$qty2",
						'operator_id_2'=>"$operator2",
						'down_type2'=>"$down_type2",
						'down_reason2'=>"$down_reason2",
						'down_total_time2'=>"$down_total_time2",
						'effi2'=>"$effi2",

						'helper1'=>"$helper1",
						'running_hours_1'=>"$running_hours_1",
						'helper2'=>"$helper2",
						'running_hours_2'=>"$running_hours_2",
						
						'total_spool'=>"$total_spool",
						'total_qty'=>"$total_qty",
						'total_eff'=>"$total_eff",
						
						'stage1'=>"$stage1",
						'stage2'=>"$stage2",
						
						
						'save_by'=>"$user_email",
						'save_date'=>"$today",
					);
			$production_id = $this->Mymodel->insertdata_withid('production_entry',$data);	
			/* 
			//Update machine tool life
			//Update WIP
			$this->Wip->wip_sub($in_product_id,$in_lotno,$grade,$qty,$in_item_size,$unit1);//sub	
			
			$wip_id=$this->Wip->wip_save_from_issue($out_product_id,$out_lotno,$grade,$qty,$out_item_size,$unit1);//add	
			if($wip_id>0)
			{
				$data=array(
								'stage'=>"$stage",
							);
				$where3=" wip_id='$wip_id' ";
				$this->db->update('wip_wire',$data,$where3);
			}
			*/
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['mc_no']))
		{
			$data=array(
						'entry_date'=>"$entry_date",
						'mc_id'=>"$mc_no",
						'mc_speed'=>"$mc_speed",
						'in_product_id'=>"$in_product_id",
						'grade'=>"$grade",
						'product_type'=>"$product_type",
						'out_product_id'=>"$out_product_id",
						'unit_id'=>"$unit1",
						'remarks'=>"$remarks",
						
						'shift1'=>"$shift1",
						'shift_hours1'=>"$shift_hours1",
						'no_of_spool1'=>"$no_of_spool1",
						'qty1'=>"$qty1",
						'operator_id_1'=>"$operator1",
						'down_type1'=>"$down_type1",
						'down_reason1'=>"$down_reason1",
						'down_total_time1'=>"$down_total_time1",
						'effi1'=>"$effi1",
						
						'shift2'=>"$shift2",
						'shift_hours2'=>"$shift_hours2",
						'no_of_spool2'=>"$no_of_spool2",
						'qty2'=>"$qty2",
						'operator_id_2'=>"$operator2",
						'down_type2'=>"$down_type2",
						'down_reason2'=>"$down_reason2",
						'down_total_time2'=>"$down_total_time2",
						'effi2'=>"$effi2",
						
						'helper1'=>"$helper1",
						'running_hours_1'=>"$running_hours_1",
						'helper2'=>"$helper2",
						'running_hours_2'=>"$running_hours_2",
						
						'total_spool'=>"$total_spool",
						'total_qty'=>"$total_qty",
						'total_eff'=>"$total_eff",

						'stage1'=>"$stage1",
						'stage2'=>"$stage2",
						
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
				$where=array('production_id'=>"$id");   
				$this->Mymodel->update('production_entry',$data,$where);
				echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close



	
	public function rope_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if(isset($_REQUEST['entry_date'])){$entry_date=$this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date='';}
		if(isset($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];}else{$mc_no='';}
		
		if(isset($_REQUEST['shift1'])){$shift1=$_REQUEST['shift1'];}else{$shift1='';}
		if(isset($_REQUEST['size'])){$size=$_REQUEST['size'];}else{$size='';}
		if(isset($_REQUEST['operation'])){$operation=$_REQUEST['operation'];}else{$operation='';}


		if(isset($_REQUEST['construction'])){$construction=$_REQUEST['construction'];}else{$construction='';}
		if(isset($_REQUEST['grade'])){$grade=$_REQUEST['grade'];}else{$grade='';}
		if(isset($_REQUEST['wt_mt'])){$wt_mt=$_REQUEST['wt_mt'];}else{$wt_mt='';}

		if(isset($_REQUEST['mc_speed'])){$mc_speed=$_REQUEST['mc_speed'];}else{$mc_speed='';}
		if(isset($_REQUEST['pitch'])){$pitch=$_REQUEST['pitch'];}else{$pitch='';}
		if(isset($_REQUEST['line_speed'])){$line_speed=$_REQUEST['line_speed'];}else{$line_speed='';}

		if(isset($_REQUEST['mc_capacity'])){$mc_capacity=$_REQUEST['mc_capacity'];}else{$mc_capacity='';}
		if(isset($_REQUEST['target'])){$target=$_REQUEST['target'];}else{$target='';}
		if(isset($_REQUEST['qty_in_meter'])){$qty_in_meter=round($_REQUEST['qty_in_meter'],0);}else{$qty_in_meter='';}
		if(isset($_REQUEST['qty_in_kg'])){$qty_in_kg=$_REQUEST['qty_in_kg'];}else{$qty_in_kg='';}

		if(isset($_REQUEST['shift_hours1'])){$shift_hours1=$_REQUEST['shift_hours1'];}else{$shift_hours1='';}
		
		if(isset($_REQUEST['operator1'])){$operator1=$_REQUEST['operator1'];}else{$operator1='';}
		if(isset($_REQUEST['helper1'])){$helper1=$_REQUEST['helper1'];}else{$helper1='';}
		if(isset($_REQUEST['down_type1'])){$down_type1=$_REQUEST['down_type1'];}else{$down_type1='';}
		if(isset($_REQUEST['down_reason1'])){$down_reason1=$_REQUEST['down_reason1'];}else{$down_reason1='';}
		if(isset($_REQUEST['down_total_time1'])){$down_total_time1=$_REQUEST['down_total_time1'];}else{$down_total_time1=0;}
		if(isset($_REQUEST['running_hours_1'])){$running_hours_1=$_REQUEST['running_hours_1'];}else{$running_hours_1='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		if(isset($_REQUEST['scrap'])){$scrap=$_REQUEST['scrap'];}else{$scrap='';}
		if(isset($_REQUEST['eff1'])){$eff1=$_REQUEST['eff1'];}else{$eff1='';}
		if(isset($_REQUEST['type'])){$type=$_REQUEST['type'];}else{$type='';}
		
		
		//eff
		// if((int)$target > 0){
		// 	$get80Per = round(((80/100)*(int)$target),0);
		// 	$eff1 = round((((int)$qty_in_meter*100)/$get80Per),0);
		// }
		// else{
		// 	$eff1 = "";
		// }
		//$qty_in_meter
		
		
		//get eff of product shift A
		//$effi1 = $this->Machinemodel->calculate_machine_eff($mc_no,$out_product_id,$qty1,$running_hours_1);

		// $running_hours_1 = (float)$shift_hours1-(float)$down_total_time1;
		// $effi1 = $this->Base->get_eff((int)$qty1,$out_product_size,$mc_speed,'A',$running_hours_1);
		
		

		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['mc_no']))
		{
			$data=array(
						'entry_date'=>"$entry_date",
						'mc_id'=>"$mc_no",
						
						'shift1'=>"$shift1",
						'size'=>"$size",
						'operation'=>"$operation",

						'construction'=>"$construction",
						'grade'=>"$grade",
						'wt_mt'=>"$wt_mt",

						'mc_speed'=>"$mc_speed",
						'pitch'=>"$pitch",
						'line_speed'=>"$line_speed",

						'mc_capacity'=>"$mc_capacity",
						'target'=>"$target", 
						'qty_in_meter'=>"$qty_in_meter",

						'qty_in_kg'=>"$qty_in_kg",
						'shift_hours1'=>"$shift_hours1",
						
						'operator1'=>"$operator1",
						'type'=>"$type",
						'helper1'=>"$helper1",
						'down_type1'=>"$down_type1",

						'down_reason1'=>"$down_reason1",
						'down_total_time1'=>"$down_total_time1",
						'running_hours_1'=>"$running_hours_1",

						'eff1'=>"$eff1",
						'remarks'=>"$remarks",
						'scrap'=>"$scrap",
						
						
						'save_by'=>"$user_email",
						'save_date'=>"$today",
					);
			$production_id = $this->Mymodel->insertdata_withid('production_entry_rope',$data);	
			/* 
			//Update machine tool life
			//Update WIP
			$this->Wip->wip_sub($in_product_id,$in_lotno,$grade,$qty,$in_item_size,$unit1);//sub	
			
			$wip_id=$this->Wip->wip_save_from_issue($out_product_id,$out_lotno,$grade,$qty,$out_item_size,$unit1);//add	
			if($wip_id>0)
			{
				$data=array(
								'stage'=>"$stage",
							);
				$where3=" wip_id='$wip_id' ";
				$this->db->update('wip_wire',$data,$where3);
			}
			*/
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['mc_no']))
		{
			$data=array(
						'entry_date'=>"$entry_date",
						'mc_id'=>"$mc_no",
						
						'shift1'=>"$shift1",
						'size'=>"$size",
						'operation'=>"$operation",

						'construction'=>"$construction",
						'grade'=>"$grade",
						'wt_mt'=>"$wt_mt",

						'mc_speed'=>"$mc_speed",
						'pitch'=>"$pitch",
						'line_speed'=>"$line_speed",

						'mc_capacity'=>"$mc_capacity",
						'target'=>"$target",   
						'qty_in_meter'=>"$qty_in_meter",

						'qty_in_kg'=>"$qty_in_kg",
						'shift_hours1'=>"$shift_hours1",
						
						'operator1'=>"$operator1",
						'type'=>"$type",
						'helper1'=>"$helper1",
						'down_type1'=>"$down_type1",

						'down_reason1'=>"$down_reason1",
						'down_total_time1'=>"$down_total_time1",
						'running_hours_1'=>"$running_hours_1",

						'eff1'=>"$eff1",
						'remarks'=>"$remarks",
						'scrap'=>"$scrap",
				
						
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
				$where=array('production_id'=>"$id");   
				$this->Mymodel->update('production_entry_rope',$data,$where);
				echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close rope




	//list3 search
	public function list3()
	{
		$result['dept'] = $this->Base->get_all_production_dept();
		
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['dept'])){$dept = $_REQUEST['dept'];}else{$dept = 5;}
			if(!empty($_REQUEST['year'])){$year = $_REQUEST['year'];}else{$year  = date('Y');}
			if(!empty($_REQUEST['month'])){$month = $_REQUEST['month'];}else{$month = date('m');}
			$data = $this->Productionmodel->get_dept_emp_detials($dept,$year,$month);
			//$this->Productionmodel->get_all_production_report($dept,$year,$month);
		}
		else
		{
			$this->load->view('production/show3',$result);
		}//search
	}//function close


	//list4 search
	public function list4()
	{
		$result['dept'] = $this->Base->get_all_production_dept();
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['dept'])){$dept = $_REQUEST['dept'];}else{$dept = 5;}
			if(!empty($_REQUEST['year'])){$year = $_REQUEST['year'];}else{$year  = date('Y');}
			if(!empty($_REQUEST['month'])){$month = $_REQUEST['month'];}else{$month = date('m');}
			//$this->Productionmodel->get_all_production_report2($dept,$year,$month);
			$this->Productionmodel->get_dept_machine_detials($dept,$year,$month);
		}
		else
		{
			$this->load->view('production/show4',$result);
		}//search
	}//function close


	//list5 search
	public function list5()
	{
		$result['dept'] = $this->Base->get_all_production_dept();
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['dept'])){$dept = $_REQUEST['dept'];}else{$dept = 5;}
			if(!empty($_REQUEST['year'])){$year = $_REQUEST['year'];}else{$year  = date('Y');}
			if(!empty($_REQUEST['month'])){$month = $_REQUEST['month'];}else{$month = date('m');}
			if(!empty($_REQUEST['date'])){$date = $_REQUEST['date'];}else{$date = 'ALL';}
			if(!empty($_REQUEST['show_details'])){$show_details = $_REQUEST['show_details'];}else{$show_details = 'Y';}
			$this->Productionmodel->get_all_production_with_man_power_cost($dept,$year,$month,$date,$show_details);
			$this->Productionmodel->get_all_production_with_man_power_cost_monthly($dept,$year,$month,'ALL',$show_details);
		}
		else
		{
			$this->load->view('production/show5',$result);
		}//search
	}//function close








	//add /edit scrap entry
	public function add_scrap()
	{
		$result['dept']=$this->Base->get_scrap_dept();
		$result['grade']=$this->Base->get_all_grade();
		$result['unit']=$this->Base->get_all_unit();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Productionmodel->get_scrap_data_with_id($id);
		}//strlen
		$this->load->view('production/scrap/entry',$result);
	}//function close

	//list search
	public function scrap_list()
	{
		$result['dept']=$this->Base->get_scrap_dept();
		$result['grade']=$this->Base->get_all_grade();
		$result['unit']=$this->Base->get_all_unit();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.dept ='$dept'   ";}
			if(!empty($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];$where.=" and  A.mc_no='$mc_no'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.grade='$grade'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER by A.entry_date,J.name,I.name ASC ";
			$result['res2'] = $this->Productionmodel->get_all_scrap_with_search($where);
			$this->load->view('production/scrap/show_table',$result);
		}
		else
		{
			$search_date = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			$where=" and A.entry_date = '$search_date'  ORDER by A.entry_date,J.name,I.name ASC ";
			$result['res2']=$this->Productionmodel->get_all_scrap_with_search($where);
			$this->load->view('production/scrap/show',$result);
		}//search
	}//function close


	public function scrap_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if(isset($_REQUEST['entry_date'])){$entry_date=$this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date='';}
		if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}else{$dept='';}
		if(isset($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];}else{$mc_no='';}
		if(isset($_REQUEST['grade'])){$grade=$_REQUEST['grade'];}else{$grade='';}
		
		if(isset($_REQUEST['qty1'])){$qty1=$_REQUEST['qty1'];}else{$qty1='';}
		if(isset($_REQUEST['person1'])){$person1=$_REQUEST['person1'];}else{$person1='';}
		if(isset($_REQUEST['unit1'])){$unit1=$_REQUEST['unit1'];}else{$unit1='';}
		if(isset($_REQUEST['shift_inchage1'])){$shift_inchage1=$_REQUEST['shift_inchage1'];}else{$shift_inchage1='';}

		if(isset($_REQUEST['qty2'])){$qty2=$_REQUEST['qty2'];}else{$qty2='';}
		if(isset($_REQUEST['person2'])){$person2=$_REQUEST['person2'];}else{$person2='';}
		if(isset($_REQUEST['unit2'])){$unit2=$_REQUEST['unit2'];}else{$unit2='';}
		if(isset($_REQUEST['shift_inchage2'])){$shift_inchage2=$_REQUEST['shift_inchage2'];}else{$shift_inchage2='';}
		
		$total_scrap = round($qty1+$qty2);
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['dept']))
		{
			$data=array(
						'entry_date'=>"$entry_date",
						'dept'=>"$dept",
						'mc_no'=>"$mc_no",
						'grade'=>"$grade",
						
						'qty1'=>"$qty1",
						'person1'=>"$person1",
						'unit1'=>"$unit1",
						'shift_inchage1'=>"$shift_inchage1",
						
						'qty2'=>"$qty2",
						'person2'=>"$person2",
						'unit2'=>"$unit2",
						'shift_inchage2'=>"$shift_inchage2",
						'total_scrap'=>"$total_scrap",
						
						'save_by'=>"$user_email",
						'save_date'=>"$today",
					);
			$scrap_id=$this->Mymodel->insertdata_withid('scrap_entry',$data);	
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['dept']))
		{
			$data=array(
						'entry_date'=>"$entry_date",
						'dept'=>"$dept",
						'mc_no'=>"$mc_no",
						'grade'=>"$grade",
						
						'qty1'=>"$qty1",
						'person1'=>"$person1",
						'unit1'=>"$unit1",
						'shift_inchage1'=>"$shift_inchage1",
						
						'qty2'=>"$qty2",
						'person2'=>"$person2",
						'unit2'=>"$unit2",
						'shift_inchage2'=>"$shift_inchage2",
						'total_scrap'=>"$total_scrap",
						
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
				$where=array('scrap_id'=>"$id");   
				$this->Mymodel->update('scrap_entry',$data,$where);
				echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close






	//add /edit scrap entry
	public function add_short()
	{
		$result['dept']=$this->Base->get_scrap_dept();
		$result['grade']=$this->Base->get_all_grade();
		$result['unit']=$this->Base->get_all_unit();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2']=$this->Productionmodel->get_short_data_with_id($id);
		}//strlen
		$this->load->view('production/short/entry',$result);
	}//function close

	//list search
	public function short_list()
	{
		$result['dept']=$this->Base->get_scrap_dept();
		$result['grade']=$this->Base->get_all_grade();
		$result['unit']=$this->Base->get_all_unit();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.dept ='$dept'   ";}
			if(!empty($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];$where.=" and  A.mc_no='$mc_no'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.grade='$grade'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ORDER by A.entry_date,J.name,I.name ASC ";
			$result['res2'] = $this->Productionmodel->get_all_short_with_search($where);
			$this->load->view('production/short/show_table',$result);
		}
		else
		{
			$search_date = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			$where=" and A.entry_date = '$search_date'  ORDER by A.entry_date,J.name,I.name ASC ";
			$result['res2']=$this->Productionmodel->get_all_short_with_search($where);
			$this->load->view('production/short/show',$result);
		}//search
	}//function close



	public function short_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
		if(isset($_REQUEST['entry_date'])){$entry_date=$this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date='';}
		if(isset($_REQUEST['dept'])){$dept=$_REQUEST['dept'];}else{$dept='';}
		if(isset($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];}else{$mc_no='';}
		if(isset($_REQUEST['grade'])){$grade=$_REQUEST['grade'];}else{$grade='';}
		
		if(isset($_REQUEST['qty1'])){$qty1=$_REQUEST['qty1'];}else{$qty1='';}
		if(isset($_REQUEST['person1'])){$person1=$_REQUEST['person1'];}else{$person1='';}
		if(isset($_REQUEST['unit1'])){$unit1=$_REQUEST['unit1'];}else{$unit1='';}
		if(isset($_REQUEST['shift_inchage1'])){$shift_inchage1=$_REQUEST['shift_inchage1'];}else{$shift_inchage1='';}

		if(isset($_REQUEST['qty2'])){$qty2=$_REQUEST['qty2'];}else{$qty2='';}
		if(isset($_REQUEST['person2'])){$person2=$_REQUEST['person2'];}else{$person2='';}
		if(isset($_REQUEST['unit2'])){$unit2=$_REQUEST['unit2'];}else{$unit2='';}
		if(isset($_REQUEST['shift_inchage2'])){$shift_inchage2=$_REQUEST['shift_inchage2'];}else{$shift_inchage2='';}
		
		$total_scrap = round($qty1+$qty2);
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['dept']))
		{
			$data=array(
						'entry_date'=>"$entry_date",
						'dept'=>"$dept",
						'mc_no'=>"$mc_no",
						'grade'=>"$grade",
						
						'qty1'=>"$qty1",
						'person1'=>"$person1",
						'unit1'=>"$unit1",
						'shift_inchage1'=>"$shift_inchage1",
						
						'qty2'=>"$qty2",
						'person2'=>"$person2",
						'unit2'=>"$unit2",
						'shift_inchage2'=>"$shift_inchage2",
						'total_scrap'=>"$total_scrap",
						
						'save_by'=>"$user_email",
						'save_date'=>"$today",
					);
			$id=$this->Mymodel->insertdata_withid('short_entry',$data);	
			echo "Save";
		}//insert
		//------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['dept']))
		{
			$data=array(
						'entry_date'=>"$entry_date",
						'dept'=>"$dept",
						'mc_no'=>"$mc_no",
						'grade'=>"$grade",
						
						'qty1'=>"$qty1",
						'person1'=>"$person1",
						'unit1'=>"$unit1",
						'shift_inchage1'=>"$shift_inchage1",
						
						'qty2'=>"$qty2",
						'person2'=>"$person2",
						'unit2'=>"$unit2",
						'shift_inchage2'=>"$shift_inchage2",
						'total_scrap'=>"$total_scrap",
						
						'update_by'=>"$user_email",
						'update_date'=>"$today",
					);
				$where=array('id'=>"$id");   
				$this->Mymodel->update('short_entry',$data,$where);
				echo "Update";
		}
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close




    
    //get all emp eff till date 
	public function fun_get_all_emp_eff_till_date_via_array()
	{
		$from_date = date('2021-01-01');
		$to_date = date('Y-m-d');
		
		$emp_list= array(
        		            1030,3208,3201,1035,3422,3438,
        		            3433,1054,1068,1053,1033,1034,1063,3316,2016,2065,1052,1058,2035,3317,3353,3378,3382,3361,3362,3360,3358,3427,2013,3428,3429
		                );
		
		foreach($emp_list as $e)
		{
		    $eff = $this->Productionmodel->get_emp_ef_till_date($e,$from_date,$to_date);
		    
		    echo $e.', '.$eff.'%<br>'; 
		    
		}//foreach
		
		
	
	    
	    
	    
	}//function close

















	//Production planing--------------------------------------------------------------------------------------------------------------------
	public function plan()
	{
		$result['dept'] = $this->Base->get_all_production_dept();
		$result['unit'] = $this->Base->get_all_unit();
		$result['grade'] = $this->Base->get_all_grade();
		$result['product_type'] = $this->Base->get_all_product_type();
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		if(isset($_REQUEST['search1']))
		{
			
		}
		else
		{
			$result['search_date'] = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			$this->load->view('production/plan/show',$result);
		}//search
	}//function close

	//list search
	public function planlist()
	{
		$result['dept'] = $this->Base->get_all_production_dept();
		$result['unit'] = $this->Base->get_all_unit();
		$result['grade'] = $this->Base->get_all_grade();
		$result['product_type'] = $this->Base->get_all_product_type();
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.dept ='$dept'   ";}
			if(!empty($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];$where.=" and  A.mc_no='$mc_no'   ";}
			if(!empty($_REQUEST['base_id'])){$base_id=$_REQUEST['base_id'];$where.=" and  A.inletSize='$base_id'   ";}
			if(!empty($_REQUEST['finish_id'])){$finish_id=$_REQUEST['finish_id'];$where.=" and  A.outletSize='$finish_id'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.inletGrade='$grade'   ";}
			if(!empty($_REQUEST['product_type'])){$product_type=$_REQUEST['product_type'];$where.=" and  A.outletgrade='$product_type'   ";}
			if(!empty($_REQUEST['status'])){$status=$_REQUEST['status'];$where.=" and  A.status='$status'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.startDateTime >= '$search_date1' and A.startDateTime <= '$search_date2'  ";
			}
			$where.="  ORDER by A.dept,A.mc_no ASC ";
			$result['res2'] = $this->Productionmodel->get_all_plan_with_search($where);
			$this->load->view('production/plan/show_table2',$result);
		}
		else
		{
			//$search_date = $this->Base->add_no_of_days_in_date_ymd(date("Y-m-d"),'-1');
			$where=" and A.status='Pending'  ORDER by A.dept,A.mc_no ASC ";
			$result['res2']=$this->Productionmodel->get_all_plan_with_search($where);
			$this->load->view('production/plan/show2',$result);
		}//search
	}//function close



	//get machine plan
	public function fun_machine_plan()
	{
		if(isset($_REQUEST['mc_id']))
		{
			$mc_id = $_REQUEST['mc_id'];
			$result = $this->Productionmodel->fun_get_machine_running_plan($mc_id);
			if(!empty($result)){
				?>
					<table class="table table-sm" style="margin-top: 10px;" >
						<tr style="background-color: #d4d5d6;">
							<th>Plan Rank</th>
							<th>Inlet - Outlet</th>
							<th>Order Qty</th>
							<th>Prod Qty</th>
							<th>Bal Qty</th>
							<th>Start Date</th>
							<th>End Date</th>
						</tr>
						<?php 
							foreach($result as $r)
							{
								$startDateTime = $this->Base->change_date_dmy_hisa($r['startDateTime']);
								$endDateTime = $this->Base->change_date_dmy_hisa($r['endDateTime']);
								?>
									<tr>
										<td><?php echo $r['planRank'];?></td>
										<td>
											<?php echo $r['in_size'].' - '.$r['out_size'];?>
											<br>
											<?php echo $r['grade_name'].' - '.$r['product_type_name'];?>
										</td>
										<td><?php echo $r['orderQty'];?></td>
										<td><?php echo $r['prodQty'];?></td>
										<td><?php echo $r['balQty'];?></td>
										<td><?php echo $startDateTime;?></td>
										<td><?php echo $endDateTime;?></td>
									</tr>
								<?php
							}
						?>
						<tr>
							<th colspan="8"><input type='radio' checked onclick="radio_function_for_startdate(this.value)" id='planRankRadio' value="end~<?php echo $startDateTime.'~'.$endDateTime;?>"> At End Previous</th>
						</tr>
					</table>
				<?php
			}
		}//strlen
	}//function close



	//get machine plan rank
	public function fun_machine_plan_rank()
	{
		if(isset($_REQUEST['mc_id']))
		{
			$mc_id = $_REQUEST['mc_id'];
			$result = $this->Productionmodel->fun_get_machine_running_plan_rank($mc_id);
			if(!empty($result)){
				echo $result[0]['planRank'];
			}
		}//strlen
	}//function close


	public function newProgramSave() 
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');

		// Get form data from POST request
		$planid = $this->input->post('planid');
		$dept = $this->input->post('dept');
		$mc_no = $this->input->post('mc_no');
		$mcSpeed = $this->input->post('mcSpeed');
		$orderNo = $this->input->post('orderNo'); 
		$planRank = $this->input->post('planRank');
		$oldPlanRank = $this->input->post('oldPlanRank');
		$coating = $this->input->post('coating');
		$inletGrade = $this->input->post('inletGrade');
		$inletSize = $this->input->post('inletSize');
		$outletgrade = $this->input->post('outletgrade');
		$outletSize = $this->input->post('outletSize');
		$reqUTS = $this->input->post('reqUTS');
		$tollness = $this->input->post('tollness');
		$orderQty = $this->input->post('orderQty');
		$prodQty = $this->input->post('prodQty');
		$balQty = $this->input->post('balQty');
		$readingMtr = $this->input->post('readingMtr');
		$oilDry = $this->input->post('oilDry');
		$coilWeight = $this->input->post('coilWeight');
		$currentSpeed = $this->input->post('currentSpeed');
		$pro100Per = $this->input->post('pro100Per');
		$pro75per = $this->input->post('pro75per');
		$partyName = $this->input->post('partyName');
		$useRodList = $this->input->post('useRodList');
		$remarks = $this->input->post('remarks');
		$hoursReq = $this->input->post('hoursReq');
		$oldhoursReq = $this->input->post('oldhoursReq');
		$DaysReq = $this->input->post('DaysReq');
		$oldstartDateTime = $this->input->post('oldstartDateTime');
		$startDateTime = $this->input->post('startDateTime');
		$endDateTime = $this->input->post('endDateTime');
		$status = $this->input->post('status');
	
		
		if(empty($_REQUEST['planid']) and !empty($_REQUEST['mc_no']))
		{
			$data = array(
				'dept' => $dept,
				'mc_no' => $mc_no,
				'mcSpeed' => $mcSpeed,
				'orderNo' => $orderNo,
				'planRank' => $planRank,
				'coating' => $coating,
				'inletGrade' => $inletGrade,
				'inletSize' => $inletSize,
				'outletgrade' => $outletgrade,
				'outletSize' => $outletSize,
				'reqUTS' => $reqUTS,
				'tollness' => $tollness,
				'orderQty' => $orderQty,
				'prodQty' => $prodQty,
				'balQty' => $balQty,
				'readingMtr' => $readingMtr,
				'oilDry' => $oilDry,
				'coilWeight' => $coilWeight,
				'currentSpeed' => $currentSpeed,
				'pro100Per' => $pro100Per,
				'pro75per' => $pro75per,
				'partyName' => $partyName,
				'useRodList' => $useRodList,
				'remarks' => $remarks,
				'hoursReq' => $hoursReq,
				'DaysReq' => $DaysReq,
				'startDateTime' => $startDateTime,
				'endDateTime' => $endDateTime,
				'status' => $status,

				'save_by' => $user_email,
				'save_date' => $today,
			);

			$production_id = $this->Mymodel->insertdata_withid('production_plan',$data);	
			echo "Save";
		}//save
		elseif(!empty($_REQUEST['planid']) and !empty($_REQUEST['mc_no']))
		{
			$data = array(
				'dept' => $dept,
				'mc_no' => $mc_no,
				'mcSpeed' => $mcSpeed,
				'orderNo' => $orderNo,
				'coating' => $coating,
				'inletGrade' => $inletGrade,
				'inletSize' => $inletSize,
				'outletgrade' => $outletgrade,
				'outletSize' => $outletSize,
				'reqUTS' => $reqUTS,
				'tollness' => $tollness,
				'orderQty' => $orderQty,
				'prodQty' => $prodQty,
				'balQty' => $balQty,
				'readingMtr' => $readingMtr,
				'oilDry' => $oilDry,
				'coilWeight' => $coilWeight,
				'currentSpeed' => $currentSpeed,
				'pro100Per' => $pro100Per,
				'pro75per' => $pro75per,
				'partyName' => $partyName,
				'useRodList' => $useRodList,
				'remarks' => $remarks,
				'hoursReq' => $hoursReq,
				'DaysReq' => $DaysReq,
				'startDateTime' => $startDateTime,
				'endDateTime' => $endDateTime,
				'status' => $status,

				'update_by' => $user_email,
				'update_date' => $today,
			);
			$where=array('planid'=>"$planid");   
			$this->Mymodel->update('production_plan',$data,$where);
			
			//if plan chnage
			if($planRank != $oldPlanRank){
				//chnage rank
				$this->Productionmodel->fun_plan_rank_change($mc_no,$oldPlanRank,$planRank);
			}//planRank

			if($hoursReq != $oldhoursReq){
				//chnage rank
				$this->Productionmodel->fun_hoursReq_change($mc_no); // update all date time
			}//planRank

			if($oldstartDateTime != $startDateTime){
				//chnage rank
				$this->Productionmodel->fun_hoursReq_change($mc_no); // update all date time
			}//planRank

			

			echo "Update";
		}//update
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit

		//print_r($data);
		
	}//function close
	



	//get plan model
	public function fun_plan_model()
	{
		$dept = $this->Base->get_all_production_dept();
		$grade = $this->Base->get_all_grade();
		$product_type = $this->Base->get_all_product_type();
		$customer = $this->Customermodel->get_all_active_customer();
		
		if(isset($_REQUEST['planid']))
		{
			$planid =  $_REQUEST['planid'];
			$res2 = $this->Productionmodel->fun_plan_with_id($planid);
		}
		?>
		
				<div class="modal-body">
					<div class="form-row">

						<input type="hidden"  id="planid" value="<?php if(isset($res2[0]['planid']))echo $res2[0]['planid'];?>"  >
						<input type="hidden"  id="oldPlanRank" value="<?php if(isset($res2[0]['planRank']))echo $res2[0]['planRank'];?>"  >
						
						<div class="col-md-2">
							<label >Department </label>
							<select class="form-control" id="dept" onChange="fun_get_machine_form_dept_id(this.value,'mc_no','diff_id')">
								<option value="">Select</option>
									<?php 
									foreach($dept as $d)
									{
									?>
										<option  <?php if(!empty($res2[0]['dept'])){if($res2[0]['dept']==$d['department_id']){echo 'selected';}}?> value="<?php echo $d['department_id'];?>"  ><?php echo $d['name'];?></option>
									<?php 
									}
									?>
							</select>
						</div>

						<div class="col-md-2">
							<label  >M/C</label>
							<select class="form-control" id="mc_no"  onChange="fun_machine_plan(this.value)" >
								<option value="">Select</option>
								<?php 
									if(!empty($res2[0]['dept']) and !empty($res2[0]['mc_no']))
									{
										$machine = $this->Machinemodel->fun_get_machine_form_dept_id($res2[0]['dept']);
										foreach($machine as $m)
										{
										?><option <?php if($m['mc_id'] == $res2[0]['mc_no']){ echo "selected";}?> value="<?php echo $m['mc_id'];?>"><?php echo $m['name'];?></option><?php 
										}
									}
								?>
								</select>
						</div>



						<div class="col-md-2">
							<label>M/C Speed</label>
							<input type="number" class="form-control" id="mcSpeed" value="<?php if(isset($res2[0]['mcSpeed']))echo $res2[0]['mcSpeed'];?>"  autocomplete="off">
						</div>

						<div class="col-md-2">
							<label>Order No.</label>
							<input type="text" class="form-control" id="orderNo" value="<?php if(isset($res2[0]['orderNo']))echo $res2[0]['orderNo'];?>"  autocomplete="off">
						</div>

						<div class="col-md-2">
							<label>Plan Rank</label>
							<select class="form-control" id="planRank">
								<option value="">Select</option>
									<?php 
									for($i=1;$i<=10;$i++)
									{
									?>
										<option  <?php if(!empty($res2[0]['planRank'])){if($res2[0]['planRank']==$i){echo 'selected';}}?> ><?php echo $i;?></option>
									<?php 
									}
									?>
							</select>
						</div>

						<div class="col-md-2">
							<label>Coating</label>
							<select class="form-control" id="coating">
								<option value="">Select</option>
								<option <?php if(isset($res2[0]['coating'])){if($res2[0]['coating']=='Phos+Borax'){echo 'selected';}}?>>Phos+Borax</option>
								<option <?php if(isset($res2[0]['coating'])){if($res2[0]['coating']=='Zinc'){echo 'selected';}}?>>Zinc</option>
							</select>
						</div>


					
						<div class="col-md-12" id='CurrentRuningDis'></div>
						<div class="col-md-12"><hr></div>



						<div class="col-md-2">
							<label>Inlet Grade</label>
							<select class="form-control" id="inletGrade" onchange="getRod()">
								<option value="">Select</option>
								<?php 
								foreach($grade as $u)
								{
									?>
									<option <?php if(isset($res2[0]['inletGrade'])){if($u['id']==$res2[0]['inletGrade']){ echo "selected";}}?> value="<?php echo $u['id'];?>" ><?php echo $u['name'];?></option>
									<?php
								}
								?>
							</select>
						</div>

						<div class="col-md-4" >
							<label>Inlet Size</label>
							<input type="text"    class="form-control"   id="inProductName_" onKeyUp="fun_get_product2(this.id,'inProductName_','inProductId_','inProductSize_')" value="<?php if(isset($res2[0]['in_product_name']))echo $res2[0]['in_product_name'];?>" autocomplete="off" />
							<input type="hidden"    id="inProductId_" value="<?php if(isset($res2[0]['inletSize']))echo $res2[0]['inletSize'];?>"  />
							<input type="hidden"   id="inProductSize_" value="<?php if(isset($res2[0]['in_size']))echo $res2[0]['in_size'];?>"  />
						</div>

						<div class="col-md-4" >
							<label>Outlet Size</label>
							<input type="text"    class="form-control"   id="outProductName_" onKeyUp="fun_get_product2(this.id,'outProductName_','outProductId_','outProductSize_')" value="<?php if(isset($res2[0]['out_product_name']))echo $res2[0]['out_product_name'];?>" autocomplete="off" />
							<input type="hidden"    id="outProductId_" value="<?php if(isset($res2[0]['outletSize']))echo $res2[0]['outletSize'];?>"  />
							<input type="hidden"   id="outProductSize_" value="<?php if(isset($res2[0]['out_size']))echo $res2[0]['out_size'];?>"  />
						</div>


						<div class="col-md-2">
							<label>Outlet Grade</label>
							<select class="form-control" id="outletgrade" onchange="getProductionQty()">
								<option value="">Select</option>
								<?php 
								foreach($product_type as $u)
								{
									?>
									<option <?php if(isset($res2[0]['outletgrade'])){if($u['id']==$res2[0]['outletgrade']){ echo "selected";}}?> value="<?php echo $u['id'];?>" ><?php echo $u['name'];?></option>
									<?php
								}
								?>
							</select>
						</div>

					
						<div class="col-md-12"><hr></div>
						
					
					

					
						
						<div class="col-md-2">
							<label>Req UTS (kg/mm2)</label>
							<input type="text" class="form-control" id="reqUTS" value="<?php if(isset($res2[0]['reqUTS']))echo $res2[0]['reqUTS'];?>" autocomplete="off" >
						</div>

						<div class="col-md-2">
							<label>Tol ±</label>
							<input type="text" class="form-control" id="tollness" value="<?php if(isset($res2[0]['tollness']))echo $res2[0]['tollness'];?>" autocomplete="off" >
						</div>

						<div class="col-md-3">
							<label>Order Qty. (kg)</label>
							<input type="text" class="form-control" id="orderQty" value="<?php if(isset($res2[0]['orderQty']))echo $res2[0]['orderQty'];?>" onKeyUp="get_calculation()" autocomplete="off">
						</div>

						<div class="col-md-3">
							<label title="Total Production from entry">Prod Qty. 
								<span id='productionDis' style="color:blue">
									<?php 
									if(isset($res2[0]['orderQty'])){
										
										
										$mc_no = $res2[0]['mc_no'];
										$in_product_id = $res2[0]['inletSize'];
										$out_product_id = $res2[0]['outletSize'];
										$grade = $res2[0]['inletGrade'];
										$product_type = $res2[0]['outletgrade'];
										$startDateTime = $res2[0]['startDateTime'];
										$endDateTime = $res2[0]['endDateTime'];
										$search_date1 = $this->Base->change_date_ymd($startDateTime);
										$search_date2 = $this->Base->change_date_ymd($endDateTime);
									 
										$where =" 	and  A.mc_id='$mc_no' 
													and A.in_product_id='$in_product_id'
													and  A.out_product_id='$out_product_id'
													 and  A.grade='$grade' 
													 and  A.product_type='$product_type'
										 			and A.entry_date between '$search_date1' and '$search_date2'  ";
										echo $this->Productionmodel->get_all_production_qty_search($where);
									}
									?>
								</span> (kg) 
							</label>
							<input type="text" class="form-control" id="prodQty" value="<?php if(isset($res2[0]['prodQty']))echo $res2[0]['prodQty'];?>" onKeyUp="get_calculation()" autocomplete="off" >
						</div>

						<div class="col-md-2">
							<label>Bal Qty. (kg)</label>
							<input type="text" class="form-control" id="balQty" value="<?php if(isset($res2[0]['balQty']))echo $res2[0]['balQty'];?>" autocomplete="off" >
						</div>

					
					
						<div class="col-md-12"><hr></div>
					

						<div class="col-md-2">
							<label>Oil / Dry</label>
							<select class="form-control" id="oilDry"   >
								<option value="">Select</option>
								<option <?php if(isset($res2[0]['oilDry'])){if($res2[0]['oilDry']=='Oil'){echo 'selected';}}?>>Oil</option>
								<option <?php if(isset($res2[0]['oilDry'])){if($res2[0]['oilDry']=='Dry'){echo 'selected';}}?>>Dry</option>
							</select>
						</div>

						<div class="col-md-2">
							<label>Current Speed</label>
							<input type="text" class="form-control" id="currentSpeed" value="<?php if(isset($res2[0]['currentSpeed']))echo $res2[0]['currentSpeed'];?>" onKeyUp="get_calculation()" autocomplete="off">
						</div>

						<div class="col-md-2">
							<label>Coil Wt. (kg)</label>
							<input type="text" class="form-control" id="coilWeight" value="<?php if(isset($res2[0]['coilWeight']))echo $res2[0]['coilWeight'];?>" onKeyUp="get_calculation()" autocomplete="off">
						</div>

						<div class="col-md-2">
							<label>Reading (mtr)</label>
							<input type="text" class="form-control" id="readingMtr" value="<?php if(isset($res2[0]['readingMtr']))echo $res2[0]['readingMtr'];?>" autocomplete="off" >
						</div>

						

					
					

						<div class="col-md-2">
							<label>Prod. 100%</label>
							<input type="text" class="form-control" id="pro100Per" value="<?php if(isset($res2[0]['pro100Per']))echo $res2[0]['pro100Per'];?>"  autocomplete="off">
						</div>

						<div class="col-md-2">
							<label>Prod. 75%</label>
							<input type="text" class="form-control" id="pro75per" value="<?php if(isset($res2[0]['pro75per']))echo $res2[0]['pro75per'];?>"  autocomplete="off">
						</div>




						<div class="col-md-12"><hr></div>
							<div class="col-md-12" id='rodDis'>
								<?php 
									if(!empty($res2[0]['in_size']) and !empty($res2[0]['inletGrade'])){
										$rolList = $this->Pomodel->fun_wire_rod_query(sprintf("%.3f", $res2[0]['in_size']),$res2[0]['inletGrade']);
										$this->Pomodel->fun_wire_rod_list($rolList,$res2[0]['useRodList']);
										//print_r($rolList);
									}
								?>
							</div>
							
						<div class="col-md-12"><hr></div>



						<div class="col-md-4">
							<label>Party Name</label>
							<select  class="form-control"   id="partyName" >
								<option   value="">Select</option>
									<?Php 
									foreach($customer as $c)
									{
										?>
											<option <?php if(isset($res2[0]['partyName'])){if($res2[0]['partyName']==$c['id']){ echo "selected";}}?>  value="<?php echo $c['id'];?>">
											<?php echo $c['name'];?>
											</option>
										<?php
									}//foreach
									?>		
							</select>
						</div>

						<div class="col-md-4">
							<label>USE ROD No.</label>
							<input type="text" class="form-control" id="useRodList" value="<?php if(isset($res2[0]['useRodList']))echo $res2[0]['useRodList'];?>"  autocomplete="off">
						</div>

						<div class="col-md-4">
							<label>Remarks </label>
							<input type="text" class="form-control" id="remarks" value="<?php if(isset($res2[0]['remarks']))echo $res2[0]['remarks'];?>"  autocomplete="off">
						</div>







						<div class="col-md-12"><hr></div>
					
						<div class="col-md-2">
							<label>Hours req</label>
							<input type="text" class="form-control" id="hoursReq" value="<?php if(isset($res2[0]['hoursReq']))echo $res2[0]['hoursReq'];?>"  autocomplete="off">
							<input type="hidden"  id="oldhoursReq" value="<?php if(isset($res2[0]['hoursReq']))echo $res2[0]['hoursReq'];?>"  >
						</div>

						<div class="col-md-2">
							<label>Days req </label>
							<input type="text" class="form-control" id="DaysReq" value="<?php if(isset($res2[0]['DaysReq']))echo $res2[0]['DaysReq'];?>"  autocomplete="off">
						</div>

						<div class="col-md-3">
							<label>Start Date & Time</label>
							<input type="datetime-local" class="form-control" id="startDateTime" value="<?php if(isset($res2[0]['startDateTime']))echo $res2[0]['startDateTime'];?>" onchange="get_end_hours()" onkeyup="get_end_hours()" autocomplete="off">
							<input type="hidden"  id="oldstartDateTime" value="<?php if(isset($res2[0]['startDateTime']))echo $res2[0]['startDateTime'];?>"  >
						</div>

						<div class="col-md-3">
							<label>End Date Date & Time </label>
							<input type="datetime-local" class="form-control" id="endDateTime" value="<?php if(isset($res2[0]['endDateTime']))echo $res2[0]['endDateTime'];?>" autocomplete="off" >
						</div>


						<div class="col-md-2">
							<label>Status</label>
							<select class="form-control" id="status"   >
								<option value="">Select</option>
								<option <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Pending'){echo 'selected';}}?>>Pending</option>
								<option <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Completed'){echo 'selected';}}?>>Completed</option>
								<option <?php if(isset($res2[0]['status'])){if($res2[0]['status']=='Cancelled'){echo 'selected';}}?>>Cancelled</option>
							</select>
						</div>

					


					</div>
				</div>
				<div class="modal-footer" style="margin-top: 50px;">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" id="saveButton"  onclick="newProgramSave()" class="btn btn-warning">Save changes</button>
				</div>
				


			<script>
				
				function get_calculation(){
					let outSize = (+$('#outProductSize_').val());
					let orderQty = (+$('#orderQty').val());
					let prodQty = (+$('#prodQty').val());
					let coilWeight = (+$('#coilWeight').val());
					let currentSpeed = (+$('#currentSpeed').val());
					
					let balQty = (orderQty-prodQty); $('#balQty').val(balQty); //get balance qty
					let readingMtr = ((coilWeight*162.164)/(outSize*outSize)).toFixed(0); $('#readingMtr').val(readingMtr); //get reading
					let pro100Per = (outSize*outSize*currentSpeed*12*0.37).toFixed(0); $('#pro100Per').val(pro100Per); //100% production
					let pro75per = (pro100Per*75/100).toFixed(0); $('#pro75per').val(pro75per); //75% production
					let perHourProuduction = (pro75per/12).toFixed(0);
					//hours and day req
					if(pro75per > 0){
						let hoursReq = (balQty/perHourProuduction).toFixed(0);  $('#hoursReq').val(hoursReq); //hours
						let DaysReq = (hoursReq/24).toFixed(1);  $('#DaysReq').val(DaysReq); //days
						get_end_hours();
					}else{
						$('#hoursReq').val('');
						$('#DaysReq').val('');
						$('#endDateTime').val(endDateTime); 
					} 
				}//function close

			

				function get_end_hours() 
				{
					let startDateTime = document.getElementById('startDateTime').value;
					let hoursReq = document.getElementById('hoursReq').value;
					if (startDateTime && hoursReq) {
						//let hoursReq = 19;

						// Parse the ISO date-time format directly
						let startDate = new Date(startDateTime);

						// Add the required hours to the start date
						let endDate = new Date(startDate.getTime() + hoursReq * 60 * 60 * 1000);

						// Format the end date to the required format
						let endDay = endDate.getDate().toString().padStart(2, '0');
						let endMonth = (endDate.getMonth() + 1).toString().padStart(2, '0');
						let endYear = endDate.getFullYear();
						let endHours = endDate.getHours().toString().padStart(2, '0');
						let endMinutes = endDate.getMinutes().toString().padStart(2, '0');

						// Construct endDateTime in the same format as startDateTime
						let endDateTime = `${endYear}-${endMonth}-${endDay}T${endHours}:${endMinutes}`;

						// Update the endDateTime input field
						document.getElementById('endDateTime').value = endDateTime;
					} else {
						document.getElementById('endDateTime').value = "";
					}
				}//function close


				


				function convert_date_format(inputDateTime){
					
					// Use a regular expression to parse the date and time
					let dateTimeRegex = /^(\d{2})-(\d{2})-(\d{4}) (\d{2}):(\d{2}):(\d{2})\s?(AM|PM)?$/i;
					let match = inputDateTime.match(dateTimeRegex);

					if (match) {
						let [day, month, year, hours, minutes, seconds, period] = match.slice(1);

						day = parseInt(day, 10);
						month = parseInt(month, 10);
						year = parseInt(year, 10);
						hours = parseInt(hours, 10);
						minutes = parseInt(minutes, 10);
						seconds = parseInt(seconds, 10);

						// Convert the 12-hour time format to 24-hour format
						if (period && period.toUpperCase() === 'PM' && hours < 12) hours += 12;
						if (period && period.toUpperCase() === 'AM' && hours === 12) hours = 0;

						// Construct the date in ISO format
						let isoDateTime = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}T${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

						return isoDateTime;
						//console.log(isoDateTime);
					} 
				}//function close


				//get machine current running plan
				function fun_machine_plan(mc_id){
					$('#CurrentRuningDis').html('');
					
					jQuery.post("<?php echo base_url().'index.php/Production/fun_machine_plan';?>", {mc_id:mc_id}, function(data) {
						$('#CurrentRuningDis').html(data);
						radio_function_for_startdate();
					});

					//online work in new plan
					let planid = $('#planid').val();
					if(planid <1 ){
						//no of plan
						jQuery.post("<?php echo base_url().'index.php/Production/fun_machine_plan_rank';?>", {mc_id:mc_id}, function(rank) {
							$('#planRank').val((+rank)+1);
							// Disable options less than rank
							$('#planRank option').each(function() {
								if (parseInt($(this).val(), 10) < rank) {
									$(this).prop('disabled', true);
								} else {
									$(this).prop('disabled', false); // Ensure others are enabled
								}
							});
						});
					}

				}//function close

				//set start date from last plan
				function radio_function_for_startdate() 
				{
					let value = $('#planRankRadio').val();
					if(value){
						let value2 = value.split("~");
						let place=value2[0];
						let startDate=value2[1];
						let endDate=value2[2];
						
						let inputDateTime = endDate;

						let endDateTime = convert_date_format(inputDateTime);
						if(endDateTime){$('#startDateTime').val(endDateTime);}
					}
				}//function close


				
				//get wire rod
				function getRod()
				{
					let size=(+$('#inProductSize_').val()).toFixed(3);;
					let grade=$('#inletGrade').val();
					let rodStatus='zero';
					let search1='1';
					
					$('#wait').show();
					$('#rodDis').html('Please wait...');
					jQuery.post("<?php echo base_url().'index.php/Qc/fun_get_rod_for_plan';?>", 
					{
						size:size,
						grade:grade,
						rodStatus:rodStatus,
						search1:search1,
					}, 
					function(data, textStatus)
					{	
						$('#rodDis').html(data);
						$('#wait').hide();
					});
				}//function close


				
				//get production from production entry
				function getProductionQty()
				{
					let in_product_id = $('#inProductId_').val();
					let grade = $('#inletGrade').val();
					let out_product_id = $('#outProductId_').val();
					let product_type = $('#outletgrade').val();
					let mc_no = $('#mc_no').val();
					let startDateTime = $('#startDateTime').val();
					let endDateTime = $('#endDateTime').val();
					let search1='1';
					
					$('#wait').show();
					$('#productionDis').html('Wait...');
					jQuery.post("<?php echo base_url().'index.php/Production/getProductionQty';?>", 
					{
						mc_no:mc_no,
						in_product_id:in_product_id,
						grade:grade,
						out_product_id:out_product_id,
						product_type:product_type,
						startDateTime:startDateTime,
						endDateTime:endDateTime,
						search1:search1,
					}, 
					function(data, textStatus)
					{	
						$('#productionDis').html(data);
						$('#wait').hide();
					});
				}//function close


				//-----------------------------Product Type to Search 
				function fun_get_product2(id,source_id,dest_id,dest_size)
				{
					let id2 = id.split("_");
					let id_no=id2[1];
					let source_id2 = '#'+source_id.concat(id_no);
					let source_val=$(source_id2).val();
					let dest_id2 = '#'+dest_id.concat(id_no);
					let dest_size2 = '#'+dest_size.concat(id_no);
					
					$(dest_id2).val('');
					$(dest_size2).val('');
					
					$(source_id2).autocomplete({
					source: '<?php echo base_url().'index.php';?>/Product/product_autocomplate_search/',
					autoFocus:true,
					select: function(event, ui) {
							event.preventDefault();
							$(source_id2).val(ui.item.label);
							$(dest_id2).val(ui.item.value);
							$(dest_size2).val(ui.item.size);
							getRod();
						},
					});
				}//function close



				function newProgramSave() {
					
					let mc_no=$('#mc_no').val(); if(mc_no==''){$('#mc_no').focus();fun_message('warning','Warning','Select Machine','toast-bottom-right');return false;}
					let orderNo=$('#orderNo').val(); if(orderNo==''){$('#orderNo').focus();fun_message('warning','Warning','Enter Order no','toast-bottom-right');return false;}

					let inletGrade=$('#inletGrade').val(); if(inletGrade==''){$('#inletGrade').focus();fun_message('warning','Warning','Select inletGrade','toast-bottom-right');return false;}
					let outletgrade=$('#outletgrade').val(); if(outletgrade==''){$('#outletgrade').focus();fun_message('warning','Warning','Select outletgrade','toast-bottom-right');return false;}
					let orderQty=$('#orderQty').val(); if(orderQty==''){$('#orderQty').focus();fun_message('warning','Warning','Select orderQty','toast-bottom-right');return false;}
					let coilWeight=$('#coilWeight').val(); if(coilWeight==''){$('#coilWeight').focus();fun_message('warning','Warning','Select coilWeight','toast-bottom-right');return false;}
					let currentSpeed=$('#currentSpeed').val(); if(currentSpeed==''){$('#currentSpeed').focus();fun_message('warning','Warning','Select currentSpeed','toast-bottom-right');return false;}
					let status=$('#status').val(); if(status==''){$('#status').focus();fun_message('warning','Warning','Select status','toast-bottom-right');return false;}

					let formData = {
							planid:$('#planid').val(),
							dept: $('#dept').val(),
							mc_no: $('#mc_no').val(),
							mcSpeed: $('#mcSpeed').val(),
							orderNo: $('#orderNo').val(),
							planRank: $('#planRank').val(), 
							oldPlanRank: $('#oldPlanRank').val(),

							coating: $('#coating').val(),
							inletGrade: $('#inletGrade').val(),
							inletSize: $('#inProductId_').val(),
							outletgrade: $('#outletgrade').val(),
							outletSize: $('#outProductId_').val(),
							reqUTS: $('#reqUTS').val(),
							tollness: $('#tollness').val(),
							orderQty: $('#orderQty').val(),

							prodQty: $('#prodQty').val(),
							balQty: $('#balQty').val(),
							readingMtr: $('#readingMtr').val(),
							oilDry: $('#oilDry').val(),
							coilWeight: $('#coilWeight').val(),

							currentSpeed: $('#currentSpeed').val(),
							pro100Per: $('#pro100Per').val(),
							pro75per: $('#pro75per').val(),
							partyName: $('#partyName').val(),
							useRodList: $('#useRodList').val(),
							remarks: $('#remarks').val(),

							hoursReq: $('#hoursReq').val(),
							oldhoursReq: $('#oldhoursReq').val(),
							DaysReq: $('#DaysReq').val(), 
							startDateTime: $('#startDateTime').val(),
							oldstartDateTime: $('#oldstartDateTime').val(),
							endDateTime: $('#endDateTime').val(),
							status: $('#status').val()
					};

				
					//Show loader
					$('.loader').show();
					$('#saveButton').hide();

					// Make AJAX request
					jQuery.post("<?php echo base_url().'index.php/Production/newProgramSave';?>", formData, function(data) {
						// Hide loader
						$('.loader').hide();
						if(data=='Save')
						{
							fun_message('success',data,'Save Successfully','toast-bottom-right');
							//showPage(url);
							$('.plan-modal-lg').modal('hide');
							location.reload();
						}
						else if(data=='Update')
						{
							fun_message('success',data,'Updated Successfully','toast-bottom-right');
							//showPage(url);
							$('.plan-modal-lg').modal('hide');
							location.reload();
						}
						else
						{
							fun_message('error','Error',data,'toast-bottom-right');
						}
						$('#loader').hide();
						$('#saveButton').show();
					});
				}
			</script>

		<?php
	}//function close




	//list search
	public function getProductionQty()
	{
		if(isset($_REQUEST['search1']))
		{
			$where = "";
			if(!empty($_REQUEST['mc_no'])){$mc_no=$_REQUEST['mc_no'];$where.=" and  A.mc_id='$mc_no'   ";}
			if(!empty($_REQUEST['in_product_id'])){$in_product_id=$_REQUEST['in_product_id'];$where.=" and  A.in_product_id='$in_product_id'   ";}
			if(!empty($_REQUEST['out_product_id'])){$out_product_id=$_REQUEST['out_product_id'];$where.=" and  A.out_product_id='$out_product_id'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.grade='$grade'   ";}
			if(!empty($_REQUEST['product_type'])){$product_type=$_REQUEST['product_type'];$where.=" and  A.product_type='$product_type'   ";}
			
			if(!empty($_REQUEST['startDateTime']) and !empty($_REQUEST['endDateTime']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['startDateTime']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['endDateTime']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.="  ";
			echo $this->Productionmodel->get_all_production_qty_search($where);
		}
		
	}//function close


	








	
	
	
	
	
	
	

}//close class