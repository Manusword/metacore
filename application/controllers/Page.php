<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Page extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
		$this->load->model('base');
		$user_email=$this->session->userdata('login_username');
		if(!$user_email>0){redirect('welcome/');}
	}//function close




	public function index()
	{
			redirect('control/');
	}//function close


	public function pagename()
	 {

		if(!empty($_REQUEST['name']) && !empty($_REQUEST['url']))
		{
			$url =  $_REQUEST['url'];
			$name =  $_REQUEST['name'];
			$this->Company->checkPermission1($name);
			redirect($_REQUEST['name']);
		}
		
	}//function close


	
	public function get_sub_menus()
	{
		$menu_id =  $_REQUEST['menu_id']; 
		$this->Base->get_all_sub_menu_from_main_id2($menu_id);
	}


	//Add menu
	public function add_menu()
	{
		$result['menu']=$this->Base->get_all_main_menu2();
		$result['sub_menu']=$this->Base->get_all_sub_menu2();
		$this->load->view('setting/menu/menu_entry',$result);
	}//function close


	public function add_menu_save()
	{
		$data = $this->input->post();

		// ❌ Basic validation
		if (empty($data['name']) || empty($data['id_name'])) {
			echo 'Invalid Data';
			return;
		}

		$payload = [
			'name'           => trim($data['name']),
			'id_name'        => trim($data['id_name']),
			'is_direct_link' => $data['is_direct_link'],
			'link'           => trim($data['link']),
			'menu_order'     => (int)$data['menu_order'],
			'status'         => $data['status'],
			'show_in_list'   => $data['show_in_list']
		];

		if (!empty($data['id'])) {

			// 🔁 UPDATE CASE
			$this->db->where('id', $data['id'])
					->update('erp_menu', $payload);

			$menu_id = (int)$data['id'];   // existing id

		} else {

			// ➕ INSERT CASE
			$this->db->insert('erp_menu', $payload);

			// 🔥 GET INSERTED MENU ID
			$menu_id = $this->db->insert_id();

			// ❗ Safety check
			if ($menu_id > 0) {
				$this->db->insert('erp_role_permission', [
					'role_id'     => 35,
					'menu_id'     => $menu_id,
					'sub_menu_id' => NULL
				]);
			}
		}

		echo 'OK';
	}


	public function add_sub_menu_save()
	{
		$data = $this->input->post();

		if (empty($data['name']) || empty($data['id_name'])) {
			echo 'Invalid Data';
			return;
		}

		$payload = [
			'main_menu_id'   => $data['main_menu_id'],
			'name'           => $data['name'],
			'id_name'        => $data['id_name'],
			'is_direct_link' => $data['is_direct_link'],
			'link'           => $data['link'],
			'menu_order'     => (int)$data['menu_order'],
			'status'         => $data['status'],
			'show_in_list'   => $data['show_in_list']
		];

		if (!empty($data['id'])) {
			$this->db->where('id', $data['id'])->update('erp_sub_menu', $payload);
		} else {
			$this->db->insert('erp_sub_menu', $payload);
		}

		echo 'OK';
	}




	//Add Department
	public function add_department()
	{
		$result['dept']=$this->Base->get_all_dept2();
		$this->load->view('setting/dept/entry',$result);
	}//function close

	public function add_department_save()
	{
		$id     = $this->input->post('id');
		$name   = trim($this->input->post('name'));
		$status = $this->input->post('status');

		if ($name === '') {
			echo 'Department name is required';
			return;
		}

		$payload = [
			'name'   => $name,
			'is_it_main_dept'   => 1,
			'is_maintenance'   => 1,
			'is_hr'   => 1,
			'status' => $status
		];

		if ($id) {
			// UPDATE
			$this->db->where('department_id', $id)->update('department', $payload);
		} else {
			// INSERT
			$this->db->insert('department', $payload);
		}

		echo 'OK';
	}


	//Add add_designation
	public function add_designation()
	{
		$result['role']=$this->Base->get_all_dept_role2();
		$this->load->view('setting/dept/role_entry',$result);
	}//function close

	public function add_designation_save()
	{
		$id     = $this->input->post('id');
		$name   = trim($this->input->post('name'));
		$status = $this->input->post('status');

		if ($name === '') {
			echo 'Designation name is required';
			return;
		}

		$payload = [
			'name'   => $name,
			'status' => $status
		];

		if ($id) {
			$this->db->where('role_id', $id)->update('department_role', $payload);
		} else {
			$this->db->insert('department_role', $payload);
		}

		echo 'OK';
	}



	//Add plants
	public function add_plants()
	{
		$result['plant']=$this->Base->get_all_contractor_code2();
		$this->load->view('setting/plants/entry',$result);
	}//function close

	public function add_plants_save()
	{
		$id = (int) $this->input->post('id');

		$payload = [ 
			'name'               => trim($this->input->post('name')),
			'full_name'          => trim($this->input->post('full_name')),
			'display_name'        => trim($this->input->post('display_name')),
			'address'            => trim($this->input->post('address')),
			'gst'                => trim($this->input->post('gst')),
			'pf_code'            => trim($this->input->post('pf_code')),
			'esi_no'             => trim($this->input->post('esi_no')),
			'manpower_limit'     => (int) $this->input->post('manpower_limit'),
			'salaryDivide_days'  => $this->input->post('salaryDivide_days') ?: null,
			'pay_code_start'     => trim($this->input->post('pay_code_start')),
			'pay_code_end'       => trim($this->input->post('pay_code_end')),
			'autoEmpcode_status' => $this->input->post('autoEmpcode_status'),
			'empcode_start'      => trim($this->input->post('empcode_start')),
			'bank_name'      => trim($this->input->post('bank_name')),
			'bank_account'      => trim($this->input->post('bank_account')),
			'bank_ifsc'      => trim($this->input->post('bank_ifsc')),
			'working_unit'      => trim($this->input->post('working_unit')),
			'order_no'      => trim($this->input->post('order_no')),
			
			'status'             => $this->input->post('status')
		];

		/* ================= VALIDATION ================= */

		if ($payload['name'] === '')
			return $this->_fail('Plant name required');

		if ($payload['full_name'] === '')
			return $this->_fail('Full name required');

		if ($payload['address'] === '')
			return $this->_fail('Address required');

		if ($payload['manpower_limit'] <= 0)
			return $this->_fail('Manpower must be greater than 0');

		if ($payload['pay_code_start'] && $payload['pay_code_end'] &&
			$payload['pay_code_start'] > $payload['pay_code_end'])
			return $this->_fail('Empcode start cannot be greater than end');

		if ($payload['gst'] &&
			!preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', $payload['gst']))
			return $this->_fail('Invalid GST format');

		

		/* ============ DUPLICATE CHECK ============ */
		$this->db->where('name', $payload['name']);
		if ($id) $this->db->where('id !=', $id);

		if ($this->db->count_all_results('contractor_code') > 0)
			return $this->_fail('Plant name already exists');

		/* ============ SAVE ============ */
		if ($id) {
			$this->db->where('id', $id)->update('contractor_code', $payload);
		} else {
			$this->db->insert('contractor_code', $payload);
		}

		echo 'OK';
	}

	private function _fail($msg)
	{
		echo $msg;
		exit;
	}


	//Add shift master
	public function add_shift()
	{
		$result['shifts']=$this->Base->get_all_shift();
		$this->load->view('setting/shift/entry',$result);
	}//function close


	public function add_shift_save()
	{
		$shift_id     = trim($this->input->post('shift_id'));
		$shift_code   = trim($this->input->post('shift_code'));
		$shift_name   = trim($this->input->post('shift_name'));
		$in_time      = trim($this->input->post('in_time'));
		$out_time     = trim($this->input->post('out_time'));
		$out_time_ot  = trim($this->input->post('out_time_ot'));
		$status       = trim($this->input->post('status'));

		// BASIC VALIDATION (minimum required)
		if ($shift_code === '' || $shift_name === '') {
			echo 'Shift Code and Shift Name are required';
			return;
		}

	if ($in_time === '' || $out_time === '' || $out_time_ot === '') {
			echo 'In Time, Out Time (8 hrs) and Out Time (12 hrs) are required';
			return;
		}

		// Normalize to 24-hour format (H:i:s)
		$in_time     = date('H:i:s', strtotime($in_time));
		$out_time    = date('H:i:s', strtotime($out_time));
		$out_time_ot = date('H:i:s', strtotime($out_time_ot));


		
		if (!empty($shift_id)) {
			// UPDATE
			$payload = [
				'shift_name'  => $shift_name,
				'in_time'     => $in_time,
				'out_time'    => $out_time,
				'out_time_ot' => $out_time_ot,
				'status'      => $status
			];
			$this->db->where('shift_id', $shift_id);
			$this->db->update('emp_shift_master', $payload);
		} else {
			// INSERT
			$payload = [
				'shift_code'  => $shift_code,
				'shift_name'  => $shift_name,
				'in_time'     => $in_time,
				'out_time'    => $out_time,
				'out_time_ot' => $out_time_ot,
				'status'      => $status
			];

			$this->db->insert('emp_shift_master', $payload);
		}

		echo 'OK';
	}




	//Setting
	public function setting()
	{
		$company_id = $this->session->userdata('company_id');  
		// $where2="1=1";
		// $result['com'] = $this->Mymodel->select_where('company_profile',$where2);
		$where2=" company_id = '$company_id' ";
		$result['com'] = $this->Mymodel->select_where('company',$where2);
		$this->load->view('setting/setting',$result);
	}//function close

	public function save_settings()
	{
		$company_id = $this->session->userdata('company_id');  
		if (!$this->input->post('group')) {
			echo 'Invalid request';
			return;
		}
		$group = $this->input->post('group');
		$this->db->trans_start(); // ---- TRANSACTION START ----
		
		$this->db->where(['company_id' => $company_id]);

		switch ($group) {

			/* ================= COMPANY ================= */
			case 'company':

				// id = 1 (company basic)
				$this->db->update('company', [
					'full_name' => $this->input->post('company_name'),
					'city' => $this->input->post('city'),
					'gstno' => $this->input->post('gst'),
					'state' => $this->input->post('state'),
					'state_code' => $this->input->post('state_code'),
					'full_address' => $this->input->post('address')
				]);
				break;

			/* ================= PRINT ================= */
			case 'print':

				$this->db->update('company', [
					'email' => $this->input->post('print_email'),
					'mob1' => $this->input->post('print_mobile'),
					'assetList' => $this->input->post('asset_list')
				]);
				break;

			/* ================= EMAIL ================= */
			case 'email':

				$this->db->update('company', [
					// 'details1' => $this->input->post('enabled'),
					'mail_server' => $this->input->post('server'),
					'mail_port' => $this->input->post('port'),
					'mail_username' => $this->input->post('email'),
					'mail_pass' => $this->input->post('password') // encrypt later
				]);
				break;

			/* ================= SECURITY ================= */
			case 'security':

				// login IPs
				$this->db->update('company', [
					'login_ip_from' => $this->input->post('login_ips')
				]);
				break;

			/* ================= DESIGN ================= */
			case 'design':

				$this->db->update('company', [
					'design1_bg_color' => $this->input->post('header_bg'),
					'design1_ft_color' => $this->input->post('header_text')
				]);
				break;

			/* ================= ATTENDANCE ================= */
			case 'other':

				$this->db->update('company', [
					'attendance_date' => $this->input->post('back_date_absent')
					
				]);

				break;

			default:
				echo 'Unknown settings group';
				return;
		}

		$this->db->trans_complete(); // ---- TRANSACTION END ----

		if ($this->db->trans_status() === FALSE) {
			echo 'DB Error';
			return;
		}

		echo 'OK';
	}



















	
	
	
	
	
	public function popup_model()
	{
		$department_id=$this->session->userdata('department_id');

		//$where2="1=1 and product_id!=''  ORDER by category_id ASC ";
		//$result['product_stock']=$this->Mymodel->select_where('product_stock',$where2);

		$where2="id='11'";
		$company_info=$this->Mymodel->select_where('company_setting',$where2);

		$all_dept_id=$company_info[0]['setting_value'];//all dept id
		$all_dept_id1=explode(',',$all_dept_id);
		
		//if(in_array($department_id,$all_dept_id1))
		//{
				?>
				<div id="printTable1">
				<h3 align="center">Short Material In Stock</h3>
					<?php
					$query2="
								SELECT 
								
								sum(A.recive_stock_level) as qty,
								A.product_id,A.product_grade_id,A.lotno,
								P.name as pname,P.economic,P.reorder,P.max_level,P.no_of_days,
								C.name as cname,C.category_id,
								U.name as uname
								
								FROM product_stock as A 
								
								LEFT JOIN product as P ON P.product_id = A.product_id
								LEFT JOIN category C ON C.category_id=A.category_id
								LEFT JOIN unit U ON U.unit_id=P.unit_id
								
								WHERE   
							";
					
					$where="  P.row_mat_puc='1' and P.repeated='1'     GROUP by A.product_id   ORDER by A.category_id,P.name ASC  ";	
					//$where="  P.row_mat_puc='1' and P.repeated='1'  and (A.category_id ='2' OR A.category_id ='13' OR A.category_id ='14')    GROUP by A.product_id   HAVING sum(A.recive_stock_level)<=P.economic ORDER by A.category_id,P.size ASC  ";	
			
					$query2.=" $where";
					$res2=$this->Mymodel->query1($query2);
					//print_r($res2);
					if(!empty($res2))
					{
							?>		
								<table border="1" width="100%" style="font-size:16px;" >
									<tr style=" background-color:#34425A; color:white;">
										<th align="left">#</th>
										<th align="left">Category</th>
										<th align="left">Product</th>
										<th align="right">Qty Req. Per Day</th>
										<th align="right">Min Level</th>
										<th align="right">No of Day's set for Min Level qty</th>
										<th align="right">Current Stock</th>
										<th align="right">Current Stock / No of Days</th>
										<th align="right">Short Percentage</th>
									</tr>
									<?php 
										$i=1;
										foreach($res2 as $r)
										{
											$per_res=round(($r['qty']*100)/$r['economic']);
											$qty = round($r['qty'],2);

											if($r['no_of_days']>0 and $qty>0){ $avg_per_day = round($r['economic']/$r['no_of_days']);   $day_rem = round($qty/$avg_per_day); }else { $avg_per_day='';$day_rem ='';}
											
											//color 
											if($per_res >= 100){$color='white';$font ='';}
											elseif($per_res < 100 and $per_res >= 50){$color='white';$font ='';}
											elseif($per_res < 50)
											{
												if($qty == 0){$color='white'; $font ='';}else{$color='#f25656'; $font = "font-weight:bold; color:white;"; }
											}
										?>
										<tr style="background-color:<?php echo $color;?>; <?php echo $font;?>">
											<td align="left"><?php echo $i;?></td>
											<td align="left"><?php echo $r['cname'];?></td>
											<td align="left"><?php echo $r['pname'];?></td>
											<td align="right"><?php echo $avg_per_day;?></td>
											<td align="right"><?php echo $r['economic'];?></td>
											<td align="right"><?php echo $r['no_of_days'];?></td>
											<td align="right"><?php echo $qty;?></td>
											<td align="right"><?php echo $day_rem;?></td>
											<td align="right"><?php echo $per_res;?>%</td>
										</tr>
										<?php
										$i++;
										}
									?>
								</table>
					<?php
					}
					?>
					
				
				</div>  

				<h3 align="center">Waiting in Quality</h3>
				<?php 
				//--------------------------------------------------geting qc category data
				$where="qc_check='1'";
				$res2=$this->Invoice_model->qc_product_group_by_rate($where);
				//print_r($res2);
				if(!empty($res2))
				{
				?>	
					<table border="1" width="100%" style="font-size:16px;" >
						<tr style=" background-color:#34425A; color:white;">
							<th align="left">#</th>
							<th align="left">Product</th>
							<th align="left">Supplier</th>
							<th align="right">Qty</th>
						</tr>
						<?php 
							$i=1;
							foreach($res2 as $r)
							{
								$product_id = $r['product_id'];
								$supplier_id = $r['supplier_id'];
					
								$query3=" SELECT name FROM product WHERE product_id = '$product_id' ";
								$out = $this->Mymodel->query1($query3);
								$pro_name = $out[0]['name'];

					
								$query3=" SELECT name FROM supplier WHERE id = '$supplier_id' ";
								$out = $this->Mymodel->query1($query3);
								$sup_name = $out[0]['name'];

								$qty = round($r['net'],2);
							?>
							<tr>
								<td align="left"><?php echo $i;?></td>
								<td align="left"><?php echo $pro_name;?></td>
								<td align="left"><?php echo $sup_name;?></td>
								<td align="right"><?php echo $qty;?></td>
							</tr>
							<?php
							$i++;
							}
						?>
					</table>
				<?php
				}
				?>


				<h3 align="center">Waiting in Quality HOD</h3>
				<?php 
				//--------------------------------------------------geting qc 
				$query="
					SELECT  A.qc_id,A.details_id,A.entry_date,A.dia,A.lotno,A.grade,A.mtc_no,A.part_no,A.accept,A.reject,A.deviation, 
					B.product_id,B.supplier_id,B.product_invoice_save_no,A.stage
					
					FROM qc as A 
					
					LEFT JOIN product_invoice_entry_details B ON A.details_id=B.details_id
					
					WHERE  A.stage='1' GROUP BY qc_id ORDER by A.entry_date DESC
				";
				
				$res2 = $this->Mymodel->query1($query);
				//print_r($res2);
				if(!empty($res2))
				{
				?>	
					<table border="1" width="100%" style="font-size:16px;" >
						<tr style=" background-color:#34425A; color:white;">
							<th align="left">#</th>
							<th align="left">Product</th>
							<th align="left">Supplier</th>
							<th align="right">Accept</th>
							<th align="right">Reject</th>
							<th align="right">Deviation</th>
						</tr>
						<?php 
							$i=1;
							foreach($res2 as $r)
							{
								$product_id = $r['product_id'];
								$supplier_id = $r['supplier_id'];
					
								$query3=" SELECT name FROM product WHERE product_id = '$product_id' ";
								$out = $this->Mymodel->query1($query3);
								if(!empty($out)){$pro_name = $out[0]['name'];}else{$pro_name = '';}
								

					
								$query3=" SELECT name FROM supplier WHERE id = '$supplier_id' ";
								$out = $this->Mymodel->query1($query3);
								if(!empty($out)){$sup_name = $out[0]['name'];}else{$sup_name = '';}
							?>
							<tr>
								<td align="left"><?php echo $i;?></td>
								<td align="left"><?php echo $pro_name;?></td>
								<td align="left"><?php echo $sup_name;?></td>
								<td align="right"><?php echo $r['accept'];?></td>
								<td align="right"><?php echo $r['reject'];?></td>
								<td align="right"><?php echo $r['deviation'];?></td>
							</tr>
							<?php
							$i++;
							}
						?>
					</table>
				<?php
				}
				?>
				<h3>F05(BP/PPC/01) Rev No / Date : 26-07-2017</h3>
				<button class="btn btn-" style=" margin:10px;" onClick="printData1()">Print Table</button>
					
				<script>
				function printData1()
				{
					var data='<h2 align="center">Rahul Wire Ropes</h2>'
					
					var divToPrint=document.getElementById("printTable1");
					newWin= window.open("");
					newWin.document.write(data);
					newWin.document.write(divToPrint.outerHTML);
					newWin.print();
					newWin.close();
				}
				</script>

				<?php 
		/*
		}//if dept
		else
		{
			echo "No Data";
		}
		*/
		
	}//function close
	
	
	
	
	
	
	
	
	
	
	
	public function popup_model_old()
	{
		$department_id=$this->session->userdata('department_id');

		$df=20;
		$dt=19;
		
		//-------geting from or to date
		$po_date_from1=date("Y-m-$df");
		$date = new DateTime($po_date_from1);
		$date->modify('-1 month');
		$po_date_from2= $date->format("Y-m-$df")."\n";//form database
		$po_date_from22= $date->format("$df-m-Y")."\n";//form database
		
		
		
		$po_date_to2=date("Y-m-$dt");////form database
		$po_date_to22=date("$dt-m-Y");////form database
		
		
		//$po_date_from2="2018-01-$df";
		//$po_date_from22="$df-01-2018";
		?>
        <div id="printTable1">
            <h3 align="center">Short Material In Stock</h3>
            <h4 align="center">P.O From <?php echo $po_date_from22;?> To <?php echo $po_date_to22;?></h4>
        <?php
		$query="
				SELECT 
				
				sum(A.recive_stock_level) as stock_qty,
				A.product_id,P.name as pname,P.economic as min_level,
				C.name as cname,C.category_id,
				U.name as uname
				
				FROM product_stock as A 
				
				LEFT JOIN product as P ON P.product_id = A.product_id
				LEFT JOIN category C ON C.category_id=A.category_id
				LEFT JOIN unit U ON U.unit_id=P.unit_id
				
				WHERE  P.row_mat_puc='1' and P.repeated='1'   GROUP by A.product_id   ORDER by A.category_id,P.size ASC 
			";
		
	 	/*
		$query="
						SELECT  
								P.product_id,P.name as pname,P.economic as min_level,
								sum(A.qunt) as qty,
								sum(A.rev_qunt) as res_qty,
								sum(S.recive_stock_level) as stock_qty
								
						FROM po_entry_details as A
						LEFT JOIN po_entry B ON A.po_entry_id=B.po_id
						LEFT JOIN product P ON A.product_id=P.product_id
						LEFT JOIN product_stock S ON A.product_id=S.product_id
						WHERE 
						
						B.stage='5' and A.po_date between '$po_date_from2' and '$po_date_to2' and 
						P.row_mat_puc='1' and P.repeated='1' 
						
						GROUP BY P.name  ORDER by P.name ASC 
					";
		*/
			
		$res=$this->Mymodel->query1($query);	
		if(!empty($res))
		{
			?>
            <table border="1" width="100%" style="font-size:16px;"  class="table-hover">
            	<tr style=" background-color:#34425A; color:white; font-weight:bolder">
                	<td align="left">#</td>
                    <td align="left">Product</td>
                    <td align="right">Order Qty</td>
                    <td align="right">Rec. Qty</td>
                    <td align="right">Rem. Qty</td>
                    <td align="right">% Rec.</td>
                    <td align="right">Stock</td>
                    <td align="right">Min-Level</td>
                    <td align="right">Unit</td>
                </tr>
			   <?php
                $i=1;
				foreach($res as $r)
                {
                    //---------getting po details
					$product_name = $r['pname'];
					$product_id = $r['product_id'];
					
					
					$query2="
						SELECT  
								sum(A.qunt) as qty,
								sum(A.rev_qunt) as res_qty
							
								
						FROM po_entry_details as A
						LEFT JOIN po_entry B ON A.po_entry_id=B.po_id
						WHERE 
						A.product_id='$product_id' and 
						B.stage='5' and A.po_date between '$po_date_from2' and '$po_date_to2' 
						GROUP BY A.product_id  
					";
					

					$res2=$this->Mymodel->query1($query2);	
					
					if(!empty($res2[0]['qty'])){$qty = round($res2[0]['qty']);}else{$qty =0;}
                    if(!empty($res2[0]['res_qty'])){$res_qty = round($res2[0]['res_qty']);}else{$res_qty =0;}
                    $rem = round($qty-$res_qty);
                    if(!empty($res2[0]['qty']) and !empty($res2[0]['res_qty'])){$per_res = round(($res_qty*100)/$qty);}else{$per_res = 0;}
					$stock_qty = round($r['stock_qty']);
					$min_level = round($r['min_level']);
					$unit = $r['uname'];
					
					//color 
					if($per_res >= 100){$color='black';}
					elseif($per_res < 100 and $per_res >= 50){$color='orange';}
					elseif($per_res < 50)
					{
						if($qty == 0){$color='black';}else{$color='red';}
						
					}
					
                    ?>
                    <tr style="color:<?php echo $color;?>;">
                    	<td align="left"><?php echo $i;?></td>
                        <td align="left"><?php echo $product_name;?></td>
                        <td align="right"><?php echo $qty;?></td>
                        <td align="right"><?php echo $res_qty;?></td>
                        <td align="right"><b><?php echo $rem;?></b></td>
                        <td align="right"><b><?php echo $per_res;?>% </b></td>
                       
                        <td align="right"><?php echo $stock_qty;?></td>
                        <td align="right"><?php echo $min_level;?></td>
                        <td align="right"><?php echo $unit;?></td>
					</tr>
                    <?php
					$i++;
                }//foreach
                ?>
            </table>
            <?php
		}//!empty
		else
		{
			echo "No Data Found";
		}
		
		
		//print_r($res);
		
		
		
		?>
        </div>
		<button class="btn btn-info" style=" margin:10px;" onClick="printData1()">Print Table</button>
        <script>
			function printData1()
			{
			   var data='<h2 align="center">Rahul Wire Ropes</h2>'
			  
			   var divToPrint=document.getElementById("printTable1");
			   newWin= window.open("");
			   newWin.document.write(data);
			   newWin.document.write(divToPrint.outerHTML);
			   newWin.print();
			   newWin.close();
			}
        </script>
		<?php
	}//function close








	public function popup_model_warehouse()
	{
		?>
				<div id="printTable1">
				<h3 align="center">Material In Transit</h3>
					<?php
					$query2="
								SELECT 
								
								P.name as pname,
								A.product_id,
								sum(A.qty) as qty,
								A.unit_name,
								sum(A.package_no) as pkg,
								sum(A.total_amt) as amt
								
								FROM dispatch_details_warehous_stock as A 
								
								LEFT JOIN product as P ON P.product_id = A.product_id
							
								WHERE   A.save_in_stock = 0 
								GROUP BY A.product_id 
								ORDER BY P.name 
							";
					$res2=$this->Mymodel->query1($query2);
					//print_r($res2);
					if(!empty($res2))
					{
							?>		
								<table border="1" width="100%" style="font-size:16px;" >
									<tr style=" background-color:#34425A; color:white;">
										<th align="left">#</th>
										<th align="left">Product</th>
										<th align="right">Package</th>
										<th align="right">Qty</th>
										<th align="right">Unit</th>
										<th align="right">Amt.</th>
									</tr>
									<?php 
										$i=1;
										foreach($res2 as $r)
										{
											$qty = $r['qty'];
											//color 
											if($qty > 0){$color='white'; $font ='';}else{$color='#f25656'; $font = "font-weight:bold; color:white;"; }
											
										?>
										<tr style="background-color:<?php echo $color;?>; <?php echo $font;?>">
											<td align="left"><?php echo $i;?></td>
											<td align="left"><?php echo $r['pname'];?></td>
											<td align="right"><?php echo $pkg2[] = $r['pkg'];?></td>
											<td align="right"><?php echo $qty2[] = $r['qty'];?></td>
											<td align="right"><?php echo $r['unit_name'];?></td>
											<td align="right"><?php echo $amt2[] = $r['amt'];?></td>
										</tr>
										<?php
										$i++;
										}
									?>

									<tr>
										<td>#</td>
										<td style="font-weight:bold">Total</td>
										<td align="right"  style="font-weight:bold"><?php if(!empty($pkg2)) echo round(array_sum($pkg2)); ?></td>
										<td align="right"  style="font-weight:bold"><?php if(!empty($qty2)) echo round(array_sum($qty2)); ?></td>
										<td></td>
										<td align="right"  style="font-weight:bold"><?php if(!empty($amt2)) echo round(array_sum($amt2)); ?></td>
									</tr>
									
								</table>
					<?php
					}
					?>


					<h3 align="center">Short Material In Stock</h3>
					<?php
					$query2="
								SELECT 
								
								sum(A.recive_stock_level) as qty,
								A.product_id,A.product_grade_id,A.lotno,
								P.name as pname,P.economic,P.reorder,P.max_level,P.no_of_days,
								C.name as cname,C.category_id,
								U.name as uname
								
								FROM product_stock as A 
								
								LEFT JOIN product as P ON P.product_id = A.product_id
								LEFT JOIN category C ON C.category_id=A.category_id
								LEFT JOIN unit U ON U.unit_id=P.unit_id
								
								WHERE   
							";
					
					$where="  P.row_mat_puc='1' and P.repeated='1'     GROUP by A.product_id   ORDER by A.category_id,P.name ASC  ";	
					//$where="  P.row_mat_puc='1' and P.repeated='1'  and (A.category_id ='2' OR A.category_id ='13' OR A.category_id ='14')    GROUP by A.product_id   HAVING sum(A.recive_stock_level)<=P.economic ORDER by A.category_id,P.size ASC  ";	
			
					$query2.=" $where";
					$res2=$this->Mymodel->query1($query2);
					//print_r($res2);
					if(!empty($res2))
					{
							?>		
								<table border="1" width="100%" style="font-size:16px;" >
									<tr style=" background-color:#34425A; color:white;">
										<th align="left">#</th>
										<th align="left">Category</th>
										<th align="left">Product</th>
										<th align="right">Qty Req. Per Day</th>
										<th align="right">Min Level</th>
										<th align="right">No of Day's set for Min Level qty</th>
										<th align="right">Current Stock</th>
										<th align="right">Current Stock / No of Days</th>
										<th align="right">Short Percentage</th>
									</tr>
									<?php 
										$i=1;
										foreach($res2 as $r)
										{
											$per_res=round(($r['qty']*100)/$r['economic']);
											$qty = round($r['qty'],2);

											if($r['no_of_days']>0 and $qty>0){ $avg_per_day = round($r['economic']/$r['no_of_days']);   $day_rem = round($qty/$avg_per_day); }else { $avg_per_day='';$day_rem ='';}
											
											
											
											//color 
											if($per_res >= 100){$color='white';$font ='';}
											elseif($per_res < 100 and $per_res >= 50){$color='white';$font ='';}
											elseif($per_res < 50)
											{
												if($qty == 0){$color='white'; $font ='';}else{$color='#f25656'; $font = "font-weight:bold; color:white;"; }
											}
										?>
										<tr style="background-color:<?php echo $color;?>; <?php echo $font;?>">
											<td align="left"><?php echo $i;?></td>
											<td align="left"><?php echo $r['cname'];?></td>
											<td align="left"><?php echo $r['pname'];?></td>
											<td align="right"><?php echo $avg_per_day;?></td>
											<td align="right"><?php echo $r['economic'];?></td>
											<td align="right"><?php echo $r['no_of_days'];?></td>
											<td align="right"><?php echo $qty;?></td>
											<td align="right"><?php echo $day_rem;?></td>
											<td align="right"><?php echo $per_res;?>%</td>
										</tr>
										<?php
										$i++;
										}
									?>
								</table>
					<?php
					}
					?>
					
				</div> 



				<!-----end div---> 

				
				




				<!-----Footer--->
				<button class="btn btn-" style=" margin:10px;" onClick="printData1()">Print Table</button>
				<script>
				function printData1()
				{
					var data='<h2 align="center">Rahul Wire Ropes</h2>'
					
					var divToPrint=document.getElementById("printTable1");
					newWin= window.open("");
					newWin.document.write(data);
					newWin.document.write(divToPrint.outerHTML);
					newWin.print();
					newWin.close();
				}
				</script>

				<?php 
				/*
				}//if dept
				else
				{
					echo "No Data";
				}
				*/
				
	}//function close























	





}// close class

