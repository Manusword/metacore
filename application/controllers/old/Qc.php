<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qc extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Base');

		$user_email = $this->session->userdata('login_username');
		if (!$user_email > 0) {
			redirect('welcome/');
		}
	} //function close

	public function index()
	{
		redirect("welcome/");
	} //function close




	//add /edit new spec
	public function spec1_add()
	{
		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Qcmodel->get_sepc1_data_with_id($id);
		} //strlen
		$result['grade'] = $this->Base->get_all_grade();
		$result['product_type'] = $this->Base->get_all_product_type();
		$this->load->view('qc/entry', $result);
	} //function close



	//list search
	public function list_spec1()
	{
		$result['dept'] = $this->Base->get_maintenance_dept();
		$result['grade'] = $this->Base->get_all_grade();
		if (isset($_REQUEST['search1'])) {
			$where = "";

			if (!empty($_REQUEST['type1'])) {
				$type1 = $_REQUEST['type1'];
				$where .= " and  A.type1='$type1'   ";
			}
			if (!empty($_REQUEST['type2'])) {
				$type2 = $_REQUEST['type2'];
				$where .= " and  A.type2='$type2'   ";
			}
			if (!empty($_REQUEST['product_grade'])) {
				$product_grade = $_REQUEST['product_grade'];
				$where .= " and  A.product_grade='$product_grade'   ";
			}
			if (!empty($_REQUEST['size'])) {
				$size = $_REQUEST['size'];
				$where .= " and  A.size='$size'   ";
			}
			$result['res2'] = $this->Qcmodel->get_all_sepc1_with_search($where);
			$this->load->view('qc/show_table', $result);
		} else {
			$where = " and A.status='Active' ORDER by A.size ASC ";
			$result['res2'] = $this->Qcmodel->get_all_sepc1_with_search($where);
			$this->load->view('qc/show', $result);
		} //search
	} //function close



	//save new product
	public function spec1_save()
	{
		$today = date("Y-m-d H:i:s");
		$login_username = $this->session->userdata('login_emp_id');

		if (isset($_REQUEST['id'])) {
			$id = $_REQUEST['id'];
		} else {
			$id = '';
		}
		if (isset($_REQUEST['type1'])) {
			$type1 = $_REQUEST['type1'];
		} else {
			$type1 = '';
		}
		if (isset($_REQUEST['type2'])) {
			$type2 = $_REQUEST['type2'];
		} else {
			$type2 = '';
		}
		if (isset($_REQUEST['product_grade'])) {
			$product_grade = $_REQUEST['product_grade'];
		} else {
			$product_grade = '';
		}

		if (isset($_REQUEST['size'])) {
			$size = number_format((float) $_REQUEST['size'], 3);
		} else {
			$size = '';
		}
		if (isset($_REQUEST['min_tole'])) {
			$min_tole = number_format((float) $_REQUEST['min_tole'], 3);
		} else {
			$min_tole = '';
		}

		if (isset($_REQUEST['min_size'])) {
			$min_size = number_format((float) $_REQUEST['min_size'], 3);
		} else {
			$min_size = '';
		}
		if (isset($_REQUEST['max_tole'])) {
			$max_tole = number_format((float) $_REQUEST['max_tole'], 3);
		} else {
			$max_tole = '';
		}
		if (isset($_REQUEST['max_size'])) {
			$max_size = number_format((float) $_REQUEST['max_size'], 3);
		} else {
			$max_size = '';
		}
		if (isset($_REQUEST['ovality_max'])) {
			$ovality_max = number_format((float) $_REQUEST['ovality_max'], 3);
		} else {
			$ovality_max = '';
		}
		if (isset($_REQUEST['ovality_size_max'])) {
			$ovality_size_max = number_format((float) $_REQUEST['ovality_size_max'], 3);
		} else {$ovality_size_max = '';}

		if (isset($_REQUEST['ts_min_ss1'])) {$ts_min_ss1 = $_REQUEST['ts_min_ss1'];} else {$ts_min_ss1 = '';}
		if (isset($_REQUEST['ts_max_ss1'])) {$ts_max_ss1 = $_REQUEST['ts_max_ss1'];} else {$ts_max_ss1 = '';}
		if (isset($_REQUEST['ts_min_ss2'])) {$ts_min_ss2 = $_REQUEST['ts_min_ss2'];} else {$ts_min_ss2 = '';}
		if (isset($_REQUEST['ts_max_ss2'])) {$ts_max_ss2 = $_REQUEST['ts_max_ss2'];} else {$ts_max_ss2 = '';}
		if (isset($_REQUEST['ts_min_ss3'])) {$ts_min_ss3 = $_REQUEST['ts_min_ss3'];} else {$ts_min_ss3 = '';}
		if (isset($_REQUEST['ts_max_ss3'])) {$ts_max_ss3 = $_REQUEST['ts_max_ss3'];} else {$ts_max_ss3 = '';}
		if (isset($_REQUEST['remarks'])) {$remarks = $_REQUEST['remarks'];} else {$remarks = '';}
		if (isset($_REQUEST['status'])) {$status = $_REQUEST['status'];} else {$status = 'Active';}
		if (isset($_REQUEST['product_type'])) {$product_type = $_REQUEST['product_type'];} else {$product_type = '';}



		//----------------------------------------------------------------------insert
		if (empty($_REQUEST['id']) and !empty($_REQUEST['size']) and !empty($_REQUEST['type1']) and !empty($_REQUEST['type2']) and !empty($_REQUEST['product_type'])) {
			$where = " size='$size' and type1='$type1' and type2='$type2' and product_grade='$product_grade' and  product_type='$product_type'  ";
			$res_chk = $this->Mymodel->select_where('qc_spec1', $where);
			if (isset($res_chk) and count($res_chk) > 0) {
				$id2 = $res_chk[0]['id'];
			}
			if (isset($id2)) {
				echo "$size in $type1, $type2, $product_type and this grade is Already Available";
			} else {
				$data = array(
					'type1' => "$type1",
					'type2' => "$type2",
					'product_grade' => "$product_grade",
					'product_type' => "$product_type",
					'size' => "$size",
					'min_tole' => "$min_tole",
					'min_size' => "$min_size",
					'max_tole' => "$max_tole",
					'max_size' => "$max_size",
					'ovality_max' => "$ovality_max",
					'ovality_size_max' => "$ovality_size_max",
					'ts_min_ss1' => "$ts_min_ss1",
					'ts_max_ss1' => "$ts_max_ss1",
					'ts_min_ss2' => "$ts_min_ss2",
					'ts_max_ss2' => "$ts_max_ss2",
					'ts_min_ss3' => "$ts_min_ss3",
					'ts_max_ss3' => "$ts_max_ss3",
					'remarks' => "$remarks",
					'status' => "$status",

					'save_by' => "$login_username",
					'save_date' => "$today",

				);
				$qc_spec1_id = $this->Mymodel->insertdata_withid('qc_spec1', $data);
				echo "Save";
			}

		} //insert




		//------------------------------------------------------------------update
		elseif (!empty($_REQUEST['id']) and !empty($_REQUEST['size']) and !empty($_REQUEST['type1']) and !empty($_REQUEST['type2']) and !empty($_REQUEST['product_type'])) {
			$where = " size='$size' and type1='$type1' and type2='$type2' and product_grade='$product_grade' and  product_type='$product_type' ";
			$res_chk = $this->Mymodel->select_where('qc_spec1', $where);
			if (isset($res_chk) and count($res_chk) > 0) {
				$id2 = $res_chk[0]['id'];
			}
			if (isset($id2) and $id != $id2) {
				echo "$size in $type1, $type2 and this grade is Already Available";
			} else {
				$data = array(
					'type1' => "$type1",
					'type2' => "$type2",
					'product_grade' => "$product_grade",
					'product_type' => "$product_type",
					'size' => "$size",
					'min_tole' => "$min_tole",
					'min_size' => "$min_size",
					'max_tole' => "$max_tole",
					'max_size' => "$max_size",
					'ovality_max' => "$ovality_max",
					'ovality_size_max' => "$ovality_size_max",
					'ts_min_ss1' => "$ts_min_ss1",
					'ts_max_ss1' => "$ts_max_ss1",
					'ts_min_ss2' => "$ts_min_ss2",
					'ts_max_ss2' => "$ts_max_ss2",
					'ts_min_ss3' => "$ts_min_ss3",
					'ts_max_ss3' => "$ts_max_ss3",
					'remarks' => "$remarks",
					'status' => "$status",

					'update_by' => "$login_username",
					'update_date' => "$today",

				);
				$where = array('id' => "$id");
				$this->Mymodel->update('qc_spec1', $data, $where);
				echo "Update";
			} //not repeat
		} else {
			//exit
			echo "Not Save. Try Again. No Data Found.";
		} //exit

	} //function close













	//add /edit new test
	public function long_test_add()
	{
		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Qcmodel->get_log_test_data_with_id($id);
		} //strlen
		$result['grade'] = $this->Base->get_all_grade();
		$result['dept'] = $this->Base->get_maintenance_dept();
		$result['product_type'] = $this->Base->get_all_product_type();
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		$this->load->view('qc/long/entry', $result);
	} //function close





	//list search
	public function list_log_test()
	{
		$result['dept'] = $this->Base->get_maintenance_dept();
		$result['grade'] = $this->Base->get_all_grade();
		if (isset($_REQUEST['search1'])) {
			$where = " ";
			if (!empty($_REQUEST['shift'])) {
				$shift = $_REQUEST['shift'];
				$where .= " and  A.shift='$shift'   ";
			}
			if (!empty($_REQUEST['finish_size'])) {
				$finish_size = $_REQUEST['finish_size'];
				$where .= " and  A.finish_size='$finish_size'   ";
			}
			if (!empty($_REQUEST['product_grade'])) {
				$product_grade = $_REQUEST['product_grade'];
				$where .= " and  A.product_grade='$product_grade'   ";
			}
			if (!empty($_REQUEST['dept'])) {
				$dept = $_REQUEST['dept'];
				$where .= " and  A.dept='$dept'   ";
			}
			if (!empty($_REQUEST['mc_no'])) {
				$mc_no = $_REQUEST['mc_no'];
				$where .= " and  A.mc_no='$mc_no'   ";
			}
			if (!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2'])) {
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where .= "  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where .= "  ORDER by M.order_list ";

			$result['res2'] = $this->Qcmodel->get_all_log_test_with_search($where);
			//print_r($result['res2']);
			$this->load->view('qc/long/show_table', $result);
		} else {
			$search_date1 = date('Y-m-d');
			$search_date2 = date('Y-m-d');
			$where = " and A.entry_date between '$search_date1' and '$search_date2'   ORDER by M.order_list  ";
			$result['res2'] = $this->Qcmodel->get_all_log_test_with_search($where);
			$this->load->view('qc/long/show', $result);
		} //search
	} //function close

	//save new log_test_save
	public function log_test_save()
	{
		$today = date("Y-m-d H:i:s");
		$login_username = $this->session->userdata('login_emp_id');

		if (isset($_REQUEST['id'])) {
			$id = $_REQUEST['id'];
		} else {
			$id = '';
		}
		if (isset($_REQUEST['entry_date'])) {
			$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);
		} else {
			$entry_date = date('Y-m-d');
		}
		if (isset($_REQUEST['shift'])) {
			$shift = $_REQUEST['shift'];
		} else {
			$shift = '';
		}
		if (isset($_REQUEST['base_size'])) {
			$base_size1 = round($_REQUEST['base_size'], 3);
		} else {
			$base_size1 = '';
		}
		if (isset($_REQUEST['dept'])) {
			$dept = $_REQUEST['dept'];
		} else {
			$dept = '';
		}
		if (isset($_REQUEST['mc_no'])) {
			$mc_no = $_REQUEST['mc_no'];
		} else {
			$mc_no = '';
		}
		if (isset($_REQUEST['product_grade'])) {
			$product_grade = $_REQUEST['product_grade'];
		} else {
			$product_grade = '';
		}
		if (isset($_REQUEST['batch_no'])) {
			$batch_no = $_REQUEST['batch_no'];
		} else {
			$batch_no = '';
		}
		if (isset($_REQUEST['product_type'])) {
			$product_type = $_REQUEST['product_type'];
		} else {
			$product_type = '';
		}
		if (isset($_REQUEST['finish_size'])) {
			$finish_size1 = round($_REQUEST['finish_size'], 3);
		} else {
			$finish_size1 = '';
		}
		if (isset($_REQUEST['coil_dia'])) {
			$coil_dia = $_REQUEST['coil_dia'];
		} else {
			$coil_dia = '';
		}
		if (isset($_REQUEST['coil_dia_from'])) {
			$coil_dia_from = $_REQUEST['coil_dia_from'];
		} else {
			$coil_dia_from = '';
		}
		if (isset($_REQUEST['coil_dia_to'])) {
			$coil_dia_to = $_REQUEST['coil_dia_to'];
		} else {
			$coil_dia_to = '';
		}
		if (isset($_REQUEST['total_coils'])) {
			$total_coils = $_REQUEST['total_coils'];
		} else {
			$total_coils = '';
		}
		if (isset($_REQUEST['total_pass_coils'])) {
			$total_pass_coils = $_REQUEST['total_pass_coils'];
		} else {
			$total_pass_coils = '';
		}
		if (isset($_REQUEST['total_nc_coils'])) {
			$total_nc_coils = $_REQUEST['total_nc_coils'];
		} else {
			$total_nc_coils = '';
		}
		if (isset($_REQUEST['operator1'])) {
			$operator1 = $_REQUEST['operator1'];
		} else {
			$operator1 = '';
		}
		if (isset($_REQUEST['nc_reason'])) {
			$nc_reason = $_REQUEST['nc_reason'];
		} else {
			$nc_reason = '';
		}
		if (isset($_REQUEST['customer_id'])) {
			$customer_id = $_REQUEST['customer_id'];
		} else {
			$status = 'customer_id';
		}
		if (isset($_REQUEST['diversion'])) {
			$diversion = $_REQUEST['diversion'];
		} else {
			$diversion = '';
		}

		$base_size = number_format((float) $base_size1, 3, '.', '');
		$finish_size = number_format((float) $finish_size1, 3, '.', '');

		//----------------------------------------------------------------------insert
		if (empty($_REQUEST['id']) and !empty($_REQUEST['entry_date']) and !empty($_REQUEST['shift']) and !empty($_REQUEST['product_grade'])) {

			$data = array(
				'entry_date' => "$entry_date",
				'shift' => "$shift",
				'base_size' => "$base_size",
				'dept' => "$dept",
				'mc_no' => "$mc_no",
				'product_grade' => "$product_grade",
				'batch_no' => "$batch_no",
				'product_type' => "$product_type",
				'finish_size' => "$finish_size",
				'coil_dia' => "$coil_dia",
				'coil_dia_from' => "$coil_dia_from",
				'coil_dia_to' => "$coil_dia_to",
				'total_coils' => "$total_coils",
				'total_pass_coils' => "$total_pass_coils",
				'total_nc_coils' => "$total_nc_coils",
				'operator1' => "$operator1",
				'nc_reason' => "$nc_reason",
				'customer_id' => "$customer_id",
				'diversion' => "$diversion",

				'save_by' => "$login_username",
				'save_date' => "$today",

			);
			$qc_spec1_id = $this->Mymodel->insertdata_withid('qc_log_test', $data);
			echo "Save";
		} //insert




		//------------------------------------------------------------------update
		elseif (!empty($_REQUEST['id']) and !empty($_REQUEST['entry_date']) and !empty($_REQUEST['shift']) and !empty($_REQUEST['product_grade'])) {

			$data = array(
				'entry_date' => "$entry_date",
				'shift' => "$shift",
				'base_size' => "$base_size",
				'dept' => "$dept",
				'mc_no' => "$mc_no",
				'product_grade' => "$product_grade",
				'batch_no' => "$batch_no",
				'product_type' => "$product_type",
				'finish_size' => "$finish_size",
				'coil_dia' => "$coil_dia",
				'coil_dia_from' => "$coil_dia_from",
				'coil_dia_to' => "$coil_dia_to",
				'total_coils' => "$total_coils",
				'total_pass_coils' => "$total_pass_coils",
				'total_nc_coils' => "$total_nc_coils",
				'operator1' => "$operator1",
				'nc_reason' => "$nc_reason",
				'customer_id' => "$customer_id",
				'diversion' => "$diversion",

				'update_by' => "$login_username",
				'update_date' => "$today",

			);
			$where = array('id' => "$id");
			$this->Mymodel->update('qc_log_test', $data, $where);
			echo "Update";

		} else {
			//exit
			echo "Not Save. Try Again. No Data Found.";
		} //exit

	} //function close







	//add /edit new test
	public function test1_add()
	{
		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			//$result['res2']=$this->Qcmodel->get_test1_data_with_id($id); 
			$result['res2'] = $this->Qcmodel->get_log_test_data_with_id($id);
			$result['res3'] = $this->Qcmodel->get_test1_data_with_logid($id);

			$result['grade'] = $this->Base->get_all_grade();
			$result['dept'] = $this->Base->get_maintenance_dept();
			$result['product_type'] = $this->Base->get_all_product_type();
			$result['customer'] = $this->Customermodel->get_all_active_customer();
			$this->load->view('qc/test/entry', $result);
		} //strlen

	} //function close

	//list search
	public function list_test1()
	{
		$result['dept'] = $this->Base->get_maintenance_dept();
		$result['grade'] = $this->Base->get_all_grade();
		if (isset($_REQUEST['search1'])) {
			$where = " ";
			if (!empty($_REQUEST['shift'])) {
				$shift = $_REQUEST['shift'];
				$where .= " and  B.shift='$shift'   ";
			}
			if (!empty($_REQUEST['size'])) {
				$size = $_REQUEST['size'];
				$where .= " and  B.finish_size='$size'   ";
			}
			if (!empty($_REQUEST['product_grade'])) {
				$product_grade = $_REQUEST['product_grade'];
				$where .= " and  B.product_grade='$product_grade'   ";
			}
			if (!empty($_REQUEST['dept'])) {
				$dept = $_REQUEST['dept'];
				$where .= " and  B.dept='$dept'   ";
			}
			if (!empty($_REQUEST['mc_no'])) {
				$mc_no = $_REQUEST['mc_no'];
				$where .= " and  B.mc_no='$mc_no'   ";
			}
			if (!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2'])) {
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where .= "  and B.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where .= " ORDER by B.entry_date,B.dept,B.mc_no,A.coil_no ";

			$result['res2'] = $this->Qcmodel->get_all_test1_with_search($where);
			$this->load->view('qc/test/show_table', $result);
		} else {
			$search_date1 = date('Y-m-d');
			$search_date2 = date('Y-m-d');
			$where = " and B.entry_date between '$search_date1' and '$search_date2'  ORDER by B.entry_date,B.dept,B.mc_no,A.coil_no   ";
			$result['res2'] = $this->Qcmodel->get_all_test1_with_search($where);
			$this->load->view('qc/test/show', $result);
		} //search
	} //function close



	//save new test1_save
	public function test1_save()
	{
		$today = date("Y-m-d H:i:s");
		$user_email = $this->session->userdata('login_emp_id');

		if (isset($_REQUEST['id'])) {
			$qc_log_test_id = $_REQUEST['id'];
		} else {
			$qc_log_test_id = '';
			echo "Log Test id Found";
			exit;
		}
		if (isset($_REQUEST['for_patt'])) {$for_patt = (Int)$_REQUEST['for_patt'];} else {$for_patt = 0;}
		//if (isset($_REQUEST['lotno'])) {$lotno = $_REQUEST['lotno'];} else {$lotno = '';}
		//update qc_log_test
		$data = array('for_patt' => $for_patt);
		$where = array('id' => $qc_log_test_id);
		$this->Mymodel->update('qc_log_test', $data, $where);

		

		//------------------row
		if (isset($_REQUEST['coilno'])) {
			$coilno = explode('~', $_REQUEST['coilno']);
			$no_of_row = count($coilno);
		} else {
			$coilno = '';
			$no_of_row = 0;
		}
		if (isset($_REQUEST['qcLogDetailsid'])) {$qcLogDetailsid = explode('~', $_REQUEST['qcLogDetailsid']);} else {$qcLogDetailsid = '';}
		if (isset($_REQUEST['baseCoilId'])) {$baseCoilId = explode('~', $_REQUEST['baseCoilId']);} else {$baseCoilId = '';}
		if (isset($_REQUEST['coilweight'])) {$coilweight = explode('~', $_REQUEST['coilweight']);} else {$coilweight = '';}
		if (isset($_REQUEST['finishsize'])) {$finishsize = explode('~', $_REQUEST['finishsize']);} else {$finishsize = '';}
		if (isset($_REQUEST['breakingload'])) {$breakingload = explode('~', $_REQUEST['breakingload']);} else {$breakingload = '';}
		if (isset($_REQUEST['uts'])) {$uts = explode('~', $_REQUEST['uts']);} else {$uts = '';}
		if (isset($_REQUEST['torsiontest'])) {$torsiontest = explode('~', $_REQUEST['torsiontest']);} else {$torsiontest = '';}
		if (isset($_REQUEST['bendtest'])) {$bendtest = explode('~', $_REQUEST['bendtest']);} else {$bendtest = '';}
		if (isset($_REQUEST['raper'])) {$raper = explode('~', $_REQUEST['raper']);} else {$raper = '';}
		if (isset($_REQUEST['scratchbrigitness'])) {$scratchbrigitness = explode('~', $_REQUEST['scratchbrigitness']);} else {$scratchbrigitness = '';}
		if (isset($_REQUEST['remarks'])) {$remarks = explode('~', $_REQUEST['remarks']);} else {$remarks = '';}

		//print_r($coilno);

		//delete
		//$where2 = array('qc_log_test_id' => $qc_log_test_id);
		//$this->Mymodel->deletedata('qc_test1', $where2);

		
		//insert
		$i = 0;
		foreach ($coilno as $c) {
			if ($c > 0) {
				//$current_finishsize = round($finishsize[$i], 3); 
				$current_finishsize = number_format((float) $finishsize[$i], 3);
				$uts2 = $this->Base->get_uts_from_breakingload_size($breakingload[$i], $current_finishsize);

				if($for_patt == 1){
					$baseId1 = 0;
					$lotno = $baseCoilId[$i];
				}else{
					$baseId1 = $baseCoilId[$i];
					$lotno = 0;
				}

				$data2 = array(
					'qc_log_test_id' => "$qc_log_test_id",
					'coil_no' => "$c",
					'finish_size' => "$current_finishsize",
					'breaking_load' => "$breakingload[$i]",
					'uts' => "$uts2",
					'torsion_test' => "$torsiontest[$i]",
					'bend_test' => "$bendtest[$i]",
					'ra_per' => "$raper[$i]",
					'scratch_brigitness' => "$scratchbrigitness[$i]",
					'remarks' => "$remarks[$i]",
					'baseCoilId' => "$baseId1",
					'lotno' => "$lotno",
					'coil_weight' => "$coilweight[$i]",
					
					'save_by' => "$user_email",
					'save_date' => "$today",
				);
				

				if($qcLogDetailsid[$i] > 0) {
					//update
					$where2 = array('id' => "$qcLogDetailsid[$i]");
					$this->Mymodel->update('qc_test1', $data2, $where2);
				}else{
					//new
					$this->Mymodel->insertdata('qc_test1', $data2);
				}
			}
			$i++;
		} //foeach


	

		echo "Save";

	} //function close




































	//----------------------------------------------------------------TC
	//qc tc spec form qc.js page 
	public function get_tc_spec_data()
	{
		if (isset($_REQUEST['product_type']) and isset($_REQUEST['size'])) {

			$product_type = $_REQUEST['product_type'];
			$size = $_REQUEST['size'];

			$res = $this->Qcmodel->get_tc_spec_data($product_type, $size);
			//print_r($res);
			if (!empty($res)) {
				echo $res[0]['c1'] . '~' .
					$res[0]['c2'] . '~' .
					$res[0]['mn1'] . '~' .
					$res[0]['mn2'] . '~' .
					$res[0]['si1'] . '~' .
					$res[0]['si2'] . '~' .
					$res[0]['p1'] . '~' .
					$res[0]['p2'] . '~' .
					$res[0]['s1'] . '~' .
					$res[0]['s2'] . '~' .
					$res[0]['dia1'] . '~' .
					$res[0]['dia2'] . '~' .
					$res[0]['uts1'] . '~' .
					$res[0]['uts2'] . '~' .
					$res[0]['tor1'] . '~' .
					$res[0]['tor2'] . '~' .
					$res[0]['ra1'] . '~' .
					$res[0]['ra2'] . '~' .
					$res[0]['zinc1'] . '~' .
					$res[0]['zinc2'] . '~' .
					$res[0]['bend1'] . '~' .
					$res[0]['bend2'] . '~' .
					$res[0]['surface1'] . '~' .
					$res[0]['surface2'] . '~' .
					$res[0]['remarks1'] . '~' .
					$res[0]['remarks2'] . '~' .
					$res[0]['size'];
			}

		}

	} //function close


	//add /edit new TC
	public function tc_add()
	{

		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Qcmodel->get_tc_data_with_id($id);
			$result['res3'] = $this->Qcmodel->get_tc_spec_data_with_tc_id($id);
		} //strlen
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		$result['product_type'] = $this->Base->get_all_product_type();
		$this->load->view('qc/tc/entry', $result);
	} //function close

	//print new TC
	public function tc_print()
	{
		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Qcmodel->get_tc_data_with_id($id);
			$result['res3'] = $this->Qcmodel->get_tc_spec_data_with_tc_id($id);
			$this->load->view('qc/tc/tc_print', $result);
		} //strlen
	} //function close

	//list search
	public function list_tc()
	{
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		$result['product_type'] = $this->Base->get_all_product_type();
		if (isset($_REQUEST['search1'])) {
			$where = " ";
			if (!empty($_REQUEST['customer_id'])) {
				$customer_id = $_REQUEST['customer_id'];
				$where .= " and  A.customer_id='$customer_id'   ";
			}
			if (!empty($_REQUEST['invoice_no'])) {
				$invoice_no = $_REQUEST['invoice_no'];
				$where .= " and  A.invoice_no='$invoice_no'   ";
			}
			if (!empty($_REQUEST['certificate_no'])) {
				$certificate_no = $_REQUEST['certificate_no'];
				$where .= " and  A.certificate_no='$certificate_no'   ";
			}
			if (!empty($_REQUEST['product_type'])) {
				$product_type = $_REQUEST['product_type'];
				$where .= " and  A.product_type='$product_type'   ";
			}
			if (!empty($_REQUEST['product_name'])) {
				$product_name = $_REQUEST['product_name'];
				$where .= " and  A.product_name like '%$product_name%'   ";
			}
			if (!empty($_REQUEST['size'])) {
				$size = number_format((float) $_REQUEST['size'], 3);
				$where .= " and  A.size='$size'   ";
			}
			if (!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2'])) {
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where .= "  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where .= "  GROUP BY A.tc_id ORDER by A.entry_date,C.name ";

			$result['res2'] = $this->Qcmodel->get_all_tc_with_search($where);
			//print_r($result['res2']);
			$this->load->view('qc/tc/show_table', $result);
		} else {
			$search_date1 = date('Y-m-01');
			$search_date2 = date('Y-m-d');
			$where = " and A.entry_date between '$search_date1' and '$search_date2' GROUP BY A.tc_id  ORDER by A.entry_date,C.name  ";
			$result['res2'] = $this->Qcmodel->get_all_tc_with_search($where);
			$this->load->view('qc/tc/show', $result);
		} //search
	} //function close


	//save new tc_save
	public function tc_save()
	{
		$today = date("Y-m-d H:i:s");
		$user_email = $this->session->userdata('login_emp_id');

		if (isset($_REQUEST['tc_id'])) {
			$tc_id = $_REQUEST['tc_id'];
		} else {
			$tc_id = '';
		}
		if (isset($_REQUEST['customer_id'])) {
			$customer_id = $_REQUEST['customer_id'];
		} else {
			$customer_id = '';
		}
		if (isset($_REQUEST['entry_date'])) {
			$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);
		} else {
			$entry_date = date('Y-m-d');
		}
		if (isset($_REQUEST['invoice_no'])) {
			$invoice_no = $_REQUEST['invoice_no'];
		} else {
			$invoice_no = '';
		}
		if (isset($_REQUEST['certificate_no'])) {
			$certificate_no = $_REQUEST['certificate_no'];
		} else {
			$certificate_no = '';
		}
		if (isset($_REQUEST['no_coil'])) {
			$no_coil = $_REQUEST['no_coil'];
		} else {
			$no_coil = '';
		}
		if (isset($_REQUEST['size'])) {
			$size = number_format((float) $_REQUEST['size'], 3);
		} else {
			$size = '';
		}
		if (isset($_REQUEST['weight'])) {
			$weight = $_REQUEST['weight'];
		} else {
			$weight = '';
		}
		if (isset($_REQUEST['product_type'])) {
			$product_type = $_REQUEST['product_type'];
		} else {
			$product_type = '';
		}
		if (isset($_REQUEST['product_name'])) {
			$product_name = $_REQUEST['product_name'];
		} else {
			$product_name = '';
		}
		if (isset($_REQUEST['invoice_date'])) {
			$invoice_date = $this->Base->change_date_ymd($_REQUEST['invoice_date']);
		} else {
			$entry_date = date('Y-m-d');
		}

		if (isset($_REQUEST['c_min'])) {
			$c_min = number_format((float) $_REQUEST['c_min'], 3);
		} else {
			$c_min = '';
		}
		if (isset($_REQUEST['mn_min'])) {
			$mn_min = number_format((float) $_REQUEST['mn_min'], 3);
		} else {
			$mn_min = '';
		}
		if (isset($_REQUEST['si_min'])) {
			$si_min = number_format((float) $_REQUEST['si_min'], 3);
		} else {
			$si_min = '';
		}
		if (isset($_REQUEST['p_min'])) {
			$p_min = number_format((float) $_REQUEST['p_min'], 3);
		} else {
			$p_min = '';
		}
		if (isset($_REQUEST['s_min'])) {
			$s_min = number_format((float) $_REQUEST['s_min'], 3);
		} else {
			$s_min = '';
		}
		if (isset($_REQUEST['heatno_1'])) {
			$heatno_1 = $_REQUEST['heatno_1'];
		} else {
			$heatno_1 = '';
		}



		if (isset($_REQUEST['c_max'])) {
			$c_max = number_format((float) $_REQUEST['c_max'], 3);
		} else {
			$c_max = '';
		}
		if (isset($_REQUEST['mn_max'])) {
			$mn_max = number_format((float) $_REQUEST['mn_max'], 3);
		} else {
			$mn_max = '';
		}
		if (isset($_REQUEST['si_max'])) {
			$si_max = number_format((float) $_REQUEST['si_max'], 3);
		} else {
			$si_max = '';
		}
		if (isset($_REQUEST['p_max'])) {
			$p_max = number_format((float) $_REQUEST['p_max'], 3);
		} else {
			$p_max = '';
		}
		if (isset($_REQUEST['s_max'])) {
			$s_max = number_format((float) $_REQUEST['s_max'], 3);
		} else {
			$s_max = '';
		}
		if (isset($_REQUEST['heatno_2'])) {
			$heatno_2 = $_REQUEST['heatno_2'];
		} else {
			$heatno_2 = '';
		}

		if (isset($_REQUEST['c_obs'])) {
			$c_obs = number_format((float) $_REQUEST['c_obs'], 3);
		} else {
			$c_obs = '';
		}
		if (isset($_REQUEST['mn_obs'])) {
			$mn_obs = number_format((float) $_REQUEST['mn_obs'], 3);
		} else {
			$mn_obs = '';
		}
		if (isset($_REQUEST['si_obs'])) {
			$si_obs = number_format((float) $_REQUEST['si_obs'], 3);
		} else {
			$si_obs = '';
		}
		if (isset($_REQUEST['p_obs'])) {
			$p_obs = number_format((float) $_REQUEST['p_obs'], 3);
		} else {
			$p_obs = '';
		}
		if (isset($_REQUEST['s_obs'])) {
			$s_obs = number_format((float) $_REQUEST['s_obs'], 3);
		} else {
			$s_obs = '';
		}
		if (isset($_REQUEST['heatno_3'])) {
			$heatno_3 = $_REQUEST['heatno_3'];
		} else {
			$heatno_3 = '';
		}


		// //------------------row
		if (isset($_REQUEST['coilno'])) {
			$coilno = explode('~', $_REQUEST['coilno']);
			$no_of_row = count($coilno);
		} else {
			$coilno = '';
			$no_of_row = 0;
		}
		if (isset($_REQUEST['diameter'])) {
			$diameter = explode('~', $_REQUEST['diameter']);
		} else {
			$diameter = '';
		}
		if (isset($_REQUEST['uts'])) {
			$uts = explode('~', $_REQUEST['uts']);
		} else {
			$uts = '';
		}
		if (isset($_REQUEST['torsiontest'])) {
			$torsiontest = explode('~', $_REQUEST['torsiontest']);
		} else {
			$torsiontest = '';
		}
		if (isset($_REQUEST['raper'])) {
			$raper = explode('~', $_REQUEST['raper']);
		} else {
			$raper = '';
		}
		if (isset($_REQUEST['zinc'])) {
			$zinc = explode('~', $_REQUEST['zinc']);
		} else {
			$zinc = '';
		}
		if (isset($_REQUEST['bend'])) {
			$bend = explode('~', $_REQUEST['bend']);
		} else {
			$bend = '';
		}
		if (isset($_REQUEST['surface'])) {
			$surface = explode('~', $_REQUEST['surface']);
		} else {
			$surface = '';
		}
		if (isset($_REQUEST['remarks'])) {
			$remarks = explode('~', $_REQUEST['remarks']);
		} else {
			$remarks = '';
		}




		//delete
		$where2 = array('tc_id' => $tc_id);
		$this->Mymodel->deletedata('qc_tc_spec', $where2);

		//save into qc spac
		$where = " product_type='$product_type' and size='$size' ";
		$res_chk = $this->Mymodel->select_where('qc_chemical_mech_properties', $where);
		if (isset($res_chk) and count($res_chk) > 0) {
			$cm_id = $res_chk[0]['cm_id'];
		}
		if (isset($cm_id)) {
			// no entry
			$qc_spec_id = 0;
		} else {
			//product not found so new entry
			$data = array(
				'product_type' => "$product_type",
				'size' => "$size",
				'c1' => "$c_min",
				'c2' => "$c_max",
				'mn1' => "$mn_min",
				'mn2' => "$mn_max",
				'si1' => "$si_min",
				'si2' => "$product_type",
				'p1' => "$p_min",
				'p2' => "$p_max",
				's1' => "$s_min",
				's2' => "$s_max",
			);
			$qc_spec_id = $this->Mymodel->insertdata_withid('qc_chemical_mech_properties', $data);
		} //qc spec



		//----------------------------------------------------------------------insert
		if (empty($_REQUEST['tc_id']) and !empty($_REQUEST['customer_id'])) {
			$where = " customer_id='$customer_id' and entry_date='$entry_date' and invoice_no='$invoice_no' and certificate_no='$certificate_no' ";
			$res_chk = $this->Mymodel->select_where('qc_tc', $where);
			if (isset($res_chk) and count($res_chk) > 0) {
				$id2 = $res_chk[0]['tc_id'];
			}
			if (isset($id2)) {
				echo "$invoice_no with $certificate_no on $entry_date with same customer are Already Available";
			} else {
				$data = array(
					'customer_id' => "$customer_id",
					'entry_date' => "$entry_date",
					'invoice_no' => "$invoice_no",
					'certificate_no' => "$certificate_no",
					'no_coil' => "$no_coil",
					'size' => "$size",
					'weight' => "$weight",
					'product_type' => "$product_type",
					'product_name' => "$product_name",
					'invoice_date' => "$invoice_date",

					'c_min' => "$c_min",
					'mn_min' => "$mn_min",
					'si_min' => "$si_min",
					'p_min' => "$p_min",
					's_min' => "$s_min",
					'heatno_1' => "$heatno_1",

					'c_max' => "$c_max",
					'mn_max' => "$mn_max",
					'si_max' => "$si_max",
					'p_max' => "$p_max",
					's_max' => "$s_max",
					'heatno_2' => "$heatno_2",

					'c_obs' => "$c_obs",
					'mn_obs' => "$mn_obs",
					'si_obs' => "$si_obs",
					'p_obs' => "$p_obs",
					's_obs' => "$s_obs",
					'heatno_3' => "$heatno_3",

					'save_by' => "$user_email",
					'save_date' => "$today",

				);
				$qc_tc_id = $this->Mymodel->insertdata_withid('qc_tc', $data);
				//insert
				$i = 0;
				if (!empty($coilno)) {
					foreach ($coilno as $c) {

						if (!empty($coilno[$i])) {
							if (!empty($diameter[$i])) {
								$diameter2 = number_format((float) $diameter[$i], 3);
							} else {
								$diameter2 = "";
							}
							if (!empty($uts[$i])) {
								$uts2 = number_format((float) $uts[$i], 2);
							} else {
								$uts2 = "";
							}

							$data2 = array(
								'tc_id' => "$qc_tc_id",
								'coilno' => "$coilno[$i]",
								'diameter' => "$diameter2",
								'uts' => "$uts2",
								'torsiontest' => "$torsiontest[$i]",
								'raper' => "$raper[$i]",
								'zinc' => "$zinc[$i]",
								'bend' => "$bend[$i]",
								'surface' => "$surface[$i]",
								'remarks' => "$remarks[$i]",
							);
							$this->Mymodel->insertdata('qc_tc_spec', $data2);



							//---------------------------------update entry into qc spec
							if ($qc_spec_id > 0) {
								if ($coilno[$i] == 'Min') {
									$data4 = array(
										'dia1' => "$diameter2",
										'uts1' => "$uts2",
										'tor1' => "$torsiontest[$i]",
										'ra1' => "$raper[$i]",
										'zinc1' => "$zinc[$i]",
										'bend1' => "$bend[$i]",
										'surface1' => "$surface[$i]",
										'remarks1' => "$remarks[$i]",
									);
									$where4 = array('cm_id ' => "$qc_spec_id");
									$this->Mymodel->update('qc_chemical_mech_properties', $data4, $where4);
								} else if ($coilno[$i] == 'Max') {
									$data4 = array(
										'dia2' => "$diameter2",
										'uts2' => "$uts2",
										'tor2' => "$torsiontest[$i]",
										'ra2' => "$raper[$i]",
										'zinc2' => "$zinc[$i]",
										'bend2' => "$bend[$i]",
										'surface2' => "$surface[$i]",
										'remarks2' => "$remarks[$i]",
									);
									$where4 = array('cm_id ' => "$qc_spec_id");
									$this->Mymodel->update('qc_chemical_mech_properties', $data4, $where4);
								}
							} //if($qc_spec_id > 0){
							//-----------------end----------------update entry into qc spec
						} //!empty

						$i++;
					} //foeach
				}

				echo "Save";
			}

		} //insert




		//------------------------------------------------------------------update
		elseif (!empty($_REQUEST['tc_id']) and !empty($_REQUEST['customer_id'])) {

			$where = " customer_id='$customer_id' and entry_date='$entry_date' and invoice_no='$invoice_no' and certificate_no='$certificate_no' ";
			$res_chk = $this->Mymodel->select_where('qc_tc', $where);
			if (isset($res_chk) and count($res_chk) > 0) {
				$id2 = $res_chk[0]['tc_id'];
			}
			if (isset($id2) and $tc_id != $id2) {
				echo "$invoice_no with $certificate_no on $entry_date with same customer are Already Available";
			} else {
				$data = array(
					'customer_id' => "$customer_id",
					'entry_date' => "$entry_date",
					'invoice_no' => "$invoice_no",
					'certificate_no' => "$certificate_no",
					'no_coil' => "$no_coil",
					'size' => "$size",
					'weight' => "$weight",
					'product_type' => "$product_type",
					'product_name' => "$product_name",
					'invoice_date' => "$invoice_date",

					'c_min' => "$c_min",
					'mn_min' => "$mn_min",
					'si_min' => "$si_min",
					'p_min' => "$p_min",
					's_min' => "$s_min",
					'heatno_1' => "$heatno_1",

					'c_max' => "$c_max",
					'mn_max' => "$mn_max",
					'si_max' => "$si_max",
					'p_max' => "$p_max",
					's_max' => "$s_max",
					'heatno_2' => "$heatno_2",

					'c_obs' => "$c_obs",
					'mn_obs' => "$mn_obs",
					'si_obs' => "$si_obs",
					'p_obs' => "$p_obs",
					's_obs' => "$s_obs",
					'heatno_3' => "$heatno_3",

					'update_by' => "$user_email",
					'update_date' => "$today",

				);
				$where = array('tc_id' => "$tc_id");
				$this->Mymodel->update('qc_tc', $data, $where);

				//insert
				$qc_tc_id = $tc_id;
				$i = 0;
				if (!empty($coilno)) {
					foreach ($coilno as $c) {

						if (!empty($coilno[$i])) {
							if (!empty($diameter[$i])) {
								$diameter2 = number_format((float) $diameter[$i], 3);
							} else {
								$diameter2 = "";
							}
							if (!empty($uts[$i])) {
								$uts2 = number_format((float) $uts[$i], 2);
							} else {
								$uts2 = "";
							}

							$data2 = array(
								'tc_id' => "$qc_tc_id",
								'coilno' => "$coilno[$i]",
								'diameter' => "$diameter2",
								'uts' => "$uts2",
								'torsiontest' => "$torsiontest[$i]",
								'raper' => "$raper[$i]",
								'zinc' => "$zinc[$i]",
								'bend' => "$bend[$i]",
								'surface' => "$surface[$i]",
								'remarks' => "$remarks[$i]",
							);
							$this->Mymodel->insertdata('qc_tc_spec', $data2);

							//---------------------------------update entry into qc spec
							if ($qc_spec_id > 0) {
								if ($coilno[$i] == 'Min') {
									$data4 = array(
										'dia1' => "$diameter2",
										'uts1' => "$uts2",
										'tor1' => "$torsiontest[$i]",
										'ra1' => "$raper[$i]",
										'zinc1' => "$zinc[$i]",
										'bend1' => "$bend[$i]",
										'surface1' => "$surface[$i]",
										'remarks1' => "$remarks[$i]",
									);
									$where4 = array('cm_id ' => "$qc_spec_id");
									$this->Mymodel->update('qc_chemical_mech_properties', $data4, $where4);
								} else if ($coilno[$i] == 'Max') {
									$data4 = array(
										'dia2' => "$diameter2",
										'uts2' => "$uts2",
										'tor2' => "$torsiontest[$i]",
										'ra2' => "$raper[$i]",
										'zinc2' => "$zinc[$i]",
										'bend2' => "$bend[$i]",
										'surface2' => "$surface[$i]",
										'remarks2' => "$remarks[$i]",
									);
									$where4 = array('cm_id ' => "$qc_spec_id");
									$this->Mymodel->update('qc_chemical_mech_properties', $data4, $where4);
								}
							} //if($qc_spec_id > 0){
							//-----------------end----------------update entry into qc spec
						} //!empty

						$i++;
					} //foeach
				} //if

				echo "Update";
			} //not repeat
		} else {
			//exit
			echo "Not Save. Try Again. No Data Found.";
		} //exit

	} //function close






	//add /edit new pickling
	public function pickling_test_add()
	{
		
		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Qcmodel->get_pickling_test_data_with_id($id);
		} //strlen
		else{
			$result['res2'] =  "";
		}
		$this->load->view('qc/pickling/entry', $result);
	} //function close


	//list search
	public function list_pickling_test()
	{
		if (isset($_REQUEST['search1'])) {
			$where = " ";
			if (!empty($_REQUEST['shift'])) {$shift = $_REQUEST['shift'];$where .= " and  A.shift='$shift'   ";}
			if (!empty($_REQUEST['show_type'])) {$show_type = $_REQUEST['show_type'];}else{$show_type =1;}
			
			
			if (!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2'])) {
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where .= "  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where .= "  ORDER by A.entry_date,shift ";

			$result['res2'] = $this->Qcmodel->get_pickling_test_with_search($where);
			//print_r($result['res2']);
			if($show_type == 1){$this->load->view('qc/pickling/show_table', $result);}else{$this->load->view('qc/pickling/show_table2', $result);}
			
		} else {
			$search_date1 = date('Y-m-d');
			$search_date2 = date('Y-m-d');
			$where = " and A.entry_date between '$search_date1' and '$search_date2'   ORDER by A.entry_date,shift  ";
			$result['res2'] = $this->Qcmodel->get_pickling_test_with_search($where);
			$this->load->view('qc/pickling/show', $result);
		} //search
	} //function close



	
	
	//save pickling_test_save
	public function pickling_test_save()
	{
		$today = date("Y-m-d H:i:s");
		$login_username = $this->session->userdata('login_emp_id');

		if (isset($_REQUEST['id'])) {$id = $_REQUEST['id'];} else {$id = '';}
		if (isset($_REQUEST['entry_date'])) {$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);} else {$entry_date = date('Y-m-d');}
		if (isset($_REQUEST['shift'])) {$shift = $_REQUEST['shift'];} else {$shift = '';}

		if (isset($_REQUEST['qc_person'])) {$qc_person = $_REQUEST['qc_person'];} else {$qc_person = '';}
		if (isset($_REQUEST['tank1_connc'])) {$tank1_connc = $_REQUEST['tank1_connc'];} else {$tank1_connc = '';}
		if (isset($_REQUEST['tank1_fe'])) {$tank1_fe = $_REQUEST['tank1_fe'];} else {$tank1_fe = '';}

		if (isset($_REQUEST['tank2_connc'])) {$tank2_connc = $_REQUEST['tank2_connc'];} else {$tank2_connc = '';}
		if (isset($_REQUEST['tank2_fe'])) {$tank2_fe = $_REQUEST['tank2_fe'];} else {$tank2_fe = '';}
		if (isset($_REQUEST['tank3_connc'])) {$tank3_connc = $_REQUEST['tank3_connc'];} else {$tank3_connc = '';}
		if (isset($_REQUEST['tank3_fe'])) {$tank3_fe = $_REQUEST['tank3_fe'];} else {$tank3_fe = '';}
		if (isset($_REQUEST['gl_tank1_connc'])) {$gl_tank1_connc = $_REQUEST['gl_tank1_connc'];} else {$gl_tank1_connc = '';}
		if (isset($_REQUEST['gl_tank1_fe'])) {$gl_tank1_fe = $_REQUEST['gl_tank1_fe'];} else {$gl_tank1_fe = '';}

		if (isset($_REQUEST['gl_tank2_connc'])) {$gl_tank2_connc = $_REQUEST['gl_tank2_connc'];} else {$gl_tank2_connc = '';}
		if (isset($_REQUEST['gl_tank2_fe'])) {$gl_tank2_fe = $_REQUEST['gl_tank2_fe'];} else {$gl_tank2_fe = '';}
		if (isset($_REQUEST['flux_gravity'])) {$flux_gravity = $_REQUEST['flux_gravity'];} else {$flux_gravity = '';}

		if (isset($_REQUEST['flux_temp'])) {$flux_temp = $_REQUEST['flux_temp'];} else {$flux_temp = '';}
		if (isset($_REQUEST['water_ph'])) {$water_ph = $_REQUEST['water_ph'];} else {$water_ph = '';}
		if (isset($_REQUEST['phos_connc'])) {$phos_connc = $_REQUEST['phos_connc'];} else {$phos_connc = '';}
		if (isset($_REQUEST['phos_fe'])) {$phos_fe = $_REQUEST['phos_fe'];} else {$phos_fe = '';}
		if (isset($_REQUEST['phos_fa'])) {$phos_fa = $_REQUEST['phos_fa'];} else {$phos_fa = '';}
		if (isset($_REQUEST['phos_acc'])) {$phos_acc = $_REQUEST['phos_acc'];} else {$phos_acc = '';}

		if (isset($_REQUEST['phos_cl'])) {$phos_cl = $_REQUEST['phos_cl'];} else {$phos_cl = '';}
		if (isset($_REQUEST['phos_temp'])) {$phos_temp = $_REQUEST['phos_temp'];} else {$phos_temp = '';}
		if (isset($_REQUEST['borex_conc'])) {$borex_conc = $_REQUEST['borex_conc'];} else {$borex_conc = '';}
		if (isset($_REQUEST['borex_temp'])) {$borex_temp = $_REQUEST['borex_temp'];} else {$borex_temp = '';}
		

		//----------------------------------------------------------------------insert
		if (empty($_REQUEST['id']) and !empty($_REQUEST['entry_date']) and !empty($_REQUEST['shift']) and !empty($_REQUEST['qc_person'])) {
			
				$data = array(
					'entry_date' => "$entry_date",
					'shift' => "$shift",
					
					'qc_person' => "$qc_person",
					'tank1_connc' => "$tank1_connc",
					'tank1_fe' => "$tank1_fe",

					'tank2_connc' => "$tank2_connc",
					'tank2_fe' => "$tank2_fe",
					'tank3_connc' => "$tank3_connc",

					'tank3_fe' => "$tank3_fe",
					'gl_tank1_connc' => "$gl_tank1_connc",
					'gl_tank1_fe' => "$gl_tank1_fe",

					'gl_tank2_connc' => "$gl_tank2_connc",
					'gl_tank2_fe' => "$gl_tank2_fe",
					'flux_gravity' => "$flux_gravity",

					'flux_temp' => "$flux_temp",
					'water_ph' => "$water_ph",
					'phos_connc' => "$phos_connc",

					'phos_fe' => "$phos_fe",
					'phos_fa' => "$phos_fa",
					'phos_acc' => "$phos_acc",
					
					'phos_cl' => "$phos_cl",
					'phos_temp' => "$phos_temp",
					'borex_conc' => "$borex_conc",
					'borex_temp' => "$borex_temp",

					'save_by' => "$login_username",
					'save_date' => "$today",

				);
				$qc_spec1_id = $this->Mymodel->insertdata_withid('qc_pickling_test', $data);
				echo "Save";
			

		} //insert




		//------------------------------------------------------------------update
		elseif (!empty($_REQUEST['id']) and !empty($_REQUEST['entry_date']) and !empty($_REQUEST['shift']) and !empty($_REQUEST['qc_person'])) {
				$data = array(
					'entry_date' => "$entry_date",
					'shift' => "$shift",
					
					'qc_person' => "$qc_person",
					'tank1_connc' => "$tank1_connc",
					'tank1_fe' => "$tank1_fe",

					'tank2_connc' => "$tank2_connc",
					'tank2_fe' => "$tank2_fe",
					'tank3_connc' => "$tank3_connc",

					'tank3_fe' => "$tank3_fe",
					'gl_tank1_connc' => "$gl_tank1_connc",
					'gl_tank1_fe' => "$gl_tank1_fe",

					'gl_tank2_connc' => "$gl_tank2_connc",
					'gl_tank2_fe' => "$gl_tank2_fe",
					'flux_gravity' => "$flux_gravity",

					'flux_temp' => "$flux_temp",
					'water_ph' => "$water_ph",
					'phos_connc' => "$phos_connc",

					'phos_fe' => "$phos_fe",
					'phos_fa' => "$phos_fa",
					'phos_acc' => "$phos_acc",
					
					'phos_cl' => "$phos_cl",
					'phos_temp' => "$phos_temp",
					'borex_conc' => "$borex_conc",
					'borex_temp' => "$borex_temp",

					'update_by' => "$login_username",
					'update_date' => "$today",

				);
				$where = array('id' => "$id");
				$this->Mymodel->update('qc_pickling_test', $data, $where);
				echo "Update";
			
		} else {
			//exit
			echo "Not Save. Try Again. No Data Found.";
		} //exit

	} //function close









	//Qc incoming materail test
	public function add_incoming_qc_test()
	{
		$result['supplier'] = $this->Suppliermodel->get_all_active_supplier();
		if (strlen($this->uri->segment(3)) > 0) {
			$invoice_deatils_id = $this->uri->segment(3);
			//$result['res2'] = $this->Pomodel->get_po_invoice_details_with_id($id);
			$result['res3'] = $this->Pomodel->get_po_invoice_product_details_with_podetails_id($invoice_deatils_id);
			$result['res4'] = $this->Pomodel->get_po_invoice_qc_row_test_with_invoice_id($invoice_deatils_id);
			$result['res5'] = $this->Pomodel->get_po_invoice_qc_row_test_coils_with_invoice_id($invoice_deatils_id);
			$result['heat'] = $this->Pomodel->get_po_invoice_qc_row_heat_with_invoice_id($invoice_deatils_id);
		} //strlen
		//$result['customer'] = $this->Customermodel->get_all_active_customer();
		$result['grade'] = $this->Base->get_all_grade();
		$result['product_type'] = $this->Base->get_all_product_type();
		$this->load->view('qc/in_row_test/entry', $result);
	} //function close


	//save new incoming materail test save
	public function in_row_save()
	{
		$today = date("Y-m-d H:i:s");
		$user_email = $this->session->userdata('login_emp_id');

		if (isset($_REQUEST['invoice_deatils_id'])) {$invoice_deatils_id = $_REQUEST['invoice_deatils_id'];} else {$invoice_deatils_id = '';}
		if (isset($_REQUEST['entry_date'])) {$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);} else {$entry_date = date('Y-m-d');}
		if (isset($_REQUEST['product_grade'])) {$product_grade = $_REQUEST['product_grade'];} else {$product_grade = '';}

		if (isset($_REQUEST['product_type'])) {$product_type = $_REQUEST['product_type'];} else {$product_type = '';}
		
		if (isset($_REQUEST['finish_size'])) {$finish_size = $_REQUEST['finish_size'];} else {$finish_size = '';}
		if (isset($_REQUEST['total_coils'])) {$total_coils = $_REQUEST['total_coils'];} else {$total_coils = '';}

		if (isset($_REQUEST['min_bl'])) {$min_bl = $_REQUEST['min_bl'];} else {$min_bl = '';}
		if (isset($_REQUEST['max_bl'])) {$max_bl = $_REQUEST['max_bl'];} else {$max_bl = '';}
		
		$finish_size2 = number_format((float) $finish_size, 3);


		/*
		if (isset($_REQUEST['c_val'])) {$c_val = $_REQUEST['c_val'];} else {$c_val = '';}
		if (isset($_REQUEST['mn_val'])) {$mn_val = $_REQUEST['mn_val'];} else {$mn_val = '';}
		if (isset($_REQUEST['p_val'])) {$p_val = $_REQUEST['p_val'];} else {$p_val = '';}
		if (isset($_REQUEST['s_val'])) {$s_val = $_REQUEST['s_val'];} else {$s_val = '';}
		if (isset($_REQUEST['si_val'])) {$si_val = $_REQUEST['si_val'];} else {$si_val = '';}
		if (isset($_REQUEST['total_al'])) {$total_al = $_REQUEST['total_al'];} else {$total_al = '';}
		if (isset($_REQUEST['cr_val'])) {$cr_val = $_REQUEST['cr_val'];} else {$cr_val = '';}
		if (isset($_REQUEST['co_val'])) {$co_val = $_REQUEST['co_val'];} else {$co_val = '';}
		if (isset($_REQUEST['ni_val'])) {$ni_val = $_REQUEST['ni_val'];} else {$ni_val = '';}
		if (isset($_REQUEST['mo_val'])) {$mo_val = $_REQUEST['mo_val'];} else {$mo_val = '';}
		if (isset($_REQUEST['ceq_val'])) {$ceq_val = $_REQUEST['ceq_val'];} else {$ceq_val = '';}
		if (isset($_REQUEST['n2_val'])) {$n2_val = $_REQUEST['n2_val'];} else {$n2_val = '';}
		if (isset($_REQUEST['is_grade'])) {$is_grade = $_REQUEST['is_grade'];} else {$is_grade = '';}
		if (isset($_REQUEST['equivalent'])) {$equivalent = $_REQUEST['equivalent'];} else {$equivalent = '';}
		*/

		//row
		//------------------row
		if (isset($_REQUEST['qcheatId'])) {$qcheatId = explode('~', $_REQUEST['qcheatId']);} else {$qcheatId = '';}
		if (isset($_REQUEST['heatnolist'])) {$heatnolist = explode('~', $_REQUEST['heatnolist']);$no_of_row2 = count($heatnolist);} else {$heatnolist = '';$no_of_row2 = 0;}
		if (isset($_REQUEST['cval'])) {$cval = explode('~', $_REQUEST['cval']);} else {$cval = '';}
		if (isset($_REQUEST['mnval'])) {$mnval = explode('~', $_REQUEST['mnval']);} else {$mnval = '';}
		if (isset($_REQUEST['pval'])) {$pval = explode('~', $_REQUEST['pval']);} else {$pval = '';}
		if (isset($_REQUEST['sval'])) {$sval = explode('~', $_REQUEST['sval']);} else {$sval = '';}
		if (isset($_REQUEST['sival'])) {$sival = explode('~', $_REQUEST['sival']);} else {$sival = '';}
		if (isset($_REQUEST['totalal'])) {$totalal = explode('~', $_REQUEST['totalal']);} else {$totalal = '';}
		if (isset($_REQUEST['crval'])) {$crval = explode('~', $_REQUEST['crval']);} else {$crval = '';}
		if (isset($_REQUEST['coval'])) {$coval = explode('~', $_REQUEST['coval']);} else {$coval = '';}
		if (isset($_REQUEST['nival'])) {$nival = explode('~', $_REQUEST['nival']);} else {$nival = '';}
		if (isset($_REQUEST['moval'])) {$moval = explode('~', $_REQUEST['moval']);} else {$moval = '';}
		if (isset($_REQUEST['ceqval'])) {$ceqval = explode('~', $_REQUEST['ceqval']);} else {$ceqval = '';}
		if (isset($_REQUEST['n2val'])) {$n2val = explode('~', $_REQUEST['n2val']);} else {$n2val = '';}
		if (isset($_REQUEST['isgrade'])) {$isgrade = explode('~', $_REQUEST['isgrade']);} else {$isgrade = '';}
		if (isset($_REQUEST['equivalent'])) {$equivalent = explode('~', $_REQUEST['equivalent']);} else {$equivalent = '';}

		if (isset($_REQUEST['ysval'])) {$ysval = explode('~', $_REQUEST['ysval']);} else {$ysval = '';}
		if (isset($_REQUEST['utsval'])) {$utsval = explode('~', $_REQUEST['utsval']);} else {$utsval = '';}
		if (isset($_REQUEST['elval'])) {$elval = explode('~', $_REQUEST['elval']);} else {$elval = '';}
		if (isset($_REQUEST['raval'])) {$raval = explode('~', $_REQUEST['raval']);} else {$raval = '';}



		
		//row
		//------------------row
		if (isset($_REQUEST['coilno'])) {$coilno = explode('~', $_REQUEST['coilno']);$no_of_row = count($coilno);} else {$coilno = '';$no_of_row = 0;}
		if (isset($_REQUEST['heatno'])) {$heatno = explode('~', $_REQUEST['heatno']);} else {$heatno = '';}
		if (isset($_REQUEST['qcTestId'])) {$qcTestId = explode('~', $_REQUEST['qcTestId']);} else {$qcTestId = '';}
		if (isset($_REQUEST['finishsize'])) {$finishsize = explode('~', $_REQUEST['finishsize']);} else {$finishsize = '';}
		if (isset($_REQUEST['breakingload'])) {$breakingload = explode('~', $_REQUEST['breakingload']);} else {$breakingload = '';}
		if (isset($_REQUEST['uts'])) {$uts = explode('~', $_REQUEST['uts']);} else {$uts = '';}
		if (isset($_REQUEST['torsiontest'])) {$torsiontest = explode('~', $_REQUEST['torsiontest']);} else {$torsiontest = '';}
		if (isset($_REQUEST['bendtest'])) {$bendtest = explode('~', $_REQUEST['bendtest']);} else {$bendtest = '';}
		if (isset($_REQUEST['raper'])) {$raper = explode('~', $_REQUEST['raper']);} else {$raper = '';}
		if (isset($_REQUEST['rdarea'])) {$rdarea = explode('~', $_REQUEST['rdarea']);} else {$rdarea = '';}
		if (isset($_REQUEST['remarks'])) {$remarks = explode('~', $_REQUEST['remarks']);} else {$remarks = '';}

		
		
		//------------------------------------------------------------------update
		if (!empty($_REQUEST['invoice_deatils_id']) ) {
			
				$data = array(
					'invoice_deatils_id' => "$invoice_deatils_id",
					'qc_row_test_date' => "$entry_date",
					'product_grade' => "$product_grade",
					'product_type' => "$product_type",
					
					'finish_size' => "$finish_size2",
					'total_coils' => "$total_coils",
					'min_bl' => "$min_bl",
					'max_bl' => "$max_bl",
					
					'update_by' => "$user_email",
					'update_date' => "$today",
				);
				
				$where = " invoice_deatils_id='$invoice_deatils_id'  ";
				$res_chk = $this->Mymodel->select_where('product_invoice_row_qc_test', $where);
				if (isset($res_chk) and count($res_chk) > 0) {
					//update
					$where = array('invoice_deatils_id' => "$invoice_deatils_id");
					$this->Mymodel->update('product_invoice_row_qc_test', $data, $where);
				}else{
					//new entry
					$this->Mymodel->insertdata('product_invoice_row_qc_test', $data);
				}
				


				//insert ------------------------------------------------------------------------------heatno details  
				$i = 0;
				foreach ($heatnolist as $c) {
					if (!empty($heatnolist[$i])) {
						$newHeatNoid = strtoupper($heatnolist[$i]);
						$data3 = array(
							'invoice_deatils_id' => "$invoice_deatils_id",
							'heatno' => "$newHeatNoid",
							'product_grade' => "$product_grade",
							'product_type' => "$product_type",
							'finish_size' => "$finish_size2",
							'c_val' => "$cval[$i]",
							'mn_val' => "$mnval[$i]",
							'p_val' => "$pval[$i]",
							's_val' => "$sval[$i]",
							'si_val' => "$sival[$i]",
							'total_al' => "$totalal[$i]",
							'cr_val' => "$crval[$i]",
							'co_val' => "$coval[$i]",
							'ni_val' => "$nival[$i]",
							'mo_val' => "$moval[$i]",
							'ceq_val' => "$ceqval[$i]",
							'n2_val' => "$n2val[$i]",
							'is_grade' => "$isgrade[$i]",
							'equivalent' => "$equivalent[$i]",
							'ys_val' => "$ysval[$i]",
							'uts_val' => "$utsval[$i]",
							'el_val' => "$elval[$i]",
							'ra_val' => "$raval[$i]",
						);

						if ($qcheatId[$i] > 0) {
							//update
							$where3 = array('row_qc_heat_id' => "$qcheatId[$i]");
							$this->Mymodel->update('product_invoice_row_heatdeatils', $data3, $where3);
						}else{
							//new
							$this->Mymodel->insertdata('product_invoice_row_heatdeatils', $data3);
						}//if ($qcTestId[$i] > 0) {

						/*
						$where = " invoice_deatils_id='$invoice_deatils_id' and heatno='$newHeatNoid' and product_grade='$product_grade' and product_type='$product_type' and finish_size= '$finish_size2'  ";
						$res_chk = $this->Mymodel->select_where('product_invoice_row_heatdeatils', $where);
						if (isset($res_chk) and count($res_chk) > 0) {
							//update
							$where3 = array(
												'invoice_deatils_id' => "$invoice_deatils_id",
												'heatno' => "$newHeatNoid",
												'product_grade' => "$product_grade",
												'product_type' => "$product_type",
												'finish_size' => "$finish_size",
											);
							$this->Mymodel->update('product_invoice_row_heatdeatils', $data3, $where3);
						}else{
							//new entry
							$this->Mymodel->insertdata('product_invoice_row_heatdeatils', $data3);
						}
						*/
						
					}//if ($heatnolist[$i] > 0) {
					$i++;
				} //foeach
				

				//insert -------------------------------------------------------------------------------------coil wise test 
				$i = 0;
				foreach ($coilno as $c) {
					if ($breakingload[$i] > 0) {
						
						$bl_category = $this->Base->get_breakingload_category($min_bl,$max_bl,$breakingload[$i]);//getting stage of bl
						$bl_color = $this->Base->get_breakingload_color($bl_category[6]);
						$uts2 = $this->Base->get_uts_from_breakingload_size($breakingload[$i], $finish_size2);
						$newHeatNoid2 = strtoupper($heatno[$i]);
						$data2 = array(
							'invoice_deatils_id' => "$invoice_deatils_id",
							'heat_no' => "$newHeatNoid2",
							'coil_no' => "$c",
							'finish_size' => "$finish_size2",
							'breaking_load' => "$breakingload[$i]",
							'uts' => "$uts2",
							'torsion_test' => "$torsiontest[$i]",
							'bend_test' => "$bendtest[$i]",
							'ra_per' => "$raper[$i]",
							'rdarea' => "$rdarea[$i]",
							'remarks' => "$remarks[$i]",
							'bl_category' => "$bl_category[6]",
							'bl_color' => "$bl_color",
							'coil_issue' => "0",
						);

						if ($qcTestId[$i] > 0) {
							//update
							$where2 = array('coil_test_d' => "$qcTestId[$i]");
							$this->Mymodel->update('product_invoice_row_qc_test_coilswise', $data2, $where2);
						}else{
							//new
							$this->Mymodel->insertdata('product_invoice_row_qc_test_coilswise', $data2);
						}//if ($qcTestId[$i] > 0) {
						
					}//if ($breakingload[$i] > 0) {
					$i++;
				} //foeach


				echo "Update";
			
		} else {
			//exit
			echo "Not Save. Try Again. No Data Found.";
		} //exit

	} //function close



	//add /edit new pickling
	public function pickling_production_entry()
	{
		$result['size'] = $this->Pomodel->get_all_not_issue_colino_groupby_size('ALL');//ALL means all, 0=not issue, 1=issued
		$result['heat'] = $this->Pomodel->get_all_not_issue_colino_groupby_heat('ALL');//ALL means all, 0=not issue, 1=issued
		$result['grade'] = $this->Pomodel->get_all_not_issue_colino_groupby_grade('ALL');//ALL means all, 0=not issue, 1=issued
		
		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Qcmodel->get_pickling_test_data_with_id($id);
		} //strlen
		else{
			$result['res2'] =  "";
		}
		$this->load->view('qc/pickling/production/entry', $result);
	} //function close


	//add /edit new pickling 2
	public function pickling_production_entry2()
	{
		$result['size'] = $this->Pomodel->get_all_not_issue_colino_groupby_size('ALL');//ALL means all, 0=not issue, 1=issued
		$result['heat'] = $this->Pomodel->get_all_not_issue_colino_groupby_heat('ALL');//ALL means all, 0=not issue, 1=issued
		$result['grade'] = $this->Pomodel->get_all_not_issue_colino_groupby_grade('ALL');//ALL means all, 0=not issue, 1=issued
		
		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Qcmodel->get_pickle_rod_data_with_id($id);
		} //strlen
		else{
			$result['res2'] =  array();
		}
		$this->load->view('qc/pickling/production/entry2', $result);
	} //function close
	//list search
	public function pickling_production_list()
	{
		$result['grade'] = $this->Base->get_all_grade();
		if (isset($_REQUEST['search1'])) {
			$where = " ";
			if (!empty($_REQUEST['actual_size'])) {
				$actual_size = $_REQUEST['actual_size'];
				$actual_size = number_format((float) $actual_size, 3);
				$where .= " and  P.finish_size='$actual_size'   ";
			}
			if (!empty($_REQUEST['product_grade'])) {$product_grade = $_REQUEST['product_grade'];$where .= " and  B.product_grade='$product_grade'   ";}
			
			if (!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2'])) {
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where .= "  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where .= " ORDER by A.entry_date,L.name,P.coil_no  ";

			$result['res2'] = $this->Qcmodel->get_all_pickling_production_with_search($where);
			$this->load->view('qc/pickling/production//show_table', $result);
		} else {
			$search_date1 = date('Y-m-d');
			$search_date2 = date('Y-m-d');
			$where = " and A.entry_date between '$search_date1' and '$search_date2'  ORDER by A.entry_date,L.name,P.coil_no  ";
			$result['res2'] = $this->Qcmodel->get_all_pickling_production_with_search($where);
			$this->load->view('qc/pickling/production//show', $result);
		} //search
	} //function close



	//get road data
	public function fun_get_rod_search()
	{
		if (isset($_REQUEST['search1']) && !empty($_REQUEST['size']) && !empty($_REQUEST['grade']) ) {
			
			$where = " ";
			if (!empty($_REQUEST['size'])) {$size = $_REQUEST['size'];$where .= " and  A.finish_size='$size'   ";}
			if (!empty($_REQUEST['grade'])) {$grade = $_REQUEST['grade'];$where .= " and  B.product_grade ='$grade'   ";}
			if (!empty($_REQUEST['heat']) && $_REQUEST['heat'] != "ALL") {$heat = $_REQUEST['heat'];$where .= " and  A.heat_no ='$heat'   ";}
			if (!empty($_REQUEST['blcategory'])  && $_REQUEST['blcategory'] != "ALL") {$blcategory = $_REQUEST['blcategory'];$where .= " and  A.bl_category ='$blcategory'   ";}
			
			if (!empty($_REQUEST['rodStatus'])) {
				$coil_issue = $_REQUEST['rodStatus'];
				if($coil_issue == 'zero'){ $where .= " and  A.coil_issue <1   ";  }
				elseif($coil_issue == 'one'){ $where .= " and  A.coil_issue = 1   ";  }
				else{  }
			}
			
			$where .= " ORDER BY A.coil_no,A.heat_no  ";
			//echo "<br><br><br>";
			$result = $this->Pomodel->get_all_not_issue_colino_search($where);
			if(!empty($result)){
				//print_r($result);
				?>
					<table border="1" width="100%">
						<tr>
							<th>Sno</th>
							<th>Choose Pickile Coil's</th>
							<th>Coil No</th>
							<th>Heat No</th>
							<th>Size</th>
							<th>BL Category</th>
							<th>Issue ?</th>
							<th>Issue Date</th>
							<th>Used in WD</th>
						</tr>
						<?php 
							$i=1;
							foreach($result as $r){
								if(isset($r['issue_date']) && $r['issue_date'] != '0000-00-00'){$issue_date=$this->Base->change_date_dmy($r['issue_date']);}else{$issue_date='';}
								?>
									<tr style="color:<?php if($r['coil_issue'] == 1){echo 'red';}?>; background-color:<?php if($r['coil_used'] == 1){echo 'pink';}?>" >
										<td><?php echo $i;?></td>
										<td> <input type="checkbox" <?php if($r['coil_issue'] == 1){echo "checked";}?>  name='coilId' value="<?php echo $r['coil_test_d'];?>"> </td>
										<td><?php echo $r['coil_no'];?></td>
										<td><?php echo $r['heat_no'];?></td>
										<td><?php echo $r['finish_size'];?></td>
										<td><?php echo $r['bl_category'];?></td>
										<td><?php if($r['coil_issue'] == 1){echo "Coil issued";}else{echo "Not issue ";}?></td>
										<td><?php echo $issue_date;?></td>
										<td style="color:black; ">
											<input type="checkbox" <?php if($r['coil_used'] == 1){echo "checked";}?>  name='coilUsedId' value="<?php echo $r['coil_test_d'];?>">
											<?php if($r['coil_used'] == 1){echo "Used";}?>
										</td>
									</tr>
								<?php
								$i++;
							}
						?>
					</table>
				<?php
			}//if(!empty($result)){
			else{
				echo "No data Found in this filter";
				exit;
			}
		} else {
			echo "Filter are required";
			exit;
		} //search
	} //function close


	//get road data
	public function fun_get_rod_search2()
	{
		?><option value="" >Select</option><?php
		if (isset($_REQUEST['search1']) && !empty($_REQUEST['size']) && !empty($_REQUEST['grade']) ) {
			
			$where = " ";
			if (!empty($_REQUEST['size'])) {$size = $_REQUEST['size'];$where .= " and  A.finish_size='$size'   ";}
			if (!empty($_REQUEST['grade'])) {$grade = $_REQUEST['grade'];$where .= " and  B.product_grade ='$grade'   ";}
			if (!empty($_REQUEST['heat']) && $_REQUEST['heat'] != "ALL") {$heat = $_REQUEST['heat'];$where .= " and  A.heat_no ='$heat'   ";}
			if (!empty($_REQUEST['blcategory'])  && $_REQUEST['blcategory'] != "ALL") {$blcategory = $_REQUEST['blcategory'];$where .= " and  A.bl_category ='$blcategory'   ";}
			
			if (!empty($_REQUEST['rodStatus'])) {
				$coil_issue = $_REQUEST['rodStatus'];
				if($coil_issue == 'zero'){ $where .= " and  A.coil_issue <1   ";  }
				elseif($coil_issue == 'one'){ $where .= " and  A.coil_issue = 1   ";  }
				else{  }
			}
			
			$where .= " ORDER BY A.coil_no,A.heat_no  ";
			//echo "<br><br><br>";
			$result = $this->Pomodel->get_all_not_issue_colino_search($where);
			if(!empty($result)){
				//print_r($result);
				
				foreach($result as $h)
				{
					?>
						<option value="<?php echo $h['coil_test_d'];?>" ><?php echo $h['coil_no'];?></option>
					<?php
				}
			}//if(!empty($result)){
			else{
				echo "No data Found in this filter";
				exit;
			}
		} else {
			echo "Filter are required";
			exit;
		} //search
	} //function close


	//get road data from plan //only use in plan page
	public function fun_get_rod_for_plan()
	{
		if (isset($_REQUEST['search1']) && !empty($_REQUEST['size']) && !empty($_REQUEST['grade']) ) {
			
			$where = " ";
			if (!empty($_REQUEST['size'])) {$size = $_REQUEST['size'];$where .= " and  A.finish_size='$size'   ";}
			if (!empty($_REQUEST['grade'])) {$grade = $_REQUEST['grade'];$where .= " and  B.product_grade ='$grade'   ";}
			
			if (!empty($_REQUEST['rodStatus'])) {
				$coil_issue = $_REQUEST['rodStatus'];
				if($coil_issue == 'zero'){ $where .= " and  A.coil_issue <1   ";  }
				elseif($coil_issue == 'one'){ $where .= " and  A.coil_issue = 1   ";  }
				else{  }
			}
			
			$where .= " ORDER BY A.bl_category ASC ";
			//echo "<br><br><br>";
			$result = $this->Pomodel->get_all_not_issue_colino_search($where);
			if(!empty($result)){
				//print_r($result);
				$this->Pomodel->fun_wire_rod_list($result,'');//'' is checked rod list
			}//if(!empty($result)){
			else{
				echo "No data Found in this filter";
				exit;
			}
		} else {
			echo "Filter are required";
			exit;
		} //search
	} //function close



	
	//get rod data 
	public function getAllWdCoils()
	{
		if (isset($_REQUEST['search1']) && !empty($_REQUEST['productid']) ) {
			
			$where = " ";
			if (!empty($_REQUEST['productid'])) { $productid = $_REQUEST['productid'];$where .= " and  P.product_id='$productid'   ";}
			
			//$product_data =  $this->Productmodel->get_product_data_with_id($productid);
			//if(!empty($product_data)){
				//$size = number_format((float) $product_data[0]['size'], 3);$where.=" and  P.product_id='$size'   ";
				
				//same qyery is in Stock->stocklist;
			if(!empty($_REQUEST['dept'])){$dept=$_REQUEST['dept'];$where.=" and  A.stock_dept='$dept'   ";}
			if(!empty($_REQUEST['dia'])){$dia=$_REQUEST['dia'];$where.=" and  A.dia='$dia'   ";}
			if(!empty($_REQUEST['oil'])){$oil=$_REQUEST['oil'];$where.=" and  A.oil='$oil'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  A.grade_id='$grade'   ";}
			if(!empty($_REQUEST['unit'])){$unit=$_REQUEST['unit'];$where.=" and  A.unit='$unit'   ";}
			
			
			$where.="  ORDER by P.size ASC ";
			$stock = $this->Storemodel->get_all_stock_coils_weight_with_search($where);
			//print_r($stock);
			if(!empty($stock)){
				?>
					<h4>Stock Details => Coils: <?php if(!empty( $stock[0]['no_of_coils']))echo $stock[0]['no_of_coils']; ?>, Weight: <?php if(!empty( $stock[0]['weight']))echo $stock[0]['weight']; ?></h4>
				<?php
			}//if(!empty($product_data)){
			else {echo "No data Found in Stock";exit;}
			
			//}//if(!empty($product_data)){
			//else {echo "Proper size not found";exit;}
		
		} else {echo "Filter are required";exit;} //search
	} //function close

	//get rod data coil no wise
	public function getAllWdCoilsList()
	{
		/*
		if (isset($_REQUEST['search1']) && !empty($_REQUEST['productid']) ) {
			
			$where = " ";
			$productid = $_REQUEST['productid'];
			$product_data =  $this->Productmodel->get_product_data_with_id($productid);
			
			if(!empty($product_data)){
				$size = number_format((float) $product_data[0]['size'], 3);$where.=" and  B.finish_size='$size'   ";
				if(!empty($_REQUEST['dia'])){$dia=$_REQUEST['dia'];$where.=" and  B.coil_dia='$dia'   ";}
				//if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  B.product_grade='$grade'   ";}
				
				$where .= " and issue_to_despatch < 1 ORDER by B.entry_date,B.dept,B.mc_no,A.coil_no ";
				$coilList = $this->Qcmodel->get_all_test1_with_search($where);
				
				//print_r($coilList);
				if(!empty($coilList)){
					//print table
					$this->Qcmodel->getAllWdCoilsList_print_table($coilList);
				}//if(!empty($product_data)){
				else {echo "No data Found in Qc coil Test";exit;}
			
			}//if(!empty($product_data)){
			else {echo "Proper size not found";exit;}
		
		} else {echo "Filter are required";exit;} //search
		*/
	} //function close



	
	//save new incoming materail Pickling test
	public function pickling_coil_test_save()
	{
		$today = date("Y-m-d H:i:s");
		$user_email = $this->session->userdata('login_emp_id');

		if (isset($_REQUEST['entry_date'])) {$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);} else {$entry_date = date('Y-m-d');}
		if (isset($_REQUEST['allcheckBox'])) {$allcheckBox = $_REQUEST['allcheckBox'];} else {$allcheckBox = '';}
		if (isset($_REQUEST['checkedBox'])) {$checkedBox = $_REQUEST['checkedBox'];} else {$checkedBox = '';}
		if (isset($_REQUEST['usedcheckedBox'])) {$usedcheckedBox = $_REQUEST['usedcheckedBox'];} else {$usedcheckedBox = '';}

		
		
		//------------------------------------------------------------------update
		if (!empty($_REQUEST['search1']) ) {
			
			//unckeck all 
			$allcheckBox_str = implode(",", $allcheckBox);
			//$data = array('coil_issue' => "0",'issue_date' => "0000-00-00",'coil_used' => "0",);
			$data = array('coil_issue' => "0",'coil_used' => "0",);
			$where = " coil_test_d  in ($allcheckBox_str) ";
			$this->Mymodel->update('product_invoice_row_qc_test_coilswise', $data, $where);

			//issue all selected coil
			
			if(!empty($checkedBox)){
				$checkedBox_str2 = implode(",", $checkedBox);
				//$data = array('coil_issue' => "1",'issue_date' => "$entry_date");
				$data = array('coil_issue' => "1");
				$where = " coil_test_d  in ($checkedBox_str2) ";
				$this->Mymodel->update('product_invoice_row_qc_test_coilswise', $data, $where);
			}
			


			//used all selected coil
			
			if(!empty($usedcheckedBox)){
				$usedcheckedBox_str2 = implode(",", $usedcheckedBox);
				$data = array('coil_used' => "1");
				$where = " coil_test_d  in ($usedcheckedBox_str2) ";
				$this->Mymodel->update('product_invoice_row_qc_test_coilswise', $data, $where);
			}
			
			

			echo "Save";
			
		} else {
			//exit
			echo "Not Save. Try Again. No Data Found.";
		} //exit

	} //function close




	public function pickling_coil_test_save2()
	{
		$today          = date("Y-m-d H:i:s");
		$login_username = $this->session->userdata('login_emp_id');
		$id             = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
		$old_coil_test_d = isset($_REQUEST['old_coil_test_d']) ? $_REQUEST['old_coil_test_d'] : '';
		$lotno             = isset($_REQUEST['lotno']) ? $_REQUEST['lotno'] : '';
		

		if(isset($_REQUEST['entry_date'])) {$entry_date = $this->Base->change_date_ymd_hisa($_REQUEST['entry_date']);} else {$entry_date = date('Y-m-d');}
		if(isset($_REQUEST['heater_on'])) {$heater_on = $this->Base->change_date_ymd_hisa($_REQUEST['heater_on']);} else {$heater_on = '';}
		
		if(isset($_REQUEST['washing_time1'])) {$washing_time1 = $this->Base->change_date_ymd_hisa($_REQUEST['washing_time1']);} else {$washing_time1 = '';}
		if(isset($_REQUEST['hcl_in'])) {$hcl_in = $this->Base->change_date_ymd_hisa($_REQUEST['hcl_in']);} else {$hcl_in = '';}
		if(isset($_REQUEST['hcl_out'])) {$hcl_out = $this->Base->change_date_ymd_hisa($_REQUEST['hcl_out']);} else {$hcl_out = '';}

		if(isset($_REQUEST['washing_time2'])) {$washing_time2 = $this->Base->change_date_ymd_hisa($_REQUEST['washing_time2']);} else {$washing_time2 = '';}
		if(isset($_REQUEST['phos_in'])) {$phos_in = $this->Base->change_date_ymd_hisa($_REQUEST['phos_in']);} else {$phos_in = '';}
		if(isset($_REQUEST['phos_out'])) {$phos_out = $this->Base->change_date_ymd_hisa($_REQUEST['phos_out']);} else {$phos_out = '';}
		if(isset($_REQUEST['borax_in'])) {$borax_in = $this->Base->change_date_ymd_hisa($_REQUEST['borax_in']);} else {$borax_in = '';}
		if(isset($_REQUEST['borax_out'])) {$borax_out = $this->Base->change_date_ymd_hisa($_REQUEST['borax_out']);} else {$borax_out = '';}
		if(isset($_REQUEST['heater_off'])) {$heater_off = $this->Base->change_date_ymd_hisa($_REQUEST['heater_off']);} else {$heater_off = '';}
		
		if(!empty($washing_time2) and !empty($phos_in)){
			$washing2_total_time = $this->Base->get_minute_diff_bw_two_dates($washing_time2,$phos_in)-1;
		}else{
			$washing2_total_time = 0;
		}
		
		if (empty($_REQUEST['rod_id']) && empty($_REQUEST['other_details'])) {
			echo "Please select Rod ID or enter other details.";
			exit;
		}

		$new_rod_id = $_REQUEST['rod_id'] ?? '';

		// CASE: Existing rod issued previously
		if (!empty($old_coil_test_d)) {
			if (empty($new_rod_id)) {
				// No new rod selected, but old exists and no other details
				if (empty($_REQUEST['other_details'])) {
					echo "Please select Rod ID or enter other details.";
					exit;
				}
			}

			if (!empty($new_rod_id) && $old_coil_test_d != $new_rod_id) {
				//echo "Rod changed.";
				//old rod unissue
				/*
				$data = array('coil_issue' => "0",'coil_used' => "0",);
				$where = " coil_test_d  in ($old_coil_test_d) ";
				$this->Mymodel->update('product_invoice_row_qc_test_coilswise', $data, $where);
				*/
				
				//new rod issue
				$data = array('coil_issue' => "1",'issue_date' => "$entry_date");
				$where = " coil_test_d  ='$new_rod_id' ";
				$this->Mymodel->update('product_invoice_row_qc_test_coilswise', $data, $where);
			} else {
				// echo $old_coil_test_d;
				// echo "Same coil. So no entry.";
				// echo $new_rod_id;
			}
		}
		// CASE: First time issuing a rod
		elseif (empty($old_coil_test_d) && !empty($new_rod_id)) {
			//echo "1st time issue";
			$data = array('coil_issue' => "1",'issue_date' => "$entry_date");
			$where = " coil_test_d  ='$new_rod_id' ";
			$this->Mymodel->update('product_invoice_row_qc_test_coilswise', $data, $where);
		}


		

		// Collect all POST data
		$data = array(
			'entry_date'             => $entry_date ?? null,
			'coil_test_d'           => $_REQUEST['rod_id'] ?? null,
			'lotno'           		=> $lotno ,
			'other_details'          => $_REQUEST['other_details'] ?? null,
			'rank'          		=> $_REQUEST['rank'] ?? null,
			'heater_on'              => $heater_on ?? null,
			'washing_time1'          => $washing_time1 ?? null,
			'hcl_in'                 => $hcl_in ?? null,
			'hcl_out'                => $hcl_out ?? null,
			'hcl_total_time'         => $_REQUEST['hcl_total_time'] ?? null,
			'washing_time2'          => $washing_time2 ?? null,
			'washing2_total_time'    => $washing2_total_time ?? null,
			'phos_in'                => $phos_in ?? null,
			'phos_out'               => $phos_out ?? null,
			'phos_total_time'        => $_REQUEST['phos_total_time'] ?? null,
			'phos_in_temp'           => $_REQUEST['phos_in_temp'] ?? null,
			'phos_out_temp'          => $_REQUEST['phos_out_temp'] ?? null,
			'phos_temp_diff'         => $_REQUEST['phos_temp_diff'] ?? null,
			'borax_in'               => $borax_in ?? null,
			'borax_out'              => $borax_out ?? null,
			'borax_total_time'       => $_REQUEST['borax_total_time'] ?? null,
			'borax_in_temp'          => $_REQUEST['borax_in_temp'] ?? null,
			'borax_out_temp'         => $_REQUEST['borax_out_temp'] ?? null,
			'borax_temp_diff'        => $_REQUEST['borax_temp_diff'] ?? null,
			'wash_to_borex_out_time' => $_REQUEST['wash_to_borex_out_time'] ?? null,
			'sup_id'                 => $_REQUEST['sup_id'] ?? null,
			'op_id'                  => $_REQUEST['op_id'] ?? null,
			'hel1_id'                => $_REQUEST['hel1_id'] ?? null,
			'hel2_id'                => $_REQUEST['hel2_id'] ?? null,
			'heater_off'             => $heater_off ?? null, 
			'remarks'                => $_REQUEST['remarks'] ?? null,
		);

		//----------------------------------------------------------------------insert
		if (empty($id)) {
			$data['save_by']   = $login_username;
			$data['save_date'] = $today;

			$qc_spec1_id = $this->Mymodel->insertdata_withid('pickling_production', $data);
			echo "Save";
		}
		//----------------------------------------------------------------------update
		elseif (!empty($id)) {
			$data['update_by']   = $login_username;
			$data['update_date'] = $today;

			$where = array('id' => $id);
			$this->Mymodel->update('pickling_production', $data, $where);
			echo "Update";
		} else {
			echo "Not Save. Try Again. No Data Found.";
		}
	} //function close




	


	//track rod
	public function track_finish_rod_form()
	{
		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$type = $this->uri->segment(4);
			$result['qc_test1_id'] = $id;
			$result['type'] = $type;
		}else{
			$result['qc_test1_id'] = 0;
			$result['type'] = '';
		}

		$this->load->view('qc/track', $result);
	} //function close


	//track rod
	public function get_track_from_finish_to_base_rod()
	{
		
		if (!empty($_REQUEST['search1']) ) {

			if (!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']) and !empty($_REQUEST['fsize'])) {
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$fsize = $_REQUEST['fsize'];
				$type = $_REQUEST['type'];
				$link = $_REQUEST['link'];
				

				
				if($type == "Simi"){
					
					$simi_base_rod = $this->Qcmodel->get_wet_mini_prod_lotno_from_size($fsize, $search_date1, $search_date2);
					
					if($link =="Yes"){
						// Step 1: Group by lotno
							$grouped = [];
							foreach ($simi_base_rod as $row) {
								$grouped[$row['lotno']][] = $row;
							}

							// Step 2: Render
							foreach ($grouped as $lotno => $records) {
								$lotname = $this->Base->get_all_lotno_with_id($lotno);
								if(!empty($lotname)){
									echo "<h5>Lotno: <span style='color:red'>".$lotname[0]['name']."</span></h5>";
									echo $this->Qcmodel->finish_coil_list($records);
									//print_r($records);
									
									$baseCoillist = $this->Qcmodel->get_baseCoilId_from_lotno($lotno,$records[0]['actual_size']);
									//print_r($baseCoillist);
									
									echo "<h5 style='margin-top:100px'>Simi Base Coil List</h5>";
									$this->Qcmodel->get_baseCoilID_from_finishid_table_data($baseCoillist);
									
									// Extract unique baseCoilId values
									$baseCoilIds = array_unique(array_column($baseCoillist, 'baseCoilId'));
									echo "<h5 style='margin-top:100px'>Wire Rod List</h5>";
									$this->Qcmodel->get_baseCoilID_from_finishid_html_table($baseCoilIds);
								}
							}//foreach
					}else{
						//print_r($simi_base_rod);
						echo $this->Qcmodel->finish_coil_list($simi_base_rod);
						$baseCoillist = $this->Qcmodel->get_baseCoilId_from_finishSize($simi_base_rod[0]['base_size'], $search_date1, $search_date2);
						//print_r($baseCoillist);
						echo "<h5 style='margin-top:100px'>Simi Base Coil List</h5>";
						$this->Qcmodel->get_baseCoilID_from_finishid_table_data($baseCoillist);
						// Extract unique size values
						$unique_Size = array_unique(array_column($baseCoillist, 'base_size'));
						
						$rodList = $this->Pomodel->get_all_heatno_colino_from_rodSize($unique_Size,$search_date1, $search_date2);
						//print_r($rodList);
						$baseCoilIds = array_unique(array_column($rodList, 'coil_test_d'));
						echo "<h5 style='margin-top:100px'>Wire Rod List</h5>";
						$this->Qcmodel->get_baseCoilID_from_finishid_html_table($baseCoilIds);
					}//if($link =="Yes"){
					
				}else{

					if($link =="Yes"){
							$baseCoil = $this->Qcmodel->get_baseCoilId_from_size($fsize,$search_date1,$search_date2);
							$this->Qcmodel->get_baseCoilID_from_finishid_table_data($baseCoil);

							// Extract unique baseCoilId values
							$baseCoilIds = array_unique(array_column($baseCoil, 'baseCoilId'));
					}else{
							$baseCoil = $this->Qcmodel->get_baseCoilId_from_size_wihout_rod($fsize,$search_date1,$search_date2);
							$this->Qcmodel->get_baseCoilID_from_finishid_table_data($baseCoil);
							
							
							// Extract unique size values
							$unique_Size = array_unique(array_column($baseCoil, 'base_size'));
							$rodList = $this->Pomodel->get_all_heatno_colino_from_rodSize($unique_Size,$search_date1, $search_date2);
							$baseCoilIds = array_unique(array_column($rodList, 'coil_test_d'));
							
					}
					echo "<h5 style='margin-top:100px'>Wire Rod List</h5>";
					$this->Qcmodel->get_baseCoilID_from_finishid_html_table($baseCoilIds);
					
				}//else
				

				
				
			}//!empty
			else{
				echo "Not Save. Try Again. No Data Found.";
			}

		} else {
			//exit
			echo "Not Save. Try Again. No Data Found.";
		} //exit
		
	} //function close




	//furnace
	public function furnace_add()
	{
		$result['grade'] = $this->Base->get_all_grade();
		if (strlen($this->uri->segment(3)) > 0) {
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Qcmodel->get_furnace_data_with_id($id);
		} //strlen
		$this->load->view('qc/furnace/entry', $result);
	} //function close

	//list search
	public function furnace_list()
	{
		$result['grade'] = $this->Base->get_all_grade();
		if (isset($_REQUEST['search1'])) {
			$where = " ";
			if (!empty($_REQUEST['actual_size'])) {
				$actual_size = $_REQUEST['actual_size'];
				$actual_size = number_format((float) $actual_size, 3);
				$where .= " and  A.actual_size='$actual_size'   ";
			}
			if (!empty($_REQUEST['product_grade'])) {$product_grade = $_REQUEST['product_grade'];$where .= " and  A.product_grade='$product_grade'   ";}
			
			if (!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2'])) {
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where .= "  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where .= " ORDER by A.entry_date,A.lotno,A.new_coil_no ";

			$result['res2'] = $this->Qcmodel->get_all_furnace_with_search($where);
			$this->load->view('qc/furnace/show_table', $result);
		} else {
			$search_date1 = date('Y-m-d');
			$search_date2 = date('Y-m-d');
			$where = " and A.entry_date between '$search_date1' and '$search_date2'  ORDER by A.entry_date,A.lotno,A.new_coil_no  ";
			$result['res2'] = $this->Qcmodel->get_all_furnace_with_search($where);
			$this->load->view('qc/furnace/show', $result);
		} //search
	} //function close

	//save new product
	public function furnace_save()
	{
		$today = date("Y-m-d H:i:s");
		$login_username = $this->session->userdata('login_emp_id');

		if (isset($_REQUEST['entry_date'])) {$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}
		if (isset($_REQUEST['actual_size'])) {$actual_size = $_REQUEST['actual_size'];} else {$actual_size = '';}
		if (isset($_REQUEST['product_grade'])) {$product_grade = $_REQUEST['product_grade'];} else {$product_grade = '';}
		if (isset($_REQUEST['lotno'])) {$lotno = $_REQUEST['lotno'];} else {$lotno = '';}
		
		if(empty($_REQUEST['actual_size']) and empty($_REQUEST['product_grade']) and empty($_REQUEST['entry_date'])){
			echo "No data to save";exit;
		}

		$actual_size = number_format((float) $actual_size, 3);
		
		// Detail arrays (make sure your inputs are named as arrays in the form: name="newCoilNo[]", etc.)
		$rowID   = (array) $this->input->post('rowID');
		$newCoilNo   = (array) $this->input->post('newCoilNo');
		$lotNo       = (array) $this->input->post('lotNo');
		$baseSize    = (array) $this->input->post('baseSize');
		$finishSize  = (array) $this->input->post('finishSize');
		$breakLoad   = (array) $this->input->post('BreaklingLoad'); // keep your original key if that's what comes from JS
		$uts         = (array) $this->input->post('uts');
		$zinc        = (array) $this->input->post('zinc');
		$raPer       = (array) $this->input->post('raPer');
		$tempInC     = (array) $this->input->post('tempInC');
		$speed       = (array) $this->input->post('speed');
		$remarks     = (array) $this->input->post('remarks');
		
		$rows = count($newCoilNo);

		for ($i = 0; $i < $rows; $i++) {
			if ($newCoilNo[$i] >0){
					if( $baseSize[$i] > 0){$baseSize = number_format((float) $baseSize[$i], 3);}else{$baseSize ='';}
					if( $finishSize[$i] > 0){$finishSize = number_format((float) $finishSize[$i], 3);}else{$finishSize ='';}
					//insert
					$data = array(
						'entry_date' => "$entry_date",
						'actual_size' => "$actual_size",
						'product_grade' => "$product_grade",
						'lotno' => "$lotno",
						'new_coil_no' => "$newCoilNo[$i]",
						'base_size' => "$baseSize",
						'finish_size' => "$finishSize",
						'bl' => "$breakLoad[$i]",
						'uts' => "$uts[$i]",
						'zinc' => "$zinc[$i]",
						'ra' => "$raPer[$i]",
						'temp' => "$tempInC[$i]",
						'speed' => "$speed[$i]",
						'remarks' => "$remarks[$i]",
						'update_by' => "$login_username",
						'update_date' => "$today",
					);
					$where = array('id ' => $rowID[$i]);
					$this->Mymodel->update('furnace_production', $data, $where);
					
					if($rowID[$i] > 0) 
					{
						//update
						$where = array('id ' => $rowID[$i]);
						$this->Mymodel->update('furnace_production', $data, $where);
					}else{
						//new
						$this->Mymodel->insertdata('furnace_production', $data);
					}//if ($qcTestId[$i] > 0) {
			}//if
		}//for
		echo "Save";

	} //function close
































} //close class