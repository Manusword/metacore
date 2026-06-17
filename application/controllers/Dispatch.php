<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dispatch extends CI_Controller {

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



	
	//get all schedule list of this customer
	public function dispatch_get_po_no()
	{
		if(isset($_REQUEST['customer_id']))
		{
			$customer_id = $_REQUEST['customer_id'];
			$out1 = $this->Dispatchmodel->get_customer_schedule_list($customer_id,date('Y-m-01'),date('Y-m-31'));
			if(!empty($out1))
			{
				?>
				<option value="">Select</option>
				<?php
				foreach($out1 as $o)
				{
					?><option value="<?php echo $o['schedule_id'];?>"><?php echo $o['customer_po'];?></option><?php
				}
			}
			else
			{
				?><option value="">No Po Found</option><?php
			}//if(!empty($out1))
		}//if(isset($_REQUEST['str']))
	}//function close




	//get customer gts %
	public function dispatch_get_cust_gst()
	{
		if(isset($_REQUEST['customer_id']))
		{
			$customer_id = $_REQUEST['customer_id'];
			//tcs charge
			$out2 = $this->Customermodel->get_customer_with_id($customer_id);
			if(!empty($out2))
			{ 
				if($out2[0]['is_tcs'] == 1){ $tcs_per =  $this->Company->dispatch_entry_charge_apply_tcs_val();}else{$tcs_per =0;}
			}else{$tcs_per = 0;}

			//last bill gst %
			$out1 = $this->Dispatchmodel->get_customer_last_gst_per_with_id($customer_id);
			if(!empty($out1))
			{
				if($out1[0]['sgst_per']>0){$sgst=$out1[0]['sgst_per'];}else{$sgst='0';}
				if($out1[0]['cgst_per']>0){$cgst=$out1[0]['cgst_per'];}else{$cgst='0';}
				if($out1[0]['igst_per']>0){$igst=$out1[0]['igst_per'];}else{$igst='0';}
				echo $out1[0]['place_of_supply'].'~'.$sgst.'~'.$cgst.'~'.$igst.'~'.$tcs_per;
			}
			else
			{
				echo '~~~~'.$tcs_per;	
			}//if(!empty($out1))
			
		}//if(isset($_REQUEST['str']))
		
	}//function close



	//getting all product on this schedule and customer id
	public function dispatch_get_product()
	{
		if(isset($_REQUEST['schedule_id']))
		{
			$schedule_id = $_REQUEST['schedule_id'];
			$customer_id= $_REQUEST['customer_id'];
			
			$out1=$this->Dispatchmodel->get_customer_schedule_list_with_schedule_id($schedule_id,date('Y-m-01'),date('Y-m-31'));
			if(!empty($out1))
			{
				?><option value="">Select</option><?php
				foreach($out1 as $o)
				{
					$product_id = $o['product_id'];
					
					$grade = $this->Base->get_grade_name_from_id($o['product_grade']);
					$pro = $this->Productmodel->get_product_data_with_id($o['product_id']);

					//---------getting product name by custome 
					$rate = $this->Customermodel->get_customer_product_rate($customer_id,$product_id);
					if(!empty($rate) and !empty($rate[0]['custname'])){ $custname= ' "'.$rate[0]['custname'].'"';}else{ $custname='';}
					?>
						<option value="<?php echo $o['details_id'];?>">
							<?php echo $pro[0]['name'].' : '.$grade.' : '.$custname.', (Rate: '.$o['rate'].', Qty: '.$o['order_qty'].')';?>
						</option>
					<?php 
				}//foreach
				
			}//if(!empty($out1))
		}
	}//function close


	//getting all product on this schedule and customer id
	public function dispatch_get_product2()
	{
		if(isset($_REQUEST['customer_id']))
		{
			$fromDate = date('Y-m-01');
			//$fromDate = date('2025-08-01');
			//$toDate = date('2025-08-31');
		    $toDate = date('Y-m-t');
			
			$customer_id= $_REQUEST['customer_id'];
			$sch = $this->Dispatchmodel->get_customer_schedule_list($customer_id,$fromDate,$toDate);
			?><option value="" >Select Product</option><?php
			if(!empty($sch)){
				foreach($sch as $s){
					//getting all schedule data
					$schedule_id = $s['schedule_id'];
					$out1=$this->Dispatchmodel->get_customer_schedule_list_with_schedule_id($schedule_id,$fromDate,$toDate);
					if(!empty($out1))
					{
						?><option value="" disabled>Schedule No : <?php echo $s['customer_po'];?></option><?php
						foreach($out1 as $o)
						{
							$product_id = $o['product_id'];
							
							$grade = $this->Base->get_grade_name_from_id($o['product_grade']);
							$pro = $this->Productmodel->get_product_data_with_id($o['product_id']);

							//---------getting product name by custome 
							$rate = $this->Customermodel->get_customer_product_rate($customer_id,$product_id);
							if(!empty($rate) and !empty($rate[0]['custname'])){ $custname= ' "'.$rate[0]['custname'].'"';}else{ $custname='';}
							?>
								<option value="<?php echo $o['details_id'];?>">
									<?php echo $pro[0]['name'].' ('.$o['oil'].') : '.$grade.' : '.$custname.', (Rate: '.$o['rate'].', Qty: '.$o['order_qty'].')';?>
								</option>
							<?php 
						}//foreach
					}//if(!empty($out1))
				}//sch id
			}//sch
					
		}//customer_id
	}//function close




	//get all product details form schedule
	public function dispatch_get_product_details()
	{
	   	if(isset($_REQUEST['cust_sech_details_id']))
	   	{
			$cust_sech_details_id = $_REQUEST['cust_sech_details_id'];
			$customer_id = $_REQUEST['customer_id'];
			//$po_no = $_REQUEST['po_no'];
			$bill_type = $_REQUEST['bill_type'];
			$discount_offer = $_REQUEST['discount_offer'];
			
			//geting customer order details
			$out1=$this->Dispatchmodel->get_customer_schedule_details_data_with_details_id($cust_sech_details_id);
			if(!empty($out1))
			{
				$order_qty= $out1[0]['order_qty'];
				$send_qty=$out1[0]['send_qty'];
				$schedule_rate = $out1[0]['rate'];
				$product_id=$out1[0]['product_id'];
				$unit= $out1[0]['unit'];
				
				
				//geting HSN Code
				$out9 = $this->Dispatchmodel->get_last_dispatch_from_product_hsn($product_id);
				if(!empty($out9)){$hsn_code=$out9[0]['hsn'];}else{$hsn_code='72171010';}

				//geting unit Name of this customer
				//$out9 = $this->Dispatchmodel->get_last_dispatch_from_product_unit($customer_id,$product_id);
				//if(!empty($out9)){$unit_name = $out9[0]['unit_name'];}else{$unit_name = $this->Company->dispatch_entry_get_deafult_unit();}
				
				//---------getting product rate by customer 
				$rate = $this->Customermodel->get_customer_product_rate($customer_id,$product_id);
				if(!empty($rate))
				{
					//checking rate come form custmore rate table or schedule table
					if($this->Company->dispatch_entry_get_deafult_rate_come() == 1){$custname_rate = $rate;}else{ $custname_rate = $schedule_rate; }
				}else{ $custname_rate = $schedule_rate;}
	
				echo $order_qty.'~'.$send_qty.'~'.$custname_rate.'~'.$hsn_code.'~'.$unit;
	
			}else{ echo "No Customer Schedule Found";exit;}
	
		}//if(isset($_REQUEST['cust_sech_details_id']))
	
	}//function close



	




















	//------------------------------------------------------------------Schedule
	//new add_schedule
	public function add_schedule()
	{
		$result['grade'] = $this->Base->get_all_grade();
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Dispatchmodel->get_customer_schedule_data_with_id($id);
			$result['res3'] = $this->Dispatchmodel->get_customer_schedule_details_data_with_id($id);
		}
		$this->load->view('dispatch/schedule/entry',$result);
	}//function close


	
	//dispatch/scheule->schedule_list 
	public function schedule_list()
	{
		$result['grade'] = $this->Base->get_all_grade();
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		if(isset($_REQUEST['search1']))
		{
			$where = ""; 
			if(!empty($_REQUEST['customer'])){$customer=$_REQUEST['customer'];$where.=" and  A.customer_id='$customer'   ";}
			if(!empty($_REQUEST['type_of_bill'])){$type_of_bill=$_REQUEST['type_of_bill'];$where.=" and  A.type_of_bill ='$type_of_bill'   ";}
			if(!empty($_REQUEST['product'])){$product=$_REQUEST['product'];$where.=" and  B.product_id ='$product'   "; $result['product1'] =$product; }
			if(!empty($_REQUEST['oil'])){$oil=$_REQUEST['oil'];$where.=" and  B.oil ='$oil'   "; $result['oil1'] =$oil; }
			if(!empty($_REQUEST['po_no'])){$po_no=$_REQUEST['po_no'];$where.=" and  A.customer_po ='$po_no'   ";}
			if(!empty($_REQUEST['actual_month2'])){$actual_month2=$_REQUEST['actual_month2'];$where.=" and  A.actual_month ='$actual_month2'   ";}
			if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  B.product_grade ='$grade'   ";}
			if(!empty($_REQUEST['area_location'])){$area_location=$_REQUEST['area_location'];$where.=" and  C.area_location ='$area_location'   ";}
			if(!empty($_REQUEST['sales_person'])){$sales_person=$_REQUEST['sales_person'];$where.=" and  C.sales_person ='$sales_person'   ";}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and B.from_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" GROUP BY A.schedule_id   ORDER by actual_month,customer_po  ";
			$result['res2'] = $this->Dispatchmodel->schedule_serach_query($where);
			$this->load->view('dispatch/schedule/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$where = "  and A.type_of_bill='Tax Invoice' and B.from_date between '$search_date1' and '$search_date2' GROUP BY A.schedule_id   ORDER by actual_month,customer_po ASC  ";
			$result['res2'] = $this->Dispatchmodel->schedule_serach_query($where);
			$this->load->view('dispatch/schedule/show',$result);
		}
	}//function close
	

	




	//schedule save
	public function add_schedule_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		if(isset($_REQUEST['entry_date'])){$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date=date('Y-m-d');}
		if(isset($_REQUEST['po_date'])){$po_date = $this->Base->change_date_ymd($_REQUEST['po_date']);}else{$po_date=date('Y-m-d');}
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['customer'])){$customer=$_REQUEST['customer'];}else{$customer='';}
		if(isset($_REQUEST['po_no'])){$po_no=$_REQUEST['po_no'];}else{$po_no='';}
		if(isset($_REQUEST['actual_month'])){$actual_month=$_REQUEST['actual_month'];}else{$actual_month='';}
		if(isset($_REQUEST['supply'])){$supply=$_REQUEST['supply'];}else{$supply='';}
		if(isset($_REQUEST['type_of_bill'])){$type_of_bill=$_REQUEST['type_of_bill'];}else{$type_of_bill='';}
		if(isset($_REQUEST['discount_offer'])){$discount_offer=$_REQUEST['discount_offer'];}else{$discount_offer='';}
		if(isset($_REQUEST['comment'])){$comment=$_REQUEST['comment'];}else{$comment='';}
		
		//------------------row
		if(isset($_REQUEST['details_id'])){$details_id=explode('~',$_REQUEST['details_id']);}else{$details_id='';}
		if(isset($_REQUEST['goods'])){$goods=explode('~',$_REQUEST['goods']);$no_of_row=count($goods);}else{$goods='';$no_of_row=0;}
		if(isset($_REQUEST['rate'])){$rate=explode('~',$_REQUEST['rate']);}else{$rate='';}
		if(isset($_REQUEST['grade'])){$grade=explode('~',$_REQUEST['grade']);}else{$grade='';}
		if(isset($_REQUEST['order'])){$order=explode('~',$_REQUEST['order']);}else{$order='';}
		if(isset($_REQUEST['unit'])){$unit=explode('~',$_REQUEST['unit']);}else{$unit='';}
		if(isset($_REQUEST['forecast'])){$forecast=explode('~',$_REQUEST['forecast']);}else{$forecast='';}
		if(isset($_REQUEST['cost'])){$cost=explode('~',$_REQUEST['cost']);}else{$cost='';}
		if(isset($_REQUEST['fromdate'])){$fromdate=explode('~',$_REQUEST['fromdate']);}else{$fromdate='';}
		if(isset($_REQUEST['todate'])){$todate=explode('~',$_REQUEST['todate']);}else{$todate='';}
		if(isset($_REQUEST['oil'])){$oil=explode('~',$_REQUEST['oil']);}else{$oil='';}
		if(isset($_REQUEST['proremarks'])){$proremarks=explode('~',$_REQUEST['proremarks']);}else{$proremarks='';}
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['customer']))
		{
				$data=array(
								'schedule_save_date'=>"$entry_date",
								'customer_id'=>"$customer",
								'customer_po'=>"$po_no",
								'actual_month'=>"$actual_month",
								'customer_po_date'=>"$po_date",
								'type_of_bill'=>"$type_of_bill",
								'discount_offer'=>"$discount_offer",
								'remarks'=>"$comment",
							 	'stage'=>"0",
								'status'=>"Active",
								'supply'=>"$supply",
								'save_by'=>"$user_email",
								'save_date'=>"$today",
							);
				$new_id=$this->Mymodel->insertdata_withid('customer_schedule',$data);
				
				if($new_id>0)
				{
					for($i=0;$i<$no_of_row;$i++)
					{
						
						if($order[$i]>0)
						{
							if(isset($fromdate[$i])){$fromdate1 = $this->Base->change_date_ymd($fromdate[$i]);}else{$fromdate1 = date('Y-m-d');}
							if(isset($todate[$i])){$todate1 = $this->Base->change_date_ymd($todate[$i]);}else{$todate1 = date('Y-m-d');}
							$product_id2=$goods[$i];
							
							$data2=array();
							$data2=array(
											'schedule_id'=>"$new_id",
											'customer_id'=>"$customer",
											'product_id'=>"$product_id2",
											'rate'=>"$rate[$i]",
											'product_grade'=>"$grade[$i]",
											'forecast_qty'=>"$forecast[$i]",
											'order_qty'=>"$order[$i]",
											'unit'=>"$unit[$i]",
											'amt'=>"$cost[$i]",
											'from_date'=>"$fromdate1",
											'to_date'=>"$todate1",
											'oil'=>"$oil[$i]",
											'proremarks'=>"$proremarks[$i]",
											'stage'=>"0",
											'save_by'=>"$user_email",
											'save_date'=>"$today",
										);
							$this->Mymodel->insertdata('customer_schedule_details',$data2);
						
						}//amount
					}//for loop
					
				}//id
			/*
			//-----------------Mail
			if($type_of_bill=='Tax Invoice' and $supply==0)
			{
				//$this->Mailmodel->schedule_email($new_id);
			}
			*/
			echo "Save";
		}//insert
		//----------------------------------------------------------------------update
		elseif(!empty($_REQUEST['id']) and !empty($_REQUEST['customer']))
		{
			
			$data=array(
								'schedule_save_date'=>"$entry_date",
								'customer_id'=>"$customer",
								'customer_po'=>"$po_no",
								'actual_month'=>"$actual_month",
								'customer_po_date'=>"$po_date",
								'type_of_bill'=>"$type_of_bill",
								'discount_offer'=>"$discount_offer",
								'remarks'=>"$comment",
							 	'stage'=>"0",
								'sch_edit'=>"1",
								'status'=>"Active",
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
				//$new_id=$this->Mymodel->insertdata_withid('customer_schedule',$data);
				//print_r($data);
				$where=array('schedule_id'=>"$id");   
				$this->Mymodel->update('customer_schedule',$data,$where);		
				$new_id=$id;
				if($new_id>0)
				{
					for($i=0;$i<$no_of_row;$i++)
					{
						if($order[$i]>0)
						{
							if(isset($fromdate[$i])){$fromdate1 = $this->Base->change_date_ymd($fromdate[$i]);}else{$fromdate1 = date('Y-m-d');}
							if(isset($todate[$i])){$todate1 = $this->Base->change_date_ymd($todate[$i]);}else{$todate1 = date('Y-m-d');}
							$product_id2=$goods[$i];
							
							if($details_id[$i]>0)
							{
								$details_id1=$details_id[$i];
								$out = $this->Dispatchmodel->get_customer_schedule_details_data_with_id($details_id1);
								if(!empty($out[0]['send_qty']) and $out[0]['send_qty']>0){$send_qty = $out[0]['send_qty'];$send_qty = (int)$send_qty;}else{$send_qty = '';}
								if($send_qty>=$order[$i]){$stage='1';}else{$stage='0';}
								
								$data2=array();
								$data2=array(
												'schedule_id'=>"$new_id",
												'customer_id'=>"$customer",
												'product_id'=>"$product_id2",
												'product_grade'=>"$grade[$i]",
												'rate'=>"$rate[$i]",
												'forecast_qty'=>"$forecast[$i]",
												'order_qty'=>"$order[$i]",
												'unit'=>"$unit[$i]",
												'amt'=>"$cost[$i]",
												'from_date'=>"$fromdate1",
												'to_date'=>"$todate1",
												'oil'=>"$oil[$i]",
												'proremarks'=>"$proremarks[$i]",
												'stage'=>"$stage",
												'update_by'=>"$user_email",
												'update_date'=>"$today",
											);
								//$this->Mymodel->insertdata('customer_schedule_details',$data2);
								$where2=array('details_id'=>$details_id1);   
				 				$this->Mymodel->update('customer_schedule_details',$data2,$where2);
								
							}
							else
							{
								//new
								$data2=array();
								$data2=array(
												'schedule_id'=>"$new_id",
												'customer_id'=>"$customer",
												'product_id'=>"$product_id2",
												'product_grade'=>"$grade[$i]",
												'rate'=>"$rate[$i]",
												'forecast_qty'=>"$forecast[$i]",
												'order_qty'=>"$order[$i]",
												'unit'=>"$unit[$i]",
												'amt'=>"$cost[$i]",
												'from_date'=>"$fromdate1",
												'to_date'=>"$todate1",
												'oil'=>"$oil[$i]",
												'proremarks'=>"$proremarks[$i]",
												'stage'=>"0",
												'save_by'=>"$user_email",
												'save_date'=>"$today",
											);
								$this->Mymodel->insertdata('customer_schedule_details',$data2);
							}//$details_id[$i]>0
						}//order
					}//for loop
				}//id
				echo "Update";
		}//insert
		else
		{
			//exit
			echo "Not Save. Try Again. No Data Found.";
		}//exit
	}//function close















	//-----------------------------------------------------------------DISPATCH
	//new add_dispatch
	public function add_dispatch()
	{
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		if(strlen($this->uri->segment(3))>0)
		{
			$id = $this->uri->segment(3);
			$result['res2'] = $this->Dispatchmodel->get_customer_dispatch_data_with_id($id);
			$result['res3'] = $this->Dispatchmodel->get_customer_dispatch_details_data_with_id($id);
		}
		//getting next bill no
		//$result['bill_no']	=	$this->Seconddb_model->get_max_bill_no();
		$this->load->view('dispatch/dispatch/entry',$result);
	}//function close







	//dispatch/dispatch->dispatch_list group by customer
	public function dispatch_list4()
	{
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
			}
			else
			{
				$search_date1= date('Y-m-01');
				$search_date2= date('Y-m-t');
			}
			$result['search_date1'] = $search_date1;
			$result['search_date2'] = $search_date2;
			$result['res2'] = $this->Base->get_all_grade_sale_type1();
			$this->load->view('dispatch/dispatch/show_table4',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$result['search_date1'] = $search_date1;
			$result['search_date2'] = $search_date2;
			$result['res2'] = $this->Base->get_all_grade_sale_type1();
			$this->load->view('dispatch/dispatch/show4',$result);
		}
	}//function close






	//dispatch/dispatch->dispatch_list group by customer
	public function dispatch_list3()
	{
		if(isset($_REQUEST['search1']))
		{
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
			}
			else
			{
				$search_date1= date('Y-m-01');
				$search_date2= date('Y-m-t');
			}
			$result['state_wise'] = $this->Dispatchmodel->state_wise_sales_schedule($search_date1,$search_date2);
			$result['com_type_wise'] = $this->Dispatchmodel->company_type_wise_sales_schedule($search_date1,$search_date2);
			$result['person_wise'] = $this->Dispatchmodel->sales_person_wise_sales_from_schedule($search_date1,$search_date2);
			$result['product_wise'] = $this->Dispatchmodel->product_wise_sales_from_schedule($search_date1,$search_date2);
			$result['customer_wise1'] = $this->Dispatchmodel->customer_wise_sales_from_schedule($search_date1,$search_date2,'Manufacturer');
			$result['customer_wise2'] = $this->Dispatchmodel->customer_wise_sales_from_schedule($search_date1,$search_date2,'Trader');
			$result['grade_wise'] = $this->Dispatchmodel->grade_wise_sales_from_schedule($search_date1,$search_date2);
			$result['product_grade_wise'] = $this->Dispatchmodel->product_grade_wise_sales_from_schedule($search_date1,$search_date2);
			$result['grade_product_wise'] = $this->Dispatchmodel->grade_product_wise_sales_from_schedule($search_date1,$search_date2);
			$result['sscp_wise'] = $this->Dispatchmodel->sscp_wise_sales_from_schedule($search_date1,$search_date2);
			$this->load->view('dispatch/dispatch/show_table3',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$result['res2']['state_wise'] = $this->Dispatchmodel->state_wise_sales_schedule($search_date1,$search_date2);
			$result['res2']['com_type_wise'] = $this->Dispatchmodel->company_type_wise_sales_schedule($search_date1,$search_date2);
			$result['res2']['person_wise'] = $this->Dispatchmodel->sales_person_wise_sales_from_schedule($search_date1,$search_date2);
			$result['res2']['product_wise'] = $this->Dispatchmodel->product_wise_sales_from_schedule($search_date1,$search_date2);
			$result['res2']['customer_wise1'] = $this->Dispatchmodel->customer_wise_sales_from_schedule($search_date1,$search_date2,'Manufacturer');
			$result['res2']['customer_wise2'] = $this->Dispatchmodel->customer_wise_sales_from_schedule($search_date1,$search_date2,'Trader');
			$result['res2']['grade_wise'] = $this->Dispatchmodel->grade_wise_sales_from_schedule($search_date1,$search_date2);
			$result['res2']['product_grade_wise'] = $this->Dispatchmodel->product_grade_wise_sales_from_schedule($search_date1,$search_date2);
			$result['res2']['grade_product_wise'] = $this->Dispatchmodel->grade_product_wise_sales_from_schedule($search_date1,$search_date2);
			$result['res2']['sscp_wise'] = $this->Dispatchmodel->sscp_wise_sales_from_schedule($search_date1,$search_date2);
			$this->load->view('dispatch/dispatch/show3',$result);
		}
	}//function close











	//dispatch/dispatch->dispatch_list group by customer
	public function dispatch_list2()
	{
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		$result['grade'] = $this->Base->get_all_grade();
		if(isset($_REQUEST['search1']))
		{
			$where = ""; 
			//if(!empty($_REQUEST['grade'])){$grade=$_REQUEST['grade'];$where.=" and  B.dispatch_no='$grade'   ";}
			if(!empty($_REQUEST['customer'])){$customer=$_REQUEST['customer'];$where.=" and  A.customer_id ='$customer'   ";}
			if(!empty($_REQUEST['product'])){$product=$_REQUEST['product'];$where.=" and  B.product_id ='$product'   ";}else{$product='';}
			
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" and  A.type_of_bill='Tax Invoice' and A.is_it_cancel=0  GROUP BY A.customer_id,B.product_id ORDER by C.name  ";
			$result['product1'] = $product;
			$result['customer_hide'] = "No";
			$result['res2'] = $this->Dispatchmodel->dispatch_serach_group_customer_query($where);
			$this->load->view('dispatch/dispatch/show_table2',$result);
		}
		else
		{
			$search_date1= date('Y-m-01');
			$search_date2= date('Y-m-t');
			$result['customer_hide'] = "Yes";
			$where = " and A.entry_date between '$search_date1' and '$search_date2'  and  A.type_of_bill='Tax Invoice' and A.is_it_cancel=0  GROUP BY B.product_id  ORDER by P.name    ";
			$result['res2'] = $this->Dispatchmodel->dispatch_serach_group_customer_query($where);
			$this->load->view('dispatch/dispatch/show2',$result);
		}
	}//function close


	//dispatch/dispatch->dispatch_list 
	public function dispatch_list()
	{
		$result['customer'] = $this->Customermodel->get_all_active_customer();
		if(isset($_REQUEST['search1']))
		{
			$where = ""; 
			if(!empty($_REQUEST['no'])){$no=$_REQUEST['no'];$where.=" and  A.dispatch_no='$no'   ";}
			if(!empty($_REQUEST['customer'])){$customer=$_REQUEST['customer'];$where.=" and  A.customer_id ='$customer'   ";}
			if(!empty($_REQUEST['product'])){$product=$_REQUEST['product'];$where.=" and  B.product_id ='$product'   ";}else{$product='';}
			if(!empty($_REQUEST['type_of_bill'])){$type_of_bill=$_REQUEST['type_of_bill'];$where.=" and  A.type_of_bill ='$type_of_bill'   ";}
			if(!empty($_REQUEST['cancel_status'])){
				$cancel_status = $_REQUEST['cancel_status'];
				if($cancel_status == "All"){

				}
				elseif($cancel_status != 1){
					$where.="  and A.is_it_cancel=0  ";
				}
				else{
					$where.="  and A.is_it_cancel='$cancel_status'  ";
				}
			}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				$where.="  and A.entry_date between '$search_date1' and '$search_date2'  ";
			}
			$where.=" GROUP BY A.dispatch_id  ORDER by A.dispatch_no DESC ";
			$result['product1'] = $product;
			$result['res2'] = $this->Dispatchmodel->dispatch_serach_query($where);
			$this->load->view('dispatch/dispatch/show_table',$result);
		}
		else
		{
			$search_date1= date('Y-m-d');
			//$search_date2= date('Y-m-d');
			$where = " and A.entry_date='$search_date1' and  A.type_of_bill='Tax Invoice'  GROUP BY A.dispatch_id  ORDER by A.dispatch_no DESC   ";
			$result['res2'] = $this->Dispatchmodel->dispatch_serach_query($where);
			$this->load->view('dispatch/dispatch/show',$result);
		}
	}//function close



	//--------dispatch save start
	public function add_dispatch_save()
	{
		$today=date("Y-m-d H:i:s");
		$user_email=$this->session->userdata('login_emp_id');
		
		///geting fin year
		$fin_year = $this->Company->get_fin_year();
		$bill_no_data = $this->Company->get_extra_dispatch_qty_per();
		if(!empty($bill_no_data[0]['details6'])){ $per_send = $bill_no_data[0]['details6'];}else{$per_send = 1;}
		
		if(isset($_REQUEST['entry_date'])){$entry_date = $this->Base->change_date_ymd($_REQUEST['entry_date']);}else{$entry_date=date('Y-m-d');}
		if(!empty($_REQUEST['invoice_no'])){$vr_no=$_REQUEST['invoice_no'];}else{$vr_no = $this->Dispatchmodel->get_next_bill_no($entry_date);} 
		if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}else{$id='';}
		if(isset($_REQUEST['old_grand_total_amt'])){$old_grand_total_amt=$_REQUEST['old_grand_total_amt'];}else{$old_grand_total_amt='';}
		if(isset($_REQUEST['type_of_bill'])){$type_of_bill=$_REQUEST['type_of_bill'];}else{$type_of_bill='';}
		if(isset($_REQUEST['customer_id'])){$customer_id=$_REQUEST['customer_id'];}else{$customer_id='';}
		if(isset($_REQUEST['po_no'])){$po_no=$_REQUEST['po_no'];}else{$po_no='';}
		if(isset($_REQUEST['transport_mode'])){$transport_mode=$_REQUEST['transport_mode'];}else{$transport_mode='';}
		if(isset($_REQUEST['vehicle_no'])){$vehicle_no=$_REQUEST['vehicle_no'];}else{$vehicle_no='';}
		if(isset($_REQUEST['place_of_supply'])){$place_of_supply=$_REQUEST['place_of_supply'];}else{$place_of_supply='';}
		if(isset($_REQUEST['discount_offer'])){$discount_offer=$_REQUEST['discount_offer'];}else{$discount_offer='';}
		if(isset($_REQUEST['isexport'])){$isexport=$_REQUEST['isexport'];}else{$isexport='';}//------------------------------Rem save into database
		if(isset($_REQUEST['tod_per'])){$tod_per=$_REQUEST['tod_per'];}else{$tod_per='';}
		if(isset($_REQUEST['tod_cost_val'])){$tod_cost_val=$_REQUEST['tod_cost_val'];}else{$tod_cost_val='';}
		if(isset($_REQUEST['amortisation_cost_per'])){$amortisation_cost_per=$_REQUEST['amortisation_cost_per'];}else{$amortisation_cost_per='';}
		if(isset($_REQUEST['amortisation_cost_val'])){$amortisation_cost_val=$_REQUEST['amortisation_cost_val'];}else{$amortisation_cost_val='';}
		//------------------row
		if(isset($_REQUEST['dispatch_details_id'])){$dispatch_details_id=explode('~',$_REQUEST['dispatch_details_id']);}else{$dispatch_details_id='';}
		if(isset($_REQUEST['oldgoodsid'])){$oldgoodsid=explode('~',$_REQUEST['oldgoodsid']);}else{$oldgoodsid='';}
		if(isset($_REQUEST['oldqty'])){$oldqty=explode('~',$_REQUEST['oldqty']);}else{$oldqty='';}
		if(isset($_REQUEST['oldamt'])){$oldamt=explode('~',$_REQUEST['oldamt']);}else{$oldamt='';}
		if(isset($_REQUEST['goods'])){$goods=explode('~',$_REQUEST['goods']);}else{$goods='';}
		if(isset($_REQUEST['amount_weight'])){$net=explode('~',$_REQUEST['amount_weight']);}else{$net='';}
		if(isset($_REQUEST['unitname'])){$unitname=explode('~',$_REQUEST['unitname']);}else{$unitname='';}
		if(isset($_REQUEST['hsn'])){$hsn=explode('~',$_REQUEST['hsn']);}else{$hsn='';}
		if(isset($_REQUEST['package'])){$package=explode('~',$_REQUEST['package']);}else{$package='';}
		if(isset($_REQUEST['price'])){$price=explode('~',$_REQUEST['price']);}else{$price='';}
		if(isset($_REQUEST['total_amount'])){$total_amount=explode('~',$_REQUEST['total_amount']);$no_of_row=count($total_amount);}else{$total_amount='';$no_of_row='';}
		//----row end
		if(isset($_REQUEST['total_old'])){$total_before_dis=$_REQUEST['total_old'];}else{$total_before_dis='';}
		if(isset($_REQUEST['other_discount_per'])){$other_discount_per=$_REQUEST['other_discount_per'];}else{$other_discount_per='';}
		if(isset($_REQUEST['discount'])){$discount=$_REQUEST['discount'];}else{$discount='';}
		if(isset($_REQUEST['taxable_amt'])){$total=$_REQUEST['taxable_amt'];}else{$total='';}
		if(isset($_REQUEST['scheme'])){$scheme=$_REQUEST['scheme'];}else{$scheme='';}
		if(isset($_REQUEST['ffc_amt'])){$ffc_amt=$_REQUEST['ffc_amt'];}else{$ffc_amt='';}
		if(isset($_REQUEST['laber_charge'])){$laber_charge=$_REQUEST['laber_charge'];}else{$laber_charge='';}
		if(isset($_REQUEST['sgst_per'])){$sgst_per=$_REQUEST['sgst_per'];}else{$sgst_per='';}
		if(isset($_REQUEST['cgst_per'])){$cgst_per=$_REQUEST['cgst_per'];}else{$cgst_per='';}
		if(isset($_REQUEST['igst_per'])){$igst_per=$_REQUEST['igst_per'];}else{$igst_per='';}
		if(isset($_REQUEST['sgst_val'])){$sgst_val=$_REQUEST['sgst_val'];}else{$sgst_val='';}
		if(isset($_REQUEST['cgst_val'])){$cgst_val=$_REQUEST['cgst_val'];}else{$cgst_val='';}
		if(isset($_REQUEST['igst_val'])){$igst_val=$_REQUEST['igst_val'];}else{$igst_val='';}
		if(isset($_REQUEST['tds_per'])){$tds_per=$_REQUEST['tds_per'];}else{$tds_per='';}
		if(isset($_REQUEST['tds_val'])){$tds_val=$_REQUEST['tds_val'];}else{$tds_val='';}
		if(isset($_REQUEST['roundoff'])){$roundoff=$_REQUEST['roundoff'];}else{$roundoff='';}
		if(isset($_REQUEST['grandtotal'])){$grandtotal=$_REQUEST['grandtotal'];}else{$grandtotal='';}
		if(isset($_REQUEST['grandtotal2'])){$grandtotal2=$_REQUEST['grandtotal2'];}else{$grandtotal2='';}
		if(isset($_REQUEST['remarks'])){$remarks=$_REQUEST['remarks'];}else{$remarks='';}
		
		
		
		//----------------------------------------------------------------------insert
		if(empty($_REQUEST['id']) and !empty($_REQUEST['customer_id']))
		{ 
			//-----------------------checking invoice alredy exits or not
			$where=" fin_year='$fin_year' and dispatch_no='$vr_no' ";
			$out2=$this->Mymodel->select_where('dispatch',$where);
			if(!empty($out2))
			{
				echo "Invoice No $vr_no Already exits. ";
				exit;
			}//if(!empty($out2))	
				
			//-------------------------------------Checking dispatch qty not more than 150% of order qty
			for($i=0;$i<$no_of_row;$i++)
			{
				if($total_amount[$i]>0)
				{
					$out=array();
					$customer_schedule_details_id = $goods[$i];
					$out = $this->Dispatchmodel->get_customer_schedule_details_data_with_details_id($customer_schedule_details_id);
					$product_id=$out[0]['product_id'];
					$order_qty=$out[0]['order_qty'];
					$already_send=$out[0]['send_qty'];
					$new_qty=round((int)$out[0]['send_qty']+(int)$net[$i]);
					
					$per=round(($order_qty*$per_send)/100);
					$per_qty=round($per+$order_qty);
					
					if($new_qty<=$per_qty)
					{
						//ok
					}
					else
					{
						$current_send=$net[$i];
						$out30 = $this->Productmodel->get_product_data_with_id($product_id);
						$product_name=$out30[0]['name'];
						$per_send2=$per_send+100;
						echo "$product_name ORDER QTY $order_qty, ALREADY SEND $already_send, NOW YOU ARE SENDING $current_send. ITS MORE THAN $per_send2%. PLEASE SUBTRACT IN QTY";
						exit;
					}
					
				}//total_amount
			}//for
			//-------------------------------------Checking dispatch qty not more than 120% of order qty
				
			
			$data=array(
							'entry_date'=>"$entry_date",
							'type_of_bill'=>"$type_of_bill",
							'dispatch_no'=>"$vr_no",
							'customer_id'=>"$customer_id",
							'customer_schedule_id'=>"$po_no",
							'transport_mode'=>"$transport_mode",
							'vehicle_no'=>"$vehicle_no",
							'place_of_supply'=>"$place_of_supply",
							'discount_offer'=>"$discount_offer",
							'isexport'=>"$isexport",
							'total_before_dis'=>"$total_before_dis",
							'other_discount_per'=>"$other_discount_per",
							'discount'=>"$discount",
							'tod_per'=>"$tod_per",
							'tod_cost_val'=>"$tod_cost_val",
							'amortisation_cost_per'=>"$amortisation_cost_per",
							'amortisation_cost_val'=>"$amortisation_cost_val",
							'total'=>"$total",
							'scheme'=>"$scheme",
							'ffc_amt'=>"$ffc_amt",
							'laber_charge'=>"$laber_charge",
							'sgst_per'=>"$sgst_per",
							'sgst_val'=>"$sgst_val",
							'cgst_per'=>"$cgst_per",
							'cgst_val'=>"$cgst_val",
							'igst_per'=>"$igst_per",
							'igst_val'=>"$igst_val",
							'tds_per'=>"$tds_per",
							'tds_val'=>"$tds_val",
							'roundoff'=>"$roundoff",
							'grandtotal'=>"$grandtotal",
							'grandtotal2'=>"$grandtotal2",
							'remarks'=>"$remarks",
							'fin_year'=>"$fin_year",
							'save_by'=>"$user_email",
							'save_date'=>"$today",
						);
			$new_id=$this->Mymodel->insertdata_withid('dispatch',$data);

				
			if($new_id>0)
			{
				for($i=0;$i<$no_of_row;$i++)
				{
					if($total_amount[$i]>0)
					{
						$out=array();
						$customer_schedule_details_id=$goods[$i];
						$out = $this->Dispatchmodel->get_customer_schedule_details_data_with_details_id($customer_schedule_details_id);
						$product_id=$out[0]['product_id'];
						$po_no=$out[0]['schedule_id'];
						
						
						
						$order_qty=$out[0]['order_qty'];
						$new_qty=round($out[0]['send_qty'],3)+round($net[$i],3);
						$new_amt=round($out[0]['send_amt'],3)+round($total_amount[$i],3);
						if($new_qty>=$order_qty){$stage='1';}else{$stage='0';}
						
						$data2=array();
						$data2=array(
										'dispatch_id'=>"$new_id",
										'customer_schedule_id'=>"$po_no",
										'customer_schedule_details_id'=>"$customer_schedule_details_id",
										'product_id'=>"$product_id",
										'qty'=>"$net[$i]",
										'unit_name'=>"$unitname[$i]",
										'hsn'=>"$hsn[$i]",
										'package_no'=>"$package[$i]",
										'rate'=>"$price[$i]",
										'total_amt'=>"$total_amount[$i]",
										'save_by'=>"$user_email",
										'save_date'=>"$today",
									);
						$dispatch_details_id=$this->Mymodel->insertdata_withid('dispatch_details',$data2);
						
						
						//customer_schedule update
						$data4=array('send_qty'=>"$new_qty",'send_amt'=>"$new_amt",'stage'=>"$stage");
						$where4=array('details_id'=>"$customer_schedule_details_id");   
						$this->Mymodel->update('customer_schedule_details',$data4,$where4);

						/*
						//finish good update hoga
						$data5=array(
										'assigned_status'=>"2",
										'dispatch_id'=>"$new_id",
										'dispatch_details_id'=>"$dispatch_details_id"
									);
						$where5=array(
										'assigned_status'=>"1",
										'schedule_id'=>"$po_no",
										'sech_details_id'=>"$customer_schedule_details_id"
									);
						//$where2=array('fg_production_id'=>"$fg_production_id");   
						$this->Mymodel->update('fg_production',$data5,$where5);	
						*/
						
						//--- sub update stock and balance
						//$this->Stock->min_stock_form_invoice($product_id,$net[$i],$total_amount[$i],'Dispatch','',$today,'','');
						
					}//$total_amount
					
				}//for loop
			}//id
			
			
			//-----------------Mail
			//if($type_of_bill=='Tax Invoice'){ $this->Dispatchmodel->mail_dispatch($new_id,'New');}
			echo "Save";
		}//insert
		

	
		
		
		//----------------------------------------------------------------------update
		if(!empty($_REQUEST['id']) and !empty($_REQUEST['customer_id']))
		{
				
				//-------------------------------------Checking dispatch qty not more than 150% of order qty
				for($i=0;$i<$no_of_row;$i++)
				{
					if($total_amount[$i]>0)
					{
						$out=array();
						$customer_schedule_details_id=$goods[$i];
						$out = $this->Dispatchmodel->get_customer_schedule_details_data_with_details_id($customer_schedule_details_id);
						
						$product_id=$out[0]['product_id'];
						$order_qty=$out[0]['order_qty'];
						$already_send=$out[0]['send_qty'];
						$now_send_qty=round($out[0]['send_qty'],3)-round($oldqty[$i],3);
						$new_qty=$now_send_qty+$net[$i];
						
						$per=round(($order_qty*$per_send)/100);
						$per_qty=round($per+$order_qty);
						if($new_qty<=$per_qty)
						{
							//ok
						}
						else
						{
							$current_send=$net[$i];
							$out30 = $this->Productmodel->get_product_data_with_id($product_id);
							$product_name=$out30[0]['name'];
							$per_send2=$per_send+100;
							echo  "$product_name ORDER QTY $order_qty, ALREADY SEND $already_send, NOW YOU ARE SENDING $current_send. ITS MORE THAN $per_send2%. PLEASE SUBTRACT IN QTY";
							exit;
						}
				
					}//total_amount
				}//for
				//-------------------------------------Checking dispatch qty not more than 120% of order qty
				
				
				
				$data=array(
								'entry_date'=>"$entry_date",
								'type_of_bill'=>"$type_of_bill",
								'dispatch_no'=>"$vr_no",
								'customer_id'=>"$customer_id",
								'customer_schedule_id'=>"",
								'transport_mode'=>"$transport_mode",
								'vehicle_no'=>"$vehicle_no",
								'place_of_supply'=>"$place_of_supply",
								'discount_offer'=>"$discount_offer",
								'isexport'=>"$isexport",
								'total_before_dis'=>"$total_before_dis",
								'other_discount_per'=>"$other_discount_per",
								'discount'=>"$discount",
								'tod_per'=>"$tod_per",
								'tod_cost_val'=>"$tod_cost_val",
								'amortisation_cost_per'=>"$amortisation_cost_per",
								'amortisation_cost_val'=>"$amortisation_cost_val",
								'total'=>"$total",
								'scheme'=>"$scheme",
								'ffc_amt'=>"$ffc_amt",
								'laber_charge'=>"$laber_charge",
								'sgst_per'=>"$sgst_per",
								'sgst_val'=>"$sgst_val",
								'cgst_per'=>"$cgst_per",
								'cgst_val'=>"$cgst_val",
								'igst_per'=>"$igst_per",
								'igst_val'=>"$igst_val",
								'tds_per'=>"$tds_per",
								'tds_val'=>"$tds_val",
								'roundoff'=>"$roundoff",
								'grandtotal'=>"$grandtotal",
								'grandtotal2'=>"$grandtotal2",
								'remarks'=>"$remarks",
								'update_by'=>"$user_email",
								'update_date'=>"$today",
							);
				// $new_id=$this->Mymodel->insertdata_withid('dispatch',$data);
				 $where=array('dispatch_id'=>"$id");   
				 $this->Mymodel->update('dispatch',$data,$where);
				 $new_id=$id;

				if($new_id>0)
				{
					for($i=0;$i<$no_of_row;$i++)
					{
						if($total_amount[$i]>0)
						{
							if($dispatch_details_id[$i]>0)
							{
								//update
								$out=array();
								$customer_schedule_details_id=$oldgoodsid[$i];
								$out = $this->Dispatchmodel->get_customer_schedule_details_data_with_details_id($customer_schedule_details_id);
								if(!empty($out))
								{
									$product_id=$out[0]['product_id'];
									$order_qty=$out[0]['order_qty'];
									$new_qty=round($out[0]['send_qty'],3)-round($oldqty[$i],3);
									$new_amt=round($out[0]['send_amt'],3)-round($oldamt[$i],3);
									if($new_qty>=$order_qty){$stage='1';}else{$stage='0';}
								}
								else
								{
									$new_qty=$oldqty[$i];
									$new_amt=$oldamt[$i];
									$stage='0';
								}
								//customer_schedule update
								$data4=array('send_qty'=>"$new_qty",'send_amt'=>"$new_amt",'stage'=>"$stage");
								$where4=array('details_id'=>"$customer_schedule_details_id");   
								$this->Mymodel->update('customer_schedule_details',$data4,$where4);

								//--- sub update stock and balance
								//$this->Stock->stock_form_invoice($product_id,$oldqty[$i],$oldamt[$i],'Dispatch','',$today,'','');
								
								
								//----------------------------------------------------------------------Update row							
								$out=array();
								$customer_schedule_details_id=$goods[$i];
								$out = $this->Dispatchmodel->get_customer_schedule_details_data_with_details_id($customer_schedule_details_id);
								$product_id=$out[0]['product_id'];
								$po_no=$out[0]['schedule_id'];

								$order_qty=$out[0]['order_qty'];
								$new_qty=round($out[0]['send_qty'],3)+round($net[$i],3);
								$new_amt=round($out[0]['send_amt'],3)+round($total_amount[$i],3);
								if($new_qty>=$order_qty){$stage='1';}else{$stage='0';}
								
								$data2=array();
								$data2=array(
												'dispatch_id'=>"$new_id",
												'customer_schedule_id'=>"$po_no",
												'customer_schedule_details_id'=>"$customer_schedule_details_id",
												'product_id'=>"$product_id",
												'qty'=>"$net[$i]",
												'unit_name'=>"$unitname[$i]",
												'hsn'=>"$hsn[$i]",
												'package_no'=>"$package[$i]",
												'rate'=>"$price[$i]",
												'total_amt'=>"$total_amount[$i]",
												'update_by'=>"$user_email",
												'update_date'=>"$today",
											);
								//$dispatch_details_id=$this->Mymodel->insertdata_withid('dispatch_details',$data2);
								$where2=array('dispatch_details_id'=>$dispatch_details_id[$i]);   
				 				$this->Mymodel->update('dispatch_details',$data2,$where2);
								
								//customer_schedule update
								$data4=array('send_qty'=>"$new_qty",'send_amt'=>"$new_amt",'stage'=>"$stage");
								$where4=array('details_id'=>"$customer_schedule_details_id");   
								$this->Mymodel->update('customer_schedule_details',$data4,$where4);
								
								
								//--- addding update stock and balance
								//$this->Stock->min_stock_form_invoice($product_id,$net[$i],$total_amount[$i],'Dispatch','',$today,'','');
							}
							else
							{
								
								//---------------------new row entry							
								$out=array();
								$customer_schedule_details_id=$goods[$i];
								$out = $this->Dispatchmodel->get_customer_schedule_details_data_with_details_id($customer_schedule_details_id);
								$product_id=$out[0]['product_id'];
								$po_no=$out[0]['schedule_id'];

								
								$order_qty=$out[0]['order_qty'];
								$new_qty=round($out[0]['send_qty'],2)+round($net[$i],2);
								$new_amt=round($out[0]['send_amt'],2)+round($total_amount[$i],2);
								if($new_qty>=$order_qty){$stage='1';}else{$stage='0';}
								
								$data2=array();
								$data2=array(
												'dispatch_id'=>"$new_id",
												'customer_schedule_id'=>"$po_no",
												'customer_schedule_details_id'=>"$customer_schedule_details_id",
												'product_id'=>"$product_id",
												'qty'=>"$net[$i]",
												'unit_name'=>"$unitname[$i]",
												'hsn'=>"$hsn[$i]",
												'package_no'=>"$package[$i]",
												'rate'=>"$price[$i]",
												'total_amt'=>"$total_amount[$i]",
												'update_by'=>"$user_email",
												'update_date'=>"$today",
											);
								$dispatch_details_id=$this->Mymodel->insertdata_withid('dispatch_details',$data2);
								
								//customer_schedule update
								$data4=array('send_qty'=>"$new_qty",'send_amt'=>"$new_amt",'stage'=>"$stage");
								$where4=array('details_id'=>"$customer_schedule_details_id");   
								$this->Mymodel->update('customer_schedule_details',$data4,$where4);
								
								//--- sub update stock and balance
								//$this->Stock->min_stock_form_invoice($product_id,$net[$i],$total_amount[$i],'Dispatch','',$today,'','');
							}
						}//$total_amount
						
					}//for loop
				}//id
			
			//-----------------Mail
			//if($type_of_bill=='Tax Invoice'){ $this->Dispatchmodel->mail_dispatch($new_id,'Update');}
			echo "Update";
		}//insert

		
	}//function close
	//--------dispatch save end






	//list4 search
	public function supply_grade_wise()
	{
		if(isset($_REQUEST['search1']))
		{
			if(isset($_REQUEST['sales_person'])){ $sales_person = $_REQUEST['sales_person'];}else{$sales_person='No';}
			if(!empty($_REQUEST['search_date1']) and !empty($_REQUEST['search_date2']))
			{
				$search_date1 = $this->Base->change_date_ymd($_REQUEST['search_date1']);
				$search_date2 = $this->Base->change_date_ymd($_REQUEST['search_date2']);
				
				if($sales_person == 'Yes'){
					$this->Dispatchmodel->get_sch_vs_sup_grade_sales_person($search_date1,$search_date2);
				}
				else{
					$this->Dispatchmodel->get_sch_vs_sup_grade($search_date1,$search_date2);
				}
			}
		}
		else
		{
			$result = array();
			$this->load->view('dispatch/schedule/show2',$result);
		}//search
	}//function close


	///disparch me schedule list -> show_table 
	public function fun_save_schedule_remarks2()
	{
	   if(isset($_REQUEST['id_no']))
	   {
		   	echo $id_no=$_REQUEST['id_no'];
			$val=$_REQUEST['val'];
		   
		   	$data3=array('plan_remarks'=>"$val");   
		   	$where3=array('details_id'=>"$id_no");   
		  	$this->Mymodel->update('customer_schedule_details',$data3,$where3);
		   
	   }//if
	}//function close

	 ///disparch me schedule list -> show_table 
	 public function popup_product_his_fun()
	 {
		if(isset($_REQUEST['id_no']))
		{
			$details_id=$_REQUEST['id_no'];
			$where3=" details_id='$details_id' ";
			$res=$this->Mymodel->select_where('customer_schedule_details',$where3);
			
			$id_no=$res[0]['product_id'];
			$customer_id=$res[0]['customer_id'];
			$order_qty=(int)$res[0]['order_qty'];
			$send_qty=(int)$res[0]['send_qty'];
			$rem = round($order_qty-$send_qty);
			$from_date=$res[0]['from_date'];
		    $test = new DateTime($from_date);
            $m= date_format($test, 'm');
			$m2= date_format($test, 'M');
			$y= date_format($test, 'Y');

			$last_day_of_month = date_format($test, 't');
			
			$where3=" product_id='$id_no' ";
			$out2=$this->Mymodel->select_where('product',$where3);

			$where3=" id='$customer_id' ";
			$out3=$this->Mymodel->select_where('customer',$where3);
			$cname = $out3[0]['name'];
			
			$sum_qty1=array();
			$sum_qty2=array();
			$sum_qty3=array();
			?>
			<input type="hidden" id="customer_schedule_details_id" value="<?php echo $details_id;?>">
            <h2 align="center"><?php echo $cname;?></h2>
			<h3 align="center"><?php echo $out2[0]['name'];?> In <?php echo "$m2 $y";?></h3>
			<h4 align="center"> In <?php echo "$m2 $y";?></h4>
			<h3 align="center"> In <?php echo "Order Qty : $order_qty, Send Qty : $send_qty, Rem. : $rem  ";?></h3>
            <table border="1" width="100%" class="table-hover">
            	<tr>
                	<th>Date</th>
                    
                    <th>Total Dispatch to all customer</th>
                    <th>Dispatch to this customer</th>
					
                </tr>
           		
					<?php
                    for($i=1;$i<=$last_day_of_month;$i++)
                    {
                        $test = new DateTime("$i-$m-$y");
                        $new_date= date_format($test, 'Y-m-d');
                         
						
						 
						//total dispatch
						$query2="
							SELECT 
							sum(qty) as qty
							FROM dispatch_details as A
							LEFT JOIN dispatch as B ON B.dispatch_id = A.dispatch_id
							WHERE A.product_id='$id_no' and entry_date = '$new_date'
						";
						$out3=$this->Mymodel->query1($query2);
						$dis_total=round($out3[0]['qty']);
						
						//dispatch customer
						$query2="
							SELECT 
							sum(qty) as qty
							FROM dispatch_details as A
							LEFT JOIN dispatch as B ON B.dispatch_id = A.dispatch_id
							WHERE A.product_id='$id_no' and B.customer_id='$customer_id' and B.entry_date = '$new_date'
						";
						$out3=$this->Mymodel->query1($query2);
						$dis=round($out3[0]['qty']);

						//plan
						/*
						<th>Enter / View Plan</th>
						$column_name = "p$i";
						$query="SELECT $column_name as plan FROM customer_schedule_dispatch_plan where  customer_schedule_details_id = '$details_id' ";
                        $rope_qty=$this->Mymodel->query1($query);
						if(!empty($rope_qty))
						{
							$plan_qty=round($rope_qty[0]['plan']);
						}
						else
						{
							$plan_qty=0;
						}
						<td><input type='tel' class="form-control plan_qty" style="height:20px" value="<?php if(!empty($plan_qty))echo $sum_qty4[]=$plan_qty;?>" ></td>
						*/
						
						 
						 ?>
                         <tr>
                         		<td><?php echo $i;?></td>
                                
                                <td><?php if(!empty($dis_total))echo $sum_qty2[]=$dis_total;?></td>
                                <td><?php if(!empty($dis))echo $sum_qty3[]=$dis;?></td>
								
                         </tr>
                         <?php
                    }//for
					?>
                    
                    	 <tr>
                         		<td>Total</td>
                                
                                <td><b><?php if(!empty($sum_qty2)){ echo array_sum($sum_qty2);}?></b></td>
                                <td><b><?php if(!empty($sum_qty3)){ echo array_sum($sum_qty3);}?></b></td>
								<td><b><?php if(!empty($sum_qty4)){ echo array_sum($sum_qty4);}?></b></td>
                         </tr>
                    
            </table>
			
			
			<?php
		}//if
	 }//function close






	
	
	
	

}//close class
